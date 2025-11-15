<?php
require_once '../config/config.php';
$alert = getAlert();

// Get payment settings
$jazzcashNumber = getSetting('jazzcash_number', '');
$easypaisaNumber = getSetting('easypaisa_number', '');
$accountTitle = getSetting('payment_account_title', 'NEDMUN-VI');
$accountNumber = getSetting('payment_account_number', '');
$bankName = getSetting('payment_bank_name', '');
$iban = getSetting('payment_iban', '');
$delegateFee = getSetting('delegate_fee', '3000');
$delegationFee = getSetting('delegation_fee', '2500');
$earlyBirdDiscount = getSetting('early_bird_discount', '500');
$earlyBirdDeadline = getSetting('early_bird_deadline', date('Y-m-d'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delegate Registration - <?php echo SITE_NAME; ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Register for NEDMUN-VI - Karachi's largest Model United Nations conference. Individual delegates and delegations welcome from NED and other institutions.">
    <meta name="keywords" content="NEDMUN Registration, MUN Registration Karachi, Model UN Delegate, NEDMUN-VI Registration">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/NEDMUN_LOGO_PNG.webp">
    <link rel="apple-touch-icon" href="<?php echo BASE_URL; ?>assets/images/NEDMUN_LOGO_PNG.webp">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <style>
        body {
            padding-top: 0px !important;
        }
        .form-step {
            display: none;
        }
        .form-step.active {
            display: block;
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark pb-2">
        <div class="container position-relative">
            <div class="w-100 d-flex justify-content-center align-items-center">
                <img src="<?php echo BASE_URL; ?>assets/images/nds-logo.png" alt="NDS Logo" style="height: 50px; margin-right: 12px;">
                <span style="font-size: 28px; color: var(--secondary-color); font-weight: 600; margin: 0 12px;">X</span>
                <img src="<?php echo BASE_URL; ?>assets/images/telinkslogoblwh.png" alt="TE Links Logo" style="height: 45px; margin-left: 12px; filter: brightness(0) saturate(100%) invert(60%) sepia(80%) saturate(500%) hue-rotate(10deg) brightness(95%) contrast(90%);">
            </div>
            <a href="<?php echo BASE_URL; ?>" class="btn btn-sm btn-outline-warning position-absolute end-0">
                <i class="fas fa-arrow-left me-2"></i>Back to Home
            </a>
        </div>
    </nav>

    <!-- Form Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <?php if ($alert): ?>
                    <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                        <?php echo $alert['message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h1 class="h3 mb-1"><i class="fas fa-users me-2"></i>NEDMUN-VI DELEGATE REGISTRATION</h1>
                            <p class="mb-0">Join Karachi's Largest Model United Nations</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="alert alert-success">
                                <h5><i class="fas fa-clock me-2"></i>Early Bird Registration!</h5>
                                <p class="mb-0">Register before <?php echo EARLY_BIRD_DEADLINE; ?> to avail special early bird rates!</p>
                            </div>

                            <form action="<?php echo BASE_URL; ?>register?action=submit" method="POST" id="delegateForm" enctype="multipart/form-data">
                                
                                <!-- Step 1: Registration & Participant Type -->
                                <div class="form-step active" id="step1">
                                    <h5 class="mb-4"><i class="fas fa-user-check me-2"></i>Step 1: Registration Type</h5>
                                    
                                    <!-- Registration Type -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Registration Type <span class="text-danger">*</span></label>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-check custom-radio-card">
                                                    <input class="form-check-input" type="radio" name="registration_type" id="ned_type" value="NED" required>
                                                    <label class="form-check-label w-100 p-3 border rounded" for="ned_type">
                                                        <i class="fas fa-university fa-2x d-block mb-2 text-primary"></i>
                                                        <strong>NED Student</strong>
                                                        <p class="small mb-0 text-muted">For current NED University students</p>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check custom-radio-card">
                                                    <input class="form-check-input" type="radio" name="registration_type" id="other_type" value="Other" required>
                                                    <label class="form-check-label w-100 p-3 border rounded" for="other_type">
                                                        <i class="fas fa-school fa-2x d-block mb-2 text-primary"></i>
                                                        <strong>Other Institution</strong>
                                                        <p class="small mb-0 text-muted">For students from other schools/universities</p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Participant Type -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Participant Type <span class="text-danger">*</span></label>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-check custom-radio-card">
                                                    <input class="form-check-input" type="radio" name="participant_type" id="delegate_type" value="delegate" required>
                                                    <label class="form-check-label w-100 p-3 border rounded" for="delegate_type">
                                                        <i class="fas fa-user fa-2x d-block mb-2 text-success"></i>
                                                        <strong>Individual Delegate</strong>
                                                        <p class="small mb-0 text-muted">Participating as an individual</p>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check custom-radio-card">
                                                    <input class="form-check-input" type="radio" name="participant_type" id="delegation_type" value="delegation" required>
                                                    <label class="form-check-label w-100 p-3 border rounded" for="delegation_type">
                                                        <i class="fas fa-users fa-2x d-block mb-2 text-success"></i>
                                                        <strong>Delegation</strong>
                                                        <p class="small mb-0 text-muted">Registering a group of delegates</p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary next-step" disabled id="step1NextBtn">
                                            Next <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 2: Personal Information -->
                                <div class="form-step" id="step2">
                                    <h5 class="mb-4"><i class="fas fa-id-card me-2"></i>Step 2: Personal Information</h5>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="03XX-XXXXXXX or +92XXX-XXXXXXX" maxlength="15" required>
                                            <small class="text-muted">Format: 03XX-XXXXXXX or +92XXX-XXXXXXX</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="whatsapp_number" class="form-label">WhatsApp Number <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" id="whatsapp_number" name="whatsapp_number" placeholder="03XX-XXXXXXX or +92XXX-XXXXXXX" maxlength="15" required>
                                            <small class="text-muted">Format: 03XX-XXXXXXX or +92XXX-XXXXXXX</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="cnic_number" class="form-label">CNIC / B-Form Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cnic_number" name="cnic_number" placeholder="XXXXX-XXXXXXX-X" maxlength="15" required>
                                        <small class="text-muted">Format: XXXXX-XXXXXXX-X</small>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary prev-step">
                                            <i class="fas fa-arrow-left me-2"></i> Previous
                                        </button>
                                        <button type="button" class="btn btn-primary next-step">
                                            Next <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 3: Institution Details -->
                                <div class="form-step" id="step3">
                                    <h5 class="mb-4"><i class="fas fa-graduation-cap me-2"></i>Step 3: Institution Details</h5>

                                    <div class="mb-3" id="institutionNameField">
                                        <label for="institution_name" class="form-label">Institution Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="institution_name" name="institution_name" required>
                                    </div>

                                    <div class="mb-3" id="educationLevelField">
                                        <label for="education_level" class="form-label">Education Level <span class="text-danger">*</span></label>
                                        <select class="form-select" id="education_level" name="education_level" required>
                                            <option value="">Select your level</option>
                                            <option value="Middle school">Middle school</option>
                                            <option value="O Levels/ Secondary School">O Levels / Secondary School</option>
                                            <option value="A Levels / Higher Secondary School">A Levels / Higher Secondary School</option>
                                            <option value="Undergraduate">Undergraduate</option>
                                            <option value="Masters">Masters</option>
                                        </select>
                                    </div>

                                    <!-- Delegation Details (shown only if delegation is selected) -->
                                    <div id="delegationDetails" style="display: none;">
                                        <h6 class="mb-3 mt-4"><i class="fas fa-users-cog me-2"></i>Delegation Details</h6>
                                        
                                        <div class="mb-3">
                                            <label for="head_delegate_name" class="form-label">Head Delegate Name</label>
                                            <input type="text" class="form-control" id="head_delegate_name" name="head_delegate_name">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary prev-step">
                                            <i class="fas fa-arrow-left me-2"></i> Previous
                                        </button>
                                        <button type="button" class="btn btn-primary next-step">
                                            Next <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 4: Committee Preferences -->
                                <div class="form-step" id="step4">
                                    <h5 class="mb-4"><i class="fas fa-list-ul me-2"></i>Step 4: Committee Preferences</h5>

                                    <div class="mb-3">
                                        <label for="committee_preference_1" class="form-label">First Preference</label>
                                        <select class="form-select" id="committee_preference_1" name="committee_preference_1">
                                            <option value="">Select committee</option>
                                            <option value="UNSC">UNSC – United Nations Security Council (Double Delegate)</option>
                                            <option value="UNCSTD">UNCSTD – UN Commission on Science and Technology for Development</option>
                                            <option value="UNWOMEN">UNWOMEN – UN Entity for Gender Equality and the Empowerment of Women</option>
                                            <option value="DISEC">DISEC – Disarmament and International Security Committee</option>
                                            <option value="SPECPOL">SPECPOL – Special Political and Decolonization Committee</option>
                                            <option value="SOCHUM">SOCHUM – Social, Humanitarian, and Cultural Committee</option>
                                            <option value="KCC">KCC – Karachi Crisis Committee</option>
                                            <option value="PNA">PNA – Pakistan National Assembly</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="committee_preference_2" class="form-label">Second Preference</label>
                                        <select class="form-select" id="committee_preference_2" name="committee_preference_2">
                                            <option value="">Select committee</option>
                                            <option value="UNSC">UNSC – United Nations Security Council (Double Delegate)</option>
                                            <option value="UNCSTD">UNCSTD – UN Commission on Science and Technology for Development</option>
                                            <option value="UNWOMEN">UNWOMEN – UN Entity for Gender Equality and the Empowerment of Women</option>
                                            <option value="DISEC">DISEC – Disarmament and International Security Committee</option>
                                            <option value="SPECPOL">SPECPOL – Special Political and Decolonization Committee</option>
                                            <option value="SOCHUM">SOCHUM – Social, Humanitarian, and Cultural Committee</option>
                                            <option value="KCC">KCC – Karachi Crisis Committee</option>
                                            <option value="PNA">PNA – Pakistan National Assembly</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="committee_preference_3" class="form-label">Third Preference</label>
                                        <select class="form-select" id="committee_preference_3" name="committee_preference_3">
                                            <option value="">Select committee</option>
                                            <option value="UNSC">UNSC – United Nations Security Council (Double Delegate)</option>
                                            <option value="UNCSTD">UNCSTD – UN Commission on Science and Technology for Development</option>
                                            <option value="UNWOMEN">UNWOMEN – UN Entity for Gender Equality and the Empowerment of Women</option>
                                            <option value="DISEC">DISEC – Disarmament and International Security Committee</option>
                                            <option value="SPECPOL">SPECPOL – Special Political and Decolonization Committee</option>
                                            <option value="SOCHUM">SOCHUM – Social, Humanitarian, and Cultural Committee</option>
                                            <option value="KCC">KCC – Karachi Crisis Committee</option>
                                            <option value="PNA">PNA – Pakistan National Assembly</option>
                                        </select>
                                    </div>

                                    <!-- Double Delegate Details (shown only if UNSC is selected) -->
                                    <div id="doubleDellegateDetails" style="display: none;">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i><strong>UNSC is a Double Delegate Committee</strong> - Please provide partner delegate information
                                        </div>
                                        <h6 class="mb-3">Partner Delegate Information</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="partner_name" class="form-label">Partner Full Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control partner-field" id="partner_name" name="partner_name">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="partner_email" class="form-label">Partner Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control partner-field" id="partner_email" name="partner_email">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="partner_phone" class="form-label">Partner Phone <span class="text-danger">*</span></label>
                                                <input type="tel" class="form-control partner-field" id="partner_phone" name="partner_phone" placeholder="03XX-XXXXXXX or +92XXX-XXXXXXX" maxlength="15">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="partner_cnic" class="form-label">Partner CNIC</label>
                                                <input type="text" class="form-control" id="partner_cnic" name="partner_cnic" placeholder="XXXXX-XXXXXXX-X" maxlength="15">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="partner_experience" class="form-label">Partner's Previous MUN Experience</label>
                                            <textarea class="form-control" id="partner_experience" name="partner_experience" rows="2" placeholder="Partner's previous MUN experience (if any)"></textarea>
                                        </div>
                                    </div>

                                    <!-- Delegation Members (shown only if delegation is selected) -->
                                    <div id="delegationMembersSection" style="display: none;">
                                        <h6 class="mb-3 mt-4"><i class="fas fa-users me-2"></i>Delegation Members Information</h6>
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>Add delegation members (Maximum 9 members). Click "Add Member" to add each delegate's information.
                                        </div>
                                        <div id="delegationMembersContainer">
                                            <!-- Members will be added dynamically here -->
                                        </div>
                                        <button type="button" class="btn btn-outline-primary mb-3" id="addMemberBtn">
                                            <i class="fas fa-plus me-2"></i>Add Delegation Member
                                        </button>
                                        <div class="mb-2">
                                            <small class="text-muted">Members added: <strong id="memberCount">0</strong> / 9</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mun_experience" class="form-label">Previous MUN Experience</label>
                                        <textarea class="form-control" id="mun_experience" name="mun_experience" rows="3" placeholder="Please describe your previous MUN experience (if any)"></textarea>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary prev-step">
                                            <i class="fas fa-arrow-left me-2"></i> Previous
                                        </button>
                                        <button type="button" class="btn btn-primary next-step">
                                            Next <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Step 5: Payment & Submit -->
                                <div class="form-step" id="step5">
                                    <h5 class="mb-4"><i class="fas fa-credit-card me-2"></i>Step 5: Payment & Submit</h5>

                                    <div class="mb-3">
                                        <label for="reference" class="form-label">Reference</label>
                                        <input type="text" class="form-control" id="reference" name="reference" placeholder="Brand Ambassador or NEDMUN-VI Team Member (If Any)">
                                        <small class="text-muted">Optional: Please mention if referred by a Brand Ambassador or Team Member</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="promo_code" class="form-label">Promo Code</label>
                                        <input type="text" class="form-control" id="promo_code" name="promo_code" placeholder="Enter promo code if you have one">
                                        <small class="text-muted">Optional: Enter promo code for discounts (if applicable)</small>
                                    </div>

                                    <!-- Payment Screenshot Section -->
                                    <div class="mb-4">
                                        <div class="alert alert-info">
                                            <h6><i class="fas fa-info-circle me-2"></i>Payment Instructions</h6>
                                            <p class="mb-2"><strong>Registration Fees:</strong></p>
                                            <ul class="small mb-2">
                                                <li>Individual Delegate: <strong>PKR <?php echo number_format($delegateFee); ?></strong></li>
                                                <li>Delegation (per member): <strong>PKR <?php echo number_format($delegationFee); ?></strong></li>
                                                <li>Early Bird Discount (Till <?php echo date('jS M', strtotime($earlyBirdDeadline)); ?>): <strong>PKR <?php echo number_format($earlyBirdDiscount); ?> OFF</strong></li>
                                            </ul>
                                            
                                            <p class="mb-2 mt-3"><strong>Payment Methods:</strong></p>
                                            <ul class="small mb-0">
                                                <?php if (!empty($jazzcashNumber)): ?>
                                                <li><strong>JazzCash:</strong> <?php echo htmlspecialchars($jazzcashNumber); ?></li>
                                                <?php endif; ?>
                                                <?php if (!empty($easypaisaNumber)): ?>
                                                <li><strong>Easypaisa:</strong> <?php echo htmlspecialchars($easypaisaNumber); ?></li>
                                                <?php endif; ?>
                                                <?php if (!empty($accountNumber)): ?>
                                                <li class="mt-2"><strong>Bank Transfer:</strong></li>
                                                <li class="ms-3">Account Title: <?php echo htmlspecialchars($accountTitle); ?></li>
                                                <li class="ms-3">Account Number: <?php echo htmlspecialchars($accountNumber); ?></li>
                                                <?php if (!empty($bankName)): ?>
                                                <li class="ms-3">Bank: <?php echo htmlspecialchars($bankName); ?></li>
                                                <?php endif; ?>
                                                <?php if (!empty($iban)): ?>
                                                <li class="ms-3">IBAN: <?php echo htmlspecialchars($iban); ?></li>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                        
                                        <label for="payment_screenshot" class="form-label">Upload Payment Screenshot</label>
                                        <input type="file" class="form-control" id="payment_screenshot" name="payment_screenshot" accept="image/*">
                                        <small class="text-muted">Supported formats: JPG, PNG, JPEG (Max size: 5MB)</small>
                                        <div class="mt-2" id="screenshot_preview"></div>
                                    </div>

                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="terms_accept" required>
                                        <label class="form-check-label" for="terms_accept">
                                            I agree to the terms and conditions and confirm that all information provided is accurate. <span class="text-danger">*</span>
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-outline-secondary prev-step">
                                            <i class="fas fa-arrow-left me-2"></i> Previous
                                        </button>
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fas fa-check-circle me-2"></i>Complete Registration
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?php echo BASE_URL; ?>assets/images/nds-logo.png" alt="NED Debating Society" class="img-fluid me-2" style="max-width: 120px;">
                        <div style="width: 2px; height: 40px; background: #d4af37; margin: 0 8px;"></div>
                        <img src="<?php echo BASE_URL; ?>assets/images/NEDMUN_LOGO_PNG.webp" alt="NEDMUN-VI" class="img-fluid" style="max-width: 120px;">
                    </div>
                    <p class="text-muted small">Empowering youth through debate, diplomacy, and leadership.</p>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0 text-center">
                    <h6 style="color: #d4af37;">Contact Us</h6>
                    <p class="text-muted small mb-1">Email: nedmunofficial@gmail.com</p>
                    <p class="text-muted small mb-1">DG: 0324-3343946</p>
                    <p class="text-muted small">DSG: 0333-3772513</p>
                </div>
                <div class="col-lg-4 text-center text-lg-end">
                    <h6 style="color: #d4af37;">Follow Us</h6>
                    <div class="social-links">
                        <a href="<?php echo FACEBOOK_URL; ?>" target="_blank" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="<?php echo INSTAGRAM_URL; ?>" target="_blank" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr style="border-color: #d4af37; opacity: 0.3;" class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <p class="mb-0 text-muted small">&copy; <?php echo date('Y'); ?> NED Debating Society. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0 text-muted">
                        Developed by <a href="https://telinks.org/team-technical" target="_blank" class="text-decoration-none d-inline-flex align-items-center" style="color: var(--secondary-color); font-weight: 500;">
                            <span class="telinks-logo-container me-2" style="display: inline-block; position: relative; width: 24px; height: 24px;">
                                <img src="<?php echo BASE_URL; ?>assets/images/telinkslogoblwh.png" alt="TE Links Logo" style="width: 100%; height: 100%; object-fit: contain; filter: brightness(0) saturate(100%) invert(60%) sepia(80%) saturate(500%) hue-rotate(10deg) brightness(95%) contrast(90%);">
                            </span>
                            TE Links Technical Team
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let memberCount = 0;
        let currentStep = 1;
        const totalSteps = 5;

        // Multi-step form navigation
        function showStep(step) {
            document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
            document.getElementById('step' + step).classList.add('active');
            currentStep = step;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Next step buttons
        document.querySelectorAll('.next-step').forEach(btn => {
            btn.addEventListener('click', function(e) {
                console.log('Next button clicked, current step:', currentStep);
                if (validateCurrentStep()) {
                    if (currentStep < totalSteps) {
                        showStep(currentStep + 1);
                    }
                } else {
                    console.log('Validation failed for step', currentStep);
                }
            });
        });

        // Previous step buttons
        document.querySelectorAll('.prev-step').forEach(btn => {
            btn.addEventListener('click', function() {
                if (currentStep > 1) {
                    showStep(currentStep - 1);
                }
            });
        });

        // Validate current step before proceeding
        function validateCurrentStep() {
            const currentStepElement = document.getElementById('step' + currentStep);
            if (!currentStepElement) {
                console.error('Step element not found:', 'step' + currentStep);
                return false;
            }
            
            const requiredInputs = currentStepElement.querySelectorAll('[required]:not([type="radio"]):not([type="checkbox"])');
            const requiredRadios = currentStepElement.querySelectorAll('input[type="radio"][required]');
            const requiredCheckboxes = currentStepElement.querySelectorAll('input[type="checkbox"][required]');
            
            console.log('Validating step', currentStep, '- Inputs:', requiredInputs.length, 'Radios:', requiredRadios.length, 'Checkboxes:', requiredCheckboxes.length);
            
            // Check text/email/etc inputs
            for (let input of requiredInputs) {
                if (!input.value.trim() && input.style.display !== 'none' && !input.closest('[style*="display: none"]')) {
                    console.log('Validation failed for input:', input.name);
                    input.focus();
                    input.reportValidity();
                    return false;
                }
            }
            
            // Check radio buttons
            const radioGroups = {};
            requiredRadios.forEach(radio => {
                if (!radioGroups[radio.name]) radioGroups[radio.name] = [];
                radioGroups[radio.name].push(radio);
            });
            
            for (let groupName in radioGroups) {
                const group = radioGroups[groupName];
                const checked = group.some(radio => radio.checked);
                if (!checked) {
                    console.log('Validation failed for radio group:', groupName);
                    group[0].focus();
                    group[0].reportValidity();
                    return false;
                }
            }
            
            // Check checkboxes
            for (let checkbox of requiredCheckboxes) {
                if (!checkbox.checked && checkbox.style.display !== 'none') {
                    console.log('Validation failed for checkbox:', checkbox.name);
                    checkbox.focus();
                    checkbox.reportValidity();
                    return false;
                }
            }
            
            console.log('Validation passed for step', currentStep);
            return true;
        }

        // Enable step 1 next button when both registration and participant type are selected
        document.querySelectorAll('input[name="registration_type"], input[name="participant_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const regType = document.querySelector('input[name="registration_type"]:checked');
                const partType = document.querySelector('input[name="participant_type"]:checked');
                const nextBtn = document.getElementById('step1NextBtn');
                
                if (nextBtn) {
                    if (regType && partType) {
                        nextBtn.disabled = false;
                    } else {
                        nextBtn.disabled = true;
                    }
                }
            });
        });

        // Handle NED selection - auto-fill institution details
        document.querySelectorAll('input[name="registration_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const educationLevelSelect = document.getElementById('education_level');
                
                if (this.value === 'NED') {
                    document.getElementById('institution_name').value = 'NED University of Engineering & Technology';
                    document.getElementById('institution_name').readOnly = true;
                    
                    // Update education level options for NED students
                    educationLevelSelect.innerHTML = `
                        <option value="Undergraduate" selected>Undergraduate</option>
                        <option value="Masters">Masters</option>
                    `;
                } else {
                    document.getElementById('institution_name').value = '';
                    document.getElementById('institution_name').readOnly = false;
                    
                    // Restore all education level options for non-NED students
                    educationLevelSelect.innerHTML = `
                        <option value="">Select your level</option>
                        <option value="Middle school">Middle school</option>
                        <option value="O Levels/ Secondary School">O Levels / Secondary School</option>
                        <option value="A Levels / Higher Secondary School">A Levels / Higher Secondary School</option>
                        <option value="Undergraduate">Undergraduate</option>
                        <option value="Masters">Masters</option>
                    `;
                }
            });
        });

        // Show/hide delegation details and members based on participant type
        document.querySelectorAll('input[name="participant_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const delegationDetails = document.getElementById('delegationDetails');
                const delegationMembersSection = document.getElementById('delegationMembersSection');
                
                if (this.value === 'delegation') {
                    delegationDetails.style.display = 'block';
                    delegationMembersSection.style.display = 'block';
                    document.getElementById('delegation_size').required = true;
                } else {
                    delegationDetails.style.display = 'none';
                    delegationMembersSection.style.display = 'none';
                    document.getElementById('delegation_size').required = false;
                }
                
                // Re-check double delegate when participant type changes
                checkDoubleDelegate();
            });
        });

        // Check for UNSC (Double Delegate) selection
        function checkDoubleDelegate() {
            const committee1 = document.getElementById('committee_preference_1').value;
            const committee2 = document.getElementById('committee_preference_2').value;
            const committee3 = document.getElementById('committee_preference_3').value;
            const doubleSection = document.getElementById('doubleDellegateDetails');
            const partnerFields = document.querySelectorAll('.partner-field');
            const participantType = document.querySelector('input[name="participant_type"]:checked');
            
            // Only show partner details for individual delegates, not delegations
            if ((committee1 === 'UNSC' || committee2 === 'UNSC' || committee3 === 'UNSC') && 
                participantType && participantType.value === 'delegate') {
                doubleSection.style.display = 'block';
                // Make partner fields required
                partnerFields.forEach(field => {
                    field.setAttribute('required', 'required');
                });
            } else {
                doubleSection.style.display = 'none';
                // Remove required attribute
                partnerFields.forEach(field => {
                    field.removeAttribute('required');
                    field.value = ''; // Clear values
                });
            }
        }

        document.getElementById('committee_preference_1').addEventListener('change', checkDoubleDelegate);
        document.getElementById('committee_preference_2').addEventListener('change', checkDoubleDelegate);
        document.getElementById('committee_preference_3').addEventListener('change', checkDoubleDelegate);

        // Add delegation member fields
        document.getElementById('addMemberBtn').addEventListener('click', function() {
            // Maximum 9 members limit
            const currentMembers = document.querySelectorAll('.delegation-member').length;
            if (currentMembers >= 9) {
                alert('Maximum 9 delegation members allowed.');
                return;
            }
            
            memberCount++;
            const container = document.getElementById('delegationMembersContainer');
            const memberHTML = `
                <div class="card mb-3 delegation-member" id="member-${memberCount}">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: #1a1a1a;">
                        <span><i class="fas fa-user me-2"></i>Delegate ${memberCount}</span>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeMember(${memberCount})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label small">Full Name *</label>
                                <input type="text" class="form-control form-control-sm" name="member_name[]" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label small">Email *</label>
                                <input type="email" class="form-control form-control-sm" name="member_email[]" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label small">Phone Number *</label>
                                <input type="tel" class="form-control form-control-sm" name="member_phone[]" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label small">CNIC / B-Form</label>
                                <input type="text" class="form-control form-control-sm" name="member_cnic[]">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class="form-label small">Committee Preference *</label>
                                <select class="form-select form-select-sm" name="member_committee[]" required>
                                    <option value="">Select committee</option>
                                    <option value="UNSC">UNSC</option>
                                    <option value="UNCSTD">UNCSTD</option>
                                    <option value="UNWOMEN">UNWOMEN</option>
                                    <option value="DISEC">DISEC</option>
                                    <option value="SPECPOL">SPECPOL</option>
                                    <option value="SOCHUM">SOCHUM</option>
                                    <option value="KCC">KCC</option>
                                    <option value="PNA">PNA</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label class="form-label small">Previous MUN Experience</label>
                                <textarea class="form-control form-control-sm" name="member_experience[]" rows="2" placeholder="Previous MUN experience (if any)"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', memberHTML);
            updateMemberCount();
            
            // Disable button if max reached
            if (currentMembers + 1 >= 9) {
                this.disabled = true;
            }
        });

        // Remove delegation member
        function removeMember(id) {
            document.getElementById('member-' + id).remove();
            updateMemberCount();
            
            // Re-enable add button if below max
            const currentMembers = document.querySelectorAll('.delegation-member').length;
            if (currentMembers < 9) {
                document.getElementById('addMemberBtn').disabled = false;
            }
        }
        
        // Update member count display
        function updateMemberCount() {
            const count = document.querySelectorAll('.delegation-member').length;
            const countElement = document.getElementById('memberCount');
            if (countElement) {
                countElement.textContent = count;
            }
        }

        // Real-time CNIC formatting (XXXXX-XXXXXXX-X)
        function formatCNIC(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            
            if (value.length > 13) {
                value = value.substring(0, 13);
            }
            
            let formatted = '';
            if (value.length > 0) {
                formatted = value.substring(0, 5);
                if (value.length > 5) {
                    formatted += '-' + value.substring(5, 12);
                    if (value.length > 12) {
                        formatted += '-' + value.substring(12, 13);
                    }
                }
            }
            
            input.value = formatted;
        }

        document.getElementById('cnic_number').addEventListener('input', function(e) {
            formatCNIC(e.target);
        });

        // Partner CNIC formatting
        const partnerCNIC = document.getElementById('partner_cnic');
        if(partnerCNIC) {
            partnerCNIC.addEventListener('input', function(e) {
                formatCNIC(e.target);
            });
        }

        // Real-time phone number formatting (03XX-XXXXXXX or +92XXX-XXXXXXX)
        function formatPhone(input) {
            let value = input.value.replace(/[^0-9+]/g, '');
            
            // Handle +92 format
            if (value.startsWith('+92')) {
                value = value.substring(0, 13); // +92 + 10 digits
                let formatted = '+92';
                const digits = value.substring(3);
                if (digits.length > 0) {
                    formatted += digits.substring(0, 3);
                    if (digits.length > 3) {
                        formatted += '-' + digits.substring(3, 10);
                    }
                }
                input.value = formatted;
            }
            // Handle 0 format
            else if (value.startsWith('0')) {
                value = value.substring(0, 11); // 0 + 10 digits
                let formatted = value.substring(0, 4);
                if (value.length > 4) {
                    formatted += '-' + value.substring(4, 11);
                }
                input.value = formatted;
            }
            else {
                input.value = value.substring(0, 11);
            }
        }

        document.getElementById('phone_number').addEventListener('input', function(e) {
            formatPhone(e.target);
        });

        document.getElementById('whatsapp_number').addEventListener('input', function(e) {
            formatPhone(e.target);
        });

        // Partner phone formatting
        const partnerPhone = document.getElementById('partner_phone');
        if(partnerPhone) {
            partnerPhone.addEventListener('input', function(e) {
                formatPhone(e.target);
            });
        }

        // Payment screenshot preview
        document.getElementById('payment_screenshot').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('screenshot_preview');
            
            if (file) {
                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
                    this.value = '';
                    preview.innerHTML = '';
                    return;
                }
                
                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please upload an image file');
                    this.value = '';
                    preview.innerHTML = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="card" style="max-width: 300px;">
                            <img src="${e.target.result}" class="card-img-top" alt="Payment Screenshot">
                            <div class="card-body">
                                <p class="card-text small text-success"><i class="fas fa-check-circle me-1"></i>Screenshot uploaded successfully</p>
                            </div>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });

        // Enable disabled fields before form submission
        document.getElementById('delegateForm').addEventListener('submit', function(e) {
            // Enable education_level if disabled (for NED students)
            const educationField = document.getElementById('education_level');
            if (educationField.disabled) {
                educationField.disabled = false;
            }
            
            // Enable institution_name if readonly (for NED students)
            const institutionField = document.getElementById('institution_name');
            if (institutionField.readOnly) {
                institutionField.readOnly = false;
            }
        });

        // Custom radio card styling
        document.querySelectorAll('.custom-radio-card input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove active class from all labels in the same group
                const groupName = this.name;
                document.querySelectorAll(`input[name="${groupName}"]`).forEach(r => {
                    r.parentElement.querySelector('label').classList.remove('border-primary', 'bg-light');
                });
                // Add active class to selected label
                if (this.checked) {
                    this.parentElement.querySelector('label').classList.add('border-primary', 'bg-light');
                }
            });
        });
    </script>
</body>
</html>
