<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

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
        error_log("Grievance table setup error: " . $e->getMessage());
    }
}

// Handle Form Submissions (Status / Remarks Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP.');
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
        $stmt = $pdo->prepare("UPDATE student_grievances 
            SET status = ?, admin_remarks = ?, resolved_at = IF(? = 'Resolved', NOW(), resolved_at) 
            WHERE id = ?");
        $stmt->execute([$status, $remarks, $status, $id]);

        setFlashMessage('success', 'Grievance ticket status and resolution remarks updated successfully.');
    }
    header('Location: grievances.php');
    exit;
}

// Handle Delete Action
if (isset($_GET['delete'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: grievances.php');
        exit;
    }
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM student_grievances WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Grievance ticket deleted successfully.');
        header('Location: grievances.php');
        exit;
    }
}

// Filters
$filterDept = trim($_GET['dept'] ?? '');
$filterStatus = trim($_GET['status'] ?? '');

// Department list
$departments = [
    'CE'    => 'Computer Engineering',
    'IT'    => 'Information Technology',
    'CIVIL' => 'Civil Engineering',
    'ME'    => 'Mechanical Engineering',
    'EE'    => 'Electrical Engineering',
    'EC'    => 'Electronics & Communication',
    'AE'    => 'Automobile Engineering',
    'AM'    => 'Applied Mechanics',
    'SH'    => 'Science & Humanities',
    'GEN'   => 'General / Administration'
];

// Fetch Records & Counts
$records = [];
$stats = [
    'Total' => 0,
    'Pending' => 0,
    'Under Review' => 0,
    'Resolved' => 0,
    'Rejected' => 0
];

