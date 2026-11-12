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
                            <h1 class="dept-heading">Electronics &amp; Communication Engineering</h1>
                            <p class="dept-tagline">
                                Nurturing innovative technocrats with strong practical foundations in semiconductor devices, VLSI design, wireless communications, embedded systems, and digital signal processing.
                            </p>
                        </div>
                        <div class="dept-hero-media">
                            <img src="images/department_building.jpg" alt="Government Engineering College Modasa - Electronics &amp; Communication Department Building" class="dept-hero-photo">
                        </div>
                    </div>

                    <!-- Key metrics counter strip -->
                    <div class="dept-stats-strip">
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">1984</span>
                            <span class="dept-stat-label">YEAR OF ESTABLISHMENT</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">30</span>
                            <span class="dept-stat-label">ANNUAL APPROVED INTAKE</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">4</span>
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
                    <p>Established in 1984, the Department of Electronics &amp; Communication Engineering is one of the oldest and successfully running engineering branches of GEC Modasa.</p>
                </div>

                <div class="dept-story-body">
                    <blockquote class="dept-lead-quote">
                        "The department was established with the mission to deliver technical programs and services to meet the changing needs of the society and industry, thereby contribute to the overall techno-economical development of the state."
                    </blockquote>
                    <p>
                        The department of Electronics &amp; Communication was established in the year 1984 is one of the oldest and successfully running the engineering branch of G.E.C. Modasa. The Department offers a four-year course in electronics and communication with 120 intakes. The department is persistently committed to enhancing technical knowledge with high ethical values.
                    </p>
                    <p>
                        The department of E.C. is accommodated in building No. 4. It has laboratories in thrust areas of Analog and Digital Electronics, Communications, Antenna, Microwave, VLSI Design, and Signal Processing. Department has a Computer Center with the latest computer facilities. All labs are well equipped with the latest types of equipment to keep the students in tune with the advancement in the field of Electronics &amp; Communication. The department is also equipped with a full-fledged departmental library.
                    </p>
                </div>

                <!-- About the Programme Section -->
                <div class="dept-programme-section">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">DISCIPLINE &amp; CAREER HORIZONS</span>
                        <h2>About the Programme</h2>
                        <p>Electronic communications engineering is the utilization of science and math applied to practical problems in the field of communications.</p>
                    </div>

                    <div class="dept-story-body">
                        <p>
                            Electronic communications engineers engage in research, design, development and testing of the electronic equipment used in various communications systems. It is due to electronic engineers that we enjoy such modern communication devices as cellular telephones, radios and television.
                        </p>
                        <p>
                            Electronics &amp; Communication Engineering deals with the electronic devices, circuits, communication equipments like transmitter, receiver, integrated circuits (IC). It also deals with basic electronics, analog and digital transmission &amp; reception of data, voice and video (Example AM, FM, DTH), microprocessors, satellite communication, microwave engineering, antennae and wave progression. It aims to deepen the knowledge and skills of the students on the basic concepts and theories that will equip them in their professional work involving analysis, systems implementation, operation, production, and maintenance of the various applications in the field of Electronics and Communications Engineering.
                        </p>
                    </div>

                    <div class="dept-avenues-grid">
                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-microchip"></i></div>
                                <h4>VLSI Design &amp; Semiconductor Technology</h4>
                            </div>
                            <p>ASIC design, FPGA synthesis, RTL coding, CMOS layout, and verification for high-speed microchips and integrated circuits.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-satellite-dish"></i></div>
                                <h4>Wireless &amp; 5G Telecommunications</h4>
                            </div>
                            <p>RF engineering, cellular network infrastructure, microwave links, satellite transceivers, and smart antennae design.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-memory"></i></div>
                                <h4>Embedded Systems &amp; IoT</h4>
                            </div>
                            <p>Microcontroller firmware, ARM architecture, Real-Time Operating Systems (RTOS), and smart connected edge devices.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-wave-square"></i></div>
                                <h4>Signal &amp; Image Processing</h4>
                            </div>
                            <p>Algorithm development in MATLAB and DSP processors for speech recognition, audio-video codecs, and computer vision.</p>
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
                                Hands-on platform for circuit testing, frequency response analysis, and digital logic verification using advanced trainer kits and lab stations.
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
                                Practical training in signal sampling, filter design, and algorithm implementation using MATLAB, Simulink, and hardware DSP processors.
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
                                Microprocessor, ARM microcontroller, FPGA, and CPLD hardware interfacing and HDL programming verification benches.
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
                                Signal modulation analysis, AM/FM kits, PSK/FSK digital trainers, and Digital Storage Oscilloscopes (DSO).
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Department Key Facilities Grid (All 16 Facilities from Portal) -->
                <div class="dept-section-block" style="margin-top: 56px;">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">CENTRAL RESOURCES &amp; INFRASTRUCTURE</span>
                        <h2>Department Facilities</h2>
                        <p>Comprehensive specialized laboratories and academic facilities supporting undergraduate experimentation, project work, and research operations.</p>
                    </div>

                    <div class="dept-facilities-grid">
                        <!-- 1. Analog & Digital Electronics Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-microchip"></i></div>
                            <div class="dept-facility-info">
                                <h4>Analog &amp; Digital Electronics Lab</h4>
                                <p>Digital trainer kits, lab stations, and logic verification setups.</p>
                            </div>
                        </div>

                        <!-- 2. Digital Communication Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-broadcast-tower"></i></div>
                            <div class="dept-facility-info">
                                <h4>Digital Communication Lab</h4>
                                <p>DSO oscilloscopes, modulation trainers, and multiplexer benches.</p>
                            </div>
                        </div>

                        <!-- 3. R.F Laboratory -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-wave-square"></i></div>
                            <div class="dept-facility-info">
                                <h4>R.F Laboratory</h4>
                                <p>RF signal generators, spectrum analyzers, and filter testing setups.</p>
                            </div>
                        </div>

                        <!-- 4. Basic & Advanced Electronics -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-plug"></i></div>
                            <div class="dept-facility-info">
                                <h4>Basic &amp; Advanced Electronics</h4>
                                <p>Semiconductor diode, amplifier, op-amp, and timer IC experiments.</p>
                            </div>
                        </div>

                        <!-- 5. Power Electronics Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-bolt"></i></div>
                            <div class="dept-facility-info">
                                <h4>Power Electronics Lab</h4>
                                <p>SCR trigger circuits, MOSFET/IGBT converters, and motor controllers.</p>
                            </div>
                        </div>

                        <!-- 6. Microprocessor & Microcontroller Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-memory"></i></div>
                            <div class="dept-facility-info">
                                <h4>Microprocessor &amp; Microcontroller Lab</h4>
                                <p>8085/8086, 8051, and ARM development trainer boards.</p>
                            </div>
                        </div>

                        <!-- 7. Telecom and Switching Network Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-network-wired"></i></div>
                            <div class="dept-facility-info">
                                <h4>Telecom and Switching Network Lab</h4>
                                <p>Electronic exchange simulators and time-division switching setups.</p>
                            </div>
                        </div>

                        <!-- 8. Electronics measurement & Instrument Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-tachometer-alt"></i></div>
                            <div class="dept-facility-info">
                                <h4>Electronics measurement &amp; Instrument Lab</h4>
                                <p>Digital multimeters, LCR bridges, and transducer calibration.</p>
                            </div>
                        </div>

                        <!-- 9. Optical Communication Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-ethernet"></i></div>
                            <div class="dept-facility-info">
                                <h4>Optical Communication Lab</h4>
                                <p>Laser sources, photodetectors, power meters, and fiber splicing units.</p>
                            </div>
                        </div>

                        <!-- 10. Electronics Workshop Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-tools"></i></div>
                            <div class="dept-facility-info">
                                <h4>Electronics Workshop Lab</h4>
                                <p>Component testing, soldering stations, and PCB prototyping practice.</p>
                            </div>
                        </div>

                        <!-- 11. Antenna and Microwave Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-satellite-dish"></i></div>
                            <div class="dept-facility-info">
                                <h4>Antenna and Microwave Lab</h4>
                                <p>Microwave waveguide benches, klystrons, and radiation pattern rigs.</p>
                            </div>
                        </div>

                        <!-- 12. VLSI & Embedded System Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-laptop-code"></i></div>
                            <div class="dept-facility-info">
                                <h4>VLSI &amp; Embedded System Lab</h4>
                                <p>FPGA/CPLD trainer kits and Xilinx/Vivado synthesis workstations.</p>
                            </div>
                        </div>

                        <!-- 13. Mobile & Wireless Communication Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-mobile-alt"></i></div>
                            <div class="dept-facility-info">
                                <h4>Mobile &amp; Wireless Communication Lab</h4>
                                <p>GSM/CDMA trainers, mobile antenna links, and propagation testers.</p>
                            </div>
                        </div>

                        <!-- 14. Digital Signal Processing Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-sliders-h"></i></div>
                            <div class="dept-facility-info">
                                <h4>Digital Signal Processing Lab</h4>
                                <p>TI TMS320 DSP kits, MATLAB simulation, and digital filter design.</p>
                            </div>
                        </div>

                        <!-- 15. Analog Communication Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-radio"></i></div>
                            <div class="dept-facility-info">
                                <h4>Analog Communication Lab</h4>
                                <p>AM/FM modulation-demodulation kits and superheterodyne receivers.</p>
                            </div>
                        </div>

                        <!-- 16. Electronic Project & Innovation Lab -->
                        <div class="dept-facility-item">
                            <div class="dept-facility-icon"><i class="fas fa-lightbulb"></i></div>
                            <div class="dept-facility-info">
                                <h4>Electronic Project &amp; Innovation Lab</h4>
                                <p>Dedicated workspace for student design projects and IoT prototypes.</p>
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
