<?php
/**
 * Department Admin - Publications Management (Clean Main Admin UI with Modal)
 */
$pageTitle = 'Department Publications';
$pageHeading = 'Research Publications';
$activeTab = 'publications';

require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$error = '';
$action = $_GET['action'] ?? '';
$editId = (int)($_GET['edit_id'] ?? 0);

// DELETE action
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
    <div class="admin-alert admin-alert-danger">
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<!-- Main Admin Card with Top Action Bar -->
<div class="admin-card">
    <div class="card-top">
        <div>
            <h2 class="card-title">Research Publications (<?= count($publications) ?>)</h2>
        </div>
        <div>
            <button type="button" class="btn-add-new" onclick="openPubModal()">
                Add Publication
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <?php if (empty($publications)): ?>
            <div style="text-align: center; padding: 48px 20px; color: var(--admin-text-muted);">
                <p>No publications added yet for this department.</p>
            </div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Paper Title</th>
                        <th>Authors</th>
                        <th style="width: 100px;">Year</th>
                        <th style="width: 120px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($publications as $idx => $p): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td>
                                <strong><?= htmlspecialchars($p['title']) ?></strong>
                                <?php if (!empty($p['journal_details'])): ?>
                                    <div style="font-size:12px; color:var(--admin-text-muted); margin-top:2px;">
                                        <?= htmlspecialchars($p['journal_details']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($p['authors']) ?></td>
                            <td><?= htmlspecialchars($p['pub_year'] ?? '-') ?></td>
                            <td style="text-align: right;">
                                <div class="table-actions" style="justify-content: flex-end;">
                                    <a href="javascript:void(0);" onclick='editPub(<?= json_encode($p) ?>)' class="btn-table-action btn-edit" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="publications.php?action=delete&id=<?= (int)$p['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Delete this publication?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: ADD / EDIT PUBLICATION                                  -->
<!-- ============================================================== -->
<div class="modal-overlay" id="pubModal">
    <div class="modal-dialog" style="max-width: 650px;">
        <div class="modal-header">
            <h3 class="modal-title" id="pubModalTitle">Add Research Publication</h3>
            <button type="button" class="btn-close-modal" onclick="closePubModal()">&times;</button>
        </div>
        <form action="publications.php" method="POST">
            <input type="hidden" name="record_id" id="pub_record_id" value="0">

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="pub_title">Paper Title <span class="required">*</span></label>
                    <input type="text" name="title" id="pub_title" class="form-control" placeholder="e.g. Structural Optimization Using Genetic Algorithms" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="pub_authors">Authors List <span class="required">*</span></label>
                    <input type="text" name="authors" id="pub_authors" class="form-control" placeholder="e.g. Dr. A. K. Patel, Prof. R. B. Joshi" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="pub_year_val">Year</label>
                        <input type="number" name="pub_year" id="pub_year_val" class="form-control" placeholder="e.g. 2024">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pub_date_val">Date</label>
                        <input type="date" name="pub_date" id="pub_date_val" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="pub_journal">Journal / Conference Citation</label>
                    <textarea name="journal_details" id="pub_journal" class="form-control" rows="2" placeholder="e.g. Elsevier Journal of Civil Engineering, Vol. 45, pp. 112-120"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="pub_url_val">DOI / Paper URL</label>
                    <input type="url" name="paper_url" id="pub_url_val" class="form-control" placeholder="https://doi.org/...">
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" id="pub_active" value="1" checked>
                        <span>Display on public department website (Active)</span>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closePubModal()">Cancel</button>
                <button type="submit" class="btn-add-new" id="pubSubmitBtn">Save Publication</button>
            </div>
        </form>
    </div>
</div>

<script>
function openPubModal() {
    document.getElementById('pubModalTitle').textContent = 'Add Research Publication';
    document.getElementById('pubSubmitBtn').textContent = 'Save Publication';
    document.getElementById('pub_record_id').value = '0';
    document.getElementById('pub_title').value = '';
    document.getElementById('pub_authors').value = '';
    document.getElementById('pub_year_val').value = '<?= date("Y") ?>';
    document.getElementById('pub_date_val').value = '';
    document.getElementById('pub_journal').value = '';
    document.getElementById('pub_url_val').value = '';
    document.getElementById('pub_active').checked = true;
    document.getElementById('pubModal').classList.add('active');
}

function editPub(data) {
    document.getElementById('pubModalTitle').textContent = 'Edit Publication';
    document.getElementById('pubSubmitBtn').textContent = 'Update Publication';
    document.getElementById('pub_record_id').value = data.id || '0';
    document.getElementById('pub_title').value = data.title || '';
    document.getElementById('pub_authors').value = data.authors || '';
    document.getElementById('pub_year_val').value = data.pub_year || '';
    document.getElementById('pub_date_val').value = data.pub_date || '';
    document.getElementById('pub_journal').value = data.journal_details || '';
    document.getElementById('pub_url_val').value = data.paper_url || '';
    document.getElementById('pub_active').checked = (data.is_active == 1);
    document.getElementById('pubModal').classList.add('active');
}

function closePubModal() {
    document.getElementById('pubModal').classList.remove('active');
}

<?php if ($editRecord): ?>
document.addEventListener('DOMContentLoaded', function() {
    editPub(<?= json_encode($editRecord) ?>);
});
<?php endif; ?>
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
