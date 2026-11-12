<?php
$page_title = "Electrical Engineering | Government Engineering College, Modasa";
$page_description = "Department of Electrical Engineering at GEC Modasa. Offering B.Tech in Electrical Engineering with electrical machines, power systems, high voltage, and instrumentation labs.";
$page_keywords = "Electrical Engineering GEC Modasa, EE GECM, GTU Electrical Engineering, Electrical Engineering Faculty Modasa, Power Systems Gujarat";

$active_page = "departments";
$root_path = "../../";

$deptCode = 'EE';
$deptName = 'Electrical Engineering';

include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../includes/department-seo.php';
?>

<!-- Electrical Department Stylesheet -->
<link rel="stylesheet" href="css/department.css?v=1.0">
<link rel="stylesheet" href="../includes/faculty.css">
<link rel="stylesheet" href="../includes/activities.css">
<link rel="stylesheet" href="../includes/publications.css?v=2.4">
<link rel="stylesheet" href="../includes/advisory-board.css">
<link rel="stylesheet" href="../includes/newsletters.css">

<div class="dept-page" id="mainContent" data-active-tab="about">

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
                        <button type="button" class="dept-subnav-link" data-tab="faculty" role="tab" aria-selected="false">Faculty</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="activities" role="tab" aria-selected="false">Activities</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="facilities" role="tab" aria-selected="false">Facilities &amp; Labs</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="publications" role="tab" aria-selected="false">Publications</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="advisory-board" role="tab" aria-selected="false">Advisory Board</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="newsletters" role="tab" aria-selected="false">Newsletters</button>
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
                <div class="dept-about-hero" style="margin-bottom: 56px;">
                    <div class="dept-hero-grid">
                        <div class="dept-hero-text">
                            <span class="dept-kicker">DEPARTMENT OF</span>
                            <h1 class="dept-heading">Electrical Engineering</h1>
                            <p class="dept-tagline">
                                Empowering future engineers through strong fundamentals in electrical machines, power systems, renewable energy, and industrial automation.
                            </p>
                        </div>
                        <div class="dept-hero-media">
                            <img src="images/department_building.jpg" alt="Government Engineering College Modasa - Electrical Department Building" class="dept-hero-photo">
                        </div>
                    </div>

                    <!-- Key metrics counter strip -->
                    <div class="dept-stats-strip">
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">1984</span>
                            <span class="dept-stat-label">YEAR OF ESTABLISHMENT</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">60</span>
                            <span class="dept-stat-label">ANNUAL APPROVED INTAKE</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">8</span>
                            <span class="dept-stat-label">SPECIALIZED LABS</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">100%</span>
                            <span class="dept-stat-label">GTU CURRICULUM ALIGNED</span>
                        </div>
                    </div>
                </div>

                <!-- About the Programme Section -->
                <div class="dept-section-block">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">OVERVIEW &amp; INFRASTRUCTURE</span>
                        <h2>About the Department</h2>
                        <p>Established in 1984, the Department of Electrical Engineering is one of the foundational academic pillars of GEC Modasa.</p>
                    </div>

                    <div class="dept-narrative-prose">
                        <p>
                            It is accommodated in academic building no. 4. This department has various laboratories in the areas of Basic Electrical, Microprocessor, Electrical Machine, Electrical Measurement, Power Electronics, Computer Laboratory, High Voltage and Switchgear &amp; Protection Laboratory. The Department has an excellent Computer Centre.
                        </p>
                        <p>
                            This department has laboratories in the field of Electrical Measurement, Electrical Machine, Power System, Microprocessor, High Voltage Engineering, Electronics and Control. The department also looks after the electrical service and maintenance of the entire institute campus.
                        </p>

                        <div class="dept-callout-quote">
                            <p>
                                "Electrical engineering, one of the core courses of engineering discipline deals with the study of design, development, and maintenance of electrical systems and their components, ensuring quality, safety, reliability, and sustainability. The course focuses on the manufacturing of electrical equipment used in a number of sectors including construction and building and the production and distribution of power."
                            </p>
                        </div>

                        <p>
                            An electrical engineer is someone who designs and develops new electrical systems, solves problems and tests equipment. They study and apply the physics and mathematics of electricity, electromagnetism and electronics to both large and small scale systems to process information and transmit energy. They work with all kinds of electronic devices, from the smallest pocket devices to large industrial supercomputers and smart grids.
                        </p>
                    </div>
                </div>

                <!-- Under Graduate Courses Table -->
                <div class="dept-section-block">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">ACADEMIC PROGRAMMES</span>
                        <h2>Under Graduate Courses</h2>
                        <p>Degree programmes approved by AICTE, New Delhi and affiliated to Gujarat Technological University (GTU).</p>
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
                                    <td><strong>Electrical Engineering</strong></td>
                                    <td>UG</td>
                                    <td>4</td>
                                    <td>60</td>
                                    <td>1984</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Career Avenues -->
                <div class="dept-section-block">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">CAREER HORIZONS</span>
                        <h2>Career Opportunities</h2>
                        <p>Diverse career pathways available to graduates of Electrical Engineering across public and private sectors.</p>
                    </div>

                    <div class="dept-avenues-grid">
                        <div class="dept-avenue-card">
                            <div class="dept-avenue-icon"><i class="fas fa-bolt"></i></div>
                            <h3>Power Generation &amp; Distribution</h3>
                            <p>Roles in state electricity boards (GETCO, GSECL, UGVCL, DGVCL), central PSUs (NTPC, PowerGrid), and private transmission utilities.</p>
                        </div>
                        <div class="dept-avenue-card">
                            <div class="dept-avenue-icon"><i class="fas fa-solar-panel"></i></div>
                            <h3>Renewable &amp; Clean Energy</h3>
                            <p>Solar farm commissioning, wind turbine integration, energy storage solutions, micro-grid design, and green energy consultancy.</p>
                        </div>
                        <div class="dept-avenue-card">
                            <div class="dept-avenue-icon"><i class="fas fa-charging-station"></i></div>
                            <h3>Electric Vehicles &amp; Drives</h3>
                            <p>EV powertrain design, battery management systems (BMS), motor controllers, fast-charging infrastructure, and automotive electricals.</p>
                        </div>
                        <div class="dept-avenue-card">
                            <div class="dept-avenue-icon"><i class="fas fa-industry"></i></div>
                            <h3>Industrial Automation &amp; PLC</h3>
                            <p>SCADA programming, PLC automation, industrial robotics, switchgear design, and instrumentation engineering in manufacturing plants.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 2: Vision & Mission -->
            <section class="dept-tab-pane" id="tab-vision-mission">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">INSTITUTIONAL PURPOSE</span>
                    <h2>Vision &amp; Mission</h2>
                    <p>Guiding philosophy and strategic goals shaping the Electrical Engineering department.</p>
                </div>

                <div class="dept-charter-cards">
                    <div class="dept-charter-card">
                        <div class="dept-charter-badge">VISION</div>
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: #111; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.05em;">Vision of the Department</h3>
                        <p style="font-size: 1.05rem; line-height: 1.75; color: var(--dept-body); margin: 0;">
                            To thrive for excellence in the field of Electrical Engineering by imparting quality education that produces skilled, innovative and ethical engineers to meet the needs of academia, industry and society.
                        </p>
                    </div>

                    <div class="dept-charter-card">
                        <div class="dept-charter-badge">MISSION</div>
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: #111; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.05em;">Mission of the Department</h3>
                        <ul class="dept-mission-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 18px;">
                            <li style="display: flex; align-items: flex-start; gap: 14px;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 50%; background: var(--dept-border-subtle); color: var(--dept-accent); font-weight: 700; font-size: 0.78rem; flex-shrink: 0; margin-top: 2px;">1</span>
                                <span style="font-size: 0.98rem; line-height: 1.65; color: var(--dept-body);">To provide an effective Teaching -Learning environment to acquire skills and knowledge in the field of Electrical Engineering.</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 14px;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 50%; background: var(--dept-border-subtle); color: var(--dept-accent); font-weight: 700; font-size: 0.78rem; flex-shrink: 0; margin-top: 2px;">2</span>
                                <span style="font-size: 0.98rem; line-height: 1.65; color: var(--dept-body);">Strengthen industry institute interaction to enable the students to work on innovative and real time problems.</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 14px;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 50%; background: var(--dept-border-subtle); color: var(--dept-accent); font-weight: 700; font-size: 0.78rem; flex-shrink: 0; margin-top: 2px;">3</span>
                                <span style="font-size: 0.98rem; line-height: 1.65; color: var(--dept-body);">To foster a culture of entrepreneurship amongst the students.</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 14px;">
                                <span style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 50%; background: var(--dept-border-subtle); color: var(--dept-accent); font-weight: 700; font-size: 0.78rem; flex-shrink: 0; margin-top: 2px;">4</span>
                                <span style="font-size: 0.98rem; line-height: 1.65; color: var(--dept-body);">To instill values in students for lifelong learning and service to the society.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Objectives (PEOs and PSOs) -->
                <div class="dept-section-block" style="margin-top: 56px;">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">EDUCATIONAL OBJECTIVES</span>
                        <h2>Program Educational Objectives (PEOs)</h2>
                        <p>Core benchmarks defining the accomplishments expected of our electrical engineering graduates.</p>
                    </div>

                    <div class="dept-objectives-grid">
                        <div class="dept-objective-card">
                            <div class="dept-objective-tag">PEO 1</div>
                            <h3>Technical Competence &amp; Problem Solving</h3>
                            <p>Graduates will apply fundamental mathematical, scientific, and electrical engineering principles to analyze, design, and solve complex real-world engineering problems.</p>
                        </div>
                        <div class="dept-objective-card">
                            <div class="dept-objective-tag">PEO 2</div>
                            <h3>Professionalism, Ethics &amp; Innovation</h3>
                            <p>Graduates will exhibit professional excellence, ethical responsibility, effective teamwork, and multidisciplinary problem-solving skills across energy and automation domains.</p>
                        </div>
                        <div class="dept-objective-card">
                            <div class="dept-objective-tag">PEO 3</div>
                            <h3>Continuous Learning &amp; Leadership</h3>
                            <p>Graduates will pursue lifelong learning, adapt to emerging technologies like smart grids and electric mobility, and contribute constructively as responsible engineering leaders.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab: Faculty Directory (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/faculty-tab.php'; ?>

            <!-- Tab: Activities & Events (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/activities-tab.php'; ?>

            <!-- Tab: Facilities & Labs -->
            <section class="dept-tab-pane" id="tab-facilities">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">INFRASTRUCTURE &amp; PRACTICAL RIGOR</span>
                    <h2>Department Laboratories</h2>
                    <p>8 well-equipped laboratories offering hands-on experimental facilities across electrical machines, power systems, high voltage testing, and instrumentation.</p>
                </div>

                <div class="dept-labs-showcase">
                    <!-- Lab 1: Electrical Machine Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_electrical_machines.jpg" alt="Electrical Machine Laboratory - GEC Modasa" loading="lazy" onerror="this.src='../../images/hero_campus_1.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">ACADEMIC BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">Electrical Machine Lab</h3>
                            <p class="dept-lab-desc">
                                It provides the students with a chance to put theory into practice, to get familiar with DC machines, Transformers, Synchronous machines and Induction motors, understand their basic principles of operation and offers an opportunity to explore their experimental skills to calculate various parameters and characteristics of the Electrical machines.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 2: Measurement & Instrumentation Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_measurement_instrumentation.jpg" alt="Measurement and Instrumentation Laboratory - GEC Modasa" loading="lazy" onerror="this.src='../../images/hero_campus_1.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">ACADEMIC BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">Measurement &amp; Instrumentation Lab</h3>
                            <p class="dept-lab-desc">
                                It provides a medium to the students to study the construction, working principle and calibration of various electrical measuring instruments and transducers.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 3: Basic Electrical Engineering Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">LAB 03 &bull; BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">Basic Electrical Engineering Lab</h3>
                            <p class="dept-lab-desc">
                                Hands-on circuit theorem verification benches, R-L-C series and parallel resonance experimentation, single-phase and three-phase power measurement setups, and instrument transformer calibration panels.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 4: Power Electronics & Drives Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">LAB 04 &bull; BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">Power Electronics &amp; Drives Lab</h3>
                            <p class="dept-lab-desc">
                                Comprehensive trainer modules for thyristor converters, IGBT/MOSFET inverters, chopper circuits, AC/DC motor speed control drives, and digital storage oscilloscopes for power waveform analysis.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 5: High Voltage & Switchgear Protection Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">LAB 05 &bull; BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">High Voltage &amp; Switchgear Protection Lab</h3>
                            <p class="dept-lab-desc">
                                Facilities for dielectric breakdown voltage testing of transformer oil, sphere gap high voltage measurements, electromagnetic and numerical overcurrent, earth fault, and differential protection relay testing.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 6: Power System Simulation Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">LAB 06 &bull; BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">Power System Simulation Lab</h3>
                            <p class="dept-lab-desc">
                                High-performance computing workstations running MATLAB/Simulink and power system CAD tools for load flow studies, symmetrical/unsymmetrical fault analysis, transmission line parameter evaluation, and stability simulations.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 7: Microprocessor & Microcontroller Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">LAB 07 &bull; BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">Microprocessor &amp; Microcontroller Lab</h3>
                            <p class="dept-lab-desc">
                                Microprocessor 8085/8086 kits and 8051 microcontroller training boards integrated with stepper motor controllers, traffic light simulation modules, and ADC/DAC interface boards for embedded control practicals.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 8: Department Computer Centre -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">CENTRE 08 &bull; BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">Department Computer Centre</h3>
                            <p class="dept-lab-desc">
                                Centralised computing lab equipped with high-speed internet connectivity, online GTU e-learning resources, technical paper writing tools, and programming environments for student academic project work.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Key Department Facilities (Below Laboratory Showcase) -->
                <div class="dept-section-block" style="margin-top: 56px;">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">CENTRAL RESOURCES &amp; INFRASTRUCTURE</span>
                        <h2>Key Department Facilities</h2>
                        <p>Specialized institutional facilities supporting comprehensive academic, project, and campus electrical operations.</p>
                    </div>

                    <div class="dept-facilities-grid">
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-charging-station"></i></div>
                            <div class="dept-facility-info">
                                <h4>Campus Electrical Service &amp; Maintenance Cell</h4>
                                <p>Dedicated maintenance wing responsible for the distribution, operation, and maintenance of the institute's power infrastructure.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-solar-panel"></i></div>
                            <div class="dept-facility-info">
                                <h4>Rooftop Grid-Connected Solar Plant</h4>
                                <p>Operational grid-tied rooftop solar power generation facility on campus, serving as both clean energy and live experimental demonstration.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-book-reader"></i></div>
                            <div class="dept-facility-info">
                                <h4>Department Library &amp; Reading Room</h4>
                                <p>Curated collection of standard textbooks, reference handbooks in power systems, electrical machines, and GTU syllabus guides.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-desktop"></i></div>
                            <div class="dept-facility-info">
                                <h4>Smart Seminar &amp; Interactive Classroom</h4>
                                <p>Multimedia LCD projector equipped smart hall for technical symposiums, expert webinars, and student project presentations.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab: Publications (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/publications-tab.php'; ?>

            <!-- Tab: Advisory Board (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/advisory-board-tab.php'; ?>

            <!-- Tab: Newsletters (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/newsletters-tab.php'; ?>

        </div>
    </main>
</div>

<script src="js/department.js?v=1.0"></script>

<?php
include_once __DIR__ . '/../../includes/footer.php';
?>