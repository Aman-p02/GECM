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
                    <li class="dept-subnav-item active">
                        <button type="button" class="dept-subnav-link active" data-tab="overview" role="tab" aria-selected="true">
                            Overview &amp; Infrastructure
                        </button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="volumes" role="tab" aria-selected="false">
                            Book Collection &amp; Volumes
                        </button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="digital" role="tab" aria-selected="false">
                            Digital Library &amp; E-Resources
                        </button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="membership" role="tab" aria-selected="false">
                            Membership &amp; Guidelines
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Panes -->
    <main class="dept-main-content">
        <div class="dept-container">

            <!-- TAB 1: OVERVIEW & INFRASTRUCTURE -->
            <section class="dept-tab-pane active" id="tab-overview">
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
            </section>

            <!-- TAB 2: BOOK COLLECTION & VOLUMES -->
            <section class="dept-tab-pane" id="tab-volumes">
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
            </section>

            <!-- TAB 3: DIGITAL LIBRARY & E-RESOURCES -->
            <section class="dept-tab-pane" id="tab-digital">
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
            </section>

            <!-- TAB 4: MEMBERSHIP & GUIDELINES -->
            <section class="dept-tab-pane" id="tab-membership">
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
            </section>

        </div>
    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const subnavLinks = document.querySelectorAll('.dept-subnav-link');
    const tabPanes = document.querySelectorAll('.dept-tab-pane');
    const subnavItems = document.querySelectorAll('.dept-subnav-item');

    subnavLinks.forEach(function (button) {
        button.addEventListener('click', function () {
            const targetTab = this.getAttribute('data-tab');

            // Deactivate all
            subnavItems.forEach(item => item.classList.remove('active'));
            subnavLinks.forEach(link => {
                link.classList.remove('active');
                link.setAttribute('aria-selected', 'false');
            });
            tabPanes.forEach(pane => pane.classList.remove('active'));

            // Activate clicked
            this.classList.add('active');
            this.setAttribute('aria-selected', 'true');
            if (this.parentElement) {
                this.parentElement.classList.add('active');
            }

            const activePane = document.getElementById('tab-' + targetTab);
            if (activePane) {
                activePane.classList.add('active');
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
