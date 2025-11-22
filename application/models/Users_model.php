<?php
class User_model extends CI_Model {

    public function get_all() {
        return $this->db->get('users')->result();
    }
}
