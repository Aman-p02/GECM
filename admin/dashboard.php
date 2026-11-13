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

        $stmtPrin = $pdo->query("SELECT * FROM principal_messages WHERE is_active = 1 LIMIT 1");
        $activePrincipal = $stmtPrin ? $stmtPrin->fetch() : null;
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}
?>

<div class="admin-card" style="text-align: center; padding: 40px 30px; margin-bottom: 24px;">
    <h2 style="font-size: 26px; font-weight: 700; color: #1a263d; margin-bottom: 10px;">GECM Administration Portal</h2>
    <p style="color: #556277; font-size: 15px; max-width: 600px; margin: 0 auto; line-height: 1.6;">
        Welcome to the administration panel. Please select any module from the navigation sidebar or quick modules below to manage website content, notices, events, and campus updates.
    </p>
</div>

<!-- About Modules Quick Cards on Dashboard -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(420px, 1fr)); gap: 20px; margin-bottom: 24px;">
    <!-- Principal Message Quick Card -->
    <div class="admin-card" style="padding: 24px; margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 16px; margin-bottom: 18px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 42px; height: 42px; background: #eff6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #009dff; font-size: 18px;">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #1a263d; margin: 0 0 2px;">Principal's Message</h3>
                    <p style="font-size: 12.5px; color: #64748b; margin: 0;">Current message &amp; archive.</p>
                </div>
            </div>
            <a href="principal-message.php" class="btn btn-primary" style="font-size: 13px; padding: 6px 14px;">
                <i class="fas fa-edit"></i> Manage
            </a>
        </div>

        <?php if ($activePrincipal): ?>
            <div style="display: flex; gap: 16px; align-items: flex-start; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px;">
                <?php if (!empty($activePrincipal['image_url'])): ?>
                    <img src="../<?= htmlspecialchars($activePrincipal['image_url']) ?>" alt="Principal Photo" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1; flex-shrink: 0;">
                <?php endif; ?>
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; flex-wrap: wrap;">
                        <span style="font-size: 14px; font-weight: 700; color: #0c3b6d;"><?= htmlspecialchars($activePrincipal['principal_name']) ?></span>
                        <span style="background: #dcfce7; color: #166534; font-size: 11px; font-weight: 700; padding: 2px 7px; border-radius: 20px;">Active</span>
                    </div>
                    <div style="font-size: 12px; color: #475569; margin-bottom: 6px; font-weight: 600;"><?= htmlspecialchars($activePrincipal['designation']) ?></div>
                    <p style="font-size: 12.5px; color: #334155; line-height: 1.4; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        <?= htmlspecialchars(mb_substr($activePrincipal['message_body'], 0, 180)) ?>...
                    </p>
                </div>
            </div>
        <?php else: ?>
            <p style="color: #64748b; font-size: 13px; margin: 0;">No active principal message set. Click "Manage" to add one.</p>
        <?php endif; ?>
    </div>

    <!-- Mandatory Disclosure & IDP Quick Card -->
    <div class="admin-card" style="padding: 24px; margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 16px; margin-bottom: 18px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 42px; height: 42px; background: #f0fdf4; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #16a34a; font-size: 18px;">
                    <i class="fas fa-file-contract"></i>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #1a263d; margin: 0 0 2px;">Mandatory Disclosures &amp; IDP</h3>
                    <p style="font-size: 12.5px; color: #64748b; margin: 0;">RTI, AICTE, Committees, &amp; IDP 2025-2030.</p>
                </div>
            </div>
            <div style="display: flex; gap: 6px;">
                <a href="idp.php" class="btn btn-secondary" style="font-size: 12px; padding: 6px 10px;">
                    <i class="fas fa-file-pdf"></i> IDP
                </a>
                <a href="mandatory-disclosure.php" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">
                    <i class="fas fa-shield-alt"></i> Disclosures
                </a>
            </div>
        </div>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; font-size: 13px; color: #475569;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; border-bottom: 1px dashed #e2e8f0; padding-bottom: 6px;">
                <span><i class="fas fa-gavel" style="color: #1e90ff; width: 18px;"></i> Statutory Disclosures:</span>
                <strong>RTI, AICTE, Accreditation, Accounts</strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span><i class="fas fa-users-cog" style="color: #16a34a; width: 18px;"></i> Campus Committees:</span>
                <strong>Anti-Ragging, WDC, ICC</strong>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
