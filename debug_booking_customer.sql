-- Debug booking ID 2 relationship
SELECT 
    b.id,
    b.customer_id,
    b.full_name,
    b.status,
    b.approved_at,
    b.expires_at,
    cu.id as customer_actual_id,
    cu.customer_id as customer_customer_id,
    cu.full_name as customer_full_name
FROM bookings b
LEFT JOIN customers cu ON cu.id = b.customer_id
WHERE b.id = 2;

-- Check apakah ada customer dengan ID sesuai dengan b.customer_id
SELECT * FROM customers WHERE id IN (
    SELECT customer_id FROM bookings WHERE id = 2
);
