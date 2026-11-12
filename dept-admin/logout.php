<?php
/**
 * Department Admin Logout
 */
session_start();
unset($_SESSION['dept_admin_id']);
unset($_SESSION['dept_admin_username']);
unset($_SESSION['dept_admin_name']);
unset($_SESSION['dept_admin_dept']);

header('Location: login.php');
exit;
