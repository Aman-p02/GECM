<?php
$page_title = "Student Enrollment Summary | Government Engineering College, Modasa";
$page_description = "Official GTU-affiliated Student Enrollment Summary and branch-wise approved enrollment registers for Government Engineering College Modasa.";
$active_page = 'enrollment-details';
$extra_css = 'css/enrollment-details.css';

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

// Helper function to map branch icons
function getBranchIcon($branchName, $programType = 'UG') {
    $name = strtolower($branchName);
    if ($programType === 'PG') {
        return 'fa-graduation-cap';
    }
    if (strpos($name, 'computer') !== false) {
        return 'fa-laptop-code';
    }
    if (strpos($name, 'information') !== false || strpos($name, 'it') !== false) {
        return 'fa-network-wired';
    }
    if (strpos($name, 'mechanical') !== false) {
        return 'fa-cogs';
    }
    if (strpos($name, 'civil') !== false) {
        return 'fa-building';
    }
    if (strpos($name, 'electrical') !== false) {
        return 'fa-bolt';
    }
    if (strpos($name, 'electronic') !== false || strpos($name, 'ec') !== false) {
        return 'fa-microchip';
    }
    if (strpos($name, 'automobile') !== false) {
        return 'fa-car';
    }
    return 'fa-book-reader';
}

// Fetch active enrollment records grouped by Academic Year
$enrollmentGroups = [];

if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM student_enrollments WHERE is_active = 1 ORDER BY academic_year DESC, display_order ASC, id ASC");
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $enrollmentGroups[$row['academic_year']][] = $row;
        }
    } catch (Exception $e) {
        $enrollmentGroups = [];
    }
}

// Resilient Fallback if database is offline or empty
if (empty($enrollmentGroups)) {
    $defaultYears = [
        '2025-26' => [
            ['Automobile Engineering', 'UG', '', ''],
            ['Civil Engineering', 'UG', '', ''],
            ['Computer Engineering', 'UG', '', ''],
            ['Electrical Engineering', 'UG', '', ''],
            ['Electronics and Communication Engineering', 'UG', '', ''],
            ['Information Technology', 'UG', '', ''],
            ['Mechanical Engineering', 'UG', '', ''],
            ['Computer Engineering (PG)', 'PG', '', '']
        ],
        '2024-25' => [
            ['Automobile Engineering', 'UG', '', ''],
            ['Civil Engineering', 'UG', '', ''],
            ['Computer Engineering', 'UG', '', ''],
            ['Electrical Engineering', 'UG', '', ''],
            ['Electronics and Communication Engineering', 'UG', '', ''],
            ['Information Technology', 'UG', '', ''],
            ['Mechanical Engineering', 'UG', '', ''],
            ['Civil Engineering (PG)', 'PG', '', ''],
            ['Computer Engineering (PG)', 'PG', '', '']
        ],
        '2023-24' => [
            ['Automobile Engineering', 'UG', '', ''],
            ['Civil Engineering', 'UG', '', ''],
            ['Computer Engineering', 'UG', '', ''],
            ['Electrical Engineering', 'UG', '', ''],
            ['Electronics and Communication Engineering', 'UG', '', ''],
            ['Information Technology', 'UG', '', ''],
            ['Mechanical Engineering', 'UG', '', ''],
            ['Civil Engineering (PG)', 'PG', '', ''],
            ['Computer Engineering (PG)', 'PG', '', '']
        ],
        '2022-23' => [
            ['Automobile Engineering', 'UG', '', ''],
            ['Civil Engineering', 'UG', '', ''],
            ['Computer Engineering', 'UG', '', ''],
            ['Electrical Engineering', 'UG', '', ''],
            ['Electronics and Communication Engineering', 'UG', '', ''],
            ['Information Technology', 'UG', '', ''],
            ['Mechanical Engineering', 'UG', '', ''],
            ['Civil Engineering (PG)', 'PG', '', ''],
            ['Computer Engineering (PG)', 'PG', '', '']
        ],
        '2021-22' => [
            ['Automobile Engineering', 'UG', '', ''],
            ['Civil Engineering', 'UG', '', ''],
            ['Computer Engineering', 'UG', '', ''],
            ['Electrical Engineering', 'UG', '', ''],
            ['Electronics and Communication Engineering', 'UG', '', ''],
            ['Information Technology', 'UG', '', ''],
            ['Mechanical Engineering', 'UG', '', ''],
            ['Civil Engineering (PG)', 'PG', '', ''],
            ['Computer Engineering (PG)', 'PG', '', '']
        ]
    ];

    foreach ($defaultYears as $yr => $branches) {
        foreach ($branches as $b) {
            $enrollmentGroups[$yr][] = [
                'academic_year' => $yr,
                'branch_name'   => $b[0],
                'program_type'  => $b[1],
                'file_path'     => $b[2],
                'file_size'     => $b[3],
                'title'         => $b[0] . ' Enrollment List (' . $yr . ')'
            ];
        }
    }
}
?>

