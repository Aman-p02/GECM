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
            INDEX `idx_enroll_year` (`academic_year`, `is_active`, `display_order`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    } catch (Exception $e) {
        error_log("Error creating student_enrollments table: " . $e->getMessage());
    }
}

// Standard Department / Branch Options
$standardBranches = [
    ['name' => 'Automobile Engineering', 'code' => 'AE', 'type' => 'UG'],
    ['name' => 'Civil Engineering', 'code' => 'CE', 'type' => 'UG'],
    ['name' => 'Computer Engineering', 'code' => 'COMP', 'type' => 'UG'],
    ['name' => 'Electrical Engineering', 'code' => 'EE', 'type' => 'UG'],
    ['name' => 'Electronics and Communication Engineering', 'code' => 'EC', 'type' => 'UG'],
    ['name' => 'Information Technology', 'code' => 'IT', 'type' => 'UG'],
    ['name' => 'Mechanical Engineering', 'code' => 'ME', 'type' => 'UG'],
    ['name' => 'Civil Engineering (PG)', 'code' => 'CE_PG', 'type' => 'PG'],
    ['name' => 'Computer Engineering (PG)', 'code' => 'COMP_PG', 'type' => 'PG'],
];

// Handle Form Submissions (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: student-enrollment.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $academic_year = trim($_POST['academic_year'] ?? '');
        $branch_name = trim($_POST['branch_name'] ?? '');
        $program_type = in_array($_POST['program_type'] ?? '', ['UG', 'PG']) ? $_POST['program_type'] : 'UG';
        $title = trim($_POST['title'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title)) {
            $title = $branch_name . ' Enrollment List (' . $academic_year . ')';
        }

        // Determine branch code
        $branch_code = 'GEN';
        foreach ($standardBranches as $sb) {
            if ($sb['name'] === $branch_name) {
                $branch_code = $sb['code'];
                break;
            }
        }

        if (empty($academic_year) || empty($branch_name)) {
            setFlashMessage('danger', 'Academic Year and Branch are required fields.');
            header('Location: student-enrollment.php');
            exit;
        }

        // Handle PDF Upload
        $upload = handlePdfUpload('pdf_file', 'enrollments');
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: student-enrollment.php');
            exit;
        }

        $file_path = $upload['path'];
        $file_size = $upload['file_size'] ?? 'PDF';

        $stmt = $pdo->prepare("INSERT INTO student_enrollments (academic_year, branch_name, branch_code, program_type, title, file_path, file_size, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$academic_year, $branch_name, $branch_code, $program_type, $title, $file_path, $file_size, $display_order, $is_active]);

        setFlashMessage('success', 'Enrollment document for ' . htmlspecialchars($branch_name) . ' (' . htmlspecialchars($academic_year) . ') uploaded successfully!');
        header('Location: student-enrollment.php?year=' . urlencode($academic_year));
        exit;

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $academic_year = trim($_POST['academic_year'] ?? '');
        $branch_name = trim($_POST['branch_name'] ?? '');
        $program_type = in_array($_POST['program_type'] ?? '', ['UG', 'PG']) ? $_POST['program_type'] : 'UG';
        $title = trim($_POST['title'] ?? '');
        $existing_file = trim($_POST['existing_file'] ?? '');
        $existing_size = trim($_POST['existing_size'] ?? 'PDF');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title)) {
            $title = $branch_name . ' Enrollment List (' . $academic_year . ')';
        }

        $branch_code = 'GEN';
        foreach ($standardBranches as $sb) {
            if ($sb['name'] === $branch_name) {
                $branch_code = $sb['code'];
                break;
            }
        }

        if (empty($academic_year) || empty($branch_name) || $id <= 0) {
            setFlashMessage('danger', 'Valid record ID, Academic Year, and Branch are required.');
            header('Location: student-enrollment.php');
            exit;
        }

        $file_path = $existing_file;
        $file_size = $existing_size;

        // Check if new PDF uploaded
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $upload = handlePdfUpload('pdf_file', 'enrollments', $existing_file);
            if ($upload['success']) {
                $file_path = $upload['path'];
                $file_size = $upload['file_size'] ?? $existing_size;
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: student-enrollment.php?edit=' . $id);
                exit;
            }
        }

        $stmt = $pdo->prepare("UPDATE student_enrollments SET academic_year = ?, branch_name = ?, branch_code = ?, program_type = ?, title = ?, file_path = ?, file_size = ?, display_order = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$academic_year, $branch_name, $branch_code, $program_type, $title, $file_path, $file_size, $display_order, $is_active, $id]);

        setFlashMessage('success', 'Enrollment record updated successfully!');
        header('Location: student-enrollment.php?year=' . urlencode($academic_year));
        exit;
    }
}

