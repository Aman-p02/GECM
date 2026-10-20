<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $role = $_POST['role'] ?? 'super_admin';
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!empty($username) && !empty($email) && !empty($password)) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            try {
                $stmt = $pdo->prepare("INSERT INTO admins (username, email, password_hash, role, is_active) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$username, $email, $hash, $role, $is_active]);
                setFlashMessage('success', 'Admin user created successfully!');
                header('Location: admins.php');
                exit;
            } catch (Exception $e) {
                setFlashMessage('danger', 'Error adding admin: ' . $e->getMessage());
            }
        } else {
            setFlashMessage('danger', 'Username, email, and password are required.');
        }
    } elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $role = $_POST['role'] ?? 'super_admin';
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!empty($email) && $id > 0) {
            try {
                if (!empty($password)) {
                    $hash = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $pdo->prepare("UPDATE admins SET email = ?, password_hash = ?, role = ?, is_active = ? WHERE id = ?");
                    $stmt->execute([$email, $hash, $role, $is_active, $id]);
                } else {
                    $stmt = $pdo->prepare("UPDATE admins SET email = ?, role = ?, is_active = ? WHERE id = ?");
                    $stmt->execute([$email, $role, $is_active, $id]);
                }
                setFlashMessage('success', 'Admin user updated successfully!');
                header('Location: admins.php');
                exit;
            } catch (Exception $e) {
                setFlashMessage('danger', 'Error updating admin: ' . $e->getMessage());
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 1) { // Prevent deleting primary super admin #1
        $stmt = $pdo->prepare("DELETE FROM admins WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Admin user deleted!');
        header('Location: admins.php');
        exit;
    } else {
        setFlashMessage('danger', 'Primary administrator cannot be deleted.');
    }
}

if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    if ($id > 1) {
        $stmt = $pdo->prepare("UPDATE admins SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('info', 'Admin status toggled!');
        header('Location: admins.php');
        exit;
    }
}

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT id, username, email, role, is_active FROM admins WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

$admins = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT id, username, email, role, is_active, created_at FROM admins ORDER BY id ASC");
    $admins = $stmt->fetchAll();
}

$current_page = 'admins';
$page_title = 'Admin Users Management';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <h2 class="card-title">Admin Users & Access Control</h2>
        </div>
        <button type="button" class="btn-add-new" onclick="openModal('addAdminModal')">
            + Add New Admin
        </button>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="card-filters" style="margin-left: auto;">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search admins..." data-table-search="adminsTable">
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="adminsTable">
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>Username</th>
                    <th>Email Address</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th style="width: 120px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admins as $row): ?>
                <tr data-status="<?= $row['is_active'] ? 'active' : 'inactive' ?>">
                    <td style="color: #888;">#<?= $row['id'] ?></td>
                    <td style="font-weight: 600; color: #1a263d;">
                        <i class="fas fa-user-shield" style="color: #1e88e5; margin-right: 6px;"></i>
                        <?= htmlspecialchars($row['username']) ?>
                    </td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <span class="badge badge-info"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $row['role']))) ?></span>
                    </td>
                    <td>
                        <?php if ($row['id'] === 1): ?>
                            <span class="badge badge-success"><i class="fas fa-check"></i> Primary</span>
                        <?php else: ?>
                            <a href="admins.php?toggle=<?= $row['id'] ?>" title="Click to toggle status">
                                <?php if ($row['is_active']): ?>
                                    <span class="badge badge-success"><i class="fas fa-check"></i> Active</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><i class="fas fa-eye-slash"></i> Inactive</span>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td style="font-size: 12.5px; color: #666;"><?= htmlspecialchars($row['created_at']) ?></td>
                    <td style="text-align: center;">
                        <div class="table-actions" style="justify-content: center;">
                            <a href="admins.php?edit=<?= $row['id'] ?>" class="btn-table-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if ($row['id'] > 1): ?>
                            <a href="admins.php?delete=<?= $row['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Delete this admin user?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add Admin -->
<div class="modal-overlay" id="addAdminModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Add New Admin User</h3>
            <button type="button" class="modal-close" onclick="closeModal('addAdminModal')">&times;</button>
        </div>
        <form method="POST" action="admins.php">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="username">Username <span class="required">*</span></label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="e.g. principal_office" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email Address <span class="required">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="e.g. user@gecmodasa.ac.in" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="password">Password <span class="required">*</span></label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter secure password" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="role">Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="super_admin">Super Admin</option>
                            <option value="editor">Editor</option>
                            <option value="notice_publisher">Notice Publisher</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Active Account</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addAdminModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Create Admin</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Admin -->
<?php if ($editItem): ?>
<div class="modal-overlay active" id="editAdminModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Edit Admin <?= htmlspecialchars($editItem['username']) ?></h3>
            <a href="admins.php" class="modal-close">&times;</a>
        </div>
        <form method="POST" action="admins.php">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_email">Email Address <span class="required">*</span></label>
                    <input type="email" name="email" id="edit_email" class="form-control" value="<?= htmlspecialchars($editItem['email']) ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_password">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" id="edit_password" class="form-control" placeholder="••••••••">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="edit_role">Role</label>
                        <select name="role" id="edit_role" class="form-control">
                            <option value="super_admin" <?= ($editItem['role'] === 'super_admin') ? 'selected' : '' ?>>Super Admin</option>
                            <option value="editor" <?= ($editItem['role'] === 'editor') ? 'selected' : '' ?>>Editor</option>
                            <option value="notice_publisher" <?= ($editItem['role'] === 'notice_publisher') ? 'selected' : '' ?>>Notice Publisher</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                        <span>Active Account</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="admins.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
