<?php
/**
 * Shared Dynamic Newsletters Component for Department Pages
 *
 * Requirements:
 * - $deptCode (string): e.g. 'IT', 'CE', 'CIVIL', 'ME', 'AE', 'AM', etc.
 * - $deptName (string): e.g. 'Computer Engineering'
 * - $root_path (string): relative path to root, e.g. '../../'
 */

if (!isset($pdo) || !$pdo) {
    if (file_exists(__DIR__ . '/../../includes/db.php')) {
        require_once __DIR__ . '/../../includes/db.php';
        $pdo = getDBConnection();
    } elseif (file_exists(__DIR__ . '/../includes/db.php')) {
        require_once __DIR__ . '/../includes/db.php';
        $pdo = getDBConnection();
    }
}

$deptCode = $deptCode ?? 'CE';
$deptName = $deptName ?? 'Department';
$root_path = $root_path ?? '../../';
$nlPaneId = $nlPaneId ?? 'tab-newsletters';

$newsletters = [];

if (isset($pdo) && $pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT * FROM department_newsletters 
            WHERE dept_code = ? AND is_active = 1 
            ORDER BY display_order ASC, id DESC
        ");
        $stmt->execute([$deptCode]);
        $newsletters = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Dept Newsletters Query Error ($deptCode): " . $e->getMessage());
    }
}
?>

<!-- Tab: Newsletters -->
<section class="dept-tab-pane" id="<?= htmlspecialchars($nlPaneId) ?>">
    <div class="dept-section-header">
        <span class="dept-section-kicker">DISPATCHES &amp; MILESTONES</span>
        <h2>Department Newsletters</h2>
        <p>Official periodicals, semester magazines, student innovations, and academic achievements chronicled by <?= htmlspecialchars($deptName) ?>.</p>
    </div>

    <div class="dept-nl-wrapper">
        <?php if (empty($newsletters)): ?>
            <div style="background: var(--dept-bg-subtle, #f8fafc); border: 1px solid var(--dept-border, #e2e8f0); border-radius: 6px; padding: 48px 24px; text-align: center; color: var(--dept-muted, #64748b); margin-top: 24px;">
                <i class="fas fa-newspaper" style="font-size: 36px; color: var(--dept-muted, #94a3b8); margin-bottom: 12px; display: block;"></i>
                <p style="font-size: 15px; margin: 0 0 6px 0; font-weight: 600; color: #1e293b;">Newsletters Updating</p>
                <p style="font-size: 13.5px; margin: 0; color: var(--dept-muted, #64748b);">No newsletters have been published for this department yet.</p>
            </div>
        <?php else: ?>
            <div class="dept-nl-grid">
                <?php foreach ($newsletters as $item): 
                    $pdfUrl = htmlspecialchars($root_path . ltrim($item['pdf_file'], '/'));
                    $fileSize = !empty($item['file_size']) ? htmlspecialchars($item['file_size']) : 'PDF';
                ?>
                    <article class="dept-nl-card">
                        <div class="dept-nl-card-body">
                            <div class="dept-nl-icon-box" aria-hidden="true">
                                <i class="fas fa-newspaper"></i>
                                <span class="dept-nl-icon-label">PDF</span>
                            </div>
                            <div class="dept-nl-info">
                                <h3 class="dept-nl-title"><?= htmlspecialchars($item['title']) ?></h3>
                                <div class="dept-nl-meta">
                                    <?php if (!empty($item['volume_issue'])): ?>
                                        <span class="dept-nl-vol-tag">
                                            <i class="fas fa-bookmark"></i> <?= htmlspecialchars($item['volume_issue']) ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (!empty($item['issue_period'])): ?>
                                        <span class="dept-nl-period-tag">
                                            <i class="far fa-calendar-alt"></i> <?= htmlspecialchars($item['issue_period']) ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="dept-nl-size">
                                        <i class="fas fa-file-pdf"></i> <?= $fileSize ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="dept-nl-footer">
                            <a href="<?= $pdfUrl ?>" target="_blank" rel="noopener noreferrer" class="dept-nl-btn" title="Open <?= htmlspecialchars($item['title']) ?> in new tab">
                                <span>Read Newsletter</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
