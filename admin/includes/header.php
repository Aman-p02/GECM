<?php
/**
 * GEC MODASA - ADMIN PANEL HEADER
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
    <title><?= htmlspecialchars($page_title) ?> - GEC Admin</title>
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
                    GECM Admin
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
                
                <?php 
                $aboutPageItems = ['principal-message', 'idp', 'e-newsletters', 'brochure', 'mandatory-disclosure', 'rankings', 'mou', 'approvals'];
                $isAboutActive = in_array($current_page, $aboutPageItems);

                $administrationPageItems = ['principal-profile', 'council-of-heads', 'account-section', 'hostel-mess', 'administration-committees'];
                $isAdministrationActive = in_array($current_page, $administrationPageItems);

                $mainPageItems = ['hero', 'notices', 'ticker', 'events', 'shots', 'departments', 'alumni', 'faculty-activities'];
                $isMainPageActive = in_array($current_page, $mainPageItems);

                $deptPageItems = ['dept-faculty', 'dept-activities', 'dept-publications', 'dept-board', 'dept-newsletters'];
                $isDeptActive = in_array($current_page, $deptPageItems);
                $activeDeptCode = $_GET['dept'] ?? ($dept_code ?? 'CE');
                ?>
                <!-- About Accordion Dropdown -->
                <li class="menu-item menu-item-has-submenu <?= $isAboutActive ? 'active open' : '' ?>">
                    <a href="javascript:void(0);" class="menu-link submenu-toggle" id="aboutMenuToggle">
                        <span>About</span>
                        <i class="fas fa-chevron-down submenu-arrow"></i>
                    </a>
                    <ul class="submenu-list">
                        <li class="submenu-item <?= ($current_page === 'principal-message') ? 'active' : '' ?>">
                            <a href="principal-message.php" class="submenu-link">
                                <span>Principal's Message</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'idp') ? 'active' : '' ?>">
                            <a href="idp.php" class="submenu-link">
                                <span>IDP</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'e-newsletters') ? 'active' : '' ?>">
                            <a href="e-newsletters.php" class="submenu-link">
                                <span>E-Newsletters</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'brochure') ? 'active' : '' ?>">
                            <a href="brochure.php" class="submenu-link">
                                <span>Information Brochure</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'mandatory-disclosure') ? 'active' : '' ?>">
                            <a href="mandatory-disclosure.php" class="submenu-link">
                                <span>Mandatory Disclosure</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'rankings') ? 'active' : '' ?>">
                            <a href="rankings.php" class="submenu-link">
                                <span>Rankings</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'mou') ? 'active' : '' ?>">
                            <a href="mou.php" class="submenu-link">
                                <span>MoU</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'approvals') ? 'active' : '' ?>">
                            <a href="approvals.php" class="submenu-link">
                                <span>AICTE &amp; GTU Approvals</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Administration Accordion Dropdown -->
                <li class="menu-item menu-item-has-submenu <?= $isAdministrationActive ? 'active open' : '' ?>">
                    <a href="javascript:void(0);" class="menu-link submenu-toggle" id="administrationMenuToggle">
                        <span>Administration</span>
                        <i class="fas fa-chevron-down submenu-arrow"></i>
                    </a>
                    <ul class="submenu-list">
                        <li class="submenu-item <?= ($current_page === 'principal-profile') ? 'active' : '' ?>">
                            <a href="principal-profile.php" class="submenu-link">
                                <span>Principal</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'council-of-heads') ? 'active' : '' ?>">
                            <a href="council-of-heads.php" class="submenu-link">
                                <span>Council of Heads</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'account-section') ? 'active' : '' ?>">
                            <a href="account-section.php" class="submenu-link">
                                <span>Account Section</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'hostel-mess') ? 'active' : '' ?>">
                            <a href="hostel-mess.php" class="submenu-link">
                                <span>Hostel &amp; Mess</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'administration-committees') ? 'active' : '' ?>">
                            <a href="administration-committees.php" class="submenu-link">
                                <span>Committees</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Main Page Accordion Dropdown -->
                <li class="menu-item menu-item-has-submenu <?= $isMainPageActive ? 'active open' : '' ?>">
                    <a href="javascript:void(0);" class="menu-link submenu-toggle" id="mainPageMenuToggle">
                        <span>Main Page</span>
                        <i class="fas fa-chevron-down submenu-arrow"></i>
                    </a>
                    <ul class="submenu-list">
                        <li class="submenu-item <?= ($current_page === 'hero') ? 'active' : '' ?>">
                            <a href="hero.php" class="submenu-link">
                                <span>Hero Slides</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'notices') ? 'active' : '' ?>">
                            <a href="notices.php" class="submenu-link">
                                <span>Notice Board</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'ticker') ? 'active' : '' ?>">
                            <a href="ticker.php" class="submenu-link">
                                <span>News Ticker</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'events') ? 'active' : '' ?>">
                            <a href="events.php" class="submenu-link">
                                <span>Recent Events</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'shots') ? 'active' : '' ?>">
                            <a href="shots.php" class="submenu-link">
                                <span>Latest Shots</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'departments') ? 'active' : '' ?>">
                            <a href="departments.php" class="submenu-link">
                                <span>Departments</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'alumni') ? 'active' : '' ?>">
                            <a href="alumni.php" class="submenu-link">
                                <span>Manage Alumni</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($current_page === 'faculty-activities') ? 'active' : '' ?>">
                            <a href="faculty-activities.php" class="submenu-link">
                                <span>Faculty Activities</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Departments Accordion Dropdown -->
                <li class="menu-item menu-item-has-submenu <?= $isDeptActive ? 'active open' : '' ?>">
                    <a href="javascript:void(0);" class="menu-link submenu-toggle" id="departmentsMenuToggle">
                        <span>Departments</span>
                        <i class="fas fa-chevron-down submenu-arrow"></i>
                    </a>
                    <ul class="submenu-list">
                        <li class="submenu-item <?= ($isDeptActive && $activeDeptCode === 'CE') ? 'active' : '' ?>">
                            <a href="dept-faculty.php?dept=CE" class="submenu-link">
                                <span>Computer Engineering</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($isDeptActive && $activeDeptCode === 'IT') ? 'active' : '' ?>">
                            <a href="dept-faculty.php?dept=IT" class="submenu-link">
                                <span>Information Technology</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($isDeptActive && $activeDeptCode === 'ME') ? 'active' : '' ?>">
                            <a href="dept-faculty.php?dept=ME" class="submenu-link">
                                <span>Mechanical Engineering</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($isDeptActive && $activeDeptCode === 'CIVIL') ? 'active' : '' ?>">
                            <a href="dept-faculty.php?dept=CIVIL" class="submenu-link">
                                <span>Civil Engineering</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($isDeptActive && $activeDeptCode === 'EE') ? 'active' : '' ?>">
                            <a href="dept-faculty.php?dept=EE" class="submenu-link">
                                <span>Electrical Engineering</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($isDeptActive && $activeDeptCode === 'EC') ? 'active' : '' ?>">
                            <a href="dept-faculty.php?dept=EC" class="submenu-link">
                                <span>Electronics &amp; Comm.</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($isDeptActive && $activeDeptCode === 'AE') ? 'active' : '' ?>">
                            <a href="dept-faculty.php?dept=AE" class="submenu-link">
                                <span>Automobile Engineering</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($isDeptActive && $activeDeptCode === 'AM') ? 'active' : '' ?>">
                            <a href="dept-faculty.php?dept=AM" class="submenu-link">
                                <span>Applied Mechanics</span>
                            </a>
                        </li>
                        <li class="submenu-item <?= ($isDeptActive && $activeDeptCode === 'SH') ? 'active' : '' ?>">
                            <a href="dept-faculty.php?dept=SH" class="submenu-link">
                                <span>Science &amp; Humanities</span>
                            </a>
                        </li>
                    </ul>
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
<?php
// Check for pending dept admin registration requests
$pendingDeptCount = 0;
$headerPdo = getDBConnection();
if ($headerPdo) {
    try {
        $pendingDeptCount = (int)$headerPdo->query("SELECT COUNT(*) FROM dept_admins WHERE status = 'pending'")->fetchColumn();
    } catch (Exception $e) {}
}
?>
                <li class="menu-item <?= ($current_page === 'dept-approvals') ? 'active' : '' ?>">
                    <a href="dept-approvals.php" class="menu-link" style="display:flex; justify-content:space-between; align-items:center;">
                        <span>Dept Admin Requests</span>
                        <?php if ($pendingDeptCount > 0): ?>
                            <span style="background:#ef4444; color:#fff; font-size:11px; font-weight:700; padding:2px 7px; border-radius:10px;"><?= $pendingDeptCount ?></span>
                        <?php endif; ?>
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
                    <a href="dept-approvals.php" class="topbar-bell" title="<?= ($pendingDeptCount > 0) ? $pendingDeptCount . ' Pending Dept Admin Requests' : 'Notifications' ?>" style="text-decoration:none; position:relative; display:inline-flex; align-items:center; justify-content:center;">
                        <i class="fas fa-bell"></i>
                        <?php if ($pendingDeptCount > 0): ?>
                            <span style="position:absolute; top:-4px; right:-4px; background:#ef4444; color:#fff; font-size:10px; font-weight:700; width:17px; height:17px; border-radius:50%; display:flex; align-items:center; justify-content:center; border:2px solid #fff;">
                                <?= $pendingDeptCount ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <div class="topbar-user">
                        Hi, <?= htmlspecialchars($admin['username']) ?>
                    </div>

                    <a href="logout.php" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="admin-content">
                <?php
                renderFlashMessage();
                if (getDBConnection() === null):
                    ?>
                    <div
                        style="background: #fee2e2; border: 1px solid #f87171; color: #991b1b; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 20px;"></i>
                        <div>
                            <div style="font-size: 15px;">Database Connection Offline</div>
                            <div style="font-size: 13px; font-weight: 400; color: #7f1d1d; margin-top: 2px;">
                                MySQL service is not running or unreachable. Please open <strong>XAMPP Control
                                    Panel</strong> and click <strong>Start</strong> next to MySQL.
                            </div>
                        </div>
                    </div>
                <?php endif; ?>