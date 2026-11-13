<?php
$page_title = "Institute E-Newsletters :: Government Engineering College, Modasa";
$active_page = 'about';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

$newsletters = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM institute_newsletters WHERE is_active = 1 ORDER BY id DESC");
    $newsletters = $stmt ? $stmt->fetchAll() : [];
}
?>

<div style="background: #f8fafc; padding: 40px 0 60px 0; min-height: 75vh;">
    <div class="container" style="max-width: 1140px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Breadcrumb & Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 16px; margin-bottom: 28px; flex-wrap: wrap; gap: 12px;">
            <div>
                <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0 0 6px 0;">Institute E-Newsletters</h1>
                <p style="font-size: 14px; color: #64748b; margin: 0;">Official periodic newsletter publications capturing achievements, events, faculty research, and campus life.</p>
            </div>
            <div style="font-size: 13px; color: #64748b;">
                <a href="index.php" style="color: #0284c7; text-decoration: none;"><i class="fas fa-home"></i></a>
                <span style="color: #cbd5e1; margin: 0 6px;">/</span>
                <a href="overview.php" style="color: #0284c7; text-decoration: none;">About</a>
                <span style="color: #cbd5e1; margin: 0 6px;">/</span>
                <span>E-Newsletters</span>
            </div>
        </div>

        <?php if (empty($newsletters)): ?>
            <div style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 48px 24px; text-align: center; color: #64748b; margin: 30px 0;">
                <i class="fas fa-newspaper" style="font-size: 40px; color: #94a3b8; margin-bottom: 14px; display: block;"></i>
                <h3 style="font-size: 18px; font-weight: 600; color: #334155; margin: 0 0 8px 0;">E-Newsletters in Progress</h3>
                <p style="font-size: 14px; margin: 0;">New editions of the institutional newsletter are currently being compiled and will be available for download shortly.</p>
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
                <?php foreach ($newsletters as $nl): ?>
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.05); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                <div style="width: 44px; height: 44px; background: #eff6ff; color: #0284c7; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                    <i class="fas fa-book-reader"></i>
                                </div>
                                <?php if (!empty($nl['issue_period'])): ?>
                                    <span style="background: #e0f2fe; color: #0369a1; font-size: 11.5px; font-weight: 700; padding: 3px 8px; border-radius: 12px;">
                                        <?= htmlspecialchars($nl['issue_period']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 8px 0; line-height: 1.4;">
                                <?= htmlspecialchars($nl['title']) ?>
                            </h3>
                            <div style="font-size: 12.5px; color: #64748b; margin-bottom: 18px;">
                                <i class="fas fa-paperclip"></i> Size: <?= htmlspecialchars($nl['file_size'] ?? 'PDF Document') ?>
                            </div>
                        </div>
                        <div>
                            <a href="<?= htmlspecialchars($nl['file_path']) ?>" target="_blank" style="display: flex; align-items: center; justify-content: center; gap: 8px; background: #0284c7; color: #ffffff; padding: 9px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; transition: background 0.2s ease;">
                                <i class="fas fa-download"></i> View / Download Newsletter
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

