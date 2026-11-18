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

// Standard Department / Branch Definitions
$standardBranches = [
    [
        'code' => 'COMP',
        'name' => 'Computer Engineering',
        'short' => 'Computer',
        'type' => 'UG',
        'level' => 'Undergraduate (B.E.)',
        'icon' => 'fa-laptop-code',
        'color' => '#0284c7',
        'bg' => '#f0f9ff',
        'border' => '#bae6fd',
        'desc' => 'GTU UG Degree in Computer Engineering'
    ],
    [
        'code' => 'IT',
        'name' => 'Information Technology',
        'short' => 'IT',
        'type' => 'UG',
        'level' => 'Undergraduate (B.E.)',
        'icon' => 'fa-network-wired',
        'color' => '#0d9488',
        'bg' => '#f0fdfa',
        'border' => '#99f6e4',
        'desc' => 'GTU UG Degree in Information Technology'
    ],
    [
        'code' => 'ME',
        'name' => 'Mechanical Engineering',
        'short' => 'Mechanical',
        'type' => 'UG',
        'level' => 'Undergraduate (B.E.)',
        'icon' => 'fa-cogs',
        'color' => '#d97706',
        'bg' => '#fffbeb',
        'border' => '#fde68a',
        'desc' => 'GTU UG Degree in Mechanical Engineering'
    ],
    [
        'code' => 'CE',
        'name' => 'Civil Engineering',
        'short' => 'Civil',
        'type' => 'UG',
        'level' => 'Undergraduate (B.E.)',
        'icon' => 'fa-building',
        'color' => '#2563eb',
        'bg' => '#eff6ff',
        'border' => '#bfdbfe',
        'desc' => 'GTU UG Degree in Civil Engineering'
    ],
    [
        'code' => 'EE',
        'name' => 'Electrical Engineering',
        'short' => 'Electrical',
        'type' => 'UG',
        'level' => 'Undergraduate (B.E.)',
        'icon' => 'fa-bolt',
        'color' => '#eab308',
        'bg' => '#fefce8',
        'border' => '#fef08a',
        'desc' => 'GTU UG Degree in Electrical Engineering'
    ],
    [
        'code' => 'EC',
        'name' => 'Electronics and Communication Engineering',
        'short' => 'EC',
        'type' => 'UG',
        'level' => 'Undergraduate (B.E.)',
        'icon' => 'fa-microchip',
        'color' => '#7c3aed',
        'bg' => '#f5f3ff',
        'border' => '#ddd6fe',
        'desc' => 'GTU UG Degree in Electronics & Communication'
    ],
    [
        'code' => 'AE',
        'name' => 'Automobile Engineering',
        'short' => 'Automobile',
        'type' => 'UG',
        'level' => 'Undergraduate (B.E.)',
        'icon' => 'fa-car',
        'color' => '#dc2626',
        'bg' => '#fef2f2',
        'border' => '#fecaca',
        'desc' => 'GTU UG Degree in Automobile Engineering'
    ],
    [
        'code' => 'COMP_PG',
        'name' => 'Computer Engineering (PG)',
        'short' => 'Computer (PG)',
        'type' => 'PG',
        'level' => 'Postgraduate (M.E.)',
        'icon' => 'fa-graduation-cap',
        'color' => '#4f46e5',
        'bg' => '#eef2ff',
        'border' => '#c7d2fe',
        'desc' => 'GTU PG Masters in Computer Engineering'
    ],
    [
        'code' => 'CE_PG',
        'name' => 'Civil Engineering (PG)',
        'short' => 'Civil (PG)',
        'type' => 'PG',
        'level' => 'Postgraduate (M.E.)',
        'icon' => 'fa-graduation-cap',
        'color' => '#0891b2',
        'bg' => '#ecfeff',
        'border' => '#a5f3fc',
        'desc' => 'GTU PG Masters in Civil (Structural) Engineering'
    ],
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
            if ($sb['name'] === $branch_name || $sb['code'] === $branch_name) {
                $branch_code = $sb['code'];
                $branch_name = $sb['name'];
                $program_type = $sb['type'];
                break;
            }
        }

        if (empty($academic_year) || empty($branch_name)) {
            setFlashMessage('danger', 'Academic Year and Branch are required fields.');
            header('Location: student-enrollment.php' . (!empty($branch_code) ? '?dept=' . urlencode($branch_code) : ''));
            exit;
        }

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

        setFlashMessage('success', 'Enrollment document for ' . htmlspecialchars($branch_name) . ' (' . htmlspecialchars($academic_year) . ') uploaded successfully!');
        header('Location: student-enrollment.php?dept=' . urlencode($branch_code));
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
            if ($sb['name'] === $branch_name || $sb['code'] === $branch_name) {
                $branch_code = $sb['code'];
                $branch_name = $sb['name'];
                $program_type = $sb['type'];
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
                header('Location: student-enrollment.php?dept=' . urlencode($branch_code) . '&edit=' . $id);
                exit;
            }
        }

        $stmt = $pdo->prepare("UPDATE student_enrollments SET academic_year = ?, branch_name = ?, branch_code = ?, program_type = ?, title = ?, file_path = ?, file_size = ?, display_order = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$academic_year, $branch_name, $branch_code, $program_type, $title, $file_path, $file_size, $display_order, $is_active, $id]);

        setFlashMessage('success', 'Enrollment record updated successfully!');
        header('Location: student-enrollment.php?dept=' . urlencode($branch_code));
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
        $stmt = $pdo->prepare("SELECT file_path, branch_code FROM student_enrollments WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        $targetDept = $row['branch_code'] ?? ($_GET['dept'] ?? '');
        if ($row && !empty($row['file_path']) && $row['file_path'] !== 'uploads/enrollments/sample_enrollment.pdf') {
            $realFile = realpath(__DIR__ . '/../' . $row['file_path']);
            if ($realFile && file_exists($realFile)) {
                @unlink($realFile);
            }
        }
        $stmt = $pdo->prepare("DELETE FROM student_enrollments WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Enrollment record deleted successfully!');
        header('Location: student-enrollment.php' . (!empty($targetDept) ? '?dept=' . urlencode($targetDept) : ''));
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
        $stmt = $pdo->prepare("SELECT is_active, branch_code FROM student_enrollments WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        $targetDept = $row['branch_code'] ?? ($_GET['dept'] ?? '');
        $newStatus = ($row && $row['is_active'] == 1) ? 0 : 1;

        $stmt = $pdo->prepare("UPDATE student_enrollments SET is_active = ? WHERE id = ?");
        $stmt->execute([$newStatus, $id]);

        if ($newStatus === 1) {
            setFlashMessage('success', 'Enrollment document is now Published and Visible on public site.');
        } else {
            setFlashMessage('info', 'Enrollment document is now Hidden from public site.');
        }
        header('Location: student-enrollment.php' . (!empty($targetDept) ? '?dept=' . urlencode($targetDept) : ''));
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

// Check which view to display: Department Detail View OR All Departments Hub
$selectedDept = trim($_GET['dept'] ?? '');
$activeBranch = null;

if (!empty($selectedDept)) {
    foreach ($standardBranches as $sb) {
        if ($sb['code'] === $selectedDept || $sb['name'] === $selectedDept) {
            $activeBranch = $sb;
            break;
        }
    }
}

// Calculate Statistics for all Departments
$deptStats = [];
$totalAllPdfs = 0;
if ($pdo) {
    try {
        $totalAllPdfs = (int)$pdo->query("SELECT COUNT(*) FROM student_enrollments")->fetchColumn();
        $statRows = $pdo->query("SELECT branch_code, branch_name, academic_year, is_active FROM student_enrollments ORDER BY academic_year DESC")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($statRows as $sr) {
            $keys = array_filter([$sr['branch_code'], $sr['branch_name']]);
            foreach ($keys as $k) {
                if (!isset($deptStats[$k])) {
                    $deptStats[$k] = [
                        'total' => 0,
                        'active' => 0,
                        'hidden' => 0,
                        'years' => []
                    ];
                }
                $deptStats[$k]['total']++;
                if ($sr['is_active']) {
                    $deptStats[$k]['active']++;
                } else {
                    $deptStats[$k]['hidden']++;
                }
                if (!in_array($sr['academic_year'], $deptStats[$k]['years'])) {
                    $deptStats[$k]['years'][] = $sr['academic_year'];
                }
            }
        }
    } catch (Exception $e) {
        $deptStats = [];
        $totalAllPdfs = 0;
    }
}

// Fetch Records for Active Department (Detail View)
$deptRecords = [];
if ($activeBranch && $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM student_enrollments WHERE branch_code = ? OR branch_name = ? ORDER BY academic_year DESC, display_order ASC, id ASC");
        $stmt->execute([$activeBranch['code'], $activeBranch['name']]);
        $deptRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $deptRecords = [];
    }
}

$current_page = 'student-enrollment';
$page_title = $activeBranch ? ($activeBranch['name'] . ' Enrollment Registers') : 'Student Enrollment Management';
require_once __DIR__ . '/includes/header.php';
?>

<?php if (!$activeBranch): ?>
    <!-- ============================================================== -->
    <!-- VIEW 1: ALL DEPARTMENTS HUB (POORE PAGE ME SARE DEPARTMENTS)   -->
    <!-- ============================================================== -->
    <div class="admin-card">
        <div class="card-top" style="margin-bottom: 24px;">
            <div class="card-title-group">
                <h2 class="card-title" style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-university" style="color: #0284c7;"></i>
                    <span>Student Enrollment Management</span>
                </h2>
                <p style="font-size: 14px; color: #64748b; margin: 6px 0 0 0;">
                    Select any engineering department below to manage, upload, or configure its multi-year GTU enrollment PDF registers.
                </p>
            </div>
            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <a href="../student-corner/enrollment-details" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; text-decoration: none; padding: 8px 16px;">
                    <i class="fas fa-external-link-alt"></i> View Public Page
                </a>
                <button type="button" class="btn-add-new" onclick="openAddModalWithBranch('', 'UG')">
                    <i class="fas fa-plus"></i> Upload Enrollment PDF
                </button>
            </div>
        </div>

        <!-- Quick Summary Stats Bar -->
        <div style="display: flex; gap: 16px; margin-bottom: 28px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 220px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <div style="font-size: 20px; font-weight: 800; color: #0f172a; line-height: 1.1;">9</div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Engineering Departments</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 220px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: #fef2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <div>
                    <div style="font-size: 20px; font-weight: 800; color: #0f172a; line-height: 1.1;"><?= $totalAllPdfs ?></div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 2px;">Total Enrollment PDFs Uploaded</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 220px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px 18px; display: flex; align-items: center; gap: 14px;">
                <div style="width: 44px; height: 44px; border-radius: 10px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div style="font-size: 20px; font-weight: 800; color: #0f172a; line-height: 1.1;">Online</div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 2px;">GTU Institutional Sync Ready</div>
                </div>
            </div>
        </div>

        <!-- Section Title -->
        <div style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: #64748b; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-th-large" style="color: #0284c7;"></i>
            <span>All Departments (Click any department to view &amp; manage its all-year PDFs)</span>
        </div>

        <!-- Full-Page Departments Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
            <?php foreach ($standardBranches as $sb): 
                $stats = $deptStats[$sb['code']] ?? ($deptStats[$sb['name']] ?? ['total' => 0, 'active' => 0, 'hidden' => 0, 'years' => []]);
                $count = $stats['total'];
                $yearsList = $stats['years'];
            ?>
                <a href="student-enrollment.php?dept=<?= urlencode($sb['code']) ?>" 
                   style="display: flex; flex-direction: column; background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 14px; padding: 22px 20px; text-decoration: none; color: inherit; transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); box-shadow: 0 1px 3px rgba(0,0,0,0.03); position: relative; overflow: hidden;"
                   onmouseover="this.style.borderColor='<?= $sb['color'] ?>'; this.style.transform='translateY(-3px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.08)';"
                   onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.03)';">
                    
                    <!-- Color Accent Bar -->
                    <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: <?= $sb['color'] ?>;"></div>

                    <!-- Top Row: Icon & Program Badge -->
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        <div style="width: 52px; height: 52px; border-radius: 12px; background: <?= $sb['bg'] ?>; border: 1px solid <?= $sb['border'] ?>; color: <?= $sb['color'] ?>; display: flex; align-items: center; justify-content: center; font-size: 22px; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                            <i class="fas <?= $sb['icon'] ?>"></i>
                        </div>
                        <span class="badge" style="background: <?= ($sb['type'] === 'PG') ? '#fef3c7' : '#e0f2fe' ?>; color: <?= ($sb['type'] === 'PG') ? '#b45309' : '#0369a1' ?>; font-weight: 700; font-size: 11px; padding: 4px 9px; border-radius: 8px; border: 1px solid <?= ($sb['type'] === 'PG') ? '#fde68a' : '#bae6fd' ?>;">
                            <?= $sb['level'] ?>
                        </span>
                    </div>

                    <!-- Department Name & Description -->
                    <h3 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0 0 6px 0; line-height: 1.3;">
                        <?= htmlspecialchars($sb['name']) ?>
                    </h3>
                    <p style="font-size: 13px; color: #64748b; margin: 0 0 16px 0; line-height: 1.4;">
                        <?= htmlspecialchars($sb['desc']) ?>
                    </p>

                    <!-- Years Preview / Stats -->
                    <div style="margin-top: auto; padding-top: 14px; border-top: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 13px; font-weight: 600; color: #334155; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fas fa-file-pdf" style="color: #dc2626; font-size: 14px;"></i>
                                <?= $count ?> <?= ($count === 1) ? 'Academic Year' : 'Academic Years' ?>
                            </span>
                            <?php if ($stats['hidden'] > 0): ?>
                                <span style="font-size: 11px; color: #64748b; background: #f1f5f9; padding: 2px 7px; border-radius: 6px;">
                                    <?= $stats['hidden'] ?> hidden
                                </span>
                            <?php else: ?>
                                <span style="font-size: 11px; color: #16a34a; background: #f0fdf4; padding: 2px 7px; border-radius: 6px; font-weight: 600;">
                                    All Active
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($yearsList)): ?>
                            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                <?php foreach (array_slice($yearsList, 0, 4) as $yrBadge): ?>
                                    <span style="font-size: 11px; font-weight: 600; color: #0284c7; background: #e0f2fe; padding: 2px 8px; border-radius: 6px;">
                                        <?= htmlspecialchars($yrBadge) ?>
                                    </span>
                                <?php endforeach; ?>
                                <?php if (count($yearsList) > 4): ?>
                                    <span style="font-size: 11px; color: #64748b; padding: 2px 4px;">+<?= count($yearsList) - 4 ?> more</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Action Link Button -->
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 6px; color: <?= $sb['color'] ?>; font-size: 13.5px; font-weight: 700;">
                            <span>Manage All Years</span>
                            <i class="fas fa-arrow-right" style="transition: transform 0.2s ease;"></i>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

<?php else: ?>
    <!-- ============================================================== -->
    <!-- VIEW 2: DEPARTMENT DETAIL VIEW (US DEPT KE SARE YEARS KI PDFS)  -->
    <!-- ============================================================== -->
    <div class="admin-card">
        <!-- Back Navigation & Breadcrumb -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; padding-bottom: 16px; border-bottom: 1px solid #e2e8f0;">
            <a href="student-enrollment.php" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 13px; text-decoration: none; padding: 8px 18px; border-radius: 8px; border: 1px solid #cbd5e1; background: #ffffff; color: #334155;">
                <i class="fas fa-arrow-left"></i>
                <span>Back to All Departments</span>
            </a>
            <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748b;">
                <a href="student-enrollment.php" style="color: #64748b; text-decoration: none;">Enrollment Hub</a>
                <span>/</span>
                <span style="font-weight: 600; color: #0f172a;"><?= htmlspecialchars($activeBranch['name']) ?></span>
            </div>
        </div>

        <!-- Department Highlight Header Banner -->
        <div style="background: linear-gradient(135deg, <?= $activeBranch['bg'] ?> 0%, #ffffff 100%); border: 1.5px solid <?= $activeBranch['border'] ?>; border-radius: 14px; padding: 22px 24px; margin-bottom: 26px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 18px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
            <div style="display: flex; align-items: center; gap: 18px;">
                <div style="width: 58px; height: 58px; border-radius: 14px; background: <?= $activeBranch['color'] ?>; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 26px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <i class="fas <?= $activeBranch['icon'] ?>"></i>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1.2;">
                            <?= htmlspecialchars($activeBranch['name']) ?>
                        </h1>
                        <span class="badge" style="background: <?= $activeBranch['color'] ?>; color: #ffffff; font-size: 11.5px; padding: 4px 10px; border-radius: 8px; font-weight: 700;">
                            <?= $activeBranch['level'] ?>
                        </span>
                    </div>
                    <p style="font-size: 13.5px; color: #475569; margin: 6px 0 0 0;">
                        Showing all official GTU enrollment PDF registers for this department (<?= count($deptRecords) ?> Academic Years).
                    </p>
                </div>
            </div>

            <!-- Header Action Buttons -->
            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <a href="../student-corner/enrollment-details" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; text-decoration: none; padding: 9px 16px; border-radius: 8px;">
                    <i class="fas fa-external-link-alt"></i> View Public Page
                </a>
                <button type="button" class="btn-add-new" onclick="openAddModalWithBranch('<?= htmlspecialchars(addslashes($activeBranch['name'])) ?>', '<?= $activeBranch['type'] ?>')" style="padding: 9px 20px; font-size: 13.5px; border-radius: 8px; background: <?= $activeBranch['color'] ?>; border-color: <?= $activeBranch['color'] ?>;">
                    <i class="fas fa-cloud-upload-alt"></i> Upload New Year PDF
                </button>
            </div>
        </div>

        <!-- Detail Actions Row: Count & Quick Search -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
            <div style="font-size: 14px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                <i class="far fa-calendar-check" style="color: #0284c7;"></i>
                <span>All Academic Years for <?= htmlspecialchars($activeBranch['short']) ?> (<?= count($deptRecords) ?>)</span>
            </div>
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" id="deptYearSearch" placeholder="Search academic year or document..." onkeyup="filterDeptYearsTable()">
            </div>
        </div>

        <!-- All Years Table for this Department -->
        <div class="table-responsive">
            <table class="admin-table" id="deptYearsTable">
                <thead>
                    <tr>
                        <th style="width: 70px; text-align: center;">Order</th>
                        <th style="width: 150px;">Academic Year</th>
                        <th>Document Title &amp; Details</th>
                        <th style="width: 100px; text-align: center;">Level</th>
                        <th style="width: 180px;">PDF Document</th>
                        <th style="width: 140px; text-align: center;">Visibility (Hide/Show)</th>
                        <th style="width: 140px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($deptRecords as $row): ?>
                    <tr data-status="<?= $row['is_active'] ? 'active' : 'inactive' ?>">
                        <td style="font-weight: 700; color: #0284c7; text-align: center;">#<?= (int)$row['display_order'] ?></td>
                        <td>
                            <span style="font-weight: 800; color: #0369a1; background: #e0f2fe; padding: 6px 12px; border-radius: 10px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #bae6fd;">
                                <i class="far fa-calendar-alt"></i> <?= htmlspecialchars($row['academic_year']) ?>
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0f172a; font-size: 14px;">
                                <?= htmlspecialchars($row['title'] ?? ($row['branch_name'] . ' Enrollment Register')) ?>
                            </div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                                <?= htmlspecialchars($row['branch_name']) ?> &bull; Created: <?= date('M d, Y', strtotime($row['created_at'])) ?>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <?php if ($row['program_type'] === 'PG'): ?>
                                <span class="badge" style="background: #fef3c7; color: #b45309; font-weight: 700; border: 1px solid #fde68a;">PG</span>
                            <?php else: ?>
                                <span class="badge" style="background: #e0f2fe; color: #0369a1; font-weight: 700; border: 1px solid #bae6fd;">UG</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($row['file_path']) && file_exists(__DIR__ . '/../' . $row['file_path'])): ?>
                                <a href="../<?= htmlspecialchars($row['file_path']) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 7px; color: #dc2626; font-weight: 700; text-decoration: none; font-size: 13px; background: #fef2f2; padding: 6px 12px; border-radius: 8px; border: 1px solid #fee2e2;" title="Click to open official PDF in new tab">
                                    <i class="fas fa-file-pdf" style="font-size: 16px;"></i>
                                    <span>View PDF</span>
                                    <?php if (!empty($row['file_size'])): ?>
                                        <span style="font-size: 11px; color: #991b1b; font-weight: normal;">(<?= htmlspecialchars($row['file_size']) ?>)</span>
                                    <?php endif; ?>
                                </a>
                            <?php else: ?>
                                <span style="font-size: 12.5px; color: #94a3b8; font-style: italic;">No PDF Uploaded</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <a href="student-enrollment.php?toggle=<?= (int)$row['id'] ?>&dept=<?= urlencode($activeBranch['code']) ?>" 
                               title="Click to toggle visibility (Hide / Publish)" 
                               style="text-decoration: none;">
                                <?php if ($row['is_active']): ?>
                                    <span class="badge badge-success" style="cursor: pointer; padding: 6px 12px; font-size: 12px; display: inline-flex; align-items: center; gap: 5px;" title="Visible on public website. Click to Hide.">
                                        <i class="fas fa-eye"></i> Visible
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-secondary" style="cursor: pointer; padding: 6px 12px; font-size: 12px; background: #e2e8f0; color: #475569; display: inline-flex; align-items: center; gap: 5px;" title="Hidden from public website. Click to Publish.">
                                        <i class="fas fa-eye-slash"></i> Hidden
                                    </span>
                                <?php endif; ?>
                            </a>
                        </td>
                        <td style="text-align: center;">
                            <div class="table-actions" style="justify-content: center; gap: 8px;">
                                <a href="student-enrollment.php?dept=<?= urlencode($activeBranch['code']) ?>&edit=<?= (int)$row['id'] ?>" class="btn-table-action btn-edit" title="Edit Record / Replace PDF">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="student-enrollment.php?dept=<?= urlencode($activeBranch['code']) ?>&delete=<?= (int)$row['id'] ?>" class="btn-table-action btn-delete" title="Delete Record" onclick="return confirm('Are you sure you want to delete the enrollment document for <?= htmlspecialchars(addslashes($activeBranch['name'])) ?> (<?= htmlspecialchars($row['academic_year']) ?>)?');">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($deptRecords)): ?>
                    <tr class="no-records-row">
                        <td colspan="7" style="text-align: center; color: #888; padding: 48px 16px;">
                            <div style="font-size: 42px; color: #cbd5e1; margin-bottom: 12px;"><i class="fas fa-folder-open"></i></div>
                            <div style="font-size: 16px; font-weight: 700; color: #334155;">No Enrollment PDF Registers for <?= htmlspecialchars($activeBranch['name']) ?> Yet</div>
                            <div style="font-size: 13.5px; color: #94a3b8; margin: 6px 0 18px 0;">Click the button below to upload the first GTU enrollment PDF document for this department.</div>
                            <button type="button" class="btn btn-primary" onclick="openAddModalWithBranch('<?= htmlspecialchars(addslashes($activeBranch['name'])) ?>', '<?= $activeBranch['type'] ?>')" style="padding: 9px 20px; font-size: 13.5px; border-radius: 8px;">
                                <i class="fas fa-plus"></i> Upload First PDF for <?= htmlspecialchars($activeBranch['short']) ?>
                            </button>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<!-- ============================================================== -->
