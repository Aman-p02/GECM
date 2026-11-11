<?php
$page_title = "Mechanical Engineering | Government Engineering College, Modasa";
$page_description = "Department of Mechanical Engineering at GEC Modasa. Discover cutting-edge thermal, fluid dynamics, CAD/CAM, workshop tooling laboratories and faculty publications.";
$page_keywords = "Mechanical Engineering GEC Modasa, Mechanical GECM, GTU Mechanical Engineering, Mechanical Faculty Modasa, CAD CAM Labs Gujarat";

$active_page = "departments";
$root_path = "../../";

$deptCode = 'ME';
$deptName = 'Mechanical Engineering';

include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../includes/department-seo.php';
?>

<!-- Mechanical Department Stylesheet -->
<link rel="stylesheet" href="css/department.css?v=<?= filemtime(__DIR__ . '/css/department.css') ?>">
<link rel="stylesheet" href="../includes/faculty.css">
<link rel="stylesheet" href="../includes/activities.css">
<link rel="stylesheet" href="../includes/publications.css">
<link rel="stylesheet" href="../includes/advisory-board.css">
<link rel="stylesheet" href="../includes/newsletters.css">

<div class="dept-page" id="mainContent" data-active-tab="about">

    <!-- Sticky sub-navigation bar -->
    <nav class="dept-subnav-bar" id="deptSubNav" aria-label="Department Navigation">
        <div class="dept-container">
            <div class="dept-subnav-wrap" id="deptSubNavWrap">
                <button type="button" class="dept-subnav-arrow-btn prev" id="deptNavScrollPrev"
                    aria-label="Scroll left to view previous tabs">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <ul class="dept-subnav-list" id="deptSubNavList" role="tablist">
                    <li class="dept-subnav-item active">
                        <button type="button" class="dept-subnav-link active" data-tab="about" role="tab"
                            aria-selected="true">About</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="vision-mission" role="tab"
                            aria-selected="false">Vision &amp; Mission</button>
                    </li>
                    <li class="dept-subnav-item">
                        <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer"
                            class="dept-subnav-link" aria-label="GTU Official Syllabus Portal">
                            <span>Syllabus</span>
                            <i class="fas fa-external-link-alt ext-arrow"></i>
                        </a>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="faculty" role="tab"
                            aria-selected="false">Faculty</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="activities" role="tab" aria-selected="false">Activities</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="facilities" role="tab"
                            aria-selected="false">Facilities &amp; Labs</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="publications" role="tab"
                            aria-selected="false">Publications</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="instruction-material" role="tab"
                            aria-selected="false">Instruction Material</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="learning-resources" role="tab"
                            aria-selected="false">Learning Resources</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="instruction-feedback" role="tab"
                            aria-selected="false">Feedback for Instruction material</button>
                    </li>
                    <li class="dept-subnav-item dept-subnav-dropdown">
                        <button type="button" class="dept-subnav-link dept-dropdown-toggle" data-tab="academic-calendar"
                            role="tab" aria-selected="false" aria-haspopup="true" aria-expanded="false">
                            <span>Department Academic Calender</span>
                            <i class="fas fa-chevron-down dept-subnav-arrow"></i>
                        </button>
                        <div class="dept-subnav-menu" role="menu">
                            <a href="#academic-calendar" class="dept-subnav-menu-link" data-tab="academic-calendar"
                                data-row-id="cal-even-2025-26" role="menuitem">EVEN 2025-26</a>
                            <a href="#academic-calendar" class="dept-subnav-menu-link" data-tab="academic-calendar"
                                data-row-id="cal-odd-2025-26" role="menuitem">ODD 2025-26</a>
                            <a href="#academic-calendar" class="dept-subnav-menu-link" data-tab="academic-calendar"
                                data-row-id="cal-even-2024-25" role="menuitem">EVEN 2024-25</a>
                            <a href="#academic-calendar" class="dept-subnav-menu-link" data-tab="academic-calendar"
                                data-row-id="cal-odd-2024-25-rev" role="menuitem">ODD 2024-25 (Revised)</a>
                            <a href="#academic-calendar" class="dept-subnav-menu-link" data-tab="academic-calendar"
                                data-row-id="cal-odd-2024-25" role="menuitem">ODD 2024-25</a>
                            <a href="#academic-calendar" class="dept-subnav-menu-link" data-tab="academic-calendar"
                                data-row-id="cal-even-2023-24-rev" role="menuitem">EVEN 2023-24 (Revised)</a>
                            <a href="#academic-calendar" class="dept-subnav-menu-link" data-tab="academic-calendar"
                                data-row-id="cal-even-2023-24" role="menuitem">EVEN 2023-24</a>
                            <a href="#academic-calendar" class="dept-subnav-menu-link" data-tab="academic-calendar"
                                data-row-id="cal-odd-2023-24" role="menuitem">ODD 2023-24</a>
                            <a href="#academic-calendar" class="dept-subnav-menu-link" data-tab="academic-calendar"
                                data-row-id="cal-even-2022-23" role="menuitem">EVEN 2022-23</a>
                            <a href="#academic-calendar" class="dept-subnav-menu-link" data-tab="academic-calendar"
                                data-row-id="cal-odd-2022-23" role="menuitem">ODD 2022-23</a>
                        </div>
                    </li>
                    <li class="dept-subnav-item dept-subnav-dropdown">
                        <button type="button" class="dept-subnav-link dept-dropdown-toggle"
                            data-tab="industry-advisory-board" role="tab" aria-selected="false" aria-haspopup="true"
                            aria-expanded="false">
                            <span>Industry Advisory Board</span>
                            <i class="fas fa-chevron-down dept-subnav-arrow"></i>
                        </button>
                        <div class="dept-subnav-menu" role="menu">
                            <a href="#industry-advisory-board" class="dept-subnav-menu-link"
                                data-tab="industry-advisory-board" data-row-id="iab-2025-26" role="menuitem">IAB
                                2025-26</a>
                            <a href="#industry-advisory-board" class="dept-subnav-menu-link"
                                data-tab="industry-advisory-board" data-row-id="iab-2024-25" role="menuitem">IAB
                                2024-25</a>
                            <a href="#industry-advisory-board" class="dept-subnav-menu-link"
                                data-tab="industry-advisory-board" data-row-id="iab-2023-24" role="menuitem">IAB
                                2023-24</a>
                            <a href="#industry-advisory-board" class="dept-subnav-menu-link"
                                data-tab="industry-advisory-board" data-row-id="iab-2022-23" role="menuitem">IAB
                                2022-23</a>
                            <a href="#industry-advisory-board" class="dept-subnav-menu-link"
                                data-tab="industry-advisory-board" data-row-id="iab-2021-22" role="menuitem">IAB
                                2021-22</a>
                            <a href="#industry-advisory-board" class="dept-subnav-menu-link"
                                data-tab="industry-advisory-board" data-row-id="iab-2020-21" role="menuitem">IAB
                                2020-21</a>
                            <a href="#industry-advisory-board" class="dept-subnav-menu-link"
                                data-tab="industry-advisory-board" data-row-id="iab-2019-20" role="menuitem">IAB
                                2019-20</a>
                            <a href="#industry-advisory-board" class="dept-subnav-menu-link"
                                data-tab="industry-advisory-board" data-row-id="iab-2018-19" role="menuitem">IAB
                                2018-19</a>
                            <a href="#industry-advisory-board" class="dept-subnav-menu-link"
                                data-tab="industry-advisory-board" data-row-id="iab-2017-18" role="menuitem">IAB
                                2017-18</a>
                        </div>
                    </li>
                    <li class="dept-subnav-item dept-subnav-dropdown">
                        <button type="button" class="dept-subnav-link dept-dropdown-toggle" data-tab="newsletters"
                            role="tab" aria-selected="false" aria-haspopup="true" aria-expanded="false">
                            <span>News Letters</span>
                            <i class="fas fa-chevron-down dept-subnav-arrow"></i>
                        </button>
                        <div class="dept-subnav-menu" role="menu">
                            <a href="#newsletters" class="dept-subnav-menu-link" data-tab="newsletters"
                                data-row-id="nl-2025" role="menuitem">News Letter 2025</a>
                            <a href="#newsletters" class="dept-subnav-menu-link" data-tab="newsletters"
                                data-row-id="nl-2024" role="menuitem">News Letter 2024</a>
                            <a href="#newsletters" class="dept-subnav-menu-link" data-tab="newsletters"
                                data-row-id="nl-2023" role="menuitem">News Letter 2023</a>
                            <a href="#newsletters" class="dept-subnav-menu-link" data-tab="newsletters"
                                data-row-id="nl-2022" role="menuitem">News Letter 2022</a>
                            <a href="#newsletters" class="dept-subnav-menu-link" data-tab="newsletters"
                                data-row-id="nl-2021" role="menuitem">News Letter 2021</a>
                            <a href="#newsletters" class="dept-subnav-menu-link" data-tab="newsletters"
                                data-row-id="nl-2020" role="menuitem">News Letter 2020</a>
                            <a href="#newsletters" class="dept-subnav-menu-link" data-tab="newsletters"
                                data-row-id="nl-2019" role="menuitem">News Letter 2019</a>
                            <a href="#newsletters" class="dept-subnav-menu-link" data-tab="newsletters"
                                data-row-id="nl-2018" role="menuitem">News Letter 2018</a>
                            <a href="#newsletters" class="dept-subnav-menu-link" data-tab="newsletters"
                                data-row-id="nl-2017" role="menuitem">News Letter 2017</a>
                        </div>
                    </li>
                </ul>
                <button type="button" class="dept-subnav-arrow-btn next" id="deptNavScrollNext"
                    aria-label="Scroll right to view more tabs">
                    <span class="dept-subnav-more-label">More</span>
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Main department content sections -->
    <main class="dept-main-content">
        <div class="dept-container">

            <!-- Tab 1: About Department -->
            <section class="dept-tab-pane active" id="tab-about">
                <div class="dept-about-hero" style="margin-bottom: 56px;">
                    <div class="dept-hero-grid">
                        <div class="dept-hero-text">
                            <span class="dept-kicker">DEPARTMENT OF</span>
                            <h1 class="dept-heading">Mechanical Engineering</h1>
                            <p class="dept-tagline">
                                Constituted in the year 1989 with two wings at the Workshop Building and New Academic Building
                                (Building No. 6). Equipped with comprehensive laboratory and workshop facilities dedicated to
                                thermodynamics, machine design, fluid mechanics, and advanced manufacturing.
                            </p>
                        </div>
                        <div class="dept-hero-media">
                            <img src="images/department_building.jpg"
                                alt="Government Engineering College Modasa - Mechanical Engineering Department Building"
                                class="dept-hero-photo">
                        </div>
                    </div>

                    <!-- Key metrics counter strip -->
                    <div class="dept-stats-strip">
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">1989</span>
                            <span class="dept-stat-label">CONSTITUTED YEAR</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">60</span>
                            <span class="dept-stat-label">ANNUAL UG INTAKE</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">NBA</span>
                            <span class="dept-stat-label">ACCREDITED PROGRAMME</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">4 Yrs</span>
                            <span class="dept-stat-label">DEGREE PROGRAMME (UG)</span>
                        </div>
                    </div>
                </div>

                <div class="dept-section-header">
                    <span class="dept-section-kicker">ACADEMIC OVERVIEW</span>
                    <h2>About Department</h2>
                    <p>Delivering foundational and advanced mechanical engineering education, hands-on workshop
                        fabrication, and applied research since 1989.</p>
                </div>

                <div class="dept-story-body">
                    <blockquote class="dept-lead-quote">
                        "Delivering technical programs and services to meet the changing needs of society and industry,
                        empowering graduates to design, analyze, and manufacture cutting-edge mechanical systems."
                    </blockquote>
                    <p>
                        This department has two wings, one at Workshop Building and another at New Academic Building
                        i.e. Building No. 6. It has various laboratories in the area of Heat Power, Thermo Dynamics,
                        Heat and Mass Transfer, IC Engines, Automobiles, Fluid Mechanics and Fluid Power, Kinematics and
                        Dynamics, Material Technology, Metrology and Instrumentation, CAD, CAM and Production
                        Technology. The department has excellent Computer Center and Workshop facilities consisting of
                        carpentry, fitting, turning and milling.
                    </p>
                </div>

                <!-- About the Programme Section -->
                <div class="dept-programme-section">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">PROFESSIONAL CURRICULUM</span>
                        <h2>About the Programme</h2>
                    </div>

                    <div class="dept-story-body">
                        <p>
                            Mechanical engineering is a professional programme which helps students to understand the
                            working mechanisms of heavy tools and machineries. The branch applies principles of
                            engineering, physics and material science for the design, analysis, manufacturing and
                            maintenance of mechanical systems. The course covers technical areas like distribution of
                            electricity through generators, transformers, transmission lines, lighting and wiring in
                            buildings. A course in mechanical engineering makes a student gain knowledge and experience
                            in the designing of electric motors, automobiles, aircrafts and other heavy vehicles.
                            Mechanical engineering demands knowledge about software used in technical work like
                            computer-aided design and mathematical modelling.
                        </p>
                        <p>
                            Mechanical Engineering science emerged in the 19th century as a result of developments in
                            the field of physics. The field has continually evolved to incorporate advancements in
                            technology. Mechanical engineers today are pursuing developments in fields such as
                            composites, mechatronics and nano technology. Mechanical Engineering overlaps with aerospace
                            engineering, civil engineering, electrical engineering, petroleum engineering and chemical
                            engineering to varying amounts.
                        </p>

                    </div>
                </div>

                <!-- Under Graduate  -->
                <div class="dept-section-header" style="margin-top: 56px;">
                    <span class="dept-section-kicker">ACADEMIC DEGREE OFFERINGS</span>
                    <h2>Undergraduate programme</h2>
                    <p>Approved by the All India Council for Technical Education (AICTE), New Delhi and affiliated with
                        Gujarat Technological University (GTU), Ahmedabad.</p>
                </div>

                <div class="dept-table-wrap">
                    <table class="dept-clean-table">
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
                                <td><span class="dept-tag-ug">UG</span></td>
                                <td>4</td>
                                <td>60</td>
                                <td>1989</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Tab 2: Vision & Mission -->
            <section class="dept-tab-pane" id="tab-vision-mission">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">ACADEMIC CHARTER</span>
                    <h2>Vision &amp; Mission</h2>
                    <p>Guiding principles, strategic commitments, and educational objectives defining our engineering
                        pedagogy.</p>
                </div>

                <!-- Vision Card -->
                <div class="dept-charter-card dept-vision-hero-card">
                    <span class="dept-vision-quote-mark">“</span>
                    <blockquote class="dept-vision-statement">
                        Build a strong teaching-learning and research environment to prepare determined, innovative,
                        inventive, self-esteemed and goal oriented mechanical engineers with good technical knowledge,
                        analytical and soft skill.
                    </blockquote>
                </div>

                <!-- Mission Card -->
                <div class="dept-charter-card" style="margin-bottom: 48px;">
                    <h3
                        style="font-size: 1.15rem; font-weight: 700; color: #111; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.05em;">
                        Mission</h3>
                    <p style="font-size: 0.96rem; color: #4b5563; margin-bottom: 24px;">To equip mechanical engineering
                        graduates to face challenges of industries, society and nation by:</p>
                    <ul class="dept-mission-steps">
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">I</span>
                            <div class="dept-mission-text">
                                Providing domain knowledge through qualified, experienced and trained faculties in
                                healthy environment.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">II</span>
                            <div class="dept-mission-text">
                                Developing technical skills and creating awareness about needs of industries by
                                encouraging entrepreneurial attitude.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">III</span>
                            <div class="dept-mission-text">
                                Encouraging graduates to think innovatively through project works with professional
                                ethical practices.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">IV</span>
                            <div class="dept-mission-text">
                                Providing all kinds of support for overall personality development.
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Objectives (PEOs and PSOs) -->
                <div class="dept-objectives-grid">
                    <div class="dept-obj-card">
                        <h4>Program Educational Objectives PEOs</h4>
                        <div class="dept-obj-lead">Graduates from the Mechanical Engineering Program are expected to
                            attain or achieve the following Program Educational Objectives</div>
                        <ul class="dept-obj-list">
                            <li><strong>PEO1:</strong> Implement the acquired knowledge of science, technology,
                                engineering, management (STEM) with good human values for a successful career.</li>
                            <li><strong>PEO2:</strong> Achieve a position of leadership in the organization through
                                managerial, communication and professional skills with ethical values.</li>
                            <li><strong>PEO3:</strong> Be a foundation for innovative solutions of complicated problems
                                as a successful entrepreneur.</li>
                            <li><strong>PEO4:</strong> Provide feasible solutions for sustainable and environment
                                friendly development.</li>
                        </ul>
                    </div>

                    <div class="dept-obj-card">
                        <h4>Program Specific Outcomes PSOs</h4>
                        <div class="dept-obj-lead">Mechanical Engineering Graduate will be able to:</div>
                        <ul class="dept-obj-list">
                            <li><strong>PSO1:</strong> Apply the specific skill acquired for solving problems related to
                                mechanical engineering and interdisciplinary problems with knowledge of Science,
                                Technology, Engineering and Mathematics (STEM) and modern software skills.</li>
                            <li><strong>PSO2:</strong> Develop optimum engineering systems by acquiring the knowledge of
                                specialized areas such as product design and its optimization, manufacturing and thermal
                                science.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Tab: Faculty Directory (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/faculty-tab.php'; ?>

            <!-- Tab: Activities & Events (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/activities-tab.php'; ?>

            <!-- Tab 3: Laboratory facilities -->
            <section class="dept-tab-pane" id="tab-facilities">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">EXPERIMENTAL INFRASTRUCTURE</span>
                    <h2>Laboratories &amp; Facilities</h2>
                    <p>Dedicated Workshop Building and New Academic Building (Building No. 6) equipped with
                        comprehensive experimental rigs and modern workshop facilities.</p>
                </div>

                <div class="dept-labs-showcase">
                    <!-- Facility 1: CAD / CAM Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame dept-lab-slider" data-lab-slider data-autoplay="4000">
                            <div class="dept-lab-slides">
                                <div class="dept-lab-slide active">
                                    <img src="images/labs/lab_cnc_manufacturing.jpg"
                                        alt="Fortune Industrial CNC Turning Center" loading="lazy"
                                        onerror="this.src='../../images/slider/default.jpg'">
                                    <span class="dept-lab-slide-caption">Fortune Industrial CNC Turning Center</span>
                                </div>
                                <div class="dept-lab-slide">
                                    <img src="images/labs/lab_wirecut_edm.jpg"
                                        alt="Electronica Wire-Cut EDM &amp; Spark Erosion Machine" loading="lazy"
                                        onerror="this.src='../../images/slider/default.jpg'">
                                    <span class="dept-lab-slide-caption">Electronica Wire-Cut EDM &amp; Spark Erosion
                                        Machine</span>
                                </div>
                            </div>
                            <button type="button" class="dept-lab-slide-nav prev" aria-label="Previous photo"
                                onclick="prevLabSlide(this, event)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button type="button" class="dept-lab-slide-nav next" aria-label="Next photo"
                                onclick="nextLabSlide(this, event)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <div class="dept-lab-slide-dots">
                                <button type="button" class="dept-lab-dot active" aria-label="Photo 1"
                                    onclick="goLabSlide(this, 0, event)"></button>
                                <button type="button" class="dept-lab-dot" aria-label="Photo 2"
                                    onclick="goLabSlide(this, 1, event)"></button>
                            </div>
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Building No. 6</span>
                            <h3 class="dept-lab-title">CAD / CAM Lab</h3>
                            <p class="dept-lab-desc">
                                Equipped with industrial CNC turning, Wire-Cut EDM, spark erosion, and 5-axis robotic
                                automation.
                            </p>
                        </div>
                    </div>

                    <!-- Facility 2: CAD Simulation & Computing Center -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_cad_simulation.jpg"
                                alt="CAD Simulation and High-Performance Computing Center" loading="lazy"
                                onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Building No. 6</span>
                            <h3 class="dept-lab-title">CAD Simulation &amp; Computing Center</h3>
                            <p class="dept-lab-desc">
                                High-performance workstations running licensed ANSYS, MATLAB, and 3D design modeling
                                packages.
                            </p>
                        </div>
                    </div>

                    <!-- Facility 3: Internal Combustion Engine and Automobile Engineering Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame dept-lab-slider" data-lab-slider data-autoplay="4000">
                            <div class="dept-lab-slides">
                                <div class="dept-lab-slide active">
                                    <img src="images/labs/lab_ic_engine.jpg" alt="Working Car Model Chassis Rig"
                                        loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                                    <span class="dept-lab-slide-caption">Car Model Chassis &amp; Engine Test Rig</span>
                                </div>
                                <div class="dept-lab-slide">
                                    <img src="images/labs/lab_automobile_systems.jpg"
                                        alt="Vehicle Steering, Suspension &amp; Brake Test Setup" loading="lazy"
                                        onerror="this.src='../../images/slider/default.jpg'">
                                    <span class="dept-lab-slide-caption">Vehicle Steering, Suspension &amp; Brake Test
                                        Setup</span>
                                </div>
                            </div>
                            <button type="button" class="dept-lab-slide-nav prev" aria-label="Previous photo"
                                onclick="prevLabSlide(this, event)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button type="button" class="dept-lab-slide-nav next" aria-label="Next photo"
                                onclick="nextLabSlide(this, event)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <div class="dept-lab-slide-dots">
                                <button type="button" class="dept-lab-dot active" aria-label="Photo 1"
                                    onclick="goLabSlide(this, 0, event)"></button>
                                <button type="button" class="dept-lab-dot" aria-label="Photo 2"
                                    onclick="goLabSlide(this, 1, event)"></button>
                            </div>
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Workshop Building</span>
                            <h3 class="dept-lab-title">Internal Combustion Engine &amp; Automobile Lab</h3>
                            <p class="dept-lab-desc">
                                Computerized VCR engine test rigs, 5-gas exhaust analyzer, and working vehicle chassis
                                setup.
                            </p>
                        </div>
                    </div>

                    <!-- Facility 4: Fluid Mechanics and Hydraulic Machine Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame dept-lab-slider" data-lab-slider data-autoplay="4000">
                            <div class="dept-lab-slides">
                                <div class="dept-lab-slide active">
                                    <img src="images/labs/lab_fluid_mechanics.jpg"
                                        alt="Centrifugal Pump Test Rig &amp; Hydraulic Bench" loading="lazy"
                                        onerror="this.src='../../images/slider/default.jpg'">
                                    <span class="dept-lab-slide-caption">Centrifugal Pump Test Rig &amp; Hydraulic
                                        Bench</span>
                                </div>
                                <div class="dept-lab-slide">
                                    <img src="images/labs/lab_fluid_turbomachines.jpg"
                                        alt="Indo-Air Multi-Stage Air Compressor Test Rig" loading="lazy"
                                        onerror="this.src='../../images/slider/default.jpg'">
                                    <span class="dept-lab-slide-caption">Indo-Air Multi-Stage Air Compressor Test
                                        Rig</span>
                                </div>
                            </div>
                            <button type="button" class="dept-lab-slide-nav prev" aria-label="Previous photo"
                                onclick="prevLabSlide(this, event)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button type="button" class="dept-lab-slide-nav next" aria-label="Next photo"
                                onclick="nextLabSlide(this, event)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <div class="dept-lab-slide-dots">
                                <button type="button" class="dept-lab-dot active" aria-label="Photo 1"
                                    onclick="goLabSlide(this, 0, event)"></button>
                                <button type="button" class="dept-lab-dot" aria-label="Photo 2"
                                    onclick="goLabSlide(this, 1, event)"></button>
                            </div>
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Workshop Building</span>
                            <h3 class="dept-lab-title">Fluid Mechanics &amp; Hydraulic Machine Lab</h3>
                            <p class="dept-lab-desc">
                                Volumetric hydraulic bench, Pelton turbine, pump test rigs, and multi-stage air
                                compressor.
                            </p>
                        </div>
                    </div>

                    <!-- Facility 5: Heat Transfer Science Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame dept-lab-slider" data-lab-slider data-autoplay="4000">
                            <div class="dept-lab-slides">
                                <div class="dept-lab-slide active">
                                    <img src="images/labs/lab_heat_transfer.jpg"
                                        alt="Coolpex Cross Flow Heat Exchanger Apparatus" loading="lazy"
                                        onerror="this.src='../../images/slider/default.jpg'">
                                    <span class="dept-lab-slide-caption">Coolpex Cross Flow Heat Exchanger
                                        Apparatus</span>
                                </div>
                                <div class="dept-lab-slide">
                                    <img src="images/labs/lab_heat_transfer_rigs.jpg"
                                        alt="Thermal Convection &amp; Heat Transfer Experimental Rig" loading="lazy"
                                        onerror="this.src='../../images/slider/default.jpg'">
                                    <span class="dept-lab-slide-caption">Thermal Convection &amp; Heat Transfer
                                        Experimental Rig</span>
                                </div>
                            </div>
                            <button type="button" class="dept-lab-slide-nav prev" aria-label="Previous photo"
                                onclick="prevLabSlide(this, event)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button type="button" class="dept-lab-slide-nav next" aria-label="Next photo"
                                onclick="nextLabSlide(this, event)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <div class="dept-lab-slide-dots">
                                <button type="button" class="dept-lab-dot active" aria-label="Photo 1"
                                    onclick="goLabSlide(this, 0, event)"></button>
                                <button type="button" class="dept-lab-dot" aria-label="Photo 2"
                                    onclick="goLabSlide(this, 1, event)"></button>
                            </div>
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Workshop Building</span>
                            <h3 class="dept-lab-title">Heat Transfer Science Lab</h3>
                            <p class="dept-lab-desc">
                                Cross-flow heat exchangers, conduction apparatus, convection test rigs, and emissivity
                                setups.
                            </p>
                        </div>
                    </div>

                    <!-- Facility 6: Refrigeration and Air Conditioning Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame dept-lab-slider" data-lab-slider data-autoplay="4000">
                            <div class="dept-lab-slides">
                                <div class="dept-lab-slide active">
                                    <img src="images/labs/lab_rac.jpg"
                                        alt="Vapour Compression &amp; Absorption Refrigeration Rig" loading="lazy"
                                        onerror="this.src='../../images/slider/default.jpg'">
                                    <span class="dept-lab-slide-caption">Vapour Absorption Rig &amp; Air Conditioning
                                        Trainer</span>
                                </div>
                                <div class="dept-lab-slide">
                                    <img src="images/labs/lab_rac_appliances.jpg"
                                        alt="Air Conditioner &amp; Pin Fin Apparatus Test Setup" loading="lazy"
                                        onerror="this.src='../../images/slider/default.jpg'">
                                    <span class="dept-lab-slide-caption">Air Conditioner &amp; Pin Fin Experimental
                                        Setup</span>
                                </div>
                            </div>
                            <button type="button" class="dept-lab-slide-nav prev" aria-label="Previous photo"
                                onclick="prevLabSlide(this, event)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button type="button" class="dept-lab-slide-nav next" aria-label="Next photo"
                                onclick="nextLabSlide(this, event)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <div class="dept-lab-slide-dots">
                                <button type="button" class="dept-lab-dot active" aria-label="Photo 1"
                                    onclick="goLabSlide(this, 0, event)"></button>
                                <button type="button" class="dept-lab-dot" aria-label="Photo 2"
                                    onclick="goLabSlide(this, 1, event)"></button>
                            </div>
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Workshop Building</span>
                            <h3 class="dept-lab-title">Refrigeration &amp; Air Conditioning (RAC) Lab</h3>
                            <p class="dept-lab-desc">
                                Vapour compression and absorption rigs, air conditioning test trainers, and cooling
                                apparatus.
                            </p>
                        </div>
                    </div>

                    <!-- Facility 7: Kinematics & Dynamics of Machine Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame dept-lab-slider" data-lab-slider data-autoplay="4000">
                            <div class="dept-lab-slides">
                                <div class="dept-lab-slide active">
                                    <img src="images/labs/lab_dynamics_machines.jpg"
                                        alt="Kinematic Mechanism Models &amp; Gear Trains" loading="lazy"
                                        onerror="this.src='../../images/slider/default.jpg'">
                                    <span class="dept-lab-slide-caption">Kinematic Mechanism Models &amp; Gear
                                        Trains</span>
                                </div>
                                <div class="dept-lab-slide">
                                    <img src="images/labs/lab_dynamics_gears.jpg"
                                        alt="Differential Gear Mechanism &amp; Dynamic Balancing Rig" loading="lazy"
                                        onerror="this.src='../../images/slider/default.jpg'">
                                    <span class="dept-lab-slide-caption">Differential Gear Mechanism &amp; Dynamic
                                        Balancing Rig</span>
                                </div>
                            </div>
                            <button type="button" class="dept-lab-slide-nav prev" aria-label="Previous photo"
                                onclick="prevLabSlide(this, event)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button type="button" class="dept-lab-slide-nav next" aria-label="Next photo"
                                onclick="nextLabSlide(this, event)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <div class="dept-lab-slide-dots">
                                <button type="button" class="dept-lab-dot active" aria-label="Photo 1"
                                    onclick="goLabSlide(this, 0, event)"></button>
                                <button type="button" class="dept-lab-dot" aria-label="Photo 2"
                                    onclick="goLabSlide(this, 1, event)"></button>
                            </div>
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Building No. 6</span>
                            <h3 class="dept-lab-title">Kinematics &amp; Dynamics of Machine Lab</h3>
                            <p class="dept-lab-desc">
                                Gear train mechanisms, differential drive, balancing test rigs, and vibration
                                measurement apparatus.
                            </p>
                        </div>
                    </div>

                    <!-- Facility 8: Manufacturing Process Lab (Machine Lab) -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame dept-lab-slider" data-lab-slider data-autoplay="4000">
                            <div class="dept-lab-slides">
                                <div class="dept-lab-slide active">
                                    <img src="images/labs/lab_manufacturing_process.jpg"
                                        alt="Precision Turning Machines &amp; Lathe Line" loading="lazy"
                                        onerror="this.src='../../images/hero_campus_1.jpg'">
                                    <span class="dept-lab-slide-caption">Precision Turning Machines &amp; Lathe
                                        Line</span>
                                </div>
                                <div class="dept-lab-slide">
                                    <img src="images/labs/lab_manufacturing_lathes.jpg"
                                        alt="HMT Series-10 Precision Lathe Machines" loading="lazy"
                                        onerror="this.src='../../images/hero_campus_1.jpg'">
                                    <span class="dept-lab-slide-caption">HMT Series-10 Precision Lathe Machines</span>
                                </div>
                                <div class="dept-lab-slide">
                                    <img src="images/labs/lab_manufacturing_shearing.jpg"
                                        alt="Industrial Hydraulic Shearing &amp; Cutting Machine" loading="lazy"
                                        onerror="this.src='../../images/hero_campus_1.jpg'">
                                    <span class="dept-lab-slide-caption">Industrial Hydraulic Shearing &amp; Cutting
                                        Machine</span>
                                </div>
                            </div>
                            <button type="button" class="dept-lab-slide-nav prev" aria-label="Previous photo"
                                onclick="prevLabSlide(this, event)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button type="button" class="dept-lab-slide-nav next" aria-label="Next photo"
                                onclick="nextLabSlide(this, event)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <div class="dept-lab-slide-dots">
                                <button type="button" class="dept-lab-dot active" aria-label="Photo 1"
                                    onclick="goLabSlide(this, 0, event)"></button>
                                <button type="button" class="dept-lab-dot" aria-label="Photo 2"
                                    onclick="goLabSlide(this, 1, event)"></button>
                                <button type="button" class="dept-lab-dot" aria-label="Photo 3"
                                    onclick="goLabSlide(this, 2, event)"></button>
                            </div>
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Workshop Building</span>
                            <h3 class="dept-lab-title">Manufacturing Process Lab (Machine Lab)</h3>
                            <p class="dept-lab-desc">
                                Center lathes, shapers, radial drills, hydraulic shearing, power press, and EDM
                                machinery.
                            </p>
                        </div>
                    </div>

                    <!-- Facility 9: Basic Mechanical Engineering Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame dept-lab-slider" data-lab-slider data-autoplay="4000">
                            <div class="dept-lab-slides">
                                <div class="dept-lab-slide active">
                                    <img src="images/labs/lab_basic_mechanical.jpg"
                                        alt="Steam Boiler Cut-Section &amp; Fire Tube Demonstration Models"
                                        loading="lazy" onerror="this.src='../../images/hero_campus_2.jpg'">
                                    <span class="dept-lab-slide-caption">Steam Boiler Cut-Section &amp; Fire Tube
                                        Demonstration Models</span>
                                </div>
                                <div class="dept-lab-slide">
                                    <img src="images/labs/lab_basic_mechanical_boilers.jpg"
                                        alt="Water Tube Boilers, Evaporator &amp; Engine Models" loading="lazy"
                                        onerror="this.src='../../images/hero_campus_2.jpg'">
                                    <span class="dept-lab-slide-caption">Water Tube Boilers, Evaporator &amp; Engine
                                        Models</span>
                                </div>
                            </div>
                            <button type="button" class="dept-lab-slide-nav prev" aria-label="Previous photo"
                                onclick="prevLabSlide(this, event)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button type="button" class="dept-lab-slide-nav next" aria-label="Next photo"
                                onclick="nextLabSlide(this, event)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <div class="dept-lab-slide-dots">
                                <button type="button" class="dept-lab-dot active" aria-label="Photo 1"
                                    onclick="goLabSlide(this, 0, event)"></button>
                                <button type="button" class="dept-lab-dot" aria-label="Photo 2"
                                    onclick="goLabSlide(this, 1, event)"></button>
                            </div>
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Building No. 6</span>
                            <h3 class="dept-lab-title">Basic Mechanical Engineering Lab</h3>
                            <p class="dept-lab-desc">
                                Cut-section demonstration models of Cochran, Babcock &amp; Wilcox, and Lancashire steam
                                boilers.
                            </p>
                        </div>
                    </div>

                    <!-- Facility 10: Central Mechanical Workshop -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame dept-lab-slider" data-lab-slider data-autoplay="4000">
                            <div class="dept-lab-slides">
                                <div class="dept-lab-slide active">
                                    <img src="images/labs/workshop_building_exterior.jpg"
                                        alt="Workshop Building Main Entrance" loading="lazy"
                                        onerror="this.src='../../images/hero_campus_1.jpg'">
                                    <span class="dept-lab-slide-caption">Workshop Building &bull; Main Entrance</span>
                                </div>
                                <div class="dept-lab-slide">
                                    <img src="images/labs/workshop_main_bay.jpg"
                                        alt="Central Workshop Main Machine and Fabrication Bay" loading="lazy"
                                        onerror="this.src='../../images/hero_campus_1.jpg'">
                                    <span class="dept-lab-slide-caption">Central Workshop Main Machine &amp; Fabrication
                                        Bay</span>
                                </div>
                                <div class="dept-lab-slide">
                                    <img src="images/labs/workshop_fitting_carpentry.jpg"
                                        alt="Fitting and Carpentry Workbenches with Heavy Vises" loading="lazy"
                                        onerror="this.src='../../images/hero_campus_1.jpg'">
                                    <span class="dept-lab-slide-caption">Fitting &amp; Carpentry Benches with Heavy
                                        Vises</span>
                                </div>
                                <div class="dept-lab-slide">
                                    <img src="images/labs/workshop_milling_shapers.jpg"
                                        alt="Universal Milling Machine and Shaping Machinery Row" loading="lazy"
                                        onerror="this.src='../../images/hero_campus_1.jpg'">
                                    <span class="dept-lab-slide-caption">Universal Milling Machine &amp; Shaping
                                        Machinery Row</span>
                                </div>
                                <div class="dept-lab-slide">
                                    <img src="images/labs/workshop_lathe_machines.jpg"
                                        alt="Heavy Industrial Center Lathes Section" loading="lazy"
                                        onerror="this.src='../../images/hero_campus_1.jpg'">
                                    <span class="dept-lab-slide-caption">Heavy Industrial Center Lathes Section</span>
                                </div>
                            </div>
                            <button type="button" class="dept-lab-slide-nav prev" aria-label="Previous photo"
                                onclick="prevLabSlide(this, event)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button type="button" class="dept-lab-slide-nav next" aria-label="Next photo"
                                onclick="nextLabSlide(this, event)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            <div class="dept-lab-slide-dots">
                                <button type="button" class="dept-lab-dot active" aria-label="Photo 1"
                                    onclick="goLabSlide(this, 0, event)"></button>
                                <button type="button" class="dept-lab-dot" aria-label="Photo 2"
                                    onclick="goLabSlide(this, 1, event)"></button>
                                <button type="button" class="dept-lab-dot" aria-label="Photo 3"
                                    onclick="goLabSlide(this, 2, event)"></button>
                                <button type="button" class="dept-lab-dot" aria-label="Photo 4"
                                    onclick="goLabSlide(this, 3, event)"></button>
                                <button type="button" class="dept-lab-dot" aria-label="Photo 5"
                                    onclick="goLabSlide(this, 4, event)"></button>
                            </div>
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Workshop Building</span>
                            <h3 class="dept-lab-title">Central Mechanical Workshop</h3>
                            <p class="dept-lab-desc">
                                Machine bays with center lathes, milling machines, shapers, carpentry, and welding
                                booths.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Key Department Facilities Summary Grid -->
                <div class="dept-section-header" style="margin-top: 56px;">
                    <span class="dept-section-kicker">INFRASTRUCTURE HIGHLIGHTS</span>
                    <h2>Department Laboratory Facilities</h2>
                    <p>Overview of practical engineering training grounds across mechanical disciplines.</p>
                </div>

                <div class="dept-facilities-grid">
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-robot"></i></div>
                        <div class="dept-facility-info">
                            <h4>CAD / CAM &amp; Robotics</h4>
                            <p>Industrial Fortune CNC turning centre, Wire-Cut EDM, vertical milling, and automation
                                equipment.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-desktop"></i></div>
                        <div class="dept-facility-info">
                            <h4>Simulation &amp; Computing Center</h4>
                            <p>High-end personal workstations equipped with licensed ANSYS, MATLAB, and 3D CAD modeling
                                software.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-car-side"></i></div>
                        <div class="dept-facility-info">
                            <h4>IC Engine &amp; Automobile Lab</h4>
                            <p>VCR engine test rig, 5-gas exhaust analyzer, car model chassis, and multi-cylinder cut
                                sections.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-water"></i></div>
                        <div class="dept-facility-info">
                            <h4>Fluid Mechanics &amp; Turbomachines</h4>
                            <p>Volumetric hydraulic bench, Reynolds apparatus, Pelton turbine, and centrifugal pump test
                                rigs.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-fire-alt"></i></div>
                        <div class="dept-facility-info">
                            <h4>Heat Transfer Laboratory</h4>
                            <p>Coolpex cross flow heat exchanger, two-phase flow rig, thermal conductivity, and
                                convection test benches.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-snowflake"></i></div>
                        <div class="dept-facility-info">
                            <h4>Refrigeration &amp; Air Conditioning</h4>
                            <p>Vapour compression &amp; absorption systems, Electrolux refrigerator, and air
                                conditioning test benches.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-cogs"></i></div>
                        <div class="dept-facility-info">
                            <h4>Dynamics &amp; Kinematics of Machines</h4>
                            <p>Mechanism models, balancing rigs, motorized gyroscope, governors, and vibration analysis
                                equipment.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-tools"></i></div>
                        <div class="dept-facility-info">
                            <h4>Central Mechanical Workshop</h4>
                            <p>Comprehensive machine tooling, carpentry, fitting, turning, milling, and welding bays.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 4: Publications -->
            <!-- Tab: Publications (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/publications-tab.php'; ?>

            <!-- Tab 5: Instruction Material -->
            <section class="dept-tab-pane" id="tab-instruction-material">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">CURRICULUM &amp; COURSEWARE</span>
                    <h2>Instruction Material</h2>
                    <p>Subject-wise lecture notes, laboratory manuals, assignment sheets, and question banks prepared by
                        faculty members.</p>
                </div>

                <div class="dept-doc-card">
                    <div class="dept-doc-empty">
                        <i class="fas fa-book-open dept-doc-icon"></i>
                        <h3>Course Materials &amp; Lecture Handouts</h3>
                        <p>Detailed syllabus units, instructional slides, and lab guides will be uploaded soon. Please
                            check back shortly or contact the department academic coordinator.</p>
                        <span class="dept-doc-badge"><i class="fas fa-clock"></i> Updating for 2025-26 Session</span>
                    </div>
                </div>
            </section>

            <!-- Tab 6: Learning Resources -->
            <section class="dept-tab-pane" id="tab-learning-resources">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">E-LEARNING &amp; DIGITAL REPOSITORIES</span>
                    <h2>Learning Resources</h2>
                    <p>Curated digital learning portals, virtual laboratories, video lectures, and open-source
                        simulation tools.</p>
                </div>

                <div class="dept-resources-grid">
                    <div class="dept-resource-card">
                        <div class="dept-resource-icon"><i class="fas fa-laptop-code"></i></div>
                        <div class="dept-resource-body">
                            <h4>NPTEL &amp; SWAYAM Online Courses</h4>
                            <p>Video courses by IIT &amp; IISc professors in fluid mechanics, heat transfer, CAD/CAM,
                                and dynamics of machines.</p>
                            <a href="https://nptel.ac.in/" target="_blank" rel="noopener noreferrer"
                                class="dept-resource-link">
                                <span>Visit NPTEL Portal</span>
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>

                    <div class="dept-resource-card">
                        <div class="dept-resource-icon"><i class="fas fa-flask"></i></div>
                        <div class="dept-resource-body">
                            <h4>Virtual Labs (MoE Govt. of India)</h4>
                            <p>Remote simulation experiments for mechanical engineering laboratories including thermal
                                engineering and vibration analysis.</p>
                            <a href="https://www.vlab.co.in/" target="_blank" rel="noopener noreferrer"
                                class="dept-resource-link">
                                <span>Access Virtual Labs</span>
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>

                    <div class="dept-resource-card">
                        <div class="dept-resource-icon"><i class="fas fa-book-reader"></i></div>
                        <div class="dept-resource-body">
                            <h4>National Digital Library of India (NDLI)</h4>
                            <p>Vast repository of academic books, peer-reviewed journals, video lectures, and technical
                                monographs.</p>
                            <a href="https://ndl.iitkgp.ac.in/" target="_blank" rel="noopener noreferrer"
                                class="dept-resource-link">
                                <span>Explore NDLI</span>
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>

                    <div class="dept-resource-card">
                        <div class="dept-resource-icon"><i class="fas fa-drafting-compass"></i></div>
                        <div class="dept-resource-body">
                            <h4>GTU E-Library &amp; Study Portals</h4>
                            <p>Gujarat Technological University digital question papers, thesis repositories, and
                                instructional guides.</p>
                            <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer"
                                class="dept-resource-link">
                                <span>GTU Syllabus &amp; Materials</span>
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 7: Feedback for Instruction Material -->
            <section class="dept-tab-pane" id="tab-instruction-feedback">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">ACADEMIC AUDIT &amp; PEDAGOGY ENHANCEMENT</span>
                    <h2>Feedback for Instruction Material</h2>
                    <p>Continuous feedback mechanisms enabling students and stakeholders to assess course materials and
                        suggest improvements.</p>
                </div>

                <div class="dept-feedback-card">
                    <div class="dept-feedback-header">
                        <div class="dept-feedback-icon"><i class="fas fa-comment-dots"></i></div>
                        <div>
                            <h3>Instructional Material Feedback Process</h3>
                            <p>Your constructive feedback helps us elevate course clarity, laboratory exercises, and
                                digital learning outcomes.</p>
                        </div>
                    </div>
                    <div class="dept-feedback-body">
                        <p>Department of Mechanical Engineering conducts periodic reviews of lecture notes, lab manuals,
                            and assignments. Students are encouraged to provide objective evaluation on content depth,
                            clarity, and industry relevance.</p>
                        <div class="dept-feedback-actions">
                            <span class="dept-feedback-status"><i class="fas fa-info-circle"></i> Feedback form links
                                will be activated during the instructional feedback window.</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 8: Department Academic Calendar -->
            <section class="dept-tab-pane" id="tab-academic-calendar">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">TERM DATES &amp; SESSION SCHEDULES</span>
                    <h2>Department Academic Calendar</h2>
                    <p>Official schedules of academic terms, commencement dates, mid-term examinations, and
                        instructional milestones.</p>
                </div>

                <div class="dept-table-wrap">
                    <table class="dept-clean-table dept-doc-table">
                        <thead>
                            <tr>
                                <th>Academic Session</th>
                                <th>Term / Schedule</th>
                                <th>Status</th>
                                <th style="text-align: right;">Document</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="cal-even-2025-26">
                                <td><strong>Academic Year 2025-26</strong></td>
                                <td><span class="dept-tag-ug">EVEN Term</span> EVEN 2025-26</td>
                                <td><span class="dept-badge-active">Upcoming</span></td>
                                <td style="text-align: right;"><button type="button" class="dept-btn-download"
                                        disabled><i class="fas fa-file-pdf"></i> Download PDF</button></td>
                            </tr>
                            <tr id="cal-odd-2025-26">
                                <td><strong>Academic Year 2025-26</strong></td>
                                <td><span class="dept-tag-ug">ODD Term</span> ODD 2025-26</td>
                                <td><span class="dept-badge-active">Upcoming</span></td>
                                <td style="text-align: right;"><button type="button" class="dept-btn-download"
                                        disabled><i class="fas fa-file-pdf"></i> Download PDF</button></td>
                            </tr>
                            <tr id="cal-even-2024-25">
                                <td><strong>Academic Year 2024-25</strong></td>
                                <td><span class="dept-tag-ug">EVEN Term</span> EVEN 2024-25</td>
                                <td><span class="dept-badge">Active</span></td>
                                <td style="text-align: right;"><button type="button" class="dept-btn-download"
                                        disabled><i class="fas fa-file-pdf"></i> Download PDF</button></td>
                            </tr>
                            <tr id="cal-odd-2024-25-rev">
                                <td><strong>Academic Year 2024-25</strong></td>
                                <td><span class="dept-tag-ug">ODD Term</span> ODD 2024-25 (Revised)</td>
                                <td><span class="dept-badge">Archived</span></td>
                                <td style="text-align: right;"><button type="button" class="dept-btn-download"
                                        disabled><i class="fas fa-file-pdf"></i> Download PDF</button></td>
                            </tr>
                            <tr id="cal-odd-2024-25">
                                <td><strong>Academic Year 2024-25</strong></td>
                                <td><span class="dept-tag-ug">ODD Term</span> ODD 2024-25</td>
                                <td><span class="dept-badge">Archived</span></td>
                                <td style="text-align: right;"><button type="button" class="dept-btn-download"
                                        disabled><i class="fas fa-file-pdf"></i> Download PDF</button></td>
                            </tr>
                            <tr id="cal-even-2023-24-rev">
                                <td><strong>Academic Year 2023-24</strong></td>
                                <td><span class="dept-tag-ug">EVEN Term</span> EVEN 2023-24 (Revised)</td>
                                <td><span class="dept-badge">Archived</span></td>
                                <td style="text-align: right;"><button type="button" class="dept-btn-download"
                                        disabled><i class="fas fa-file-pdf"></i> Download PDF</button></td>
                            </tr>
                            <tr id="cal-even-2023-24">
                                <td><strong>Academic Year 2023-24</strong></td>
                                <td><span class="dept-tag-ug">EVEN Term</span> EVEN 2023-24</td>
                                <td><span class="dept-badge">Archived</span></td>
                                <td style="text-align: right;"><button type="button" class="dept-btn-download"
                                        disabled><i class="fas fa-file-pdf"></i> Download PDF</button></td>
                            </tr>
                            <tr id="cal-odd-2023-24">
                                <td><strong>Academic Year 2023-24</strong></td>
                                <td><span class="dept-tag-ug">ODD Term</span> ODD 2023-24</td>
                                <td><span class="dept-badge">Archived</span></td>
                                <td style="text-align: right;"><button type="button" class="dept-btn-download"
                                        disabled><i class="fas fa-file-pdf"></i> Download PDF</button></td>
                            </tr>
                            <tr id="cal-even-2022-23">
                                <td><strong>Academic Year 2022-23</strong></td>
                                <td><span class="dept-tag-ug">EVEN Term</span> EVEN 2022-23</td>
                                <td><span class="dept-badge">Archived</span></td>
                                <td style="text-align: right;"><button type="button" class="dept-btn-download"
                                        disabled><i class="fas fa-file-pdf"></i> Download PDF</button></td>
                            </tr>
                            <tr id="cal-odd-2022-23">
                                <td><strong>Academic Year 2022-23</strong></td>
                                <td><span class="dept-tag-ug">ODD Term</span> ODD 2022-23</td>
                                <td><span class="dept-badge">Archived</span></td>
                                <td style="text-align: right;"><button type="button" class="dept-btn-download"
                                        disabled><i class="fas fa-file-pdf"></i> Download PDF</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Tab 9: Industry Advisory Board (Dynamic from Admin Panel) -->
            <?php 
            $boardPaneId = 'tab-industry-advisory-board';
            include __DIR__ . '/../includes/advisory-board-tab.php'; 
            ?>

            <!-- Tab 10: Department Newsletters (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/newsletters-tab.php'; ?>

        </div>
    </main>

</div>

<!-- Department JavaScript Component -->
<script src="js/department.js?v=<?= filemtime(__DIR__ . '/js/department.js') ?>"></script>

<?php
include_once __DIR__ . '/../../includes/footer.php';
?>