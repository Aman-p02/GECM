<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();
require_once __DIR__ . '/../includes/db.php';

$pdo = getDBConnection();

// Handle AJAX toggle for form open/close BEFORE any HTML output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'toggle_form_status') {
    header('Content-Type: application/json');
    $newStatus = (int)($_POST['status'] ?? 0);
    $response = ['success' => false, 'new_status' => $newStatus];

    if ($pdo) {
        try {
            $stmt = $pdo->prepare("UPDATE form_status SET is_open = ? WHERE id = 1");
            $response['success'] = $stmt->execute([$newStatus]);
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }
    }
    echo json_encode($response);
    exit;
}

$current_page = 'hostel-dashboard';
$page_title = 'Hostel Administration Dashboard';
require_once __DIR__ . '/includes/header.php';

// 1. Fetch form status
$formIsOpen = 0;
$academicYear = '2024-2025';
if ($pdo) {
    try {
        $stmtStatus = $pdo->query("SELECT is_open, academic_year FROM form_status WHERE id = 1");
        if ($row = $stmtStatus->fetch(PDO::FETCH_ASSOC)) {
            $formIsOpen = (int)$row['is_open'];
            $academicYear = $row['academic_year'] ?? '2024-2025';
        }
    } catch (Exception $e) {}
}

// 2. Fetch live metrics
$totalApps = 0;
$confirmedCount = 0;
$pendingCount = 0;
$cancelledCount = 0;
$recentApps = [];
$blockData = [];

