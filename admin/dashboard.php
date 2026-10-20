<?php
$current_page = 'dashboard';
$page_title = 'Dashboard Overview';
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();

// Fetch summary counts
$totalNotices = 0;
$totalEvents = 0;
$totalShots = 0;
$totalAlumni = 0;
$totalDepts = 0;
$totalSlides = 0;
$departments = [];
$recentNotices = [];

if ($pdo) {
    try {
        $totalNotices = (int)$pdo->query("SELECT COUNT(*) FROM notices")->fetchColumn();
        $totalEvents = (int)$pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
        $totalShots = (int)$pdo->query("SELECT COUNT(*) FROM latest_shots")->fetchColumn();
        $totalAlumni = (int)$pdo->query("SELECT COUNT(*) FROM alumni")->fetchColumn();
        $totalDepts = (int)$pdo->query("SELECT COUNT(*) FROM departments")->fetchColumn();
        $totalSlides = (int)$pdo->query("SELECT COUNT(*) FROM hero_slides")->fetchColumn();

        $stmtDept = $pdo->query("SELECT * FROM departments ORDER BY display_order ASC");
        $departments = $stmtDept->fetchAll();

        $stmtRecent = $pdo->query("SELECT * FROM notices ORDER BY publish_date DESC, id DESC LIMIT 5");
        $recentNotices = $stmtRecent->fetchAll();
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}
?>

<!-- Metric Stat Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <div class="stat-number"><?= $totalNotices ?></div>
            <div class="stat-label">Notice Board Items</div>
        </div>
        <div class="stat-icon icon-blue">
            <i class="fas fa-bullhorn"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <div class="stat-number"><?= $totalEvents ?></div>
            <div class="stat-label">Recent Events</div>
        </div>
        <div class="stat-icon icon-green">
            <i class="fas fa-calendar-alt"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <div class="stat-number"><?= $totalShots ?></div>
            <div class="stat-label">Campus Shots</div>
        </div>
        <div class="stat-icon icon-purple">
            <i class="fas fa-camera-retro"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <div class="stat-number"><?= $totalAlumni ?></div>
            <div class="stat-label">Proud Alumni</div>
        </div>
        <div class="stat-icon icon-amber">
            <i class="fas fa-user-graduate"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <div class="stat-number"><?= $totalDepts ?></div>
            <div class="stat-label">Departments</div>
        </div>
        <div class="stat-icon icon-cyan">
            <i class="fas fa-graduation-cap"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <div class="stat-number"><?= $totalSlides ?></div>
            <div class="stat-label">Hero Slides</div>
        </div>
        <div class="stat-icon icon-red">
            <i class="fas fa-images"></i>
        </div>
    </div>
</div>

<!-- Branch Summary Card (Exact Layout from Reference Screenshot) -->
<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <i class="fas fa-chart-pie"></i>
            <h2 class="card-title">Branch Summary</h2>
        </div>
        <a href="notices.php" class="btn-add-new">
            <i class="fas fa-plus"></i> Add New Notice
        </a>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="btn-group-export">
            <button type="button" class="btn-export btn-export-excel" data-target-table="branchSummaryTable">
                <i class="fas fa-file-excel"></i> Excel
            </button>
            <button type="button" class="btn-export btn-export-pdf">
                <i class="fas fa-file-pdf"></i> PDF
            </button>
            <button type="button" class="btn-export btn-export-print">
                <i class="fas fa-print"></i> Print
            </button>
        </div>

        <div class="card-filters">
            <label style="font-size: 13px; color: #495057; display: flex; align-items: center; gap: 6px;">
                <i class="far fa-calendar-alt"></i> Batch Year:
                <select class="filter-select">
                    <option value="all">All Batches</option>
                    <option value="2024">2024 - 2025</option>
                    <option value="2023">2023 - 2024</option>
                    <option value="2022">2022 - 2023</option>
                </select>
            </label>

            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search summary..." data-table-search="branchSummaryTable">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="admin-table" id="branchSummaryTable">
            <thead>
                <tr>
                    <th>Branch <i class="fas fa-sort sort-icon"></i></th>
                    <th>Total Students <i class="fas fa-sort sort-icon"></i></th>
                    <th>Applications <i class="fas fa-sort sort-icon"></i></th>
                    <th>Placed <i class="fas fa-sort sort-icon"></i></th>
                    <th>Highest Package <i class="fas fa-sort sort-icon"></i></th>
                    <th>Avg Package <i class="fas fa-sort sort-icon"></i></th>
                    <th>Lowest Package <i class="fas fa-sort sort-icon"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Pre-populated branch statistics matching screenshot and departments table
                $branchStats = [
                    'Computer Engineering' => ['students' => 120, 'apps' => 98, 'placed' => 45, 'highest' => '12.00 LPA', 'avg' => '6.50 LPA', 'lowest' => '4.20 LPA'],
                    'Information Technology' => ['students' => 60, 'apps' => 54, 'placed' => 28, 'highest' => '10.50 LPA', 'avg' => '5.80 LPA', 'lowest' => '3.80 LPA'],
                    'Mechanical Engineering' => ['students' => 120, 'apps' => 85, 'placed' => 32, 'highest' => '8.00 LPA', 'avg' => '4.50 LPA', 'lowest' => '3.20 LPA'],
                    'Automobile Engineering' => ['students' => 60, 'apps' => 42, 'placed' => 18, 'highest' => '7.50 LPA', 'avg' => '4.20 LPA', 'lowest' => '3.00 LPA'],
                    'Civil Engineering' => ['students' => 120, 'apps' => 70, 'placed' => 24, 'highest' => '7.00 LPA', 'avg' => '4.00 LPA', 'lowest' => '3.00 LPA'],
                    'Electrical Engineering' => ['students' => 60, 'apps' => 48, 'placed' => 22, 'highest' => '8.50 LPA', 'avg' => '4.80 LPA', 'lowest' => '3.40 LPA'],
                    'Electronics & Comm.' => ['students' => 60, 'apps' => 50, 'placed' => 26, 'highest' => '9.00 LPA', 'avg' => '5.20 LPA', 'lowest' => '3.60 LPA'],
                ];

                foreach ($departments as $dept):
                    $name = $dept['name'];
                    $stat = $branchStats[$name] ?? ['students' => 60, 'apps' => 40, 'placed' => 15, 'highest' => '6.00 LPA', 'avg' => '4.50 LPA', 'lowest' => '3.20 LPA'];
                ?>
                <tr>
                    <td style="font-weight: 600; color: #1a263d;">
                        <i class="<?= htmlspecialchars($dept['icon_class']) ?>" style="color: #1e88e5; margin-right: 8px;"></i>
                        <?= htmlspecialchars($name) ?>
                    </td>
                    <td><?= $stat['students'] ?></td>
                    <td><?= $stat['apps'] ?></td>
                    <td>
                        <span class="badge badge-count"><?= $stat['placed'] ?></span>
                    </td>
                    <td style="color: #1e88e5; font-weight: 600;"><?= $stat['highest'] ?></td>
                    <td><?= $stat['avg'] ?></td>
                    <td><?= $stat['lowest'] ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($departments)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #888; padding: 24px;">No branch records found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Notices Quick View -->
<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <i class="fas fa-bullhorn"></i>
            <h2 class="card-title">Recent Notice Board Updates</h2>
        </div>
        <a href="notices.php" style="font-size: 13px; font-weight: 600; color: #1e88e5;">
            Manage All Notices <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Notice Title</th>
                    <th>Category</th>
                    <th>Badge</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentNotices as $notice): ?>
                <tr>
                    <td style="white-space: nowrap;"><?= htmlspecialchars($notice['publish_date']) ?></td>
                    <td style="font-weight: 500;"><?= htmlspecialchars($notice['title']) ?></td>
                    <td><span class="badge badge-secondary"><?= htmlspecialchars($notice['category']) ?></span></td>
                    <td>
                        <?php if ($notice['badge'] === 'New'): ?>
                            <span class="badge badge-success">New</span>
                        <?php elseif ($notice['badge'] === 'Urgent'): ?>
                            <span class="badge badge-danger">Urgent</span>
                        <?php else: ?>
                            <span style="color: #999;">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($notice['is_active']): ?>
                            <span class="badge badge-success">Active</span>
                        <?php else: ?>
                            <span class="badge badge-secondary">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="notices.php?edit=<?= $notice['id'] ?>" class="btn-table-action btn-edit" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
