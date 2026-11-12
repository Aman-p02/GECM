<?php
// Set Page Variables
$page_title = "Department of Science & Humanities - Government Engineering College, Modasa";
$page_description = "Department of Science & Humanities at GEC Modasa. Imparting fundamental engineering theories in Physics, Mathematics, English Communication, and Management.";
$page_keywords = "Science and Humanities GEC Modasa, Physics Lab Modasa, Engineering Mathematics Gujarat, GEC Modasa Humanities";

$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/science-and-humanities/css/department.css";
$extra_js = "departments/science-and-humanities/js/department.js";

$deptCode = 'SH';
$deptName = 'Science & Humanities';

// Include Header
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../includes/department-seo.php';
?>
<link rel="stylesheet" href="../includes/faculty.css">
<link rel="stylesheet" href="../includes/activities.css">
<link rel="stylesheet" href="../includes/publications.css?v=2.4">
<link rel="stylesheet" href="../includes/advisory-board.css">
<link rel="stylesheet" href="../includes/newsletters.css">

<div class="dept-page" id="mainContent" data-active-tab="about">

    <!-- Sticky sub-navigation bar -->
    <nav class="dept-subnav-bar" id="deptSubNav" aria-label="Department Navigation">
        <div class="dept-container">
            <div class="dept-subnav-wrapper">
                <ul class="dept-subnav-list" role="tablist">
                    <li class="dept-subnav-item active">
                        <button type="button" class="dept-subnav-link active" data-tab="about" role="tab" aria-selected="true">About Department</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="faculty" role="tab" aria-selected="false">Faculty</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="activities" role="tab" aria-selected="false">Activities</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="facilities" role="tab" aria-selected="false">Facilities</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="publications" role="tab" aria-selected="false">Publications</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="advisory-board" role="tab" aria-selected="false">Advisory Board</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="newsletters" role="tab" aria-selected="false">Newsletters</button>
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
                <div class="dept-about-hero" style="margin-bottom: 56px;">
                    <div class="dept-hero-grid">
                        <div class="dept-hero-text">
                            <span class="dept-kicker">DEPARTMENT OF</span>
                            <h1 class="dept-heading">Science &amp; Humanities</h1>
                            <p class="dept-tagline">
                                Imparting foundational education in Physics, Mathematics, Communication Skills, and Management to develop strong scientific acumen and core competencies.
                            </p>
                        </div>
                        <div class="dept-hero-media">
                            <img src="images/department_building.jpg" alt="Government Engineering College Modasa - Science and Humanities Department Building" class="dept-hero-photo">
                        </div>
                    </div>

                    <!-- Key metrics counter strip -->
                    <div class="dept-stats-strip">
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">Bld 01</span>
                            <span class="dept-stat-label">MAIN CAMPUS PREMISES</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">4+</span>
                            <span class="dept-stat-label">SPECIALIZED LABS</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">300+</span>
                            <span class="dept-stat-label">HOURS/WEEK TEACHING LOAD</span>
                        </div>
                        <div class="dept-stat-item">
                            <span class="dept-stat-num">ISI/BIS</span>
                            <span class="dept-stat-label">TESTING STANDARDS</span>
                        </div>
                    </div>
                </div>

                <div class="dept-section-header">
                    <span class="dept-section-kicker">ACADEMIC OVERVIEW</span>
                    <h2>About the Department</h2>
                    <p>Building strong analytical and scientific foundations across all engineering disciplines.</p>
                </div>

                <div class="dept-story-body">
                    <blockquote class="dept-lead-quote">
                        "Fostering fundamental scientific inquiry, mathematical rigor, and humanistic values for budding engineers."
                    </blockquote>
                    <p>
                        The Department of Science and Humanities is accommodated in the main building (01). This interdisciplinary department is actively engaged in teaching core foundational subjects including Mathematics, Communication Skills (English), Contributor Personality Development, Physics, and Management.
                    </p>
                    <p>
                        The department imparts education on fundamental theories and principles essential to engineering sciences. The well-equipped Physics laboratory provides hands-on experimental learning with instruments such as Hall Effect apparatus, Four Probe resistivity meters, Ultrasonic velocity meters, and Hysteresis curve tracers. English communication is enhanced through the Language Laboratory and multimedia resources.
                    </p>
                    <p>
                        The department actively organizes workshops, technical seminars, and expert guest lectures by eminent scholars from leading universities to enrich students' academic acumen and professional personality.
                    </p>
                </div>

                <!-- Core Academic Pillars -->
                <div class="dept-programme-section">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">DISCIPLINE DOMAINS</span>
                        <h2>Core Specializations</h2>
                        <p>Providing interdisciplinary scientific rigor and essential soft skills across four key academic domains.</p>
                    </div>

                    <div class="dept-avenues-grid">
                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-atom"></i></div>
                                <h4>Engineering Physics</h4>
                            </div>
                            <p>Experimental studies in optics, semiconductor physics, magnetic hysteresis, and solid-state characterization.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-square-root-alt"></i></div>
                                <h4>Engineering Mathematics</h4>
                            </div>
                            <p>Rigorous mathematical training in calculus, linear algebra, numerical methods, and differential equations.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-comments"></i></div>
                                <h4>Professional Communication</h4>
                            </div>
                            <p>Multimedia language lab training in English phonetics, listening comprehension, presentation, and technical writing.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-user-tie"></i></div>
                                <h4>Personality &amp; Management</h4>
                            </div>
                            <p>Contributor personality development, ethical values, leadership skills, and engineering management principles.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab: Faculty Directory (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/faculty-tab.php'; ?>

            <!-- Tab: Activities & Events (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/activities-tab.php'; ?>

            <!-- Tab 2: Laboratory facilities -->
            <section class="dept-tab-pane" id="tab-facilities">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">EXPERIMENTAL INFRASTRUCTURE</span>
                    <h2>Laboratories &amp; Facilities</h2>
                    <p>Located in the main building, well equipped with standard experimental setups and multimedia learning resources.</p>
                </div>

                <!-- Laboratory Photo Showcase (Concise 1-line descriptions) -->
                <div class="dept-labs-showcase">
                    <!-- Lab 1: Physics Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_physics.jpg" alt="Physics Laboratory" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Main Building</span>
                            <h3 class="dept-lab-title">Physics Laboratory</h3>
                            <p class="dept-lab-desc">
                                Hall effect setups, four-probe resistivity meters, ultrasonic velocity kits, and B-H curve tracers.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 2: Language Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_language.jpg" alt="Language & Communication Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Main Building</span>
                            <h3 class="dept-lab-title">Language &amp; Communication Lab</h3>
                            <p class="dept-lab-desc">
                                Computerized audio-visual speech booths and multimedia English language learning software.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 3: Mathematics Tutorial Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_mathematics.jpg" alt="Mathematics Tutorial Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Main Building</span>
                            <h3 class="dept-lab-title">Mathematics Tutorial Cell</h3>
                            <p class="dept-lab-desc">
                                Interactive computational tutorial workspace for calculus, numerical analysis, and modeling.
                            </p>
                        </div>
                    </div>

                    <!-- Lab 4: CPD & Seminar Hall -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_cpd_seminar.jpg" alt="Personality Development & Seminar Hall" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Main Building</span>
                            <h3 class="dept-lab-title">CPD &amp; Seminar Facility</h3>
                            <p class="dept-lab-desc">
                                Dedicated presentation and seminar hall for group discussions, grooming, and expert lectures.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Key Department Facilities (Crisp 1-liners) -->
                <div class="dept-section-header" style="margin-top: 56px;">
                    <span class="dept-section-kicker">KEY ASSETS</span>
                    <h2>Department Facilities</h2>
                    <p>Modern experimental equipment, audio-visual classrooms, and academic resources.</p>
                </div>

                <div class="dept-facilities-grid">
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-wave-square"></i></div>
                        <div class="dept-facility-info">
                            <h4>Ultrasonic &amp; Optics Benches</h4>
                            <p>Ultrasonic interferometer and laser optic kits for wave velocity determination.</p>
                        </div>
                    </div>

                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-magnet"></i></div>
                        <div class="dept-facility-info">
                            <h4>Magnetic Hysteresis Tracer</h4>
                            <p>Apparatus for testing ferromagnetic core loss and magnetic coercivity.</p>
                        </div>
                    </div>

                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-microchip"></i></div>
                        <div class="dept-facility-info">
                            <h4>Four-Probe Semiconductor Bench</h4>
                            <p>Setup for band gap energy and resistivity measurement in semiconductor wafers.</p>
                        </div>
                    </div>

                    <div class="dept-facility-item">
                        <div class="dept-facility-info"><i class="fas fa-headphones"></i></div>
                        <div class="dept-facility-info">
                            <h4>Audio-Visual Language Console</h4>
                            <p>Interactive listening booths with BBC audio-visual archives and speech modules.</p>
                        </div>
                    </div>

                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-calculator"></i></div>
                        <div class="dept-facility-info">
                            <h4>Mathematics Tutorial Center</h4>
                            <p>Weekly tutorial sessions supporting 300+ hours of academic problem-solving load.</p>
                        </div>
                    </div>

                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-book-reader"></i></div>
                        <div class="dept-facility-info">
                            <h4>Departmental Reference Library</h4>
                            <p>Curated collection of reference texts in physics, mathematics, and linguistics.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab: Publications (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/publications-tab.php'; ?>

            <!-- Tab: Advisory Board (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/advisory-board-tab.php'; ?>

            <!-- Tab: Newsletters (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/newsletters-tab.php'; ?>

        </div>
    </main>

</div>

<?php
// Include Footer
include_once __DIR__ . '/../../includes/footer.php';
?>