if ($pdo) {
    try {
        // Overall Counts
        $cntQuery = $pdo->query("SELECT status, COUNT(*) as cnt FROM student_grievances GROUP BY status");
        while ($r = $cntQuery->fetch(PDO::FETCH_ASSOC)) {
            $stats['Total'] += (int)$r['cnt'];
            if (isset($stats[$r['status']])) {
                $stats[$r['status']] = (int)$r['cnt'];
            }
        }

        // Build filtered query
        $sql = "SELECT * FROM student_grievances WHERE 1=1";
        $params = [];

        if (!empty($filterDept)) {
            $sql .= " AND dept_code = ?";
            $params[] = $filterDept;
        }

        if (!empty($filterStatus)) {
            $sql .= " AND status = ?";
            $params[] = $filterStatus;
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $records = [];
    }
}

$current_page = 'grievances';
$page_title = 'Grievance Redressal Management';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 20px;">
        <a href="../student-corner/grievance-portal" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; text-decoration: none;">
            <i class="fas fa-external-link-alt"></i> View Public Grievance Form
        </a>
    </div>

    <!-- Quick Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; margin-bottom: 22px;">
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px;">
            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Submissions</div>
            <div style="font-size: 26px; font-weight: 800; color: #0f172a; margin-top: 4px;"><?= $stats['Total'] ?></div>
        </div>
        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 14px 18px;">
            <div style="font-size: 12px; font-weight: 700; color: #b45309; text-transform: uppercase;">Pending Action</div>
            <div style="font-size: 26px; font-weight: 800; color: #b45309; margin-top: 4px;"><?= $stats['Pending'] ?></div>
        </div>
        <div style="background: #e0f2fe; border: 1px solid #bae6fd; border-radius: 8px; padding: 14px 18px;">
            <div style="font-size: 12px; font-weight: 700; color: #0369a1; text-transform: uppercase;">Under Review</div>
            <div style="font-size: 26px; font-weight: 800; color: #0369a1; margin-top: 4px;"><?= $stats['Under Review'] ?></div>
        </div>
        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 14px 18px;">
            <div style="font-size: 12px; font-weight: 700; color: #047857; text-transform: uppercase;">Resolved</div>
            <div style="font-size: 26px; font-weight: 800; color: #047857; margin-top: 4px;"><?= $stats['Resolved'] ?></div>
        </div>
        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 14px 18px;">
            <div style="font-size: 12px; font-weight: 700; color: #b91c1c; text-transform: uppercase;">Rejected</div>
            <div style="font-size: 26px; font-weight: 800; color: #b91c1c; margin-top: 4px;"><?= $stats['Rejected'] ?></div>
        </div>
    </div>

    <!-- Filters Row -->
    <div class="card-actions-row" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-bottom: 20px;">
        <form method="GET" action="grievances.php" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <div>
                <select name="dept" onchange="this.form.submit()" style="padding: 7px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; font-weight: 600; background: #ffffff;">
                    <option value="">All Departments (<?= $stats['Total'] ?>)</option>
                    <?php foreach ($departments as $dCode => $dName): ?>
                        <option value="<?= $dCode ?>" <?= ($filterDept === $dCode) ? 'selected' : '' ?>>
                            <?= $dCode ?> - <?= htmlspecialchars($dName) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <select name="status" onchange="this.form.submit()" style="padding: 7px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; font-weight: 600; background: #ffffff;">
                    <option value="">All Statuses</option>
                    <option value="Pending" <?= ($filterStatus === 'Pending') ? 'selected' : '' ?>>Pending (<?= $stats['Pending'] ?>)</option>
                    <option value="Under Review" <?= ($filterStatus === 'Under Review') ? 'selected' : '' ?>>Under Review (<?= $stats['Under Review'] ?>)</option>
                    <option value="Resolved" <?= ($filterStatus === 'Resolved') ? 'selected' : '' ?>>Resolved (<?= $stats['Resolved'] ?>)</option>
                    <option value="Rejected" <?= ($filterStatus === 'Rejected') ? 'selected' : '' ?>>Rejected (<?= $stats['Rejected'] ?>)</option>
                </select>
            </div>

            <?php if (!empty($filterDept) || !empty($filterStatus)): ?>
                <a href="grievances.php" class="btn btn-secondary btn-sm" style="font-size: 12px; padding: 7px 12px; text-decoration: none;">
                    Clear Filters
                </a>
            <?php endif; ?>
        </form>

        <div class="search-input-group" style="margin-left: auto;">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" id="adminGrvSearch" placeholder="Search ticket, student, branch..." onkeyup="filterAdminGrvTable()">
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="adminGrvTable">
            <thead>
                <tr>
                    <th style="width: 140px;">Ticket No.</th>
                    <th style="width: 190px;">Applicant Name</th>
                    <th style="width: 130px;">Branch</th>
                    <th style="width: 150px;">Category</th>
                    <th>Description</th>
                    <th style="width: 110px; text-align: center;">Status</th>
                    <th style="width: 105px;">Date</th>
                    <th style="width: 110px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($records)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 34px; color: #64748b;">
                            No grievance applications found matching the selected criteria.
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
                    <tr>
                        <td style="font-weight: 700; color: #0f172a;">
                            <?= htmlspecialchars($row['ticket_number']) ?>
                        </td>
                        <td style="font-weight: 600; color: #1e293b;">
                            <?= htmlspecialchars($row['full_name']) ?>
                            <div style="font-size: 11.5px; color: #64748b; font-weight: 400;">
                                ID: <?= htmlspecialchars($row['enrollment_faculty_id']) ?>
                            </div>
                        </td>
                        <td>
                            <span style="font-size: 11.5px; font-weight: 700; color: #0369a1; background: #e0f2fe; padding: 3px 8px; border-radius: 4px;">
                                <?= htmlspecialchars($row['dept_code']) ?>
                            </span>
                        </td>
                        <td style="font-weight: 600; color: #334155; font-size: 12.5px;">
                            <?= htmlspecialchars($row['grievance_category']) ?>
                        </td>
                        <td style="font-size: 12.5px; color: #475569; line-height: 1.45;">
                            <div style="max-width: 260px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?= htmlspecialchars($row['grievance_description']) ?>
                            </div>
                            <?php if (!empty($row['admin_remarks'])): ?>
                                <div style="font-size: 11px; color: #059669; margin-top: 3px; font-weight: 600;">
                                    Remarks: <?= htmlspecialchars($row['admin_remarks']) ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <span style="display: inline-block; padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; background: <?= $statusBg ?>; color: <?= $statusColor ?>;">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                        </td>
                        <td style="color: #64748b; font-size: 12px;">
                            <?= date('d M Y', strtotime($row['created_at'])) ?>
                        </td>
                        <td style="text-align: center;">
                            <div style="display: inline-flex; gap: 6px;">
                                <button type="button" 
                                        class="btn-icon edit" 
                                        title="View / Resolve Grievance" 
                                        onclick='openAdminGrvModal(<?= json_encode($row) ?>)'>
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="grievances.php?delete=<?= $row['id'] ?>" 
                                   class="btn-icon delete" 
                                   title="Delete Grievance" 
                                   onclick="return confirm('Are you sure you want to delete this grievance record?');">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Modal: Super Admin View & Resolve Grievance -->
<div class="modal" id="adminGrvModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; border-radius: 8px; width: 100%; max-width: 680px; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 1.15rem; color: #0f172a; font-weight: 700;" id="saTicketTitle">
                Grievance Application Details
            </h3>
            <button type="button" onclick="closeAdminGrvModal()" style="background: none; border: none; font-size: 22px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <form method="POST" action="grievances.php" style="padding: 22px 24px;">
            <input type="hidden" name="action" value="update_status">
            <input type="hidden" name="id" id="saGrievanceId" value="">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px; background: #f8fafc; padding: 14px; border-radius: 6px; border: 1px solid #e2e8f0;">
                <div>
                    <span style="display: block; font-size: 11.5px; color: #64748b; text-transform: uppercase; font-weight: 600;">Applicant Name</span>
                    <strong style="color: #0f172a; font-size: 13.5px;" id="saFullName"></strong>
                </div>
                <div>
                    <span style="display: block; font-size: 11.5px; color: #64748b; text-transform: uppercase; font-weight: 600;">Enrollment / Faculty ID</span>
                    <strong style="color: #0f172a; font-size: 13.5px;" id="saEnrollment"></strong>
                </div>
                <div>
                    <span style="display: block; font-size: 11.5px; color: #64748b; text-transform: uppercase; font-weight: 600;">Contact Number</span>
                    <strong style="color: #0f172a; font-size: 13.5px;" id="saContact"></strong>
                </div>
                <div>
                    <span style="display: block; font-size: 11.5px; color: #64748b; text-transform: uppercase; font-weight: 600;">Gender / Category</span>
                    <strong style="color: #0f172a; font-size: 13.5px;" id="saGenderCat"></strong>
                </div>
                <div>
                    <span style="display: block; font-size: 11.5px; color: #64748b; text-transform: uppercase; font-weight: 600;">Father's Name</span>
                    <strong style="color: #0f172a; font-size: 13.5px;" id="saFatherName"></strong>
                </div>
                <div>
                    <span style="display: block; font-size: 11.5px; color: #64748b; text-transform: uppercase; font-weight: 600;">Department / Branch</span>
                    <strong style="color: #0f172a; font-size: 13.5px;" id="saBranch"></strong>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 4px;">
                    Grievance Category: <span id="saCategory" style="color: #0284c7;"></span>
                </label>
                <div id="saDescription" style="padding: 12px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; color: #1e293b; line-height: 1.6; white-space: pre-wrap; max-height: 180px; overflow-y: auto;"></div>
            </div>

            <!-- Action Section -->
            <div style="border-top: 1px solid #e2e8f0; padding-top: 16px;">
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">
                        Grievance Status
                    </label>
                    <select name="status" id="saStatus" style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13.5px; font-weight: 600;">
                        <option value="Pending">Pending</option>
                        <option value="Under Review">Under Review</option>
                        <option value="Resolved">Resolved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>

                <div style="margin-bottom: 18px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">
                        Super Admin / Committee Resolution Remarks
                    </label>
                    <textarea name="admin_remarks" id="saRemarks" rows="3" placeholder="Enter resolution notes or instructions for the department..." style="width: 100%; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 13px; box-sizing: border-box;"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeAdminGrvModal()" class="btn btn-secondary" style="padding: 8px 16px; border: 1px solid #cbd5e1; border-radius: 6px; background: #f8fafc; cursor: pointer;">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" style="padding: 8px 20px; border: none; border-radius: 6px; background: #0284c7; color: #ffffff; font-weight: 600; cursor: pointer;">
                        Save Resolution
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function openAdminGrvModal(data) {
    document.getElementById('saTicketTitle').textContent = 'Grievance: ' + data.ticket_number;
    document.getElementById('saGrievanceId').value = data.id;
    document.getElementById('saFullName').textContent = data.full_name;
    document.getElementById('saEnrollment').textContent = data.enrollment_faculty_id;
    document.getElementById('saContact').textContent = data.contact_number;
    document.getElementById('saGenderCat').textContent = data.gender + ' / ' + data.category;
    document.getElementById('saFatherName').textContent = data.father_name;
    document.getElementById('saBranch').textContent = data.branch + ' (' + data.dept_code + ') - ' + data.semester;
    document.getElementById('saCategory').textContent = data.grievance_category;
    document.getElementById('saDescription').textContent = data.grievance_description;
    document.getElementById('saStatus').value = data.status;
    document.getElementById('saRemarks').value = data.admin_remarks || '';

    var modal = document.getElementById('adminGrvModal');
    if (modal) modal.style.display = 'flex';
}

function closeAdminGrvModal() {
    var modal = document.getElementById('adminGrvModal');
    if (modal) modal.style.display = 'none';
}

function filterAdminGrvTable() {
    var input = document.getElementById("adminGrvSearch");
    var filter = input.value.toLowerCase();
    var table = document.getElementById("adminGrvTable");
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
