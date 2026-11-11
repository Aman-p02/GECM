<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

// Department resolution
$deptCode = strtoupper(trim($_GET['dept'] ?? 'CE'));
$validDepts = [
    'CE'    => 'Computer Engineering',
    'IT'    => 'Information Technology',
    'ME'    => 'Mechanical Engineering',
    'CIVIL' => 'Civil Engineering',
    'EE'    => 'Electrical Engineering',
    'EC'    => 'Electronics & Communication',
    'AE'    => 'Automobile Engineering',
    'AM'    => 'Applied Mechanics',
    'SH'    => 'Science & Humanities'
];

if (!isset($validDepts[$deptCode])) {
    $deptCode = 'CE';
}
$deptName = $validDepts[$deptCode];

$deptFolderMap = [
    'CE'    => 'computer',
    'IT'    => 'information-technology',
    'ME'    => 'mechanical',
    'CIVIL' => 'civil',
    'AE'    => 'automobile',
    'AM'    => 'applied-mechanics',
];
$liveDeptFolder = $deptFolderMap[$deptCode] ?? 'computer';
$livePageUrl = "../departments/{$liveDeptFolder}/index.php#faculty";

// Guard against DB connection failure on write requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: dept-faculty.php?dept=' . $deptCode);
        exit;
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
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

        // Process photo upload into department-specific subfolder (e.g. uploads/faculty/ce/)
        $deptFolder = 'faculty/' . strtolower($deptCode);
        $upload = handleImageUpload('photo_file', $deptFolder, null, $_POST['photo_url'] ?? null);
        $photo_url = $upload['success'] ? $upload['path'] : 'images/avatar_placeholder.jpg';

        if (!empty($name) && !empty($designation)) {
            try {
                // Generate clean username
                $cleanUser = strtolower($deptCode . '_' . substr(preg_replace('/[^a-zA-Z]/', '', $name), 0, 5) . '_' . time());
                $stmt = $pdo->prepare("INSERT INTO faculties (dept_code, username, name, designation, qualification, experience, date_of_joining, area_of_interest, email, website, photo_url, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$deptCode, $cleanUser, $name, $designation, $qualification, $experience, $date_of_joining, $area_of_interest, $email, $website, $photo_url, $display_order, $is_active]);
                $newFacId = $pdo->lastInsertId();

                setFlashMessage('success', "Faculty '{$name}' added successfully to {$deptName}!");
                header('Location: dept-faculty.php?dept=' . $deptCode);
                exit;
            } catch (Exception $e) {
                setFlashMessage('danger', 'Database error: ' . $e->getMessage());
            }
        } else {
            setFlashMessage('danger', 'Faculty name and designation are required.');
        }
    } elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
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
        $existingPhoto = trim($_POST['existing_photo'] ?? '');

        $deptFolder = 'faculty/' . strtolower($deptCode);
        $upload = handleImageUpload('photo_file', $deptFolder, $existingPhoto, $_POST['photo_url'] ?? null);
        $photo_url = $upload['success'] ? $upload['path'] : $existingPhoto;

        if (!empty($name) && !empty($designation) && $id > 0) {
            try {
                $stmt = $pdo->prepare("UPDATE faculties SET name = ?, designation = ?, qualification = ?, experience = ?, date_of_joining = ?, area_of_interest = ?, email = ?, website = ?, photo_url = ?, display_order = ?, is_active = ? WHERE id = ?");
                $stmt->execute([$name, $designation, $qualification, $experience, $date_of_joining, $area_of_interest, $email, $website, $photo_url, $display_order, $is_active, $id]);
                setFlashMessage('success', "Faculty profile updated successfully!");
                header('Location: dept-faculty.php?dept=' . $deptCode);
                exit;
            } catch (Exception $e) {
                setFlashMessage('danger', 'Database error: ' . $e->getMessage());
            }
        }
    } elseif ($action === 'add_qualification') {
        $faculty_id = (int)$_POST['faculty_id'];
        $deg = trim($_POST['qualification'] ?? '');
        $uni = trim($_POST['university'] ?? '');
        $yop = trim($_POST['year_of_passing'] ?? '');
        $perc = trim($_POST['percentage'] ?? '');

        if ($faculty_id > 0 && !empty($deg)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO faculty_qualifications (faculty_id, qualification, university, year_of_passing, percentage) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$faculty_id, $deg, $uni, $yop, $perc]);
                setFlashMessage('success', "Qualification entry added!");
            } catch (Exception $e) {
                setFlashMessage('danger', 'Database error: ' . $e->getMessage());
            }
        }
        header('Location: dept-faculty.php?dept=' . $deptCode . '&manage_quals=' . $faculty_id);
        exit;
    } elseif ($action === 'delete_qualification') {
        $qual_id = (int)$_POST['qual_id'];
        $faculty_id = (int)$_POST['faculty_id'];
        if ($qual_id > 0) {
            try {
                $stmt = $pdo->prepare("DELETE FROM faculty_qualifications WHERE id = ?");
                $stmt->execute([$qual_id]);
                setFlashMessage('success', "Qualification entry deleted!");
            } catch (Exception $e) {
                setFlashMessage('danger', 'Database error: ' . $e->getMessage());
            }
        }
        header('Location: dept-faculty.php?dept=' . $deptCode . '&manage_quals=' . $faculty_id);
        exit;
    }
}

