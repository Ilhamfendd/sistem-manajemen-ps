<?php
// Simple debug to check customer ID generation
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if we can connect and test the query
$mysqli = new mysqli("localhost", "root", "", "ps_manager");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

echo "=== Customer ID Generation Debug ===\n\n";

// Get current year
$current_year = date('y');
$prefix = $current_year;
echo "Current year (2-digit): $current_year\n";
echo "Searching for customer_id LIKE: $prefix%\n\n";

// Check existing IDs
echo "Existing customer IDs:\n";
$result = $mysqli->query("SELECT customer_id, full_name FROM customers WHERE customer_id LIKE '$prefix%' ORDER BY customer_id DESC LIMIT 10");

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "  - {$row['customer_id']} ({$row['full_name']})\n";
    }
} else {
    echo "  No customer IDs found with prefix $prefix\n";
}

// Get the last one
echo "\nFinding last customer_id with prefix $prefix:\n";
$result = $mysqli->query("SELECT customer_id FROM customers WHERE customer_id LIKE '$prefix%' ORDER BY customer_id DESC LIMIT 1");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $last_id = $row['customer_id'];
    echo "  Last ID: $last_id\n";
    
    $last_number = (int) substr($last_id, 2);
    echo "  Last number (digits 3-6): $last_number\n";
    
    $next_number = $last_number + 1;
    echo "  Next number: $next_number\n";
    
    $new_id = $prefix . str_pad($next_number, 4, '0', STR_PAD_LEFT);
    echo "  New ID would be: $new_id\n";
} else {
    echo "  No previous ID found, first customer of this year\n";
    $new_id = $prefix . str_pad(1, 4, '0', STR_PAD_LEFT);
    echo "  New ID would be: $new_id\n";
}

$mysqli->close();
?>
