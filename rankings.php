<?php
require_once __DIR__ . '/includes/db.php';

$rankingsByYear = [];

if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM institute_rankings WHERE is_active = 1 AND file_path != '#' AND file_path != '' AND file_path IS NOT NULL ORDER BY academic_year DESC, display_order ASC, id DESC");
        $allRankings = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        foreach ($allRankings as $r) {
            $yr = !empty($r['academic_year']) ? trim($r['academic_year']) : 'General';
            $rankingsByYear[$yr][] = $r;
        }
    } catch (Exception $e) {
        error_log("Error loading rankings: " . $e->getMessage());
    }
}

$page_title = "NIRF & Institutional Rankings :: Government Engineering College, Modasa";
$active_page = 'about';
$extra_css = 'css/rankings.css';
require_once __DIR__ . '/includes/header.php';
?>

<div class="rankings-page-wrapper">

    <!-- Page Hero Banner -->
    <section class="rnk-hero">
        <div class="container rnk-container">
            <span class="rnk-kicker">INSTITUTIONAL PERFORMANCE &amp; AUDITS</span>
            <h1 class="rnk-title">NIRF &amp; Institutional Rankings</h1>
        </div>
    </section>

    <!-- Main Content Container -->
    <div class="container rnk-container">

        <?php if (!empty($rankingsByYear)): ?>
            <div class="rnk-content-wrapper" id="rnkContentWrapper">
                <?php foreach ($rankingsByYear as $year => $reports): ?>
                    <section class="rnk-year-block" id="year-<?= htmlspecialchars($year) ?>">
                        
                        <div class="rnk-year-header">
                            <h2 class="rnk-year-title">
                                <span><?= htmlspecialchars($year) ?></span>
                            </h2>
                        </div>

                        <div class="rnk-reports-list">
                            <?php foreach ($reports as $doc): ?>
                                <?php
                                    $hasRealFile = !empty($doc['file_path']) && $doc['file_path'] !== '#' && file_exists(__DIR__ . '/' . ltrim($doc['file_path'], '/'));
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
                                                <?php if (!empty($doc['file_size']) && $doc['file_size'] !== 'PDF'): ?>
                                                    <span class="rnk-report-size">
                                                        <i class="fas fa-paperclip"></i> <?= htmlspecialchars($doc['file_size']) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <h3 class="rnk-report-title">
                                                <span><?= htmlspecialchars($doc['title']) ?></span>
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
                                            <span class="rnk-btn-pending" title="Official file can be uploaded from the admin panel">
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
        <?php else: ?>
            <div class="rnk-empty-state" style="text-align: center; padding: 56px 24px; background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 8px; margin: 30px 0;">
                <i class="fas fa-file-pdf" style="font-size: 38px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                <h3 style="font-size: 17px; font-weight: 700; color: #1e293b; margin: 0 0 6px 0;">No Ranking Reports Published Yet</h3>
                <p style="font-size: 14px; color: #64748b; margin: 0;">Institutional ranking reports uploaded through the admin panel will appear here.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