// Handle GET Actions (delete, toggle, edit)
if (isset($_GET['delete'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP.');
        header('Location: dept-faculty.php?dept=' . $deptCode);
        exit;
    }
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        try {
            $stmt = $pdo->prepare("DELETE FROM faculties WHERE id = ?");
            $stmt->execute([$id]);
            $pdo->prepare("DELETE FROM faculty_qualifications WHERE faculty_id = ?")->execute([$id]);
            $pdo->prepare("DELETE FROM faculty_details WHERE faculty_id = ?")->execute([$id]);
            setFlashMessage('success', 'Faculty record deleted!');
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }
        header('Location: dept-faculty.php?dept=' . $deptCode);
        exit;
    }
}

if (isset($_GET['toggle'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP.');
        header('Location: dept-faculty.php?dept=' . $deptCode);
        exit;
    }
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        try {
            $stmt = $pdo->prepare("UPDATE faculties SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('info', 'Faculty status toggled!');
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }
        header('Location: dept-faculty.php?dept=' . $deptCode);
        exit;
    }
}

if (isset($_GET['edit']) && $pdo) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM faculties WHERE id = ?");
            $stmt->execute([$id]);
            $editItem = $stmt->fetch();
        } catch (Exception $e) {
            $editItem = null;
        }
    }
}

// Fetch faculties for this department
$faculties = [];
if ($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM faculties WHERE dept_code = ? ORDER BY display_order ASC, id ASC");
        $stmt->execute([$deptCode]);
        $faculties = $stmt->fetchAll();
    } catch (Exception $e) {
        $faculties = [];
    }
}

// Qualifications manager state
$managingFaculty = null;
$facultyQuals = [];
if (isset($_GET['manage_quals']) && $pdo) {
    $mId = (int)$_GET['manage_quals'];
    if ($mId > 0) {
        try {
            $mStmt = $pdo->prepare("SELECT * FROM faculties WHERE id = ?");
            $mStmt->execute([$mId]);
            $managingFaculty = $mStmt->fetch();
            if ($managingFaculty) {
                $qStmt = $pdo->prepare("SELECT * FROM faculty_qualifications WHERE faculty_id = ? ORDER BY id ASC");
                $qStmt->execute([$mId]);
                $facultyQuals = $qStmt->fetchAll();
            }
        } catch (Exception $e) {
            $managingFaculty = null;
            $facultyQuals = [];
        }
    }
}

