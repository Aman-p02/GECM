<?php
// Page configuration
$page_title = "Department of Computer Engineering — Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/computer/css/department.css";
$extra_js = "departments/computer/js/department.js";

// Include Header
include_once __DIR__ . '/../../includes/header.php';
?>

<!-- ========================================================
     1. Department Page Hero
     ======================================================== -->
<section class="dept-hero-section" id="overview">
    <div class="dept-container">
        
        <!-- Breadcrumbs -->
        <nav class="dept-breadcrumb" aria-label="Breadcrumb">
            <a href="<?= $root_path ?>">Home</a>
            <span class="bc-sep">/</span>
            <a href="<?= $root_path ?>#departments">Departments</a>
            <span class="bc-sep">/</span>
            <span class="bc-current">Computer Engineering</span>
        </nav>

        <!-- Hero Content Grid -->
        <div class="dept-hero-grid">
            <div class="dept-hero-text">
                <span class="dept-eyebrow">DEPARTMENT OF</span>
                <h1 class="dept-headline">Computer Engineering</h1>
                <p class="dept-lead">
                    Pioneering computational science, algorithmic foundations, and ethical engineering education to solve critical challenges for industry and society.
                </p>
                <div class="dept-hero-actions">
                    <a href="#overview-details" class="btn-editorial-primary">Explore Overview</a>
                    <a href="#faculty" class="btn-editorial-ghost">Meet Faculty &rarr;</a>
                </div>
            </div>

            <div class="dept-hero-media">
                <div class="dept-hero-frame">
                    <img src="images/labs/lab_8113_programming1.jpg" 
                         alt="Students working collaboratively in the Computer Engineering Laboratory" 
                         class="dept-hero-img">
                    <span class="dept-img-caption">Advanced Computing &amp; Algorithm Research Laboratory &mdash; Room 101</span>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ========================================================
     2. Department Statistics Strip
     ======================================================== -->
<section class="dept-stats-strip" aria-label="Department Overview Statistics">
    <div class="dept-container">
        <div class="dept-stats-grid">
            <div class="stat-item">
                <span class="stat-number">2000</span>
                <span class="stat-label">Established</span>
            </div>
            <div class="stat-divider" aria-hidden="true"></div>
            <div class="stat-item">
                <span class="stat-number">120</span>
                <span class="stat-label">Annual Intake</span>
            </div>
            <div class="stat-divider" aria-hidden="true"></div>
            <div class="stat-item">
                <span class="stat-number">06</span>
                <span class="stat-label">Specialised Laboratories</span>
            </div>
            <div class="stat-divider" aria-hidden="true"></div>
            <div class="stat-item">
                <span class="stat-number">25</span>
                <span class="stat-label">Faculty Members</span>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================
     3. Department Subnavigation (Sticky Secondary Bar)
     ======================================================== -->
<nav class="dept-subnav" id="deptSubnav" aria-label="Department Sections Navigation">
    <div class="dept-container">
        <ul class="dept-subnav-list">
            <li><a href="#overview-details" class="subnav-link active">Overview</a></li>
            <li><a href="#hod-message" class="subnav-link">Head of Department</a></li>
            <li><a href="#faculty" class="subnav-link">People</a></li>
            <li><a href="#laboratories" class="subnav-link">Laboratories</a></li>
            <li><a href="#history" class="subnav-link">History</a></li>
            <li><a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="subnav-link">Syllabus <i class="fas fa-external-link-alt subnav-ext"></i></a></li>
            <li><a href="#downloads" class="subnav-link">Downloads</a></li>
        </ul>
    </div>
</nav>

<!-- ========================================================
     4. Overview Section (Asymmetric Editorial Layout)
     ======================================================== -->
