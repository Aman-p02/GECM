<?php
/**
 * GEC MODASA - TECHNOPRENEUR CLUB
 * Student Technical & Entrepreneurship Club
 * Features Two Tabs: "About Club" & "Activities" (similar to Mandatory Disclosure / SSIP)
 * Follows GECM Institutional Activities Hub Design System & synced with Admin Panel
 */
$page_title = "Technopreneur Club | Government Engineering College, Modasa";
$active_page = "technopreneur_club";
$root_path = "../";
$extra_css = "css/activities-hub.css";
$extra_js = "js/activities-hub.js";

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/cell_activities_helper.php';

$pdo = getDBConnection();
if ($pdo) {
    initCellActivitiesTable($pdo);
}

$selectedTab = strtolower(trim($_GET['tab'] ?? 'about'));
if (!in_array($selectedTab, ['about', 'activities'])) {
    $selectedTab = 'about';
}

$selectedYear = trim($_GET['year'] ?? 'ALL');

// Fetch Technopreneur Club activities
$activities = getCellActivities('technopreneur_club', $pdo);

// Fetch Technopreneur Club Team & Mentors (dynamically from DB with fallback)
$convenerList = getTechnopreneurTeam('convener', $pdo);
$convener = !empty($convenerList) ? $convenerList[0] : [
    'name' => 'Dr. H. R. Patel',
    'designation_or_role' => 'Assistant Professor',
    'department' => 'Information Technology Department'
];
$facultyCoordinators = getTechnopreneurTeam('faculty_coordinator', $pdo);
$studentLeadership = getTechnopreneurTeam('student_leadership', $pdo);
$advisoryBoard = getTechnopreneurTeam('advisory_board', $pdo);

// Fail-safe fallbacks if DB returns empty
if (empty($facultyCoordinators)) {
    $allFallback = getTechnopreneurTeamFallbackData();
    $facultyCoordinators = array_values(array_filter($allFallback, function($m) {
        return ($m['group_type'] === 'faculty_coordinator');
    }));
}
if (empty($studentLeadership)) {
    $allFallback = getTechnopreneurTeamFallbackData();
    $studentLeadership = array_values(array_filter($allFallback, function($m) {
        return ($m['group_type'] === 'student_leadership');
    }));
}
if (empty($advisoryBoard)) {
    $allFallback = getTechnopreneurTeamFallbackData();
    $advisoryBoard = array_values(array_filter($allFallback, function($m) {
        return ($m['group_type'] === 'advisory_board');
    }));
}

