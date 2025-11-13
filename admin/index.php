<?php
/**
 * Admin Directory Index
 * Redirects to login page if not authenticated, otherwise to dashboard
 */

require_once '../config/config.php';

// Check if user is already logged in
if (isLoggedIn()) {
    header('Location: ' . BASE_URL . 'admin/dashboard.php');
    exit();
} else {
    header('Location: ' . BASE_URL . 'admin/login.php');
    exit();
}
