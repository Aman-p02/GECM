<?php
// Set Page Variables
$page_title = "Computer Engineering Department - Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/css/department.css";
$extra_js = "departments/js/department.js";

// Include Header
include_once __DIR__ . '/../../includes/header.php';
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
                    <li class="dept-sidebar-dropdown" id="sidebar-iab">
                        <div class="dept-dropdown-header" role="button" tabindex="0">
                            <span>Industry Advisory Board</span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </div>
                        <ul class="dept-sub-menu">
                            <li>
                                <a class="dept-sub-link" data-tab="iab-2025-26" href="#iab-2025-26">IAB 2025-26</a>
                            </li>
                            <li>
                                <a class="dept-sub-link" data-tab="iab-2023-24" href="#iab-2023-24">IAB 2023-24</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dept-sidebar-dropdown" id="sidebar-newsletters">
                        <div class="dept-dropdown-header" role="button" tabindex="0">
                            <span>News Letters</span>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </div>
                        <ul class="dept-sub-menu">
                            <li>
                                <a class="dept-sub-link" data-tab="nl-vol1-issue2" href="#nl-vol1-issue2">Vol. 1 Issue 2</a>
                            </li>
                            <li>
                                <a class="dept-sub-link" data-tab="nl-vol1-issue1" href="#nl-vol1-issue1">Vol. 1 Issue 1</a>
                            </li>
                        </ul>
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
                    <!-- Modern Minimal Segmented Tabs -->
                    <div class="facility-tabs-container">
                        <div class="facility-segmented-tabs" role="tablist">
                            <button type="button" class="facility-tab-btn active" data-subtab="labs" role="tab">
                                <span>Laboratories</span>
                                <span class="tab-count-badge">5</span>
                            </button>
                            <button type="button" class="facility-tab-btn" data-subtab="seminar" role="tab">
                                <span>Seminar Room</span>
                            </button>
                            <button type="button" class="facility-tab-btn" data-subtab="server" role="tab">
                                <span>Server Room</span>
                            </button>
                        </div>
                    </div>

                    <!-- ================= SUBTAB 1: LABORATORIES ================= -->
                    <div class="facility-pane active" id="subtab-labs">
                        <p class="facility-lead-intro">
                            There are total 10 laboratories in the department for performing practical in various domains like Computer Programming, Computer Graphics, Networking, Database Management, Operating Systems, Artificial Intelligence, etc. Department has a separate laboratory for computer hardware subjects.
                        </p>

                        <div class="modern-labs-stack">

                            <!-- Lab 1: 8112 Project Lab -->
                            <article class="modern-lab-card">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8112_project.jpg" alt="8112 Project Lab" class="modern-photo-img" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="modern-photo-placeholder" style="display: none;">
                                        <span>Photo Space</span>
                                    </div>
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8112</span>
                                    <h3 class="modern-lab-title">Project Lab</h3>
                                    <p class="modern-lab-text">
                                        The project lab has number of computers. This lab is dedicatedly used for project and design engineering subject. Students can perform their project related work. Sufficient number of PC, laptop points and other required infrastructure is available in this lab.
                                    </p>
                                </div>
                            </article>

                            <!-- Lab 2: 8113 Programming Lab - 1 -->
                            <article class="modern-lab-card modern-lab-card-reverse">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8113_programming1.jpg" alt="8113 Programming Lab - 1" class="modern-photo-img" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="modern-photo-placeholder" style="display: none;">
                                        <span>Photo Space</span>
                                    </div>
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8113</span>
                                    <h3 class="modern-lab-title">Programming Lab - 1</h3>
                                    <p class="modern-lab-text">
                                        The department is having programming lab for students where they can perform their experiments. This lab contains number of Computers with Internet connection. This lab is dedicatedly used for subjects such as DBMS, OS, CG, CoS, SE, Compiler Design and Python.
                                    </p>
                                </div>
                            </article>

                            <!-- Lab 3: 8115 Hardware Lab -->
                            <article class="modern-lab-card">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8115_hardware.jpg" alt="8115 Hardware Lab" class="modern-photo-img" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="modern-photo-placeholder" style="display: none;">
                                        <span>Photo Space</span>
                                    </div>
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8115</span>
                                    <h3 class="modern-lab-title">Hardware Lab</h3>
                                    <p class="modern-lab-text">
                                        The department is having programming lab for students where they can perform their experiments. This lab contains number of Computers with Internet connection. This lab is dedicatedly used for hardware related subjects such as digital fundamentals, COA, CN, Blockchain and IoT.
                                    </p>
                                </div>
                            </article>

                            <!-- Lab 4: 8116 PPS Lab - 2 -->
                            <article class="modern-lab-card modern-lab-card-reverse">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8116_pps2.jpg" alt="8116 PPS Lab - 2" class="modern-photo-img" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="modern-photo-placeholder" style="display: none;">
                                        <span>Photo Space</span>
                                    </div>
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8116</span>
                                    <h3 class="modern-lab-title">PPS Lab - 2</h3>
                                    <p class="modern-lab-text">
                                        The department is having Programming for Problem Solving lab for students where they can perform their PPS experiments. This lab contains number of Computers with Internet connection.
                                    </p>
                                </div>
                            </article>

                            <!-- Lab 5: 8117 Programming Lab - 3 -->
                            <article class="modern-lab-card">
                                <div class="modern-photo-wrap">
                                    <img src="images/labs/lab_8117_programming3.jpg" alt="8117 Programming Lab - 3" class="modern-photo-img" loading="lazy" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="modern-photo-placeholder" style="display: none;">
                                        <span>Photo Space</span>
                                    </div>
                                </div>
                                <div class="modern-lab-body">
                                    <span class="modern-room-pill">Room 8117</span>
                                    <h3 class="modern-lab-title">Programming Lab - 3</h3>
                                    <p class="modern-lab-text">
                                        The department is having programming lab for students where they can perform their experiments. This lab contains number of Computers with Internet connection. This lab is dedicatedly used for software/hardware related subjects such as .Net, MCWC and cloud computing.
                                    </p>
                                </div>
                            </article>

                        </div>
                    </div>

                    <!-- ================= SUBTAB 2: SEMINAR ROOM ================= -->
                    <div class="facility-pane" id="subtab-seminar">
                        <article class="modern-lab-card">
                            <div class="modern-photo-wrap">
                                <img src="images/labs/seminar_room.jpg" alt="Seminar Room" class="modern-photo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="modern-photo-placeholder" style="display: none;">
                                    <span>Photo Space (Seminar Room)</span>
                                </div>
                            </div>
                            <div class="modern-lab-body">
                                <span class="modern-room-pill">Room 8119 (Ground Floor)</span>
                                <h3 class="modern-lab-title">Seminar Room - 1</h3>
                                <p class="modern-lab-text">
                                    The Seminar Room is a space that seats up to around 120 people. Featuring a large whiteboard, 2 medium-sized tables, a podium, and a projector and small speaker set (in the media closet), fully air-conditioned, the Seminar Room is the ideal location for a guest lecture, a meeting, or a conference. The seminar room is one of the state-of-art facility in the college. It is equipped with the audio system and projection facilities. Lectures of prominent people, seminars and discussions are organized here. The hall is often used for Debates, Seminars, Council meeting and society's events etc.
                                </p>
                                <div class="modern-lab-location">
                                    <strong>Seminar Room-1 No.:</strong> 8119 (Ground Floor)
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- ================= SUBTAB 3: SERVER ROOM ================= -->
                    <div class="facility-pane" id="subtab-server">
                        <article class="modern-lab-card">
                            <div class="modern-photo-wrap">
                                <img src="images/labs/server_room.jpg" alt="Server Room" class="modern-photo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="modern-photo-placeholder" style="display: none;">
                                    <span>Photo Space (Server Room)</span>
                                </div>
                            </div>
                            <div class="modern-lab-body">
                                <span class="modern-room-pill">Room 8103 (Ground Floor)</span>
                                <h3 class="modern-lab-title">Server Room</h3>
                                <p class="modern-lab-text">
                                    The department maintains campus wide networking and INTERNET facility of institute. The INTERNET line is provided by NKN (National Knowledge Network) with speed up to 100 MBPS. Server room contains two high end servers, routers, Fortinet firewall system, switches and Wi-Fi controller.
                                </p>
                                <div class="modern-lab-location">
                                    <strong>Server Room No.:</strong> 8103 (Ground Floor)
                                </div>
                            </div>
                        </article>
                    </div>
                </section>

                <!-- ========================================================
                     7. PUBLICATIONS TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-publications">
                    <div class="dept-divider-title">Publications</div>

                    <p class="dept-text-body">
                        Faculties and students of the Computer Engineering department actively publish research articles in peer-reviewed national and international journals and conferences.
                    </p>

                    <!-- Filter Bar & Count Badge (Year-Wise Filter) -->
                    <div class="publications-header-bar">
                        <div class="publications-filter-group">
                            <div class="publications-year-select-box">
                                <i class="far fa-calendar-alt select-calendar-icon"></i>
                                <select id="pubYearSelect" aria-label="Filter by Year">
                                    <option value="all">All Years (150)</option>
                                    <option value="2026">2026</option>
                                    <option value="2025">2025</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2009">2009</option>
                                    <option value="2008">2008</option>
                                </select>
                                <i class="fas fa-chevron-down select-chevron-icon"></i>
                            </div>
                            
                        </div>
                        <div class="publications-count-badge" id="pubCountBadge">
                            <i class="fas fa-file-alt"></i> 150 Publications
                        </div>
                    </div>

                    <!-- Publications List Stack -->
                    <div class="publications-list-stack">

                        <!-- Publication 1 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Crowd Emotion and Behavior Analysis Using Lightweight CNN Model</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Jignesh Vaniya, Safvan Vahora, Uttam Chauhan, Sudhir Vegad</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>October 2024</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 2 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Peculiar Sentiment Analysis Advancement in Big Data</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Manisha Valera, Yash Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>October 2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 3 -->
                        <article class="publication-card">
                            <h4 class="publication-title">An avant-garde approach of Block chain in Big data analytics</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Manisha Valera, Parth Patel, Shruti Chettiar</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>November-December 2018</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 4 -->
                        <article class="publication-card">
                            <h4 class="publication-title">The Descriptive Study of Preprocessing from Web Usage Mining</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Manisha Valera</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>November 2012</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 5 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Low Control Overhead for Cluster Maintenance in Wireless Network for DSR Protocol</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nilesh Goriya, IndrJeet Rajput, Mihir Mehta</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>May-2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 6 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Abstractive Gujarati Text Summarization Using Sequence-To-Sequence Model and Attention Mechanism</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Shilpa Serasiya, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>May 2025</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 7 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Neoteric Web Recommender System based on Approach of Mining Frequent Sequential Pattern from Customized Web Log Preprocessing</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Manisha Valera, Uttam Chauhan, Kirit Rathod</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>May 2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 8 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Image Encryption Using Chaotic Based Artificial Neural Network</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Minal Chauhan, Rashmin Prajapati</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>June-2014</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 9 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Blazing issues in big data</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Manisha Valera, Yash Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>June 2018</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 10 -->
                        <article class="publication-card">
                            <h4 class="publication-title">AN EXHAUSTIVE STUDY: BIG DATA</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Manisha Valera</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>June 2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 11 -->
                        <article class="publication-card">
                            <h4 class="publication-title">An efficient web recommender system based on approach of mining frequent sequential pattern from Customized Web Log Preprocessing</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Manisha Valera, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>JULY 2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 12 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Object Removal using Image Inpainting</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Patel Hemangini Gamanbhai, Narenda Limbad</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>ISSN: 2321-0613, Issue 04, Vol 3, 2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 13 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Comprehensive Survey on Text Summarization For Indian Languages: Opportunities, Challenges and Future Prospects</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Shilpa Serasiya, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>February 2025</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 14 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Survey Paper on Cluster Head Selection Techniques for Mobile Ad-Hoc Network</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nilesh Goriya</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>December-2014</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 15 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Step up in Data Cleaning and User identification of Preprocessing on Web Usage data</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Manisha Valera, Shaktisinh Parmar</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>December 2014</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 16 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Radical Change through E- Governance in Gujarat</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nilesh Goriya, IndrJeet Rajput, Mihir Mehta</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>April- 2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 17 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Enhancing Semantic Coherence in Gujarati Topic Models by Eliminating Poor Quality Topics</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Uttam Chauhan, Nakul Dave, Avani Dave, Vishwa Kachhadiya, Priyanshi Chavadiya, Megh Dobariya, Ravi Nai, Diti Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2026</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 18 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Parkinson's Disease Detection Using Keystroke Dynamics And With Convolutional Neural Networks</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Bhumiben Mukeshbhai Gentiyal, Safvan A. Vahora, Pradeep Rohitbhai Gamit, Mahendra N Patel, Hirenkumar Ramanbhai Patel, Mahesh Goyani, Uttam Chauhan, Pinal J. Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2026</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 19 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Multi-Stage Diabetic Retinopathy Classification Using Deep Learning: Trends, Challenges, And Future Directions</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Shreya Dubey, Mahesh Goyani, Mahendrakumar N Patel, Pinal J. Patel, Safvan A. Vahora, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2026</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 20 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Deepfake detection Demodulate Synthetic Videos Using Deep Learning Models</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Priyanshu Hirpara, Hardi Valangar, Vishwa Kachhadiya, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2025</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 21 -->
                        <article class="publication-card">
                            <h4 class="publication-title">HyViSE: (Hybrid ViT-SE) Approach for Crowd Anomaly Detection and Emotion-Behavior Classification</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Jignesh Vaniya, Safvan Vahora, Uttam Chauhan, Sudhir Vegad</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2025</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 22 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Conceptual Study On Various ML Models Used in Financial Distress Prediction</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Janki Patel, Pinal Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2025</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 23 -->
                        <article class="publication-card">
                            <h4 class="publication-title">An outlier detection framework for Air Quality Index prediction using linear and ensemble models</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Viral Patel, Pradeep Kumar Dongre, Upendra Bhoi, Nilesh N. Maltare</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2025</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 24 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Study on Packet Filtering and Network Traffic Management on Linux</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Jogin Joshi, Pinal J. Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2025</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 25 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Securing E-Commerce: A Comprehensive Analysis of Fraud Detection Methods</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Rushi Parikh, Krupa Bhavsar, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2024</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 26 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Performance Evaluation of Text Summarization Models on SAMSUM Chat Data</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Jitendra Bhatia, Dip Patel, Jalpan Patel, Malaram Kumhar, Uttam Chauhan, Harshal Trivedi, Sudeep Tanwar</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2024</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 27 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Personalized Features-Based Stress Detection With Hyperparameter Tuning Using Genetic Algorithm</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Jigna Jadav, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2024</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 28 -->
                        <article class="publication-card">
                            <h4 class="publication-title">An Evolutionary Amharic Fake News Detection Based on ML and Deep Learning Approach</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Abirham Ayenew, Uttam Chauhan, Avani N Dave, Jaimin M Shroff, Nakul R Dave, Jigna J Jadav, Amit H Rathod</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2024</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 29 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Analysis Of Personalized Stress Recognition In The Office Environment</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Jigna Jadav, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2024</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 30 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Heart Rate Variability Based LSTM Model for Stress Detection with Explainable AI Insights</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Jigna Jadav, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2024</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 31 -->
                        <article class="publication-card">
                            <h4 class="publication-title">AN ASSESSMENT OF MACHINE LEARNING AND ENSEMBLE MODELS FOR DIABETES PREDICTION</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Dr. Pinal J. Patel, Prof. Priyank Shah, Prof. Rutu Nayak, Prof. Hemangini Shukla, Prof. Chintan Shah, Prof. Navdeepsinh Limbad, Mr. Aayush Kukadiya</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2024</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 32 -->
                        <article class="publication-card">
                            <h4 class="publication-title">HANDWRITTEN GUJARATI VOWEL RECOGNITION USING DEEP LEARNING MODELS</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Dr. Pinal J. Patel, Ms. Dhruvi Aacharya, Prof. Priyank Shah, Prof. Rutu Nayak, Prof. Chintan shah, Prof. Jignasha Prajapati, Prof. Navdeepsinh Limbad</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2024</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 33 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Chatbot For Academic Institutions</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Heeya Amin, Uttam Chauhan, Sahil Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2023</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 34 -->
                        <article class="publication-card">
                            <h4 class="publication-title">The Content Based Misinformation Detection for Gujarati Language</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Uttam Chauhan, Vinay Sheth, Vishvesh Trivedi, Chintan Bhatt, Juan Manuel, Corchado</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2023</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 35 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Amharic Language Hate Speech Detection Using Machine Learning</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Abirham Ayenew, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2023</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 36 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Recommendation Systems: Types, Applications, and Challenges</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Dhruval Patel, Foram Patel, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2023</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 37 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Modeling Topics in DFA-Based Lemmatized Gujarati Text</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Uttam Chauhan, Shrusti Shah, Dharati Shiroya, Dipti Solanki, Zeel Patel, Jitendra Bhatia, Sudeep Tanwar, Ravi Sharma, Verdes Marina, Maria Simona Raboaca</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2023</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 38 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Performance analysis of deep learning algorithms for classifying chronic obstructive pulmonary disease</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Pinal J. Patel, Dhanashree Yevle, Daksha Diwan, Shashi Ranga, Kinjal Gandhi, Samay Dumasia, Rutu Nayak</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2023</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 39 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Multi feature fusion for COPD classification using Deep Learning algorithms</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Pinal J. Patel, Daksha Diwan, Shashi Ranga, Niral J. Modi, Samay Dumasia</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2023</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 40 -->
                        <article class="publication-card">
                            <h4 class="publication-title">IoT Based Scalable Framework for Pollution Aware Route Recommendation</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Radha Govani, Parth Kakadia, Yash Modi, Dhrumin Thakkar, Heta Bhayani, Meshwa Patel, Jitendra Bhatia, Uttam Chauhan, Abdulatif Alabdulatif</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2022</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 41 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Abstractive Text Summarization For Indian Regional Languages: A Survey</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Shilpa Serasiya, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2022</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 42 -->
                        <article class="publication-card">
                            <h4 class="publication-title">An Overview of Fog Data Analytics for IoT Applications</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Jitendra Bhatia, Kiran Italiya, Kuldeepsinh Jadeja, Malaram Kumhar, Uttam Chauhan, Sudeep Tanwar, Madhuri Bhavsar, Ravi Sharma, Daniela Lucia Manea, Marina Verdes, Maria Simona Raboaca</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2022</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 43 -->
                        <article class="publication-card">
                            <h4 class="publication-title">5G-enabled deep learning-based framework for healthcare mining State of the art and challenges</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Rahil Parmar, Naitik Panchal, Dhruval Patel, Uttam Chauhan, Jitendra Bhatia</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2022</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 44 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Plant Disease Detection using Deep Learning</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>PINAL J. PATEL, NIYATI PANDYA, MANISHA CHAUDHARI, KINJAL GANDHI, HARDIK MAHENDRABHAI PATEL</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2022</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 45 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Alzheimer Disease Detection using Deep Learning</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Dr. Pinal J. Patel, Ms. Mohini H. Patel, Prof. Kinjal Gandhi, Dr. Shashi V. Ranga</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2022</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 46 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Offline Handwritten Character Recognition of Gujarati Characters using Convolutional Neural Network</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Pinal J. Patel, S. Kheni Rukhshmani, Urmila Patel, Darshil P. Patel, Kinjal N. Patel & Kinjal A. Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2022</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 47 -->
                        <article class="publication-card">
                            <h4 class="publication-title">SIMULTANEOUS ESTIMATION OF NEBIVOLOL AND CILNIDIPINE IN PHARMACEUTICAL FORMULATIONBY REVERSE PHASE HIGH PERFORMANCE LIQUID CHROMATOGRAPHY METHOD</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Pinal J. Patel, Drashti Mahendrabhai Patel, Meghal J. Patel, Manisha Chaudhari, Kinjal Gandhi, Shashi V. Ranga & Hardik Mahendrabhai Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2022</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 48 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Fraud Detection in Credit Card Data using Unsupervised & Supervised Machine Learning-Based Algorithms</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>PDF Prasanna Kumar Lakineni; Keyurkumar M Nayak; Harikumar Pallathadka; Kamal Gulati; Kapil Pandey; Pinal J. Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2022</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 49 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Coverless Information Hiding: A Review</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nitin Kanzariya, Gaurang Lakhani, Dhaval Jadhav, Uttam Chauhan, Lokesh Gagani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2021</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 50 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Topic Modeling Using Latent Dirichlet Allocation: A Survey</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Uttam Chauhan, Apurva Shah</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2021</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 51 -->
                        <article class="publication-card">
                            <h4 class="publication-title">ResTS: Residual Deep Interpretable Architecture for Plant Disease Detection</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Dhruvil Shah, Vishvesh Trivedi, Vinay Sheth, Aakash Shah, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2021</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 52 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Improving Semantic Coherence of Gujarati Text Topic Model Using Inflectional Forms Reduction and Single-letter Words Removal</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Uttam Chauhan, Apurva Shah</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2021</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 53 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Ant Colony Optimization for Travelling Salesman Problem with Modified Pheromone Update Formula</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Rahil Parmar, Naitik Panchal, Dhruval Patel, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2020</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 54 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Advancement of Text Summarization Using Machine Learning and Deep Learning: A Review</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Rishi Kotadiya, Shivangi Bhatt, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2019</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 55 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Survey on Architecture of Deep Convolution Neural Network</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Prachi Pandya Pinal J. Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2019</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 56 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Semi Supervised PU learning method for deceptive detection using MKNN</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Priyanka Patani Pinal Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2019</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 57 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Review on Crop Yield Prediction using Data Mining Focusing on Groundnut Crop and Naive Bayes Technique</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Haresh L. Siju, Pinal J. Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2018</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 58 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Biclustering of web usage data using Genetic Algorithm</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mayuree Rathva</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 59 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Speech based Watermark relational databases</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mayuree Rathva</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 60 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Hybrid Approach for Data Denoising on Image Segmentation</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Minal Chauhan, Binal Bhatt</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 61 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Solar power forecasting : Analysis of trends in modeling techniques and error minimization</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Archana Gondalia</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 62 -->
                        <article class="publication-card">
                            <h4 class="publication-title">AON: A Survey on Emergency Communication Systems during a Catastrophic Disaster</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Vasani Yash Kishorbhai, Nagekar Nainesh Vasantbhai</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 63 -->
                        <article class="publication-card">
                            <h4 class="publication-title">The Architecture for Optimizing Semantic Topical Coherence in Gujarati Text Topic Modeling</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Uttam Chauhan, Apurva Shah, Uday Yadav</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 64 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Survey - Sophisticated Topic Modeling</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Uttam Chauhan, Apurva Shah, Uday Yadav</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 65 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Performance analysis of neural networks for intrusion detection system</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Pinal J. Patel, J.S.Shah and Jinul Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 66 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Survey of Models and Tools for Project Monitoring and Control</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>H. L. Siju Pinal Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 67 -->
                        <article class="publication-card">
                            <h4 class="publication-title">SOFTWARE MAINTENANCE</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Ketan Sangadiya and Pinal Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 68 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Intrusion detection system using BackPropagation Neural Network</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Pinal Patel , Dr. J.S.Shah</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 69 -->
                        <article class="publication-card">
                            <h4 class="publication-title">RMMM: A SURVEY</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Krishna Dilip Suchak pinal patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 70 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A COMPARATIVE STUDY ON INTERNAL & EXTERNAL QUALITY FOR SOFTWARE PROJECT</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Komal Prajapati, Pinal Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2017</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 71 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Survey on Node Scheduling Methods for Wireless Sensor Network</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Neha Patel, Shweta Singh</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 72 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Survey on Techniques for Collision Avoidance in VANET</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Neha Patel, Shweta Singh</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 73 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A survey on big data uding cloud storage</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Binal Bhatt, Minal Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 74 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Review: Big Data Analysis Framework</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Uttam Chauhan, Apurva Shah, Uday Yadav, Mahendra Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 75 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Big data solutions and big data vendor’s comparison</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Prof. M.B.Chaudhary, Pianl Patel, Samarth Modi</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 76 -->
                        <article class="publication-card">
                            <h4 class="publication-title">CLOUD PLATFORMS AND SIMULATORS: A COMPARATIVE STUDY</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Pinal Patel, Umang Surani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 77 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Weather Prediction using Machine Learning: A Survey</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Pinal Patel, Jyoti Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 78 -->
                        <article class="publication-card">
                            <h4 class="publication-title">comparative study of the routing protocol approches in (DTN) Delay Tolerant Network</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Sweety Patel , Prof. M.B.1chaudhary, Pinal Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 79 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Hierarchical Query Task Clustering using Search Logs</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Vivek Bhojawala Pinal Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 80 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Brief Survey of Face Recognition Techniques</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Pinal Patel Nilam Goswami</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 81 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Search Logs Mining: Survey</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Vivek Bhojawala Pinal Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2016</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 82 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Performance Enhancement of Facial Expression Recognition using Appearance based features</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Jaimini Suthar, Goyani Mahesh</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 83 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Review on AODV Routing Protocol over Simulation Environment</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Neha Patel, Vijay Reshmwala</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 84 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Comparison Analysis of AODV and DSR Protocol over Energy Efficiency</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Neha Patel, Vijay Reshmwala, Shweta Singh</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 85 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Survey on Data Mining Techniques for Crime Hotspots Prediction</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Neha Patel, Shivani.V.Vora</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 86 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Survey on Natural Language Query Processing and Semantic Image Search</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Rashmi Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 87 -->
                        <article class="publication-card">
                            <h4 class="publication-title">GLIMPSE OF IMAGE RESTORATION TECHNIQUE – IMAGE INPAINTING</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nainesh V Nagekar, Prof. Jayesh Chaudhary</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 88 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Web Page Data Extraction and Categorization Web Pages Using Rule Based Classification Algorithm</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nirav Prajapati, Ketan Modi, Uttam Chauhan</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 89 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Clustering approach for Moving object detection from video sequence</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Parth V. Parekh, Prof. Pinal J. Patel, Shrikrishna Padalkar, Vaibhavi S. Ghariya</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 90 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Wireless Video Streaming using ARM Processor</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Suresh Prasad Pinal Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2015</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 91 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Min-Max Selection Sort Algorithm - Improved Version of Selection Sort</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Mohammad Chharchhodawala, Bhargav Mendapara</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2014</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 92 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Comparison of SUMO and SiMTram for Indian Traffic Scenario Representation</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Viral Patel, Manish Chaturvedi and Sanjay Srivastava</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2014</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 93 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Green Cloud Computing: An Overview</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Archana Gondalia</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2014</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 94 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Comparative Analysis of Dynamic Source Routing Protocol with Mobility and without Mobility</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>NileshGoriya, ParthWadhwa, MuktiPathak</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2014</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 95 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Comparative analysis for accuracy and size of pruned and unpruned decision tree inducted for various datasets</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Uttam Chauhan, Uday Yadav, Nakul Dave</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2014</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 96 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Comprehensive study on Machine Learning Techniques for IDS in Cloud Computing</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Pinal Patel, Dr. J. S. Shah, Meghal Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2014</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 97 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Detection and prevention zero-day attack in honeypot system for virtualization</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Ankit Patel, Pinal Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2014</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 98 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Corporate Governance and financial performance</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Gaurang Patel, Pinal Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2014</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 99 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A literature survey on Facial Expression Recognition using Global Features</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Vaibhavkumar J. Mistry, Mahesh M. Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 100 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Comparison of different image retrieval techniques in CBIR</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Chauhan Nandish, Mahesh Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 101 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Facial Expression Recognition using Gabor Filter by minimizing Feature Vector</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Vaibhavkumar J. Mistry, Mahesh M. Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 102 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Enhanced Multistage Content Based Image Retrieval</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nandish Chauhan, Mahesh Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 103 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Handwritten Character Recognition - A Comprehensive Review</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Harsh Dani, Chahna Dixit</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 104 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Novel Approach as Multi-place Watermarking for security in Database</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mayuree Rathva</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 105 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Reducing Avarage Waiting Time for Processes in Distributed System Using Dynamic Priority and Multiple Token Algorithm</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Ami Patel, Uttam Chauhan, Sanjay Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 106 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Text Based Fuzzy Clustering Algorithm to Filter Spam E- mail</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nakul Dave, Uttam Chauhan, Avani Nakul Dave</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 107 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Panoramic Image Mosaicing</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mrs. Hetal M.Patel, Prof. Pinal. J. Patel, Prof. Mr. Sandip G. Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 108 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Secure Cloud using Homomorphic Encryption Scheme</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Ms. Parin V. Patel, Mr. Hitesh D. Patel, Prof. Pinal J. Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 109 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Cancer Detection Using Modified Watershed</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Shanti L. Kadachha, Pinal J. Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2013</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 110 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Performance Analysis of FDA Based Face Recognition Using Correlation, ANN and SVM</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Akash Dhorajiya, Ronak Paun</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 111 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Comparative Analysis Between DCT & DWT Techniques of Image Compression</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Anil Kathrotiya, Swati Patel, Mahesh Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 112 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Key Frame Detection Based Semantic Event Detection and Classification Using Hierarchical Approach for Cricket Sport Video Indexing</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Shreyash Dutta, Payal Raj</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 113 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Performance Analysis of Block and Non Block Based Approach of Invisible Image Watermarking Using SVD in DCT Domain</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Gunvantsinh Gohil</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 114 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Geometry and Skin Color Based Hybrid Approach for Face Tracking in Color Environment</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Gitam Sikkenawis, Brijesh Joshi</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 115 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Review on Handwritten Character Recognition Systems</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Ravi Sheth, Narendra Chauhan, Mahesh Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 116 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Wicket fall Concept Mining From Cricket Video Using A-Priori Algorithm</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Shreyash Dutta, Gunvantsinh Gohil, Sapan Naik</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 117 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Handwritten Character Recognition System Using Correlation Coefficient</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Ravi Sheth, Narendra Chauhan, Mahesh Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 118 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Robust Face Recognition in Low Dimensional Subspace Using Reconstructive and Discriminative Features</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Gunvantsinh Gohil, Amit Chaudhari</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 119 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Top Down Hierarchical Histogram Based Approach for Printed Devanagari Script Character Isolation</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Trusha Gajjar, Rekha Teraiya, Gunvantsinh Gohil, Mahesh Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 120 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Detail Study of Digital Image Watermarking Techniques</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Swati Patel, Anil Kathrotiya, Mahesh Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 121 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Survey on Digital Video Watermarking</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Swati Patel, Anil Kathrotiya, Mahesh Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 122 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Chain Code Based Hand Written Character Recognition System Using Neural Network and Support Vector Machine</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Ravi Sheth, Narendra Chauhan, Mahesh Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 123 -->
                        <article class="publication-card">
                            <h4 class="publication-title">3D Face Recognition Techniques - A Review</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Preeti B. Sharma, Mahesh M. Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 124 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Chain code and holistic features based OCR system for printed Devanagari script using ANN and SVM</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Gunvantsinh Gohil, Rekha Teraiya and Mahesh Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 125 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Euler Number, Symmetry and Histogram Based Hierarchical Approach for English OCR</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh M Goyani, Rekha R Teraiya, Trusha Y Gajjar, Gunvantsinh D Gohil</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 126 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Comparision between DCT and DWT algorithms of Digital Watermarking</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Swati Patel, Anilkumar Katharotiya, Mahesh Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 127 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Face recognition using PCA and Modified PCA</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Preeti B. Sharma, Mahesh M. Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 128 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A survey optimize visual image search for sematic web</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Jaimin MShroff Prof. Bhaumik Nagar Prof Parth Shah</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 129 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A review on sla and various approaches for efficient cloud service provider selection</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Shreyas Patel, Prof. Gordhan B. Jethava</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 130 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Host Selection Strategy Based On Propagation Delay in Cloud</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Dodiya Aniruddhsinh Karshanbhai</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 131 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Host Selection Technique for Data Intensive Application in Cloud Computing</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Dodiya Aniruddhsinh Karshanbhai</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 132 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Analysis of Multiple path TCP over Heterogeneous networks</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>P R Gamit</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 133 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Load Sharing Optimization of Multipath TCP in heterogeneous Networks</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>P R Gamit</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 134 -->
                        <article class="publication-card">
                            <h4 class="publication-title">An Adaptive Classification approach to filter spam E-mail using Vector Space Model</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nakul Dave, Uttam Chauhan, Avani Nakul Dave</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 135 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Review of spam filtering based on unstructured classification</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Nakul Dave, Uttam Chauhan, Dhaval Varia</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 136 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Comprehensive study and review of image mosaicing methods</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mrs. Hetal M. Patel, Prof. Pinal. J. Patel, Prof. Mr. Sandip G. Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 137 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Survey paper on Architecture of Deep Convolutional Network</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Prachi Pandya , Pinal J. Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2012</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 138 -->
                        <article class="publication-card">
                            <h4 class="publication-title">PCA Based Handwritten Character Recognition System Using Support Vector Machine & Neural Network</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Ravi Sheth, N C Chauhan, Mahesh M Goyani, Kinjal A Mehta</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2011</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 139 -->
                        <article class="publication-card">
                            <h4 class="publication-title">An analysis and study of decision tree induction operating under adaptive mode to enhance accuracy and uptime in a dataset introduced to spontaneous variation in data attributes</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Uttam Chauhan, Y P Kosta, Amit Ganatra, Amit Thakkar</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2011</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 140 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Performance Enhancement in Lip Synchronization Using MFCC Parameters</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Narendra Patel, Mukesh Zaveri</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2010</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 141 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Acceptance / Rejection Rule Based Algorithm for Multiple Face Detection in Color Images</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Brijesh Joshi, Gitam Sikkenawis</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2010</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 142 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Performance Analysis of LPC, PLP and MFCC Parameters in Speech Recognition</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Namrata Dave</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2010</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 143 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Performance improvement in Lip Synchronization using LPC, MFCC and PLP Speech Parameters</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Namrata Dave, Narendra Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2010</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 144 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Real Time Lip Synchronization</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2009</span>
                                </div>
                            </div>
                        </article>

                        <!-- Publication 145 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Improvement in Lip Detection and Feature Extraction in Dynamic Lighting Conditions and Complex Background</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Parul Tandel, Hetal Chudasama</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2009</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 146 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Ear Recognition Using Force Field Feature Extraction</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Japen Pathak</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2009</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 147 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Classification Using Adaptive Decision Tree Induction Algorithm For accuracy and scale-up measure</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Uttam Chauhan, Amit Ganatra, Amit Thakkar</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2009</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 148 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Artificial Neural Network in Data Mining</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Mahesh Goyani, Mukesh Patel</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>2008</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 149 -->
                        <article class="publication-card">
                            <h4 class="publication-title">Image Encryption Using Chaotic Cryptosystems and Artificial Neural Network Cryptosystems: A Review</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Minal Chauhan, Rashmin Prajapati</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>May-2014</span>
                                </div>
                            </div>
                        </article>
                        <!-- Publication 150 -->
                        <article class="publication-card">
                            <h4 class="publication-title">A Novel Approach of Mining Frequent Sequential Pattern from Customized Web Log Preprocessing</h4>
                            <div class="publication-meta-row">
                                <div class="publication-authors">
                                    <i class="fas fa-user"></i>
                                    <span>Manisha Valera</span>
                                </div>
                                <div class="publication-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <span>January - February 2013</span>
                                </div>
                            </div>
                        </article>

                    </div>
                </section>

                <!-- ========================================================
                     8. INDUSTRY ADVISORY BOARD TABS & SUB-OPTIONS
                     ======================================================== -->

                <!-- 8A. IAB 2025-26 Sub-tab -->
                <section class="dept-tab-content" id="tab-iab-2025-26">
                    <div class="dept-divider-title">Industry Advisory Board (IAB 2025-26)</div>

                    <p class="dept-text-body">
                        Official notifications, committee constitution, and proceedings of the Industry Advisory Board for academic session 2025-26.
                    </p>

                    <!-- PDF Viewer Container (Paste your PDF URL in src & href) -->
                    <div class="dept-pdf-card">
                        <div class="dept-pdf-toolbar">
                            <div class="dept-pdf-toolbar-info">
                                <i class="fas fa-file-pdf dept-pdf-icon-badge"></i>
                                <div>
                                    <h4 class="dept-pdf-name">IAB 2025-26 Notification Document</h4>
                                    <span class="dept-pdf-sub">Government Engineering College, Modasa &bull; Official PDF Document</span>
                                </div>
                            </div>
                            <div class="dept-pdf-toolbar-actions">
                                <!-- USER: Put your PDF URL / file path in href and src below -->
                                <a href="#" target="_blank" class="dept-pdf-btn dept-pdf-btn-open" title="Open in new tab / Fullscreen">
                                    <i class="fas fa-external-link-alt"></i> Fullscreen
                                </a>
                                <a href="#" download class="dept-pdf-btn dept-pdf-btn-download" title="Download PDF file">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                            </div>
                        </div>

                        <div class="dept-pdf-viewer-area">
                            <!-- USER: Set your PDF path below, e.g. src="../../assets/pdf/iab-2025-26.pdf" -->
                            <iframe src="" class="dept-pdf-iframe" id="pdf-iab-2025-26" title="IAB 2025-26 Document"></iframe>
                            <div class="dept-pdf-empty-state">
                                <div class="dept-pdf-empty-icon"><i class="fas fa-file-pdf"></i></div>
                                <h5>IAB 2025-26 PDF Document</h5>
                                <p>PDF file yahan display hoga. Aap PDF provide karenge to direct link ho jayega.</p>
                                <span class="badge bg-light text-dark border px-3 py-2"><i class="fas fa-info-circle text-primary"></i> Ready for your PDF file</span>
                            </div>
                        </div>
                    </div>

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

                <!-- 8B. IAB 2023-24 Sub-tab -->
                <section class="dept-tab-content" id="tab-iab-2023-24">
                    <div class="dept-divider-title">Industry Advisory Board (IAB 2023-24)</div>

                    <p class="dept-text-body">
                        Official notifications, committee constitution, and proceedings of the Industry Advisory Board for academic session 2023-24.
                    </p>

                    <!-- PDF Viewer Container (Paste your PDF URL in src & href) -->
                    <div class="dept-pdf-card">
                        <div class="dept-pdf-toolbar">
                            <div class="dept-pdf-toolbar-info">
                                <i class="fas fa-file-pdf dept-pdf-icon-badge"></i>
                                <div>
                                    <h4 class="dept-pdf-name">IAB 2023-24 Notification Document</h4>
                                    <span class="dept-pdf-sub">Government Engineering College, Modasa &bull; Official PDF Document</span>
                                </div>
                            </div>
                            <div class="dept-pdf-toolbar-actions">
                                <!-- USER: Put your PDF URL / file path in href and src below -->
                                <a href="#" target="_blank" class="dept-pdf-btn dept-pdf-btn-open" title="Open in new tab / Fullscreen">
                                    <i class="fas fa-external-link-alt"></i> Fullscreen
                                </a>
                                <a href="#" download class="dept-pdf-btn dept-pdf-btn-download" title="Download PDF file">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                            </div>
                        </div>

                        <div class="dept-pdf-viewer-area">
                            <!-- USER: Set your PDF path below, e.g. src="../../assets/pdf/iab-2023-24.pdf" -->
                            <iframe src="" class="dept-pdf-iframe" id="pdf-iab-2023-24" title="IAB 2023-24 Document"></iframe>
                            <div class="dept-pdf-empty-state">
                                <div class="dept-pdf-empty-icon"><i class="fas fa-file-pdf"></i></div>
                                <h5>IAB 2023-24 PDF Document</h5>
                                <p>PDF file yahan display hoga. Aap PDF provide karenge to direct link ho jayega.</p>
                                <span class="badge bg-light text-dark border px-3 py-2"><i class="fas fa-info-circle text-primary"></i> Ready for your PDF file</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 8C. Industry Advisory Board Overview Tab -->
                <section class="dept-tab-content" id="tab-advisory-board">
                    <div class="dept-divider-title">Industry Advisory Board</div>

                    <p class="dept-text-body">
                        The Industry Advisory Board bridges the gap between academic curriculum and current industry demands, reviewing syllabi and capstone projects periodically. Select an academic year session below to view official proceedings.
                    </p>

                    <div class="row g-3 my-3">
                        <div class="col-md-6">
                            <a href="#iab-2025-26" class="dept-sub-link-card dept-sub-link" data-tab="iab-2025-26" style="display:block; padding: 18px 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; text-decoration: none; color: inherit;">
                                <div style="display:flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <h5 style="margin:0 0 5px; color:#1e293b; font-weight:600;"><i class="fas fa-file-pdf text-danger me-2"></i> IAB 2025-26</h5>
                                        <span style="font-size:0.85rem; color:#64748b;">Current Academic Year Proceedings</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#iab-2023-24" class="dept-sub-link-card dept-sub-link" data-tab="iab-2023-24" style="display:block; padding: 18px 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; text-decoration: none; color: inherit;">
                                <div style="display:flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <h5 style="margin:0 0 5px; color:#1e293b; font-weight:600;"><i class="fas fa-file-pdf text-danger me-2"></i> IAB 2023-24</h5>
                                        <span style="font-size:0.85rem; color:#64748b;">Previous Session Proceedings</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </a>
                        </div>
                    </div>

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
                     9. NEWS LETTERS TABS & SUB-OPTIONS
                     ======================================================== -->

                <!-- 9A. News Letters Vol. 1 Issue 2 Sub-tab -->
                <section class="dept-tab-content" id="tab-nl-vol1-issue2">
                    <div class="dept-divider-title">News Letters: Vol. 1 Issue 2</div>

                    <p class="dept-text-body">
                        Department of Computer Engineering biannual newsletter <strong>"COMP-CONNECT"</strong> &mdash; Volume 1, Issue 2.
                    </p>

                    <!-- PDF Viewer Container (Paste your PDF URL in src & href) -->
                    <div class="dept-pdf-card">
                        <div class="dept-pdf-toolbar">
                            <div class="dept-pdf-toolbar-info">
                                <i class="fas fa-file-pdf dept-pdf-icon-badge"></i>
                                <div>
                                    <h4 class="dept-pdf-name">COMP-CONNECT Newsletter (Vol. 1 Issue 2)</h4>
                                    <span class="dept-pdf-sub">Department of Computer Engineering &bull; Official Publication</span>
                                </div>
                            </div>
                            <div class="dept-pdf-toolbar-actions">
                                <!-- USER: Put your PDF URL / file path in href and src below -->
                                <a href="#" target="_blank" class="dept-pdf-btn dept-pdf-btn-open" title="Open in new tab / Fullscreen">
                                    <i class="fas fa-external-link-alt"></i> Fullscreen
                                </a>
                                <a href="#" download class="dept-pdf-btn dept-pdf-btn-download" title="Download PDF file">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                            </div>
                        </div>

                        <div class="dept-pdf-viewer-area">
                            <!-- USER: Set your PDF path below, e.g. src="../../assets/pdf/newsletter-vol1-issue2.pdf" -->
                            <iframe src="" class="dept-pdf-iframe" id="pdf-nl-vol1-issue2" title="Newsletter Vol. 1 Issue 2"></iframe>
                            <div class="dept-pdf-empty-state">
                                <div class="dept-pdf-empty-icon"><i class="fas fa-file-pdf"></i></div>
                                <h5>Vol. 1 Issue 2 Newsletter Document</h5>
                                <p>PDF file yahan display hoga. Aap PDF provide karenge to direct link ho jayegi.</p>
                                <span class="badge bg-light text-dark border px-3 py-2"><i class="fas fa-info-circle text-primary"></i> Ready for your PDF file</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 9B. News Letters Vol. 1 Issue 1 Sub-tab -->
                <section class="dept-tab-content" id="tab-nl-vol1-issue1">
                    <div class="dept-divider-title">News Letters: Vol. 1 Issue 1</div>

                    <p class="dept-text-body">
                        Department of Computer Engineering biannual newsletter <strong>"COMP-CONNECT"</strong> &mdash; Volume 1, Issue 1 (Inaugural Edition).
                    </p>

                    <!-- PDF Viewer Container (Paste your PDF URL in src & href) -->
                    <div class="dept-pdf-card">
                        <div class="dept-pdf-toolbar">
                            <div class="dept-pdf-toolbar-info">
                                <i class="fas fa-file-pdf dept-pdf-icon-badge"></i>
                                <div>
                                    <h4 class="dept-pdf-name">COMP-CONNECT Newsletter (Vol. 1 Issue 1)</h4>
                                    <span class="dept-pdf-sub">Department of Computer Engineering &bull; Official Publication</span>
                                </div>
                            </div>
                            <div class="dept-pdf-toolbar-actions">
                                <!-- USER: Put your PDF URL / file path in href and src below -->
                                <a href="#" target="_blank" class="dept-pdf-btn dept-pdf-btn-open" title="Open in new tab / Fullscreen">
                                    <i class="fas fa-external-link-alt"></i> Fullscreen
                                </a>
                                <a href="#" download class="dept-pdf-btn dept-pdf-btn-download" title="Download PDF file">
                                    <i class="fas fa-download"></i> Download PDF
                                </a>
                            </div>
                        </div>

                        <div class="dept-pdf-viewer-area">
                            <!-- USER: Set your PDF path below, e.g. src="../../assets/pdf/newsletter-vol1-issue1.pdf" -->
                            <iframe src="" class="dept-pdf-iframe" id="pdf-nl-vol1-issue1" title="Newsletter Vol. 1 Issue 1"></iframe>
                            <div class="dept-pdf-empty-state">
                                <div class="dept-pdf-empty-icon"><i class="fas fa-file-pdf"></i></div>
                                <h5>Vol. 1 Issue 1 Newsletter Document</h5>
                                <p>PDF file yahan display hoga. Aap PDF provide karenge to direct link ho jayegi.</p>
                                <span class="badge bg-light text-dark border px-3 py-2"><i class="fas fa-info-circle text-primary"></i> Ready for your PDF file</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 9C. News Letters Overview & Archives Tab -->
                <section class="dept-tab-content" id="tab-newsletters">
                    <div class="dept-divider-title">News Letters</div>

                    <p class="dept-text-body">
                        The biannual departmental newsletter <strong>"COMP-CONNECT"</strong> chronicles academic achievements, faculty publications, student awards, and technological developments.
                    </p>

                    <div class="row g-3 my-3">
                        <div class="col-md-6">
                            <a href="#nl-vol1-issue2" class="dept-sub-link-card dept-sub-link" data-tab="nl-vol1-issue2" style="display:block; padding: 18px 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; text-decoration: none; color: inherit;">
                                <div style="display:flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <h5 style="margin:0 0 5px; color:#1e293b; font-weight:600;"><i class="fas fa-newspaper text-primary me-2"></i> Vol. 1 Issue 2</h5>
                                        <span style="font-size:0.85rem; color:#64748b;">Latest Edition Newsletter</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#nl-vol1-issue1" class="dept-sub-link-card dept-sub-link" data-tab="nl-vol1-issue1" style="display:block; padding: 18px 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; text-decoration: none; color: inherit;">
                                <div style="display:flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <h5 style="margin:0 0 5px; color:#1e293b; font-weight:600;"><i class="fas fa-newspaper text-primary me-2"></i> Vol. 1 Issue 1</h5>
                                        <span style="font-size:0.85rem; color:#64748b;">Inaugural Edition Newsletter</span>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="courses-card mt-4">
                        <div class="courses-card-header">
                            <i class="fas fa-bars"></i>
                            <span>Departmental Newsletters Archive</span>
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
include_once __DIR__ . '/../../includes/footer.php';
?>
