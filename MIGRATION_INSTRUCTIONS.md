# Database Migration Instructions

## Step 1: Run the SQL Migration

Execute the migration file to add the new columns to your database:

1. Open phpMyAdmin in your WAMPP installation: http://localhost/phpmyadmin/
2. Select your database (the one containing `delegate_registrations` table)
3. Go to the "SQL" tab
4. Copy and paste the contents of `migration_payment_allotment.sql`
5. Click "Go" to execute

Alternatively, you can run from command line:
```bash
mysql -u root -p your_database_name < migration_payment_allotment.sql
```

## Step 2: Verify the Changes

After running the migration, verify that the columns were added:

1. Check `delegate_registrations` table - should have:
   - `payment_amount` (DECIMAL(10,2))
   - `allotment_details` (TEXT)

2. Check `delegation_members` table - should have:
   - `payment_amount` (DECIMAL(10,2))
   - `allotment_details` (TEXT)

## What's New?

### Admin Panel Features:

1. **Payment Amount Tracking**
   - When editing delegate status, you can now enter the actual payment amount received
   - Field appears in the "Update Status" modal
   - Optional field - leave empty if no payment received yet

2. **Total Revenue Display**
   - A new stat card shows total revenue collected
   - Located in the top stats row (rightmost card)
   - Automatically sums all payment_amount values
   - Displays as "PKR X,XXX" format

3. **Allotment Details**
   - When assigning a committee, you can add detailed allotment information
   - Text area for country assignment, portfolio, or special instructions
   - Example: "Representing France" or "Portfolio: Minister of Defense"
   - This information can be included in acceptance emails

### Database Changes:

**delegate_registrations table:**
- Added `payment_amount` - stores actual payment received in PKR
- Added `allotment_details` - stores detailed allotment information

**delegation_members table:**
- Added same columns for delegation members

### Updated Files:

1. `admin/delegates.php` - UI updates for payment and allotment
2. `models/DelegateRegistration.php` - Updated to handle new fields
3. `admin/ajax/assign-committee.php` - Saves allotment details
4. `migration_payment_allotment.sql` - Database migration file

## Testing Checklist:

- [ ] Run the SQL migration successfully
- [ ] Edit a delegate status and add payment amount
- [ ] Verify total revenue updates on dashboard
- [ ] Assign committee with allotment details
- [ ] Check that allotment details save correctly
- [ ] Verify email confirmations still work

## Notes:

- Payment amounts are stored as DECIMAL(10,2) to support up to PKR 99,999,999.99
- All existing records will have NULL for these new fields
- The total revenue calculation only includes non-NULL payment amounts
