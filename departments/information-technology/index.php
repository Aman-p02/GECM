<?php
// Set Page Variables
$page_title = "Department of Information Technology — Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/information-technology/css/department.css";
$extra_js = "departments/information-technology/js/department.js";

// Include Header
include_once __DIR__ . '/../../includes/header.php';
?>

<div class="us-dept-page">

    <!-- 1. US University Masthead & Hero Banner -->
    <header class="us-hero-banner">
        <div class="us-container">
            <nav class="us-breadcrumb" aria-label="Academic Navigation Breadcrumbs">
                <a href="<?= $root_path ?>">Home</a>
                <span class="sep">/</span>
                <a href="<?= $root_path ?>#departments">Academic Departments</a>
                <span class="sep">/</span>
                <span class="active-crumb">Information Technology</span>
            </nav>

            <span class="us-dept-kicker">Department of</span>
            <h1 class="us-dept-heading">Information Technology</h1>
            <p class="us-dept-tagline">
                Pioneering software engineering, web architectures, cybersecurity, and intelligent information networks since 1999. Dedicated to empowering students through innovative project-based learning and state-of-the-art computational laboratories.
            </p>

            <!-- Institutional Metrics Strip -->
            <div class="us-stats-strip">
                <div class="us-stat-item">
                    <span class="us-stat-num">1999</span>
                    <span class="us-stat-label">Year of Establishment</span>
                </div>
                <div class="us-stat-item">
                    <span class="us-stat-num">120</span>
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

    <!-- 2. Sticky Sub-Navigation Bar -->
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

    <!-- 3. Main Department Content -->
    <main class="us-main-content">
        <div class="us-container">

            <!-- TAB 1: ABOUT DEPARTMENT -->
            <section class="us-tab-pane active" id="tab-about">
                <div class="us-section-header">
                    <span class="us-section-kicker">ACADEMIC OVERVIEW</span>
                    <h2>About the Department</h2>
                    <p>Delivering high-caliber education in modern software paradigms, full-stack systems, distributed cloud computing, and real-time enterprise networks.</p>
                </div>

                <div class="us-about-split">
                    <div class="us-story-body">
                        <blockquote class="us-lead-quote">
                            "Shaping innovative information technologists proficient in scalable architectures, enterprise web ecosystems, and modern secure software delivery."
                        </blockquote>
                        <p>
                            Established in 1999, the Department of Information Technology has continuously evolved to meet the demands of the global software industry. With a sanctioned intake of 120 students in the four-year Bachelor of Engineering program, the department provides rigorous exposure to programming fundamentals, software architecture, and modern cloud deployment frameworks.
                        </p>
                        <p>
                            The department is housed within a modern computing complex with dedicated labs in Web Technology, Database Systems, Network Security, and Project Development. Students benefit from gigabit optical fiber connectivity, high-speed Wi-Fi access, and industry-aligned experiential practicals.
                        </p>
                        <p>
                            Through close collaboration with leading IT enterprises and continuous student mentorship, graduates from the Information Technology department secure prestigious placements in top software consultancies, multinational corporations, and premier research universities.
                        </p>
                    </div>

                    <div class="us-feature-cards">
                        <div class="us-feature-card">
                            <h4>Specialized Cloud &amp; Web Labs</h4>
                            <p>Modern terminal nodes configured with Node.js, Python, Java, Docker, and full-stack software stacks.</p>
                        </div>
                        <div class="us-feature-card">
                            <h4>Industry-Driven Capstone Projects</h4>
                            <p>Final-year engineering projects guided by both academic faculty and senior industry tech architects.</p>
                        </div>
                        <div class="us-feature-card">
                            <h4>High-Speed Campus Backbone</h4>
                            <p>Optical fiber connectivity linking departmental labs to the institute's central server farm.</p>
                        </div>
                        <div class="us-feature-card">
                            <h4>Active Technical Clubs</h4>
                            <p>Student-led programming clubs organizing weekly coding rounds, hackathons, and technical webinars.</p>
                        </div>
                    </div>
                </div>

                <!-- Academic Programmes Table -->
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
                                    <td><strong>B.E. Information Technology</strong></td>
                                    <td><span class="us-tag-ug">Undergraduate</span></td>
                                    <td>120 Seats</td>
                                    <td>4 Years (8 Semesters)</td>
                                    <td>GTU / AICTE Approved</td>
                                    <td>ACPC Gujarat (GUJCET / JEE Main)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- TAB 2: VISION & MISSION -->
            <section class="us-tab-pane" id="tab-vision-mission">
                <div class="us-section-header">
                    <span class="us-section-kicker">INSTITUTIONAL CHARTER</span>
                    <h2>Vision &amp; Mission</h2>
                    <p>Fostering academic excellence, innovation mindset, and technical integrity in information technology education.</p>
                </div>

                <div class="us-charter-grid">
                    <div class="us-charter-card">
                        <h3>Department Vision</h3>
                        <p class="us-charter-desc">
                            "To emerge as a premier center of excellence in Information Technology education and applied research, nurturing technically proficient and socially responsible engineers who drive digital transformation."
                        </p>
                    </div>

                    <div class="us-charter-card">
                        <h3>Department Mission</h3>
                        <ul class="us-mission-steps">
                            <li class="us-mission-item">
                                <span class="us-mission-index">I</span>
                                <div class="us-mission-text">
                                    <strong>Academic Rigor:</strong> Impart strong theoretical foundation and hands-on skills in information technology, data engineering, and software engineering.
                                </div>
                            </li>
                            <li class="us-mission-item">
                                <span class="us-mission-index">II</span>
                                <div class="us-mission-text">
                                    <strong>Industry Integration:</strong> Strengthen collaborations with IT enterprises to provide exposure to state-of-the-art software tools and practical problem domains.
                                </div>
                            </li>
                            <li class="us-mission-item">
                                <span class="us-mission-index">III</span>
                                <div class="us-mission-text">
                                    <strong>Innovation &amp; Research:</strong> Encourage student innovation, technical design thinking, and multidisciplinary research projects.
                                </div>
                            </li>
                            <li class="us-mission-item">
                                <span class="us-mission-index">IV</span>
                                <div class="us-mission-text">
                                    <strong>Professional Ethics:</strong> Instill professional ethics, effective team collaboration, and a spirit of continuous learning for societal upliftment.
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Objectives (PEOs & PSOs) -->
                <div class="us-objectives-grid">
                    <div class="us-obj-card">
                        <h4>Program Educational Objectives (PEOs)</h4>
                        <ul class="us-obj-list">
                            <li><strong>PEO 1:</strong> Excel in professional careers in software development, web engineering, cloud technologies, or pursue advanced postgraduate research.</li>
                            <li><strong>PEO 2:</strong> Design, build, and maintain scalable software architectures and secure networked systems using contemporary engineering methodologies.</li>
                            <li><strong>PEO 3:</strong> Exhibit leadership qualities, professional ethics, effective interpersonal communication, and adapt to emerging technological disruptions.</li>
                        </ul>
                    </div>

                    <div class="us-obj-card">
                        <h4>Program Specific Outcomes (PSOs)</h4>
                        <ul class="us-obj-list">
                            <li><strong>PSO 1:</strong> Ability to specify, design, implement, and test modern web applications and enterprise information systems.</li>
                            <li><strong>PSO 2:</strong> Ability to apply information security principles, database modeling, and cloud computing concepts to solve complex organizational challenges.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- TAB 3: FACULTY DIRECTORY -->
            <section class="us-tab-pane" id="tab-faculty">
                <div class="us-section-header">
                    <span class="us-section-kicker">SCHOLARLY DIRECTORY</span>
                    <h2>Faculty Members</h2>
                    <p>Our dedicated academic mentors and researchers committed to imparting cutting-edge technical education.</p>
                </div>

                <div class="us-faculty-roster">
                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">BP</div>
                        <h4 class="us-faculty-name">Dr. B. C. Patel</h4>
                        <div class="us-faculty-rank">Professor &amp; Head of Department</div>
                        <div class="us-faculty-degrees">Ph.D., M.E. (Information Technology)<br><small>Specialization: Information Security, Cloud Architectures</small></div>
                        <a href="mailto:hod_it@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> hod_it@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">NP</div>
                        <h4 class="us-faculty-name">Prof. N. M. Prajapati</h4>
                        <div class="us-faculty-rank">Associate Professor</div>
                        <div class="us-faculty-degrees">Ph.D. (Pursuing), M.Tech (Computer Engineering)<br><small>Specialization: Web Mining, Distributed Databases</small></div>
                        <a href="mailto:nmprajapati@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> nmprajapati@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">KS</div>
                        <h4 class="us-faculty-name">Prof. K. R. Solanki</h4>
                        <div class="us-faculty-rank">Assistant Professor</div>
                        <div class="us-faculty-degrees">M.E. (Information Technology)<br><small>Specialization: Full-Stack Web Technologies, Mobile Computing</small></div>
                        <a href="mailto:krsolanki@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> krsolanki@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">DV</div>
                        <h4 class="us-faculty-name">Prof. D. J. Vaghela</h4>
                        <div class="us-faculty-rank">Assistant Professor</div>
                        <div class="us-faculty-degrees">M.Tech (Software Engineering)<br><small>Specialization: DevOps, Software Quality Assurance</small></div>
                        <a href="mailto:djvaghela@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> djvaghela@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">HT</div>
                        <h4 class="us-faculty-name">Prof. H. K. Trivedi</h4>
                        <div class="us-faculty-rank">Assistant Professor</div>
                        <div class="us-faculty-degrees">M.E. (Computer Engineering)<br><small>Specialization: Artificial Intelligence, Data Analytics</small></div>
                        <a href="mailto:hktrivedi@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> hktrivedi@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">MP</div>
                        <h4 class="us-faculty-name">Prof. M. S. Panchal</h4>
                        <div class="us-faculty-rank">Assistant Professor</div>
                        <div class="us-faculty-degrees">M.E. (Information Technology)<br><small>Specialization: Cyber Forensics, Cryptography</small></div>
                        <a href="mailto:mspanchal@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> mspanchal@gecmodasa.ac.in
                        </a>
                    </div>
                </div>
            </section>

            <!-- TAB 4: ACTIVITIES & EVENTS -->
            <section class="us-tab-pane" id="tab-activities">
                <div class="us-section-header">
                    <span class="us-section-kicker">CAMPUS ENGAGEMENT</span>
                    <h2>Department Activities</h2>
                    <p>Developer bootcamps, competitive programming leagues, industry technical tours, and hands-on workshops.</p>
                </div>

                <div class="us-periodical-grid">
                    <div class="us-feature-card">
                        <h4>InfoTech WebSprint &amp; Hackathon</h4>
                        <p>Annual software sprint where student development teams craft production web apps addressing campus workflows, public governance, and fintech solutions.</p>
                    </div>
                    <div class="us-feature-card">
                        <h4>Cloud &amp; DevOps Masterclasses</h4>
                        <p>Invited senior technical leads from top tech firms conduct masterclasses on AWS cloud services, containerization with Docker, and Kubernetes deployment pipelines.</p>
                    </div>
                    <div class="us-feature-card">
                        <h4>Industrial Visits to IT Hubs</h4>
                        <p>Regular educational field trips to GIFT City Gandhinagar, InfoCity, and leading tech companies to observe enterprise software architectures in operation.</p>
                    </div>
                    <div class="us-feature-card">
                        <h4>Open-Source Contribution Drives</h4>
                        <p>Department-sponsored workshops teaching version control with Git, collaborative pull-request workflows, and contributing to open-source software libraries.</p>
                    </div>
                </div>
            </section>

            <!-- TAB 5: FACILITIES & LABS -->
            <section class="us-tab-pane" id="tab-facilities">
                <div class="us-section-header">
                    <span class="us-section-kicker">EXPERIMENTAL INFRASTRUCTURE</span>
                    <h2>Laboratories &amp; Facilities</h2>
                    <p>Modern computing facilities supporting comprehensive curriculum from programming foundations to distributed cloud development.</p>
                </div>

                <div class="us-labs-showcase">
                    <!-- Lab 1: 8212 Project Lab -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="images/labs/lab_8212_project.jpg" alt="Room 8212 - Project &amp; Capstone Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Room 8212</span>
                            <h3 class="us-lab-title">IT Project &amp; Research Lab</h3>
                            <p class="us-lab-desc">Equipped for final-year undergraduate capstone development, multidisciplinary software research, and prototype validation with high-spec desktop machines.</p>
                        </div>
                    </div>

                    <!-- Lab 2: 8213 Web & Cloud Lab -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="images/labs/8213-lab.png" alt="Room 8213 - Web Technology &amp; Cloud Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Room 8213</span>
                            <h3 class="us-lab-title">Web Technology &amp; Cloud Computing Lab</h3>
                            <p class="us-lab-desc">Dedicated to Web Development, Cloud Computing, RESTful API Design, and Full-Stack framework development utilizing modern Linux environments.</p>
                        </div>
                    </div>

                    <!-- Lab 3: 8215 Database & Software Systems Lab -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="images/labs/lab_8215_programming2.jpg" alt="Room 8215 - Database &amp; Software Systems Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Room 8215</span>
                            <h3 class="us-lab-title">Database &amp; Software Systems Lab</h3>
                            <p class="us-lab-desc">Equipped with enterprise relational database servers (Oracle, MySQL, PostgreSQL) and software testing suites for practical coursework.</p>
                        </div>
                    </div>

                    <!-- Lab 4: 8216 PPS Lab -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="images/labs/lab_8216_pps.jpg" alt="Room 8216 - Programming for Problem Solving Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Room 8216</span>
                            <h3 class="us-lab-title">Programming for Problem Solving Lab</h3>
                            <p class="us-lab-desc">Designed for first-year IT students to master algorithmic thinking, data structures, and core programming paradigms using C, C++, and Python.</p>
                        </div>
                    </div>

                    <!-- Lab 5: 8217 Network Security Lab -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="images/labs/lab_8217_programming3.jpg" alt="Room 8217 - Network Security &amp; IoT Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Room 8217</span>
                            <h3 class="us-lab-title">Network Security &amp; IoT Lab</h3>
                            <p class="us-lab-desc">Advanced networking facility with managed switches, traffic analysis tools, Wireshark packet capture stations, and IoT sensor interface nodes.</p>
                        </div>
                    </div>

                    <!-- Seminar Hall -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="images/labs/seminar_hall.jpg" alt="IT Department Seminar Hall" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Seminar Complex</span>
                            <h3 class="us-lab-title">IT Department Seminar Hall</h3>
                            <p class="us-lab-desc">Air-conditioned presentation auditorium equipped with digital audiovisual systems for expert guest lectures, workshops, and project viva defenses.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- TAB 6: PUBLICATIONS -->
            <section class="us-tab-pane" id="tab-publications">
                <div class="us-section-header">
                    <span class="us-section-kicker">SCHOLARLY OUTPUT</span>
                    <h2>Faculty Publications</h2>
                    <p>Recent research papers published by IT faculty members in reputed international journals and IEEE/Springer conferences.</p>
                </div>

                <div class="us-citations-list">
                    <div class="us-citation-item">
                        <div class="us-citation-title">Secure Lightweight Authentication Protocol for IoT-Enabled Smart Campus Environments</div>
                        <div class="us-citation-authors">Dr. B. C. Patel, Prof. K. R. Solanki (2024)</div>
                        <div class="us-citation-venue">Elsevier Computers &amp; Security, Vol. 136, Article 103580</div>
                    </div>
                    <div class="us-citation-item">
                        <div class="us-citation-title">Distributed Ledger Technology for Verifiable Academic Credential Management</div>
                        <div class="us-citation-authors">Prof. N. M. Prajapati, Dr. B. C. Patel (2023)</div>
                        <div class="us-citation-venue">IEEE International Conference on Distributed Computing Systems (ICDCS)</div>
                    </div>
                    <div class="us-citation-item">
                        <div class="us-citation-title">Automated Code Quality Assessment in Continuous Integration Pipelines Using Deep Learning</div>
                        <div class="us-citation-authors">Prof. D. J. Vaghela (2023)</div>
                        <div class="us-citation-venue">Springer Journal of Software Engineering Research and Development, Vol. 11, Issue 2</div>
                    </div>
                    <div class="us-citation-item">
                        <div class="us-citation-title">An Empirical Study of Microservice Failure Recovery Patterns in Cloud-Native Environments</div>
                        <div class="us-citation-authors">Prof. H. K. Trivedi, Prof. M. S. Panchal (2022)</div>
                        <div class="us-citation-venue">International Journal of Web Information Systems, Emerald Publishing, Vol. 18, Issue 4</div>
                    </div>
                </div>
            </section>

            <!-- TAB 7: INDUSTRY ADVISORY BOARD -->
            <section class="us-tab-pane" id="tab-advisory-board">
                <div class="us-section-header">
                    <span class="us-section-kicker">GOVERNANCE &amp; CURRICULUM</span>
                    <h2>Industry Advisory Board (IAB)</h2>
                    <p>Corporate technology leaders and researchers actively collaborating to maintain syllabus relevance with current software industry trends.</p>
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
                                <td><strong>Dr. B. C. Patel</strong></td>
                                <td>Head of Department, Information Technology, GEC Modasa</td>
                                <td>Chairman</td>
                                <td>2025–2026</td>
                            </tr>
                            <tr>
                                <td><strong>Mr. Samir Parikh</strong></td>
                                <td>VP &amp; Cloud Architect, Tech Mahindra</td>
                                <td>Industry Member</td>
                                <td>2025–2026</td>
                            </tr>
                            <tr>
                                <td><strong>Ms. Riddhi Mehta</strong></td>
                                <td>Staff Security Engineer, Sophos Technologies</td>
                                <td>Industry Member</td>
                                <td>2025–2026</td>
                            </tr>
                            <tr>
                                <td><strong>Prof. N. M. Prajapati</strong></td>
                                <td>Associate Professor, Information Technology, GEC Modasa</td>
                                <td>Member Secretary</td>
                                <td>2025–2026</td>
                            </tr>
                            <tr>
                                <td><strong>Mr. Hiren Soni</strong></td>
                                <td>Director of Technology, Cybage Software</td>
                                <td>Industry Member</td>
                                <td>2023–2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- TAB 8: NEWSLETTERS -->
            <section class="us-tab-pane" id="tab-newsletters">
                <div class="us-section-header">
                    <span class="us-section-kicker">DEPARTMENT CHRONICLE</span>
                    <h2>Department Newsletters</h2>
                    <p>Official periodical chronicling faculty achievements, hackathon medals, student technical projects, and alumni career updates.</p>
                </div>

                <div class="us-periodical-grid">
                    <div class="us-periodical-card">
                        <div class="us-periodical-body">
                            <span class="us-periodical-meta">Vol. 1, Issue 2 · Academic Year 2024–25</span>
                            <h4 class="us-periodical-title">InfoTech Pulse</h4>
                            <p class="us-periodical-summary">Showcases winners of the 2024 WebSprint Hackathon, technical guest lectures on Generative AI, cloud certifications achieved by students, and faculty journal publications.</p>
                            <a href="#" class="us-download-btn"><i class="fas fa-file-pdf"></i> Download Newsletter (PDF)</a>
                        </div>
                    </div>

                    <div class="us-periodical-card">
                        <div class="us-periodical-body">
                            <span class="us-periodical-meta">Vol. 1, Issue 1 · Academic Year 2023–24</span>
                            <h4 class="us-periodical-title">InfoTech Pulse (Inaugural Issue)</h4>
                            <p class="us-periodical-summary">Inaugural release highlighting laboratory network upgrades, industrial visits to BISAG-N and GIFT City, student placement statistics, and alumni career stories.</p>
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