<div class="enrollment-page" id="mainContent">

    <!-- Hero Section -->
    <header class="enrollment-hero">
        <div class="enrollment-hero-inner">
            <span class="enrollment-kicker">
                <i class="fas fa-user-graduate"></i> Student Corner
            </span>
            <h1 class="enrollment-title">Student Enrollment Summary</h1>
            <p class="enrollment-lead">
                Year-wise approved enrollment registers and student intake documentation across all undergraduate (B.E.) and postgraduate (M.E.) branches affiliated with Gujarat Technological University (GTU).
            </p>
        </div>
    </header>

    <!-- Quick Year Filters & Search Bar -->
    <div class="enrollment-filter-bar">
        <div class="enrollment-filter-card">
            <div class="enrollment-pills" id="yearPillFilters" role="tablist" aria-label="Enrollment Academic Years">
                <button type="button" class="enr-pill-btn is-active" data-year="all" role="tab" aria-selected="true">
                    <i class="fas fa-layer-group"></i> All Academic Years
                </button>
                <?php foreach (array_keys($enrollmentGroups) as $yrKey): ?>
                    <button type="button" class="enr-pill-btn" data-year="<?= htmlspecialchars($yrKey) ?>" role="tab" aria-selected="false">
                        <i class="far fa-calendar-alt"></i> <?= htmlspecialchars($yrKey) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="enr-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="branchSearchInput" class="enr-search-input" placeholder="Search branch or year..." aria-label="Search branch or enrollment year">
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <main class="enrollment-container" id="enrollmentSectionsWrap">

        <?php foreach ($enrollmentGroups as $academicYear => $items): ?>
            <section class="enrollment-year-block" data-year-section="<?= htmlspecialchars($academicYear) ?>">
                <!-- Year Header -->
                <div class="enrollment-year-header">
                    <h2 class="enrollment-year-title">
                        <i class="fas fa-calendar-check"></i>
                        <span>Enrollment Year <?= htmlspecialchars($academicYear) ?></span>
                    </h2>
                    <span class="enrollment-year-badge">
                        <?= count($items) ?> Branches Registered
                    </span>
                </div>

                <!-- Branch Grid -->
                <div class="enrollment-grid">
                    <?php foreach ($items as $item): ?>
                        <?php
                        $iconClass = getBranchIcon($item['branch_name'], $item['program_type']);
                        $hasRealPdf = !empty($item['file_path']) && file_exists(__DIR__ . '/' . $item['file_path']);
                        $linkHref = $hasRealPdf ? htmlspecialchars($root_path . ltrim($item['file_path'], '/')) : 'javascript:void(0);';
                        $targetAttr = $hasRealPdf ? 'target="_blank" rel="noopener noreferrer"' : '';
                        ?>
                        <a href="<?= $linkHref ?>"
                           <?= $targetAttr ?>
                           class="enr-branch-card <?= !$hasRealPdf ? 'is-static' : '' ?>"
                           data-branch-name="<?= strtolower(htmlspecialchars($item['branch_name'] . ' ' . $academicYear)) ?>"
                           aria-label="<?= htmlspecialchars($item['branch_name']) ?> Enrollment Document">
                            <div class="enr-card-top">
                                <div class="enr-card-icon">
                                    <i class="fas <?= $iconClass ?>"></i>
                                </div>
                                <div class="enr-card-meta">
                                    <h3 class="enr-branch-name"><?= htmlspecialchars($item['branch_name']) ?></h3>
                                </div>
                            </div>
                            <div class="enr-card-footer">
                                <span class="enr-pdf-label">
                                    <i class="fas fa-file-pdf"></i>
                                    <span><?= $hasRealPdf ? 'View PDF' : 'PDF Document' ?></span>
                                </span>
                                <?php if ($hasRealPdf): ?>
                                    <i class="fas fa-external-link-alt enr-open-icon"></i>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>

        <!-- Institutional Note -->
        <div class="enrollment-info-note">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Official University Verification Note:</strong>
                All student enrollment lists published on this portal are approved by the Gujarat Technological University (GTU) and the Commissionerate of Technical Education (CTE), Government of Gujarat. In case of any clarification or discrepancy, students and verification authorities may contact the <strong>Student Section</strong> at the institute administrative block.
            </div>
        </div>

    </main>

</div>

<!-- Client-side Interactive Filter Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pillButtons = document.querySelectorAll('#yearPillFilters .enr-pill-btn');
    const yearBlocks = document.querySelectorAll('.enrollment-year-block');
    const searchInput = document.getElementById('branchSearchInput');

    let activeYear = 'all';
    let searchQuery = '';

    function applyFilters() {
        yearBlocks.forEach(function (block) {
            const blockYear = block.getAttribute('data-year-section');
            const yearMatches = (activeYear === 'all' || activeYear === blockYear);

            if (!yearMatches) {
                block.style.display = 'none';
                return;
            }

            const cards = block.querySelectorAll('.enr-branch-card');
            let visibleInBlock = 0;

            cards.forEach(function (card) {
                const text = card.getAttribute('data-branch-name') || '';
                if (!searchQuery || text.indexOf(searchQuery) !== -1) {
                    card.style.display = 'flex';
                    visibleInBlock++;
                } else {
                    card.style.display = 'none';
                }
            });

            block.style.display = (visibleInBlock > 0) ? 'block' : 'none';
        });
    }

    // Pill click handler
    pillButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            pillButtons.forEach(b => b.classList.remove('is-active'));
            this.classList.add('is-active');
            activeYear = this.getAttribute('data-year');
            applyFilters();
        });
    });

    // Real-time search handler
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = this.value.toLowerCase().trim();
            applyFilters();
        });
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
