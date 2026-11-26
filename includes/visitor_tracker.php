<?php
/**
 * GEC MODASA - Privacy-Safe Unique Visitor & Page Analytics Tracker
 * Hybrid deduplication: 5-year HttpOnly/SameSite cookie + 24h salted IP/UA fallback + bot filter.
 */

require_once __DIR__ . '/db.php';

/**
 * Determine whether the incoming request is from an automated bot, non-GET action, or asset/admin path.
 */
function gecmShouldSkipVisitorTracking(): bool
{
    if (php_sapi_name() === 'cli') {
        return true;
    }

    if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
        return true;
    }

    if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest') {
        return true;
    }

    $accept = strtolower($_SERVER['HTTP_ACCEPT'] ?? '');
    if ($accept !== '' && strpos($accept, 'application/json') === 0) {
        return true;
    }

    $ua = trim($_SERVER['HTTP_USER_AGENT'] ?? '');
    if ($ua === '') {
        return true;
    }

    $botPattern = '/(bot|crawl|spider|slurp|mediapartners|facebookexternalhit|bingpreview|whatsapp|telegrambot|discordbot|linkedinbot|curl|wget|python|postman|httpclient|lighthouse|pagespeed|gtmetrix|headless|phantomjs|selenium|puppeteer)/i';
    if (preg_match($botPattern, $ua)) {
        return true;
    }

    $rawUri = strtolower((string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
    if (preg_match('#/(admin|dept-admin|fac-admin|api|database|includes|uploads|assets)(/|$)#i', $rawUri)) {
        return true;
    }

    if (preg_match('#\.(css|js|png|jpg|jpeg|gif|webp|svg|ico|woff|woff2|ttf|pdf|xml|txt|map)$#i', $rawUri)) {
        return true;
    }

    return false;
}

/**
 * Detect application base path prefix dynamically (e.g. '/GECM' on localhost, '' on production root).
 */
function gecmGetAppBasePrefix(): string
{
    $docRootRaw = trim((string)($_SERVER['DOCUMENT_ROOT'] ?? ''));
    if ($docRootRaw === '') {
        return '';
    }
    $docRoot = realpath($docRootRaw);
    $appRoot = realpath(dirname(__DIR__));
    if ($docRoot === false || $appRoot === false) {
        return '';
    }

    $docRootNorm = rtrim(str_replace('\\', '/', $docRoot), '/');
    $appRootNorm = rtrim(str_replace('\\', '/', $appRoot), '/');

    if (stripos($appRootNorm, $docRootNorm) === 0) {
        $rel = substr($appRootNorm, strlen($docRootNorm));
        return '/' . ltrim($rel, '/');
    }

    return '';
}

/**
 * Normalize request URI into a canonical page path so duplicate URL forms share one analytics row.
 */
function gecmNormalizePagePath(?string $requestUri = null): string
{
    $uri = $requestUri ?? ($_SERVER['REQUEST_URI'] ?? '/');
    $parsedPath = (string) (parse_url($uri, PHP_URL_PATH) ?: '/');
    $parsedPath = preg_replace('#/+#', '/', $parsedPath);

    $basePrefix = gecmGetAppBasePrefix();
    if ($basePrefix !== '' && $basePrefix !== '/' && stripos($parsedPath, $basePrefix) === 0) {
        $parsedPath = substr($parsedPath, strlen($basePrefix));
    }

    $parsedPath = '/' . ltrim($parsedPath, '/');
    $parsedPath = preg_replace('#/index\.php$#i', '/', $parsedPath);
    $parsedPath = preg_replace('#\.php$#i', '', $parsedPath);
    $parsedPath = preg_replace('#/index$#i', '/', $parsedPath);

    if ($parsedPath !== '/') {
        $parsedPath = rtrim($parsedPath, '/');
        if ($parsedPath === '') {
            $parsedPath = '/';
        }
    }

    $queryStr = (string) (parse_url($uri, PHP_URL_QUERY) ?: '');
    if ($queryStr !== '') {
        parse_str($queryStr, $queryParams);
        $allowedKeys = ['category', 'c', 'dept'];
        $cleanParams = [];
        foreach ($allowedKeys as $key) {
            if (isset($queryParams[$key]) && is_string($queryParams[$key])) {
                $val = trim($queryParams[$key]);
                if ($val !== '' && strlen($val) <= 60) {
                    $cleanParams[$key] = $val;
                }
            }
        }
        if (!empty($cleanParams)) {
            $parsedPath .= '?' . http_build_query($cleanParams);
        }
    }

    return substr($parsedPath, 0, 255);
}

/**
 * Clean a page title for concise display in the admin analytics table.
 */
function gecmCleanPageTitle(string $rawTitle): string
{
    $title = trim(strip_tags($rawTitle));
    $title = preg_replace('/\s*\|\s*Government Engineering College, Modasa.*$/i', '', $title);
    $title = preg_replace('/\s*\|\s*GEC Modasa.*$/i', '', $title);
    $title = trim($title);
    if ($title === '') {
        $title = 'GEC Modasa';
    }
    return substr($title, 0, 255);
}

/**
 * Extract safe device type, browser, and OS labels from a User-Agent string.
 */
function gecmParseUserAgent(string $ua): array
{
    $deviceType = 'Desktop';
    if (preg_match('/(ipad|tablet|playbook|silk)|(android(?!.*mobile))/i', $ua)) {
        $deviceType = 'Tablet';
    } elseif (preg_match('/(mobile|iphone|ipod|android.*mobile|blackberry|iemobile|opera mini)/i', $ua)) {
        $deviceType = 'Mobile';
    }

    $os = 'Other';
    if (preg_match('/android/i', $ua)) {
        $os = 'Android';
    } elseif (preg_match('/iphone|ipad|ipod/i', $ua)) {
        $os = 'iOS';
    } elseif (preg_match('/windows/i', $ua)) {
        $os = 'Windows';
    } elseif (preg_match('/mac os x|macintosh/i', $ua)) {
        $os = 'macOS';
    } elseif (preg_match('/linux/i', $ua)) {
        $os = 'Linux';
    }

    $browser = 'Other';
    if (preg_match('/edg\//i', $ua)) {
        $browser = 'Edge';
    } elseif (preg_match('/opr\/|opera/i', $ua)) {
        $browser = 'Opera';
    } elseif (preg_match('/chrome|crios/i', $ua)) {
        $browser = 'Chrome';
    } elseif (preg_match('/firefox|fxios/i', $ua)) {
        $browser = 'Firefox';
    } elseif (preg_match('/safari/i', $ua)) {
        $browser = 'Safari';
    }

    return [
        'device_type' => $deviceType,
        'browser'     => $browser,
        'os'          => $os
    ];
}

/**
 * Compute salted SHA-256 fingerprint hash without persisting raw client IP addresses.
 */
function gecmComputeVisitorFingerprint(string $ua): string
{
    $ipCandidates = [
        $_SERVER['HTTP_CF_CONNECTING_IP'] ?? '',
        explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '')[0] ?? '',
        $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'
    ];

    $clientIp = '0.0.0.0';
    foreach ($ipCandidates as $candidate) {
        $candidate = trim($candidate);
        if ($candidate !== '' && filter_var($candidate, FILTER_VALIDATE_IP)) {
            $clientIp = $candidate;
            break;
        }
    }

    $salt = hash('sha256', DB_HOST . '|' . DB_NAME . '|' . __DIR__ . '|GECM_VISITOR_SALT_V1');
    return hash_hmac('sha256', $clientIp . '|' . $ua, $salt);
}

