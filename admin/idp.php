<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage Institutional Development Plan (IDP)";
$current_page = 'idp';

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: idp.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    // Upload New or Replace Existing IDP PDF (Preserves original PDF file name)
    if ($action === 'upload_idp') {
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['pdf_file'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if ($ext !== 'pdf') {
                setFlashMessage('danger', 'Only PDF documents (.pdf) are allowed.');
                header('Location: idp.php');
                exit;
            }

            if ($file['size'] > 25 * 1024 * 1024) {
                setFlashMessage('danger', 'PDF file size exceeds maximum limit of 25MB.');
                header('Location: idp.php');
                exit;
            }

            // Check and remove previous PDF file from disk
            $stmtOld = $pdo->query("SELECT id, file_path FROM idp_documents WHERE is_active = 1 LIMIT 1");
            $oldDoc = $stmtOld ? $stmtOld->fetch() : null;
            if ($oldDoc && !empty($oldDoc['file_path'])) {
                $realOld = realpath(__DIR__ . '/../' . $oldDoc['file_path']);
                if ($realOld && file_exists($realOld)) {
                    @unlink($realOld);
                }
            }

            $targetDir = realpath(__DIR__ . '/../uploads/idp');
            if (!$targetDir) {
                $targetDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'idp';
            }
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Preserve original filename (sanitized safely for URL and filesystem)
            $rawBase = pathinfo($file['name'], PATHINFO_FILENAME);
            $cleanBase = preg_replace('/[^a-zA-Z0-9_\-\.\(\)\s]/', '_', $rawBase);
            $cleanBase = trim($cleanBase);
            if (empty($cleanBase)) {
                $cleanBase = 'Institutional_Development_Plan_IDP';
            }
            $targetFilename = $cleanBase . '.pdf';
            $targetFile = $targetDir . DIRECTORY_SEPARATOR . $targetFilename;

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                // Remove dummy titles like '(anonymous)' injected by iLovePDF / compressors
                $pdfRaw = @file_get_contents($targetFile);
                if ($pdfRaw) {
                    $dummyTitles = ['/Title (\(anonymous\))', '/Title (anonymous)', '/Title (unspecified)', '/Title (untitled)', '/Title (Untitled)'];
                    $cleanNeeded = false;
                    foreach ($dummyTitles as $dt) {
                        if (strpos($pdfRaw, $dt) !== false) {
                            $pdfRaw = str_replace($dt, str_pad('/Title ()', strlen($dt), ' ', STR_PAD_RIGHT), $pdfRaw);
                            $cleanNeeded = true;
                        }
                    }
                    if ($cleanNeeded) {
                        @file_put_contents($targetFile, $pdfRaw);
                    }
                }

                $filePath = 'uploads/idp/' . $targetFilename;

                // Format file size
                $bytes = $file['size'];
                if ($bytes >= 1048576) {
                    $fileSize = number_format($bytes / 1048576, 1) . ' MB';
                } elseif ($bytes >= 1024) {
                    $fileSize = number_format($bytes / 1024, 0) . ' KB';
                } else {
                    $fileSize = $bytes . ' B';
                }

                $fileName = $rawBase;

                // Mark any previous entries inactive
                $pdo->exec("UPDATE idp_documents SET is_active = 0");

                $stmt = $pdo->prepare("INSERT INTO idp_documents (file_path, file_size, file_name, is_active) VALUES (?, ?, ?, 1)");
                $stmt->execute([$filePath, $fileSize, $fileName]);

                setFlashMessage('success', 'IDP PDF document uploaded successfully!');
            } else {
                setFlashMessage('danger', 'Could not save PDF file to server.');
            }
        } else {
            setFlashMessage('danger', 'Please choose a valid PDF file to upload.');
        }
        header('Location: idp.php');
        exit;

    } elseif ($action === 'delete_idp') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("SELECT file_path FROM idp_documents WHERE id = ?");
            $stmt->execute([$id]);
            $doc = $stmt->fetch();
            if ($doc && !empty($doc['file_path'])) {
                $realFile = realpath(__DIR__ . '/../' . $doc['file_path']);
                if ($realFile && file_exists($realFile)) {
                    @unlink($realFile);
                }
            }
            $pdo->prepare("DELETE FROM idp_documents WHERE id = ?")->execute([$id]);
            setFlashMessage('success', 'IDP PDF document has been removed successfully.');
        }
        header('Location: idp.php');
        exit;
    }
}

