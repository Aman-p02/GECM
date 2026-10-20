<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings = $_POST['settings'] ?? [];
    if (!empty($settings) && is_array($settings)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");
            foreach ($settings as $key => $val) {
                $stmt->execute([trim($key), trim($val)]);
            }
            setFlashMessage('success', 'Site settings updated successfully!');
            header('Location: settings.php');
            exit;
        } catch (Exception $e) {
            setFlashMessage('danger', 'Error updating settings: ' . $e->getMessage());
        }
    }
}

// Fetch current settings
$settings = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM site_settings");
    $rows = $stmt->fetchAll();
    foreach ($rows as $r) {
        $settings[$r['setting_key']] = $r['setting_value'];
    }
}

$current_page = 'settings';
$page_title = 'Site Settings';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-top">
        <div class="card-title-group">
            <i class="fas fa-sliders-h"></i>
            <h2 class="card-title">General Institution Settings</h2>
        </div>
    </div>

    <form method="POST" action="settings.php" style="padding: 24px;">
        <div class="form-group">
            <label class="form-label" for="college_name">College / Institute Name <span class="required">*</span></label>
            <input type="text" id="college_name" name="settings[college_name]" class="form-control" value="<?= htmlspecialchars($settings['college_name'] ?? 'Government Engineering College, Modasa') ?>" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="college_location">Location</label>
                <input type="text" id="college_location" name="settings[college_location]" class="form-control" value="<?= htmlspecialchars($settings['college_location'] ?? 'Modasa, Gujarat') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="phone_number">Contact Phone Number</label>
                <input type="text" id="phone_number" name="settings[phone_number]" class="form-control" value="<?= htmlspecialchars($settings['phone_number'] ?? '+91 2774 242631') ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="contact_email">Official Email</label>
                <input type="email" id="contact_email" name="settings[contact_email]" class="form-control" value="<?= htmlspecialchars($settings['contact_email'] ?? 'gec-modasa-dte@gujarat.gov.in') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="virtual_tour_url">Virtual Tour / YouTube Embed URL</label>
                <input type="text" id="virtual_tour_url" name="settings[virtual_tour_url]" class="form-control" value="<?= htmlspecialchars($settings['virtual_tour_url'] ?? '#') ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Full Campus Postal Address</label>
            <textarea id="address" name="settings[address]" class="form-control" rows="3"><?= htmlspecialchars($settings['address'] ?? 'Shamlaji Road, Modasa, Dist. Aravalli, Gujarat - 383315') ?></textarea>
        </div>

        <div style="margin-top: 24px; text-align: right;">
            <button type="submit" class="btn-primary" style="padding: 10px 24px;">
                <i class="fas fa-save"></i> Save Site Settings
            </button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
