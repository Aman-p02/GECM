<?php
/**
 * GEC MODASA - ACADEMIC CALENDAR
 * Official Institutional Semester Term Schedules & GTU Circulars
 */
$page_title = "Academic Calendar | Government Engineering College, Modasa";
$active_page = "academic-calendar";
$root_path = "../";
$extra_css = "css/academic-calendar.css";

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

// In-Memory Fallback Archive Matching Official Institutional Records
$fallbackCalendars = [
    ['academic_year' => '2026-27', 'semester_type' => 'Odd',  'title' => 'Academic Calendar 2026-27 (Odd Semesters)',  'file_path' => 'uploads/academic_calendar/academic_calendar_2026_27_odd.pdf',  'file_size' => '245 KB'],
    ['academic_year' => '2025-26', 'semester_type' => 'Odd',  'title' => 'Academic Calendar 2025-26 (Odd Semesters)',  'file_path' => 'uploads/academic_calendar/academic_calendar_2025_26_odd.pdf',  'file_size' => '230 KB'],
    ['academic_year' => '2025-26', 'semester_type' => 'Even', 'title' => 'Academic Calendar 2025-26 (Even Semesters)', 'file_path' => 'uploads/academic_calendar/academic_calendar_2025_26_even.pdf', 'file_size' => '215 KB'],
    ['academic_year' => '2024-25', 'semester_type' => 'Odd',  'title' => 'Academic Calendar 2024-25 (Odd Semesters)',  'file_path' => 'uploads/academic_calendar/academic_calendar_2024_25_odd.pdf',  'file_size' => '280 KB'],
    ['academic_year' => '2024-25', 'semester_type' => 'Even', 'title' => 'Academic Calendar 2024-25 (Even Semesters)', 'file_path' => 'uploads/academic_calendar/academic_calendar_2024_25_even.pdf', 'file_size' => '265 KB'],
    ['academic_year' => '2023-24', 'semester_type' => 'Odd',  'title' => 'Academic Calendar 2023-24 (Odd Semesters)',  'file_path' => 'uploads/academic_calendar/academic_calendar_2023_24_odd.pdf',  'file_size' => '310 KB'],
    ['academic_year' => '2023-24', 'semester_type' => 'Even', 'title' => 'Academic Calendar 2023-24 (Even Semesters)', 'file_path' => 'uploads/academic_calendar/academic_calendar_2023_24_even.pdf', 'file_size' => '290 KB'],
    ['academic_year' => '2022-23', 'semester_type' => 'Odd',  'title' => 'Academic Calendar 2022-23 (Odd Semesters)',  'file_path' => 'uploads/academic_calendar/academic_calendar_2022_23_odd.pdf',  'file_size' => '250 KB'],
    ['academic_year' => '2022-23', 'semester_type' => 'Even', 'title' => 'Academic Calendar 2022-23 (Even Semesters)', 'file_path' => 'uploads/academic_calendar/academic_calendar_2022_23_even.pdf', 'file_size' => '240 KB'],
    ['academic_year' => '2021-22', 'semester_type' => 'Odd',  'title' => 'Academic Calendar 2021-22 (Odd Semesters)',  'file_path' => 'uploads/academic_calendar/academic_calendar_2021_22_odd.pdf',  'file_size' => '210 KB'],
    ['academic_year' => '2021-22', 'semester_type' => 'Even', 'title' => 'Academic Calendar 2021-22 (Even Semesters)', 'file_path' => 'uploads/academic_calendar/academic_calendar_2021_22_even.pdf', 'file_size' => '205 KB'],
    ['academic_year' => '2020-21', 'semester_type' => 'Odd',  'title' => 'Academic Calendar 2020-21 (Odd Semesters)',  'file_path' => 'uploads/academic_calendar/academic_calendar_2020_21_odd.pdf',  'file_size' => '195 KB'],
    ['academic_year' => '2020-21', 'semester_type' => 'Even', 'title' => 'Academic Calendar 2020-21 (Even Semesters)', 'file_path' => 'uploads/academic_calendar/academic_calendar_2020_21_even.pdf', 'file_size' => '190 KB'],
    ['academic_year' => '2019-20', 'semester_type' => 'Odd',  'title' => 'Academic Calendar 2019-20 (Odd Semesters)',  'file_path' => 'uploads/academic_calendar/academic_calendar_2019_20_odd.pdf',  'file_size' => '220 KB'],
    ['academic_year' => '2019-20', 'semester_type' => 'Even', 'title' => 'Academic Calendar 2019-20 (Even Semesters)', 'file_path' => 'uploads/academic_calendar/academic_calendar_2019_20_even.pdf', 'file_size' => '215 KB'],
];

