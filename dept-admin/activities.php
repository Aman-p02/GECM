<?php
/**
 * Department Admin - Activities & Events Management (Strictly scoped to dept_code)
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
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<!-- Form Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3>
            <i class="fas fa-<?= $editRecord ? 'pen-to-square' : 'calendar-plus' ?>"></i>
            <?= $editRecord ? 'Edit Department Activity' : 'Post New Activity / Event to ' . htmlspecialchars($deptName) ?>
        </h3>
        <?php if ($editRecord): ?>
            <a href="activities.php" class="btn btn-outline btn-sm">Cancel Edit</a>
        <?php endif; ?>
    </div>

    <div class="admin-card-body">
        <form method="POST" action="activities.php" enctype="multipart/form-data">
            <input type="hidden" name="record_id" value="<?= htmlspecialchars($editRecord['id'] ?? 0) ?>">
            <input type="hidden" name="current_image" value="<?= htmlspecialchars($editRecord['image_url'] ?? '') ?>">

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="title">Activity / Event Title <span class="required">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="e.g. National Level Hackathon 2026" value="<?= htmlspecialchars($editRecord['title'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="activity_date">Date of Event</label>
                    <input type="date" name="activity_date" id="activity_date" class="form-control" value="<?= htmlspecialchars($editRecord['activity_date'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="short_description">Short Summary</label>
                <input type="text" name="short_description" id="short_description" class="form-control" placeholder="Brief 1-2 sentence overview for cards" value="<?= htmlspecialchars($editRecord['short_description'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Full Details / Event Report</label>
                <textarea name="description" id="description" class="form-control" placeholder="Detailed report, guest speakers, winners, etc."><?= htmlspecialchars($editRecord['description'] ?? '') ?></textarea>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="image_file">Event Banner / Photograph</label>
                    <input type="file" name="image_file" id="image_file" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <label class="form-label" for="external_url">External Link / Registration URL</label>
                    <input type="url" name="external_url" id="external_url" class="form-control" placeholder="https://..." value="<?= htmlspecialchars($editRecord['external_url'] ?? '') ?>">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:15px;">
                <button type="submit" class="btn btn-navy">
                    <i class="fas fa-save"></i> <?= $editRecord ? 'Update Activity' : 'Publish Activity' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- List Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-list-check"></i> Published Activities (<?= count($activities) ?>)</h3>
    </div>

    <div class="data-table-wrapper">
        <?php if (empty($activities)): ?>
            <div class="empty-state">
                <i class="fas fa-calendar-xmark"></i>
                <p>No activities published yet for this department.</p>
            </div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Short Description</th>
                        <th style="width: 130px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activities as $idx => $act): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td><strong><?= htmlspecialchars($act['title']) ?></strong></td>
                            <td><?= !empty($act['activity_date']) ? date('d M Y', strtotime($act['activity_date'])) : '-' ?></td>
                            <td style="color:#64748b;"><?= htmlspecialchars($act['short_description'] ?? '-') ?></td>
                            <td style="text-align: right;">
                                <a href="activities.php?action=edit&edit_id=<?= (int)$act['id'] ?>" class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="activities.php?action=delete&id=<?= (int)$act['id'] ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Delete this activity?');">
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

