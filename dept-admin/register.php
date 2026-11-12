<?php
/**
 * Department Admin Registration Portal
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
$success = '';

$pdo = getDBConnection();

$departments = [
    'CE'    => 'Computer Engineering',
    'IT'    => 'Information Technology',
    'CIVIL' => 'Civil Engineering',
    'ME'    => 'Mechanical Engineering',
    'EE'    => 'Electrical Engineering',
    'EC'    => 'Electronics & Communication',
    'AE'    => 'Automobile Engineering',
    'AM'    => 'Applied Mechanics',
    'SH'    => 'Science & Humanities'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dept_code = trim($_POST['dept_code'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($dept_code) || !array_key_exists($dept_code, $departments)) {
        $error = 'Please select a valid department.';
    } elseif (empty($full_name) || strlen($full_name) < 3) {
        $error = 'Please enter your full name.';
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid official email address.';
    } elseif (empty($username) || strlen($username) < 4) {
        $error = 'Username must be at least 4 characters long.';
    } elseif (!preg_match('/^[a-zA-Z0-9_.-]+$/', $username)) {
        $error = 'Username can only contain alphanumeric characters, underscores, and dashes.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match. Please retype.';
    } else {
        if (!$pdo) {
            $error = 'Database connection error. Please try again.';
        } else {
            try {
                // Check if username or email is already registered
                $check = $pdo->prepare("SELECT id, username, email FROM dept_admins WHERE username = ? OR email = ?");
                $check->execute([$username, $email]);
                $existing = $check->fetch(PDO::FETCH_ASSOC);

                if ($existing) {
                    if (strtolower($existing['username']) === strtolower($username)) {
                        $error = 'This username is already taken. Please choose another.';
                    } else {
                        $error = 'An account with this email address already exists.';
                    }
                } else {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO dept_admins (dept_code, full_name, designation, email, username, password_hash, status, is_active, created_at) VALUES (?, ?, ?, ?, ?, ?, 'pending', 1, NOW())");
                    $stmt->execute([$dept_code, $full_name, $designation, $email, $username, $passwordHash]);

                    $success = 'Your registration request has been submitted successfully! It is currently PENDING approval from the Super Admin. Once approved, you will be able to log in.';
                }
            } catch (Exception $e) {
                $error = 'Registration error: ' . $e->getMessage();
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
    <title>Department Admin Registration : GEC Modasa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../fac-admin/css/fac-admin.css">
</head>
<body class="fac-auth-body">

    <div class="login-wrapper wide-form">
        <div class="login-card">
            <div class="login-header">
                <div class="brand-logo-frame">
                    <img src="../logos/logo.png" alt="GEC Modasa">
                </div>
                <h1 class="login-title">Dept Admin Registration</h1>
                <p class="login-subtitle">Request access to manage your Department Portal</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="login-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="login-alert login-alert-success" style="background:#ecfdf5; border-color:#a7f3d0; color:#065f46;">
                    <i class="fas fa-circle-check" style="color:#059669; font-size:18px;"></i>
                    <span style="line-height:1.5;"><?= htmlspecialchars($success) ?></span>
                </div>
                <div style="text-align: center; margin-top: 20px;">
                    <a href="login.php" class="btn btn-navy" style="text-decoration:none;">
                        <i class="fas fa-arrow-left"></i> Go to Login Page
                    </a>
                </div>
            <?php else: ?>

            <form method="POST" action="register.php" autocomplete="off">
                <div class="form-field">
                    <label class="form-label" for="dept_code">
                        1. Select Your Department <span class="required">*</span>
                    </label>
                    <div class="input-group">
                        <i class="fas fa-building-columns field-icon"></i>
                        <select name="dept_code" id="dept_code" class="form-input" required>
                            <option value="">-- Choose Department --</option>
                            <?php foreach ($departments as $code => $title): ?>
                                <option value="<?= htmlspecialchars($code) ?>" <?= (isset($_POST['dept_code']) && $_POST['dept_code'] === $code) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($title) ?> (<?= htmlspecialchars($code) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-field">
                        <label class="form-label" for="full_name">
                            Full Name <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <i class="fas fa-user-tie field-icon"></i>
                            <input type="text" name="full_name" id="full_name" class="form-input" placeholder="e.g. Prof. R. K. Patel" value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-field">
                        <label class="form-label" for="designation">
                            Designation / Role
                        </label>
                        <div class="input-group">
                            <i class="fas fa-id-badge field-icon"></i>
                            <input type="text" name="designation" id="designation" class="form-input" placeholder="e.g. HOD / Dept Coordinator" value="<?= htmlspecialchars($_POST['designation'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-field">
                        <label class="form-label" for="email">
                            Official Email <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <i class="fas fa-envelope field-icon"></i>
                            <input type="email" name="email" id="email" class="form-input" placeholder="name@gecmodasa.ac.in" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-field">
                        <label class="form-label" for="username">
                            Desired Username <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <i class="fas fa-at field-icon"></i>
                            <input type="text" name="username" id="username" class="form-input" placeholder="e.g. ce_admin" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                        </div>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-field">
                        <label class="form-label" for="password">
                            Password <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <i class="fas fa-lock field-icon"></i>
                            <input type="password" name="password" id="password" class="form-input" placeholder="Min 6 characters" required>
                        </div>
                    </div>

                    <div class="form-field">
                        <label class="form-label" for="confirm_password">
                            Confirm Password <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <i class="fas fa-shield-halved field-icon"></i>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-input" placeholder="Retype password" required>
                        </div>
                    </div>
                </div>

                <div style="background:#fffbeb; border:1px solid #fde68a; color:#92400e; padding:10px 14px; border-radius:8px; font-size:12px; margin-bottom:18px;">
                    <i class="fas fa-info-circle"></i> <strong>Note:</strong> After registration, your request will be sent to the Super Admin for verification and approval.
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus"></i> Submit Registration Request
                </button>
            </form>
            <?php endif; ?>

            <div class="login-footer">
                <div>
                    Already registered and approved? <a href="login.php">Sign In to Dept Admin</a>
                </div>
                <a href="../index.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to GEC Modasa Website
                </a>
            </div>
        </div>
    </div>

</body>
</html>
