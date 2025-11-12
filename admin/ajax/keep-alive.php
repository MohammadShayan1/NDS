<?php
require_once '../../config/config.php';

// Check if admin is logged in
requireLogin();

header('Content-Type: application/json');

// Update last activity time
$_SESSION['LAST_ACTIVITY'] = time();

echo json_encode([
    'success' => true,
    'timeRemaining' => 3600 - (time() - $_SESSION['LAST_ACTIVITY'])
]);
?>