// Group faculty coordinators by department while preserving order
$facultyByDept = [];
foreach ($facultyCoordinators as $fac) {
    $dept = !empty($fac['department']) ? trim($fac['department']) : 'Faculty Coordinators';
    if (!isset($facultyByDept[$dept])) {
        $facultyByDept[$dept] = [];
    }
    $facultyByDept[$dept][] = $fac;
}

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

    <!-- Top Horizontal Sub-Navbar (Matches Mandatory Disclosure & SSIP) -->
    <nav class="act-subnav-bar" aria-label="Technopreneur Club Navigation">
        <div class="act-subnav-wrap">
            <ul class="act-subnav-list" role="tablist">
                <li class="act-subnav-item">
                    <button type="button" 
                            class="act-subnav-link <?= ($selectedTab === 'about') ? 'active is-current' : '' ?>" 
                            data-tab="about" 
                            role="tab" 
                            aria-selected="<?= ($selectedTab === 'about') ? 'true' : 'false' ?>" 
                            id="tabAboutClub">
                        <i class="fas fa-circle-info"></i>
                        <span>About Club</span>
                    </button>
                </li>
                <li class="act-subnav-item">
                    <button type="button" 
                            class="act-subnav-link <?= ($selectedTab === 'activities') ? 'active is-current' : '' ?>" 
                            data-tab="activities" 
                            role="tab" 
                            aria-selected="<?= ($selectedTab === 'activities') ? 'true' : 'false' ?>" 
                            id="tabActivities">
                        <i class="fas fa-calendar-check"></i>
                        <span>Activities</span>
                    </button>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Page Hero Banner -->
    <header class="act-hero">
        <div class="act-hero-inner act-reveal">
            <span class="act-kicker" id="heroKicker">
                <?= ($selectedTab === 'activities') ? 'STUDENT STARTUP &amp; VENTURE INITIATIVES' : 'STUDENT INNOVATION &amp; STARTUP ECOSYSTEM' ?>
            </span>
            <h1 class="act-heading" id="heroHeading" style="margin-bottom: 0;">
                <?= ($selectedTab === 'activities') ? 'Technopreneur Club Activities' : 'Technopreneur Club' ?>
            </h1>
            <p class="act-lead" id="heroLead" style="margin-top: 12px;">
                <?= ($selectedTab === 'activities') 
                    ? 'Official portfolio of technical hackathons, venture pitch competitions, innovation bootcamps, and founder masterclasses organized by Technopreneur Club, GEC Modasa.' 
                    : 'Fostering entrepreneurial mindsets, technical innovation, venture pitch competitions, and alumni founder mentorship sprints for aspiring engineers at GEC Modasa.' ?>
            </p>
        </div>
    </header>

    <!-- =========================================================================
         TAB 1: ABOUT CLUB PANEL
         ========================================================================= -->
    <section id="panelAboutClub" class="club-tab-panel <?= ($selectedTab === 'about') ? 'is-active' : '' ?>">
        <div class="act-container" style="margin-top: 24px;">
            
            <!-- Tagline Pill & Intro -->
            <div class="club-tagline-box">
                <div class="club-tagline-badge">
                    <i class="fas fa-sparkles"></i> OFFICIAL MOTTO
                </div>
                <div class="club-tagline-text">Innovate &bull; Inspire &bull; Lead</div>
                <div class="club-tagline-sub">Government Engineering College, Modasa</div>
            </div>

            <!-- About the Club Narrative (5 Official Paragraphs) -->
            <div class="club-narrative-card">
                <div class="club-section-title-wrap">
                    <span class="club-section-kicker">OVERVIEW &amp; PHILOSOPHY</span>
                    <h2 class="club-section-heading">About the Club</h2>
                    <div class="club-title-line"></div>
                </div>

                <div class="club-narrative-body">
                    <p>The <strong>Technopreneur Club</strong> at Government Engineering College, Modasa, is a premier student-led initiative that unites talented individuals from all academic departments under one collaborative platform.</p>
                    <p>The term <strong>&ldquo;Technopreneur&rdquo;</strong> is a fusion of <strong>&ldquo;Technology&rdquo;</strong> and <strong>&ldquo;Entrepreneur&rdquo;</strong>, reflecting the club&rsquo;s core philosophy of nurturing technically skilled individuals with an entrepreneurial mindset.</p>
                    <p>Evolving from its origins in the Computer Engineering and Information Technology departments, the club has grown into a multidisciplinary ecosystem where innovation, leadership, and learning thrive together.</p>
                    <p>What sets the Technopreneur Club apart is its strong sense of community&mdash;functioning not just as a team, but as a family&mdash;where students and faculty work hand in hand to support, inspire, and elevate one another.</p>
                    <p>With a focus on holistic development, the club actively cultivates technical expertise, creative thinking, and essential soft skills. Guided by dedicated mentors and driven by student passion, the club transforms ideas into action and challenges into opportunities.</p>
                </div>
            </div>

            <!-- Team Details Section -->
            <div class="club-team-section">
                <div class="club-section-title-wrap">
                    <span class="club-section-kicker">GOVERNANCE &amp; COMMITTEE</span>
                    <h2 class="club-section-heading">Team Details</h2>
                    <div class="club-title-line"></div>
                </div>

                <!-- 1. Convener Featured Card -->
                <div class="convener-featured-card">
                    <div class="convener-badge-top">
                        <i class="fas fa-award"></i> Club Convener
                    </div>
                    <div class="convener-card-inner">
                        <div class="convener-avatar">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="convener-info">
                            <h3 class="convener-name"><?= htmlspecialchars($convener['name'] ?? 'Dr. H. R. Patel') ?></h3>
                            <p class="convener-role">
                                <span class="role-highlight"><?= htmlspecialchars($convener['designation_or_role'] ?? 'Assistant Professor') ?></span>
                                <?php if (!empty($convener['department'])): ?>
                                    &ndash; <span class="dept-text"><?= htmlspecialchars($convener['department']) ?></span>
                                <?php endif; ?>
                            </p>
                            <p class="convener-meta">Government Engineering College, Modasa</p>
                        </div>
                    </div>
                </div>

                <!-- 2. Faculty Coordinators Grouped by Department -->
                <div class="team-subgroup-wrap">
                    <div class="team-subgroup-header">
                        <h3 class="team-subgroup-title">
                            <i class="fas fa-chalkboard-user"></i> Faculty Coordinators
                        </h3>
                        <span class="team-count-pill"><?= count($facultyCoordinators) ?> Faculty Mentors</span>
                    </div>

                    <div class="faculty-dept-grid">
                        <?php foreach ($facultyByDept as $deptName => $facultyList): ?>
                            <div class="faculty-dept-card">
                                <div class="dept-card-header">
                                    <div class="dept-card-icon"><i class="fas fa-graduation-cap"></i></div>
                                    <h4 class="dept-card-title"><?= htmlspecialchars($deptName) ?></h4>
                                </div>
                                <ul class="dept-faculty-list">
                                    <?php foreach ($facultyList as $fac): ?>
                                        <li class="dept-faculty-item">
                                            <i class="fas fa-user-check"></i>
                                            <span class="faculty-item-name"><?= htmlspecialchars($fac['name']) ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 3. Student Leadership -->
                <div class="team-subgroup-wrap">
                    <div class="team-subgroup-header">
                        <h3 class="team-subgroup-title">
                            <i class="fas fa-users-gear"></i> Student Leadership
                        </h3>
                        <span class="team-count-pill"><?= count($studentLeadership) ?> Office Bearers</span>
                    </div>

                    <div class="student-leadership-grid">
                        <?php foreach ($studentLeadership as $leader): 
                            $role = trim($leader['designation_or_role'] ?? 'Leader');
                            $isPresident = (stripos($role, 'President') !== false && stripos($role, 'Vice') === false);
                            $isVP = (stripos($role, 'Vice') !== false);
                            $badgeClass = $isPresident ? 'badge-president' : ($isVP ? 'badge-vp' : 'badge-secretary');
                        ?>
                            <div class="student-leader-card">
                                <div class="leader-role-badge <?= $badgeClass ?>">
                                    <?= htmlspecialchars($role) ?>
                                </div>
                                <div class="leader-avatar">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <h4 class="leader-name"><?= htmlspecialchars($leader['name']) ?></h4>
                                <p class="leader-dept"><?= htmlspecialchars($leader['department'] ?? 'GEC Modasa') ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 4. Advisory Board -->
                <div class="team-subgroup-wrap">
                    <div class="team-subgroup-header">
                        <h3 class="team-subgroup-title">
                            <i class="fas fa-handshake-angle"></i> Advisory Board
                        </h3>
                        <span class="team-count-pill"><?= count($advisoryBoard) ?> Student Advisors</span>
                    </div>

                    <div class="advisory-board-grid">
                        <?php foreach ($advisoryBoard as $adv): ?>
                            <div class="advisory-member-card">
                                <div class="advisory-avatar">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="advisory-content">
                                    <h4 class="advisory-name"><?= htmlspecialchars($adv['name']) ?></h4>
                                    <p class="advisory-dept"><?= htmlspecialchars($adv['department'] ?? 'GEC Modasa') ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- 5. Contact Details Card -->
                <div class="team-subgroup-wrap">
                    <div class="club-contact-card">
                        <div class="contact-card-header">
                            <div class="contact-header-icon"><i class="fas fa-paper-plane"></i></div>
                            <div>
                                <h3 class="contact-card-title">Contact Details &amp; Connect With Us</h3>
                                <p class="contact-card-sub">Reach out to the Technopreneur Club for student partnerships, event collaborations, or mentorship.</p>
                            </div>
                        </div>

                        <div class="contact-channels-grid">
                            <a href="mailto:technopreneur267@gmail.com" class="contact-channel-item channel-email">
                                <div class="channel-icon"><i class="fas fa-envelope"></i></div>
                                <div class="channel-text">
                                    <span class="channel-label">Email</span>
                                    <span class="channel-value">technopreneur267@gmail.com</span>
                                </div>
                            </a>

                            <a href="https://instagram.com/the._.technopreneur" target="_blank" rel="noopener noreferrer" class="contact-channel-item channel-instagram">
                                <div class="channel-icon"><i class="fab fa-instagram"></i></div>
                                <div class="channel-text">
                                    <span class="channel-label">Instagram</span>
                                    <span class="channel-value">the._.technopreneur</span>
                                </div>
                            </a>

                            <a href="https://www.youtube.com/@technopreneurclub" target="_blank" rel="noopener noreferrer" class="contact-channel-item channel-youtube">
                                <div class="channel-icon"><i class="fab fa-youtube"></i></div>
                                <div class="channel-text">
                                    <span class="channel-label">YouTube</span>
                                    <span class="channel-value">Technopreneur Club</span>
                                </div>
                            </a>

                            <a href="https://www.linkedin.com/company/technopreneur-club" target="_blank" rel="noopener noreferrer" class="contact-channel-item channel-linkedin">
                                <div class="channel-icon"><i class="fab fa-linkedin-in"></i></div>
                                <div class="channel-text">
                                    <span class="channel-label">LinkedIn</span>
                                    <span class="channel-value">Technopreneur Club</span>
                                </div>
                            </a>

                            <a href="https://www.facebook.com/technopreneurclub" target="_blank" rel="noopener noreferrer" class="contact-channel-item channel-facebook">
                                <div class="channel-icon"><i class="fab fa-facebook-f"></i></div>
                                <div class="channel-text">
                                    <span class="channel-label">Facebook</span>
                                    <span class="channel-value">Technopreneur Club</span>
                                </div>
                            </a>

                            <a href="https://x.com/technopreneur_1" target="_blank" rel="noopener noreferrer" class="contact-channel-item channel-x">
                                <div class="channel-icon"><i class="fab fa-x-twitter"></i></div>
                                <div class="channel-text">
                                    <span class="channel-label">X (Twitter)</span>
                                    <span class="channel-value">technopreneur_1</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- =========================================================================
         TAB 2: ACTIVITIES PANEL (Identical to RUSA / SSIP Activities)
         ========================================================================= -->
    <section id="panelActivities" class="club-tab-panel <?= ($selectedTab === 'activities') ? 'is-active' : '' ?>">
        
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
                    $eventDate = !empty($act['activity_date']) ? date('M d, Y', strtotime($act['activity_date'])) : 'Club Activity';
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
                                        <i class="fas fa-external-link-alt"></i> Club Page
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>

                    <!-- Full Detail Modal (Hardware Accelerated Carousel Slider) -->
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
                                                <button type="button" class="act-slider-dot <?= ($idx === 0) ? 'is-active' : '' ?>" onclick="goToActSlide('<?= $sliderId ?>', <?= $idx ?>)" aria-label="Slide <?= $idx + 1 ?>"></button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="act-modal-content">
                                <div class="act-modal-header">
                                    <div class="act-modal-date">
                                        <i class="far fa-calendar-alt"></i>
                                        <span><?= $eventDate ?></span>
                                    </div>
                                    <button type="button" class="act-modal-close" onclick="closeActModal('<?= $modalId ?>')" aria-label="Close modal">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                                <h2 class="act-modal-title" id="<?= $modalId ?>_title">
                                    <?= htmlspecialchars($act['title']) ?>
                                </h2>

                                <div class="act-modal-body">
                                    <p><?= nl2br(htmlspecialchars($act['description'] ?? '')) ?></p>
                                </div>

                                <?php if (!empty($act['external_url']) && $act['external_url'] !== '#'): ?>
                                    <div class="act-modal-footer">
                                        <a href="<?= htmlspecialchars($act['external_url']) ?>" target="_blank" rel="noopener noreferrer" class="act-btn-ext">
                                            <span>Visit Official Link</span>
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Empty State Container -->
                <div class="act-empty-state" id="emptyState" style="display: none;">
                    <i class="fas fa-calendar-times act-empty-icon"></i>
                    <h4 class="act-empty-title">No Club Activities Found</h4>
                    <p class="act-empty-desc">No activities found for the selected year.</p>
                    <button type="button" class="btn btn-primary" id="emptyResetBtn" style="margin-top: 16px; padding: 8px 22px; font-size: 0.86rem; border-radius: 9999px;">
                        <i class="fas fa-undo"></i> Show All Years
                    </button>
                </div>
            </div>
        </main>
    </section>

