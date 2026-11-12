<?php
/**
 * Department Admin - Advisory Board Management (Strictly scoped to dept_code)
 */
$pageTitle = 'Industry Advisory Board';
$pageHeading = 'Industry Advisory Board';
$activeTab = 'board';

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
        $delStmt = $pdo->prepare("DELETE FROM department_advisory_board WHERE id = ? AND dept_code = ?");
        $delStmt->execute([$delId, $deptCode]);
        setDeptFlash('success', 'Board member deleted successfully.');
        header('Location: board.php');
        exit;
    } catch (Exception $e) {
        $error = 'Delete failed: ' . $e->getMessage();
    }
}

// POST Add or Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitId = (int)($_POST['record_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $academic_year = trim($_POST['academic_year'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $display_order = (int)($_POST['display_order'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if (empty($title)) {
        $error = 'Member Name / Title is required.';
    } else {
        $deptSubdir = 'dept_board/' . strtolower($deptCode);
        $upload = handlePdfUpload('pdf_file', $deptSubdir, null, $_POST['current_pdf'] ?? null);
        $pdf_file = $upload['success'] ? $upload['path'] : ($_POST['current_pdf'] ?? null);

        try {
            if ($submitId > 0) {
                $stmt = $pdo->prepare("UPDATE department_advisory_board SET 
                    title = ?, 
                    academic_year = ?, 
                    pdf_file = ?, 
                    description = ?, 
                    display_order = ?, 
                    is_active = ?, 
                    updated_at = NOW() 
                    WHERE id = ? AND dept_code = ?");
                $stmt->execute([$title, $academic_year, $pdf_file, $description, $display_order, $is_active, $submitId, $deptCode]);
                setDeptFlash('success', 'Board entry updated successfully.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO department_advisory_board (dept_code, title, academic_year, pdf_file, description, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$deptCode, $title, $academic_year, $pdf_file, $description, $display_order, $is_active]);
                setDeptFlash('success', 'Board entry added successfully.');
            }
            header('Location: board.php');
            exit;
        } catch (Exception $e) {
            $error = 'Save failed: ' . $e->getMessage();
        }
    }
}

// Fetch edit record
$editRecord = null;
if ($action === 'edit' && $editId > 0) {
    $editStmt = $pdo->prepare("SELECT * FROM department_advisory_board WHERE id = ? AND dept_code = ?");
    $editStmt->execute([$editId, $deptCode]);
    $editRecord = $editStmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch board entries
$stmt = $pdo->prepare("SELECT * FROM department_advisory_board WHERE dept_code = ? ORDER BY display_order ASC, id DESC");
$stmt->execute([$deptCode]);
$boardEntries = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <i class="fas fa-<?= $editRecord ? 'pen-to-square' : 'user-plus' ?>"></i>
            <?= $editRecord ? 'Edit Advisory Board Entry' : 'Add Advisory Board Member / Document for ' . htmlspecialchars($deptName) ?>
        </h3>
        <?php if ($editRecord): ?>
            <a href="board.php" class="btn btn-outline btn-sm">Cancel Edit</a>
        <?php endif; ?>
    </div>

    <div class="admin-card-body">
        <form method="POST" action="board.php" enctype="multipart/form-data">
            <input type="hidden" name="record_id" value="<?= htmlspecialchars($editRecord['id'] ?? 0) ?>">
            <input type="hidden" name="current_pdf" value="<?= htmlspecialchars($editRecord['pdf_file'] ?? '') ?>">

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="title">Title / Name of Member <span class="required">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="e.g. Department Industry Advisory Board or Mr. Rajesh Shah" value="<?= htmlspecialchars($editRecord['title'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="academic_year">Academic Year / Term</label>
                    <input type="text" name="academic_year" id="academic_year" class="form-control" placeholder="e.g. 2024-2025" value="<?= htmlspecialchars($editRecord['academic_year'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Role / Organization / Designation</label>
                <textarea name="description" id="description" class="form-control" placeholder="e.g. Vice President, TCS Gandhinagar / Senior Research Scientist, ISRO"><?= htmlspecialchars($editRecord['description'] ?? '') ?></textarea>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="pdf_file">Upload Minutes / Circular (PDF)</label>
                    <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept="application/pdf">
                </div>

                <div class="form-group">
                    <label class="form-label" for="display_order">Display Sort Order</label>
                    <input type="number" name="display_order" id="display_order" class="form-control" value="<?= htmlspecialchars($editRecord['display_order'] ?? 0) ?>">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:15px;">
                <button type="submit" class="btn btn-navy">
                    <i class="fas fa-save"></i> <?= $editRecord ? 'Update Entry' : 'Save Entry' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- List Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-list-check"></i> Advisory Board Members / Documents (<?= count($boardEntries) ?>)</h3>
    </div>

    <div class="data-table-wrapper">
        <?php if (empty($boardEntries)): ?>
            <div class="empty-state">
                <i class="fas fa-user-group"></i>
                <p>No advisory board entries added yet for this department.</p>
            </div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Name / Document Title</th>
                        <th>Academic Year</th>
                        <th>Role / Organization</th>
                        <th style="width: 130px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($boardEntries as $idx => $b): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td><strong><?= htmlspecialchars($b['title']) ?></strong></td>
                            <td><?= htmlspecialchars($b['academic_year'] ?? '-') ?></td>
                            <td style="color:#64748b;"><?= htmlspecialchars($b['description'] ?? '-') ?></td>
                            <td style="text-align: right;">
                                <a href="board.php?action=edit&edit_id=<?= (int)$b['id'] ?>" class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="board.php?action=delete&id=<?= (int)$b['id'] ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Delete this entry?');">
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

