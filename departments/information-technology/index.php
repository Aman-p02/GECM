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
                    <span class="dept-stat-num">250+</span>
                    <span class="dept-stat-label">CAMPUS NETWORK NODES</span>
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
                        <span class="dept-section-kicker">CURRICULAR INSIGHT</span>
                        <h2>About the Programme</h2>
                        <p class="dept-programme-lead">
                            The field of information technology (IT) covers the design, administration and support of computer and telecommunications systems. Some of the positions in this field include database and network administrators, computer support specialists, computer scientists, software programmers and system analysts. The majority of career tracks in IT entail design and operational tasks related to computer hardware components, networks and software applications.
                        </p>
                    </div>

                    <div class="dept-story-body">
                        <p>
                            Professionals in the IT field work with businesses and organizations to set up and support viable computer networks that will keep systems efficient and reliable. IT encompasses all hardware and software used in the storing, creation and accessing of information. Examples of technologies that professionals work with are firewalls, databases, media storage devices, networks and the Internet.
                        </p>
                        <p>
                            Aspiring IT professionals typically need a bachelor's degree in a technology field, such as computer science, information systems management, programming or networking. Even without a degree, experience in an entry-level help desk position could help IT professionals advance with professional certification or vocational training. The fundamentals of a degree program generally include computer hardware, programming, networking, and technical theory. Depending on the major, students could also learn IT management, website development, computer circuitry, systems analysis and database management. Some programs also include internship opportunities. To work as a computer research scientist, a Ph.D. degree is often necessary.
                        </p>
                    </div>

                    <!-- Under Graduate Courses Table -->
                    <div class="dept-section-header" style="margin-top: 40px; margin-bottom: 20px;">
                        <span class="dept-section-kicker">ACADEMIC OFFERINGS</span>
                        <h3 style="font-family: var(--dept-font-display); font-size: 1.35rem; font-weight: 700; color: #111111; margin: 0;">Under Graduate / Post Graduate Courses</h3>
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
                                    <td><strong>Information Technology</strong></td>
                                    <td><span class="dept-tag-ug">UG</span></td>
                                    <td>4 Years</td>
                                    <td><strong>120</strong></td>
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

            <!-- Tab 3: Faculty -->
            <section class="dept-tab-pane" id="tab-faculty">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">ACADEMIC EXCELLENCE</span>
                    <h2>Faculty Directory</h2>
                    <p>Highly qualified and well-experienced faculties dedicated to academic mentorship, advanced network research, and engineering excellence.</p>
                </div>

                <div class="dept-faculty-roster">
                    <!-- Faculty 1: HOD -->
                    <div class="dept-faculty-card">
                        <div class="dept-faculty-header">
                            <div class="dept-avatar-ph">BC</div>
                            <div>
                                <h3 class="dept-faculty-name">Dr. B. C. Patel</h3>
                                <div class="dept-faculty-rank">Professor &amp; Head of Department</div>
                            </div>
                        </div>
                        <div class="dept-faculty-body">
                            <p class="dept-faculty-meta">
                                <i class="fas fa-graduation-cap"></i> Ph.D. in Information Technology, M.E. (Computer Engg)
                            </p>
                            <p class="dept-faculty-meta">
                                <i class="fas fa-layer-group"></i> Network Security, Cloud Computing &amp; IoT Architectures
                            </p>
                            <div class="dept-faculty-contact">
                                <a href="mailto:hod.it@gecmodasa.ac.in" class="dept-contact-link"><i class="fas fa-envelope"></i> hod.it@gecmodasa.ac.in</a>
                            </div>
                        </div>
                    </div>

                    <!-- Faculty 2 -->
                    <div class="dept-faculty-card">
                        <div class="dept-faculty-header">
                            <div class="dept-avatar-ph">NP</div>
                            <div>
                                <h3 class="dept-faculty-name">Prof. N. M. Prajapati</h3>
                                <div class="dept-faculty-rank">Associate Professor</div>
                            </div>
                        </div>
                        <div class="dept-faculty-body">
                            <p class="dept-faculty-meta">
                                <i class="fas fa-graduation-cap"></i> M.Tech in Information Technology
                            </p>
                            <p class="dept-faculty-meta">
                                <i class="fas fa-layer-group"></i> Distributed Systems, Database Management &amp; Blockchain
                            </p>
                            <div class="dept-faculty-contact">
                                <a href="mailto:nmprajapati@gecmodasa.ac.in" class="dept-contact-link"><i class="fas fa-envelope"></i> nmprajapati@gecmodasa.ac.in</a>
                            </div>
                        </div>
                    </div>

                    <!-- Faculty 3 -->
                    <div class="dept-faculty-card">
                        <div class="dept-faculty-header">
                            <div class="dept-avatar-ph">KS</div>
                            <div>
                                <h3 class="dept-faculty-name">Prof. K. R. Solanki</h3>
                                <div class="dept-faculty-rank">Assistant Professor</div>
                            </div>
                        </div>
                        <div class="dept-faculty-body">
                            <p class="dept-faculty-meta">
                                <i class="fas fa-graduation-cap"></i> M.E. in Information Technology
                            </p>
                            <p class="dept-faculty-meta">
                                <i class="fas fa-layer-group"></i> Web Technology, Full-Stack Engineering &amp; REST APIs
                            </p>
                            <div class="dept-faculty-contact">
                                <a href="mailto:krsolanki@gecmodasa.ac.in" class="dept-contact-link"><i class="fas fa-envelope"></i> krsolanki@gecmodasa.ac.in</a>
                            </div>
                        </div>
                    </div>

                    <!-- Faculty 4 -->
                    <div class="dept-faculty-card">
                        <div class="dept-faculty-header">
                            <div class="dept-avatar-ph">DV</div>
                            <div>
                                <h3 class="dept-faculty-name">Prof. D. J. Vaghela</h3>
                                <div class="dept-faculty-rank">Assistant Professor</div>
                            </div>
                        </div>
                        <div class="dept-faculty-body">
                            <p class="dept-faculty-meta">
                                <i class="fas fa-graduation-cap"></i> M.E. in Computer Engineering
                            </p>
                            <p class="dept-faculty-meta">
                                <i class="fas fa-layer-group"></i> Software Engineering, Agile DevOps &amp; Code Quality
                            </p>
                            <div class="dept-faculty-contact">
                                <a href="mailto:djvaghela@gecmodasa.ac.in" class="dept-contact-link"><i class="fas fa-envelope"></i> djvaghela@gecmodasa.ac.in</a>
                            </div>
                        </div>
                    </div>

                    <!-- Faculty 5 -->
                    <div class="dept-faculty-card">
                        <div class="dept-faculty-header">
                            <div class="dept-avatar-ph">HT</div>
                            <div>
                                <h3 class="dept-faculty-name">Prof. H. K. Trivedi</h3>
                                <div class="dept-faculty-rank">Assistant Professor</div>
                            </div>
                        </div>
                        <div class="dept-faculty-body">
                            <p class="dept-faculty-meta">
                                <i class="fas fa-graduation-cap"></i> M.Tech in Information Technology
                            </p>
                            <p class="dept-faculty-meta">
                                <i class="fas fa-layer-group"></i> Cloud Native Architecture, Microservices &amp; Linux Admin
                            </p>
                            <div class="dept-faculty-contact">
                                <a href="mailto:hktrivedi@gecmodasa.ac.in" class="dept-contact-link"><i class="fas fa-envelope"></i> hktrivedi@gecmodasa.ac.in</a>
                            </div>
                        </div>
                    </div>

                    <!-- Faculty 6 -->
                    <div class="dept-faculty-card">
                        <div class="dept-faculty-header">
                            <div class="dept-avatar-ph">MP</div>
                            <div>
                                <h3 class="dept-faculty-name">Prof. M. S. Panchal</h3>
                                <div class="dept-faculty-rank">Assistant Professor</div>
                            </div>
                        </div>
                        <div class="dept-faculty-body">
                            <p class="dept-faculty-meta">
                                <i class="fas fa-graduation-cap"></i> M.E. in Information Technology
                            </p>
                            <p class="dept-faculty-meta">
                                <i class="fas fa-layer-group"></i> Data Structures, Algorithms &amp; High-Performance Computing
                            </p>
                            <div class="dept-faculty-contact">
                                <a href="mailto:mspanchal@gecmodasa.ac.in" class="dept-contact-link"><i class="fas fa-envelope"></i> mspanchal@gecmodasa.ac.in</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 4: Activities -->
            <section class="dept-tab-pane" id="tab-activities">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">CO-CURRICULAR &amp; TECHNICAL</span>
                    <h2>Department Activities</h2>
                    <p>Fostering practical technical expertise, open-source contribution, and team collaboration through hackathons, industrial visits, and expert workshops.</p>
                </div>

                <div class="dept-activities-grid">
                    <!-- Activity 1 -->
                    <div class="dept-activity-card">
                        <div class="dept-activity-date">
                            <span class="day">18</span>
                            <span class="month">SEP</span>
                        </div>
                        <div class="dept-activity-info">
                            <span class="dept-activity-tag">Hackathon</span>
                            <h3 class="dept-activity-title">WebSprint 2024: 24-Hour Full-Stack Development Challenge</h3>
                            <p class="dept-activity-desc">Department-level hackathon bringing together over 35 student teams building real-world web applications using modern JavaScript frameworks and RESTful APIs.</p>
                        </div>
                    </div>

                    <!-- Activity 2 -->
                    <div class="dept-activity-card">
                        <div class="dept-activity-date">
                            <span class="day">05</span>
                            <span class="month">AUG</span>
                        </div>
                        <div class="dept-activity-info">
                            <span class="dept-activity-tag">Workshop</span>
                            <h3 class="dept-activity-title">Hands-on Cloud Computing &amp; AWS DevOps Workshop</h3>
                            <p class="dept-activity-desc">Comprehensive three-day technical workshop on deploying scalable containerized applications using Docker, Kubernetes, and AWS EC2 cloud infrastructure.</p>
                        </div>
                    </div>

                    <!-- Activity 3 -->
                    <div class="dept-activity-card">
                        <div class="dept-activity-date">
                            <span class="day">12</span>
                            <span class="month">MAR</span>
                        </div>
                        <div class="dept-activity-info">
                            <span class="dept-activity-tag">Industrial Visit</span>
                            <h3 class="dept-activity-title">Industrial Exposure Visit to BISAG-N &amp; Gujarat Informatics Ltd (GIL)</h3>
                            <p class="dept-activity-desc">Educational visit providing pre-final year IT students direct insight into state-level geospatial network centers, data center administration, and e-governance systems.</p>
                        </div>
                    </div>

                    <!-- Activity 4 -->
                    <div class="dept-activity-card">
                        <div class="dept-activity-date">
                            <span class="day">22</span>
                            <span class="month">JAN</span>
                        </div>
                        <div class="dept-activity-info">
                            <span class="dept-activity-tag">Bootcamp</span>
                            <h3 class="dept-activity-title">Cyber Security &amp; Network Defense Bootcamp</h3>
                            <p class="dept-activity-desc">Interactive cybersecurity session on ethical hacking, firewall configuration, Wireshark packet analysis, and OWASP vulnerability identification.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 5: Facilities & Labs -->
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
                                <option value="all">All Years (4)</option>
                                <option value="2024">2024 (1)</option>
                                <option value="2023">2023 (2)</option>
                                <option value="2022">2022 (1)</option>
                            </select>
                            <i class="fas fa-chevron-down dept-pub-arrow"></i>
                        </div>
                    </div>
                    <div class="dept-pub-badge" id="pubCountBadge">
                        Showing <strong>4</strong> publications
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
                        <h3 class="dept-citation-title">Secure Lightweight Authentication Protocol for IoT-Enabled Smart Campus Environments</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Dr. B. C. Patel, Prof. K. R. Solanki</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2024</span>
                        </div>
                    </div>

                    <!-- Publication 2 -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">Distributed Ledger Technology for Verifiable Academic Credential Management</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Prof. N. M. Prajapati, Dr. B. C. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- Publication 3 -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">Automated Code Quality Assessment in Continuous Integration Pipelines Using Deep Learning</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Prof. D. J. Vaghela</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- Publication 4 -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">An Empirical Study of Microservice Failure Recovery Patterns in Cloud-Native Environments</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Prof. H. K. Trivedi, Prof. M. S. Panchal</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
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

