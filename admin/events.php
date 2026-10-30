<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $event_date = !empty($_POST['event_date']) ? $_POST['event_date'] : null;
        $view_url = trim($_POST['view_url'] ?? '#');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        // Process uploaded image
        $upload = handleImageUpload('event_image', 'events', null, $_POST['image_url'] ?? null);
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: events.php');
            exit;
        }

        $image_url = $upload['path'];

        if (!empty($title) && !empty($image_url)) {
            $stmt = $pdo->prepare("INSERT INTO events (title, description, image_url, event_date, view_url, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $image_url, $event_date, $view_url, $display_order, $is_active]);
            setFlashMessage('success', 'Event added successfully!');
            header('Location: events.php');
            exit;
        } else {
            setFlashMessage('danger', 'Event title and image are required.');
        }
    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            try {
                $imgStmt = $pdo->prepare("SELECT image_url FROM events WHERE id = ?");
                $imgStmt->execute([$id]);
                $imagePath = $imgStmt->fetchColumn();

                $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
                $stmt->execute([$id]);

                if ($imagePath && strpos($imagePath, 'uploads/') === 0) {
                    $physicalFile = __DIR__ . '/../../' . $imagePath;
                    if (file_exists($physicalFile)) {
                        @unlink($physicalFile);
                    }
                }

                setFlashMessage('success', 'Event has been permanently deleted from the database!');
            } catch (Exception $e) {
                error_log("Event delete error: " . $e->getMessage());
                setFlashMessage('danger', 'Could not delete event: ' . $e->getMessage());
            }
            header('Location: events.php');
            exit;
        }
    } elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $existingImage = trim($_POST['existing_image'] ?? '');
        $event_date = !empty($_POST['event_date']) ? $_POST['event_date'] : null;
        $view_url = trim($_POST['view_url'] ?? '#');
        $display_order = (int)($_POST['display_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        // Process uploaded image or retain existing file
        $upload = handleImageUpload('event_image', 'events', $existingImage, $_POST['image_url'] ?? null);
        if (!$upload['success']) {
            setFlashMessage('danger', $upload['error']);
            header('Location: events.php?edit=' . $id);
            exit;
        }

        $image_url = $upload['path'];

        if (!empty($title) && !empty($image_url) && $id > 0) {
            $stmt = $pdo->prepare("UPDATE events SET title = ?, description = ?, image_url = ?, event_date = ?, view_url = ?, display_order = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $description, $image_url, $event_date, $view_url, $display_order, $is_active, $id]);
            setFlashMessage('success', 'Event updated successfully!');
            header('Location: events.php');
            exit;
        }
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        try {
            // 1. Fetch image path to delete file from storage if local
            $imgStmt = $pdo->prepare("SELECT image_url FROM events WHERE id = ?");
            $imgStmt->execute([$id]);
            $imagePath = $imgStmt->fetchColumn();

            // 2. Delete event record directly from database
            $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
            $stmt->execute([$id]);

            // 3. Remove physical file from uploads folder if local
            if ($imagePath && strpos($imagePath, 'uploads/') === 0) {
                $physicalFile = __DIR__ . '/../../' . $imagePath;
                if (file_exists($physicalFile)) {
                    @unlink($physicalFile);
                }
            }

            setFlashMessage('success', 'Event has been permanently deleted from the database!');
        } catch (Exception $e) {
            error_log("Event delete error: " . $e->getMessage());
            setFlashMessage('danger', 'Could not delete event: ' . $e->getMessage());
        }
        header('Location: events.php');
        exit;
    }
}

if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE events SET is_active = IF(is_active = 1, 0, 1) WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('info', 'Event status updated!');
        header('Location: events.php');
        exit;
    }
}

if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

$events = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM events ORDER BY display_order ASC, id ASC");
    $events = $stmt->fetchAll();
}

$current_page = 'events';
$page_title = 'Recent Events Management';
require_once __DIR__ . '/includes/header.php';
?>

