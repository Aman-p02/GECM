<?php
// Set Page Variables
$page_title = "Meet the Developers | GEC Modasa";
$page_description = "Meet the student software developers behind the architecture, design, and engineering of the Government Engineering College, Modasa web portal.";
$page_keywords = "GEC Modasa Developers, GECM Web Team, Dantani Vanit Nitinbhai, Prajapati Aman Jayeshbhai, GEC Modasa Portal Developers";
$active_page = "developers";
$root_path = "../";

// Include Header
include_once __DIR__ . '/../includes/header.php';
?>

<link rel="stylesheet" href="css/style.css?v=<?= filemtime(__DIR__ . '/css/style.css') ?>">

<section class="dev-main-section">
    <!-- Ambient Background Blobs -->
    <div class="bg-blobs" aria-hidden="true">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>

    <!-- Main Container -->
    <div class="dev-container">

        <!-- Header -->
        <header class="dev-header">
            <span class="dev-kicker">GEC MODASA</span>
            <h1>Meet the Developers</h1>
            <p>The engineering minds behind the architecture and development of the GEC Modasa Placement Portal.</p>
        </header>

        <!-- 2 Developers Grid: Vanit First, Aman Second -->
        <div class="dev-grid">

            <!-- ==============================================
                 Developer 1: Vanit Dantani (Placed First)
                 ============================================== -->
            <article class="dev-card">
                <div>
                    <!-- Top Row: Avatar + Intro -->
                    <div class="dev-header-flex">
                        <div class="dev-img-wrapper" onclick="openDevImageModal('developers_pic/Vanit.png')" title="Click to view full photo">
                            <img src="developers_pic/Vanit.png" alt="DANTANI VANIT NITINBHAI" class="dev-img" loading="eager">
                        </div>
                        <div class="dev-intro">
                            <h2 class="dev-name">DANTANI VANIT NITINBHAI</h2>
                            <div class="dev-role">Full Stack Developer</div>
                            <p class="dev-quote">"Transforming complex data into intuitive dashboards and seamless user experiences."</p>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="dev-info">
                        <div class="dev-info-item">
                            <i class="fa-solid fa-id-badge"></i>
                            <span><strong>Enrollment:</strong> 250163107004</span>
                        </div>
                        <div class="dev-info-item">
                            <i class="fa-solid fa-laptop-code"></i>
                            <span><strong>Branch:</strong> Computer Engineering</span>
                        </div>
                        <div class="dev-info-item">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span><strong>Batch:</strong> 2025 - 2028</span>
                        </div>
                        <div class="dev-info-item">
                            <i class="fa-solid fa-envelope"></i>
                            <span><strong>Email:</strong> <a href="mailto:vanitdantani05@gmail.com">vanitdantani05@gmail.com</a></span>
                        </div>
                    </div>

                    <hr class="dev-divider">

                    <!-- Key Contributions -->
                    <div class="dev-section-title">
                        <i class="fa-solid fa-bullseye" style="color: #e05638;"></i> Key Contributions:
                    </div>
                    <div class="dev-contributions-desc">
                        Developed statistics page, super admin panel &amp; UI design. Handled backend logic &amp; database architecture. Developed interactive resume builder tool and worked on student panel.
                    </div>

                    <!-- Tech Stack -->
                    <div class="dev-tech-heading">
                        <i class="fa-solid fa-code" style="color: #2563eb;"></i> Tech Stack I used in this portal:
                    </div>

                    <!-- Frontend UI -->
                    <div class="dev-stack-category">Frontend UI:</div>
                    <div class="dev-pills-wrap">
                        <span class="dev-badge dev-badge-blue">HTML/CSS</span>
                        <span class="dev-badge dev-badge-blue">Bootstrap 5</span>
                        <span class="dev-badge dev-badge-blue">JavaScript</span>
                    </div>

                    <!-- Backend & AI / ML -->
                    <div class="dev-stack-category">Backend &amp; AI / ML:</div>
                    <div class="dev-pills-wrap">
                        <span class="dev-badge dev-badge-green">PHP</span>
                        <span class="dev-badge dev-badge-green">MySQL</span>
                        <span class="dev-badge dev-badge-purple">Machine Learning</span>
                        <span class="dev-badge dev-badge-purple">API Integration</span>
                    </div>

                    <!-- Tools & APIs -->
                    <div class="dev-stack-category">Tools &amp; APIs:</div>
                    <div class="dev-pills-wrap">
                        <span class="dev-badge dev-badge-red">Git</span>
                        <span class="dev-badge dev-badge-red">GitHub</span>
                        <span class="dev-badge dev-badge-red">REST API</span>
                    </div>
                </div>

                <!-- Connect Links -->
                <div>
                    <div class="connect-heading">Let's Connect</div>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/in/vanitdantani" target="_blank" rel="noopener noreferrer" class="social-btn linkedin" title="LinkedIn" aria-label="Vanit's LinkedIn">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <a href="https://github.com/VanitDantani" target="_blank" rel="noopener noreferrer" class="social-btn github" title="GitHub" aria-label="Vanit's GitHub">
                            <i class="fa-brands fa-github"></i>
                        </a>
                        <a href="https://vanitdantaniportfolio.netlify.app/" target="_blank" rel="noopener noreferrer" class="social-btn portfolio" title="Portfolio Website" aria-label="Vanit's Portfolio">
                            <i class="fa-solid fa-globe"></i>
                        </a>
                    </div>
                </div>
            </article>

            <!-- ==============================================
                 Developer 2: Aman Prajapati (Placed Second)
                 ============================================== -->
            <article class="dev-card">
                <div>
                    <!-- Top Row: Avatar + Intro -->
                    <div class="dev-header-flex">
                        <div class="dev-img-wrapper" onclick="openDevImageModal('developers_pic/Aman5.png')" title="Click to view full photo">
                            <img src="developers_pic/Aman5.png" alt="Prajapati Aman Jayeshbhai" class="dev-img" loading="eager">
                        </div>
                        <div class="dev-intro">
                            <h2 class="dev-name">PRAJAPATI AMAN JAYESHBHAI</h2>
                            <div class="dev-role">Full Stack Developer</div>
                            <p class="dev-quote">"Transforming ideas into digital reality through modern web technologies."</p>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="dev-info">
                        <div class="dev-info-item">
                            <i class="fa-solid fa-id-badge"></i>
                            <span><strong>Enrollment:</strong> 250163107021</span>
                        </div>
                        <div class="dev-info-item">
                            <i class="fa-solid fa-laptop-code"></i>
                            <span><strong>Branch:</strong> Computer Engineering</span>
                        </div>
                        <div class="dev-info-item">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span><strong>Batch:</strong> 2025 - 2028</span>
                        </div>
                        <div class="dev-info-item">
                            <i class="fa-solid fa-envelope"></i>
                            <span><strong>Email:</strong> <a href="mailto:amanjp5711@gmail.com">amanjp5711@gmail.com</a></span>
                        </div>
                    </div>

                    <hr class="dev-divider">

                    <!-- Key Contributions -->
                    <div class="dev-section-title">
                        <i class="fa-solid fa-bullseye" style="color: #e05638;"></i> Key Contributions:
                    </div>
                    <div class="dev-contributions-desc">
                        Developed student &amp; admin panels, database architecture, backend logic, UI design, and integrated an AI-powered real-time chat assistant and ML features like outlier detection, clustering, train model.
                    </div>

                    <!-- Tech Stack -->
                    <div class="dev-tech-heading">
                        <i class="fa-solid fa-code" style="color: #2563eb;"></i> Tech Stack I used in this portal:
                    </div>

                    <!-- Frontend UI -->
                    <div class="dev-stack-category">Frontend UI:</div>
                    <div class="dev-pills-wrap">
                        <span class="dev-badge dev-badge-blue">HTML/CSS</span>
                        <span class="dev-badge dev-badge-blue">Bootstrap 5</span>
                        <span class="dev-badge dev-badge-blue">JS/AJAX</span>
                    </div>

                    <!-- Backend & AI / ML -->
                    <div class="dev-stack-category">Backend &amp; AI / ML:</div>
                    <div class="dev-pills-wrap">
                        <span class="dev-badge dev-badge-green">PHP</span>
                        <span class="dev-badge dev-badge-green">SQL Database</span>
                        <span class="dev-badge dev-badge-green">Apache URL Rewriting</span>
                        <span class="dev-badge dev-badge-purple">API Integration</span>
                        <span class="dev-badge dev-badge-purple">Machine Learning</span>
                        <span class="dev-badge dev-badge-purple">Clustering &amp; Models</span>
                        <span class="dev-badge dev-badge-purple">Outlier Detection</span>
                        <span class="dev-badge dev-badge-purple">AI Chat Assistant</span>
                    </div>

                    <!-- Tools & APIs -->
                    <div class="dev-stack-category">Tools &amp; APIs:</div>
                    <div class="dev-pills-wrap">
                        <span class="dev-badge dev-badge-red">Git &amp; Version Control</span>
                        <span class="dev-badge dev-badge-red">CI/CD Pipeline</span>
                    </div>
                </div>

                <!-- Connect Links -->
                <div>
                    <div class="connect-heading">Let's Connect</div>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/in/aman-prajapati-855a8a37b/" target="_blank" rel="noopener noreferrer" class="social-btn linkedin" title="LinkedIn" aria-label="Aman's LinkedIn">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <a href="https://github.com/Aman-p02" target="_blank" rel="noopener noreferrer" class="social-btn github" title="GitHub" aria-label="Aman's GitHub">
                            <i class="fa-brands fa-github"></i>
                        </a>
                        <a href="https://amanprajapati2.vercel.app/" target="_blank" rel="noopener noreferrer" class="social-btn portfolio" title="Portfolio Website" aria-label="Aman's Portfolio">
                            <i class="fa-solid fa-globe"></i>
                        </a>
                    </div>
                </div>
            </article>

        </div>

        <!-- Animated Heart Footer Note -->
        <footer class="dev-footer">
            <p class="dev-footer-text">
                Crafted with <i class="fa-solid fa-heart heart-anim"></i> for
                <span class="highlight">GEC Modasa</span> <span style="font-size: 0.85rem;">(November 2026)</span>
            </p>
        </footer>

    </div>

    <!-- Self-Contained Instagram Style Image Modal -->
    <div class="dev-modal-overlay" id="devImageModal" onclick="closeDevImageModal(event)">
        <div class="dev-modal-content">
            <button type="button" class="dev-modal-close" onclick="closeDevImageModal(event)" aria-label="Close photo">&times;</button>
            <img id="devModalImg" src="" alt="Developer Photo" class="dev-modal-img">
        </div>
    </div>
</section>

<script>
    function openDevImageModal(src) {
        var modal = document.getElementById('devImageModal');
        var img = document.getElementById('devModalImg');
        if (modal && img) {
            img.src = src;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeDevImageModal(e) {
        if (!e || e.target.id === 'devImageModal' || e.target.classList.contains('dev-modal-close')) {
            var modal = document.getElementById('devImageModal');
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDevImageModal();
        }
    });
</script>

<?php
// Include Footer
include_once __DIR__ . '/../includes/footer.php';
?>
