<?php
$config = include 'application/config/database.php';
$db = $config['default'];
$conn = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);

// Lihat outstanding payments per customer
$sql = "SELECT 
    c.id,
    c.full_name,
    c.phone,
    COUNT(r.id) as rental_count,
    SUM(r.total_amount) as total_amount,
    COALESCE(SUM(t.amount), 0) as paid_amount,
    (SUM(r.total_amount) - COALESCE(SUM(t.amount), 0)) as sisa_piutang,
    r.payment_status
FROM rentals r
JOIN customers c ON c.id = r.customer_id
LEFT JOIN transactions t ON t.rental_id = r.id
WHERE r.payment_status != 'paid'
GROUP BY c.id, r.payment_status
ORDER BY sisa_piutang DESC
LIMIT 20";

$result = $conn->query($sql);
echo "Customer | Phone | Count | Total | Dibayar | SISA PIUTANG | Status\n";
echo str_repeat('-', 120) . "\n";
while($row = $result->fetch_assoc()) {
    printf("%-20s | %-12s | %5d | %7d | %7d | %12d | %10s\n", 
        $row['full_name'], 
        $row['phone'] ?? '-', 
        $row['rental_count'], 
        $row['total_amount'], 
        $row['paid_amount'], 
        $row['sisa_piutang'], 
        $row['payment_status']
    );
}

$conn->close();
?>
