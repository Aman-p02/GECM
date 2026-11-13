<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage Institutional Development Plan (IDP)";
$current_page = 'idp';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: idp.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'save_idp') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? 'Institutional Development Plan (IDP) 2025-2030');
        $cycle_years = trim($_POST['cycle_years'] ?? '2025-2030');
        $description = trim($_POST['description'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_file = trim($_POST['existing_file'] ?? '');

        $file_path = $existing_file;
        $file_size = null;

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $upload = handlePdfUpload('pdf_file', 'idp', $existing_file);
            if ($upload['success']) {
                $file_path = $upload['path'];
                $file_size = $upload['file_size'] ?? null;
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: idp.php');
                exit;
            }
        }

        if (empty($file_path)) {
            setFlashMessage('danger', 'Please upload an IDP document (PDF).');
            header('Location: idp.php');
            exit;
        }

        if ($id > 0) {
            if ($file_size) {
                $stmt = $pdo->prepare("UPDATE idp_documents SET title = ?, cycle_years = ?, description = ?, file_path = ?, file_size = ?, is_active = ? WHERE id = ?");
                $stmt->execute([$title, $cycle_years, $description, $file_path, $file_size, $is_active, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE idp_documents SET title = ?, cycle_years = ?, description = ?, file_path = ?, is_active = ? WHERE id = ?");
                $stmt->execute([$title, $cycle_years, $description, $file_path, $is_active, $id]);
            }
            setFlashMessage('success', 'IDP document updated successfully!');
        } else {
            $stmt = $pdo->prepare("INSERT INTO idp_documents (title, cycle_years, description, file_path, file_size, is_active) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $cycle_years, $description, $file_path, $file_size, $is_active]);
            setFlashMessage('success', 'IDP document uploaded successfully!');
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
            setFlashMessage('success', 'IDP entry deleted.');
        }
        header('Location: idp.php');
        exit;
    }
}

// Fetch current IDP document
$currentIdp = null;
$allIdp = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM idp_documents ORDER BY is_active DESC, id DESC");
    $allIdp = $stmt->fetchAll();
    if (!empty($allIdp)) {
        $currentIdp = $allIdp[0];
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 24px;">
    <!-- Top Action Bar (No Duplicate Title) -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 14px; margin-bottom: 22px; flex-wrap: wrap; gap: 12px;">
        <p style="font-size: 13.5px; color: #64748b; margin: 0;">Upload and publish the institutional multi-year strategic development plan (NEP 2020).</p>
        <a href="../idp.php" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; font-size: 12.5px;">
            <i class="fas fa-external-link-alt"></i> View Public Page
        </a>
    </div>

    <!-- IDP Upload / Edit Form -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas <?= $currentIdp ? 'fa-edit' : 'fa-upload' ?>" style="color: #1e90ff;"></i>
            <?= $currentIdp ? 'Update IDP Strategic Plan Document' : 'Upload IDP Strategic Plan Document' ?>
        </h3>

        <form action="idp.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="save_idp">
            <?php if ($currentIdp): ?>
                <input type="hidden" name="id" value="<?= $currentIdp['id'] ?>">
                <input type="hidden" name="existing_file" value="<?= htmlspecialchars($currentIdp['file_path']) ?>">
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Document Title <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($currentIdp['title'] ?? 'Institutional Development Plan (IDP) 2025-2030') ?>" required>
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Planning Cycle / Years</label>
                    <input type="text" name="cycle_years" class="form-control" value="<?= htmlspecialchars($currentIdp['cycle_years'] ?? '2025-2030') ?>" placeholder="e.g. 2025-2030">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label">Executive Summary / Vision Statement</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Brief summary of institutional objectives, targets, and strategic pillars..."><?= htmlspecialchars($currentIdp['description'] ?? '') ?></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 20px; align-items: flex-start;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">IDP PDF Document <?= $currentIdp ? '' : '<span style="color: #ef4444;">*</span>' ?></label>
                    <input type="file" name="pdf_file" class="form-control" accept=".pdf" <?= $currentIdp ? '' : 'required' ?> style="padding: 5px 8px; font-size: 13px;">
                    <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">PDF format only. Maximum file size: 25MB.</div>
                    <?php if ($currentIdp && !empty($currentIdp['file_path'])): ?>
                        <div style="margin-top: 4px; font-size: 12px;">
                            <a href="../<?= htmlspecialchars($currentIdp['file_path']) ?>" target="_blank" style="color: #1e90ff;">
                                <i class="fas fa-file-pdf"></i> Current: <?= htmlspecialchars($currentIdp['file_size'] ?? 'PDF') ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group" style="margin-bottom: 0; padding-top: 28px;">
                    <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13.5px; font-weight: 600; color: #334155;">
                        <input type="checkbox" name="is_active" value="1" <?= (!$currentIdp || $currentIdp['is_active'] == 1) ? 'checked' : '' ?> style="width: 17px; height: 17px;">
                        <span>Active &amp; Visible</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="padding: 8px 22px; font-size: 13px;">
                <i class="fas fa-save"></i> <?= $currentIdp ? 'Save Changes' : 'Upload IDP Document' ?>
            </button>
        </form>
    </div>

    <!-- Historical / Uploaded IDP list if any -->
    <?php if (count($allIdp) > 1): ?>
        <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 12px 0;">All Uploaded IDP Versions</h3>
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Cycle</th>
                        <th>File Size</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allIdp as $item): ?>
                        <tr>
                            <td style="font-weight: 600;"><?= htmlspecialchars($item['title']) ?></td>
                            <td><?= htmlspecialchars($item['cycle_years']) ?></td>
                            <td><?= htmlspecialchars($item['file_size'] ?? '-') ?></td>
                            <td>
                                <?= ($item['is_active'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Archived</span>' ?>
                            </td>
                            <td>
                                <a href="../<?= htmlspecialchars($item['file_path']) ?>" target="_blank" class="btn btn-sm btn-info" style="padding: 4px 8px;">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <form action="idp.php" method="POST" style="display: inline;" onsubmit="return confirm('Delete this version?');">
                                    <input type="hidden" name="action" value="delete_idp">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" style="padding: 4px 8px;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

