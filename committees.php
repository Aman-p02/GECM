<?php
$c = $_GET['c'] ?? $_GET['doc'] ?? 'anti-ragging';
header("Location: mandatory-disclosure.php?doc=" . urlencode($c));
exit;
