<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

// Department resolution
$deptCode = strtoupper(trim($_GET['dept'] ?? 'CE'));
$validDepts = [
    'CE'    => 'Computer Engineering',
    'IT'    => 'Information Technology',
    'ME'    => 'Mechanical Engineering',
    'CIVIL' => 'Civil Engineering',
    'EE'    => 'Electrical Engineering',
    'EC'    => 'Electronics & Communication',
    'AE'    => 'Automobile Engineering',
    'AM'    => 'Applied Mechanics',
    'SH'    => 'Science & Humanities'
];

if (!isset($validDepts[$deptCode])) {
    $deptCode = 'CE';
}
$deptName = $validDepts[$deptCode];

$deptFolderMap = [
    'CE'    => 'computer',
    'IT'    => 'information-technology',
    'ME'    => 'mechanical',
    'CIVIL' => 'civil',
    'AE'    => 'automobile',
    'AM'    => 'applied-mechanics',
];
$liveDeptFolder = $deptFolderMap[$deptCode] ?? 'computer';
$livePageUrl = "../departments/{$liveDeptFolder}/index.php#activities";

// Guard against DB connection failure on write requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: dept-activities.php?dept=' . $deptCode);
        exit;
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $activity_date = !empty($_POST['activity_date']) ? $_POST['activity_date'] : null;
        $description = trim($_POST['description'] ?? '');
        $external_url = trim($_POST['external_url'] ?? '');
        $display_order = 0;
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title)) {
            setFlashMessage('danger', 'Activity Title cannot be empty.');
            header('Location: dept-activities.php?dept=' . $deptCode);
            exit;
        }

        // Handle Image Upload
        $photo_url = '';
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = handleImageUpload('image_file', 'activities');
            if ($uploadResult['success']) {
                $photo_url = $uploadResult['path'];
            } else {
                setFlashMessage('danger', 'Image upload failed: ' . $uploadResult['error']);
                header('Location: dept-activities.php?dept=' . $deptCode);
                exit;
            }
        }

        try {
            $stmt = $pdo->prepare("
                INSERT INTO department_activities 
                (dept_code, title, activity_date, image_url, description, external_url, display_order, is_active)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $deptCode, $title, $activity_date, $photo_url, $description, $external_url, $display_order, $is_active
            ]);
            setFlashMessage('success', "Activity '$title' added successfully for $deptName!");
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }

        header('Location: dept-activities.php?dept=' . $deptCode);
        exit;
    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $activity_date = !empty($_POST['activity_date']) ? $_POST['activity_date'] : null;
        $description = trim($_POST['description'] ?? '');
        $external_url = trim($_POST['external_url'] ?? '');
        $display_order = 0;
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_photo = trim($_POST['existing_photo'] ?? '');

        if ($id <= 0 || empty($title)) {
            setFlashMessage('danger', 'Invalid activity ID or title.');
            header('Location: dept-activities.php?dept=' . $deptCode);
            exit;
        }

        $photo_url = $existing_photo;
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = handleImageUpload('image_file', 'activities');
            if ($uploadResult['success']) {
                $photo_url = $uploadResult['path'];
            } else {
                setFlashMessage('danger', 'Image upload failed: ' . $uploadResult['error']);
                header('Location: dept-activities.php?dept=' . $deptCode);
                exit;
            }
        }

        try {
            $stmt = $pdo->prepare("
                UPDATE department_activities 
                SET title = ?, activity_date = ?, image_url = ?, description = ?, external_url = ?, display_order = ?, is_active = ?
                WHERE id = ? AND dept_code = ?
            ");
            $stmt->execute([
                $title, $activity_date, $photo_url, $description, $external_url, $display_order, $is_active, $id, $deptCode
            ]);
            setFlashMessage('success', 'Activity updated successfully!');
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }

        header('Location: dept-activities.php?dept=' . $deptCode);
        exit;
    }
}

// Handle GET Actions (Delete, Toggle, Edit)
if (isset($_GET['delete'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: dept-activities.php?dept=' . $deptCode);
        exit;
    }
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        try {
            $imgStmt = $pdo->prepare("SELECT image_url, dept_code FROM department_activities WHERE id = ?");
            $imgStmt->execute([$id]);
            $row = $imgStmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $targetDept = $row['dept_code'] ?: $deptCode;
                $stmt = $pdo->prepare("DELETE FROM department_activities WHERE id = ?");
                $stmt->execute([$id]);

                if (!empty($row['image_url']) && strpos($row['image_url'], 'uploads/') === 0) {
                    $phys = __DIR__ . '/../' . $row['image_url'];
                    if (file_exists($phys)) {
                        @unlink($phys);
                    }
                }
                setFlashMessage('success', 'Activity deleted successfully.');
                header('Location: dept-activities.php?dept=' . urlencode($targetDept));
                exit;
            } else {
                setFlashMessage('warning', 'Activity not found or already deleted.');
            }
        } catch (Exception $e) {
            setFlashMessage('danger', 'Delete error: ' . $e->getMessage());
        }
    }
    header('Location: dept-activities.php?dept=' . $deptCode);
    exit;
}

