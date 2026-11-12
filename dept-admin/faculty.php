<?php
/**
 * Department Admin - Faculty Management (Clean Main Admin UI with Modal & Data Table)
 */
$pageTitle = 'Faculty Directory';
$pageHeading = 'Faculty Profiles';
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
        $deptSubdir = 'faculty/' . strtolower($deptCode);
        $upload = handleImageUpload('photo_file', $deptSubdir, null, $_POST['current_photo'] ?? null);
        $photo_url = $upload['success'] ? $upload['path'] : ($_POST['current_photo'] ?? 'images/avatar_placeholder.jpg');

        try {
            if ($submitId > 0) {
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
                $cleanUser = strtolower($deptCode . '_' . substr(preg_replace('/[^a-zA-Z]/', '', $name), 0, 5) . '_' . time());
                $stmt = $pdo->prepare("INSERT INTO faculties (dept_code, username, name, designation, qualification, experience, date_of_joining, area_of_interest, email, website, photo_url, display_order, is_active, is_registered) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
                $stmt->execute([$deptCode, $cleanUser, $name, $designation, $qualification, $experience, $date_of_joining, $area_of_interest, $email, $website, $photo_url, $display_order, $is_active]);
                setDeptFlash('success', "New faculty member '{$name}' added successfully.");
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
    <div class="admin-alert admin-alert-danger">
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<!-- Main Admin Card with Top Action Bar -->
<div class="admin-card">
    <div class="card-top">
        <div>
            <h2 class="card-title">Faculty Profiles (<?= count($faculties) ?>)</h2>
        </div>
        <div>
            <button type="button" class="btn-add-new" onclick="openFacultyModal()">
                Add Faculty Member
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <?php if (empty($faculties)): ?>
            <div style="text-align: center; padding: 48px 20px; color: var(--admin-text-muted);">
                <p>No faculty members found in this department.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Faculty Name</th>
                        <th>Designation</th>
                        <th>Email</th>
                        <th style="width: 140px;">Portal Status</th>
                        <th style="width: 120px; text-align: right;">Action</th>
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
                                    <span class="badge badge-success">Registered</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Unclaimed</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <div class="table-actions" style="justify-content: flex-end;">
                                    <a href="javascript:void(0);" onclick='editFaculty(<?= json_encode($f) ?>)' class="btn-table-action btn-edit" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="faculty.php?action=delete&id=<?= (int)$f['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Delete this faculty member?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: ADD / EDIT FACULTY (Clean Side-by-Side Grid Layout)     -->
<!-- ============================================================== -->
<div class="modal-overlay" id="facultyModal">
    <div class="modal-dialog" style="max-width: 680px;">
        <div class="modal-header">
            <h3 class="modal-title" id="facultyModalTitle">Add Faculty Member</h3>
            <button type="button" class="btn-close-modal" onclick="closeFacultyModal()">&times;</button>
        </div>
        <form action="faculty.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="record_id" id="modal_record_id" value="0">
            <input type="hidden" name="current_photo" id="modal_current_photo" value="">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label" for="modal_name">Full Name <span class="required">*</span></label>
                        <input type="text" name="name" id="modal_name" class="form-control" placeholder="e.g. Dr. John Doe" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="modal_order">Display Order</label>
                        <input type="number" name="display_order" id="modal_order" class="form-control" value="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="modal_designation">Designation <span class="required">*</span></label>
                        <input type="text" name="designation" id="modal_designation" class="form-control" placeholder="e.g. Assistant Professor" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="modal_qualification">Qualification</label>
                        <input type="text" name="qualification" id="modal_qualification" class="form-control" placeholder="e.g. Ph.D., M.Tech">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="modal_experience">Experience</label>
                        <input type="text" name="experience" id="modal_experience" class="form-control" placeholder="e.g. 10 Years">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="modal_doj">Date of Joining</label>
                        <input type="date" name="date_of_joining" id="modal_doj" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="modal_aoi">Area of Specialization</label>
                    <input type="text" name="area_of_interest" id="modal_aoi" class="form-control" placeholder="e.g. Structural Engineering, Geotechnical Engineering">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="modal_email">Official Email</label>
                        <input type="email" name="email" id="modal_email" class="form-control" placeholder="name@gecmodasa.ac.in">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="modal_website">Website / Scholar URL</label>
                        <input type="url" name="website" id="modal_website" class="form-control" placeholder="https://scholar.google.com/...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="modal_photo">Profile Photo</label>
                    <input type="file" name="photo_file" id="modal_photo" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" id="modal_is_active" value="1" checked>
                        <span>Display on public department website (Active)</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeFacultyModal()">Cancel</button>
                <button type="submit" class="btn-add-new" id="modalSubmitBtn">Save Faculty</button>
            </div>
        </form>
    </div>
</div>

<script>
function openFacultyModal() {
    document.getElementById('facultyModalTitle').textContent = 'Add Faculty Member';
    document.getElementById('modalSubmitBtn').textContent = 'Save Faculty';
    document.getElementById('modal_record_id').value = '0';
    document.getElementById('modal_current_photo').value = '';
    document.getElementById('modal_name').value = '';
    document.getElementById('modal_order').value = '0';
    document.getElementById('modal_designation').value = '';
    document.getElementById('modal_qualification').value = '';
    document.getElementById('modal_experience').value = '';
    document.getElementById('modal_doj').value = '';
    document.getElementById('modal_aoi').value = '';
    document.getElementById('modal_email').value = '';
    document.getElementById('modal_website').value = '';
    document.getElementById('modal_photo').value = '';
    document.getElementById('modal_is_active').checked = true;
    document.getElementById('facultyModal').classList.add('active');
}

function editFaculty(data) {
    document.getElementById('facultyModalTitle').textContent = 'Edit Faculty Details';
    document.getElementById('modalSubmitBtn').textContent = 'Update Faculty';
    document.getElementById('modal_record_id').value = data.id || '0';
    document.getElementById('modal_current_photo').value = data.photo_url || '';
    document.getElementById('modal_name').value = data.name || '';
    document.getElementById('modal_order').value = data.display_order || '0';
    document.getElementById('modal_designation').value = data.designation || '';
    document.getElementById('modal_qualification').value = data.qualification || '';
    document.getElementById('modal_experience').value = data.experience || '';
    document.getElementById('modal_doj').value = data.date_of_joining || '';
    document.getElementById('modal_aoi').value = data.area_of_interest || '';
    document.getElementById('modal_email').value = data.email || '';
    document.getElementById('modal_website').value = data.website || '';
    document.getElementById('modal_is_active').checked = (data.is_active == 1);
    document.getElementById('facultyModal').classList.add('active');
}

function closeFacultyModal() {
    document.getElementById('facultyModal').classList.remove('active');
}

// Auto open if URL has edit_id
<?php if ($editRecord): ?>
document.addEventListener('DOMContentLoaded', function() {
    editFaculty(<?= json_encode($editRecord) ?>);
});
<?php endif; ?>
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
