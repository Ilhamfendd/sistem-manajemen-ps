<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    // proteksi login
    protected function require_login() {
        if (!$this->session->userdata('user')) {
            redirect('login');
        }
    }

    // hanya 1 role
    protected function require_role($role) {
        $user = $this->session->userdata('user');
        if (!$user || $user['role'] !== $role) {
            show_error('Akses ditolak.', 403);
        }
    }

    // boleh beberapa role
    protected function require_any_role($roles = []) {
        $user = $this->session->userdata('user');
        if (!$user || !in_array($user['role'], $roles)) {
            show_error('Akses ditolak.', 403);
        }
    }
}
