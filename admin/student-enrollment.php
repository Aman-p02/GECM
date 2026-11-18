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

// Standard Department / Branch Options with Icons and Short Names
$standardBranches = [
    ['name' => 'Computer Engineering', 'code' => 'COMP', 'type' => 'UG', 'icon' => 'fa-laptop-code', 'short' => 'Computer'],
    ['name' => 'Information Technology', 'code' => 'IT', 'type' => 'UG', 'icon' => 'fa-network-wired', 'short' => 'IT'],
    ['name' => 'Civil Engineering', 'code' => 'CE', 'type' => 'UG', 'icon' => 'fa-building', 'short' => 'Civil'],
    ['name' => 'Mechanical Engineering', 'code' => 'ME', 'type' => 'UG', 'icon' => 'fa-cogs', 'short' => 'Mechanical'],
    ['name' => 'Electrical Engineering', 'code' => 'EE', 'type' => 'UG', 'icon' => 'fa-bolt', 'short' => 'Electrical'],
    ['name' => 'Electronics and Communication Engineering', 'code' => 'EC', 'type' => 'UG', 'icon' => 'fa-microchip', 'short' => 'EC'],
    ['name' => 'Automobile Engineering', 'code' => 'AE', 'type' => 'UG', 'icon' => 'fa-car', 'short' => 'Automobile'],
    ['name' => 'Civil Engineering (PG)', 'code' => 'CE_PG', 'type' => 'PG', 'icon' => 'fa-graduation-cap', 'short' => 'Civil (PG)'],
    ['name' => 'Computer Engineering (PG)', 'code' => 'COMP_PG', 'type' => 'PG', 'icon' => 'fa-graduation-cap', 'short' => 'Computer (PG)'],
];

