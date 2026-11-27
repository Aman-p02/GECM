<?php
/**
 * GEC MODASA - Super Admin Most Visited Pages & Separate Visitors Analytics
 */
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$loggedAdmin = getLoggedInAdmin();
if (($loggedAdmin['role'] ?? '') !== 'super_admin') {
    setFlashMessage('danger', 'Access denied. Only Super Admin can view visitor analytics.');
    header('Location: dashboard');
    exit;
}

$pdo = getDBConnection();

$selectedPageId = isset($_GET['page_id']) ? (int)$_GET['page_id'] : 0;
$searchQuery = trim((string)($_GET['q'] ?? ''));
$currentPageNum = max(1, (int)($_GET['p'] ?? 1));
$perPage = 25;
$offset = ($currentPageNum - 1) * $perPage;

$summary = [
    'total_unique_visitors' => 0,
    'total_page_views'      => 0,
    'tracked_pages'         => 0,
    'top_page_title'        => 'No data yet',
    'top_page_unique'       => 0
];

$pagesList = [];
$totalPagesCount = 0;

$selectedPage = null;
$pageVisitors = [];
$totalVisitorsForPage = 0;

if ($pdo) {
    try {
        // Overall stats summary
        $statRow = $pdo->query("SELECT total_unique_visitors, total_page_views FROM site_visitor_stats WHERE id = 1 LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        if ($statRow) {
            $summary['total_unique_visitors'] = (int)$statRow['total_unique_visitors'];
            $summary['total_page_views'] = (int)$statRow['total_page_views'];
        }

        $summary['tracked_pages'] = (int)$pdo->query("SELECT COUNT(*) FROM page_analytics")->fetchColumn();

        $topRow = $pdo->query("SELECT page_title, page_path, unique_visitors FROM page_analytics ORDER BY unique_visitors DESC, total_views DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        if ($topRow) {
            $summary['top_page_title'] = $topRow['page_title'] ?: $topRow['page_path'];
            $summary['top_page_unique'] = (int)$topRow['unique_visitors'];
        }

        if ($selectedPageId > 0) {
            // Mode 2: Separate visitors list for a specific page
            $stmtPage = $pdo->prepare("SELECT * FROM page_analytics WHERE id = ? LIMIT 1");
            $stmtPage->execute([$selectedPageId]);
            $selectedPage = $stmtPage->fetch(PDO::FETCH_ASSOC);

            if ($selectedPage) {
                $whereClause = " WHERE pvl.page_id = ?";
                $params = [$selectedPageId];

                if ($searchQuery !== '') {
                    $like = '%' . $searchQuery . '%';
                    $whereClause .= " AND (LEFT(sv.visitor_token_hash, 8) LIKE ? OR sv.device_type LIKE ? OR sv.browser LIKE ? OR sv.os LIKE ?)";
                    $params = array_merge($params, [$like, $like, $like, $like]);
                }

                $stmtCnt = $pdo->prepare(
                    "SELECT COUNT(*) FROM page_visitor_logs pvl
                     INNER JOIN site_visitors sv ON sv.id = pvl.visitor_id" . $whereClause
                );
                $stmtCnt->execute($params);
                $totalVisitorsForPage = (int)$stmtCnt->fetchColumn();

                $stmtVisitors = $pdo->prepare(
                    "SELECT sv.id AS visitor_id,
                            UPPER(LEFT(sv.visitor_token_hash, 8)) AS visitor_code,
                            sv.device_type,
                            sv.browser,
                            sv.os,
                            pvl.first_visited_at,
                            pvl.last_visited_at,
                            pvl.hit_count
                     FROM page_visitor_logs pvl
                     INNER JOIN site_visitors sv ON sv.id = pvl.visitor_id"
                    . $whereClause .
                    " ORDER BY pvl.last_visited_at DESC, pvl.id DESC
                      LIMIT ? OFFSET ?"
                );

                $bindIndex = 1;
                foreach ($params as $pVal) {
                    $stmtVisitors->bindValue($bindIndex++, $pVal, is_int($pVal) ? PDO::PARAM_INT : PDO::PARAM_STR);
                }
                $stmtVisitors->bindValue($bindIndex++, $perPage, PDO::PARAM_INT);
                $stmtVisitors->bindValue($bindIndex, $offset, PDO::PARAM_INT);
                $stmtVisitors->execute();
                $pageVisitors = $stmtVisitors->fetchAll(PDO::FETCH_ASSOC);
            } else {
                setFlashMessage('danger', 'Selected page record was not found.');
                header('Location: most-visited-pages');
                exit;
            }
        } else {
            // Mode 1: Overall Most Visited Pages Ranking
            $whereClause = "";
            $params = [];

            if ($searchQuery !== '') {
                $like = '%' . $searchQuery . '%';
                $whereClause = " WHERE page_path LIKE ? OR page_title LIKE ?";
                $params = [$like, $like];
            }

            $stmtCnt = $pdo->prepare("SELECT COUNT(*) FROM page_analytics" . $whereClause);
            $stmtCnt->execute($params);
            $totalPagesCount = (int)$stmtCnt->fetchColumn();

            $stmtPages = $pdo->prepare(
                "SELECT id, page_path, page_title, unique_visitors, total_views, last_visited_at
                 FROM page_analytics"
                . $whereClause .
                " ORDER BY unique_visitors DESC, total_views DESC, last_visited_at DESC
                  LIMIT ? OFFSET ?"
            );

            $bindIndex = 1;
            foreach ($params as $pVal) {
                $stmtPages->bindValue($bindIndex++, $pVal, PDO::PARAM_STR);
            }
            $stmtPages->bindValue($bindIndex++, $perPage, PDO::PARAM_INT);
            $stmtPages->bindValue($bindIndex, $offset, PDO::PARAM_INT);
            $stmtPages->execute();
            $pagesList = $stmtPages->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (Exception $e) {
        error_log("Analytics fetch error: " . $e->getMessage());
    }
}

$current_page = 'most-visited-pages';
$page_title = $selectedPage ? 'Page Visitors Detail' : 'Most Visited Pages';
require_once __DIR__ . '/includes/header.php';

/**
 * Helper to build clean public preview URL respecting localhost subfolder or root domain.
 */
$publicBasePrefix = preg_replace('#/admin(/.*)?$#i', '', $adminBaseUrl);
if ($publicBasePrefix === '') {
    $publicBasePrefix = '';
}
?>

<style>
.analytics-row-clickable {
    cursor: pointer;
    transition: background-color 0.15s ease;
}
.analytics-row-clickable:hover {
    background-color: #fff7ed !important;
}
.analytics-badge-unique {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 999px;
    background: #fff7ed;
    border: 1px solid #fed7aa;
    color: #c2410c;
    font-weight: 700;
    font-size: 12.5px;
}
.analytics-badge-device {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
}
.analytics-pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    padding: 16px 24px;
    border-top: 1px solid var(--admin-border-color);
    background: #f8fafc;
}
.analytics-page-btn {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #0f172a;
    font-size: 12.5px;
    font-weight: 600;
    text-decoration: none;
}
.analytics-page-btn.active {
    background: #ff8800;
    border-color: #ff8800;
    color: #ffffff;
}
</style>

<div class="admin-card">
    <!-- Top Bar -->
    <div class="card-top" style="justify-content: space-between; padding: 16px 24px; border-bottom: 1px solid var(--admin-border-color); background: #ffffff; flex-wrap: wrap; gap: 12px;">
        <?php if ($selectedPage): ?>
            <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                <a href="most-visited-pages" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; text-decoration: none; padding: 7px 14px; border-radius: 6px; font-weight: 600;">
                    <i class="fas fa-arrow-left"></i> Back to Most Visited Pages
                </a>
                <div>
                    <div style="font-weight: 800; font-size: 15px; color: #0f172a;">
                        <?= htmlspecialchars($selectedPage['page_title']) ?>
                    </div>
                    <div style="font-size: 12px; color: #64748b; font-family: monospace;">
                        <?= htmlspecialchars($selectedPage['page_path']) ?>
                    </div>
                </div>
            </div>
            <a href="<?= htmlspecialchars($publicBasePrefix . $selectedPage['page_path']) ?>" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 7px; font-size: 12.5px; text-decoration: none; padding: 7px 14px; border-radius: 6px; font-weight: 600;">
                <i class="fas fa-external-link-alt" style="color: #ff8800;"></i> Open Page
            </a>
        <?php else: ?>
            <div style="font-size: 13px; color: #475569; font-weight: 600;">
                <i class="fas fa-chart-line" style="color: #ff8800; margin-right: 6px;"></i>
                Overall Unique Visitors &amp; Page Traffic (Click any page to view its separate visitors)
            </div>
            <a href="../" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 7px; font-size: 12.5px; text-decoration: none; padding: 7px 14px; border-radius: 6px; font-weight: 600;">
                <i class="fas fa-globe" style="color: #ff8800;"></i> View Public Website
            </a>
        <?php endif; ?>
    </div>

    <!-- Summary Cards -->
    <div style="padding: 20px 24px 8px 24px;">
        <?php if ($selectedPage): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 14px; margin-bottom: 16px;">
                <div style="background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px; padding: 14px 18px;">
                    <div style="font-size: 12px; font-weight: 700; color: #c2410c; text-transform: uppercase;">Page Unique Visitors</div>
                    <div style="font-size: 26px; font-weight: 800; color: #9a3412; margin-top: 4px;"><?= number_format((int)$selectedPage['unique_visitors']) ?></div>
                </div>
                <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 14px 18px;">
                    <div style="font-size: 12px; font-weight: 700; color: #0369a1; text-transform: uppercase;">Total Views on Page</div>
                    <div style="font-size: 26px; font-weight: 800; color: #0c4a6e; margin-top: 4px;"><?= number_format((int)$selectedPage['total_views']) ?></div>
                </div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px;">
                    <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Last Visited</div>
                    <div style="font-size: 16px; font-weight: 700; color: #0f172a; margin-top: 8px;">
                        <?= date('d M Y, h:i A', strtotime($selectedPage['last_visited_at'])) ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 14px; margin-bottom: 16px;">
                <div style="background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px; padding: 14px 18px;">
                    <div style="font-size: 12px; font-weight: 700; color: #c2410c; text-transform: uppercase;">Overall Unique Visitors</div>
                    <div style="font-size: 26px; font-weight: 800; color: #9a3412; margin-top: 4px;"><?= number_format($summary['total_unique_visitors']) ?></div>
                </div>
                <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 14px 18px;">
                    <div style="font-size: 12px; font-weight: 700; color: #0369a1; text-transform: uppercase;">Overall Page Views</div>
                    <div style="font-size: 26px; font-weight: 800; color: #0c4a6e; margin-top: 4px;"><?= number_format($summary['total_page_views']) ?></div>
                </div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px;">
                    <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase;">Tracked Pages</div>
                    <div style="font-size: 26px; font-weight: 800; color: #0f172a; margin-top: 4px;"><?= number_format($summary['tracked_pages']) ?></div>
                </div>
                <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 8px; padding: 14px 18px;">
                    <div style="font-size: 12px; font-weight: 700; color: #047857; text-transform: uppercase;">Top Visited Page</div>
                    <div style="font-size: 14.5px; font-weight: 700; color: #064e3b; margin-top: 6px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($summary['top_page_title']) ?>">
                        <?= htmlspecialchars($summary['top_page_title']) ?>
                    </div>
                    <div style="font-size: 12px; color: #047857; font-weight: 600; margin-top: 2px;">
                        <?= number_format($summary['top_page_unique']) ?> unique visitors
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Search Row -->
    <div class="card-actions-row" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; padding: 0 24px 16px 24px;">
        <form method="GET" action="most-visited-pages" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap; width: 100%; justify-content: space-between;">
            <?php if ($selectedPage): ?>
                <input type="hidden" name="page_id" value="<?= (int)$selectedPage['id'] ?>">
            <?php endif; ?>
            <div style="font-size: 13px; color: #64748b;">
                <?php if ($selectedPage): ?>
                    Showing unique visitors for this page (<?= number_format($totalVisitorsForPage) ?> total).
                <?php else: ?>
                    Showing overall ranked pages (<?= number_format($totalPagesCount) ?> tracked).
                <?php endif; ?>
            </div>
            <div style="display: flex; gap: 8px; align-items: center;">
                <div class="search-input-group">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" class="search-input" value="<?= htmlspecialchars($searchQuery) ?>"
                           placeholder="<?= $selectedPage ? 'Search visitor ID, browser, OS...' : 'Search page URL or title...' ?>">
                </div>
                <button type="submit" class="btn btn-primary btn-sm" style="padding: 7px 14px; font-size: 12.5px; font-weight: 700;">Search</button>
                <?php if ($searchQuery !== ''): ?>
                    <a href="most-visited-pages<?= $selectedPage ? '?page_id=' . (int)$selectedPage['id'] : '' ?>" class="btn btn-secondary btn-sm" style="padding: 7px 12px; font-size: 12px; text-decoration: none;">Reset</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Main Table -->
    <div class="table-responsive">
        <?php if ($selectedPage): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">#</th>
                        <th style="width: 170px;">Visitor ID</th>
                        <th style="width: 140px;">Device Type</th>
                        <th>Browser &amp; OS</th>
                        <th style="width: 175px;">First Visited Page</th>
                        <th style="width: 175px;">Last Visited Page</th>
                        <th style="width: 110px; text-align: center;">Total Hits</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pageVisitors)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 36px; color: #64748b;">
                                No visitors recorded for this page yet.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($pageVisitors as $idx => $vis): ?>
                        <?php
                        $srNo = $offset + $idx + 1;
                        $devIcon = 'fa-desktop';
                        $devBg = '#f1f5f9';
                        $devColor = '#334155';
                        if ($vis['device_type'] === 'Mobile') {
                            $devIcon = 'fa-mobile-alt';
                            $devBg = '#fff7ed';
                            $devColor = '#c2410c';
                        } elseif ($vis['device_type'] === 'Tablet') {
                            $devIcon = 'fa-tablet-alt';
                            $devBg = '#e0f2fe';
                            $devColor = '#0369a1';
                        }
                        ?>
                        <tr>
                            <td style="font-weight: 700; color: #64748b;"><?= $srNo ?></td>
                            <td>
                                <span style="font-family: monospace; font-weight: 700; color: #0f172a; background: #f8fafc; border: 1px solid #cbd5e1; padding: 3px 8px; border-radius: 5px; font-size: 12.5px;">
                                    #VIS-<?= htmlspecialchars($vis['visitor_code']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="analytics-badge-device" style="background: <?= $devBg ?>; color: <?= $devColor ?>;">
                                    <i class="fas <?= $devIcon ?>"></i>
                                    <?= htmlspecialchars($vis['device_type']) ?>
                                </span>
                            </td>
                            <td style="font-weight: 600; color: #1e293b;">
                                <?= htmlspecialchars($vis['browser']) ?>
                                <span style="color: #94a3b8; margin: 0 4px;">/</span>
                                <span style="color: #475569; font-weight: 500;"><?= htmlspecialchars($vis['os']) ?></span>
                            </td>
                            <td style="font-size: 12.5px; color: #475569;">
                                <?= date('d M Y, h:i A', strtotime($vis['first_visited_at'])) ?>
                            </td>
                            <td style="font-size: 12.5px; color: #0f172a; font-weight: 600;">
                                <?= date('d M Y, h:i A', strtotime($vis['last_visited_at'])) ?>
                            </td>
                            <td style="text-align: center;">
                                <span style="display: inline-block; min-width: 34px; padding: 3px 9px; border-radius: 999px; background: #e0f2fe; color: #0369a1; font-weight: 700; font-size: 12px;">
                                    <?= (int)$vis['hit_count'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">Rank</th>
                        <th>Page Title &amp; URL Path</th>
                        <th style="width: 170px; text-align: center;">Unique Visitors</th>
                        <th style="width: 140px; text-align: center;">Total Views</th>
                        <th style="width: 180px;">Last Visited</th>
                        <th style="width: 170px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pagesList)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 36px; color: #64748b;">
                                No page visits recorded yet. Open pages on the public website to collect overall visitor stats.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($pagesList as $idx => $pg): ?>
                        <?php
                        $rank = $offset + $idx + 1;
                        $detailUrl = 'most-visited-pages?page_id=' . (int)$pg['id'];
                        ?>
                        <tr class="analytics-row-clickable" onclick="window.location.href='<?= htmlspecialchars($detailUrl) ?>'">
                            <td style="font-weight: 800; color: <?= ($rank <= 3) ? '#ff8800' : '#64748b' ?>; font-size: 14px;">
                                #<?= $rank ?>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a; font-size: 13.5px;">
                                    <?= htmlspecialchars($pg['page_title']) ?>
                                </div>
                                <div style="font-size: 12px; color: #64748b; font-family: monospace; margin-top: 2px;">
                                    <?= htmlspecialchars($pg['page_path']) ?>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <span class="analytics-badge-unique">
                                    <i class="fas fa-user-check"></i>
                                    <?= number_format((int)$pg['unique_visitors']) ?>
                                </span>
                            </td>
                            <td style="text-align: center; font-weight: 700; color: #334155;">
                                <?= number_format((int)$pg['total_views']) ?>
                            </td>
                            <td style="font-size: 12.5px; color: #475569;">
                                <?= date('d M Y, h:i A', strtotime($pg['last_visited_at'])) ?>
                            </td>
                            <td style="text-align: center;" onclick="event.stopPropagation();">
                                <a href="<?= htmlspecialchars($detailUrl) ?>" class="btn btn-primary btn-sm" style="background: #111827; border-color: #111827; color: #ffffff; padding: 6px 12px; font-size: 12px; font-weight: 700; text-decoration: none; border-radius: 6px; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-users" style="color: #ff8800;"></i> View Visitors
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Pagination & Scope Footer -->
    <?php
    $totalRecords = $selectedPage ? $totalVisitorsForPage : $totalPagesCount;
    $totalPaginationPages = max(1, (int)ceil($totalRecords / $perPage));
    $basePageLink = 'most-visited-pages?' . ($selectedPage ? 'page_id=' . (int)$selectedPage['id'] . '&' : '') . ($searchQuery !== '' ? 'q=' . urlencode($searchQuery) . '&' : '');
    ?>
    <div class="analytics-pagination">
        <div style="font-size: 12px; color: #64748b;">
            Showing overall analytics. Day-wise, Month-wise &amp; Year-wise breakdowns can be added in Phase 2.
        </div>
        <?php if ($totalPaginationPages > 1): ?>
            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                <?php for ($i = 1; $i <= $totalPaginationPages; $i++): ?>
                    <a href="<?= htmlspecialchars($basePageLink . 'p=' . $i) ?>" class="analytics-page-btn <?= ($i === $currentPageNum) ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
