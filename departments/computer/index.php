<?php
// Set Page Variables
$page_title = "Department of Computer Engineering - Government Engineering College, Modasa";
$page_description = "Explore the Computer Engineering department at GEC Modasa. View faculty directory, research publications, modern computing labs, departmental activities, and newsletters.";
$page_keywords = "Computer Engineering GEC Modasa, CE GECM, GTU Computer Engineering, Computer Science Engineering Gujarat, Computer Engineering Faculty Modasa";
$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/computer/css/department.css";
$extra_js = "departments/computer/js/department.js";

$deptCode = 'CE';
$deptName = 'Computer Engineering';

// Include Header
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../includes/department-seo.php';
?>
<link rel="stylesheet" href="../includes/faculty.css">
<link rel="stylesheet" href="../includes/activities.css">
<link rel="stylesheet" href="../includes/publications.css?v=2.1">
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

    <!-- Tab panels container -->
    <main class="dept-main-content">
        <div class="dept-container">

            <!-- Tab 1: About Department -->
            <section class="dept-tab-pane active" id="tab-about">
                <div class="dept-about-hero" style="margin-bottom: 56px;">
                    <!-- Two-column hero grid (7 cols left, 5 cols right) -->
                    <div class="dept-hero-grid">
                        <div class="dept-hero-text">
                            <span class="dept-kicker">DEPARTMENT OF</span>
                            <h1 class="dept-heading">Computer Engineering</h1>
                            <p class="dept-tagline">
                                Empowering future engineers through innovation and technology. Focused on practical learning, software development, and building skills for the digital future.
                            </p>
                        </div>
                        <div class="dept-hero-media">
                            <img src="images/department_building.jpg" alt="Government Engineering College Modasa - Computer Engineering Department Building" class="dept-hero-photo">
                        </div>
                    </div>

                    <!-- Key metrics counter strip -->
                    <div class="dept-stats-strip">
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">2001</span>
                            <span class="dept-stat-label">YEAR OF ESTABLISHMENT</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">120</span>
                            <span class="dept-stat-label">ANNUAL APPROVED INTAKE</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">10</span>
                            <span class="dept-stat-label">SPECIALIZED LABS</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">25</span>
                            <span class="dept-stat-label">FACULTY MEMBERS</span>
                        </div>
                    </div>
                </div>

                <div class="dept-section-header">
                    <span class="dept-section-kicker">ACADEMIC OVERVIEW</span>
                    <h2>About the Department</h2>
                    <p>Pioneering engineering education, campus network engineering, and laboratory discovery at Government Engineering College, Modasa since 2001.</p>
                </div>

                <div class="dept-story-body">
                    <blockquote class="dept-lead-quote">
                        "Fostering next-generation computing engineers through deep theoretical foundations, state-of-the-art laboratory discovery, and real-time systems mastery."
                    </blockquote>
                    <p>
                       The Computer Engineering Department at GEC Modasa has been providing quality education since 2001. It offers well-equipped laboratories, modern computer systems, and networking facilities. The department emphasizes practical learning, software development, database management, and emerging technologies. With experienced faculty and hands-on training, it aims to develop skilled engineers ready to meet industry challenges.
                    </p>
                    <p>
                     Students are encouraged to enhance their technical knowledge through projects, practical assignments, and innovative activities. The department promotes teamwork, creativity, and problem-solving skills. It also provides opportunities to explore emerging technologies and improve technical expertise.
                    </p>
                    <p>
                       The department encourages students to participate in technical events, workshops, and seminars to expand their knowledge. It aims to bridge the gap between academic learning and industry requirements. Through continuous learning and innovation, the department prepares students to become competent professionals in the field of computer engineering.
                    </p>
                </div>

                <!-- About the Programme Section -->
                <div class="dept-programme-section">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">DISCIPLINE &amp; CAREER PATHS</span>
                        <h2>About the Programme</h2>
                        <p>Integrating computer science and electrical engineering to develop safer, faster, and more powerful computing technologies.</p>
                    </div>

                    <p class="dept-programme-lead">
                        Computer engineering blends together computer science and electrical engineering to further advancements in digital technology, computer networking, and computing systems. In turn, computer engineers use their extensive knowledge of hardware and software design and computer programming to make computing platforms and applications more efficient, secure, and effective. At the professional level, the discipline offers two vital avenues:
                    </p>

                    <div class="dept-avenues-grid">
                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-microchip"></i></div>
                                <h4>Hardware Engineering</h4>
                            </div>
                            <p>Hardware engineers focus their skills on computer systems and physical components - designing microprocessors, circuit boards, routers, and embedded devices that power modern smart electronics.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-laptop-code"></i></div>
                                <h4>Software Engineering</h4>
                            </div>
                            <p>On the software side, engineers create, test, and debug programs and applications that run on computers, distributed networks, cloud architectures, and mobile devices to solve complex challenges.</p>
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
                                <td><strong>Computer Engineering</strong></td>
                                <td><span class="dept-tag-ug">UG (B.E.)</span></td>
                                <td>4 Years (8 Semesters)</td>
                                <td><span class="dept-badge">120 Seats</span></td>
                                <td>2001</td>
                            </tr>
                            <tr>
                                <td><strong>Computer Engineering (Software Engineering)</strong></td>
                                <td><span class="dept-tag-pg">PG (M.E.)</span></td>
                                <td>2 Years (4 Semesters)</td>
                                <td><span class="dept-badge">18 Seats</span></td>
                                <td>2010</td>
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
                        To become a prominent department producing competent professionals with research, innovation and entrepreneurial skills, inculcating moral values and societal concerns.
                    </blockquote>
                </div>

                <div class="dept-charter-card" style="margin-bottom: 48px;">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #111; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.05em;">Mission of the Department</h3>
                    <ul class="dept-mission-steps">
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">I</span>
                            <div class="dept-mission-text">
                                To create globally competent students having ability to design, develop and test world class software, keeping pace with the latest technological developments.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">II</span>
                            <div class="dept-mission-text">
                                Create facilities and expertise in advanced computer technology thereby promote research.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">III</span>
                            <div class="dept-mission-text">
                                Enhance Industry Institute Interaction programme to get acquainted with corporate culture.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">IV</span>
                            <div class="dept-mission-text">
                                Induce moral, ethical values and spirit of social commitment.
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Objectives (PEOs and PSOs) -->
                <div class="dept-objectives-grid">
                    <div class="dept-obj-card">
                        <h4>Program Educational Objectives (PEOs)</h4>
                        <div class="dept-obj-lead">Graduates will:</div>
                        <ul class="dept-obj-list">
                            <li><strong>PEO 1:</strong> Be an efficient Software developer in diverse fields and will be a successful professional and/or pursue higher studies.</li>
                            <li><strong>PEO 2:</strong> Be capable to adapt advanced state of the art computing technology for professional excellence and Research and be a lifelong learner.</li>
                            <li><strong>PEO 3:</strong> Work productively exhibiting ethical qualities for the betterment of society.</li>
                            <li><strong>PEO 4:</strong> Possess leadership and entrepreneurial qualities, work harmoniously as a team member with effective communication skills.</li>
                        </ul>
                    </div>

                    <div class="dept-obj-card">
                        <h4>Program Specific Outcomes (PSOs)</h4>
                        <div class="dept-obj-lead">Computer Engineering Graduate will be able to:</div>
                        <ul class="dept-obj-list">
                            <li><strong>PSO 1:</strong> Gain capability to use current / advanced technology, skills and tools necessary for carrying out Real-World Multidisciplinary projects.</li>
                            <li><strong>PSO 2:</strong> Achieve an ability to build a computer based system, process or a component that meets the desired needs.</li>
                            <li><strong>PSO 3:</strong> Apply concepts of core areas of Computer Engineering - Data Structures, Database Management Systems, Operating Systems, Computer Architecture and Software Engineering to provide innovative solution.</li>
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
                    <p>Modern computing infrastructure supporting coursework from fundamental algorithmic programming to advanced capstone innovation.</p>
                </div>

                <div class="dept-labs-showcase">
                    <!-- Lab 8112: Project and Research Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_8112_project.jpg" alt="Room 8112 - Project &amp; Research Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Room 8112</span>
                            <h3 class="dept-lab-title">Project &amp; Research Lab</h3>
                            <p class="dept-lab-desc">Equipped for final-year undergraduate capstone projects, multidisciplinary research, and startup incubation with high-performance desktop towers and gigabit switches.</p>
                        </div>
                    </div>

                    <!-- Lab 8113: Programming Lab 1 -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_8113_programming1.jpg" alt="Room 8113 - Programming Laboratory 1" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Room 8113</span>
                            <h3 class="dept-lab-title">Programming Laboratory - 1</h3>
                            <p class="dept-lab-desc">Dedicated to Database Management Systems (Oracle/MySQL), Operating Systems internals, Computer Graphics, and Python application development.</p>
                        </div>
                    </div>

                    <!-- Lab 8115: Hardware and Networking Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_8115_hardware.jpg" alt="Room 8115 - Computer Hardware &amp; Networking Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Room 8115</span>
                            <h3 class="dept-lab-title">Computer Hardware &amp; Networking Lab</h3>
                            <p class="dept-lab-desc">Outfitted with digital electronics trainers, 8085/8086 microprocessor kits, Cisco managed switches, packet sniffing stations, and IoT microcontroller boards.</p>
                        </div>
                    </div>

                    <!-- Lab 8116: PPS Lab 2 -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_8116_pps2.jpg" alt="Room 8116 - PPS Laboratory 2" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Room 8116</span>
                            <h3 class="dept-lab-title">PPS Laboratory - 2</h3>
                            <p class="dept-lab-desc">Designed for freshman Programming for Problem Solving (PPS) courses, instilling structured programming principles using C/C++ in a networked terminal environment.</p>
                        </div>
                    </div>

                    <!-- Lab 8117: Advanced Software Lab 3 -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_8117_programming3.jpg" alt="Room 8117 - Advanced Software &amp; ML Lab 3" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Room 8117</span>
                            <h3 class="dept-lab-title">Advanced Software &amp; ML Lab - 3</h3>
                            <p class="dept-lab-desc">High-speed computational cluster utilized for Compiler Design, Full-Stack Web Technologies, Distributed Cloud Computing, and Machine Learning algorithms.</p>
                        </div>
                    </div>

                    <!-- Department Seminar Room -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/seminar_room.jpg" alt="Department Seminar Room" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Seminar Complex</span>
                            <h3 class="dept-lab-title">Department Seminar Room</h3>
                            <p class="dept-lab-desc">Acoustically treated conference and colloquium room with ceiling-mounted digital projection, surround audio, and video conferencing capabilities for scholarly defenses.</p>
                        </div>
                    </div>
                </div>

                <!-- Key Department Facilities (Below Laboratory Showcase) -->
                <div class="dept-section-header" style="margin-top: 56px;">
                    <span class="dept-section-kicker">INFRASTRUCTURE HIGHLIGHTS</span>
                    <h2>Department Facilities</h2>
                    <p>Modern campus-wide connectivity, state-of-the-art computing laboratories, and high-tech academic amenities powering student innovation.</p>
                </div>

                <div class="dept-facilities-grid">
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-wifi"></i></div>
                        <div class="dept-facility-info">
                            <h4>Wi-Fi enabled Department</h4>
                            <p>High-speed wireless internet access across all departmental blocks, labs, and interactive classrooms.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-network-wired"></i></div>
                        <div class="dept-facility-info">
                            <h4>Campus Wide Fiber Optic Cable Network</h4>
                            <p>Gigabit optical backbone seamlessly interconnecting computer laboratories, data centers, and academic blocks.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-desktop"></i></div>
                        <div class="dept-facility-info">
                            <h4>System Lab</h4>
                            <p>High-performance workstations dedicated to fundamental system software, assembly, and core computation.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-project-diagram"></i></div>
                        <div class="dept-facility-info">
                            <h4>Network Lab</h4>
                            <p>Hardware routing, switching gear, and packet simulation environments for hands-on networking practice.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-code"></i></div>
                        <div class="dept-facility-info">
                            <h4>Programming Language Lab</h4>
                            <p>Integrated development environments and compiler suites supporting C, C++, Java, and modern programming.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-database"></i></div>
                        <div class="dept-facility-info">
                            <h4>DBMS Lab</h4>
                            <p>Dedicated database management systems facility for relational, NoSQL, and query design experimentation.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-microchip"></i></div>
                        <div class="dept-facility-info">
                            <h4>Digital Logic Lab</h4>
                            <p>Hardware logic design trainer kits, breadboards, digital IC testers, and microprocessor experiment benches.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-terminal"></i></div>
                        <div class="dept-facility-info">
                            <h4>Operating System Lab</h4>
                            <p>Multi-OS testbed with Unix/Linux environments, kernel experimentation, and process scheduling tools.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="dept-facility-info">
                            <h4>Seminar Halls</h4>
                            <p>Acoustically engineered presentation halls with AV projection systems for expert talks and tech symposiums.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-laptop-code"></i></div>
                        <div class="dept-facility-info">
                            <h4>Digital Learning Lab</h4>
                            <p>E-learning platform terminals, MOOC access, virtual classroom suites, and online certification hub.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 6: Faculty publications (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/publications-tab.php'; ?>

            <!-- Tab 7: Advisory Board (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/advisory-board-tab.php'; ?>

            <!-- Tab 8: Newsletters (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/newsletters-tab.php'; ?>

        </div>
    </main>

</div>

<?php
// Include Footer
include_once __DIR__ . '/../../includes/footer.php';
?>
