<?php
// Set Page Variables
$page_title = "Department of Applied Mechanics — Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/applied-mechanics/css/department.css";
$extra_js = "departments/applied-mechanics/js/department.js";

// Include Header
include_once __DIR__ . '/../../includes/header.php';
?>

<div class="dept-page">

    <!-- Hero header section -->
    <header class="dept-hero-banner">
        <div class="dept-container">
            <!-- Two-column hero grid (7 cols left, 5 cols right) -->
            <div class="dept-hero-grid">
                <div class="dept-hero-text">
                    <span class="dept-kicker">DEPARTMENT OF</span>
                    <h1 class="dept-heading">Applied Mechanics</h1>
                    <p class="dept-tagline">
                        Accommodated in the main building, advancing foundational mechanics, materials testing, geotechnical investigations, and earthquake engineering testing.
                    </p>
                </div>
                <div class="dept-hero-media">
                    <img src="images/department_building.jpg" alt="Government Engineering College Modasa - Applied Mechanics Department Building" class="dept-hero-photo">
                </div>
            </div>

            <!-- Key metrics counter strip -->
            <div class="dept-stats-strip">
                <div class="dept-stat-item">
                    <span class="dept-stat-num">4+</span>
                    <span class="dept-stat-label">SPECIALIZED TESTING LABS</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">BIS/ISI</span>
                    <span class="dept-stat-label">COMPLIANT TESTING</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">UG &amp; PG</span>
                    <span class="dept-stat-label">STRUCTURAL PEDAGOGY</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">8</span>
                    <span class="dept-stat-label">FACULTY MEMBERS</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Sticky sub-navigation bar -->
    <nav class="dept-subnav-bar" id="deptSubNav" aria-label="Department Navigation">
        <div class="dept-container">
            <div class="dept-subnav-wrapper">
                <ul class="dept-subnav-list" role="tablist">
                    <li class="dept-subnav-item active">
                        <button type="button" class="dept-subnav-link active" data-tab="about" role="tab" aria-selected="true">About Department</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" role="tab" aria-selected="false">Faculty</button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" role="tab" aria-selected="false">Activities</button>
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

    <!-- Tab panels container -->
    <main class="dept-main-content">
        <div class="dept-container">

            <!-- Tab 1: About Department -->
            <section class="dept-tab-pane active" id="tab-about">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">ACADEMIC OVERVIEW</span>
                    <h2>About the Department</h2>
                    <p>Fostering rigorous experimental foundations in engineering mechanics, materials testing, and geotechnical characterization.</p>
                </div>

                <div class="dept-story-body">
                    <blockquote class="dept-lead-quote">
                        "Bridging the vital gap between physical mechanics theory and modern structural engineering application."
                    </blockquote>
                    <p>
                        This department is accommodated in the main building, having laboratories in area like Engineering Mechanics, Strength of Materials, Concrete Technology and Geotechnic Engineering. All these Laboratories are well equipped to meet the testing requirement as per ISI.
                    </p>
                    <p>
                        This department is having laboratories in area like Mechanics of Solids, Concrete Technology, Structural Engineering, Geotechnical Engineering and Computing. All these laboratories are well equipped to meet the testing requirement as per BIS (Bureau of International Standards).
                    </p>
                    <p>
                        Applied Mechanics is a branch of the physical sciences and the practical application of mechanics. Applied mechanics examines the response of bodies (solids and fluids) or systems of bodies to external forces. Some examples of mechanical systems include the flow of a liquid under pressure, the fracture of a solid from an applied force, or the vibration of an ear in response to sound. A practitioner of the discipline is known as a mechanician. Applied mechanics, as its name suggests, bridges the gap between physical theory and its application to technology.
                    </p>
                    <p>
                        As such, Applied Mechanics is used in many fields of engineering, especially mechanical engineering. In this context, it is commonly referred to as engineering mechanics. Much of modern engineering mechanics is based on Isaac Newton's laws of motion, while the modern practice of their application can be traced back to Stephen Timoshenko, who is said to be the father of modern engineering mechanics. Within the theoretical sciences, applied mechanics is useful in formulating new ideas and theories, discovering and interpreting phenomena, and developing experimental and computational tools.
                    </p>
                </div>

                <!-- About the Programme Section -->
                <div class="dept-programme-section">
                    <div class="dept-section-header">
                        <span class="dept-section-kicker">DISCIPLINE &amp; TESTING STREAMS</span>
                        <h2>Core Specializations</h2>
                        <p>Providing essential testing infrastructure, structural analysis, and material sciences verification for engineering students.</p>
                    </div>

                    <div class="dept-avenues-grid">
                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-cubes"></i></div>
                                <h4>Mechanics of Solids &amp; Structures</h4>
                            </div>
                            <p>Demonstrating stress-strain relationships, structural stability, bending moments, tensile properties, and material fracture behavior under external loading conditions.</p>
                        </div>

                        <div class="dept-avenue-card">
                            <div class="dept-avenue-header">
                                <div class="dept-avenue-icon"><i class="fas fa-mountain"></i></div>
                                <h4>Geotechnical &amp; Material Testing</h4>
                            </div>
                            <p>Characterizing soil shear strength, tri-axial parameters, concrete compressive strength, and aggregate durability adhering strictly to Bureau of Indian Standards (BIS).</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 2: Laboratory facilities -->
            <section class="dept-tab-pane" id="tab-facilities">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">EXPERIMENTAL INFRASTRUCTURE</span>
                    <h2>Laboratories &amp; Facilities</h2>
                    <p>Accommodated in the main building, our laboratories are well equipped to meet testing requirements as per BIS and ISI specifications.</p>
                </div>

                <!-- Laboratory Photo Showcase -->
                <div class="dept-labs-showcase">
                    <!-- Lab 1: Mechanics of Solid Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_solid_mechanics.jpg" alt="Mechanics of Solid Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Main Building Wing</span>
                            <h3 class="dept-lab-title">Mechanics of Solid Lab</h3>
                            <p class="dept-lab-desc">The objective of the laboratory is to demonstrate the basic principles in the area of engineering mechanics and strength of materials to the undergraduate students through a series of experiments. In this lab the experiments are performed based on basic engineering and to measure the properties of the materials such as impact strength, tensile strength, compressive strength, hardness, ductility etc.</p>
                        </div>
                    </div>

                    <!-- Lab 2: Concrete Technology Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_concrete_tech.jpg" alt="Concrete Technology Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Materials Annex</span>
                            <h3 class="dept-lab-title">Concrete Technology Lab</h3>
                            <p class="dept-lab-desc">The testing and inspection of concrete and concrete making materials like cement and aggregates are important elements in obtaining quality construction. The laboratory allows the students to perform tests on the materials and also to assess the properties of various fresh and hardened concrete properties that may affect the performance of concrete members. The apparatus and machines available at the concrete technology laboratory are Sieve Shaker, Compressive testing machine, Flexural Testing Machine, Apparatus for workability measurement, etc.</p>
                        </div>
                    </div>

                    <!-- Lab 3: Geotechnical Engineering Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_geotechnical.jpg" alt="Geotechnical Engineering Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Geotechnical Wing</span>
                            <h3 class="dept-lab-title">Geotechnical Engineering Lab</h3>
                            <p class="dept-lab-desc">Soil Testing is an integral part of soil mechanics and foundation engineering. A proper evaluation of soil samples and analysis of test results are essential of students and practicing civil Engineers. Tri-axial Testing machine, Direct Shear testing machine, Unconfined compression testing machine, consistency limit testing machines available in the laboratory.</p>
                        </div>
                    </div>

                    <!-- Lab 4: Earthquake Engineering Lab -->
                    <div class="dept-lab-card">
                        <div class="dept-lab-image-frame">
                            <img src="images/labs/lab_earthquake.jpg" alt="Earthquake Engineering Lab" loading="lazy" onerror="this.src='../../images/slider/default.jpg'">
                        </div>
                        <div class="dept-lab-details">
                            <span class="dept-lab-room">Structural Dynamics Center</span>
                            <h3 class="dept-lab-title">Earthquake Engineering Lab</h3>
                            <p class="dept-lab-desc">Several major facilities have been developed in the Department to conduct experiments related to earthquake engineering. Some of the major facilities include: a low cost shake table for dynamic testing of structural models like pounding effect, mode shapes, spring mass system, re-entrant corners, building model with active and passive damper devices.</p>
                        </div>
                    </div>
                </div>

                <!-- Key Department Facilities (Below Laboratory Showcase) -->
                <div class="dept-section-header" style="margin-top: 56px;">
                    <span class="dept-section-kicker">INFRASTRUCTURE HIGHLIGHTS</span>
                    <h2>Department Facilities</h2>
                    <p>Modern testing equipment, experimental benches, and institutional facilities meeting standard BIS and ISI specifications.</p>
                </div>

                <div class="dept-facilities-grid">
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-certificate"></i></div>
                        <div class="dept-facility-info">
                            <h4>BIS &amp; ISI Testing Compliant</h4>
                            <p>Testing protocols and equipment calibrated strictly as per Bureau of Indian Standards and ISI requirements.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-compress-arrows-alt"></i></div>
                        <div class="dept-facility-info">
                            <h4>Universal Testing Setup</h4>
                            <p>High-precision compressive, flexural, and tensile testing rigs for comprehensive material evaluation.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-wave-square"></i></div>
                        <div class="dept-facility-info">
                            <h4>Structural Dynamics &amp; Shake Table</h4>
                            <p>Low-cost dynamic shake table facility for structural vibration, pounding effect, and damping modeling.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-layer-group"></i></div>
                        <div class="dept-facility-info">
                            <h4>Concrete &amp; Aggregates Testing</h4>
                            <p>Motorized sieve shakers, slump cone apparatus, and workability testing units for quality construction analysis.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-mountain"></i></div>
                        <div class="dept-facility-info">
                            <h4>Tri-Axial &amp; Direct Shear Testing</h4>
                            <p>Advanced tri-axial and direct shear apparatus for determining soil shear strength and cohesion parameters.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-shield-alt"></i></div>
                        <div class="dept-facility-info">
                            <h4>Hardness &amp; Impact Testing Bench</h4>
                            <p>Charpy and Izod impact testing apparatus and hardness testers for strength of materials laboratory experiments.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-flask"></i></div>
                        <div class="dept-facility-info">
                            <h4>Soil Consistency &amp; Permeability</h4>
                            <p>Liquid limit, plastic limit, and unconfined compression machines for thorough foundation soil assessment.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-laptop-code"></i></div>
                        <div class="dept-facility-info">
                            <h4>Computing &amp; Numerical Modeling</h4>
                            <p>Computational facility for finite element structural modeling, data acquisition, and numerical analysis.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-wifi"></i></div>
                        <div class="dept-facility-info">
                            <h4>Campus Network &amp; Wi-Fi Access</h4>
                            <p>Integrated internet and campus LAN connection throughout the department premises for faculty and student research.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="dept-facility-info">
                            <h4>Seminar &amp; Colloquium Space</h4>
                            <p>Presentation hall equipped with digital projection systems for expert guest lectures, workshops, and student defenses.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 6: Publications -->
            <section class="dept-tab-pane" id="tab-publications">
                <div class="dept-section-header">
                    <span class="dept-section-kicker">SCHOLARLY OUTPUT</span>
                    <h2>Faculty Publications</h2>
                    <p>Research contributions, journal articles, and conference proceedings published by Applied Mechanics faculty and research scholars.</p>
                </div>

                <!-- Publications Filter Toolbar -->
                <div class="dept-pub-toolbar">
                    <div class="dept-pub-filter-wrap">
                        <label for="pubYearFilter" class="dept-pub-filter-label">
                            <i class="fas fa-calendar-alt"></i> Filter by Year:
                        </label>
                        <div class="dept-pub-select-box">
                            <select id="pubYearFilter" class="dept-pub-select" aria-label="Filter publications by year" onchange="window.filterPublicationsByYear && window.filterPublicationsByYear(this.value)">
                                <option value="all">All Years (3)</option>
                                <option value="2023">2023 (1)</option>
                                <option value="2022">2022 (1)</option>
                                <option value="2021">2021 (1)</option>
                            </select>
                            <i class="fas fa-chevron-down dept-pub-arrow"></i>
                        </div>
                    </div>
                    <div class="dept-pub-badge" id="pubCountBadge">
                        Showing <strong>3</strong> publications
                    </div>
                </div>

                <div class="dept-citations-list">
                    <!-- Empty filter state notice -->
                    <div class="dept-pub-empty" id="pubEmptyState">
                        <i class="far fa-folder-open"></i>
                        No publications found for the selected year.
                    </div>

                    <!-- Publication 1 -->
                    <div class="dept-citation-item" data-year="2023">
                        <h3 class="dept-citation-title">Experimental Investigation of Dynamic Response in Asymmetric Multi-Story Structures Using Shake Table Testing</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Applied Mechanics Faculty, Structural Engineering Group</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2023</span>
                        </div>
                    </div>

                    <!-- Publication 2 -->
                    <div class="dept-citation-item" data-year="2022">
                        <h3 class="dept-citation-title">Shear Strength and Settlement Characteristics of Reinforced Soil Under Tri-Axial Compression</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Geotechnical Research Group, GEC Modasa</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2022</span>
                        </div>
                    </div>

                    <!-- Publication 3 -->
                    <div class="dept-citation-item" data-year="2021">
                        <h3 class="dept-citation-title">Comparative Study of Workability and Compressive Strength of High-Performance Concrete with Mineral Admixtures</h3>
                        <div class="dept-citation-meta">
                            <span class="dept-citation-authors"><i class="fas fa-user"></i> Materials &amp; Concrete Technology Group</span>
                            <span class="dept-citation-date"><i class="far fa-calendar-alt"></i> 2021</span>
                        </div>
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
