<?php
require_once 'config/config.php';
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .error-container {
            text-align: center;
            color: white;
        }
        .error-code {
            font-size: 150px;
            font-weight: 900;
            line-height: 1;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-container">
            <div class="error-code">404</div>
            <h1 class="display-4 mb-4">Page Not Found</h1>
            <p class="lead mb-5">Sorry, the page you're looking for doesn't exist.</p>
            <div>
                <a href="<?php echo BASE_URL; ?>" class="btn btn-light btn-lg me-2">
                    <i class="fas fa-home me-2"></i>Go Home
                </a>
                <a href="<?php echo BASE_URL; ?>register" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Register Now
                </a>
            </div>
        </div>
    </div>
</body>
</html>
