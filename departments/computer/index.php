<?php
// Set Page Variables
$page_title = "Computer Engineering Department - Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/computer/css/department.css";
$extra_js = "departments/computer/js/department.js";

// Include Header
include_once __DIR__ . '/../../includes/header.php';
?>

<!-- ========================================================
     1. Institutional Department Hero Strip
     ======================================================== -->
<section class="dept-hero-strip" aria-label="Department Overview">
    <div class="container">
        <div class="dept-hero-inner">
            <nav class="dept-breadcrumb" aria-label="Breadcrumb">
                <a href="<?= $root_path ?>"><i class="fas fa-home"></i> Home</a>
                <span class="sep"><i class="fas fa-chevron-right"></i></span>
                <a href="<?= $root_path ?>#departments">Departments</a>
                <span class="sep"><i class="fas fa-chevron-right"></i></span>
                <span class="current">Computer Engineering</span>
            </nav>
            <div class="dept-hero-badge">Department of</div>
            <h1 class="dept-hero-title">Computer Engineering</h1>
            <p class="dept-hero-desc">
                Pioneering computing education, cutting-edge software engineering, and technological research since 2001. Committed to producing globally competent engineering graduates with strong ethics.
            </p>
            <div class="dept-hero-stats">
                <div class="dept-stat-chip">
                    <i class="fas fa-calendar-check"></i>
                    <span>Established <strong>2001</strong></span>
                </div>
                <div class="dept-stat-chip">
                    <i class="fas fa-user-graduate"></i>
                    <span>Intake: <strong>120 UG + 18 PG</strong></span>
                </div>
                <div class="dept-stat-chip">
                    <i class="fas fa-microchip"></i>
                    <span>Laboratories: <strong>10 Modern Labs</strong></span>
                </div>
                <div class="dept-stat-chip">
                    <i class="fas fa-certificate"></i>
                    <span>Affiliation: <strong>GTU / AICTE</strong></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================
     2. Main Department Interactive Portal Layout
     ======================================================== -->
