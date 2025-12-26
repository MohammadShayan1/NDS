# حرف راز Event Registration System Setup

## Overview
This system allows users to register for the Harf-e-Raaz event and provides admin functionality to approve/reject registrations.

## Files Created

### 1. Database Migration
- **File:** `event_registration_migration.sql`
- **Purpose:** Creates the `event_registrations` table
- **Status:** Ready to execute

### 2. Model
- **File:** `models/EventRegistration.php`
- **Purpose:** Handles all database operations for event registrations

### 3. Public Registration Form
- **File:** `views/event-registration-form.php`
- **URL:** `http://localhost/telinks.live/NDS/event-registration`
- **Features:**
  - Beautiful Urdu/English bilingual design
  - Name, CNIC, Email, Phone fields
  - Payment screenshot upload
  - CNIC auto-formatting (xxxxx-xxxxxxx-x)
  - Image preview before upload
  - Bank payment details display

### 4. Form Controller
- **File:** `controllers/EventRegistrationController.php`
- **Purpose:** Processes form submissions
- **Features:**
  - Input validation and sanitization
  - File upload handling (max 5MB)
  - Accepts JPG, PNG, PDF formats

### 5. Admin Management Page
- **File:** `admin/event-registrations.php`
- **URL:** `http://localhost/telinks.live/NDS/admin/event-registrations`
- **Features:**
  - Quick stats dashboard (Total, Pending, Approved, Rejected)
  - DataTables with search and sorting
  - View registration details
  - View payment screenshots (zoom capability)
  - Approve/Reject with admin notes
  - Delete registrations

### 6. AJAX Helper
- **File:** `admin/ajax/get-event-registration.php`
- **Purpose:** Fetches registration details for modals

### 7. Configuration Updates
- **Updated:** `admin/includes/sidebar.php` - Added "Event Registrations" menu item
- **Updated:** `.htaccess` - Added routing for event registration URLs

## Installation Steps

### Step 1: Run Database Migration
1. Open phpMyAdmin or MySQL CLI
2. Select your database (e.g., `nedmun_db`)
3. Execute the SQL file:
   ```sql
   -- Copy and paste contents of event_registration_migration.sql
   -- OR import the file directly
   ```
4. Verify table created:
   ```sql
   SHOW TABLES LIKE 'event_registrations';
   DESC event_registrations;
   ```

### Step 2: Create Upload Directory
```bash
# Navigate to your project root
cd d:/shayan/wamp64/www/telinks.live/NDS

# Create directory for event payment uploads
mkdir -p uploads/event_payments

# Set permissions (on Linux/Mac)
chmod 755 uploads/event_payments
```

On Windows (WAMPP), the directory will be created automatically with correct permissions when first upload occurs.

### Step 3: Configure Settings (Optional)
Add these settings in your admin settings page or directly in database:

```sql
INSERT INTO settings (setting_key, setting_value) VALUES
('event_registration_status', 'open'),
('event_fee', '500'),
('bank_name', 'HBL'),
('account_title', 'NED Debating Society'),
('account_number', '1234567890')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);
```

### Step 4: Restart Apache
Restart your WAMPP server to apply .htaccess changes.

## URLs

### Public Access
- **Registration Form:** `http://localhost/telinks.live/NDS/event-registration`

### Admin Access
- **Admin Login:** `http://localhost/telinks.live/NDS/admin/login`
- **Event Registrations:** `http://localhost/telinks.live/NDS/admin/event-registrations`

## Features

### Public Form Features
✅ Name, CNIC, Email, Phone Number fields  
✅ Payment screenshot upload with preview  
✅ CNIC auto-formatting (xxxxx-xxxxxxx-x)  
✅ File validation (JPG, PNG, PDF only, max 5MB)  
✅ Responsive design with gradient background  
✅ Beautiful Urdu heading (حرف راز)  
✅ Bank payment details display  
✅ Registration status check (open/closed)  

### Admin Panel Features
✅ Quick statistics cards (Total, Pending, Approved, Rejected)  
✅ DataTables with search, sort, pagination  
✅ View full registration details  
✅ View payment screenshots with zoom  
✅ Approve/Reject registrations  
✅ Add admin notes  
✅ Delete registrations  
✅ Status badges (color-coded)  
✅ Date formatting  
✅ Responsive design  

