<?php
/**
 * Common Header & Sidebar for Faculty Dashboard
 */
require_once __DIR__ . '/auth.php';
checkFacultyAuth();

$faculty = getLoggedInFaculty();
if (!$faculty) {
    header('Location: logout.php');
    exit;
}

$activeTab = $activeTab ?? 'profile';
$flash = getFacultyFlash();

$photoPath = !empty($faculty['photo_url']) ? '../' . ltrim($faculty['photo_url'], '/') : '../assets/images/default-avatar.png';
if (!file_exists(__DIR__ . '/../../' . ltrim($faculty['photo_url'] ?? '', '/')) || empty($faculty['photo_url'])) {
    $photoPath = '../assets/images/faculty/default.jpg';
}

$deptLabels = [
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
$deptName = $deptLabels[$faculty['dept_code']] ?? $faculty['dept_code'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Faculty Portal') ?> : GEC Modasa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/fac-admin.css">
</head>
<body>
    <div class="dashboard-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="sidebar" id="facultySidebar">
            <div class="sidebar-header">
                <img src="../assets/images/logo.png" alt="GEC Modasa">
                <div class="title-group">
                    <h2>GEC Modasa</h2>
                    <span>Faculty Portal</span>
                </div>
            </div>

            <!-- Faculty Info Badge -->
            <div class="faculty-badge-card">
                <img src="<?= htmlspecialchars($photoPath) ?>" alt="Avatar" class="avatar" onerror="this.src='../assets/images/faculty/default.jpg'">
                <div class="info">
                    <h4 title="<?= htmlspecialchars($faculty['name']) ?>"><?= htmlspecialchars($faculty['name']) ?></h4>
                    <p><?= htmlspecialchars($deptName) ?></p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="sidebar-nav">
                <div class="nav-category">Main Profile</div>
                <a href="index.php" class="nav-link <?= ($activeTab === 'profile') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fa-solid fa-user-gear"></i></span>
                    <span>General Information</span>
                </a>
                <a href="qualifications.php" class="nav-link <?= ($activeTab === 'qualifications') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fa-solid fa-graduation-cap"></i></span>
                    <span>Qualifications</span>
                </a>

                <div class="nav-category">Academic Portfolio</div>
                <a href="portfolio.php?type=publications" class="nav-link <?= ($activeTab === 'publications') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fa-solid fa-newspaper"></i></span>
                    <span>Publications</span>
                </a>
                <a href="portfolio.php?type=books" class="nav-link <?= ($activeTab === 'books') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fa-solid fa-book"></i></span>
                    <span>Books & Chapters</span>
                </a>
                <a href="portfolio.php?type=editorial" class="nav-link <?= ($activeTab === 'editorial') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fa-solid fa-feather-pointed"></i></span>
                    <span>Editorial Board</span>
                </a>
                <a href="portfolio.php?type=training" class="nav-link <?= ($activeTab === 'training') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fa-solid fa-chalkboard-user"></i></span>
                    <span>Training Programs</span>
                </a>
                <a href="portfolio.php?type=expert_talks" class="nav-link <?= ($activeTab === 'expert_talks') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fa-solid fa-microphone-lines"></i></span>
                    <span>Expert Talks</span>
                </a>
                <a href="portfolio.php?type=workshops" class="nav-link <?= ($activeTab === 'workshops') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fa-solid fa-people-group"></i></span>
                    <span>Workshops Organized</span>
                </a>
                <a href="portfolio.php?type=activities" class="nav-link <?= ($activeTab === 'activities') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fa-solid fa-trophy"></i></span>
                    <span>Department Activities</span>
                </a>
                <a href="portfolio.php?type=experience" class="nav-link <?= ($activeTab === 'experience') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fa-solid fa-briefcase"></i></span>
                    <span>Past Experience</span>
                </a>
                <a href="portfolio.php?type=extra" class="nav-link <?= ($activeTab === 'extra') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fa-solid fa-star"></i></span>
                    <span>Extra Curricular</span>
                </a>

                <div class="nav-category">Account</div>
                <a href="change-password.php" class="nav-link <?= ($activeTab === 'password') ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="fa-solid fa-key"></i></span>
                    <span>Change Password</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="logout.php" class="btn btn-outline btn-block btn-sm">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
                </a>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="main-content">
            <!-- Topbar -->
            <header class="topbar">
                <div class="page-title">
                    <h1><?= htmlspecialchars($pageHeading ?? 'Faculty Profile Dashboard') ?></h1>
                </div>
                <div class="actions">
                    <a href="../departments/faculty-profile.php?id=<?= (int)$faculty['id'] ?>" target="_blank" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> View Live Public Profile
                    </a>
                    <a href="logout.php" class="btn btn-outline btn-sm" title="Log out">
                        <i class="fa-solid fa-power-off"></i>
                    </a>
                </div>
            </header>

            <!-- Container for Content -->
            <div class="content-container">
                <?php if (!empty($flash)): ?>
                    <div class="alert alert-<?= htmlspecialchars($flash['type']) ?>">
                        <i class="fa-solid fa-circle-check"></i>
                        <span><?= htmlspecialchars($flash['message']) ?></span>
                    </div>
                <?php endif; ?>

