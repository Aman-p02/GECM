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

<!-- Clean Admin Card: Pending Requests -->
<div class="admin-card" style="margin-bottom: 28px;">
    <div class="card-top" style="background:#ffffff; border-bottom:1px solid #e5e9f0; padding:16px 24px;">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:36px; height:36px; border-radius:8px; background:#fef3c7; color:#d97706; display:flex; align-items:center; justify-content:center; font-size:16px;">
                <i class="fas fa-user-clock"></i>
            </div>
            <div>
                <h2 style="font-size:17px; font-weight:700; color:#1a263d; margin:0;">Pending Registration Requests</h2>
                <p style="font-size:12.5px; color:#64748b; margin-top:2px;">Department coordinators waiting for Super Admin approval</p>
            </div>
        </div>
        <div>
            <?php if (count($pendingRequests) > 0): ?>
                <span style="background:#ef4444; color:#ffffff; font-size:12px; font-weight:700; padding:4px 12px; border-radius:20px; letter-spacing:0.3px;">
                    <?= count($pendingRequests) ?> PENDING
                </span>
            <?php else: ?>
                <span style="background:#ecfdf5; color:#059669; font-size:12px; font-weight:600; padding:4px 12px; border-radius:20px;">
                    All Caught Up
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="table-responsive">
        <?php if (empty($pendingRequests)): ?>
            <div style="text-align:center; padding:48px 20px; color:#64748b;">
                <div style="width:54px; height:54px; border-radius:50%; background:#ecfdf5; color:#10b981; display:inline-flex; align-items:center; justify-content:center; font-size:22px; margin-bottom:12px;">
                    <i class="fas fa-check"></i>
                </div>
                <h4 style="font-size:15px; font-weight:600; color:#1a263d;">No Pending Requests</h4>
                <p style="font-size:13px; color:#94a3b8; margin-top:4px;">All department admin registration requests have been processed.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 140px;">Request Date</th>
                        <th style="width: 160px;">Department</th>
                        <th>Applicant Details</th>
                        <th>Email &amp; Username</th>
                        <th style="width: 180px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pendingRequests as $r): ?>
                        <tr>
                            <td>
                                <div style="font-weight:600; color:#1a263d; font-size:13px;"><?= date('d M Y', strtotime($r['created_at'])) ?></div>
                                <div style="font-size:11.5px; color:#94a3b8;"><?= date('h:i A', strtotime($r['created_at'])) ?></div>
                            </td>
                            <td>
                                <span style="background:#eff6ff; color:#1e40af; border:1px solid #bfdbfe; font-size:12px; font-weight:700; padding:3px 10px; border-radius:6px; display:inline-block;">
                                    <?= htmlspecialchars($r['dept_code']) ?>
                                </span>
                                <div style="font-size:11.5px; color:#64748b; margin-top:3px;"><?= htmlspecialchars($deptLabels[$r['dept_code']] ?? '') ?></div>
                            </td>
                            <td>
                                <div style="font-size:14px; font-weight:700; color:#0f172a;"><?= htmlspecialchars($r['full_name']) ?></div>
                                <div style="font-size:12px; color:#64748b;"><?= htmlspecialchars($r['designation'] ?? 'Department Coordinator') ?></div>
                            </td>
                            <td>
                                <div style="font-size:13px; color:#334155; display:flex; align-items:center; gap:6px;">
                                    <i class="fas fa-envelope" style="color:#94a3b8; font-size:11px;"></i> <?= htmlspecialchars($r['email']) ?>
                                </div>
                                <div style="font-size:12px; color:#64748b; margin-top:2px; display:flex; align-items:center; gap:6px;">
                                    <i class="fas fa-user" style="color:#94a3b8; font-size:11px;"></i> @<?= htmlspecialchars($r['username']) ?>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <form method="POST" action="dept-approvals.php" style="display:inline-flex; gap:8px;">
                                    <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                                    <button type="submit" name="action" value="approve" class="btn" style="background:#10b981; color:#ffffff; font-size:12.5px; font-weight:600; padding:6px 14px; border-radius:6px; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:background 0.15s ease;" onclick="return confirm('Approve <?= htmlspecialchars($r['full_name']) ?> as Department Admin for <?= htmlspecialchars($r['dept_code']) ?>?');">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button type="submit" name="action" value="reject" class="btn" style="background:#ffffff; color:#dc2626; border:1px solid #fecaca; font-size:12.5px; font-weight:600; padding:6px 12px; border-radius:6px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:all 0.15s ease;" onclick="return confirm('Reject this registration request?');">
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

