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
            ORDER BY display_order ASC, activity_date DESC, id DESC
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
        <p>Workshops, technical symposiums, industrial visits, expert lectures, and student enrichment programs
            conducted by <?= htmlspecialchars($deptName) ?>.</p>
    </div>

    <div class="dept-activities-wrapper">
        <?php if (empty($deptActivities)): ?>
            <div
                style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 48px 24px; text-align: center; color: #64748b; margin-top: 24px;">
                <i class="fas fa-calendar-alt"
                    style="font-size: 38px; color: #94a3b8; margin-bottom: 14px; display: block;"></i>
                <p style="font-size: 16px; margin: 0 0 6px 0; font-weight: 600; color: #334155;">Department Activities
                    Updating</p>
                <p style="font-size: 14px; margin: 0; color: #64748b;">No recent activities or events have been published
                    for this department yet.</p>
            </div>
        <?php else: ?>
            <!-- Alternating Modern Timeline Container -->
            <div class="activity-timeline">
                <div class="activity-timeline-line"></div>

                <?php foreach ($deptActivities as $index => $act):
                    $isRight = ($index % 2 !== 0);
                    $cardSideClass = $isRight ? 'timeline-right' : 'timeline-left';
                    $photoSrc = !empty($act['image_url']) ? $root_path . $act['image_url'] : $root_path . 'images/slider/default.jpg';
                    $modalId = 'actModal_' . $act['id'];
                    ?>
                    <div class="timeline-row <?= $cardSideClass ?>">
                        <!-- Center Node Marker -->
                        <div class="timeline-node">
                            <i class="fas fa-circle"></i>
                        </div>

                        <!-- Card Content -->
                        <div class="timeline-card">
                            <?php if (!empty($act['image_url'])): ?>
                                <div class="timeline-media">
                                    <img src="<?= htmlspecialchars($photoSrc) ?>" alt="<?= htmlspecialchars($act['title']) ?>"
                                        loading="lazy" onerror="this.src='<?= $root_path ?>images/slider/default.jpg'">
                                    <?php if (!empty($act['activity_date'])): ?>
                                        <div class="timeline-date-badge">
                                            <i class="far fa-calendar-alt"></i> <?= date('M d, Y', strtotime($act['activity_date'])) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="timeline-body">
                                <?php if (empty($act['image_url']) && !empty($act['activity_date'])): ?>
                                    <div class="timeline-date-text">
                                        <i class="far fa-calendar-alt"></i> <?= date('M d, Y', strtotime($act['activity_date'])) ?>
                                    </div>
                                <?php endif; ?>

                                <h3 class="timeline-title"><?= htmlspecialchars($act['title']) ?></h3>

                                <p class="timeline-desc">
                                    <?= nl2br(htmlspecialchars(mb_strimwidth($act['description'], 0, 180, '...'))) ?>
                                </p>

                                <div class="timeline-footer">
                                    <button type="button" class="btn-activity-view"
                                        onclick="openActivityModal('<?= $modalId ?>')">
                                        View More <i class="fas fa-arrow-right" style="margin-left: 4px;"></i>
                                    </button>
                                    <?php if (!empty($act['external_url'])): ?>
                                        <a href="<?= htmlspecialchars($act['external_url']) ?>" target="_blank"
                                            rel="noopener noreferrer" class="btn-activity-link">
                                            <i class="fas fa-external-link-alt"></i> Link
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Full Details Modal for this Activity -->
                    <div class="activity-modal-backdrop" id="<?= $modalId ?>">
                        <div class="activity-modal-dialog">
                            <div class="activity-modal-header">
                                <h3 class="activity-modal-title"><?= htmlspecialchars($act['title']) ?></h3>
                                <button type="button" class="activity-modal-close"
                                    onclick="closeActivityModal('<?= $modalId ?>')">&times;</button>
                            </div>
                            <div class="activity-modal-body">
                                <?php if (!empty($act['image_url'])): ?>
                                    <div
                                        style="margin-bottom: 20px; text-align: center; background: #f8fafc; border-radius: 6px; overflow: hidden; border: 1px solid #e2e8f0;">
                                        <img src="<?= htmlspecialchars($photoSrc) ?>" alt="<?= htmlspecialchars($act['title']) ?>"
                                            style="max-width: 100%; max-height: 420px; object-fit: contain;">
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($act['activity_date'])): ?>
                                    <div
                                        style="font-size: 13.5px; font-weight: 600; color: #2563eb; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                                        <i class="far fa-calendar-alt"></i> Date:
                                        <?= date('F d, Y', strtotime($act['activity_date'])) ?>
                                    </div>
                                <?php endif; ?>

                                <div style="font-size: 15px; line-height: 1.7; color: #334155; white-space: pre-line;">
                                    <?= htmlspecialchars($act['description']) ?>
                                </div>

                                <?php if (!empty($act['external_url'])): ?>
                                    <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #e2e8f0;">
                                        <a href="<?= htmlspecialchars($act['external_url']) ?>" target="_blank"
                                            rel="noopener noreferrer"
                                            style="display: inline-flex; align-items: center; gap: 8px; background: #2563eb; color: #ffffff; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px;">
                                            <i class="fas fa-external-link-alt"></i> Open External Link / Report
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
</script>