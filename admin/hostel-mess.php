<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Hostel & Mess Management";
$current_page = 'hostel-mess';

$activeTab = $_GET['tab'] ?? 'rules'; // 'rules', 'staff', 'blocks', 'fees', 'mess', 'photos'
$editId = isset($_GET['edit_id']) ? (int)$_GET['edit_id'] : 0;

// Handle Form Submissions
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header("Location: hostel-mess?tab={$activeTab}");
        exit;
    }

    $action = $_POST['action'] ?? '';

    // =========================================================================
    // 0. HOSTEL LEADERSHIP ACTIONS (RECTOR & ASSISTANT RECTORS)
    // =========================================================================
    if ($action === 'add_leadership') {
        $role_badge = trim($_POST['role_badge'] ?? 'Assistant Rector');
        $name = trim($_POST['name'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $is_primary = isset($_POST['is_primary']) ? 1 : 0;
        $display_order = (int)($_POST['display_order'] ?? 0);

        if (!empty($name)) {
            $stmt = $pdo->prepare("INSERT INTO hostel_leadership (role_badge, name, designation, department, is_primary, display_order) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$role_badge, $name, $designation, $department, $is_primary, $display_order]);
            setFlashMessage('success', 'Hostel leadership officer added successfully.');
        } else {
            setFlashMessage('danger', 'Officer name cannot be empty.');
        }
        header('Location: hostel-mess?tab=leadership');
        exit;
    }

    if ($action === 'edit_leadership') {
        $id = (int)($_POST['id'] ?? 0);
        $role_badge = trim($_POST['role_badge'] ?? 'Assistant Rector');
        $name = trim($_POST['name'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $is_primary = isset($_POST['is_primary']) ? 1 : 0;
        $display_order = (int)($_POST['display_order'] ?? 0);

        if ($id > 0 && !empty($name)) {
            $stmt = $pdo->prepare("UPDATE hostel_leadership SET role_badge = ?, name = ?, designation = ?, department = ?, is_primary = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$role_badge, $name, $designation, $department, $is_primary, $display_order, $id]);
            setFlashMessage('success', 'Hostel leadership officer updated successfully.');
        }
        header('Location: hostel-mess?tab=leadership');
        exit;
    }

    if ($action === 'delete_leadership') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM hostel_leadership WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('success', 'Leadership officer record removed.');
        }
        header('Location: hostel-mess?tab=leadership');
        exit;
    }

    // =========================================================================
    // 1. UPLOAD & DELETE HOSTEL RULES PDF
    // =========================================================================
    if ($action === 'upload_rules_pdf') {
        if (isset($_FILES['rules_pdf']) && $_FILES['rules_pdf']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['pdf'];
            $file = $_FILES['rules_pdf'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                setFlashMessage('danger', 'Only PDF files are allowed for Hostel Rules.');
                header('Location: hostel-mess?tab=rules');
                exit;
            }

            if ($file['size'] > 25 * 1024 * 1024) {
                setFlashMessage('danger', 'File size exceeds maximum limit of 25MB.');
                header('Location: hostel-mess?tab=rules');
                exit;
            }

            $uploadDir = __DIR__ . '/../uploads/hostel';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Fetch current old PDF URL from database
            $stmtOld = $pdo->query("SELECT rules_pdf_url FROM hostel_mess WHERE id = 1");
            $oldRow = $stmtOld ? $stmtOld->fetch() : null;
            $oldPdfUrl = $oldRow['rules_pdf_url'] ?? '';

            $newFileName = 'hostel_rules_' . time() . '.pdf';
            $destPath = $uploadDir . '/' . $newFileName;
            $dbPath = 'uploads/hostel/' . $newFileName;

            if (move_uploaded_file($file['tmp_name'], $destPath)) {
                // Sanitize PDF metadata title to prevent "MergedFile" appearing on browser tabs
                sanitizePdfTitle($destPath, 'Rules and Regulations for Hostel Students - GEC Modasa');

                // Completely delete the old PDF file from disk
                if (!empty($oldPdfUrl) && $oldPdfUrl !== $dbPath) {
                    deleteUploadedFile($oldPdfUrl);
                }

                // Clean up any remaining previous hostel_rules_*.pdf files in directory
                foreach (glob($uploadDir . '/hostel_rules_*.pdf') as $existingPdf) {
                    if (basename($existingPdf) !== $newFileName) {
                        @unlink($existingPdf);
                    }
                }

                $stmt = $pdo->prepare("UPDATE hostel_mess SET rules_pdf_url = ? WHERE id = 1");
                $stmt->execute([$dbPath]);
                setFlashMessage('success', 'Hostel Rules PDF updated successfully! Previous PDF was completely removed.');
            } else {
                setFlashMessage('danger', 'Failed to save uploaded PDF file.');
            }
        } else {
            setFlashMessage('danger', 'Please choose a valid PDF file to upload.');
        }
        header('Location: hostel-mess?tab=rules');
        exit;
    }

    if ($action === 'delete_rules_pdf') {
        $stmtOld = $pdo->query("SELECT rules_pdf_url FROM hostel_mess WHERE id = 1");
        $oldRow = $stmtOld ? $stmtOld->fetch() : null;
        $oldPdfUrl = $oldRow['rules_pdf_url'] ?? '';

        if (!empty($oldPdfUrl)) {
            deleteUploadedFile($oldPdfUrl);
        }

        $uploadDir = __DIR__ . '/../uploads/hostel';
        foreach (glob($uploadDir . '/hostel_rules_*.pdf') as $existingPdf) {
            @unlink($existingPdf);
        }

        $stmt = $pdo->prepare("UPDATE hostel_mess SET rules_pdf_url = NULL WHERE id = 1");
        $stmt->execute();
        setFlashMessage('success', 'Current Hostel Rules PDF has been completely deleted from server and database.');
        header('Location: hostel-mess?tab=rules');
        exit;
    }

    // =========================================================================
    // 2. STAFF INCHARGE ACTIONS (ABOUT TAB)
    // =========================================================================
    if ($action === 'add_staff') {
        $section_type = $_POST['section_type'] ?? 'warden_caretaker';
        $work_description = trim($_POST['work_description'] ?? 'Warden & Care Taker');
        $block_name = trim($_POST['block_name'] ?? '');
        $warden = trim($_POST['warden'] ?? '');
        $care_taker = trim($_POST['care_taker'] ?? '');
        $staff_incharge = trim($_POST['staff_incharge'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);

        $stmt = $pdo->prepare("INSERT INTO hostel_staff (section_type, work_description, block_name, warden, care_taker, staff_incharge, display_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$section_type, $work_description, $block_name, $warden, $care_taker, $staff_incharge, $display_order]);
        setFlashMessage('success', 'Staff in-charge entry added successfully.');
        header('Location: hostel-mess?tab=staff');
        exit;
    }

    if ($action === 'edit_staff') {
        $id = (int)($_POST['id'] ?? 0);
        $section_type = $_POST['section_type'] ?? 'warden_caretaker';
        $work_description = trim($_POST['work_description'] ?? 'Warden & Care Taker');
        $block_name = trim($_POST['block_name'] ?? '');
        $warden = trim($_POST['warden'] ?? '');
        $care_taker = trim($_POST['care_taker'] ?? '');
        $staff_incharge = trim($_POST['staff_incharge'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE hostel_staff SET section_type = ?, work_description = ?, block_name = ?, warden = ?, care_taker = ?, staff_incharge = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$section_type, $work_description, $block_name, $warden, $care_taker, $staff_incharge, $display_order, $id]);
            setFlashMessage('success', 'Staff in-charge record updated.');
        }
        header('Location: hostel-mess?tab=staff');
        exit;
    }

    if ($action === 'delete_staff') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM hostel_staff WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('success', 'Staff entry removed.');
        }
        header('Location: hostel-mess?tab=staff');
        exit;
    }

    // =========================================================================
    // 3. BLOCK CAPACITY ACTIONS
    // =========================================================================
    if ($action === 'add_block') {
        $sr_no = (int)($_POST['sr_no'] ?? 1);
        $block_name = trim($_POST['block_name'] ?? '');
        $number_of_floor = trim($_POST['number_of_floor'] ?? 'G + 2');
        $total_rooms = (int)($_POST['total_rooms'] ?? 0);
        $number_of_students = (int)($_POST['number_of_students'] ?? 0);
        $display_order = (int)($_POST['display_order'] ?? 0);

        if (!empty($block_name)) {
            $stmt = $pdo->prepare("INSERT INTO hostel_blocks (sr_no, block_name, number_of_floor, total_rooms, number_of_students, display_order) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$sr_no, $block_name, $number_of_floor, $total_rooms, $number_of_students, $display_order]);
            setFlashMessage('success', 'Hostel block capacity added.');
        }
        header('Location: hostel-mess?tab=blocks');
        exit;
    }

    if ($action === 'edit_block') {
        $id = (int)($_POST['id'] ?? 0);
        $sr_no = (int)($_POST['sr_no'] ?? 1);
        $block_name = trim($_POST['block_name'] ?? '');
        $number_of_floor = trim($_POST['number_of_floor'] ?? 'G + 2');
        $total_rooms = (int)($_POST['total_rooms'] ?? 0);
        $number_of_students = (int)($_POST['number_of_students'] ?? 0);
        $display_order = (int)($_POST['display_order'] ?? 0);

        if ($id > 0 && !empty($block_name)) {
            $stmt = $pdo->prepare("UPDATE hostel_blocks SET sr_no = ?, block_name = ?, number_of_floor = ?, total_rooms = ?, number_of_students = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$sr_no, $block_name, $number_of_floor, $total_rooms, $number_of_students, $display_order, $id]);
            setFlashMessage('success', 'Block capacity updated.');
        }
        header('Location: hostel-mess?tab=blocks');
        exit;
    }

    if ($action === 'delete_block') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM hostel_blocks WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('success', 'Block entry deleted.');
        }
        header('Location: hostel-mess?tab=blocks');
        exit;
    }

    // =========================================================================
    // 4. FEES STRUCTURE ACTIONS
    // =========================================================================
    if ($action === 'save_fee_notes') {
        $fee_notes = trim($_POST['fee_notes'] ?? '');
        $stmt = $pdo->prepare("UPDATE hostel_mess SET fee_notes = ? WHERE id = 1");
        $stmt->execute([$fee_notes]);
        setFlashMessage('success', 'Hostel fee guidelines updated.');
        header('Location: hostel-mess?tab=fees');
        exit;
    }

    if ($action === 'add_fee_row') {
        $year_name = trim($_POST['year_name'] ?? '');
        $hostel_fees = trim($_POST['hostel_fees'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if (!empty($year_name) && !empty($hostel_fees)) {
            $stmt = $pdo->prepare("INSERT INTO hostel_fees (year_name, hostel_fees, display_order) VALUES (?, ?, ?)");
            $stmt->execute([$year_name, $hostel_fees, $display_order]);
            setFlashMessage('success', 'Fee row added.');
        }
        header('Location: hostel-mess?tab=fees');
        exit;
    }

    if ($action === 'delete_fee_row') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM hostel_fees WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('success', 'Fee row removed.');
        }
        header('Location: hostel-mess?tab=fees');
        exit;
    }

    // =========================================================================
    // 5. MESS GUIDELINES ACTIONS
    // =========================================================================
    if ($action === 'save_mess_notes') {
        $mess_notes = trim($_POST['mess_notes'] ?? '');
        $stmt = $pdo->prepare("UPDATE hostel_mess SET mess_notes = ? WHERE id = 1");
        $stmt->execute([$mess_notes]);
        setFlashMessage('success', 'Hostel mess guidelines updated successfully.');
        header('Location: hostel-mess?tab=mess');
        exit;
    }

    // =========================================================================
    // 6. PHOTOS GALLERY ACTIONS
    // =========================================================================
    if ($action === 'add_photo') {
        $caption = trim($_POST['caption'] ?? 'New Hostel');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload = handleImageUpload('photo', 'hostel');
            if ($upload['success']) {
                $stmt = $pdo->prepare("INSERT INTO hostel_photos (caption, image_path, display_order, is_active) VALUES (?, ?, ?, 1)");
                $stmt->execute([$caption, $upload['path'], $display_order]);
                setFlashMessage('success', 'Hostel photo uploaded successfully.');
            } else {
                setFlashMessage('danger', $upload['error']);
            }
        } else {
            setFlashMessage('danger', 'Please select an image file to upload.');
        }
        header('Location: hostel-mess?tab=photos');
        exit;
    }

    if ($action === 'delete_photo') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmtPhoto = $pdo->prepare("SELECT image_path FROM hostel_photos WHERE id = ?");
            $stmtPhoto->execute([$id]);
            $photoRow = $stmtPhoto->fetch();
            if ($photoRow && !empty($photoRow['image_path'])) {
                deleteUploadedFile($photoRow['image_path']);
            }

            $stmt = $pdo->prepare("DELETE FROM hostel_photos WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('success', 'Photo and image file removed successfully.');
        }
        header('Location: hostel-mess?tab=photos');
        exit;
    }
}

