<?php
require_once __DIR__ . '/../includes/db.php';
$pdo = getDBConnection();

$id = (int)($_GET['id'] ?? 0);
$uname = trim($_GET['username'] ?? '');

$validDepts = [
    'CE'    => ['name' => 'Computer Engineering', 'folder' => 'computer'],
    'IT'    => ['name' => 'Information Technology', 'folder' => 'information-technology'],
    'ME'    => ['name' => 'Mechanical Engineering', 'folder' => 'mechanical'],
    'CIVIL' => ['name' => 'Civil Engineering', 'folder' => 'civil'],
    'EE'    => ['name' => 'Electrical Engineering', 'folder' => 'electrical'],
    'EC'    => ['name' => 'Electronics & Communication', 'folder' => 'electronics-communication'],
    'AE'    => ['name' => 'Automobile Engineering', 'folder' => 'automobile'],
    'AM'    => ['name' => 'Applied Mechanics', 'folder' => 'applied-mechanics'],
    'SH'    => ['name' => 'Science & Humanities', 'folder' => 'science-humanities']
];

$faculty = null;
if ($pdo && ($id > 0 || !empty($uname))) {
    try {
        if ($id > 0) {
            $stmt = $pdo->prepare("SELECT * FROM faculties WHERE id = ? AND is_active = 1");
            $stmt->execute([$id]);
        } else {
            $stmt = $pdo->prepare("SELECT * FROM faculties WHERE username = ? AND is_active = 1");
            $stmt->execute([$uname]);
        }
        $faculty = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Faculty Profile Error: " . $e->getMessage());
    }
}

if (!$faculty) {
    header('Location: ../index.php');
    exit;
}

$deptCode = $faculty['dept_code'];
$deptInfo = $validDepts[$deptCode] ?? ['name' => $deptCode . ' Department', 'folder' => 'computer'];
$deptName = $deptInfo['name'];
$deptFolder = $deptInfo['folder'];
$deptUrl = file_exists(__DIR__ . '/' . $deptFolder . '/index.php') ? $deptFolder . '/index.php' : '../index.php';

// Fetch qualifications
$qualifications = [];
$detailsGrouped = [];
if ($pdo) {
    try {
        $qStmt = $pdo->prepare("SELECT * FROM faculty_qualifications WHERE faculty_id = ? ORDER BY id ASC");
        $qStmt->execute([$faculty['id']]);
        $qualifications = $qStmt->fetchAll(PDO::FETCH_ASSOC);

        $dStmt = $pdo->prepare("SELECT * FROM faculty_details WHERE faculty_id = ? ORDER BY display_order ASC, id ASC");
        $dStmt->execute([$faculty['id']]);
        $allDetails = $dStmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($allDetails as $d) {
            $detailsGrouped[$d['section_type']][] = $d;
        }
    } catch (Exception $e) {
        error_log("Faculty Details Error: " . $e->getMessage());
    }
}

$page_title = htmlspecialchars($faculty['name']) . " - Department of " . htmlspecialchars($deptName);
$active_page = "departments";
$root_path = "../";

$deptCssPath = "departments/" . $deptFolder . "/css/department.css";
$extra_css = file_exists(__DIR__ . '/../' . $deptCssPath) ? $deptCssPath : "departments/computer/css/department.css";
$deptJsPath = "departments/" . $deptFolder . "/js/department.js";
$extra_js = file_exists(__DIR__ . '/../' . $deptJsPath) ? $deptJsPath : "departments/computer/js/department.js";

// Include Header
include_once __DIR__ . '/../includes/header.php';
?>
<link rel="stylesheet" href="includes/faculty.css">