$current_page = 'dept-faculty';
$page_title = $deptName . ' - Faculty Management';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Department Modules Navigation Bar -->
<div style="background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 12px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <span style="font-size: 15px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-layer-group" style="color: #2563eb;"></i> <?= htmlspecialchars($deptName) ?> (<?= htmlspecialchars($deptCode) ?>)
        </span>
    </div>

    <!-- Sub-modules of this Department (as requested: Faculty, Activities, Publications, Advisory Board, Newsletters) -->
    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
        <a href="dept-faculty.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #1e90ff; color: #ffffff; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-users" style="margin-right: 6px;"></i> Faculty Members
        </a>
        <a href="dept-activities.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 500; text-decoration: none; font-size: 13px;">
            <i class="fas fa-calendar-check" style="margin-right: 6px;"></i> Activities
        </a>
        <a href="dept-publications.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 500; text-decoration: none; font-size: 13px;">
            <i class="fas fa-book" style="margin-right: 6px;"></i> Publications
        </a>
        <a href="dept-board.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 500; text-decoration: none; font-size: 13px;">
            <i class="fas fa-user-tie" style="margin-right: 6px;"></i> Advisory Board
        </a>
        <a href="dept-newsletters.php?dept=<?= urlencode($deptCode) ?>" class="btn-sm" style="background: #f1f5f9; color: #334155; padding: 7px 14px; border-radius: 6px; font-weight: 500; text-decoration: none; font-size: 13px;">
            <i class="fas fa-newspaper" style="margin-right: 6px;"></i> Newsletters
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <h2 class="card-title"><?= htmlspecialchars($deptName) ?> - Faculty Directory</h2>
            <p style="color: #64748b; font-size: 13.5px; margin-top: 4px;">
                Manage professors, designations, contact information, photos, and academic profile tabs.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="<?= htmlspecialchars($livePageUrl) ?>" target="_blank" class="btn-secondary" style="text-decoration: none; display: flex; align-items: center; gap: 6px; padding: 8px 16px;">
                <i class="fas fa-external-link-alt"></i> View Live Page
            </a>
            <button type="button" class="btn-add-new" onclick="openModal('addFacultyModal')">
                + Add Faculty Member
            </button>
        </div>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="card-filters" style="margin-left: auto;">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search faculty name, qualification, designation..." data-table-search="facultyTable">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="admin-table" id="facultyTable">
            <thead>
                <tr>
                    <th style="width: 50px;">Order</th>
                    <th style="width: 70px;">Photo</th>
                    <th>Faculty Name &amp; Designation</th>
                    <th>Qualification &amp; Experience</th>
                    <th>Contact &amp; Links</th>
                    <th style="width: 90px;">Status</th>
                    <th style="width: 170px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($faculties)): ?>
                    <tr class="no-records-row">
                        <td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
                            No faculty members found for <?= htmlspecialchars($deptName) ?>. Click "+ Add Faculty Member" above to create one.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($faculties as $fac): ?>
                        <tr data-status="<?= $fac['is_active'] ? 'active' : 'inactive' ?>">
                            <td style="font-weight: 700; color: #1e90ff;">
                                #<?= htmlspecialchars($fac['display_order']) ?>
                            </td>
                            <td>
                                <?php 
                                $photoSrc = !empty($fac['photo_url']) ? '../' . $fac['photo_url'] : '../images/avatar_placeholder.jpg';
                                ?>
                                <img src="<?= htmlspecialchars($photoSrc) ?>" alt="Photo" style="width: 48px; height: 54px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1; display: block;" onerror="this.src='../images/avatar_placeholder.jpg'">
                            </td>
                            <td>
                                <strong style="font-size: 15px; color: #0f172a; display: block;"><?= htmlspecialchars($fac['name']) ?></strong>
                                <span style="font-size: 13px; color: #1e90ff; font-weight: 600;"><?= htmlspecialchars($fac['designation']) ?></span>
                            </td>
                            <td>
                                <div style="font-size: 13.5px; color: #334155; font-weight: 500;"><?= htmlspecialchars($fac['qualification'] ?: ' - ') ?></div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Exp: <?= htmlspecialchars($fac['experience'] ?: ' - ') ?></div>
                            </td>
                            <td>
                                <div style="font-size: 13px; color: #334155;">
                                    <?php if (!empty($fac['email'])): ?>
                                        <a href="mailto:<?= htmlspecialchars($fac['email']) ?>" style="color: #475569; text-decoration: none;">
                                            <i class="fas fa-envelope" style="color: #94a3b8; font-size: 11px; margin-right: 4px;"></i><?= htmlspecialchars($fac['email']) ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($fac['website']) && $fac['website'] !== '#'): ?>
                                    <div style="font-size: 12px; margin-top: 2px;">
                                        <a href="<?= htmlspecialchars($fac['website']) ?>" target="_blank" style="color: #1e90ff; text-decoration: underline;">
                                            <i class="fas fa-globe" style="font-size: 11px; margin-right: 3px;"></i>Portfolio / Website
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="dept-faculty.php?dept=<?= $deptCode ?>&toggle=<?= $fac['id'] ?>" class="status-badge <?= $fac['is_active'] ? 'status-active' : 'status-inactive' ?>" title="Click to toggle status">
                                    <?= $fac['is_active'] ? 'Active' : 'Inactive' ?>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <div class="table-actions" style="justify-content: center; gap: 6px;">
                                    <a href="dept-faculty.php?dept=<?= $deptCode ?>&manage_quals=<?= $fac['id'] ?>" class="btn-action" title="Manage Qualifications &amp; Tabs" style="color: #0284c7; background: #e0f2fe; padding: 5px 8px; border-radius: 4px; font-size: 12px; text-decoration: none;">
                                        <i class="fas fa-graduation-cap"></i> Qualifications
                                    </a>
                                    <a href="dept-faculty.php?dept=<?= $deptCode ?>&edit=<?= $fac['id'] ?>" class="btn-action btn-edit" title="Edit Profile">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="dept-faculty.php?dept=<?= $deptCode ?>&delete=<?= $fac['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to delete this faculty member?');" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: ADD FACULTY MEMBER                                      -->