// Fetch all data for display
$hostelData = null;
$leadershipList = [];
$staffList = [];
$blocksList = [];
$feesList = [];
$photosList = [];

if ($pdo) {
    try {
        $hostelData = $pdo->query("SELECT * FROM hostel_mess LIMIT 1")->fetch();
        $leadershipList = $pdo->query("SELECT * FROM hostel_leadership ORDER BY display_order ASC, id ASC")->fetchAll();
        $staffList = $pdo->query("SELECT * FROM hostel_staff ORDER BY display_order ASC, id ASC")->fetchAll();
        $blocksList = $pdo->query("SELECT * FROM hostel_blocks ORDER BY display_order ASC, sr_no ASC")->fetchAll();
        $feesList = $pdo->query("SELECT * FROM hostel_fees ORDER BY display_order ASC, id ASC")->fetchAll();
        $photosList = $pdo->query("SELECT * FROM hostel_photos ORDER BY display_order ASC, id DESC")->fetchAll();
    } catch (Throwable $e) {
        error_log("Admin hostel data fetch error: " . $e->getMessage());
    }
}

$editLeadership = null;
$editStaff = null;
$editBlock = null;
if ($editId > 0 && $pdo) {
    if ($activeTab === 'leadership') {
        $stmt = $pdo->prepare("SELECT * FROM hostel_leadership WHERE id = ?");
        $stmt->execute([$editId]);
        $editLeadership = $stmt->fetch();
    } elseif ($activeTab === 'staff') {
        $stmt = $pdo->prepare("SELECT * FROM hostel_staff WHERE id = ?");
        $stmt->execute([$editId]);
        $editStaff = $stmt->fetch();
    } elseif ($activeTab === 'blocks') {
        $stmt = $pdo->prepare("SELECT * FROM hostel_blocks WHERE id = ?");
        $stmt->execute([$editId]);
        $editBlock = $stmt->fetch();
    }
}

