<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/db.php';
$pdo = getDBConnection();

// AJAX endpoint to fetch talukas based on selected district
if (isset($_GET['action']) && $_GET['action'] === 'get_talukas' && !empty($_GET['district'])) {
    header('Content-Type: application/json');
    $talukas = [];
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT DISTINCT Taluka, Distance_From_Modasa FROM location WHERE District = ? ORDER BY Taluka ASC");
            $stmt->execute([trim($_GET['district'])]);
            $talukas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {}
    }
    echo json_encode($talukas);
    exit;
}

$page_title = "Online Hostel Admission Form | Government Engineering College, Modasa";
$page_description = "Apply online for on-campus hostel admission at Government Engineering College, Modasa. View block details, distance criteria, and application status.";
$active_page = 'hostel-admission';
$root_path = '../';

// Check if form intake is open
$formIsOpen = 0;
$academicYear = '2024-2025';
$districts = [];

if ($pdo) {
    try {
        $st = $pdo->query("SELECT is_open, academic_year FROM form_status WHERE id = 1");
        if ($row = $st->fetch(PDO::FETCH_ASSOC)) {
            $formIsOpen = (int)$row['is_open'];
            $academicYear = $row['academic_year'] ?? '2024-2025';
        }

        $stmtDist = $pdo->query("SELECT DISTINCT District FROM location ORDER BY District ASC");
        $districts = $stmtDist->fetchAll(PDO::FETCH_COLUMN);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

$successMessage = '';
$errorMessage = '';
$generatedAppId = null;

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_application'])) {
    $studentName   = strtoupper(trim($_POST['student_name'] ?? ''));
    $gender        = trim($_POST['gender'] ?? '');
    $category      = trim($_POST['category'] ?? '');
    $fatherName    = strtoupper(trim($_POST['father_name'] ?? ''));
    $currentSem    = trim($_POST['current_sem'] ?? '1');
    $branch        = trim($_POST['branch'] ?? '');
    $acpcRank      = trim($_POST['acpc_merit_rank'] ?? '');
    $admissionYear = trim($_POST['admission_year'] ?? date('Y'));
    $district      = trim($_POST['district'] ?? '');
    $taluka        = trim($_POST['taluka'] ?? '');
    $permAddress   = trim($_POST['perm_address'] ?? '');
    $contactNumber = trim($_POST['contact_number'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $localAddress  = trim($_POST['local_address'] ?? '');
    $annualIncome  = trim($_POST['annual_income'] ?? '');
    $lastExam      = trim($_POST['last_exam'] ?? '12th Science');
    $passingYear   = trim($_POST['passing_year'] ?? date('Y'));
    $resultPercent = trim($_POST['result_percent'] ?? '');

    if (empty($studentName) || empty($gender) || empty($category) || empty($fatherName) || empty($branch) || empty($acpcRank) || empty($district) || empty($taluka) || empty($contactNumber) || empty($email)) {
        $errorMessage = "Please fill in all mandatory application fields marked with an asterisk (*).";
    } elseif (!$pdo) {
        $errorMessage = "Database service is temporarily offline. Please try again shortly.";
    } else {
        try {
            // Check for existing application with same ACPC rank & year
            $chk = $pdo->prepare("SELECT id FROM hostel_applications WHERE acpc_merit_rank = ? AND admission_year = ? LIMIT 1");
            $chk->execute([$acpcRank, $admissionYear]);
            if ($chk->rowCount() > 0) {
                $existingId = $chk->fetchColumn();
                $errorMessage = "An application (#{$existingId}) has already been submitted with ACPC Merit Rank {$acpcRank} for year {$admissionYear}.";
            } else {
                // Handle Photo Upload
                $photoPath = '';
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../uploads/hostel/students/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                        $newFilename = 'student_' . date('Ymd_His') . '_' . mt_rand(1000, 9999) . '.' . $ext;
                        $targetPath = $uploadDir . $newFilename;
                        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
                            $photoPath = 'uploads/hostel/students/' . $newFilename;
                        }
                    }
                }

                $stmtIns = $pdo->prepare("INSERT INTO hostel_applications 
                    (student_name, current_sem, branch, acpc_merit_rank, admission_year, gender, category, father_name, district, taluka, perm_address, contact_number, email, local_address, annual_income, last_exam, passing_year, result_percent, photo_path, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

                $stmtIns->execute([
                    $studentName, $currentSem, $branch, $acpcRank, $admissionYear,
                    $gender, $category, $fatherName, $district, $taluka,
                    $permAddress, $contactNumber, $email, $localAddress,
                    $annualIncome, $lastExam, $passingYear, $resultPercent, $photoPath
                ]);

                $generatedAppId = $pdo->lastInsertId();
                $successMessage = "Your Hostel Admission application has been successfully recorded! Application ID: #" . $generatedAppId;
            }
        } catch (Exception $e) {
            $errorMessage = "Error submitting application: " . $e->getMessage();
            error_log("Hostel app submission error: " . $e->getMessage());
        }
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<style>
.hostel-form-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    border: 1.5px solid #e2e8f0;
    padding: 36px 32px;
    max-width: 820px;
    margin: 0 auto;
}
.hostel-form-section {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 20px 22px;
    margin-bottom: 24px;
    background: #fcfdfd;
}
.hostel-form-legend {
    font-size: 0.92rem;
    font-weight: 800;
    color: #ff8800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0 8px;
    width: auto;
    margin-bottom: 0;
}
.hostel-label {
    font-size: 0.86rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 6px;
    display: block;
}
.hostel-input, .hostel-select, .hostel-textarea {
    width: 100%;
    border: 1.5px solid #cbd5e1;
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 0.90rem;
    color: #0f172a;
    background: #ffffff;
    transition: border-color .2s;
    font-family: inherit;
    box-sizing: border-box;
}
.hostel-input:focus, .hostel-select:focus, .hostel-textarea:focus {
    outline: none;
    border-color: #ff8800;
    box-shadow: 0 0 0 3px rgba(255, 136, 0, 0.15);
}
.hostel-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 14px;
}
.hostel-grid-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 14px;
    margin-bottom: 14px;
}
.btn-hostel-outline {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.90rem;
    font-weight: 600;
    padding: 10px 20px;
    text-decoration: none !important;
    border-radius: 6px;
    border: 1.5px solid #cbd5e1;
    background: #ffffff;
    color: #1e293b !important;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}
.btn-hostel-outline i {
    color: #ff8800;
}
.btn-hostel-outline:hover {
    background: #f8fafc;
    border-color: #ff8800;
    color: #ff8800 !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}
.btn-hostel-solid {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.90rem;
    font-weight: 600;
    padding: 10px 20px;
    text-decoration: none !important;
    border-radius: 6px;
    border: 1.5px solid #ff8800;
    background: #ff8800;
    color: #ffffff !important;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(255, 136, 0, 0.25);
}
.btn-hostel-solid i {
    color: #ffffff;
}
.btn-hostel-solid:hover {
    background: #e67a00;
    border-color: #e67a00;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(255, 136, 0, 0.35);
}
@media (max-width: 650px) {
    .hostel-form-card { padding: 24px 18px; }
    .hostel-grid-2, .hostel-grid-3 { grid-template-columns: 1fr; gap: 12px; }
}
</style>

<div style="background: #f8fafc; padding: 40px 16px; min-height: 80vh;" id="mainContent">
    <div style="max-width: 820px; margin: 0 auto;">

        <div style="text-align: center; margin-bottom: 28px;">
            <span style="font-size: 0.78rem; font-weight: 800; letter-spacing: 0.12em; text-transform: uppercase; color: #ff8800; display: block; margin-bottom: 4px;">
                ACADEMIC YEAR <?= htmlspecialchars($academicYear) ?>
            </span>
            <h1 style="font-size: clamp(1.6rem, 2.5vw, 2.1rem); font-weight: 800; color: #000000; margin: 0 0 8px 0; letter-spacing: -0.02em;">
                Hostel Online Admission Form
            </h1>
            <p style="font-size: 0.92rem; color: #475569; max-width: 580px; margin: 0 auto;">
                Government Engineering College, Modasa campus residential accommodation for undergraduate engineering students.
            </p>
        </div>

        <?php if (!empty($successMessage)): ?>
            <div style="background: #ecfdf5; border: 1.5px solid #a7f3d0; border-radius: 10px; padding: 22px; margin-bottom: 24px; text-align: center;">
                <div style="width: 48px; height: 48px; border-radius: 50%; background: #047857; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 12px auto;">
                    <i class="fas fa-check"></i>
                </div>
                <h3 style="margin: 0 0 6px 0; font-size: 1.25rem; font-weight: 800; color: #065f46;">Application Submitted Successfully!</h3>
                <p style="margin: 0 0 16px 0; font-size: 0.92rem; color: #047857;"><?= htmlspecialchars($successMessage) ?></p>
                <div style="background: #ffffff; border: 1px dashed #6ee7b7; border-radius: 8px; padding: 12px; display: inline-block;">
                    <span style="font-size: 0.85rem; color: #475569;">Your Application Reference ID:</span>
                    <strong style="font-size: 1.2rem; color: #ff8800; margin-left: 6px;">#<?= $generatedAppId ?></strong>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($errorMessage)): ?>
            <div style="background: #fef2f2; border: 1.5px solid #fecaca; border-radius: 8px; padding: 14px 18px; margin-bottom: 24px; color: #991b1b; font-size: 0.92rem; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-exclamation-circle" style="font-size: 1.1rem; color: #dc2626;"></i>
                <span><?= htmlspecialchars($errorMessage) ?></span>
            </div>
        <?php endif; ?>

        <?php if (!$formIsOpen): ?>
            <!-- Admissions Closed Notice Card -->
            <div class="hostel-form-card" style="text-align: center; padding: 48px 24px;">
                <div style="width: 64px; height: 64px; border-radius: 50%; background: #fff7ed; color: #ff8800; border: 2px solid #fed7aa; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin: 0 auto 18px auto;">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h2 style="font-size: 1.45rem; font-weight: 800; color: #0f172a; margin: 0 0 8px 0;">Hostel Admissions Are Currently Closed</h2>
                <p style="font-size: 0.94rem; color: #64748b; max-width: 520px; margin: 0 auto 24px auto; line-height: 1.6;">
                    The online application intake for hostel admission is not accepting submissions at this time. Registrations open during the official admission rounds (July - September).
                </p>
                <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
                    <a href="../administration/hostel-mess" class="btn-hostel-outline">
                        <i class="fas fa-info-circle"></i> View Hostel &amp; Mess Info
                    </a>
                    <a href="../contact" class="btn-hostel-solid">
                        <i class="fas fa-envelope"></i> Contact Administration
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Main Application Form -->
            <div class="hostel-form-card">
                <form method="POST" action="hostel-admission.php" enctype="multipart/form-data">
                    <input type="hidden" name="submit_application" value="1">
                    <input type="hidden" name="admission_year" value="<?= htmlspecialchars($academicYear) ?>">

                    <!-- 1. Personal Details -->
                    <fieldset class="hostel-form-section">
                        <legend class="hostel-form-legend">1. Personal Information</legend>

                        <div style="margin-bottom: 14px;">
                            <label class="hostel-label">Full Name (As per admission letter) <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="student_name" class="hostel-input" placeholder="SURNAME YOUR_NAME FATHER_NAME" required style="text-transform: uppercase;">
                        </div>

                        <div class="hostel-grid-2">
                            <div>
                                <label class="hostel-label">Gender <span style="color: #ef4444;">*</span></label>
                                <select name="gender" class="hostel-select" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="hostel-label">Category <span style="color: #ef4444;">*</span></label>
                                <select name="category" class="hostel-select" required>
                                    <option value="">-- Select Category --</option>
                                    <option value="Open">Open</option>
                                    <option value="Open-EWS">Open-EWS</option>
                                    <option value="SEBC">SEBC</option>
                                    <option value="SC">SC</option>
                                    <option value="ST">ST</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="hostel-label">Father's / Guardian's Full Name <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="father_name" class="hostel-input" placeholder="FATHER'S FULL NAME" required style="text-transform: uppercase;">
                        </div>
                    </fieldset>

                    <!-- 2. Academic Details -->
                    <fieldset class="hostel-form-section">
                        <legend class="hostel-form-legend">2. Academic Information</legend>

                        <div class="hostel-grid-2">
                            <div>
                                <label class="hostel-label">Semester <span style="color: #ef4444;">*</span></label>
                                <select name="current_sem" class="hostel-select" required>
                                    <option value="1">Semester 1 (First Year)</option>
                                    <option value="3">Semester 3 (D-to-D / Second Year)</option>
                                </select>
                            </div>
                            <div>
                                <label class="hostel-label">Engineering Branch <span style="color: #ef4444;">*</span></label>
                                <select name="branch" class="hostel-select" required>
                                    <option value="">-- Select Branch --</option>
                                    <option value="CE">Computer Engineering (CE)</option>
                                    <option value="IT">Information Technology (IT)</option>
                                    <option value="EC">Electronics &amp; Communication (EC)</option>
                                    <option value="Mechanical">Mechanical Engineering</option>
                                    <option value="Civil">Civil Engineering</option>
                                    <option value="Electrical">Electrical Engineering</option>
                                    <option value="Automobile">Automobile Engineering</option>
                                </select>
                            </div>
                        </div>

                        <div class="hostel-grid-2">
                            <div>
                                <label class="hostel-label">ACPC Merit Rank <span style="color: #ef4444;">*</span></label>
                                <input type="number" name="acpc_merit_rank" class="hostel-input" placeholder="e.g. 8420" required min="1">
                            </div>
                            <div>
                                <label class="hostel-label">Parent's Annual Income (₹) <span style="color: #ef4444;">*</span></label>
                                <input type="number" name="annual_income" class="hostel-input" placeholder="e.g. 250000" required>
                            </div>
                        </div>

                        <div class="hostel-grid-3">
                            <div>
                                <label class="hostel-label">Previous Exam</label>
                                <select name="last_exam" class="hostel-select">
                                    <option value="12th Science">12th Science (HSC)</option>
                                    <option value="Diploma">Diploma Engineering</option>
                                </select>
                            </div>
                            <div>
                                <label class="hostel-label">Passing Year</label>
                                <input type="number" name="passing_year" class="hostel-input" value="<?= date('Y') ?>" min="2015" max="<?= date('Y') + 1 ?>">
                            </div>
                            <div>
                                <label class="hostel-label">Percentage (%)</label>
                                <input type="text" name="result_percent" class="hostel-input" placeholder="e.g. 84.50">
                            </div>
                        </div>
                    </fieldset>

                    <!-- 3. Address & Distance Criteria -->
                    <fieldset class="hostel-form-section">
                        <legend class="hostel-form-legend">3. Address &amp; Distance Verification</legend>

                        <div class="hostel-grid-2">
                            <div>
                                <label class="hostel-label">Native District <span style="color: #ef4444;">*</span></label>
                                <select name="district" id="districtSelect" class="hostel-select" required onchange="loadTalukas(this.value)">
                                    <option value="">-- Select District --</option>
                                    <?php foreach ($districts as $d): ?>
                                        <option value="<?= htmlspecialchars($d) ?>"><?= htmlspecialchars($d) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="hostel-label">Taluka <span style="color: #ef4444;">*</span></label>
                                <select name="taluka" id="talukaSelect" class="hostel-select" required onchange="displayDistance(this)">
                                    <option value="">-- Select District First --</option>
                                </select>
                            </div>
                        </div>

                        <div id="distanceCard" style="display: none; background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 6px; padding: 10px 14px; margin-bottom: 14px; font-size: 0.86rem; color: #065f46;">
                            <i class="fas fa-map-marker-alt" style="color: #047857; margin-right: 6px;"></i>
                            Calculated Distance from GEC Modasa: <strong id="distanceValue" style="color: #ff8800; font-size: 1rem;">0 KM</strong>
                        </div>

                        <div style="margin-bottom: 14px;">
                            <label class="hostel-label">Full Permanent Address <span style="color: #ef4444;">*</span></label>
                            <textarea name="perm_address" rows="3" class="hostel-textarea" placeholder="Village / City, Street, Pincode" required></textarea>
                        </div>

                        <div class="hostel-grid-2">
                            <div>
                                <label class="hostel-label">Mobile Number <span style="color: #ef4444;">*</span></label>
                                <input type="tel" name="contact_number" class="hostel-input" placeholder="10-digit mobile number" pattern="[0-9]{10}" required>
                            </div>
                            <div>
                                <label class="hostel-label">Email Address <span style="color: #ef4444;">*</span></label>
                                <input type="email" name="email" class="hostel-input" placeholder="your.email@example.com" required>
                            </div>
                        </div>

                        <div>
                            <label class="hostel-label">Local Guardian Address (if any)</label>
                            <input type="text" name="local_address" class="hostel-input" placeholder="Optional: Relative / Guardian contact in Modasa">
                        </div>
                    </fieldset>

                    <!-- 4. Photo Upload -->
                    <fieldset class="hostel-form-section">
                        <legend class="hostel-form-legend">4. Passport Photo Upload</legend>
                        <div>
                            <label class="hostel-label">Student Passport Photo (JPG/PNG max 1MB) <span style="color: #ef4444;">*</span></label>
                            <input type="file" name="photo" class="hostel-input" accept="image/jpeg,image/png,image/webp" required style="padding: 8px;">
                            <small style="color: #64748b; font-size: 0.78rem; display: block; margin-top: 4px;">Recent formal passport size photo. Required for ID card and hostel verification register.</small>
                        </div>
                    </fieldset>

                    <button type="submit" class="btn btn-primary" style="background: #ff8800; border-color: #ff8800; color: #fff; width: 100%; padding: 14px; font-size: 1.05rem; font-weight: 800; border-radius: 8px; cursor: pointer; box-shadow: 0 4px 12px rgba(255, 136, 0, 0.25);">
                        Submit Application &amp; Generate Acknowledgment
                    </button>
                </form>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
let talukaData = [];

function loadTalukas(district) {
    const talukaSelect = document.getElementById('talukaSelect');
    const distCard = document.getElementById('distanceCard');
    distCard.style.display = 'none';

    if (!district) {
        talukaSelect.innerHTML = '<option value="">-- Select District First --</option>';
        return;
    }

    talukaSelect.innerHTML = '<option value="">Loading Talukas...</option>';

    fetch('hostel-admission.php?action=get_talukas&district=' + encodeURIComponent(district))
        .then(r => r.json())
        .then(data => {
            talukaData = data;
            talukaSelect.innerHTML = '<option value="">-- Select Taluka --</option>';
            data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.Taluka;
                opt.textContent = item.Taluka + ' (' + item.Distance_From_Modasa + ' KM)';
                opt.setAttribute('data-km', item.Distance_From_Modasa);
                talukaSelect.appendChild(opt);
            });
        })
        .catch(err => {
            console.error(err);
            talukaSelect.innerHTML = '<option value="">Error loading talukas</option>';
        });
}

function displayDistance(sel) {
    const selectedOpt = sel.options[sel.selectedIndex];
    const km = selectedOpt.getAttribute('data-km');
    const distCard = document.getElementById('distanceCard');
    const distVal = document.getElementById('distanceValue');

    if (km) {
        distVal.textContent = km + ' KM';
        distCard.style.display = 'block';
    } else {
        distCard.style.display = 'none';
    }
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