<!-- ============================================================== -->
<div class="admin-modal" id="addFacultyModal">
    <div class="modal-dialog" style="max-width: 680px;">
        <div class="modal-header">
            <h3 class="modal-title">Add New Faculty Member (<?= htmlspecialchars($deptName) ?>)</h3>
            <button type="button" class="btn-close-modal" onclick="closeModal('addFacultyModal')">&times;</button>
        </div>
        <form action="dept-faculty.php?dept=<?= $deptCode ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label" for="add_name">Full Name with Prefix <span class="required">*</span></label>
                        <input type="text" name="name" id="add_name" class="form-control" placeholder="e.g. Dr. Mahesh M. Goyani" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="add_order">Display Order</label>
                        <input type="number" name="display_order" id="add_order" class="form-control" value="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="add_designation">Designation <span class="required">*</span></label>
                        <input type="text" name="designation" id="add_designation" class="form-control" placeholder="e.g. Associate Professor and Head" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="add_qualification">Qualification</label>
                        <input type="text" name="qualification" id="add_qualification" class="form-control" placeholder="e.g. Ph.D, B.A., M.E., B.E.">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="add_experience">Experience</label>
                        <input type="text" name="experience" id="add_experience" class="form-control" placeholder="e.g. 15 Years">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="add_doj">Date of Joining</label>
                        <input type="date" name="date_of_joining" id="add_doj" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_aoi">Area of Interest</label>
                    <textarea name="area_of_interest" id="add_aoi" class="form-control" rows="2" placeholder="e.g. Pattern Recognition, Computer Vision, Machine Learning, Image Processing..."></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="add_email">Official Email</label>
                        <input type="email" name="email" id="add_email" class="form-control" placeholder="e.g. mgoyani@gmail.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="add_website">Website / Portfolio URL</label>
                        <input type="text" name="website" id="add_website" class="form-control" placeholder="e.g. https://maheshgoyani.in/">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_photo_file">Faculty Photo (Upload from PC)</label>
                    <input type="file" name="photo_file" id="add_photo_file" class="form-control" accept="image/*">
                    <small style="color: #64748b; font-size: 12px; margin-top: 4px; display: block;">Supports JPG, PNG, WEBP. Recommended size: 400x500 portrait.</small>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Display on public department website (Active)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addFacultyModal')">Cancel</button>
                <button type="submit" class="btn-primary">Save Faculty Member</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: EDIT FACULTY MEMBER                                     -->
<!-- ============================================================== -->
<?php if ($editItem): ?>
<div class="admin-modal show" id="editFacultyModal">
    <div class="modal-dialog" style="max-width: 680px;">
        <div class="modal-header">
            <h3 class="modal-title">Edit Faculty: <?= htmlspecialchars($editItem['name']) ?></h3>
            <a href="dept-faculty.php?dept=<?= $deptCode ?>" class="btn-close-modal">&times;</a>
        </div>
        <form action="dept-faculty.php?dept=<?= $deptCode ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <input type="hidden" name="existing_photo" value="<?= htmlspecialchars($editItem['photo_url'] ?? '') ?>">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label" for="edit_name">Full Name <span class="required">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control" value="<?= htmlspecialchars($editItem['name']) ?>" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="edit_order">Display Order</label>
                        <input type="number" name="display_order" id="edit_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order']) ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_designation">Designation <span class="required">*</span></label>
                        <input type="text" name="designation" id="edit_designation" class="form-control" value="<?= htmlspecialchars($editItem['designation']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_qualification">Qualification</label>
                        <input type="text" name="qualification" id="edit_qualification" class="form-control" value="<?= htmlspecialchars($editItem['qualification'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_experience">Experience</label>
                        <input type="text" name="experience" id="edit_experience" class="form-control" value="<?= htmlspecialchars($editItem['experience'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_doj">Date of Joining</label>
                        <input type="date" name="date_of_joining" id="edit_doj" class="form-control" value="<?= htmlspecialchars($editItem['date_of_joining'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_aoi">Area of Interest</label>
                    <textarea name="area_of_interest" id="edit_aoi" class="form-control" rows="2"><?= htmlspecialchars($editItem['area_of_interest'] ?? '') ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_email">Official Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" value="<?= htmlspecialchars($editItem['email'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="edit_website">Website / Portfolio URL</label>
                        <input type="text" name="website" id="edit_website" class="form-control" value="<?= htmlspecialchars($editItem['website'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Current Photo</label>
                    <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 8px;">
                        <?php $ePhoto = !empty($editItem['photo_url']) ? '../' . $editItem['photo_url'] : '../images/avatar_placeholder.jpg'; ?>
                        <img src="<?= htmlspecialchars($ePhoto) ?>" style="width: 50px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;" onerror="this.src='../images/avatar_placeholder.jpg'">
                        <input type="file" name="photo_file" class="form-control" accept="image/*" style="flex: 1;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                        <span>Active and visible on website</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="dept-faculty.php?dept=<?= $deptCode ?>" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Update Faculty</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- ============================================================== -->
