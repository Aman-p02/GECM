<?php
// Asset root path
if (!isset($root_path)) {
    $root_path = '';
}
// Page title
if (!isset($page_title)) {
    $page_title = "Government Engineering College, Modasa (GECM)";
}
// Page Meta Description (Default fallback for SEO)
if (!isset($page_description)) {
    $page_description = "Government Engineering College, Modasa (GEC Modasa) is a premier engineering institution in Gujarat affiliated with GTU, offering degree programs in CE, IT, ME, Civil, Automobile and Applied Mechanics.";
}
// Page Meta Keywords
if (!isset($page_keywords)) {
    $page_keywords = "GEC Modasa, Government Engineering College Modasa, GECM, GTU Engineering College, Engineering Admissions Gujarat, Computer Engineering Modasa, IT Engineering Modasa";
}
// Canonical URL
$canonical_url = $canonical_url ?? ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . ($_SERVER['HTTP_HOST'] ?? 'gecmodasa.ac.in') . ($_SERVER['REQUEST_URI'] ?? ''));
// Active navigation page
if (!isset($active_page)) {
    $active_page = "home";
}
?>
<!DOCTYPE html>
<html lang="en" prefix="og: https://ogp.me/ns#">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Primary Meta Tags -->
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page_keywords); ?>">
    <meta name="author" content="Government Engineering College, Modasa">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical_url); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta property="og:image" content="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'gecmodasa.ac.in') . '/' . ltrim($root_path, '/') ?>images/logo/gec-logo.png">
    <meta property="og:site_name" content="Government Engineering College, Modasa">
    <meta property="og:locale" content="en_IN">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?php echo htmlspecialchars($canonical_url); ?>">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="twitter:image" content="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'gecmodasa.ac.in') . '/' . ltrim($root_path, '/') ?>images/logo/gec-logo.png">

    <!-- JSON-LD Structured Data: CollegeOrUniversity -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "CollegeOrUniversity",
      "name": "Government Engineering College, Modasa",
      "alternateName": ["GEC Modasa", "GECM"],
      "url": "https://gecmodasa.ac.in",
      "logo": "https://gecmodasa.ac.in/images/logo/gec-logo.png",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Shamlaji Road",
        "addressLocality": "Modasa",
        "addressRegion": "Gujarat",
        "postalCode": "383315",
        "addressCountry": "IN"
      },
      "sameAs": [
        "https://www.facebook.com/GECModasaOfficial",
        "https://www.linkedin.com/school/gecmodasa/"
      ]
    }
    </script>
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
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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
                <a href="<?= $root_path ?>index.php" class="hdr-identity" aria-label="GEC Modasa Home">
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
                    <a href="<?= $root_path ?>index.php" class="hdr-nav-link <?= ($active_page === 'home') ? 'active' : '' ?>">
                        Home
                    </a>
                </li>

                <!-- About Dropdown -->
                <li class="hdr-nav-item has-dropdown">
                    <a href="<?= $root_path ?>overview.php"
                       class="hdr-nav-link <?= in_array($active_page, ['about', 'overview', 'vision-mission', 'principal-message']) ? 'active is-active' : '' ?>">
                        About <i class="fas fa-chevron-down hdr-arrow"></i>
                    </a>
                    <div class="hdr-dropdown">
                        <div class="hdr-dd-heading">THE INSTITUTE</div>
                        <ul class="hdr-dd-list">
                            <li><a href="<?= $root_path ?>overview.php" class="hdr-dd-link <?= ($active_page === 'overview') ? 'is-active active' : '' ?>">Overview</a></li>
                            <li><a href="<?= $root_path ?>vision-mission.php" class="hdr-dd-link <?= ($active_page === 'vision-mission') ? 'is-active active' : '' ?>">Vision &amp; Mission</a></li>
                            <li><a href="<?= $root_path ?>principal-message.php" class="hdr-dd-link <?= ($active_page === 'principal-message') ? 'is-active active' : '' ?>">Principal's Message</a></li>
                            <li><a href="#" class="hdr-dd-link">IDP</a></li>
                            <li><a href="<?= $root_path ?>overview.php#facilities" class="hdr-dd-link">Facilities</a></li>
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
                    <a href="javascript:void(0);" class="hdr-nav-link">
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
                    <a href="javascript:void(0);" class="hdr-nav-link <?= in_array($active_page, ['academics', 'courses', 'admission']) ? 'active is-active' : '' ?>">
                        Academic <i class="fas fa-chevron-down hdr-arrow"></i>
                    </a>
                    <div class="hdr-dropdown">
                        <ul class="hdr-dd-list">
                            <li><a href="<?= $root_path ?>courses.php" class="hdr-dd-link <?= ($active_page === 'courses' || $active_page === 'academics') ? 'is-active active' : '' ?>">Courses</a></li>
                            <li><a href="<?= $root_path ?>admission.php" class="hdr-dd-link <?= ($active_page === 'admission') ? 'is-active active' : '' ?>">Admission</a></li>
                            <li><a href="#" class="hdr-dd-link">Academic Calendar</a></li>
                            <li><a href="https://syllabus.gtu.ac.in/" target="_blank" rel="noopener noreferrer" class="hdr-dd-link">Syllabus</a></li>
                            <li><a href="#" class="hdr-dd-link">Central Library</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Departments Dropdown -->
                <li class="hdr-nav-item has-dropdown">
                    <a href="<?php echo ($active_page === 'home') ? '#departments' : $root_path . 'index.php#departments'; ?>"
                       class="hdr-nav-link <?= (isset($deptCode) || in_array($active_page, ['departments', 'department'])) ? 'active is-active' : '' ?>">
                        Departments <i class="fas fa-chevron-down hdr-arrow"></i>
                    </a>
                    <div class="hdr-dropdown">
                        <ul class="hdr-dd-list">
                            <li><a href="<?= $root_path ?>departments/applied-mechanics/" class="hdr-dd-link">Applied Mechanics</a></li>
                            <li><a href="<?= $root_path ?>departments/automobile/" class="hdr-dd-link">Automobile Engineering</a></li>
                            <li><a href="<?= $root_path ?>departments/civil/" class="hdr-dd-link">Civil Engineering</a></li>
                            <li><a href="<?= $root_path ?>departments/computer/" class="hdr-dd-link">Computer Engineering</a></li>
                            <li><a href="<?= $root_path ?>departments/electrical/" class="hdr-dd-link">Electrical Engineering</a></li>
                            <li><a href="<?= $root_path ?>departments/electronics-and-communication/" class="hdr-dd-link">Electronics &amp; Communication</a></li>
                            <li><a href="<?= $root_path ?>departments/information-technology/" class="hdr-dd-link">Information Technology</a></li>
                            <li><a href="<?= $root_path ?>departments/mechanical/" class="hdr-dd-link">Mechanical Engineering</a></li>
                            <li><a href="<?= $root_path ?>departments/science-and-humanities/" class="hdr-dd-link">Science &amp; Humanities</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Activities Dropdown (Categorized Mega Dropdown) -->
                <li class="hdr-nav-item has-dropdown">
                    <a href="<?= $root_path ?>college-activities.php"
                       class="hdr-nav-link <?= in_array($active_page, ['activities', 'college_activities', 'dept_activities', 'faculty_activities']) ? 'active is-active' : '' ?>">
                        Activities <i class="fas fa-chevron-down hdr-arrow"></i>
                    </a>
                    <div class="hdr-dropdown hdr-dropdown-mega">
                        <div class="hdr-mega-grid">
                            <div class="hdr-mega-col">
                                <div class="hdr-dd-heading">CAMPUS ACTIVITIES</div>
                                <ul class="hdr-dd-list">
                                    <li><a href="<?= $root_path ?>college-activities.php" class="hdr-dd-link <?= ($active_page === 'college_activities') ? 'is-active' : '' ?>">College Activities</a></li>
                                    <li><a href="<?= $root_path ?>departmental-activities.php" class="hdr-dd-link <?= ($active_page === 'dept_activities') ? 'is-active' : '' ?>">Departmental Activities</a></li>
                                    <li><a href="<?= $root_path ?>faculty-activities.php" class="hdr-dd-link <?= ($active_page === 'faculty_activities') ? 'is-active' : '' ?>">Faculty Activities</a></li>
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
                    <a href="javascript:void(0);" class="hdr-nav-link">
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
                    <a href="<?php echo ($active_page === 'home') ? '#alumni' : $root_path . 'index.php#alumni'; ?>"
                       class="hdr-nav-link">
                        Placement
                    </a>
                </li>

                <li class="hdr-nav-item">
                    <a href="<?= $root_path ?>contact.php"
                       class="hdr-nav-link <?= ($active_page === 'contact') ? 'active' : '' ?>">
                        Contact Us
                    </a>
                </li>

                <li class="hdr-nav-item">
                    <a href="<?= $root_path ?>developers.php"
                       class="hdr-nav-link <?= ($active_page === 'developers') ? 'active' : '' ?>">
                        Developers Team
                    </a>
                </li>

            </ul>
        </div>
    </nav>
