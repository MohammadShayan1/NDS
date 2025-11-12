<?php
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../models/Admin.php';

// If already logged in, redirect to dashboard
if (isLoggedIn()) {
    redirect('admin/dashboard');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    $database = new Database();
    $db = $database->connect();
    $adminModel = new Admin($db);

    $admin = $adminModel->login($username, $password);

    if ($admin) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        redirect('admin/dashboard');
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - <?php echo SITE_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 450px;
            width: 100%;
            background: #0d0d0d;
            border: 2px solid #d4af37;
        }
        .card-body {
            background: #000;
        }
        .nds-logo-login {
            max-width: 280px;
            margin: 0 auto 20px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #d4af37, #b8860b);
            border: none;
            color: #000;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #b8860b, #8b7500);
        }
        .form-control:focus {
            border-color: #d4af37;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
        }
        .input-group-text {
            background: #1a1a1a;
            color: #d4af37;
            border-color: #d4af37;
        }
        .form-control {
            background: #1a1a1a;
            color: #fff;
            border-color: #d4af37;
        }
        h3 {
            color: #d4af37;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg login-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="<?php echo BASE_URL; ?>assets/images/nds-logo.png" alt="NED Debating Society" class="img-fluid nds-logo-login">
                            <h3 class="mt-3">Admin Login</h3>
                            <p class="text-muted">NEDMUN-VI Management Portal</p>
                        </div>

                        <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                        </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" required autofocus>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <a href="<?php echo BASE_URL; ?>" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>Back to Website
                            </a>
                        </div>
                        <div class="text-center mt-3 pt-3" style="border-top: 1px solid rgba(212, 175, 55, 0.2);">
                            <small style="color: #d4af37;">
                                <i class="fas fa-code me-1"></i>
                                Tech Partner: <a href="https://telinks.org" target="_blank" style="color: #d4af37; text-decoration: none; font-weight: 600;">TE Links</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
