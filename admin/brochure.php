<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage Information Brochures";
$current_page = 'brochure';

$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: brochure.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    // ==========================================
    // ACTION: ADD BROCHURE
    // ==========================================
    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $academic_year = trim($_POST['academic_year'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
            setFlashMessage('danger', 'Please select a valid PDF file to upload.');
            header('Location: brochure.php');
            exit;
        }

        $file = $_FILES['pdf_file'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($ext !== 'pdf') {
            setFlashMessage('danger', 'Only PDF files (.pdf) are allowed.');
            header('Location: brochure.php');
            exit;
        }

        if ($file['size'] > 25 * 1024 * 1024) {
            setFlashMessage('danger', 'PDF file size exceeds maximum limit of 25MB.');
            header('Location: brochure.php');
            exit;
        }

        // Sanitize and preserve clean file name
        $rawBase = pathinfo($file['name'], PATHINFO_FILENAME);
        $cleanBase = preg_replace('/[^a-zA-Z0-9_\-\.\(\)\s]/', '_', $rawBase);
        $cleanBase = trim($cleanBase);
        if (empty($cleanBase)) {
            $cleanBase = 'brochure_' . time();
        }

        // If title was left blank, use the cleaned original file name
        if (empty($title)) {
            $title = str_replace(['_', '-'], ' ', $cleanBase);
        }

        $targetDir = realpath(__DIR__ . '/../uploads/brochures');
        if (!$targetDir) {
            $targetDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'brochures';
        }
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $cleanFilename = $cleanBase . '.pdf';
        $targetFile = $targetDir . DIRECTORY_SEPARATOR . $cleanFilename;

        // If duplicate filename exists on disk, append timestamp to prevent accidental collision
        if (file_exists($targetFile)) {
            $cleanFilename = $cleanBase . '_' . time() . '.pdf';
            $targetFile = $targetDir . DIRECTORY_SEPARATOR . $cleanFilename;
        }

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

            $bytes = $file['size'];
            if ($bytes >= 1048576) {
                $fileSizeStr = number_format($bytes / 1048576, 1) . ' MB';
            } elseif ($bytes >= 1024) {
                $fileSizeStr = number_format($bytes / 1024, 0) . ' KB';
            } else {
                $fileSizeStr = $bytes . ' B';
            }

            $relativePath = 'uploads/brochures/' . $cleanFilename;

            $stmt = $pdo->prepare("INSERT INTO institute_brochures (title, academic_year, file_path, file_size, is_active) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $academic_year, $relativePath, $fileSizeStr, $is_active]);

            setFlashMessage('success', 'Information Brochure added successfully! It is now listed at the top.');
        } else {
            setFlashMessage('danger', 'Failed to save the PDF file to uploads folder.');
        }

        header('Location: brochure.php');
        exit;

    // ==========================================
    // ACTION: EDIT BROCHURE
    // ==========================================
    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $academic_year = trim($_POST['academic_year'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_file = trim($_POST['existing_file'] ?? '');

        if (empty($title) || $id <= 0) {
            setFlashMessage('danger', 'Valid ID and brochure title are required.');
            header('Location: brochure.php');
            exit;
        }

        $file_path = $existing_file;
        $file_size = null;

        // Check if new file was uploaded
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['pdf_file'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if ($ext !== 'pdf') {
                setFlashMessage('danger', 'Only PDF files (.pdf) are allowed.');
                header('Location: brochure.php?edit=' . $id);
                exit;
            }

            if ($file['size'] > 25 * 1024 * 1024) {
                setFlashMessage('danger', 'PDF file size exceeds maximum limit of 25MB.');
                header('Location: brochure.php?edit=' . $id);
                exit;
            }

            $rawBase = pathinfo($file['name'], PATHINFO_FILENAME);
            $cleanBase = preg_replace('/[^a-zA-Z0-9_\-\.\(\)\s]/', '_', $rawBase);
            $cleanBase = trim($cleanBase) ?: ('brochure_' . time());

            $targetDir = realpath(__DIR__ . '/../uploads/brochures');
            if (!$targetDir) {
                $targetDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'brochures';
            }
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $cleanFilename = $cleanBase . '.pdf';
            $targetFile = $targetDir . DIRECTORY_SEPARATOR . $cleanFilename;

            if (file_exists($targetFile)) {
                $cleanFilename = $cleanBase . '_' . time() . '.pdf';
                $targetFile = $targetDir . DIRECTORY_SEPARATOR . $cleanFilename;
            }

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                // Remove dummy titles like '(anonymous)' injected by compressors
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

                // Delete previous file if different
                if (!empty($existing_file)) {
                    $oldReal = realpath(__DIR__ . '/../' . $existing_file);
                    if ($oldReal && file_exists($oldReal)) {
                        @unlink($oldReal);
                    }
                }

                $bytes = $file['size'];
                $file_size = ($bytes >= 1048576) ? (number_format($bytes / 1048576, 1) . ' MB') : (number_format($bytes / 1024, 0) . ' KB');
                $file_path = 'uploads/brochures/' . $cleanFilename;
            }
        }

        if ($file_size) {
            $stmt = $pdo->prepare("UPDATE institute_brochures SET title = ?, academic_year = ?, file_path = ?, file_size = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $academic_year, $file_path, $file_size, $is_active, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE institute_brochures SET title = ?, academic_year = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $academic_year, $is_active, $id]);
        }

        setFlashMessage('success', 'Information Brochure updated successfully!');
        header('Location: brochure.php');
        exit;

    // ==========================================
    // ACTION: DELETE BROCHURE
    // ==========================================
    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("SELECT file_path FROM institute_brochures WHERE id = ?");
            $stmt->execute([$id]);
            $item = $stmt->fetch();
            if ($item && !empty($item['file_path'])) {
                $realFile = realpath(__DIR__ . '/../' . $item['file_path']);
                if ($realFile && file_exists($realFile)) {
                    @unlink($realFile);
                }
            }
            $pdo->prepare("DELETE FROM institute_brochures WHERE id = ?")->execute([$id]);
            setFlashMessage('success', 'Brochure deleted successfully.');
        }
        header('Location: brochure.php');
        exit;

    // ==========================================
    // ACTION: TOGGLE STATUS
    // ==========================================
    } elseif ($action === 'toggle_status') {
        $id = (int)($_POST['id'] ?? 0);
        $status = (int)($_POST['status'] ?? 0);
        $new_status = ($status === 1) ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE institute_brochures SET is_active = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
        setFlashMessage('success', 'Brochure status updated.');
        header('Location: brochure.php');
        exit;
    }
}

// Fetch item for editing
if (isset($_GET['edit']) && (int)$_GET['edit'] > 0 && $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM institute_brochures WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editItem = $stmt->fetch();
}

// Fetch all brochures - LATEST ON TOP (ORDER BY id DESC)
$brochures = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM institute_brochures ORDER BY id DESC");
    $brochures = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 24px;">
    <!-- Top Action Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 14px; margin-bottom: 22px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">Information Brochures &amp; Reports</h2>
            <p style="font-size: 13.5px; color: #64748b; margin: 0;">Upload and manage admission booklets, activity reports, and institutional brochures. Latest added appears at the top.</p>
        </div>
        <a href="../brochure.php" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; font-size: 13px;">
            <i class="fas fa-external-link-alt"></i> View Live Page
        </a>
    </div>

    <!-- Upload / Add Form -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas <?= $editItem ? 'fa-edit' : 'fa-plus-circle' ?>" style="color: #009dff;"></i>
            <?= $editItem ? 'Edit Brochure' : 'Add New Brochure / Report (PDF)' ?>
        </h3>

        <form action="brochure.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
                <input type="hidden" name="existing_file" value="<?= htmlspecialchars($editItem['file_path']) ?>">
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-weight: 600; color: #334155;">Brochure Title / Booklet Name <span style="color: #ef4444;">*</span></label>
                    <input type="text" 
                           name="title" 
                           class="form-control" 
                           placeholder="e.g. Information Booklet 2026-27" 
                           required 
                           value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">This title will be shown on the website list.</div>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-weight: 600; color: #334155;">Academic Year / Session</label>
                    <input type="text" 
                           name="academic_year" 
                           class="form-control" 
                           placeholder="e.g. 2026-27" 
                           value="<?= htmlspecialchars($editItem['academic_year'] ?? '') ?>">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 20px; align-items: flex-start;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-weight: 600; color: #334155;">
                        Select PDF Document <?= $editItem ? '' : '<span style="color: #ef4444;">*</span>' ?>
                    </label>
                    <input type="file" 
                           name="pdf_file" 
                           class="form-control" 
                           accept=".pdf" 
                           <?= $editItem ? '' : 'required' ?> 
                           style="padding: 7px 10px; font-size: 13.5px;">
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                        PDF files only. Maximum file size: 25MB. Original file name is preserved.
                    </div>
                    <?php if ($editItem && !empty($editItem['file_path'])): ?>
                        <div style="margin-top: 6px; font-size: 12.5px;">
                            <span style="color: #64748b;">Current File:</span>
                            <a href="../<?= htmlspecialchars($editItem['file_path']) ?>" target="_blank" style="color: #009dff; font-weight: 500; margin-left: 4px;">
                                <i class="fas fa-file-pdf"></i> <?= htmlspecialchars(basename($editItem['file_path'])) ?> (<?= htmlspecialchars($editItem['file_size'] ?? 'PDF') ?>)
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group" style="margin-bottom: 0; padding-top: 28px;">
                    <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13.5px; font-weight: 600; color: #334155;">
                        <input type="checkbox" name="is_active" value="1" <?= (!$editItem || $editItem['is_active'] == 1) ? 'checked' : '' ?> style="width: 17px; height: 17px;">
                        <span>Active &amp; Visible on Website</span>
                    </label>
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 8px 22px; font-size: 13.5px;">
                    <i class="fas fa-save"></i> <?= $editItem ? 'Update Brochure' : 'Upload &amp; Publish Brochure' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="brochure.php" class="btn btn-secondary" style="padding: 8px 18px; font-size: 13.5px;">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Uploaded Brochures List -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 2px 0;">
                All Brochures &amp; Reports (<?= count($brochures) ?>)
            </h3>
            <span style="font-size: 12px; color: #009dff; font-weight: 600;">Latest added appears at the top</span>
        </div>
        <div style="width: 280px;">
            <input type="text" class="form-control" placeholder="Search brochures..." data-table-search="brochuresTable" style="font-size: 13px;">
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table" id="brochuresTable" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Brochure / Report Title</th>
                    <th>Academic Year</th>
                    <th>PDF File &amp; Size</th>
                    <th>Uploaded Date</th>
                    <th style="width: 100px;">Status</th>
                    <th style="width: 130px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($brochures)): ?>
                    <tr class="no-records-row">
                        <td colspan="7" style="text-align: center; padding: 36px; color: #64748b;">
                            <i class="fas fa-book-open" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                            No brochures uploaded yet. Use the form above to add your first brochure PDF.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($brochures as $idx => $b): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td>
                                <a href="../<?= htmlspecialchars($b['file_path']) ?>" target="_blank" style="font-weight: 600; color: #009dff; text-decoration: none;">
                                    <?= htmlspecialchars($b['title']) ?>
                                    <i class="fas fa-external-link-alt" style="font-size: 11px; margin-left: 4px;"></i>
                                </a>
                                <?php if ($idx === 0): ?>
                                    <span style="margin-left: 8px; font-size: 11px; font-weight: 700; background: #e0f2fe; color: #0369a1; padding: 2px 6px; border-radius: 4px;">
                                        LATEST
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #334155;">
                                    <?= !empty($b['academic_year']) ? htmlspecialchars($b['academic_year']) : '-' ?>
                                </span>
                            </td>
                            <td>
                                <span style="color: #64748b; font-size: 13px;">
                                    <i class="fas fa-file-pdf" style="color: #ef4444;"></i> <?= htmlspecialchars(basename($b['file_path'])) ?>
                                    <span style="color: #94a3b8;">(<?= htmlspecialchars($b['file_size'] ?? 'PDF') ?>)</span>
                                </span>
                            </td>
                            <td style="font-size: 13px; color: #64748b;">
                                <?= !empty($b['created_at']) ? date('d M Y, h:i A', strtotime($b['created_at'])) : '-' ?>
                            </td>
                            <td>
                                <form action="brochure.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                    <input type="hidden" name="status" value="<?= $b['is_active'] ?>">
                                    <button type="submit" style="border: none; background: none; cursor: pointer; padding: 0;">
                                        <?= ($b['is_active'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Hidden</span>' ?>
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: right;">
                                <a href="../<?= htmlspecialchars($b['file_path']) ?>" target="_blank" class="btn btn-sm btn-info" title="View PDF in New Tab" style="padding: 4px 8px;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="brochure.php?edit=<?= $b['id'] ?>" class="btn btn-sm btn-warning" title="Edit Brochure" style="padding: 4px 8px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="brochure.php" method="POST" style="display: inline;" onsubmit="return confirm('Delete this brochure and its PDF file?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $b['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete Brochure" style="padding: 4px 8px;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
