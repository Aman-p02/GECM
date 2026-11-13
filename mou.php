<?php
$page_title = "Memorandums of Understanding (MoU) :: Government Engineering College, Modasa";
$active_page = 'about';
$extra_css = 'css/mou.css';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

$mous = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM institute_mous WHERE is_active = 1 ORDER BY display_order ASC, id DESC");
    $mous = $stmt ? $stmt->fetchAll() : [];
}
?>

<div class="mou-page-wrapper">
    <div class="mou-container">
        
        <!-- Header & Breadcrumbs -->
        <div class="mou-header">
            <div>
                <h1 class="mou-title">Memorandums of Understanding (MoU)</h1>
                <p class="mou-subtitle">Strategic partnerships signed with industrial enterprises, academic institutions, and research centers to empower student learning and innovation.</p>
            </div>
            <div class="mou-breadcrumbs">
                <a href="index.php" title="Home"><i class="fas fa-home"></i></a>
                <span class="sep">/</span>
                <a href="overview.php">About</a>
                <span class="sep">/</span>
                <span>MoU</span>
            </div>
        </div>

        <?php if (empty($mous)): ?>
            <div class="mou-empty-state">
                <i class="fas fa-handshake"></i>
                <h3 style="font-size: 18px; font-weight: 600; color: #334155; margin: 0 0 8px 0;">MoU Directory Being Updated</h3>
                <p style="font-size: 14px; margin: 0;">Institutional collaboration agreements and signed MoUs are currently being updated and will be published here shortly.</p>
            </div>
        <?php else: ?>
            <div class="mou-table-card">
                <div class="mou-table-wrap">
                    <table class="mou-table">
                        <thead>
                            <tr>
                                <th style="width: 60px;">Sr. No.</th>
                                <th>Collaboration / MoU Title</th>
                                <th>Partner Organization</th>
                                <th>Type / Domain</th>
                                <th>Validity Period</th>
                                <th style="width: 160px; text-align: center;">Official Document</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mous as $idx => $m): ?>
                                <tr>
                                    <td style="font-weight: 600; text-align: center;"><?= $idx + 1 ?></td>
                                    <td style="font-weight: 600; color: #1e293b;">
                                        <?= htmlspecialchars($m['title']) ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-building" style="color: #94a3b8; margin-right: 6px;"></i>
                                        <?= htmlspecialchars($m['partner_organization'] ?? '-') ?>
                                    </td>
                                    <td>
                                        <span class="mou-category-badge">
                                            <?= htmlspecialchars($m['category'] ?? 'Industry') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-alt" style="color: #94a3b8; margin-right: 4px;"></i>
                                        <?= htmlspecialchars($m['validity_period'] ?? 'Active') ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="<?= htmlspecialchars($m['file_path']) ?>" target="_blank" class="mou-download-btn">
                                            <i class="fas fa-file-pdf"></i> View MoU (<?= htmlspecialchars($m['file_size'] ?? 'PDF') ?>)
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

