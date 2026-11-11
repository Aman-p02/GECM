<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

// Department resolution
$deptCode = strtoupper(trim($_GET['dept'] ?? 'CE'));
$validDepts = [
    'CE'    => 'Computer Engineering',
    'IT'    => 'Information Technology',
    'ME'    => 'Mechanical Engineering',
    'CIVIL' => 'Civil Engineering',
    'EE'    => 'Electrical Engineering',
    'EC'    => 'Electronics & Communication',
    'AE'    => 'Automobile Engineering',
    'AM'    => 'Applied Mechanics',
    'SH'    => 'Science & Humanities'
];

if (!isset($validDepts[$deptCode])) {
    $deptCode = 'CE';
}
$deptName = $validDepts[$deptCode];

$deptFolderMap = [
    'CE'    => 'computer',
    'IT'    => 'information-technology',
    'ME'    => 'mechanical',
    'CIVIL' => 'civil',
    'AE'    => 'automobile',
    'AM'    => 'applied-mechanics',
];
$liveDeptFolder = $deptFolderMap[$deptCode] ?? 'computer';
$livePageUrl = "../departments/{$liveDeptFolder}/index.php#publications";

// Guard against DB connection failure on write requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: dept-publications.php?dept=' . $deptCode);
        exit;
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $authors = trim($_POST['authors'] ?? '');
        $pub_date = trim($_POST['pub_date'] ?? '');
        $pub_year = trim($_POST['pub_year'] ?? '');
        $journal_details = trim($_POST['journal_details'] ?? '');
        $paper_url = trim($_POST['paper_url'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        // Auto-extract 4-digit year if not specified
        if (empty($pub_year) && preg_match('/\b(20\d\d|19\d\d)\b/', $pub_date, $matches)) {
            $pub_year = $matches[1];
        }

        if (empty($title) || empty($authors)) {
            setFlashMessage('danger', 'Paper Title and Author/Member name(s) are required.');
            header('Location: dept-publications.php?dept=' . $deptCode);
            exit;
        }

        try {
            $stmt = $pdo->prepare("
                INSERT INTO department_publications 
                (dept_code, title, authors, pub_date, pub_year, journal_details, paper_url, display_order, is_active)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $deptCode, $title, $authors, $pub_date, $pub_year, $journal_details, $paper_url, $display_order, $is_active
            ]);
            setFlashMessage('success', "Publication added successfully for $deptName!");
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }

        header('Location: dept-publications.php?dept=' . $deptCode);
        exit;
    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $authors = trim($_POST['authors'] ?? '');
        $pub_date = trim($_POST['pub_date'] ?? '');
        $pub_year = trim($_POST['pub_year'] ?? '');
        $journal_details = trim($_POST['journal_details'] ?? '');
        $paper_url = trim($_POST['paper_url'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($pub_year) && preg_match('/\b(20\d\d|19\d\d)\b/', $pub_date, $matches)) {
            $pub_year = $matches[1];
        }

        if ($id <= 0 || empty($title) || empty($authors)) {
            setFlashMessage('danger', 'Invalid publication ID or missing required fields.');
            header('Location: dept-publications.php?dept=' . $deptCode);
            exit;
        }

        try {
            $stmt = $pdo->prepare("
                UPDATE department_publications 
                SET title = ?, authors = ?, pub_date = ?, pub_year = ?, journal_details = ?, paper_url = ?, display_order = ?, is_active = ?
                WHERE id = ? AND dept_code = ?
            ");
            $stmt->execute([
                $title, $authors, $pub_date, $pub_year, $journal_details, $paper_url, $display_order, $is_active, $id, $deptCode
            ]);
            setFlashMessage('success', 'Publication updated successfully!');
        } catch (Exception $e) {
            setFlashMessage('danger', 'Database error: ' . $e->getMessage());
        }

        header('Location: dept-publications.php?dept=' . $deptCode);
        exit;
    }
}

// Handle GET Actions (Delete, Toggle, Edit)
if (isset($_GET['delete'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: dept-publications.php?dept=' . $deptCode);
        exit;
    }
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        try {
            $stmt = $pdo->prepare("DELETE FROM department_publications WHERE id = ? AND dept_code = ?");
            $stmt->execute([$id, $deptCode]);
            setFlashMessage('success', 'Publication deleted successfully.');
        } catch (Exception $e) {
            setFlashMessage('danger', 'Delete error: ' . $e->getMessage());
        }
    }
    header('Location: dept-publications.php?dept=' . $deptCode);
    exit;
}

if (isset($_GET['toggle'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: dept-publications.php?dept=' . $deptCode);
        exit;
    }
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        try {
            $stmt = $pdo->prepare("UPDATE department_publications SET is_active = IF(is_active = 1, 0, 1) WHERE id = ? AND dept_code = ?");
            $stmt->execute([$id, $deptCode]);
            setFlashMessage('info', 'Publication visibility status updated.');
        } catch (Exception $e) {
            setFlashMessage('danger', 'Status update error: ' . $e->getMessage());
        }
    }
    header('Location: dept-publications.php?dept=' . $deptCode);
    exit;
}

if (isset($_GET['edit']) && $pdo) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM department_publications WHERE id = ? AND dept_code = ?");
        $stmt->execute([$id, $deptCode]);
        $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Fetch all publications for this department
$publicationsList = [];
if ($pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT * FROM department_publications 
            WHERE dept_code = ? 
            ORDER BY display_order ASC, pub_year DESC, id DESC
        ");
        $stmt->execute([$deptCode]);
        $publicationsList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Dept Publications Fetch Error: " . $e->getMessage());
    }
}

