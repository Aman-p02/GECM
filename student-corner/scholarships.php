<?php
$page_title = "Scholarships | Government Engineering College, Modasa";
$page_description = "Explore state and national scholarship schemes, institutional coordinators, committee members, and application guidelines at GEC Modasa.";
$active_page = 'scholarships';
$root_path = '../';
$extra_css = 'css/scholarships.css';

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/header.php';

$pdo = getDBConnection();

// Fetch active scholarship committee members
$committeeMembers = [];
$academicYear = '2025-26';

if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM scholarship_committee WHERE is_active = 1 ORDER BY display_order ASC, id ASC");
        $committeeMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($committeeMembers[0]['academic_year'])) {
            $academicYear = $committeeMembers[0]['academic_year'];
        }
    } catch (Exception $e) {
        $committeeMembers = [];
    }
}

// Fallback seed data if database table is not yet created or empty
if (empty($committeeMembers)) {
    $committeeMembers = [
        [
            'category' => 'Convener & Leadership',
            'faculty_name' => 'Prof. D. R. Tarachandani (Asso. Prof and Head, AM Dept.)',
            'role_duties' => 'Convener',
            'cabin_no' => 'Main Building'
        ],
        [
            'category' => 'Convener & Leadership',
            'faculty_name' => 'Prof. M. M. Bhunga (Asst. Prof, AM Dept)',
            'role_duties' => "Co-Convener\nMOMA Scholarship / NSP Scholarship\nSEBC Scholarship",
            'cabin_no' => '1217'
        ],
        [
            'category' => 'Co In-charge (SEBC Scholarship)',
            'faculty_name' => 'Prof. V. A. Rathod (Asst. Prof, IT Dept)',
            'role_duties' => "SEBC/EBC (1st Year) / PM-Yashashvi\nM.E Comp Scholarship",
            'cabin_no' => '8216'
        ],
        [
            'category' => 'Co In-charge (SEBC Scholarship)',
            'faculty_name' => 'Prof. Sumit Banker (Asst. Prof, EE Dept)',
            'role_duties' => "SEBC/EBC (1st Year) / BCK-79 / BCK-80",
            'cabin_no' => '7201'
        ],
        [
            'category' => 'Co In-charge (SEBC Scholarship)',
            'faculty_name' => 'Prof. Parul A. Bhura (Asst. Prof, CE Dept)',
            'role_duties' => "SEBC/EBC (2nd Year) / PM-Yashashvi",
            'cabin_no' => '8112'
        ],
        [
            'category' => 'Co In-charge (SEBC Scholarship)',
            'faculty_name' => 'Prof. Sachin Ganchi (Asst. Prof, ME Dept)',
            'role_duties' => "SEBC/EBC (2nd Year) / BCK-79 / BCK-80",
            'cabin_no' => '2108'
        ],
        [
            'category' => 'Co In-charge (SEBC Scholarship)',
            'faculty_name' => 'Prof. Shilpa A. Rana (Asst. Prof, EC Dept)',
            'role_duties' => "SEBC/EBC (3rd Year) / PM-Yashashvi",
            'cabin_no' => '4117'
        ],
        [
            'category' => 'Co In-charge (SEBC Scholarship)',
            'faculty_name' => 'Prof. Sanket Bhatiya (Asst. Prof, ME Dept)',
            'role_duties' => "SEBC/EBC (3rd Year) / BCK-79 / BCK-80",
            'cabin_no' => '6218-B'
        ],
        [
            'category' => 'Co In-charge (SEBC Scholarship)',
            'faculty_name' => 'Prof. Dron H. Chaudhari (Asst. Prof, Civil Dept)',
            'role_duties' => "SEBC/EBC (4th Year) / PM-Yashashvi\nM.E Civil Scholarship",
            'cabin_no' => '1220'
        ],
        [
            'category' => 'Co In-charge (SEBC Scholarship)',
            'faculty_name' => 'Prof. Dinesh B. Sathawara (Asst. Prof, AM Dept)',
            'role_duties' => "SEBC/EBC (4th Year) / BCK-79 / BCK-80",
            'cabin_no' => '1130'
        ],
        [
            'category' => 'Co In-charge (SC / ST Scholarship)',
            'faculty_name' => 'Prof. H. I. Chaudhary (Asst. Prof, ME Dept)',
            'role_duties' => "SC Scholarship / ST Scholarship",
            'cabin_no' => '6219-B'
        ],
        [
            'category' => 'Co In-charge (MYSY / CMSS Scholarship)',
            'faculty_name' => 'Prof. S. R. Patel (Asst. Prof, CE Dept)',
            'role_duties' => "MYSY / CMSS Scholarship",
            'cabin_no' => 'CE-8115'
        ],
        [
            'category' => 'Co In-charge (MYSY / CMSS Scholarship)',
            'faculty_name' => 'Prof. N. V. Nagekar (Asst. Prof, CE Dept)',
            'role_duties' => "MYSY / CMSS Scholarship",
            'cabin_no' => 'CE-8217'
        ],
        [
            'category' => 'Co In-charge (PMSS & Other Scholarship)',
            'faculty_name' => 'Prof. C. K. Bariya (Asst. Prof, EE Dept)',
            'role_duties' => "PMSSS / Shram Vibhag / ONGC / Other Scholarships",
            'cabin_no' => '7201'
        ]
    ];
}

