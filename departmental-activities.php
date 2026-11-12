<?php
$page_title = "Departmental Activities & Events | Government Engineering College, Modasa";
$active_page = "dept_activities";
$root_path = "";
$extra_css = "css/activities-hub.css";

require_once __DIR__ . '/includes/db.php';
$pdo = getDBConnection();

// Fetch departments for filter
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
            SELECT * FROM department_activities 
            WHERE is_active = 1 
            ORDER BY activity_date DESC, display_order ASC, id DESC
        ");
        $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Collect available years from real records
        foreach ($activities as $act) {
            if (!empty($act['activity_date'])) {
                $yr = date('Y', strtotime($act['activity_date']));
                if (!in_array($yr, $availableYears)) {
                    $availableYears[] = $yr;
                }
            }
        }
        rsort($availableYears);
    } catch (Exception $e) {
        error_log("Departmental Activities Error: " . $e->getMessage());
    }
}

// Compute counts per department for quick pill counters
$deptCounts = [];
foreach ($activities as $act) {
    $c = strtoupper(trim($act['dept_code'] ?? ''));
    if (!empty($c)) {
        $deptCounts[$c] = ($deptCounts[$c] ?? 0) + 1;
    }
}

// Ensure current year is in filter options
$currentYr = date('Y');
if (!in_array($currentYr, $availableYears)) {
    array_unshift($availableYears, $currentYr);
}
rsort($availableYears);

require_once __DIR__ . '/includes/header.php';
?>

