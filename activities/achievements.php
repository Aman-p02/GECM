<?php
/**
 * GEC MODASA - ACHIEVEMENTS ROUTER HUB
 * Redirects or routes to the corresponding achievements section
 */
$type = strtolower(trim($_GET['type'] ?? 'student'));

if ($type === 'faculty' || $type === 'faculty_achievements') {
    header("Location: faculty-achievements.php" . (!empty($_GET['year']) ? '?year=' . urlencode($_GET['year']) : ''));
    exit;
} elseif ($type === 'institute' || $type === 'institute_achievements') {
    header("Location: institute-achievements.php" . (!empty($_GET['year']) ? '?year=' . urlencode($_GET['year']) : ''));
    exit;
} else {
    header("Location: student-achievements.php" . (!empty($_GET['year']) ? '?year=' . urlencode($_GET['year']) : ''));
    exit;
}
