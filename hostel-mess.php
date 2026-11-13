<?php
$page_title = "Hostel & Mess Facility :: Government Engineering College, Modasa";
$active_page = 'hostel-mess';
$extra_css = 'css/hostel-mess.css';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';

// Data queries
$hostelData = null;
$wardenStaff = [];
$workStaff = [];
$blockCapacity = [];
$feesStructure = [];
$photos = [];

if ($pdo) {
    // 1. General Info & PDF
    $stmtH = $pdo->query("SELECT * FROM hostel_mess LIMIT 1");
    $hostelData = $stmtH ? $stmtH->fetch() : null;

    // 2. Staff Incharge (About)
    $stmtW = $pdo->query("SELECT * FROM hostel_staff WHERE section_type = 'warden_caretaker' ORDER BY display_order ASC, id ASC");
    $wardenStaff = $stmtW ? $stmtW->fetchAll() : [];

    $stmtWorks = $pdo->query("SELECT * FROM hostel_staff WHERE section_type = 'works' ORDER BY display_order ASC, id ASC");
    $workStaff = $stmtWorks ? $stmtWorks->fetchAll() : [];

    // 3. Block Capacity
    $stmtB = $pdo->query("SELECT * FROM hostel_blocks ORDER BY display_order ASC, sr_no ASC");
    $blockCapacity = $stmtB ? $stmtB->fetchAll() : [];

    // 4. Fees
    $stmtF = $pdo->query("SELECT * FROM hostel_fees ORDER BY display_order ASC, id ASC");
    $feesStructure = $stmtF ? $stmtF->fetchAll() : [];

    // 5. Photos
    $stmtP = $pdo->query("SELECT * FROM hostel_photos WHERE is_active = 1 ORDER BY display_order ASC, id ASC");
    $photos = $stmtP ? $stmtP->fetchAll() : [];
}

$rulesPdf = !empty($hostelData['rules_pdf_url']) ? $hostelData['rules_pdf_url'] : 'uploads/hostel/hostel_rules_and_regulations.pdf';

// Parse bullet points
$messPoints = !empty($hostelData['mess_notes']) ? explode("\n", str_replace("\r", "", trim($hostelData['mess_notes']))) : [];
$feePoints = !empty($hostelData['fee_notes']) ? explode("\n", str_replace("\r", "", trim($hostelData['fee_notes']))) : [];
?>

