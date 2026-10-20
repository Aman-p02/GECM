<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? 'Welcome to <br> Government Engineering College, Modasa');
        $subtitle = trim($_POST['subtitle'] ?? 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi');
        $label = trim($_POST['label'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        // Handle image upload from PC
        $upload = handleImageUpload('slide_file', 'hero', null, $_POST['image_url'] ?? null);
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: hero.php');
            exit;
        }
        $image_url = $upload['path'];

        if (!empty($image_url)) {
            $stmt = $pdo->prepare("INSERT INTO hero_slides (title, subtitle, image_url, label, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $subtitle, $image_url, $label, $display_order, $is_active]);
            setFlashMessage('success', 'Hero slide added successfully!');
            header('Location: hero.php');
            exit;
        } else {
            setFlashMessage('danger', 'Slide image is required.');
        }
    } elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
        $title = trim($_POST['title'] ?? '');
        $subtitle = trim($_POST['subtitle'] ?? '');
        $label = trim($_POST['label'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existingImage = trim($_POST['existing_image'] ?? '');

        // Handle image upload from PC (keeps existing if no new file selected)
        $upload = handleImageUpload('slide_file', 'hero', $existingImage, $_POST['image_url'] ?? null);
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: hero.php');
            exit;
        }
        $image_url = $upload['path'];

        if (!empty($image_url) && $id > 0) {
            $stmt = $pdo->prepare("UPDATE hero_slides SET title = ?, subtitle = ?, image_url = ?, label = ?, display_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $subtitle, $image_url, $label, $display_order, $is_active, $id]);
            setFlashMessage('success', 'Hero slide updated successfully!');
            header('Location: hero.php');
            exit;
        }
    }
}

// Handle GET Actions
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM hero_slides WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Slide deleted successfully!');
        header('Location: hero.php');
        exit;
    }
}

if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE hero_slides SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('info', 'Slide status updated!');
        header('Location: hero.php');
        exit;
    }
}

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM hero_slides WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

// Fetch all slides
$slides = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM hero_slides ORDER BY display_order ASC, id ASC");
    $slides = $stmt->fetchAll();
}

$current_page = 'hero';
$page_title = 'Hero Slides Management';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <i class="fas fa-images"></i>
            <h2 class="card-title">Campus Hero Carousel Slides</h2>
        </div>
        <button type="button" class="btn-add-new" onclick="openModal('addSlideModal')">
            <i class="fas fa-plus"></i> Add New Slide
        </button>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="btn-group-export">
            <button type="button" class="btn-export btn-export-excel" data-target-table="heroTable">
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
                <input type="text" class="search-input" placeholder="Search slides..." data-table-search="heroTable">
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="heroTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th style="width: 100px;">Preview</th>
                    <th>Slide Label</th>
                    <th>Image Path</th>
                    <th>Status</th>
                    <th style="width: 120px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($slides as $row): ?>
                <tr data-status="<?= $row['is_active'] ? 'active' : 'inactive' ?>">
                    <td style="font-weight: 700; color: #1e88e5; text-align: center;">#<?= $row['display_order'] ?></td>
                    <td>
                        <img src="<?= htmlspecialchars(getAdminImageSrc($row['image_url'])) ?>" alt="Preview" style="width: 70px; height: 42px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;" onerror="this.src='https://via.placeholder.com/70x42?text=Slide';">
                    </td>
                    <td style="font-weight: 600; color: #1a263d;">
                        <?= htmlspecialchars($row['label']) ?>
                    </td>
                    <td style="font-family: monospace; font-size: 12.5px; color: #666;">
                        <?= htmlspecialchars($row['image_url']) ?>
                    </td>
                    <td>
                        <a href="hero.php?toggle=<?= $row['id'] ?>" title="Click to toggle status">
                            <?php if ($row['is_active']): ?>
                                <span class="badge badge-success"><i class="fas fa-check"></i> Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><i class="fas fa-eye-slash"></i> Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <div class="table-actions" style="justify-content: center;">
                            <a href="hero.php?edit=<?= $row['id'] ?>" class="btn-table-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="hero.php?delete=<?= $row['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Are you sure you want to delete this slide?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($slides)): ?>
                <tr class="no-records-row">
                    <td colspan="6" style="text-align: center; color: #888; padding: 30px;">No slides added yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add New Slide -->
<div class="modal-overlay" id="addSlideModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-plus-circle" style="color: #1e88e5;"></i> Add Campus Slide</h3>
            <button type="button" class="modal-close" onclick="closeModal('addSlideModal')">&times;</button>
        </div>
        <form method="POST" action="hero.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="label">Slide Label <span class="required">*</span></label>
                    <input type="text" name="label" id="label" class="form-control" placeholder="e.g. Main Campus & Admin Block" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="slide_file">Upload Slide Image from PC <span class="required">*</span></label>
                    <input type="file" name="slide_file" id="slide_file" class="form-control" accept="image/*" required>
                    <div style="font-size: 11.5px; color: #6c757d; margin-top: 5px;">
                        Choose image file (WEBP, JPG, PNG) from your PC, or specify path/URL below:
                    </div>
                    <input type="text" name="image_url" id="image_url" class="form-control" placeholder="Or local path / URL (e.g. images/hero_campus_1.webp)" style="margin-top: 6px;">
                </div>

                <div class="form-group">
                    <label class="form-label" for="title">Title Overlay (HTML allowed)</label>
                    <input type="text" name="title" id="title" class="form-control" value="Welcome to <br> Government Engineering College, Modasa">
                </div>

                <div class="form-group">
                    <label class="form-label" for="subtitle">Subtitle</label>
                    <input type="text" name="subtitle" id="subtitle" class="form-control" value="Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="display_order">Display Order</label>
                        <input type="number" name="display_order" id="display_order" class="form-control" value="<?= count($slides) + 1 ?>" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Slide is Active</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addSlideModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Add Slide</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Slide -->
<?php if ($editItem): ?>
<div class="modal-overlay active" id="editSlideModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-edit" style="color: #1e88e5;"></i> Edit Slide #<?= $editItem['id'] ?></h3>
            <a href="hero.php" class="modal-close">&times;</a>
        </div>
        <form method="POST" action="hero.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <input type="hidden" name="existing_image" value="<?= htmlspecialchars($editItem['image_url']) ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_label">Slide Label <span class="required">*</span></label>
                    <input type="text" name="label" id="edit_label" class="form-control" value="<?= htmlspecialchars($editItem['label']) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Current Slide Image</label>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <img src="<?= htmlspecialchars(getAdminImageSrc($editItem['image_url'])) ?>" alt="Current" style="width: 80px; height: 48px; border-radius: 4px; object-fit: cover; border: 1px solid #ddd;">
                        <span style="font-size: 12px; color: #666; font-family: monospace;"><?= htmlspecialchars($editItem['image_url']) ?></span>
                    </div>
                    <label class="form-label" for="edit_slide_file">Upload New Image from PC (optional)</label>
                    <input type="file" name="slide_file" id="edit_slide_file" class="form-control" accept="image/*">
                    <input type="text" name="image_url" id="edit_image_url" class="form-control" value="<?= htmlspecialchars($editItem['image_url']) ?>" placeholder="Or path / URL" style="margin-top: 6px;">
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_title">Title Overlay</label>
                    <input type="text" name="title" id="edit_title" class="form-control" value="<?= htmlspecialchars($editItem['title']) ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_subtitle">Subtitle</label>
                    <input type="text" name="subtitle" id="edit_subtitle" class="form-control" value="<?= htmlspecialchars($editItem['subtitle']) ?>">
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
                        <span>Slide is Active</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="hero.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
