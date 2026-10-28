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
     Main Department Section (Authentic Institutional Layout)
     ======================================================== -->
<div class="dept-page-wrapper">
    <div class="container">
        <div class="dept-layout-grid">

            <!-- Left Sidebar Navigation -->
            <aside class="dept-sidebar">
                <div class="dept-sidebar-header">
                    Mechanical Department
                </div>
                <ul class="dept-sidebar-menu">
                    <li class="active">
                        <a class="dept-nav-link active" data-tab="about">About Department</a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="vision-mission">Vision and Mission</a>
                    </li>
                    <li>
                        <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="dept-nav-link">
                            <span>Syllabus</span>
                            <i class="fas fa-external-link-alt arrow-icon"></i>
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
                    <li>
                        <a class="dept-nav-link" data-tab="instruction-material">Instruction Material</a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="learning-resources">Learning Resources</a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="feedback">Feedback for Instruction material</a>
                    </li>
                    <li class="dept-sidebar-dropdown closed" id="sidebar-academic-calendar">
                        <div class="dept-dropdown-header" role="button" tabindex="0">
                            <span>Department Academic Calender</span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </div>
                        <ul class="dept-sub-menu">
                            <li>
                                <a class="dept-sub-link" data-tab="cal-2025-26" href="#cal-2025-26">Academic Calendar 2025-26</a>
                            </li>
                            <li>
                                <a class="dept-sub-link" data-tab="cal-2024-25" href="#cal-2024-25">Academic Calendar 2024-25</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dept-sidebar-dropdown closed" id="sidebar-iab">
                        <div class="dept-dropdown-header" role="button" tabindex="0">
                            <span>Industry Advisory Board</span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
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
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
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
                        It is accommodated in separate building. This department has various laboratories in the areas of Heat Power, Thermodynamics, Heat and Mass Transfer, IC Engines, Automobiles, Fluid Mechanics and Fluid Power, Kinematics and dynamics, Material Technology, Metrology and Instrumentation, and CAD. The Department has excellent Computer Centre and workshop facilities consisting of carpentry, fitting, turning and milling.
                    </p>

                    <p class="dept-text-body">
                        This department has two wings, one at Workshop Building and another at New Academic Building i.e. Building No. 6. It has various laboratories in the area of Heat Power, Thermo Dynamics, Heat and Mass Transfer, IC Engines, Automobiles, Fluid Mechanics and Fluid Power, Kinematics and Dynamics, Material Technology, Metrology and Instrumentation, CAD, CAM and Production Technology. The department has excellent Computer Center and Workshop facilities consisting of carpentry, fitting, turning and milling.
                    </p>

                    <div class="dept-divider-title">About the Programme</div>

                    <p class="dept-text-body">
                        Mechanical engineering is a professional programme which helps students to understand the working mechanisms of heavy tools and machineries. The branch applies principles of engineering, physics and material science for the design, analysis, manufacturing and maintenance of mechanical systems. The course covers technical areas like distribution of electricity through generators, transformers, transmission lines, lighting and wiring in buildings. A course in mechanical engineering makes a student gain knowledge and experience in the designing of electric motors, automobiles, aircrafts and other heavy vehicles. Mechanical engineering demands knowledge about software used in technical work like computer-aided design and mathematical modelling.
                    </p>

                    <p class="dept-text-body">
                        Mechanical Engineering science emerged in the 19th century as a result of developments in the field of physics. The field has continually evolved to incorporate advancements in technology. Mechanical engineers today are pursuing developments in fields such as composites, mechatronics and nano technology. Mechanical Engineering overlaps with aerospace engineering, civil engineering, electrical engineering, petroleum engineering and chemical engineering to varying amounts.
                    </p>

                    <p class="dept-text-body" style="font-weight: 700; color: #111827;">
                        B.E. (Mechanical) program offered by the department is accredited by National Board of Accreditation(NBA) for three years till Jun-2024.
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
                                        <td><strong>Mechanical Engineering (NBA Accredited)</strong></td>
                                        <td>UG</td>
                                        <td>4</td>
                                        <td>60</td>
                                        <td>1989</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Facilities Dual Column List -->
                    <div class="dept-divider-title">Facilities</div>

                    <div class="dept-facilities-dual-grid">
                        <ul class="facility-items-list">
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Basic Mechanical Engineering Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Engineering Graphics Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Heat Transfer Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Material Science and Metallurgy Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Manufacturing Technology Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Internal Combustion Engines Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Computer Aided Design Lab</span></li>
                        </ul>
                        <ul class="facility-items-list">
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Workshop</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Fluid Mechanics and Hydraulics Machines Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Dynamics of Machinery Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Mechanical Measurement and Metrology Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Manufacturing Processes Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Automobile Engineering Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Refrigeration and Air Conditioning Lab</span></li>
                        </ul>
                    </div>
                </section>

                <!-- ========================================================
                     2. VISION & MISSION TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-vision-mission">
                    <div class="dept-divider-title">Vision</div>

                    <p class="dept-text-body">
                        Build a strong teaching-learning and research environment to prepare determined, innovative, inventive, self-esteemed and goal oriented mechanical engineers with good technical knowledge, analytical and soft skill.
                    </p>

                    <div class="dept-divider-title">Mission</div>

                    <p class="dept-text-body">
                        To equip mechanical engineering graduates to face challenges of industries, society and nation by:
                    </p>

                    <ul class="mission-bullet-list">
                        <li>Providing domain knowledge through qualified, experienced and trained faculties in healthy environment.</li>
                        <li>Developing technical skills and creating awareness about needs of industries by encouraging entrepreneurial attitude.</li>
                        <li>Encouraging graduates to think innovatively through project works with professional ethical practices.</li>
                        <li>Providing all kinds of support for overall personality development.</li>
                    </ul>

                    <!-- Program Educational Objectives PEOs Table -->
                    <div class="courses-card">
                        <div class="courses-card-header">
                            <i class="fas fa-bars"></i>
                            <span>Program Educational Objectives PEOs</span>
                        </div>
                        <div class="peo-intro-banner">
                            Graduates from the Mechanical Engineering Program are expected to attain or achieve the following Program Educational Objectives
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table peo-pso-table">
                                <tbody>
                                    <tr>
                                        <td class="peo-code-cell"><strong>PEO1</strong></td>
                                        <td>Implement the acquired knowledge of science, technology, engineering, management (STEM) with good human values for a successful career.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-code-cell"><strong>PEO2</strong></td>
                                        <td>Achieve a position of leadership in the organization through managerial, communication and professional skills with ethical values.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-code-cell"><strong>PEO3</strong></td>
                                        <td>Be a foundation for innovative solutions of complicated problems as a successful entrepreneur.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-code-cell"><strong>PEO4</strong></td>
                                        <td>Provide feasible solutions for sustainable and environment friendly development.</td>
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
                            Mechanical Engineering Graduate will be able to:
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table peo-pso-table">
                                <tbody>
                                    <tr>
                                        <td class="peo-code-cell"><strong>PSO1</strong></td>
                                        <td>Apply the specific skill acquired for solving problems related to mechanical engineering and interdisciplinary problems with knowledge of Science, Technology, Engineering and Mathematics (STEM) and modern software skills.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-code-cell"><strong>PSO2</strong></td>
                                        <td>Develop optimum engineering systems by acquiring the knowledge of specialized areas such as product design and its optimization, manufacturing and thermal science.</td>
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
                    <div class="faculty-simple-grid">
                        <div class="faculty-simple-card">
                            <div class="faculty-simple-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="faculty-simple-info">
                                <h4 class="faculty-simple-name">Dr. H. D. Mehta</h4>
                                <div class="faculty-simple-designation">Professor &amp; Head of Department</div>
                                <div class="faculty-simple-meta"><i class="fas fa-graduation-cap"></i> Ph.D., M.E. (Mechanical)</div>
                                <div class="faculty-simple-meta"><i class="fas fa-envelope"></i> hod_mech@gecmodasa.ac.in</div>
                            </div>
                        </div>
                        <div class="faculty-simple-card">
                            <div class="faculty-simple-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="faculty-simple-info">
                                <h4 class="faculty-simple-name">Prof. P. M. Patel</h4>
                                <div class="faculty-simple-designation">Associate Professor</div>
                                <div class="faculty-simple-meta"><i class="fas fa-graduation-cap"></i> M.E. (Thermal Engg.)</div>
                                <div class="faculty-simple-meta"><i class="fas fa-envelope"></i> pmpatel@gecmodasa.ac.in</div>
                            </div>
                        </div>
                        <div class="faculty-simple-card">
                            <div class="faculty-simple-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="faculty-simple-info">
                                <h4 class="faculty-simple-name">Prof. S. R. Joshi</h4>
                                <div class="faculty-simple-designation">Assistant Professor</div>
                                <div class="faculty-simple-meta"><i class="fas fa-graduation-cap"></i> M.Tech (CAD/CAM)</div>
                                <div class="faculty-simple-meta"><i class="fas fa-envelope"></i> srjoshi@gecmodasa.ac.in</div>
                            </div>
                        </div>
                        <div class="faculty-simple-card">
                            <div class="faculty-simple-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="faculty-simple-info">
                                <h4 class="faculty-simple-name">Prof. N. K. Prajapati</h4>
                                <div class="faculty-simple-designation">Assistant Professor</div>
                                <div class="faculty-simple-meta"><i class="fas fa-graduation-cap"></i> M.E. (Machine Design)</div>
                                <div class="faculty-simple-meta"><i class="fas fa-envelope"></i> nkprajapati@gecmodasa.ac.in</div>
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
                        The Mechanical Engineering Department routinely organizes state and national level events, hands-on workshops, industrial field visits, expert lecture series, and SAE Collegiate Club competitions (such as BAJA, SUPRA, and E-Mobility rallies) to bridge the industry-academia gap.
                    </p>

                    <div class="activities-simple-list">
                        <div class="activity-card">
                            <div class="activity-card-header">
                                <span class="activity-tag">Workshop</span>
                                <span class="activity-date"><i class="far fa-calendar-alt"></i> March 2025</span>
                            </div>
                            <h4 class="activity-title">Hands-on Training on CAD/CAM &amp; CNC Machining</h4>
                            <p class="dept-text-body">Five-day intensive industrial training for pre-final and final year mechanical students on CNC programming and modern tooling solutions.</p>
                        </div>
                        <div class="activity-card">
                            <div class="activity-card-header">
                                <span class="activity-tag">Industrial Visit</span>
                                <span class="activity-date"><i class="far fa-calendar-alt"></i> January 2025</span>
                            </div>
                            <h4 class="activity-title">Industrial Visit to Thermal Power Station, Gandhinagar</h4>
                            <p class="dept-text-body">Practical exposure for B.E. semester 6 students to understand steam power generation, boilers, and cooling systems in heavy utility plants.</p>
                        </div>
                        <div class="activity-card">
                            <div class="activity-card-header">
                                <span class="activity-tag">Expert Lecture</span>
                                <span class="activity-date"><i class="far fa-calendar-alt"></i> September 2024</span>
                            </div>
                            <h4 class="activity-title">Industry 4.0, Robotics &amp; Automation in Automotive Manufacturing</h4>
                            <p class="dept-text-body">Expert lecture by senior design engineers from leading automotive industries on smart manufacturing and digital twins.</p>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     5. FACILITIES TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-facilities">
                    <div class="dept-divider-title">Laboratories &amp; Facilities</div>
                    <p class="dept-text-body">
                        The department has 14 well-equipped laboratories catering to core mechanical engineering disciplines, thermal research, material testing, and computer-aided engineering.
                    </p>

                    <div class="dept-facilities-dual-grid">
                        <ul class="facility-items-list">
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Basic Mechanical Engineering Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Engineering Graphics Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Heat Transfer Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Material Science and Metallurgy Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Manufacturing Technology Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Internal Combustion Engines Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Computer Aided Design Lab</span></li>
                        </ul>
                        <ul class="facility-items-list">
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Workshop (Fitting, Turning, Carpentry, Welding)</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Fluid Mechanics and Hydraulics Machines Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Dynamics of Machinery Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Mechanical Measurement and Metrology Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Manufacturing Processes Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Automobile Engineering Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right facility-bullet-icon"></i> <span>Refrigeration and Air Conditioning Lab</span></li>
                        </ul>
                    </div>
                </section>

                <!-- ========================================================
                     6. PUBLICATIONS TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-publications">
                    <div class="dept-divider-title">Research Publications</div>
                    <p class="dept-text-body">
                        Faculty and students of the Mechanical Engineering Department actively publish in peer-reviewed national and international journals and conferences indexed in Scopus and Web of Science.
                    </p>

                    <div class="publications-list-stack">
                        <div class="publication-card">
                            <div class="publication-title">
                                Experimental Investigation of Thermal Performance in Parabolic Trough Solar Collectors with Nanofluids
                            </div>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user-edit"></i>
                                    <span>Dr. H. D. Mehta, Prof. P. M. Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2024</span>
                                </div>
                            </div>
                        </div>

                        <div class="publication-card">
                            <div class="publication-title">
                                Optimization of Machining Parameters in Wire-EDM of Ti-6Al-4V Alloy Using Taguchi-Grey Relational Analysis
                            </div>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user-edit"></i>
                                    <span>Prof. S. R. Joshi, Dr. H. D. Mehta</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2023</span>
                                </div>
                            </div>
                        </div>

                        <div class="publication-card">
                            <div class="publication-title">
                                Finite Element Stress Analysis and Fatigue Life Estimation of Automotive Lower Control Arm
                            </div>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user-edit"></i>
                                    <span>Prof. N. K. Prajapati</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2022</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     7. INSTRUCTION MATERIAL TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-instruction-material">
                    <div class="dept-divider-title">Instruction Material</div>
                    <p class="dept-text-body">
                        Course handouts, lecture presentations, laboratory instruction sheets, and tutorial booklets developed by the faculty are made available for student reference.
                    </p>
                    <div class="dept-doc-accordion-container">
                        <div class="dept-doc-accordion open">
                            <button class="dept-doc-accordion-header" type="button">
                                <span><i class="fas fa-book-open"></i> Laboratory Manuals (Sem 3 to 8)</span>
                                <i class="fas fa-chevron-down accordion-arrow"></i>
                            </button>
                            <div class="dept-doc-accordion-body" style="display: block; padding: 18px 20px;">
                                <div class="dept-pdf-toolbar-card">
                                    <div class="dept-pdf-toolbar-info">
                                        <i class="fas fa-file-pdf dept-pdf-icon-badge"></i>
                                        <div>
                                            <div class="dept-pdf-name">Heat Transfer Lab Manual (B.E. Sem 5)</div>
                                            <div class="dept-pdf-sub">Approved by Department Academic Committee</div>
                                        </div>
                                    </div>
                                    <div class="dept-pdf-toolbar-actions">
                                        <a href="#" class="dept-pdf-btn dept-pdf-btn-open"><i class="fas fa-eye"></i> View</a>
                                        <a href="#" class="dept-pdf-btn dept-pdf-btn-download"><i class="fas fa-download"></i> Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     8. LEARNING RESOURCES TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-learning-resources">
                    <div class="dept-divider-title">Learning Resources</div>
                    <p class="dept-text-body">
                        Students are encouraged to utilize digital learning initiatives including NPTEL/SWAYAM video lectures, IIT Bombay Virtual Labs, ASME student chapter technical papers, and open-source CAD/FEA simulation repositories.
                    </p>
                </section>

                <!-- ========================================================
                     9. FEEDBACK FOR INSTRUCTION MATERIAL TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-feedback">
                    <div class="dept-divider-title">Feedback for Instruction Material</div>
                    <p class="dept-text-body">
                        The department collects continuous constructive feedback from students and stakeholders regarding the clarity, industrial relevance, and quality of instruction manuals and course materials to support continual outcome-based improvement.
                    </p>
                </section>

                <!-- ========================================================
                     10. DEPARTMENT ACADEMIC CALENDAR SUB-TABS
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-cal-2025-26">
                    <div class="dept-divider-title">Department Academic Calendar 2025-26</div>
                    <p class="dept-text-body">
                        Official academic calendar, instructional weeks, mid-semester assessment schedules, and project milestone submission windows for academic session 2025-26.
                    </p>
                    <div class="dept-doc-accordion-container">
                        <div class="dept-doc-accordion open">
                            <button class="dept-doc-accordion-header" type="button">
                                <span><i class="fas fa-calendar-check"></i> Academic Calendar Notification (2025-26)</span>
                                <i class="fas fa-chevron-down accordion-arrow"></i>
                            </button>
                            <div class="dept-doc-accordion-body" style="display: block; padding: 18px 20px;">
                                <div class="dept-pdf-toolbar-card">
                                    <div class="dept-pdf-toolbar-info">
                                        <i class="fas fa-file-pdf dept-pdf-icon-badge"></i>
                                        <div>
                                            <div class="dept-pdf-name">Mechanical_Academic_Calendar_2025_26.pdf</div>
                                            <div class="dept-pdf-sub">Published by Office of Head, Mechanical Department</div>
                                        </div>
                                    </div>
                                    <div class="dept-pdf-toolbar-actions">
                                        <a href="#" class="dept-pdf-btn dept-pdf-btn-open"><i class="fas fa-eye"></i> View</a>
                                        <a href="#" class="dept-pdf-btn dept-pdf-btn-download"><i class="fas fa-download"></i> Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="dept-tab-content" id="tab-cal-2024-25">
                    <div class="dept-divider-title">Department Academic Calendar 2024-25</div>
                    <p class="dept-text-body">
                        Archived academic calendar and term schedule for academic year 2024-25.
                    </p>
                </section>

                <!-- ========================================================
                     11. INDUSTRY ADVISORY BOARD SUB-TABS
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-iab-2025-26">
                    <div class="dept-divider-title">Industry Advisory Board (IAB 2025-26)</div>
                    <p class="dept-text-body">
                        Official notifications, committee constitution, and proceedings of the Mechanical Industry Advisory Board for academic session 2025-26.
                    </p>
                    <div class="dept-doc-accordion-container">
                        <div class="dept-doc-accordion open">
                            <button class="dept-doc-accordion-header" type="button">
                                <span><i class="fas fa-users-cog"></i> Industry Advisory Board Committee Notification</span>
                                <i class="fas fa-chevron-down accordion-arrow"></i>
                            </button>
                            <div class="dept-doc-accordion-body" style="display: block; padding: 18px 20px;">
                                <div class="dept-pdf-toolbar-card">
                                    <div class="dept-pdf-toolbar-info">
                                        <i class="fas fa-file-pdf dept-pdf-icon-badge"></i>
                                        <div>
                                            <div class="dept-pdf-name">Mechanical_IAB_Constitution_2025_26.pdf</div>
                                            <div class="dept-pdf-sub">Endorsed by Principal &amp; Department Industry Committee</div>
                                        </div>
                                    </div>
                                    <div class="dept-pdf-toolbar-actions">
                                        <a href="#" class="dept-pdf-btn dept-pdf-btn-open"><i class="fas fa-eye"></i> View</a>
                                        <a href="#" class="dept-pdf-btn dept-pdf-btn-download"><i class="fas fa-download"></i> Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="dept-tab-content" id="tab-iab-2023-24">
                    <div class="dept-divider-title">Industry Advisory Board (IAB 2023-24)</div>
                    <p class="dept-text-body">
                        Official proceedings and meeting minutes of the Mechanical Industry Advisory Board for academic session 2023-24.
                    </p>
                </section>

                <!-- ========================================================
                     12. NEWS LETTERS SUB-TABS
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-nl-vol1-issue2">
                    <div class="dept-divider-title">News Letters: Vol. 1 Issue 2</div>
                    <p class="dept-text-body">
                        Departmental half-yearly newsletter showcasing student achievements, technical competitions, SAE team performances, research activities, and faculty honors.
                    </p>
                    <div class="dept-doc-accordion-container">
                        <div class="dept-doc-accordion open">
                            <button class="dept-doc-accordion-header" type="button">
                                <span><i class="fas fa-newspaper"></i> Mechanical Department Newsletter Vol. 1 Issue 2</span>
                                <i class="fas fa-chevron-down accordion-arrow"></i>
                            </button>
                            <div class="dept-doc-accordion-body" style="display: block; padding: 18px 20px;">
                                <div class="dept-pdf-toolbar-card">
                                    <div class="dept-pdf-toolbar-info">
                                        <i class="fas fa-file-pdf dept-pdf-icon-badge"></i>
                                        <div>
                                            <div class="dept-pdf-name">Mechanical_Newsletter_Vol1_Issue2.pdf</div>
                                            <div class="dept-pdf-sub">Published by Editorial Board, Mechanical Dept</div>
                                        </div>
                                    </div>
                                    <div class="dept-pdf-toolbar-actions">
                                        <a href="#" class="dept-pdf-btn dept-pdf-btn-open"><i class="fas fa-eye"></i> View</a>
                                        <a href="#" class="dept-pdf-btn dept-pdf-btn-download"><i class="fas fa-download"></i> Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="dept-tab-content" id="tab-nl-vol1-issue1">
                    <div class="dept-divider-title">News Letters: Vol. 1 Issue 1</div>
                    <p class="dept-text-body">
                        Inaugural issue of the Mechanical Engineering Department newsletter.
                    </p>
                </section>

            </main>
        </div>
    </div>
</div>

<?php
// Include Footer
include_once __DIR__ . '/../../includes/footer.php';
?>
