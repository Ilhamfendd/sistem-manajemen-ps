<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
  protected $current_user;

  public function __construct() {
    parent::__construct();
    $this->current_user = $this->session->userdata('user');
  }

  protected function require_login() {
    if (!$this->current_user) {
      redirect('login');
    }
  }
}
