<?php
$page_title = "Admissions | Government Engineering College, Modasa";
$active_page = "admission";
$root_path = "../";
$extra_css = "css/admission.css";

require_once __DIR__ . '/../includes/header.php';
?>

<div class="admission-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="admission-hero">
        <div class="container act-reveal">
            <span class="admission-kicker">ACADEMIC ADMISSIONS</span>
            <h1 class="admission-heading">Admissions</h1>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admission-content">
        <div class="container">

            <!-- Official ACPC Governance Statement Card -->
            <div class="admission-notice-card act-reveal">
                <p class="admission-statement">
                    Being a Government institute the admissions are governed by ACPC committee. For more information please visit <a href="https://acpc.gujarat.gov.in/be-b-tech" target="_blank" rel="noopener noreferrer" class="admission-acpc-link">ACPC website <i class="fas fa-external-link-alt" style="font-size: 0.72rem;"></i></a>
                </p>
            </div>

            <!-- Degree Programmes Admission Breakdown -->
            <div class="admission-grid">

                <!-- Undergraduate (B.E.) Card -->
                <div class="admission-card act-reveal">
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
                    </div>
                </div>

                <!-- Postgraduate (M.E.) Card -->
                <div class="admission-card act-reveal">
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
                    </div>
                </div>

            </div>

        </div>
    </main>

</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const revealSelectors = [
        '.admission-hero .container',
        '.admission-notice-card',
        '.admission-card'
    ];

    let revealObserver = null;
    if ('IntersectionObserver' in window) {
        revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            root: null,
            rootMargin: '0px 0px 20px 0px',
            threshold: 0.02
        });
    }

    function setupRevealElements(container = document) {
        if (!container) return;
        const elements = container.querySelectorAll(revealSelectors.join(', '));
        const viewportHeight = window.innerHeight || document.documentElement.clientHeight;

        elements.forEach(el => {
            if (!el.classList.contains('act-reveal')) {
                el.classList.add('act-reveal');
            }
            const rect = el.getBoundingClientRect();
            if (rect.top < viewportHeight - 30 && rect.bottom > 0) {
                setTimeout(() => el.classList.add('is-revealed'), 80);
            } else if (revealObserver) {
                revealObserver.observe(el);
            } else {
                el.classList.add('is-revealed');
            }
        });
    }

    setupRevealElements(document);
});
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>

