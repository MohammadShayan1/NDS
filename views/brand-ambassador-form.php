<?php
require_once '../config/config.php';
$alert = getAlert();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Ambassador Application - <?php echo SITE_NAME; ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Apply to become a NEDMUN-VI Brand Ambassador. Help us promote Karachi's largest MUN and enjoy exclusive benefits including certificates, recognition, and more!">
    <meta name="keywords" content="NEDMUN Brand Ambassador, MUN Ambassador, Student Ambassador, NEDMUN-VI, NED Debating Society">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                <i class="fas fa-arrow-left me-2"></i>Back to Home
            </a>
        </div>
    </nav>

    <!-- Form Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <?php if ($alert): ?>
                    <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                        <?php echo $alert['message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <div class="card shadow-lg">
                        <div class="card-header bg-warning text-dark text-center py-4">
                            <h1 class="h3 mb-2"><i class="fas fa-star me-2"></i>NEDMUN-VI BRAND AMBASSADOR</h1>
                            <p class="mb-0">Get Ready For The NEDMUN-VI!</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="alert alert-info">
                                <h5><i class="fas fa-info-circle me-2"></i>About the Program</h5>
                                <p class="mb-2">We are thrilled to invite passionate and committed individuals to join us as Brand Ambassadors for Karachi's largest MUN! As a Brand Ambassador, you will play a pivotal role in helping us expand our reach and promote this exciting event to a broader audience!</p>
                                
                                <h6 class="mt-3 mb-2">Event Details:</h6>
                                <ul class="mb-2">
                                    <li><strong>Dates:</strong> <?php echo EVENT_DATE; ?></li>
                                    <li><strong>Venue:</strong> <?php echo EVENT_VENUE; ?></li>
                                </ul>

                                <h6 class="mt-3 mb-2">You are required to:</h6>
                                <ul class="mb-2">
                                    <li>Actively promote NEDMUN within your community, school, and on social media</li>
                                    <li>Encourage registrations and engagement by sharing event updates, posters, and promotional materials</li>
                                </ul>

                                <h6 class="mt-3 mb-2">Benefits to Brand Ambassadors:</h6>
                                <ul class="mb-0">
                                    <li>Recognition on social media</li>
                                    <li>Certificate of Appreciation</li>
                                    <li>Letter of Recommendation</li>
                                    <li>Commemorative Shield</li>
                                    <li>A chance to attend the conference for free</li>
                                </ul>
                            </div>

                            <div class="alert alert-warning">
                                <strong><i class="fas fa-exclamation-triangle me-2"></i>PLEASE READ CAREFULLY:</strong>
                                We will be shortlisting candidates and sending out confirmation emails to officially appoint them as Brand Ambassadors.
                            </div>

                            <form action="<?php echo BASE_URL; ?>brand-ambassador?action=submit" method="POST" id="baForm">
                                <div class="mb-4">
                                    <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                                </div>

                                <div class="mb-4">
                                    <label for="whatsapp_number" class="form-label">WhatsApp Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="whatsapp_number" name="whatsapp_number" placeholder="+92 XXX XXXXXXX" required>
                                </div>

                                <div class="mb-4">
                                    <label for="cnic_number" class="form-label">CNIC Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cnic_number" name="cnic_number" placeholder="XXXXX-XXXXXXX-X" required>
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <div class="mb-4">
                                    <label for="institution" class="form-label">Institution <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="institution" name="institution" required>
                                </div>

                                <div class="mb-4">
                                    <label for="education_level" class="form-label">Year/Grade Level <span class="text-danger">*</span></label>
                                    <select class="form-select" id="education_level" name="education_level" required>
                                        <option value="">Select your level</option>
                                        <option value="Middle school">Middle school</option>
                                        <option value="O Levels/ Secondary School">O Levels / Secondary School</option>
                                        <option value="A Levels / Higher Secondary School">A Levels / Higher Secondary School</option>
                                        <option value="Undergraduate">Undergraduate</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="prior_experience" class="form-label">Prior Brand Ambassador Experience (Max: 200 Words) <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="prior_experience" name="prior_experience" rows="5" maxlength="1000" required></textarea>
                                    <small class="form-text text-muted">Please describe any previous experience as a brand ambassador or in promotional roles.</small>
                                </div>

                                <div class="mb-4">
                                    <label for="delegates_count" class="form-label">How many delegates can you bring to NEDMUN-VI? <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="delegates_count" name="delegates_count" placeholder="e.g., 10-15 delegates" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Can you help in conducting PR drive in your Institute? <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pr_drive" id="pr_yes" value="Yes" required>
                                        <label class="form-check-label" for="pr_yes">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pr_drive" id="pr_no" value="No" required>
                                        <label class="form-check-label" for="pr_no">No</label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-warning btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>Submit Application
                                    </button>
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
                        <img src="<?php echo BASE_URL; ?>assets/images/NEDMUN_LOGO_PNG.png" alt="NEDMUN-VI" class="img-fluid" style="max-width: 120px;">
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
                    <p class="mb-0 text-muted small">
                        Developed by <a href="https://telinks.org/team-technical" target="_blank" class="text-decoration-none" style="color: #d4af37; font-weight: 500;">
                            <i class="fas fa-code me-1"></i>TE Links Technical Team
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        document.getElementById('baForm').addEventListener('submit', function(e) {
            const experience = document.getElementById('prior_experience').value;
            const wordCount = experience.trim().split(/\s+/).length;
            
            if (wordCount > 200) {
                e.preventDefault();
                alert('Prior experience should not exceed 200 words. Current count: ' + wordCount);
            }
        });

        // CNIC format validation
        document.getElementById('cnic_number').addEventListener('blur', function() {
            const cnic = this.value.replace(/[^0-9]/g, '');
            if (cnic.length === 13) {
                this.value = cnic.substring(0,5) + '-' + cnic.substring(5,12) + '-' + cnic.substring(12);
            }
        });
    </script>
</body>
</html>
