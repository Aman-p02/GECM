<?php
$page_title = "Government Engineering College, Modasa";
$active_page = "home";
$extra_css = "css/home.css";
$extra_js = "js/home.js";

// Include Database Handler
require_once __DIR__ . '/includes/db.php';
$pdo = getDBConnection();

// Fetch Dynamic Records from Database
$heroSlides = [];
$newsTickers = [];
$noticesList = [];
$recentEvents = [];
$latestShots = [];
$departmentsList = [];
$alumniList = [];

if ($pdo) {
    try {
        $heroSlides = $pdo->query("SELECT * FROM hero_slides WHERE is_active = 1 ORDER BY display_order ASC, id ASC")->fetchAll();
        $newsTickers = $pdo->query("SELECT * FROM news_ticker WHERE is_active = 1 ORDER BY display_order ASC, id ASC")->fetchAll();
        $noticesList = $pdo->query("SELECT * FROM notices WHERE is_active = 1 ORDER BY publish_date DESC, id DESC")->fetchAll();
        $recentEvents = $pdo->query("SELECT * FROM events WHERE is_active = 1 ORDER BY display_order ASC, id ASC")->fetchAll();
        $latestShots = $pdo->query("SELECT * FROM latest_shots WHERE is_active = 1 ORDER BY display_order ASC, id ASC")->fetchAll();
        $departmentsList = $pdo->query("SELECT * FROM departments WHERE is_active = 1 ORDER BY display_order ASC, id ASC")->fetchAll();
        $alumniList = $pdo->query("SELECT * FROM alumni WHERE is_active = 1 ORDER BY display_order ASC, id ASC")->fetchAll();
    } catch (Exception $e) {
        error_log("DB Query Error: " . $e->getMessage());
    }
}

