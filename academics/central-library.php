<?php
/**
 * GEC MODASA - CENTRAL LIBRARY
 * Learning Resource Centre (LRC)
 * Follows GECM Institutional Department Design Language (100% Match)
 */
$page_title = "Central Library (LRC) | Government Engineering College, Modasa";
$active_page = "central-library";
$root_path = "../";
$extra_css = "css/central-library.css";

require_once __DIR__ . '/../includes/db.php';
$pdo = getDBConnection();

// Default Fallback Collections Data (Institutional Archive)
$defaultCatalogues = [
    ['dept_name' => 'Mechanical & Automobile Engineering', 'subtext' => 'Thermodynamics, Manufacturing, Automobile Systems, Machine Design', 'titles_count' => '1,110', 'volume_count' => '4,811', 'file_path' => null],
    ['dept_name' => 'Civil Engineering & Applied Mechanics', 'subtext' => 'Structural Analysis, Surveying, Geotechnical, Fluid Mechanics, Concrete', 'titles_count' => '1,457', 'volume_count' => '3,873', 'file_path' => null],
    ['dept_name' => 'Computer Engineering & Information Technology', 'subtext' => 'Algorithms, Operating Systems, Database, AI/ML, Networks, Cyber Security', 'titles_count' => '1,476', 'volume_count' => '5,178', 'file_path' => null],
    ['dept_name' => 'Electrical Engineering', 'subtext' => 'Electrical Machines, Power Systems, Control Systems, High Voltage', 'titles_count' => '668', 'volume_count' => '2,312', 'file_path' => null],
    ['dept_name' => 'Electronics & Communication Engineering', 'subtext' => 'Digital Communication, VLSI Design, Embedded Systems, Signal Processing', 'titles_count' => '1,347', 'volume_count' => '4,186', 'file_path' => null],
    ['dept_name' => 'General Sciences & Humanities', 'subtext' => 'Engineering Mathematics, Physics, Chemistry, Professional English, Ethics', 'titles_count' => '901', 'volume_count' => '2,163', 'file_path' => null],
    ['dept_name' => 'RUSA Section', 'subtext' => 'Rashtriya Uchchatar Shiksha Abhiyan Special Grant Volumes & Reference', 'titles_count' => '201', 'volume_count' => '290', 'file_path' => null],
    ['dept_name' => 'Bureau of Indian Standards (IS Code)', 'subtext' => 'National Engineering Specifications, Testing Standards, Codes of Practice', 'titles_count' => '1,818', 'volume_count' => '2,049', 'file_path' => null]
];

$catalogues = $defaultCatalogues;
if ($pdo) {
    try {
        $stmtCats = $pdo->query("SELECT * FROM library_catalogues WHERE is_active = 1 ORDER BY display_order ASC, id ASC");
        $fetchedCats = $stmtCats->fetchAll();
        if (!empty($fetchedCats)) {
            $catalogues = $fetchedCats;
        }
    } catch (Exception $e) {
        // Fallback to default array
    }
}

// Default Fallback Committee & Staff Data
$defaultCommittee = [
    ['name' => 'Prof. Nirali V. Upadhyay', 'department_info' => 'Assistant Professor, Electrical Engineering (AP.EE)', 'designation' => 'Library Incharge', 'badge_class' => 'dept-tag-incharge'],
    ['name' => 'Prof. Kunal V. Fadadu', 'department_info' => 'Assistant Professor, Automobile Engineering (AP.AT)', 'designation' => 'Assistant Library Incharge', 'badge_class' => 'dept-tag-asst'],
    ['name' => 'Prof. A. B. Parmar', 'department_info' => 'Assistant Professor, Computer Engineering (AP.CE)', 'designation' => 'Member', 'badge_class' => 'dept-tag-ug'],
    ['name' => 'Prof. N. S. Chowdhary', 'department_info' => 'Assistant Professor, Computer Engineering (AP.CE)', 'designation' => 'Member', 'badge_class' => 'dept-tag-ug'],
    ['name' => 'Prof. R. N. Vaza', 'department_info' => 'Assistant Professor, Computer Engineering (AP.CE)', 'designation' => 'Member', 'badge_class' => 'dept-tag-ug'],
    ['name' => 'Prof. C. K. Baria', 'department_info' => 'Assistant Professor, Electrical Engineering (AP.EE)', 'designation' => 'Member', 'badge_class' => 'dept-tag-ug']
];

$defaultStaff = [
    ['name' => 'Shri A. M. Patel', 'department_info' => 'Learning Resource Centre (LRC)', 'designation' => 'In-charge (Librarian)', 'badge_class' => 'dept-tag-librarian'],
    ['name' => 'Shri J. N. Patel', 'department_info' => 'Electronics & Communication Engineering (EC)', 'designation' => 'Member', 'badge_class' => 'dept-tag-ug']
];

$committeeMembers = $defaultCommittee;
$staffMembers = $defaultStaff;

