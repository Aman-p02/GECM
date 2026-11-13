<?php
$page_title = "Principal :: Government Engineering College, Modasa";
$active_page = 'principal';
$extra_css = 'css/principal.css';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

// Fetch Principal Profile
$profile = null;
$qualifications = [];
$tabItems = [];

if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM principal_profile LIMIT 1");
    $profile = $stmt ? $stmt->fetch() : null;

    $stmtQ = $pdo->query("SELECT * FROM principal_qualifications ORDER BY display_order ASC, id ASC");
    $qualifications = $stmtQ ? $stmtQ->fetchAll() : [];

    $stmtT = $pdo->query("SELECT * FROM principal_tab_items ORDER BY display_order ASC, id DESC");
    $allTabs = $stmtT ? $stmtT->fetchAll() : [];
    foreach ($allTabs as $t) {
        $tabItems[$t['tab_name']][] = $t;
    }
}

// Fallback values if profile is not set yet
$name = $profile['name'] ?? 'Dr. JEETENDRAKUMAR VADHER';
$designation = $profile['designation'] ?? 'Principal';
$qualification = $profile['qualification'] ?? 'M. Tech. (IIT-Madras), Ph.D. (HNGU-Patan)';
$experience = $profile['experience'] ?? '28 Years';
$date_of_joining = $profile['date_of_joining'] ?? '18-05-2022';
$area_of_interest = $profile['area_of_interest'] ?? 'Production, Manufacturing, Industrial Engineering, CAD/CAM, Automation,';
$email = $profile['email'] ?? 'jeetendra.vadher@gecmodasa.ac.in';
$website = $profile['website'] ?? 'http://www.gecmodasa.ac.in/';
$photo_url = !empty($profile['photo_url']) ? $profile['photo_url'] : 'images/avatar_placeholder.svg';
?>

