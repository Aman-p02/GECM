<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Principal Profile Management";
$current_page = 'principal-profile';

$activeTab = $_GET['tab'] ?? 'profile'; // 'profile', 'qualifications', 'tab_items'

// Handle Form Submissions
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: principal-profile.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    // ==========================================
    // 1. UPDATE BASIC PROFILE
    // ==========================================
    if ($action === 'update_profile') {
        $name = trim($_POST['name'] ?? '');
        $designation = trim($_POST['designation'] ?? 'Principal');
        $qualification = trim($_POST['qualification'] ?? '');
        $experience = trim($_POST['experience'] ?? '');
        $date_of_joining = trim($_POST['date_of_joining'] ?? '');
        $area_of_interest = trim($_POST['area_of_interest'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $website = trim($_POST['website'] ?? '');
        $existing_photo = trim($_POST['existing_photo'] ?? '');

        if (empty($name)) {
            setFlashMessage('danger', 'Principal name is required.');
            header('Location: principal-profile.php?tab=profile');
            exit;
        }

        $photo_url = $existing_photo;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload = handleImageUpload('photo', 'principal', $existing_photo);
            if ($upload['success']) {
                $photo_url = $upload['path'];
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: principal-profile.php?tab=profile');
                exit;
            }
        }

        $pCheck = $pdo->query("SELECT id FROM principal_profile LIMIT 1")->fetch();
        if ($pCheck) {
            $stmt = $pdo->prepare("UPDATE principal_profile SET name = ?, designation = ?, qualification = ?, experience = ?, date_of_joining = ?, area_of_interest = ?, email = ?, website = ?, photo_url = ? WHERE id = ?");
            $stmt->execute([$name, $designation, $qualification, $experience, $date_of_joining, $area_of_interest, $email, $website, $photo_url, $pCheck['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO principal_profile (name, designation, qualification, experience, date_of_joining, area_of_interest, email, website, photo_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $designation, $qualification, $experience, $date_of_joining, $area_of_interest, $email, $website, $photo_url]);
        }

        setFlashMessage('success', 'Principal basic profile updated successfully!');
        header('Location: principal-profile.php?tab=profile');
        exit;

    // ==========================================
    // 2. QUALIFICATIONS
    // ==========================================
    } elseif ($action === 'add_qualification') {
        $qual = trim($_POST['qualification'] ?? '');
        $univ = trim($_POST['university_board'] ?? '');
        $year = trim($_POST['year_of_passing'] ?? '--');
        $perc = trim($_POST['percentage'] ?? '--');
        $order = (int)($_POST['display_order'] ?? 0);

        if (!empty($qual)) {
            $stmt = $pdo->prepare("INSERT INTO principal_qualifications (qualification, university_board, year_of_passing, percentage, display_order) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$qual, $univ, $year, $perc, $order]);
            setFlashMessage('success', 'Qualification entry added!');
        } else {
            setFlashMessage('danger', 'Qualification title is required.');
        }
        header('Location: principal-profile.php?tab=qualifications');
        exit;

    } elseif ($action === 'edit_qualification') {
        $id = (int)($_POST['id'] ?? 0);
        $qual = trim($_POST['qualification'] ?? '');
        $univ = trim($_POST['university_board'] ?? '');
        $year = trim($_POST['year_of_passing'] ?? '--');
        $perc = trim($_POST['percentage'] ?? '--');
        $order = (int)($_POST['display_order'] ?? 0);

        if ($id > 0 && !empty($qual)) {
            $stmt = $pdo->prepare("UPDATE principal_qualifications SET qualification = ?, university_board = ?, year_of_passing = ?, percentage = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$qual, $univ, $year, $perc, $order, $id]);
            setFlashMessage('success', 'Qualification updated!');
        }
        header('Location: principal-profile.php?tab=qualifications');
        exit;

    } elseif ($action === 'delete_qualification') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $pdo->prepare("DELETE FROM principal_qualifications WHERE id = ?")->execute([$id]);
            setFlashMessage('success', 'Qualification deleted.');
        }
        header('Location: principal-profile.php?tab=qualifications');
        exit;

    // ==========================================
    // 3. TAB ITEMS (PUBLICATIONS, BOOKS, TALKS)
    // ==========================================
    } elseif ($action === 'add_tab_item') {
        $tab_name = trim($_POST['tab_name'] ?? 'publications');
        $title = trim($_POST['title'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $extra_info = trim($_POST['extra_info'] ?? '');
        $order = (int)($_POST['display_order'] ?? 0);

        if (!empty($title)) {
            $stmt = $pdo->prepare("INSERT INTO principal_tab_items (tab_name, title, description, extra_info, display_order) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$tab_name, $title, $desc, $extra_info, $order]);
            setFlashMessage('success', 'Item added to ' . htmlspecialchars($tab_name) . '!');
        }
        header('Location: principal-profile.php?tab=tab_items&subtab=' . urlencode($tab_name));
        exit;

    } elseif ($action === 'delete_tab_item') {
        $id = (int)($_POST['id'] ?? 0);
        $subtab = trim($_POST['subtab'] ?? 'publications');
        if ($id > 0) {
            $pdo->prepare("DELETE FROM principal_tab_items WHERE id = ?")->execute([$id]);
            setFlashMessage('success', 'Item deleted.');
        }
        header('Location: principal-profile.php?tab=tab_items&subtab=' . urlencode($subtab));
        exit;
    }
}

// Fetch Principal Profile
$profile = null;
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM principal_profile LIMIT 1");
    $profile = $stmt ? $stmt->fetch() : null;
}

// Fetch Qualifications
$qualifications = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM principal_qualifications ORDER BY display_order ASC, id ASC");
    $qualifications = $stmt ? $stmt->fetchAll() : [];
}

// Fetch Tab Items
$subtab = $_GET['subtab'] ?? 'publications';
$tabItems = [];
if ($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM principal_tab_items WHERE tab_name = ? ORDER BY display_order ASC, id DESC");
    $stmt->execute([$subtab]);
    $tabItems = $stmt->fetchAll();
}

// Fetch edit qualification if requested
$editQual = null;
if (isset($_GET['edit_qual']) && (int)$_GET['edit_qual'] > 0 && $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM principal_qualifications WHERE id = ?");
    $stmt->execute([(int)$_GET['edit_qual']]);
    $editQual = $stmt->fetch();
}

$tabList = [
    'publications' => 'Publications',
    'books' => 'Books',
    'editorial' => 'Editorial',
    'expert_talks' => 'Expert Talks',
    'workshops' => 'Workshops',
    'experience' => 'Experience',
    'extra' => 'Extra'
];

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 24px;">
    <!-- Top Action Bar (No Duplicate Title) -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 14px; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <p style="font-size: 13.5px; color: #64748b; margin: 0;">Manage Principal's faculty-style profile, academic credentials, research metrics, and publications.</p>
        <a href="../principal.php" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; font-size: 12.5px;">
            <i class="fas fa-external-link-alt"></i> View Public Profile
        </a>
    </div>

    <!-- Navigation Tabs -->
    <div style="display: flex; gap: 8px; border-bottom: 2px solid #e2e8f0; margin-bottom: 24px;">
        <a href="principal-profile.php?tab=profile" 
           style="padding: 9px 18px; font-weight: 600; font-size: 14px; text-decoration: none; border-bottom: 3px solid <?= ($activeTab === 'profile') ? '#1e90ff' : 'transparent' ?>; color: <?= ($activeTab === 'profile') ? '#1e90ff' : '#64748b' ?>; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-user-tie"></i> Profile Details &amp; Photo
        </a>
        <a href="principal-profile.php?tab=qualifications" 
           style="padding: 9px 18px; font-weight: 600; font-size: 14px; text-decoration: none; border-bottom: 3px solid <?= ($activeTab === 'qualifications') ? '#1e90ff' : 'transparent' ?>; color: <?= ($activeTab === 'qualifications') ? '#1e90ff' : '#64748b' ?>; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-graduation-cap"></i> Qualifications &amp; Research IDs
        </a>
        <a href="principal-profile.php?tab=tab_items" 
           style="padding: 9px 18px; font-weight: 600; font-size: 14px; text-decoration: none; border-bottom: 3px solid <?= ($activeTab === 'tab_items') ? '#1e90ff' : 'transparent' ?>; color: <?= ($activeTab === 'tab_items') ? '#1e90ff' : '#64748b' ?>; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-book"></i> Profile Tabs (Publications, Books, etc.)
        </a>
    </div>

    <?php if ($activeTab === 'profile'): ?>
        <!-- ============================================== -->
        <!-- TAB 1: BASIC PROFILE & PHOTO                   -->
        <!-- ============================================== -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px;">
            <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-edit" style="color: #1e90ff;"></i> Edit Principal Bio &amp; Official Contact
            </h3>

            <form action="principal-profile.php?tab=profile" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_profile">
                <input type="hidden" name="existing_photo" value="<?= htmlspecialchars($profile['photo_url'] ?? '') ?>">

                <!-- Row 1 -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Full Name &amp; Title <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Dr. JEETENDRAKUMAR VADHER" required value="<?= htmlspecialchars($profile['name'] ?? 'Dr. JEETENDRAKUMAR VADHER') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Official Designation</label>
                        <input type="text" name="designation" class="form-control" value="<?= htmlspecialchars($profile['designation'] ?? 'Principal') ?>" required>
                    </div>
                </div>

                <!-- Row 2 -->
                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Highest Qualification</label>
                        <input type="text" name="qualification" class="form-control" placeholder="e.g. M. Tech. (IIT-Madras), Ph.D. (HNGU-Patan)" value="<?= htmlspecialchars($profile['qualification'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Experience</label>
                        <input type="text" name="experience" class="form-control" placeholder="e.g. 28 Years" value="<?= htmlspecialchars($profile['experience'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Date of Joining</label>
                        <input type="text" name="date_of_joining" class="form-control" placeholder="e.g. 18-05-2022" value="<?= htmlspecialchars($profile['date_of_joining'] ?? '') ?>">
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label">Area of Interest / Research Specialization</label>
                    <input type="text" name="area_of_interest" class="form-control" placeholder="e.g. Production, Manufacturing, Industrial Engineering, CAD/CAM, Automation" value="<?= htmlspecialchars($profile['area_of_interest'] ?? '') ?>">
                </div>

                <!-- Row 4 -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Official Email</label>
                        <input type="email" name="email" class="form-control" placeholder="e.g. jeetendra.vadher@gecmodasa.ac.in" value="<?= htmlspecialchars($profile['email'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Official Website URL</label>
                        <input type="text" name="website" class="form-control" placeholder="e.g. http://www.gecmodasa.ac.in/" value="<?= htmlspecialchars($profile['website'] ?? 'http://www.gecmodasa.ac.in/') ?>">
                    </div>
                </div>

                <!-- Row 5: Photo -->
                <div style="margin-bottom: 22px;">
                    <label class="form-label">Principal Photo (Faculty Card Media)</label>
                    <input type="file" name="photo" class="form-control" accept="image/*" style="padding: 5px 8px; font-size: 13px;">
                    <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">JPG, PNG, or WebP. Optimal size: 300x380px.</div>
                    <?php if (!empty($profile['photo_url'])): ?>
                        <div style="margin-top: 8px; display: flex; align-items: center; gap: 10px;">
                            <img src="../<?= htmlspecialchars($profile['photo_url']) ?>" alt="Principal Photo" style="width: 70px; height: 90px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;">
                            <span style="font-size: 12.5px; color: #64748b;">Current Photo</span>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 8px 22px; font-size: 13px;">
                    <i class="fas fa-save"></i> Save Principal Profile
                </button>
            </form>
        </div>

    <?php elseif ($activeTab === 'qualifications'): ?>
        <!-- ============================================== -->
        <!-- TAB 2: QUALIFICATIONS & RESEARCH IDS           -->
        <!-- ============================================== -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
            <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0;">
                <i class="fas <?= $editQual ? 'fa-edit' : 'fa-plus-circle' ?>" style="color: #1e90ff;"></i>
                <?= $editQual ? 'Edit Qualification / ID' : 'Add Qualification / Research ID (Google Scholar, Scopus, Vidhwan)' ?>
            </h3>

            <form action="principal-profile.php?tab=qualifications" method="POST">
                <input type="hidden" name="action" value="<?= $editQual ? 'edit_qualification' : 'add_qualification' ?>">
                <?php if ($editQual): ?>
                    <input type="hidden" name="id" value="<?= $editQual['id'] ?>">
                <?php endif; ?>

                <div style="display: grid; grid-template-columns: 2fr 2fr 1fr 1fr 1fr; gap: 14px; margin-bottom: 18px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Qualification / Metric <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="qualification" class="form-control" placeholder="e.g. GOOGLE SCHOLAR ID or Ph.D." required value="<?= htmlspecialchars($editQual['qualification'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">University / Board / ID Value</label>
                        <input type="text" name="university_board" class="form-control" placeholder="e.g. CiAjBIwAAAAJ or IIT Madras" value="<?= htmlspecialchars($editQual['university_board'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Year of Passing</label>
                        <input type="text" name="year_of_passing" class="form-control" placeholder="e.g. 2015 or --" value="<?= htmlspecialchars($editQual['year_of_passing'] ?? '--') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Perc. (%) / CPI</label>
                        <input type="text" name="percentage" class="form-control" placeholder="e.g. 8.9 CPI or --" value="<?= htmlspecialchars($editQual['percentage'] ?? '--') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Order</label>
                        <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editQual['display_order'] ?? '0') ?>">
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary" style="padding: 8px 22px; font-size: 13px;">
                        <i class="fas fa-save"></i> <?= $editQual ? 'Update Entry' : 'Add Entry' ?>
                    </button>
                    <?php if ($editQual): ?>
                        <a href="principal-profile.php?tab=qualifications" class="btn btn-secondary" style="padding: 8px 18px; font-size: 13px;">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Qualification / Identifier</th>
                        <th>University / Board / ID</th>
                        <th>Year</th>
                        <th>Perc. (%) / Grade</th>
                        <th style="width: 110px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($qualifications)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 24px; color: #64748b;">No qualifications added yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($qualifications as $idx => $q): ?>
                            <tr>
                                <td><?= $idx + 1 ?></td>
                                <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($q['qualification']) ?></td>
                                <td><?= htmlspecialchars($q['university_board'] ?? '--') ?></td>
                                <td><?= htmlspecialchars($q['year_of_passing'] ?? '--') ?></td>
                                <td><?= htmlspecialchars($q['percentage'] ?? '--') ?></td>
                                <td style="text-align: right;">
                                    <a href="principal-profile.php?tab=qualifications&edit_qual=<?= $q['id'] ?>" class="btn btn-sm btn-warning" style="padding: 3px 7px;" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="principal-profile.php?tab=qualifications" method="POST" style="display: inline;" onsubmit="return confirm('Delete this qualification?');">
                                        <input type="hidden" name="action" value="delete_qualification">
                                        <input type="hidden" name="id" value="<?= $q['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" style="padding: 3px 7px;" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    <?php elseif ($activeTab === 'tab_items'): ?>
        <!-- ============================================== -->
        <!-- TAB 3: PUBLICATIONS, BOOKS, TALKS, ETC.        -->
        <!-- ============================================== -->
        <div style="display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap;">
            <?php foreach ($tabList as $sKey => $sLabel): ?>
                <a href="principal-profile.php?tab=tab_items&subtab=<?= urlencode($sKey) ?>" 
                   class="btn btn-sm <?= ($subtab === $sKey) ? 'btn-primary' : 'btn-secondary' ?>" 
                   style="border-radius: 4px; font-weight: 600;">
                    <?= htmlspecialchars($sLabel) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 24px;">
            <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0;">
                <i class="fas fa-plus-circle" style="color: #1e90ff;"></i> Add New Item to <?= htmlspecialchars($tabList[$subtab] ?? $subtab) ?>
            </h3>

            <form action="principal-profile.php?tab=tab_items" method="POST">
                <input type="hidden" name="action" value="add_tab_item">
                <input type="hidden" name="tab_name" value="<?= htmlspecialchars($subtab) ?>">

                <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Title / Citation <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Research Paper Title, Book Name, Talk Subject" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Extra Info / Journal / Publisher / Year</label>
                        <input type="text" name="extra_info" class="form-control" placeholder="e.g. Elsevier 2023, ISBN...">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label">Full Description / Abstract</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Brief summary, authors, conference details..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="padding: 8px 22px; font-size: 13px;">
                    <i class="fas fa-save"></i> Add to <?= htmlspecialchars($tabList[$subtab] ?? $subtab) ?>
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="admin-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Title / Citation</th>
                        <th>Journal / Publisher / Date</th>
                        <th>Description</th>
                        <th style="width: 90px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tabItems)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 24px; color: #64748b;">
                                No items in <?= htmlspecialchars($tabList[$subtab] ?? $subtab) ?> yet.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tabItems as $idx => $item): ?>
                            <tr>
                                <td><?= $idx + 1 ?></td>
                                <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($item['title']) ?></td>
                                <td><?= htmlspecialchars($item['extra_info'] ?? '-') ?></td>
                                <td style="font-size: 13px; color: #475569; max-width: 320px;"><?= htmlspecialchars(mb_strimwidth($item['description'] ?? '', 0, 90, '...')) ?></td>
                                <td style="text-align: right;">
                                    <form action="principal-profile.php?tab=tab_items" method="POST" style="display: inline;" onsubmit="return confirm('Delete this item?');">
                                        <input type="hidden" name="action" value="delete_tab_item">
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                        <input type="hidden" name="subtab" value="<?= htmlspecialchars($subtab) ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" style="padding: 3px 7px;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
