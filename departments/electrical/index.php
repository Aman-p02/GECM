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
<link rel="stylesheet" href="css/department.css?v=<?= filemtime(__DIR__ . '/css/department.css') ?>">
<link rel="stylesheet" href="../includes/faculty.css">
<link rel="stylesheet" href="../includes/activities.css">
<link rel="stylesheet" href="../includes/publications.css?v=2.5">
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
                            <span class="dept-stat-num">5</span>
                            <span class="dept-stat-label">MAJOR LABS</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">100%</span>
                            <span class="dept-stat-label">GTU CURRICULUM ALIGNED</span>
                        </div>
                    </div>
                </div>

                <div class="dept-section-header">
                    <span class="dept-section-kicker">ACADEMIC OVERVIEW</span>
                    <h2>About Department</h2>
                    <p>Established in 1984, the Department of Electrical Engineering is one of the foundational academic pillars of GEC Modasa.</p>
                </div>

                <div class="dept-story-body">
                    <blockquote class="dept-lead-quote">
                        "Electrical engineering, one of the core courses of engineering discipline deals with the study of design, development, and maintenance of electrical systems and their components, ensuring quality, safety, reliability, and sustainability."
                    </blockquote>
                    <p>
                        It is accommodated in academic building no. 4. This department has various laboratories in the areas of Basic Electrical, Microprocessor, Electrical Machine, Electrical Measurement, Power Electronics, Computer Laboratory, High Voltage and Switchgear &amp; Protection Laboratory. The Department has an excellent Computer Centre.
                    </p>
                    <p>
                        This department has laboratories in the field of Electrical Measurement, Electrical Machine, Power System, Microprocessor, High Voltage Engineering, Electronics and Control. The department also looks after the electrical service and maintenance of the entire institute campus.
                    </p>
                </div>

                <!-- About the Programme Section -->
                <div class="dept-programme-section">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">DISCIPLINE &amp; CAREER HORIZONS</span>
                        <h2>About the Programme</h2>
                        <p>Focusing on the design, analysis, and manufacturing of electrical equipment used across power generation, transmission, industrial automation, and smart electronics.</p>
                    </div>

                    <div class="dept-story-body">
                        <p>
                            Electrical engineering focuses on the manufacturing of electrical equipment used in a number of sectors including construction and building and the production and distribution of power. Students pursuing electrical engineering study about semiconductors and microprocessors. The undergraduate course will award a B.Tech / B.E. degree and the postgraduate course, an M.Tech.
                        </p>
                        <p>
                            An electrical engineer is someone who designs and develops new electrical systems, solves problems and tests equipment. They study and apply the physics and mathematics of electricity, electromagnetism and electronics to both large and small scale systems to process information and transmit energy. They work with all kinds of electronic devices, from the smallest pocket devices to large industrial supercomputers and smart grids.
                        </p>
                    </div>

                    <div class="dept-avenues-grid">
                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-bolt"></i></div>
                                <h4>Power Systems &amp; Grid Infrastructure</h4>
                            </div>
                            <p>Engineering transmission substations, high-voltage distribution networks, smart grids, and utility operations with state electricity boards and central PSUs.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-solar-panel"></i></div>
                                <h4>Renewable &amp; Clean Energy Systems</h4>
                            </div>
                            <p>Solar farm commissioning, wind turbine power integration, energy storage systems, micro-grid design, and green energy management.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-charging-station"></i></div>
                                <h4>Electric Vehicles &amp; Power Electronics</h4>
                            </div>
                            <p>EV powertrain design, battery management systems (BMS), motor controllers, fast-charging infrastructure, and power converter drives.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-industry"></i></div>
                                <h4>Industrial Automation &amp; Control</h4>
                            </div>
                            <p>PLC and SCADA programming, industrial robotics, switchgear protection engineering, and instrumentation in modern manufacturing plants.</p>
                        </div>
                    </div>
                </div>

                <!-- Under Graduate Courses Table -->
                <div class="dept-section-header" style="margin-top: 56px;">
                    <span class="dept-section-kicker">ACADEMIC DEGREE OFFERINGS</span>
                    <h2>Undergraduate Programme</h2>
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
                                <td><strong>Electrical Engineering</strong></td>
                                <td><span class="dept-tag-ug">UG (B.E.)</span></td>
                                <td>4 Years (8 Semesters)</td>
                                <td><span class="dept-badge">60 Seats</span></td>
                                <td>1984</td>
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

                <!-- Vision Card -->
                <div class="dept-charter-card dept-vision-hero-card">
                    <span class="dept-vision-quote-mark">“</span>
                    <blockquote class="dept-vision-statement">
                        To thrive for excellence in the field of Electrical Engineering by imparting quality education that produces skilled, innovative and ethical engineers to meet the needs of academia, industry and society.
                    </blockquote>
                </div>

                <!-- Mission Card -->
                <div class="dept-charter-card" style="margin-bottom: 48px;">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #111; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.05em;">Mission of the Department</h3>
                    <ul class="dept-mission-steps">
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">I</span>
                            <div class="dept-mission-text">
                                To provide an effective Teaching -Learning environment to acquire skills and knowledge in the field of Electrical Engineering.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">II</span>
                            <div class="dept-mission-text">
                                Strengthen industry institute interaction to enable the students to work on innovative and real time problems.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">III</span>
                            <div class="dept-mission-text">
                                To foster a culture of entrepreneurship amongst the students.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">IV</span>
                            <div class="dept-mission-text">
                                To instill values in students for lifelong learning and service to the society.
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Objectives (PEOs and PSOs) -->
                <div class="dept-objectives-grid">
                    <div class="dept-obj-card">
                        <h4>Program Educational Objectives (PEOs)</h4>
                        <div class="dept-obj-lead">After successful completion of the program, the student will:</div>
                        <ul class="dept-obj-list">
                            <li><strong>PEO 1:</strong> apply fundamental mathematical, scientific, and electrical engineering principles to analyze, design, and solve complex real-world engineering problems.</li>
                            <li><strong>PEO 2:</strong> exhibit professional excellence, ethical responsibility, effective teamwork, and multidisciplinary problem-solving skills across energy and automation domains.</li>
                            <li><strong>PEO 3:</strong> pursue lifelong learning, adapt to emerging technologies like smart grids and electric mobility, and contribute constructively as responsible engineering leaders.</li>
                        </ul>
                    </div>

                    <div class="dept-obj-card">
                        <h4>Program Specific Outcomes (PSOs)</h4>
                        <div class="dept-obj-lead">At the end of the program, the student will be able to:</div>
                        <ul class="dept-obj-list">
                            <li><strong>PSO 1:</strong> design, analyze, and test electrical machines, control circuits, power electronics systems, and industrial drives.</li>
                            <li><strong>PSO 2:</strong> operate, protect, and simulate generation, transmission, and distribution power networks with renewable energy integration.</li>
                            <li><strong>PSO 3:</strong> implement microcontroller-based automation, instrumentation, and smart monitoring solutions for industrial and societal needs.</li>
                        </ul>
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
                    <p>5 well-equipped major laboratories offering hands-on experimental facilities across electrical machines, measurement, high voltage testing, basic electrical, and embedded systems.</p>
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

                    <!-- Lab 3: High Voltage Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_high_voltage.jpg" alt="High Voltage Laboratory - GEC Modasa" loading="lazy" onerror="this.src='../../images/hero_campus_1.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">ACADEMIC BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">High Voltage Lab</h3>
                            <p class="dept-lab-desc">
                                Assists the students in the presence of faculty to perform high voltage experiments for reinforcing the learning of theoretical concepts of impulse voltage generation, di-electric testing, solid insulation testing to name a few and evaluation of results. It inculcates a habit in the students to remain safety conscious in a laboratory environment.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 4: Basic Electrical Engineering Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_basic_electrical.jpg" alt="Basic Electrical Engineering Laboratory - GEC Modasa" loading="lazy" onerror="this.src='../../images/hero_campus_1.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">ACADEMIC BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">Basic Electrical Engineering Lab</h3>
                            <p class="dept-lab-desc">
                                It provides a platform for the First Year students to understand the fundamentals of Electrical engineering, basic electric wiring, measurement and electric safety. It develops skills in the students which they will need subsequent Electrical engineering laboratories.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 5: Embedded Systems Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_embedded_systems.jpg" alt="Embedded Systems Laboratory - GEC Modasa" loading="lazy" onerror="this.src='../../images/hero_campus_1.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">ACADEMIC BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">Embedded Systems Lab</h3>
                            <p class="dept-lab-desc">
                                It enables the students to program, simulate, test and interface the microprocessors and micro controllers. The students can do programming using various software. It provides a platform to the students to do multi disciplinary projects.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Department Facilities (All 12 Facilities from Portal) -->
                <div class="dept-section-block" style="margin-top: 56px;">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">CENTRAL RESOURCES &amp; INFRASTRUCTURE</span>
                        <h2>Department Facilities</h2>
                        <p>Specialized institutional facilities and departmental laboratories supporting comprehensive academic and research operations.</p>
                    </div>

                    <div class="dept-facilities-grid">
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-bolt"></i></div>
                            <div class="dept-facility-info">
                                <h4>Basic Electrical Lab</h4>
                                <p>Foundational circuit theory benches, electrical wiring setups, and AC/DC network verification panels.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-memory"></i></div>
                            <div class="dept-facility-info">
                                <h4>Microprocessor Lab</h4>
                                <p>8085 / 8086 microprocessor trainer boards, ADC/DAC peripherals, stepper motor, and traffic light interface kits.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-cogs"></i></div>
                            <div class="dept-facility-info">
                                <h4>Electrical Machine Lab</h4>
                                <p>Operational testing benches for DC motors, generators, single &amp; 3-phase transformers, and induction machines.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-shield-alt"></i></div>
                            <div class="dept-facility-info">
                                <h4>Switchgear and Protection Lab</h4>
                                <p>Electromagnetic and numerical overcurrent, earth fault, differential relays, and circuit breaker testing.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-tachometer-alt"></i></div>
                            <div class="dept-facility-info">
                                <h4>Electrical Measurement Lab</h4>
                                <p>Precision calibration of electrical measuring instruments, energy meters, wattmeters, and bridge circuits.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-plug"></i></div>
                            <div class="dept-facility-info">
                                <h4>Basic/Analog Electronics</h4>
                                <p>Diode characteristics, BJT / FET amplifier circuits, operational amplifiers, and regulated power supply experiments.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-microchip"></i></div>
                            <div class="dept-facility-info">
                                <h4>Instrumentation Lab</h4>
                                <p>Modern transducers, sensors, LVDT, thermocouple, RTD setups, and signal conditioning equipment.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-desktop"></i></div>
                            <div class="dept-facility-info">
                                <h4>Power Computation Lab</h4>
                                <p>MATLAB/Simulink computing workstations for load flow analysis, symmetrical fault studies, and stability simulations.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-wave-square"></i></div>
                            <div class="dept-facility-info">
                                <h4>Digital Electronics Lab</h4>
                                <p>Logic gates, sequential &amp; combinational digital circuits, multiplexers, and flip-flop trainer kits.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-charging-station"></i></div>
                            <div class="dept-facility-info">
                                <h4>High Voltage Lab</h4>
                                <p>Impulse voltage generation, dielectric breakdown testing of transformer oil, and sphere gap high voltage measurements.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-network-wired"></i></div>
                            <div class="dept-facility-info">
                                <h4>PLS and DSP Lab</h4>
                                <p>Programmable logic controller (PLC) automation stations, ladder logic consoles, and DSP processor benches.</p>
                            </div>
                        </div>

                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-sliders-h"></i></div>
                            <div class="dept-facility-info">
                                <h4>Control Lab</h4>
                                <p>Feedback control systems, DC/AC servomotors, synchro transmitter-receiver pairs, and PID controller setups.</p>
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