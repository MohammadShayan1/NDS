<?php
require_once '../config/config.php';

// Check if registration is open
$registrationStatus = getSetting('event_registration_status', 'open');

$alert = getAlert();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harf-e-Raaz Registration | NEDMUN-VI</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/NEDMUN.webp">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 100%);
            min-height: 100vh;
        }
        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            margin: 50px auto;
            max-width: 700px;
        }
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-header h1 {
            color: #d4af37;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .form-header .urdu-title {
            font-size: 2.5rem;
            color: #d4af37;
            font-weight: 800;
            margin-bottom: 15px;
            text-shadow: 0 0 12px rgba(212, 175, 55, 0.3);
        }
        .btn-submit {
            background: linear-gradient(135deg, #d4af37, #b8860b);
            border: 2px solid #d4af37;
            color: #000;
            padding: 12px 40px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #daa520, #d4af37);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(212, 175, 55, 0.5), 0 0 30px rgba(212, 175, 55, 0.3);
            color: #000;
        }
        .required-star {
            color: #dc3545;
        }
        .alert-info {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(184, 134, 11, 0.1)) !important;
            border: 2px solid #d4af37 !important;
            border-left: 4px solid #d4af37 !important;
            color: #000 !important;
        }
        .alert-info h6 {
            color: #000 !important;
            font-weight: 700;
        }
        .alert-info p {
            color: #000 !important;
        }
        .alert-info strong {
            color: #8b7500 !important;
        }
        .alert-info i {
            color: #d4af37 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($registrationStatus !== 'open'): ?>
        <div class="form-container">
            <div class="form-header">
                <div class="urdu-title">حرف راز</div>
                <h1>Registration Closed</h1>
            </div>
            <div class="alert alert-danger text-center">
                <i class="fas fa-times-circle fa-3x mb-3"></i>
                <h4>Registration is Currently Closed</h4>
                <p>Thank you for your interest in Harf-e-Raaz. Registration is currently not available.</p>
                <p>For inquiries, please contact: <strong><?php echo getSetting('contact_email', 'nedmunofficial@gmail.com'); ?></strong></p>
                <a href="<?php echo BASE_URL; ?>" class="btn btn-primary mt-3">
                    <i class="fas fa-home me-2"></i>Back to Home
                </a>
            </div>
        </div>
        <?php else: ?>
        <div class="form-container">
            <?php if ($alert): ?>
            <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $alert['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="form-header">
                <div class="urdu-title">حرف راز</div>
                <h1>Social Event</h1>
                <p class="text-muted">Join us for an exclusive event experience</p>
            </div>

            <form action="<?php echo BASE_URL; ?>controllers/EventRegistrationController.php" method="POST" enctype="multipart/form-data" id="eventForm">
                
                <!-- Full Name -->
                <div class="mb-4">
                    <label class="form-label">Full Name <span class="required-star">*</span></label>
                    <input type="text" class="form-control" name="full_name" required>
                </div>

                <!-- CNIC -->
                <div class="mb-4">
                    <label class="form-label">CNIC Number <span class="required-star">*</span></label>
                    <input type="text" class="form-control" name="cnic_number" placeholder="xxxxx-xxxxxxx-x" pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}" required>
                    <small class="text-muted">Format: 12345-1234567-1</small>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="form-label">Email Address <span class="required-star">*</span></label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <!-- Phone Number -->
                <div class="mb-4">
                    <label class="form-label">Phone Number <span class="required-star">*</span></label>
                    <input type="tel" class="form-control" name="phone_number" placeholder="03XX-XXXXXXX" required>
                </div>

                <!-- Payment Screenshot -->
                <div class="mb-4">
                    <label class="form-label">Payment Screenshot <span class="required-star">*</span></label>
                    <input type="file" class="form-control" name="payment_screenshot" accept="image/*" required id="paymentFile">
                    <small class="text-muted">Upload proof of payment (JPG, PNG, or PDF - Max 5MB)</small>
                    <div id="imagePreview" class="mt-3" style="display: none;">
                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                    </div>
                </div>

                <!-- Bank Details Info -->
                <div class="alert alert-info">
                    <h6><i class="fas fa-university me-2"></i>Payment Details</h6>
                    <p class="mb-0"><strong>Bank:</strong> <?php echo getSetting('bank_name', 'HBL'); ?></p>
                    <p class="mb-0"><strong>Account Title:</strong> <?php echo getSetting('account_title', 'NED Debating Society'); ?></p>
                    <p class="mb-0"><strong>Account Number:</strong> <?php echo getSetting('account_number', '1234567890'); ?></p>
                    <p class="mb-0"><strong>Registration Fee (NED Students):</strong> PKR <?php echo getSetting('ned_event_fee', '300'); ?></p>
                    <p class="mb-0"><strong>Registration Fee (Other Institutions):</strong> PKR <?php echo getSetting('event_fee', '500'); ?></p>
                </div>

                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-submit btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>Submit Registration
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="<?php echo BASE_URL; ?>" class="text-muted">
                    <i class="fas fa-arrow-left me-2"></i>Back to Home
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Image preview
        document.getElementById('paymentFile').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        // CNIC formatting
        document.querySelector('input[name="cnic_number"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value.length > 5) {
                value = value.slice(0, 5) + '-' + value.slice(5);
            }
            if (value.length > 13) {
                value = value.slice(0, 13) + '-' + value.slice(13, 14);
            }
            e.target.value = value;
        });
    </script>
</body>
</html>
