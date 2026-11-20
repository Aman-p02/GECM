<?php
/**
 * GEC MODASA - HOSTEL & MESS FACILITY
 * Modern Department-Grade Editorial Design, 100% Mobile Responsive
 */
$page_title = "Hostel & Mess Facility | GEC Modasa";
$active_page = 'hostel-mess';
$root_path = '../';
$extra_css = 'css/hostel-mess.css';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

// Official In-Memory Datasets Matching Institutional Records
$defaultWardenStaff = [
    ['work_description' => 'Warden & Care Taker', 'block_name' => 'A', 'warden' => "Prof. A. D. Chaudhari (Info. Tech. Dept.)", 'care_taker' => "Prof. J. P. Pandya (Civil Dept.)"],
    ['work_description' => 'Warden & Care Taker', 'block_name' => 'B', 'warden' => "Prof. A. J. Patel (Applied Mechanics Dept.)", 'care_taker' => "Prof. D. B. Sathvara (Applied Mechanics Dept.)"],
    ['work_description' => 'Warden & Care Taker', 'block_name' => 'C', 'warden' => "Prof. J. R. Bhavsar (Mechanical Dept.)", 'care_taker' => "Prof. N. V. Nagekar (Computer Dept.)"],
    ['work_description' => 'Warden & Care Taker', 'block_name' => 'E (Ground Floor)', 'warden' => "Prof. A. K. Dodiya (Computer Dept.)", 'care_taker' => ''],
    ['work_description' => 'Warden & Care Taker', 'block_name' => 'E (First Floor)', 'warden' => "Prof. M. G. Patel (Mechanical Dept.)", 'care_taker' => ''],
    ['work_description' => 'Warden & Care Taker', 'block_name' => 'E (Second Floor)', 'warden' => "Prof. C. K. Bariya (Electrical Dept.)", 'care_taker' => ''],
    ['work_description' => 'Warden & Care Taker', 'block_name' => 'E (Third Floor)', 'warden' => "Prof. M. M. Bhunga (Applied Mechanics Dept.)", 'care_taker' => ''],
    ['work_description' => 'Warden & Care Taker', 'block_name' => "F (Girl's Hostel)", 'warden' => "Prof. S. K. Rana (EC Dept.)\nProf. Nehal S. Chawdhary (Computer Dept.)", 'care_taker' => "Prof. Rinkal J. Prajapati (Computer Dept.)\nProf. Hinal B. Thakar (Civil Dept.)"]
];

$defaultWorkStaff = [
    ['work_description' => 'Civil works', 'staff_incharge' => 'Prof. D. A. Sagar (Applied Mechanics Dept.)'],
    ['work_description' => 'Electrical works', 'staff_incharge' => 'Prof. J. B. Pujara (Electrical Dept.)'],
    ['work_description' => 'Administrative works', 'staff_incharge' => 'Shri H. M. Vanakar (Mechanical Engineering)']
];

$defaultLeadership = [
    ['role_badge' => 'Chief Warden / Rector', 'name' => 'Prof. (Dr.) U. V. Shah', 'designation' => 'Professor & Head', 'department' => 'Mechanical Engineering Department', 'is_primary' => 1, 'display_order' => 1],
    ['role_badge' => 'Assistant Rector', 'name' => 'Prof. P. R. Gamit', 'designation' => 'Assistant Professor', 'department' => 'Computer Engineering Department', 'is_primary' => 0, 'display_order' => 2],
    ['role_badge' => 'Assistant Rector', 'name' => 'Prof. P. V. Patel', 'designation' => 'Assistant Professor', 'department' => 'Electronics & Communication Dept.', 'is_primary' => 0, 'display_order' => 3]
];

$defaultBlockCapacity = [
    ['sr_no' => 1, 'block_name' => 'A', 'number_of_floor' => 'G + 2', 'total_rooms' => 44, 'number_of_students' => 132],
    ['sr_no' => 2, 'block_name' => 'B', 'number_of_floor' => 'G + 2', 'total_rooms' => 44, 'number_of_students' => 132],
    ['sr_no' => 3, 'block_name' => 'C', 'number_of_floor' => 'G + 2', 'total_rooms' => 44, 'number_of_students' => 132],
    ['sr_no' => 4, 'block_name' => 'D', 'number_of_floor' => 'G + 2', 'total_rooms' => 16, 'number_of_students' => 48],
    ['sr_no' => 5, 'block_name' => 'E', 'number_of_floor' => 'G + 3', 'total_rooms' => 122, 'number_of_students' => 366],
    ['sr_no' => 6, 'block_name' => 'F', 'number_of_floor' => 'G + 2', 'total_rooms' => 32, 'number_of_students' => 96]
];