<div class="act-hub-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="act-hero">
        <div class="act-hero-inner">
            <span class="act-kicker">INSTITUTIONAL SHOWCASE</span>
            <h1 class="act-heading" style="margin-bottom: 0;">Departmental Activities &amp; Events</h1>
        </div>
    </header>

    <!-- Secondary Minimal Action Toolbar (Search, Department Dropdown, Year Dropdown) -->
    <div class="act-toolbar-strip" style="margin-top: 36px;">
        <div class="act-toolbar-inner">
            <div class="act-search-pill">
                <i class="fas fa-search act-search-icon" aria-hidden="true"></i>
                <input type="text" id="searchInput" class="act-search-field" placeholder="Search by title, workshop, or topic..." aria-label="Search departmental activities">
                <button type="button" id="searchClearBtn" class="act-search-clear" aria-label="Clear search" style="display: none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="act-toolbar-meta">
                <!-- Department Dropdown Pill -->
                <div class="act-year-dropdown-wrap">
                    <span class="act-year-label">Dept:</span>
                    <select id="deptSelect" class="act-year-select" aria-label="Filter by Department">
                        <option value="ALL" <?= ($selectedDept === 'ALL') ? 'selected' : '' ?>>All Departments</option>
                        <?php foreach ($deptFilterList as $code => $name): ?>
                            <option value="<?= $code ?>" <?= ($selectedDept === $code) ? 'selected' : '' ?>>
                                <?= $code ?> - <?= htmlspecialchars($name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-chevron-down act-year-icon"></i>
                </div>

                <!-- Year Dropdown Pill (Right Beside Department) -->
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
                    Showing <strong><?= count($activities) ?></strong> activities
                </div>

                <button type="button" id="resetFiltersBtn" class="act-reset-link" style="display: none;">
                    Reset filters
                </button>
            </div>
        </div>
    </div>

    <!-- Activities Grid Container -->
    <main class="act-container">
        <div class="act-grid" id="activitiesGrid">
            <?php foreach ($activities as $act):
                $code = strtoupper(trim($act['dept_code'] ?? ''));
                $deptTitle = $deptFilterList[$code] ?? $code;
                $actYear = !empty($act['activity_date']) ? date('Y', strtotime($act['activity_date'])) : '2026';
                $actDateFormatted = !empty($act['activity_date']) ? date('M d, Y', strtotime($act['activity_date'])) : 'Recent';
                $photoSrc = !empty($act['image_url']) ? htmlspecialchars($root_path . $act['image_url']) : 'images/hero_campus_1.jpg';
                $modalId = 'actModal_' . $act['id'];
                $badgeClass = 'badge-' . strtolower($code);
                $rawDesc = !empty($act['short_description']) ? $act['short_description'] : (!empty($act['description']) ? $act['description'] : '');
                $fullDesc = !empty($act['description']) ? $act['description'] : (!empty($act['short_description']) ? $act['short_description'] : 'No detailed description available.');
            ?>
                <article class="act-card"
                         data-dept="<?= htmlspecialchars($code) ?>"
                         data-year="<?= htmlspecialchars($actYear) ?>"
                         data-title="<?= htmlspecialchars(strtolower($act['title'])) ?>"
                         data-desc="<?= htmlspecialchars(strtolower($rawDesc)) ?>">
                    
                    <div class="act-card-media">
                        <img src="<?= $photoSrc ?>" alt="<?= htmlspecialchars($act['title']) ?>" loading="lazy" onerror="this.src='images/hero_campus_1.jpg'">
                        <span class="act-dept-badge <?= $badgeClass ?>"><?= htmlspecialchars($code) ?> &bull; <?= htmlspecialchars($deptTitle) ?></span>
                    </div>

                    <div class="act-card-body">
                        <div class="act-card-date">
                            <i class="far fa-calendar-alt"></i>
                            <span><?= $actDateFormatted ?></span>
                        </div>

                        <h3 class="act-card-title"><?= htmlspecialchars($act['title']) ?></h3>

                        <p class="act-card-desc">
                            <?= nl2br(htmlspecialchars(mb_strimwidth($rawDesc, 0, 150, '...'))) ?>
                        </p>

                        <div class="act-card-footer">
                            <button type="button" class="act-btn-view" onclick="openActModal('<?= $modalId ?>')">
                                <span>View Details</span>
                                <i class="fas fa-arrow-right"></i>
                            </button>
                            <?php if (!empty($act['external_url']) && $act['external_url'] !== '#'): ?>
                                <a href="<?= htmlspecialchars($act['external_url']) ?>" target="_blank" rel="noopener noreferrer" class="act-link-ext">
                                    <i class="fas fa-external-link-alt"></i> Report
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>

                <!-- Full Detail Modal -->
                <div class="act-modal-backdrop" id="<?= $modalId ?>" role="dialog" aria-modal="true" aria-labelledby="<?= $modalId ?>_title">
                    <div class="act-modal-dialog">
                        <?php if (!empty($act['image_url'])): ?>
                            <div class="act-modal-media">
                                <img src="<?= $photoSrc ?>" alt="<?= htmlspecialchars($act['title']) ?>">
                            </div>
                        <?php endif; ?>

                        <div class="act-modal-header">
                            <button type="button" class="act-modal-close" onclick="closeActModal('<?= $modalId ?>')" aria-label="Close modal">
                                <i class="fas fa-times"></i>
                            </button>
                            <span class="act-dept-badge <?= $badgeClass ?>" style="position:static; margin-bottom:8px; display:inline-block;">
                                <?= htmlspecialchars($code) ?> &bull; <?= htmlspecialchars($deptTitle) ?>
                            </span>
                            <div class="act-card-date" style="display:block; margin:6px 0;">
                                <i class="far fa-calendar-alt"></i> <?= $actDateFormatted ?>
                            </div>
                            <h2 id="<?= $modalId ?>_title" style="font-size:1.45rem; font-weight:800; color:#111; margin:6px 0 0; line-height:1.3;">
                                <?= htmlspecialchars($act['title']) ?>
                            </h2>
                        </div>

                        <div class="act-modal-body">
                            <?= nl2br(htmlspecialchars($fullDesc)) ?>
                        </div>

                        <div class="act-modal-footer">
                            <?php if (!empty($act['external_url']) && $act['external_url'] !== '#'): ?>
                                <a href="<?= htmlspecialchars($act['external_url']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="padding:8px 18px; font-size:0.88rem;">
                                    <i class="fas fa-external-link-alt"></i> View Official Report / Document
                                </a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-secondary" onclick="closeActModal('<?= $modalId ?>')" style="padding:8px 18px; font-size:0.88rem;">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Empty State Container -->
            <div class="act-empty-state" id="emptyState" style="display: none;">
                <i class="fas fa-calendar-times act-empty-icon"></i>
                <h4 class="act-empty-title">No Activities Found</h4>
                <p class="act-empty-desc">No departmental activities match your selected department, year, or search criteria. Please adjust your filters or reset to view all.</p>
                <button type="button" class="btn btn-primary" id="emptyResetBtn" style="margin-top: 16px; padding: 8px 22px; font-size: 0.86rem; border-radius: 9999px;">
                    <i class="fas fa-undo"></i> Show All Activities
                </button>
            </div>
        </div>
    </main>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const deptSelect = document.getElementById("deptSelect");
    const yearSelect = document.getElementById("yearSelect");
    const searchInput = document.getElementById("searchInput");
    const searchClearBtn = document.getElementById("searchClearBtn");
    const resetFiltersBtn = document.getElementById("resetFiltersBtn");
    const emptyResetBtn = document.getElementById("emptyResetBtn");
    const cards = Array.from(document.querySelectorAll("#activitiesGrid .act-card"));
    const emptyState = document.getElementById("emptyState");
    const resultsCount = document.getElementById("resultsCount");

    function filterActivities() {
        const selectedDept = deptSelect.value.toUpperCase();
        const selectedYear = yearSelect.value;
        const searchQuery = searchInput.value.trim().toLowerCase();

        // Toggle clear search button
        if (searchClearBtn) {
            searchClearBtn.style.display = searchQuery ? "flex" : "none";
        }

        // Toggle reset filters button if non-default
        const isFiltered = (selectedDept !== "ALL" || selectedYear !== "ALL" || searchQuery.length > 0);
        if (resetFiltersBtn) {
            resetFiltersBtn.style.display = isFiltered ? "inline-block" : "none";
        }

        let visibleCount = 0;

        cards.forEach(card => {
            const cardDept = (card.getAttribute("data-dept") || "").toUpperCase();
            const cardYear = card.getAttribute("data-year") || "";
            const cardTitle = card.getAttribute("data-title") || "";
            const cardDesc = card.getAttribute("data-desc") || "";

            const matchesDept = (selectedDept === "ALL" || cardDept === selectedDept);
            const matchesYear = (selectedYear === "ALL" || cardYear === selectedYear);
            const matchesSearch = (!searchQuery || cardTitle.includes(searchQuery) || cardDesc.includes(searchQuery));

            if (matchesDept && matchesYear && matchesSearch) {
                card.style.display = "";
                visibleCount++;
            } else {
                card.style.display = "none";
            }
        });

        if (visibleCount === 0) {
            emptyState.style.display = "block";
        } else {
            emptyState.style.display = "none";
        }

        resultsCount.innerHTML = `Showing <strong>${visibleCount}</strong> activit${visibleCount === 1 ? 'y' : 'ies'}`;
    }

    deptSelect.addEventListener("change", () => {
        filterActivities();
        updateURL();
    });

    yearSelect.addEventListener("change", () => {
        filterActivities();
        updateURL();
    });

    searchInput.addEventListener("input", filterActivities);

    if (searchClearBtn) {
        searchClearBtn.addEventListener("click", () => {
            searchInput.value = "";
            filterActivities();
            updateURL();
            searchInput.focus();
        });
    }

    function resetAllFilters() {
        deptSelect.value = "ALL";
        yearSelect.value = "ALL";
        searchInput.value = "";
        filterActivities();
        updateURL();
    }

    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener("click", resetAllFilters);
    }
    if (emptyResetBtn) {
        emptyResetBtn.addEventListener("click", resetAllFilters);
    }

    function updateURL() {
        const params = new URLSearchParams(window.location.search);
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

    // Initial check
    filterActivities();
});

// Modal helpers
window.openActModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add("is-active");
    document.body.style.overflow = "hidden";
};

window.closeActModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove("is-active");
    document.body.style.overflow = "";
};

// Dismiss modal on backdrop click or Escape
document.addEventListener("click", (e) => {
    if (e.target.classList.contains("act-modal-backdrop")) {
        e.target.classList.remove("is-active");
        document.body.style.overflow = "";
    }
});

document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
        document.querySelectorAll(".act-modal-backdrop.is-active").forEach(m => {
            m.classList.remove("is-active");
        });
        document.body.style.overflow = "";
    }
});
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>

