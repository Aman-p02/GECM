<?php
$current_page = 'hostel-blocks';
$page_title = 'Hostel Blocks & Seat Quotas';
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();

// Handle Save Block Configuration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_block') {
    $blockId = (int)($_POST['id'] ?? 0);
    $capacity = (int)($_POST['capacity'] ?? 0);
    $round = (int)($_POST['round'] ?? 1);
    $ce = (int)($_POST['ce_seats'] ?? 0);
    $it = (int)($_POST['it_seats'] ?? 0);
    $ec = (int)($_POST['ec_seats'] ?? 0);
    $mech = (int)($_POST['mechanical_seats'] ?? 0);
    $civil = (int)($_POST['civil_seats'] ?? 0);
    $elec = (int)($_POST['electrical_seats'] ?? 0);
    $auto = (int)($_POST['automobile_seats'] ?? 0);

    if ($blockId > 0 && $pdo) {
        try {
            $stmtUpd = $pdo->prepare("UPDATE hostels SET 
                capacity = ?, round = ?, ce_seats = ?, it_seats = ?, ec_seats = ?, 
                mechanical_seats = ?, civil_seats = ?, electrical_seats = ?, automobile_seats = ?
                WHERE id = ?");
            $stmtUpd->execute([$capacity, $round, $ce, $it, $ec, $mech, $civil, $elec, $auto, $blockId]);
            setFlashMessage('success', 'Hostel block seat configuration updated successfully.');
        } catch (Exception $e) {
            setFlashMessage('danger', 'Error updating block: ' . $e->getMessage());
        }
    }
    header('Location: hostel-blocks.php');
    exit;
}

$blocks = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM hostels ORDER BY block_name ASC");
        $blocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}
?>