<section class="dept-section dept-overview-section" id="overview-details">
    <div class="dept-container">
        <div class="editorial-grid">
            
            <!-- Left Column: Heading & Eyebrow -->
            <div class="editorial-col-left">
                <span class="section-label">OVERVIEW</span>
                <h2 class="editorial-heading">
                    Building Technology for a Better Society
                </h2>
            </div>

            <!-- Right Column: Narrative Body -->
            <div class="editorial-col-right">
                <p class="editorial-lead-text">
                    Established in the year 2000, the Department of Computer Engineering at Government Engineering College, Modasa has steadily grown into a center of rigorous academic instruction, innovative research, and technical leadership in North Gujarat.
                </p>
                <p class="editorial-body-text">
                    Our curriculum synthesizes foundational theoretical paradigms in computer science with contemporary applied engineering practices. Students master data structures, algorithm design, operating systems, distributed architectures, database engines, and machine intelligence while participating in intensive hands-on lab experiments.
                </p>
                <p class="editorial-body-text">
                    Through state-of-the-art computational infrastructure, industry-supported project mentors, and regular participation in national hackathons and symposiums, we prepare future engineers who possess exceptional analytical abilities and an unwavering commitment to societal well-being.
                </p>
                <div class="editorial-link-wrapper">
                    <a href="#laboratories" class="editorial-arrow-link">
                        Discover the Department &rarr;
                    </a>
                </div>
            </div>

        </div>

        <!-- Full-Width Editorial Architectural Campus Photography -->
        <div class="editorial-feature-media">
            <img src="<?= $root_path ?>images/hero_campus_1.jpg" 
                 alt="Main Administrative and Academic Campus Quadrangle, GEC Modasa" 
                 class="editorial-feature-img">
            <div class="editorial-feature-caption">
                <span>Academic Block &amp; Computing Faculty Quadrangle &mdash; GEC Modasa Campus</span>
            </div>
        </div>

    </div>
</section>

<!-- ========================================================
     5. Head of Department Section (Editorial Magazine Feature)
     ======================================================== -->
<section class="dept-section dept-hod-section bg-warm" id="hod-message">
    <div class="dept-container">
        <div class="hod-editorial-layout">
            
            <!-- HOD Portrait -->
            <div class="hod-portrait-column">
                <div class="hod-portrait-frame">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=800&q=80" 
                         alt="Portrait of Dr. R. K. Patel, Head of Department" 
                         class="hod-portrait-img">
                </div>
                <div class="hod-credentials-mobile">
                    <h3 class="hod-name">Dr. R. K. Patel</h3>
                    <p class="hod-title">Professor &amp; Head of Department</p>
                    <p class="hod-degrees">Ph.D. (CSE), M.E. (Computer Engg), B.E.</p>
                </div>
            </div>

            <!-- HOD Quote & Statement -->
            <div class="hod-narrative-column">
                <span class="section-label">HEAD OF DEPARTMENT</span>
                
                <blockquote class="hod-pullquote">
                    &ldquo;We aim to create not just skilled professionals, but responsible technologists who use computing for the greater good of society.&rdquo;
                </blockquote>

                <div class="hod-message-body">
                    <p>
                        In an era dominated by rapid computational transformation, our foremost duty as educators is to instill deep mathematical intuition and analytical resilience. Technology is only as impactful as the principles guiding its architects.
                    </p>
                    <p>
                        At GEC Modasa, we actively encourage our students to look beyond lines of code and examine how software solutions affect human lives, public welfare, and national progress. Our graduates leave campus prepared to lead ethically and engineer fearlessly.
                    </p>
                </div>

                <div class="hod-signature-block desktop-only">
                    <h3 class="hod-name">Dr. R. K. Patel</h3>
                    <p class="hod-title">Professor &amp; Head of Department</p>
                    <p class="hod-dept">Department of Computer Engineering, GEC Modasa</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ========================================================
     6. Faculty Section (Minimalist Directory with Search & Filter)
     ======================================================== -->
