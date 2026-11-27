<?php
/**
 * GEC MODASA - Visitor Analytics Database Migration
 * Creates tables for unique visitor counting and per-page analytics.
 *
 * Reversible rollback (CLI only):
 *   php database/migrate_visitor_analytics.php --rollback
 */

require_once __DIR__ . '/../includes/db.php';

$pdo = getDBConnection();
if (!$pdo) {
    die("Database connection failed\n");
}

$isCli = (php_sapi_name() === 'cli');
$isRollback = $isCli && isset($argv) && in_array('--rollback', $argv, true);

if ($isRollback) {
    try {
        $pdo->exec("DROP TABLE IF EXISTS `page_visitor_logs`");
        $pdo->exec("DROP TABLE IF EXISTS `page_analytics`");
        $pdo->exec("DROP TABLE IF EXISTS `site_visitors`");
        $pdo->exec("DROP TABLE IF EXISTS `site_visitor_stats`");
        echo "VISITOR_ANALYTICS_ROLLBACK_SUCCESSFUL\n";
    } catch (Exception $e) {
        echo "ROLLBACK ERROR: " . $e->getMessage() . "\n";
        exit(1);
    }
    exit(0);
}

try {
    // 1. Global site summary counters (single row for O(1) footer lookup)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `site_visitor_stats` (
        `id` TINYINT UNSIGNED NOT NULL PRIMARY KEY,
        `total_unique_visitors` BIGINT UNSIGNED NOT NULL DEFAULT 0,
        `total_page_views` BIGINT UNSIGNED NOT NULL DEFAULT 0,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $pdo->exec("INSERT IGNORE INTO `site_visitor_stats` (`id`, `total_unique_visitors`, `total_page_views`) VALUES (1, 0, 0)");

    // 2. Global unique devices/visitors (salted hashes only, no raw IP PII)
    $pdo->exec("CREATE TABLE IF NOT EXISTS `site_visitors` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `visitor_token_hash` CHAR(64) NOT NULL UNIQUE,
        `fingerprint_hash` CHAR(64) NOT NULL,
        `device_type` VARCHAR(30) NOT NULL DEFAULT 'Desktop',
        `browser` VARCHAR(60) NOT NULL DEFAULT 'Other',
        `os` VARCHAR(60) NOT NULL DEFAULT 'Other',
        `first_visit_at` DATETIME NOT NULL,
        `last_visit_at` DATETIME NOT NULL,
        `visit_count` INT UNSIGNED NOT NULL DEFAULT 1,
        INDEX `idx_fp_last` (`fingerprint_hash`, `last_visit_at`),
        INDEX `idx_first_visit` (`first_visit_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    // 3. Per-page aggregated overall metrics
    $pdo->exec("CREATE TABLE IF NOT EXISTS `page_analytics` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `page_path` VARCHAR(255) NOT NULL UNIQUE,
        `page_title` VARCHAR(255) NOT NULL DEFAULT 'GEC Modasa',
        `unique_visitors` BIGINT UNSIGNED NOT NULL DEFAULT 0,
        `total_views` BIGINT UNSIGNED NOT NULL DEFAULT 0,
        `last_visited_at` DATETIME NOT NULL,
        INDEX `idx_unique_desc` (`unique_visitors`),
        INDEX `idx_views_desc` (`total_views`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    // 4. Per-page separate unique visitor mapping
    $pdo->exec("CREATE TABLE IF NOT EXISTS `page_visitor_logs` (
        `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `page_id` INT UNSIGNED NOT NULL,
        `visitor_id` BIGINT UNSIGNED NOT NULL,
        `first_visited_at` DATETIME NOT NULL,
        `last_visited_at` DATETIME NOT NULL,
        `hit_count` INT UNSIGNED NOT NULL DEFAULT 1,
        UNIQUE KEY `uq_page_visitor` (`page_id`, `visitor_id`),
        INDEX `idx_page_last` (`page_id`, `last_visited_at`),
        CONSTRAINT `fk_pvl_page` FOREIGN KEY (`page_id`) REFERENCES `page_analytics` (`id`) ON DELETE CASCADE,
        CONSTRAINT `fk_pvl_visitor` FOREIGN KEY (`visitor_id`) REFERENCES `site_visitors` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    echo "VISITOR_ANALYTICS_MIGRATION_SUCCESSFUL\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
