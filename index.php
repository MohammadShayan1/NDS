<?php
require_once 'config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#000000">
    <title>Thank You - NEDMUN-VI</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/NEDMUN.webp">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #000000;
            --secondary-color: #DAA520;
            --text-light: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .thank-you-container {
            text-align: center;
            padding: 20px;
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100vh;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .logo-item {
            animation: fadeInUp 1s ease-out;
        }
        
        .logo-item img {
            max-width: 180px;
            height: auto;
            filter: drop-shadow(0 10px 20px rgba(218, 165, 32, 0.3));
            transition: transform 0.3s ease;
        }
        
        .logo-item img:hover {
            transform: scale(1.05);
        }
        
        .logo-separator {
            width: 3px;
            height: 80px;
            background: var(--secondary-color);
            animation: fadeIn 1.5s ease-out;
        }
        
        .thank-you-text {
            animation: fadeInUp 1.2s ease-out;
            margin-bottom: 20px;
        }
        
        .thank-you-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 900;
            color: var(--secondary-color);
            margin-bottom: 15px;
            text-shadow: 0 5px 15px rgba(218, 165, 32, 0.3);
        }
        
        .thank-you-text h2 {
            font-size: 1.5rem;
            color: var(--text-light);
            font-weight: 300;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        
        .tagline {
            font-style: italic;
            color: var(--secondary-color);
            font-size: 1.1rem;
            margin-bottom: 0;
            animation: fadeInUp 1.4s ease-out;
        }
        
        .footer-logo {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid rgba(218, 165, 32, 0.3);
            animation: fadeInUp 1.6s ease-out;
        }
        
        .footer-logo p {
            color: #999;
            font-size: 0.85rem;
            margin-bottom: 10px;
        }
        
        .telinks-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--secondary-color);
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .telinks-logo:hover {
            color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .telinks-logo img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            filter: brightness(0) saturate(100%) invert(60%) sepia(80%) saturate(500%) hue-rotate(10deg) brightness(95%) contrast(90%);
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .thank-you-container {
                padding: 15px;
            }
            
            .thank-you-text h1 {
                font-size: 2.2rem;
                margin-bottom: 12px;
            }
            
            .thank-you-text h2 {
                font-size: 1.2rem;
                margin-bottom: 15px;
            }
            
            .logo-container {
                gap: 20px;
                margin-bottom: 25px;
            }
            
            .logo-separator {
                height: 60px;
            }
            
            .logo-item img {
                max-width: 120px;
            }
            
            .tagline {
                font-size: 0.95rem;
            }
            
            .footer-logo {
                margin-top: 25px;
                padding-top: 25px;
            }
            
            .footer-logo p {
                font-size: 0.8rem;
                margin-bottom: 8px;
            }
        }
        
        @media (max-width: 480px) {
            .thank-you-text h1 {
                font-size: 1.8rem;
                margin-bottom: 10px;
            }
            
            .thank-you-text h2 {
                font-size: 1rem;
                margin-bottom: 12px;
            }
            
            .logo-item img {
                max-width: 100px;
            }
            
            .logo-separator {
                height: 50px;
            }
            
            .tagline {
                font-size: 0.9rem;
            }
            
            .telinks-logo {
                font-size: 0.9rem;
            }
            
            .telinks-logo img {
                width: 30px;
                height: 30px;
            }
        }
        
        @media (max-height: 600px) {
            .logo-item img {
                max-width: 100px;
            }
            
            .logo-separator {
                height: 50px;
            }
            
            .thank-you-text h1 {
                font-size: 2rem;
                margin-bottom: 10px;
            }
            
            .thank-you-text h2 {
                font-size: 1.2rem;
                margin-bottom: 10px;
            }
            
            .tagline {
                font-size: 0.9rem;
            }
            
            .footer-logo {
                margin-top: 20px;
                padding-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <!-- Logos Section -->
        <div class="logo-container">
            <div class="logo-item">
                <img src="<?php echo BASE_URL; ?>assets/images/NEDMUN.webp" alt="NEDMUN Logo">
            </div>
            <div class="logo-separator"></div>
            <div class="logo-item">
                <img src="<?php echo BASE_URL; ?>assets/images/nds-logo.png" alt="NED Debating Society Logo">
            </div>
        </div>
        
        <!-- Thank You Message -->
        <div class="thank-you-text">
            <h1>Thank You For Joining Us!</h1>
            <h2>NEDMUN-VI has concluded successfully</h2>
            <p class="tagline">"Noting the Past, Navigating the Present, Nurturing the Future"</p>
        </div>
        
        <!-- Footer with Telinks Logo -->
        <div class="footer-logo">
            <p>Website Developed By</p>
            <a href="https://telinks.org/team-technical" target="_blank" class="telinks-logo">
                <img src="<?php echo BASE_URL; ?>assets/images/telinkslogoblwh.png" alt="TE Links Logo">
                <span>TE Links Technical Team</span>
            </a>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
