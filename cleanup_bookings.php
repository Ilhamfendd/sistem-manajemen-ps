<?php
// Emergency cleanup script - run this to reset bookings table
// Access: http://localhost/sistem-manajemen-ps/cleanup.php

defined('BASEPATH') OR exit('No direct script access allowed');

// Load CodeIgniter
require_once __DIR__ . '/index.php';

$CI = &get_instance();
$CI->load->database();

// Check if admin/superuser
$user = $CI->session->userdata('user');
if (!$user || ($user['role'] != 'admin' && $user['role'] != 'kasir')) {
    die('Access denied. Admin only.');
}

try {
    // Step 1: Delete all bookings
    $CI->db->truncate('bookings');
    echo "✅ Deleted all bookings<br>";
    
    // Step 2: Drop phone column if exists
    $CI->db->query("ALTER TABLE bookings DROP COLUMN IF EXISTS phone");
    echo "✅ Removed phone column if existed<br>";
    
    // Step 3: Verify structure
    $columns = $CI->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'bookings' AND TABLE_SCHEMA = 'ps_manager' ORDER BY ORDINAL_POSITION")->result_array();
    
    echo "<br><strong>Bookings Table Structure:</strong><br>";
    echo "<table border='1' cellpadding='5'>";
    foreach ($columns as $col) {
        echo "<tr><td>" . $col['COLUMN_NAME'] . "</td></tr>";
    }
    echo "</table>";
    
    echo "<br><strong>✅ Bookings table cleaned and ready!</strong>";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
