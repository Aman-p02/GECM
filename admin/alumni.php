<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $branch = trim($_POST['branch'] ?? '');
        $graduation_year = (int)($_POST['graduation_year'] ?? date('Y'));
        $company = trim($_POST['company'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        // Handle image file upload from PC
        $upload = handleImageUpload('photo_file', 'alumni', null, $_POST['photo_url'] ?? null);

        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: alumni.php');
            exit;
        }

        $photo_url = $upload['path'];

        if (!empty($name) && !empty($company) && !empty($photo_url)) {
            $stmt = $pdo->prepare("INSERT INTO alumni (name, branch, graduation_year, company, photo_url, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $branch, $graduation_year, $company, $photo_url, $display_order, $is_active]);
            setFlashMessage('success', 'Alumni record added successfully!');
            header('Location: alumni.php');
            exit;
        } else {
            setFlashMessage('danger', 'Name, company, and photo are required.');
        }
    } elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
        $name = trim($_POST['name'] ?? '');
        $branch = trim($_POST['branch'] ?? '');
        $graduation_year = (int)($_POST['graduation_year'] ?? date('Y'));
        $company = trim($_POST['company'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existingPhoto = trim($_POST['existing_photo'] ?? '');

        // Handle image file upload from PC (keeps existing if no new file uploaded)
        $upload = handleImageUpload('photo_file', 'alumni', $existingPhoto, $_POST['photo_url'] ?? null);

        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: alumni.php');
            exit;
        }

        $photo_url = $upload['path'];

        if (!empty($name) && !empty($company) && !empty($photo_url) && $id > 0) {
            $stmt = $pdo->prepare("UPDATE alumni SET name = ?, branch = ?, graduation_year = ?, company = ?, photo_url = ?, display_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$name, $branch, $graduation_year, $company, $photo_url, $display_order, $is_active, $id]);
            setFlashMessage('success', 'Alumni record updated successfully!');
            header('Location: alumni.php');
            exit;
        }
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM alumni WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Alumni record deleted!');
        header('Location: alumni.php');
        exit;
    }
}

if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE alumni SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('info', 'Alumni status toggled!');
        header('Location: alumni.php');
        exit;
    }
}

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM alumni WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

$alumniList = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM alumni ORDER BY display_order ASC, id ASC");
    $alumniList = $stmt->fetchAll();
}

