-- Cleanup bookings table
-- Remove phone column if exists and reset data

-- Delete all bookings data
DELETE FROM bookings;

-- Reset AUTO_INCREMENT
ALTER TABLE bookings AUTO_INCREMENT = 1;

-- Check if phone column exists and drop it
ALTER TABLE bookings DROP COLUMN IF EXISTS phone;

-- Verify bookings table structure
-- SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'bookings' AND TABLE_SCHEMA = 'ps_manager';

-- Verify table is clean
SELECT COUNT(*) as total_bookings FROM bookings;
