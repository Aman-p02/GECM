<?php
/**
 * Faculty Registration Portal
 */
session_start();
require_once __DIR__ . '/../../includes/db.php';
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
        $error = 'Username must be at least 4 characters long and contain only letters, numbers, or underscores.';
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
                    $error = 'This profile is already registered. Please go to Login or contact the site administrator if you forgot credentials.';
                } else {
                    // Check if username is already taken by anyone
                    $userCheck = $pdo->prepare("SELECT id FROM faculties WHERE username = ? AND id != ?");
                    $userCheck->execute([$username, $faculty_id]);
                    if ($userCheck->fetch()) {
                        $error = 'This username is already taken. Please choose another username.';
                    } else {
                        // All good: Hash password and update record
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
    <title>Faculty Portal Registration : GEC Modasa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/fac-admin.css">
</head>
<body class="auth-wrapper">

    <div class="auth-card">
        <div class="auth-header">
            <img src="../assets/images/logo.png" alt="GEC Modasa Logo">
            <h1>Faculty Self-Service Portal</h1>
            <p>Register your faculty account to manage your profile</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <span><?= htmlspecialchars($success) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php" id="registrationForm">
            <div class="form-group">
                <label class="form-label" for="dept_code">
                    1. Select Your Department <span class="required">*</span>
                </label>
                <select name="dept_code" id="dept_code" class="form-control" required>
                    <option value="">-- Choose Department --</option>
                    <?php foreach ($departments as $code => $title): ?>
                        <option value="<?= htmlspecialchars($code) ?>" <?= (isset($_POST['dept_code']) && $_POST['dept_code'] === $code) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($title) ?> (<?= htmlspecialchars($code) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="faculty_id">
                    2. Select Your Name (Faculty Profile) <span class="required">*</span>
                </label>
                <select name="faculty_id" id="faculty_id" class="form-control" required disabled>
                    <option value="">-- First choose a department above --</option>
                </select>
                <small id="fac_loading_text" style="display:none; color: var(--accent-orange); font-size:12px; margin-top:4px;">
                    <i class="fa-solid fa-spinner fa-spin"></i> Loading faculties for department...
                </small>
            </div>

            <div class="form-group">
                <label class="form-label" for="username">
                    3. Choose a Username <span class="required">*</span>
                </label>
                <input type="text" name="username" id="username" class="form-control" placeholder="e.g. mb_chavda or chavda_gec" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autocomplete="off">
            </div>

            <div class="form-group">
                <label class="form-label" for="password">
                    4. Set Password <span class="required">*</span>
                </label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Minimum 6 characters" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="confirm_password">
                    5. Confirm Password <span class="required">*</span>
                </label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Retype password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block" style="margin-top: 24px;">
                <i class="fa-solid fa-user-plus"></i> Complete Registration & Log In
            </button>
        </form>

        <div class="auth-footer">
            Already registered? <a href="login.php">Click here to Login</a>
            <div style="margin-top: 10px;">
                <a href="../index.php" style="color: var(--text-muted); font-weight: normal; font-size: 12px;">
                    <i class="fa-solid fa-arrow-left"></i> Back to GEC Modasa Website
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

        // Trigger on load if dept is preselected (e.g. after POST validation error)
        if (deptSelect.value) {
            loadFaculties(deptSelect.value, prevSelectedFacId);
        }
    });
    </script>
</body>
</html>
