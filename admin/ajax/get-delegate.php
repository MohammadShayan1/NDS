<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../models/DelegateRegistration.php';

requireLogin();

if (isset($_GET['id'])) {
    $database = new Database();
    $db = $database->connect();
    $delegateModel = new DelegateRegistration($db);
    
    $delegate = $delegateModel->getById($_GET['id']);
    
    if ($delegate) {
        header('Content-Type: application/json');
        echo json_encode($delegate);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Delegate not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID parameter required']);
}
?>
