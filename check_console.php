<?php
$conn = new mysqli('localhost', 'root', '', 'ps_manager');
$result = $conn->query('SELECT id, console_name, console_type, price_per_hour FROM consoles LIMIT 1');
$row = $result->fetch_assoc();
echo "console_type value: '" . $row['console_type'] . "'\n";
echo "console_type length: " . strlen($row['console_type']) . "\n";
var_dump($row);
?>