</div>

<!-- Stylesheet for About Club & Tab Switching -->
<style>
/* Tab Panels */
.club-tab-panel {
    display: none;
    opacity: 0;
    transition: opacity 0.25s ease;
}

.club-tab-panel.is-active {
    display: block;
    opacity: 1;
}

/* Overview Cards */
.club-overview-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}

@media (max-width: 768px) {
    .club-overview-grid {
        grid-template-columns: 1fr;
    }
}

.club-overview-card {
    background: #ffffff;
    border: 1px solid #eef2f6;
    border-radius: 14px;
    padding: 32px 28px;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.club-overview-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.07);
}

.card-icon-pill {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin-bottom: 20px;
}

.icon-orange { background: #fff7ed; color: #ea580c; }
.icon-blue { background: #eff6ff; color: #2563eb; }

.card-title {
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 1.3rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 12px;
}

.card-text {
    font-size: 0.96rem;
    color: #475569;
    line-height: 1.68;
    margin: 0;
}

/* Pillars Section */
.section-header-wrap {
    margin-bottom: 24px;
}

.section-kicker {
    display: inline-block;
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: #ff8800;
    margin-bottom: 8px;
}

.section-heading {
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: clamp(1.6rem, 2.8vw, 2.2rem);
    font-weight: 800;
    color: #0f172a;
    line-height: 1.2;
    margin: 0 0 10px;
}

.section-desc {
    font-size: 1rem;
    color: #475569;
    line-height: 1.6;
    margin: 0;
    max-width: 820px;
}

/* Technopreneur Club Dedicated Custom Styles */
#panelAboutClub,
#panelAboutClub .club-tagline-box,
#panelAboutClub .club-narrative-card,
#panelAboutClub .club-team-section,
#panelAboutClub .convener-featured-card,
#panelAboutClub .team-subgroup-wrap,
#panelAboutClub .faculty-dept-card,
#panelAboutClub .student-leader-card,
#panelAboutClub .advisory-member-card,
#panelAboutClub .club-contact-card {
    opacity: 1 !important;
    visibility: visible !important;
    display: block !important;
    transform: none !important;
}

#panelAboutClub .faculty-dept-grid {
    display: grid !important;
}