/**
 * Persist an HttpOnly anonymous visitor cookie for 5 years.
 */
function gecmSetVisitorCookie(string $token): void
{
    if (headers_sent()) {
        return;
    }

    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || ((int)($_SERVER['SERVER_PORT'] ?? 80) === 443);

    setcookie('gecm_vid', $token, [
        'expires'  => time() + (5 * 365 * 86400),
        'path'     => '/',
        'secure'   => $isSecure,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    $_COOKIE['gecm_vid'] = $token;
}

/**
 * Resolve existing unique visitor ID or create a new unique visitor record atomically.
 */
function gecmResolveOrCreateVisitor(PDO $pdo, string $ua): int
{
    $rawCookie = trim((string)($_COOKIE['gecm_vid'] ?? ''));
    if ($rawCookie !== '' && preg_match('/^[a-f0-9]{32}$/', $rawCookie)) {
        $tokenHash = hash('sha256', $rawCookie);
        $stmtFind = $pdo->prepare("SELECT id FROM site_visitors WHERE visitor_token_hash = ? LIMIT 1");
        $stmtFind->execute([$tokenHash]);
        $existingId = $stmtFind->fetchColumn();

        if ($existingId !== false) {
            $stmtTouch = $pdo->prepare("UPDATE site_visitors SET last_visit_at = NOW(), visit_count = visit_count + 1 WHERE id = ?");
            $stmtTouch->execute([(int)$existingId]);
            return (int)$existingId;
        }
    }

    $fingerprintHash = gecmComputeVisitorFingerprint($ua);
    $stmtFp = $pdo->prepare(
        "SELECT id FROM site_visitors WHERE fingerprint_hash = ? AND last_visit_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR) ORDER BY id DESC LIMIT 1"
    );
    $stmtFp->execute([$fingerprintHash]);
    $recentId = $stmtFp->fetchColumn();

    if ($recentId !== false) {
        $stmtTouch = $pdo->prepare("UPDATE site_visitors SET last_visit_at = NOW(), visit_count = visit_count + 1 WHERE id = ?");
        $stmtTouch->execute([(int)$recentId]);
        return (int)$recentId;
    }

    // Genuine first-time unique visitor
    $newToken = bin2hex(random_bytes(16));
    $newTokenHash = hash('sha256', $newToken);
    $uaInfo = gecmParseUserAgent($ua);

    $pdo->beginTransaction();
    try {
        $stmtIns = $pdo->prepare(
            "INSERT INTO site_visitors (visitor_token_hash, fingerprint_hash, device_type, browser, os, first_visit_at, last_visit_at, visit_count)
             VALUES (?, ?, ?, ?, ?, NOW(), NOW(), 1)"
        );
        $stmtIns->execute([
            $newTokenHash,
            $fingerprintHash,
            $uaInfo['device_type'],
            $uaInfo['browser'],
            $uaInfo['os']
        ]);
        $visitorId = (int)$pdo->lastInsertId();

        $pdo->exec("INSERT IGNORE INTO site_visitor_stats (id, total_unique_visitors, total_page_views) VALUES (1, 0, 0)");
        $pdo->exec("UPDATE site_visitor_stats SET total_unique_visitors = total_unique_visitors + 1 WHERE id = 1");

        $pdo->commit();
        gecmSetVisitorCookie($newToken);
        return $visitorId;
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        throw $e;
    }
}

/**
 * Record per-page unique visit and view counts atomically.
 */
function gecmRecordPageVisit(PDO $pdo, int $visitorId, string $pagePath, string $pageTitle): void
{
    // Upsert canonical page row
    $stmtPage = $pdo->prepare(
        "INSERT INTO page_analytics (page_path, page_title, unique_visitors, total_views, last_visited_at)
         VALUES (?, ?, 0, 1, NOW())
         ON DUPLICATE KEY UPDATE
            total_views = total_views + 1,
            page_title = IF(VALUES(page_title) != '', VALUES(page_title), page_title),
            last_visited_at = NOW()"
    );
    $stmtPage->execute([$pagePath, $pageTitle]);

    $stmtPageId = $pdo->prepare("SELECT id FROM page_analytics WHERE page_path = ? LIMIT 1");
    $stmtPageId->execute([$pagePath]);
    $pageId = (int)$stmtPageId->fetchColumn();
    if ($pageId <= 0) {
        return;
    }

    // Track per-page visitor uniqueness: rowCount() === 1 means brand-new visitor for this page
    $stmtMap = $pdo->prepare(
        "INSERT INTO page_visitor_logs (page_id, visitor_id, first_visited_at, last_visited_at, hit_count)
         VALUES (?, ?, NOW(), NOW(), 1)
         ON DUPLICATE KEY UPDATE
            hit_count = hit_count + 1,
            last_visited_at = NOW()"
    );
    $stmtMap->execute([$pageId, $visitorId]);

    if ($stmtMap->rowCount() === 1) {
        $stmtIncUnique = $pdo->prepare("UPDATE page_analytics SET unique_visitors = unique_visitors + 1 WHERE id = ?");
        $stmtIncUnique->execute([$pageId]);
    }

    $pdo->exec("UPDATE site_visitor_stats SET total_page_views = total_page_views + 1 WHERE id = 1");
}

/**
 * Main entry point invoked from public pages (includes/header.php) before HTML output.
 */
function trackUniqueVisitorVisit(string $rawPageTitle = 'GEC Modasa'): void
{
    static $alreadyTrackedThisRequest = false;
    if ($alreadyTrackedThisRequest || gecmShouldSkipVisitorTracking()) {
        return;
    }
    $alreadyTrackedThisRequest = true;

    $pdo = getDBConnection();
    if (!$pdo) {
        return;
    }

    try {
        $ua = trim($_SERVER['HTTP_USER_AGENT'] ?? '');
        $pagePath = gecmNormalizePagePath();
        $pageTitle = gecmCleanPageTitle($rawPageTitle);

        $visitorId = gecmResolveOrCreateVisitor($pdo, $ua);
        if ($visitorId > 0) {
            gecmRecordPageVisit($pdo, $visitorId, $pagePath, $pageTitle);
        }
    } catch (Throwable $e) {
        error_log("Visitor tracking error: " . $e->getMessage());
    }
}

/**
 * Fetch global unique visitor and page view totals for footer & dashboard display.
 */
function getSiteVisitorSummary(?PDO $pdo = null): array
{
    $conn = $pdo ?? getDBConnection();
    if (!$conn) {
        return ['total_unique_visitors' => 0, 'total_page_views' => 0];
    }

    try {
        $row = $conn->query("SELECT total_unique_visitors, total_page_views FROM site_visitor_stats WHERE id = 1 LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return [
                'total_unique_visitors' => (int)$row['total_unique_visitors'],
                'total_page_views'      => (int)$row['total_page_views']
            ];
        }
    } catch (Throwable $e) {
        error_log("Visitor summary error: " . $e->getMessage());
    }

    return ['total_unique_visitors' => 0, 'total_page_views' => 0];
}
