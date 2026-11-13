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
        $description = trim($_POST['description'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if ($category !== 'conferences' && empty($faculty_name)) {
            setFlashMessage('danger', 'Faculty name is required for ' . ucfirst(str_replace('_', ' ', $category)) . '.');
            header('Location: faculty-activities.php?cat=' . urlencode($category));
            exit;
        }

        if (empty($description)) {
            setFlashMessage('danger', 'Activity details / description is required.');
            header('Location: faculty-activities.php?cat=' . urlencode($category));
            exit;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO faculty_activities (category, faculty_name, description, display_order, is_active) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $category,
                $faculty_name,
                $description,
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
        $description = trim($_POST['description'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if ($category !== 'conferences' && empty($faculty_name)) {
            setFlashMessage('danger', 'Faculty name is required.');
            header('Location: faculty-activities.php?cat=' . urlencode($category));
            exit;
        }

        if ($id > 0 && !empty($description)) {
            try {
                $stmt = $pdo->prepare("UPDATE faculty_activities SET category = ?, faculty_name = ?, description = ?, display_order = ?, is_active = ? WHERE id = ?");
                $stmt->execute([
                    $category,
                    $faculty_name,
                    $description,
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
    if ($selectedCat === 'conferences') {
        $stmt = $pdo->query("SELECT * FROM faculty_activities WHERE category = 'conferences' ORDER BY id DESC");
    } elseif ($selectedCat === 'all') {
        $stmt = $pdo->query("SELECT * FROM faculty_activities ORDER BY CASE WHEN category = 'conferences' THEN 0 ELSE 1 END, display_order ASC, id DESC");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM faculty_activities WHERE category = ? ORDER BY display_order ASC, id ASC");
        $stmt->execute([$selectedCat]);
    }
    $activities = $stmt->fetchAll();
}

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
            <button type="button" class="btn-add-new" onclick="openAddModalFor('<?= $selectedCat === 'all' ? 'conferences' : $selectedCat ?>')" style="padding: 8px 18px; border-radius: 6px; font-size: 13px; font-weight: 600;">
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
                <span>All</span>
                <span style="padding: 1px 7px; border-radius: 10px; font-size: 11px; font-weight: 700; <?= ($selectedCat === 'all') ? 'background: rgba(255,255,255,0.25); color: #fff;' : 'background: #e2e8f0; color: #334155;' ?>"><?= $counts['all'] ?></span>
            </a>
            <a href="faculty-activities.php?cat=conferences" 
               style="padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all 0.15s ease; <?= ($selectedCat === 'conferences') ? 'background: #0284c7; color: #ffffff;' : 'background: #f1f5f9; color: #475569;' ?>">
                <i class="fas fa-users" style="font-size: 12px;"></i>
                <span>Conferences</span>
                <span style="padding: 1px 7px; border-radius: 10px; font-size: 11px; font-weight: 700; <?= ($selectedCat === 'conferences') ? 'background: rgba(255,255,255,0.25); color: #fff;' : 'background: #e2e8f0; color: #334155;' ?>"><?= $counts['conferences'] ?></span>
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
                    <th>Activity / Conference Details</th>
                    <th style="width: 90px; text-align: center;">Status</th>
                    <th style="width: 110px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $sr = 1; foreach ($activities as $row): 
                    $catLabel = 'Conferences';
                    $catColor = '#7c3aed';
                    $catBg = '#ede9fe';
                    if ($row['category'] === 'trainings') {
                        $catLabel = 'Trainings';
                        $catColor = '#0284c7';
                        $catBg = '#e0f2fe';
                    } elseif ($row['category'] === 'expert_lectures') {
                        $catLabel = 'Expert Lectures';
                        $catColor = '#059669';
                        $catBg = '#d1fae5';
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
                        <?php if ($row['category'] === 'conferences'): ?>
                            <span style="color: #94a3b8; font-size: 12px; font-style: italic;">Included in details</span>
                        <?php else: ?>
                            <div style="font-weight: 700; color: #1e293b; font-size: 13.5px;">
                                <?= htmlspecialchars($row['faculty_name'] ?? '—') ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td style="color: #334155; font-size: 13.5px; line-height: 1.55;">
                        <?= nl2br(htmlspecialchars($row['description'])) ?>
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
                           onclick="return confirm('Are you sure you want to permanently delete this record?');">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($activities)): ?>
                <tr class="no-records-row">
                    <td colspan="6" style="text-align: center; color: #64748b; padding: 40px 20px;">
                        <div style="font-size: 28px; color: #cbd5e1; margin-bottom: 8px;"><i class="fas fa-folder-open"></i></div>
                        <div style="font-size: 15px; font-weight: 600; color: #334155;">No records found in this category.</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add New Activity -->
<div class="modal-overlay" id="addActivityModal">
    <div class="modal-dialog" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title" id="addModalTitle"><i class="fas fa-plus-circle" style="color: #0284c7;"></i> Add Faculty Activity</h3>
            <button type="button" class="modal-close" onclick="closeModal('addActivityModal')">&times;</button>
        </div>
        <form method="POST" action="faculty-activities.php">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="add_category">Category <span class="required">*</span></label>
                    <select name="category" id="add_category" class="form-control" onchange="syncAddModalFields()" required>
                        <option value="conferences" <?= ($selectedCat === 'conferences') ? 'selected' : '' ?>>Conferences (Attended / Chaired by Faculty)</option>
                        <option value="trainings" <?= ($selectedCat === 'trainings') ? 'selected' : '' ?>>Trainings (Attended by Faculty)</option>
                        <option value="expert_lectures" <?= ($selectedCat === 'expert_lectures') ? 'selected' : '' ?>>Expert Lectures (Delivered by Faculty)</option>
                    </select>
                </div>

                <!-- Faculty Name (Visible only for Trainings & Expert Lectures) -->
                <div class="form-group" id="add_faculty_name_group">
                    <label class="form-label" for="add_faculty_name">Faculty Name <span class="required">*</span></label>
                    <input type="text" name="faculty_name" id="add_faculty_name" class="form-control" placeholder="e.g. Dr. Rajendrakumar J. Jani">
                </div>

                <!-- Description / Activity Detail -->
                <div class="form-group">
                    <label class="form-label" id="add_description_label" for="add_description">Conferences Attended/Chaired by Faculty <span class="required">*</span></label>
                    <textarea name="description" id="add_description" class="form-control" rows="5" placeholder="Enter complete conference details (e.g. Dr. B. J. Shah, Professor in Applied Mechanics, attended the International conclave...)" required></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; align-items: center;">
                    <div class="form-group" id="add_display_order_group" style="margin-bottom: 0;">
                        <label class="form-label" for="add_display_order">Display Order</label>
                        <input type="number" name="display_order" id="add_display_order" class="form-control" value="0">
                    </div>

                    <div class="form-group" style="margin-bottom: 0; padding-top: 24px;">
                        <label class="form-check">
                            <input type="checkbox" name="is_active" value="1" checked>
                            <span>Active / Display on Website</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addActivityModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Add Record</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Activity -->
<div class="modal-overlay" id="editActivityModal">
    <div class="modal-dialog" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-edit" style="color: #0284c7;"></i> Edit Record</h3>
            <button type="button" class="modal-close" onclick="closeModal('editActivityModal')">&times;</button>
        </div>
        <form method="POST" action="faculty-activities.php">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit_id" value="">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_category">Category <span class="required">*</span></label>
                    <select name="category" id="edit_category" class="form-control" onchange="syncEditModalFields()" required>
                        <option value="conferences">Conferences (Attended / Chaired by Faculty)</option>
                        <option value="trainings">Trainings (Attended by Faculty)</option>
                        <option value="expert_lectures">Expert Lectures (Delivered by Faculty)</option>
                    </select>
                </div>

                <!-- Faculty Name (Visible only for Trainings & Expert Lectures) -->
                <div class="form-group" id="edit_faculty_name_group">
                    <label class="form-label" for="edit_faculty_name">Faculty Name <span class="required">*</span></label>
                    <input type="text" name="faculty_name" id="edit_faculty_name" class="form-control">
                </div>

                <!-- Description / Activity Detail -->
                <div class="form-group">
                    <label class="form-label" id="edit_description_label" for="edit_description">Details / Description <span class="required">*</span></label>
                    <textarea name="description" id="edit_description" class="form-control" rows="5" required></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; align-items: center;">
                    <div class="form-group" id="edit_display_order_group" style="margin-bottom: 0;">
                        <label class="form-label" for="edit_display_order">Display Order</label>
                        <input type="number" name="display_order" id="edit_display_order" class="form-control">
                    </div>

                    <div class="form-group" style="margin-bottom: 0; padding-top: 24px;">
                        <label class="form-check">
                            <input type="checkbox" name="is_active" id="edit_is_active" value="1">
                            <span>Active / Display on Website</span>
                        </label>
                    </div>
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
function syncAddModalFields() {
    const cat = document.getElementById('add_category').value;
    const nameGroup = document.getElementById('add_faculty_name_group');
    const nameInput = document.getElementById('add_faculty_name');
    const descLabel = document.getElementById('add_description_label');
    const descText = document.getElementById('add_description');
    const orderGroup = document.getElementById('add_display_order_group');

    if (cat === 'conferences') {
        nameGroup.style.display = 'none';
        nameInput.required = false;
        nameInput.value = '';
        if (orderGroup) orderGroup.style.display = 'none';
        descLabel.innerHTML = 'Conferences Attended/Chaired by Faculty <span class="required">*</span>';
        descText.placeholder = 'Enter full conference detail (e.g. Dr. B. J. Shah, Professor in Applied Mechanics, attended the International conclave...)';
    } else if (cat === 'trainings') {
        nameGroup.style.display = 'block';
        nameInput.required = true;
        if (orderGroup) orderGroup.style.display = 'block';
        descLabel.innerHTML = 'Trainings Attended by Faculty <span class="required">*</span>';
        descText.placeholder = 'Enter training topic, dates, or program details (e.g. Effective Classroom Communication)';
    } else if (cat === 'expert_lectures') {
        nameGroup.style.display = 'block';
        nameInput.required = true;
        if (orderGroup) orderGroup.style.display = 'block';
        descLabel.innerHTML = 'Expert Lectures Delivered by Faculty <span class="required">*</span>';
        descText.placeholder = 'Enter lecture topic and details (e.g. Hydroxygen as additive in two wheeler)';
    }
}

function syncEditModalFields() {
    const cat = document.getElementById('edit_category').value;
    const nameGroup = document.getElementById('edit_faculty_name_group');
    const nameInput = document.getElementById('edit_faculty_name');
    const descLabel = document.getElementById('edit_description_label');
    const orderGroup = document.getElementById('edit_display_order_group');

    if (cat === 'conferences') {
        nameGroup.style.display = 'none';
        nameInput.required = false;
        if (orderGroup) orderGroup.style.display = 'none';
        descLabel.innerHTML = 'Conferences Attended/Chaired by Faculty <span class="required">*</span>';
    } else if (cat === 'trainings') {
        nameGroup.style.display = 'block';
        nameInput.required = true;
        if (orderGroup) orderGroup.style.display = 'block';
        descLabel.innerHTML = 'Trainings Attended by Faculty <span class="required">*</span>';
    } else if (cat === 'expert_lectures') {
        nameGroup.style.display = 'block';
        nameInput.required = true;
        if (orderGroup) orderGroup.style.display = 'block';
        descLabel.innerHTML = 'Expert Lectures Delivered by Faculty <span class="required">*</span>';
    }
}

function openAddModalFor(category) {
    if (category) {
        document.getElementById('add_category').value = category;
    }
    syncAddModalFields();
    openModal('addActivityModal');
}

function openEditActivityModal(data) {
    document.getElementById('edit_id').value = data.id || '';
    document.getElementById('edit_category').value = data.category || 'conferences';
    document.getElementById('edit_faculty_name').value = data.faculty_name || '';
    document.getElementById('edit_description').value = data.description || '';
    document.getElementById('edit_display_order').value = data.display_order || '0';
    document.getElementById('edit_is_active').checked = (parseInt(data.is_active) === 1);
    
    syncEditModalFields();
    openModal('editActivityModal');
}

document.addEventListener('DOMContentLoaded', function() {
    syncAddModalFields();
});
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
