<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rental_model extends CI_Model {

    private $table = 'rentals';

    /**
     * Get all rentals with customer and console info
     */
    public function get_all() {
        $this->db->select('rentals.*, customers.full_name, customers.customer_id, consoles.console_name, consoles.console_type, consoles.price_per_hour');
        $this->db->from($this->table);
        $this->db->join('customers', 'customers.id = rentals.customer_id');
        $this->db->join('consoles', 'consoles.id = rentals.console_id');
        return $this->db->order_by('rentals.id', 'DESC')->get()->result();
    }

    /**
     * Get ongoing rentals only
     */
    public function get_ongoing() {
        $this->db->select('rentals.*, customers.full_name, customers.customer_id, consoles.console_name, consoles.console_type, consoles.price_per_hour');
        $this->db->from($this->table);
        $this->db->join('customers', 'customers.id = rentals.customer_id');
        $this->db->join('consoles', 'consoles.id = rentals.console_id');
        $this->db->where('rentals.status', 'ongoing');
        return $this->db->order_by('rentals.id', 'DESC')->get()->result();
    }

    /**
     * Get finished rentals with transaction info
     */
    public function get_finished() {
        $this->db->select('rentals.*, customers.full_name, customers.customer_id, consoles.console_name, consoles.console_type, consoles.price_per_hour');
        $this->db->from($this->table);
        $this->db->join('customers', 'customers.id = rentals.customer_id', 'left');
        $this->db->join('consoles', 'consoles.id = rentals.console_id', 'left');
        $this->db->where('rentals.status', 'finished');
        return $this->db->order_by('rentals.id', 'DESC')->get()->result();
    }

    /**
     * Get today's rentals
     */
    public function get_today() {
        $this->db->select('rentals.*, customers.full_name, consoles.console_name');
        $this->db->from($this->table);
        $this->db->join('customers', 'customers.id = rentals.customer_id');
        $this->db->join('consoles', 'consoles.id = rentals.console_id');
        $this->db->where('DATE(rentals.created_at)', date('Y-m-d'));
        return $this->db->order_by('rentals.id', 'DESC')->get()->result();
    }

    /**
     * Find single rental
     */
    public function find($id) {
        $this->db->select('rentals.*, customers.full_name, customers.customer_id, consoles.console_name, consoles.console_type, consoles.price_per_hour');
        $this->db->from($this->table);
        $this->db->join('customers', 'customers.id = rentals.customer_id', 'left');
        $this->db->join('consoles', 'consoles.id = rentals.console_id', 'left');
        $this->db->where('rentals.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Insert rental
     */
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update rental
     */
    public function update($id, $data) {
        return $this->db->where('id', $id)
                        ->update($this->table, $data);
    }

    /**
     * Delete rental
     */
    public function delete($id) {
        return $this->db->delete('rentals', ['id' => $id]);
    }

    /**
     * Get rental with transaction details
     */
    public function get_with_transactions($id) {
        $this->db->select('rentals.*, customers.full_name, customers.customer_id, consoles.console_name, consoles.console_type, consoles.price_per_hour');
        $this->db->from($this->table);
        $this->db->join('customers', 'customers.id = rentals.customer_id', 'left');
        $this->db->join('consoles', 'consoles.id = rentals.console_id', 'left');
        $this->db->where('rentals.id', $id);
        
        $rental = $this->db->get()->row_array();
        
        if ($rental) {
            // Get transactions for this rental
            $this->db->select('transactions.*, payment_methods.name as method_name');
            $this->db->from('transactions');
            $this->db->join('payment_methods', 'payment_methods.id = transactions.payment_method_id', 'left');
            $this->db->where('transactions.rental_id', $id);
            $rental['transactions'] = $this->db->order_by('transactions.paid_at', 'DESC')->get()->result_array();
        }
        
        return $rental;
    }

    /**
     * Get revenue statistics
     */
    public function get_revenue_stats($period = 'day') {
        $this->db->select('COUNT(*) as total_rentals, SUM(rentals.total_amount) as total_revenue, AVG(rentals.total_amount) as avg_revenue');
        $this->db->from($this->table);
        
        if ($period == 'day') {
            $this->db->where('DATE(rentals.created_at)', date('Y-m-d'));
        } elseif ($period == 'month') {
            $this->db->where('YEAR(rentals.created_at)', date('Y'));
            $this->db->where('MONTH(rentals.created_at)', date('m'));
        }
        
        $this->db->where('rentals.status', 'finished');
        return $this->db->get()->row_array();
    }
}
