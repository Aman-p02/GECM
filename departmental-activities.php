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

    <!-- Minimalist Filter Bar (Department & Year Custom Dropdowns) -->
    <div class="act-toolbar-strip" style="margin-top: 14px;">
        <div class="act-toolbar-inner" style="justify-content: space-between;">
            <div class="act-toolbar-filters" style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                <!-- Department Custom Dropdown -->
                <div class="custom-select-wrap" id="deptDropdownWrap">
                    <button type="button" class="custom-select-trigger" id="deptDropdownTrigger" aria-expanded="false" aria-haspopup="listbox">
                        <span class="custom-select-value" id="deptSelectedLabel"><?= ($selectedDept === 'ALL') ? 'All Departments' : ($deptFilterList[$selectedDept] ?? $selectedDept) ?></span>
                        <i class="fas fa-chevron-down custom-select-arrow"></i>
                    </button>
                    <div class="custom-select-menu" id="deptDropdownMenu" role="listbox" aria-label="Select Department">
                        <div class="custom-select-option <?= ($selectedDept === 'ALL') ? 'is-selected' : '' ?>" data-value="ALL" role="option">
                            All Departments
                        </div>
                        <?php foreach ($deptFilterList as $code => $name): ?>
                            <div class="custom-select-option <?= ($selectedDept === $code) ? 'is-selected' : '' ?>" data-value="<?= $code ?>" role="option">
                                <?= htmlspecialchars($name) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Year Custom Dropdown (Right Beside Department) -->
                <div class="custom-select-wrap" id="yearDropdownWrap">
                    <button type="button" class="custom-select-trigger" id="yearDropdownTrigger" aria-expanded="false" aria-haspopup="listbox">
                        <span class="custom-select-value" id="yearSelectedLabel"><?= ($selectedYear === 'ALL') ? 'All Years' : $selectedYear ?></span>
                        <i class="fas fa-chevron-down custom-select-arrow"></i>
                    </button>
                    <div class="custom-select-menu" id="yearDropdownMenu" role="listbox" aria-label="Select Year" style="min-width: 140px;">
                        <div class="custom-select-option <?= ($selectedYear === 'ALL') ? 'is-selected' : '' ?>" data-value="ALL" role="option">
                            All Years
                        </div>
                        <?php foreach ($availableYears as $yr): ?>
                            <div class="custom-select-option <?= ($selectedYear == $yr) ? 'is-selected' : '' ?>" data-value="<?= $yr ?>" role="option">
                                <?= $yr ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="act-toolbar-meta">
                <div class="act-count-pill" id="resultsCount">
                    Showing&nbsp;<strong><?= count($activities) ?></strong>&nbsp;activities
                </div>
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
    // Custom Dropdown Elements
    const deptDropdownWrap = document.getElementById("deptDropdownWrap");
    const deptDropdownTrigger = document.getElementById("deptDropdownTrigger");
    const deptSelectedLabel = document.getElementById("deptSelectedLabel");
    const deptOptions = Array.from(document.querySelectorAll("#deptDropdownMenu .custom-select-option"));

    const yearDropdownWrap = document.getElementById("yearDropdownWrap");
    const yearDropdownTrigger = document.getElementById("yearDropdownTrigger");
    const yearSelectedLabel = document.getElementById("yearSelectedLabel");
    const yearOptions = Array.from(document.querySelectorAll("#yearDropdownMenu .custom-select-option"));

    const emptyResetBtn = document.getElementById("emptyResetBtn");
    const cards = Array.from(document.querySelectorAll("#activitiesGrid .act-card"));
    const emptyState = document.getElementById("emptyState");
    const resultsCount = document.getElementById("resultsCount");

    let currentDept = "<?= htmlspecialchars($selectedDept) ?>";
    if (!currentDept) currentDept = "ALL";

    let currentYear = "<?= htmlspecialchars($selectedYear) ?>";
    if (!currentYear) currentYear = "ALL";

    // Toggle Dropdowns
    deptDropdownTrigger.addEventListener("click", (e) => {
        e.stopPropagation();
        const isOpen = deptDropdownWrap.classList.contains("is-open");
        closeAllDropdowns();
        if (!isOpen) {
            deptDropdownWrap.classList.add("is-open");
            deptDropdownTrigger.setAttribute("aria-expanded", "true");
        }
    });

    yearDropdownTrigger.addEventListener("click", (e) => {
        e.stopPropagation();
        const isOpen = yearDropdownWrap.classList.contains("is-open");
        closeAllDropdowns();
        if (!isOpen) {
            yearDropdownWrap.classList.add("is-open");
            yearDropdownTrigger.setAttribute("aria-expanded", "true");
        }
    });

    function closeAllDropdowns() {
        deptDropdownWrap.classList.remove("is-open");
        deptDropdownTrigger.setAttribute("aria-expanded", "false");
        yearDropdownWrap.classList.remove("is-open");
        yearDropdownTrigger.setAttribute("aria-expanded", "false");
    }

    // Dismiss dropdowns on outside click or Escape
    document.addEventListener("click", (e) => {
        if (!deptDropdownWrap.contains(e.target) && !yearDropdownWrap.contains(e.target)) {
            closeAllDropdowns();
        }
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            closeAllDropdowns();
        }
    });

    // Handle Department Selection
    deptOptions.forEach(opt => {
        opt.addEventListener("click", () => {
            const val = (opt.getAttribute("data-value") || "ALL").toUpperCase();
            const labelText = opt.textContent.trim();

            currentDept = val;
            deptSelectedLabel.textContent = labelText;

            deptOptions.forEach(o => o.classList.toggle("is-selected", o === opt));
            closeAllDropdowns();

            filterActivities();
            updateURL();
        });
    });

    // Handle Year Selection
    yearOptions.forEach(opt => {
        opt.addEventListener("click", () => {
            const val = opt.getAttribute("data-value") || "ALL";
            const labelText = opt.textContent.trim();

            currentYear = val;
            yearSelectedLabel.textContent = labelText;

            yearOptions.forEach(o => o.classList.toggle("is-selected", o === opt));
            closeAllDropdowns();

            filterActivities();
            updateURL();
        });
    });

    function filterActivities() {
        let visibleCount = 0;

        cards.forEach(card => {
            const cardDept = (card.getAttribute("data-dept") || "").toUpperCase();
            const cardYear = card.getAttribute("data-year") || "";

            const matchesDept = (currentDept === "ALL" || cardDept === currentDept);
            const matchesYear = (currentYear === "ALL" || cardYear === currentYear);

            if (matchesDept && matchesYear) {
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

        resultsCount.innerHTML = `Showing&nbsp;<strong>${visibleCount}</strong>&nbsp;activit${visibleCount === 1 ? 'y' : 'ies'}`;
    }

    function resetAllFilters() {
        currentDept = "ALL";
        currentYear = "ALL";

        deptSelectedLabel.textContent = "All Departments";
        yearSelectedLabel.textContent = "All Years";

        deptOptions.forEach(o => o.classList.toggle("is-selected", o.getAttribute("data-value") === "ALL"));
        yearOptions.forEach(o => o.classList.toggle("is-selected", o.getAttribute("data-value") === "ALL"));

        closeAllDropdowns();
        filterActivities();
        updateURL();
    }

    if (emptyResetBtn) {
        emptyResetBtn.addEventListener("click", resetAllFilters);
    }

    function updateURL() {
        const params = new URLSearchParams(window.location.search);
        if (currentDept !== "ALL") {
            params.set("dept", currentDept);
        } else {
            params.delete("dept");
        }
        if (currentYear !== "ALL") {
            params.set("year", currentYear);
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

