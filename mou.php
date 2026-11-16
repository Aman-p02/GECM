<?php
require_once __DIR__ . '/includes/db.php';

$mous = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM institute_mous WHERE is_active = 1 AND file_path != '#' AND file_path != '' AND file_path IS NOT NULL ORDER BY id DESC");
        $mous = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    } catch (Exception $e) {
        error_log("Error loading MOUs: " . $e->getMessage());
    }
}

$page_title = "Memorandums of Understanding (MoU) :: Government Engineering College, Modasa";
$active_page = 'about';
$extra_css = 'css/mou.css';
require_once __DIR__ . '/includes/header.php';
?>

<div class="mou-page-wrapper">

    <!-- Page Hero Banner -->
    <section class="mou-hero">
        <div class="container mou-container">
            <span class="mou-kicker">COLLABORATIONS &amp; STRATEGIC PARTNERSHIPS</span>
            <h1 class="mou-title">Memorandums of Understanding (MoU)</h1>
        </div>
    </section>

    <!-- Main Content Container -->
    <div class="container mou-container">

        <?php if (!empty($mous)): ?>
            <div class="mou-reports-list">
                <?php foreach ($mous as $doc): ?>
                    <?php
                        $hasRealFile = !empty($doc['file_path']) && $doc['file_path'] !== '#' && file_exists(__DIR__ . '/' . ltrim($doc['file_path'], '/'));
                        $fileUrl = $hasRealFile ? htmlspecialchars($doc['file_path']) : 'javascript:void(0);';
                    ?>
                    <article class="mou-report-card">
                        <div class="mou-report-left">
                            <div class="mou-report-icon" aria-hidden="true">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="mou-report-info">
                                <div class="mou-report-meta">
                                    <span class="mou-badge">MOU</span>
                                    <?php if (!empty($doc['file_size']) && $doc['file_size'] !== 'PDF'): ?>
                                        <span class="mou-report-size">
                                            <i class="fas fa-paperclip"></i> <?= htmlspecialchars($doc['file_size']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <h3 class="mou-report-title">
                                    <span><?= htmlspecialchars($doc['title']) ?></span>
                                </h3>
                            </div>
                        </div>

                        <div class="mou-report-action">
                            <?php if ($hasRealFile): ?>
                                <a href="<?= $fileUrl ?>" target="_blank" rel="noopener noreferrer" class="mou-btn-view">
                                    <span>View MoU</span>
                                    <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                                </a>
                            <?php else: ?>
                                <span class="mou-btn-pending" title="Official file can be uploaded from the admin panel">
                                    <i class="far fa-clock" aria-hidden="true"></i> File Awaiting Upload
                                </span>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="mou-empty-state">
                <i class="fas fa-file-pdf"></i>
                <h3 class="mou-empty-title">No MoU Documents Published Yet</h3>
                <p class="mou-empty-text">Institutional collaboration agreements and signed MoUs uploaded through the admin panel will appear here.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
