<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

// Self-healing database table setup
if ($pdo) {
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `student_enrollments` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `academic_year` VARCHAR(20) NOT NULL,
            `branch_name` VARCHAR(100) NOT NULL,
            `branch_code` VARCHAR(20) DEFAULT NULL,
            `program_type` ENUM('UG', 'PG') NOT NULL DEFAULT 'UG',
            `title` VARCHAR(255) DEFAULT NULL,
            `file_path` VARCHAR(255) NOT NULL,
            `file_size` VARCHAR(50) DEFAULT NULL,
            `display_order` INT NOT NULL DEFAULT 0,
            `is_active` TINYINT(1) NOT NULL DEFAULT 1,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_enroll_year` (`academic_year`, `is_active`, `display_order`),
            INDEX `idx_enroll_dept` (`branch_code`, `academic_year`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    } catch (Exception $e) {
        error_log("Error creating student_enrollments table: " . $e->getMessage());
    }
}

// Simple Clean Departments List (Only Department Name & Degree BE or ME)
$departments = [
    ['code' => 'COMP',    'name' => 'Computer Engineering',                       'degree' => 'B.E.', 'type' => 'UG'],
    ['code' => 'IT',      'name' => 'Information Technology',                      'degree' => 'B.E.', 'type' => 'UG'],
    ['code' => 'ME',      'name' => 'Mechanical Engineering',                      'degree' => 'B.E.', 'type' => 'UG'],
    ['code' => 'CE',      'name' => 'Civil Engineering',                           'degree' => 'B.E.', 'type' => 'UG'],
    ['code' => 'EE',      'name' => 'Electrical Engineering',                      'degree' => 'B.E.', 'type' => 'UG'],
    ['code' => 'EC',      'name' => 'Electronics and Communication Engineering',   'degree' => 'B.E.', 'type' => 'UG'],
    ['code' => 'AE',      'name' => 'Automobile Engineering',                      'degree' => 'B.E.', 'type' => 'UG'],
    ['code' => 'COMP_PG', 'name' => 'Computer Engineering (PG)',                  'degree' => 'M.E.', 'type' => 'PG'],
    ['code' => 'CE_PG',   'name' => 'Civil Engineering (PG)',                     'degree' => 'M.E.', 'type' => 'PG'],
];

// Helper to get department by code
function findDepartment($code, $departments) {
    foreach ($departments as $d) {
        if ($d['code'] === $code || $d['name'] === $code) {
            return $d;
        }
    }
    return null;
}

// Clean up any dummy sample records if present
if ($pdo) {
    try {
        $pdo->exec("DELETE FROM student_enrollments WHERE file_path LIKE '%sample_enrollment.pdf%' OR file_path LIKE '%sample%'");
    } catch (Exception $e) {
        // silent
    }
}

// Handle Form Submissions (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP.');
        header('Location: student-enrollment.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $academic_year = trim($_POST['academic_year'] ?? '');
        $branch_code = trim($_POST['branch_code'] ?? '');
        $deptInfo = findDepartment($branch_code, $departments);

        if (!$deptInfo || empty($academic_year)) {
            setFlashMessage('danger', 'Please select a valid Department and Academic Year.');
            header('Location: student-enrollment.php' . (!empty($branch_code) ? '?dept=' . urlencode($branch_code) : ''));
            exit;
        }

        $branch_name = $deptInfo['name'];
        $program_type = $deptInfo['type'];
        $title = $branch_name . ' (' . $academic_year . ')';
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        // Handle PDF Upload
        $upload = handlePdfUpload('pdf_file', 'enrollments');
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: student-enrollment.php?dept=' . urlencode($branch_code));
            exit;
        }

        $file_path = $upload['path'];
        $file_size = $upload['file_size'] ?? 'PDF';

        $stmt = $pdo->prepare("INSERT INTO student_enrollments (academic_year, branch_name, branch_code, program_type, title, file_path, file_size, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$academic_year, $branch_name, $branch_code, $program_type, $title, $file_path, $file_size, $display_order, $is_active]);

        setFlashMessage('success', 'PDF uploaded for ' . htmlspecialchars($academic_year) . '!');
        header('Location: student-enrollment.php?dept=' . urlencode($branch_code));
        exit;

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $academic_year = trim($_POST['academic_year'] ?? '');
        $branch_code = trim($_POST['branch_code'] ?? '');
        $deptInfo = findDepartment($branch_code, $departments);
        $existing_file = trim($_POST['existing_file'] ?? '');
        $existing_size = trim($_POST['existing_size'] ?? 'PDF');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!$deptInfo || empty($academic_year) || $id <= 0) {
            setFlashMessage('danger', 'Invalid record parameters.');
            header('Location: student-enrollment.php');
            exit;
        }

        $branch_name = $deptInfo['name'];
        $program_type = $deptInfo['type'];
        $title = $branch_name . ' (' . $academic_year . ')';
        $file_path = $existing_file;
        $file_size = $existing_size;

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $upload = handlePdfUpload('pdf_file', 'enrollments', $existing_file);
            if ($upload['success']) {
                $file_path = $upload['path'];
                $file_size = $upload['file_size'] ?? $existing_size;
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: student-enrollment.php?dept=' . urlencode($branch_code) . '&edit=' . $id);
                exit;
            }
        }

        $stmt = $pdo->prepare("UPDATE student_enrollments SET academic_year = ?, branch_name = ?, branch_code = ?, program_type = ?, title = ?, file_path = ?, file_size = ?, display_order = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$academic_year, $branch_name, $branch_code, $program_type, $title, $file_path, $file_size, $display_order, $is_active, $id]);

        setFlashMessage('success', 'Record updated successfully!');
        header('Location: student-enrollment.php?dept=' . urlencode($branch_code));
        exit;
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: student-enrollment.php');
        exit;
    }
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT file_path, branch_code FROM student_enrollments WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        $targetDept = $row['branch_code'] ?? ($_GET['dept'] ?? '');
        if ($row && !empty($row['file_path'])) {
            $realFile = realpath(__DIR__ . '/../' . $row['file_path']);
            if ($realFile && file_exists($realFile)) {
                @unlink($realFile);
            }
        }
        $stmt = $pdo->prepare("DELETE FROM student_enrollments WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Record deleted successfully!');
        header('Location: student-enrollment.php' . (!empty($targetDept) ? '?dept=' . urlencode($targetDept) : ''));
        exit;
    }
}

// Handle Hide / Show Status Toggle
if (isset($_GET['toggle'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: student-enrollment.php');
        exit;
    }
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT is_active, branch_code FROM student_enrollments WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        $targetDept = $row['branch_code'] ?? ($_GET['dept'] ?? '');
        $newStatus = ($row && $row['is_active'] == 1) ? 0 : 1;

        $stmt = $pdo->prepare("UPDATE student_enrollments SET is_active = ? WHERE id = ?");
        $stmt->execute([$newStatus, $id]);

        setFlashMessage('info', $newStatus ? 'Document is now Visible.' : 'Document is now Hidden.');
        header('Location: student-enrollment.php' . (!empty($targetDept) ? '?dept=' . urlencode($targetDept) : ''));
        exit;
    }
}

// Handle Edit Fetch
if (isset($_GET['edit']) && $pdo) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM student_enrollments WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

// Current Selected Department
$selectedDept = trim($_GET['dept'] ?? '');
$activeDept = findDepartment($selectedDept, $departments);

// Fetch Records for Active Department
$deptRecords = [];
if ($activeDept && $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM student_enrollments WHERE branch_code = ? OR branch_name = ? ORDER BY academic_year DESC, id ASC");
        $stmt->execute([$activeDept['code'], $activeDept['name']]);
        $deptRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $deptRecords = [];
    }
}

$current_page = 'student-enrollment';
$page_title = $activeDept ? ($activeDept['name'] . ' - Enrollment') : 'Student Enrollment';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">

    <?php if (!$activeDept): ?>
        <!-- ============================================================== -->
        <!-- SCREEN 1: ALL DEPARTMENTS (ONLY DEPARTMENT NAME & BE / ME)     -->
        <!-- ============================================================== -->
        <div class="card-top">
            <div class="card-title-group">
                <h2 class="card-title">Student Enrollment</h2>
            </div>
            <a href="../student-corner/enrollment-details" target="_blank" class="btn btn-secondary btn-sm" style="text-decoration: none;">
                <i class="fas fa-external-link-alt"></i> View Public Page
            </a>
        </div>

        <!-- Clean Departments List (Simple Design, No Clutter) -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 14px; margin-top: 14px;">
            <?php foreach ($departments as $d): ?>
                <a href="student-enrollment.php?dept=<?= urlencode($d['code']) ?>" 
                   style="display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #1e293b; transition: border-color 0.15s ease, background-color 0.15s ease;"
                   onmouseover="this.style.borderColor='#0284c7'; this.style.backgroundColor='#f8fafc';"
                   onmouseout="this.style.borderColor='#e2e8f0'; this.style.backgroundColor='#ffffff';">
                    <span style="font-size: 15px; font-weight: 600; color: #0f172a;">
                        <?= htmlspecialchars($d['name']) ?>
                    </span>
                    <span style="font-size: 12px; font-weight: 700; color: #0284c7; background: #f0f9ff; border: 1px solid #bae6fd; padding: 3px 10px; border-radius: 4px;">
                        <?= htmlspecialchars($d['degree']) ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>

    <?php else: ?>
        <!-- ============================================================== -->
        <!-- SCREEN 2: INSIDE DEPARTMENT (YEAR, BE/ME, PDF, HIDE, EDIT/DEL) -->
        <!-- ============================================================== -->
        <div class="card-top" style="margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                <a href="student-enrollment.php" class="btn btn-secondary btn-sm" style="text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fas fa-arrow-left"></i> Back to Departments
                </a>
                <h2 class="card-title" style="margin: 0; font-size: 18px;">
                    <?= htmlspecialchars($activeDept['name']) ?> 
                    <span style="font-size: 13px; font-weight: 700; color: #0284c7; background: #f0f9ff; border: 1px solid #bae6fd; padding: 2px 8px; border-radius: 4px; margin-left: 6px;">
                        <?= htmlspecialchars($activeDept['degree']) ?>
                    </span>
                </h2>
            </div>
            <button type="button" class="btn-add-new" onclick="openModal('addEnrollmentModal')">
                + Upload New PDF
            </button>
        </div>

        <!-- Simple Clean Table -->
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 140px;">Academic Year</th>
                        <th style="width: 90px; text-align: center;">Program</th>
                        <th>PDF Document</th>
                        <th style="width: 120px; text-align: center;">Status</th>
                        <th style="width: 120px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($deptRecords as $row): 
                        $progLabel = ($row['program_type'] === 'PG') ? 'M.E.' : 'B.E.';
                    ?>
                    <tr>
                        <td style="font-weight: 600; color: #0f172a;">
                            <?= htmlspecialchars($row['academic_year']) ?>
                        </td>
                        <td style="text-align: center;">
                            <span style="font-size: 12px; font-weight: 600; color: #475569;">
                                <?= $progLabel ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($row['file_path']) && file_exists(__DIR__ . '/../' . $row['file_path'])): ?>
                                <a href="../<?= htmlspecialchars($row['file_path']) ?>" target="_blank" rel="noopener noreferrer" style="color: #dc2626; font-weight: 600; text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-file-pdf"></i> View PDF
                                </a>
                            <?php else: ?>
                                <span style="font-size: 12px; color: #94a3b8;">No File</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <a href="student-enrollment.php?toggle=<?= (int)$row['id'] ?>&dept=<?= urlencode($activeDept['code']) ?>" 
                               title="Click to Hide or Show" 
                               style="text-decoration: none;">
                                <?php if ($row['is_active']): ?>
                                    <span class="badge badge-success" style="cursor: pointer;">Visible</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary" style="cursor: pointer; background: #94a3b8; color: #ffffff;">Hidden</span>
                                <?php endif; ?>
                            </a>
                        </td>
                        <td style="text-align: center;">
                            <div class="table-actions" style="justify-content: center;">
                                <a href="student-enrollment.php?dept=<?= urlencode($activeDept['code']) ?>&edit=<?= (int)$row['id'] ?>" class="btn-table-action btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="student-enrollment.php?dept=<?= urlencode($activeDept['code']) ?>&delete=<?= (int)$row['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Delete enrollment PDF for <?= htmlspecialchars(addslashes($row['academic_year'])) ?>?');">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($deptRecords)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #64748b; padding: 30px;">
                            No enrollment records found for <?= htmlspecialchars($activeDept['name']) ?>. Click "+ Upload New PDF" above to add.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

<!-- Modal: Add Enrollment PDF -->
<div class="modal-overlay" id="addEnrollmentModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Upload Enrollment PDF</h3>
            <button type="button" class="modal-close" onclick="closeModal('addEnrollmentModal')">&times;</button>
        </div>
        <form method="POST" action="student-enrollment.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Department</label>
                    <select name="branch_code" class="form-control" required>
                        <?php foreach ($departments as $d): ?>
                            <option value="<?= htmlspecialchars($d['code']) ?>" <?= (!empty($activeDept) && $activeDept['code'] === $d['code']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($d['name']) ?> (<?= $d['degree'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Academic Year <span class="required">*</span></label>
                    <select name="academic_year" class="form-control" required>
                        <option value="2025-26" selected>2025-26</option>
                        <option value="2024-25">2024-25</option>
                        <option value="2023-24">2023-24</option>
                        <option value="2022-23">2022-23</option>
                        <option value="2021-22">2021-22</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Upload PDF Document <span class="required">*</span></label>
                    <input type="file" name="pdf_file" class="form-control" accept=".pdf,application/pdf" required>
                </div>

                <div class="form-group">
                    <label class="form-check" style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin-top: 10px;">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Visible on website</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addEnrollmentModal')">Cancel</button>
                <button type="submit" class="btn-primary">Upload PDF</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Enrollment PDF -->
<?php if ($editItem): ?>
<div class="modal-overlay active show" id="editEnrollmentModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Edit Enrollment Record</h3>
            <a href="student-enrollment.php<?= !empty($selectedDept) ? '?dept=' . urlencode($selectedDept) : '' ?>" class="modal-close">&times;</a>
        </div>
        <form method="POST" action="student-enrollment.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
            <input type="hidden" name="existing_file" value="<?= htmlspecialchars($editItem['file_path']) ?>">
            <input type="hidden" name="existing_size" value="<?= htmlspecialchars($editItem['file_size'] ?? 'PDF') ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Department</label>
                    <select name="branch_code" class="form-control" required>
                        <?php foreach ($departments as $d): ?>
                            <option value="<?= htmlspecialchars($d['code']) ?>" <?= ($editItem['branch_code'] === $d['code'] || $editItem['branch_name'] === $d['name']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($d['name']) ?> (<?= $d['degree'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Academic Year <span class="required">*</span></label>
                    <select name="academic_year" class="form-control" required>
                        <?php foreach (['2025-26', '2024-25', '2023-24', '2022-23', '2021-22'] as $yr): ?>
                            <option value="<?= $yr ?>" <?= ($editItem['academic_year'] === $yr) ? 'selected' : '' ?>><?= $yr ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Current PDF Document</label>
                    <?php if (!empty($editItem['file_path']) && file_exists(__DIR__ . '/../' . $editItem['file_path'])): ?>
                        <div style="margin-bottom: 8px;">
                            <a href="../<?= htmlspecialchars($editItem['file_path']) ?>" target="_blank" rel="noopener noreferrer" style="color: #dc2626; font-weight: 600; text-decoration: none; font-size: 13px;">
                                <i class="fas fa-file-pdf"></i> View Current PDF
                            </a>
                        </div>
                    <?php endif; ?>
                    <label class="form-label">Upload New PDF to Replace (Optional)</label>
                    <input type="file" name="pdf_file" class="form-control" accept=".pdf,application/pdf">
                </div>

                <div class="form-group">
                    <label class="form-check" style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin-top: 10px;">
                        <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                        <span>Visible on website</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="student-enrollment.php<?= !empty($selectedDept) ? '?dept=' . urlencode($selectedDept) : '' ?>" class="btn-secondary" style="text-decoration: none;">Cancel</a>
                <button type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
