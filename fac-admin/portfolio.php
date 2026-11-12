<?php
/**
 * Faculty Academic Portfolio Items Management
 * Handles: publications, books, editorial, training, expert_talks, workshops, activities, experience, extra
 */
require_once __DIR__ . '/includes/auth.php';
checkFacultyAuth();

$faculty = getLoggedInFaculty();
if (!$faculty) {
    header('Location: logout.php');
    exit;
}

$facultyId = (int)$faculty['id'];
$pdo = getDBConnection();

// Allowed section types map
$sectionConfig = [
    'publications' => [
        'title' => 'Publications & Research Papers',
        'icon' => 'newspaper',
        'title_label' => 'Paper Title / Publication Headline',
        'details_label' => 'Journal / Conference / Volume / DOI / Authors Details',
        'year_label' => 'Publication Year',
        'placeholder_title' => 'e.g. Deep Learning Approaches for Medical Imaging Analysis',
        'placeholder_details' => 'e.g. IEEE Transactions on Neural Networks, Vol. 14, pp. 112-120'
    ],
    'books' => [
        'title' => 'Books & Book Chapters',
        'icon' => 'book',
        'title_label' => 'Book Title / Chapter Name',
        'details_label' => 'Publisher / ISBN / Co-Authors / Edition',
        'year_label' => 'Year of Publication',
        'placeholder_title' => 'e.g. Modern Operating System Principles',
        'placeholder_details' => 'e.g. McGraw-Hill India, ISBN: 978-0071234567'
    ],
    'editorial' => [
        'title' => 'Editorial Board Memberships & Reviewer Roles',
        'icon' => 'feather-pointed',
        'title_label' => 'Journal / Organization Name',
        'details_label' => 'Role & Editorial Details (e.g. Associate Editor, Reviewer)',
        'year_label' => 'Year / Duration',
        'placeholder_title' => 'e.g. International Journal of Computer Applications',
        'placeholder_details' => 'e.g. Reviewer of Computer Science and Engineering division'
    ],
    'training' => [
        'title' => 'Training Programs / STTP / FDP Attended',
        'icon' => 'chalkboard-user',
        'title_label' => 'Program Title',
        'details_label' => 'Organizing Body / Institution / Sponsoring Agency',
        'year_label' => 'Duration / Year',
        'placeholder_title' => 'e.g. One-Week AICTE-ATAL FDP on Cloud Security & Blockchain',
        'placeholder_details' => 'e.g. Organized by SVNIT Surat'
    ],
    'expert_talks' => [
        'title' => 'Expert Lectures & Keynote Talks Delivered',
        'icon' => 'microphone-lines',
        'title_label' => 'Topic / Title of Expert Lecture',
        'details_label' => 'Host Institution / Event / Target Audience',
        'year_label' => 'Date / Year',
        'placeholder_title' => 'e.g. Introduction to Generative AI and Transformer Architectures',
        'placeholder_details' => 'e.g. Delivered to final year engineering students at VGEC Chandkheda'
    ],
    'workshops' => [
        'title' => 'Workshops & Seminars Organized',
        'icon' => 'people-group',
        'title_label' => 'Workshop / Seminar Title',
        'details_label' => 'Role (Coordinator/Convener) & Sponsoring Agency details',
        'year_label' => 'Date / Year',
        'placeholder_title' => 'e.g. Two-Day National Workshop on IoT and Edge Computing',
        'placeholder_details' => 'e.g. Role: Coordinator. Sponsored by GUJCOST.'
    ],
    'activities' => [
        'title' => 'Department & Institutional Activities',
        'icon' => 'trophy',
        'title_label' => 'Portfolio / Activity Name',
        'details_label' => 'Responsibilities / Achievements / Description',
        'year_label' => 'Duration / Year',
        'placeholder_title' => 'e.g. Head of Department / NBA Accreditation Coordinator / SSIP Coordinator',
        'placeholder_details' => 'e.g. Guided student startup projects and managed incubation lab.'
    ],
    'experience' => [
        'title' => 'Past Professional Experience',
        'icon' => 'briefcase',
        'title_label' => 'Position & Organization',
        'details_label' => 'Key Responsibilities / Highlights',
        'year_label' => 'Period (e.g. 2012 - 2016)',
        'placeholder_title' => 'e.g. Assistant Professor at L.D. College of Engineering, Ahmedabad',
        'placeholder_details' => 'e.g. Taught Operating Systems and Database Systems.'
    ],
    'extra' => [
        'title' => 'Extra Curricular & Honors',
        'icon' => 'star',
        'title_label' => 'Honor / Award / Activity Title',
        'details_label' => 'Description / Awarding Organization',
        'year_label' => 'Year',
        'placeholder_title' => 'e.g. Best Faculty Award / NSS Officer / Cultural Committee Incharge',
        'placeholder_details' => 'e.g. Received Certificate of Appreciation from DTE Gujarat.'
    ]
];

$type = $_GET['type'] ?? 'publications';
if (!array_key_exists($type, $sectionConfig)) {
    $type = 'publications';
}

$cfg = $sectionConfig[$type];
$pageTitle = $cfg['title'];
$pageHeading = $cfg['title'];
$activeTab = $type;

$error = '';
$action = $_GET['action'] ?? '';
$editId = (int)($_GET['edit_id'] ?? 0);

// DELETE action (Strict IDOR check)
if ($action === 'delete' && !empty($_GET['id'])) {
    $delId = (int)$_GET['id'];
    try {
        $delStmt = $pdo->prepare("DELETE FROM faculty_details WHERE id = ? AND faculty_id = ? AND section_type = ?");
        $delStmt->execute([$delId, $facultyId, $type]);
        setFacultyFlash('success', 'Item deleted successfully.');
        header('Location: portfolio.php?type=' . urlencode($type));
        exit;
    } catch (Exception $e) {
        $error = 'Delete failed: ' . $e->getMessage();
    }
}

