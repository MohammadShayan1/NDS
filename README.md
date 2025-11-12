# NEDMUN-VI Registration System

A complete Model-View-Controller (MVC) based web application for managing NEDMUN-VI (NED Model United Nations) conference registrations, built with core PHP and MySQL.

## 🎯 Features

### Public Features
- **Responsive Homepage** with event information and SEO optimization
- **Delegate Registration** - Individual and delegation registrations with committee preferences
- **Brand Ambassador Program** - Application system with benefits tracking
- **NED & External Institutions** - Separate registration flows
- **Email Confirmations** - Automated emails for registrations and assignments
- **Committee Assignment** - Admin can assign committees and send acceptance emails
- **Mobile-Friendly Design** - Fully responsive black & gold theme

### Admin Panel Features
- **Modern Dashboard** - Real-time statistics with black & gold theme
- **1-Hour Session Timeout** - Enhanced security with live countdown timer
- **Delegate Management** - View, assign committees, approve/reject registrations
- **Delegation Member Management** - View and assign committees to individual members
- **Brand Ambassador Management** - Review and manage BA applications
- **Status Tracking** - Payment status, confirmation status
- **Data Export** - CSV export functionality
- **Secure Authentication** - Bcrypt password hashing

## 🏗️ Architecture

### MVC Structure
```
NDS/
├── config/              # Configuration files
│   ├── config.php       # App configuration
│   ├── database.php     # Database connection (git-ignored)
│   ├── email.php        # Email functions (git-ignored)
│   ├── database.php.example  # Template for database config
│   └── email.php.example     # Template for email config
├── models/              # Data models
│   ├── Admin.php
│   ├── BrandAmbassador.php
│   └── DelegateRegistration.php
├── views/               # View templates
│   ├── brand-ambassador-form.php
│   └── delegate-registration-form.php
├── controllers/         # Controllers
│   ├── BrandAmbassadorController.php
│   └── DelegateController.php
├── admin/              # Admin panel
│   ├── includes/       # Reusable components
│   ├── ajax/          # AJAX endpoints
│   ├── dashboard.php
│   ├── delegates.php
│   ├── brand-ambassadors.php
│   └── login.php
├── assets/             # Static assets
│   ├── css/           # Black & gold themed styles
│   ├── js/
│   └── images/
├── database.sql        # Database schema
├── index.php          # Homepage
├── deploy.php         # Auto-deployment script for cPanel
├── .htaccess          # URL routing
└── .gitignore         # Git ignore rules
```

## 🚀 Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server with mod_rewrite enabled
- Git (for version control and auto-deployment)

### Step 1: Clone Repository
```bash
git clone https://github.com/yourusername/nedmun-vi.git
cd nedmun-vi
```

### Step 2: Database Setup
1. Create a MySQL database named `nedmun_vi`
2. Import the database schema:
   ```bash
   mysql -u root -p nedmun_vi < database.sql
   ```
   Or use phpMyAdmin to import `database.sql`

### Step 3: Configuration
1. Copy database template:
   ```bash
   cp config/database.php.example config/database.php
   ```
2. Edit `config/database.php` with your credentials
3. Copy email template:
   ```bash
   cp config/email.php.example config/email.php
   ```
4. Configure email settings in `config/email.php`
5. Update `BASE_URL` in `config/config.php`

### Step 4: Default Admin Login
- Username: `admin`
- Password: `admin123`
- **Change this immediately after first login!**

## 🔄 Auto-Deployment Setup (cPanel)

### Step 1: Configure deploy.php
1. Open `deploy.php`
2. Change `YOUR_SECRET_KEY_HERE_CHANGE_THIS` to a strong random key
3. Save the file

### Step 2: Setup Git on cPanel
```bash
# SSH into your cPanel account
cd public_html/nedmun
git init
git remote add origin https://github.com/yourusername/nedmun-vi.git
git pull origin main
```

### Step 3: Configure GitHub Webhook
1. Go to your GitHub repository settings
2. Click on "Webhooks" → "Add webhook"
3. Payload URL: `https://yourdomain.com/deploy.php?key=YOUR_SECRET_KEY`
4. Content type: `application/json`
5. Select "Just the push event"
6. Click "Add webhook"

### How It Works
- Push code to GitHub → Webhook triggers → deploy.php pulls latest code → Website updates automatically
- Check `deployment.log` for deployment history

## 📊 Database Schema

### Tables
- **admins** - Admin user accounts with bcrypt passwords
- **brand_ambassadors** - BA applications
- **delegate_registrations** - Main delegate registrations (includes partner info for UNSC)
- **delegation_members** - Individual members within delegations
- **contact_messages** - Contact form submissions
- **newsletter_subscribers** - Email subscribers
- **site_settings** - Configuration settings