$current_page = 'alumni';
$page_title = 'Manage Alumni';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <i class="fas fa-user-graduate"></i>
            <h2 class="card-title">Manage Notable Alumni</h2>
        </div>
        <button type="button" class="btn-add-new" onclick="openModal('addAlumniModal')">
            <i class="fas fa-plus"></i> Add Notable Alumni
        </button>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="btn-group-export">
            <button type="button" class="btn-export btn-export-excel" data-target-table="alumniTable">
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
                <input type="text" class="search-input" placeholder="Search alumni..." data-table-search="alumniTable">
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="alumniTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th style="width: 70px;">Photo</th>
                    <th>Alumni Name</th>
                    <th>Branch</th>
                    <th>Batch</th>
                    <th>Current Company</th>
                    <th>Status</th>
                    <th style="width: 120px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alumniList as $row): ?>
                <tr data-status="<?= $row['is_active'] ? 'active' : 'inactive' ?>">
                    <td style="font-weight: 700; color: #1e88e5; text-align: center;">#<?= $row['display_order'] ?></td>
                    <td>
                        <img src="<?= htmlspecialchars(getAdminImageSrc($row['photo_url'])) ?>" alt="Photo" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;" onerror="this.src='https://via.placeholder.com/40?text=A';">
                    </td>
                    <td style="font-weight: 600; color: #1a263d;">
                        <?= htmlspecialchars($row['name']) ?>
                    </td>
                    <td><?= htmlspecialchars($row['branch']) ?></td>
                    <td><span class="badge badge-secondary"><?= $row['graduation_year'] ?></span></td>
                    <td style="color: #1e88e5; font-weight: 500;">
                        <i class="fas fa-building" style="color: #666; margin-right: 5px;"></i>
                        <?= htmlspecialchars($row['company']) ?>
                    </td>
                    <td>
                        <a href="alumni.php?toggle=<?= $row['id'] ?>" title="Click to toggle status">
                            <?php if ($row['is_active']): ?>
                                <span class="badge badge-success"><i class="fas fa-check"></i> Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><i class="fas fa-eye-slash"></i> Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <div class="table-actions" style="justify-content: center;">
                            <a href="alumni.php?edit=<?= $row['id'] ?>" class="btn-table-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="alumni.php?delete=<?= $row['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Delete this alumni record?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($alumniList)): ?>
                <tr class="no-records-row">
                    <td colspan="8" style="text-align: center; color: #888; padding: 30px;">No alumni records found. Click "Add Notable Alumni" to upload from your PC.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add Alumni -->
<div class="modal-overlay" id="addAlumniModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-plus-circle" style="color: #1e88e5;"></i> Add Notable Alumni</h3>
            <button type="button" class="modal-close" onclick="closeModal('addAlumniModal')">&times;</button>
        </div>
        <form method="POST" action="alumni.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="name">Alumni Full Name <span class="required">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Rahul Sharma" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="branch">Engineering Branch <span class="required">*</span></label>
                        <input type="text" name="branch" id="branch" class="form-control" placeholder="e.g. Computer Engg." required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="graduation_year">Graduation Year <span class="required">*</span></label>
                        <input type="number" name="graduation_year" id="graduation_year" class="form-control" value="2020" min="1980" max="2030" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="company">Current Company & Designation <span class="required">*</span></label>
                    <input type="text" name="company" id="company" class="form-control" placeholder="e.g. Google, USA" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="photo_file">Profile Photo from PC <span class="required">*</span></label>
                    <input type="file" name="photo_file" id="photo_file" class="form-control" accept="image/*" required>
                    <div style="font-size: 11.5px; color: #6c757d; margin-top: 5px;">
                        Select photo (JPG, PNG, WEBP) directly from your computer, or paste URL below if hosted online:
                    </div>
                    <input type="text" name="photo_url" id="photo_url" class="form-control" placeholder="Optional external image URL (https://...)" style="margin-top: 6px;">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="display_order">Display Order</label>
                        <input type="number" name="display_order" id="display_order" class="form-control" value="<?= count($alumniList) + 1 ?>" min="1">
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
                <button type="button" class="btn-secondary" onclick="closeModal('addAlumniModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Add Alumni</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Alumni -->
<?php if ($editItem): ?>
<div class="modal-overlay active" id="editAlumniModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-edit" style="color: #1e88e5;"></i> Edit Alumni</h3>
            <a href="alumni.php" class="modal-close">&times;</a>
        </div>
        <form method="POST" action="alumni.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <input type="hidden" name="existing_photo" value="<?= htmlspecialchars($editItem['photo_url']) ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_name">Alumni Full Name <span class="required">*</span></label>
                    <input type="text" name="name" id="edit_name" class="form-control" value="<?= htmlspecialchars($editItem['name']) ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_branch">Engineering Branch <span class="required">*</span></label>
                        <input type="text" name="branch" id="edit_branch" class="form-control" value="<?= htmlspecialchars($editItem['branch']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="edit_graduation_year">Graduation Year <span class="required">*</span></label>
                        <input type="number" name="graduation_year" id="edit_graduation_year" class="form-control" value="<?= $editItem['graduation_year'] ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_company">Current Company & Designation <span class="required">*</span></label>
                    <input type="text" name="company" id="edit_company" class="form-control" value="<?= htmlspecialchars($editItem['company']) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Current Photo</label>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <img src="<?= htmlspecialchars(getAdminImageSrc($editItem['photo_url'])) ?>" alt="Current" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">
                        <span style="font-size: 12px; color: #666; font-family: monospace;"><?= htmlspecialchars($editItem['photo_url']) ?></span>
                    </div>
                    <label class="form-label" for="edit_photo_file">Upload New Photo from PC (optional)</label>
                    <input type="file" name="photo_file" id="edit_photo_file" class="form-control" accept="image/*">
                    <input type="text" name="photo_url" id="edit_photo_url" class="form-control" value="<?= htmlspecialchars($editItem['photo_url']) ?>" placeholder="Or external photo URL" style="margin-top: 6px;">
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
                <a href="alumni.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
