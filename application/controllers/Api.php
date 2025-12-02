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
}