<!-- MODAL: MANAGE QUALIFICATIONS & TABS                             -->
<!-- ============================================================== -->
<?php if ($managingFaculty): ?>
<div class="admin-modal show" id="manageQualsModal">
    <div class="modal-dialog" style="max-width: 780px;">
        <div class="modal-header">
            <h3 class="modal-title">Qualifications: <?= htmlspecialchars($managingFaculty['name']) ?></h3>
            <a href="dept-faculty.php?dept=<?= $deptCode ?>" class="btn-close-modal">&times;</a>
        </div>
        <div class="modal-body">
            <!-- Add New Qualification Row Form -->
            <form action="dept-faculty.php?dept=<?= $deptCode ?>" method="POST" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 14px; margin-bottom: 20px;">
                <input type="hidden" name="action" value="add_qualification">
                <input type="hidden" name="faculty_id" value="<?= $managingFaculty['id'] ?>">

                <div style="font-weight: 700; font-size: 13.5px; color: #1e293b; margin-bottom: 10px;">
                    + Add Qualification Record (Displayed on "Read More..." tab)
                </div>
                <div style="display: grid; grid-template-columns: 2fr 2fr 1fr 1fr auto; gap: 8px; align-items: end;">
                    <div>
                        <label class="form-label" style="font-size: 11px;">Degree / Exam *</label>
                        <input type="text" name="qualification" class="form-control" placeholder="e.g. Ph.D., M.E., B.E." required>
                    </div>
                    <div>
                        <label class="form-label" style="font-size: 11px;">University / Board *</label>
                        <input type="text" name="university" class="form-control" placeholder="e.g. CHARUSAT, GSEB" required>
                    </div>
                    <div>
                        <label class="form-label" style="font-size: 11px;">Passing Year</label>
                        <input type="text" name="year_of_passing" class="form-control" placeholder="e.g. 2017">
                    </div>
                    <div>
                        <label class="form-label" style="font-size: 11px;">Percentage / CPI</label>
                        <input type="text" name="percentage" class="form-control" placeholder="e.g. 85%">
                    </div>
                    <div>
                        <button type="submit" class="btn-primary" style="padding: 9px 16px;">Add</button>
                    </div>
                </div>
            </form>

            <!-- Current Table of Qualifications -->
            <div style="font-weight: 700; font-size: 14px; color: #1e293b; margin-bottom: 10px;">
                Current Qualification Entries
            </div>
            <table class="admin-table" style="font-size: 13px;">
                <thead>
                    <tr style="background: #f1f5f9;">
                        <th>Qualification</th>
                        <th>University / Board</th>
                        <th>Year of Passing</th>
                        <th>Perc. (%)</th>
                        <th style="width: 60px; text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($facultyQuals)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #64748b; padding: 20px;">
                                No specific qualifications added yet. Use the form above to add educational milestones.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($facultyQuals as $q): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($q['qualification']) ?></strong></td>
                                <td><?= htmlspecialchars($q['university']) ?></td>
                                <td><?= htmlspecialchars($q['year_of_passing']) ?></td>
                                <td><?= htmlspecialchars($q['percentage'] ?: ' - ') ?></td>
                                <td style="text-align: center;">
                                    <form action="dept-faculty.php?dept=<?= $deptCode ?>" method="POST" onsubmit="return confirm('Delete this qualification?');" style="display:inline;">
                                        <input type="hidden" name="action" value="delete_qualification">
                                        <input type="hidden" name="qual_id" value="<?= $q['id'] ?>">
                                        <input type="hidden" name="faculty_id" value="<?= $managingFaculty['id'] ?>">
                                        <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer;" title="Delete">
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
        <div class="modal-footer">
            <a href="dept-faculty.php?dept=<?= $deptCode ?>" class="btn-secondary">Done</a>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