<div class="admin-card">
    <div class="card-top">
        <div class="card-title-group">
            <h2 class="card-title">Manage Recent Events</h2>
        </div>
        <button type="button" class="btn-add-new" onclick="openModal('addEventModal')">
            + Add New Event
        </button>
    </div>

    <!-- Actions & Filter Row -->
    <div class="card-actions-row">
        <div class="card-filters" style="margin-left: auto;">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Search events..." data-table-search="eventsTable">
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="admin-table" id="eventsTable">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th style="width: 90px;">Cover</th>
                    <th>Event Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th style="width: 120px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $row): ?>
                <tr data-status="<?= $row['is_active'] ? 'active' : 'inactive' ?>">
                    <td style="font-weight: 700; color: #1e88e5; text-align: center;">#<?= $row['display_order'] ?></td>
                    <td>
                        <img src="<?= htmlspecialchars(getAdminImageSrc($row['image_url'])) ?>" alt="Event Cover" style="width: 60px; height: 42px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;" onerror="this.src='https://via.placeholder.com/60x42?text=Event';">
                    </td>
                    <td style="font-weight: 600; color: #1a263d;">
                        <?= htmlspecialchars($row['title']) ?>
                    </td>
                    <td style="max-width: 320px; color: #666; font-size: 13px;">
                        <?= htmlspecialchars($row['description']) ?>
                    </td>
                    <td>
                        <a href="events.php?toggle=<?= $row['id'] ?>" title="Click to toggle status">
                            <?php if ($row['is_active']): ?>
                                <span class="badge badge-success"><i class="fas fa-check"></i> Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary"><i class="fas fa-eye-slash"></i> Inactive</span>
                            <?php endif; ?>
                        </a>
                    </td>
                    <td style="text-align: center;">
                        <div class="table-actions" style="justify-content: center;">
                            <a href="events.php?edit=<?= $row['id'] ?>" class="btn-table-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="events.php?delete=<?= $row['id'] ?>" class="btn-table-action btn-delete" title="Delete" onclick="return confirm('Delete this event?');">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($events)): ?>
                <tr class="no-records-row">
                    <td colspan="6" style="text-align: center; color: #888; padding: 30px;">No events found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal: Add New Event -->
<div class="modal-overlay" id="addEventModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Add Recent Event</h3>
            <button type="button" class="modal-close" onclick="closeModal('addEventModal')">&times;</button>
        </div>
        <form method="POST" action="events.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="title">Event Title <span class="required">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="e.g. TechFest 2024" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Short Description <span class="required">*</span></label>
                    <textarea name="description" id="description" class="form-control" placeholder="e.g. Annual Technical Symposium with 50+ inter-college events." required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="event_image">Upload Event Cover from PC <span class="required">*</span></label>
                    <input type="file" name="event_image" id="event_image" class="form-control" accept="image/*" required>
                    <small style="color: #777; font-size: 12px; display: block; margin-top: 4px;">
                        Choose image file (WEBP, JPG, PNG) from your PC, or specify URL below:
                    </small>
                    <input type="text" name="image_url" id="image_url" class="form-control" placeholder="Or enter image URL (optional fallback)" style="margin-top: 6px;">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="event_date">Event Date</label>
                        <input type="date" name="event_date" id="event_date" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="display_order">Display Order</label>
                        <input type="number" name="display_order" id="display_order" class="form-control" value="<?= count($events) + 1 ?>" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" checked>
                        <span>Display on Homepage</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addEventModal')">Cancel</button>
                <button type="submit" class="btn-primary"><i class="fas fa-check"></i> Add Event</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Event -->
<?php if ($editItem): ?>
<div class="modal-overlay active" id="editEventModal">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 class="modal-title">Edit Event #<?= $editItem['id'] ?></h3>
            <a href="events.php" class="modal-close">&times;</a>
        </div>
        <form method="POST" action="events.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
            <input type="hidden" name="existing_image" value="<?= htmlspecialchars($editItem['image_url']) ?>">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="edit_title">Event Title <span class="required">*</span></label>
                    <input type="text" name="title" id="edit_title" class="form-control" value="<?= htmlspecialchars($editItem['title']) ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_description">Short Description <span class="required">*</span></label>
                    <textarea name="description" id="edit_description" class="form-control" required><?= htmlspecialchars($editItem['description']) ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Current Event Cover</label>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <img src="<?= htmlspecialchars(getAdminImageSrc($editItem['image_url'])) ?>" alt="Current Cover" style="width: 80px; height: 50px; border-radius: 4px; object-fit: cover; border: 1px solid #ddd;">
                        <span style="font-size: 12px; color: #666; font-family: monospace;"><?= htmlspecialchars($editItem['image_url']) ?></span>
                    </div>
                    <label class="form-label" for="edit_event_image">Upload New Image from PC (optional)</label>
                    <input type="file" name="event_image" id="edit_event_image" class="form-control" accept="image/*">
                    <input type="text" name="image_url" id="edit_image_url" class="form-control" value="<?= htmlspecialchars($editItem['image_url']) ?>" placeholder="Or image URL" style="margin-top: 6px;">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="edit_event_date">Event Date</label>
                        <input type="date" name="event_date" id="edit_event_date" class="form-control" value="<?= htmlspecialchars($editItem['event_date'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="edit_display_order">Display Order</label>
                        <input type="number" name="display_order" id="edit_display_order" class="form-control" value="<?= $editItem['display_order'] ?>" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" <?= $editItem['is_active'] ? 'checked' : '' ?>>
                        <span>Display on Homepage</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="events.php" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
