<?php
require_once __DIR__ . '/includes/db.php';

// Fetch Principal Profile
$profile = null;
$qualifications = [];
$tabItems = [];

if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM principal_profile LIMIT 1");
        $profile = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;

        $stmtQ = $pdo->query("SELECT * FROM principal_qualifications ORDER BY display_order ASC, id ASC");
        $qualifications = $stmtQ ? $stmtQ->fetchAll(PDO::FETCH_ASSOC) : [];

        $stmtT = $pdo->query("SELECT * FROM principal_tab_items ORDER BY display_order ASC, id DESC");
        $allTabs = $stmtT ? $stmtT->fetchAll(PDO::FETCH_ASSOC) : [];
        foreach ($allTabs as $t) {
            $tabItems[$t['tab_name']][] = $t;
        }
    } catch (Throwable $e) {
        error_log("Principal profile load error: " . $e->getMessage());
    }
}

// Fallback values if profile is not set yet
$name = $profile['name'] ?? 'Dr. JEETENDRAKUMAR VADHER';
$designation = $profile['designation'] ?? 'Principal';
$qualification = $profile['qualification'] ?? 'M. Tech. (IIT-Madras), Ph.D. (HNGU-Patan)';
$experience = $profile['experience'] ?? '28 Years';
$date_of_joining = $profile['date_of_joining'] ?? '18-05-2022';
$raw_interests = $profile['area_of_interest'] ?? 'Production, Manufacturing, Industrial Engineering, CAD/CAM, Automation';
$email = $profile['email'] ?? 'jeetendra.vadher@gecmodasa.ac.in';
$website = $profile['website'] ?? 'http://www.gecmodasa.ac.in/';

// Photo URL resolution with existing file check
$photo_url = 'images/avatar_placeholder.svg';
if (!empty($profile['photo_url']) && file_exists(__DIR__ . '/' . ltrim($profile['photo_url'], '/'))) {
    $photo_url = ltrim($profile['photo_url'], '/');
} elseif (file_exists(__DIR__ . '/uploads/principal/principal_1794768679_38c22090.jpeg')) {
    $photo_url = 'uploads/principal/principal_1794768679_38c22090.jpeg';
}

// Parse specialization tags
$interests = array_filter(array_map('trim', explode(',', $raw_interests)));

$page_title = "Principal :: Government Engineering College, Modasa";
$active_page = 'principal';
$extra_css = 'css/principal.css';
require_once __DIR__ . '/includes/header.php';
?>

