<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->load->model('Rental_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index() {
        $data['title'] = 'Laporan Pendapatan';
        $data['today'] = $this->get_today_income();
        $data['week']  = $this->get_week_income();
        $data['month'] = $this->get_month_income();

        // default: tampilkan transaksi selesai bulan ini
        $data['items'] = $this->get_transactions_month();

        $this->load->view('reports/index', $data);
    }

    private function get_today_income() {
        $today = date('Y-m-d');

        $this->db->select_sum('total_cost');
        $this->db->where('DATE(end_time)', $today);
        $this->db->where('status', 'finished');
        $income = $this->db->get('rentals')->row()->total_cost ?? 0;

        $this->db->where('DATE(end_time)', $today);
        $this->db->where('status', 'finished');
        $count = $this->db->count_all_results('rentals');

        return ['income' => $income, 'count' => $count];
    }

    private function get_week_income() {
        $start = date('Y-m-d', strtotime('monday this week'));
        $end   = date('Y-m-d', strtotime('sunday this week'));

        $this->db->select_sum('total_cost');
        $this->db->where('end_time >=', $start." 00:00:00");
        $this->db->where('end_time <=', $end." 23:59:59");
        $this->db->where('status', 'finished');
        $income = $this->db->get('rentals')->row()->total_cost ?? 0;

        $this->db->where('end_time >=', $start." 00:00:00");
        $this->db->where('end_time <=', $end." 23:59:59");
        $this->db->where('status', 'finished');
        $count = $this->db->count_all_results('rentals');

        return ['income' => $income, 'count' => $count];
    }

    private function get_month_income() {
        $month = date('m');
        $year  = date('Y');

        $this->db->select_sum('total_cost');
        $this->db->where('MONTH(end_time)', $month);
        $this->db->where('YEAR(end_time)', $year);
        $this->db->where('status', 'finished');
        $income = $this->db->get('rentals')->row()->total_cost ?? 0;

        $this->db->where('MONTH(end_time)', $month);
        $this->db->where('YEAR(end_time)', $year);
        $this->db->where('status', 'finished');
        $count = $this->db->count_all_results('rentals');

        return ['income' => $income, 'count' => $count];
    }

    private function get_transactions_month() {
        $month = date('m');
        $year  = date('Y');

        $this->db->where('MONTH(end_time)', $month);
        $this->db->where('YEAR(end_time)', $year);
        $this->db->where('status', 'finished');
        return $this->db->order_by('end_time','DESC')->get('rentals')->result();
    }
}
