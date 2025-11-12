<?php
require_once '../../config/config.php';
require_once '../../config/database.php';

// Check if admin is logged in
requireLogin();

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Invalid member ID']);
    exit;
}

$database = new Database();
$db = $database->connect();

try {
    $query = "SELECT * FROM delegation_members WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    $member = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($member) {
        echo json_encode($member);
    } else {
        echo json_encode(['success' => false, 'message' => 'Member not found']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
