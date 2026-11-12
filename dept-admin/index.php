<?php
/**
 * Department Admin Dashboard Overview
 */
$pageTitle = 'Department Dashboard';
$pageHeading = 'Dashboard Overview';
$activeTab = 'dashboard';

require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();

// Fetch metrics strictly for this department
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

<div class="grid-3" style="margin-bottom: 24px;">
    <div class="stat-card">
        <div class="stat-icon" style="background:#eff6ff; color:#2563eb;">
            <i class="fas fa-users-line"></i>
        </div>
        <div class="stat-info">
            <h3><?= $facCount ?></h3>
            <p>Active Faculty Members</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#fef3c7; color:#d97706;">
            <i class="fas fa-calendar-days"></i>
        </div>
        <div class="stat-info">
            <h3><?= $actCount ?></h3>
            <p>Department Activities</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background:#ecfdf5; color:#059669;">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="stat-info">
            <h3><?= $pubCount ?></h3>
            <p>Research Publications</p>
        </div>
    </div>
</div>

<div class="grid-2">
    <div class="admin-card">
        <div class="admin-card-header">
            <h3><i class="fas fa-shield-halved"></i> Department Control Scope</h3>
        </div>
        <div class="admin-card-body">
            <p style="font-size:13.5px; color:#475569; margin-bottom:14px;">
                You are logged in as the official Department Administrator for <strong><?= htmlspecialchars($deptName) ?> (<?= htmlspecialchars($deptCode) ?>)</strong>.
            </p>
            <ul style="font-size:13px; color:#64748b; padding-left:18px; line-height:1.8;">
                <li>Add new faculty profiles so they can claim their account in the Faculty Portal.</li>
                <li>Post and update departmental seminars, workshops, and student achievements.</li>
                <li>Upload research papers published by professors and students.</li>
                <li>Manage the Industry Advisory Board members for your department.</li>
                <li>Publish departmental biannual/annual newsletters (PDF).</li>
            </ul>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
        </div>
        <div class="admin-card-body" style="display:flex; flex-direction:column; gap:10px;">
            <a href="faculty.php?action=add_new" class="btn btn-primary" style="justify-content:flex-start;">
                <i class="fas fa-user-plus"></i> Add New Faculty Member
            </a>
            <a href="activities.php?action=add_new" class="btn btn-outline" style="justify-content:flex-start;">
                <i class="fas fa-calendar-plus"></i> Post Department Activity / Event
            </a>
            <a href="publications.php?action=add_new" class="btn btn-outline" style="justify-content:flex-start;">
                <i class="fas fa-file-circle-plus"></i> Add Research Publication
            </a>
            <a href="<?= htmlspecialchars($livePageUrl) ?>" target="_blank" class="btn btn-navy" style="justify-content:flex-start;">
                <i class="fas fa-globe"></i> View Public Department Page
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

