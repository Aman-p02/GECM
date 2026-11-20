<?php
/**
 * GEC MODASA - ACADEMIC CALENDAR
 * Official Institutional Semester Term Schedules & GTU Circulars
 * Follows GECM Institutional Department Design System
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

<div class="dept-page" id="mainContent">

    <div class="dept-container">
        <!-- Breadcrumbs -->
        <nav class="dept-breadcrumbs" aria-label="Breadcrumb">
            <a href="<?= $root_path ?>">Home</a>
            <span class="sep"><i class="fas fa-chevron-right"></i></span>
            <a href="<?= $root_path ?>academics/courses">Academics</a>
            <span class="sep"><i class="fas fa-chevron-right"></i></span>
            <span class="current">Academic Calendar</span>
        </nav>

        <!-- Department Style Clean Hero -->
        <div class="dept-about-hero">
            <div class="dept-hero-grid">
                <div class="dept-hero-text">
                    <span class="dept-kicker">ACADEMIC PROGRAMMES &amp; SCHEDULE</span>
                    <h1 class="dept-heading">Academic Calendar</h1>
                    <p class="dept-tagline">
                        Official institutional semester term schedules, instructional commencement dates, examination windows, and Gujarat Technological University (GTU) academic regulations.
                    </p>
                </div>
            </div>

            <!-- Key metrics counter strip -->
            <div class="dept-stats-strip">
                <div class="dept-stat-item">
                    <span class="dept-stat-num"><?= htmlspecialchars($latestYear) ?></span>
                    <span class="dept-stat-label">CURRENT ACADEMIC SESSION</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num"><?= $totalYearsCount ?></span>
                    <span class="dept-stat-label">ARCHIVED SESSIONS</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">ODD &amp; EVEN</span>
                    <span class="dept-stat-label">SEMESTER TERM SCHEDULES</span>
                </div>
                <div class="dept-stat-item">
                    <span class="dept-stat-num">GTU</span>
                    <span class="dept-stat-label">REGULATORY AFFILIATION</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Sub-Navigation Bar matching Department Tabs -->
    <nav class="dept-subnav-bar" id="calSubNav" aria-label="Academic Calendar Navigation">
        <div class="dept-container">
            <div class="dept-subnav-wrap">
                <ul class="dept-subnav-list" role="tablist">
                    <li class="dept-subnav-item active">
                        <button type="button" class="dept-subnav-link active" data-filter="all" role="tab" aria-selected="true">
                            All Sessions (<?= $totalYearsCount ?>)
                        </button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-filter="odd" role="tab" aria-selected="false">
                            Odd Semester (Sem 1, 3, 5, 7)
                        </button>
                    </li>
                    <li class="dept-subnav-item">
                        <button type="button" class="dept-subnav-link" data-filter="even" role="tab" aria-selected="false">
                            Even Semester (Sem 2, 4, 6, 8)
                        </button>
                    </li>
                </ul>

                <div class="cal-search-wrap">
                    <i class="fas fa-search cal-search-icon"></i>
                    <input type="text" id="calSearchInput" class="cal-search-input" placeholder="Search academic year (e.g. 2026-27)..." aria-label="Search Academic Calendar">
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="dept-main-content">
        <div class="dept-container">

            <div class="dept-section-header">
                <span class="dept-section-kicker">INSTITUTIONAL TIMELINE</span>
                <h2>Official Semester Schedules</h2>
                <p>Term dates, teaching phases, internal assessment periods, end-semester university examinations, and non-instructional days as sanctioned by Gujarat Technological University.</p>
            </div>

            <!-- Institutional Governance Notice -->
            <div class="cal-notice-box">
                <i class="fas fa-info-circle cal-notice-ico"></i>
                <p class="cal-notice-text">
                    <strong>Academic Governance Directive:</strong> The Academic Calendars published below are structured strictly in conformity with directives from Gujarat Technological University (GTU), Ahmedabad, and the Directorate of Technical Education (DTE), Gandhinagar. Official revisions and circular amendments are updated by the institutional administration.
                </p>
            </div>

            <!-- Desktop Clean Data Table -->
            <div class="dept-table-wrap">
                <table class="dept-clean-table" id="calMainTable">
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
                                    <div class="cal-year-title">
                                        <span><?= htmlspecialchars($yearKey) ?></span>
                                        <?php if ($isCurrentYear): ?>
                                            <span class="cal-tag-current">CURRENT</span>
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
                                        <a href="<?= htmlspecialchars($oddUrl) ?>" target="_blank" class="cal-doc-link" title="Download <?= $oddLabel ?>">
                                            <i class="fas fa-file-pdf cal-pdf-ico"></i>
                                            <span><?= htmlspecialchars($yearKey) ?> (Odd)</span>
                                            <span class="cal-doc-size"><?= htmlspecialchars($oddSize) ?></span>
                                            <i class="fas fa-arrow-down cal-download-arrow"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="cal-awaited-cell">
                                            <i class="far fa-clock"></i> Schedule Awaited
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
                                        <a href="<?= htmlspecialchars($evenUrl) ?>" target="_blank" class="cal-doc-link" title="Download <?= $evenLabel ?>">
                                            <i class="fas fa-file-pdf cal-pdf-ico"></i>
                                            <span><?= htmlspecialchars($yearKey) ?> (Even)</span>
                                            <span class="cal-doc-size"><?= htmlspecialchars($evenSize) ?></span>
                                            <i class="fas fa-arrow-down cal-download-arrow"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="cal-awaited-cell">
                                            <i class="far fa-clock"></i> Schedule Awaited
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Mobile View: Clean Institutional Cards (< 820px) -->
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
                                <span class="cal-tag-current">CURRENT SESSION</span>
                            <?php endif; ?>
                        </div>

                        <!-- Odd Semester Item -->
                        <div class="cal-mobile-group">
                            <span class="cal-mobile-label">Odd Semester (Sem 1, 3, 5, 7)</span>
                            <?php if ($oddDoc && !empty($oddDoc['file_path'])): 
                                $oddUrl = $root_path . ltrim($oddDoc['file_path'], '/');
                            ?>
                                <a href="<?= htmlspecialchars($oddUrl) ?>" target="_blank" class="cal-doc-link">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-file-pdf cal-pdf-ico"></i>
                                        <span><?= htmlspecialchars($yearKey) ?> (Odd)</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span class="cal-doc-size"><?= htmlspecialchars($oddDoc['file_size'] ?? 'PDF') ?></span>
                                        <i class="fas fa-download cal-download-arrow"></i>
                                    </div>
                                </a>
                            <?php else: ?>
                                <span class="cal-awaited-cell"><i class="far fa-clock"></i> Schedule Awaited</span>
                            <?php endif; ?>
                        </div>

                        <!-- Even Semester Item -->
                        <div class="cal-mobile-group">
                            <span class="cal-mobile-label">Even Semester (Sem 2, 4, 6, 8)</span>
                            <?php if ($evenDoc && !empty($evenDoc['file_path'])): 
                                $evenUrl = $root_path . ltrim($evenDoc['file_path'], '/');
                            ?>
                                <a href="<?= htmlspecialchars($evenUrl) ?>" target="_blank" class="cal-doc-link">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-file-pdf cal-pdf-ico"></i>
                                        <span><?= htmlspecialchars($yearKey) ?> (Even)</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span class="cal-doc-size"><?= htmlspecialchars($evenDoc['file_size'] ?? 'PDF') ?></span>
                                        <i class="fas fa-download cal-download-arrow"></i>
                                    </div>
                                </a>
                            <?php else: ?>
                                <span class="cal-awaited-cell"><i class="far fa-clock"></i> Schedule Awaited</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- No Results Message -->
            <div id="calNoResults" class="cal-empty-search" style="display: none;">
                <i class="fas fa-search"></i>
                <p>No academic calendars matched your search criteria.</p>
            </div>

        </div>
    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('calSearchInput');
    const filterTabs = document.querySelectorAll('.dept-subnav-link');
    const filterItems = document.querySelectorAll('.dept-subnav-item');
    const rows = document.querySelectorAll('.cal-row');
    const noResults = document.getElementById('calNoResults');

    let currentFilter = 'all';

    function applyFilter() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        let visibleCount = 0;

        rows.forEach(function (row) {
            const year = row.getAttribute('data-year') || '';
            const hasOdd = row.getAttribute('data-has-odd') === '1';
            const hasEven = row.getAttribute('data-has-even') === '1';

            // Check search text
            const matchesQuery = !query || year.includes(query);

            // Check pill / subnav tab filter
            let matchesFilter = true;
            if (currentFilter === 'odd') {
                matchesFilter = hasOdd;
            } else if (currentFilter === 'even') {
                matchesFilter = hasEven;
            }

            if (matchesQuery && matchesFilter) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (noResults) {
            noResults.style.display = (visibleCount === 0) ? 'block' : 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyFilter);
    }

    filterTabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            filterItems.forEach(item => item.classList.remove('active'));
            filterTabs.forEach(t => {
                t.classList.remove('active');
                t.setAttribute('aria-selected', 'false');
            });

            this.classList.add('active');
            this.setAttribute('aria-selected', 'true');
            if (this.parentElement) {
                this.parentElement.classList.add('active');
            }

            currentFilter = this.getAttribute('data-filter') || 'all';
            applyFilter();
        });
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
