<?php
/**
 * GEC MODASA - Application Cache Helper (Cache-Aside + Stale Fallback)
 *
 * Read-heavy college pages cache database responses locally in storage/cache/.
 * Automatically invalidates affected cache keys when admins mutate content,
 * and serves stale cache gracefully if MySQL is temporarily unavailable.
 */

if (!defined('GECM_CACHE_DIR')) {
    define('GECM_CACHE_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'cache');
}

/**
 * Ensure storage/cache directory exists and is blocked from direct web access.
 */
function gecmEnsureCacheDir(): bool {
    $storageDir = dirname(GECM_CACHE_DIR);
    if (!is_dir(GECM_CACHE_DIR)) {
        if (!@mkdir(GECM_CACHE_DIR, 0755, true) && !is_dir(GECM_CACHE_DIR)) {
            return false;
        }
    }

    $htaccessPath = $storageDir . DIRECTORY_SEPARATOR . '.htaccess';
    if (!file_exists($htaccessPath)) {
        @file_put_contents(
            $htaccessPath,
            "<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\n    Order allow,deny\n    Deny from all\n</IfModule>\n"
        );
    }

    $indexPath = GECM_CACHE_DIR . DIRECTORY_SEPARATOR . 'index.php';
    if (!file_exists($indexPath)) {
        @file_put_contents($indexPath, "<?php http_response_code(403); exit;\n");
    }

    if (!is_dir(GECM_CACHE_DIR)) {
        return false;
    }

    // On Windows NTFS/ACLs, PHP's is_writable() on directories can return false negatives;
    // verify actual file write capability once per request.
    static $canWrite = null;
    if ($canWrite === null) {
        $canWrite = @is_writable(GECM_CACHE_DIR);
        if (!$canWrite) {
            $probe = GECM_CACHE_DIR . DIRECTORY_SEPARATOR . '.write_probe';
            if (@file_put_contents($probe, '1') !== false) {
                @unlink($probe);
                $canWrite = true;
            }
        }
    }
    return $canWrite;
}

/**
 * Sanitize cache key to a safe filesystem name.
 */
function gecmCacheFilePath(string $key): string {
    $safe = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $key);
    $safe = trim($safe, '._-');
    if ($safe === '') {
        $safe = 'default';
    }
    return GECM_CACHE_DIR . DIRECTORY_SEPARATOR . $safe . '.json';
}

/**
 * Atomically write a cache payload to disk.
 */
function gecmWriteCacheFile(string $path, array $envelope): void {
    $json = json_encode($envelope, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return;
    }

    $dir = dirname($path);
    $tmp = @tempnam($dir, 'tmp_');
    if ($tmp !== false) {
        if (@file_put_contents($tmp, $json, LOCK_EX) !== false) {
            if (@rename($tmp, $path)) {
                return;
            }
        }
        @unlink($tmp);
    }
    @file_put_contents($path, $json, LOCK_EX);
}

/**
 * Read cached data using Cache-Aside with stale-fallback on loader failure.
 *
 * Loader contract: return null if the data source failed/is offline (so stale cache
 * can be served), or return the fetched payload (including [] if legitimately empty).
 */
function gecmCacheRemember(string $key, int $ttlSeconds, callable $loader, ?string &$status = null) {
    $dirReady = gecmEnsureCacheDir();
    $path = gecmCacheFilePath($key);
    $staleEnvelope = null;

    if ($dirReady && file_exists($path)) {
        $raw = @file_get_contents($path);
        if ($raw !== false) {
            $decoded = json_decode($raw, true);
            if (is_array($decoded) && array_key_exists('data', $decoded)) {
                $staleEnvelope = $decoded;
                if (isset($decoded['expires_at']) && time() < (int)$decoded['expires_at']) {
                    $status = 'HIT';
                    return $decoded['data'];
                }
            }
        }
    }

    $fresh = null;
    try {
        $fresh = $loader();
    } catch (Throwable $e) {
        error_log("gecmCacheRemember loader error [{$key}]: " . $e->getMessage());
        $fresh = null;
    }

    if ($fresh !== null) {
        if ($dirReady) {
            $now = time();
            gecmWriteCacheFile($path, [
                'key'        => $key,
                'created_at' => $now,
                'expires_at' => $now + max(1, $ttlSeconds),
                'data'       => $fresh
            ]);
        }
        $status = 'MISS';
        return $fresh;
    }

    if ($staleEnvelope !== null) {
        $status = 'STALE_FALLBACK';
        return $staleEnvelope['data'];
    }

    $status = 'EMPTY';
    return null;
}

/**
 * Invalidate all cache files whose key starts with the given prefix.
 */
function gecmCacheInvalidate(string $prefix): int {
    if (!is_dir(GECM_CACHE_DIR)) {
        return 0;
    }
    $safePrefix = trim(preg_replace('/[^a-zA-Z0-9_.-]/', '_', $prefix), '._-');
    if ($safePrefix === '') {
        return 0;
    }
    $files = @glob(GECM_CACHE_DIR . DIRECTORY_SEPARATOR . $safePrefix . '*.json');
    if (!$files) {
        return 0;
    }
    $removed = 0;
    foreach ($files as $file) {
        if (is_file($file) && @unlink($file)) {
            $removed++;
        }
    }
    return $removed;
}

/**
 * Purge every cached JSON entry in storage/cache/.
 */
function gecmCacheClearAll(): int {
    if (!is_dir(GECM_CACHE_DIR)) {
        return 0;
    }
    $files = @glob(GECM_CACHE_DIR . DIRECTORY_SEPARATOR . '*.json');
    if (!$files) {
        return 0;
    }
    $removed = 0;
    foreach ($files as $file) {
        if (is_file($file) && @unlink($file)) {
            $removed++;
        }
    }
    return $removed;
}

/**
 * Collect runtime statistics for Super Admin Cache Monitor.
 */
function gecmCacheStats(): array {
    $writable = gecmEnsureCacheDir();
    $files = $writable ? (@glob(GECM_CACHE_DIR . DIRECTORY_SEPARATOR . '*.json') ?: []) : [];

    $entries = [];
    $totalBytes = 0;
    $now = time();

    foreach ($files as $file) {
        if (!is_file($file)) {
            continue;
        }
        $size = (int)@filesize($file);
        $totalBytes += $size;
        $raw = @file_get_contents($file);
        $decoded = $raw ? json_decode($raw, true) : null;
        $createdAt = (int)($decoded['created_at'] ?? @filemtime($file));
        $expiresAt = (int)($decoded['expires_at'] ?? 0);

        $entries[] = [
            'key'        => $decoded['key'] ?? basename($file, '.json'),
            'size_bytes' => $size,
            'created_at' => $createdAt,
            'expires_at' => $expiresAt,
            'is_expired' => ($expiresAt > 0 && $now >= $expiresAt)
        ];
    }

    usort($entries, function ($a, $b) {
        return $b['created_at'] <=> $a['created_at'];
    });

    return [
        'writable'    => $writable,
        'count'       => count($entries),
        'total_bytes' => $totalBytes,
        'entries'     => $entries
    ];
}
