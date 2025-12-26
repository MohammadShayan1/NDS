<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../models/EventRegistration.php';

requireLogin();

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID required']);
    exit;
}

$database = new Database();
$db = $database->connect();
$eventModel = new EventRegistration($db);

$registration = $eventModel->getById($_GET['id']);

if ($registration) {
    echo json_encode($registration);
} else {
    echo json_encode(['success' => false, 'message' => 'Registration not found']);
}
?>
