<?php
require_once '../config/config.php';

// Destroy session and redirect to login
session_destroy();
redirect('admin/login');
?>
