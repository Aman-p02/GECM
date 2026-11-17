<?php
$queryString = !empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : '';
header("HTTP/1.1 301 Moved Permanently");
header("Location: about/mandatory-disclosure" . $queryString);
exit;