<!-- MODAL: UPLOAD NEW ENROLLMENT PDF DOCUMENT                      -->
<!-- ============================================================== -->
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
                    <label class="form-label" for="add_branch_name">Department / Branch <span class="required">*</span></label>
                    <select name="branch_name" id="add_branch_name" class="form-control" required>
                        <?php foreach ($standardBranches as $sb): ?>
                            <option value="<?= htmlspecialchars($sb['name']) ?>" <?= (!empty($activeBranch) && $activeBranch['name'] === $sb['name']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($sb['name']) ?> [<?= $sb['type'] ?>]
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_pdf_file">Upload Official Enrollment PDF <span class="required">*</span></label>
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
                            <span>Published (Visible on website)</span>
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

<!-- ============================================================== -->
<!-- MODAL: EDIT ENROLLMENT PDF DOCUMENT                            -->
<!-- ============================================================== -->
<?php if ($editItem): ?>
<div class="modal-overlay active show" id="editEnrollmentModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Edit Enrollment Record #<?= (int)$editItem['id'] ?></h3>
            <a href="student-enrollment.php<?= !empty($selectedDept) ? '?dept=' . urlencode($selectedDept) : '' ?>" class="modal-close">&times;</a>
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
                    <label class="form-label" for="edit_branch_name">Department / Branch <span class="required">*</span></label>
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
                            <a href="../<?= htmlspecialchars($editItem['file_path']) ?>" target="_blank" rel="noopener noreferrer" style="color: #dc2626; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; background: #fef2f2; padding: 6px 12px; border-radius: 8px; border: 1px solid #fee2e2;">
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
                            <span>Published (Visible on website)</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="student-enrollment.php<?= !empty($selectedDept) ? '?dept=' . urlencode($selectedDept) : '' ?>" class="btn-secondary" style="text-decoration: none;">Cancel</a>
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

function filterDeptYearsTable() {
    var input = document.getElementById('deptYearSearch');
    if (!input) return;
    var filter = input.value.toLowerCase();
    var table = document.getElementById('deptYearsTable');
    if (!table) return;
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
