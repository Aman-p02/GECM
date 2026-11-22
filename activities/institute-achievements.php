<?php
/**
 * GEC MODASA - INSTITUTE ACHIEVEMENTS
 * NBA Accreditations, GSIRF Ratings, AICTE IDEA Lab & Green Campus Accolades
 * Follows GECM Institutional Activities Hub Design System
 */
$page_title = "Institute Achievements | Government Engineering College, Modasa";
$active_page = "institute_achievements";
$root_path = "../";
$extra_css = "css/activities-hub.css";
$extra_js = "js/activities-hub.js";

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/cell_activities_helper.php';

$pdo = getDBConnection();
$selectedYear = trim($_GET['year'] ?? 'ALL');

// Fetch Institute Achievements
$activities = getCellActivities('institute_achievements', $pdo);

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

    <!-- Horizontal Sub-Navbar (Matches Mandatory Disclosure & Central Library) -->
    <nav class="act-subnav-bar" aria-label="Achievements Navigation">
        <div class="act-subnav-wrap">
            <ul class="act-subnav-list">
                <li class="act-subnav-item">
                    <a href="student-achievements.php" class="act-subnav-link" style="text-decoration: none;">
                        <span>Student Achievements</span>
                    </a>
                </li>
                <li class="act-subnav-item">
                    <a href="faculty-achievements.php" class="act-subnav-link" style="text-decoration: none;">
                        <span>Faculty Achievements</span>
                    </a>
                </li>
                <li class="act-subnav-item">
                    <a href="institute-achievements.php" class="act-subnav-link active is-current" style="text-decoration: none;">
                        <span>Institute Achievements</span>
                    </a>
                </li>
                <li class="act-subnav-item">
                    <a href="patents.php" class="act-subnav-link" style="text-decoration: none;">
                        <span>Patents</span>
                    </a>
                </li>
                <li class="act-subnav-item">
                    <a href="technopreneur-club.php" class="act-subnav-link" style="text-decoration: none;">
                        <span>Technopreneur Club</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Page Hero Banner -->
    <header class="act-hero">
        <div class="act-hero-inner act-reveal">
            <span class="act-kicker">INSTITUTIONAL RANKINGS &amp; MILESTONES</span>
            <h1 class="act-heading" style="margin-bottom: 0;">Institute Achievements</h1>
            <p class="act-lead" style="margin-top: 12px;">
                Showcasing institutional accreditations, NBA quality benchmarks, GSIRF ratings, AICTE IDEA Lab milestones, and sustainability recognitions achieved by GEC Modasa.
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
                    Showing&nbsp;<strong id="countNum"><?= count($activities) ?></strong>&nbsp;achievements
                </div>
            </div>
        </div>
    </div>

    <!-- Activities Grid Container -->
    <main class="act-container">
        <div class="act-grid" id="activitiesGrid">
            <?php foreach ($activities as $act):
                $evYear = !empty($act['activity_date']) ? date('Y', strtotime($act['activity_date'])) : '2026';
                $eventDate = !empty($act['activity_date']) ? date('M d, Y', strtotime($act['activity_date'])) : 'Accreditation';
                $images = getActivityImages($act, $root_path);
                $primaryPhoto = !empty($images[0]) ? $images[0] : ($root_path . 'images/hero_campus_1.jpg');
                $modalId = 'actModal_' . $act['id'];
                $sliderId = 'slider_' . $act['id'];
            ?>
                <article class="act-card act-reveal" data-year="<?= htmlspecialchars($evYear) ?>">
                    <div class="act-card-media" style="cursor: pointer;" onclick="openActModal('<?= $modalId ?>')">
                        <img src="<?= htmlspecialchars($primaryPhoto) ?>" alt="<?= htmlspecialchars($act['title']) ?>" loading="lazy" onerror="this.src='<?= $root_path ?>images/hero_campus_1.jpg'">
                        <?php if (count($images) > 1): ?>
                            <span class="act-card-photo-count" title="<?= count($images) ?> Photos">
                                <i class="far fa-images"></i> <?= count($images) ?>
                            </span>
                        <?php endif; ?>
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
                                    <i class="fas fa-external-link-alt"></i> Document
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>

                <!-- Full Detail Modal -->
                <div class="act-modal-backdrop" id="<?= $modalId ?>" role="dialog" aria-modal="true" aria-labelledby="<?= $modalId ?>_title">
                    <div class="act-modal-dialog">
                        <?php if (!empty($images)): ?>
                            <?php if (count($images) === 1): ?>
                                <div class="act-modal-media">
                                    <img src="<?= htmlspecialchars($images[0]) ?>" alt="<?= htmlspecialchars($act['title']) ?>">
                                </div>
                            <?php else: ?>
                                <div class="act-modal-slider-wrap" id="<?= $sliderId ?>" data-slider-id="<?= $sliderId ?>" data-slide-count="<?= count($images) ?>">
                                    <div class="act-modal-slider">
                                        <?php foreach ($images as $idx => $imgUrl): ?>
                                            <div class="act-modal-slide <?= ($idx === 0) ? 'is-active' : '' ?>" data-slide-index="<?= $idx ?>">
                                                <img src="<?= htmlspecialchars($imgUrl) ?>" alt="<?= htmlspecialchars($act['title']) ?> - Photo <?= $idx + 1 ?>" loading="lazy">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <!-- Navigation Arrows -->
                                    <button type="button" class="act-slider-arrow act-slider-prev" onclick="prevActSlide('<?= $sliderId ?>')" aria-label="Previous Photo">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="act-slider-arrow act-slider-next" onclick="nextActSlide('<?= $sliderId ?>')" aria-label="Next Photo">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>

                                    <!-- Counter Badge -->
                                    <div class="act-slider-counter" id="counter_<?= $sliderId ?>">
                                        1 / <?= count($images) ?>
                                    </div>

                                    <!-- Dot Indicators -->
                                    <div class="act-slider-dots">
                                        <?php foreach ($images as $idx => $imgUrl): ?>
                                            <button type="button" class="act-slider-dot <?= ($idx === 0) ? 'is-active' : '' ?>" onclick="goToActSlide('<?= $sliderId ?>', <?= $idx ?>)" aria-label="Go to photo <?= $idx + 1 ?>"></button>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
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
                                    <i class="fas fa-external-link-alt"></i> View Circular / Report
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
                <h4 class="act-empty-title">No Achievements Found</h4>
                <p class="act-empty-desc">No institute achievements found for the selected year.</p>
                <button type="button" class="btn btn-primary" id="emptyResetBtn" style="margin-top: 16px; padding: 8px 22px; font-size: 0.86rem; border-radius: 9999px;">
                    <i class="fas fa-undo"></i> Show All Years
                </button>
            </div>
        </div>
    </main>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const cards = Array.from(document.querySelectorAll('#activitiesGrid .act-card'));
    const countNum = document.getElementById('countNum');
    const emptyState = document.getElementById('emptyState');
    const emptyResetBtn = document.getElementById('emptyResetBtn');

    // Year Dropdown Elements
    const yearTrigger = document.getElementById('yearDropdownTrigger');
    const yearMenu = document.getElementById('yearDropdownMenu');
    const yearValue = document.getElementById('yearSelectedLabel');
    const yearOptions = document.querySelectorAll('#yearDropdownMenu .custom-select-option');

    let currentYear = "<?= htmlspecialchars($selectedYear) ?>";

    function filterCards() {
        let visibleCount = 0;
        cards.forEach(card => {
            const cardYear = card.getAttribute('data-year') || '';
            const matchYear = (currentYear === 'ALL' || cardYear === currentYear);

            if (matchYear) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (countNum) countNum.textContent = visibleCount;
        if (emptyState) {
            emptyState.style.display = (visibleCount === 0) ? 'block' : 'none';
        }
    }

    if (yearTrigger && yearMenu) {
        yearTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = yearMenu.classList.contains('is-open');
            yearMenu.classList.toggle('is-open', !isOpen);
            yearTrigger.setAttribute('aria-expanded', !isOpen);
        });

        yearOptions.forEach(opt => {
            opt.addEventListener('click', (e) => {
                e.stopPropagation();
                currentYear = opt.getAttribute('data-value') || 'ALL';
                yearValue.textContent = opt.textContent.trim();
                yearOptions.forEach(o => o.classList.remove('is-selected'));
                opt.classList.add('is-selected');
                yearMenu.classList.remove('is-open');
                yearTrigger.setAttribute('aria-expanded', 'false');
                filterCards();
            });
        });

        document.addEventListener('click', () => {
            yearMenu.classList.remove('is-open');
            yearTrigger.setAttribute('aria-expanded', 'false');
        });
    }

    if (emptyResetBtn) {
        emptyResetBtn.addEventListener('click', () => {
            currentYear = 'ALL';
            if (yearValue) yearValue.textContent = 'All Years';
            yearOptions.forEach(o => {
                o.classList.toggle('is-selected', o.getAttribute('data-value') === 'ALL');
            });
            filterCards();
        });
    }

    filterCards();
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
