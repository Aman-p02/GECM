<?php
/**
 * Department Admin - Newsletters Management (Clean Main Admin UI with Modal)
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
        $file_size = $upload['success'] ? ($upload['file_size'] ?? null) : ($_POST['current_size'] ?? null);

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
    <div class="admin-alert admin-alert-danger">
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<!-- Main Admin Card with Top Action Bar -->
<div class="admin-card">
    <div class="card-top">
        <div>
            <h2 class="card-title">Department Newsletters (<?= count($newsletters) ?>)</h2>
        </div>
        <div>
            <button type="button" class="btn-add-new" onclick="openNewsletterModal()">
                Add Newsletter
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <?php if (empty($newsletters)): ?>
            <div style="text-align: center; padding: 48px 20px; color: var(--admin-text-muted);">
                <p>No newsletters published yet for this department.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Newsletter Title</th>
                        <th style="width: 140px;">Volume / Issue</th>
                        <th style="width: 140px;">Period</th>
                        <th style="width: 120px;">PDF</th>
                        <th style="width: 120px; text-align: right;">Action</th>
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
                                    <a href="../<?= htmlspecialchars(ltrim($nl['pdf_file'], '/')) ?>" target="_blank" style="color:var(--admin-primary); font-weight:600;">
                                        View PDF <?= !empty($nl['file_size']) ? '(' . htmlspecialchars($nl['file_size']) . ')' : '' ?>
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <div class="table-actions" style="justify-content: flex-end;">
                                    <a href="javascript:void(0);" onclick='editNewsletter(<?= json_encode($nl) ?>)' class="btn-table-action btn-edit" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="newsletters.php?action=delete&id=<?= (int)$nl['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Delete this newsletter?');">
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
<!-- MODAL: ADD / EDIT NEWSLETTER                                   -->
<!-- ============================================================== -->
<div class="modal-overlay" id="newsletterModal">
    <div class="modal-dialog" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title" id="newsletterModalTitle">Publish Newsletter</h3>
            <button type="button" class="btn-close-modal" onclick="closeNewsletterModal()">&times;</button>
        </div>
        <form action="newsletters.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="record_id" id="nl_record_id" value="0">
            <input type="hidden" name="current_pdf" id="nl_current_pdf" value="">
            <input type="hidden" name="current_size" id="nl_current_size" value="">

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="nl_title">Newsletter Title <span class="required">*</span></label>
                    <input type="text" name="title" id="nl_title" class="form-control" placeholder="e.g. Nirman - Civil Engineering Newsletter" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="nl_volume">Volume & Issue</label>
                        <input type="text" name="volume_issue" id="nl_volume" class="form-control" placeholder="e.g. Vol 3, Issue 1">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nl_period">Period</label>
                        <input type="text" name="issue_period" id="nl_period" class="form-control" placeholder="e.g. Jan - Jun 2026">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="nl_pdf">Newsletter Document (PDF) <span class="required">*</span></label>
                    <input type="file" name="pdf_file" id="nl_pdf" class="form-control" accept="application/pdf">
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" id="nl_active" value="1" checked>
                        <span>Display on public department website (Active)</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeNewsletterModal()">Cancel</button>
                <button type="submit" class="btn-add-new" id="nlSubmitBtn">Save Newsletter</button>
            </div>
        </form>
    </div>
</div>

<script>
function openNewsletterModal() {
    document.getElementById('newsletterModalTitle').textContent = 'Publish Newsletter';
    document.getElementById('nlSubmitBtn').textContent = 'Save Newsletter';
    document.getElementById('nl_record_id').value = '0';
    document.getElementById('nl_current_pdf').value = '';
    document.getElementById('nl_current_size').value = '';
    document.getElementById('nl_title').value = '';
    document.getElementById('nl_volume').value = '';
    document.getElementById('nl_period').value = '';
    document.getElementById('nl_pdf').value = '';
    document.getElementById('nl_active').checked = true;
    document.getElementById('newsletterModal').classList.add('active');
}

function editNewsletter(data) {
    document.getElementById('newsletterModalTitle').textContent = 'Edit Newsletter';
    document.getElementById('nlSubmitBtn').textContent = 'Update Newsletter';
    document.getElementById('nl_record_id').value = data.id || '0';
    document.getElementById('nl_current_pdf').value = data.pdf_file || '';
    document.getElementById('nl_current_size').value = data.file_size || '';
    document.getElementById('nl_title').value = data.title || '';
    document.getElementById('nl_volume').value = data.volume_issue || '';
    document.getElementById('nl_period').value = data.issue_period || '';
    document.getElementById('nl_active').checked = (data.is_active == 1);
    document.getElementById('newsletterModal').classList.add('active');
}

function closeNewsletterModal() {
    document.getElementById('newsletterModal').classList.remove('active');
}

<?php if ($editRecord): ?>
document.addEventListener('DOMContentLoaded', function() {
    editNewsletter(<?= json_encode($editRecord) ?>);
});
<?php endif; ?>
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
