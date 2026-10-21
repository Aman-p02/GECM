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
     Department Hero Banner & Breadcrumbs (Replaces messy floating box)
     ======================================================== -->
<section class="dept-hero-banner">
    <div class="full-width-container">
        <div class="dept-hero-inner">
            <div class="dept-hero-info">
                <span class="dept-badge"><i class="fas fa-microchip"></i> Department of</span>
                <h1 class="dept-main-title">Computer Engineering</h1>
                <p class="dept-hero-sub">Pioneering technical education, cutting-edge software research, and industry innovation since 2001.</p>
            </div>
            <nav class="dept-hero-breadcrumb" aria-label="Breadcrumb">
                <a href="./"><i class="fas fa-home"></i> Home</a>
                <span class="crumb-sep">/</span>
                <a href="./#departments">Departments</a>
                <span class="crumb-sep">/</span>
                <span class="current-crumb">Computer Engineering</span>
            </nav>
        </div>
    </div>
</section>

<!-- ========================================================
     Main 2-Column Department Workspace
     ======================================================== -->
<div class="dept-page-wrapper">
    <div class="full-width-container">
        <div class="dept-layout-grid">

            <!-- Left Sidebar Navigation -->
            <aside class="dept-sidebar">
                <div class="dept-sidebar-header">
                    <i class="fas fa-laptop-code"></i>
                    <span>Computer Department</span>
                </div>
                <ul class="dept-sidebar-menu">
                    <li class="active">
                        <a class="dept-nav-link active" data-tab="about">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-info-circle"></i>
                                <span>About Department</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="vision-mission">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-bullseye"></i>
                                <span>Vision &amp; Mission</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="syllabus">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-book-reader"></i>
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
                                <i class="fas fa-calendar-alt"></i>
                                <span>Activities</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="facilities">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-network-wired"></i>
                                <span>Facilities</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="publications">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-file-alt"></i>
                                <span>Publications</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="advisory-board">
                            <span class="dept-nav-link-left">
                                <i class="fas fa-handshake"></i>
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

                <!-- Sidebar Quick Info -->
                <div class="dept-sidebar-contact">
                    <h5><i class="fas fa-headset"></i> Department Office</h5>
                    <p><i class="fas fa-building" style="color: #64748b;"></i> New CE-IT Building, 1st Floor</p>
                    <p><i class="fas fa-envelope" style="color: #64748b;"></i> <a href="mailto:hod_ce@gecmodasa.ac.in">hod_ce@gecmodasa.ac.in</a></p>
                    <p><i class="fas fa-phone-alt" style="color: #64748b;"></i> +91 2774 242631 Ext: 201</p>
                </div>
            </aside>

            <!-- Right Content Card -->
            <main class="dept-content-card">

                <!-- ========================================================
                     1. ABOUT DEPARTMENT TAB
                     ======================================================== -->
                <section class="dept-tab-content active" id="tab-about">
                    <div class="tab-header">
                        <div class="tab-header-icon"><i class="fas fa-info-circle"></i></div>
                        <div>
                            <h2 class="tab-title">About Department</h2>
                            <p class="tab-subtitle">Government Engineering College, Modasa &bull; Established in 2001</p>
                        </div>
                    </div>

                    <!-- Department Key Highlights / Stats -->
                    <div class="dept-stats-grid">
                        <div class="dept-stat-box">
                            <div class="stat-number">2001</div>
                            <div class="stat-label">Year Established</div>
                        </div>
                        <div class="dept-stat-box">
                            <div class="stat-number">120</div>
                            <div class="stat-label">B.E. Intake</div>
                        </div>
                        <div class="dept-stat-box">
                            <div class="stat-number">18</div>
                            <div class="stat-label">M.E. Intake</div>
                        </div>
                        <div class="dept-stat-box">
                            <div class="stat-number">10</div>
                            <div class="stat-label">Advanced Labs</div>
                        </div>
                        <div class="dept-stat-box">
                            <div class="stat-number">250+</div>
                            <div class="stat-label">Network Nodes</div>
                        </div>
                    </div>

                    <p class="dept-text-body">
                        This department is running from 2001. The staff has developed required laboratories in the areas like Computer Hardware, Computer Networking &amp; Security, Database Management System, Computer Graphics and Internet Technology in tune with real-time systems.
                    </p>

                    <p class="dept-text-body">
                        The Internet access is provided to the students to update their knowledge in various fields. Currently, a project under AICTE Grant for Campus Networking is under process. The Computer Department is equipped with around 100+ computers with multimedia software and LAN Systems with Internet connection.
                    </p>

                    <p class="dept-text-body">
                        The Department has purchased Latest Computer Servers and Network-based online teaching system software named Content Server. The department is sharing all infrastructural facilities of Information Technology Department. The laboratories in the department are well developed to cater needs of the students. Department is also offering Post Graduate course in Computer Science &amp; Engineering since 2010.
                    </p>

                    <p class="dept-text-body">
                        Computer Engineering and Information Technology department run in a newly constructed, well-furnished building. The main strength of the department is highly qualified and well-experienced faculties. Also, the department is well equipped with an ample number of computer systems, networking of more than 250 nodes and required software and hardware. Department has well equipped 10 computer laboratories and two seminar halls. Campus Wide Network of college is handled by the department with 30 Wi-Fi access points with 1 controller. It has High-End Servers available for various activities.
                    </p>

                    <!-- About the Programme Section -->
                    <div class="content-section-title">
                        <i class="fas fa-graduation-cap"></i>
                        <span>About the Programme</span>
                    </div>

                    <p class="dept-text-body">
                        Computer engineering blends together computer science and electrical engineering to further advancements in digital technology, computer networking, and computer systems. In turn, computer engineers use their extensive knowledge of hardware and software design and computer programming to make computing platforms and applications more efficient and effective. Seamlessly integrating the latest innovations, computer engineers develop new computer hardware, design and implement software applications, and enhance the capabilities of networks and communications systems.
                    </p>

                    <p class="dept-text-body">
                        Computer engineers work with hardware and software, ensuring that the two are seamlessly integrated and functioning properly. Computer engineers focus on innovation—making computing systems safer, faster and more powerfull. At the career level, there are two main avenues: hardware and software engineering. Hardware engineers focus their skills on computer systems and components, designing microprocessors, circuit boards, routers and other embedded devices. On the software side, these engineers create, test and debug programs and applications that run on computers, mobile devices and more.
                    </p>

                    <!-- Under Graduate/Post Graduate Courses Table Card -->
                    <div class="courses-card">
                        <div class="courses-card-header">
                            <i class="fas fa-bars"></i>
                            <span>Under Graduate/Post Graduate Courses</span>
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table">
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
                                        <td><span class="type-badge ug">UG</span></td>
                                        <td>4</td>
                                        <td>120</td>
                                        <td>2001</td>
                                    </tr>
                                    <tr>
                                        <td>Computer Engineering (Software Engineering)</td>
                                        <td><span class="type-badge pg">PG</span></td>
                                        <td>2</td>
                                        <td>18</td>
                                        <td>2010</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     2. VISION & MISSION TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-vision-mission">
                    <div class="tab-header">
                        <div class="tab-header-icon"><i class="fas fa-bullseye"></i></div>
                        <div>
                            <h2 class="tab-title">Vision &amp; Mission</h2>
                            <p class="tab-subtitle">Department of Computer Engineering &bull; GEC Modasa</p>
                        </div>
                    </div>

                    <div class="content-section-title">
                        <i class="fas fa-eye"></i>
                        <span>Department Vision</span>
                    </div>

                    <div class="vision-card">
                        <i class="fas fa-quote-right quote-icon"></i>
                        <p>
                            To become a prominent department producing competent professionals with research, innovation and entrepreneurial skills, inculcating moral values and societal concerns.
                        </p>
                    </div>

                    <div class="content-section-title">
                        <i class="fas fa-bullseye"></i>
                        <span>Department Mission</span>
                    </div>

                    <div class="mission-grid">
                        <div class="mission-item">
                            <div class="mission-icon"><i class="fas fa-code"></i></div>
                            <p>To create globally competent students having ability to design, develop and test world class software, keeping pace with the latest technological developments.</p>
                        </div>
                        <div class="mission-item">
                            <div class="mission-icon"><i class="fas fa-atom"></i></div>
                            <p>Create facilities and expertise in advanced computer technology thereby promote research.</p>
                        </div>
                        <div class="mission-item">
                            <div class="mission-icon"><i class="fas fa-handshake"></i></div>
                            <p>Enhance Industry Institute Interaction programme to get acquainted with corporate culture.</p>
                        </div>
                        <div class="mission-item">
                            <div class="mission-icon"><i class="fas fa-heart"></i></div>
                            <p>Induce moral, ethical values and spirit of social commitment.</p>
                        </div>
                    </div>

                    <!-- PEOs Banner Card -->
                    <div class="peo-card">
                        <div class="peo-card-header">
                            <i class="fas fa-bars"></i>
                            <span>Program Educational Objectives (PEOs)</span>
                        </div>
                        <div class="peo-card-body">
                            <div class="peo-intro">Graduates will:</div>
                            <ul class="peo-list">
                                <li>
                                    <strong>PEO 1:</strong> Establish themselves as successful professionals in computer engineering or allied fields.
                                </li>
                                <li>
                                    <strong>PEO 2:</strong> Pursue lifelong learning, higher education, research and adapt to evolving technologies.
                                </li>
                                <li>
                                    <strong>PEO 3:</strong> Practice professional ethics, leadership qualities, and contribute responsibly to societal development.
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     3. SYLLABUS TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-syllabus">
                    <div class="tab-header">
                        <div class="tab-header-icon"><i class="fas fa-book-reader"></i></div>
                        <div>
                            <h2 class="tab-title">Syllabus &amp; Curriculum</h2>
                            <p class="tab-subtitle">GTU Curriculum &bull; NEP / AICTE Aligned</p>
                        </div>
                    </div>

                    <p class="dept-text-body">
                        The curriculum of Bachelor of Engineering (Computer Engineering) follows Gujarat Technological University (GTU) guidelines aligned with the National Education Policy (NEP) and AICTE model curriculum.
                    </p>

                    <div class="syllabus-table-wrapper">
                        <table class="syllabus-table">
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
                                    <td>GTU NEP</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-file-pdf"></i> View Syllabus</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester III</strong></td>
                                    <td>Data Structures, Digital Fundamentals, Database Management Systems, Discrete Mathematics</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-file-pdf"></i> View Syllabus</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester IV</strong></td>
                                    <td>Operating Systems, Object Oriented Programming with Java, Computer Organization, Principles of Economics</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-file-pdf"></i> View Syllabus</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester V</strong></td>
                                    <td>Computer Networks, Software Engineering, Design &amp; Analysis of Algorithms, Professional Elective I</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-file-pdf"></i> View Syllabus</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester VI</strong></td>
                                    <td>Theory of Computation, Web Technology, Advanced Java / Python, Cyber Security, Professional Elective II</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-file-pdf"></i> View Syllabus</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester VII</strong></td>
                                    <td>Artificial Intelligence &amp; Machine Learning, Cloud Computing, Compiler Design, Project - I</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-file-pdf"></i> View Syllabus</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester VIII</strong></td>
                                    <td>Big Data Analytics / Internet of Things, Major Project / Full Semester Industry Internship</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-file-pdf"></i> View Syllabus</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- ========================================================
                     4. FACULTY TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-faculty">
                    <div class="tab-header">
                        <div class="tab-header-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div>
                            <h2 class="tab-title">Faculty Members</h2>
                            <p class="tab-subtitle">Dedicated Academicians &amp; Research Supervisors</p>
                        </div>
                    </div>

                    <p class="dept-text-body">
                        The Computer Engineering department possesses highly qualified, experienced, and dedicated teaching faculty members with specializations across diverse domains.
                    </p>

                    <div class="faculty-grid">
                        <div class="faculty-card">
                            <div class="faculty-avatar"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Dr. H. M. Patel</h4>
                            <div class="faculty-role">Head of Department</div>
                            <div class="faculty-qual">Ph.D., M.Tech (Computer Engineering)</div>
                            <p style="font-size: 0.85rem; color: #475569;">Specialization: Cloud Computing &amp; Distributed Systems</p>
                            <div class="faculty-contact"><i class="fas fa-envelope"></i> hod_ce@gecmodasa.ac.in</div>
                        </div>

                        <div class="faculty-card">
                            <div class="faculty-avatar"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. A. S. Shah</h4>
                            <div class="faculty-role">Associate Professor</div>
                            <div class="faculty-qual">Ph.D. (Pursuing), M.E. (Computer Engg)</div>
                            <p style="font-size: 0.85rem; color: #475569;">Specialization: Information Security &amp; Cryptography</p>
                            <div class="faculty-contact"><i class="fas fa-envelope"></i> asshah@gecmodasa.ac.in</div>
                        </div>

                        <div class="faculty-card">
                            <div class="faculty-avatar"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. R. K. Prajapati</h4>
                            <div class="faculty-role">Assistant Professor</div>
                            <div class="faculty-qual">M.E. (Computer Science &amp; Engg)</div>
                            <p style="font-size: 0.85rem; color: #475569;">Specialization: Database Management &amp; Data Mining</p>
                            <div class="faculty-contact"><i class="fas fa-envelope"></i> rkprajapati@gecmodasa.ac.in</div>
                        </div>

                        <div class="faculty-card">
                            <div class="faculty-avatar"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. P. N. Mehta</h4>
                            <div class="faculty-role">Assistant Professor</div>
                            <div class="faculty-qual">M.Tech (Software Engineering)</div>
                            <p style="font-size: 0.85rem; color: #475569;">Specialization: Artificial Intelligence &amp; Deep Learning</p>
                            <div class="faculty-contact"><i class="fas fa-envelope"></i> pnmehta@gecmodasa.ac.in</div>
                        </div>

                        <div class="faculty-card">
                            <div class="faculty-avatar"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. S. D. Joshi</h4>
                            <div class="faculty-role">Assistant Professor</div>
                            <div class="faculty-qual">M.E. (Computer Engineering)</div>
                            <p style="font-size: 0.85rem; color: #475569;">Specialization: Computer Networks &amp; IoT</p>
                            <div class="faculty-contact"><i class="fas fa-envelope"></i> sdjoshi@gecmodasa.ac.in</div>
                        </div>

                        <div class="faculty-card">
                            <div class="faculty-avatar"><i class="fas fa-user-tie"></i></div>
                            <h4 class="faculty-name">Prof. M. B. Patel</h4>
                            <div class="faculty-role">Assistant Professor</div>
                            <div class="faculty-qual">M.Tech (Information Technology)</div>
                            <p style="font-size: 0.85rem; color: #475569;">Specialization: Full Stack Web Development &amp; DevOps</p>
                            <div class="faculty-contact"><i class="fas fa-envelope"></i> mbpatel@gecmodasa.ac.in</div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     5. ACTIVITIES TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-activities">
                    <div class="tab-header">
                        <div class="tab-header-icon"><i class="fas fa-calendar-alt"></i></div>
                        <div>
                            <h2 class="tab-title">Department Activities</h2>
                            <p class="tab-subtitle">Workshops, Hackathons, Expert Talks &amp; Field Visits</p>
                        </div>
                    </div>

                    <p class="dept-text-body">
                        The department regularly organizes workshops, hackathons, expert lectures by industry leaders, and technical competitions under the banner of the Computer Society of India (CSI) and student developer clubs.
                    </p>

                    <div class="lab-grid">
                        <div class="lab-card">
                            <h4><i class="fas fa-laptop-code"></i> CodeFest &amp; Hackathons</h4>
                            <p>Annual 24-hour inter-college coding marathon encouraging students to develop innovative software solutions for real-world governance and industrial problems.</p>
                        </div>
                        <div class="lab-card">
                            <h4><i class="fas fa-chalkboard-teacher"></i> Expert Lectures &amp; Webinars</h4>
                            <p>Industry professionals from MNCs deliver interactive sessions on Cloud Architecture, Cyber Forensics, DevOps, and Full-Stack Development.</p>
                        </div>
                        <div class="lab-card">
                            <h4><i class="fas fa-industry"></i> Industrial Visits</h4>
                            <p>Educational visits to prestigious organizations such as BISAG-N Gandhinagar, TCS Garima Park, and ISRO Space Applications Centre (SAC).</p>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     6. FACILITIES TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-facilities">
                    <div class="tab-header">
                        <div class="tab-header-icon"><i class="fas fa-network-wired"></i></div>
                        <div>
                            <h2 class="tab-title">Laboratories &amp; Facilities</h2>
                            <p class="tab-subtitle">State-of-the-Art Computing Infrastructure</p>
                        </div>
                    </div>

                    <p class="dept-text-body">
                        The department is equipped with 10 state-of-the-art computer laboratories with over 250 high-end networked systems, dedicated servers, and high-speed campus-wide Wi-Fi access.
                    </p>

                    <div class="lab-grid">
                        <div class="lab-card">
                            <h4><i class="fas fa-desktop"></i> Programming &amp; Algorithms Lab</h4>
                            <p>Equipped with modern Linux and Windows environments for C, C++, Data Structures, and Algorithm analysis experiments.</p>
                        </div>
                        <div class="lab-card">
                            <h4><i class="fas fa-database"></i> Database Management Systems Lab</h4>
                            <p>Configured with Oracle, MySQL, MongoDB, and PostgreSQL for backend architecture design and query optimization.</p>
                        </div>
                        <div class="lab-card">
                            <h4><i class="fas fa-network-wired"></i> Networking &amp; Security Lab</h4>
                            <p>Equipped with Cisco routers, managed switches, Wireshark packet analyzers, and cyber security simulation testbeds.</p>
                        </div>
                        <div class="lab-card">
                            <h4><i class="fas fa-brain"></i> AI &amp; Machine Learning Lab</h4>
                            <p>High-end GPU-accelerated computing systems dedicated to Artificial Intelligence, Deep Learning, and Computer Vision research.</p>
                        </div>
                        <div class="lab-card">
                            <h4><i class="fas fa-server"></i> Central Server Room</h4>
                            <p>High-performance rack servers hosting institute websites, student portal, proxy, and network firewall controllers.</p>
                        </div>
                        <div class="lab-card">
                            <h4><i class="fas fa-users"></i> Department Seminar Halls</h4>
                            <p>Two air-conditioned seminar halls with digital podiums, surround sound, and HD projection facilities for workshops.</p>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     7. PUBLICATIONS TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-publications">
                    <div class="tab-header">
                        <div class="tab-header-icon"><i class="fas fa-file-alt"></i></div>
                        <div>
                            <h2 class="tab-title">Research &amp; Publications</h2>
                            <p class="tab-subtitle">Peer-Reviewed Journals, Patents &amp; Conference Papers</p>
                        </div>
                    </div>

                    <p class="dept-text-body">
                        Faculties and students of the Computer Engineering department actively publish research articles in peer-reviewed Scopus-indexed and UGC-CARE approved international journals and conferences.
                    </p>

                    <div class="syllabus-table-wrapper">
                        <table class="syllabus-table">
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
                <section class="dept-tab-content" id="tab-advisory-board">
                    <div class="tab-header">
                        <div class="tab-header-icon"><i class="fas fa-handshake"></i></div>
                        <div>
                            <h2 class="tab-title">Industry Advisory Board (IAB)</h2>
                            <p class="tab-subtitle">Bridging Academia with Corporate Leadership</p>
                        </div>
                    </div>

                    <p class="dept-text-body">
                        The Industry Advisory Board bridges the gap between academic curriculum and current industry demands. Comprising senior corporate leaders, entrepreneurs, and academic stalwarts, the board reviews syllabi and project quality periodically.
                    </p>

                    <div class="lab-grid">
                        <div class="lab-card">
                            <h4><i class="fas fa-building"></i> Industry Representatives</h4>
                            <p style="margin-bottom: 6px;"><strong>Mr. J. K. Sharma</strong> &bull; VP Engineering, TCS</p>
                            <p style="margin-bottom: 6px;"><strong>Mr. Sameer Desai</strong> &bull; Technical Director, L&amp;T Infotech</p>
                            <p><strong>Ms. Neha Trivedi</strong> &bull; Senior Architect, Infosys</p>
                        </div>
                        <div class="lab-card">
                            <h4><i class="fas fa-bullseye"></i> Key Board Objectives</h4>
                            <p style="margin-bottom: 6px;">&bull; Align GTU curriculum with market technologies (Cloud, GenAI, DevOps).</p>
                            <p style="margin-bottom: 6px;">&bull; Facilitate semester-long industry internships and live capstone projects.</p>
                            <p>&bull; Facilitate campus recruitment drives and corporate mentoring.</p>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     9. NEWS LETTERS TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-newsletters">
                    <div class="tab-header">
                        <div class="tab-header-icon"><i class="fas fa-newspaper"></i></div>
                        <div>
                            <h2 class="tab-title">Department Newsletters</h2>
                            <p class="tab-subtitle">Biannual Departmental Chronicle "COMP-CONNECT"</p>
                        </div>
                    </div>

                    <p class="dept-text-body">
                        The biannual departmental newsletter <strong>"COMP-CONNECT"</strong> chronicles academic achievements, faculty publications, student awards, and technological developments within the department.
                    </p>

                    <div class="syllabus-table-wrapper">
                        <table class="syllabus-table">
                            <thead>
                                <tr>
                                    <th>Volume &amp; Issue</th>
                                    <th>Period</th>
                                    <th>Theme Highlights</th>
                                    <th>Newsletter</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>COMP-CONNECT Vol. 8</strong></td>
                                    <td>Jan 2024 - June 2024</td>
                                    <td>AI Advancements, Hackathon Achievements &amp; Placements</td>
                                    <td><a href="#" class="btn-download"><i class="fas fa-file-pdf"></i> Read Edition</a></td>
                                </tr>
                                <tr>
                                    <td><strong>COMP-CONNECT Vol. 7</strong></td>
                                    <td>July 2023 - Dec 2023</td>
                                    <td>Cloud Architecture Workshop &amp; Alumni Interactions</td>
                                    <td><a href="#" class="btn-download"><i class="fas fa-file-pdf"></i> Read Edition</a></td>
                                </tr>
                                <tr>
                                    <td><strong>COMP-CONNECT Vol. 6</strong></td>
                                    <td>Jan 2023 - June 2023</td>
                                    <td>National Tech-Fest Winner Edition</td>
                                    <td><a href="#" class="btn-download"><i class="fas fa-file-pdf"></i> Read Edition</a></td>
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
