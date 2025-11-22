<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Consoles extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->load->model('Console_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = 'Unit PlayStation';
        $data['items'] = $this->Console_model->get_all();

        $this->load->view('consoles/index', $data);
    }

    public function create() {
        $data['title'] = 'Tambah Unit PlayStation';
        $this->load->view('consoles/form', $data);
    }

    public function store() {
        $this->form_validation->set_rules('console_name', 'Nama Unit', 'required');
        $this->form_validation->set_rules('console_type', 'Tipe Konsol', 'required');

        if ($this->form_validation->run() == FALSE) {
            return $this->create();
        }

        $payload = [
            'console_name' => $this->input->post('console_name', TRUE),
            'console_type' => $this->input->post('console_type', TRUE),
            'status'       => $this->input->post('status', TRUE),
            'note'         => $this->input->post('note', TRUE)
        ];

        $this->Console_model->insert($payload);
        $this->session->set_flashdata('success', 'Unit berhasil ditambahkan.');
        redirect('consoles');
    }

    public function edit($id) {
        $data['item'] = $this->Console_model->find($id);
        if (!$data['item']) show_404();

        $data['title'] = 'Edit Unit';
        $this->load->view('consoles/form', $data);
    }

    public function update($id) {
        $this->form_validation->set_rules('console_name', 'Nama Unit', 'required');
        $this->form_validation->set_rules('console_type', 'Tipe Konsol', 'required');

        if ($this->form_validation->run() == FALSE) {
            return $this->edit($id);
        }

        $payload = [
            'console_name' => $this->input->post('console_name', TRUE),
            'console_type' => $this->input->post('console_type', TRUE),
            'status'       => $this->input->post('status', TRUE),
            'note'         => $this->input->post('note', TRUE)
        ];

        $this->Console_model->update($id, $payload);
        $this->session->set_flashdata('success', 'Unit berhasil diperbarui.');

        redirect('consoles');
    }

    public function delete($id) {
        $this->Console_model->delete($id);
        $this->session->set_flashdata('success', 'Unit berhasil dihapus.');
        redirect('consoles');
    }
}
