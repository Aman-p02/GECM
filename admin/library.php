<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage Central Library";
$current_page = 'library';

// Ensure tables exist
if ($pdo) {
    try {
        $pdo->query("SELECT 1 FROM library_catalogues LIMIT 1");
    } catch (Exception $e) {
        // Run migration if tables do not exist
        require_once __DIR__ . '/../database/migrate_library.php';
    }
}

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: library.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    // ==========================================
    // ACTION: UPLOAD / REPLACE XLSX CATALOGUE FILE
    // ==========================================
    if ($action === 'upload_catalogue') {
        $catId = (int)($_POST['id'] ?? 0);
        if ($catId <= 0) {
            setFlashMessage('danger', 'Invalid department catalogue record.');
            header('Location: library.php');
            exit;
        }

        if (isset($_FILES['xlsx_file']) && $_FILES['xlsx_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['xlsx_file'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowedExts = ['xlsx', 'xls', 'csv'];

            if (!in_array($ext, $allowedExts)) {
                setFlashMessage('danger', 'Only Excel files (.xlsx, .xls) or CSV files are allowed.');
                header('Location: library.php');
                exit;
            }

            if ($file['size'] > 20 * 1024 * 1024) {
                setFlashMessage('danger', 'File size exceeds maximum limit of 20MB.');
                header('Location: library.php');
                exit;
            }

            // Upload directory
            $targetDir = __DIR__ . '/../uploads/library_catalogues/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Clean sanitized filename
            $cleanFilename = 'catalogue_dept_' . $catId . '_' . time() . '.' . $ext;
            $targetPath = $targetDir . $cleanFilename;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                // Delete previous file if exists
                $stmtPrev = $pdo->prepare("SELECT file_path FROM library_catalogues WHERE id = ?");
                $stmtPrev->execute([$catId]);
                $oldRow = $stmtPrev->fetch();
                if ($oldRow && !empty($oldRow['file_path'])) {
                    $oldFilePath = __DIR__ . '/../' . ltrim($oldRow['file_path'], '/');
                    if (file_exists($oldFilePath) && is_file($oldFilePath)) {
                        @unlink($oldFilePath);
                    }
                }

                $bytes = $file['size'];
                $sizeStr = ($bytes >= 1048576) ? number_format($bytes / 1048576, 2) . ' MB' : number_format($bytes / 1024, 0) . ' KB';
                $relativePath = 'uploads/library_catalogues/' . $cleanFilename;

                $stmtUpdate = $pdo->prepare("UPDATE library_catalogues SET file_path = ?, file_size = ? WHERE id = ?");
                $stmtUpdate->execute([$relativePath, $sizeStr, $catId]);

                setFlashMessage('success', 'Catalogue XLSX file uploaded successfully.');
            } else {
                setFlashMessage('danger', 'Could not save the uploaded file to server directory.');
            }
        } else {
            setFlashMessage('danger', 'Please select a valid .xlsx file to upload.');
        }

        header('Location: library.php');
        exit;
    }

    // ==========================================
    // ACTION: REMOVE CATALOGUE FILE
    // ==========================================
    if ($action === 'remove_catalogue') {
        $catId = (int)($_POST['id'] ?? 0);
        if ($catId > 0) {
            $stmt = $pdo->prepare("SELECT file_path FROM library_catalogues WHERE id = ?");
            $stmt->execute([$catId]);
            $row = $stmt->fetch();
            if ($row && !empty($row['file_path'])) {
                $filePath = __DIR__ . '/../' . ltrim($row['file_path'], '/');
                if (file_exists($filePath) && is_file($filePath)) {
                    @unlink($filePath);
                }
            }
            $stmtClear = $pdo->prepare("UPDATE library_catalogues SET file_path = NULL, file_size = NULL WHERE id = ?");
            $stmtClear->execute([$catId]);
            setFlashMessage('success', 'Catalogue file removed.');
        }
        header('Location: library.php');
        exit;
    }

    // ==========================================
    // ACTION: ADD FACULTY OR STAFF MEMBER
    // ==========================================
    if ($action === 'add_member') {
        $name = trim($_POST['name'] ?? '');
        $team_type = ($_POST['team_type'] ?? '') === 'staff' ? 'staff' : 'committee';
        $department_info = trim($_POST['department_info'] ?? '');
        $designation = trim($_POST['designation'] ?? 'Member');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if (empty($name)) {
            setFlashMessage('danger', 'Please enter the member name.');
            header('Location: library.php?tab=team');
            exit;
        }

        // Set appropriate badge class
        $badge_class = 'dept-tag-ug';
        if (stripos($designation, 'Incharge') !== false || stripos($designation, 'In-charge') !== false) {
            if (stripos($designation, 'Assistant') !== false) {
                $badge_class = 'dept-tag-asst';
            } elseif (stripos($designation, 'Librarian') !== false) {
                $badge_class = 'dept-tag-librarian';
            } else {
                $badge_class = 'dept-tag-incharge';
            }
        }

        $stmt = $pdo->prepare("INSERT INTO library_team (team_type, name, department_info, designation, badge_class, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, 1)");
        $stmt->execute([$team_type, $name, $department_info, $designation, $badge_class, $display_order]);

        setFlashMessage('success', 'New library member added successfully.');
        header('Location: library.php?tab=team');
        exit;
    }

    // ==========================================
    // ACTION: EDIT FACULTY OR STAFF MEMBER
    // ==========================================
    if ($action === 'edit_member') {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $team_type = ($_POST['team_type'] ?? '') === 'staff' ? 'staff' : 'committee';
        $department_info = trim($_POST['department_info'] ?? '');
        $designation = trim($_POST['designation'] ?? 'Member');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if ($id <= 0 || empty($name)) {
            setFlashMessage('danger', 'Please enter a valid member name.');
            header('Location: library.php?tab=team');
            exit;
        }

        $badge_class = 'dept-tag-ug';
        if (stripos($designation, 'Incharge') !== false || stripos($designation, 'In-charge') !== false) {
            if (stripos($designation, 'Assistant') !== false) {
                $badge_class = 'dept-tag-asst';
            } elseif (stripos($designation, 'Librarian') !== false) {
                $badge_class = 'dept-tag-librarian';
            } else {
                $badge_class = 'dept-tag-incharge';
            }
        }

        $stmt = $pdo->prepare("UPDATE library_team SET team_type = ?, name = ?, department_info = ?, designation = ?, badge_class = ?, display_order = ? WHERE id = ?");
        $stmt->execute([$team_type, $name, $department_info, $designation, $badge_class, $display_order, $id]);

        setFlashMessage('success', 'Library member details updated successfully.');
        header('Location: library.php?tab=team');
        exit;
    }

    // ==========================================
    // ACTION: DELETE MEMBER
    // ==========================================
    if ($action === 'delete_member') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM library_team WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('success', 'Member removed successfully.');
        }
        header('Location: library.php?tab=team');
        exit;
    }
}

