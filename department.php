<?php
/**
 * Department Redirector
 * Directs incoming department requests to their dedicated pages in the departments folder.
 */
$deptCode = strtoupper(trim($_GET['code'] ?? $_GET['dept'] ?? ''));

switch ($deptCode) {
    case 'CE':
    case 'COMPUTER':
    default:
        // Direct redirect to dedicated Computer Engineering page
        header("Location: departments/computer-engineering.php", true, 301);
        exit;
}
