<?php
$page_title = "Institutional Rankings & Accreditations :: Government Engineering College, Modasa";
$active_page = 'about';
$extra_css = 'css/rankings.css';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

$rankings = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM institute_rankings WHERE is_active = 1 ORDER BY display_order ASC, id DESC");
    $rankings = $stmt ? $stmt->fetchAll() : [];
}
?>

<div class="rankings-page-wrapper">
    <div class="rankings-container">
        
        <!-- Header & Breadcrumbs -->
        <div class="rankings-header">
            <div>
                <h1 class="rankings-title">Institutional Rankings &amp; Surveys</h1>
                <p class="rankings-subtitle">Official national ranking submissions, performance audit reports, and accreditation outcomes (NIRF, GSIRF, etc.).</p>
            </div>
            <div class="rankings-breadcrumbs">
                <a href="index.php" title="Home"><i class="fas fa-home"></i></a>
                <span class="sep">/</span>
                <a href="overview.php">About</a>
                <span class="sep">/</span>
                <span>Rankings</span>
            </div>
        </div>

        <?php if (empty($rankings)): ?>
            <div class="rankings-empty-state">
                <i class="fas fa-award"></i>
                <h3 style="font-size: 18px; font-weight: 600; color: #334155; margin: 0 0 8px 0;">Rankings Data Being Updated</h3>
                <p style="font-size: 14px; margin: 0;">Official ranking certificates and evaluation reports for the current academic year are being processed by the IQAC and will be published here shortly.</p>
            </div>
        <?php else: ?>
            <div class="rankings-grid">
                <?php foreach ($rankings as $item): ?>
                    <div class="ranking-card">
                        <div>
                            <div class="ranking-card-top">
                                <div class="ranking-icon-box">
                                    <i class="fas fa-medal"></i>
                                </div>
                                <?php if (!empty($item['ranking_body'])): ?>
                                    <span class="ranking-badge">
                                        <?= htmlspecialchars($item['ranking_body']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <h2 class="ranking-doc-title">
                                <?= htmlspecialchars($item['title']) ?>
                            </h2>
                            <div class="ranking-doc-meta">
                                <div><i class="fas fa-calendar-alt" style="color: #94a3b8; width: 16px;"></i> Year: <strong><?= htmlspecialchars($item['academic_year'] ?? 'Latest') ?></strong></div>
                                <div style="margin-top: 4px;"><i class="fas fa-file-pdf" style="color: #dc2626; width: 16px;"></i> Size: <?= htmlspecialchars($item['file_size'] ?? 'PDF Document') ?></div>
                            </div>
                        </div>
                        <div>
                            <a href="<?= htmlspecialchars($item['file_path']) ?>" target="_blank" class="ranking-download-btn">
                                <i class="fas fa-download"></i> View / Download Report
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