$current_page = 'dept-publications';
$page_title = "Publications — " . $deptName;
require_once __DIR__ . '/includes/header.php';
?>

<!-- Department Modules Navigation Bar -->
<div style="background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 12px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <span style="font-size: 15px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-layer-group" style="color: #2563eb;"></i> <?= htmlspecialchars($deptName) ?> (<?= htmlspecialchars($deptCode) ?>)
        </span>
    </div>

    <!-- Sub-modules of this Department -->
    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
        <a href="dept-faculty.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-users" style="margin-right: 6px;"></i> Faculty Members
        </a>
        <a href="dept-activities.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-calendar-check" style="margin-right: 6px;"></i> Activities
        </a>
        <a href="dept-publications.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #1e90ff; color: #ffffff; padding: 7px 14px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 13px;">
            <i class="fas fa-book" style="margin-right: 6px;"></i> Publications
        </a>
        <a href="dept-board.php?dept=<?= $deptCode ?>" class="btn-sm" style="background: #f1f5f9; color: #475569; padding: 7px 14px; border-radius: 6px; font-weight: 500; text-decoration: none; font-size: 13px;">
            <i class="fas fa-user-tie" style="margin-right: 6px;"></i> Advisory Board
        </a>
        <a href="dept-newsletters.php?dept=<?= urlencode($deptCode) ?>" class="btn-sm" style="background: #f1f5f9; color: #334155; padding: 7px 14px; border-radius: 6px; font-weight: 500; text-decoration: none; font-size: 13px;">
            <i class="fas fa-newspaper" style="margin-right: 6px;"></i> Newsletters
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <h2 class="card-title"><?= htmlspecialchars($deptName) ?> — Research Publications</h2>
            <p style="color: #64748b; font-size: 13.5px; margin-top: 4px;">
                Manage journal publications, conference proceedings, authors, publication dates, and paper links.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="<?= htmlspecialchars($livePageUrl) ?>" target="_blank" class="btn-secondary" style="text-decoration: none; display: flex; align-items: center; gap: 6px; padding: 8px 16px;">
                <i class="fas fa-external-link-alt"></i> View Live Page
            </a>
            <button type="button" class="btn-add-new" onclick="openModal('addPublicationModal')">
                + Add Publication
            </button>
        </div>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="card-filters" style="margin-left: auto;">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search publication title, authors, date, year..." data-table-search="pubTable">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="admin-table" id="pubTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th>Publication Title</th>
                    <th>Member / Authors</th>
                    <th style="width: 160px;">Publication Date</th>
                    <th style="width: 90px; text-align: center;">Status</th>
                    <th style="width: 120px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($publicationsList)): ?>
                    <tr class="no-records-row">
                        <td colspan="6" style="text-align: center; padding: 48px; color: #64748b;">
                            <i class="fas fa-book-open" style="font-size: 32px; color: #cbd5e1; margin-bottom: 12px; display: block;"></i>
                            No publications recorded yet for <?= htmlspecialchars($deptName) ?>. Click "+ Add Publication" above to add research papers.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($publicationsList as $pub): ?>
                        <tr>
                            <td>
                                <span class="badge" style="background: #f1f5f9; color: #475569; font-weight: 700;">
                                    #<?= htmlspecialchars($pub['display_order']) ?>
                                </span>
                            </td>
                            <td>
                                <div style="font-weight: 600; font-size: 14.5px; color: #0f172a; line-height: 1.45;">
                                    <?= htmlspecialchars($pub['title']) ?>
                                </div>
                                <?php if (!empty($pub['journal_details'])): ?>
                                    <div style="font-size: 12.5px; color: #64748b; margin-top: 4px;">
                                        <?= htmlspecialchars($pub['journal_details']) ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($pub['paper_url'])): ?>
                                    <a href="<?= htmlspecialchars($pub['paper_url']) ?>" target="_blank" style="font-size: 12px; color: #2563eb; text-decoration: none; margin-top: 4px; display: inline-block;">
                                        <i class="fas fa-external-link-alt"></i> View Paper Link
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="display: flex; align-items: flex-start; gap: 6px; font-size: 13.5px; color: #334155; font-weight: 500;">
                                    <i class="fas fa-user-friends" style="color: #64748b; margin-top: 3px;"></i>
                                    <span><?= htmlspecialchars($pub['authors']) ?></span>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 6px; font-size: 13px; color: #475569;">
                                    <i class="far fa-calendar-alt" style="color: #2563eb;"></i>
                                    <span><?= htmlspecialchars($pub['pub_date'] ?: ($pub['pub_year'] ?: '—')) ?></span>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <a href="dept-publications.php?dept=<?= $deptCode ?>&toggle=<?= $pub['id'] ?>" class="status-pill <?= $pub['is_active'] ? 'active' : 'inactive' ?>" title="Click to toggle visibility">
                                    <?= $pub['is_active'] ? 'Active' : 'Hidden' ?>
                                </a>
                            </td>
                            <td style="text-align: right;">
                                <div class="action-btn-group">
                                    <a href="dept-publications.php?dept=<?= $deptCode ?>&edit=<?= $pub['id'] ?>" class="btn-action edit" title="Edit Publication">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="dept-publications.php?dept=<?= $deptCode ?>&delete=<?= $pub['id'] ?>" class="btn-action delete" title="Delete Publication" onclick="return confirm('Delete this publication entry?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: ADD PUBLICATION                                         -->
