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

$page_title = htmlspecialchars($faculty['name']) . " — Department of " . htmlspecialchars($deptName);
$active_page = "departments";
$root_path = "../";
$extra_css = "departments/computer/css/department.css";
$extra_js = "departments/computer/js/department.js";

// Include Header
include_once __DIR__ . '/../includes/header.php';
?>

<div class="dept-page">
    <div class="dept-container" style="padding-top: 36px; padding-bottom: 60px;">
        
        <!-- Breadcrumb & Top Bar matching reference screenshot -->
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; border-bottom: 1px solid #f1f5f9; padding-bottom: 16px;">
            <div style="font-size: 1.15rem; font-weight: 700; color: #1e293b;">
                <?= htmlspecialchars($faculty['name']) ?>
            </div>
            <nav aria-label="breadcrumb">
                <ol style="list-style: none; display: flex; align-items: center; gap: 8px; margin: 0; padding: 0; font-size: 13px; color: #64748b;">
                    <li><a href="../index.php" style="color: #1976d2; text-decoration: none;"><i class="fas fa-home" style="margin-right: 4px;"></i></a></li>
                    <li>/</li>
                    <li><a href="../index.php#departments" style="color: #1976d2; text-decoration: none;">Departments</a></li>
                    <li>/</li>
                    <li><a href="<?= htmlspecialchars($deptUrl) ?>" style="color: #1976d2; text-decoration: none;"><?= htmlspecialchars($deptName) ?></a></li>
                    <li>/</li>
                    <li><a href="<?= htmlspecialchars($deptUrl) ?>#faculty" style="color: #1976d2; text-decoration: none;">Faculty</a></li>
                </ol>
            </nav>
        </div>

        <!-- Faculty Main Info Card matching reference screenshot -->
        <div class="faculty-card" style="box-shadow: 0 1px 4px rgba(0,0,0,0.06); border-left: 4px solid #1976d2; margin-bottom: 36px;">
            <div class="faculty-card-media" style="width: 200px;">
                <?php 
                $photoSrc = !empty($faculty['photo_url']) ? '../' . $faculty['photo_url'] : '../images/avatar_placeholder.jpg';
                ?>
                <img src="<?= htmlspecialchars($photoSrc) ?>" 
                     alt="<?= htmlspecialchars($faculty['name']) ?>" 
                     class="faculty-card-photo" 
                     onerror="this.src='../images/avatar_placeholder.jpg'">
            </div>
            <div class="faculty-card-content">
                <h1 class="faculty-card-name" style="font-size: 1.6rem; margin-bottom: 14px;"><?= htmlspecialchars($faculty['name']) ?></h1>
                <table class="faculty-info-table">
                    <tbody>
                        <tr>
                            <th class="faculty-th">Designation</th>
                            <td class="faculty-colon">:</td>
                            <td class="faculty-td"><?= htmlspecialchars($faculty['designation'] ?: '—') ?></td>
                        </tr>
                        <tr>
                            <th class="faculty-th">Qualification</th>
                            <td class="faculty-colon">:</td>
                            <td class="faculty-td"><?= htmlspecialchars($faculty['qualification'] ?: '—') ?></td>
                        </tr>
                        <tr>
                            <th class="faculty-th">Experience</th>
                            <td class="faculty-colon">:</td>
                            <td class="faculty-td"><?= htmlspecialchars($faculty['experience'] ?: '—') ?></td>
                        </tr>
                        <?php if (!empty($faculty['date_of_joining']) && $faculty['date_of_joining'] !== '0000-00-00'): ?>
                        <tr>
                            <th class="faculty-th">Date of joining</th>
                            <td class="faculty-colon">:</td>
                            <td class="faculty-td"><?= date('d-m-Y', strtotime($faculty['date_of_joining'])) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($faculty['area_of_interest'])): ?>
                        <tr>
                            <th class="faculty-th">Area of Interest</th>
                            <td class="faculty-colon">:</td>
                            <td class="faculty-td"><?= htmlspecialchars($faculty['area_of_interest']) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($faculty['email'])): ?>
                        <tr>
                            <th class="faculty-th">Email</th>
                            <td class="faculty-colon">:</td>
                            <td class="faculty-td">
                                <a href="mailto:<?= htmlspecialchars($faculty['email']) ?>"><?= htmlspecialchars($faculty['email']) ?></a>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <th class="faculty-th">Website</th>
                            <td class="faculty-colon">:</td>
                            <td class="faculty-td">
                                <?php if (!empty($faculty['website']) && $faculty['website'] !== '#' && $faculty['website'] !== '0'): ?>
                                    <a href="<?= htmlspecialchars($faculty['website']) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($faculty['website']) ?></a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Detailed Profile Tabs matching reference screenshot (Image 3) -->
        <div class="faculty-tabs-container">
            <!-- Tab Headers Bar -->
            <div class="faculty-tabs-nav" role="tablist">
                <button type="button" class="fac-tab-btn active" data-fac-tab="qualifications">
                    <i class="fas fa-graduation-cap"></i> Qualifications
                </button>
                <button type="button" class="fac-tab-btn" data-fac-tab="publications">
                    <i class="fas fa-file-alt"></i> Publications <?= !empty($detailsGrouped['publications']) ? '(' . count($detailsGrouped['publications']) . ')' : '' ?>
                </button>
                <button type="button" class="fac-tab-btn" data-fac-tab="books">
                    <i class="fas fa-book"></i> Books <?= !empty($detailsGrouped['books']) ? '(' . count($detailsGrouped['books']) . ')' : '' ?>
                </button>
                <button type="button" class="fac-tab-btn" data-fac-tab="editorial">
                    <i class="fas fa-pencil-alt"></i> Editorial
                </button>
                <button type="button" class="fac-tab-btn" data-fac-tab="training">
                    <i class="fas fa-cogs"></i> Training
                </button>
                <button type="button" class="fac-tab-btn" data-fac-tab="expert_talks">
                    <i class="fas fa-comments"></i> Expert Talks
                </button>
                <button type="button" class="fac-tab-btn" data-fac-tab="workshops">
                    <i class="fas fa-wrench"></i> Workshops
                </button>
                <button type="button" class="fac-tab-btn" data-fac-tab="activities">
                    <i class="fas fa-tasks"></i> Activities
                </button>
                <button type="button" class="fac-tab-btn" data-fac-tab="experience">
                    <i class="fas fa-briefcase"></i> Experience
                </button>
                <button type="button" class="fac-tab-btn" data-fac-tab="extra">
                    <i class="fas fa-plus"></i> Extra
                </button>
            </div>

            <!-- Tab 1: Qualifications Table (Matches Image 3) -->
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
                                        <td><?= htmlspecialchars($q['percentage'] ?: '—') ?></td>
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
            <a href="<?= htmlspecialchars($deptUrl) ?>#faculty" class="btn-secondary" style="display: inline-flex; align-items: center; gap: 8px; text-decoration: none; padding: 10px 20px; font-weight: 600; font-size: 14px; background: #f1f5f9; color: #334155; border-radius: 6px; border: 1px solid #cbd5e1;">
                <i class="fas fa-arrow-left"></i> Back to <?= htmlspecialchars($deptName) ?> Faculty
            </a>
        </div>

    </div>
