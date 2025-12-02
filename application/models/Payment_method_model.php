<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_method_model extends CI_Model {

    private $table = 'payment_methods';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all payment methods (active)
     */
    public function get_all($active_only = true) {
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        $this->db->order_by('name', 'ASC');
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Get payment method by ID
     */
    public function find($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    /**
     * Create payment method
     */
    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update payment method
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete payment method
     */
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Get payment method dropdown (for forms)
     */
    public function get_dropdown($active_only = true) {
        $methods = $this->get_all($active_only);
        $dropdown = [];
        foreach ($methods as $method) {
            $dropdown[$method['id']] = $method['name'];
        }
        return $dropdown;
    }
}
