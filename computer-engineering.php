<?php
// Set Page Variables
$page_title = "Computer Engineering Department - Government Engineering College, Modasa";
$active_page = "departments";
$extra_css = "css/department.css";
$extra_js = "js/department.js";

// Include Header
include_once __DIR__ . '/includes/header.php';
?>

<!-- ========================================================
     1. Department Institutional Hero Banner
     ======================================================== -->
<section class="dept-hero-section">
    <div class="full-width-container">
        <div class="dept-hero-container">
            <div class="dept-hero-text">
                <div class="dept-pill-badge">
                    <i class="fas fa-microchip"></i> Department of Technical Education &bull; Government of Gujarat
                </div>
                <h1 class="dept-hero-h1">
                    Department of <span class="highlight">Computer Engineering</span>
                </h1>
                <p class="dept-hero-p">
                    Pioneering excellence in computing technologies, high-impact software research, and industry-oriented engineering education since 2001.
                </p>
                <div class="dept-tags-row">
                    <span class="dept-tag"><i class="fas fa-check-circle"></i> GTU Affiliated</span>
                    <span class="dept-tag"><i class="fas fa-award"></i> AICTE Approved</span>
                    <span class="dept-tag"><i class="fas fa-calendar-alt"></i> Established 2001</span>
                    <span class="dept-tag"><i class="fas fa-graduation-cap"></i> UG &amp; PG Degree Programs</span>
                </div>
            </div>
            <nav class="dept-breadcrumb-pill" aria-label="Breadcrumb">
                <a href="./"><i class="fas fa-home"></i> Home</a>
                <span class="sep">/</span>
                <a href="./#departments">Departments</a>
                <span class="sep">/</span>
                <span class="current">Computer Engineering</span>
            </nav>
        </div>
    </div>
</section>

<!-- ========================================================
     2. Main 2-Column Department Workspace
     ======================================================== -->
