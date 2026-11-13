<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/upload_helper.php';
checkAdminAuth();

$pdo = getDBConnection();
$editItem = null;
$page_title = "Manage Principal's Message";
$current_page = 'principal-message';

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP Control Panel.');
        header('Location: principal-message.php');
        exit;
    }
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $principal_name = trim($_POST['principal_name'] ?? '');
        $designation = trim($_POST['designation'] ?? 'Principal, Government Engineering College, Modasa');
        $message_date = trim($_POST['message_date'] ?? date('Y-m-d'));
        $salutation = trim($_POST['salutation'] ?? 'Dear Students, Faculty Members, and all Stakeholders,');
        $greeting = trim($_POST['greeting'] ?? 'Warm greetings to all.');
        $message_body = trim($_POST['message_body'] ?? '');
        $closing = trim($_POST['closing'] ?? "Best wishes for the future.\nSincerely, and with Best Regards,");
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        // Photo upload
        $image_url = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload = handleImageUpload('photo', 'principal');
            if ($upload['success']) {
                $image_url = $upload['path'];
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: principal-message.php');
                exit;
            }
        }

        if (!empty($principal_name) && !empty($message_body)) {
            // If setting this as active, deactivate previous ones
            if ($is_active === 1) {
                $pdo->exec("UPDATE principal_messages SET is_active = 0");
            }

            $stmt = $pdo->prepare("INSERT INTO principal_messages (principal_name, designation, image_url, message_date, salutation, greeting, message_body, closing, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$principal_name, $designation, $image_url, $message_date, $salutation, $greeting, $message_body, $closing, $is_active]);

            setFlashMessage('success', "Principal's message added successfully!");
            header('Location: principal-message.php');
            exit;
        } else {
            setFlashMessage('danger', 'Principal name and message body are required.');
        }
    } elseif ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $principal_name = trim($_POST['principal_name'] ?? '');
        $designation = trim($_POST['designation'] ?? 'Principal, Government Engineering College, Modasa');
        $message_date = trim($_POST['message_date'] ?? date('Y-m-d'));
        $salutation = trim($_POST['salutation'] ?? 'Dear Students, Faculty Members, and all Stakeholders,');
        $greeting = trim($_POST['greeting'] ?? 'Warm greetings to all.');
        $message_body = trim($_POST['message_body'] ?? '');
        $closing = trim($_POST['closing'] ?? "Best wishes for the future.\nSincerely, and with Best Regards,");
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        $existing_image = trim($_POST['existing_image'] ?? '');

        // Photo upload
        $image_url = $existing_image;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload = handleImageUpload('photo', 'principal', $existing_image);
            if ($upload['success']) {
                $image_url = $upload['path'];
            } else {
                setFlashMessage('danger', $upload['error']);
                header('Location: principal-message.php?edit=' . $id);
                exit;
            }
        }

        if (!empty($principal_name) && !empty($message_body) && $id > 0) {
            if ($is_active === 1) {
                $pdo->exec("UPDATE principal_messages SET is_active = 0 WHERE id != " . (int)$id);
            }

            $stmt = $pdo->prepare("UPDATE principal_messages SET principal_name = ?, designation = ?, image_url = ?, message_date = ?, salutation = ?, greeting = ?, message_body = ?, closing = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$principal_name, $designation, $image_url, $message_date, $salutation, $greeting, $message_body, $closing, $is_active, $id]);

            setFlashMessage('success', "Principal's message updated successfully!");
            header('Location: principal-message.php');
            exit;
        } else {
            setFlashMessage('danger', 'Principal name and message body are required.');
        }
    }
}

// Handle GET Actions (delete, toggle active, edit)
if (isset($_GET['delete'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP.');
        header('Location: principal-message.php');
        exit;
    }
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM principal_messages WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Message deleted successfully!');
        header('Location: principal-message.php');
        exit;
    }
}

if (isset($_GET['make_active'])) {
    if (!$pdo) {
        setFlashMessage('danger', 'Database offline. Please start MySQL in XAMPP.');
        header('Location: principal-message.php');
        exit;
    }
    $id = (int)$_GET['make_active'];
    if ($id > 0) {
        $pdo->exec("UPDATE principal_messages SET is_active = 0");
        $stmt = $pdo->prepare("UPDATE principal_messages SET is_active = 1 WHERE id = ?");
        $stmt->execute([$id]);
        setFlashMessage('success', 'Selected message set as the active current message!');
        header('Location: principal-message.php');
        exit;
    }
}

if (isset($_GET['edit']) && $pdo) {
    $id = (int)$_GET['edit'];
    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM principal_messages WHERE id = ?");
        $stmt->execute([$id]);
        $editItem = $stmt->fetch();
    }
}

