<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

// Self-healing database table setup
if ($pdo) {
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `scholarship_committee` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `academic_year` VARCHAR(30) NOT NULL DEFAULT '2025-26',
            `category` VARCHAR(100) NOT NULL DEFAULT 'Convener & Leadership',
            `faculty_name` VARCHAR(255) NOT NULL,
            `role_duties` TEXT NOT NULL,
            `cabin_no` VARCHAR(100) NOT NULL,
            `display_order` INT NOT NULL DEFAULT 0,
            `is_active` TINYINT(1) NOT NULL DEFAULT 1,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `idx_sc_order` (`academic_year`, `is_active`, `display_order`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    } catch (Exception $e) {
        error_log("Error creating scholarship_committee table: " . $e->getMessage());
    }
}

// Standard categories for scholarship committee
$standardCategories = [
    'Convener & Leadership',
    'Co In-charge (SEBC Scholarship)',
    'Co In-charge (SC / ST Scholarship)',
    'Co In-charge (MYSY / CMSS Scholarship)',
    'Co In-charge (PMSS & Other Scholarship)',
    'General Committee'
];

// Auto-seed standard 14 committee rows if table is empty
if ($pdo) {
    try {
        $checkCount = (int)$pdo->query("SELECT COUNT(*) FROM scholarship_committee")->fetchColumn();
        if ($checkCount === 0) {
            $initialMembers = [
                [
                    'category' => 'Convener & Leadership',
                    'faculty_name' => 'Prof. D. R. Tarachandani (Asso. Prof and Head, AM Dept.)',
                    'role_duties' => 'Convener',
                    'cabin_no' => 'Main Building',
                    'display_order' => 1
                ],
                [
                    'category' => 'Convener & Leadership',
                    'faculty_name' => 'Prof. M. M. Bhunga (Asst. Prof, AM Dept)',
                    'role_duties' => "Co-Convener\nMOMA Scholarship / NSP Scholarship\nSEBC Scholarship",
                    'cabin_no' => '1217',
                    'display_order' => 2
                ],
                [
                    'category' => 'Co In-charge (SEBC Scholarship)',
                    'faculty_name' => 'Prof. V. A. Rathod (Asst. Prof, IT Dept)',
                    'role_duties' => "SEBC/EBC (1st Year) / PM-Yashashvi\nM.E Comp Scholarship",
                    'cabin_no' => '8216',
                    'display_order' => 3
                ],
                [
                    'category' => 'Co In-charge (SEBC Scholarship)',
                    'faculty_name' => 'Prof. Sumit Banker (Asst. Prof, EE Dept)',
                    'role_duties' => "SEBC/EBC (1st Year) / BCK-79 / BCK-80",
                    'cabin_no' => '7201',
                    'display_order' => 4
                ],
                [
                    'category' => 'Co In-charge (SEBC Scholarship)',
                    'faculty_name' => 'Prof. Parul A. Bhura (Asst. Prof, CE Dept)',
                    'role_duties' => "SEBC/EBC (2nd Year) / PM-Yashashvi",
                    'cabin_no' => '8112',
                    'display_order' => 5
                ],
                [
                    'category' => 'Co In-charge (SEBC Scholarship)',
                    'faculty_name' => 'Prof. Sachin Ganchi (Asst. Prof, ME Dept)',
                    'role_duties' => "SEBC/EBC (2nd Year) / BCK-79 / BCK-80",
                    'cabin_no' => '2108',
                    'display_order' => 6
                ],
                [
                    'category' => 'Co In-charge (SEBC Scholarship)',
                    'faculty_name' => 'Prof. Shilpa A. Rana (Asst. Prof, EC Dept)',
                    'role_duties' => "SEBC/EBC (3rd Year) / PM-Yashashvi",
                    'cabin_no' => '4117',
                    'display_order' => 7
                ],
                [
                    'category' => 'Co In-charge (SEBC Scholarship)',
                    'faculty_name' => 'Prof. Sanket Bhatiya (Asst. Prof, ME Dept)',
                    'role_duties' => "SEBC/EBC (3rd Year) / BCK-79 / BCK-80",
                    'cabin_no' => '6218-B',
                    'display_order' => 8
                ],
                [
                    'category' => 'Co In-charge (SEBC Scholarship)',
                    'faculty_name' => 'Prof. Dron H. Chaudhari (Asst. Prof, Civil Dept)',
                    'role_duties' => "SEBC/EBC (4th Year) / PM-Yashashvi\nM.E Civil Scholarship",
                    'cabin_no' => '1220',
                    'display_order' => 9
                ],
                [
                    'category' => 'Co In-charge (SEBC Scholarship)',
                    'faculty_name' => 'Prof. Dinesh B. Sathawara (Asst. Prof, AM Dept)',
                    'role_duties' => "SEBC/EBC (4th Year) / BCK-79 / BCK-80",
                    'cabin_no' => '1130',
                    'display_order' => 10
                ],
                [
                    'category' => 'Co In-charge (SC / ST Scholarship)',
                    'faculty_name' => 'Prof. H. I. Chaudhary (Asst. Prof, ME Dept)',
                    'role_duties' => "SC Scholarship / ST Scholarship",
                    'cabin_no' => '6219-B',
                    'display_order' => 11
                ],
                [
                    'category' => 'Co In-charge (MYSY / CMSS Scholarship)',
                    'faculty_name' => 'Prof. S. R. Patel (Asst. Prof, CE Dept)',
                    'role_duties' => "MYSY / CMSS Scholarship",
                    'cabin_no' => 'CE-8115',
                    'display_order' => 12
                ],
                [
                    'category' => 'Co In-charge (MYSY / CMSS Scholarship)',
                    'faculty_name' => 'Prof. N. V. Nagekar (Asst. Prof, CE Dept)',
                    'role_duties' => "MYSY / CMSS Scholarship",
                    'cabin_no' => 'CE-8217',
                    'display_order' => 13
                ],
                [
                    'category' => 'Co In-charge (PMSS & Other Scholarship)',
                    'faculty_name' => 'Prof. C. K. Bariya (Asst. Prof, EE Dept)',
                    'role_duties' => "PMSSS / Shram Vibhag / ONGC / Other Scholarships",
                    'cabin_no' => '7201',
                    'display_order' => 14
                ]
            ];

            $insStmt = $pdo->prepare("INSERT INTO scholarship_committee 
                (academic_year, category, faculty_name, role_duties, cabin_no, display_order, is_active) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");

            foreach ($initialMembers as $im) {
                $insStmt->execute([
                    '2025-26',
                    $im['category'],
                    $im['faculty_name'],
                    $im['role_duties'],
                    $im['cabin_no'],
                    $im['display_order'],
                    1
                ]);
            }
        }
    } catch (Exception $e) {
        error_log("Seed error: " . $e->getMessage());
    }
}

// Handle Form Submissions (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP.');
        header('Location: scholarships.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $academic_year = trim($_POST['academic_year'] ?? '2025-26');
        $category = trim($_POST['category'] ?? 'Convener & Leadership');
        $faculty_name = trim($_POST['faculty_name'] ?? '');
        $role_duties = trim($_POST['role_duties'] ?? '');
        $cabin_no = trim($_POST['cabin_no'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($faculty_name) || empty($role_duties)) {
            setFlashMessage('danger', 'Faculty Name and Role/Duties are required.');
            header('Location: scholarships.php');
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO scholarship_committee (academic_year, category, faculty_name, role_duties, cabin_no, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$academic_year, $category, $faculty_name, $role_duties, $cabin_no, $display_order, $is_active]);

        setFlashMessage('success', 'Committee member added successfully!');
        header('Location: scholarships.php');
        exit;

    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $academic_year = trim($_POST['academic_year'] ?? '2025-26');
        $category = trim($_POST['category'] ?? 'Convener & Leadership');
        $faculty_name = trim($_POST['faculty_name'] ?? '');
        $role_duties = trim($_POST['role_duties'] ?? '');
        $cabin_no = trim($_POST['cabin_no'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (empty($faculty_name) || empty($role_duties) || $id <= 0) {
            setFlashMessage('danger', 'Valid ID, Faculty Name, and Role/Duties are required.');
            header('Location: scholarships.php');
            exit;
        }

        $stmt = $pdo->prepare("UPDATE scholarship_committee SET academic_year = ?, category = ?, faculty_name = ?, role_duties = ?, cabin_no = ?, display_order = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$academic_year, $category, $faculty_name, $role_duties, $cabin_no, $display_order, $is_active, $id]);

        setFlashMessage('success', 'Committee member details updated successfully!');
        header('Location: scholarships.php');
        exit;
    }
}

// Handle GET Actions (Delete, Toggle, Edit)
if (isset($_GET['delete'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: scholarships.php');
        exit;
    }
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM scholarship_committee WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Committee member removed successfully!');
        header('Location: scholarships.php');
        exit;
    }
}

if (isset($_GET['toggle'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline.');
        header('Location: scholarships.php');
        exit;
    }
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE scholarship_committee SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('info', 'Visibility status updated successfully!');
        header('Location: scholarships.php');
        exit;
    }
}

if (isset($_GET['edit']) && $pdo) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM scholarship_committee WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

// Fetch Records with optional category filter
$filterCat = trim($_GET['cat'] ?? '');
$records = [];
if ($pdo) {
    try {
        if (!empty($filterCat)) {
            $stmt = $pdo->prepare("SELECT * FROM scholarship_committee WHERE category = ? ORDER BY display_order ASC, id ASC");
            $stmt->execute([$filterCat]);
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $records = $pdo->query("SELECT * FROM scholarship_committee ORDER BY display_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (Exception $e) {
        $records = [];
    }
}

$current_page = 'scholarships';
$page_title = 'Scholarship Committee Management';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <h2 class="card-title">Scholarship Committee Management</h2>
            <p style="font-size: 13.5px; color: #64748b; margin: 4px 0 0 0;">
                Manage faculty coordinators, assigned roles/duties, and cabin allocations for official student scholarships.
            </p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <a href="../student-corner/scholarships" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; text-decoration: none;">
                <i class="fas fa-external-link-alt"></i> View Public Page
            </a>
            <button type="button" class="btn-add-new" onclick="openModal('addMemberModal')">
                <i class="fas fa-plus"></i> Add Committee Member
            </button>
        </div>
    </div>

    <!-- Category Filter Row -->
    <div class="card-actions-row" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px; margin-bottom: 20px;">
        <div style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
            <a href="scholarships.php" class="btn btn-sm <?= empty($filterCat) ? 'btn-primary' : 'btn-secondary' ?>" style="text-decoration: none; border-radius: 20px; padding: 5px 14px; font-size: 12.5px;">
                All Groups (<?= count($pdo ? $pdo->query("SELECT id FROM scholarship_committee")->fetchAll() : []) ?>)
            </a>
            <?php foreach ($standardCategories as $catOption): ?>
                <a href="scholarships.php?cat=<?= urlencode($catOption) ?>" class="btn btn-sm <?= ($filterCat === $catOption) ? 'btn-primary' : 'btn-secondary' ?>" style="text-decoration: none; border-radius: 20px; padding: 5px 14px; font-size: 12.5px;">
                    <?= htmlspecialchars($catOption) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="search-input-group" style="margin-left: auto;">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" id="committeeSearch" placeholder="Search faculty, duty, cabin..." onkeyup="filterCommitteeTable()">
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="committeeTable">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">Order</th>
                    <th style="width: 28%;">Name of Faculty/Staff</th>
                    <th style="width: 24%;">Category / Group</th>
                    <th>Role / Duties</th>
                    <th style="width: 120px; text-align: center;">Cabin No.</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="width: 110px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $row): ?>
                <tr>
                    <td style="font-weight: 700; color: #0284c7; text-align: center;">#<?= (int)$row['display_order'] ?></td>
                    <td style="font-weight: 600; color: #0f172a;">
                        <?= htmlspecialchars($row['faculty_name']) ?>
                    </td>
                    <td>
                        <span style="font-size: 11.5px; font-weight: 600; color: #0284c7; background: #f0f9ff; border: 1px solid #bae6fd; padding: 3px 8px; border-radius: 4px;">
                            <?= htmlspecialchars($row['category']) ?>
                        </span>
                    </td>
                    <td style="color: #334155; font-size: 13px; line-height: 1.45;">
                        <?= nl2br(htmlspecialchars($row['role_duties'])) ?>
                    </td>
                    <td style="text-align: center;">
                        <span style="font-weight: 600; color: #475569; font-size: 12.5px;">
                            <?= htmlspecialchars($row['cabin_no']) ?>
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="scholarships.php?toggle=<?= (int)$row['id'] ?><?= !empty($filterCat) ? '&cat=' . urlencode($filterCat) : '' ?>" title="Click to toggle status" style="text-decoration: none;">
                            <?php if ($row['is_active']): ?>
                                <span class="badge badge-success" style="cursor: pointer;">Visible</span>
                            <?php else: ?>
                                <span class="badge badge-secondary" style="cursor: pointer; background: #94a3b8; color: #ffffff;">Hidden</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <div class="table-actions" style="justify-content: center; gap: 8px;">
                            <a href="scholarships.php?edit=<?= (int)$row['id'] ?><?= !empty($filterCat) ? '&cat=' . urlencode($filterCat) : '' ?>" class="btn-table-action btn-edit" title="Edit Details">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="scholarships.php?delete=<?= (int)$row['id'] ?>" class="btn-table-action btn-delete" title="Delete Member" onclick="return confirm('Are you sure you want to remove <?= htmlspecialchars(addslashes($row['faculty_name'])) ?> from the committee?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($records)): ?>
                <tr class="no-records-row">
                    <td colspan="7" style="text-align: center; color: #64748b; padding: 36px 16px;">
                        No committee members found in this category. Click "+ Add Committee Member" above to create one.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add Committee Member -->
<div class="modal-overlay" id="addMemberModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Add Scholarship Committee Member</h3>
            <button type="button" class="modal-close" onclick="closeModal('addMemberModal')">&times;</button>
        </div>
        <form method="POST" action="scholarships.php">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Academic Year <span class="required">*</span></label>
                        <input type="text" name="academic_year" class="form-control" value="2025-26" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Category / Group <span class="required">*</span></label>
                        <select name="category" class="form-control" required>
                            <?php foreach ($standardCategories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Name of Faculty/Staff &amp; Designation <span class="required">*</span></label>
                    <input type="text" name="faculty_name" class="form-control" placeholder="e.g. Prof. D. R. Tarachandani (Asso. Prof and Head, AM Dept.)" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Role / Duties <span class="required">*</span></label>
                    <textarea name="role_duties" class="form-control" rows="3" placeholder="e.g. Convener or SEBC/EBC (1st Year) / PM-Yashashvi" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Cabin No. <span class="required">*</span></label>
                        <input type="text" name="cabin_no" class="form-control" placeholder="e.g. Main Building or 1217 or 8216" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="0" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check" style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin-top: 10px;">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Visible on public website</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addMemberModal')">Cancel</button>
                <button type="submit" class="btn-primary">Add Member</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Committee Member -->
<?php if ($editItem): ?>
<div class="modal-overlay active show" id="editMemberModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Edit Committee Member #<?= (int)$editItem['id'] ?></h3>
            <a href="scholarships.php<?= !empty($filterCat) ? '?cat=' . urlencode($filterCat) : '' ?>" class="modal-close">&times;</a>
        </div>
        <form method="POST" action="scholarships.php">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Academic Year <span class="required">*</span></label>
                        <input type="text" name="academic_year" class="form-control" value="<?= htmlspecialchars($editItem['academic_year']) ?>" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Category / Group <span class="required">*</span></label>
                        <select name="category" class="form-control" required>
                            <?php foreach ($standardCategories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat) ?>" <?= ($editItem['category'] === $cat) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Name of Faculty/Staff &amp; Designation <span class="required">*</span></label>
                    <input type="text" name="faculty_name" class="form-control" value="<?= htmlspecialchars($editItem['faculty_name']) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Role / Duties <span class="required">*</span></label>
                    <textarea name="role_duties" class="form-control" rows="3" required><?= htmlspecialchars($editItem['role_duties']) ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Cabin No. <span class="required">*</span></label>
                        <input type="text" name="cabin_no" class="form-control" value="<?= htmlspecialchars($editItem['cabin_no']) ?>" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" class="form-control" value="<?= (int)$editItem['display_order'] ?>" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check" style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin-top: 10px;">
                        <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                        <span>Visible on public website</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="scholarships.php<?= !empty($filterCat) ? '?cat=' . urlencode($filterCat) : '' ?>" class="btn-secondary" style="text-decoration: none;">Cancel</a>
                <button type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<script>
function filterCommitteeTable() {
    var input = document.getElementById('committeeSearch');
    if (!input) return;
    var filter = input.value.toLowerCase();
    var table = document.getElementById('committeeTable');
    if (!table) return;
    var trs = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    for (var i = 0; i < trs.length; i++) {
        if (trs[i].classList.contains('no-records-row')) continue;
        var text = trs[i].textContent.toLowerCase();
        if (text.indexOf(filter) > -1) {
            trs[i].style.display = '';
        } else {
            trs[i].style.display = 'none';
        }
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
