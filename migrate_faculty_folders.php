<?php
require_once __DIR__ . '/includes/db.php';
$pdo = getDBConnection();

$baseUploadDir = __DIR__ . '/uploads/faculty/';

// 1. Department subfolders list
$depts = ['ce', 'it', 'me', 'civil', 'ee', 'ec', 'ae', 'am', 'sh'];
foreach ($depts as $d) {
    $dir = $baseUploadDir . $d;
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Created folder: uploads/faculty/{$d}/\n";
    }
}

// 2. Fetch all faculty members from database
$stmt = $pdo->query("SELECT id, dept_code, name, photo_url FROM faculties");
$faculties = $stmt->fetchAll(PDO::FETCH_ASSOC);

$updated = 0;
$moved = 0;

foreach ($faculties as $fac) {
    $id = $fac['id'];
    $dept = strtolower(trim($fac['dept_code']));
    $oldPath = trim($fac['photo_url']);

    if (empty($oldPath)) continue;

    // Check if it starts with uploads/faculty/ and is not already in a dept folder
    if (strpos($oldPath, 'uploads/faculty/') === 0) {
        $filename = basename($oldPath);
        $currentFull = __DIR__ . '/' . $oldPath;

        // Target path
        $targetRel = "uploads/faculty/{$dept}/{$filename}";
        $targetFull = __DIR__ . '/' . $targetRel;

        if (file_exists($currentFull) && is_file($currentFull)) {
            // Move file
            if (rename($currentFull, $targetFull)) {
                $moved++;
                echo "Moved file: {$filename} -> uploads/faculty/{$dept}/\n";
            }
        }

        // Update DB record
        $updateStmt = $pdo->prepare("UPDATE faculties SET photo_url = ? WHERE id = ?");
        $updateStmt->execute([$targetRel, $id]);
        $updated++;
    }
}

// 3. Any remaining loose files in uploads/faculty/ that look like CE / IT / etc.
$remainingFiles = glob($baseUploadDir . '*.*');
foreach ($remainingFiles as $rf) {
    if (is_file($rf)) {
        $fn = basename($rf);
        // If file starts with ce_ or CE_, move to ce/
        if (preg_match('/^(ce_|CE_)/i', $fn) || in_array($fn, ['AKD.jpg', 'JBB.jpg', 'JMS.jpg', 'MKR.jpg', 'MMG.jpg', 'PRG.jpg', 'RJP.jpg', 'SGP.jpg'])) {
            $dest = $baseUploadDir . 'ce/' . $fn;
            rename($rf, $dest);
            echo "Moved unlinked CE file {$fn} -> ce/\n";
        }
    }
}

echo "\nMigration Complete! Updated DB: $updated records, Moved: $moved files.\n";

