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
        $circular_no = trim($_POST['circular_no'] ?? '');
        $effective_date = !empty($_POST['effective_date']) ? $_POST['effective_date'] : null;
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($academic_year)) {
            setFlashMessage('danger', 'Please enter or select an Academic Year (e.g., 2026-27).');
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

        $stmt = $pdo->prepare("INSERT INTO academic_calendars (academic_year, semester_type, title, file_path, file_size, circular_no, effective_date, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$academic_year, $semester_type, $title, $relativePath, $fileSizeStr, $circular_no, $effective_date, $display_order, $is_active]);

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
        $circular_no = trim($_POST['circular_no'] ?? '');
        $effective_date = !empty($_POST['effective_date']) ? $_POST['effective_date'] : null;
        $display_order = (int)($_POST['display_order'] ?? 0);
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

        $stmt = $pdo->prepare("UPDATE academic_calendars SET academic_year = ?, semester_type = ?, title = ?, file_path = ?, file_size = ?, circular_no = ?, effective_date = ?, display_order = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$academic_year, $semester_type, $title, $relativePath, $fileSizeStr, $circular_no, $effective_date, $display_order, $is_active, $id]);

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
            setFlashMessage('success', 'Status toggled successfully.');
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

// Fetch all calendars
$calendars = [];
$totalOdd = 0;
$totalEven = 0;
$totalActive = 0;

if ($pdo) {
    try {
        $calendars = $pdo->query("SELECT * FROM academic_calendars ORDER BY display_order ASC, academic_year DESC, semester_type ASC")->fetchAll();
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

<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                <i class="fas fa-calendar-alt text-primary mr-2"></i>Manage Academic Calendar
            </h1>
            <p class="text-muted small mb-0">Upload, organize, and publish odd &amp; even term academic schedules, circular PDFs, and academic years.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="../academics/academic-calendar" target="_blank" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-external-link-alt mr-1"></i> View Live Page
            </a>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#calendarFormCollapse" aria-expanded="<?= $editItem ? 'true' : 'false' ?>">
                <i class="fas fa-plus-circle mr-1"></i> <?= $editItem ? 'Edit Calendar' : 'Add New Calendar' ?>
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Calendars</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($calendars) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Odd Semesters</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalOdd ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Even Semesters</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalEven ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Active / Published</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalActive ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Collapsible Add/Edit Form Panel -->
    <div class="collapse <?= $editItem ? 'show' : '' ?> mb-4" id="calendarFormCollapse">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-<?= $editItem ? 'edit' : 'plus-circle' ?> mr-2"></i>
                    <?= $editItem ? 'Edit Academic Calendar Record' : 'Upload New Academic Calendar' ?>
                </h6>
                <?php if ($editItem): ?>
                    <a href="academic-calendar.php" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times mr-1"></i> Cancel Edit
                    </a>
                <?php endif; ?>
            </div>
            <div class="card-body p-4">
                <form action="academic-calendar.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
                    <?php if ($editItem): ?>
                        <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
                    <?php endif; ?>

                    <div class="row">
                        <!-- Academic Year -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label font-weight-bold text-dark">
                                Academic Year <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="academic_year" class="form-control" placeholder="e.g. 2026-27 or 2025-26" 
                                   value="<?= htmlspecialchars($editItem['academic_year'] ?? '') ?>" required>
                            <small class="form-text text-muted">Format: YYYY-YY (e.g. 2026-27, 2025-26)</small>
                        </div>

                        <!-- Semester Type -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label font-weight-bold text-dark">
                                Term / Semester Type <span class="text-danger">*</span>
                            </label>
                            <select name="semester_type" class="form-control" required>
                                <option value="Odd" <?= ($editItem && $editItem['semester_type'] === 'Odd') ? 'selected' : '' ?>>Odd Semester (Sem 1, 3, 5, 7)</option>
                                <option value="Even" <?= ($editItem && $editItem['semester_type'] === 'Even') ? 'selected' : '' ?>>Even Semester (Sem 2, 4, 6, 8)</option>
                                <option value="Full Year" <?= ($editItem && $editItem['semester_type'] === 'Full Year') ? 'selected' : '' ?>>Full Year / Combined</option>
                            </select>
                        </div>

                        <!-- Display Order -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label font-weight-bold text-dark">Display Order</label>
                            <input type="number" name="display_order" class="form-control" value="<?= (int)($editItem['display_order'] ?? 0) ?>">
                            <small class="form-text text-muted">Lower numbers appear first (e.g. 1 for newest)</small>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Title -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold text-dark">Document Title / Caption</label>
                            <input type="text" name="title" class="form-control" placeholder="Optional. Default: Academic Calendar 2026-27 (Odd)"
                                   value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                            <small class="form-text text-muted">Leaves blank to auto-generate from year &amp; semester.</small>
                        </div>

                        <!-- Circular / Notification Number -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold text-dark">GTU Circular / Notification Ref.</label>
                            <input type="text" name="circular_no" class="form-control" placeholder="e.g. GTU/Acad/2026/894"
                                   value="<?= htmlspecialchars($editItem['circular_no'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="row">
                        <!-- PDF File Upload -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label font-weight-bold text-dark">
                                PDF Document <?= $editItem ? '(Leave blank to keep existing)' : '<span class="text-danger">*</span>' ?>
                            </label>
                            <div class="custom-file">
                                <input type="file" name="pdf_file" class="custom-file-input" id="calendarPdfFile" accept=".pdf" <?= $editItem ? '' : 'required' ?>>
                                <label class="custom-file-label" for="calendarPdfFile">Choose PDF document...</label>
                            </div>
                            <?php if ($editItem && !empty($editItem['file_path'])): ?>
                                <div class="mt-2 text-muted small">
                                    <i class="fas fa-file-pdf text-danger mr-1"></i> Current file: 
                                    <a href="../<?= htmlspecialchars(ltrim($editItem['file_path'], '/')) ?>" target="_blank" class="font-weight-bold">
                                        <?= basename($editItem['file_path']) ?>
                                    </a> (<?= htmlspecialchars($editItem['file_size'] ?? 'PDF') ?>)
                                </div>
                            <?php endif; ?>
                            <small class="form-text text-muted">Max file size: 25 MB. Only PDF format supported.</small>
                        </div>

                        <!-- Effective / Issue Date -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label font-weight-bold text-dark">Effective Date</label>
                            <input type="date" name="effective_date" class="form-control" value="<?= htmlspecialchars($editItem['effective_date'] ?? '') ?>">
                        </div>

                        <!-- Active Checkbox -->
                        <div class="col-md-3 mb-3 d-flex align-items-center">
                            <div class="custom-control custom-switch mt-3">
                                <input type="checkbox" class="custom-control-input" id="is_active_toggle" name="is_active" value="1" 
                                       <?= (!$editItem || !empty($editItem['is_active'])) ? 'checked' : '' ?>>
                                <label class="custom-control-label font-weight-bold" for="is_active_toggle">
                                    Publish on Website
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="text-right pt-2 border-top">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save mr-1"></i> <?= $editItem ? 'Save Changes' : 'Upload &amp; Publish Calendar' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Calendar Records Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list-alt mr-2"></i>Published Academic Calendar Records
            </h6>
            <div class="form-inline">
                <input type="text" id="calendarSearchInput" class="form-control form-control-sm mr-2" placeholder="Search by year or title...">
                <select id="calendarFilterSem" class="form-control form-control-sm">
                    <option value="">All Semesters</option>
                    <option value="Odd">Odd Semester</option>
                    <option value="Even">Even Semester</option>
                </select>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="calendarDataTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-3 py-3" style="width: 130px;">Academic Year</th>
                            <th class="border-0 px-3 py-3" style="width: 110px;">Semester</th>
                            <th class="border-0 px-3 py-3">Document Title &amp; Details</th>
                            <th class="border-0 px-3 py-3" style="width: 140px;">PDF Attachment</th>
                            <th class="border-0 px-3 py-3 text-center" style="width: 100px;">Status</th>
                            <th class="border-0 px-3 py-3 text-right" style="width: 140px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($calendars)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3 d-block"></i>
                                    No academic calendar records found. Click <strong>Add New Calendar</strong> above to publish.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($calendars as $row): 
                                $isOdd = ($row['semester_type'] === 'Odd');
                                $badgeClass = $isOdd ? 'badge-primary' : 'badge-info';
                                $hasFile = !empty($row['file_path']);
                            ?>
                                <tr class="calendar-row" data-year="<?= htmlspecialchars(strtolower($row['academic_year'])) ?>" data-sem="<?= htmlspecialchars($row['semester_type']) ?>" data-title="<?= htmlspecialchars(strtolower($row['title'])) ?>">
                                    <td class="px-3 py-3">
                                        <span class="font-weight-bold text-dark text-nowrap" style="font-size: 0.95rem;">
                                            <?= htmlspecialchars($row['academic_year']) ?>
                                        </span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <span class="badge <?= $badgeClass ?> px-2 py-1 font-weight-normal text-nowrap">
                                            <?= htmlspecialchars($row['semester_type']) ?>
                                        </span>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="font-weight-bold text-dark"><?= htmlspecialchars($row['title']) ?></div>
                                        <?php if (!empty($row['circular_no'])): ?>
                                            <div class="text-muted small">
                                                <i class="fas fa-tag mr-1 text-gray-400"></i> Circular: <?= htmlspecialchars($row['circular_no']) ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($row['effective_date'])): ?>
                                            <div class="text-muted small">
                                                <i class="fas fa-calendar-day mr-1 text-gray-400"></i> Date: <?= date('d M Y', strtotime($row['effective_date'])) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-3 py-3">
                                        <?php if ($hasFile): ?>
                                            <a href="../<?= htmlspecialchars(ltrim($row['file_path'], '/')) ?>" target="_blank" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center text-nowrap">
                                                <i class="fas fa-file-pdf mr-1"></i> View PDF
                                                <?php if (!empty($row['file_size'])): ?>
                                                    <span class="badge badge-light border text-dark ml-1"><?= htmlspecialchars($row['file_size']) ?></span>
                                                <?php endif; ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">No File Attached</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-3 py-3 text-center">
                                        <form action="academic-calendar.php" method="POST" class="d-inline">
                                            <input type="hidden" name="action" value="toggle_status">
                                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                            <button type="submit" class="btn btn-sm <?= $row['is_active'] ? 'btn-success' : 'btn-secondary' ?> px-2 py-1" style="font-size: 0.78rem;" title="Click to toggle status">
                                                <i class="fas fa-<?= $row['is_active'] ? 'check' : 'eye-slash' ?> mr-1"></i>
                                                <?= $row['is_active'] ? 'Active' : 'Draft' ?>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-3 py-3 text-right">
                                        <div class="btn-group btn-group-sm">
                                            <a href="academic-calendar.php?edit=<?= (int)$row['id'] ?>" class="btn btn-outline-primary" title="Edit Calendar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="academic-calendar.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete the academic calendar for <?= htmlspecialchars($row['academic_year']) ?> (<?= htmlspecialchars($row['semester_type']) ?>)? This cannot be undone.');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                                <button type="submit" class="btn btn-outline-danger" title="Delete">
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
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Custom file input label update
    const fileInput = document.getElementById('calendarPdfFile');
    if (fileInput) {
        fileInput.addEventListener('change', function (e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Choose PDF document...';
            const label = e.target.nextElementSibling;
            if (label) label.textContent = fileName;
        });
    }

    // Client-side quick filter & search
    const searchInput = document.getElementById('calendarSearchInput');
    const filterSem = document.getElementById('calendarFilterSem');
    const rows = document.querySelectorAll('.calendar-row');

    function filterTable() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const sem = filterSem ? filterSem.value : '';

        rows.forEach(function (row) {
            const year = row.getAttribute('data-year') || '';
            const rowSem = row.getAttribute('data-sem') || '';
            const title = row.getAttribute('data-title') || '';

            const matchQuery = !query || year.includes(query) || title.includes(query);
            const matchSem = !sem || rowSem === sem;

            if (matchQuery && matchSem) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (filterSem) filterSem.addEventListener('change', filterTable);
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
