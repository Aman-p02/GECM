<?php
// Set Page Variables
$page_title = "Information Technology Department - Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/information-technology/css/department.css";
$extra_js = "departments/information-technology/js/department.js";

// Include Header
include_once __DIR__ . '/../../includes/header.php';
?>

<!-- ========================================================
     Main Department Section (Information Technology)
     ======================================================== -->
<div class="dept-page-wrapper">
    <div class="container">
        <div class="dept-layout-grid">

            <!-- Left Sidebar Navigation -->
            <aside class="dept-sidebar">
                <div class="dept-sidebar-header">
                    Information Technology
                </div>
                <ul class="dept-sidebar-menu">
                    <li class="active">
                        <a class="dept-nav-link active" data-tab="about">About Department</a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="vision-mission">Vision &amp; Mission</a>
                    </li>
                    <li>
                        <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="dept-nav-link">
                            <span>Syllabus</span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="faculty">Faculty</a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="activities">Activities</a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="facilities">Facilities</a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="publications">Publications</a>
                    </li>
                    <li class="dept-sidebar-dropdown closed" id="sidebar-iab">
                        <div class="dept-dropdown-header" role="button" tabindex="0">
                            <span>Industry Advisory Board</span>
                            <i class="fas fa-chevron-right dropdown-arrow"></i>
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
                        <div class="dept-dropdown-header" role="button" tabindex="0">
                            <span>News Letters</span>
                            <i class="fas fa-chevron-right dropdown-arrow"></i>
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
            </aside>

            <!-- Right Content Area -->
            <main class="dept-content-panel">

                <!-- ========================================================
                     1. ABOUT DEPARTMENT TAB
                     ======================================================== -->
                <section class="dept-tab-content active" id="tab-about">
                    <div class="dept-divider-title">About Department</div>

                    <p class="dept-text-body">
                        This department is running since 1999. The staff has developed required laboratories in the areas like Computer Hardware, Computer Networking &amp; Security, Database Management System, Computer Graphics and Internet Technology in tune with real-time systems. The IT Department is equipped with around 100+ computers with multimedia software and LAN Systems with Internet connection.
                    </p>

                    <p class="dept-text-body">
                        The internet access is provided to the students to update their knowledge in the various fields.The campus-wide area network is managed through this department.
                    </p>

                    <p class="dept-text-body">
                        Computer Engineering and Information Technology department run in a newly constructed, well-furnished building. The main strength of the department is highly qualified and well-experienced faculties. Also, the department is well equipped with an ample number of computer systems, networking of more than 250 nodes and required software and hardware. Department has well equipped 10 computer laboratories and two seminar halls. Campus Wide Network of college is handled by the department with 30 Wi-Fi access points with 1 controller. It has High-End Servers available for various activities.
                    </p>

                    <div class="dept-divider-title">About the Programme</div>

                    <p class="dept-text-body">
                        The field of information technology (IT) covers the design, administration and support of computer and telecommunications systems. Some of the positions in this field include database and network administrators, computer support specialists, computer scientists, software programmers and system analysts. The majority of career tracks in IT entail design and operational tasks related to computer hardware components, networks and software applications.
                    </p>

                    <p class="dept-text-body">
                        Professionals in the IT field work with businesses and organizations to set up and support viable computer networks that will keep systems efficient and reliable. IT encompasses all hardware and software used in the storing, creation and accessing of information. Examples of technologies that professionals work with are firewalls, databases, media storage devices, networks and the Internet.
                    </p>

                    <p class="dept-text-body">
                        Aspiring IT professionals typically need a bachelor's degree in a technology field, such as computer science, information systems management, programming or networking. Even without a degree, experience in an entry-level help desk position could help IT professionals advance with professional certification or vocational training. The fundamentals of a degree program generally include computer hardware, programming, networking, and technical theory. Depending on the major, students could also learn IT management, website development, computer circuitry, systems analysis and database management. Some programs also include internship opportunities. To work as a computer research scientist, a Ph.D. degree is often necessary.
                    </p>

                    <!-- Under Graduate/Post Graduate Courses Table -->
                    <div class="courses-card">
                        <div class="courses-card-header">
                            <i class="fas fa-bars"></i>
                            <span>Under Graduate/Post Graduate Courses</span>
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table">
                                <thead>
                                    <tr>
                                        <th>Name of Course</th>
                                        <th>Type</th>
                                        <th>Period (Years)</th>
                                        <th>Intake</th>
                                        <th>Year of Starting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Information Technology</strong></td>
                                        <td>UG</td>
                                        <td>4</td>
                                        <td>120</td>
                                        <td>1999</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Facilities Dual Column List -->
                    <div class="dept-divider-title">Facilities</div>

                    <div class="dept-facilities-dual-grid">
                        <ul class="facility-items-list">
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Wi-Fi enabled Department</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>System Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Android Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Appl. Development Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>DLD Lab</span></li>
                        </ul>
                        <ul class="facility-items-list">
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Campus Wide Fiber Optic Cable Network</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Network Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Advance Project Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>DBMS Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Operating System Lab</span></li>
                        </ul>
                    </div>
                </section>

                <!-- ========================================================
                     2. VISION & MISSION TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-vision-mission">
                    <div class="dept-divider-title">Vision</div>

                    <div class="vision-quote-box">
                        To become a prominent department producing technically competent and skilled intellectual IT professionals with research, innovation and entrepreneurial skills, inculcating moral values and societal concerns.
                    </div>

                    <div class="dept-divider-title">Mission</div>

                    <ul class="mission-bullet-list">
                        <li>To create globally competent students having ability to provide technical solutions in the field of Information Technology.</li>
                        <li>To create facilities and expertise in the field of Information Technology where students and faculty can enhance their understanding of technology.</li>
                        <li>To enhance industry institute interaction programme to get acquainted with corporate culture.</li>
                        <li>To induce moral, ethical values and spirit of social commitment.</li>
                    </ul>

                    <!-- Program Educational Objectives PEOs Table -->
                    <div class="courses-card">
                        <div class="courses-card-header">
                            <i class="fas fa-bars"></i>
                            <span>Program Educational Objectives PEOs</span>
                        </div>
                        <div class="peo-intro-banner">
                            Graduates will,
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table peo-pso-table">
                                <tbody>
                                    <tr>
                                        <td class="peo-code-cell"><strong>PEO1</strong></td>
                                        <td>Be prepared to gain employment as a successful IT professional and/or pursue higher studies.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-code-cell"><strong>PEO2</strong></td>
                                        <td>Be capable to adapt advanced state of the art Information technology for professional excellence and Research and be a lifelong learner.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-code-cell"><strong>PEO3</strong></td>
                                        <td>work productively exhibiting ethical qualities for the betterment of society.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-code-cell"><strong>PEO4</strong></td>
                                        <td>possess leadership and entrepreneurial qualities, work harmoniously as a team member with effective communication skills.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Program Specific Outcomes PSOs Table -->
                    <div class="courses-card">
                        <div class="courses-card-header">
                            <i class="fas fa-bars"></i>
                            <span>Program Specific Outcomes PSOs</span>
                        </div>
                        <div class="peo-intro-banner">
                            Information Technology Graduate will be able to:
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table peo-pso-table">
                                <tbody>
                                    <tr>
                                        <td class="peo-code-cell"><strong>PSO1</strong></td>
                                        <td>Effectively integrate IT-based solutions into the user environment.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-code-cell"><strong>PSO2</strong></td>
                                        <td>Possess professional skill set of software design process using open source technologies.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-code-cell"><strong>PSO3</strong></td>
                                        <td>Apply concepts of core areas of Information Technology- Data Structures, Database Management Systems, Operating Systems, Computer Network and Software Engineering to provide innovative solution.</td>
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
                    <div class="dept-divider-title">Faculty Members</div>

                    <p class="dept-text-body">
                        The Information Technology Department is backed by dedicated, highly qualified faculties committed to academic excellence and research.
                    </p>

                    <div class="row g-3 my-3">
                        <div class="col-12">
                            <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 6px; padding: 36px 20px; text-align: center;">
                                <i class="fas fa-users-cog fa-3x text-primary mb-3"></i>
                                <h4 style="font-size: 1.15rem; color: #1e293b; margin-bottom: 6px;">Information Technology Faculty Profiles</h4>
                                <p style="color: #64748b; font-size: 0.90rem; margin: 0;">Faculty details will be updated here as soon as provided.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     4. ACTIVITIES TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-activities">
                    <div class="dept-divider-title">Department Activities</div>

                    <p class="dept-text-body">
                        Seminars, workshops, technical webinars, industrial visits, and expert lectures organized by the Information Technology Department.
                    </p>

                    <div class="row g-3 my-3">
                        <div class="col-12">
                            <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 6px; padding: 36px 20px; text-align: center;">
                                <i class="fas fa-calendar-check fa-3x text-primary mb-3"></i>
                                <h4 style="font-size: 1.15rem; color: #1e293b; margin-bottom: 6px;">Workshops &amp; Technical Events</h4>
                                <p style="color: #64748b; font-size: 0.90rem; margin: 0;">Departmental activity records and event photos will be updated here.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     5. FACILITIES TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-facilities">
                    <div class="dept-divider-title">Facilities</div>

                    <!-- Segmented Sub-tabs Matching Screenshot -->
                    <div class="facility-tabs-container">
                        <div class="facility-segmented-tabs">
                            <button type="button" class="facility-tab-btn active" data-subtab="laboratories">
                                <i class="fas fa-desktop"></i> Laboratories <span class="tab-count-badge">5</span>
                            </button>
                            <button type="button" class="facility-tab-btn" data-subtab="seminar">
                                <i class="fas fa-chalkboard-teacher"></i> Seminar Room
                            </button>
                        </div>
                    </div>

                    <!-- ================= SUBTAB 1: LABORATORIES ================= -->
                    <div class="facility-pane active" id="subtab-laboratories">
                        <p class="facility-lead-intro">
                            There are total 10 laboratories in the department for performing practical in various domains like Computer Programming, Computer Graphics, Networking, Database Management, Operating Systems, Artificial Intelligence, etc. Department has a separate laboratory for computer hardware subjects.
                        </p>

                        <div class="modern-labs-stack">

                            <!-- Lab 1: 8212 Project Lab -->
                            <article class="modern-lab-card">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8212_project.jpg" alt="8212 Project Lab" class="modern-photo-img" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="modern-photo-placeholder" style="display: none;">
                                        <span>Photo Space</span>
                                    </div>
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8212</span>
                                    <h3 class="modern-lab-title">Project Lab</h3>
                                    <p class="modern-lab-text">
                                        This lab is dedicatedly used for project and design engineering. Sufficient number of laptop points and other required infrastructure is available in this lab.
                                    </p>
                                </div>
                            </article>

                            <!-- Lab 2: 8213 Programming Lab - 1 -->
                            <article class="modern-lab-card modern-lab-card-reverse">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/8213-lab.png" alt="8213 Programming Lab - 1" class="modern-photo-img" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="modern-photo-placeholder" style="display: none;">
                                        <span>Photo Space</span>
                                    </div>
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8213</span>
                                    <h3 class="modern-lab-title">Programming Lab - 1</h3>
                                    <p class="modern-lab-text">
                                        The department is having programming lab for students where they can perform their experiments. This lab contains number of Computers with Internet connection. This lab is dedicatedly used for subjects such as DBMS, OS, CG, CoS, SE, Compiler Design and Python.
                                    </p>
                                </div>
                            </article>

                            <!-- Lab 3: 8215 Programming Lab - 2 -->
                            <article class="modern-lab-card">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8215_programming2.jpg" alt="8215 Programming Lab - 2" class="modern-photo-img" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="modern-photo-placeholder" style="display: none;">
                                        <span>Photo Space</span>
                                    </div>
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8215</span>
                                    <h3 class="modern-lab-title">Programming Lab - 2</h3>
                                    <p class="modern-lab-text">
                                        The department is having programming lab for students where they can perform their experiments. This lab contains number of Computers with Internet connection. This lab is dedicatedly used for hardware related subjects such as digital fundamentals, COA, CN, Blockchain and IoT.
                                    </p>
                                </div>
                            </article>

                            <!-- Lab 4: 8216 PPS Lab -->
                            <article class="modern-lab-card modern-lab-card-reverse">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8216_pps.jpg" alt="8216 PPS Lab" class="modern-photo-img" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="modern-photo-placeholder" style="display: none;">
                                        <span>Photo Space</span>
                                    </div>
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8216</span>
                                    <h3 class="modern-lab-title">PPS Lab</h3>
                                    <p class="modern-lab-text">
                                        The department is having Programming for Problem Solving lab for students where they can perform their PPS experiments. This lab contains number of Computers with Internet connection.
                                    </p>
                                </div>
                            </article>

                            <!-- Lab 5: 8217 Programming Lab - 3 -->
                            <article class="modern-lab-card">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8217_programming3.jpg" alt="8217 Programming Lab - 3" class="modern-photo-img" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="modern-photo-placeholder" style="display: none;">
                                        <span>Photo Space</span>
                                    </div>
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8217</span>
                                    <h3 class="modern-lab-title">Programming Lab - 3</h3>
                                    <p class="modern-lab-text">
                                        The department is having programming lab for students where they can perform their experiments. This lab contains number of Computers with Internet connection. This lab is dedicatedly used for software/hardware related subjects such as .Net, MCWC and cloud computing.
                                    </p>
                                </div>
                            </article>

                        </div>

                        <!-- Department Facilities Overview List -->
                        <div class="dept-divider-title mt-5">All Department Facilities Overview</div>
                        <div class="dept-facilities-dual-grid mb-4">
                            <ul class="facility-items-list">
                                <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Wi-Fi enabled Department</span></li>
                                <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>System Lab</span></li>
                                <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Android Lab</span></li>
                                <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Appl. Development Lab</span></li>
                                <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>DLD Lab</span></li>
                            </ul>
                            <ul class="facility-items-list">
                                <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Campus Wide Fiber Optic Cable Network</span></li>
                                <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Network Lab</span></li>
                                <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Advance Project Lab</span></li>
                                <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>DBMS Lab</span></li>
                                <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Operating System Lab</span></li>
                            </ul>
                        </div>
                    </div>

                    <!-- ================= SUBTAB 2: SEMINAR ROOM ================= -->
                    <div class="facility-pane" id="subtab-seminar">
                        <article class="modern-lab-card">
                            <div class="modern-photo-wrap">
                                <img src="images/labs/seminar_hall.jpg" alt="Department Seminar Hall" class="modern-photo-img" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="modern-photo-placeholder" style="display: none;">
                                    <span>Photo Space (Seminar Room)</span>
                                </div>
                            </div>
                            <div class="modern-lab-body">
                                <span class="modern-room-pill">Department Seminar Hall</span>
                                <h3 class="modern-lab-title">Department Seminar Hall</h3>
                                <p class="modern-lab-text">
                                    The Seminar Hall is a modern facility with high-end audio-visual projection equipment, sound system, and comfortable seating capacity for guest lectures, seminars, workshops, and project evaluations.
                                </p>
                            </div>
                        </article>
                    </div>
                </section>

                <!-- ========================================================
                     6. PUBLICATIONS TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-publications">
                    <div class="dept-divider-title">Publications</div>

                    <p class="dept-text-body">
                        Research papers, journal articles, and conference publications by faculties and students of the Information Technology Department.
                    </p>

                    <!-- Filter Bar & Count Badge (Year-Wise Filter) -->
                    <div class="publications-header-bar">
                        <div class="publications-filter-group">
                            <div class="publications-year-select-box">
                                <i class="far fa-calendar-alt select-calendar-icon"></i>
                                <select id="pubYearSelect" aria-label="Filter by Year">
                                    <option value="all">All Years (30)</option>
                                    <option value="2023">2023</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2008">2008</option>
                                </select>
                                <i class="fas fa-chevron-down select-chevron-icon"></i>
                            </div>
                        </div>
                        <div class="publications-count-badge" id="pubCountBadge">
                            <i class="fas fa-file-alt"></i> 30 Publications
                        </div>
                    </div>

                    <!-- Publications List Stack -->
                    <div class="publications-list-stack">

                        <!-- Publication 1 (2023) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Plant Pathology Detection for Massive Heterogeneous Data Using Deep Learning</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Avinash Chaudhari, Kuntesh Jani, Sunil Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2023</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 2 (2020) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Automatic abnormality detection system for capsule endoscopy</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Kuntesh K. Jani, Subodh Srivastava, Animesh Anand and Rajeev Srivastava</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2020</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 3 (2019) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Data Reduction Technique for Capsule Endoscopy</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Kuntesh Jani and Rajeev Srivastava</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2019</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 4 (2019) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Computer aided medical image analysis for capsule endoscopy using conventional machine learning and deep learning</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Kuntesh K. Jani, Subodh Srivastava, Animesh Anand and Rajeev Srivastava</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2019</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 5 (2019) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Computer aided medical image analysis for capsule endoscopy using multi-class classifier</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Kuntesh K. Jani, Subodh Srivastava and Rajeev Srivastava</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2019</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 6 (2019) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Computer-Aided Diagnosis for Capsule Endoscopy: From Inception to Future</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>KunteshK. Jani, Subodh Srivastava, Rajeev Srivastava</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2019</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 7 (2019) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Computer aided diagnosis system for ulcer detection in capsule endoscopy using optimized feature set</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Kuntesh K. Jani, Subodh Srivastava and Rajeev Srivastava</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2019</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 8 (2019) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Applying Parallel Design Patterns on Molecular Dynamics Simulation</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nilesh Maltare, Vithal N Kamat.</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2019</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 9 (2019) -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Survey on Medical Image Analysis in Capsule Endoscopy</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Kuntesh Ketan Jani, Rajeev Srivastava</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2019</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 10 (2019) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Deep Neural Network Model for Group Activity Recognition Using Contextual Relationship</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>S. A. Vahora and N. C. Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2019</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 11 (2018) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Group Activity Recognition Using Deep Autoencoder With Temporal Context Descriptor</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>S. A. Vahora and N. C. Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2018</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 12 (2018) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Android Smartphone based Visual Object Recognition for Visually Impaired using Deep Learning</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Neel Parikh, Ishita Shah, Safvan Vahora</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2018</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 13 (2017) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Prediction based Auto Scaling for Cloud Applications</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Prof.C.A.Patel , Prof. H.R.Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 14 (2017) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Gender Classification From Faces: A Survey</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Siddharth Shah, Gopi Bhatt and Safvan Vahora</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 15 (2017) -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Comprehensive Study of Group Activity Recognition Methods in Video</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>S. A. Vahora and N. C. Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 16 (2016) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Applying Parallel Design Patterns of Embarassingly Parallel Problem</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nilesh Maltare, Chetan Chudasama</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 17 (2016) -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Review on Forecasting Techniques for SLA Aware Elasticity in Cloud Computing</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Prof.C.A.Patel ,Prof.H.R.Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 18 (2015) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Crowd Behavior Analysis Using Fast Feature</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Kinjal Joshi and Safvan Vahora</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 19 (2015) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Experimenting Large Prime Numbers Generation in MPI Cluster</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nilesh Maltare, Chetan Chudasama</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 20 (2014) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Crowd Behavior Analysis</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Kinjal Joshi and Safvan Vahora</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2014</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 21 (2014) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Features for Parallel Pattern Based Programming System for Multicore</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nilesh Maltare</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2014</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 22 (2013) -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Survey On Super Resolution Image Reconstruction Techniques</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Krunal Shah, Jaymit Pandya and Safvan Vahora</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 23 (2012) -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Robust Method for Moving Object Detection Using Modified Statistical Mean Method</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Safvan Vahora, Narendra Chauhan, Nilesh Prajapati</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 24 (2012) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Moving Object Detection Using Incremental Statistical Mean Technique</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Safvan Vahora, Narendra Chauhan, Nilesh Prajapati</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 25 (2011) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Novel Approach: Naive Bayes with Vector Space Model for Spam Classification</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Safvan Vahora, Mosin Hasan, Reshma Lakhani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2011</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 26 (2010) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Case study on social engineering Techniques for persuasion</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mosin Hasan, Nilesh Prajapati, Safvan Vahora</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2010</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 27 (2010) -->
                        <article class="publication-card">
                            <h4 class="publication-title">A comparative analysis of different neural networks for face recognition using principal component analysis, wavelets and efficient variable learning rate</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nilesh Maltare, Raman Bhati, Sarika Jain</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2010</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 28 (2010) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Analysis of parallelism available in Neural Network training algorithm of face recognition</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nilesh Maltare, Raman Bhati, Sarika Jain</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2010</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 29 (2010) -->
                        <article class="publication-card">
                            <h4 class="publication-title">Exploiting UML in modeling Military Organization and Military Behavior</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nilesh Maltare, Aditya Parasrampuriya, Sachin Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2010</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 30 (2008) -->
                        <article class="publication-card">
                            <h4 class="publication-title">MANAGING DATA REPLICATION IN MOBILE AD-HOC NETWORK DATABASES USING CONTENT BASED ENERGY OPTIMIZATION</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nilesh Maltare, N.A. Khan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2008</span>
                                </div>
                            </div>
                        </article>

                    </div>
                </section>

                <!-- ========================================================
                     7. INDUSTRY ADVISORY BOARD SUB-OPTIONS & TABS
                     ======================================================== -->

                <!-- 7A. IAB 2025-26 Sub-tab -->
                <section class="dept-tab-content" id="tab-iab-2025-26">
                    <div class="dept-divider-title">Industry Advisory Board (IAB 2025-26)</div>

                    <p class="dept-text-body">
                        Official notifications, committee constitution, and proceedings of the Industry Advisory Board for academic session 2025-26.
                    </p>

                    <!-- PDF Viewer Container -->
                    <div class="dept-pdf-card">
                        <div class="dept-pdf-toolbar">
                            <div class="dept-pdf-toolbar-info">
                                <i class="fas fa-file-pdf dept-pdf-icon-badge"></i>
                                <div>
                                    <h4 class="dept-pdf-name">IAB 2025-26 Notification Document</h4>
                                    <span class="dept-pdf-sub">Government Engineering College, Modasa &bull; Official PDF Document</span>
                                </div>
                            </div>
                            <div class="dept-pdf-toolbar-actions">
                                <!-- USER: Put your PDF URL in href and src below -->
                                <a href="#" target="_blank" class="dept-pdf-btn dept-pdf-btn-open" title="Open in new tab / Fullscreen">
                                    <i class="fas fa-external-link-alt"></i> Fullscreen
                                </a>
                                <a href="#" download class="dept-pdf-btn dept-pdf-btn-download" title="Download PDF file">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                            </div>
                        </div>

                        <div class="dept-pdf-viewer-area">
                            <iframe src="" class="dept-pdf-iframe" id="pdf-iab-2025-26" title="IAB 2025-26 Document"></iframe>
                            <div class="dept-pdf-empty-state">
                                <div class="dept-pdf-empty-icon"><i class="fas fa-file-pdf"></i></div>
                                <h5>IAB 2025-26 PDF Document</h5>
                                <p>PDF file yahan display hoga. Aap PDF provide karenge to direct link ho jayega.</p>
                                <span class="badge bg-light text-dark border px-3 py-2"><i class="fas fa-info-circle text-primary"></i> Ready for your PDF file</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 7B. IAB 2023-24 Sub-tab -->
                <section class="dept-tab-content" id="tab-iab-2023-24">
                    <div class="dept-divider-title">Industry Advisory Board (IAB 2023-24)</div>

                    <p class="dept-text-body">
                        Official notifications, committee constitution, and proceedings of the Industry Advisory Board for academic session 2023-24.
                    </p>

                    <!-- PDF Viewer Container -->
                    <div class="dept-pdf-card">
                        <div class="dept-pdf-toolbar">
                            <div class="dept-pdf-toolbar-info">
                                <i class="fas fa-file-pdf dept-pdf-icon-badge"></i>
                                <div>
                                    <h4 class="dept-pdf-name">IAB 2023-24 Notification Document</h4>
                                    <span class="dept-pdf-sub">Government Engineering College, Modasa &bull; Official PDF Document</span>
                                </div>
                            </div>
                            <div class="dept-pdf-toolbar-actions">
                                <!-- USER: Put your PDF URL in href and src below -->
                                <a href="#" target="_blank" class="dept-pdf-btn dept-pdf-btn-open" title="Open in new tab / Fullscreen">
                                    <i class="fas fa-external-link-alt"></i> Fullscreen
                                </a>
                                <a href="#" download class="dept-pdf-btn dept-pdf-btn-download" title="Download PDF file">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                            </div>
                        </div>

                        <div class="dept-pdf-viewer-area">
                            <iframe src="" class="dept-pdf-iframe" id="pdf-iab-2023-24" title="IAB 2023-24 Document"></iframe>
                            <div class="dept-pdf-empty-state">
                                <div class="dept-pdf-empty-icon"><i class="fas fa-file-pdf"></i></div>
                                <h5>IAB 2023-24 PDF Document</h5>
                                <p>PDF file yahan display hoga. Aap PDF provide karenge to direct link ho jayega.</p>
                                <span class="badge bg-light text-dark border px-3 py-2"><i class="fas fa-info-circle text-primary"></i> Ready for your PDF file</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     8. NEWS LETTERS SUB-OPTIONS & TABS
                     ======================================================== -->

                <!-- 8A. News Letters Vol. 1 Issue 2 Sub-tab -->
                <section class="dept-tab-content" id="tab-nl-vol1-issue2">
                    <div class="dept-divider-title">News Letters: Vol. 1 Issue 2</div>

                    <p class="dept-text-body">
                        Department of Information Technology newsletter &mdash; Volume 1, Issue 2.
                    </p>

                    <!-- PDF Viewer Container -->
                    <div class="dept-pdf-card">
                        <div class="dept-pdf-toolbar">
                            <div class="dept-pdf-toolbar-info">
                                <i class="fas fa-file-pdf dept-pdf-icon-badge"></i>
                                <div>
                                    <h4 class="dept-pdf-name">IT Department Newsletter (Vol. 1 Issue 2)</h4>
                                    <span class="dept-pdf-sub">Department of Information Technology &bull; Official Publication</span>
                                </div>
                            </div>
                            <div class="dept-pdf-toolbar-actions">
                                <!-- USER: Put your PDF URL in href and src below -->
                                <a href="#" target="_blank" class="dept-pdf-btn dept-pdf-btn-open" title="Open in new tab / Fullscreen">
                                    <i class="fas fa-external-link-alt"></i> Fullscreen
                                </a>
                                <a href="#" download class="dept-pdf-btn dept-pdf-btn-download" title="Download PDF file">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                            </div>
                        </div>

                        <div class="dept-pdf-viewer-area">
                            <iframe src="" class="dept-pdf-iframe" id="pdf-nl-vol1-issue2" title="Newsletter Vol. 1 Issue 2"></iframe>
                            <div class="dept-pdf-empty-state">
                                <div class="dept-pdf-empty-icon"><i class="fas fa-file-pdf"></i></div>
                                <h5>Vol. 1 Issue 2 Newsletter Document</h5>
                                <p>PDF file yahan display hoga. Aap PDF provide karenge to direct link ho jayegi.</p>
                                <span class="badge bg-light text-dark border px-3 py-2"><i class="fas fa-info-circle text-primary"></i> Ready for your PDF file</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 8B. News Letters Vol. 1 Issue 1 Sub-tab -->
                <section class="dept-tab-content" id="tab-nl-vol1-issue1">
                    <div class="dept-divider-title">News Letters: Vol. 1 Issue 1</div>

                    <p class="dept-text-body">
                        Department of Information Technology newsletter &mdash; Volume 1, Issue 1 (Inaugural Edition).
                    </p>

                    <!-- PDF Viewer Container -->
                    <div class="dept-pdf-card">
                        <div class="dept-pdf-toolbar">
                            <div class="dept-pdf-toolbar-info">
                                <i class="fas fa-file-pdf dept-pdf-icon-badge"></i>
                                <div>
                                    <h4 class="dept-pdf-name">IT Department Newsletter (Vol. 1 Issue 1)</h4>
                                    <span class="dept-pdf-sub">Department of Information Technology &bull; Official Publication</span>
                                </div>
                            </div>
                            <div class="dept-pdf-toolbar-actions">
                                <!-- USER: Put your PDF URL in href and src below -->
                                <a href="#" target="_blank" class="dept-pdf-btn dept-pdf-btn-open" title="Open in new tab / Fullscreen">
                                    <i class="fas fa-external-link-alt"></i> Fullscreen
                                </a>
                                <a href="#" download class="dept-pdf-btn dept-pdf-btn-download" title="Download PDF file">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                            </div>
                        </div>

                        <div class="dept-pdf-viewer-area">
                            <iframe src="" class="dept-pdf-iframe" id="pdf-nl-vol1-issue1" title="Newsletter Vol. 1 Issue 1"></iframe>
                            <div class="dept-pdf-empty-state">
                                <div class="dept-pdf-empty-icon"><i class="fas fa-file-pdf"></i></div>
                                <h5>Vol. 1 Issue 1 Newsletter Document</h5>
                                <p>PDF file yahan display hoga. Aap PDF provide karenge to direct link ho jayegi.</p>
                                <span class="badge bg-light text-dark border px-3 py-2"><i class="fas fa-info-circle text-primary"></i> Ready for your PDF file</span>
                            </div>
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
