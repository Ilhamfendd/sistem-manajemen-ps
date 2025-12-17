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
        // Step 1: Input HP
        $data['title'] = 'Pesan Unit PS - Step 1';
        $this->load->view('booking/form_step1', $data);
    }

    public function search_customer() {
        $this->output->set_content_type('application/json');
        $customer_id = $this->input->post('customer_id');
        
        if (!$customer_id) {
            echo json_encode(['success' => false, 'message' => 'ID Pelanggan harus diisi']);
            return;
        }
        
        $customer = $this->db->where('customer_id', $customer_id)->get('customers')->row_array();
        
        if ($customer) {
            // Customer exists
            echo json_encode([
                'success' => true,
                'customer' => $customer
            ]);
        } else {
            // Customer not found
            echo json_encode([
                'success' => false,
                'message' => 'ID Pelanggan tidak ditemukan'
            ]);
        }
    }

    public function form_step2() {
        // Step 2: Input Nama (hanya untuk customer baru)
        $phone = $this->input->post('phone');
        $data['phone'] = $phone;
        $data['title'] = 'Pesan Unit PS - Step 2';
        $this->load->view('booking/form_step2', $data);
    }

    public function form_step3() {
        // Step 3: Pilih Unit PS
        $phone = $this->input->post('phone');
        $full_name = $this->input->post('full_name');
        
        // Clean up expired bookings first - restore console status if booking expired
        $this->db->where('status', 'pending');
        $this->db->where('expires_at <', date('Y-m-d H:i:s'));
        $expired_bookings = $this->db->get('bookings')->result_array();
        
        foreach ($expired_bookings as $booking) {
            // Restore console to available
            $this->db->where('id', $booking['console_id']);
            $this->db->update('consoles', ['status' => 'available']);
            
            // Mark booking as expired
            $this->db->where('id', $booking['id']);
            $this->db->update('bookings', ['status' => 'expired']);
        }
        
        // Get only available consoles (exclude di_pesan and maintenance)
        $this->db->where('status', 'available');
        $data['consoles'] = $this->db->get('consoles')->result_array();
        $data['phone'] = $phone;
        $data['full_name'] = $full_name;
        $data['title'] = 'Pesan Unit PS - Step 3';
        $this->load->view('booking/form_step3', $data);
    }

    public function form_step4() {
        // Step 4: Pilih Durasi & Konfirmasi
        $phone = $this->input->post('phone');
        $full_name = $this->input->post('full_name');
        $console_id = $this->input->post('console_id');
        
        if (!$console_id) {
            redirect('booking');
        }
        
        $console = $this->db->where('id', $console_id)->get('consoles')->row_array();
        
        $data['phone'] = $phone;
        $data['full_name'] = $full_name;
        $data['console'] = $console;
        $data['title'] = 'Pesan Unit PS - Step 4';
        $this->load->view('booking/form_step4', $data);
    }

    public function store() {
        $this->load->library('form_validation');
        
        $phone = $this->input->post('phone');
        $full_name = $this->input->post('full_name');
        $console_id = $this->input->post('console_id');
        $booking_date = $this->input->post('booking_date');
        $booking_start_time = $this->input->post('booking_start_time');
        $duration_hours = $this->input->post('duration_hours');
        
        // Validate input
        if (!$phone || !$full_name || !$console_id || !$booking_date || !$booking_start_time || !$duration_hours) {
            echo json_encode([
                'success' => false,
                'message' => 'Semua field harus diisi'
            ]);
            return;
        }
        
        // Check or create customer
        $customer = $this->db->where('phone', $phone)->get('customers')->row_array();
        if ($customer) {
            $customer_id = $customer['id'];
        } else {
            $this->db->insert('customers', [
                'full_name' => $full_name,
                'phone' => $phone,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $customer_id = $this->db->insert_id();
        }
        
        // Get console price & verify exists
        $console = $this->db->where('id', $console_id)->where('status', 'available')->get('consoles')->row_array();
        if (!$console) {
            echo json_encode([
                'success' => false,
                'message' => 'Unit tidak tersedia'
            ]);
            return;
        }
        
        // Check if console already booked for this date/time
        // A booking conflicts if it's for same console, same date, and same/overlapping time
        $this->db->where('console_id', $console_id);
        $this->db->where('booking_date', $booking_date);
        $this->db->where_in('status', ['pending', 'approved']); // Only pending/approved blocks booking
        $existing_booking = $this->db->get('bookings')->row_array();
        
        if ($existing_booking) {
            echo json_encode([
                'success' => false,
                'message' => 'Unit ini sudah di-booking untuk tanggal dan waktu yang sama. Pilih unit atau waktu lain.'
            ]);
            return;
        }
        
        $total_price = $console['price_per_hour'] * $duration_hours;
        
        // Create booking
        $booking_data = [
            'customer_id' => $customer_id,
            'console_id' => $console_id,
            'phone' => $phone,
            'full_name' => $full_name,
            'booking_date' => $booking_date,
            'booking_start_time' => $booking_start_time,
            'duration_hours' => $duration_hours,
            'estimated_cost' => $total_price,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+15 minutes'))
        ];
        
        if ($this->db->insert('bookings', $booking_data)) {
            $booking_id = $this->db->insert_id();
            
            // Set console status to 'di_pesan' (booked) to prevent double booking
            $this->db->where('id', $console_id);
            $update_result = $this->db->update('consoles', ['status' => 'di_pesan']);
            
            // Debug: Log the update result
            error_log("Console ID: $console_id, Update Result: " . ($update_result ? 'SUCCESS' : 'FAILED'));
            
            echo json_encode([
                'success' => true,
                'message' => 'Booking berhasil dibuat! Silakan tunggu persetujuan kasir.',
                'booking_id' => $booking_id
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal membuat booking'
            ]);
        }
    }

    public function approve($booking_id) {
        // Check kasir only
        $user = $this->session->userdata('user');
        if (!$user || $user['role'] != 'kasir') {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak']);
            return;
        }
        
        $booking = $this->db->where('id', $booking_id)->get('bookings')->row_array();
        if (!$booking) {
            echo json_encode(['success' => false, 'message' => 'Booking tidak ditemukan']);
            return;
        }
        
        $this->db->where('id', $booking_id);
        $this->db->update('bookings', [
            'status' => 'approved',
            'approved_at' => date('Y-m-d H:i:s')
        ]);
        
        echo json_encode(['success' => true, 'message' => 'Booking disetujui']);
    }

    public function reject($booking_id) {
        // Check kasir only
        $user = $this->session->userdata('user');
        if (!$user || $user['role'] != 'kasir') {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak']);
            return;
        }
        
        $booking = $this->db->where('id', $booking_id)->get('bookings')->row_array();
        if (!$booking) {
            echo json_encode(['success' => false, 'message' => 'Booking tidak ditemukan']);
            return;
        }
        
        $this->db->where('id', $booking_id);
        $this->db->update('bookings', ['status' => 'rejected']);
        
        // Restore console to 'available' when booking is rejected
        $this->db->where('id', $booking['console_id']);
        $this->db->update('consoles', ['status' => 'available']);
        
        echo json_encode(['success' => true, 'message' => 'Booking ditolak']);
    }

    public function customer_arrived($booking_id) {
        // Check kasir only
        $user = $this->session->userdata('user');
        if (!$user || $user['role'] != 'kasir') {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak']);
            return;
        }
        
        $booking = $this->db->where('id', $booking_id)->get('bookings')->row_array();
        
        if (!$booking || $booking['status'] != 'approved') {
            echo json_encode(['success' => false, 'message' => 'Booking tidak valid']);
            return;
        }
        
        // Create rental from booking
        $rental_data = [
            'customer_id' => $booking['customer_id'],
            'console_id' => $booking['console_id'],
            'start_time' => date('Y-m-d H:i:s'),
            'estimated_hours' => $booking['duration_hours'],
            'estimated_cost' => $booking['estimated_cost'],
            'status' => 'ongoing',
            'payment_status' => 'pending',
            'total_amount' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('rentals', $rental_data);
        $rental_id = $this->db->insert_id();
        
        // Update booking status
        $this->db->where('id', $booking_id);
        $this->db->update('bookings', ['status' => 'completed']);
        
        // Update console status
        $this->db->where('id', $booking['console_id']);
        $this->db->update('consoles', ['status' => 'in_use']);
        
        echo json_encode([
            'success' => true,
            'rental_id' => $rental_id,
            'message' => 'Pelanggan berhasil dicatat. Lanjutkan ke pembayaran.'
        ]);
    }

    public function process_payment($booking_id) {
        $booking = $this->db->where('id', $booking_id)->get('bookings')->row_array();
        
        if (!$booking || $booking['status'] != 'approved') {
            $this->session->set_flashdata('error', 'Booking tidak valid');
            redirect('booking');
            return;
        }
        
        // Create rental
        $rental_data = [
            'customer_id' => $booking['customer_id'],
            'console_id' => $booking['console_id'],
            'start_time' => date('Y-m-d H:i:s'),
            'estimated_hours' => $booking['duration_hours'],
            'estimated_cost' => $booking['estimated_cost'],
            'status' => 'ongoing',
            'payment_status' => 'paid',
            'total_amount' => $booking['estimated_cost'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('rentals', $rental_data);
        $rental_id = $this->db->insert_id();
        
        // Update booking status
        $this->db->where('id', $booking_id);
        $this->db->update('bookings', ['status' => 'completed']);
        
        // Update console status
        $this->db->where('id', $booking['console_id']);
        $this->db->update('consoles', ['status' => 'in_use']);
        
        $this->session->set_flashdata('success', 'Rental berhasil dibuat');
        redirect('rentals');
    }

    public function booking_status($booking_id) {
        // Get booking details
        $this->db->select('b.*, c.console_name, c.console_type, c.price_per_hour');
        $this->db->from('bookings b');
        $this->db->join('consoles c', 'c.id = b.console_id', 'left');
        $this->db->where('b.id', $booking_id);
        $booking = $this->db->get()->row_array();
        
        if (!$booking) {
            $this->session->set_flashdata('error', 'Booking tidak ditemukan');
            redirect('home');
        }
        
        // Calculate remaining time if approved
        $data['remaining_time'] = null;
        if ($booking['status'] == 'approved' && $booking['approved_at']) {
            $approved_time = strtotime($booking['approved_at']);
            $expire_time = $approved_time + (15 * 60); // 15 minutes
            $remaining = $expire_time - time();
            $data['remaining_time'] = max(0, $remaining); // Don't show negative
        }
        
        $data['booking'] = $booking;
        $data['title'] = 'Status Booking';
        $this->load->view('booking/status', $data);
    }

    public function customer_bookings($phone) {
        // Get all bookings for this customer
        $this->db->select('b.*, c.console_name, c.console_type, c.price_per_hour');
        $this->db->from('bookings b');
        $this->db->join('consoles c', 'c.id = b.console_id', 'left');
        $this->db->where('b.phone', $phone);
        $this->db->order_by('b.created_at', 'DESC');
        $data['bookings'] = $this->db->get()->result_array();
        
        $data['phone'] = $phone;
        $data['title'] = 'Daftar Booking Saya';
        $this->load->view('booking/customer_bookings', $data);
    }

    /**
     * Generate customer ID via AJAX (for booking new customer)
     */
    public function generate_customer_id() {
        $this->output->set_content_type('application/json');
        
        $customer_id = $this->Customer_model->generate_customer_id();
        
        if ($customer_id) {
            echo json_encode([
                'success' => true,
                'customer_id' => $customer_id
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Tidak dapat generate ID (mungkin sudah 9999 pelanggan tahun ini)'
            ]);
        }
    }}