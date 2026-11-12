<?php
/**
 * AJAX: Fetch unregistered faculties by department
 */
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/db.php';

$dept = isset($_GET['dept']) ? trim($_GET['dept']) : '';

if (empty($dept)) {
    echo json_encode(['success' => false, 'data' => []]);
    exit;
}

$pdo = getDBConnection();
if (!$pdo) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, name, designation, email FROM faculties WHERE dept_code = ? AND (is_registered = 0 OR is_registered IS NULL) AND is_active = 1 ORDER BY name ASC");
    $stmt->execute([$dept]);
    $faculties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $faculties]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

