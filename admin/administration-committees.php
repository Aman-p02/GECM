<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Committees Management";
$current_page = 'administration-committees';

$activeCommitteeId = isset($_GET['committee_id']) ? (int)$_GET['committee_id'] : 0;
$editMemberId = isset($_GET['edit_member_id']) ? (int)$_GET['edit_member_id'] : 0;

// Fetch all committees
$committees = $pdo ? $pdo->query("SELECT * FROM campus_committees ORDER BY display_order ASC, id ASC")->fetchAll() : [];

// Default to first committee if none selected
if ($activeCommitteeId === 0 && !empty($committees)) {
    $activeCommitteeId = (int)$committees[0]['id'];
}

// Handle Form Submissions
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: administration-committees.php');
        exit;
    }

    $action = $_POST['action'] ?? '';

    // 1. UPDATE COMMITTEE DETAILS
    if ($action === 'update_committee') {
        $cId = (int)($_POST['committee_id'] ?? 0);
        $committee_name = trim($_POST['committee_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $objectives = trim($_POST['objectives'] ?? '');

        if ($cId > 0 && !empty($committee_name)) {
            $stmt = $pdo->prepare("UPDATE campus_committees SET committee_name = ?, description = ?, objectives = ? WHERE id = ?");
            $stmt->execute([$committee_name, $description, $objectives, $cId]);
            setFlashMessage('success', 'Committee details updated successfully.');
        } else {
            setFlashMessage('danger', 'Invalid committee details.');
        }
        header("Location: administration-committees.php?committee_id={$cId}");
        exit;
    }

    // 2. ADD MEMBER
    if ($action === 'add_member') {
        $cId = (int)($_POST['committee_id'] ?? 0);
        $sr_no = (int)($_POST['sr_no'] ?? 1);
        $faculty_name = trim($_POST['faculty_name'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $role = trim($_POST['role'] ?? 'Member');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if ($cId > 0 && !empty($faculty_name)) {
            $stmt = $pdo->prepare("INSERT INTO committee_members (committee_id, sr_no, faculty_name, designation, role, display_order) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$cId, $sr_no, $faculty_name, $designation, $role, $display_order]);
            setFlashMessage('success', 'Committee member added successfully.');
        } else {
            setFlashMessage('danger', 'Faculty name is required.');
        }
        header("Location: administration-committees.php?committee_id={$cId}");
        exit;
    }

    // 3. EDIT MEMBER
    if ($action === 'edit_member') {
        $mId = (int)($_POST['member_id'] ?? 0);
        $cId = (int)($_POST['committee_id'] ?? 0);
        $sr_no = (int)($_POST['sr_no'] ?? 1);
        $faculty_name = trim($_POST['faculty_name'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $role = trim($_POST['role'] ?? 'Member');
        $display_order = (int)($_POST['display_order'] ?? 0);

        if ($mId > 0 && !empty($faculty_name)) {
            $stmt = $pdo->prepare("UPDATE committee_members SET sr_no = ?, faculty_name = ?, designation = ?, role = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$sr_no, $faculty_name, $designation, $role, $display_order, $mId]);
            setFlashMessage('success', 'Member record updated.');
        } else {
            setFlashMessage('danger', 'Faculty name is required.');
        }
        header("Location: administration-committees.php?committee_id={$cId}");
        exit;
    }

    // 4. DELETE MEMBER
    if ($action === 'delete_member') {
        $mId = (int)($_POST['member_id'] ?? 0);
        $cId = (int)($_POST['committee_id'] ?? 0);
        if ($mId > 0) {
            $stmt = $pdo->prepare("DELETE FROM committee_members WHERE id = ?");
            $stmt->execute([$mId]);
            setFlashMessage('success', 'Committee member removed.');
        }
        header("Location: administration-committees.php?committee_id={$cId}");
        exit;
    }

    // 5. CREATE NEW COMMITTEE
    if ($action === 'create_committee') {
        $committee_name = trim($_POST['committee_name'] ?? '');
        $committee_slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $committee_name)));
        $description = trim($_POST['description'] ?? '');
        $objectives = trim($_POST['objectives'] ?? '');

        if (!empty($committee_name)) {
            $stmt = $pdo->prepare("INSERT INTO campus_committees (committee_slug, committee_name, description, objectives, display_order) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$committee_slug, $committee_name, $description, $objectives, count($committees) + 1]);
            $newId = $pdo->lastInsertId();
            setFlashMessage('success', 'New committee created successfully.');
            header("Location: administration-committees.php?committee_id={$newId}");
            exit;
        } else {
            setFlashMessage('danger', 'Committee name is required.');
            header('Location: administration-committees.php');
            exit;
        }
    }
}

// Current Selected Committee Data
$currentCommittee = null;
$members = [];
$editMember = null;

if ($activeCommitteeId > 0 && $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM campus_committees WHERE id = ?");
    $stmt->execute([$activeCommitteeId]);
    $currentCommittee = $stmt->fetch();

    $mStmt = $pdo->prepare("SELECT * FROM committee_members WHERE committee_id = ? ORDER BY display_order ASC, sr_no ASC, id ASC");
    $mStmt->execute([$activeCommitteeId]);
    $members = $mStmt->fetchAll();

    if ($editMemberId > 0) {
        $eStmt = $pdo->prepare("SELECT * FROM committee_members WHERE id = ?");
        $eStmt->execute([$editMemberId]);
        $editMember = $eStmt->fetch();
    }
}

include __DIR__ . '/includes/header.php';
?>

<div class="content-header-action" style="display: flex; justify-content: flex-end; margin-bottom: 1.5rem;">
    <a href="../committees.php?c=<?= urlencode($currentCommittee['committee_slug'] ?? 'anti-ragging') ?>" target="_blank" class="btn btn-outline-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 500;">
        <i class="fas fa-external-link-alt"></i> View Public Committees Page
    </a>
</div>

<!-- Committee Selector Tabs -->
<div class="card" style="margin-bottom: 1.5rem; padding: 0.5rem;">
    <ul class="nav nav-tabs-modern" style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin: 0; padding: 0; list-style: none;">
        <?php foreach ($committees as $comm): ?>
            <li>
                <a href="administration-committees.php?committee_id=<?= (int)$comm['id'] ?>" class="btn <?= ($activeCommitteeId == $comm['id']) ? 'btn-primary' : 'btn-light' ?>" style="font-weight: 600;">
                    <i class="fas fa-users"></i> <?= htmlspecialchars($comm['committee_name']) ?>
                </a>
            </li>
        <?php endforeach; ?>
        <li>
            <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('newCommitteeForm').style.display='block'; window.scrollTo(0, document.getElementById('newCommitteeForm').offsetTop);" style="font-weight: 600;">
                <i class="fas fa-plus"></i> Add New Committee
            </button>
        </li>
    </ul>
</div>

<!-- Add New Committee Block (Hidden by default) -->
<div id="newCommitteeForm" class="card" style="display: none; margin-bottom: 1.5rem; border-left: 4px solid #0284c7;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1rem;">
        <i class="fas fa-folder-plus text-primary"></i> Create New Committee
    </div>
    <form method="POST" action="administration-committees.php">
        <input type="hidden" name="action" value="create_committee">
        <div class="form-group" style="margin-bottom: 1rem;">
            <label class="form-label" style="font-weight: 600;">Committee Name <span class="text-danger">*</span></label>
            <input type="text" name="committee_name" class="form-control" required placeholder="e.g. Grievance Redressal Committee">
        </div>
        <div class="form-group" style="margin-bottom: 1rem;">
            <label class="form-label" style="font-weight: 600;">Introductory Text / UGC Regulation Context</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Background details, legal backing, or constitution note..."></textarea>
        </div>
        <div class="form-group" style="margin-bottom: 1rem;">
            <label class="form-label" style="font-weight: 600;">Objectives (Bullet points)</label>
            <textarea name="objectives" class="form-control" rows="3" placeholder="• Objective 1&#10;• Objective 2"></textarea>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary" style="font-weight: 600;">Create Committee</button>
            <button type="button" class="btn btn-light" onclick="document.getElementById('newCommitteeForm').style.display='none';">Cancel</button>
        </div>
    </form>
</div>

<?php if ($currentCommittee): ?>
<!-- Committee Text & Objectives Form -->
<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-edit text-primary"></i> Edit <?= htmlspecialchars($currentCommittee['committee_name']) ?> Details
    </div>
    <form method="POST" action="administration-committees.php?committee_id=<?= (int)$currentCommittee['id'] ?>">
        <input type="hidden" name="action" value="update_committee">
        <input type="hidden" name="committee_id" value="<?= (int)$currentCommittee['id'] ?>">

        <div class="form-group" style="margin-bottom: 1rem;">
            <label class="form-label" style="font-weight: 600;">Committee Display Name <span class="text-danger">*</span></label>
            <input type="text" name="committee_name" class="form-control" required value="<?= htmlspecialchars($currentCommittee['committee_name']) ?>">
        </div>

        <div class="form-group" style="margin-bottom: 1rem;">
            <label class="form-label" style="font-weight: 600;">Introductory Text / Background</label>
            <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($currentCommittee['description'] ?? '') ?></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 1.25rem;">
            <label class="form-label" style="font-weight: 600;">Objectives (Optional)</label>
            <textarea name="objectives" class="form-control" rows="4"><?= htmlspecialchars($currentCommittee['objectives'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="font-weight: 600;">
            <i class="fas fa-save"></i> Save Committee Details
        </button>
    </form>
</div>

<!-- Add / Edit Member Form -->
<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-<?= $editMember ? 'user-edit' : 'user-plus' ?> text-primary"></i> 
        <?= $editMember ? 'Edit Committee Member' : 'Add Member to ' . htmlspecialchars($currentCommittee['committee_name']) ?>
    </div>
    <form method="POST" action="administration-committees.php?committee_id=<?= (int)$currentCommittee['id'] ?>">
        <input type="hidden" name="action" value="<?= $editMember ? 'edit_member' : 'add_member' ?>">
        <input type="hidden" name="committee_id" value="<?= (int)$currentCommittee['id'] ?>">
        <?php if ($editMember): ?>
            <input type="hidden" name="member_id" value="<?= (int)$editMember['id'] ?>">
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem;">
            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Sr. No.</label>
                <input type="number" name="sr_no" class="form-control" value="<?= (int)($editMember['sr_no'] ?? (count($members) + 1)) ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Name of Faculty / Member <span class="text-danger">*</span></label>
                <input type="text" name="faculty_name" class="form-control" required placeholder="e.g. Prof. (Dr.) U. V. Shah" value="<?= htmlspecialchars($editMember['faculty_name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Designation</label>
                <input type="text" name="designation" class="form-control" placeholder="e.g. Prof. & Head, Mech. Engg. Dept." value="<?= htmlspecialchars($editMember['designation'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Role <span class="text-danger">*</span></label>
                <input type="text" name="role" class="form-control" required placeholder="Coordinator / Co-coordinator / Member" value="<?= htmlspecialchars($editMember['role'] ?? 'Member') ?>">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Display Priority</label>
                <input type="number" name="display_order" class="form-control" value="<?= (int)($editMember['display_order'] ?? (count($members) + 1)) ?>">
            </div>
        </div>

        <div style="margin-top: 1.25rem; display: flex; gap: 0.75rem;">
            <button type="submit" class="btn btn-primary" style="font-weight: 600;">
                <i class="fas fa-save"></i> <?= $editMember ? 'Update Member' : 'Add Member' ?>
            </button>
            <?php if ($editMember): ?>
                <a href="administration-committees.php?committee_id=<?= (int)$currentCommittee['id'] ?>" class="btn btn-light">Cancel Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Members Table -->
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
        <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b;">
            Current Members in <?= htmlspecialchars($currentCommittee['committee_name']) ?> (<?= count($members) ?>)
        </div>
        <input type="text" data-table-search="membersTable" class="form-control" placeholder="Search members..." style="max-width: 260px;">
    </div>

    <div class="table-responsive">
        <table class="table" id="membersTable">
            <thead>
                <tr>
                    <th style="width: 70px;">Sr. No.</th>
                    <th>Name of Faculty</th>
                    <th>Designation</th>
                    <th>Role</th>
                    <th style="width: 140px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($members)): ?>
                    <tr class="no-records-row"><td colspan="5" class="text-center" style="padding: 2rem; color: #64748b;">No members added yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($members as $m): ?>
                        <tr>
                            <td><span class="badge badge-light"><?= (int)$m['sr_no'] ?></span></td>
                            <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($m['faculty_name']) ?></td>
                            <td style="color: #475569;"><?= htmlspecialchars($m['designation'] ?: '--') ?></td>
                            <td>
                                <?php if (stripos($m['role'], 'Coordinator') !== false && stripos($m['role'], 'Co-') === false): ?>
                                    <span class="badge badge-primary"><?= htmlspecialchars($m['role']) ?></span>
                                <?php elseif (stripos($m['role'], 'Co-coordinator') !== false): ?>
                                    <span class="badge badge-success" style="background: #0284c7;"><?= htmlspecialchars($m['role']) ?></span>
                                <?php else: ?>
                                    <span class="badge badge-light" style="color: #475569;"><?= htmlspecialchars($m['role']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 0.4rem;">
                                    <a href="administration-committees.php?committee_id=<?= (int)$currentCommittee['id'] ?>&edit_member_id=<?= (int)$m['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="administration-committees.php?committee_id=<?= (int)$currentCommittee['id'] ?>" onsubmit="return confirm('Are you sure you want to remove this member?');" style="margin: 0;">
                                        <input type="hidden" name="action" value="delete_member">
                                        <input type="hidden" name="committee_id" value="<?= (int)$currentCommittee['id'] ?>">
                                        <input type="hidden" name="member_id" value="<?= (int)$m['id'] ?>">
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
