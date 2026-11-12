<?php
/**
 * Department Admin - Faculty Management (Strictly scoped to logged in dept)
 */
$pageTitle = 'Manage Faculty';
$pageHeading = 'Faculty Directory';
$activeTab = 'faculty';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../admin/includes/upload_helper.php';

$pdo = getDBConnection();
$error = '';
$action = $_GET['action'] ?? '';
$editId = (int)($_GET['edit_id'] ?? 0);

// DELETE action (Strictly scoped by dept_code)
if ($action === 'delete' && !empty($_GET['id'])) {
    $delId = (int)$_GET['id'];
    try {
        $delStmt = $pdo->prepare("DELETE FROM faculties WHERE id = ? AND dept_code = ?");
        $delStmt->execute([$delId, $deptCode]);
        setDeptFlash('success', 'Faculty profile deleted successfully.');
        header('Location: faculty.php');
        exit;
    } catch (Exception $e) {
        $error = 'Delete failed: ' . $e->getMessage();
    }
}

// POST Add or Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitId = (int)($_POST['record_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $qualification = trim($_POST['qualification'] ?? '');
    $experience = trim($_POST['experience'] ?? '');
    $date_of_joining = !empty($_POST['date_of_joining']) ? $_POST['date_of_joining'] : null;
    $area_of_interest = trim($_POST['area_of_interest'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $website = trim($_POST['website'] ?? '');
    $display_order = (int)($_POST['display_order'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if (empty($name) || empty($designation)) {
        $error = 'Name and Designation are required.';
    } else {
        // Upload photo into uploads/faculty/<dept_code>/
        $deptSubdir = 'faculty/' . strtolower($deptCode);
        $upload = handleImageUpload('photo_file', $deptSubdir, null, $_POST['current_photo'] ?? null);
        $photo_url = $upload['success'] ? $upload['path'] : ($_POST['current_photo'] ?? 'images/avatar_placeholder.jpg');

        try {
            if ($submitId > 0) {
                // UPDATE (Strict IDOR check: WHERE id = ? AND dept_code = ?)
                $stmt = $pdo->prepare("UPDATE faculties SET 
                    name = ?, 
                    designation = ?, 
                    qualification = ?, 
                    experience = ?, 
                    date_of_joining = ?, 
                    area_of_interest = ?, 
                    email = ?, 
                    website = ?, 
                    photo_url = ?, 
                    display_order = ?, 
                    is_active = ?, 
                    updated_at = NOW() 
                    WHERE id = ? AND dept_code = ?");
                $stmt->execute([$name, $designation, $qualification, $experience, $date_of_joining, $area_of_interest, $email, $website, $photo_url, $display_order, $is_active, $submitId, $deptCode]);
                setDeptFlash('success', 'Faculty details updated successfully.');
            } else {
                // INSERT (Auto-generate clean username and bind dept_code)
                $cleanUser = strtolower($deptCode . '_' . substr(preg_replace('/[^a-zA-Z]/', '', $name), 0, 5) . '_' . time());
                $stmt = $pdo->prepare("INSERT INTO faculties (dept_code, username, name, designation, qualification, experience, date_of_joining, area_of_interest, email, website, photo_url, display_order, is_active, is_registered) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
                $stmt->execute([$deptCode, $cleanUser, $name, $designation, $qualification, $experience, $date_of_joining, $area_of_interest, $email, $website, $photo_url, $display_order, $is_active]);
                setDeptFlash('success', "New faculty '{$name}' created successfully! They can now claim their account in Faculty Self-Service Portal.");
            }
            header('Location: faculty.php');
            exit;
        } catch (Exception $e) {
            $error = 'Save error: ' . $e->getMessage();
        }
    }
}

// Fetch record for editing
$editRecord = null;
if ($action === 'edit' && $editId > 0) {
    $editStmt = $pdo->prepare("SELECT * FROM faculties WHERE id = ? AND dept_code = ?");
    $editStmt->execute([$editId, $deptCode]);
    $editRecord = $editStmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch all faculties of this department
$stmt = $pdo->prepare("SELECT * FROM faculties WHERE dept_code = ? ORDER BY display_order ASC, name ASC");
$stmt->execute([$deptCode]);
$faculties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<!-- Form Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3>
            <i class="fas fa-<?= $editRecord ? 'pen-to-square' : 'user-plus' ?>"></i>
            <?= $editRecord ? 'Edit Faculty Details' : 'Add New Faculty Member to ' . htmlspecialchars($deptName) ?>
        </h3>
        <?php if ($editRecord): ?>
            <a href="faculty.php" class="btn btn-outline btn-sm">Cancel Edit</a>
        <?php endif; ?>
    </div>

    <div class="admin-card-body">
        <form method="POST" action="faculty.php" enctype="multipart/form-data">
            <input type="hidden" name="record_id" value="<?= htmlspecialchars($editRecord['id'] ?? 0) ?>">
            <input type="hidden" name="current_photo" value="<?= htmlspecialchars($editRecord['photo_url'] ?? '') ?>">

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="name">Full Name <span class="required">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Dr. John Doe" value="<?= htmlspecialchars($editRecord['name'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="designation">Designation <span class="required">*</span></label>
                    <input type="text" name="designation" id="designation" class="form-control" placeholder="e.g. Assistant Professor" value="<?= htmlspecialchars($editRecord['designation'] ?? '') ?>" required>
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="email">Official Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="name@gecmodasa.ac.in" value="<?= htmlspecialchars($editRecord['email'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="qualification">Highest Qualification</label>
                    <input type="text" name="qualification" id="qualification" class="form-control" placeholder="e.g. Ph.D., M.Tech" value="<?= htmlspecialchars($editRecord['qualification'] ?? '') ?>">
                </div>
            </div>

            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label" for="experience">Experience</label>
                    <input type="text" name="experience" id="experience" class="form-control" placeholder="e.g. 10 Years" value="<?= htmlspecialchars($editRecord['experience'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="date_of_joining">Date of Joining</label>
                    <input type="date" name="date_of_joining" id="date_of_joining" class="form-control" value="<?= htmlspecialchars($editRecord['date_of_joining'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="display_order">Display Order</label>
                    <input type="number" name="display_order" id="display_order" class="form-control" value="<?= htmlspecialchars($editRecord['display_order'] ?? 0) ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="area_of_interest">Area of Specialization / Interest</label>
                <input type="text" name="area_of_interest" id="area_of_interest" class="form-control" placeholder="e.g. Artificial Intelligence, VLSI, Structural Analysis" value="<?= htmlspecialchars($editRecord['area_of_interest'] ?? '') ?>">
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="photo_file">Profile Photo</label>
                    <input type="file" name="photo_file" id="photo_file" class="form-control" accept="image/*">
                </div>

                <div class="form-group" style="display:flex; align-items:center; gap:10px; margin-top:28px;">
                    <label style="cursor:pointer; display:flex; align-items:center; gap:8px;">
                        <input type="checkbox" name="is_active" value="1" <?= (!isset($editRecord) || !empty($editRecord['is_active'])) ? 'checked' : '' ?>>
                        <span>Active Profile (Visible on website)</span>
                    </label>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:15px;">
                <button type="submit" class="btn btn-navy">
                    <i class="fas fa-save"></i> <?= $editRecord ? 'Update Faculty' : 'Save Faculty Profile' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- List Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-list-check"></i> Faculty Members in <?= htmlspecialchars($deptName) ?> (<?= count($faculties) ?>)</h3>
    </div>

    <div class="data-table-wrapper">
        <?php if (empty($faculties)): ?>
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                <p>No faculty members found in this department.</p>
            </div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Email</th>
                        <th>Portal Status</th>
                        <th style="width: 130px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faculties as $idx => $f): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td>
                                <strong><?= htmlspecialchars($f['name']) ?></strong>
                            </td>
                            <td><?= htmlspecialchars($f['designation']) ?></td>
                            <td><?= htmlspecialchars($f['email'] ?? '-') ?></td>
                            <td>
                                <?php if (!empty($f['is_registered'])): ?>
                                    <span style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; padding:2px 8px; border-radius:12px; font-size:11px; font-weight:600;">
                                        <i class="fas fa-circle-check"></i> Registered
                                    </span>
                                <?php else: ?>
                                    <span style="background:#fffbeb; color:#92400e; border:1px solid #fde68a; padding:2px 8px; border-radius:12px; font-size:11px; font-weight:600;">
                                        <i class="fas fa-clock"></i> Not Claimed Yet
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <a href="faculty.php?action=edit&edit_id=<?= (int)$f['id'] ?>" class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="faculty.php?action=delete&id=<?= (int)$f['id'] ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Delete this faculty profile?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

