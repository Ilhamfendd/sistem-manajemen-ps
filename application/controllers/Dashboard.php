<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
  public function __construct() {
    parent::__construct();
    $this->require_login();
  }

  public function index() {
    $data['title'] = 'Dashboard';
    $this->load->view('layouts/header', $data);
    $this->load->view('dashboard/index');
    $this->load->view('layouts/footer');
  }
}
