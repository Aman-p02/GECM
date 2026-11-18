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
$wardenStaff = $defaultWardenStaff;
$workStaff = $defaultWorkStaff;
$blockCapacity = $defaultBlockCapacity;
$feesStructure = $defaultFeesStructure;
$messPoints = $defaultMessNotes;
$feePoints = $defaultFeeNotes;
$photos = [
    ['caption' => 'GEC Modasa - Main Hostel Building', 'image_path' => 'uploads/hostel/hostel_main.jpg'],
    ['caption' => 'Hostel Campus & Residential Lawn', 'image_path' => 'uploads/hostel/hostel_campus.jpg']
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

$rulesPdf = !empty($hostelData['rules_pdf_url']) ? $hostelData['rules_pdf_url'] : 'uploads/hostel/hostel_rules_and_regulations.pdf';
?>

<div class="hostel-page" id="mainContent">
    <div class="hostel-container">

        <!-- Department-Style Hero Banner -->
        <header class="hostel-hero-banner">
            <div class="hostel-breadcrumbs">
                <a href="<?= $root_path ?>"><i class="fas fa-home"></i></a>
                <span class="sep">/</span>
                <a href="<?= $root_path ?>administration/principal">Administration</a>
                <span class="sep">/</span>
                <span class="current">Hostel &amp; Mess Facility</span>
            </div>

            <span class="hostel-kicker">CAMPUS AMENITIES &amp; RESIDENTIAL LIFE</span>
            <h1 class="hostel-heading">Hostel &amp; Mess Facility</h1>
            <p class="hostel-tagline">
                Comfortable, disciplined, and secure on-campus residential accommodation fostering academic focus, holistic personal development, and an inclusive student community across campus blocks.
            </p>
        </header>

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

        <!-- Clean Department-Grade Navigation Tabs -->
        <nav class="hostel-tabs-nav" aria-label="Hostel Sections">
            <button type="button" class="hostel-tab-btn active" data-target="aboutTab">About</button>
            <button type="button" class="hostel-tab-btn" data-target="messTab">Hostel Mess</button>
            <button type="button" class="hostel-tab-btn" data-target="feesTab">Fees Structure</button>
            <button type="button" class="hostel-tab-btn" data-target="rulesTab">Hostel Rules</button>
            <button type="button" class="hostel-tab-btn" data-target="capacityTab">Hostel Block Capacity</button>
            <button type="button" class="hostel-tab-btn" data-target="photosTab">Photos</button>
        </nav>

        <!-- ========================================================================= -->
        <!-- TAB 1: ABOUT (Overview, Committees, Leadership, Common Room & Staff Table) -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane active" id="aboutTab">

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

            <div class="hostel-gov-grid">
                <!-- Card 1: Hostel Management Committee -->
                <div class="hostel-gov-card">
                    <h3 class="hostel-gov-card-title">
                        <i class="fas fa-users-cog"></i> Hostel Management Committee
                    </h3>
                    <p style="font-size: 0.88rem; color: var(--hostel-muted); margin: 0 0 14px;">The following officers constitute the Hostel Management:</p>
                    <ul class="hostel-gov-list">
                        <li class="hostel-gov-item">
                            <span class="hostel-gov-item-num">1</span>
                            <span class="hostel-gov-item-text"><span class="hostel-gov-item-label">Principal</span> (Patron &amp; Head of Institute)</span>
                        </li>
                        <li class="hostel-gov-item">
                            <span class="hostel-gov-item-num">2</span>
                            <span class="hostel-gov-item-text"><span class="hostel-gov-item-label">Rector and / or Assistant Rector</span></span>
                        </li>
                        <li class="hostel-gov-item">
                            <span class="hostel-gov-item-num">3</span>
                            <span class="hostel-gov-item-text"><span class="hostel-gov-item-label">Wardens</span></span>
                        </li>
                        <li class="hostel-gov-item">
                            <span class="hostel-gov-item-num">4</span>
                            <span class="hostel-gov-item-text"><span class="hostel-gov-item-label">Care Takers</span></span>
                        </li>
                        <li class="hostel-gov-item">
                            <span class="hostel-gov-item-num">5</span>
                            <span class="hostel-gov-item-text"><span class="hostel-gov-item-label">Administrative Staff</span></span>
                        </li>
                    </ul>
                </div>

                <!-- Card 2: Institute Disciplinary Committee -->
                <div class="hostel-gov-card">
                    <h3 class="hostel-gov-card-title">
                        <i class="fas fa-balance-scale"></i> Institute Disciplinary Committee
                    </h3>
                    <p style="font-size: 0.88rem; color: var(--hostel-muted); margin: 0 0 14px;">The following officers constitute the Institute Disciplinary Committee:</p>
                    <ul class="hostel-gov-list">
                        <li class="hostel-gov-item">
                            <span class="hostel-gov-item-num">1</span>
                            <span class="hostel-gov-item-text"><span class="hostel-gov-item-label">Principal</span> (Chairman)</span>
                        </li>
                        <li class="hostel-gov-item">
                            <span class="hostel-gov-item-num">2</span>
                            <span class="hostel-gov-item-text"><span class="hostel-gov-item-label">All Heads of the Departments</span></span>
                        </li>
                        <li class="hostel-gov-item">
                            <span class="hostel-gov-item-num">3</span>
                            <span class="hostel-gov-item-text"><span class="hostel-gov-item-label">Rector and / or Assistant Rector</span></span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- 3. Key Leadership & Common Room Highlight Strip -->
            <div class="hostel-exec-strip">
                <!-- Rector & Assistant Rectors Box -->
                <div class="hostel-exec-box">
                    <div class="hostel-exec-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="hostel-exec-content">
                        <div class="hostel-exec-label">Hostel Leadership</div>
                        <div class="hostel-exec-name">Prof. (Dr.) U. V. Shah</div>
                        <div class="hostel-exec-sub"><strong>Rector</strong> (Professor &amp; Head, Mechanical Engineering Dept.)</div>
                        <div class="hostel-exec-sub" style="margin-top: 6px; padding-top: 6px; border-top: 1px dashed var(--hostel-border);">
                            <strong>Assistant Rector(s):</strong><br>
                            &bull; Prof. P. R. Gamit (Assistant Prof., Computer Engineering Dept.)<br>
                            &bull; Prof. P. V. Patel (Assistant Prof., EC Engineering Dept.)
                        </div>
                    </div>
                </div>

                <!-- Girl's Common Room Facility Box -->
                <div class="hostel-exec-box">
                    <div class="hostel-exec-icon">
                        <i class="fas fa-female"></i>
                    </div>
                    <div class="hostel-exec-content">
                        <div class="hostel-exec-label">Campus Amenities</div>
                        <div class="hostel-exec-name">Girl's Common Room Facility</div>
                        <div class="hostel-exec-sub" style="margin-top: 4px;">
                            <strong>1. Electrical Department:</strong> Room No. 7102<br>
                            <strong>2. Girl's Hostel (Emergency Case):</strong> Recreation Hall
                        </div>
                        <div class="hostel-exec-sub" style="margin-top: 8px; font-size: 0.82rem; color: var(--hostel-muted);">
                            Dedicated hygienic rest, study, and recreation spaces designated for female students across academic hours.
                        </div>
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
                        <?php 
                        $wardenCount = count($wardenStaff);
                        $first = true;
                        foreach ($wardenStaff as $w): 
                        ?>
                            <tr>
                                <?php if ($first): ?>
                                    <td rowspan="<?= $wardenCount ?>" style="font-weight: 700; color: var(--hostel-primary); vertical-align: top; background: #ffffff;">
                                        <?= htmlspecialchars($w['work_description']) ?>
                                    </td>
                                    <?php $first = false; ?>
                                <?php endif; ?>
                                <td style="text-align: center;">
                                    <span class="hostel-badge"><?= htmlspecialchars($w['block_name']) ?></span>
                                </td>
                                <td style="font-weight: 500; color: var(--hostel-primary);">
                                    <?= nl2br(htmlspecialchars($w['warden'])) ?>
                                </td>
                                <td>
                                    <?= !empty($w['care_taker']) ? nl2br(htmlspecialchars($w['care_taker'])) : '<span style="color: #94a3b8;">&mdash;</span>' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <!-- Technical & Works Section (Civil, Electrical, Administrative) -->
                        <?php foreach ($workStaff as $ws): ?>
                            <tr>
                                <td style="font-weight: 700; color: var(--hostel-primary);">
                                    <?= htmlspecialchars($ws['work_description']) ?>
                                </td>
                                <td colspan="3" style="font-weight: 500; color: var(--hostel-primary);">
                                    <?= htmlspecialchars($ws['staff_incharge'] ?? $ws['warden']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- ========================================================================= -->
        <!-- TAB 2: HOSTEL MESS -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane" id="messTab">
            <div class="hostel-sec-header">
                <span class="hostel-sec-kicker">CAMPUS DINING</span>
                <h2 class="hostel-sec-title">Hostel Mess Facility &amp; Operational Guidelines</h2>
            </div>

            <div class="hostel-bullet-card">
                <ul class="hostel-bullet-list">
                    <?php foreach ($messPoints as $pt): ?>
                        <?php if (!empty(trim($pt))): ?>
                            <li class="hostel-bullet-item">
                                <i class="fas fa-check-circle hostel-bullet-icon"></i>
                                <span><?= htmlspecialchars(trim($pt)) ?></span>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
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
                    <a href="<?= htmlspecialchars($root_path . ltrim($rulesPdf, '/')) ?>" target="_blank" rel="noopener noreferrer" class="hostel-rules-btn">
                        <i class="fas fa-file-pdf"></i> Download Hostel Rules (PDF)
                    </a>
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

    </div>
</div>

<script>
// Interactive Tab Switching Script with History Hash Support
document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.hostel-tab-btn');
    const tabPanes = document.querySelectorAll('.hostel-tab-pane');

    function activateTab(targetId) {
        tabButtons.forEach(btn => {
            if (btn.getAttribute('data-target') === targetId) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        tabPanes.forEach(pane => {
            if (pane.getAttribute('id') === targetId) {
                pane.classList.add('active');
            } else {
                pane.classList.remove('active');
            }
        });
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            activateTab(targetId);
            const hashKey = targetId.replace('Tab', '').toLowerCase();
            if (history.replaceState) {
                history.replaceState(null, null, '#' + hashKey);
            } else {
                window.location.hash = hashKey;
            }
        });
    });

    // Check URL hash on page load
    const hash = window.location.hash.replace('#', '').toLowerCase();
    const map = {
        'about': 'aboutTab',
        'mess': 'messTab',
        'fees': 'feesTab',
        'rules': 'rulesTab',
        'capacity': 'capacityTab',
        'photos': 'photosTab'
    };

    if (hash && map[hash]) {
        activateTab(map[hash]);
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
