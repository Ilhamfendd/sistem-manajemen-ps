<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->load->database();
    }

    public function index() {
        $data['title'] = 'Dashboard';

        // Ambil total pelanggan
        if ($this->db->table_exists('customers')) {
            $data['total_customers'] = $this->db->count_all('customers');
        } else {
            $data['total_customers'] = 0;
        }

        // Ambil total unit PS
        if ($this->db->table_exists('consoles')) {
            $data['total_consoles']  = $this->db->count_all('consoles');

            // Console available
            $this->db->where('status', 'available');
            $data['total_available'] = $this->db->count_all_results('consoles');

            // Console in use
            $this->db->where('status', 'in_use');
            $data['total_in_use'] = $this->db->count_all_results('consoles');
        } else {
            $data['total_consoles']  = 0;
            $data['total_available'] = 0;
            $data['total_in_use']    = 0;
        }

        $this->load->view('dashboard/index', $data);
    }
}
