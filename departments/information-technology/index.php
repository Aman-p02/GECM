<?php
// Set Page Variables
$page_title = "Information Technology Department - Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/information-technology/css/department.css";
$extra_js = "departments/information-technology/js/department.js";

// Include Header
include_once __DIR__ . '/../../includes/header.php';
?>

<div class="dept-page-container">

    <!-- 1. Department Hero Showcase (Dignified & Spacious) -->
    <header class="dept-hero-editorial">
        <div class="dept-inner-container">
            <nav class="dept-breadcrumb-row" aria-label="Breadcrumb">
                <a href="<?= $root_path ?>">Home</a>
                <span class="crumb-sep">/</span>
                <a href="<?= $root_path ?>#departments">Departments</a>
                <span class="crumb-sep">/</span>
                <span class="current-crumb">Information Technology</span>
            </nav>

            <span class="dept-editorial-kicker">Department of</span>
            <h1 class="dept-editorial-title">Information Technology</h1>
            <p class="dept-editorial-subtitle">
                Fostering computational science, software engineering, and technological innovation since 1999. Committed to educating globally competent engineers through hands-on laboratory experiences.
            </p>

            <!-- Key Metrics Strip -->
            <div class="dept-metrics-strip">
                <div class="dept-metric-box">
                    <span class="dept-metric-value">1999</span>
                    <span class="dept-metric-label">Year of Establishment</span>
                </div>
                <div class="dept-metric-box">
                    <span class="dept-metric-value">120</span>
                    <span class="dept-metric-label">Approved Annual Intake</span>
                </div>
                <div class="dept-metric-box">
                    <span class="dept-metric-value">10</span>
                    <span class="dept-metric-label">Modern Laboratories</span>
                </div>
                <div class="dept-metric-box">
                    <span class="dept-metric-value">GTU / AICTE</span>
                    <span class="dept-metric-label">Affiliation &amp; Approval</span>
                </div>
            </div>
        </div>
    </header>

    <!-- 2. Sticky Horizontal Navigation Bar -->
    <nav class="dept-sticky-nav-bar" aria-label="Department Sections">
        <div class="dept-inner-container">
            <ul class="dept-nav-track" role="tablist">
                <li class="dept-nav-tab-item active">
                    <button type="button" class="dept-tab-btn active" data-tab="about" role="tab" aria-selected="true">About Department</button>
                </li>
                <li class="dept-nav-tab-item">
                    <button type="button" class="dept-tab-btn" data-tab="vision-mission" role="tab" aria-selected="false">Vision &amp; Mission</button>
                </li>
                <li class="dept-nav-tab-item">
                    <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="dept-tab-btn" aria-label="GTU Official Syllabus Portal">
                        <span>Syllabus</span>
                        <i class="fas fa-external-link-alt ext-icon"></i>
                    </a>
                </li>
                <li class="dept-nav-tab-item">
                    <button type="button" class="dept-tab-btn" data-tab="faculty" role="tab" aria-selected="false">Faculty</button>
                </li>
                <li class="dept-nav-tab-item">
                    <button type="button" class="dept-tab-btn" data-tab="activities" role="tab" aria-selected="false">Activities</button>
                </li>
                <li class="dept-nav-tab-item">
                    <button type="button" class="dept-tab-btn" data-tab="facilities" role="tab" aria-selected="false">Facilities</button>
                </li>
                <li class="dept-nav-tab-item">
                    <button type="button" class="dept-tab-btn" data-tab="publications" role="tab" aria-selected="false">Publications</button>
                </li>
                <li class="dept-nav-tab-item">
                    <button type="button" class="dept-tab-btn" data-tab="advisory-board" role="tab" aria-selected="false">Industry Advisory Board</button>
                </li>
                <li class="dept-nav-tab-item">
                    <button type="button" class="dept-tab-btn" data-tab="newsletters" role="tab" aria-selected="false">News Letters</button>
                </li>
            </ul>
        </div>
    </nav>

    <!-- 3. Department Content Area -->
    <main class="dept-content-section-wrapper">
        <div class="dept-inner-container">

            <!-- TAB 1: ABOUT DEPARTMENT -->
            <section class="dept-pane active" id="tab-about">
                <div class="dept-section-lead-header">
                    <h2 class="dept-section-lead-title">About the Department</h2>
                    <p class="dept-section-lead-desc">
                        Providing rigorous engineering education, research mentorship, and industrial training across computer hardware and software paradigms.
                    </p>
                </div>

                <div class="dept-about-layout">
                    <div class="dept-story-text">
                        <p>
                            Running continuously since 1999, the Department of Information Technology is equipped with high-performance computing clusters, multimedia software, and optical fiber gigabit networking. The department has established robust laboratories in Computer Hardware, Networking &amp; Security, Database Management Systems, Computer Graphics, and Internet Technologies in tune with real-time systems.
                        </p>
                        <p>
                            Under AICTE grant assistance, the campus-wide network infrastructure was engineered and is centrally maintained by the department. In addition to the four-year undergraduate program, the department offers a specialized Post Graduate program (M.E. in Computer Science &amp; Engineering) established in 2010.
                        </p>
                        <p>
                            Information Technology and Information Technology share infrastructural facilities in a spacious academic complex, complete with 10 computer laboratories and two seminar halls, providing students an immersive environment to build industry-scale software solutions.
                        </p>
                    </div>

                    <div class="dept-infrastructure-grid">
                        <div class="dept-infra-card">
                            <h4>Gigabit Campus LAN</h4>
                            <p>250+ networked terminals connected over high-speed optical fiber backbone.</p>
                        </div>
                        <div class="dept-infra-card">
                            <h4>High-Speed Wi-Fi</h4>
                            <p>30 enterprise-grade wireless access points with central hardware controller.</p>
                        </div>
                        <div class="dept-infra-card">
                            <h4>Dedicated Servers</h4>
                            <p>High-end departmental servers hosting local repository and e-learning systems.</p>
                        </div>
                        <div class="dept-infra-card">
                            <h4>Postgraduate Wing</h4>
                            <p>M.E. in Computer Science &amp; Engineering running successfully since 2010.</p>
                        </div>
                    </div>
                </div>

                <!-- Academic Programmes Table -->
                <div class="dept-programmes-block">
                    <h3 class="dept-sub-heading">Academic Programmes Offered</h3>
                    <div class="dept-clean-table-wrap">
                        <table class="dept-clean-table">
                            <thead>
                                <tr>
                                    <th>Programme Name</th>
                                    <th>Level</th>
                                    <th>Duration</th>
                                    <th>Approved Intake</th>
                                    <th>Year of Inception</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>B.E. Information Technology</strong></td>
                                    <td><span class="programme-level-pill">UG</span></td>
                                    <td>4 Years</td>
                                    <td><strong>120 Seats</strong></td>
                                    <td>1999</td>
                                </tr>
                                <tr>
                                    <td><strong>M.E. Computer Science &amp; Engineering</strong></td>
                                    <td><span class="programme-level-pill">PG</span></td>
                                    <td>2 Years</td>
                                    <td><strong>18 Seats</strong></td>
                                    <td>2010</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- TAB 2: VISION & MISSION -->
            <section class="dept-pane" id="tab-vision-mission">
                <div class="dept-section-lead-header">
                    <h2 class="dept-section-lead-title">Vision &amp; Mission</h2>
                    <p class="dept-section-lead-desc">
                        Strategic direction guiding our academic pedagogy, technical research, and societal responsibility.
                    </p>
                </div>

                <div class="vm-editorial-grid">
                    <div class="vm-col-card">
                        <h3>Department Vision</h3>
                        <p class="vm-statement-text">
                            To become a prominent department producing competent professionals with research, innovation, and entrepreneurial skills, inculcating moral values and societal concerns.
                        </p>
                    </div>

                    <div class="vm-col-card">
                        <h3>Department Mission</h3>
                        <ul class="mission-step-list">
                            <li class="mission-step-item">
                                <span class="mission-step-num">01</span>
                                <span class="mission-step-desc">Create globally competent students with the ability to design, develop, and test world-class software keeping pace with technological advances.</span>
                            </li>
                            <li class="mission-step-item">
                                <span class="mission-step-num">02</span>
                                <span class="mission-step-desc">Establish facilities and expertise in advanced computer technology, thereby promoting cutting-edge research.</span>
                            </li>
                            <li class="mission-step-item">
                                <span class="mission-step-num">03</span>
                                <span class="mission-step-desc">Enhance Industry Institute Interaction programs to get students acquainted with modern corporate culture.</span>
                            </li>
                            <li class="mission-step-item">
                                <span class="mission-step-num">04</span>
                                <span class="mission-step-desc">Induce moral, ethical values and a strong spirit of social commitment among future technologists.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- PEOs & PSOs -->
                <div class="objectives-grid">
                    <div class="objective-box">
                        <h4>Program Educational Objectives (PEOs)</h4>
                        <ul class="objective-list">
                            <li><strong>PEO 1:</strong> Be efficient software developers in diverse fields and become successful professionals and/or pursue higher studies.</li>
                            <li><strong>PEO 2:</strong> Be capable of adapting to advanced computing technology for professional excellence and lifelong learning.</li>
                            <li><strong>PEO 3:</strong> Work productively exhibiting ethical qualities for the betterment of society.</li>
                            <li><strong>PEO 4:</strong> Possess leadership qualities, working harmoniously as team members with effective communication skills.</li>
                        </ul>
                    </div>

                    <div class="objective-box">
                        <h4>Program Specific Outcomes (PSOs)</h4>
                        <ul class="objective-list">
                            <li><strong>PSO 1:</strong> Gain capability to use current and advanced technology, skills, and tools necessary for carrying out real-world multidisciplinary projects.</li>
                            <li><strong>PSO 2:</strong> Achieve an ability to build a computer-based system, process, or component that meets desired technical and societal specifications.</li>
                            <li><strong>PSO 3:</strong> Apply core areas—Data Structures, DBMS, Operating Systems, Computer Architecture, and Software Engineering—to develop innovative solutions.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- TAB 3: FACULTY DIRECTORY -->
            <section class="dept-pane" id="tab-faculty">
                <div class="dept-section-lead-header">
                    <h2 class="dept-section-lead-title">Faculty Members</h2>
                    <p class="dept-section-lead-desc">
                        Our distinguished team of professors, researchers, and mentors committed to scholarly excellence.
                    </p>
                </div>

                <div class="faculty-roster-grid">
                    <div class="faculty-member-card">
                        <div class="faculty-portrait-box">HP</div>
                        <h4 class="faculty-name-title">Dr. H. M. Patel</h4>
                        <div class="faculty-designation">Head of Department &amp; Professor</div>
                        <div class="faculty-qual-text">Ph.D., M.Tech (Information Technology)</div>
                        <a href="mailto:hod_ce@gecmodasa.ac.in" class="faculty-email-link"><i class="fas fa-envelope"></i> hod_ce@gecmodasa.ac.in</a>
                    </div>

                    <div class="faculty-member-card">
                        <div class="faculty-portrait-box">AS</div>
                        <h4 class="faculty-name-title">Prof. A. S. Shah</h4>
                        <div class="faculty-designation">Associate Professor</div>
                        <div class="faculty-qual-text">Ph.D. (Pursuing), M.E. (Information Technology)</div>
                        <a href="mailto:asshah@gecmodasa.ac.in" class="faculty-email-link"><i class="fas fa-envelope"></i> asshah@gecmodasa.ac.in</a>
                    </div>

                    <div class="faculty-member-card">
                        <div class="faculty-portrait-box">RP</div>
                        <h4 class="faculty-name-title">Prof. R. K. Prajapati</h4>
                        <div class="faculty-designation">Assistant Professor</div>
                        <div class="faculty-qual-text">M.E. (Computer Science &amp; Engineering)</div>
                        <a href="mailto:rkprajapati@gecmodasa.ac.in" class="faculty-email-link"><i class="fas fa-envelope"></i> rkprajapati@gecmodasa.ac.in</a>
                    </div>

                    <div class="faculty-member-card">
                        <div class="faculty-portrait-box">PM</div>
                        <h4 class="faculty-name-title">Prof. P. N. Mehta</h4>
                        <div class="faculty-designation">Assistant Professor</div>
                        <div class="faculty-qual-text">M.Tech (Software Engineering)</div>
                        <a href="mailto:pnmehta@gecmodasa.ac.in" class="faculty-email-link"><i class="fas fa-envelope"></i> pnmehta@gecmodasa.ac.in</a>
                    </div>

                    <div class="faculty-member-card">
                        <div class="faculty-portrait-box">SJ</div>
                        <h4 class="faculty-name-title">Prof. S. D. Joshi</h4>
                        <div class="faculty-designation">Assistant Professor</div>
                        <div class="faculty-qual-text">M.E. (Information Technology)</div>
                        <a href="mailto:sdjoshi@gecmodasa.ac.in" class="faculty-email-link"><i class="fas fa-envelope"></i> sdjoshi@gecmodasa.ac.in</a>
                    </div>

                    <div class="faculty-member-card">
                        <div class="faculty-portrait-box">MP</div>
                        <h4 class="faculty-name-title">Prof. M. B. Patel</h4>
                        <div class="faculty-designation">Assistant Professor</div>
                        <div class="faculty-qual-text">M.Tech (Information Technology)</div>
                        <a href="mailto:mbpatel@gecmodasa.ac.in" class="faculty-email-link"><i class="fas fa-envelope"></i> mbpatel@gecmodasa.ac.in</a>
                    </div>
                </div>
            </section>

            <!-- TAB 4: ACTIVITIES -->
            <section class="dept-pane" id="tab-activities">
                <div class="dept-section-lead-header">
                    <h2 class="dept-section-lead-title">Department Activities</h2>
                    <p class="dept-section-lead-desc">
                        Workshops, student technical competitions, hackathons, and industrial field visits organized by the department.
                    </p>
                </div>

                <div class="doc-editorial-grid">
                    <div class="doc-download-card">
                        <h4>CodeFest &amp; Hackathons</h4>
                        <p>Annual technical programming sprint challenging student developers to solve real-world industrial and governance problems using modern software frameworks.</p>
                    </div>
                    <div class="doc-download-card">
                        <h4>Expert Technical Lectures</h4>
                        <p>Distinguished industry architects deliver masterclasses on cloud systems, cybersecurity, distributed microservices, and AI models.</p>
                    </div>
                    <div class="doc-download-card">
                        <h4>Industrial Visits</h4>
                        <p>Field exposure tours to prominent IT and space research organizations including BISAG-N Gandhinagar, TCS Garima Park, and ISRO Space Applications Centre.</p>
                    </div>
                </div>
            </section>

            <!-- TAB 5: FACILITIES & LABS -->
            <section class="dept-pane" id="tab-facilities">
                <div class="dept-section-lead-header">
                    <h2 class="dept-section-lead-title">Laboratories &amp; Facilities</h2>
                    <p class="dept-section-lead-desc">
                        State-of-the-art computing facilities supporting practical curricula from fundamental problem solving to advanced capstone projects.
                    </p>
                </div>

                <div class="labs-editorial-grid">
                    <!-- Lab 1: 8112 Project Lab -->
                    <div class="lab-editorial-card">
                        <div class="lab-photo-wrap">
                            <img src="images/labs/lab_8112_project.jpg" alt="8112 Project Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="lab-info-wrap">
                            <span class="lab-room-badge">Room 8112</span>
                            <h3 class="lab-title-text">Project &amp; Research Lab</h3>
                            <p class="lab-desc-text">Dedicated to final year capstone projects and multidisciplinary innovations with high-performance desktop systems and high-speed network points.</p>
                        </div>
                    </div>

                    <!-- Lab 2: 8113 Programming Lab 1 -->
                    <div class="lab-editorial-card">
                        <div class="lab-photo-wrap">
                            <img src="images/labs/lab_8113_programming1.jpg" alt="8113 Programming Lab 1" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="lab-info-wrap">
                            <span class="lab-room-badge">Room 8113</span>
                            <h3 class="lab-title-text">Programming Laboratory - 1</h3>
                            <p class="lab-desc-text">Dedicated for DBMS, Operating Systems, Computer Graphics, Software Engineering, and Python programming practicals.</p>
                        </div>
                    </div>

                    <!-- Lab 3: 8115 Hardware Lab -->
                    <div class="lab-editorial-card">
                        <div class="lab-photo-wrap">
                            <img src="images/labs/lab_8115_hardware.jpg" alt="8115 Hardware Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="lab-info-wrap">
                            <span class="lab-room-badge">Room 8115</span>
                            <h3 class="lab-title-text">Computer Hardware &amp; Networking Lab</h3>
                            <p class="lab-desc-text">Equipped with digital logic trainers, microprocessor kits, network switches, and IoT experimental setups.</p>
                        </div>
                    </div>

                    <!-- Lab 4: 8116 PPS Lab 2 -->
                    <div class="lab-editorial-card">
                        <div class="lab-photo-wrap">
                            <img src="images/labs/lab_8116_pps2.jpg" alt="8116 PPS Lab 2" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="lab-info-wrap">
                            <span class="lab-room-badge">Room 8116</span>
                            <h3 class="lab-title-text">PPS Laboratory - 2</h3>
                            <p class="lab-desc-text">Designed for Programming for Problem Solving (PPS) courses, enabling freshers to build core algorithmic thinking using C and C++.</p>
                        </div>
                    </div>

                    <!-- Lab 5: 8117 Programming Lab 3 -->
                    <div class="lab-editorial-card">
                        <div class="lab-photo-wrap">
                            <img src="images/labs/lab_8117_programming3.jpg" alt="8117 Programming Lab 3" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="lab-info-wrap">
                            <span class="lab-room-badge">Room 8117</span>
                            <h3 class="lab-title-text">Advanced Programming Lab - 3</h3>
                            <p class="lab-desc-text">High-speed computing lab utilized for web engineering, compiler construction, and machine learning practicals.</p>
                        </div>
                    </div>

                    <!-- Seminar Hall -->
                    <div class="lab-editorial-card">
                        <div class="lab-photo-wrap">
                            <img src="images/labs/seminar_room.jpg" alt="Department Seminar Hall" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="lab-info-wrap">
                            <span class="lab-room-badge">Seminar Hall</span>
                            <h3 class="lab-title-text">Department Seminar Room</h3>
                            <p class="lab-desc-text">Air-conditioned presentation hall equipped with high-resolution projection and conferencing setup for seminars and webinars.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- TAB 6: PUBLICATIONS -->
            <section class="dept-pane" id="tab-publications">
                <div class="dept-section-lead-header">
                    <h2 class="dept-section-lead-title">Faculty Publications</h2>
                    <p class="dept-section-lead-desc">
                        Peer-reviewed international journal articles and conference proceedings published by departmental faculty.
                    </p>
                </div>

                <div class="pub-citation-list">
                    <div class="pub-citation-card">
                        <div class="pub-paper-title">Deep Learning Approaches for Real-Time Network Intrusion Detection in IoT Networks</div>
                        <div class="pub-paper-authors">Dr. H. M. Patel, Prof. A. S. Shah (2024)</div>
                        <div class="pub-paper-venue">International Journal of Information and Computer Security, Vol. 18, Issue 3</div>
                    </div>
                    <div class="pub-citation-card">
                        <div class="pub-paper-title">An Efficient Cryptographic Framework for Cloud Data Integrity Verification</div>
                        <div class="pub-paper-authors">Prof. R. K. Prajapati, Dr. H. M. Patel (2023)</div>
                        <div class="pub-paper-venue">IEEE International Conference on Advanced Computing Technologies (ICACT)</div>
                    </div>
                    <div class="pub-citation-card">
                        <div class="pub-paper-title">Performance Optimization in Distributed Microservices Architecture</div>
                        <div class="pub-paper-authors">Prof. P. N. Mehta (2023)</div>
                        <div class="pub-paper-venue">Springer Communications in Computer and Information Science, Vol. 1422</div>
                    </div>
                    <div class="pub-citation-card">
                        <div class="pub-paper-title">Comparative Analysis of Machine Learning Algorithms for Brain-Computer Interface Applications</div>
                        <div class="pub-paper-authors">Prof. S. D. Joshi, Prof. M. B. Patel (2022)</div>
                        <div class="pub-paper-venue">Elsevier Procedia Computer Science, Vol. 218</div>
                    </div>
                </div>
            </section>

            <!-- TAB 7: INDUSTRY ADVISORY BOARD -->
            <section class="dept-pane" id="tab-advisory-board">
                <div class="dept-section-lead-header">
                    <h2 class="dept-section-lead-title">Industry Advisory Board (IAB)</h2>
                    <p class="dept-section-lead-desc">
                        Corporate leaders and researchers guiding curriculum relevance, technical skills, and industry placement standards.
                    </p>
                </div>

                <div class="dept-clean-table-wrap">
                    <table class="dept-clean-table">
                        <thead>
                            <tr>
                                <th>Member Name</th>
                                <th>Organization &amp; Designation</th>
                                <th>Committee Role</th>
                                <th>Term</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Dr. H. M. Patel</strong></td>
                                <td>Head of Department, Information Technology, GEC Modasa</td>
                                <td>Chairman</td>
                                <td>2025-26</td>
                            </tr>
                            <tr>
                                <td><strong>Mr. Nirav Joshi</strong></td>
                                <td>Senior Cloud Architect, Tata Consultancy Services (TCS)</td>
                                <td>Industry Member</td>
                                <td>2025-26</td>
                            </tr>
                            <tr>
                                <td><strong>Ms. Pooja Sharma</strong></td>
                                <td>Lead Data Scientist, Infosys Limited</td>
                                <td>Industry Member</td>
                                <td>2025-26</td>
                            </tr>
                            <tr>
                                <td><strong>Prof. A. S. Shah</strong></td>
                                <td>Associate Professor, Information Technology, GEC Modasa</td>
                                <td>Member Secretary</td>
                                <td>2025-26</td>
                            </tr>
                            <tr>
                                <td><strong>Mr. Rajesh Vaghela</strong></td>
                                <td>VP Engineering, eInfochips</td>
                                <td>Industry Member</td>
                                <td>2023-24</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- TAB 8: NEWSLETTERS -->
            <section class="dept-pane" id="tab-newsletters">
                <div class="dept-section-lead-header">
                    <h2 class="dept-section-lead-title">Department Newsletters</h2>
                    <p class="dept-section-lead-desc">
                        Official periodicals documenting faculty achievements, student innovations, and campus milestones.
                    </p>
                </div>

                <div class="doc-editorial-grid">
                    <div class="doc-download-card">
                        <h4>InfoTech Pulse — Vol. 1 Issue 2</h4>
                        <p>Highlights of CodeFest 2024, expert guest talks by industry researchers, student hackathon victories, and academic publications.</p>
                        <a href="#" class="doc-btn-link"><i class="fas fa-file-pdf"></i> Download Newsletter (PDF)</a>
                    </div>
                    <div class="doc-download-card">
                        <h4>InfoTech Pulse — Vol. 1 Issue 1</h4>
                        <p>Inaugural issue covering AICTE networking grant milestones, laboratory modernization, and alumni career achievements.</p>
                        <a href="#" class="doc-btn-link"><i class="fas fa-file-pdf"></i> Download Newsletter (PDF)</a>
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