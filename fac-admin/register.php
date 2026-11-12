<?php
/**
 * Faculty Registration Portal - Matches Main Admin Theme
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
$success = '';

$pdo = getDBConnection();

// Available departments list
$departments = [
    'CE' => 'Computer Engineering',
    'IT' => 'Information Technology',
    'CIVIL' => 'Civil Engineering',
    'ME' => 'Mechanical Engineering',
    'EE' => 'Electrical Engineering',
    'EC' => 'Electronics & Communication',
    'AE' => 'Automobile Engineering',
    'AM' => 'Applied Mechanics',
    'SH' => 'Science & Humanities'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dept = trim($_POST['dept_code'] ?? '');
    $faculty_id = (int)($_POST['faculty_id'] ?? 0);
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($dept) || !array_key_exists($dept, $departments)) {
        $error = 'Please select a valid department.';
    } elseif ($faculty_id <= 0) {
        $error = 'Please select your faculty profile from the list.';
    } elseif (empty($username) || strlen($username) < 4) {
        $error = 'Username must be at least 4 characters long.';
    } elseif (!preg_match('/^[a-zA-Z0-9_.-]+$/', $username)) {
        $error = 'Username can only contain alphanumeric characters, dots, underscores or dashes.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match. Please retype.';
    } else {
        if (!$pdo) {
            $error = 'Database connection error. Please try again.';
        } else {
            try {
                // Verify faculty exists, matches dept, and is NOT yet registered
                $checkStmt = $pdo->prepare("SELECT id, name, is_registered FROM faculties WHERE id = ? AND dept_code = ?");
                $checkStmt->execute([$faculty_id, $dept]);
                $faculty = $checkStmt->fetch(PDO::FETCH_ASSOC);

                if (!$faculty) {
                    $error = 'Selected faculty profile does not exist in this department.';
                } elseif (!empty($faculty['is_registered'])) {
                    $error = 'This profile is already registered. Please go to Login or contact the site administrator.';
                } else {
                    // Check if username is already taken by anyone
                    $userCheck = $pdo->prepare("SELECT id FROM faculties WHERE username = ? AND id != ?");
                    $userCheck->execute([$username, $faculty_id]);
                    if ($userCheck->fetch()) {
                        $error = 'This username is already taken. Please choose another username.';
                    } else {
                        // Hash password and update record
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                        $updateStmt = $pdo->prepare("UPDATE faculties SET username = ?, password_hash = ?, is_registered = 1, updated_at = NOW() WHERE id = ?");
                        $updateStmt->execute([$username, $passwordHash, $faculty_id]);

                        // Set session and redirect to dashboard
                        $_SESSION['faculty_user_id'] = $faculty['id'];
                        $_SESSION['faculty_name'] = $faculty['name'];
                        $_SESSION['faculty_dept'] = $dept;
                        setFacultyFlash('success', 'Registration successful! Welcome to your Faculty Profile Dashboard.');

                        header('Location: index.php');
                        exit;
                    }
                }
            } catch (Exception $e) {
                $error = 'Registration failed: ' . $e->getMessage();
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
    <title>Faculty Registration : GEC Modasa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/fac-admin.css">
</head>
<body class="fac-auth-body">

    <div class="login-wrapper wide-form">
        <div class="login-card">
            <div class="login-header">
                <div class="brand-logo-frame">
                    <img src="../logos/logo.png" alt="GEC Modasa">
                </div>
                <h1 class="login-title">Faculty Registration</h1>
                <p class="login-subtitle">Create account to manage your academic profile</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="login-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="register.php" id="registrationForm" autocomplete="off">
                <div class="form-field">
                    <label class="form-label" for="dept_code">
                        1. Select Department <span class="required">*</span>
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

                <div class="form-field">
                    <label class="form-label" for="faculty_id">
                        2. Select Faculty Profile <span class="required">*</span>
                    </label>
                    <div class="input-group">
                        <i class="fas fa-user-tie field-icon"></i>
                        <select name="faculty_id" id="faculty_id" class="form-input" required disabled>
                            <option value="">-- First choose a department above --</option>
                        </select>
                    </div>
                    <small id="fac_loading_text" style="display:none; color: #1e88e5; font-size:12px; margin-top:4px;">
                        <i class="fas fa-spinner fa-spin"></i> Loading faculties for selected department...
                    </small>
                </div>

                <div class="form-field">
                    <label class="form-label" for="username">
                        3. Choose Username <span class="required">*</span>
                    </label>
                    <div class="input-group">
                        <i class="fas fa-at field-icon"></i>
                        <input type="text" name="username" id="username" class="form-input" placeholder="e.g. mb_chavda or chavda_gec" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-field">
                        <label class="form-label" for="password">
                            4. Set Password <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <i class="fas fa-lock field-icon"></i>
                            <input type="password" name="password" id="password" class="form-input" placeholder="Min 6 characters" required>
                        </div>
                    </div>

                    <div class="form-field">
                        <label class="form-label" for="confirm_password">
                            5. Confirm Password <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <i class="fas fa-shield-halved field-icon"></i>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-input" placeholder="Retype password" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus"></i> Complete Registration & Enter
                </button>
            </form>

            <div class="login-footer">
                <div>
                    Already registered? <a href="login.php">Sign In to your account</a>
                </div>
                <a href="../index.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to GEC Modasa Website
                </a>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const deptSelect = document.getElementById('dept_code');
        const facSelect = document.getElementById('faculty_id');
        const loadingText = document.getElementById('fac_loading_text');
        const prevSelectedFacId = "<?= htmlspecialchars($_POST['faculty_id'] ?? '') ?>";

        function loadFaculties(dept, preselectId) {
            if (!dept) {
                facSelect.innerHTML = '<option value="">-- First choose a department above --</option>';
                facSelect.disabled = true;
                return;
            }

            loadingText.style.display = 'block';
            facSelect.disabled = true;
            facSelect.innerHTML = '<option value="">Loading list...</option>';

            fetch('get-unregistered-faculties.php?dept=' + encodeURIComponent(dept))
                .then(res => res.json())
                .then(data => {
                    loadingText.style.display = 'none';
                    if (data.success && data.data && data.data.length > 0) {
                        facSelect.innerHTML = '<option value="">-- Select Your Name --</option>';
                        data.data.forEach(fac => {
                            const opt = document.createElement('option');
                            opt.value = fac.id;
                            opt.textContent = fac.name + (fac.designation ? ' (' + fac.designation + ')' : '');
                            if (preselectId && String(fac.id) === String(preselectId)) {
                                opt.selected = true;
                            }
                            facSelect.appendChild(opt);
                        });
                        facSelect.disabled = false;
                    } else {
                        facSelect.innerHTML = '<option value="">No unregistered profiles found in this department</option>';
                        facSelect.disabled = true;
                    }
                })
                .catch(err => {
                    loadingText.style.display = 'none';
                    facSelect.innerHTML = '<option value="">Error loading list</option>';
                    facSelect.disabled = true;
                });
        }

        deptSelect.addEventListener('change', function() {
            loadFaculties(this.value, null);
        });

        if (deptSelect.value) {
            loadFaculties(deptSelect.value, prevSelectedFacId);
        }
    });
    </script>
</body>
</html>
