<?php
/**
 * Department Admin Login Portal
 */
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/includes/auth.php';

// If already logged in, redirect to dashboard
if (isset($_SESSION['dept_admin_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$flash = getDeptFlash();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($identifier) || empty($password)) {
        $error = 'Please enter both Username/Email and Password.';
    } else {
        $pdo = getDBConnection();
        if (!$pdo) {
            $error = 'Database connection error. Please try again.';
        } else {
            try {
                $stmt = $pdo->prepare("SELECT * FROM dept_admins WHERE (username = ? OR email = ?) LIMIT 1");
                $stmt->execute([$identifier, $identifier]);
                $deptAdmin = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$deptAdmin) {
                    $error = 'No Department Admin account found with this username or email.';
                } elseif (!password_verify($password, $deptAdmin['password_hash'])) {
                    $error = 'Invalid password. Please check and try again.';
                } elseif ($deptAdmin['status'] === 'pending') {
                    $error = 'Your registration request is still PENDING approval from the Super Admin. Please wait or contact college admin.';
                } elseif ($deptAdmin['status'] === 'rejected') {
                    $error = 'Your registration request was rejected by the Super Admin. Please contact college authority.';
                } elseif (empty($deptAdmin['is_active'])) {
                    $error = 'Your account has been deactivated. Please contact Super Admin.';
                } else {
                    // Approved & active
                    $_SESSION['dept_admin_id'] = $deptAdmin['id'];
                    $_SESSION['dept_admin_username'] = $deptAdmin['username'];
                    $_SESSION['dept_admin_name'] = $deptAdmin['full_name'];
                    $_SESSION['dept_admin_dept'] = $deptAdmin['dept_code'];

                    header('Location: index.php');
                    exit;
                }
            } catch (Exception $e) {
                $error = 'Login error: ' . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Admin Login : GEC Modasa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../fac-admin/css/fac-admin.css">
</head>
<body class="fac-auth-body">

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="brand-logo-frame">
                    <img src="../logos/logo.png" alt="GEC Modasa">
                </div>
                <h1 class="login-title">Dept Admin Portal</h1>
                <p class="login-subtitle">Department Administration : GEC Modasa</p>
            </div>

            <?php if (!empty($flash)): ?>
                <div class="login-alert login-alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?= htmlspecialchars($flash['message']) ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="login-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php" autocomplete="off">
                <div class="form-field">
                    <label class="form-label" for="identifier">Username or Official Email</label>
                    <div class="input-group">
                        <i class="fas fa-user field-icon"></i>
                        <input type="text" id="identifier" name="identifier" class="form-input" placeholder="Enter username or email"
                            value="<?= htmlspecialchars($_POST['identifier'] ?? '') ?>" required autofocus>
                    </div>
                </div>

                <div class="form-field">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" id="password" name="password" class="form-input"
                            placeholder="Enter password" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-sign-in-alt"></i> Sign In to Department Admin
                </button>
            </form>

            <div class="login-footer">
                <div>
                    Need a Department Admin account? <a href="register.php">Submit Request</a>
                </div>
                <a href="../index.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to GEC Modasa Website
                </a>
            </div>
        </div>
    </div>

</body>
</html>

