<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debts extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->require_kasir();  // KASIR ONLY
        $this->load->model('Rental_model');
        $this->load->model('Customer_model');
    }

    /**
     * List all customers with outstanding debt
     */
    public function index() {
        // Get all finished rentals with payment status partial or pending
        $this->db->select('rentals.id, rentals.customer_id, rentals.console_id, rentals.total_amount, rentals.status, rentals.payment_status, rentals.end_time, customers.full_name, customers.customer_id, consoles.console_name');
        $this->db->from('rentals');
        $this->db->join('customers', 'customers.id = rentals.customer_id', 'left');
        $this->db->join('consoles', 'consoles.id = rentals.console_id', 'left');
        $this->db->where('rentals.status', 'finished');
        $this->db->where_in('rentals.payment_status', ['partial', 'pending']);
        $this->db->order_by('rentals.end_time', 'DESC');
        
        $debts_raw = $this->db->get()->result();

        // Process each debt to get paid amount and outstanding
        $debts = [];
        foreach ($debts_raw as $debt) {
            $this->db->select('SUM(amount) as total');
            $this->db->where('rental_id', $debt->id);
            $paid_result = $this->db->get('transactions')->row_array();
            $paid_amount = $paid_result['total'] ?? 0;
            $outstanding = $debt->total_amount - $paid_amount;

            if ($outstanding > 0) {
                $debt->paid_amount = $paid_amount;
                $debt->outstanding = $outstanding;
                $debts[] = $debt;
            }
        }

        // Group by customer
        $customers_debt = [];
        foreach ($debts as $debt) {
            if (!isset($customers_debt[$debt->customer_id])) {
                $customers_debt[$debt->customer_id] = [
                    'customer_id' => $debt->customer_id,
                    'customer_name' => $debt->full_name,
                    'total_outstanding' => 0,
                    'rentals' => []
                ];
            }
            $customers_debt[$debt->customer_id]['total_outstanding'] += $debt->outstanding;
            $customers_debt[$debt->customer_id]['rentals'][] = $debt;
        }

        $data['title'] = 'Daftar Hutang Pelanggan';
        $data['customers_debt'] = array_values($customers_debt);
        $data['total_outstanding'] = array_sum(array_column($customers_debt, 'total_outstanding'));

        $this->load->view('debts/index', $data);
    }

    /**
     * View customer debt details
     */
    public function customer_detail($customer_id) {
        // Get all customer's outstanding rentals
        $this->db->select('rentals.id, rentals.customer_id, rentals.console_id, rentals.total_amount, rentals.status, rentals.payment_status, rentals.end_time, customers.full_name, customers.customer_id, consoles.console_name');
        $this->db->from('rentals');
        $this->db->join('customers', 'customers.id = rentals.customer_id', 'left');
        $this->db->join('consoles', 'consoles.id = rentals.console_id', 'left');
        $this->db->where('rentals.status', 'finished');
        $this->db->where_in('rentals.payment_status', ['partial', 'pending']);
        $this->db->where('rentals.customer_id', $customer_id);
        $this->db->order_by('rentals.end_time', 'DESC');
        
        $debts_raw = $this->db->get()->result();

        if (empty($debts_raw)) {
            $this->session->set_flashdata('error', 'Pelanggan tidak memiliki hutang.');
            redirect('debts');
            return;
        }

        // Process each debt
        $debts = [];
        $customer = null;
        foreach ($debts_raw as $debt) {
            if (!$customer) {
                $customer = $this->Customer_model->find($customer_id);
            }

            $this->db->select('SUM(amount) as total');
            $this->db->where('rental_id', $debt->id);
            $paid_result = $this->db->get('transactions')->row_array();
            $paid_amount = $paid_result['total'] ?? 0;
            $outstanding = $debt->total_amount - $paid_amount;

            if ($outstanding > 0) {
                $debt->paid_amount = $paid_amount;
                $debt->outstanding = $outstanding;
                $debts[] = $debt;
            }
        }

        $data['title'] = 'Detail Hutang - ' . $customer->full_name;
        $data['customer'] = $customer;
        $data['debts'] = $debts;
        $data['total_outstanding'] = array_sum(array_column($debts, 'outstanding'));

        $this->load->view('debts/customer_detail', $data);
    }
}