include __DIR__ . '/includes/header.php';
?>

<div class="content-header-action" style="display: flex; justify-content: flex-end; margin-bottom: 1.5rem;">
    <a href="../administration/hostel-mess" target="_blank" class="btn btn-outline-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 500;">
        <i class="fas fa-external-link-alt"></i> View Public Hostel &amp; Mess Page
    </a>
</div>

<!-- Navigation Tabs inside Admin -->
<div class="card" style="margin-bottom: 1.5rem; padding: 0.5rem;">
    <ul class="nav nav-tabs-modern" style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin: 0; padding: 0; list-style: none;">
        <li>
            <a href="hostel-mess?tab=leadership" class="btn <?= ($activeTab === 'leadership') ? 'btn-primary' : 'btn-light' ?>" style="font-weight: 600;">
                <i class="fas fa-user-tie"></i> Hostel Leadership (<?= count($leadershipList) ?>)
            </a>
        </li>
        <li>
            <a href="hostel-mess?tab=rules" class="btn <?= ($activeTab === 'rules') ? 'btn-primary' : 'btn-light' ?>" style="font-weight: 600;">
                <i class="fas fa-file-pdf"></i> Hostel Rules PDF
            </a>
        </li>
        <li>
            <a href="hostel-mess?tab=staff" class="btn <?= ($activeTab === 'staff') ? 'btn-primary' : 'btn-light' ?>" style="font-weight: 600;">
                <i class="fas fa-users-cog"></i> Duty Allocation &amp; Caretakers (<?= count($staffList) ?>)
            </a>
        </li>
        <li>
            <a href="hostel-mess?tab=blocks" class="btn <?= ($activeTab === 'blocks') ? 'btn-primary' : 'btn-light' ?>" style="font-weight: 600;">
                <i class="fas fa-building"></i> Block Capacity (<?= count($blocksList) ?>)
            </a>
        </li>
        <li>
            <a href="hostel-mess?tab=fees" class="btn <?= ($activeTab === 'fees') ? 'btn-primary' : 'btn-light' ?>" style="font-weight: 600;">
                <i class="fas fa-money-bill-wave"></i> Fees Structure (<?= count($feesList) ?>)
            </a>
        </li>
        <li>
            <a href="hostel-mess?tab=mess" class="btn <?= ($activeTab === 'mess') ? 'btn-primary' : 'btn-light' ?>" style="font-weight: 600;">
                <i class="fas fa-utensils"></i> Mess Guidelines
            </a>
        </li>
        <li>
            <a href="hostel-mess?tab=photos" class="btn <?= ($activeTab === 'photos') ? 'btn-primary' : 'btn-light' ?>" style="font-weight: 600;">
                <i class="fas fa-images"></i> Photos Gallery (<?= count($photosList) ?>)
            </a>
        </li>
    </ul>