<!-- ============================================================== -->
<div class="admin-modal" id="addPublicationModal">
    <div class="modal-dialog" style="max-width: 680px;">
        <div class="modal-header">
            <h3 class="modal-title">Add New Publication (<?= htmlspecialchars($deptName) ?>)</h3>
            <button type="button" class="btn-close-modal" onclick="closeModal('addPublicationModal')">&times;</button>
        </div>
        <form action="dept-publications.php?dept=<?= $deptCode ?>" method="POST">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="add_title">Paper / Publication Title <span class="required">*</span></label>
                    <textarea name="title" id="add_title" class="form-control" rows="2" placeholder="e.g. Crowd Emotion and Behavior Analysis Using Lightweight CNN Model" required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_authors">Member / Author Name(s) <span class="required">*</span></label>
                    <input type="text" name="authors" id="add_authors" class="form-control" placeholder="e.g. Jignesh Vaniya, Safvan Vahora, Uttam Chauhan, Sudhir Vegad" required>
                    <small style="color: #64748b; font-size: 11px;">Separate multiple authors with commas.</small>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label" for="add_date">Date / Month & Year <span class="required">*</span></label>
                        <input type="text" name="pub_date" id="add_date" class="form-control" placeholder="e.g. October 2024 or November-December 2018" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="add_year">4-Digit Year (Filter)</label>
                        <input type="text" name="pub_year" id="add_year" class="form-control" placeholder="e.g. 2024">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="add_order">Display Order</label>
                        <input type="number" name="display_order" id="add_order" class="form-control" value="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_journal">Journal / Conference / Publisher Details (Optional)</label>
                    <input type="text" name="journal_details" id="add_journal" class="form-control" placeholder="e.g. IEEE Transactions on Neural Networks, Vol. 12, Issue 3">
                </div>

                <div class="form-group">
                    <label class="form-label" for="add_url">Paper URL / DOI Link (Optional)</label>
                    <input type="text" name="paper_url" id="add_url" class="form-control" placeholder="https://doi.org/...">
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Display on public department website (Active)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addPublicationModal')">Cancel</button>
                <button type="submit" class="btn-primary">Save Publication</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: EDIT PUBLICATION                                        -->
<!-- ============================================================== -->
<?php if ($editItem): ?>
<div class="admin-modal show" id="editPublicationModal">
    <div class="modal-dialog" style="max-width: 680px;">
        <div class="modal-header">
            <h3 class="modal-title">Edit Publication</h3>
            <a href="dept-publications.php?dept=<?= $deptCode ?>" class="btn-close-modal">&times;</a>
        </div>
        <form action="dept-publications.php?dept=<?= $deptCode ?>" method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">

            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_title">Paper / Publication Title <span class="required">*</span></label>
                    <textarea name="title" id="edit_title" class="form-control" rows="2" required><?= htmlspecialchars($editItem['title']) ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_authors">Member / Author Name(s) <span class="required">*</span></label>
                    <input type="text" name="authors" id="edit_authors" class="form-control" value="<?= htmlspecialchars($editItem['authors']) ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label class="form-label" for="edit_date">Date / Month & Year <span class="required">*</span></label>
                        <input type="text" name="pub_date" id="edit_date" class="form-control" value="<?= htmlspecialchars($editItem['pub_date']) ?>" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="edit_year">4-Digit Year</label>
                        <input type="text" name="pub_year" id="edit_year" class="form-control" value="<?= htmlspecialchars($editItem['pub_year']) ?>">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label" for="edit_order">Display Order</label>
                        <input type="number" name="display_order" id="edit_order" class="form-control" value="<?= htmlspecialchars($editItem['display_order']) ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_journal">Journal / Conference / Publisher Details</label>
                    <input type="text" name="journal_details" id="edit_journal" class="form-control" value="<?= htmlspecialchars($editItem['journal_details'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_url">Paper URL / DOI Link</label>
                    <input type="text" name="paper_url" id="edit_url" class="form-control" value="<?= htmlspecialchars($editItem['paper_url'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                        <span>Display on public department website (Active)</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="dept-publications.php?dept=<?= $deptCode ?>" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary">Update Publication</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