if ($pdo) {
    try {
        // Auto-cancel expired pending allocations
        $pdo->exec("UPDATE allocation_list SET status = 'Cancelled' WHERE status = 'pending' AND reporting_deadline < CURDATE()");

        $totalApps = (int)$pdo->query("SELECT COUNT(*) FROM hostel_applications")->fetchColumn();
        $confirmedCount = (int)$pdo->query("SELECT COUNT(*) FROM allocation_list WHERE status = 'Confirm'")->fetchColumn();
        $pendingCount = (int)$pdo->query("SELECT COUNT(*) FROM allocation_list WHERE status = 'pending'")->fetchColumn();
        $cancelledCount = (int)$pdo->query("SELECT COUNT(*) FROM allocation_list WHERE status = 'Cancelled'")->fetchColumn();

        // Recent applications
        $stmtRecent = $pdo->query("SELECT * FROM hostel_applications ORDER BY created_at DESC, id DESC LIMIT 5");
        $recentApps = $stmtRecent->fetchAll(PDO::FETCH_ASSOC);

        // Block-wise occupancy
        $stmtBlocks = $pdo->query("SELECT * FROM hostels ORDER BY block_name ASC");
        while ($b = $stmtBlocks->fetch(PDO::FETCH_ASSOC)) {
            $bName = $b['block_name'];
            $cap = (int)$b['capacity'];

            $stmtOcc = $pdo->prepare("SELECT 
                COUNT(CASE WHEN status != 'Cancelled' THEN 1 END) AS filled,
                COUNT(CASE WHEN status = 'Confirm' THEN 1 END) AS confirmed
                FROM allocation_list WHERE hostel_block = ?");
            $stmtOcc->execute([$bName]);
            $occ = $stmtOcc->fetch(PDO::FETCH_ASSOC);

            $filled = (int)($occ['filled'] ?? 0);
            $confirmed = (int)($occ['confirmed'] ?? 0);
            $available = max(0, $cap - $filled);
            $percent = $cap > 0 ? min(100, round(($filled / $cap) * 100)) : 0;

            $blockData[] = [
                'block' => $bName,
                'capacity' => $cap,
                'filled' => $filled,
                'confirmed' => $confirmed,
                'available' => $available,
                'percent' => $percent
            ];
        }
    } catch (Exception $e) {
        error_log("Hostel Dashboard metrics error: " . $e->getMessage());
    }
}
?>

<div class="admin-fade-in">

    <!-- Top Action Banner with Live Form Switcher -->
    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 22px 26px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                <span style="font-size: 0.75rem; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase; background: #fff7ed; color: #ff8800; border: 1px solid #fed7aa; padding: 3px 10px; border-radius: 12px;">
                    Academic Year <?= htmlspecialchars($academicYear) ?>
                </span>
                <span id="badgeFormStatus" style="font-size: 0.75rem; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase; padding: 3px 10px; border-radius: 12px; <?= $formIsOpen ? 'background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;' : 'background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca;' ?>">
                    <?= $formIsOpen ? '● ADMISSIONS OPEN' : '○ ADMISSIONS CLOSED' ?>
                </span>
            </div>
            <h2 style="font-size: 1.45rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">Hostel Central Management &amp; Allocation</h2>
            <p style="font-size: 0.88rem; color: #64748b; margin: 0;">Control online application intake, view incoming student forms, and run automated seat allocation.</p>
        </div>

        <!-- Form Status Toggle Button -->
        <div style="display: flex; align-items: center; gap: 12px;">
            <label style="font-size: 0.90rem; font-weight: 700; color: #1e293b; cursor: pointer; user-select: none;" for="toggleFormIntake">
                Student Online Form:
            </label>
            <label for="toggleFormIntake" style="position: relative; width: 62px; height: 32px; display: inline-block; cursor: pointer; margin: 0; user-select: none;">
                <input type="checkbox" id="toggleFormIntake" style="position: absolute; opacity: 0; width: 0; height: 0;" <?= $formIsOpen ? 'checked' : '' ?> onchange="toggleFormIntakeState(this.checked)">
                <span id="switchSlider" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: <?= $formIsOpen ? '#ff8800' : '#cbd5e1' ?>; transition: .3s; border-radius: 34px;">
                    <span id="switchCircle" style="position: absolute; content: ''; height: 24px; width: 24px; left: <?= $formIsOpen ? '34px' : '4px' ?>; bottom: 4px; background-color: white; transition: .3s; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.2);"></span>
                </span>
            </label>
            <a href="../student-corner/hostel-admission.php" target="_blank" class="btn btn-secondary" style="font-size: 0.84rem; padding: 7px 14px; text-decoration: none; border-radius: 6px;">
                <i class="fas fa-external-link-alt"></i> Preview Form
            </a>
        </div>
    </div>

    <!-- 4 Key Metrics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 26px;">
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span style="font-size: 0.82rem; font-weight: 700; text-transform: uppercase; color: #64748b;">Total Applications</span>
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #fff7ed; color: #ff8800; display: flex; align-items: center; justify-content: center; font-size: 1.05rem;">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
            <div style="font-size: 1.85rem; font-weight: 800; color: #0f172a;"><?= number_format($totalApps) ?></div>
            <div style="font-size: 0.80rem; color: #64748b; margin-top: 4px;">Registered students for hostel</div>
        </div>

        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span style="font-size: 0.82rem; font-weight: 700; text-transform: uppercase; color: #64748b;">Confirmed Admissions</span>
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #ecfdf5; color: #047857; display: flex; align-items: center; justify-content: center; font-size: 1.05rem;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div style="font-size: 1.85rem; font-weight: 800; color: #047857;"><?= number_format($confirmedCount) ?></div>
            <div style="font-size: 0.80rem; color: #64748b; margin-top: 4px;">Room verified &amp; allotted</div>
        </div>

        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span style="font-size: 0.82rem; font-weight: 700; text-transform: uppercase; color: #64748b;">Pending Reporting</span>
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #fffbeb; color: #b45309; display: flex; align-items: center; justify-content: center; font-size: 1.05rem;">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div style="font-size: 1.85rem; font-weight: 800; color: #b45309;"><?= number_format($pendingCount) ?></div>
            <div style="font-size: 0.80rem; color: #64748b; margin-top: 4px;">Awaiting office physical reporting</div>
        </div>

        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span style="font-size: 0.82rem; font-weight: 700; text-transform: uppercase; color: #64748b;">Cancelled / Expired</span>
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #fef2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 1.05rem;">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
            <div style="font-size: 1.85rem; font-weight: 800; color: #dc2626;"><?= number_format($cancelledCount) ?></div>
            <div style="font-size: 0.80rem; color: #64748b; margin-top: 4px;">Non-reported or cancelled seats</div>
        </div>
    </div>

    <!-- Quick Navigation Shortcuts -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 14px; margin-bottom: 26px;">
        <a href="hostel-applications.php" class="btn" style="background: #ffffff; border: 1.5px solid #cbd5e1; color: #1e293b; padding: 14px 18px; border-radius: 8px; font-weight: 700; font-size: 0.90rem; display: flex; align-items: center; justify-content: space-between; text-decoration: none; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <span><i class="fas fa-address-book" style="color: #ff8800; margin-right: 8px;"></i> View Applications</span>
            <i class="fas fa-arrow-right" style="font-size: 0.80rem; color: #94a3b8;"></i>
        </a>
        <a href="hostel-blocks.php" class="btn" style="background: #ffffff; border: 1.5px solid #cbd5e1; color: #1e293b; padding: 14px 18px; border-radius: 8px; font-weight: 700; font-size: 0.90rem; display: flex; align-items: center; justify-content: space-between; text-decoration: none; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <span><i class="fas fa-building" style="color: #ff8800; margin-right: 8px;"></i> Manage Blocks &amp; Quotas</span>
            <i class="fas fa-arrow-right" style="font-size: 0.80rem; color: #94a3b8;"></i>
        </a>
        <a href="hostel-allocation.php" class="btn" style="background: #ffffff; border: 1.5px solid #cbd5e1; color: #1e293b; padding: 14px 18px; border-radius: 8px; font-weight: 700; font-size: 0.90rem; display: flex; align-items: center; justify-content: space-between; text-decoration: none; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <span><i class="fas fa-cogs" style="color: #ff8800; margin-right: 8px;"></i> Run Allocation &amp; Merit</span>
            <i class="fas fa-arrow-right" style="font-size: 0.80rem; color: #94a3b8;"></i>
        </a>
        <a href="hostel-confirmation.php" class="btn" style="background: #ffffff; border: 1.5px solid #cbd5e1; color: #1e293b; padding: 14px 18px; border-radius: 8px; font-weight: 700; font-size: 0.90rem; display: flex; align-items: center; justify-content: space-between; text-decoration: none; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
            <span><i class="fas fa-door-open" style="color: #ff8800; margin-right: 8px;"></i> Room Allotment Desk</span>
            <i class="fas fa-arrow-right" style="font-size: 0.80rem; color: #94a3b8;"></i>
        </a>
    </div>

    <!-- Two-Column Layout: Block Occupancy & Recent Applications -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 22px; margin-bottom: 26px;">

        <!-- Left Column: Block Occupancy -->
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                <h3 style="font-size: 1.10rem; font-weight: 800; color: #0f172a; margin: 0;">Hostel Block Capacity Status</h3>
                <a href="hostel-blocks.php" style="font-size: 0.82rem; font-weight: 700; color: #ff8800; text-decoration: none;">Manage All &rarr;</a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                <?php if (empty($blockData)): ?>
                    <p style="color: #64748b; font-size: 0.90rem; text-align: center; margin: 20px 0;">No hostel blocks configured yet.</p>
                <?php else: ?>
                    <?php foreach ($blockData as $b): ?>
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 16px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                <strong style="font-size: 0.94rem; color: #1e293b;"><?= htmlspecialchars($b['block']) ?></strong>
                                <span style="font-size: 0.82rem; color: #475569;">
                                    <strong><?= $b['filled'] ?></strong> / <?= $b['capacity'] ?> Seats (<?= $b['percent'] ?>%)
                                </span>
                            </div>
                            <!-- Progress Bar -->
                            <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden; margin-bottom: 8px;">
                                <div style="width: <?= $b['percent'] ?>%; height: 100%; background: <?= $b['percent'] > 90 ? '#ef4444' : ($b['percent'] > 60 ? '#f59e0b' : '#ff8800') ?>; border-radius: 4px; transition: width .4s;"></div>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.78rem; color: #64748b;">
                                <span>Confirmed: <strong style="color: #047857;"><?= $b['confirmed'] ?></strong></span>
                                <span>Available Vacant: <strong style="color: #b45309;"><?= $b['available'] ?></strong></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column: Recent Applications -->
        <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                <h3 style="font-size: 1.10rem; font-weight: 800; color: #0f172a; margin: 0;">Recent Registrations</h3>
                <a href="hostel-applications.php" style="font-size: 0.82rem; font-weight: 700; color: #ff8800; text-decoration: none;">View All (<?= $totalApps ?>) &rarr;</a>
            </div>

            <?php if (empty($recentApps)): ?>
                <div style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                    <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 10px; color: #cbd5e1;"></i>
                    <p style="margin: 0; font-size: 0.90rem;">No student applications received yet.</p>
                </div>
            <?php else: ?>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <?php foreach ($recentApps as $app): ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                            <div>
                                <div style="font-weight: 700; font-size: 0.90rem; color: #0f172a;"><?= htmlspecialchars($app['student_name']) ?></div>
                                <div style="font-size: 0.78rem; color: #64748b; margin-top: 2px;">
                                    <span><?= htmlspecialchars($app['branch']) ?> (Sem <?= htmlspecialchars($app['current_sem']) ?>)</span> &bull; 
                                    <span>Rank: <?= htmlspecialchars($app['acpc_merit_rank']) ?></span> &bull; 
                                    <span><?= htmlspecialchars($app['district']) ?></span>
                                </div>
                            </div>
                            <span style="font-size: 0.75rem; font-weight: 800; padding: 3px 8px; border-radius: 6px; background: #fff7ed; color: #ff8800; border: 1px solid #fed7aa;">
                                <?= htmlspecialchars($app['category']) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

</div>

<script>
function toggleFormIntakeState(isOpen) {
    const statusVal = isOpen ? 1 : 0;
    const slider = document.getElementById('switchSlider');
    const circle = document.getElementById('switchCircle');
    const badge = document.getElementById('badgeFormStatus');

    slider.style.backgroundColor = isOpen ? '#ff8800' : '#cbd5e1';
    circle.style.left = isOpen ? '34px' : '4px';

    fetch('hostel-dashboard.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=toggle_form_status&status=' + encodeURIComponent(statusVal)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            if (isOpen) {
                badge.style.background = '#ecfdf5';
                badge.style.color = '#047857';
                badge.style.border = '1px solid #a7f3d0';
                badge.textContent = '● ADMISSIONS OPEN';
            } else {
                badge.style.background = '#fef2f2';
                badge.style.color = '#b91c1c';
                badge.style.border = '1px solid #fecaca';
                badge.textContent = '○ ADMISSIONS CLOSED';
            }
        } else {
            alert('Failed to update form status: ' + (data.error || 'Unknown error'));
            document.getElementById('toggleFormIntake').checked = !isOpen;
            slider.style.backgroundColor = !isOpen ? '#ff8800' : '#cbd5e1';
            circle.style.left = !isOpen ? '34px' : '4px';
        }
    })
    .catch(err => {
        console.error(err);
        alert('Server communication error.');
        document.getElementById('toggleFormIntake').checked = !isOpen;
        slider.style.backgroundColor = !isOpen ? '#ff8800' : '#cbd5e1';
        circle.style.left = !isOpen ? '34px' : '4px';
    });
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
