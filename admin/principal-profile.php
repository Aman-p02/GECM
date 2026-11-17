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
        } elseif ($tab_name === 'workshops') {
            $title = trim($_POST['title'] ?? '');
            $wsPlace = trim($_POST['workshop_place'] ?? $_POST['extra_info'] ?? '');
            $wsYear = trim($_POST['workshop_year'] ?? '');
            $wsDuration = trim($_POST['workshop_duration'] ?? '');
            $wsDetails = trim($_POST['workshop_details'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($title)) {
                setFlashMessage('error', 'Subject / Workshop Title is mandatory!');
                header('Location: principal-profile.php?tab=tab_items&subtab=workshops');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'workshops'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $descLines = [];
            if (!empty($wsYear) && $wsYear !== '--' && $wsYear !== '-') $descLines[] = "Year: " . $wsYear;
            if (!empty($wsDuration) && $wsDuration !== '--' && $wsDuration !== '-') $descLines[] = "Duration: " . $wsDuration;
            if (!empty($wsPlace) && $wsPlace !== '--' && $wsPlace !== '-') $descLines[] = "Place: " . $wsPlace;
            if (!empty($wsDetails) && $wsDetails !== '--' && $wsDetails !== '-') $descLines[] = "Details: " . $wsDetails;
            $desc = implode("\n", $descLines);
            $extra_info = !empty($wsPlace) ? $wsPlace : '-';
        } elseif ($tab_name === 'experience') {
            $title = trim($_POST['title'] ?? '');
            $expPlace = trim($_POST['exp_place'] ?? $_POST['extra_info'] ?? '');
            $expJoin = trim($_POST['exp_join'] ?? '');
            $expLeave = trim($_POST['exp_leave'] ?? '');
            $expDept = trim($_POST['exp_dept'] ?? '');
            $expDuration = trim($_POST['exp_duration'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($title)) {
                setFlashMessage('error', 'Designation is mandatory!');
                header('Location: principal-profile.php?tab=tab_items&subtab=experience');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'experience'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $descLines = [];
            if (!empty($expJoin) && $expJoin !== '--' && $expJoin !== '-') $descLines[] = "Date of Joining: " . $expJoin;
            if (!empty($expLeave) && $expLeave !== '--' && $expLeave !== '-') $descLines[] = "Date of Leave: " . $expLeave;
            if (!empty($expDept) && $expDept !== '--' && $expDept !== '-') $descLines[] = "Department: " . $expDept;
            if (!empty($expDuration) && $expDuration !== '--' && $expDuration !== '-') $descLines[] = "Duration: " . $expDuration;
            if (!empty($expPlace) && $expPlace !== '--' && $expPlace !== '-') $descLines[] = "Place: " . $expPlace;
            $desc = implode("\n", $descLines);
            $extra_info = !empty($expPlace) ? $expPlace : '-';
        } elseif ($tab_name === 'achievements') {
            $achDetails = trim($_POST['details_text'] ?? $_POST['description'] ?? $_POST['title'] ?? '');
            $extra_info = trim($_POST['extra_info'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($achDetails)) {
                setFlashMessage('error', 'Achievement details cannot be empty!');
                header('Location: principal-profile.php?tab=tab_items&subtab=achievements');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'achievements'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $title = mb_substr($achDetails, 0, 250);
            $desc = $achDetails;
        } elseif ($tab_name === 'dissertation') {
            $title = trim($_POST['title'] ?? '');
            $student = trim($_POST['student'] ?? $_POST['extra_info'] ?? '');
            $dissYear = trim($_POST['diss_year'] ?? '');
            $dissDetails = trim($_POST['diss_details'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($title)) {
                setFlashMessage('error', 'Thesis / Research Title is mandatory!');
                header('Location: principal-profile.php?tab=tab_items&subtab=dissertation');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'dissertation'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $descLines = [];
            if (!empty($dissYear) && $dissYear !== '--' && $dissYear !== '-') $descLines[] = "Year: " . $dissYear;
            if (!empty($student) && $student !== '--' && $student !== '-') $descLines[] = "Student: " . $student;
            if (!empty($dissDetails) && $dissDetails !== '--' && $dissDetails !== '-') $descLines[] = "Details: " . $dissDetails;
            $desc = implode("\n", $descLines);
            $extra_info = !empty($student) ? $student : '-';
        } elseif ($tab_name === 'membership') {
            $memDetails = trim($_POST['details_text'] ?? $_POST['description'] ?? $_POST['title'] ?? '');
            $extra_info = trim($_POST['extra_info'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($memDetails)) {
                setFlashMessage('error', 'Membership details cannot be empty!');
                header('Location: principal-profile.php?tab=tab_items&subtab=membership');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'membership'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $title = mb_substr($memDetails, 0, 250);
            $desc = $memDetails;
        } elseif ($tab_name === 'patents') {
            $title = trim($_POST['title'] ?? '');
            $patDetails = trim($_POST['patent_details'] ?? $_POST['description'] ?? '');
            $extra_info = trim($_POST['extra_info'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($title)) {
                setFlashMessage('error', 'Patent Title is mandatory!');
                header('Location: principal-profile.php?tab=tab_items&subtab=patents');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'patents'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $desc = !empty($patDetails) ? $patDetails : $title;
        }

        if ($order === 0) {
            $maxStmt = $pdo->prepare("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = ?");
            $maxStmt->execute([$tab_name]);
            $order = (int)$maxStmt->fetchColumn();
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
        } elseif ($tab_name === 'workshops') {
            $title = trim($_POST['title'] ?? '');
            $wsPlace = trim($_POST['workshop_place'] ?? $_POST['extra_info'] ?? '');
            $wsYear = trim($_POST['workshop_year'] ?? '');
            $wsDuration = trim($_POST['workshop_duration'] ?? '');
            $wsDetails = trim($_POST['workshop_details'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($title)) {
                setFlashMessage('error', 'Subject / Workshop Title is mandatory!');
                header('Location: principal-profile.php?tab=tab_items&subtab=workshops');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'workshops'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $descLines = [];
            if (!empty($wsYear) && $wsYear !== '--' && $wsYear !== '-') $descLines[] = "Year: " . $wsYear;
            if (!empty($wsDuration) && $wsDuration !== '--' && $wsDuration !== '-') $descLines[] = "Duration: " . $wsDuration;
            if (!empty($wsPlace) && $wsPlace !== '--' && $wsPlace !== '-') $descLines[] = "Place: " . $wsPlace;
            if (!empty($wsDetails) && $wsDetails !== '--' && $wsDetails !== '-') $descLines[] = "Details: " . $wsDetails;
            $desc = implode("\n", $descLines);
            $extra_info = !empty($wsPlace) ? $wsPlace : '-';
        } elseif ($tab_name === 'experience') {
            $title = trim($_POST['title'] ?? '');
            $expPlace = trim($_POST['exp_place'] ?? $_POST['extra_info'] ?? '');
            $expJoin = trim($_POST['exp_join'] ?? '');
            $expLeave = trim($_POST['exp_leave'] ?? '');
            $expDept = trim($_POST['exp_dept'] ?? '');
            $expDuration = trim($_POST['exp_duration'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($title)) {
                setFlashMessage('error', 'Designation is mandatory!');
                header('Location: principal-profile.php?tab=tab_items&subtab=experience');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'experience'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $descLines = [];
            if (!empty($expJoin) && $expJoin !== '--' && $expJoin !== '-') $descLines[] = "Date of Joining: " . $expJoin;
            if (!empty($expLeave) && $expLeave !== '--' && $expLeave !== '-') $descLines[] = "Date of Leave: " . $expLeave;
            if (!empty($expDept) && $expDept !== '--' && $expDept !== '-') $descLines[] = "Department: " . $expDept;
            if (!empty($expDuration) && $expDuration !== '--' && $expDuration !== '-') $descLines[] = "Duration: " . $expDuration;
            if (!empty($expPlace) && $expPlace !== '--' && $expPlace !== '-') $descLines[] = "Place: " . $expPlace;
            $desc = implode("\n", $descLines);
            $extra_info = !empty($expPlace) ? $expPlace : '-';
        } elseif ($tab_name === 'achievements') {
            $achDetails = trim($_POST['details_text'] ?? $_POST['description'] ?? $_POST['title'] ?? '');
            $extra_info = trim($_POST['extra_info'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($achDetails)) {
                setFlashMessage('error', 'Achievement details cannot be empty!');
                header('Location: principal-profile.php?tab=tab_items&subtab=achievements');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'achievements'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $title = mb_substr($achDetails, 0, 250);
            $desc = $achDetails;
        } elseif ($tab_name === 'dissertation') {
            $title = trim($_POST['title'] ?? '');
            $student = trim($_POST['student'] ?? $_POST['extra_info'] ?? '');
            $dissYear = trim($_POST['diss_year'] ?? '');
            $dissDetails = trim($_POST['diss_details'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($title)) {
                setFlashMessage('error', 'Thesis / Research Title is mandatory!');
                header('Location: principal-profile.php?tab=tab_items&subtab=dissertation');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'dissertation'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $descLines = [];
            if (!empty($dissYear) && $dissYear !== '--' && $dissYear !== '-') $descLines[] = "Year: " . $dissYear;
            if (!empty($student) && $student !== '--' && $student !== '-') $descLines[] = "Student: " . $student;
            if (!empty($dissDetails) && $dissDetails !== '--' && $dissDetails !== '-') $descLines[] = "Details: " . $dissDetails;
            $desc = implode("\n", $descLines);
            $extra_info = !empty($student) ? $student : '-';
        } elseif ($tab_name === 'membership') {
            $memDetails = trim($_POST['details_text'] ?? $_POST['description'] ?? $_POST['title'] ?? '');
            $extra_info = trim($_POST['extra_info'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($memDetails)) {
                setFlashMessage('error', 'Membership details cannot be empty!');
                header('Location: principal-profile.php?tab=tab_items&subtab=membership');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'membership'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $title = mb_substr($memDetails, 0, 250);
            $desc = $memDetails;
        } elseif ($tab_name === 'patents') {
            $title = trim($_POST['title'] ?? '');
            $patDetails = trim($_POST['patent_details'] ?? $_POST['description'] ?? '');
            $extra_info = trim($_POST['extra_info'] ?? '');
            $order = (int)($_POST['display_order'] ?? 0);

            if (empty($title)) {
                setFlashMessage('error', 'Patent Title is mandatory!');
                header('Location: principal-profile.php?tab=tab_items&subtab=patents');
                exit;
            }

            if ($order === 0) {
                $maxStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 FROM principal_tab_items WHERE tab_name = 'patents'");
                $order = (int)$maxStmt->fetchColumn();
            }

            $desc = !empty($patDetails) ? $patDetails : $title;
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
    // Auto-seed workshops if not present
    $wsChk = $pdo->query("SELECT COUNT(*) FROM principal_tab_items WHERE tab_name = 'workshops'")->fetchColumn();
    if ($wsChk == 0) {
        $initialWorkshops = [
            [
                'title' => 'Organized One Day Workshop on Multi Varient Techniques',
                'extra_info' => 'S. S. Engineering College, Bhavnagar',
                'description' => "Year: 2015\nDuration: 26-June-2015\nPlace: S. S. Engineering College, Bhavnagar\nDetails: Name of Expert : Prof. M. K. Barua, IIT Roorkee, Under TQIP-II",
                'display_order' => 1
            ],
            [
                'title' => 'Organized One week STTP on Product Design by Solid Works',
                'extra_info' => 'S. S. Engineering College, Bhavnagar',
                'description' => "Year: 2015\nDuration: 12-16 Oct 2015\nPlace: S. S. Engineering College, Bhavnagar\nDetails: -",
                'display_order' => 2
            ],
            [
                'title' => 'Worked as Co-coordinator of Entrepreneurship and Management Development Center',
                'extra_info' => 'Government Engineering College Modasa',
                'description' => "Year: 2003\nDuration: -\nPlace: Government Engineering College Modasa\nDetails: Sponsored by AICTE, New Delhi",
                'display_order' => 3
            ],
            [
                'title' => 'Organized "2-D State Level Workshop on Computer Based Diesel Engine Test Rig"',
                'extra_info' => '-',
                'description' => "Year: 2002\nDuration: 17th&18th October 2002\nPlace: -\nDetails: Sponsored by GUJCOST, Gandhinagar as a committee member.",
                'display_order' => 4
            ]
        ];
        $insStmt = $pdo->prepare("INSERT INTO principal_tab_items (tab_name, title, description, extra_info, display_order) VALUES ('workshops', ?, ?, ?, ?)");
        foreach ($initialWorkshops as $iw) {
            $insStmt->execute([$iw['title'], $iw['description'], $iw['extra_info'], $iw['display_order']]);
        }
    }

    // Auto-seed experience if not present
    $expChk = $pdo->query("SELECT COUNT(*) FROM principal_tab_items WHERE tab_name = 'experience'")->fetchColumn();
    if ($expChk == 0) {
        $initialExperience = [
            [
                'title' => 'Professor and Head in Mechanical Engineering',
                'extra_info' => 'Government Engineering College Modasa',
                'description' => "Date of Joining: 18-05-2022\nDate of Leave: Till Date\nDepartment: Mechanical Engineering\nDuration: -\nPlace: Government Engineering College Modasa",
                'display_order' => 1
            ],
            [
                'title' => 'Professor and Head in Mechanical Engineering',
                'extra_info' => 'Government Engineering College Palanpur',
                'description' => "Date of Joining: 01-04-2017\nDate of Leave: 17-05-2022\nDepartment: Mechanical Engineering\nDuration: 5 years 1 month\nPlace: Government Engineering College Palanpur",
                'display_order' => 2
            ],
            [
                'title' => 'Incharge Principal (CTE Order)',
                'extra_info' => 'Government Engineering College Palanpur',
                'description' => "Date of Joining: 04-02-2016\nDate of Leave: 31-03-2017\nDepartment: Mechanical Engineering\nDuration: 1 year 1 month\nPlace: Government Engineering College Palanpur",
                'display_order' => 3
            ],
            [
                'title' => 'Professor Mechanical (Promotion and Transfer)',
                'extra_info' => 'Government Engineering College Palanpur',
                'description' => "Date of Joining: 23-12-2015\nDate of Leave: 03-02-2016\nDepartment: Mechanical Engineering\nDuration: 1 months 11 days\nPlace: Government Engineering College Palanpur",
                'display_order' => 4
            ],
            [
                'title' => 'Associate Professor (Promotion)',
                'extra_info' => 'Shantilal Shah Engineering College, Bhavnagar',
                'description' => "Date of Joining: 15-07-2010\nDate of Leave: 22-12-2015\nDepartment: Mechanical Engineering\nDuration: 5 years 5 months\nPlace: Shantilal Shah Engineering College, Bhavnagar",
                'display_order' => 5
            ],
            [
                'title' => 'Lecturer',
                'extra_info' => 'Shantilal Shah Engineering College, Bhavnagar',
                'description' => "Date of Joining: 07-04-2004\nDate of Leave: 14-07-2010\nDepartment: Mechanical Engineering\nDuration: 6 years 1 months\nPlace: Shantilal Shah Engineering College, Bhavnagar",
                'display_order' => 6
            ],
            [
                'title' => 'Lecturer (GPSC Posting)',
                'extra_info' => 'Government Engineering College, Modasa',
                'description' => "Date of Joining: 05-04-2000\nDate of Leave: 06-12-2004\nDepartment: Mechanical Engineering\nDuration: 4 years 8 months\nPlace: Government Engineering College, Modasa",
                'display_order' => 7
            ],
            [
                'title' => 'Lecturer',
                'extra_info' => 'GCET, V V Nagar',
                'description' => "Date of Joining: 23-06-1998\nDate of Leave: 04-04-2000\nDepartment: Mechanical Engineering\nDuration: 1 years 9 months\nPlace: GCET, V V Nagar",
                'display_order' => 8
            ],
            [
                'title' => 'Lecturer',
                'extra_info' => 'Shantilal Shah Engineering College, Bhavnagar',
                'description' => "Date of Joining: 26-12-1995\nDate of Leave: 04-07-1996\nDepartment: Mechanical\nDuration: 6 months\nPlace: Shantilal Shah Engineering College, Bhavnagar",
                'display_order' => 9
            ]
        ];
        $insStmt = $pdo->prepare("INSERT INTO principal_tab_items (tab_name, title, description, extra_info, display_order) VALUES ('experience', ?, ?, ?, ?)");
        foreach ($initialExperience as $ie) {
            $insStmt->execute([$ie['title'], $ie['description'], $ie['extra_info'], $ie['display_order']]);
        }
    }

    // Auto-seed achievements if not present
    $achChk = $pdo->query("SELECT COUNT(*) FROM principal_tab_items WHERE tab_name = 'achievements'")->fetchColumn();
    if ($achChk == 0) {
        $initialAchievements = [
            [
                'title' => 'Patent for "Universal Centrifugal Casting Machine"',
                'extra_info' => 'Granted',
                'description' => 'Patent for "Universal Centrifugal Casting Machine" is Published in the Official Journal of The Patent Office. Publication Date: 17-12-2021, and Granted on 18/03/2024, Patent No: 528730, ID: 202121056480.',
                'display_order' => 1
            ],
            [
                'title' => 'Associate Dean, GTU',
                'extra_info' => 'GTU',
                'description' => 'Associate Dean, GTU from 25 May 2021 to 24 May 2024.',
                'display_order' => 2
            ],
            [
                'title' => 'Innovative Research Technologist & Dedicated Teaching Professional Awards',
                'extra_info' => 'ISME, Chennai',
                'description' => 'Received Innovative Research Technologist and Dedicated Teaching Professional Awards, ISME, Chennai Year-2021',
                'display_order' => 3
            ],
            [
                'title' => 'Global Faculty Award 2020',
                'extra_info' => 'AKS Education, New Delhi',
                'description' => 'Global Faculty Award 2020, AKS Education, New Delhi Year-2020',
                'display_order' => 4
            ],
            [
                'title' => 'Bharat Shiksharatan Award',
                'extra_info' => 'Delhi',
                'description' => 'Awarded Bharat Shiksharatan Award from Global Society for Health and Education Growth, Delhi, Year-2003.',
                'display_order' => 5
            ],
            [
                'title' => 'Nominated for Meritorious Educational Excellence Award',
                'extra_info' => 'Delhi',
                'description' => 'Nominated for the Meritorious Educational Excellence Award from Global Society for Health and Education Growth, Delhi, Year 2002-2003.',
                'display_order' => 6
            ],
            [
                'title' => 'Hari Ohm Ashram Prerit Bhaikaka Inter-University Smarak Trust Award',
                'extra_info' => '1998',
                'description' => 'Received Prestigious Hariohm Ashram PreritBhaikaka Inter-University Smarak Trust Award for the Best Publication of Petri nets Application to Project Management, Year-1998',
                'display_order' => 7
            ]
        ];
        $insStmt = $pdo->prepare("INSERT INTO principal_tab_items (tab_name, title, description, extra_info, display_order) VALUES ('achievements', ?, ?, ?, ?)");
        foreach ($initialAchievements as $ia) {
            $insStmt->execute([$ia['title'], $ia['description'], $ia['extra_info'], $ia['display_order']]);
        }
    }

    // Auto-seed dissertation if not present
    $dissChk = $pdo->query("SELECT COUNT(*) FROM principal_tab_items WHERE tab_name = 'dissertation'")->fetchColumn();
    if ($dissChk == 0) {
        $initialDissertation = [
            [
                'title' => 'Mechanical Engineering',
                'extra_info' => 'B M Trivedi',
                'description' => "Year: 2017\nStudent: B M Trivedi\nDetails: Rai Uni Ahemedabad",
                'display_order' => 1
            ],
            [
                'title' => 'Laser Beam Cladding',
                'extra_info' => 'Srushti Bhatt',
                'description' => "Year: 2024\nStudent: Srushti Bhatt\nDetails: Pursuing (Admission 2024)",
                'display_order' => 2
            ],
            [
                'title' => 'SME Industry Energy',
                'extra_info' => 'Meeta Chauhan',
                'description' => "Year: 2025\nStudent: Meeta Chauhan\nDetails: Submitted",
                'display_order' => 3
            ],
            [
                'title' => 'Engineer to Order',
                'extra_info' => 'Nimesh Soni',
                'description' => "Year: 2024\nStudent: Nimesh Soni\nDetails: GTU Ahmedabad 2024",
                'display_order' => 4
            ],
            [
                'title' => 'Sheet Metal Working',
                'extra_info' => 'Nimesh Patel',
                'description' => "Year: 2023\nStudent: Nimesh Patel\nDetails: GTU Ahmedabad 2023",
                'display_order' => 5
            ],
            [
                'title' => 'Centrifugal Casting',
                'extra_info' => 'Anand Patel',
                'description' => "Year: 2023\nStudent: Anand Patel\nDetails: GTU Ahmedabad 2023",
                'display_order' => 6
            ],
            [
                'title' => 'Metal Matrix Composite',
                'extra_info' => 'Mehul Mehta',
                'description' => "Year: 2023\nStudent: Mehul Mehta\nDetails: GTU Ahmedabad 2023",
                'display_order' => 7
            ],
            [
                'title' => 'Nylone Gear teeth Analysis',
                'extra_info' => 'Anand Kalani',
                'description' => "Year: 2023\nStudent: Anand Kalani\nDetails: GTU Ahmedabad 2023",
                'display_order' => 8
            ],
            [
                'title' => 'Machining Vibration and Condition Monitoring',
                'extra_info' => 'Narendra Patel',
                'description' => "Year: 2021\nStudent: Narendra Patel\nDetails: GTU Ahmedabad 2021",
                'display_order' => 9
            ],
            [
                'title' => 'Analysis of heat transfer in conical shell and circular tube heat exchanger',
                'extra_info' => 'Chirag Maradiya',
                'description' => "Year: 2020\nStudent: Chirag Maradiya\nDetails: GTU Chandkheda -Ahmedabad (Completed 2020)",
                'display_order' => 10
            ],
            [
                'title' => 'Sustainability in Manufacturing Process in Steel Re-rolling Mills',
                'extra_info' => 'Rita Jani',
                'description' => "Year: 2020\nStudent: Rita Jani\nDetails: GTU Chandkheda- Ahmedabad (Completed 2020)",
                'display_order' => 11
            ],
            [
                'title' => 'Minimization of sand casting defects by predicting and analyzing the process parameters',
                'extra_info' => 'Priyank Parekh',
                'description' => "Year: 2019\nStudent: Priyank Parekh\nDetails: RK University Rajkot, (Completed 2019)",
                'display_order' => 12
            ],
            [
                'title' => 'Evaluate furan no-bake binder system for quality casting and environmental aspects Year of notification',
                'extra_info' => 'Shailee Acharya',
                'description' => "Year: 2017\nStudent: Shailee Acharya\nDetails: RK University Rajkot (Completed 2017)",
                'display_order' => 13
            ]
        ];
        $insStmt = $pdo->prepare("INSERT INTO principal_tab_items (tab_name, title, description, extra_info, display_order) VALUES ('dissertation', ?, ?, ?, ?)");
        foreach ($initialDissertation as $idiss) {
            $insStmt->execute([$idiss['title'], $idiss['description'], $idiss['extra_info'], $idiss['display_order']]);
        }
    }

    // Auto-seed membership if not present
    $memChk = $pdo->query("SELECT COUNT(*) FROM principal_tab_items WHERE tab_name = 'membership'")->fetchColumn();
    if ($memChk == 0) {
        $initialMembership = [
            [
                'title' => 'Professional Member - ASME',
                'extra_info' => 'ASME',
                'description' => 'Professional Member - ASME, New York, ID 103778216., 05 May 2023',
                'display_order' => 1
            ],
            [
                'title' => 'Sr Member : SMISME',
                'extra_info' => 'SMISME',
                'description' => 'Sr Member : SMISME, SMISME20200207, 15 Feb 2020.',
                'display_order' => 2
            ],
            [
                'title' => 'Fellow : FSISRP',
                'extra_info' => 'FSISRP',
                'description' => 'Fellow : FSISRP, LM171899318, 15 Feb 2020',
                'display_order' => 3
            ],
            [
                'title' => 'Life Member : IA ENG',
                'extra_info' => 'IA ENG',
                'description' => 'Life Member : IA ENG, International Association of Engineers, Hong Kong,( M-245200)',
                'display_order' => 4
            ],
            [
                'title' => 'Member : ISTE',
                'extra_info' => 'ISTE',
                'description' => 'Member : ISTE, New Delhi (M-62770)',
                'display_order' => 5
            ],
            [
                'title' => 'Life Member : Institute of Engineers',
                'extra_info' => 'IEI',
                'description' => 'Life Member : Institute of Engineers, Kolkata(LM 146505-2)',
                'display_order' => 6
            ],
            [
                'title' => 'Life Member : Indian Institute of Industrial Engineering',
                'extra_info' => 'IIIE',
                'description' => 'Life Member : Indian Institute of Industrial Engineering, Mumbai (LM 9467)',
                'display_order' => 7
            ],
            [
                'title' => 'Life Fellow : Indian Institute of Production Engineers',
                'extra_info' => 'IIPE',
                'description' => 'Life Fellow : Indian Institute of Production Engineers, Bengaluru (W/LF/1364)',
                'display_order' => 8
            ]
        ];
        $insStmt = $pdo->prepare("INSERT INTO principal_tab_items (tab_name, title, description, extra_info, display_order) VALUES ('membership', ?, ?, ?, ?)");
        foreach ($initialMembership as $im) {
            $insStmt->execute([$im['title'], $im['description'], $im['extra_info'], $im['display_order']]);
        }
    }

    // Auto-seed patents if not present
    $patChk = $pdo->query("SELECT COUNT(*) FROM principal_tab_items WHERE tab_name = 'patents'")->fetchColumn();
    if ($patChk == 0) {
        $initialPatents = [
            [
                'title' => 'Patent for Universal Centrifugal Casting Machine',
                'extra_info' => 'Patent No: 528730',
                'description' => 'Patent for "Universal Centrifugal Casting Machine" is Published in the Official Journal of The Patent Office. Publication Date: 17-12-2021, and Granted on 18/03/2024, Patent No: 528730, ID: 202121056480.',
                'display_order' => 1
            ]
        ];
        $insStmt = $pdo->prepare("INSERT INTO principal_tab_items (tab_name, title, description, extra_info, display_order) VALUES ('patents', ?, ?, ?, ?)");
        foreach ($initialPatents as $ip) {
            $insStmt->execute([$ip['title'], $ip['description'], $ip['extra_info'], $ip['display_order']]);
        }
    }

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
    'books'        => 'Books',
    'editorial'    => 'Editorial',
    'expert_talks' => 'Expert Talks',
    'workshops'    => 'Workshops',
    'experience'   => 'Experience',
    'achievements' => 'Achievements',
    'dissertation' => 'Dissertation/Ph.D. Thesis Guidance',
    'membership'   => 'Membership',
    'patents'      => 'Patents'
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
    <div style="display: flex; gap: 8px; border-bottom: 2px solid #e2e8f0; margin-bottom: 24px; flex-wrap: wrap;">
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
                <div style="display: grid; grid-template-columns: minmax(0, 2fr) minmax(0, 1fr); gap: 16px; margin-bottom: 16px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Full Name &amp; Title <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($profile['name'] ?? 'Dr. JEETENDRAKUMAR VADHER') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Official Designation</label>
                        <input type="text" name="designation" class="form-control" value="<?= htmlspecialchars($profile['designation'] ?? 'Principal') ?>" required>
                    </div>
                </div>

                <!-- Row 2 -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 16px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Highest Qualification</label>
                        <input type="text" name="qualification" class="form-control" value="<?= htmlspecialchars($profile['qualification'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Experience</label>
                        <input type="text" name="experience" class="form-control" value="<?= htmlspecialchars($profile['experience'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Date of Joining</label>
                        <input type="text" name="date_of_joining" class="form-control" value="<?= htmlspecialchars($profile['date_of_joining'] ?? '') ?>">
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label">Area of Interest / Research Specialization</label>
                    <input type="text" name="area_of_interest" class="form-control" value="<?= htmlspecialchars($profile['area_of_interest'] ?? '') ?>">
                </div>

                <!-- Row 4: Official Contact -->
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label">Official Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($profile['email'] ?? '') ?>">
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

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 14px; margin-bottom: 18px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Degree / Qualification <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="qualification" class="form-control" required value="<?= htmlspecialchars($editQual['qualification'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">University / Board</label>
                        <input type="text" name="university_board" class="form-control" value="<?= htmlspecialchars($editQual['university_board'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Passing Year</label>
                        <input type="text" name="year_of_passing" class="form-control" value="<?= htmlspecialchars($editQual['year_of_passing'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Grade / CGPA</label>
                        <input type="text" name="percentage" class="form-control" value="<?= htmlspecialchars($editQual['percentage'] ?? '') ?>">
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
        $editTalkYear = '';
        $editTalkPlace = '';
        $editTalkDetails = '';
        $editWorkshopYear = '';
        $editWorkshopDuration = '';
        $editWorkshopPlace = '';
        $editWorkshopDetails = '';
        $editExpJoin = '';
        $editExpLeave = '';
        $editExpDept = '';
        $editExpDuration = '';
        $editExpPlace = '';
        $editDissYear = '';
        $editDissStudent = '';
        $editDissDetails = '';
        $editPatentDetails = '';
        $editDetailsText = '';

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
            } elseif ($subtab === 'expert_talks') {
                $editTalkPlace = $editItem['extra_info'] ?? '';
                $lines = explode("\n", $eDesc);
                foreach ($lines as $ln) {
                    $ln = trim($ln);
                    if (preg_match('/^Year:\s*(.*)$/i', $ln, $m)) $editTalkYear = trim($m[1]);
                    elseif (preg_match('/^Place:\s*(.*)$/i', $ln, $m)) $editTalkPlace = trim($m[1]);
                    elseif (preg_match('/^Details:\s*(.*)$/i', $ln, $m)) $editTalkDetails = trim($m[1]);
                }
                if (empty($editTalkDetails) && empty($editTalkYear) && !empty($eDesc) && !preg_match('/^(?:Year|Place|Details):/i', $eDesc)) {
                    $editTalkDetails = $eDesc;
                }
            } elseif ($subtab === 'workshops') {
                $editWorkshopPlace = $editItem['extra_info'] ?? '';
                if ($editWorkshopPlace === '-') $editWorkshopPlace = '';
                $lines = explode("\n", $eDesc);
                foreach ($lines as $ln) {
                    $ln = trim($ln);
                    if (preg_match('/^Year:\s*(.*)$/i', $ln, $m)) $editWorkshopYear = trim($m[1]);
                    elseif (preg_match('/^Duration:\s*(.*)$/i', $ln, $m)) $editWorkshopDuration = trim($m[1]);
                    elseif (preg_match('/^Place:\s*(.*)$/i', $ln, $m)) {
                        $p = trim($m[1]);
                        if ($p !== '-') $editWorkshopPlace = $p;
                    } elseif (preg_match('/^Details:\s*(.*)$/i', $ln, $m)) {
                        $d = trim($m[1]);
                        if ($d !== '-') $editWorkshopDetails = $d;
                    }
                }
                if (empty($editWorkshopDetails) && empty($editWorkshopYear) && empty($editWorkshopDuration) && !empty($eDesc) && !preg_match('/^(?:Year|Duration|Place|Details):/i', $eDesc)) {
                    $editWorkshopDetails = $eDesc;
                }
            } elseif ($subtab === 'experience') {
                $editExpPlace = $editItem['extra_info'] ?? '';
                if ($editExpPlace === '-') $editExpPlace = '';
                $lines = explode("\n", $eDesc);
                foreach ($lines as $ln) {
                    $ln = trim($ln);
                    if (preg_match('/^(?:Date of Joining|Joining):\s*(.*)$/i', $ln, $m)) $editExpJoin = trim($m[1]);
                    elseif (preg_match('/^(?:Date of Leave|Leave):\s*(.*)$/i', $ln, $m)) $editExpLeave = trim($m[1]);
                    elseif (preg_match('/^Department:\s*(.*)$/i', $ln, $m)) $editExpDept = trim($m[1]);
                    elseif (preg_match('/^Duration:\s*(.*)$/i', $ln, $m)) $editExpDuration = trim($m[1]);
                    elseif (preg_match('/^Place:\s*(.*)$/i', $ln, $m)) {
                        $p = trim($m[1]);
                        if ($p !== '-') $editExpPlace = $p;
                    }
                }
            } elseif ($subtab === 'achievements' || $subtab === 'membership') {
                $editDetailsText = !empty($eDesc) ? $eDesc : ($editItem['title'] ?? '');
            } elseif ($subtab === 'dissertation') {
                $editDissStudent = $editItem['extra_info'] ?? '';
                if ($editDissStudent === '-') $editDissStudent = '';
                $lines = explode("\n", $eDesc);
                foreach ($lines as $ln) {
                    $ln = trim($ln);
                    if (preg_match('/^Year:\s*(.*)$/i', $ln, $m)) $editDissYear = trim($m[1]);
                    elseif (preg_match('/^Student:\s*(.*)$/i', $ln, $m)) $editDissStudent = trim($m[1]);
                    elseif (preg_match('/^Details:\s*(.*)$/i', $ln, $m)) $editDissDetails = trim($m[1]);
                }
                if (empty($editDissDetails) && !empty($eDesc) && !preg_match('/^(?:Year|Student|Details):/i', $eDesc)) {
                    $editDissDetails = $eDesc;
                }
            } elseif ($subtab === 'patents') {
                $editPatentDetails = !empty($eDesc) ? $eDesc : ($editItem['title'] ?? '');
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

        <div id="item-form" style="background: <?= $editItem ? '#fffbeb' : '#f8fafc' ?>; border: 1px solid <?= $editItem ? '#fde68a' : '#e2e8f0' ?>; border-radius: 8px; padding: 22px; margin-bottom: 24px; max-width: 100%; box-sizing: border-box; overflow: hidden;">
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
                    <div style="display: grid; grid-template-columns: minmax(0, 3fr) minmax(0, 1fr); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Research Paper Title <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
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
                        <input type="text" name="pub_authors" class="form-control" value="<?= htmlspecialchars($editAuthors) ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label">Journal / Conference / ISSN / DOI / Citation</label>
                        <textarea name="pub_journal" class="form-control" rows="2"><?= htmlspecialchars($editJournal) ?></textarea>
                    </div>

                <?php elseif ($subtab === 'books'): ?>
                    <!-- Row 1: Book Title & Publisher Name (Both Mandatory) -->
                    <div style="display: grid; grid-template-columns: minmax(0, 3fr) minmax(0, 2fr); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Book Title / Name <span style="color: #ef4444; font-weight: bold;">*</span>
                            </label>
                            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Mandatory: Official book title or monograph name</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Publisher Name <span style="color: #ef4444; font-weight: bold;">*</span>
                            </label>
                            <input type="text" name="extra_info" class="form-control" required value="<?= htmlspecialchars($editItem['extra_info'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Mandatory: Publishing house or entity</small>
                        </div>
                    </div>

                    <!-- Row 2: University (Mandatory), Branch (Optional), Semester (Optional) -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                University <span style="color: #ef4444; font-weight: bold;">*</span>
                            </label>
                            <input type="text" name="book_univ" class="form-control" required value="<?= htmlspecialchars($editBookUniv) ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Mandatory: Affiliated university / board</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Branch <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="book_branch" class="form-control" value="<?= htmlspecialchars($editBookBranch) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Leave empty if not specified</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Semester <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="book_semester" class="form-control" value="<?= htmlspecialchars($editBookSemester) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Leave empty if not specified</small>
                        </div>
                    </div>

                    <!-- Row 3: Content/Edition (Optional), Book Code (Optional), ISBN Code (Optional) -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Content / Edition <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="book_content" class="form-control" value="<?= htmlspecialchars($editBookContent) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Edition details or curriculum scope</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Book Code <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="book_code" class="form-control" value="<?= htmlspecialchars($editBookCode) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Leave empty if not applicable</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                ISBN Code <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="book_isbn" class="form-control" value="<?= htmlspecialchars($editBookIsbn) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Leave empty if not assigned</small>
                        </div>
                    </div>

                <?php elseif ($subtab === 'editorial'): ?>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-weight: 600;">
                            Editorial Role, Journal / Committee &amp; Details <span style="color: #ef4444; font-weight: bold;">*</span>
                        </label>
                        <textarea name="editorial_text" class="form-control" rows="3" required><?= htmlspecialchars($editItem['description'] ?? $editItem['title'] ?? '') ?></textarea>
                        <small style="font-size: 11.5px; color: #64748b;">Mandatory: Full editorial board title, journal/conference name, ISSN, location, or date.</small>
                    </div>

                    <div style="display: grid; grid-template-columns: minmax(0, 2fr) minmax(0, 1fr); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Organization / Location / Tag <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="extra_info" class="form-control" value="<?= htmlspecialchars($editItem['extra_info'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Short tag, location, or institution</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Sr. No. / Display Order <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Controls sorting order (leave blank to auto-append)</small>
                        </div>
                    </div>

                <?php elseif ($subtab === 'expert_talks'): ?>
                    <!-- Row 1: Subject (Mandatory) & Place (Mandatory) -->
                    <div style="display: grid; grid-template-columns: minmax(0, 3fr) minmax(0, 2fr); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Subject / Lecture Title <span style="color: #ef4444; font-weight: bold;">*</span>
                            </label>
                            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Mandatory: Topic, keynote title, or subject</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Place / Host Institution <span style="color: #ef4444; font-weight: bold;">*</span>
                            </label>
                            <input type="text" name="talk_place" class="form-control" required value="<?= htmlspecialchars($editTalkPlace) ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Mandatory: Venue, department, college, or online platform</small>
                        </div>
                    </div>

                    <!-- Row 2: Year (Optional), Details (Optional), Sr. No. (Optional) -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Year <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="talk_year" class="form-control" value="<?= htmlspecialchars($editTalkYear) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Delivery year</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Details / Audience / Remarks <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="talk_details" class="form-control" value="<?= htmlspecialchars($editTalkDetails) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Audience, session details, or remarks</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Sr. No. / Order <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Sorting order</small>
                        </div>
                    </div>

                <?php elseif ($subtab === 'workshops'): ?>
                    <!-- Row 1: Subject (Mandatory) & Place (Optional) -->
                    <div style="display: grid; grid-template-columns: minmax(0, 3fr) minmax(0, 2fr); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Subject / Workshop Title <span style="color: #ef4444; font-weight: bold;">*</span>
                            </label>
                            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Mandatory: Workshop, STTP, or seminar topic / title</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Place / Host Institution <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="workshop_place" class="form-control" value="<?= htmlspecialchars($editWorkshopPlace) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Host college, venue, or department (leave empty if not applicable)</small>
                        </div>
                    </div>

                    <!-- Row 2: Year (Optional), Duration (Optional), Details (Optional), Sr. No. (Optional) -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Year <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="workshop_year" class="form-control" value="<?= htmlspecialchars($editWorkshopYear) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Event year</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Duration / Dates <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="workshop_duration" class="form-control" value="<?= htmlspecialchars($editWorkshopDuration) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Specific dates or duration</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Details / Sponsor / Expert <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="workshop_details" class="form-control" value="<?= htmlspecialchars($editWorkshopDetails) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Sponsorship, expert details, or role</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Sr. No. / Order <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Sorting order</small>
                        </div>
                    </div>

                <?php elseif ($subtab === 'experience'): ?>
                    <!-- Row 1: Designation (Mandatory) & Place (Optional) -->
                    <div style="display: grid; grid-template-columns: minmax(0, 3fr) minmax(0, 2fr); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Designation / Role <span style="color: #ef4444; font-weight: bold;">*</span>
                            </label>
                            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Mandatory: Official job title or administrative designation</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Place / College / Institution <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="exp_place" class="form-control" value="<?= htmlspecialchars($editExpPlace) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">College, university, or organization name</small>
                        </div>
                    </div>

                    <!-- Row 2: Joining, Leave, Department, Duration, Order -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Date of Joining <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="exp_join" class="form-control" value="<?= htmlspecialchars($editExpJoin) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Joining date</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Date of Leave <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="exp_leave" class="form-control" value="<?= htmlspecialchars($editExpLeave) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Relieving date or Till Date</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Department <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="exp_dept" class="form-control" value="<?= htmlspecialchars($editExpDept) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Academic department</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Duration <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="exp_duration" class="form-control" value="<?= htmlspecialchars($editExpDuration) ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Total tenure</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Sr. No. / Order <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #94a3b8;">Sorting order</small>
                        </div>
                    </div>

                <?php elseif ($subtab === 'achievements'): ?>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-weight: 600;">
                            Achievement Details / Award Citation <span style="color: #ef4444; font-weight: bold;">*</span>
                        </label>
                        <textarea name="details_text" class="form-control" rows="3" required><?= htmlspecialchars($editDetailsText) ?></textarea>
                        <small style="font-size: 11.5px; color: #64748b;">Full achievement citation as displayed on the public profile table</small>
                    </div>

                    <div style="display: grid; grid-template-columns: minmax(0, 3fr) minmax(0, 1fr); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Awarding Body / Organization <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="extra_info" class="form-control" value="<?= htmlspecialchars($editItem['extra_info'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Optional reference tag</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Sr. No. / Order <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Sorting order</small>
                        </div>
                    </div>

                <?php elseif ($subtab === 'dissertation'): ?>
                    <div style="display: grid; grid-template-columns: minmax(0, 3fr) minmax(0, 2fr); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Research / Thesis Title <span style="color: #ef4444; font-weight: bold;">*</span>
                            </label>
                            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Title of the Ph.D. or Master's research work</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Student / Scholar Name <span style="color: #ef4444; font-weight: bold;">*</span>
                            </label>
                            <input type="text" name="student" class="form-control" required value="<?= htmlspecialchars($editDissStudent) ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Name of the scholar supervised</small>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 120px minmax(0, 3fr) 120px; gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">Year</label>
                            <input type="text" name="diss_year" class="form-control" value="<?= htmlspecialchars($editDissYear) ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Academic year</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">Details / Status / University</label>
                            <input type="text" name="diss_details" class="form-control" value="<?= htmlspecialchars($editDissDetails) ?>">
                            <small style="font-size: 11.5px; color: #64748b;">University name, status (Completed, Submitted, Pursuing)</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">Order</label>
                            <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Sorting order</small>
                        </div>
                    </div>

                <?php elseif ($subtab === 'membership'): ?>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-weight: 600;">
                            Membership Citation &amp; Details <span style="color: #ef4444; font-weight: bold;">*</span>
                        </label>
                        <textarea name="details_text" class="form-control" rows="3" required><?= htmlspecialchars($editDetailsText) ?></textarea>
                        <small style="font-size: 11.5px; color: #64748b;">Full professional body membership title, organization, and ID</small>
                    </div>

                    <div style="display: grid; grid-template-columns: minmax(0, 3fr) minmax(0, 1fr); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Body / Society Tag <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="extra_info" class="form-control" value="<?= htmlspecialchars($editItem['extra_info'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Short abbreviation</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Sr. No. / Order <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Sorting order</small>
                        </div>
                    </div>

                <?php elseif ($subtab === 'patents'): ?>
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-weight: 600;">
                            Patent Title <span style="color: #ef4444; font-weight: bold;">*</span>
                        </label>
                        <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                        <small style="font-size: 11.5px; color: #64748b;">Official title of the invention or patent</small>
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-weight: 600;">
                            Patent Details, Grant &amp; Publication Info <span style="color: #ef4444; font-weight: bold;">*</span>
                        </label>
                        <textarea name="patent_details" class="form-control" rows="3" required><?= htmlspecialchars($editPatentDetails) ?></textarea>
                        <small style="font-size: 11.5px; color: #64748b;">Full grant number, application ID, publication journal, and dates</small>
                    </div>

                    <div style="display: grid; grid-template-columns: minmax(0, 3fr) minmax(0, 1fr); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Patent No. / Status Tag <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="text" name="extra_info" class="form-control" value="<?= htmlspecialchars($editItem['extra_info'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Patent number or status badge</small>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">
                                Sr. No. / Order <span style="color: #94a3b8; font-weight: normal;">(Optional)</span>
                            </label>
                            <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order'] ?? '') ?>">
                            <small style="font-size: 11.5px; color: #64748b;">Sorting order</small>
                        </div>
                    </div>

                <?php else: ?>
                    <div style="display: grid; grid-template-columns: minmax(0, 3fr) minmax(0, 1.5fr) minmax(0, 110px); gap: 16px; margin-bottom: 16px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">Title / Citation <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">Extra Info</label>
                            <input type="text" name="extra_info" class="form-control" value="<?= htmlspecialchars($editItem['extra_info'] ?? '') ?>">
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600;">Order</label>
                            <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-weight: 600;">Full Description / Abstract</label>
                        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
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
                        <th>
                            <?php
                            if ($subtab === 'books') echo 'Book Title / Monograph';
                            elseif ($subtab === 'editorial') echo 'Editorial Role & Details';
                            elseif ($subtab === 'expert_talks') echo 'Subject / Lecture Title';
                            elseif ($subtab === 'workshops') echo 'Subject / Workshop Title';
                            elseif ($subtab === 'experience') echo 'Designation / Role';
                            elseif ($subtab === 'achievements') echo 'Award / Achievement Title';
                            elseif ($subtab === 'dissertation') echo 'Candidate & Thesis Topic';
                            elseif ($subtab === 'membership') echo 'Professional Body / Society';
                            elseif ($subtab === 'patents') echo 'Patent / Invention Title';
                            else echo 'Title / Citation';
                            ?>
                        </th>
                        <th>
                            <?php
                            if ($subtab === 'books') echo 'Publisher';
                            elseif ($subtab === 'editorial') echo 'Organization / Location';
                            elseif ($subtab === 'expert_talks' || $subtab === 'workshops' || $subtab === 'experience') echo 'Place / Institution';
                            elseif ($subtab === 'achievements') echo 'Awarding Body / Year';
                            elseif ($subtab === 'dissertation') echo 'Degree & Status';
                            elseif ($subtab === 'membership') echo 'Grade / ID';
                            elseif ($subtab === 'patents') echo 'Application / Patent No.';
                            else echo 'Journal / Publisher / Date';
                            ?>
                        </th>
                        <th>
                            <?php
                            if ($subtab === 'books') echo 'University, Edition & Details';
                            elseif ($subtab === 'editorial') echo 'Editorial Summary';
                            elseif ($subtab === 'expert_talks') echo 'Year & Details';
                            elseif ($subtab === 'workshops') echo 'Year, Duration & Details';
                            elseif ($subtab === 'experience') echo 'Joining, Leave, Dept & Duration';
                            elseif ($subtab === 'achievements') echo 'Details & Recognition';
                            elseif ($subtab === 'dissertation') echo 'University & Guidance Details';
                            elseif ($subtab === 'membership') echo 'Tenure & Association Details';
                            elseif ($subtab === 'patents') echo 'Inventors & Scope';
                            else echo 'Description';
                            ?>
                        </th>
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
                                    <?php if ($subtab === 'editorial' || $subtab === 'achievements' || $subtab === 'membership'): ?>
                                        <?= htmlspecialchars(mb_strimwidth(!empty($item['description']) ? $item['description'] : $item['title'], 0, 95, '...')) ?>
                                    <?php else: ?>
                                        <?= htmlspecialchars($item['title']) ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($item['extra_info']) && $item['extra_info'] !== '-'): ?>
                                        <span style="font-weight: 600; color: #1e40af; background: #eff6ff; padding: 2px 8px; border-radius: 4px; font-size: 12px; border: 1px solid #bfdbfe;">
                                            <?= htmlspecialchars($item['extra_info']) ?>
                                        </span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td style="font-size: 13px; color: #475569; max-width: 340px;">
                                    <?php 
                                    if ($subtab === 'expert_talks') {
                                        $tDesc = $item['description'] ?? '';
                                        $y = '';
                                        $d = '';
                                        foreach (explode("\n", $tDesc) as $ln) {
                                            if (preg_match('/^Year:\s*(.*)$/i', $ln, $m)) $y = trim($m[1]);
                                            elseif (preg_match('/^Details:\s*(.*)$/i', $ln, $m)) $d = trim($m[1]);
                                        }
                                        $parts = [];
                                        if (!empty($y)) $parts[] = '<strong>Year: ' . htmlspecialchars($y) . '</strong>';
                                        if (!empty($d)) $parts[] = htmlspecialchars($d);
                                        echo !empty($parts) ? implode(' • ', $parts) : '<span style="color: #94a3b8;">-</span>';
                                    } elseif ($subtab === 'workshops') {
                                        $wDesc = $item['description'] ?? '';
                                        $y = '';
                                        $dur = '';
                                        $d = '';
                                        foreach (explode("\n", $wDesc) as $ln) {
                                            if (preg_match('/^Year:\s*(.*)$/i', $ln, $m)) $y = trim($m[1]);
                                            elseif (preg_match('/^Duration:\s*(.*)$/i', $ln, $m)) $dur = trim($m[1]);
                                            elseif (preg_match('/^Details:\s*(.*)$/i', $ln, $m)) $d = trim($m[1]);
                                        }
                                        $parts = [];
                                        if (!empty($y) && $y !== '-') $parts[] = '<strong>Year: ' . htmlspecialchars($y) . '</strong>';
                                        if (!empty($dur) && $dur !== '-') $parts[] = '<span style="color: #0369a1;"><i class="fas fa-calendar-alt"></i> ' . htmlspecialchars($dur) . '</span>';
                                        if (!empty($d) && $d !== '-') $parts[] = htmlspecialchars($d);
                                        echo !empty($parts) ? implode(' • ', $parts) : '<span style="color: #94a3b8;">-</span>';
                                    } elseif ($subtab === 'experience') {
                                        $eDesc = $item['description'] ?? '';
                                        $j = '';
                                        $l = '';
                                        $dept = '';
                                        $dur = '';
                                        foreach (explode("\n", $eDesc) as $ln) {
                                            if (preg_match('/^(?:Date of Joining|Joining):\s*(.*)$/i', $ln, $m)) $j = trim($m[1]);
                                            elseif (preg_match('/^(?:Date of Leave|Leave):\s*(.*)$/i', $ln, $m)) $l = trim($m[1]);
                                            elseif (preg_match('/^Department:\s*(.*)$/i', $ln, $m)) $dept = trim($m[1]);
                                            elseif (preg_match('/^Duration:\s*(.*)$/i', $ln, $m)) $dur = trim($m[1]);
                                        }
                                        $parts = [];
                                        if (!empty($j) || !empty($l)) {
                                            $leaveTag = (strcasecmp($l, 'Till Date') === 0) 
                                                ? '<span style="background: #ecfdf5; color: #047857; font-weight: 700; font-size: 11px; padding: 1px 5px; border-radius: 3px;">Till Date</span>'
                                                : htmlspecialchars($l);
                                            $parts[] = '<strong>' . htmlspecialchars($j) . ' &rarr; ' . $leaveTag . '</strong>';
                                        }
                                        if (!empty($dept) && $dept !== '-') $parts[] = htmlspecialchars($dept);
                                        if (!empty($dur) && $dur !== '-') $parts[] = '<span style="color: #0369a1;"><i class="fas fa-hourglass-half"></i> ' . htmlspecialchars($dur) . '</span>';
                                        echo !empty($parts) ? implode(' • ', $parts) : '<span style="color: #94a3b8;">-</span>';
                                    } elseif ($subtab === 'dissertation') {
                                        $dDesc = $item['description'] ?? '';
                                        $y = '';
                                        $det = '';
                                        foreach (explode("\n", $dDesc) as $ln) {
                                            if (preg_match('/^Year:\s*(.*)$/i', $ln, $m)) $y = trim($m[1]);
                                            elseif (preg_match('/^Details:\s*(.*)$/i', $ln, $m)) $det = trim($m[1]);
                                        }
                                        if (empty($det) && !empty($dDesc) && !preg_match('/^(?:Year|Student|Details):/i', $dDesc)) {
                                            $det = $dDesc;
                                        }
                                        $parts = [];
                                        if (!empty($y) && $y !== '-') $parts[] = '<strong>Year: ' . htmlspecialchars($y) . '</strong>';
                                        if (!empty($det) && $det !== '-') $parts[] = htmlspecialchars($det);
                                        echo !empty($parts) ? implode(' • ', $parts) : '<span style="color: #94a3b8;">-</span>';
                                    } elseif ($subtab === 'patents') {
                                        echo htmlspecialchars(mb_strimwidth(!empty($item['description']) ? $item['description'] : ($item['title'] ?? ''), 0, 110, '...'));
                                    } else {
                                        echo htmlspecialchars(str_replace("\n", " • ", mb_strimwidth(!empty($item['description']) ? $item['description'] : ($item['title'] ?? ''), 0, 110, '...')));
                                    }
                                    ?>
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
