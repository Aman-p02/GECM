<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$page_title = "Campus Facilities";
$current_page = 'facilities';

require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card" style="padding: 24px;">
    <!-- Top Action Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eef2f6; padding-bottom: 14px; margin-bottom: 22px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">Campus Facilities</h2>
            <p style="font-size: 13.5px; color: #64748b; margin: 0;">Institutional campus facilities overview and website display status.</p>
        </div>
        <a href="../facilities.php" target="_blank" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px; font-size: 13px;">
            <i class="fas fa-external-link-alt"></i> View Public Facilities Page
        </a>
    </div>

    <!-- Informational Card -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 22px; margin-bottom: 24px;">
        <div style="display: flex; align-items: flex-start; gap: 16px;">
            <div style="width: 44px; height: 44px; background: #e0f2fe; color: #009dff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                <i class="fas fa-building"></i>
            </div>
            <div>
                <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 6px 0;">Permanent Institutional Content</h3>
                <p style="font-size: 13.5px; color: #475569; line-height: 1.6; margin: 0 0 12px 0;">
                    Campus facilities are maintained directly as high-performance institutional content on the website with zero database dependency.
                </p>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="../facilities.php" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px;">
                        <i class="fas fa-eye"></i> Open Public View
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Facilities Overview -->
    <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 14px 0;">Published Campus Facilities on Website</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
        <?php
        $staticFacilities = [
            ['title' => 'Siemens Center of Excellence (CoE)', 'cat' => 'Industry Partnered', 'icon' => 'fa-cogs'],
            ['title' => 'Central Digital Library & LRC', 'cat' => 'Academic Resource', 'icon' => 'fa-book-reader'],
            ['title' => 'Central Computing Facility (CCF)', 'cat' => 'IT Infrastructure', 'icon' => 'fa-network-wired'],
            ['title' => 'On-Campus Student Hostels', 'cat' => 'Residential', 'icon' => 'fa-building'],
            ['title' => 'Central Engineering Workshop', 'cat' => 'Practical Training', 'icon' => 'fa-tools'],
            ['title' => 'Sports Complex & Gymkhana', 'cat' => 'Recreation & Fitness', 'icon' => 'fa-running'],
            ['title' => 'Auditorium & Seminar Halls', 'cat' => 'Events & Symposia', 'icon' => 'fa-microphone-alt']
        ];
        foreach ($staticFacilities as $f):
        ?>
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 14px 16px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; background: #f1f5f9; color: #009dff; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0;">
                    <i class="fas <?= $f['icon'] ?>"></i>
                </div>
                <div>
                    <div style="font-size: 13.5px; font-weight: 600; color: #1e293b; line-height: 1.3;"><?= htmlspecialchars($f['title']) ?></div>
                    <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;"><?= htmlspecialchars($f['cat']) ?> &bull; <span style="color: #10b981; font-weight: 600;">Active</span></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
