<?php
$conn = new mysqli('localhost', 'root', '', 'ps_manager');
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

$sql_file = file_get_contents('setup_consoles.sql');
$statements = array_filter(array_map('trim', explode(';', $sql_file)));

foreach ($statements as $statement) {
    if (!empty($statement)) {
        if ($conn->query($statement) === FALSE) {
            echo 'Error: ' . $conn->error . "\n";
        }
    }
}

$result = $conn->query('SELECT COUNT(*) as total FROM consoles');
$row = $result->fetch_assoc();
echo "Berhasil! Total unit PS yang ada sekarang: " . $row['total'] . "\n\n";

$result = $conn->query('SELECT id, console_name, console_type, price_per_hour, status FROM consoles ORDER BY id');
echo str_repeat('-', 90) . "\n";
while($row = $result->fetch_assoc()) {
    echo sprintf("ID: %d | Nama: %-20s | Tipe: %-5s | Harga: %s/jam | Status: %s\n", 
        $row['id'], $row['console_name'], $row['console_type'], 
        number_format($row['price_per_hour']), $row['status']);
}
$conn->close();
?>
