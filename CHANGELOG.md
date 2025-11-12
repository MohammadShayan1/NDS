# Changelog - NEDMUN-VI Registration System

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-11-13

### Added - Production Release
### Added - Production Release
- **Complete MVC Architecture** - Model-View-Controller pattern implementation
- **Delegate Registration System**
  - Individual delegate registration
  - Delegation registration (groups of 9+ members)
  - UNSC double delegate support (partner information with CNIC)
  - NED student auto-fill functionality (institution & education level)
  - Committee preference selection (3 choices from 8 committees)
  - MUN experience tracking for delegates, partners, and delegation members
  - Dietary requirements
  - Special needs accommodation
  - Reference code and promo code fields
  - Dynamic delegation member collection (name, email, phone, CNIC, preference, experience)
  
- **Brand Ambassador Program**
  - Application system with comprehensive form
  - Prior experience evaluation
  - Expected delegate count tracking
  - PR drive capability assessment
  - Benefits tracking and display
  - CNIC validation
  - Approval workflow
  
- **Admin Panel Features**
  - **Modern Black & Gold Theme**
    - Complete redesign with gradients and animations
    - Custom CSS variables for consistent theming
    - Animated stat cards with hover effects
    - Gradient buttons with ripple effects
    - Custom dark scrollbars
    - Dark themed DataTables
  - **Session Management**
    - 1-hour session timeout (3600 seconds)
    - Live countdown timer in header (MM:SS format)
    - Color-coded warnings (gray >5min, yellow <5min, red <1min)
    - Activity-based session renewal
    - Auto-logout on expiry
  - **Dashboard**
    - Real-time statistics
    - Analytics overview
    - Activity tracking
  - **Delegate Management**
    - View all registrations with DataTables
    - Status tracking (pending/confirmed/rejected)
    - Payment status management (pending/paid/waived)
    - Committee assignment with dropdown selection
    - View delegation members modal
    - Individual delegation member committee assignment
    - Automated acceptance email on assignment
    - CSV export functionality
    - Admin notes system
    - Search and filter capabilities
  - **Brand Ambassador Management**
    - Application review system
    - Approval/rejection workflow
    - Status tracking
    - CSV export
  - **TE Links Tech Partner Branding**
    - Sidebar footer credit with logo
    - Login page credit
    - Dashboard banner
    - Version number display
  
- **Email System**
  - **Automated Confirmation Emails** (pending status)
    - Delegate registration confirmation
    - Brand Ambassador application confirmation
  - **Committee Assignment Acceptance Emails** (confirmed status)
    - Personalized committee assignment notification
    - Event details and next steps
    - NEDMUN branding
  - **HTML Templates**
    - Black & gold branding
    - Responsive design
    - TE Links tech partner credit in footer
    - Professional formatting
  - **Email Configuration**
    - From: noreply@telinks.org
    - Reply-To: nedmunofficial@gmail.com
    - Git-safe configuration (.example template)
  
- **Security Features**
  - Bcrypt password hashing (cost factor 12)
  - 1-hour session timeout with activity renewal
  - PDO prepared statements (SQL injection protection)
  - Input sanitization (XSS prevention)
  - Git-safe configuration (.gitignore for sensitive files)
  - Webhook secret key authentication
  - Template files (.example) for safe commits
  
- **Design & Branding**
  - **Black & Gold Theme**
    - Primary: #000000, #0d0d0d, #1a1a1a
    - Gold: #d4af37, #b8860b, #daa520
    - Gradients and animations throughout
  - **NDS/NEDMUN Branding**
    - Official logos throughout site
    - NEDMUN-VI tagline: "Noting the Past, Navigating the Present, Nurturing the Future"
    - Event dates: January 2-4, 2026
  - **Responsive Design**
    - Bootstrap 5.3.2
    - Mobile-first approach
    - Optimized for all screen sizes
  - **UX Enhancements**
    - Smooth transitions
    - Loading animations
    - Interactive forms
    - Reduced header padding (py-3, mb-1)
  
