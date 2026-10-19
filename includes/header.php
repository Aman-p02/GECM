<?php
// Default page title if not set by including page
if (!isset($page_title)) {
    $page_title = "Government Engineering College, Modasa";
}
// Default active page indicator
if (!isset($active_page)) {
    $active_page = "home";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <!-- CSS -->
    <link rel="stylesheet" href="style.css?v=6">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <!-- Header / Navbar -->
    <header class="header">
        <div class="nav-container">
            <div class="logo-container">
                <a href="index.php" style="display: flex; align-items: center; gap: 15px; text-decoration: none; color: inherit;">
                    <img src="logoGrey.png" alt="GEC Modasa Logo" class="logo">
                    <div class="college-name">
                        <h1>Government Engineering College, Modasa</h1>
                        <p>Modasa, Gujarat</p>
                    </div>
                </a>
                <img src="affiliated.png" alt="Affiliated to GTU" class="affiliated-logo desktop-only">
            </div>
            <nav class="navbar">
                <ul class="nav-links">
                    <li><a href="index.php" class="<?php echo ($active_page === 'home') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="index.php#about" class="<?php echo ($active_page === 'about') ? 'active' : ''; ?>">About</a></li>
                    <li><a href="index.php#departments" class="<?php echo ($active_page === 'departments') ? 'active' : ''; ?>">Departments</a></li>
                    <li><a href="index.php#events" class="<?php echo ($active_page === 'events') ? 'active' : ''; ?>">Events</a></li>
                    <li><a href="index.php#alumni" class="<?php echo ($active_page === 'alumni') ? 'active' : ''; ?>">Alumni</a></li>
                    <li><a href="#contact" class="<?php echo ($active_page === 'contact') ? 'active' : ''; ?>">Contact</a></li>
                </ul>
                <div class="hamburger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </nav>
        </div>
    </header>
