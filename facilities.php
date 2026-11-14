<?php
$page_title = "Campus Facilities | Government Engineering College, Modasa";
$active_page = "facilities";
$extra_css = "css/facilities.css";

require_once __DIR__ . '/includes/header.php';

$facilities = [
    [
        'title'    => 'Siemens Center of Excellence (CoE)',
        'category' => 'Industry Partnered',
        'icon'     => 'fas fa-cogs',
        'desc'     => 'State-of-the-art specialized laboratories established in partnership with Siemens Industry Software, providing hands-on training in product design, digital manufacturing, automation, and industrial robotics.'
    ],
    [
        'title'    => 'Central Digital Library &amp; LRC',
        'category' => 'Academic Resource',
        'icon'     => 'fas fa-book-reader',
        'desc'     => 'Comprehensive repository of over 30,000+ technical volumes, national and international engineering journals, IEEE and ScienceDirect e-subscriptions, with an air-conditioned digital learning and research hall.'
    ],
    [
        'title'    => 'Central Computing Facility (CCF)',
        'category' => 'IT Infrastructure',
        'icon'     => 'fas fa-network-wired',
        'desc'     => 'Modern campus-wide computing infrastructure powered by 1 Gbps National Knowledge Network (NKN) leased lines, high-end workstations, campus-wide Wi-Fi, and licensed engineering design tools.'
    ],
    [
        'title'    => 'On-Campus Student Hostels',
        'category' => 'Residential',
        'icon'     => 'fas fa-building',
        'desc'     => 'Safe and secure on-campus residential accommodation for boys and girls, featuring RO purified drinking water, 24/7 security surveillance, recreation rooms, and hygienic student dining mess facilities.'
    ],
    [
        'title'    => 'Central Engineering Workshop',
        'category' => 'Practical Training',
        'icon'     => 'fas fa-tools',
        'desc'     => 'Spacious practical shop floors including Machine Shop, Welding, Carpentry, Fitting, Smithy, and Foundry equipped with modern machines to foster foundational hands-on manufacturing skills.'
    ],
    [
        'title'    => 'Sports Complex &amp; Gymkhana',
        'category' => 'Recreation &amp; Fitness',
        'icon'     => 'fas fa-running',
        'desc'     => 'Extensive athletic grounds for cricket, football, volleyball, and badminton, complemented by an indoor gymkhana for table tennis, chess, and dedicated student physical fitness development.'
    ],
    [
        'title'    => 'Auditorium &amp; Seminar Halls',
        'category' => 'Events &amp; Symposia',
        'icon'     => 'fas fa-microphone-alt',
        'desc'     => 'Acoustically treated, air-conditioned seminar halls and open-air performance spaces equipped with high-definition audio-visual projection systems for national conferences, expert lectures, and cultural events.'
    ],
    [
        'title'    => 'SSIP &amp; DIC Innovation Hub',
        'category' => 'Start-up &amp; Research',
        'icon'     => 'fas fa-lightbulb',
        'desc'     => 'Dedicated innovation and pre-incubation workspace under the Student Start-up and Innovation Policy (SSIP) and Design Innovation Centre (DIC), offering seed funding, mentoring, and patent filing support.'
    ],
    [
        'title'    => 'Student Cafeteria &amp; Amenities',
        'category' => 'Campus Amenities',
        'icon'     => 'fas fa-utensils',
        'desc'     => 'Clean and hygienic campus canteen serving wholesome meals, snacks, and beverages, supported by an on-campus student store, post office, banking facilities, and medical first-aid center.'
    ]
];
?>

<div class="fac-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="fac-hero">
        <div class="container">
            <span class="fac-kicker">THE INSTITUTE</span>
            <h1 class="fac-heading">Campus Facilities</h1>
            <p class="fac-lead">
                Sprawling academic, research, and residential infrastructure designed to support high educational standards, practical engineering competence, and holistic student life.
            </p>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="container">
        <div class="fac-grid">
            <?php foreach ($facilities as $item): ?>
                <div class="fac-card">
                    <div class="fac-card-header">
                        <div class="fac-icon-box">
                            <i class="<?= htmlspecialchars($item['icon']) ?>"></i>
                        </div>
                        <span class="fac-badge"><?= htmlspecialchars($item['category']) ?></span>
                    </div>
                    <h2 class="fac-title"><?= $item['title'] ?></h2>
                    <p class="fac-desc"><?= $item['desc'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
