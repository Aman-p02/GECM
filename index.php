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

// Fallback arrays if database is temporarily unavailable or tables are empty
if (empty($heroSlides)) {
    $heroSlides = [
        ['image_url' => 'images/hero_campus_1.webp', 'label' => 'Main Campus & Admin Block', 'title' => 'Welcome to <br> Government Engineering College, Modasa', 'subtitle' => 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi'],
        ['image_url' => 'images/hero_campus_2.jpg', 'label' => 'Engineering Academic Complex', 'title' => 'Welcome to <br> Government Engineering College, Modasa', 'subtitle' => 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi'],
        ['image_url' => 'images/hero_campus_3.jpg', 'label' => 'Central Library & Auditorium', 'title' => 'Welcome to <br> Government Engineering College, Modasa', 'subtitle' => 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi'],
        ['image_url' => 'images/hero_campus_4.jpg', 'label' => 'Lush Green Campus Aerial View', 'title' => 'Welcome to <br> Government Engineering College, Modasa', 'subtitle' => 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi'],
    ];
}

if (empty($newsTickers)) {
    $newsTickers = [
        ['message' => 'Admission open for BE First Year 2024-25.', 'link_url' => '#'],
        ['message' => 'Mid-Semester Exams schedule has been released. Check notice board for details.', 'link_url' => '#'],
        ['message' => 'State Level Hackathon 2024 registrations are now open!', 'link_url' => '#'],
    ];
}

if (empty($noticesList)) {
    $noticesList = [
        ['title' => 'Guidelines for AICTE Pragati & Saksham Scholarship Schemes 2024-25', 'publish_date' => '2026-10-15', 'badge' => 'New', 'link_url' => '#'],
        ['title' => 'Timetable for B.E. Semester 5 Mid-Semester Examination', 'publish_date' => '2026-10-10', 'badge' => 'None', 'link_url' => '#'],
        ['title' => 'Result Declaration: BE Sem-6 Regular Summer 2024', 'publish_date' => '2026-10-02', 'badge' => 'None', 'link_url' => '#'],
        ['title' => 'Academic Calendar for Odd Semester 2024-25', 'publish_date' => '2026-09-28', 'badge' => 'None', 'link_url' => '#'],
        ['title' => 'Submission of Scholarship Forms for SC/ST Students', 'publish_date' => '2026-09-20', 'badge' => 'Urgent', 'link_url' => '#'],
        ['title' => 'Hostel Admission Merit List Announced for First Year Students', 'publish_date' => '2026-09-15', 'badge' => 'None', 'link_url' => '#'],
        ['title' => 'GTU TechFest 2024 Participation Registration Open', 'publish_date' => '2026-09-10', 'badge' => 'None', 'link_url' => '#'],
        ['title' => 'Revised Syllabus for Engineering Mechanics (Civil Dept)', 'publish_date' => '2026-09-05', 'badge' => 'None', 'link_url' => '#'],
    ];
}

if (empty($recentEvents)) {
    $recentEvents = [
        ['title' => 'TechFest 2024', 'description' => 'Annual Technical Symposium with 50+ inter-college events.', 'image_url' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'view_url' => '#'],
        ['title' => 'Convocation Ceremony', 'description' => 'Batch of 2020-2024 engineering graduation day.', 'image_url' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'view_url' => '#'],
        ['title' => 'State Level Hackathon', 'description' => '24-hour innovation sprint held at GEC Modasa campus.', 'image_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 'view_url' => '#'],
    ];
}

if (empty($latestShots)) {
    $latestShots = [
        ['title' => 'Robotics & Innovation', 'description' => 'Students demonstrating autonomous robotics and IoT prototypes.', 'image_url' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
        ['title' => 'Annual Sports Meet', 'description' => 'Inter-department athletics championship and cricket tournament.', 'image_url' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
        ['title' => 'Prarambh Youth Fest', 'description' => 'Vibrant stage performances, music, drama, and celebrations.', 'image_url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
        ['title' => 'Engineering Workshop', 'description' => 'Hands-on practical machining and metal fabrication sessions.', 'image_url' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'],
    ];
}

if (empty($departmentsList)) {
    $departmentsList = [
        ['name' => 'Computer Engineering', 'icon_class' => 'fas fa-desktop', 'learn_more_url' => '#'],
        ['name' => 'Information Technology', 'icon_class' => 'fas fa-network-wired', 'learn_more_url' => '#'],
        ['name' => 'Mechanical Engineering', 'icon_class' => 'fas fa-cogs', 'learn_more_url' => '#'],
        ['name' => 'Automobile Engineering', 'icon_class' => 'fas fa-car-side', 'learn_more_url' => '#'],
        ['name' => 'Civil Engineering', 'icon_class' => 'fas fa-building', 'learn_more_url' => '#'],
        ['name' => 'Electrical Engineering', 'icon_class' => 'fas fa-bolt', 'learn_more_url' => '#'],
        ['name' => 'Electronics & Comm.', 'icon_class' => 'fas fa-microchip', 'learn_more_url' => '#'],
    ];
}

if (empty($alumniList)) {
    $alumniList = [
        ['name' => 'Rahul Sharma', 'branch' => 'Computer Engg.', 'graduation_year' => 2015, 'company' => 'Google, USA', 'photo_url' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80'],
        ['name' => 'Priya Patel', 'branch' => 'IT Engg.', 'graduation_year' => 2018, 'company' => 'Microsoft, India', 'photo_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80'],
        ['name' => 'Amit Kumar', 'branch' => 'Mechanical Engg.', 'graduation_year' => 2012, 'company' => 'Tata Motors', 'photo_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80'],
        ['name' => 'Sneha Desai', 'branch' => 'Civil Engg.', 'graduation_year' => 2016, 'company' => 'L&T Construction', 'photo_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80'],
        ['name' => 'Karan Singh', 'branch' => 'Electrical Engg.', 'graduation_year' => 2019, 'company' => 'Reliance Industries', 'photo_url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80'],
        ['name' => 'Pooja Mehta', 'branch' => 'Electronics & Comm.', 'graduation_year' => 2017, 'company' => 'Intel Corporation', 'photo_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80'],
        ['name' => 'Darshan Joshi', 'branch' => 'Automobile Engg.', 'graduation_year' => 2014, 'company' => 'Mahindra R&D', 'photo_url' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80'],
        ['name' => 'Riya Trivedi', 'branch' => 'Computer Engg.', 'graduation_year' => 2021, 'company' => 'Amazon AWS', 'photo_url' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80'],
    ];
}

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
        <p class="hero-subtitle fade-in-up delay-2"><?= htmlspecialchars($heroSlides[0]['subtitle'] ?? 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi') ?></p>

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
                <?php foreach ($departmentsList as $dept): ?>
                <div class="dept-card">
                    <div class="dept-icon"><i class="<?= htmlspecialchars($dept['icon_class'] ?? 'fas fa-graduation-cap') ?>"></i></div>
                    <h3><?= htmlspecialchars($dept['name']) ?></h3>
                    <a href="<?= htmlspecialchars($dept['learn_more_url'] ?? '#') ?>" class="dept-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <?php endforeach; ?>
            </div>
            <button class="scroll-btn dept-btn right-btn" id="deptRightBtn" aria-label="Next Department"><i
                    class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>

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

<?php
include_once __DIR__ . '/includes/footer.php';
?>