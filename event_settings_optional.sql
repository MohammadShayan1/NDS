-- Optional Settings for Event Registration System
-- Run this after creating the event_registrations table
-- These settings will be used in the registration form

INSERT INTO site_settings (setting_key, setting_value) VALUES
('event_registration_status', 'open'),
('event_fee', '500'),
('bank_name', 'Habib Bank Limited (HBL)'),
('account_title', 'NED Debating Society'),
('account_number', '12345678901234')
ON DUPLICATE KEY UPDATE 
    setting_value = VALUES(setting_value);

-- Verify settings were added
SELECT * FROM site_settings WHERE setting_key LIKE 'event_%' OR setting_key LIKE 'bank_%' OR setting_key LIKE 'account_%';
