<?php
$current_page = 'hostel-confirmation';
$page_title = 'Hostel Room Allotment & Confirmation';
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();

// 1. Handle Confirm Admission POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'confirm_student') {
        $id = (int)($_POST['id'] ?? 0);
        $refNo = strtoupper(trim($_POST['reference_no'] ?? ''));
        $room = trim($_POST['hostel_room'] ?? '');

        if ($id > 0 && !empty($room) && $pdo) {
            try {
                $stmt = $pdo->prepare("UPDATE allocation_list SET reference_no = ?, hostel_room = ?, status = 'Confirm' WHERE id = ?");
                $stmt->execute([$refNo, $room, $id]);
                setFlashMessage('success', "Student #{$id} confirmed with Room #{$room} successfully!");
            } catch (Exception $e) {
                setFlashMessage('danger', 'Confirmation failed: ' . $e->getMessage());
            }
        } else {
            setFlashMessage('danger', 'Please provide a valid Room Number.');
        }
    } elseif ($_POST['action'] === 'cancel_student') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0 && $pdo) {
            try {
                $stmt = $pdo->prepare("UPDATE allocation_list SET status = 'Cancelled' WHERE id = ?");
                $stmt->execute([$id]);
                setFlashMessage('info', "Allocation for student #{$id} has been cancelled.");
            } catch (Exception $e) {
                setFlashMessage('danger', 'Cancellation failed: ' . $e->getMessage());
            }
        }
    } elseif ($_POST['action'] === 'auto_cancel_expired') {
        if ($pdo) {
            try {
                $stmt = $pdo->exec("UPDATE allocation_list SET status = 'Cancelled' WHERE status = 'pending' AND reporting_deadline < CURDATE()");
                setFlashMessage('success', "Auto-cancelled expired pending allocations past deadline.");
            } catch (Exception $e) {
                setFlashMessage('danger', 'Auto-cancellation error: ' . $e->getMessage());
            }
        }
    }
    header('Location: hostel-confirmation.php');
    exit;
}

// 2. Fetch Allocated Students
$search = trim($_GET['search'] ?? '');
$statusFilter = trim($_GET['status'] ?? 'pending');
$blockFilter = trim($_GET['block'] ?? '');

$where = [];
$params = [];

if (!empty($search)) {
    $where[] = "(student_name LIKE ? OR acpc_merit_rank LIKE ? OR hostel_room LIKE ? OR reference_no LIKE ?)";
    $like = "%$search%";
    $params = array_merge($params, [$like, $like, $like, $like]);
}

if (!empty($statusFilter)) {
    $where[] = "status = ?";
    $params[] = $statusFilter;
}

if (!empty($blockFilter)) {
    $where[] = "hostel_block = ?";
    $params[] = $blockFilter;
}

$whereSql = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$allocations = [];
if ($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM allocation_list $whereSql ORDER BY reporting_deadline ASC, id ASC");
        $stmt->execute($params);
        $allocations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}
?>

