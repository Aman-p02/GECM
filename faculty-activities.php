<?php
$page_title = "Faculty Activities & Professional Development | Government Engineering College, Modasa";
$active_page = "faculty_activities";
$root_path = "";
$extra_css = "css/activities-hub.css";

require_once __DIR__ . '/includes/db.php';
$pdo = getDBConnection();

$trainings = [];
$expertLectures = [];
$conferences = [];

if ($pdo) {
    try {
        $stmt = $pdo->query("
            SELECT * FROM faculty_activities 
            WHERE is_active = 1 
            ORDER BY display_order ASC, id ASC
        ");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['category'] === 'trainings') {
                $trainings[] = $row;
            } elseif ($row['category'] === 'expert_lectures') {
                $expertLectures[] = $row;
            } elseif ($row['category'] === 'conferences') {
                $conferences[] = $row;
            }
        }
    } catch (Exception $e) {
        error_log("Faculty Activities Error: " . $e->getMessage());
    }
}

// Current active tab from URL (defaults to 'trainings')
$activeTab = $_GET['tab'] ?? 'trainings';
$validTabs = ['trainings', 'expert_lectures', 'conferences'];
if (!in_array($activeTab, $validTabs)) {
    $activeTab = 'trainings';
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="act-hub-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="act-hero">
        <div class="act-hero-inner">
            <span class="act-kicker">ACADEMIC &amp; RESEARCH LEADERSHIP</span>
            <h1 class="act-heading" style="margin-bottom: 0;">Faculty Activities</h1>
        </div>
    </header>

    <!-- 3 Navbar Tabs (Trainings, Expert Lectures, Conferences) -->
    <div class="fac-tabs-wrapper">
        <nav class="fac-tabs-nav" role="tablist" aria-label="Faculty Activities Categories">
            <button type="button" 
                    class="fac-tab-btn <?= ($activeTab === 'trainings') ? 'is-active' : '' ?>" 
                    id="tabBtnTrainings" 
                    data-tab-target="tabTrainings" 
                    role="tab" 
                    aria-selected="<?= ($activeTab === 'trainings') ? 'true' : 'false' ?>" 
                    aria-controls="tabTrainings">
                <span>Trainings</span>
                <span class="fac-tab-badge" id="badgeTrainings"><?= count($trainings) ?></span>
            </button>

            <button type="button" 
                    class="fac-tab-btn <?= ($activeTab === 'expert_lectures') ? 'is-active' : '' ?>" 
                    id="tabBtnLectures" 
                    data-tab-target="tabLectures" 
                    role="tab" 
                    aria-selected="<?= ($activeTab === 'expert_lectures') ? 'true' : 'false' ?>" 
                    aria-controls="tabLectures">
                <span>Expert Lectures</span>
                <span class="fac-tab-badge" id="badgeLectures"><?= count($expertLectures) ?></span>
            </button>

            <button type="button" 
                    class="fac-tab-btn <?= ($activeTab === 'conferences') ? 'is-active' : '' ?>" 
                    id="tabBtnConferences" 
                    data-tab-target="tabConferences" 
                    role="tab" 
                    aria-selected="<?= ($activeTab === 'conferences') ? 'true' : 'false' ?>" 
                    aria-controls="tabConferences">
                <span>Conferences</span>
                <span class="fac-tab-badge" id="badgeConferences"><?= count($conferences) ?></span>
            </button>
        </nav>
    </div>

    <!-- Tab Contents Container -->
    <main class="act-container" style="max-width: 1320px; margin: 0 auto; padding: 0 24px;">

        <!-- 1. TRAININGS TAB -->
        <section class="fac-tab-pane <?= ($activeTab === 'trainings') ? 'is-active' : '' ?>" 
                 id="tabTrainings" 
                 role="tabpanel" 
                 aria-labelledby="tabBtnTrainings" 
                 style="<?= ($activeTab === 'trainings') ? '' : 'display: none;' ?>">
            
            <div class="fac-tab-toolbar">
                <div class="fac-search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="fac-table-search-input" placeholder="Search by faculty name or training details..." data-target-table="tableTrainings">
                </div>
                <div class="fac-tab-meta">
                    <i class="fas fa-info-circle" style="color: #0284c7;"></i>
                    <span>Showing <strong class="fac-showing-count"><?= count($trainings) ?></strong> training records</span>
                </div>
            </div>

            <div class="fac-table-card">
                <div class="fac-table-responsive">
                    <table class="fac-table" id="tableTrainings">
                        <thead>
                            <tr>
                                <th class="fac-col-sr">Sr.<br>No.</th>
                                <th class="fac-col-faculty">Faculty Name</th>
                                <th>Trainings Attended by Faculty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sr = 1; foreach ($trainings as $item): ?>
                            <tr>
                                <td class="fac-col-sr"><?= $sr++ ?></td>
                                <td class="fac-col-faculty">
                                    <div class="fac-faculty-name"><?= htmlspecialchars($item['faculty_name']) ?></div>
                                    <?php if (!empty($item['designation']) || !empty($item['dept_code'])): ?>
                                        <div class="fac-faculty-sub">
                                            <?= htmlspecialchars($item['designation'] ?? '') ?>
                                            <?= (!empty($item['designation']) && !empty($item['dept_code'])) ? '·' : '' ?>
                                            <?= htmlspecialchars($item['dept_code'] ?? '') ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($item['title'])): ?>
                                        <div style="font-weight: 600; color: #0f172a; margin-bottom: 2px;">
                                            <?= htmlspecialchars($item['title']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="fac-desc-text">
                                        <?= nl2br(htmlspecialchars($item['description'])) ?>
                                    </div>
                                    <?php if (!empty($item['year']) || !empty($item['event_date'])): ?>
                                        <div style="font-size: 0.78rem; color: #94a3b8; margin-top: 4px;">
                                            <?php if (!empty($item['event_date'])): ?>
                                                <span><i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($item['event_date'])) ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($item['year'])): ?>
                                                <span style="margin-left: 8px;"><i class="far fa-clock"></i> Year: <?= htmlspecialchars($item['year']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($trainings)): ?>
                            <tr class="fac-no-records">
                                <td colspan="3" class="fac-empty-state">
                                    <i class="fas fa-user-graduate"></i>
                                    <p style="margin: 0; font-weight: 600;">No training records found.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- 2. EXPERT LECTURES TAB -->
        <section class="fac-tab-pane <?= ($activeTab === 'expert_lectures') ? 'is-active' : '' ?>" 
                 id="tabLectures" 
                 role="tabpanel" 
                 aria-labelledby="tabBtnLectures" 
                 style="<?= ($activeTab === 'expert_lectures') ? '' : 'display: none;' ?>">
            
            <div class="fac-tab-toolbar">
                <div class="fac-search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="fac-table-search-input" placeholder="Search by faculty name or lecture topics..." data-target-table="tableLectures">
                </div>
                <div class="fac-tab-meta">
                    <i class="fas fa-info-circle" style="color: #0284c7;"></i>
                    <span>Showing <strong class="fac-showing-count"><?= count($expertLectures) ?></strong> expert lectures</span>
                </div>
            </div>

            <div class="fac-table-card">
                <div class="fac-table-responsive">
                    <table class="fac-table" id="tableLectures">
                        <thead>
                            <tr>
                                <th class="fac-col-sr">Sr.<br>No.</th>
                                <th class="fac-col-faculty">Faculty Name</th>
                                <th>Expert Lectures Delivered by Faculty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sr = 1; foreach ($expertLectures as $item): ?>
                            <tr>
                                <td class="fac-col-sr"><?= $sr++ ?></td>
                                <td class="fac-col-faculty">
                                    <div class="fac-faculty-name"><?= htmlspecialchars($item['faculty_name']) ?></div>
                                    <?php if (!empty($item['designation']) || !empty($item['dept_code'])): ?>
                                        <div class="fac-faculty-sub">
                                            <?= htmlspecialchars($item['designation'] ?? '') ?>
                                            <?= (!empty($item['designation']) && !empty($item['dept_code'])) ? '·' : '' ?>
                                            <?= htmlspecialchars($item['dept_code'] ?? '') ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($item['title'])): ?>
                                        <div style="font-weight: 600; color: #0f172a; margin-bottom: 2px;">
                                            <?= htmlspecialchars($item['title']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="fac-desc-text">
                                        <?= nl2br(htmlspecialchars($item['description'])) ?>
                                    </div>
                                    <?php if (!empty($item['year']) || !empty($item['event_date'])): ?>
                                        <div style="font-size: 0.78rem; color: #94a3b8; margin-top: 4px;">
                                            <?php if (!empty($item['event_date'])): ?>
                                                <span><i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($item['event_date'])) ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($item['year'])): ?>
                                                <span style="margin-left: 8px;"><i class="far fa-clock"></i> Year: <?= htmlspecialchars($item['year']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($expertLectures)): ?>
                            <tr class="fac-no-records">
                                <td colspan="3" class="fac-empty-state">
                                    <i class="fas fa-microphone-alt"></i>
                                    <p style="margin: 0; font-weight: 600;">No expert lectures found.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- 3. CONFERENCES TAB -->
        <section class="fac-tab-pane <?= ($activeTab === 'conferences') ? 'is-active' : '' ?>" 
                 id="tabConferences" 
                 role="tabpanel" 
                 aria-labelledby="tabBtnConferences" 
                 style="<?= ($activeTab === 'conferences') ? '' : 'display: none;' ?>">
            
            <div class="fac-tab-toolbar">
                <div class="fac-search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="fac-table-search-input" placeholder="Search conference details or chair sessions..." data-target-table="tableConferences">
                </div>
                <div class="fac-tab-meta">
                    <i class="fas fa-info-circle" style="color: #0284c7;"></i>
                    <span>Showing <strong class="fac-showing-count"><?= count($conferences) ?></strong> conference entries</span>
                </div>
            </div>

            <div class="fac-table-card">
                <div class="fac-table-responsive">
                    <table class="fac-table" id="tableConferences">
                        <thead>
                            <tr>
                                <th class="fac-col-sr">Sr.<br>No.</th>
                                <th>Conferences Attended/Chaired by Faculty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sr = 1; foreach ($conferences as $item): ?>
                            <tr>
                                <td class="fac-col-sr"><?= $sr++ ?></td>
                                <td>
                                    <?php if (!empty($item['title'])): ?>
                                        <div style="font-weight: 600; color: #0f172a; margin-bottom: 2px;">
                                            <?= htmlspecialchars($item['title']) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="fac-desc-text">
                                        <?= nl2br(htmlspecialchars($item['description'])) ?>
                                    </div>
                                    <?php if (!empty($item['year']) || !empty($item['event_date'])): ?>
                                        <div style="font-size: 0.78rem; color: #94a3b8; margin-top: 4px;">
                                            <?php if (!empty($item['event_date'])): ?>
                                                <span><i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($item['event_date'])) ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($item['year'])): ?>
                                                <span style="margin-left: 8px;"><i class="far fa-clock"></i> Year: <?= htmlspecialchars($item['year']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($conferences)): ?>
                            <tr class="fac-no-records">
                                <td colspan="2" class="fac-empty-state">
                                    <i class="fas fa-users"></i>
                                    <p style="margin: 0; font-weight: 600;">No conference records found.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Tab Switching Functionality
    const tabButtons = document.querySelectorAll('.fac-tab-btn');
    const tabPanes = document.querySelectorAll('.fac-tab-pane');

    const tabParamMap = {
        'tabTrainings': 'trainings',
        'tabLectures': 'expert_lectures',
        'tabConferences': 'conferences'
    };

    tabButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const targetPaneId = this.getAttribute('data-tab-target');

            // Deactivate all buttons
            tabButtons.forEach(function (btn) {
                btn.classList.remove('is-active');
                btn.setAttribute('aria-selected', 'false');
            });

            // Hide all tab panes
            tabPanes.forEach(function (pane) {
                pane.classList.remove('is-active');
                pane.style.display = 'none';
            });

            // Activate clicked button
            this.classList.add('is-active');
            this.setAttribute('aria-selected', 'true');

            // Show target pane
            const activePane = document.getElementById(targetPaneId);
            if (activePane) {
                activePane.classList.add('is-active');
                activePane.style.display = '';
            }

            // Sync URL with push/replaceState for bookmarking/navigation
            if (tabParamMap[targetPaneId] && window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.set('tab', tabParamMap[targetPaneId]);
                window.history.replaceState({}, '', url);
            }
        });
    });

    // 2. Real-time Live Search Filter within Active Table
    const searchInputs = document.querySelectorAll('.fac-table-search-input');
    searchInputs.forEach(function (input) {
        input.addEventListener('keyup', function () {
            const query = this.value.toLowerCase().trim();
            const tableId = this.getAttribute('data-target-table');
            const table = document.getElementById(tableId);
            if (!table) return;

            const tbody = table.querySelector('tbody');
            if (!tbody) return;

            const rows = tbody.querySelectorAll('tr:not(.fac-no-records)');
            let visibleCount = 0;

            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                if (text.indexOf(query) > -1) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update showing count in toolbar
            const pane = table.closest('.fac-tab-pane');
            if (pane) {
                const countBadge = pane.querySelector('.fac-showing-count');
                if (countBadge) {
                    countBadge.textContent = visibleCount;
                }
            }
        });
    });
});
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
