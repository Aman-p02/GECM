<?php
/**
 * Faculty Change Password
 */
$pageTitle = 'Change Password';
$pageHeading = 'Account Security';
$activeTab = 'password';

require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = 'All password fields are required.';
    } elseif (strlen($newPassword) < 6) {
        $error = 'New password must be at least 6 characters long.';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'New password and confirmation do not match.';
    } else {
        try {
            // Verify current password
            $stmt = $pdo->prepare("SELECT password_hash FROM faculties WHERE id = ?");
            $stmt->execute([(int)$faculty['id']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
                $error = 'Current password is incorrect.';
            } else {
                $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $update = $pdo->prepare("UPDATE faculties SET password_hash = ?, updated_at = NOW() WHERE id = ?");
                $update->execute([$newHash, (int)$faculty['id']]);

                setFacultyFlash('success', 'Your password has been changed successfully.');
                header('Location: change-password.php');
                exit;
            }
        } catch (Exception $e) {
            $error = 'Password update error: ' . $e->getMessage();
        }
    }
}
?>

<div class="admin-card" style="max-width: 600px;">
    <div class="admin-card-header">
        <h3><i class="fa-solid fa-key"></i> Update Account Password</h3>
    </div>

    <div class="admin-card-body">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="change-password.php">
            <div class="form-group">
                <label class="form-label" for="current_password">Current Password <span class="required">*</span></label>
                <input type="password" name="current_password" id="current_password" class="form-control" required autocomplete="current-password">
            </div>

            <div class="form-group">
                <label class="form-label" for="new_password">New Password <span class="required">*</span></label>
                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Minimum 6 characters" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <label class="form-label" for="confirm_password">Confirm New Password <span class="required">*</span></label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Retype new password" required autocomplete="new-password">
            </div>

            <div style="margin-top: 24px;">
                <button type="submit" class="btn btn-navy">
                    <i class="fa-solid fa-lock"></i> Update Password
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

