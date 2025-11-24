-- Add early bird delegation discount setting for Other Institutions
-- This allows separate early bird discounts for individual delegates and delegations

INSERT INTO site_settings (setting_key, setting_value) 
VALUES ('early_bird_delegation_discount', '500')
ON DUPLICATE KEY UPDATE setting_value = setting_value;

-- Update existing early_bird_discount setting label for clarity
-- Note: The early_bird_discount now applies only to individual delegates (Other Institutions)
-- The early_bird_delegation_discount applies to delegations (Other Institutions)