// Fetch all messages
$messages = [];
if ($pdo) {
    $stmt = $pdo->query("SELECT * FROM principal_messages ORDER BY message_date DESC, id DESC");
    $messages = $stmt->fetchAll();
}

require_once __DIR__ . '/includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1px solid #eef2f6; flex-wrap: wrap; gap: 12px;">
    <p style="color: #64748b; font-size: 13.5px; margin: 0;">Add and manage the current message from the Principal and archive past institutional messages.</p>
    <div>
        <a href="../principal-message.php" target="_blank" class="btn btn-secondary btn-sm" style="display: inline-flex; align-items: center; gap: 6px; text-decoration: none; padding: 6px 14px; font-size: 12.5px;">
            <i class="fas fa-external-link-alt"></i> View Public Page
        </a>
    </div>
</div>

<!-- Add / Edit Message Form -->
<div class="admin-card" style="margin-bottom: 30px;">
    <div class="card-header" style="padding: 16px 20px; border-bottom: 1px solid #eef2f6;">
        <h3 style="font-size: 16px; font-weight: 700; color: #1a263d; margin: 0;">
            <i class="fas fa-<?= $editItem ? 'edit' : 'plus-circle' ?>" style="color: #009dff; margin-right: 8px;"></i>
            <?= $editItem ? 'Edit Principal Message' : 'Add New Principal Message' ?>
        </h3>
    </div>
    <div class="card-body" style="padding: 24px 20px;">
        <form method="POST" action="principal-message.php" enctype="multipart/form-data">
            <input type="hidden" name="action" value="<?= $editItem ? 'edit' : 'add' ?>">
            <?php if ($editItem): ?>
                <input type="hidden" name="id" value="<?= (int)$editItem['id'] ?>">
                <input type="hidden" name="existing_image" value="<?= htmlspecialchars($editItem['image_url'] ?? '') ?>">
            <?php endif; ?>

            <div class="form-row" style="margin-bottom: 18px;">
                <div class="form-group">
                    <label style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 8px; color: #334155;">
                        Principal Name <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="principal_name" class="form-control" required
                           value="<?= htmlspecialchars($editItem['principal_name'] ?? '') ?>"
                           placeholder="e.g. Prof. Dr. Jeetendra A. Vadher">
                </div>

                <div class="form-group">
                    <label style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 8px; color: #334155;">
                        Designation / Official Title
                    </label>
                    <input type="text" name="designation" class="form-control"
                           value="<?= htmlspecialchars($editItem['designation'] ?? 'Principal, Government Engineering College, Modasa') ?>"
                           placeholder="e.g. Principal, Government Engineering College, Modasa">
                </div>
            </div>

            <div class="form-row" style="margin-bottom: 18px;">
                <div class="form-group">
                    <label style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 8px; color: #334155;">
                        Message Date <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="date" name="message_date" class="form-control" required
                           value="<?= htmlspecialchars($editItem['message_date'] ?? date('Y-m-d')) ?>">
                    <small style="color: #64748b; font-size: 12px; margin-top: 4px; display: block;">This date will appear in the signature block and in the Previous Messages archive list.</small>
                </div>

                <div class="form-group">
                    <label style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 8px; color: #334155;">
                        Principal Photo
                    </label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    <?php if (!empty($editItem['image_url'])): ?>
                        <div style="margin-top: 8px; display: flex; align-items: center; gap: 10px;">
                            <img src="../<?= htmlspecialchars($editItem['image_url']) ?>" alt="Preview" style="height: 48px; width: 48px; object-fit: cover; border-radius: 4px; border: 1px solid #cbd5e1;">
                            <span style="font-size: 12px; color: #64748b;">Current photo saved</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-row" style="margin-bottom: 18px;">
                <div class="form-group">
                    <label style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 8px; color: #334155;">
                        Salutation Heading
                    </label>
                    <input type="text" name="salutation" class="form-control"
                           value="<?= htmlspecialchars($editItem['salutation'] ?? 'Dear Students, Faculty Members, and all Stakeholders,') ?>"
                           placeholder="e.g. Dear Students, Faculty Members, and all Stakeholders,">
                </div>

                <div class="form-group">
                    <label style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 8px; color: #334155;">
                        Opening Greeting
                    </label>
                    <input type="text" name="greeting" class="form-control"
                           value="<?= htmlspecialchars($editItem['greeting'] ?? 'Warm greetings to all.') ?>"
                           placeholder="e.g. Warm greetings to all.">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 18px;">
                <label style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 8px; color: #334155;">
                    Full Message Body <span style="color: #ef4444;">*</span>
                </label>
                <textarea name="message_body" rows="10" class="form-control" required
                          style="font-family: inherit; line-height: 1.6; resize: vertical;"
                          placeholder="Enter the complete message text. Separate paragraphs with double enter..."><?= htmlspecialchars($editItem['message_body'] ?? '') ?></textarea>
                <small style="color: #64748b; font-size: 12px; margin-top: 4px; display: block;">Paragraph breaks will automatically format into clean separated blocks on the public page.</small>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; font-size: 13.5px; margin-bottom: 8px; color: #334155;">
                    Closing &amp; Sign-off Text
                </label>
                <input type="text" name="closing" class="form-control"
                       value="<?= htmlspecialchars($editItem['closing'] ?? 'Sincerely, and with Best Regards,') ?>"
                       placeholder="e.g. Sincerely, and with Best Regards,">
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px; font-weight: 600; color: #1e293b;">
                    <input type="checkbox" name="is_active" value="1" <?= (!empty($editItem['is_active']) || (!$editItem && empty($messages))) ? 'checked' : '' ?>>
                    <span>Set as Active Current Principal Message (Shows by default on website)</span>
                </label>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?= $editItem ? 'Update Message' : 'Save Message' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="principal-message.php" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Messages List Table -->