<section class="dept-section" id="faculty">
    <div class="dept-container">
        
        <!-- Section Header -->
        <div class="section-heading-row">
            <div>
                <span class="section-label">PEOPLE</span>
                <h2 class="editorial-heading">Faculty Members</h2>
            </div>
            <p class="section-heading-sub">
                Our faculty members combine doctoral research credentials, extensive pedagogical experience, and dedicated mentorship.
            </p>
        </div>

        <!-- Filter & Search Controls Bar -->
        <div class="faculty-controls-bar">
            <div class="faculty-filter-pills" role="tablist" aria-label="Faculty Rank Filter">
                <button class="filter-pill active" data-filter="all">All (8)</button>
                <button class="filter-pill" data-filter="Professor">Professors</button>
                <button class="filter-pill" data-filter="Associate Professor">Associate Professors</button>
                <button class="filter-pill" data-filter="Assistant Professor">Assistant Professors</button>
            </div>
            <div class="faculty-search-box">
                <i class="fas fa-search search-icon" aria-hidden="true"></i>
                <input type="text" id="facultySearchInput" class="faculty-search-input" placeholder="Search by name or field..." aria-label="Search faculty members">
            </div>
        </div>

        <!-- Borderless 4-Column Grid -->
        <div class="faculty-editorial-grid" id="facultyGrid">
            
            <!-- Faculty Card 1 -->
            <article class="faculty-member-item" data-designation="Professor" data-name="Dr. R. K. Patel" data-field="Distributed Systems, Cloud Architecture">
                <div class="faculty-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80" alt="Dr. R. K. Patel" class="faculty-img">
                </div>
                <div class="faculty-details">
                    <h3 class="faculty-name">Dr. R. K. Patel</h3>
                    <p class="faculty-rank">Professor &amp; Head</p>
                    <p class="faculty-meta">Ph.D., Distributed Cloud Systems</p>
                </div>
            </article>

            <!-- Faculty Card 2 -->
            <article class="faculty-member-item" data-designation="Associate Professor" data-name="Prof. S. M. Shah" data-field="Machine Learning, Data Mining">
                <div class="faculty-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80" alt="Prof. S. M. Shah" class="faculty-img">
                </div>
                <div class="faculty-details">
                    <h3 class="faculty-name">Prof. S. M. Shah</h3>
                    <p class="faculty-rank">Associate Professor</p>
                    <p class="faculty-meta">M.E., Machine Learning &amp; AI</p>
                </div>
            </article>

            <!-- Faculty Card 3 -->
            <article class="faculty-member-item" data-designation="Associate Professor" data-name="Dr. A. N. Joshi" data-field="Cybersecurity, Cryptography, Blockchain">
                <div class="faculty-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&q=80" alt="Dr. A. N. Joshi" class="faculty-img">
                </div>
                <div class="faculty-details">
                    <h3 class="faculty-name">Dr. A. N. Joshi</h3>
                    <p class="faculty-rank">Associate Professor</p>
                    <p class="faculty-meta">Ph.D., Network Security &amp; Cryptography</p>
                </div>
            </article>

            <!-- Faculty Card 4 -->
            <article class="faculty-member-item" data-designation="Assistant Professor" data-name="Prof. M. K. Desai" data-field="Database Management, Big Data Analytics">
                <div class="faculty-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80" alt="Prof. M. K. Desai" class="faculty-img">
                </div>
                <div class="faculty-details">
                    <h3 class="faculty-name">Prof. M. K. Desai</h3>
                    <p class="faculty-rank">Assistant Professor</p>
                    <p class="faculty-meta">M.Tech, Database Engine Optimisation</p>
                </div>
            </article>

            <!-- Faculty Card 5 -->
            <article class="faculty-member-item" data-designation="Assistant Professor" data-name="Prof. P. H. Mehta" data-field="Computer Networks, IoT Systems">
                <div class="faculty-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=600&q=80" alt="Prof. P. H. Mehta" class="faculty-img">
                </div>
                <div class="faculty-details">
                    <h3 class="faculty-name">Prof. P. H. Mehta</h3>
                    <p class="faculty-rank">Assistant Professor</p>
                    <p class="faculty-meta">M.E., Wireless Sensor Networks</p>
                </div>
            </article>

            <!-- Faculty Card 6 -->
            <article class="faculty-member-item" data-designation="Assistant Professor" data-name="Prof. K. B. Trivedi" data-field="Software Engineering, Web Architectures">
                <div class="faculty-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=600&q=80" alt="Prof. K. B. Trivedi" class="faculty-img">
                </div>
                <div class="faculty-details">
                    <h3 class="faculty-name">Prof. K. B. Trivedi</h3>
                    <p class="faculty-rank">Assistant Professor</p>
                    <p class="faculty-meta">M.Tech, High-Availability Systems</p>
                </div>
            </article>

            <!-- Faculty Card 7 -->
            <article class="faculty-member-item" data-designation="Assistant Professor" data-name="Prof. H. J. Parmar" data-field="Algorithms, Theory of Computation">
                <div class="faculty-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=600&q=80" alt="Prof. H. J. Parmar" class="faculty-img">
                </div>
                <div class="faculty-details">
                    <h3 class="faculty-name">Prof. H. J. Parmar</h3>
                    <p class="faculty-rank">Assistant Professor</p>
                    <p class="faculty-meta">M.E., Automata &amp; Complexity</p>
                </div>
            </article>

            <!-- Faculty Card 8 -->
            <article class="faculty-member-item" data-designation="Assistant Professor" data-name="Prof. N. D. Vaghela" data-field="Compiler Design, Computer Vision">
                <div class="faculty-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=600&q=80" alt="Prof. N. D. Vaghela" class="faculty-img">
                </div>
                <div class="faculty-details">
                    <h3 class="faculty-name">Prof. N. D. Vaghela</h3>
                    <p class="faculty-rank">Assistant Professor</p>
                    <p class="faculty-meta">M.Tech, Deep Learning &amp; Vision</p>
                </div>
            </article>

        </div>

        <div id="noFacultyMatch" class="no-records-msg" style="display: none;">
            <p>No faculty members match your search criteria.</p>
        </div>

    </div>
