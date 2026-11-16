<?php
$page_title = "NIRF & Institutional Rankings :: Government Engineering College, Modasa";
$active_page = 'about';
$extra_css = 'css/rankings.css';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

$rankingsByYear = [];

if ($pdo) {
    try {
        // Self-healing database table setup
        $pdo->exec("CREATE TABLE IF NOT EXISTS `institute_rankings` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `title` VARCHAR(255) NOT NULL,
            `ranking_body` VARCHAR(100) DEFAULT 'NIRF',
            `academic_year` VARCHAR(50) NOT NULL,
            `file_path` VARCHAR(500) NOT NULL,
            `file_size` VARCHAR(50) DEFAULT NULL,
            `display_order` INT NOT NULL DEFAULT 0,
            `is_active` TINYINT(1) NOT NULL DEFAULT 1,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_rankings_year` (`academic_year`),
            INDEX `idx_rankings_order` (`display_order`, `id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        // Seed initial NIRF structure if table is empty
        $count = $pdo->query("SELECT COUNT(*) FROM institute_rankings")->fetchColumn();
        if ($count == 0) {
            $defaultItems = [
                ['title' => 'All Report-MHRD, National Institutional Ranking Framework (NIRF)-ENGINEERING', 'academic_year' => '2025', 'ranking_body' => 'NIRF', 'display_order' => 1],
                ['title' => 'All Report-MHRD, National Institutional Ranking Framework (NIRF)-OVERALL', 'academic_year' => '2025', 'ranking_body' => 'NIRF', 'display_order' => 2],
                ['title' => 'All Report-MHRD, National Institutional Ranking Framework (NIRF)-ENGINEERING', 'academic_year' => '2024', 'ranking_body' => 'NIRF', 'display_order' => 1],
                ['title' => 'All Report-MHRD, National Institutional Ranking Framework (NIRF)-ENGINEERING', 'academic_year' => '2023', 'ranking_body' => 'NIRF', 'display_order' => 1],
                ['title' => 'All Report-MHRD, National Institutional Ranking Framework (NIRF)-OVERALL', 'academic_year' => '2023', 'ranking_body' => 'NIRF', 'display_order' => 2],
                ['title' => 'All Report-MHRD, National Institutional Ranking Framework (NIRF)-ENGINEERING', 'academic_year' => '2022', 'ranking_body' => 'NIRF', 'display_order' => 1],
                ['title' => 'All Report-MHRD, National Institutional Ranking Framework (NIRF)-OVERALL', 'academic_year' => '2022', 'ranking_body' => 'NIRF', 'display_order' => 2],
                ['title' => 'All Report-MHRD, National Institutional Ranking Framework (NIRF)-ENGINEERING', 'academic_year' => '2021', 'ranking_body' => 'NIRF', 'display_order' => 1],
                ['title' => 'All Report-MHRD, National Institutional Ranking Framework (NIRF)-OVERALL', 'academic_year' => '2021', 'ranking_body' => 'NIRF', 'display_order' => 2],
                ['title' => 'All Report-MHRD, National Institutional Ranking Framework (NIRF)-ENGINEERING', 'academic_year' => '2020', 'ranking_body' => 'NIRF', 'display_order' => 1],
                ['title' => 'All Report-MHRD, National Institutional Ranking Framework (NIRF)-OVERALL', 'academic_year' => '2020', 'ranking_body' => 'NIRF', 'display_order' => 2],
            ];
            $seedStmt = $pdo->prepare("INSERT INTO institute_rankings (title, ranking_body, academic_year, file_path, file_size, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
            foreach ($defaultItems as $item) {
                $seedStmt->execute([$item['title'], $item['ranking_body'], $item['academic_year'], '#', 'PDF', $item['display_order'], 1]);
            }
        }

        $stmt = $pdo->query("SELECT * FROM institute_rankings WHERE is_active = 1 ORDER BY academic_year DESC, display_order ASC, id DESC");
        $allRankings = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        foreach ($allRankings as $r) {
            $yr = !empty($r['academic_year']) ? trim($r['academic_year']) : 'General';
            $rankingsByYear[$yr][] = $r;
        }
    } catch (Exception $e) {
        error_log("Error loading rankings: " . $e->getMessage());
    }
}
?>

<div class="rankings-page-wrapper">

    <!-- Page Hero Banner -->
    <section class="rnk-hero">
        <div class="container rnk-container">
            <span class="rnk-kicker">INSTITUTIONAL PERFORMANCE &amp; AUDITS</span>
            <h1 class="rnk-title">NIRF &amp; Institutional Rankings</h1>
            <p class="rnk-lead">
                Official ranking audit submissions, evaluation certificates, and institutional reports under the National Institutional Ranking Framework (NIRF, Ministry of Education, Govt. of India).
            </p>
            <div class="rnk-breadcrumbs" aria-label="Breadcrumb">
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
                <span class="sep">/</span>
                <a href="overview.php">About</a>
                <span class="sep">/</span>
                <span class="current">Rankings</span>
            </div>
        </div>
    </section>

    <!-- Year Sticky Filter Pills Bar -->
    <?php if (!empty($rankingsByYear)): ?>
        <nav class="rnk-year-nav" aria-label="Ranking Years Navigation">
            <div class="container rnk-container">
                <div class="rnk-year-pills" id="rnkYearPills">
                    <button type="button" class="rnk-pill is-active" data-year="all">All Years</button>
                    <?php foreach (array_keys($rankingsByYear) as $year): ?>
                        <button type="button" class="rnk-pill" data-year="<?= htmlspecialchars($year) ?>">
                            <?= htmlspecialchars($year) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </nav>
    <?php endif; ?>

    <!-- Main Content Container -->
    <div class="container rnk-container">

        <?php if (empty($rankingsByYear)): ?>
            <div class="rnk-empty-state">
                <i class="fas fa-award" aria-hidden="true"></i>
                <h2 class="rnk-empty-title">Rankings Data Being Updated</h2>
                <p class="rnk-empty-text">
                    Official ranking submissions and certificates for the current academic year are being compiled by the IQAC and will be published here shortly.
                </p>
            </div>
        <?php else: ?>
            <div class="rnk-content-wrapper" id="rnkContentWrapper">
                <?php foreach ($rankingsByYear as $year => $reports): ?>
                    <section class="rnk-year-block" id="year-<?= htmlspecialchars($year) ?>" data-year-group="<?= htmlspecialchars($year) ?>">
                        
                        <div class="rnk-year-header">
                            <h2 class="rnk-year-title">
                                <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                                <span>Year <?= htmlspecialchars($year) ?></span>
                            </h2>
                            <span class="rnk-year-count"><?= count($reports) ?> <?= count($reports) === 1 ? 'Report' : 'Reports' ?></span>
                        </div>

                        <div class="rnk-reports-list">
                            <?php foreach ($reports as $doc): ?>
                                <?php
                                    $hasRealFile = !empty($doc['file_path']) && $doc['file_path'] !== '#';
                                    $fileUrl = $hasRealFile ? htmlspecialchars($doc['file_path']) : 'javascript:void(0);';
                                    $agency = !empty($doc['ranking_body']) ? htmlspecialchars($doc['ranking_body']) : 'NIRF';
                                ?>
                                <article class="rnk-report-card">
                                    <div class="rnk-report-left">
                                        <div class="rnk-report-icon" aria-hidden="true">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                        <div class="rnk-report-info">
                                            <div class="rnk-report-meta">
                                                <span class="rnk-badge rnk-badge-nirf"><?= $agency ?></span>
                                                <span class="rnk-badge rnk-badge-year"><?= htmlspecialchars($year) ?></span>
                                                <?php if (!empty($doc['file_size']) && $doc['file_size'] !== 'PDF'): ?>
                                                    <span class="rnk-report-size">
                                                        <i class="fas fa-paperclip"></i> <?= htmlspecialchars($doc['file_size']) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h3 class="rnk-report-title">
                                                <?php if ($hasRealFile): ?>
                                                    <a href="<?= $fileUrl ?>" target="_blank" rel="noopener noreferrer">
                                                        <?= htmlspecialchars($doc['title']) ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span><?= htmlspecialchars($doc['title']) ?></span>
                                                <?php endif; ?>
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="rnk-report-action">
                                        <?php if ($hasRealFile): ?>
                                            <a href="<?= $fileUrl ?>" target="_blank" rel="noopener noreferrer" class="rnk-btn-view">
                                                <span>View Report</span>
                                                <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                                            </a>
                                        <?php else: ?>
                                            <span class="rnk-btn-pending" title="Official file will be uploaded shortly by the administration">
                                                <i class="far fa-clock" aria-hidden="true"></i> File Awaiting Upload
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>

                    </section>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- Interactive Year Filter Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pills = document.querySelectorAll('.rnk-pill');
    const yearBlocks = document.querySelectorAll('.rnk-year-block');

    pills.forEach(function(pill) {
        pill.addEventListener('click', function() {
            const targetYear = this.getAttribute('data-year');

            // Update active pill state
            pills.forEach(p => p.classList.remove('is-active'));
            this.classList.add('is-active');

            // Filter year blocks
            yearBlocks.forEach(function(block) {
                if (targetYear === 'all' || block.getAttribute('data-year-group') === targetYear) {
                    block.style.display = 'block';
                } else {
                    block.style.display = 'none';
                }
            });

            // Smooth scroll if specific year clicked
            if (targetYear !== 'all') {
                const targetBlock = document.getElementById('year-' + targetYear);
                if (targetBlock) {
                    targetBlock.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
