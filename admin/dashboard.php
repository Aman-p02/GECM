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

<div class="admin-card" style="padding: 28px 24px; margin-bottom: 24px; background: linear-gradient(135deg, #0b1f3a 0%, #1a365d 100%); color: #fff; border-radius: 12px;">
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px;">
        <div>
            <h2 style="font-size: 24px; font-weight: 800; color: #fff; margin: 0 0 6px;">GECM Administration Portal</h2>
            <p style="color: #cbd5e1; font-size: 14px; margin: 0; max-width: 650px; line-height: 1.5;">
                Welcome to the administration panel. Manage institutional website content, cells &amp; initiatives, student/faculty achievements, and department updates.
            </p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="achievements.php" class="btn btn-primary" style="background: #ff8800; border-color: #ff8800; color: #fff; font-weight: 700; padding: 10px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-trophy"></i> Manage Achievements
            </a>
            <a href="cell-activities.php" class="btn btn-secondary" style="background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.25); color: #fff; font-weight: 600; padding: 10px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                <i class="fas fa-rocket"></i> Cells &amp; Initiatives
            </a>
        </div>
    </div>
</div>

<!-- Quick-Access Cards for Cells & Achievements -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 20px; margin-bottom: 24px;">

    <!-- Achievements & Clubs Management Box -->
    <div class="admin-card" style="margin-bottom: 0; padding: 22px; border-top: 4px solid #ff8800;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 8px; background: #fff7ed; color: #ea580c; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fas fa-award"></i>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0;">Achievements &amp; Clubs</h3>
                    <span style="font-size: 12px; color: #64748b;">Accolades, hackathon winners, patents &amp; clubs</span>
                </div>
            </div>
            <a href="achievements.php" class="btn btn-sm btn-primary" style="background: #ff8800; border-color: #ff8800; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 6px; text-decoration: none;">
                + Add / Manage
            </a>
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; padding-top: 14px; border-top: 1px solid #e2e8f0;">
            <a href="achievements.php?category=student_achievements" class="btn btn-sm btn-light" style="font-size: 12px; font-weight: 600; text-decoration: none; border-radius: 6px; padding: 6px 10px;">
                <i class="fas fa-user-graduate" style="color: #ff8800; margin-right: 4px;"></i> Student Achievements
            </a>
            <a href="achievements.php?category=faculty_achievements" class="btn btn-sm btn-light" style="font-size: 12px; font-weight: 600; text-decoration: none; border-radius: 6px; padding: 6px 10px;">
                <i class="fas fa-chalkboard-teacher" style="color: #0284c7; margin-right: 4px;"></i> Faculty Achievements
            </a>
            <a href="achievements.php?category=institute_achievements" class="btn btn-sm btn-light" style="font-size: 12px; font-weight: 600; text-decoration: none; border-radius: 6px; padding: 6px 10px;">
                <i class="fas fa-university" style="color: #16a34a; margin-right: 4px;"></i> Institute Achievements
            </a>
            <a href="achievements.php?category=patents" class="btn btn-sm btn-light" style="font-size: 12px; font-weight: 600; text-decoration: none; border-radius: 6px; padding: 6px 10px;">
                <i class="fas fa-lightbulb" style="color: #ca8a04; margin-right: 4px;"></i> Patents
            </a>
            <a href="achievements.php?category=technopreneur_club" class="btn btn-sm btn-light" style="font-size: 12px; font-weight: 600; text-decoration: none; border-radius: 6px; padding: 6px 10px;">
                <i class="fas fa-users" style="color: #7c3aed; margin-right: 4px;"></i> Technopreneur Club
            </a>
        </div>
    </div>

    <!-- Cells & Initiatives Management Box -->
    <div class="admin-card" style="margin-bottom: 0; padding: 22px; border-top: 4px solid #0284c7;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 8px; background: #f0f9ff; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fas fa-rocket"></i>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0;">Cells &amp; Initiatives</h3>
                    <span style="font-size: 12px; color: #64748b;">SSIP, DIC, RUSA, Gymkhana, WDC, Anchor Nodal</span>
                </div>
            </div>
            <a href="cell-activities.php" class="btn btn-sm btn-primary" style="background: #0284c7; border-color: #0284c7; font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 6px; text-decoration: none;">
                + Add / Manage
            </a>
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; padding-top: 14px; border-top: 1px solid #e2e8f0;">
            <a href="cell-activities.php?category=ssip" class="btn btn-sm btn-light" style="font-size: 12px; font-weight: 600; text-decoration: none; border-radius: 6px; padding: 6px 10px;">
                SSIP &amp; DIC
            </a>
            <a href="cell-activities.php?category=rusa" class="btn btn-sm btn-light" style="font-size: 12px; font-weight: 600; text-decoration: none; border-radius: 6px; padding: 6px 10px;">
                RUSA Grants
            </a>
            <a href="cell-activities.php?category=gymkhana" class="btn btn-sm btn-light" style="font-size: 12px; font-weight: 600; text-decoration: none; border-radius: 6px; padding: 6px 10px;">
                Gymkhana
            </a>
            <a href="cell-activities.php?category=finishing_school" class="btn btn-sm btn-light" style="font-size: 12px; font-weight: 600; text-decoration: none; border-radius: 6px; padding: 6px 10px;">
                Finishing School
            </a>
            <a href="cell-activities.php?category=wdc" class="btn btn-sm btn-light" style="font-size: 12px; font-weight: 600; text-decoration: none; border-radius: 6px; padding: 6px 10px;">
                WDC &amp; UBA
            </a>
            <a href="cell-activities.php?category=anchor_nodal" class="btn btn-sm btn-light" style="font-size: 12px; font-weight: 600; text-decoration: none; border-radius: 6px; padding: 6px 10px;">
                Anchor Nodal
            </a>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