// Handle GET Actions (Delete, Toggle, Edit)
if (isset($_GET['delete'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP.');
        header('Location: student-enrollment.php');
        exit;
    }
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT file_path FROM student_enrollments WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row && !empty($row['file_path']) && $row['file_path'] !== 'uploads/enrollments/sample_enrollment.pdf') {
            $realFile = realpath(__DIR__ . '/../' . $row['file_path']);
            if ($realFile && file_exists($realFile)) {
                @unlink($realFile);
            }
        }
        $stmt = $pdo->prepare("DELETE FROM student_enrollments WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Enrollment record deleted successfully!');
        header('Location: student-enrollment.php');
        exit;
    }
}

if (isset($_GET['toggle'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP.');
        header('Location: student-enrollment.php');
        exit;
    }
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE student_enrollments SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('info', 'Enrollment status updated successfully!');
        header('Location: student-enrollment.php' . (isset($_GET['year']) ? '?year=' . urlencode($_GET['year']) : ''));
        exit;
    }
}

if (isset($_GET['edit']) && $pdo) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM student_enrollments WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

// Filter by Academic Year
$filterYear = trim($_GET['year'] ?? '');

// Fetch distinct academic years for filter tabs
$academicYears = [];
if ($pdo) {
    try {
        $academicYears = $pdo->query("SELECT DISTINCT academic_year FROM student_enrollments ORDER BY academic_year DESC")->fetchAll(PDO::FETCH_COLUMN);
    } catch (Exception $e) {
        $academicYears = [];
    }
}

// Fetch enrollment records
$records = [];
if ($pdo) {
    try {
        if (!empty($filterYear)) {
            $stmt = $pdo->prepare("SELECT * FROM student_enrollments WHERE academic_year = ? ORDER BY display_order ASC, id ASC");
            $stmt->execute([$filterYear]);
            $records = $stmt->fetchAll();
        } else {
            $stmt = $pdo->query("SELECT * FROM student_enrollments ORDER BY academic_year DESC, display_order ASC, id ASC");
            $records = $stmt->fetchAll();
        }
    } catch (Exception $e) {
        $records = [];
    }
}

