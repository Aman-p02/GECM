<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage Institutional Rankings";
$current_page = 'rankings';

$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: rankings.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $ranking_body = trim($_POST['ranking_body'] ?? '');
        $academic_year = trim($_POST['academic_year'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title)) {
            setFlashMessage('danger', 'Ranking title is required.');
            header('Location: rankings.php');
            exit;
        }

        $upload = handlePdfUpload('pdf_file', 'rankings');
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: rankings.php');
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO institute_rankings (title, ranking_body, academic_year, file_path, file_size, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $ranking_body, $academic_year, $upload['path'], $upload['file_size'] ?? null, $display_order, $is_active]);

        setFlashMessage('success', 'Ranking document uploaded successfully!');
        header('Location: rankings.php');
        exit;

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $ranking_body = trim($_POST['ranking_body'] ?? '');
        $academic_year = trim($_POST['academic_year'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_file = trim($_POST['existing_file'] ?? '');

        if (empty($title) || $id <= 0) {
            setFlashMessage('danger', 'Valid ID and ranking title are required.');
            header('Location: rankings.php');
            exit;
        }

        $file_path = $existing_file;
        $file_size = null;

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $upload = handlePdfUpload('pdf_file', 'rankings', $existing_file);
            if ($upload['success']) {
                $file_path = $upload['path'];
                $file_size = $upload['file_size'] ?? null;
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: rankings.php?edit=' . $id);
                exit;
            }
        }

        if ($file_size) {
            $stmt = $pdo->prepare("UPDATE institute_rankings SET title = ?, ranking_body = ?, academic_year = ?, file_path = ?, file_size = ?, display_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $ranking_body, $academic_year, $file_path, $file_size, $display_order, $is_active, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE institute_rankings SET title = ?, ranking_body = ?, academic_year = ?, file_path = ?, display_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $ranking_body, $academic_year, $file_path, $display_order, $is_active, $id]);
        }

        setFlashMessage('success', 'Ranking document updated successfully!');
        header('Location: rankings.php');
        exit;

    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("SELECT file_path FROM institute_rankings WHERE id = ?");
            $stmt->execute([$id]);
            $item = $stmt->fetch();
            if ($item && !empty($item['file_path'])) {
                $realFile = realpath(__DIR__ . '/../' . $item['file_path']);
                if ($realFile && file_exists($realFile)) {
                    @unlink($realFile);
                }
            }
            $pdo->prepare("DELETE FROM institute_rankings WHERE id = ?")->execute([$id]);
            setFlashMessage('success', 'Ranking document deleted.');
        }
        header('Location: rankings.php');
        exit;

    } elseif ($action === 'toggle_status') {
        $id = (int)($_POST['id'] ?? 0);
        $status = (int)($_POST['status'] ?? 0);
        $new_status = ($status === 1) ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE institute_rankings SET is_active = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
        setFlashMessage('success', 'Ranking document status updated.');
        header('Location: rankings.php');
        exit;
    }
}

// Fetch item for editing
if (isset($_GET['edit']) && (int)$_GET['edit'] > 0 && $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM institute_rankings WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editItem = $stmt->fetch();
}

