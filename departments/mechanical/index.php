<?php
// Set Page Variables
$page_title = "Department of Mechanical Engineering — Government Engineering College, Modasa";
$active_page = "departments";
$root_path = "../../";
$extra_css = "departments/mechanical/css/department.css";
$extra_js = "departments/mechanical/js/department.js";

// Include Header
include_once __DIR__ . '/../../includes/header.php';
?>

<div class="us-dept-page">

    <!-- 1. US University Masthead & Hero Banner -->
    <header class="us-hero-banner">
        <div class="us-container">
            <nav class="us-breadcrumb" aria-label="Academic Navigation Breadcrumbs">
                <a href="<?= $root_path ?>">Home</a>
                <span class="sep">/</span>
                <a href="<?= $root_path ?>#departments">Academic Departments</a>
                <span class="sep">/</span>
                <span class="active-crumb">Mechanical Engineering</span>
            </nav>

            <span class="us-dept-kicker">Department of</span>
            <h1 class="us-dept-heading">Mechanical Engineering</h1>
            <p class="us-dept-tagline">
                Educating pioneering engineers in thermodynamics, structural mechanics, advanced manufacturing, and robotics since 1989. Committed to rigorous hands-on engineering practice in comprehensive laboratories and modern workshop facilities.
            </p>

            <!-- Institutional Metrics Strip -->
            <div class="us-stats-strip">
                <div class="us-stat-item">
                    <span class="us-stat-num">1989</span>
                    <span class="us-stat-label">Year of Establishment</span>
                </div>
                <div class="us-stat-item">
                    <span class="us-stat-num">120</span>
                    <span class="us-stat-label">Annual Approved Intake</span>
                </div>
                <div class="us-stat-item">
                    <span class="us-stat-num">14 <strong>Labs</strong></span>
                    <span class="us-stat-label">Laboratories &amp; Workshop</span>
                </div>
                <div class="us-stat-item">
                    <span class="us-stat-num">GTU / AICTE</span>
                    <span class="us-stat-label">Affiliation &amp; Approval</span>
                </div>
            </div>
        </div>
    </header>

    <!-- 2. Sticky Sub-Navigation Bar -->
    <nav class="us-subnav-bar" id="deptSubNav" aria-label="Department Navigation">
        <div class="us-container">
            <ul class="us-subnav-list" role="tablist">
                <li class="us-subnav-item active">
                    <button type="button" class="us-subnav-link active" data-tab="about" role="tab" aria-selected="true">About Department</button>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="vision-mission" role="tab" aria-selected="false">Vision &amp; Mission</button>
                </li>
                <li class="us-subnav-item">
                    <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="us-subnav-link" aria-label="GTU Official Syllabus Portal">
                        <span>Syllabus</span>
                        <i class="fas fa-external-link-alt ext-arrow"></i>
                    </a>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="faculty" role="tab" aria-selected="false">Faculty Directory</button>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="activities" role="tab" aria-selected="false">Activities</button>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="facilities" role="tab" aria-selected="false">Facilities &amp; Labs</button>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="publications" role="tab" aria-selected="false">Publications</button>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="advisory-board" role="tab" aria-selected="false">Industry Advisory Board</button>
                </li>
                <li class="us-subnav-item">
                    <button type="button" class="us-subnav-link" data-tab="newsletters" role="tab" aria-selected="false">Newsletters</button>
                </li>
            </ul>
        </div>
    </nav>

    <!-- 3. Main Department Content -->
    <main class="us-main-content">
        <div class="us-container">

            <!-- TAB 1: ABOUT DEPARTMENT -->
            <section class="us-tab-pane active" id="tab-about">
                <div class="us-section-header">
                    <span class="us-section-kicker">ACADEMIC OVERVIEW</span>
                    <h2>About the Department</h2>
                    <p>Delivering comprehensive training in thermal sciences, mechanical machine design, precision manufacturing, automation, and industrial systems.</p>
                </div>

                <div class="us-about-split">
                    <div class="us-story-body">
                        <blockquote class="us-lead-quote">
                            "Cultivating mechanical engineers who understand physical laws, materials science, and modern computational simulation to build sustainable machines."
                        </blockquote>
                        <p>
                            Founded in 1989, the Department of Mechanical Engineering is one of the premier foundational engineering branches at Government Engineering College, Modasa. Over three decades of academic excellence, the department has produced thousands of engineers serving core manufacturing, automotive, energy, and defense sectors globally.
                        </p>
                        <p>
                            The department houses 14 specialized engineering laboratories and a comprehensive Central Workshop spanning over 2,500 square meters. Students gain practical mastery across machine tools, CNC machining, metal casting, fluid dynamics, refrigeration test rigs, and finite element modeling software suites.
                        </p>
                        <p>
                            In addition to the undergraduate Bachelor of Engineering program with 120 seats, the department runs a specialized postgraduate program (M.E. in CAD/CAM) providing advanced research avenues in computational mechanics and automated manufacturing systems.
                        </p>
                    </div>

                    <div class="us-feature-cards">
                        <div class="us-feature-card">
                            <h4>Central Engineering Workshop</h4>
                            <p>Spacious workshop complex equipped with heavy lathe machines, shaper, milling, welding booths, and casting foundry.</p>
                        </div>
                        <div class="us-feature-card">
                            <h4>CAD/CAM Simulation Center</h4>
                            <p>Dedicated high-performance workstations hosting ANSYS, SolidWorks, AutoCAD, and CNC programming simulators.</p>
                        </div>
                        <div class="us-feature-card">
                            <h4>Thermal Science Test Rigs</h4>
                            <p>Multi-cylinder diesel and petrol engine test benches, heat exchanger rigs, and refrigeration &amp; air-conditioning setups.</p>
                        </div>
                        <div class="us-feature-card">
                            <h4>Postgraduate Research Center</h4>
                            <p>M.E. in CAD/CAM offering research opportunities in finite element analysis, kinematics, and additive manufacturing.</p>
                        </div>
                    </div>
                </div>

                <!-- Academic Programmes Table -->
                <div class="us-degrees-section">
                    <h3>Academic Degree Programs</h3>
                    <div class="us-table-wrap">
                        <table class="us-clean-table">
                            <thead>
                                <tr>
                                    <th>Program Title</th>
                                    <th>Level</th>
                                    <th>Approved Intake</th>
                                    <th>Duration</th>
                                    <th>Affiliation</th>
                                    <th>Eligibility / Admission</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>B.E. Mechanical Engineering</strong></td>
                                    <td><span class="us-tag-ug">Undergraduate</span></td>
                                    <td>120 Seats</td>
                                    <td>4 Years (8 Semesters)</td>
                                    <td>GTU / AICTE Approved</td>
                                    <td>ACPC Gujarat (GUJCET / JEE Main)</td>
                                </tr>
                                <tr>
                                    <td><strong>M.E. CAD / CAM</strong></td>
                                    <td><span class="us-tag-pg">Postgraduate</span></td>
                                    <td>18 Seats</td>
                                    <td>2 Years (4 Semesters)</td>
                                    <td>GTU / AICTE Approved</td>
                                    <td>ACPC Gujarat (GATE / Non-GATE PGCET)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- TAB 2: VISION & MISSION -->
            <section class="us-tab-pane" id="tab-vision-mission">
                <div class="us-section-header">
                    <span class="us-section-kicker">INSTITUTIONAL CHARTER</span>
                    <h2>Vision &amp; Mission</h2>
                    <p>Guiding pedagogical rigor, ethical engineering practices, and industrial leadership in mechanical engineering.</p>
                </div>

                <div class="us-charter-grid">
                    <div class="us-charter-card">
                        <h3>Department Vision</h3>
                        <p class="us-charter-desc">
                            "To achieve national recognition in mechanical engineering education and research by nurturing competent, innovative, and ethically grounded engineers who contribute meaningfully to industrial advancement and environmental sustainability."
                        </p>
                    </div>

                    <div class="us-charter-card">
                        <h3>Department Mission</h3>
                        <ul class="us-mission-steps">
                            <li class="us-mission-item">
                                <span class="us-mission-index">I</span>
                                <div class="us-mission-text">
                                    <strong>Fundamental Mastery:</strong> Provide rigorous conceptual knowledge in thermal, design, and manufacturing domains integrated with extensive laboratory practice.
                                </div>
                            </li>
                            <li class="us-mission-item">
                                <span class="us-mission-index">II</span>
                                <div class="us-mission-text">
                                    <strong>Industrial Synergy:</strong> Enhance industry collaborations, plant internships, and live problem-solving to meet contemporary manufacturing requirements.
                                </div>
                            </li>
                            <li class="us-mission-item">
                                <span class="us-mission-index">III</span>
                                <div class="us-mission-text">
                                    <strong>Research &amp; Sustainability:</strong> Promote innovative multidisciplinary research focused on clean energy technologies and advanced materials.
                                </div>
                            </li>
                            <li class="us-mission-item">
                                <span class="us-mission-index">IV</span>
                                <div class="us-mission-text">
                                    <strong>Societal Stewardship:</strong> Foster professional ethics, leadership qualities, safety consciousness, and commitment to lifelong engineering growth.
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Objectives (PEOs & PSOs) -->
                <div class="us-objectives-grid">
                    <div class="us-obj-card">
                        <h4>Program Educational Objectives (PEOs)</h4>
                        <ul class="us-obj-list">
                            <li><strong>PEO 1:</strong> Build successful engineering careers in automotive, energy, aerospace, manufacturing industries or pursue scholarly research.</li>
                            <li><strong>PEO 2:</strong> Formulate, analyze, and synthesize mechanical systems and thermal processes using experimental and computational methods.</li>
                            <li><strong>PEO 3:</strong> Demonstrate professional ethics, effective project leadership, environmental responsibility, and continuous professional growth.</li>
                        </ul>
                    </div>

                    <div class="us-obj-card">
                        <h4>Program Specific Outcomes (PSOs)</h4>
                        <ul class="us-obj-list">
                            <li><strong>PSO 1:</strong> Ability to analyze, design, and optimize mechanical and thermal systems using modern CAD/CAE tools.</li>
                            <li><strong>PSO 2:</strong> Ability to select suitable materials and manufacturing processes for high-precision, economical, and sustainable product fabrication.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- TAB 3: FACULTY DIRECTORY -->
            <section class="us-tab-pane" id="tab-faculty">
                <div class="us-section-header">
                    <span class="us-section-kicker">SCHOLARLY DIRECTORY</span>
                    <h2>Faculty Members</h2>
                    <p>Our experienced professors, research scholars, and workshop mentors dedicated to engineering excellence.</p>
                </div>

                <div class="us-faculty-roster">
                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">US</div>
                        <h4 class="us-faculty-name">Dr. U. V. Shah</h4>
                        <div class="us-faculty-rank">Professor &amp; Head of Department</div>
                        <div class="us-faculty-degrees">Ph.D., M.Tech (Thermal Engineering)<br><small>Specialization: Computational Fluid Dynamics, Heat Transfer</small></div>
                        <a href="mailto:hod_mech@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> hod_mech@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">PN</div>
                        <h4 class="us-faculty-name">Prof. P. K. Nanavati</h4>
                        <div class="us-faculty-rank">Associate Professor</div>
                        <div class="us-faculty-degrees">Ph.D. (Pursuing), M.E. (Mechanical Engineering)<br><small>Specialization: Advanced Manufacturing, Quality Control</small></div>
                        <a href="mailto:pknanavati@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> pknanavati@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">MP</div>
                        <h4 class="us-faculty-name">Prof. M. J. Patel</h4>
                        <div class="us-faculty-rank">Assistant Professor</div>
                        <div class="us-faculty-degrees">M.E. (Machine Design)<br><small>Specialization: Finite Element Analysis, Kinematics</small></div>
                        <a href="mailto:mjpatel@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> mjpatel@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">SC</div>
                        <h4 class="us-faculty-name">Prof. S. A. Chauhan</h4>
                        <div class="us-faculty-rank">Assistant Professor</div>
                        <div class="us-faculty-degrees">M.Tech (Thermal Sciences)<br><small>Specialization: Renewable Energy, Refrigeration &amp; AC</small></div>
                        <a href="mailto:sachauhan@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> sachauhan@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">RJ</div>
                        <h4 class="us-faculty-name">Prof. R. B. Joshi</h4>
                        <div class="us-faculty-rank">Assistant Professor</div>
                        <div class="us-faculty-degrees">M.E. (CAD / CAM)<br><small>Specialization: CNC Machining, Robotics, Additive Manufacturing</small></div>
                        <a href="mailto:rbjoshi@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> rbjoshi@gecmodasa.ac.in
                        </a>
                    </div>

                    <div class="us-faculty-card">
                        <div class="us-faculty-initials">VB</div>
                        <h4 class="us-faculty-name">Prof. V. K. Barot</h4>
                        <div class="us-faculty-rank">Assistant Professor</div>
                        <div class="us-faculty-degrees">M.Tech (Industrial Engineering)<br><small>Specialization: Operations Research, Supply Chain Logistics</small></div>
                        <a href="mailto:vkbarot@gecmodasa.ac.in" class="us-faculty-contact">
                            <i class="fas fa-envelope"></i> vkbarot@gecmodasa.ac.in
                        </a>
                    </div>
                </div>
            </section>

            <!-- TAB 4: ACTIVITIES & EVENTS -->
            <section class="us-tab-pane" id="tab-activities">
                <div class="us-section-header">
                    <span class="us-section-kicker">CAMPUS ENGAGEMENT</span>
                    <h2>Department Activities</h2>
                    <p>Automotive design challenges, heavy industry factory visits, expert masterclasses, and hands-on fabrication workshops.</p>
                </div>

                <div class="us-periodical-grid">
                    <div class="us-feature-card">
                        <h4>SAE Collegiate Design Challenge</h4>
                        <p>Inter-college motorsport design team developing all-terrain vehicles (ATVs) and electric karts for national SAE BAJA and SUPRA competitions.</p>
                    </div>
                    <div class="us-feature-card">
                        <h4>Industrial Plant Exposure Tours</h4>
                        <p>Regular study tours to major industrial complexes including Adani Thermal Power Station, L&amp;T Heavy Engineering Hazira, and Elecon Gears.</p>
                    </div>
                    <div class="us-feature-card">
                        <h4>Robotics &amp; Automation Bootcamps</h4>
                        <p>Intensive hands-on workshops on PLC programming, industrial robotic arm kinematics, and pneumatics/hydraulics automation circuits.</p>
                    </div>
                    <div class="us-feature-card">
                        <h4>FDP on Advanced Green Energy Systems</h4>
                        <p>State-level faculty development program exploring solar thermal collectors, hydrogen fuel storage, and green refrigeration cycles.</p>
                    </div>
                </div>
            </section>

            <!-- TAB 5: FACILITIES & LABS -->
            <section class="us-tab-pane" id="tab-facilities">
                <div class="us-section-header">
                    <span class="us-section-kicker">EXPERIMENTAL INFRASTRUCTURE</span>
                    <h2>Laboratories &amp; Facilities</h2>
                    <p>Comprehensive physical experimental rigs and central workshop facilities spanning design, testing, machining, and thermal analysis.</p>
                </div>

                <div class="us-labs-showcase">
                    <!-- Lab 1: Central Workshop -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="../../images/hero_campus_1.jpg" alt="Central Engineering Workshop" loading="lazy">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Main Workshop Complex</span>
                            <h3 class="us-lab-title">Central Mechanical Workshop</h3>
                            <p class="us-lab-desc">Equipped with 20+ heavy centre lathes, universal milling machine, shaping machines, radial drill, welding booths, and sand casting foundry.</p>
                        </div>
                    </div>

                    <!-- Lab 2: Fluid Mechanics & Machinery Lab -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="../../images/hero_campus_2.jpg" alt="Fluid Mechanics &amp; Machinery Lab" loading="lazy">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Lab Block M-102</span>
                            <h3 class="us-lab-title">Fluid Mechanics &amp; Hydraulic Machinery Lab</h3>
                            <p class="us-lab-desc">Features calibrated test benches for Pelton turbine, Francis turbine, centrifugal pumps, Bernoulli apparatus, and pipe friction flow meters.</p>
                        </div>
                    </div>

                    <!-- Lab 3: Heat Transfer & I.C. Engines Lab -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="../../images/hero_campus_3.jpg" alt="Heat Transfer &amp; I.C. Engines Lab" loading="lazy">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Lab Block M-104</span>
                            <h3 class="us-lab-title">Heat Transfer &amp; I.C. Engines Lab</h3>
                            <p class="us-lab-desc">Outfitted with computerized single and multi-cylinder petrol/diesel test engines with eddy current dynamometers and emission measurement sensors.</p>
                        </div>
                    </div>

                    <!-- Lab 4: Dynamics of Machines Lab -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="../../images/hero_campus_4.jpg" alt="Dynamics of Machines Lab" loading="lazy">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Lab Block M-201</span>
                            <h3 class="us-lab-title">Dynamics of Machines &amp; Vibration Lab</h3>
                            <p class="us-lab-desc">Experimental apparatus for studying motorized gyroscope precessional torque, static &amp; dynamic balancing, cam-follower kinematics, and governors.</p>
                        </div>
                    </div>

                    <!-- Lab 5: CAD/CAM Center -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="../../images/hero_campus_1.jpg" alt="CAD/CAM &amp; FEA Computing Lab" loading="lazy">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Lab Block M-205</span>
                            <h3 class="us-lab-title">CAD / CAM &amp; Computational Mechanics Lab</h3>
                            <p class="us-lab-desc">Equipped with 40 high-performance workstations running ANSYS, SolidWorks, PTC Creo, and CNC simulator software for 3D modeling and structural stress analysis.</p>
                        </div>
                    </div>

                    <!-- Lab 6: Metrology & Metallurgy Lab -->
                    <div class="us-lab-card">
                        <div class="us-lab-image-frame">
                            <img src="../../images/hero_campus_2.jpg" alt="Metrology &amp; Material Testing Lab" loading="lazy">
                        </div>
                        <div class="us-lab-details">
                            <span class="us-lab-room">Lab Block M-208</span>
                            <h3 class="us-lab-title">Metrology &amp; Material Testing Lab</h3>
                            <p class="us-lab-desc">Universal Testing Machine (UTM), Rockwell/Brinell hardness testers, optical profile projector, metallurgy microscope, and surface roughness testers.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- TAB 6: PUBLICATIONS -->
            <section class="us-tab-pane" id="tab-publications">
                <div class="us-section-header">
                    <span class="us-section-kicker">SCHOLARLY OUTPUT</span>
                    <h2>Faculty Publications</h2>
                    <p>Recent research articles published by mechanical faculty in peer-reviewed international journals and ASME/Elsevier conference proceedings.</p>
                </div>

                <div class="us-citations-list">
                    <div class="us-citation-item">
                        <div class="us-citation-title">Experimental Investigation of Turbulent Convective Heat Transfer in Micro-Fin Tubes using Al2O3 Nanofluids</div>
                        <div class="us-citation-authors">Dr. U. V. Shah, Prof. S. A. Chauhan (2024)</div>
                        <div class="us-citation-venue">Elsevier International Journal of Thermal Sciences, Vol. 192, Article 108422</div>
                    </div>
                    <div class="us-citation-item">
                        <div class="us-citation-title">Structural Optimization and Crashworthiness Simulation of Automotive Bumper Beams using High-Strength Composites</div>
                        <div class="us-citation-authors">Prof. M. J. Patel, Dr. U. V. Shah (2023)</div>
                        <div class="us-citation-venue">ASME Journal of Mechanical Design, Vol. 145, Issue 6</div>
                    </div>
                    <div class="us-citation-item">
                        <div class="us-citation-title">Multi-Objective Optimization of CNC End Milling Parameters for Inconel 718 Superalloys using Taguchi-Grey Relational Analysis</div>
                        <div class="us-citation-authors">Prof. P. K. Nanavati, Prof. R. B. Joshi (2023)</div>
                        <div class="us-citation-venue">Springer Journal of The Institution of Engineers (India): Series C, Vol. 104, pp. 411–425</div>
                    </div>
                    <div class="us-citation-item">
                        <div class="us-citation-title">Thermodynamic Analysis of Organic Rankine Cycle Powered by Low-Grade Industrial Waste Heat</div>
                        <div class="us-citation-authors">Prof. S. A. Chauhan, Prof. V. K. Barot (2022)</div>
                        <div class="us-citation-venue">Elsevier Energy Conversion and Management, Vol. 268, Article 116035</div>
                    </div>
                </div>
            </section>

            <!-- TAB 7: INDUSTRY ADVISORY BOARD -->
            <section class="us-tab-pane" id="tab-advisory-board">
                <div class="us-section-header">
                    <span class="us-section-kicker">GOVERNANCE &amp; CURRICULUM</span>
                    <h2>Industry Advisory Board (IAB)</h2>
                    <p>Eminent plant directors, chief engineers, and manufacturing leaders guiding academic curriculum relevance and graduate recruitment.</p>
                </div>

                <div class="us-table-wrap">
                    <table class="us-clean-table">
                        <thead>
                            <tr>
                                <th>Distinguished Member</th>
                                <th>Organization &amp; Designation</th>
                                <th>Committee Role</th>
                                <th>Active Term</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Dr. U. V. Shah</strong></td>
                                <td>Head of Department, Mechanical Engineering, GEC Modasa</td>
                                <td>Chairman</td>
                                <td>2025–2026</td>
                            </tr>
                            <tr>
                                <td><strong>Mr. Dharmesh Patel</strong></td>
                                <td>Senior General Manager (Manufacturing), Larsen &amp; Toubro Heavy Engineering</td>
                                <td>Industry Member</td>
                                <td>2025–2026</td>
                            </tr>
                            <tr>
                                <td><strong>Mr. Keyur Trivedi</strong></td>
                                <td>Chief Thermal Design Specialist, Thermax Limited</td>
                                <td>Industry Member</td>
                                <td>2025–2026</td>
                            </tr>
                            <tr>
                                <td><strong>Prof. P. K. Nanavati</strong></td>
                                <td>Associate Professor, Mechanical Engineering, GEC Modasa</td>
                                <td>Member Secretary</td>
                                <td>2025–2026</td>
                            </tr>
                            <tr>
                                <td><strong>Mr. Ashish Shah</strong></td>
                                <td>Vice President - Engineering Operations, Elecon Engineering Co. Ltd.</td>
                                <td>Industry Member</td>
                                <td>2023–2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- TAB 8: NEWSLETTERS -->
            <section class="us-tab-pane" id="tab-newsletters">
                <div class="us-section-header">
                    <span class="us-section-kicker">DEPARTMENT CHRONICLE</span>
                    <h2>Department Newsletters</h2>
                    <p>Official periodic publication documenting student vehicle innovations, industry internships, faculty honors, and alumni career achievements.</p>
                </div>

                <div class="us-periodical-grid">
                    <div class="us-periodical-card">
                        <div class="us-periodical-body">
                            <span class="us-periodical-meta">Vol. 1, Issue 2 · Academic Year 2024–25</span>
                            <h4 class="us-periodical-title">MechE Chronicle</h4>
                            <p class="us-periodical-summary">Spotlights the SAE BAJA all-terrain vehicle build, plant visits to L&amp;T Hazira, international conference papers presented by faculty, and campus placement records.</p>
                            <a href="#" class="us-download-btn"><i class="fas fa-file-pdf"></i> Download Newsletter (PDF)</a>
                        </div>
                    </div>

                    <div class="us-periodical-card">
                        <div class="us-periodical-body">
                            <span class="us-periodical-meta">Vol. 1, Issue 1 · Academic Year 2023–24</span>
                            <h4 class="us-periodical-title">MechE Chronicle (Inaugural Issue)</h4>
                            <p class="us-periodical-summary">Inaugural release reviewing CNC machine installations, CAD/CAM simulation lab inaugurations, student technical project exhibitions, and alumni industrial leadership.</p>
                            <a href="#" class="us-download-btn"><i class="fas fa-file-pdf"></i> Download Newsletter (PDF)</a>
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
