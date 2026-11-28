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
            <h1>Meet the Developers</h1>
            <p>Engineering minds behind the GEC Modasa Portal.</p>
        </header>

        <div class="dev-grid">

            <article class="dev-card">
                <div>
                    <div class="dev-header-flex">
                        <div class="dev-img-wrapper" onclick="openDevImageModal('developers_pic/Vanit.png')" title="Click to view full photo">
                            <img src="developers_pic/Vanit.png" alt="DANTANI VANIT NITINBHAI" class="dev-img" loading="eager">
                        </div>
                        <div class="dev-intro">
                            <h2 class="dev-name">DANTANI VANIT NITINBHAI</h2>
                            <div class="dev-role">Full Stack Developer</div>
                            <p class="dev-quote">"Engineering scalable interfaces, modular CMS workflows, and resilient web experiences."</p>
                        </div>
                    </div>

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

                    <div class="dev-section-title">
                        <i class="fa-solid fa-bullseye" style="color: #e05638;"></i> Key Contributions:
                    </div>
                    <div class="dev-contributions-desc">
                        Engineered the Global UI/UX System, Main Navigation, and responsive architecture across all 9 Engineering Departments, Academics, Administration, About &amp; Mandatory Disclosure,Library module, Hostel &amp mess and Activities. Built dynamic PHP/MySQL Admin CMS workflows and implemented a Cache-Aside layer with event-driven invalidation and stale fallback for high-traffic resilience.
                    </div>

                    <div class="dev-tech-heading">
                        <i class="fa-solid fa-code" style="color: #2563eb;"></i> Tech Stack I used in this portal:
                    </div>

                    <div class="dev-stack-category">Frontend UI:</div>
                    <div class="dev-pills-wrap">
                        <span class="dev-badge dev-badge-blue">HTML5 / CSS3</span>
                        <span class="dev-badge dev-badge-blue">JavaScript (ES6+)</span>
                        <span class="dev-badge dev-badge-blue">Responsive UI/UX</span>
                        <span class="dev-badge dev-badge-blue">Design System</span>
                    </div>

                    <div class="dev-stack-category">Backend &amp; System Design:</div>
                    <div class="dev-pills-wrap">
                        <span class="dev-badge dev-badge-green">PHP &amp; MySQL (PDO)</span>
                        <span class="dev-badge dev-badge-green">Cache-Aside Architecture</span>
                        <span class="dev-badge dev-badge-green">Event-Driven Invalidation</span>
                        <span class="dev-badge dev-badge-purple">Dynamic Admin CMS</span>
                        <span class="dev-badge dev-badge-purple">Modular Multi-Page UI</span>
                    </div>

                    <div class="dev-stack-category">Tools &amp; Performance:</div>
                    <div class="dev-pills-wrap">
                        <span class="dev-badge dev-badge-red">Git &amp; GitHub</span>
                        <span class="dev-badge dev-badge-red">CI/CD Pipeline</span>
                        <span class="dev-badge dev-badge-red">Stale-Fallback Caching</span>
                        <span class="dev-badge dev-badge-red">JSON File Storage</span>
                        <span class="dev-badge dev-badge-red">Performance Optimization</span>
                    </div>
                </div>

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

            <article class="dev-card">
                <div>
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

                    <div class="dev-section-title">
                        <i class="fa-solid fa-bullseye" style="color: #e05638;"></i> Key Contributions:
                    </div>
                    <div class="dev-contributions-desc">
                        Architected the modular PHP/MySQL CMS with 3-Tier RBAC, approval workflows, and database migrations. Implemented Clean URL routing (301 redirects), Technical SEO, responsive UI/UX, student portals, CI/CD pipelines, and production deployment.
                    </div>

                    <div class="dev-tech-heading">
                        <i class="fa-solid fa-code" style="color: #2563eb;"></i> Tech Stack I used in this portal:
                    </div>

                    <div class="dev-stack-category">Frontend UI:</div>
                    <div class="dev-pills-wrap">
                        <span class="dev-badge dev-badge-blue">HTML5 / CSS3</span>
                        <span class="dev-badge dev-badge-blue">JavaScript / AJAX</span>
                        <span class="dev-badge dev-badge-blue">Responsive UI/UX</span>
                    </div>

                    <div class="dev-stack-category">Backend &amp; Architecture:</div>
                    <div class="dev-pills-wrap">
                        <span class="dev-badge dev-badge-green">PHP &amp; MySQL (PDO)</span>
                        <span class="dev-badge dev-badge-green">Modular System Design</span>
                        <span class="dev-badge dev-badge-green">3-Tier RBAC</span>
                        <span class="dev-badge dev-badge-purple">URL Rewriting (301)</span>
                        <span class="dev-badge dev-badge-purple">Technical SEO &amp; Schema</span>
                    </div>

                    <div class="dev-stack-category">Tools &amp; Deployment:</div>
                    <div class="dev-pills-wrap">
                        <span class="dev-badge dev-badge-red">Git &amp; Version Control</span>
                        <span class="dev-badge dev-badge-red">Apache (.htaccess)</span>
                        <span class="dev-badge dev-badge-red">CI/CD Pipeline</span>
                        <span class="dev-badge dev-badge-red">Production Deployment</span>
                    </div>
                </div>

                <div>
                    <div class="connect-heading">Let's Connect</div>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/in/amanprajapati2" target="_blank" rel="noopener noreferrer" class="social-btn linkedin" title="LinkedIn" aria-label="Aman's LinkedIn">
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

