<?php
$page_title = "Admissions | Government Engineering College, Modasa";
$active_page = "admission";
$root_path = "";
$extra_css = "css/admission.css";

require_once __DIR__ . '/includes/header.php';
?>

<div class="admission-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="admission-hero">
        <div class="container">
            <span class="admission-kicker">ACADEMIC ADMISSIONS</span>
            <h1 class="admission-heading">Admissions</h1>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admission-content">
        <div class="container">

            <!-- Official ACPC Governance Statement Card -->
            <div class="admission-notice-card">
                <p class="admission-statement">
                    Being a Government institute the admissions are governed by ACPC committee. For more information please visit <a href="https://acpc.gujarat.gov.in/be-b-tech" target="_blank" rel="noopener noreferrer" class="admission-acpc-link">ACPC website <i class="fas fa-external-link-alt" style="font-size: 0.72rem;"></i></a>
                </p>
            </div>

            <!-- Degree Programmes Admission Breakdown -->
            <div class="admission-grid">

                <!-- Undergraduate (B.E.) Card -->
                <div class="admission-card">
                    <div>
                        <div class="admission-card-header">
                            <div class="admission-card-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h2 class="admission-card-title">Bachelor of Engineering (B.E.)</h2>
                        </div>
                        <div class="admission-card-body">
                            <p>Admissions to 4-year undergraduate engineering programmes across all 7 disciplines:</p>
                            <ul>
                                <li>Admission through ACPC centralized online counselling.</li>
                                <li>Eligibility: 10+2 (Science Stream with PCM) and valid GUJCET / JEE (Main) score.</li>
                                <li>Diploma to Degree (D2D) lateral entry seats allocated per ACPC guidelines.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="admission-actions">
                        <a href="https://acpc.gujarat.gov.in/be-b-tech" target="_blank" rel="noopener noreferrer" class="admission-btn primary">
                            <i class="fas fa-external-link-alt"></i> ACPC B.E. Portal
                        </a>
                        <a href="<?= $root_path ?>courses.php" class="admission-btn outline">
                            <i class="fas fa-list-ul"></i> View Approved Intake
                        </a>
                    </div>
                </div>

                <!-- Postgraduate (M.E.) Card -->
                <div class="admission-card">
                    <div>
                        <div class="admission-card-header">
                            <div class="admission-card-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h2 class="admission-card-title">Master of Engineering (M.E.)</h2>
                        </div>
                        <div class="admission-card-body">
                            <p>Admissions to 2-year postgraduate programmes in Computer (Software Engineering) and Transportation Engineering:</p>
                            <ul>
                                <li>Admission governed by ACPC Post Graduate Admission Committee.</li>
                                <li>Eligibility: Recognized B.E./B.Tech degree in relevant discipline.</li>
                                <li>Merit-based admission with valid GATE or Gujarat PGCET score.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="admission-actions">
                        <a href="https://acpc.gujarat.gov.in/" target="_blank" rel="noopener noreferrer" class="admission-btn primary">
                            <i class="fas fa-external-link-alt"></i> ACPC Official Portal
                        </a>
                        <a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="admission-btn outline">
                            <i class="fas fa-book-open"></i> GTU Syllabus Portal
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </main>

</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
