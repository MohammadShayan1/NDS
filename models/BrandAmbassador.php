<?php
/**
 * Brand Ambassador Model
 */

class BrandAmbassador {
    private $conn;
    private $table = 'brand_ambassadors';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (full_name, whatsapp_number, cnic_number, email, institution, 
                   education_level, prior_experience, delegates_count, pr_drive) 
                  VALUES 
                  (:full_name, :whatsapp_number, :cnic_number, :email, :institution, 
                   :education_level, :prior_experience, :delegates_count, :pr_drive)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':full_name', $data['full_name']);
        $stmt->bindParam(':whatsapp_number', $data['whatsapp_number']);
        $stmt->bindParam(':cnic_number', $data['cnic_number']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':institution', $data['institution']);
        $stmt->bindParam(':education_level', $data['education_level']);
        $stmt->bindParam(':prior_experience', $data['prior_experience']);
        $stmt->bindParam(':delegates_count', $data['delegates_count']);
        $stmt->bindParam(':pr_drive', $data['pr_drive']);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateStatus($id, $status, $notes = '') {
        $query = "UPDATE " . $this->table . " 
                  SET status = :status, admin_notes = :notes 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':notes', $notes);
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected
                  FROM " . $this->table;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }
}
?>
