<?php
require_once __DIR__ . '/../includes/db.php';

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

// Photo URL resolution with existing file check
$photo_url = 'images/avatar_placeholder.svg';
if (!empty($profile['photo_url']) && file_exists(__DIR__ . '/../' . ltrim($profile['photo_url'], '/'))) {
    $photo_url = ltrim($profile['photo_url'], '/');
} elseif (file_exists(__DIR__ . '/../uploads/principal/principal_1794768679_38c22090.jpeg')) {
    $photo_url = 'uploads/principal/principal_1794768679_38c22090.jpeg';
}

// Parse specialization tags
$interests = array_filter(array_map('trim', explode(',', $raw_interests)));

$page_title = "Principal :: Government Engineering College, Modasa";
$active_page = 'principal';
$root_path = '../';
$extra_css = 'css/principal.css';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="pr-page-wrapper">

    <!-- Page Hero Banner -->
    <header class="pr-hero">
        <div class="container pr-container">
            <span class="pr-kicker">INSTITUTIONAL LEADERSHIP</span>
            <h1 class="pr-heading">Principal Profile</h1>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="container pr-container">

        <!-- Executive Profile Card (Borderless) -->
        <article class="pr-profile-card" aria-label="Principal Executive Profile">
            
            <!-- Left Portrait Column with Quick Actions -->
            <div class="pr-profile-media">
                <div class="pr-portrait-frame">
                    <img src="<?= $root_path . htmlspecialchars($photo_url) ?>" 
                         alt="<?= htmlspecialchars($name) ?>" 
                         class="pr-portrait-img" 
                         loading="eager"
                         onerror="this.src='<?= $root_path ?>images/avatar_placeholder.svg'">
                </div>

                <div class="pr-media-actions">
                    <!-- Clean URL without .php -->
                    <a href="<?= $root_path ?>about/principal-message" class="pr-cta-desk-btn" title="Read Principal's Official Welcome Message">
                        <span>Principal's Message</span>
                    </a>

                    <div class="pr-contact-pills-row">
                        <?php if (!empty($email)): ?>
                            <a href="mailto:<?= htmlspecialchars($email) ?>" class="pr-contact-btn" title="Email: <?= htmlspecialchars($email) ?>">
                                <i class="fas fa-envelope" aria-hidden="true"></i>
                                <span>Email</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Body / Information -->
            <div class="pr-profile-body">
                <div class="pr-badge-strip">
                    <span class="pr-badge-lead">Head of the Institute &bull; Principal</span>
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
                <?php 
                $totalPubsCount = 0;
                if (!empty($tabItems['pub_summary'])) {
                    foreach ($tabItems['pub_summary'] as $s) {
                        $totalPubsCount += (int)($s['extra_info'] ?? 0);
                    }
                } elseif (!empty($tabItems['publications'])) {
                    $totalPubsCount = count($tabItems['publications']);
                } else {
                    $totalPubsCount = 83;
                }
                ?>
                <button type="button" class="pr-tab-btn" data-tab="tab-publications" role="tab" aria-selected="false" aria-controls="tab-publications">
                    <i class="fas fa-file-invoice" aria-hidden="true"></i>
                    <span>Publications</span>
                    <?php if ($totalPubsCount > 0): ?>
                        <span class="pr-tab-count"><?= $totalPubsCount ?></span>
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
                    <?php if (!empty($tabItems['editorial'])): ?>
                        <span class="pr-tab-count"><?= count($tabItems['editorial']) ?></span>
                    <?php endif; ?>
                </button>
                <button type="button" class="pr-tab-btn" data-tab="tab-talks" role="tab" aria-selected="false" aria-controls="tab-talks">
                    <i class="fas fa-microphone-alt" aria-hidden="true"></i>
                    <span>Expert Talks</span>
                    <?php if (!empty($tabItems['expert_talks'])): ?>
                        <span class="pr-tab-count"><?= count($tabItems['expert_talks']) ?></span>
                    <?php endif; ?>
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

            <!-- 1. Qualifications Pane (Academic Milestones Stream) -->
            <div id="tab-qualifications" class="pr-tab-pane active" role="tabpanel">
                <?php if (empty($qualifications)): ?>
                    <div class="pr-empty-box">
                        <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                        <h4 class="pr-empty-title">Educational Milestones</h4>
                        <p class="pr-empty-sub">Academic degrees and qualifications are currently being compiled.</p>
                    </div>
                <?php else: ?>
                    <div class="pr-qual-stream">
                        <?php foreach ($qualifications as $idx => $q): 
                            $univ = !empty($q['university_board']) ? $q['university_board'] : ($q['university'] ?? '');
                            $isLast = ($idx === count($qualifications) - 1);
                        ?>
                            <div class="pr-qual-row <?= $isLast ? 'is-last' : '' ?>">
                                <div class="pr-qual-year-col">
                                    <span class="pr-qual-year"><?= htmlspecialchars($q['year_of_passing']) ?></span>
                                    <span class="pr-qual-year-label">Passing Year</span>
                                </div>

                                <div class="pr-qual-divider-col" aria-hidden="true">
                                    <span class="pr-qual-dot"></span>
                                    <?php if (!$isLast): ?>
                                        <span class="pr-qual-line"></span>
                                    <?php endif; ?>
                                </div>

                                <div class="pr-qual-content-col">
                                    <div class="pr-qual-header">
                                        <h3 class="pr-qual-title"><?= htmlspecialchars($q['qualification']) ?></h3>
                                        <?php if (!empty($q['percentage'])): ?>
                                            <span class="pr-qual-grade"><?= htmlspecialchars($q['percentage']) ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (!empty($univ)): ?>
                                        <div class="pr-qual-univ">
                                            <i class="fas fa-university" aria-hidden="true"></i>
                                            <span><?= htmlspecialchars($univ) ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- 2. Publications Pane (Summary Table + Scholarly Articles) -->
            <div id="tab-publications" class="pr-tab-pane" role="tabpanel">
                <?php 
                $publicationsList = $tabItems['publications'] ?? [];
                $pubSummary = $tabItems['pub_summary'] ?? [
                    ['title' => 'International Journal', 'extra_info' => '53'],
                    ['title' => 'International Conference', 'extra_info' => '22'],
                    ['title' => 'National Journal', 'extra_info' => '3'],
                    ['title' => 'National Conference', 'extra_info' => '5'],
                ];
                $sumTotal = 0;
                foreach ($pubSummary as $ps) {
                    $sumTotal += (int)($ps['extra_info'] ?? 0);
                }
                ?>
                <!-- Category Summary Table -->
                <div class="pr-pub-summary-card">
                    <div class="pr-pub-summary-header">
                        <h4 class="pr-pub-summary-title">
                            <i class="fas fa-chart-pie" aria-hidden="true"></i>
                            <span>Summary of Research Publications</span>
                        </h4>
                        <span class="pr-pub-total-badge">Total Publications: <strong><?= $sumTotal ?></strong></span>
                    </div>

                    <div class="table-responsive">
                        <table class="pr-pub-summary-table">
                            <thead>
                                <tr>
                                    <th style="width: 80px; text-align: center;">Sr. No.</th>
                                    <th>Category</th>
                                    <th style="width: 200px; text-align: right;">No. of Publications</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pubSummary as $sIdx => $ps): ?>
                                    <tr>
                                        <td style="text-align: center; font-weight: 600; color: #64748b;"><?= $sIdx + 1 ?></td>
                                        <td style="font-weight: 600; color: #0f172a;"><?= htmlspecialchars($ps['title']) ?></td>
                                        <td style="text-align: right; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a; font-size: 1rem;"><?= htmlspecialchars($ps['extra_info']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Individual Publications List -->
                <?php 
                $publicationsList = $tabItems['publications'] ?? [];
                if (empty($publicationsList)): 
                ?>
                    <div class="pr-empty-box" style="margin-top: 24px;">
                        <i class="fas fa-file-invoice" aria-hidden="true"></i>
                        <h4 class="pr-empty-title">Scholarly Publications</h4>
                        <p class="pr-empty-sub">Full list of citations and research papers is being updated periodically through the Principal's Office.</p>
                    </div>
                <?php else: ?>
                    <div class="pr-pub-papers-wrap">
                        <div class="pr-pub-papers-header">
                            <h4 class="pr-pub-papers-title">
                                <i class="fas fa-book-reader" aria-hidden="true"></i>
                                <span>Research Articles &amp; Papers</span>
                            </h4>
                            <span class="pr-pub-count-label">Showing <?= count($publicationsList) ?> listed records</span>
                        </div>

                        <div class="pr-pub-items-list">
                            <?php foreach ($publicationsList as $pIdx => $pub): 
                                $desc = trim($pub['description'] ?? '');
                                $authors = '';
                                $journal = '';

                                if (preg_match('/^Authors:\s*(.*?)(?:\n(.*))?$/s', $desc, $matches)) {
                                    $authors = trim($matches[1]);
                                    $journal = isset($matches[2]) ? trim($matches[2]) : '';
                                } else {
                                    $journal = $desc;
                                }
                                $category = !empty($pub['extra_info']) ? $pub['extra_info'] : 'International Journal';
                            ?>
                                <article class="pr-pub-item">
                                    <div class="pr-pub-icon-col" aria-hidden="true">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    
                                    <div class="pr-pub-content-col">
                                        <h5 class="pr-pub-paper-title"><?= htmlspecialchars($pub['title']) ?></h5>
                                        
                                        <?php if (!empty($authors)): ?>
                                            <div class="pr-pub-authors">
                                                <i class="fas fa-user-friends" aria-hidden="true"></i>
                                                <span><?= htmlspecialchars($authors) ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($journal)): ?>
                                            <div class="pr-pub-journal">
                                                <i class="fas fa-bookmark" aria-hidden="true"></i>
                                                <span><?= htmlspecialchars($journal) ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <div class="pr-pub-footer">
                                            <?php
                                            $catClass = 'tag-journal';
                                            if (stripos($category, 'Conference') !== false) {
                                                $catClass = (stripos($category, 'National') !== false) ? 'tag-national-conf' : 'tag-conference';
                                            } elseif (stripos($category, 'National') !== false) {
                                                $catClass = 'tag-national-journal';
                                            }
                                            ?>
                                            <span class="pr-pub-tag <?= $catClass ?>">
                                                <i class="fas fa-tag" aria-hidden="true"></i>
                                                <?= htmlspecialchars($category) ?>
                                            </span>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- 3. Books & Monographs Pane (Dedicated Card Layout) -->
            <div id="tab-books" class="pr-tab-pane" role="tabpanel">
                <?php 
                $booksList = $tabItems['books'] ?? [];
                if (empty($booksList)): 
                ?>
                    <div class="pr-empty-box">
                        <i class="fas fa-book-open" aria-hidden="true"></i>
                        <h4 class="pr-empty-title">Books &amp; Monographs</h4>
                        <p class="pr-empty-sub">Academic books and curriculum text publications are updated periodically through the Principal's Office.</p>
                    </div>
                <?php else: ?>
                    <div class="pr-pub-papers-wrap">
                        <div class="pr-pub-papers-header">
                            <h4 class="pr-pub-papers-title">
                                <i class="fas fa-book" aria-hidden="true"></i>
                                <span>Books &amp; Monographs Authored</span>
                            </h4>
                            <span class="pr-pub-count-label">Showing <?= count($booksList) ?> Authored Titles</span>
                        </div>

                        <div class="pr-pub-items-list">
                            <?php foreach ($booksList as $bIdx => $b): 
                                $publisher = trim($b['extra_info'] ?? '');
                                $desc = trim($b['description'] ?? '');

                                $edition = '';
                                $univ = '';
                                $branch = '';
                                $semester = '';
                                $book_code = '';
                                $isbn = '';

                                $lines = explode("\n", $desc);
                                foreach ($lines as $ln) {
                                    $ln = trim($ln);
                                    if (preg_match('/^(?:Edition|Content):\s*(.*)$/i', $ln, $m)) {
                                        $val = trim($m[1]);
                                        if ($val !== '--' && $val !== '-') $edition = $val;
                                    } elseif (preg_match('/^University:\s*(.*)$/i', $ln, $m)) {
                                        $val = trim($m[1]);
                                        if ($val !== '--' && $val !== '-') $univ = $val;
                                    } elseif (preg_match('/^Branch:\s*(.*)$/i', $ln, $m)) {
                                        $val = trim($m[1]);
                                        if ($val !== '--' && $val !== '-') $branch = $val;
                                    } elseif (preg_match('/^Semester:\s*(.*)$/i', $ln, $m)) {
                                        $val = trim($m[1]);
                                        if ($val !== '--' && $val !== '-') $semester = $val;
                                    } elseif (preg_match('/^(?:Book Code|Code):\s*(.*)$/i', $ln, $m)) {
                                        $val = trim($m[1]);
                                        if ($val !== '--' && $val !== '-') $book_code = $val;
                                    } elseif (preg_match('/^ISBN:\s*(.*)$/i', $ln, $m)) {
                                        $val = trim($m[1]);
                                        if ($val !== '--' && $val !== '-') $isbn = $val;
                                    }
                                }

                                if (empty($edition) && empty($univ) && empty($branch) && empty($isbn) && empty($book_code) && empty($semester) && !empty($desc)) {
                                    $edition = $desc;
                                }
                            ?>
                                <article class="pr-pub-item">
                                    <div class="pr-pub-icon-col" style="background: #eff6ff; color: #1e90ff; border-color: #bfdbfe;" aria-hidden="true">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    
                                    <div class="pr-pub-content-col">
                                        <h5 class="pr-pub-paper-title"><?= htmlspecialchars($b['title']) ?></h5>

                                        <?php if (!empty($publisher)): ?>
                                            <div class="pr-pub-authors" style="color: #1e40af;">
                                                <i class="fas fa-building" style="color: #3b82f6;" aria-hidden="true"></i>
                                                <span>Publisher: <strong><?= htmlspecialchars($publisher) ?></strong></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($univ) || !empty($branch) || !empty($semester)): ?>
                                            <div class="pr-pub-journal">
                                                <i class="fas fa-university" aria-hidden="true"></i>
                                                <span>
                                                    <?php
                                                    $metaParts = [];
                                                    if (!empty($univ)) $metaParts[] = $univ;
                                                    if (!empty($branch)) $metaParts[] = 'Branch: ' . $branch;
                                                    if (!empty($semester)) $metaParts[] = 'Sem: ' . $semester;
                                                    echo htmlspecialchars(implode(' • ', $metaParts));
                                                    ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($edition) || !empty($isbn) || !empty($book_code)): ?>
                                            <div class="pr-pub-footer">
                                                <?php if (!empty($edition)): ?>
                                                    <span class="pr-pub-tag tag-journal" style="background: #f8fafc; color: #334155; border-color: #cbd5e1;">
                                                        <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                                                        <?= htmlspecialchars($edition) ?>
                                                    </span>
                                                <?php endif; ?>

                                                <?php if (!empty($book_code)): ?>
                                                    <span class="pr-pub-tag" style="background: #f1f5f9; color: #475569; border-color: #cbd5e1;">
                                                        <i class="fas fa-hashtag" aria-hidden="true"></i>
                                                        Code: <?= htmlspecialchars($book_code) ?>
                                                    </span>
                                                <?php endif; ?>

                                                <?php if (!empty($isbn)): ?>
                                                    <span class="pr-pub-tag tag-conference">
                                                        <i class="fas fa-barcode" aria-hidden="true"></i>
                                                        <?= htmlspecialchars($isbn) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- 4. Editorial & Advisory Board Roles Pane -->
            <div id="tab-editorial" class="pr-tab-pane" role="tabpanel">
                <?php 
                $editorialList = $tabItems['editorial'] ?? [];
                if (empty($editorialList)): 
                ?>
                    <div class="pr-empty-box">
                        <i class="fas fa-feather-alt" aria-hidden="true"></i>
                        <h4 class="pr-empty-title">Editorial &amp; Review Board Roles</h4>
                        <p class="pr-empty-sub">Academic journal memberships and editorial responsibilities are updated periodically through the Principal's Office.</p>
                    </div>
                <?php else: ?>
                    <div class="pr-pub-papers-wrap">
                        <div class="pr-pub-papers-header">
                            <h4 class="pr-pub-papers-title">
                                <i class="fas fa-feather-alt" aria-hidden="true"></i>
                                <span>Editorial &amp; Advisory Board Memberships</span>
                            </h4>
                            <span class="pr-pub-count-label">Showing <?= count($editorialList) ?> Editorial Records</span>
                        </div>

                        <div class="pr-pub-summary-card" style="padding: 0; overflow: hidden; border: 1px solid #e2e8f0; border-radius: 10px; background: #ffffff; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);">
                            <div class="table-responsive">
                                <table class="pr-pub-summary-table" style="margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th style="width: 80px; text-align: center; font-weight: 700;">Sr. No.</th>
                                            <th style="font-weight: 700;">Editorials</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($editorialList as $eIdx => $ed): 
                                            $edText = !empty($ed['description']) ? $ed['description'] : $ed['title'];
                                            $edHtml = preg_replace(
                                                '~(https?://[^\s,]+)~i',
                                                '<a href="$1" target="_blank" rel="noopener noreferrer" style="color: #1e90ff; word-break: break-all; text-decoration: underline;">$1</a>',
                                                htmlspecialchars($edText)
                                            );
                                        ?>
                                            <tr>
                                                <td style="text-align: center; font-weight: 700; color: #64748b; vertical-align: top; padding: 16px 14px; border-bottom: 1px solid #f1f5f9;">
                                                    <?= !empty($ed['display_order']) ? (int)$ed['display_order'] : ($eIdx + 1) ?>
                                                </td>
                                                <td style="color: #334155; font-size: 0.935rem; line-height: 1.6; vertical-align: middle; padding: 16px 20px; border-bottom: 1px solid #f1f5f9;">
                                                    <?= $edHtml ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- 5. Expert Talks & Keynotes Pane -->
            <div id="tab-talks" class="pr-tab-pane" role="tabpanel">
                <?php 
                $talksList = $tabItems['expert_talks'] ?? [];
                if (empty($talksList)): 
                ?>
                    <div class="pr-empty-box">
                        <i class="fas fa-microphone-alt" aria-hidden="true"></i>
                        <h4 class="pr-empty-title">Expert Lectures &amp; Keynotes</h4>
                        <p class="pr-empty-sub">Invited keynotes, expert sessions, and technical lectures delivered across universities and institutions are updated periodically.</p>
                    </div>
                <?php else: ?>
                    <div class="pr-pub-papers-wrap">
                        <div class="pr-pub-papers-header">
                            <h4 class="pr-pub-papers-title">
                                <i class="fas fa-microphone-alt" aria-hidden="true"></i>
                                <span>Invited Expert Lectures &amp; Keynotes</span>
                            </h4>
                            <span class="pr-pub-count-label">Showing <?= count($talksList) ?> Expert Talks</span>
                        </div>

                        <div class="pr-pub-summary-card" style="padding: 0; overflow: hidden; border: 1px solid #e2e8f0; border-radius: 10px; background: #ffffff; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);">
                            <div class="table-responsive">
                                <table class="pr-pub-summary-table" style="margin-bottom: 0;">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px; text-align: center; font-weight: 700;">Sr. No.</th>
                                            <th style="width: 90px; text-align: center; font-weight: 700;">Year</th>
                                            <th style="font-weight: 700;">Subject</th>
                                            <th style="font-weight: 700;">Place</th>
                                            <th style="font-weight: 700;">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($talksList as $tIdx => $talk): 
                                            $tDesc = trim($talk['description'] ?? '');
                                            $tYear = '';
                                            $tPlace = trim($talk['extra_info'] ?? '');
                                            $tDetails = '';

                                            $lines = explode("\n", $tDesc);
                                            foreach ($lines as $ln) {
                                                $ln = trim($ln);
                                                if (preg_match('/^Year:\s*(.*)$/i', $ln, $m)) {
                                                    $val = trim($m[1]);
                                                    if ($val !== '--' && $val !== '-') $tYear = $val;
                                                } elseif (preg_match('/^Place:\s*(.*)$/i', $ln, $m)) {
                                                    $val = trim($m[1]);
                                                    if ($val !== '--' && $val !== '-') $tPlace = $val;
                                                } elseif (preg_match('/^Details:\s*(.*)$/i', $ln, $m)) {
                                                    $val = trim($m[1]);
                                                    if ($val !== '--' && $val !== '-') $tDetails = $val;
                                                }
                                            }
                                            if (empty($tDetails) && empty($tYear) && !empty($tDesc) && !preg_match('/^(?:Year|Place|Details):/i', $tDesc)) {
                                                $tDetails = $tDesc;
                                            }
                                        ?>
                                            <tr>
                                                <td style="text-align: center; font-weight: 700; color: #64748b; vertical-align: top; padding: 15px 12px; border-bottom: 1px solid #f1f5f9;">
                                                    <?= !empty($talk['display_order']) ? (int)$talk['display_order'] : ($tIdx + 1) ?>
                                                </td>
                                                <td style="text-align: center; font-weight: 600; color: #1e293b; vertical-align: top; padding: 15px 12px; border-bottom: 1px solid #f1f5f9;">
                                                    <?= !empty($tYear) ? htmlspecialchars($tYear) : '<span style="color: #94a3b8;">-</span>' ?>
                                                </td>
                                                <td style="color: #0f172a; font-weight: 600; font-size: 0.94rem; vertical-align: top; padding: 15px 16px; border-bottom: 1px solid #f1f5f9;">
                                                    <?= htmlspecialchars($talk['title']) ?>
                                                </td>
                                                <td style="color: #334155; font-size: 0.92rem; vertical-align: top; padding: 15px 16px; border-bottom: 1px solid #f1f5f9;">
                                                    <?= !empty($tPlace) ? htmlspecialchars($tPlace) : '<span style="color: #94a3b8;">-</span>' ?>
                                                </td>
                                                <td style="color: #64748b; font-size: 0.88rem; line-height: 1.5; vertical-align: top; padding: 15px 16px; border-bottom: 1px solid #f1f5f9;">
                                                    <?= !empty($tDetails) ? htmlspecialchars($tDetails) : '<span style="color: #94a3b8;">-</span>' ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Dynamic Tab Panes for Other Sections -->
            <?php
            $tabPanesConfig = [
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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
