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
                <span class="current">Mechanical Engineering</span>
            </nav>
            <div class="dept-hero-badge">Department of</div>
            <h1 class="dept-hero-title">Mechanical Engineering</h1>
            <p class="dept-hero-desc">
                One of the founding departments of GEC Modasa since 1989. NBA Accredited program fostering excellence in thermodynamics, manufacturing, robotics, and CAD/CAM engineering.
            </p>
            <div class="dept-hero-stats">
                <div class="dept-stat-chip">
                    <i class="fas fa-calendar-check"></i>
                    <span>Established <strong>1989</strong></span>
                </div>
                <div class="dept-stat-chip">
                    <i class="fas fa-award"></i>
                    <span>Accreditation: <strong>NBA Accredited</strong></span>
                </div>
                <div class="dept-stat-chip">
                    <i class="fas fa-user-graduate"></i>
                    <span>Intake: <strong>60 UG</strong></span>
                </div>
                <div class="dept-stat-chip">
                    <i class="fas fa-cogs"></i>
                    <span>Laboratories: <strong>14 Advanced Labs &amp; Workshop</strong></span>
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
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="dept-sidebar-header-text">
                            <span class="dept-sidebar-subtitle">DEPARTMENT PORTAL</span>
                            <h3 class="dept-sidebar-title">Mechanical Dept</h3>
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
                        <li class="dept-menu-item">
                            <a class="dept-nav-link" data-tab="instruction-material" role="tab" aria-selected="false">
                                <span class="nav-icon-wrap"><i class="fas fa-file-alt"></i></span>
                                <span class="nav-label">Instruction Material</span>
                            </a>
                        </li>
                        <li class="dept-menu-item">
                            <a class="dept-nav-link" data-tab="learning-resources" role="tab" aria-selected="false">
                                <span class="nav-icon-wrap"><i class="fas fa-photo-video"></i></span>
                                <span class="nav-label">Learning Resources</span>
                            </a>
                        </li>
                        <li class="dept-menu-item">
                            <a class="dept-nav-link" data-tab="feedback" role="tab" aria-selected="false">
                                <span class="nav-icon-wrap"><i class="fas fa-comment-dots"></i></span>
                                <span class="nav-label">Feedback</span>
                            </a>
                        </li>
                        <li class="dept-menu-item dept-sidebar-dropdown closed" id="sidebar-academic-calendar">
                            <div class="dept-dropdown-header" role="button" tabindex="0" aria-expanded="false">
                                <div class="dd-title-wrap">
                                    <span class="nav-icon-wrap"><i class="fas fa-calendar-alt"></i></span>
                                    <span class="nav-label">Academic Calendar</span>
                                </div>
                                <i class="fas fa-chevron-right dropdown-arrow"></i>
                            </div>
                            <ul class="dept-sub-menu">
                                <li>
                                    <a class="dept-sub-link" data-tab="cal-2025-26" href="#cal-2025-26">
                                        <span class="sub-dot"></span>
                                        <span>Calendar 2025-26</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dept-sub-link" data-tab="cal-2024-25" href="#cal-2024-25">
                                        <span class="sub-dot"></span>
                                        <span>Calendar 2024-25</span>
                                    </a>
                                </li>
                            </ul>
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
                        <h2 class="dept-section-title">About Mechanical Engineering</h2>
                    </div>

                    <p class="dept-lead-text">
                        Established in 1989, the Department of Mechanical Engineering is one of the premier branches of GEC Modasa. The B.E. (Mechanical) programme is accredited by the National Board of Accreditation (NBA) for academic excellence and high outcome attainment.
                    </p>

                    <!-- Key Highlights Grid -->
                    <div class="dept-highlights-grid">
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-certificate"></i></div>
                            <div class="dept-highlight-body">
                                <h4>NBA Accredited</h4>
                                <p>Rigorous outcome-based quality benchmarked by the National Board of Accreditation.</p>
                            </div>
                        </div>
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-industry"></i></div>
                            <div class="dept-highlight-body">
                                <h4>Heavy Workshop</h4>
                                <p>Extensive machine shop with turning, milling, shaping, fitting, welding, and carpentry.</p>
                            </div>
                        </div>
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-fire"></i></div>
                            <div class="dept-highlight-body">
                                <h4>Thermal &amp; IC Engines</h4>
                                <p>Specialized engine test rigs, heat transfer tunnels, and refrigeration simulators.</p>
                            </div>
                        </div>
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-pencil-ruler"></i></div>
                            <div class="dept-highlight-body">
                                <h4>Modern CAD/CAM Lab</h4>
                                <p>High-end simulation workstations equipped with AutoCAD, Creo, and ANSYS.</p>
                            </div>
                        </div>
                    </div>

                    <p class="dept-text-body">
                        The department spans two large academic wings: the dedicated Central Workshop Building and the New Academic Building (Building No. 6). It is furnished with 14 specialized engineering laboratories covering Fluid Power, Dynamics of Machinery, Materials Metallurgy, Metrology, IC Engines, and Automobile Engineering.
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
                                        <td><strong>B.E. Mechanical Engineering (NBA Accredited)</strong></td>
                                        <td><span class="dept-badge-pill dept-badge-ug">UG</span></td>
                                        <td>4 Years</td>
                                        <td><strong>60</strong></td>
                                        <td>1989</td>
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
                                Build a strong teaching-learning and research environment to prepare determined, innovative, inventive, self-esteemed and goal oriented mechanical engineers with good technical knowledge, analytical and soft skills.
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
                                    <span>Providing domain knowledge through qualified, experienced and trained faculties in a healthy academic environment.</span>
                                </li>
                                <li class="mission-item">
                                    <span class="mission-tag">M2</span>
                                    <span>Developing technical skills and creating awareness about industrial needs by encouraging entrepreneurial attitude.</span>
                                </li>
                                <li class="mission-item">
                                    <span class="mission-tag">M3</span>
                                    <span>Encouraging graduates to think innovatively through capstone project works with professional ethical practices.</span>
                                </li>
                                <li class="mission-item">
                                    <span class="mission-tag">M4</span>
                                    <span>Providing all kinds of support for overall personality development and lifelong learning.</span>
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
                            Graduates from the Mechanical Engineering Program are expected to attain:
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table peo-table">
                                <tbody>
                                    <tr>
                                        <td class="peo-label">PEO 1</td>
                                        <td>Gain required knowledge and technical skills to address real-world mechanical and thermal engineering challenges.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-label">PEO 2</td>
                                        <td>Practice mechanical engineering in corporate industries or successfully establish entrepreneurial enterprises.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-label">PEO 3</td>
                                        <td>Pursue higher education, research, and adapt to emerging technologies through lifelong professional learning.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-label">PEO 4</td>
                                        <td>Exhibit high professional ethics, environmental sensitivity, effective communication, and team leadership.</td>
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

                    <div class="faculty-grid">
                        <div class="faculty-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Dr. B. C. Patel</h4>
                            <span class="faculty-desig-badge">Head of Department</span>
                            <div class="faculty-qual">Ph.D., M.E. (Thermal Engineering)</div>
                            <a href="mailto:hod_mech@gecmodasa.ac.in" class="faculty-email-btn"><i class="fas fa-envelope"></i> hod_mech@gecmodasa.ac.in</a>
                        </div>
                        <div class="faculty-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. M. K. Shah</h4>
                            <span class="faculty-desig-badge">Associate Professor</span>
                            <div class="faculty-qual">Ph.D. (Pursuing), M.Tech (Design Engg)</div>
                            <a href="mailto:mkshah@gecmodasa.ac.in" class="faculty-email-btn"><i class="fas fa-envelope"></i> mkshah@gecmodasa.ac.in</a>
                        </div>
                        <div class="faculty-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. S. R. Vaghela</h4>
                            <span class="faculty-desig-badge">Assistant Professor</span>
                            <div class="faculty-qual">M.E. (Manufacturing Engineering)</div>
                            <a href="mailto:srvaghela@gecmodasa.ac.in" class="faculty-email-btn"><i class="fas fa-envelope"></i> srvaghela@gecmodasa.ac.in</a>
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
                            <div class="activity-card-icon"><i class="fas fa-car-side"></i></div>
                            <h4>SAE Collegiate Club</h4>
                            <p>Student engineering teams design, build, and race all-terrain vehicles (BAJA SAE) and electric mobility prototypes.</p>
                        </div>
                        <div class="activity-card">
                            <div class="activity-card-icon"><i class="fas fa-tools"></i></div>
                            <h4>Manufacturing Workshops</h4>
                            <p>Hands-on CNC machining, 3D printing, advanced TIG/MIG welding, and precision inspection seminars.</p>
                        </div>
                        <div class="activity-card">
                            <div class="activity-card-icon"><i class="fas fa-industry"></i></div>
                            <h4>Industrial Visits</h4>
                            <p>Study visits to leading industrial plants including Thermal Power Stations, L&amp;T Hazira, and Maruti Suzuki manufacturing hub.</p>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     5. FACILITIES TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-facilities">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">INFRASTRUCTURE</span>
                        <h2 class="dept-section-title">Laboratories &amp; Central Workshop</h2>
                    </div>

                    <div class="dept-highlights-grid">
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-fire-alt"></i></div>
                            <div class="dept-highlight-body">
                                <h4>Thermal Engineering Lab</h4>
                                <p>Boilers, steam turbines, heat exchangers, and conduction test equipment.</p>
                            </div>
                        </div>
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-tachometer-alt"></i></div>
                            <div class="dept-highlight-body">
                                <h4>Fluid Mechanics Lab</h4>
                                <p>Pelton turbine, Francis turbine, Reynolds apparatus, and hydraulic test benches.</p>
                            </div>
                        </div>
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-drafting-compass"></i></div>
                            <div class="dept-highlight-body">
                                <h4>CAD/CAM Lab</h4>
                                <p>Dedicated workstations equipped with Creo, SolidWorks, AutoCAD, and ANSYS.</p>
                            </div>
                        </div>
                        <div class="dept-highlight-card">
                            <div class="dept-highlight-icon"><i class="fas fa-compress-arrows-alt"></i></div>
                            <div class="dept-highlight-body">
                                <h4>Metrology &amp; Metallurgy</h4>
                                <p>Precision coordinate measuring, optical microscopes, and hardness testing machines.</p>
                            </div>
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

                    <div class="publications-stack">
                        <div class="publication-item">
                            <span class="pub-year-badge">2024</span>
                            <div class="pub-content">
                                <h4 class="pub-title">Experimental Investigation of Thermal Conductivity Enhancement in Graphene Nanofluids</h4>
                                <p class="pub-authors">Dr. B. C. Patel, Prof. M. K. Shah</p>
                                <p class="pub-journal">Applied Thermal Engineering, Elsevier</p>
                            </div>
                        </div>
                        <div class="publication-item">
                            <span class="pub-year-badge">2023</span>
                            <div class="pub-content">
                                <h4 class="pub-title">Optimization of CNC Wire-EDM Process Parameters for Inconel 718 Superalloys</h4>
                                <p class="pub-authors">Prof. S. R. Vaghela</p>
                                <p class="pub-journal">Journal of Materials Processing Technology</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     7. INSTRUCTION MATERIAL TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-instruction-material">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">ACADEMIC RESOURCES</span>
                        <h2 class="dept-section-title">Instruction &amp; Course Material</h2>
                    </div>

                    <div class="newsletter-grid">
                        <div class="newsletter-card">
                            <div class="nl-card-top">
                                <div class="nl-icon"><i class="fas fa-book-reader"></i></div>
                                <div>
                                    <h4>Fluid Power Engineering Lab Manual</h4>
                                    <p>Comprehensive experiment guides &amp; calculation sheets.</p>
                                </div>
                            </div>
                            <a href="#" class="nl-download-btn"><i class="fas fa-download"></i> Download Lab Manual (PDF)</a>
                        </div>
                        <div class="newsletter-card">
                            <div class="nl-card-top">
                                <div class="nl-icon"><i class="fas fa-book-reader"></i></div>
                                <div>
                                    <h4>Kinematics &amp; Dynamics Question Bank</h4>
                                    <p>GTU Mid-sem &amp; University previous years solved papers.</p>
                                </div>
                            </div>
                            <a href="#" class="nl-download-btn"><i class="fas fa-download"></i> Download Question Bank (PDF)</a>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     8. LEARNING RESOURCES TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-learning-resources">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">DIGITAL LEARNING</span>
                        <h2 class="dept-section-title">E-Learning &amp; Virtual Labs</h2>
                    </div>

                    <p class="dept-text-body">
                        Students have access to IIT Virtual Labs, NPTEL course video archives, and digital CAD modeling tutorials directly through the departmental local intranet repository.
                    </p>
                </section>

                <!-- ========================================================
                     9. FEEDBACK TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-feedback">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">CONTINUOUS IMPROVEMENT</span>
                        <h2 class="dept-section-title">Student &amp; Stakeholder Feedback</h2>
                    </div>

                    <p class="dept-text-body">
                        Feedback regarding curriculum, laboratory experiments, and instructional delivery is recorded on a semester basis to enhance teaching-learning efficacy under NBA guidelines.
                    </p>
                </section>

                <!-- ========================================================
                     10. ACADEMIC CALENDAR (2025-26 & 2024-25)
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-cal-2025-26">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">SCHEDULE</span>
                        <h2 class="dept-section-title">Academic Calendar (2025-26)</h2>
                    </div>

                    <div class="newsletter-card" style="max-width: 450px;">
                        <div class="nl-card-top">
                            <div class="nl-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div>
                                <h4>Department Term Calendar 2025-26</h4>
                                <p>Mid-sem exams, submissions, and industrial visits schedule.</p>
                            </div>
                        </div>
                        <a href="#" class="nl-download-btn"><i class="fas fa-download"></i> Download Calendar (PDF)</a>
                    </div>
                </section>

                <section class="dept-tab-content" id="tab-cal-2024-25">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">SCHEDULE</span>
                        <h2 class="dept-section-title">Academic Calendar (2024-25)</h2>
                    </div>

                    <div class="newsletter-card" style="max-width: 450px;">
                        <div class="nl-card-top">
                            <div class="nl-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div>
                                <h4>Department Term Calendar 2024-25</h4>
                                <p>Archived academic schedule.</p>
                            </div>
                        </div>
                        <a href="#" class="nl-download-btn"><i class="fas fa-download"></i> Download Calendar (PDF)</a>
                    </div>
                </section>

                <!-- ========================================================
                     11. IAB 2025-26 & 2023-24
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-iab-2025-26">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">INDUSTRY COLLABORATION</span>
                        <h2 class="dept-section-title">Industry Advisory Board (2025-26)</h2>
                    </div>

                    <div class="iab-member-grid">
                        <div class="iab-card">
                            <h4>Dr. B. C. Patel</h4>
                            <div class="iab-org">HOD, Mechanical, GEC Modasa</div>
                            <div class="iab-role">Chairman</div>
                        </div>
                        <div class="iab-card">
                            <h4>Mr. Sanjay Dave</h4>
                            <div class="iab-org">Plant General Manager, L&amp;T Heavy Engg</div>
                            <div class="iab-role">Industry Member</div>
                        </div>
                    </div>
                </section>

                <section class="dept-tab-content" id="tab-iab-2023-24">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">INDUSTRY COLLABORATION</span>
                        <h2 class="dept-section-title">Industry Advisory Board (2023-24)</h2>
                    </div>

                    <div class="iab-member-grid">
                        <div class="iab-card">
                            <h4>Dr. B. C. Patel</h4>
                            <div class="iab-org">HOD, Mechanical, GEC Modasa</div>
                            <div class="iab-role">Chairman</div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     12. NEWS LETTERS (Vol. 1 Issue 2 & Vol. 1 Issue 1)
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-nl-vol1-issue2">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">DEPARTMENT PERIODICAL</span>
                        <h2 class="dept-section-title">MechE Chronicle (Vol. 1 Issue 2)</h2>
                    </div>

                    <div class="newsletter-grid">
                        <div class="newsletter-card">
                            <div class="nl-card-top">
                                <div class="nl-icon"><i class="fas fa-file-pdf"></i></div>
                                <div>
                                    <h4>MechE Chronicle - Vol. 1 Issue 2</h4>
                                    <p>NBA Accreditation review and SAE collegiate events.</p>
                                </div>
                            </div>
                            <a href="#" class="nl-download-btn"><i class="fas fa-download"></i> Download Newsletter (PDF)</a>
                        </div>
                    </div>
                </section>

                <section class="dept-tab-content" id="tab-nl-vol1-issue1">
                    <div class="dept-section-header">
                        <span class="dept-section-tag">DEPARTMENT PERIODICAL</span>
                        <h2 class="dept-section-title">MechE Chronicle (Vol. 1 Issue 1)</h2>
                    </div>

                    <div class="newsletter-grid">
                        <div class="newsletter-card">
                            <div class="nl-card-top">
                                <div class="nl-icon"><i class="fas fa-file-pdf"></i></div>
                                <div>
                                    <h4>MechE Chronicle - Vol. 1 Issue 1</h4>
                                    <p>Inaugural issue on workshop modernization and faculty Ph.D. defenses.</p>
                                </div>
                            </div>
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