<?php
/**
 * Department Admin Header & Sidebar Layout
 */
require_once __DIR__ . '/auth.php';
checkDeptAdminAuth();

$deptAdmin = getLoggedInDeptAdmin();
if (!$deptAdmin) {
    header('Location: logout.php');
    exit;
}

$deptCode = $deptAdmin['dept_code'];
$deptLabels = [
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
$deptName = $deptLabels[$deptCode] ?? $deptCode;

$deptFolderMap = [
    'CE'    => 'computer',
    'IT'    => 'information-technology',
    'ME'    => 'mechanical',
    'CIVIL' => 'civil',
    'AE'    => 'automobile',
    'AM'    => 'applied-mechanics',
];
$liveDeptFolder = $deptFolderMap[$deptCode] ?? 'computer';
$livePageUrl = "../departments/{$liveDeptFolder}/index.php";

$activeTab = $activeTab ?? 'dashboard';
$flash = getDeptFlash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Dept Admin') ?> : <?= htmlspecialchars($deptCode) ?> - GEC Modasa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../fac-admin/css/fac-admin.css">
    <style>
        .dept-scope-badge {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .stat-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        .stat-info h3 {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.1;
        }
        .stat-info p {
            font-size: 12.5px;
            color: #64748b;
            margin-top: 2px;
        }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../logos/logo.png" alt="GEC Modasa">
                <div class="title-group">
                    <h2><?= htmlspecialchars($deptCode) ?> Dept Admin</h2>
                    <span>GEC Modasa</span>
                </div>
            </div>

            <!-- Dept Admin Badge -->
            <div class="faculty-badge-card">
                <div style="width:44px; height:44px; border-radius:50%; background:#1e88e5; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:16px;">
                    <?= htmlspecialchars(substr($deptCode, 0, 2)) ?>
                </div>
                <div class="info">
                    <h4 title="<?= htmlspecialchars($deptAdmin['full_name']) ?>"><?= htmlspecialchars($deptAdmin['full_name']) ?></h4>
                    <p><?= htmlspecialchars($deptName) ?></p>
                </div>
            </div>

            <!-- Navigation Links strictly for their Department -->
            <nav class="sidebar-nav">
                <div class="nav-category">Department Management</div>
                <a href="index.php" class="nav-link <?= ($activeTab === 'dashboard') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fas fa-gauge-high"></i></span>
                    <span>Overview</span>
                </a>
                <a href="faculty.php" class="nav-link <?= ($activeTab === 'faculty') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fas fa-users-line"></i></span>
                    <span>Faculty Profiles</span>
                </a>
                <a href="activities.php" class="nav-link <?= ($activeTab === 'activities') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fas fa-calendar-days"></i></span>
                    <span>Activities & Events</span>
                </a>
                <a href="publications.php" class="nav-link <?= ($activeTab === 'publications') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fas fa-newspaper"></i></span>
                    <span>Dept Publications</span>
                </a>
                <a href="board.php" class="nav-link <?= ($activeTab === 'board') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fas fa-user-group"></i></span>
                    <span>Advisory Board</span>
                </a>
                <a href="newsletters.php" class="nav-link <?= ($activeTab === 'newsletters') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fas fa-file-lines"></i></span>
                    <span>Newsletters</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="logout.php" class="btn btn-outline btn-block btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Sign Out
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header class="topbar">
                <div class="page-title" style="display:flex; align-items:center; gap:12px;">
                    <h1><?= htmlspecialchars($pageHeading ?? 'Department Admin Portal') ?></h1>
                    <span class="dept-scope-badge"><i class="fas fa-lock"></i> <?= htmlspecialchars($deptName) ?></span>
                </div>
                <div class="actions">
                    <a href="<?= htmlspecialchars($livePageUrl) ?>" target="_blank" class="btn btn-primary btn-sm">
                        <i class="fas fa-external-link-alt"></i> Live Department Page
                    </a>
                    <a href="logout.php" class="btn btn-outline btn-sm" title="Log Out">
                        <i class="fas fa-power-off"></i>
                    </a>
                </div>
            </header>

            <div class="content-container">
                <?php if (!empty($flash)): ?>
                    <div class="alert alert-<?= htmlspecialchars($flash['type']) ?>">
                        <i class="fas fa-circle-check"></i>
                        <span><?= htmlspecialchars($flash['message']) ?></span>
                    </div>
                <?php endif; ?>