// Fetch current active IDP document
$activeIdp = null;
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM idp_documents WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
    $activeIdp = $stmt ? $stmt->fetch() : null;
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 28px 24px;">

    <!-- Top Info Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 16px; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="font-size: 18px; font-weight: 700; color: #0c3b6d; margin: 0 0 4px 0;">Institutional Development Plan (IDP) PDF</h2>
            <p style="font-size: 13.5px; color: #64748b; margin: 0;">Upload or replace the single official IDP PDF. When visitors click IDP on the website, this PDF will open directly.</p>
        </div>
        <?php if ($activeIdp && !empty($activeIdp['file_path'])): ?>
            <a href="../<?= htmlspecialchars($activeIdp['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px; font-size: 13px; font-weight: 600;">
                <i class="fas fa-external-link-alt"></i> Open Live PDF
            </a>
        <?php endif; ?>
    </div>

    <!-- 1. Upload / Replace PDF Box (Top) -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; margin-bottom: 28px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-cloud-upload-alt" style="color: #009dff;"></i>
            <?= $activeIdp ? 'Replace with New IDP PDF' : 'Upload IDP PDF Document' ?>
        </h3>

        <form action="idp.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="upload_idp">

            <div class="form-group" style="margin-bottom: 18px;">
                <label class="form-label" style="font-weight: 600; color: #334155; margin-bottom: 6px;">
                    Select PDF Document from Computer <span style="color: #ef4444;">*</span>
                </label>
                <input type="file" name="pdf_file" class="form-control" accept=".pdf" required style="padding: 9px 12px; font-size: 13.5px; background: #ffffff;">
                <div style="font-size: 12px; color: #64748b; margin-top: 6px;">
                    <i class="fas fa-info-circle"></i> Only PDF files are allowed. Maximum file size: 25 MB.
                    <?php if ($activeIdp): ?>
                        <span style="color: #ea580c; font-weight: 600; margin-left: 6px;">Uploading a new PDF will automatically replace the existing one and keep its original filename.</span>
                    <?php endif; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="background: #009dff; border-color: #009dff; padding: 10px 24px; font-size: 13.5px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-upload"></i> <?= $activeIdp ? 'Upload &amp; Replace PDF' : 'Upload IDP PDF' ?>
            </button>
        </form>
    </div>

    <!-- 2. Current Uploaded Document Status (Shown Below) -->
    <?php if ($activeIdp && !empty($activeIdp['file_path'])): ?>
        <div>
            <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 14px 0; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-file-pdf" style="color: #16a34a;"></i> Currently Published IDP PDF
            </h3>
            <div style="background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 8px; padding: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 50px; height: 50px; border-radius: 8px; background: #dcfce7; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0;">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                            <h4 style="font-size: 15px; font-weight: 700; color: #14532d; margin: 0;">
                                <?= htmlspecialchars(basename($activeIdp['file_path'])) ?>
                            </h4>
                            <span style="background: #bbf7d0; color: #166534; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 12px;">Active on Website</span>
                        </div>
                        <div style="font-size: 13px; color: #15803d;">
                            Size: <strong><?= htmlspecialchars($activeIdp['file_size'] ?? 'PDF Document') ?></strong> &bull; Uploaded on: <?= date('d M Y, h:i A', strtotime($activeIdp['created_at'])) ?>
                        </div>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 10px;">
                    <a href="../<?= htmlspecialchars($activeIdp['file_path']) ?>" target="_blank" class="btn btn-sm" style="background: #16a34a; color: #ffffff; padding: 7px 16px; font-size: 12.5px; font-weight: 600; text-decoration: none; border-radius: 4px; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fas fa-eye"></i> View PDF
                    </a>
                    <form action="idp.php" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to remove this IDP PDF? The document will no longer be available on the website until a new one is uploaded.');">
                        <input type="hidden" name="action" value="delete_idp">
                        <input type="hidden" name="id" value="<?= (int)$activeIdp['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 7px 16px; font-size: 12.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fas fa-trash-alt"></i> Remove PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div style="background: #fff7ed; border: 1.5px solid #fed7aa; border-radius: 8px; padding: 18px 20px; display: flex; align-items: center; gap: 14px;">
            <div style="width: 42px; height: 42px; border-radius: 6px; background: #ffedd5; color: #ea580c; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div>
                <div style="font-size: 14px; font-weight: 700; color: #9a3412;">No IDP PDF Uploaded Yet</div>
                <div style="font-size: 13px; color: #c2410c;">Please upload the official IDP document above so that visitors can open it directly from the website.</div>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
