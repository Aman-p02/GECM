<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage Information Brochure";
$current_page = 'brochure';

$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: brochure.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? 'Information Brochure');
        $academic_year = trim($_POST['academic_year'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title)) {
            setFlashMessage('danger', 'Brochure title is required.');
            header('Location: brochure.php');
            exit;
        }

        $upload = handlePdfUpload('pdf_file', 'brochures');
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: brochure.php');
            exit;
        }

        // If active, optionally set older ones inactive or keep them
        $stmt = $pdo->prepare("INSERT INTO institute_brochures (title, academic_year, file_path, file_size, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $academic_year, $upload['path'], $upload['file_size'] ?? null, $is_active]);

        setFlashMessage('success', 'Information Brochure uploaded successfully!');
        header('Location: brochure.php');
        exit;

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $academic_year = trim($_POST['academic_year'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_file = trim($_POST['existing_file'] ?? '');

        if (empty($title) || $id <= 0) {
            setFlashMessage('danger', 'Valid ID and title are required.');
            header('Location: brochure.php');
            exit;
        }

        $file_path = $existing_file;
        $file_size = null;

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $upload = handlePdfUpload('pdf_file', 'brochures', $existing_file);
            if ($upload['success']) {
                $file_path = $upload['path'];
                $file_size = $upload['file_size'] ?? null;
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: brochure.php?edit=' . $id);
                exit;
            }
        }

        if ($file_size) {
            $stmt = $pdo->prepare("UPDATE institute_brochures SET title = ?, academic_year = ?, file_path = ?, file_size = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $academic_year, $file_path, $file_size, $is_active, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE institute_brochures SET title = ?, academic_year = ?, file_path = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $academic_year, $file_path, $is_active, $id]);
        }

        setFlashMessage('success', 'Information Brochure updated successfully!');
        header('Location: brochure.php');
        exit;

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
            setFlashMessage('success', 'Brochure deleted.');
        }
        header('Location: brochure.php');
        exit;

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

// Fetch brochure for editing
if (isset($_GET['edit']) && (int)$_GET['edit'] > 0 && $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM institute_brochures WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editItem = $stmt->fetch();
}

// Fetch all brochures
$brochures = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM institute_brochures ORDER BY id DESC");
    $brochures = $stmt->fetchAll();
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 24px;">
    <!-- Top Action Bar (No Duplicate Title) -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 14px; margin-bottom: 22px; flex-wrap: wrap; gap: 12px;">
        <p style="font-size: 13.5px; color: #64748b; margin: 0;">Upload and publish the official institute information brochure and prospectus (PDF).</p>
        <a href="../brochure.php" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; font-size: 12.5px;">
            <i class="fas fa-external-link-alt"></i> View Public Page
        </a>
    </div>

    <!-- Upload Form -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas <?= $editItem ? 'fa-edit' : 'fa-plus-circle' ?>" style="color: #1e90ff;"></i>
            <?= $editItem ? 'Edit Information Brochure' : 'Upload New Information Brochure (PDF)' ?>
        </h3>

        <form action="brochure.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
                <input type="hidden" name="existing_file" value="<?= htmlspecialchars($editItem['file_path']) ?>">
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Brochure Title <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. GEC Modasa Information Brochure &amp; Prospectus 2025-26" required value="<?= htmlspecialchars($editItem['title'] ?? 'Information Brochure') ?>">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Academic Year</label>
                    <input type="text" name="academic_year" class="form-control" placeholder="e.g. 2025-26" value="<?= htmlspecialchars($editItem['academic_year'] ?? '') ?>">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 20px; align-items: flex-start;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Brochure PDF File <?= $editItem ? '' : '<span style="color: #ef4444;">*</span>' ?></label>
                    <input type="file" name="pdf_file" class="form-control" accept=".pdf" <?= $editItem ? '' : 'required' ?> style="padding: 5px 8px; font-size: 13px;">
                    <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">PDF format only. Maximum file size: 25MB.</div>
                    <?php if ($editItem && !empty($editItem['file_path'])): ?>
                        <div style="margin-top: 4px; font-size: 12px;">
                            <a href="../<?= htmlspecialchars($editItem['file_path']) ?>" target="_blank" style="color: #1e90ff;">
                                <i class="fas fa-file-pdf"></i> Current: <?= htmlspecialchars($editItem['file_size'] ?? 'PDF') ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group" style="margin-bottom: 0; padding-top: 28px;">
                    <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13.5px; font-weight: 600; color: #334155;">
                        <input type="checkbox" name="is_active" value="1" <?= (!$editItem || $editItem['is_active'] == 1) ? 'checked' : '' ?> style="width: 17px; height: 17px;">
                        <span>Active &amp; Visible</span>
                    </label>
                </div>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 8px 22px; font-size: 13px;">
                    <i class="fas fa-save"></i> <?= $editItem ? 'Update Brochure' : 'Upload Brochure' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="brochure.php" class="btn btn-secondary" style="padding: 8px 18px; font-size: 13px;">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
        <h3 style="font-size: 17px; font-weight: 700; color: #1e293b; margin: 0;">Uploaded Brochures (<?= count($brochures) ?>)</h3>
        <div style="width: 280px;">
            <input type="text" class="form-control" placeholder="Search brochures..." data-table-search="brochuresTable">
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table" id="brochuresTable" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Title</th>
                    <th>Academic Year</th>
                    <th>File Size</th>
                    <th>Status</th>
                    <th style="width: 120px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($brochures)): ?>
                    <tr class="no-records-row">
                        <td colspan="6" style="text-align: center; padding: 36px; color: #64748b;">
                            <i class="fas fa-book-open" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                            No brochures uploaded yet. Use the form above to add one.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($brochures as $idx => $br): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($br['title']) ?></td>
                            <td><?= htmlspecialchars($br['academic_year'] ?? '-') ?></td>
                            <td>
                                <span style="color: #64748b; font-size: 13px;">
                                    <i class="fas fa-paperclip"></i> <?= htmlspecialchars($br['file_size'] ?? 'PDF') ?>
                                </span>
                            </td>
                            <td>
                                <form action="brochure.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= $br['id'] ?>">
                                    <input type="hidden" name="status" value="<?= $br['is_active'] ?>">
                                    <button type="submit" style="border: none; background: none; cursor: pointer;">
                                        <?= ($br['is_active'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>' ?>
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: right;">
                                <a href="../<?= htmlspecialchars($br['file_path']) ?>" target="_blank" class="btn btn-sm btn-info" style="padding: 4px 8px;">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="brochure.php?edit=<?= $br['id'] ?>" class="btn btn-sm btn-warning" style="padding: 4px 8px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="brochure.php" method="POST" style="display: inline;" onsubmit="return confirm('Delete this brochure?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $br['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" style="padding: 4px 8px;">
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

