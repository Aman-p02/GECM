<?php
/**
 * Shared Dynamic Activities Component for Department Pages
 *
 * Requirements:
 * - $deptCode (string): e.g. 'IT', 'CE', 'CIVIL', 'ME', 'AE', 'AM', etc.
 * - $deptName (string): e.g. 'Information Technology'
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

$deptActivities = [];
if (isset($pdo) && $pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT * FROM department_activities 
            WHERE dept_code = ? AND is_active = 1 
            ORDER BY activity_date DESC, id DESC
        ");
        $stmt->execute([$deptCode]);
        $deptActivities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Dept Activities Query Error ($deptCode): " . $e->getMessage());
    }
}
?>

<!-- Tab: Activities & Events -->
<section class="dept-tab-pane" id="tab-activities">
    <div class="dept-section-header">
        <span class="dept-section-kicker">STUDENT ENGAGEMENT &amp; EXPERIENTIAL LEARNING</span>
        <h2>Department Activities</h2>
        <p>Workshops, technical symposiums, industrial visits, expert lectures, and student enrichment programs conducted by <?= htmlspecialchars($deptName) ?>.</p>
    </div>

    <div class="dept-activities-wrapper">
        <?php if (empty($deptActivities)): ?>
            <div style="background: var(--dept-bg-subtle, #f8fafc); border: 1px solid var(--dept-border, #e2e8f0); border-radius: 6px; padding: 48px 24px; text-align: center; color: var(--dept-muted, #64748b); margin-top: 24px;">
                <i class="fas fa-calendar-alt" style="font-size: 36px; color: var(--dept-muted, #94a3b8); margin-bottom: 12px; display: block;"></i>
                <p style="font-size: 15px; margin: 0 0 6px 0; font-weight: 600; color: #1e293b;">Department Activities Updating</p>
                <p style="font-size: 13.5px; margin: 0; color: var(--dept-muted, #64748b);">No recent activities or events have been published for this department yet.</p>
            </div>
        <?php else: ?>
            <!-- Editorial Activities Grid -->
            <div class="dept-activities-grid">
                <?php foreach ($deptActivities as $act):
                    $photoSrc = !empty($act['image_url']) ? $root_path . $act['image_url'] : $root_path . 'images/hero_campus_1.jpg';
                    $modalId = 'actModal_' . $act['id'];
                ?>
                    <article class="activity-card">
                        <?php if (!empty($act['image_url'])): ?>
                            <div class="activity-card-media">
                                <img src="<?= htmlspecialchars($photoSrc) ?>" alt="<?= htmlspecialchars($act['title']) ?>" loading="lazy" onerror="this.src='<?= $root_path ?>images/hero_campus_1.jpg'">
                            </div>
                        <?php endif; ?>

                        <div class="activity-card-body">
                            <?php if (!empty($act['activity_date'])): ?>
                                <span class="activity-date">
                                    <?= date('M d, Y', strtotime($act['activity_date'])) ?>
                                </span>
                            <?php endif; ?>

                            <h3 class="activity-title"><?= htmlspecialchars($act['title']) ?></h3>

                            <p class="activity-desc">
                                <?= nl2br(htmlspecialchars(mb_strimwidth($act['description'], 0, 160, '...'))) ?>
                            </p>

                            <div class="activity-card-footer">
                                <button type="button" class="activity-btn-view" onclick="openActivityModal('<?= $modalId ?>')">
                                    <span>View Details</span>
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                                <?php if (!empty($act['external_url'])): ?>
                                    <a href="<?= htmlspecialchars($act['external_url']) ?>" target="_blank" rel="noopener noreferrer" class="activity-link-ext">
                                        <i class="fas fa-external-link-alt"></i> Report
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>

                    <!-- Full Details Modal for this Activity -->
                    <div class="activity-modal-backdrop" id="<?= $modalId ?>" role="dialog" aria-modal="true" aria-labelledby="<?= $modalId ?>_title">
                        <div class="activity-modal-dialog">
                            <div class="activity-modal-header">
                                <h3 class="activity-modal-title" id="<?= $modalId ?>_title"><?= htmlspecialchars($act['title']) ?></h3>
                                <button type="button" class="activity-modal-close" onclick="closeActivityModal('<?= $modalId ?>')" aria-label="Close dialog">&times;</button>
                            </div>
                            <div class="activity-modal-body">
                                <?php if (!empty($act['image_url'])): ?>
                                    <div style="margin-bottom: 20px; text-align: center; background: var(--dept-bg-subtle, #f8fafc); border-radius: 6px; overflow: hidden; border: 1px solid var(--dept-border, #e5e7eb);">
                                        <img src="<?= htmlspecialchars($photoSrc) ?>" alt="<?= htmlspecialchars($act['title']) ?>" style="max-width: 100%; max-height: 420px; object-fit: contain; display: block; margin: 0 auto;">
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($act['activity_date'])): ?>
                                    <div class="activity-modal-date">
                                        <i class="far fa-calendar-alt"></i> <?= date('F d, Y', strtotime($act['activity_date'])) ?>
                                    </div>
                                <?php endif; ?>

                                <div class="activity-modal-text">
                                    <?= htmlspecialchars($act['description']) ?>
                                </div>

                                <?php if (!empty($act['external_url'])): ?>
                                    <div style="margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--dept-border, #e5e7eb);">
                                        <a href="<?= htmlspecialchars($act['external_url']) ?>" target="_blank" rel="noopener noreferrer" class="activity-modal-cta">
                                            <span>Open External Link / Report</span>
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Modal Helper Scripts for Activities -->
<script>
    function openActivityModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }
    }
    function closeActivityModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('is-open');
            document.body.style.overflow = '';
        }
    }
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('activity-modal-backdrop')) {
            e.target.classList.remove('is-open');
            document.body.style.overflow = '';
        }
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            var openModals = document.querySelectorAll('.activity-modal-backdrop.is-open');
            openModals.forEach(function(m) {
                m.classList.remove('is-open');
            });
            document.body.style.overflow = '';
        }
    });
</script>
