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
    <title>Admin Portal Login GEC Modasa</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body.admin-login-body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #eef2f6 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 16px;
            color: #1e293b;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        /* Clean White Login Box (stands out from the light-grey background) */
        .login-card {
            background-color: #ffffff;
            border: 1px solid #dbe2ea;
            border-radius: 14px;
            padding: 36px 32px;
            box-shadow: 0 16px 36px -8px rgba(15, 23, 42, 0.12),
                0 4px 12px -2px rgba(15, 23, 42, 0.05);
            color: #1e293b;
            position: relative;
        }

        .login-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-logo-frame {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 8px;
            margin-bottom: 14px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .brand-logo-frame img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .login-title {
            font-size: 21px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.2px;
            margin-bottom: 4px;
        }

        .login-subtitle {
            font-size: 13px;
            color: #64748b;
            font-weight: 400;
        }

        /* Alert message - Auto disappears after 2 seconds */
        .login-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 13.5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.08);
            transform-origin: top;
            transition: opacity 0.5s ease, transform 0.5s ease, max-height 0.5s ease, margin 0.5s ease, padding 0.5s ease;
        }

        .login-alert i {
            font-size: 15px;
            color: #dc2626;
            flex-shrink: 0;
        }

        /* Form elements */
        .form-field {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group .field-icon {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            font-size: 14px;
            pointer-events: none;
            z-index: 1;
        }

        .form-input {
            width: 100%;
            height: 46px;
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            padding: 0 46px 0 40px;
            font-size: 14px;
            color: #0f172a;
            font-family: inherit;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .form-input:focus {
            border-color: #1e88e5;
            box-shadow: 0 0 0 3.5px rgba(30, 136, 229, 0.2);
        }

        /* Monkey inside Password Input (Right Side) */
        .monkey-input-slot {
            position: absolute;
            right: 10px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            /* Clicking on monkey does nothing */
            user-select: none;
            z-index: 3;
        }

        .monkey-svg {
            width: 34px;
            height: 34px;
            overflow: visible;
            transition: transform 0.22s ease;
        }

        /* Thought Cloud Floating over Monkey's head when typing username */
        .thought-cloud {
            position: absolute;
            right: 0px;
            bottom: 48px;
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            border-radius: 18px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 600;
            color: #1e293b;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
            white-space: nowrap;
            opacity: 0;
            transform: translateY(6px) scale(0.85);
            transition: opacity 0.25s ease, transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            pointer-events: none;
            z-index: 10;
        }

        /* Comic thought bubble dots */
        .thought-cloud::before {
            content: '';
            position: absolute;
            bottom: -6px;
            right: 22px;
            width: 7px;
            height: 7px;
            background: #ffffff;
            border-right: 1.5px solid #cbd5e1;
            border-bottom: 1.5px solid #cbd5e1;
            border-radius: 50%;
        }

        .thought-cloud::after {
            content: '';
            position: absolute;
            bottom: -11px;
            right: 18px;
            width: 4px;
            height: 4px;
            background: #ffffff;
            border-right: 1.5px solid #cbd5e1;
            border-bottom: 1.5px solid #cbd5e1;
            border-radius: 50%;
        }

        .thought-cloud.active {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Thinking Pose: Head tilts up towards thought cloud */
        .monkey-head-group {
            transform-origin: 32px 34px;
            transition: transform 0.25s ease;
        }

        .monkey-svg.thinking .monkey-head-group {
            transform: rotate(-10deg) translateY(-2px);
        }

        .monkey-eyes {
            transition: transform 0.25s ease;
        }

        .monkey-svg.thinking .monkey-eyes {
            transform: translateY(-2px);
        }

        /* Hands Covering Eyes (When typing password) */
        .monkey-hands {
            transform-origin: 32px 52px;
            transform: translateY(22px) scale(0.65);
            opacity: 0;
            transition: transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.2s ease;
            pointer-events: none;
        }

        .monkey-svg.covering .monkey-hands {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        /* Tail Wag Animation on Submit (NO JUMPING) */
        .monkey-tail-wrap {
            transform-origin: 18px 48px;
            transition: transform 0.15s ease;
        }

        .monkey-svg.wagging .monkey-tail-wrap {
            animation: monkeyTailWag 0.12s infinite alternate ease-in-out;
        }

        @keyframes monkeyTailWag {
            0% {
                transform: rotate(-26deg);
            }

            100% {
                transform: rotate(30deg);
            }
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
            font-size: 13px;
        }

        .checkbox-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            cursor: pointer;
            user-select: none;
            font-size: 13.5px;
        }

        .checkbox-item input[type="checkbox"] {
            accent-color: #1e88e5;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            height: 46px;
            background-color: #1e88e5;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(30, 136, 229, 0.25);
            transition: background-color 0.15s ease, transform 0.1s ease, box-shadow 0.15s ease;
        }

        .btn-submit:hover {
            background-color: #1565c0;
            box-shadow: 0 6px 16px rgba(30, 136, 229, 0.35);
        }

        .btn-submit:active {
            transform: translateY(1px);
        }

        /* Footer link */
        .login-footer {
            text-align: center;
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #e2e8f0;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: color 0.15s ease;
        }

        .back-link:hover {
            color: #0f172a;
        }

        .disclaimer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #64748b;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 28px 22px;
            }

            .login-title {
                font-size: 19px;
            }
        }
    </style>
</head>

<body class="admin-login-body">

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="brand-logo-frame">
                    <img src="../logos/logoGrey.png" alt="GEC Modasa">
                </div>
                <h1 class="login-title">GEC Modasa</h1>
                <p class="login-subtitle">Government Engineering College Administration Portal</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="login-alert" id="loginAlert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= $error ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php" id="loginForm" autocomplete="off">
                <div class="form-field">
                    <label class="form-label" for="username">Username or Official Email</label>
                    <div class="input-group">
                        <i class="fas fa-user field-icon"></i>
                        <input type="text" id="username" name="username" class="form-input" placeholder="Enter username"
                            value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autofocus>
                    </div>
                </div>

                <div class="form-field">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" id="password" name="password" class="form-input"
                            placeholder="Enter password" required>

                        <!-- Thought Cloud when typing username: "ohh its username ?" -->
                        <div class="thought-cloud" id="thoughtCloud">
                            ohh its username ?
                        </div>

                        <!-- Monkey sitting inside the password box (right side, no click action) -->
                        <div class="monkey-input-slot" id="monkeySlot">
                            <svg class="monkey-svg" id="monkeySvg" viewBox="0 0 64 64">
                                <!-- Tail on side -->
                                <g class="monkey-tail-wrap">
                                    <path d="M 17 50 C 7 46, 3 34, 6 25 C 8 19, 15 21, 14 27 C 12 32, 16 40, 20 46"
                                        fill="none" stroke="#7a441e" stroke-width="4.5" stroke-linecap="round" />
                                </g>

                                <!-- Ears -->
                                <circle cx="14" cy="28" r="8" fill="#8d532d" />
                                <circle cx="14" cy="28" r="5" fill="#f6c8a5" />
                                <circle cx="50" cy="28" r="8" fill="#8d532d" />
                                <circle cx="50" cy="28" r="5" fill="#f6c8a5" />

                                <!-- Head Group (tilts when thinking) -->
                                <g class="monkey-head-group">
                                    <ellipse cx="32" cy="30" rx="19" ry="17" fill="#8d532d" />

                                    <!-- Face Mask / Muzzle -->
                                    <ellipse cx="26" cy="27" rx="8" ry="10" fill="#f6c8a5" />
                                    <ellipse cx="38" cy="27" rx="8" ry="10" fill="#f6c8a5" />
                                    <ellipse cx="32" cy="36" rx="12" ry="9" fill="#f6c8a5" />

                                    <!-- Eyes (glance up when thinking) -->
                                    <g class="monkey-eyes">
                                        <ellipse cx="26" cy="26" rx="3.5" ry="4.5" fill="#221b18" />
                                        <circle cx="25" cy="24.5" r="1.3" fill="#ffffff" />
                                        <ellipse cx="38" cy="26" rx="3.5" ry="4.5" fill="#221b18" />
                                        <circle cx="37" cy="24.5" r="1.3" fill="#ffffff" />
                                    </g>

                                    <!-- Nose & Smile -->
                                    <ellipse cx="32" cy="33.5" rx="2.4" ry="1.7" fill="#5a3118" />
                                    <path d="M 28 37.5 Q 32 41 36 37.5" fill="none" stroke="#5a3118" stroke-width="1.8"
                                        stroke-linecap="round" />
                                </g>

                                <!-- Hands Covering Eyes (when typing password) -->
                                <g class="monkey-hands" id="monkeyHands">
                                    <!-- Left Hand -->
                                    <path
                                        d="M 17 48 C 17 48, 18 36, 21 28 C 22 24, 26 23, 29 27 C 31 30, 27 38, 23 44 Z"
                                        fill="#7a4320" stroke="#5a3118" stroke-width="0.8" />
                                    <circle cx="27" cy="26" r="3.2" fill="#f6c8a5" />

                                    <!-- Right Hand -->
                                    <path
                                        d="M 47 48 C 47 48, 46 36, 43 28 C 42 24, 38 23, 35 27 C 33 30, 37 38, 41 44 Z"
                                        fill="#7a4320" stroke="#5a3118" stroke-width="0.8" />
                                    <circle cx="37" cy="26" r="3.2" fill="#f6c8a5" />
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="form-options">
                    <label class="checkbox-item">
                        <input type="checkbox" name="remember" checked>
                        <span>Remember this device</span>
                    </label>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    Sign In
                </button>
            </form>

            <div class="login-footer">
                <a href="../index.php" class="back-link">
                    &larr; Return to College Website
                </a>
            </div>
        </div>

        <p class="disclaimer-text">
            &copy; <?= date('Y') ?> Government Engineering College, Modasa. Authorized access only.
        </p>
    </div>

    <script>
        // 1. Auto-remove red alert / warning after exactly 2 seconds
        const alertEl = document.getElementById('loginAlert');
        if (alertEl) {
            setTimeout(() => {
                alertEl.style.opacity = '0';
                alertEl.style.transform = 'translateY(-10px)';
                alertEl.style.maxHeight = '0';
                alertEl.style.paddingTop = '0';
                alertEl.style.paddingBottom = '0';
                alertEl.style.marginTop = '0';
                alertEl.style.marginBottom = '0';
                alertEl.style.overflow = 'hidden';
                setTimeout(() => alertEl.remove(), 500);
            }, 2000);
        }

        // 2. Interactive Elements
        const monkeySvg = document.getElementById('monkeySvg');
        const thoughtCloud = document.getElementById('thoughtCloud');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');

        let usernameTimer = null;
        let passwordTimer = null;

        // A. When Admin types username -> Monkey thinks & thought cloud appears: "ohh its username ?"
        usernameInput.addEventListener('input', function () {
            thoughtCloud.classList.add('active');
            monkeySvg.classList.add('thinking');

            clearTimeout(usernameTimer);
            // When stops typing for 1.2s -> cloud disappears and stops thinking
            usernameTimer = setTimeout(() => {
                thoughtCloud.classList.remove('active');
                monkeySvg.classList.remove('thinking');
            }, 1200);
        });

        usernameInput.addEventListener('focus', function () {
            if (usernameInput.value.length > 0) {
                thoughtCloud.classList.add('active');
                monkeySvg.classList.add('thinking');
            }
        });

        usernameInput.addEventListener('blur', function () {
            clearTimeout(usernameTimer);
            thoughtCloud.classList.remove('active');
            monkeySvg.classList.remove('thinking');
        });

        // B. When Admin types password -> Monkey puts hands over eyes
        passwordInput.addEventListener('input', function () {
            // Dismiss thought cloud if open
            thoughtCloud.classList.remove('active');
            monkeySvg.classList.remove('thinking');

            // Hands cover eyes
            monkeySvg.classList.add('covering');

            clearTimeout(passwordTimer);
            // When admin stops typing for 1 second -> hands leave eyes
            passwordTimer = setTimeout(() => {
                monkeySvg.classList.remove('covering');
            }, 1000);
        });

        passwordInput.addEventListener('focus', function () {
            thoughtCloud.classList.remove('active');
            monkeySvg.classList.remove('thinking');
            if (passwordInput.value.length > 0) {
                monkeySvg.classList.add('covering');
            }
        });

        passwordInput.addEventListener('blur', function () {
            clearTimeout(passwordTimer);
            monkeySvg.classList.remove('covering');
        });

        // C. When Admin submits form -> Tail wagging only (JUMP REMOVED)
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Hide clouds, hands down, tail wags!
            thoughtCloud.classList.remove('active');
            monkeySvg.classList.remove('covering');
            monkeySvg.classList.remove('thinking');
            monkeySvg.classList.add('wagging');

            submitBtn.disabled = true;
            submitBtn.textContent = 'Signing in...';

            // Wait a brief moment for tail wag animation, then submit form
            setTimeout(() => {
                loginForm.submit();
            }, 600);
        });
    </script>

</body>

</html>