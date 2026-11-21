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

require_once __DIR__ . '/../includes/header.php';
?>

<div class="dept-page" id="mainContent">

    <div class="dept-container">
        <!-- Hero Section (Two-Column Department Layout) -->
        <div class="dept-about-hero">
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
    </div>

    <!-- Sticky sub-navigation bar matching Department tabs -->
    <nav class="dept-subnav-bar" id="libSubNav" aria-label="Library Navigation">
        <div class="dept-container">
            <div class="dept-subnav-wrap">
                <ul class="dept-subnav-list" role="tablist">
                    <li class="dept-subnav-item dept-subnav-dropdown active">
                        <button type="button" class="dept-subnav-link dept-subnav-link-with-arrow active" data-tab="details" role="tab" aria-selected="true" aria-haspopup="true" aria-expanded="false" id="libDetailsTab">
                            <span>Library Details</span>
                            <svg class="dept-subnav-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div class="dept-subnav-dropdown-menu" role="menu" aria-label="Library Details Subsections">
                            <button type="button" class="dept-subnav-dropdown-item active" data-subtab="overview" role="menuitem">
                                Overview &amp; Infrastructure
                            </button>
                            <button type="button" class="dept-subnav-dropdown-item" data-subtab="volumes" role="menuitem">
                                Book Collection &amp; Volumes
                            </button>
                            <button type="button" class="dept-subnav-dropdown-item" data-subtab="digital" role="menuitem">
                                Digital Library &amp; E-Resources
                            </button>
                            <button type="button" class="dept-subnav-dropdown-item" data-subtab="membership" role="menuitem">
                                Membership &amp; Guidelines
                            </button>
                        </div>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="incharge" role="tab" aria-selected="false">
                            Library In-charge
                        </button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="gallery" role="tab" aria-selected="false">
                            Library at a glance
                        </button>
                    </li>
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
                            <tr>
                                <td>
                                    <strong>Mechanical &amp; Automobile Engineering</strong>
                                    <div style="font-size: 0.82rem; color: #6b7280; margin-top: 3px;">Thermodynamics, Manufacturing, Automobile Systems, Machine Design</div>
                                </td>
                                <td style="text-align: center;" class="lib-vol-num">1,110</td>
                                <td style="text-align: center;" class="lib-vol-num">4,811</td>
                                <td style="text-align: center;"><span class="dept-tag-ug">Barcoded</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Civil Engineering &amp; Applied Mechanics</strong>
                                    <div style="font-size: 0.82rem; color: #6b7280; margin-top: 3px;">Structural Analysis, Surveying, Geotechnical, Fluid Mechanics, Concrete</div>
                                </td>
                                <td style="text-align: center;" class="lib-vol-num">1,457</td>
                                <td style="text-align: center;" class="lib-vol-num">3,873</td>
                                <td style="text-align: center;"><span class="dept-tag-ug">Barcoded</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Computer Engineering &amp; Information Technology</strong>
                                    <div style="font-size: 0.82rem; color: #6b7280; margin-top: 3px;">Algorithms, Operating Systems, Database, AI/ML, Networks, Cyber Security</div>
                                </td>
                                <td style="text-align: center;" class="lib-vol-num">1,476</td>
                                <td style="text-align: center;" class="lib-vol-num">5,178</td>
                                <td style="text-align: center;"><span class="dept-tag-ug">Barcoded</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Electrical Engineering</strong>
                                    <div style="font-size: 0.82rem; color: #6b7280; margin-top: 3px;">Electrical Machines, Power Systems, Control Systems, High Voltage</div>
                                </td>
                                <td style="text-align: center;" class="lib-vol-num">668</td>
                                <td style="text-align: center;" class="lib-vol-num">2,312</td>
                                <td style="text-align: center;"><span class="dept-tag-ug">Barcoded</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Electronics &amp; Communication Engineering</strong>
                                    <div style="font-size: 0.82rem; color: #6b7280; margin-top: 3px;">Digital Communication, VLSI Design, Embedded Systems, Signal Processing</div>
                                </td>
                                <td style="text-align: center;" class="lib-vol-num">1,347</td>
                                <td style="text-align: center;" class="lib-vol-num">4,186</td>
                                <td style="text-align: center;"><span class="dept-tag-ug">Barcoded</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>General Sciences &amp; Humanities</strong>
                                    <div style="font-size: 0.82rem; color: #6b7280; margin-top: 3px;">Engineering Mathematics, Physics, Chemistry, Professional English, Ethics</div>
                                </td>
                                <td style="text-align: center;" class="lib-vol-num">901</td>
                                <td style="text-align: center;" class="lib-vol-num">2,163</td>
                                <td style="text-align: center;"><span class="dept-tag-ug">Barcoded</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>RUSA Section</strong>
                                    <div style="font-size: 0.82rem; color: #6b7280; margin-top: 3px;">Rashtriya Uchchatar Shiksha Abhiyan Special Grant Volumes &amp; Reference</div>
                                </td>
                                <td style="text-align: center;" class="lib-vol-num">201</td>
                                <td style="text-align: center;" class="lib-vol-num">290</td>
                                <td style="text-align: center;"><span class="dept-tag-ug">Special Grant</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Bureau of Indian Standards (IS Code)</strong>
                                    <div style="font-size: 0.82rem; color: #6b7280; margin-top: 3px;">National Engineering Specifications, Testing Standards, Codes of Practice</div>
                                </td>
                                <td style="text-align: center;" class="lib-vol-num">1,818</td>
                                <td style="text-align: center;" class="lib-vol-num">2,049</td>
                                <td style="text-align: center;"><span class="dept-tag-ug">Standards</span></td>
                            </tr>
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
                            <tr>
                                <td style="text-align: center; color: #6b7280; font-weight: 600;">1</td>
                                <td>
                                    <strong>Prof. Nirali V. Upadhyay</strong>
                                    <div style="font-size: 0.84rem; color: #6b7280; margin-top: 2px;">Assistant Professor, Electrical Engineering (AP.EE)</div>
                                </td>
                                <td>
                                    <span class="dept-tag-incharge">Library Incharge</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; color: #6b7280; font-weight: 600;">2</td>
                                <td>
                                    <strong>Prof. Kunal V. Fadadu</strong>
                                    <div style="font-size: 0.84rem; color: #6b7280; margin-top: 2px;">Assistant Professor, Automobile Engineering (AP.AT)</div>
                                </td>
                                <td>
                                    <span class="dept-tag-asst">Assistant Library Incharge</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; color: #6b7280; font-weight: 600;">3</td>
                                <td>
                                    <strong>Prof. A. B. Parmar</strong>
                                    <div style="font-size: 0.84rem; color: #6b7280; margin-top: 2px;">Assistant Professor, Computer Engineering (AP.CE)</div>
                                </td>
                                <td>
                                    <span class="dept-tag-ug">Member</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; color: #6b7280; font-weight: 600;">4</td>
                                <td>
                                    <strong>Prof. N. S. Chowdhary</strong>
                                    <div style="font-size: 0.84rem; color: #6b7280; margin-top: 2px;">Assistant Professor, Computer Engineering (AP.CE)</div>
                                </td>
                                <td>
                                    <span class="dept-tag-ug">Member</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; color: #6b7280; font-weight: 600;">5</td>
                                <td>
                                    <strong>Prof. R. N. Vaza</strong>
                                    <div style="font-size: 0.84rem; color: #6b7280; margin-top: 2px;">Assistant Professor, Computer Engineering (AP.CE)</div>
                                </td>
                                <td>
                                    <span class="dept-tag-ug">Member</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; color: #6b7280; font-weight: 600;">6</td>
                                <td>
                                    <strong>Prof. C. K. Baria</strong>
                                    <div style="font-size: 0.84rem; color: #6b7280; margin-top: 2px;">Assistant Professor, Electrical Engineering (AP.EE)</div>
                                </td>
                                <td>
                                    <span class="dept-tag-ug">Member</span>
                                </td>
                            </tr>
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
                            <tr>
                                <td style="text-align: center; color: #6b7280; font-weight: 600;">1</td>
                                <td>
                                    <strong>Shri A. M. Patel</strong>
                                    <div style="font-size: 0.84rem; color: #6b7280; margin-top: 2px;">Learning Resource Centre (LRC)</div>
                                </td>
                                <td>
                                    <span class="dept-tag-librarian">In-charge (Librarian)</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center; color: #6b7280; font-weight: 600;">2</td>
                                <td>
                                    <strong>Shri J. N. Patel</strong>
                                    <div style="font-size: 0.84rem; color: #6b7280; margin-top: 2px;">Electronics &amp; Communication Engineering (EC)</div>
                                </td>
                                <td>
                                    <span class="dept-tag-ug">Member</span>
                                </td>
                            </tr>
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
                    <div class="lib-gallery-card">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_reading_hall_wide.jpg" alt="Central Library Reading Hall Wide Overview" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <div>
                                <span class="lib-gallery-tag">READING HALL</span>
                                <h3 class="lib-gallery-title">Spacious Reading Hall</h3>
                                <p class="lib-gallery-desc">Modern 100-seat reading hall featuring natural ventilation, expansive study tables, and a serene academic atmosphere.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Photo 2: Reading Room Study Desks -->
                    <div class="lib-gallery-card">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_reading_hall_study.jpg" alt="Student Reading and Study Desks" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <div>
                                <span class="lib-gallery-tag">STUDY AREA</span>
                                <h3 class="lib-gallery-title">Student Reading Desks</h3>
                                <p class="lib-gallery-desc">Ergonomic seating arrangements providing focused and peaceful environments for extended study sessions.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Photo 3: Digital Library Workstations -->
                    <div class="lib-gallery-card">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_digital_workstations.jpg" alt="Digital Library Computing Terminals" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <div>
                                <span class="lib-gallery-tag">DIGITAL LIBRARY</span>
                                <h3 class="lib-gallery-title">Multimedia Workstations</h3>
                                <p class="lib-gallery-desc">Dedicated high-speed PC terminals (Stations 6 &amp; 7) connected to 100 Mbps NKN broadband with strict quiet zone protocols.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Photo 4: Digital Research & E-Resources -->
                    <div class="lib-gallery-card">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_digital_research.jpg" alt="Students and Faculty Accessing E-Resources" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <div>
                                <span class="lib-gallery-tag">E-RESOURCES</span>
                                <h3 class="lib-gallery-title">Online Journal &amp; Research Lab</h3>
                                <p class="lib-gallery-desc">Students and faculty actively accessing online institutional databases, e-books, and research publications.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Photo 5: Periodicals & Journals Display -->
                    <div class="lib-gallery-card">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_periodicals_rack.jpg" alt="Technical Periodicals and Journals Display Rack" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <div>
                                <span class="lib-gallery-tag">PERIODICALS</span>
                                <h3 class="lib-gallery-title">Periodicals &amp; Magazine Display</h3>
                                <p class="lib-gallery-desc">Current national and international periodicals including DRDO newsletters, MARG, Engineering Success Review, and technical digests.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Photo 6: Librarian Office & Cabin -->
                    <div class="lib-gallery-card">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_librarian_cabin.jpg" alt="Librarian Office Cabin Room 3109-A" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <div>
                                <span class="lib-gallery-tag">ADMINISTRATION</span>
                                <h3 class="lib-gallery-title">Librarian Office (Room 3109-A)</h3>
                                <p class="lib-gallery-desc">Dedicated glass-partitioned administration cabin for circulation help, member registration, and book management.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Photo 7: Reference Reading Area & Corridor -->
                    <div class="lib-gallery-card">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_reference_section.jpg" alt="Reference Section and Periodicals Corridor" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <div>
                                <span class="lib-gallery-tag">REFERENCE AREA</span>
                                <h3 class="lib-gallery-title">Reference Reading Area</h3>
                                <p class="lib-gallery-desc">Adjacent reading desks with direct access to current periodicals racks, academic journals, and general digests.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Photo 8: Main Book Storage Almirahs -->
                    <div class="lib-gallery-card">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_book_stacks_1.jpg" alt="Main Book Storage and Glass-Door Almirahs" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <div>
                                <span class="lib-gallery-tag">BOOK STACKS</span>
                                <h3 class="lib-gallery-title">Main Book Storage &amp; Almirahs</h3>
                                <p class="lib-gallery-desc">Secure glass-door cupboards housing over 24,800+ barcoded and categorized academic engineering volumes.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Photo 9: Book Stacks & Partition Corridor -->
                    <div class="lib-gallery-card">
                        <div class="lib-gallery-media">
                            <img src="<?= $root_path ?>images/library/gallery_book_stacks_2.jpg" alt="Book Stacks and Circulation Aisles" class="lib-gallery-img" loading="lazy">
                        </div>
                        <div class="lib-gallery-body">
                            <div>
                                <span class="lib-gallery-tag">CIRCULATION AISLES</span>
                                <h3 class="lib-gallery-title">Book Stacks &amp; Partition Aisles</h3>
                                <p class="lib-gallery-desc">Department-wise organized steel and wood stack aisles facilitating efficient textbook retrieval.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainSubnavLinks = document.querySelectorAll('.dept-subnav-link');
    const mainSubnavItems = document.querySelectorAll('.dept-subnav-item');
    const mainTabPanes = document.querySelectorAll('.dept-tab-pane');

    const dropdownWrap = document.querySelector('.dept-subnav-dropdown');
    const dropdownItems = document.querySelectorAll('.dept-subnav-dropdown-item');
    const libSubpanes = document.querySelectorAll('.lib-subpane');

    // Switch Top-Level Tabs (details / incharge / gallery)
    function switchMainTab(targetTab) {
        mainSubnavItems.forEach(item => item.classList.remove('active'));
        mainSubnavLinks.forEach(link => {
            link.classList.remove('active');
            link.setAttribute('aria-selected', 'false');
        });
        mainTabPanes.forEach(pane => pane.classList.remove('active'));

        const targetBtn = document.querySelector(`.dept-subnav-link[data-tab="${targetTab}"]`);
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

        // Close dropdown
        if (dropdownWrap) {
            dropdownWrap.classList.remove('open');
        }
    }

    // Top Subnav Link Clicks
    mainSubnavLinks.forEach(btn => {
        btn.addEventListener('click', function (e) {
            const targetTab = this.getAttribute('data-tab');
            if (targetTab === 'details') {
                e.preventDefault();
                switchMainTab('details');
                if (dropdownWrap) {
                    dropdownWrap.classList.toggle('open');
                }
            } else {
                switchMainTab(targetTab);
                if (dropdownWrap) {
                    dropdownWrap.classList.remove('open');
                }
            }
        });
    });

    // Dropdown Items Click
    dropdownItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.stopPropagation();
            const subtab = this.getAttribute('data-subtab');
            switchSubPane(subtab);
        });
    });

    // Close Dropdown on Click Outside
    document.addEventListener('click', function (e) {
        if (dropdownWrap && !dropdownWrap.contains(e.target)) {
            dropdownWrap.classList.remove('open');
        }
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
