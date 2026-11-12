<?php
/**
 * Department Admin Header & Sidebar Layout - Exactly matching Main Admin Structure
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
    <title><?= htmlspecialchars($pageTitle ?? 'Dept Admin') ?> - GEC Modasa</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../admin/css/admin.css">
    <style>
        /* Exact text left alignment without icons in sidebar */
        .admin-sidebar .menu-link {
            justify-content: flex-start !important;
            text-align: left;
            padding: 10px 18px;
        }
        .admin-sidebar .menu-link span {
            display: block;
            width: 100%;
            text-align: left;
        }
        /* Clean minimal stat cards with no colored icon squares */
        .clean-stat-card {
            background-color: var(--admin-card-bg);
            border: 1px solid var(--admin-border-color);
            border-radius: 8px;
            padding: 22px 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .clean-stat-card .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #1a263d;
            line-height: 1.1;
        }
        .clean-stat-card .stat-label {
            font-size: 13.5px;
            font-weight: 500;
            color: var(--admin-text-muted);
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar Navigation matching Main Admin -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <a href="index.php" class="sidebar-brand">
                    <?= htmlspecialchars($deptCode) ?> Admin
                </a>
            </div>

            <!-- Sidebar Menu Links strictly left-aligned, no icons -->
            <ul class="sidebar-menu">
                <li class="menu-category">Department Management</li>
                <li class="menu-item <?= ($activeTab === 'dashboard') ? 'active' : '' ?>">
                    <a href="index.php" class="menu-link">
                        <span>Overview</span>
                    </a>
                </li>
                <li class="menu-item <?= ($activeTab === 'faculty') ? 'active' : '' ?>">
                    <a href="faculty.php" class="menu-link">
                        <span>Faculty Profiles</span>
                    </a>
                </li>
                <li class="menu-item <?= ($activeTab === 'activities') ? 'active' : '' ?>">
                    <a href="activities.php" class="menu-link">
                        <span>Activities & Events</span>
                    </a>
                </li>
                <li class="menu-item <?= ($activeTab === 'publications') ? 'active' : '' ?>">
                    <a href="publications.php" class="menu-link">
                        <span>Publications</span>
                    </a>
                </li>
                <li class="menu-item <?= ($activeTab === 'board') ? 'active' : '' ?>">
                    <a href="board.php" class="menu-link">
                        <span>Advisory Board</span>
                    </a>
                </li>
                <li class="menu-item <?= ($activeTab === 'newsletters') ? 'active' : '' ?>">
                    <a href="newsletters.php" class="menu-link">
                        <span>Newsletters</span>
                    </a>
                </li>

                <li class="menu-category">External Links</li>
                <li class="menu-item">
                    <a href="<?= htmlspecialchars($livePageUrl) ?>" target="_blank" class="menu-link">
                        <span>Live Department Page</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../index.php" target="_blank" class="menu-link">
                        <span>College Website</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content Area -->
        <div class="admin-main">
            <!-- Header matching Main Admin -->
            <header class="admin-topbar">
                <div class="topbar-left">
                    <h1 class="page-title"><?= htmlspecialchars($pageHeading ?? 'Dashboard Overview') ?></h1>
                </div>

                <div class="topbar-right">
                    <div class="topbar-user">
                        Hi, <?= htmlspecialchars($deptAdmin['full_name']) ?>
                    </div>
                    <a href="logout.php" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </header>

            <main class="admin-content" style="padding: 24px 28px;">
                <?php if (!empty($flash)): ?>
                    <div class="admin-alert admin-alert-<?= htmlspecialchars($flash['type'] === 'danger' ? 'danger' : 'success') ?>">
                        <span><?= htmlspecialchars($flash['message']) ?></span>
                        <button class="admin-alert-close" onclick="this.parentElement.remove();">&times;</button>
                    </div>
                <?php endif; ?>
