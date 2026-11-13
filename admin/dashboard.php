<?php
$current_page = 'dashboard';
$page_title = 'Dashboard Overview';
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();

// Fetch summary counts
$totalNotices = 0;
$totalEvents = 0;
$totalShots = 0;
$totalAlumni = 0;
$totalDepts = 0;
$totalSlides = 0;
$departments = [];
$recentNotices = [];

if ($pdo) {
    try {
        $totalNotices = (int)$pdo->query("SELECT COUNT(*) FROM notices")->fetchColumn();
        $totalEvents = (int)$pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
        $totalShots = (int)$pdo->query("SELECT COUNT(*) FROM latest_shots")->fetchColumn();
        $totalAlumni = (int)$pdo->query("SELECT COUNT(*) FROM alumni")->fetchColumn();
        $totalDepts = (int)$pdo->query("SELECT COUNT(*) FROM departments")->fetchColumn();
        $totalSlides = (int)$pdo->query("SELECT COUNT(*) FROM hero_slides")->fetchColumn();

        $stmtDept = $pdo->query("SELECT * FROM departments ORDER BY display_order ASC");
        $departments = $stmtDept->fetchAll();

        $stmtRecent = $pdo->query("SELECT * FROM notices ORDER BY publish_date DESC, id DESC LIMIT 5");
        $recentNotices = $stmtRecent->fetchAll();
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}
?>

<div class="admin-card" style="text-align: center; padding: 40px 30px; margin-bottom: 24px;">
    <h2 style="font-size: 26px; font-weight: 700; color: #1a263d; margin-bottom: 10px;">GECM Administration Portal</h2>
    <p style="color: #556277; font-size: 15px; max-width: 600px; margin: 0 auto; line-height: 1.6;">
        Welcome to the administration panel. Please select any module from the navigation sidebar to manage website content, notices, events, and campus updates.
    </p>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
