<?php
$conn = new mysqli('localhost', 'root', '', 'ps_manager');
$result = $conn->query('DESCRIBE consoles');
echo "Struktur Tabel Consoles:\n";
echo str_repeat('-', 100) . "\n";
while($row = $result->fetch_assoc()) {
    echo sprintf("%-20s | %-15s | %-4s | %-4s | %-20s | %s\n",
        $row['Field'],
        $row['Type'],
        $row['Null'],
        $row['Key'],
        $row['Default'] ?? 'NULL',
        $row['Extra']
    );
}
?>
