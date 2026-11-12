<?php
$page_title = "Faculty Activities & Professional Development | Government Engineering College, Modasa";
$active_page = "faculty_activities";
$root_path = "";
$extra_css = "css/activities-hub.css";

require_once __DIR__ . '/includes/db.php';
$pdo = getDBConnection();

// Initial sample activities for faculty development
$facultyActivities = [
    [
        'id' => 1,
        'title' => 'AICTE-ATAL Faculty Development Programme on Generative AI & Deep Learning',
        'activity_date' => '2026-09-18',
        'dept_code' => 'CE',
        'image_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'description' => 'One-week national FDP attended by engineering faculty members focusing on LLM architecture, prompt engineering, fine-tuning techniques, and ethical AI in pedagogical practices.',
        'external_url' => '#'
    ],
    [
        'id' => 2,
        'title' => 'Patent Granted: Smart IoT Sensor Node for Precision Agriculture',
        'activity_date' => '2026-07-12',
        'dept_code' => 'IT',
        'image_url' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'description' => 'Faculty members published and granted official intellectual property patent for low-power soil moisture and microclimate telemetry nodes designed at GECM campus labs.',
        'external_url' => '#'
    ],
    [
        'id' => 3,
        'title' => 'International IEEE Conference Paper Presentation on Green Energy Microgrids',
        'activity_date' => '2026-06-25',
        'dept_code' => 'EE',
        'image_url' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'description' => 'Research paper authored by Electrical Engineering faculty presented at IEEE Power & Energy Society Symposium on bi-directional converter control in hybrid solar-wind microgrids.',
        'external_url' => '#'
    ],
    [
        'id' => 4,
        'title' => 'Short Term Training Programme (STTP) on Advanced Finite Element Analysis',
        'activity_date' => '2026-04-14',
        'dept_code' => 'ME',
        'image_url' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'description' => 'Hands-on training using ANSYS Mechanical and structural optimization algorithms conducted for faculty researchers and industry professionals.',
        'external_url' => '#'
    ]
];

require_once __DIR__ . '/includes/header.php';
?>

