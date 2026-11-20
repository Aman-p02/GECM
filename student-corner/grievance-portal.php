<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_title = "Student / Faculty Grievance Form | Government Engineering College, Modasa";
$page_description = "Submit student and faculty grievances online to the designated department administration at GEC Modasa.";
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
        } catch (Exception $e) {
            $errorMessage = "An error occurred while submitting your grievance. Please verify your details and try again.";
            error_log("Grievance submission error: " . $e->getMessage());
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="grv-page" id="mainContent">
    <div class="grv-container">

        <div class="grv-card">
            <h1 class="grv-title">Student / Faculty Grievance Form</h1>

            <?php if (!empty($successMessage)): ?>
                <div class="grv-alert grv-alert-success">
                    <div style="font-weight: 700; font-size: 1rem; margin-bottom: 4px; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-check-circle"></i> Submission Successful
                    </div>
                    <p style="margin: 0 0 8px 0;"><?= htmlspecialchars($successMessage) ?></p>
                    <div style="background: #ffffff; border: 1px dashed #10b981; border-radius: 6px; padding: 10px 14px; display: inline-block;">
                        <span style="font-size: 0.85rem; color: #475569;">Grievance Reference Ticket:</span>
                        <strong style="font-size: 1.05rem; color: #047857; letter-spacing: 0.04em; margin-left: 6px;">
                            <?= htmlspecialchars($generatedTicket) ?>
                        </strong>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($errorMessage)): ?>
                <div class="grv-alert grv-alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($errorMessage) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">

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

    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
