-- Cleanup bookings table
-- Remove phone column and reset data

-- Step 1: Drop phone column
ALTER TABLE bookings DROP `phone`;

-- Step 2: Delete all bookings data
DELETE FROM bookings;

-- Step 3: Reset AUTO_INCREMENT
ALTER TABLE bookings AUTO_INCREMENT = 1;

-- Step 4: Verify table is clean
SELECT COUNT(*) as total_bookings FROM bookings;

-- Step 5: Show final structure
SELECT COLUMN_NAME, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'bookings' AND TABLE_SCHEMA = 'ps_manager' 
ORDER BY ORDINAL_POSITION;