<div class="act-hub-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="act-hero">
        <div class="act-hero-inner">
            <span class="act-kicker">RESEARCH &amp; ACADEMIC EXCELLENCE</span>
            <h1 class="act-heading">Faculty Activities &amp; Development</h1>
            <p class="act-lead">
                Faculty Development Programmes (FDPs), national and international research publications, intellectual property patents, STTPs, and pedagogical workshops conducted by the professors of Government Engineering College, Modasa.
            </p>

            <!-- Quick stats bar -->
            <div class="act-stats-bar">
                <div class="act-stat-item">
                    <div class="act-stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <div class="act-stat-info">
                        <span class="act-stat-value">120+</span>
                        <span class="act-stat-label">Faculty Members</span>
                    </div>
                </div>
                <div class="act-stat-item">
                    <div class="act-stat-icon"><i class="fas fa-file-contract"></i></div>
                    <div class="act-stat-info">
                        <span class="act-stat-value">50+</span>
                        <span class="act-stat-label">FDPs &amp; STTPs</span>
                    </div>
                </div>
                <div class="act-stat-item">
                    <div class="act-stat-icon"><i class="fas fa-award"></i></div>
                    <div class="act-stat-info">
                        <span class="act-stat-value">Patents</span>
                        <span class="act-stat-label">Research &amp; Innovation</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Activities Grid Container -->
    <main class="act-container" style="margin-top: 40px;">
        <div class="act-grid">
            <?php foreach ($facultyActivities as $act):
                $actDate = !empty($act['activity_date']) ? date('M d, Y', strtotime($act['activity_date'])) : 'Recent';
                $photoSrc = !empty($act['image_url']) ? htmlspecialchars($act['image_url']) : 'images/hero_campus_1.jpg';
                $modalId = 'facModal_' . $act['id'];
                $deptCode = $act['dept_code'] ?? 'GECM';
            ?>
                <article class="act-card">
                    <div class="act-card-media">
                        <img src="<?= $photoSrc ?>" alt="<?= htmlspecialchars($act['title']) ?>" loading="lazy" onerror="this.src='images/hero_campus_1.jpg'">
                        <span class="act-dept-badge badge-<?= strtolower($deptCode) ?>"><?= htmlspecialchars($deptCode) ?> &bull; Faculty</span>
                    </div>

                    <div class="act-card-body">
                        <div class="act-card-date">
                            <i class="far fa-calendar-alt"></i>
                            <span><?= $actDate ?></span>
                        </div>

                        <h3 class="act-card-title"><?= htmlspecialchars($act['title']) ?></h3>

                        <p class="act-card-desc">
                            <?= nl2br(htmlspecialchars(mb_strimwidth($act['description'] ?? '', 0, 160, '...'))) ?>
                        </p>

                        <div class="act-card-footer">
                            <button type="button" class="act-btn-view" onclick="openActModal('<?= $modalId ?>')">
                                <span>View Details</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                            <?php if (!empty($act['external_url']) && $act['external_url'] !== '#'): ?>
                                <a href="<?= htmlspecialchars($act['external_url']) ?>" target="_blank" rel="noopener noreferrer" class="act-link-ext">
                                    <i class="fas fa-external-link-alt"></i> Paper/Report
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>

                <!-- Full Detail Modal -->
                <div class="act-modal-backdrop" id="<?= $modalId ?>" role="dialog" aria-modal="true" aria-labelledby="<?= $modalId ?>_title">
                    <div class="act-modal-dialog">
                        <?php if (!empty($act['image_url'])): ?>
                            <div class="act-modal-media">
                                <img src="<?= $photoSrc ?>" alt="<?= htmlspecialchars($act['title']) ?>">
                            </div>
                        <?php endif; ?>

                        <div class="act-modal-header">
                            <button type="button" class="act-modal-close" onclick="closeActModal('<?= $modalId ?>')" aria-label="Close modal">
                                <i class="fas fa-times"></i>
                            </button>
                            <span class="act-dept-badge badge-<?= strtolower($deptCode) ?>" style="position:static; margin-bottom:8px; display:inline-block;">
                                <?= htmlspecialchars($deptCode) ?> &bull; Faculty Activity
                            </span>
                            <div class="act-card-date" style="display:block; margin:6px 0;">
                                <i class="far fa-calendar-alt"></i> <?= $actDate ?>
                            </div>
                            <h2 id="<?= $modalId ?>_title" style="font-size:1.45rem; font-weight:800; color:#111; margin:6px 0 0; line-height:1.3;">
                                <?= htmlspecialchars($act['title']) ?>
                            </h2>
                        </div>

                        <div class="act-modal-body">
                            <?= nl2br(htmlspecialchars($act['description'] ?? 'No detailed description available.')) ?>
                        </div>

                        <div class="act-modal-footer">
                            <?php if (!empty($act['external_url']) && $act['external_url'] !== '#'): ?>
                                <a href="<?= htmlspecialchars($act['external_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="padding:8px 18px; font-size:0.88rem;">
                                    <i class="fas fa-external-link-alt"></i> View Research Paper / Document
                                </a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-secondary" onclick="closeActModal('<?= $modalId ?>')" style="padding:8px 18px; font-size:0.88rem;">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</div>

<script>
window.openActModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add("is-active");
    document.body.style.overflow = "hidden";
};

window.closeActModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove("is-active");
    document.body.style.overflow = "";
};

document.addEventListener("click", (e) => {
    if (e.target.classList.contains("act-modal-backdrop")) {
        e.target.classList.remove("is-active");
        document.body.style.overflow = "";
    }
});

document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
        document.querySelectorAll(".act-modal-backdrop.is-active").forEach(m => {
            m.classList.remove("is-active");
        });
        document.body.style.overflow = "";
    }
});
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
