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

                <!-- Featured Laboratories Showcase with Photos -->
                <div class="dept-labs-showcase">
                    <!-- Facility 1: Surveying Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_surveying.jpg" alt="Surveying Laboratory with Total Station and Survey Equipment" loading="lazy" onerror="this.src='../../images/hero_campus_1.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Main Building</span>
                            <h3 class="dept-lab-title">Surveying Lab</h3>
                            <p class="dept-lab-desc">Surveying Laboratory contains measuring instruments for distance, vertical and horizontal angles, and elevation. It is also used for performing leveling surveys and traverse surveys, and for applying corrections to geodetic observations. Major equipment includes: Total Station, Optical Theodolite, Dumpy Level, Chains/Tapes, Plane Table &amp; accessories, Plumb Bob, Ranging Rods, and Spirit Level.</p>
                        </div>
                    </div>

                    <!-- Facility 2: Environmental Engineering Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_environmental.jpg" alt="Environmental Engineering Laboratory with Water and Air Testing Setups" loading="lazy" onerror="this.src='../../images/hero_campus_1.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Main Building</span>
                            <h3 class="dept-lab-title">Environmental Engineering Lab</h3>
                            <p class="dept-lab-desc">The primary objective of the Environmental Engineering lab is to assess the pollutants of water and air, assess noise levels, and monitor concentrations of environmental pollutants. Continuously upgraded with modern apparatus, allowing students to conduct experiments on water, noise, and air by calculating pollution load, BOD, COD, etc. Equipped with BOD Testing Machine, Multi-parameter Testing Machine, and Turbidimeter.</p>
                        </div>
                    </div>

                    <!-- Facility 3: Transportation Engineering Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_transportation.jpg" alt="Transportation Engineering Laboratory with Highway Material Testing Apparatus" loading="lazy" onerror="this.src='../../images/hero_campus_1.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Main Building</span>
                            <h3 class="dept-lab-title">Transportation Engineering Lab</h3>
                            <p class="dept-lab-desc">Transportation Engineering Laboratory is well-equipped for highway material testing and pavement evaluation. Key apparatus and experiments include: Aggregate Crushing Value Apparatus, Los Angeles Abrasion Testing Machine, Aggregate Impact Value Apparatus, Universal Penetrometer, Ductility Testing Machine, Flash &amp; Fire Point Apparatus, Ring &amp; Ball Softening Point Apparatus, and Stripping Value Test setups.</p>
                        </div>
                    </div>

                    <!-- Facility 4: Fluid Mechanics Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_fluid_mechanics.jpg" alt="Fluid Mechanics Laboratory Hydraulic Measurement Apparatus" loading="lazy" onerror="this.src='../../images/hero_campus_1.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Main Building</span>
                            <h3 class="dept-lab-title">Fluid Mechanics Lab</h3>
                            <p class="dept-lab-desc">Deals with practical knowledge and application of principles in the collection, storage, control, transport, regulation, measurement, and use of water by engaging with flow-measuring setups such as venturi meters, orifice plates, pitot tubes, and rotameters, enabling students to directly visualize and verify fluid mechanics theory.</p>
                        </div>
                    </div>
                </div>

                <!-- Department Facilities Directory (All 10 Facilities) -->
                <div class="dept-section-header" style="margin-top: 52px;">
                    <span class="dept-section-kicker">INFRASTRUCTURE DIRECTORY</span>
                    <h2>All Department Facilities &amp; Centers</h2>
                    <p>Comprehensive list of teaching laboratories, workshops, and specialized testing facilities.</p>
                </div>

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
                                <option value="all">All Years (45)</option>
                                <option value="2023">2023 (3)</option>
                                <option value="2022">2022 (3)</option>
                                <option value="2021">2021 (1)</option>
                                <option value="2020">2020 (3)</option>
                                <option value="2019">2019 (2)</option>
                                <option value="2018">2018 (2)</option>
                                <option value="2017">2017 (8)</option>
                                <option value="2016">2016 (7)</option>
                                <option value="2015">2015 (5)</option>
                                <option value="2014">2014 (1)</option>
                                <option value="2013">2013 (3)</option>
                                <option value="2012">2012 (2)</option>
                                <option value="2011">2011 (1)</option>
                                <option value="2007">2007 (2)</option>
                                <option value="2006">2006 (1)</option>
                            </select>
                            <i class="fas fa-chevron-down dept-pub-arrow"></i>
                        </div>
                    </div>
                    <div class="dept-pub-badge" id="pubCountBadge">
                        Showing <strong>45</strong> publications
                    </div>
                </div>

                <div class="dept-citations-list">
                    <div class="dept-pub-empty" id="pubEmptyState" style="display: none;">
                        <i class="far fa-folder-open"></i>
                        No publications found matching the selected filter.
                    </div>

                    <!-- Publication 1 (2023) -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">Comparison of Shoreline Change Analysis using EPR and LRR methods along the Coastal Region</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Pratima Shah, Dr. Gargi Rajapara</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- Publication 2 (2023) -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">A Critical Literature Review on The Effect of Coastal Process and Hydrodynamics Changes along Region of India</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Pratima Shah, Dr. Gargi Rajpara</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- Publication 3 (2023) -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">A Critical Literature Review on The Effect of Coastal Process and Hydrodynamics Changes along Region of India</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Pratima Shah, Dr. Gargi Rajpara</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- Publication 4 (2022) -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">Evaluating socio-economic impacts for micro watersheds of Sabarkantha and Aravalli districts of Gujarat, India</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Vishalkumar R. Gor, Vinodkumar M. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- Publication 5 (2022) -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">Evaluating the changes in soil erosion for micro watersheds of Sabarkantha and Aravalli districts of Gujarat, India</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Vishalkumar R. Gor, Vinodkumar M. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- Publication 6 (2022) -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">Coastline Extraction of Gulf of Khambhat using RS and GIS Techniques</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Shah Pratima, Rajpara Gargi</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- Publication 7 (2021) -->
                    <div class="dept-citation-item" data-year="2021">
                        <h3 class="dept-citation-title">Mechanistic aspects of photocatalytic degradation of Lindane by TiO2 in the presence of Oxalic acid and EDTA as hole-scavengers</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Bhaumik Shah and U D Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2021</span>
                        </div>
                    </div>

                    <!-- Publication 8 (2020) -->
                    <div class="dept-citation-item" data-year="2020">
                        <h3 class="dept-citation-title">Water Supply System Planning of Gandhinagar District, Gujarat</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Pratima Shah, Utkarsh Nigam</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2020</span>
                        </div>
                    </div>

                    <!-- Publication 9 (2020) -->
                    <div class="dept-citation-item" data-year="2020">
                        <h3 class="dept-citation-title">Impact of Coastal Processes and Hydrodynamics along Coastal Region: A Literature Review</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Shah Pratima, G. Rajapara, S. Dixit, U. Nigam</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2020</span>
                        </div>
                    </div>

                    <!-- Publication 10 (2020) -->
                    <div class="dept-citation-item" data-year="2020">
                        <h3 class="dept-citation-title">Planning of Water Supply System for Sector-27, Gandhinagar District, Gujarat</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Shah Pratima, U. Nigam, S. Dixit</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2020</span>
                        </div>
                    </div>

                    <!-- Publication 11 (2019) -->
                    <div class="dept-citation-item" data-year="2019">
                        <h3 class="dept-citation-title">Reductive photocatalytic decolourisation of reactive black 5 using immobilized TiO2, 4th International Conference on Bioenergy, Environment and Sustainable Technologies (BEST 2019)</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Bhaumik Shah and U D Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2019</span>
                        </div>
                    </div>

                    <!-- Publication 12 (2019) -->
                    <div class="dept-citation-item" data-year="2019">
                        <h3 class="dept-citation-title">Aqueous pollutants in water bodies can be photocatalytically reduced by TiO2 nano-particles in the presence of natural organic matter</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Bhaumik Shah and U D Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2019</span>
                        </div>
                    </div>

                    <!-- Publication 13 (2018) -->
                    <div class="dept-citation-item" data-year="2018">
                        <h3 class="dept-citation-title">Development of Model for Estimating Saturation Flow using Width and Roughness of Road for Mixed Traffic Condition in Urban Area</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> N. G. Raval, Dr. P. J. Gundaliya</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2018</span>
                        </div>
                    </div>

                    <!-- Publication 14 (2018) -->
                    <div class="dept-citation-item" data-year="2018">
                        <h3 class="dept-citation-title">Reductive Photocatalytic Decolourization of an Azo Dye Reactive Black 5 Using TiO2: Mechanism and Role of Reductive Species</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Bhaumik Shah and U D Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2018</span>
                        </div>
                    </div>

                    <!-- Publication 15 (2017) -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Analyzing Urban population Density Gradient for Morbi city</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Toral Vyas, Prof. R. N. Shukla</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- Publication 16 (2017) -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Impact Analysis of Branch Canal on Land Use Pattern using GIS Techniques</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Prof. Pratima Shah, Prof. M. B. Dholakia, Daksha Kataria</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- Publication 17 (2017) -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Development of Model for Estimating Capacity of Roads for Heterogeneous Traffic Condition in Urban Area</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> N. G. Raval, Dr. P. J. Gundaliya, Dr. Gargee Rajpara</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- Publication 18 (2017) -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Development of Relationship Between Saturation Flow &amp; Capacity of Mid-Block Section of urban Road - A Case Study of Ahmedabad City</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> N. G. Raval, Dr. P. J. Gundaliya</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- Publication 19 (2017) -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Reductive Photocatalytic Degradation of Triclosan by UV Light and P25: Influence of Experimental Parameters</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Bhaumik Shah and U D Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- Publication 20 (2017) -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Willingness towards Rail Transits for Modasa – Lunavada – Godhara route</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Purohit Shekhar, Thakar H.B., Varia H.R., Bhavasar A.M.</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- Publication 21 (2017) -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Feasibility of new Proposed Railway link Between Modasa – Lunavada - Godhara</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Purohit Shekhar, Thakar H.B., Varia H.R., Bhavasar A.M.</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- Publication 22 (2017) -->
                    <div class="dept-citation-item" data-year="2017">
                        <h3 class="dept-citation-title">Use of Waste Marble Powder to Improve the Characteristics of Black cotton soil</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Patel B.B., Thakar H.B., Varia H.R., Mishra C.B.</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2017</span>
                        </div>
                    </div>

                    <!-- Publication 23 (2016) -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">ROAD SAFETY AUDIT FOR SELECTED RURAL ROAD OF ARAVALLI DISTRICT</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> H. K. SHARMA</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- Publication 24 (2016) -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">Feasibility of Public Transport Services in Prantij</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Pandya Jay P. &amp; Patel Gunjan S.</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- Publication 25 (2016) -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">Ground water balance study in the command area of Sanand branch canal, Gujarat, India using GEC 1997 and Geoinformatics Technology</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Daksha Katariya, Prof. P. K. Shah, Dr. Indra Prakash, Khalid Mehammud</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- Publication 26 (2016) -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">Impact Of Sanand Branch Canal On Landuse Pattern In Sanand Taluka, Gujarat, India Using Geoinformatics Technology</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Daksha Katariya, Prof. P. K. Shah, Dr. Indra Prakash, Khalid Mehammud</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- Publication 27 (2016) -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">Assessment of Water Supply System of Deodar Taluka, Banaskantha, Gujarat, India using Geo-informatics Technology and EPANET</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Dhaval B. Patel, P. K. Shah, Khalid Mehmood, Indra Prakash</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- Publication 28 (2016) -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">Reductive photocatalysis of azo dyes using TiO2 nano-particles in the presence of some natural anti-oxidants as hole scavengers, 252nd ACS National Meeting</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Bhaumik Shah, M. Doshi, J. Ruparelia, U. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- Publication 29 (2016) -->
                    <div class="dept-citation-item" data-year="2016">
                        <h3 class="dept-citation-title">Development of Strategy for Up Gradation of Existing Rural Road Links of Aravalli District</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pandya Jay P.</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2016</span>
                        </div>
                    </div>

                    <!-- Publication 30 (2015) -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Rainwater Harvesting - A Case Study of Amba Township, Gandhinagar</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Anant D. Patel, Asst. Prof. Pratima K. Shah</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- Publication 31 (2015) -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Analysis of Quality of Ground Water and its Suitability for Drinking Purpose in Visnagar Taluka, Mehsana District, Gujarat</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> D. S. Goswamee, S. K. Raval, P. K. Shah, Y. S. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- Publication 32 (2015) -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">TRIP MAKING BEHAVIOUR IN THE MODASA TOWN (Gujarat)</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> H. K. SHARMA</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- Publication 33 (2015) -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">International paper on "Integrated Ozonation and Aerobic Biodegradation of Acid Red 14 and Congo Red Azo Dyes"</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Dr. U. K. Khare, Dr. P. Bose</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- Publication 34 (2015) -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Trip Making Behaviour in the Modasa Town</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Pandya Jay P.</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- Publication 35 (2015) -->
                    <div class="dept-citation-item" data-year="2015">
                        <h3 class="dept-citation-title">Utilization of Waste Plastic in Construction of Pavement</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> H. K. SHARMA</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2015</span>
                        </div>
                    </div>

                    <!-- Publication 36 (2014) -->
                    <div class="dept-citation-item" data-year="2014">
                        <h3 class="dept-citation-title">International paper on "Combined ozonation and aerobic biodegradation of Reactive Black-5 and Reactive Violet 5 Dyes"</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Dr. U. K. Khare, Dr. P. Bose</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2014</span>
                        </div>
                    </div>

                    <!-- Publication 37 (2013) -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">IMPROVEMENT IN TRANSIT SERVICE USING TRANSCAD GIS A CASE STUDY OF HIMATNAGAR BUS DEPOT</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Sathawara Jigar K., Prof. A. K. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- Publication 38 (2013) -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">COMPARISON BETWEEN SOAKED AND UNSOAKED CBR</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Sathawara Jigar K., Prof. A. K. Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- Publication 39 (2013) -->
                    <div class="dept-citation-item" data-year="2013">
                        <h3 class="dept-citation-title">Reductive Photocatalysis for Degradation of Toxic Pollutants in water: A Short Review</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Bhaumik Shah, U D Patel</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2013</span>
                        </div>
                    </div>

                    <!-- Publication 40 (2012) -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Modification of Webster's Delay Formula Using Modified Saturation Flow Model 41 for Non-Lane Based Heterogeneous Traffic Conditions</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> N. G. Raval, P. J. Gundaliya</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- Publication 41 (2012) -->
                    <div class="dept-citation-item" data-year="2012">
                        <h3 class="dept-citation-title">Green Highways: Today's Need for Sustainable Development</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> H. B. Thakar, Dr. H. R. Varia, Dr. L. B. Zala</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2012</span>
                        </div>
                    </div>

                    <!-- Publication 42 (2011) -->
                    <div class="dept-citation-item" data-year="2011">
                        <h3 class="dept-citation-title">Public Transport Scenario in Modasa Taluka Region</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> H. B. Thakar, Dr. H. R. Varia, Dr. L. B. Zala</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2011</span>
                        </div>
                    </div>

                    <!-- Publication 43 (2007) -->
                    <div class="dept-citation-item" data-year="2007">
                        <h3 class="dept-citation-title">International paper on "Impact of ozonation on subsequent treatment of azo dye solutions"</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Dr. U. K. Khare, Dr. P. Bose</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2007</span>
                        </div>
                    </div>

                    <!-- Publication 44 (2007) -->
                    <div class="dept-citation-item" data-year="2007">
                        <h3 class="dept-citation-title">Paper titled on "Combined ozonation and aerobic biodegradation of some azo dyes"</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Dr. U. K. Khare, Dr. P. Bose</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2007</span>
                        </div>
                    </div>

                    <!-- Publication 45 (2006) -->
                    <div class="dept-citation-item" data-year="2006">
                        <h3 class="dept-citation-title">Paper titled on "Ozonation of azo dyes:physico-chemical and toxicological aspects"</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user-friends"></i> Dr. U. K. Khare, Dr. P. Bose</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2006</span>
                        </div>
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
