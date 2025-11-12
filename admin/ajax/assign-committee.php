<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../config/email.php';
require_once '../../models/DelegateRegistration.php';

// Check if admin is logged in
requireLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delegateId = $_POST['delegate_id'] ?? null;
    $memberId = $_POST['member_id'] ?? null;
    $assignedCommittee = $_POST['assigned_committee'] ?? null;
    $type = $_POST['type'] ?? 'main'; // 'main' or 'member'
    
    if (!$assignedCommittee) {
        echo json_encode(['success' => false, 'message' => 'Committee is required']);
        exit;
    }
    
    $database = new Database();
    $db = $database->connect();
    
    try {
        if ($type === 'member' && $memberId) {
            // Update delegation member
            $query = "UPDATE delegation_members 
                     SET assigned_committee = :committee, status = 'confirmed' 
                     WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':committee', $assignedCommittee);
            $stmt->bindParam(':id', $memberId);
            $stmt->execute();
            
            // Get member details for email
            $query = "SELECT * FROM delegation_members WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $memberId);
            $stmt->execute();
            $member = $stmt->fetch();
            
            if ($member) {
                // Send acceptance email to member
                $memberData = [
                    'full_name' => $member['member_name'],
                    'email' => $member['member_email']
                ];
                sendDelegateAcceptance($memberData, $assignedCommittee);
            }
            
            echo json_encode([
                'success' => true, 
                'message' => 'Committee assigned and confirmation email sent to delegation member!'
            ]);
            
        } else if ($delegateId) {
            // Update main delegate
            $model = new DelegateRegistration($db);
            $query = "UPDATE delegate_registrations 
                     SET assigned_committee = :committee, status = 'confirmed' 
                     WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':committee', $assignedCommittee);
            $stmt->bindParam(':id', $delegateId);
            $stmt->execute();
            
            // Get delegate details
            $delegate = $model->getById($delegateId);
            
            if ($delegate) {
                // Send acceptance email
                sendDelegateAcceptance($delegate, $assignedCommittee);
            }
            
            echo json_encode([
                'success' => true, 
                'message' => 'Committee assigned and confirmation email sent!'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
