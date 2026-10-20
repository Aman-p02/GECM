<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $category = trim($_POST['category'] ?? 'General');
        $badge = $_POST['badge'] ?? 'None';
        $publish_date = $_POST['publish_date'] ?? date('Y-m-d');
        $link_url = trim($_POST['link_url'] ?? '#');
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!empty($title)) {
            $stmt = $pdo->prepare("INSERT INTO notices (title, category, badge, publish_date, link_url, is_active) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $category, $badge, $publish_date, $link_url, $is_active]);
            setFlashMessage('success', 'Notice added successfully!');
            header('Location: notices.php');
            exit;
        } else {
            setFlashMessage('danger', 'Notice title cannot be empty.');
        }
    } elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
        $title = trim($_POST['title'] ?? '');
        $category = trim($_POST['category'] ?? 'General');
        $badge = $_POST['badge'] ?? 'None';
        $publish_date = $_POST['publish_date'] ?? date('Y-m-d');
        $link_url = trim($_POST['link_url'] ?? '#');
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!empty($title) && $id > 0) {
            $stmt = $pdo->prepare("UPDATE notices SET title = ?, category = ?, badge = ?, publish_date = ?, link_url = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $category, $badge, $publish_date, $link_url, $is_active, $id]);
            setFlashMessage('success', 'Notice updated successfully!');
            header('Location: notices.php');
            exit;
        }
    }
}

// Handle GET Actions (delete, toggle, edit)
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM notices WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Notice deleted successfully!');
        header('Location: notices.php');
        exit;
    }
}

if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE notices SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('info', 'Notice status updated!');
        header('Location: notices.php');
        exit;
    }
}

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM notices WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

// Fetch all notices
$notices = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM notices ORDER BY publish_date DESC, id DESC");
    $notices = $stmt->fetchAll();
}

$current_page = 'notices';
$page_title = 'Notice Board Management';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <i class="fas fa-bullhorn"></i>
            <h2 class="card-title">Manage Notice Board</h2>
        </div>
        <button type="button" class="btn-add-new" onclick="openModal('addNoticeModal')">
            <i class="fas fa-plus"></i> Post New Notice
        </button>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="card-filters" style="margin-left: auto;">
            <select class="filter-select" data-table-filter="noticesTable">
                <option value="all">All Categories</option>
                <option value="Exam">Exam</option>
                <option value="Scholarship">Scholarship</option>
                <option value="Academic">Academic</option>
                <option value="Hostel">Hostel</option>
                <option value="Events">Events</option>
                <option value="General">General</option>
            </select>

            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search notices..." data-table-search="noticesTable">
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="noticesTable">
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th style="width: 120px;">Date <i class="fas fa-sort sort-icon"></i></th>
                    <th>Notice Title <i class="fas fa-sort sort-icon"></i></th>
                    <th>Category</th>
                    <th>Badge</th>
                    <th>Status</th>
                    <th style="width: 120px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notices as $row): ?>
                <tr data-category="<?= htmlspecialchars($row['category']) ?>" data-status="<?= $row['is_active'] ? 'active' : 'inactive' ?>">
                    <td style="color: #888;">#<?= $row['id'] ?></td>
                    <td style="white-space: nowrap; font-weight: 500;"><?= htmlspecialchars($row['publish_date']) ?></td>
                    <td style="font-weight: 500; color: #1a263d;">
                        <?= htmlspecialchars($row['title']) ?>
                        <?php if (!empty($row['link_url']) && $row['link_url'] !== '#'): ?>
                            <a href="<?= htmlspecialchars($row['link_url']) ?>" target="_blank" style="margin-left: 6px; font-size: 12px; color: #1e88e5;">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge badge-secondary"><?= htmlspecialchars($row['category']) ?></span>
                    </td>
                    <td>
                        <?php if ($row['badge'] === 'New'): ?>
                            <span class="badge badge-success">New</span>
                        <?php elseif ($row['badge'] === 'Urgent'): ?>
                            <span class="badge badge-danger">Urgent</span>
                        <?php else: ?>
                            <span style="color: #aaa;">None</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="notices.php?toggle=<?= $row['id'] ?>" title="Click to toggle status">
                            <?php if ($row['is_active']): ?>
                                <span class="badge badge-success"><i class="fas fa-check"></i> Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><i class="fas fa-eye-slash"></i> Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <div class="table-actions" style="justify-content: center;">
                            <a href="notices.php?edit=<?= $row['id'] ?>" class="btn-table-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="notices.php?delete=<?= $row['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Are you sure you want to delete this notice?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($notices)): ?>
                <tr class="no-records-row">
                    <td colspan="7" style="text-align: center; color: #888; padding: 30px;">No notices available. Click "Post New Notice" to add one.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add New Notice -->
<div class="modal-overlay" id="addNoticeModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-plus-circle" style="color: #1e88e5;"></i> Post New Notice</h3>
            <button type="button" class="modal-close" onclick="closeModal('addNoticeModal')">&times;</button>
        </div>
        <form method="POST" action="notices.php">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="title">Notice Title <span class="required">*</span></label>
                    <textarea name="title" id="title" class="form-control" placeholder="Enter clear, concise notice title..." required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="category">Category</label>
                        <select name="category" id="category" class="form-control">
                            <option value="General">General</option>
                            <option value="Exam">Exam</option>
                            <option value="Scholarship">Scholarship</option>
                            <option value="Academic">Academic</option>
                            <option value="Hostel">Hostel</option>
                            <option value="Events">Events</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="badge">Attention Badge</label>
                        <select name="badge" id="badge" class="form-control">
                            <option value="None">None</option>
                            <option value="New">New</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="publish_date">Publish Date</label>
                        <input type="date" name="publish_date" id="publish_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="link_url">External / PDF Link</label>
                        <input type="text" name="link_url" id="link_url" class="form-control" placeholder="Optional link or #" value="#">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Publish immediately (Active)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addNoticeModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Post Notice</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Notice -->
<?php if ($editItem): ?>
<div class="modal-overlay active" id="editNoticeModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-edit" style="color: #1e88e5;"></i> Edit Notice #<?= $editItem['id'] ?></h3>
            <a href="notices.php" class="modal-close">&times;</a>
        </div>
        <form method="POST" action="notices.php">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_title">Notice Title <span class="required">*</span></label>
                    <textarea name="title" id="edit_title" class="form-control" required><?= htmlspecialchars($editItem['title']) ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_category">Category</label>
                        <select name="category" id="edit_category" class="form-control">
                            <?php foreach (['General', 'Exam', 'Scholarship', 'Academic', 'Hostel', 'Events'] as $cat): ?>
                                <option value="<?= $cat ?>" <?= ($editItem['category'] === $cat) ? 'selected' : '' ?>><?= $cat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="edit_badge">Attention Badge</label>
                        <select name="badge" id="edit_badge" class="form-control">
                            <option value="None" <?= ($editItem['badge'] === 'None') ? 'selected' : '' ?>>None</option>
                            <option value="New" <?= ($editItem['badge'] === 'New') ? 'selected' : '' ?>>New</option>
                            <option value="Urgent" <?= ($editItem['badge'] === 'Urgent') ? 'selected' : '' ?>>Urgent</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_publish_date">Publish Date</label>
                        <input type="date" name="publish_date" id="edit_publish_date" class="form-control" value="<?= htmlspecialchars($editItem['publish_date']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="edit_link_url">External / PDF Link</label>
                        <input type="text" name="link_url" id="edit_link_url" class="form-control" value="<?= htmlspecialchars($editItem['link_url']) ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                        <span>Notice is Active</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="notices.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
