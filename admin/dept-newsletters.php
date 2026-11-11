<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

// Department resolution
$deptCode = strtoupper(trim($_GET['dept'] ?? 'CE'));
$validDepts = [
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

if (!isset($validDepts[$deptCode])) {
    $deptCode = 'CE';
}
$deptName = $validDepts[$deptCode];

$deptFolderMap = [
    'CE'    => 'computer',
    'IT'    => 'information-technology',
    'ME'    => 'mechanical',
    'CIVIL' => 'civil',
    'AE'    => 'automobile',
    'AM'    => 'applied-mechanics',
];
$liveDeptFolder = $deptFolderMap[$deptCode] ?? 'computer';
$livePageUrl = "../departments/{$liveDeptFolder}/index.php#newsletters";

// Guard against DB connection failure on write requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: dept-newsletters.php?dept=' . $deptCode);
        exit;
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $volume_issue = trim($_POST['volume_issue'] ?? '');
        $issue_period = trim($_POST['issue_period'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title)) {
            setFlashMessage('danger', 'Newsletter Name / Title cannot be empty.');
            header('Location: dept-newsletters.php?dept=' . $deptCode);
            exit;
        }

        if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
            setFlashMessage('danger', 'Please upload a PDF file.');
            header('Location: dept-newsletters.php?dept=' . $deptCode);
            exit;
        }

        $uploadResult = handlePdfUpload('pdf_file', 'newsletters');
        if (!$uploadResult['success']) {
            setFlashMessage('danger', 'PDF upload error: ' . $uploadResult['error']);
            header('Location: dept-newsletters.php?dept=' . $deptCode);
            exit;
        }

        $pdf_path = $uploadResult['path'];
        $file_size = $uploadResult['file_size'];

        try {
            $stmt = $pdo->prepare("
                INSERT INTO department_newsletters 
                (dept_code, title, volume_issue, issue_period, pdf_file, file_size, display_order, is_active) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $deptCode,
                $title,
                $volume_issue,
                $issue_period,
                $pdf_path,
                $file_size,
                $display_order,
                $is_active
            ]);
            setFlashMessage('success', "Newsletter '{$title}' added successfully.");
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }
        header('Location: dept-newsletters.php?dept=' . $deptCode);
        exit;
    }

    if ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $volume_issue = trim($_POST['volume_issue'] ?? '');
        $issue_period = trim($_POST['issue_period'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_pdf = trim($_POST['existing_pdf'] ?? '');
        $existing_size = trim($_POST['existing_size'] ?? '');

        if (empty($title) || $id <= 0) {
            setFlashMessage('danger', 'Invalid newsletter data or ID.');
            header('Location: dept-newsletters.php?dept=' . $deptCode);
            exit;
        }

        $pdf_path = $existing_pdf;
        $file_size = $existing_size;

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = handlePdfUpload('pdf_file', 'newsletters', $existing_pdf);
            if ($uploadResult['success']) {
                $pdf_path = $uploadResult['path'];
                $file_size = $uploadResult['file_size'];
            } else {
                setFlashMessage('warning', 'PDF upload failed: ' . $uploadResult['error'] . '. Retained existing PDF.');
            }
        }

        try {
            $stmt = $pdo->prepare("
                UPDATE department_newsletters 
                SET title = ?, volume_issue = ?, issue_period = ?, pdf_file = ?, file_size = ?, display_order = ?, is_active = ?
                WHERE id = ? AND dept_code = ?
            ");
            $stmt->execute([
                $title,
                $volume_issue,
                $issue_period,
                $pdf_path,
                $file_size,
                $display_order,
                $is_active,
                $id,
                $deptCode
            ]);
            setFlashMessage('success', "Newsletter '{$title}' updated successfully.");
        } catch (Exception $e) {
            setFlashMessage('danger', 'Update failed: ' . $e->getMessage());
        }
        header('Location: dept-newsletters.php?dept=' . $deptCode);
        exit;
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            try {
                $stmt = $pdo->prepare("SELECT pdf_file, title FROM department_newsletters WHERE id = ? AND dept_code = ?");
                $stmt->execute([$id, $deptCode]);
                $item = $stmt->fetch();
                if ($item) {
                    if (!empty($item['pdf_file'])) {
                        deleteUploadedFile($item['pdf_file']);
                    }
                    $delStmt = $pdo->prepare("DELETE FROM department_newsletters WHERE id = ? AND dept_code = ?");
                    $delStmt->execute([$id, $deptCode]);
                    setFlashMessage('success', "Newsletter '{$item['title']}' deleted successfully.");
                }
            } catch (Exception $e) {
                setFlashMessage('danger', 'Delete error: ' . $e->getMessage());
            }
        }
        header('Location: dept-newsletters.php?dept=' . $deptCode);
        exit;
    }

    if ($action === 'toggle_active') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            try {
                $stmt = $pdo->prepare("UPDATE department_newsletters SET is_active = 1 - is_active WHERE id = ? AND dept_code = ?");
                $stmt->execute([$id, $deptCode]);
                setFlashMessage('success', 'Status toggled successfully.');
            } catch (Exception $e) {
                setFlashMessage('danger', 'Status toggle failed: ' . $e->getMessage());
            }
        }
        header('Location: dept-newsletters.php?dept=' . $deptCode);
        exit;
    }
}

