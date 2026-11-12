<?php
/**
 * Faculty Qualifications Management
 */
$pageTitle = 'Manage Qualifications';
$pageHeading = 'Academic Qualifications';
$activeTab = 'qualifications';

require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$error = '';
$facultyId = (int)$faculty['id'];

// Handle Actions (Add, Edit, Delete)
$action = $_GET['action'] ?? '';
$editId = (int)($_GET['edit_id'] ?? 0);

// DELETE action (Strictly protected by faculty_id)
if ($action === 'delete' && !empty($_GET['id'])) {
    $delId = (int)$_GET['id'];
    try {
        $delStmt = $pdo->prepare("DELETE FROM faculty_qualifications WHERE id = ? AND faculty_id = ?");
        $delStmt->execute([$delId, $facultyId]);
        setFacultyFlash('success', 'Qualification deleted successfully.');
        header('Location: qualifications.php');
        exit;
    } catch (Exception $e) {
        $error = 'Delete failed: ' . $e->getMessage();
    }
}

// POST: Add or Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qualName = trim($_POST['qualification'] ?? '');
    $university = trim($_POST['university'] ?? '');
    $yearOfPassing = trim($_POST['year_of_passing'] ?? '');
    $percentage = trim($_POST['percentage'] ?? '');
    $displayOrder = (int)($_POST['display_order'] ?? 0);
    $submitId = (int)($_POST['record_id'] ?? 0);

    if (empty($qualName) || empty($university) || empty($yearOfPassing)) {
        $error = 'Qualification, University/Board, and Year of Passing are required.';
    } else {
        try {
            if ($submitId > 0) {
                // UPDATE (Strict IDOR check: WHERE id = ? AND faculty_id = ?)
                $stmt = $pdo->prepare("UPDATE faculty_qualifications SET 
                    qualification = ?, 
                    university = ?, 
                    year_of_passing = ?, 
                    percentage = ?, 
                    display_order = ? 
                    WHERE id = ? AND faculty_id = ?");
                $stmt->execute([$qualName, $university, $yearOfPassing, $percentage, $displayOrder, $submitId, $facultyId]);
                setFacultyFlash('success', 'Qualification updated successfully.');
            } else {
                // INSERT (Strictly set faculty_id to logged in user)
                $stmt = $pdo->prepare("INSERT INTO faculty_qualifications (faculty_id, qualification, university, year_of_passing, percentage, display_order) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$facultyId, $qualName, $university, $yearOfPassing, $percentage, $displayOrder]);
                setFacultyFlash('success', 'New qualification added successfully.');
            }
            header('Location: qualifications.php');
            exit;
        } catch (Exception $e) {
            $error = 'Save failed: ' . $e->getMessage();
        }
    }
}

// Fetch record for editing if requested
$editRecord = null;
if ($action === 'edit' && $editId > 0) {
    $editStmt = $pdo->prepare("SELECT * FROM faculty_qualifications WHERE id = ? AND faculty_id = ?");
    $editStmt->execute([$editId, $facultyId]);
    $editRecord = $editStmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch all qualifications belonging exclusively to this faculty
$stmt = $pdo->prepare("SELECT * FROM faculty_qualifications WHERE faculty_id = ? ORDER BY display_order ASC, year_of_passing DESC");
$stmt->execute([$facultyId]);
$qualifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<!-- Form Card: Add or Edit -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3>
            <i class="fa-solid fa-<?= $editRecord ? 'pen-to-square' : 'plus-circle' ?>"></i>
            <?= $editRecord ? 'Edit Qualification' : 'Add New Academic Qualification' ?>
        </h3>
        <?php if ($editRecord): ?>
            <a href="qualifications.php" class="btn btn-outline btn-sm">Cancel Edit</a>
        <?php endif; ?>
    </div>

    <div class="admin-card-body">
        <form method="POST" action="qualifications.php">
            <input type="hidden" name="record_id" value="<?= htmlspecialchars($editRecord['id'] ?? 0) ?>">

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="qualification">Degree / Qualification <span class="required">*</span></label>
                    <input type="text" name="qualification" id="qualification" class="form-control" placeholder="e.g. Ph.D. or M.E. (Computer Engineering)" value="<?= htmlspecialchars($editRecord['qualification'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="university">University / Board / Institution <span class="required">*</span></label>
                    <input type="text" name="university" id="university" class="form-control" placeholder="e.g. Gujarat Technological University, Ahmedabad" value="<?= htmlspecialchars($editRecord['university'] ?? '') ?>" required>
                </div>
            </div>

            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label" for="year_of_passing">Year of Passing <span class="required">*</span></label>
                    <input type="text" name="year_of_passing" id="year_of_passing" class="form-control" placeholder="e.g. 2018" value="<?= htmlspecialchars($editRecord['year_of_passing'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="percentage">Percentage / CGPA / CPI</label>
                    <input type="text" name="percentage" id="percentage" class="form-control" placeholder="e.g. 8.5 CPI or 78%" value="<?= htmlspecialchars($editRecord['percentage'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="display_order">Display Sort Order</label>
                    <input type="number" name="display_order" id="display_order" class="form-control" value="<?= htmlspecialchars($editRecord['display_order'] ?? 0) ?>">
                    <small style="color:var(--text-muted); font-size:11px;">Lower number displays first (e.g. 0, 1, 2)</small>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:15px;">
                <button type="submit" class="btn btn-navy">
                    <i class="fa-solid fa-floppy-disk"></i> <?= $editRecord ? 'Update Qualification' : 'Save Qualification' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- List Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fa-solid fa-list-check"></i> Your Qualifications List (<?= count($qualifications) ?>)</h3>
    </div>

    <div class="data-table-wrapper">
        <?php if (empty($qualifications)): ?>
            <div class="empty-state">
                <i class="fa-solid fa-graduation-cap"></i>
                <p>No qualifications added yet. Use the form above to add your degrees.</p>
            </div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Qualification</th>
                        <th>University / Board</th>
                        <th>Passing Year</th>
                        <th>Perc. / CPI</th>
                        <th style="width: 140px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($qualifications as $idx => $q): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td><strong><?= htmlspecialchars($q['qualification']) ?></strong></td>
                            <td><?= htmlspecialchars($q['university']) ?></td>
                            <td><?= htmlspecialchars($q['year_of_passing']) ?></td>
                            <td><?= !empty($q['percentage']) ? htmlspecialchars($q['percentage']) : '-' ?></td>
                            <td style="text-align: right;">
                                <a href="qualifications.php?action=edit&edit_id=<?= (int)$q['id'] ?>" class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="qualifications.php?action=delete&id=<?= (int)$q['id'] ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this qualification?');">
                                    <i class="fa-solid fa-trash"></i>
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
