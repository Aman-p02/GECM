<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

// Self-healing database table setup
if ($pdo) {
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `student_chapters` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `title` VARCHAR(255) NOT NULL,
            `description` TEXT DEFAULT NULL,
            `image_url` VARCHAR(500) DEFAULT NULL,
            `display_order` INT NOT NULL DEFAULT 0,
            `is_active` TINYINT(1) NOT NULL DEFAULT 1,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_sc_status_order` (`is_active`, `display_order`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    } catch (Exception $e) {
        error_log("Error creating student_chapters table: " . $e->getMessage());
    }
}

// Handle Form Submissions (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: student-chapters.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title)) {
            setFlashMessage('danger', 'Chapter title is required.');
            header('Location: student-chapters.php');
            exit;
        }

        // Process image upload from PC or optional URL fallback
        $upload = handleImageUpload('image_file', 'student_chapters', null, $_POST['image_url'] ?? null);
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: student-chapters.php');
            exit;
        }

        $image_url = $upload['path'];

        $stmt = $pdo->prepare("INSERT INTO student_chapters (title, description, image_url, display_order, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $image_url, $display_order, $is_active]);

        setFlashMessage('success', 'Student Chapter added successfully!');
        header('Location: student-chapters.php');
        exit;

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $existingImage = trim($_POST['existing_image'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title) || $id <= 0) {
            setFlashMessage('danger', 'Valid Chapter ID and title are required.');
            header('Location: student-chapters.php');
            exit;
        }

        // Process image upload or retain existing image
        $upload = handleImageUpload('image_file', 'student_chapters', $existingImage, $_POST['image_url'] ?? null);
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: student-chapters.php?edit=' . $id);
            exit;
        }

        $image_url = $upload['path'];

        $stmt = $pdo->prepare("UPDATE student_chapters SET title = ?, description = ?, image_url = ?, display_order = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$title, $description, $image_url, $display_order, $is_active, $id]);

        setFlashMessage('success', 'Student Chapter updated successfully!');
        header('Location: student-chapters.php');
        exit;
    }
}

// Handle GET Actions (Delete, Toggle, Edit)
if (isset($_GET['delete'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP.');
        header('Location: student-chapters.php');
        exit;
    }
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT image_url FROM student_chapters WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row && !empty($row['image_url'])) {
            $realFile = realpath(__DIR__ . '/../' . $row['image_url']);
            if ($realFile && file_exists($realFile)) {
                @unlink($realFile);
            }
        }
        $stmt = $pdo->prepare("DELETE FROM student_chapters WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Student Chapter deleted successfully!');
        header('Location: student-chapters.php');
        exit;
    }
}

if (isset($_GET['toggle'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP.');
        header('Location: student-chapters.php');
        exit;
    }
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE student_chapters SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('info', 'Chapter status updated successfully!');
        header('Location: student-chapters.php');
        exit;
    }
}

if (isset($_GET['edit']) && $pdo) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM student_chapters WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

// Fetch all chapters
$chapters = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM student_chapters ORDER BY display_order ASC, id ASC");
        $chapters = $stmt->fetchAll();
    } catch (Exception $e) {
        $chapters = [];
    }
}

$current_page = 'student-chapters';
$page_title = 'Student Chapters';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <h2 class="card-title">Student Chapters &amp; Clubs</h2>
            <p style="font-size: 13.5px; color: #64748b; margin: 4px 0 0 0;">
                Manage student technical chapters, clubs, photos, and descriptions.
            </p>
        </div>
        <button type="button" class="btn-add-new" onclick="openModal('addChapterModal')">
            <i class="fas fa-plus"></i> Add New Chapter
        </button>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="card-filters" style="margin-left: auto;">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search chapters..." data-table-search="chaptersTable">
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="chaptersTable">
            <thead>
                <tr>
                    <th style="width: 70px; text-align: center;">Order</th>
                    <th style="width: 100px;">Image</th>
                    <th>Chapter Title</th>
                    <th>Description</th>
                    <th style="width: 110px;">Status</th>
                    <th style="width: 130px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chapters as $row): ?>
                <tr data-status="<?= $row['is_active'] ? 'active' : 'inactive' ?>">
                    <td style="font-weight: 700; color: var(--admin-primary); text-align: center;">#<?= (int)$row['display_order'] ?></td>
                    <td>
                        <img src="<?= htmlspecialchars(getAdminImageSrc($row['image_url'])) ?>"
                             alt="Chapter"
                             style="width: 70px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;"
                             onerror="this.src='https://via.placeholder.com/70x50?text=No+Image';">
                    </td>
                    <td style="font-weight: 600; color: #1a263d;">
                        <?= htmlspecialchars($row['title']) ?>
                    </td>
                    <td style="max-width: 360px; color: #64748b; font-size: 13px; line-height: 1.5;">
                        <?= nl2br(htmlspecialchars(mb_strimwidth($row['description'] ?? '', 0, 160, '...'))) ?>
                    </td>
                    <td>
                        <a href="student-chapters.php?toggle=<?= (int)$row['id'] ?>" title="Click to toggle status" style="text-decoration: none;">
                            <?php if ($row['is_active']): ?>
                                <span class="badge badge-success"><i class="fas fa-check"></i> Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><i class="fas fa-eye-slash"></i> Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <div class="table-actions" style="justify-content: center;">
                            <a href="student-chapters.php?edit=<?= (int)$row['id'] ?>" class="btn-table-action btn-edit" title="Edit Chapter">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="student-chapters.php?delete=<?= (int)$row['id'] ?>" class="btn-table-action btn-delete" title="Delete Chapter" onclick="return confirm('Are you sure you want to delete this chapter?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($chapters)): ?>
                <tr class="no-records-row">
                    <td colspan="6" style="text-align: center; color: #888; padding: 36px 16px;">
                        <div style="font-size: 36px; color: #cbd5e1; margin-bottom: 8px;"><i class="fas fa-users"></i></div>
                        <div style="font-size: 15px; font-weight: 600; color: #475569;">No Student Chapters added yet.</div>
                        <div style="font-size: 13px; color: #94a3b8; margin-top: 4px;">Click the "+ Add New Chapter" button above to upload an image and description.</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add New Chapter -->
<div class="modal-overlay" id="addChapterModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Add Student Chapter</h3>
            <button type="button" class="modal-close" onclick="closeModal('addChapterModal')">&times;</button>
        </div>
        <form method="POST" action="student-chapters.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="add_title">Chapter Title / Name <span class="required">*</span></label>
                    <input type="text" name="title" id="add_title" class="form-control" placeholder="e.g. IEEE Student Branch, ISTE Chapter, Coding Club" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_image_file">Upload Chapter Image from PC <span class="required">*</span></label>
                    <input type="file" name="image_file" id="add_image_file" class="form-control" accept="image/*" required>
                    <div style="font-size: 11.5px; color: #6c757d; margin-top: 5px;">
                        Supported formats: JPG, PNG, WEBP, GIF (Max size: 10MB).
                    </div>
                    <input type="text" name="image_url" id="add_image_url" class="form-control" placeholder="Or enter existing image path / URL (optional fallback)" style="margin-top: 6px;">
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_description">Description / About Chapter</label>
                    <textarea name="description" id="add_description" class="form-control" rows="4" placeholder="Enter chapter objectives, activities, coordinators, and member benefits..."></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="add_display_order">Display Order</label>
                        <input type="number" name="display_order" id="add_display_order" class="form-control" value="<?= count($chapters) + 1 ?>" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Active (Visible on website)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addChapterModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Add Chapter</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Chapter -->
<?php if ($editItem): ?>
<div class="modal-overlay active show" id="editChapterModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Edit Chapter #<?= (int)$editItem['id'] ?></h3>
            <a href="student-chapters.php" class="modal-close">&times;</a>
        </div>
        <form method="POST" action="student-chapters.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
            <input type="hidden" name="existing_image" value="<?= htmlspecialchars($editItem['image_url'] ?? '') ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_title">Chapter Title / Name <span class="required">*</span></label>
                    <input type="text" name="title" id="edit_title" class="form-control" value="<?= htmlspecialchars($editItem['title']) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Current Chapter Image</label>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <img src="<?= htmlspecialchars(getAdminImageSrc($editItem['image_url'])) ?>" alt="Current" style="width: 80px; height: 55px; border-radius: 6px; object-fit: cover; border: 1px solid #ddd;">
                        <span style="font-size: 12px; color: #64748b;"><?= htmlspecialchars($editItem['image_url']) ?></span>
                    </div>
                    <label class="form-label" for="edit_image_file">Upload New Image from PC (optional)</label>
                    <input type="file" name="image_file" id="edit_image_file" class="form-control" accept="image/*">
                    <input type="text" name="image_url" id="edit_image_url" class="form-control" value="<?= htmlspecialchars($editItem['image_url'] ?? '') ?>" placeholder="Or path / URL" style="margin-top: 6px;">
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_description">Description / About Chapter</label>
                    <textarea name="description" id="edit_description" class="form-control" rows="4"><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_display_order">Display Order</label>
                        <input type="number" name="display_order" id="edit_display_order" class="form-control" value="<?= (int)$editItem['display_order'] ?>" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                        <span>Active (Visible on website)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="student-chapters.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
