<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'bookings';
    }

    /**
     * Create new booking
     */
    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['expires_at'] = date('Y-m-d H:i:s', strtotime('+24 hours'));
        return $this->db->insert($this->table, $data);
    }

    /**
     * Get booking by ID
     */
    public function get($id) {
        return $this->db->where('id', $id)
                        ->get($this->table)
                        ->row_array();
    }

    /**
     * Get all pending bookings (for kasir dashboard)
     */
    public function get_pending() {
        return $this->db->select('b.*, cust.full_name, cust.customer_id, c.console_name, c.console_type, c.price_per_hour')
                        ->from('bookings b')
                        ->join('customers cust', 'cust.id = b.customer_id', 'left')
                        ->join('consoles c', 'c.id = b.console_id', 'left')
                        ->where('b.status', 'pending')
                        ->where('b.expires_at > ', date('Y-m-d H:i:s'))
                        ->order_by('b.created_at', 'DESC')
                        ->get()
                        ->result_array();
    }

    /**
     * Get all approved bookings (for today/upcoming)
     */
    public function get_approved() {
        return $this->db->select('b.*, cust.full_name, cust.customer_id, c.console_name, c.console_type, c.price_per_hour')
                        ->from('bookings b')
                        ->join('customers cust', 'cust.id = b.customer_id', 'left')
                        ->join('consoles c', 'c.id = b.console_id', 'left')
                        ->where('b.status', 'approved')
                        ->where('b.booking_date >=', date('Y-m-d'))
                        ->order_by('b.booking_date', 'ASC')
                        ->get()
                        ->result_array();
    }

    /**
     * Approve booking by kasir
     */
    public function approve($id, $notes = null) {
        return $this->db->where('id', $id)
                        ->update($this->table, [
                            'status' => 'approved',
                            'approved_at' => date('Y-m-d H:i:s'),
                            'notes' => $notes
                        ]);
    }

    /**
     * Reject booking by kasir
     */
    public function reject($id, $notes = null) {
        return $this->db->where('id', $id)
                        ->delete($this->table);
    }

    /**
     * Mark as paid (when customer pays)
     */
    public function mark_paid($id, $customer_id) {
        return $this->db->where('id', $id)
                        ->update($this->table, [
                            'customer_id' => $customer_id,
                            'payment_status' => 'paid',
                            'status' => 'completed',
                            'paid_at' => date('Y-m-d H:i:s')
                        ]);
    }

    /**
     * Auto-cancel expired bookings (run via cron/task)
     */
    public function auto_cancel_expired() {
        return $this->db->where('status', 'pending')
                        ->where('expires_at <=', date('Y-m-d H:i:s'))
                        ->update($this->table, [
                            'status' => 'expired'
                        ]);
    }

    /**
     * Get booking with console details
     */
    public function get_with_details($id) {
        return $this->db->select('b.*, c.console_name, c.console_type, c.price_per_hour')
                        ->from('bookings b')
                        ->join('consoles c', 'c.id = b.console_id', 'left')
                        ->where('b.id', $id)
                        ->get()
                        ->row_array();
    }

    /**
     * Check if console available on specific date/time
     */
    public function is_console_available($console_id, $booking_date, $booking_start_time, $duration_hours, $exclude_booking_id = null) {
        $booking_end_time = date('H:i:s', strtotime("+{$duration_hours} hours", strtotime($booking_start_time)));
        
        $query = $this->db->select('COUNT(*) as count')
                          ->from('bookings')
                          ->where('console_id', $console_id)
                          ->where('booking_date', $booking_date)
                          ->where('status !=', 'rejected')
                          ->where('status !=', 'expired');

        // Check for time conflict
        $query->where("(
            (booking_start_time < '$booking_end_time' AND DATE_ADD(CONCAT(booking_date, ' ', booking_start_time), INTERVAL duration_hours HOUR) > '$booking_start_time')
        )");

        if ($exclude_booking_id) {
            $query->where('id !=', $exclude_booking_id);
        }

        $result = $query->get()->row_array();
        return $result['count'] == 0;
    }
}
