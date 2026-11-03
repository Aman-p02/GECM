<?php
$page_title = "Civil Engineering | Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";

include_once __DIR__ . '/../../includes/header.php';
?>

<link rel="stylesheet" href="css/department.css">

<div class="dept-page" id="mainContent">

    <!-- Hero Header Banner -->
    <header class="dept-hero-banner" role="banner">
        <div class="dept-container">
            <div class="dept-hero-grid">
                <div class="dept-hero-text">
                    <span class="dept-kicker">DEPARTMENT OF</span>
                    <h1 class="dept-heading">Civil Engineering</h1>
                    <p class="dept-tagline">
                        Housed in the main building of the college, imparting practical knowledge and excellence in Surveying, Fluid Mechanics, Transportation, Environmental Engineering, and Geology since 1984.
                    </p>
                </div>
                <div class="dept-hero-media">
                    <img src="images/department_building.jpg" alt="Government Engineering College Modasa - Civil Engineering Department" class="dept-hero-photo" onerror="this.src='../../images/hero_campus_1.jpg'">
                </div>
            </div>

            <!-- Key metrics counter strip -->
            <div class="dept-stats-strip">
                <div class="dept-stat-item">
                    <span class="dept-stat-num">1984</span>
                    <span class="dept-stat-label">ESTABLISHED YEAR</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">120</span>
                    <span class="dept-stat-label">ANNUAL UG INTAKE</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">18</span>
                    <span class="dept-stat-label">ANNUAL PG INTAKE</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">10</span>
                    <span class="dept-stat-label">SPECIALIZED LABORATORIES</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Sub-navigation bar -->
    <nav class="dept-subnav-bar" id="deptSubNav" aria-label="Department Navigation">
        <div class="dept-container">
            <div class="dept-subnav-wrap">
                <ul class="dept-subnav-list" role="tablist">
                    <li class="dept-subnav-item active">
                        <button type="button" class="dept-subnav-link active" data-tab="about" role="tab" aria-selected="true">About Department</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="vision-mission" role="tab" aria-selected="false">Vision &amp; Mission</button>
                    </li>
                    <li class="dept-subnav-item">
                        <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="dept-subnav-link" aria-label="GTU Official Syllabus Portal">
                            <span>Syllabus</span>
                            <i class="fas fa-external-link-alt ext-arrow"></i>
                        </a>
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main department content sections -->
    <main class="dept-main-content">
        <div class="dept-container">

            <!-- Tab 1: About Department -->
            <section class="dept-tab-pane active" id="tab-about">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">ACADEMIC OVERVIEW</span>
                    <h2>About Department</h2>
                    <p>Fostering academic rigor, experimental infrastructure, and professional engineering skills in Civil Engineering.</p>
                </div>

                <div class="dept-story-body">
                    <blockquote class="dept-lead-quote">
                        "Civil Engineering is one of the broadest and oldest of the engineering disciplines, extending across many technical specialties to plan, design, construct, and sustain modern infrastructure."
                    </blockquote>
                    <p>
                        This department is housed in the main building of the college. It has laboratories for Surveying, Fluid Mechanics, Transport Engineering, Environmental Engineering and Geology for strengthening the practical knowledge of the students in various areas.
                    </p>
                    <p>
                        This department has laboratories for Surveying, Fluid Mechanics, Transportation Engineering, Environmental Engineering and Geology. These laboratories are imparting practical knowledge of the subject area. Department is also offering Post Graduate course in Transport Engineering since 2010.
                    </p>
                </div>

                <!-- About the Programme Section -->
                <div class="dept-programme-section">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">DISCIPLINE &amp; CAREER PATHS</span>
                        <h2>About the Programme</h2>
                        <p>Comprehensive education in planning, designing, constructing, and maintaining critical infrastructure.</p>
                    </div>

                    <div class="dept-story-body">
                        <p>
                            Civil Engineering is one of the broadest and oldest of the engineering disciplines, extending across many technical specialties. Civil Engineers plan, design, and supervise the construction of facilities essential to modern life like space satellites and launching facilities, offshore structures, bridges, buildings, tunnels, highways, transit systems, dams, airports, harbors, water supply system and wastewater treatment plants. A civil engineer is responsible for planning and designing a project, constructing the project to the required scale, and maintenance of the project. A civil engineer requires not only a high standard of engineering knowledge but also supervisory and administrative skills.
                        </p>
                        <p>
                            Civil engineers are involved in the design and building of highways, bridges and tunnels, schools, hospitals, airports and other buildings, sewage systems and water treatment facilities. Most structures, large and small, require the help of a civil engineer whether in the designing, planning or managing of the project. Civil engineers also help to preserve our environment by assisting in the cleaning up of existing pollution and planning ways to reduce future pollution of our air, land and water.
                        </p>
                        <p>
                            Civil engineers are employed in all the major construction projects carried out by the state or central government like the public works departments (PWD), the railways and military. Civil Engineers are mostly required in private construction and real estate companies as project engineers.
                        </p>
                    </div>

                    <!-- Under Graduate / Post Graduate Courses -->
                    <div class="dept-table-card">
                        <div class="dept-table-banner">
                            <i class="fas fa-layer-group"></i> Under Graduate/Post Graduate Courses
                        </div>
                        <div class="dept-table-wrap">
                            <table class="dept-clean-table">
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
                                        <td><strong>Civil Engineering</strong></td>
                                        <td><span class="dept-tag-ug">UG</span></td>
                                        <td>4</td>
                                        <td>120</td>
                                        <td>1984</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Transportation Engineering</strong></td>
                                        <td><span class="dept-tag-pg">PG</span></td>
                                        <td>2</td>
                                        <td>18</td>
                                        <td>2010</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 2: Vision & Mission -->
            <section class="dept-tab-pane" id="tab-vision-mission">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">ACADEMIC CHARTER</span>
                    <h2>Vision &amp; Mission</h2>
                    <p>Guiding values, educational mission, and professional objectives of the Civil Engineering Department.</p>
                </div>

                <!-- Vision Card -->
                <div class="dept-charter-card dept-vision-hero-card">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #111; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.05em;">Vision</h3>
                    <blockquote class="dept-vision-statement">
                        Produce globally employable competent civil engineers committed to research, innovation and entrepreneurship with core values.
                    </blockquote>
                </div>

                <!-- Mission Card -->
                <div class="dept-charter-card">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #111; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.05em;">Mission</h3>
                    <ul class="dept-mission-steps">
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">1</span>
                            <div class="dept-mission-text">
                                To impart quality in academics through experimental innovation with core values.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">2</span>
                            <div class="dept-mission-text">
                                To promote innovative practices in the field of civil engineering.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">3</span>
                            <div class="dept-mission-text">
                                To inculcate entrepreneurial approach among the learners as civil engineer.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">4</span>
                            <div class="dept-mission-text">
                                To enhance industry – academia collaboration for promoting research and placement.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">5</span>
                            <div class="dept-mission-text">
                                To offer the services to community.
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Program Education Objectives (PEOs) Table -->
                <div class="dept-table-card">
                    <div class="dept-table-banner">
                        <i class="fas fa-server"></i> Program Education Objectives (PEOs)
                    </div>
                    <div class="dept-table-caption-bar">
                        After successful completion of the program, the student will
                    </div>
                    <div class="dept-table-wrap">
                        <table class="dept-clean-table">
                            <tbody>
                                <tr>
                                    <td style="width: 120px; font-weight: 700; color: #111;">PEO1</td>
                                    <td>able to pursue higher study for research and innovation in the field of civil engineering.</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 700; color: #111;">PEO2</td>
                                    <td>be equipped with knowledge, skill, attitude and ability to perform ethically the role of competent professional civil engineer.</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 700; color: #111;">PEO3</td>
                                    <td>work as an entrepreneur for serving the society.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Programme Specific Outcomes (PSOs) Table -->
                <div class="dept-table-card">
                    <div class="dept-table-banner">
                        <i class="fas fa-server"></i> Programme Specific Outcomes (PSOs)
                    </div>
                    <div class="dept-table-caption-bar">
                        At the end of the program, the student will be able to
                    </div>
                    <div class="dept-table-wrap">
                        <table class="dept-clean-table">
                            <tbody>
                                <tr>
                                    <td style="width: 120px; font-weight: 700; color: #111;">PSO1</td>
                                    <td>apply the knowledge of civil engineering to avail the services in planning, designing and execution of various projects with professional ethics.</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 700; color: #111;">PSO2</td>
                                    <td>plan, design and construct infrastructure facilities to satisfy economic, environmental and societal need in a sustainable manner.</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 700; color: #111;">PSO3</td>
                                    <td>solve the real life problems of Transportation Engineering.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Tab 3: Faculty -->
            <section class="dept-tab-pane" id="tab-faculty">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">ACADEMIC EXCELLENCE</span>
                    <h2>Faculty Members</h2>
                    <p>Distinguished professors, associate professors, and assistant professors of the Civil Engineering Department.</p>
                </div>
                <div class="dept-empty-card">
                    <i class="fas fa-user-graduate"></i>
                    <h3>Faculty Directory</h3>
                    <p>Faculty details and profiles are being updated.</p>
                </div>
            </section>

            <!-- Tab 4: Activities -->
            <section class="dept-tab-pane" id="tab-activities">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">EVENTS &amp; WORKSHOPS</span>
                    <h2>Department Activities</h2>
                    <p>Seminars, technical site visits, expert talks, and student workshops conducted by Civil Engineering.</p>
                </div>
                <div class="dept-empty-card">
                    <i class="fas fa-calendar-alt"></i>
                    <h3>Activities &amp; Events</h3>
                    <p>Recent department activities and workshop records are being updated.</p>
                </div>
            </section>

            <!-- Tab 5: Facilities -->
            <section class="dept-tab-pane" id="tab-facilities">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">EXPERIMENTAL INFRASTRUCTURE</span>
                    <h2>Facilities</h2>
                    <p>Laboratories equipped for imparting practical knowledge and testing across all core civil engineering disciplines.</p>
                </div>

                <div class="dept-charter-card">
                    <div class="dept-facilities-list-grid">
                        <div class="dept-facility-bullet-item">
                            <i class="fas fa-chevron-circle-right dept-facility-bullet-icon"></i>
                            <span>Drawing hall</span>
                        </div>
                        <div class="dept-facility-bullet-item">
                            <i class="fas fa-chevron-circle-right dept-facility-bullet-icon"></i>
                            <span>Geoinformatic / Geology Lab</span>
                        </div>
                        <div class="dept-facility-bullet-item">
                            <i class="fas fa-chevron-circle-right dept-facility-bullet-icon"></i>
                            <span>Surveying Lab</span>
                        </div>
                        <div class="dept-facility-bullet-item">
                            <i class="fas fa-chevron-circle-right dept-facility-bullet-icon"></i>
                            <span>Water Resources Lab</span>
                        </div>
                        <div class="dept-facility-bullet-item">
                            <i class="fas fa-chevron-circle-right dept-facility-bullet-icon"></i>
                            <span>Fluid Mechanics Lab</span>
                        </div>
                        <div class="dept-facility-bullet-item">
                            <i class="fas fa-chevron-circle-right dept-facility-bullet-icon"></i>
                            <span>Concrete Laboratory</span>
                        </div>
                        <div class="dept-facility-bullet-item">
                            <i class="fas fa-chevron-circle-right dept-facility-bullet-icon"></i>
                            <span>Environmental Engineering Lab</span>
                        </div>
                        <div class="dept-facility-bullet-item">
                            <i class="fas fa-chevron-circle-right dept-facility-bullet-icon"></i>
                            <span>Structure &amp; Heavy Structures Laboratory</span>
                        </div>
                        <div class="dept-facility-bullet-item">
                            <i class="fas fa-chevron-circle-right dept-facility-bullet-icon"></i>
                            <span>Transportation Engineering Lab</span>
                        </div>
                        <div class="dept-facility-bullet-item">
                            <i class="fas fa-chevron-circle-right dept-facility-bullet-icon"></i>
                            <span>Soil &amp; Material Testing Laboratory</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 6: Publications -->
            <section class="dept-tab-pane" id="tab-publications">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">SCHOLARLY CONTRIBUTIONS</span>
                    <h2>Publications</h2>
                    <p>Research contributions and journal articles by Civil Engineering faculty members.</p>
                </div>
                <div class="dept-empty-card">
                    <i class="fas fa-book-open"></i>
                    <h3>Publications Archive</h3>
                    <p>Department research papers and publication citations are being compiled.</p>
                </div>
            </section>

        </div>
    </main>
</div>

<script src="js/department.js"></script>

<?php
include_once __DIR__ . '/../../includes/footer.php';
?>
