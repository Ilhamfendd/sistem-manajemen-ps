<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

    private $table = 'customers';

    public function get_all() {
        return $this->db->order_by('id', 'DESC')->get($this->table)->result();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function find($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    /**
     * Generate auto customer ID with format YYNNNN
     * YY = 2 digit last year (25 for 2025, 26 for 2026, etc)
     * NNNN = 4 digit sequential number (0001, 0002, ..., 9999)
     */
    public function generate_customer_id() {
        $current_year = date('y'); // Get 2 digit year (25, 26, etc)
        $prefix = $current_year;
        
        // Get last customer_id with current year prefix
        $this->db->select('customer_id')
                 ->like('customer_id', $prefix, 'after')
                 ->order_by('customer_id', 'DESC')
                 ->limit(1);
        $last_customer = $this->db->get($this->table)->row();
        
        // Extract sequential number from last ID
        if ($last_customer && strlen($last_customer->customer_id) === 6) {
            $last_number = (int) substr($last_customer->customer_id, 2); // Get last 4 digits
            $next_number = $last_number + 1;
            
            // Check if we exceeded 9999
            if ($next_number > 9999) {
                return null; // Error: too many customers for this year
            }
        } else {
            // First customer of this year
            $next_number = 1;
        }
        
        // Format as YYNNNN (e.g., 250001, 250002)
        $new_customer_id = $prefix . str_pad($next_number, 4, '0', STR_PAD_LEFT);
        
        return $new_customer_id;
    }

    /**
     * Check if customer_id is unique
     */
    public function is_customer_id_unique($customer_id) {
        $exists = $this->db->get_where($this->table, ['customer_id' => $customer_id])->num_rows();
        return $exists === 0;
    }}