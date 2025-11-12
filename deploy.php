<?php
/**
 * Auto-Deploy Script for cPanel
 * 
 * This script pulls the latest code from Git when triggered
 * Set up a webhook in your Git repository to call this file
 * 
 * GitHub Webhook URL: https://yourdomain.com/deploy.php?key=YOUR_SECRET_KEY
 */

// Security: Set a secret key (change this!)
define('DEPLOY_SECRET_KEY', 'YOUR_SECRET_KEY_HERE_CHANGE_THIS');

// Verify secret key
$provided_key = $_GET['key'] ?? '';
if ($provided_key !== DEPLOY_SECRET_KEY) {
    http_response_code(403);
    die('Unauthorized');
}

// Log file
$log_file = __DIR__ . '/deployment.log';

// Function to log messages
function log_message($message) {
    global $log_file;
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND);
    echo "$message\n";
}

// Start deployment
log_message('=== Deployment Started ===');

// Change to repository directory
chdir(__DIR__);

// Execute git pull
$output = [];
$return_var = 0;

// Fetch latest changes
exec('git fetch origin 2>&1', $output, $return_var);
log_message('Git Fetch: ' . implode("\n", $output));

// Pull changes
$output = [];
exec('git pull origin main 2>&1', $output, $return_var);
log_message('Git Pull: ' . implode("\n", $output));

if ($return_var === 0) {
    log_message('✓ Deployment successful!');
    
    // Optional: Clear cache if you have one
    if (file_exists(__DIR__ . '/cache')) {
        array_map('unlink', glob(__DIR__ . '/cache/*'));
        log_message('✓ Cache cleared');
    }
    
    http_response_code(200);
    echo "Deployment successful!";
} else {
    log_message('✗ Deployment failed!');
    http_response_code(500);
    echo "Deployment failed!";
}

log_message('=== Deployment Finished ===');
?>
