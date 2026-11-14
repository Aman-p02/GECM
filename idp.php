<?php
require_once __DIR__ . '/includes/db.php';

if ($pdo) {
    $stmt = $pdo->query("SELECT file_path FROM idp_documents WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
    $doc = $stmt ? $stmt->fetch() : null;
    if ($doc && !empty($doc['file_path'])) {
        $filePath = ltrim($doc['file_path'], '/');
        if (file_exists(__DIR__ . '/' . $filePath)) {
            header("Location: " . $filePath);
            exit;
        }
    }
}
exit;
