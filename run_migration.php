<?php
// Migration runner - execute this once to update database
$config = include 'application/config/database.php';
$db = $config['default'];
$conn = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "Starting migration...\n\n";

// Step 1: Add customer_id column
echo "1. Adding customer_id column...\n";
$sql1 = "ALTER TABLE customers ADD COLUMN customer_id VARCHAR(6) UNIQUE NULL AFTER id";
if ($conn->query($sql1) === TRUE) {
    echo "   ✓ customer_id column added\n";
} else {
    echo "   ! " . $conn->error . "\n";
}

// Step 2: Add index
echo "2. Adding index on customer_id...\n";
$sql2 = "CREATE INDEX idx_customer_id ON customers(customer_id)";
if ($conn->query($sql2) === TRUE) {
    echo "   ✓ Index created\n";
} else {
    echo "   ! " . $conn->error . "\n";
}

// Step 3: Drop phone column
echo "3. Dropping phone column...\n";
$sql3 = "ALTER TABLE customers DROP COLUMN phone";
if ($conn->query($sql3) === TRUE) {
    echo "   ✓ phone column dropped\n";
} else {
    echo "   ! " . $conn->error . "\n";
}

// Step 4: Make customer_id NOT NULL
echo "4. Making customer_id NOT NULL...\n";
$sql4 = "ALTER TABLE customers MODIFY COLUMN customer_id VARCHAR(6) NOT NULL UNIQUE";
if ($conn->query($sql4) === TRUE) {
    echo "   ✓ customer_id is now required\n";
} else {
    echo "   ! " . $conn->error . "\n";
}

echo "\nMigration completed!\n";
echo "✓ Customers table structure updated successfully\n";
echo "✓ Ready to use new customer ID system (YYNNNN format)\n";

$conn->close();
?>
