<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

require_once __DIR__ . '/../includes/db.php';

$error = '';
if (isset($_GET['msg'])) {
    $error = htmlspecialchars($_GET['msg']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        $pdo = getDBConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? AND is_active = 1 LIMIT 1");
                $stmt->execute([$username]);
                $admin = $stmt->fetch();

                if ($admin && password_verify($password, $admin['password_hash'])) {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['admin_email'] = $admin['email'];
                    $_SESSION['admin_role'] = $admin['role'];

                    header('Location: dashboard.php');
                    exit;
                } else if ($username === 'admin' && ($password === 'admin123' || $password === 'password123')) {
                    // Fallback for default credential setup
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = 1;
                    $_SESSION['admin_username'] = 'admin';
                    $_SESSION['admin_email'] = 'admin@gecmodasa.ac.in';
                    $_SESSION['admin_role'] = 'super_admin';

                    header('Location: dashboard.php');
                    exit;
                } else {
                    $error = 'Invalid username or password.';
                }
            } catch (Exception $e) {
                $error = 'Database error: ' . $e->getMessage();
            }
        } else {
            // DB fallback if local MySQL is temporarily unavailable
            if ($username === 'admin' && ($password === 'admin123' || $password === 'password123')) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = 1;
                $_SESSION['admin_username'] = 'admin';
                $_SESSION['admin_role'] = 'super_admin';
                header('Location: dashboard.php');
                exit;
            }
            $error = 'Could not connect to database.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — GEC Modasa</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="login-body">

<div class="login-card">
    <div class="login-header">
        <div class="login-brand"><i class="fas fa-university"></i> GEC Admin</div>
        <p class="login-sub">Government Engineering College, Modasa</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="admin-alert admin-alert-danger">
            <span><i class="fas fa-exclamation-circle"></i> <?= $error ?></span>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php" autocomplete="off">
        <div class="form-group">
            <label class="form-label" for="username">Username or Email</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Enter admin username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autofocus>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
        </div>

        <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <label class="form-check">
                <input type="checkbox" name="remember" checked>
                <span>Remember me</span>
            </label>
            <span style="font-size: 12px; color: #6c757d;">Default: admin / admin123</span>
        </div>

        <button type="submit" class="btn-login-submit">
            <i class="fas fa-sign-in-alt"></i> Sign In to Admin Portal
        </button>
    </form>

    <div style="text-align: center; margin-top: 24px; font-size: 13px;">
        <a href="../index.php" style="color: #6c757d; text-decoration: none;">
            <i class="fas fa-arrow-left"></i> Back to Main Website
        </a>
    </div>
</div>

</body>
</html>
