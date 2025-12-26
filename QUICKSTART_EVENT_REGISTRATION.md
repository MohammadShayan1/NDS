# حرف راز Event Registration - Quick Start Guide

## 🚀 Quick Setup (3 Steps)

### 1️⃣ Run Database Migration
```sql
-- Open phpMyAdmin → Select your database → SQL tab
-- Copy/paste contents of: event_registration_migration.sql
-- Click "Go"
```

### 2️⃣ (Optional) Add Settings
```sql
-- Copy/paste contents of: event_settings_optional.sql
-- Update bank details as needed
-- Click "Go"
```

### 3️⃣ Test the System
- **Public Form:** http://localhost/telinks.live/NDS/event-registration
- **Admin Panel:** http://localhost/telinks.live/NDS/admin/event-registrations

---

## 📋 What's Included?

### ✅ Public Registration Form
- Name, CNIC, Email, Phone fields
- Payment screenshot upload
- Auto-formatting CNIC (xxxxx-xxxxxxx-x)
- Beautiful Urdu design (حرف راز)
- Payment instructions displayed

### ✅ Admin Management Panel
- View all registrations
- Statistics dashboard
- Approve/Reject with notes
- View payment screenshots
- Search and filter
- Delete registrations

---

## 🎯 Admin Quick Actions

### How to Approve a Registration
1. Click **eye icon** (View Details) to review
2. Click **payment icon** to verify screenshot
3. Click **pencil icon** (Edit Status)
4. Select "Approved" from dropdown
5. Add admin notes (optional)
6. Click "Save Changes"

### How to Reject a Registration
1. Click **pencil icon** (Edit Status)
2. Select "Rejected"
3. Add reason in admin notes
4. Click "Save Changes"

---

## 📱 Access URLs

| Page | URL |
|------|-----|
| **Public Form** | `/event-registration` |
| **Admin Panel** | `/admin/event-registrations` |
| **Admin Login** | `/admin/login` |

---

## 🎨 Status Colors

| Status | Color | Badge |
|--------|-------|-------|
| **Pending** | Yellow | ⚠️ |
| **Approved** | Green | ✅ |
| **Rejected** | Red | ❌ |

---

## 📂 Files Created

1. `event_registration_migration.sql` - Database table
2. `models/EventRegistration.php` - Data model
3. `views/event-registration-form.php` - Public form
4. `controllers/EventRegistrationController.php` - Form handler
5. `admin/event-registrations.php` - Admin page
6. `admin/ajax/get-event-registration.php` - AJAX helper
7. `uploads/event_payments/` - Upload directory

---

## 🔧 Configuration Options

### Close Registration
```sql
UPDATE settings SET setting_value = 'closed' 
WHERE setting_key = 'event_registration_status';
```

### Change Registration Fee
```sql
UPDATE settings SET setting_value = '1000' 
WHERE setting_key = 'event_fee';
```

### Update Bank Details
```sql
UPDATE settings SET setting_value = 'Your Bank Name' 
WHERE setting_key = 'bank_name';

UPDATE settings SET setting_value = 'Your Account Title' 
WHERE setting_key = 'account_title';

UPDATE settings SET setting_value = 'Your Account Number' 
WHERE setting_key = 'account_number';
```

---

## 📊 Quick Stats

The admin dashboard shows:
- **Total Registrations** - All submissions
- **Pending** - Awaiting review
- **Approved** - Verified and accepted
- **Rejected** - Not approved

---

## 🛡️ Security Features

✅ Login required for admin access  
✅ File type validation (JPG, PNG, PDF only)  
✅ File size limit (5MB max)  
✅ SQL injection prevention  
✅ XSS protection  
✅ Input sanitization  

---

## 💡 Pro Tips

1. **Review payments first** - Always check payment screenshot before approving
2. **Add notes** - Document approval/rejection reasons
3. **Use search** - DataTables has powerful search functionality
4. **Export data** - Click on table, Ctrl+A, Ctrl+C to copy to Excel
5. **Backup regularly** - Export database before making bulk changes

---

## 📞 Need Help?

Check the full documentation: `EVENT_REGISTRATION_SETUP.md`

---

**System Status:** ✅ Ready to Use  
**Version:** 1.0  
**Date:** December 27, 2025
