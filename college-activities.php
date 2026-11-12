<?php
$page_title = "College Activities & Flagship Events | Government Engineering College, Modasa";
$active_page = "college_activities";
$root_path = "";
$extra_css = "css/activities-hub.css";

require_once __DIR__ . '/includes/db.php';
$pdo = getDBConnection();

$collegeEvents = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("
            SELECT * FROM events 
            WHERE is_active = 1 
            ORDER BY display_order ASC, event_date DESC, id DESC
        ");
        $collegeEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("College Activities Error: " . $e->getMessage());
    }
}

// Fallback college activities if database has few
if (empty($collegeEvents)) {
    $collegeEvents = [
        [
            'id' => 1,
            'title' => 'State Level Hackathon: Innovation Sprint 2026',
            'event_date' => '2026-10-15',
            'image_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'description' => 'A premier 36-hour non-stop innovation hackathon bringing together over 300 engineering innovators across Gujarat to build software and hardware prototypes for Smart Governance, Agritech, and HealthTech.',
            'view_url' => '#'
        ],
        [
            'id' => 2,
            'title' => 'Annual Technical Symposium: TechFest 2026',
            'event_date' => '2026-09-20',
            'image_url' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'description' => 'Flagship inter-college technical symposium featuring 50+ competitions including Roborace, Drone Obstacle Race, Circuit Debugging, Paper Presentation, and Code Clash with massive student participation.',
            'view_url' => '#'
        ],
        [
            'id' => 3,
            'title' => 'Annual Engineering Convocation Ceremony',
            'event_date' => '2026-08-05',
            'image_url' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'description' => 'Graduation ceremony celebrating the passing out batch of engineers. Meritorious rank holders and departmental toppers were awarded gold medals and degree certificates by distinguished guests.',
            'view_url' => '#'
        ],
        [
            'id' => 4,
            'title' => 'Prarambh: Annual Cultural & Youth Festival',
            'event_date' => '2026-03-12',
            'image_url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'description' => 'Vibrant 3-day multi-cultural celebration showcasing musical symphonies, theater, folk dance, fine arts, photography exhibitions, and literary debate competitions across the campus.',
            'view_url' => '#'
        ],
        [
            'id' => 5,
            'title' => 'Annual Campus Athletics & Inter-Department Sports Meet',
            'event_date' => '2026-02-18',
            'image_url' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'description' => 'Annual college sports championship organized by Gymkhana committee featuring cricket, football, volleyball, badminton, table tennis, and track & field tournaments.',
            'view_url' => '#'
        ],
        [
            'id' => 6,
            'title' => 'National Blood Donation & Mega Health Awareness Camp',
            'event_date' => '2026-01-26',
            'image_url' => 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'description' => 'Organized jointly by NSS GEC Modasa unit and Red Cross Society. Faculty members, staff, and over 250 student volunteers donated blood to support community healthcare.',
            'view_url' => '#'
        ]
    ];
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="act-hub-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="act-hero">
        <div class="act-hero-inner">
            <span class="act-kicker">CAMPUS LIFE &amp; FLAGSHIP INITIATIVES</span>
            <h1 class="act-heading" style="margin-bottom: 0;">College Activities &amp; Events</h1>
        </div>
    </header>

    <!-- Activities Grid Container -->
    <main class="act-container" style="margin-top: 40px;">
        <div class="act-grid">
            <?php foreach ($collegeEvents as $event):
                $eventDate = !empty($event['event_date']) ? date('M d, Y', strtotime($event['event_date'])) : 'Annual Flagship';
                $photoSrc = !empty($event['image_url']) ? htmlspecialchars($event['image_url']) : 'images/hero_campus_1.jpg';
                $modalId = 'eventModal_' . $event['id'];
            ?>
                <article class="act-card">
                    <div class="act-card-media">
                        <img src="<?= $photoSrc ?>" alt="<?= htmlspecialchars($event['title']) ?>" loading="lazy" onerror="this.src='images/hero_campus_1.jpg'">
                        <span class="act-dept-badge badge-college">GEC Modasa &bull; Campus</span>
                    </div>

                    <div class="act-card-body">
                        <div class="act-card-date">
                            <i class="far fa-calendar-alt"></i>
                            <span><?= $eventDate ?></span>
                        </div>

                        <h3 class="act-card-title"><?= htmlspecialchars($event['title']) ?></h3>

                        <p class="act-card-desc">
                            <?= nl2br(htmlspecialchars(mb_strimwidth($event['description'] ?? '', 0, 160, '...'))) ?>
                        </p>

                        <div class="act-card-footer">
                            <button type="button" class="act-btn-view" onclick="openActModal('<?= $modalId ?>')">
                                <span>View Details</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                            <?php if (!empty($event['view_url']) && $event['view_url'] !== '#'): ?>
                                <a href="<?= htmlspecialchars($event['view_url']) ?>" target="_blank" rel="noopener noreferrer" class="act-link-ext">
                                    <i class="fas fa-external-link-alt"></i> Details
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>

                <!-- Full Detail Modal -->
                <div class="act-modal-backdrop" id="<?= $modalId ?>" role="dialog" aria-modal="true" aria-labelledby="<?= $modalId ?>_title">
                    <div class="act-modal-dialog">
                        <?php if (!empty($event['image_url'])): ?>
                            <div class="act-modal-media">
                                <img src="<?= $photoSrc ?>" alt="<?= htmlspecialchars($event['title']) ?>">
                            </div>
                        <?php endif; ?>

                        <div class="act-modal-header">
                            <button type="button" class="act-modal-close" onclick="closeActModal('<?= $modalId ?>')" aria-label="Close modal">
                                <i class="fas fa-times"></i>
                            </button>
                            <span class="act-dept-badge badge-college" style="position:static; margin-bottom:8px; display:inline-block;">
                                GEC Modasa &bull; Flagship Campus Event
                            </span>
                            <div class="act-card-date" style="display:block; margin:6px 0;">
                                <i class="far fa-calendar-alt"></i> <?= $eventDate ?>
                            </div>
                            <h2 id="<?= $modalId ?>_title" style="font-size:1.45rem; font-weight:800; color:#111; margin:6px 0 0; line-height:1.3;">
                                <?= htmlspecialchars($event['title']) ?>
                            </h2>
                        </div>

                        <div class="act-modal-body">
                            <?= nl2br(htmlspecialchars($event['description'] ?? 'No detailed description available.')) ?>
                        </div>

                        <div class="act-modal-footer">
                            <?php if (!empty($event['view_url']) && $event['view_url'] !== '#'): ?>
                                <a href="<?= htmlspecialchars($event['view_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="padding:8px 18px; font-size:0.88rem;">
                                    <i class="fas fa-external-link-alt"></i> View Full Notice / Registration
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

