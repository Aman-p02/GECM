<?php
/**
 * Shared Dynamic Advisory Board Component for Department Pages
 *
 * Requirements:
 * - $deptCode (string): e.g. 'IT', 'CE', 'CIVIL', 'ME', 'AE', 'AM', etc.
 * - $deptName (string): e.g. 'Computer Engineering'
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

$boardDocs = [];
$yearCounts = [];
$totalDocs = 0;

if (isset($pdo) && $pdo) {
    try {
        $stmt = $pdo->prepare("
            SELECT * FROM department_advisory_board 
            WHERE dept_code = ? AND is_active = 1 
            ORDER BY display_order ASC, id DESC
        ");
        $stmt->execute([$deptCode]);
        $boardDocs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $totalDocs = count($boardDocs);

        foreach ($boardDocs as $doc) {
            $yr = trim($doc['academic_year'] ?: '');
            if (!empty($yr)) {
                $yearCounts[$yr] = ($yearCounts[$yr] ?? 0) + 1;
            }
        }
        krsort($yearCounts);
    } catch (Exception $e) {
        error_log("Dept Advisory Board Query Error ($deptCode): " . $e->getMessage());
    }
}
$boardPaneId = $boardPaneId ?? 'tab-advisory-board';
?>

<!-- Tab: Advisory Board -->
<section class="dept-tab-pane" id="<?= htmlspecialchars($boardPaneId) ?>">
    <div class="dept-section-header">
        <span class="dept-section-kicker">GOVERNANCE &amp; STRATEGY</span>
        <h2>Department Advisory Board (DAB)</h2>
        <p>Official constitution, minutes of meetings, and advisory guidelines guiding academic excellence and industry relevance for <?= htmlspecialchars($deptName) ?>.</p>
    </div>

    <div class="dept-board-wrapper">
        <?php if (empty($boardDocs)): ?>
            <div style="background: var(--dept-bg-subtle, #f8fafc); border: 1px solid var(--dept-border, #e2e8f0); border-radius: 6px; padding: 48px 24px; text-align: center; color: var(--dept-muted, #64748b); margin-top: 24px;">
                <i class="fas fa-file-pdf" style="font-size: 36px; color: var(--dept-muted, #94a3b8); margin-bottom: 12px; display: block;"></i>
                <p style="font-size: 15px; margin: 0 0 6px 0; font-weight: 600; color: #1e293b;">Advisory Board Documents Updating</p>
                <p style="font-size: 13.5px; margin: 0; color: var(--dept-muted, #64748b);">No advisory board documents have been published for this department yet.</p>
            </div>
        <?php else: ?>
            <!-- Advisory Board Filter Toolbar -->
            <?php if (!empty($yearCounts) && count($yearCounts) > 1): ?>
            <div class="dept-board-toolbar">
                <div class="dept-board-filter-wrap">
                    <label for="boardYearFilter_<?= htmlspecialchars($deptCode) ?>" class="dept-board-filter-label">
                        <i class="fas fa-filter"></i> Academic Year:
                    </label>
                    <div class="dept-board-select-box">
                        <select id="boardYearFilter_<?= htmlspecialchars($deptCode) ?>" class="dept-board-select" aria-label="Filter documents by academic year" onchange="filterDeptBoard(this.value, '<?= htmlspecialchars($deptCode) ?>')">
                            <option value="all">All Documents (<?= $totalDocs ?>)</option>
                            <?php foreach ($yearCounts as $yr => $cnt): ?>
                                <option value="<?= htmlspecialchars($yr) ?>"><?= htmlspecialchars($yr) ?> (<?= $cnt ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fas fa-chevron-down dept-board-arrow"></i>
                    </div>
                </div>
                <div class="dept-board-badge" id="boardCountBadge_<?= htmlspecialchars($deptCode) ?>">
                    Showing <strong><?= $totalDocs ?></strong> document<?= $totalDocs > 1 ? 's' : '' ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="dept-board-grid" id="boardList_<?= htmlspecialchars($deptCode) ?>">
                <!-- Empty filter state notice -->
                <div class="dept-board-empty" id="boardEmptyState_<?= htmlspecialchars($deptCode) ?>" style="display: none;">
                    <i class="far fa-folder-open"></i>
                    No documents found for the selected academic year.
                </div>

                <?php foreach ($boardDocs as $doc): 
                    $yrAttr = trim($doc['academic_year'] ?: '');
                    $pdfUrl = htmlspecialchars($root_path . ltrim($doc['pdf_file'], '/'));
                ?>
                    <article class="dept-board-card" data-year="<?= htmlspecialchars($yrAttr) ?>">
                        <div class="dept-board-card-body">
                            <div class="dept-board-icon-box" aria-hidden="true">
                                <i class="fas fa-file-pdf"></i>
                                <span class="dept-board-icon-label">PDF</span>
                            </div>
                            <div class="dept-board-info">
                                <h3 class="dept-board-title"><?= htmlspecialchars($doc['title']) ?></h3>
                                <?php if (!empty($doc['academic_year'])): ?>
                                    <div class="dept-board-meta">
                                        <span class="dept-board-year-tag">
                                            <i class="far fa-calendar-alt"></i> <?= htmlspecialchars($doc['academic_year']) ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="dept-board-footer">
                            <a href="<?= $pdfUrl ?>" target="_blank" rel="noopener noreferrer" class="dept-board-btn" title="Open <?= htmlspecialchars($doc['title']) ?> in new tab">
                                <span>View PDF</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
function filterDeptBoard(year, deptCode) {
    var container = document.getElementById('boardList_' + deptCode);
    if (!container) return;
    var cards = container.querySelectorAll('.dept-board-card');
    var emptyNotice = document.getElementById('boardEmptyState_' + deptCode);
    var badge = document.getElementById('boardCountBadge_' + deptCode);
    var visible = 0;

    cards.forEach(function(card) {
        var cardYr = card.getAttribute('data-year');
        if (year === 'all' || cardYr === year) {
            card.style.display = '';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    if (emptyNotice) {
        emptyNotice.style.display = visible === 0 ? 'block' : 'none';
    }
    if (badge) {
        badge.innerHTML = 'Showing <strong>' + visible + '</strong> document' + (visible !== 1 ? 's' : '');
    }
}
</script>