<div class="admin-fade-in">

    <!-- Header Banner -->
    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px 24px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">Hostel Room Allotment Desk</h2>
            <p style="font-size: 0.86rem; color: #64748b; margin: 0;">Assign room numbers to shortlisted students upon physical reporting and fee receipt verification.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <form method="POST" action="hostel-confirmation.php" onsubmit="return confirm('Auto-cancel all pending allocations whose reporting deadline has passed?');">
                <input type="hidden" name="action" value="auto_cancel_expired">
                <button type="submit" class="btn btn-secondary" style="font-weight: 700; font-size: 0.84rem; padding: 8px 14px; border-radius: 6px; color: #b91c1c;">
                    <i class="fas fa-calendar-times"></i> Cancel Expired Deadlines
                </button>
            </form>
            <a href="hostel-allocation.php" class="btn btn-primary" style="background: #ff8800; border-color: #ff8800; color: #fff; font-weight: 700; font-size: 0.84rem; padding: 8px 16px; border-radius: 6px; text-decoration: none;">
                <i class="fas fa-plus"></i> Run New Allocation
            </a>
        </div>
    </div>

    <!-- Filter Strip -->
    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 16px 20px; margin-bottom: 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.03);">
        <form method="GET" action="hostel-confirmation.php" style="display: grid; grid-template-columns: 2fr 1fr 1fr auto auto; gap: 12px; align-items: end;">
            <div>
                <label style="font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 4px; display: block;">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search student, ACPC rank, room, ref no..." value="<?= htmlspecialchars($search) ?>" style="font-size: 0.88rem; height: 38px;">
            </div>

            <div>
                <label style="font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 4px; display: block;">Status</label>
                <select name="status" class="form-control" style="font-size: 0.88rem; height: 38px;">
                    <option value="">All Statuses</option>
                    <option value="pending" <?= ($statusFilter === 'pending') ? 'selected' : '' ?>>Pending Reporting</option>
                    <option value="Confirm" <?= ($statusFilter === 'Confirm') ? 'selected' : '' ?>>Confirmed</option>
                    <option value="Cancelled" <?= ($statusFilter === 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>

            <div>
                <label style="font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 4px; display: block;">Block</label>
                <input type="text" name="block" class="form-control" placeholder="e.g. A Block" value="<?= htmlspecialchars($blockFilter) ?>" style="font-size: 0.88rem; height: 38px;">
            </div>

            <button type="submit" class="btn btn-primary" style="background: #0f172a; border-color: #0f172a; color: #fff; height: 38px; padding: 0 18px; font-weight: 700; font-size: 0.88rem;">
                <i class="fas fa-filter"></i> Filter
            </button>

            <?php if (!empty($search) || $statusFilter !== 'pending' || !empty($blockFilter)): ?>
                <a href="hostel-confirmation.php" class="btn btn-secondary" style="height: 38px; display: flex; align-items: center; justify-content: center; padding: 0 14px; font-size: 0.88rem; text-decoration: none;">
                    Reset
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Allocation List Table -->
    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.76rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <th style="padding: 14px 16px;">Student</th>
                        <th style="padding: 14px 16px;">Branch &amp; Rank</th>
                        <th style="padding: 14px 16px;">Block &amp; Round</th>
                        <th style="padding: 14px 16px;">Reporting Deadline</th>
                        <th style="padding: 14px 16px;">Room Number</th>
                        <th style="padding: 14px 16px;">Status</th>
                        <th style="padding: 14px 16px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($allocations)): ?>
                        <tr>
                            <td colspan="7" style="padding: 36px; text-align: center; color: #94a3b8;">
                                <i class="fas fa-bed" style="font-size: 2rem; margin-bottom: 10px; color: #cbd5e1;"></i>
                                <p style="margin: 0; font-size: 0.92rem;">No student allocations found matching this filter.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($allocations as $row): 
                            $isExpired = ($row['status'] === 'pending' && !empty($row['reporting_deadline']) && strtotime($row['reporting_deadline']) < strtotime(date('Y-m-d')));
                        ?>
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#ffffff'">
                                <td style="padding: 13px 16px;">
                                    <div style="font-weight: 700; color: #0f172a;"><?= htmlspecialchars($row['student_name']) ?></div>
                                    <div style="font-size: 0.78rem; color: #64748b;">ID: #<?= $row['id'] ?> &bull; Contact: <?= htmlspecialchars($row['contact_number']) ?></div>
                                </td>
                                <td style="padding: 13px 16px;">
                                    <span style="font-weight: 700; color: #1e293b;"><?= htmlspecialchars($row['branch']) ?></span>
                                    <span style="font-size: 0.78rem; color: #64748b; display: block;">Rank: <?= htmlspecialchars($row['acpc_merit_rank']) ?></span>
                                </td>
                                <td style="padding: 13px 16px;">
                                    <span style="font-weight: 700; color: #0f172a;"><?= htmlspecialchars($row['hostel_block']) ?></span>
                                    <span style="font-size: 0.78rem; color: #ff8800; display: block;">Round <?= (int)$row['round'] ?></span>
                                </td>
                                <td style="padding: 13px 16px;">
                                    <span style="font-weight: 600; color: <?= $isExpired ? '#dc2626' : '#1e293b' ?>;">
                                        <?= htmlspecialchars($row['reporting_deadline'] ?? 'N/A') ?>
                                    </span>
                                    <?php if ($isExpired): ?>
                                        <span style="display: block; font-size: 0.74rem; font-weight: 800; color: #dc2626;">EXPIRED</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 13px 16px;">
                                    <?php if (!empty($row['hostel_room'])): ?>
                                        <span style="font-size: 0.95rem; font-weight: 800; color: #047857; background: #ecfdf5; border: 1px solid #a7f3d0; padding: 4px 10px; border-radius: 6px;">
                                            Room <?= htmlspecialchars($row['hostel_room']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: #94a3b8; font-style: italic;">Not assigned</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 13px 16px;">
                                    <?php if ($row['status'] === 'Confirm'): ?>
                                        <span style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 3px 8px; border-radius: 6px; font-size: 0.76rem; font-weight: 800;">CONFIRMED</span>
                                    <?php elseif ($row['status'] === 'Cancelled'): ?>
                                        <span style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 3px 8px; border-radius: 6px; font-size: 0.76rem; font-weight: 800;">CANCELLED</span>
                                    <?php else: ?>
                                        <span style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a; padding: 3px 8px; border-radius: 6px; font-size: 0.76rem; font-weight: 800;">PENDING</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 13px 16px; text-align: right;">
                                    <?php if ($row['status'] === 'pending'): ?>
                                        <button type="button" class="btn btn-sm btn-primary" style="background: #047857; border-color: #047857; color: #fff; font-weight: 700; padding: 5px 12px; border-radius: 6px; font-size: 0.82rem;" onclick="openConfirmModal(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>)">
                                            <i class="fas fa-key"></i> Allot Room
                                        </button>
                                        <form method="POST" action="hostel-confirmation.php" style="display: inline;" onsubmit="return confirm('Cancel allocation for <?= htmlspecialchars($row['student_name']) ?>?');">
                                            <input type="hidden" name="action" value="cancel_student">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <button type="submit" class="btn btn-sm" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 5px 8px; border-radius: 6px; margin-left: 4px;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-sm" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 5px 10px; border-radius: 6px; font-size: 0.80rem;" onclick="openConfirmModal(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>)">
                                            <i class="fas fa-edit"></i> Edit Room
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Room Allotment Modal -->
<div id="allotModal" style="display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; width: 100%; max-width: 480px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); overflow: hidden;">
        <form method="POST" action="hostel-confirmation.php">
            <input type="hidden" name="action" value="confirm_student">
            <input type="hidden" name="id" id="allotStudentId">

            <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
                <h4 style="margin: 0; font-size: 1.10rem; font-weight: 800; color: #0f172a;" id="allotModalTitle">Allot Hostel Room</h4>
                <button type="button" onclick="closeAllotModal()" style="border: none; background: transparent; font-size: 1.4rem; color: #64748b; cursor: pointer;">&times;</button>
            </div>

            <div style="padding: 22px 24px; display: flex; flex-direction: column; gap: 14px;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 14px;">
                    <div style="font-weight: 700; color: #0f172a;" id="allotStudentName">Student Name</div>
                    <div style="font-size: 0.80rem; color: #64748b; margin-top: 2px;" id="allotStudentDetails">Branch &amp; Block</div>
                </div>

                <div>
                    <label style="font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 5px; display: block;">Hostel Room Number <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="hostel_room" id="allotRoomNo" class="form-control" placeholder="e.g. 104, 212" required style="font-size: 0.95rem; height: 42px;">
                </div>

                <div>
                    <label style="font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 5px; display: block;">Office Fee Reference Number (Optional)</label>
                    <input type="text" name="reference_no" id="allotRefNo" class="form-control" placeholder="e.g. REC2024-8849" style="font-size: 0.95rem; height: 42px;">
                </div>
            </div>

            <div style="padding: 14px 24px; border-top: 1px solid #e2e8f0; text-align: right; background: #f8fafc; display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeAllotModal()" class="btn btn-secondary" style="padding: 6px 16px; font-size: 0.88rem;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: #047857; border-color: #047857; color: #fff; padding: 6px 20px; font-weight: 700; font-size: 0.88rem;">
                    Confirm &amp; Allot Room
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openConfirmModal(row) {
    document.getElementById('allotStudentId').value = row.id;
    document.getElementById('allotStudentName').textContent = row.student_name;
    document.getElementById('allotStudentDetails').textContent = row.branch + ' (Sem ' + row.current_sem + ') • ' + row.hostel_block;
    document.getElementById('allotRoomNo').value = row.hostel_room || '';
    document.getElementById('allotRefNo').value = row.reference_no || '';

    document.getElementById('allotModal').style.display = 'flex';
}

function closeAllotModal() {
    document.getElementById('allotModal').style.display = 'none';
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
