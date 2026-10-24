<?php
// Set Page Variables
$page_title = "Computer Engineering Department - Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../";
$extra_css = "departments/css/department.css";
$extra_js = "departments/js/department.js";

// Include Header
include_once __DIR__ . '/../includes/header.php';
?>

<!-- ========================================================
     Main Department Section (Authentic Institutional Layout)
     ======================================================== -->
<div class="dept-page-wrapper">
    <div class="container">
        <div class="dept-layout-grid">

            <!-- Left Sidebar Navigation -->
            <aside class="dept-sidebar">
                <div class="dept-sidebar-header">
                    Computer Department
                </div>
                <ul class="dept-sidebar-menu">
                    <li class="active">
                        <a class="dept-nav-link active" data-tab="about">About Department</a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="vision-mission">Vision &amp; Mission</a>
                    </li>
                    <li>
                        <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="dept-nav-link">
                            <span>Syllabus</span>
                            <i class="fas fa-external-link-alt arrow-icon"></i>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="faculty">Faculty</a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="activities">Activities</a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="facilities">Facilities</a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="publications">Publications</a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="advisory-board">
                            <span>Industry Advisory Board</span>
                            <i class="fas fa-angle-right arrow-icon"></i>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="newsletters">
                            <span>News Letters</span>
                            <i class="fas fa-angle-right arrow-icon"></i>
                        </a>
                    </li>
                </ul>
            </aside>

            <!-- Right Content Area -->
            <main class="dept-content-panel">



                <!-- ========================================================
                     1. ABOUT DEPARTMENT TAB
                     ======================================================== -->
                <section class="dept-tab-content active" id="tab-about">
                    <div class="dept-divider-title">About Department</div>

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
                    <div class="dept-divider-title">About the Programme</div>

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
                                        <td>UG</td>
                                        <td>4</td>
                                        <td>120</td>
                                        <td>2001</td>
                                    </tr>
                                    <tr>
                                        <td>Computer Engineering (Software Engineering)</td>
                                        <td>PG</td>
                                        <td>2</td>
                                        <td>18</td>
                                        <td>2010</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Facilities Section below Courses Table -->
                    <div class="dept-divider-title">Facilities</div>

                    <div class="dept-facilities-dual-grid">
                        <ul class="facility-items-list">
                            <li><i class="fas fa-chevron-circle-right"></i><span>Wi-Fi enabled Department</span></li>
                            <li><i class="fas fa-chevron-circle-right"></i><span>System Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right"></i><span>Programming Language Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right"></i><span>Digital Logic Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right"></i><span>Seminar Halls</span></li>
                        </ul>
                        <ul class="facility-items-list">
                            <li><i class="fas fa-chevron-circle-right"></i><span>Campus Wide Fiber Optic Cable Network</span></li>
                            <li><i class="fas fa-chevron-circle-right"></i><span>Network Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right"></i><span>DBMS Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right"></i><span>Operating System Lab</span></li>
                            <li><i class="fas fa-chevron-circle-right"></i><span>Digital Learning Lab</span></li>
                        </ul>
                    </div>
                </section>

                <!-- ========================================================
                     2. VISION & MISSION TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-vision-mission">
                    <div class="dept-divider-title">Vision</div>

                    <p class="dept-text-body">
                        To become a prominent department producing competent professionals with research, innovation and entrepreneurial skills, inculcating moral values and societal concerns.
                    </p>

                    <div class="dept-divider-title">Mission</div>

                    <ul class="mission-bullet-list">
                        <li>To create globally competent students having ability to design, develop and test world class software, keeping pace with the latest technological developments.</li>
                        <li>Create facilities and expertise in advanced computer technology thereby promote research.</li>
                        <li>Enhance Industry Institute Interaction programme to get acquainted with corporate culture.</li>
                        <li>Induce moral , ethical values and spirit of social commitment.</li>
                    </ul>

                    <!-- Program Educational Objectives PEOs Card -->
                    <div class="peo-card">
                        <div class="peo-card-header">
                            <i class="fas fa-server"></i>
                            <span>Program Educational Objectives PEOs</span>
                        </div>
                        <div class="peo-card-intro">
                            Graduates will
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table peo-table">
                                <tbody>
                                    <tr>
                                        <td class="peo-label">PEO1</td>
                                        <td>Be an efficient Software developer in diverse fields and will be a successful professional and/or pursue higher studies.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-label">PEO2</td>
                                        <td>be capable to adapt advanced state of the art computing technology for professional excellence and Research and be a lifelong learner.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-label">PEO3</td>
                                        <td>Work productively exhibiting ethical qualities for the betterment of society.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-label">PEO4</td>
                                        <td>Possess leadership and entrepreneurial qualities, work harmoniously as a team member with effective communication skills.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Program Specific Outcomes PSOs Card -->
                    <div class="peo-card">
                        <div class="peo-card-header">
                            <i class="fas fa-server"></i>
                            <span>Program Specific Outcomes PSOs</span>
                        </div>
                        <div class="peo-card-intro">
                            Computer Engineering Graduate will be able to:
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table peo-table">
                                <tbody>
                                    <tr>
                                        <td class="peo-label">PSO1</td>
                                        <td>Gain capability to use current / advanced technology, skills and tools necessary for carrying out Real- World Multidisciplinary projects.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-label">PSO2</td>
                                        <td>Achieve an ability to build a computer based system, process or a component that meets the desired needs.</td>
                                    </tr>
                                    <tr>
                                        <td class="peo-label">PSO3</td>
                                        <td>Apply concepts of core areas of Computer Engineering– Data Structures, Database Management Systems, Operating Systems, Computer Architecture and Software Engineering to provide innovative solution.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>



                <!-- ========================================================
                     4. FACULTY TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-faculty">
                    <div class="dept-divider-title">Faculty</div>

                    <p class="dept-text-body">
                        The Computer Engineering department possesses highly qualified, experienced, and dedicated teaching faculty members with specializations across diverse domains.
                    </p>

                    <div class="faculty-simple-grid">
                        <div class="faculty-simple-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h5>Dr. H. M. Patel</h5>
                            <div class="desig">Head of Department</div>
                            <div class="qual">Ph.D., M.Tech (Computer Engg)</div>
                            <div class="email"><i class="fas fa-envelope"></i> hod_ce@gecmodasa.ac.in</div>
                        </div>

                        <div class="faculty-simple-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h5>Prof. A. S. Shah</h5>
                            <div class="desig">Associate Professor</div>
                            <div class="qual">Ph.D. (Pursuing), M.E. (Computer Engg)</div>
                            <div class="email"><i class="fas fa-envelope"></i> asshah@gecmodasa.ac.in</div>
                        </div>

                        <div class="faculty-simple-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h5>Prof. R. K. Prajapati</h5>
                            <div class="desig">Assistant Professor</div>
                            <div class="qual">M.E. (Computer Science &amp; Engg)</div>
                            <div class="email"><i class="fas fa-envelope"></i> rkprajapati@gecmodasa.ac.in</div>
                        </div>

                        <div class="faculty-simple-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h5>Prof. P. N. Mehta</h5>
                            <div class="desig">Assistant Professor</div>
                            <div class="qual">M.Tech (Software Engineering)</div>
                            <div class="email"><i class="fas fa-envelope"></i> pnmehta@gecmodasa.ac.in</div>
                        </div>

                        <div class="faculty-simple-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h5>Prof. S. D. Joshi</h5>
                            <div class="desig">Assistant Professor</div>
                            <div class="qual">M.E. (Computer Engineering)</div>
                            <div class="email"><i class="fas fa-envelope"></i> sdjoshi@gecmodasa.ac.in</div>
                        </div>

                        <div class="faculty-simple-card">
                            <div class="faculty-avatar-box"><i class="fas fa-user-tie"></i></div>
                            <h5>Prof. M. B. Patel</h5>
                            <div class="desig">Assistant Professor</div>
                            <div class="qual">M.Tech (Information Technology)</div>
                            <div class="email"><i class="fas fa-envelope"></i> mbpatel@gecmodasa.ac.in</div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     5. ACTIVITIES TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-activities">
                    <div class="dept-divider-title">Activities</div>

                    <p class="dept-text-body">
                        The department regularly organizes workshops, hackathons, expert lectures by industry leaders, and technical competitions under the banner of student developer clubs and societies.
                    </p>

                    <div class="labs-simple-grid">
                        <div class="lab-simple-item">
                            <h5><i class="fas fa-laptop-code"></i> CodeFest &amp; Hackathons</h5>
                            <p>Annual inter-college coding marathon encouraging students to develop innovative software solutions for real-world governance and industrial problems.</p>
                        </div>
                        <div class="lab-simple-item">
                            <h5><i class="fas fa-chalkboard-teacher"></i> Expert Lectures &amp; Webinars</h5>
                            <p>Industry professionals deliver interactive sessions on Cloud Architecture, Cyber Forensics, DevOps, and Full-Stack Development.</p>
                        </div>
                        <div class="lab-simple-item">
                            <h5><i class="fas fa-industry"></i> Industrial Visits</h5>
                            <p>Educational visits to organizations such as BISAG-N Gandhinagar, TCS Garima Park, and ISRO Space Applications Centre.</p>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     6. FACILITIES TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-facilities">
                    <!-- Clean Minimal Subtabs -->
                    <div class="facility-tabs-bar">
                        <button type="button" class="facility-tab-link active" data-subtab="labs">Laboratories</button>
                        <button type="button" class="facility-tab-link" data-subtab="seminar">Seminar Room</button>
                        <button type="button" class="facility-tab-link" data-subtab="server">Server Room</button>
                    </div>

                    <!-- ================= SUBTAB 1: LABORATORIES ================= -->
                    <div class="facility-pane active" id="subtab-labs">
                        <p class="facility-lead-text">
                            There are total 10 laboratories in the department for performing practical in various domains like Computer Programming, Computer Graphics, Networking, Database Management, Operating Systems, Artificial Intelligence, etc. Department has a separate laboratory for computer hardware subjects.
                        </p>

                        <div class="facility-labs-list">

                            <!-- Lab 1: 8112 Project Lab (Text Left, Photo Right) -->
                            <div class="lab-row">
                                <div class="lab-info">
                                    <h3 class="lab-name">8112 Project Lab</h3>
                                    <p class="lab-description">
                                        The project lab has number of computers. This lab is dedicatedly used for project and design engineering subject. Students can perform their project related work. Sufficient number of PC, laptop points and other required infrastructure is available in this lab.
                                    </p>
                                </div>
                                <div class="lab-media">
                                    <div class="lab-photo-frame">
                                        <img src="images/labs/lab_8112_project.jpg" alt="8112 Project Lab" class="lab-photo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="lab-photo-placeholder" style="display: none;">
                                            <span>Photo Space</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Lab 2: 8113 Programming Lab - 1 (Photo Left, Text Right) -->
                            <div class="lab-row lab-row-reverse">
                                <div class="lab-info">
                                    <h3 class="lab-name">8113 Programming Lab - 1</h3>
                                    <p class="lab-description">
                                        The department is having programming lab for students where they can perform their experiments. This lab contains number of Computers with Internet connection. This lab is dedicatedly used for subjects such as DBMS, OS, CG, CoS, SE, Compiler Design and Python.
                                    </p>
                                </div>
                                <div class="lab-media">
                                    <div class="lab-photo-frame">
                                        <img src="images/labs/lab_8113_programming1.jpg" alt="8113 Programming Lab - 1" class="lab-photo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="lab-photo-placeholder" style="display: none;">
                                            <span>Photo Space</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Lab 3: 8115 Hardware Lab (Text Left, Photo Right) -->
                            <div class="lab-row">
                                <div class="lab-info">
                                    <h3 class="lab-name">8115 Hardware Lab</h3>
                                    <p class="lab-description">
                                        The department is having programming lab for students where they can perform their experiments. This lab contains number of Computers with Internet connection. This lab is dedicatedly used for hardware related subjects such as digital fundamentals, COA, CN, Blockchain and IoT.
                                    </p>
                                </div>
                                <div class="lab-media">
                                    <div class="lab-photo-frame">
                                        <img src="images/labs/lab_8115_hardware.jpg" alt="8115 Hardware Lab" class="lab-photo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="lab-photo-placeholder" style="display: none;">
                                            <span>Photo Space</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Lab 4: 8116 PPS Lab - 2 (Photo Left, Text Right) -->
                            <div class="lab-row lab-row-reverse">
                                <div class="lab-info">
                                    <h3 class="lab-name">8116 PPS Lab - 2</h3>
                                    <p class="lab-description">
                                        The department is having Programming for Problem Solving lab for students where they can perform their PPS experiments. This lab contains number of Computers with Internet connection.
                                    </p>
                                </div>
                                <div class="lab-media">
                                    <div class="lab-photo-frame">
                                        <img src="images/labs/lab_8116_pps2.jpg" alt="8116 PPS Lab - 2" class="lab-photo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="lab-photo-placeholder" style="display: none;">
                                            <span>Photo Space</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Lab 5: 8117 Programming Lab - 3 (Text Left, Photo Right) -->
                            <div class="lab-row">
                                <div class="lab-info">
                                    <h3 class="lab-name">8117 Programming Lab - 3</h3>
                                    <p class="lab-description">
                                        The department is having programming lab for students where they can perform their experiments. This lab contains number of Computers with Internet connection. This lab is dedicatedly used for software/hardware related subjects such as .Net, MCWC and cloud computing.
                                    </p>
                                </div>
                                <div class="lab-media">
                                    <div class="lab-photo-frame">
                                        <img src="images/labs/lab_8117_programming3.jpg" alt="8117 Programming Lab - 3" class="lab-photo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="lab-photo-placeholder" style="display: none;">
                                            <span>Photo Space</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ================= SUBTAB 2: SEMINAR ROOM ================= -->
                    <div class="facility-pane" id="subtab-seminar">
                        <div class="lab-row">
                            <div class="lab-info">
                                <h3 class="lab-name">Seminar Room</h3>
                                <p class="lab-description">
                                    The department has a dedicated Seminar Room equipped with modern audio-visual presentation systems, LCD projector, and public address system. It is utilized for departmental seminars, workshops, expert lectures, student presentations, and group discussions.
                                </p>
                            </div>
                            <div class="lab-media">
                                <div class="lab-photo-frame">
                                    <img src="images/labs/seminar_room.jpg" alt="Seminar Room" class="lab-photo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="lab-photo-placeholder">
                                        <span>Photo Space (Seminar Room)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= SUBTAB 3: SERVER ROOM ================= -->
                    <div class="facility-pane" id="subtab-server">
                        <div class="lab-row">
                            <div class="lab-info">
                                <h3 class="lab-name">Server Room</h3>
                                <p class="lab-description">
                                    The department features a centralized Server Room maintaining high-capacity servers, network racks, managed switches, and centralized firewall systems. It provides network management, proxy services, academic software licenses, and high-speed internet connectivity across all laboratories.
                                </p>
                            </div>
                            <div class="lab-media">
                                <div class="lab-photo-frame">
                                    <img src="images/labs/server_room.jpg" alt="Server Room" class="lab-photo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="lab-photo-placeholder">
                                        <span>Photo Space (Server Room)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     7. PUBLICATIONS TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-publications">
                    <div class="dept-divider-title">Publications</div>

                    <p class="dept-text-body">
                        Faculties and students of the Computer Engineering department actively publish research articles in peer-reviewed journals and conferences.
                    </p>

                    <div class="courses-card">
                        <div class="courses-card-header">
                            <i class="fas fa-bars"></i>
                            <span>Recent Research Publications</span>
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table">
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
                    </div>
                </section>

                <!-- ========================================================
                     8. INDUSTRY ADVISORY BOARD TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-advisory-board">
                    <div class="dept-divider-title">Industry Advisory Board</div>

                    <p class="dept-text-body">
                        The Industry Advisory Board bridges the gap between academic curriculum and current industry demands, reviewing syllabi and capstone projects periodically.
                    </p>

                    <div class="labs-simple-grid">
                        <div class="lab-simple-item">
                            <h5>Industry Leaders &amp; Advisors</h5>
                            <p style="margin-bottom: 6px;"><strong>Mr. J. K. Sharma</strong> &bull; VP Engineering, TCS</p>
                            <p style="margin-bottom: 6px;"><strong>Mr. Sameer Desai</strong> &bull; Technical Director, L&amp;T Infotech</p>
                            <p><strong>Ms. Neha Trivedi</strong> &bull; Senior Architect, Infosys</p>
                        </div>
                        <div class="lab-simple-item">
                            <h5>Key Board Objectives</h5>
                            <p style="margin-bottom: 6px;">&bull; Align GTU curriculum with market technologies.</p>
                            <p style="margin-bottom: 6px;">&bull; Facilitate semester-long industry internships and capstone projects.</p>
                            <p>&bull; Facilitate campus placement drives and corporate mentoring.</p>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     9. NEWS LETTERS TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-newsletters">
                    <div class="dept-divider-title">News Letters</div>

                    <p class="dept-text-body">
                        The biannual departmental newsletter <strong>"COMP-CONNECT"</strong> chronicles academic achievements, faculty publications, student awards, and technological developments.
                    </p>

                    <div class="courses-card">
                        <div class="courses-card-header">
                            <i class="fas fa-bars"></i>
                            <span>Departmental Newsletters</span>
                        </div>
                        <div class="courses-table-wrapper">
                            <table class="courses-table">
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
                                        <td><a href="#" class="btn-action-simple"><i class="fas fa-file-pdf"></i> Read</a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>COMP-CONNECT Vol. 7</strong></td>
                                        <td>July 2023 - Dec 2023</td>
                                        <td>Cloud Architecture Workshop &amp; Alumni Interactions</td>
                                        <td><a href="#" class="btn-action-simple"><i class="fas fa-file-pdf"></i> Read</a></td>
                                    </tr>
                                    <tr>
                                        <td><strong>COMP-CONNECT Vol. 6</strong></td>
                                        <td>Jan 2023 - June 2023</td>
                                        <td>National Tech-Fest Winner Edition</td>
                                        <td><a href="#" class="btn-action-simple"><i class="fas fa-file-pdf"></i> Read</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

            </main>
        </div>
    </div>
</div>

<?php
// Include Footer
include_once __DIR__ . '/../includes/footer.php';
?>
