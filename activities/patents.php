<?php
/**
 * GEC MODASA - PATENTS
 * Intellectual Property Rights, Granted & Published Patents Details
 * Modern Institutional Data Table synced with Admin Panel
 */
$page_title = "Patents | Government Engineering College, Modasa";
$active_page = "patents";
$root_path = "../";
$extra_css = "css/activities-hub.css";
$extra_js = "js/activities-hub.js";

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/cell_activities_helper.php';

$pdo = getDBConnection();
if ($pdo) {
    initCellActivitiesTable($pdo);
}

// Fetch Patents from Database (or Fallback if DB offline)
$patents = getCellActivities('patents', $pdo);
$totalPatents = count($patents);

require_once __DIR__ . '/../includes/header.php';
?>

<div class="act-hub-page" id="mainContent">

    <!-- Page Hero Banner (Identical to Student & Faculty Achievements) -->
    <header class="act-hero">
        <div class="act-hero-inner act-reveal">
            <span class="act-kicker">INTELLECTUAL PROPERTY &amp; INVENTIONS</span>
            <h1 class="act-heading" style="margin-bottom: 0;">Patents</h1>
            <p class="act-lead" style="margin-top: 12px;">
                Official register of utility and industrial design patents published and granted to faculty researchers and student innovators of Government Engineering College, Modasa.
            </p>
        </div>
    </header>

    <!-- Modern Institutional Table Container -->
    <main class="act-container" style="margin-top: 36px; margin-bottom: 80px;">
        <div class="patent-modern-wrapper">
            
            <!-- Table Header Bar -->
            <div class="patent-table-headerbar">
                <div class="headerbar-left">
                    <div class="headerbar-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <div>
                        <h2 class="headerbar-title">Patent Details &amp; IPR Register</h2>
                        <p class="headerbar-subtitle">Accredited by Directorate of Technical Education &amp; GTU</p>
                    </div>
                </div>

                <div class="headerbar-right">
                    <!-- Live Search Input -->
                    <div class="patent-search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" id="patentTableSearch" placeholder="Search by title, faculty, department..." aria-label="Search patents">
                    </div>

                    <!-- Total Count Pill -->
                    <div class="patent-count-chip">
                        Showing&nbsp;<strong id="patentDisplayCount"><?= $totalPatents ?></strong>&nbsp;patents
                    </div>

                    <!-- Print Button -->
                    <button type="button" onclick="window.print()" class="patent-btn-print" title="Print Register">
                        <i class="fas fa-print"></i> <span>Print</span>
                    </button>
                </div>
            </div>

            <!-- Responsive Table -->
            <div class="patent-table-scroll">
                <table class="patent-table-new" id="officialPatentTable">
                    <thead>
                        <tr>
                            <th class="th-sr">Sr. No.</th>
                            <th class="th-title">Patent Title</th>
                            <th class="th-year">Year of Pub.</th>
                            <th class="th-category">Category</th>
                            <th class="th-status">Status</th>
                            <th class="th-faculty">Faculty Name &amp; Inventors</th>
                            <th class="th-department">Department</th>
                        </tr>
                    </thead>
                    <tbody id="patentTableBody">
                        <?php 
                        $sr = 1;
                        foreach ($patents as $row):
                            $pYear = $row['pub_year'] ?? (!empty($row['activity_date']) ? date('Y', strtotime($row['activity_date'])) : '2024');
                            $pCat = $row['patent_category'] ?? 'Utility';
                            $pStat = $row['patent_status'] ?? 'Published';
                            $pFac = $row['faculty_name'] ?? '';
                            $pDept = $row['department'] ?? '';
                            
                            $catClass = (strtolower(trim($pCat)) === 'design') ? 'cat-design' : 'cat-utility';
                            $statClass = (strtolower(trim($pStat)) === 'granted') ? 'status-granted' : 'status-published';
                            
                            $searchHaystack = strtolower($row['title'] . ' ' . $pFac . ' ' . $pDept . ' ' . $pYear . ' ' . $pCat . ' ' . $pStat);
                        ?>
                            <tr class="patent-data-row" data-search="<?= htmlspecialchars($searchHaystack) ?>">
                                <!-- Sr. No. Badge -->
                                <td class="cell-sr">
                                    <span class="sr-badge"><?= sprintf('%02d', $sr++) ?></span>
                                </td>

                                <!-- Title -->
                                <td class="cell-title">
                                    <div class="title-main"><?= htmlspecialchars($row['title']) ?></div>
                                    <?php if (!empty($row['external_url']) && $row['external_url'] !== '#'): ?>
                                        <div style="margin-top: 5px;">
                                            <a href="<?= htmlspecialchars($row['external_url']) ?>" target="_blank" rel="noopener noreferrer" class="patent-cert-link">
                                                <i class="fas fa-arrow-up-right-from-square"></i> Gazette / Certificate Link
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Year -->
                                <td class="cell-year">
                                    <span class="year-badge">
                                        <i class="far fa-calendar-alt"></i> <?= htmlspecialchars($pYear) ?>
                                    </span>
                                </td>

                                <!-- Category -->
                                <td class="cell-category">
                                    <span class="cat-pill <?= $catClass ?>">
                                        <?php if ($catClass === 'cat-design'): ?>
                                            <i class="fas fa-drafting-compass"></i>
                                        <?php else: ?>
                                            <i class="fas fa-cogs"></i>
                                        <?php endif; ?>
                                        <?= htmlspecialchars($pCat) ?>
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="cell-status">
                                    <span class="status-pill <?= $statClass ?>">
                                        <?php if ($statClass === 'status-granted'): ?>
                                            <i class="fas fa-check-circle"></i>
                                        <?php else: ?>
                                            <i class="fas fa-newspaper"></i>
                                        <?php endif; ?>
                                        <?= htmlspecialchars($pStat) ?>
                                    </span>
                                </td>

                                <!-- Faculty Name -->
                                <td class="cell-faculty">
                                    <div class="faculty-box">
                                        <i class="fas fa-user-tie faculty-avatar"></i>
                                        <div class="faculty-text"><?= htmlspecialchars($pFac) ?></div>
                                    </div>
                                </td>

                                <!-- Department -->
                                <td class="cell-department">
                                    <div class="dept-chips-group">
                                        <?php 
                                        $deptItems = array_map('trim', explode(',', $pDept));
                                        foreach ($deptItems as $d):
                                            if (!empty($d)):
                                        ?>
                                            <span class="dept-chip"><?= htmlspecialchars($d) ?></span>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Empty Search Results State -->
            <div id="noPatentMatches" class="patent-empty-state" style="display: none;">
                <div class="empty-icon-circle">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="empty-title">No matching patents found</h3>
                <p class="empty-subtitle">Try searching for a different keyword, faculty name, or department.</p>
                <button type="button" id="resetPatentSearch" class="btn-reset-search">
                    <i class="fas fa-rotate-left"></i> Clear Search
                </button>
            </div>
        </div>
    </main>

