<?php
$page_title = "College Activities & Flagship Events | Government Engineering College, Modasa";
$active_page = "college_activities";
$root_path = "";
$extra_css = "css/activities-hub.css";

require_once __DIR__ . '/includes/db.php';
$pdo = getDBConnection();

$selectedYear = trim($_GET['year'] ?? 'ALL');

$collegeEvents = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("
            SELECT * FROM events 
            WHERE is_active = 1 
            ORDER BY event_date DESC, id DESC
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
            'title' => 'Annual Technical Symposium: TechFest 2025',
            'event_date' => '2025-09-20',
            'image_url' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'description' => 'Flagship inter-college technical symposium featuring 50+ competitions including Roborace, Drone Obstacle Race, Circuit Debugging, Paper Presentation, and Code Clash with massive student participation.',
            'view_url' => '#'
        ],
        [
            'id' => 3,
            'title' => 'Annual Engineering Convocation Ceremony',
            'event_date' => '2024-08-05',
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
            'event_date' => '2025-02-18',
            'image_url' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'description' => 'Annual college sports championship organized by Gymkhana committee featuring cricket, football, volleyball, badminton, table tennis, and track & field tournaments.',
            'view_url' => '#'
        ],
        [
            'id' => 6,
            'title' => 'National Blood Donation & Mega Health Awareness Camp',
            'event_date' => '2024-01-26',
            'image_url' => 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'description' => 'Organized jointly by NSS GEC Modasa unit and Red Cross Society. Faculty members, staff, and over 250 student volunteers donated blood to support community healthcare.',
            'view_url' => '#'
        ]
    ];
}

