<?php
// Departments Directory Index / Router
$dept = isset($_GET['code']) ? strtolower(trim($_GET['code'])) : (isset($_GET['dept']) ? strtolower(trim($_GET['dept'])) : '');

switch ($dept) {
    case 'ce':
    case 'computer':
    case 'computer-engineering':
        header("Location: computer/", true, 302);
        exit;
    case 'it':
    case 'information-technology':
    case 'it-engineering':
        header("Location: information-technology/", true, 302);
        exit;
    default:
        // Default to computer department
        header("Location: computer/", true, 302);
        exit;
}
