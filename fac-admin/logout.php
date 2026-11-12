<?php
/**
 * Faculty Logout
 */
session_start();
unset($_SESSION['faculty_user_id']);
unset($_SESSION['faculty_name']);
unset($_SESSION['faculty_dept']);

header('Location: login.php');
exit;
