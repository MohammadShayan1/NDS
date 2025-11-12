<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../models/DelegateRegistration.php';

requireLogin();

$database = new Database();
$db = $database->connect();
$delegateModel = new DelegateRegistration($db);

$delegates = $delegateModel->getAll();

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="nedmun_delegates_' . date('Y-m-d') . '.csv"');

$output = fopen('php://output', 'w');

// CSV Headers
fputcsv($output, [
    'ID', 'Name', 'Email', 'Phone', 'WhatsApp', 'CNIC', 
    'Institution', 'Education Level', 'Registration Type', 
    'Participant Type', 'Delegation Size', 'Committee Pref 1', 
    'Committee Pref 2', 'Committee Pref 3', 'MUN Experience', 
    'Status', 'Payment Status', 'Registration Date'
]);

// CSV Data
foreach ($delegates as $delegate) {
    fputcsv($output, [
        $delegate['id'],
        $delegate['full_name'],
        $delegate['email'],
        $delegate['phone_number'],
        $delegate['whatsapp_number'],
        $delegate['cnic_number'],
        $delegate['institution_name'],
        $delegate['education_level'],
        $delegate['registration_type'],
        $delegate['participant_type'],
        $delegate['delegation_size'],
        $delegate['committee_preference_1'],
        $delegate['committee_preference_2'],
        $delegate['committee_preference_3'],
        $delegate['mun_experience'],
        $delegate['status'],
        $delegate['payment_status'],
        $delegate['created_at']
    ]);
}

fclose($output);
exit();
?>
