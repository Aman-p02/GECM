<?php
/**
 * Faculty Login Portal
 */
session_start();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/includes/auth.php';

// If already logged in, redirect to dashboard
if (isset($_SESSION['faculty_user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$flash = getFacultyFlash();

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
                // Find faculty by username OR email
                $stmt = $pdo->prepare("SELECT id, dept_code, username, name, email, password_hash, is_registered, is_active FROM faculties WHERE (username = ? OR email = ?) LIMIT 1");
                $stmt->execute([$identifier, $identifier]);
                $faculty = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$faculty) {
                    $error = 'No faculty found with this Username or Email.';
                } elseif (empty($faculty['is_registered']) || empty($faculty['password_hash'])) {
                    $error = 'Your profile is not registered yet. Please click on Register first.';
                } elseif (empty($faculty['is_active'])) {
                    $error = 'Your faculty account is currently marked inactive. Please contact the administrator.';
                } elseif (!password_verify($password, $faculty['password_hash'])) {
                    $error = 'Invalid password. Please check and try again.';
                } else {
                    // Successful login
                    $_SESSION['faculty_user_id'] = $faculty['id'];
                    $_SESSION['faculty_name'] = $faculty['name'];
                    $_SESSION['faculty_dept'] = $faculty['dept_code'];

                    // Update last_login timestamp
                    $updateStmt = $pdo->prepare("UPDATE faculties SET last_login = NOW() WHERE id = ?");
                    $updateStmt->execute([$faculty['id']]);

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
    <title>Faculty Login : GEC Modasa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/fac-admin.css">
</head>
<body class="auth-wrapper">

    <div class="auth-card">
        <div class="auth-header">
            <img src="../assets/images/logo.png" alt="GEC Modasa Logo">
            <h1>Faculty Login Portal</h1>
            <p>Log in to manage your public academic portfolio</p>
        </div>

        <?php if (!empty($flash)): ?>
            <div class="alert alert-<?= htmlspecialchars($flash['type']) ?>">
                <i class="fa-solid fa-circle-info"></i>
                <span><?= htmlspecialchars($flash['message']) ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="form-group">
                <label class="form-label" for="identifier">
                    Username or Registered Email <span class="required">*</span>
                </label>
                <input type="text" name="identifier" id="identifier" class="form-control" placeholder="Enter username or email address" value="<?= htmlspecialchars($_POST['identifier'] ?? '') ?>" required autofocus autocomplete="username">
            </div>

            <div class="form-group">
                <label class="form-label" for="password">
                    Password <span class="required">*</span>
                </label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required autocomplete="current-password">
            </div>

            <button type="submit" class="btn btn-navy btn-block" style="margin-top: 24px;">
                <i class="fa-solid fa-right-to-bracket"></i> Sign In to Faculty Portal
            </button>
        </form>

        <div class="auth-footer">
            New here or first time setting up? <a href="register.php">Register your account</a>
            <div style="margin-top: 12px;">
                <a href="../index.php" style="color: var(--text-muted); font-weight: normal; font-size: 12px;">
                    <i class="fa-solid fa-arrow-left"></i> Back to GEC Modasa Website
                </a>
            </div>
        </div>
    </div>

</body>
</html>

