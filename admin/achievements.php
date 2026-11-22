<?php
/**
 * GEC MODASA - Admin Management for Achievements
 * Supports Student Achievements, Faculty Achievements, and Institute Achievements
 */
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
require_once __DIR__ . '/../includes/cell_activities_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
if ($pdo) {
    initCellActivitiesTable($pdo);
}

$categories = [
    'student_achievements' => [
        'name' => 'Student Achievements',
        'badge' => 'Students',
        'cell' => 'Student Accolades & Hackathons',
        'live_url' => '../activities/student-achievements.php'
    ],
    'faculty_achievements' => [
        'name' => 'Faculty Achievements',
        'badge' => 'Faculty',
        'cell' => 'Faculty Research & Awards',
        'live_url' => '../activities/faculty-achievements.php'
    ],
    'institute_achievements' => [
        'name' => 'Institute Achievements',
        'badge' => 'Institute',
        'cell' => 'Institutional Accreditations & Honours',
        'live_url' => '../activities/institute-achievements.php'
    ],
    'patents' => [
        'name' => 'Patents & IPR',
        'badge' => 'Patents',
        'cell' => 'Intellectual Property & Patents',
        'live_url' => '../activities/patents.php'
    ],
    'technopreneur_club' => [
        'name' => 'Technopreneur Club',
        'badge' => 'Club',
        'cell' => 'Student Technical & Entrepreneurship Club',
        'live_url' => '../activities/technopreneur-club.php'
    ]
];

$selectedCategory = strtolower(trim($_GET['category'] ?? 'all'));
if ($selectedCategory !== 'all' && !isset($categories[$selectedCategory])) {
    $selectedCategory = 'all';
}

$editItem = null;

