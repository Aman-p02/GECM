<?php
$activeTab = 'grievances';
$pageTitle = 'Department Grievances';
$pageHeading = 'Department Grievances';

require_once __DIR__ . '/includes/header.php';
$pdo = getDBConnection();

// Self-healing database table setup
if ($pdo) {
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `student_grievances` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `ticket_number` VARCHAR(30) UNIQUE NOT NULL,
            `full_name` VARCHAR(255) NOT NULL,
            `enrollment_faculty_id` VARCHAR(100) NOT NULL,
            `contact_number` VARCHAR(25) NOT NULL,
            `gender` VARCHAR(20) NOT NULL,
            `category` VARCHAR(50) NOT NULL,
            `father_name` VARCHAR(255) NOT NULL,
            `semester` VARCHAR(50) NOT NULL,
            `branch` VARCHAR(100) NOT NULL,
            `dept_code` VARCHAR(20) NOT NULL,
            `grievance_category` VARCHAR(100) NOT NULL,
            `grievance_description` TEXT NOT NULL,
            `status` VARCHAR(30) NOT NULL DEFAULT 'Pending',
            `admin_remarks` TEXT NULL,
            `resolved_at` DATETIME NULL,
            `ip_address` VARCHAR(45) NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_dept_status` (`dept_code`, `status`, `created_at`),
            INDEX `idx_ticket` (`ticket_number`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    } catch (Exception $e) {
        error_log("Grievance table check error: " . $e->getMessage());
    }
}

// Handle Status & Remarks Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    if (!$pdo) {
        setDeptFlash('danger', 'Database connection offline.');
        header('Location: grievances.php');
        exit;
    }

    $id = (int)($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? 'Pending');
    $remarks = trim($_POST['admin_remarks'] ?? '');

    $allowedStatuses = ['Pending', 'Under Review', 'Resolved', 'Rejected'];
    if (!in_array($status, $allowedStatuses)) {
        $status = 'Pending';
    }

    if ($id > 0) {
        // Enforce strict department isolation: only update if grievance belongs to logged in dept
        $stmt = $pdo->prepare("UPDATE student_grievances 
            SET status = ?, admin_remarks = ?, resolved_at = IF(? = 'Resolved', NOW(), resolved_at) 
            WHERE id = ? AND dept_code = ?");
        $stmt->execute([$status, $remarks, $status, $id, $deptCode]);

        setDeptFlash('success', 'Grievance ticket status and remarks updated successfully.');
    }
    header('Location: grievances.php');
    exit;
}

// Fetch Grievances for logged in department only
$statusFilter = trim($_GET['status'] ?? '');
$records = [];
$counts = [
    'Total' => 0,
    'Pending' => 0,
    'Under Review' => 0,
    'Resolved' => 0,
    'Rejected' => 0
];

if ($pdo) {
    try {
        // Counts for tabs
        $cStmt = $pdo->prepare("SELECT status, COUNT(*) as cnt FROM student_grievances WHERE dept_code = ? GROUP BY status");
        $cStmt->execute([$deptCode]);
        $rows = $cStmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $r) {
            $counts['Total'] += (int)$r['cnt'];
            if (isset($counts[$r['status']])) {
                $counts[$r['status']] = (int)$r['cnt'];
            }
        }

        // Fetch records
        if (!empty($statusFilter)) {
            $stmt = $pdo->prepare("SELECT * FROM student_grievances WHERE dept_code = ? AND status = ? ORDER BY created_at DESC");
            $stmt->execute([$deptCode, $statusFilter]);
        } else {
            $stmt = $pdo->prepare("SELECT * FROM student_grievances WHERE dept_code = ? ORDER BY created_at DESC");
            $stmt->execute([$deptCode]);
        }
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $records = [];
    }
}
?>

<div class="clean-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">

    <!-- Header info banner -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-bottom: 22px;">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">
                <?= htmlspecialchars($deptName) ?> Grievances
            </h2>
            <p style="font-size: 13px; color: #64748b; margin: 0;">
                Showing student and faculty grievances routed specifically to the <?= htmlspecialchars($deptCode) ?> department administration.
            </p>
        </div>

        <a href="../student-corner/grievance-portal" target="_blank" class="btn btn-secondary btn-sm" style="font-size: 13px; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; padding: 6px 12px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f8fafc; color: #334155;">
            <i class="fas fa-external-link-alt"></i> Open Public Form
        </a>
    </div>

    <!-- Status Filter Buttons & Search -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-bottom: 20px;">
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a href="grievances.php" class="btn btn-sm" style="text-decoration: none; border-radius: 20px; padding: 5px 14px; font-size: 12.5px; font-weight: 600; <?= empty($statusFilter) ? 'background: #ff8800; color: #ffffff;' : 'background: #f1f5f9; color: #475569;' ?>">
                All (<?= $counts['Total'] ?>)
            </a>
            <a href="grievances.php?status=Pending" class="btn btn-sm" style="text-decoration: none; border-radius: 20px; padding: 5px 14px; font-size: 12.5px; font-weight: 600; <?= ($statusFilter === 'Pending') ? 'background: #f59e0b; color: #ffffff;' : 'background: #fef3c7; color: #92400e;' ?>">
                Pending (<?= $counts['Pending'] ?>)
            </a>
            <a href="grievances.php?status=Under+Review" class="btn btn-sm" style="text-decoration: none; border-radius: 20px; padding: 5px 14px; font-size: 12.5px; font-weight: 600; <?= ($statusFilter === 'Under Review') ? 'background: #0284c7; color: #ffffff;' : 'background: #e0f2fe; color: #075985;' ?>">
                Under Review (<?= $counts['Under Review'] ?>)
            </a>
            <a href="grievances.php?status=Resolved" class="btn btn-sm" style="text-decoration: none; border-radius: 20px; padding: 5px 14px; font-size: 12.5px; font-weight: 600; <?= ($statusFilter === 'Resolved') ? 'background: #10b981; color: #ffffff;' : 'background: #d1fae5; color: #065f46;' ?>">
                Resolved (<?= $counts['Resolved'] ?>)
            </a>
            <a href="grievances.php?status=Rejected" class="btn btn-sm" style="text-decoration: none; border-radius: 20px; padding: 5px 14px; font-size: 12.5px; font-weight: 600; <?= ($statusFilter === 'Rejected') ? 'background: #ef4444; color: #ffffff;' : 'background: #fee2e2; color: #991b1b;' ?>">
                Rejected (<?= $counts['Rejected'] ?>)
            </a>
        </div>

        <div style="position: relative;">
            <input type="text" id="grvSearchInput" placeholder="Search ticket, name, ID..." onkeyup="filterGrvTable()" style="padding: 7px 12px 7px 32px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 6px; width: 220px; outline: none;">
            <i class="fas fa-search" style="position: absolute; left: 10px; top: 10px; color: #94a3b8; font-size: 12px;"></i>
        </div>
    </div>

    <!-- Grievances Table -->
    <div style="overflow-x: auto;">
        <table class="admin-table" id="grvTable" style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 12px 14px; color: #475569; font-weight: 700; width: 140px;">Ticket No.</th>
                    <th style="padding: 12px 14px; color: #475569; font-weight: 700; width: 180px;">Applicant Name</th>
                    <th style="padding: 12px 14px; color: #475569; font-weight: 700; width: 150px;">Enrollment / ID</th>
                    <th style="padding: 12px 14px; color: #475569; font-weight: 700;">Grievance Category</th>
                    <th style="padding: 12px 14px; color: #475569; font-weight: 700; width: 110px; text-align: center;">Status</th>
                    <th style="padding: 12px 14px; color: #475569; font-weight: 700; width: 110px;">Date</th>
                    <th style="padding: 12px 14px; color: #475569; font-weight: 700; width: 100px; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($records)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 34px; color: #64748b;">
                            No grievances submitted for <?= htmlspecialchars($deptName) ?> yet.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($records as $row): ?>
                    <?php
                    $statusColor = '#f59e0b';
                    $statusBg = '#fef3c7';
                    if ($row['status'] === 'Resolved') {
                        $statusColor = '#059669';
                        $statusBg = '#d1fae5';
                    } elseif ($row['status'] === 'Under Review') {
                        $statusColor = '#0284c7';
                        $statusBg = '#e0f2fe';
                    } elseif ($row['status'] === 'Rejected') {
                        $statusColor = '#dc2626';
                        $statusBg = '#fee2e2';
                    }
                    ?>
                    <tr style="border-bottom: 1px solid #e2e8f0;">
                        <td style="padding: 12px 14px; font-weight: 700; color: #0f172a;">
                            <?= htmlspecialchars($row['ticket_number']) ?>
                        </td>
                        <td style="padding: 12px 14px; font-weight: 600; color: #1e293b;">
                            <?= htmlspecialchars($row['full_name']) ?>
                            <div style="font-size: 11.5px; color: #64748b; font-weight: 400;">
                                <?= htmlspecialchars($row['semester']) ?>
                            </div>
                        </td>
                        <td style="padding: 12px 14px; color: #475569; font-family: monospace;">
                            <?= htmlspecialchars($row['enrollment_faculty_id']) ?>
                        </td>
                        <td style="padding: 12px 14px;">
                            <span style="font-weight: 600; color: #0f172a;">
                                <?= htmlspecialchars($row['grievance_category']) ?>
                            </span>
                            <div style="font-size: 12px; color: #64748b; max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?= htmlspecialchars($row['grievance_description']) ?>
                            </div>
                        </td>
                        <td style="padding: 12px 14px; text-align: center;">
                            <span style="display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; background: <?= $statusBg ?>; color: <?= $statusColor ?>;">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                        </td>
                        <td style="padding: 12px 14px; color: #64748b; font-size: 12px;">
                            <?= date('d M Y', strtotime($row['created_at'])) ?>
                        </td>
                        <td style="padding: 12px 14px; text-align: center;">
                            <button type="button" 
                                    class="btn btn-sm btn-primary" 
                                    onclick='viewGrievance(<?= json_encode($row) ?>)'
                                    style="padding: 5px 12px; font-size: 12px; border-radius: 4px; background: #ff8800; color: #fff; border: none; cursor: pointer;">
                                View / Review
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Modal: View & Update Grievance -->
<div class="modal" id="viewGrvModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; border-radius: 8px; width: 100%; max-width: 650px; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 1.1rem; color: #0f172a; font-weight: 700;" id="mTicketTitle">
                Grievance Details
            </h3>
            <button type="button" onclick="closeGrvModal()" style="background: none; border: none; font-size: 22px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <form method="POST" action="grievances.php" style="padding: 22px 24px;">
            <input type="hidden" name="action" value="update_status">
            <input type="hidden" name="id" id="mGrievanceId" value="">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; background: #f8fafc; padding: 14px; border-radius: 6px; border: 1px solid #e2e8f0;">
                <div>
                    <span style="display: block; font-size: 11.5px; color: #64748b; text-transform: uppercase; font-weight: 600;">Applicant Name</span>
                    <strong style="color: #0f172a; font-size: 13.5px;" id="mFullName"></strong>
                </div>
                <div>
                    <span style="display: block; font-size: 11.5px; color: #64748b; text-transform: uppercase; font-weight: 600;">Enrollment / Faculty ID</span>
                    <strong style="color: #0f172a; font-size: 13.5px;" id="mEnrollment"></strong>
                </div>
                <div>
                    <span style="display: block; font-size: 11.5px; color: #64748b; text-transform: uppercase; font-weight: 600;">Contact Number</span>
                    <strong style="color: #0f172a; font-size: 13.5px;" id="mContact"></strong>
                </div>
                <div>
                    <span style="display: block; font-size: 11.5px; color: #64748b; text-transform: uppercase; font-weight: 600;">Gender / Category</span>
                    <strong style="color: #0f172a; font-size: 13.5px;" id="mGenderCat"></strong>
                </div>
                <div>
                    <span style="display: block; font-size: 11.5px; color: #64748b; text-transform: uppercase; font-weight: 600;">Semester</span>
                    <strong style="color: #0f172a; font-size: 13.5px;" id="mSemester"></strong>
                </div>
                <div>
                    <span style="display: block; font-size: 11.5px; color: #64748b; text-transform: uppercase; font-weight: 600;">Branch</span>
                    <strong style="color: #0f172a; font-size: 13.5px;" id="mBranch"></strong>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                    Grievance Category: <span id="mCategory" style="color: #ff8800; font-weight: 700;"></span>
                </label>
                <div id="mDescription" style="padding: 12px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #1e293b; line-height: 1.6; white-space: pre-wrap; max-height: 160px; overflow-y: auto;"></div>
            </div>

            <!-- Dept Admin Action Section -->
            <div style="border-top: 1px solid #e2e8f0; padding-top: 16px;">
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">
                        Update Grievance Status
                    </label>
                    <select name="status" id="mStatus" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13.5px; font-weight: 600;">
                        <option value="Pending">Pending</option>
                        <option value="Under Review">Under Review</option>
                        <option value="Resolved">Resolved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">
                        Department Action / Resolution Remarks
                    </label>
                    <textarea name="admin_remarks" id="mRemarks" rows="3" placeholder="Enter department review notes, action taken, or response to the student..." style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeGrvModal()" class="btn btn-secondary" style="padding: 8px 16px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f8fafc; cursor: pointer;">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" style="padding: 8px 20px; border: none; border-radius: 6px; background: #ff8800; color: #ffffff; font-weight: 600; cursor: pointer;">
                        Save Resolution
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function viewGrievance(data) {
    document.getElementById('mTicketTitle').textContent = 'Grievance: ' + data.ticket_number;
    document.getElementById('mGrievanceId').value = data.id;
    document.getElementById('mFullName').textContent = data.full_name;
    document.getElementById('mEnrollment').textContent = data.enrollment_faculty_id;
    document.getElementById('mContact').textContent = data.contact_number;
    document.getElementById('mGenderCat').textContent = data.gender + ' / ' + data.category;
    document.getElementById('mSemester').textContent = data.semester;
    document.getElementById('mBranch').textContent = data.branch;
    document.getElementById('mCategory').textContent = data.grievance_category;
    document.getElementById('mDescription').textContent = data.grievance_description;
    document.getElementById('mStatus').value = data.status;
    document.getElementById('mRemarks').value = data.admin_remarks || '';

    var modal = document.getElementById('viewGrvModal');
    if (modal) modal.style.display = 'flex';
}

function closeGrvModal() {
    var modal = document.getElementById('viewGrvModal');
    if (modal) modal.style.display = 'none';
}

function filterGrvTable() {
    var input = document.getElementById("grvSearchInput");
    var filter = input.value.toLowerCase();
    var table = document.getElementById("grvTable");
    var tr = table.getElementsByTagName("tr");

    for (var i = 1; i < tr.length; i++) {
        var textContent = tr[i].textContent || tr[i].innerText;
        if (textContent.toLowerCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
