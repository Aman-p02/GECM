<?php
$current_page = 'hostel-allocation';
$page_title = 'Run Hostel Allocation & Merit';
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();

$branches_map = [
    "CE" => "Computer Engineering",
    "IT" => "Information Technology",
    "EC" => "Electronics & Communication",
    "Mechanical" => "Mechanical Engineering",
    "Civil" => "Civil Engineering",
    "Electrical" => "Electrical Engineering",
    "Automobile" => "Automobile Engineering"
];

// 1. Fetch available blocks
$blocks = [];
if ($pdo) {
    try {
        $blocks = $pdo->query("SELECT DISTINCT block_name FROM hostels ORDER BY block_name ASC")->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {}
}

// 2. Parameters for run
$selectedBlock = trim($_POST['block_name'] ?? ($_GET['block_name'] ?? ''));
$selectedRound = (int)($_POST['round'] ?? ($_GET['round'] ?? 1));
$studentType   = trim($_POST['student_type'] ?? ($_GET['student_type'] ?? ''));
$sortMode      = trim($_POST['sort_mode'] ?? ($_GET['sort_mode'] ?? 'distance'));
$reportingDate = trim($_POST['reporting_date'] ?? date('Y-m-d', strtotime('+10 days')));
$runExecuted   = isset($_POST['action']) && $_POST['action'] === 'run_algorithm';

// 3. Save Allocation Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'commit_allocation') {
    $studentsToSave = json_decode($_POST['students_payload'] ?? '[]', true);
    $savedCount = 0;

    if (!empty($studentsToSave) && $pdo) {
        $pdo->beginTransaction();
        try {
            $stmtInsert = $pdo->prepare("INSERT INTO allocation_list 
                (id, student_name, current_sem, branch, acpc_merit_rank, admission_year, gender, category, father_name, district, taluka, perm_address, contact_number, local_address, hostel_block, annual_income, last_exam, passing_year, result_percent, photo_path, created_at, round, reference_no, status, reporting_deadline, hostel_room) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, '', 'pending', ?, NULL)");

            foreach ($studentsToSave as $st) {
                // Check if already allocated
                $chk = $pdo->prepare("SELECT id FROM allocation_list WHERE id = ?");
                $chk->execute([$st['id']]);
                if ($chk->rowCount() > 0) continue;

                $stmtInsert->execute([
                    $st['id'],
                    $st['student_name'],
                    $st['current_sem'],
                    $st['branch'],
                    $st['acpc_merit_rank'],
                    $st['admission_year'],
                    $st['gender'],
                    $st['category'],
                    $st['father_name'],
                    $st['district'],
                    $st['taluka'],
                    $st['perm_address'] ?? '',
                    $st['contact_number'] ?? '',
                    $st['local_address'] ?? '',
                    $selectedBlock,
                    $st['annual_income'] ?? '',
                    $st['last_exam'] ?? '',
                    $st['passing_year'] ?? '',
                    $st['result_percent'] ?? '',
                    $st['photo_path'] ?? '',
                    $selectedRound,
                    $reportingDate
                ]);
                $savedCount++;
            }
            $pdo->commit();
            setFlashMessage('success', "Successfully allocated and saved {$savedCount} students to {$selectedBlock} (Round {$selectedRound}) with reporting deadline {$reportingDate}!");
        } catch (Exception $e) {
            $pdo->rollBack();
            setFlashMessage('danger', 'Error committing allocation: ' . $e->getMessage());
        }
    } else {
        setFlashMessage('info', 'No eligible candidates to save.');
    }
    header("Location: hostel-allocation.php?block_name=" . urlencode($selectedBlock) . "&round=" . $selectedRound);
    exit;
}

// 4. Algorithm Calculation
$blockConfig = null;
$categoryBreakdown = [];
$allocatedStudents = [];
$totalAllocated = 0;