</div>

<!-- Stylesheet: Modern Institutional Table Design -->
<style>
/* --------------------------------------------------------------------------
   WRAPPER & CARD STYLES
   -------------------------------------------------------------------------- */
.patent-modern-wrapper {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 10px 30px -4px rgba(15, 23, 42, 0.05);
    overflow: hidden;
    opacity: 1 !important;
    visibility: visible !important;
}

/* Header Bar inside Card */
.patent-table-headerbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 24px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    flex-wrap: wrap;
    gap: 16px;
}

.headerbar-left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.headerbar-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: #eff6ff;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.headerbar-title {
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 1.12rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    line-height: 1.25;
}

.headerbar-subtitle {
    font-size: 0.80rem;
    color: #64748b;
    margin: 2px 0 0;
    font-weight: 500;
}

.headerbar-right {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-left: auto;
}

/* Live Search Box */
.patent-search-box {
    position: relative;
    min-width: 250px;
}

.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}

.patent-search-box input {
    width: 100%;
    background: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 8px 12px 8px 34px;
    font-size: 0.88rem;
    color: #0f172a;
    outline: none;
    transition: border-color 0.18s ease, box-shadow 0.18s ease;
}

.patent-search-box input:focus {
    border-color: #ff8800;
    box-shadow: 0 0 0 3px rgba(255, 136, 0, 0.12);
}

.patent-count-chip {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 7px 12px;
    font-size: 0.82rem;
    font-weight: 600;
    color: #475569;
    white-space: nowrap;
}

.patent-count-chip strong {
    color: #0f172a;
}

.patent-btn-print {
    background: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 7px 14px;
    font-size: 0.84rem;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
    height: 36px;
}

.patent-btn-print:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    color: #0f172a;
}

/* --------------------------------------------------------------------------
   MODERN TABLE STYLING
   -------------------------------------------------------------------------- */
.patent-table-scroll {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.patent-table-new {
    width: 100%;
    border-collapse: collapse;
    font-family: var(--act-font-body, 'Inter', sans-serif);
    text-align: left;
}

/* Table Header */
.patent-table-new thead tr {
    background: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
}

.patent-table-new th {
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #475569;
    padding: 14px 18px;
    vertical-align: middle;
    white-space: nowrap;
    border: none;
}

.th-sr { width: 65px; text-align: center; }
.th-title { min-width: 290px; }
.th-year { width: 120px; text-align: center; }
.th-category { width: 115px; text-align: center; }
.th-status { width: 115px; text-align: center; }
.th-faculty { min-width: 300px; }
.th-department { width: 120px; text-align: center; }

/* Table Body Rows */
.patent-table-new tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background-color 0.18s ease;
}

.patent-table-new tbody tr:last-child {
    border-bottom: none;
}

.patent-table-new tbody tr:hover {
    background-color: #f8fafc;
}

