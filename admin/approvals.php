<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage AICTE & GTU Approvals";
$current_page = 'approvals';

$activeTab = $_GET['tab'] ?? 'AICTE';
if (!in_array($activeTab, ['AICTE', 'GTU'])) {
    $activeTab = 'AICTE';
}

$editDoc = null;
if (isset($_GET['edit']) && (int)$_GET['edit'] > 0 && $pdo) {
    $editId = (int)$_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM institute_approvals WHERE id = ?");
    $stmt->execute([$editId]);
    $editDoc = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($editDoc) {
        $activeTab = $editDoc['category'];
    }
}

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: approvals.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'add_document') {
        $category = trim($_POST['category'] ?? 'AICTE');
        if (!in_array($category, ['AICTE', 'GTU'])) {
            $category = 'AICTE';
        }
        $title = trim($_POST['title'] ?? '');
        $academic_year = trim($_POST['academic_year'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title)) {
            setFlashMessage('danger', 'Document title is required.');
            header("Location: approvals.php?tab={$category}");
            exit;
        }

        $upload = handlePdfUpload('pdf_file', 'approvals');
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header("Location: approvals.php?tab={$category}");
            exit;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO institute_approvals (category, title, academic_year, file_path, file_size, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$category, $title, $academic_year, $upload['path'], $upload['file_size'] ?? null, $display_order, $is_active]);

            setFlashMessage('success', "{$category} document uploaded successfully!");
        } catch (Exception $e) {
            setFlashMessage('danger', 'Failed to save approval document: ' . $e->getMessage());
        }

        header("Location: approvals.php?tab={$category}");
        exit;

    } elseif ($action === 'edit_document') {
        $id = (int)($_POST['id'] ?? 0);
        $category = trim($_POST['category'] ?? 'AICTE');
        if (!in_array($category, ['AICTE', 'GTU'])) {
            $category = 'AICTE';
        }
        $title = trim($_POST['title'] ?? '');
        $academic_year = trim($_POST['academic_year'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_file = trim($_POST['existing_file'] ?? '');

        if (empty($title) || $id <= 0) {
            setFlashMessage('danger', 'Valid ID and Document Title are required.');
            header("Location: approvals.php?tab={$category}");
            exit;
        }

        $file_path = $existing_file;
        $file_size = null;

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $upload = handlePdfUpload('pdf_file', 'approvals', $existing_file);
            if ($upload['success']) {
                $file_path = $upload['path'];
                $file_size = $upload['file_size'] ?? null;
            } else {
                setFlashMessage('danger', $upload['error']);
                header("Location: approvals.php?tab={$category}&edit={$id}");
                exit;
            }
        }

        try {
            if ($file_size) {
                $stmt = $pdo->prepare("UPDATE institute_approvals SET category = ?, title = ?, academic_year = ?, file_path = ?, file_size = ?, display_order = ?, is_active = ? WHERE id = ?");
                $stmt->execute([$category, $title, $academic_year, $file_path, $file_size, $display_order, $is_active, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE institute_approvals SET category = ?, title = ?, academic_year = ?, file_path = ?, display_order = ?, is_active = ? WHERE id = ?");
                $stmt->execute([$category, $title, $academic_year, $file_path, $display_order, $is_active, $id]);
            }

            setFlashMessage('success', "{$category} document updated successfully!");
        } catch (Exception $e) {
            setFlashMessage('danger', 'Failed to update document: ' . $e->getMessage());
        }

        header("Location: approvals.php?tab={$category}");
        exit;

    } elseif ($action === 'delete_document') {
        $id = (int)($_POST['id'] ?? 0);
        $redirectTab = 'AICTE';
        if ($id > 0) {
            $stmt = $pdo->prepare("SELECT category, file_path FROM institute_approvals WHERE id = ?");
            $stmt->execute([$id]);
            $doc = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($doc) {
                $redirectTab = $doc['category'];
                if (!empty($doc['file_path'])) {
                    $realFile = realpath(__DIR__ . '/../' . $doc['file_path']);
                    if ($realFile && file_exists($realFile)) {
                        @unlink($realFile);
                    }
                }
                $del = $pdo->prepare("DELETE FROM institute_approvals WHERE id = ?");
                $del->execute([$id]);
                setFlashMessage('success', "{$redirectTab} approval document deleted successfully.");
            }
        }
        header("Location: approvals.php?tab={$redirectTab}");
        exit;
    }
}

// Fetch documents for both categories
$aicteDocs = [];
$gtuDocs = [];
if ($pdo) {
    try {
        $stmtAicte = $pdo->query("SELECT * FROM institute_approvals WHERE category = 'AICTE' ORDER BY display_order ASC, academic_year DESC, id DESC");
        $aicteDocs = $stmtAicte->fetchAll(PDO::FETCH_ASSOC);

        $stmtGtu = $pdo->query("SELECT * FROM institute_approvals WHERE category = 'GTU' ORDER BY display_order ASC, academic_year DESC, id DESC");
        $gtuDocs = $stmtGtu->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $aicteDocs = [];
        $gtuDocs = [];
    }
}

$currentDocs = ($activeTab === 'GTU') ? $gtuDocs : $aicteDocs;

include_once __DIR__ . '/includes/header.php';
?>

<div class="admin-content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 22px; font-weight: 700; color: #1e293b; margin: 0 0 4px;">AICTE &amp; GTU Regulatory Approvals</h1>
        <p style="color: #64748b; margin: 0; font-size: 13.5px;">Manage official AICTE Extensions of Approval (EoA) and GTU Affiliation Letters shown on the About Overview page.</p>
    </div>
</div>

<?php renderFlashMessage(); ?>

<!-- Category Tabs -->
<div class="admin-tabs" style="display: flex; gap: 10px; margin-bottom: 24px; border-bottom: 2px solid #e2e8f0; padding-bottom: 0;">
    <a href="approvals.php?tab=AICTE" class="tab-item <?= ($activeTab === 'AICTE') ? 'active' : '' ?>" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px; font-weight: 600; font-size: 14px; text-decoration: none; border-bottom: 3px solid <?= ($activeTab === 'AICTE') ? '#009dff' : 'transparent' ?>; color: <?= ($activeTab === 'AICTE') ? '#009dff' : '#64748b' ?>; background: transparent; margin-bottom: -2px;">
        <i class="fas fa-certificate"></i>
        <span>AICTE Approvals</span>
        <span class="badge" style="background: <?= ($activeTab === 'AICTE') ? '#009dff' : '#e2e8f0' ?>; color: <?= ($activeTab === 'AICTE') ? '#ffffff' : '#475569' ?>; border-radius: 12px; padding: 2px 8px; font-size: 11px;">
            <?= count($aicteDocs) ?>
        </span>
    </a>
    <a href="approvals.php?tab=GTU" class="tab-item <?= ($activeTab === 'GTU') ? 'active' : '' ?>" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 20px; font-weight: 600; font-size: 14px; text-decoration: none; border-bottom: 3px solid <?= ($activeTab === 'GTU') ? '#009dff' : 'transparent' ?>; color: <?= ($activeTab === 'GTU') ? '#009dff' : '#64748b' ?>; background: transparent; margin-bottom: -2px;">
        <i class="fas fa-university"></i>
        <span>GTU Affiliations</span>
        <span class="badge" style="background: <?= ($activeTab === 'GTU') ? '#009dff' : '#e2e8f0' ?>; color: <?= ($activeTab === 'GTU') ? '#ffffff' : '#475569' ?>; border-radius: 12px; padding: 2px 8px; font-size: 11px;">
            <?= count($gtuDocs) ?>
        </span>
    </a>
</div>

<!-- Upload / Edit Document Card -->
<div class="admin-card" style="margin-bottom: 32px; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
        <h2 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas <?= $editDoc ? 'fa-edit' : 'fa-cloud-upload-alt' ?>" style="color: #009dff;"></i>
            <?= $editDoc ? 'Edit Approval Document' : 'Upload New ' . htmlspecialchars($activeTab) . ' Approval PDF' ?>
        </h2>
        <?php if ($editDoc): ?>
            <a href="approvals.php?tab=<?= urlencode($activeTab) ?>" class="btn btn-sm btn-secondary" style="font-size: 12px;">
                <i class="fas fa-times"></i> Cancel Edit
            </a>
        <?php endif; ?>
    </div>

    <form method="POST" action="approvals.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?= $editDoc ? 'edit_document' : 'add_document' ?>">
        <?php if ($editDoc): ?>
            <input type="hidden" name="id" value="<?= $editDoc['id'] ?>">
            <input type="hidden" name="existing_file" value="<?= htmlspecialchars($editDoc['file_path']) ?>">
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 16px;">
            <div class="form-group">
                <label style="display: block; font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">Category <span style="color: #ef4444;">*</span></label>
                <select name="category" class="form-control" required style="width: 100%;">
                    <option value="AICTE" <?= (($editDoc['category'] ?? $activeTab) === 'AICTE') ? 'selected' : '' ?>>AICTE (All India Council for Technical Education)</option>
                    <option value="GTU" <?= (($editDoc['category'] ?? $activeTab) === 'GTU') ? 'selected' : '' ?>>GTU (Gujarat Technological University)</option>
                </select>
            </div>

            <div class="form-group" style="grid-column: span 2;">
                <label style="display: block; font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">Document Title <span style="color: #ef4444;">*</span></label>
                <input type="text" name="title" class="form-control" required placeholder="e.g. AICTE Extension of Approval (EoA) 2024-25" value="<?= htmlspecialchars($editDoc['title'] ?? '') ?>" style="width: 100%;">
            </div>

            <div class="form-group">
                <label style="display: block; font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">Academic Year</label>
                <input type="text" name="academic_year" class="form-control" placeholder="e.g. 2024-25" value="<?= htmlspecialchars($editDoc['academic_year'] ?? '') ?>" style="width: 100%;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display: block; font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">
                    Upload PDF Document <?= $editDoc ? '(Leave empty to keep existing)' : '<span style="color: #ef4444;">*</span>' ?>
                </label>
                <input type="file" name="pdf_file" class="form-control" accept=".pdf" <?= $editDoc ? '' : 'required' ?> style="width: 100%;">
                <?php if ($editDoc && !empty($editDoc['file_path'])): ?>
                    <small style="color: #64748b; margin-top: 4px; display: block;">
                        Current file: <a href="../<?= htmlspecialchars($editDoc['file_path']) ?>" target="_blank" style="color: #009dff; font-weight: 600;"><i class="fas fa-file-pdf"></i> View Current PDF (<?= htmlspecialchars($editDoc['file_size'] ?? '') ?>)</a>
                    </small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label style="display: block; font-weight: 600; font-size: 13px; color: #334155; margin-bottom: 6px;">Display Order</label>
                <input type="number" name="display_order" class="form-control" placeholder="0" value="<?= (int)($editDoc['display_order'] ?? 0) ?>" style="width: 100%;">
            </div>

            <div class="form-group" style="display: flex; align-items: flex-end; padding-bottom: 8px;">
                <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13.5px; font-weight: 600; color: #334155;">
                    <input type="checkbox" name="is_active" value="1" <?= (!$editDoc || $editDoc['is_active'] == 1) ? 'checked' : '' ?> style="width: 18px; height: 18px;">
                    <span>Active &amp; Published on Website</span>
                </label>
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="padding: 9px 24px; font-size: 13.5px; font-weight: 600;">
                <i class="fas fa-save"></i> <?= $editDoc ? 'Update Document' : 'Upload Approval PDF' ?>
            </button>
            <?php if ($editDoc): ?>
                <a href="approvals.php?tab=<?= urlencode($activeTab) ?>" class="btn btn-secondary" style="padding: 9px 20px; font-size: 13.5px;">Cancel</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Documents List Table -->
<div class="admin-card" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
        <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">
            Uploaded <?= htmlspecialchars($activeTab) ?> Documents (<?= count($currentDocs) ?>)
        </h3>
        <div style="width: 280px;">
            <input type="text" class="form-control" placeholder="Search approvals by title/year..." data-table-search="approvalsTable">
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table" id="approvalsTable" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Document Title</th>
                    <th style="width: 140px; text-align: center;">Academic Year</th>
                    <th style="width: 120px; text-align: center;">File Size</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="width: 130px; text-align: center;">Uploaded</th>
                    <th style="width: 180px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($currentDocs)): ?>
                    <tr class="no-records-row">
                        <td colspan="7" style="text-align: center; padding: 40px 20px; color: #64748b;">
                            <i class="fas fa-file-pdf" style="font-size: 36px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                            No <?= htmlspecialchars($activeTab) ?> documents uploaded yet. Use the upload form above to add approval PDFs.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($currentDocs as $idx => $doc): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-file-pdf" style="color: #ef4444; font-size: 18px; flex-shrink: 0;"></i>
                                    <div>
                                        <a href="../<?= htmlspecialchars($doc['file_path']) ?>" target="_blank" style="font-weight: 600; color: #0f172a; text-decoration: none;">
                                            <?= htmlspecialchars($doc['title']) ?>
                                        </a>
                                        <small style="color: #94a3b8; display: block;"><?= htmlspecialchars($doc['file_path']) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge" style="background: #f1f5f9; color: #334155; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 6px;">
                                    <?= htmlspecialchars($doc['academic_year'] ?: '—') ?>
                                </span>
                            </td>
                            <td style="text-align: center; color: #64748b; font-size: 12.5px;">
                                <?= htmlspecialchars($doc['file_size'] ?: '—') ?>
                            </td>
                            <td style="text-align: center;">
                                <?php if ($doc['is_active']): ?>
                                    <span class="badge" style="background: #dcfce7; color: #166534; font-size: 11px; padding: 4px 8px; border-radius: 12px; font-weight: 600;">Active</span>
                                <?php else: ?>
                                    <span class="badge" style="background: #fee2e2; color: #991b1b; font-size: 11px; padding: 4px 8px; border-radius: 12px; font-weight: 600;">Hidden</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center; color: #64748b; font-size: 12px;">
                                <?= date('d M Y', strtotime($doc['created_at'])) ?>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 6px; align-items: center;">
                                    <a href="../<?= htmlspecialchars($doc['file_path']) ?>" target="_blank" class="btn btn-sm btn-info" title="View PDF" style="padding: 5px 10px; font-size: 12px;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="approvals.php?tab=<?= urlencode($activeTab) ?>&edit=<?= $doc['id'] ?>" class="btn btn-sm btn-secondary" title="Edit" style="padding: 5px 10px; font-size: 12px;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="approvals.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to permanently delete this <?= htmlspecialchars($doc['category']) ?> document? The file will also be removed from the server.');">
                                        <input type="hidden" name="action" value="delete_document">
                                        <input type="hidden" name="id" value="<?= $doc['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete Document" style="padding: 5px 10px; font-size: 12px;">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quick real-time client-side table search
    const searchInputs = document.querySelectorAll('[data-table-search]');
    searchInputs.forEach(input => {
        const tableId = input.getAttribute('data-table-search');
        const table = document.getElementById(tableId);
        if (!table) return;

        input.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const rows = table.querySelectorAll('tbody tr:not(.no-records-row)');
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    });
});
</script>

<?php
include_once __DIR__ . '/includes/footer.php';
?>
