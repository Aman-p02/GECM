<?php
// Department Router
$deptCode = strtoupper(trim($_GET['code'] ?? $_GET['dept'] ?? ''));

switch ($deptCode) {
    case 'CE':
    case 'COMPUTER':
        include __DIR__ . '/computer-engineering.php';
        exit;
    default:
        // Default to Computer Engineering if no or CE code specified
        include __DIR__ . '/computer-engineering.php';
        exit;
}