$current_page = 'student-enrollment';
$page_title = 'Student Enrollment Management';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <h2 class="card-title">Student Enrollment Details</h2>
            <p style="font-size: 13.5px; color: #64748b; margin: 4px 0 0 0;">
                Manage official GTU student enrollment registers and branch-wise PDF documents by academic year.
            </p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <a href="../enrollment-details" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; text-decoration: none;">
                <i class="fas fa-external-link-alt"></i> View Public Page
            </a>
            <button type="button" class="btn-add-new" onclick="openModal('addEnrollmentModal')">
                <i class="fas fa-plus"></i> Upload Enrollment PDF
            </button>
        </div>
    </div>

    <!-- Year Filter Tabs & Search -->
    <div class="card-actions-row" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-bottom: 20px;">
        <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
            <a href="student-enrollment.php" class="btn btn-sm <?= empty($filterYear) ? 'btn-primary' : 'btn-secondary' ?>" style="text-decoration: none; border-radius: 20px; padding: 6px 14px; font-size: 13px;">
                All Years (<?= count($pdo ? $pdo->query("SELECT id FROM student_enrollments")->fetchAll() : []) ?>)
            </a>
            <?php foreach ($academicYears as $yr): ?>
                <a href="student-enrollment.php?year=<?= urlencode($yr) ?>" class="btn btn-sm <?= ($filterYear === $yr) ? 'btn-primary' : 'btn-secondary' ?>" style="text-decoration: none; border-radius: 20px; padding: 6px 14px; font-size: 13px;">
                    <?= htmlspecialchars($yr) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="search-input-group" style="margin-left: auto;">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" placeholder="Search branch or year..." data-table-search="enrollmentsTable">
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="enrollmentsTable">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">Order</th>
                    <th style="width: 120px;">Academic Year</th>
                    <th>Branch / Program</th>
                    <th style="width: 90px; text-align: center;">Level</th>
                    <th>PDF Document</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="width: 130px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $row): ?>
                <tr data-status="<?= $row['is_active'] ? 'active' : 'inactive' ?>">
                    <td style="font-weight: 700; color: #1e88e5; text-align: center;">#<?= (int)$row['display_order'] ?></td>
                    <td>
                        <span style="font-weight: 700; color: #0284c7; background: #e0f2fe; padding: 4px 10px; border-radius: 12px; font-size: 12.5px;">
                            <?= htmlspecialchars($row['academic_year']) ?>
                        </span>
                    </td>
                    <td style="font-weight: 600; color: #1a263d;">
                        <?= htmlspecialchars($row['branch_name']) ?>
                        <div style="font-size: 12px; color: #64748b; font-weight: normal; margin-top: 2px;">
                            <?= htmlspecialchars($row['title'] ?? '') ?>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <?php if ($row['program_type'] === 'PG'): ?>
                            <span class="badge" style="background: #fef3c7; color: #d97706; font-weight: 700; border: 1px solid #fde68a;">PG</span>
                        <?php else: ?>
                            <span class="badge" style="background: #e0f2fe; color: #0369a1; font-weight: 700; border: 1px solid #bae6fd;">UG</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($row['file_path']) && file_exists(__DIR__ . '/../' . $row['file_path'])): ?>
                            <a href="../<?= htmlspecialchars($row['file_path']) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 6px; color: #dc2626; font-weight: 600; text-decoration: none; font-size: 13px;">
                                <i class="fas fa-file-pdf" style="font-size: 16px;"></i>
                                <span>View PDF</span>
                            </a>
                        <?php else: ?>
                            <span style="font-size: 12px; color: #94a3b8; font-style: italic;">No PDF Uploaded</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="student-enrollment.php?toggle=<?= (int)$row['id'] ?><?= !empty($filterYear) ? '&year=' . urlencode($filterYear) : '' ?>" title="Click to toggle status" style="text-decoration: none;">
                            <?php if ($row['is_active']): ?>
                                <span class="badge badge-success"><i class="fas fa-check"></i> Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><i class="fas fa-eye-slash"></i> Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <div class="table-actions" style="justify-content: center;">
                            <a href="student-enrollment.php?edit=<?= (int)$row['id'] ?>" class="btn-table-action btn-edit" title="Edit Record">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="student-enrollment.php?delete=<?= (int)$row['id'] ?>" class="btn-table-action btn-delete" title="Delete Record" onclick="return confirm('Are you sure you want to delete this enrollment document?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($records)): ?>
                <tr class="no-records-row">
                    <td colspan="7" style="text-align: center; color: #888; padding: 36px 16px;">
                        <div style="font-size: 36px; color: #cbd5e1; margin-bottom: 8px;"><i class="fas fa-folder-open"></i></div>
                        <div style="font-size: 15px; font-weight: 600; color: #475569;">No Enrollment Records Found.</div>
                        <div style="font-size: 13px; color: #94a3b8; margin-top: 4px;">Click the "+ Upload Enrollment PDF" button above to add enrollment records.</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add Enrollment PDF -->
<div class="modal-overlay" id="addEnrollmentModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Upload Student Enrollment PDF</h3>
            <button type="button" class="modal-close" onclick="closeModal('addEnrollmentModal')">&times;</button>
        </div>
        <form method="POST" action="student-enrollment.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="add_academic_year">Academic Year <span class="required">*</span></label>
                        <select name="academic_year" id="add_academic_year" class="form-control" required>
                            <option value="2025-26" selected>2025-26</option>
                            <option value="2024-25">2024-25</option>
                            <option value="2023-24">2023-24</option>
                            <option value="2022-23">2022-23</option>
                            <option value="2021-22">2021-22</option>
                            <option value="2020-21">2020-21</option>
                        </select>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="add_program_type">Program Level <span class="required">*</span></label>
                        <select name="program_type" id="add_program_type" class="form-control" required>
                            <option value="UG" selected>Undergraduate (B.E.)</option>
                            <option value="PG">Postgraduate (M.E.)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_branch_name">Branch / Department <span class="required">*</span></label>
                    <select name="branch_name" id="add_branch_name" class="form-control" required>
                        <?php foreach ($standardBranches as $sb): ?>
                            <option value="<?= htmlspecialchars($sb['name']) ?>">
                                <?= htmlspecialchars($sb['name']) ?> [<?= $sb['type'] ?>]
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_pdf_file">Upload Enrollment PDF Document <span class="required">*</span></label>
                    <input type="file" name="pdf_file" id="add_pdf_file" class="form-control" accept=".pdf,application/pdf" required>
                    <div style="font-size: 11.5px; color: #6c757d; margin-top: 5px;">
                        Only official PDF documents allowed (Max size: 25MB).
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_title">Document Title / Remarks (Optional)</label>
                    <input type="text" name="title" id="add_title" class="form-control" placeholder="e.g. Computer Engineering Enrollment Register (2025-26)">
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="add_display_order">Display Order</label>
                        <input type="number" name="display_order" id="add_display_order" class="form-control" value="1" min="0">
                    </div>
                    <div class="form-group" style="flex: 1; display: flex; align-items: center; padding-top: 26px;">
                        <label class="form-check" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1" checked>
                            <span>Active (Published on website)</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addEnrollmentModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-cloud-upload-alt"></i> Upload Document</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Enrollment PDF -->