// Fetch Catalogues and Members
$catalogues = [];
$committeeMembers = [];
$staffMembers = [];

if ($pdo) {
    try {
        $catalogues = $pdo->query("SELECT * FROM library_catalogues ORDER BY display_order ASC, id ASC")->fetchAll();
        $committeeMembers = $pdo->query("SELECT * FROM library_team WHERE team_type = 'committee' ORDER BY display_order ASC, id ASC")->fetchAll();
        $staffMembers = $pdo->query("SELECT * FROM library_team WHERE team_type = 'staff' ORDER BY display_order ASC, id ASC")->fetchAll();
    } catch (Exception $e) {
        $catalogues = [];
        $committeeMembers = [];
        $staffMembers = [];
    }
}

$activeTab = $_GET['tab'] ?? 'catalogues';

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px;">
            <i class="fas fa-book-reader" style="color: var(--admin-primary); margin-right: 8px;"></i>Manage Central Library
        </h1>
        <p style="color: #64748b; margin: 0; font-size: 13.5px;">Upload department-wise XLSX catalogues and manage Library Committee faculty &amp; staff members.</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="../academics/central-library.php" target="_blank" class="btn" style="background: #fff; border: 1px solid #ced4da; color: #374151; font-size: 13px;">
            <i class="fas fa-external-link-alt" style="margin-right: 6px;"></i> View Library Page
        </a>
    </div>
