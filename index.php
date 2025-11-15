<?php
require_once 'config/config.php';

// Get site settings
$delegateFee = getSetting('delegate_fee', '3000');
$delegationFee = getSetting('delegation_fee', '2500');
$earlyBirdDiscount = getSetting('early_bird_discount', '500');
$earlyBirdDeadline = getSetting('early_bird_deadline', date('Y-m-d'));
$delegateCardTitle = getSetting('delegate_card_title', 'Delegate Registration');
$delegateCardDesc = getSetting('delegate_card_description', 'Register as an individual delegate or delegation for NEDMUN-VI');
$baCardTitle = getSetting('ba_card_title', 'Brand Ambassador');
$baCardDesc = getSetting('ba_card_description', 'Become a Brand Ambassador and represent NEDMUN-VI at your institution');

// Calculate prices
$earlyDelegateFee = $delegateFee - $earlyBirdDiscount;
$earlyDelegationFee = $delegationFee - $earlyBirdDiscount;

// Format deadline
$deadlineFormatted = date('jS M', strtotime($earlyBirdDeadline));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#000000">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title><?php echo SITE_NAME; ?> - Karachi's Largest Model United Nations</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo META_DESCRIPTION; ?>">
    <meta name="keywords" content="<?php echo META_KEYWORDS; ?>">
    <meta name="author" content="NED Debating Society">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="NEDMUN-VI - Karachi's Largest MUN Conference">
    <meta property="og:description" content="<?php echo META_DESCRIPTION; ?>">
    <meta property="og:image" content="<?php echo BASE_URL; ?>assets/images/nedmun-og-image.jpg">
    <meta property="og:url" content="<?php echo BASE_URL; ?>">
    <meta property="og:type" content="website">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="NEDMUN-VI - Karachi's Largest MUN Conference">
    <meta name="twitter:description" content="<?php echo META_DESCRIPTION; ?>">
    <meta name="twitter:image" content="<?php echo BASE_URL; ?>assets/images/nedmun-twitter-card.jpg">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/favicon.png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    
    <!-- Structured Data for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Event",
        "name": "NEDMUN-VI",
        "description": "Karachi's largest Model United Nations conference",
        "startDate": "2026-01-02",
        "endDate": "2026-01-04",
        "eventStatus": "https://schema.org/EventScheduled",
        "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
        "location": {
            "@type": "Place",
            "name": "NED University of Engineering and Technology",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "University Road",
                "addressLocality": "Karachi",
                "addressRegion": "Sindh",
                "addressCountry": "Pakistan"
            }
        },
        "organizer": {
            "@type": "Organization",
            "name": "NED Debating Society",
            "url": "<?php echo BASE_URL; ?>"
        }
    }
    </script>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo BASE_URL; ?>">
                <img src="<?php echo BASE_URL; ?>assets/images/nds-logo.png" alt="NED Debating Society Logo" class="nds-logo me-2">
                <div class="logo-separator"></div>
                <img src="<?php echo BASE_URL; ?>assets/images/NEDMUN_LOGO_PNG.webp" alt="NEDMUN-VI Logo" class="nedmun-logo ms-2">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#committees">Committees</a></li>
                    <li class="nav-item"><a class="nav-link" href="#registration">Registration</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-lg-3" href="<?php echo BASE_URL; ?>register">Register Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section" id="home">
        <div class="hero-overlay"></div>
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <div class="mb-4" data-aos="zoom-in">
                        <img src="<?php echo BASE_URL; ?>assets/images/NEDMUN_LOGO_PNG.webp" alt="NEDMUN-VI" class="img-fluid" style="max-width: 400px;">
                    </div>
                    <span class="badge bg-warning text-dark mb-3 early-bird-badge" data-aos="fade-down">
                        <i class="fas fa-clock"></i> Early Bird Registration Valid till 15th November
                    </span>
                    <p class="lead mb-2 tagline" data-aos="fade-up" style="color: var(--secondary-color); font-style: italic; font-size: 1.3rem;">
                        "Noting the Past, Navigating the Present, Nurturing the Future"
                    </p>
                    <h2 class="h3 mb-4" data-aos="fade-up" data-aos-delay="100">Karachi's Largest Model United Nations</h2>
                    <p class="mb-4" data-aos="fade-up" data-aos-delay="150" style="font-size: 1.1rem;">
                        Enhance your portfolio by participating in Karachi's largest Model United Nations Conference
                    </p>
                    <div class="event-details mb-5" data-aos="fade-up" data-aos-delay="200">
                        <p class="lead mb-2">
                            <i class="fas fa-calendar-alt me-2"></i><?php echo EVENT_DATE; ?>
                        </p>
                        <p class="lead">
                            <i class="fas fa-map-marker-alt me-2"></i><?php echo EVENT_VENUE; ?>
                        </p>
                    </div>
                    <!-- <div class="cta-buttons" data-aos="fade-up" data-aos-delay="300">
                        <a href="<?php echo BASE_URL; ?>register" class="btn btn-lg btn-primary me-3 mb-3">
                            <i class="fas fa-user-plus me-2"></i>Register as Delegate
                        </a>
                        <a href="<?php echo BASE_URL; ?>brand-ambassador" class="btn btn-lg btn-outline-light mb-3">
                            <i class="fas fa-star me-2"></i>Become Brand Ambassador
                        </a> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <a href="#about"><i class="fas fa-chevron-down"></i></a>
        </div>
    </header>

    <!-- About Section -->
    <section class="py-5 bg-light" id="about">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <div class="about-logos d-flex align-items-center justify-content-center justify-content-lg-start mb-4">
                        <img src="<?php echo BASE_URL; ?>assets/images/nds-logo.png" alt="NED Debating Society" class="img-fluid me-3" style="max-width: 200px;">
                        <div class="mx-3" style="width: 2px; height: 80px; background: var(--secondary-color);"></div>
                        <img src="<?php echo BASE_URL; ?>assets/images/NEDMUN_LOGO_PNG.webp" alt="NEDMUN-VI" class="img-fluid" style="max-width: 200px;">
                    </div>
                    <h2 class="section-title mb-4">About NEDMUN-VI</h2>
                    <p class="lead mb-4">Welcome to the sixth edition of NED Model United Nations - Karachi's premier platform for youth diplomacy and international relations!</p>
                    <p>Organized by the <strong style="color: var(--secondary-color);">NED Debating Society (NDS)</strong>, NEDMUN-VI brings together bright minds from across Pakistan to engage in meaningful diplomatic discourse, develop leadership skills, and address global challenges.</p>
                    <p>Join us for three days of intensive debate, networking, and personal growth as we simulate the workings of the United Nations and tackle pressing international issues.</p>
                    <div class="stats-row mt-5">
                        <div class="row text-center">
                            <div class="col-4">
                                <h3 class="display-4 text-primary fw-bold">500+</h3>
                                <p>Delegates Expected</p>
                            </div>
                            <div class="col-4">
                                <h3 class="display-4 text-primary fw-bold">8</h3>
                                <p>Committees</p>
                            </div>
                            <div class="col-4">
                                <h3 class="display-4 text-primary fw-bold">3</h3>
                                <p>Days of Conference</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <img src="<?php echo BASE_URL; ?>assets/images/audi.png" alt="NEDMUN Conference" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Committees Section -->
    <section class="py-5" id="committees">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Our Committees</h2>
                <p class="lead text-muted">8 Diverse committees covering critical global and national issues</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="committee-card card h-100">
                        <div class="card-body">
                            <div class="committee-icon mb-3">
                                <img src="<?php echo BASE_URL; ?>assets/images/UNSC.png" alt="UNSC Logo" style="width: 80px; height: 80px; object-fit: contain;">
                            </div>
                            <h5 class="card-title">UNSC</h5>
                            <p class="card-text small"><strong>United Nations Security Council</strong></p>
                            <span class="badge bg-warning text-dark">Double Delegate</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="150">
                    <div class="committee-card card h-100">
                        <div class="card-body">
                            <div class="committee-icon mb-3">
                                <img src="<?php echo BASE_URL; ?>assets/images/UNCSTD.png" alt="UNCSTD Logo" style="width: 80px; height: 80px; object-fit: contain;">
                            </div>
                            <h5 class="card-title">UNCSTD</h5>
                            <p class="card-text small"><strong>UN Commission on Science and Technology for Development</strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="committee-card card h-100">
                        <div class="card-body">
                            <div class="committee-icon mb-3">
                                <img src="<?php echo BASE_URL; ?>assets/images/UNWOMEN.png" alt="UNWOMEN Logo" style="width: 80px; height: 80px; object-fit: contain;">
                            </div>
                            <h5 class="card-title">UNWOMEN</h5>
                            <p class="card-text small"><strong>UN Entity for Gender Equality and the Empowerment of Women</strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="250">
                    <div class="committee-card card h-100">
                        <div class="card-body">
                            <div class="committee-icon mb-3">
                                <img src="<?php echo BASE_URL; ?>assets/images/DISEC.png" alt="DISEC Logo" style="width: 80px; height: 80px; object-fit: contain;">
                            </div>
                            <h5 class="card-title">DISEC</h5>
                            <p class="card-text small"><strong>Disarmament and International Security Committee</strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="committee-card card h-100">
                        <div class="card-body">
                            <div class="committee-icon mb-3">
                                <img src="<?php echo BASE_URL; ?>assets/images/SPECPOL.png" alt="SPECPOL Logo" style="width: 80px; height: 80px; object-fit: contain;">
                            </div>
                            <h5 class="card-title">SPECPOL</h5>
                            <p class="card-text small"><strong>Special Political and Decolonization Committee</strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="350">
                    <div class="committee-card card h-100">
                        <div class="card-body">
                            <div class="committee-icon mb-3">
                                <img src="<?php echo BASE_URL; ?>assets/images/SOCHUM.png" alt="SOCHUM Logo" style="width: 80px; height: 80px; object-fit: contain;">
                            </div>
                            <h5 class="card-title">SOCHUM</h5>
                            <p class="card-text small"><strong>Social, Humanitarian, and Cultural Committee</strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="committee-card card h-100">
                        <div class="card-body">
                            <div class="committee-icon mb-3">
                                <img src="<?php echo BASE_URL; ?>assets/images/KCC.png" alt="KCC Logo" style="width: 80px; height: 80px; object-fit: contain;">
                            </div>
                            <h5 class="card-title">KCC</h5>
                            <p class="card-text small"><strong>Karachi Crisis Committee</strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="450">
                    <div class="committee-card card h-100">
                        <div class="card-body">
                            <div class="committee-icon mb-3">
                                <img src="<?php echo BASE_URL; ?>assets/images/PNA.png" alt="PNA Logo" style="width: 80px; height: 80px; object-fit: contain;">
                            </div>
                            <h5 class="card-title">PNA</h5>
                            <p class="card-text small"><strong>Pakistan National Assembly</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Options Section -->
    <section class="py-5 bg-light" id="registration">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Join NEDMUN-VI</h2>
                <p class="lead text-muted">Choose your path to participate</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="registration-card card h-100 border-primary">
                        <div class="card-header bg-primary text-white text-center">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <h3><?php echo htmlspecialchars($delegateCardTitle); ?></h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text mb-4"><?php echo htmlspecialchars($delegateCardDesc); ?></p>
                            
                            <h5 class="mb-3" style="color: var(--secondary-color);">REGISTRATION FEES</h5>
                            <div class="pricing-info mb-3 p-3" style="background: #1a1a1a; border-left: 3px solid var(--secondary-color);">
                                <p class="mb-1"><strong>Early Bird (Till <?php echo $deadlineFormatted; ?>):</strong></p>
                                <p class="mb-1 ms-3">• Individual Delegate: PKR <?php echo number_format($earlyDelegateFee); ?></p>
                                <p class="mb-3 ms-3">• Delegation (per member): PKR <?php echo number_format($earlyDelegationFee); ?></p>
                                <p class="mb-1"><strong>Regular Phase:</strong></p>
                                <p class="mb-1 ms-3">• Individual Delegate: PKR <?php echo number_format($delegateFee); ?></p>
                                <p class="mb-0 ms-3">• Delegation (per member): PKR <?php echo number_format($delegationFee); ?></p>
                            </div>
                            
                            <div class="alert alert-warning mb-4" style="font-size: 0.9rem;">
                                <i class="fas fa-users me-2"></i><strong>Note:</strong> Each delegation must consist of minimum 9 delegates
                            </div>
                            
                            <a href="<?php echo BASE_URL; ?>register" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-user-plus me-2"></i>Register Now
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="registration-card card h-100 border-warning">
                        <div class="card-header bg-warning text-dark text-center">
                            <i class="fas fa-star fa-3x mb-3"></i>
                            <h3><?php echo htmlspecialchars($baCardTitle); ?></h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text mb-4"><?php echo htmlspecialchars($baCardDesc); ?></p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Social Media Recognition</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Certificate of Appreciation</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Letter of Recommendation</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Commemorative Shield</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Free Conference Attendance (for selected BAs)</li>
                            </ul>
                            <a href="<?php echo BASE_URL; ?>brand-ambassador" class="btn btn-warning btn-lg w-100">
                                <i class="fas fa-star me-2"></i>Become Brand Ambassador
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5" id="contact">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Get In Touch</h2>
                <p class="lead text-muted">Have questions? We're here to help!</p>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4" data-aos="fade-right">
                    <div class="contact-info">
                        <h4 class="mb-4">Contact Information</h4>
                        <div class="contact-item mb-3">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <span>nedmunofficial@gmail.com</span>
                        </div>
                        <div class="contact-item mb-3">
                            <i class="fas fa-phone text-primary me-3"></i>
                            <div>
                                <p class="mb-1">Directorate General: 0324-3343946</p>
                                <p class="mb-0">Deputy Secretary General: 0333-3772513</p>
                            </div>
                        </div>
                        <div class="contact-item mb-3">
                            <i class="fas fa-map-marker-alt text-primary me-3"></i>
                            <span><?php echo EVENT_VENUE; ?></span>
                        </div>
                        <div class="social-links mt-4">
                            <h5 class="mb-3">Follow Us</h5>
                            <a href="<?php echo FACEBOOK_URL; ?>" target="_blank" class="social-icon">
                                <i class="fab fa-facebook fa-2x"></i>
                            </a>
                            <a href="<?php echo INSTAGRAM_URL; ?>" target="_blank" class="social-icon">
                                <i class="fab fa-instagram fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7235.9697956697355!2d67.10825628877602!3d24.932584390522308!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb338bf22becb0f%3A0xd5e50842c5c4867b!2sNED%20University%20Of%20Engineering%20%26%20Technology%2C%20Karachi%2C%20Pakistan!5e0!3m2!1sen!2s!4v1762890726262!5m2!1sen!2s" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?php echo BASE_URL; ?>assets/images/nds-logo.png" alt="NED Debating Society" class="img-fluid me-2" style="max-width: 150px;">
                        <div style="width: 2px; height: 50px; background: var(--secondary-color); margin: 0 8px;"></div>
                        <img src="<?php echo BASE_URL; ?>assets/images/NEDMUN_LOGO_PNG.webp" alt="NEDMUN-VI" class="img-fluid" style="max-width: 150px;">
                    </div>
                    <p class="text-muted">Empowering youth through debate, diplomacy, and leadership since its inception.</p>
                </div>
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="mb-3" style="color: var(--secondary-color);">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#about" class="text-muted text-decoration-none">About NEDMUN</a></li>
                        <li><a href="#committees" class="text-muted text-decoration-none">Committees</a></li>
                        <li><a href="<?php echo BASE_URL; ?>register" class="text-muted text-decoration-none">Register</a></li>
                        <li><a href="#contact" class="text-muted text-decoration-none">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="mb-3" style="color: var(--secondary-color);">Organized By</h5>
                    <p><strong>NED Debating Society (NDS)</strong></p>
                    <p class="text-muted small">NED University of Engineering & Technology, Karachi</p>
                </div>
            </div>
            <hr style="border-color: var(--secondary-color); opacity: 0.3;" class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0 text-muted">&copy; <?php echo date('Y'); ?> NED Debating Society. All rights reserved.</p>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Custom JS -->
    <script src="<?php echo BASE_URL; ?>assets/js/main.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>
</html>
