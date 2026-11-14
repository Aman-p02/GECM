<?php
$page_title = "Information Brochures & Reports | Government Engineering College, Modasa";
$active_page = "brochure";
$extra_css = "css/brochure.css";

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

$brochures = [];
if ($pdo) {
    // Latest uploaded brochures appear at the top
    $stmt = $pdo->query("SELECT * FROM institute_brochures WHERE is_active = 1 ORDER BY id DESC");
    $brochures = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
}
?>

<div class="br-page">
    <!-- Main Content Area -->
    <main id="main-content" class="container">
        <!-- Hero / Header -->
        <section class="br-hero" aria-labelledby="brHeading">
            <span class="br-kicker">INSTITUTIONAL PUBLICATIONS &amp; PROSPECTUS</span>
            <h1 id="brHeading" class="br-heading">Information Brochures &amp; Reports</h1>
            <p class="br-lead">
                Official information booklets, admission prospectus, annual institutional activity reports, student induction records, and college publications of Government Engineering College, Modasa.
            </p>
        </section>

        <!-- Publications Card Container -->
        <section class="br-card" aria-label="Information Brochures and Reports">
            <div class="br-card-header">
                <h2 class="br-card-title">
                    <i class="fas fa-book-open" style="color: #009dff;" aria-hidden="true"></i>
                    <span>Published Brochures &amp; Reports</span>
                </h2>
                <span class="br-count-badge"><?= count($brochures) ?> Publications</span>
            </div>

            <?php if (empty($brochures)): ?>
                <div class="br-empty">
                    <i class="fas fa-book-open" aria-hidden="true"></i>
                    <p style="margin: 0; font-weight: 600; color: #334155; font-size: 1.05rem;">No brochures uploaded yet.</p>
                    <p style="margin: 6px 0 0; font-size: 0.9rem; color: #64748b;">Official institutional brochures and booklets will be available here soon.</p>
                </div>
            <?php else: ?>
                <ul class="br-list">
                    <?php foreach ($brochures as $index => $b): ?>
                        <li class="br-row <?= ($index === 0) ? 'is-latest' : '' ?>">
                            <div class="br-left">
                                <div class="br-icon" aria-hidden="true">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="br-details">
                                    <div class="br-title-line">
                                        <h3 class="br-title"><?= htmlspecialchars($b['title']) ?></h3>
                                        <?php if ($index === 0): ?>
                                            <span class="br-badge-latest">Latest</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="br-meta">
                                        <?php if (!empty($b['academic_year'])): ?>
                                            <span class="br-meta-item">
                                                <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                                                <?= htmlspecialchars($b['academic_year']) ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="br-meta-item">
                                            <i class="fas fa-paperclip" aria-hidden="true"></i>
                                            <?= htmlspecialchars($b['file_size'] ?? 'PDF') ?>
                                        </span>
                                        <span class="br-meta-item">
                                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                                            <?= !empty($b['created_at']) ? date('M Y', strtotime($b['created_at'])) : 'Official Issue' ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="br-right">
                                <a href="<?= htmlspecialchars($b['file_path']) ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="br-view-btn"
                                   title="Open <?= htmlspecialchars($b['title']) ?> in new tab">
                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                    <span>View PDF</span>
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
