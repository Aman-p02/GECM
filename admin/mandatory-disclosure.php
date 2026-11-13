<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage Mandatory Disclosures & Committees";
$current_page = 'mandatory-disclosure';

$activeTab = $_GET['tab'] ?? 'disclosures'; // 'disclosures' or 'committees'
$selectedCommittee = $_GET['committee'] ?? 'anti-ragging';

// Categories list
$disclosureCategories = [
    'RTI Pro-Active Disclosure' => 'RTI Pro-Active Disclosure',
    'AICTE Mandatory Disclosure' => 'AICTE Mandatory Disclosure',
    'Financial Statements' => 'Financial Statements',
    'Accreditation' => 'Accreditation',
    'Institute Establishment Resolution' => 'Institute Establishment Resolution',
    'RTI Booklet (2005)' => 'RTI Booklet (2005)',
    'Other Statutory Disclosures' => 'Other Statutory Disclosures'
];

$committeesList = [
    'anti-ragging' => 'Anti-Ragging Committee',
    'sexual-harassment' => 'Sexual Harassment Committee',
    'women-development-cell' => 'Women development Cell'
];

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: mandatory-disclosure.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    // ==========================================
    // DISCLOSURE PDF ACTIONS
    // ==========================================
    if ($action === 'add_document') {
        $category = trim($_POST['category'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $academic_year = trim($_POST['academic_year'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($category) || empty($title)) {
            setFlashMessage('danger', 'Category and document title are required.');
            header('Location: mandatory-disclosure.php?tab=disclosures');
            exit;
        }

        $upload = handlePdfUpload('pdf_file', 'disclosures');
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: mandatory-disclosure.php?tab=disclosures');
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO mandatory_disclosures (category, title, academic_year, file_path, file_size, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$category, $title, $academic_year, $upload['path'], $upload['file_size'] ?? null, $display_order, $is_active]);

        setFlashMessage('success', 'Mandatory disclosure PDF uploaded successfully!');
        header('Location: mandatory-disclosure.php?tab=disclosures');
        exit;

    } elseif ($action === 'edit_document') {
        $id = (int)($_POST['id'] ?? 0);
        $category = trim($_POST['category'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $academic_year = trim($_POST['academic_year'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_file = trim($_POST['existing_file'] ?? '');

        if (empty($category) || empty($title) || $id <= 0) {
            setFlashMessage('danger', 'Valid ID, category, and document title are required.');
            header('Location: mandatory-disclosure.php?tab=disclosures');
            exit;
        }

        $file_path = $existing_file;
        $file_size = null;

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $upload = handlePdfUpload('pdf_file', 'disclosures', $existing_file);
            if ($upload['success']) {
                $file_path = $upload['path'];
                $file_size = $upload['file_size'] ?? null;
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: mandatory-disclosure.php?tab=disclosures&edit_doc=' . $id);
                exit;
            }
        }

        if ($file_size) {
            $stmt = $pdo->prepare("UPDATE mandatory_disclosures SET category = ?, title = ?, academic_year = ?, file_path = ?, file_size = ?, display_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$category, $title, $academic_year, $file_path, $file_size, $display_order, $is_active, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE mandatory_disclosures SET category = ?, title = ?, academic_year = ?, file_path = ?, display_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$category, $title, $academic_year, $file_path, $display_order, $is_active, $id]);
        }

        setFlashMessage('success', 'Mandatory disclosure document updated successfully!');
        header('Location: mandatory-disclosure.php?tab=disclosures');
        exit;

    } elseif ($action === 'delete_document') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("SELECT file_path FROM mandatory_disclosures WHERE id = ?");
            $stmt->execute([$id]);
            $doc = $stmt->fetch();
            if ($doc && !empty($doc['file_path'])) {
                $realFile = realpath(__DIR__ . '/../' . $doc['file_path']);
                if ($realFile && file_exists($realFile)) {
                    @unlink($realFile);
                }
            }

            $del = $pdo->prepare("DELETE FROM mandatory_disclosures WHERE id = ?");
            $del->execute([$id]);
            setFlashMessage('success', 'Document deleted successfully.');
        }
        header('Location: mandatory-disclosure.php?tab=disclosures');
        exit;

    } elseif ($action === 'toggle_doc_status') {
        $id = (int)($_POST['id'] ?? 0);
        $status = (int)($_POST['status'] ?? 0);
        $new_status = ($status === 1) ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE mandatory_disclosures SET is_active = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
        setFlashMessage('success', 'Document status updated.');
        header('Location: mandatory-disclosure.php?tab=disclosures');
        exit;

    // ==========================================
    // CAMPUS COMMITTEE ACTIONS
    // ==========================================
    } elseif ($action === 'update_committee_info') {
        $slug = trim($_POST['committee_slug'] ?? '');
        $cname = trim($_POST['committee_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $objectives = trim($_POST['objectives'] ?? '');
        $vision = trim($_POST['vision'] ?? '');
        $mission = trim($_POST['mission'] ?? '');

        if (!empty($slug) && !empty($cname)) {
            $stmt = $pdo->prepare("UPDATE campus_committees SET committee_name = ?, description = ?, objectives = ?, vision = ?, mission = ? WHERE committee_slug = ?");
            $stmt->execute([$cname, $description, $objectives, $vision, $mission, $slug]);
            setFlashMessage('success', 'Committee details updated successfully!');
        } else {
            setFlashMessage('danger', 'Committee slug and name are required.');
        }
        header('Location: mandatory-disclosure.php?tab=committees&committee=' . urlencode($slug));
        exit;

    } elseif ($action === 'add_member') {
        $slug = trim($_POST['committee_slug'] ?? '');
        $sr_no = (int)($_POST['sr_no'] ?? 1);
        $faculty_name = trim($_POST['faculty_name'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $role_or_email = trim($_POST['role_or_email'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? $sr_no);

        if (!empty($slug) && !empty($faculty_name)) {
            $stmt = $pdo->prepare("INSERT INTO campus_committee_members (committee_slug, sr_no, faculty_name, designation, role_or_email, display_order) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$slug, $sr_no, $faculty_name, $designation, $role_or_email, $display_order]);
            setFlashMessage('success', 'Committee member added successfully!');
        } else {
            setFlashMessage('danger', 'Faculty name is required.');
        }
        header('Location: mandatory-disclosure.php?tab=committees&committee=' . urlencode($slug));
        exit;

    } elseif ($action === 'edit_member') {
        $member_id = (int)($_POST['member_id'] ?? 0);
        $slug = trim($_POST['committee_slug'] ?? '');
        $sr_no = (int)($_POST['sr_no'] ?? 1);
        $faculty_name = trim($_POST['faculty_name'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $role_or_email = trim($_POST['role_or_email'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? $sr_no);

        if ($member_id > 0 && !empty($faculty_name)) {
            $stmt = $pdo->prepare("UPDATE campus_committee_members SET sr_no = ?, faculty_name = ?, designation = ?, role_or_email = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$sr_no, $faculty_name, $designation, $role_or_email, $display_order, $member_id]);
            setFlashMessage('success', 'Committee member updated successfully!');
        }
        header('Location: mandatory-disclosure.php?tab=committees&committee=' . urlencode($slug));
        exit;

    } elseif ($action === 'delete_member') {
        $member_id = (int)($_POST['member_id'] ?? 0);
        $slug = trim($_POST['committee_slug'] ?? '');
        if ($member_id > 0) {
            $stmt = $pdo->prepare("DELETE FROM campus_committee_members WHERE id = ?");
            $stmt->execute([$member_id]);
            setFlashMessage('success', 'Committee member removed.');
        }
        header('Location: mandatory-disclosure.php?tab=committees&committee=' . urlencode($slug));
        exit;
    }
}

// Fetch document for editing if requested
$editDoc = null;
if (isset($_GET['edit_doc']) && (int)$_GET['edit_doc'] > 0 && $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM mandatory_disclosures WHERE id = ?");
    $stmt->execute([(int)$_GET['edit_doc']]);
    $editDoc = $stmt->fetch();
}

// Fetch member for editing if requested
$editMember = null;
if (isset($_GET['edit_member']) && (int)$_GET['edit_member'] > 0 && $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM campus_committee_members WHERE id = ?");
    $stmt->execute([(int)$_GET['edit_member']]);
    $editMember = $stmt->fetch();
}

// Fetch all documents
$documents = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM mandatory_disclosures ORDER BY category ASC, display_order ASC, id DESC");
    $documents = $stmt->fetchAll();
}

// Fetch current committee info and members
$currentCommitteeInfo = null;
$committeeMembers = [];
if ($pdo && !empty($selectedCommittee)) {
    $stmt = $pdo->prepare("SELECT * FROM campus_committees WHERE committee_slug = ?");
    $stmt->execute([$selectedCommittee]);
    $currentCommitteeInfo = $stmt->fetch();

    $stmt2 = $pdo->prepare("SELECT * FROM campus_committee_members WHERE committee_slug = ? ORDER BY sr_no ASC, display_order ASC, id ASC");
    $stmt2->execute([$selectedCommittee]);
    $committeeMembers = $stmt2->fetchAll();
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 24px;">
    <!-- Top Action Bar (No Duplicate Title) -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 14px; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <p style="font-size: 13.5px; color: #64748b; margin: 0;">Upload statutory regulatory PDFs (RTI, AICTE, Accreditation) and manage Campus Committees.</p>
        <a href="../mandatory-disclosure.php" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; font-size: 12.5px;">
            <i class="fas fa-external-link-alt"></i> View Public Page
        </a>
    </div>

    <!-- Navigation Tabs -->
    <div style="display: flex; gap: 8px; border-bottom: 2px solid #e2e8f0; margin-bottom: 24px;">
        <a href="mandatory-disclosure.php?tab=disclosures" 
           style="padding: 9px 18px; font-weight: 600; font-size: 14px; text-decoration: none; border-bottom: 3px solid <?= ($activeTab === 'disclosures') ? '#1e90ff' : 'transparent' ?>; color: <?= ($activeTab === 'disclosures') ? '#1e90ff' : '#64748b' ?>; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-file-pdf"></i> Mandatory Disclosure Documents (PDF)
        </a>
        <a href="mandatory-disclosure.php?tab=committees" 
           style="padding: 9px 18px; font-weight: 600; font-size: 14px; text-decoration: none; border-bottom: 3px solid <?= ($activeTab === 'committees') ? '#1e90ff' : 'transparent' ?>; color: <?= ($activeTab === 'committees') ? '#1e90ff' : '#64748b' ?>; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-users-cog"></i> Campus Committees (Anti-Ragging, WDC, ICC)
        </a>
    </div>

    <?php if ($activeTab === 'disclosures'): ?>
        <!-- ============================================================= -->
        <!-- TAB 1: MANDATORY DISCLOSURE STATUTORY DOCUMENTS (PDF)        -->
        <!-- ============================================================= -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
            <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
                <i class="fas <?= $editDoc ? 'fa-edit' : 'fa-plus-circle' ?>" style="color: #1e90ff;"></i>
                <?= $editDoc ? 'Edit Disclosure Document' : 'Upload New Mandatory Disclosure (PDF)' ?>
            </h3>

            <form action="mandatory-disclosure.php?tab=disclosures" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="<?= $editDoc ? 'edit_document' : 'add_document' ?>">
                <?php if ($editDoc): ?>
                    <input type="hidden" name="id" value="<?= $editDoc['id'] ?>">
                    <input type="hidden" name="existing_file" value="<?= htmlspecialchars($editDoc['file_path']) ?>">
                <?php endif; ?>

                <div style="display: grid; grid-template-columns: 1.3fr 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Statutory Category <span style="color: #ef4444;">*</span></label>
                        <select name="category" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            <?php foreach ($disclosureCategories as $catKey => $catLabel): ?>
                                <option value="<?= htmlspecialchars($catKey) ?>" <?= ($editDoc && $editDoc['category'] === $catKey) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($catLabel) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Document Title <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. AICTE Mandatory Disclosure (Approval 2024-25)" required value="<?= htmlspecialchars($editDoc['title'] ?? '') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Academic Cycle / Year</label>
                        <input type="text" name="academic_year" class="form-control" placeholder="e.g. 2024-25" value="<?= htmlspecialchars($editDoc['academic_year'] ?? '') ?>">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px; margin-bottom: 20px; align-items: flex-start;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">PDF Document File <?= $editDoc ? '' : '<span style="color: #ef4444;">*</span>' ?></label>
                        <input type="file" name="pdf_file" class="form-control" accept=".pdf" <?= $editDoc ? '' : 'required' ?> style="padding: 5px 8px; font-size: 13px;">
                        <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">PDF format only. Maximum size: 25MB.</div>
                        <?php if ($editDoc && !empty($editDoc['file_path'])): ?>
                            <div style="margin-top: 4px; font-size: 12px;">
                                <a href="../<?= htmlspecialchars($editDoc['file_path']) ?>" target="_blank" style="color: #1e90ff;">
                                    <i class="fas fa-file-pdf"></i> Current: <?= htmlspecialchars($editDoc['file_size'] ?? 'PDF') ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Priority Order</label>
                        <input type="number" name="display_order" class="form-control" value="<?= htmlspecialchars($editDoc['display_order'] ?? '0') ?>">
                    </div>

                    <div class="form-group" style="margin-bottom: 0; padding-top: 28px;">
                        <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13.5px; font-weight: 600; color: #334155;">
                            <input type="checkbox" name="is_active" value="1" <?= (!$editDoc || $editDoc['is_active'] == 1) ? 'checked' : '' ?> style="width: 17px; height: 17px;">
                            <span>Active &amp; Visible</span>
                        </label>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary" style="padding: 8px 22px; font-size: 13px;">
                        <i class="fas fa-save"></i> <?= $editDoc ? 'Update Document' : 'Upload Document' ?>
                    </button>
                    <?php if ($editDoc): ?>
                        <a href="mandatory-disclosure.php?tab=disclosures" class="btn btn-secondary" style="padding: 8px 18px; font-size: 13px;">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Documents Table -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
            <h3 style="font-size: 17px; font-weight: 700; color: #1e293b; margin: 0;">Uploaded Disclosure Documents (<?= count($documents) ?>)</h3>
            <div style="width: 280px;">
                <input type="text" class="form-control" placeholder="Search by title or category..." data-table-search="disclosuresTable">
            </div>
        </div>

        <div class="table-responsive">
            <table class="admin-table" id="disclosuresTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Category</th>
                        <th>Document Title</th>
                        <th>Academic Year</th>
                        <th>File Size</th>
                        <th>Status</th>
                        <th style="width: 160px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($documents)): ?>
                        <tr class="no-records-row">
                            <td colspan="7" style="text-align: center; padding: 36px; color: #64748b;">
                                <i class="fas fa-file-pdf" style="font-size: 32px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                                No mandatory disclosure documents uploaded yet. Use the form above to add one.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($documents as $idx => $doc): ?>
                            <tr>
                                <td><?= $idx + 1 ?></td>
                                <td>
                                    <span style="background: #e0f2fe; color: #0284c7; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                        <?= htmlspecialchars($doc['category']) ?>
                                    </span>
                                </td>
                                <td style="font-weight: 600; color: #1e293b;">
                                    <?= htmlspecialchars($doc['title']) ?>
                                </td>
                                <td><?= htmlspecialchars($doc['academic_year'] ?? '-') ?></td>
                                <td>
                                    <span style="color: #64748b; font-size: 13px;">
                                        <i class="fas fa-paperclip"></i> <?= htmlspecialchars($doc['file_size'] ?? 'PDF') ?>
                                    </span>
                                </td>
                                <td>
                                    <form action="mandatory-disclosure.php?tab=disclosures" method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="toggle_doc_status">
                                        <input type="hidden" name="id" value="<?= $doc['id'] ?>">
                                        <input type="hidden" name="status" value="<?= $doc['is_active'] ?>">
                                        <button type="submit" style="border: none; background: none; cursor: pointer;" title="Click to toggle status">
                                            <?php if ($doc['is_active'] == 1): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </button>
                                    </form>
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: inline-flex; gap: 6px; align-items: center;">
                                        <a href="../<?= htmlspecialchars($doc['file_path']) ?>" target="_blank" class="btn btn-sm btn-info" title="Open PDF" style="padding: 4px 8px;">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                        <a href="mandatory-disclosure.php?tab=disclosures&edit_doc=<?= $doc['id'] ?>" class="btn btn-sm btn-warning" title="Edit" style="padding: 4px 8px;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="mandatory-disclosure.php?tab=disclosures" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to permanently delete this document?');">
                                            <input type="hidden" name="action" value="delete_document">
                                            <input type="hidden" name="id" value="<?= $doc['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" style="padding: 4px 8px;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    <?php else: ?>
        <!-- ============================================================= -->
        <!-- TAB 2: CAMPUS COMMITTEES (ANTI-RAGGING, ICC, WDC)            -->
        <!-- ============================================================= -->
        <div style="display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
            <?php foreach ($committeesList as $cSlug => $cName): ?>
                <a href="mandatory-disclosure.php?tab=committees&committee=<?= urlencode($cSlug) ?>" 
                   class="btn <?= ($selectedCommittee === $cSlug) ? 'btn-primary' : 'btn-secondary' ?>" 
                   style="border-radius: 6px; font-weight: 600;">
                    <?= htmlspecialchars($cName) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($currentCommitteeInfo): ?>
            <!-- Committee Intro & Objectives Editor -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
                <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0;">
                    <i class="fas fa-edit" style="color: #1e90ff;"></i> Edit <?= htmlspecialchars($currentCommitteeInfo['committee_name']) ?> Description &amp; Objectives
                </h3>
                <form action="mandatory-disclosure.php?tab=committees&committee=<?= urlencode($selectedCommittee) ?>" method="POST">
                    <input type="hidden" name="action" value="update_committee_info">
                    <input type="hidden" name="committee_slug" value="<?= htmlspecialchars($currentCommitteeInfo['committee_slug']) ?>">

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-weight: 600;">Committee Display Name</label>
                        <input type="text" name="committee_name" class="form-control" value="<?= htmlspecialchars($currentCommitteeInfo['committee_name']) ?>" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-weight: 600;">Introduction &amp; Regulatory Overview</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Official description, UGC regulations, statutory context..."><?= htmlspecialchars($currentCommitteeInfo['description'] ?? '') ?></textarea>
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label class="form-label" style="font-weight: 600;">Objectives (Optional - displayed as points or text)</label>
                        <textarea name="objectives" class="form-control" rows="3" placeholder="Key objectives and mandate..."><?= htmlspecialchars($currentCommitteeInfo['objectives'] ?? '') ?></textarea>
                    </div>

                    <?php if ($selectedCommittee === 'women-development-cell'): ?>
                        <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div class="form-group">
                                <label class="form-label" style="font-weight: 600;">Vision</label>
                                <textarea name="vision" class="form-control" rows="3"><?= htmlspecialchars($currentCommitteeInfo['vision'] ?? '') ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label" style="font-weight: 600;">Mission</label>
                                <textarea name="mission" class="form-control" rows="3"><?= htmlspecialchars($currentCommitteeInfo['mission'] ?? '') ?></textarea>
                            </div>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Committee Overview
                    </button>
                </form>
            </div>

            <!-- Committee Members Management -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
                <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0;">
                    <i class="fas <?= $editMember ? 'fa-user-edit' : 'fa-user-plus' ?>" style="color: #1e90ff;"></i>
                    <?= $editMember ? 'Edit Committee Member' : 'Add Committee Member' ?>
                </h3>

                <form action="mandatory-disclosure.php?tab=committees&committee=<?= urlencode($selectedCommittee) ?>" method="POST">
                    <input type="hidden" name="action" value="<?= $editMember ? 'edit_member' : 'add_member' ?>">
                    <input type="hidden" name="committee_slug" value="<?= htmlspecialchars($selectedCommittee) ?>">
                    <?php if ($editMember): ?>
                        <input type="hidden" name="member_id" value="<?= $editMember['id'] ?>">
                    <?php endif; ?>

                    <div class="form-row" style="display: grid; grid-template-columns: 90px 1fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600;">Sr. No.</label>
                            <input type="number" name="sr_no" class="form-control" value="<?= htmlspecialchars($editMember['sr_no'] ?? (count($committeeMembers) + 1)) ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600;">Faculty / Member Name <span style="color: #ef4444;">*</span></label>
                            <input type="text" name="faculty_name" class="form-control" placeholder="e.g. Prof. (Dr) U. V. Shah" required value="<?= htmlspecialchars($editMember['faculty_name'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600;">Designation &amp; Department</label>
                            <input type="text" name="designation" class="form-control" placeholder="e.g. Prof. &amp; Head, Mech. Engg. Dept." value="<?= htmlspecialchars($editMember['designation'] ?? '') ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label" style="font-weight: 600;">
                                <?= ($selectedCommittee === 'women-development-cell') ? 'Official Mail ID / Role' : 'Committee Role' ?>
                            </label>
                            <input type="text" name="role_or_email" class="form-control" placeholder="<?= ($selectedCommittee === 'women-development-cell') ? 'e.g. convener_wdc@gecmodasa.ac.in' : 'e.g. Coordinator / Co-coordinator / Member' ?>" value="<?= htmlspecialchars($editMember['role_or_email'] ?? '') ?>">
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?= $editMember ? 'Update Member' : 'Add Member' ?>
                        </button>
                        <?php if ($editMember): ?>
                            <a href="mandatory-disclosure.php?tab=committees&committee=<?= urlencode($selectedCommittee) ?>" class="btn btn-secondary">Cancel</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Committee Members Table -->
            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 12px 0;">Current Members in <?= htmlspecialchars($currentCommitteeInfo['committee_name']) ?></h3>
            <div class="table-responsive">
                <table class="admin-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 70px;">Sr. No.</th>
                            <th>Name of Faculty / Member</th>
                            <th>Designation</th>
                            <th><?= ($selectedCommittee === 'women-development-cell') ? 'Mail ID / Role' : 'Role' ?></th>
                            <th style="width: 120px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($committeeMembers)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 24px; color: #64748b;">
                                    No members added yet to this committee.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($committeeMembers as $mem): ?>
                                <tr>
                                    <td><?= htmlspecialchars($mem['sr_no']) ?></td>
                                    <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($mem['faculty_name']) ?></td>
                                    <td><?= htmlspecialchars($mem['designation'] ?? '-') ?></td>
                                    <td>
                                        <span style="font-weight: 500; color: #0284c7;">
                                            <?= htmlspecialchars($mem['role_or_email'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="mandatory-disclosure.php?tab=committees&committee=<?= urlencode($selectedCommittee) ?>&edit_member=<?= $mem['id'] ?>" class="btn btn-sm btn-warning" title="Edit" style="padding: 4px 8px;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="mandatory-disclosure.php?tab=committees&committee=<?= urlencode($selectedCommittee) ?>" method="POST" style="display: inline;" onsubmit="return confirm('Remove this member from the committee?');">
                                            <input type="hidden" name="action" value="delete_member">
                                            <input type="hidden" name="member_id" value="<?= $mem['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" style="padding: 4px 8px;">
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
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

