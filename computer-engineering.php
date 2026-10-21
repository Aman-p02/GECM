<?php
// Set Page Variables
$page_title = "Computer Engineering Department - Government Engineering College, Modasa";
$active_page = "departments";
$extra_css = "css/department.css";
$extra_js = "js/department.js";

// Include Header
include_once __DIR__ . '/includes/header.php';
?>

<div class="dept-page-wrapper">
    <div class="full-width-container">

        <!-- Top Breadcrumb & Header Bar -->
        <div class="dept-top-bar">
            <h2 class="dept-page-title" id="deptPageTitle">About Department</h2>
            <ul class="dept-breadcrumb">
                <li><a href="./"><i class="fas fa-home"></i></a></li>
                <li class="separator">/</li>
                <li><a href="./#departments">Departments</a></li>
                <li class="separator">/</li>
                <li class="active-crumb">Computer Engineering Department</li>
            </ul>
        </div>

        <!-- 2-Column Grid Layout -->
        <div class="dept-layout-grid">

            <!-- Left Sidebar Navigation -->
            <aside class="dept-sidebar">
                <div class="dept-sidebar-header">
                    Computer Department
                </div>
                <ul class="dept-sidebar-menu">
                    <li class="active">
                        <a class="dept-nav-link active" data-tab="about">
                            <span>About Department</span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="vision-mission">
                            <span>Vision &amp; Mission</span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="syllabus">
                            <span>Syllabus</span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="faculty">
                            <span>Faculty</span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="activities">
                            <span>Activities</span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="facilities">
                            <span>Facilities</span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="publications">
                            <span>Publications</span>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="advisory-board">
                            <span>Industry Advisory Board</span>
                            <i class="fas fa-chevron-right chevron-icon"></i>
                        </a>
                    </li>
                    <li>
                        <a class="dept-nav-link" data-tab="newsletters">
                            <span>News Letters</span>
                            <i class="fas fa-chevron-right chevron-icon"></i>
                        </a>
                    </li>
                </ul>
            </aside>

            <!-- Right Content Area -->
            <main class="dept-content-card">

                <!-- ========================================================
                     1. ABOUT DEPARTMENT TAB
                     ======================================================== -->
                <section class="dept-tab-content active" id="tab-about">
                    <div class="dept-divider-title">
                        About Department
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

                    <div class="dept-divider-title">
                        About the Programme
                    </div>

                    <div class="programme-cards-grid">
                        <div class="prog-card">
                            <h4><i class="fas fa-graduation-cap"></i> Under Graduate (B.E.)</h4>
                            <p style="font-size: 0.93rem; color: #475569; margin-bottom: 15px;">
                                Bachelor of Engineering in Computer Engineering
                            </p>
                            <ul class="prog-meta-list">
                                <li><span>Intake Capacity:</span> <strong>120 Seats</strong></li>
                                <li><span>Duration:</span> <strong>4 Years (8 Semesters)</strong></li>
                                <li><span>Starting Year:</span> <strong>2001</strong></li>
                                <li><span>Affiliation:</span> <strong>GTU, Ahmedabad</strong></li>
                                <li><span>Approval:</span> <strong>AICTE, New Delhi</strong></li>
                            </ul>
                        </div>

                        <div class="prog-card">
                            <h4><i class="fas fa-user-graduate"></i> Post Graduate (M.E.)</h4>
                            <p style="font-size: 0.93rem; color: #475569; margin-bottom: 15px;">
                                Master of Engineering in Computer Science &amp; Engineering
                            </p>
                            <ul class="prog-meta-list">
                                <li><span>Intake Capacity:</span> <strong>18 Seats</strong></li>
                                <li><span>Duration:</span> <strong>2 Years (4 Semesters)</strong></li>
                                <li><span>Starting Year:</span> <strong>2010</strong></li>
                                <li><span>Affiliation:</span> <strong>GTU, Ahmedabad</strong></li>
                                <li><span>Approval:</span> <strong>AICTE, New Delhi</strong></li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     2. VISION & MISSION TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-vision-mission">
                    <div class="dept-divider-title">
                        Vision
                    </div>

                    <div class="vision-box">
                        To become a prominent department producing competent professionals with research, innovation and entrepreneurial skills, inculcating moral values and societal concerns.
                    </div>

                    <div class="dept-divider-title">
                        Mission
                    </div>

                    <ul class="dept-mission-list">
                        <li>
                            To create globally competent students having ability to design, develop and test world class software, keeping pace with the latest technological developments.
                        </li>
                        <li>
                            Create facilities and expertise in advanced computer technology thereby promote research.
                        </li>
                        <li>
                            Enhance Industry Institute Interaction programme to get acquainted with corporate culture.
                        </li>
                        <li>
                            Induce moral, ethical values and spirit of social commitment.
                        </li>
                    </ul>

                    <!-- PEOs Banner Card -->
                    <div class="peo-card">
                        <div class="peo-card-header">
                            <i class="fas fa-bars"></i> Program Educational Objectives PEOs
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
                    <div class="dept-divider-title">
                        Syllabus &amp; Curriculum
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
                                    <th>Curriculum Pattern</th>
                                    <th>Syllabus PDF</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Semester I &amp; II</strong></td>
                                    <td>Basic Engineering, Mathematics, Programming for Problem Solving (C Language), Engineering Graphics</td>
                                    <td>GTU NEP / AICTE</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester III</strong></td>
                                    <td>Data Structures, Digital Fundamentals, Database Management Systems, Discrete Mathematics</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester IV</strong></td>
                                    <td>Operating Systems, Object Oriented Programming with Java, Computer Organization, Principles of Economics</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester V</strong></td>
                                    <td>Computer Networks, Software Engineering, Design &amp; Analysis of Algorithms, Professional Elective I</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester VI</strong></td>
                                    <td>Theory of Computation, Web Technology, Advanced Java / Python, Cyber Security, Professional Elective II</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester VII</strong></td>
                                    <td>Artificial Intelligence &amp; Machine Learning, Cloud Computing, Compiler Design, Project - I</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                                <tr>
                                    <td><strong>Semester VIII</strong></td>
                                    <td>Big Data Analytics / Internet of Things, Major Project / Full Semester Industry Internship</td>
                                    <td>GTU Revised</td>
                                    <td><a href="https://www.gtu.ac.in/" target="_blank" class="btn-download"><i class="fas fa-download"></i> View</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- ========================================================
                     4. FACULTY TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-faculty">
                    <div class="dept-divider-title">
                        Department Faculty Members
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
                    <div class="dept-divider-title">
                        Department Activities
                    </div>
                    <p class="dept-text-body">
                        The department regularly organizes workshops, hackathons, expert lectures by industry leaders, and technical competitions under the banner of the Computer Society of India (CSI) and student developer clubs.
                    </p>

                    <div class="programme-cards-grid">
                        <div class="prog-card">
                            <h4><i class="fas fa-laptop-code"></i> CodeFest &amp; Hackathons</h4>
                            <p class="dept-text-body" style="font-size: 0.92rem;">
                                Annual 24-hour inter-college coding marathon encouraging students to develop innovative software solutions for real-world governance and industrial problems.
                            </p>
                        </div>
                        <div class="prog-card">
                            <h4><i class="fas fa-chalkboard-teacher"></i> Expert Lectures &amp; Webinars</h4>
                            <p class="dept-text-body" style="font-size: 0.92rem;">
                                Industry professionals from MNCs deliver interactive sessions on Cloud Architecture, Cyber Forensics, DevOps, and Full-Stack Development.
                            </p>
                        </div>
                        <div class="prog-card">
                            <h4><i class="fas fa-industry"></i> Industrial Visits</h4>
                            <p class="dept-text-body" style="font-size: 0.92rem;">
                                Educational visits to prestigious organizations such as BISAG-N Gandhinagar, TCS Garima Park, and ISRO Space Applications Centre (SAC).
                            </p>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     6. FACILITIES TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-facilities">
                    <div class="dept-divider-title">
                        Laboratories &amp; Infrastructure
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
                    <div class="dept-divider-title">
                        Research &amp; Publications
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
                    <div class="dept-divider-title">
                        Industry Advisory Board (IAB)
                    </div>
                    <p class="dept-text-body">
                        The Industry Advisory Board bridges the gap between academic curriculum and current industry demands. Comprising senior corporate leaders, entrepreneurs, and academic stalwarts, the board reviews syllabi and project quality periodically.
                    </p>

                    <div class="programme-cards-grid">
                        <div class="prog-card">
                            <h4><i class="fas fa-building"></i> Industry Representatives</h4>
                            <ul class="prog-meta-list">
                                <li><span>Mr. J. K. Sharma</span> <strong>VP Engineering, TCS</strong></li>
                                <li><span>Mr. Sameer Desai</span> <strong>Technical Director, L&amp;T Infotech</strong></li>
                                <li><span>Ms. Neha Trivedi</span> <strong>Senior Architect, Infosys</strong></li>
                            </ul>
                        </div>
                        <div class="prog-card">
                            <h4><i class="fas fa-bullseye"></i> Key Board Objectives</h4>
                            <ul class="dept-mission-list" style="margin: 0; padding: 0;">
                                <li>Align GTU curriculum with market technologies (Cloud, GenAI, DevOps).</li>
                                <li>Facilitate semester-long industry internships and live capstone projects.</li>
                                <li>Facilitate placement drives and corporate training workshops.</li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- ========================================================
                     9. NEWS LETTERS TAB
                     ======================================================== -->
                <section class="dept-tab-content" id="tab-newsletters">
                    <div class="dept-divider-title">
                        Department Newsletters
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>COMP-CONNECT Vol. 8</strong></td>
                                    <td>Jan 2024 - June 2024</td>
                                    <td>AI Advancements, Hackathon Achievements &amp; Placements</td>
                                    <td><a href="#" class="btn-download"><i class="fas fa-file-pdf"></i> Read Newsletter</a></td>
                                </tr>
                                <tr>
                                    <td><strong>COMP-CONNECT Vol. 7</strong></td>
                                    <td>July 2023 - Dec 2023</td>
                                    <td>Cloud Architecture Workshop &amp; Alumni Interactions</td>
                                    <td><a href="#" class="btn-download"><i class="fas fa-file-pdf"></i> Read Newsletter</a></td>
                                </tr>
                                <tr>
                                    <td><strong>COMP-CONNECT Vol. 6</strong></td>
                                    <td>Jan 2023 - June 2023</td>
                                    <td>National Tech-Fest Winner Edition</td>
                                    <td><a href="#" class="btn-download"><i class="fas fa-file-pdf"></i> Read Newsletter</a></td>
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