if ($pdo) {
    try {
        $stmtComm = $pdo->query("SELECT * FROM library_team WHERE team_type = 'committee' AND is_active = 1 ORDER BY display_order ASC, id ASC");
        $fetchedComm = $stmtComm->fetchAll();
        if (!empty($fetchedComm)) {
            $committeeMembers = $fetchedComm;
        }

        $stmtStf = $pdo->query("SELECT * FROM library_team WHERE team_type = 'staff' AND is_active = 1 ORDER BY display_order ASC, id ASC");
        $fetchedStf = $stmtStf->fetchAll();
        if (!empty($fetchedStf)) {
            $staffMembers = $fetchedStf;
        }
    } catch (Exception $e) {
        // Fallback to default array
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="dept-page" id="mainContent">

    <!-- Sticky sub-navigation bar matching Main Navbar -->
    <nav class="lib-subnav-bar" id="libSubNav" aria-label="Library Navigation">
        <div class="lib-nav-inner">
            <ul class="lib-nav-list" id="libNavLinks" role="tablist">

                <!-- Library Details Dropdown Trigger -->
                <li class="lib-nav-item lib-nav-dropdown active">
                    <button type="button" class="lib-nav-link active" data-tab="details" role="tab" aria-selected="true" aria-haspopup="true" aria-expanded="false" id="libDetailsTab">
                        <span class="lib-nav-text">Library Details</span>
                        <i class="fas fa-chevron-down lib-arrow"></i>
                    </button>
                </li>

                <!-- Library In-charge -->
                <li class="lib-nav-item">
                    <button type="button" class="lib-nav-link" data-tab="incharge" role="tab" aria-selected="false">
                        <span class="lib-nav-text">Library In-charge</span>
                    </button>
                </li>

                <!-- Library at a glance -->
                <li class="lib-nav-item">
                    <button type="button" class="lib-nav-link" data-tab="gallery" role="tab" aria-selected="false">
                        <span class="lib-nav-text">Library at a glance</span>
                    </button>
                </li>
            </ul>

            <!-- Dropdown Menu placed outside <ul> so overflow-x never clips it -->
            <div class="lib-dropdown" id="libDetailsMenu" role="menu" aria-label="Library Details Subsections">
                <ul class="lib-dd-list">
                    <li><button type="button" class="lib-dd-link active" data-subtab="overview" role="menuitem">Overview &amp; Infrastructure</button></li>
                    <li><button type="button" class="lib-dd-link" data-subtab="volumes" role="menuitem">Book Collection &amp; Volumes</button></li>
                    <li><button type="button" class="lib-dd-link" data-subtab="digital" role="menuitem">Digital Library &amp; E-Resources</button></li>
                    <li><button type="button" class="lib-dd-link" data-subtab="membership" role="menuitem">Membership &amp; Guidelines</button></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Panes -->
    <main class="dept-main-content">
        <div class="dept-container">

            <!-- TAB 1: LIBRARY DETAILS (CONSOLIDATED) -->
            <section class="dept-tab-pane active" id="tab-details">

                <!-- SUB-PANE 1: OVERVIEW & INFRASTRUCTURE -->
                <div class="lib-subpane active" id="subpane-overview">

                    <!-- Hero Section (Two-Column Department Layout) -->
                    <div class="dept-about-hero" style="margin-bottom: 56px;">
                        <div class="dept-hero-grid">
                            <div class="dept-hero-text">
                                <span class="dept-kicker">LEARNING RESOURCE CENTRE (LRC)</span>
                                <h1 class="dept-heading">Central Library</h1>
                                <p class="dept-tagline">
                                    The central information hub supporting technical education, academic research, and intellectual scholarship at Government Engineering College, Modasa. Serving as a collaborative space for faculty, researchers, and students across all disciplines.
                                </p>
                            </div>
                            <div class="dept-hero-media">
                                <img src="<?= $root_path ?>images/library/library_reading_room.jpg" alt="Government Engineering College Modasa Central Library Reading Room" class="dept-hero-photo">
                            </div>
                        </div>

                        <!-- Key metrics counter strip -->
                        <div class="dept-stats-strip">
                            <div class="dept-stat-item">
                                <span class="dept-stat-num">24,862+</span>
                                <span class="dept-stat-label">TOTAL BOOK VOLUMES</span>
                            </div>
                            <div class="dept-stat-item">
                                <span class="dept-stat-num">8,978+</span>
                                <span class="dept-stat-label">SPECIALIZED TITLES</span>
                            </div>
                            <div class="dept-stat-item">
                                <span class="dept-stat-num">100</span>
                                <span class="dept-stat-label">READING ROOM SEATS</span>
                            </div>
                            <div class="dept-stat-item">
                                <span class="dept-stat-num">100 MBPS</span>
                                <span class="dept-stat-label">HIGH-SPEED NKN &amp; WI-FI</span>
                            </div>
                        </div>
                    </div>

                    <div class="dept-section-header">
                        <span class="dept-section-kicker">ABOUT THE LIBRARY</span>
                        <h2>Learning Resource Centre (LRC)</h2>
                        <p>Fostering academic excellence through vast print resources, state-of-the-art digital infrastructure, and a peaceful study environment.</p>
                    </div>

                <div class="dept-story-body">
                    <blockquote class="dept-lead-quote">
                        "The Central Library of the institute is the hub for information services, gathering place for faculties and students of diversified technological areas, and also serves as a major learning and resource centre. It is a creative and innovative partner in supporting teaching, learning, scholarship, and research activities."
                    </blockquote>
                    <p>
                        The Central Library is situated in the dedicated <strong>Learning Resource Centre (LRC) Building</strong>. The facility is carefully planned to accommodate diverse academic needs, housing the Librarian Cabin, book circulation desk, newspaper reading space, reference literature, digital computing terminals, and expansive periodicals display racks.
                    </p>
                </div>

                <!-- LRC Key Zones Grid -->
                <div class="lib-zones-grid">
                    <div class="lib-zone-card">
                        <div class="lib-zone-icon"><i class="fas fa-book-reader"></i></div>
                        <h3 class="lib-zone-title">Spacious Reading Hall</h3>
                        <p class="lib-zone-desc">Dedicated seating for 100 students in a peaceful, well-illuminated and ventilated atmosphere fostering deep study.</p>
                    </div>
                    <div class="lib-zone-card">
                        <div class="lib-zone-icon"><i class="fas fa-laptop-code"></i></div>
                        <h3 class="lib-zone-title">Digital Library Suite</h3>
                        <p class="lib-zone-desc">10 high-speed multimedia desktop terminals with NKN 100 Mbps internet for online journals and thesis research.</p>
                    </div>
                    <div class="lib-zone-card">
                        <div class="lib-zone-icon"><i class="fas fa-barcode"></i></div>
                        <h3 class="lib-zone-title">Automated Circulation</h3>
                        <p class="lib-zone-desc">Powered by SOUL 3.0 software and complete barcode tagging for quick book issuing, return, and catalog queries.</p>
                    </div>
                    <div class="lib-zone-card">
                        <div class="lib-zone-icon"><i class="fas fa-newspaper"></i></div>
                        <h3 class="lib-zone-title">Periodicals &amp; Dailies</h3>
                        <p class="lib-zone-desc">Display racks featuring national dailies, general magazines, research bulletins, and archival bound journals.</p>
                    </div>
                    <div class="lib-zone-card">
                        <div class="lib-zone-icon"><i class="fas fa-bookmark"></i></div>
                        <h3 class="lib-zone-title">Reference Section</h3>
                        <p class="lib-zone-desc">Authoritative encyclopedias, handbooks, Bureau of Indian Standards (IS Codes), and competitive literature.</p>
                    </div>
                    <div class="lib-zone-card">
                        <div class="lib-zone-icon"><i class="fas fa-wifi"></i></div>
                        <h3 class="lib-zone-title">Campus Wi-Fi</h3>
                        <p class="lib-zone-desc">High-speed National Knowledge Network (NKN) Wi-Fi coverage across the entire reading area for student devices.</p>
                    </div>
                </div>

                <!-- Library Information Table -->
                <div class="dept-section-header" style="margin-top: 20px;">
                    <span class="dept-section-kicker">INFRASTRUCTURE SPECIFICATIONS</span>
                    <h2>Key Facility Matrix</h2>
                    <p>Official physical dimensions, network capacity, and infrastructure details of the Learning Resource Centre.</p>
                </div>

                <div class="dept-table-wrap">
                    <table class="dept-clean-table">
                        <thead>
                            <tr>
                                <th style="width: 45%;">Facility Parameter</th>
                                <th style="width: 55%;">Specification / Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Total Library Carpet Area</strong></td>
                                <td>293.27 sq. meters</td>
                            </tr>
                            <tr>
                                <td><strong>Total Dedicated Reading Area</strong></td>
                                <td>116.09 sq. meters</td>
                            </tr>
                            <tr>
                                <td><strong>Seating Capacity in Reading Space</strong></td>
                                <td>100 Student Seats (Ergonomic seating with natural illumination)</td>
                            </tr>
                            <tr>
                                <td><strong>Library Networking &amp; Internet Facility</strong></td>
                                <td>Yes — High-Speed National Knowledge Network (NKN) 100 Mbps Local LAN &amp; Campus Wi-Fi</td>
                            </tr>
                            <tr>
                                <td><strong>Integrated Library Management System</strong></td>
                                <td>SOUL 3.0 (INFLIBNET Centre) with Barcode Reader Technology</td>
                            </tr>
                            <tr>
                                <td><strong>Location on Campus</strong></td>
                                <td>LRC Building, Government Engineering College, Modasa</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> <!-- /subpane-overview -->

            <!-- SUB-PANE 2: BOOK COLLECTION & VOLUMES -->
            <div class="lib-subpane" id="subpane-volumes">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">COMPREHENSIVE REPOSITORY</span>
                    <h2>Departmental Book Matrix &amp; Volumes</h2>
                    <p>
                        The library collection encompasses over <strong>24,862 books across 8,978 titles</strong> covering all major Engineering disciplines, Applied Sciences, Management, Humanities, and National Standard Codes.
                    </p>
                </div>

                <div class="dept-table-wrap">
                    <table class="dept-clean-table">
                        <thead>
                            <tr>
                                <th style="width: 40%;">Course(s) / Department</th>
                                <th style="width: 20%; text-align: center;">No. of Titles</th>
                                <th style="width: 20%; text-align: center;">Total Volume</th>
                                <th style="width: 20%; text-align: center;">Catalogue Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($catalogues as $cat): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($cat['dept_name']) ?></strong>
                                        <?php if (!empty($cat['subtext'])): ?>
                                            <div style="font-size: 0.82rem; color: #6b7280; margin-top: 3px;"><?= htmlspecialchars($cat['subtext']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;" class="lib-vol-num"><?= htmlspecialchars($cat['titles_count']) ?></td>
                                    <td style="text-align: center;" class="lib-vol-num"><?= htmlspecialchars($cat['volume_count']) ?></td>
                                    <td style="text-align: center;">
                                        <?php if (!empty($cat['file_path'])): ?>
                                            <a href="<?= $root_path . htmlspecialchars(ltrim($cat['file_path'], '/')) ?>" target="_blank" download class="lib-btn-view" title="Download / View <?= htmlspecialchars($cat['dept_name']) ?> Catalogue Spreadsheet">
                                                <i class="fas fa-file-excel"></i> <span>View</span>
                                            </a>
                                        <?php else: ?>
                                            <span class="dept-tag-ug">Barcoded</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr style="background: #f8fafc; font-weight: 700;">
                                <td><strong>Total Institutional Collection</strong></td>
                                <td style="text-align: center;" class="lib-vol-num" style="color: var(--dept-accent); font-size: 1.1rem;">8,978 Titles</td>
                                <td style="text-align: center;" class="lib-vol-num" style="color: var(--dept-accent); font-size: 1.1rem;">24,862 Volumes</td>
                                <td style="text-align: center;"><span class="dept-tag-ug" style="background: #fff7ed; color: #c2410c;">Active Collection</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> <!-- /subpane-volumes -->

            <!-- SUB-PANE 3: DIGITAL LIBRARY & E-RESOURCES -->
            <div class="lib-subpane" id="subpane-digital">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">ELECTRONIC ACCESS &amp; NETWORKING</span>
                    <h2>Digital Library &amp; National Portals</h2>
                    <p>Facilitating seamless 24x7 online access to top tier international journals, research repositories, and curriculum modules.</p>
                </div>

                <div class="dept-story-body">
                    <p>
                        The Digital Library section is equipped with <strong>10 dedicated high-performance desktop computers</strong> connected to the 100 Mbps NKN backbone. All physical library operations are digitized using <strong>SOUL 3.0 (Software for University Libraries)</strong> developed by INFLIBNET Centre, enabling automated OPAC search, barcode tracking, and user transaction management.
                    </p>
                </div>

                <!-- Digital Resources Cards Grid -->
                <div class="lib-eresources-grid">
                    <!-- Knimbus -->
                    <div class="lib-eresource-card">
                        <div class="lib-eresource-top">
                            <span class="lib-eresource-badge">GTU Consortia</span>
                            <h3 class="lib-eresource-title">Knimbus Digital Library &amp; E-Books</h3>
                            <p class="lib-eresource-desc">
                                Facilitated through Gujarat Technological University (GTU), providing access to premier e-resources including IEEE Knimbus Open eBooks, JSTOR, ScienceDirect, Springer, Taylor &amp; Francis, Cambridge University Press, Bloomsbury, and Knimbus Multimedia.
                            </p>
                        </div>
                        <a href="https://gtu.knimbus.com/" target="_blank" rel="noopener noreferrer" class="lib-eresource-action">
                            <span>Access Knimbus Portal</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- NDL -->
                    <div class="lib-eresource-card">
                        <div class="lib-eresource-top">
                            <span class="lib-eresource-badge">Ministry of Education</span>
                            <h3 class="lib-eresource-title">National Digital Library of India (NDLI)</h3>
                            <p class="lib-eresource-desc">
                                Developed under the National Mission on Education through ICT (NME-ICT). Provides access to millions of textbooks, research articles, video lectures, and simulation tools. Institutional members are assigned registered login access.
                            </p>
                        </div>
                        <a href="https://ndl.iitkgp.ac.in/" target="_blank" rel="noopener noreferrer" class="lib-eresource-action">
                            <span>Open NDL India Portal</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- ONOS -->
                    <div class="lib-eresource-card">
                        <div class="lib-eresource-top">
                            <span class="lib-eresource-badge">Government of India</span>
                            <h3 class="lib-eresource-title">ONOS (One Nation One Subscription)</h3>
                            <p class="lib-eresource-desc">
                                Centralized national subscription platform giving students, researchers, and faculty access to world-class academic journals and publications across technological disciplines from a single institutional interface.
                            </p>
                        </div>
                        <a href="https://www.onos.gov.in/ums/index" target="_blank" rel="noopener noreferrer" class="lib-eresource-action">
                            <span>Visit ONOS Gateway</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- e-PG Pathshala -->
                    <div class="lib-eresource-card">
                        <div class="lib-eresource-top">
                            <span class="lib-eresource-badge">UGC &amp; MHRD</span>
                            <h3 class="lib-eresource-title">e-PG Pathshala &amp; Open Courseware</h3>
                            <p class="lib-eresource-desc">
                                Open access gateway executed by the UGC featuring 22,000+ high-quality e-text modules and curriculum video lectures across postgraduate subjects. Open to all students without login barrier.
                            </p>
                        </div>
                        <a href="https://epgp.inflibnet.ac.in/" target="_blank" rel="noopener noreferrer" class="lib-eresource-action">
                            <span>Explore e-PG Pathshala</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Rashtriya e-Pustakalaya -->
                    <div class="lib-eresource-card">
                        <div class="lib-eresource-top">
                            <span class="lib-eresource-badge">National Initiative</span>
                            <h3 class="lib-eresource-title">Rashtriya e-Pustakalaya (ReP)</h3>
                            <p class="lib-eresource-desc">
                                Pioneering national digital reading initiative curated by the Ministry of Education, serving as an open repository of knowledge, academic literature, and inspirational reading materials across age groups.
                            </p>
                        </div>
                        <a href="https://rep.education.gov.in/" target="_blank" rel="noopener noreferrer" class="lib-eresource-action">
                            <span>Visit ReP Portal</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Sanskrit Daily & Periodicals -->
                    <div class="lib-eresource-card">
                        <div class="lib-eresource-top">
                            <span class="lib-eresource-badge">Daily Periodical</span>
                            <h3 class="lib-eresource-title">विश्वस्य वृत्तान्तः &amp; News Archive</h3>
                            <p class="lib-eresource-desc">
                                Digital subscription to the World's First Daily Sanskrit Newspaper (विश्वस्य वृत्तान्तः) alongside physical display racks for leading engineering magazines, national periodicals, and peer-reviewed journals.
                            </p>
                        </div>
                        <a href="https://chat.whatsapp.com/DrHAozau53qIwlKPJ4CEHn" target="_blank" rel="noopener noreferrer" class="lib-eresource-action">
                            <span>Join Sanskrit Newspaper Community</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div> <!-- /subpane-digital -->

            <!-- SUB-PANE 4: MEMBERSHIP & GUIDELINES -->
            <div class="lib-subpane" id="subpane-membership">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">RULES &amp; REGULATIONS</span>
                    <h2>Library Membership &amp; Access Policies</h2>
                    <p>General borrowing guidelines, card maintenance protocols, and admission conditions for all patrons.</p>
                </div>

                <div class="lib-rules-grid">
                    <div class="lib-rule-card">
                        <h3><i class="fas fa-id-card"></i> Free Membership Registration</h3>
                        <p>
                            All enrolled students (Undergraduate B.E. &amp; Postgraduate M.E.) and faculty members of the institute are entitled to library membership <strong>free of cost</strong>.
                        </p>
                        <p>
                            Borrowing privileges and access to physical/digital collections are granted upon formal enrollment, subject to compliance with institutional rules.
                        </p>
                    </div>

                    <div class="lib-rule-card">
                        <h3><i class="fas fa-shield-alt"></i> Care of Library Borrower Cards</h3>
                        <p>
                            Members are instructed to take special care in maintaining their library cards. Do not fold, alter, or deface any stamped entries on the card.
                        </p>
                        <p>
                            Borrower cards are strictly non-transferable. The registered member is held personally responsible for all materials borrowed against their card.
                        </p>
                    </div>

                    <div class="lib-rule-card">
                        <h3><i class="fas fa-exclamation-triangle"></i> Loss of Cards &amp; Duplication</h3>
                        <p>
                            Any loss of borrower card must be reported immediately in writing to the Librarian to prevent misuse.
                        </p>
                        <p>
                            A duplicate library card may be issued upon formal written application and compliance with the verification procedure defined by the college.
                        </p>
                    </div>

                    <div class="lib-rule-card">
                        <h3><i class="fas fa-user-check"></i> Entry &amp; Identity Verification</h3>
                        <p>
                            Students are strictly required to produce their authorized institutional <strong>Photo Identity Card</strong> upon entry to the Learning Resource Centre.
                        </p>
                        <p>
                            Silence must be observed inside the reading hall and digital laboratory at all times. Mobile phones must be kept on silent mode.
                        </p>
                    </div>
                </div>

                <!-- Operating Hours Banner -->
                <div class="lib-hours-strip">
                    <div>
                        <h4 class="lib-hours-title">Library Circulation &amp; Working Timings</h4>
                        <p class="lib-hours-subtitle">Open on all state working days throughout academic terms.</p>
                    </div>
                    <div class="lib-hours-badge">
                        <i class="far fa-clock"></i>
                        <span>11:00 AM – 5:00 PM (All Working Days)</span>
                    </div>
                </div>
            </div> <!-- /subpane-membership -->
        </section> <!-- /tab-details -->

        <!-- TAB 2: LIBRARY IN-CHARGE & STAFF -->
        <section class="dept-tab-pane" id="tab-incharge">
            <div class="dept-section-header">
                <span class="dept-section-kicker">INSTITUTIONAL GOVERNANCE</span>
                <h2>Library Committee &amp; Team</h2>
                <p>The College has a Central Library located in the Learning Resource Centre (LRC) building on the ground floor, governed by the faculty library committee and supported by professional staff.</p>
            </div>

            <!-- Table 1: Library Team (Faculty In-charges & Members) -->
            <div style="margin-bottom: 36px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                    <h3 style="font-family: var(--dept-font-display); font-size: 1.25rem; font-weight: 700; color: #111111; margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-users" style="color: var(--dept-accent); font-size: 1.1rem;"></i>
                        Library Committee (Faculty Team)
                    </h3>
                </div>

                <div class="dept-table-wrap">
                    <table class="dept-clean-table">
                        <thead>
                            <tr>
                                <th style="width: 10%; text-align: center;">Sr. No.</th>
                                <th style="width: 50%;">Faculty Name &amp; Academic Department</th>
                                <th style="width: 40%;">Designation / Role in Library</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($committeeMembers as $idx => $mem): ?>
                                <tr>
                                    <td style="text-align: center; color: #6b7280; font-weight: 600;"><?= $idx + 1 ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($mem['name']) ?></strong>
                                        <?php if (!empty($mem['department_info'])): ?>
                                            <div style="font-size: 0.84rem; color: #6b7280; margin-top: 2px;"><?= htmlspecialchars($mem['department_info']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="<?= htmlspecialchars($mem['badge_class'] ?? 'dept-tag-ug') ?>">
                                            <?= htmlspecialchars($mem['designation']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table 2: Library Staff -->
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px;">
                    <h3 style="font-family: var(--dept-font-display); font-size: 1.25rem; font-weight: 700; color: #111111; margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-id-badge" style="color: var(--dept-accent); font-size: 1.1rem;"></i>
                        Library Administrative &amp; Technical Staff
                    </h3>
                </div>

                <div class="dept-table-wrap">
                    <table class="dept-clean-table">
                        <thead>
                            <tr>
                                <th style="width: 10%; text-align: center;">Sr. No.</th>
                                <th style="width: 50%;">Staff Member Name</th>
                                <th style="width: 40%;">Designation / Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($staffMembers as $idx => $stf): ?>
                                <tr>
                                    <td style="text-align: center; color: #6b7280; font-weight: 600;"><?= $idx + 1 ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($stf['name']) ?></strong>
                                        <?php if (!empty($stf['department_info'])): ?>
                                            <div style="font-size: 0.84rem; color: #6b7280; margin-top: 2px;"><?= htmlspecialchars($stf['department_info']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="<?= htmlspecialchars($stf['badge_class'] ?? 'dept-tag-ug') ?>">
                                            <?= htmlspecialchars($stf['designation']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- TAB 3: LIBRARY AT A GLANCE (PHOTO GALLERY) -->
        <section class="dept-tab-pane" id="tab-gallery">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">INFRASTRUCTURE SHOWCASE</span>
                    <h2>Library at a Glance</h2>
                    <p>A visual walkthrough of the Learning Resource Centre (LRC) featuring our reading halls, digital laboratory, stack areas, and periodical sections.</p>
                </div>

                <div class="lib-gallery-grid">
                    <!-- Photo 1: Reading Room Wide -->
                    <div class="lib-gallery-card" data-img="<?= $root_path ?>images/library/gallery_reading_hall_wide.jpg" data-caption="Spacious Reading Hall" data-badge="Central Library">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_reading_hall_wide.jpg" alt="Central Library Reading Hall Wide Overview" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <h3 class="lib-gallery-title">Spacious Reading Hall</h3>
                        </div>
                    </div>

                    <!-- Photo 2: Reading Room Study Desks -->
                    <div class="lib-gallery-card" data-img="<?= $root_path ?>images/library/gallery_reading_hall_study.jpg" data-caption="Student Reading Desks" data-badge="Central Library">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_reading_hall_study.jpg" alt="Student Reading and Study Desks" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <h3 class="lib-gallery-title">Student Reading Desks</h3>
                        </div>
                    </div>

                    <!-- Photo 3: Digital Library Workstations -->
                    <div class="lib-gallery-card" data-img="<?= $root_path ?>images/library/gallery_digital_workstations.jpg" data-caption="Multimedia Workstations (Stations 6 &amp; 7)" data-badge="Digital Infrastructure">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_digital_workstations.jpg" alt="Digital Library Computing Terminals" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <h3 class="lib-gallery-title">Multimedia Workstations</h3>
                        </div>
                    </div>

                    <!-- Photo 4: Digital Research & E-Resources -->
                    <div class="lib-gallery-card" data-img="<?= $root_path ?>images/library/gallery_digital_research.jpg" data-caption="Online Journal &amp; Research Lab" data-badge="E-Resource Center">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_digital_research.jpg" alt="Students and Faculty Accessing E-Resources" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <h3 class="lib-gallery-title">Online Journal &amp; Research Lab</h3>
                        </div>
                    </div>

                    <!-- Photo 5: Periodicals & Journals Display -->
                    <div class="lib-gallery-card" data-img="<?= $root_path ?>images/library/gallery_periodicals_rack.jpg" data-caption="Technical Periodicals &amp; Magazines Display" data-badge="Periodicals Section">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_periodicals_rack.jpg" alt="Technical Periodicals and Journals Display Rack" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <h3 class="lib-gallery-title">Periodicals &amp; Magazine Display</h3>
                        </div>
                    </div>

                    <!-- Photo 6: Librarian Office & Cabin -->
                    <div class="lib-gallery-card" data-img="<?= $root_path ?>images/library/gallery_librarian_cabin.jpg" data-caption="Librarian Office Cabin (Room 3109-A)" data-badge="Administration">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_librarian_cabin.jpg" alt="Librarian Office Cabin Room 3109-A" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <h3 class="lib-gallery-title">Librarian Office (Room 3109-A)</h3>
                        </div>
                    </div>

                    <!-- Photo 7: Reference Reading Area & Corridor -->
                    <div class="lib-gallery-card" data-img="<?= $root_path ?>images/library/gallery_reference_section.jpg" data-caption="Reference Reading Area &amp; Study Desks" data-badge="Reference Section">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_reference_section.jpg" alt="Reference Section and Periodicals Corridor" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <h3 class="lib-gallery-title">Reference Reading Area</h3>
                        </div>
                    </div>

                    <!-- Photo 8: Main Book Storage Almirahs -->
                    <div class="lib-gallery-card" data-img="<?= $root_path ?>images/library/gallery_book_stacks_1.jpg" data-caption="Main Book Storage &amp; Glass-Door Almirahs" data-badge="Book Stacks">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_book_stacks_1.jpg" alt="Main Book Storage and Glass-Door Almirahs" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <h3 class="lib-gallery-title">Main Book Storage &amp; Almirahs</h3>
                        </div>
                    </div>

                    <!-- Photo 9: Book Stacks & Partition Corridor -->
                    <div class="lib-gallery-card" data-img="<?= $root_path ?>images/library/gallery_book_stacks_2.jpg" data-caption="Book Stacks &amp; Partition Aisles" data-badge="Circulation Aisles">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_book_stacks_2.jpg" alt="Book Stacks and Circulation Aisles" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <h3 class="lib-gallery-title">Book Stacks &amp; Partition Aisles</h3>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <!-- Lightbox Modal for Fullscreen Image Viewing -->
    <div class="lib-lightbox" id="libLightbox" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="lib-lightbox-backdrop" id="libLightboxBackdrop"></div>
        <div class="lib-lightbox-dialog">
            <button type="button" class="lib-lightbox-close" id="libLightboxClose" aria-label="Close Lightbox">&times;</button>
            <div class="lib-lightbox-media">
                <img src="" alt="" id="libLightboxImg">
            </div>
            <div class="lib-lightbox-info">
                <span class="lib-lightbox-badge" id="libLightboxBadge">Central Library</span>
                <p class="lib-lightbox-caption" id="libLightboxCaption"></p>
            </div>
        </div>
    </div>

        </div>
    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainSubnavLinks = document.querySelectorAll('.lib-nav-list .lib-nav-link');
    const mainSubnavItems = document.querySelectorAll('.lib-nav-list .lib-nav-item');
    const mainTabPanes = document.querySelectorAll('.dept-tab-pane');

    const detailsTab = document.getElementById('libDetailsTab');
    const dropdownMenu = document.getElementById('libDetailsMenu');
    const dropdownWrap = document.querySelector('.lib-nav-dropdown');
    const dropdownItems = document.querySelectorAll('.lib-dropdown .lib-dd-link');
    const libSubpanes = document.querySelectorAll('.lib-subpane');

    let hoverTimer;

    function openDropdown() {
        clearTimeout(hoverTimer);
        if (dropdownMenu) dropdownMenu.classList.add('show');
        if (dropdownWrap) dropdownWrap.classList.add('open');
        if (detailsTab) detailsTab.setAttribute('aria-expanded', 'true');
    }

    function closeDropdown(immediate) {
        clearTimeout(hoverTimer);
        if (immediate) {
            if (dropdownMenu) dropdownMenu.classList.remove('show');
            if (dropdownWrap) dropdownWrap.classList.remove('open');
            if (detailsTab) detailsTab.setAttribute('aria-expanded', 'false');
        } else {
            hoverTimer = setTimeout(function () {
                if (dropdownMenu) dropdownMenu.classList.remove('show');
                if (dropdownWrap) dropdownWrap.classList.remove('open');
                if (detailsTab) detailsTab.setAttribute('aria-expanded', 'false');
            }, 220);
        }
    }

    // Desktop hover handling (only for devices with true mouse hover support)
    const hasFineHover = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    if (hasFineHover && dropdownWrap && dropdownMenu) {
        dropdownWrap.addEventListener('mouseenter', openDropdown);
        dropdownWrap.addEventListener('mouseleave', function () { closeDropdown(false); });
        dropdownMenu.addEventListener('mouseenter', openDropdown);
        dropdownMenu.addEventListener('mouseleave', function () { closeDropdown(false); });

        // Hovering other top tabs closes the dropdown immediately
        mainSubnavLinks.forEach(btn => {
            if (btn.getAttribute('data-tab') !== 'details' && btn.parentElement) {
                btn.parentElement.addEventListener('mouseenter', function () {
                    closeDropdown(true);
                });
            }
        });
    }

    // Switch Top-Level Tabs (details / incharge / gallery)
    function switchMainTab(targetTab) {
        mainSubnavItems.forEach(item => item.classList.remove('active'));
        mainSubnavLinks.forEach(link => {
            link.classList.remove('active');
            link.setAttribute('aria-selected', 'false');
        });
        mainTabPanes.forEach(pane => pane.classList.remove('active'));

        const targetBtn = document.querySelector(`.lib-nav-list .lib-nav-link[data-tab="${targetTab}"]`);
        if (targetBtn) {
            targetBtn.classList.add('active');
            targetBtn.setAttribute('aria-selected', 'true');
            if (targetBtn.parentElement) {
                targetBtn.parentElement.classList.add('active');
            }
        }

        const activePane = document.getElementById('tab-' + targetTab);
        if (activePane) {
            activePane.classList.add('active');
        }

        if (dropdownWrap && targetTab !== 'details') {
            dropdownWrap.classList.remove('open');
        }
    }

    // Switch Sub-Options inside Library Details
    function switchSubPane(subtabId) {
        // Ensure Library Details parent tab is active
        switchMainTab('details');

        // Update Dropdown Items active state
        dropdownItems.forEach(item => {
            const isMatch = item.getAttribute('data-subtab') === subtabId;
            item.classList.toggle('active', isMatch);
        });

        // Update Sub-panes
        libSubpanes.forEach(pane => pane.classList.remove('active'));
        const targetSubpane = document.getElementById('subpane-' + subtabId);
        if (targetSubpane) {
            targetSubpane.classList.add('active');
        }

        // Close dropdown immediately
        closeDropdown(true);
    }

    // Top Subnav Link Clicks
    mainSubnavLinks.forEach(btn => {
        btn.addEventListener('click', function (e) {
            const targetTab = this.getAttribute('data-tab');
            if (targetTab === 'details') {
                e.preventDefault();
                e.stopPropagation();
                switchMainTab('details');
                const isOpen = dropdownMenu && dropdownMenu.classList.contains('show');
                if (isOpen) {
                    closeDropdown(true);
                } else {
                    openDropdown();
                }
            } else {
                switchMainTab(targetTab);
                closeDropdown(true);
            }
        });
    });

    // Dropdown Items Click
    dropdownItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const subtab = this.getAttribute('data-subtab');
            switchSubPane(subtab);
        });
    });

    // Close Dropdown on Click Outside
    document.addEventListener('click', function (e) {
        if (dropdownWrap && dropdownMenu && !dropdownWrap.contains(e.target) && !dropdownMenu.contains(e.target)) {
            closeDropdown(true);
        }
    });

    // Lightbox for Gallery Photos (Zoom View)
    const galleryCards = document.querySelectorAll('.lib-gallery-card');
    const lightbox = document.getElementById('libLightbox');
    const lightboxImg = document.getElementById('libLightboxImg');
    const lightboxCaption = document.getElementById('libLightboxCaption');
    const lightboxBadge = document.getElementById('libLightboxBadge');
    const lightboxClose = document.getElementById('libLightboxClose');
    const lightboxBackdrop = document.getElementById('libLightboxBackdrop');

    if (galleryCards.length > 0 && lightbox) {
        galleryCards.forEach(card => {
            card.addEventListener('click', function () {
                const imgUrl = this.getAttribute('data-img');
                const caption = this.getAttribute('data-caption');
                const badge = this.getAttribute('data-badge') || 'Central Library';

                if (lightboxImg && imgUrl) {
                    lightboxImg.src = imgUrl;
                    lightboxImg.alt = caption || 'Library Photo';
                    if (lightboxCaption) lightboxCaption.textContent = caption || '';
                    if (lightboxBadge) lightboxBadge.textContent = badge;
                    lightbox.classList.add('is-open');
                    lightbox.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                }
            });
        });

        function closeLightbox() {
            lightbox.classList.remove('is-open');
            lightbox.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
        if (lightboxBackdrop) lightboxBackdrop.addEventListener('click', closeLightbox);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && lightbox.classList.contains('is-open')) {
                closeLightbox();
            }
        });
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
