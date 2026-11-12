<?php
/**
 * FACULTY ADMIN AUTHENTICATION HELPER
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../includes/db.php';

function checkFacultyAuth() {
    if (!isset($_SESSION['faculty_user_id']) || empty($_SESSION['faculty_user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function getLoggedInFaculty() {
    if (!isset($_SESSION['faculty_user_id'])) {
        return null;
    }
    $pdo = getDBConnection();
    if (!$pdo) return null;

    try {
        $stmt = $pdo->prepare("SELECT * FROM faculties WHERE id = ? AND is_active = 1");
        $stmt->execute([(int)$_SESSION['faculty_user_id']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return null;
    }
}

function setFacultyFlash($type, $msg) {
    $_SESSION['fac_flash'] = [
        'type' => $type, // success, danger, warning, info
        'message' => $msg
    ];
}

function getFacultyFlash() {
    if (isset($_SESSION['fac_flash'])) {
        $flash = $_SESSION['fac_flash'];
        unset($_SESSION['fac_flash']);
        return $flash;
    }
    return null;
}
