<?php
$page_title = "Vision & Mission | Government Engineering College, Modasa";
$active_page = "vision-mission";
$root_path = "";
$extra_css = "css/vision-mission.css";

require_once __DIR__ . '/includes/header.php';
?>

<div class="vm-page" id="mainContent">

    <!-- Page Hero Banner (Seamless with Global Header) -->
    <header class="vm-hero">
        <div class="vm-container">
            <span class="vm-kicker">INSTITUTIONAL CHARTER</span>
            <h1 class="vm-heading">Vision &amp; Mission</h1>
            <p class="vm-lead">
                Guiding principles, strategic commitments, and educational objectives defining our engineering pedagogy and institutional ethos.
            </p>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="vm-content">
        <div class="vm-container">
            <div class="vm-charter-wrap">

                <!-- Vision Card (Matching Department Charter Architecture) -->
                <section class="vm-charter-card vm-vision-hero-card" aria-labelledby="visionHeading">
                    <div class="vm-charter-badge-wrap">
                        <span class="vm-charter-kicker" id="visionHeading">Vision of the Institute</span>
                    </div>
                    <span class="vm-vision-quote-mark">“</span>
                    <blockquote class="vm-vision-statement">
                        To be a leading institution ensuring Academic Excellence, Research, Nurturing Innovation and Entrepreneurial Attitude to produce competent technocrats for service to Nation.
                    </blockquote>
                </section>

                <!-- Mission Card (Roman Numerals & Step Items) -->
                <section class="vm-charter-card vm-mission-card" aria-labelledby="missionHeading">
                    <div class="vm-charter-badge-wrap">
                        <span class="vm-charter-kicker" id="missionHeading">Strategic Mission</span>
                    </div>
                    <h2 class="vm-charter-title">Mission of the Institute</h2>

                    <ul class="vm-mission-steps">
                        <li class="vm-mission-item">
                            <span class="vm-mission-index">I</span>
                            <div class="vm-mission-text">
                                To be a student centric institute imbibing experiential, innovative and lifelong learning skills, addressing societal problems.
                            </div>
                        </li>
                        <li class="vm-mission-item">
                            <span class="vm-mission-index">II</span>
                            <div class="vm-mission-text">
                                To create a conducive ecosystem for Research, innovation &amp; extension services.
                            </div>
                        </li>
                        <li class="vm-mission-item">
                            <span class="vm-mission-index">III</span>
                            <div class="vm-mission-text">
                                To inculcate entrepreneurial attitude and values amongst Learners.
                            </div>
                        </li>
                        <li class="vm-mission-item">
                            <span class="vm-mission-index">IV</span>
                            <div class="vm-mission-text">
                                To Collaborate with Industries and other institutions to strengthen symbiotic relations.
                            </div>
                        </li>
                        <li class="vm-mission-item">
                            <span class="vm-mission-index">V</span>
                            <div class="vm-mission-text">
                                To mentor aspiring Institutions to unleash their potential, towards nation building.
                            </div>
                        </li>
                    </ul>
                </section>

                <!-- Core Values Section -->
                <section class="vm-charter-card" aria-labelledby="valuesHeading">
                    <div class="vm-charter-badge-wrap">
                        <span class="vm-charter-kicker" id="valuesHeading" style="color: #64748b;">Foundational Principles</span>
                    </div>
                    <h2 class="vm-charter-title">Core Institutional Values</h2>
                    <p class="vm-values-lead">
                        Our core values are quality, equality, morality, environmental sustainability, energy saving, and a steadfast commitment to the cause of technical education and societal welfare.
                    </p>

                    <div class="vm-values-grid">
                        <div class="vm-value-card">
                            <div class="vm-value-header">
                                <div class="vm-value-icon orange">
                                    <i class="fas fa-seedling"></i>
                                </div>
                                <h3 class="vm-value-title">Equitable &amp; Harmonious Growth</h3>
                            </div>
                            <p class="vm-value-desc">
                                Fostering sustainable, inclusive progress and holistic development across students, faculty, staff, industry, and the community.
                            </p>
                        </div>

                        <div class="vm-value-card">
                            <div class="vm-value-header">
                                <div class="vm-value-icon blue">
                                    <i class="fas fa-award"></i>
                                </div>
                                <h3 class="vm-value-title">Quality &amp; High Moral Standards</h3>
                            </div>
                            <p class="vm-value-desc">
                                Imparting rigorous engineering education to nurture enlightened, ethical technocrats with strong civic consciousness and global values.
                            </p>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </main>

</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
