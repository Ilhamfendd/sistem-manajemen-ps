<?php
// Quick test to verify console update works
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'ps_manager';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Test update console 23 to di_pesan
$sql = "UPDATE consoles SET status='di_pesan' WHERE id=23";
if ($conn->query($sql) === TRUE) {
    echo "✅ Update successful!<br>";
} else {
    echo "❌ Update failed: " . $conn->error . "<br>";
}

// Check result
$result = $conn->query("SELECT id, console_name, status FROM consoles WHERE id=23");
$row = $result->fetch_assoc();

echo "Current data:<br>";
echo "ID: " . $row['id'] . "<br>";
echo "Name: " . $row['console_name'] . "<br>";
echo "Status: " . $row['status'] . "<br>";

$conn->close();
?>
