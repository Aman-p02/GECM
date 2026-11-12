<?php
$page_title = "Electronics & Communication Engineering | Government Engineering College, Modasa";
$page_description = "Department of Electronics & Communication Engineering at GEC Modasa. Established in 1984, offering B.Tech in EC with cutting-edge VLSI, Digital Communication, Signal Processing, and Embedded Systems laboratories.";
$page_keywords = "Electronics and Communication GEC Modasa, EC Engineering Modasa, GTU EC Department, VLSI Lab Modasa, Digital Communication Gujarat";

$active_page = "departments";
$root_path = "../../";

$deptCode = 'EC';
$deptName = 'Electronics & Communication Engineering';

include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../includes/department-seo.php';
?>

<!-- Electronics & Communication Department Stylesheet -->
<link rel="stylesheet" href="css/department.css?v=<?= filemtime(__DIR__ . '/css/department.css') ?>">
<link rel="stylesheet" href="../includes/faculty.css">
<link rel="stylesheet" href="../includes/activities.css">
<link rel="stylesheet" href="../includes/publications.css?v=2.5">
<link rel="stylesheet" href="../includes/advisory-board.css">
<link rel="stylesheet" href="../includes/newsletters.css">

<div class="dept-page" id="mainContent" data-active-tab="about">

    <!-- Hero banner header -->
    <header class="dept-hero-banner" role="banner">
        <div class="dept-container">
            <div class="dept-hero-grid">
                <div class="dept-hero-copy">
                    <span class="dept-kicker">DEPARTMENT OF</span>
                    <h1 class="dept-heading">Electronics &amp; Communication Engineering</h1>
                    <p class="dept-lead">
                        One of the oldest and premier engineering branches at GEC Modasa, nurturing innovative technocrats in VLSI design, wireless communications, embedded systems, and signal processing.
                    </p>
                </div>
                <div class="dept-hero-media">
                    <img src="images/labs/lab_vlsi_embedded.jpg" 
                         alt="Electronics &amp; Communication Department - GEC Modasa" 
                         class="dept-hero-img"
                         onerror="this.src='../../images/hero_campus_1.jpg'">
                </div>
            </div>

            <!-- Department Quick Stats -->
            <div class="dept-stats-strip" aria-label="Department Overview Statistics">
                <div class="dept-stat-item">
                    <span class="dept-stat-value">1984</span>
                    <span class="dept-stat-label">Year Established</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-value">30</span>
                    <span class="dept-stat-label">Approved Intake</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-value">4+</span>
                    <span class="dept-stat-label">Specialised Labs</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-value">B.E.</span>
                    <span class="dept-stat-label">4-Year Degree</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Sticky Sub-Navigation Bar -->
    <nav class="dept-subnav-bar" id="deptSubNav" aria-label="Department sections">
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
                <div class="dept-section-header">
                    <span class="dept-section-kicker">INSTITUTIONAL FOUNDATION</span>
                    <h2>About Department</h2>
                    <p>Established in 1984 as one of the pioneer pillars of GEC Modasa, shaping engineering leaders in electronics, communications, and emerging semiconductor technologies.</p>
                </div>

                <!-- Callout Quote -->
                <div class="dept-quote-callout">
                    <p>
                        The department of Electronics &amp; Communication was established in the year 1984 is one of the oldest and successfully running the engineering branch of G.E.C. Modasa. The Department offers a four-year course in electronics and communication with 120 intakes.
                    </p>
                    <p class="dept-quote-body">
                        The department was established with the mission to deliver technical programs and services to meet the changing needs of the society and industry, thereby contribute to the overall techno-economical development of the state. The department is persistently committed to enhancing technical knowledge with high ethical values.
                    </p>
                    <p class="dept-quote-body">
                        The department of E.C. is accommodated in building No. 4. It has laboratories in thrust areas of Analog and Digital Electronics, Communications, Antenna, Microwave, VLSI Design, and Signal Processing. Department has a Computer Center with the latest computer facilities. All labs are well equipped with the latest types of equipment to keep the students in tune with the advancement in the field of Electronics &amp; Communication. The department is also equipped with a full-fledged departmental library.
                    </p>
                </div>

                <!-- About the Programme Editorial -->
                <div class="dept-section-header" style="margin-top: 48px;">
                    <span class="dept-section-kicker">ACADEMIC RIGOR</span>
                    <h2>About the Programme</h2>
                    <p>Comprehensive curriculum bridging fundamental electromagnetic theory with modern microchip and digital communication architectures.</p>
                </div>

                <div class="dept-text-columns">
                    <div class="dept-column">
                        <h3>Core Engineering Discipline</h3>
                        <p>
                            Electronic communications engineering is the utilization of science and math applied to practical problems in the field of communications. Electronic communications engineers engage in research, design, development and testing of the electronic equipment used in various communications systems. It is due to electronic engineers that we enjoy such modern communication devices as cellular telephones, radios and television.
                        </p>
                    </div>
                    <div class="dept-column">
                        <h3>Applications &amp; Industry Scope</h3>
                        <p>
                            Electronics &amp; Communication Engineering deals with the electronic devices, circuits, communication equipments like transmitter, receiver, integrated circuits (IC). It also deals with basic electronics, analog and digital transmission &amp; reception of data, voice and video (Example AM, FM, DTH), microprocessors, satellite communication, microwave engineering, antennae and wave progression.
                        </p>
                        <p>
                            It aims to deepen the knowledge and skills of the students on the basic concepts and theories that will equip them in their professional work involving analysis, systems implementation, operation, production, and maintenance of the various applications in the field of Electronics and Communications Engineering.
                        </p>
                    </div>
                </div>

                <!-- Career Avenues & Thrust Areas -->
                <div class="dept-section-header" style="margin-top: 36px;">
                    <span class="dept-section-kicker">SPECIALIZED DOMAINS</span>
                    <h2>Thrust Areas &amp; Career Avenues</h2>
                    <p>Dynamic engineering specializations offering vast industry opportunities and higher research pathways.</p>
                </div>

                <div class="dept-avenues-grid">
                    <div class="dept-avenue-card">
                        <div class="dept-avenue-icon"><i class="fas fa-microchip"></i></div>
                        <h4>VLSI Design &amp; Semiconductors</h4>
                        <p>ASIC design, FPGA synthesis, RTL coding, CMOS layout, and verification for high-speed integrated circuits and microchips.</p>
                    </div>

                    <div class="dept-avenue-card">
                        <div class="dept-avenue-icon"><i class="fas fa-satellite-dish"></i></div>
                        <h4>5G, Wireless &amp; RF Engineering</h4>
                        <p>Modern wireless systems, cellular infrastructure, antenna design, satellite transceivers, and microwave communication links.</p>
                    </div>

                    <div class="dept-avenue-card">
                        <div class="dept-avenue-icon"><i class="fas fa-memory"></i></div>
                        <h4>Embedded Systems &amp; IoT</h4>
                        <p>Microcontroller firmware, ARM architecture, Real-Time Operating Systems (RTOS), and smart connected telemetry devices.</p>
                    </div>

                    <div class="dept-avenue-card">
                        <div class="dept-avenue-icon"><i class="fas fa-wave-square"></i></div>
                        <h4>Digital Signal &amp; Image Processing</h4>
                        <p>Algorithm development, filtering, speech processing, audio-video codecs, and computer vision applications.</p>
                    </div>

                    <div class="dept-avenue-card">
                        <div class="dept-avenue-icon"><i class="fas fa-robot"></i></div>
                        <h4>Robotics &amp; Automation</h4>
                        <p>Electronic sensor interfacing, servo control systems, industrial automation, and robotic subsystem integration.</p>
                    </div>

                    <div class="dept-avenue-card">
                        <div class="dept-avenue-icon"><i class="fas fa-network-wired"></i></div>
                        <h4>Optical &amp; Data Networks</h4>
                        <p>Fiber-optic transmission systems, photonic networks, high-speed routing hardware, and packet communications.</p>
                    </div>
                </div>

                <!-- Degree Specifications Table -->
                <div class="dept-section-header" style="margin-top: 48px;">
                    <span class="dept-section-kicker">ACCREDITED PROGRAMME</span>
                    <h2>Under Graduate / Post Graduate Courses</h2>
                    <p>Degree programmes approved by AICTE and affiliated with Gujarat Technological University (GTU).</p>
                </div>

                <div class="dept-table-wrapper">
                    <table class="dept-data-table">
                        <thead>
                            <tr>
                                <th>Name of Course</th>
                                <th>Type</th>
                                <th>Period (Years)</th>
                                <th>Approved Intake</th>
                                <th>Year of Starting</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Electronics &amp; Communications Engineering</strong></td>
                                <td><span class="dept-tag-ug">UG (B.E.)</span></td>
                                <td>4 Years (8 Semesters)</td>
                                <td><span class="dept-badge">30 Seats</span></td>
                                <td>1991</td>
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
                        To strive for academic excellence, enhance industry- institute interaction to create competent technocrats in relevant areas for addressing ever changing needs of society.
                    </blockquote>
                </div>

                <!-- Mission Card -->
                <div class="dept-charter-card" style="margin-bottom: 48px;">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #111; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.05em;">Mission of the Department</h3>
                    <ul class="dept-mission-steps">
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">I</span>
                            <div class="dept-mission-text">
                                To ensure dissemination of knowledge through effective teaching and learning process.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">II</span>
                            <div class="dept-mission-text">
                                To strengthen collaboration with industries.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">III</span>
                            <div class="dept-mission-text">
                                To prepare the students with multidisciplinary competence for their successful career and service to the society.
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
                            <li><strong>PEO 1:</strong> apply core electronics and communication engineering knowledge, analytical tools, and modern software to design, test, and implement robust electronic systems.</li>
                            <li><strong>PEO 2:</strong> exhibit professional excellence, ethical responsibility, effective teamwork, and multidisciplinary problem-solving skills across semiconductor and telecom domains.</li>
                            <li><strong>PEO 3:</strong> pursue continuous lifelong learning, adapt to emerging technologies like 5G/6G, IoT, and AI-enabled hardware, and contribute constructively as responsible engineering leaders.</li>
                        </ul>
                    </div>

                    <div class="dept-obj-card">
                        <h4>Program Specific Outcomes (PSOs)</h4>
                        <div class="dept-obj-lead">At the end of the program, the student will be able to:</div>
                        <ul class="dept-obj-list">
                            <li><strong>PSO 1:</strong> analyze, design, and simulate analog and digital electronic circuits, VLSI systems, and embedded hardware architectures.</li>
                            <li><strong>PSO 2:</strong> develop and evaluate signal processing algorithms and communication links across wireless, RF, and optical media.</li>
                            <li><strong>PSO 3:</strong> apply modern hardware-software co-design tools to solve complex real-world engineering challenges for industrial automation and societal impact.</li>
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
                    <p>4 well-equipped specialized laboratories offering comprehensive hands-on experimental facilities across analog/digital electronics, signal processing, VLSI/embedded systems, and digital communications.</p>
                </div>

                <div class="dept-labs-showcase">
                    <!-- Lab 1: Analog & Digital Electronics Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_analog_digital.jpg" alt="Analog Electronics and Digital Electronics laboratory - GEC Modasa" loading="lazy" onerror="this.src='../../images/hero_campus_1.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">ACADEMIC BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">Analog Electronics &amp; Digital Electronics Lab</h3>
                            <p class="dept-lab-desc">
                                Analog Electronics and Digital Electronics laboratory provides the platform for the students to understand the behavior of the circuit related to Analog Electronics and Digital Electronics. The laboratory is equipped with the different experimental set-ups like Lab Station, digital trainer kits provided to the students to do hands on for observing the response of the circuits and to carry out the testing of the circuits.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 2: Signal Processing Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_signal_processing.jpg" alt="Signal Processing Laboratory - GEC Modasa" loading="lazy" onerror="this.src='../../images/hero_campus_1.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">ACADEMIC BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">Signal Processing Laboratory</h3>
                            <p class="dept-lab-desc">
                                It takes care of the understanding and hands on training of various signal processing techniques and algorithms. It provides ample opportunities for a student to understand various projects of many signal processing techniques such as sampling and quantizing trainer kits. Students are encouraged to develop algorithms and implement both in MATLAB and DSP Processors. This laboratory also facilitates students to carry out minor and major projects in the area of Signal Processing.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 3: VLSI & Embedded Systems Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_vlsi_embedded.jpg" alt="VLSI &amp; Embedded Systems Lab - GEC Modasa" loading="lazy" onerror="this.src='../../images/hero_campus_1.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">ACADEMIC BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">VLSI &amp; Embedded Systems Lab</h3>
                            <p class="dept-lab-desc">
                                It provides the platform for the students to understand the architecture and interfacing of microprocessor, microcontroller, Field Programmable Gate Array (FPGA) and Complex Programmable Logic Device (CPLD). This laboratory is equipped with the different experimental set-ups. Facility is provided to the students to do hands on for testing their programming codes.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 4: Digital Communication Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_digital_communication.jpg" alt="Digital Communication Lab - GEC Modasa" loading="lazy" onerror="this.src='../../images/hero_campus_1.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">ACADEMIC BUILDING NO. 4</span>
                            <h3 class="dept-lab-title">Digital Communication Lab</h3>
                            <p class="dept-lab-desc">
                                It deals with the analysis and manipulation of signals. The equipments like Digital Storage Oscilloscope (DSO), Lab Station Amplitude, frequency and phase shift keying Trainer Kits and modulation kits for mobile communication, AM-FM Modulation-Demodulation kits are available in this laboratory.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Department Supporting Facilities -->
                <div class="dept-section-header" style="margin-top: 48px;">
                    <span class="dept-section-kicker">CAMPUS ECOSYSTEM</span>
                    <h2>Key Facilities &amp; Thrust Infrastructure</h2>
                    <p>Additional academic centers and research resources supporting undergraduate students and faculty.</p>
                </div>

                <div class="dept-facilities-grid">
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-satellite-dish"></i></div>
                        <div class="dept-facility-info">
                            <h4>Antenna &amp; Microwave Lab</h4>
                            <p>Equipped with microwave test benches, klystron power supplies, frequency meters, slotted waveguide sections, and radiation pattern measurement rigs.</p>
                        </div>
                    </div>

                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-microchip"></i></div>
                        <div class="dept-facility-info">
                            <h4>Microprocessor &amp; Microcontroller Center</h4>
                            <p>Features 8085, 8086, 8051, PIC, and ARM development boards with peripheral interface kits for DAC/ADC, stepper motors, and traffic light simulators.</p>
                        </div>
                    </div>

                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-desktop"></i></div>
                        <div class="dept-facility-info">
                            <h4>Departmental Computer Center</h4>
                            <p>Latest networked computer workstations with licensed simulation software including MATLAB, Multisim, Xilinx Vivado, and Keil IDE.</p>
                        </div>
                    </div>

                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-book-reader"></i></div>
                        <div class="dept-facility-info">
                            <h4>Departmental Library</h4>
                            <p>Full-fledged departmental library housing curriculum textbooks, IEEE transactions, project reports, and reference manuals for students and faculty.</p>
                        </div>
                    </div>

                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-project-diagram"></i></div>
                        <div class="dept-facility-info">
                            <h4>PCB Design &amp; Prototyping Station</h4>
                            <p>Provides equipment for schematic capture, PCB layout design, chemical etching, component soldering, and circuit board assembly.</p>
                        </div>
                    </div>

                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-ethernet"></i></div>
                        <div class="dept-facility-info">
                            <h4>Fiber Optic &amp; Telecommunication Lab</h4>
                            <p>Laser and LED optical sources, photodetectors, optical power meters, single/multimode fiber links, and bit-error rate analyzers.</p>
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
