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

$selectedCategory = strtolower(trim($_GET['category'] ?? 'student_achievements'));
if ($selectedCategory === 'all' || !isset($categories[$selectedCategory])) {
    $selectedCategory = 'student_achievements';
}

$clubSection = strtolower(trim($_GET['section'] ?? 'activities'));
if (!in_array($clubSection, ['activities', 'team'])) {
    $clubSection = 'activities';
}
$teamFilter = trim($_GET['group'] ?? 'all');
$editTeamMember = null;
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

        // Patent-specific metadata
        $patent_category = trim($_POST['patent_category'] ?? '');
        $patent_status = trim($_POST['patent_status'] ?? '');
        $faculty_name = trim($_POST['faculty_name'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $pub_year = !empty($_POST['pub_year']) ? (int)$_POST['pub_year'] : (!empty($activity_date) ? (int)date('Y', strtotime($activity_date)) : 2026);
        if ($category === 'patents' && empty($activity_date) && !empty($pub_year)) {
            $activity_date = "{$pub_year}-01-01";
        }

        if (!isset($categories[$category])) {
            $category = 'student_achievements';
        }

        if (empty($title)) {
            setFlashMessage('danger', 'Title cannot be empty.');
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
        $gallery_images = !empty($galleryList) ? json_encode(array_values(array_unique($galleryList))) : null;

        try {
            $stmt = $pdo->prepare("
                INSERT INTO cell_activities 
                (category, title, activity_date, image_url, gallery_images, description, external_url, display_order, is_active, patent_category, patent_status, faculty_name, department, pub_year)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$category, $title, $activity_date, $photo_url, $gallery_images, $description, $external_url, $display_order, $is_active, $patent_category, $patent_status, $faculty_name, $department, $pub_year]);
            gecmCacheInvalidate('cell_activities_');
            setFlashMessage('success', "Record '{$title}' added successfully!");
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

        // Patent-specific metadata
        $patent_category = trim($_POST['patent_category'] ?? '');
        $patent_status = trim($_POST['patent_status'] ?? '');
        $faculty_name = trim($_POST['faculty_name'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $pub_year = !empty($_POST['pub_year']) ? (int)$_POST['pub_year'] : (!empty($activity_date) ? (int)date('Y', strtotime($activity_date)) : null);
        if ($category === 'patents' && empty($activity_date) && !empty($pub_year)) {
            $activity_date = "{$pub_year}-01-01";
        }

        if (!isset($categories[$category])) {
            $category = 'student_achievements';
        }

        if (empty($title) || $id <= 0) {
            setFlashMessage('danger', 'Invalid record ID or title.');
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
            $decoded = is_array($existing['gallery_images']) ? $existing['gallery_images'] : json_decode($existing['gallery_images'], true);
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

        $gallery_images = !empty($finalGallery) ? json_encode(array_values(array_unique($finalGallery))) : null;

        try {
            $stmtCheck = $pdo->prepare("SELECT id FROM cell_activities WHERE id = ?");
            $stmtCheck->execute([$id]);
            $exists = $stmtCheck->fetchColumn();

            if ($exists) {
                $stmt = $pdo->prepare("
                    UPDATE cell_activities 
                    SET category = ?, title = ?, activity_date = ?, image_url = ?, gallery_images = ?, description = ?, external_url = ?, display_order = ?, is_active = ?,
                        patent_category = ?, patent_status = ?, faculty_name = ?, department = ?, pub_year = ?
                    WHERE id = ?
                ");
                $stmt->execute([$category, $title, $activity_date, $photo_url, $gallery_images, $description, $external_url, $display_order, $is_active, $patent_category, $patent_status, $faculty_name, $department, $pub_year, $id]);
            } else {
                $stmt = $pdo->prepare("
                    INSERT INTO cell_activities 
                    (category, title, activity_date, image_url, gallery_images, description, external_url, display_order, is_active, patent_category, patent_status, faculty_name, department, pub_year)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$category, $title, $activity_date, $photo_url, $gallery_images, $description, $external_url, $display_order, $is_active, $patent_category, $patent_status, $faculty_name, $department, $pub_year]);
            }
            gecmCacheInvalidate('cell_activities_');
            setFlashMessage('success', "Record updated successfully!");
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }

        header("Location: achievements.php?category={$category}");
        exit;
    } elseif ($action === 'add_team_member') {
        $group_type = trim($_POST['group_type'] ?? 'faculty_coordinator');
        $name = trim($_POST['name'] ?? '');
        $designation_or_role = trim($_POST['designation_or_role'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name)) {
            setFlashMessage('danger', 'Member name cannot be empty.');
            header("Location: achievements.php?category=technopreneur_club&section=team");
            exit;
        }

        try {
            initTechnopreneurTeamTable($pdo);
            $stmt = $pdo->prepare("
                INSERT INTO technopreneur_team (group_type, name, designation_or_role, department, display_order, is_active)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$group_type, $name, $designation_or_role, $department, $display_order, $is_active]);
            gecmCacheInvalidate('technopreneur_team_');
            setFlashMessage('success', "Member '{$name}' added to team successfully!");
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }

        header("Location: achievements.php?category=technopreneur_club&section=team");
        exit;

    } elseif ($action === 'edit_team_member') {
        $id = (int)($_POST['id'] ?? 0);
        $group_type = trim($_POST['group_type'] ?? 'faculty_coordinator');
        $name = trim($_POST['name'] ?? '');
        $designation_or_role = trim($_POST['designation_or_role'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name) || $id <= 0) {
            setFlashMessage('danger', 'Invalid member details or name empty.');
            header("Location: achievements.php?category=technopreneur_club&section=team");
            exit;
        }

        try {
            initTechnopreneurTeamTable($pdo);
            $stmt = $pdo->prepare("
                UPDATE technopreneur_team 
                SET group_type = ?, name = ?, designation_or_role = ?, department = ?, display_order = ?, is_active = ?
                WHERE id = ?
            ");
            $stmt->execute([$group_type, $name, $designation_or_role, $department, $display_order, $is_active, $id]);
            gecmCacheInvalidate('technopreneur_team_');
            setFlashMessage('success', "Member '{$name}' updated successfully!");
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }

        header("Location: achievements.php?category=technopreneur_club&section=team");
        exit;
    }
}

// Handle Delete Technopreneur Team Member
if (isset($_GET['delete_team_member'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: achievements.php?category=technopreneur_club&section=team');
        exit;
    }

    $id = (int)$_GET['delete_team_member'];
    try {
        initTechnopreneurTeamTable($pdo);
        $stmt = $pdo->prepare("DELETE FROM technopreneur_team WHERE id = ?");
        $stmt->execute([$id]);
        gecmCacheInvalidate('technopreneur_team_');
        setFlashMessage('success', 'Team member deleted successfully.');
    } catch (Exception $e) {
        setFlashMessage('danger', 'Delete error: ' . $e->getMessage());
    }

    header('Location: achievements.php?category=technopreneur_club&section=team');
    exit;
}

// Handle Toggle Technopreneur Team Member Active Status
if (isset($_GET['toggle_team_member'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: achievements.php?category=technopreneur_club&section=team');
        exit;
    }

    $id = (int)$_GET['toggle_team_member'];
    try {
        initTechnopreneurTeamTable($pdo);
        $stmt = $pdo->prepare("UPDATE technopreneur_team SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        gecmCacheInvalidate('technopreneur_team_');
        setFlashMessage('success', 'Member status updated successfully.');
    } catch (Exception $e) {
        setFlashMessage('danger', 'Toggle error: ' . $e->getMessage());
    }

    header('Location: achievements.php?category=technopreneur_club&section=team');
    exit;
}

// Fetch team member for edit modal
if (isset($_GET['edit_team'])) {
    $editTeamId = (int)$_GET['edit_team'];
    if ($editTeamId > 0 && $pdo) {
        initTechnopreneurTeamTable($pdo);
        $stmt = $pdo->prepare("SELECT * FROM technopreneur_team WHERE id = ?");
        $stmt->execute([$editTeamId]);
        $editTeamMember = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($editTeamMember) {
            $selectedCategory = 'technopreneur_club';
            $clubSection = 'team';
        }
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
        gecmCacheInvalidate('cell_activities_');
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
        gecmCacheInvalidate('cell_activities_');
        setFlashMessage('success', 'Status toggled successfully.');
    } catch (Exception $e) {
        setFlashMessage('danger', 'Toggle error: ' . $e->getMessage());
    }

    header('Location: achievements.php' . ($selectedCategory !== 'all' ? '?category=' . $selectedCategory : ''));
    exit;
}

// Fetch item for edit mode if requested
if (isset($_GET['edit'])) {
    $editId = (int)$_GET['edit'];
    if ($editId > 0) {
        if ($pdo) {
            $stmt = $pdo->prepare("SELECT * FROM cell_activities WHERE id = ?");
            $stmt->execute([$editId]);
            $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($editItem) {
                $selectedCategory = $editItem['category'] ?? $selectedCategory;
            }
        }
        // Fallback lookup if not yet seeded into DB
        if (!$editItem) {
            $allFallbacks = getCellActivitiesFallbackData();
            foreach ($allFallbacks as $catRows) {
                foreach ($catRows as $r) {
                    if (($r['id'] ?? 0) == $editId) {
                        $editItem = $r;
                        $selectedCategory = $r['category'] ?? $selectedCategory;
                        break 2;
                    }
                }
            }
        }
    }
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
            $orderClause = ($selectedCategory === 'patents') ? "display_order ASC, id ASC" : "activity_date DESC, id DESC";
            $stmt = $pdo->prepare("
                SELECT * FROM cell_activities 
                WHERE category = ? 
                ORDER BY {$orderClause}
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

// Fetch Technopreneur Team counts and members if in club category
$teamMembersList = [];
$teamCounts = [
    'all' => 0,
    'convener' => 0,
    'faculty_coordinator' => 0,
    'student_leadership' => 0,
    'advisory_board' => 0
];

if ($selectedCategory === 'technopreneur_club') {
    if ($pdo) {
        initTechnopreneurTeamTable($pdo);
        try {
            $allRows = $pdo->query("SELECT * FROM technopreneur_team ORDER BY display_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($allRows as $r) {
                $teamCounts['all']++;
                $grp = $r['group_type'] ?? '';
                if (isset($teamCounts[$grp])) {
                    $teamCounts[$grp]++;
                }
            }
            if ($clubSection === 'team') {
                if ($teamFilter !== 'all' && in_array($teamFilter, ['convener', 'faculty_coordinator', 'student_leadership', 'advisory_board'])) {
                    $teamMembersList = array_values(array_filter($allRows, function($m) use ($teamFilter) {
                        return ($m['group_type'] === $teamFilter);
                    }));
                } else {
                    $teamMembersList = $allRows;
                }
            }
        } catch (Exception $e) {
            error_log("Error fetching team: " . $e->getMessage());
        }
    }
    if (empty($teamMembersList) && $clubSection === 'team') {
        $teamMembersList = getTechnopreneurTeam($teamFilter !== 'all' ? $teamFilter : null, $pdo);
    }
}

$current_page = 'achievements';
$page_title = 'Manage Achievements';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top" style="flex-wrap: wrap; gap: 14px;">
        <div class="card-title-group">
            <?php if ($selectedCategory === 'technopreneur_club' && $clubSection === 'team'): ?>
                <h2 class="card-title">Manage Technopreneur Club Team &amp; Mentors</h2>
                <p style="font-size: 0.85rem; color: #64748b; margin: 4px 0 0;">
                    Manage Convener, Department Faculty Coordinators, Student Leadership, and Advisory Board. All changes reflect live on the Technopreneur Club page.
                </p>
            <?php elseif ($selectedCategory === 'patents'): ?>
                <h2 class="card-title">Manage Patents &amp; IPR</h2>
                <p style="font-size: 0.85rem; color: #64748b; margin: 4px 0 0;">
                    Publish, edit, and organize patents granted and published by GEC Modasa faculty and student researchers.
                </p>
            <?php else: ?>
                <h2 class="card-title">Manage Achievements</h2>
                <p style="font-size: 0.85rem; color: #64748b; margin: 4px 0 0;">
                    Publish and manage accolades, awards, hackathon triumphs, and recognitions across Student, Faculty, and Institute categories.
                </p>
            <?php endif; ?>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; margin-left: auto;">
            <?php if ($selectedCategory !== 'all' && isset($categories[$selectedCategory])): ?>
                <a href="<?= htmlspecialchars($categories[$selectedCategory]['live_url']) ?>" target="_blank" class="btn btn-secondary" style="font-size: 0.86rem; padding: 7px 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fas fa-external-link-alt"></i> View Live Page
                </a>
            <?php endif; ?>

            <?php if ($selectedCategory === 'technopreneur_club' && $clubSection === 'team'): ?>
                <button type="button" class="btn-add-new" onclick="openModal('addTeamMemberModal')">
                    <i class="fas fa-user-plus"></i> Add Team Member
                </button>
            <?php else: ?>
                <button type="button" class="btn-add-new" onclick="openModal('addAchievementModal')">
                    + <?= ($selectedCategory === 'patents') ? 'Add New Patent' : 'Add New Achievement' ?>
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Category Selector Pill Tabs -->
    <div style="display: flex; flex-wrap: wrap; gap: 8px; margin: 18px 0 14px; border-bottom: 1px solid #e2e8f0; padding-bottom: 14px;">
        <?php foreach ($categories as $catKey => $catMeta): ?>
            <a href="achievements.php?category=<?= $catKey ?>" 
               class="btn btn-sm <?= ($selectedCategory === $catKey) ? 'btn-primary' : 'btn-light' ?>" 
               style="border-radius: 9999px; padding: 6px 14px; font-size: 0.82rem; font-weight: 600; text-decoration: none;">
                <?= htmlspecialchars($catMeta['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Technopreneur Club Sub-Section Navigation -->
    <?php if ($selectedCategory === 'technopreneur_club'): ?>
        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin: 0 0 18px; background: #f8fafc; padding: 6px 8px; border-radius: 8px; border: 1px solid #e2e8f0; width: fit-content;">
            <a href="achievements.php?category=technopreneur_club&section=activities" 
               class="btn btn-sm <?= ($clubSection === 'activities') ? 'btn-primary' : 'btn-light' ?>" 
               style="border-radius: 6px; padding: 6px 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-calendar-check"></i> Club Activities
            </a>
            <a href="achievements.php?category=technopreneur_club&section=team" 
               class="btn btn-sm <?= ($clubSection === 'team') ? 'btn-primary' : 'btn-light' ?>" 
               style="border-radius: 6px; padding: 6px 14px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                <i class="fas fa-users"></i> Club Team &amp; Mentors (<?= $teamCounts['all'] ?: count($teamMembersList) ?>)
            </a>
        </div>
    <?php endif; ?>

    <?php if ($selectedCategory === 'technopreneur_club' && $clubSection === 'team'): ?>
        <!-- Team Subgroup Filter Tabs -->
        <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 18px; align-items: center;">
            <span style="font-size: 0.82rem; font-weight: 700; color: #64748b; margin-right: 4px;">FILTER BY ROLE:</span>
            <a href="achievements.php?category=technopreneur_club&section=team&group=all" class="btn btn-sm <?= ($teamFilter === 'all') ? 'btn-dark' : 'btn-light' ?>" style="border-radius: 9999px; padding: 5px 12px; font-size: 0.8rem; font-weight: 600; text-decoration: none;">
                All (<?= $teamCounts['all'] ?: count($teamMembersList) ?>)
            </a>
            <a href="achievements.php?category=technopreneur_club&section=team&group=convener" class="btn btn-sm <?= ($teamFilter === 'convener') ? 'btn-dark' : 'btn-light' ?>" style="border-radius: 9999px; padding: 5px 12px; font-size: 0.8rem; font-weight: 600; text-decoration: none;">
                Convener (<?= $teamCounts['convener'] ?: 1 ?>)
            </a>
            <a href="achievements.php?category=technopreneur_club&section=team&group=faculty_coordinator" class="btn btn-sm <?= ($teamFilter === 'faculty_coordinator') ? 'btn-dark' : 'btn-light' ?>" style="border-radius: 9999px; padding: 5px 12px; font-size: 0.8rem; font-weight: 600; text-decoration: none;">
                Faculty Coordinators (<?= $teamCounts['faculty_coordinator'] ?: 17 ?>)
            </a>
            <a href="achievements.php?category=technopreneur_club&section=team&group=student_leadership" class="btn btn-sm <?= ($teamFilter === 'student_leadership') ? 'btn-dark' : 'btn-light' ?>" style="border-radius: 9999px; padding: 5px 12px; font-size: 0.8rem; font-weight: 600; text-decoration: none;">
                Student Leadership (<?= $teamCounts['student_leadership'] ?: 4 ?>)
            </a>
            <a href="achievements.php?category=technopreneur_club&section=team&group=advisory_board" class="btn btn-sm <?= ($teamFilter === 'advisory_board') ? 'btn-dark' : 'btn-light' ?>" style="border-radius: 9999px; padding: 5px 12px; font-size: 0.8rem; font-weight: 600; text-decoration: none;">
                Advisory Board (<?= $teamCounts['advisory_board'] ?: 9 ?>)
            </a>

            <div class="search-input-group" style="margin-left: auto;">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search team members..." data-table-search="teamMembersTable">
            </div>
        </div>

        <!-- Technopreneur Team Data Table -->
        <div class="table-responsive">
            <table class="admin-table" id="teamMembersTable">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">Sr. No.</th>
                        <th>Member Name</th>
                        <th style="width: 170px;">Role Group</th>
                        <th>Designation / Role</th>
                        <th>Department</th>
                        <th style="width: 70px; text-align: center;">Order</th>
                        <th style="width: 90px; text-align: center;">Status</th>
                        <th style="width: 110px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($teamMembersList)): ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 36px; color: #94a3b8;">
                                No team members found. Click <strong>+ Add Team Member</strong> to add records.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $sr = 1; foreach ($teamMembersList as $tm):
                            $isActive = !isset($tm['is_active']) || $tm['is_active'] == 1;
                            $grp = $tm['group_type'] ?? 'faculty_coordinator';
                            $grpLabel = [
                                'convener' => 'Convener',
                                'faculty_coordinator' => 'Faculty Coordinator',
                                'student_leadership' => 'Student Leadership',
                                'advisory_board' => 'Advisory Board'
                            ][$grp] ?? ucfirst($grp);
                            $grpStyle = [
                                'convener' => 'background:#fef3c7; color:#b45309; border:1px solid #fde68a;',
                                'faculty_coordinator' => 'background:#e0f2fe; color:#0369a1; border:1px solid #bae6fd;',
                                'student_leadership' => 'background:#ede9fe; color:#6d28d9; border:1px solid #ddd6fe;',
                                'advisory_board' => 'background:#f1f5f9; color:#475569; border:1px solid #e2e8f0;'
                            ][$grp] ?? 'background:#f1f5f9; color:#475569;';
                        ?>
                            <tr data-status="<?= $isActive ? 'active' : 'inactive' ?>">
                                <td style="text-align: center; font-weight: 700; color: #64748b;"><?= $sr++ ?></td>
                                <td style="font-weight: 700; color: #0f172a; font-size: 14px;">
                                    <?= htmlspecialchars($tm['name']) ?>
                                </td>
                                <td>
                                    <span class="badge" style="<?= $grpStyle ?> padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700;">
                                        <?= htmlspecialchars($grpLabel) ?>
                                    </span>
                                </td>
                                <td style="font-weight: 600; color: #334155; font-size: 13px;">
                                    <?= htmlspecialchars($tm['designation_or_role'] ?? '—') ?>
                                </td>
                                <td style="font-size: 13px; color: #475569;">
                                    <?= htmlspecialchars($tm['department'] ?? '—') ?>
                                </td>
                                <td style="text-align: center; font-weight: 700; color: #64748b; font-size: 12px;">
                                    <?= (int)($tm['display_order'] ?? 0) ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="achievements.php?category=technopreneur_club&section=team&toggle_team_member=<?= $tm['id'] ?>" class="badge <?= $isActive ? 'badge-success' : 'badge-danger' ?>" style="text-decoration: none;" title="Click to toggle status">
                                        <?= $isActive ? 'Active' : 'Inactive' ?>
                                    </a>
                                </td>
                                <td style="text-align: center; white-space: nowrap;">
                                    <a href="achievements.php?category=technopreneur_club&section=team&edit_team=<?= $tm['id'] ?>" class="btn-action btn-edit" title="Edit Member">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="achievements.php?category=technopreneur_club&section=team&delete_team_member=<?= $tm['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to permanently delete this team member?');" title="Delete Member">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    <?php else: ?>
        <!-- Actions & Filter Row for Activities / Patents -->
        <div class="card-actions-row">
            <div class="card-filters" style="margin-left: auto;">
                <div class="search-input-group">
                    <i class="fas fa-search"></i>
                    <input type="text" class="search-input" placeholder="Search <?= ($selectedCategory === 'patents') ? 'patents...' : 'achievements...' ?>" data-table-search="achievementsTable">
                </div>
            </div>
        </div>

        <!-- Data Table for Activities / Patents -->
        <div class="table-responsive">
            <table class="admin-table" id="achievementsTable">
                <?php if ($selectedCategory === 'patents'): ?>
                    <!-- Patents Specific Table Headers -->
                    <thead>
                        <tr>
                            <th style="width: 60px; text-align: center;">Sr. No.</th>
                            <th>Title</th>
                            <th style="width: 90px; text-align: center;">Year</th>
                            <th style="width: 100px;">Category</th>
                            <th style="width: 100px;">Status</th>
                            <th>Faculty Name</th>
                            <th style="width: 110px;">Department</th>
                            <th style="width: 90px; text-align: center;">Status</th>
                            <th style="width: 110px; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($activitiesList)): ?>
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 36px; color: #94a3b8;">
                                    No patents found. Click <strong>+ Add New Patent</strong> to publish the first record.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $sr = 1; foreach ($activitiesList as $row):
                                $isActive = !isset($row['is_active']) || $row['is_active'] == 1;
                                $pYear = $row['pub_year'] ?? (!empty($row['activity_date']) ? date('Y', strtotime($row['activity_date'])) : '2025');
                                $pCat = $row['patent_category'] ?? 'Utility';
                                $pStat = $row['patent_status'] ?? 'Published';
                                $pFac = $row['faculty_name'] ?? '';
                                $pDept = $row['department'] ?? '';
                            ?>
                                <tr data-status="<?= $isActive ? 'active' : 'inactive' ?>">
                                    <td style="text-align: center; font-weight: 700; color: #64748b;"><?= $sr++ ?></td>
                                    <td>
                                        <div style="font-weight: 700; color: #0f172a; line-height: 1.4;"><?= htmlspecialchars($row['title']) ?></div>
                                        <?php if (!empty($row['description'])): ?>
                                            <div style="color: #64748b; font-size: 12px; margin-top: 3px; max-width: 450px;">
                                                <?= htmlspecialchars(mb_strimwidth($row['description'], 0, 110, '...')) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center; font-weight: 700; color: #0284c7;"><?= htmlspecialchars($pYear) ?></td>
                                    <td>
                                        <span class="badge" style="background: <?= ($pCat === 'Design') ? '#e0f2fe; color: #0369a1;' : '#fef3c7; color: #b45309;' ?> font-weight: 600; padding: 4px 8px; border-radius: 4px;">
                                            <?= htmlspecialchars($pCat) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge" style="font-weight: 700; padding: 4px 8px; border-radius: 4px; <?= ($pStat === 'Granted') ? 'background:#dcfce7; color:#15803d;' : 'background:#e0e7ff; color:#4338ca;' ?>">
                                            <?= htmlspecialchars($pStat) ?>
                                        </span>
                                    </td>
                                    <td style="font-size: 13px; color: #334155; max-width: 260px; line-height: 1.4;"><?= htmlspecialchars($pFac) ?></td>
                                    <td style="font-weight: 600; color: #0f172a; font-size: 13px;"><?= htmlspecialchars($pDept) ?></td>
                                    <td style="text-align: center;">
                                        <a href="achievements.php?toggle=<?= $row['id'] ?>&category=<?= $selectedCategory ?>" class="badge <?= $isActive ? 'badge-success' : 'badge-danger' ?>" style="text-decoration: none;" title="Click to toggle status">
                                            <?= $isActive ? 'Active' : 'Inactive' ?>
                                        </a>
                                    </td>
                                    <td style="text-align: center; white-space: nowrap;">
                                        <a href="achievements.php?edit=<?= $row['id'] ?>&category=<?= $selectedCategory ?>" class="btn-action btn-edit" title="Edit Patent">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="achievements.php?delete=<?= $row['id'] ?>&category=<?= $selectedCategory ?>" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to permanently delete this patent?');" title="Delete Patent">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                <?php else: ?>
                    <!-- Standard Achievements Table -->
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
                <?php endif; ?>
            </table>
        </div>
    <?php endif; ?>
</div>
</div>

<!-- ==========================================================================
     MODAL WINDOW STYLES (CRITICAL OVERLAY & DIALOG FIX)
     ========================================================================== -->
<style>
.modal-overlay {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    background: rgba(15, 23, 42, 0.75) !important;
    backdrop-filter: blur(4px) !important;
    -webkit-backdrop-filter: blur(4px) !important;
    display: none;
    align-items: center !important;
    justify-content: center !important;
    z-index: 999999 !important;
    padding: 20px !important;
    box-sizing: border-box !important;
}
.modal-overlay.active,
.modal-overlay.show,
.modal-overlay.is-open {
    display: flex !important;
}
.modal-dialog {
    background: #ffffff !important;
    border-radius: 12px !important;
    width: 100% !important;
    max-width: 650px !important;
    max-height: 90vh !important;
    display: flex !important;
    flex-direction: column !important;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important;
    overflow: hidden !important;
    animation: modalPopIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
@keyframes modalPopIn {
    from { opacity: 0; transform: scale(0.96) translateY(-10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.modal-header {
    padding: 16px 24px !important;
    border-bottom: 1px solid #e2e8f0 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    background: #f8fafc !important;
}
.modal-title {
    font-size: 18px !important;
    font-weight: 700 !important;
    color: #0f172a !important;
    margin: 0 !important;
}
.modal-close {
    background: none !important;
    border: none !important;
    font-size: 26px !important;
    line-height: 1 !important;
    color: #64748b !important;
    cursor: pointer !important;
    padding: 0 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 32px !important;
    height: 32px !important;
    border-radius: 6px !important;
    transition: all 0.15s ease !important;
}
.modal-close:hover {
    background: #e2e8f0 !important;
    color: #0f172a !important;
}
.modal-body {
    padding: 20px 24px !important;
    overflow-y: auto !important;
    max-height: calc(90vh - 140px) !important;
}
.modal-footer {
    padding: 14px 24px !important;
    border-top: 1px solid #e2e8f0 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: 12px !important;
    background: #f8fafc !important;
}
</style>

<!-- ==========================================================================
     ADD RECORD MODAL (DYNAMIC: PATENT VS STANDARD ACHIEVEMENT)
     ========================================================================== -->
<div class="modal-overlay" id="addAchievementModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><?= ($selectedCategory === 'patents') ? '+ Add New Patent' : '+ Add New Achievement' ?></h3>
            <button type="button" class="modal-close" onclick="closeModal('addAchievementModal')">&times;</button>
        </div>
        <form action="achievements.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Category <span style="color:red;">*</span></label>
                    <select name="category" class="form-control" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        <?php foreach ($categories as $catKey => $catMeta): ?>
                            <option value="<?= $catKey ?>" <?= ($selectedCategory === $catKey) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($catMeta['name']) ?> (<?= htmlspecialchars($catMeta['cell']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;"><?= ($selectedCategory === 'patents') ? 'Patent Title' : 'Achievement Title' ?> <span style="color:red;">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="<?= ($selectedCategory === 'patents') ? 'e.g. Real-Time Road Safety System with IoT Studs' : 'e.g. Smart India Hackathon 1st Prize Winner' ?>" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                </div>

                <?php if ($selectedCategory === 'patents'): ?>
                    <!-- Patent Specific Form Fields -->
                    <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                        <div style="flex: 1;">
                            <label style="display:block; font-weight:600; margin-bottom:6px;">Year of Publication <span style="color:red;">*</span></label>
                            <input type="number" name="pub_year" class="form-control" value="<?= date('Y') ?>" min="2000" max="2035" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        </div>
                        <div style="flex: 1;">
                            <label style="display:block; font-weight:600; margin-bottom:6px;">Category <span style="color:red;">*</span></label>
                            <input type="text" name="patent_category" class="form-control" placeholder="e.g. Utility, Design" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        </div>
                        <div style="flex: 1;">
                            <label style="display:block; font-weight:600; margin-bottom:6px;">Status <span style="color:red;">*</span></label>
                            <input type="text" name="patent_status" class="form-control" placeholder="e.g. Published, Granted" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        </div>
                    </div>

                    <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                        <div style="flex: 2;">
                            <label style="display:block; font-weight:600; margin-bottom:6px;">Faculty Name(s) / Inventors <span style="color:red;">*</span></label>
                            <input type="text" name="faculty_name" class="form-control" placeholder="e.g. Prof. N. N. Maltare, Prof. Safvan Vahora" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        </div>
                        <div style="flex: 1;">
                            <label style="display:block; font-weight:600; margin-bottom:6px;">Department <span style="color:red;">*</span></label>
                            <input type="text" name="department" class="form-control" placeholder="e.g. CE,IT,EC" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Patent Brief / Summary (Optional)</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Brief technical summary or application area..." style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;"></textarea>
                    </div>
                <?php else: ?>
                    <!-- Standard Achievement Form Fields -->
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
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Description / Award Highlights</label>
                        <textarea name="description" rows="4" class="form-control" placeholder="Enter detailed description of the achievement..." style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;"></textarea>
                    </div>
                <?php endif; ?>

                <div class="form-group" style="margin-bottom: 8px;">
                    <label style="display:inline-flex; align-items:center; gap:8px; cursor:pointer; font-weight: 600;">
                        <input type="checkbox" name="is_active" value="1" checked style="width:16px; height:16px;">
                        Publish immediately (Active)
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addAchievementModal')">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: #ff8800; border-color: #ff8800; color: #fff; font-weight: 600;">
                    <?= ($selectedCategory === 'patents') ? 'Save Patent' : 'Save Achievement' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================================================
     EDIT RECORD MODAL (DYNAMIC: PATENT VS STANDARD ACHIEVEMENT)
     ========================================================================== -->
<?php if ($editItem): 
    $isEditPatent = ($editItem['category'] === 'patents');
?>
<div class="modal-overlay active show is-open" id="editAchievementModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><?= $isEditPatent ? ('Edit Patent #' . $editItem['id']) : ('Edit Achievement #' . $editItem['id']) ?></h3>
            <a href="achievements.php?category=<?= $selectedCategory ?>" class="modal-close" style="text-decoration: none;">&times;</a>
        </div>
        <form action="achievements.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Category <span style="color:red;">*</span></label>
                    <select name="category" class="form-control" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        <?php foreach ($categories as $catKey => $catMeta): ?>
                            <option value="<?= $catKey ?>" <?= ($editItem['category'] === $catKey) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($catMeta['name']) ?> (<?= htmlspecialchars($catMeta['cell']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;"><?= $isEditPatent ? 'Patent Title' : 'Achievement Title' ?> <span style="color:red;">*</span></label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($editItem['title'] ?? '') ?>" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                </div>

                <?php if ($isEditPatent): ?>
                    <!-- Patent Specific Edit Fields -->
                    <?php
                        $curYear = $editItem['pub_year'] ?? (!empty($editItem['activity_date']) ? date('Y', strtotime($editItem['activity_date'])) : '2025');
                        $curCat = $editItem['patent_category'] ?? 'Utility';
                        $curStat = $editItem['patent_status'] ?? 'Published';
                    ?>
                    <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                        <div style="flex: 1;">
                            <label style="display:block; font-weight:600; margin-bottom:6px;">Year of Publication <span style="color:red;">*</span></label>
                            <input type="number" name="pub_year" class="form-control" value="<?= htmlspecialchars($curYear) ?>" min="2000" max="2035" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        </div>
                        <div style="flex: 1;">
                            <label style="display:block; font-weight:600; margin-bottom:6px;">Category <span style="color:red;">*</span></label>
                            <input type="text" name="patent_category" class="form-control" value="<?= htmlspecialchars($curCat) ?>" placeholder="e.g. Utility, Design" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        </div>
                        <div style="flex: 1;">
                            <label style="display:block; font-weight:600; margin-bottom:6px;">Status <span style="color:red;">*</span></label>
                            <input type="text" name="patent_status" class="form-control" value="<?= htmlspecialchars($curStat) ?>" placeholder="e.g. Published, Granted" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        </div>
                    </div>

                    <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                        <div style="flex: 2;">
                            <label style="display:block; font-weight:600; margin-bottom:6px;">Faculty Name(s) / Inventors <span style="color:red;">*</span></label>
                            <input type="text" name="faculty_name" class="form-control" value="<?= htmlspecialchars($editItem['faculty_name'] ?? '') ?>" placeholder="e.g. Prof. N. N. Maltare, Prof. Safvan Vahora" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        </div>
                        <div style="flex: 1;">
                            <label style="display:block; font-weight:600; margin-bottom:6px;">Department <span style="color:red;">*</span></label>
                            <input type="text" name="department" class="form-control" value="<?= htmlspecialchars($editItem['department'] ?? '') ?>" placeholder="e.g. CE,IT,EC" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Patent Brief / Summary</label>
                        <textarea name="description" rows="3" class="form-control" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;"><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
                    </div>
                <?php else: ?>
                    <!-- Standard Achievement Edit Fields -->
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
                            $dec = is_array($editItem['gallery_images']) ? $editItem['gallery_images'] : json_decode($editItem['gallery_images'], true);
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
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Description / Award Highlights</label>
                        <textarea name="description" rows="4" class="form-control" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;"><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
                    </div>
                <?php endif; ?>

                <div class="form-group" style="margin-bottom: 8px;">
                    <label style="display:inline-flex; align-items:center; gap:8px; cursor:pointer; font-weight: 600;">
                        <input type="checkbox" name="is_active" value="1" <?= (!isset($editItem['is_active']) || $editItem['is_active'] == 1) ? 'checked' : '' ?> style="width:16px; height:16px;">
                        Active / Published
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="achievements.php?category=<?= $selectedCategory ?>" class="btn btn-secondary" style="text-decoration:none;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="background: #ff8800; border-color: #ff8800; color: #fff; font-weight: 600;">
                    <?= $isEditPatent ? 'Update Patent' : 'Update Achievement' ?>
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<!-- ==========================================================================
     ADD TECHNOPRENEUR TEAM MEMBER MODAL
     ========================================================================== -->
<div class="modal-overlay" id="addTeamMemberModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">+ Add Technopreneur Team Member</h3>
            <button type="button" class="modal-close" onclick="closeModal('addTeamMemberModal')">&times;</button>
        </div>
        <form action="achievements.php" method="POST">
            <input type="hidden" name="action" value="add_team_member">
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Role Group <span style="color:red;">*</span></label>
                    <select name="group_type" class="form-control" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        <option value="convener">Convener</option>
                        <option value="faculty_coordinator" selected>Faculty Coordinator</option>
                        <option value="student_leadership">Student Leadership</option>
                        <option value="advisory_board">Advisory Board</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Member Full Name <span style="color:red;">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Dr. R. N. Vaza or Tanmay Panchal" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                </div>

                <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Role / Designation</label>
                        <input type="text" name="designation_or_role" class="form-control" placeholder="e.g. Faculty Coordinator, President, Vice President" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Department / Branch</label>
                        <input type="text" name="department" class="form-control" placeholder="e.g. Computer Engineering Department" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;">
                    </div>
                </div>

                <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Display Order (Sorting)</label>
                        <input type="number" name="display_order" class="form-control" value="10" min="0" max="9999" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 8px;">
                    <label style="display:inline-flex; align-items:center; gap:8px; cursor:pointer; font-weight: 600;">
                        <input type="checkbox" name="is_active" value="1" checked style="width:16px; height:16px;">
                        Active / Visible on Club Page
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addTeamMemberModal')">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: #ff8800; border-color: #ff8800; color: #fff; font-weight: 600;">
                    Save Team Member
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==========================================================================
     EDIT TECHNOPRENEUR TEAM MEMBER MODAL
     ========================================================================== -->
<?php if ($editTeamMember): ?>
<div class="modal-overlay active show is-open" id="editTeamMemberModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Edit Team Member: <?= htmlspecialchars($editTeamMember['name']) ?></h3>
            <a href="achievements.php?category=technopreneur_club&section=team" class="modal-close" style="text-decoration: none;">&times;</a>
        </div>
        <form action="achievements.php" method="POST">
            <input type="hidden" name="action" value="edit_team_member">
            <input type="hidden" name="id" value="<?= $editTeamMember['id'] ?>">
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Role Group <span style="color:red;">*</span></label>
                    <select name="group_type" class="form-control" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                        <option value="convener" <?= ($editTeamMember['group_type'] === 'convener') ? 'selected' : '' ?>>Convener</option>
                        <option value="faculty_coordinator" <?= ($editTeamMember['group_type'] === 'faculty_coordinator') ? 'selected' : '' ?>>Faculty Coordinator</option>
                        <option value="student_leadership" <?= ($editTeamMember['group_type'] === 'student_leadership') ? 'selected' : '' ?>>Student Leadership</option>
                        <option value="advisory_board" <?= ($editTeamMember['group_type'] === 'advisory_board') ? 'selected' : '' ?>>Advisory Board</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 16px;">
                    <label style="display:block; font-weight:600; margin-bottom:6px;">Member Full Name <span style="color:red;">*</span></label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($editTeamMember['name']) ?>" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;" required>
                </div>

                <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Role / Designation</label>
                        <input type="text" name="designation_or_role" class="form-control" value="<?= htmlspecialchars($editTeamMember['designation_or_role'] ?? '') ?>" placeholder="e.g. Faculty Coordinator, President, Vice President" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Department / Branch</label>
                        <input type="text" name="department" class="form-control" value="<?= htmlspecialchars($editTeamMember['department'] ?? '') ?>" placeholder="e.g. Computer Engineering Department" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;">
                    </div>
                </div>

                <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label style="display:block; font-weight:600; margin-bottom:6px;">Display Order (Sorting)</label>
                        <input type="number" name="display_order" class="form-control" value="<?= (int)($editTeamMember['display_order'] ?? 0) ?>" min="0" max="9999" style="width:100%; padding:9px 12px; border-radius:6px; border:1px solid #d1d5db;">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 8px;">
                    <label style="display:inline-flex; align-items:center; gap:8px; cursor:pointer; font-weight: 600;">
                        <input type="checkbox" name="is_active" value="1" <?= (!isset($editTeamMember['is_active']) || $editTeamMember['is_active'] == 1) ? 'checked' : '' ?> style="width:16px; height:16px;">
                        Active / Visible on Club Page
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="achievements.php?category=technopreneur_club&section=team" class="btn btn-secondary" style="text-decoration:none;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="background: #ff8800; border-color: #ff8800; color: #fff; font-weight: 600;">
                    Update Team Member
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.add('active', 'show', 'is-open');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}
function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('active', 'show', 'is-open');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }
}
// Backdrop click to dismiss
document.addEventListener('click', function(e) {
    if (e.target.classList && e.target.classList.contains('modal-overlay')) {
        closeModal(e.target.id);
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
