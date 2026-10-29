<?php
$page_title = "Government Engineering College, Modasa";
$active_page = "home";
$extra_css = "css/home.css";
$extra_js = "js/home.js";

// Database connection
require_once __DIR__ . '/includes/db.php';
$pdo = getDBConnection();

// Fetch content from database
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

// Fallback hero banner slides
if (empty($heroSlides)) {
    $heroSlides = [
        ['image_url' => 'images/hero_campus_1.jpg', 'label' => 'Main Campus & Admin Block', 'title' => 'Welcome to <br> Government Engineering College, Modasa', 'subtitle' => 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi']
    ];
}

// Fallback news tickers
if (empty($newsTickers)) {
    $newsTickers = [
        ['message' => 'Admission open for BE First Year 2024-25.'],
        ['message' => 'Mid-Semester Exams schedule has been released. Check notice board for details.'],
        ['message' => 'State Level Hackathon 2024 registrations are now open!']
    ];
}

// Fallback notices
if (empty($noticesList)) {
    $noticesList = [
        ['publish_date' => '2024-10-15', 'title' => 'Guidelines for AICTE Pragati & Saksham Scholarship Schemes 2024-25', 'badge' => 'New', 'link_url' => '#'],
        ['publish_date' => '2024-10-10', 'title' => 'Timetable for B.E. Semester 5 Mid-Semester Examination', 'badge' => 'None', 'link_url' => '#'],
        ['publish_date' => '2024-10-02', 'title' => 'Result Declaration: BE Sem-6 Regular Summer 2024', 'badge' => 'None', 'link_url' => '#'],
        ['publish_date' => '2024-09-28', 'title' => 'Academic Calendar for Odd Semester 2024-25', 'badge' => 'None', 'link_url' => '#'],
        ['publish_date' => '2024-09-20', 'title' => 'Submission of Scholarship Forms for SC/ST Students', 'badge' => 'Urgent', 'link_url' => '#'],
        ['publish_date' => '2024-09-15', 'title' => 'Hostel Admission Merit List Announced for First Year Students', 'badge' => 'None', 'link_url' => '#'],
        ['publish_date' => '2024-09-10', 'title' => 'GTU TechFest 2024 Participation Registration Open', 'badge' => 'None', 'link_url' => '#'],
        ['publish_date' => '2024-09-05', 'title' => 'Revised Syllabus for Engineering Mechanics (Civil Dept)', 'badge' => 'None', 'link_url' => '#']
    ];
}

// Fallback events
if (empty($recentEvents)) {
    $recentEvents = [
        [
            'image_url' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'title' => 'TechFest 2024',
            'description' => 'Annual Technical Symposium with 50+ inter-college events.',
            'view_url' => '#'
        ],
        [
            'image_url' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'title' => 'Convocation Ceremony',
            'description' => 'Batch of 2020-2024 engineering graduation day.',
            'view_url' => '#'
        ],
        [
            'image_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'title' => 'State Level Hackathon',
            'description' => '24-hour innovation sprint held at GEC Modasa campus.',
            'view_url' => '#'
        ]
    ];
}

// Fallback gallery shots
if (empty($latestShots)) {
    $latestShots = [
        [
            'image_url' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'title' => 'Robotics & Innovation',
            'description' => 'Students demonstrating autonomous robotics and IoT prototypes.'
        ],
        [
            'image_url' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'title' => 'Annual Sports Meet',
            'description' => 'Inter-department athletics championship and cricket tournament.'
        ],
        [
            'image_url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            'title' => 'Prarambh Youth Fest',
            'description' => 'Vibrant stage performances, music, drama, and celebrations.'
        ]
    ];
}

// Fallback alumni
if (empty($alumniList)) {
    $alumniList = [
        [
            'photo_url' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80',
            'name' => 'Rahul Sharma',
            'branch' => 'Computer Engg.',
            'graduation_year' => '2015',
            'company' => 'Google, USA'
        ],
        [
            'photo_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80',
            'name' => 'Priya Patel',
            'branch' => 'Information Technology',
            'graduation_year' => '2018',
            'company' => 'Microsoft, India'
        ],
        [
            'photo_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80',
            'name' => 'Amit Verma',
            'branch' => 'Mechanical Engg.',
            'graduation_year' => '2014',
            'company' => 'Tata Motors, Pune'
        ],
        [
            'photo_url' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80',
            'name' => 'Sneha Joshi',
            'branch' => 'Civil Engg.',
            'graduation_year' => '2019',
            'company' => 'L&T Construction'
        ],
        [
            'photo_url' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&auto=format&fit=crop&w=256&q=80',
            'name' => 'Kiran Mehta',
            'branch' => 'Electrical Engg.',
            'graduation_year' => '2016',
            'company' => 'Siemens Energy'
        ]
    ];
}

// Fallback departments
if (empty($departmentsList)) {
    $departmentsList = [
        ['id' => 1, 'name' => 'Computer Engineering', 'code' => 'CE', 'icon_class' => 'fas fa-laptop-code', 'learn_more_url' => 'departments/computer/'],
        ['id' => 2, 'name' => 'Information Technology', 'code' => 'IT', 'icon_class' => 'fas fa-network-wired', 'learn_more_url' => 'departments/information-technology/'],
        ['id' => 3, 'name' => 'Mechanical Engineering', 'code' => 'ME', 'icon_class' => 'fas fa-cogs', 'learn_more_url' => 'departments/mechanical/'],
        ['id' => 4, 'name' => 'Automobile Engineering', 'code' => 'AE', 'icon_class' => 'fas fa-car', 'learn_more_url' => '#'],
        ['id' => 5, 'name' => 'Civil Engineering', 'code' => 'CIVIL', 'icon_class' => 'fas fa-building', 'learn_more_url' => '#'],
        ['id' => 6, 'name' => 'Electrical Engineering', 'code' => 'EE', 'icon_class' => 'fas fa-bolt', 'learn_more_url' => '#'],
        ['id' => 7, 'name' => 'Electronics & Comm.', 'code' => 'EC', 'icon_class' => 'fas fa-microchip', 'learn_more_url' => '#'],
        ['id' => 8, 'name' => 'Applied Mechanics', 'code' => 'AM', 'icon_class' => 'fas fa-drafting-compass', 'learn_more_url' => '#'],
        ['id' => 9, 'name' => 'Science & Humanities', 'code' => 'SH', 'icon_class' => 'fas fa-atom', 'learn_more_url' => '#'],
    ];
}

// Department logos mapping
$deptLogos = [
    'Computer Engineering'   => 'logos/computer-department.png',
    'Information Technology' => 'logos/it-department.png',
    'Mechanical Engineering' => 'logos/mechanical-department.png',
    'Automobile Engineering' => 'logos/automobile-department.png',
    'Civil Engineering'      => 'logos/civil-department.png',
    'Electrical Engineering' => 'logos/electrical-department.png',
    'Electronics & Comm.'    => 'logos/ec-department.png',
];

// Department background images mapping (for mobile cards)
$deptImages = [
    'Computer Engineering'   => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'Information Technology' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'Mechanical Engineering' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'Automobile Engineering' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'Civil Engineering'      => 'https://images.unsplash.com/photo-1541888946425-d0fbb186c5f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'Electrical Engineering' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'Electronics & Comm.'    => 'https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'Applied Mechanics'      => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'Science & Humanities'   => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
];

include_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section id="about" class="hero govt-hero" aria-label="Campus Showcase">
    <!-- Hero Slides -->
    <div class="hero-slider" id="heroSlider">
        <?php foreach ($heroSlides as $i => $slide):
            $imgUrl = $slide['image_url'];
            if (!empty($imgUrl) && !file_exists(__DIR__ . '/' . $imgUrl)) {
                if (str_ends_with($imgUrl, '.webp') && file_exists(__DIR__ . '/' . preg_replace('/\.webp$/i', '.jpg', $imgUrl))) {
                    $imgUrl = preg_replace('/\.webp$/i', '.jpg', $imgUrl);
                } elseif (str_ends_with($imgUrl, '.jpg') && file_exists(__DIR__ . '/' . preg_replace('/\.jpg$/i', '.webp', $imgUrl))) {
                    $imgUrl = preg_replace('/\.jpg$/i', '.webp', $imgUrl);
                }
            }
        ?>
            <div class="hero-slide <?= ($i === 0) ? 'active' : '' ?>" style="background-image: url('<?= htmlspecialchars($imgUrl) ?>');"
                data-label="<?= htmlspecialchars($slide['label'] ?? '') ?>"></div>
        <?php endforeach; ?>
    </div>

    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1 class="hero-title fade-in-up delay-1"><?= $heroSlides[0]['title'] ?? 'Welcome to <br> Government Engineering College, Modasa' ?></h1>
        <p class="hero-subtitle fade-in-up delay-2"><?= htmlspecialchars(str_replace(['???', 'ÔÇó', 'â€¢', 'Â•'], '•', $heroSlides[0]['subtitle'] ?? 'Affiliated to Gujarat Technological University (GTU) • Approved by AICTE, New Delhi')) ?></p>

        <div class="hero-buttons fade-in-up delay-3">
            <a href="<?= htmlspecialchars($heroSlides[0]['virtual_tour_url'] ?? '#') ?>" class="btn btn-primary"><i class="fas fa-street-view"></i> Virtual Tour</a>
        </div>
    </div>

    <!-- Slider Controls -->
    <button class="hero-nav hero-prev" id="heroPrevBtn" aria-label="Previous Slide">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="hero-nav hero-next" id="heroNextBtn" aria-label="Next Slide">
        <i class="fas fa-chevron-right"></i>
    </button>

    <!-- Slider Indicators -->
    <div class="hero-indicators" id="heroIndicators">
        <?php foreach ($heroSlides as $i => $slide): ?>
            <button class="hero-dot <?= ($i === 0) ? 'active' : '' ?>" data-index="<?= $i ?>" aria-label="Slide <?= $i + 1 ?>"></button>
        <?php endforeach; ?>
    </div>
</section>

<!-- News Ticker -->
<div class="news-ticker-container">
    <div class="ticker-title">Updates</div>
    <div class="ticker-content">
        <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
            <?php foreach ($newsTickers as $tick): ?>
                <span><?= htmlspecialchars($tick['message']) ?></span>
            <?php endforeach; ?>
        </marquee>
    </div>
</div>

<!-- Notices & Events Grid -->
<section id="events" class="section container two-col-layout">
    <div class="notice-board">
        <div class="section-header">
            <h4>Notice Board</h4>
            <a href="#" class="view-all">View All</a>
        </div>
        <div class="notice-scroll-container">
            <div class="notice-marquee">
                <?php
                // Helper function to render notice rows
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
                <ul class="notice-list" aria-hidden="true">
                    <?php $renderNoticeItems($noticesList); ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent Events -->
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
                <!-- Dynamic Indicators -->
            </div>
        </div>
    </div>

    <!-- Gallery -->
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
                <!-- Dynamic Indicators -->
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
                    $colorClass = 'dept-default';
                    if ($deptCode === 'IT' || stripos($deptName, 'Information') !== false) {
                        $colorClass = 'dept-it';
                    } elseif ($deptCode === 'CE' || stripos($deptName, 'Computer') !== false) {
                        $colorClass = 'dept-ce';
                    } elseif ($deptCode === 'EE' || stripos($deptName, 'Electrical') !== false) {
                        $colorClass = 'dept-ee';
                    } elseif ($deptCode === 'EC' || stripos($deptName, 'Electronics') !== false) {
                        $colorClass = 'dept-ec';
                    } elseif ($deptCode === 'AE' || stripos($deptName, 'Automobile') !== false) {
                        $colorClass = 'dept-ae';
                    } elseif ($deptCode === 'CIVIL' || stripos($deptName, 'Civil') !== false) {
                        $colorClass = 'dept-civil';
                    } elseif ($deptCode === 'ME' || stripos($deptName, 'Mechanical') !== false) {
                        $colorClass = 'dept-me';
                    } elseif ($deptCode === 'AM' || stripos($deptName, 'Applied Mechanics') !== false) {
                        $colorClass = 'dept-am';
                    } elseif ($deptCode === 'SH' || stripos($deptName, 'Science') !== false || stripos($deptName, 'Humanities') !== false) {
                        $colorClass = 'dept-sh';
                    }
                    $resolvedUrl = (!empty($dept['learn_more_url']) && $dept['learn_more_url'] !== '#')
                        ? $dept['learn_more_url']
                        : ($deptCode === 'IT' || stripos($deptName, 'Information Technology') !== false
                            ? 'departments/information-technology/'
                            : ($deptCode === 'CE' || stripos($deptName, 'Computer') !== false
                                ? 'departments/computer/'
                                : ($deptCode === 'ME' || stripos($deptName, 'Mechanical') !== false
                                    ? 'departments/mechanical/'
                                    : '#')));
                ?>
                <div class="dept-card <?= $colorClass ?>" onclick="if('<?= htmlspecialchars($resolvedUrl) ?>' !== '#') { window.location.href='<?= htmlspecialchars($resolvedUrl) ?>'; }" style="cursor: <?= ($resolvedUrl !== '#') ? 'pointer' : 'default' ?>;">
                    <div class="dept-icon">
                        <?php if (!empty($deptLogos[$dept['name']]) && file_exists(__DIR__ . '/' . $deptLogos[$dept['name']])): ?>
                            <img src="<?= htmlspecialchars($deptLogos[$dept['name']]) ?>" alt="<?= htmlspecialchars($dept['name']) ?> Icon" class="dept-img-icon">
                        <?php else: ?>
                            <i class="<?= htmlspecialchars($dept['icon_class'] ?? 'fas fa-graduation-cap') ?>"></i>
                        <?php endif; ?>
                    </div>
                    <h3><?= htmlspecialchars($dept['name']) ?></h3>
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