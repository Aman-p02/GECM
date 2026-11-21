<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage Academic Calendar";
$current_page = 'academic-calendar';

$editItem = null;

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: academic-calendar.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    // ==========================================
    // ACTION: ADD CALENDAR
    // ==========================================
    if ($action === 'add') {
        $academic_year = trim($_POST['academic_year'] ?? '');
        $semester_type = trim($_POST['semester_type'] ?? 'Odd');
        $title = trim($_POST['title'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($academic_year)) {
            setFlashMessage('danger', 'Please enter an Academic Year (e.g. 2026-27).');
            header('Location: academic-calendar.php');
            exit;
        }

        if (!in_array($semester_type, ['Odd', 'Even', 'Full Year'])) {
            $semester_type = 'Odd';
        }

        if (empty($title)) {
            $title = "Academic Calendar {$academic_year} ({$semester_type})";
        }

        $relativePath = null;
        $fileSizeStr = null;

        // Process PDF file if uploaded
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['pdf_file'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if ($ext !== 'pdf') {
                setFlashMessage('danger', 'Only PDF files (.pdf) are allowed.');
                header('Location: academic-calendar.php');
                exit;
            }

            if ($file['size'] > 25 * 1024 * 1024) {
                setFlashMessage('danger', 'PDF file size exceeds maximum limit of 25MB.');
                header('Location: academic-calendar.php');
                exit;
            }

            $rawBase = pathinfo($file['name'], PATHINFO_FILENAME);
            $cleanBase = preg_replace('/[^a-zA-Z0-9_\-\.\(\)\s]/', '_', $rawBase);
            $cleanBase = trim($cleanBase) ?: ('academic_cal_' . time());

            $targetDir = realpath(__DIR__ . '/../uploads/academic_calendar');
            if (!$targetDir) {
                $targetDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'academic_calendar';
            }
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $cleanFilename = $cleanBase . '.pdf';
            $targetFile = $targetDir . DIRECTORY_SEPARATOR . $cleanFilename;

            if (file_exists($targetFile)) {
                $cleanFilename = $cleanBase . '_' . time() . '.pdf';
                $targetFile = $targetDir . DIRECTORY_SEPARATOR . $cleanFilename;
            }

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                $bytes = $file['size'];
                $fileSizeStr = ($bytes >= 1048576) ? (number_format($bytes / 1048576, 1) . ' MB') : (number_format($bytes / 1024, 0) . ' KB');
                $relativePath = 'uploads/academic_calendar/' . $cleanFilename;
            } else {
                setFlashMessage('danger', 'Failed to upload PDF file to storage.');
                header('Location: academic-calendar.php');
                exit;
            }
        }

        $stmt = $pdo->prepare("INSERT INTO academic_calendars (academic_year, semester_type, title, file_path, file_size, circular_no, effective_date, display_order, is_active) VALUES (?, ?, ?, ?, ?, NULL, NULL, 0, ?)");
        $stmt->execute([$academic_year, $semester_type, $title, $relativePath, $fileSizeStr, $is_active]);

        setFlashMessage('success', "Academic Calendar for {$academic_year} ({$semester_type}) added successfully!");
        header('Location: academic-calendar.php');
        exit;
    }

    // ==========================================
    // ACTION: EDIT CALENDAR
    // ==========================================
    if ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $academic_year = trim($_POST['academic_year'] ?? '');
        $semester_type = trim($_POST['semester_type'] ?? 'Odd');
        $title = trim($_POST['title'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if ($id <= 0 || empty($academic_year)) {
            setFlashMessage('danger', 'Invalid calendar record data.');
            header('Location: academic-calendar.php');
            exit;
        }

        if (!in_array($semester_type, ['Odd', 'Even', 'Full Year'])) {
            $semester_type = 'Odd';
        }

        if (empty($title)) {
            $title = "Academic Calendar {$academic_year} ({$semester_type})";
        }

        // Fetch existing record
        $stmt = $pdo->prepare("SELECT * FROM academic_calendars WHERE id = ?");
        $stmt->execute([$id]);
        $existing = $stmt->fetch();

        if (!$existing) {
            setFlashMessage('danger', 'Record not found.');
            header('Location: academic-calendar.php');
            exit;
        }

        $relativePath = $existing['file_path'];
        $fileSizeStr = $existing['file_size'];

        // If new PDF uploaded
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['pdf_file'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if ($ext !== 'pdf') {
                setFlashMessage('danger', 'Only PDF files (.pdf) are allowed.');
                header('Location: academic-calendar.php');
                exit;
            }

            if ($file['size'] > 25 * 1024 * 1024) {
                setFlashMessage('danger', 'PDF file size exceeds maximum limit of 25MB.');
                header('Location: academic-calendar.php');
                exit;
            }

            $rawBase = pathinfo($file['name'], PATHINFO_FILENAME);
            $cleanBase = preg_replace('/[^a-zA-Z0-9_\-\.\(\)\s]/', '_', $rawBase);
            $cleanBase = trim($cleanBase) ?: ('academic_cal_' . time());

            $targetDir = realpath(__DIR__ . '/../uploads/academic_calendar');
            if (!$targetDir) {
                $targetDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'academic_calendar';
            }
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $cleanFilename = $cleanBase . '_' . time() . '.pdf';
            $targetFile = $targetDir . DIRECTORY_SEPARATOR . $cleanFilename;

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                // Delete previous file if exists
                if (!empty($existing['file_path'])) {
                    $oldPath = __DIR__ . '/../' . ltrim($existing['file_path'], '/');
                    if (file_exists($oldPath) && is_file($oldPath)) {
                        @unlink($oldPath);
                    }
                }

                $bytes = $file['size'];
                $fileSizeStr = ($bytes >= 1048576) ? (number_format($bytes / 1048576, 1) . ' MB') : (number_format($bytes / 1024, 0) . ' KB');
                $relativePath = 'uploads/academic_calendar/' . $cleanFilename;
            }
        }

        $stmt = $pdo->prepare("UPDATE academic_calendars SET academic_year = ?, semester_type = ?, title = ?, file_path = ?, file_size = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$academic_year, $semester_type, $title, $relativePath, $fileSizeStr, $is_active, $id]);

        setFlashMessage('success', "Academic Calendar for {$academic_year} updated successfully!");
        header('Location: academic-calendar.php');
        exit;
    }

    // ==========================================
    // ACTION: TOGGLE STATUS
    // ==========================================
    if ($action === 'toggle_status') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE academic_calendars SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('success', 'Status updated successfully.');
        }
        header('Location: academic-calendar.php');
        exit;
    }

    // ==========================================
    // ACTION: DELETE CALENDAR
    // ==========================================
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("SELECT file_path FROM academic_calendars WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            if ($row && !empty($row['file_path'])) {
                $filePath = __DIR__ . '/../' . ltrim($row['file_path'], '/');
                if (file_exists($filePath) && is_file($filePath)) {
                    @unlink($filePath);
                }
            }
            $stmtDel = $pdo->prepare("DELETE FROM academic_calendars WHERE id = ?");
            $stmtDel->execute([$id]);
            setFlashMessage('success', 'Academic calendar record deleted successfully.');
        }
        header('Location: academic-calendar.php');
        exit;
    }
}

