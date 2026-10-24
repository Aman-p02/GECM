<?php
// Default root path for relative asset links ('' for root, '../' for subdirectories)
if (!isset($root_path)) {
    $root_path = '';
}
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
    <link rel="stylesheet" href="<?= $root_path ?>css/global.css?v=<?= file_exists(__DIR__ . '/../css/global.css') ? filemtime(__DIR__ . '/../css/global.css') : time() ?>">
<?php if (isset($extra_css)): ?>
    <?php if (is_array($extra_css)): ?>
        <?php foreach ($extra_css as $css_file): ?>
    <link rel="stylesheet" href="<?= $root_path . htmlspecialchars($css_file); ?>?v=<?= file_exists(__DIR__ . '/../' . $css_file) ? filemtime(__DIR__ . '/../' . $css_file) : time() ?>">
        <?php endforeach; ?>
    <?php else: ?>
    <link rel="stylesheet" href="<?= $root_path . htmlspecialchars($extra_css); ?>?v=<?= file_exists(__DIR__ . '/../' . $extra_css) ? filemtime(__DIR__ . '/../' . $extra_css) : time() ?>">
    <?php endif; ?>
<?php endif; ?>
    <!-- Google Fonts (Inter & Outfit) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <!-- Header / Navbar -->
    <header class="header">
        <!-- Institutional Identity Row -->
        <div class="header-top-brand">
            <div class="brand-container">
                <a href="<?= $root_path ?>" class="brand-identity-link">
                    <img src="<?= $root_path ?>logos/logo.png" alt="GEC Modasa Logo" class="logo">
                    <div class="college-name">
                        <span class="college-meta">Government of Gujarat</span>
                        <h1>Government Engineering College, Modasa</h1>
                        <p>Affiliated to Gujarat Technological University (GTU) &bull; Approved by AICTE, New Delhi</p>
                    </div>
                </a>
                <div class="brand-badges desktop-only">
                    <img src="<?= $root_path ?>logos/affiliated.png" alt="Affiliated to GTU" class="affiliated-logo">
                </div>
            </div>
        </div>

        <!-- Refined Navy Navigation Bar -->
        <nav class="nav-bar-navy" aria-label="Main Navigation">
            <div class="nav-container">
                <ul class="nav-links">
                    <li><a href="<?= $root_path ?>" class="<?php echo ($active_page === 'home') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="<?php echo ($active_page === 'home') ? '#about' : $root_path . '#about'; ?>" class="<?php echo ($active_page === 'about') ? 'active' : ''; ?>">About</a></li>
                    <li><a href="<?php echo ($active_page === 'home') ? '#departments' : $root_path . '#departments'; ?>" class="<?php echo ($active_page === 'departments') ? 'active' : ''; ?>">Departments</a></li>
                    <li><a href="<?php echo ($active_page === 'home') ? '#events' : $root_path . '#events'; ?>" class="<?php echo ($active_page === 'events') ? 'active' : ''; ?>">Events &amp; Notices</a></li>
                    <li><a href="<?php echo ($active_page === 'home') ? '#alumni' : $root_path . '#alumni'; ?>" class="<?php echo ($active_page === 'alumni') ? 'active' : ''; ?>">Alumni</a></li>
                    <li><a href="<?php echo ($active_page === 'home') ? '#contact' : $root_path . '#contact'; ?>" class="<?php echo ($active_page === 'contact') ? 'active' : ''; ?>">Contact</a></li>
                </ul>
                <button type="button" class="hamburger" aria-label="Toggle Navigation">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>
            </div>
        </nav>
    </header>
