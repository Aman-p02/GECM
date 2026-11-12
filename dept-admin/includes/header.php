<?php
/**
 * Department Admin Header & Sidebar Layout - Clean, Authentic Institutional Theme
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../admin/css/admin.css">
    <style>
        .dept-sidebar-header {
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .dept-sidebar-header img {
            width: 38px;
            height: 38px;
            object-fit: contain;
            background: #ffffff;
            border-radius: 8px;
            padding: 4px;
        }
        .dept-sidebar-brand {
            display: flex;
            flex-direction: column;
        }
        .dept-sidebar-brand .brand-title {
            font-size: 15px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.2;
        }
        .dept-sidebar-brand .brand-subtitle {
            font-size: 11px;
            color: var(--admin-sidebar-text);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }
        .dept-admin-profile-strip {
            padding: 14px 20px;
            background: rgba(0, 0, 0, 0.15);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .dept-admin-avatar {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            background: #1e88e5;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            flex-shrink: 0;
        }
        .dept-admin-meta {
            overflow: hidden;
        }
        .dept-admin-meta .name {
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .dept-admin-meta .dept {
            font-size: 11.5px;
            color: var(--admin-sidebar-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .scope-pill {
            background-color: #e3f2fd;
            color: #1565c0;
            font-size: 11.5px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: 1px solid #bbdefb;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        /* Top Navigation Bar inside Department */
        .dept-module-nav {
            background: #ffffff;
            border: 1px solid var(--admin-border-color);
            border-radius: 8px;
            padding: 10px 18px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .dept-module-nav .nav-tabs-list {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        .dept-module-nav .tab-btn {
            padding: 7px 14px;
            font-size: 13px;
            font-weight: 500;
            color: #495057;
            border-radius: 4px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s ease;
        }
        .dept-module-nav .tab-btn:hover {
            background: #f1f5f9;
            color: var(--admin-primary);
        }
        .dept-module-nav .tab-btn.active {
            background: var(--admin-primary);
            color: #ffffff;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar Navigation -->
        <aside class="admin-sidebar">
            <div class="dept-sidebar-header">
                <img src="../logos/logo.png" alt="GEC Modasa">
                <div class="dept-sidebar-brand">
                    <span class="brand-title"><?= htmlspecialchars($deptCode) ?> Department</span>
                    <span class="brand-subtitle">GEC Modasa</span>
                </div>
            </div>

            <!-- Dept Admin Profile Strip -->
            <div class="dept-admin-profile-strip">
                <div class="dept-admin-avatar">
                    <?= htmlspecialchars(substr($deptCode, 0, 2)) ?>
                </div>
                <div class="dept-admin-meta">
                    <div class="name" title="<?= htmlspecialchars($deptAdmin['full_name']) ?>"><?= htmlspecialchars($deptAdmin['full_name']) ?></div>
                    <div class="dept"><?= htmlspecialchars($deptName) ?></div>
                </div>
            </div>

            <!-- Sidebar Menu Links -->
            <ul class="sidebar-menu">
                <li class="menu-category">Department Management</li>
                <li class="menu-item <?= ($activeTab === 'dashboard') ? 'active' : '' ?>">
                    <a href="index.php" class="menu-link">
                        <i class="fas fa-chart-pie" style="font-size: 14px; width: 20px;"></i>
                        <span>Overview</span>
                    </a>
                </li>
                <li class="menu-item <?= ($activeTab === 'faculty') ? 'active' : '' ?>">
                    <a href="faculty.php" class="menu-link">
                        <i class="fas fa-users" style="font-size: 14px; width: 20px;"></i>
                        <span>Faculty Profiles</span>
                    </a>
                </li>
                <li class="menu-item <?= ($activeTab === 'activities') ? 'active' : '' ?>">
                    <a href="activities.php" class="menu-link">
                        <i class="fas fa-calendar-alt" style="font-size: 14px; width: 20px;"></i>
                        <span>Activities & Events</span>
                    </a>
                </li>
                <li class="menu-item <?= ($activeTab === 'publications') ? 'active' : '' ?>">
                    <a href="publications.php" class="menu-link">
                        <i class="fas fa-newspaper" style="font-size: 14px; width: 20px;"></i>
                        <span>Publications</span>
                    </a>
                </li>
                <li class="menu-item <?= ($activeTab === 'board') ? 'active' : '' ?>">
                    <a href="board.php" class="menu-link">
                        <i class="fas fa-user-tie" style="font-size: 14px; width: 20px;"></i>
                        <span>Advisory Board</span>
                    </a>
                </li>
                <li class="menu-item <?= ($activeTab === 'newsletters') ? 'active' : '' ?>">
                    <a href="newsletters.php" class="menu-link">
                        <i class="fas fa-file-pdf" style="font-size: 14px; width: 20px;"></i>
                        <span>Newsletters</span>
                    </a>
                </li>

                <li class="menu-category">Links</li>
                <li class="menu-item">
                    <a href="<?= htmlspecialchars($livePageUrl) ?>" target="_blank" class="menu-link">
                        <i class="fas fa-external-link-alt" style="font-size: 14px; width: 20px;"></i>
                        <span>Live Department Page</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="../index.php" target="_blank" class="menu-link">
                        <i class="fas fa-globe" style="font-size: 14px; width: 20px;"></i>
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
                    <h1 class="page-title"><?= htmlspecialchars($pageHeading ?? 'Department Overview') ?></h1>
                    <span class="scope-pill"><i class="fas fa-shield-alt"></i> <?= htmlspecialchars($deptName) ?></span>
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
