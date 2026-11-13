<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Council of Heads Management";
$current_page = 'council-of-heads';

$activeTab = $_GET['tab'] ?? 'council'; // 'council', 'iqac', 'hod', 'cells', 'contacts'
$editId = isset($_GET['edit_id']) ? (int)$_GET['edit_id'] : 0;

// Handle POST submissions
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header("Location: council-of-heads.php?tab={$activeTab}");
        exit;
    }

    $action = $_POST['action'] ?? '';

    // =========================================================================
    // 1. COUNCIL OF HEADS ACTIONS
    // =========================================================================
    if ($action === 'add_council') {
        $section_name = trim($_POST['section_name'] ?? '');
        $designation = trim($_POST['designation'] ?? 'Convener');
        $section_head = trim($_POST['section_head'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if (empty($section_name) || empty($section_head)) {
            setFlashMessage('danger', 'Section name and Section head are required.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO council_of_heads (section_name, designation, section_head, display_order) VALUES (?, ?, ?, ?)");
            $stmt->execute([$section_name, $designation, $section_head, $display_order]);
            setFlashMessage('success', 'Council member added successfully.');
        }
        header('Location: council-of-heads.php?tab=council');
        exit;
    }

    if ($action === 'edit_council') {
        $id = (int)($_POST['id'] ?? 0);
        $section_name = trim($_POST['section_name'] ?? '');
        $designation = trim($_POST['designation'] ?? 'Convener');
        $section_head = trim($_POST['section_head'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if ($id > 0 && !empty($section_name) && !empty($section_head)) {
            $stmt = $pdo->prepare("UPDATE council_of_heads SET section_name = ?, designation = ?, section_head = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$section_name, $designation, $section_head, $display_order, $id]);
            setFlashMessage('success', 'Council entry updated successfully.');
        } else {
            setFlashMessage('danger', 'Invalid details provided.');
        }
        header('Location: council-of-heads.php?tab=council');
        exit;
    }

    if ($action === 'delete_council') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM council_of_heads WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('success', 'Council entry removed.');
        }
        header('Location: council-of-heads.php?tab=council');
        exit;
    }

    // =========================================================================
    // 2. IQAC ACTIONS
    // =========================================================================
    if ($action === 'add_iqac') {
        $name = trim($_POST['name'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $status_role = trim($_POST['status_role'] ?? 'Member');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if (empty($name)) {
            setFlashMessage('danger', 'Member name is required.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO iqac_members (name, designation, status_role, display_order) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $designation, $status_role, $display_order]);
            setFlashMessage('success', 'IQAC member added successfully.');
        }
        header('Location: council-of-heads.php?tab=iqac');
        exit;
    }

    if ($action === 'edit_iqac') {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $status_role = trim($_POST['status_role'] ?? 'Member');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if ($id > 0 && !empty($name)) {
            $stmt = $pdo->prepare("UPDATE iqac_members SET name = ?, designation = ?, status_role = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$name, $designation, $status_role, $display_order, $id]);
            setFlashMessage('success', 'IQAC member updated.');
        }
        header('Location: council-of-heads.php?tab=iqac');
        exit;
    }

    if ($action === 'delete_iqac') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM iqac_members WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('success', 'IQAC member deleted.');
        }
        header('Location: council-of-heads.php?tab=iqac');
        exit;
    }

    // =========================================================================
    // 3. HEAD OF DEPARTMENTS ACTIONS
    // =========================================================================
    if ($action === 'add_hod') {
        $department_name = trim($_POST['department_name'] ?? '');
        $designation = trim($_POST['designation'] ?? 'Professor');
        $faculty_name = trim($_POST['faculty_name'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if (empty($department_name) || empty($faculty_name)) {
            setFlashMessage('danger', 'Department name and Faculty name are required.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO head_of_departments (department_name, designation, faculty_name, display_order) VALUES (?, ?, ?, ?)");
            $stmt->execute([$department_name, $designation, $faculty_name, $display_order]);
            setFlashMessage('success', 'HOD added successfully.');
        }
        header('Location: council-of-heads.php?tab=hod');
        exit;
    }

    if ($action === 'edit_hod') {
        $id = (int)($_POST['id'] ?? 0);
        $department_name = trim($_POST['department_name'] ?? '');
        $designation = trim($_POST['designation'] ?? 'Professor');
        $faculty_name = trim($_POST['faculty_name'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if ($id > 0 && !empty($department_name) && !empty($faculty_name)) {
            $stmt = $pdo->prepare("UPDATE head_of_departments SET department_name = ?, designation = ?, faculty_name = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$department_name, $designation, $faculty_name, $display_order, $id]);
            setFlashMessage('success', 'HOD updated successfully.');
        }
        header('Location: council-of-heads.php?tab=hod');
        exit;
    }

    if ($action === 'delete_hod') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM head_of_departments WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('success', 'HOD record deleted.');
        }
        header('Location: council-of-heads.php?tab=hod');
        exit;
    }

    // =========================================================================
    // 4. IMPORTANT CELLS & COMMITTEES ACTIONS
    // =========================================================================
    if ($action === 'add_cell') {
        $cell_name = trim($_POST['cell_name'] ?? '');
        $designation = trim($_POST['designation'] ?? 'Coordinator');
        $officer_name = trim($_POST['officer_name'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if (empty($cell_name) || empty($officer_name)) {
            setFlashMessage('danger', 'Cell name and Officer name are required.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO important_cells (cell_name, designation, officer_name, display_order) VALUES (?, ?, ?, ?)");
            $stmt->execute([$cell_name, $designation, $officer_name, $display_order]);
            setFlashMessage('success', 'Cell coordinator added.');
        }
        header('Location: council-of-heads.php?tab=cells');
        exit;
    }

    if ($action === 'edit_cell') {
        $id = (int)($_POST['id'] ?? 0);
        $cell_name = trim($_POST['cell_name'] ?? '');
        $designation = trim($_POST['designation'] ?? 'Coordinator');
        $officer_name = trim($_POST['officer_name'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if ($id > 0 && !empty($cell_name) && !empty($officer_name)) {
            $stmt = $pdo->prepare("UPDATE important_cells SET cell_name = ?, designation = ?, officer_name = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$cell_name, $designation, $officer_name, $display_order, $id]);
            setFlashMessage('success', 'Cell coordinator updated.');
        }
        header('Location: council-of-heads.php?tab=cells');
        exit;
    }

    if ($action === 'delete_cell') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM important_cells WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('success', 'Cell record deleted.');
        }
        header('Location: council-of-heads.php?tab=cells');
        exit;
    }

    // =========================================================================
    // 5. IMPORTANT CONTACTS ACTIONS
    // =========================================================================
    if ($action === 'add_contact') {
        $sr_no = (int)($_POST['sr_no'] ?? 1);
        $organization_name = trim($_POST['organization_name'] ?? '');
        $contact_number = trim($_POST['contact_number'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if (empty($organization_name) || empty($contact_number)) {
            setFlashMessage('danger', 'Organization name and contact number are required.');
        } else {
            $stmt = $pdo->prepare("INSERT INTO important_contacts (sr_no, organization_name, contact_number, display_order) VALUES (?, ?, ?, ?)");
            $stmt->execute([$sr_no, $organization_name, $contact_number, $display_order]);
            setFlashMessage('success', 'Emergency / Important contact added.');
        }
        header('Location: council-of-heads.php?tab=contacts');
        exit;
    }

    if ($action === 'edit_contact') {
        $id = (int)($_POST['id'] ?? 0);
        $sr_no = (int)($_POST['sr_no'] ?? 1);
        $organization_name = trim($_POST['organization_name'] ?? '');
        $contact_number = trim($_POST['contact_number'] ?? '');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if ($id > 0 && !empty($organization_name) && !empty($contact_number)) {
            $stmt = $pdo->prepare("UPDATE important_contacts SET sr_no = ?, organization_name = ?, contact_number = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$sr_no, $organization_name, $contact_number, $display_order, $id]);
            setFlashMessage('success', 'Contact updated successfully.');
        }
        header('Location: council-of-heads.php?tab=contacts');
        exit;
    }

    if ($action === 'delete_contact') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM important_contacts WHERE id = ?");
            $stmt->execute([$id]);
            setFlashMessage('success', 'Contact removed.');
        }
        header('Location: council-of-heads.php?tab=contacts');
        exit;
    }
}

// Fetch Active Data
$councilList = $pdo ? $pdo->query("SELECT * FROM council_of_heads ORDER BY display_order ASC, id ASC")->fetchAll() : [];
$iqacList = $pdo ? $pdo->query("SELECT * FROM iqac_members ORDER BY display_order ASC, id ASC")->fetchAll() : [];
$hodList = $pdo ? $pdo->query("SELECT * FROM head_of_departments ORDER BY display_order ASC, id ASC")->fetchAll() : [];
$cellsList = $pdo ? $pdo->query("SELECT * FROM important_cells ORDER BY display_order ASC, id ASC")->fetchAll() : [];
$contactsList = $pdo ? $pdo->query("SELECT * FROM important_contacts ORDER BY display_order ASC, id ASC")->fetchAll() : [];

// Fetch item for editing if requested
$editItem = null;
if ($editId > 0 && $pdo) {
    if ($activeTab === 'council') {
        $stmt = $pdo->prepare("SELECT * FROM council_of_heads WHERE id = ?");
        $stmt->execute([$editId]);
        $editItem = $stmt->fetch();
    } elseif ($activeTab === 'iqac') {
        $stmt = $pdo->prepare("SELECT * FROM iqac_members WHERE id = ?");
        $stmt->execute([$editId]);
        $editItem = $stmt->fetch();
    } elseif ($activeTab === 'hod') {
        $stmt = $pdo->prepare("SELECT * FROM head_of_departments WHERE id = ?");
        $stmt->execute([$editId]);
        $editItem = $stmt->fetch();
    } elseif ($activeTab === 'cells') {
        $stmt = $pdo->prepare("SELECT * FROM important_cells WHERE id = ?");
        $stmt->execute([$editId]);
        $editItem = $stmt->fetch();
    } elseif ($activeTab === 'contacts') {
        $stmt = $pdo->prepare("SELECT * FROM important_contacts WHERE id = ?");
        $stmt->execute([$editId]);
        $editItem = $stmt->fetch();
    }
}

include __DIR__ . '/includes/header.php';
?>

<div class="content-header-action" style="display: flex; justify-content: flex-end; margin-bottom: 1.5rem;">
    <a href="../council-of-heads.php" target="_blank" class="btn btn-outline-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 500;">
        <i class="fas fa-external-link-alt"></i> View Public Council of Heads Page
    </a>
</div>

<!-- Navigation Tabs -->
<div class="card" style="margin-bottom: 1.5rem; padding: 0.5rem;">
    <ul class="nav nav-tabs-modern" style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin: 0; padding: 0; list-style: none;">
        <li>
            <a href="council-of-heads.php?tab=council" class="btn <?= ($activeTab === 'council') ? 'btn-primary' : 'btn-light' ?>" style="font-weight: 600;">
                <i class="fas fa-users-cog"></i> Council of Heads (<?= count($councilList) ?>)
            </a>
        </li>
        <li>
            <a href="council-of-heads.php?tab=iqac" class="btn <?= ($activeTab === 'iqac') ? 'btn-primary' : 'btn-light' ?>" style="font-weight: 600;">
                <i class="fas fa-award"></i> IQAC Cell (<?= count($iqacList) ?>)
            </a>
        </li>
        <li>
            <a href="council-of-heads.php?tab=hod" class="btn <?= ($activeTab === 'hod') ? 'btn-primary' : 'btn-light' ?>" style="font-weight: 600;">
                <i class="fas fa-user-tie"></i> Head of Departments (<?= count($hodList) ?>)
            </a>
        </li>
        <li>
            <a href="council-of-heads.php?tab=cells" class="btn <?= ($activeTab === 'cells') ? 'btn-primary' : 'btn-light' ?>" style="font-weight: 600;">
                <i class="fas fa-sitemap"></i> Important Cells &amp; Committees (<?= count($cellsList) ?>)
            </a>
        </li>
        <li>
            <a href="council-of-heads.php?tab=contacts" class="btn <?= ($activeTab === 'contacts') ? 'btn-primary' : 'btn-light' ?>" style="font-weight: 600;">
                <i class="fas fa-phone-alt"></i> Important Contacts (<?= count($contactsList) ?>)
            </a>
        </li>
    </ul>
</div>

<!-- ========================================================================= -->
<!-- TAB 1: COUNCIL OF HEADS -->
<!-- ========================================================================= -->
<?php if ($activeTab === 'council'): ?>
<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-<?= $editItem ? 'edit' : 'plus-circle' ?> text-primary"></i> 
        <?= $editItem ? 'Edit Council Entry' : 'Add New Council Section / Convener' ?>
    </div>
    <form method="POST" action="council-of-heads.php?tab=council">
        <input type="hidden" name="action" value="<?= $editItem ? 'edit_council' : 'add_council' ?>">
        <?php if ($editItem): ?>
            <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Sections / Domain <span class="text-danger">*</span></label>
                <input type="text" name="section_name" class="form-control" required placeholder="e.g. Student Affairs" value="<?= htmlspecialchars($editItem['section_name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Designation</label>
                <input type="text" name="designation" class="form-control" placeholder="Convener" value="<?= htmlspecialchars($editItem['designation'] ?? 'Convener') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Section Head / Officer <span class="text-danger">*</span></label>
                <input type="text" name="section_head" class="form-control" required placeholder="e.g. Dr. S. S. Singh (Prof. Civil Dept.)" value="<?= htmlspecialchars($editItem['section_head'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Display Priority</label>
                <input type="number" name="display_order" class="form-control" value="<?= (int)($editItem['display_order'] ?? (count($councilList) + 1)) ?>">
            </div>
        </div>

        <div style="margin-top: 1.25rem; display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary" style="font-weight: 600;">
                <i class="fas fa-save"></i> <?= $editItem ? 'Update Entry' : 'Add to Council Table' ?>
            </button>
            <?php if ($editItem): ?>
                <a href="council-of-heads.php?tab=council" class="btn btn-light">Cancel Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
        <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b;">
            Council of Head Directory (<?= count($councilList) ?>)
        </div>
        <input type="text" data-table-search="councilTable" class="form-control" placeholder="Search sections or heads..." style="max-width: 280px;">
    </div>

    <div class="table-responsive">
        <table class="table" id="councilTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th>Sections</th>
                    <th>Designation</th>
                    <th>Section Head</th>
                    <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($councilList)): ?>
                    <tr class="no-records-row"><td colspan="5" class="text-center" style="padding: 2rem; color: #64748b;">No council records found.</td></tr>
                <?php else: ?>
                    <?php foreach ($councilList as $item): ?>
                        <tr>
                            <td><span class="badge badge-light" style="font-size: 0.9rem;"><?= (int)$item['display_order'] ?></span></td>
                            <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($item['section_name']) ?></td>
                            <td><span class="badge badge-primary"><?= htmlspecialchars($item['designation']) ?></span></td>
                            <td style="color: #334155;"><?= htmlspecialchars($item['section_head']) ?></td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 0.4rem;">
                                    <a href="council-of-heads.php?tab=council&edit_id=<?= (int)$item['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="council-of-heads.php?tab=council" onsubmit="return confirm('Are you sure you want to delete this council entry?');" style="margin: 0;">
                                        <input type="hidden" name="action" value="delete_council">
                                        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
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
<?php endif; ?>

<!-- ========================================================================= -->
<!-- TAB 2: IQAC CELL -->
<!-- ========================================================================= -->
<?php if ($activeTab === 'iqac'): ?>
<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-<?= $editItem ? 'edit' : 'plus-circle' ?> text-primary"></i> 
        <?= $editItem ? 'Edit IQAC Member' : 'Add New IQAC Member' ?>
    </div>
    <form method="POST" action="council-of-heads.php?tab=iqac">
        <input type="hidden" name="action" value="<?= $editItem ? 'edit_iqac' : 'add_iqac' ?>">
        <?php if ($editItem): ?>
            <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Member Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required placeholder="e.g. Dr. J. A. Vadher" value="<?= htmlspecialchars($editItem['name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Designation</label>
                <input type="text" name="designation" class="form-control" placeholder="e.g. Prof. and Head Electrical Engg. Dept." value="<?= htmlspecialchars($editItem['designation'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Status / Role <span class="text-danger">*</span></label>
                <input type="text" name="status_role" class="form-control" required placeholder="Chairman / Convener / Member / External Member" value="<?= htmlspecialchars($editItem['status_role'] ?? 'Member') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Display Priority</label>
                <input type="number" name="display_order" class="form-control" value="<?= (int)($editItem['display_order'] ?? (count($iqacList) + 1)) ?>">
            </div>
        </div>

        <div style="margin-top: 1.25rem; display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary" style="font-weight: 600;">
                <i class="fas fa-save"></i> <?= $editItem ? 'Update IQAC Member' : 'Add to IQAC Table' ?>
            </button>
            <?php if ($editItem): ?>
                <a href="council-of-heads.php?tab=iqac" class="btn btn-light">Cancel Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
        <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b;">
            Internal Quality Assurance Cell Members (<?= count($iqacList) ?>)
        </div>
        <input type="text" data-table-search="iqacTable" class="form-control" placeholder="Search IQAC members..." style="max-width: 280px;">
    </div>

    <div class="table-responsive">
        <table class="table" id="iqacTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Status</th>
                    <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($iqacList)): ?>
                    <tr class="no-records-row"><td colspan="5" class="text-center" style="padding: 2rem; color: #64748b;">No IQAC members found.</td></tr>
                <?php else: ?>
                    <?php foreach ($iqacList as $item): ?>
                        <tr>
                            <td><span class="badge badge-light"><?= (int)$item['display_order'] ?></span></td>
                            <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($item['name']) ?></td>
                            <td style="color: #475569;"><?= htmlspecialchars($item['designation']) ?></td>
                            <td>
                                <?php if ($item['status_role'] === 'Chairman'): ?>
                                    <span class="badge badge-success" style="background: #0284c7;"><?= htmlspecialchars($item['status_role']) ?></span>
                                <?php elseif ($item['status_role'] === 'Convener'): ?>
                                    <span class="badge badge-primary"><?= htmlspecialchars($item['status_role']) ?></span>
                                <?php else: ?>
                                    <span class="badge badge-light" style="color: #475569; font-weight: 500;"><?= htmlspecialchars($item['status_role']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 0.4rem;">
                                    <a href="council-of-heads.php?tab=iqac&edit_id=<?= (int)$item['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="council-of-heads.php?tab=iqac" onsubmit="return confirm('Are you sure you want to delete this IQAC member?');" style="margin: 0;">
                                        <input type="hidden" name="action" value="delete_iqac">
                                        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
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
<?php endif; ?>

<!-- ========================================================================= -->
<!-- TAB 3: HEAD OF DEPARTMENTS -->
<!-- ========================================================================= -->
<?php if ($activeTab === 'hod'): ?>
<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-<?= $editItem ? 'edit' : 'plus-circle' ?> text-primary"></i> 
        <?= $editItem ? 'Edit Head of Department' : 'Add New Head of Department' ?>
    </div>
    <form method="POST" action="council-of-heads.php?tab=hod">
        <input type="hidden" name="action" value="<?= $editItem ? 'edit_hod' : 'add_hod' ?>">
        <?php if ($editItem): ?>
            <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Department Name <span class="text-danger">*</span></label>
                <input type="text" name="department_name" class="form-control" required placeholder="e.g. Computer Engineering Department" value="<?= htmlspecialchars($editItem['department_name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Designation</label>
                <input type="text" name="designation" class="form-control" placeholder="e.g. Associate Professor / Professor" value="<?= htmlspecialchars($editItem['designation'] ?? 'Professor') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Faculty Name <span class="text-danger">*</span></label>
                <input type="text" name="faculty_name" class="form-control" required placeholder="e.g. Prof. M. M. Goyani" value="<?= htmlspecialchars($editItem['faculty_name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Display Priority</label>
                <input type="number" name="display_order" class="form-control" value="<?= (int)($editItem['display_order'] ?? (count($hodList) + 1)) ?>">
            </div>
        </div>

        <div style="margin-top: 1.25rem; display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary" style="font-weight: 600;">
                <i class="fas fa-save"></i> <?= $editItem ? 'Update HOD' : 'Add HOD' ?>
            </button>
            <?php if ($editItem): ?>
                <a href="council-of-heads.php?tab=hod" class="btn btn-light">Cancel Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
        <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b;">
            Head of Department Directory (<?= count($hodList) ?>)
        </div>
        <input type="text" data-table-search="hodTable" class="form-control" placeholder="Search departments or HODs..." style="max-width: 280px;">
    </div>

    <div class="table-responsive">
        <table class="table" id="hodTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Name</th>
                    <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($hodList)): ?>
                    <tr class="no-records-row"><td colspan="5" class="text-center" style="padding: 2rem; color: #64748b;">No HOD records found.</td></tr>
                <?php else: ?>
                    <?php foreach ($hodList as $item): ?>
                        <tr>
                            <td><span class="badge badge-light"><?= (int)$item['display_order'] ?></span></td>
                            <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($item['department_name']) ?></td>
                            <td><span class="badge badge-light" style="color: #475569;"><?= htmlspecialchars($item['designation']) ?></span></td>
                            <td style="font-weight: 600; color: #0284c7;"><?= htmlspecialchars($item['faculty_name']) ?></td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 0.4rem;">
                                    <a href="council-of-heads.php?tab=hod&edit_id=<?= (int)$item['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="council-of-heads.php?tab=hod" onsubmit="return confirm('Are you sure you want to delete this HOD?');" style="margin: 0;">
                                        <input type="hidden" name="action" value="delete_hod">
                                        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
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
<?php endif; ?>

<!-- ========================================================================= -->
<!-- TAB 4: IMPORTANT CELLS & COMMITTEES -->
<!-- ========================================================================= -->
<?php if ($activeTab === 'cells'): ?>
<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-<?= $editItem ? 'edit' : 'plus-circle' ?> text-primary"></i> 
        <?= $editItem ? 'Edit Cell / Committee Officer' : 'Add New Cell / Committee Officer' ?>
    </div>
    <form method="POST" action="council-of-heads.php?tab=cells">
        <input type="hidden" name="action" value="<?= $editItem ? 'edit_cell' : 'add_cell' ?>">
        <?php if ($editItem): ?>
            <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Cell / Committee Name <span class="text-danger">*</span></label>
                <input type="text" name="cell_name" class="form-control" required placeholder="e.g. Training & Placement Cell" value="<?= htmlspecialchars($editItem['cell_name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Designation</label>
                <input type="text" name="designation" class="form-control" placeholder="Coordinator / Co-Coordinator / Rector / Cashier" value="<?= htmlspecialchars($editItem['designation'] ?? 'Coordinator') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Officer / Faculty Name <span class="text-danger">*</span></label>
                <input type="text" name="officer_name" class="form-control" required placeholder="e.g. Prof. (Dr.) M. M. Goyani (Associate Prof. in Computer Dept.)" value="<?= htmlspecialchars($editItem['officer_name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Display Priority</label>
                <input type="number" name="display_order" class="form-control" value="<?= (int)($editItem['display_order'] ?? (count($cellsList) + 1)) ?>">
            </div>
        </div>

        <div style="margin-top: 1.25rem; display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary" style="font-weight: 600;">
                <i class="fas fa-save"></i> <?= $editItem ? 'Update Officer' : 'Add to Cells Table' ?>
            </button>
            <?php if ($editItem): ?>
                <a href="council-of-heads.php?tab=cells" class="btn btn-light">Cancel Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
        <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b;">
            Important Cells and Committees (<?= count($cellsList) ?>)
        </div>
        <input type="text" data-table-search="cellsTable" class="form-control" placeholder="Search cells or officers..." style="max-width: 280px;">
    </div>

    <div class="table-responsive">
        <table class="table" id="cellsTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th>Cells</th>
                    <th>Designation</th>
                    <th>Name of Officer</th>
                    <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($cellsList)): ?>
                    <tr class="no-records-row"><td colspan="5" class="text-center" style="padding: 2rem; color: #64748b;">No cells or committees found.</td></tr>
                <?php else: ?>
                    <?php foreach ($cellsList as $item): ?>
                        <tr>
                            <td><span class="badge badge-light"><?= (int)$item['display_order'] ?></span></td>
                            <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($item['cell_name']) ?></td>
                            <td><span class="badge badge-primary"><?= htmlspecialchars($item['designation']) ?></span></td>
                            <td style="color: #334155;"><?= htmlspecialchars($item['officer_name']) ?></td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 0.4rem;">
                                    <a href="council-of-heads.php?tab=cells&edit_id=<?= (int)$item['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="council-of-heads.php?tab=cells" onsubmit="return confirm('Are you sure you want to delete this cell entry?');" style="margin: 0;">
                                        <input type="hidden" name="action" value="delete_cell">
                                        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
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
<?php endif; ?>

<!-- ========================================================================= -->
<!-- TAB 5: IMPORTANT CONTACTS -->
<!-- ========================================================================= -->
<?php if ($activeTab === 'contacts'): ?>
<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-<?= $editItem ? 'edit' : 'plus-circle' ?> text-primary"></i> 
        <?= $editItem ? 'Edit Important Contact' : 'Add New Important Contact' ?>
    </div>
    <form method="POST" action="council-of-heads.php?tab=contacts">
        <input type="hidden" name="action" value="<?= $editItem ? 'edit_contact' : 'add_contact' ?>">
        <?php if ($editItem): ?>
            <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Sr. No.</label>
                <input type="number" name="sr_no" class="form-control" value="<?= (int)($editItem['sr_no'] ?? (count($contactsList) + 1)) ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Organization / Authority <span class="text-danger">*</span></label>
                <input type="text" name="organization_name" class="form-control" required placeholder="e.g. Police Station, Modasa" value="<?= htmlspecialchars($editItem['organization_name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Contact Number <span class="text-danger">*</span></label>
                <input type="text" name="contact_number" class="form-control" required placeholder="e.g. 02774-246660" value="<?= htmlspecialchars($editItem['contact_number'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Display Priority</label>
                <input type="number" name="display_order" class="form-control" value="<?= (int)($editItem['display_order'] ?? (count($contactsList) + 1)) ?>">
            </div>
        </div>

        <div style="margin-top: 1.25rem; display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary" style="font-weight: 600;">
                <i class="fas fa-save"></i> <?= $editItem ? 'Update Contact' : 'Add Contact' ?>
            </button>
            <?php if ($editItem): ?>
                <a href="council-of-heads.php?tab=contacts" class="btn btn-light">Cancel Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
        <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b;">
            Emergency &amp; Important Contacts Directory (<?= count($contactsList) ?>)
        </div>
        <input type="text" data-table-search="contactsTable" class="form-control" placeholder="Search contacts..." style="max-width: 280px;">
    </div>

    <div class="table-responsive">
        <table class="table" id="contactsTable">
            <thead>
                <tr>
                    <th style="width: 70px;">Sr.</th>
                    <th>Organization / Authority</th>
                    <th>Contact Number</th>
                    <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($contactsList)): ?>
                    <tr class="no-records-row"><td colspan="4" class="text-center" style="padding: 2rem; color: #64748b;">No contact numbers found.</td></tr>
                <?php else: ?>
                    <?php foreach ($contactsList as $item): ?>
                        <tr>
                            <td><span class="badge badge-light"><?= (int)$item['sr_no'] ?></span></td>
                            <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($item['organization_name']) ?></td>
                            <td>
                                <a href="tel:<?= preg_replace('/[^0-9+]/', '', $item['contact_number']) ?>" style="color: #0284c7; font-weight: 600; text-decoration: none;">
                                    <i class="fas fa-phone-alt" style="font-size: 0.85rem; margin-right: 0.35rem;"></i> <?= htmlspecialchars($item['contact_number']) ?>
                                </a>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 0.4rem;">
                                    <a href="council-of-heads.php?tab=contacts&edit_id=<?= (int)$item['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="council-of-heads.php?tab=contacts" onsubmit="return confirm('Are you sure you want to delete this contact?');" style="margin: 0;">
                                        <input type="hidden" name="action" value="delete_contact">
                                        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
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
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
