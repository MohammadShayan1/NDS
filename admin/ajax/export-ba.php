<?php
require_once '../../config/config.php';
require_once '../../config/database.php';
require_once '../../models/BrandAmbassador.php';

requireLogin();

$database = new Database();
$db = $database->connect();
$baModel = new BrandAmbassador($db);

$ambassadors = $baModel->getAll();

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="nedmun_brand_ambassadors_' . date('Y-m-d') . '.csv"');

$output = fopen('php://output', 'w');

// CSV Headers
fputcsv($output, [
    'ID', 'Name', 'Email', 'WhatsApp', 'CNIC', 'Institution', 
    'Education Level', 'Expected Delegates', 'PR Drive', 
    'Prior Experience', 'Status', 'Application Date'
]);

// CSV Data
foreach ($ambassadors as $ba) {
    fputcsv($output, [
        $ba['id'],
        $ba['full_name'],
        $ba['email'],
        $ba['whatsapp_number'],
        $ba['cnic_number'],
        $ba['institution'],
        $ba['education_level'],
        $ba['delegates_count'],
        $ba['pr_drive'],
        $ba['prior_experience'],
        $ba['status'],
        $ba['created_at']
    ]);
}

fclose($output);
exit();
?>
