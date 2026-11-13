<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage Memorandums of Understanding (MoU)";
$current_page = 'mou';

$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: mou.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $partner_organization = trim($_POST['partner_organization'] ?? '');
        $category = trim($_POST['category'] ?? 'Industry Collaboration');
        $validity_period = trim($_POST['validity_period'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title)) {
            setFlashMessage('danger', 'MoU title is required.');
            header('Location: mou.php');
            exit;
        }

        $upload = handlePdfUpload('pdf_file', 'mous');
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: mou.php');
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO institute_mous (title, partner_organization, category, validity_period, file_path, file_size, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $partner_organization, $category, $validity_period, $upload['path'], $upload['file_size'] ?? null, $display_order, $is_active]);

        setFlashMessage('success', 'MoU document uploaded successfully!');
        header('Location: mou.php');
        exit;

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $partner_organization = trim($_POST['partner_organization'] ?? '');
        $category = trim($_POST['category'] ?? 'Industry Collaboration');
        $validity_period = trim($_POST['validity_period'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_file = trim($_POST['existing_file'] ?? '');

        if (empty($title) || $id <= 0) {
            setFlashMessage('danger', 'Valid ID and MoU title are required.');
            header('Location: mou.php');
            exit;
        }

        $file_path = $existing_file;
        $file_size = null;

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $upload = handlePdfUpload('pdf_file', 'mous', $existing_file);
            if ($upload['success']) {
                $file_path = $upload['path'];
                $file_size = $upload['file_size'] ?? null;
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: mou.php?edit=' . $id);
                exit;
            }
        }

        if ($file_size) {
            $stmt = $pdo->prepare("UPDATE institute_mous SET title = ?, partner_organization = ?, category = ?, validity_period = ?, file_path = ?, file_size = ?, display_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $partner_organization, $category, $validity_period, $file_path, $file_size, $display_order, $is_active, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE institute_mous SET title = ?, partner_organization = ?, category = ?, validity_period = ?, file_path = ?, display_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $partner_organization, $category, $validity_period, $file_path, $display_order, $is_active, $id]);
        }

        setFlashMessage('success', 'MoU document updated successfully!');
        header('Location: mou.php');
        exit;

    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("SELECT file_path FROM institute_mous WHERE id = ?");
            $stmt->execute([$id]);
            $item = $stmt->fetch();
            if ($item && !empty($item['file_path'])) {
                $realFile = realpath(__DIR__ . '/../' . $item['file_path']);
                if ($realFile && file_exists($realFile)) {
                    @unlink($realFile);
                }
            }
            $pdo->prepare("DELETE FROM institute_mous WHERE id = ?")->execute([$id]);
            setFlashMessage('success', 'MoU document deleted.');
        }
        header('Location: mou.php');
        exit;

    } elseif ($action === 'toggle_status') {
        $id = (int)($_POST['id'] ?? 0);
        $status = (int)($_POST['status'] ?? 0);
        $new_status = ($status === 1) ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE institute_mous SET is_active = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
        setFlashMessage('success', 'MoU status updated.');
        header('Location: mou.php');
        exit;
    }
}

// Fetch item for editing
if (isset($_GET['edit']) && (int)$_GET['edit'] > 0 && $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM institute_mous WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editItem = $stmt->fetch();
}

