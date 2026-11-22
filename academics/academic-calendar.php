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
        $stmt = $pdo->query("SELECT * FROM academic_calendars WHERE is_active = 1 ORDER BY academic_year DESC, semester_type ASC, id DESC");
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
            'Even' => null
        ];
    }
    $groupedYears[$yr][$sem] = $item;
}

// Calculate Metrics
$totalYearsCount = count($groupedYears);
$latestYear = array_key_first($groupedYears) ?? '2026-27';
?>

<div class="dept-page" id="mainContent">

    <div class="dept-container">
        <!-- Department Style Clean Hero -->
        <div class="dept-about-hero act-reveal">
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
                <div class="dept-stat-item act-reveal">
                    <span class="dept-stat-num"><?= htmlspecialchars($latestYear) ?></span>
                    <span class="dept-stat-label">CURRENT ACADEMIC SESSION</span>
                </div>
                <div class="dept-stat-item act-reveal">
                    <span class="dept-stat-num"><?= $totalYearsCount ?></span>
                    <span class="dept-stat-label">ARCHIVED SESSIONS</span>
                </div>
                <div class="dept-stat-item act-reveal">
                    <span class="dept-stat-num">ODD &amp; EVEN</span>
                    <span class="dept-stat-label">SEMESTER TERM SCHEDULES</span>
                </div>
                <div class="dept-stat-item act-reveal">
                    <span class="dept-stat-num">GTU</span>
                    <span class="dept-stat-label">REGULATORY AFFILIATION</span>
                </div>
            </div>
        </div>

        <!-- Desktop Clean Data Table -->
        <div class="dept-table-wrap act-reveal">
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
                            <tr class="cal-row" data-year="<?= htmlspecialchars(strtolower($yearKey)) ?>">
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
                                        $oddLabel = htmlspecialchars($oddDoc['title'] ?? ($yearKey . ' (Odd)'));
                                    ?>
                                        <a href="<?= htmlspecialchars($oddUrl) ?>" target="_blank" class="cal-doc-link" title="Download <?= $oddLabel ?>">
                                            <i class="fas fa-file-pdf cal-pdf-ico"></i>
                                            <span><?= htmlspecialchars($yearKey) ?> (Odd)</span>
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
                                        $evenLabel = htmlspecialchars($evenDoc['title'] ?? ($yearKey . ' (Even)'));
                                    ?>
                                        <a href="<?= htmlspecialchars($evenUrl) ?>" target="_blank" class="cal-doc-link" title="Download <?= $evenLabel ?>">
                                            <i class="fas fa-file-pdf cal-pdf-ico"></i>
                                            <span><?= htmlspecialchars($yearKey) ?> (Even)</span>
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
                    <div class="cal-mobile-card cal-row act-reveal" data-year="<?= htmlspecialchars(strtolower($yearKey)) ?>">
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
                                    <i class="fas fa-download cal-download-arrow"></i>
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
                                    <i class="fas fa-download cal-download-arrow"></i>
                                </a>
                            <?php else: ?>
                                <span class="cal-awaited-cell"><i class="far fa-clock"></i> Schedule Awaited</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const revealSelectors = [
        '.dept-about-hero',
        '.dept-stat-item',
        '.dept-table-wrap',
        '.cal-mobile-card'
    ];

    let revealObserver = null;
    if ('IntersectionObserver' in window) {
        revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            root: null,
            rootMargin: '0px 0px 20px 0px',
            threshold: 0.02
        });
    }

    function setupRevealElements(container = document) {
        if (!container) return;
        const elements = container.querySelectorAll(revealSelectors.join(', '));
        const viewportHeight = window.innerHeight || document.documentElement.clientHeight;

        elements.forEach(el => {
            if (!el.classList.contains('act-reveal')) {
                el.classList.add('act-reveal');
            }
            const rect = el.getBoundingClientRect();
            if (rect.top < viewportHeight - 30 && rect.bottom > 0) {
                setTimeout(() => el.classList.add('is-revealed'), 80);
            } else if (revealObserver) {
                revealObserver.observe(el);
            } else {
                el.classList.add('is-revealed');
            }
        });
    }

    setupRevealElements(document);
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