</section>

<!-- ========================================================
     7. Laboratories Section (Large Editorial Showcase)
     ======================================================== -->
<section class="dept-section bg-warm" id="laboratories">
    <div class="dept-container">
        
        <div class="section-heading-row">
            <div>
                <span class="section-label">FACILITIES</span>
                <h2 class="editorial-heading">Our Laboratories</h2>
            </div>
            <p class="section-heading-sub">
                Equipped with dedicated workstation nodes, gigabit LAN connectivity, and industry-standard software environments.
            </p>
        </div>

        <div class="laboratories-editorial-stack">
            
            <!-- Lab 1: Programming Laboratory -->
            <article class="lab-editorial-item">
                <div class="lab-media">
                    <img src="images/labs/lab_8116_pps2.jpg" alt="Programming Laboratory Room 101" class="lab-img">
                </div>
                <div class="lab-text">
                    <div class="lab-meta-tag">ROOM 101 &bull; 30 WORKSTATIONS</div>
                    <h3 class="lab-name">Programming Laboratory</h3>
                    <p class="lab-desc">
                        Dedicated to foundational problem solving, data structure implementations, and object-oriented paradigms. Supports multi-language development suites including GNU C/C++, OpenJDK Java, Python 3, and Rust environments.
                    </p>
                    <ul class="lab-features-list">
                        <li><span>Core Curriculum:</span> Data Structures, Algorithms, OOP with Java</li>
                        <li><span>Equipment:</span> Intel Core i5 Nodes, Gigabit Ethernet, Ubuntu Linux</li>
                    </ul>
                </div>
            </article>

            <!-- Lab 2: Computer Networks Laboratory -->
            <article class="lab-editorial-item reverse">
                <div class="lab-media">
                    <img src="images/labs/lab_8115_hardware.jpg" alt="Computer Networks Laboratory Room 102" class="lab-img">
                </div>
                <div class="lab-text">
                    <div class="lab-meta-tag">ROOM 102 &bull; MANAGED SWITCHES &amp; ROUTERS</div>
                    <h3 class="lab-name">Computer Networks Laboratory</h3>
                    <p class="lab-desc">
                        Provides a physical and simulated environment for topology design, packet-level protocol analysis, and network security testing. Equipped with Cisco hardware routers, managed 24-port switches, Wireshark, and NS-3 simulators.
                    </p>
                    <ul class="lab-features-list">
                        <li><span>Core Curriculum:</span> Computer Networks, Network Security, Packet Routing</li>
                        <li><span>Equipment:</span> Cisco Layer-3 Switches, Wireshark, Mininet SDN</li>
                    </ul>
                </div>
            </article>

            <!-- Lab 3: Database Systems Laboratory -->
            <article class="lab-editorial-item">
                <div class="lab-media">
                    <img src="images/labs/lab_8117_programming3.jpg" alt="Database Systems Laboratory Room 103" class="lab-img">
                </div>
                <div class="lab-text">
                    <div class="lab-meta-tag">ROOM 103 &bull; HIGH-MEMORY SERVER NODES</div>
                    <h3 class="lab-name">Database Systems Laboratory</h3>
                    <p class="lab-desc">
                        Facilitates practical experimentation in relational algebra, transaction management, query optimization, and NoSQL document architectures using PostgreSQL, Oracle Database 19c, and Apache Hadoop ecosystems.
                    </p>
                    <ul class="lab-features-list">
                        <li><span>Core Curriculum:</span> DBMS, Advanced SQL, Distributed Big Data</li>
                        <li><span>Equipment:</span> Dedicated Database Server, Dual Monitor Nodes</li>
                    </ul>
                </div>
            </article>

        </div>

    </div>
</section>

<!-- ========================================================
     8. Department History (Minimalist Editorial Timeline)
     ======================================================== -->
