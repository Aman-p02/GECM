<?php
/**
 * Department Redirector
 * Directs incoming department requests to their dedicated standalone pages.
 */
$deptCode = strtoupper(trim($_GET['code'] ?? $_GET['dept'] ?? ''));

switch ($deptCode) {
    case 'CE':
    case 'COMPUTER':
    default:
        // Direct redirect to dedicated Computer Engineering page
        header("Location: computer-engineering.php", true, 301);
        exit;
}