// Group committee members by category
$groupedCommittee = [];
foreach ($committeeMembers as $member) {
    $cat = $member['category'] ?? 'General Committee';
    $groupedCommittee[$cat][] = $member;
}

// Scholarship Portals for Guidelines section
$scholarshipPortals = [
    [
        'title' => 'Digital Gujarat Portal',
        'url' => 'https://www.digitalgujarat.gov.in/'
    ],
    [
        'title' => 'NSP Portal',
        'url' => 'https://scholarships.gov.in/'
    ],
    [
        'title' => 'PMSSS',
        'url' => 'https://www.aicte-india.org/bureaus/pms-jk'
    ],
    [
        'title' => 'Shram Vibhag',
        'url' => 'https://sanman.gujarat.gov.in/'
    ],
    [
        'title' => 'MYSY',
        'url' => 'https://mysy.guj.nic.in/'
    ],
    [
        'title' => 'PM-USP',
        'url' => 'https://scholarships.gov.in/'
    ]
];
?>

<div class="sch-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="sch-hero">
        <div class="sch-hero-inner">
            <span class="sch-kicker">STUDENT CORNER</span>
            <h1 class="sch-heading">Scholarships at Government Engineering College, Modasa</h1>
            <p class="sch-lead">
                Government Engineering College, Modasa offers a wide range of scholarships to support students from diverse socio-economic backgrounds. Eligible students can apply for MYSY, Digital Gujarat (SC/ST/SEBC/EWS), PM-YASASVI, BCK-79/80, Shramyogi, and National Scholarship Portal (NSP) schemes. Additional scholarships like PMSSS (J&amp;K &amp; Ladakh), Pragati (for girls), and AICTE-Swanath are also available. The list of dedicated faculty members is provided in the table below. These coordinators assist with application, document verification, and timely submission. Detailed eligibility, guidelines, and deadlines are available in following sections.
            </p>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="sch-main-content">

        <!-- Scholarship Committee Table Card -->
        <section class="sch-card" aria-label="Scholarship Committee Table">
            <div class="sch-card-header">
                <h2 class="sch-card-title">
                    <i class="fas fa-users-cog"></i>
                    <span>Scholarship Committee - Academic Year <?= htmlspecialchars($academicYear) ?></span>
                </h2>
            </div>

            <div class="sch-table-wrapper">
                <table class="sch-table">
                    <thead>
                        <tr>
                            <th style="width: 38%;">Name of Faculty/Staff</th>
                            <th style="width: 44%;">Role/Duties</th>
                            <th style="width: 18%;">Cabin No.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groupedCommittee as $groupName => $members): ?>
                            <?php if ($groupName !== 'Convener & Leadership' && $groupName !== 'General Committee'): ?>
                                <tr class="sch-group-row">
                                    <td colspan="3"><?= htmlspecialchars($groupName) ?></td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($members as $mem): ?>
                                <tr>
                                    <td>
                                        <div class="sch-faculty-name">
                                            <?= htmlspecialchars($mem['faculty_name']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="sch-role-text">
                                            <?= nl2br(htmlspecialchars($mem['role_duties'])) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="sch-cabin-badge">
                                            <?= htmlspecialchars($mem['cabin_no']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Guidelines for following Scholarships Section -->
        <section class="sch-guidelines-section" aria-label="Guidelines for Scholarships">
            <h2 class="sch-guidelines-heading">Guidelines for following Scholarships</h2>

            <div class="sch-portal-list">
                <?php foreach ($scholarshipPortals as $portal): ?>
                    <a href="<?= htmlspecialchars($portal['url']) ?>" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="sch-portal-card" 
                       title="Open <?= htmlspecialchars($portal['title']) ?> official portal">
                        <span class="sch-portal-title">
                            <?= htmlspecialchars($portal['title']) ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

    </main>

</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>