// Collect available years
$availableYears = [];
foreach ($collegeEvents as $ev) {
    if (!empty($ev['event_date'])) {
        $yr = date('Y', strtotime($ev['event_date']));
        if (!in_array($yr, $availableYears)) {
            $availableYears[] = $yr;
        }
    }
}
rsort($availableYears);

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

    <!-- Minimalist Filter Bar (Year Custom Dropdown) -->
    <div class="act-toolbar-strip">
        <div class="act-toolbar-inner">
            <div class="act-toolbar-filters">
                <!-- Year Custom Dropdown (Navbar-style) -->
                <div class="custom-select-wrap" id="yearDropdownWrap">
                    <button type="button" class="custom-select-trigger" id="yearDropdownTrigger" aria-expanded="false" aria-haspopup="listbox">
                        <span class="custom-select-value" id="yearSelectedLabel"><?= ($selectedYear === 'ALL') ? 'All Years' : $selectedYear ?></span>
                        <i class="fas fa-chevron-down custom-select-arrow"></i>
                    </button>
                    <div class="custom-select-menu" id="yearDropdownMenu" role="listbox" aria-label="Select Year" style="min-width: 140px;">
                        <div class="custom-select-option <?= ($selectedYear === 'ALL') ? 'is-selected' : '' ?>" data-value="ALL" role="option">
                            All Years
                        </div>
                        <?php foreach ($availableYears as $yr): ?>
                            <div class="custom-select-option <?= ($selectedYear == $yr) ? 'is-selected' : '' ?>" data-value="<?= $yr ?>" role="option">
                                <?= $yr ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="act-toolbar-meta">
                <div class="act-count-pill" id="resultsCount">
                    Showing&nbsp;<strong><?= count($collegeEvents) ?></strong>&nbsp;activities
                </div>
            </div>
        </div>
    </div>

    <!-- Activities Grid Container -->
    <main class="act-container">
        <div class="act-grid" id="collegeActivitiesGrid">
            <?php foreach ($collegeEvents as $event):
                $evYear = !empty($event['event_date']) ? date('Y', strtotime($event['event_date'])) : '2026';
                $eventDate = !empty($event['event_date']) ? date('M d, Y', strtotime($event['event_date'])) : 'Annual Flagship';
                $photoSrc = !empty($event['image_url']) ? htmlspecialchars($event['image_url']) : 'images/hero_campus_1.jpg';
                $modalId = 'eventModal_' . $event['id'];
            ?>
                <article class="act-card" data-year="<?= htmlspecialchars($evYear) ?>">
                    <div class="act-card-media">
                        <img src="<?= $photoSrc ?>" alt="<?= htmlspecialchars($event['title']) ?>" loading="lazy" onerror="this.src='images/hero_campus_1.jpg'">
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

            <!-- Empty State Container -->
            <div class="act-empty-state" id="emptyState" style="display: none;">
                <i class="fas fa-calendar-times act-empty-icon"></i>
                <h4 class="act-empty-title">No Activities Found</h4>
                <p class="act-empty-desc">No college activities match the selected year.</p>
                <button type="button" class="btn btn-primary" id="emptyResetBtn" style="margin-top: 16px; padding: 8px 22px; font-size: 0.86rem; border-radius: 9999px;">
                    <i class="fas fa-undo"></i> Show All Activities
                </button>
            </div>
        </div>
    </main>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const yearDropdownWrap = document.getElementById("yearDropdownWrap");
    const yearDropdownTrigger = document.getElementById("yearDropdownTrigger");
    const yearSelectedLabel = document.getElementById("yearSelectedLabel");
    const yearOptions = Array.from(document.querySelectorAll("#yearDropdownMenu .custom-select-option"));

    const emptyResetBtn = document.getElementById("emptyResetBtn");
    const cards = Array.from(document.querySelectorAll("#collegeActivitiesGrid .act-card"));
    const emptyState = document.getElementById("emptyState");
    const resultsCount = document.getElementById("resultsCount");

    let currentYear = "<?= htmlspecialchars($selectedYear) ?>";
    if (!currentYear) currentYear = "ALL";

    // Toggle Dropdown
    yearDropdownTrigger.addEventListener("click", (e) => {
        e.stopPropagation();
        const isOpen = yearDropdownWrap.classList.contains("is-open");
        yearDropdownWrap.classList.toggle("is-open", !isOpen);
        yearDropdownTrigger.setAttribute("aria-expanded", !isOpen ? "true" : "false");
    });

    function closeDropdown() {
        yearDropdownWrap.classList.remove("is-open");
        yearDropdownTrigger.setAttribute("aria-expanded", "false");
    }

    document.addEventListener("click", (e) => {
        if (!yearDropdownWrap.contains(e.target)) {
            closeDropdown();
        }
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            closeDropdown();
        }
    });

    // Handle Year Selection
    yearOptions.forEach(opt => {
        opt.addEventListener("click", () => {
            const val = opt.getAttribute("data-value") || "ALL";
            const labelText = opt.textContent.trim();

            currentYear = val;
            yearSelectedLabel.textContent = labelText;

            yearOptions.forEach(o => o.classList.toggle("is-selected", o === opt));
            closeDropdown();

            filterActivities();
            updateURL();
        });
    });

    function filterActivities() {
        let visibleCount = 0;

        cards.forEach(card => {
            const cardYear = card.getAttribute("data-year") || "";
            const matchesYear = (currentYear === "ALL" || cardYear === currentYear);

            if (matchesYear) {
                card.style.display = "";
                visibleCount++;
            } else {
                card.style.display = "none";
            }
        });

        if (visibleCount === 0) {
            emptyState.style.display = "block";
        } else {
            emptyState.style.display = "none";
        }

        resultsCount.innerHTML = `Showing&nbsp;<strong>${visibleCount}</strong>&nbsp;activit${visibleCount === 1 ? 'y' : 'ies'}`;
    }

    function resetAllFilters() {
        currentYear = "ALL";
        yearSelectedLabel.textContent = "All Years";
        yearOptions.forEach(o => o.classList.toggle("is-selected", o.getAttribute("data-value") === "ALL"));
        closeDropdown();
        filterActivities();
        updateURL();
    }

    if (emptyResetBtn) {
        emptyResetBtn.addEventListener("click", resetAllFilters);
    }

    function updateURL() {
        const params = new URLSearchParams(window.location.search);
        if (currentYear !== "ALL") {
            params.set("year", currentYear);
        } else {
            params.delete("year");
        }
        const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        window.history.replaceState({}, '', newUrl);
    }

    // Initial check
    filterActivities();

    // Auto-open event modal if redirected from Homepage (?event=ID) or hash
    const urlParams = new URLSearchParams(window.location.search);
    const targetEventId = urlParams.get("event");
    if (targetEventId) {
        const targetModalId = "eventModal_" + targetEventId;
        const targetModal = document.getElementById(targetModalId);
        if (targetModal) {
            const cardBtn = document.querySelector(`button[onclick*="${targetModalId}"]`);
            if (cardBtn) {
                cardBtn.closest(".act-card")?.scrollIntoView({ behavior: "smooth", block: "center" });
            }
            setTimeout(() => {
                window.openActModal(targetModalId);
            }, 100);
        }
    } else if (window.location.hash && window.location.hash.startsWith("#eventModal_")) {
        const hashModalId = window.location.hash.substring(1);
        const targetModal = document.getElementById(hashModalId);
        if (targetModal) {
            window.openActModal(hashModalId);
        }
    }
});

// Modal helpers
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

    // Clean URL query param if present
    const url = new URL(window.location.href);
    if (url.searchParams.has("event")) {
        url.searchParams.delete("event");
        window.history.replaceState({}, '', url.pathname + (url.search ? url.search : ''));
    }
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
