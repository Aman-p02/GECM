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
                <span class="current">Information Technology</span>
            </nav>
            <div class="dept-hero-badge">Department of</div>
            <h1 class="dept-hero-title">Information Technology</h1>
            <p class="dept-hero-desc">
                Leading academic excellence in digital infrastructure, cloud networks, cybersecurity, and intelligent information systems since 1999.
            </p>
            <div class="dept-hero-stats">
                <div class="dept-stat-chip">
                    <i class="fas fa-calendar-check"></i>
                    <span>Established <strong>1999</strong></span>
                </div>
                <div class="dept-stat-chip">
                    <i class="fas fa-user-graduate"></i>
                    <span>Intake: <strong>120 UG</strong></span>
                </div>
                <div class="dept-stat-chip">
                    <i class="fas fa-microchip"></i>
                    <span>Laboratories: <strong>6 High-End Labs</strong></span>
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
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <div class="dept-sidebar-header-text">
                            <span class="dept-sidebar-subtitle">DEPARTMENT PORTAL</span>
                            <h3 class="dept-sidebar-title">IT Department</h3>
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
                        <h2 class="dept-section-title">About Information Technology</h2>
                    </div>

                    <p class="dept-lead-text">
                        The Information Technology Department at Government Engineering College, Modasa has been educating competent IT professionals since 1999. The department equips students with state-of-the-art skills in cloud technologies, cybersecurity, data engineering, and enterprise network design.
                    </p>

                    <!-- Key Highlights Grid -->
                    <div class="dept-highlights-grid">
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-shield-alt"></i></div>
                            <div class="dept-highlight-body">
                                <h4>Network &amp; Security</h4>
                                <p>Comprehensive security labs with live firewall configuration and packet analysis.</p>
                            </div>
                        </div>
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-cloud"></i></div>
                            <div class="dept-highlight-body">
                                <h4>Cloud Infrastructure</h4>
                                <p>Hands-on virtualization, cloud containers, and enterprise server access.</p>
                            </div>
                        </div>
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-database"></i></div>
                            <div class="dept-highlight-body">
                                <h4>Big Data &amp; DBMS</h4>
                                <p>Specialized systems for Relational, NoSQL, and Distributed database architectures.</p>
                            </div>
                        </div>
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-laptop-code"></i></div>
                            <div class="dept-highlight-body">
                                <h4>Full-Stack Labs</h4>
                                <p>Dedicated workstations equipped with modern frameworks, Linux, and IDE suites.</p>
                            </div>
                        </div>
                    </div>

                    <p class="dept-text-body">
                        The department has developed high-end laboratories in Computer Hardware, Networking &amp; Security, Database Management Systems, Internet of Things, and Web Technologies. The entire campus-wide network infrastructure of GEC Modasa is centrally managed by the IT Department.
                    </p>

                    <p class="dept-text-body">
                        Operating in a dedicated academic block alongside Computer Engineering, the department features modern seminar halls, dedicated server racks, and high-speed leased line internet connectivity to support student research and academic innovation.
                    </p>

                    <!-- Under Graduate Courses Table Card -->
                    <div class="courses-card">
                        <div class="courses-card-header">
                            <i class="fas fa-layer-group"></i>
                            <span>Under Graduate Programmes</span>
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
                                        <td><strong>B.E. Information Technology</strong></td>
                                        <td><span class="dept-badge-pill dept-badge-ug">UG</span></td>
                                        <td>4 Years</td>
                                        <td><strong>120</strong></td>
                                        <td>1999</td>
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
                                To achieve national recognition in Information Technology education and research by nurturing innovative technologists capable of meeting societal challenges with high ethical standards.
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
                                    <span>Provide student-centric learning environment with modern curricula in information technology and networking.</span>
                                </li>
                                <li class="mission-item">
                                    <span class="mission-tag">M2</span>
                                    <span>Establish cutting-edge research facilities in cybersecurity, cloud systems, and applied machine learning.</span>
                                </li>
                                <li class="mission-item">
                                    <span class="mission-tag">M3</span>
                                    <span>Foster strong collaborative linkages with leading software industries and research institutions.</span>
                                </li>
                                <li class="mission-item">
                                    <span class="mission-tag">M4</span>
                                    <span>Inculcate leadership qualities, professional ethics, and active responsibility towards sustainable societal progress.</span>
                                </li>
                            </ul>
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
                        The Information Technology Department is backed by dedicated, highly qualified faculties committed to academic excellence, continuous learning, and mentorship.
                    </p>

                    <div class="faculty-grid">
                        <div class="faculty-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. V. M. Joshi</h4>
                            <span class="faculty-desig-badge">Head of Department (I/C)</span>
                            <div class="faculty-qual">M.E. (Information Technology)</div>
                            <a href="mailto:hod_it@gecmodasa.ac.in" class="faculty-email-btn"><i class="fas fa-envelope"></i> hod_it@gecmodasa.ac.in</a>
                        </div>
                        <div class="faculty-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. K. R. Solanki</h4>
                            <span class="faculty-desig-badge">Assistant Professor</span>
                            <div class="faculty-qual">M.Tech (Computer Engineering)</div>
                            <a href="mailto:krsolanki@gecmodasa.ac.in" class="faculty-email-btn"><i class="fas fa-envelope"></i> krsolanki@gecmodasa.ac.in</a>
                        </div>
                        <div class="faculty-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. D. J. Patel</h4>
                            <span class="faculty-desig-badge">Assistant Professor</span>
                            <div class="faculty-qual">M.E. (Information Technology)</div>
                            <a href="mailto:djpatel@gecmodasa.ac.in" class="faculty-email-btn"><i class="fas fa-envelope"></i> djpatel@gecmodasa.ac.in</a>
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

                    <div class="activities-grid">
                        <div class="activity-card">
                            <div class="activity-card-icon"><i class="fas fa-shield-virus"></i></div>
                            <h4>CyberSec Bootcamps</h4>
                            <p>Hands-on ethical hacking, vulnerability scanning, and secure software development workshops.</p>
                        </div>
                        <div class="activity-card">
                            <div class="activity-card-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                            <h4>Cloud DevOps Seminars</h4>
                            <p>Industry-led interactive bootcamps covering Docker, Kubernetes, CI/CD pipelines, and AWS deployment.</p>
                        </div>
                        <div class="activity-card">
                            <div class="activity-card-icon"><i class="fas fa-users-cog"></i></div>
                            <h4>Industrial Seminars</h4>
                            <p>Technical sessions conducted by engineers from leading IT hubs across Ahmedabad and Gandhinagar.</p>
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

                    <div class="modern-labs-stack">
                        <article class="modern-lab-card">
                            <div class="modern-photo-wrap">
                                <img src="images/labs/lab_8212_project.jpg" alt="8212 IT Project Lab" class="modern-photo-img" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                            </div>
                            <div class="modern-lab-body">
                                <span class="modern-room-pill">Room 8212</span>
                                <h3 class="modern-lab-title">IT Project &amp; Development Lab</h3>
                                <p class="modern-lab-text">
                                    Equipped with high-performance desktop terminals and software development IDEs for final year student capstone projects.
                                </p>
                            </div>
                        </article>

                        <article class="modern-lab-card">
                            <div class="modern-photo-wrap">
                                <img src="images/labs/lab_8215_programming2.jpg" alt="8215 Programming Lab - 2" class="modern-photo-img" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                            </div>
                            <div class="modern-lab-body">
                                <span class="modern-room-pill">Room 8215</span>
                                <h3 class="modern-lab-title">Programming &amp; DBMS Lab</h3>
                                <p class="modern-lab-text">
                                    Dedicated for advanced database management, system programming, object-oriented methodologies, and web engineering.
                                </p>
                            </div>
                        </article>

                        <article class="modern-lab-card">
                            <div class="modern-photo-wrap">
                                <img src="images/labs/lab_8216_pps.jpg" alt="8216 PPS Lab" class="modern-photo-img" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                            </div>
                            <div class="modern-lab-body">
                                <span class="modern-room-pill">Room 8216</span>
                                <h3 class="modern-lab-title">PPS &amp; Algorithms Lab</h3>
                                <p class="modern-lab-text">
                                    Designed to strengthen foundational problem-solving abilities, data structure implementations, and competitive coding practice.
                                </p>
                            </div>
                        </article>
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

                    <div class="publications-stack">
                        <div class="publication-item">
                            <span class="pub-year-badge">2024</span>
                            <div class="pub-content">
                                <h4 class="pub-title">Secure Lightweight Authentication Protocol for Fog-Enabled Internet of Vehicles</h4>
                                <p class="pub-authors">Prof. V. M. Joshi, Prof. K. R. Solanki</p>
                                <p class="pub-journal">IEEE Transactions on Intelligent Transportation Systems</p>
                            </div>
                        </div>

                        <div class="publication-item">
                            <span class="pub-year-badge">2023</span>
                            <div class="pub-content">
                                <h4 class="pub-title">Optimizing Serverless Cold-Start Latency in Edge Computing Architectures</h4>
                                <p class="pub-authors">Prof. D. J. Patel</p>
                                <p class="pub-journal">International Journal of Cloud Applications and Computing</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     7. IAB 2025-26
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-iab-2025-26">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">INDUSTRY COLLABORATION</span>
                        <h2 class="dept-section-title">Industry Advisory Board (2025-26)</h2>
                    </div>

                    <div class="iab-member-grid">
                        <div class="iab-card">
                            <h4>Prof. V. M. Joshi</h4>
                            <div class="iab-org">HOD (I/C), GEC Modasa</div>
                            <div class="iab-role">Chairman</div>
                        </div>
                        <div class="iab-card">
                            <h4>Mr. Mayank Bhatt</h4>
                            <div class="iab-org">Senior Cloud Engineer, Oracle</div>
                            <div class="iab-role">Industry Member</div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     8. IAB 2023-24
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-iab-2023-24">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">INDUSTRY COLLABORATION</span>
                        <h2 class="dept-section-title">Industry Advisory Board (2023-24)</h2>
                    </div>

                    <div class="iab-member-grid">
                        <div class="iab-card">
                            <h4>Prof. V. M. Joshi</h4>
                            <div class="iab-org">HOD (I/C), GEC Modasa</div>
                            <div class="iab-role">Chairman</div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     9. NEWS LETTERS (Vol. 1 Issue 2)
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-nl-vol1-issue2">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">DEPARTMENT PERIODICAL</span>
                        <h2 class="dept-section-title">IT Newsletter (Vol. 1 Issue 2)</h2>
                    </div>

                    <div class="newsletter-grid">
                        <div class="newsletter-card">
                            <div class="nl-card-top">
                                <div class="nl-icon"><i class="fas fa-file-pdf"></i></div>
                                <div>
                                    <h4>InfoTech Pulse - Vol. 1 Issue 2</h4>
                                    <p>Academic Year Term Review</p>
                                </div>
                            </div>
                            <p class="dept-text-body" style="font-size: 0.88rem; margin-bottom: 18px;">
                                Covers student hackathon achievements, cloud certifications, and technical symposium highlights.
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
                        <h2 class="dept-section-title">IT Newsletter (Vol. 1 Issue 1)</h2>
                    </div>

                    <div class="newsletter-grid">
                        <div class="newsletter-card">
                            <div class="nl-card-top">
                                <div class="nl-icon"><i class="fas fa-file-pdf"></i></div>
                                <div>
                                    <h4>InfoTech Pulse - Vol. 1 Issue 1</h4>
                                    <p>Inaugural Issue</p>
                                </div>
                            </div>
                            <p class="dept-text-body" style="font-size: 0.88rem; margin-bottom: 18px;">
                                Inaugural edition showcasing departmental milestones, faculty research, and alumni placements.
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