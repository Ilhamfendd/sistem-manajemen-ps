<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller {
  public function __construct() {
    parent::__construct();
    $this->require_role(['admin','staff']);
    $this->load->model('Customer_model');
    $this->load->library('form_validation');
    $this->load->helper(array('form','url'));
  }

  public function index() {
    $q = trim($this->input->get('q', TRUE));
    $data['title'] = 'Customers';
    $data['q'] = $q;
    $data['items'] = $this->Customer_model->all($q);
    $this->load->view('layouts/header', $data);
    $this->load->view('customers/index', $data);
    $this->load->view('layouts/footer');
  }

  public function create() {
    $data['title'] = 'Add Customer';
    $data['item'] = null;
    $this->load->view('layouts/header', $data);
    $this->load->view('customers/form', $data);
    $this->load->view('layouts/footer');
  }

  public function store() {
    $this->_set_rules();

    if ($this->form_validation->run() === FALSE) {
      return $this->create();
    }
    $payload = [
      'full_name' => $this->input->post('full_name', TRUE),
      'phone'     => $this->input->post('phone', TRUE),
      'note'      => $this->input->post('note', TRUE),
    ];
    $this->Customer_model->insert($payload);
    $this->session->set_flashdata('success','Customer created.');
    redirect('customers');
  }

  public function edit($id) {
    $item = $this->Customer_model->find($id);
    if (!$item) show_404();

    $data['title'] = 'Edit Customer';
    $data['item'] = $item;
    $this->load->view('layouts/header', $data);
    $this->load->view('customers/form', $data);
    $this->load->view('layouts/footer');
  }

  public function update($id) {
    $item = $this->Customer_model->find($id);
    if (!$item) show_404();

    $this->_set_rules();
    if ($this->form_validation->run() === FALSE) {
      return $this->edit($id);
    }
    $payload = [
      'full_name' => $this->input->post('full_name', TRUE),
      'phone'     => $this->input->post('phone', TRUE),
      'note'      => $this->input->post('note', TRUE),
    ];
    $this->Customer_model->update($id, $payload);
    $this->session->set_flashdata('success','Customer updated.');
    redirect('customers');
  }

  public function delete($id) {
    $item = $this->Customer_model->find($id);
    if (!$item) show_404();

    $this->Customer_model->delete($id);
    $this->session->set_flashdata('success','Customer deleted.');
    redirect('customers');
  }

  private function _set_rules() {
    $this->form_validation->set_rules('full_name','Full Name','required|min_length[3]|max_length[120]');
    $this->form_validation->set_rules('phone','Phone','max_length[30]');
    $this->form_validation->set_rules('note','Note','max_length[65535]');
  }
}
