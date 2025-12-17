-- Update approved bookings yang expires_at NULL
-- Set expires_at ke 15 menit dari approved_at

UPDATE bookings 
SET expires_at = DATE_ADD(approved_at, INTERVAL 15 MINUTE)
WHERE status = 'approved' 
  AND expires_at IS NULL
  AND approved_at IS NOT NULL;

-- Verify the update
SELECT id, full_name, approved_at, expires_at FROM bookings 
WHERE status = 'approved' 
ORDER BY approved_at DESC;
