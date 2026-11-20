<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

// Self-healing database tables setup
if ($pdo) {
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `student_section_team` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `sr_no` INT NOT NULL DEFAULT 1,
            `name` VARCHAR(255) NOT NULL,
            `department` VARCHAR(255) NOT NULL,
            `designation` VARCHAR(100) NOT NULL DEFAULT 'Member',
            `display_order` INT NOT NULL DEFAULT 0,
            `is_active` TINYINT(1) NOT NULL DEFAULT 1,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_sst_order` (`is_active`, `display_order`, `sr_no`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        $pdo->exec("CREATE TABLE IF NOT EXISTS `student_section_settings` (
            `setting_key` VARCHAR(50) PRIMARY KEY,
            `setting_value` TEXT,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    } catch (Exception $e) {
        error_log("Error creating student section tables: " . $e->getMessage());
    }
}

// Auto-seed standard 6 team members if table is empty
if ($pdo) {
    try {
        $checkCount = (int)$pdo->query("SELECT COUNT(*) FROM student_section_team")->fetchColumn();
        if ($checkCount === 0) {
            $initialMembers = [
                [
                    'sr_no' => 1,
                    'name' => 'Dr. Lalit Narsingani',
                    'department' => 'Science & Humanities Department',
                    'designation' => 'Convener',
                    'display_order' => 1
                ],
                [
                    'sr_no' => 2,
                    'name' => 'Dr. D. H. Sahay',
                    'department' => 'General Department',
                    'designation' => 'Co-Convener',
                    'display_order' => 2
                ],
                [
                    'sr_no' => 3,
                    'name' => 'Dr. K. K. Bhatt',
                    'department' => 'Electrical Engineering',
                    'designation' => 'Member',
                    'display_order' => 3
                ],
                [
                    'sr_no' => 4,
                    'name' => 'Prof. K. R. Patel',
                    'department' => 'Electronics and Communication Engineering',
                    'designation' => 'Member',
                    'display_order' => 4
                ],
                [
                    'sr_no' => 5,
                    'name' => 'Dr. N. N. Mallare',
                    'department' => 'IT',
                    'designation' => 'Member',
                    'display_order' => 5
                ],
                [
                    'sr_no' => 6,
                    'name' => 'Prof. N.D. Goriya',
                    'department' => 'Computer Engineering',
                    'designation' => 'Member',
                    'display_order' => 6
                ]
            ];

            $insStmt = $pdo->prepare("INSERT INTO student_section_team 
                (sr_no, name, department, designation, display_order, is_active) 
                VALUES (?, ?, ?, ?, ?, ?)");

            foreach ($initialMembers as $im) {
                $insStmt->execute([
                    $im['sr_no'],
                    $im['name'],
                    $im['department'],
                    $im['designation'],
                    $im['display_order'],
                    1
                ]);
            }
        }
    } catch (Exception $e) {
        error_log("Seed error student_section_team: " . $e->getMessage());
    }
}

// Fetch current Departmental PDF setting
$currentPdfPath = '';
$currentPdfTitle = 'Departmental Student Section Team Members';
if ($pdo) {
    try {
        $pdfStmt = $pdo->query("SELECT setting_value FROM student_section_settings WHERE setting_key = 'dept_team_pdf_path' LIMIT 1");
        $pdfRow = $pdfStmt->fetch(PDO::FETCH_ASSOC);
        if ($pdfRow && !empty($pdfRow['setting_value'])) {
            $currentPdfPath = $pdfRow['setting_value'];
        }

        $titleStmt = $pdo->query("SELECT setting_value FROM student_section_settings WHERE setting_key = 'dept_team_pdf_title' LIMIT 1");
        $titleRow = $titleStmt->fetch(PDO::FETCH_ASSOC);
        if ($titleRow && !empty($titleRow['setting_value'])) {
            $currentPdfTitle = $titleRow['setting_value'];
        }
    } catch (Exception $e) {
        // Table may be initialising
    }
}

// Handle Form Submissions (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP.');
        header('Location: education-verification.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    // 1. Add Team Member
    if ($action === 'add_member') {
        $sr_no = (int)($_POST['sr_no'] ?? 1);
        $name = trim($_POST['name'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $designation = trim($_POST['designation'] ?? 'Member');
        $display_order = (int)($_POST['display_order'] ?? $sr_no);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name) || empty($department)) {
            setFlashMessage('danger', 'Faculty Name and Department are required.');
            header('Location: education-verification.php');
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO student_section_team (sr_no, name, department, designation, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$sr_no, $name, $department, $designation, $display_order, $is_active]);

        setFlashMessage('success', 'Student Section team member added successfully!');
        header('Location: education-verification.php');
        exit;

    // 2. Edit Team Member
    } elseif ($action === 'edit_member') {
        $id = (int)($_POST['id'] ?? 0);
        $sr_no = (int)($_POST['sr_no'] ?? 1);
        $name = trim($_POST['name'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $designation = trim($_POST['designation'] ?? 'Member');
        $display_order = (int)($_POST['display_order'] ?? $sr_no);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name) || empty($department) || $id <= 0) {
            setFlashMessage('danger', 'Valid ID, Faculty Name, and Department are required.');
            header('Location: education-verification.php');
            exit;
        }

        $stmt = $pdo->prepare("UPDATE student_section_team SET sr_no = ?, name = ?, department = ?, designation = ?, display_order = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$sr_no, $name, $department, $designation, $display_order, $is_active, $id]);

        setFlashMessage('success', 'Team member details updated successfully!');
        header('Location: education-verification.php');
        exit;

    // 3. Upload / Update Departmental PDF
    } elseif ($action === 'upload_pdf') {
        $pdfTitle = trim($_POST['dept_team_pdf_title'] ?? 'Departmental Student Section Team Members');
        if (empty($pdfTitle)) {
            $pdfTitle = 'Departmental Student Section Team Members';
        }

        $uploadedPath = $currentPdfPath;
        if (isset($_FILES['dept_team_pdf']) && $_FILES['dept_team_pdf']['error'] === UPLOAD_ERR_OK) {
            $uploadRes = handlePdfUpload($_FILES['dept_team_pdf'], 'student_section', $currentPdfPath);
            if ($uploadRes['success']) {
                $uploadedPath = $uploadRes['path'];
            } else {
                setFlashMessage('danger', 'PDF upload error: ' . $uploadRes['error']);
                header('Location: education-verification.php');
                exit;
            }
        }

        // Save into student_section_settings
        $stmt = $pdo->prepare("INSERT INTO student_section_settings (setting_key, setting_value) VALUES ('dept_team_pdf_path', ?) ON DUPLICATE KEY UPDATE setting_value = ?");
        $stmt->execute([$uploadedPath, $uploadedPath]);

        $stmt2 = $pdo->prepare("INSERT INTO student_section_settings (setting_key, setting_value) VALUES ('dept_team_pdf_title', ?) ON DUPLICATE KEY UPDATE setting_value = ?");
        $stmt2->execute([$pdfTitle, $pdfTitle]);

        setFlashMessage('success', 'Departmental Team PDF configuration saved successfully!');
        header('Location: education-verification.php');
        exit;

    // 4. Delete PDF
    } elseif ($action === 'delete_pdf') {
        if (!empty($currentPdfPath)) {
            $fullPath = __DIR__ . '/../' . ltrim($currentPdfPath, '/');
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        $stmt = $pdo->prepare("UPDATE student_section_settings SET setting_value = '' WHERE setting_key = 'dept_team_pdf_path'");
        $stmt->execute();

        setFlashMessage('info', 'Departmental PDF removed successfully.');
        header('Location: education-verification.php');
        exit;
    }
}

// Handle GET Actions (Delete, Toggle, Edit)
if (isset($_GET['delete'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: education-verification.php');
        exit;
    }
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM student_section_team WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Team member removed successfully!');
        header('Location: education-verification.php');
        exit;
    }
}

if (isset($_GET['toggle'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: education-verification.php');
        exit;
    }
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE student_section_team SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('info', 'Member visibility status updated successfully!');
        header('Location: education-verification.php');
        exit;
    }
}

if (isset($_GET['edit']) && $pdo) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM student_section_team WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

// Fetch all records
$records = [];
if ($pdo) {
    try {
        $records = $pdo->query("SELECT * FROM student_section_team ORDER BY display_order ASC, sr_no ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $records = [];
    }
}

$current_page = 'education-verification';
$page_title = 'Education Verification & Student Section Team Management';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <h2 class="card-title">Education Verification &amp; Student Section Team</h2>
            <p style="font-size: 13.5px; color: #64748b; margin: 4px 0 0 0;">
                Manage the Student Section team members table, convener roles, and Departmental Student Section Team PDF document.
            </p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <a href="../student-corner/education-verification" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; text-decoration: none;">
                <i class="fas fa-external-link-alt"></i> View Public Page
            </a>
            <button type="button" class="btn-add-new" onclick="openModal('addMemberModal')">
                <i class="fas fa-plus"></i> Add Team Member
            </button>
        </div>
    </div>

    <!-- PDF Upload Section Card -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 14px;">
            <div style="font-weight: 700; color: #0f172a; font-size: 1rem; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-file-pdf" style="color: #ef4444;"></i>
                <span>Departmental Student Section Team Members (PDF Link)</span>
            </div>
            <?php if (!empty($currentPdfPath)): ?>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <a href="../<?= htmlspecialchars(ltrim($currentPdfPath, '/')) ?>" target="_blank" class="btn btn-secondary btn-sm" style="font-size: 12.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="fas fa-eye"></i> View Current PDF
                    </a>
                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to remove this PDF?');">
                        <input type="hidden" name="action" value="delete_pdf">
                        <button type="submit" class="btn btn-danger btn-sm" style="font-size: 12.5px; padding: 4px 10px;">
                            <i class="fas fa-trash-alt"></i> Remove PDF
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <form method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 14px;">
            <input type="hidden" name="action" value="upload_pdf">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                        Link Label / Title
                    </label>
                    <input type="text" name="dept_team_pdf_title" class="form-control" value="<?= htmlspecialchars($currentPdfTitle) ?>" required style="font-size: 13.5px; padding: 8px 12px; width: 100%; border: 1px solid #cbd5e1; border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px;">
                        Select PDF Document (Max 25MB)
                    </label>
                    <input type="file" name="dept_team_pdf" accept="application/pdf" class="form-control" style="font-size: 13px; padding: 6px 10px; width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; background: #ffffff;">
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary" style="font-size: 13px; padding: 7px 18px; border-radius: 6px;">
                    <i class="fas fa-save"></i> Save PDF Document
                </button>
            </div>
        </form>
    </div>

    <!-- Search & Quick Filter -->
    <div class="card-actions-row" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-bottom: 18px;">
        <div style="font-weight: 600; font-size: 14px; color: #475569;">
            Active Team Members (<?= count($records) ?>)
        </div>
        <div class="search-input-group" style="margin-left: auto;">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" id="teamSearch" placeholder="Search member, department, role..." onkeyup="filterTeamTable()">
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="teamTable">
            <thead>
                <tr>
                    <th style="width: 80px; text-align: center;">Sr No.</th>
                    <th style="width: 32%;">Name</th>
                    <th style="width: 34%;">Department</th>
                    <th style="width: 180px;">Designation</th>
                    <th style="width: 90px; text-align: center;">Status</th>
                    <th style="width: 110px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($records)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px; color: #64748b;">
                            No team members found. Click "Add Team Member" above to create one.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($records as $row): ?>
                <tr>
                    <td style="font-weight: 700; color: #0284c7; text-align: center;">
                        <?= (int)$row['sr_no'] ?>
                    </td>
                    <td style="font-weight: 600; color: #0f172a;">
                        <?= htmlspecialchars($row['name']) ?>
                    </td>
                    <td style="color: #334155;">
                        <?= htmlspecialchars($row['department']) ?>
                    </td>
                    <td>
                        <?php 
                        $desig = $row['designation'];
                        $isConvener = (stripos($desig, 'Convener') !== false);
                        ?>
                        <span style="font-size: 11.5px; font-weight: 600; color: <?= $isConvener ? '#b45309' : '#0284c7' ?>; background: <?= $isConvener ? '#fffbeb' : '#f0f9ff' ?>; border: 1px solid <?= $isConvener ? '#fde68a' : '#bae6fd' ?>; padding: 3px 8px; border-radius: 4px;">
                            <?= htmlspecialchars($desig) ?>
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="education-verification.php?toggle=<?= $row['id'] ?>" 
                           class="badge <?= $row['is_active'] ? 'badge-success' : 'badge-secondary' ?>" 
                           title="Click to toggle visibility" 
                           style="text-decoration: none; cursor: pointer; padding: 4px 8px; border-radius: 4px; font-size: 11px;">
                            <?= $row['is_active'] ? 'Active' : 'Hidden' ?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <div style="display: inline-flex; gap: 6px;">
                            <a href="education-verification.php?edit=<?= $row['id'] ?>" class="btn-icon edit" title="Edit Member">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="education-verification.php?delete=<?= $row['id'] ?>" 
                               class="btn-icon delete" 
                               title="Delete Member" 
                               onclick="return confirm('Are you sure you want to delete this team member?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Modal: Add Member -->
<div class="modal" id="addMemberModal" style="display: none;">
    <div class="modal-content" style="max-width: 580px;">
        <div class="modal-header">
            <h3 class="modal-title">Add Student Section Team Member</h3>
            <button type="button" class="modal-close" onclick="closeModal('addMemberModal')">&times;</button>
        </div>
        <form method="POST" action="education-verification.php">
            <input type="hidden" name="action" value="add_member">
            <div class="modal-body" style="display: flex; flex-direction: column; gap: 16px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label">Sr No. / Display Order</label>
                        <input type="number" name="sr_no" class="form-control" value="<?= count($records) + 1 ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Designation / Role</label>
                        <input type="text" name="designation" class="form-control" value="Member" placeholder="Convener, Co-Convener, Member" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Faculty / Staff Name <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Dr. Lalit Narsingani" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Department <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="department" class="form-control" placeholder="e.g. Science & Humanities Department" required>
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Visible on Public Page (Active)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addMemberModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Member</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Member -->
<?php if ($editItem): ?>
<div class="modal" id="editMemberModal" style="display: flex;">
    <div class="modal-content" style="max-width: 580px;">
        <div class="modal-header">
            <h3 class="modal-title">Edit Team Member Details</h3>
            <a href="education-verification.php" class="modal-close">&times;</a>
        </div>
        <form method="POST" action="education-verification.php">
            <input type="hidden" name="action" value="edit_member">
            <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
            <div class="modal-body" style="display: flex; flex-direction: column; gap: 16px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label">Sr No. / Display Order</label>
                        <input type="number" name="sr_no" class="form-control" value="<?= (int)$editItem['sr_no'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Designation / Role</label>
                        <input type="text" name="designation" class="form-control" value="<?= htmlspecialchars($editItem['designation']) ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Faculty / Staff Name <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($editItem['name']) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Department <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="department" class="form-control" value="<?= htmlspecialchars($editItem['department']) ?>" required>
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                        <span>Visible on Public Page (Active)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="education-verification.php" class="btn btn-secondary" style="text-decoration: none;">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Member</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
function openModal(id) {
    var modal = document.getElementById(id);
    if (modal) modal.style.display = 'flex';
}

function closeModal(id) {
    var modal = document.getElementById(id);
    if (modal) modal.style.display = 'none';
}

function filterTeamTable() {
    var input = document.getElementById("teamSearch");
    var filter = input.value.toLowerCase();
    var table = document.getElementById("teamTable");
    var tr = table.getElementsByTagName("tr");

    for (var i = 1; i < tr.length; i++) {
        var textContent = tr[i].textContent || tr[i].innerText;
        if (textContent.toLowerCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
