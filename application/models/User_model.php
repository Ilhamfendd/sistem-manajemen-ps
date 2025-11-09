<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
  private $table = 'users';

  public function find_by_email($email) {
    return $this->db->get_where($this->table, ['email' => $email])->row();
  }
}