<?php if ($editItem): ?>
<div class="modal-overlay active show" id="editEnrollmentModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Edit Enrollment Record #<?= (int)$editItem['id'] ?></h3>
            <a href="student-enrollment.php" class="modal-close">&times;</a>
        </div>
        <form method="POST" action="student-enrollment.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
            <input type="hidden" name="existing_file" value="<?= htmlspecialchars($editItem['file_path']) ?>">
            <input type="hidden" name="existing_size" value="<?= htmlspecialchars($editItem['file_size'] ?? 'PDF') ?>">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="edit_academic_year">Academic Year <span class="required">*</span></label>
                        <select name="academic_year" id="edit_academic_year" class="form-control" required>
                            <?php foreach (['2025-26', '2024-25', '2023-24', '2022-23', '2021-22', '2020-21'] as $yr): ?>
                                <option value="<?= $yr ?>" <?= ($editItem['academic_year'] === $yr) ? 'selected' : '' ?>><?= $yr ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="edit_program_type">Program Level <span class="required">*</span></label>
                        <select name="program_type" id="edit_program_type" class="form-control" required>
                            <option value="UG" <?= ($editItem['program_type'] === 'UG') ? 'selected' : '' ?>>Undergraduate (B.E.)</option>
                            <option value="PG" <?= ($editItem['program_type'] === 'PG') ? 'selected' : '' ?>>Postgraduate (M.E.)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_branch_name">Branch / Department <span class="required">*</span></label>
                    <select name="branch_name" id="edit_branch_name" class="form-control" required>
                        <?php foreach ($standardBranches as $sb): ?>
                            <option value="<?= htmlspecialchars($sb['name']) ?>" <?= ($editItem['branch_name'] === $sb['name']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($sb['name']) ?> [<?= $sb['type'] ?>]
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Current PDF Document</label>
                    <?php if (!empty($editItem['file_path']) && file_exists(__DIR__ . '/../' . $editItem['file_path'])): ?>
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                            <a href="../<?= htmlspecialchars($editItem['file_path']) ?>" target="_blank" rel="noopener noreferrer" style="color: #dc2626; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fas fa-file-pdf" style="font-size: 18px;"></i>
                                <span><?= htmlspecialchars($editItem['file_path']) ?></span>
                            </a>
                        </div>
                    <?php else: ?>
                        <div style="font-size: 13px; color: #94a3b8; margin-bottom: 8px; font-style: italic;">No PDF document uploaded yet.</div>
                    <?php endif; ?>
                    <label class="form-label" for="edit_pdf_file">Upload PDF Document</label>
                    <input type="file" name="pdf_file" id="edit_pdf_file" class="form-control" accept=".pdf,application/pdf">
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_title">Document Title / Remarks</label>
                    <input type="text" name="title" id="edit_title" class="form-control" value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="edit_display_order">Display Order</label>
                        <input type="number" name="display_order" id="edit_display_order" class="form-control" value="<?= (int)$editItem['display_order'] ?>" min="0">
                    </div>
                    <div class="form-group" style="flex: 1; display: flex; align-items: center; padding-top: 26px;">
                        <label class="form-check" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                            <span>Active (Published on website)</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="student-enrollment.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
