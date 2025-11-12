<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/email.php';
require_once '../models/DelegateRegistration.php';

class DelegateController {
    private $db;
    private $model;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->model = new DelegateRegistration($this->db);
    }

    public function showForm() {
        include VIEWS_PATH . 'delegate-registration-form.php';
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input
            $data = [
                'registration_type' => sanitize($_POST['registration_type']),
                'participant_type' => sanitize($_POST['participant_type']),
                'full_name' => sanitize($_POST['full_name']),
                'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
                'phone_number' => sanitize($_POST['phone_number']),
                'cnic_number' => sanitize($_POST['cnic_number'] ?? ''),
                'whatsapp_number' => sanitize($_POST['whatsapp_number']),
                'institution_name' => sanitize($_POST['institution_name']),
                'education_level' => sanitize($_POST['education_level']),
                'delegation_size' => $_POST['delegation_size'] ?? null,
                'head_delegate_name' => sanitize($_POST['head_delegate_name'] ?? ''),
                'committee_preference_1' => sanitize($_POST['committee_preference_1'] ?? ''),
                'committee_preference_2' => sanitize($_POST['committee_preference_2'] ?? ''),
                'committee_preference_3' => sanitize($_POST['committee_preference_3'] ?? ''),
                'mun_experience' => sanitize($_POST['mun_experience'] ?? ''),
                'dietary_requirements' => sanitize($_POST['dietary_requirements'] ?? ''),
                'special_needs' => sanitize($_POST['special_needs'] ?? ''),
                'reference' => sanitize($_POST['reference'] ?? ''),
                'promo_code' => sanitize($_POST['promo_code'] ?? ''),
                'partner_name' => sanitize($_POST['partner_name'] ?? ''),
                'partner_email' => filter_var($_POST['partner_email'] ?? '', FILTER_SANITIZE_EMAIL),
                'partner_phone' => sanitize($_POST['partner_phone'] ?? ''),
                'partner_cnic' => sanitize($_POST['partner_cnic'] ?? ''),
                'partner_experience' => sanitize($_POST['partner_experience'] ?? '')
            ];

            // Validate required fields
            if (empty($data['full_name']) || empty($data['email']) || empty($data['phone_number'])) {
                showAlert('Please fill in all required fields.', 'danger');
                redirect('register');
                return;
            }

            // Validate email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                showAlert('Please enter a valid email address.', 'danger');
                redirect('register');
                return;
            }

            // Create registration
            $registrationId = $this->model->create($data);
            
            if ($registrationId) {
                // Save delegation members if participant type is delegation
                if ($data['participant_type'] === 'delegation' && isset($_POST['member_name']) && is_array($_POST['member_name'])) {
                    $memberNames = $_POST['member_name'];
                    $memberEmails = $_POST['member_email'];
                    $memberPhones = $_POST['member_phone'];
                    $memberCnics = $_POST['member_cnic'];
                    $memberCommittees = $_POST['member_committee'];
                    $memberExperiences = $_POST['member_experience'] ?? [];
                    
                    for ($i = 0; $i < count($memberNames); $i++) {
                        if (!empty($memberNames[$i])) {
                            $memberData = [
                                'registration_id' => $registrationId,
                                'member_name' => sanitize($memberNames[$i]),
                                'member_email' => filter_var($memberEmails[$i], FILTER_SANITIZE_EMAIL),
                                'member_phone' => sanitize($memberPhones[$i]),
                                'member_cnic' => sanitize($memberCnics[$i]),
                                'member_committee_preference' => sanitize($memberCommittees[$i]),
                                'member_experience' => sanitize($memberExperiences[$i] ?? '')
                            ];
                            
                            $this->model->addDelegationMember($memberData);
                        }
                    }
                }
                
                // Send confirmation email
                $emailSent = sendDelegateConfirmation($data);
                
                if ($emailSent) {
                    showAlert('Registration successful! A confirmation email has been sent to ' . $data['email'] . '. Please check your inbox.', 'success');
                } else {
                    showAlert('Registration successful! However, we could not send a confirmation email. Our team will contact you soon.', 'warning');
                }
                
                redirect('');
            } else {
                showAlert('An error occurred. Please try again.', 'danger');
                redirect('register');
            }
        }
    }
}

// Handle routing
$controller = new DelegateController();

if (isset($_GET['action']) && $_GET['action'] === 'submit') {
    $controller->submit();
} else {
    $controller->showForm();
}
?>