// Fetch all MoU documents
$mous = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM institute_mous ORDER BY display_order ASC, id DESC");
    $mous = $stmt->fetchAll();
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 24px;">
    <!-- Top Action Bar (No Duplicate Title) -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 14px; margin-bottom: 22px; flex-wrap: wrap; gap: 12px;">
        <p style="font-size: 13.5px; color: #64748b; margin: 0;">Upload and publish official MoUs signed with industries, academic institutions, and research bodies (PDF).</p>
        <a href="../mou.php" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; font-size: 12.5px;">
            <i class="fas fa-external-link-alt"></i> View Public Page
        </a>
    </div>

    <!-- Upload / Edit Form -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas <?= $editItem ? 'fa-edit' : 'fa-plus-circle' ?>" style="color: #1e90ff;"></i>
            <?= $editItem ? 'Edit MoU Document' : 'Upload New MoU (PDF)' ?>
        </h3>

        <form action="mou.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
                <input type="hidden" name="existing_file" value="<?= htmlspecialchars($editItem['file_path']) ?>">
            <?php endif; ?>

            <!-- Row 1 -->
            <div style="display: grid; grid-template-columns: 2fr 1.5fr 1.2fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">MoU Title <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. MoU with Larsen &amp; Toubro Edutech" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Partner Organization</label>
                    <input type="text" name="partner_organization" class="form-control" placeholder="e.g. L&amp;T Edutech, Gujarat Gas" value="<?= htmlspecialchars($editItem['partner_organization'] ?? '') ?>">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-control">
                        <option value="Industry Collaboration" <?= ($editItem && $editItem['category'] === 'Industry Collaboration') ? 'selected' : '' ?>>Industry Collaboration</option>
                        <option value="Academic &amp; University" <?= ($editItem && $editItem['category'] === 'Academic & University') ? 'selected' : '' ?>>Academic &amp; University</option>
                        <option value="Government &amp; Research" <?= ($editItem && $editItem['category'] === 'Government & Research') ? 'selected' : '' ?>>Government &amp; Research</option>
                        <option value="Skill &amp; Training" <?= ($editItem && $editItem['category'] === 'Skill & Training') ? 'selected' : '' ?>>Skill &amp; Training</option>
                    </select>
                </div>
            </div>

            <!-- Row 2 -->
            <div style="display: grid; grid-template-columns: 1fr 2fr 1fr 1fr; gap: 16px; margin-bottom: 20px; align-items: flex-start;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Validity Period / Date</label>
                    <input type="text" name="validity_period" class="form-control" placeholder="e.g. 2024 - 2027" value="<?= htmlspecialchars($editItem['validity_period'] ?? '') ?>">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Signed MoU PDF <?= $editItem ? '' : '<span style="color: #ef4444;">*</span>' ?></label>
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
                    <i class="fas fa-save"></i> <?= $editItem ? 'Update MoU' : 'Upload MoU PDF' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="mou.php" class="btn btn-secondary" style="padding: 8px 18px; font-size: 13px;">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table Header & Search -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 12px;">
        <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">Active Memorandums of Understanding (<?= count($mous) ?>)</h3>
        <div style="width: 260px;">
            <input type="text" class="form-control" placeholder="Search MoUs..." data-table-search="mousTable" style="height: 36px; font-size: 13px;">
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table" id="mousTable" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>MoU Title</th>
                    <th>Partner Organization</th>
                    <th>Category</th>
                    <th>Validity</th>
                    <th style="width: 90px;">Status</th>
                    <th style="width: 110px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($mous)): ?>
                    <tr class="no-records-row">
                        <td colspan="7" style="text-align: center; padding: 32px; color: #64748b;">
                            <i class="fas fa-handshake" style="font-size: 28px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                            No MoU documents uploaded yet. Use the form above to add one.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($mous as $idx => $m): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($m['title']) ?></td>
                            <td><?= htmlspecialchars($m['partner_organization'] ?? '-') ?></td>
                            <td>
                                <span style="background: #f0fdf4; color: #166534; padding: 2px 7px; border-radius: 4px; font-size: 11.5px; font-weight: 600;">
                                    <?= htmlspecialchars($m['category'] ?? 'Industry') ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($m['validity_period'] ?? '-') ?></td>
                            <td>
                                <form action="mou.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                    <input type="hidden" name="status" value="<?= $m['is_active'] ?>">
                                    <button type="submit" style="border: none; background: none; cursor: pointer;">
                                        <?= ($m['is_active'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>' ?>
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: right;">
                                <a href="../<?= htmlspecialchars($m['file_path']) ?>" target="_blank" class="btn btn-sm btn-info" style="padding: 3px 7px;" title="View PDF">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <a href="mou.php?edit=<?= $m['id'] ?>" class="btn btn-sm btn-warning" style="padding: 3px 7px;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="mou.php" method="POST" style="display: inline;" onsubmit="return confirm('Delete this MoU document?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $m['id'] ?>">
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
