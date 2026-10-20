<?php
require_once __DIR__ . '/includes/auth.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $message = trim($_POST['message'] ?? '');
        $link_url = trim($_POST['link_url'] ?? '#');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!empty($message)) {
            $stmt = $pdo->prepare("INSERT INTO news_ticker (message, link_url, display_order, is_active) VALUES (?, ?, ?, ?)");
            $stmt->execute([$message, $link_url, $display_order, $is_active]);
            setFlashMessage('success', 'Ticker update added successfully!');
            header('Location: ticker.php');
            exit;
        } else {
            setFlashMessage('danger', 'Ticker message cannot be empty.');
        }
    } elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
        $message = trim($_POST['message'] ?? '');
        $link_url = trim($_POST['link_url'] ?? '#');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!empty($message) && $id > 0) {
            $stmt = $pdo->prepare("UPDATE news_ticker SET message = ?, link_url = ?, display_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$message, $link_url, $display_order, $is_active, $id]);
            setFlashMessage('success', 'Ticker update saved!');
            header('Location: ticker.php');
            exit;
        }
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM news_ticker WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Ticker item deleted!');
        header('Location: ticker.php');
        exit;
    }
}

if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE news_ticker SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('info', 'Ticker status toggled!');
        header('Location: ticker.php');
        exit;
    }
}

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM news_ticker WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

$tickers = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM news_ticker ORDER BY display_order ASC, id ASC");
    $tickers = $stmt->fetchAll();
}

$current_page = 'ticker';
$page_title = 'News Ticker Management';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <i class="fas fa-broadcast-tower"></i>
            <h2 class="card-title">Marquee News Ticker Updates</h2>
        </div>
        <button type="button" class="btn-add-new" onclick="openModal('addTickerModal')">
            <i class="fas fa-plus"></i> Add Ticker Update
        </button>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="card-filters" style="margin-left: auto;">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search ticker..." data-table-search="tickerTable">
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="tickerTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th>Ticker Announcement Message</th>
                    <th>Link URL</th>
                    <th>Status</th>
                    <th style="width: 120px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickers as $row): ?>
                <tr data-status="<?= $row['is_active'] ? 'active' : 'inactive' ?>">
                    <td style="font-weight: 700; color: #1e88e5; text-align: center;">#<?= $row['display_order'] ?></td>
                    <td style="font-weight: 500; color: #1a263d;">
                        <i class="fas fa-bullhorn" style="color: #e53935; margin-right: 8px;"></i>
                        <?= htmlspecialchars($row['message']) ?>
                    </td>
                    <td>
                        <span style="color: #666; font-size: 12.5px;"><?= htmlspecialchars($row['link_url']) ?></span>
                    </td>
                    <td>
                        <a href="ticker.php?toggle=<?= $row['id'] ?>" title="Click to toggle status">
                            <?php if ($row['is_active']): ?>
                                <span class="badge badge-success"><i class="fas fa-check"></i> Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><i class="fas fa-eye-slash"></i> Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <div class="table-actions" style="justify-content: center;">
                            <a href="ticker.php?edit=<?= $row['id'] ?>" class="btn-table-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="ticker.php?delete=<?= $row['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Delete this ticker update?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($tickers)): ?>
                <tr class="no-records-row">
                    <td colspan="5" style="text-align: center; color: #888; padding: 30px;">No ticker messages added yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add New Ticker -->
<div class="modal-overlay" id="addTickerModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-plus-circle" style="color: #1e88e5;"></i> Add News Ticker Update</h3>
            <button type="button" class="modal-close" onclick="closeModal('addTickerModal')">&times;</button>
        </div>
        <form method="POST" action="ticker.php">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="message">Announcement Message <span class="required">*</span></label>
                    <textarea name="message" id="message" class="form-control" placeholder="e.g. Admission open for BE First Year 2024-25." required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="link_url">Target Link URL</label>
                        <input type="text" name="link_url" id="link_url" class="form-control" value="#">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="display_order">Display Order</label>
                        <input type="number" name="display_order" id="display_order" class="form-control" value="<?= count($tickers) + 1 ?>" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Active on homepage marquee</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addTickerModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Add Ticker</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Ticker -->
<?php if ($editItem): ?>
<div class="modal-overlay active" id="editTickerModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fas fa-edit" style="color: #1e88e5;"></i> Edit Ticker #<?= $editItem['id'] ?></h3>
            <a href="ticker.php" class="modal-close">&times;</a>
        </div>
        <form method="POST" action="ticker.php">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_message">Announcement Message <span class="required">*</span></label>
                    <textarea name="message" id="edit_message" class="form-control" required><?= htmlspecialchars($editItem['message']) ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_link_url">Target Link URL</label>
                        <input type="text" name="link_url" id="edit_link_url" class="form-control" value="<?= htmlspecialchars($editItem['link_url']) ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="edit_display_order">Display Order</label>
                        <input type="number" name="display_order" id="edit_display_order" class="form-control" value="<?= $editItem['display_order'] ?>" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                        <span>Active on homepage marquee</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="ticker.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