// Check for Edit Request via GET
if (isset($_GET['edit']) && (int)$_GET['edit'] > 0 && $pdo) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM academic_calendars WHERE id = ?");
    $stmt->execute([$editId]);
    $editItem = $stmt->fetch();
}

// Fetch all calendars: sorted by academic_year DESC so latest added year stays at top automatically!
$calendars = [];
$totalOdd = 0;
$totalEven = 0;
$totalActive = 0;

if ($pdo) {
    try {
        $calendars = $pdo->query("SELECT * FROM academic_calendars ORDER BY academic_year DESC, semester_type ASC, id DESC")->fetchAll();
        foreach ($calendars as $cal) {
            if ($cal['semester_type'] === 'Odd') $totalOdd++;
            if ($cal['semester_type'] === 'Even') $totalEven++;
            if ($cal['is_active']) $totalActive++;
        }
    } catch (Exception $e) {
        $calendars = [];
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px;">
            <i class="fas fa-calendar-alt" style="color: var(--admin-primary); margin-right: 8px;"></i>Manage Academic Calendar
        </h1>
        <p style="color: #64748b; margin: 0; font-size: 13.5px;">Upload and manage odd &amp; even term academic schedules. Latest academic years appear at the top automatically.</p>
    </div>
    <div>
        <a href="../academics/academic-calendar" target="_blank" class="btn" style="background: #fff; border: 1px solid #ced4da; color: #374151; font-size: 13px;">
            <i class="fas fa-external-link-alt" style="margin-right: 6px;"></i> View Live Page
        </a>
    </div>
</div>

<?php renderFlashMessage(); ?>

<!-- Quick Stats Grid (Clean GECM Admin Style) -->
<div class="stats-grid" style="margin-bottom: 24px;">
    <div class="stat-card">
        <div class="stat-info">
            <div class="stat-number"><?= count($calendars) ?></div>
            <div class="stat-label">Total Calendars</div>
        </div>
        <div class="stat-icon icon-blue">
            <i class="fas fa-calendar-check"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <div class="stat-number"><?= $totalOdd ?></div>
            <div class="stat-label">Odd Semesters</div>
        </div>
        <div class="stat-icon icon-amber">
            <i class="fas fa-file-pdf"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <div class="stat-number"><?= $totalEven ?></div>
            <div class="stat-label">Even Semesters</div>
        </div>
        <div class="stat-icon icon-purple">
            <i class="fas fa-file-alt"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <div class="stat-number"><?= $totalActive ?></div>
            <div class="stat-label">Active / Published</div>
        </div>
        <div class="stat-icon icon-green">
            <i class="fas fa-check-circle"></i>
        </div>
    </div>
</div>

<!-- Upload / Edit Academic Calendar Card -->
<div class="admin-card" style="margin-bottom: 28px; border: 1px solid #e2e8f0; border-radius: 10px; background: #ffffff; padding: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
        <h2 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas <?= $editItem ? 'fa-edit' : 'fa-cloud-upload-alt' ?>" style="color: var(--admin-primary);"></i>
            <?= $editItem ? 'Edit Academic Calendar Record' : 'Upload New Academic Calendar' ?>
        </h2>
        <?php if ($editItem): ?>
            <a href="academic-calendar.php" class="btn btn-secondary" style="font-size: 12px; padding: 5px 12px;">
                <i class="fas fa-times"></i> Cancel Edit
            </a>
        <?php endif; ?>
    </div>

    <form method="POST" action="academic-calendar.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
        <?php if ($editItem): ?>
            <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
        <?php endif; ?>

        <!-- Row 1: Academic Year & Semester Type -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 16px;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">
                    Academic Year <span class="required">*</span>
                </label>
                <input type="text" name="academic_year" class="form-control" required placeholder="e.g. 2026-27 or 2025-26" 
                       value="<?= htmlspecialchars($editItem['academic_year'] ?? '') ?>">
                <small style="color: #64748b; font-size: 12px; margin-top: 4px; display: block;">Format: YYYY-YY (e.g. 2026-27, 2025-26)</small>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">
                    Term / Semester Type <span class="required">*</span>
                </label>
                <select name="semester_type" class="form-control" required>
                    <option value="Odd" <?= ($editItem && $editItem['semester_type'] === 'Odd') ? 'selected' : '' ?>>Odd Semester (Sem 1, 3, 5, 7)</option>
                    <option value="Even" <?= ($editItem && $editItem['semester_type'] === 'Even') ? 'selected' : '' ?>>Even Semester (Sem 2, 4, 6, 8)</option>
                    <option value="Full Year" <?= ($editItem && $editItem['semester_type'] === 'Full Year') ? 'selected' : '' ?>>Full Year / Combined</option>
                </select>
            </div>
        </div>

        <!-- Row 2: Document Title & PDF Upload -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">Document Title / Caption</label>
                <input type="text" name="title" class="form-control" placeholder="Optional. Default: Academic Calendar [Year] ([Term])"
                       value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                <small style="color: #64748b; font-size: 12px; margin-top: 4px; display: block;">Leave blank to auto-generate title from year &amp; semester.</small>
            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">
                    Upload PDF Document <?= $editItem ? '(Leave empty to keep existing)' : '<span class="required">*</span>' ?>
                </label>
                <input type="file" name="pdf_file" class="form-control" accept=".pdf" <?= $editItem ? '' : 'required' ?>>
                <?php if ($editItem && !empty($editItem['file_path'])): ?>
                    <small style="color: #64748b; font-size: 12px; margin-top: 4px; display: block;">
                        Current file: <a href="../<?= htmlspecialchars(ltrim($editItem['file_path'], '/')) ?>" target="_blank" style="color: var(--admin-primary); font-weight: 600;">
                            <i class="fas fa-file-pdf text-danger"></i> <?= basename($editItem['file_path']) ?> (<?= htmlspecialchars($editItem['file_size'] ?? 'PDF') ?>)
                        </a>
                    </small>
                <?php else: ?>
                    <small style="color: #64748b; font-size: 12px; margin-top: 4px; display: block;">Max file size: 25 MB. Only PDF format supported.</small>
                <?php endif; ?>
            </div>
        </div>

        <!-- Row 3: Status & Submit -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 16px; flex-wrap: wrap; gap: 12px;">
            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13.5px; font-weight: 600; color: #334155;">
                <input type="checkbox" name="is_active" value="1" <?= (!$editItem || !empty($editItem['is_active'])) ? 'checked' : '' ?> style="width: 17px; height: 17px;">
                <span>Active &amp; Published on Website</span>
            </label>

            <button type="submit" class="btn btn-primary" style="padding: 9px 24px;">
                <i class="fas fa-save mr-1"></i> <?= $editItem ? 'Save Changes' : 'Upload &amp; Publish Calendar' ?>
            </button>
        </div>
    </form>
</div>

<!-- Published Records Table Card -->
<div class="admin-card" style="border: 1px solid #e2e8f0; border-radius: 10px; background: #ffffff; padding: 22px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
        <h2 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-list-alt" style="color: var(--admin-primary);"></i>
            Published Academic Calendar Records
            <span class="badge badge-light" style="font-size: 12px; font-weight: 600;"><?= count($calendars) ?></span>
        </h2>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 140px; white-space: nowrap;">Academic Year</th>
                    <th style="width: 120px; white-space: nowrap;">Semester</th>
                    <th>Document Title</th>
                    <th style="width: 170px; white-space: nowrap;">PDF Attachment</th>
                    <th style="width: 110px; text-align: center; white-space: nowrap;">Status</th>
                    <th style="width: 110px; text-align: center; white-space: nowrap;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($calendars)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 36px; color: #888;">
                            <i class="fas fa-calendar-times fa-2x" style="color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                            No academic calendar records found. Use the form above to upload a calendar PDF.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($calendars as $row): 
                        $isOdd = ($row['semester_type'] === 'Odd');
                        $badgeStyle = $isOdd 
                            ? 'background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa;' 
                            : 'background: #ecfeff; color: #0e7490; border: 1px solid #a5f3fc;';
                        $hasFile = !empty($row['file_path']);
                    ?>
                        <tr>
                            <!-- Academic Year -->
                            <td style="white-space: nowrap; font-weight: 700; font-size: 14px; color: #0f172a;">
                                <?= htmlspecialchars($row['academic_year']) ?>
                            </td>

                            <!-- Semester Badge -->
                            <td style="white-space: nowrap;">
                                <span style="display: inline-block; padding: 3px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; <?= $badgeStyle ?>">
                                    <?= htmlspecialchars($row['semester_type']) ?>
                                </span>
                            </td>

                            <!-- Document Title -->
                            <td>
                                <div style="font-weight: 600; color: #1e293b; font-size: 13.5px;">
                                    <?= htmlspecialchars($row['title']) ?>
                                </div>
                            </td>

                            <!-- PDF Attachment Button (Ensured text never wraps awkwardly) -->
                            <td style="white-space: nowrap;">
                                <?php if ($hasFile): ?>
                                    <a href="../<?= htmlspecialchars(ltrim($row['file_path'], '/')) ?>" target="_blank" 
                                       style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: #fff; border: 1px solid #fca5a5; color: #dc2626; border-radius: 5px; font-size: 12.5px; font-weight: 600; text-decoration: none; white-space: nowrap;">
                                        <i class="fas fa-file-pdf"></i>
                                        <span>View PDF</span>
                                        <?php if (!empty($row['file_size'])): ?>
                                            <span style="font-size: 11px; background: #fee2e2; color: #991b1b; padding: 1px 5px; border-radius: 3px; font-weight: 500;">
                                                <?= htmlspecialchars($row['file_size']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                <?php else: ?>
                                    <span style="color: #94a3b8; font-size: 12.5px; font-style: italic;">No PDF attached</span>
                                <?php endif; ?>
                            </td>

                            <!-- Status Toggle Button -->
                            <td style="text-align: center; white-space: nowrap;">
                                <form action="academic-calendar.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                    <button type="submit" style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; white-space: nowrap; <?= $row['is_active'] ? 'background: #dcfce7; color: #15803d;' : 'background: #f1f5f9; color: #64748b;' ?>" title="Click to toggle status">
                                        <i class="fas fa-<?= $row['is_active'] ? 'check-circle' : 'eye-slash' ?>"></i>
                                        <span><?= $row['is_active'] ? 'Active' : 'Draft' ?></span>
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td style="text-align: center; white-space: nowrap;">
                                <div class="table-actions" style="justify-content: center; gap: 6px;">
                                    <a href="academic-calendar.php?edit=<?= (int)$row['id'] ?>" class="btn-table-action btn-edit" title="Edit Calendar" style="padding: 5px 9px; font-size: 12px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="academic-calendar.php" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete the calendar for <?= htmlspecialchars($row['academic_year']) ?> (<?= htmlspecialchars($row['semester_type']) ?>)?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                        <button type="submit" class="btn-table-action btn-delete" title="Delete Calendar" style="padding: 5px 9px; font-size: 12px; border: none; cursor: pointer;">
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

<?php require_once __DIR__ . '/includes/footer.php'; ?>
