<?php
/**
 * Faculty Roster Component for Department Pages
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

$deptFaculties = [];
if (isset($pdo) && $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM faculties WHERE dept_code = ? AND is_active = 1 ORDER BY display_order ASC, id ASC");
        $stmt->execute([$deptCode]);
        $deptFaculties = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Dept Faculty Query Error ($deptCode): " . $e->getMessage());
    }
}
?>

<!-- Tab: Faculty Directory -->
<section class="dept-tab-pane" id="tab-faculty">
    <div class="dept-section-header">
        <span class="dept-section-kicker">ACADEMIC &amp; RESEARCH LEADERSHIP</span>
        <h2>Faculty Members</h2>
        <p>Dedicated professors, industry researchers, and mentors guiding students of <?= htmlspecialchars($deptName) ?>.</p>
    </div>

    <div class="faculty-roster-list">
        <?php if (empty($deptFaculties)): ?>
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 40px; text-align: center; color: #64748b;">
                <i class="fas fa-user-graduate" style="font-size: 36px; color: #94a3b8; margin-bottom: 12px; display: block;"></i>
                <p style="font-size: 16px; margin: 0 0 6px 0; font-weight: 600; color: #334155;">Faculty Directory Updating</p>
                <p style="font-size: 14px; margin: 0; color: #64748b;">No active faculty members have been published for this department yet.</p>
            </div>
        <?php else: ?>
            <?php foreach ($deptFaculties as $fac): ?>
                <div class="faculty-card">
                    <div class="faculty-card-media">
                        <?php 
                        $photoRel = !empty($fac['photo_url']) ? ltrim($fac['photo_url'], '/') : '';
                        $deptLower = strtolower($fac['dept_code'] ?? 'ce');
                        $photoSrc = $root_path . 'images/avatar_placeholder.svg';

                        if (!empty($photoRel)) {
                            if (file_exists(__DIR__ . '/../../' . $photoRel)) {
                                $photoSrc = $root_path . $photoRel;
                            } elseif (file_exists(__DIR__ . '/../../uploads/faculty/' . $deptLower . '/' . basename($photoRel))) {
                                $photoSrc = $root_path . 'uploads/faculty/' . $deptLower . '/' . basename($photoRel);
                            } elseif (file_exists(__DIR__ . '/../../uploads/faculty/' . basename($photoRel))) {
                                $photoSrc = $root_path . 'uploads/faculty/' . basename($photoRel);
                            } else {
                                $photoSrc = $root_path . $photoRel;
                            }
                        }
                        ?>
                        <div class="faculty-photo-frame">
                            <img src="<?= htmlspecialchars($photoSrc) ?>" 
                                 alt="<?= htmlspecialchars($fac['name']) ?>" 
                                 class="faculty-card-photo" 
                                 loading="lazy"
                                 onerror="this.src='<?= $root_path ?>images/avatar_placeholder.svg'">
                        </div>
                    </div>
                    <div class="faculty-card-body">
                        <div class="faculty-card-top">
                            <div class="faculty-rank"><?= htmlspecialchars($fac['designation'] ?: 'Faculty Member') ?></div>
                            <h3 class="faculty-name">
                                <a href="<?= $root_path ?>departments/faculty-profile.php?id=<?= $fac['id'] ?>">
                                    <?= htmlspecialchars($fac['name']) ?>
                                </a>
                            </h3>
                        </div>

                        <div class="faculty-details-row">
                            <?php if (!empty($fac['qualification'])): ?>
                            <div class="faculty-detail-col">
                                <span class="faculty-detail-label">Qualification</span>
                                <span class="faculty-detail-val"><?= htmlspecialchars($fac['qualification']) ?></span>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($fac['experience'])): ?>
                            <div class="faculty-detail-col">
                                <span class="faculty-detail-label">Experience</span>
                                <span class="faculty-detail-val"><?= htmlspecialchars($fac['experience']) ?></span>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($fac['date_of_joining']) && $fac['date_of_joining'] !== '0000-00-00'): ?>
                            <div class="faculty-detail-col">
                                <span class="faculty-detail-label">Date of Joining</span>
                                <span class="faculty-detail-val"><?= date('d-m-Y', strtotime($fac['date_of_joining'])) ?></span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($fac['area_of_interest'])): ?>
                        <div class="faculty-research">
                            <span class="faculty-research-label">Area of Interest:</span>
                            <span class="faculty-research-val"><?= htmlspecialchars($fac['area_of_interest']) ?></span>
                        </div>
                        <?php endif; ?>

                        <div class="faculty-card-bottom">
                            <div class="faculty-actions-left">
                                <?php if (!empty($fac['email'])): ?>
                                    <a href="mailto:<?= htmlspecialchars($fac['email']) ?>" class="faculty-link" title="Email <?= htmlspecialchars($fac['name']) ?>">
                                        <i class="far fa-envelope"></i>
                                        <span><?= htmlspecialchars($fac['email']) ?></span>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($fac['website']) && $fac['website'] !== '#' && $fac['website'] !== '0' && $fac['website'] !== '-'): ?>
                                    <a href="<?= htmlspecialchars($fac['website']) ?>" target="_blank" rel="noopener noreferrer" class="faculty-link" title="Personal Website">
                                        <i class="fas fa-globe"></i>
                                        <span>Website</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <a href="<?= $root_path ?>departments/faculty-profile.php?id=<?= $fac['id'] ?>" class="faculty-profile-cta">
                                <span>View Profile</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