// POST: Add or Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $details = trim($_POST['details'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $displayOrder = (int)($_POST['display_order'] ?? 0);
    $submitId = (int)($_POST['record_id'] ?? 0);

    if (empty($title)) {
        $error = 'Title is a required field.';
    } else {
        try {
            if ($submitId > 0) {
                // UPDATE (Strict IDOR check)
                $stmt = $pdo->prepare("UPDATE faculty_details SET 
                    title = ?, 
                    details = ?, 
                    year = ?, 
                    display_order = ? 
                    WHERE id = ? AND faculty_id = ? AND section_type = ?");
                $stmt->execute([$title, $details, $year, $displayOrder, $submitId, $facultyId, $type]);
                setFacultyFlash('success', 'Item updated successfully.');
            } else {
                // INSERT
                $stmt = $pdo->prepare("INSERT INTO faculty_details (faculty_id, section_type, title, details, year, display_order) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$facultyId, $type, $title, $details, $year, $displayOrder]);
                setFacultyFlash('success', 'New item added successfully.');
            }
            header('Location: portfolio.php?type=' . urlencode($type));
            exit;
        } catch (Exception $e) {
            $error = 'Save failed: ' . $e->getMessage();
        }
    }
}

// Fetch record for editing
$editRecord = null;
if ($action === 'edit' && $editId > 0) {
    $editStmt = $pdo->prepare("SELECT * FROM faculty_details WHERE id = ? AND faculty_id = ? AND section_type = ?");
    $editStmt->execute([$editId, $facultyId, $type]);
    $editRecord = $editStmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch all items for this section belonging exclusively to this faculty
$stmt = $pdo->prepare("SELECT * FROM faculty_details WHERE faculty_id = ? AND section_type = ? ORDER BY display_order ASC, id DESC");
$stmt->execute([$facultyId, $type]);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . '/includes/header.php';
?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<!-- Form Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3>
            <i class="fa-solid fa-<?= $editRecord ? 'pen-to-square' : 'circle-plus' ?>"></i>
            <?= $editRecord ? 'Edit ' . htmlspecialchars($cfg['title']) : 'Add New Entry to ' . htmlspecialchars($cfg['title']) ?>
        </h3>
        <?php if ($editRecord): ?>
            <a href="portfolio.php?type=<?= urlencode($type) ?>" class="btn btn-outline btn-sm">Cancel Edit</a>
        <?php endif; ?>
    </div>

    <div class="admin-card-body">
        <form method="POST" action="portfolio.php?type=<?= urlencode($type) ?>">
            <input type="hidden" name="record_id" value="<?= htmlspecialchars($editRecord['id'] ?? 0) ?>">

            <div class="form-group">
                <label class="form-label" for="title">
                    <?= htmlspecialchars($cfg['title_label']) ?> <span class="required">*</span>
                </label>
                <input type="text" name="title" id="title" class="form-control" placeholder="<?= htmlspecialchars($cfg['placeholder_title']) ?>" value="<?= htmlspecialchars($editRecord['title'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="details">
                    <?= htmlspecialchars($cfg['details_label']) ?>
                </label>
                <textarea name="details" id="details" class="form-control" placeholder="<?= htmlspecialchars($cfg['placeholder_details']) ?>"><?= htmlspecialchars($editRecord['details'] ?? '') ?></textarea>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label" for="year">
                        <?= htmlspecialchars($cfg['year_label']) ?>
                    </label>
                    <input type="text" name="year" id="year" class="form-control" placeholder="e.g. 2024 or 2021 - 2023" value="<?= htmlspecialchars($editRecord['year'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="display_order">Display Sort Order</label>
                    <input type="number" name="display_order" id="display_order" class="form-control" value="<?= htmlspecialchars($editRecord['display_order'] ?? 0) ?>">
                    <small style="color:var(--text-muted); font-size:11px;">Lower number appears first</small>
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:15px;">
                <button type="submit" class="btn btn-navy">
                    <i class="fa-solid fa-floppy-disk"></i> <?= $editRecord ? 'Update Entry' : 'Save Entry' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- List Table Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3><i class="fa-solid fa-list-ul"></i> Saved Entries (<?= count($records) ?>)</h3>
    </div>

    <div class="data-table-wrapper">
        <?php if (empty($records)): ?>
            <div class="empty-state">
                <i class="fa-solid fa-<?= htmlspecialchars($cfg['icon']) ?>"></i>
                <p>No entries added yet in this section. Add your first entry using the form above.</p>
            </div>
        <?php else: ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Title / Details</th>
                        <th style="width: 140px;">Year / Period</th>
                        <th style="width: 120px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $idx => $r): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td>
                                <strong><?= htmlspecialchars($r['title']) ?></strong>
                                <?php if (!empty($r['details'])): ?>
                                    <div style="color: var(--text-muted); font-size: 12px; margin-top: 3px;">
                                        <?= nl2br(htmlspecialchars($r['details'])) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?= !empty($r['year']) ? htmlspecialchars($r['year']) : '-' ?></td>
                            <td style="text-align: right;">
                                <a href="portfolio.php?type=<?= urlencode($type) ?>&action=edit&edit_id=<?= (int)$r['id'] ?>" class="btn btn-outline btn-sm" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="portfolio.php?type=<?= urlencode($type) ?>&action=delete&id=<?= (int)$r['id'] ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this entry?');">
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
