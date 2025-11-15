<?php
require_once '../config/config.php';
require_once '../config/database.php';

requireLogin();

$database = new Database();
$db = $database->connect();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_settings') {
    try {
        $settings = [
            'delegate_fee' => $_POST['delegate_fee'],
            'delegation_fee' => $_POST['delegation_fee'],
            'early_bird_discount' => $_POST['early_bird_discount'],
            'early_bird_deadline' => $_POST['early_bird_deadline'],
            'payment_account_title' => $_POST['payment_account_title'],
            'payment_account_number' => $_POST['payment_account_number'],
            'payment_bank_name' => $_POST['payment_bank_name'],
            'payment_iban' => $_POST['payment_iban'],
            'jazzcash_number' => $_POST['jazzcash_number'],
            'easypaisa_number' => $_POST['easypaisa_number'],
            'delegate_card_title' => $_POST['delegate_card_title'],
            'delegate_card_description' => $_POST['delegate_card_description'],
            'ba_card_title' => $_POST['ba_card_title'],
            'ba_card_description' => $_POST['ba_card_description'],
            'registration_status' => isset($_POST['registration_status']) ? 'open' : 'closed',
            'ba_registration_status' => isset($_POST['ba_registration_status']) ? 'open' : 'closed'
        ];
        
        foreach ($settings as $key => $value) {
            $query = "INSERT INTO site_settings (setting_key, setting_value) 
                     VALUES (:key, :value) 
                     ON DUPLICATE KEY UPDATE setting_value = :value";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':key', $key);
            $stmt->bindParam(':value', $value);
            $stmt->execute();
        }
        
        showAlert('Settings updated successfully!', 'success');
        redirect('admin/settings');
    } catch (Exception $e) {
        showAlert('Error updating settings: ' . $e->getMessage(), 'danger');
    }
}

// Fetch current settings
$query = "SELECT setting_key, setting_value FROM site_settings";
$stmt = $db->prepare($query);
$stmt->execute();
$settingsData = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Default values
$defaults = [
    'delegate_fee' => '3000',
    'delegation_fee' => '2500',
    'early_bird_discount' => '500',
    'early_bird_deadline' => date('Y-m-d', strtotime('+30 days')),
    'payment_account_title' => 'NEDMUN-VI',
    'payment_account_number' => '',
    'payment_bank_name' => '',
    'payment_iban' => '',
    'jazzcash_number' => '',
    'easypaisa_number' => '',
    'delegate_card_title' => 'Delegate Registration',
    'delegate_card_description' => 'Register as an individual delegate or delegation for NEDMUN-VI',
    'ba_card_title' => 'Brand Ambassador',
    'ba_card_description' => 'Become a Brand Ambassador and represent NEDMUN-VI at your institution',
    'registration_status' => 'open',
    'ba_registration_status' => 'open'
];

$settings = array_merge($defaults, $settingsData);

$alert = getAlert();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Settings - <?php echo SITE_NAME; ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/NEDMUN_LOGO_PNG.webp">
    <link rel="apple-touch-icon" href="<?php echo BASE_URL; ?>assets/images/NEDMUN_LOGO_PNG.webp">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/admin.css">
    <!-- Summernote WYSIWYG Editor -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div class="main-content">
        <?php include 'includes/header.php'; ?>

        <div class="container-fluid py-4">
            <?php if ($alert): ?>
            <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $alert['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fas fa-cog me-2"></i>Site Settings</h1>
            </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-sliders-h me-2"></i>
            Manage Site Configuration
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <input type="hidden" name="action" value="update_settings">
                
                <!-- Payment Settings -->
                <h5 class="mb-3"><i class="fas fa-money-bill-wave me-2"></i>Payment Information</h5>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Individual Delegate Fee (PKR)</label>
                        <input type="number" class="form-control" name="delegate_fee" value="<?php echo htmlspecialchars($settings['delegate_fee']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Delegation Fee per Member (PKR)</label>
                        <input type="number" class="form-control" name="delegation_fee" value="<?php echo htmlspecialchars($settings['delegation_fee']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Early Bird Discount (PKR)</label>
                        <input type="number" class="form-control" name="early_bird_discount" value="<?php echo htmlspecialchars($settings['early_bird_discount']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Early Bird Deadline</label>
                        <input type="date" class="form-control" name="early_bird_deadline" value="<?php echo htmlspecialchars($settings['early_bird_deadline']); ?>" required>
                    </div>
                </div>

                <!-- Bank Account Details -->
                <h5 class="mb-3"><i class="fas fa-university me-2"></i>Bank Account Details</h5>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Account Title</label>
                        <input type="text" class="form-control" name="payment_account_title" value="<?php echo htmlspecialchars($settings['payment_account_title']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Account Number</label>
                        <input type="text" class="form-control" name="payment_account_number" value="<?php echo htmlspecialchars($settings['payment_account_number']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bank Name</label>
                        <input type="text" class="form-control" name="payment_bank_name" value="<?php echo htmlspecialchars($settings['payment_bank_name']); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">IBAN</label>
                        <input type="text" class="form-control" name="payment_iban" value="<?php echo htmlspecialchars($settings['payment_iban']); ?>">
                    </div>
                </div>

                <!-- Mobile Payment -->
                <h5 class="mb-3"><i class="fas fa-mobile-alt me-2"></i>Mobile Payment Details</h5>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">JazzCash Number</label>
                        <input type="tel" class="form-control" name="jazzcash_number" value="<?php echo htmlspecialchars($settings['jazzcash_number']); ?>" placeholder="03XX-XXXXXXX">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Easypaisa Number</label>
                        <input type="tel" class="form-control" name="easypaisa_number" value="<?php echo htmlspecialchars($settings['easypaisa_number']); ?>" placeholder="03XX-XXXXXXX">
                    </div>
                </div>

                <!-- Registration Card Content -->
                <h5 class="mb-3"><i class="fas fa-id-card me-2"></i>Registration Card Content</h5>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Delegate Card Title</label>
                        <input type="text" class="form-control" name="delegate_card_title" value="<?php echo htmlspecialchars($settings['delegate_card_title']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Delegate Card Description</label>
                        <textarea class="form-control summernote" name="delegate_card_description" rows="5" required><?php echo htmlspecialchars($settings['delegate_card_description']); ?></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Brand Ambassador Card Title</label>
                        <input type="text" class="form-control" name="ba_card_title" value="<?php echo htmlspecialchars($settings['ba_card_title']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Brand Ambassador Card Description</label>
                        <textarea class="form-control summernote" name="ba_card_description" rows="5" required><?php echo htmlspecialchars($settings['ba_card_description']); ?></textarea>
                    </div>
                </div>

                <!-- Registration Status -->
                <h5 class="mb-3"><i class="fas fa-toggle-on me-2"></i>Registration Status</h5>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="registration_status" id="registration_status" <?php echo $settings['registration_status'] === 'open' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="registration_status">
                                Delegate Registration Open
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="ba_registration_status" id="ba_registration_status" <?php echo $settings['ba_registration_status'] === 'open' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="ba_registration_status">
                                Brand Ambassador Registration Open
                            </label>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (required for Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <style>
        /* Fix Summernote visibility on dark background */
        .note-editor.note-frame {
            background: #ffffff !important;
            border: 1px solid #dee2e6 !important;
        }
        .note-editing-area .note-editable {
            background: #ffffff !important;
            color: #000000 !important;
        }
        .note-toolbar {
            background: #f8f9fa !important;
            border-bottom: 1px solid #dee2e6 !important;
        }
        .note-btn {
            background: #ffffff !important;
            color: #000000 !important;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });
        });
    </script>
</body>
</html>