<div class="hostel-wrapper">
    <div class="hostel-container">
        
        <!-- Breadcrumbs -->
        <div class="hostel-breadcrumbs">
            <a href="index.php"><i class="fas fa-home"></i></a>
            <span style="color: #cbd5e1; margin: 0 6px;">/</span>
            <span>Administration</span>
            <span style="color: #cbd5e1; margin: 0 6px;">/</span>
            <span style="color: #1e293b; font-weight: 500;">Hostel &amp; Mess Facility</span>
        </div>

        <h1 class="hostel-page-title">Hostel &amp; Mess Facility</h1>

        <!-- Navigation Tabs matching Image 1 -->
        <nav class="hostel-tabs-nav" aria-label="Hostel Sections">
            <button type="button" class="hostel-tab-btn active" data-target="aboutTab">About</button>
            <button type="button" class="hostel-tab-btn" data-target="messTab">Hostel Mess</button>
            <button type="button" class="hostel-tab-btn" data-target="feesTab">Fees Structure</button>
            <button type="button" class="hostel-tab-btn" data-target="rulesTab">Hostel Rules</button>
            <button type="button" class="hostel-tab-btn" data-target="capacityTab">Hostel Block Capacity</button>
            <button type="button" class="hostel-tab-btn" data-target="photosTab">Photos</button>
        </nav>

        <!-- ========================================================================= -->
        <!-- TAB 1: ABOUT (Image 2 - Administrational Structure) -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane active" id="aboutTab">
            <p class="hostel-sub-intro">
                The administrational structure of hostel is shown as below.
            </p>

            <div class="hostel-table-wrap">
                <table class="hostel-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 25%;">Description of work</th>
                            <th colspan="3" style="text-align: center;">Staff Incharge</th>
                        </tr>
                        <tr>
                            <th style="width: 22%; text-align: center;">Block</th>
                            <th style="width: 26%;">Warden</th>
                            <th style="width: 27%;">Care Taker</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($wardenStaff) && empty($workStaff)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 25px; color: #64748b;">No administration records available.</td>
                            </tr>
                        <?php else: ?>
                            <?php 
                            $wardenCount = count($wardenStaff);
                            $first = true;
                            foreach ($wardenStaff as $w): 
                            ?>
                                <tr>
                                    <?php if ($first): ?>
                                        <td rowspan="<?= $wardenCount ?>" style="font-weight: 600; color: #1e293b; vertical-align: top; background: #ffffff;">
                                            <?= htmlspecialchars($w['work_description']) ?>
                                        </td>
                                        <?php $first = false; ?>
                                    <?php endif; ?>
                                    <td style="text-align: center; font-weight: 600;"><?= htmlspecialchars($w['block_name']) ?></td>
                                    <td><?= nl2br(htmlspecialchars($w['warden'])) ?></td>
                                    <td><?= !empty($w['care_taker']) ? nl2br(htmlspecialchars($w['care_taker'])) : '' ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <!-- Works Section (Civil, Electrical, Administrative) -->
                            <?php foreach ($workStaff as $ws): ?>
                                <tr>
                                    <td style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($ws['work_description']) ?></td>
                                    <td colspan="3"><?= htmlspecialchars($ws['staff_incharge'] ?? $ws['warden']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 2: HOSTEL MESS (Image 3) -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane" id="messTab">
            <ul class="hostel-bullet-list">
                <?php if (!empty($messPoints)): ?>
                    <?php foreach ($messPoints as $pt): ?>
                        <?php if (!empty(trim($pt))): ?>
                            <li class="hostel-bullet-item">
                                <i class="fas fa-chevron-circle-right hostel-bullet-icon"></i>
                                <span><?= htmlspecialchars(trim($pt)) ?></span>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="hostel-bullet-item">
                        <i class="fas fa-chevron-circle-right hostel-bullet-icon"></i>
                        <span>The Mess is operated twice a day at lunch and at dinner.</span>
                    </li>
                    <li class="hostel-bullet-item">
                        <i class="fas fa-chevron-circle-right hostel-bullet-icon"></i>
                        <span>The mess is operated by the private mess contractor.</span>
                    </li>
                    <li class="hostel-bullet-item">
                        <i class="fas fa-chevron-circle-right hostel-bullet-icon"></i>
                        <span>The mess contractor is finalized based on the terms and condition of contract.</span>
                    </li>
                    <li class="hostel-bullet-item">
                        <i class="fas fa-chevron-circle-right hostel-bullet-icon"></i>
                        <span>The mess committee is framed to monitor the quantity, quality and rates of food provided by the mess contractor.</span>
                    </li>
                    <li class="hostel-bullet-item">
                        <i class="fas fa-chevron-circle-right hostel-bullet-icon"></i>
                        <span>The mess is non operative during vacation.</span>
                    </li>
                    <li class="hostel-bullet-item">
                        <i class="fas fa-chevron-circle-right hostel-bullet-icon"></i>
                        <span>The hostel fee does not include mess fee. It is to be paid separately to the mess contractor as per the terms and condition of mess contract.</span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 3: FEES STRUCTURE (Image 4) -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane" id="feesTab">
            <ul class="hostel-bullet-list">
                <?php if (!empty($feePoints)): ?>
                    <?php foreach ($feePoints as $pt): ?>
                        <?php if (!empty(trim($pt))): ?>
                            <li class="hostel-bullet-item">
                                <i class="fas fa-chevron-circle-right hostel-bullet-icon"></i>
                                <span><?= htmlspecialchars(trim($pt)) ?></span>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="hostel-bullet-item">
                        <i class="fas fa-chevron-circle-right hostel-bullet-icon"></i>
                        <span>Hostel facility is available exclusively for boy students of GEC, Modasa campus only.</span>
                    </li>
                    <li class="hostel-bullet-item">
                        <i class="fas fa-chevron-circle-right hostel-bullet-icon"></i>
                        <span>Hostel fee is non-transferable and not refundable.</span>
                    </li>
                    <li class="hostel-bullet-item">
                        <i class="fas fa-chevron-circle-right hostel-bullet-icon"></i>
                        <span>The hostel fee does not include mess fee. It is to be paid separately to the mess contractor as per the terms and condition of mess contract.</span>
                    </li>
                    <li class="hostel-bullet-item">
                        <i class="fas fa-chevron-circle-right hostel-bullet-icon"></i>
                        <span>Hostel facility is available upto 3rd year only.</span>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="hostel-table-wrap" style="max-width: 900px;">
                <table class="hostel-table">
                    <thead>
                        <tr>
                            <th style="width: 50%;">Year</th>
                            <th style="width: 50%;">Hostel Fees</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($feesStructure)): ?>
                            <tr>
                                <td>1st year</td>
                                <td>1750</td>
                            </tr>
                            <tr>
                                <td>2nd year</td>
                                <td>1700</td>
                            </tr>
                            <tr>
                                <td>3rd year</td>
                                <td>1700</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($feesStructure as $f): ?>
                                <tr>
                                    <td><?= htmlspecialchars($f['year_name']) ?></td>
                                    <td><?= htmlspecialchars($f['hostel_fees']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 4: HOSTEL RULES (Image 5) -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane" id="rulesTab">
            <div style="padding: 20px 0;">
                <a href="<?= htmlspecialchars($rulesPdf) ?>" target="_blank" class="hostel-rules-link">
                    <i class="fas fa-chevron-circle-right" style="font-size: 20px;"></i>
                    <span>View/Download Updated Hostel Rules and Regulations</span>
                </a>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 5: HOSTEL BLOCK CAPACITY (Image 6) -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane" id="capacityTab">
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 0;">Hostel Block Wise Details</h2>
            </div>

            <div class="hostel-table-wrap">
                <table class="hostel-table">
                    <thead>
                        <tr>
                            <th style="width: 12%;">Sr No.</th>
                            <th style="width: 25%;">Block Name</th>
                            <th style="width: 25%;">Number of Floor</th>
                            <th style="width: 18%;">Total Rooms</th>
                            <th style="width: 20%;">Number of Students</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sumRooms = 0;
                        $sumStudents = 0;
                        if (!empty($blockCapacity)): 
                            foreach ($blockCapacity as $b): 
                                $sumRooms += (int)$b['total_rooms'];
                                $sumStudents += (int)$b['number_of_students'];
                        ?>
                                <tr>
                                    <td><?= (int)$b['sr_no'] ?></td>
                                    <td><?= htmlspecialchars($b['block_name']) ?></td>
                                    <td><?= htmlspecialchars($b['number_of_floor']) ?></td>
                                    <td><?= (int)$b['total_rooms'] ?></td>
                                    <td><?= (int)$b['number_of_students'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr style="font-weight: 700; background-color: #f8fafc;">
                                <td></td>
                                <td>Total</td>
                                <td></td>
                                <td><?= $sumRooms ?></td>
                                <td><?= $sumStudents ?></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td>1</td>
                                <td>A</td>
                                <td>G + 2</td>
                                <td>44</td>
                                <td>132</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>B</td>
                                <td>G + 2</td>
                                <td>44</td>
                                <td>132</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>C</td>
                                <td>G + 2</td>
                                <td>44</td>
                                <td>132</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>D</td>
                                <td>G + 2</td>
                                <td>16</td>
                                <td>48</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>E</td>
                                <td>G + 3</td>
                                <td>122</td>
                                <td>366</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>F</td>
                                <td>G + 2</td>
                                <td>32</td>
                                <td>96</td>
                            </tr>
                            <tr style="font-weight: 700; background-color: #f8fafc;">
                                <td></td>
                                <td>Total</td>
                                <td></td>
                                <td>302</td>
                                <td>906</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- TAB 6: PHOTOS GALLERY (Image 7) -->
        <!-- ========================================================================= -->
        <div class="hostel-tab-pane" id="photosTab">
            <div class="hostel-photo-grid">
                <?php if (empty($photos)): ?>
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #64748b;">
                        No hostel photos uploaded yet.
                    </div>
                <?php else: ?>
                    <?php foreach ($photos as $ph): ?>
                        <div class="hostel-photo-card">
                            <img src="<?= htmlspecialchars($ph['image_path']) ?>" alt="<?= htmlspecialchars($ph['caption']) ?>" class="hostel-photo-thumb" onerror="this.src='images/hero_campus_1.jpg'">
                            <div class="hostel-photo-caption">
                                <?= htmlspecialchars($ph['caption']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script>
// Tab Switching Script with Hash Support
document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.hostel-tab-btn');
    const tabPanes = document.querySelectorAll('.hostel-tab-pane');

    function activateTab(targetId) {
        tabButtons.forEach(btn => {
            if (btn.getAttribute('data-target') === targetId) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        tabPanes.forEach(pane => {
            if (pane.getAttribute('id') === targetId) {
                pane.classList.add('active');
            } else {
                pane.classList.remove('active');
            }
        });
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            activateTab(targetId);
            window.location.hash = targetId.replace('Tab', '').toLowerCase();
        });
    });

    // Check URL hash on page load
    const hash = window.location.hash.replace('#', '').toLowerCase();
    const map = {
        'about': 'aboutTab',
        'mess': 'messTab',
        'fees': 'feesTab',
        'rules': 'rulesTab',
        'capacity': 'capacityTab',
        'photos': 'photosTab'
    };

    if (hash && map[hash]) {
        activateTab(map[hash]);
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
