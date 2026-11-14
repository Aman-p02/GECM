<?php
$page_title = "E-Newsletters | Government Engineering College, Modasa";
$active_page = "newsletters";
$extra_css = "css/e-newsletters.css";

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

$newsletters = [];
if ($pdo) {
    // Latest uploaded newsletters appear at the top
    $stmt = $pdo->query("SELECT * FROM institute_newsletters WHERE is_active = 1 ORDER BY id DESC");
    $newsletters = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
}
?>

<div class="nl-page">
    <!-- Main Content Area -->
    <main id="main-content" class="container">
        <!-- Hero / Header -->
        <section class="nl-hero" aria-labelledby="nlHeading">
            <span class="nl-kicker">PUBLICATIONS &amp; ARCHIVES</span>
            <h1 id="nlHeading" class="nl-heading">E-Newsletters</h1>
            <p class="nl-lead">
                Official periodic institutional e-newsletters capturing academic milestones, departmental innovations, faculty research achievements, student campus life, and outreach initiatives.
            </p>
        </section>

        <!-- Publications Card Container -->
        <section class="nl-card" aria-label="E-Newsletter Publications">
            <div class="nl-card-header">
                <h2 class="nl-card-title">
                    <i class="fas fa-newspaper" style="color: #009dff;" aria-hidden="true"></i>
                    <span>Published Issues</span>
                </h2>
                <span class="nl-count-badge"><?= count($newsletters) ?> Publications</span>
            </div>

            <?php if (empty($newsletters)): ?>
                <div class="nl-empty">
                    <i class="fas fa-newspaper" aria-hidden="true"></i>
                    <p style="margin: 0; font-weight: 600; color: #334155; font-size: 1.05rem;">No e-newsletters uploaded yet.</p>
                    <p style="margin: 6px 0 0; font-size: 0.9rem; color: #64748b;">Periodic newsletters will be published here soon.</p>
                </div>
            <?php else: ?>
                <ul class="nl-list">
                    <?php foreach ($newsletters as $index => $nl): ?>
                        <li class="nl-row <?= ($index === 0) ? 'is-latest' : '' ?>">
                            <div class="nl-left">
                                <div class="nl-icon" aria-hidden="true">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="nl-details">
                                    <div class="nl-title-line">
                                        <h3 class="nl-title"><?= htmlspecialchars($nl['title']) ?></h3>
                                        <?php if ($index === 0): ?>
                                            <span class="nl-badge-latest">Latest</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="nl-meta">
                                        <span class="nl-meta-item">
                                            <i class="fas fa-paperclip" aria-hidden="true"></i>
                                            <?= htmlspecialchars($nl['file_size'] ?? 'PDF') ?>
                                        </span>
                                        <span class="nl-meta-item">
                                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                                            <?= !empty($nl['created_at']) ? date('M Y', strtotime($nl['created_at'])) : 'Official Issue' ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="nl-right">
                                <a href="<?= htmlspecialchars($nl['file_path']) ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="nl-view-btn"
                                   title="Open <?= htmlspecialchars($nl['title']) ?> in new tab">
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