#panelAboutClub .student-leadership-grid {
    display: grid !important;
}

#panelAboutClub .advisory-board-grid {
    display: grid !important;
}

#panelAboutClub .contact-channels-grid {
    display: grid !important;
}

#panelAboutClub .convener-card-inner {
    display: flex !important;
}

.club-tagline-box {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    border-radius: 14px;
    padding: 26px 28px;
    color: #ffffff;
    text-align: center;
    position: relative;
    overflow: hidden;
    margin-bottom: 28px;
    box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.club-tagline-box::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 260px;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 136, 0, 0.18) 0%, transparent 70%);
    pointer-events: none;
}

.club-tagline-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255, 136, 0, 0.2);
    border: 1px solid rgba(255, 136, 0, 0.4);
    color: #ff9d2e;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    padding: 4px 12px;
    border-radius: 9999px;
    margin-bottom: 10px;
    text-transform: uppercase;
}

.club-tagline-text {
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: clamp(1.4rem, 2.5vw, 1.85rem);
    font-weight: 800;
    letter-spacing: 0.04em;
    color: #ffffff;
    margin-bottom: 6px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.club-tagline-sub {
    font-size: 0.92rem;
    color: #94a3b8;
    font-weight: 500;
}

/* Narrative Card */
.club-narrative-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 32px 36px;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    margin-bottom: 36px;
}

