<?php
$page_title = "Information Brochure & Prospectus :: Government Engineering College, Modasa";
$active_page = 'about';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

// Fetch active brochure
$brochure = null;
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM institute_brochures WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
    $brochure = $stmt ? $stmt->fetch() : null;
}
?>

<div style="background: #f8fafc; padding: 40px 0 60px 0; min-height: 75vh;">
    <div class="container" style="max-width: 1140px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Breadcrumb & Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 16px; margin-bottom: 28px; flex-wrap: wrap; gap: 12px;">
            <div>
                <h1 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0 0 6px 0;">Information Brochure &amp; Prospectus</h1>
                <p style="font-size: 14px; color: #64748b; margin: 0;">Official institutional prospectus covering undergraduate/postgraduate programs, admission criteria, departments, and campus life.</p>
            </div>
            <div style="font-size: 13px; color: #64748b;">
                <a href="index.php" style="color: #0284c7; text-decoration: none;"><i class="fas fa-home"></i></a>
                <span style="color: #cbd5e1; margin: 0 6px;">/</span>
                <a href="overview.php" style="color: #0284c7; text-decoration: none;">About</a>
                <span style="color: #cbd5e1; margin: 0 6px;">/</span>
                <span>Brochure</span>
            </div>
        </div>

        <?php if ($brochure): ?>
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 36px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 28px;">
                <div style="display: flex; gap: 24px; align-items: center; flex-wrap: wrap; justify-content: space-between;">
                    <div style="display: flex; gap: 20px; align-items: center;">
                        <div style="width: 60px; height: 60px; background: #fee2e2; color: #dc2626; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 28px; flex-shrink: 0;">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <h2 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0 0 6px 0;"><?= htmlspecialchars($brochure['title']) ?></h2>
                            <p style="font-size: 13.5px; color: #64748b; margin: 0;">
                                Academic Year: <strong><?= htmlspecialchars($brochure['academic_year'] ?? 'Latest Edition') ?></strong> &bull; Size: <?= htmlspecialchars($brochure['file_size'] ?? 'PDF Document') ?>
                            </p>
                        </div>
                    </div>
                    <div>
                        <a href="<?= htmlspecialchars($brochure['file_path']) ?>" target="_blank" style="display: inline-flex; align-items: center; gap: 10px; background: #dc2626; color: #ffffff; padding: 12px 24px; border-radius: 6px; font-size: 14px; font-weight: 600; text-decoration: none; transition: background 0.2s ease;">
                            <i class="fas fa-download"></i> Download Full Brochure (PDF)
                        </a>
                    </div>
                </div>

                <div style="margin-top: 32px; border-top: 1px solid #f1f5f9; padding-top: 24px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 14px 0;">What is inside the Information Brochure:</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
                        <div style="background: #f8fafc; padding: 14px 18px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 13.5px; color: #334155;">
                            <i class="fas fa-check-circle" style="color: #16a34a; margin-right: 6px;"></i> Academic Programs &amp; Seat Matrix
                        </div>
                        <div style="background: #f8fafc; padding: 14px 18px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 13.5px; color: #334155;">
                            <i class="fas fa-check-circle" style="color: #16a34a; margin-right: 6px;"></i> ACPC Admission Guidelines &amp; Eligibility
                        </div>
                        <div style="background: #f8fafc; padding: 14px 18px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 13.5px; color: #334155;">
                            <i class="fas fa-check-circle" style="color: #16a34a; margin-right: 6px;"></i> Department Laboratories &amp; Faculty
                        </div>
                        <div style="background: #f8fafc; padding: 14px 18px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 13.5px; color: #334155;">
                            <i class="fas fa-check-circle" style="color: #16a34a; margin-right: 6px;"></i> Training &amp; Placement Statistics
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 48px 24px; text-align: center; color: #64748b; margin: 30px 0;">
                <i class="fas fa-book-open" style="font-size: 40px; color: #94a3b8; margin-bottom: 14px; display: block;"></i>
                <h3 style="font-size: 18px; font-weight: 600; color: #334155; margin: 0 0 8px 0;">Information Brochure Being Updated</h3>
                <p style="font-size: 14px; margin: 0;">The latest admission information brochure is currently under preparation and will be uploaded here shortly.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

