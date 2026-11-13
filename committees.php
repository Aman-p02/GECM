<?php
$active_page = 'committees';
$extra_css = 'css/committees.css';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

$currentSlug = $_GET['c'] ?? 'anti-ragging';

// Fetch all committees for sidebar
$allCommittees = [];
$activeComm = null;
$members = [];

if ($pdo) {
    $cStmt = $pdo->query("SELECT * FROM campus_committees ORDER BY display_order ASC, id ASC");
    $allCommittees = $cStmt ? $cStmt->fetchAll() : [];

    // Find active committee by slug
    foreach ($allCommittees as $c) {
        if ($c['committee_slug'] === $currentSlug) {
            $activeComm = $c;
            break;
        }
    }

    // Fallback to first if slug not matched
    if (!$activeComm && !empty($allCommittees)) {
        $activeComm = $allCommittees[0];
        $currentSlug = $activeComm['committee_slug'];
    }

    if ($activeComm) {
        $mStmt = $pdo->prepare("SELECT * FROM committee_members WHERE committee_id = ? ORDER BY display_order ASC, sr_no ASC, id ASC");
        $mStmt->execute([$activeComm['id']]);
        $members = $mStmt->fetchAll();
    }
}

$pageName = $activeComm['committee_name'] ?? 'Committees';
$page_title = "{$pageName} :: Government Engineering College, Modasa";
?>

<div class="comm-wrapper">
    <div class="comm-container">
        
        <div class="comm-layout">
            
            <!-- Left Sidebar Navigation matching Image 2 -->
            <aside class="comm-sidebar">
                <div class="comm-sidebar-header">
                    <span>Campus Committee</span>
                    <i class="fas fa-chevron-right" style="font-size: 11px;"></i>
                </div>
                <ul class="comm-sidebar-list">
                    <?php if (empty($allCommittees)): ?>
                        <li class="comm-sidebar-item"><span class="comm-sidebar-link">No committees listed</span></li>
                    <?php else: ?>
                        <?php foreach ($allCommittees as $comm): ?>
                            <li class="comm-sidebar-item">
                                <a href="committees.php?c=<?= urlencode($comm['committee_slug']) ?>" class="comm-sidebar-link <?= ($comm['committee_slug'] === $currentSlug) ? 'active' : '' ?>">
                                    <?= htmlspecialchars($comm['committee_name']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>

                <div class="comm-sidebar-accordion-header">
                    <span>Mandatory Disclosures</span>
                    <i class="fas fa-chevron-down" style="font-size: 11px;"></i>
                </div>
                <ul class="comm-sidebar-list">
                    <li class="comm-sidebar-item">
                        <a href="mandatory-disclosure.php" class="comm-sidebar-link">RTI Pro-Active Disclosure</a>
                    </li>
                    <li class="comm-sidebar-item">
                        <a href="mandatory-disclosure.php" class="comm-sidebar-link">AICTE Mandatory Disclosure</a>
                    </li>
                    <li class="comm-sidebar-item">
                        <a href="mandatory-disclosure.php" class="comm-sidebar-link">Financial Statements</a>
                    </li>
                    <li class="comm-sidebar-item">
                        <a href="mandatory-disclosure.php" class="comm-sidebar-link">Accreditation</a>
                    </li>
                    <li class="comm-sidebar-item">
                        <a href="mandatory-disclosure.php" class="comm-sidebar-link">Institute Establishment Resolution</a>
                    </li>
                    <li class="comm-sidebar-item">
                        <a href="mandatory-disclosure.php" class="comm-sidebar-link">RTI Booklet (2005)</a>
                    </li>
                </ul>
            </aside>

            <!-- Right Content Area matching Image 3 & Image 4 -->
            <main class="comm-content-area">
                
                <div class="comm-top-row">
                    <h1 class="comm-page-title"><?= htmlspecialchars($pageName) ?></h1>
                    
                    <div class="comm-breadcrumbs">
                        <a href="index.php"><i class="fas fa-home"></i></a>
                        <span style="color: #cbd5e1; margin: 0 4px;">/</span>
                        <span>About</span>
                        <span style="color: #cbd5e1; margin: 0 4px;">/</span>
                        <span style="color: #0284c7;"><?= htmlspecialchars($pageName) ?></span>
                    </div>
                </div>

                <?php if ($activeComm && !empty($activeComm['description'])): ?>
                    <div class="comm-intro-text">
                        <?= nl2br(htmlspecialchars($activeComm['description'])) ?>
                    </div>
                <?php endif; ?>

                <?php if ($activeComm && !empty($activeComm['objectives'])): ?>
                    <div class="comm-objectives-box">
                        <div class="comm-objectives-title">Objectives:</div>
                        <div style="font-size: 14px; line-height: 1.7; color: #334155; white-space: pre-line;"><?= htmlspecialchars($activeComm['objectives']) ?></div>
                    </div>
                <?php endif; ?>

                <!-- Subheading matching Image 3 & 4 -->
                <h2 class="comm-subheading"><?= htmlspecialchars($pageName) ?></h2>

                <!-- Committee Members Table -->
                <div class="comm-table-wrap">
                    <table class="comm-table">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Sr. No.</th>
                                <th style="width: 38%;">Name of Faculty</th>
                                <th style="width: 34%;">Designation</th>
                                <th style="width: 18%;">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($members)): ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 25px; color: #64748b;">No members listed for this committee yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($members as $m): ?>
                                    <tr>
                                        <td><?= (int)$m['sr_no'] ?></td>
                                        <td class="comm-faculty-name"><?= htmlspecialchars($m['faculty_name']) ?></td>
                                        <td><?= htmlspecialchars($m['designation'] ?: '--') ?></td>
                                        <td><?= htmlspecialchars($m['role']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </main>

        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
