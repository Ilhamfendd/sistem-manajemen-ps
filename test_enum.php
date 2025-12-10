<?php
// Test enum constraint
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'ps_manager';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h3>Testing enum values</h3>";

$test_values = ['available', 'di_pesan', 'in_use', 'maintenance', 'invalid_status', ''];

foreach ($test_values as $val) {
    $sql = "UPDATE consoles SET status='" . $conn->real_escape_string($val) . "' WHERE id=23";
    if ($conn->query($sql) === TRUE) {
        $result = $conn->query("SELECT status FROM consoles WHERE id=23");
        $row = $result->fetch_assoc();
        echo "✅ Set to: '$val' → Actual: '" . $row['status'] . "'<br>";
    } else {
        echo "❌ Set to: '$val' → Error: " . $conn->error . "<br>";
    }
}

$conn->close();
?>
