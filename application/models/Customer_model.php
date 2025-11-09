<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {
  private $table = 'customers';

  public function all($q = '') {
    if ($q !== '') {
      $this->db->group_start()
        ->like('full_name', $q)
        ->or_like('phone', $q)
        ->group_end();
    }
    $this->db->order_by('id','DESC');
    return $this->db->get($this->table)->result();
  }

  public function find($id) {
    return $this->db->get_where($this->table, ['id' => $id])->row();
  }

  public function insert($data) {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  public function update($id, $data) {
    $this->db->where('id', $id)->update($this->table, $data);
    return $this->db->affected_rows();
  }

  public function delete($id) {
    $this->db->delete($this->table, ['id' => $id]);
    return $this->db->affected_rows();
  }
}
