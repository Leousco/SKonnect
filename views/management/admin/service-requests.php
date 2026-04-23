<?php
// Redirect service-requests.php → admin_service_requests.php
// preserving any query string (e.g. ?id=18)
$query = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
header('Location: admin_service_requests.php' . $query, true, 301);
exit;