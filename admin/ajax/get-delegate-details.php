<?php
require_once '../../config/config.php';
require_once '../../config/database.php';

// Check if admin is logged in
requireLogin();

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Invalid ID']);
    exit;
}

$database = new Database();
$db = $database->connect();

try {
    // Get main delegate
    $query = "SELECT * FROM delegate_registrations WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $delegate = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$delegate) {
        echo json_encode(['success' => false, 'message' => 'Delegate not found']);
        exit;
    }
    
    // Get delegation members if it's a delegation
    $members = [];
    if ($delegate['participant_type'] === 'delegation') {
        $query = "SELECT * FROM delegation_members WHERE registration_id = :id ORDER BY id ASC";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    echo json_encode([
        'success' => true,
        'delegate' => $delegate,
        'members' => $members
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