// Fallback only for hero banner if table has 0 slides
if (empty($heroSlides)) {
    $heroSlides = [
        ['image_url' => 'images/hero_campus_1.webp', 'label' => 'Main Campus & Admin Block', 'title' => 'Welcome to <br> Government Engineering College, Modasa', 'subtitle' => 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi']
    ];
}

// Department Logos mapping
$deptLogos = [
    'Computer Engineering'   => 'logos/computer-department.png',
    'Information Technology' => 'logos/it-department.png',
    'Mechanical Engineering' => 'logos/mechanical-department.png',
    'Automobile Engineering' => 'logos/automobile-department.png',
    'Civil Engineering'      => 'logos/civil-department.png',
    'Electrical Engineering' => 'logos/electrical-department.png',
    'Electronics & Comm.'    => 'logos/ec-department.png',
];

include_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section with Background Carousel -->
<section id="about" class="hero govt-hero" aria-label="Campus Showcase">
    <!-- Hero Image Carousel Slides -->
    <div class="hero-slider" id="heroSlider">
        <?php foreach ($heroSlides as $i => $slide): ?>
            <div class="hero-slide <?= ($i === 0) ? 'active' : '' ?>" style="background-image: url('<?= htmlspecialchars($slide['image_url']) ?>');"
                data-label="<?= htmlspecialchars($slide['label'] ?? '') ?>"></div>
        <?php endforeach; ?>
    </div>

    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1 class="hero-title fade-in-up delay-1"><?= $heroSlides[0]['title'] ?? 'Welcome to <br> Government Engineering College, Modasa' ?></h1>
        <p class="hero-subtitle fade-in-up delay-2"><?= htmlspecialchars(str_replace('???', '•', $heroSlides[0]['subtitle'] ?? 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi')) ?></p>

        <div class="hero-buttons fade-in-up delay-3">
            <a href="<?= htmlspecialchars($heroSlides[0]['virtual_tour_url'] ?? '#') ?>" class="btn btn-primary"><i class="fas fa-street-view"></i> Virtual Tour</a>
        </div>
    </div>

    <!-- Carousel Navigation Arrows -->
    <button class="hero-nav hero-prev" id="heroPrevBtn" aria-label="Previous Slide">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="hero-nav hero-next" id="heroNextBtn" aria-label="Next Slide">
        <i class="fas fa-chevron-right"></i>
    </button>

    <!-- Carousel Indicators (Dots) -->
    <div class="hero-indicators" id="heroIndicators">
        <?php foreach ($heroSlides as $i => $slide): ?>
            <button class="hero-dot <?= ($i === 0) ? 'active' : '' ?>" data-index="<?= $i ?>" aria-label="Slide <?= $i + 1 ?>"></button>
        <?php endforeach; ?>
    </div>
</section>

<!-- Notice Board Marquee -->
<div class="news-ticker-container">
    <div class="ticker-title">Updates</div>
    <div class="ticker-content">
        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
            <?php foreach ($newsTickers as $tick): ?>
                <span><i class="fas fa-bell"></i> <?= htmlspecialchars($tick['message']) ?></span>
            <?php endforeach; ?>
        </marquee>
    </div>
</div>

<!-- Main Content Grid for Notices and Quick Links -->
<section id="events" class="section container two-col-layout">
    <div class="notice-board">
        <div class="section-header">
            <h4>Notice Board</h4>
            <a href="#" class="view-all">View All</a>
        </div>
        <div class="notice-scroll-container">
            <div class="notice-marquee">
                <?php
                // Helper to render notice item list
                $renderNoticeItems = function($notices) {
                    foreach ($notices as $row) {
                        $dateTs = !empty($row['publish_date']) ? strtotime($row['publish_date']) : time();
                        $day = date('d', $dateTs);
                        $month = date('M', $dateTs);
                        $badge = $row['badge'] ?? 'None';
                        $link = (!empty($row['link_url']) && $row['link_url'] !== '#') ? htmlspecialchars($row['link_url']) : '#';
                        $target = ($link !== '#') ? ' target="_blank"' : '';
                        echo '<li>';
                        echo '<div class="date"><span class="day">' . $day . '</span><span class="month">' . $month . '</span></div>';
                        echo '<div class="notice-text">';
                        echo '<a href="' . $link . '"' . $target . '>' . htmlspecialchars($row['title']) . '</a>';
                        if ($badge === 'New') {
                            echo '<span class="badge new">New</span>';
                        } elseif ($badge === 'Urgent') {
                            echo '<span class="badge new" style="background: #e53935;">Urgent</span>';
                        }
                        echo '</div>';
                        echo '</li>';
                    }
                };
                ?>
                <ul class="notice-list">
                    <?php $renderNoticeItems($noticesList); ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- 2. Recent Events Carousel -->
    <div class="recent-events-card">
        <div class="section-header">
            <h4>Recent Events</h4>
            <a href="#" class="view-all">All Events</a>
        </div>
        <div class="events-slider-container">
            <div class="events-slider" id="eventsSlider">
                <?php foreach ($recentEvents as $ev): ?>
                <div class="event-slide">
                    <img src="<?= htmlspecialchars($ev['image_url']) ?>" alt="<?= htmlspecialchars($ev['title']) ?>">
                    <div class="slide-content">
                        <h4><?= htmlspecialchars($ev['title']) ?></h4>
                        <p><?= htmlspecialchars($ev['description']) ?></p>
                        <a href="<?= htmlspecialchars($ev['view_url'] ?? '#') ?>" class="view-full-btn">View Full <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="slider-dots" id="sliderDots">
                <!-- Dots will be generated by JS -->
            </div>
        </div>
    </div>

    <!-- 3. Latest Shots Carousel -->
    <div class="latest-shots-card">
        <div class="section-header">
            <h4>Latest Shots</h4>
            <a href="#" class="view-all">View Gallery</a>
        </div>
        <div class="shots-slider-container">
            <div class="shots-slider" id="shotsSlider">
                <?php foreach ($latestShots as $shot): ?>
                <div class="shot-slide">
                    <div class="shot-img-wrapper">
                        <img src="<?= htmlspecialchars($shot['image_url']) ?>" alt="<?= htmlspecialchars($shot['title']) ?>">
                    </div>
                    <div class="shot-content">
                        <h4><?= htmlspecialchars($shot['title']) ?></h4>
                        <p><?= htmlspecialchars($shot['description']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="slider-dots" id="shotsSliderDots">
                <!-- Dots will be generated by JS -->
            </div>
        </div>
    </div>
</section>

<!-- Departments Section -->
<section id="departments" class="section bg-light">
    <div class="full-width-container">
        <div class="section-title text-center">
            <h3>Our Departments</h3>
            <div class="title-underline"></div>
        </div>
        <div class="dept-wrapper">
            <button class="scroll-btn dept-btn left-btn" id="deptLeftBtn" aria-label="Previous Department"><i
                    class="fas fa-chevron-left"></i></button>
            <div class="dept-grid" id="deptGrid">
                <?php foreach ($departmentsList as $dept): 
                    $deptCode = strtoupper(trim($dept['code'] ?? ''));
                    $deptName = trim($dept['name'] ?? '');
                    $resolvedUrl = (!empty($dept['learn_more_url']) && $dept['learn_more_url'] !== '#') 
                        ? $dept['learn_more_url'] 
                        : ($deptCode === 'IT' || stripos($deptName, 'Information Technology') !== false 
                            ? 'departments/information-technology/' 
                            : ($deptCode === 'CE' || stripos($deptName, 'Computer') !== false 
                                ? 'departments/computer/' 
                                : '#'));
                ?>
                <div class="dept-card">
                    <div class="dept-icon">
                        <?php if (!empty($deptLogos[$dept['name']]) && file_exists(__DIR__ . '/' . $deptLogos[$dept['name']])): ?>
                            <img src="<?= htmlspecialchars($deptLogos[$dept['name']]) ?>" alt="<?= htmlspecialchars($dept['name']) ?> Icon" class="dept-img-icon">
                        <?php else: ?>
                            <i class="<?= htmlspecialchars($dept['icon_class'] ?? 'fas fa-graduation-cap') ?>"></i>
                        <?php endif; ?>
                    </div>
                    <h3><?= htmlspecialchars($dept['name']) ?></h3>
                    <a href="<?= htmlspecialchars($resolvedUrl) ?>" class="dept-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <?php endforeach; ?>
            </div>
            <button class="scroll-btn dept-btn right-btn" id="deptRightBtn" aria-label="Next Department"><i
                    class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>

<?php if (!empty($alumniList)): ?>
<!-- Alumni Section -->
<section id="alumni" class="section alumni-section">
    <div class="full-width-container">
        <div class="section-title text-center">
            <h2>Our Proud Alumni</h2>
            <p>Leading the industry worldwide</p>
            <div class="title-underline"></div>
        </div>

        <div class="alumni-wrapper">
            <button class="scroll-btn left-btn" id="alumniLeftBtn" aria-label="Previous Alumni"><i
                    class="fas fa-chevron-left"></i></button>
            <div class="alumni-carousel" id="alumniCarousel">
                <?php foreach ($alumniList as $alumnus): ?>
                <div class="alumni-card">
                    <img src="<?= htmlspecialchars($alumnus['photo_url']) ?>" alt="<?= htmlspecialchars($alumnus['name']) ?>">
                    <h4><?= htmlspecialchars($alumnus['name']) ?></h4>
                    <p class="batch"><?= htmlspecialchars($alumnus['branch']) ?> &bull; <?= htmlspecialchars($alumnus['graduation_year']) ?></p>
                    <p class="company"><?= htmlspecialchars($alumnus['company']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <button class="scroll-btn right-btn" id="alumniRightBtn" aria-label="Next Alumni"><i
                    class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
include_once __DIR__ . '/includes/footer.php';
?>