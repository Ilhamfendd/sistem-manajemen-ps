<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->require_kasir();  // KASIR ONLY
        $this->load->model('Customer_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = 'Data Pelanggan';
        $data['items'] = $this->Customer_model->get_all();

        $this->load->view('customers/index', $data);
    }

    public function create() {
        $data['title'] = 'Tambah Pelanggan';
        $this->load->view('customers/form', $data);
    }

    public function store() {
        $this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('customer_id', 'ID Pelanggan', 'required|is_unique[customers.customer_id]');

        if ($this->form_validation->run() == FALSE) {
            return $this->create();
        }

        $payload = [
            'full_name' => $this->input->post('full_name', TRUE),
            'customer_id' => $this->input->post('customer_id', TRUE),
            'note' => $this->input->post('note', TRUE),
        ];

        $customer_id = $this->Customer_model->insert($payload);
        
        // Redirect ke halaman show QR code
        redirect('customers/show_qr/' . $customer_id);
    }

    public function edit($id) {
        $data['item'] = $this->Customer_model->find($id);
        if (!$data['item']) show_404();

        $data['title'] = 'Edit Pelanggan';
        $this->load->view('customers/form', $data);
    }

    public function update($id) {
        $this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('phone', 'No. Telepon', 'required');

        if ($this->form_validation->run() == FALSE) {
            return $this->edit($id);
        }

        $payload = [
            'full_name' => $this->input->post('full_name', TRUE),
            'phone'     => $this->input->post('phone', TRUE),
            'note'      => $this->input->post('note', TRUE),
        ];

        $this->Customer_model->update($id, $payload);
        $this->session->set_flashdata('success', 'Data pelanggan berhasil diperbarui.');

        redirect('customers');
    }

    public function delete($id) {
        $this->Customer_model->delete($id);
        redirect('customers');
    }

    /**
     * Generate customer ID via AJAX
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
    }

    /**
     * Show QR code after customer registration
     */
    public function show_qr($id) {
        $data['customer'] = $this->Customer_model->find($id);
        if (!$data['customer']) show_404();

        $data['title'] = 'ID Pelanggan - ' . $data['customer']->full_name;
        $this->load->view('customers/show_qr', $data);
    }
