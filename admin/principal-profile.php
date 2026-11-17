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
        $website = '';
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
        $year = trim($_POST['year_of_passing'] ?? '');
        $perc = trim($_POST['percentage'] ?? '');
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
        $year = trim($_POST['year_of_passing'] ?? '');
        $perc = trim($_POST['percentage'] ?? '');
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

        if ($tab_name === 'publications' && isset($_POST['pub_authors'])) {
            $authors = trim($_POST['pub_authors'] ?? '');
            $journal = trim($_POST['pub_journal'] ?? '');
            $desc = (!empty($authors) ? "Authors: " . $authors . "\n" : "") . $journal;
        } elseif ($tab_name === 'books') {
            $bTitle = trim($_POST['title'] ?? '');
            $bPublisher = trim($_POST['extra_info'] ?? '');
            $bUniv = trim($_POST['book_univ'] ?? '');
            $bCode = trim($_POST['book_code'] ?? '');
            $bBranch = trim($_POST['book_branch'] ?? '');
            $bSemester = trim($_POST['book_semester'] ?? '');
            $bIsbn = trim($_POST['book_isbn'] ?? '');
            $bContent = trim($_POST['book_content'] ?? '');

            // Mandatory validation: Book Title, Publisher Name, and University
            if (empty($bTitle) || empty($bPublisher) || empty($bUniv)) {
                setFlashMessage('error', 'Book Title, Publisher Name, and University are mandatory fields!');
                header('Location: principal-profile.php?tab=tab_items&subtab=books');
                exit;
            }

            $descLines = [];
            if (!empty($bContent) && $bContent !== '--' && $bContent !== '-') $descLines[] = "Content: " . $bContent;
            if (!empty($bUniv) && $bUniv !== '--' && $bUniv !== '-') $descLines[] = "University: " . $bUniv;
            if (!empty($bBranch) && $bBranch !== '--' && $bBranch !== '-') $descLines[] = "Branch: " . $bBranch;
            if (!empty($bSemester) && $bSemester !== '--' && $bSemester !== '-') $descLines[] = "Semester: " . $bSemester;
            if (!empty($bCode) && $bCode !== '--' && $bCode !== '-') $descLines[] = "Book Code: " . $bCode;
            if (!empty($bIsbn) && $bIsbn !== '--' && $bIsbn !== '-') $descLines[] = "ISBN: " . $bIsbn;
            $desc = implode("\n", $descLines);
            $extra_info = $bPublisher;
            $title = $bTitle;
        } elseif ($tab_name === 'editorial') {
            $edText = trim($_POST['editorial_text'] ?? $_POST['title'] ?? '');
            $extra_info = trim($_POST['extra_info'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($edText)) {
                setFlashMessage('error', 'Editorial details cannot be empty!');
                header('Location: principal-profile.php?tab=tab_items&subtab=editorial');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'editorial'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $title = mb_substr($edText, 0, 250);
            $desc = $edText;
        } elseif ($tab_name === 'expert_talks') {
            $title = trim($_POST['title'] ?? '');
            $talkPlace = trim($_POST['talk_place'] ?? $_POST['extra_info'] ?? '');
            $talkYear = trim($_POST['talk_year'] ?? '');
            $talkDetails = trim($_POST['talk_details'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($title)) {
                setFlashMessage('error', 'Subject / Lecture Title is mandatory!');
                header('Location: principal-profile.php?tab=tab_items&subtab=expert_talks');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'expert_talks'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $descLines = [];
            if (!empty($talkYear) && $talkYear !== '--' && $talkYear !== '-') $descLines[] = "Year: " . $talkYear;
            if (!empty($talkPlace) && $talkPlace !== '--' && $talkPlace !== '-') $descLines[] = "Place: " . $talkPlace;
            if (!empty($talkDetails) && $talkDetails !== '--' && $talkDetails !== '-') $descLines[] = "Details: " . $talkDetails;
            $desc = implode("\n", $descLines);
            $extra_info = $talkPlace;
        }

        if (!empty($title)) {
            $stmt = $pdo->prepare("INSERT INTO principal_tab_items (tab_name, title, description, extra_info, display_order) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$tab_name, $title, $desc, $extra_info, $order]);
            setFlashMessage('success', 'Item added to ' . htmlspecialchars($tab_name) . '!');
        }
        header('Location: principal-profile.php?tab=tab_items&subtab=' . urlencode($tab_name));
        exit;

    } elseif ($action === 'edit_tab_item') {
        $id = (int)($_POST['id'] ?? 0);
        $tab_name = trim($_POST['tab_name'] ?? 'publications');
        $title = trim($_POST['title'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $extra_info = trim($_POST['extra_info'] ?? '');
        $order = (int)($_POST['display_order'] ?? 0);

        if ($tab_name === 'publications' && isset($_POST['pub_authors'])) {
            $authors = trim($_POST['pub_authors'] ?? '');
            $journal = trim($_POST['pub_journal'] ?? '');
            $desc = (!empty($authors) ? "Authors: " . $authors . "\n" : "") . $journal;
        } elseif ($tab_name === 'books') {
            $bTitle = trim($_POST['title'] ?? '');
            $bPublisher = trim($_POST['extra_info'] ?? '');
            $bUniv = trim($_POST['book_univ'] ?? '');
            $bCode = trim($_POST['book_code'] ?? '');
            $bBranch = trim($_POST['book_branch'] ?? '');
            $bSemester = trim($_POST['book_semester'] ?? '');
            $bIsbn = trim($_POST['book_isbn'] ?? '');
            $bContent = trim($_POST['book_content'] ?? '');

            // Mandatory validation: Book Title, Publisher Name, and University
            if (empty($bTitle) || empty($bPublisher) || empty($bUniv)) {
                setFlashMessage('error', 'Book Title, Publisher Name, and University are mandatory fields!');
                header('Location: principal-profile.php?tab=tab_items&subtab=books&edit_item=' . $id);
                exit;
            }

            $descLines = [];
            if (!empty($bContent) && $bContent !== '--' && $bContent !== '-') $descLines[] = "Content: " . $bContent;
            if (!empty($bUniv) && $bUniv !== '--' && $bUniv !== '-') $descLines[] = "University: " . $bUniv;
            if (!empty($bBranch) && $bBranch !== '--' && $bBranch !== '-') $descLines[] = "Branch: " . $bBranch;
            if (!empty($bSemester) && $bSemester !== '--' && $bSemester !== '-') $descLines[] = "Semester: " . $bSemester;
            if (!empty($bCode) && $bCode !== '--' && $bCode !== '-') $descLines[] = "Book Code: " . $bCode;
            if (!empty($bIsbn) && $bIsbn !== '--' && $bIsbn !== '-') $descLines[] = "ISBN: " . $bIsbn;
            $desc = implode("\n", $descLines);
            $extra_info = $bPublisher;
            $title = $bTitle;
        } elseif ($tab_name === 'editorial') {
            $edText = trim($_POST['editorial_text'] ?? $_POST['title'] ?? '');
            $extra_info = trim($_POST['extra_info'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($edText)) {
                setFlashMessage('error', 'Editorial details cannot be empty!');
                header('Location: principal-profile.php?tab=tab_items&subtab=editorial&edit_item=' . $id);
                exit;
            }

            $title = mb_substr($edText, 0, 250);
            $desc = $edText;
        } elseif ($tab_name === 'expert_talks') {
            $title = trim($_POST['title'] ?? '');
            $talkPlace = trim($_POST['talk_place'] ?? $_POST['extra_info'] ?? '');
            $talkYear = trim($_POST['talk_year'] ?? '');
            $talkDetails = trim($_POST['talk_details'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($title)) {
                setFlashMessage('error', 'Subject / Lecture Title is mandatory!');
                header('Location: principal-profile.php?tab=tab_items&subtab=expert_talks');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'expert_talks'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $descLines = [];
            if (!empty($talkYear) && $talkYear !== '--' && $talkYear !== '-') $descLines[] = "Year: " . $talkYear;
            if (!empty($talkPlace) && $talkPlace !== '--' && $talkPlace !== '-') $descLines[] = "Place: " . $talkPlace;
            if (!empty($talkDetails) && $talkDetails !== '--' && $talkDetails !== '-') $descLines[] = "Details: " . $talkDetails;
            $desc = implode("\n", $descLines);
            $extra_info = $talkPlace;
        }

        if ($id > 0 && !empty($title)) {
            $stmt = $pdo->prepare("UPDATE principal_tab_items SET title = ?, description = ?, extra_info = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$title, $desc, $extra_info, $order, $id]);
            setFlashMessage('success', 'Item updated successfully!');
        }
        header('Location: principal-profile.php?tab=tab_items&subtab=' . urlencode($tab_name));
        exit;

    } elseif ($action === 'update_pub_summary') {
        $cats = $_POST['summary_cats'] ?? [];
        $counts = $_POST['summary_counts'] ?? [];
        $pdo->prepare("DELETE FROM principal_tab_items WHERE tab_name = 'pub_summary'")->execute();
        $stmtS = $pdo->prepare("INSERT INTO principal_tab_items (tab_name, title, extra_info, display_order) VALUES ('pub_summary', ?, ?, ?)");
        $ord = 1;
        foreach ($cats as $idx => $cat) {
            $cat = trim($cat);
            $cnt = trim($counts[$idx] ?? '0');
            if (!empty($cat)) {
                $stmtS->execute([$cat, $cnt, $ord++]);
            }
        }
        setFlashMessage('success', 'Publications summary counts updated successfully!');
        header('Location: principal-profile.php?tab=tab_items&subtab=publications');
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
        <a href="../administration/principal" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; font-size: 12.5px;">
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
            <i class="fas fa-graduation-cap"></i> Academic Qualifications
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

                <!-- Row 4: Official Contact -->
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label">Official Email</label>
                    <input type="email" name="email" class="form-control" placeholder="e.g. jeetendra.vadher@gecmodasa.ac.in" value="<?= htmlspecialchars($profile['email'] ?? '') ?>">
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
        <!-- TAB 2: ACADEMIC QUALIFICATIONS                 -->
        <!-- ============================================== -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
            <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0;">
                <i class="fas <?= $editQual ? 'fa-edit' : 'fa-plus-circle' ?>" style="color: #1e90ff;"></i>
                <?= $editQual ? 'Edit Academic Qualification' : 'Add Academic Qualification (Degree / Milestone)' ?>
            </h3>

            <form action="principal-profile.php?tab=qualifications" method="POST">
                <input type="hidden" name="action" value="<?= $editQual ? 'edit_qualification' : 'add_qualification' ?>">
                <?php if ($editQual): ?>
                    <input type="hidden" name="id" value="<?= $editQual['id'] ?>">
                <?php endif; ?>

                <div style="display: grid; grid-template-columns: 2fr 2fr 1fr 1fr 1fr; gap: 14px; margin-bottom: 18px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Degree / Qualification <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="qualification" class="form-control" placeholder="e.g. Ph.D. or M. Tech." required value="<?= htmlspecialchars($editQual['qualification'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">University / Board</label>
                        <input type="text" name="university_board" class="form-control" placeholder="IIT Madras" value="<?= htmlspecialchars($editQual['university_board'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Passing Year</label>
                        <input type="text" name="year_of_passing" class="form-control" placeholder="e.g. 2015" value="<?= htmlspecialchars($editQual['year_of_passing'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Grade / CGPA</label>
                        <input type="text" name="percentage" class="form-control" placeholder="e.g. Distinction or 8.44 CGPA" value="<?= htmlspecialchars($editQual['percentage'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Order</label>
                        <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editQual['display_order'] ?? '0') ?>">
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary" style="padding: 8px 22px; font-size: 13px;">
                        <i class="fas fa-save"></i> <?= $editQual ? 'Update Qualification' : 'Add Qualification' ?>
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
                        <th>Degree / Qualification</th>
                        <th>University / Board</th>
                        <th>Passing Year</th>
                        <th>Grade / CGPA</th>
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

        <?php 
        // Handle Edit Item Fetch
        $editItem = null;
        if (isset($_GET['edit_item']) && $pdo) {
            $eId = (int)$_GET['edit_item'];
            $eStmt = $pdo->prepare("SELECT * FROM principal_tab_items WHERE id = ?");
            $eStmt->execute([$eId]);
            $editItem = $eStmt->fetch(PDO::FETCH_ASSOC);
        }

        $editAuthors = '';
        $editJournal = '';
        $editBookCode = '';
        $editBookUniv = '';
        $editBookBranch = '';
        $editBookSemester = '';
        $editBookIsbn = '';
        $editBookContent = '';

        if ($editItem) {
            $eDesc = $editItem['description'] ?? '';
            if ($subtab === 'publications') {
                if (preg_match('/^Authors:\s*(.*?)(?:\n(.*))?$/s', $eDesc, $matches)) {
                    $editAuthors = trim($matches[1]);
                    $editJournal = isset($matches[2]) ? trim($matches[2]) : '';
                } else {
                    $editJournal = $eDesc;
                }
            } elseif ($subtab === 'books') {
                $lines = explode("\n", $eDesc);
                foreach ($lines as $ln) {
                    $ln = trim($ln);
                    if (preg_match('/^(?:Edition|Content):\s*(.*)$/i', $ln, $m)) $editBookContent = trim($m[1]);
                    elseif (preg_match('/^University:\s*(.*)$/i', $ln, $m)) $editBookUniv = trim($m[1]);
                    elseif (preg_match('/^Branch:\s*(.*)$/i', $ln, $m)) $editBookBranch = trim($m[1]);
                    elseif (preg_match('/^Semester:\s*(.*)$/i', $ln, $m)) $editBookSemester = trim($m[1]);
                    elseif (preg_match('/^(?:Book Code|Code):\s*(.*)$/i', $ln, $m)) $editBookCode = trim($m[1]);
                    elseif (preg_match('/^ISBN:\s*(.*)$/i', $ln, $m)) $editBookIsbn = trim($m[1]);
                }
                if (empty($editBookContent) && empty($editBookUniv) && empty($editBookBranch) && empty($editBookIsbn) && empty($editBookCode) && empty($editBookSemester)) {
                    $editBookContent = $eDesc;
                }
            }
        }
        ?>

        <?php if ($subtab === 'publications'): 
            $pubSummaryRows = [];
            if ($pdo) {
                $pubSummaryRows = $pdo->query("SELECT * FROM principal_tab_items WHERE tab_name = 'pub_summary' ORDER BY display_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
            }
            if (empty($pubSummaryRows)) {
                $pubSummaryRows = [
                    ['title' => 'International Journal', 'extra_info' => '53'],
                    ['title' => 'International Conference', 'extra_info' => '22'],
                    ['title' => 'National Journal', 'extra_info' => '3'],
                    ['title' => 'National Conference', 'extra_info' => '5']
                ];
            }
        ?>
            <!-- Publications Summary Counts Box (Manual Management) -->
            <div style="background: #ffffff; border: 1px solid #fed7aa; border-radius: 8px; padding: 20px 22px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(255, 136, 0, 0.08);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 8px;">
                    <div>
                        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-chart-pie" style="color: #ff8800;"></i> Manage Publication Summary Counts
                        </h3>
                        <p style="font-size: 12.5px; color: #64748b; margin: 3px 0 0 0;">
                            Public profile page par summary table me dikhaye jaane wale counts yahan se set karein.
                        </p>
                    </div>
                </div>

                <form action="principal-profile.php?tab=tab_items&subtab=publications" method="POST">
                    <input type="hidden" name="action" value="update_pub_summary">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; margin-bottom: 16px;">
                        <?php foreach ($pubSummaryRows as $idx => $psr): ?>
                            <div>
                                <label class="form-label" style="font-size: 12.5px; font-weight: 600; color: #334155;">
                                    <?= htmlspecialchars($psr['title']) ?>
                                </label>
                                <input type="hidden" name="summary_cats[]" value="<?= htmlspecialchars($psr['title']) ?>">
                                <input type="number" name="summary_counts[]" class="form-control" value="<?= htmlspecialchars($psr['extra_info']) ?>" min="0" required>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary" style="padding: 6px 18px; font-size: 13px;">
                        <i class="fas fa-save"></i> Save Summary Counts
                    </button>
                </form>
            </div>
        <?php endif; ?>

        <div id="item-form" style="background: <?= $editItem ? '#fffbeb' : '#f8fafc' ?>; border: 1px solid <?= $editItem ? '#fde68a' : '#e2e8f0' ?>; border-radius: 8px; padding: 22px; margin-bottom: 24px;">
            <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; justify-content: space-between;">
                <span>
                    <i class="<?= $editItem ? 'fas fa-edit' : 'fas fa-plus-circle' ?>" style="color: <?= $editItem ? '#d97706' : '#1e90ff' ?>;"></i> 
                    <?= $editItem ? 'Modify / Edit ' . htmlspecialchars($tabList[$subtab] ?? $subtab) . ' Entry' : 'Add New Item to ' . htmlspecialchars($tabList[$subtab] ?? $subtab) ?>
                </span>
                <?php if ($editItem): ?>
                    <a href="principal-profile.php?tab=tab_items&subtab=<?= urlencode($subtab) ?>" class="btn btn-sm btn-secondary" style="font-size: 12px; padding: 3px 10px;">
                        <i class="fas fa-times"></i> Cancel Edit
                    </a>
                <?php endif; ?>
            </h3>

            <form action="principal-profile.php?tab=tab_items" method="POST">
                <input type="hidden" name="action" value="<?= $editItem ? 'edit_tab_item' : 'add_tab_item' ?>">
                <input type="hidden" name="tab_name" value="<?= htmlspecialchars($subtab) ?>">
                <?php if ($editItem): ?>
                    <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
                <?php endif; ?>

                <?php if ($subtab === 'publications'): 
                    $selectedCat = $editItem['extra_info'] ?? 'International Journal';
                ?>
                    <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Research Paper Title <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. An Impact of reinforcement on Aluminum metal matrix composites: A critical Review" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Category</label>
                            <select name="extra_info" class="form-control">
                                <option value="International Journal" <?= ($selectedCat === 'International Journal') ? 'selected' : '' ?>>International Journal</option>
                                <option value="International Conference" <?= ($selectedCat === 'International Conference') ? 'selected' : '' ?>>International Conference</option>
                                <option value="National Journal" <?= ($selectedCat === 'National Journal') ? 'selected' : '' ?>>National Journal</option>
                                <option value="National Conference" <?= ($selectedCat === 'National Conference') ? 'selected' : '' ?>>National Conference</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">Authors</label>
                        <input type="text" name="pub_authors" class="form-control" placeholder="e.g. Kapil Banker, Anand Dhruv, Jeetendra Vadher, Utkarsh Patel" value="<?= htmlspecialchars($editAuthors) ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">Journal / Conference / ISSN / DOI / Citation</label>
                        <textarea name="pub_journal" class="form-control" rows="2" placeholder="e.g. International Journal of Computational and Experimental Science and Engineering, Vol. 11, DOI: 10.22399/..."><?= htmlspecialchars($editJournal) ?></textarea>
                    </div>

                <?php elseif ($subtab === 'books'): ?>
                    <!-- Row 1: Book Title & Publisher Name (Both Mandatory) -->
                    <div style="display: grid; grid-template-columns: 3fr 2fr; gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Book Title / Name <span style="color: #ef4444; font-weight: bold;">*</span>
                            </label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Computer Integrated Manufacturing" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Mandatory: Official book title or monograph name</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Publisher Name <span style="color: #ef4444; font-weight: bold;">*</span>
                            </label>
                            <input type="text" name="extra_info" class="form-control" placeholder="e.g. Books India Publications, Pearson" required value="<?= htmlspecialchars($editItem['extra_info'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Mandatory: Publishing house or entity</small>
                        </div>
                    </div>

                    <!-- Row 2: University (Mandatory), Branch (Optional), Semester (Optional) -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                University <span style="color: #ef4444; font-weight: bold;">*</span>
                            </label>
                            <input type="text" name="book_univ" class="form-control" placeholder="e.g. GTU" required value="<?= htmlspecialchars($editBookUniv) ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Mandatory: Affiliated university / board</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Branch <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="book_branch" class="form-control" placeholder="e.g. Mechanical (or leave empty)" value="<?= htmlspecialchars($editBookBranch) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Leave empty if not specified</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Semester <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="book_semester" class="form-control" placeholder="e.g. Sem 5, Sem 7 (or leave empty)" value="<?= htmlspecialchars($editBookSemester) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Leave empty if not specified</small>
                        </div>
                    </div>

                    <!-- Row 3: Content/Edition (Optional), Book Code (Optional), ISBN Code (Optional) -->
                    <div style="display: grid; grid-template-columns: 1.5fr 1fr 1.5fr; gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Content / Edition <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="book_content" class="form-control" placeholder="e.g. GTU Syllabus, First Edition Dec 2019" value="<?= htmlspecialchars($editBookContent) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Edition details or curriculum scope</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Book Code <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="book_code" class="form-control" placeholder="e.g. ME-204 (or leave empty)" value="<?= htmlspecialchars($editBookCode) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Leave empty if not applicable</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                ISBN Code <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="book_isbn" class="form-control" placeholder="e.g. 978-93-80867-54-0 (or leave empty)" value="<?= htmlspecialchars($editBookIsbn) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Leave empty if not assigned</small>
                        </div>
                    </div>

                <?php elseif ($subtab === 'editorial'): ?>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-weight: 600;">
                            Editorial Role, Journal / Committee &amp; Details <span style="color: #ef4444; font-weight: bold;">*</span>
                        </label>
                        <textarea name="editorial_text" class="form-control" rows="3" placeholder="e.g. Editorial Board Member Educational Coordinator, The Technology World, Kuala Lumpur, Malaysia ISSN: 2180-1614, 20 June 2020." required><?= htmlspecialchars($editItem['description'] ?? $editItem['title'] ?? '') ?></textarea>
                        <small style="font-size: 11.5px; color: #64748b;">Mandatory: Full editorial board title, journal/conference name, ISSN, location, or date.</small>
                    </div>

                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Organization / Location / Tag <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="extra_info" class="form-control" placeholder="e.g. Kuala Lumpur, Malaysia or GTU" value="<?= htmlspecialchars($editItem['extra_info'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Short tag, location, or institution</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Sr. No. / Display Order <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="number" name="display_order" class="form-control" placeholder="Auto" value="<?= htmlspecialchars($editItem['display_order'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Controls sorting order (leave blank to auto-append)</small>
                        </div>
                    </div>

                <?php else: ?>
                    <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Title / Citation <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Research Paper Title, Book Name, Talk Subject" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Extra Info / Journal / Publisher / Year</label>
                            <input type="text" name="extra_info" class="form-control" placeholder="e.g. Elsevier 2023, ISBN..." value="<?= htmlspecialchars($editItem['extra_info'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">Full Description / Abstract</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Brief summary, authors, conference details..."><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
                    </div>
                <?php endif; ?>

                <div style="display: flex; gap: 10px; align-items: center;">
                    <button type="submit" class="btn btn-primary" style="padding: 8px 22px; font-size: 13px;">
                        <i class="fas fa-save"></i> <?= $editItem ? 'Update ' . htmlspecialchars($tabList[$subtab] ?? $subtab) : 'Add to ' . htmlspecialchars($tabList[$subtab] ?? $subtab) ?>
                    </button>
                    <?php if ($editItem): ?>
                        <a href="principal-profile.php?tab=tab_items&subtab=<?= urlencode($subtab) ?>" class="btn btn-secondary" style="padding: 8px 18px; font-size: 13px;">Cancel Edit</a>
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
                        <th><?= ($subtab === 'books') ? 'Book Title / Monograph' : (($subtab === 'editorial') ? 'Editorial Role & Details' : 'Title / Citation') ?></th>
                        <th><?= ($subtab === 'books') ? 'Publisher' : (($subtab === 'editorial') ? 'Organization / Location' : 'Journal / Publisher / Date') ?></th>
                        <th><?= ($subtab === 'books') ? 'University, Edition & Details' : (($subtab === 'editorial') ? 'Editorial Summary' : 'Description') ?></th>
                        <th style="width: 100px; text-align: right;">Action</th>
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
                            <tr style="<?= ($editItem && $editItem['id'] == $item['id']) ? 'background: #fffbeb;' : '' ?>">
                                <td><?= !empty($item['display_order']) ? (int)$item['display_order'] : ($idx + 1) ?></td>
                                <td style="font-weight: 600; color: #1e293b;">
                                    <?php if ($subtab === 'editorial'): ?>
                                        <?= htmlspecialchars(mb_strimwidth(!empty($item['description']) ? $item['description'] : $item['title'], 0, 85, '...')) ?>
                                    <?php else: ?>
                                        <?= htmlspecialchars($item['title']) ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($item['extra_info'])): ?>
                                        <span style="font-weight: 600; color: #1e40af; background: #eff6ff; padding: 2px 8px; border-radius: 4px; font-size: 12px; border: 1px solid #bfdbfe;">
                                            <?= htmlspecialchars($item['extra_info']) ?>
                                        </span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td style="font-size: 13px; color: #475569; max-width: 340px;">
                                    <?= htmlspecialchars(str_replace("\n", " • ", mb_strimwidth(!empty($item['description']) ? $item['description'] : ($item['title'] ?? ''), 0, 110, '...'))) ?>
                                </td>
                                <td style="text-align: right; white-space: nowrap;">
                                    <a href="principal-profile.php?tab=tab_items&subtab=<?= urlencode($subtab) ?>&edit_item=<?= $item['id'] ?>#item-form" class="btn btn-sm btn-info" style="padding: 3px 8px; margin-right: 4px;" title="Modify / Edit this entry">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="principal-profile.php?tab=tab_items" method="POST" style="display: inline;" onsubmit="return confirm('Delete this item?');">
                                        <input type="hidden" name="action" value="delete_tab_item">
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                        <input type="hidden" name="subtab" value="<?= htmlspecialchars($subtab) ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" style="padding: 3px 8px;" title="Delete">
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
