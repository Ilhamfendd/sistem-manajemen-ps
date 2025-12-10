<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->require_role('kasir');
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->helper(['form', 'url']);
    }

    public function index() {
        $data['title'] = 'Manajemen User';
        $data['items'] = $this->User_model->get_all();
        $this->load->view('users/index', $data);
    }

    public function create() {
        $data['title'] = 'Tambah User';
        $data['user'] = null; // Pass null untuk form.php
        $this->load->view('users/form', $data);
    }

    public function store() {
        $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[kasir,owner]');

        if ($this->form_validation->run()) {
            $data = [
                'name' => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'password' => $this->input->post('password'),
                'role' => $this->input->post('role', TRUE),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->User_model->insert($data)) {
                $this->session->set_flashdata('success', 'User berhasil ditambahkan');
                redirect('users');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan user');
            }
        }

        $data['title'] = 'Tambah User';
        $this->load->view('users/form', $data);
    }

    public function edit($id) {
        $data['user'] = $this->User_model->get_by_id($id);
        
        if (!$data['user']) {
            show_404();
        }

        $data['title'] = 'Edit User';
        $this->load->view('users/form', $data);
    }

    public function update($id) {
        $user = $this->User_model->get_by_id($id);
        
        if (!$user) {
            show_404();
        }

        $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[kasir,owner]');

        if ($this->form_validation->run()) {
            $data = [
                'name' => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'role' => $this->input->post('role', TRUE)
            ];

            $password = $this->input->post('password');
            if (!empty($password)) {
                $data['password'] = $password;
            }

            if ($this->User_model->update($id, $data)) {
                $this->session->set_flashdata('success', 'User berhasil diupdate');
                redirect('users');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate user');
            }
        }

        $data['user'] = $user;
        $data['title'] = 'Edit User';
        $this->load->view('users/form', $data);
    }

    public function delete($id) {
        $user = $this->User_model->get_by_id($id);
        
        if (!$user) {
            show_404();
        }

        if ($this->User_model->delete($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user');
        }

        redirect('users');
    }
}