<div class="dept-page">
    <div class="dept-container" style="padding-top: 32px; padding-bottom: 60px;">
        
        <!-- Minimal Back Link -->
        <div style="margin-bottom: 24px;">
            <a href="<?= htmlspecialchars($deptUrl) ?>#faculty" class="dept-back-link">
                <i class="fas fa-arrow-left"></i> Back to <?= htmlspecialchars($deptName) ?> Faculty
            </a>
        </div>

        <!-- Faculty Main Info Card -->
        <div class="faculty-card" style="margin-bottom: 32px;">
            <div class="faculty-card-media" style="width: 160px;">
                <?php 
                $photoRel = !empty($faculty['photo_url']) ? ltrim($faculty['photo_url'], '/') : '';
                $deptLower = strtolower($faculty['dept_code'] ?? 'ce');
                $photoSrc = '../images/avatar_placeholder.svg';

                if (!empty($photoRel)) {
                    if (file_exists(__DIR__ . '/../' . $photoRel)) {
                        $photoSrc = '../' . $photoRel;
                    } elseif (file_exists(__DIR__ . '/../uploads/faculty/' . $deptLower . '/' . basename($photoRel))) {
                        $photoSrc = '../uploads/faculty/' . $deptLower . '/' . basename($photoRel);
                    } elseif (file_exists(__DIR__ . '/../uploads/faculty/' . basename($photoRel))) {
                        $photoSrc = '../uploads/faculty/' . basename($photoRel);
                    } else {
                        $photoSrc = '../' . $photoRel;
                    }
                }
                ?>
                <div class="faculty-photo-frame">
                    <img src="<?= htmlspecialchars($photoSrc) ?>" 
                         alt="<?= htmlspecialchars($faculty['name']) ?>" 
                         class="faculty-card-photo" 
                         onerror="this.src='../images/avatar_placeholder.svg'">
                </div>
            </div>
            <div class="faculty-card-body">
                <div class="faculty-card-top">
                    <div class="faculty-rank"><?= htmlspecialchars($faculty['designation'] ?: 'Faculty Member') ?></div>
                    <h1 class="faculty-name" style="font-size: 1.65rem;"><?= htmlspecialchars($faculty['name']) ?></h1>
                </div>

                <div class="faculty-details-row">
                    <?php if (!empty($faculty['qualification'])): ?>
                    <div class="faculty-detail-col">
                        <span class="faculty-detail-label">Qualification</span>
                        <span class="faculty-detail-val"><?= htmlspecialchars($faculty['qualification']) ?></span>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($faculty['experience'])): ?>
                    <div class="faculty-detail-col">
                        <span class="faculty-detail-label">Experience</span>
                        <span class="faculty-detail-val"><?= htmlspecialchars($faculty['experience']) ?></span>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($faculty['date_of_joining']) && $faculty['date_of_joining'] !== '0000-00-00'): ?>
                    <div class="faculty-detail-col">
                        <span class="faculty-detail-label">Date of Joining</span>
                        <span class="faculty-detail-val"><?= date('d-m-Y', strtotime($faculty['date_of_joining'])) ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($faculty['area_of_interest'])): ?>
                <div class="faculty-research">
                    <span class="faculty-research-label">Area of Interest:</span>
                    <span class="faculty-research-val"><?= htmlspecialchars($faculty['area_of_interest']) ?></span>
                </div>
                <?php endif; ?>

                <div class="faculty-card-bottom">
                    <div class="faculty-actions-left">
                        <?php if (!empty($faculty['email'])): ?>
                            <a href="mailto:<?= htmlspecialchars($faculty['email']) ?>" class="faculty-link" title="Email <?= htmlspecialchars($faculty['name']) ?>">
                                <i class="far fa-envelope"></i>
                                <span><?= htmlspecialchars($faculty['email']) ?></span>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($faculty['website']) && $faculty['website'] !== '#' && $faculty['website'] !== '0' && $faculty['website'] !== '-'): ?>
                            <a href="<?= htmlspecialchars($faculty['website']) ?>" target="_blank" rel="noopener noreferrer" class="faculty-link" title="Personal Website">
                                <i class="fas fa-globe"></i>
                                <span><?= htmlspecialchars($faculty['website']) ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Profile Tabs -->
        <div class="faculty-tabs-container">
            <!-- Tab Headers Bar -->
            <div class="fac-subnav-list" role="tablist">
                <button type="button" class="fac-subnav-btn active" data-fac-tab="qualifications">
                    Qualifications
                </button>
                <button type="button" class="fac-subnav-btn" data-fac-tab="publications">
                    Publications <?= !empty($detailsGrouped['publications']) ? '(' . count($detailsGrouped['publications']) . ')' : '' ?>
                </button>
                <button type="button" class="fac-subnav-btn" data-fac-tab="books">
                    Books <?= !empty($detailsGrouped['books']) ? '(' . count($detailsGrouped['books']) . ')' : '' ?>
                </button>
                <button type="button" class="fac-subnav-btn" data-fac-tab="editorial">
                    Editorial
                </button>
                <button type="button" class="fac-subnav-btn" data-fac-tab="training">
                    Training
                </button>
                <button type="button" class="fac-subnav-btn" data-fac-tab="expert_talks">
                    Expert Talks
                </button>
                <button type="button" class="fac-subnav-btn" data-fac-tab="workshops">
                    Workshops
                </button>
                <button type="button" class="fac-subnav-btn" data-fac-tab="activities">
                    Activities
                </button>
                <button type="button" class="fac-subnav-btn" data-fac-tab="experience">
                    Experience
                </button>
                <button type="button" class="fac-subnav-btn" data-fac-tab="extra">
                    Extra
                </button>
            </div>

            <!-- Tab 1: Qualifications Table -->
            <div class="fac-tab-pane active" id="fac-pane-qualifications">
                <div class="table-responsive" style="margin-top: 16px;">
                    <table class="fac-qual-table">
                        <thead>
                            <tr>
                                <th style="width: 25%;">Qualification</th>
                                <th style="width: 45%;">University / Board</th>
                                <th style="width: 15%;">Year of Passing</th>
                                <th style="width: 15%;">Perc.(%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($qualifications)): ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 24px; color: #64748b;">
                                        No educational milestones recorded currently.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($qualifications as $q): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($q['qualification']) ?></strong></td>
                                        <td><?= htmlspecialchars($q['university']) ?></td>
                                        <td><?= htmlspecialchars($q['year_of_passing']) ?></td>
                                        <td><?= htmlspecialchars($q['percentage'] ?: ' - ') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab 2: Publications -->
            <div class="fac-tab-pane" id="fac-pane-publications">
                <div style="margin-top: 20px;">
                    <?php if (empty($detailsGrouped['publications'])): ?>
                        <div class="fac-empty-box">No publications currently listed.</div>
                    <?php else: ?>
                        <ol class="fac-numbered-list">
                            <?php foreach ($detailsGrouped['publications'] as $pub): ?>
                                <li class="fac-list-item">
                                    <div class="fac-item-title"><?= htmlspecialchars($pub['title']) ?> (<?= htmlspecialchars($pub['year']) ?>)</div>
                                    <div class="fac-item-details"><?= $pub['details'] ?></div>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tab 3: Books -->
            <div class="fac-tab-pane" id="fac-pane-books">
                <div style="margin-top: 20px;">
                    <?php if (empty($detailsGrouped['books'])): ?>
                        <div class="fac-empty-box">No published books or book chapters listed.</div>
                    <?php else: ?>
                        <ol class="fac-numbered-list">
                            <?php foreach ($detailsGrouped['books'] as $book): ?>
                                <li class="fac-list-item">
                                    <div class="fac-item-title"><?= htmlspecialchars($book['title']) ?></div>
                                    <div class="fac-item-details"><?= $book['details'] ?></div>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Other Tabs: Editorial, Training, Expert Talks, Workshops, Activities, Experience, Extra -->
            <?php 
            $otherTabs = [
                'editorial'    => 'Editorial Appointments & Reviews',
                'training'     => 'Faculty Development & Training Programs',
                'expert_talks' => 'Expert Lectures & Keynotes Delivered',
                'workshops'    => 'Workshops & Seminars Attended',
                'activities'   => 'Departmental & Institutional Responsibilities',
                'experience'   => 'Professional & Industrial Experience',
                'extra'        => 'Awards, Honors & Additional Distinctions'
            ];
            foreach ($otherTabs as $secKey => $secLabel):
            ?>
            <div class="fac-tab-pane" id="fac-pane-<?= $secKey ?>">
                <div style="margin-top: 20px;">
                    <?php if (empty($detailsGrouped[$secKey])): ?>
                        <div class="fac-empty-box">No records currently listed under <?= htmlspecialchars($secLabel) ?>.</div>
                    <?php else: ?>
                        <ol class="fac-numbered-list">
                            <?php foreach ($detailsGrouped[$secKey] as $item): ?>
                                <li class="fac-list-item">
                                    <div class="fac-item-title"><?= htmlspecialchars($item['title']) ?></div>
                                    <?php if (!empty($item['details'])): ?>
                                        <div class="fac-item-details"><?= $item['details'] ?></div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Back button -->
        <div style="margin-top: 40px; text-align: left;">
            <a href="<?= htmlspecialchars($deptUrl) ?>#faculty" class="dept-back-link" style="font-size: 14px;">
                <i class="fas fa-arrow-left"></i> Back to <?= htmlspecialchars($deptName) ?> Faculty
            </a>
        </div>

    </div>
