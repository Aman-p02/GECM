<?php
// Set Page Variables
$page_title = "Department of Computer Engineering — Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/computer/css/department.css";
$extra_js = "departments/computer/js/department.js";

// Include Header
include_once __DIR__ . '/../../includes/header.php';
?>

<div class="us-dept-page">

    <!-- Hero header section -->
    <header class="us-hero-banner">
        <div class="us-container">
            <!-- Two-column hero grid (7 cols left, 5 cols right) -->
            <div class="us-hero-grid">
                <div class="us-hero-text">
                    <span class="us-dept-kicker">DEPARTMENT OF</span>
                    <h1 class="us-dept-heading">Computer Engineering</h1>
                    <p class="us-dept-tagline">
Empowering future engineers through innovation and technology. Focused on practical learning, software development, and building skills for the digital future.
                    </p>
                </div>
                <div class="us-hero-media">
                    <img src="images/department_building.jpg" alt="Government Engineering College Modasa - Computer Engineering Department Building" class="us-hero-photo">
                </div>
            </div>

            <!-- Key metrics counter strip (separated by single thin 1px line, no boxes, no vertical dividers) -->
            <div class="us-stats-strip">
                <div class="us-stat-item">
                    <span class="us-stat-num">2001</span>
                    <span class="us-stat-label">YEAR OF ESTABLISHMENT</span>
                </div>
                <div class="us-stat-item">
                    <span class="us-stat-num">120</span>
                    <span class="us-stat-label">ANNUAL APPROVED INTAKE</span>
                </div>
                <div class="us-stat-item">
                    <span class="us-stat-num">10</span>
                    <span class="us-stat-label">SPECIALIZED LABS</span>
                </div>
                <div class="us-stat-item">
                    <span class="us-stat-num">25</span>
                    <span class="us-stat-label">FACULTY MEMBERS</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Sticky sub-navigation bar -->
    <nav class="us-subnav-bar" id="deptSubNav" aria-label="Department Navigation">
        <div class="us-container">
            <ul class="us-subnav-list" role="tablist">
                <li class="us-subnav-item active">
                    <button type="button" class="us-subnav-link active" data-tab="about" role="tab" aria-selected="true">About Department</button>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="vision-mission" role="tab" aria-selected="false">Vision &amp; Mission</button>
                </li>
                <li class="us-subnav-item">
                    <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="us-subnav-link" aria-label="GTU Official Syllabus Portal">
                        <span>Syllabus</span>
                        <i class="fas fa-external-link-alt ext-arrow"></i>
                    </a>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="faculty" role="tab" aria-selected="false">Faculty Directory</button>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="activities" role="tab" aria-selected="false">Activities</button>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="facilities" role="tab" aria-selected="false">Facilities &amp; Labs</button>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="publications" role="tab" aria-selected="false">Publications</button>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="advisory-board" role="tab" aria-selected="false">Industry Advisory Board</button>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="newsletters" role="tab" aria-selected="false">Newsletters</button>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Tab panels container -->
    <main class="us-main-content">
        <div class="us-container">

            <!-- Tab 1: About Department -->
            <section class="us-tab-pane active" id="tab-about">
                <div class="us-section-header">
                    <span class="us-section-kicker">ACADEMIC OVERVIEW</span>
                    <h2>About the Department</h2>
                    <p>Pioneering engineering education, campus network engineering, and laboratory discovery at Government Engineering College, Modasa since 2001.</p>
                </div>

                <div class="us-story-body">
                    <blockquote class="us-lead-quote">
                        "Fostering next-generation computing engineers through deep theoretical foundations, state-of-the-art laboratory discovery, and real-time systems mastery."
                    </blockquote>
                    <p>
                        Established in 2001, the Department of Computer Engineering operates in a newly constructed, spacious, and well-furnished academic complex shared with the Information Technology department. The academic facility features 10 specialized computer laboratories and two air-conditioned seminar halls, offering students an immersive environment for software engineering, algorithmic exploration, and technical innovation.
                    </p>
                    <p>
                        Under AICTE Grant assistance for Campus Networking, the department centrally planned, engineered, and manages the entire campus-wide network infrastructure. The computing infrastructure connects more than 250 networked nodes across optical fiber and high-speed LAN systems, reinforced with 30 enterprise Wi-Fi access points orchestrated through a centralized controller for seamless digital connectivity.
                    </p>
                    <p>
                        The department is powered by latest high-end enterprise servers and interactive online instructional platforms, including a dedicated Content Server for network-based e-learning. Backed by a team of highly qualified and experienced faculty members, the department has also offered a specialized Post Graduate programme (M.E. in Computer Engineering with Software Engineering) since 2010, complementing its flagship undergraduate degree.
                    </p>
                </div>

                <!-- About the Programme Section -->
                <div class="us-programme-section">
                    <div class="us-section-header">
                        <span class="us-section-kicker">DISCIPLINE &amp; CAREER PATHS</span>
                        <h2>About the Programme</h2>
                        <p>Integrating computer science and electrical engineering to develop safer, faster, and more powerful computing technologies.</p>
                    </div>

                    <p class="us-programme-lead">
                        Computer engineering blends together computer science and electrical engineering to further advancements in digital technology, computer networking, and computing systems. In turn, computer engineers use their extensive knowledge of hardware and software design and computer programming to make computing platforms and applications more efficient, secure, and effective. At the professional level, the discipline offers two vital avenues:
                    </p>

                    <div class="us-avenues-grid">
                        <div class="us-avenue-card">
                            <div class="us-avenue-header">
                                <div class="us-avenue-icon"><i class="fas fa-microchip"></i></div>
                                <h4>Hardware Engineering</h4>
                            </div>
                            <p>Hardware engineers focus their skills on computer systems and physical components—designing microprocessors, circuit boards, routers, and embedded devices that power modern smart electronics.</p>
                        </div>

                        <div class="us-avenue-card">
                            <div class="us-avenue-header">
                                <div class="us-avenue-icon"><i class="fas fa-laptop-code"></i></div>
                                <h4>Software Engineering</h4>
                            </div>
                            <p>On the software side, engineers create, test, and debug programs and applications that run on computers, distributed networks, cloud architectures, and mobile devices to solve complex challenges.</p>
                        </div>
                    </div>
                </div>

                <!-- Under Graduate / Post Graduate Courses -->
                <div class="us-section-header" style="margin-top: 56px;">
                    <span class="us-section-kicker">ACADEMIC DEGREE OFFERINGS</span>
                    <h2>Undergraduate &amp; Postgraduate Programmes</h2>
                    <p>Approved by the All India Council for Technical Education (AICTE), New Delhi and affiliated with Gujarat Technological University (GTU), Ahmedabad.</p>
                </div>

                <div class="us-table-wrap">
                    <table class="us-clean-table">
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
                                <td><span class="us-tag-ug">UG (B.E.)</span></td>
                                <td>4 Years (8 Semesters)</td>
                                <td><span class="us-badge">120 Seats</span></td>
                                <td>2001</td>
                            </tr>
                            <tr>
                                <td><strong>Computer Engineering (Software Engineering)</strong></td>
                                <td><span class="us-tag-pg">PG (M.E.)</span></td>
                                <td>2 Years (4 Semesters)</td>
                                <td><span class="us-badge">18 Seats</span></td>
                                <td>2010</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Tab 2: Vision & Mission -->
            <section class="us-tab-pane" id="tab-vision-mission">
                <div class="us-section-header">
                    <span class="us-section-kicker">ACADEMIC CHARTER</span>
                    <h2>Vision &amp; Mission</h2>
                    <p>Guiding principles, strategic commitments, and instructional roadmaps defining our engineering pedagogy.</p>
                </div>

                <div class="us-charter-card us-vision-hero-card">
                    <span class="us-vision-quote-mark">“</span>
                    <blockquote class="us-vision-statement">
                        To produce globally competent and ethically responsible computer engineering professionals capable of leading innovation, technical entrepreneurship, and sustainable societal development.
                    </blockquote>
                </div>

                <div class="us-charter-card" style="margin-bottom: 48px;">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #111; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.05em;">Mission of the Department</h3>
                    <ul class="us-mission-steps">
                        <li class="us-mission-item">
                            <span class="us-mission-index">I</span>
                            <div class="us-mission-text">
                                <strong>Foundational Excellence:</strong> Deliver rigorous theoretical instruction blended with extensive laboratory experimentation in computer hardware, software engineering, and intelligent systems.
                            </div>
                        </li>
                        <li class="us-mission-item">
                            <span class="us-mission-index">II</span>
                            <div class="us-mission-text">
                                <strong>Industrial Relevance:</strong> Foster industry partnerships, technical internships, and collaborative problem-solving to meet contemporary technology demands.
                            </div>
                        </li>
                        <li class="us-mission-item">
                            <span class="us-mission-index">III</span>
                            <div class="us-mission-text">
                                <strong>Research &amp; Innovation:</strong> Cultivate multidisciplinary research, student innovation sprints, and lifelong learning attitudes among aspiring engineers.
                            </div>
                        </li>
                        <li class="us-mission-item">
                            <span class="us-mission-index">IV</span>
                            <div class="us-mission-text">
                                <strong>Ethical Leadership:</strong> Instill professional ethics, environmental awareness, and civic responsibility in technological design.
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Objectives (PEOs and PSOs) -->
                <div class="us-objectives-grid">
                    <div class="us-obj-card">
                        <h4>Program Educational Objectives (PEOs)</h4>
                        <ul class="us-obj-list">
                            <li><strong>PEO 1:</strong> Establish successful careers in core computing and IT industries or pursue higher scholarly research in advanced engineering domains.</li>
                            <li><strong>PEO 2:</strong> Analyze, design, and validate algorithmic solutions for complex engineering problems utilizing modern computational tools.</li>
                            <li><strong>PEO 3:</strong> Demonstrate professional ethics, effective multidisciplinary teamwork, communication skills, and commitment to lifelong self-learning.</li>
                        </ul>
                    </div>

                    <div class="us-obj-card">
                        <h4>Program Specific Outcomes (PSOs)</h4>
                        <ul class="us-obj-list">
                            <li><strong>PSO 1:</strong> Ability to apply core software engineering, operating system concepts, and data structures to develop robust enterprise applications.</li>
                            <li><strong>PSO 2:</strong> Ability to design and evaluate secure distributed architectures, networks, and intelligent machine learning systems.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Tab 3: Faculty directory -->
            <section class="us-tab-pane" id="tab-faculty">
                <div class="us-section-header">
                    <span class="us-section-kicker">SCHOLARLY DIRECTORY</span>
                    <h2>Faculty Members</h2>
                    <p>Our distinguished academic roster of educators, researchers, and technical mentors dedicated to student mastery.</p>
                </div>

                <div class="us-faculty-roster">
                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">HP</div>
                        <h4 class="us-faculty-name">Dr. H. M. Patel</h4>
                        <div class="us-faculty-rank">Professor &amp; Head of Department</div>
                        <div class="us-faculty-degrees">Ph.D., M.Tech (Computer Engineering)<br><small>Specialization: Cloud Security, Distributed Systems</small></div>
                        <a href="mailto:hod_ce@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> hod_ce@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">AS</div>
                        <h4 class="us-faculty-name">Prof. A. S. Shah</h4>
                        <div class="us-faculty-rank">Associate Professor</div>
                        <div class="us-faculty-degrees">Ph.D. (Pursuing), M.E. (Computer Engineering)<br><small>Specialization: IoT Security, Embedded Networks</small></div>
                        <a href="mailto:asshah@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> asshah@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">RP</div>
                        <h4 class="us-faculty-name">Prof. R. K. Prajapati</h4>
                        <div class="us-faculty-rank">Assistant Professor</div>
                        <div class="us-faculty-degrees">M.E. (Computer Science &amp; Engineering)<br><small>Specialization: Data Engineering, Cryptography</small></div>
                        <a href="mailto:rkprajapati@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> rkprajapati@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">PM</div>
                        <h4 class="us-faculty-name">Prof. P. N. Mehta</h4>
                        <div class="us-faculty-rank">Assistant Professor</div>
                        <div class="us-faculty-degrees">M.Tech (Software Engineering)<br><small>Specialization: Microservices, Web Architectures</small></div>
                        <a href="mailto:pnmehta@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> pnmehta@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">SJ</div>
                        <h4 class="us-faculty-name">Prof. S. D. Joshi</h4>
                        <div class="us-faculty-rank">Assistant Professor</div>
                        <div class="us-faculty-degrees">M.E. (Computer Engineering)<br><small>Specialization: Machine Learning, Neural Signals</small></div>
                        <a href="mailto:sdjoshi@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> sdjoshi@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">MP</div>
                        <h4 class="us-faculty-name">Prof. M. B. Patel</h4>
                        <div class="us-faculty-rank">Assistant Professor</div>
                        <div class="us-faculty-degrees">M.Tech (Information Technology)<br><small>Specialization: Mobile Systems, Data Mining</small></div>
                        <a href="mailto:mbpatel@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> mbpatel@gecmodasa.ac.in
                        </a>
                    </div>
                </div>
            </section>

            <!-- Tab 4: Activities and events -->
            <section class="us-tab-pane" id="tab-activities">
                <div class="us-section-header">
                    <span class="us-section-kicker">CAMPUS ENGAGEMENT</span>
                    <h2>Department Activities</h2>
                    <p>Annual hackathons, industrial field tours, expert colloquia, and hands-on developer workshops.</p>
                </div>

                <div class="us-periodical-grid">
                    <div class="us-feature-card">
                        <h4>Annual CodeFest &amp; Hackathons</h4>
                        <p>24-hour technical coding sprints challenging student developers to solve real-world industrial and civic governance problems using full-stack frameworks and AI APIs.</p>
                    </div>
                    <div class="us-feature-card">
                        <h4>Industry Masterclass Series</h4>
                        <p>Distinguished technical architects and engineering leaders deliver in-depth sessions on cloud infrastructure, container orchestration, and cybersecurity hygiene.</p>
                    </div>
                    <div class="us-feature-card">
                        <h4>Industrial Research Visits</h4>
                        <p>Experiential tours to leading scientific centers including BISAG-N Gandhinagar, TCS Garima Park, and ISRO Space Applications Centre to observe production data centers.</p>
                    </div>
                    <div class="us-feature-card">
                        <h4>Faculty Development Programs (FDP)</h4>
                        <p>GTU-sponsored short-term training programs on deep learning, internet of things, and advanced pedagogy conducted for regional engineering educators.</p>
                    </div>
                </div>
            </section>

            <!-- Tab 5: Laboratory facilities -->
            <section class="us-tab-pane" id="tab-facilities">
                <div class="us-section-header">
                    <span class="us-section-kicker">EXPERIMENTAL INFRASTRUCTURE</span>
                    <h2>Laboratories &amp; Facilities</h2>
                    <p>Modern computing infrastructure supporting coursework from fundamental algorithmic programming to advanced capstone innovation.</p>
                </div>

                <div class="us-labs-showcase">
                    <!-- Lab 8112: Project and Research Lab -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="images/labs/lab_8112_project.jpg" alt="Room 8112 - Project &amp; Research Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Room 8112</span>
                            <h3 class="us-lab-title">Project &amp; Research Lab</h3>
                            <p class="us-lab-desc">Equipped for final-year undergraduate capstone projects, multidisciplinary research, and startup incubation with high-performance desktop towers and gigabit switches.</p>
                        </div>
                    </div>

                    <!-- Lab 8113: Programming Lab 1 -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="images/labs/lab_8113_programming1.jpg" alt="Room 8113 - Programming Laboratory 1" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Room 8113</span>
                            <h3 class="us-lab-title">Programming Laboratory - 1</h3>
                            <p class="us-lab-desc">Dedicated to Database Management Systems (Oracle/MySQL), Operating Systems internals, Computer Graphics, and Python application development.</p>
                        </div>
                    </div>

                    <!-- Lab 8115: Hardware and Networking Lab -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="images/labs/lab_8115_hardware.jpg" alt="Room 8115 - Computer Hardware &amp; Networking Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Room 8115</span>
                            <h3 class="us-lab-title">Computer Hardware &amp; Networking Lab</h3>
                            <p class="us-lab-desc">Outfitted with digital electronics trainers, 8085/8086 microprocessor kits, Cisco managed switches, packet sniffing stations, and IoT microcontroller boards.</p>
                        </div>
                    </div>

                    <!-- Lab 8116: PPS Lab 2 -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="images/labs/lab_8116_pps2.jpg" alt="Room 8116 - PPS Laboratory 2" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Room 8116</span>
                            <h3 class="us-lab-title">PPS Laboratory - 2</h3>
                            <p class="us-lab-desc">Designed for freshman Programming for Problem Solving (PPS) courses, instilling structured programming principles using C/C++ in a networked terminal environment.</p>
                        </div>
                    </div>

                    <!-- Lab 8117: Advanced Software Lab 3 -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="images/labs/lab_8117_programming3.jpg" alt="Room 8117 - Advanced Software &amp; ML Lab 3" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Room 8117</span>
                            <h3 class="us-lab-title">Advanced Software &amp; ML Lab - 3</h3>
                            <p class="us-lab-desc">High-speed computational cluster utilized for Compiler Design, Full-Stack Web Technologies, Distributed Cloud Computing, and Machine Learning algorithms.</p>
                        </div>
                    </div>

                    <!-- Department Seminar Room -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="images/labs/seminar_room.jpg" alt="Department Seminar Room" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Seminar Complex</span>
                            <h3 class="us-lab-title">Department Seminar Room</h3>
                            <p class="us-lab-desc">Acoustically treated conference and colloquium room with ceiling-mounted digital projection, surround audio, and video conferencing capabilities for scholarly defenses.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 6: Faculty publications -->
            <section class="us-tab-pane" id="tab-publications">
                <div class="us-section-header">
                    <span class="us-section-kicker">SCHOLARLY OUTPUT</span>
                    <h2>Faculty Publications</h2>
                    <p>Recent peer-reviewed international journal articles, conference papers, and book chapters published by departmental faculty.</p>
                </div>

                <div class="us-citations-list">
                    <div class="us-citation-item">
                        <div class="us-citation-title">Deep Learning Approaches for Real-Time Network Intrusion Detection in IoT Networks</div>
                        <div class="us-citation-authors">Dr. H. M. Patel, Prof. A. S. Shah (2024)</div>
                        <div class="us-citation-venue">International Journal of Information and Computer Security, Inderscience, Vol. 18, Issue 3</div>
                    </div>
                    <div class="us-citation-item">
                        <div class="us-citation-title">An Efficient Cryptographic Framework for Cloud Data Integrity Verification</div>
                        <div class="us-citation-authors">Prof. R. K. Prajapati, Dr. H. M. Patel (2023)</div>
                        <div class="us-citation-venue">IEEE International Conference on Advanced Computing Technologies (ICACT), Proceedings, pp. 112–118</div>
                    </div>
                    <div class="us-citation-item">
                        <div class="us-citation-title">Performance Optimization in Distributed Microservices Architecture using Containerization</div>
                        <div class="us-citation-authors">Prof. P. N. Mehta (2023)</div>
                        <div class="us-citation-venue">Springer Communications in Computer and Information Science, Vol. 1422, pp. 45–59</div>
                    </div>
                    <div class="us-citation-item">
                        <div class="us-citation-title">Comparative Analysis of Machine Learning Classifiers for Brain-Computer Interface Applications</div>
                        <div class="us-citation-authors">Prof. S. D. Joshi, Prof. M. B. Patel (2022)</div>
                        <div class="us-citation-venue">Elsevier Procedia Computer Science, Vol. 218, pp. 1402–1411</div>
                    </div>
                </div>
            </section>

            <!-- Tab 7: Industry Advisory Board -->
            <section class="us-tab-pane" id="tab-advisory-board">
                <div class="us-section-header">
                    <span class="us-section-kicker">GOVERNANCE &amp; CURRICULUM</span>
                    <h2>Industry Advisory Board (IAB)</h2>
                    <p>Distinguished technical directors, senior architects, and researchers actively steering academic relevance and recruitment readiness.</p>
                </div>

                <div class="us-table-wrap">
                    <table class="us-clean-table">
                        <thead>
                            <tr>
                                <th>Distinguished Member</th>
                                <th>Organization &amp; Designation</th>
                                <th>Committee Role</th>
                                <th>Active Term</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Dr. H. M. Patel</strong></td>
                                <td>Head of Department, Computer Engineering, GEC Modasa</td>
                                <td>Chairman</td>
                                <td>2025–2026</td>
                            </tr>
                            <tr>
                                <td><strong>Mr. Nirav Joshi</strong></td>
                                <td>Senior Cloud Solutions Architect, Tata Consultancy Services (TCS)</td>
                                <td>Industry Member</td>
                                <td>2025–2026</td>
                            </tr>
                            <tr>
                                <td><strong>Ms. Pooja Sharma</strong></td>
                                <td>Lead Data Scientist, Infosys Limited</td>
                                <td>Industry Member</td>
                                <td>2025–2026</td>
                            </tr>
                            <tr>
                                <td><strong>Prof. A. S. Shah</strong></td>
                                <td>Associate Professor, Computer Engineering, GEC Modasa</td>
                                <td>Member Secretary</td>
                                <td>2025–2026</td>
                            </tr>
                            <tr>
                                <td><strong>Mr. Rajesh Vaghela</strong></td>
                                <td>Vice President of Engineering, eInfochips</td>
                                <td>Industry Member</td>
                                <td>2023–2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Tab 8: Department newsletters -->
            <section class="us-tab-pane" id="tab-newsletters">
                <div class="us-section-header">
                    <span class="us-section-kicker">DEPARTMENT CHRONICLE</span>
                    <h2>Department Newsletters</h2>
                    <p>Official periodic publications recording student victories, research grants, faculty honors, and alumni spotlights.</p>
                </div>

                <div class="us-periodical-grid">
                    <div class="us-periodical-card">
                        <div class="us-periodical-body">
                            <span class="us-periodical-meta">Vol. 1, Issue 2 · Academic Year 2024–25</span>
                            <h4 class="us-periodical-title">CompTech Chronicle</h4>
                            <p class="us-periodical-summary">Features comprehensive recaps of CodeFest 2024, expert lectures by cloud architects, national hackathon podium finishes, and recent faculty IEEE publications.</p>
                            <a href="#" class="us-download-btn"><i class="fas fa-file-pdf"></i> Download Newsletter (PDF)</a>
                        </div>
                    </div>

                    <div class="us-periodical-card">
                        <div class="us-periodical-body">
                            <span class="us-periodical-meta">Vol. 1, Issue 1 · Academic Year 2023–24</span>
                            <h4 class="us-periodical-title">CompTech Chronicle (Inaugural Issue)</h4>
                            <p class="us-periodical-summary">Inaugural release highlighting the AICTE laboratory modernization grant, establishment of new computational clusters, and alumni career milestones in global tech firms.</p>
                            <a href="#" class="us-download-btn"><i class="fas fa-file-pdf"></i> Download Newsletter (PDF)</a>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>

</div>

<?php
// Include Footer
include_once __DIR__ . '/../../includes/footer.php';
?>
