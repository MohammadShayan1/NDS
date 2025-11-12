<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../config/email.php';
require_once '../models/BrandAmbassador.php';

class BrandAmbassadorController {
    private $db;
    private $model;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->model = new BrandAmbassador($this->db);
    }

    public function showForm() {
        include VIEWS_PATH . 'brand-ambassador-form.php';
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input
            $data = [
                'full_name' => sanitize($_POST['full_name']),
                'whatsapp_number' => sanitize($_POST['whatsapp_number']),
                'cnic_number' => sanitize($_POST['cnic_number']),
                'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
                'institution' => sanitize($_POST['institution']),
                'education_level' => sanitize($_POST['education_level']),
                'prior_experience' => sanitize($_POST['prior_experience']),
                'delegates_count' => sanitize($_POST['delegates_count']),
                'pr_drive' => sanitize($_POST['pr_drive'])
            ];

            // Validate required fields
            if (empty($data['full_name']) || empty($data['email']) || empty($data['whatsapp_number'])) {
                showAlert('Please fill in all required fields.', 'danger');
                redirect('brand-ambassador');
                return;
            }

            // Validate email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                showAlert('Please enter a valid email address.', 'danger');
                redirect('brand-ambassador');
                return;
            }

            // Create application
            if ($this->model->create($data)) {
                // Send confirmation email
                $emailSent = sendBrandAmbassadorConfirmation($data);
                
                if ($emailSent) {
                    showAlert('Thank you for applying! A confirmation email has been sent to ' . $data['email'] . '. Please check your inbox.', 'success');
                } else {
                    showAlert('Thank you for applying! However, we could not send a confirmation email. Our team will contact you soon.', 'warning');
                }
                
                redirect('');
            } else {
                showAlert('An error occurred. Please try again.', 'danger');
                redirect('brand-ambassador');
            }
        }
    }
}

// Handle routing
$controller = new BrandAmbassadorController();

if (isset($_GET['action']) && $_GET['action'] === 'submit') {
    $controller->submit();
} else {
    $controller->showForm();
}
?>
