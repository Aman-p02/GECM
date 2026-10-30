<?php
// Set Page Variables
$page_title = "Mechanical Engineering Department - Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/mechanical/css/department.css";
$extra_js = "departments/mechanical/js/department.js";

// Include Header
include_once __DIR__ . '/../../includes/header.php';
?>

<!-- Clean Dignified Institutional Department Header -->
<div class="dept-header-banner">
    <div class="container">
        <nav class="dept-breadcrumb-nav" aria-label="Breadcrumb">
            <a href="<?= $root_path ?>">Home</a>
            <span class="sep">/</span>
            <a href="<?= $root_path ?>#departments">Departments</a>
            <span class="sep">/</span>
            <span class="active-page">Mechanical Engineering</span>
        </nav>
        <div class="dept-header-title-row">
            <div class="dept-title-group">
                <span class="dept-pre-title">Academic Department</span>
                <h1 class="dept-main-heading">Mechanical Engineering</h1>
                <p class="dept-lead-summary">
                    NBA Accredited program educating mechanical engineers in thermodynamics, manufacturing processes, robotics, and machine design since 1989.
                </p>
            </div>
            <div class="dept-quick-meta">
                <div class="dept-meta-item"><i class="fas fa-calendar-alt"></i> Established 1989</div>
                <div class="dept-meta-item"><i class="fas fa-university"></i> GTU Affiliated &amp; AICTE Approved</div>
                <div class="dept-meta-item"><i class="fas fa-users"></i> Intake: 60 UG (NBA Accredited)</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Two-Column Layout -->
