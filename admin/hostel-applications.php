<?php
$current_page = 'hostel-applications';
$page_title = 'Hostel Student Applications';
require_once __DIR__ . '/includes/header.php';

$pdo = getDBConnection();

// Handle Delete Application
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_app') {
    $deleteId = (int)($_POST['id'] ?? 0);
    if ($deleteId > 0 && $pdo) {
        try {
            $stmtDel = $pdo->prepare("DELETE FROM hostel_applications WHERE id = ?");
            $stmtDel->execute([$deleteId]);
            setFlashMessage('success', 'Application #' . $deleteId . ' has been deleted successfully.');
        } catch (Exception $e) {
            setFlashMessage('danger', 'Error deleting application: ' . $e->getMessage());
        }
    }
    header('Location: hostel-applications.php');
    exit;
}

// Filters & Search
$search = trim($_GET['search'] ?? '');
$branch = trim($_GET['branch'] ?? '');
$sem = trim($_GET['sem'] ?? '');
$category = trim($_GET['category'] ?? '');

$where = [];
$params = [];

if (!empty($search)) {
    $where[] = "(student_name LIKE ? OR acpc_merit_rank LIKE ? OR contact_number LIKE ? OR district LIKE ?)";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}

if (!empty($branch)) {
    $where[] = "branch = ?";
    $params[] = $branch;
}

if (!empty($sem)) {
    $where[] = "current_sem = ?";
    $params[] = $sem;
}

if (!empty($category)) {
    $where[] = "category = ?";
    $params[] = $category;
}

$whereSql = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$applications = [];
$totalFiltered = 0;

if ($pdo) {
    try {
        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM hostel_applications $whereSql");
        $countStmt->execute($params);
        $totalFiltered = (int)$countStmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT ha.*, l.Distance_From_Modasa 
                               FROM hostel_applications ha 
                               LEFT JOIN location l ON ha.district = l.District AND ha.taluka = l.Taluka 
                               $whereSql 
                               ORDER BY ha.created_at DESC, ha.id DESC");
        $stmt->execute($params);
        $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Applications fetch error: " . $e->getMessage());
    }
}
?>

