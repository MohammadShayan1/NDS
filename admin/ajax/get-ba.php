<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../models/BrandAmbassador.php';

requireLogin();

if (isset($_GET['id'])) {
    $database = new Database();
    $db = $database->connect();
    $baModel = new BrandAmbassador($db);
    
    $ba = $baModel->getById($_GET['id']);
    
    if ($ba) {
        header('Content-Type: application/json');
        echo json_encode($ba);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Brand Ambassador not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID parameter required']);
}
?>
