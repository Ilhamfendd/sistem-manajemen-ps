<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        header('Content-Type: application/json');
    }

    /**
     * Get total units
     */
    public function total_units() {
        $count = $this->db->count_all('consoles');
        echo json_encode([
            'success' => true,
            'total' => $count
        ]);
    }

    /**
     * Get available units count
     */
    public function available_units() {
        $this->db->where('status', 'available');
        $count = $this->db->count_all_results('consoles');
        echo json_encode([
            'success' => true,
            'total' => $count
        ]);
    }

    /**
     * Get in-use units count
     */
    public function in_use_units() {
        $this->db->where('status', 'in_use');
        $count = $this->db->count_all_results('consoles');
        echo json_encode([
            'success' => true,
            'total' => $count
        ]);
    }

    /**
     * Debug endpoint - check approved bookings and expires_at
     */
    public function debug_approved_bookings() {
        $this->db->select('b.id, b.full_name, b.status, b.approved_at, b.expires_at');
        $this->db->from('bookings b');
        $this->db->where('b.status', 'approved');
        $this->db->order_by('b.approved_at', 'DESC');
        $bookings = $this->db->get()->result_array();
        
        $debug = [
            'server_time' => date('Y-m-d H:i:s'),
            'server_timestamp' => time(),
            'total_approved_bookings' => count($bookings),
            'bookings' => $bookings
        ];
        
        echo json_encode($debug, JSON_PRETTY_PRINT);
    }
}
