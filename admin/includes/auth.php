<?php
/**
 * GEC MODASA — ADMIN AUTH & SESSION HELPER
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start();

require_once __DIR__ . '/../../includes/db.php';

function checkAdminAuth() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login.php?msg=Please+login+to+continue');
        exit;
    }
}

function getLoggedInAdmin() {
    return [
        'id'       => $_SESSION['admin_id'] ?? 1,
        'username' => $_SESSION['admin_username'] ?? 'admin',
        'role'     => $_SESSION['admin_role'] ?? 'super_admin'
    ];
}

function setFlashMessage($type, $message) {
    $_SESSION['flash'] = [
        'type'    => $type, // success, danger, info
        'message' => $message
    ];
}

function renderFlashMessage() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        $type = htmlspecialchars($flash['type']);
        $message = htmlspecialchars($flash['message']);
        echo '<div class="admin-alert admin-alert-' . $type . '">
            <span>' . $message . '</span>
            <button class="admin-alert-close" onclick="this.parentElement.remove();">&times;</button>
        </div>';
    }
}
