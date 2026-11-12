<?php
// Set Page Variables
$page_title = "Department of Applied Mechanics - Government Engineering College, Modasa";
$page_description = "Department of Applied Mechanics at GEC Modasa. Specializing in structural engineering, concrete testing, strength of materials, and soil mechanics research.";
$page_keywords = "Applied Mechanics GEC Modasa, Structural Engineering Modasa, GTU Applied Mechanics, Soil Mechanics Gujarat";

$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/applied-mechanics/css/department.css";
$extra_js = "departments/applied-mechanics/js/department.js";

$deptCode = 'AM';
$deptName = 'Applied Mechanics';

// Include Header
include_once __DIR__ . '/../../includes/header.php';
include_once __DIR__ . '/../includes/department-seo.php';
?>
<link rel="stylesheet" href="../includes/faculty.css">
<link rel="stylesheet" href="../includes/activities.css">
<link rel="stylesheet" href="../includes/publications.css?v=2.2">
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

            <!-- Tab: Faculty Directory (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/faculty-tab.php'; ?>

            <!-- Tab: Activities & Events (Dynamic from Admin Panel) -->
            <?php include __DIR__ . '/../includes/activities-tab.php'; ?>

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
                        <div class="dept-facility-icon"><i class="fas fa-weight-hanging"></i></div>
                        <div class="dept-facility-info">
                            <h4>Strength of Material</h4>
                            <p>Experimental testing of tensile, compressive, shear, and torsional behavior of engineering materials under external mechanical loads.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-cogs"></i></div>
                        <div class="dept-facility-info">
                            <h4>Engineering Mechanics Laboratory</h4>
                            <p>Practical verification of fundamental mechanics principles including force polygons, coplanar equilibrium, friction, and moments.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-desktop"></i></div>
                        <div class="dept-facility-info">
                            <h4>Computer Lab</h4>
                            <p>Modern computational facility equipped for structural drafting, finite element modeling, data analysis, and computer-aided design.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-cubes"></i></div>
                        <div class="dept-facility-info">
                            <h4>Concrete Technology &amp; Heavy Structure Laboratory</h4>
                            <p>Heavy loading frames, compressive and flexural testing machines, and aggregate durability apparatus meeting BIS and ISI standards.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-wave-square"></i></div>
                        <div class="dept-facility-info">
                            <h4>Earthquake Engineering Lab</h4>
                            <p>Specialized dynamic shake table setup for experimental analysis of structural response, active/passive damping, and seismic vibration.</p>
                        </div>
                    </div>
                    <div class="dept-facility-item">
                        <div class="dept-facility-icon"><i class="fas fa-mountain"></i></div>
                        <div class="dept-facility-info">
                            <h4>Soil mechanics &amp; Foundation Engineering Laboratory</h4>
                            <p>Standard geotechnical testing apparatus including direct shear, tri-axial testing, and unconfined compression for soil characterization.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Tab 6: Publications -->
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
