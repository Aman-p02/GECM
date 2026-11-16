<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage Mandatory Disclosures";
$current_page = 'mandatory-disclosure';

// Statutory Mandatory Disclosure Categories
$disclosureCategories = [
    'RTI Pro-Active Disclosure'          => 'RTI Pro-Active Disclosure',
    'AICTE Mandatory Disclosure'         => 'AICTE Mandatory Disclosure',
    'Financial Statements'               => 'Financial Statements',
    'Accreditation'                      => 'Accreditation',
    'Institute Establishment Resolution' => 'Institute Establishment Resolution',
    'RTI Booklet (2005)'                 => 'RTI Booklet (2005)'
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
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($category) || !isset($disclosureCategories[$category])) {
            setFlashMessage('danger', 'Please select a valid statutory category.');
            header('Location: mandatory-disclosure.php');
            exit;
        }

        if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
            setFlashMessage('danger', 'Please select a valid PDF file to upload.');
            header('Location: mandatory-disclosure.php');
            exit;
        }

        $file = $_FILES['pdf_file'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($ext !== 'pdf') {
            setFlashMessage('danger', 'Only PDF files (.pdf) are allowed.');
            header('Location: mandatory-disclosure.php');
            exit;
        }

        if ($file['size'] > 25 * 1024 * 1024) {
            setFlashMessage('danger', 'PDF file size exceeds maximum limit of 25MB.');
            header('Location: mandatory-disclosure.php');
            exit;
        }

        $rawBase = pathinfo($file['name'], PATHINFO_FILENAME);
        // PDF filename automatically becomes the title
        $title = trim(preg_replace('/[_\-]+/', ' ', $rawBase));
        if (empty($title)) {
            $title = $category;
        }

        $cleanBase = preg_replace('/[^a-zA-Z0-9_\-\.\(\)\s]/', '_', $rawBase);
        $cleanBase = trim($cleanBase) ?: ('doc_' . time());

        $targetDir = realpath(__DIR__ . '/../uploads/disclosures');
        if (!$targetDir) {
            $targetDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'disclosures';
        }
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $cleanFilename = $cleanBase . '.pdf';
        $targetFile = $targetDir . DIRECTORY_SEPARATOR . $cleanFilename;

        if (file_exists($targetFile)) {
            $cleanFilename = $cleanBase . '_' . time() . '.pdf';
            $targetFile = $targetDir . DIRECTORY_SEPARATOR . $cleanFilename;
        }

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Remove dummy titles like '(anonymous)' injected by compressors
            $pdfRaw = @file_get_contents($targetFile);
            if ($pdfRaw) {
                $dummyTitles = ['/Title (\(anonymous\))', '/Title (anonymous)', '/Title (unspecified)', '/Title (untitled)', '/Title (Untitled)'];
                $cleanNeeded = false;
                foreach ($dummyTitles as $dt) {
                    if (strpos($pdfRaw, $dt) !== false) {
                        $pdfRaw = str_replace($dt, str_pad('/Title ()', strlen($dt), ' ', STR_PAD_RIGHT), $pdfRaw);
                        $cleanNeeded = true;
                    }
                }
                if ($cleanNeeded) {
                    @file_put_contents($targetFile, $pdfRaw);
                }
            }

            $bytes = $file['size'];
            $fileSizeStr = ($bytes >= 1048576) ? (number_format($bytes / 1048576, 1) . ' MB') : (number_format($bytes / 1024, 0) . ' KB');
            $relativePath = 'uploads/disclosures/' . $cleanFilename;

            $stmt = $pdo->prepare("INSERT INTO mandatory_disclosures (category, title, file_path, file_size, is_active) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$category, $title, $relativePath, $fileSizeStr, $is_active]);

            setFlashMessage('success', 'Document uploaded successfully as "' . htmlspecialchars($title) . '"!');
        } else {
            setFlashMessage('danger', 'Failed to save the PDF file.');
        }

        header('Location: mandatory-disclosure.php');
        exit;

    } elseif ($action === 'edit_document') {
        $id = (int)($_POST['id'] ?? 0);
        $category = trim($_POST['category'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_file = trim($_POST['existing_file'] ?? '');

        if (empty($category) || !isset($disclosureCategories[$category]) || $id <= 0) {
            setFlashMessage('danger', 'Valid ID and category are required.');
            header('Location: mandatory-disclosure.php');
            exit;
        }

        $file_path = $existing_file;
        $file_size = null;

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['pdf_file'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if ($ext !== 'pdf') {
                setFlashMessage('danger', 'Only PDF files (.pdf) are allowed.');
                header('Location: mandatory-disclosure.php?edit_doc=' . $id);
                exit;
            }

            if ($file['size'] > 25 * 1024 * 1024) {
                setFlashMessage('danger', 'PDF file size exceeds maximum limit of 25MB.');
                header('Location: mandatory-disclosure.php?edit_doc=' . $id);
                exit;
            }

            $rawBase = pathinfo($file['name'], PATHINFO_FILENAME);
            if (empty($title)) {
                $title = trim(preg_replace('/[_\-]+/', ' ', $rawBase));
            }

            $cleanBase = preg_replace('/[^a-zA-Z0-9_\-\.\(\)\s]/', '_', $rawBase);
            $cleanBase = trim($cleanBase) ?: ('doc_' . time());

            $targetDir = realpath(__DIR__ . '/../uploads/disclosures');
            if (!$targetDir) {
                $targetDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'disclosures';
            }
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $cleanFilename = $cleanBase . '.pdf';
            $targetFile = $targetDir . DIRECTORY_SEPARATOR . $cleanFilename;

            if (file_exists($targetFile)) {
                $cleanFilename = $cleanBase . '_' . time() . '.pdf';
                $targetFile = $targetDir . DIRECTORY_SEPARATOR . $cleanFilename;
            }

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                $pdfRaw = @file_get_contents($targetFile);
                if ($pdfRaw) {
                    $dummyTitles = ['/Title (\(anonymous\))', '/Title (anonymous)', '/Title (unspecified)', '/Title (untitled)', '/Title (Untitled)'];
                    $cleanNeeded = false;
                    foreach ($dummyTitles as $dt) {
                        if (strpos($pdfRaw, $dt) !== false) {
                            $pdfRaw = str_replace($dt, str_pad('/Title ()', strlen($dt), ' ', STR_PAD_RIGHT), $pdfRaw);
                            $cleanNeeded = true;
                        }
                    }
                    if ($cleanNeeded) {
                        @file_put_contents($targetFile, $pdfRaw);
                    }
                }

                if (!empty($existing_file)) {
                    $oldReal = realpath(__DIR__ . '/../' . $existing_file);
                    if ($oldReal && file_exists($oldReal)) {
                        @unlink($oldReal);
                    }
                }

                $bytes = $file['size'];
                $file_size = ($bytes >= 1048576) ? (number_format($bytes / 1048576, 1) . ' MB') : (number_format($bytes / 1024, 0) . ' KB');
                $file_path = 'uploads/disclosures/' . $cleanFilename;
            }
        }

        if (empty($title)) {
            $title = $category;
        }

        if ($file_size) {
            $stmt = $pdo->prepare("UPDATE mandatory_disclosures SET category = ?, title = ?, file_path = ?, file_size = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$category, $title, $file_path, $file_size, $is_active, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE mandatory_disclosures SET category = ?, title = ?, file_path = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$category, $title, $file_path, $is_active, $id]);
        }

        setFlashMessage('success', 'Document updated successfully!');
        header('Location: mandatory-disclosure.php');
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
        header('Location: mandatory-disclosure.php');
        exit;

    } elseif ($action === 'toggle_doc_status') {
        $id = (int)($_POST['id'] ?? 0);
        $status = (int)($_POST['status'] ?? 0);
        $new_status = ($status === 1) ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE mandatory_disclosures SET is_active = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
        setFlashMessage('success', 'Document status updated.');
        header('Location: mandatory-disclosure.php');
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

// Fetch all documents
$documents = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM mandatory_disclosures ORDER BY category ASC, id DESC");
    $documents = $stmt->fetchAll();
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 24px;">
    <!-- Top Action Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 14px; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">Mandatory Disclosure Documents</h2>
            <p style="font-size: 13.5px; color: #64748b; margin: 0;">Upload statutory regulatory PDFs. The PDF file name will automatically be used as the document title.</p>
        </div>
        <a href="../mandatory-disclosure.php" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px; font-size: 13px;">
            <i class="fas fa-external-link-alt"></i> View Public Page
        </a>
    </div>

    <!-- Upload / Edit Disclosure Document Form -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas <?= $editDoc ? 'fa-edit' : 'fa-plus-circle' ?>" style="color: #1e90ff;"></i>
            <?= $editDoc ? 'Edit Disclosure Document' : 'Upload Mandatory Disclosure (PDF)' ?>
        </h3>

        <form action="mandatory-disclosure.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?= $editDoc ? 'edit_document' : 'add_document' ?>">
            <?php if ($editDoc): ?>
                <input type="hidden" name="id" value="<?= $editDoc['id'] ?>">
                <input type="hidden" name="existing_file" value="<?= htmlspecialchars($editDoc['file_path']) ?>">
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: <?= $editDoc ? '1.2fr 1.5fr 1.5fr auto' : '1.3fr 2fr auto' ?>; gap: 18px; margin-bottom: 20px; align-items: flex-end;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-weight: 600;">Statutory Category <span style="color: #ef4444;">*</span></label>
                    <select name="category" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        <?php foreach ($disclosureCategories as $catKey => $catLabel): ?>
                            <option value="<?= htmlspecialchars($catKey) ?>" <?= ($editDoc && $editDoc['category'] === $catKey) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($catLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if ($editDoc): ?>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" style="font-weight: 600;">Document Title</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($editDoc['title'] ?? '') ?>" placeholder="Document Title (PDF name)">
                    </div>
                <?php endif; ?>

                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-weight: 600;">PDF Document File <?= $editDoc ? '' : '<span style="color: #ef4444;">*</span>' ?></label>
                    <input type="file" name="pdf_file" class="form-control" accept=".pdf" <?= $editDoc ? '' : 'required' ?> style="padding: 5px 8px; font-size: 13px;">
                    <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">
                        PDF filename automatically becomes the title. Max size: 25MB.
                    </div>
                    <?php if ($editDoc && !empty($editDoc['file_path'])): ?>
                        <div style="margin-top: 4px; font-size: 12px;">
                            <a href="../<?= htmlspecialchars($editDoc['file_path']) ?>" target="_blank" style="color: #1e90ff;">
                                <i class="fas fa-file-pdf"></i> Current File (<?= htmlspecialchars($editDoc['file_size'] ?? 'PDF') ?>)
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group" style="margin-bottom: 0; padding-bottom: 8px;">
                    <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13.5px; font-weight: 600; color: #334155; white-space: nowrap;">
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
                    <a href="mandatory-disclosure.php" class="btn btn-secondary" style="padding: 8px 18px; font-size: 13px;">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Documents Table -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
        <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">Uploaded Disclosure Documents (<?= count($documents) ?>)</h3>
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
                    <th>Document Name</th>
                    <th>File Size</th>
                    <th>Status</th>
                    <th style="width: 160px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($documents)): ?>
                    <tr class="no-records-row">
                        <td colspan="6" style="text-align: center; padding: 36px; color: #64748b;">
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
                            <td>
                                <span style="color: #64748b; font-size: 13px;">
                                    <i class="fas fa-paperclip"></i> <?= htmlspecialchars($doc['file_size'] ?? 'PDF') ?>
                                </span>
                            </td>
                            <td>
                                <form action="mandatory-disclosure.php" method="POST" style="display: inline;">
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
                                    <a href="mandatory-disclosure.php?edit_doc=<?= $doc['id'] ?>" class="btn btn-sm btn-warning" title="Edit" style="padding: 4px 8px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="mandatory-disclosure.php" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to permanently delete this document?');">
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
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