<section class="dept-section" id="history">
    <div class="dept-container">
        
        <div class="section-heading-row">
            <div>
                <span class="section-label">HERITAGE</span>
                <h2 class="editorial-heading">Department Milestones</h2>
            </div>
            <p class="section-heading-sub">
                A timeline of educational commitment, capacity expansion, and academic modernisation over two decades.
            </p>
        </div>

        <div class="dept-timeline-container">
            
            <div class="timeline-row">
                <div class="timeline-year">2000</div>
                <div class="timeline-line-marker">
                    <span class="timeline-dot"></span>
                </div>
                <div class="timeline-content">
                    <h3 class="timeline-event-title">Department Established</h3>
                    <p class="timeline-event-desc">
                        Founded alongside Government Engineering College, Modasa, under the Department of Technical Education, Government of Gujarat, with an initial intake of 60 undergraduate seats.
                    </p>
                </div>
            </div>

            <div class="timeline-row">
                <div class="timeline-year">2008</div>
                <div class="timeline-line-marker">
                    <span class="timeline-dot"></span>
                </div>
                <div class="timeline-content">
                    <h3 class="timeline-event-title">Intake Capacity Doubled</h3>
                    <p class="timeline-event-desc">
                        Sanctioned intake increased from 60 to 120 seats to address the burgeoning national demand for skilled software engineers and computational researchers.
                    </p>
                </div>
            </div>

            <div class="timeline-row">
                <div class="timeline-year">2015</div>
                <div class="timeline-line-marker">
                    <span class="timeline-dot"></span>
                </div>
                <div class="timeline-content">
                    <h3 class="timeline-event-title">Laboratory Modernisation</h3>
                    <p class="timeline-event-desc">
                        Complete overhaul of network cabling, computing nodes, and hardware peripherals. Installation of centralized high-throughput campus broadband.
                    </p>
                </div>
            </div>

            <div class="timeline-row">
                <div class="timeline-year">2020</div>
                <div class="timeline-line-marker">
                    <span class="timeline-dot"></span>
                </div>
                <div class="timeline-content">
                    <h3 class="timeline-event-title">Research &amp; Innovation Initiatives</h3>
                    <p class="timeline-event-desc">
                        Establishment of specialized AI, ML, and Cyber Security student research clusters resulting in multiple sponsored hackathon achievements and journal publications.
                    </p>
                </div>
            </div>

            <div class="timeline-row">
                <div class="timeline-year">2024</div>
                <div class="timeline-line-marker">
                    <span class="timeline-dot"></span>
                </div>
                <div class="timeline-content">
                    <h3 class="timeline-event-title">Academic &amp; Pedagogical Advancement</h3>
                    <p class="timeline-event-desc">
                        Integration of modern outcome-based engineering competencies in compliance with National Board of Accreditation (NBA) benchmarks and AICTE guidelines.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ========================================================
     9. Downloads & Resources Section
     ======================================================== -->
<section class="dept-section bg-warm" id="downloads">
    <div class="dept-container">
        
        <div class="section-heading-row">
            <div>
                <span class="section-label">ACADEMIC RESOURCES</span>
                <h2 class="editorial-heading">Downloads &amp; Documents</h2>
            </div>
            <p class="section-heading-sub">
                Official syllabus circulars, lab guidelines, and instructional resources for students.
            </p>
        </div>

        <div class="downloads-editorial-grid">
            
            <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="download-doc-item">
                <div class="doc-icon"><i class="far fa-file-pdf"></i></div>
                <div class="doc-meta">
                    <h4 class="doc-title">B.E. Computer Engineering Syllabus (GTU)</h4>
                    <span class="doc-info">Semester 1 to 8 Full Curriculum &bull; GTU Official Portal</span>
                </div>
                <div class="doc-action"><i class="fas fa-arrow-down"></i></div>
            </a>

            <a href="#" class="download-doc-item">
                <div class="doc-icon"><i class="far fa-file-alt"></i></div>
                <div class="doc-meta">
                    <h4 class="doc-title">Academic Calendar &mdash; Odd Semester 2026-27</h4>
                    <span class="doc-info">Term dates, Mid-sem examinations, &amp; Submissions &bull; PDF 420 KB</span>
                </div>
                <div class="doc-action"><i class="fas fa-arrow-down"></i></div>
            </a>

            <a href="#" class="download-doc-item">
                <div class="doc-icon"><i class="far fa-file-pdf"></i></div>
                <div class="doc-meta">
                    <h4 class="doc-title">Laboratory Code of Conduct &amp; Safety Norms</h4>
                    <span class="doc-info">General rules for software &amp; networking labs &bull; PDF 280 KB</span>
                </div>
                <div class="doc-action"><i class="fas fa-arrow-down"></i></div>
            </a>

            <a href="#" class="download-doc-item">
                <div class="doc-icon"><i class="far fa-file-alt"></i></div>
                <div class="doc-meta">
                    <h4 class="doc-title">Final Year Major Project Guidelines &amp; Template</h4>
                    <span class="doc-info">Format specification for thesis report and synopsis &bull; PDF 650 KB</span>
                </div>
                <div class="doc-action"><i class="fas fa-arrow-down"></i></div>
            </a>

        </div>

    </div>
</section>

<?php
// Include Footer
include_once __DIR__ . '/../../includes/footer.php';
?>