</div>

<?php renderFlashMessage(); ?>

<!-- Tab navigation pills -->
<div style="display: flex; gap: 8px; margin-bottom: 24px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
    <a href="library.php?tab=catalogues" class="btn <?= ($activeTab === 'catalogues') ? 'btn-primary' : 'btn-outline-secondary' ?>" style="font-size: 13.5px; font-weight: 600;">
        <i class="fas fa-file-excel" style="margin-right: 6px;"></i> Book Catalogues (XLSX Uploads)
    </a>
    <a href="library.php?tab=team" class="btn <?= ($activeTab === 'team') ? 'btn-primary' : 'btn-outline-secondary' ?>" style="font-size: 13.5px; font-weight: 600;">
        <i class="fas fa-users" style="margin-right: 6px;"></i> Library Faculty &amp; Staff
    </a>
</div>

<?php if ($activeTab === 'catalogues'): ?>
    <!-- ========================================================================= -->
    <!-- TAB 1: BOOK CATALOGUES (XLSX UPLOADS)                                     -->
    <!-- ========================================================================= -->
    <div class="admin-card" style="background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <div>
                <h2 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 4px;">Department Book Collections &amp; Catalogue Sheets</h2>
                <p style="color: #64748b; margin: 0; font-size: 13px;">Upload an <strong>.xlsx</strong> or <strong>.xls</strong> spreadsheet for each department. Uploaded files will show a <strong>"View"</strong> button on the public website.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" style="width: 100%; border-collapse: collapse; font-size: 13.5px;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left;">
                        <th style="padding: 12px 14px; width: 6%; text-align: center;">#</th>
                        <th style="padding: 12px 14px; width: 38%;">Course / Department</th>
                        <th style="padding: 12px 14px; width: 14%; text-align: center;">Titles / Volumes</th>
                        <th style="padding: 12px 14px; width: 22%;">Catalogue File Status</th>
                        <th style="padding: 12px 14px; width: 20%; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($catalogues)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 24px; color: #94a3b8;">No catalogue departments found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($catalogues as $idx => $cat): ?>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 14px; text-align: center; color: #64748b; font-weight: 600;"><?= $idx + 1 ?></td>
                                <td style="padding: 14px;">
                                    <strong style="color: #1e293b; display: block; font-size: 14px;"><?= htmlspecialchars($cat['dept_name']) ?></strong>
                                    <?php if (!empty($cat['subtext'])): ?>
                                        <div style="color: #64748b; font-size: 12px; margin-top: 2px;"><?= htmlspecialchars($cat['subtext']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 14px; text-align: center;">
                                    <span style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($cat['titles_count']) ?></span> Titles
                                    <div style="font-size: 12px; color: #64748b;"><?= htmlspecialchars($cat['volume_count']) ?> Volumes</div>
                                </td>
                                <td style="padding: 14px;">
                                    <?php if (!empty($cat['file_path'])): ?>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span class="badge" style="background: #10b981; color: #fff; padding: 5px 8px; border-radius: 4px; font-weight: 600; font-size: 11.5px;">
                                                <i class="fas fa-file-excel"></i> XLSX Uploaded
                                            </span>
                                            <a href="../<?= htmlspecialchars(ltrim($cat['file_path'], '/')) ?>" target="_blank" download style="color: #0284c7; text-decoration: none; font-size: 12px; font-weight: 600;">
                                                <i class="fas fa-download"></i> <?= htmlspecialchars($cat['file_size'] ?? 'Download') ?>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge" style="background: #f1f5f9; color: #64748b; padding: 5px 8px; border-radius: 4px; font-size: 11.5px; border: 1px solid #e2e8f0;">
                                            <i class="fas fa-times-circle"></i> No File (Shows 'Barcoded')
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 14px; text-align: right;">
                                    <button type="button" class="btn btn-sm" style="background: #ff8800; color: #fff; font-size: 12.5px; padding: 6px 12px; border-radius: 4px; font-weight: 600;" onclick="openUploadModal(<?= $cat['id'] ?>, '<?= htmlspecialchars(addslashes($cat['dept_name'])) ?>', '<?= !empty($cat['file_path']) ? 'replace' : 'upload' ?>')">
                                        <i class="fas fa-upload" style="margin-right: 4px;"></i> <?= !empty($cat['file_path']) ? 'Replace XLSX' : 'Upload XLSX' ?>
                                    </button>
                                    <?php if (!empty($cat['file_path'])): ?>
                                        <form method="POST" action="library.php" style="display: inline-block; margin-left: 4px;" onsubmit="return confirm('Remove this catalogue file?');">
                                            <input type="hidden" name="action" value="remove_catalogue">
                                            <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Remove XLSX File" style="padding: 6px 10px; font-size: 12px;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Upload XLSX Modal -->
    <div id="uploadModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: #fff; border-radius: 8px; width: 100%; max-width: 480px; padding: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="margin: 0; font-size: 17px; font-weight: 700; color: #1e293b;">
                    <i class="fas fa-file-excel" style="color: #10b981; margin-right: 8px;"></i><span id="modalTitle">Upload XLSX Catalogue</span>
                </h3>
                <button type="button" onclick="closeUploadModal()" style="border: none; background: transparent; font-size: 18px; cursor: pointer; color: #64748b;">&times;</button>
            </div>
            <form method="POST" action="library.php" enctype="multipart/form-data">
                <input type="hidden" name="action" value="upload_catalogue">
                <input type="hidden" name="id" id="uploadCatId" value="0">

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; font-size: 13px; color: #374151; margin-bottom: 4px;">Department</label>
                    <input type="text" id="uploadDeptName" class="form-control" readonly style="background: #f8fafc; font-weight: 600; color: #1e293b;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; font-size: 13px; color: #374151; margin-bottom: 6px;">Select Excel Spreadsheet (.xlsx, .xls)</label>
                    <input type="file" name="xlsx_file" accept=".xlsx,.xls,.csv" required class="form-control" style="font-size: 13px;">
                    <small style="color: #64748b; font-size: 12px; display: block; margin-top: 4px;">File will be linked directly to the "View" button for this department.</small>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                    <button type="button" class="btn btn-secondary" onclick="closeUploadModal()">Cancel</button>
                    <button type="submit" class="btn btn-success" style="font-weight: 600;">
                        <i class="fas fa-cloud-upload-alt"></i> Save &amp; Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php else: ?>
    <!-- ========================================================================= -->
    <!-- TAB 2: LIBRARY FACULTY & STAFF MANAGEMENT                                 -->
    <!-- ========================================================================= -->
    
    <!-- 1. Faculty Committee Section -->
    <div class="admin-card" style="background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 28px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
            <div>
                <h2 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 4px;">
                    <i class="fas fa-users" style="color: #ff8800; margin-right: 6px;"></i> Library Committee (Faculty Team)
                </h2>
                <p style="color: #64748b; margin: 0; font-size: 13px;">Add, edit name/designation, or remove faculty members of the Library Committee.</p>
            </div>
            <div>
                <button type="button" class="btn btn-primary" onclick="openMemberModal('add', 'committee')" style="font-weight: 600; font-size: 13px;">
                    <i class="fas fa-plus"></i> Add Faculty Member
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" style="width: 100%; border-collapse: collapse; font-size: 13.5px;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left;">
                        <th style="padding: 10px 14px; width: 6%; text-align: center;">Order</th>
                        <th style="padding: 10px 14px; width: 44%;">Faculty Member Name &amp; Academic Role</th>
                        <th style="padding: 10px 14px; width: 30%;">Library Designation</th>
                        <th style="padding: 10px 14px; width: 20%; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($committeeMembers)): ?>
                        <tr><td colspan="4" style="text-align: center; padding: 20px; color: #94a3b8;">No committee members recorded.</td></tr>
                    <?php else: ?>
                        <?php foreach ($committeeMembers as $mem): ?>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 12px 14px; text-align: center; font-weight: 600; color: #64748b;"><?= $mem['display_order'] ?></td>
                                <td style="padding: 12px 14px;">
                                    <strong style="color: #1e293b; font-size: 14px; display: block;"><?= htmlspecialchars($mem['name']) ?></strong>
                                    <div style="color: #64748b; font-size: 12px; margin-top: 2px;"><?= htmlspecialchars($mem['department_info']) ?></div>
                                </td>
                                <td style="padding: 12px 14px;">
                                    <span class="badge" style="background: #fff7ed; color: #c2410c; border: 1px solid rgba(255,136,0,0.25); padding: 5px 9px; border-radius: 4px; font-weight: 600; font-size: 12px;">
                                        <?= htmlspecialchars($mem['designation']) ?>
                                    </span>
                                </td>
                                <td style="padding: 12px 14px; text-align: right;">
                                    <button type="button" class="btn btn-sm btn-outline-primary" style="padding: 4px 10px; font-size: 12px; margin-right: 4px;" onclick='openMemberModal("edit", "committee", <?= json_encode($mem) ?>)'>
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form method="POST" action="library.php" style="display: inline-block;" onsubmit="return confirm('Delete this member?');">
                                        <input type="hidden" name="action" value="delete_member">
                                        <input type="hidden" name="id" value="<?= $mem['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 4px 8px; font-size: 12px;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. Library Staff Section -->
    <div class="admin-card" style="background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
            <div>
                <h2 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 4px;">
                    <i class="fas fa-id-badge" style="color: #0284c7; margin-right: 6px;"></i> Library Administrative &amp; Technical Staff
                </h2>
                <p style="color: #64748b; margin: 0; font-size: 13px;">Manage librarians and operational staff of the Learning Resource Centre.</p>
            </div>
            <div>
                <button type="button" class="btn btn-primary" onclick="openMemberModal('add', 'staff')" style="font-weight: 600; font-size: 13px;">
                    <i class="fas fa-plus"></i> Add Staff Member
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" style="width: 100%; border-collapse: collapse; font-size: 13.5px;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left;">
                        <th style="padding: 10px 14px; width: 6%; text-align: center;">Order</th>
                        <th style="padding: 10px 14px; width: 44%;">Staff Member Name &amp; Division</th>
                        <th style="padding: 10px 14px; width: 30%;">Designation / Role</th>
                        <th style="padding: 10px 14px; width: 20%; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($staffMembers)): ?>
                        <tr><td colspan="4" style="text-align: center; padding: 20px; color: #94a3b8;">No library staff recorded.</td></tr>
                    <?php else: ?>
                        <?php foreach ($staffMembers as $stf): ?>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 12px 14px; text-align: center; font-weight: 600; color: #64748b;"><?= $stf['display_order'] ?></td>
                                <td style="padding: 12px 14px;">
                                    <strong style="color: #1e293b; font-size: 14px; display: block;"><?= htmlspecialchars($stf['name']) ?></strong>
                                    <div style="color: #64748b; font-size: 12px; margin-top: 2px;"><?= htmlspecialchars($stf['department_info']) ?></div>
                                </td>
                                <td style="padding: 12px 14px;">
                                    <span class="badge" style="background: #f0fdf4; color: #166534; border: 1px solid rgba(22,101,52,0.2); padding: 5px 9px; border-radius: 4px; font-weight: 600; font-size: 12px;">
                                        <?= htmlspecialchars($stf['designation']) ?>
                                    </span>
                                </td>
                                <td style="padding: 12px 14px; text-align: right;">
                                    <button type="button" class="btn btn-sm btn-outline-primary" style="padding: 4px 10px; font-size: 12px; margin-right: 4px;" onclick='openMemberModal("edit", "staff", <?= json_encode($stf) ?>)'>
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form method="POST" action="library.php" style="display: inline-block;" onsubmit="return confirm('Delete this staff member?');">
                                        <input type="hidden" name="action" value="delete_member">
                                        <input type="hidden" name="id" value="<?= $stf['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 4px 8px; font-size: 12px;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Member Modal (Add / Edit) -->
    <div id="memberModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: #fff; border-radius: 8px; width: 100%; max-width: 480px; padding: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="margin: 0; font-size: 17px; font-weight: 700; color: #1e293b;" id="memberModalTitle">Add Member</h3>
                <button type="button" onclick="closeMemberModal()" style="border: none; background: transparent; font-size: 18px; cursor: pointer; color: #64748b;">&times;</button>
            </div>
            <form method="POST" action="library.php">
                <input type="hidden" name="action" id="memberAction" value="add_member">
                <input type="hidden" name="id" id="memberId" value="0">
                <input type="hidden" name="team_type" id="memberTeamType" value="committee">

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-weight: 600; font-size: 13px; color: #374151; margin-bottom: 4px;">Full Name *</label>
                    <input type="text" name="name" id="memberName" required class="form-control" placeholder="e.g. Prof. Nirali V. Upadhyay">
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-weight: 600; font-size: 13px; color: #374151; margin-bottom: 4px;">Department / Subtitle</label>
                    <input type="text" name="department_info" id="memberDept" class="form-control" placeholder="e.g. Assistant Professor, Electrical Engineering (AP.EE)">
                </div>

                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-weight: 600; font-size: 13px; color: #374151; margin-bottom: 4px;">Designation / Role in Library *</label>
                    <input type="text" name="designation" id="memberDesignation" required class="form-control" placeholder="e.g. Library Incharge / Member / In-charge (Librarian)">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; font-size: 13px; color: #374151; margin-bottom: 4px;">Display Order</label>
                    <input type="number" name="display_order" id="memberOrder" value="1" min="1" max="99" class="form-control" style="width: 100px;">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                    <button type="button" class="btn btn-secondary" onclick="closeMemberModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="font-weight: 600;">Save Member</button>
                </div>
            </form>
        </div>
    </div>

<?php endif; ?>

<script>
function openUploadModal(id, deptName, mode) {
    document.getElementById('uploadCatId').value = id;
    document.getElementById('uploadDeptName').value = deptName;
    document.getElementById('modalTitle').textContent = mode === 'replace' ? 'Replace XLSX Catalogue' : 'Upload XLSX Catalogue';
    const modal = document.getElementById('uploadModal');
    modal.style.display = 'flex';
}

function closeUploadModal() {
    const modal = document.getElementById('uploadModal');
    modal.style.display = 'none';
}

function openMemberModal(action, teamType, data) {
    document.getElementById('memberAction').value = action === 'edit' ? 'edit_member' : 'add_member';
    document.getElementById('memberTeamType').value = teamType;
    document.getElementById('memberModalTitle').textContent = action === 'edit' ? 'Edit Member Details' : (teamType === 'staff' ? 'Add Staff Member' : 'Add Faculty Member');

    if (action === 'edit' && data) {
        document.getElementById('memberId').value = data.id || 0;
        document.getElementById('memberName').value = data.name || '';
        document.getElementById('memberDept').value = data.department_info || '';
        document.getElementById('memberDesignation').value = data.designation || '';
        document.getElementById('memberOrder').value = data.display_order || 1;
    } else {
        document.getElementById('memberId').value = 0;
        document.getElementById('memberName').value = '';
        document.getElementById('memberDept').value = '';
        document.getElementById('memberDesignation').value = teamType === 'staff' ? 'In-charge (Librarian)' : 'Member';
        document.getElementById('memberOrder').value = 1;
    }

    const modal = document.getElementById('memberModal');
    modal.style.display = 'flex';
}

function closeMemberModal() {
    const modal = document.getElementById('memberModal');
    modal.style.display = 'none';
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
