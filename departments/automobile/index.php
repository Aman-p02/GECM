<?php
/**
 * Government Engineering College, Modasa (GECM)
 * Department of Automobile Engineering
 *
 * Production-ready, fully responsive institutional department portal.
 * Adheres strictly to the GECM Design System, WCAG 2.2 AA accessibility,
 * and high-performance standards.
 */

$page_title = "Automobile Engineering | Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";

// Include global header component
include_once __DIR__ . '/../../includes/header.php';
?>

<!-- Automobile Department Stylesheet -->
<link rel="stylesheet" href="css/department.css">

<div class="dept-page" id="mainContent">

    <!-- Hero Header Banner -->
    <header class="dept-hero-banner" role="banner">
        <div class="dept-container">
            <div class="dept-hero-grid">
                <!-- Left text content -->
                <div class="dept-hero-text">
                    <span class="dept-kicker">GOVERNMENT ENGINEERING COLLEGE, MODASA</span>
                    <h1 class="dept-title">Automobile Engineering</h1>
                    <p class="dept-subtitle">
                        Premier Center for Automotive Systems, Internal Combustion Engines, Vehicle Dynamics, and Mobility Innovation since 2008.
                    </p>
                </div>

                <!-- Right visual building card -->
                <div class="dept-hero-card">
                    <div class="dept-card-inner">
                        <img src="images/department_building.jpg" alt="Automobile Engineering Department Building" class="dept-card-image" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        <div class="dept-card-overlay">
                            <span class="dept-card-badge">ESTD. 2008</span>
                            <h3 class="dept-card-title">Automobile Engineering Wing</h3>
                            <p class="dept-card-meta">Separate Building with Labs, Workshop &amp; AC Conference Room</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key metrics counter strip -->
            <div class="dept-stats-strip">
                <div class="dept-stat-item">
                    <span class="dept-stat-num">2008</span>
                    <span class="dept-stat-label">CONSTITUTED YEAR</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">30</span>
                    <span class="dept-stat-label">ANNUAL UG INTAKE</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">1st</span>
                    <span class="dept-stat-label">IN GECM (2014 RESULT)</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">14+</span>
                    <span class="dept-stat-label">LABS &amp; WORKSHOPS</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Sticky sub-navigation bar -->
    <nav class="dept-subnav-bar" id="deptSubNav" aria-label="Department Navigation">
        <div class="dept-container">
            <div class="dept-subnav-wrap">
                <ul class="dept-subnav-list" role="tablist">
                    <li class="dept-subnav-item active">
                        <button type="button" class="dept-subnav-link active" data-tab="about" role="tab" aria-selected="true">About</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="vision-mission" role="tab" aria-selected="false">Vision &amp; Mission</button>
                    </li>
                    <li class="dept-subnav-item">
                        <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="dept-subnav-link" aria-label="GTU Official Syllabus Portal">
                            <span>Syllabus</span>
                            <i class="fas fa-external-link-alt ext-arrow"></i>
                        </a>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" role="tab" aria-selected="false" style="opacity: 0.6; cursor: default;">Faculty</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" role="tab" aria-selected="false" style="opacity: 0.6; cursor: default;">Activities</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="facilities" role="tab" aria-selected="false">Facilities &amp; Labs</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="publications" role="tab" aria-selected="false">Publications</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main department content sections -->
    <main class="dept-main-content">
        <div class="dept-container">

            <!-- Tab 1: About Department -->
            <section class="dept-tab-pane active" id="tab-about">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">ACADEMIC OVERVIEW</span>
                    <h2>About the Department</h2>
                    <p>Pioneering automotive engineering education, vehicle dynamics research, and state-of-the-art laboratory experimentation at GEC Modasa since 2008.</p>
                </div>

                <div class="dept-story-body">
                    <blockquote class="dept-lead-quote">
                        "Empowering future automotive engineers through advanced powertrain innovation, vehicle dynamics research, and state-of-the-art laboratory experimentation."
                    </blockquote>
                    <p>
                        This department is constituted in the year 2008 with a view to meet the demands of automobile engineers by transport and automobile sectors. Automobile Department has a separate building with full facilities of Laboratory, workshop and AC Conference room.
                    </p>
                    <p>
                        This department has laboratories of Material Science &amp; Metallurgical, Mechanical Measurement &amp; Metrology, Control Engineering, Power Plant Engineering, Heat &amp; Mass Transfer, Thermal engineering &amp; Refrigeration, ICE &amp; Auto Engineering, Kinematic &amp; Dynamics of Machine, Theory of Machine, Fluid Mechanics, Engineering Graphics and Computer Centre.
                    </p>
                    <p>
                        The result of Automobile is at on 1st in GECM in 2014 final year and in Government Engineering College, in Automobile Branch, GECM is in 3rd Position. Automobile engineering or automotive engineering is the branch of engineering which deals with the study as for how to design, manufacture and operate automobiles like buses, trucks, cars etc. and also their respective engineering subsystems. This can also be a group under vehicle engineering.
                    </p>
                    <p>
                        Automobile engineers further can specialize in the areas such as aerodynamics, alternative fuels, chassis, electronics, emissions, ergonomics, manufacturing, materials, motorsport, power train, rapid prototyping, vehicle and pedestrian safety or supply chain management etc.
                    </p>
                    <p>
                        In recent times, owing to the rapid growth of automobile industries in the country, the demand for skilled professionals has also been increased considerably. Hence opting for a career in automobile engineering will be interesting as well as rewarding.
                    </p>
                </div>

                <!-- About the Programme Section -->
                <div class="dept-programme-section">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">DISCIPLINE &amp; CAREER PATHS</span>
                        <h2>About the Programme</h2>
                        <p>Specialization in vehicle designing, testing, assembling, and manufacturing with interdisciplinary engineering sub-systems.</p>
                    </div>

                    <p class="dept-programme-lead">
                        Automobile Engineering or Automotive Engineering is a part of Mechanical Engineering. Through the application of automotive technology, the course offers specialisation in vehicle designing, repairing, testing and assembling. In this programme, one can also learn safety engineering, quality management and control, automotive analytics as well as assembling and installation of various automobiles. BE/B.Tech in Automobile Engineering is a 4-year programme. This programme also involves the study of courses related to aerospace and marine engineering. It enables the students to explore new areas, create new avenues in the fields of research and development of technologies in the field of automobile engineering. One can pursue M.Tech in Automobile Engineering after successful completion of BE/B.Tech.
                    </p>

                    <div class="dept-story-body">
                        <p>
                            This branch deals with the designing, developing, manufacturing, testing and repairing and servicing automobiles such as cars, trucks, motorcycles, scooters etc &amp; the related sub Engineering systems. For the perfect blend of manufacturing and designing automobiles, Automobile Engineering uses the features of different elements of Engineering such as Mechanical, Electrical, Electronics, Software and Safety Engineering.
                        </p>
                    </div>

                    <div class="dept-avenues-grid">
                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-cogs"></i></div>
                                <h4>Vehicle Design &amp; Assembly</h4>
                            </div>
                            <p>Designing, developing, testing, and servicing automobiles such as cars, trucks, and motorcycles integrating mechanical, electrical, and safety systems.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-tachometer-alt"></i></div>
                                <h4>Powertrain &amp; Quality Control</h4>
                            </div>
                            <p>Specializing in powertrain engineering, safety systems, quality control, automotive analytics, and advanced diagnostics.</p>
                        </div>
                    </div>
                </div>

                <!-- Under Graduate / Post Graduate Courses -->
                <div class="dept-section-header" style="margin-top: 56px;">
                    <span class="dept-section-kicker">ACADEMIC DEGREE OFFERINGS</span>
                    <h2>Undergraduate &amp; Postgraduate Programmes</h2>
                    <p>Approved by the All India Council for Technical Education (AICTE), New Delhi and affiliated with Gujarat Technological University (GTU), Ahmedabad.</p>
                </div>

                <div class="dept-table-wrap">
                    <table class="dept-clean-table">
                        <thead>
                            <tr>
                                <th>Name of Course</th>
                                <th>Degree Type</th>
                                <th>Period (Years)</th>
                                <th>Approved Intake</th>
                                <th>Year of Starting</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Automobile Engineering</strong></td>
                                <td><span class="dept-tag-ug">UG (B.E.)</span></td>
                                <td>4 Years (8 Semesters)</td>
                                <td><span class="dept-badge">30 Seats</span></td>
                                <td>2008</td>
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
                    <p>Guiding principles, strategic commitments, and educational objectives defining our engineering pedagogy.</p>
                </div>

                <div class="dept-charter-card dept-vision-hero-card">
                    <span class="dept-vision-quote-mark">“</span>
                    <blockquote class="dept-vision-statement">
                        Build a strong teaching-learning and research environment to prepare determined, innovative, inventive, self-esteemed and goal oriented Automobile engineers with good technical knowledge, analytical and soft skill.
                    </blockquote>
                </div>

                <div class="dept-charter-card" style="margin-bottom: 48px;">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #111; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.05em;">Mission of the Department</h3>
                    <ul class="dept-mission-steps">
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">I</span>
                            <div class="dept-mission-text">
                                Providing domain knowledge through qualified, experienced and trained faculties in healthy environment.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">II</span>
                            <div class="dept-mission-text">
                                Developing technical skills and creating awareness about needs of industries by encouraging entrepreneurial attitude.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">III</span>
                            <div class="dept-mission-text">
                                Encouraging graduates to think innovatively through project works with professional ethical practices.
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
                        <h4>Program Educational Objectives (PEOs)</h4>
                        <div class="dept-obj-lead">Graduates from the Automobile Engineering Program are expected to attain:</div>
                        <ul class="dept-obj-list">
                            <li><strong>PEO 1:</strong> Implement the acquired knowledge of science, technology, engineering, management (STEM) with good human values for a successful career.</li>
                            <li><strong>PEO 2:</strong> Achieve a position of leadership in the organization through managerial, communication and professional skills with ethical values.</li>
                            <li><strong>PEO 3:</strong> Be a foundation for innovative solutions of complicated problems as a successful entrepreneur.</li>
                            <li><strong>PEO 4:</strong> Provide feasible solutions for sustainable and environment friendly development.</li>
                        </ul>
                    </div>

                    <div class="dept-obj-card">
                        <h4>Program Specific Outcomes (PSOs)</h4>
                        <div class="dept-obj-lead">Automobile Engineering Graduate will be able to:</div>
                        <ul class="dept-obj-list">
                            <li><strong>PSO 1:</strong> Apply the specific skill acquired for solving problems related to automobile engineering and interdisciplinary problems with knowledge of Science, Technology, Engineering and Mathematics (STEM) and modern software skills.</li>
                            <li><strong>PSO 2:</strong> Develop optimum engineering systems in specialized areas such as product design and its optimization.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Tab 3: Laboratory facilities -->
            <section class="dept-tab-pane" id="tab-facilities">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">EXPERIMENTAL INFRASTRUCTURE</span>
                    <h2>Laboratories &amp; Facilities</h2>
                    <p>Dedicated departmental building equipped with specialized test-rigs, IC engine dynamometers, and comprehensive fabrication workshop.</p>
                </div>

                <!-- Featured Laboratory Photo Showcase -->
                <div class="dept-labs-showcase">
                    <!-- Featured Lab: Internal Combustion Engine Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_ice.jpg" alt="Internal Combustion Engine Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Main Automobile Block</span>
                            <h3 class="dept-lab-title">Internal Combustion Engine Lab</h3>
                            <p class="dept-lab-desc">
                                This laboratory is equipped with modern instruments like modern internal combustion engine test rig, diesel smoke meter, variable compression ratio engine test rig, five gas exhaust gas analyzer etc.
                            </p>
                        </div>
                    </div>

                    <!-- Workshop & Chassis Bay -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/department_building.jpg" alt="Automobile Workshop &amp; Testing Facility" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Automobile Annex</span>
                            <h3 class="dept-lab-title">Automobile Workshop &amp; Chassis Bay</h3>
                            <p class="dept-lab-desc">
                                Comprehensive vehicle servicing and overhaul bays equipped with hydraulic vehicle lifts, computerized wheel alignment apparatus, transmission cut-sections, and heavy component fabrication machinery.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Comprehensive Department Facilities Grid -->
                <div class="dept-section-header" style="margin-top: 56px;">
                    <span class="dept-section-kicker">INFRASTRUCTURE HIGHLIGHTS</span>
                    <h2>Departmental Laboratories &amp; Workshop</h2>
                    <p>Extensive hands-on testing infrastructure, machine dynamics, and thermal analysis laboratories supporting the curriculum.</p>
                </div>

                <div class="dept-facilities-grid">
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-layer-group"></i></div>
                        <div class="dept-facility-info">
                            <h4>Material Science &amp; Metallurgical Lab</h4>
                            <p>Microstructural examination, specimen polishing, hardness testing, and heat-treatment analysis for automotive alloys.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-ruler-combined"></i></div>
                        <div class="dept-facility-info">
                            <h4>Mechanical Measurement &amp; Metrology Lab</h4>
                            <p>Precision measurement benches, profile projectors, dial indicators, and surface roughness testers.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-sliders-h"></i></div>
                        <div class="dept-facility-info">
                            <h4>Control Engineering Lab</h4>
                            <p>Closed-loop feedback control simulators, pneumatic and electro-pneumatic trainers, and dynamic system analyzers.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-industry"></i></div>
                        <div class="dept-facility-info">
                            <h4>Power Plant Engineering Lab</h4>
                            <p>Thermodynamic cycle demonstration setups, boiler performance rigs, and steam turbine energy conversion models.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-fire-alt"></i></div>
                        <div class="dept-facility-info">
                            <h4>Heat &amp; Mass Transfer Lab</h4>
                            <p>Conduction, natural/forced convection benches, emissivity apparatus, and multi-pass shell &amp; tube heat exchangers.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-snowflake"></i></div>
                        <div class="dept-facility-info">
                            <h4>Thermal Engineering &amp; Refrigeration Lab</h4>
                            <p>Vapour compression test rigs, refrigeration trainers, air conditioning testbeds, and psychrometric measurement systems.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-car-battery"></i></div>
                        <div class="dept-facility-info">
                            <h4>ICE &amp; Auto Engineering Lab</h4>
                            <p>Engine test rigs, transmission assemblies, cut-section engine blocks, and automotive subsystems demonstration units.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-tachometer-alt"></i></div>
                        <div class="dept-facility-info">
                            <h4>Kinematic &amp; Dynamics of Machine Lab</h4>
                            <p>Motorized gyroscopes, static and dynamic balancing apparatus, whirling of shafts, and governor test rigs.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-cogs"></i></div>
                        <div class="dept-facility-info">
                            <h4>Theory of Machine Lab</h4>
                            <p>Epicyclic gear trains, kinematic inversions, cam-follower mechanism benches, and vibration test equipment.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-water"></i></div>
                        <div class="dept-facility-info">
                            <h4>Fluid Mechanics Lab</h4>
                            <p>Bernoulli apparatus, Venturimeter &amp; orifice calibration rigs, pipe friction benches, and hydraulic pump testbeds.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-drafting-compass"></i></div>
                        <div class="dept-facility-info">
                            <h4>Engineering Graphics Lab</h4>
                            <p>Ergonomic drafting tables for orthographic, isometric, sectioning, and machine component drawing practice.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-desktop"></i></div>
                        <div class="dept-facility-info">
                            <h4>Computer Centre &amp; CAD Lab</h4>
                            <p>High-performance workstations equipped with parametric modeling, CAE simulation, and automotive drafting suites.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-warehouse"></i></div>
                        <div class="dept-facility-info">
                            <h4>Automobile Workshop</h4>
                            <p>Spacious workshop facility with chassis maintenance bays, wheel alignment, hydraulic vehicle lifts, and tools.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="dept-facility-info">
                            <h4>AC Conference Room</h4>
                            <p>Fully air-conditioned presentation and conference facility with digital audio-visual setup for seminars and project reviews.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 4: Publications -->
            <section class="dept-tab-pane" id="tab-publications">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">SCHOLARLY OUTPUT</span>
                    <h2>Faculty Publications</h2>
                    <p>Research contributions, technical papers, and conference proceedings published by Automobile Engineering faculty and research scholars.</p>
                </div>

                <!-- Publications Filter Toolbar -->
                <div class="dept-pub-toolbar">
                    <div class="dept-pub-filter-wrap">
                        <label for="pubYearFilter" class="dept-pub-filter-label">
                            <i class="fas fa-calendar-alt"></i> Filter by Year:
                        </label>
                        <div class="dept-pub-select-box">
                            <select id="pubYearFilter" class="dept-pub-select" aria-label="Filter publications by year" onchange="window.filterPublicationsByYear && window.filterPublicationsByYear(this.value)">
                                <option value="all">All Years</option>
                            </select>
                            <i class="fas fa-chevron-down dept-pub-arrow"></i>
                        </div>
                    </div>
                    <div class="dept-pub-badge" id="pubCountBadge">
                        Department Publications
                    </div>
                </div>

                <div class="dept-citations-list">
                    <!-- Notice for publications -->
                    <div class="dept-pub-empty" id="pubEmptyState" style="display: block;">
                        <i class="far fa-folder-open"></i>
                        Faculty publications and research archives are currently being compiled.
                    </div>
                </div>
            </section>

        </div>
    </main>

</div>

<!-- Department JavaScript -->
<script src="js/department.js" defer></script>

<?php
// Include Footer
include_once __DIR__ . '/../../includes/footer.php';
?>
