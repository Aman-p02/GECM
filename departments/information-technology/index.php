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

<div class="dept-page">

    <!-- Hero header section -->
    <header class="dept-hero-banner">
        <div class="dept-container">
            <!-- Two-column hero grid (7 cols left, 5 cols right) -->
            <div class="dept-hero-grid">
                <div class="dept-hero-text">
                    <span class="dept-kicker">DEPARTMENT OF</span>
                    <h1 class="dept-heading">Information Technology</h1>
                    <p class="dept-tagline">
                        Empowering next-generation IT professionals through technical innovation, software engineering, network administration, and hands-on laboratory learning since 1999.
                    </p>
                </div>
                <div class="dept-hero-media">
                    <img src="images/department_building.jpg" alt="Government Engineering College Modasa - Computer and Information Technology Department Building" class="dept-hero-photo">
                </div>
            </div>

            <!-- Key metrics counter strip -->
            <div class="dept-stats-strip">
                <div class="dept-stat-item">
                    <span class="dept-stat-num">1999</span>
                    <span class="dept-stat-label">YEAR OF ESTABLISHMENT</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">120</span>
                    <span class="dept-stat-label">ANNUAL APPROVED INTAKE</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">10</span>
                    <span class="dept-stat-label">SPECIALIZED LABS &amp; HALLS</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">15</span>
                    <span class="dept-stat-label">FACULTY MEMBERS</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Sticky sub-navigation bar -->
    <nav class="dept-subnav-bar" id="deptSubNav" aria-label="Department Navigation">
        <div class="dept-container">
            <div class="dept-subnav-wrapper">
                <ul class="dept-subnav-list" role="tablist">
                    <li class="dept-subnav-item active">
                        <button type="button" class="dept-subnav-link active" data-tab="about" role="tab" aria-selected="true">About</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="vision-mission" role="tab" aria-selected="false">Vision &amp; Mission</button>
                    </li>
                    <li class="dept-subnav-item">
                        <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="dept-subnav-link" aria-label="GTU Syllabus Portal">
                            <span>Syllabus</span>
                            <i class="fas fa-external-link-alt dept-ext-icon"></i>
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
                    <p>Pioneering software engineering, network administration, and laboratory discovery at Government Engineering College, Modasa since 1999.</p>
                </div>

                <div class="dept-story-body">
                    <blockquote class="dept-lead-quote">
                        "Equipping future IT leaders with core engineering foundations, robust networking acumen, and industry-aligned software design expertise."
                    </blockquote>
                    <p>
                        This department is running since 1999. The staff has developed required laboratories in the areas like Computer Hardware, Computer Networking &amp; Security, Database Management System, Computer Graphics and Internet Technology in tune with real-time systems. The IT Department is equipped with around 100+ computers with multimedia software and LAN Systems with Internet connection.
                    </p>
                    <p>
                        The internet access is provided to the students to update their knowledge in the various fields. The campus-wide area network is managed through this department.
                    </p>
                    <p>
                        Computer Engineering and Information Technology department run in a newly constructed, well-furnished building. The main strength of the department is highly qualified and well-experienced faculties. Also, the department is well equipped with an ample number of computer systems, networking of more than 250 nodes and required software and hardware. Department has well equipped 10 computer laboratories and two seminar halls. Campus Wide Network of college is handled by the department with 30 Wi-Fi access points with 1 controller. It has High-End Servers available for various activities.
                    </p>
                </div>

                <!-- About the Programme Section -->
                <div class="dept-programme-section">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">DISCIPLINE &amp; CAREER PATHS</span>
                        <h2>About the Programme</h2>
                        <p>Integrating computer science, telecommunications, and software systems to develop robust, secure, and scalable information networks.</p>
                    </div>

                    <p class="dept-programme-lead">
                        The field of information technology (IT) covers the design, administration and support of computer and telecommunications systems. Professionals in the IT field work with businesses and organizations to set up and support viable computer networks that will keep systems efficient and reliable. At the professional level, the discipline offers vital career avenues:
                    </p>

                    <div class="dept-avenues-grid">
                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-network-wired"></i></div>
                                <h4>Network &amp; Security Engineering</h4>
                            </div>
                            <p>Design, secure, and administer enterprise computer networks, telecommunications frameworks, cloud architectures, firewalls, and IoT infrastructure.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-laptop-code"></i></div>
                                <h4>Software &amp; Web Systems</h4>
                            </div>
                            <p>Develop, test, and deploy database-driven web applications, modern RESTful APIs, cloud microservices, and mobile software systems using open-source technologies.</p>
                        </div>
                    </div>

                    <div class="dept-story-body">
                        <p>
                            Aspiring IT professionals typically need a bachelor's degree in a technology field, such as computer science, information systems management, programming or networking. Even without a degree, experience in an entry-level help desk position could help IT professionals advance with professional certification or vocational training. The fundamentals of a degree program generally include computer hardware, programming, networking, and technical theory. Depending on the major, students also learn IT management, website development, computer circuitry, systems analysis, and database management. Some programs also include internship opportunities.
                        </p>
                    </div>

                    <!-- Under Graduate Courses Table -->
                    <div class="dept-section-header" style="margin-top: 56px;">
                        <span class="dept-section-kicker">ACADEMIC DEGREE OFFERINGS</span>
                        <h2>Undergraduate Programmes</h2>
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
                                    <td><strong>Information Technology</strong></td>
                                    <td><span class="dept-tag-ug">UG (B.E.)</span></td>
                                    <td>4 Years (8 Semesters)</td>
                                    <td><span class="dept-badge">120 Seats</span></td>
                                    <td>1999</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                        To become a prominent department producing technically competent and skilled intellectual IT professionals with research, innovation and entrepreneurial skills, inculcating moral values and societal concerns.
                    </blockquote>
                </div>

                <div class="dept-charter-card" style="margin-bottom: 48px;">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #111; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.05em;">Mission of the Department</h3>
                    <ul class="dept-mission-steps">
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">I</span>
                            <div class="dept-mission-text">
                                To create globally competent students having ability to provide technical solutions in the field of Information Technology.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">II</span>
                            <div class="dept-mission-text">
                                To create facilities and expertise in the field of Information Technology where students and faculty can enhance their understanding of technology.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">III</span>
                            <div class="dept-mission-text">
                                To enhance industry institute interaction programme to get acquainted with corporate culture.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">IV</span>
                            <div class="dept-mission-text">
                                To induce moral, ethical values and spirit of social commitment.
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
                            <li><strong>PEO 1:</strong> Be prepared to gain employment as a successful IT professional and/or pursue higher studies.</li>
                            <li><strong>PEO 2:</strong> Be capable to adapt advanced state of the art Information technology for professional excellence and Research and be a lifelong learner.</li>
                            <li><strong>PEO 3:</strong> Work productively exhibiting ethical qualities for the betterment of society.</li>
                            <li><strong>PEO 4:</strong> Possess leadership and entrepreneurial qualities, work harmoniously as a team member with effective communication skills.</li>
                        </ul>
                    </div>

                    <div class="dept-obj-card">
                        <h4>Program Specific Outcomes (PSOs)</h4>
                        <div class="dept-obj-lead">Information Technology Graduate will be able to:</div>
                        <ul class="dept-obj-list">
                            <li><strong>PSO 1:</strong> Effectively integrate IT-based solutions into the user environment.</li>
                            <li><strong>PSO 2:</strong> Possess professional skill set of software design process using open source technologies.</li>
                            <li><strong>PSO 3:</strong> Apply concepts of core areas of Information Technology– Data Structures, Database Management Systems, Operating Systems, Computer Network and Software Engineering to provide innovative solution.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Tab 3: Facilities & Labs -->
            <section class="dept-tab-pane" id="tab-facilities">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">EXPERIMENTAL INFRASTRUCTURE</span>
                    <h2>Laboratories &amp; Facilities</h2>
                    <p>Modern computing infrastructure supporting coursework from fundamental algorithmic programming to advanced capstone innovation.</p>
                </div>

                <div class="dept-labs-showcase">
                    <!-- Lab 1 -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_8212_project.jpg" alt="Room 8212 - IT Project &amp; Research Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Room 8212</span>
                            <h3 class="dept-lab-title">IT Project &amp; Research Lab</h3>
                            <p class="dept-lab-desc">Equipped for final-year undergraduate capstone development, multidisciplinary software research, and prototype validation with high-spec desktop machines.</p>
                        </div>
                    </div>

                    <!-- Lab 2 -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/8213-lab.png" alt="Room 8213 - Web Technology &amp; Cloud Computing Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Room 8213</span>
                            <h3 class="dept-lab-title">Web Technology &amp; Cloud Computing Lab</h3>
                            <p class="dept-lab-desc">Dedicated to Web Development, Cloud Computing, RESTful API Design, and Full-Stack framework development utilizing modern Linux environments.</p>
                        </div>
                    </div>

                    <!-- Lab 3 -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_8215_programming2.jpg" alt="Room 8215 - Database &amp; Software Systems Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Room 8215</span>
                            <h3 class="dept-lab-title">Database &amp; Software Systems Lab</h3>
                            <p class="dept-lab-desc">Equipped with enterprise relational database servers (Oracle, MySQL, PostgreSQL) and software testing suites for practical coursework.</p>
                        </div>
                    </div>

                    <!-- Lab 4 -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_8216_pps.jpg" alt="Room 8216 - Programming for Problem Solving Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Room 8216</span>
                            <h3 class="dept-lab-title">Programming for Problem Solving Lab</h3>
                            <p class="dept-lab-desc">Designed for first-year IT students to master algorithmic thinking, data structures, and core programming paradigms using C, C++, and Python.</p>
                        </div>
                    </div>

                    <!-- Lab 5 -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_8217_programming3.jpg" alt="Room 8217 - Network Security &amp; IoT Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Room 8217</span>
                            <h3 class="dept-lab-title">Network Security &amp; IoT Lab</h3>
                            <p class="dept-lab-desc">Advanced networking facility with managed switches, traffic analysis tools, Wireshark packet capture stations, and IoT sensor interface nodes.</p>
                        </div>
                    </div>

                    <!-- Lab 6 -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/seminar_hall.jpg" alt="IT Department Seminar Hall" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Presentation Complex</span>
                            <h3 class="dept-lab-title">IT Department Seminar Hall</h3>
                            <p class="dept-lab-desc">Air-conditioned presentation auditorium equipped with digital audiovisual systems for expert guest lectures, workshops, and project viva defenses.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 6: Publications -->
            <section class="dept-tab-pane" id="tab-publications">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">SCHOLARLY OUTPUT</span>
                    <h2>Faculty Publications</h2>
                    <p>Research contributions, journal articles, and conference proceedings published by Information Technology faculty and researchers.</p>
                </div>

                <!-- Publications Filter Toolbar -->
                <div class="dept-pub-toolbar">
                    <div class="dept-pub-filter-wrap">
                        <label for="pubYearFilter" class="dept-pub-filter-label">
                            <i class="fas fa-calendar-alt"></i> Filter by Year:
                        </label>
                        <div class="dept-pub-select-box">
                            <select id="pubYearFilter" class="dept-pub-select" aria-label="Filter publications by year" onchange="window.filterPublicationsByYear && window.filterPublicationsByYear(this.value)">
                                <option value="all">All Years (30)</option>
                                <option value="2023">2023 (1)</option>
                                <option value="2020">2020 (1)</option>
                                <option value="2019">2019 (8)</option>
                                <option value="2018">2018 (2)</option>
                                <option value="2017">2017 (3)</option>
                                <option value="2016">2016 (2)</option>
                                <option value="2015">2015 (2)</option>
                                <option value="2014">2014 (2)</option>
                                <option value="2013">2013 (1)</option>
                                <option value="2012">2012 (2)</option>
                                <option value="2011">2011 (1)</option>
                                <option value="2010">2010 (4)</option>
                                <option value="2008">2008 (1)</option>
                            </select>
                            <i class="fas fa-chevron-down dept-pub-arrow"></i>
                        </div>
                    </div>
                    <div class="dept-pub-badge" id="pubCountBadge">
                        Showing <strong>30</strong> publications
                    </div>
                </div>

                <div class="dept-citations-list">
                    <!-- Empty filter state notice -->
                    <div class="dept-pub-empty" id="pubEmptyState">
                        <i class="far fa-folder-open"></i>
                        No publications found for the selected year.
                    </div>

                    <!-- Publication 1 -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">Plant Pathology Detection for Massive Heterogeneous Data Using Deep Learning</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Avinash Chaudhari, Kuntesh Jani, Sunil Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- Publication 2 -->
                    <div class="dept-citation-item" data-year="2020">
                        <h3 class="dept-citation-title">Automatic abnormality detection system for capsule endoscopy</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Kuntesh K. Jani, Subodh Srivastava, Animesh Anand and Rajeev Srivastava</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2020</span>
                        </div>
                    </div>

                    <!-- Publication 3 -->
                    <div class="dept-citation-item" data-year="2019">
                        <h3 class="dept-citation-title">Data Reduction Technique for Capsule Endoscopy</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Kuntesh Jani and Rajeev Srivastava</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2019</span>
                        </div>
                    </div>

                    <!-- Publication 4 -->
                    <div class="dept-citation-item" data-year="2019">
                        <h3 class="dept-citation-title">Computer aided medical image analysis for capsule endoscopy using conventional machine learning and deep learning</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Kuntesh K. Jani, Subodh Srivastava, Animesh Anand and Rajeev Srivastava</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2019</span>
                        </div>
                    </div>

                    <!-- Publication 5 -->
                    <div class="dept-citation-item" data-year="2019">
                        <h3 class="dept-citation-title">Computer aided medical image analysis for capsule endoscopy using multi-class classifier</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Kuntesh K. Jani, Subodh Srivastava and Rajeev Srivastava</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2019</span>
                        </div>
                    </div>

                    <!-- Publication 6 -->
                    <div class="dept-citation-item" data-year="2019">
                        <h3 class="dept-citation-title">Computer-Aided Diagnosis for Capsule Endoscopy: From Inception to Future</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> KunteshK. Jani, Subodh Srivastava, Rajeev Srivastava</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2019</span>
                        </div>
                    </div>

                    <!-- Publication 7 -->
                    <div class="dept-citation-item" data-year="2019">
                        <h3 class="dept-citation-title">Computer aided diagnosis system for ulcer detection in capsule endoscopy using optimized feature set</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Kuntesh K. Jani, Subodh Srivastava and Rajeev Srivastava</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2019</span>
                        </div>
                    </div>

                    <!-- Publication 8 -->
                    <div class="dept-citation-item" data-year="2019">
                        <h3 class="dept-citation-title">Applying Parallel Design Patterns on Molecular Dynamics Simulation</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Maltare, Vithal N Kamat.</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2019</span>
                        </div>
                    </div>

                    <!-- Publication 9 -->
                    <div class="dept-citation-item" data-year="2019">
                        <h3 class="dept-citation-title">A Survey on Medical Image Analysis in Capsule Endoscopy</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Kuntesh Ketan Jani, Rajeev Srivastava</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2019</span>
                        </div>
                    </div>

                    <!-- Publication 10 -->
                    <div class="dept-citation-item" data-year="2019">
                        <h3 class="dept-citation-title">Deep Neural Network Model for Group Activity Recognition Using Contextual Relationship</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> S. A. Vahora and N. C. Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2019</span>
                        </div>
                    </div>

                    <!-- Publication 11 -->
                    <div class="dept-citation-item" data-year="2018">
                        <h3 class="dept-citation-title">Group Activity Recognition Using Deep Autoencoder With Temporal Context Descriptor</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> S. A. Vahora and N. C. Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2018</span>
                        </div>
                    </div>

                    <!-- Publication 12 -->
                    <div class="dept-citation-item" data-year="2018">
                        <h3 class="dept-citation-title">Android Smartphone based Visual Object Recognition for Visually Impaired using Deep Learning</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Neel Parikh, Ishita Shah, Safvan Vahora</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2018</span>
                        </div>
                    </div>

                    <!-- Publication 13 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Prediction based Auto Scaling for Cloud Applications</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Prof.C.A.Patel , Prof. H.R.Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- Publication 14 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Gender Classification From Faces: A Survey</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Siddharth Shah, Gopi Bhatt and Safvan Vahora</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- Publication 15 -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">A Comprehensive Study of Group Activity Recognition Methods in Video</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> S. A. Vahora and N. C. Chauhan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- Publication 16 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">Applying Parallel Design Patterns of Embarassingly Parallel Problem</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Maltare, Chetan Chudasama</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- Publication 17 -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">A Review on Forecasting Techniques for SLA Aware Elasticity in Cloud Computing</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Prof.C.A.Patel ,Prof.H.R.Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- Publication 18 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Crowd Behavior Analysis Using Fast Feature</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Kinjal Joshi and Safvan Vahora</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- Publication 19 -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Experimenting Large Prime Numbers Generation in MPI Cluster</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Maltare, Chetan Chudasama</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- Publication 20 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">Crowd Behavior Analysis</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Kinjal Joshi and Safvan Vahora</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2014</span>
                        </div>
                    </div>

                    <!-- Publication 21 -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">Features for Parallel Pattern Based Programming System for Multicore</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Maltare</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2014</span>
                        </div>
                    </div>

                    <!-- Publication 22 -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">A Survey On Super Resolution Image Reconstruction Techniques</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Krunal Shah, Jaymit Pandya and Safvan Vahora</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- Publication 23 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">A Robust Method for Moving Object Detection Using Modified Statistical Mean Method</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Safvan Vahora, Narendra Chauhan, Nilesh Prajapati</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- Publication 24 -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Moving Object Detection Using Incremental Statistical Mean Technique</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Safvan Vahora, Narendra Chauhan, Nilesh Prajapati</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- Publication 25 -->
                    <div class="dept-citation-item" data-year="2011">
                        <h3 class="dept-citation-title">Novel Approach: Naïve Bayes with Vector Space Model for Spam Classification</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Safvan Vahora, Mosin Hasan, Reshma Lakhani</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2011</span>
                        </div>
                    </div>

                    <!-- Publication 26 -->
                    <div class="dept-citation-item" data-year="2010">
                        <h3 class="dept-citation-title">case study on social engineering Techniques for persuasion</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Mosin Hasan, Nilesh Prajapati, Safvan Vahora</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2010</span>
                        </div>
                    </div>

                    <!-- Publication 27 -->
                    <div class="dept-citation-item" data-year="2010">
                        <h3 class="dept-citation-title">A comparative analysis of different neural networks for face recognition using principal component analysis, wavelets and efficient variable learning rate</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Maltare, Raman Bhati, Sarika Jain</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2010</span>
                        </div>
                    </div>

                    <!-- Publication 28 -->
                    <div class="dept-citation-item" data-year="2010">
                        <h3 class="dept-citation-title">Analysis of parallelism available in Neural Network training algorithm of face recognition</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Maltare, Raman Bhati, Sarika Jain</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2010</span>
                        </div>
                    </div>

                    <!-- Publication 29 -->
                    <div class="dept-citation-item" data-year="2010">
                        <h3 class="dept-citation-title">Exploiting UML in modeling Military Organization and Military Behavior</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Maltare, Aditya Parasarampuriya, Sachin Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2010</span>
                        </div>
                    </div>

                    <!-- Publication 30 -->
                    <div class="dept-citation-item" data-year="2008">
                        <h3 class="dept-citation-title">MANAGING DATA REPLICATION IN MOBILE AD-HOC NETWORK DATABASES USING CONTENT BASED ENERGY OPTIMIZATION</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Nilesh Maltare, N.A. Khan</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2008</span>
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

