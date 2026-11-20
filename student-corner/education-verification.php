<?php
$page_title = "Education Verification & Student Section | Government Engineering College, Modasa";
$page_description = "Student section activities, team members, departmental coordinators, and education verification services at GEC Modasa.";
$active_page = 'education-verification';
$root_path = '../';
$extra_css = 'css/education-verification.css';

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

$pdo = getDBConnection();

// Fetch active team members
$teamMembers = [];
$deptPdfPath = '';
$deptPdfTitle = 'Departmental Student Section Team Members';

if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM student_section_team WHERE is_active = 1 ORDER BY display_order ASC, sr_no ASC, id ASC");
        $teamMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Fetch Departmental PDF setting
        $pdfStmt = $pdo->query("SELECT setting_value FROM student_section_settings WHERE setting_key = 'dept_team_pdf_path' LIMIT 1");
        $pdfRow = $pdfStmt->fetch(PDO::FETCH_ASSOC);
        if ($pdfRow && !empty($pdfRow['setting_value'])) {
            $deptPdfPath = $pdfRow['setting_value'];
        }

        $titleStmt = $pdo->query("SELECT setting_value FROM student_section_settings WHERE setting_key = 'dept_team_pdf_title' LIMIT 1");
        $titleRow = $titleStmt->fetch(PDO::FETCH_ASSOC);
        if ($titleRow && !empty($titleRow['setting_value'])) {
            $deptPdfTitle = $titleRow['setting_value'];
        }
    } catch (Exception $e) {
        $teamMembers = [];
    }
}

// Fallback seed data matching official circular if database is empty
if (empty($teamMembers)) {
    $teamMembers = [
        [
            'sr_no' => 1,
            'name' => 'Dr. Lalit Narsingani',
            'department' => 'Science & Humanities Department',
            'designation' => 'Convener'
        ],
        [
            'sr_no' => 2,
            'name' => 'Dr. D. H. Sahay',
            'department' => 'General Department',
            'designation' => 'Co-Convener'
        ],
        [
            'sr_no' => 3,
            'name' => 'Dr. K. K. Bhatt',
            'department' => 'Electrical Engineering',
            'designation' => 'Member'
        ],
        [
            'sr_no' => 4,
            'name' => 'Prof. K. R. Patel',
            'department' => 'Electronics and Communication Engineering',
            'designation' => 'Member'
        ],
        [
            'sr_no' => 5,
            'name' => 'Dr. N. N. Mallare',
            'department' => 'IT',
            'designation' => 'Member'
        ],
        [
            'sr_no' => 6,
            'name' => 'Prof. N.D. Goriya',
            'department' => 'Computer Engineering',
            'designation' => 'Member'
        ]
    ];
}

// Official Activities list
$sectionActivities = [
    'Student Registration',
    'Fees Payment',
    'Scholarships',
    'Admission Cancellation',
    'Institute Transfer',
    'Student I-Card',
    'GTU certificates',
    'Bona fide / Character Certificate',
    'Name Correction',
    'Transcript'
];
?>

