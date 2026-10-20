<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $code = strtoupper(trim($_POST['code'] ?? ''));
        $icon_class = trim($_POST['icon_class'] ?? 'fas fa-graduation-cap');
        $learn_more_url = trim($_POST['learn_more_url'] ?? '#');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!empty($name) && !empty($code)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO departments (name, code, icon_class, learn_more_url, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $code, $icon_class, $learn_more_url, $display_order, $is_active]);
                setFlashMessage('success', 'Department added successfully!');
                header('Location: departments.php');
                exit;
            } catch (Exception $e) {
                setFlashMessage('danger', 'Error adding department: ' . $e->getMessage());
            }
        } else {
            setFlashMessage('danger', 'Department name and unique code are required.');
        }
    } elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
        $name = trim($_POST['name'] ?? '');
        $code = strtoupper(trim($_POST['code'] ?? ''));
        $icon_class = trim($_POST['icon_class'] ?? 'fas fa-graduation-cap');
        $learn_more_url = trim($_POST['learn_more_url'] ?? '#');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!empty($name) && !empty($code) && $id > 0) {
            try {
                $stmt = $pdo->prepare("UPDATE departments SET name = ?, code = ?, icon_class = ?, learn_more_url = ?, display_order = ?, is_active = ? WHERE id = ?");
                $stmt->execute([$name, $code, $icon_class, $learn_more_url, $display_order, $is_active, $id]);
                setFlashMessage('success', 'Department updated successfully!');
                header('Location: departments.php');
                exit;
            } catch (Exception $e) {
                setFlashMessage('danger', 'Error updating department: ' . $e->getMessage());
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM departments WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Department deleted successfully!');
        header('Location: departments.php');
        exit;
    }
}

if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE departments SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('info', 'Department status toggled!');
        header('Location: departments.php');
        exit;
    }
}

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM departments WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

$departments = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM departments ORDER BY display_order ASC, id ASC");
    $departments = $stmt->fetchAll();
}

$current_page = 'departments';
$page_title = 'Departments Management';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <i class="fas fa-graduation-cap"></i>
            <h2 class="card-title">Manage Engineering Departments</h2>
        </div>
        <button type="button" class="btn-add-new" onclick="openModal('addDeptModal')">
            <i class="fas fa-plus"></i> Add New Department
        </button>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="card-filters" style="margin-left: auto;">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search departments..." data-table-search="deptsTable">
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="deptsTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th style="width: 70px;">Icon</th>
                    <th>Department Name</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th style="width: 120px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $row): ?>
                <tr data-status="<?= $row['is_active'] ? 'active' : 'inactive' ?>">
                    <td style="font-weight: 700; color: #1e88e5; text-align: center;">#<?= $row['display_order'] ?></td>
                    <td style="text-align: center; font-size: 18px; color: #1e88e5;">
                        <i class="<?= htmlspecialchars($row['icon_class']) ?>"></i>
                    </td>
                    <td style="font-weight: 600; color: #1a263d;">
                        <?= htmlspecialchars($row['name']) ?>
                    </td>
                    <td>
                        <span class="badge badge-primary"><?= htmlspecialchars($row['code']) ?></span>
                    </td>
                    <td>
                        <a href="departments.php?toggle=<?= $row['id'] ?>" title="Click to toggle status">
                            <?php if ($row['is_active']): ?>
                                <span class="badge badge-success"><i class="fas fa-check"></i> Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><i class="fas fa-eye-slash"></i> Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <div class="table-actions" style="justify-content: center;">
                            <a href="departments.php?edit=<?= $row['id'] ?>" class="btn-table-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="departments.php?delete=<?= $row['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Delete this department?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($departments)): ?>
                <tr class="no-records-row">
                    <td colspan="6" style="text-align: center; color: #888; padding: 30px;">No departments found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add Department -->
<div class="modal-overlay" id="addDeptModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-plus-circle" style="color: #1e88e5;"></i> Add Engineering Department</h3>
            <button type="button" class="modal-close" onclick="closeModal('addDeptModal')">&times;</button>
        </div>
        <form method="POST" action="departments.php">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="name">Department Name <span class="required">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Computer Engineering" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="code">Branch Code <span class="required">*</span></label>
                        <input type="text" name="code" id="code" class="form-control" placeholder="e.g. CE" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="icon_class">FontAwesome Icon Class</label>
                        <input type="text" name="icon_class" id="icon_class" class="form-control" value="fas fa-desktop" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="learn_more_url">Learn More URL</label>
                        <input type="text" name="learn_more_url" id="learn_more_url" class="form-control" value="#">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="display_order">Display Order</label>
                        <input type="number" name="display_order" id="display_order" class="form-control" value="<?= count($departments) + 1 ?>" min="1">
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
                <button type="button" class="btn-secondary" onclick="closeModal('addDeptModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Add Department</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Department -->
<?php if ($editItem): ?>
<div class="modal-overlay active" id="editDeptModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-edit" style="color: #1e88e5;"></i> Edit Department</h3>
            <a href="departments.php" class="modal-close">&times;</a>
        </div>
        <form method="POST" action="departments.php">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_name">Department Name <span class="required">*</span></label>
                    <input type="text" name="name" id="edit_name" class="form-control" value="<?= htmlspecialchars($editItem['name']) ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_code">Branch Code <span class="required">*</span></label>
                        <input type="text" name="code" id="edit_code" class="form-control" value="<?= htmlspecialchars($editItem['code']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="edit_icon_class">FontAwesome Icon Class</label>
                        <input type="text" name="icon_class" id="edit_icon_class" class="form-control" value="<?= htmlspecialchars($editItem['icon_class']) ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_learn_more_url">Learn More URL</label>
                        <input type="text" name="learn_more_url" id="edit_learn_more_url" class="form-control" value="<?= htmlspecialchars($editItem['learn_more_url']) ?>">
                    </div>

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
                <a href="departments.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
