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
            // Validate CSRF token
            if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
                showAlert('Invalid security token. Please try again.', 'danger');
                redirect('register');
                return;
            }
            
            // Handle payment screenshot upload
            $paymentScreenshot = '';
            if (isset($_FILES['payment_screenshot']) && $_FILES['payment_screenshot']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../uploads/payment_screenshots/';
                
                // Create directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                // Validate file type by MIME type
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $_FILES['payment_screenshot']['tmp_name']);
                finfo_close($finfo);
                
                $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!in_array($mimeType, $allowedMimeTypes)) {
                    showAlert('Invalid file format. Please upload JPG, JPEG, or PNG file.', 'danger');
                    redirect('register');
                    return;
                }
                
                $fileExtension = strtolower(pathinfo($_FILES['payment_screenshot']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                
                if (!in_array($fileExtension, $allowedExtensions)) {
                    showAlert('Invalid file format. Please upload JPG, JPEG, or PNG file.', 'danger');
                    redirect('register');
                    return;
                }
                
                // Check file size (5MB max)
                if ($_FILES['payment_screenshot']['size'] > 5 * 1024 * 1024) {
                    showAlert('File size too large. Maximum size is 5MB.', 'danger');
                    redirect('register');
                    return;
                }
                
                // Generate unique filename with secure random
                $fileName = 'payment_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $fileExtension;
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['payment_screenshot']['tmp_name'], $uploadPath)) {
                    // Set proper permissions
                    chmod($uploadPath, 0644);
                    $paymentScreenshot = 'uploads/payment_screenshots/' . $fileName;
                } else {
                    showAlert('Failed to upload payment screenshot. Please try again.', 'danger');
                    redirect('register');
                    return;
                }
            }
            
            // Validate and sanitize input
            $data = [
                'registration_type' => sanitize($_POST['registration_type'] ?? ''),
                'participant_type' => sanitize($_POST['participant_type'] ?? ''),
                'full_name' => sanitize($_POST['full_name'] ?? ''),
                'email' => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
                'phone_number' => sanitize($_POST['phone_number'] ?? ''),
                'cnic_number' => sanitize($_POST['cnic_number'] ?? ''),
                'whatsapp_number' => sanitize($_POST['whatsapp_number'] ?? ''),
                'institution_name' => sanitize($_POST['institution_name'] ?? ''),
                'education_level' => !empty($_POST['education_level']) ? sanitize($_POST['education_level']) : null,
                'delegation_size' => !empty($_POST['delegation_size']) ? intval($_POST['delegation_size']) : null,
                'head_delegate_name' => sanitize($_POST['head_delegate_name'] ?? ''),
                'committee_preference_1' => sanitize($_POST['committee_preference_1'] ?? ''),
                'committee_preference_2' => sanitize($_POST['committee_preference_2'] ?? ''),
                'committee_preference_3' => sanitize($_POST['committee_preference_3'] ?? ''),
                'mun_experience' => sanitize($_POST['mun_experience'] ?? ''),
                'reference' => sanitize($_POST['reference'] ?? ''),
                'promo_code' => sanitize($_POST['promo_code'] ?? ''),
                'payment_screenshot' => $paymentScreenshot,
                'partner_name' => sanitize($_POST['partner_name'] ?? ''),
                'partner_email' => !empty($_POST['partner_email']) ? filter_var($_POST['partner_email'], FILTER_SANITIZE_EMAIL) : '',
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
            
            // Validate phone number format (Pakistan)
            if (!preg_match('/^[\d\s\-\+\(\)]+$/', $data['phone_number'])) {
                showAlert('Please enter a valid phone number.', 'danger');
                redirect('register');
                return;
            }
            
            // Validate CNIC format if provided (13 digits with optional dashes)
            if (!empty($data['cnic_number']) && !preg_match('/^\d{5}-?\d{7}-?\d{1}$/', str_replace(' ', '', $data['cnic_number']))) {
                showAlert('Please enter a valid CNIC number (format: 12345-1234567-1).', 'danger');
                redirect('register');
                return;
            }
            
            // Validate registration type
            $validRegistrationTypes = ['NED', 'Other'];
            if (!in_array($data['registration_type'], $validRegistrationTypes)) {
                showAlert('Invalid registration type.', 'danger');
                redirect('register');
                return;
            }
            
            // Validate participant type
            $validParticipantTypes = ['delegate', 'delegation'];
            if (!in_array($data['participant_type'], $validParticipantTypes)) {
                showAlert('Invalid participant type.', 'danger');
                redirect('register');
                return;
            }
            
            // Validate committee preferences
            $validCommittees = ['UNSC', 'UNCSTD', 'UNWOMEN', 'DISEC', 'SPECPOL', 'SOCHUM', 'KCC', 'PNA'];
            if (!empty($data['committee_preference_1']) && !in_array($data['committee_preference_1'], $validCommittees)) {
                showAlert('Invalid committee preference.', 'danger');
                redirect('register');
                return;
            }

            // Create registration
            $registrationId = $this->model->create($data);
            
            if ($registrationId) {
                // Save delegation members if participant type is delegation
                if ($data['participant_type'] === 'delegation' && isset($_POST['member_name']) && is_array($_POST['member_name'])) {
                    $memberNames = $_POST['member_name'] ?? [];
                    $memberEmails = $_POST['member_email'] ?? [];
                    $memberPhones = $_POST['member_phone'] ?? [];
                    $memberCnics = $_POST['member_cnic'] ?? [];
                    $memberCommittees = $_POST['member_committee'] ?? [];
                    $memberExperiences = $_POST['member_experience'] ?? [];
                    
                    // Validate delegation has at least 1 additional member (form filler is member 1)
                    if (count($memberNames) < 1) {
                        showAlert('Delegation must have at least 2 members (including you).', 'danger');
                        redirect('register');
                        return;
                    }
                    
                    // Validate max 8 additional members
                    if (count($memberNames) > 8) {
                        showAlert('Delegation cannot exceed 9 members total.', 'danger');
                        redirect('register');
                        return;
                    }
                    
                    for ($i = 0; $i < count($memberNames); $i++) {
                        if (!empty($memberNames[$i])) {
                            // Validate member email if provided
                            $sanitizedEmail = '';
                            if (isset($memberEmails[$i]) && !empty($memberEmails[$i])) {
                                if (!filter_var($memberEmails[$i], FILTER_VALIDATE_EMAIL)) {
                                    showAlert('Invalid email address for delegation member: ' . sanitize($memberNames[$i]), 'danger');
                                    redirect('register');
                                    return;
                                }
                                $sanitizedEmail = filter_var($memberEmails[$i], FILTER_SANITIZE_EMAIL);
                            }
                            
                            // Validate member committee
                            if (!empty($memberCommittees[$i]) && !in_array($memberCommittees[$i], $validCommittees)) {
                                showAlert('Invalid committee selection for delegation member.', 'danger');
                                redirect('register');
                                return;
                            }
                            
                            $memberData = [
                                'registration_id' => $registrationId,
                                'member_name' => sanitize($memberNames[$i] ?? ''),
                                'member_email' => $sanitizedEmail,
                                'member_phone' => sanitize($memberPhones[$i] ?? ''),
                                'member_cnic' => sanitize($memberCnics[$i] ?? ''),
                                'member_committee_preference' => sanitize($memberCommittees[$i] ?? ''),
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
