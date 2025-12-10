<?php
$config = include 'application/config/database.php';
$db = $config['default'];
$conn = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);

// Cek rental #102
$sql = "SELECT 
    r.id,
    r.booking_id,
    c.full_name,
    con.console_name,
    r.total_amount,
    r.status,
    r.payment_status,
    COALESCE(SUM(t.amount), 0) as total_paid,
    (r.total_amount - COALESCE(SUM(t.amount), 0)) as sisa
FROM rentals r
JOIN customers c ON c.id = r.customer_id
JOIN consoles con ON con.id = r.console_id
LEFT JOIN transactions t ON t.rental_id = r.id
WHERE r.id = 102
GROUP BY r.id";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo "=== RENTAL #102 ===\n";
echo "Customer: " . $row['full_name'] . "\n";
echo "Console: " . $row['console_name'] . "\n";
echo "Total Biaya: Rp " . number_format($row['total_amount']) . "\n";
echo "Sudah Dibayar: Rp " . number_format($row['total_paid']) . "\n";
echo "Sisa Piutang: Rp " . number_format($row['sisa']) . "\n";
echo "Status: " . $row['status'] . "\n";
echo "Payment Status: " . $row['payment_status'] . "\n\n";

if ($row['sisa'] > 0 && $row['total_paid'] > 0) {
    echo "✓ Status 'Sebagian' BENAR (ada yang dibayar tapi masih sisa)\n";
} elseif ($row['sisa'] == 0) {
    echo "✗ Status SALAH - harusnya 'Lunas' (sudah dibayar semua)\n";
} elseif ($row['total_paid'] == 0) {
    echo "✗ Status SALAH - harusnya 'Pending' (belum bayar sama sekali)\n";
}

echo "\n=== TRANSAKSI ===\n";
$sql2 = "SELECT id, amount, payment_method_id, paid_at FROM transactions WHERE rental_id = 102";
$result2 = $conn->query($sql2);
while ($trans = $result2->fetch_assoc()) {
    echo "Trans ID " . $trans['id'] . ": Rp " . number_format($trans['amount']) . " (" . $trans['paid_at'] . ")\n";
}

$conn->close();
?>