.patent-table-new td {
    padding: 16px 18px;
    vertical-align: middle;
    font-size: 0.90rem;
    color: #1e293b;
    border: none;
}

/* Cell-Specific Components */
.cell-sr {
    text-align: center;
}

.sr-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    border-radius: 8px;
    background: #f1f5f9;
    color: #475569;
    font-family: var(--act-font-display, 'Plus Jakarta Sans', sans-serif);
    font-size: 0.80rem;
    font-weight: 700;
}

.title-main {
    font-weight: 600;
    color: #0f172a;
    line-height: 1.48;
    font-size: 0.94rem;
}

.patent-cert-link {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.76rem;
    font-weight: 600;
    color: #ea580c;
    text-decoration: none;
    transition: color 0.15s ease;
}

.patent-cert-link:hover {
    color: #c2410c;
    text-decoration: underline;
}

.cell-year {
    text-align: center;
}

.year-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.80rem;
    font-weight: 700;
    color: #334155;
    background: #f1f5f9;
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

.cell-category {
    text-align: center;
}

.cat-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.76rem;
    font-weight: 700;
    padding: 4px 11px;
    border-radius: 9999px;
    white-space: nowrap;
}

.cat-pill.cat-utility {
    background: #eef2ff;
    color: #4338ca;
    border: 1px solid #c7d2fe;
}

.cat-pill.cat-design {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fde68a;
}

.cell-status {
    text-align: center;
}

.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.76rem;
    font-weight: 700;
    padding: 4px 11px;
    border-radius: 9999px;
    white-space: nowrap;
}

.status-pill.status-granted {
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
}

.status-pill.status-published {
    background: #f0fdf4;
    color: #0284c7;
    border: 1px solid #bae6fd;
}

.faculty-box {
    display: flex;
    align-items: flex-start;
    gap: 9px;
}

.faculty-avatar {
    color: #94a3b8;
    font-size: 0.90rem;
    margin-top: 3px;
    flex-shrink: 0;
}

.faculty-text {
    color: #334155;
    line-height: 1.45;
    font-size: 0.86rem;
}

.cell-department {
    text-align: center;
}

.dept-chips-group {
    display: flex;
    gap: 4px;
    justify-content: center;
    flex-wrap: wrap;
}

.dept-chip {
    background: #f8fafc;
    border: 1px solid #cbd5e1;
    color: #334155;
    font-size: 0.74rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 4px;
}

/* Empty State */
.patent-empty-state {
    padding: 56px 20px;
    text-align: center;
}

.empty-icon-circle {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: #f1f5f9;
    color: #94a3b8;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    margin-bottom: 12px;
}

.empty-title {
    font-size: 1.10rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 5px;
}

.empty-subtitle {
    font-size: 0.88rem;
    color: #64748b;
    margin: 0 0 16px;
}

.btn-reset-search {
    background: #ff8800;
    color: #ffffff;
    border: none;
    border-radius: 6px;
    padding: 8px 16px;
    font-size: 0.84rem;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: background 0.15s ease;
}

.btn-reset-search:hover {
    background: #ea580c;
}

/* --------------------------------------------------------------------------
   RESPONSIVE & PRINT MEDIA QUERIES
   -------------------------------------------------------------------------- */
@media (max-width: 900px) {
    .patent-table-headerbar {
        flex-direction: column;
        align-items: stretch;
    }
    .headerbar-right {
        margin-left: 0;
        width: 100%;
        justify-content: flex-start;
    }
    .patent-search-box {
        flex: 1;
        min-width: 200px;
    }
}

@media (max-width: 640px) {
    .headerbar-left {
        gap: 10px;
    }
    .patent-table-new td, .patent-table-new th {
        padding: 12px 14px;
    }
}

@media print {
    header.site-header, footer, .act-hero, .headerbar-right {
        display: none !important;
    }
    body, .act-hub-page, main, .act-container {
        margin: 0 !important;
        padding: 0 !important;
        background: #fff !important;
    }
    .patent-modern-wrapper {
        border: 1px solid #000 !important;
        box-shadow: none !important;
    }
    .patent-table-new th, .patent-table-new td {
        border-bottom: 1px solid #ddd !important;
    }
}
</style>

<!-- Live Instant Search Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('patentTableSearch');
    const tableBody = document.getElementById('patentTableBody');
    const rows = Array.from(document.querySelectorAll('.patent-data-row'));
    const countDisplay = document.getElementById('patentDisplayCount');
    const noMatches = document.getElementById('noPatentMatches');
    const resetBtn = document.getElementById('resetPatentSearch');

    function filterTable() {
        const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
        let visibleCount = 0;

        rows.forEach(row => {
            const searchContent = row.getAttribute('data-search') || '';
            if (!query || searchContent.includes(query)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (countDisplay) {
            countDisplay.textContent = visibleCount;
        }

        if (noMatches) {
            noMatches.style.display = (visibleCount === 0) ? 'block' : 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            filterTable();
        });
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