### Key Features
- Partner delegate support (UNSC double delegates)
- Delegation member management with individual committee assignments
- MUN experience tracking for all participants
- Committee assignment tracking

## 🔐 Security Features

- **1-Hour Session Timeout** - Automatic logout after inactivity
- **Password Hashing** - Bcrypt with cost factor 12
- **SQL Injection Protection** - PDO prepared statements
- **XSS Prevention** - Input sanitization
- **Git Security** - Sensitive files excluded via .gitignore
- **Environment Separation** - Example files for safe commits
- **Webhook Security** - Secret key authentication for deployment

## 🎨 Theme & Design

### Black & Gold Theme
- Primary: `#d4af37` (Gold)
- Secondary: `#b8860b` (Dark Gold)
- Background: `#000000` / `#1a1a1a` (Black)
- Modern gradients and animations
- Consistent across all pages

### Features
- Session timer with color-coded warnings
- Animated stat cards
- Gradient buttons with ripple effects
- Custom scrollbars
- Responsive sidebar

## 📱 Responsive Design

- Bootstrap 5.3.2 framework
- Mobile-first approach
- Touch-friendly interface
- Optimized for all screen sizes

## 🔧 Customization

### Changing Event Details
Edit `config/config.php`:
```php
define('EVENT_DATE', '2nd - 4th January, 2026');
define('EVENT_VENUE', 'Your Venue');
define('EARLY_BIRD_DEADLINE', '15 Nov');
```

### Social Media Links
Update in `config/config.php`:
```php
define('FACEBOOK_URL', 'https://www.facebook.com/nedmunofficial');
define('INSTAGRAM_URL', 'https://www.instagram.com/nedmunofficial/');
```

## 📧 Email System

Automated emails for:
- Delegate registration confirmation (pending status)
- Committee assignment acceptance (confirmed status)
- Brand Ambassador application confirmation

All emails include:
- NEDMUN-VI branding
- Event details
- Contact information
- TE Links tech partner credit

## 🤝 Tech Partner

