<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        echo "Test Pesan Controller";
    }
}
