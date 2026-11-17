<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage Institutional Rankings";
$current_page = 'rankings';

// Self-healing database table setup
if ($pdo) {
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `institute_rankings` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `title` VARCHAR(255) NOT NULL,
            `ranking_body` VARCHAR(100) DEFAULT 'NIRF',
            `academic_year` VARCHAR(50) NOT NULL,
            `file_path` VARCHAR(500) NOT NULL,
            `file_size` VARCHAR(50) DEFAULT NULL,
            `display_order` INT NOT NULL DEFAULT 0,
            `is_active` TINYINT(1) NOT NULL DEFAULT 1,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_rankings_year` (`academic_year`),
            INDEX `idx_rankings_order` (`display_order`, `id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    } catch (Exception $e) {
        error_log("Error in institute_rankings setup: " . $e->getMessage());
    }
}

$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: rankings.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $academic_year = trim($_POST['academic_year'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $ranking_body = 'NIRF';
        $display_order = 0;
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($academic_year)) {
            $academic_year = date('Y');
        }

        if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
            setFlashMessage('danger', 'Please select a valid PDF file to upload.');
            header('Location: rankings.php');
            exit;
        }

        // Auto-extract title from PDF filename if left empty
        if (empty($title)) {
            $rawBase = pathinfo($_FILES['pdf_file']['name'], PATHINFO_FILENAME);
            $title = trim(preg_replace('/[_\-]+/', ' ', $rawBase));
            if (empty($title)) {
                $title = "NIRF Ranking Report {$academic_year}";
            }
        }

        $upload = handlePdfUpload('pdf_file', 'rankings');
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: rankings.php');
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO institute_rankings (title, ranking_body, academic_year, file_path, file_size, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $ranking_body, $academic_year, $upload['path'], $upload['file_size'] ?? 'PDF', $display_order, $is_active]);

        setFlashMessage('success', "Ranking document for Year {$academic_year} uploaded successfully!");
        header('Location: rankings.php');
        exit;

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $academic_year = trim($_POST['academic_year'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $ranking_body = 'NIRF';
        $display_order = 0;
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_file = trim($_POST['existing_file'] ?? '');

        if ($id <= 0) {
            setFlashMessage('danger', 'Valid ID is required.');
            header('Location: rankings.php');
            exit;
        }

        if (empty($academic_year)) {
            $academic_year = date('Y');
        }

        $file_path = $existing_file;
        $file_size = null;

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            if (empty($title)) {
                $rawBase = pathinfo($_FILES['pdf_file']['name'], PATHINFO_FILENAME);
                $title = trim(preg_replace('/[_\-]+/', ' ', $rawBase));
            }

            $upload = handlePdfUpload('pdf_file', 'rankings', ($existing_file !== '#' ? $existing_file : null));
            if ($upload['success']) {
                $file_path = $upload['path'];
                $file_size = $upload['file_size'] ?? 'PDF';
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: rankings.php?edit=' . $id);
                exit;
            }
        }

        if (empty($title)) {
            $title = "NIRF Ranking Report {$academic_year}";
        }

        if ($file_size) {
            $stmt = $pdo->prepare("UPDATE institute_rankings SET title = ?, ranking_body = ?, academic_year = ?, file_path = ?, file_size = ?, display_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $ranking_body, $academic_year, $file_path, $file_size, $display_order, $is_active, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE institute_rankings SET title = ?, ranking_body = ?, academic_year = ?, file_path = ?, display_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $ranking_body, $academic_year, $file_path, $display_order, $is_active, $id]);
        }

        setFlashMessage('success', "Ranking document updated successfully!");
        header('Location: rankings.php');
        exit;

    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("SELECT file_path FROM institute_rankings WHERE id = ?");
            $stmt->execute([$id]);
            $item = $stmt->fetch();
            if ($item && !empty($item['file_path']) && $item['file_path'] !== '#') {
                $realFile = realpath(__DIR__ . '/../' . $item['file_path']);
                if ($realFile && file_exists($realFile)) {
                    @unlink($realFile);
                }
            }
            $pdo->prepare("DELETE FROM institute_rankings WHERE id = ?")->execute([$id]);
            setFlashMessage('success', 'Ranking document deleted.');
        }
        header('Location: rankings.php');
        exit;

    } elseif ($action === 'toggle_status') {
        $id = (int)($_POST['id'] ?? 0);
        $status = (int)($_POST['status'] ?? 0);
        $new_status = ($status === 1) ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE institute_rankings SET is_active = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
        setFlashMessage('success', 'Ranking document status updated.');
        header('Location: rankings.php');
        exit;
    }
}

