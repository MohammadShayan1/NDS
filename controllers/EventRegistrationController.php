<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../models/EventRegistration.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('event-registration');
    exit;
}

$database = new Database();
$db = $database->connect();
$eventModel = new EventRegistration($db);

// Sanitize input
$full_name = sanitize($_POST['full_name']);
$cnic_number = sanitize($_POST['cnic_number']);
$email = sanitize($_POST['email']);
$phone_number = sanitize($_POST['phone_number']);

// Validate required fields
if (empty($full_name) || empty($cnic_number) || empty($email) || empty($phone_number)) {
    showAlert('All fields are required.', 'danger');
    redirect('event-registration');
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    showAlert('Invalid email address.', 'danger');
    redirect('event-registration');
    exit;
}

// Handle payment screenshot upload
$payment_screenshot = '';
if (isset($_FILES['payment_screenshot']) && $_FILES['payment_screenshot']['error'] === UPLOAD_ERR_OK) {
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
    $file_type = $_FILES['payment_screenshot']['type'];
    
    if (!in_array($file_type, $allowed_types)) {
        showAlert('Invalid file type. Only JPG, PNG, and PDF files are allowed.', 'danger');
        redirect('event-registration');
        exit;
    }
    
    // Check file size (5MB max)
    if ($_FILES['payment_screenshot']['size'] > 5 * 1024 * 1024) {
        showAlert('File size too large. Maximum size is 5MB.', 'danger');
        redirect('event-registration');
        exit;
    }
    
    $upload_dir = '../uploads/event_payments/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_extension = pathinfo($_FILES['payment_screenshot']['name'], PATHINFO_EXTENSION);
    $file_name = 'event_payment_' . uniqid() . '.' . $file_extension;
    $target_path = $upload_dir . $file_name;
    
    if (move_uploaded_file($_FILES['payment_screenshot']['tmp_name'], $target_path)) {
        $payment_screenshot = 'uploads/event_payments/' . $file_name;
    } else {
        showAlert('Failed to upload payment screenshot.', 'danger');
        redirect('event-registration');
        exit;
    }
} else {
    showAlert('Payment screenshot is required.', 'danger');
    redirect('event-registration');
    exit;
}

// Prepare data
$data = [
    'full_name' => $full_name,
    'cnic_number' => $cnic_number,
    'email' => $email,
    'phone_number' => $phone_number,
    'payment_screenshot' => $payment_screenshot
];

// Create registration
$registration_id = $eventModel->create($data);

if ($registration_id) {
    showAlert('Registration submitted successfully! We will review your application and contact you soon.', 'success');
    redirect('');
} else {
    showAlert('An error occurred during registration. Please try again.', 'danger');
    redirect('event-registration');
}
?>
