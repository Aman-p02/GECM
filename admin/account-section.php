<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$page_title = "Account Section Management";
$current_page = 'account-section';

// Handle Form Submission
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: account-section.php');
        exit;
    }

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $in_charge_name = trim($_POST['in_charge_name'] ?? '');
    $in_charge_designation = trim($_POST['in_charge_designation'] ?? '');
    $cashier_name = trim($_POST['cashier_name'] ?? '');
    $office_location = trim($_POST['office_location'] ?? '');
    $contact_email = trim($_POST['contact_email'] ?? '');
    $contact_phone = trim($_POST['contact_phone'] ?? '');
    $services_offered = trim($_POST['services_offered'] ?? '');

    if (empty($title)) {
        setFlashMessage('danger', 'Section Title is required.');
    } else {
        $check = $pdo->query("SELECT id FROM account_section LIMIT 1")->fetch();
        if ($check) {
            $stmt = $pdo->prepare("UPDATE account_section SET title = ?, description = ?, in_charge_name = ?, in_charge_designation = ?, cashier_name = ?, office_location = ?, contact_email = ?, contact_phone = ?, services_offered = ? WHERE id = ?");
            $stmt->execute([$title, $description, $in_charge_name, $in_charge_designation, $cashier_name, $office_location, $contact_email, $contact_phone, $services_offered, $check['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO account_section (title, description, in_charge_name, in_charge_designation, cashier_name, office_location, contact_email, contact_phone, services_offered) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $in_charge_name, $in_charge_designation, $cashier_name, $office_location, $contact_email, $contact_phone, $services_offered]);
        }
        setFlashMessage('success', 'Account Section details updated successfully.');
    }
    header('Location: account-section.php');
    exit;
}

// Fetch existing details
$accountData = $pdo ? $pdo->query("SELECT * FROM account_section LIMIT 1")->fetch() : null;

include __DIR__ . '/includes/header.php';
?>

<div class="content-header-action" style="display: flex; justify-content: flex-end; margin-bottom: 1.5rem;">
    <a href="../account-section.php" target="_blank" class="btn btn-outline-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 500;">
        <i class="fas fa-external-link-alt"></i> View Public Account Section Page
    </a>
</div>

<div class="card" style="margin-bottom: 2rem;">
    <div style="font-weight: 600; font-size: 1.1rem; color: #1e293b; margin-bottom: 1.25rem;">
        <i class="fas fa-file-invoice-dollar text-primary"></i> Edit Account Section Information
    </div>

    <form method="POST" action="account-section.php">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem; margin-bottom: 1.25rem;">
            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label" style="font-weight: 600;">Section Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($accountData['title'] ?? 'Account Section - GEC Modasa') ?>">
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label" style="font-weight: 600;">Overview / Description</label>
                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($accountData['description'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">In-Charge Name</label>
                <input type="text" name="in_charge_name" class="form-control" value="<?= htmlspecialchars($accountData['in_charge_name'] ?? '') ?>" placeholder="e.g. Dr. M. A. Patel">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">In-Charge Designation</label>
                <input type="text" name="in_charge_designation" class="form-control" value="<?= htmlspecialchars($accountData['in_charge_designation'] ?? '') ?>" placeholder="e.g. Associate Prof. in Sci. and Hum. Dept.">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Cashier / Key Staff</label>
                <input type="text" name="cashier_name" class="form-control" value="<?= htmlspecialchars($accountData['cashier_name'] ?? '') ?>" placeholder="e.g. Shri Vipul Damor">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Office Location</label>
                <input type="text" name="office_location" class="form-control" value="<?= htmlspecialchars($accountData['office_location'] ?? '') ?>" placeholder="e.g. Administrative Block, Room No. 102">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Contact Email</label>
                <input type="email" name="contact_email" class="form-control" value="<?= htmlspecialchars($accountData['contact_email'] ?? '') ?>" placeholder="e.g. accounts@gecmodasa.ac.in">
            </div>

            <div class="form-group">
                <label class="form-label" style="font-weight: 600;">Contact Phone</label>
                <input type="text" name="contact_phone" class="form-control" value="<?= htmlspecialchars($accountData['contact_phone'] ?? '') ?>" placeholder="e.g. 02774-242633">
            </div>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label class="form-label" style="font-weight: 600;">Services Offered / Responsibilities</label>
                <textarea name="services_offered" class="form-control" rows="5" placeholder="• Tuition Fee Collection&#10;• Scholarship disbursement&#10;• Billing &amp; Audit compliance"><?= htmlspecialchars($accountData['services_offered'] ?? '') ?></textarea>
                <small class="text-muted">Enter bullet points starting with • for clean list formatting on frontend.</small>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="font-weight: 600;">
            <i class="fas fa-save"></i> Save Account Section Details
        </button>
    </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