// Fetch item for editing
if (isset($_GET['edit']) && (int)$_GET['edit'] > 0 && $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM institute_rankings WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editItem = $stmt->fetch();
}

// Fetch all ranking documents grouped / ordered by academic_year DESC
$rankings = [];
$distinctYears = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM institute_rankings ORDER BY academic_year DESC, display_order ASC, id DESC");
    $rankings = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];

    foreach ($rankings as $r) {
        $y = trim($r['academic_year'] ?? '');
        if ($y !== '' && !in_array($y, $distinctYears)) {
            $distinctYears[] = $y;
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 24px;">
    <!-- Top Action Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 14px; margin-bottom: 22px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">Year-wise Institutional Rankings &amp; Surveys (NIRF)</h2>
            <p style="font-size: 13.5px; color: #64748b; margin: 0;">Upload and organize NIRF, GSIRF, and statutory evaluation reports year-wise.</p>
        </div>
        <a href="../about/rankings" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px; font-size: 13px;">
            <i class="fas fa-external-link-alt"></i> View Public Page
        </a>
    </div>

    <!-- Upload / Edit Form -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas <?= $editItem ? 'fa-edit' : 'fa-plus-circle' ?>" style="color: #1e90ff;"></i>
            <?= $editItem ? 'Edit Ranking Document' : 'Upload Year-wise Ranking Report (PDF)' ?>
        </h3>

        <form action="rankings.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
                <input type="hidden" name="existing_file" value="<?= htmlspecialchars($editItem['file_path']) ?>">
            <?php endif; ?>

            <!-- Row 1: Year & Document Title -->
            <div style="display: grid; grid-template-columns: 1.2fr 2.8fr; gap: 16px; margin-bottom: 14px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-weight: 600;">Ranking Year <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="academic_year" id="academic_year" class="form-control" placeholder="e.g. 2025" required value="<?= htmlspecialchars($editItem['academic_year'] ?? '2025') ?>">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-weight: 600;">Document Title</label>
                    <input type="text" name="title" id="ranking_title" class="form-control" placeholder="e.g. All Report-MHRD, NIRF-ENGINEERING" value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                </div>
            </div>

            <!-- Row 2: File Upload, Status -->
            <div style="display: grid; grid-template-columns: 1fr auto; gap: 16px; margin-bottom: 20px; align-items: flex-start;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-weight: 600;">Ranking Report PDF <?= ($editItem && !empty($editItem['file_path']) && $editItem['file_path'] !== '#') ? '' : '<span style="color: #ef4444;">*</span>' ?></label>
                    <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept=".pdf" <?= ($editItem && !empty($editItem['file_path']) && $editItem['file_path'] !== '#') ? '' : 'required' ?> style="padding: 5px 8px; font-size: 13px;">
                    <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">
                        PDF format only. Maximum size: 25MB. Title auto-populates from PDF name if blank.
                    </div>
                    <?php if ($editItem && !empty($editItem['file_path'])): ?>
                        <div style="margin-top: 5px; font-size: 12px;">
                            <?php if ($editItem['file_path'] !== '#'): ?>
                                <a href="../<?= htmlspecialchars($editItem['file_path']) ?>" target="_blank" style="color: #1e90ff; font-weight: 600;">
                                    <i class="fas fa-file-pdf" style="color: #dc2626;"></i> Current PDF (<?= htmlspecialchars($editItem['file_size'] ?? 'PDF') ?>)
                                </a>
                            <?php else: ?>
                                <span style="color: #f59e0b; font-weight: 600;">
                                    <i class="far fa-clock"></i> File currently awaiting upload. Select a PDF file above to attach it.
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group" style="margin-bottom: 0; padding-top: 30px;">
                    <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13.5px; font-weight: 600; color: #334155; white-space: nowrap;">
                        <input type="checkbox" name="is_active" value="1" <?= (!$editItem || $editItem['is_active'] == 1) ? 'checked' : '' ?> style="width: 17px; height: 17px;">
                        <span>Active &amp; Visible</span>
                    </label>
                </div>
            </div>

            <!-- Submit Row -->
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 8px 22px; font-size: 13px;">
                    <i class="fas fa-save"></i> <?= $editItem ? 'Update Ranking Report' : 'Upload Ranking PDF' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="rankings.php" class="btn btn-secondary" style="padding: 8px 18px; font-size: 13px;">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table Header & Year Filter -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
        <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">
            Uploaded Ranking Documents (<?= count($rankings) ?>)
        </h3>
        <div style="display: flex; gap: 10px; align-items: center;">
            <select class="form-control" id="adminYearFilter" style="height: 36px; font-size: 13px; width: 140px;">
                <option value="all">All Years</option>
                <?php foreach ($distinctYears as $dy): ?>
                    <option value="<?= htmlspecialchars($dy) ?>"><?= htmlspecialchars($dy) ?></option>
                <?php endforeach; ?>
            </select>
            <div style="width: 240px;">
                <input type="text" class="form-control" placeholder="Search by title..." data-table-search="rankingsTable" style="height: 36px; font-size: 13px;">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table" id="rankingsTable" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="width: 90px;">Year</th>
                    <th>Document Title</th>
                    <th style="width: 140px;">File Status</th>
                    <th style="width: 90px;">Status</th>
                    <th style="width: 130px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rankings)): ?>
                    <tr class="no-records-row">
                        <td colspan="6" style="text-align: center; padding: 36px; color: #64748b;">
                            <i class="fas fa-award" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                            No ranking documents uploaded yet. Use the form above to add one.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($rankings as $idx => $r): ?>
                        <tr data-row-year="<?= htmlspecialchars($r['academic_year']) ?>">
                            <td><?= $idx + 1 ?></td>
                            <td>
                                <span style="background: #e0f2fe; color: #0369a1; padding: 3px 9px; border-radius: 4px; font-size: 12px; font-weight: 700;">
                                    <?= htmlspecialchars($r['academic_year'] ?? '-') ?>
                                </span>
                            </td>
                            <td style="font-weight: 600; color: #1e293b;">
                                <?= htmlspecialchars($r['title']) ?>
                            </td>
                            <td>
                                <?php if (!empty($r['file_path']) && $r['file_path'] !== '#'): ?>
                                    <span style="color: #059669; font-size: 12.5px; font-weight: 600;">
                                        <i class="fas fa-file-pdf" style="color: #dc2626;"></i> <?= htmlspecialchars($r['file_size'] ?? 'PDF') ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: #f59e0b; font-size: 12px; font-weight: 600;">
                                        <i class="far fa-clock"></i> Awaiting File
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form action="rankings.php" method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                    <input type="hidden" name="status" value="<?= $r['is_active'] ?>">
                                    <button type="submit" style="border: none; background: none; cursor: pointer;" title="Toggle active status">
                                        <?= ($r['is_active'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>' ?>
                                    </button>
                                </form>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 5px; align-items: center;">
                                    <?php if (!empty($r['file_path']) && $r['file_path'] !== '#'): ?>
                                        <a href="../<?= htmlspecialchars($r['file_path']) ?>" target="_blank" class="btn btn-sm btn-info" style="padding: 4px 8px;" title="Open PDF">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="rankings.php?edit=<?= $r['id'] ?>" class="btn btn-sm btn-warning" style="padding: 4px 8px;" title="Edit / Attach PDF">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="rankings.php" method="POST" style="display: inline;" onsubmit="return confirm('Delete this ranking document?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" style="padding: 4px 8px;" title="Delete">
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

<script>
// Auto-populate title from PDF filename if title field is empty
document.getElementById('pdf_file')?.addEventListener('change', function(e) {
    const titleInput = document.getElementById('ranking_title');
    if (titleInput && (!titleInput.value || titleInput.value.trim() === '')) {
        if (this.files && this.files[0]) {
            const rawName = this.files[0].name.replace(/\.[^/.]+$/, "");
            titleInput.value = rawName.replace(/[_\-]+/g, ' ').trim();
        }
    }
});

// Admin table filter by year
document.getElementById('adminYearFilter')?.addEventListener('change', function() {
    const selected = this.value;
    const rows = document.querySelectorAll('#rankingsTable tbody tr[data-row-year]');
    rows.forEach(function(row) {
        if (selected === 'all' || row.getAttribute('data-row-year') === selected) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
