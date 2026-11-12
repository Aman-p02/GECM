<?php
/**
 * DEPARTMENT ADMIN AUTHENTICATION HELPER
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start();

require_once __DIR__ . '/../../includes/db.php';

function checkDeptAdminAuth() {
    if (!isset($_SESSION['dept_admin_id']) || empty($_SESSION['dept_admin_id'])) {
        header('Location: login.php');
        exit;
    }
}

function getLoggedInDeptAdmin() {
    if (!isset($_SESSION['dept_admin_id'])) {
        return null;
    }
    $pdo = getDBConnection();
    if (!$pdo) return null;

    try {
        $stmt = $pdo->prepare("SELECT * FROM dept_admins WHERE id = ? AND is_active = 1 AND status = 'approved'");
        $stmt->execute([(int)$_SESSION['dept_admin_id']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return null;
    }
}

function setDeptFlash($type, $msg) {
    $_SESSION['dept_flash'] = [
        'type' => $type, // success, danger, warning, info
        'message' => $msg
    ];
}

function getDeptFlash() {
    if (isset($_SESSION['dept_flash'])) {
        $flash = $_SESSION['dept_flash'];
        unset($_SESSION['dept_flash']);
        return $flash;
    }
    return null;
}

