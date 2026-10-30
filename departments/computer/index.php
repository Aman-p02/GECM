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
            <nav class="us-breadcrumb" aria-label="Academic Navigation Breadcrumbs">
                <a href="<?= $root_path ?>">Home</a>
                <span class="sep">/</span>
                <a href="<?= $root_path ?>#departments">Academic Departments</a>
                <span class="sep">/</span>
                <span class="active-crumb">Computer Engineering</span>
            </nav>

            <span class="us-dept-kicker">Department of</span>
            <h1 class="us-dept-heading">Computer Engineering</h1>
            <p class="us-dept-tagline">
                Advancing computational science, software architectures, and intelligent systems since 2001. Dedicated to educating globally competent engineers through rigorous theory and hands-on laboratory discovery.
            </p>

            <!-- Key metrics counter strip -->
            <div class="us-stats-strip">
                <div class="us-stat-item">
                    <span class="us-stat-num">2001</span>
                    <span class="us-stat-label">Year of Establishment</span>
                </div>
                <div class="us-stat-item">
                    <span class="us-stat-num">138</span>
                    <span class="us-stat-label">Annual Approved Intake</span>
                </div>
                <div class="us-stat-item">
                    <span class="us-stat-num">10 <strong>Labs</strong></span>
                    <span class="us-stat-label">Specialized Facilities</span>
                </div>
                <div class="us-stat-item">
                    <span class="us-stat-num">GTU / AICTE</span>
                    <span class="us-stat-label">Affiliation &amp; Approval</span>
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
                    <p>Providing rigorous engineering education, research mentorship, and industrial training across computer hardware, software systems, and data-driven intelligence.</p>
                </div>

                <div class="us-about-split">
                    <div class="us-story-body">
                        <blockquote class="us-lead-quote">
                            "Equipping tomorrow's software engineers with foundational mathematics, modern computing architectures, and the collaborative skills needed to address complex societal challenges."
                        </blockquote>
                        <p>
                            Running continuously since 2001, the Department of Computer Engineering is equipped with high-performance computing clusters, multimedia software, and optical fiber gigabit networking. The department has established robust laboratories in Computer Hardware, Networking &amp; Security, Database Management Systems, Computer Graphics, and Internet Technologies in tune with real-time systems.
                        </p>
                        <p>
                            Under AICTE grant assistance, the campus-wide network infrastructure was engineered and is centrally maintained by the department. In addition to the four-year undergraduate program, the department offers a specialized Post Graduate program (M.E. in Computer Science &amp; Engineering) established in 2010.
                        </p>
                        <p>
                            Computer Engineering and Information Technology share infrastructural facilities in a spacious academic complex, complete with 10 computer laboratories and two seminar halls, providing students an immersive environment to build industry-scale software solutions.
                        </p>
                    </div>

                    <div class="us-feature-cards">
                        <div class="us-feature-card">
                            <h4>Gigabit Campus LAN Backbone</h4>
                            <p>250+ high-performance networked terminals linked through high-speed optical fiber backbone infrastructure.</p>
                        </div>
                        <div class="us-feature-card">
                            <h4>Enterprise Campus Wi-Fi</h4>
                            <p>30 enterprise-grade wireless access points with centralized controller ensuring seamless campus connectivity.</p>
                        </div>
                        <div class="us-feature-card">
                            <h4>Central Department Servers</h4>
                            <p>Dedicated high-capacity servers hosting local Git repositories, e-learning platforms, and computational workloads.</p>
                        </div>
                        <div class="us-feature-card">
                            <h4>Postgraduate Research Wing</h4>
                            <p>M.E. in Computer Science &amp; Engineering running successfully since 2010 with dedicated research laboratories.</p>
                        </div>
                    </div>
                </div>

                <!-- Degree programs table -->
                <div class="us-degrees-section">
                    <h3>Academic Degree Programs</h3>
                    <div class="us-table-wrap">
                        <table class="us-clean-table">
                            <thead>
                                <tr>
                                    <th>Program Title</th>
                                    <th>Level</th>
                                    <th>Approved Intake</th>
                                    <th>Duration</th>
                                    <th>Affiliation</th>
                                    <th>Eligibility / Admission</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>B.E. Computer Engineering</strong></td>
                                    <td><span class="us-tag-ug">Undergraduate</span></td>
                                    <td>138 Seats</td>
                                    <td>4 Years (8 Semesters)</td>
                                    <td>GTU / AICTE Approved</td>
                                    <td>ACPC Gujarat (GUJCET / JEE Main)</td>
                                </tr>
                                <tr>
                                    <td><strong>M.E. Computer Science &amp; Engineering</strong></td>
                                    <td><span class="us-tag-pg">Postgraduate</span></td>
                                    <td>18 Seats</td>
                                    <td>2 Years (4 Semesters)</td>
                                    <td>GTU / AICTE Approved</td>
                                    <td>ACPC Gujarat (GATE / Non-GATE PGCET)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Tab 2: Vision and Mission -->
            <section class="us-tab-pane" id="tab-vision-mission">
                <div class="us-section-header">
                    <span class="us-section-kicker">INSTITUTIONAL CHARTER</span>
                    <h2>Vision &amp; Mission</h2>
                    <p>Guiding pedagogical excellence, research ethics, and technical leadership for students and faculty alike.</p>
                </div>

                <div class="us-charter-grid">
                    <div class="us-charter-card">
                        <h3>Department Vision</h3>
                        <p class="us-charter-desc">
                            "To produce globally competent and ethically responsible computer engineering professionals capable of leading innovation, technical entrepreneurship, and sustainable societal development."
                        </p>
                    </div>

                    <div class="us-charter-card">
                        <h3>Department Mission</h3>
                        <ul class="us-mission-steps">
                            <li class="us-mission-item">
                                <span class="us-mission-index">I</span>
                                <div class="us-mission-text">
                                    <strong>Foundational Excellence:</strong> Deliver rigorous theoretical instruction blended with extensive laboratory experimentation in computer hardware and software systems.
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