// Query Live Database
$calendarList = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM academic_calendars WHERE is_active = 1 ORDER BY display_order ASC, academic_year DESC, semester_type ASC");
        $dbRows = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
        if (!empty($dbRows)) {
            $calendarList = $dbRows;
        }
    } catch (Throwable $e) {
        error_log("Academic calendar fetch error: " . $e->getMessage());
    }
}

if (empty($calendarList)) {
    $calendarList = $fallbackCalendars;
}

// Group by Academic Year
$groupedYears = [];
foreach ($calendarList as $item) {
    $yr = trim($item['academic_year']);
    $sem = trim($item['semester_type']);
    if (!isset($groupedYears[$yr])) {
        $groupedYears[$yr] = [
            'year' => $yr,
            'Odd' => null,
            'Even' => null,
            'Full Year' => null
        ];
    }
    $groupedYears[$yr][$sem] = $item;
}

// Calculate Metrics
$totalYearsCount = count($groupedYears);
$totalDocsCount = count($calendarList);
$latestYear = array_key_first($groupedYears) ?? '2026-27';
?>

<div class="cal-page" id="mainContent">

    <!-- Hero Banner -->
    <header class="cal-hero">
        <div class="container">
            <nav class="cal-breadcrumbs" aria-label="Breadcrumb">
                <a href="<?= $root_path ?>">Home</a>
                <span class="sep"><i class="fas fa-chevron-right"></i></span>
                <a href="<?= $root_path ?>academics/courses">Academics</a>
                <span class="sep"><i class="fas fa-chevron-right"></i></span>
                <span class="current">Academic Calendar</span>
            </nav>

            <span class="cal-kicker">OFFICIAL INSTITUTIONAL SCHEDULE</span>
            <h1 class="cal-heading">Academic Calendar</h1>
            <p class="cal-lead">
                Comprehensive semester-wise schedule detailing instructional terms, commencement dates, mid-semester assessments, vacation periods, and Gujarat Technological University (GTU) academic timelines.
            </p>

            <!-- Key Metrics Stats Grid -->
            <div class="cal-stats-grid">
                <div class="cal-stat-card">
                    <span class="cal-stat-num"><?= $latestYear ?></span>
                    <span class="cal-stat-label">Current Academic Session</span>
                </div>
                <div class="cal-stat-card">
                    <span class="cal-stat-num"><?= $totalYearsCount ?> Years</span>
                    <span class="cal-stat-label">Archived Sessions</span>
                </div>
                <div class="cal-stat-card">
                    <span class="cal-stat-num">Odd &amp; Even</span>
                    <span class="cal-stat-label">Semester Term Schedules</span>
                </div>
                <div class="cal-stat-card">
                    <span class="cal-stat-num">GTU Aligned</span>
                    <span class="cal-stat-label">State University Guidelines</span>
                </div>
            </div>
        </div>
    </header>

    <div class="container" style="margin-top: 0;">

        <!-- Filter & Search Toolbar -->
        <div class="cal-toolbar-card">
            <div class="cal-toolbar-inner">
                <div class="cal-filter-pills" role="tablist">
                    <button type="button" class="cal-pill-btn active" data-filter="all">
                        <i class="fas fa-layer-group"></i> All Sessions (<?= $totalYearsCount ?>)
                    </button>
                    <button type="button" class="cal-pill-btn" data-filter="odd">
                        <i class="fas fa-calendar-alt"></i> Odd Semesters
                    </button>
                    <button type="button" class="cal-pill-btn" data-filter="even">
                        <i class="fas fa-calendar-check"></i> Even Semesters
                    </button>
                </div>

                <div class="cal-search-box">
                    <i class="fas fa-search cal-search-icon"></i>
                    <input type="text" id="calSearchInput" class="cal-search-input" placeholder="Search academic year (e.g. 2026-27)..." aria-label="Search Academic Calendar">
                </div>
            </div>
        </div>

        <!-- Institutional Regulation Callout -->
        <div class="cal-notice-card">
            <i class="fas fa-info-circle cal-notice-icon"></i>
            <p class="cal-notice-text">
                <strong>Academic Governance Notice:</strong> The Academic Calendars published herein are formulated in accordance with the regulatory directives of Gujarat Technological University (GTU), Ahmedabad, and the Directorate of Technical Education (DTE), Gandhinagar. Term dates, end-semester examinations, and non-instructional days are subject to official university notifications.
            </p>
        </div>

        <!-- Academic Calendar Main Table Card -->
        <div class="cal-table-card">
            <div class="cal-table-header-strip">
                <div>
                    <h2 class="cal-table-heading">
                        <i class="fas fa-calendar-week"></i> Session-Wise Academic Calendars
                    </h2>
                    <p class="cal-table-sub">Click on any semester term document below to view or download the verified institutional PDF schedule.</p>
                </div>
            </div>

            <!-- Desktop View: High Contrast Structured Table -->
            <div class="cal-table-wrap">
                <table class="cal-table" id="calMainTable">
                    <thead>
                        <tr>
                            <th style="width: 22%;">Academic Year</th>
                            <th style="width: 39%;">Odd Semester (Sem 1, 3, 5, 7)</th>
                            <th style="width: 39%;">Even Semester (Sem 2, 4, 6, 8)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groupedYears as $yearKey => $yearData): 
                            $oddDoc = $yearData['Odd'];
                            $evenDoc = $yearData['Even'];
                            $isCurrentYear = ($yearKey === $latestYear);
                        ?>
                            <tr class="cal-row" data-year="<?= htmlspecialchars(strtolower($yearKey)) ?>" data-has-odd="<?= $oddDoc ? '1' : '0' ?>" data-has-even="<?= $evenDoc ? '1' : '0' ?>">
                                <!-- Academic Year Column -->
                                <td>
                                    <div class="cal-year-badge">
                                        <?= htmlspecialchars($yearKey) ?>
                                        <?php if ($isCurrentYear): ?>
                                            <span class="cal-tag-current">Current</span>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Odd Semester Column -->
                                <td>
                                    <?php if ($oddDoc && !empty($oddDoc['file_path'])): 
                                        $oddUrl = $root_path . ltrim($oddDoc['file_path'], '/');
                                        $oddSize = $oddDoc['file_size'] ?? 'PDF';
                                        $oddLabel = htmlspecialchars($oddDoc['title'] ?? ($yearKey . ' (Odd)'));
                                    ?>
                                        <a href="<?= htmlspecialchars($oddUrl) ?>" target="_blank" class="cal-doc-item" title="Download <?= $oddLabel ?>">
                                            <div class="cal-doc-icon">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div class="cal-doc-info">
                                                <span class="cal-doc-title"><?= htmlspecialchars($yearKey) ?> (Odd)</span>
                                                <span class="cal-doc-meta">
                                                    <span><?= htmlspecialchars($oddSize) ?></span>
                                                    <span>•</span>
                                                    <span>Verified GTU</span>
                                                </span>
                                            </div>
                                            <span class="cal-doc-action-tag">
                                                <i class="fas fa-arrow-down"></i>
                                            </span>
                                        </a>
                                    <?php else: ?>
                                        <span class="cal-empty-state-cell">
                                            <i class="fas fa-clock"></i> Schedule Awaited / Not Applicable
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Even Semester Column -->
                                <td>
                                    <?php if ($evenDoc && !empty($evenDoc['file_path'])): 
                                        $evenUrl = $root_path . ltrim($evenDoc['file_path'], '/');
                                        $evenSize = $evenDoc['file_size'] ?? 'PDF';
                                        $evenLabel = htmlspecialchars($evenDoc['title'] ?? ($yearKey . ' (Even)'));
                                    ?>
                                        <a href="<?= htmlspecialchars($evenUrl) ?>" target="_blank" class="cal-doc-item" title="Download <?= $evenLabel ?>">
                                            <div class="cal-doc-icon">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div class="cal-doc-info">
                                                <span class="cal-doc-title"><?= htmlspecialchars($yearKey) ?> (Even)</span>
                                                <span class="cal-doc-meta">
                                                    <span><?= htmlspecialchars($evenSize) ?></span>
                                                    <span>•</span>
                                                    <span>Verified GTU</span>
                                                </span>
                                            </div>
                                            <span class="cal-doc-action-tag">
                                                <i class="fas fa-arrow-down"></i>
                                            </span>
                                        </a>
                                    <?php else: ?>
                                        <span class="cal-empty-state-cell">
                                            <i class="fas fa-clock"></i> Schedule Awaited / In Preparation
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile View: Clean Responsive Cards (< 820px) -->
            <div class="cal-mobile-list" id="calMobileList">
                <?php foreach ($groupedYears as $yearKey => $yearData): 
                    $oddDoc = $yearData['Odd'];
                    $evenDoc = $yearData['Even'];
                    $isCurrentYear = ($yearKey === $latestYear);
                ?>
                    <div class="cal-mobile-card cal-row" data-year="<?= htmlspecialchars(strtolower($yearKey)) ?>" data-has-odd="<?= $oddDoc ? '1' : '0' ?>" data-has-even="<?= $evenDoc ? '1' : '0' ?>">
                        <div class="cal-mobile-header">
                            <span class="cal-mobile-year"><?= htmlspecialchars($yearKey) ?></span>
                            <?php if ($isCurrentYear): ?>
                                <span class="cal-tag-current">Current Session</span>
                            <?php endif; ?>
                        </div>

                        <!-- Odd Section -->
                        <div class="cal-mobile-section">
                            <span class="cal-mobile-sec-label">Odd Semester (Sem 1, 3, 5, 7)</span>
                            <?php if ($oddDoc && !empty($oddDoc['file_path'])): 
                                $oddUrl = $root_path . ltrim($oddDoc['file_path'], '/');
                            ?>
                                <a href="<?= htmlspecialchars($oddUrl) ?>" target="_blank" class="cal-doc-item">
                                    <div class="cal-doc-icon"><i class="fas fa-file-pdf"></i></div>
                                    <div class="cal-doc-info">
                                        <span class="cal-doc-title"><?= htmlspecialchars($yearKey) ?> (Odd)</span>
                                        <span class="cal-doc-meta"><?= htmlspecialchars($oddDoc['file_size'] ?? 'PDF') ?> • GTU Approved</span>
                                    </div>
                                    <span class="cal-doc-action-tag"><i class="fas fa-download"></i></span>
                                </a>
                            <?php else: ?>
                                <span class="cal-empty-state-cell"><i class="fas fa-clock"></i> Schedule Awaited</span>
                            <?php endif; ?>
                        </div>

                        <!-- Even Section -->
                        <div class="cal-mobile-section">
                            <span class="cal-mobile-sec-label">Even Semester (Sem 2, 4, 6, 8)</span>
                            <?php if ($evenDoc && !empty($evenDoc['file_path'])): 
                                $evenUrl = $root_path . ltrim($evenDoc['file_path'], '/');
                            ?>
                                <a href="<?= htmlspecialchars($evenUrl) ?>" target="_blank" class="cal-doc-item">
                                    <div class="cal-doc-icon"><i class="fas fa-file-pdf"></i></div>
                                    <div class="cal-doc-info">
                                        <span class="cal-doc-title"><?= htmlspecialchars($yearKey) ?> (Even)</span>
                                        <span class="cal-doc-meta"><?= htmlspecialchars($evenDoc['file_size'] ?? 'PDF') ?> • GTU Approved</span>
                                    </div>
                                    <span class="cal-doc-action-tag"><i class="fas fa-download"></i></span>
                                </a>
                            <?php else: ?>
                                <span class="cal-empty-state-cell"><i class="fas fa-clock"></i> Schedule Awaited</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('calSearchInput');
    const filterPills = document.querySelectorAll('.cal-pill-btn');
    const rows = document.querySelectorAll('.cal-row');

    let currentFilter = 'all';

    function applyFilter() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';

        rows.forEach(function (row) {
            const year = row.getAttribute('data-year') || '';
            const hasOdd = row.getAttribute('data-has-odd') === '1';
            const hasEven = row.getAttribute('data-has-even') === '1';

            // Check search text
            const matchesQuery = !query || year.includes(query);

            // Check pill filter
            let matchesFilter = true;
            if (currentFilter === 'odd') {
                matchesFilter = hasOdd;
            } else if (currentFilter === 'even') {
                matchesFilter = hasEven;
            }

            if (matchesQuery && matchesFilter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyFilter);
    }

    filterPills.forEach(function (btn) {
        btn.addEventListener('click', function () {
            filterPills.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter') || 'all';
            applyFilter();
        });
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