if (!empty($selectedBlock) && $pdo) {
    try {
        $stmtCfg = $pdo->prepare("SELECT * FROM hostels WHERE block_name = ? LIMIT 1");
        $stmtCfg->execute([$selectedBlock]);
        $blockConfig = $stmtCfg->fetch(PDO::FETCH_ASSOC);

        if ($blockConfig) {
            // Category quota calculation
            $categories = ['Open-EWS', 'SC', 'ST', 'SEBC', 'Open'];
            foreach ($categories as $cat) {
                foreach (array_keys($branches_map) as $bCode) {
                    $categoryBreakdown[$cat][$bCode] = 0;
                }
            }

            foreach (array_keys($branches_map) as $bCode) {
                $col = strtolower($bCode) . '_seats';
                $branchSeats = (int)($blockConfig[$col] ?? 0);

                if ($branchSeats > 0) {
                    $ews = (int)floor($branchSeats * 0.10);
                    $rem = $branchSeats - $ews;
                    $sebc = (int)floor($rem * 0.28);
                    $st = (int)floor($rem * 0.14);
                    $sc = (int)floor($rem * 0.07);
                    $open = max(0, $branchSeats - ($ews + $sebc + $st + $sc));

                    $categoryBreakdown['Open-EWS'][$bCode] = $ews;
                    $categoryBreakdown['SEBC'][$bCode] = $sebc;
                    $categoryBreakdown['SC'][$bCode] = $sc;
                    $categoryBreakdown['ST'][$bCode] = $st;
                    $categoryBreakdown['Open'][$bCode] = $open;
                }
            }

            // Run candidate slotting if requested
            if ($runExecuted) {
                $sqlCand = "SELECT ha.*, l.Distance_From_Modasa 
                            FROM hostel_applications ha 
                            LEFT JOIN location l ON ha.district = l.District AND ha.taluka = l.Taluka 
                            WHERE ha.id NOT IN (SELECT id FROM allocation_list WHERE status != 'Cancelled')";

                if (!empty($studentType)) {
                    $sqlCand .= " AND ha.current_sem = " . $pdo->quote($studentType);
                }

                $stmtCand = $pdo->query($sqlCand);
                $candidates = $stmtCand->fetchAll(PDO::FETCH_ASSOC);

                // Sort candidates according to sorting mode
                if ($sortMode === 'merit') {
                    usort($candidates, function ($a, $b) {
                        $ra = (int)$a['acpc_merit_rank'];
                        $rb = (int)$b['acpc_merit_rank'];
                        if ($ra === $rb) {
                            return (int)($b['Distance_From_Modasa'] ?? 0) - (int)($a['Distance_From_Modasa'] ?? 0);
                        }
                        return $ra - $rb;
                    });
                } else {
                    // Distance first (Default)
                    usort($candidates, function ($a, $b) {
                        $da = (int)($a['Distance_From_Modasa'] ?? 0);
                        $db = (int)($b['Distance_From_Modasa'] ?? 0);
                        if ($da === $db) {
                            return (int)$a['acpc_merit_rank'] - (int)$b['acpc_merit_rank'];
                        }
                        return $db - $da;
                    });
                }

                // Fill quota buckets
                $remainingQuota = $categoryBreakdown;

                foreach ($candidates as $cand) {
                    $cBranch = $cand['branch'];
                    $cCategory = $cand['category'];

                    // Check exact category quota first
                    if (isset($remainingQuota[$cCategory][$cBranch]) && $remainingQuota[$cCategory][$cBranch] > 0) {
                        $remainingQuota[$cCategory][$cBranch]--;
                        $cand['allotted_category'] = $cCategory;
                        $allocatedStudents[] = $cand;
                        $totalAllocated++;
                    } 
                    // Fallback to Open category quota
                    elseif (isset($remainingQuota['Open'][$cBranch]) && $remainingQuota['Open'][$cBranch] > 0) {
                        $remainingQuota['Open'][$cBranch]--;
                        $cand['allotted_category'] = 'Open (General)';
                        $allocatedStudents[] = $cand;
                        $totalAllocated++;
                    }
                }
            }
        }
    } catch (Exception $e) {
        error_log("Allocation error: " . $e->getMessage());
    }
}
?>

