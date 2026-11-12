<?php
/**
 * Department Admin - Activities & Events Management (Clean Main Admin UI with Modal)
 */
$pageTitle = 'Department Activities';
$pageHeading = 'Activities & Events';
$activeTab = 'activities';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../admin/includes/upload_helper.php';

$pdo = getDBConnection();
$error = '';
$action = $_GET['action'] ?? '';
$editId = (int)($_GET['edit_id'] ?? 0);

// DELETE action (Strictly scoped)
if ($action === 'delete' && !empty($_GET['id'])) {
    $delId = (int)$_GET['id'];
    try {
        $delStmt = $pdo->prepare("DELETE FROM department_activities WHERE id = ? AND dept_code = ?");
        $delStmt->execute([$delId, $deptCode]);
        setDeptFlash('success', 'Activity deleted successfully.');
        header('Location: activities.php');
        exit;
    } catch (Exception $e) {
        $error = 'Delete failed: ' . $e->getMessage();
    }
}

// POST Add or Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitId = (int)($_POST['record_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $activity_date = !empty($_POST['activity_date']) ? $_POST['activity_date'] : null;
    $short_description = trim($_POST['short_description'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $external_url = trim($_POST['external_url'] ?? '');
    $display_order = (int)($_POST['display_order'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if (empty($title)) {
        $error = 'Activity title is required.';
    } else {
        $deptSubdir = 'dept_activities/' . strtolower($deptCode);
        $upload = handleImageUpload('image_file', $deptSubdir, null, $_POST['current_image'] ?? null);
        $image_url = $upload['success'] ? $upload['path'] : ($_POST['current_image'] ?? null);

        try {
            if ($submitId > 0) {
                $stmt = $pdo->prepare("UPDATE department_activities SET 
                    title = ?, 
                    activity_date = ?, 
                    image_url = ?, 
                    short_description = ?, 
                    description = ?, 
                    external_url = ?, 
                    display_order = ?, 
                    is_active = ?, 
                    updated_at = NOW() 
                    WHERE id = ? AND dept_code = ?");
                $stmt->execute([$title, $activity_date, $image_url, $short_description, $description, $external_url, $display_order, $is_active, $submitId, $deptCode]);
                setDeptFlash('success', 'Activity updated successfully.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO department_activities (dept_code, title, activity_date, image_url, short_description, description, external_url, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$deptCode, $title, $activity_date, $image_url, $short_description, $description, $external_url, $display_order, $is_active]);
                setDeptFlash('success', 'New activity published successfully.');
            }
            header('Location: activities.php');
            exit;
        } catch (Exception $e) {
            $error = 'Save failed: ' . $e->getMessage();
        }
    }
}

// Fetch edit record
$editRecord = null;
if ($action === 'edit' && $editId > 0) {
    $editStmt = $pdo->prepare("SELECT * FROM department_activities WHERE id = ? AND dept_code = ?");
    $editStmt->execute([$editId, $deptCode]);
    $editRecord = $editStmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch activities for this department
$stmt = $pdo->prepare("SELECT * FROM department_activities WHERE dept_code = ? ORDER BY activity_date DESC, id DESC");
$stmt->execute([$deptCode]);
$activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <h2 class="card-title">Department Activities (<?= count($activities) ?>)</h2>
        </div>
        <div>
            <button type="button" class="btn-add-new" onclick="openActivityModal()">
                Add Activity
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <?php if (empty($activities)): ?>
            <div style="text-align: center; padding: 48px 20px; color: var(--admin-text-muted);">
                <p>No activities published yet for this department.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Activity Title</th>
                        <th style="width: 140px;">Event Date</th>
                        <th>Summary</th>
                        <th style="width: 120px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activities as $idx => $act): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td><strong><?= htmlspecialchars($act['title']) ?></strong></td>
                            <td><?= !empty($act['activity_date']) ? date('d M Y', strtotime($act['activity_date'])) : '-' ?></td>
                            <td><?= htmlspecialchars($act['short_description'] ?? '-') ?></td>
                            <td style="text-align: right;">
                                <div class="table-actions" style="justify-content: flex-end;">
                                    <a href="javascript:void(0);" onclick='editActivity(<?= json_encode($act) ?>)' class="btn-table-action btn-edit" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="activities.php?action=delete&id=<?= (int)$act['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Delete this activity?');">
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
<!-- MODAL: ADD / EDIT ACTIVITY                                     -->
<!-- ============================================================== -->
<div class="modal-overlay" id="activityModal">
    <div class="modal-dialog" style="max-width: 650px;">
        <div class="modal-header">
            <h3 class="modal-title" id="activityModalTitle">Post New Activity</h3>
            <button type="button" class="btn-close-modal" onclick="closeActivityModal()">&times;</button>
        </div>
        <form action="activities.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="record_id" id="act_record_id" value="0">
            <input type="hidden" name="current_image" id="act_current_image" value="">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label" for="act_title">Activity Title <span class="required">*</span></label>
                        <input type="text" name="title" id="act_title" class="form-control" placeholder="e.g. National Seminar on AI" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="act_date">Date</label>
                        <input type="date" name="activity_date" id="act_date" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="act_short">Short Summary</label>
                    <input type="text" name="short_description" id="act_short" class="form-control" placeholder="1-2 sentences for summary card">
                </div>

                <div class="form-group">
                    <label class="form-label" for="act_desc">Detailed Report</label>
                    <textarea name="description" id="act_desc" class="form-control" rows="3" placeholder="Key highlights, speakers, participating students..."></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="act_img">Event Photograph</label>
                        <input type="file" name="image_file" id="act_img" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="act_url">Registration / Details URL</label>
                        <input type="url" name="external_url" id="act_url" class="form-control" placeholder="https://...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" id="act_active" value="1" checked>
                        <span>Display on public department website (Active)</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeActivityModal()">Cancel</button>
                <button type="submit" class="btn-add-new" id="actSubmitBtn">Publish Activity</button>
            </div>
        </form>
    </div>
</div>

<script>
function openActivityModal() {
    document.getElementById('activityModalTitle').textContent = 'Post New Activity';
    document.getElementById('actSubmitBtn').textContent = 'Publish Activity';
    document.getElementById('act_record_id').value = '0';
    document.getElementById('act_current_image').value = '';
    document.getElementById('act_title').value = '';
    document.getElementById('act_date').value = '';
    document.getElementById('act_short').value = '';
    document.getElementById('act_desc').value = '';
    document.getElementById('act_img').value = '';
    document.getElementById('act_url').value = '';
    document.getElementById('act_active').checked = true;
    document.getElementById('activityModal').classList.add('active');
}

function editActivity(data) {
    document.getElementById('activityModalTitle').textContent = 'Edit Activity';
    document.getElementById('actSubmitBtn').textContent = 'Update Activity';
    document.getElementById('act_record_id').value = data.id || '0';
    document.getElementById('act_current_image').value = data.image_url || '';
    document.getElementById('act_title').value = data.title || '';
    document.getElementById('act_date').value = data.activity_date || '';
    document.getElementById('act_short').value = data.short_description || '';
    document.getElementById('act_desc').value = data.description || '';
    document.getElementById('act_url').value = data.external_url || '';
    document.getElementById('act_active').checked = (data.is_active == 1);
    document.getElementById('activityModal').classList.add('active');
}

function closeActivityModal() {
    document.getElementById('activityModal').classList.remove('active');
}

<?php if ($editRecord): ?>
document.addEventListener('DOMContentLoaded', function() {
    editActivity(<?= json_encode($editRecord) ?>);
});
<?php endif; ?>
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
