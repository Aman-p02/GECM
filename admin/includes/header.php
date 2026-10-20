<?php
/**
 * GEC MODASA — ADMIN PANEL HEADER
 */
require_once __DIR__ . '/auth.php';
checkAdminAuth();

$admin = getLoggedInAdmin();
$current_page = $current_page ?? 'dashboard';
$page_title = $page_title ?? 'Dashboard Overview';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> — GEC Admin</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Admin CSS -->
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a href="dashboard.php" class="sidebar-brand">
                GEC Admin
            </a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-category">Main Navigation</li>
            <li class="menu-item <?= ($current_page === 'dashboard') ? 'active' : '' ?>">
                <a href="dashboard.php" class="menu-link">
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="menu-category">Content Management</li>
            <li class="menu-item <?= ($current_page === 'hero') ? 'active' : '' ?>">
                <a href="hero.php" class="menu-link">
                    <span>Hero Slides</span>
                </a>
            </li>
            <li class="menu-item <?= ($current_page === 'notices') ? 'active' : '' ?>">
                <a href="notices.php" class="menu-link">
                    <span>Notice Board</span>
                </a>
            </li>
            <li class="menu-item <?= ($current_page === 'ticker') ? 'active' : '' ?>">
                <a href="ticker.php" class="menu-link">
                    <span>News Ticker</span>
                </a>
            </li>
            <li class="menu-item <?= ($current_page === 'events') ? 'active' : '' ?>">
                <a href="events.php" class="menu-link">
                    <span>Recent Events</span>
                </a>
            </li>
            <li class="menu-item <?= ($current_page === 'shots') ? 'active' : '' ?>">
                <a href="shots.php" class="menu-link">
                    <span>Latest Shots</span>
                </a>
            </li>
            <li class="menu-item <?= ($current_page === 'departments') ? 'active' : '' ?>">
                <a href="departments.php" class="menu-link">
                    <span>Departments</span>
                </a>
            </li>
            <li class="menu-item <?= ($current_page === 'alumni') ? 'active' : '' ?>">
                <a href="alumni.php" class="menu-link">
                    <span>Manage Alumni</span>
                </a>
            </li>

            <li class="menu-category">System & Settings</li>
            <li class="menu-item <?= ($current_page === 'settings') ? 'active' : '' ?>">
                <a href="settings.php" class="menu-link">
                    <span>Site Settings</span>
                </a>
            </li>
            <li class="menu-item <?= ($current_page === 'admins') ? 'active' : '' ?>">
                <a href="admins.php" class="menu-link">
                    <span>Admin Users</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="../index.php" target="_blank" class="menu-link">
                    <span>View Website</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Wrapper -->
    <div class="admin-main">
        <!-- Top Bar matching reference screenshot -->
        <header class="admin-topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="Toggle Navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title"><?= htmlspecialchars($page_title) ?></h1>
            </div>

            <div class="topbar-right">
                <div class="topbar-bell" title="Notifications">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="topbar-user">
                    Hi, <?= htmlspecialchars($admin['username']) ?>
                </div>
                <span class="badge-role">Admin - GECM</span>
                <a href="logout.php" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="admin-content">
            <?php renderFlashMessage(); ?>