<div class="pr-page-wrapper">

    <!-- Page Hero Banner -->
    <header class="pr-hero">
        <div class="container pr-container">
            <span class="pr-kicker">INSTITUTIONAL LEADERSHIP</span>
            <h1 class="pr-heading">Principal Profile</h1>
            <p class="pr-subhead">Academic credentials, administrative milestones, and research profile of the Head of the Institute.</p>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="container pr-container">

        <!-- Executive Profile Card -->
        <article class="pr-profile-card" aria-label="Principal Executive Profile">
            
            <!-- Left Portrait Column with Quick Actions -->
            <div class="pr-profile-media">
                <div class="pr-portrait-frame">
                    <img src="<?= htmlspecialchars($photo_url) ?>" 
                         alt="<?= htmlspecialchars($name) ?>" 
                         class="pr-portrait-img" 
                         loading="eager"
                         onerror="this.src='images/avatar_placeholder.svg'">
                </div>

                <div class="pr-media-actions">
                    <!-- Clean URL without .php -->
                    <a href="principal-message" class="pr-cta-desk-btn" title="Read Principal's Official Welcome Message">
                        <i class="fas fa-quote-left" aria-hidden="true"></i>
                        <span>Principal's Message</span>
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>

                    <div class="pr-contact-pills-row">
                        <?php if (!empty($email)): ?>
                            <a href="mailto:<?= htmlspecialchars($email) ?>" class="pr-contact-btn" title="Email: <?= htmlspecialchars($email) ?>">
                                <i class="fas fa-envelope" aria-hidden="true"></i>
                                <span>Email</span>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($website)): ?>
                            <a href="<?= htmlspecialchars($website) ?>" target="_blank" rel="noopener noreferrer" class="pr-contact-btn" title="Visit Official Portal">
                                <i class="fas fa-globe" aria-hidden="true"></i>
                                <span>Website</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Body / Information -->
            <div class="pr-profile-body">
                <div class="pr-badge-strip">
                    <span class="pr-badge-lead">
                        <i class="fas fa-shield-alt" aria-hidden="true"></i> Head of the Institute &bull; Principal
                    </span>
                </div>

                <h2 class="pr-profile-name"><?= htmlspecialchars($name) ?></h2>
                <div class="pr-profile-desig">Principal &amp; Professor in Mechanical Engineering</div>
                <div class="pr-profile-affil">
                    <i class="fas fa-university" aria-hidden="true"></i>
                    <span>Government Engineering College, Modasa (Affiliated to GTU)</span>
                </div>

                <!-- 3 Key Metric Counter Cards -->
                <div class="pr-metrics-grid">
                    
                    <div class="pr-metric-card">
                        <div class="pr-metric-icon pr-icon-blue" aria-hidden="true">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="pr-metric-info">
                            <span class="pr-metric-label">Highest Degree</span>
                            <span class="pr-metric-val">Ph.D. &bull; M.Tech.</span>
                            <span class="pr-metric-sub">IIT Madras &bull; HNGU Patan</span>
                        </div>
                    </div>

                    <div class="pr-metric-card">
                        <div class="pr-metric-icon pr-icon-orange" aria-hidden="true">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="pr-metric-info">
                            <span class="pr-metric-label">Total Experience</span>
                            <span class="pr-metric-val"><?= htmlspecialchars($experience) ?></span>
                            <span class="pr-metric-sub">Academic &amp; Administrative</span>
                        </div>
                    </div>

                    <div class="pr-metric-card">
                        <div class="pr-metric-icon pr-icon-green" aria-hidden="true">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="pr-metric-info">
                            <span class="pr-metric-label">Appointed at GECM</span>
                            <span class="pr-metric-val"><?= htmlspecialchars($date_of_joining) ?></span>
                            <span class="pr-metric-sub">Principal &amp; Institutional Head</span>
                        </div>
                    </div>

                </div>

                <!-- Areas of Specialization & Research -->
                <?php if (!empty($interests)): ?>
                    <div class="pr-spec-wrap">
                        <div class="pr-spec-title">
                            <i class="fas fa-microscope" aria-hidden="true"></i>
                            <span>Areas of Specialization &amp; Research</span>
                        </div>
                        <div class="pr-tags-list">
                            <?php foreach ($interests as $tag): ?>
                                <span class="pr-tag">
                                    <i class="fas fa-check" style="font-size: 0.72rem; color: #009dff;" aria-hidden="true"></i>
                                    <span><?= htmlspecialchars($tag) ?></span>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

        </article>

        <!-- Segmented Tabbed Sections -->
        <section class="pr-tabs-container" aria-label="Academic Records and Professional Profile">
            
            <!-- Modern Horizontal Segmented Tabs Bar -->
            <div class="pr-tabs-bar" role="tablist">
                <button type="button" class="pr-tab-btn active" data-tab="tab-qualifications" role="tab" aria-selected="true" aria-controls="tab-qualifications">
                    <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                    <span>Qualifications</span>
                    <span class="pr-tab-count"><?= count($qualifications) ?></span>
                </button>
                <button type="button" class="pr-tab-btn" data-tab="tab-publications" role="tab" aria-selected="false" aria-controls="tab-publications">
                    <i class="fas fa-file-invoice" aria-hidden="true"></i>
                    <span>Publications</span>
                    <?php if (!empty($tabItems['publications'])): ?>
                        <span class="pr-tab-count"><?= count($tabItems['publications']) ?></span>
                    <?php endif; ?>
                </button>
                <button type="button" class="pr-tab-btn" data-tab="tab-books" role="tab" aria-selected="false" aria-controls="tab-books">
                    <i class="fas fa-book-open" aria-hidden="true"></i>
                    <span>Books</span>
                    <?php if (!empty($tabItems['books'])): ?>
                        <span class="pr-tab-count"><?= count($tabItems['books']) ?></span>
                    <?php endif; ?>
                </button>
                <button type="button" class="pr-tab-btn" data-tab="tab-editorial" role="tab" aria-selected="false" aria-controls="tab-editorial">
                    <i class="fas fa-feather-alt" aria-hidden="true"></i>
                    <span>Editorial</span>
                </button>
                <button type="button" class="pr-tab-btn" data-tab="tab-talks" role="tab" aria-selected="false" aria-controls="tab-talks">
                    <i class="fas fa-microphone-alt" aria-hidden="true"></i>
                    <span>Expert Talks</span>
                </button>
                <button type="button" class="pr-tab-btn" data-tab="tab-workshops" role="tab" aria-selected="false" aria-controls="tab-workshops">
                    <i class="fas fa-chalkboard-teacher" aria-hidden="true"></i>
                    <span>Workshops</span>
                </button>
                <button type="button" class="pr-tab-btn" data-tab="tab-experience" role="tab" aria-selected="false" aria-controls="tab-experience">
                    <i class="fas fa-history" aria-hidden="true"></i>
                    <span>Experience</span>
                </button>
                <button type="button" class="pr-tab-btn" data-tab="tab-extra" role="tab" aria-selected="false" aria-controls="tab-extra">
                    <i class="fas fa-award" aria-hidden="true"></i>
                    <span>Honors &amp; Extra</span>
                </button>
            </div>

            <!-- 1. Qualifications Pane (Educational Milestones Card Timeline) -->
            <div id="tab-qualifications" class="pr-tab-pane active" role="tabpanel">
                <?php if (empty($qualifications)): ?>
                    <div class="pr-empty-box">
                        <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                        <h4 class="pr-empty-title">Educational Milestones</h4>
                        <p class="pr-empty-sub">Academic degrees and qualifications are currently being compiled.</p>
                    </div>
                <?php else: ?>
                    <div class="pr-timeline-list">
                        <?php foreach ($qualifications as $q): ?>
                            <div class="pr-timeline-card">
                                <div class="pr-timeline-left">
                                    <div class="pr-degree-badge-icon" aria-hidden="true">
                                        <i class="fas fa-award"></i>
                                    </div>
                                    <div class="pr-timeline-details">
                                        <h3 class="pr-degree-name"><?= htmlspecialchars($q['qualification']) ?></h3>
                                        <div class="pr-degree-univ">
                                            <i class="fas fa-university" aria-hidden="true"></i>
                                            <span><?= htmlspecialchars($q['university_board'] ?? '--') ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="pr-timeline-right">
                                    <?php if (!empty($q['year_of_passing'])): ?>
                                        <span class="pr-year-pill">
                                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                                            <span><?= htmlspecialchars($q['year_of_passing']) ?></span>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (!empty($q['percentage'])): ?>
                                        <span class="pr-grade-pill">
                                            <i class="fas fa-check-circle" aria-hidden="true"></i>
                                            <span><?= htmlspecialchars($q['percentage']) ?></span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Other Tab Panes -->
            <?php 
            $tabPanesConfig = [
                'tab-publications' => ['key' => 'publications',  'title' => 'Publications & Research Papers', 'icon' => 'fas fa-file-invoice'],
                'tab-books'        => ['key' => 'books',         'title' => 'Published Books & Chapters',     'icon' => 'fas fa-book-open'],
                'tab-editorial'    => ['key' => 'editorial',     'title' => 'Editorial Appointments & Reviews','icon' => 'fas fa-feather-alt'],
                'tab-talks'        => ['key' => 'expert_talks',  'title' => 'Expert Lectures & Keynotes Delivered','icon' => 'fas fa-microphone-alt'],
                'tab-workshops'    => ['key' => 'workshops',     'title' => 'Workshops & Seminars Attended',  'icon' => 'fas fa-chalkboard-teacher'],
                'tab-experience'   => ['key' => 'experience',    'title' => 'Professional & Industrial Experience', 'icon' => 'fas fa-history'],
                'tab-extra'        => ['key' => 'extra',         'title' => 'Awards, Honors & Additional Distinctions', 'icon' => 'fas fa-award']
            ];

            foreach ($tabPanesConfig as $paneId => $cfg):
                $items = $tabItems[$cfg['key']] ?? [];
            ?>
                <div id="<?= $paneId ?>" class="pr-tab-pane" role="tabpanel">
                    <?php if (empty($items)): ?>
                        <div class="pr-empty-box">
                            <i class="<?= $cfg['icon'] ?>" aria-hidden="true"></i>
                            <h4 class="pr-empty-title">No <?= htmlspecialchars($cfg['title']) ?> Listed Yet</h4>
                            <p class="pr-empty-sub">Academic publications and administrative records are updated periodically through the Principal's Office.</p>
                        </div>
                    <?php else: ?>
                        <div class="pr-entries-list">
                            <?php foreach ($items as $it): ?>
                                <div class="pr-entry-card">
                                    <div class="pr-entry-icon" aria-hidden="true">
                                        <i class="<?= $cfg['icon'] ?>"></i>
                                    </div>
                                    <div class="pr-entry-content">
                                        <div class="pr-entry-header">
                                            <h4 class="pr-entry-title"><?= htmlspecialchars($it['title']) ?></h4>
                                            <?php if (!empty($it['extra_info'])): ?>
                                                <span class="pr-entry-tag"><?= htmlspecialchars($it['extra_info']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (!empty($it['description'])): ?>
                                            <p class="pr-entry-desc"><?= nl2br(htmlspecialchars($it['description'])) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

        </section>

    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.pr-tab-btn');
    const tabPanes = document.querySelectorAll('.pr-tab-pane');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-tab');

            tabButtons.forEach(b => {
                b.classList.remove('active');
                b.setAttribute('aria-selected', 'false');
            });
            tabPanes.forEach(p => p.classList.remove('active'));

            this.classList.add('active');
            this.setAttribute('aria-selected', 'true');
            const targetPane = document.getElementById(targetId);
            if (targetPane) {
                targetPane.classList.add('active');
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