- **Deployment & Version Control**
  - **Git Integration**
    - .gitignore for sensitive files
    - .example templates for database and email config
    - Comprehensive Git workflow
  - **Auto-Deployment**
    - deploy.php webhook endpoint
    - Secret key authentication
    - Git fetch and pull automation
    - Deployment logging
  - **cPanel Integration**
    - .cpanel.yml deployment configuration
    - Automatic rsync on git push
    - Directory creation and permission setting
    - Excludes .git, .example files, documentation
  
- **Documentation**
  - **README.md** - Comprehensive project overview
  - **DEPLOYMENT.md** - Step-by-step deployment guide
  - **QUICKSTART.md** - 5-minute setup guide
  - **CHANGELOG.md** - Version history (this file)
  - Inline code documentation
  
- **Database Schema**
  - admins table (id, username, password, created_at, updated_at)
  - delegate_registrations table (with partner fields: partner_name, partner_email, partner_phone, partner_cnic, partner_experience, assigned_committee)
  - delegation_members table (registration_id FK, member details, member_experience, assigned_committee, status) - CASCADE DELETE
  - brand_ambassadors table
  - contact_messages table
  - newsletter_subscribers table
  - site_settings table
  - UTF-8 encoding, proper indexing, timestamp tracking
  
- **Committees (8 Total)**
  - UNSC (United Nations Security Council) - Double Delegate
  - UNCSTD (UN Commission on Science and Technology for Development)
  - UNWOMEN (UN Women)
  - ECOSOC (Economic and Social Council)
  - UNHRC (UN Human Rights Council)
  - UNODC (UN Office on Drugs and Crime)
  - UNCSW (UN Commission on Status of Women)
  - CLIMATE COUNCIL
  
- **Pricing Structure**
  - **NEDians**
    - Early Bird (till Dec 15): Rs 2000 (individual), Rs 1750/person (delegation)
    - Regular (till Dec 31): Rs 2500 (individual), Rs 2250/person (delegation)
  - **External**
    - Early Bird (till Dec 15): Rs 3000 (individual), Rs 2750/person (delegation)
    - Regular (till Dec 31): Rs 3500 (individual), Rs 3250/person (delegation)
  
- **Social Media Integration**
  - Facebook: https://www.facebook.com/nedmunofficial
  - Instagram: https://www.instagram.com/nedmunofficial/
  - (Removed: Twitter and LinkedIn links)
  
- **Tech Partner Branding**
  - **TE Links** (https://telinks.org) credited throughout:
    - Admin sidebar footer
    - Admin login page
    - Admin dashboard
    - All email templates
    - Public website footers
    - Configuration constants

### Changed
- Updated registration form header padding (reduced from py-4, mb-2 to py-3, mb-1)
- Simplified social media links (removed Twitter and LinkedIn)
- Updated email footer with TE Links tech partner credit
- Changed contact email from help.nexsys@gmail.com to nedmunofficial@gmail.com
- Removed waitlist status (now: pending/confirmed/rejected)
- Database schema updated with partner and delegation member fields
- Admin panel completely redesigned with black & gold theme

### Security
- Implemented .gitignore for sensitive files (database.php, email.php)
- Created .example templates for safe Git commits
- Added webhook secret key authentication
- Session timeout set to 1 hour (3600 seconds)
- Activity-based session renewal implemented
- Password requirement: admin123 (CHANGE AFTER FIRST LOGIN)

### Fixed
- NED institution auto-fill now works correctly
- Form header padding reduced for better mobile experience
- Session expiry now properly tracked with LAST_ACTIVITY
- Email sending integrated with committee assignment
- Delegation member cascade delete on registration removal

### Removed
- Unnecessary init-git.sh file (replaced by .cpanel.yml)
- Twitter and LinkedIn social media links
- Excessive documentation files
- Waitlist status option

### Tech Stack