<div class="admin-card">
    <div class="card-header" style="padding: 16px 20px; border-bottom: 1px solid #eef2f6; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-size: 16px; font-weight: 700; color: #1a263d; margin: 0;">
            <i class="fas fa-list-alt" style="color: #009dff; margin-right: 8px;"></i>
            All Principal Messages (<?= count($messages) ?>)
        </h3>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-responsive">
            <table class="data-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left;">
                        <th style="padding: 12px 18px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">Photo</th>
                        <th style="padding: 12px 18px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">Date</th>
                        <th style="padding: 12px 18px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">Principal</th>
                        <th style="padding: 12px 18px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase;">Status</th>
                        <th style="padding: 12px 18px; font-size: 12px; font-weight: 700; color: #475569; text-transform: uppercase; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $row): 
                            $dateFmt = !empty($row['message_date']) ? date('d/m/Y', strtotime($row['message_date'])) : '';
                        ?>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 12px 18px; vertical-align: middle;">
                                    <?php if (!empty($row['image_url'])): ?>
                                        <img src="../<?= htmlspecialchars($row['image_url']) ?>" alt="Photo" style="width: 44px; height: 44px; object-fit: cover; border-radius: 4px; border: 1px solid #e2e8f0;">
                                    <?php else: ?>
                                        <div style="width: 44px; height: 44px; background: #e2e8f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #64748b;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 12px 18px; vertical-align: middle; font-weight: 700; color: #0c3b6d; font-family: monospace; font-size: 13.5px;">
                                    <?= htmlspecialchars($dateFmt) ?>
                                </td>
                                <td style="padding: 12px 18px; vertical-align: middle;">
                                    <div style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($row['principal_name']) ?></div>
                                    <div style="font-size: 12px; color: #64748b;"><?= htmlspecialchars($row['designation']) ?></div>
                                </td>
                                <td style="padding: 12px 18px; vertical-align: middle;">
                                    <?php if (!empty($row['is_active'])): ?>
                                        <span style="display: inline-block; background: #dcfce7; color: #166534; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 20px;">
                                            <i class="fas fa-check-circle"></i> Current Active
                                        </span>
                                    <?php else: ?>
                                        <span style="display: inline-block; background: #f1f5f9; color: #64748b; font-size: 12px; font-weight: 600; padding: 3px 10px; border-radius: 20px;">
                                            Archive
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 12px 18px; vertical-align: middle; text-align: right;">
                                    <div style="display: inline-flex; gap: 6px;">
                                        <?php if (empty($row['is_active'])): ?>
                                            <a href="principal-message.php?make_active=<?= (int)$row['id'] ?>" class="btn btn-sm btn-outline-success" title="Set as Current Active Message" style="padding: 4px 8px; font-size: 12px;">
                                                <i class="fas fa-star"></i> Set Active
                                            </a>
                                        <?php endif; ?>
                                        <a href="../principal-message.php?id=<?= (int)$row['id'] ?>" target="_blank" class="btn btn-sm btn-secondary" title="Preview" style="padding: 4px 8px; font-size: 12px;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="principal-message.php?edit=<?= (int)$row['id'] ?>" class="btn btn-sm btn-outline-primary" title="Edit" style="padding: 4px 8px; font-size: 12px;">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <a href="principal-message.php?delete=<?= (int)$row['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete" style="padding: 4px 8px; font-size: 12px;" onclick="return confirm('Are you sure you want to delete this message?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 36px; color: #94a3b8;">
                                No principal messages found. Please add a message using the form above.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

