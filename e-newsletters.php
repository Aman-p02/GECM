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
    <!-- Breadcrumb -->
    <div class="breadcrumb-wrapper">
        <div class="container">
            <nav class="breadcrumb-nav" aria-label="Breadcrumb">
                <a href="index.php"><i class="fas fa-home" aria-hidden="true"></i> Home</a>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
                <a href="overview.php">About</a>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
                <span class="breadcrumb-current" aria-current="page">E-Newsletters</span>
            </nav>
        </div>
    </div>

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

        <!-- Newsletter Links Container -->
        <section class="nl-archive-card" aria-label="E-Newsletter Publications">
            <?php if (empty($newsletters)): ?>
                <div class="nl-empty">
                    <i class="fas fa-newspaper" aria-hidden="true"></i>
                    <p style="margin: 0; font-weight: 500; color: #334155;">No e-newsletters uploaded yet.</p>
                    <p style="margin: 6px 0 0; font-size: 0.9rem; color: #64748b;">Periodic newsletters will be listed here soon.</p>
                </div>
            <?php else: ?>
                <ul class="nl-links-list">
                    <?php foreach ($newsletters as $index => $nl): ?>
                        <li class="nl-item <?= ($index === 0) ? 'is-latest' : '' ?>">
                            <a href="<?= htmlspecialchars($nl['file_path']) ?>" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="nl-link"
                               title="Open <?= htmlspecialchars($nl['title']) ?> (PDF)">
                                <?= htmlspecialchars($nl['title']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
