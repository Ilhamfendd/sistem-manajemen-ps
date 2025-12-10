<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consoles extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->require_kasir();  // KASIR ONLY
        
        $this->load->model(['Console_model', 'Payment_method_model']);
        $this->load->library('form_validation');
    }

    /**
     * List all consoles
     */
    public function index() {
        $data['title'] = 'Manajemen Unit PlayStation';
        $data['items'] = $this->Console_model->get_all();

        $this->load->view('consoles/index', $data);
    }

    /**
     * Create new console
     */
    public function create() {
        $data['title'] = 'Tambah Unit PlayStation';
        $data['console_types'] = ['PS3' => 'PlayStation 3', 'PS4' => 'PlayStation 4', 'PS5' => 'PlayStation 5'];
        
        $this->load->view('consoles/form', $data);
    }

    /**
     * Store new console
     */
    public function store() {
        $this->form_validation->set_rules('console_name', 'Nama Unit', 'required|trim');
        $this->form_validation->set_rules('console_type', 'Tipe Konsol', 'required');
        $this->form_validation->set_rules('price_per_hour', 'Harga Per Jam', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            return $this->create();
        }

        $payload = [
            'console_name' => $this->input->post('console_name', TRUE),
            'console_type' => $this->input->post('console_type', TRUE),
            'price_per_hour' => $this->input->post('price_per_hour', TRUE),
            'status' => 'available',
            'note' => $this->input->post('note', TRUE)
        ];

        $this->Console_model->insert($payload);
        $this->session->set_flashdata('success', 'Unit berhasil ditambahkan.');
        redirect('consoles');
    }

    /**
     * Edit console
     */
    public function edit($id) {
        $data['item'] = $this->Console_model->find($id);
        if (!$data['item']) show_404();

        $data['title'] = 'Edit Unit PlayStation';
        $data['console_types'] = ['PS3' => 'PlayStation 3', 'PS4' => 'PlayStation 4', 'PS5' => 'PlayStation 5'];
        
        // Get price history
        $this->db->where('console_id', $id);
        $this->db->join('users', 'users.id = console_price_history.changed_by', 'left');
        $this->db->order_by('console_price_history.changed_at', 'DESC');
        $data['price_history'] = $this->db->get('console_price_history')->result_array();

        $this->load->view('consoles/form', $data);
    }

    /**
     * Update console
     */
    public function update($id) {
        $this->form_validation->set_rules('console_name', 'Nama Unit', 'required|trim');
        $this->form_validation->set_rules('console_type', 'Tipe Konsol', 'required');
        $this->form_validation->set_rules('price_per_hour', 'Harga Per Jam', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == FALSE) {
            return $this->edit($id);
        }

        // Get old price for history
        $old_console = $this->Console_model->find($id);
        $old_price = $old_console->price_per_hour;
        $new_price = $this->input->post('price_per_hour', TRUE);

        // Update console
        $payload = [
            'console_name' => $this->input->post('console_name', TRUE),
            'console_type' => $this->input->post('console_type', TRUE),
            'price_per_hour' => $new_price,
            'status' => $this->input->post('status', TRUE),
            'note' => $this->input->post('note', TRUE)
        ];

        $this->Console_model->update($id, $payload);

        // Record price change history if price changed
        if ($old_price != $new_price) {
            $history = [
                'console_id' => $id,
                'old_price' => $old_price,
                'new_price' => $new_price,
                'changed_by' => $this->get_user_id(),
                'changed_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('console_price_history', $history);
        }

        $this->session->set_flashdata('success', 'Unit berhasil diperbarui.');
        redirect('consoles');
    }

    /**
     * Delete console
     */
    public function delete($id) {
        $console = $this->Console_model->find($id);
        if (!$console) show_404();

        // Check if console has active rentals
        $this->db->where('console_id', $id);
        $this->db->where('status', 'ongoing');
        $active_rentals = $this->db->count_all_results('rentals');

        if ($active_rentals > 0) {
            $this->session->set_flashdata('error', 'Tidak bisa menghapus unit yang sedang digunakan!');
            redirect('consoles');
            return;
        }

        $this->Console_model->delete($id);
        $this->session->set_flashdata('success', 'Unit berhasil dihapus.');
        redirect('consoles');
    }

    /**
     * View price history for a console
     */
    public function price_history($console_id) {
        $console = $this->Console_model->find($console_id);
        if (!$console) show_404();

        $data['title'] = 'Riwayat Harga - ' . $console['console_name'];
        $data['console'] = $console;

        // Get price history with user info
        $this->db->where('console_id', $console_id);
        $this->db->join('users', 'users.id = console_price_history.changed_by', 'left');
        $this->db->order_by('console_price_history.changed_at', 'DESC');
        $data['history'] = $this->db->get('console_price_history')->result_array();

        $this->load->view('consoles/price_history', $data);
    }

    /**
     * Bulk update status
     */
    public function bulk_status() {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $console_ids = $this->input->post('console_ids');
        $new_status = $this->input->post('status');

        if (empty($console_ids) || !is_array($console_ids)) {
            echo json_encode(['success' => false, 'message' => 'Tidak ada console yang dipilih']);
            return;
        }

        foreach ($console_ids as $id) {
            $this->db->where('id', $id);
            $this->db->update('consoles', ['status' => $new_status]);
        }

        $this->session->set_flashdata('success', 'Status berhasil diperbarui untuk ' . count($console_ids) . ' unit.');
        redirect('consoles');
    }

    /**
     * Console status report
     */
    public function report() {
        $data['title'] = 'Laporan Status Unit';

        // Status breakdown
        $this->db->select('status, COUNT(*) as count');
        $this->db->from('consoles');
        $this->db->group_by('status');
        $data['status_report'] = $this->db->get()->result_array();

        // Console by type
        $this->db->select('console_type, COUNT(*) as count, AVG(price_per_hour) as avg_price, MIN(price_per_hour) as min_price, MAX(price_per_hour) as max_price');
        $this->db->from('consoles');
        $this->db->group_by('console_type');
        $data['type_report'] = $this->db->get()->result_array();

        // Price list
        $this->db->select('id, console_name, console_type, price_per_hour, status');
        $this->db->from('consoles');
        $this->db->order_by('console_type, console_name');
        $data['price_list'] = $this->db->get()->result_array();

        $this->load->view('consoles/report', $data);
    }
}