<div class="principal-profile-wrapper">
    <div class="principal-container">
        
        <!-- Breadcrumbs -->
        <div style="font-size: 13px; color: #64748b; margin-bottom: 20px;">
            <a href="index.php" style="color: #0284c7; text-decoration: none;"><i class="fas fa-home"></i></a>
            <span style="color: #cbd5e1; margin: 0 6px;">/</span>
            <span>Administration</span>
            <span style="color: #cbd5e1; margin: 0 6px;">/</span>
            <span>Principal</span>
        </div>

        <!-- Principal Card matching screenshot -->
        <div class="principal-card">
            <div class="principal-photo-wrap">
                <img src="<?= htmlspecialchars($photo_url) ?>" alt="<?= htmlspecialchars($name) ?>" class="principal-photo-img" onerror="this.src='images/avatar_placeholder.svg'">
            </div>

            <div class="principal-info-col">
                <h1 class="principal-name-heading"><?= htmlspecialchars($name) ?></h1>

                <table class="principal-meta-table">
                    <tbody>
                        <tr>
                            <td class="meta-label">Designation</td>
                            <td class="meta-colon">:</td>
                            <td class="meta-val"><?= htmlspecialchars($designation) ?></td>
                        </tr>
                        <tr>
                            <td class="meta-label">Qualification</td>
                            <td class="meta-colon">:</td>
                            <td class="meta-val"><?= htmlspecialchars($qualification) ?></td>
                        </tr>
                        <tr>
                            <td class="meta-label">Experience</td>
                            <td class="meta-colon">:</td>
                            <td class="meta-val"><?= htmlspecialchars($experience) ?></td>
                        </tr>
                        <tr>
                            <td class="meta-label">Date of joining</td>
                            <td class="meta-colon">:</td>
                            <td class="meta-val"><?= htmlspecialchars($date_of_joining) ?></td>
                        </tr>
                        <tr>
                            <td class="meta-label">Area of Interest</td>
                            <td class="meta-colon">:</td>
                            <td class="meta-val"><?= htmlspecialchars($area_of_interest) ?></td>
                        </tr>
                        <tr>
                            <td class="meta-label">Email</td>
                            <td class="meta-colon">:</td>
                            <td class="meta-val">
                                <a href="mailto:<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="meta-label">Website</td>
                            <td class="meta-colon">:</td>
                            <td class="meta-val">
                                <a href="<?= htmlspecialchars($website) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($website) ?></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabs Section matching screenshot -->
        <div class="principal-tabs-card">
            <nav class="principal-tab-nav" role="tablist">
                <button type="button" class="principal-tab-btn active" data-tab="tab-qualifications">
                    <i class="fas fa-graduation-cap"></i> Qualifications
                </button>
                <button type="button" class="principal-tab-btn" data-tab="tab-publications">
                    <i class="fas fa-file-alt"></i> Publications
                </button>
                <button type="button" class="principal-tab-btn" data-tab="tab-books">
                    <i class="fas fa-book"></i> Books
                </button>
                <button type="button" class="principal-tab-btn" data-tab="tab-editorial">
                    <i class="fas fa-pen-nib"></i> Editorial
                </button>
                <button type="button" class="principal-tab-btn" data-tab="tab-talks">
                    <i class="fas fa-chalkboard-teacher"></i> Expert Talks
                </button>
                <button type="button" class="principal-tab-btn" data-tab="tab-workshops">
                    <i class="fas fa-tools"></i> Workshops
                </button>
                <button type="button" class="principal-tab-btn" data-tab="tab-experience">
                    <i class="fas fa-briefcase"></i> Experience
                </button>
                <button type="button" class="principal-tab-btn" data-tab="tab-extra">
                    <i class="fas fa-plus"></i> Extra
                </button>
            </nav>

            <!-- 1. Qualifications Pane -->
            <div id="tab-qualifications" class="principal-tab-pane active">
                <div style="overflow-x: auto;">
                    <table class="principal-tab-table">
                        <thead>
                            <tr>
                                <th>Qualification</th>
                                <th>University / Board</th>
                                <th style="width: 150px;">Year of Passing</th>
                                <th style="width: 140px;">Perc.(%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($qualifications)): ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 20px; color: #64748b;">No qualifications recorded.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($qualifications as $q): ?>
                                    <tr>
                                        <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($q['qualification']) ?></td>
                                        <td><?= htmlspecialchars($q['university_board'] ?? '--') ?></td>
                                        <td><?= htmlspecialchars($q['year_of_passing'] ?? '--') ?></td>
                                        <td><?= htmlspecialchars($q['percentage'] ?? '--') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Other Tab Panes -->
            <?php 
            $tabMappings = [
                'tab-publications' => 'publications',
                'tab-books'        => 'books',
                'tab-editorial'    => 'editorial',
                'tab-talks'        => 'expert_talks',
                'tab-workshops'    => 'workshops',
                'tab-experience'   => 'experience',
                'tab-extra'        => 'extra'
            ];
            foreach ($tabMappings as $paneId => $mapKey):
                $items = $tabItems[$mapKey] ?? [];
            ?>
                <div id="<?= $paneId ?>" class="principal-tab-pane">
                    <?php if (empty($items)): ?>
                        <p style="color: #64748b; font-size: 14px; text-align: center; padding: 20px; margin: 0;">Details are being updated.</p>
                    <?php else: ?>
                        <div style="display: flex; flex-direction: column; gap: 14px;">
                            <?php foreach ($items as $it): ?>
                                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 14px 18px;">
                                    <h4 style="font-size: 14.5px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;"><?= htmlspecialchars($it['title']) ?></h4>
                                    <?php if (!empty($it['extra_info'])): ?>
                                        <div style="font-size: 12.5px; color: #0284c7; font-weight: 600; margin-bottom: 6px;"><?= htmlspecialchars($it['extra_info']) ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($it['description'])): ?>
                                        <p style="font-size: 13.5px; color: #475569; margin: 0; line-height: 1.5;"><?= nl2br(htmlspecialchars($it['description'])) ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.principal-tab-btn');
    const tabPanes = document.querySelectorAll('.principal-tab-pane');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-tab');

            tabButtons.forEach(b => b.classList.remove('active'));
            tabPanes.forEach(p => p.classList.remove('active'));

            this.classList.add('active');
            const targetPane = document.getElementById(targetId);
            if (targetPane) {
                targetPane.classList.add('active');
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