<!-- Clean Admin Card: Registered Department Admins -->
<div class="admin-card">
    <div class="card-top" style="background:#ffffff; border-bottom:1px solid #e5e9f0; padding:16px 24px;">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:36px; height:36px; border-radius:8px; background:#eff6ff; color:#1e88e5; display:flex; align-items:center; justify-content:center; font-size:16px;">
                <i class="fas fa-users-gear"></i>
            </div>
            <div>
                <h2 style="font-size:17px; font-weight:700; color:#1a263d; margin:0;">Department Administrators Directory</h2>
                <p style="font-size:12.5px; color:#64748b; margin-top:2px;">Approved administrators managing respective departmental sections</p>
            </div>
        </div>
        <div>
            <span style="font-size:13px; font-weight:600; color:#64748b;">
                Total: <?= count($approvedAdmins) ?> Admins
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <?php if (empty($approvedAdmins)): ?>
            <div style="text-align:center; padding:48px 20px; color:#64748b;">
                <div style="width:54px; height:54px; border-radius:50%; background:#f1f5f9; color:#94a3b8; display:inline-flex; align-items:center; justify-content:center; font-size:22px; margin-bottom:12px;">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h4 style="font-size:15px; font-weight:600; color:#1a263d;">No Registered Admins Yet</h4>
                <p style="font-size:13px; color:#94a3b8; margin-top:4px;">When applicants are approved, their records will appear here.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 140px;">Department</th>
                        <th>Administrator Name</th>
                        <th>Contact / Username</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 140px;">Approved On</th>
                        <th style="width: 130px; text-align: right;">Access Control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($approvedAdmins as $a): ?>
                        <tr>
                            <td>
                                <span style="background:#eff6ff; color:#1e40af; border:1px solid #bfdbfe; font-size:12px; font-weight:700; padding:3px 10px; border-radius:6px; display:inline-block;">
                                    <?= htmlspecialchars($a['dept_code']) ?>
                                </span>
                                <div style="font-size:11.5px; color:#64748b; margin-top:3px;"><?= htmlspecialchars($deptLabels[$a['dept_code']] ?? '') ?></div>
                            </td>
                            <td>
                                <div style="font-size:14px; font-weight:700; color:#0f172a;"><?= htmlspecialchars($a['full_name']) ?></div>
                                <div style="font-size:12px; color:#64748b;"><?= htmlspecialchars($a['designation'] ?? 'Department Admin') ?></div>
                            </td>
                            <td>
                                <div style="font-size:13px; color:#334155;"><?= htmlspecialchars($a['email']) ?></div>
                                <div style="font-size:12px; color:#64748b; margin-top:2px;">@<?= htmlspecialchars($a['username']) ?></div>
                            </td>
                            <td>
                                <?php if ($a['status'] === 'approved'): ?>
                                    <?php if (!empty($a['is_active'])): ?>
                                        <span style="background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; padding:3px 10px; border-radius:12px; font-size:11.5px; font-weight:600; display:inline-flex; align-items:center; gap:5px;">
                                            <i class="fas fa-circle-check"></i> Active
                                        </span>
                                    <?php else: ?>
                                        <span style="background:#fef2f2; color:#991b1b; border:1px solid #fecaca; padding:3px 10px; border-radius:12px; font-size:11.5px; font-weight:600; display:inline-flex; align-items:center; gap:5px;">
                                            <i class="fas fa-ban"></i> Suspended
                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span style="background:#f1f5f9; color:#64748b; border:1px solid #cbd5e1; padding:3px 10px; border-radius:12px; font-size:11.5px; font-weight:600;">
                                        Rejected
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="font-size:13px; color:#334155;">
                                    <?= !empty($a['approved_at']) ? date('d M Y', strtotime($a['approved_at'])) : '-' ?>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <form method="POST" action="dept-approvals.php">
                                    <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                                    <input type="hidden" name="action" value="toggle_active">
                                    <?php if (!empty($a['is_active'])): ?>
                                        <button type="submit" class="btn" style="background:#ffffff; color:#dc2626; border:1px solid #fecaca; font-size:11.5px; font-weight:600; padding:5px 12px; border-radius:6px; cursor:pointer;" title="Temporarily revoke login access">
                                            Suspend
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="btn" style="background:#10b981; color:#ffffff; font-size:11.5px; font-weight:600; padding:5px 12px; border-radius:6px; border:none; cursor:pointer;" title="Restore login access">
                                            Reactivate
                                        </button>
                                    <?php endif; ?>
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
