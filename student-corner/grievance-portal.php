<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = "Student / Faculty Grievance Form | Government Engineering College, Modasa";
$page_description = "Submit student and faculty grievances online and track application redressal status at GEC Modasa.";
$active_page = 'grievance-portal';
$root_path = '../';
$extra_css = 'css/grievance-portal.css';

require_once __DIR__ . '/../includes/db.php';
$pdo = getDBConnection();

// Self-healing database table setup
if ($pdo) {
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `student_grievances` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `ticket_number` VARCHAR(30) UNIQUE NOT NULL,
            `full_name` VARCHAR(255) NOT NULL,
            `enrollment_faculty_id` VARCHAR(100) NOT NULL,
            `contact_number` VARCHAR(25) NOT NULL,
            `gender` VARCHAR(20) NOT NULL,
            `category` VARCHAR(50) NOT NULL,
            `father_name` VARCHAR(255) NOT NULL,
            `semester` VARCHAR(50) NOT NULL,
            `branch` VARCHAR(100) NOT NULL,
            `dept_code` VARCHAR(20) NOT NULL,
            `grievance_category` VARCHAR(100) NOT NULL,
            `grievance_description` TEXT NOT NULL,
            `status` VARCHAR(30) NOT NULL DEFAULT 'Pending',
            `admin_remarks` TEXT NULL,
            `resolved_at` DATETIME NULL,
            `ip_address` VARCHAR(45) NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_dept_status` (`dept_code`, `status`, `created_at`),
            INDEX `idx_ticket` (`ticket_number`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    } catch (Exception $e) {
        error_log("Error creating student_grievances table: " . $e->getMessage());
    }
}

// Branch to Department Code mapping
$branchDeptMap = [
    'Computer Engineering'                     => 'CE',
    'Information Technology'                  => 'IT',
    'Civil Engineering'                       => 'CIVIL',
    'Mechanical Engineering'                  => 'ME',
    'Electrical Engineering'                  => 'EE',
    'Electronics & Communication Engineering' => 'EC',
    'Automobile Engineering'                  => 'AE',
    'Applied Mechanics'                       => 'AM',
    'Science & Humanities'                    => 'SH',
    'General / Administration'                => 'GEN'
];

$successMessage = '';
$errorMessage = '';
$generatedTicket = '';

// Active Tab state ('form' or 'track')
$activeTab = trim($_GET['tab'] ?? 'form');

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $enrollmentId = trim($_POST['enrollment_faculty_id'] ?? '');
    $contactNumber = trim($_POST['contact_number'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $fatherName = trim($_POST['father_name'] ?? '');
    $semester = trim($_POST['semester'] ?? '');
    $branch = trim($_POST['branch'] ?? '');
    $grievanceCategory = trim($_POST['grievance_category'] ?? '');
    $grievanceDesc = trim($_POST['grievance_description'] ?? '');

    if (empty($fullName) || empty($enrollmentId) || empty($contactNumber) || empty($gender) || empty($category) || empty($fatherName) || empty($semester) || empty($branch) || empty($grievanceCategory) || empty($grievanceDesc)) {
        $errorMessage = "Please fill in all required fields accurately before submitting.";
    } elseif (!$pdo) {
        $errorMessage = "Database connection is temporarily offline. Please try again shortly or contact the student section desk.";
    } else {
        try {
            $deptCode = $branchDeptMap[$branch] ?? 'GEN';
            $ticketNumber = 'GRV-' . date('Y') . '-' . strtoupper(bin2hex(random_bytes(3)));
            $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';

            $stmt = $pdo->prepare("INSERT INTO student_grievances 
                (ticket_number, full_name, enrollment_faculty_id, contact_number, gender, category, father_name, semester, branch, dept_code, grievance_category, grievance_description, status, ip_address) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?)");

            $stmt->execute([
                $ticketNumber,
                $fullName,
                $enrollmentId,
                $contactNumber,
                $gender,
                $category,
                $fatherName,
                $semester,
                $branch,
                $deptCode,
                $grievanceCategory,
                $grievanceDesc,
                $ipAddress
            ]);

            $successMessage = "Your grievance has been successfully submitted and forwarded to the designated Department Administration ({$branch}) for review.";
            $generatedTicket = $ticketNumber;
            $activeTab = 'form';
        } catch (Exception $e) {
            $errorMessage = "An error occurred while submitting your grievance. Please verify your details and try again.";
            error_log("Grievance submission error: " . $e->getMessage());
        }
    }
}

// Handle Ticket Status Tracking (GET)
$trackQuery = trim($_GET['ticket'] ?? '');
$trackedGrievance = null;
$trackNotFound = false;

if (!empty($trackQuery) && $pdo) {
    $activeTab = 'track';
    try {
        $stmt = $pdo->prepare("SELECT * FROM student_grievances WHERE ticket_number = ? OR enrollment_faculty_id = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$trackQuery, $trackQuery]);
        $trackedGrievance = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$trackedGrievance) {
            $trackNotFound = true;
        }
    } catch (Exception $e) {
        $trackNotFound = true;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="grv-page" id="mainContent">
    <div class="grv-container">

        <!-- Tab Navigation Switcher -->
        <div class="grv-nav-tabs">
            <button type="button" 
                    class="grv-tab-btn <?= ($activeTab === 'form') ? 'active' : '' ?>" 
                    id="btnTabForm" 
                    onclick="switchGrvTab('form')">
                <i class="fas fa-file-alt"></i>
                <span>Submit Grievance</span>
            </button>
            <button type="button" 
                    class="grv-tab-btn <?= ($activeTab === 'track') ? 'active' : '' ?>" 
                    id="btnTabTrack" 
                    onclick="switchGrvTab('track')">
                <i class="fas fa-search-location"></i>
                <span>Track Grievance Status</span>
            </button>
        </div>

        <div class="grv-card">

            <!-- ============================================================== -->
            <!-- PANE 1: GRIEVANCE SUBMISSION FORM                             -->
            <!-- ============================================================== -->
            <div id="paneForm" style="<?= ($activeTab === 'form') ? 'display: block;' : 'display: none;' ?>">
                <h1 class="grv-title">Student / Faculty Grievance Form</h1>

                <?php if (!empty($successMessage)): ?>
                    <div class="grv-alert grv-alert-success">
                        <div style="font-weight: 700; font-size: 1rem; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-check-circle"></i> Submission Successful
                        </div>
                        <p style="margin: 0 0 10px 0;"><?= htmlspecialchars($successMessage) ?></p>
                        <div style="background: #ffffff; border: 1px dashed #10b981; border-radius: 6px; padding: 10px 14px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                            <div>
                                <span style="font-size: 0.85rem; color: #475569;">Grievance Reference Ticket:</span>
                                <strong style="font-size: 1.05rem; color: #047857; letter-spacing: 0.04em; margin-left: 6px;">
                                    <?= htmlspecialchars($generatedTicket) ?>
                                </strong>
                            </div>
                            <a href="grievance-portal.php?tab=track&ticket=<?= urlencode($generatedTicket) ?>" 
                               class="grv-track-btn" 
                               style="font-size: 0.84rem; padding: 6px 14px; text-decoration: none;">
                                Track Status <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errorMessage)): ?>
                    <div class="grv-alert grv-alert-danger">
                        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($errorMessage) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="grievance-portal.php">

                    <!-- 1. Personal Information Section -->
                    <fieldset class="grv-section">
                        <legend class="grv-section-legend">Personal Information</legend>

                        <div class="grv-form-group">
                            <label class="grv-label">Full Name</label>
                            <input type="text" 
                                   name="full_name" 
                                   class="grv-input" 
                                   placeholder="E.G., PATEL RAHULKUMAR" 
                                   required 
                                   value="<?= isset($_POST['full_name']) && empty($successMessage) ? htmlspecialchars($_POST['full_name']) : '' ?>">
                        </div>

                        <div class="grv-grid-2">
                            <div class="grv-form-group">
                                <label class="grv-label">Enrollment Number / Faculty Id</label>
                                <input type="text" 
                                       name="enrollment_faculty_id" 
                                       class="grv-input" 
                                       placeholder="e.g., 250160107155" 
                                       required 
                                       value="<?= isset($_POST['enrollment_faculty_id']) && empty($successMessage) ? htmlspecialchars($_POST['enrollment_faculty_id']) : '' ?>">
                            </div>
                            <div class="grv-form-group">
                                <label class="grv-label">Contact Number</label>
                                <input type="tel" 
                                       name="contact_number" 
                                       class="grv-input" 
                                       placeholder="e.g., 9935512545" 
                                       required 
                                       pattern="[0-9]{10}" 
                                       title="Please enter a valid 10-digit mobile number" 
                                       value="<?= isset($_POST['contact_number']) && empty($successMessage) ? htmlspecialchars($_POST['contact_number']) : '' ?>">
                            </div>
                        </div>

                        <div class="grv-grid-2">
                            <div class="grv-form-group">
                                <label class="grv-label">Gender</label>
                                <select name="gender" class="grv-select" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="Male" <?= (isset($_POST['gender']) && $_POST['gender'] === 'Male' && empty($successMessage)) ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= (isset($_POST['gender']) && $_POST['gender'] === 'Female' && empty($successMessage)) ? 'selected' : '' ?>>Female</option>
                                    <option value="Other" <?= (isset($_POST['gender']) && $_POST['gender'] === 'Other' && empty($successMessage)) ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>
                            <div class="grv-form-group">
                                <label class="grv-label">Category</label>
                                <select name="category" class="grv-select" required>
                                    <option value="">-- Select Category --</option>
                                    <option value="OPEN" <?= (isset($_POST['category']) && $_POST['category'] === 'OPEN' && empty($successMessage)) ? 'selected' : '' ?>>OPEN</option>
                                    <option value="SEBC / OBC" <?= (isset($_POST['category']) && $_POST['category'] === 'SEBC / OBC' && empty($successMessage)) ? 'selected' : '' ?>>SEBC / OBC</option>
                                    <option value="SC" <?= (isset($_POST['category']) && $_POST['category'] === 'SC' && empty($successMessage)) ? 'selected' : '' ?>>SC</option>
                                    <option value="ST" <?= (isset($_POST['category']) && $_POST['category'] === 'ST' && empty($successMessage)) ? 'selected' : '' ?>>ST</option>
                                    <option value="EWS" <?= (isset($_POST['category']) && $_POST['category'] === 'EWS' && empty($successMessage)) ? 'selected' : '' ?>>EWS</option>
                                </select>
                            </div>
                        </div>

                        <div class="grv-form-group">
                            <label class="grv-label">Father's Name</label>
                            <input type="text" 
                                   name="father_name" 
                                   class="grv-input" 
                                   placeholder="E.G., PATEL ANILBHAI" 
                                   required 
                                   value="<?= isset($_POST['father_name']) && empty($successMessage) ? htmlspecialchars($_POST['father_name']) : '' ?>">
                        </div>
                    </fieldset>

                    <!-- 2. Academic Details Section -->
                    <fieldset class="grv-section">
                        <legend class="grv-section-legend">Academic Details</legend>

                        <div class="grv-grid-2">
                            <div class="grv-form-group">
                                <label class="grv-label">Semester</label>
                                <select name="semester" class="grv-select" required>
                                    <option value="">-- Select Sem --</option>
                                    <option value="Semester 1" <?= (isset($_POST['semester']) && $_POST['semester'] === 'Semester 1' && empty($successMessage)) ? 'selected' : '' ?>>Semester 1</option>
                                    <option value="Semester 2" <?= (isset($_POST['semester']) && $_POST['semester'] === 'Semester 2' && empty($successMessage)) ? 'selected' : '' ?>>Semester 2</option>
                                    <option value="Semester 3" <?= (isset($_POST['semester']) && $_POST['semester'] === 'Semester 3' && empty($successMessage)) ? 'selected' : '' ?>>Semester 3</option>
                                    <option value="Semester 4" <?= (isset($_POST['semester']) && $_POST['semester'] === 'Semester 4' && empty($successMessage)) ? 'selected' : '' ?>>Semester 4</option>
                                    <option value="Semester 5" <?= (isset($_POST['semester']) && $_POST['semester'] === 'Semester 5' && empty($successMessage)) ? 'selected' : '' ?>>Semester 5</option>
                                    <option value="Semester 6" <?= (isset($_POST['semester']) && $_POST['semester'] === 'Semester 6' && empty($successMessage)) ? 'selected' : '' ?>>Semester 6</option>
                                    <option value="Semester 7" <?= (isset($_POST['semester']) && $_POST['semester'] === 'Semester 7' && empty($successMessage)) ? 'selected' : '' ?>>Semester 7</option>
                                    <option value="Semester 8" <?= (isset($_POST['semester']) && $_POST['semester'] === 'Semester 8' && empty($successMessage)) ? 'selected' : '' ?>>Semester 8</option>
                                    <option value="Faculty / Staff" <?= (isset($_POST['semester']) && $_POST['semester'] === 'Faculty / Staff' && empty($successMessage)) ? 'selected' : '' ?>>Faculty / Staff</option>
                                </select>
                            </div>
                            <div class="grv-form-group">
                                <label class="grv-label">Branch</label>
                                <select name="branch" class="grv-select" required>
                                    <option value="">-- Select Branch --</option>
                                    <option value="Computer Engineering" <?= (isset($_POST['branch']) && $_POST['branch'] === 'Computer Engineering' && empty($successMessage)) ? 'selected' : '' ?>>Computer Engineering</option>
                                    <option value="Information Technology" <?= (isset($_POST['branch']) && $_POST['branch'] === 'Information Technology' && empty($successMessage)) ? 'selected' : '' ?>>Information Technology</option>
                                    <option value="Civil Engineering" <?= (isset($_POST['branch']) && $_POST['branch'] === 'Civil Engineering' && empty($successMessage)) ? 'selected' : '' ?>>Civil Engineering</option>
                                    <option value="Mechanical Engineering" <?= (isset($_POST['branch']) && $_POST['branch'] === 'Mechanical Engineering' && empty($successMessage)) ? 'selected' : '' ?>>Mechanical Engineering</option>
                                    <option value="Electrical Engineering" <?= (isset($_POST['branch']) && $_POST['branch'] === 'Electrical Engineering' && empty($successMessage)) ? 'selected' : '' ?>>Electrical Engineering</option>
                                    <option value="Electronics & Communication Engineering" <?= (isset($_POST['branch']) && $_POST['branch'] === 'Electronics & Communication Engineering' && empty($successMessage)) ? 'selected' : '' ?>>Electronics & Communication Engineering</option>
                                    <option value="Automobile Engineering" <?= (isset($_POST['branch']) && $_POST['branch'] === 'Automobile Engineering' && empty($successMessage)) ? 'selected' : '' ?>>Automobile Engineering</option>
                                    <option value="Applied Mechanics" <?= (isset($_POST['branch']) && $_POST['branch'] === 'Applied Mechanics' && empty($successMessage)) ? 'selected' : '' ?>>Applied Mechanics</option>
                                    <option value="Science & Humanities" <?= (isset($_POST['branch']) && $_POST['branch'] === 'Science & Humanities' && empty($successMessage)) ? 'selected' : '' ?>>Science & Humanities</option>
                                    <option value="General / Administration" <?= (isset($_POST['branch']) && $_POST['branch'] === 'General / Administration' && empty($successMessage)) ? 'selected' : '' ?>>General / Administration</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <!-- 3. Grievance Details Section -->
                    <fieldset class="grv-section">
                        <legend class="grv-section-legend">Grievance Details</legend>

                        <div class="grv-form-group">
                            <label class="grv-label">Grievance Category</label>
                            <select name="grievance_category" class="grv-select" required>
                                <option value="">-- Select --</option>
                                <option value="Academic" <?= (isset($_POST['grievance_category']) && $_POST['grievance_category'] === 'Academic' && empty($successMessage)) ? 'selected' : '' ?>>Academic</option>
                                <option value="Examination" <?= (isset($_POST['grievance_category']) && $_POST['grievance_category'] === 'Examination' && empty($successMessage)) ? 'selected' : '' ?>>Examination</option>
                                <option value="Fee / Financial" <?= (isset($_POST['grievance_category']) && $_POST['grievance_category'] === 'Fee / Financial' && empty($successMessage)) ? 'selected' : '' ?>>Fee / Financial</option>
                                <option value="Anti-Ragging" <?= (isset($_POST['grievance_category']) && $_POST['grievance_category'] === 'Anti-Ragging' && empty($successMessage)) ? 'selected' : '' ?>>Anti-Ragging</option>
                                <option value="Infrastructure & Facilities" <?= (isset($_POST['grievance_category']) && $_POST['grievance_category'] === 'Infrastructure & Facilities' && empty($successMessage)) ? 'selected' : '' ?>>Infrastructure & Facilities</option>
                                <option value="Library" <?= (isset($_POST['grievance_category']) && $_POST['grievance_category'] === 'Library' && empty($successMessage)) ? 'selected' : '' ?>>Library</option>
                                <option value="Hostel & Mess" <?= (isset($_POST['grievance_category']) && $_POST['grievance_category'] === 'Hostel & Mess' && empty($successMessage)) ? 'selected' : '' ?>>Hostel & Mess</option>
                                <option value="Transportation" <?= (isset($_POST['grievance_category']) && $_POST['grievance_category'] === 'Transportation' && empty($successMessage)) ? 'selected' : '' ?>>Transportation</option>
                                <option value="Harassment / Discrimination" <?= (isset($_POST['grievance_category']) && $_POST['grievance_category'] === 'Harassment / Discrimination' && empty($successMessage)) ? 'selected' : '' ?>>Harassment / Discrimination</option>
                                <option value="Other" <?= (isset($_POST['grievance_category']) && $_POST['grievance_category'] === 'Other' && empty($successMessage)) ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>

                        <div class="grv-form-group">
                            <label class="grv-label">Grievance Description</label>
                            <textarea name="grievance_description" 
                                      class="grv-textarea" 
                                      placeholder="Describe your grievance in detail..." 
                                      required><?= isset($_POST['grievance_description']) && empty($successMessage) ? htmlspecialchars($_POST['grievance_description']) : '' ?></textarea>
                        </div>
                    </fieldset>

                    <button type="submit" class="grv-submit-btn">
                        <span>Submit Application</span>
                    </button>

                </form>
            </div>

            <!-- ============================================================== -->
            <!-- PANE 2: TRACK GRIEVANCE STATUS                                 -->
            <!-- ============================================================== -->
            <div id="paneTrack" style="<?= ($activeTab === 'track') ? 'display: block;' : 'display: none;' ?>">
                <h2 class="grv-title" style="margin-bottom: 12px;">Track Grievance Status</h2>
                <p style="font-size: 0.92rem; color: #64748b; text-align: center; margin: 0 0 22px 0;">
                    Enter your unique Grievance Ticket Number or Student Enrollment ID to view current redressal progress.
                </p>

                <!-- Search Input Box -->
                <form method="GET" action="grievance-portal.php" class="grv-track-box">
                    <input type="hidden" name="tab" value="track">
                    <label class="grv-label" style="font-weight: 700; color: #1f646c; margin-bottom: 8px;">
                        Grievance Ticket Number / Enrollment No.
                    </label>
                    <div class="grv-track-search-row">
                        <input type="text" 
                               name="ticket" 
                               class="grv-input" 
                               placeholder="e.g. GRV-2026-7EB970 or 250160107155" 
                               value="<?= htmlspecialchars($trackQuery) ?>" 
                               required 
                               style="flex: 1;">
                        <button type="submit" class="grv-track-btn">
                            <i class="fas fa-search"></i>
                            <span>Check Status</span>
                        </button>
                    </div>
                </form>

                <?php if ($trackNotFound): ?>
                    <div class="grv-alert grv-alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>No grievance record found matching <strong><?= htmlspecialchars($trackQuery) ?></strong>. Please double-check your Ticket Number or Enrollment Number and try again.</span>
                    </div>
                <?php endif; ?>

                <?php if ($trackedGrievance): ?>
                    <?php
                    $curStatus = $trackedGrievance['status'];
                    $badgeClass = 'grv-status-pending';
                    $statusIcon = 'fa-clock';
                    if ($curStatus === 'Under Review') {
                        $badgeClass = 'grv-status-under-review';
                        $statusIcon = 'fa-spinner fa-spin';
                    } elseif ($curStatus === 'Resolved') {
                        $badgeClass = 'grv-status-resolved';
                        $statusIcon = 'fa-check-circle';
                    } elseif ($curStatus === 'Rejected') {
                        $badgeClass = 'grv-status-rejected';
                        $statusIcon = 'fa-times-circle';
                    }
                    ?>
                    <div class="grv-result-card">
                        <div class="grv-result-header">
                            <div>
                                <span style="font-size: 0.78rem; text-transform: uppercase; font-weight: 700; color: #64748b;">Ticket Reference</span>
                                <div class="grv-result-ticket">
                                    <?= htmlspecialchars($trackedGrievance['ticket_number']) ?>
                                </div>
                            </div>
                            <div>
                                <span class="grv-status-badge <?= $badgeClass ?>">
                                    <i class="fas <?= $statusIcon ?>"></i>
                                    <span><?= htmlspecialchars($curStatus) ?></span>
                                </span>
                            </div>
                        </div>

                        <div class="grv-info-grid">
                            <div class="grv-info-item">
                                <span class="grv-info-label">Applicant Name</span>
                                <span class="grv-info-value"><?= htmlspecialchars($trackedGrievance['full_name']) ?></span>
                            </div>
                            <div class="grv-info-item">
                                <span class="grv-info-label">Enrollment / ID</span>
                                <span class="grv-info-value"><?= htmlspecialchars($trackedGrievance['enrollment_faculty_id']) ?></span>
                            </div>
                            <div class="grv-info-item">
                                <span class="grv-info-label">Department / Branch</span>
                                <span class="grv-info-value"><?= htmlspecialchars($trackedGrievance['branch']) ?> (<?= htmlspecialchars($trackedGrievance['dept_code']) ?>)</span>
                            </div>
                            <div class="grv-info-item">
                                <span class="grv-info-label">Submission Date</span>
                                <span class="grv-info-value"><?= date('d M Y, h:i A', strtotime($trackedGrievance['created_at'])) ?></span>
                            </div>
                        </div>

                        <div class="grv-detail-box">
                            <div class="grv-detail-label">
                                Grievance Category: <span style="color: #1f646c;"><?= htmlspecialchars($trackedGrievance['grievance_category']) ?></span>
                            </div>
                            <div class="grv-detail-content">
                                <?= nl2br(htmlspecialchars($trackedGrievance['grievance_description'])) ?>
                            </div>
                        </div>

                        <!-- Department Action / Remarks Box -->
                        <?php if (!empty($trackedGrievance['admin_remarks'])): ?>
                            <div class="grv-remarks-box">
                                <div class="grv-remarks-title">
                                    <i class="fas fa-check-double"></i>
                                    <span>Department Redressal Action &amp; Remarks</span>
                                </div>
                                <p class="grv-remarks-text">
                                    <?= nl2br(htmlspecialchars($trackedGrievance['admin_remarks'])) ?>
                                </p>
                                <?php if (!empty($trackedGrievance['resolved_at'])): ?>
                                    <div style="font-size: 0.78rem; color: #047857; margin-top: 6px; font-weight: 600;">
                                        Resolved on: <?= date('d M Y, h:i A', strtotime($trackedGrievance['resolved_at'])) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="grv-remarks-box pending">
                                <div class="grv-remarks-title pending">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Current Action Status</span>
                                </div>
                                <p class="grv-remarks-text" style="color: #92400e; font-size: 0.85rem;">
                                    Your application has been logged and assigned to the <?= htmlspecialchars($trackedGrievance['branch']) ?> administration committee. Official resolution remarks will be updated here as soon as the review is complete.
                                </p>
                            </div>
                        <?php endif; ?>

                        <div style="margin-top: 20px; text-align: center;">
                            <button type="button" 
                                    onclick="switchGrvTab('form')" 
                                    class="grv-track-btn" 
                                    style="background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;">
                                <i class="fas fa-plus"></i> Submit Another Grievance
                            </button>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

        </div>

    </div>
</div>

<script>
function switchGrvTab(tab) {
    var paneForm = document.getElementById('paneForm');
    var paneTrack = document.getElementById('paneTrack');
    var btnForm = document.getElementById('btnTabForm');
    var btnTrack = document.getElementById('btnTabTrack');

    if (tab === 'track') {
        if (paneForm) paneForm.style.display = 'none';
        if (paneTrack) paneTrack.style.display = 'block';
        if (btnForm) btnForm.classList.remove('active');
        if (btnTrack) btnTrack.classList.add('active');
    } else {
        if (paneTrack) paneTrack.style.display = 'none';
        if (paneForm) paneForm.style.display = 'block';
        if (btnTrack) btnTrack.classList.remove('active');
        if (btnForm) btnForm.classList.add('active');
    }
}
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