<div class="dept-page-wrapper">
    <div class="full-width-container">
        <div class="dept-layout-grid">

            <!-- Left Sidebar Navigation -->
            <aside class="dept-sidebar">
                <div class="dept-sidebar-header">
                    <div class="sidebar-header-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div class="sidebar-header-text">
                        <h4>Computer Dept.</h4>
                        <small>Academic Portal</small>
                    </div>
                </div>
                <ul class="dept-sidebar-menu">
                    <li class="active">
                        <a class="dept-nav-link active" data-tab="about">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-landmark"></i>
                                <span>About Department</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="vision-mission">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-compass"></i>
                                <span>Vision &amp; Mission</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="syllabus">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-graduation-cap"></i>
                                <span>Syllabus</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="faculty">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <span>Faculty</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="activities">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-bolt"></i>
                                <span>Activities</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="facilities">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-server"></i>
                                <span>Facilities</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="publications">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-award"></i>
                                <span>Publications</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="advisory-board">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-briefcase"></i>
                                <span>Industry Advisory Board</span>
                            </span>
                            <i class="fas fa-chevron-right chevron-icon"></i>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="newsletters">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-newspaper"></i>
                                <span>News Letters</span>
                            </span>
                            <i class="fas fa-chevron-right chevron-icon"></i>
                        </a>
                    </li>
                </ul>

                <!-- Sidebar Department Contact Footer -->
                <div class="dept-sidebar-info">
                    <h5><i class="fas fa-headset"></i> Department Office</h5>
                    <p><strong>Location:</strong> New CE-IT Building, 1st Floor</p>
                    <p><strong>Email:</strong> <a href="mailto:hod_ce@gecmodasa.ac.in">hod_ce@gecmodasa.ac.in</a></p>
                    <p><strong>Phone:</strong> +91 2774 242631 Ext: 201</p>
                </div>
            </aside>

            <!-- Right Content Area -->
            <main class="dept-content-panel">

                <!-- ========================================================
                     1. ABOUT DEPARTMENT TAB
                     ======================================================== -->
                <section class="dept-tab-pane active" id="tab-about">
                    <div class="tab-header-banner">
                        <div class="tab-header-left">
                            <div class="tab-header-icon"><i class="fas fa-landmark"></i></div>
                            <div class="tab-header-text">
                                <h3>About Department</h3>
                                <p>Government Engineering College, Modasa &bull; Established 2001</p>
                            </div>
                        </div>
                    </div>

                    <!-- Department Key Metrics Strip -->
                    <div class="dept-metrics-strip">
                        <div class="metric-card">
                            <div class="metric-num">2001</div>
                            <div class="metric-label">Established</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-num">120</div>
                            <div class="metric-label">B.E. Intake</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-num">18</div>
                            <div class="metric-label">M.E. Intake</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-num">10</div>
                            <div class="metric-label">Hi-Tech Labs</div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-num">250+</div>
                            <div class="metric-label">Network Nodes</div>
                        </div>
                    </div>

                    <p class="dept-content-text">
                        This department is running from 2001. The staff has developed required laboratories in the areas like Computer Hardware, Computer Networking &amp; Security, Database Management System, Computer Graphics and Internet Technology in tune with real-time systems.
                    </p>

                    <p class="dept-content-text">
                        The Internet access is provided to the students to update their knowledge in various fields. Currently, a project under AICTE Grant for Campus Networking is under process. The Computer Department is equipped with around 100+ computers with multimedia software and LAN Systems with Internet connection.
                    </p>

                    <p class="dept-content-text">
                        The Department has purchased Latest Computer Servers and Network-based online teaching system software named Content Server. The department is sharing all infrastructural facilities of Information Technology Department. The laboratories in the department are well developed to cater needs of the students. Department is also offering Post Graduate course in Computer Science &amp; Engineering since 2010.
                    </p>

                    <p class="dept-content-text">
                        Computer Engineering and Information Technology department run in a newly constructed, well-furnished building. The main strength of the department is highly qualified and well-experienced faculties. Also, the department is well equipped with an ample number of computer systems, networking of more than 250 nodes and required software and hardware. Department has well equipped 10 computer laboratories and two seminar halls. Campus Wide Network of college is handled by the department with 30 Wi-Fi access points with 1 controller. It has High-End Servers available for various activities.
                    </p>

                    <!-- About the Programme Section -->
                    <div class="dept-subheading">
                        <i class="fas fa-graduation-cap"></i>
                        <span>About the Programme</span>
                    </div>

                    <p class="dept-content-text">
                        Computer engineering blends together computer science and electrical engineering to further advancements in digital technology, computer networking, and computer systems. In turn, computer engineers use their extensive knowledge of hardware and software design and computer programming to make computing platforms and applications more efficient and effective. Seamlessly integrating the latest innovations, computer engineers develop new computer hardware, design and implement software applications, and enhance the capabilities of networks and communications systems.
                    </p>

                    <p class="dept-content-text">
                        Computer engineers work with hardware and software, ensuring that the two are seamlessly integrated and functioning properly. Computer engineers focus on innovation—making computing systems safer, faster and more powerfull. At the career level, there are two main avenues: hardware and software engineering. Hardware engineers focus their skills on computer systems and components, designing microprocessors, circuit boards, routers and other embedded devices. On the software side, these engineers create, test and debug programs and applications that run on computers, mobile devices and more.
                    </p>

                    <!-- Under Graduate/Post Graduate Courses Table Card -->
                    <div class="dept-academic-card">
                        <div class="dept-card-header">
                            <i class="fas fa-bars"></i>
                            <span>Under Graduate/Post Graduate Courses</span>
                        </div>
                        <div class="dept-table-responsive">
                            <table class="dept-data-table">
                                <thead>
                                    <tr>
                                        <th>Name of Course</th>
                                        <th>Type</th>
                                        <th>Period (Years)</th>
                                        <th>Intake</th>
                                        <th>Year of Starting</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Computer Engineering</td>
                                        <td><span class="badge-program ug">UG</span></td>
                                        <td>4</td>
                                        <td>120</td>
                                        <td>2001</td>
                                    </tr>
                                    <tr>
                                        <td>Computer Engineering (Software Engineering)</td>
                                        <td><span class="badge-program pg">PG</span></td>
                                        <td>2</td>
                                        <td>18</td>
                                        <td>2010</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Facilities Section below Courses Table -->
                    <div class="dept-subheading" style="margin-top: 40px;">
                        <i class="fas fa-server"></i>
                        <span>Department Facilities</span>
                    </div>

                    <div class="facilities-interactive-grid">
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-wifi"></i></div>
                            <span class="facility-name">Wi-Fi enabled Department</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-network-wired"></i></div>
                            <span class="facility-name">Campus Wide Fiber Optic Cable Network</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-desktop"></i></div>
                            <span class="facility-name">System Lab</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-shield-alt"></i></div>
                            <span class="facility-name">Network Lab</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-code"></i></div>
                            <span class="facility-name">Programming Language Lab</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-database"></i></div>
                            <span class="facility-name">DBMS Lab</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-microchip"></i></div>
                            <span class="facility-name">Digital Logic Lab</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-terminal"></i></div>
                            <span class="facility-name">Operating System Lab</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-chalkboard-teacher"></i></div>
                            <span class="facility-name">Seminar Halls</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-laptop"></i></div>
                            <span class="facility-name">Digital Learning Lab</span>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     2. VISION & MISSION TAB
                     ======================================================== -->
                <section class="dept-tab-pane" id="tab-vision-mission">
                    <div class="tab-header-banner">
                        <div class="tab-header-left">
                            <div class="tab-header-icon"><i class="fas fa-compass"></i></div>
                            <div class="tab-header-text">
                                <h3>Vision &amp; Mission</h3>
                                <p>Guiding Principles of Computer Engineering Department &bull; GEC Modasa</p>
                            </div>
                        </div>
                    </div>

                    <div class="dept-subheading">
                        <i class="fas fa-eye"></i>
                        <span>Department Vision</span>
                    </div>

                    <div class="vision-banner-card">
                        <p>
                            &ldquo;To become a prominent department producing competent professionals with research, innovation and entrepreneurial skills, inculcating moral values and societal concerns.&rdquo;
                        </p>
                    </div>

                    <div class="dept-subheading">
                        <i class="fas fa-bullseye"></i>
                        <span>Department Mission</span>
                    </div>

                    <div class="mission-cards-list">
                        <div class="mission-card">
                            <div class="mission-badge-num">01</div>
                            <p>To create globally competent students having ability to design, develop and test world class software, keeping pace with the latest technological developments.</p>
                        </div>
                        <div class="mission-card">
                            <div class="mission-badge-num">02</div>
                            <p>Create facilities and expertise in advanced computer technology thereby promote research.</p>
                        </div>
                        <div class="mission-card">
                            <div class="mission-badge-num">03</div>
                            <p>Enhance Industry Institute Interaction programme to get acquainted with corporate culture.</p>
                        </div>
                        <div class="mission-card">
                            <div class="mission-badge-num">04</div>
                            <p>Induce moral, ethical values and spirit of social commitment.</p>
                        </div>
                    </div>

                    <!-- PEOs Card -->
                    <div class="dept-academic-card">
                        <div class="dept-card-header">
                            <i class="fas fa-bars"></i>
                            <span>Program Educational Objectives (PEOs)</span>
                        </div>
                        <div class="peo-card-body">
                            <div class="peo-intro-line">Graduates will:</div>
                            <ul class="peo-list">
                                <li><strong>PEO 1:</strong> Establish themselves as successful professionals in computer engineering or allied fields.</li>
                                <li><strong>PEO 2:</strong> Pursue lifelong learning, higher education, research and adapt to evolving technologies.</li>
                                <li><strong>PEO 3:</strong> Practice professional ethics, leadership qualities, and contribute responsibly to societal development.</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     3. SYLLABUS TAB
                     ======================================================== -->
                <section class="dept-tab-pane" id="tab-syllabus">
                    <div class="tab-header-banner">
                        <div class="tab-header-left">
                            <div class="tab-header-icon"><i class="fas fa-graduation-cap"></i></div>
                            <div class="tab-header-text">
                                <h3>Syllabus &amp; Curriculum</h3>
                                <p>Gujarat Technological University (GTU) &bull; NEP / AICTE Model Curriculum</p>
                            </div>
                        </div>
                    </div>

                    <p class="dept-content-text">
                        The curriculum of Bachelor of Engineering (Computer Engineering) follows Gujarat Technological University (GTU) guidelines aligned with the National Education Policy (NEP) and AICTE model curriculum.
                    </p>

                    <div class="dept-table-responsive">
                        <table class="dept-data-table">
                            <thead>
                                <tr>
                                    <th>Semester</th>
                                    <th>Key Subjects Included</th>
                                    <th>Pattern</th>
                                    <th>Curriculum</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Semester I &amp; II</strong></td>
                                    <td>Basic Engineering, Mathematics, Programming for Problem Solving (C Language), Engineering Graphics</td>
                                    <td>GTU NEP / AICTE</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-action-primary"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester III</strong></td>
                                    <td>Data Structures, Digital Fundamentals, Database Management Systems, Discrete Mathematics</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-action-primary"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester IV</strong></td>
                                    <td>Operating Systems, Object Oriented Programming with Java, Computer Organization, Principles of Economics</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-action-primary"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester V</strong></td>
                                    <td>Computer Networks, Software Engineering, Design &amp; Analysis of Algorithms, Professional Elective I</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-action-primary"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester VI</strong></td>
                                    <td>Theory of Computation, Web Technology, Advanced Java / Python, Cyber Security, Professional Elective II</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-action-primary"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester VII</strong></td>
                                    <td>Artificial Intelligence &amp; Machine Learning, Cloud Computing, Compiler Design, Project - I</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-action-primary"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester VIII</strong></td>
                                    <td>Big Data Analytics / Internet of Things, Major Project / Full Semester Industry Internship</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-action-primary"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- ========================================================
                     4. FACULTY TAB
                     ======================================================== -->
                <section class="dept-tab-pane" id="tab-faculty">
                    <div class="tab-header-banner">
                        <div class="tab-header-left">
                            <div class="tab-header-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                            <div class="tab-header-text">
                                <h3>Faculty Members</h3>
                                <p>Dedicated Teaching Faculty &bull; Department of Computer Engineering</p>
                            </div>
                        </div>
                    </div>

                    <p class="dept-content-text">
                        The Computer Engineering department possesses highly qualified, experienced, and dedicated teaching faculty members with specializations across diverse domains.
                    </p>

                    <div class="dept-faculty-grid">
                        <div class="dept-faculty-card">
                            <div class="faculty-avatar-circle"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-card-name">Dr. H. M. Patel</h4>
                            <div class="faculty-card-role">Head of Department</div>
                            <div class="faculty-card-qual">Ph.D., M.Tech (Computer Engg)</div>
                            <div class="faculty-card-contact"><i class="fas fa-envelope"></i> hod_ce@gecmodasa.ac.in</div>
                        </div>

                        <div class="dept-faculty-card">
                            <div class="faculty-avatar-circle"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-card-name">Prof. A. S. Shah</h4>
                            <div class="faculty-card-role">Associate Professor</div>
                            <div class="faculty-card-qual">Ph.D. (Pursuing), M.E. (Computer Engg)</div>
                            <div class="faculty-card-contact"><i class="fas fa-envelope"></i> asshah@gecmodasa.ac.in</div>
                        </div>

                        <div class="dept-faculty-card">
                            <div class="faculty-avatar-circle"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-card-name">Prof. R. K. Prajapati</h4>
                            <div class="faculty-card-role">Assistant Professor</div>
                            <div class="faculty-card-qual">M.E. (Computer Science &amp; Engg)</div>
                            <div class="faculty-card-contact"><i class="fas fa-envelope"></i> rkprajapati@gecmodasa.ac.in</div>
                        </div>

                        <div class="dept-faculty-card">
                            <div class="faculty-avatar-circle"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-card-name">Prof. P. N. Mehta</h4>
                            <div class="faculty-card-role">Assistant Professor</div>
                            <div class="faculty-card-qual">M.Tech (Software Engineering)</div>
                            <div class="faculty-card-contact"><i class="fas fa-envelope"></i> pnmehta@gecmodasa.ac.in</div>
                        </div>

                        <div class="dept-faculty-card">
                            <div class="faculty-avatar-circle"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-card-name">Prof. S. D. Joshi</h4>
                            <div class="faculty-card-role">Assistant Professor</div>
                            <div class="faculty-card-qual">M.E. (Computer Engineering)</div>
                            <div class="faculty-card-contact"><i class="fas fa-envelope"></i> sdjoshi@gecmodasa.ac.in</div>
                        </div>

                        <div class="dept-faculty-card">
                            <div class="faculty-avatar-circle"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-card-name">Prof. M. B. Patel</h4>
                            <div class="faculty-card-role">Assistant Professor</div>
                            <div class="faculty-card-qual">M.Tech (Information Technology)</div>
                            <div class="faculty-card-contact"><i class="fas fa-envelope"></i> mbpatel@gecmodasa.ac.in</div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     5. ACTIVITIES TAB
                     ======================================================== -->
                <section class="dept-tab-pane" id="tab-activities">
                    <div class="tab-header-banner">
                        <div class="tab-header-left">
                            <div class="tab-header-icon"><i class="fas fa-bolt"></i></div>
                            <div class="tab-header-text">
                                <h3>Department Activities</h3>
                                <p>Workshops, Hackathons, Expert Talks &amp; Field Visits</p>
                            </div>
                        </div>
                    </div>

                    <p class="dept-content-text">
                        The department regularly organizes workshops, hackathons, expert lectures by industry leaders, and technical competitions under the banner of student developer clubs and societies.
                    </p>

                    <div class="dept-lab-detailed-grid">
                        <div class="dept-lab-box">
                            <h5><i class="fas fa-laptop-code"></i> CodeFest &amp; Hackathons</h5>
                            <p>Annual inter-college coding marathon encouraging students to develop innovative software solutions for real-world governance and industrial problems.</p>
                        </div>
                        <div class="dept-lab-box">
                            <h5><i class="fas fa-chalkboard-teacher"></i> Expert Lectures &amp; Webinars</h5>
                            <p>Industry professionals deliver interactive sessions on Cloud Architecture, Cyber Forensics, DevOps, and Full-Stack Development.</p>
                        </div>
                        <div class="dept-lab-box">
                            <h5><i class="fas fa-industry"></i> Industrial Visits</h5>
                            <p>Educational visits to organizations such as BISAG-N Gandhinagar, TCS Garima Park, and ISRO Space Applications Centre.</p>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     6. FACILITIES TAB
                     ======================================================== -->
                <section class="dept-tab-pane" id="tab-facilities">
                    <div class="tab-header-banner">
                        <div class="tab-header-left">
                            <div class="tab-header-icon"><i class="fas fa-server"></i></div>
                            <div class="tab-header-text">
                                <h3>Laboratories &amp; Facilities</h3>
                                <p>Cutting-Edge Computing Infrastructure &amp; Specialised Labs</p>
                            </div>
                        </div>
                    </div>

                    <p class="dept-content-text">
                        The department is equipped with 10 computer laboratories with over 250 high-end networked systems, dedicated servers, and high-speed campus-wide Wi-Fi access.
                    </p>

                    <div class="dept-subheading" style="margin-top: 10px;">
                        <i class="fas fa-th-list"></i>
                        <span>Facility Overview</span>
                    </div>

                    <div class="facilities-interactive-grid" style="margin-bottom: 35px;">
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-wifi"></i></div>
                            <span class="facility-name">Wi-Fi enabled Department</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-network-wired"></i></div>
                            <span class="facility-name">Campus Wide Fiber Optic Cable Network</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-desktop"></i></div>
                            <span class="facility-name">System Lab</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-shield-alt"></i></div>
                            <span class="facility-name">Network Lab</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-code"></i></div>
                            <span class="facility-name">Programming Language Lab</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-database"></i></div>
                            <span class="facility-name">DBMS Lab</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-microchip"></i></div>
                            <span class="facility-name">Digital Logic Lab</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-terminal"></i></div>
                            <span class="facility-name">Operating System Lab</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-chalkboard-teacher"></i></div>
                            <span class="facility-name">Seminar Halls</span>
                        </div>
                        <div class="facility-card-item">
                            <div class="facility-icon-wrap"><i class="fas fa-laptop"></i></div>
                            <span class="facility-name">Digital Learning Lab</span>
                        </div>
                    </div>

                    <div class="dept-subheading">
                        <i class="fas fa-door-open"></i>
                        <span>Detailed Laboratory Configurations</span>
                    </div>

                    <div class="dept-lab-detailed-grid">
                        <div class="dept-lab-box">
                            <h5><i class="fas fa-desktop"></i> Programming &amp; Algorithms Lab</h5>
                            <p>Equipped with Linux and Windows environments for C, C++, Data Structures, and Algorithm analysis experiments.</p>
                        </div>
                        <div class="dept-lab-box">
                            <h5><i class="fas fa-database"></i> Database Management Systems Lab</h5>
                            <p>Configured with Oracle, MySQL, MongoDB, and PostgreSQL for backend architecture design and query optimization.</p>
                        </div>
                        <div class="dept-lab-box">
                            <h5><i class="fas fa-network-wired"></i> Networking &amp; Security Lab</h5>
                            <p>Equipped with Cisco routers, managed switches, Wireshark packet analyzers, and cyber security simulation testbeds.</p>
                        </div>
                        <div class="dept-lab-box">
                            <h5><i class="fas fa-brain"></i> AI &amp; Machine Learning Lab</h5>
                            <p>High-end GPU-accelerated computing systems dedicated to Artificial Intelligence, Deep Learning, and Computer Vision research.</p>
                        </div>
                        <div class="dept-lab-box">
                            <h5><i class="fas fa-server"></i> Central Server Room</h5>
                            <p>High-performance rack servers hosting institute websites, student portal, proxy, and network firewall controllers.</p>
                        </div>
                        <div class="dept-lab-box">
                            <h5><i class="fas fa-users"></i> Department Seminar Halls</h5>
                            <p>Two seminar halls with digital podiums, surround sound, and HD projection facilities for workshops and seminars.</p>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     7. PUBLICATIONS TAB
                     ======================================================== -->
                <section class="dept-tab-pane" id="tab-publications">
                    <div class="tab-header-banner">
                        <div class="tab-header-left">
                            <div class="tab-header-icon"><i class="fas fa-award"></i></div>
                            <div class="tab-header-text">
                                <h3>Research &amp; Publications</h3>
                                <p>Scopus-Indexed Journals, Patents &amp; International Conferences</p>
                            </div>
                        </div>
                    </div>

                    <p class="dept-content-text">
                        Faculties and students of the Computer Engineering department actively publish research articles in peer-reviewed journals and conferences.
                    </p>

                    <div class="dept-table-responsive">
                        <table class="dept-data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title of Research Paper</th>
                                    <th>Author(s)</th>
                                    <th>Journal / Conference</th>
                                    <th>Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>"Optimized Task Scheduling Algorithm in Cloud Computing Using Heuristic Approaches"</td>
                                    <td>Dr. H. M. Patel</td>
                                    <td>IEEE International Conference on Smart Systems</td>
                                    <td>2024</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>"Lightweight Cryptographic Protocol for Resource-Constrained IoT Edge Devices"</td>
                                    <td>Prof. A. S. Shah</td>
                                    <td>International Journal of Information Security (Springer)</td>
                                    <td>2023</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>"Deep Learning-Based Automated Medical Image Segmentation"</td>
                                    <td>Prof. P. N. Mehta</td>
                                    <td>Elsevier Procedia Computer Science</td>
                                    <td>2023</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>"A Comparative Analysis of NoSQL Databases for Large-Scale Big Data Streaming"</td>
                                    <td>Prof. R. K. Prajapati</td>
                                    <td>UGC Care Group Journal of Engineering Sciences</td>
                                    <td>2022</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- ========================================================
                     8. INDUSTRY ADVISORY BOARD TAB
                     ======================================================== -->
                <section class="dept-tab-pane" id="tab-advisory-board">
                    <div class="tab-header-banner">
                        <div class="tab-header-left">
                            <div class="tab-header-icon"><i class="fas fa-briefcase"></i></div>
                            <div class="tab-header-text">
                                <h3>Industry Advisory Board (IAB)</h3>
                                <p>Curriculum Modernization &bull; Corporate Partnerships</p>
                            </div>
                        </div>
                    </div>

                    <p class="dept-content-text">
                        The Industry Advisory Board bridges the gap between academic curriculum and current industry demands, reviewing syllabi and capstone projects periodically.
                    </p>

                    <div class="dept-lab-detailed-grid">
                        <div class="dept-lab-box">
                            <h5><i class="fas fa-building"></i> Industry Leaders</h5>
                            <p style="margin-bottom: 8px;"><strong>Mr. J. K. Sharma</strong> &bull; VP Engineering, TCS</p>
                            <p style="margin-bottom: 8px;"><strong>Mr. Sameer Desai</strong> &bull; Technical Director, L&amp;T Infotech</p>
                            <p><strong>Ms. Neha Trivedi</strong> &bull; Senior Architect, Infosys</p>
                        </div>
                        <div class="dept-lab-box">
                            <h5><i class="fas fa-bullseye"></i> Key Board Objectives</h5>
                            <p style="margin-bottom: 8px;">&bull; Align GTU curriculum with market technologies.</p>
                            <p style="margin-bottom: 8px;">&bull; Facilitate semester-long industry internships and live capstone projects.</p>
                            <p>&bull; Facilitate campus placement drives and corporate mentoring.</p>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     9. NEWS LETTERS TAB
                     ======================================================== -->
                <section class="dept-tab-pane" id="tab-newsletters">
                    <div class="tab-header-banner">
                        <div class="tab-header-left">
                            <div class="tab-header-icon"><i class="fas fa-newspaper"></i></div>
                            <div class="tab-header-text">
                                <h3>Department Newsletters</h3>
                                <p>Biannual Departmental Chronicle "COMP-CONNECT"</p>
                            </div>
                        </div>
                    </div>

                    <p class="dept-content-text">
                        The biannual departmental newsletter <strong>"COMP-CONNECT"</strong> chronicles academic achievements, faculty publications, student awards, and technological developments.
                    </p>

                    <div class="dept-table-responsive">
                        <table class="dept-data-table">
                            <thead>
                                <tr>
                                    <th>Volume &amp; Issue</th>
                                    <th>Period</th>
                                    <th>Theme Highlights</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>COMP-CONNECT Vol. 8</strong></td>
                                    <td>Jan 2024 - June 2024</td>
                                    <td>AI Advancements, Hackathon Achievements &amp; Placements</td>
                                    <td><a href="#" class="btn-action-primary"><i class="fas fa-file-pdf"></i> Read</a></td>
                                </tr>
                                <tr>
                                    <td><strong>COMP-CONNECT Vol. 7</strong></td>
                                    <td>July 2023 - Dec 2023</td>
                                    <td>Cloud Architecture Workshop &amp; Alumni Interactions</td>
                                    <td><a href="#" class="btn-action-primary"><i class="fas fa-file-pdf"></i> Read</a></td>
                                </tr>
                                <tr>
                                    <td><strong>COMP-CONNECT Vol. 6</strong></td>
                                    <td>Jan 2023 - June 2023</td>
                                    <td>National Tech-Fest Winner Edition</td>
                                    <td><a href="#" class="btn-action-primary"><i class="fas fa-file-pdf"></i> Read</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

            </main>
        </div>
    </div>
</div>

<?php
// Include Footer
include_once __DIR__ . '/includes/footer.php';
?>