## Database Schema

```sql
CREATE TABLE event_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(100) DEFAULT 'Harf-e-Raaz',
    full_name VARCHAR(100) NOT NULL,
    cnic_number VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    payment_screenshot VARCHAR(255) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    admin_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## Testing Checklist

### Public Form Testing
- [ ] Access form at `/event-registration`
- [ ] Fill all fields with valid data
- [ ] Upload payment screenshot (JPG/PNG)
- [ ] Verify CNIC formatting works (xxxxx-xxxxxxx-x)
- [ ] Verify image preview shows before submit
- [ ] Submit form and check success message
- [ ] Verify redirect to homepage
- [ ] Check email field validation
- [ ] Test with invalid file types (should reject)
- [ ] Test with large files >5MB (should reject)

### Admin Panel Testing
- [ ] Login to admin panel
- [ ] Navigate to "Event Registrations" in sidebar
- [ ] Verify stats cards show correct counts
- [ ] Test DataTables search functionality
- [ ] Test DataTables sorting
- [ ] Click "View Details" - verify modal shows complete info
- [ ] Click "View Payment" - verify image displays
- [ ] Click zoom on payment image - verify opens in new tab
- [ ] Edit status to "Approved" - verify saves
- [ ] Edit status to "Rejected" with notes - verify saves
- [ ] Delete a registration - verify confirmation and deletion
- [ ] Test with multiple registrations
- [ ] Verify date formatting is correct

## Status Badge Colors
- **Pending:** Yellow/Warning badge
- **Approved:** Green/Success badge
- **Rejected:** Red/Danger badge

## File Upload Configuration
- **Allowed Types:** JPG, PNG, PDF
- **Max Size:** 5MB
- **Upload Path:** `uploads/event_payments/`
- **Naming:** `event_payment_[unique_id].[extension]`

## Admin Actions

### View Details
Shows complete registration information in a modal:
- Full Name
- CNIC Number
- Email Address
- Phone Number
- Current Status
- Admin Notes
- Registration Date/Time

### View Payment
Opens payment screenshot in a modal with:
- Full-size image display
- Click to open in new tab
- Zoom capability

### Edit Status
Modal form with:
- Status dropdown (Pending/Approved/Rejected)
- Admin notes textarea
- Pre-filled with current values

### Delete Registration
Confirmation dialog before permanent deletion.

## Security Features
- ✅ Login required for admin panel (`requireLogin()`)
- ✅ Input sanitization on all form fields
- ✅ File type validation
- ✅ File size validation
- ✅ SQL injection prevention (prepared statements)
- ✅ XSS prevention (`htmlspecialchars()`)
- ✅ CSRF protection via session
- ✅ Direct file access prevention

## Email Notifications (Optional Enhancement)
Currently not implemented but can be added:
- Send confirmation email to user on registration
- Send approval/rejection notification to user
- Send admin notification on new registration

To implement, use the existing email system:
```php
require_once '../config/email.php';
// Add email functions similar to delegate system
```

## Future Enhancements (Not Implemented)
- [ ] Export registrations to CSV/Excel
- [ ] Bulk approve/reject
- [ ] Email notifications
- [ ] Registration limit/capacity
- [ ] QR code generation for approved registrants
- [ ] SMS notifications
- [ ] Payment amount field
- [ ] Multiple event support
- [ ] Registration deadline configuration

## Troubleshooting

### Issue: Form not accessible
**Solution:** Check .htaccess routing is correct and Apache rewrite module is enabled

### Issue: Upload directory not writable
**Solution:** 
```bash
# Windows: Check folder exists and is not read-only
# Linux/Mac: 
chmod 755 uploads/event_payments
```

### Issue: Payment screenshot not displaying
**Solution:** Verify file path is correct and file was uploaded successfully

### Issue: Admin menu not showing
**Solution:** Clear browser cache and verify sidebar.php was updated correctly

### Issue: DataTables not loading
**Solution:** Check browser console for JavaScript errors, verify jQuery and DataTables CDN links

## Support
For issues or questions, contact the development team.

---

**Developed by TE Links**  
**Date:** December 27, 2025  
**Version:** 1.0
