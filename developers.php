<?php
// Set Page Variables
$page_title = "Meet the Developers | GEC Modasa";
$page_description = "Meet the student software developers and project mentor behind the architecture, design, and engineering of the Government Engineering College, Modasa web portal.";
$page_keywords = "GEC Modasa Developers, GECM Web Team, Dantani Vanit Nitinbhai, Prajapati Aman Jayeshbhai, Dr. M M Goyani, GEC Modasa Portal Developers";
$active_page = "developers";
$root_path = "";

// Include Header
include_once __DIR__ . '/includes/header.php';
?>

<link rel="stylesheet" href="css/developers.css?v=<?= filemtime(__DIR__ . '/css/developers.css') ?>">

<div class="dev-main-section">
    <!-- Background Decoration Blobs -->
    <div class="bg-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>

    <!-- Main Content Container -->
    <div class="container pb-5 flex-grow-1 position-relative" style="z-index: 1;">

        <!-- Project Mentor Header -->
        <div class="dev-header mt-3 mb-3 pt-4">
            <h1 class="mb-2" style="font-size: clamp(1.5rem, 5vw, 2.25rem);">Project Mentor</h1>
            <p class="mb-0">Guiding the vision of the GEC Modasa Placement Portal.</p>
        </div>

        <div class="row g-4 justify-content-center">

            <!-- Mentor Card -->
            <div class="col-12 col-lg-8 mb-lg-2">
                <div class="dev-card" style="animation-delay: 0.1s;">
                    <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between gap-4 px-lg-3">

                        <!-- Left Side: Image + Info -->
                        <div class="dev-header-flex mb-0 w-auto">
                            <div class="dev-img-wrapper mb-3 mb-lg-0">
                                <img src="uploads/faculty/ce/MMG.jpg"
                                    alt="Dr. M M Goyani" class="dev-img" style="cursor: pointer;"
                                    onclick="openImageModal(this.src)"
                                    onerror="this.src='images/team/MMG.jpg'">
                            </div>
                            <div class="dev-intro text-center text-lg-start">
                                <h3 class="dev-name" style="font-size: 1.6rem;">Dr. M M Goyani</h3>
                                <div class="text-secondary fw-medium mb-1" style="font-size: 1.05rem;">Associate Professor</div>
                                <div class="badge mb-2 px-3 py-2"
                                    style="background-color: #e05e55; font-size: 0.9rem; font-weight: 500; border-radius: 6px;">
                                    Computer Engineering
                                </div>
                                <div class="fw-bold" style="color: var(--primary-navy); font-size: 1.1rem;">
                                    Placement Coordinator - Institute
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Email + Socials -->
                        <div class="text-center text-lg-end mt-2 mt-lg-0 pb-3 pb-lg-0">
                            <div class="d-flex align-items-center justify-content-center justify-content-lg-end gap-2 text-secondary mb-3">
                                <i class="fa-solid fa-envelope" style="color: #e05e55; font-size: 1.1rem;"></i>
                                <a href="mailto:mgoyani@gmail.com"
                                    class="text-secondary text-decoration-none fw-semibold"
                                    style="font-size: 1.05rem; transition: color 0.3s;"
                                    onmouseover="this.style.color='#e05e55'"
                                    onmouseout="this.style.color=''">mgoyani@gmail.com</a>
                            </div>
                            <div class="social-links justify-content-center justify-content-lg-end">
                                <a href="https://in.linkedin.com/in/mahesh-goyani-71321711" target="_blank" rel="noopener noreferrer" class="social-btn linkedin" title="LinkedIn">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                                <a href="https://maheshgoyani.in/" target="_blank" rel="noopener noreferrer" class="social-btn portfolio" title="Website">
                                    <i class="fa-solid fa-globe"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Developers Header -->
            <div class="col-12 mt-3">
                <div class="dev-header pt-0 pb-3">
                    <h1 class="mb-2">Meet the Developers</h1>
                    <p class="mb-0">The engineering minds behind the architecture and development of the GEC Modasa Placement Portal.</p>
                </div>
            </div>

            <!-- Developer 1: Vanit Dantani (Placed First per instructions) -->
            <div class="col-12 col-lg-6">
                <div class="dev-card" style="animation-delay: 0.1s;">
                    <div class="dev-header-flex">
                        <div class="dev-img-wrapper">
                            <img src="developers_pic/Vanit.png" alt="DANTANI VANIT NITINBHAI"
                                class="dev-img" style="cursor: pointer;" onclick="openImageModal(this.src)"
                                onerror="this.src='images/developers/Vanit.png'">
                        </div>
                        <div class="dev-intro">
                            <h3 class="dev-name">DANTANI VANIT NITINBHAI</h3>
                            <div class="dev-role">Full Stack Developer</div>
                            <div class="dev-quote">"Transforming complex data into intuitive dashboards and seamless user experiences."</div>
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
                    <hr class="my-2 border-secondary" style="opacity: 0.15;">

                    <div class="text-start mt-2">
                        <div style="color: var(--primary-navy); font-size: 0.95rem; font-weight: 800; margin-bottom: 4px;">
                            <i class="fa-solid fa-bullseye me-1 text-danger"></i> Key Contributions:
                        </div>
                        <div style="font-size: 0.9rem; line-height: 1.5; color: #222; font-weight: 500;" class="mb-2 fw-medium">
                            Developed statistics page, super admin panel &amp; UI design. Handled backend logic &amp; database architecture. Developed interactive resume builder tool and worked on student panel.
                        </div>
                        <br>
                        <div style="color: var(--primary-navy); font-size: 0.95rem; font-weight: 800; margin-bottom: 6px;">
                            <i class="fa-solid fa-code me-1 text-primary"></i> Tech Stack I used in this portal:
                        </div>
                        <div class="mb-1" style="font-size: 0.8rem; font-weight: 700; color: #555;">Frontend UI:</div>
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">HTML/CSS</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">Bootstrap 5</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">JavaScript</span>
                        </div>

                        <div class="mb-1" style="font-size: 0.8rem; font-weight: 700; color: #555;">Backend &amp; AI / ML:</div>
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">PHP</span>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">MySQL</span>
                            <span class="badge fw-semibold" style="color: #8b5cf6; border: 1px solid #8b5cf6; background-color: rgba(139, 92, 246, 0.1); font-size: 0.75rem; padding: 5px 10px;">Machine Learning</span>
                            <span class="badge fw-semibold" style="color: #8b5cf6; border: 1px solid #8b5cf6; background-color: rgba(139, 92, 246, 0.1); font-size: 0.75rem; padding: 5px 10px;">API Integration</span>
                        </div>

                        <div class="mb-1" style="font-size: 0.8rem; font-weight: 700; color: #555;">Tools &amp; APIs:</div>
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">Git</span>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">GitHub</span>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">REST API</span>
                        </div>
                    </div>

                    <div class="connect-heading">Let's Connect</div>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/in/vanitdantani" target="_blank" rel="noopener noreferrer" class="social-btn linkedin" title="LinkedIn">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <a href="https://github.com/VanitDantani" target="_blank" rel="noopener noreferrer" class="social-btn github" title="GitHub">
                            <i class="fa-brands fa-github"></i>
                        </a>
                        <a href="https://vanitdantaniportfolio.netlify.app/" target="_blank" rel="noopener noreferrer" class="social-btn portfolio" title="Portfolio">
                            <i class="fa-solid fa-globe"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Developer 2: Aman Prajapati (Placed Second) -->
            <div class="col-12 col-lg-6">
                <div class="dev-card" style="animation-delay: 0.3s;">
                    <div class="dev-header-flex">
                        <div class="dev-img-wrapper">
                            <img src="developers_pic/Aman5.png" alt="Prajapati Aman Jayeshbhai"
                                class="dev-img" style="cursor: pointer;" onclick="openImageModal(this.src)"
                                onerror="this.src='images/developers/Aman5.png'">
                        </div>
                        <div class="dev-intro">
                            <h3 class="dev-name">PRAJAPATI AMAN JAYESHBHAI</h3>
                            <div class="dev-role">Full Stack Developer</div>
                            <div class="dev-quote">"Transforming ideas into digital reality through modern web technologies."</div>
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

                        <hr class="my-2 border-secondary" style="opacity: 0.15;">

                        <div class="text-start mt-2">
                            <div style="color: var(--primary-navy); font-size: 0.95rem; font-weight: 800; margin-bottom: 4px;">
                                <i class="fa-solid fa-bullseye me-1 text-danger"></i> Key Contributions:
                            </div>
                            <div style="font-size: 0.9rem; line-height: 1.5; color: #222; font-weight: 500;" class="mb-2 fw-medium">
                                Developed student &amp; admin panels, database architecture, backend logic, UI design, and integrated an AI-powered real-time chat assistant and ML features like outlier detection, clustering, train model.
                            </div>
                            <br>
                            <div style="color: var(--primary-navy); font-size: 0.95rem; font-weight: 800; margin-bottom: 6px;">
                                <i class="fa-solid fa-code me-1 text-primary"></i> Tech Stack I used in this portal:
                            </div>
                            <div class="mb-1" style="font-size: 0.8rem; font-weight: 700; color: #555;">Frontend UI:</div>
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">HTML/CSS</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">Bootstrap 5</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">JS/AJAX</span>
                            </div>

                            <div class="mb-1" style="font-size: 0.8rem; font-weight: 700; color: #555;">Backend &amp; AI / ML:</div>
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                <span class="badge bg-success bg-opacity-10 text-success border border-success fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">PHP</span>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">SQL Database</span>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">Apache URL Rewriting</span>
                                <span class="badge fw-semibold" style="color: #8b5cf6; border: 1px solid #8b5cf6; background-color: rgba(139, 92, 246, 0.1); font-size: 0.75rem; padding: 5px 10px;">API Integration</span>
                                <span class="badge fw-semibold" style="color: #8b5cf6; border: 1px solid #8b5cf6; background-color: rgba(139, 92, 246, 0.1); font-size: 0.75rem; padding: 5px 10px;">Machine Learning</span>
                                <span class="badge fw-semibold" style="color: #8b5cf6; border: 1px solid #8b5cf6; background-color: rgba(139, 92, 246, 0.1); font-size: 0.75rem; padding: 5px 10px;">Clustering &amp; Models</span>
                                <span class="badge fw-semibold" style="color: #8b5cf6; border: 1px solid #8b5cf6; background-color: rgba(139, 92, 246, 0.1); font-size: 0.75rem; padding: 5px 10px;">Outlier Detection</span>
                                <span class="badge fw-semibold" style="color: #8b5cf6; border: 1px solid #8b5cf6; background-color: rgba(139, 92, 246, 0.1); font-size: 0.75rem; padding: 5px 10px;">AI Chat Assistant</span>
                            </div>

                            <div class="mb-1" style="font-size: 0.8rem; font-weight: 700; color: #555;">Tools &amp; APIs:</div>
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">Git &amp; Version Control</span>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger fw-semibold" style="font-size: 0.75rem; padding: 5px 10px;">CI/CD Pipeline</span>
                            </div>
                        </div>
                    </div>

                    <div class="connect-heading">Let's Connect</div>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/in/aman-prajapati-855a8a37b/" target="_blank" rel="noopener noreferrer" class="social-btn linkedin" title="LinkedIn">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <a href="https://github.com/Aman-p02" target="_blank" rel="noopener noreferrer" class="social-btn github" title="GitHub">
                            <i class="fa-brands fa-github"></i>
                        </a>
                        <a href="https://amanprajapati2.vercel.app/" target="_blank" rel="noopener noreferrer" class="social-btn portfolio" title="Portfolio">
                            <i class="fa-solid fa-globe"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer Note with Animated Heart -->
        <div class="text-center mt-5 mb-4">
            <p class="dev-footer-text">
                Crafted with <i class="fa-solid fa-heart text-danger mx-1 heart-anim"></i> for
                <span class="highlight">GEC Modasa</span> <span style="font-size: 0.85rem;">(August 2026)</span>
            </p>
        </div>
    </div>

    <!-- Image Modal (Instagram Style) -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body text-center position-relative p-0">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                        data-bs-dismiss="modal" aria-label="Close"
                        style="z-index: 1055; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));"></button>
                    <img id="modalImage" src="" alt="Developer" class="img-fluid rounded-circle shadow-lg"
                        style="max-height: 85vh; max-width: 85vw; aspect-ratio: 1/1; object-fit: cover; border: 4px solid #fff;">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openImageModal(src) {
        var modalImg = document.getElementById('modalImage');
        if (modalImg) {
            modalImg.src = src;
        }
        var modalEl = document.getElementById('imageModal');
        if (modalEl && typeof bootstrap !== 'undefined') {
            var imageModal = new bootstrap.Modal(modalEl);
            imageModal.show();
        }
    }
</script>

<?php
// Include Footer
include_once __DIR__ . '/includes/footer.php';
?>