if (isset($_GET['edit']) && $pdo) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM department_newsletters WHERE id = ? AND dept_code = ?");
        $stmt->execute([$id, $deptCode]);
        $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Fetch list of newsletters
$newsletters = [];
if ($pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT * FROM department_newsletters 
            WHERE dept_code = ? 
            ORDER BY display_order ASC, id DESC
        ");
        $stmt->execute([$deptCode]);
        $newsletters = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $newsletters = [];
    }
}

$current_page = 'dept-newsletters';
$page_title = "Newsletters - " . $deptName;
require_once __DIR__ . '/includes/header.php';
?>

<!-- Department Modules Navigation Bar -->
<div style="background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 12px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <span style="font-size: 15px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-layer-group" style="color: #2563eb;"></i> <?= htmlspecialchars($deptName) ?> (<?= htmlspecialchars($deptCode) ?>)
        </span>
    </div>

    <!-- Sub-modules of this Department -->
    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
        <a href="dept-faculty.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-users" style="margin-right: 6px;"></i> Faculty Members
        </a>
        <a href="dept-activities.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-calendar-check" style="margin-right: 6px;"></i> Activities
        </a>
        <a href="dept-publications.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-book" style="margin-right: 6px;"></i> Publications
        </a>
        <a href="dept-board.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-user-tie" style="margin-right: 6px;"></i> Advisory Board
        </a>
        <a href="dept-newsletters.php?dept=<?= urlencode($deptCode) ?>" class="btn-sm" style="background: #1e90ff; color: #ffffff; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-newspaper" style="margin-right: 6px;"></i> Newsletters
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <h2 class="card-title"><?= htmlspecialchars($deptName) ?> - Newsletters &amp; Periodicals</h2>
            <p style="color: #64748b; font-size: 13.5px; margin-top: 4px;">
                Upload and manage departmental semester magazines, technical newsletters, and periodicals.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="<?= htmlspecialchars($livePageUrl) ?>" target="_blank" class="btn-secondary" style="text-decoration: none; display: flex; align-items: center; gap: 6px; padding: 8px 16px;">
                <i class="fas fa-external-link-alt"></i> View Live Page
            </a>
            <button type="button" class="btn-add-new" onclick="openModal('addNlModal')">
                + Upload Newsletter
            </button>
        </div>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="card-filters" style="margin-left: auto;">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search newsletter name, issue..." data-table-search="nlTable">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="admin-table" id="nlTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th style="width: 80px; text-align: center;">PDF</th>
                    <th>Newsletter Name / Title</th>
                    <th style="width: 140px;">Volume / Issue</th>
                    <th style="width: 140px;">Period</th>
                    <th style="width: 100px;">Size</th>
                    <th style="width: 90px; text-align: center;">Status</th>
                    <th style="width: 120px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($newsletters)): ?>
                    <tr class="no-records-row">
                        <td colspan="8" style="text-align: center; padding: 48px; color: #64748b;">
                            <i class="fas fa-newspaper" style="font-size: 32px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                            No newsletters uploaded yet for <?= htmlspecialchars($deptName) ?>. Click "+ Upload Newsletter" above.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($newsletters as $item): ?>
                        <tr>
                            <td>
                                <span class="badge" style="background: #f1f5f9; color: #475569; font-weight: 700;">
                                    #<?= htmlspecialchars($item['display_order']) ?>
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a href="../<?= htmlspecialchars($item['pdf_file']) ?>" target="_blank" title="View PDF in new tab" style="color: #0284c7; font-size: 24px; text-decoration: none;">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </td>
                            <td>
                                <div style="font-weight: 600; font-size: 14.5px; color: #0f172a;">
                                    <a href="../<?= htmlspecialchars($item['pdf_file']) ?>" target="_blank" style="color: #0f172a; text-decoration: none;">
                                        <?= htmlspecialchars($item['title']) ?>
                                    </a>
                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                                    <a href="../<?= htmlspecialchars($item['pdf_file']) ?>" target="_blank" style="color: #0284c7; text-decoration: none;">
                                        <i class="fas fa-external-link-alt" style="margin-right: 3px;"></i> Open in New Tab
                                    </a>
                                </div>
                            </td>
                            <td>
                                <?php if (!empty($item['volume_issue'])): ?>
                                    <span style="font-weight: 600; color: #334155; font-size: 13px; background: #f8fafc; padding: 3px 8px; border-radius: 4px; border: 1px solid #e2e8f0;">
                                        <?= htmlspecialchars($item['volume_issue']) ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: #94a3b8; font-size: 12px;"> - </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($item['issue_period'])): ?>
                                    <span style="font-weight: 500; color: #166534; font-size: 12.5px; background: #f0fdf4; padding: 3px 8px; border-radius: 4px; border: 1px solid #bbf7d0;">
                                        <?= htmlspecialchars($item['issue_period']) ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: #94a3b8; font-size: 12px;"> - </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span style="font-size: 12.5px; color: #64748b; font-weight: 500;">
                                    <?= htmlspecialchars($item['file_size'] ?: 'PDF') ?>
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="toggle_active">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="status-badge <?= $item['is_active'] ? 'status-active' : 'status-inactive' ?>" style="cursor: pointer; border: none;" title="Click to toggle status">
                                        <?= $item['is_active'] ? 'Active' : 'Hidden' ?>
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: right;">
                                <div class="action-buttons" style="justify-content: flex-end;">
                                    <a href="dept-newsletters.php?dept=<?= $deptCode ?>&edit=<?= $item['id'] ?>" class="btn-action btn-edit" title="Edit Newsletter">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete newsletter: <?= addslashes(htmlspecialchars($item['title'])) ?>?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                        <button type="submit" class="btn-action btn-delete" title="Delete Newsletter">
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