<div class="admin-fade-in">

    <!-- Header & Action Bar -->
    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 20px 24px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
        <div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">Student Hostel Applications</h2>
            <p style="font-size: 0.86rem; color: #64748b; margin: 0;">Showing <strong><?= $totalFiltered ?></strong> registered students matching current filters.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="hostel-allocation.php" class="btn btn-primary" style="background: #ff8800; border-color: #ff8800; color: #fff; font-weight: 700; font-size: 0.88rem; padding: 8px 16px; border-radius: 6px; text-decoration: none;">
                <i class="fas fa-play-circle"></i> Proceed to Allocation Wizard
            </a>
        </div>
    </div>

    <!-- Filters Strip -->
    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 16px 20px; margin-bottom: 22px; box-shadow: 0 1px 4px rgba(0,0,0,0.03);">
        <form method="GET" action="hostel-applications.php" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto auto; gap: 12px; align-items: end;">
            <div>
                <label style="font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 4px; display: block;">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Search name, ACPC rank, mobile, district..." value="<?= htmlspecialchars($search) ?>" style="font-size: 0.88rem; height: 38px;">
            </div>

            <div>
                <label style="font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 4px; display: block;">Branch</label>
                <select name="branch" class="form-control" style="font-size: 0.88rem; height: 38px;">
                    <option value="">All Branches</option>
                    <option value="CE" <?= ($branch === 'CE') ? 'selected' : '' ?>>Computer (CE)</option>
                    <option value="IT" <?= ($branch === 'IT') ? 'selected' : '' ?>>Info Tech (IT)</option>
                    <option value="EC" <?= ($branch === 'EC') ? 'selected' : '' ?>>EC</option>
                    <option value="Mechanical" <?= ($branch === 'Mechanical') ? 'selected' : '' ?>>Mechanical</option>
                    <option value="Civil" <?= ($branch === 'Civil') ? 'selected' : '' ?>>Civil</option>
                    <option value="Electrical" <?= ($branch === 'Electrical') ? 'selected' : '' ?>>Electrical</option>
                    <option value="Automobile" <?= ($branch === 'Automobile') ? 'selected' : '' ?>>Automobile</option>
                </select>
            </div>

            <div>
                <label style="font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 4px; display: block;">Semester</label>
                <select name="sem" class="form-control" style="font-size: 0.88rem; height: 38px;">
                    <option value="">All Semesters</option>
                    <option value="1" <?= ($sem === '1') ? 'selected' : '' ?>>Sem 1 (1st Year)</option>
                    <option value="3" <?= ($sem === '3') ? 'selected' : '' ?>>Sem 3 (D-to-D / 2nd Year)</option>
                </select>
            </div>

            <div>
                <label style="font-size: 0.78rem; font-weight: 700; color: #475569; text-transform: uppercase; margin-bottom: 4px; display: block;">Category</label>
                <select name="category" class="form-control" style="font-size: 0.88rem; height: 38px;">
                    <option value="">All Categories</option>
                    <option value="Open" <?= ($category === 'Open') ? 'selected' : '' ?>>Open</option>
                    <option value="Open-EWS" <?= ($category === 'Open-EWS') ? 'selected' : '' ?>>Open-EWS</option>
                    <option value="SEBC" <?= ($category === 'SEBC') ? 'selected' : '' ?>>SEBC</option>
                    <option value="SC" <?= ($category === 'SC') ? 'selected' : '' ?>>SC</option>
                    <option value="ST" <?= ($category === 'ST') ? 'selected' : '' ?>>ST</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="background: #0f172a; border-color: #0f172a; color: #fff; height: 38px; padding: 0 18px; font-weight: 700; font-size: 0.88rem;">
                <i class="fas fa-filter"></i> Apply
            </button>

            <?php if (!empty($search) || !empty($branch) || !empty($sem) || !empty($category)): ?>
                <a href="hostel-applications.php" class="btn btn-secondary" style="height: 38px; display: flex; align-items: center; justify-content: center; padding: 0 14px; font-size: 0.88rem; text-decoration: none;">
                    Reset
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Data Table Card -->
    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.88rem;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1.5px solid #e2e8f0; color: #475569; font-size: 0.76rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <th style="padding: 14px 16px;">App ID</th>
                        <th style="padding: 14px 16px;">Student Name</th>
                        <th style="padding: 14px 16px;">Branch &amp; Sem</th>
                        <th style="padding: 14px 16px;">ACPC Rank</th>
                        <th style="padding: 14px 16px;">Category</th>
                        <th style="padding: 14px 16px;">District &amp; Distance</th>
                        <th style="padding: 14px 16px;">Contact</th>
                        <th style="padding: 14px 16px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($applications)): ?>
                        <tr>
                            <td colspan="8" style="padding: 40px; text-align: center; color: #94a3b8;">
                                <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 10px; color: #cbd5e1;"></i>
                                <p style="margin: 0; font-size: 0.92rem;">No hostel applications found matching the selected criteria.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($applications as $app): ?>
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#ffffff'">
                                <td style="padding: 13px 16px; font-weight: 700; color: #ff8800;">
                                    #<?= $app['id'] ?>
                                </td>
                                <td style="padding: 13px 16px;">
                                    <div style="font-weight: 700; color: #0f172a;"><?= htmlspecialchars($app['student_name']) ?></div>
                                    <div style="font-size: 0.78rem; color: #64748b;">Father: <?= htmlspecialchars($app['father_name']) ?></div>
                                </td>
                                <td style="padding: 13px 16px;">
                                    <span style="font-weight: 700; color: #1e293b;"><?= htmlspecialchars($app['branch']) ?></span>
                                    <span style="font-size: 0.78rem; color: #64748b; display: block;">Sem <?= htmlspecialchars($app['current_sem']) ?></span>
                                </td>
                                <td style="padding: 13px 16px; font-weight: 700; color: #0f172a;">
                                    <?= htmlspecialchars($app['acpc_merit_rank']) ?>
                                </td>
                                <td style="padding: 13px 16px;">
                                    <span style="font-size: 0.76rem; font-weight: 800; padding: 3px 8px; border-radius: 6px; background: #fff7ed; color: #ff8800; border: 1px solid #fed7aa;">
                                        <?= htmlspecialchars($app['category']) ?>
                                    </span>
                                </td>
                                <td style="padding: 13px 16px;">
                                    <div style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($app['district']) ?></div>
                                    <div style="font-size: 0.78rem; color: #047857; font-weight: 700;">
                                        <?= isset($app['Distance_From_Modasa']) ? $app['Distance_From_Modasa'] . ' KM away' : 'Distance N/A' ?>
                                    </div>
                                </td>
                                <td style="padding: 13px 16px; font-size: 0.84rem; color: #475569;">
                                    <div><i class="fas fa-phone" style="font-size: 11px; color: #94a3b8; margin-right: 4px;"></i> <?= htmlspecialchars($app['contact_number']) ?></div>
                                    <div style="font-size: 0.78rem; color: #64748b;"><?= htmlspecialchars($app['email']) ?></div>
                                </td>
                                <td style="padding: 13px 16px; text-align: right;">
                                    <div style="display: inline-flex; gap: 6px;">
                                        <button type="button" class="btn btn-sm" style="background: #f1f5f9; color: #1e293b; border: 1px solid #cbd5e1; padding: 5px 10px; border-radius: 6px;" onclick="showAppDetails(<?= htmlspecialchars(json_encode($app), ENT_QUOTES, 'UTF-8') ?>)">
                                            <i class="fas fa-eye"></i> Details
                                        </button>
                                        <form method="POST" action="hostel-applications.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to permanently delete application #<?= $app['id'] ?>?');">
                                            <input type="hidden" name="action" value="delete_app">
                                            <input type="hidden" name="id" value="<?= $app['id'] ?>">
                                            <button type="submit" class="btn btn-sm" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 5px 10px; border-radius: 6px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Student Details Modal -->