// Handle Form Submissions (Add / Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: achievements.php' . ($selectedCategory !== 'all' ? '?category=' . $selectedCategory : ''));
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $category = strtolower(trim($_POST['category'] ?? 'student_achievements'));
        $title = trim($_POST['title'] ?? '');
        $activity_date = !empty($_POST['activity_date']) ? $_POST['activity_date'] : null;
        $description = trim($_POST['description'] ?? '');
        $external_url = trim($_POST['external_url'] ?? '#');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!isset($categories[$category])) {
            $category = 'student_achievements';
        }

        if (empty($title)) {
            setFlashMessage('danger', 'Achievement Title cannot be empty.');
            header("Location: achievements.php?category={$category}");
            exit;
        }

        // Handle Primary Image Upload
        $photo_url = '';
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = handleImageUpload('image_file', 'cell_activities');
            if ($uploadResult['success']) {
                $photo_url = $uploadResult['path'];
            } else {
                setFlashMessage('danger', 'Image upload error: ' . $uploadResult['error']);
                header("Location: achievements.php?category={$category}");
                exit;
            }
        } elseif (!empty($_POST['image_url'])) {
            $photo_url = trim($_POST['image_url']);
        }

        // Handle Multiple Gallery Images
        $galleryList = handleMultipleImageUpload('gallery_files', 'cell_activities');
        if (!empty($_POST['gallery_urls'])) {
            $urlLines = preg_split('/[\r\n]+/', $_POST['gallery_urls']);
            foreach ($urlLines as $line) {
                $line = trim($line);
                if (!empty($line)) {
                    $galleryList[] = $line;
                }
            }
        }
        $gallery_images = !empty($galleryList) ? json_encode(array_values(array_unique($galleryList))) : null;

        try {
            $stmt = $pdo->prepare("
                INSERT INTO cell_activities 
                (category, title, activity_date, image_url, gallery_images, description, external_url, display_order, is_active)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$category, $title, $activity_date, $photo_url, $gallery_images, $description, $external_url, $display_order, $is_active]);
            setFlashMessage('success', "Achievement '{$title}' added successfully!");
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }

        header("Location: achievements.php?category={$category}");
        exit;

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $category = strtolower(trim($_POST['category'] ?? 'student_achievements'));
        $title = trim($_POST['title'] ?? '');
        $activity_date = !empty($_POST['activity_date']) ? $_POST['activity_date'] : null;
        $description = trim($_POST['description'] ?? '');
        $external_url = trim($_POST['external_url'] ?? '#');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!isset($categories[$category])) {
            $category = 'student_achievements';
        }

        if (empty($title) || $id <= 0) {
            setFlashMessage('danger', 'Invalid achievement ID or title.');
            header("Location: achievements.php?category={$category}");
            exit;
        }

        // Fetch existing record
        $stmtOld = $pdo->prepare("SELECT * FROM cell_activities WHERE id = ?");
        $stmtOld->execute([$id]);
        $existing = $stmtOld->fetch(PDO::FETCH_ASSOC);

        $photo_url = $existing['image_url'] ?? '';
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = handleImageUpload('image_file', 'cell_activities');
            if ($uploadResult['success']) {
                $photo_url = $uploadResult['path'];
            }
        } elseif (!empty($_POST['image_url'])) {
            $photo_url = trim($_POST['image_url']);
        }

        // Existing gallery images
        $existingGallery = [];
        if (!empty($existing['gallery_images'])) {
            $decoded = json_decode($existing['gallery_images'], true);
            if (is_array($decoded)) {
                $existingGallery = $decoded;
            }
        }

        // Retain selected existing images
        $keptGallery = $_POST['keep_gallery'] ?? [];
        $finalGallery = array_values(array_intersect($existingGallery, $keptGallery));

        // Add newly uploaded gallery images
        $newUploaded = handleMultipleImageUpload('gallery_files', 'cell_activities');
        foreach ($newUploaded as $nu) {
            $finalGallery[] = $nu;
        }

        // Add extra gallery URLs
        if (!empty($_POST['gallery_urls'])) {
            $urlLines = preg_split('/[\r\n]+/', $_POST['gallery_urls']);
            foreach ($urlLines as $line) {
                $line = trim($line);
                if (!empty($line) && !in_array($line, $finalGallery)) {
                    $finalGallery[] = $line;
                }
            }
        }
        $gallery_images = !empty($finalGallery) ? json_encode(array_values(array_unique($finalGallery))) : null;

        try {
            $stmt = $pdo->prepare("
                UPDATE cell_activities 
                SET category = ?, title = ?, activity_date = ?, image_url = ?, gallery_images = ?, description = ?, external_url = ?, display_order = ?, is_active = ?
                WHERE id = ?
            ");
            $stmt->execute([$category, $title, $activity_date, $photo_url, $gallery_images, $description, $external_url, $display_order, $is_active, $id]);
            setFlashMessage('success', "Achievement updated successfully!");
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }

        header("Location: achievements.php?category={$category}");
        exit;
    }
}

// Handle Delete Request
if (isset($_GET['delete'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: achievements.php');
        exit;
    }

    $id = (int)$_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM cell_activities WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Achievement deleted successfully.');
    } catch (Exception $e) {
        setFlashMessage('danger', 'Delete error: ' . $e->getMessage());
    }

    header('Location: achievements.php' . ($selectedCategory !== 'all' ? '?category=' . $selectedCategory : ''));
    exit;
}