<!-- ============================================================== -->
<!-- MODAL: UPLOAD NEW NEWSLETTER                                   -->
<!-- ============================================================== -->
<div class="admin-modal" id="addNlModal">
    <div class="modal-dialog" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title">Upload Newsletter (<?= htmlspecialchars($deptName) ?>)</h3>
            <button type="button" class="btn-close-modal" onclick="closeModal('addNlModal')">&times;</button>
        </div>
        <form action="dept-newsletters.php?dept=<?= $deptCode ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="add_title">Newsletter Name / Title <span class="required">*</span></label>
                    <input type="text" name="title" id="add_title" class="form-control" placeholder="e.g. ByteCraft - Department Technical Newsletter" required>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="add_vol">Volume / Issue (Optional)</label>
                        <input type="text" name="volume_issue" id="add_vol" class="form-control" placeholder="e.g. Vol. 5, Issue 1">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="add_period">Period / Year (Optional)</label>
                        <input type="text" name="issue_period" id="add_period" class="form-control" placeholder="e.g. Jan - Jun 2025">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_order">Display Order</label>
                    <input type="number" name="display_order" id="add_order" class="form-control" value="0">
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_pdf">Select PDF Document <span class="required">*</span></label>
                    <input type="file" name="pdf_file" id="add_pdf" class="form-control" accept="application/pdf,.pdf" required>
                    <small style="color: #64748b; font-size: 11px;">Max allowed size: 25MB. Must be a valid .pdf file.</small>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Display on public department website (Active)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addNlModal')">Cancel</button>
                <button type="submit" class="btn-primary">Upload Newsletter</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: EDIT NEWSLETTER                                         -->
<!-- ============================================================== -->
<?php if ($editItem): ?>
<div class="admin-modal show" id="editNlModal">
    <div class="modal-dialog" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title">Edit Newsletter: <?= htmlspecialchars($editItem['title']) ?></h3>
            <a href="dept-newsletters.php?dept=<?= $deptCode ?>" class="btn-close-modal">&times;</a>
        </div>
        <form action="dept-newsletters.php?dept=<?= $deptCode ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <input type="hidden" name="existing_pdf" value="<?= htmlspecialchars($editItem['pdf_file']) ?>">
            <input type="hidden" name="existing_size" value="<?= htmlspecialchars($editItem['file_size'] ?? '') ?>">

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_title">Newsletter Name / Title <span class="required">*</span></label>
                    <input type="text" name="title" id="edit_title" class="form-control" value="<?= htmlspecialchars($editItem['title']) ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="edit_vol">Volume / Issue (Optional)</label>
                        <input type="text" name="volume_issue" id="edit_vol" class="form-control" value="<?= htmlspecialchars($editItem['volume_issue'] ?? '') ?>">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="edit_period">Period / Year (Optional)</label>
                        <input type="text" name="issue_period" id="edit_period" class="form-control" value="<?= htmlspecialchars($editItem['issue_period'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_order">Display Order</label>
                    <input type="number" name="display_order" id="edit_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order']) ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Replace PDF File (Optional)</label>
                    <div style="margin-bottom: 8px; font-size: 13px; color: #475569;">
                        Current File: <a href="../<?= htmlspecialchars($editItem['pdf_file']) ?>" target="_blank" style="color: #0284c7;"><i class="fas fa-file-pdf"></i> View Current PDF (<?= htmlspecialchars($editItem['file_size'] ?: 'PDF') ?>)</a>
                    </div>
                    <input type="file" name="pdf_file" class="form-control" accept="application/pdf,.pdf">
                    <small style="color: #64748b; font-size: 11px;">Leave empty to keep the existing PDF file.</small>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                        <span>Display on public department website (Active)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="dept-newsletters.php?dept=<?= $deptCode ?>" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
