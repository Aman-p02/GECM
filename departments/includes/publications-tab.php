<?php
/**
 * Shared Dynamic Publications Component for Department Pages
 *
 * Requirements:
 * - $deptCode (string): e.g. 'IT', 'CE', 'CIVIL', 'ME', 'AE', 'AM', etc.
 * - $deptName (string): e.g. 'Information Technology'
 * - $root_path (string): relative path to root, e.g. '../../'
 */

if (!isset($pdo) || !$pdo) {
    if (file_exists(__DIR__ . '/../../includes/db.php')) {
        require_once __DIR__ . '/../../includes/db.php';
        $pdo = getDBConnection();
    } elseif (file_exists(__DIR__ . '/../includes/db.php')) {
        require_once __DIR__ . '/../includes/db.php';
        $pdo = getDBConnection();
    }
}

$deptCode = $deptCode ?? 'CE';
$deptName = $deptName ?? 'Department';
$root_path = $root_path ?? '../../';

$deptPublications = [];
$yearCounts = [];
$totalPubs = 0;

if (isset($pdo) && $pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT * FROM department_publications 
            WHERE dept_code = ? AND is_active = 1 
            ORDER BY display_order ASC, pub_year DESC, id DESC
        ");
        $stmt->execute([$deptCode]);
        $deptPublications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $totalPubs = count($deptPublications);

        foreach ($deptPublications as $p) {
            $yr = trim($p['pub_year'] ?: '');
            if (empty($yr) && preg_match('/\b(20\d\d|19\d\d)\b/', $p['pub_date'], $m)) {
                $yr = $m[1];
            }
            if (!empty($yr)) {
                $yearCounts[$yr] = ($yearCounts[$yr] ?? 0) + 1;
            }
        }
        krsort($yearCounts);
    } catch (Exception $e) {
        error_log("Dept Publications Query Error ($deptCode): " . $e->getMessage());
    }
}
?>

<!-- Tab: Research Publications -->
<section class="dept-tab-pane" id="tab-publications">
    <div class="dept-section-header">
        <span class="dept-section-kicker">SCHOLARLY OUTPUT</span>
        <h2>Faculty Publications</h2>
        <p>Research contributions, journal articles, and conference proceedings published by <?= htmlspecialchars($deptName) ?> faculty and research scholars.</p>
    </div>

    <?php if (empty($deptPublications)): ?>
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 48px 24px; text-align: center; color: #64748b; margin-top: 24px;">
            <i class="fas fa-book-open" style="font-size: 38px; color: #94a3b8; margin-bottom: 14px; display: block;"></i>
            <p style="font-size: 16px; margin: 0 0 6px 0; font-weight: 600; color: #334155;">Publications Updating</p>
            <p style="font-size: 14px; margin: 0; color: #64748b;">No research publications have been recorded for this department yet.</p>
        </div>
    <?php else: ?>
        <!-- Publications Filter Toolbar -->
        <div class="dept-pub-toolbar">
            <div class="dept-pub-filter-wrap">
                <label for="pubYearFilter_<?= htmlspecialchars($deptCode) ?>" class="dept-pub-filter-label">
                    <i class="fas fa-calendar-alt"></i> Filter by Year:
                </label>
                <div class="dept-pub-select-box">
                    <select id="pubYearFilter_<?= htmlspecialchars($deptCode) ?>" class="dept-pub-select" aria-label="Filter publications by year" onchange="filterDeptPubs(this.value, '<?= htmlspecialchars($deptCode) ?>')">
                        <option value="all">All Years (<?= $totalPubs ?>)</option>
                        <?php foreach ($yearCounts as $yr => $cnt): ?>
                            <option value="<?= htmlspecialchars($yr) ?>"><?= htmlspecialchars($yr) ?> (<?= $cnt ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-chevron-down dept-pub-arrow"></i>
                </div>
            </div>
            <div class="dept-pub-badge" id="pubCountBadge_<?= htmlspecialchars($deptCode) ?>">
                Showing <strong><?= $totalPubs ?></strong> publications
            </div>
        </div>

        <div class="dept-citations-list" id="pubList_<?= htmlspecialchars($deptCode) ?>">
            <!-- Empty filter state notice -->
            <div class="dept-pub-empty" id="pubEmptyState_<?= htmlspecialchars($deptCode) ?>" style="display: none;">
                <i class="far fa-folder-open"></i>
                No publications found for the selected year.
            </div>

            <?php foreach ($deptPublications as $pub): 
                $yrAttr = trim($pub['pub_year'] ?: '');
                if (empty($yrAttr) && preg_match('/\b(20\d\d|19\d\d)\b/', $pub['pub_date'], $m)) {
                    $yrAttr = $m[1];
                }
            ?>
                <!-- Publication Item -->
                <div class="dept-citation-item" data-year="<?= htmlspecialchars($yrAttr) ?>">
                    <h3 class="dept-citation-title">
                        <?php if (!empty($pub['paper_url'])): ?>
                            <a href="<?= htmlspecialchars($pub['paper_url']) ?>" target="_blank" rel="noopener noreferrer">
                                <?= htmlspecialchars($pub['title']) ?>
                            </a>
                        <?php else: ?>
                            <?= htmlspecialchars($pub['title']) ?>
                        <?php endif; ?>
                    </h3>

                    <div class="dept-citation-meta">
                        <span class="dept-citation-authors">
                            <i class="fas fa-user"></i>
                            <span><?= htmlspecialchars($pub['authors']) ?></span>
                        </span>

                        <span class="dept-citation-date" title="Year: <?= htmlspecialchars($yrAttr) ?>">
                            <i class="far fa-calendar-alt"></i>
                            <span><?= htmlspecialchars($pub['pub_date'] ?: ($pub['pub_year'] ?: ' - ')) ?></span>
                        </span>
                    </div>

                    <?php if (!empty($pub['journal_details'])): ?>
                        <div class="dept-citation-journal">
                            <?= htmlspecialchars($pub['journal_details']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- Filter Script -->
<script>
function filterDeptPubs(selectedYear, deptCode) {
    const list = document.getElementById('pubList_' + deptCode);
    if (!list) return;

    const items = list.querySelectorAll('.dept-citation-item');
    const emptyState = document.getElementById('pubEmptyState_' + deptCode);
    const countBadge = document.getElementById('pubCountBadge_' + deptCode);
    
    let visible = 0;

    items.forEach(item => {
        const itemYear = item.getAttribute('data-year');
        if (selectedYear === 'all' || itemYear === selectedYear) {
            item.style.display = 'flex';
            visible++;
        } else {
            item.style.display = 'none';
        }
    });

    if (emptyState) {
        emptyState.style.display = visible === 0 ? 'block' : 'none';
    }

    if (countBadge) {
        countBadge.innerHTML = `Showing <strong>${visible}</strong> publications`;
    }
}
</script>