// Handle Status Toggle (Active / Inactive)
if (isset($_GET['toggle'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: achievements.php');
        exit;
    }

    $id = (int)$_GET['toggle'];
    try {
        $stmt = $pdo->prepare("UPDATE cell_activities SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Status toggled successfully.');
    } catch (Exception $e) {
        setFlashMessage('danger', 'Toggle error: ' . $e->getMessage());
    }

    header('Location: achievements.php' . ($selectedCategory !== 'all' ? '?category=' . $selectedCategory : ''));
    exit;
}

// Fetch item for edit mode if requested
if (isset($_GET['edit']) && $pdo) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM cell_activities WHERE id = ?");
    $stmt->execute([$editId]);
    $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch all achievements
$activitiesList = [];
$achievementKeys = array_keys($categories);

if ($pdo) {
    try {
        if ($selectedCategory === 'all') {
            $placeholders = implode(',', array_fill(0, count($achievementKeys), '?'));
            $stmt = $pdo->prepare("
                SELECT * FROM cell_activities 
                WHERE category IN ($placeholders)
                ORDER BY activity_date DESC, id DESC
            ");
            $stmt->execute($achievementKeys);
        } else {
            $stmt = $pdo->prepare("
                SELECT * FROM cell_activities 
                WHERE category = ? 
                ORDER BY activity_date DESC, id DESC
            ");
            $stmt->execute([$selectedCategory]);
        }
        $activitiesList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Achievements fetch error: " . $e->getMessage());
    }
}

// Fallback to static seed data if database has no rows
if (empty($activitiesList)) {
    $allFallbacks = getCellActivitiesFallbackData();
    if ($selectedCategory === 'all') {
        foreach ($achievementKeys as $catKey) {
            if (!empty($allFallbacks[$catKey])) {
                $activitiesList = array_merge($activitiesList, $allFallbacks[$catKey]);
            }
        }
    } else {
        $activitiesList = $allFallbacks[$selectedCategory] ?? [];
    }
}

$current_page = 'achievements';
$page_title = 'Manage Achievements';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top" style="flex-wrap: wrap; gap: 14px;">
        <div class="card-title-group">
            <h2 class="card-title">Manage Achievements</h2>
            <p style="font-size: 0.85rem; color: #64748b; margin: 4px 0 0;">
                Publish and manage accolades, awards, hackathon triumphs, and recognitions across Student, Faculty, and Institute categories.
            </p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; margin-left: auto;">
            <?php if ($selectedCategory !== 'all' && isset($categories[$selectedCategory])): ?>
                <a href="<?= htmlspecialchars($categories[$selectedCategory]['live_url']) ?>" target="_blank" class="btn btn-secondary" style="font-size: 0.86rem; padding: 7px 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fas fa-external-link-alt"></i> View Live Page
                </a>
            <?php endif; ?>
            <button type="button" class="btn-add-new" onclick="openModal('addAchievementModal')">
                + Add New Achievement
            </button>
        </div>
    </div>

    <!-- Category Selector Pill Tabs -->
    <div style="display: flex; flex-wrap: wrap; gap: 8px; margin: 18px 0; border-bottom: 1px solid #e2e8f0; padding-bottom: 14px;">
        <a href="achievements.php?category=all" 
           class="btn btn-sm <?= ($selectedCategory === 'all') ? 'btn-primary' : 'btn-light' ?>" 
           style="border-radius: 9999px; padding: 6px 14px; font-size: 0.82rem; font-weight: 600; text-decoration: none;">
            All Achievements
        </a>
        <?php foreach ($categories as $catKey => $catMeta): ?>
            <a href="achievements.php?category=<?= $catKey ?>" 
               class="btn btn-sm <?= ($selectedCategory === $catKey) ? 'btn-primary' : 'btn-light' ?>" 
               style="border-radius: 9999px; padding: 6px 14px; font-size: 0.82rem; font-weight: 600; text-decoration: none;">
                <?= htmlspecialchars($catMeta['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="card-filters" style="margin-left: auto;">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search achievements..." data-table-search="achievementsTable">
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="achievementsTable">
            <thead>
                <tr>
                    <th style="width: 120px;">Date</th>
                    <th style="width: 130px;">Category</th>
                    <th style="width: 80px;">Cover</th>
                    <th>Achievement Title &amp; Details</th>
                    <th style="width: 100px;">Status</th>
                    <th style="width: 120px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($activitiesList)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 36px; color: #94a3b8;">
                            No achievements found for this category. Click <strong>+ Add New Achievement</strong> to publish the first record.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($activitiesList as $row):
                        $cat = strtolower(trim($row['category'] ?? 'student_achievements'));
                        $catBadge = $categories[$cat]['badge'] ?? strtoupper($cat);
                        $isActive = !isset($row['is_active']) || $row['is_active'] == 1;
                        $photoSrc = !empty($row['image_url']) 
                            ? ((strpos($row['image_url'], 'http') === 0) ? htmlspecialchars($row['image_url']) : htmlspecialchars('../' . ltrim($row['image_url'], '/'))) 
                            : 'https://via.placeholder.com/80x50?text=Accolade';
                    ?>
                        <tr data-status="<?= $isActive ? 'active' : 'inactive' ?>">
                            <td style="font-weight: 600; color: #ff8800; font-size: 13px; white-space: nowrap;">
                                <i class="far fa-calendar-alt" style="margin-right: 4px;"></i>
                                <?= !empty($row['activity_date']) ? date('d M Y', strtotime($row['activity_date'])) : 'Honour' ?>
                            </td>
                            <td>
                                <span class="badge" style="background: #e2e8f0; color: #0f172a; font-weight: 700; font-size: 0.74rem; padding: 4px 8px; border-radius: 4px;">
                                    <?= htmlspecialchars($catBadge) ?>
                                </span>
                            </td>
                            <td>
                                <div style="position: relative; display: inline-block;">
                                    <img src="<?= $photoSrc ?>" alt="Cover" style="width: 60px; height: 42px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;" onerror="this.src='https://via.placeholder.com/60x42?text=Achievement';">
                                    <?php 
                                        $gal = !empty($row['gallery_images']) ? (is_array($row['gallery_images']) ? $row['gallery_images'] : json_decode($row['gallery_images'], true)) : [];
                                        $extraCount = is_array($gal) ? count($gal) : 0;
                                        if ($extraCount > 0): 
                                    ?>
                                        <span style="position: absolute; bottom: 2px; right: 2px; background: rgba(15,23,42,0.85); color: #fff; font-size: 10px; font-weight: 700; padding: 1px 4px; border-radius: 3px;" title="<?= $extraCount ?> gallery photos">
                                            +<?= $extraCount ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">
                                    <?= htmlspecialchars($row['title']) ?>
                                </div>
                                <div style="color: #64748b; font-size: 13px; line-height: 1.4; max-width: 480px;">
                                    <?= htmlspecialchars(mb_strimwidth($row['description'] ?? '', 0, 140, '...')) ?>
                                </div>
                            </td>
                            <td>
                                <a href="achievements.php?toggle=<?= $row['id'] ?>&category=<?= $selectedCategory ?>" class="badge <?= $isActive ? 'badge-success' : 'badge-danger' ?>" style="text-decoration: none;" title="Click to toggle status">
                                    <?= $isActive ? 'Active' : 'Inactive' ?>
                                </a>
                            </td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="achievements.php?edit=<?= $row['id'] ?>&category=<?= $selectedCategory ?>" class="btn-action btn-edit" title="Edit Achievement">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="achievements.php?delete=<?= $row['id'] ?>&category=<?= $selectedCategory ?>" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to permanently delete this achievement?');" title="Delete Achievement">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ==========================================================================
     ADD ACHIEVEMENT MODAL
     ========================================================================== -->
<div class="admin-modal-backdrop" id="addAchievementModal" style="display: none;">
    <div class="admin-modal-dialog" style="max-width: 650px;">
        <div class="admin-modal-header">
            <h3>+ Add New Achievement</h3>
            <button type="button" class="admin-modal-close" onclick="closeModal('addAchievementModal')">&times;</button>
        </div>
        <form action="achievements.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="admin-modal-body" style="padding: 20px;">
                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Achievement Category <span style="color:red;">*</span></label>
                    <select name="category" class="form-control" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        <?php foreach ($categories as $catKey => $catMeta): ?>
                            <option value="<?= $catKey ?>" <?= ($selectedCategory === $catKey) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($catMeta['name']) ?> (<?= htmlspecialchars($catMeta['cell']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Achievement Title <span style="color:red;">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Smart India Hackathon 1st Prize Winner" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                </div>

                <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Date / Year</label>
                        <input type="date" name="activity_date" class="form-control" value="<?= date('Y-m-d') ?>" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Certificate / External URL</label>
                        <input type="text" name="external_url" class="form-control" placeholder="https://..." value="#" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Primary Cover Image</label>
                    <input type="file" name="image_file" class="form-control" accept="image/*" style="width:100%; padding:6px 12px; border-radius:6px; border:1px solid #d1d5db;">
                    <small style="color: #64748b; display: block; margin-top: 4px;">Or enter primary image URL:</small>
                    <input type="text" name="image_url" class="form-control" placeholder="images/hero_campus_1.jpg" style="width:100%; padding:7px 12px; border-radius:6px; border:1px solid #d1d5db; margin-top: 4px;">
                </div>

                <div class="form-group" style="margin-bottom: 16px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 14px;">
                    <label style="display:flex; align-items:center; gap:8px; font-weight:700; color:#0f172a; margin-bottom:4px;">
                        <i class="far fa-images" style="color:#ff8800;"></i> Additional Gallery Photos (For Auto Slider)
                    </label>
                    <p style="font-size:12px; color:#64748b; margin:0 0 8px;">Select multiple event photos (Hold Ctrl / Shift to select multiple images). They will slide smoothly in the detail popup!</p>
                    <input type="file" name="gallery_files[]" class="form-control" accept="image/*" multiple style="width:100%; padding:6px 12px; border-radius:6px; border:1px solid #d1d5db; background:#fff;">
                    <small style="color: #64748b; display: block; margin-top: 6px;">Or enter additional image URLs (one per line):</small>
                    <textarea name="gallery_urls" rows="2" class="form-control" placeholder="https://...&#10;https://..." style="width:100%; padding:7px 12px; border-radius:6px; border:1px solid #d1d5db; margin-top: 4px; font-size:12px; background:#fff;"></textarea>
                </div>

                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Description / Award Highlights</label>
                    <textarea name="description" rows="4" class="form-control" placeholder="Enter detailed description of the achievement..." style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;"></textarea>
                </div>

                <div class="form-group" style="margin-bottom: 8px;">
                    <label style="display:inline-flex; align-items:center; gap:8px; cursor:pointer; font-weight: 600;">
                        <input type="checkbox" name="is_active" value="1" checked style="width:16px; height:16px;">
                        Publish immediately (Active)
                    </label>
                </div>
            </div>
            <div class="admin-modal-footer" style="padding: 14px 20px; display: flex; justify-content: flex-end; gap: 10px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addAchievementModal')">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: #ff8800; border-color: #ff8800; color: #fff; font-weight: 600;">Save Achievement</button>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================================================
     EDIT ACHIEVEMENT MODAL
     ========================================================================== -->
<?php if ($editItem): ?>
<div class="admin-modal-backdrop" id="editAchievementModal" style="display: flex;">
    <div class="admin-modal-dialog" style="max-width: 650px;">
        <div class="admin-modal-header">
            <h3>Edit Achievement #<?= $editItem['id'] ?></h3>
            <a href="achievements.php?category=<?= $selectedCategory ?>" class="admin-modal-close" style="text-decoration: none;">&times;</a>
        </div>
        <form action="achievements.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <div class="admin-modal-body" style="padding: 20px;">
                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Achievement Category <span style="color:red;">*</span></label>
                    <select name="category" class="form-control" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        <?php foreach ($categories as $catKey => $catMeta): ?>
                            <option value="<?= $catKey ?>" <?= ($editItem['category'] === $catKey) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($catMeta['name']) ?> (<?= htmlspecialchars($catMeta['cell']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Achievement Title <span style="color:red;">*</span></label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($editItem['title'] ?? '') ?>" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                </div>

                <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Date / Year</label>
                        <input type="date" name="activity_date" class="form-control" value="<?= htmlspecialchars($editItem['activity_date'] ?? '') ?>" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Certificate / External URL</label>
                        <input type="text" name="external_url" class="form-control" value="<?= htmlspecialchars($editItem['external_url'] ?? '#') ?>" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Change Primary Cover Image</label>
                    <?php if (!empty($editItem['image_url'])): ?>
                        <div style="margin-bottom: 8px;">
                            <img src="<?= (strpos($editItem['image_url'], 'http') === 0) ? htmlspecialchars($editItem['image_url']) : htmlspecialchars('../' . ltrim($editItem['image_url'], '/')) ?>" alt="Current Cover" style="width: 80px; height: 50px; border-radius: 4px; object-fit: cover; border: 1px solid #ddd;">
                            <span style="font-size:12px; color:#64748b; margin-left:8px;">Current Primary Image</span>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image_file" class="form-control" accept="image/*" style="width:100%; padding:6px 12px; border-radius:6px; border:1px solid #d1d5db;">
                    <input type="text" name="image_url" class="form-control" value="<?= htmlspecialchars($editItem['image_url'] ?? '') ?>" placeholder="Image URL / path" style="width:100%; padding:7px 12px; border-radius:6px; border:1px solid #d1d5db; margin-top: 4px;">
                </div>

                <div class="form-group" style="margin-bottom: 16px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 14px;">
                    <label style="display:flex; align-items:center; gap:8px; font-weight:700; color:#0f172a; margin-bottom:4px;">
                        <i class="far fa-images" style="color:#ff8800;"></i> Event Gallery Photos (For Auto Slider)
                    </label>
                    <?php 
                    $existingGallery = [];
                    if (!empty($editItem['gallery_images'])) {
                        $dec = json_decode($editItem['gallery_images'], true);
                        if (is_array($dec)) $existingGallery = $dec;
                    }
                    if (!empty($existingGallery)): 
                    ?>
                        <p style="font-size:12px; color:#334155; margin:0 0 6px; font-weight:600;">Currently Saved Photos (Uncheck to remove):</p>
                        <div style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                            <?php foreach ($existingGallery as $gUrl): 
                                $src = (strpos($gUrl, 'http') === 0) ? htmlspecialchars($gUrl) : htmlspecialchars('../' . ltrim($gUrl, '/'));
                            ?>
                                <label style="display:flex; flex-direction:column; align-items:center; gap:4px; cursor:pointer;">
                                    <img src="<?= $src ?>" style="width:65px; height:45px; object-fit:cover; border-radius:4px; border:1px solid #cbd5e1;">
                                    <span style="font-size:11px; display:inline-flex; align-items:center; gap:3px;">
                                        <input type="checkbox" name="keep_gallery[]" value="<?= htmlspecialchars($gUrl) ?>" checked> Keep
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <p style="font-size:12px; color:#64748b; margin:0 0 6px;">Add more photos from your device:</p>
                    <input type="file" name="gallery_files[]" class="form-control" accept="image/*" multiple style="width:100%; padding:6px 12px; border-radius:6px; border:1px solid #d1d5db; background:#fff;">
                    <small style="color: #64748b; display: block; margin-top: 6px;">Or add more image URLs (one per line):</small>
                    <textarea name="gallery_urls" rows="2" class="form-control" placeholder="https://...&#10;https://..." style="width:100%; padding:7px 12px; border-radius:6px; border:1px solid #d1d5db; margin-top: 4px; font-size:12px; background:#fff;"></textarea>
                </div>

                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Description / Award Highlights</label>
                    <textarea name="description" rows="4" class="form-control" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;"><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
                </div>

                <div class="form-group" style="margin-bottom: 8px;">
                    <label style="display:inline-flex; align-items:center; gap:8px; cursor:pointer; font-weight: 600;">
                        <input type="checkbox" name="is_active" value="1" <?= (!isset($editItem['is_active']) || $editItem['is_active'] == 1) ? 'checked' : '' ?> style="width:16px; height:16px;">
                        Active / Published
                    </label>
                </div>
            </div>
            <div class="admin-modal-footer" style="padding: 14px 20px; display: flex; justify-content: flex-end; gap: 10px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                <a href="achievements.php?category=<?= $selectedCategory ?>" class="btn btn-secondary" style="text-decoration:none;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="background: #ff8800; border-color: #ff8800; color: #fff; font-weight: 600;">Update Achievement</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.style.display = 'flex';
}
function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.style.display = 'none';
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
