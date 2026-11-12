<?php
$page_title = "Faculty Activities & Professional Development | Government Engineering College, Modasa";
$active_page = "faculty_activities";
$root_path = "";
$extra_css = "css/activities-hub.css";

require_once __DIR__ . '/includes/db.php';
$pdo = getDBConnection();

$deptFilterList = [
    'CE'    => 'Computer Engineering',
    'IT'    => 'Information Technology',
    'ME'    => 'Mechanical Engineering',
    'CIVIL' => 'Civil Engineering',
    'EE'    => 'Electrical Engineering',
    'EC'    => 'Electronics & Communication',
    'AE'    => 'Automobile Engineering',
    'AM'    => 'Applied Mechanics',
    'SH'    => 'Science & Humanities'
];

$selectedCat = strtolower(trim($_GET['cat'] ?? 'conferences'));
$selectedDept = strtoupper(trim($_GET['dept'] ?? 'ALL'));
$selectedYear = trim($_GET['year'] ?? 'ALL');

$activities = [];
$availableYears = [];

if ($pdo) {
    try {
        $deptRows = $pdo->query("SELECT code, name FROM departments ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($deptRows)) {
            $deptFilterList = [];
            foreach ($deptRows as $row) {
                $deptFilterList[strtoupper(trim($row['code']))] = trim($row['name']);
            }
        }

        $stmt = $pdo->query("
            SELECT * FROM faculty_activities 
            WHERE is_active = 1 
            ORDER BY display_order ASC, event_date DESC, id DESC
        ");
        $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($activities as $act) {
            $yr = !empty($act['year']) ? $act['year'] : (!empty($act['event_date']) ? date('Y', strtotime($act['event_date'])) : '');
            if (!empty($yr) && !in_array($yr, $availableYears)) {
                $availableYears[] = $yr;
            }
        }
        rsort($availableYears);
    } catch (Exception $e) {
        error_log("Faculty Activities Error: " . $e->getMessage());
    }
}

// Category counts
$catCounts = [
    'conferences'     => 0,
    'trainings'       => 0,
    'expert_lectures' => 0
];

foreach ($activities as $act) {
    $c = strtolower(trim($act['category'] ?? ''));
    if (isset($catCounts[$c])) {
        $catCounts[$c]++;
    }
}

$catTitles = [
    'conferences'     => 'Conferences Attended / Chaired by Faculty',
    'trainings'       => 'Trainings & STTP Attended by Faculty',
    'expert_lectures' => 'Expert Lectures Delivered by Faculty',
    'all'             => 'All Faculty Activities & Engagements'
];

$activeTableTitle = $catTitles[$selectedCat] ?? $catTitles['conferences'];

require_once __DIR__ . '/includes/header.php';
?>

<div class="act-hub-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="act-hero">
        <div class="act-hero-inner">
            <span class="act-kicker">ACADEMIC &amp; RESEARCH LEADERSHIP</span>
            <h1 class="act-heading" style="margin-bottom: 0;">Faculty Activities &amp; Development</h1>
        </div>
    </header>

    <!-- Category Segments Bar (Navbar like Department Activities) -->
    <section class="dept-pills-section" aria-label="Faculty Activity Categories">
        <div class="dept-pills-inner">
            <div class="dept-pills-scroll" id="catPillsContainer" role="tablist">
                <button type="button" 
                        role="tab"
                        aria-selected="<?= ($selectedCat === 'conferences') ? 'true' : 'false' ?>"
                        class="dept-pill-btn <?= ($selectedCat === 'conferences') ? 'is-active' : '' ?>" 
                        data-cat="conferences">
                    <span>Conferences</span>
                    <span class="dept-pill-count"><?= $catCounts['conferences'] ?></span>
                </button>

                <button type="button" 
                        role="tab"
                        aria-selected="<?= ($selectedCat === 'trainings') ? 'true' : 'false' ?>"
                        class="dept-pill-btn <?= ($selectedCat === 'trainings') ? 'is-active' : '' ?>" 
                        data-cat="trainings">
                    <span>Trainings &amp; STTP</span>
                    <span class="dept-pill-count"><?= $catCounts['trainings'] ?></span>
                </button>

                <button type="button" 
                        role="tab"
                        aria-selected="<?= ($selectedCat === 'expert_lectures') ? 'true' : 'false' ?>"
                        class="dept-pill-btn <?= ($selectedCat === 'expert_lectures') ? 'is-active' : '' ?>" 
                        data-cat="expert_lectures">
                    <span>Expert Lectures</span>
                    <span class="dept-pill-count"><?= $catCounts['expert_lectures'] ?></span>
                </button>

                <button type="button" 
                        role="tab"
                        aria-selected="<?= ($selectedCat === 'all') ? 'true' : 'false' ?>"
                        class="dept-pill-btn <?= ($selectedCat === 'all') ? 'is-active' : '' ?>" 
                        data-cat="all">
                    <span>All Activities</span>
                    <span class="dept-pill-count"><?= count($activities) ?></span>
                </button>
            </div>
        </div>
    </section>

    <!-- Secondary Action Toolbar -->
    <div class="act-toolbar-strip">
        <div class="act-toolbar-inner">
            <div class="act-search-pill">
                <i class="fas fa-search act-search-icon" aria-hidden="true"></i>
                <input type="text" id="searchInput" class="act-search-field" placeholder="Search by faculty name, topic, or institution..." aria-label="Search faculty activities">
                <button type="button" id="searchClearBtn" class="act-search-clear" aria-label="Clear search" style="display: none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="act-toolbar-meta">
                <!-- Department Dropdown Pill -->
                <div class="act-year-dropdown-wrap">
                    <span class="act-year-label">Dept:</span>
                    <select id="deptSelect" class="act-year-select" aria-label="Filter by Department">
                        <option value="ALL" <?= ($selectedDept === 'ALL') ? 'selected' : '' ?>>All Depts</option>
                        <?php foreach ($deptFilterList as $code => $name): ?>
                            <option value="<?= $code ?>" <?= ($selectedDept === $code) ? 'selected' : '' ?>>
                                <?= $code ?> - <?= htmlspecialchars($name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-chevron-down act-year-icon"></i>
                </div>

                <!-- Year Dropdown Pill -->
                <div class="act-year-dropdown-wrap">
                    <span class="act-year-label">Year:</span>
                    <select id="yearSelect" class="act-year-select" aria-label="Filter by Year">
                        <option value="ALL" <?= ($selectedYear === 'ALL') ? 'selected' : '' ?>>All Years</option>
                        <?php foreach ($availableYears as $yr): ?>
                            <option value="<?= $yr ?>" <?= ($selectedYear == $yr) ? 'selected' : '' ?>>
                                <?= $yr ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-chevron-down act-year-icon"></i>
                </div>

                <div class="act-count-pill" id="resultsCount">
                    Showing <strong><?= count($activities) ?></strong> records
                </div>

                <button type="button" id="resetFiltersBtn" class="act-reset-link" style="display: none;">
                    Reset filters
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content Container: Institutional Data Table -->
    <main class="act-container" style="margin-top: 24px;">
        <div class="fac-table-card">
            <div class="fac-table-header-strip">
                <h2 class="fac-table-title" id="dynamicTableTitle">
                    <i class="fas fa-bookmark" aria-hidden="true"></i>
                    <span><?= htmlspecialchars($activeTableTitle) ?></span>
                </h2>
            </div>

            <div class="fac-table-responsive">
                <table class="fac-table" id="facultyTable">
                    <thead>
                        <tr>
                            <th class="fac-sr-col">Sr. No.</th>
                            <th>Activity / Engagement Details</th>
                            <th style="width: 140px;">Department</th>
                            <th style="width: 110px;">Date / Year</th>
                        </tr>
                    </thead>
                    <tbody id="facultyTableBody">
                        <?php 
                        $counter = 1;
                        foreach ($activities as $act): 
                            $cat = strtolower(trim($act['category'] ?? ''));
                            $dept = strtoupper(trim($act['dept_code'] ?? ''));
                            $yr = !empty($act['year']) ? $act['year'] : (!empty($act['event_date']) ? date('Y', strtotime($act['event_date'])) : 'N/A');
                            $actDateFormatted = !empty($act['event_date']) ? date('M d, Y', strtotime($act['event_date'])) : $yr;
                            $deptName = $deptFilterList[$dept] ?? $dept;
                        ?>
                            <tr class="fac-table-row" 
                                data-cat="<?= htmlspecialchars($cat) ?>"
                                data-dept="<?= htmlspecialchars($dept) ?>"
                                data-year="<?= htmlspecialchars($yr) ?>"
                                data-faculty="<?= htmlspecialchars(strtolower($act['faculty_name'] ?? '')) ?>"
                                data-desc="<?= htmlspecialchars(strtolower($act['description'] ?? '')) ?>">
                                <td class="fac-sr-col">
                                    <span class="fac-sr-badge" data-counter="1"><?= $counter++ ?></span>
                                </td>
                                <td>
                                    <span class="fac-member-name"><?= htmlspecialchars($act['faculty_name'] ?? '') ?> <?= !empty($act['designation']) ? ' &bull; <small style="color:#64748b; font-weight:500;">' . htmlspecialchars($act['designation']) . '</small>' : '' ?></span>
                                    <div class="fac-row-desc"><?= nl2br(htmlspecialchars($act['description'] ?? '')) ?></div>
                                </td>
                                <td>
                                    <span class="fac-dept-tag"><?= htmlspecialchars($dept) ?></span>
                                </td>
                                <td>
                                    <span class="fac-year-tag"><?= htmlspecialchars($yr) ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Empty State Container -->
            <div class="act-empty-state" id="emptyState" style="display: none; padding: 48px 24px;">
                <i class="fas fa-clipboard-list act-empty-icon"></i>
                <h4 class="act-empty-title">No Records Found</h4>
                <p class="act-empty-desc">No faculty activities match your selected category, department, year, or search criteria.</p>
                <button type="button" class="btn btn-primary" id="emptyResetBtn" style="margin-top: 14px; padding: 7px 20px; font-size: 0.85rem; border-radius: 9999px;">
                    <i class="fas fa-undo"></i> Show All Activities
                </button>
            </div>
        </div>
    </main>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const pillButtons = Array.from(document.querySelectorAll("#catPillsContainer .dept-pill-btn"));
    const deptSelect = document.getElementById("deptSelect");
    const yearSelect = document.getElementById("yearSelect");
    const searchInput = document.getElementById("searchInput");
    const searchClearBtn = document.getElementById("searchClearBtn");
    const resetFiltersBtn = document.getElementById("resetFiltersBtn");
    const emptyResetBtn = document.getElementById("emptyResetBtn");
    const rows = Array.from(document.querySelectorAll("#facultyTableBody .fac-table-row"));
    const emptyState = document.getElementById("emptyState");
    const resultsCount = document.getElementById("resultsCount");
    const dynamicTableTitle = document.getElementById("dynamicTableTitle");
    const facultyTable = document.getElementById("facultyTable");

    const categoryTitles = {
        conferences: "Conferences Attended / Chaired by Faculty",
        trainings: "Trainings & STTP Attended by Faculty",
        expert_lectures: "Expert Lectures Delivered by Faculty",
        all: "All Faculty Activities & Engagements"
    };

    let currentCat = "<?= htmlspecialchars($selectedCat) ?>";
    if (!currentCat) currentCat = "conferences";

    function filterTable() {
        const selectedDept = deptSelect.value.toUpperCase();
        const selectedYear = yearSelect.value;
        const searchQuery = searchInput.value.trim().toLowerCase();

        // Toggle clear search button
        if (searchClearBtn) {
            searchClearBtn.style.display = searchQuery ? "flex" : "none";
        }

        // Toggle reset filters button
        const isFiltered = (currentCat !== "conferences" || selectedDept !== "ALL" || selectedYear !== "ALL" || searchQuery.length > 0);
        if (resetFiltersBtn) {
            resetFiltersBtn.style.display = isFiltered ? "inline-block" : "none";
        }

        // Update table title according to category
        if (dynamicTableTitle && categoryTitles[currentCat]) {
            dynamicTableTitle.innerHTML = `<i class="fas fa-bookmark" aria-hidden="true"></i> <span>${categoryTitles[currentCat]}</span>`;
        }

        let visibleCount = 0;

        rows.forEach(row => {
            const rowCat = (row.getAttribute("data-cat") || "").toLowerCase();
            const rowDept = (row.getAttribute("data-dept") || "").toUpperCase();
            const rowYear = row.getAttribute("data-year") || "";
            const rowFaculty = row.getAttribute("data-faculty") || "";
            const rowDesc = row.getAttribute("data-desc") || "";

            const matchesCat = (currentCat === "all" || rowCat === currentCat);
            const matchesDept = (selectedDept === "ALL" || rowDept === selectedDept);
            const matchesYear = (selectedYear === "ALL" || rowYear === selectedYear);
            const matchesSearch = (!searchQuery || rowFaculty.includes(searchQuery) || rowDesc.includes(searchQuery));

            if (matchesCat && matchesDept && matchesYear && matchesSearch) {
                row.style.display = "";
                visibleCount++;
                const badge = row.querySelector(".fac-sr-badge");
                if (badge) {
                    badge.textContent = visibleCount;
                }
            } else {
                row.style.display = "none";
            }
        });

        if (visibleCount === 0) {
            facultyTable.style.display = "none";
            emptyState.style.display = "block";
        } else {
            facultyTable.style.display = "";
            emptyState.style.display = "none";
        }

        resultsCount.innerHTML = `Showing <strong>${visibleCount}</strong> record${visibleCount === 1 ? '' : 's'}`;
    }

    // Category Pill tabs click
    pillButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const cat = (btn.getAttribute("data-cat") || "conferences").toLowerCase();
            if (currentCat === cat) return;

            pillButtons.forEach(b => {
                b.classList.remove("is-active");
                b.setAttribute("aria-selected", "false");
            });

            btn.classList.add("is-active");
            btn.setAttribute("aria-selected", "true");
            currentCat = cat;

            filterTable();
            updateURL();

            btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        });
    });

    deptSelect.addEventListener("change", () => {
        filterTable();
        updateURL();
    });

    yearSelect.addEventListener("change", () => {
        filterTable();
        updateURL();
    });

    searchInput.addEventListener("input", filterTable);

    if (searchClearBtn) {
        searchClearBtn.addEventListener("click", () => {
            searchInput.value = "";
            filterTable();
            updateURL();
            searchInput.focus();
        });
    }

    function resetAllFilters() {
        currentCat = "conferences";
        pillButtons.forEach(b => {
            const isDefault = (b.getAttribute("data-cat") === "conferences");
            b.classList.toggle("is-active", isDefault);
            b.setAttribute("aria-selected", isDefault ? "true" : "false");
        });
        deptSelect.value = "ALL";
        yearSelect.value = "ALL";
        searchInput.value = "";
        filterTable();
        updateURL();
        const defaultBtn = document.querySelector("#catPillsContainer .dept-pill-btn[data-cat='conferences']");
        if (defaultBtn) {
            defaultBtn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }

    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener("click", resetAllFilters);
    }
    if (emptyResetBtn) {
        emptyResetBtn.addEventListener("click", resetAllFilters);
    }

    function updateURL() {
        const params = new URLSearchParams(window.location.search);
        if (currentCat !== "conferences") {
            params.set("cat", currentCat);
        } else {
            params.delete("cat");
        }
        if (deptSelect.value !== "ALL") {
            params.set("dept", deptSelect.value);
        } else {
            params.delete("dept");
        }
        if (yearSelect.value !== "ALL") {
            params.set("year", yearSelect.value);
        } else {
            params.delete("year");
        }
        const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        window.history.replaceState({}, '', newUrl);
    }

    // Initial filter run
    filterTable();
});
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