.club-section-title-wrap {
    margin-bottom: 22px;
}

.club-section-kicker {
    display: inline-block;
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 0.76rem;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: #ff8800;
    margin-bottom: 6px;
}

.club-section-heading {
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: clamp(1.5rem, 2.5vw, 1.95rem);
    font-weight: 800;
    color: #0f172a;
    line-height: 1.25;
    margin: 0 0 10px;
}

.club-title-line {
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #ff8800, #ffb366);
    border-radius: 2px;
}

.club-narrative-body p {
    font-size: 0.98rem;
    line-height: 1.75;
    color: #334155;
    margin: 0 0 16px;
}

.club-narrative-body p:last-child {
    margin-bottom: 0;
}

/* Team Details & Subgroups */
.club-team-section {
    margin-top: 10px;
}

.team-subgroup-wrap {
    margin-bottom: 34px;
}

.team-subgroup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
    border-bottom: 2px solid #f1f5f9;
    padding-bottom: 10px;
    flex-wrap: wrap;
    gap: 10px;
}

.team-subgroup-title {
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 1.22rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.team-subgroup-title i {
    color: #ff8800;
}

.team-count-pill {
    background: #f1f5f9;
    color: #475569;
    font-size: 0.78rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 9999px;
    border: 1px solid #e2e8f0;
}

/* Convener Featured Card */
.convener-featured-card {
    background: linear-gradient(135deg, #ffffff 0%, #fff8f1 100%);
    border: 1.5px solid #ffedd5;
    border-radius: 14px;
    padding: 24px 28px;
    position: relative;
    box-shadow: 0 6px 20px rgba(255, 136, 0, 0.08);
    margin-bottom: 32px;
}

.convener-badge-top {
    position: absolute;
    top: 14px;
    right: 20px;
    background: #ff8800;
    color: #ffffff;
    font-size: 0.74rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    padding: 4px 10px;
    border-radius: 6px;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.convener-card-inner {
    display: flex;
    align-items: center;
    gap: 20px;
}

.convener-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ff8800 0%, #ea580c 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.7rem;
    box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);
    flex-shrink: 0;
}

.convener-info {
    flex: 1;
}

.convener-name {
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 1.35rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px;
}

.convener-role {
    font-size: 0.94rem;
    color: #334155;
    margin: 0 0 4px;
}

.role-highlight {
    font-weight: 700;
    color: #ea580c;
}

.dept-text {
    font-weight: 600;
    color: #475569;
}

.convener-meta {
    font-size: 0.82rem;
    color: #64748b;
    margin: 0;
}

/* Faculty Coordinators Dept Grid */
.faculty-dept-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 18px;
}