</div>

<!-- ========================================================================= -->
<!-- TAB 0: HOSTEL LEADERSHIP & ADMINISTRATION -->
<!-- ========================================================================= -->
<?php if ($activeTab === 'leadership'): ?>
<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-<?= $editLeadership ? 'edit' : 'user-plus' ?> text-primary"></i>
        <?= $editLeadership ? 'Edit Hostel Leadership Officer' : 'Add New Hostel Leadership Officer' ?>
    </div>
    <form method="POST" action="hostel-mess?tab=leadership">
        <input type="hidden" name="action" value="<?= $editLeadership ? 'edit_leadership' : 'add_leadership' ?>">
        <?php if ($editLeadership): ?>
            <input type="hidden" name="id" value="<?= (int)$editLeadership['id'] ?>">
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Role / Badge <span class="text-danger">*</span></label>
                <input type="text" name="role_badge" class="form-control" required placeholder="e.g. Chief Warden / Rector or Assistant Rector" value="<?= htmlspecialchars($editLeadership['role_badge'] ?? 'Assistant Rector') ?>">
                <small class="text-muted">Displayed as the blue pill tag above the name.</small>
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Full Name with Salutation <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required placeholder="e.g. Prof. (Dr.) U. V. Shah" value="<?= htmlspecialchars($editLeadership['name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Designation</label>
                <input type="text" name="designation" class="form-control" placeholder="e.g. Professor & Head / Assistant Professor" value="<?= htmlspecialchars($editLeadership['designation'] ?? 'Assistant Professor') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Department / Unit</label>
                <input type="text" name="department" class="form-control" placeholder="e.g. Mechanical Engineering Department" value="<?= htmlspecialchars($editLeadership['department'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Display Priority / Order</label>
                <input type="number" name="display_order" class="form-control" value="<?= (int)($editLeadership['display_order'] ?? (count($leadershipList) + 1)) ?>">
            </div>

            <div class="form-group" style="display: flex; align-items: center; margin-top: 1.8rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; cursor: pointer;">
                    <input type="checkbox" name="is_primary" value="1" <?= (!empty($editLeadership['is_primary'])) ? 'checked' : '' ?>>
                    Mark as Primary / Chief Rector (Highlighted)
                </label>
            </div>
        </div>

        <div style="margin-top: 1.25rem; display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary" style="font-weight: 600;">
                <i class="fas fa-save"></i> <?= $editLeadership ? 'Update Officer' : 'Save Officer' ?>
            </button>
            <?php if ($editLeadership): ?>
                <a href="hostel-mess?tab=leadership" class="btn btn-light">Cancel Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1rem;">
        Hostel Leadership &amp; Administration Directory (<?= count($leadershipList) ?>)
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 50px;">Order</th>
                    <th>Role / Badge</th>
                    <th>Officer Name</th>
                    <th>Designation</th>
                    <th>Department</th>
                    <th>Role Type</th>
                    <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($leadershipList)): ?>
                    <tr class="no-records-row"><td colspan="7" class="text-center" style="padding: 2rem; color: #64748b;">No leadership records found.</td></tr>
                <?php else: ?>
                    <?php foreach ($leadershipList as $ld): ?>
                        <tr>
                            <td><span class="badge badge-light"><?= (int)$ld['display_order'] ?></span></td>
                            <td>
                                <span class="badge badge-primary" style="font-size: 11px; text-transform: uppercase;">
                                    <?= htmlspecialchars($ld['role_badge']) ?>
                                </span>
                            </td>
                            <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($ld['name']) ?></td>
                            <td><?= htmlspecialchars($ld['designation'] ?: '--') ?></td>
                            <td><?= htmlspecialchars($ld['department'] ?: '--') ?></td>
                            <td>
                                <?php if (!empty($ld['is_primary'])): ?>
                                    <span class="badge badge-success">Primary / Chief</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Assistant</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 0.4rem;">
                                    <a href="hostel-mess?tab=leadership&edit_id=<?= (int)$ld['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="hostel-mess?tab=leadership" onsubmit="return confirm('Delete this officer from hostel leadership?');" style="margin: 0;">
                                        <input type="hidden" name="action" value="delete_leadership">
                                        <input type="hidden" name="id" value="<?= (int)$ld['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- ========================================================================= -->