// Auto-seed standard GTU departments and academic years if table is empty
if ($pdo) {
    try {
        $checkCount = (int)$pdo->query("SELECT COUNT(*) FROM student_enrollments")->fetchColumn();
        if ($checkCount === 0) {
            $defaultYears = ['2025-26', '2024-25', '2023-24', '2022-23'];
            $samplePdfPath = 'uploads/enrollments/sample_enrollment.pdf';
            $insStmt = $pdo->prepare("INSERT INTO student_enrollments 
                (academic_year, branch_name, branch_code, program_type, title, file_path, file_size, display_order, is_active) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $order = 1;
            foreach ($defaultYears as $yr) {
                foreach ($standardBranches as $sb) {
                    $docTitle = $sb['name'] . ' Enrollment Register (' . $yr . ')';
                    $insStmt->execute([
                        $yr,
                        $sb['name'],
                        $sb['code'],
                        $sb['type'],
                        $docTitle,
                        $samplePdfPath,
                        '30 KB',
                        $order++,
                        1
                    ]);
                }
            }
        }
    } catch (Exception $e) {
        error_log("Student Enrollment Auto-seed Error: " . $e->getMessage());
    }
}

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
            $title = $branch_name . ' Enrollment Register (' . $academic_year . ')';
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
        header('Location: student-enrollment.php?dept=' . urlencode($branch_code) . '&year=' . urlencode($academic_year));
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
            $title = $branch_name . ' Enrollment Register (' . $academic_year . ')';
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
        header('Location: student-enrollment.php?dept=' . urlencode($branch_code) . '&year=' . urlencode($academic_year));
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
        $redirQuery = [];
        if (!empty($_GET['dept'])) $redirQuery['dept'] = $_GET['dept'];
        if (!empty($_GET['year'])) $redirQuery['year'] = $_GET['year'];
        header('Location: student-enrollment.php' . (!empty($redirQuery) ? '?' . http_build_query($redirQuery) : ''));
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
        $redirQuery = [];
        if (!empty($_GET['dept'])) $redirQuery['dept'] = $_GET['dept'];
        if (!empty($_GET['year'])) $redirQuery['year'] = $_GET['year'];
        header('Location: student-enrollment.php' . (!empty($redirQuery) ? '?' . http_build_query($redirQuery) : ''));
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

// Filter by Department and Academic Year
$selectedDept = trim($_GET['dept'] ?? '');
$filterYear = trim($_GET['year'] ?? '');

// Match active branch info
$activeBranchInfo = null;
if (!empty($selectedDept)) {
    foreach ($standardBranches as $sb) {
        if ($sb['code'] === $selectedDept || $sb['name'] === $selectedDept) {
            $activeBranchInfo = $sb;
            break;
        }
    }
}

// Fetch department counts and total count
$deptCounts = [];
$totalRecordsCount = 0;
if ($pdo) {
    try {
        $totalRecordsCount = (int)$pdo->query("SELECT COUNT(*) FROM student_enrollments")->fetchColumn();
        $countRows = $pdo->query("SELECT branch_code, branch_name, COUNT(*) as total FROM student_enrollments GROUP BY branch_code, branch_name")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($countRows as $cr) {
            if (!empty($cr['branch_code'])) {
                $deptCounts[$cr['branch_code']] = (int)$cr['total'];
            }
            if (!empty($cr['branch_name'])) {
                $deptCounts[$cr['branch_name']] = (int)$cr['total'];
            }
        }
    } catch (Exception $e) {
        $deptCounts = [];
        $totalRecordsCount = 0;
    }
}

// Fetch distinct academic years for filter tabs
$academicYears = [];
if ($pdo) {
    try {
        if (!empty($selectedDept)) {
            $stmt = $pdo->prepare("SELECT DISTINCT academic_year FROM student_enrollments WHERE branch_code = ? OR branch_name = ? ORDER BY academic_year DESC");
            $stmt->execute([$selectedDept, $selectedDept]);
            $academicYears = $stmt->fetchAll(PDO::FETCH_COLUMN);
        } else {
            $academicYears = $pdo->query("SELECT DISTINCT academic_year FROM student_enrollments ORDER BY academic_year DESC")->fetchAll(PDO::FETCH_COLUMN);
        }
    } catch (Exception $e) {
        $academicYears = [];
    }
}

// Fetch enrollment records based on department and year filters
$records = [];
if ($pdo) {
    try {
        if (!empty($selectedDept) && !empty($filterYear)) {
            $stmt = $pdo->prepare("SELECT * FROM student_enrollments WHERE (branch_code = ? OR branch_name = ?) AND academic_year = ? ORDER BY academic_year DESC, display_order ASC, id ASC");
            $stmt->execute([$selectedDept, $selectedDept, $filterYear]);
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif (!empty($selectedDept)) {
            $stmt = $pdo->prepare("SELECT * FROM student_enrollments WHERE (branch_code = ? OR branch_name = ?) ORDER BY academic_year DESC, display_order ASC, id ASC");
            $stmt->execute([$selectedDept, $selectedDept]);
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif (!empty($filterYear)) {
            $stmt = $pdo->prepare("SELECT * FROM student_enrollments WHERE academic_year = ? ORDER BY branch_name ASC, display_order ASC, id ASC");
            $stmt->execute([$filterYear]);
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $pdo->query("SELECT * FROM student_enrollments ORDER BY academic_year DESC, branch_name ASC, display_order ASC, id ASC");
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <!-- Card Top Header -->
    <div class="card-top">
        <div class="card-title-group">
            <h2 class="card-title">Student Enrollment Details</h2>
            <p style="font-size: 13.5px; color: #64748b; margin: 4px 0 0 0;">
                Official GTU student enrollment registers and branch-wise PDF documents organized by department and academic year.
            </p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <a href="../student-corner/enrollment-details" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; text-decoration: none;">
                <i class="fas fa-external-link-alt"></i> View Public Page
            </a>
            <button type="button" class="btn-add-new" onclick="openAddModalWithBranch('<?= !empty($activeBranchInfo) ? htmlspecialchars($activeBranchInfo['name']) : '' ?>', '<?= !empty($activeBranchInfo) ? $activeBranchInfo['type'] : 'UG' ?>')">
                <i class="fas fa-plus"></i> Upload Enrollment PDF
            </button>
        </div>
    </div>

    <!-- Department Navigation Tabs (Show All Departments with One-Click Access) -->
    <div style="margin-bottom: 22px; padding: 14px 16px; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
        <div style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;">
            <span style="display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-building" style="color: #0284c7;"></i> Select Department to View All Academic Years
            </span>
            <span style="font-size: 11.5px; color: #94a3b8; font-weight: 500; text-transform: none;">
                Click any department below to view its all-year enrollment registers
            </span>
        </div>
        <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
            <a href="student-enrollment.php" 
               class="btn btn-sm <?= empty($selectedDept) ? 'btn-primary' : 'btn-light' ?>" 
               style="border-radius: 20px; padding: 7px 15px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; <?= empty($selectedDept) ? 'box-shadow: 0 2px 8px rgba(2, 132, 199, 0.25);' : 'border: 1px solid #e2e8f0; background: #f8fafc;' ?>">
                <i class="fas fa-layer-group"></i> All Departments
                <span class="badge" style="background: <?= empty($selectedDept) ? 'rgba(255,255,255,0.25)' : '#e2e8f0' ?>; color: <?= empty($selectedDept) ? '#ffffff' : '#475569' ?>; font-size: 11px; padding: 2px 6px; border-radius: 10px;">
                    <?= $totalRecordsCount ?>
                </span>
            </a>
            <?php foreach ($standardBranches as $sb): 
                $isActive = ($selectedDept === $sb['code'] || $selectedDept === $sb['name']);
                $count = $deptCounts[$sb['code']] ?? ($deptCounts[$sb['name']] ?? 0);
            ?>
                <a href="student-enrollment.php?dept=<?= urlencode($sb['code']) ?>" 
                   class="btn btn-sm <?= $isActive ? 'btn-primary' : 'btn-light' ?>" 
                   style="border-radius: 20px; padding: 7px 14px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; <?= $isActive ? 'box-shadow: 0 2px 8px rgba(2, 132, 199, 0.25);' : 'border: 1px solid #e2e8f0; background: #f8fafc;' ?>">
                    <i class="fas <?= $sb['icon'] ?>"></i>
                    <span><?= htmlspecialchars($sb['name']) ?></span>
                    <span class="badge" style="background: <?= $isActive ? 'rgba(255,255,255,0.25)' : '#e2e8f0' ?>; color: <?= $isActive ? '#ffffff' : '#475569' ?>; font-size: 11px; padding: 2px 6px; border-radius: 10px;">
                        <?= $count ?> Years
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Department Active Highlight Banner (When a specific Department is chosen) -->
    <?php if (!empty($activeBranchInfo)): ?>
    <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border: 1px solid #bae6fd; border-radius: 12px; padding: 16px 20px; margin-bottom: 22px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: #0284c7; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 22px; box-shadow: 0 4px 10px rgba(2, 132, 199, 0.25);">
                <i class="fas <?= $activeBranchInfo['icon'] ?>"></i>
            </div>
            <div>
                <div style="font-size: 17px; font-weight: 700; color: #0c4a6e; display: flex; align-items: center; gap: 10px;">
                    <span><?= htmlspecialchars($activeBranchInfo['name']) ?></span>
                    <span class="badge" style="background: #0284c7; color: #ffffff; font-size: 11px; padding: 3px 8px; border-radius: 6px;">
                        <?= $activeBranchInfo['type'] ?> Program
                    </span>
                </div>
                <div style="font-size: 13px; color: #0369a1; margin-top: 3px;">
                    Showing all academic years' GTU enrollment PDF registers for this department (<?= count($records) ?> records).
                </div>
            </div>
        </div>
        <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
            <button type="button" class="btn btn-sm btn-primary" onclick="openAddModalWithBranch('<?= htmlspecialchars($activeBranchInfo['name']) ?>', '<?= $activeBranchInfo['type'] ?>')" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; padding: 7px 14px;">
                <i class="fas fa-plus"></i> Upload PDF for <?= htmlspecialchars($activeBranchInfo['short']) ?>
            </button>
            <a href="student-enrollment.php" class="btn btn-sm btn-secondary" style="font-size: 13px; text-decoration: none; padding: 7px 14px;">
                <i class="fas fa-times"></i> View All Departments
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Secondary Filter Bar (Academic Year Pills & Search) -->
    <div class="card-actions-row" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-bottom: 20px;">
        <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
            <span style="font-size: 12.5px; font-weight: 600; color: #64748b; margin-right: 4px;">
                <i class="far fa-calendar-alt"></i> Filter Year:
            </span>
            <?php 
                $baseYearUrl = 'student-enrollment.php' . (!empty($selectedDept) ? '?dept=' . urlencode($selectedDept) : '');
                $allYearsActive = empty($filterYear);
            ?>
            <a href="<?= $baseYearUrl ?>" class="btn btn-sm <?= $allYearsActive ? 'btn-primary' : 'btn-secondary' ?>" style="text-decoration: none; border-radius: 20px; padding: 5px 13px; font-size: 12.5px;">
                All Years (<?= count($records) ?>)
            </a>
            <?php foreach ($academicYears as $yr): 
                $yrActive = ($filterYear === $yr);
                $yrUrl = 'student-enrollment.php?' . (!empty($selectedDept) ? 'dept=' . urlencode($selectedDept) . '&' : '') . 'year=' . urlencode($yr);
            ?>
                <a href="<?= $yrUrl ?>" class="btn btn-sm <?= $yrActive ? 'btn-primary' : 'btn-secondary' ?>" style="text-decoration: none; border-radius: 20px; padding: 5px 13px; font-size: 12.5px;">
                    <?= htmlspecialchars($yr) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="search-input-group" style="margin-left: auto;">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" id="enrollmentTableSearch" placeholder="Search branch, year, title..." onkeyup="filterEnrollmentsTable()">
        </div>
    </div>

    <!-- Data Table of Enrollment PDF Documents -->
    <div class="table-responsive">
        <table class="admin-table" id="enrollmentsTable">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">Order</th>
                    <th style="width: 140px;">Academic Year</th>
                    <th>Branch / Department &amp; Document</th>
                    <th style="width: 90px; text-align: center;">Level</th>
                    <th style="width: 160px;">PDF Document</th>
                    <th style="width: 110px; text-align: center;">Status</th>
                    <th style="width: 130px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $row): ?>
                <tr data-status="<?= $row['is_active'] ? 'active' : 'inactive' ?>">
                    <td style="font-weight: 700; color: #1e88e5; text-align: center;">#<?= (int)$row['display_order'] ?></td>
                    <td>
                        <span style="font-weight: 700; color: #0284c7; background: #e0f2fe; padding: 4px 10px; border-radius: 12px; font-size: 12.5px; display: inline-flex; align-items: center; gap: 4px;">
                            <i class="far fa-calendar-alt" style="font-size: 11px;"></i> <?= htmlspecialchars($row['academic_year']) ?>
                        </span>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #1a263d; font-size: 14px;">
                            <?= htmlspecialchars($row['branch_name']) ?>
                        </div>
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
                            <a href="../<?= htmlspecialchars($row['file_path']) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 6px; color: #dc2626; font-weight: 600; text-decoration: none; font-size: 13px; background: #fef2f2; padding: 5px 10px; border-radius: 6px; border: 1px solid #fee2e2;">
                                <i class="fas fa-file-pdf" style="font-size: 15px;"></i>
                                <span>View PDF</span>
                                <?php if (!empty($row['file_size'])): ?>
                                    <span style="font-size: 10.5px; color: #991b1b; font-weight: normal;">(<?= htmlspecialchars($row['file_size']) ?>)</span>
                                <?php endif; ?>
                            </a>
                        <?php else: ?>
                            <span style="font-size: 12px; color: #94a3b8; font-style: italic;">No PDF Uploaded</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                        <?php 
                            $toggleUrl = 'student-enrollment.php?toggle=' . (int)$row['id'];
                            if (!empty($selectedDept)) $toggleUrl .= '&dept=' . urlencode($selectedDept);
                            if (!empty($filterYear)) $toggleUrl .= '&year=' . urlencode($filterYear);
                        ?>
                        <a href="<?= $toggleUrl ?>" title="Click to toggle status" style="text-decoration: none;">
                            <?php if ($row['is_active']): ?>
                                <span class="badge badge-success" style="cursor: pointer;"><i class="fas fa-check"></i> Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary" style="cursor: pointer;"><i class="fas fa-eye-slash"></i> Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <div class="table-actions" style="justify-content: center;">
                            <a href="student-enrollment.php?edit=<?= (int)$row['id'] ?><?= !empty($selectedDept) ? '&dept=' . urlencode($selectedDept) : '' ?><?= !empty($filterYear) ? '&year=' . urlencode($filterYear) : '' ?>" class="btn-table-action btn-edit" title="Edit Record / Replace PDF">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php 
                                $deleteUrl = 'student-enrollment.php?delete=' . (int)$row['id'];
                                if (!empty($selectedDept)) $deleteUrl .= '&dept=' . urlencode($selectedDept);
                                if (!empty($filterYear)) $deleteUrl .= '&year=' . urlencode($filterYear);
                            ?>
                            <a href="<?= $deleteUrl ?>" class="btn-table-action btn-delete" title="Delete Record" onclick="return confirm('Are you sure you want to delete this enrollment document for <?= htmlspecialchars(addslashes($row['branch_name'])) ?> (<?= htmlspecialchars($row['academic_year']) ?>)?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($records)): ?>
                <tr class="no-records-row">
                    <td colspan="7" style="text-align: center; color: #888; padding: 40px 16px;">
                        <div style="font-size: 38px; color: #cbd5e1; margin-bottom: 8px;"><i class="fas fa-folder-open"></i></div>
                        <div style="font-size: 15px; font-weight: 600; color: #475569;">No Enrollment Records Found.</div>
                        <div style="font-size: 13px; color: #94a3b8; margin-top: 4px;">Click the "+ Upload Enrollment PDF" button above to add records for this department.</div>
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
                            <option value="<?= htmlspecialchars($sb['name']) ?>" <?= (!empty($activeBranchInfo) && $activeBranchInfo['name'] === $sb['name']) ? 'selected' : '' ?>>
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
                        <input type="number" name="display_order" id="add_display_order" class="form-control" value="0" min="0">
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
            <a href="student-enrollment.php<?= !empty($selectedDept) ? '?dept=' . urlencode($selectedDept) : '' ?><?= !empty($filterYear) ? '&year=' . urlencode($filterYear) : '' ?>" class="modal-close">&times;</a>
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
                            <a href="../<?= htmlspecialchars($editItem['file_path']) ?>" target="_blank" rel="noopener noreferrer" style="color: #dc2626; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; background: #fef2f2; padding: 6px 12px; border-radius: 6px; border: 1px solid #fee2e2;">
                                <i class="fas fa-file-pdf" style="font-size: 16px;"></i>
                                <span><?= htmlspecialchars(basename($editItem['file_path'])) ?></span>
                                <span style="font-size: 11px; color: #991b1b;">(<?= htmlspecialchars($editItem['file_size'] ?? 'PDF') ?>)</span>
                            </a>
                        </div>
                    <?php else: ?>
                        <div style="font-size: 13px; color: #94a3b8; margin-bottom: 8px; font-style: italic;">No PDF document uploaded yet.</div>
                    <?php endif; ?>
                    <label class="form-label" for="edit_pdf_file">Upload New PDF to Replace (Optional)</label>
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
                <a href="student-enrollment.php<?= !empty($selectedDept) ? '?dept=' . urlencode($selectedDept) : '' ?><?= !empty($filterYear) ? '&year=' . urlencode($filterYear) : '' ?>" class="btn-secondary" style="text-decoration: none;">Cancel</a>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
function openAddModalWithBranch(branchName, programType) {
    if (branchName) {
        var branchSelect = document.getElementById('add_branch_name');
        if (branchSelect) {
            branchSelect.value = branchName;
        }
    }
    if (programType) {
        var progSelect = document.getElementById('add_program_type');
        if (progSelect) {
            progSelect.value = programType;
        }
    }
    openModal('addEnrollmentModal');
}

function filterEnrollmentsTable() {
    var input = document.getElementById('enrollmentTableSearch');
    var filter = input.value.toLowerCase();
    var table = document.getElementById('enrollmentsTable');
    var trs = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    for (var i = 0; i < trs.length; i++) {
        if (trs[i].classList.contains('no-records-row')) continue;
        var text = trs[i].textContent.toLowerCase();
        if (text.indexOf(filter) > -1) {
            trs[i].style.display = '';
        } else {
            trs[i].style.display = 'none';
        }
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