$defaultFeesStructure = [
    ['year_name' => '1st year', 'hostel_fees' => '1750'],
    ['year_name' => '2nd year', 'hostel_fees' => '1700'],
    ['year_name' => '3rd year', 'hostel_fees' => '1700']
];

$defaultMessNotes = [
    "The Mess is operated twice a day at lunch and at dinner.",
    "The mess is operated by the private mess contractor.",
    "The mess contractor is finalized based on the terms and condition of contract.",
    "The mess committee is framed to monitor the quantity, quality and rates of food provided by the mess contractor.",
    "The mess is non operative during vacation.",
    "The hostel fee does not include mess fee. It is to be paid separately to the mess contractor as per the terms and condition of mess contract."
];

$defaultFeeNotes = [
    "Hostel facility is available exclusively for boy students of GEC, Modasa campus only.",
    "Hostel fee is non-transferable and not refundable.",
    "The hostel fee does not include mess fee. It is to be paid separately to the mess contractor as per the terms and condition of mess contract.",
    "Hostel facility is available upto 3rd year only."
];

// Initial State
$hostelData = null;
$leadershipList = $defaultLeadership;
$wardenStaff = $defaultWardenStaff;
$workStaff = $defaultWorkStaff;
$blockCapacity = $defaultBlockCapacity;
$feesStructure = $defaultFeesStructure;
$messPoints = $defaultMessNotes;
$feePoints = $defaultFeeNotes;
$photos = [
    ['caption' => 'GEC Modasa - Main Hostel Building', 'image_path' => 'uploads/hostel/hostel_main.jpg']
];

// Safely query database when available
if ($pdo) {
    try {
        $stmtH = $pdo->query("SELECT * FROM hostel_mess LIMIT 1");
        $hDb = $stmtH ? $stmtH->fetch(PDO::FETCH_ASSOC) : null;
        if ($hDb) {
            $hostelData = $hDb;
            if (!empty($hDb['mess_notes'])) {
                $messPoints = explode("\n", str_replace("\r", "", trim($hDb['mess_notes'])));
            }
            if (!empty($hDb['fee_notes'])) {
                $feePoints = explode("\n", str_replace("\r", "", trim($hDb['fee_notes'])));
            }
        }

        $stmtLd = $pdo->query("SELECT * FROM hostel_leadership ORDER BY display_order ASC, id ASC");
        $ldDb = $stmtLd ? $stmtLd->fetchAll(PDO::FETCH_ASSOC) : [];
        if (!empty($ldDb)) $leadershipList = $ldDb;

        $stmtW = $pdo->query("SELECT * FROM hostel_staff WHERE section_type = 'warden_caretaker' ORDER BY display_order ASC, id ASC");
        $wDb = $stmtW ? $stmtW->fetchAll(PDO::FETCH_ASSOC) : [];
        if (!empty($wDb)) $wardenStaff = $wDb;

        $stmtWorks = $pdo->query("SELECT * FROM hostel_staff WHERE section_type = 'works' ORDER BY display_order ASC, id ASC");
        $worksDb = $stmtWorks ? $stmtWorks->fetchAll(PDO::FETCH_ASSOC) : [];
        if (!empty($worksDb)) $workStaff = $worksDb;

        $stmtB = $pdo->query("SELECT * FROM hostel_blocks ORDER BY display_order ASC, sr_no ASC");
        $bDb = $stmtB ? $stmtB->fetchAll(PDO::FETCH_ASSOC) : [];
        if (!empty($bDb)) $blockCapacity = $bDb;

        $stmtF = $pdo->query("SELECT * FROM hostel_fees ORDER BY display_order ASC, id ASC");
        $fDb = $stmtF ? $stmtF->fetchAll(PDO::FETCH_ASSOC) : [];
        if (!empty($fDb)) $feesStructure = $fDb;

        $stmtP = $pdo->query("SELECT * FROM hostel_photos WHERE is_active = 1 ORDER BY display_order ASC, id ASC");
        $pDb = $stmtP ? $stmtP->fetchAll(PDO::FETCH_ASSOC) : [];
        if (!empty($pDb)) $photos = $pDb;
    } catch (Throwable $e) {
        error_log("Hostel data fetch error: " . $e->getMessage());
    }
}

