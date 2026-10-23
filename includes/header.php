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
    <!-- Global CSS -->
    <link rel="stylesheet" href="css/global.css?v=<?= file_exists(__DIR__ . '/../css/global.css') ? filemtime(__DIR__ . '/../css/global.css') : time() ?>">
<?php if (isset($extra_css)): ?>
    <?php if (is_array($extra_css)): ?>
        <?php foreach ($extra_css as $css_file): ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($css_file); ?>?v=<?= file_exists(__DIR__ . '/../' . $css_file) ? filemtime(__DIR__ . '/../' . $css_file) : time() ?>">
        <?php endforeach; ?>
    <?php else: ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($extra_css); ?>?v=<?= file_exists(__DIR__ . '/../' . $extra_css) ? filemtime(__DIR__ . '/../' . $extra_css) : time() ?>">
    <?php endif; ?>
<?php endif; ?>
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
                <a href="./" style="display: flex; align-items: center; gap: 15px; text-decoration: none; color: inherit;">
                    <img src="logos/logoGrey.png" alt="GEC Modasa Logo" class="logo">
                    <div class="college-name">
                        <h1>Government Engineering College, Modasa</h1>
                        <p>Modasa, Gujarat</p>
                    </div>
                </a>
                <img src="logos/affiliated.png" alt="Affiliated to GTU" class="affiliated-logo desktop-only">
            </div>
            <nav class="navbar">
                <ul class="nav-links">
                    <li><a href="./" class="<?php echo ($active_page === 'home') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="<?php echo ($active_page === 'home') ? '#about' : './#about'; ?>" class="<?php echo ($active_page === 'about') ? 'active' : ''; ?>">About</a></li>
                    <li><a href="<?php echo ($active_page === 'home') ? '#departments' : './#departments'; ?>" class="<?php echo ($active_page === 'departments') ? 'active' : ''; ?>">Departments</a></li>
                    <li><a href="<?php echo ($active_page === 'home') ? '#events' : './#events'; ?>" class="<?php echo ($active_page === 'events') ? 'active' : ''; ?>">Events</a></li>
                    <li><a href="<?php echo ($active_page === 'home') ? '#alumni' : './#alumni'; ?>" class="<?php echo ($active_page === 'alumni') ? 'active' : ''; ?>">Alumni</a></li>
                    <li><a href="<?php echo ($active_page === 'home') ? '#contact' : './#contact'; ?>" class="<?php echo ($active_page === 'contact') ? 'active' : ''; ?>">Contact</a></li>
                </ul>
                <div class="hamburger">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </nav>
        </div>
    </header>
