<?php
$conn = new mysqli('localhost', 'root', '', 'ps_manager');

// Alter table untuk menambah PS3 ke enum
$sql = "ALTER TABLE consoles MODIFY console_type ENUM('PS3', 'PS4', 'PS5')";
if ($conn->query($sql) === TRUE) {
    echo "✓ Schema berhasil diupdate - console_type sekarang menerima PS3, PS4, PS5\n\n";
} else {
    echo "✗ Error: " . $conn->error . "\n";
    exit(1);
}

// Sekarang update semua console_type menjadi PS3
$sql_file = file_get_contents('setup_consoles.sql');
$statements = array_filter(array_map('trim', explode(';', $sql_file)));

foreach ($statements as $statement) {
    if (!empty($statement)) {
        if ($conn->query($statement) === FALSE) {
            echo '✗ Error: ' . $conn->error . "\n";
        }
    }
}

$result = $conn->query('SELECT COUNT(*) as total FROM consoles');
$row = $result->fetch_assoc();
echo "✓ Berhasil! Total unit PS yang ada sekarang: " . $row['total'] . "\n\n";

$result = $conn->query('SELECT id, console_name, console_type, price_per_hour, status FROM consoles ORDER BY id');
echo str_repeat('-', 110) . "\n";
while($row = $result->fetch_assoc()) {
    echo sprintf("ID: %2d | Nama: %-20s | Tipe: %-5s | Harga: %s/jam | Status: %s\n", 
        $row['id'], $row['console_name'], $row['console_type'], 
        number_format($row['price_per_hour']), $row['status']);
}
echo str_repeat('-', 110) . "\n";
$conn->close();
?>
