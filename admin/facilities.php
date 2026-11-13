<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage Campus Facilities";
$current_page = 'facilities';

$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: facilities.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $short_desc = trim($_POST['short_desc'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title)) {
            setFlashMessage('danger', 'Facility title is required.');
            header('Location: facilities.php');
            exit;
        }

        $image_path = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload = handleImageUpload('photo', 'facilities');
            if ($upload['success']) {
                $image_path = $upload['path'];
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: facilities.php');
                exit;
            }
        }

        $stmt = $pdo->prepare("INSERT INTO campus_facilities (title, short_desc, image_path, display_order, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $short_desc, $image_path, $display_order, $is_active]);

        setFlashMessage('success', 'Campus facility added successfully!');
        header('Location: facilities.php');
        exit;

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $short_desc = trim($_POST['short_desc'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_image = trim($_POST['existing_image'] ?? '');

        if (empty($title) || $id <= 0) {
            setFlashMessage('danger', 'Valid ID and facility title are required.');
            header('Location: facilities.php');
            exit;
        }

        $image_path = $existing_image;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload = handleImageUpload('photo', 'facilities', $existing_image);
            if ($upload['success']) {
                $image_path = $upload['path'];
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: facilities.php?edit=' . $id);
                exit;
            }
        }

        $stmt = $pdo->prepare("UPDATE campus_facilities SET title = ?, short_desc = ?, image_path = ?, display_order = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$title, $short_desc, $image_path, $display_order, $is_active, $id]);

        setFlashMessage('success', 'Campus facility updated successfully!');
        header('Location: facilities.php');
        exit;

    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("SELECT image_path FROM campus_facilities WHERE id = ?");
            $stmt->execute([$id]);
            $item = $stmt->fetch();
            if ($item && !empty($item['image_path'])) {
                $realFile = realpath(__DIR__ . '/../' . $item['image_path']);
                if ($realFile && file_exists($realFile)) {
                    @unlink($realFile);
                }
            }
            $pdo->prepare("DELETE FROM campus_facilities WHERE id = ?")->execute([$id]);
            setFlashMessage('success', 'Facility deleted successfully.');
        }
        header('Location: facilities.php');
        exit;

    } elseif ($action === 'toggle_status') {
        $id = (int)($_POST['id'] ?? 0);
        $status = (int)($_POST['status'] ?? 0);
        $new_status = ($status === 1) ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE campus_facilities SET is_active = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
        setFlashMessage('success', 'Facility status updated.');
        header('Location: facilities.php');
        exit;
    }
}

// Fetch facility for editing
if (isset($_GET['edit']) && (int)$_GET['edit'] > 0 && $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM campus_facilities WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editItem = $stmt->fetch();
}

// Fetch all facilities
$facilities = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM campus_facilities ORDER BY display_order ASC, id DESC");
    $facilities = $stmt->fetchAll();
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 24px;">
    <!-- Top Action Bar (No Duplicate Title) -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 14px; margin-bottom: 22px; flex-wrap: wrap; gap: 12px;">
        <p style="font-size: 13.5px; color: #64748b; margin: 0;">Add and manage campus facilities (Library, Hostels, Labs, Sports Complex, etc.).</p>
        <a href="../overview.php#facilities" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; font-size: 12.5px;">
            <i class="fas fa-external-link-alt"></i> View on Website
        </a>
    </div>

    <!-- Facility Form -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas <?= $editItem ? 'fa-edit' : 'fa-plus-circle' ?>" style="color: #1e90ff;"></i>
            <?= $editItem ? 'Edit Campus Facility' : 'Add New Campus Facility' ?>
        </h3>

        <form action="facilities.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
                <input type="hidden" name="existing_image" value="<?= htmlspecialchars($editItem['image_path'] ?? '') ?>">
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Facility Title <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Central Library, Hostels, Sports Complex" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Display Priority Order</label>
                    <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order'] ?? '0') ?>">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label">Description &amp; Key Features</label>
                <textarea name="short_desc" class="form-control" rows="3" placeholder="Brief details about the facility, equipment, seating capacity, access hours..."><?= htmlspecialchars($editItem['short_desc'] ?? '') ?></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 20px; align-items: flex-start;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Facility Photo</label>
                    <input type="file" name="photo" class="form-control" accept="image/*" style="padding: 5px 8px; font-size: 13px;">
                    <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">JPG, PNG, or WebP. Optimal size: 800x600px.</div>
                    <?php if ($editItem && !empty($editItem['image_path'])): ?>
                        <div style="margin-top: 6px;">
                            <img src="../<?= htmlspecialchars($editItem['image_path']) ?>" alt="" style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;">
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
                    <i class="fas fa-save"></i> <?= $editItem ? 'Update Facility' : 'Add Facility' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="facilities.php" class="btn btn-secondary" style="padding: 8px 18px; font-size: 13px;">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Facilities Table -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
        <h3 style="font-size: 17px; font-weight: 700; color: #1e293b; margin: 0;">Registered Campus Facilities (<?= count($facilities) ?>)</h3>
        <div style="width: 280px;">
            <input type="text" class="form-control" placeholder="Search facilities..." data-table-search="facilitiesTable">
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table" id="facilitiesTable" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 70px;">Photo</th>
                    <th>Facility Title</th>
                    <th>Description</th>
                    <th style="width: 80px;">Order</th>
                    <th style="width: 100px;">Status</th>
                    <th style="width: 120px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($facilities)): ?>
                    <tr class="no-records-row">
                        <td colspan="6" style="text-align: center; padding: 36px; color: #64748b;">
                            <i class="fas fa-building" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                            No campus facilities added yet. Use the form above to add one.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($facilities as $fac): ?>
                        <tr>
                            <td>
                                <?php if (!empty($fac['image_path'])): ?>
                                    <img src="../<?= htmlspecialchars($fac['image_path']) ?>" alt="" style="width: 55px; height: 38px; object-fit: cover; border-radius: 4px; border: 1px solid #e2e8f0;">
                                <?php else: ?>
                                    <div style="width: 55px; height: 38px; background: #f1f5f9; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 11px;">No Img</div>
                                <?php endif; ?>
                            </td>
                            <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($fac['title']) ?></td>
                            <td style="color: #64748b; font-size: 13px; max-width: 320px;"><?= htmlspecialchars(mb_strimwidth($fac['short_desc'] ?? '', 0, 90, '...')) ?></td>
                            <td><?= (int)$fac['display_order'] ?></td>
                            <td>
                                <form action="facilities.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= $fac['id'] ?>">
                                    <input type="hidden" name="status" value="<?= $fac['is_active'] ?>">
                                    <button type="submit" style="border: none; background: none; cursor: pointer;">
                                        <?= ($fac['is_active'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>' ?>
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: right;">
                                <a href="facilities.php?edit=<?= $fac['id'] ?>" class="btn btn-sm btn-warning" style="padding: 4px 8px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="facilities.php" method="POST" style="display: inline;" onsubmit="return confirm('Delete this facility?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $fac['id'] ?>">
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

