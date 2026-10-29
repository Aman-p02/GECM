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
    <!-- Google Fonts (Inter & Poppins) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <!-- ================================================================
         HEADER — Two-tier institutional navigation
         Row 1: Branding (logo + name + affiliations)
         Row 2: Horizontal navigation bar
         ================================================================ -->
    <header class="site-header" role="banner">

        <!-- ── Row 1 : Branding ────────────────────────────────────── -->
        <div class="hdr-brand">
            <div class="hdr-brand-inner">

                <!-- Left: Logo + College Name -->
                <a href="<?= $root_path ?>" class="hdr-identity" aria-label="GEC Modasa – Home">
                    <img src="<?= $root_path ?>logos/logo.png"
                         alt="GEC Modasa Logo"
                         class="hdr-logo"
                         width="64" height="64">
                    <div class="hdr-nameblock">
                        <span class="hdr-college-name">Government Engineering College, Modasa</span>
                        <span class="hdr-college-sub">Modasa, Gujarat</span>
                    </div>
                </a>

                <!-- Right: Affiliation banner + mobile hamburger -->
                <div class="hdr-right">
                    <img src="<?= $root_path ?>logos/affiliated.png"
                         alt="Affiliated to GTU | Approved by AICTE | Administered by GOG"
                         class="hdr-affil desktop-only">
                    <button class="hdr-hamburger"
                            id="hamburgerBtn"
                            aria-label="Open navigation menu"
                            aria-expanded="false"
                            aria-controls="mainNavLinks">
                        <span class="hbr"></span>
                        <span class="hbr"></span>
                        <span class="hbr"></span>
                    </button>
                </div>

            </div>
        </div><!-- /hdr-brand -->

        <!-- ── Row 2 : Navigation ──────────────────────────────────── -->
        <nav class="hdr-nav" id="mainNavbar" aria-label="Primary navigation">
            <div class="hdr-nav-inner">
                <ul class="hdr-nav-list" id="mainNavLinks">

                    <!-- Home (icon only on desktop) -->
                    <li class="hdr-nav-home">
                        <a href="<?= $root_path ?>"
                           class="hdr-nav-link hdr-home-icon <?php echo ($active_page === 'home') ? 'is-active' : ''; ?>"
                           aria-label="Home" title="Home">
                            <i class="fas fa-home" aria-hidden="true"></i>
                            <span class="hdr-home-label">Home</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo ($active_page === 'home') ? '#about' : $root_path . '#about'; ?>"
                           class="hdr-nav-link <?php echo ($active_page === 'about') ? 'is-active' : ''; ?>">
                            About
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo ($active_page === 'home') ? '#about' : $root_path . '#about'; ?>"
                           class="hdr-nav-link <?php echo ($active_page === 'administration') ? 'is-active' : ''; ?>">
                            Administration
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo ($active_page === 'home') ? '#departments' : $root_path . '#departments'; ?>"
                           class="hdr-nav-link <?php echo ($active_page === 'academic') ? 'is-active' : ''; ?>">
                            Academic
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo ($active_page === 'home') ? '#departments' : $root_path . '#departments'; ?>"
                           class="hdr-nav-link <?php echo ($active_page === 'departments') ? 'is-active' : ''; ?>">
                            Departments
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo ($active_page === 'home') ? '#events' : $root_path . '#events'; ?>"
                           class="hdr-nav-link <?php echo ($active_page === 'activities') ? 'is-active' : ''; ?>">
                            Activities
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo ($active_page === 'home') ? '#events' : $root_path . '#events'; ?>"
                           class="hdr-nav-link <?php echo ($active_page === 'student-corner') ? 'is-active' : ''; ?>">
                            Student Corner
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo ($active_page === 'home') ? '#alumni' : $root_path . '#alumni'; ?>"
                           class="hdr-nav-link <?php echo ($active_page === 'placement') ? 'is-active' : ''; ?>">
                            Placement
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo ($active_page === 'home') ? '#contact' : $root_path . '#contact'; ?>"
                           class="hdr-nav-link <?php echo ($active_page === 'contact') ? 'is-active' : ''; ?>">
                            Contact Us
                        </a>
                    </li>

                </ul>
            </div>
        </nav><!-- /hdr-nav -->

    </header><!-- /site-header -->