if (isset($_GET['toggle'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: dept-activities.php?dept=' . $deptCode);
        exit;
    }
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        try {
            $stmt = $pdo->prepare("UPDATE department_activities SET is_active = IF(is_active = 1, 0, 1) WHERE id = ? AND dept_code = ?");
            $stmt->execute([$id, $deptCode]);
            setFlashMessage('info', 'Activity status updated.');
        } catch (Exception $e) {
            setFlashMessage('danger', 'Status update error: ' . $e->getMessage());
        }
    }
    header('Location: dept-activities.php?dept=' . $deptCode);
    exit;
}

if (isset($_GET['edit']) && $pdo) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM department_activities WHERE id = ? AND dept_code = ?");
        $stmt->execute([$id, $deptCode]);
        $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Fetch all activities for this department
$activitiesList = [];
if ($pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT * FROM department_activities 
            WHERE dept_code = ? 
            ORDER BY id DESC
        ");
        $stmt->execute([$deptCode]);
        $activitiesList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Dept Activities Fetch Error: " . $e->getMessage());
    }
}

$current_page = 'dept-activities';
$page_title = "Activities - " . $deptName;
require_once __DIR__ . '/includes/header.php';
?>

<!-- Department Modules Navigation Bar -->
<div style="background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 12px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <span style="font-size: 15px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-layer-group" style="color: #2563eb;"></i> <?= htmlspecialchars($deptName) ?> (<?= htmlspecialchars($deptCode) ?>)
        </span>
    </div>

    <!-- Sub-modules of this Department -->
    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
        <a href="dept-faculty.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-users" style="margin-right: 6px;"></i> Faculty Members
        </a>
        <a href="dept-activities.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #1e90ff; color: #ffffff; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-calendar-check" style="margin-right: 6px;"></i> Activities
        </a>
        <a href="dept-publications.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 500; text-decoration: none; font-size: 13px;">
            <i class="fas fa-book" style="margin-right: 6px;"></i> Publications
        </a>
        <a href="dept-board.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 500; text-decoration: none; font-size: 13px;">
            <i class="fas fa-user-tie" style="margin-right: 6px;"></i> Advisory Board
        </a>
        <a href="dept-newsletters.php?dept=<?= urlencode($deptCode) ?>" class="btn-sm" style="background: #f1f5f9; color: #334155; padding: 7px 14px; border-radius: 6px; font-weight: 500; text-decoration: none; font-size: 13px;">
            <i class="fas fa-newspaper" style="margin-right: 6px;"></i> Newsletters
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <h2 class="card-title"><?= htmlspecialchars($deptName) ?> - Activities & Events</h2>
            <p style="color: #64748b; font-size: 13.5px; margin-top: 4px;">
                Manage departmental workshops, industrial visits, guest lectures, expert talks, and student activities.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="<?= htmlspecialchars($livePageUrl) ?>" target="_blank" class="btn-secondary" style="text-decoration: none; display: flex; align-items: center; gap: 6px; padding: 8px 16px;">
                <i class="fas fa-external-link-alt"></i> View Live Page
            </a>
            <button type="button" class="btn-add-new" onclick="openModal('addActivityModal')">
                + Add Activity
            </button>
        </div>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="card-filters" style="margin-left: auto;">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search activity title, description..." data-table-search="activitiesTable">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="admin-table" id="activitiesTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Sr.</th>
                    <th style="width: 100px;">Photo</th>
                    <th>Activity Title &amp; Date</th>
                    <th>Description</th>
                    <th style="width: 90px; text-align: center;">Status</th>
                    <th style="width: 120px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($activitiesList)): ?>
                    <tr class="no-records-row">
                        <td colspan="6" style="text-align: center; padding: 48px; color: #64748b;">
                            <i class="fas fa-calendar-times" style="font-size: 32px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                            No activities found for <?= htmlspecialchars($deptName) ?>. Click "+ Add Activity" above to create one.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $sr = 1; foreach ($activitiesList as $act): ?>
                        <tr>
                            <td>
                                <span class="badge" style="background: #f1f5f9; color: #475569; font-weight: 700;">
                                    #<?= $sr++ ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($act['image_url'])): ?>
                                    <img src="../<?= htmlspecialchars($act['image_url']) ?>" alt="Activity" style="width: 70px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #e2e8f0;" onerror="this.src='../images/slider/default.jpg'">
                                <?php else: ?>
                                    <div style="width: 70px; height: 50px; background: #f1f5f9; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 18px;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="font-weight: 600; font-size: 14.5px; color: #0f172a;">
                                    <?= htmlspecialchars($act['title']) ?>
                                </div>
                                <div style="font-size: 12.5px; color: #64748b; margin-top: 3px;">
                                    <i class="far fa-calendar-alt" style="margin-right: 4px;"></i>
                                    <?= !empty($act['activity_date']) ? date('M d, Y', strtotime($act['activity_date'])) : 'No date' ?>
                                    <?php if (!empty($act['external_url'])): ?>
                                        <a href="<?= htmlspecialchars($act['external_url']) ?>" target="_blank" style="margin-left: 10px; color: #2563eb; text-decoration: none;">
                                            <i class="fas fa-link"></i> Link
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 13.5px; color: #475569; max-width: 380px; line-height: 1.45;">
                                    <?= htmlspecialchars(mb_strimwidth(strip_tags($act['description']), 0, 140, '...')) ?>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <a href="dept-activities.php?dept=<?= $deptCode ?>&toggle=<?= $act['id'] ?>" class="status-pill <?= $act['is_active'] ? 'active' : 'inactive' ?>" title="Click to toggle visibility">
                                    <?= $act['is_active'] ? 'Active' : 'Hidden' ?>
                                </a>
                            </td>
                            <td style="text-align: right;">
                                <div class="action-btn-group">
                                    <a href="dept-activities.php?dept=<?= $deptCode ?>&edit=<?= $act['id'] ?>" class="btn-action edit" title="Edit Activity">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="dept-activities.php?dept=<?= $deptCode ?>&delete=<?= $act['id'] ?>" class="btn-action delete" title="Delete Activity" onclick="return confirm('Are you sure you want to delete this activity?');">
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
<!-- MODAL: ADD NEW ACTIVITY                                        -->
<!-- ============================================================== -->
<div class="admin-modal" id="addActivityModal">
    <div class="modal-dialog" style="max-width: 680px;">
        <div class="modal-header">
            <h3 class="modal-title">Add New Activity (<?= htmlspecialchars($deptName) ?>)</h3>
            <button type="button" class="btn-close-modal" onclick="closeModal('addActivityModal')">&times;</button>
        </div>
        <form action="dept-activities.php?dept=<?= $deptCode ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label" for="add_title">Activity Title <span class="required">*</span></label>
                        <input type="text" name="title" id="add_title" class="form-control" placeholder="e.g. Two Day Workshop on Full Stack Web Development" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="add_date">Activity Date</label>
                        <input type="date" name="activity_date" id="add_date" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_image">Activity Photo / Banner</label>
                    <input type="file" name="image_file" id="add_image" class="form-control" accept="image/*">
                    <small style="color: #64748b; font-size: 11px;">Recommended size: 800x500px JPG/PNG/WebP</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_url">External / Registration / Report Link (Optional)</label>
                    <input type="text" name="external_url" id="add_url" class="form-control" placeholder="https://...">
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_desc">Activity Description <span class="required">*</span></label>
                    <textarea name="description" id="add_desc" class="form-control" rows="5" placeholder="Write full details about the activity, topics covered, dignitaries, student participation..." required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Display on public department website (Active)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addActivityModal')">Cancel</button>
                <button type="submit" class="btn-primary">Save Activity</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: EDIT ACTIVITY                                           -->
