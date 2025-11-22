<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->require_role('admin');
        $this->load->model('User_model');
    }

    public function index() {
        $data['title'] = 'Manajemen User';
        $data['items'] = $this->User_model->get_all();
        $this->load->view('users/index', $data);
    }
}
