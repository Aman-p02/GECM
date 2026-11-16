<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Manage Memorandums of Understanding (MoU)";
$current_page = 'mou';

$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: mou.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');

        if (empty($title)) {
            setFlashMessage('danger', 'MoU title is required.');
            header('Location: mou.php');
            exit;
        }

        $upload = handlePdfUpload('pdf_file', 'mous');
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: mou.php');
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO institute_mous (title, file_path, file_size, is_active) VALUES (?, ?, ?, 1)");
        $stmt->execute([$title, $upload['path'], $upload['file_size'] ?? null]);

        setFlashMessage('success', 'MoU document uploaded successfully!');
        header('Location: mou.php');
        exit;

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $existing_file = trim($_POST['existing_file'] ?? '');

        if (empty($title) || $id <= 0) {
            setFlashMessage('danger', 'Valid ID and MoU title are required.');
            header('Location: mou.php');
            exit;
        }

        $file_path = $existing_file;
        $file_size = null;

        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $upload = handlePdfUpload('pdf_file', 'mous', $existing_file);
            if ($upload['success']) {
                $file_path = $upload['path'];
                $file_size = $upload['file_size'] ?? null;
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: mou.php?edit=' . $id);
                exit;
            }
        }

        if ($file_size) {
            $stmt = $pdo->prepare("UPDATE institute_mous SET title = ?, file_path = ?, file_size = ? WHERE id = ?");
            $stmt->execute([$title, $file_path, $file_size, $id]);
        } else {
            $stmt = $pdo->prepare("UPDATE institute_mous SET title = ?, file_path = ? WHERE id = ?");
            $stmt->execute([$title, $file_path, $id]);
        }

        setFlashMessage('success', 'MoU document updated successfully!');
        header('Location: mou.php');
        exit;

    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("SELECT file_path FROM institute_mous WHERE id = ?");
            $stmt->execute([$id]);
            $item = $stmt->fetch();
            if ($item && !empty($item['file_path']) && $item['file_path'] !== '#') {
                $realFile = realpath(__DIR__ . '/../' . $item['file_path']);
                if ($realFile && file_exists($realFile)) {
                    @unlink($realFile);
                }
            }
            $pdo->prepare("DELETE FROM institute_mous WHERE id = ?")->execute([$id]);
            setFlashMessage('success', 'MoU document deleted.');
        }
        header('Location: mou.php');
        exit;
    }
}

// Fetch item for editing
if (isset($_GET['edit']) && (int)$_GET['edit'] > 0 && $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM institute_mous WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editItem = $stmt->fetch();
}

// Fetch all MoU documents
$mous = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM institute_mous ORDER BY id DESC");
    $mous = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 24px;">
    <!-- Top Action Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 14px; margin-bottom: 22px; flex-wrap: wrap; gap: 12px;">
        <p style="font-size: 13.5px; color: #64748b; margin: 0;">Upload and publish official Memorandums of Understanding (MoU) signed with industries, academic institutions, and research bodies (PDF).</p>
        <a href="../mou.php" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px; font-size: 13px;">
            <i class="fas fa-external-link-alt"></i> View Public Page
        </a>
    </div>

    <!-- Upload / Edit Form -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 28px;">
        <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas <?= $editItem ? 'fa-edit' : 'fa-plus-circle' ?>" style="color: #1e90ff;"></i>
            <?= $editItem ? 'Edit MoU Document' : 'Upload New MoU (PDF)' ?>
        </h3>

        <form action="mou.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
                <input type="hidden" name="existing_file" value="<?= htmlspecialchars($editItem['file_path']) ?>">
            <?php endif; ?>

            <!-- Field 1: MoU Title -->
            <div style="margin-bottom: 16px;">
                <label class="form-label" style="font-weight: 600;">MoU Title <span style="color: #ef4444;">*</span></label>
                <input type="text" name="title" id="mou_title" class="form-control" placeholder="e.g. Khodiyar CAD Center : MOU (01.04.2026)" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>">
            </div>

            <!-- Field 2: PDF File Upload -->
            <div style="margin-bottom: 20px;">
                <label class="form-label" style="font-weight: 600;">Signed MoU PDF <?= ($editItem && !empty($editItem['file_path']) && $editItem['file_path'] !== '#') ? '' : '<span style="color: #ef4444;">*</span>' ?></label>
                <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept=".pdf" <?= ($editItem && !empty($editItem['file_path']) && $editItem['file_path'] !== '#') ? '' : 'required' ?> style="padding: 5px 8px; font-size: 13px;">
                <div style="font-size: 11.5px; color: #64748b; margin-top: 3px;">
                    PDF format only. Maximum size: 25MB.
                </div>
                <?php if ($editItem && !empty($editItem['file_path'])): ?>
                    <div style="margin-top: 5px; font-size: 12px;">
                        <?php if ($editItem['file_path'] !== '#'): ?>
                            <a href="../<?= htmlspecialchars($editItem['file_path']) ?>" target="_blank" style="color: #1e90ff; font-weight: 600;">
                                <i class="fas fa-file-pdf" style="color: #dc2626;"></i> Current PDF (<?= htmlspecialchars($editItem['file_size'] ?? 'PDF') ?>)
                            </a>
                        <?php else: ?>
                            <span style="color: #f59e0b; font-weight: 600;">
                                <i class="far fa-clock"></i> File currently awaiting upload. Select a PDF file above to attach it.
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Submit Row -->
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 8px 22px; font-size: 13px; font-weight: 600;">
                    <i class="fas fa-save"></i> <?= $editItem ? 'Update MoU' : 'Upload MoU PDF' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="mou.php" class="btn btn-secondary" style="padding: 8px 18px; font-size: 13px;">Cancel Edit</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table Header & Search -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 12px;">
        <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0;">Published MoU Documents (<?= count($mous) ?>)</h3>
        <div style="width: 260px;">
            <input type="text" class="form-control" placeholder="Search MoUs..." data-table-search="mousTable" style="height: 36px; font-size: 13px;">
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table" id="mousTable" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>MoU Title</th>
                    <th style="width: 160px;">Document</th>
                    <th style="width: 110px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($mous)): ?>
                    <tr class="no-records-row">
                        <td colspan="4" style="text-align: center; padding: 36px; color: #64748b;">
                            <i class="fas fa-handshake" style="font-size: 28px; color: #cbd5e1; margin-bottom: 8px; display: block;"></i>
                            No MoU documents uploaded yet. Use the form above to upload one.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($mous as $idx => $m): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($m['title']) ?></td>
                            <td>
                                <?php if (!empty($m['file_path']) && $m['file_path'] !== '#'): ?>
                                    <a href="../<?= htmlspecialchars($m['file_path']) ?>" target="_blank" class="badge badge-primary" style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 8px; font-size: 11.5px; text-decoration: none;">
                                        <i class="fas fa-file-pdf"></i> PDF (<?= htmlspecialchars($m['file_size'] ?? 'View') ?>)
                                    </a>
                                <?php else: ?>
                                    <span class="badge badge-warning" style="font-size: 11px;">Pending Upload</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <?php if (!empty($m['file_path']) && $m['file_path'] !== '#'): ?>
                                    <a href="../<?= htmlspecialchars($m['file_path']) ?>" target="_blank" class="btn btn-sm btn-info" style="padding: 3px 7px;" title="View PDF">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="mou.php?edit=<?= $m['id'] ?>" class="btn btn-sm btn-warning" style="padding: 3px 7px;" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="mou.php" method="POST" style="display: inline;" onsubmit="return confirm('Delete this MoU document?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $m['id'] ?>">
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
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