<div class="admin-fade-in">

    <!-- Header Banner -->
    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px 24px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">Run Hostel Allocation &amp; Merit Lists</h2>
            <p style="font-size: 0.86rem; color: #64748b; margin: 0;">Automated merit shortlisting engine matching institutional quota rules (10% EWS, 28% SEBC, 14% ST, 7% SC, Open).</p>
        </div>
        <div>
            <a href="hostel-confirmation.php" class="btn btn-secondary" style="font-weight: 700; font-size: 0.88rem; padding: 8px 16px; border-radius: 6px; text-decoration: none;">
                <i class="fas fa-door-open"></i> Go to Room Allotment
            </a>
        </div>
    </div>

    <!-- Step 1: Configuration Form Card -->
    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 22px 24px; margin-bottom: 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
        <h4 style="margin: 0 0 16px 0; font-size: 1.05rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 8px;">
            <span style="width: 24px; height: 24px; border-radius: 50%; background: #ff8800; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 12px;">1</span>
            Select Allocation Parameters
        </h4>

        <form method="POST" action="hostel-allocation.php" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) auto; gap: 14px; align-items: end;">
            <input type="hidden" name="action" value="run_algorithm">

            <div>
                <label style="font-size: 0.80rem; font-weight: 700; color: #334155; margin-bottom: 5px; display: block;">Hostel Block</label>
                <select name="block_name" class="form-control" required style="font-size: 0.90rem; height: 40px;">
                    <option value="" disabled <?= empty($selectedBlock) ? 'selected' : '' ?>>-- Choose Block --</option>
                    <?php foreach ($blocks as $blk): ?>
                        <option value="<?= htmlspecialchars($blk['block_name']) ?>" <?= ($selectedBlock === $blk['block_name']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($blk['block_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label style="font-size: 0.80rem; font-weight: 700; color: #334155; margin-bottom: 5px; display: block;">Allocation Round</label>
                <select name="round" class="form-control" required style="font-size: 0.90rem; height: 40px;">
                    <option value="1" <?= ($selectedRound === 1) ? 'selected' : '' ?>>Round 1</option>
                    <option value="2" <?= ($selectedRound === 2) ? 'selected' : '' ?>>Round 2</option>
                    <option value="3" <?= ($selectedRound === 3) ? 'selected' : '' ?>>Round 3</option>
                    <option value="4" <?= ($selectedRound === 4) ? 'selected' : '' ?>>Round 4</option>
                    <option value="5" <?= ($selectedRound === 5) ? 'selected' : '' ?>>Round 5</option>
                </select>
            </div>

            <div>
                <label style="font-size: 0.80rem; font-weight: 700; color: #334155; margin-bottom: 5px; display: block;">Candidate Group</label>
                <select name="student_type" class="form-control" style="font-size: 0.90rem; height: 40px;">
                    <option value="">All Semesters</option>
                    <option value="1" <?= ($studentType === '1') ? 'selected' : '' ?>>Sem 1 (BE 1st Year)</option>
                    <option value="3" <?= ($studentType === '3') ? 'selected' : '' ?>>Sem 3 (D-to-D / 2nd Year)</option>
                </select>
            </div>

            <div>
                <label style="font-size: 0.80rem; font-weight: 700; color: #334155; margin-bottom: 5px; display: block;">Sorting Rule</label>
                <select name="sort_mode" class="form-control" style="font-size: 0.90rem; height: 40px;">
                    <option value="distance" <?= ($sortMode === 'distance') ? 'selected' : '' ?>>Distance First (Modasa KM)</option>
                    <option value="merit" <?= ($sortMode === 'merit') ? 'selected' : '' ?>>Merit Rank First (ACPC)</option>
                </select>
            </div>

            <div>
                <label style="font-size: 0.80rem; font-weight: 700; color: #334155; margin-bottom: 5px; display: block;">Reporting Deadline</label>
                <input type="date" name="reporting_date" class="form-control" value="<?= htmlspecialchars($reportingDate) ?>" required style="font-size: 0.90rem; height: 40px;">
            </div>

            <button type="submit" class="btn btn-primary" style="background: #ff8800; border-color: #ff8800; color: #fff; height: 40px; font-weight: 700; font-size: 0.90rem; padding: 0 20px;">
                <i class="fas fa-magic"></i> Run Algorithm
            </button>
        </form>
    </div>

    <!-- Step 2: Quota Breakdown Matrix -->
    <?php if ($blockConfig): ?>
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px 24px; margin-bottom: 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <h4 style="margin: 0; font-size: 1.05rem; font-weight: 800; color: #0f172a;">
                    Calculated Seat Quota Matrix: <?= htmlspecialchars($selectedBlock) ?> (Capacity: <?= $blockConfig['capacity'] ?> Beds)
                </h4>
                <a href="hostel-blocks.php" style="font-size: 0.82rem; font-weight: 700; color: #ff8800; text-decoration: none;">Edit Quota Seats &rarr;</a>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 0.84rem;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569;">
                            <th style="padding: 10px; text-align: left;">Category Quota</th>
                            <?php foreach ($branches_map as $code => $name): ?>
                                <th style="padding: 10px;" title="<?= htmlspecialchars($name) ?>"><?= $code ?></th>
                            <?php endforeach; ?>
                            <th style="padding: 10px; font-weight: 800;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $catTotals = [];
                        foreach ($categoryBreakdown as $catName => $branchSeats): 
                            $rowSum = array_sum($branchSeats);
                        ?>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 8px 10px; text-align: left; font-weight: 700; color: #1e293b;"><?= htmlspecialchars($catName) ?></td>
                                <?php foreach ($branches_map as $code => $name): 
                                    $val = $branchSeats[$code] ?? 0;
                                    $catTotals[$code] = ($catTotals[$code] ?? 0) + $val;
                                ?>
                                    <td style="padding: 8px 10px;"><?= $val ?></td>
                                <?php endforeach; ?>
                                <td style="padding: 8px 10px; font-weight: 700; color: #ff8800;"><?= $rowSum ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr style="background: #fff7ed; font-weight: 800; border-top: 2px solid #fed7aa; color: #0f172a;">
                            <td style="padding: 10px; text-align: left;">Total Branch Quota</td>
                            <?php foreach ($branches_map as $code => $name): ?>
                                <td style="padding: 10px;"><?= $catTotals[$code] ?? 0 ?></td>
                            <?php endforeach; ?>
                            <td style="padding: 10px; font-size: 0.95rem; color: #c2410c;"><?= array_sum($catTotals) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <!-- Step 3: Allocated Results Table -->
    <?php if ($runExecuted): ?>
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 22px 24px; margin-bottom: 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 14px;">
                <div>
                    <h3 style="margin: 0 0 4px 0; font-size: 1.20rem; font-weight: 800; color: #0f172a;">
                        Allocation Preview: <span style="color: #047857;"><?= $totalAllocated ?> Candidates Shortlisted</span>
                    </h3>
                    <p style="margin: 0; font-size: 0.86rem; color: #64748b;">
                        Review the generated list below before committing to database. Reporting Deadline: <strong><?= htmlspecialchars($reportingDate) ?></strong>
                    </p>
                </div>

                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <!-- Print Button -->
                    <button type="button" onclick="window.print()" class="btn btn-secondary" style="font-weight: 700; font-size: 0.88rem; padding: 8px 16px; border-radius: 6px;">
                        <i class="fas fa-print"></i> Print Merit List
                    </button>

                    <!-- Save Allocation Form -->
                    <form method="POST" action="hostel-allocation.php">
                        <input type="hidden" name="action" value="commit_allocation">
                        <input type="hidden" name="block_name" value="<?= htmlspecialchars($selectedBlock) ?>">
                        <input type="hidden" name="round" value="<?= $selectedRound ?>">
                        <input type="hidden" name="reporting_date" value="<?= htmlspecialchars($reportingDate) ?>">
                        <input type="hidden" name="students_payload" value="<?= htmlspecialchars(json_encode($allocatedStudents), ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="btn btn-primary" style="background: #047857; border-color: #047857; color: #fff; font-weight: 700; font-size: 0.88rem; padding: 8px 20px; border-radius: 6px;" <?= empty($allocatedStudents) ? 'disabled' : '' ?>>
                            <i class="fas fa-save"></i> Save &amp; Commit Allocation
                        </button>
                    </form>
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.76rem; text-transform: uppercase; letter-spacing: 0.05em;">
                            <th style="padding: 12px 14px;">Merit No</th>
                            <th style="padding: 12px 14px;">Student Name</th>
                            <th style="padding: 12px 14px;">Branch</th>
                            <th style="padding: 12px 14px;">Category</th>
                            <th style="padding: 12px 14px;">Quota Allotted</th>
                            <th style="padding: 12px 14px;">ACPC Rank</th>
                            <th style="padding: 12px 14px;">District</th>
                            <th style="padding: 12px 14px;">Distance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($allocatedStudents)): ?>
                            <tr>
                                <td colspan="8" style="padding: 30px; text-align: center; color: #94a3b8;">
                                    No eligible candidates found for this block quota.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $mNo = 1; foreach ($allocatedStudents as $st): ?>
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 11px 14px; font-weight: 800; color: #ff8800;"><?= $mNo++ ?></td>
                                    <td style="padding: 11px 14px; font-weight: 700; color: #0f172a;"><?= htmlspecialchars($st['student_name']) ?></td>
                                    <td style="padding: 11px 14px; font-weight: 600; color: #1e293b;"><?= htmlspecialchars($st['branch']) ?></td>
                                    <td style="padding: 11px 14px;"><?= htmlspecialchars($st['category']) ?></td>
                                    <td style="padding: 11px 14px;">
                                        <span style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 2px 8px; border-radius: 4px; font-size: 0.76rem; font-weight: 700;">
                                            <?= htmlspecialchars($st['allotted_category']) ?>
                                        </span>
                                    </td>
                                    <td style="padding: 11px 14px; font-weight: 700;"><?= htmlspecialchars($st['acpc_merit_rank']) ?></td>
                                    <td style="padding: 11px 14px;"><?= htmlspecialchars($st['district']) ?></td>
                                    <td style="padding: 11px 14px; font-weight: 700; color: #047857;"><?= (int)($st['Distance_From_Modasa'] ?? 0) ?> KM</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
