<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends CI_Model {

    private $table = 'transactions';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all transactions
     */
    public function get_all() {
        $this->db->select('t.*, r.customer_id, c.full_name, pm.name as payment_method, u.name as created_by_name');
        $this->db->from($this->table . ' t');
        $this->db->join('rentals r', 'r.id = t.rental_id', 'left');
        $this->db->join('customers c', 'c.id = r.customer_id', 'left');
        $this->db->join('payment_methods pm', 'pm.id = t.payment_method_id', 'left');
        $this->db->join('users u', 'u.id = t.created_by', 'left');
        $this->db->order_by('t.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Get transaction by ID
     */
    public function find($id) {
        $this->db->select('t.*, r.customer_id, c.full_name, pm.name as payment_method, u.name as created_by_name');
        $this->db->from($this->table . ' t');
        $this->db->join('rentals r', 'r.id = t.rental_id', 'left');
        $this->db->join('customers c', 'c.id = r.customer_id', 'left');
        $this->db->join('payment_methods pm', 'pm.id = t.payment_method_id', 'left');
        $this->db->join('users u', 'u.id = t.created_by', 'left');
        $this->db->where('t.id', $id);
        return $this->db->get()->row_array();
    }

    /**
     * Get transaction by rental ID
     */
    public function get_by_rental($rental_id) {
        $this->db->where('rental_id', $rental_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    /**
     * Create transaction
     */
    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update transaction
     */
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Delete transaction
     */
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Get revenue by date
     */
    public function get_revenue_by_date($date) {
        $this->db->select('DATE(paid_at) as date, SUM(amount) as total_revenue, COUNT(*) as total_transactions');
        $this->db->from($this->table);
        $this->db->where('DATE(paid_at)', $date);
        $this->db->group_by('DATE(paid_at)');
        return $this->db->get()->row_array();
    }

    /**
     * Get revenue by date range
     */
    public function get_revenue_by_range($start_date, $end_date) {
        $this->db->select('DATE(paid_at) as date, SUM(amount) as total_revenue, COUNT(*) as total_transactions');
        $this->db->from($this->table);
        $this->db->where('DATE(paid_at) >=', $start_date);
        $this->db->where('DATE(paid_at) <=', $end_date);
        $this->db->group_by('DATE(paid_at)');
        $this->db->order_by('date', 'ASC');
        return $this->db->get()->result_array();
    }

    /**
     * Get today's revenue
     */
    public function get_today_revenue() {
        return $this->get_revenue_by_date(date('Y-m-d'));
    }

    /**
     * Get total revenue
     */
    public function get_total_revenue() {
        $this->db->select('SUM(amount) as total_revenue, COUNT(*) as total_transactions');
        $this->db->from($this->table);
        return $this->db->get()->row_array();
    }

    /**
     * Get revenue by payment method
     */
    public function get_revenue_by_payment_method($start_date = null, $end_date = null) {
        $this->db->select('pm.name as payment_method, SUM(t.amount) as total_revenue, COUNT(t.id) as total_transactions');
        $this->db->from($this->table . ' t');
        $this->db->join('payment_methods pm', 'pm.id = t.payment_method_id', 'left');
        
        if ($start_date && $end_date) {
            $this->db->where('DATE(t.paid_at) >=', $start_date);
            $this->db->where('DATE(t.paid_at) <=', $end_date);
        }
        
        $this->db->group_by('pm.id');
        $this->db->order_by('total_revenue', 'DESC');
        return $this->db->get()->result_array();
    }
}
