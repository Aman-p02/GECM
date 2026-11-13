<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Hostel & Mess Management";
$current_page = 'hostel-mess';

// Handle Form Submission
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: hostel-mess.php');
        exit;
    }

    $title = trim($_POST['title'] ?? '');
    $overview = trim($_POST['overview'] ?? '');
    $boys_hostel_capacity = trim($_POST['boys_hostel_capacity'] ?? '');
    $girls_hostel_capacity = trim($_POST['girls_hostel_capacity'] ?? '');
    $mess_details = trim($_POST['mess_details'] ?? '');
    $rector_name = trim($_POST['rector_name'] ?? '');
    $warden_info = trim($_POST['warden_info'] ?? '');
    $rules_regulations = trim($_POST['rules_regulations'] ?? '');

    if (empty($title)) {
        setFlashMessage('danger', 'Title is required.');
    } else {
        $check = $pdo->query("SELECT id FROM hostel_mess LIMIT 1")->fetch();
        if ($check) {
            $stmt = $pdo->prepare("UPDATE hostel_mess SET title = ?, overview = ?, boys_hostel_capacity = ?, girls_hostel_capacity = ?, mess_details = ?, rector_name = ?, warden_info = ?, rules_regulations = ? WHERE id = ?");
            $stmt->execute([$title, $overview, $boys_hostel_capacity, $girls_hostel_capacity, $mess_details, $rector_name, $warden_info, $rules_regulations, $check['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO hostel_mess (title, overview, boys_hostel_capacity, girls_hostel_capacity, mess_details, rector_name, warden_info, rules_regulations) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $overview, $boys_hostel_capacity, $girls_hostel_capacity, $mess_details, $rector_name, $warden_info, $rules_regulations]);
        }
        setFlashMessage('success', 'Hostel and Mess information updated successfully.');
    }
    header('Location: hostel-mess.php');
    exit;
}

// Fetch existing details
$hostelData = $pdo ? $pdo->query("SELECT * FROM hostel_mess LIMIT 1")->fetch() : null;

include __DIR__ . '/includes/header.php';
?>

<div class="content-header-action" style="display: flex; justify-content: flex-end; margin-bottom: 1.5rem;">
    <a href="../hostel-mess.php" target="_blank" class="btn btn-outline-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 500;">
        <i class="fas fa-external-link-alt"></i> View Public Hostel &amp; Mess Page
    </a>
</div>

<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-hotel text-primary"></i> Edit Hostel &amp; Mess Information
    </div>

    <form method="POST" action="hostel-mess.php">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem; margin-bottom: 1.25rem;">
            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label" style="font-weight: 600;">Page Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($hostelData['title'] ?? 'Hostel & Mess Facility - GEC Modasa') ?>">
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label" style="font-weight: 600;">Overview / Description</label>
                <textarea name="overview" class="form-control" rows="4"><?= htmlspecialchars($hostelData['overview'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Boys Hostel Capacity &amp; Blocks</label>
                <input type="text" name="boys_hostel_capacity" class="form-control" value="<?= htmlspecialchars($hostelData['boys_hostel_capacity'] ?? '') ?>" placeholder="e.g. 4 Blocks (600+ Students)">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Girls Hostel Capacity &amp; Blocks</label>
                <input type="text" name="girls_hostel_capacity" class="form-control" value="<?= htmlspecialchars($hostelData['girls_hostel_capacity'] ?? '') ?>" placeholder="e.g. 1 Dedicated Block (200+ Students)">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Rector Name &amp; Dept.</label>
                <input type="text" name="rector_name" class="form-control" value="<?= htmlspecialchars($hostelData['rector_name'] ?? '') ?>" placeholder="e.g. Dr. U. V. Shah (Professor in Mechanical Dept.) - Rector">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Assistant Rectors / Wardens</label>
                <textarea name="warden_info" class="form-control" rows="2" placeholder="• Prof. P. R. Gamit - Assistant Rector&#10;• Prof. P. V. Patel - Assistant Rector"><?= htmlspecialchars($hostelData['warden_info'] ?? '') ?></textarea>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label" style="font-weight: 600;">Mess Facilities &amp; Food Quality</label>
                <textarea name="mess_details" class="form-control" rows="4" placeholder="Cooperative mess system details, hygiene inspection, meal timings..."><?= htmlspecialchars($hostelData['mess_details'] ?? '') ?></textarea>
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label" style="font-weight: 600;">Hostel Rules &amp; Regulations</label>
                <textarea name="rules_regulations" class="form-control" rows="5" placeholder="1. Anti-ragging policy&#10;2. Gate closing timings&#10;3. Leave application procedure"><?= htmlspecialchars($hostelData['rules_regulations'] ?? '') ?></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="font-weight: 600;">
            <i class="fas fa-save"></i> Save Hostel &amp; Mess Details
        </button>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