</div>

<style>
/* Detailed Faculty Profile Tab Bar Styling (Matches Image 3) */
.faculty-tabs-container {
    background: #ffffff;
    border-radius: 4px;
    margin-top: 28px;
}

.faculty-tabs-nav {
    display: flex;
    flex-wrap: wrap;
    border-bottom: 2px solid #1976d2;
    background: #f8fafc;
    gap: 2px;
}

.fac-tab-btn {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-bottom: none;
    padding: 10px 16px;
    font-size: 13.5px;
    font-weight: 500;
    color: #475569;
    cursor: pointer;
    border-radius: 4px 4px 0 0;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: all 0.15s ease;
}

.fac-tab-btn:hover {
    color: #1976d2;
    background: #ffffff;
}

.fac-tab-btn.active {
    background: #1976d2;
    color: #ffffff;
    border-color: #1976d2;
    font-weight: 600;
}

.fac-tab-btn.active i {
    color: #ffffff;
}

.fac-tab-pane {
    display: none;
    padding: 16px 4px;
}

.fac-tab-pane.active {
    display: block;
}

/* Qualification Table (Matches Image 3) */
.fac-qual-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #e2e8f0;
    font-size: 14px;
}

.fac-qual-table th {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 10px 16px;
    text-align: left;
    color: #334155;
    font-weight: 600;
}

.fac-qual-table td {
    border: 1px solid #e2e8f0;
    padding: 10px 16px;
    color: #475569;
}

.fac-qual-table tr:nth-child(even) td {
    background: #fcfcfd;
}

.fac-empty-box {
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 6px;
    padding: 30px;
    text-align: center;
    color: #64748b;
    font-size: 14px;
}

.fac-numbered-list {
    margin: 0;
    padding-left: 24px;
}

.fac-list-item {
    margin-bottom: 18px;
    line-height: 1.6;
}

.fac-item-title {
    font-weight: 600;
    color: #1e293b;
    font-size: 14.5px;
}

.fac-item-details {
    font-size: 13.5px;
    color: #64748b;
    margin-top: 4px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.fac-tab-btn');
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