<div id="appModal" style="display: none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; width: 100%; max-width: 620px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); overflow: hidden; max-height: 90vh; display: flex; flex-direction: column;">
        <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <h4 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a;" id="modalTitle">Application Details</h4>
            <button type="button" onclick="closeAppModal()" style="border: none; background: transparent; font-size: 1.4rem; color: #64748b; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 24px; overflow-y: auto;" id="modalBody">
            <!-- Injected via JS -->
        </div>
        <div style="padding: 14px 24px; border-top: 1px solid #e2e8f0; text-align: right; background: #f8fafc;">
            <button type="button" onclick="closeAppModal()" class="btn btn-secondary" style="padding: 6px 18px; font-size: 0.88rem;">Close</button>
        </div>
    </div>
</div>

<script>
function showAppDetails(app) {
    document.getElementById('modalTitle').textContent = 'Application #' + app.id + ' - ' + app.student_name;
    const body = document.getElementById('modalBody');

    let photoHtml = app.photo_path ? 
        `<img src="../${app.photo_path.replace('../../', '')}" style="width: 80px; height: 95px; object-fit: cover; border-radius: 6px; border: 1.5px solid #cbd5e1;" onerror="this.style.display='none'">` :
        `<div style="width: 80px; height: 95px; background: #f1f5f9; border-radius: 6px; border: 1.5px solid #cbd5e1; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 12px;">No Photo</div>`;

    body.innerHTML = `
        <div style="display: flex; gap: 20px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9;">
            ${photoHtml}
            <div>
                <h3 style="margin: 0 0 4px 0; font-size: 1.25rem; font-weight: 800; color: #0f172a;">${app.student_name}</h3>
                <div style="color: #64748b; font-size: 0.88rem; margin-bottom: 6px;">Father's Name: <strong>${app.father_name}</strong></div>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <span style="font-size: 0.76rem; font-weight: 800; padding: 2px 8px; border-radius: 6px; background: #fff7ed; color: #ff8800; border: 1px solid #fed7aa;">${app.category}</span>
                    <span style="font-size: 0.76rem; font-weight: 800; padding: 2px 8px; border-radius: 6px; background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;">${app.gender}</span>
                    <span style="font-size: 0.76rem; font-weight: 800; padding: 2px 8px; border-radius: 6px; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">${app.branch} (Sem ${app.current_sem})</span>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 0.88rem; margin-bottom: 16px;">
            <div style="background: #f8fafc; padding: 10px 14px; border-radius: 6px; border: 1px solid #e2e8f0;">
                <span style="color: #64748b; font-size: 0.78rem; text-transform: uppercase; font-weight: 700; display: block;">ACPC Merit Rank</span>
                <strong style="font-size: 1.10rem; color: #0f172a;">${app.acpc_merit_rank}</strong>
            </div>
            <div style="background: #f8fafc; padding: 10px 14px; border-radius: 6px; border: 1px solid #e2e8f0;">
                <span style="color: #64748b; font-size: 0.78rem; text-transform: uppercase; font-weight: 700; display: block;">Distance From Modasa</span>
                <strong style="font-size: 1.10rem; color: #047857;">${app.Distance_From_Modasa || '0'} KM</strong>
            </div>
        </div>

        <div style="font-size: 0.88rem; display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px;">
            <div><span style="color: #64748b; font-weight: 600;">District / Taluka:</span> <strong>${app.district} / ${app.taluka}</strong></div>
            <div><span style="color: #64748b; font-weight: 600;">Permanent Address:</span> ${app.perm_address || 'N/A'}</div>
            <div><span style="color: #64748b; font-weight: 600;">Contact Number:</span> <strong>${app.contact_number}</strong></div>
            <div><span style="color: #64748b; font-weight: 600;">Email:</span> ${app.email}</div>
            <div><span style="color: #64748b; font-weight: 600;">Annual Parent Income:</span> ₹${app.annual_income || 'N/A'}</div>
            <div><span style="color: #64748b; font-weight: 600;">Previous Exam Result:</span> ${app.last_exam || '12th'} (${app.passing_year || ''}) - <strong>${app.result_percent || ''}%</strong></div>
        </div>
    `;

    document.getElementById('appModal').style.display = 'flex';
}

function closeAppModal() {
    document.getElementById('appModal').style.display = 'none';
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
