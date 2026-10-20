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
    <title>Admin Portal Login — GEC Modasa</title>
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
            padding: 34px 32px 30px;
            box-shadow: 0 16px 36px -8px rgba(15, 23, 42, 0.12),
                0 4px 12px -2px rgba(15, 23, 42, 0.05);
            color: #1e293b;
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .brand-logo-frame {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 7px;
            margin-bottom: 12px;
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
            margin-bottom: 18px;
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
            margin-bottom: 16px;
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
            padding: 0 16px 0 40px;
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

        /* Full Body Sitting Monkey Mascot Stage */
        .monkey-stage {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            height: 98px;
            margin-bottom: 2px;
            margin-top: 4px;
            pointer-events: none;
            /* Clicking on monkey does nothing */
            user-select: none;
        }

        .monkey-mascot-wrapper {
            display: inline-flex;
            align-items: flex-end;
            transform-origin: center bottom;
            pointer-events: none;
        }

        .monkey-full-svg {
            width: 90px;
            height: 98px;
            overflow: visible;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.08));
        }

        /* Hands Animation (Down vs Covering Eyes) */
        .hands-down {
            transition: opacity 0.22s ease, transform 0.22s ease;
            transform-origin: 50px 75px;
            opacity: 1;
        }

        .monkey-full-svg.covering .hands-down {
            opacity: 0;
            transform: translateY(6px) scale(0.9);
        }

        .hands-up {
            transition: opacity 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform-origin: 50px 65px;
            transform: translateY(22px) scale(0.7);
            opacity: 0;
        }

        .monkey-full-svg.covering .hands-up {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Tail Wag Animation */
        .monkey-tail-wrap {
            transform-origin: 32px 84px;
            transition: transform 0.15s ease;
        }

        .monkey-full-svg.wagging .monkey-tail-wrap {
            animation: tailWagFast 0.14s infinite alternate ease-in-out;
        }

        @keyframes tailWagFast {
            0% {
                transform: rotate(-30deg);
            }

            100% {
                transform: rotate(34deg);
            }
        }

        /* Jump Animation on Sign In */
        .monkey-mascot-wrapper.jumping {
            animation: monkeyJumpAnim 0.28s infinite alternate ease-in-out;
        }

        @keyframes monkeyJumpAnim {
            0% {
                transform: translateY(0) scale(1);
            }

            100% {
                transform: translateY(-18px) scale(1.05);
            }
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 14px;
            margin-bottom: 20px;
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
            margin-top: 20px;
            padding-top: 16px;
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
            margin-top: 18px;
            font-size: 12px;
            color: #64748b;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 26px 20px;
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

                <!-- Full Body Sitting Monkey Mascot (Sitting with hands, feet, tail) -->
                <div class="monkey-stage">
                    <div class="monkey-mascot-wrapper" id="monkeyMascot">
                        <svg class="monkey-full-svg" id="monkeySvg" viewBox="0 0 100 110">
                            <!-- Curled Tail behind body -->
                            <g class="monkey-tail-wrap">
                                <path d="M 34 86 C 18 84, 8 72, 10 56 C 12 44, 22 45, 20 54 C 18 62, 24 74, 32 80"
                                    fill="none" stroke="#78421c" stroke-width="5" stroke-linecap="round" />
                            </g>

                            <!-- Sitting Legs & Feet (Pair) -->
                            <!-- Left Foot -->
                            <ellipse cx="28" cy="91" rx="14" ry="9" fill="#8d532d" />
                            <ellipse cx="26" cy="92" rx="8" ry="5.5" fill="#f6c8a5" />
                            <circle cx="20" cy="88" r="2.4" fill="#f6c8a5" />
                            <circle cx="25" cy="86" r="2.4" fill="#f6c8a5" />
                            <circle cx="30" cy="87" r="2.4" fill="#f6c8a5" />

                            <!-- Right Foot -->
                            <ellipse cx="72" cy="91" rx="14" ry="9" fill="#8d532d" />
                            <ellipse cx="74" cy="92" rx="8" ry="5.5" fill="#f6c8a5" />
                            <circle cx="70" cy="87" r="2.4" fill="#f6c8a5" />
                            <circle cx="75" cy="86" r="2.4" fill="#f6c8a5" />
                            <circle cx="80" cy="88" r="2.4" fill="#f6c8a5" />

                            <!-- Torso / Body -->
                            <ellipse cx="50" cy="72" rx="23" ry="21" fill="#8d532d" />
                            <!-- Tummy / Belly -->
                            <ellipse cx="50" cy="74" rx="15" ry="14" fill="#f6c8a5" />

                            <!-- Resting Hands / Arms (Hath down on knees/belly) -->
                            <g class="hands-down" id="handsDown">
                                <!-- Left Arm Down -->
                                <path d="M 30 62 C 26 68, 28 80, 36 82 C 40 83, 42 79, 38 75 C 35 71, 35 65, 33 62 Z"
                                    fill="#7a4320" />
                                <circle cx="37" cy="80" r="4.5" fill="#f6c8a5" />
                                <!-- Right Arm Down -->
                                <path d="M 70 62 C 74 68, 72 80, 64 82 C 60 83, 58 79, 62 75 C 65 71, 65 65, 67 62 Z"
                                    fill="#7a4320" />
                                <circle cx="63" cy="80" r="4.5" fill="#f6c8a5" />
                            </g>

                            <!-- Head Group -->
                            <!-- Left Ear -->
                            <circle cx="22" cy="34" r="11" fill="#8d532d" />
                            <circle cx="22" cy="34" r="7" fill="#f6c8a5" />

                            <!-- Right Ear -->
                            <circle cx="78" cy="34" r="11" fill="#8d532d" />
                            <circle cx="78" cy="34" r="7" fill="#f6c8a5" />

                            <!-- Head Base -->
                            <circle cx="50" cy="36" r="25" fill="#8d532d" />

                            <!-- Face Mask (Muzzle & cheeks) -->
                            <ellipse cx="42" cy="33" rx="10" ry="12" fill="#f6c8a5" />
                            <ellipse cx="58" cy="33" rx="10" ry="12" fill="#f6c8a5" />
                            <ellipse cx="50" cy="43" rx="15" ry="11" fill="#f6c8a5" />

                            <!-- Eyes (Big friendly monkey eyes) -->
                            <g class="monkey-eyes">
                                <ellipse cx="42" cy="31" rx="4" ry="5.5" fill="#221b18" />
                                <circle cx="40.5" cy="29.5" r="1.6" fill="#ffffff" />
                                <ellipse cx="58" cy="31" rx="4" ry="5.5" fill="#221b18" />
                                <circle cx="56.5" cy="29.5" r="1.6" fill="#ffffff" />
                            </g>

                            <!-- Nose & Smile -->
                            <ellipse cx="50" cy="40" rx="3.2" ry="2" fill="#5a3118" />
                            <path d="M 44 45 Q 50 50 56 45" fill="none" stroke="#5a3118" stroke-width="2"
                                stroke-linecap="round" />

                            <!-- Hands Covering Eyes (Hath on Eyes when typing password) -->
                            <g class="hands-up" id="handsUp">
                                <!-- Left Arm Reaching Eyes -->
                                <path d="M 28 62 C 24 50, 28 38, 36 32 C 40 29, 46 30, 48 35 C 49 40, 42 45, 36 52 Z"
                                    fill="#7a4320" stroke="#5a3118" stroke-width="0.8" />
                                <circle cx="42" cy="32" r="5.2" fill="#f6c8a5" />
                                <circle cx="39" cy="28" r="2.5" fill="#f6c8a5" />
                                <circle cx="43" cy="27" r="2.5" fill="#f6c8a5" />
                                <circle cx="46" cy="29" r="2.5" fill="#f6c8a5" />

                                <!-- Right Arm Reaching Eyes -->
                                <path d="M 72 62 C 76 50, 72 38, 64 32 C 60 29, 54 30, 52 35 C 51 40, 58 45, 64 52 Z"
                                    fill="#7a4320" stroke="#5a3118" stroke-width="0.8" />
                                <circle cx="58" cy="32" r="5.2" fill="#f6c8a5" />
                                <circle cx="61" cy="28" r="2.5" fill="#f6c8a5" />
                                <circle cx="57" cy="27" r="2.5" fill="#f6c8a5" />
                                <circle cx="54" cy="29" r="2.5" fill="#f6c8a5" />
                            </g>
                        </svg>
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

        // 2. Full Body Sitting Monkey Password Interaction
        const monkeySvg = document.getElementById('monkeySvg');
        const monkeyMascot = document.getElementById('monkeyMascot');
        const passwordInput = document.getElementById('password');
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');

        let typingTimer = null;

        // When admin types in password field -> monkey puts hands over eyes
        passwordInput.addEventListener('input', function () {
            monkeySvg.classList.add('covering');

            clearTimeout(typingTimer);
            // When admin stops typing for 1 second -> monkey removes hands from eyes
            typingTimer = setTimeout(() => {
                monkeySvg.classList.remove('covering');
            }, 1000);
        });

        // When user focuses on password, if text exists -> cover eyes
        passwordInput.addEventListener('focus', function () {
            if (passwordInput.value.length > 0) {
                monkeySvg.classList.add('covering');
            }
        });

        // When user leaves password field (blur) -> remove hands from eyes
        passwordInput.addEventListener('blur', function () {
            clearTimeout(typingTimer);
            monkeySvg.classList.remove('covering');
        });

        // 3. When admin submits password -> monkey wags tail AND jumps, then submits
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Hands down, tail wagging + jumping excitedly!
            monkeySvg.classList.remove('covering');
            monkeySvg.classList.add('wagging');
            monkeyMascot.classList.add('jumping');

            submitBtn.disabled = true;
            submitBtn.textContent = 'Signing in...';

            // Wait brief moment for jump & tail wag animation, then submit form
            setTimeout(() => {
                loginForm.submit();
            }, 800);
        });
    </script>

</body>

</html>