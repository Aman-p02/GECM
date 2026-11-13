<?php
$page_title = "Campus Facilities :: Government Engineering College, Modasa";
$active_page = 'facilities';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

$facilities = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM campus_facilities WHERE is_active = 1 ORDER BY display_order ASC, id DESC");
    $facilities = $stmt ? $stmt->fetchAll() : [];
}
?>

<div style="background-color: #f8fafc; min-height: calc(100vh - 280px); padding: 30px 0 60px 0; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <div style="max-width: 1180px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Breadcrumbs -->
        <div style="font-size: 13px; color: #64748b; margin-bottom: 24px;">
            <a href="index.php" style="color: #0284c7; text-decoration: none;"><i class="fas fa-home"></i></a>
            <span style="color: #cbd5e1; margin: 0 6px;">/</span>
            <span>About</span>
            <span style="color: #cbd5e1; margin: 0 6px;">/</span>
            <span style="color: #1e293b; font-weight: 500;">Campus Facilities</span>
        </div>

        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 35px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04); margin-bottom: 30px;">
            <div style="border-bottom: 2px solid #0284c7; padding-bottom: 12px; margin-bottom: 20px;">
                <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">Campus Facilities &amp; Infrastructure</h1>
            </div>
            <p style="font-size: 15px; line-height: 1.75; color: #475569; margin: 0; text-align: justify;">
                Government Engineering College, Modasa is spread over a sprawling green campus equipped with contemporary academic, research, recreational, and residential infrastructure to foster high academic standards and student well-being.
            </p>
        </div>

        <!-- Facilities Cards Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 26px;">
            <?php if (empty($facilities)): ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #ffffff; border-radius: 8px; color: #64748b;">
                    No campus facilities listed at this time.
                </div>
            <?php else: ?>
                <?php foreach ($facilities as $fac): ?>
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04); display: flex; flex-direction: column; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                        <?php if (!empty($fac['image_path'])): ?>
                            <div style="height: 200px; background: #e2e8f0; overflow: hidden;">
                                <img src="<?= htmlspecialchars($fac['image_path']) ?>" alt="<?= htmlspecialchars($fac['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null; this.parentElement.style.display='none';">
                            </div>
                        <?php endif; ?>
                        
                        <div style="padding: 22px; flex: 1; display: flex; flex-direction: column;">
                            <h2 style="font-size: 17px; font-weight: 700; color: #1e293b; margin: 0 0 10px 0; line-height: 1.4;">
                                <?= htmlspecialchars($fac['title']) ?>
                            </h2>
                            <p style="font-size: 14px; line-height: 1.7; color: #475569; margin: 0; flex: 1; text-align: justify;">
                                <?= nl2br(htmlspecialchars($fac['short_desc'])) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
