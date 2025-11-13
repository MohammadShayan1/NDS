<?php
/**
 * Delegate Registration Model
 */

class DelegateRegistration {
    private $conn;
    private $table = 'delegate_registrations';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (registration_type, participant_type, full_name, email, phone_number, 
                   cnic_number, whatsapp_number, institution_name, education_level, 
                   delegation_size, head_delegate_name, committee_preference_1, 
                   committee_preference_2, committee_preference_3, mun_experience, 
                   dietary_requirements, special_needs, reference, promo_code,
                   partner_name, partner_email, partner_phone, partner_cnic, partner_experience) 
                  VALUES 
                  (:registration_type, :participant_type, :full_name, :email, :phone_number, 
                   :cnic_number, :whatsapp_number, :institution_name, :education_level, 
                   :delegation_size, :head_delegate_name, :committee_preference_1, 
                   :committee_preference_2, :committee_preference_3, :mun_experience, 
                   :dietary_requirements, :special_needs, :reference, :promo_code,
                   :partner_name, :partner_email, :partner_phone, :partner_cnic, :partner_experience)";

        $stmt = $this->conn->prepare($query);

        // Sanitize and set defaults for nullable fields
        $registration_type = $data['registration_type'] ?? '';
        $participant_type = $data['participant_type'] ?? '';
        $full_name = $data['full_name'] ?? '';
        $email = $data['email'] ?? '';
        $phone_number = $data['phone_number'] ?? null;
        $cnic_number = $data['cnic_number'] ?? null;
        $whatsapp_number = $data['whatsapp_number'] ?? null;
        $institution_name = $data['institution_name'] ?? null;
        // Provide a default value for education_level (adjust based on your database ENUM values)
        $education_level = !empty($data['education_level']) ? $data['education_level'] : 'undergraduate';
        $delegation_size = $data['delegation_size'] ?? null;
        $head_delegate_name = $data['head_delegate_name'] ?? null;
        $committee_preference_1 = $data['committee_preference_1'] ?? null;
        $committee_preference_2 = $data['committee_preference_2'] ?? null;
        $committee_preference_3 = $data['committee_preference_3'] ?? null;
        $mun_experience = $data['mun_experience'] ?? null;
        $dietary_requirements = $data['dietary_requirements'] ?? null;
        $special_needs = $data['special_needs'] ?? null;
        $reference = $data['reference'] ?? null;
        $promo_code = $data['promo_code'] ?? null;
        $partner_name = $data['partner_name'] ?? null;
        $partner_email = $data['partner_email'] ?? null;
        $partner_phone = $data['partner_phone'] ?? null;
        $partner_cnic = $data['partner_cnic'] ?? null;
        $partner_experience = $data['partner_experience'] ?? null;

        // Bind parameters
        $stmt->bindParam(':registration_type', $registration_type);
        $stmt->bindParam(':participant_type', $participant_type);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':cnic_number', $cnic_number);
        $stmt->bindParam(':whatsapp_number', $whatsapp_number);
        $stmt->bindParam(':institution_name', $institution_name);
        $stmt->bindParam(':education_level', $education_level);
        $stmt->bindParam(':delegation_size', $delegation_size);
        $stmt->bindParam(':head_delegate_name', $head_delegate_name);
        $stmt->bindParam(':committee_preference_1', $committee_preference_1);
        $stmt->bindParam(':committee_preference_2', $committee_preference_2);
        $stmt->bindParam(':committee_preference_3', $committee_preference_3);
        $stmt->bindParam(':mun_experience', $mun_experience);
        $stmt->bindParam(':dietary_requirements', $dietary_requirements);
        $stmt->bindParam(':special_needs', $special_needs);
        $stmt->bindParam(':reference', $reference);
        $stmt->bindParam(':promo_code', $promo_code);
        $stmt->bindParam(':partner_name', $partner_name);
        $stmt->bindParam(':partner_email', $partner_email);
        $stmt->bindParam(':partner_phone', $partner_phone);
        $stmt->bindParam(':partner_cnic', $partner_cnic);
        $stmt->bindParam(':partner_experience', $partner_experience);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function addDelegationMember($data) {
        $query = "INSERT INTO delegation_members 
                  (registration_id, member_name, member_email, member_phone, 
                   member_cnic, member_committee_preference, member_experience) 
                  VALUES 
                  (:registration_id, :member_name, :member_email, :member_phone, 
                   :member_cnic, :member_committee_preference, :member_experience)";

        $stmt = $this->conn->prepare($query);

        // Sanitize and set defaults for nullable fields
        $registration_id = $data['registration_id'] ?? null;
        $member_name = $data['member_name'] ?? null;
        $member_email = $data['member_email'] ?? null;
        $member_phone = $data['member_phone'] ?? null;
        $member_cnic = $data['member_cnic'] ?? null;
        $member_committee_preference = $data['member_committee_preference'] ?? null;
        $member_experience = $data['member_experience'] ?? null;

        $stmt->bindParam(':registration_id', $registration_id);
        $stmt->bindParam(':member_name', $member_name);
        $stmt->bindParam(':member_email', $member_email);
        $stmt->bindParam(':member_phone', $member_phone);
        $stmt->bindParam(':member_cnic', $member_cnic);
        $stmt->bindParam(':member_committee_preference', $member_committee_preference);
        $stmt->bindParam(':member_experience', $member_experience);

        return $stmt->execute();
    }

    public function getDelegationMembers($registrationId) {
        $query = "SELECT * FROM delegation_members WHERE registration_id = :registration_id ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':registration_id', $registrationId);
        $stmt->execute();
        return $stmt->fetchAll();
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

    public function updateStatus($id, $status, $payment_status, $notes = '') {
        $query = "UPDATE " . $this->table . " 
                  SET status = :status, payment_status = :payment_status, admin_notes = :notes 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':payment_status', $payment_status);
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
                    SUM(CASE WHEN registration_type = 'NED' THEN 1 ELSE 0 END) as ned_registrations,
                    SUM(CASE WHEN registration_type = 'Other' THEN 1 ELSE 0 END) as other_registrations,
                    SUM(CASE WHEN participant_type = 'delegate' THEN 1 ELSE 0 END) as delegates,
                    SUM(CASE WHEN participant_type = 'delegation' THEN 1 ELSE 0 END) as delegations,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
                    SUM(CASE WHEN payment_status = 'paid' THEN 1 ELSE 0 END) as paid
                  FROM " . $this->table;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }
}
?>
