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
                        <button type="button" class="dept-subnav-link" role="tab" aria-selected="false">Faculty</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" role="tab" aria-selected="false">Activities</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="facilities" role="tab" aria-selected="false">Facilities &amp; Labs</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="publications" role="tab" aria-selected="false">Publications</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" role="tab" aria-selected="false">Advisory Board</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" role="tab" aria-selected="false">Newsletters</button>
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
            </section>

            <!-- Tab 6: Faculty publications -->
            <section class="dept-tab-pane" id="tab-publications">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">SCHOLARLY OUTPUT</span>
                    <h2>Faculty Publications</h2>
                    <p>Research contributions, journal articles, and conference proceedings published by Computer Engineering faculty and research scholars.</p>
                </div>

                <!-- Publications Filter Toolbar -->
                <div class="dept-pub-toolbar">
                    <div class="dept-pub-filter-wrap">
                        <label for="pubYearFilter" class="dept-pub-filter-label">
                            <i class="fas fa-calendar-alt"></i> Filter by Year:
                        </label>
                        <div class="dept-pub-select-box">
                            <select id="pubYearFilter" class="dept-pub-select" aria-label="Filter publications by year" onchange="window.filterPublicationsByYear && window.filterPublicationsByYear(this.value)">
                                <option value="all">All Years (153)</option>
                                <option value="2026">2026 (3)</option>
                                <option value="2025">2025 (7)</option>
                                <option value="2024">2024 (9)</option>
                                <option value="2023">2023 (7)</option>
                                <option value="2022">2022 (9)</option>
                                <option value="2021">2021 (4)</option>
                                <option value="2020">2020 (1)</option>
                                <option value="2019">2019 (3)</option>
                                <option value="2018">2018 (3)</option>
                                <option value="2017">2017 (13)</option>
                                <option value="2016">2016 (12)</option>
                                <option value="2015">2015 (13)</option>
                                <option value="2014">2014 (12)</option>
                                <option value="2013">2013 (16)</option>
                                <option value="2012">2012 (29)</option>
                                <option value="2011">2011 (2)</option>
                                <option value="2010">2010 (4)</option>
                                <option value="2009">2009 (5)</option>
                                <option value="2008">2008 (1)</option>
                            </select>
                            <i class="fas fa-chevron-down dept-pub-arrow"></i>
                        </div>
                    </div>
                    <div class="dept-pub-badge" id="pubCountBadge">
                        Showing <strong>153</strong> publications
                    </div>
                </div>

                <div class="dept-citations-list">
                    <!-- Empty filter state notice -->
                    <div class="dept-pub-empty" id="pubEmptyState">
                        <i class="far fa-folder-open"></i>
                        No publications found for the selected year.
                    </div>

                    <!-- Publication 1 -->
                    <div class="dept-citation-item" data-year="2024">
                        <h3 class="dept-citation-title">Crowd Emotion and Behavior Analysis Using Lightweight CNN Model</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jignesh Vaniya, Safvan Vahora, Uttam Chauhan, Sudhir Vegad</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2024</span>
                        </div>
                    </div>

                    <!-- Publication 2 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">A Peculiar Sentiment Analysis Advancement in Big Data</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera, Yash Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2017</span>
                        </div>
                    </div>

                    <!-- Publication 3 -->
                    <div class="dept-citation-item" data-year="2018">
                        <h3 class="dept-citation-title">An avant-garde approach of Block chain in Big data analytics</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera, Parth Patel, Shruti Chettiar</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2018</span>
                        </div>
                    </div>

                    <!-- Publication 4 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">The Descriptive Study of Preprocessing from Web Usage Mining</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2012</span>
                        </div>
                    </div>

                    <!-- Publication 5 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Low Control Overhead for Cluster Maintenance in Wireless Network for DSR Protocol</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Goriya, Indrjeet Rajput, Mihir Mehta</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2015</span>
                        </div>
                    </div>

                    <!-- Publication 6 -->
                    <div class="dept-citation-item" data-year="2025">
                        <h3 class="dept-citation-title">Abstractive Gujarati Text Summarization Using Sequence-To-Sequence Model and Attention Mechanism</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Shilpa Serasiya, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2025</span>
                        </div>
                    </div>

                    <!-- Publication 7 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">A Neoteric Web Recommender System based on Approach of Mining Frequent Sequential Pattern from Customized Web Log Preprocessing</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2013</span>
                        </div>
                    </div>

                    <!-- Publication 8 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">Image Encryption Using Chaotic Based Artificial Neural Network</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Minal Chauhan, Rashmin Prajapati</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2014</span>
                        </div>
                    </div>

                    <!-- Publication 9 -->
                    <div class="dept-citation-item" data-year="2018">
                        <h3 class="dept-citation-title">Blazing issues in big data</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera, Yash Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2018</span>
                        </div>
                    </div>

                    <!-- Publication 10 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">AN EXHAUSTIVE STUDY: BIG DATA</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2016</span>
                        </div>
                    </div>

                    <!-- Publication 11 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">An efficient web recommender system based on approach of mining frequent sequential pattern from Customized Web Log Preprocessing</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2013</span>
                        </div>
                    </div>

                    <!-- Publication 12 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Object Removal using Image Inpainting</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Patel Hemangini Gamanbhai, Narenda Limbad</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2015</span>
                        </div>
                    </div>

                    <!-- Publication 13 -->
                    <div class="dept-citation-item" data-year="2025">
                        <h3 class="dept-citation-title">A Comprehensive Survey on Text Summarization For Indian Languages: Opportunities, Challenges and Future Prospects</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Shilpa Serasiya, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2025</span>
                        </div>
                    </div>

                    <!-- Publication 14 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">A Survey Paper on Cluster Head Selection Techniques for Mobile Ad-Hoc Network</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Goriya</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2014</span>
                        </div>
                    </div>

                    <!-- Publication 15 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">A Step up in Data Cleaning and User identification of Preprocessing on Web Usage data</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera, Shaktisinh Parmar</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2014</span>
                        </div>
                    </div>

                    <!-- Publication 16 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Radical Change through E-Governance in Gujarat</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Goriya, Indrjeet Rajput, Mihir Mehta</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i>  2015</span>
                        </div>
                    </div>

                    <!-- Publication 17 -->
                    <div class="dept-citation-item" data-year="2026">
                        <h3 class="dept-citation-title">Enhancing Semantic Coherence in Gujarati Topic Models by Eliminating Poor Quality Topics</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Nakul Dave, Avani Dave, Vishwa Kachhadiya, Priyanshi Chavadiya, Megh Dobariya, Ravi Nai, Diti Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2026</span>
                        </div>
                    </div>

                    <!-- Publication 18 -->
                    <div class="dept-citation-item" data-year="2026">
                        <h3 class="dept-citation-title">Parkinson's Disease Detection Using Keystroke Dynamics And With Convolutional Neural Networks</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Bhumiben Mukeshbhai Gentiyal, Safvan A. Vahora, Pradeep Rohitbhai Gamit, Mahendra N Patel, Hirenkumar Ramanbhai Patel, Mahesh Goyani, Uttam Chauhan, Pinal J. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2026</span>
                        </div>
                    </div>

                    <!-- Publication 19 -->
                    <div class="dept-citation-item" data-year="2026">
                        <h3 class="dept-citation-title">Multi-Stage Diabetic Retinopathy Classification Using Deep Learning: Trends, Challenges, And Future Directions</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Shreya Dubey, Mahesh Goyani, Mahendrakumar N Patel, Pinal J. Patel, Safvan A. Vahora, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2026</span>
                        </div>
                    </div>

                    <!-- 20 -->
                    <div class="dept-citation-item" data-year="2025">
                        <h3 class="dept-citation-title">Deepfake detection Demodulate Synthetic Videos Using Deep Learning Models</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Priyanshu Hirpara, Hardi Valangar, Vishwa Kachhadiya, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2025</span>
                        </div>
                    </div>

                    <!-- 21 -->
                    <div class="dept-citation-item" data-year="2025">
                        <h3 class="dept-citation-title">HyViSE: (Hybrid ViT-SE) Approach for Crowd Anomaly Detection and Emotion-Behavior Classification</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jignesh Vaniya, Safvan Vahora, Uttam Chauhan, Sudhir Vegad</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2025</span>
                        </div>
                    </div>

                    <!-- 22 -->
                    <div class="dept-citation-item" data-year="2025">
                        <h3 class="dept-citation-title">Conceptual Study On Various ML Models Used in Financial Distress Prediction</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Janki Patel, Pinal Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2025</span>
                        </div>
                    </div>

                    <!-- 23 -->
                    <div class="dept-citation-item" data-year="2025">
                        <h3 class="dept-citation-title">An outlier detection framework for Air Quality Index prediction using linear and ensemble models</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Viral Patel, Pradeep Kumar Dongre, Upendra Bhoi, Nilesh N. Maltare</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2025</span>
                        </div>
                    </div>

                    <!-- 24 -->
                    <div class="dept-citation-item" data-year="2025">
                        <h3 class="dept-citation-title">A Study on Packet Filtering and Network Traffic Management on Linux</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jogin Joshi, Pinal J. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2025</span>
                        </div>
                    </div>

                    <!-- 25 -->
                    <div class="dept-citation-item" data-year="2024">
                        <h3 class="dept-citation-title">Securing E-Commerce: A Comprehensive Analysis of Fraud Detection Methods</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Rushi Parikh, Krupa Bhavsar, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 26 -->
                    <div class="dept-citation-item" data-year="2024">
                        <h3 class="dept-citation-title">Performance Evaluation of Text Summarization Models on SAMSUM Chat Data</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jitendra Bhatia, Dip Patel, Jalpan Patel, Malaram Kumhar, Uttam Chauhan, Harshal Trivedi, Sudeep Tanwar</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 27 -->
                    <div class="dept-citation-item" data-year="2024">
                        <h3 class="dept-citation-title">Personalized Features-Based Stress Detection With Hyperparameter Tuning Using Genetic Algorithm</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jigna Jadav, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 28 -->
                    <div class="dept-citation-item" data-year="2024">
                        <h3 class="dept-citation-title">An Evolutionary Amharic Fake News Detection Based on ML and Deep Learning Approach</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Abirham Ayenew, Uttam Chauhan, Avani N Dave, Jaimin M Shroff, Nakul R Dave, Jigna J Jadav, Amit H Rathod</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 29 -->
                    <div class="dept-citation-item" data-year="2024">
                        <h3 class="dept-citation-title">Analysis Of Personalized Stress Recognition In The Office Environment</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jigna Jadav, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 30 -->
                    <div class="dept-citation-item" data-year="2024">
                        <h3 class="dept-citation-title">Heart Rate Variability Based LSTM Model for Stress Detection with Explainable AI Insights</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jigna Jadav, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 31 -->
                    <div class="dept-citation-item" data-year="2024">
                        <h3 class="dept-citation-title">AN ASSESSMENT OF MACHINE LEARNING AND ENSEMBLE MODELS FOR DIABETES PREDICTION</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Dr. Pinal J. Patel, Prof. Priyank Shah, Prof. Rutu Nayak, Prof. Hemangini Shukla, Prof. Chintan Shah, Prof. Navdeepsinh Limbad, Mr. Aayush Kukadiya</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 32 -->
                    <div class="dept-citation-item" data-year="2024">
                        <h3 class="dept-citation-title">HANDWRITTEN GUJARATI VOWEL RECOGNITION USING DEEP LEARNING MODELS</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Dr. Pinal J. Patel, Ms. Dhruvi Aacharya, Prof. Priyank Shah, Prof. Rutu Nayak, Prof. Chintan Shah, Prof. Jignasha Prajapati, Prof. Navdeepsinh Limbad</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- 33 -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">Chatbot For Academic Institutions</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Heeya Amin, Uttam Chauhan, Sahil Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 34 -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">The Content Based Misinformation Detection for Gujarati Language</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Vinay Sheth, Vishvesh Trivedi, Chintan Bhatt, Juan Manuel Corchado</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 35 -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">Amharic Language Hate Speech Detection Using Machine Learning</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Abirham Ayenew, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 36 -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">Recommendation Systems: Types, Applications, and Challenges</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Dhruval Patel, Foram Patel, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 37 -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">Modeling Topics in DFA-Based Lemmatized Gujarati Text</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Shrusti Shah, Dharati Shiroya, Dipti Solanki, Zeel Patel, Jitendra Bhatia, Sudeep Tanwar, Ravi Sharma, Verdes Marina, Maria Simona Raboaca</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 38 -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">Performance analysis of deep learning algorithms for classifying chronic obstructive pulmonary disease</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal J. Patel, Dhanashree Yevle, Daksha Diwan, Shashi Ranga, Kinjal Gandhi, Samay Dumasia, Rutu Nayak</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 39 -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">Multi feature fusion for COPD classification using Deep Learning algorithms</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal J. Patel, Daksha Diwan, Shashi Ranga, Niral J. Modi, Samay Dumasia</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- 40 -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">IoT Based Scalable Framework for Pollution Aware Route Recommendation</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Radha Govani, Parth Kakadia, Yash Modi, Dhrumin Thakkar, Heta Bhayani, Meshwa Patel, Jitendra Bhatia, Uttam Chauhan, Abdulatif Alabdulatif</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 41 -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">Abstractive Text Summarization For Indian Regional Languages: A Survey</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Shilpa Serasiya, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 42 -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">An Overview of Fog Data Analytics for IoT Applications</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jitendra Bhatia, Kiran Italiya, Kuldeepsinh Jadeja, Malaram Kumhar, Uttam Chauhan, Sudeep Tanwar, Madhuri Bhavsar, Ravi Sharma, Daniela Lucia Manea, Marina Verdes, Maria Simona Raboaca</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 43 -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">5G-enabled deep learning-based framework for healthcare mining State of the art and challenges</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Rahil Parmar, Naitik Panchal, Dhruval Patel, Uttam Chauhan, Jitendra Bhatia</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 44 -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">Plant Disease Detection using Deep Learning</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal J. Patel, Niyati Pandya, Manisha Chaudhari, Kinjal Gandhi, Hardik Mahendrabhai Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 45 -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">Alzheimer Disease Detection using Deep Learning</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Dr. Pinal J. Patel, Ms. Mohini H. Patel, Prof. Kinjal Gandhi, Dr. Shashi V. Ranga</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 46 -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">Offline Handwritten Character Recognition of Gujarati Characters using Convolutional Neural Network</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal J. Patel, S. Kheni Rukhmani, Urmila Patel, Darshil P. Patel, Kinjal N. Patel &amp; Kinjal A. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 47 -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">SIMULTANEOUS ESTIMATION OF NEBIVOLOL AND CILNIDIPINE IN PHARMACEUTICAL FORMULATIONBY REVERSE PHASE HIGH PERFORMANCE LIQUID CHROMATOGRAPHY METHOD</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal J. Patel, Drashti Mahendrabhai Patel, Meghal J. Patel, Manisha Chaudhari, Kinjal Gandhi, Shashi V. Ranga &amp; Hardik Mahendrabhai Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 48 -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">Fraud Detection in Credit Card Data using Unsupervised &amp; Supervised Machine Learning-Based Algorithms</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> PDF Prasanna Kumar Lakineni, Keyurkumar M Nayak, Harikumar Pallathadka, Kamal Gulati, Kapil Pandey, Pinal J. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- 49 -->
                    <div class="dept-citation-item" data-year="2021">
                        <h3 class="dept-citation-title">Coverless Information Hiding: A Review</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nitin Kanzariya, Gaurang Lakhani, Dhaval Jadhav, Uttam Chauhan, Lokesh Gagani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2021</span>
                        </div>
                    </div>

                    <!-- 50 -->
                    <div class="dept-citation-item" data-year="2021">
                        <h3 class="dept-citation-title">Topic Modeling Using Latent Dirichlet Allocation: A Survey</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Apurva Shah</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2021</span>
                        </div>
                    </div>

                    <!-- 51 -->
                    <div class="dept-citation-item" data-year="2021">
                        <h3 class="dept-citation-title">ResTS: Residual Deep Interpretable Architecture for Plant Disease Detection</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Dhruvil Shah, Vishvesh Trivedi, Vinay Sheth, Aakash Shah, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2021</span>
                        </div>
                    </div>

                    <!-- 52 -->
                    <div class="dept-citation-item" data-year="2021">
                        <h3 class="dept-citation-title">Improving Semantic Coherence of Gujarati Text Topic Model Using Inflectional Forms Reduction and Single-letter Words Removal</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Apurva Shah</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2021</span>
                        </div>
                    </div>

                    <!-- 53 -->
                    <div class="dept-citation-item" data-year="2020">
                        <h3 class="dept-citation-title">Ant Colony Optimization for Travelling Salesman Problem with Modified Pheromone Update Formula</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Rahil Parmar, Naitik Panchal, Dhruval Patel, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2020</span>
                        </div>
                    </div>

                    <!-- 54 -->
                    <div class="dept-citation-item" data-year="2019">
                        <h3 class="dept-citation-title">Advancement of Text Summarization Using Machine Learning and Deep Learning: A Review</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Rishi Kotadiya, Shivangi Bhatt, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2019</span>
                        </div>
                    </div>

                    <!-- 55 -->
                    <div class="dept-citation-item" data-year="2019">
                        <h3 class="dept-citation-title">A Survey on Architecture of Deep Convolution Neural Network</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Prachi Pandya, Pinal J. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2019</span>
                        </div>
                    </div>

                    <!-- 56 -->
                    <div class="dept-citation-item" data-year="2019">
                        <h3 class="dept-citation-title">Semi Supervised PU learning method for deceptive detection using MKNN</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Priyanka Patani, Pinal Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2019</span>
                        </div>
                    </div>

                    <!-- 57 -->
                    <div class="dept-citation-item" data-year="2018">
                        <h3 class="dept-citation-title">Review on Crop Yield Prediction using Data Mining Focusing on Groundnut Crop and Naive Bayes Technique</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Haresh L. Siju, Pinal J. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2018</span>
                        </div>
                    </div>

                    <!-- 58 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Biclustering of web usage data using Genetic Algorithm</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mayuree Rathva</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- 59 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Speech based Watermark relational databases</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mayuree Rathva</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- 60 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Hybrid Approach for Data Denoising on Image Segmentation</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Minal Chauhan, Binal Bhatt</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- 61 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Solar power forecasting : Analysis of trends in modeling techniques and error minimization</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Archana Gondalia</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- 62 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">AON: A Survey on Emergency Communication Systems during a Catastrophic Disaster</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Vasani Yash Kishorbhai, Nagekar Nainesh Vasantbhai</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- 63 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">The Architecture for Optimizing Semantic Topical Coherence in Gujarati Text Topic Modeling</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Apurva Shah, Uday Yadav</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- 64 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">A Survey - Sophisticated Topic Modeling</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Apurva Shah, Uday Yadav</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- 65 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Performance analysis of neural networks for intrusion detection system</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal J. Patel, J.S.Shah and Jinul Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- 66 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">SOFTWARE MAINTENANCE</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Ketan Sangadiya and Pinal Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- 67 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Intrusion detection system using BackPropagation Neural Network</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal Patel, Dr. J.S.Shah</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- 68 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">RMMM: A SURVEY</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Krishna Dilip Suchak, pinal patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- 69 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">A COMPARATIVE STUDY ON INTERNAL &amp; EXTERNAL QUALITY FOR SOFTWARE PROJECT</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Komal Prajapati, Pinal Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- 70 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">A Survey on Node Scheduling Methods for Wireless Sensor Network</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Neha Patel, Shweta Singh</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- 71 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">A Survey on Techniques for Collision Avoidance in VANET</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Neha Patel, Shweta Singh</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- 72 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">A survey on big data uding cloud storage</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Binal Bhatt, Minal Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- 73 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">A Review: Big Data Analysis Framework</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Apurva Shah, Uday Yadav, Mahendra Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- 74 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">Big data solutions and big data vendor’s comparison</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Prof. M.B.Chaudhary, Pianl Patel, Samarth Modi</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- 75 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">CLOUD PLATFORMS AND SIMULATORS: A COMPARATIVE STUDY</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal Patel, Umang Surani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- 76 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">Weather Prediction using Machine Learning: A Survey</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal Patel, Jyoti Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- 77 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">comparative study of the routing protocol approaches in (DTN) Delay Tolerant Network</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Sweety Patel, Prof. M.B.1chaudhary, Pinal Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- 78 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">Hierarchical Query Task Clustering using Search Logs</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Vivek Bhojawala, Pinal Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- 79 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">A Brief Survey of Face Recognition Techniques</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal Patel, Nilam Goswami</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- 80 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">Search Logs Mining: Survey</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Vivek Bhojawala, Pinal Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- 81 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Performance Enhancement of Facial Expression Recognition using Appearance based features</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jaimini Suthar, Goyani Mahesh</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- 82 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">A Review on AODV Routing Protocol over Simulation Environment</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Neha Patel, Vijay Reshmwala</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- 83 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">A Comparison Analysis of AODV and DSR Protocol over Energy Efficiency</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Neha Patel, Vijay Reshmwala, Shweta Singh</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- 84 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">A Survey on Data Mining Techniques for Crime Hotspots Prediction</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Neha Patel, Shivani.V.Vora</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- 85 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">A Survey on Natural Language Query Processing and Semantic Image Search</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Rashmi Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- 86 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Object Removal using Image Inpainting</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Patel Hemangini Gamanbhai, Narenda Limbad</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- 87 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">GLIMPSE OF IMAGE RESTORATION TECHNIQUE – IMAGE INPAINTING</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nainesh V Nagekar, Prof. Jayesh Chaudhary</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- 88 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Web Page Data Extraction and Categorization Web Pages Using Rule Based Classification Algorithm</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nirav Prajapati, Ketan Modi, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- 89 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Clustering approach for Moving object detection from video sequence</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Parth V. Parekh, Prof. Pinal J. Patel, Shrikrishna Padalkar, Vaibhavi S. Ghariya</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- 90 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Wireless Video Streaming using ARM Processor</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Suresh Prasad, Pinal Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- 91 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">Min-Max Selection Sort Algorithm - Improved Version of Selection Sort</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Mohammad Chharchhodawala, Bhargav Mendapara</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2014</span>
                        </div>
                    </div>

                    <!-- 92 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">Comparison of SUMO and SiMTram for Indian Traffic Scenario Representation</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Viral Patel, Manish Chaturvedi and Sanjay Srivastava</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2014</span>
                        </div>
                    </div>

                    <!-- 93 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">Green Cloud Computing: An Overview</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Archana Gondalia</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2014</span>
                        </div>
                    </div>

                    <!-- 94 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">Comparative Analysis of Dynamic Source Routing Protocol with Mobility and without Mobility</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Goriya, Parth Wadhwa, Mukti Pathak</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2014</span>
                        </div>
                    </div>

                    <!-- 95 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">A Comparative analysis for accuracy and size of pruned and unpruned decision tree inducted for various datasets</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Uday Yadav, Nakul Dave</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2014</span>
                        </div>
                    </div>

                    <!-- 96 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">Comprehensive study on Machine Learning Techniques for IDS in Cloud Computing</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pinal Patel, Dr. J. S. Shah, Meghal Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2014</span>
                        </div>
                    </div>

                    <!-- 97 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">Detection and prevention zero-day attack in honeypot system for virtualization</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Ankit Patel, Pinal Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2014</span>
                        </div>
                    </div>

                    <!-- 98 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">Corporate Governance and financial performance</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Gaurang Patel, Pinal Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2014</span>
                        </div>
                    </div>

                    <!-- 99 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">A literature survey on Facial Expression Recognition using Global Features</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Vaibhavkumar J. Mistry, Mahesh M. Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- 100 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">Comparison of different image retrieval techniques in CBIR</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Chauhan Nandish, Mahesh Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- 101 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">Facial Expression Recognition using Gabor Filter by minimizing Feature Vector</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Vaibhavkumar J. Mistry, Mahesh M. Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- 102 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">Enhanced Multistage Content Based Image Retrieval</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nandish Chauhan, Mahesh Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- 103 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">Handwritten Character Recognition - A Comprehensive Review</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Harsh Dani, Chahna Dixit</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- 104 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">A Novel Approach as Multi-place Watermarking for security in Database</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mayuree Rathva</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- 105 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">An Efficient Web Recommender System based on Approach of Mining Frequent Sequential Pattern from Customized Web Log</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera, Uttam Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- 106 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">Reducing Avarage Waiting Time for Processes in Distributed System Using Dynamic Priority and Multiple Token Algorithm</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Ami Patel, Uttam Chauhan, Sanjay Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- 107 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">Text Based Fuzzy Clustering Algorithm to Filter Spam E- mail</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nakul Dave, Uttam Chauhan, Avani Nakul Dave</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- 108 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">A Neoteric Web Recommender System based on Approach of Mining Frequent Sequential Pattern from Customized Web Log Preprocessing</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera, Uttam Chauhan, Kirit Rathod</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- 109 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">Panoramic Image Mosaicing</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mrs. Hetal M.Patel, Prof. Pinal. J. Patel, Prof. Mr. Sandip G. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- 110 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">A Secure Cloud using Homomorphic Encryption Scheme</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Ms. Parin V. Patel, Mr. Hitesh D. Patel, Prof. Pinal J. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- 111 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">Cancer Detection Using Modified Watershed</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Shanti L. Kadachha, Pinal J. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- 112 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Performance Analysis of FDA Based Face Recognition Using Correlation, ANN and SVM</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Akash Dhorajiya, Ronak Paun</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 113 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Comparative Analysis Between DCT &amp; DWT Techniques of Image Compression</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Anil Kathrotiya, Swati Patel, Mahesh Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 114 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Key Frame Detection Based Semantic Event Detection and Classification Using Hierarchical Approach for Cricket Sport Video Indexing</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Shreyash Dutta, Payal Raj</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 115 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Performance Analysis of Block and Non Block Based Approach of Invisible Image Watermarking Using SVD in DCT Domain</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Gunvantsinh Gohil</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 116 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Geometry and Skin Color Based Hybrid Approach for Face Tracking in Color Environment</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Gitam Sikkenawis, Brijesh Joshi</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 117 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">A Review on Handwritten Character Recognition Systems</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Ravi Sheth, Narendra Chauhan, Mahesh Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 118 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Wicket fall Concept Mining From Cricket Video Using A-Priori Algorithm</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Shreyash Dutta, Gunvantsinh Gohil, Sapan Naik</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 119 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Handwritten Character Recognition System Using Correlation Coefficient</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Ravi Sheth, Narendra Chauhan, Mahesh Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 120 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Robust Face Recognition in Low Dimensional Subspace Using Reconstructive and Discriminative Features</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Gunvantsinh Gohil, Amit Chaudhari</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 121 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Top Down Hierarchical Histogram Based Approach for Printed Devanagari Script Character Isolation</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Trusha Gajjar, Rekha Teraiya, Gunvantsinh Gohil, Mahesh Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 122 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">A Detail Study of Digital Image Watermarking Techniques</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Swati Patel, Anil Kathrotiya, Mahesh Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 123 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">A Survey on Digital Video Watermarking</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Swati Patel, Anil Kathrotiya, Mahesh Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 124 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Chain Code Based Hand Written Character Recognition System Using Neural Network and Support Vector Machine</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Ravi Sheth, Narendra Chauhan, Mahesh Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 125 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">3D Face Recognition Techniques - A Review</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Preeti B. Sharma, Mahesh M. Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 126 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Chain code and holistic features based OCR system for printed Devanagari script using ANN and SVM</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Gunvantsinh Gohil, Rekha Teraiya and Mahesh Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 127 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Euler Number, Symmetry and Histogram Based Hierarchical Approach for English OCR</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh M Goyani, Rekha R Teraiya, Trusha Y Gajjar, Gunvantsinh D Gohil</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 128 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Comparision between DCT and DWT algorithms of Digital Watermarking</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Swati Patel, Anilkumar Katharotiya, Mahesh Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 129 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Face recognition using PCA and Modified PCA</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Preeti B. Sharma, Mahesh M. Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 130 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">A survey optimize visual image search for sematic web</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Jaimin MShroff, Prof. Bhaumik Nagar, Prof. Parth Shah</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 131 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">A review on sla and various approaches for efficient cloud service provider selection</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Shreyas Patel, Prof. Gordhan B. Jethava</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 132 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Host Selection Strategy Based On Propagation Delay in Cloud</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Dodiya Aniruddhsinh Karshanbhai</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 133 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Host Selection Technique for Data Intensive Application in Cloud Computing</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Dodiya Aniruddhsinh Karshanbhai</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 134 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Analysis of Multiple path TCP over Heterogeneous networks</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> P R Gamit</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 135 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Load Sharing Optimization of Multipath TCP in heterogeneous Networks</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> P R Gamit</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 136 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">An Adaptive Classification approach to filter spam E-mail using Vector Space Model</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nakul Dave, Uttam Chauhan, Avani Nakul Dave</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 137 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">A Review of spam filtering based on unstructured classification</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nakul Dave, Uttam Chauhan, Dhaval Varia</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 138 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Comprehensive study and review of image mosaicing methods</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mrs. Hetal M. Patel, Prof. Pinal. J. Patel, Prof. Mr. Sandip G. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 139 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Survey paper on Architecture of Deep Convolutional Network</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Prachi Pandya, Pinal J. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- 140 -->
                    <div class="dept-citation-item" data-year="2011">
                        <h3 class="dept-citation-title">PCA Based Handwritten Character Recognition System Using Support Vector Machine &amp; Neural Network</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Ravi Sheth, N C Chauhan, Mahesh M Goyani, Kinjal A Mehta</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2011</span>
                        </div>
                    </div>

                    <!-- 141 -->
                    <div class="dept-citation-item" data-year="2011">
                        <h3 class="dept-citation-title">An analysis and study of decision tree induction operating under adaptive mode to enhance accuracy and uptime in a dataset introduced to spontaneous variation in data attributes</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Y P Kosta, Amit Ganatra, Amit Thakkar</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2011</span>
                        </div>
                    </div>

                    <!-- 142 -->
                    <div class="dept-citation-item" data-year="2010">
                        <h3 class="dept-citation-title">Performance Enhancement in Lip Synchronization Using MFCC Parameters</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Narendra Patel, Mukesh Zaveri</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2010</span>
                        </div>
                    </div>

                    <!-- 143 -->
                    <div class="dept-citation-item" data-year="2010">
                        <h3 class="dept-citation-title">Acceptance / Rejection Rule Based Algorithm for Multiple Face Detection in Color Images</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Brijesh Joshi, Gitam Sikkenawis</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2010</span>
                        </div>
                    </div>

                    <!-- 144 -->
                    <div class="dept-citation-item" data-year="2010">
                        <h3 class="dept-citation-title">Performance Analysis of LPC, PLP and MFCC Parameters in Speech Recognition</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Namrata Dave</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2010</span>
                        </div>
                    </div>

                    <!-- 145 -->
                    <div class="dept-citation-item" data-year="2010">
                        <h3 class="dept-citation-title">Performance improvement in Lip Synchronization using LPC, MFCC and PLP Speech Parameters</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Namrata Dave, Narendra Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2010</span>
                        </div>
                    </div>

                    <!-- 146 -->
                    <div class="dept-citation-item" data-year="2009">
                        <h3 class="dept-citation-title">Real Time Lip Synchronization</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2009</span>
                        </div>
                    </div>

                    <!-- 147 -->
                    <div class="dept-citation-item" data-year="2009">
                        <h3 class="dept-citation-title">Improvement in Lip Detection and Feature Extraction in Dynamic Lighting Conditions and Complex Background</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Parul Tandel, Hetal Chudasama</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2009</span>
                        </div>
                    </div>

                    <!-- 148 -->
                    <div class="dept-citation-item" data-year="2009">
                        <h3 class="dept-citation-title">Ear Recognition Using Force Field Feature Extraction</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Japen Pathak</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2009</span>
                        </div>
                    </div>

                    <!-- 149 -->
                    <div class="dept-citation-item" data-year="2009">
                        <h3 class="dept-citation-title">Performance Analysis of LPC, PLP and MFCC Parameters in Speech Recognition</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Namrata Dave</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2009</span>
                        </div>
                    </div>

                    <!-- 150 -->
                    <div class="dept-citation-item" data-year="2009">
                        <h3 class="dept-citation-title">Classification Using Adaptive Decision Tree Induction Algorithm For accuracy and scale-up measure</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Uttam Chauhan, Amit Ganatra, Amit Thakkar</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2009</span>
                        </div>
                    </div>

                    <!-- 151 -->
                    <div class="dept-citation-item" data-year="2008">
                        <h3 class="dept-citation-title">Artificial Neural Network in Data Mining</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mahesh Goyani, Mukesh Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2008</span>
                        </div>
                    </div>

                    <!-- 152 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">Image Encryption Using Chaotic Cryptosystems and Artificial Neural Network Cryptosystems: A Review</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Minal Chauhan, Rashmin Prajapati</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> May-2014</span>
                        </div>
                    </div>

                    <!-- 153 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">A Novel Approach of Mining Frequent Sequential Pattern from Customized Web Log Preprocessing</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Manisha Valera</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> January - February 2013</span>
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
