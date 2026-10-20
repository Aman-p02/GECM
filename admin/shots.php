<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        // Handle image upload from PC
        $upload = handleImageUpload('shot_file', 'shots', null, $_POST['image_url'] ?? null);
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: shots.php');
            exit;
        }

        $image_url = $upload['path'];

        if (!empty($title) && !empty($image_url)) {
            $stmt = $pdo->prepare("INSERT INTO latest_shots (title, description, image_url, display_order, is_active) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $image_url, $display_order, $is_active]);
            setFlashMessage('success', 'Campus shot added successfully!');
            header('Location: shots.php');
            exit;
        } else {
            setFlashMessage('danger', 'Shot title and image are required.');
        }
    } elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $existingImage = trim($_POST['existing_image'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        // Handle image upload from PC (keeps existing if no new file selected)
        $upload = handleImageUpload('shot_file', 'shots', $existingImage, $_POST['image_url'] ?? null);
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: shots.php?edit=' . $id);
            exit;
        }

        $image_url = $upload['path'];

        if (!empty($title) && !empty($image_url) && $id > 0) {
            $stmt = $pdo->prepare("UPDATE latest_shots SET title = ?, description = ?, image_url = ?, display_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $description, $image_url, $display_order, $is_active, $id]);
            setFlashMessage('success', 'Campus shot updated successfully!');
            header('Location: shots.php');
            exit;
        }
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM latest_shots WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Shot deleted successfully!');
        header('Location: shots.php');
        exit;
    }
}

if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE latest_shots SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('info', 'Shot status updated!');
        header('Location: shots.php');
        exit;
    }
}

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM latest_shots WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

$shots = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM latest_shots ORDER BY display_order ASC, id ASC");
    $shots = $stmt->fetchAll();
}

$current_page = 'shots';
$page_title = 'Latest Shots Management';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <i class="fas fa-camera-retro"></i>
            <h2 class="card-title">Latest Shots / Campus Gallery</h2>
        </div>
        <button type="button" class="btn-add-new" onclick="openModal('addShotModal')">
            <i class="fas fa-plus"></i> Add New Shot
        </button>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="btn-group-export">
            <button type="button" class="btn-export btn-export-excel" data-target-table="shotsTable">
                <i class="fas fa-file-excel"></i> Excel
            </button>
            <button type="button" class="btn-export btn-export-pdf">
                <i class="fas fa-file-pdf"></i> PDF
            </button>
            <button type="button" class="btn-export btn-export-print">
                <i class="fas fa-print"></i> Print
            </button>
        </div>

        <div class="card-filters">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search shots..." data-table-search="shotsTable">
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="shotsTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th style="width: 90px;">Thumbnail</th>
                    <th>Shot Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th style="width: 120px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shots as $row): ?>
                <tr data-status="<?= $row['is_active'] ? 'active' : 'inactive' ?>">
                    <td style="font-weight: 700; color: #1e88e5; text-align: center;">#<?= $row['display_order'] ?></td>
                    <td>
                        <img src="<?= htmlspecialchars(getAdminImageSrc($row['image_url'])) ?>" alt="Shot" style="width: 60px; height: 42px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;" onerror="this.src='https://via.placeholder.com/60x42?text=Shot';">
                    </td>
                    <td style="font-weight: 600; color: #1a263d;">
                        <?= htmlspecialchars($row['title']) ?>
                    </td>
                    <td style="max-width: 320px; color: #666; font-size: 13px;">
                        <?= htmlspecialchars($row['description']) ?>
                    </td>
                    <td>
                        <a href="shots.php?toggle=<?= $row['id'] ?>" title="Click to toggle status">
                            <?php if ($row['is_active']): ?>
                                <span class="badge badge-success"><i class="fas fa-check"></i> Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><i class="fas fa-eye-slash"></i> Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <div class="table-actions" style="justify-content: center;">
                            <a href="shots.php?edit=<?= $row['id'] ?>" class="btn-table-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="shots.php?delete=<?= $row['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Delete this shot?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($shots)): ?>
                <tr class="no-records-row">
                    <td colspan="6" style="text-align: center; color: #888; padding: 30px;">No shots found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add New Shot -->
<div class="modal-overlay" id="addShotModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-plus-circle" style="color: #1e88e5;"></i> Add Campus Shot</h3>
            <button type="button" class="modal-close" onclick="closeModal('addShotModal')">&times;</button>
        </div>
        <form method="POST" action="shots.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="title">Title <span class="required">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="e.g. Robotics & Innovation" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Short Description <span class="required">*</span></label>
                    <textarea name="description" id="description" class="form-control" placeholder="e.g. Students demonstrating autonomous robotics..." required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="shot_file">Upload Shot from PC <span class="required">*</span></label>
                    <input type="file" name="shot_file" id="shot_file" class="form-control" accept="image/*" required>
                    <small style="color: #777; font-size: 12px; display: block; margin-top: 4px;">
                        Choose image file (WEBP, JPG, PNG) from your PC, or specify URL below:
                    </small>
                    <input type="text" name="image_url" id="image_url" class="form-control" placeholder="Or enter image URL (optional fallback)" style="margin-top: 6px;">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="display_order">Display Order</label>
                        <input type="number" name="display_order" id="display_order" class="form-control" value="<?= count($shots) + 1 ?>" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Display on Homepage</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addShotModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Add Shot</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Shot -->
<?php if ($editItem): ?>
<div class="modal-overlay active" id="editShotModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-edit" style="color: #1e88e5;"></i> Edit Shot #<?= $editItem['id'] ?></h3>
            <a href="shots.php" class="modal-close">&times;</a>
        </div>
        <form method="POST" action="shots.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <input type="hidden" name="existing_image" value="<?= htmlspecialchars($editItem['image_url']) ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_title">Title <span class="required">*</span></label>
                    <input type="text" name="title" id="edit_title" class="form-control" value="<?= htmlspecialchars($editItem['title']) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_description">Short Description <span class="required">*</span></label>
                    <textarea name="description" id="edit_description" class="form-control" required><?= htmlspecialchars($editItem['description']) ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Current Shot Image</label>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <img src="<?= htmlspecialchars(getAdminImageSrc($editItem['image_url'])) ?>" alt="Current Shot" style="width: 80px; height: 50px; border-radius: 4px; object-fit: cover; border: 1px solid #ddd;">
                        <span style="font-size: 12px; color: #666; font-family: monospace;"><?= htmlspecialchars($editItem['image_url']) ?></span>
                    </div>
                    <label class="form-label" for="edit_shot_file">Upload New Image from PC (optional)</label>
                    <input type="file" name="shot_file" id="edit_shot_file" class="form-control" accept="image/*">
                    <input type="text" name="image_url" id="edit_image_url" class="form-control" value="<?= htmlspecialchars($editItem['image_url']) ?>" placeholder="Or image URL" style="margin-top: 6px;">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_display_order">Display Order</label>
                        <input type="number" name="display_order" id="edit_display_order" class="form-control" value="<?= $editItem['display_order'] ?>" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                        <span>Display on Homepage</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="shots.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
