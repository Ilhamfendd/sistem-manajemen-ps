<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Console_model');
        $this->load->model('Payment_method_model');
        $this->load->library('form_validation');
    }

    /**
     * Public Landing Page
     * Menampilkan informasi GO-KOPI dan ketersediaan unit
     */
    public function index() {
        $data['title'] = 'GO-KOPI - Rental PlayStation';
        
        // Get available consoles
        $this->db->where('status', 'available');
        $this->db->order_by('console_type', 'ASC');
        $data['available_consoles'] = $this->db->get('consoles')->result_array();
        
        // Count available by type
        $this->db->select('console_type, COUNT(*) as count');
        $this->db->from('consoles');
        $this->db->where('status', 'available');
        $this->db->group_by('console_type');
        $data['console_stats'] = $this->db->get()->result_array();
        
        $this->load->view('home/index', $data);
    }

    /**
     * Get available units - API endpoint
     * Return JSON dengan unit yang tersedia
     */
    public function get_available_units() {
        header('Content-Type: application/json');
        
        $this->db->where('status', 'available');
        $this->db->select('id, console_name, console_type, price_per_hour, status');
        $this->db->order_by('console_type, console_name', 'ASC');
        $units = $this->db->get('consoles')->result_array();
        
        echo json_encode([
            'success' => true,
            'total' => count($units),
            'data' => $units
        ]);
    }

    /**
     * Pricing Information
     * Menampilkan info harga rental
     */
    public function pricing() {
        $data['title'] = 'Pricing - GO-KOPI';
        
        // Get all console types dengan pricing
        $this->db->select('console_type, COUNT(*) as total, AVG(price_per_hour) as avg_price');
        $this->db->from('consoles');
        $this->db->group_by('console_type');
        $data['pricing'] = $this->db->get()->result_array();
        
        $this->load->view('home/pricing', $data);
    }

    /**
     * About Page
     */
    public function about() {
        $data['title'] = 'Tentang GO-KOPI';
        $this->load->view('home/about', $data);
    }

    /**
     * Contact / Inquiry Form
     */
    public function contact() {
        $data['title'] = 'Hubungi Kami - GO-KOPI';
        
        if ($this->input->method() === 'post') {
            // Validate form
            $this->form_validation->set_rules('name', 'Nama', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
            $this->form_validation->set_rules('phone', 'Nomor Telepon', 'required|trim');
            $this->form_validation->set_rules('message', 'Pesan', 'required|trim');
            
            if ($this->form_validation->run()) {
                // Store inquiry (optional - bisa disimpan ke database atau email)
                $inquiry = [
                    'name' => $this->input->post('name', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'message' => $this->input->post('message', TRUE),
                    'received_at' => date('Y-m-d H:i:s')
                ];
                
                // Log or save inquiry
                log_message('info', 'Inquiry received from: ' . $inquiry['email']);
                
                $this->session->set_flashdata('success', 'Terima kasih! Pesan Anda telah kami terima. Kami akan menghubungi Anda segera.');
                redirect('contact');
            }
        }
        
        $this->load->view('home/contact', $data);
    }

    /**
     * FAQ Page
     */
    public function faq() {
        $data['title'] = 'FAQ - GO-KOPI';
        $data['faqs'] = [
            [
                'q' => 'Bagaimana cara menyewa PS di GO-KOPI?',
                'a' => 'Anda bisa langsung datang ke toko kami dan memilih unit yang ingin disewa. Kasir kami akan membantu proses sewa dan pembayaran. Waktu sewa dihitung per jam.'
            ],
            [
                'q' => 'Berapa harga penyewaan?',
                'a' => 'Harga tergantung tipe console. PS4 biasanya Rp 5.000/jam, PS5 bisa lebih tinggi. Cek halaman Pricing untuk detail.'
            ],
            [
                'q' => 'Metode pembayaran apa yang diterima?',
                'a' => 'Saat ini kami menerima pembayaran tunai. Pengembangan untuk metode lain sedang dalam proses.'
            ],
            [
                'q' => 'Apakah ada deposit atau jaminan?',
                'a' => 'Untuk sekarang tidak ada. Pembayaran cukup saat Anda selesai bermain.'
            ],
            [
                'q' => 'Apakah ada game terbaru?',
                'a' => 'Ya, kami selalu update koleksi game terbaru. Silakan tanyakan langsung ke kasir kami.'
            ],
            [
                'q' => 'Bagaimana dengan kebijakan waktu?',
                'a' => 'Waktu sewa dihitung dari saat mulai bermain hingga selesai. Jika melebihi 1 jam penuh, dibulatkan ke atas.'
            ]
        ];
        
        $this->load->view('home/faq', $data);
    }

    /**
     * Availability Check API
     * Check ketersediaan unit by console_type
     */
    public function check_availability($console_type = null) {
        header('Content-Type: application/json');
        
        if ($console_type) {
            $this->db->where('console_type', $console_type);
        }
        
        $this->db->select('console_type, COUNT(*) as available_count');
        $this->db->from('consoles');
        $this->db->where('status', 'available');
        
        if ($console_type) {
            $this->db->group_by('console_type');
            $result = $this->db->get()->row_array();
        } else {
            $this->db->group_by('console_type');
            $result = $this->db->get()->result_array();
        }
        
        echo json_encode([
            'success' => true,
            'data' => $result
        ]);
    }
}