</div>

<style>
/* Detailed Profile Sub-Panes & Tables */
.fac-tab-pane {
    display: none;
    padding: 20px 0;
}

.fac-tab-pane.active {
    display: block;
}

/* Qualification Table */
.fac-qual-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid var(--dept-border, #e5e7eb);
    font-size: 14px;
    background: #ffffff;
    border-radius: 6px;
    overflow: hidden;
}

.fac-qual-table th {
    background: var(--dept-bg-subtle, #f8fafc);
    border: 1px solid var(--dept-border, #e5e7eb);
    padding: 12px 18px;
    text-align: left;
    color: #111111;
    font-weight: 600;
    font-family: var(--dept-font-display, inherit);
}

.fac-qual-table td {
    border: 1px solid var(--dept-border, #e5e7eb);
    padding: 12px 18px;
    color: var(--dept-body, #4b5563);
}

.fac-qual-table tr:nth-child(even) td {
    background: #fafafa;
}

.fac-empty-box {
    background: var(--dept-bg-subtle, #f8fafc);
    border: 1px dashed #cbd5e1;
    border-radius: 6px;
    padding: 36px 20px;
    text-align: center;
    color: var(--dept-muted, #6b7280);
    font-size: 14.5px;
}

.fac-numbered-list {
    margin: 0;
    padding-left: 20px;
}

.fac-list-item {
    margin-bottom: 20px;
    line-height: 1.6;
}

.fac-item-title {
    font-weight: 600;
    color: #111111;
    font-size: 14.5px;
    font-family: var(--dept-font-display, inherit);
}

.fac-item-details {
    font-size: 13.5px;
    color: var(--dept-body, #4b5563);
    margin-top: 4px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.fac-subnav-btn');
    const tabPanes = document.querySelectorAll('.fac-tab-pane');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const target = this.getAttribute('data-fac-tab');
            tabBtns.forEach(b => b.classList.remove('active'));
            tabPanes.forEach(p => p.classList.remove('active'));

            this.classList.add('active');
            const targetPane = document.getElementById('fac-pane-' + target);
            if (targetPane) {
                targetPane.classList.add('active');
            }
        });
    });
});
</script>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
