<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage E-Newsletters";
$current_page = 'e-newsletters';

$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: e-newsletters.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    // ==========================================
    // ACTION: ADD NEWSLETTER
    // ==========================================
    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
            setFlashMessage('danger', 'Please select a valid PDF file to upload.');
            header('Location: e-newsletters.php');
            exit;
        }

        $file = $_FILES['pdf_file'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($ext !== 'pdf') {
            setFlashMessage('danger', 'Only PDF files (.pdf) are allowed.');
            header('Location: e-newsletters.php');
            exit;
        }

        if ($file['size'] > 25 * 1024 * 1024) {
            setFlashMessage('danger', 'PDF file size exceeds maximum limit of 25MB.');
            header('Location: e-newsletters.php');
            exit;
        }

        // Sanitize and preserve clean file name
        $rawBase = pathinfo($file['name'], PATHINFO_FILENAME);
        $cleanBase = preg_replace('/[^a-zA-Z0-9_\-\.\(\)\s]/', '_', $rawBase);
        $cleanBase = trim($cleanBase);
        if (empty($cleanBase)) {
            $cleanBase = 'newsletter_' . time();
        }

        // If title was left blank, use the cleaned original file name
        if (empty($title)) {
            $title = str_replace(['_', '-'], ' ', $cleanBase);
        }

        $targetDir = realpath(__DIR__ . '/../../uploads/newsletters');
        if (!$targetDir) {
            $targetDir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'newsletters';
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
            $bytes = $file['size'];
            if ($bytes >= 1048576) {
                $fileSizeStr = number_format($bytes / 1048576, 1) . ' MB';
            } elseif ($bytes >= 1024) {
                $fileSizeStr = number_format($bytes / 1024, 0) . ' KB';
            } else {
                $fileSizeStr = $bytes . ' B';
            }

            $relativePath = 'uploads/newsletters/' . $cleanFilename;

            $stmt = $pdo->prepare("INSERT INTO institute_newsletters (title, file_path, file_size, is_active) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $relativePath, $fileSizeStr, $is_active]);

            setFlashMessage('success', 'E-Newsletter added successfully! It is now listed at the top.');
        } else {
            setFlashMessage('danger', 'Failed to save the PDF file to uploads folder.');
        }

        header('Location: e-newsletters.php');
        exit;

    // ==========================================
    // ACTION: EDIT NEWSLETTER
    // ==========================================
    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_file = trim($_POST['existing_file'] ?? '');

        if (empty($title) || $id <= 0) {
            setFlashMessage('danger', 'Valid ID and newsletter title are required.');
            header('Location: e-newsletters.php');
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
                header('Location: e-newsletters.php?edit=' . $id);
                exit;
            }

            if ($file['size'] > 25 * 1024 * 1024) {
                setFlashMessage('danger', 'PDF file size exceeds maximum limit of 25MB.');
                header('Location: e-newsletters.php?edit=' . $id);
                exit;
            }

            $rawBase = pathinfo($file['name'], PATHINFO_FILENAME);
            $cleanBase = preg_replace('/[^a-zA-Z0-9_\-\.\(\)\s]/', '_', $rawBase);
            $cleanBase = trim($cleanBase) ?: ('newsletter_' . time());

            $targetDir = realpath(__DIR__ . '/../../uploads/newsletters');
            if (!$targetDir) {
                $targetDir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'newsletters';
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
                // Delete previous file if different
                if (!empty($existing_file)) {
                    $oldReal = realpath(__DIR__ . '/../' . $existing_file);
                    if ($oldReal && file_exists($oldReal)) {
                        @unlink($oldReal);
                    }
                }

                $bytes = $file['size'];
                $file_size = ($bytes >= 1048576) ? (number_format($bytes / 1048576, 1) . ' MB') : (number_format($bytes / 1024, 0) . ' KB');
                $file_path = 'uploads/newsletters/' . $cleanFilename;
            }
        }

        if ($file_size) {
            $stmt = $pdo->prepare("UPDATE institute_newsletters SET title = ?, file_path = ?, file_size = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $file_path, $file_size, $is_active, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE institute_newsletters SET title = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $is_active, $id]);
        }

        setFlashMessage('success', 'E-Newsletter updated successfully!');
        header('Location: e-newsletters.php');
        exit;

    // ==========================================
    // ACTION: DELETE NEWSLETTER
    // ==========================================
    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("SELECT file_path FROM institute_newsletters WHERE id = ?");
            $stmt->execute([$id]);
            $item = $stmt->fetch();
            if ($item && !empty($item['file_path'])) {
                $realFile = realpath(__DIR__ . '/../' . $item['file_path']);
                if ($realFile && file_exists($realFile)) {
                    @unlink($realFile);
                }
            }
            $pdo->prepare("DELETE FROM institute_newsletters WHERE id = ?")->execute([$id]);
            setFlashMessage('success', 'Newsletter deleted successfully.');
        }
        header('Location: e-newsletters.php');
        exit;

    // ==========================================
    // ACTION: TOGGLE STATUS
    // ==========================================
    } elseif ($action === 'toggle_status') {
        $id = (int)($_POST['id'] ?? 0);
        $status = (int)($_POST['status'] ?? 0);
        $new_status = ($status === 1) ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE institute_newsletters SET is_active = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
        setFlashMessage('success', 'Newsletter status updated.');
        header('Location: e-newsletters.php');
        exit;
    }
}