<div class="dept-page-wrapper">
    <div class="container">
        <div class="dept-layout-grid">

            <!-- Left Navigation Sidebar -->
            <aside class="dept-sidebar" aria-label="Department Navigation">
                <div class="dept-sidebar-card">
                    <div class="dept-sidebar-header">
                        <div class="dept-sidebar-header-icon">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <div class="dept-sidebar-header-text">
                            <span class="dept-sidebar-subtitle">DEPARTMENT PORTAL</span>
                            <h3 class="dept-sidebar-title">Computer Dept</h3>
                        </div>
                    </div>

                    <ul class="dept-sidebar-menu" role="tablist">
                        <li class="dept-menu-item active">
                            <a class="dept-nav-link active" data-tab="about" role="tab" aria-selected="true">
                                <span class="nav-icon-wrap"><i class="fas fa-info-circle"></i></span>
                                <span class="nav-label">About Department</span>
                            </a>
                        </li>
                        <li class="dept-menu-item">
                            <a class="dept-nav-link" data-tab="vision-mission" role="tab" aria-selected="false">
                                <span class="nav-icon-wrap"><i class="fas fa-compass"></i></span>
                                <span class="nav-label">Vision &amp; Mission</span>
                            </a>
                        </li>
                        <li class="dept-menu-item">
                            <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="dept-nav-link" aria-label="Syllabus on GTU Portal">
                                <span class="nav-icon-wrap"><i class="fas fa-graduation-cap"></i></span>
                                <span class="nav-label">Syllabus</span>
                                <span class="nav-ext-badge"><i class="fas fa-arrow-up-right-from-square"></i></span>
                            </a>
                        </li>
                        <li class="dept-menu-item">
                            <a class="dept-nav-link" data-tab="faculty" role="tab" aria-selected="false">
                                <span class="nav-icon-wrap"><i class="fas fa-chalkboard-teacher"></i></span>
                                <span class="nav-label">Faculty</span>
                                <span class="nav-count-badge">6</span>
                            </a>
                        </li>
                        <li class="dept-menu-item">
                            <a class="dept-nav-link" data-tab="activities" role="tab" aria-selected="false">
                                <span class="nav-icon-wrap"><i class="fas fa-calendar-check"></i></span>
                                <span class="nav-label">Activities</span>
                            </a>
                        </li>
                        <li class="dept-menu-item">
                            <a class="dept-nav-link" data-tab="facilities" role="tab" aria-selected="false">
                                <span class="nav-icon-wrap"><i class="fas fa-microchip"></i></span>
                                <span class="nav-label">Facilities</span>
                            </a>
                        </li>
                        <li class="dept-menu-item">
                            <a class="dept-nav-link" data-tab="publications" role="tab" aria-selected="false">
                                <span class="nav-icon-wrap"><i class="fas fa-book-bookmark"></i></span>
                                <span class="nav-label">Publications</span>
                            </a>
                        </li>
                        <li class="dept-menu-item dept-sidebar-dropdown closed" id="sidebar-iab">
                            <div class="dept-dropdown-header" role="button" tabindex="0" aria-expanded="false">
                                <div class="dd-title-wrap">
                                    <span class="nav-icon-wrap"><i class="fas fa-handshake"></i></span>
                                    <span class="nav-label">Industry Advisory Board</span>
                                </div>
                                <i class="fas fa-chevron-right dropdown-arrow"></i>
                            </div>
                            <ul class="dept-sub-menu">
                                <li>
                                    <a class="dept-sub-link" data-tab="iab-2025-26" href="#iab-2025-26">
                                        <span class="sub-dot"></span>
                                        <span>IAB 2025-26</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dept-sub-link" data-tab="iab-2023-24" href="#iab-2023-24">
                                        <span class="sub-dot"></span>
                                        <span>IAB 2023-24</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dept-menu-item dept-sidebar-dropdown closed" id="sidebar-newsletters">
                            <div class="dept-dropdown-header" role="button" tabindex="0" aria-expanded="false">
                                <div class="dd-title-wrap">
                                    <span class="nav-icon-wrap"><i class="fas fa-newspaper"></i></span>
                                    <span class="nav-label">News Letters</span>
                                </div>
                                <i class="fas fa-chevron-right dropdown-arrow"></i>
                            </div>
                            <ul class="dept-sub-menu">
                                <li>
                                    <a class="dept-sub-link" data-tab="nl-vol1-issue2" href="#nl-vol1-issue2">
                                        <span class="sub-dot"></span>
                                        <span>Vol. 1 Issue 2</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dept-sub-link" data-tab="nl-vol1-issue1" href="#nl-vol1-issue1">
                                        <span class="sub-dot"></span>
                                        <span>Vol. 1 Issue 1</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Right Content Area -->
            <main class="dept-content-panel">

                <!-- ========================================================
                     1. ABOUT DEPARTMENT TAB
                     ======================================================== -->
                <section class="dept-tab-content active" id="tab-about">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">OVERVIEW</span>
                        <h2 class="dept-section-title">About Computer Engineering</h2>
                    </div>

                    <p class="dept-lead-text">
                        The Department of Computer Engineering at Government Engineering College, Modasa has been delivering quality engineering education since 2001. Equipped with high-speed campus networking, advanced computing servers, and industry-oriented laboratory environments.
                    </p>

                    <!-- Key Highlights Grid -->
                    <div class="dept-highlights-grid">
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-network-wired"></i></div>
                            <div class="dept-highlight-body">
                                <h4>Campus Wide LAN</h4>
                                <p>250+ networked nodes with dedicated high-speed optical fiber connectivity.</p>
                            </div>
                        </div>
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-wifi"></i></div>
                            <div class="dept-highlight-body">
                                <h4>High-Speed Wi-Fi</h4>
                                <p>30 enterprise-grade Wi-Fi access points managed by a central hardware controller.</p>
                            </div>
                        </div>
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-server"></i></div>
                            <div class="dept-highlight-body">
                                <h4>Dedicated Servers</h4>
                                <p>Latest rack-mounted servers hosting e-learning tools and departmental servers.</p>
                            </div>
                        </div>
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-graduation-cap"></i></div>
                            <div class="dept-highlight-body">
                                <h4>PG Programme</h4>
                                <p>M.E. in Computer Science &amp; Engineering offered continuously since 2010.</p>
                            </div>
                        </div>
                    </div>

                    <p class="dept-text-body">
                        The department has developed state-of-the-art laboratories in cutting-edge domains like Computer Hardware, Networking &amp; Security, Database Management Systems, Computer Graphics, Cloud Computing, and Artificial Intelligence in tune with real-time industrial systems.
                    </p>

                    <p class="dept-text-body">
                        Computer Engineering and Information Technology departments operate in a newly constructed, well-furnished academic block. The main strength of the department is highly qualified and experienced faculties. With 10 computer laboratories and two seminar halls, students receive hands-on training to build robust software systems.
                    </p>

                    <!-- Under Graduate/Post Graduate Courses Table Card -->
                    <div class="courses-card">
                        <div class="courses-card-header">
                            <i class="fas fa-layer-group"></i>
                            <span>Under Graduate &amp; Post Graduate Programmes</span>
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table">
                                <thead>
                                    <tr>
                                        <th>Name of Course</th>
                                        <th>Level</th>
                                        <th>Duration</th>
                                        <th>Approved Intake</th>
                                        <th>Year of Starting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>B.E. Computer Engineering</strong></td>
                                        <td><span class="dept-badge-pill dept-badge-ug">UG</span></td>
                                        <td>4 Years</td>
                                        <td><strong>120</strong></td>
                                        <td>2001</td>
                                    </tr>
                                    <tr>
                                        <td><strong>M.E. Computer Science &amp; Engineering</strong></td>
                                        <td><span class="dept-badge-pill dept-badge-pg">PG</span></td>
                                        <td>2 Years</td>
                                        <td><strong>18</strong></td>
                                        <td>2010</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     2. VISION & MISSION TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-vision-mission">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">STRATEGIC GOALS</span>
                        <h2 class="dept-section-title">Vision &amp; Mission</h2>
                    </div>

                    <div class="vision-mission-grid">
                        <div class="vm-card vm-card-vision">
                            <div class="vm-header">
                                <div class="vm-icon-box"><i class="fas fa-eye"></i></div>
                                <h3 class="vm-title">Department Vision</h3>
                            </div>
                            <p class="vm-text">
                                To become a prominent department producing competent professionals with research, innovation and entrepreneurial skills, inculcating moral values and societal concerns.
                            </p>
                        </div>

                        <div class="vm-card vm-card-mission">
                            <div class="vm-header">
                                <div class="vm-icon-box"><i class="fas fa-bullseye"></i></div>
                                <h3 class="vm-title">Department Mission</h3>
                            </div>
                            <ul class="mission-list">
                                <li class="mission-item">
                                    <span class="mission-tag">M1</span>
                                    <span>To create globally competent students having ability to design, develop and test world-class software, keeping pace with latest technological developments.</span>
                                </li>
                                <li class="mission-item">
                                    <span class="mission-tag">M2</span>
                                    <span>Create facilities and expertise in advanced computer technology, thereby promoting cutting-edge research.</span>
                                </li>
                                <li class="mission-item">
                                    <span class="mission-tag">M3</span>
                                    <span>Enhance Industry Institute Interaction programme to get students thoroughly acquainted with modern corporate culture.</span>
                                </li>
                                <li class="mission-item">
                                    <span class="mission-tag">M4</span>
                                    <span>Induce moral, ethical values and spirit of active social commitment.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Program Educational Objectives PEOs Card -->
                    <div class="peo-card">
                        <div class="peo-card-header">
                            <i class="fas fa-bullseye"></i>
                            <span>Program Educational Objectives (PEOs)</span>
                        </div>
                        <div class="peo-card-intro">
                            Graduates of Computer Engineering will:
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table peo-table">
                                <tbody>
                                    <tr>
                                        <td class="peo-label">PEO 1</td>
                                        <td>Be an efficient Software developer in diverse fields and will be a successful professional and/or pursue higher studies.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-label">PEO 2</td>
                                        <td>Be capable to adapt advanced state of the art computing technology for professional excellence and Research and be a lifelong learner.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-label">PEO 3</td>
                                        <td>Work productively exhibiting ethical qualities for the betterment of society.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-label">PEO 4</td>
                                        <td>Possess leadership and entrepreneurial qualities, work harmoniously as a team member with effective communication skills.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Program Specific Outcomes PSOs Card -->
                    <div class="peo-card">
                        <div class="peo-card-header">
                            <i class="fas fa-check-circle"></i>
                            <span>Program Specific Outcomes (PSOs)</span>
                        </div>
                        <div class="peo-card-intro">
                            Computer Engineering Graduates will be able to:
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table peo-table">
                                <tbody>
                                    <tr>
                                        <td class="peo-label">PSO 1</td>
                                        <td>Gain capability to use current / advanced technology, skills and tools necessary for carrying out Real-World Multidisciplinary projects.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-label">PSO 2</td>
                                        <td>Achieve an ability to build a computer based system, process or a component that meets the desired needs.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-label">PSO 3</td>
                                        <td>Apply concepts of core areas of Computer Engineering– Data Structures, Database Management Systems, Operating Systems, Computer Architecture and Software Engineering to provide innovative solutions.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     3. FACULTY TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-faculty">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">ACADEMIC TEAM</span>
                        <h2 class="dept-section-title">Faculty Members</h2>
                    </div>

                    <p class="dept-text-body">
                        The Computer Engineering department possesses highly qualified, experienced, and dedicated teaching faculty members with specializations across diverse computing domains.
                    </p>

                    <div class="faculty-grid">
                        <div class="faculty-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Dr. H. M. Patel</h4>
                            <span class="faculty-desig-badge">Head of Department</span>
                            <div class="faculty-qual">Ph.D., M.Tech (Computer Engineering)</div>
                            <a href="mailto:hod_ce@gecmodasa.ac.in" class="faculty-email-btn"><i class="fas fa-envelope"></i> hod_ce@gecmodasa.ac.in</a>
                        </div>

                        <div class="faculty-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. A. S. Shah</h4>
                            <span class="faculty-desig-badge">Associate Professor</span>
                            <div class="faculty-qual">Ph.D. (Pursuing), M.E. (Computer Engineering)</div>
                            <a href="mailto:asshah@gecmodasa.ac.in" class="faculty-email-btn"><i class="fas fa-envelope"></i> asshah@gecmodasa.ac.in</a>
                        </div>

                        <div class="faculty-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. R. K. Prajapati</h4>
                            <span class="faculty-desig-badge">Assistant Professor</span>
                            <div class="faculty-qual">M.E. (Computer Science &amp; Engineering)</div>
                            <a href="mailto:rkprajapati@gecmodasa.ac.in" class="faculty-email-btn"><i class="fas fa-envelope"></i> rkprajapati@gecmodasa.ac.in</a>
                        </div>

                        <div class="faculty-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. P. N. Mehta</h4>
                            <span class="faculty-desig-badge">Assistant Professor</span>
                            <div class="faculty-qual">M.Tech (Software Engineering)</div>
                            <a href="mailto:pnmehta@gecmodasa.ac.in" class="faculty-email-btn"><i class="fas fa-envelope"></i> pnmehta@gecmodasa.ac.in</a>
                        </div>

                        <div class="faculty-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. S. D. Joshi</h4>
                            <span class="faculty-desig-badge">Assistant Professor</span>
                            <div class="faculty-qual">M.E. (Computer Engineering)</div>
                            <a href="mailto:sdjoshi@gecmodasa.ac.in" class="faculty-email-btn"><i class="fas fa-envelope"></i> sdjoshi@gecmodasa.ac.in</a>
                        </div>

                        <div class="faculty-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. M. B. Patel</h4>
                            <span class="faculty-desig-badge">Assistant Professor</span>
                            <div class="faculty-qual">M.Tech (Information Technology)</div>
                            <a href="mailto:mbpatel@gecmodasa.ac.in" class="faculty-email-btn"><i class="fas fa-envelope"></i> mbpatel@gecmodasa.ac.in</a>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     4. ACTIVITIES TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-activities">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">CO-CURRICULAR &amp; EXTENSIONS</span>
                        <h2 class="dept-section-title">Department Activities</h2>
                    </div>

                    <p class="dept-text-body">
                        The department regularly organizes workshops, hackathons, expert lectures by industry leaders, and technical competitions under the banner of student developer clubs and societies.
                    </p>

                    <div class="activities-grid">
                        <div class="activity-card">
                            <div class="activity-card-icon"><i class="fas fa-laptop-code"></i></div>
                            <h4>CodeFest &amp; Hackathons</h4>
                            <p>Annual inter-college coding marathon encouraging students to develop innovative software solutions for real-world governance and industrial problems.</p>
                        </div>
                        <div class="activity-card">
                            <div class="activity-card-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                            <h4>Expert Lectures &amp; Webinars</h4>
                            <p>Distinguished industry leaders and researchers deliver interactive masterclasses on Cloud Computing, Cyber Security, DevOps, and Machine Learning.</p>
                        </div>
                        <div class="activity-card">
                            <div class="activity-card-icon"><i class="fas fa-industry"></i></div>
                            <h4>Industrial Visits</h4>
                            <p>Regular study tours to leading organizations like BISAG-N Gandhinagar, TCS Garima Park, and ISRO Space Applications Centre to experience real tech scale.</p>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     5. FACILITIES TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-facilities">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">INFRASTRUCTURE</span>
                        <h2 class="dept-section-title">Laboratories &amp; Facilities</h2>
                    </div>

                    <!-- Modern Segmented Tabs -->
                    <div class="facility-tabs-container">
                        <div class="facility-segmented-tabs" role="tablist">
                            <button type="button" class="facility-tab-btn active" data-subtab="labs" role="tab">
                                <i class="fas fa-desktop"></i>
                                <span>Laboratories</span>
                                <span class="tab-count-badge">5</span>
                            </button>
                            <button type="button" class="facility-tab-btn" data-subtab="seminar" role="tab">
                                <i class="fas fa-users"></i>
                                <span>Seminar Room</span>
                            </button>
                            <button type="button" class="facility-tab-btn" data-subtab="server" role="tab">
                                <i class="fas fa-server"></i>
                                <span>Server Room</span>
                            </button>
                        </div>
                    </div>

                    <!-- Subtab 1: Laboratories -->
                    <div class="facility-pane active" id="subtab-labs">
                        <p class="dept-text-body">
                            There are 10 computer laboratories dedicated to practical experiments in domains like Programming, Computer Graphics, Networking, Database Management, Operating Systems, AI, and Hardware design.
                        </p>

                        <div class="modern-labs-stack">
                            <!-- Lab 1: 8112 Project Lab -->
                            <article class="modern-lab-card">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8112_project.jpg" alt="8112 Project Lab" class="modern-photo-img" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8112</span>
                                    <h3 class="modern-lab-title">Project &amp; Research Lab</h3>
                                    <p class="modern-lab-text">
                                        Dedicated for final year capstone projects and multidisciplinary innovations. Equipped with high-performance desktop systems, rapid prototyping tools, and continuous network access.
                                    </p>
                                </div>
                            </article>

                            <!-- Lab 2: 8113 Programming Lab - 1 -->
                            <article class="modern-lab-card">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8113_programming1.jpg" alt="8113 Programming Lab - 1" class="modern-photo-img" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8113</span>
                                    <h3 class="modern-lab-title">Programming Lab - 1</h3>
                                    <p class="modern-lab-text">
                                        Dedicated for foundational and advanced software subjects including Database Management Systems (DBMS), Operating Systems (OS), Software Engineering, and Python.
                                    </p>
                                </div>
                            </article>

                            <!-- Lab 3: 8115 Hardware Lab -->
                            <article class="modern-lab-card">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8115_hardware.jpg" alt="8115 Hardware Lab" class="modern-photo-img" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8115</span>
                                    <h3 class="modern-lab-title">Computer Hardware &amp; IoT Lab</h3>
                                    <p class="modern-lab-text">
                                        Dedicated for microprocessors, computer organization, digital logic design, IoT kits, and network simulation equipment.
                                    </p>
                                </div>
                            </article>

                            <!-- Lab 4: 8116 PPS Lab - 2 -->
                            <article class="modern-lab-card">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8116_pps2.jpg" alt="8116 PPS Lab - 2" class="modern-photo-img" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8116</span>
                                    <h3 class="modern-lab-title">PPS Lab - 2</h3>
                                    <p class="modern-lab-text">
                                        Designed for Programming for Problem Solving (PPS) courses, enabling freshers to build core algorithmic thinking using C, C++, and Data Structures.
                                    </p>
                                </div>
                            </article>

                            <!-- Lab 5: 8117 Programming Lab - 3 -->
                            <article class="modern-lab-card">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8117_programming3.jpg" alt="8117 Programming Lab - 3" class="modern-photo-img" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8117</span>
                                    <h3 class="modern-lab-title">Programming Lab - 3</h3>
                                    <p class="modern-lab-text">
                                        High-speed networked computing lab utilized for web engineering, full-stack application development, compiler design, and machine learning practicals.
                                    </p>
                                </div>
                            </article>
                        </div>
                    </div>

                    <!-- Subtab 2: Seminar Room -->
                    <div class="facility-pane" id="subtab-seminar">
                        <article class="modern-lab-card">
                            <div class="modern-photo-wrap">
                                <img src="images/labs/seminar_room.jpg" alt="Department Seminar Hall" class="modern-photo-img" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                            </div>
                            <div class="modern-lab-body">
                                <span class="modern-room-pill">Seminar Hall</span>
                                <h3 class="modern-lab-title">Department Seminar &amp; Conference Hall</h3>
                                <p class="modern-lab-text">
                                    Acoustically treated, air-conditioned seminar room equipped with modern AV projection systems, surround audio, and video-conferencing setup for workshops, webinars, and expert sessions.
                                </p>
                            </div>
                        </article>
                    </div>

                    <!-- Subtab 3: Server Room -->
                    <div class="facility-pane" id="subtab-server">
                        <div class="dept-lead-text">
                            <strong>Central Campus Server Facility:</strong> Houses high-performance blade servers, enterprise network firewalls, and 30 managed access points ensuring uninterrupted high-bandwidth connectivity for students and research scholars across the institution.
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     6. PUBLICATIONS TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-publications">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">RESEARCH OUTPUT</span>
                        <h2 class="dept-section-title">Faculty Publications</h2>
                    </div>

                    <p class="dept-text-body">
                        The faculty members actively contribute to peer-reviewed international journals, IEEE conferences, and Springer proceedings.
                    </p>

                    <div class="publications-stack">
                        <div class="publication-item">
                            <span class="pub-year-badge">2024</span>
                            <div class="pub-content">
                                <h4 class="pub-title">Deep Learning Approaches for Real-Time Network Intrusion Detection in IoT Networks</h4>
                                <p class="pub-authors">Dr. H. M. Patel, Prof. A. S. Shah</p>
                                <p class="pub-journal">International Journal of Information and Computer Security, Vol. 18, Issue 3</p>
                            </div>
                        </div>

                        <div class="publication-item">
                            <span class="pub-year-badge">2023</span>
                            <div class="pub-content">
                                <h4 class="pub-title">An Efficient Cryptographic Framework for Cloud Data Integrity Verification</h4>
                                <p class="pub-authors">Prof. R. K. Prajapati, Dr. H. M. Patel</p>
                                <p class="pub-journal">IEEE International Conference on Advanced Computing Technologies (ICACT)</p>
                            </div>
                        </div>

                        <div class="publication-item">
                            <span class="pub-year-badge">2023</span>
                            <div class="pub-content">
                                <h4 class="pub-title">Performance Optimization in Distributed Microservices Architecture</h4>
                                <p class="pub-authors">Prof. P. N. Mehta</p>
                                <p class="pub-journal">Springer Communications in Computer and Information Science, Vol. 1422</p>
                            </div>
                        </div>

                        <div class="publication-item">
                            <span class="pub-year-badge">2022</span>
                            <div class="pub-content">
                                <h4 class="pub-title">Comparative Analysis of Machine Learning Algorithms for Brain-Computer Interface Applications</h4>
                                <p class="pub-authors">Prof. S. D. Joshi, Prof. M. B. Patel</p>
                                <p class="pub-journal">Elsevier Procedia Computer Science, Vol. 218</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     7. INDUSTRY ADVISORY BOARD (IAB 2025-26)
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-iab-2025-26">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">INDUSTRY COLLABORATION</span>
                        <h2 class="dept-section-title">Industry Advisory Board (2025-26)</h2>
                    </div>

                    <p class="dept-text-body">
                        The Industry Advisory Board bridges academia and the corporate sector, providing strategic inputs to align the curriculum, research projects, and student skills with current industry trends.
                    </p>

                    <div class="iab-member-grid">
                        <div class="iab-card">
                            <h4>Dr. H. M. Patel</h4>
                            <div class="iab-org">Head of Dept, GEC Modasa</div>
                            <div class="iab-role">Chairman, IAB Committee</div>
                        </div>
                        <div class="iab-card">
                            <h4>Mr. Nirav Joshi</h4>
                            <div class="iab-org">Senior Cloud Architect, TCS</div>
                            <div class="iab-role">Industry Member (Cloud &amp; DevOps)</div>
                        </div>
                        <div class="iab-card">
                            <h4>Ms. Pooja Sharma</h4>
                            <div class="iab-org">Lead Data Scientist, Infosys</div>
                            <div class="iab-role">Industry Member (AI &amp; Analytics)</div>
                        </div>
                        <div class="iab-card">
                            <h4>Prof. A. S. Shah</h4>
                            <div class="iab-org">Associate Professor, GEC Modasa</div>
                            <div class="iab-role">Member Secretary</div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     8. INDUSTRY ADVISORY BOARD (IAB 2023-24)
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-iab-2023-24">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">INDUSTRY COLLABORATION</span>
                        <h2 class="dept-section-title">Industry Advisory Board (2023-24)</h2>
                    </div>

                    <p class="dept-text-body">
                        Minutes and recommendations of the Industry Advisory Board for the academic year 2023-24 focusing on practical internship opportunities and GTU syllabus feedback.
                    </p>

                    <div class="iab-member-grid">
                        <div class="iab-card">
                            <h4>Dr. H. M. Patel</h4>
                            <div class="iab-org">Head of Dept, GEC Modasa</div>
                            <div class="iab-role">Chairman</div>
                        </div>
                        <div class="iab-card">
                            <h4>Mr. Rajesh Vaghela</h4>
                            <div class="iab-org">VP Engineering, E-Infochips</div>
                            <div class="iab-role">Industry Member (Embedded Systems)</div>
                        </div>
                        <div class="iab-card">
                            <h4>Prof. R. K. Prajapati</h4>
                            <div class="iab-org">Assistant Professor, GEC Modasa</div>
                            <div class="iab-role">Member Secretary</div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     9. NEWS LETTERS (Vol. 1 Issue 2)
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-nl-vol1-issue2">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">DEPARTMENT PERIODICAL</span>
                        <h2 class="dept-section-title">E-Newsletter (Vol. 1 Issue 2)</h2>
                    </div>

                    <p class="dept-text-body">
                        Chronicles faculty accomplishments, student achievements in national hackathons, research publications, and highlights of departmental workshops.
                    </p>

                    <div class="newsletter-grid">
                        <div class="newsletter-card">
                            <div class="nl-card-top">
                                <div class="nl-icon"><i class="fas fa-file-pdf"></i></div>
                                <div>
                                    <h4>CompTech Chronicle - Vol. 1 Issue 2</h4>
                                    <p>Released: July - December Academic Term</p>
                                </div>
                            </div>
                            <p class="dept-text-body" style="font-size: 0.88rem; margin-bottom: 18px;">
                                Features coverage of CodeFest 2024, expert talk by ISRO scientists, and placement roundups.
                            </p>
                            <a href="#" class="nl-download-btn"><i class="fas fa-download"></i> Download Newsletter (PDF)</a>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     10. NEWS LETTERS (Vol. 1 Issue 1)
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-nl-vol1-issue1">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">DEPARTMENT PERIODICAL</span>
                        <h2 class="dept-section-title">E-Newsletter (Vol. 1 Issue 1)</h2>
                    </div>

                    <p class="dept-text-body">
                        The inaugural volume covering departmental initiatives, laboratory modernization milestones, and alumni success stories.
                    </p>

                    <div class="newsletter-grid">
                        <div class="newsletter-card">
                            <div class="nl-card-top">
                                <div class="nl-icon"><i class="fas fa-file-pdf"></i></div>
                                <div>
                                    <h4>CompTech Chronicle - Vol. 1 Issue 1</h4>
                                    <p>Released: January - June Academic Term</p>
                                </div>
                            </div>
                            <p class="dept-text-body" style="font-size: 0.88rem; margin-bottom: 18px;">
                                Highlights of AICTE grant achievements, student startup innovations, and faculty development programs.
                            </p>
                            <a href="#" class="nl-download-btn"><i class="fas fa-download"></i> Download Newsletter (PDF)</a>
                        </div>
                    </div>
                </section>

            </main>
        </div>
    </div>
</div>

<?php
// Include Footer
include_once __DIR__ . '/../../includes/footer.php';
?>