<!-- ============================================================== -->
<?php if ($editItem): ?>
<div class="admin-modal show" id="editActivityModal">
    <div class="modal-dialog" style="max-width: 680px;">
        <div class="modal-header">
            <h3 class="modal-title">Edit Activity: <?= htmlspecialchars($editItem['title']) ?></h3>
            <a href="dept-activities.php?dept=<?= $deptCode ?>" class="btn-close-modal">&times;</a>
        </div>
        <form action="dept-activities.php?dept=<?= $deptCode ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <input type="hidden" name="existing_photo" value="<?= htmlspecialchars($editItem['image_url'] ?? '') ?>">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label" for="edit_title">Activity Title <span class="required">*</span></label>
                        <input type="text" name="title" id="edit_title" class="form-control" value="<?= htmlspecialchars($editItem['title']) ?>" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="edit_date">Activity Date</label>
                        <input type="date" name="activity_date" id="edit_date" class="form-control" value="<?= htmlspecialchars($editItem['activity_date'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Activity Photo / Banner</label>
                    <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 8px;">
                        <?php if (!empty($editItem['image_url'])): ?>
                            <img src="../<?= htmlspecialchars($editItem['image_url']) ?>" style="width: 60px; height: 45px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;" onerror="this.src='../images/slider/default.jpg'">
                        <?php endif; ?>
                        <input type="file" name="image_file" class="form-control" accept="image/*" style="flex: 1;">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_url">External / Registration / Report Link</label>
                    <input type="text" name="external_url" id="edit_url" class="form-control" value="<?= htmlspecialchars($editItem['external_url'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_desc">Activity Description <span class="required">*</span></label>
                    <textarea name="description" id="edit_desc" class="form-control" rows="5" required><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                        <span>Display on public department website (Active)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="dept-activities.php?dept=<?= $deptCode ?>" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Update Activity</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

