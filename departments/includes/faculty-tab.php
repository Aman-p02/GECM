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
                        $photoSrc = !empty($fac['photo_url']) ? $root_path . $fac['photo_url'] : $root_path . 'images/avatar_placeholder.jpg';
                        ?>
                        <img src="<?= htmlspecialchars($photoSrc) ?>" 
                             alt="<?= htmlspecialchars($fac['name']) ?>" 
                             class="faculty-card-photo" 
                             onerror="this.src='<?= $root_path ?>images/avatar_placeholder.jpg'">
                    </div>
                    <div class="faculty-card-content">
                        <h3 class="faculty-card-name"><?= htmlspecialchars($fac['name']) ?></h3>
                        <table class="faculty-info-table">
                            <tbody>
                                <tr>
                                    <th class="faculty-th">Designation</th>
                                    <td class="faculty-colon">:</td>
                                    <td class="faculty-td"><?= htmlspecialchars($fac['designation'] ?: ' - ') ?></td>
                                </tr>
                                <tr>
                                    <th class="faculty-th">Qualification</th>
                                    <td class="faculty-colon">:</td>
                                    <td class="faculty-td"><?= htmlspecialchars($fac['qualification'] ?: ' - ') ?></td>
                                </tr>
                                <tr>
                                    <th class="faculty-th">Experience</th>
                                    <td class="faculty-colon">:</td>
                                    <td class="faculty-td"><?= htmlspecialchars($fac['experience'] ?: ' - ') ?></td>
                                </tr>
                                <?php if (!empty($fac['date_of_joining']) && $fac['date_of_joining'] !== '0000-00-00'): ?>
                                <tr>
                                    <th class="faculty-th">Date of joining</th>
                                    <td class="faculty-colon">:</td>
                                    <td class="faculty-td"><?= date('d-m-Y', strtotime($fac['date_of_joining'])) ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if (!empty($fac['area_of_interest'])): ?>
                                <tr>
                                    <th class="faculty-th">Area of Interest</th>
                                    <td class="faculty-colon">:</td>
                                    <td class="faculty-td"><?= htmlspecialchars($fac['area_of_interest']) ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if (!empty($fac['email'])): ?>
                                <tr>
                                    <th class="faculty-th">Email</th>
                                    <td class="faculty-colon">:</td>
                                    <td class="faculty-td">
                                        <a href="mailto:<?= htmlspecialchars($fac['email']) ?>"><?= htmlspecialchars($fac['email']) ?></a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <th class="faculty-th">Website</th>
                                    <td class="faculty-colon">:</td>
                                    <td class="faculty-td">
                                        <?php if (!empty($fac['website']) && $fac['website'] !== '#' && $fac['website'] !== '0'): ?>
                                            <a href="<?= htmlspecialchars($fac['website']) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($fac['website']) ?></a>
                                        <?php else: ?>
                                             - 
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="faculty-card-footer">
                            <a href="<?= $root_path ?>departments/faculty-profile.php?id=<?= $fac['id'] ?>" class="faculty-read-more">Read More...</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