**Developed by:** [TE Links](https://telinks.org)
- Powering NEDMUN-VI Registration System
- Custom MVC Architecture
- Full-stack Development

## 📈 Git Best Practices

### Branching Strategy
```bash
main          # Production-ready code
develop       # Development branch
feature/*     # New features
hotfix/*      # Urgent fixes
```

### Committing Changes
```bash
git add .
git commit -m "feat: Add delegation member management"
git push origin main
```

### Pulling Updates
```bash
git pull origin main
```

## 🚦 Version

**Version 1.0.0** - November 2025
- Complete registration system
- Admin panel with committee assignment
- Email automation
- Auto-deployment support
- Black & gold themed design
- 1-hour session timeout

## 📄 License

Copyright © 2025 NED Debating Society. All rights reserved.

---

**NEDMUN-VI** - Karachi's Largest Model United Nations Conference  
*Noting the Past, Navigating the Present, Nurturing the Future*


## 🏗️ Architecture

### MVC Structure
```
NDS/
├── config/              # Configuration files
│   ├── config.php       # App configuration
│   └── database.php     # Database connection
├── models/              # Data models
│   ├── Admin.php
│   ├── BrandAmbassador.php
│   └── DelegateRegistration.php
├── views/               # View templates
│   ├── brand-ambassador-form.php
│   └── delegate-registration-form.php
├── controllers/         # Controllers
│   ├── BrandAmbassadorController.php
│   └── DelegateController.php
├── admin/              # Admin panel
│   ├── includes/       # Reusable components
│   ├── ajax/          # AJAX endpoints
│   ├── dashboard.php
│   ├── delegates.php
│   ├── brand-ambassadors.php
│   └── login.php
├── assets/             # Static assets
│   ├── css/
│   ├── js/
│   └── images/
├── database.sql        # Database schema
├── index.php          # Homepage
└── .htaccess          # URL routing
```

## 🚀 Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server with mod_rewrite enabled
- WAMP/XAMPP/LAMP stack

### Step 1: Database Setup
1. Create a MySQL database named `nedmun_vi`
2. Import the database schema:
   ```sql
   mysql -u root -p nedmun_vi < database.sql
   ```
   Or use phpMyAdmin to import `database.sql`

### Step 2: Configuration
1. Open `config/database.php`
2. Update database credentials if needed:
   ```php
   private $host = 'localhost';
   private $db_name = 'nedmun_vi';
   private $username = 'root';
   private $password = '';
   ```

3. Open `config/config.php`
4. Update the `BASE_URL` constant:
   ```php
   define('BASE_URL', 'http://localhost/telinks.live/NDS/');
   ```

### Step 3: File Permissions
Ensure the web server has read/write permissions:
```bash
chmod -R 755 /path/to/NDS
```

### Step 4: Access the Application
- **Homepage**: `http://localhost/telinks.live/NDS/`
- **Admin Login**: `http://localhost/telinks.live/NDS/admin`
- **Default Credentials**:
  - Username: `admin`
  - Password: `admin123`

## 📊 Database Schema

### Tables
- **admins** - Admin user accounts
- **brand_ambassadors** - BA applications
- **delegate_registrations** - Delegate registrations
- **contact_messages** - Contact form submissions
- **newsletter_subscribers** - Email subscribers
- **site_settings** - Configuration settings

## 🎨 SEO Features

### Implemented SEO Best Practices
- ✅ Semantic HTML5 structure
- ✅ Meta tags (title, description, keywords)
- ✅ Open Graph tags for social media
- ✅ Twitter Card meta tags
- ✅ Structured data (JSON-LD schema)
- ✅ Sitemap-ready structure
- ✅ Mobile-responsive design
- ✅ Fast loading with optimized assets
- ✅ Clean URLs with .htaccess
- ✅ Image alt attributes
- ✅ Heading hierarchy (H1-H6)

### Target Keywords
- NEDMUN
- Model United Nations Karachi
- NED University MUN
- MUN Conference Pakistan
- Student Diplomacy Conference
- Youth Leadership Pakistan

## 🔐 Security Features

- **Password Hashing** - Using PHP password_hash()
- **SQL Injection Protection** - PDO prepared statements
- **XSS Prevention** - Input sanitization
- **CSRF Protection** - Session management
- **Access Control** - Authentication required for admin
- **.htaccess Protection** - Config files protected
- **Input Validation** - Server-side validation

## 📱 Responsive Design

- Bootstrap 5.3.2 framework
- Mobile-first approach
- Breakpoints: 576px, 768px, 992px, 1200px
- Touch-friendly interface
- Optimized for all screen sizes

## 🎯 Key Pages

### Public Pages
1. **Home** (`index.php`)
   - Event information
   - Statistics
   - Committee overview
   - Registration options

2. **Delegate Registration** (`/register`)
   - Personal information form
   - Institution details
   - Committee preferences
   - Delegation options

3. **Brand Ambassador** (`/brand-ambassador`)
   - Application form
   - Program benefits
   - Requirements

### Admin Pages
1. **Dashboard** (`/admin/dashboard`)
   - Statistics overview
   - Recent registrations
   - Quick actions

2. **Delegates** (`/admin/delegates`)
   - All registrations
   - Filter & search
   - Status management
   - Export data

3. **Brand Ambassadors** (`/admin/brand-ambassadors`)
   - All applications
   - Approval workflow
   - Export data

## 🛠️ Customization

### Changing Event Details
Edit `config/config.php`:
```php
define('EVENT_DATE', '2nd - 4th January, 2026');
define('EVENT_VENUE', 'Your Venue');
define('EARLY_BIRD_DEADLINE', '15 Nov');
```

### Adding Committees
Edit the select options in `views/delegate-registration-form.php`

### Styling
- Main styles: `assets/css/style.css`
- Admin styles: `assets/css/admin.css`

## 📧 Email Configuration

For email notifications, configure SMTP in `config/config.php`:
```php
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-app-password');
```

## 🔄 Updates & Maintenance

### Backup Database
```bash
mysqldump -u root -p nedmun_vi > backup_$(date +%Y%m%d).sql
```

### Update Admin Password
```php
// Run this script once to change password
$new_password = password_hash('new_password', PASSWORD_DEFAULT);
// Update in database
```

## 📈 Analytics Integration

Add Google Analytics to track visitors:
```html
<!-- Add before </head> in all view files -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
```

## 🤝 Support

For issues or questions:
- Email: help.nexsys@gmail.com
- Documentation: This README file

## 📄 License

Copyright © 2025 NED Debating Society. All rights reserved.

## 🎓 Credits

- **Developed for**: NED Debating Society
- **Event**: NEDMUN-VI
- **Framework**: Bootstrap 5, PHP 7+, MySQL
- **Icons**: Font Awesome 6
- **Fonts**: Google Fonts (Poppins, Playfair Display)

## 🚦 Version

**Version 1.0.0** - November 2025
- Initial release
- Complete registration system
- Admin panel
- SEO optimization

---

**NEDMUN-VI** - Karachi's Largest Model United Nations Conference
