<?php
/**
 * Faculty Login Portal - Matches Main Admin Login Theme
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
                    $error = 'Your profile is not registered yet. Please click on Register below first.';
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/fac-admin.css">
</head>
<body class="fac-auth-body">

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="brand-logo-frame">
                    <img src="../logos/logo.png" alt="GEC Modasa">
                </div>
                <h1 class="login-title">Faculty Portal</h1>
                <p class="login-subtitle">Government Engineering College Modasa</p>
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
                    <i class="fas fa-sign-in-alt"></i> Sign In to Faculty Portal
                </button>
            </form>

            <div class="login-footer">
                <div>
                    New faculty member? <a href="register.php">Register your account</a>
                </div>
                <a href="../index.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to GEC Modasa Website
                </a>
            </div>
        </div>
    </div>

</body>
</html>
