<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->model('Customer_model');
        $this->load->model('Console_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->db->where('status', 'available');
        $data['consoles'] = $this->db->get('consoles')->result_array();
        $data['title'] = 'Pesan Unit PS';
        $this->load->view('booking/index', $data);
    }

    public function search_customer() {
        $phone = $this->input->post('phone');
        $customer = $this->db->where('phone', $phone)->get('customers')->row_array();
        
        if ($customer) {
            echo json_encode(['success' => true, 'is_existing' => true, 'customer' => $customer]);
        } else {
            echo json_encode(['success' => true, 'is_existing' => false]);
        }
    }

    public function booking_form() {
        $console_id = $this->input->post('console_id');
        $phone = $this->input->post('phone');
        $full_name = $this->input->post('full_name');
        $this->db->where('id', $console_id);
        $console = $this->db->get('consoles')->row_array();
        $data['console'] = $console;
        $data['phone'] = $phone;
        $data['full_name'] = $full_name;
        $data['title'] = 'Form Booking';
        $this->load->view('booking/form', $data);
    }

    public function store() {
        $phone = $this->input->post('phone');
        $full_name = $this->input->post('full_name');
        $console_id = $this->input->post('console_id');
        $booking_date = $this->input->post('booking_date');
        $booking_start_time = $this->input->post('booking_start_time');
        $duration_hours = $this->input->post('duration_hours');
        $customer = $this->db->where('phone', $phone)->get('customers')->row_array();
        if ($customer) {
            $customer_id = $customer['id'];
        } else {
            $this->db->insert('customers', ['full_name' => $full_name, 'phone' => $phone, 'created_at' => date('Y-m-d H:i:s')]);
            $customer_id = $this->db->insert_id();
        }
        $console = $this->db->where('id', $console_id)->get('consoles')->row_array();
        $total_price = $console['price_per_hour'] * $duration_hours;
        $booking_data = ['customer_id' => $customer_id, 'console_id' => $console_id, 'phone' => $phone, 'full_name' => $full_name, 'booking_date' => $booking_date, 'booking_start_time' => $booking_start_time, 'duration_hours' => $duration_hours, 'estimated_cost' => $total_price, 'status' => 'pending', 'created_at' => date('Y-m-d H:i:s'), 'expires_at' => date('Y-m-d H:i:s', strtotime('+24 hours'))];
        $this->db->insert('bookings', $booking_data);
        $booking_id = $this->db->insert_id();
        echo json_encode(['success' => true, 'booking_id' => $booking_id, 'message' => 'Booking berhasil dibuat!']);
    }

    public function manage() {
        if ($this->session->userdata('role') != 'kasir') redirect('home');
        $this->db->select('b.*, c.console_name, c.console_type, c.price_per_hour');
        $this->db->from('bookings b');
        $this->db->join('consoles c', 'c.id = b.console_id', 'left');
        $this->db->where('b.status', 'pending');
        $data['pending'] = $this->db->get()->result_array();
        $this->db->select('b.*, c.console_name, c.console_type, c.price_per_hour');
        $this->db->from('bookings b');
        $this->db->join('consoles c', 'c.id = b.console_id', 'left');
        $this->db->where('b.status', 'approved');
        $data['approved'] = $this->db->get()->result_array();
        $data['title'] = 'Manage Booking Online';
        $this->load->view('booking/manage', $data);
    }

    public function approve($booking_id) {
        $this->db->where('id', $booking_id);
        $this->db->update('bookings', ['status' => 'approved', 'approved_at' => date('Y-m-d H:i:s')]);
        echo json_encode(['success' => true, 'message' => 'Booking disetujui']);
    }

    public function reject($booking_id) {
        $this->db->where('id', $booking_id);
        $this->db->delete('bookings');
        echo json_encode(['success' => true, 'message' => 'Booking ditolak']);
    }

    public function process_payment($booking_id) {
        $booking = $this->db->where('id', $booking_id)->get('bookings')->row_array();
        if (!$booking || $booking['status'] != 'approved') {
            $this->session->set_flashdata('error', 'Booking tidak valid');
            redirect('booking');
            return;
        }
        $rental_data = ['customer_id' => $booking['customer_id'], 'console_id' => $booking['console_id'], 'start_time' => date('Y-m-d H:i:s'), 'estimated_hours' => $booking['duration_hours'], 'estimated_cost' => $booking['estimated_cost'], 'status' => 'ongoing', 'payment_status' => 'paid', 'total_amount' => $booking['estimated_cost'], 'created_at' => date('Y-m-d H:i:s')];
        $this->db->insert('rentals', $rental_data);
        $rental_id = $this->db->insert_id();
        $this->db->where('id', $booking_id);
        $this->db->update('bookings', ['status' => 'completed']);
        $this->db->where('id', $booking['console_id']);
        $this->db->update('consoles', ['status' => 'in_use']);
        $this->session->set_flashdata('success', 'Rental berhasil dibuat');
        redirect('rentals');
    }
}