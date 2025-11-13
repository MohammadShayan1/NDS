<?php
require_once 'config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo META_DESCRIPTION; ?>">
    <meta name="keywords" content="<?php echo META_KEYWORDS; ?>">
    <title><?php echo SITE_NAME; ?></title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --text: #333;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: var(--text);
        }

        /* Header/Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.3;
        }

        .navbar {
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 10;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        .nav-links {
            display: none;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .nav-links a:hover {
            opacity: 0.8;
        }

        .mobile-menu-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            display: block;
        }

        .hero-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem 1rem;
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            opacity: 0.95;
        }

        .hero-date {
            font-size: 1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            width: 100%;
            max-width: 400px;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: white;
            color: var(--primary);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline:hover {
            background: white;
            color: var(--primary);
        }

        /* Alert Section */
        .alert {
            padding: 1rem;
            margin: 1rem;
            border-radius: 8px;
            text-align: center;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
        }

        /* Features Section */
        .features {
            padding: 3rem 1rem;
            background: var(--light);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 3rem;
            color: var(--dark);
        }

        .features-grid {
            display: grid;
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .feature-title {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }

        .feature-text {
            color: #666;
            line-height: 1.8;
        }

        /* Stats Section */
        .stats {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 3rem 1rem;
        }

        .stats-grid {
            display: grid;
            gap: 2rem;
            text-align: center;
        }

        .stat-item {
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* About Section */
        .about {
            padding: 3rem 1rem;
            background: white;
        }

        .about-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .about-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #666;
            margin-bottom: 2rem;
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: white;
            padding: 2rem 1rem;
            text-align: center;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .social-links a {
            color: white;
            font-size: 1.5rem;
            transition: opacity 0.3s;
        }

        .social-links a:hover {
            opacity: 0.7;
        }

        .footer-text {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 0.5rem;
        }

        .tech-partner {
            font-size: 0.85rem;
            opacity: 0.7;
        }

        .tech-partner a {
            color: var(--primary);
            text-decoration: none;
        }

        /* Tablet */
        @media (min-width: 768px) {
            .nav-links {
                display: flex;
            }

            .mobile-menu-btn {
                display: none;
            }

            .hero-title {
                font-size: 3.5rem;
            }

            .hero-subtitle {
                font-size: 1.3rem;
            }

            .cta-buttons {
                flex-direction: row;
                max-width: none;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Desktop */
        @media (min-width: 1024px) {
            .navbar {
                padding: 1.5rem 3rem;
            }

            .hero-content {
                padding: 3rem;
            }

            .hero-title {
                font-size: 4.5rem;
            }

            .features-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .features,
            .stats,
            .about {
                padding: 5rem 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero">
        <nav class="navbar">
            <a href="<?php echo BASE_URL; ?>" class="logo"><?php echo EVENT_NAME; ?></a>
            <div class="nav-links">
                <a href="#about">About</a>
                <a href="#features">Features</a>
                <a href="<?php echo BASE_URL; ?>register">Register</a>
                <a href="<?php echo BASE_URL; ?>admin">Admin</a>
            </div>
            <button class="mobile-menu-btn">☰</button>
        </nav>

        <?php
        $alert = getAlert();
        if ($alert):
        ?>
        <div class="alert alert-<?php echo $alert['type']; ?>">
            <?php echo $alert['message']; ?>
        </div>
        <?php endif; ?>

        <div class="hero-content">
            <h1 class="hero-title"><?php echo EVENT_NAME; ?></h1>
            <p class="hero-subtitle">NED Debating Society presents</p>
            <p class="hero-date">📅 <?php echo EVENT_DATE; ?></p>
            <p class="hero-date">📍 <?php echo EVENT_VENUE; ?></p>
            
            <div class="cta-buttons">
                <a href="<?php echo BASE_URL; ?>register" class="btn btn-primary">Register Now</a>
                <a href="#about" class="btn btn-outline">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">500+</span>
                    <span class="stat-label">Expected Delegates</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">10+</span>
                    <span class="stat-label">Committees</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">3</span>
                    <span class="stat-label">Days</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">50+</span>
                    <span class="stat-label">Universities</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="section-title">Why Attend NEDMUN-VI?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3 class="feature-title">Professional Experience</h3>
                    <p class="feature-text">Gain valuable diplomatic and negotiation skills while engaging with global issues in a professional setting.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🌍</div>
                    <h3 class="feature-title">Global Perspective</h3>
                    <p class="feature-text">Discuss pressing international issues and develop a deeper understanding of world affairs.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🤝</div>
                    <h3 class="feature-title">Networking</h3>
                    <p class="feature-text">Connect with students from universities across Pakistan and build lasting professional relationships.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🏆</div>
                    <h3 class="feature-title">Recognition</h3>
                    <p class="feature-text">Compete for prestigious awards and certificates that recognize outstanding performance.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💡</div>
                    <h3 class="feature-title">Skill Development</h3>
                    <p class="feature-text">Enhance your public speaking, critical thinking, and leadership abilities.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎓</div>
                    <h3 class="feature-title">Learning Opportunity</h3>
                    <p class="feature-text">Participate in workshops and training sessions led by experienced diplomats and MUN veterans.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <h2 class="section-title">About NEDMUN</h2>
            <div class="about-content">
                <p class="about-text">
                    NEDMUN (NED Model United Nations) is one of Karachi's largest and most prestigious MUN conferences, 
                    organized annually by the NED Debating Society. This year marks our sixth edition, bringing together 
                    hundreds of students from across Pakistan to simulate UN committees and engage in diplomatic discourse.
                </p>
                <p class="about-text">
                    Whether you're a seasoned delegate or a first-time participant, NEDMUN-VI offers an unparalleled 
                    platform to develop your skills, expand your network, and make a lasting impact. Join us for three 
                    days of intense debate, cultural exchange, and personal growth.
                </p>
                <a href="<?php echo BASE_URL; ?>register" class="btn btn-primary">Register for NEDMUN-VI</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="social-links">
                <a href="<?php echo FACEBOOK_URL; ?>" target="_blank" aria-label="Facebook">📘</a>
                <a href="<?php echo INSTAGRAM_URL; ?>" target="_blank" aria-label="Instagram">📷</a>
            </div>
            <p class="footer-text">&copy; <?php echo date('Y'); ?> NED Debating Society. All rights reserved.</p>
            <p class="tech-partner">
                Developed by <a href="<?php echo TECH_PARTNER_URL; ?>" target="_blank"><?php echo TECH_PARTNER_NAME; ?></a>
            </p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Mobile menu toggle (if needed in future)
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                // Add mobile menu functionality if needed
                alert('Mobile menu - implement dropdown navigation');
            });
        }
    </script>
</body>
</html>
