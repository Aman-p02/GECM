<?php
$page_title = "Civil Engineering | Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";

include_once __DIR__ . '/../../includes/header.php';
?>

<!-- Civil Department Stylesheet -->
<link rel="stylesheet" href="css/department.css">

<div class="dept-page" id="mainContent" data-active-tab="about">

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
                    <img src="images/department_building.jpg" alt="Government Engineering College Modasa - Civil Engineering Department Building" class="dept-hero-photo" onerror="this.src='../../images/hero_campus_1.jpg'">
                </div>
            </div>

            <!-- Key metrics counter strip -->
            <div class="dept-stats-strip">
                <div class="dept-stat-item">
                    <span class="dept-stat-num">1984</span>
                    <span class="dept-stat-label">CONSTITUTED YEAR</span>
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
                    <span class="dept-stat-label">SPECIALIZED LABS</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Sticky sub-navigation bar -->
    <nav class="dept-subnav-bar" id="deptSubNav" aria-label="Department Navigation">
        <div class="dept-container">
            <div class="dept-subnav-wrap">
                <ul class="dept-subnav-list" role="tablist">
                    <li class="dept-subnav-item active">
                        <button type="button" class="dept-subnav-link active" data-tab="about" role="tab" aria-selected="true">About</button>
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
                        <button type="button" class="dept-subnav-link" role="tab" aria-selected="false">Faculty</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" role="tab" aria-selected="false">Activities</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-tab="facilities" role="tab" aria-selected="false">Facilities &amp; Labs</button>
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
                    <p>Delivering foundational and advanced civil engineering education, experimental laboratory testing, and professional infrastructure development since 1984.</p>
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
                        <span class="dept-section-kicker">PROFESSIONAL CURRICULUM</span>
                        <h2>About the Programme</h2>
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

                    <div class="dept-avenues-grid">
                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-building"></i></div>
                                <h4>Structural &amp; Environmental Infrastructure</h4>
                            </div>
                            <p>Planning, designing, and supervising buildings, bridges, water supply systems, and wastewater treatment facilities to preserve environmental sustainability.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-road"></i></div>
                                <h4>Transportation &amp; Public Works</h4>
                            </div>
                            <p>Engineering highways, transit networks, railways, and harbors for state and central infrastructure projects like PWD, railways, and defense works.</p>
                        </div>
                    </div>
                </div>

                <!-- Under Graduate / Post Graduate Courses -->
                <div class="dept-section-header" style="margin-top: 56px;">
                    <span class="dept-section-kicker">ACADEMIC DEGREE OFFERINGS</span>
                    <h2>Undergraduate &amp; Postgraduate Programmes</h2>
                    <p>Approved by the All India Council for Technical Education (AICTE), New Delhi and affiliated with Gujarat Technological University (GTU), Ahmedabad.</p>
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
            </section>

            <!-- Tab 2: Vision & Mission -->
            <section class="dept-tab-pane" id="tab-vision-mission">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">ACADEMIC CHARTER</span>
                    <h2>Vision &amp; Mission</h2>
                    <p>Guiding principles, strategic commitments, and educational objectives defining our engineering pedagogy.</p>
                </div>

                <!-- Vision Card -->
                <div class="dept-charter-card dept-vision-hero-card">
                    <span class="dept-vision-quote-mark">“</span>
                    <blockquote class="dept-vision-statement">
                        Produce globally employable competent civil engineers committed to research, innovation and entrepreneurship with core values.
                    </blockquote>
                </div>

                <!-- Mission Card -->
                <div class="dept-charter-card" style="margin-bottom: 48px;">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #111; margin-bottom: 24px; text-transform: uppercase; letter-spacing: 0.05em;">Mission of the Department</h3>
                    <ul class="dept-mission-steps">
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">I</span>
                            <div class="dept-mission-text">
                                To impart quality in academics through experimental innovation with core values.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">II</span>
                            <div class="dept-mission-text">
                                To promote innovative practices in the field of civil engineering.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">III</span>
                            <div class="dept-mission-text">
                                To inculcate entrepreneurial approach among the learners as civil engineer.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">IV</span>
                            <div class="dept-mission-text">
                                To enhance industry – academia collaboration for promoting research and placement.
                            </div>
                        </li>
                        <li class="dept-mission-item">
                            <span class="dept-mission-index">V</span>
                            <div class="dept-mission-text">
                                To offer the services to community.
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Objectives (PEOs and PSOs) -->
                <div class="dept-objectives-grid">
                    <div class="dept-obj-card">
                        <h4>Program Education Objectives (PEOs)</h4>
                        <div class="dept-obj-lead">After successful completion of the program, the student will:</div>
                        <ul class="dept-obj-list">
                            <li><strong>PEO 1:</strong> able to pursue higher study for research and innovation in the field of civil engineering.</li>
                            <li><strong>PEO 2:</strong> be equipped with knowledge, skill, attitude and ability to perform ethically the role of competent professional civil engineer.</li>
                            <li><strong>PEO 3:</strong> work as an entrepreneur for serving the society.</li>
                        </ul>
                    </div>

                    <div class="dept-obj-card">
                        <h4>Programme Specific Outcomes (PSOs)</h4>
                        <div class="dept-obj-lead">At the end of the program, the student will be able to:</div>
                        <ul class="dept-obj-list">
                            <li><strong>PSO 1:</strong> apply the knowledge of civil engineering to avail the services in planning, designing and execution of various projects with professional ethics.</li>
                            <li><strong>PSO 2:</strong> plan, design and construct infrastructure facilities to satisfy economic, environmental and societal need in a sustainable manner.</li>
                            <li><strong>PSO 3:</strong> solve the real life problems of Transportation Engineering.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Tab 3: Facilities & Labs -->
            <section class="dept-tab-pane" id="tab-facilities">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">EXPERIMENTAL INFRASTRUCTURE</span>
                    <h2>Laboratories &amp; Facilities</h2>
                    <p>Housed in the main building of the college, equipped with specialized testing apparatus, experimental benches, and engineering laboratories.</p>
                </div>

                <!-- Key Department Facilities Grid -->
                <div class="dept-facilities-grid">
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-drafting-compass"></i></div>
                        <div class="dept-facility-info">
                            <h4>Drawing hall</h4>
                            <p>Spacious drawing hall dedicated to engineering graphics, structural drawing, and manual blueprint preparation.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-map-marked-alt"></i></div>
                        <div class="dept-facility-info">
                            <h4>Surveying Lab</h4>
                            <p>Equipped with total stations, optical theodolites, auto-levels, and measurement chains for comprehensive field surveying.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-water"></i></div>
                        <div class="dept-facility-info">
                            <h4>Fluid Mechanics Lab</h4>
                            <p>Flow measurement benches, hydraulic flumes, pipe friction apparatus, and fluid dynamics experimental setups.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-leaf"></i></div>
                        <div class="dept-facility-info">
                            <h4>Environmental Engineering Lab</h4>
                            <p>Water and wastewater testing equipment, pH meters, turbidity meters, BOD/COD incubators, and air quality analysis.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-road"></i></div>
                        <div class="dept-facility-info">
                            <h4>Transportation Engineering Lab</h4>
                            <p>Pavement material testing apparatus including bitumen penetration, ductility, softening point, and aggregate impact tests.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-globe-asia"></i></div>
                        <div class="dept-facility-info">
                            <h4>Geoinformatic / Geology Lab</h4>
                            <p>Geological mineral specimen collections, petrological study microscopes, rock classification, and GIS mapping tools.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-tint"></i></div>
                        <div class="dept-facility-info">
                            <h4>Water Resources Lab</h4>
                            <p>Hydrological measurement instruments, rainfall simulation benches, and groundwater seepage demonstration models.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-cubes"></i></div>
                        <div class="dept-facility-info">
                            <h4>Concrete Laboratory</h4>
                            <p>Compressive testing machine, sieve shaker, workability slump test apparatus, and concrete mix design facilities.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-archway"></i></div>
                        <div class="dept-facility-info">
                            <h4>Structure &amp; Heavy Structures Laboratory</h4>
                            <p>Heavy loading frames for structural deflection, column buckling, beam bending moments, and frame analysis.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-mountain"></i></div>
                        <div class="dept-facility-info">
                            <h4>Soil &amp; Material Testing Laboratory</h4>
                            <p>Tri-axial shear apparatus, direct shear machines, unconfined compression, and soil consolidation testing equipment.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 4: Publications -->
            <section class="dept-tab-pane" id="tab-publications">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">SCHOLARLY OUTPUT</span>
                    <h2>Faculty Publications</h2>
                    <p>Research contributions, technical papers, and conference proceedings published by Civil Engineering faculty and research scholars.</p>
                </div>

                <div class="dept-pub-toolbar">
                    <div class="dept-pub-filter-wrap">
                        <label for="pubYearFilter" class="dept-pub-filter-label">
                            <i class="fas fa-calendar-alt"></i> Filter by Year:
                        </label>
                        <div class="dept-pub-select-box">
                            <select id="pubYearFilter" class="dept-pub-select" aria-label="Filter publications by year" onchange="window.filterPublicationsByYear && window.filterPublicationsByYear(this.value)">
                                <option value="all">All Years (0)</option>
                            </select>
                            <i class="fas fa-chevron-down dept-pub-arrow"></i>
                        </div>
                    </div>
                    <div class="dept-pub-badge" id="pubCountBadge">
                        Showing <strong>0</strong> publications
                    </div>
                </div>

                <div class="dept-citations-list">
                    <div class="dept-pub-empty" id="pubEmptyState">
                        <i class="far fa-folder-open"></i>
                        Publications list is currently being compiled and will be available soon.
                    </div>
                </div>
            </section>

        </div>
    </main>
</div>

<script src="js/department.js"></script>

<?php
include_once __DIR__ . '/../../includes/footer.php';
?>
