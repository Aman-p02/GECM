<?php
/**
 * Department Admin - Advisory Board Management (Clean Main Admin UI with Modal)
 */
$pageTitle = 'Industry Advisory Board';
$pageHeading = 'Advisory Board';
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
        setDeptFlash('success', 'Board entry deleted successfully.');
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
        $error = 'Title or Member Name is required.';
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
    <div class="admin-alert admin-alert-danger">
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<!-- Main Admin Card with Top Action Bar -->
<div class="admin-card">
    <div class="card-top">
        <div>
            <h2 class="card-title">Industry Advisory Board (<?= count($boardEntries) ?>)</h2>
        </div>
        <div>
            <button type="button" class="btn-add-new" onclick="openBoardModal()">
                Add Board Entry
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <?php if (empty($boardEntries)): ?>
            <div style="text-align: center; padding: 48px 20px; color: var(--admin-text-muted);">
                <p>No advisory board entries added yet for this department.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Member / Document Title</th>
                        <th style="width: 140px;">Academic Year</th>
                        <th>Role / Organization</th>
                        <th style="width: 100px;">Minutes PDF</th>
                        <th style="width: 120px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($boardEntries as $idx => $b): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td><strong><?= htmlspecialchars($b['title']) ?></strong></td>
                            <td><?= htmlspecialchars($b['academic_year'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($b['description'] ?? '-') ?></td>
                            <td>
                                <?php if (!empty($b['pdf_file'])): ?>
                                    <a href="../<?= htmlspecialchars(ltrim($b['pdf_file'], '/')) ?>" target="_blank" style="color:var(--admin-primary); font-weight:600;">
                                        View PDF
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <div class="table-actions" style="justify-content: flex-end;">
                                    <a href="javascript:void(0);" onclick='editBoard(<?= json_encode($b) ?>)' class="btn-table-action btn-edit" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="board.php?action=delete&id=<?= (int)$b['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Delete this entry?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: ADD / EDIT BOARD                                        -->
<!-- ============================================================== -->
<div class="modal-overlay" id="boardModal">
    <div class="modal-dialog" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title" id="boardModalTitle">Add Advisory Board Entry</h3>
            <button type="button" class="btn-close-modal" onclick="closeBoardModal()">&times;</button>
        </div>
        <form action="board.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="record_id" id="board_record_id" value="0">
            <input type="hidden" name="current_pdf" id="board_current_pdf" value="">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label" for="board_title">Member Name or Document Title <span class="required">*</span></label>
                        <input type="text" name="title" id="board_title" class="form-control" placeholder="e.g. Mr. Rajesh Shah / IAB Minutes" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="board_year">Academic Year</label>
                        <input type="text" name="academic_year" id="board_year" class="form-control" placeholder="e.g. 2024-25">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="board_desc">Role / Organization / Designation</label>
                    <textarea name="description" id="board_desc" class="form-control" rows="2" placeholder="e.g. Executive Engineer, R&B Division / Senior VP, L&T"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="board_pdf">Minutes / Circular (PDF Document)</label>
                    <input type="file" name="pdf_file" id="board_pdf" class="form-control" accept="application/pdf">
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" id="board_active" value="1" checked>
                        <span>Display on public department website (Active)</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeBoardModal()">Cancel</button>
                <button type="submit" class="btn-add-new" id="boardSubmitBtn">Save Entry</button>
            </div>
        </form>
    </div>
</div>

<script>
function openBoardModal() {
    document.getElementById('boardModalTitle').textContent = 'Add Advisory Board Entry';
    document.getElementById('boardSubmitBtn').textContent = 'Save Entry';
    document.getElementById('board_record_id').value = '0';
    document.getElementById('board_current_pdf').value = '';
    document.getElementById('board_title').value = '';
    document.getElementById('board_year').value = '';
    document.getElementById('board_desc').value = '';
    document.getElementById('board_pdf').value = '';
    document.getElementById('board_active').checked = true;
    document.getElementById('boardModal').classList.add('active');
}

function editBoard(data) {
    document.getElementById('boardModalTitle').textContent = 'Edit Board Entry';
    document.getElementById('boardSubmitBtn').textContent = 'Update Entry';
    document.getElementById('board_record_id').value = data.id || '0';
    document.getElementById('board_current_pdf').value = data.pdf_file || '';
    document.getElementById('board_title').value = data.title || '';
    document.getElementById('board_year').value = data.academic_year || '';
    document.getElementById('board_desc').value = data.description || '';
    document.getElementById('board_active').checked = (data.is_active == 1);
    document.getElementById('boardModal').classList.add('active');
}

function closeBoardModal() {
    document.getElementById('boardModal').classList.remove('active');
}

<?php if ($editRecord): ?>
document.addEventListener('DOMContentLoaded', function() {
    editBoard(<?= json_encode($editRecord) ?>);
});
<?php endif; ?>
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
