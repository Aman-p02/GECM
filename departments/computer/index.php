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

<div class="dept-page">

    <!-- Hero header section -->
    <header class="dept-hero-banner">
        <div class="dept-container">
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

            <!-- Key metrics counter strip (separated by single thin 1px line, no boxes, no vertical dividers) -->
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
                            <p>Hardware engineers focus their skills on computer systems and physical components—designing microprocessors, circuit boards, routers, and embedded devices that power modern smart electronics.</p>
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
                            <li><strong>PSO 3:</strong> Apply concepts of core areas of Computer Engineering—Data Structures, Database Management Systems, Operating Systems, Computer Architecture and Software Engineering to provide innovative solution.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Tab 3: Faculty directory -->
            <section class="dept-tab-pane" id="tab-faculty">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">SCHOLARLY DIRECTORY</span>
                    <h2>Faculty Members</h2>
                    <p>Our distinguished academic roster of educators, researchers, and technical mentors dedicated to student mastery.</p>
                </div>

                <div class="dept-faculty-roster">
                    <div class="dept-faculty-card">
                        <div class="dept-faculty-initials">HP</div>
                        <h4 class="dept-faculty-name">Dr. H. M. Patel</h4>
                        <div class="dept-faculty-rank">Professor &amp; Head of Department</div>
                        <div class="dept-faculty-degrees">Ph.D., M.Tech (Computer Engineering)<br><small>Specialization: Cloud Security, Distributed Systems</small></div>
                        <a href="mailto:hod_ce@gecmodasa.ac.in" class="dept-faculty-contact">
                            <i class="fas fa-envelope"></i> hod_ce@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="dept-faculty-card">
                        <div class="dept-faculty-initials">AS</div>
                        <h4 class="dept-faculty-name">Prof. A. S. Shah</h4>
                        <div class="dept-faculty-rank">Associate Professor</div>
                        <div class="dept-faculty-degrees">Ph.D. (Pursuing), M.E. (Computer Engineering)<br><small>Specialization: IoT Security, Embedded Networks</small></div>
                        <a href="mailto:asshah@gecmodasa.ac.in" class="dept-faculty-contact">
                            <i class="fas fa-envelope"></i> asshah@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="dept-faculty-card">
                        <div class="dept-faculty-initials">RP</div>
                        <h4 class="dept-faculty-name">Prof. R. K. Prajapati</h4>
                        <div class="dept-faculty-rank">Assistant Professor</div>
                        <div class="dept-faculty-degrees">M.E. (Computer Science &amp; Engineering)<br><small>Specialization: Data Engineering, Cryptography</small></div>
                        <a href="mailto:rkprajapati@gecmodasa.ac.in" class="dept-faculty-contact">
                            <i class="fas fa-envelope"></i> rkprajapati@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="dept-faculty-card">
                        <div class="dept-faculty-initials">PM</div>
                        <h4 class="dept-faculty-name">Prof. P. N. Mehta</h4>
                        <div class="dept-faculty-rank">Assistant Professor</div>
                        <div class="dept-faculty-degrees">M.Tech (Software Engineering)<br><small>Specialization: Microservices, Web Architectures</small></div>
                        <a href="mailto:pnmehta@gecmodasa.ac.in" class="dept-faculty-contact">
                            <i class="fas fa-envelope"></i> pnmehta@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="dept-faculty-card">
                        <div class="dept-faculty-initials">SJ</div>
                        <h4 class="dept-faculty-name">Prof. S. D. Joshi</h4>
                        <div class="dept-faculty-rank">Assistant Professor</div>
                        <div class="dept-faculty-degrees">M.E. (Computer Engineering)<br><small>Specialization: Machine Learning, Neural Signals</small></div>
                        <a href="mailto:sdjoshi@gecmodasa.ac.in" class="dept-faculty-contact">
                            <i class="fas fa-envelope"></i> sdjoshi@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="dept-faculty-card">
                        <div class="dept-faculty-initials">MP</div>
                        <h4 class="dept-faculty-name">Prof. M. B. Patel</h4>
                        <div class="dept-faculty-rank">Assistant Professor</div>
                        <div class="dept-faculty-degrees">M.Tech (Information Technology)<br><small>Specialization: Mobile Systems, Data Mining</small></div>
                        <a href="mailto:mbpatel@gecmodasa.ac.in" class="dept-faculty-contact">
                            <i class="fas fa-envelope"></i> mbpatel@gecmodasa.ac.in
                        </a>
                    </div>
                </div>
            </section>

            <!-- Tab 4: Activities and events -->
            <section class="dept-tab-pane" id="tab-activities">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">CAMPUS ENGAGEMENT</span>
                    <h2>Department Activities</h2>
                    <p>Annual hackathons, industrial field tours, expert colloquia, and hands-on developer workshops.</p>
                </div>

                <div class="dept-periodical-grid">
                    <div class="dept-activity-card">
                        <h4>Annual CodeFest &amp; Hackathons</h4>
                        <p>24-hour technical coding sprints challenging student developers to solve real-world industrial and civic governance problems using full-stack frameworks and AI APIs.</p>
                    </div>
                    <div class="dept-activity-card">
                        <h4>Industry Masterclass Series</h4>
                        <p>Distinguished technical architects and engineering leaders deliver in-depth sessions on cloud infrastructure, container orchestration, and cybersecurity hygiene.</p>
                    </div>
                    <div class="dept-activity-card">
                        <h4>Industrial Research Visits</h4>
                        <p>Experiential tours to leading scientific centers including BISAG-N Gandhinagar, TCS Garima Park, and ISRO Space Applications Centre to observe production data centers.</p>
                    </div>
                    <div class="dept-activity-card">
                        <h4>Faculty Development Programs (FDP)</h4>
                        <p>GTU-sponsored short-term training programs on deep learning, internet of things, and advanced pedagogy conducted for regional engineering educators.</p>
                    </div>
                </div>
            </section>

            <!-- Tab 5: Laboratory facilities -->
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
            </section>

            <!-- Tab 6: Faculty publications -->
            <section class="dept-tab-pane" id="tab-publications">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">SCHOLARLY OUTPUT</span>
                    <h2>Faculty Publications</h2>
                    <p>Research contributions, journal articles, and conference proceedings published by Computer Engineering faculty and research scholars.</p>
                </div>

                <div class="dept-citations-list">
                    <!-- Publication 1 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Crowd Emotion and Behavior Analysis Using Lightweight CNN Model</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jignesh Vaniya, Safvan Vahora, Uttam Chauhan, Sudhir Vegad</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2024</span>
                        </div>
                    </div>

                    <!-- Publication 2 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">A Peculiar Sentiment Analysis Advancement in Big Data</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera, Yash Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2017</span>
                        </div>
                    </div>

                    <!-- Publication 3 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">An avant-garde approach of Block chain in Big data analytics</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera, Parth Patel, Shruti Chettiar</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2018</span>
                        </div>
                    </div>

                    <!-- Publication 4 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">The Descriptive Study of Preprocessing from Web Usage Mining</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2012</span>
                        </div>
                    </div>

                    <!-- Publication 5 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Low Control Overhead for Cluster Maintenance in Wireless Network for DSR Protocol</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Goriya, Indrjeet Rajput, Mihir Mehta</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2015</span>
                        </div>
                    </div>

                    <!-- Publication 6 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Abstractive Gujarati Text Summarization Using Sequence-To-Sequence Model and Attention Mechanism</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Shilpa Serasiya, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2025</span>
                        </div>
                    </div>

                    <!-- Publication 7 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">A Neoteric Web Recommender System based on Approach of Mining Frequent Sequential Pattern from Customized Web Log Preprocessing</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2013</span>
                        </div>
                    </div>

                    <!-- Publication 8 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Image Encryption Using Chaotic Based Artificial Neural Network</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Minal Chauhan, Rashmin Prajapati</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2014</span>
                        </div>
                    </div>

                    <!-- Publication 9 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Blazing issues in big data</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera, Yash Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2018</span>
                        </div>
                    </div>

                    <!-- Publication 10 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">AN EXHAUSTIVE STUDY: BIG DATA</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2016</span>
                        </div>
                    </div>

                    <!-- Publication 11 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">An efficient web recommender system based on approach of mining frequent sequential pattern from Customized Web Log Preprocessing</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2013</span>
                        </div>
                    </div>

                    <!-- Publication 12 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Object Removal using Image Inpainting</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Patel Hemangini Gamanbhai, Narenda Limbad</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2015</span>
                        </div>
                    </div>

                    <!-- Publication 13 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">A Comprehensive Survey on Text Summarization For Indian Languages: Opportunities, Challenges and Future Prospects</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Shilpa Serasiya, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2025</span>
                        </div>
                    </div>

                    <!-- Publication 14 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">A Survey Paper on Cluster Head Selection Techniques for Mobile Ad-Hoc Network</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Goriya</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2014</span>
                        </div>
                    </div>

                    <!-- Publication 15 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">A Step up in Data Cleaning and User identification of Preprocessing on Web Usage data</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera, Shaktisinh Parmar</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2014</span>
                        </div>
                    </div>

                    <!-- Publication 16 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Radical Change through E-Governance in Gujarat</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Goriya, Indrjeet Rajput, Mihir Mehta</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2015</span>
                        </div>
                    </div>

                    <!-- Publication 17 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Enhancing Semantic Coherence in Gujarati Topic Models by Eliminating Poor Quality Topics</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Nakul Dave, Avani Dave, Vishwa Kachhadiya, Priyanshi Chavadiya, Megh Dobariya, Ravi Nai, Diti Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2026</span>
                        </div>
                    </div>

                    <!-- Publication 18 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Parkinson's Disease Detection Using Keystroke Dynamics And With Convolutional Neural Networks</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Bhumiben Mukeshbhai Gentiyal, Safvan A. Vahora, Pradeep Rohitbhai Gamit, Mahendra N Patel, Hirenkumar Ramanbhai Patel, Mahesh Goyani, Uttam Chauhan, Pinal J. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2026</span>
                        </div>
                    </div>

                    <!-- Publication 19 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Multi-Stage Diabetic Retinopathy Classification Using Deep Learning: Trends, Challenges, And Future Directions</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Shreya Dubey, Mahesh Goyani, Mahendrakumar N Patel, Pinal J. Patel, Safvan A. Vahora, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2026</span>
                        </div>
                    </div>

                    <!-- 20 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Deepfake detection Demodulate Synthetic Videos Using Deep Learning Models</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Priyanshu Hirpara, Hardi Valangar, Vishwa Kachhadiya, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2025</span>
                        </div>
                    </div>

                    <!-- 21 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">HyViSE: (Hybrid ViT-SE) Approach for Crowd Anomaly Detection and Emotion-Behavior Classification</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jignesh Vaniya, Safvan Vahora, Uttam Chauhan, Sudhir Vegad</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2025</span>
                        </div>
                    </div>

                    <!-- 22 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Conceptual Study On Various ML Models Used in Financial Distress Prediction</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Janki Patel, Pinal Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2025</span>
                        </div>
                    </div>

                    <!-- 23 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">An outlier detection framework for Air Quality Index prediction using linear and ensemble models</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Viral Patel, Pradeep Kumar Dongre, Upendra Bhoi, Nilesh N. Maltare</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2025</span>
                        </div>
                    </div>

                    <!-- 24 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">A Study on Packet Filtering and Network Traffic Management on Linux</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jogin Joshi, Pinal J. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2025</span>
                        </div>
                    </div>

                    <!-- 25 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Securing E-Commerce: A Comprehensive Analysis of Fraud Detection Methods</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Rushi Parikh, Krupa Bhavsar, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 26 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Performance Evaluation of Text Summarization Models on SAMSUM Chat Data</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jitendra Bhatia, Dip Patel, Jalpan Patel, Malaram Kumhar, Uttam Chauhan, Harshal Trivedi, Sudeep Tanwar</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 27 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Personalized Features-Based Stress Detection With Hyperparameter Tuning Using Genetic Algorithm</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jigna Jadav, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 28 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">An Evolutionary Amharic Fake News Detection Based on ML and Deep Learning Approach</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Abirham Ayenew, Uttam Chauhan, Avani N Dave, Jaimin M Shroff, Nakul R Dave, Jigna J Jadav, Amit H Rathod</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 29 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Analysis Of Personalized Stress Recognition In The Office Environment</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jigna Jadav, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 30 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Heart Rate Variability Based LSTM Model for Stress Detection with Explainable AI Insights</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jigna Jadav, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 31 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">AN ASSESSMENT OF MACHINE LEARNING AND ENSEMBLE MODELS FOR DIABETES PREDICTION</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Dr. Pinal J. Patel, Prof. Priyank Shah, Prof. Rutu Nayak, Prof. Hemangini Shukla, Prof. Chintan Shah, Prof. Navdeepsinh Limbad, Mr. Aayush Kukadiya</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 32 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">HANDWRITTEN GUJARATI VOWEL RECOGNITION USING DEEP LEARNING MODELS</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Dr. Pinal J. Patel, Ms. Dhruvi Aacharya, Prof. Priyank Shah, Prof. Rutu Nayak, Prof. Chintan Shah, Prof. Jignasha Prajapati, Prof. Navdeepsinh Limbad</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 33 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Chatbot For Academic Institutions</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Heeya Amin, Uttam Chauhan, Sahil Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 34 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">The Content Based Misinformation Detection for Gujarati Language</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Vinay Sheth, Vishvesh Trivedi, Chintan Bhatt, Juan Manuel Corchado</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 35 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Amharic Language Hate Speech Detection Using Machine Learning</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Abirham Ayenew, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 36 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Recommendation Systems: Types, Applications, and Challenges</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Dhruval Patel, Foram Patel, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 37 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Modeling Topics in DFA-Based Lemmatized Gujarati Text</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Shrusti Shah, Dharati Shiroya, Dipti Solanki, Zeel Patel, Jitendra Bhatia, Sudeep Tanwar, Ravi Sharma, Verdes Marina, Maria Simona Raboaca</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 38 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Performance analysis of deep learning algorithms for classifying chronic obstructive pulmonary disease</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal J. Patel, Dhanashree Yevle, Daksha Diwan, Shashi Ranga, Kinjal Gandhi, Samay Dumasia, Rutu Nayak</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 39 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Multi feature fusion for COPD classification using Deep Learning algorithms</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal J. Patel, Daksha Diwan, Shashi Ranga, Niral J. Modi, Samay Dumasia</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 40 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">IoT Based Scalable Framework for Pollution Aware Route Recommendation</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Radha Govani, Parth Kakadia, Yash Modi, Dhrumin Thakkar, Heta Bhayani, Meshwa Patel, Jitendra Bhatia, Uttam Chauhan, Abdulatif Alabdulatif</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 41 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Abstractive Text Summarization For Indian Regional Languages: A Survey</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Shilpa Serasiya, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 42 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">An Overview of Fog Data Analytics for IoT Applications</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jitendra Bhatia, Kiran Italiya, Kuldeepsinh Jadeja, Malaram Kumhar, Uttam Chauhan, Sudeep Tanwar, Madhuri Bhavsar, Ravi Sharma, Daniela Lucia Manea, Marina Verdes, Maria Simona Raboaca</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 43 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">5G-enabled deep learning-based framework for healthcare mining State of the art and challenges</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Rahil Parmar, Naitik Panchal, Dhruval Patel, Uttam Chauhan, Jitendra Bhatia</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 44 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Plant Disease Detection using Deep Learning</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal J. Patel, Niyati Pandya, Manisha Chaudhari, Kinjal Gandhi, Hardik Mahendrabhai Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 45 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Alzheimer Disease Detection using Deep Learning</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Dr. Pinal J. Patel, Ms. Mohini H. Patel, Prof. Kinjal Gandhi, Dr. Shashi V. Ranga</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 46 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Offline Handwritten Character Recognition of Gujarati Characters using Convolutional Neural Network</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal J. Patel, S. Kheni Rukhmani, Urmila Patel, Darshil P. Patel, Kinjal N. Patel &amp; Kinjal A. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 47 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">SIMULTANEOUS ESTIMATION OF NEBIVOLOL AND CILNIDIPINE IN PHARMACEUTICAL FORMULATIONBY REVERSE PHASE HIGH PERFORMANCE LIQUID CHROMATOGRAPHY METHOD</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal J. Patel, Drashti Mahendrabhai Patel, Meghal J. Patel, Manisha Chaudhari, Kinjal Gandhi, Shashi V. Ranga &amp; Hardik Mahendrabhai Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 48 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Fraud Detection in Credit Card Data using Unsupervised &amp; Supervised Machine Learning-Based Algorithms</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> PDF Prasanna Kumar Lakineni, Keyurkumar M Nayak, Harikumar Pallathadka, Kamal Gulati, Kapil Pandey, Pinal J. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 49 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Coverless Information Hiding: A Review</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nitin Kanzariya, Gaurang Lakhani, Dhaval Jadhav, Uttam Chauhan, Lokesh Gagani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2021</span>
                        </div>
                    </div>

                    <!-- 50 -->
                    <div class="dept-citation-item">
                        <h3 class="dept-citation-title">Topic Modeling Using Latent Dirichlet Allocation: A Survey</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Apurva Shah</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2021</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 7: Industry Advisory Board -->
            <section class="dept-tab-pane" id="tab-advisory-board">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">GOVERNANCE &amp; CURRICULUM</span>
                    <h2>Industry Advisory Board (IAB)</h2>
                    <p>Distinguished technical directors, senior architects, and researchers actively steering academic relevance and recruitment readiness.</p>
                </div>

                <div class="dept-table-wrap">
                    <table class="dept-clean-table">
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
            <section class="dept-tab-pane" id="tab-newsletters">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">DEPARTMENT CHRONICLE</span>
                    <h2>Department Newsletters</h2>
                    <p>Official periodic publications recording student victories, research grants, faculty honors, and alumni spotlights.</p>
                </div>

                <div class="dept-periodical-grid">
                    <div class="dept-periodical-card">
                        <div class="dept-periodical-body">
                            <span class="dept-periodical-meta">Vol. 1, Issue 2 · Academic Year 2024–25</span>
                            <h4 class="dept-periodical-title">CompTech Chronicle</h4>
                            <p class="dept-periodical-summary">Features comprehensive recaps of CodeFest 2024, expert lectures by cloud architects, national hackathon podium finishes, and recent faculty IEEE publications.</p>
                            <a href="#" class="dept-download-btn"><i class="fas fa-file-pdf"></i> Download Newsletter (PDF)</a>
                        </div>
                    </div>

                    <div class="dept-periodical-card">
                        <div class="dept-periodical-body">
                            <span class="dept-periodical-meta">Vol. 1, Issue 1 · Academic Year 2023–24</span>
                            <h4 class="dept-periodical-title">CompTech Chronicle (Inaugural Issue)</h4>
                            <p class="dept-periodical-summary">Inaugural release highlighting the AICTE laboratory modernization grant, establishment of new computational clusters, and alumni career milestones in global tech firms.</p>
                            <a href="#" class="dept-download-btn"><i class="fas fa-file-pdf"></i> Download Newsletter (PDF)</a>
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
