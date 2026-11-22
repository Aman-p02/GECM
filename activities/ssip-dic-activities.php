<?php
/**
 * GEC MODASA - SSIP & DIC ACTIVITIES
 * Student Startup & Innovation Policy (SSIP) and Design Innovation Centre (DIC)
 * Follows GECM Institutional Design System (Matches Mandatory Disclosure & Central Library)
 */
$page_title = "SSIP & DIC Activities | Government Engineering College, Modasa";
$active_page = "ssip_dic_activities";
$root_path = "../";
$extra_css = "css/activities-hub.css";

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/cell_activities_helper.php';

$pdo = getDBConnection();

// Initial active tab (ssip or dic)
$selectedType = strtolower(trim($_GET['type'] ?? 'ssip'));
if (!in_array($selectedType, ['ssip', 'dic', 'all'])) {
    $selectedType = 'ssip';
}

$selectedYear = trim($_GET['year'] ?? 'ALL');

// Fetch SSIP and DIC activities
$allActivities = getCombinedCellActivities(['ssip', 'dic'], $pdo);

// Collect available years
$availableYears = [];
foreach ($allActivities as $act) {
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
    <nav class="act-subnav-bar" aria-label="Initiatives Navigation">
        <div class="act-subnav-wrap">
            <ul class="act-subnav-list" role="tablist">
                <li class="act-subnav-item">
                    <button type="button" class="act-subnav-link <?= ($selectedType === 'ssip') ? 'active is-current' : '' ?>" data-type="ssip" role="tab" aria-selected="<?= ($selectedType === 'ssip') ? 'true' : 'false' ?>" id="tabSsip">
                        <span>SSIP Activities</span>
                    </button>
                </li>
                <li class="act-subnav-item">
                    <button type="button" class="act-subnav-link <?= ($selectedType === 'dic') ? 'active is-current' : '' ?>" data-type="dic" role="tab" aria-selected="<?= ($selectedType === 'dic') ? 'true' : 'false' ?>" id="tabDic">
                        <span>DIC Activities</span>
                    </button>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Page Hero Banner -->
    <header class="act-hero">
        <div class="act-hero-inner act-reveal">
            <span class="act-kicker" id="heroKicker"><?= ($selectedType === 'dic') ? 'DESIGN INNOVATION CENTRE' : 'STUDENT STARTUP &amp; INNOVATION POLICY' ?></span>
            <h1 class="act-heading" id="heroTitle" style="margin-bottom: 0;"><?= ($selectedType === 'dic') ? 'DIC Activities' : 'SSIP Activities' ?></h1>
            <p class="act-lead" id="heroDesc" style="margin-top: 12px;">
                <?= ($selectedType === 'dic') 
                    ? 'Promoting design thinking, rapid 3D prototyping, CAD/CAM fabrication, and frugal engineering solutions for regional industrial challenges.' 
                    : 'Empowering student engineers through innovation bootcamps, prototype grants, patent filing support, and startup mentorship under SSIP 2.0.' ?>
            </p>
        </div>
    </header>

    <!-- Clean Minimalist Filter Bar -->
    <div class="act-toolbar-strip act-reveal">
        <div class="act-toolbar-inner">
            <div class="act-toolbar-filters">
                <!-- Year Custom Dropdown (Navbar-style) -->
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
                    Showing&nbsp;<strong id="countNum"><?= count($allActivities) ?></strong>&nbsp;activities
                </div>
            </div>
        </div>
    </div>

    <!-- Activities Grid Container -->
    <main class="act-container">
        <div class="act-grid" id="activitiesGrid">
            <?php foreach ($allActivities as $act):
                $cat = strtolower(trim($act['category'] ?? 'ssip'));
                $evYear = !empty($act['activity_date']) ? date('Y', strtotime($act['activity_date'])) : '2026';
                $eventDate = !empty($act['activity_date']) ? date('M d, Y', strtotime($act['activity_date'])) : 'Official Initiative';
                $photoSrc = !empty($act['image_url']) 
                    ? ((strpos($act['image_url'], 'http') === 0) ? htmlspecialchars($act['image_url']) : htmlspecialchars($root_path . ltrim($act['image_url'], '/'))) 
                    : ($root_path . 'images/hero_campus_1.jpg');
                $modalId = 'actModal_' . $act['id'];
                $catBadge = ($cat === 'ssip') ? 'SSIP 2.0' : 'DIC Modasa';
            ?>
                <article class="act-card act-reveal" data-type="<?= htmlspecialchars($cat) ?>" data-year="<?= htmlspecialchars($evYear) ?>">
                    <div class="act-card-media" style="cursor: pointer;" onclick="openActModal('<?= $modalId ?>')">
                        <img src="<?= $photoSrc ?>" alt="<?= htmlspecialchars($act['title']) ?>" loading="lazy" onerror="this.src='<?= $root_path ?>images/hero_campus_1.jpg'">
                        <span style="position: absolute; top: 12px; left: 12px; background: rgba(17, 24, 39, 0.85); color: #fff; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 4px; letter-spacing: 0.04em; text-transform: uppercase;">
                            <?= $catBadge ?>
                        </span>
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
                                <i class="far fa-calendar-alt"></i> <?= $eventDate ?> &bull; <strong><?= $catBadge ?></strong>
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
                <h4 class="act-empty-title">No Activities Found</h4>
                <p class="act-empty-desc">No activities match the selected initiative and year filter.</p>
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

    // Dynamic Filter by Type (SSIP vs DIC) and Year
    const subnavLinks = document.querySelectorAll('.act-subnav-link');
    const cards = Array.from(document.querySelectorAll('#activitiesGrid .act-card'));
    const countNum = document.getElementById('countNum');
    const emptyState = document.getElementById('emptyState');
    const heroKicker = document.getElementById('heroKicker');
    const heroTitle = document.getElementById('heroTitle');
    const heroDesc = document.getElementById('heroDesc');

    const yearDropdownWrap = document.getElementById('yearDropdownWrap');
    const yearDropdownTrigger = document.getElementById('yearDropdownTrigger');
    const yearDropdownMenu = document.getElementById('yearDropdownMenu');
    const yearSelectedLabel = document.getElementById('yearSelectedLabel');
    const yearOptions = Array.from(document.querySelectorAll('#yearDropdownMenu .custom-select-option'));

    let currentType = '<?= $selectedType ?>';
    let currentYear = '<?= $selectedYear ?>';

    function filterGrid() {
        let visibleCount = 0;
        cards.forEach(card => {
            const cardType = card.getAttribute('data-type');
            const cardYear = card.getAttribute('data-year');
            const typeMatch = (currentType === 'all' || cardType === currentType);
            const yearMatch = (currentYear === 'ALL' || cardYear === currentYear);

            if (typeMatch && yearMatch) {
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

    function updateHeroContent() {
        if (currentType === 'dic') {
            if (heroKicker) heroKicker.textContent = 'DESIGN INNOVATION CENTRE';
            if (heroTitle) heroTitle.textContent = 'DIC Activities';
            if (heroDesc) heroDesc.textContent = 'Promoting design thinking, rapid 3D prototyping, CAD/CAM fabrication, and frugal engineering solutions for regional industrial challenges.';
        } else {
            if (heroKicker) heroKicker.textContent = 'STUDENT STARTUP & INNOVATION POLICY';
            if (heroTitle) heroTitle.textContent = 'SSIP Activities';
            if (heroDesc) heroDesc.textContent = 'Empowering student engineers through innovation bootcamps, prototype grants, patent filing support, and startup mentorship under SSIP 2.0.';
        }
    }

    // Subnav tabs click listener
    subnavLinks.forEach(link => {
        link.addEventListener('click', () => {
            subnavLinks.forEach(l => {
                l.classList.remove('active', 'is-current');
                l.setAttribute('aria-selected', 'false');
            });
            link.classList.add('active', 'is-current');
            link.setAttribute('aria-selected', 'true');
            currentType = link.getAttribute('data-type');

            updateHeroContent();

            if (history.replaceState) {
                const params = new URLSearchParams(window.location.search);
                params.set('type', currentType);
                if (currentYear !== 'ALL') params.set('year', currentYear);
                else params.delete('year');
                window.history.replaceState({}, '', window.location.pathname + '?' + params.toString());
            }
            filterGrid();
        });
    });

    // Year Dropdown toggle & selection
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
