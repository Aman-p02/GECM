<?php
/**
 * Statutory Disclosure & Committee Document Direct Opener
 * Automatically opens the active official PDF in a new browser tab.
 */

require_once __DIR__ . '/includes/db.php';

$slugMap = [
    // Campus Committees
    'anti-ragging'            => 'Anti-Ragging Committee',
    'sexual-harassment'       => 'Sexual Harassment Committee',
    'women-development-cell'  => 'Women development Cell',

    // Mandatory Disclosures
    'rti-proactive'           => 'RTI Pro-Active Disclosure',
    'aicte'                   => 'AICTE Mandatory Disclosure',
    'financial-statements'    => 'Financial Statements',
    'accreditation'           => 'Accreditation',
    'institute-establishment' => 'Institute Establishment Resolution',
    'rti-booklet'             => 'RTI Booklet (2005)'
];

$docKey = trim($_GET['doc'] ?? $_GET['type'] ?? '');
$category = $slugMap[$docKey] ?? null;

if (!$category) {
    // Check if category name was passed directly
    if (!empty($docKey) && in_array($docKey, $slugMap)) {
        $category = $docKey;
    } else {
        $category = 'Mandatory Disclosure';
    }
}

$activeFile = null;

if ($pdo && $category) {
    try {
        $stmt = $pdo->prepare("SELECT file_path FROM mandatory_disclosures WHERE category = ? AND is_active = 1 ORDER BY id DESC LIMIT 1");
        $stmt->execute([$category]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && !empty($row['file_path'])) {
            $realPath = realpath(__DIR__ . '/' . ltrim($row['file_path'], '/'));
            if ($realPath && file_exists($realPath)) {
                $activeFile = $row['file_path'];
            }
        }
    } catch (PDOException $e) {
        error_log("Disclosure redirect error: " . $e->getMessage());
    }
}

// If active PDF exists, redirect immediately to open the file directly in browser tab
if ($activeFile) {
    header('Location: ' . $activeFile, true, 302);
    exit;
}

// Fallback message if PDF has not been uploaded yet
$page_title = htmlspecialchars($category) . " | Government Engineering College, Modasa";
$active_page = 'about';
require_once __DIR__ . '/includes/header.php';
?>

<div style="background: #f8fafc; padding: 60px 0 80px; min-height: 75vh; display: flex; align-items: center;">
    <div class="container" style="max-width: 780px; margin: 0 auto; padding: 0 20px;">
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 48px 36px; text-align: center;">
            <div style="width: 64px; height: 64px; background: #fff7ed; color: #ff8800; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 28px; margin-bottom: 20px;">
                <i class="fas fa-file-pdf"></i>
            </div>
            <span style="display: block; font-size: 0.78rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: #ff8800; margin-bottom: 8px;">
                STATUTORY NOTIFICATION
            </span>
            <h1 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.65rem; font-weight: 800; color: #0f172a; margin: 0 0 12px 0;">
                <?= htmlspecialchars($category) ?>
            </h1>
            <p style="font-size: 1rem; color: #64748b; line-height: 1.6; margin: 0 auto 28px; max-width: 580px;">
                The official notification / document for <strong><?= htmlspecialchars($category) ?></strong> is being compiled by the college administration and will be uploaded here shortly.
            </p>
            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <a href="index.php" style="background: #009dff; color: #ffffff; padding: 10px 22px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-home"></i> Back to Home
                </a>
                <a href="javascript:history.back();" style="background: #ffffff; border: 1px solid #cbd5e1; color: #334155; padding: 10px 20px; border-radius: 6px; font-weight: 600; text-decoration: none; font-size: 0.9rem;">
                    Go Back
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