<div class="dept-page-wrapper">
    <div class="container">
        <div class="dept-layout-grid">

            <!-- Left Navigation Sidebar -->
            <aside class="dept-sidebar" aria-label="Department Sections">
                <div class="dept-sidebar-box">
                    <div class="dept-sidebar-title-bar">
                        <h3>Mechanical Dept</h3>
                    </div>
                    <ul class="dept-sidebar-menu" role="tablist">
                        <li class="active">
                            <a class="dept-nav-link active" data-tab="about" role="tab" aria-selected="true">
                                <span>About Department</span>
                            </a>
                        </li>
                        <li>
                            <a class="dept-nav-link" data-tab="vision-mission" role="tab" aria-selected="false">
                                <span>Vision &amp; Mission</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="dept-nav-link" aria-label="GTU Syllabus Portal">
                                <span>Syllabus</span>
                                <i class="fas fa-external-link-alt ext-arrow"></i>
                            </a>
                        </li>
                        <li>
                            <a class="dept-nav-link" data-tab="faculty" role="tab" aria-selected="false">
                                <span>Faculty</span>
                            </a>
                        </li>
                        <li>
                            <a class="dept-nav-link" data-tab="activities" role="tab" aria-selected="false">
                                <span>Activities</span>
                            </a>
                        </li>
                        <li>
                            <a class="dept-nav-link" data-tab="facilities" role="tab" aria-selected="false">
                                <span>Facilities</span>
                            </a>
                        </li>
                        <li>
                            <a class="dept-nav-link" data-tab="publications" role="tab" aria-selected="false">
                                <span>Publications</span>
                            </a>
                        </li>
                        <li class="dept-sidebar-dropdown closed" id="sidebar-iab">
                            <div class="dept-dropdown-toggle" role="button" tabindex="0" aria-expanded="false">
                                <span>Industry Advisory Board</span>
                                <i class="fas fa-chevron-right chevron-icon"></i>
                            </div>
                            <ul class="dept-sub-menu">
                                <li>
                                    <a class="dept-sub-link" data-tab="iab-2025-26" href="#iab-2025-26">IAB 2025-26</a>
                                </li>
                                <li>
                                    <a class="dept-sub-link" data-tab="iab-2023-24" href="#iab-2023-24">IAB 2023-24</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dept-sidebar-dropdown closed" id="sidebar-newsletters">
                            <div class="dept-dropdown-toggle" role="button" tabindex="0" aria-expanded="false">
                                <span>News Letters</span>
                                <i class="fas fa-chevron-right chevron-icon"></i>
                            </div>
                            <ul class="dept-sub-menu">
                                <li>
                                    <a class="dept-sub-link" data-tab="nl-vol1-issue2" href="#nl-vol1-issue2">Vol. 1 Issue 2</a>
                                </li>
                                <li>
                                    <a class="dept-sub-link" data-tab="nl-vol1-issue1" href="#nl-vol1-issue1">Vol. 1 Issue 1</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Right Content Area -->
            <main class="dept-content-panel">

                <!-- 1. ABOUT DEPARTMENT TAB -->
                <section class="dept-tab-content active" id="tab-about">
                    <h2 class="content-section-title">About the Department</h2>

                    <p class="content-lead-para">
                        The Department of Mechanical Engineering at Government Engineering College, Modasa has been delivering quality engineering education since 2001. Equipped with high-speed campus networking, advanced computing servers, and industry-oriented laboratory environments.
                    </p>

                    <!-- Key Facts Strip -->
                    <div class="dept-facts-strip">
                        <div class="dept-fact-card">
                            <span class="dept-fact-num">2001</span>
                            <h4>Established Year</h4>
                            <p>Continuous excellence in technical education and software research.</p>
                        </div>
                        <div class="dept-fact-card">
                            <span class="dept-fact-num">138</span>
                            <h4>Total Annual Intake</h4>
                            <p>120 Seats in Undergraduate (B.E.) + 18 Seats in Postgraduate (M.E.).</p>
                        </div>
                        <div class="dept-fact-card">
                            <span class="dept-fact-num">10</span>
                            <h4>Modern Laboratories</h4>
                            <p>Dedicated computing labs for software engineering, AI, and systems.</p>
                        </div>
                        <div class="dept-fact-card">
                            <span class="dept-fact-num">250+</span>
                            <h4>Networked Workstations</h4>
                            <p>Campus-wide gigabit LAN with 30 enterprise-grade Wi-Fi access points.</p>
                        </div>
                    </div>

                    <p class="content-body-para">
                        The department has developed laboratories in core and emerging areas such as Computer Hardware, Computer Networking &amp; Security, Database Management Systems, Computer Graphics, Cloud Computing, and Artificial Intelligence in tune with real-time industrial standards.
                    </p>

                    <p class="content-body-para">
                        Mechanical Engineering and Information Technology departments operate in a newly constructed, well-furnished academic block. The main strength of the department is its highly qualified, experienced faculty members. Two dedicated seminar halls and central computing servers facilitate technical symposia, research workshops, and expert guest sessions.
                    </p>

                    <!-- Academic Programmes Table -->
                    <div class="dept-table-container">
                        <div class="dept-table-header-bar">
                            Academic Programmes Offered
                        </div>
                        <table class="dept-data-table">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Level</th>
                                    <th>Duration</th>
                                    <th>Approved Intake</th>
                                    <th>Established</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>B.E. Mechanical Engineering</strong></td>
                                    <td><span class="table-tag table-tag-ug">UG</span></td>
                                    <td>4 Years</td>
                                    <td><strong>120</strong></td>
                                    <td>2001</td>
                                </tr>
                                <tr>
                                    <td><strong>M.E. Computer Science &amp; Engineering</strong></td>
                                    <td><span class="table-tag table-tag-pg">PG</span></td>
                                    <td>2 Years</td>
                                    <td><strong>18</strong></td>
                                    <td>2010</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- 2. VISION & MISSION TAB -->
                <section class="dept-tab-content" id="tab-vision-mission">
                    <h2 class="content-section-title">Vision &amp; Mission</h2>

                    <div class="vm-editorial-block">
                        <div class="vm-section-item">
                            <h3 class="vm-title-label">Department Vision</h3>
                            <p class="vm-content-text">
                                To become a prominent department producing competent professionals with research, innovation and entrepreneurial skills, inculcating moral values and societal concerns.
                            </p>
                        </div>

                        <div class="vm-section-item">
                            <h3 class="vm-title-label">Department Mission</h3>
                            <ul class="mission-numbered-list">
                                <li>
                                    <span class="mission-num-badge">M1</span>
                                    <span>To create globally competent students having ability to design, develop and test world-class software, keeping pace with latest technological developments.</span>
                                </li>
                                <li>
                                    <span class="mission-num-badge">M2</span>
                                    <span>Create facilities and expertise in advanced computer technology, thereby promoting cutting-edge research.</span>
                                </li>
                                <li>
                                    <span class="mission-num-badge">M3</span>
                                    <span>Enhance Industry Institute Interaction programme to get students thoroughly acquainted with modern corporate culture.</span>
                                </li>
                                <li>
                                    <span class="mission-num-badge">M4</span>
                                    <span>Induce moral, ethical values and spirit of active social commitment.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Program Educational Objectives -->
                    <div class="dept-table-container">
                        <div class="dept-table-header-bar">
                            Program Educational Objectives (PEOs)
                        </div>
                        <table class="dept-data-table">
                            <thead>
                                <tr>
                                    <th style="width: 100px;">Identifier</th>
                                    <th>Objective Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>PEO 1</strong></td>
                                    <td>Be an efficient software developer in diverse fields and become a successful professional and/or pursue higher studies.</td>
                                </tr>
                                <tr>
                                    <td><strong>PEO 2</strong></td>
                                    <td>Be capable of adapting to advanced computing technology for professional excellence, research, and lifelong learning.</td>
                                </tr>
                                <tr>
                                    <td><strong>PEO 3</strong></td>
                                    <td>Work productively exhibiting ethical qualities for the betterment of society.</td>
                                </tr>
                                <tr>
                                    <td><strong>PEO 4</strong></td>
                                    <td>Possess leadership and entrepreneurial qualities, working harmoniously as a team member with effective communication skills.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Program Specific Outcomes -->
                    <div class="dept-table-container">
                        <div class="dept-table-header-bar">
                            Program Specific Outcomes (PSOs)
                        </div>
                        <table class="dept-data-table">
                            <thead>
                                <tr>
                                    <th style="width: 100px;">Identifier</th>
                                    <th>Outcome Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>PSO 1</strong></td>
                                    <td>Gain capability to use current and advanced technology, skills, and tools necessary for carrying out real-world multidisciplinary projects.</td>
                                </tr>
                                <tr>
                                    <td><strong>PSO 2</strong></td>
                                    <td>Achieve an ability to build a computer-based system, process, or component that meets desired technical and societal needs.</td>
                                </tr>
                                <tr>
                                    <td><strong>PSO 3</strong></td>
                                    <td>Apply concepts of core areas—Data Structures, Database Management Systems, Operating Systems, Computer Architecture, and Software Engineering—to provide innovative solutions.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- 3. FACULTY TAB -->
                <section class="dept-tab-content" id="tab-faculty">
                    <h2 class="content-section-title">Faculty Members</h2>

                    <p class="content-body-para">
                        The department has a team of experienced and dedicated faculty members specializing across software systems, network security, data engineering, and artificial intelligence.
                    </p>

                    <div class="faculty-card-grid">
                        <div class="faculty-person-card">
                            <div class="faculty-person-header">
                                <div class="faculty-initials-avatar">HP</div>
                                <div class="faculty-title-group">
                                    <h4>Dr. B. C. Patel</h4>
                                    <span class="faculty-role-title">Head of Department &amp; Professor</span>
                                </div>
                            </div>
                            <div class="faculty-degrees">Ph.D., M.Tech (Mechanical Engineering)</div>
                            <a href="mailto:hod_ce@gecmodasa.ac.in" class="faculty-contact-link"><i class="fas fa-envelope"></i> hod_ce@gecmodasa.ac.in</a>
                        </div>

                        <div class="faculty-person-card">
                            <div class="faculty-person-header">
                                <div class="faculty-initials-avatar">AS</div>
                                <div class="faculty-title-group">
                                    <h4>Prof. A. S. Shah</h4>
                                    <span class="faculty-role-title">Associate Professor</span>
                                </div>
                            </div>
                            <div class="faculty-degrees">Ph.D. (Pursuing), M.E. (Mechanical Engineering)</div>
                            <a href="mailto:asshah@gecmodasa.ac.in" class="faculty-contact-link"><i class="fas fa-envelope"></i> asshah@gecmodasa.ac.in</a>
                        </div>

                        <div class="faculty-person-card">
                            <div class="faculty-person-header">
                                <div class="faculty-initials-avatar">RP</div>
                                <div class="faculty-title-group">
                                    <h4>Prof. R. K. Prajapati</h4>
                                    <span class="faculty-role-title">Assistant Professor</span>
                                </div>
                            </div>
                            <div class="faculty-degrees">M.E. (Computer Science &amp; Engineering)</div>
                            <a href="mailto:rkprajapati@gecmodasa.ac.in" class="faculty-contact-link"><i class="fas fa-envelope"></i> rkprajapati@gecmodasa.ac.in</a>
                        </div>

                        <div class="faculty-person-card">
                            <div class="faculty-person-header">
                                <div class="faculty-initials-avatar">PM</div>
                                <div class="faculty-title-group">
                                    <h4>Prof. P. N. Mehta</h4>
                                    <span class="faculty-role-title">Assistant Professor</span>
                                </div>
                            </div>
                            <div class="faculty-degrees">M.Tech (Software Engineering)</div>
                            <a href="mailto:pnmehta@gecmodasa.ac.in" class="faculty-contact-link"><i class="fas fa-envelope"></i> pnmehta@gecmodasa.ac.in</a>
                        </div>

                        <div class="faculty-person-card">
                            <div class="faculty-person-header">
                                <div class="faculty-initials-avatar">SJ</div>
                                <div class="faculty-title-group">
                                    <h4>Prof. S. D. Joshi</h4>
                                    <span class="faculty-role-title">Assistant Professor</span>
                                </div>
                            </div>
                            <div class="faculty-degrees">M.E. (Mechanical Engineering)</div>
                            <a href="mailto:sdjoshi@gecmodasa.ac.in" class="faculty-contact-link"><i class="fas fa-envelope"></i> sdjoshi@gecmodasa.ac.in</a>
                        </div>

                        <div class="faculty-person-card">
                            <div class="faculty-person-header">
                                <div class="faculty-initials-avatar">MP</div>
                                <div class="faculty-title-group">
                                    <h4>Prof. M. B. Patel</h4>
                                    <span class="faculty-role-title">Assistant Professor</span>
                                </div>
                            </div>
                            <div class="faculty-degrees">M.Tech (Information Technology)</div>
                            <a href="mailto:mbpatel@gecmodasa.ac.in" class="faculty-contact-link"><i class="fas fa-envelope"></i> mbpatel@gecmodasa.ac.in</a>
                        </div>
                    </div>
                </section>

                <!-- 4. ACTIVITIES TAB -->
                <section class="dept-tab-content" id="tab-activities">
                    <h2 class="content-section-title">Department Activities</h2>

                    <p class="content-body-para">
                        The department regularly organizes technical workshops, competitive hackathons, industrial visits, and expert masterclasses to keep students aligned with current software industry practices.
                    </p>

                    <div class="document-card-grid">
                        <div class="document-item-card">
                            <h4>CodeFest &amp; Hackathons</h4>
                            <p>Annual inter-college coding marathon encouraging students to build innovative software solutions for real-world governance and societal challenges.</p>
                        </div>
                        <div class="document-item-card">
                            <h4>Expert Technical Seminars</h4>
                            <p>Interactive sessions delivered by senior software engineers on Cloud Computing, Cyber Security, DevOps pipelines, and AI systems.</p>
                        </div>
                        <div class="document-item-card">
                            <h4>Industrial Study Visits</h4>
                            <p>Field visits to leading technical organizations like BISAG-N Gandhinagar, TCS Garima Park, and ISRO Space Applications Centre.</p>
                        </div>
                    </div>
                </section>

                <!-- 5. FACILITIES TAB -->
                <section class="dept-tab-content" id="tab-facilities">
                    <h2 class="content-section-title">Laboratories &amp; Facilities</h2>

                    <div class="facilities-filter-row">
                        <button type="button" class="facility-tab-pill active" data-subtab="labs">Laboratories</button>
                        <button type="button" class="facility-tab-pill" data-subtab="seminar">Seminar Room</button>
                        <button type="button" class="facility-tab-pill" data-subtab="server">Server Facility</button>
                    </div>

                    <div class="facility-pane active" id="subtab-labs">
                        <div class="lab-entry-list">
                            <!-- Lab 1: 8112 Project Lab -->
                            <div class="lab-entry-row">
                                <div class="lab-photo-frame">
                                    <img src="images/labs/lab_8112_project.jpg" alt="8112 Project Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                                </div>
                                <div class="lab-details-frame">
                                    <span class="lab-room-tag">Room 8112</span>
                                    <h3>Project &amp; Research Laboratory</h3>
                                    <p>Dedicated to final year capstone projects and multidisciplinary innovations. Equipped with modern workstations, hardware test benches, and continuous internet connectivity.</p>
                                </div>
                            </div>

                            <!-- Lab 2: 8113 Programming Lab 1 -->
                            <div class="lab-entry-row">
                                <div class="lab-photo-frame">
                                    <img src="images/labs/lab_8113_programming1.jpg" alt="8113 Programming Lab 1" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                                </div>
                                <div class="lab-details-frame">
                                    <span class="lab-room-tag">Room 8113</span>
                                    <h3>Programming Laboratory - 1</h3>
                                    <p>Utilized for Database Management Systems (DBMS), Operating Systems, Software Engineering, and Python programming practicals.</p>
                                </div>
                            </div>

                            <!-- Lab 3: 8115 Hardware Lab -->
                            <div class="lab-entry-row">
                                <div class="lab-photo-frame">
                                    <img src="images/labs/lab_8115_hardware.jpg" alt="8115 Hardware Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                                </div>
                                <div class="lab-details-frame">
                                    <span class="lab-room-tag">Room 8115</span>
                                    <h3>Computer Hardware &amp; Networking Lab</h3>
                                    <p>Facilitates hands-on experiments in Digital Logic Design, Microprocessors, Computer Organization, Network Protocols, and IoT sensor kits.</p>
                                </div>
                            </div>

                            <!-- Lab 4: 8116 PPS Lab 2 -->
                            <div class="lab-entry-row">
                                <div class="lab-photo-frame">
                                    <img src="images/labs/lab_8116_pps2.jpg" alt="8116 PPS Lab 2" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                                </div>
                                <div class="lab-details-frame">
                                    <span class="lab-room-tag">Room 8116</span>
                                    <h3>Programming for Problem Solving Lab - 2</h3>
                                    <p>Designed for first-year engineering students to develop foundational algorithmic problem-solving skills using C, C++, and basic data structures.</p>
                                </div>
                            </div>

                            <!-- Lab 5: 8117 Programming Lab 3 -->
                            <div class="lab-entry-row">
                                <div class="lab-photo-frame">
                                    <img src="images/labs/lab_8117_programming3.jpg" alt="8117 Programming Lab 3" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                                </div>
                                <div class="lab-details-frame">
                                    <span class="lab-room-tag">Room 8117</span>
                                    <h3>Advanced Computing Laboratory - 3</h3>
                                    <p>Equipped with high-performance systems for Web Engineering, Compiler Construction, Full-Stack Development, and Machine Learning workflows.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="facility-pane" id="subtab-seminar">
                        <div class="lab-entry-row">
                            <div class="lab-photo-frame">
                                <img src="images/labs/seminar_room.jpg" alt="Department Seminar Hall" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                            </div>
                            <div class="lab-details-frame">
                                <span class="lab-room-tag">Seminar Hall</span>
                                <h3>Department Seminar &amp; Conference Hall</h3>
                                <p>Air-conditioned presentation space equipped with multimedia projection, high-definition audio, and video-conferencing equipment for academic seminars and workshops.</p>
                            </div>
                        </div>
                    </div>

                    <div class="facility-pane" id="subtab-server">
                        <p class="content-lead-para">
                            <strong>Central Campus Server Room:</strong> Managed rack-mounted computing servers, central network controllers, and enterprise optical distribution equipment ensuring high-uptime connectivity across the institute.
                        </p>
                    </div>
                </section>

                <!-- 6. PUBLICATIONS TAB -->
                <section class="dept-tab-content" id="tab-publications">
                    <h2 class="content-section-title">Faculty Publications</h2>

                    <div class="academic-pub-list">
                        <div class="academic-pub-card">
                            <div class="pub-headline">Deep Learning Approaches for Real-Time Network Intrusion Detection in IoT Networks</div>
                            <div class="pub-meta-line">Dr. B. C. Patel, Prof. A. S. Shah (2024)</div>
                            <div class="pub-source-line">International Journal of Information and Computer Security, Vol. 18, Issue 3</div>
                        </div>
                        <div class="academic-pub-card">
                            <div class="pub-headline">An Efficient Cryptographic Framework for Cloud Data Integrity Verification</div>
                            <div class="pub-meta-line">Prof. R. K. Prajapati, Dr. B. C. Patel (2023)</div>
                            <div class="pub-source-line">IEEE International Conference on Advanced Computing Technologies (ICACT)</div>
                        </div>
                        <div class="academic-pub-card">
                            <div class="pub-headline">Performance Optimization in Distributed Microservices Architecture</div>
                            <div class="pub-meta-line">Prof. P. N. Mehta (2023)</div>
                            <div class="pub-source-line">Springer Communications in Computer and Information Science, Vol. 1422</div>
                        </div>
                        <div class="academic-pub-card">
                            <div class="pub-headline">Comparative Analysis of Machine Learning Algorithms for Brain-Computer Interface Applications</div>
                            <div class="pub-meta-line">Prof. S. D. Joshi, Prof. M. B. Patel (2022)</div>
                            <div class="pub-source-line">Elsevier Procedia Computer Science, Vol. 218</div>
                        </div>
                    </div>
                </section>

                <!-- 7. IAB 2025-26 TAB -->
                <section class="dept-tab-content" id="tab-iab-2025-26">
                    <h2 class="content-section-title">Industry Advisory Board (2025-26)</h2>

                    <p class="content-body-para">
                        The Industry Advisory Board provides strategic direction to ensure that the department curriculum, laboratory experiments, and student projects align with contemporary software industry needs.
                    </p>

                    <div class="dept-table-container">
                        <table class="dept-data-table">
                            <thead>
                                <tr>
                                    <th>Member Name</th>
                                    <th>Designation / Organization</th>
                                    <th>Role in IAB</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Dr. B. C. Patel</strong></td>
                                    <td>Head of Department, Mechanical Engineering, GEC Modasa</td>
                                    <td>Chairman</td>
                                </tr>
                                <tr>
                                    <td><strong>Mr. Nirav Joshi</strong></td>
                                    <td>Senior Cloud Architect, Tata Consultancy Services (TCS)</td>
                                    <td>Industry Member</td>
                                </tr>
                                <tr>
                                    <td><strong>Ms. Pooja Sharma</strong></td>
                                    <td>Lead Data Scientist, Infosys Limited</td>
                                    <td>Industry Member</td>
                                </tr>
                                <tr>
                                    <td><strong>Prof. A. S. Shah</strong></td>
                                    <td>Associate Professor, Mechanical Engineering, GEC Modasa</td>
                                    <td>Member Secretary</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- 8. IAB 2023-24 TAB -->
                <section class="dept-tab-content" id="tab-iab-2023-24">
                    <h2 class="content-section-title">Industry Advisory Board (2023-24)</h2>

                    <div class="dept-table-container">
                        <table class="dept-data-table">
                            <thead>
                                <tr>
                                    <th>Member Name</th>
                                    <th>Designation / Organization</th>
                                    <th>Role in IAB</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Dr. B. C. Patel</strong></td>
                                    <td>Head of Department, Mechanical Engineering, GEC Modasa</td>
                                    <td>Chairman</td>
                                </tr>
                                <tr>
                                    <td><strong>Mr. Rajesh Vaghela</strong></td>
                                    <td>VP Engineering, eInfochips</td>
                                    <td>Industry Member</td>
                                </tr>
                                <tr>
                                    <td><strong>Prof. R. K. Prajapati</strong></td>
                                    <td>Assistant Professor, Mechanical Engineering, GEC Modasa</td>
                                    <td>Member Secretary</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- 9. NEWS LETTERS (Vol. 1 Issue 2) -->
                <section class="dept-tab-content" id="tab-nl-vol1-issue2">
                    <h2 class="content-section-title">Department Newsletter (Vol. 1 Issue 2)</h2>

                    <div class="document-item-card" style="max-width: 500px;">
                        <h4>MechE Chronicle — Volume 1, Issue 2</h4>
                        <p>Features departmental highlights, student achievements in national hackathons, faculty research papers, and technical seminars.</p>
                        <a href="#" class="doc-download-action"><i class="fas fa-file-pdf"></i> Download Newsletter (PDF)</a>
                    </div>
                </section>

                <!-- 10. NEWS LETTERS (Vol. 1 Issue 1) -->
                <section class="dept-tab-content" id="tab-nl-vol1-issue1">
                    <h2 class="content-section-title">Department Newsletter (Vol. 1 Issue 1)</h2>

                    <div class="document-item-card" style="max-width: 500px;">
                        <h4>MechE Chronicle — Volume 1, Issue 1</h4>
                        <p>Inaugural issue documenting department milestones, laboratory modernizations, and alumni placements.</p>
                        <a href="#" class="doc-download-action"><i class="fas fa-file-pdf"></i> Download Newsletter (PDF)</a>
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