$formIsOpen = 0;
$academicYear = '2024-2025';
if ($pdo) {
    try {
        $stmtStatus = $pdo->query("SELECT is_open, academic_year FROM form_status WHERE id = 1");
        if ($stRow = $stmtStatus->fetch(PDO::FETCH_ASSOC)) {
            $formIsOpen = (int)$stRow['is_open'];
            $academicYear = $stRow['academic_year'] ?? '2024-2025';
        }
    } catch (Throwable $e) {}
}

$rulesPdf = !empty($hostelData['rules_pdf_url']) ? $hostelData['rules_pdf_url'] : 'uploads/hostel/hostel_rules_and_regulations.pdf';
?>

<div class="hostel-page" id="mainContent" data-active-tab="about">

    <!-- Sticky Sub-Navigation Bar (Department Style - Placed right under main website navbar) -->
    <nav class="dept-subnav-bar" id="deptSubNav" aria-label="Hostel Navigation" data-root="<?= $root_path ?>">
        <div class="hostel-container">
            <div class="dept-subnav-wrap">
                <ul class="dept-subnav-list" role="tablist">
                    <li class="dept-subnav-item active">
                        <button type="button" class="dept-subnav-link active" data-tab="about" role="tab" aria-selected="true">About</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="mess" role="tab" aria-selected="false">Hostel Mess</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="fees" role="tab" aria-selected="false">Fees Structure</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="rules" role="tab" aria-selected="false">Hostel Rules</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="capacity" role="tab" aria-selected="false">Hostel Block Capacity</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="photos" role="tab" aria-selected="false">Photos</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Hostel Content Area -->
    <main class="hostel-main-content">
        <div class="hostel-container">

        <!-- ========================================================================= -->
        <!-- TAB 1: ABOUT (Overview, Committees, Leadership, Common Room & Staff Table) -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane active" id="aboutTab">

            <!-- Department-Style Hero Banner -->
            <header class="hostel-hero-banner">
                <span class="hostel-kicker">CAMPUS AMENITIES &amp; RESIDENTIAL LIFE</span>
                <h1 class="hostel-heading">Hostel &amp; Mess Facility</h1>
                <p class="hostel-tagline">
                    Comfortable, disciplined, and secure on-campus residential accommodation fostering academic focus, holistic personal development, and an inclusive student community across campus blocks.
                </p>
            </header>

            <!-- Live Admission Status Callout Banner -->
            <?php if ($formIsOpen): ?>
                <div style="background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); border: 2px solid #ff8800; border-radius: 12px; padding: 18px 24px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; box-shadow: 0 4px 14px rgba(255, 136, 0, 0.15);">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: #ff8800; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="background: #047857; color: #ffffff; font-size: 0.72rem; font-weight: 800; padding: 2px 8px; border-radius: 10px; letter-spacing: 0.05em; text-transform: uppercase;">Admissions Open</span>
                                <span style="font-size: 0.82rem; font-weight: 700; color: #9a3412;">Academic Year <?= htmlspecialchars($academicYear) ?></span>
                            </div>
                            <h3 style="margin: 4px 0 0 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Hostel Online Application Intake is Now Active!</h3>
                        </div>
                    </div>
                    <a href="<?= $root_path ?>student-corner/hostel-admission" class="btn btn-primary" style="background: #ff8800; border: none; color: #fff; padding: 10px 22px; font-weight: 700; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 3px 10px rgba(255, 136, 0, 0.3);">
                        Apply Online Now <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            <?php else: ?>
                <div style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 14px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 10px; color: #64748b; font-size: 0.90rem;">
                        <i class="fas fa-info-circle" style="color: #94a3b8; font-size: 1.1rem;"></i>
                        <span>Hostel admissions for the current session are currently <strong>closed</strong>.</span>
                    </div>
                    <a href="<?= $root_path ?>student-corner/hostel-admission" style="font-size: 0.85rem; font-weight: 600; color: #ff8800; text-decoration: none;">View Admission Details &rarr;</a>
                </div>
            <?php endif; ?>

            <!-- Institutional Stat Highlights -->
            <div class="hostel-stats-grid">
                <div class="hostel-stat-card">
                    <div class="hostel-stat-num">4</div>
                    <div class="hostel-stat-label">Boys' Hostel Blocks</div>
                </div>
                <div class="hostel-stat-card">
                    <div class="hostel-stat-num">2</div>
                    <div class="hostel-stat-label">Girls' Hostel Blocks</div>
                </div>
                <div class="hostel-stat-card">
                    <div class="hostel-stat-num">462</div>
                    <div class="hostel-stat-label">Total Student Capacity</div>
                </div>
                <div class="hostel-stat-card">
                    <div class="hostel-stat-num">154</div>
                    <div class="hostel-stat-label">Furnished Rooms</div>
                </div>
            </div>

            <!-- 1. Campus Overview Hero Card with Building Photo -->
            <div class="hostel-overview-card">
                <div class="hostel-overview-grid">
                    <div class="hostel-overview-media">
                        <img src="<?= $root_path ?>uploads/hostel/hostel_main.jpg" alt="Hostel Building - GEC Modasa" class="hostel-overview-img" onerror="this.src='<?= $root_path ?>images/hero_campus_1.jpg'">
                    </div>
                    <div class="hostel-overview-body">
                        <span class="hostel-sec-kicker">RESIDENTIAL OVERVIEW</span>
                        <h2 class="hostel-sec-title" style="margin-bottom: 16px;">Campus Residential Blocks</h2>
                        <p class="hostel-overview-lead">
                            The College has four Boys' Hostel blocks and two Girls' Hostel blocks near the campus to accommodate students coming from different parts of Gujarat and other states. The Boys' Hostels provide accommodation for 366 students in 122 rooms across various semesters. The Girls' Hostels have a capacity of 96 students in 32 rooms.
                        </p>
                        <p class="hostel-overview-lead" style="margin-bottom: 24px;">
                            Hostel admission is granted based on distance based, department-wise, and category-wise criteria. Students are allowed to stay in the hostel for a maximum of six semesters (up to the 3rd year). The mess facility operates twice a day, serving lunch and dinner. Each room accommodates three students and is furnished with three steel beds, three chairs, three wall cupboards, and three study tables.
                        </p>
                        <div class="hostel-overview-badge-row">
                            <span class="hostel-badge-tag"><i class="fas fa-bed"></i> 3 Beds &amp; Study Tables / Room</span>
                            <span class="hostel-badge-tag"><i class="fas fa-utensils"></i> Lunch &amp; Dinner Mess Service</span>
                            <span class="hostel-badge-tag"><i class="fas fa-calendar-alt"></i> Max 6 Semesters (Up to 3rd Yr)</span>
                            <span class="hostel-badge-tag"><i class="fas fa-shield-alt"></i> 24x7 Campus Security</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Organizational Structure Committees Grid -->
            <div class="hostel-sec-header">
                <span class="hostel-sec-kicker">GOVERNANCE &amp; COMMITTEES</span>
                <h2 class="hostel-sec-title">Organizational Structure of Hostel</h2>
            </div>

            <div class="hostel-governance-panels">
                <!-- Panel 1: Hostel Management Committee -->
                <div class="hostel-panel">
                    <div class="hostel-panel-header">
                        <div class="hostel-panel-header-main">
                            <span class="hostel-panel-kicker">Statutory Body</span>
                            <h3 class="hostel-panel-title">Hostel Management Committee</h3>
                        </div>
                    </div>
                    <p class="hostel-panel-desc">Constituted for residential governance, hostel policy formulation, student welfare, and operational supervision:</p>
                    <div class="hostel-panel-table-wrap">
                        <table class="hostel-panel-table">
                            <thead>
                                <tr>
                                    <th style="width: 14%;">No.</th>
                                    <th style="width: 48%;">Designation</th>
                                    <th style="width: 38%;">Role in Committee</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="hostel-idx">01</td>
                                    <td class="hostel-officer">Principal</td>
                                    <td><span class="hostel-role-tag hostel-role-patron">Patron &amp; Head of Institute</span></td>
                                </tr>
                                <tr>
                                    <td class="hostel-idx">02</td>
                                    <td class="hostel-officer">Rector / Assistant Rector</td>
                                    <td><span class="hostel-role-tag hostel-role-exec">Executive Authority</span></td>
                                </tr>
                                <tr>
                                    <td class="hostel-idx">03</td>
                                    <td class="hostel-officer">Hostel Wardens</td>
                                    <td><span class="hostel-role-tag">Block Administration</span></td>
                                </tr>
                                <tr>
                                    <td class="hostel-idx">04</td>
                                    <td class="hostel-officer">Care Takers</td>
                                    <td><span class="hostel-role-tag">Ground Supervision</span></td>
                                </tr>
                                <tr>
                                    <td class="hostel-idx">05</td>
                                    <td class="hostel-officer">Administrative Staff</td>
                                    <td><span class="hostel-role-tag">Records &amp; Secretariat</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Panel 2: Institute Disciplinary Committee -->
                <div class="hostel-panel">
                    <div class="hostel-panel-header">
                        <div class="hostel-panel-header-main">
                            <span class="hostel-panel-kicker">Institutional Body</span>
                            <h3 class="hostel-panel-title">Institute Disciplinary Committee</h3>
                        </div>
                    </div>
                    <p class="hostel-panel-desc">Mandated with maintaining institutional discipline, student conduct guidelines, and hostel code of ethics:</p>
                    <div class="hostel-panel-table-wrap">
                        <table class="hostel-panel-table">
                            <thead>
                                <tr>
                                    <th style="width: 14%;">No.</th>
                                    <th style="width: 48%;">Designation</th>
                                    <th style="width: 38%;">Role in Committee</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="hostel-idx">01</td>
                                    <td class="hostel-officer">Principal</td>
                                    <td><span class="hostel-role-tag hostel-role-patron">Chairman</span></td>
                                </tr>
                                <tr>
                                    <td class="hostel-idx">02</td>
                                    <td class="hostel-officer">All Heads of the Departments</td>
                                    <td><span class="hostel-role-tag">Members</span></td>
                                </tr>
                                <tr>
                                    <td class="hostel-idx">03</td>
                                    <td class="hostel-officer">Rector / Assistant Rector</td>
                                    <td><span class="hostel-role-tag hostel-role-exec">Member Secretary</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 3. Executive Leadership & Administration -->
            <div class="hostel-sec-header" style="margin-top: 40px;">
                <span class="hostel-sec-kicker">EXECUTIVE ADMINISTRATION</span>
                <h2 class="hostel-sec-title">Hostel Leadership &amp; Administration</h2>
            </div>

            <div class="hostel-leadership-cards">
                <?php foreach ($leadershipList as $ld): ?>
                    <div class="hostel-leader-tile <?= !empty($ld['is_primary']) ? 'hostel-leader-primary' : '' ?>">
                        <span class="hostel-leader-role-tag"><?= htmlspecialchars($ld['role_badge']) ?></span>
                        <h3 class="hostel-leader-name"><?= htmlspecialchars($ld['name']) ?></h3>
                        <div class="hostel-leader-desig"><?= htmlspecialchars($ld['designation']) ?></div>
                        <div class="hostel-leader-dept"><?= htmlspecialchars($ld['department']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- 4. Campus Student Welfare: Girl's Common Room Facility -->
            <div class="hostel-common-room-banner">
                <div class="hostel-cr-left">
                    <span class="hostel-cr-kicker">CAMPUS STUDENT WELFARE</span>
                    <h3 class="hostel-cr-title">Dedicated Girl's Common Room Facility</h3>
                    <p class="hostel-cr-desc">
                        Equipped, hygienic, and secure rest, study, and recreational spaces designated for female students across campus hours:
                    </p>
                </div>
                <div class="hostel-cr-locations">
                    <div class="hostel-cr-loc-card">
                        <span class="hostel-cr-loc-badge">Primary Academic Hours</span>
                        <div class="hostel-cr-loc-room">Room No. 7102</div>
                        <div class="hostel-cr-loc-bldg">Electrical Engineering Department</div>
                    </div>
                    <div class="hostel-cr-loc-card">
                        <span class="hostel-cr-loc-badge">Residential &amp; Emergency</span>
                        <div class="hostel-cr-loc-room">Recreation Hall</div>
                        <div class="hostel-cr-loc-bldg">Girl's Hostel Campus</div>
                    </div>
                </div>
            </div>

            <!-- 4. Staff Incharge Table (Administrational Structure) -->
            <div class="hostel-sec-header" style="margin-top: 48px;">
                <span class="hostel-sec-kicker">DUTY ALLOCATION &amp; CARETAKERS</span>
                <h2 class="hostel-sec-title">Administrational Structure of Hostel</h2>
                <p style="font-size: 0.95rem; color: var(--hostel-muted); margin: 6px 0 0;">
                    The administrational structure and designated officers in charge of respective blocks are shown below:
                </p>
            </div>

            <div class="hostel-table-wrap">
                <table class="hostel-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 24%;">Description of work</th>
                            <th colspan="3" style="text-align: center;">Staff Incharge</th>
                        </tr>
                        <tr>
                            <th style="width: 22%; text-align: center;">Block</th>
                            <th style="width: 27%;">Warden</th>
                            <th style="width: 27%;">Care Taker</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($wardenStaff) && empty($workStaff)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 24px; color: var(--hostel-muted);">
                                    No staff records currently published.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php 
                            // Group wardenStaff dynamically by work_description
                            $groupedWarden = [];
                            foreach ($wardenStaff as $w) {
                                $desc = trim($w['work_description'] ?? 'Warden & Care Taker');
                                if ($desc === '') $desc = 'Warden & Care Taker';
                                $groupedWarden[$desc][] = $w;
                            }

                            foreach ($groupedWarden as $groupDesc => $groupRows):
                                $groupCount = count($groupRows);
                                $isFirst = true;
                                foreach ($groupRows as $w):
                            ?>
                                <tr>
                                    <?php if ($isFirst): ?>
                                        <td rowspan="<?= $groupCount ?>" style="font-weight: 700; color: var(--hostel-primary); vertical-align: top; background: #ffffff;">
                                            <?= htmlspecialchars($groupDesc) ?>
                                        </td>
                                        <?php $isFirst = false; ?>
                                    <?php endif; ?>
                                    <td style="text-align: center;">
                                        <span class="hostel-badge"><?= htmlspecialchars($w['block_name']) ?></span>
                                    </td>
                                    <td style="font-weight: 500; color: var(--hostel-primary);">
                                        <?= nl2br(htmlspecialchars(str_replace('\n', "\n", $w['warden'] ?? ''))) ?>
                                    </td>
                                    <td>
                                        <?= !empty($w['care_taker']) ? nl2br(htmlspecialchars(str_replace('\n', "\n", $w['care_taker']))) : '<span style="color: #94a3b8;">&mdash;</span>' ?>
                                    </td>
                                </tr>
                            <?php 
                                endforeach;
                            endforeach; 
                            ?>

                            <!-- Technical & Works Section (Civil, Electrical, Administrative) -->
                            <?php foreach ($workStaff as $ws): ?>
                                <tr>
                                    <td style="font-weight: 700; color: var(--hostel-primary);">
                                        <?= htmlspecialchars($ws['work_description']) ?>
                                    </td>
                                    <td colspan="3" style="font-weight: 500; color: var(--hostel-primary);">
                                        <?= htmlspecialchars($ws['staff_incharge'] ?? $ws['warden'] ?? '') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- TAB 2: HOSTEL MESS -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane" id="messTab">
            <!-- Section Header with Enlarged Heading -->
            <div class="hostel-sec-header hostel-mess-main-header">
                <span class="hostel-sec-kicker">CAMPUS DINING</span>
                <h2 class="hostel-sec-title hostel-mess-main-title">Hostel Mess Facility &amp; Operational Guidelines</h2>
            </div>

            <!-- Guidelines Table Directly on the Page (No nested box wrapper, No count) -->
            <div class="hostel-table-wrap hostel-mess-table-wrap">
                <table class="hostel-table hostel-mess-table">
                    <thead>
                        <tr>
                            <th style="width: 80px; text-align: center;">Sr. No.</th>
                            <th>Operational Guideline / Regulation Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $ruleNo = 1;
                        foreach ($messPoints as $pt): 
                            $text = trim($pt);
                            if (empty($text)) continue;
                        ?>
                            <tr>
                                <td class="hostel-idx" style="text-align: center; vertical-align: top; padding-top: 18px; font-weight: 700; color: #ff8800; font-size: 0.95rem;">
                                    <?= sprintf('%02d', $ruleNo) ?>
                                </td>
                                <td style="padding: 16px 20px; vertical-align: middle;">
                                    <p class="hostel-mess-entry-text"><?= htmlspecialchars($text) ?></p>
                                </td>
                            </tr>
                        <?php 
                            $ruleNo++;
                        endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Administrative Policy Footnote -->
            <div class="hostel-mess-callout-note">
                <i class="fas fa-info-circle hostel-mess-note-icon"></i>
                <div>
                    <strong>Administrative Policy:</strong>
                    The hostel mess remains non-operative during official college vacations. The hostel accommodation fee does not include mess charges, which must be settled directly with the authorized contractor.
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 3: FEES STRUCTURE -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane" id="feesTab">
            <div class="hostel-sec-header">
                <span class="hostel-sec-kicker">ACCOMMODATION TARIFF</span>
                <h2 class="hostel-sec-title">Hostel Fees Structure &amp; Regulations</h2>
            </div>

            <div class="hostel-bullet-card">
                <ul class="hostel-bullet-list">
                    <?php foreach ($feePoints as $pt): ?>
                        <?php if (!empty(trim($pt))): ?>
                            <li class="hostel-bullet-item">
                                <i class="fas fa-info-circle hostel-bullet-icon"></i>
                                <span><?= htmlspecialchars(trim($pt)) ?></span>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="hostel-table-wrap" style="max-width: 800px;">
                <table class="hostel-table">
                    <thead>
                        <tr>
                            <th style="width: 50%;">Academic Year / Term</th>
                            <th style="width: 50%;">Hostel Fees (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feesStructure as $f): ?>
                            <tr>
                                <td style="font-weight: 600; color: var(--hostel-primary);"><?= htmlspecialchars($f['year_name']) ?></td>
                                <td style="font-weight: 700; color: var(--hostel-accent);">₹<?= htmlspecialchars($f['hostel_fees']) ?>/-</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 4: HOSTEL RULES -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane" id="rulesTab">
            <div class="hostel-sec-header">
                <span class="hostel-sec-kicker">CODE OF CONDUCT &amp; COMPLIANCE</span>
                <h2 class="hostel-sec-title">Hostel Rules &amp; Regulations</h2>
            </div>

            <div class="hostel-rules-callout">
                <div class="hostel-rules-info">
                    <h3 class="hostel-rules-title">Official Hostel Code of Conduct Document</h3>
                    <p class="hostel-rules-desc">
                        All resident students are strictly required to adhere to the institutional discipline policies, anti-ragging mandates, entry-exit timings, and campus code of conduct issued by the Directorate of Technical Education and Government Engineering College, Modasa.
                    </p>
                </div>
                <div>
                    <?php 
                    $rulesPdfPath = !empty($rulesPdf) ? (__DIR__ . '/../' . ltrim($rulesPdf, '/')) : '';
                    if (!empty($rulesPdf) && file_exists($rulesPdfPath)): 
                    ?>
                        <a href="<?= htmlspecialchars($root_path . ltrim($rulesPdf, '/')) ?>" target="_blank" rel="noopener noreferrer" class="hostel-rules-btn">
                            <i class="fas fa-file-pdf"></i> Download Hostel Rules (PDF)
                        </a>
                    <?php else: ?>
                        <span class="hostel-rules-btn" style="opacity: 0.7; cursor: default; background: #64748b;">
                            <i class="fas fa-info-circle"></i> Document Under Revision
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 5: HOSTEL BLOCK CAPACITY -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane" id="capacityTab">
            <div class="hostel-sec-header">
                <span class="hostel-sec-kicker">INFRASTRUCTURE AUDIT</span>
                <h2 class="hostel-sec-title">Hostel Block Wise Capacity Details</h2>
            </div>

            <div class="hostel-table-wrap">
                <table class="hostel-table">
                    <thead>
                        <tr>
                            <th style="width: 12%; text-align: center;">Sr. No.</th>
                            <th style="width: 25%;">Block Name</th>
                            <th style="width: 25%;">Number of Floors</th>
                            <th style="width: 18%; text-align: center;">Total Rooms</th>
                            <th style="width: 20%; text-align: center;">Student Capacity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sumRooms = 0;
                        $sumStudents = 0;
                        foreach ($blockCapacity as $b): 
                            $sumRooms += (int)$b['total_rooms'];
                            $sumStudents += (int)$b['number_of_students'];
                        ?>
                            <tr>
                                <td style="text-align: center; color: var(--hostel-muted);"><?= (int)$b['sr_no'] ?></td>
                                <td>
                                    <span class="hostel-badge">Block <?= htmlspecialchars($b['block_name']) ?></span>
                                </td>
                                <td><?= htmlspecialchars($b['number_of_floor']) ?></td>
                                <td style="text-align: center; font-weight: 600;"><?= (int)$b['total_rooms'] ?></td>
                                <td style="text-align: center; font-weight: 700; color: var(--hostel-primary);"><?= (int)$b['number_of_students'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr style="font-weight: 800; background-color: var(--hostel-bg-subtle);">
                            <td colspan="3" style="text-align: right; text-transform: uppercase; font-size: 0.82rem; letter-spacing: 0.05em; color: var(--hostel-primary);">
                                Consolidated Campus Total
                            </td>
                            <td style="text-align: center; font-size: 1rem; color: var(--hostel-primary);"><?= $sumRooms ?> Rooms</td>
                            <td style="text-align: center; font-size: 1rem; color: var(--hostel-accent);"><?= $sumStudents ?> Students</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 6: PHOTOS GALLERY -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane" id="photosTab">
            <div class="hostel-sec-header">
                <span class="hostel-sec-kicker">CAMPUS LIFE &amp; LIVING</span>
                <h2 class="hostel-sec-title">Hostel &amp; Residential Gallery</h2>
            </div>

            <div class="hostel-photo-grid">
                <?php foreach ($photos as $ph): ?>
                    <div class="hostel-photo-card">
                        <div class="hostel-photo-thumb-wrap">
                            <img src="<?= htmlspecialchars($root_path . ltrim($ph['image_path'], '/')) ?>" alt="<?= htmlspecialchars($ph['caption']) ?>" class="hostel-photo-thumb" onerror="this.src='<?= $root_path ?>images/hero_campus_1.jpg'">
                        </div>
                        <div class="hostel-photo-caption">
                            <?= htmlspecialchars($ph['caption']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </main>
</div>

<script>
// Interactive Tab Switching Script with History Hash & Global Mobile Drawer Support
window.activateTab = function(tabName, shouldScroll) {
    const cleanKey = tabName.replace('Tab', '').toLowerCase();
    const targetId = cleanKey + 'Tab';

    // 1. Update subnav buttons
    document.querySelectorAll('.dept-subnav-item').forEach(item => {
        const btn = item.querySelector('.dept-subnav-link');
        const tabAttr = btn ? btn.getAttribute('data-tab') : '';
        if (tabAttr === cleanKey) {
            item.classList.add('active');
            btn?.classList.add('active');
            btn?.setAttribute('aria-selected', 'true');
        } else {
            item.classList.remove('active');
            btn?.classList.remove('active');
            btn?.setAttribute('aria-selected', 'false');
        }
    });

    // 2. Update tab panes
    document.querySelectorAll('.hostel-tab-pane').forEach(pane => {
        const paneId = pane.getAttribute('id');
        if (paneId === targetId || paneId === cleanKey) {
            pane.classList.add('active');
        } else {
            pane.classList.remove('active');
        }
    });

    // 3. Update hash
    if (history.replaceState) {
        history.replaceState(null, null, '#' + cleanKey);
    } else {
        window.location.hash = cleanKey;
    }

    // 4. Update data-active-tab on .hostel-page and body
    const page = document.querySelector('.hostel-page') || document.body;
    page.setAttribute('data-active-tab', cleanKey);
    document.body.setAttribute('data-active-tab', cleanKey);

    // 5. Ensure smooth scroll alignment if user clicked a tab while scrolled down
    if (shouldScroll) {
        const subnav = document.querySelector('.dept-subnav-bar');
        if (subnav && window.pageYOffset > (subnav.offsetTop + 40)) {
            const targetY = subnav.offsetTop - 10;
            window.scrollTo({ top: Math.max(0, targetY), behavior: 'smooth' });
        }
    }
};

document.addEventListener('DOMContentLoaded', function () {
    // Bind click events on desktop subnav buttons
    document.querySelectorAll('.dept-subnav-link').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const tab = this.getAttribute('data-tab');
            if (tab) {
                window.activateTab(tab, true);
            }
        });
    });

    // Check URL hash on page load
    const hash = window.location.hash.replace('#', '').toLowerCase();
    const validTabs = ['about', 'mess', 'fees', 'rules', 'capacity', 'photos'];
    if (hash && validTabs.includes(hash)) {
        window.activateTab(hash, false);
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
