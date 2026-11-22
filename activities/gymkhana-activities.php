<?php
/**
 * GEC MODASA - GYMKHANA ACTIVITIES
 * Sports, Athletics, Cultural, and Youth Wellness Events
 * Follows GECM Institutional Activities Hub Design System
 */
$page_title = "Gymkhana Activities | Government Engineering College, Modasa";
$active_page = "gymkhana_activities";
$root_path = "../";
$extra_css = "css/activities-hub.css";

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/cell_activities_helper.php';

$pdo = getDBConnection();
$selectedYear = trim($_GET['year'] ?? 'ALL');

// Fetch Gymkhana activities
$activities = getCellActivities('gymkhana', $pdo);

// Collect available years
$availableYears = [];
foreach ($activities as $act) {
    if (!empty($act['activity_date'])) {
        $yr = date('Y', strtotime($act['activity_date']));
        if (!in_array($yr, $availableYears)) {
            $availableYears[] = $yr;
        }
    }
}
rsort($availableYears);

require_once __DIR__ . '/../includes/header.php';
?>

<div class="act-hub-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="act-hero">
        <div class="act-hero-inner act-reveal">
            <span class="act-kicker">SPORTS, ATHLETICS &amp; WELLNESS</span>
            <h1 class="act-heading" style="margin-bottom: 0;">Gymkhana Activities</h1>
            <p class="act-lead" style="margin-top: 12px;">
                Fostering leadership, athleticism, and teamwork through annual sports tournaments, GTU zonal championships, yoga carnivals, and cultural youth celebrations.
            </p>
        </div>
    </header>

    <!-- Toolbar Strip with Year Filter -->
    <div class="act-toolbar-strip act-reveal">
        <div class="act-toolbar-inner">
            <div class="act-toolbar-filters">
                <!-- Year Custom Dropdown -->
                <div class="custom-select-wrap" id="yearDropdownWrap">
                    <button type="button" class="custom-select-trigger" id="yearDropdownTrigger" aria-expanded="false" aria-haspopup="listbox">
                        <span class="custom-select-value" id="yearSelectedLabel"><?= ($selectedYear === 'ALL') ? 'All Years' : $selectedYear ?></span>
                        <i class="fas fa-chevron-down custom-select-arrow"></i>
                    </button>
                    <div class="custom-select-menu" id="yearDropdownMenu" role="listbox" aria-label="Select Year">
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
                    Showing&nbsp;<strong id="countNum"><?= count($activities) ?></strong>&nbsp;activities
                </div>
            </div>
        </div>
    </div>

    <!-- Activities Grid Container -->
    <main class="act-container">
        <div class="act-grid" id="activitiesGrid">
            <?php foreach ($activities as $act):
                $evYear = !empty($act['activity_date']) ? date('Y', strtotime($act['activity_date'])) : '2026';
                $eventDate = !empty($act['activity_date']) ? date('M d, Y', strtotime($act['activity_date'])) : 'Official Event';
                $photoSrc = !empty($act['image_url']) 
                    ? ((strpos($act['image_url'], 'http') === 0) ? htmlspecialchars($act['image_url']) : htmlspecialchars($root_path . ltrim($act['image_url'], '/'))) 
                    : ($root_path . 'images/hero_campus_1.jpg');
                $modalId = 'actModal_' . $act['id'];
            ?>
                <article class="act-card act-reveal" data-year="<?= htmlspecialchars($evYear) ?>">
                    <div class="act-card-media" style="cursor: pointer;" onclick="openActModal('<?= $modalId ?>')">
                        <img src="<?= $photoSrc ?>" alt="<?= htmlspecialchars($act['title']) ?>" loading="lazy" onerror="this.src='<?= $root_path ?>images/hero_campus_1.jpg'">
                    </div>

                    <div class="act-card-body">
                        <div class="act-card-date">
                            <i class="far fa-calendar-alt"></i>
                            <span><?= $eventDate ?></span>
                        </div>

                        <h3 class="act-card-title" style="cursor: pointer;" onclick="openActModal('<?= $modalId ?>')">
                            <?= htmlspecialchars($act['title']) ?>
                        </h3>

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
                                    <i class="fas fa-external-link-alt"></i> Link
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>

                <!-- Full Detail Modal (Bada Hoke Dikhna Chahiye - Max-width 860px) -->
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
                            <div class="act-card-date" style="display:block; margin:6px 0;">
                                <i class="far fa-calendar-alt"></i> <?= $eventDate ?>
                            </div>
                            <h2 id="<?= $modalId ?>_title" style="font-size:1.6rem; font-weight:800; color:#111; margin:6px 0 0; line-height:1.25;">
                                <?= htmlspecialchars($act['title']) ?>
                            </h2>
                        </div>

                        <div class="act-modal-body" style="font-size:1.02rem; line-height:1.75; color:#334155;">
                            <?= nl2br(htmlspecialchars($act['description'] ?? 'No detailed description available.')) ?>
                        </div>

                        <div class="act-modal-footer">
                            <?php if (!empty($act['external_url']) && $act['external_url'] !== '#'): ?>
                                <a href="<?= htmlspecialchars($act['external_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="padding:10px 22px; font-size:0.90rem; background:#ff8800; border-color:#ff8800; color:#fff;">
                                    <i class="fas fa-external-link-alt"></i> View Circular / Fixtures
                                </a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-secondary" onclick="closeActModal('<?= $modalId ?>')" style="padding:10px 22px; font-size:0.90rem;">
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
                <p class="act-empty-desc">No gymkhana activities match the selected year filter.</p>
                <button type="button" class="btn btn-primary" id="emptyResetBtn" style="margin-top: 16px; padding: 8px 22px; font-size: 0.86rem; border-radius: 9999px;">
                    <i class="fas fa-undo"></i> Show All Activities
                </button>
            </div>
        </div>
    </main>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // Scroll Reveal Entrance Animation System
    const revealSelectors = [
        '.act-card',
        '.act-toolbar-strip',
        '.act-hero-inner'
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
            if (el.classList.contains('act-card') && el.style.display === 'none') return;
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

    // Dynamic Filter by Year
    const cards = Array.from(document.querySelectorAll('#activitiesGrid .act-card'));
    const countNum = document.getElementById('countNum');
    const emptyState = document.getElementById('emptyState');
    const yearDropdownWrap = document.getElementById('yearDropdownWrap');
    const yearDropdownTrigger = document.getElementById('yearDropdownTrigger');
    const yearDropdownMenu = document.getElementById('yearDropdownMenu');
    const yearSelectedLabel = document.getElementById('yearSelectedLabel');
    const yearOptions = Array.from(document.querySelectorAll('#yearDropdownMenu .custom-select-option'));

    let currentYear = '<?= $selectedYear ?>';

    function filterGrid() {
        let visibleCount = 0;
        cards.forEach(card => {
            const cardYear = card.getAttribute('data-year');
            const yearMatch = (currentYear === 'ALL' || cardYear === currentYear);

            if (yearMatch) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (countNum) countNum.textContent = visibleCount;
        if (emptyState) emptyState.style.display = (visibleCount === 0) ? 'block' : 'none';

        setupRevealElements(document);
    }

    // Year Dropdown logic
    if (yearDropdownTrigger && yearDropdownWrap && yearDropdownMenu) {
        yearDropdownTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            yearDropdownWrap.classList.toggle('is-open');
        });

        yearOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                e.stopPropagation();
                currentYear = option.getAttribute('data-value') || 'ALL';
                yearSelectedLabel.textContent = option.textContent.trim();
                yearOptions.forEach(opt => opt.classList.remove('is-selected'));
                option.classList.add('is-selected');
                yearDropdownWrap.classList.remove('is-open');
                filterGrid();
            });
        });

        document.addEventListener('click', (e) => {
            if (!yearDropdownWrap.contains(e.target)) {
                yearDropdownWrap.classList.remove('is-open');
            }
        });
    }

    // Reset button
    const emptyResetBtn = document.getElementById('emptyResetBtn');
    if (emptyResetBtn) {
        emptyResetBtn.addEventListener('click', () => {
            currentYear = 'ALL';
            if (yearSelectedLabel) yearSelectedLabel.textContent = 'All Years';
            yearOptions.forEach(opt => opt.classList.toggle('is-selected', opt.getAttribute('data-value') === 'ALL'));
            filterGrid();
        });
    }

    // Initial run
    filterGrid();
});

// Modal helpers with complete background scroll lock
function lockScroll() {
    document.documentElement.classList.add("act-modal-open");
    document.body.classList.add("act-modal-open");
    document.documentElement.style.overflow = "hidden";
    document.body.style.overflow = "hidden";
}

function unlockScroll() {
    document.documentElement.classList.remove("act-modal-open");
    document.body.classList.remove("act-modal-open");
    document.documentElement.style.overflow = "";
    document.body.style.overflow = "";
}

window.openActModal = function(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('is-active', 'is-open');
    lockScroll();
};

window.closeActModal = function(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.remove('is-active', 'is-open');
    unlockScroll();
};

document.addEventListener('click', (e) => {
    if (e.target.classList.contains('act-modal-backdrop')) {
        e.target.classList.remove('is-active', 'is-open');
        unlockScroll();
    }
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.act-modal-backdrop.is-active, .act-modal-backdrop.is-open').forEach(m => {
            m.classList.remove('is-active', 'is-open');
        });
        unlockScroll();
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