.faculty-dept-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.faculty-dept-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06);
    border-color: #cbd5e1;
}

.dept-card-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.dept-card-icon {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    background: #e2e8f0;
    color: #0369a1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
}

.dept-card-title {
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 0.94rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    line-height: 1.3;
}

.dept-faculty-list {
    list-style: none;
    margin: 0;
    padding: 12px 16px;
}

.dept-faculty-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 0;
    font-size: 0.90rem;
    color: #334155;
    border-bottom: 1px dashed #f1f5f9;
}

.dept-faculty-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.dept-faculty-item i {
    color: #10b981;
    font-size: 0.82rem;
}

.faculty-item-name {
    font-weight: 600;
}

/* Student Leadership Grid */
.student-leadership-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}

@media (max-width: 992px) {
    .student-leadership-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 560px) {
    .student-leadership-grid {
        grid-template-columns: 1fr;
    }
}

.student-leader-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 22px 18px;
    text-align: center;
    position: relative;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.student-leader-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
}

.leader-role-badge {
    display: inline-block;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    padding: 3px 10px;
    border-radius: 9999px;
    margin-bottom: 12px;
}

.badge-president {
    background: #fef3c7;
    color: #b45309;
    border: 1px solid #fde68a;
}

.badge-vp {
    background: #e0f2fe;
    color: #0369a1;
    border: 1px solid #bae6fd;
}

.badge-secretary {
    background: #ede9fe;
    color: #6d28d9;
    border: 1px solid #ddd6fe;
}

.leader-avatar {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    margin-bottom: 12px;
}

.leader-name {
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 1.05rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 4px;
}

.leader-dept {
    font-size: 0.80rem;
    color: #64748b;
    margin: 0;
    font-weight: 500;
}

/* Advisory Board Grid */
.advisory-board-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

@media (max-width: 900px) {
    .advisory-board-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 560px) {
    .advisory-board-grid {
        grid-template-columns: 1fr;
    }
}

.advisory-member-card {
    background: #ffffff;
    border: 1px solid #eef2f6;
    border-radius: 10px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 1px 4px rgba(15, 23, 42, 0.03);
    transition: transform 0.15s ease, border-color 0.15s ease;
}

.advisory-member-card:hover {
    transform: translateY(-2px);
    border-color: #cbd5e1;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
}

.advisory-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #f1f5f9;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.advisory-content {
    flex: 1;
    min-width: 0;
}

