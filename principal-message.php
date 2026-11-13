<?php
$page_title = "Principal's Message | Government Engineering College, Modasa";
$active_page = "principal-message";
$root_path = "";
$extra_css = "css/principal-message.css";

require_once __DIR__ . '/includes/db.php';

$requestedId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$currentMsg = null;
$allMessages = [];

if ($pdo) {
    try {
        if ($requestedId > 0) {
            $stmt = $pdo->prepare("SELECT * FROM principal_messages WHERE id = ?");
            $stmt->execute([$requestedId]);
            $currentMsg = $stmt->fetch();
        }

        // If not found or not specified, fetch active current message or latest
        if (!$currentMsg) {
            $stmt = $pdo->query("SELECT * FROM principal_messages WHERE is_active = 1 LIMIT 1");
            $currentMsg = $stmt->fetch();
            if (!$currentMsg) {
                $stmt = $pdo->query("SELECT * FROM principal_messages ORDER BY message_date DESC LIMIT 1");
                $currentMsg = $stmt->fetch();
            }
        }

        // Fetch all messages for the Previous Messages archive
        $stmtList = $pdo->query("SELECT id, message_date, principal_name, is_active FROM principal_messages ORDER BY message_date DESC");
        $allMessages = $stmtList->fetchAll();
    } catch (Exception $e) {
        error_log("Principal Message Query Error: " . $e->getMessage());
    }
}

// Parse paragraphs if message exists
$paragraphs = [];
if (!empty($currentMsg['message_body'])) {
    $rawBody = $currentMsg['message_body'];
    $paragraphs = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $rawBody))));
}

require_once __DIR__ . '/includes/header.php';
?>

<div class="pm-page" id="mainContent">

    <!-- Page Hero Banner -->
    <header class="pm-hero">
        <div class="container">
            <span class="pm-kicker">THE INSTITUTE</span>
            <h1 class="pm-heading">Principal's Message</h1>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="pm-content">
        <div class="container">

            <?php if ($currentMsg): ?>

                <!-- Principal Photo (Top Left) -->
                <?php if (!empty($currentMsg['image_url'])): ?>
                    <div class="pm-photo-wrap">
                        <img src="<?= $root_path . htmlspecialchars($currentMsg['image_url']) ?>"
                             alt="<?= htmlspecialchars($currentMsg['principal_name']) ?>"
                             class="pm-photo">
                    </div>
                <?php endif; ?>

                <!-- Salutation & Greeting -->
                <?php if (!empty($currentMsg['salutation'])): ?>
                    <h2 class="pm-salutation"><?= htmlspecialchars($currentMsg['salutation']) ?></h2>
                <?php endif; ?>

                <?php if (!empty($currentMsg['greeting'])): ?>
                    <p class="pm-greeting"><?= htmlspecialchars($currentMsg['greeting']) ?></p>
                <?php endif; ?>

                <!-- Message Body Paragraphs -->
                <div class="pm-body">
                    <?php foreach ($paragraphs as $para): ?>
                        <?php if (!empty($para)): ?>
                            <p class="pm-paragraph"><?= htmlspecialchars($para) ?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <!-- Sign-off & Date Block -->
                <div class="pm-signoff">
                    <?php if (!empty($currentMsg['closing'])): ?>
                        <div class="pm-closing-text"><?= nl2br(htmlspecialchars($currentMsg['closing'])) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($currentMsg['message_date'])): ?>
                        <div class="pm-date">
                            Date: <strong><?= date('d F Y', strtotime($currentMsg['message_date'])) ?></strong>
                        </div>
                    <?php endif; ?>

                    <div class="pm-signature">
                        <div class="pm-signer-name"><?= htmlspecialchars($currentMsg['principal_name']) ?></div>
                        <div class="pm-signer-title"><?= htmlspecialchars($currentMsg['designation']) ?></div>
                    </div>
                </div>

                <!-- Previous Messages Section (Matching Image 3) -->
                <?php if (!empty($allMessages) && count($allMessages) > 1): ?>
                    <div class="pm-archive-section">
                        <h3 class="pm-archive-title">Previous Messages</h3>
                        <ul class="pm-archive-list">
                            <?php foreach ($allMessages as $msg): 
                                $dateFormatted = date('d/m/Y', strtotime($msg['message_date']));
                                $isCurrent = ($currentMsg && $currentMsg['id'] == $msg['id']);
                            ?>
                                <li>
                                    <a href="principal-message.php?id=<?= (int)$msg['id'] ?>" class="pm-archive-link <?= $isCurrent ? 'is-active' : '' ?>">
                                        <?= htmlspecialchars($dateFormatted) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="pm-empty-state">
                    <p>Principal's message will be updated soon.</p>
                </div>
            <?php endif; ?>

        </div>
    </main>

</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>
