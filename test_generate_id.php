<?php
// Test script for customer_id generation
define('BASEPATH', dirname(__FILE__) . '/system/');

require_once dirname(__FILE__) . '/system/core/CodeIgniter.php';

// Get CI instance
$CI = get_instance();
$CI->load->model('Customer_model');

echo "=== Testing Customer ID Generation ===\n\n";

// Test 1: Generate new ID
echo "Test 1: Generate new customer ID\n";
$new_id = $CI->Customer_model->generate_customer_id();
echo "Generated ID: " . ($new_id ? $new_id : "NULL/FAILED") . "\n\n";

// Test 2: Check what's in database
echo "Test 2: Check existing customer IDs\n";
$CI->db->select('customer_id, full_name')->order_by('customer_id', 'DESC')->limit(5);
$results = $CI->db->get('customers')->result_array();
echo "Last 5 customer IDs:\n";
foreach ($results as $row) {
    echo "  - " . $row['customer_id'] . " (" . $row['full_name'] . ")\n";
}

// Test 3: Current year
echo "\nTest 3: Current year check\n";
echo "Current year (2-digit): " . date('y') . "\n";
