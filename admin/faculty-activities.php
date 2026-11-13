<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP.');
        header('Location: faculty-activities.php');
        exit;
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $category = trim($_POST['category'] ?? 'trainings');
        $validCategories = ['trainings', 'expert_lectures', 'conferences'];
        if (!in_array($category, $validCategories)) {
            $category = 'trainings';
        }

        $faculty_name = trim($_POST['faculty_name'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $dept_code = trim($_POST['dept_code'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $event_date = !empty($_POST['event_date']) ? $_POST['event_date'] : null;
        $year = trim($_POST['year'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($faculty_name) && $category !== 'conferences') {
            setFlashMessage('danger', 'Faculty name is required.');
            header('Location: faculty-activities.php');
            exit;
        }

        if (empty($description)) {
            setFlashMessage('danger', 'Activity details / description is required.');
            header('Location: faculty-activities.php');
            exit;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO faculty_activities (category, faculty_name, designation, dept_code, title, description, event_date, year, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $category,
                $faculty_name,
                $designation ?: null,
                $dept_code ?: null,
                $title ?: null,
                $description,
                $event_date,
                $year ?: null,
                $display_order,
                $is_active
            ]);
            setFlashMessage('success', 'Faculty activity added successfully!');
        } catch (Exception $e) {
            error_log("Faculty activity add error: " . $e->getMessage());
            setFlashMessage('danger', 'Error adding activity: ' . $e->getMessage());
        }
        header('Location: faculty-activities.php?cat=' . urlencode($category));
        exit;

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $category = trim($_POST['category'] ?? 'trainings');
        $validCategories = ['trainings', 'expert_lectures', 'conferences'];
        if (!in_array($category, $validCategories)) {
            $category = 'trainings';
        }

        $faculty_name = trim($_POST['faculty_name'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $dept_code = trim($_POST['dept_code'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $event_date = !empty($_POST['event_date']) ? $_POST['event_date'] : null;
        $year = trim($_POST['year'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if ($id > 0 && !empty($description)) {
            try {
                $stmt = $pdo->prepare("UPDATE faculty_activities SET category = ?, faculty_name = ?, designation = ?, dept_code = ?, title = ?, description = ?, event_date = ?, year = ?, display_order = ?, is_active = ? WHERE id = ?");
                $stmt->execute([
                    $category,
                    $faculty_name,
                    $designation ?: null,
                    $dept_code ?: null,
                    $title ?: null,
                    $description,
                    $event_date,
                    $year ?: null,
                    $display_order,
                    $is_active,
                    $id
                ]);
                setFlashMessage('success', 'Faculty activity updated successfully!');
            } catch (Exception $e) {
                error_log("Faculty activity update error: " . $e->getMessage());
                setFlashMessage('danger', 'Error updating activity: ' . $e->getMessage());
            }
        } else {
            setFlashMessage('danger', 'Activity details cannot be empty.');
        }
        header('Location: faculty-activities.php?cat=' . urlencode($category));
        exit;

    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        $cat = trim($_POST['cat'] ?? 'all');
        if ($id > 0) {
            try {
                $stmt = $pdo->prepare("DELETE FROM faculty_activities WHERE id = ?");
                $stmt->execute([$id]);
                setFlashMessage('success', 'Faculty activity permanently deleted from database!');
            } catch (Exception $e) {
                error_log("Faculty activity delete error: " . $e->getMessage());
                setFlashMessage('danger', 'Could not delete activity: ' . $e->getMessage());
            }
        }
        header('Location: faculty-activities.php' . ($cat !== 'all' ? '?cat=' . urlencode($cat) : ''));
        exit;
    }
}

// Toggle Active / Inactive
if (isset($_GET['toggle'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: faculty-activities.php');
        exit;
    }
    $id = (int)$_GET['toggle'];
    $cat = $_GET['cat'] ?? 'all';
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE faculty_activities SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('info', 'Activity status updated!');
    }
    header('Location: faculty-activities.php' . ($cat !== 'all' ? '?cat=' . urlencode($cat) : ''));
    exit;
}

// Quick Delete via GET with confirmation
if (isset($_GET['delete'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: faculty-activities.php');
        exit;
    }
    $id = (int)$_GET['delete'];
    $cat = $_GET['cat'] ?? 'all';
    if ($id > 0) {
        try {
            $stmt = $pdo->prepare("DELETE FROM faculty_activities WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('success', 'Faculty activity permanently deleted from database!');
        } catch (Exception $e) {
            error_log("Faculty activity delete error: " . $e->getMessage());
            setFlashMessage('danger', 'Could not delete activity: ' . $e->getMessage());
        }
    }
    header('Location: faculty-activities.php' . ($cat !== 'all' ? '?cat=' . urlencode($cat) : ''));
    exit;
}

// Load item for edit if requested
if (isset($_GET['edit']) && $pdo) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM faculty_activities WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

// Category filter
$selectedCat = $_GET['cat'] ?? 'all';
$validCats = ['trainings', 'expert_lectures', 'conferences'];
if (!in_array($selectedCat, $validCats)) {
    $selectedCat = 'all';
}

$activities = [];
$counts = ['all' => 0, 'trainings' => 0, 'expert_lectures' => 0, 'conferences' => 0];

if ($pdo) {
    // Count per category
    $cStmt = $pdo->query("SELECT category, COUNT(*) as cnt FROM faculty_activities GROUP BY category");
    while ($row = $cStmt->fetch()) {
        if (isset($counts[$row['category']])) {
            $counts[$row['category']] = (int)$row['cnt'];
        }
        $counts['all'] += (int)$row['cnt'];
    }

    // Query activities
    if ($selectedCat === 'all') {
        $stmt = $pdo->query("SELECT * FROM faculty_activities ORDER BY category ASC, display_order ASC, id ASC");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM faculty_activities WHERE category = ? ORDER BY display_order ASC, id ASC");
        $stmt->execute([$selectedCat]);
    }
    $activities = $stmt->fetchAll();
}

$departments = [
    'CE' => 'Computer Engineering',
    'IT' => 'Information Technology',
    'ME' => 'Mechanical Engineering',
    'CIVIL' => 'Civil Engineering',
    'EE' => 'Electrical Engineering',
    'EC' => 'Electronics & Communication',
    'AE' => 'Automobile Engineering',
    'AM' => 'Applied Mechanics',
    'SH' => 'Science & Humanities'
];

$current_page = 'faculty-activities';
$page_title = 'Faculty Activities Management';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div class="card-title-group">
            <h2 class="card-title" style="margin: 0; font-size: 1.45rem; font-weight: 700; color: #1e293b;">
                <i class="fas fa-chalkboard-teacher" style="color: #0284c7; margin-right: 8px;"></i> Faculty Activities
            </h2>
            <p style="margin: 4px 0 0; color: #64748b; font-size: 0.88rem;">
                Manage Trainings Attended, Expert Lectures Delivered, and Conferences Attended/Chaired.
            </p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="../faculty-activities.php" target="_blank" class="btn-secondary" style="padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; border: 1px solid #cbd5e1; background: #ffffff; color: #334155;">
                <i class="fas fa-external-link-alt" style="color: #0284c7;"></i> View Public Page
            </a>
            <button type="button" class="btn-add-new" onclick="openModal('addActivityModal')" style="padding: 8px 18px; border-radius: 6px; font-size: 13px; font-weight: 600;">
                <i class="fas fa-plus"></i> Add New Activity
            </button>
        </div>
    </div>

    <!-- Category Filter Tabs & Search -->
    <div class="card-actions-row" style="margin-top: 18px; padding-top: 16px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <!-- Filter Tabs -->
        <div style="display: flex; gap: 6px; flex-wrap: wrap;">
            <a href="faculty-activities.php?cat=all" 
               style="padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s ease; <?= ($selectedCat === 'all') ? 'background: #0284c7; color: #ffffff;' : 'background: #f1f5f9; color: #475569;' ?>">
                <span>All Activities</span>
                <span style="padding: 1px 7px; border-radius: 10px; font-size: 11px; font-weight: 700; <?= ($selectedCat === 'all') ? 'background: rgba(255,255,255,0.25); color: #fff;' : 'background: #e2e8f0; color: #334155;' ?>"><?= $counts['all'] ?></span>
            </a>
            <a href="faculty-activities.php?cat=trainings" 
               style="padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s ease; <?= ($selectedCat === 'trainings') ? 'background: #0284c7; color: #ffffff;' : 'background: #f1f5f9; color: #475569;' ?>">
                <i class="fas fa-user-graduate" style="font-size: 12px;"></i>
                <span>Trainings</span>
                <span style="padding: 1px 7px; border-radius: 10px; font-size: 11px; font-weight: 700; <?= ($selectedCat === 'trainings') ? 'background: rgba(255,255,255,0.25); color: #fff;' : 'background: #e2e8f0; color: #334155;' ?>"><?= $counts['trainings'] ?></span>
            </a>
            <a href="faculty-activities.php?cat=expert_lectures" 
               style="padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s ease; <?= ($selectedCat === 'expert_lectures') ? 'background: #0284c7; color: #ffffff;' : 'background: #f1f5f9; color: #475569;' ?>">
                <i class="fas fa-microphone-alt" style="font-size: 12px;"></i>
                <span>Expert Lectures</span>
                <span style="padding: 1px 7px; border-radius: 10px; font-size: 11px; font-weight: 700; <?= ($selectedCat === 'expert_lectures') ? 'background: rgba(255,255,255,0.25); color: #fff;' : 'background: #e2e8f0; color: #334155;' ?>"><?= $counts['expert_lectures'] ?></span>
            </a>
            <a href="faculty-activities.php?cat=conferences" 
               style="padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s ease; <?= ($selectedCat === 'conferences') ? 'background: #0284c7; color: #ffffff;' : 'background: #f1f5f9; color: #475569;' ?>">
                <i class="fas fa-users" style="font-size: 12px;"></i>
                <span>Conferences</span>
                <span style="padding: 1px 7px; border-radius: 10px; font-size: 11px; font-weight: 700; <?= ($selectedCat === 'conferences') ? 'background: rgba(255,255,255,0.25); color: #fff;' : 'background: #e2e8f0; color: #334155;' ?>"><?= $counts['conferences'] ?></span>
            </a>
        </div>

        <!-- Search Input -->
        <div class="search-input-group" style="min-width: 260px;">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" placeholder="Search activities, faculty, details..." data-table-search="facultyActivitiesTable">
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive" style="margin-top: 16px;">
        <table class="admin-table" id="facultyActivitiesTable">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">Sr.</th>
                    <th style="width: 140px;">Category</th>
                    <th style="width: 220px;">Faculty Name</th>
                    <th>Activity Details / Description</th>
                    <th style="width: 80px; text-align: center;">Dept</th>
                    <th style="width: 90px; text-align: center;">Status</th>
                    <th style="width: 110px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $sr = 1; foreach ($activities as $row): 
                    $catLabel = 'Trainings';
                    $catColor = '#0284c7';
                    $catBg = '#e0f2fe';
                    if ($row['category'] === 'expert_lectures') {
                        $catLabel = 'Expert Lecture';
                        $catColor = '#059669';
                        $catBg = '#d1fae5';
                    } elseif ($row['category'] === 'conferences') {
                        $catLabel = 'Conference';
                        $catColor = '#7c3aed';
                        $catBg = '#ede9fe';
                    }
                ?>
                <tr data-status="<?= $row['is_active'] ? 'active' : 'inactive' ?>">
                    <td style="text-align: center; font-weight: 700; color: #64748b; font-size: 13px;">
                        <?= $sr++ ?>
                    </td>
                    <td>
                        <span style="display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; background: <?= $catBg ?>; color: <?= $catColor ?>; white-space: nowrap;">
                            <?= $catLabel ?>
                        </span>
                    </td>
                    <td>
                        <div style="font-weight: 700; color: #1e293b; font-size: 13.5px;">
                            <?= !empty($row['faculty_name']) ? htmlspecialchars($row['faculty_name']) : '<span style="color: #94a3b8; font-weight: 400; font-style: italic;">— Included in text —</span>' ?>
                        </div>
                        <?php if (!empty($row['designation'])): ?>
                            <div style="color: #64748b; font-size: 12px; margin-top: 2px;">
                                <?= htmlspecialchars($row['designation']) ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td style="color: #334155; font-size: 13.5px; line-height: 1.55;">
                        <?php if (!empty($row['title'])): ?>
                            <div style="font-weight: 600; color: #0f172a; margin-bottom: 3px;">
                                <?= htmlspecialchars($row['title']) ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <?= nl2br(htmlspecialchars($row['description'])) ?>
                        </div>
                        <?php if (!empty($row['event_date']) || !empty($row['year'])): ?>
                            <div style="margin-top: 4px; font-size: 11.5px; color: #64748b; display: flex; align-items: center; gap: 8px;">
                                <?php if (!empty($row['event_date'])): ?>
                                    <span><i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($row['event_date'])) ?></span>
                                <?php endif; ?>
                                <?php if (!empty($row['year'])): ?>
                                    <span><i class="far fa-clock"></i> Year: <?= htmlspecialchars($row['year']) ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                        <?php if (!empty($row['dept_code'])): ?>
                            <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; background: #f8fafc; border: 1px solid #cbd5e1; color: #334155;">
                                <?= htmlspecialchars($row['dept_code']) ?>
                            </span>
                        <?php else: ?>
                            <span style="color: #94a3b8; font-size: 12px;">—</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="faculty-activities.php?toggle=<?= $row['id'] ?>&cat=<?= urlencode($selectedCat) ?>" 
                           title="Click to toggle status" 
                           style="text-decoration: none;">
                            <?php if ($row['is_active']): ?>
                                <span class="badge badge-success" style="cursor: pointer;"><i class="fas fa-check-circle"></i> Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary" style="cursor: pointer; opacity: 0.7;"><i class="fas fa-times-circle"></i> Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td style="text-align: center; white-space: nowrap;">
                        <button type="button" class="btn-action btn-edit" title="Edit Activity" 
                                onclick='openEditActivityModal(<?= json_encode($row) ?>)'>
                            <i class="fas fa-edit"></i>
                        </button>
                        <a href="faculty-activities.php?delete=<?= $row['id'] ?>&cat=<?= urlencode($selectedCat) ?>" 
                           class="btn-action btn-delete" title="Delete Activity" 
                           onclick="return confirm('Are you sure you want to permanently delete this faculty activity record from the database?');">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($activities)): ?>
                <tr class="no-records-row">
                    <td colspan="7" style="text-align: center; color: #64748b; padding: 40px 20px;">
                        <div style="font-size: 28px; color: #cbd5e1; margin-bottom: 8px;"><i class="fas fa-folder-open"></i></div>
                        <div style="font-size: 15px; font-weight: 600; color: #334155;">No faculty activities found in this category.</div>
                        <div style="font-size: 13px; color: #94a3b8; margin-top: 4px;">Click "+ Add New Activity" above to add the first record.</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add New Activity -->
<div class="modal-overlay" id="addActivityModal">
    <div class="modal-dialog" style="max-width: 650px;">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-plus-circle" style="color: #0284c7;"></i> Add Faculty Activity</h3>
            <button type="button" class="modal-close" onclick="closeModal('addActivityModal')">&times;</button>
        </div>
        <form method="POST" action="faculty-activities.php">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="add_category">Category <span class="required">*</span></label>
                    <select name="category" id="add_category" class="form-control" required>
                        <option value="trainings" <?= ($selectedCat === 'trainings') ? 'selected' : '' ?>>Trainings (Attended by Faculty)</option>
                        <option value="expert_lectures" <?= ($selectedCat === 'expert_lectures') ? 'selected' : '' ?>>Expert Lectures (Delivered by Faculty)</option>
                        <option value="conferences" <?= ($selectedCat === 'conferences') ? 'selected' : '' ?>>Conferences (Attended/Chaired by Faculty)</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label" for="add_faculty_name">Faculty Name <span class="required">*</span></label>
                        <input type="text" name="faculty_name" id="add_faculty_name" class="form-control" placeholder="e.g. Dr. Hemang Suryakant Pandya" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="add_designation">Designation</label>
                        <input type="text" name="designation" id="add_designation" class="form-control" placeholder="e.g. Associate Professor / Professor">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label" for="add_dept_code">Department</label>
                        <select name="dept_code" id="add_dept_code" class="form-control">
                            <option value="">-- Select Department (Optional) --</option>
                            <?php foreach ($departments as $code => $name): ?>
                                <option value="<?= $code ?>"><?= $code ?> - <?= $name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="add_year">Academic Year / Year</label>
                        <input type="text" name="year" id="add_year" class="form-control" placeholder="e.g. 2024 or 2023-24">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_title">Topic / Workshop Title (Optional)</label>
                    <input type="text" name="title" id="add_title" class="form-control" placeholder="e.g. AICTE-QIP STTP on Modern Power Converters">
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_description">Activity Details / Description <span class="required">*</span></label>
                    <textarea name="description" id="add_description" class="form-control" rows="4" placeholder="Enter complete activity description, dates, organizer, and details..." required></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label" for="add_event_date">Event Date (Optional)</label>
                        <input type="date" name="event_date" id="add_event_date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="add_display_order">Display Order</label>
                        <input type="number" name="display_order" id="add_display_order" class="form-control" value="0">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 10px;">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Display on public Faculty Activities page</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addActivityModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Add Activity</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Activity -->
<div class="modal-overlay" id="editActivityModal">
    <div class="modal-dialog" style="max-width: 650px;">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-edit" style="color: #0284c7;"></i> Edit Faculty Activity</h3>
            <button type="button" class="modal-close" onclick="closeModal('editActivityModal')">&times;</button>
        </div>
        <form method="POST" action="faculty-activities.php">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit_id" value="">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_category">Category <span class="required">*</span></label>
                    <select name="category" id="edit_category" class="form-control" required>
                        <option value="trainings">Trainings (Attended by Faculty)</option>
                        <option value="expert_lectures">Expert Lectures (Delivered by Faculty)</option>
                        <option value="conferences">Conferences (Attended/Chaired by Faculty)</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label" for="edit_faculty_name">Faculty Name</label>
                        <input type="text" name="faculty_name" id="edit_faculty_name" class="form-control" placeholder="e.g. Dr. Hemang Suryakant Pandya">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="edit_designation">Designation</label>
                        <input type="text" name="designation" id="edit_designation" class="form-control" placeholder="e.g. Associate Professor / Professor">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label" for="edit_dept_code">Department</label>
                        <select name="dept_code" id="edit_dept_code" class="form-control">
                            <option value="">-- Select Department (Optional) --</option>
                            <?php foreach ($departments as $code => $name): ?>
                                <option value="<?= $code ?>"><?= $code ?> - <?= $name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="edit_year">Academic Year / Year</label>
                        <input type="text" name="year" id="edit_year" class="form-control" placeholder="e.g. 2024 or 2023-24">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_title">Topic / Workshop Title (Optional)</label>
                    <input type="text" name="title" id="edit_title" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_description">Activity Details / Description <span class="required">*</span></label>
                    <textarea name="description" id="edit_description" class="form-control" rows="4" required></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div class="form-group">
                        <label class="form-label" for="edit_event_date">Event Date (Optional)</label>
                        <input type="date" name="event_date" id="edit_event_date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="edit_display_order">Display Order</label>
                        <input type="number" name="display_order" id="edit_display_order" class="form-control">
                    </div>
                </div>

                <div class="form-group" style="margin-top: 10px;">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                        <span>Display on public Faculty Activities page</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('editActivityModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditActivityModal(data) {
    document.getElementById('edit_id').value = data.id || '';
    document.getElementById('edit_category').value = data.category || 'trainings';
    document.getElementById('edit_faculty_name').value = data.faculty_name || '';
    document.getElementById('edit_designation').value = data.designation || '';
    document.getElementById('edit_dept_code').value = data.dept_code || '';
    document.getElementById('edit_title').value = data.title || '';
    document.getElementById('edit_description').value = data.description || '';
    document.getElementById('edit_event_date').value = data.event_date || '';
    document.getElementById('edit_year').value = data.year || '';
    document.getElementById('edit_display_order').value = data.display_order || '0';
    document.getElementById('edit_is_active').checked = (parseInt(data.is_active) === 1);
    
    openModal('editActivityModal');
}
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
