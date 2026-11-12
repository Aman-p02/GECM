<?php
/**
 * Department Admin Dashboard Overview - Clean Authentic Institutional Style
 */
$pageTitle = 'Department Overview';
$pageHeading = 'Dashboard Overview';
$activeTab = 'dashboard';

require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();

$facCount = 0;
$actCount = 0;
$pubCount = 0;
$boardCount = 0;
$nlCount = 0;

if ($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM faculties WHERE dept_code = ? AND is_active = 1");
        $stmt->execute([$deptCode]);
        $facCount = (int)$stmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM department_activities WHERE dept_code = ?");
        $stmt->execute([$deptCode]);
        $actCount = (int)$stmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM department_publications WHERE dept_code = ?");
        $stmt->execute([$deptCode]);
        $pubCount = (int)$stmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM department_advisory_board WHERE dept_code = ?");
        $stmt->execute([$deptCode]);
        $boardCount = (int)$stmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM department_newsletters WHERE dept_code = ?");
        $stmt->execute([$deptCode]);
        $nlCount = (int)$stmt->fetchColumn();
    } catch (Exception $e) {}
}
?>

<!-- Clean Minimal Stat Numbers (No Icon Squares) -->
<div class="stats-grid" style="margin-bottom: 24px;">
    <div class="clean-stat-card">
        <div class="stat-number"><?= $facCount ?></div>
        <div class="stat-label">Faculty Members</div>
    </div>

    <div class="clean-stat-card">
        <div class="stat-number"><?= $actCount ?></div>
        <div class="stat-label">Department Activities</div>
    </div>

    <div class="clean-stat-card">
        <div class="stat-number"><?= $pubCount ?></div>
        <div class="stat-label">Research Publications</div>
    </div>

    <div class="clean-stat-card">
        <div class="stat-number"><?= $boardCount ?></div>
        <div class="stat-label">Advisory Board</div>
    </div>
</div>

<!-- Two Column Main Layout -->
<div style="display: grid; grid-template-columns: 2fr 1.2fr; gap: 24px;">
    <!-- Left Column: Department Scope & Control -->
    <div class="admin-card">
        <div class="card-top">
            <h2 class="card-title">Department Management Scope</h2>
            <span style="font-size: 13px; color: var(--admin-text-muted);">
                Authorized Dept: <strong><?= htmlspecialchars($deptCode) ?></strong>
            </span>
        </div>
        <div style="padding: 22px;">
            <p style="color: #495057; font-size: 14px; line-height: 1.6; margin-bottom: 16px;">
                Welcome, <strong><?= htmlspecialchars($deptAdmin['full_name']) ?></strong>. You have administrative control over the <strong><?= htmlspecialchars($deptName) ?></strong> public portal. All updates made here reflect directly on the official college website.
            </p>

            <div style="background: #f8fafc; border: 1px solid var(--admin-border-color); border-radius: 6px; padding: 16px 20px;">
                <h4 style="font-size: 13.5px; font-weight: 700; color: #1e293b; margin-bottom: 10px;">
                    Department Administrator Checklist:
                </h4>
                <ul style="font-size: 13px; color: #64748b; line-height: 1.8; padding-left: 20px;">
                    <li>Keep faculty roster up-to-date with correct designations and emails.</li>
                    <li>Post recent workshops, industrial visits, and expert talks under Activities.</li>
                    <li>Record faculty research publications with journal and conference citations.</li>
                    <li>Publish department biannual newsletters for students and accreditation audits.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Right Column: Quick Shortcuts -->
    <div class="admin-card">
        <div class="card-top">
            <h2 class="card-title">Quick Actions</h2>
        </div>
        <div style="padding: 18px 22px; display: flex; flex-direction: column; gap: 10px;">
            <a href="faculty.php" class="btn-add-new" style="justify-content: center; width: 100%; padding: 10px;">
                Add Faculty Member
            </a>
            <a href="activities.php" class="btn" style="background:#ffffff; color:#2c3e50; border:1px solid #ced4da; padding:9px; border-radius:4px; font-weight:600; text-align:center; text-decoration:none;">
                Post New Activity
            </a>
            <a href="publications.php" class="btn" style="background:#ffffff; color:#2c3e50; border:1px solid #ced4da; padding:9px; border-radius:4px; font-weight:600; text-align:center; text-decoration:none;">
                Add Research Paper
            </a>
            <a href="newsletters.php" class="btn" style="background:#ffffff; color:#2c3e50; border:1px solid #ced4da; padding:9px; border-radius:4px; font-weight:600; text-align:center; text-decoration:none;">
                Upload Newsletter (PDF)
            </a>
            <a href="<?= htmlspecialchars($livePageUrl) ?>" target="_blank" class="btn" style="background:#192742; color:#ffffff; padding:10px; border-radius:4px; font-weight:600; text-align:center; text-decoration:none; margin-top:6px;">
                View Public Department Page
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