<div class="ev-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="ev-hero">
        <div class="ev-hero-inner">
            <span class="ev-kicker">STUDENT CORNER</span>
            <h1 class="ev-heading">STUDENT SECTION, GEC Modasa</h1>
            <p class="ev-lead">
                The prime objective of the student section is to assist the students for their various kinds of activities seeking from the institution such as enrollment, examination, scholarship, anti ragging, student grievance, student affairs and certifications.
            </p>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="ev-main-content">

        <!-- Activities Section -->
        <section class="ev-card" aria-label="Student Section Activities">
            <div class="ev-card-header">
                <h2 class="ev-card-title">
                    <i class="fas fa-tasks"></i>
                    <span>Section performed following activities for the students</span>
                </h2>
            </div>
            <div class="ev-card-body">
                <div class="ev-activities-grid">
                    <?php foreach ($sectionActivities as $activity): ?>
                        <div class="ev-activity-item">
                            <i class="fas fa-check-circle"></i>
                            <span><?= htmlspecialchars($activity) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Student Section Team Table Card -->
        <section class="ev-card" aria-label="Student Section Team">
            <div class="ev-card-header">
                <h2 class="ev-card-title">
                    <i class="fas fa-users"></i>
                    <span>Student Section Team</span>
                </h2>
            </div>

            <div class="ev-table-wrapper">
                <table class="ev-table">
                    <thead>
                        <tr>
                            <th style="width: 80px; text-align: center;">Sr No.</th>
                            <th style="width: 32%;">Name</th>
                            <th style="width: 40%;">Department</th>
                            <th style="width: 20%;">Designation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teamMembers as $index => $member): ?>
                            <tr>
                                <td class="ev-sr-no">
                                    <?= htmlspecialchars($member['sr_no'] ?? ($index + 1)) ?>
                                </td>
                                <td>
                                    <div class="ev-name">
                                        <?= htmlspecialchars($member['name']) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="ev-dept">
                                        <?= htmlspecialchars($member['department']) ?>
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                    $desig = $member['designation'] ?? 'Member';
                                    $isConvener = (stripos($desig, 'Convener') !== false);
                                    ?>
                                    <span class="ev-designation-badge <?= $isConvener ? 'convener' : '' ?>">
                                        <?= htmlspecialchars($desig) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Departmental Student Section Team Members PDF Link -->
            <div class="ev-pdf-bar">
                <?php if (!empty($deptPdfPath)): ?>
                    <a href="<?= $root_path . htmlspecialchars(ltrim($deptPdfPath, '/')) ?>" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="ev-pdf-link"
                       title="Open <?= htmlspecialchars($deptPdfTitle) ?> (PDF)">
                        <i class="fas fa-file-pdf"></i>
                        <span><?= htmlspecialchars($deptPdfTitle) ?></span>
                        <i class="fas fa-external-link-alt" style="font-size: 0.8rem; color: #0284c7; margin-left: 4px;"></i>
                    </a>
                <?php else: ?>
                    <span class="ev-pdf-link" style="color: #64748b; border-color: #e2e8f0; cursor: default;">
                        <i class="fas fa-file-pdf" style="color: #94a3b8;"></i>
                        <span><?= htmlspecialchars($deptPdfTitle) ?></span>
                    </span>
                <?php endif; ?>
                <span style="font-size: 0.86rem; color: #64748b;">
                    Official Institutional Roster
                </span>
            </div>
        </section>

        <!-- Education Verification Official Guidelines Card -->
        <section class="ev-card" aria-label="Official Education Verification Guidelines">
            <div class="ev-card-header">
                <h2 class="ev-card-title">
                    <i class="fas fa-shield-alt"></i>
                    <span>Official Education Verification Guidelines (BGV &amp; Screening Agencies)</span>
                </h2>
            </div>
            <div class="ev-card-body">
                <p class="ev-lead" style="margin-bottom: 16px;">
                    Government Engineering College, Modasa provides education credential verification services for prospective employers, background verification (BGV) partners, embassies, and academic bodies verifying degrees and marksheets issued to its alumni.
                </p>

                <div class="ev-guide-grid">
                    <div class="ev-guide-box">
                        <div class="ev-guide-title">
                            <i class="fas fa-envelope"></i> Verification Desk Email
                        </div>
                        <p class="ev-guide-val">
                            <strong>gec-modasa-dte@gujarat.gov.in</strong><br>
                            Requests must be sent from official corporate domain email addresses.
                        </p>
                    </div>

                    <div class="ev-guide-box">
                        <div class="ev-guide-title">
                            <i class="fas fa-paperclip"></i> Required Scanned Documents
                        </div>
                        <p class="ev-guide-val">
                            Clear PDF copies of Degree Certificate, Final Semester Marksheet, and signed candidate authorization / consent letter.
                        </p>
                    </div>

                    <div class="ev-guide-box">
                        <div class="ev-guide-title">
                            <i class="fas fa-clock"></i> Response Turnaround Time
                        </div>
                        <p class="ev-guide-val">
                            Formal verification reports are processed within <strong>3 to 5 business working days</strong> upon document validation.
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </main>

</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
