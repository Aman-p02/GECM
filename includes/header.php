<?php
// Asset root path
if (!isset($root_path)) {
    $root_path = '';
}
// Page title
if (!isset($page_title)) {
    $page_title = "Government Engineering College, Modasa";
}
// Active navigation page
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
    <!-- Stylesheets -->
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
    <!-- Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <!-- Header -->
    <header class="site-header" role="banner">
        <!-- Institutional Branding -->
        <div class="hdr-brand">
            <div class="hdr-brand-inner">

                <!-- Logo & Title -->
                <a href="<?= $root_path ?>" class="hdr-identity" aria-label="GEC Modasa Home">
                    <img src="<?= $root_path ?>logos/logo.png"
                         alt="GEC Modasa Logo"
                         class="hdr-logo"
                         width="64" height="64">
                    <div class="hdr-nameblock">
                        <span class="hdr-college-name">Government Engineering College, Modasa</span>
                        <span class="hdr-college-sub">Modasa, Gujarat</span>
                    </div>
                </a>

                <!-- Affiliation & Toggle -->
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
        </div>
    </header>

    <!-- Navigation Bar -->
    <nav class="hdr-nav" id="mainNavbar" aria-label="Primary navigation">
        <div class="hdr-nav-inner">
            <ul class="hdr-nav-list" id="mainNavLinks">

                <!-- Navigation Links -->
                <li class="hdr-nav-item">
                    <a href="<?= $root_path ?>" class="hdr-nav-link">
                        Home
                    </a>
                </li>

                <!-- About Dropdown -->
                <li class="hdr-nav-item has-dropdown">
                    <a href="<?php echo ($active_page === 'home') ? '#about' : $root_path . '#about'; ?>"
                       class="hdr-nav-link">
                        About <i class="fas fa-chevron-down hdr-arrow"></i>
                    </a>
                    <div class="hdr-dropdown">
                        <div class="hdr-dd-heading">THE INSTITUTE</div>
                        <ul class="hdr-dd-list">
                            <li><a href="<?php echo ($active_page === 'home') ? '#about' : $root_path . '#about'; ?>" class="hdr-dd-link">Overview</a></li>
                            <li><a href="<?php echo ($active_page === 'home') ? '#about' : $root_path . '#about'; ?>" class="hdr-dd-link">Vision &amp; Mission</a></li>
                            <li><a href="#" class="hdr-dd-link">Principal's Message</a></li>
                            <li><a href="#" class="hdr-dd-link">IDP</a></li>
                            <li><a href="<?php echo ($active_page === 'home') ? '#facilities' : $root_path . '#facilities'; ?>" class="hdr-dd-link">Facilities</a></li>
                            <li><a href="#" class="hdr-dd-link">E-Newsletter</a></li>
                            <li><a href="#" class="hdr-dd-link">Information Brochure</a></li>
                            <li><a href="#" class="hdr-dd-link">Mandatory Disclosure</a></li>
                            <li><a href="#" class="hdr-dd-link">Rankings</a></li>
                            <li><a href="#" class="hdr-dd-link">MoU</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Administration Dropdown -->
                <li class="hdr-nav-item has-dropdown">
                    <a href="<?php echo ($active_page === 'home') ? '#about' : $root_path . '#about'; ?>"
                       class="hdr-nav-link">
                        Administration <i class="fas fa-chevron-down hdr-arrow"></i>
                    </a>
                    <div class="hdr-dropdown">
                        <ul class="hdr-dd-list">
                            <li><a href="#" class="hdr-dd-link">Principal</a></li>
                            <li><a href="#" class="hdr-dd-link">Council of Heads</a></li>
                            <li><a href="#" class="hdr-dd-link">Account Section</a></li>
                            <li><a href="#" class="hdr-dd-link">Hostel &amp; Mess</a></li>
                            <li><a href="#" class="hdr-dd-link">Committees</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Academic Dropdown -->
                <li class="hdr-nav-item has-dropdown">
                    <a href="<?php echo ($active_page === 'home') ? '#departments' : $root_path . '#departments'; ?>"
                       class="hdr-nav-link">
                        Academic <i class="fas fa-chevron-down hdr-arrow"></i>
                    </a>
                    <div class="hdr-dropdown">
                        <ul class="hdr-dd-list">
                            <li><a href="#" class="hdr-dd-link">Courses</a></li>
                            <li><a href="#" class="hdr-dd-link">Admission</a></li>
                            <li><a href="#" class="hdr-dd-link">Academic Calendar</a></li>
                            <li><a href="#" class="hdr-dd-link">Syllabus</a></li>
                            <li><a href="#" class="hdr-dd-link">Central Library</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Departments Dropdown -->
                <li class="hdr-nav-item has-dropdown">
                    <a href="<?php echo ($active_page === 'home') ? '#departments' : $root_path . '#departments'; ?>"
                       class="hdr-nav-link">
                        Departments <i class="fas fa-chevron-down hdr-arrow"></i>
                    </a>
                    <div class="hdr-dropdown">
                        <ul class="hdr-dd-list">
                            <li><a href="#" class="hdr-dd-link">Applied Mechanics</a></li>
                            <li><a href="#" class="hdr-dd-link">Automobile Engineering</a></li>
                            <li><a href="#" class="hdr-dd-link">Civil Engineering</a></li>
                            <li><a href="<?= $root_path ?>departments/computer/" class="hdr-dd-link">Computer Engineering</a></li>
                            <li><a href="#" class="hdr-dd-link">Electrical Engineering</a></li>
                            <li><a href="#" class="hdr-dd-link">Electronics &amp; Communication</a></li>
                            <li><a href="<?= $root_path ?>departments/information-technology/" class="hdr-dd-link">Information Technology</a></li>
                            <li><a href="<?= $root_path ?>departments/mechanical/" class="hdr-dd-link">Mechanical Engineering</a></li>
                            <li><a href="#" class="hdr-dd-link">Science &amp; Humanities</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Activities Dropdown (Categorized) -->
                <li class="hdr-nav-item has-dropdown">
                    <a href="<?php echo ($active_page === 'home') ? '#events' : $root_path . '#events'; ?>"
                       class="hdr-nav-link">
                        Activities <i class="fas fa-chevron-down hdr-arrow"></i>
                    </a>
                    <div class="hdr-dropdown hdr-dropdown-mega">
                        <div class="hdr-mega-grid">
                            <div class="hdr-mega-col">
                                <div class="hdr-dd-heading">CAMPUS ACTIVITIES</div>
                                <ul class="hdr-dd-list">
                                    <li><a href="#" class="hdr-dd-link">College Activities</a></li>
                                    <li><a href="#" class="hdr-dd-link">Departmental Activities</a></li>
                                    <li><a href="#" class="hdr-dd-link">Faculty Activities</a></li>
                                </ul>
                            </div>
                            <div class="hdr-mega-col">
                                <div class="hdr-dd-heading">CELLS &amp; INITIATIVES</div>
                                <ul class="hdr-dd-list">
                                    <li><a href="#" class="hdr-dd-link">SSIP &amp; DIC</a></li>
                                    <li><a href="#" class="hdr-dd-link">RUSA</a></li>
                                    <li><a href="#" class="hdr-dd-link">Gymkhana</a></li>
                                    <li><a href="#" class="hdr-dd-link">Finishing School</a></li>
                                    <li><a href="#" class="hdr-dd-link">WDC &amp; UBA</a></li>
                                    <li><a href="#" class="hdr-dd-link">Anchor Nodal</a></li>
                                </ul>
                            </div>
                            <div class="hdr-mega-col">
                                <div class="hdr-dd-heading">ACHIEVEMENTS &amp; CLUBS</div>
                                <ul class="hdr-dd-list">
                                    <li><a href="#" class="hdr-dd-link">Student Achievements</a></li>
                                    <li><a href="#" class="hdr-dd-link">Faculty Achievements</a></li>
                                    <li><a href="#" class="hdr-dd-link">Institute Achievements</a></li>
                                    <li><a href="#" class="hdr-dd-link">Patents</a></li>
                                    <li><a href="#" class="hdr-dd-link">Technopreneur Club</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- Student Corner Dropdown -->
                <li class="hdr-nav-item has-dropdown">
                    <a href="<?php echo ($active_page === 'home') ? '#events' : $root_path . '#events'; ?>"
                       class="hdr-nav-link">
                        Student Corner <i class="fas fa-chevron-down hdr-arrow"></i>
                    </a>
                    <div class="hdr-dropdown">
                        <ul class="hdr-dd-list">
                            <li><a href="#" class="hdr-dd-link">Student Section</a></li>
                            <li><a href="#" class="hdr-dd-link">General Rules &amp; Regulations</a></li>
                            <li><a href="#" class="hdr-dd-link">Student Chapters &amp; Clubs</a></li>
                            <li><a href="#" class="hdr-dd-link">Enrollment Details</a></li>
                            <li><a href="#" class="hdr-dd-link">Scholarships</a></li>
                            <li><a href="#" class="hdr-dd-link">Grade History Card</a></li>
                            <li><a href="#" class="hdr-dd-link">Online Fees Payment</a></li>
                            <li><a href="#" class="hdr-dd-link">Education Verification</a></li>
                            <li><a href="#" class="hdr-dd-link">Grievance Portal</a></li>
                        </ul>
                    </div>
                </li>

                <li class="hdr-nav-item">
                    <a href="<?php echo ($active_page === 'home') ? '#alumni' : $root_path . '#alumni'; ?>"
                       class="hdr-nav-link">
                        Placement
                    </a>
                </li>

                <li class="hdr-nav-item">
                    <a href="<?php echo ($active_page === 'home') ? '#contact' : $root_path . '#contact'; ?>"
                       class="hdr-nav-link">
                        Contact Us
                    </a>
                </li>

            </ul>
        </div>
    </nav>