// Fetch all ranking documents
$rankings = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM institute_rankings ORDER BY display_order ASC, id DESC");
    $rankings = $stmt->fetchAll();
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 24px;">
    <!-- Top Action Bar (No Duplicate Title) -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 14px; margin-bottom: 22px; flex-wrap: wrap; gap: 12px;">
        <p style="font-size: 13.5px; color: #64748b; margin: 0;">Upload and publish official NIRF, GSIRF, and national ranking evaluation reports (PDF).</p>
        <a href="../rankings.php" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; font-size: 12.5px;">
            <i class="fas fa-external-link-alt"></i> View Public Page
        </a>
    </div>

    <!-- Upload / Edit Form -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas <?= $editItem ? 'fa-edit' : 'fa-plus-circle' ?>" style="color: #1e90ff;"></i>
            <?= $editItem ? 'Edit Ranking Document' : 'Upload New Ranking Document (PDF)' ?>
        </h3>

        <form action="rankings.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
                <input type="hidden" name="existing_file" value="<?= htmlspecialchars($editItem['file_path']) ?>">
            <?php endif; ?>

            <!-- Row 1 -->
            <div style="display: grid; grid-template-columns: 2fr 1.3fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Ranking Title <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. NIRF 2024 Engineering Ranking Certificate" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Ranking Body / Agency</label>
                    <input type="text" name="ranking_body" class="form-control" placeholder="e.g. NIRF (MoE), GSIRF, India Today" value="<?= htmlspecialchars($editItem['ranking_body'] ?? '') ?>">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Evaluation Year</label>
                    <input type="text" name="academic_year" class="form-control" placeholder="e.g. 2024 or 2023-24" value="<?= htmlspecialchars($editItem['academic_year'] ?? '') ?>">
                </div>
            </div>

            <!-- Row 2 -->
            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px; margin-bottom: 20px; align-items: flex-start;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Ranking Report PDF <?= $editItem ? '' : '<span style="color: #ef4444;">*</span>' ?></label>
                    <input type="file" name="pdf_file" class="form-control" accept=".pdf" <?= $editItem ? '' : 'required' ?> style="padding: 5px 8px; font-size: 13px;">
                    <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">PDF format only. Maximum size: 25MB.</div>
                    <?php if ($editItem && !empty($editItem['file_path'])): ?>
                        <div style="margin-top: 4px; font-size: 12px;">
                            <a href="../<?= htmlspecialchars($editItem['file_path']) ?>" target="_blank" style="color: #1e90ff;">
                                <i class="fas fa-file-pdf"></i> Current: <?= htmlspecialchars($editItem['file_size'] ?? 'PDF') ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Priority Order</label>
                    <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order'] ?? '0') ?>">
                </div>

                <div class="form-group" style="margin-bottom: 0; padding-top: 28px;">
                    <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13.5px; font-weight: 600; color: #334155;">
                        <input type="checkbox" name="is_active" value="1" <?= (!$editItem || $editItem['is_active'] == 1) ? 'checked' : '' ?> style="width: 17px; height: 17px;">
                        <span>Active &amp; Visible</span>
                    </label>
                </div>
            </div>

            <!-- Submit Row -->
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 8px 22px; font-size: 13px;">
                    <i class="fas fa-save"></i> <?= $editItem ? 'Update Document' : 'Upload Ranking PDF' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="rankings.php" class="btn btn-secondary" style="padding: 8px 18px; font-size: 13px;">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table Header & Search -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 12px;">
        <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">Uploaded Ranking Documents (<?= count($rankings) ?>)</h3>
        <div style="width: 260px;">
            <input type="text" class="form-control" placeholder="Search rankings..." data-table-search="rankingsTable" style="height: 36px; font-size: 13px;">
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table" id="rankingsTable" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Document Title</th>
                    <th>Agency / Body</th>
                    <th>Year</th>
                    <th>File Size</th>
                    <th style="width: 90px;">Status</th>
                    <th style="width: 110px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rankings)): ?>
                    <tr class="no-records-row">
                        <td colspan="7" style="text-align: center; padding: 32px; color: #64748b;">
                            <i class="fas fa-award" style="font-size: 28px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                            No ranking documents uploaded yet. Use the form above to add one.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($rankings as $idx => $r): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($r['title']) ?></td>
                            <td>
                                <span style="background: #e0f2fe; color: #0369a1; padding: 2px 7px; border-radius: 4px; font-size: 11.5px; font-weight: 600;">
                                    <?= htmlspecialchars($r['ranking_body'] ?? 'Institutional') ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($r['academic_year'] ?? '-') ?></td>
                            <td>
                                <span style="color: #64748b; font-size: 12.5px;">
                                    <i class="fas fa-paperclip"></i> <?= htmlspecialchars($r['file_size'] ?? 'PDF') ?>
                                </span>
                            </td>
                            <td>
                                <form action="rankings.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                    <input type="hidden" name="status" value="<?= $r['is_active'] ?>">
                                    <button type="submit" style="border: none; background: none; cursor: pointer;">
                                        <?= ($r['is_active'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>' ?>
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: right;">
                                <a href="../<?= htmlspecialchars($r['file_path']) ?>" target="_blank" class="btn btn-sm btn-info" style="padding: 3px 7px;" title="View PDF">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="rankings.php?edit=<?= $r['id'] ?>" class="btn btn-sm btn-warning" style="padding: 3px 7px;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="rankings.php" method="POST" style="display: inline;" onsubmit="return confirm('Delete this ranking document?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" style="padding: 3px 7px;" title="Delete">
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