.advisory-name {
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 0.92rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.advisory-dept {
    font-size: 0.77rem;
    color: #64748b;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Contact Details Card */
.club-contact-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 28px 32px;
    box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
}

.contact-card-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 24px;
}

.contact-header-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: #ffedd5;
    color: #ea580c;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.contact-card-title {
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 1.22rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 4px;
}

.contact-card-sub {
    font-size: 0.88rem;
    color: #64748b;
    margin: 0;
}

.contact-channels-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}

@media (max-width: 900px) {
    .contact-channels-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 560px) {
    .contact-channels-grid {
        grid-template-columns: 1fr;
    }
}

.contact-channel-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.contact-channel-item:hover {
    background: #ffffff;
    border-color: #cbd5e1;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
}

.contact-channel-item .channel-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.channel-email .channel-icon { background: #fee2e2; color: #dc2626; }
.channel-instagram .channel-icon { background: #fce7f3; color: #db2777; }
.channel-youtube .channel-icon { background: #fee2e2; color: #ef4444; }
.channel-linkedin .channel-icon { background: #e0f2fe; color: #0284c7; }
.channel-facebook .channel-icon { background: #e0e7ff; color: #4f46e5; }
.channel-x .channel-icon { background: #f1f5f9; color: #0f172a; }

.channel-text {
    flex: 1;
    min-width: 0;
}

.channel-label {
    display: block;
    font-size: 0.72rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.channel-value {
    display: block;
    font-size: 0.88rem;
    font-weight: 600;
    color: #0f172a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<!-- Tab Switching & Activities Filter Script -->
<script>
function switchClubTab(targetTab) {
    const tabButtons = document.querySelectorAll('.act-subnav-link');
    const tabPanels = document.querySelectorAll('.club-tab-panel');
    const heroKicker = document.getElementById('heroKicker');
    const heroHeading = document.getElementById('heroHeading');
    const heroLead = document.getElementById('heroLead');

    tabButtons.forEach(btn => {
        const isMatch = btn.getAttribute('data-tab') === targetTab;
        btn.classList.toggle('active', isMatch);
        btn.classList.toggle('is-current', isMatch);
        btn.setAttribute('aria-selected', isMatch ? 'true' : 'false');
    });

    tabPanels.forEach(panel => {
        panel.classList.remove('is-active');
    });

    if (targetTab === 'activities') {
        const pAct = document.getElementById('panelActivities');
        if (pAct) pAct.classList.add('is-active');

        if (heroKicker) heroKicker.textContent = 'STUDENT STARTUP & VENTURE INITIATIVES';
        if (heroHeading) heroHeading.textContent = 'Technopreneur Club Activities';
        if (heroLead) heroLead.textContent = 'Official portfolio of technical hackathons, venture pitch competitions, innovation bootcamps, and founder masterclasses organized by Technopreneur Club, GEC Modasa.';
    } else {
        const pAbout = document.getElementById('panelAboutClub');
        if (pAbout) pAbout.classList.add('is-active');

        if (heroKicker) heroKicker.textContent = 'STUDENT INNOVATION & STARTUP ECOSYSTEM';
        if (heroHeading) heroHeading.textContent = 'Technopreneur Club';
        if (heroLead) heroLead.textContent = 'Fostering entrepreneurial mindsets, technical innovation, venture pitch competitions, and alumni founder mentorship sprints for aspiring engineers at GEC Modasa.';
    }

    // Update URL query parameter without page reload
    if (window.history && window.history.pushState) {
        const newUrl = window.location.pathname + '?tab=' + targetTab;
        window.history.pushState({ tab: targetTab }, '', newUrl);
    }

    // Trigger reveal on visible content
    if (typeof window.setupActReveal === 'function') {
        setTimeout(window.setupActReveal, 50);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    // Tab Clicks
    document.querySelectorAll('.act-subnav-link').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const tab = this.getAttribute('data-tab');
            switchClubTab(tab);
        });
    });

    // Activities Year Filter
    const cards = Array.from(document.querySelectorAll('#activitiesGrid .act-card'));
    const countNum = document.getElementById('countNum');
    const emptyState = document.getElementById('emptyState');
    const emptyResetBtn = document.getElementById('emptyResetBtn');

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
                if (yearValue) yearValue.textContent = opt.textContent.trim();
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