<!-- TAB 1: HOSTEL RULES PDF -->
<!-- ========================================================================= -->
<?php if ($activeTab === 'rules'): ?>
<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-file-pdf text-danger"></i> Upload / Update Official Hostel Rules PDF
    </div>

    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
        <div style="font-weight: 600; color: #1e293b; margin-bottom: 8px;">Current Active Rules Document:</div>
        <?php 
        $hasRulesPdf = !empty($hostelData['rules_pdf_url']);
        $rulesPdfDiskPath = $hasRulesPdf ? (__DIR__ . '/../' . ltrim($hostelData['rules_pdf_url'], '/')) : '';
        $rulesPdfExists = $hasRulesPdf && file_exists($rulesPdfDiskPath);
        if ($hasRulesPdf && $rulesPdfExists): 
            $fileSizeBytes = filesize($rulesPdfDiskPath);
            $formattedSize = ($fileSizeBytes >= 1048576) ? number_format($fileSizeBytes / 1048576, 2) . ' MB' : number_format($fileSizeBytes / 1024, 0) . ' KB';
        ?>
            <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                <span class="badge badge-primary" style="font-size: 13px; padding: 7px 12px; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fas fa-file-pdf"></i> <?= htmlspecialchars(basename($hostelData['rules_pdf_url'])) ?> (<?= $formattedSize ?>)
                </span>
                <a href="../<?= htmlspecialchars($hostelData['rules_pdf_url']) ?>" target="_blank" class="btn btn-sm btn-outline-primary" style="font-weight: 600;">
                    <i class="fas fa-eye"></i> View Current PDF
                </a>
                <form method="POST" action="hostel-mess?tab=rules" onsubmit="return confirm('Are you sure you want to permanently delete this Rules PDF? It will be completely removed from server storage and database.');" style="margin: 0; display: inline;">
                    <input type="hidden" name="action" value="delete_rules_pdf">
                    <button type="submit" class="btn btn-sm btn-outline-danger" style="font-weight: 600;">
                        <i class="fas fa-trash-alt"></i> Delete Current PDF
                    </button>
                </form>
            </div>
            <div style="margin-top: 10px; font-size: 12.5px; color: #64748b; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-shield-alt text-success"></i> 
                Auto-cleanup active: Jab aap naya PDF upload karenge, to ye purani file server disk se permanently delete ho jayegi.
            </div>
        <?php else: ?>
            <span style="color: #64748b;">No PDF document uploaded yet.</span>
        <?php endif; ?>
    </div>

    <form method="POST" action="hostel-mess?tab=rules" enctype="multipart/form-data">
        <input type="hidden" name="action" value="upload_rules_pdf">
        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label class="form-label" style="font-weight: 600;">Select New Hostel Rules &amp; Regulations PDF <span class="text-danger">*</span></label>
            <input type="file" name="rules_pdf" class="form-control" accept=".pdf" required>
            <small class="text-muted">PDF format only. Maximum file size: 25MB.</small>
        </div>
        <button type="submit" class="btn btn-primary" style="font-weight: 600;">
            <i class="fas fa-upload"></i> Upload &amp; Update Rules PDF
        </button>
    </form>
