<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

// Department resolution
$deptCode = strtoupper(trim($_GET['dept'] ?? 'CE'));
$validDepts = [
    'CE' => 'Computer Engineering',
    'IT' => 'Information Technology',
    'ME' => 'Mechanical Engineering',
    'CIVIL' => 'Civil Engineering',
    'EE' => 'Electrical Engineering',
    'EC' => 'Electronics & Communication',
    'AE' => 'Automobile Engineering',
    'AM' => 'Applied Mechanics',
    'SH' => 'Science & Humanities'
];

if (!isset($validDepts[$deptCode])) {
    $deptCode = 'CE';
}
$deptName = $validDepts[$deptCode];

$deptFolderMap = [
    'CE' => 'computer',
    'IT' => 'information-technology',
    'ME' => 'mechanical',
    'CIVIL' => 'civil',
    'AE' => 'automobile',
    'AM' => 'applied-mechanics',
];
$liveDeptFolder = $deptFolderMap[$deptCode] ?? 'computer';
$livePageUrl = "../departments/{$liveDeptFolder}/index.php#advisory-board";

// Guard against DB connection failure on write requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: dept-board.php?dept=' . $deptCode);
        exit;
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $academic_year = trim($_POST['academic_year'] ?? '');
        $display_order = (int) ($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title)) {
            setFlashMessage('danger', 'Document / Meeting Title cannot be empty.');
            header('Location: dept-board.php?dept=' . $deptCode);
            exit;
        }

        // Handle PDF Upload
        if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
            setFlashMessage('danger', 'Please upload a PDF file.');
            header('Location: dept-board.php?dept=' . $deptCode);
            exit;
        }

        $uploadResult = handlePdfUpload('pdf_file', 'advisory_board');
        if (!$uploadResult['success']) {
            setFlashMessage('danger', 'PDF upload error: ' . $uploadResult['error']);
            header('Location: dept-board.php?dept=' . $deptCode);
            exit;
        }

        $pdf_path = $uploadResult['path'];
        $file_size = $uploadResult['file_size'];

        try {
            $stmt = $pdo->prepare("
                INSERT INTO department_advisory_board 
                (dept_code, title, academic_year, pdf_file, file_size, display_order, is_active)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $deptCode,
                $title,
                $academic_year,
                $pdf_path,
                $file_size,
                $display_order,
                $is_active
            ]);
            setFlashMessage('success', "Advisory Board PDF '$title' uploaded successfully!");
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }

        header('Location: dept-board.php?dept=' . $deptCode);
        exit;
    } elseif ($action === 'edit') {
        $id = (int) ($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $academic_year = trim($_POST['academic_year'] ?? '');
        $display_order = (int) ($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_pdf = trim($_POST['existing_pdf'] ?? '');
        $existing_size = trim($_POST['existing_size'] ?? '');

        if ($id <= 0 || empty($title)) {
            setFlashMessage('danger', 'Invalid document ID or title.');
            header('Location: dept-board.php?dept=' . $deptCode);
            exit;
        }

        $pdf_path = $existing_pdf;
        $file_size = $existing_size;

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = handlePdfUpload('pdf_file', 'advisory_board');
            if ($uploadResult['success']) {
                $pdf_path = $uploadResult['path'];
                $file_size = $uploadResult['file_size'];
            } else {
                setFlashMessage('danger', 'PDF upload error: ' . $uploadResult['error']);
                header('Location: dept-board.php?dept=' . $deptCode);
                exit;
            }
        }

        try {
            $stmt = $pdo->prepare("
                UPDATE department_advisory_board 
                SET title = ?, academic_year = ?, pdf_file = ?, file_size = ?, display_order = ?, is_active = ?
                WHERE id = ? AND dept_code = ?
            ");
            $stmt->execute([
                $title,
                $academic_year,
                $pdf_path,
                $file_size,
                $display_order,
                $is_active,
                $id,
                $deptCode
            ]);
            setFlashMessage('success', 'Advisory Board document updated successfully!');
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }

        header('Location: dept-board.php?dept=' . $deptCode);
        exit;
    }
}

// Handle GET Actions (Delete, Toggle, Edit)
if (isset($_GET['delete'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: dept-board.php?dept=' . $deptCode);
        exit;
    }
    $id = (int) $_GET['delete'];
    if ($id > 0) {
        try {
            // Optional: delete physical file if needed
            $stmt = $pdo->prepare("SELECT pdf_file FROM department_advisory_board WHERE id = ? AND dept_code = ?");
            $stmt->execute([$id, $deptCode]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row && !empty($row['pdf_file']) && file_exists(__DIR__ . '/../' . $row['pdf_file'])) {
                @unlink(__DIR__ . '/../' . $row['pdf_file']);
            }

            $stmt = $pdo->prepare("DELETE FROM department_advisory_board WHERE id = ? AND dept_code = ?");
            $stmt->execute([$id, $deptCode]);
            setFlashMessage('success', 'Document deleted successfully.');
        } catch (Exception $e) {
            setFlashMessage('danger', 'Delete error: ' . $e->getMessage());
        }
    }
    header('Location: dept-board.php?dept=' . $deptCode);
    exit;
}

if (isset($_GET['toggle'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: dept-board.php?dept=' . $deptCode);
        exit;
    }
    $id = (int) $_GET['toggle'];
    if ($id > 0) {
        try {
            $stmt = $pdo->prepare("UPDATE department_advisory_board SET is_active = IF(is_active = 1, 0, 1) WHERE id = ? AND dept_code = ?");
            $stmt->execute([$id, $deptCode]);
            setFlashMessage('info', 'Document status updated.');
        } catch (Exception $e) {
            setFlashMessage('danger', 'Status update error: ' . $e->getMessage());
        }
    }
    header('Location: dept-board.php?dept=' . $deptCode);
    exit;
}

if (isset($_GET['edit']) && $pdo) {
    $id = (int) $_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM department_advisory_board WHERE id = ? AND dept_code = ?");
        $stmt->execute([$id, $deptCode]);
        $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Fetch all advisory board documents for this department
$boardList = [];
if ($pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT * FROM department_advisory_board 
            WHERE dept_code = ? 
            ORDER BY display_order ASC, id DESC
        ");
        $stmt->execute([$deptCode]);
        $boardList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Dept Advisory Board Fetch Error: " . $e->getMessage());
    }
}

$current_page = 'dept-board';
$page_title = "Advisory Board - " . $deptName;
require_once __DIR__ . '/includes/header.php';
?>

<!-- Department Modules Navigation Bar -->
<div
    style="background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 12px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <span style="font-size: 15px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-layer-group" style="color: #2563eb;"></i> <?= htmlspecialchars($deptName) ?>
            (<?= htmlspecialchars($deptCode) ?>)
        </span>
    </div>

    <!-- Sub-modules of this Department -->
    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
        <a href="dept-faculty.php?dept=<?= $deptCode ?>" class="btn-sm"
            style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-users" style="margin-right: 6px;"></i> Faculty Members
        </a>
        <a href="dept-activities.php?dept=<?= $deptCode ?>" class="btn-sm"
            style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-calendar-check" style="margin-right: 6px;"></i> Activities
        </a>
        <a href="dept-publications.php?dept=<?= $deptCode ?>" class="btn-sm"
            style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-book" style="margin-right: 6px;"></i> Publications
        </a>
        <a href="dept-board.php?dept=<?= $deptCode ?>" class="btn-sm"
            style="background: #1e90ff; color: #ffffff; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-user-tie" style="margin-right: 6px;"></i> Advisory Board
        </a>
        <a href="dept-newsletters.php?dept=<?= urlencode($deptCode) ?>" class="btn-sm"
            style="background: #f1f5f9; color: #334155; padding: 7px 14px; border-radius: 6px; font-weight: 500; text-decoration: none; font-size: 13px;">
            <i class="fas fa-newspaper" style="margin-right: 6px;"></i> Newsletters
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <h2 class="card-title"><?= htmlspecialchars($deptName) ?> - Advisory Board Documents</h2>
            <p style="color: #64748b; font-size: 13.5px; margin-top: 4px;">
                Upload and manage Advisory Board meeting minutes, circulars, agendas, and constitution PDF files.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="<?= htmlspecialchars($livePageUrl) ?>" target="_blank" class="btn-secondary"
                style="text-decoration: none; display: flex; align-items: center; gap: 6px; padding: 8px 16px;">
                <i class="fas fa-external-link-alt"></i> View Live Page
            </a>
            <button type="button" class="btn-add-new" onclick="openModal('addBoardModal')">
                + Upload PDF Document
            </button>
        </div>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="card-filters" style="margin-left: auto;">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search document title, year..."
                    data-table-search="boardTable">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="admin-table" id="boardTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th style="width: 80px; text-align: center;">File</th>
                    <th>Document Name / Title</th>
                    <th style="width: 150px;">Year / Session</th>
                    <th style="width: 100px;">Size</th>
                    <th style="width: 90px; text-align: center;">Status</th>
                    <th style="width: 120px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($boardList)): ?>
                    <tr class="no-records-row">
                        <td colspan="7" style="text-align: center; padding: 48px; color: #64748b;">
                            <i class="fas fa-file-pdf"
                                style="font-size: 32px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                            No Advisory Board documents uploaded yet for <?= htmlspecialchars($deptName) ?>. Click "+ Upload
                            PDF Document" above.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($boardList as $doc): ?>
                        <tr>
                            <td>
                                <span class="badge" style="background: #f1f5f9; color: #475569; font-weight: 700;">
                                    #<?= htmlspecialchars($doc['display_order']) ?>
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a href="../<?= htmlspecialchars($doc['pdf_file']) ?>" target="_blank"
                                    title="View PDF in new tab" style="color: #ef4444; font-size: 24px; text-decoration: none;">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            </td>
                            <td>
                                <div style="font-weight: 600; font-size: 14.5px; color: #0f172a;">
                                    <a href="../<?= htmlspecialchars($doc['pdf_file']) ?>" target="_blank"
                                        style="color: #0f172a; text-decoration: none;">
                                        <?= htmlspecialchars($doc['title']) ?>
                                    </a>
                                </div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                                    <a href="../<?= htmlspecialchars($doc['pdf_file']) ?>" target="_blank"
                                        style="color: #2563eb; text-decoration: none;">
                                        <i class="fas fa-external-link-alt" style="margin-right: 3px;"></i> Open in New Tab
                                    </a>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background: #e0f2fe; color: #0369a1; font-weight: 600;">
                                    <?= htmlspecialchars($doc['academic_year'] ?: 'General') ?>
                                </span>
                            </td>
                            <td>
                                <span style="font-size: 13px; color: #64748b;">
                                    <?= htmlspecialchars($doc['file_size'] ?: 'PDF') ?>
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a href="dept-board.php?dept=<?= $deptCode ?>&toggle=<?= $doc['id'] ?>"
                                    class="status-pill <?= $doc['is_active'] ? 'active' : 'inactive' ?>"
                                    title="Click to toggle visibility">
                                    <?= $doc['is_active'] ? 'Active' : 'Hidden' ?>
                                </a>
                            </td>
                            <td style="text-align: right;">
                                <div class="action-btn-group">
                                    <a href="dept-board.php?dept=<?= $deptCode ?>&edit=<?= $doc['id'] ?>"
                                        class="btn-action edit" title="Edit Document">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="dept-board.php?dept=<?= $deptCode ?>&delete=<?= $doc['id'] ?>"
                                        class="btn-action delete" title="Delete Document"
                                        onclick="return confirm('Delete this PDF document?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
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
<!-- MODAL: UPLOAD NEW PDF DOCUMENT                                 -->
<!-- ============================================================== -->
<div class="admin-modal" id="addBoardModal">
    <div class="modal-dialog" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title">Upload Advisory Board PDF (<?= htmlspecialchars($deptName) ?>)</h3>
            <button type="button" class="btn-close-modal" onclick="closeModal('addBoardModal')">&times;</button>
        </div>
        <form action="dept-board.php?dept=<?= $deptCode ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="add_title">Name of PDF / Document Title <span
                            class="required">*</span></label>
                    <input type="text" name="title" id="add_title" class="form-control"
                        placeholder="e.g. Industry Advisory Board Meeting Minutes 2025-26" required>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label" for="add_year">Academic Year / Session</label>
                        <input type="text" name="academic_year" id="add_year" class="form-control"
                            placeholder="e.g. 2025-26">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="add_order">Display Order</label>
                        <input type="number" name="display_order" id="add_order" class="form-control" value="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_pdf">Select PDF Document <span class="required">*</span></label>
                    <input type="file" name="pdf_file" id="add_pdf" class="form-control" accept="application/pdf,.pdf"
                        required>
                    <small style="color: #64748b; font-size: 11px;">Max allowed size: 25MB. Must be a valid .pdf
                        file.</small>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Display on public department website (Active)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addBoardModal')">Cancel</button>
                <button type="submit" class="btn-primary">Upload PDF</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: EDIT DOCUMENT                                           -->
<!-- ============================================================== -->
<?php if ($editItem): ?>
    <div class="admin-modal show" id="editBoardModal">
        <div class="modal-dialog" style="max-width: 600px;">
            <div class="modal-header">
                <h3 class="modal-title">Edit Document: <?= htmlspecialchars($editItem['title']) ?></h3>
                <a href="dept-board.php?dept=<?= $deptCode ?>" class="btn-close-modal">&times;</a>
            </div>
            <form action="dept-board.php?dept=<?= $deptCode ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
                <input type="hidden" name="existing_pdf" value="<?= htmlspecialchars($editItem['pdf_file']) ?>">
                <input type="hidden" name="existing_size" value="<?= htmlspecialchars($editItem['file_size'] ?? '') ?>">

                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="edit_title">Name of PDF / Document Title <span
                                class="required">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control"
                            value="<?= htmlspecialchars($editItem['title']) ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group" style="flex: 2;">
                            <label class="form-label" for="edit_year">Academic Year / Session</label>
                            <input type="text" name="academic_year" id="edit_year" class="form-control"
                                value="<?= htmlspecialchars($editItem['academic_year'] ?? '') ?>">
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label class="form-label" for="edit_order">Display Order</label>
                            <input type="number" name="display_order" id="edit_order" class="form-control"
                                value="<?= htmlspecialchars($editItem['display_order']) ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Replace PDF File (Optional)</label>
                        <div style="margin-bottom: 8px; font-size: 13px; color: #475569;">
                            Current File: <a href="../<?= htmlspecialchars($editItem['pdf_file']) ?>" target="_blank"
                                style="color: #2563eb;"><i class="fas fa-file-pdf"></i> View Current PDF
                                (<?= htmlspecialchars($editItem['file_size'] ?: 'PDF') ?>)</a>
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
                    <a href="dept-board.php?dept=<?= $deptCode ?>" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">Update Document</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>