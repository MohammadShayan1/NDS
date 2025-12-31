<?php
require_once '../config/config.php';
require_once '../config/database.php';

requireLogin();

$database = new Database();
$db = $database->connect();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_settings') {
    try {
        // Log for debugging
        error_log('Form submitted - Starting save process');
        
        $settings = [
            'site_name' => $_POST['site_name'] ?? '',
            'event_date' => $_POST['event_date'] ?? '',
            'event_venue' => $_POST['event_venue'] ?? '',
            'contact_email' => $_POST['contact_email'] ?? '',
            'contact_phone_1' => $_POST['contact_phone_1'] ?? '',
            'contact_phone_1_label' => $_POST['contact_phone_1_label'] ?? '',
            'contact_phone_2' => $_POST['contact_phone_2'] ?? '',
            'contact_phone_2_label' => $_POST['contact_phone_2_label'] ?? '',
            'delegate_fee' => $_POST['delegate_fee'] ?? '0',
            'delegation_fee' => $_POST['delegation_fee'] ?? '0',
            'ned_delegate_fee' => $_POST['ned_delegate_fee'] ?? '0',
            'ned_delegation_fee' => $_POST['ned_delegation_fee'] ?? '0',
            'early_bird_discount' => $_POST['early_bird_discount'] ?? '0',
            'early_bird_delegation_discount' => $_POST['early_bird_delegation_discount'] ?? '0',
            'ned_early_bird_discount' => $_POST['ned_early_bird_discount'] ?? '0',
            'early_bird_deadline' => $_POST['early_bird_deadline'] ?? date('Y-m-d'),
            'payment_account_title' => $_POST['payment_account_title'] ?? '',
            'payment_account_number' => $_POST['payment_account_number'] ?? '',
            'payment_bank_name' => $_POST['payment_bank_name'] ?? '',
            'payment_iban' => $_POST['payment_iban'] ?? '',
            'jazzcash_number' => $_POST['jazzcash_number'] ?? '',
            'easypaisa_number' => $_POST['easypaisa_number'] ?? '',
            'delegate_card_title' => $_POST['delegate_card_title'] ?? 'Delegate Registration',
            'delegate_card_description' => $_POST['delegate_card_description'] ?? '',
            'registration_status' => isset($_POST['registration_status']) ? 'open' : 'closed'
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
        
        error_log('Settings saved successfully');
        showAlert('Settings updated successfully!', 'success');
        redirect('admin/settings');
    } catch (Exception $e) {
        error_log('Error saving settings: ' . $e->getMessage());
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
    'site_name' => 'NEDMUN-VI',
    'event_date' => '2nd - 4th January, 2026',
    'event_venue' => 'NED University of Engineering And Technology, University Road, Karachi',
    'contact_email' => 'nedmunofficial@gmail.com',
    'contact_phone_1' => '0324-3343946',
    'contact_phone_1_label' => 'Directorate General',
    'contact_phone_2' => '0333-3772513',
    'contact_phone_2_label' => 'Deputy Secretary General',
    'delegate_fee' => '3000',
    'delegation_fee' => '2500',
    'ned_delegate_fee' => '2500',
    'ned_delegation_fee' => '2000',
    'early_bird_discount' => '500',
    'early_bird_delegation_discount' => '500',
    'ned_early_bird_discount' => '300',
    'early_bird_deadline' => date('Y-m-d', strtotime('+30 days')),
    'payment_account_title' => 'NEDMUN-VI',
    'payment_account_number' => '',
    'payment_bank_name' => '',
    'payment_iban' => '',
    'jazzcash_number' => '',
    'easypaisa_number' => '',
    'delegate_card_title' => 'Delegate Registration',
    'delegate_card_description' => 'Register as an individual delegate or delegation for NEDMUN-VI',
    'registration_status' => 'open',
    'event_registration_status' => 'open',
    'event_fee' => '500',
    'ned_event_fee' => '300',
    'bank_name' => 'Habib Bank Limited (HBL)',
    'account_title' => 'NED Debating Society',
    'account_number' => '12345678901234'
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
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/NEDMUN.webp">
    <link rel="apple-touch-icon" href="<?php echo BASE_URL; ?>assets/images/NEDMUN.webp">
    
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
                
                <!-- Event Information -->
                <h5 class="mb-3"><i class="fas fa-calendar-alt me-2"></i>Event Information</h5>
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Site Name</label>
                        <input type="text" class="form-control" name="site_name" value="<?php echo htmlspecialchars($settings['site_name']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Event Date</label>
                        <input type="text" class="form-control" name="event_date" value="<?php echo htmlspecialchars($settings['event_date']); ?>" required>
                        <small class="text-muted">Format: 2nd - 4th January, 2026</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Early Bird Deadline</label>
                        <input type="date" class="form-control" name="early_bird_deadline" value="<?php echo htmlspecialchars($settings['early_bird_deadline']); ?>" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Event Venue</label>
                        <input type="text" class="form-control" name="event_venue" value="<?php echo htmlspecialchars($settings['event_venue']); ?>" required>
                    </div>
                </div>

                <!-- Contact Information -->
                <h5 class="mb-3"><i class="fas fa-address-book me-2"></i>Contact Information</h5>
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Contact Email</label>
                        <input type="email" class="form-control" name="contact_email" value="<?php echo htmlspecialchars($settings['contact_email']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Contact Phone 1</label>
                        <input type="text" class="form-control" name="contact_phone_1" value="<?php echo htmlspecialchars($settings['contact_phone_1']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Contact Phone 1 Designation</label>
                        <input type="text" class="form-control" name="contact_phone_1_label" value="<?php echo htmlspecialchars($settings['contact_phone_1_label']); ?>" required>
                        <small class="text-muted">e.g., Directorate General, Event Manager</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Contact Phone 2</label>
                        <input type="text" class="form-control" name="contact_phone_2" value="<?php echo htmlspecialchars($settings['contact_phone_2']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Contact Phone 2 Designation</label>
                        <input type="text" class="form-control" name="contact_phone_2_label" value="<?php echo htmlspecialchars($settings['contact_phone_2_label']); ?>" required>
                        <small class="text-muted">e.g., Deputy Secretary General, Support Team</small>
                    </div>
                </div>
                
                <!-- Payment Settings -->
                <h5 class="mb-3"><i class="fas fa-money-bill-wave me-2"></i>Payment Information</h5>
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Individual Delegate Fee - Other Institutions (PKR)</label>
                        <input type="number" class="form-control" name="delegate_fee" value="<?php echo htmlspecialchars($settings['delegate_fee']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Delegation Fee per Member - Other Institutions (PKR)</label>
                        <input type="number" class="form-control" name="delegation_fee" value="<?php echo htmlspecialchars($settings['delegation_fee']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Individual Delegate Fee - NED Students (PKR)</label>
                        <input type="number" class="form-control" name="ned_delegate_fee" value="<?php echo htmlspecialchars($settings['ned_delegate_fee']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Delegation Fee per Member - NED Students (PKR)</label>
                        <input type="number" class="form-control" name="ned_delegation_fee" value="<?php echo htmlspecialchars($settings['ned_delegation_fee']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Early Bird Discount - Individual Delegate (Other Institutions) (PKR)</label>
                        <input type="number" class="form-control" name="early_bird_discount" value="<?php echo htmlspecialchars($settings['early_bird_discount']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Early Bird Discount - Delegation (Other Institutions) (PKR)</label>
                        <input type="number" class="form-control" name="early_bird_delegation_discount" value="<?php echo htmlspecialchars($settings['early_bird_delegation_discount']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Early Bird Discount - NED Students (PKR)</label>
                        <input type="number" class="form-control" name="ned_early_bird_discount" value="<?php echo htmlspecialchars($settings['ned_early_bird_discount']); ?>" required>
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
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Delegate Card Description</label>
                        <textarea class="form-control summernote" name="delegate_card_description" rows="5"><?php echo htmlspecialchars($settings['delegate_card_description']); ?></textarea>
                    </div>
                </div>

                <!-- Registration Status -->
                <h5 class="mb-3"><i class="fas fa-toggle-on me-2"></i>Registration Status</h5>
                <div class="row mb-4">
                    <div class="col-md-12 mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="registration_status" id="registration_status" <?php echo $settings['registration_status'] === 'open' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="registration_status">
                                Delegate Registration Open
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
            // Initialize Summernote
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });
            
            // Ensure Summernote content syncs before form submission
            $('form').on('submit', function(e) {
                // Sync all Summernote editors
                $('.summernote').each(function() {
                    var content = $(this).summernote('code');
                    $(this).val(content);
                });
                
                console.log('Form submitting...');
                console.log('Summernote synced');
                return true;
            });
        });
    </script>
</body>
</html>