<div class="admin-fade-in">

    <!-- Header Banner -->
    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px 24px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">Hostel Blocks &amp; Seat Quotas</h2>
            <p style="font-size: 0.86rem; color: #64748b; margin: 0;">Configure total bed capacity and branch-wise seat quotas used by the automated allocation algorithm.</p>
        </div>
        <div>
            <a href="hostel-allocation.php" class="btn btn-primary" style="background: #ff8800; border-color: #ff8800; color: #fff; font-weight: 700; font-size: 0.88rem; padding: 8px 16px; border-radius: 6px; text-decoration: none;">
                <i class="fas fa-play"></i> Run Allocation Algorithm
            </a>
        </div>
    </div>

    <!-- Blocks Table -->
    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.76rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <th style="padding: 14px 16px;">Block Name</th>
                        <th style="padding: 14px 16px;">Active Round</th>
                        <th style="padding: 14px 16px;">Total Capacity</th>
                        <th style="padding: 14px 16px; text-align: center;">CE</th>
                        <th style="padding: 14px 16px; text-align: center;">IT</th>
                        <th style="padding: 14px 16px; text-align: center;">EC</th>
                        <th style="padding: 14px 16px; text-align: center;">Mech</th>
                        <th style="padding: 14px 16px; text-align: center;">Civil</th>
                        <th style="padding: 14px 16px; text-align: center;">Elec</th>
                        <th style="padding: 14px 16px; text-align: center;">Auto</th>
                        <th style="padding: 14px 16px; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($blocks)): ?>
                        <tr>
                            <td colspan="11" style="padding: 30px; text-align: center; color: #94a3b8;">No blocks found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($blocks as $blk): ?>
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#ffffff'">
                                <td style="padding: 14px 16px; font-weight: 800; color: #0f172a;">
                                    <span style="font-size: 0.95rem;"><?= htmlspecialchars($blk['block_name']) ?></span>
                                </td>
                                <td style="padding: 14px 16px;">
                                    <span style="background: #fff7ed; color: #ff8800; border: 1px solid #fed7aa; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 0.78rem;">
                                        Round <?= (int)$blk['round'] ?>
                                    </span>
                                </td>
                                <td style="padding: 14px 16px; font-weight: 800; color: #047857; font-size: 1rem;">
                                    <?= (int)$blk['capacity'] ?> Beds
                                </td>
                                <td style="padding: 14px 16px; text-align: center; font-weight: 600;"><?= (int)$blk['ce_seats'] ?></td>
                                <td style="padding: 14px 16px; text-align: center; font-weight: 600;"><?= (int)$blk['it_seats'] ?></td>
                                <td style="padding: 14px 16px; text-align: center; font-weight: 600;"><?= (int)$blk['ec_seats'] ?></td>
                                <td style="padding: 14px 16px; text-align: center; font-weight: 600;"><?= (int)$blk['mechanical_seats'] ?></td>
                                <td style="padding: 14px 16px; text-align: center; font-weight: 600;"><?= (int)$blk['civil_seats'] ?></td>
                                <td style="padding: 14px 16px; text-align: center; font-weight: 600;"><?= (int)$blk['electrical_seats'] ?></td>
                                <td style="padding: 14px 16px; text-align: center; font-weight: 600;"><?= (int)$blk['automobile_seats'] ?></td>
                                <td style="padding: 14px 16px; text-align: right;">
                                    <button type="button" class="btn btn-sm" style="background: #0f172a; color: #fff; font-weight: 600; padding: 6px 12px; border-radius: 6px; font-size: 0.82rem;" onclick="editBlock(<?= htmlspecialchars(json_encode($blk), ENT_QUOTES, 'UTF-8') ?>)">
                                        <i class="fas fa-edit"></i> Edit Quota
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Edit Block Modal -->
<div id="editBlockModal" style="display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; width: 100%; max-width: 580px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); overflow: hidden;">
        <form method="POST" action="hostel-blocks.php">
            <input type="hidden" name="action" value="save_block">
            <input type="hidden" name="id" id="editBlockId">

            <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
                <h4 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;" id="editBlockTitle">Configure Block</h4>
                <button type="button" onclick="closeEditModal()" style="border: none; background: transparent; font-size: 1.4rem; color: #64748b; cursor: pointer;">&times;</button>
            </div>

            <div style="padding: 22px 24px; display: flex; flex-direction: column; gap: 16px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div>
                        <label style="font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">Total Bed Capacity</label>
                        <input type="number" name="capacity" id="editCapacity" class="form-control" required min="1" style="font-size: 0.90rem; height: 38px;">
                    </div>
                    <div>
                        <label style="font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 4px; display: block;">Allocation Round</label>
                        <select name="round" id="editRound" class="form-control" style="font-size: 0.90rem; height: 38px;">
                            <option value="1">Round 1</option>
                            <option value="2">Round 2</option>
                            <option value="3">Round 3</option>
                            <option value="4">Round 4</option>
                            <option value="5">Round 5</option>
                        </select>
                    </div>
                </div>

                <div style="border-top: 1px solid #f1f5f9; padding-top: 14px;">
                    <span style="font-size: 0.82rem; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 10px;">
                        Branch-wise Seat Distribution
                    </span>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;">
                        <div>
                            <label style="font-size: 0.78rem; font-weight: 700; color: #64748b;">CE Seats</label>
                            <input type="number" name="ce_seats" id="editCe" class="form-control" min="0" style="height: 36px;">
                        </div>
                        <div>
                            <label style="font-size: 0.78rem; font-weight: 700; color: #64748b;">IT Seats</label>
                            <input type="number" name="it_seats" id="editIt" class="form-control" min="0" style="height: 36px;">
                        </div>
                        <div>
                            <label style="font-size: 0.78rem; font-weight: 700; color: #64748b;">EC Seats</label>
                            <input type="number" name="ec_seats" id="editEc" class="form-control" min="0" style="height: 36px;">
                        </div>
                        <div>
                            <label style="font-size: 0.78rem; font-weight: 700; color: #64748b;">Mechanical</label>
                            <input type="number" name="mechanical_seats" id="editMech" class="form-control" min="0" style="height: 36px;">
                        </div>
                        <div>
                            <label style="font-size: 0.78rem; font-weight: 700; color: #64748b;">Civil Seats</label>
                            <input type="number" name="civil_seats" id="editCivil" class="form-control" min="0" style="height: 36px;">
                        </div>
                        <div>
                            <label style="font-size: 0.78rem; font-weight: 700; color: #64748b;">Electrical</label>
                            <input type="number" name="electrical_seats" id="editElec" class="form-control" min="0" style="height: 36px;">
                        </div>
                        <div>
                            <label style="font-size: 0.78rem; font-weight: 700; color: #64748b;">Automobile</label>
                            <input type="number" name="automobile_seats" id="editAuto" class="form-control" min="0" style="height: 36px;">
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding: 14px 24px; border-top: 1px solid #e2e8f0; text-align: right; background: #f8fafc; display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary" style="padding: 6px 16px; font-size: 0.88rem;">Cancel</button>
                <button type="submit" class="btn btn-primary" style="background: #ff8800; border-color: #ff8800; color: #fff; padding: 6px 20px; font-weight: 700; font-size: 0.88rem;">Save Configuration</button>
            </div>
        </form>
    </div>
</div>

<script>
function editBlock(blk) {
    document.getElementById('editBlockId').value = blk.id;
    document.getElementById('editBlockTitle').textContent = 'Configure ' + blk.block_name;
    document.getElementById('editCapacity').value = blk.capacity;
    document.getElementById('editRound').value = blk.round;
    document.getElementById('editCe').value = blk.ce_seats;
    document.getElementById('editIt').value = blk.it_seats;
    document.getElementById('editEc').value = blk.ec_seats;
    document.getElementById('editMech').value = blk.mechanical_seats;
    document.getElementById('editCivil').value = blk.civil_seats;
    document.getElementById('editElec').value = blk.electrical_seats;
    document.getElementById('editAuto').value = blk.automobile_seats;

    document.getElementById('editBlockModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editBlockModal').style.display = 'none';
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
