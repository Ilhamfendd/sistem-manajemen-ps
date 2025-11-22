<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rental_model extends CI_Model {

    private $table = 'rentals';

    public function get_all() {
        $this->db->select('rentals.*, customers.full_name, consoles.console_name');
        $this->db->from($this->table);
        $this->db->join('customers', 'customers.id = rentals.customer_id');
        $this->db->join('consoles', 'consoles.id = rentals.console_id');
        return $this->db->order_by('rentals.id', 'DESC')->get()->result();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function find($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)
                        ->update($this->table, $data);
    }
    public function delete($id)
    {
    return $this->db->delete('rentals', ['id' => $id]);
    }

}
