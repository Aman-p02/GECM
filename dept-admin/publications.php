<?php
/**
 * Department Admin - Publications Management (Strictly scoped to dept_code)
 */
$pageTitle = 'Department Publications';
$pageHeading = 'Research Publications';
$activeTab = 'publications';

require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$error = '';
$action = $_GET['action'] ?? '';
$editId = (int)($_GET['edit_id'] ?? 0);

// DELETE action (Strictly scoped)
if ($action === 'delete' && !empty($_GET['id'])) {
    $delId = (int)$_GET['id'];
    try {
        $delStmt = $pdo->prepare("DELETE FROM department_publications WHERE id = ? AND dept_code = ?");
        $delStmt->execute([$delId, $deptCode]);
        setDeptFlash('success', 'Publication deleted successfully.');
        header('Location: publications.php');
        exit;
    } catch (Exception $e) {
        $error = 'Delete failed: ' . $e->getMessage();
    }
}

// POST Add or Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitId = (int)($_POST['record_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $authors = trim($_POST['authors'] ?? '');
    $pub_date = !empty($_POST['pub_date']) ? $_POST['pub_date'] : null;
    $pub_year = !empty($_POST['pub_year']) ? (int)$_POST['pub_year'] : null;
    $journal_details = trim($_POST['journal_details'] ?? '');
    $paper_url = trim($_POST['paper_url'] ?? '');
    $display_order = (int)($_POST['display_order'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if (empty($title) || empty($authors)) {
        $error = 'Paper Title and Authors are required.';
    } else {
        try {
            if ($submitId > 0) {
                $stmt = $pdo->prepare("UPDATE department_publications SET 
                    title = ?, 
                    authors = ?, 
                    pub_date = ?, 
                    pub_year = ?, 
                    journal_details = ?, 
                    paper_url = ?, 
                    display_order = ?, 
                    is_active = ?, 
                    updated_at = NOW() 
                    WHERE id = ? AND dept_code = ?");
                $stmt->execute([$title, $authors, $pub_date, $pub_year, $journal_details, $paper_url, $display_order, $is_active, $submitId, $deptCode]);
                setDeptFlash('success', 'Publication updated successfully.');
            } else {
                $stmt = $pdo->prepare("INSERT INTO department_publications (dept_code, title, authors, pub_date, pub_year, journal_details, paper_url, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$deptCode, $title, $authors, $pub_date, $pub_year, $journal_details, $paper_url, $display_order, $is_active]);
                setDeptFlash('success', 'New publication recorded successfully.');
            }
            header('Location: publications.php');
            exit;
        } catch (Exception $e) {
            $error = 'Save failed: ' . $e->getMessage();
        }
    }
}

// Fetch edit record
$editRecord = null;
if ($action === 'edit' && $editId > 0) {
    $editStmt = $pdo->prepare("SELECT * FROM department_publications WHERE id = ? AND dept_code = ?");
    $editStmt->execute([$editId, $deptCode]);
    $editRecord = $editStmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch publications
$stmt = $pdo->prepare("SELECT * FROM department_publications WHERE dept_code = ? ORDER BY pub_year DESC, display_order ASC, id DESC");
$stmt->execute([$deptCode]);
$publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<!-- Form Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3>
            <i class="fas fa-<?= $editRecord ? 'pen-to-square' : 'newspaper' ?>"></i>
            <?= $editRecord ? 'Edit Publication' : 'Add Research Publication to ' . htmlspecialchars($deptName) ?>
        </h3>
        <?php if ($editRecord): ?>
            <a href="publications.php" class="btn btn-outline btn-sm">Cancel Edit</a>
        <?php endif; ?>
    </div>

    <div class="admin-card-body">
        <form method="POST" action="publications.php">
            <input type="hidden" name="record_id" value="<?= htmlspecialchars($editRecord['id'] ?? 0) ?>">

            <div class="form-group">
                <label class="form-label" for="title">Paper / Publication Title <span class="required">*</span></label>
                <input type="text" name="title" id="title" class="form-control" placeholder="e.g. Robust Machine Learning Models for Structural Health Monitoring" value="<?= htmlspecialchars($editRecord['title'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="authors">Authors List <span class="required">*</span></label>
                <input type="text" name="authors" id="authors" class="form-control" placeholder="e.g. Dr. A. B. Shah, Prof. P. K. Sharma" value="<?= htmlspecialchars($editRecord['authors'] ?? '') ?>" required>
            </div>

            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label" for="pub_year">Publication Year</label>
                    <input type="number" name="pub_year" id="pub_year" class="form-control" placeholder="e.g. 2024" value="<?= htmlspecialchars($editRecord['pub_year'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="pub_date">Date of Publication</label>
                    <input type="date" name="pub_date" id="pub_date" class="form-control" value="<?= htmlspecialchars($editRecord['pub_date'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="paper_url">DOI / Paper URL</label>
                    <input type="url" name="paper_url" id="paper_url" class="form-control" placeholder="https://doi.org/..." value="<?= htmlspecialchars($editRecord['paper_url'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="journal_details">Journal / Conference / Publisher Details</label>
                <textarea name="journal_details" id="journal_details" class="form-control" placeholder="e.g. IEEE Transactions on Smart Grid, Vol. 12, Issue 4, pp. 230-241"><?= htmlspecialchars($editRecord['journal_details'] ?? '') ?></textarea>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:15px;">
                <button type="submit" class="btn btn-navy">
                    <i class="fas fa-save"></i> <?= $editRecord ? 'Update Publication' : 'Save Publication' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- List Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fas fa-list-check"></i> Recorded Publications (<?= count($publications) ?>)</h3>
    </div>

    <div class="data-table-wrapper">
        <?php if (empty($publications)): ?>
            <div class="empty-state">
                <i class="fas fa-newspaper"></i>
                <p>No publications added yet for this department.</p>
            </div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Paper Title</th>
                        <th>Authors</th>
                        <th>Year</th>
                        <th style="width: 130px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($publications as $idx => $p): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td>
                                <strong><?= htmlspecialchars($p['title']) ?></strong>
                                <?php if (!empty($p['journal_details'])): ?>
                                    <div style="font-size:12px; color:#64748b;"><?= htmlspecialchars($p['journal_details']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($p['authors']) ?></td>
                            <td><?= htmlspecialchars($p['pub_year'] ?? '-') ?></td>
                            <td style="text-align: right;">
                                <a href="publications.php?action=edit&edit_id=<?= (int)$p['id'] ?>" class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="publications.php?action=delete&id=<?= (int)$p['id'] ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Delete this publication?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

