<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('User_model');
    $this->load->library(['form_validation','session']);
    $this->load->helper(['form','url']);
  }

  public function login() {
    if ($this->session->userdata('user')) {
      redirect('dashboard');
    }

    if ($this->input->method() === 'post') {
      $this->form_validation->set_rules('email','Email','required|valid_email');
      $this->form_validation->set_rules('password','Password','required');

      if ($this->form_validation->run()) {
        $email = $this->input->post('email', TRUE);
        $password = $this->input->post('password');

        $user = $this->User_model->find_by_email($email);

        // 🔹 perbandingan langsung (tanpa hash)
        if ($user && $user->password === $password) {
          $this->session->set_userdata('user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role
          ]);
          redirect('dashboard');
        } else {
          $this->session->set_flashdata('error', 'Email atau password salah.');
        }
      }
    }

    $this->load->view('auth/login');
  }

  public function logout() {
    $this->session->unset_userdata('user');
    $this->session->sess_destroy();
    redirect('login');
  }
}