</div>
<?php endif; ?>

<!-- ========================================================================= -->
<!-- TAB 2: WARDEN & STAFF INCHARGE (ABOUT TAB) -->
<!-- ========================================================================= -->
<?php if ($activeTab === 'staff'): ?>
<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-<?= $editStaff ? 'edit' : 'plus-circle' ?> text-primary"></i>
        <?= $editStaff ? 'Edit Staff In-Charge' : 'Add New Staff / Warden In-Charge' ?>
    </div>
    <form method="POST" action="hostel-mess?tab=staff">
        <input type="hidden" name="action" value="<?= $editStaff ? 'edit_staff' : 'add_staff' ?>">
        <?php if ($editStaff): ?>
            <input type="hidden" name="id" value="<?= (int)$editStaff['id'] ?>">
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Section Type</label>
                <select name="section_type" class="form-control">
                    <option value="warden_caretaker" <?= (($editStaff['section_type'] ?? '') === 'warden_caretaker') ? 'selected' : '' ?>>Warden &amp; Care Taker (Block)</option>
                    <option value="works" <?= (($editStaff['section_type'] ?? '') === 'works') ? 'selected' : '' ?>>Works Section (Civil/Electrical/Admin)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Description of Work <span class="text-danger">*</span></label>
                <input type="text" name="work_description" class="form-control" required placeholder="Warden & Care Taker / Civil works / Electrical works" value="<?= htmlspecialchars($editStaff['work_description'] ?? 'Warden & Care Taker') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Block Name (If applicable)</label>
                <input type="text" name="block_name" class="form-control" placeholder="e.g. A, B, C, E (Ground Floor), F (Girl's Hostel)" value="<?= htmlspecialchars($editStaff['block_name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Warden Details</label>
                <textarea name="warden" class="form-control" rows="2" placeholder="e.g. Prof A. D. Chaudhari (Info. Tech. Dept.)"><?= htmlspecialchars($editStaff['warden'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Care Taker Details</label>
                <textarea name="care_taker" class="form-control" rows="2" placeholder="e.g. Prof. J. P. Pandya (Civil Dept.)"><?= htmlspecialchars($editStaff['care_taker'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Staff In-Charge (For Works Section)</label>
                <input type="text" name="staff_incharge" class="form-control" placeholder="e.g. Prof. D. A. Sagar (Applied Mechanics Dept.)" value="<?= htmlspecialchars($editStaff['staff_incharge'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Display Priority</label>
                <input type="number" name="display_order" class="form-control" value="<?= (int)($editStaff['display_order'] ?? (count($staffList) + 1)) ?>">
            </div>
        </div>

        <div style="margin-top: 1.25rem; display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary" style="font-weight: 600;">
                <i class="fas fa-save"></i> <?= $editStaff ? 'Update Entry' : 'Add Staff Entry' ?>
            </button>
            <?php if ($editStaff): ?>
                <a href="hostel-mess?tab=staff" class="btn btn-light">Cancel Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1rem;">
        Administrational Structure Directory &mdash; Duty Allocation &amp; Caretakers (<?= count($staffList) ?>)
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 50px;">Order</th>
                    <th>Type</th>
                    <th>Work Description</th>
                    <th>Block</th>
                    <th>Warden</th>
                    <th>Care Taker</th>
                    <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($staffList)): ?>
                    <tr class="no-records-row"><td colspan="7" class="text-center" style="padding: 2rem; color: #64748b;">No staff records found.</td></tr>
                <?php else: ?>
                    <?php foreach ($staffList as $s): ?>
                        <tr>
                            <td><span class="badge badge-light"><?= (int)$s['display_order'] ?></span></td>
                            <td><span class="badge badge-primary"><?= htmlspecialchars($s['section_type']) ?></span></td>
                            <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($s['work_description']) ?></td>
                            <td><span class="badge badge-light" style="font-weight: 700;"><?= htmlspecialchars($s['block_name'] ?: '--') ?></span></td>
                            <td><?= nl2br(htmlspecialchars($s['warden'] ?: ($s['staff_incharge'] ?? '--'))) ?></td>
                            <td><?= nl2br(htmlspecialchars($s['care_taker'] ?: '--')) ?></td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 0.4rem;">
                                    <a href="hostel-mess?tab=staff&edit_id=<?= (int)$s['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="hostel-mess?tab=staff" onsubmit="return confirm('Delete this staff record?');" style="margin: 0;">
                                        <input type="hidden" name="action" value="delete_staff">
                                        <input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- ========================================================================= -->
<!-- TAB 3: BLOCK CAPACITY -->
<!-- ========================================================================= -->
<?php if ($activeTab === 'blocks'): ?>
<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-<?= $editBlock ? 'edit' : 'plus-circle' ?> text-primary"></i>
        <?= $editBlock ? 'Edit Block Capacity' : 'Add New Block Capacity' ?>
    </div>
    <form method="POST" action="hostel-mess?tab=blocks">
        <input type="hidden" name="action" value="<?= $editBlock ? 'edit_block' : 'add_block' ?>">
        <?php if ($editBlock): ?>
            <input type="hidden" name="id" value="<?= (int)$editBlock['id'] ?>">
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Sr No.</label>
                <input type="number" name="sr_no" class="form-control" value="<?= (int)($editBlock['sr_no'] ?? (count($blocksList) + 1)) ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Block Name <span class="text-danger">*</span></label>
                <input type="text" name="block_name" class="form-control" required placeholder="e.g. A, B, C, E, F" value="<?= htmlspecialchars($editBlock['block_name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Number of Floor <span class="text-danger">*</span></label>
                <input type="text" name="number_of_floor" class="form-control" required placeholder="e.g. G + 2 / G + 3" value="<?= htmlspecialchars($editBlock['number_of_floor'] ?? 'G + 2') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Total Rooms <span class="text-danger">*</span></label>
                <input type="number" name="total_rooms" class="form-control" required value="<?= (int)($editBlock['total_rooms'] ?? 0) ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Number of Students <span class="text-danger">*</span></label>
                <input type="number" name="number_of_students" class="form-control" required value="<?= (int)($editBlock['number_of_students'] ?? 0) ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Display Priority</label>
                <input type="number" name="display_order" class="form-control" value="<?= (int)($editBlock['display_order'] ?? (count($blocksList) + 1)) ?>">
            </div>
        </div>

        <div style="margin-top: 1.25rem; display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary" style="font-weight: 600;">
                <i class="fas fa-save"></i> <?= $editBlock ? 'Update Block' : 'Add Block Entry' ?>
            </button>
            <?php if ($editBlock): ?>
                <a href="hostel-mess?tab=blocks" class="btn btn-light">Cancel Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1rem;">
        Hostel Block Wise Capacity Details
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 60px;">Sr No.</th>
                    <th>Block Name</th>
                    <th>Number of Floor</th>
                    <th>Total Rooms</th>
                    <th>Number of Students</th>
                    <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $rTot = 0; $sTot = 0;
                foreach ($blocksList as $b): 
                    $rTot += (int)$b['total_rooms'];
                    $sTot += (int)$b['number_of_students'];
                ?>
                    <tr>
                        <td><?= (int)$b['sr_no'] ?></td>
                        <td style="font-weight: 600; color: #0284c7;"><?= htmlspecialchars($b['block_name']) ?></td>
                        <td><?= htmlspecialchars($b['number_of_floor']) ?></td>
                        <td><?= (int)$b['total_rooms'] ?></td>
                        <td><?= (int)$b['number_of_students'] ?></td>
                        <td style="text-align: center;">
                            <div style="display: inline-flex; gap: 0.4rem;">
                                <a href="hostel-mess?tab=blocks&edit_id=<?= (int)$b['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="hostel-mess?tab=blocks" onsubmit="return confirm('Delete this block?');" style="margin: 0;">
                                    <input type="hidden" name="action" value="delete_block">
                                    <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr style="font-weight: 700; background: #f8fafc;">
                    <td></td>
                    <td>Total</td>
                    <td></td>
                    <td><?= $rTot ?></td>
                    <td><?= $sTot ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- ========================================================================= -->
<!-- TAB 4: FEES STRUCTURE -->
<!-- ========================================================================= -->
<?php if ($activeTab === 'fees'): ?>
<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-edit text-primary"></i> Edit Fees Guidelines &amp; Bullet Points
    </div>
    <form method="POST" action="hostel-mess?tab=fees">
        <input type="hidden" name="action" value="save_fee_notes">
        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label class="form-label" style="font-weight: 600;">Fees Guidelines (One bullet point per line)</label>
            <textarea name="fee_notes" class="form-control" rows="5"><?= htmlspecialchars($hostelData['fee_notes'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="font-weight: 600;">
            <i class="fas fa-save"></i> Save Fees Guidelines
        </button>
    </form>
</div>

<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-plus-circle text-primary"></i> Add Year Fee Row
    </div>
    <form method="POST" action="hostel-mess?tab=fees" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
        <input type="hidden" name="action" value="add_fee_row">
        <div class="form-group" style="flex: 1; min-width: 200px;">
            <label class="form-label" style="font-weight: 600;">Year / Semester</label>
            <input type="text" name="year_name" class="form-control" required placeholder="e.g. 1st year / 2nd year">
        </div>
        <div class="form-group" style="flex: 1; min-width: 200px;">
            <label class="form-label" style="font-weight: 600;">Hostel Fees (₹)</label>
            <input type="text" name="hostel_fees" class="form-control" required placeholder="e.g. 1750">
        </div>
        <div class="form-group" style="width: 120px;">
            <label class="form-label" style="font-weight: 600;">Order</label>
            <input type="number" name="display_order" class="form-control" value="<?= count($feesList) + 1 ?>">
        </div>
        <button type="submit" class="btn btn-primary" style="font-weight: 600; height: 42px;">
            <i class="fas fa-plus"></i> Add Fee Row
        </button>
    </form>
</div>

<div class="card">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1rem;">
        Current Fees Table
    </div>
    <div class="table-responsive" style="max-width: 700px;">
        <table class="table">
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Hostel Fees</th>
                    <th style="width: 100px; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($feesList as $f): ?>
                    <tr>
                        <td style="font-weight: 600;"><?= htmlspecialchars($f['year_name']) ?></td>
                        <td>₹ <?= htmlspecialchars($f['hostel_fees']) ?></td>
                        <td style="text-align: center;">
                            <form method="POST" action="hostel-mess?tab=fees" onsubmit="return confirm('Delete this fee entry?');" style="margin: 0;">
                                <input type="hidden" name="action" value="delete_fee_row">
                                <input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- ========================================================================= -->
<!-- TAB 5: MESS GUIDELINES -->
<!-- ========================================================================= -->
<?php if ($activeTab === 'mess'): ?>
<div class="card">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-utensils text-primary"></i> Edit Hostel Mess Guidelines &amp; Bullet Points
    </div>
    <form method="POST" action="hostel-mess?tab=mess">
        <input type="hidden" name="action" value="save_mess_notes">
        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label class="form-label" style="font-weight: 600;">Mess Guidelines (One bullet point per line)</label>
            <textarea name="mess_notes" class="form-control" rows="8"><?= htmlspecialchars($hostelData['mess_notes'] ?? '') ?></textarea>
            <small class="text-muted">Each line in this text will automatically render as an official bullet point with blue chevron icon on the public frontend.</small>
        </div>
        <button type="submit" class="btn btn-primary" style="font-weight: 600;">
            <i class="fas fa-save"></i> Save Mess Guidelines
        </button>
    </form>
</div>
<?php endif; ?>

<!-- ========================================================================= -->
<!-- TAB 6: PHOTOS GALLERY -->
<!-- ========================================================================= -->
<?php if ($activeTab === 'photos'): ?>
<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-upload text-primary"></i> Upload New Hostel Photo
    </div>
    <form method="POST" action="hostel-mess?tab=photos" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add_photo">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem; margin-bottom: 1.25rem;">
            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Photo Caption / Title <span class="text-danger">*</span></label>
                <input type="text" name="caption" class="form-control" required placeholder="e.g. New Hostel / Hostel Block A,B,C" value="New Hostel">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Select Image File <span class="text-danger">*</span></label>
                <input type="file" name="photo" class="form-control" accept="image/*" required>
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Display Priority</label>
                <input type="number" name="display_order" class="form-control" value="<?= count($photosList) + 1 ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="font-weight: 600;">
            <i class="fas fa-upload"></i> Upload Hostel Photo
        </button>
    </form>
</div>

<div class="card">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        Current Hostel Photos Gallery (<?= count($photosList) ?>)
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 18px;">
        <?php foreach ($photosList as $p): ?>
            <div style="border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden; background: #ffffff; display: flex; flex-direction: column;">
                <img src="../<?= htmlspecialchars($p['image_path']) ?>" alt="<?= htmlspecialchars($p['caption']) ?>" style="width: 100%; height: 140px; object-fit: cover; background: #f1f5f9;" onerror="this.src='../images/hero_campus_1.jpg'">
                <div style="padding: 10px; font-weight: 600; font-size: 13.5px; color: #1e293b; text-align: center; border-top: 1px solid #f1f5f9;">
                    <?= htmlspecialchars($p['caption']) ?>
                </div>
                <div style="padding: 0 10px 10px 10px; text-align: center;">
                    <form method="POST" action="hostel-mess?tab=photos" onsubmit="return confirm('Delete this photo?');" style="margin: 0;">
                        <input type="hidden" name="action" value="delete_photo">
                        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger" style="width: 100%;">
                            <i class="fas fa-trash-alt"></i> Delete Photo
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
