<?php
/**
 * Department Admin - Newsletters Management (Strictly scoped to dept_code)
 */
$pageTitle = 'Department Newsletters';
$pageHeading = 'Newsletters & Magazines';
$activeTab = 'newsletters';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../admin/includes/upload_helper.php';

$pdo = getDBConnection();
$error = '';
$action = $_GET['action'] ?? '';
$editId = (int)($_GET['edit_id'] ?? 0);

// DELETE action
if ($action === 'delete' && !empty($_GET['id'])) {
    $delId = (int)$_GET['id'];
    try {
        $delStmt = $pdo->prepare("DELETE FROM department_newsletters WHERE id = ? AND dept_code = ?");
        $delStmt->execute([$delId, $deptCode]);
        setDeptFlash('success', 'Newsletter deleted successfully.');
        header('Location: newsletters.php');
        exit;
    } catch (Exception $e) {
        $error = 'Delete failed: ' . $e->getMessage();
    }
}

// POST Add or Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitId = (int)($_POST['record_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $volume_issue = trim($_POST['volume_issue'] ?? '');
    $issue_period = trim($_POST['issue_period'] ?? '');
    $display_order = (int)($_POST['display_order'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if (empty($title)) {
        $error = 'Newsletter title is required.';
    } else {
        $deptSubdir = 'dept_newsletters/' . strtolower($deptCode);
        $upload = handlePdfUpload('pdf_file', $deptSubdir, null, $_POST['current_pdf'] ?? null);
        $pdf_file = $upload['success'] ? $upload['path'] : ($_POST['current_pdf'] ?? null);
        $file_size = $upload['success'] ? ($upload['size'] ?? null) : ($_POST['current_size'] ?? null);

        try {
            if ($submitId > 0) {
                $stmt = $pdo->prepare("UPDATE department_newsletters SET 
                    title = ?, 
                    volume_issue = ?, 
                    issue_period = ?, 
                    pdf_file = ?, 
                    file_size = ?, 
                    display_order = ?, 
                    is_active = ?, 
                    updated_at = NOW() 
                    WHERE id = ? AND dept_code = ?");
                $stmt->execute([$title, $volume_issue, $issue_period, $pdf_file, $file_size, $display_order, $is_active, $submitId, $deptCode]);
                setDeptFlash('success', 'Newsletter updated successfully.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO department_newsletters (dept_code, title, volume_issue, issue_period, pdf_file, file_size, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$deptCode, $title, $volume_issue, $issue_period, $pdf_file, $file_size, $display_order, $is_active]);
                setDeptFlash('success', 'New newsletter published successfully.');
            }
            header('Location: newsletters.php');
            exit;
        } catch (Exception $e) {
            $error = 'Save failed: ' . $e->getMessage();
        }
    }
}

// Fetch edit record
$editRecord = null;
if ($action === 'edit' && $editId > 0) {
    $editStmt = $pdo->prepare("SELECT * FROM department_newsletters WHERE id = ? AND dept_code = ?");
    $editStmt->execute([$editId, $deptCode]);
    $editRecord = $editStmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch newsletters
$stmt = $pdo->prepare("SELECT * FROM department_newsletters WHERE dept_code = ? ORDER BY display_order ASC, id DESC");
$stmt->execute([$deptCode]);
$newsletters = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<!-- Form Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3>
            <i class="fas fa-<?= $editRecord ? 'pen-to-square' : 'file-circle-plus' ?>"></i>
            <?= $editRecord ? 'Edit Newsletter' : 'Publish Department Newsletter for ' . htmlspecialchars($deptName) ?>
        </h3>
        <?php if ($editRecord): ?>
            <a href="newsletters.php" class="btn btn-outline btn-sm">Cancel Edit</a>
        <?php endif; ?>
    </div>

    <div class="admin-card-body">
        <form method="POST" action="newsletters.php" enctype="multipart/form-data">
            <input type="hidden" name="record_id" value="<?= htmlspecialchars($editRecord['id'] ?? 0) ?>">
            <input type="hidden" name="current_pdf" value="<?= htmlspecialchars($editRecord['pdf_file'] ?? '') ?>">
            <input type="hidden" name="current_size" value="<?= htmlspecialchars($editRecord['file_size'] ?? '') ?>">

            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label" for="title">Title <span class="required">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="e.g. BytePulse" value="<?= htmlspecialchars($editRecord['title'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="volume_issue">Volume & Issue</label>
                    <input type="text" name="volume_issue" id="volume_issue" class="form-control" placeholder="e.g. Vol 4, Issue 2" value="<?= htmlspecialchars($editRecord['volume_issue'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="issue_period">Issue Period</label>
                    <input type="text" name="issue_period" id="issue_period" class="form-control" placeholder="e.g. Jan - Jun 2026" value="<?= htmlspecialchars($editRecord['issue_period'] ?? '') ?>">
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="pdf_file">Newsletter Document (PDF)</label>
                    <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept="application/pdf">
                </div>

                <div class="form-group">
                    <label class="form-label" for="display_order">Display Sort Order</label>
                    <input type="number" name="display_order" id="display_order" class="form-control" value="<?= htmlspecialchars($editRecord['display_order'] ?? 0) ?>">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:15px;">
                <button type="submit" class="btn btn-navy">
                    <i class="fas fa-save"></i> <?= $editRecord ? 'Update Newsletter' : 'Publish Newsletter' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- List Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-list-check"></i> Published Newsletters (<?= count($newsletters) ?>)</h3>
    </div>

    <div class="data-table-wrapper">
        <?php if (empty($newsletters)): ?>
            <div class="empty-state">
                <i class="fas fa-file-pdf"></i>
                <p>No newsletters published yet for this department.</p>
            </div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Title</th>
                        <th>Volume / Issue</th>
                        <th>Period</th>
                        <th>PDF</th>
                        <th style="width: 130px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newsletters as $idx => $nl): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td><strong><?= htmlspecialchars($nl['title']) ?></strong></td>
                            <td><?= htmlspecialchars($nl['volume_issue'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($nl['issue_period'] ?? '-') ?></td>
                            <td>
                                <?php if (!empty($nl['pdf_file'])): ?>
                                    <a href="../<?= htmlspecialchars(ltrim($nl['pdf_file'], '/')) ?>" target="_blank" style="color:#2563eb; text-decoration:none;">
                                        <i class="fas fa-file-pdf"></i> View PDF
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <a href="newsletters.php?action=edit&edit_id=<?= (int)$nl['id'] ?>" class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="newsletters.php?action=delete&id=<?= (int)$nl['id'] ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Delete this newsletter?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

