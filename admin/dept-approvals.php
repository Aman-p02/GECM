<?php
/**
 * Super Admin - Department Admin Requests & Approvals
 */
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$current_page = 'dept-approvals';
$page_title = 'Department Admin Approvals';

// Handle Actions (Approve / Reject / Toggle Active)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    $action = $_POST['action'] ?? '';
    $adminId = (int)($_POST['id'] ?? 0);
    $superAdminId = $_SESSION['admin_id'] ?? 1;

    if ($adminId > 0) {
        try {
            if ($action === 'approve') {
                $stmt = $pdo->prepare("UPDATE dept_admins SET status = 'approved', approved_by = ?, approved_at = NOW(), is_active = 1 WHERE id = ?");
                $stmt->execute([$superAdminId, $adminId]);
                setFlashMessage('success', 'Department Admin approved successfully! They can now log in to their department portal.');
            } elseif ($action === 'reject') {
                $stmt = $pdo->prepare("UPDATE dept_admins SET status = 'rejected', approved_by = ?, approved_at = NOW() WHERE id = ?");
                $stmt->execute([$superAdminId, $adminId]);
                setFlashMessage('danger', 'Registration request rejected.');
            } elseif ($action === 'toggle_active') {
                $stmt = $pdo->prepare("UPDATE dept_admins SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
                $stmt->execute([$adminId]);
                setFlashMessage('info', 'Status updated.');
            }
            header('Location: dept-approvals.php');
            exit;
        } catch (Exception $e) {
            setFlashMessage('danger', 'Action failed: ' . $e->getMessage());
        }
    }
}

// Fetch pending and approved dept admins
$pendingRequests = [];
$approvedAdmins = [];
if ($pdo) {
    try {
        $pStmt = $pdo->query("SELECT * FROM dept_admins WHERE status = 'pending' ORDER BY created_at DESC");
        $pendingRequests = $pStmt->fetchAll(PDO::FETCH_ASSOC);

        $aStmt = $pdo->query("SELECT * FROM dept_admins WHERE status != 'pending' ORDER BY dept_code ASC, created_at DESC");
        $approvedAdmins = $aStmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {}
}

$deptLabels = [
    'CE'    => 'Computer Engineering',
    'IT'    => 'Information Technology',
    'ME'    => 'Mechanical Engineering',
    'CIVIL' => 'Civil Engineering',
    'EE'    => 'Electrical Engineering',
    'EC'    => 'Electronics & Communication',
    'AE'    => 'Automobile Engineering',
    'AM'    => 'Applied Mechanics',
    'SH'    => 'Science & Humanities'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- Pending Registration Requests -->
<div class="admin-card" style="margin-bottom: 30px;">
    <div class="admin-card-header" style="background:#fffbeb; border-bottom:1px solid #fde68a;">
        <h3 style="color:#92400e; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-bell"></i>
            Pending Department Admin Requests (<?= count($pendingRequests) ?>)
        </h3>
    </div>

    <div class="table-responsive">
        <?php if (empty($pendingRequests)): ?>
            <div style="text-align:center; padding:35px 20px; color:#64748b;">
                <i class="fas fa-circle-check" style="font-size:36px; color:#10b981; margin-bottom:10px;"></i>
                <p>No pending department admin requests at this time.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Department</th>
                        <th>Applicant Name</th>
                        <th>Designation</th>
                        <th>Email & Username</th>
                        <th style="width:200px; text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pendingRequests as $r): ?>
                        <tr>
                            <td><?= date('d M Y, h:i A', strtotime($r['created_at'])) ?></td>
                            <td>
                                <strong style="color:#2563eb;"><?= htmlspecialchars($r['dept_code']) ?></strong>
                                <div style="font-size:11px; color:#64748b;"><?= htmlspecialchars($deptLabels[$r['dept_code']] ?? '') ?></div>
                            </td>
                            <td><strong><?= htmlspecialchars($r['full_name']) ?></strong></td>
                            <td><?= htmlspecialchars($r['designation'] ?? '-') ?></td>
                            <td>
                                <div><i class="fas fa-envelope" style="color:#94a3b8; font-size:11px;"></i> <?= htmlspecialchars($r['email']) ?></div>
                                <div style="font-size:11.5px; color:#64748b;"><i class="fas fa-user" style="color:#94a3b8; font-size:11px;"></i> @<?= htmlspecialchars($r['username']) ?></div>
                            </td>
                            <td style="text-align:right;">
                                <form method="POST" action="dept-approvals.php" style="display:inline-flex; gap:6px;">
                                    <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                                    <button type="submit" name="action" value="approve" class="btn btn-sm" style="background:#10b981; color:#fff; border:none; padding:5px 10px; border-radius:6px; cursor:pointer;" onclick="return confirm('Approve this user as Department Admin for <?= htmlspecialchars($r['dept_code']) ?>?');">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button type="submit" name="action" value="reject" class="btn btn-sm" style="background:#ef4444; color:#fff; border:none; padding:5px 10px; border-radius:6px; cursor:pointer;" onclick="return confirm('Reject this registration request?');">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- All Department Admins (Approved / Rejected) -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-users-gear"></i> Department Administrators Directory (<?= count($approvedAdmins) ?>)</h3>
    </div>

    <div class="table-responsive">
        <?php if (empty($approvedAdmins)): ?>
            <div style="text-align:center; padding:35px 20px; color:#64748b;">
                <p>No department administrators registered yet.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Admin Name</th>
                        <th>Email / Username</th>
                        <th>Status</th>
                        <th>Approved On</th>
                        <th style="width:120px; text-align:right;">Toggle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($approvedAdmins as $a): ?>
                        <tr>
                            <td>
                                <strong style="color:#2563eb;"><?= htmlspecialchars($a['dept_code']) ?></strong>
                                <div style="font-size:11px; color:#64748b;"><?= htmlspecialchars($deptLabels[$a['dept_code']] ?? '') ?></div>
                            </td>
                            <td>
                                <strong><?= htmlspecialchars($a['full_name']) ?></strong>
                                <?php if (!empty($a['designation'])): ?>
                                    <div style="font-size:11.5px; color:#64748b;"><?= htmlspecialchars($a['designation']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div><?= htmlspecialchars($a['email']) ?></div>
                                <div style="font-size:11.5px; color:#64748b;">@<?= htmlspecialchars($a['username']) ?></div>
                            </td>
                            <td>
                                <?php if ($a['status'] === 'approved'): ?>
                                    <?php if (!empty($a['is_active'])): ?>
                                        <span class="badge badge-success" style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; padding:2px 8px; border-radius:12px; font-size:11px; font-weight:600;">
                                            <i class="fas fa-check"></i> Active
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-danger" style="background:#fef2f2; color:#991b1b; border:1px solid #fecaca; padding:2px 8px; border-radius:12px; font-size:11px; font-weight:600;">
                                            Deactivated
                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge badge-secondary" style="background:#f1f5f9; color:#64748b; border:1px solid #cbd5e1; padding:2px 8px; border-radius:12px; font-size:11px; font-weight:600;">
                                        Rejected
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= !empty($a['approved_at']) ? date('d M Y', strtotime($a['approved_at'])) : '-' ?>
                            </td>
                            <td style="text-align:right;">
                                <form method="POST" action="dept-approvals.php">
                                    <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                                    <input type="hidden" name="action" value="toggle_active">
                                    <button type="submit" class="btn btn-sm btn-outline" style="font-size:11px; padding:3px 8px;">
                                        <?= !empty($a['is_active']) ? 'Deactivate' : 'Activate' ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
