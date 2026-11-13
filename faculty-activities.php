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
        // Conferences: latest added first (id DESC)
        $cStmt = $pdo->query("
            SELECT * FROM faculty_activities 
            WHERE is_active = 1 AND category = 'conferences' 
            ORDER BY id DESC
        ");
        $conferences = $cStmt->fetchAll(PDO::FETCH_ASSOC);

        // Trainings: latest added first (id DESC)
        $tStmt = $pdo->query("
            SELECT * FROM faculty_activities 
            WHERE is_active = 1 AND category = 'trainings' 
            ORDER BY id DESC
        ");
        $trainings = $tStmt->fetchAll(PDO::FETCH_ASSOC);

        // Expert Lectures: id ASC
        $lStmt = $pdo->query("
            SELECT * FROM faculty_activities 
            WHERE is_active = 1 AND category = 'expert_lectures' 
            ORDER BY id ASC
        ");
        $expertLectures = $lStmt->fetchAll(PDO::FETCH_ASSOC);
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

    <!-- Sub-Navigation Bar (Matches Department Sub-Navbar Style) -->
    <nav class="fac-subnav-bar" id="facSubNav" aria-label="Faculty Activities Navigation">
        <div class="fac-subnav-container">
            <div class="fac-subnav-wrap">
                <ul class="fac-subnav-list" role="tablist">
                    <li class="fac-subnav-item">
                        <button type="button" 
                                class="fac-subnav-link <?= ($activeTab === 'trainings') ? 'is-active' : '' ?>" 
                                id="tabBtnTrainings" 
                                data-tab-target="tabTrainings" 
                                role="tab" 
                                aria-selected="<?= ($activeTab === 'trainings') ? 'true' : 'false' ?>" 
                                aria-controls="tabTrainings">
                            <span>Trainings</span>
                        </button>
                    </li>
                    <li class="fac-subnav-item">
                        <button type="button" 
                                class="fac-subnav-link <?= ($activeTab === 'expert_lectures') ? 'is-active' : '' ?>" 
                                id="tabBtnLectures" 
                                data-tab-target="tabLectures" 
                                role="tab" 
                                aria-selected="<?= ($activeTab === 'expert_lectures') ? 'true' : 'false' ?>" 
                                aria-controls="tabLectures">
                            <span>Expert Lectures</span>
                        </button>
                    </li>
                    <li class="fac-subnav-item">
                        <button type="button" 
                                class="fac-subnav-link <?= ($activeTab === 'conferences') ? 'is-active' : '' ?>" 
                                id="tabBtnConferences" 
                                data-tab-target="tabConferences" 
                                role="tab" 
                                aria-selected="<?= ($activeTab === 'conferences') ? 'true' : 'false' ?>" 
                                aria-controls="tabConferences">
                            <span>Conferences</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Tab Contents Container -->
    <main class="act-container" style="max-width: 1320px; margin: 0 auto; padding: 0 24px;">

        <!-- 1. TRAININGS TAB -->
        <section class="fac-tab-pane <?= ($activeTab === 'trainings') ? 'is-active' : '' ?>" 
                 id="tabTrainings" 
                 role="tabpanel" 
                 aria-labelledby="tabBtnTrainings" 
                 style="<?= ($activeTab === 'trainings') ? '' : 'display: none;' ?>">

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
    // Tab Switching Functionality matching Department Sub-navbar behavior
    const tabLinks = document.querySelectorAll('.fac-subnav-link');
    const tabPanes = document.querySelectorAll('.fac-tab-pane');

    const tabParamMap = {
        'tabTrainings': 'trainings',
        'tabLectures': 'expert_lectures',
        'tabConferences': 'conferences'
    };

    tabLinks.forEach(function (button) {
        button.addEventListener('click', function () {
            const targetPaneId = this.getAttribute('data-tab-target');

            // Deactivate all links
            tabLinks.forEach(function (btn) {
                btn.classList.remove('is-active');
                btn.setAttribute('aria-selected', 'false');
            });

            // Hide all tab panes
            tabPanes.forEach(function (pane) {
                pane.classList.remove('is-active');
                pane.style.display = 'none';
            });

            // Activate clicked link
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
});
</script>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