// Fetch item for editing
if (isset($_GET['edit']) && (int)$_GET['edit'] > 0 && $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM institute_newsletters WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editItem = $stmt->fetch();
}

// Fetch all newsletters - LATEST ON TOP (ORDER BY id DESC)
$newsletters = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM institute_newsletters ORDER BY id DESC");
    $newsletters = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 24px;">
    <!-- Top Action Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 14px; margin-bottom: 22px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">Institutional E-Newsletters</h2>
            <p style="font-size: 13.5px; color: #64748b; margin: 0;">Add and manage newsletter PDF links. The latest added newsletter will automatically appear at the top.</p>
        </div>
        <a href="../e-newsletters.php" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; font-size: 13px;">
            <i class="fas fa-external-link-alt"></i> View Live Page
        </a>
    </div>

    <!-- Upload / Add Form -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas <?= $editItem ? 'fa-edit' : 'fa-plus-circle' ?>" style="color: #009dff;"></i>
            <?= $editItem ? 'Edit E-Newsletter' : 'Add New E-Newsletter PDF' ?>
        </h3>

        <form action="e-newsletters.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
                <input type="hidden" name="existing_file" value="<?= htmlspecialchars($editItem['file_path']) ?>">
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-weight: 600; color: #334155;">Newsletter Title / Link Text <span style="color: #ef4444;">*</span></label>
                    <input type="text" 
                           name="title" 
                           class="form-control" 
                           placeholder="e.g. Volume-6, Issue-1, Jan - June 2026" 
                           required 
                           value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">This title will be shown as the clickable link on the website.</div>
                </div>

                <div class="form-group" style="margin-bottom: 0; padding-top: 28px;">
                    <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13.5px; font-weight: 600; color: #334155;">
                        <input type="checkbox" name="is_active" value="1" <?= (!$editItem || $editItem['is_active'] == 1) ? 'checked' : '' ?> style="width: 17px; height: 17px;">
                        <span>Active &amp; Visible on Website</span>
                    </label>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label" style="font-weight: 600; color: #334155;">
                    Select PDF File <?= $editItem ? '' : '<span style="color: #ef4444;">*</span>' ?>
                </label>
                <input type="file" 
                       name="pdf_file" 
                       class="form-control" 
                       accept=".pdf" 
                       <?= $editItem ? '' : 'required' ?> 
                       style="padding: 7px 10px; font-size: 13.5px;">
                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                    PDF files only. Maximum file size: 25MB. Original file name will be preserved for browser tabs.
                </div>
                <?php if ($editItem && !empty($editItem['file_path'])): ?>
                    <div style="margin-top: 6px; font-size: 12.5px;">
                        <span style="color: #64748b;">Current PDF:</span>
                        <a href="../<?= htmlspecialchars($editItem['file_path']) ?>" target="_blank" style="color: #009dff; font-weight: 500; margin-left: 4px;">
                            <i class="fas fa-file-pdf"></i> <?= htmlspecialchars(basename($editItem['file_path'])) ?> (<?= htmlspecialchars($editItem['file_size'] ?? 'PDF') ?>)
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 8px 22px; font-size: 13.5px;">
                    <i class="fas fa-save"></i> <?= $editItem ? 'Update Newsletter' : 'Upload &amp; Publish Newsletter' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="e-newsletters.php" class="btn btn-secondary" style="padding: 8px 18px; font-size: 13.5px;">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Uploaded Newsletters List -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 2px 0;">
                All Newsletters (<?= count($newsletters) ?>)
            </h3>
            <span style="font-size: 12px; color: #009dff; font-weight: 600;">Latest added appears at the top</span>
        </div>
        <div style="width: 280px;">
            <input type="text" class="form-control" placeholder="Search newsletters..." data-table-search="newslettersTable" style="font-size: 13px;">
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table" id="newslettersTable" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Link Title (Shown to Users)</th>
                    <th>PDF File &amp; Size</th>
                    <th>Uploaded Date</th>
                    <th style="width: 100px;">Status</th>
                    <th style="width: 130px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($newsletters)): ?>
                    <tr class="no-records-row">
                        <td colspan="6" style="text-align: center; padding: 36px; color: #64748b;">
                            <i class="fas fa-newspaper" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                            No newsletters uploaded yet. Use the form above to add your first newsletter PDF.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($newsletters as $idx => $nl): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td>
                                <a href="../<?= htmlspecialchars($nl['file_path']) ?>" target="_blank" style="font-weight: 600; color: #009dff; text-decoration: none;">
                                    <?= htmlspecialchars($nl['title']) ?>
                                    <i class="fas fa-external-link-alt" style="font-size: 11px; margin-left: 4px;"></i>
                                </a>
                                <?php if ($idx === 0): ?>
                                    <span style="margin-left: 8px; font-size: 11px; font-weight: 700; background: #e0f2fe; color: #0369a1; padding: 2px 6px; border-radius: 4px;">
                                        LATEST
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span style="color: #64748b; font-size: 13px;">
                                    <i class="fas fa-file-pdf" style="color: #ef4444;"></i> <?= htmlspecialchars(basename($nl['file_path'])) ?>
                                    <span style="color: #94a3b8;">(<?= htmlspecialchars($nl['file_size'] ?? 'PDF') ?>)</span>
                                </span>
                            </td>
                            <td style="font-size: 13px; color: #64748b;">
                                <?= !empty($nl['created_at']) ? date('d M Y, h:i A', strtotime($nl['created_at'])) : '-' ?>
                            </td>
                            <td>
                                <form action="e-newsletters.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= $nl['id'] ?>">
                                    <input type="hidden" name="status" value="<?= $nl['is_active'] ?>">
                                    <button type="submit" style="border: none; background: none; cursor: pointer; padding: 0;">
                                        <?= ($nl['is_active'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Hidden</span>' ?>
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: right;">
                                <a href="../<?= htmlspecialchars($nl['file_path']) ?>" target="_blank" class="btn btn-sm btn-info" title="View PDF in New Tab" style="padding: 4px 8px;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="e-newsletters.php?edit=<?= $nl['id'] ?>" class="btn btn-sm btn-warning" title="Edit Newsletter" style="padding: 4px 8px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="e-newsletters.php" method="POST" style="display: inline;" onsubmit="return confirm('Delete this newsletter and its PDF file?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $nl['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete Newsletter" style="padding: 4px 8px;">
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
