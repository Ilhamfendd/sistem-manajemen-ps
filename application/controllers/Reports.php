<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->require_role('owner');  // OWNER ONLY
        
        $this->load->model(['Rental_model', 'Transaction_model', 'Payment_method_model', 'Console_model']);
        $this->load->library('form_validation');
        date_default_timezone_set('Asia/Jakarta');
    }

    /**
     * Main reports dashboard with quick statistics
     */
    public function index() {
        $data['title'] = 'Laporan & Analitik';
        
        // Quick stats for today, month, all-time
        $today = $this->get_date_stats(date('Y-m-d'), date('Y-m-d'));
        $month = $this->get_date_stats(date('Y-m-01'), date('Y-m-t'));
        $all_time = $this->db->select('COUNT(*) as total_rentals, SUM(total_amount) as total_revenue')
                             ->where('status', 'finished')
                             ->get('rentals')->row_array();

        $data['today'] = $today;
        $data['month'] = $month;
        $data['all_time'] = $all_time;

        // 7-day trend data
        $trend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $this->db->select('SUM(total_amount) as revenue, COUNT(*) as rentals')
                     ->where('status', 'finished')
                     ->where('DATE(created_at)', $date);
            $result = $this->db->get('rentals')->row_array();
            $trend[] = [
                'date' => date('d/m', strtotime($date)),
                'revenue' => $result['revenue'] ?? 0,
                'rentals' => $result['rentals'] ?? 0
            ];
        }
        $data['trend'] = $trend;

        $this->load->view('reports/index', $data);
    }

    /**
     * Revenue report with date range filtering
     */
    public function revenue() {
        $data['title'] = 'Laporan Pendapatan';
        
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');
        
        if (strtotime($start_date) > strtotime($end_date)) {
            $temp = $start_date;
            $start_date = $end_date;
            $end_date = $temp;
        }

        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $this->db->select('DATE(rentals.created_at) as rent_date, COUNT(*) as rental_count, SUM(rentals.duration_minutes) as total_minutes, SUM(rentals.total_amount) as daily_revenue')
                 ->where('rentals.status', 'finished')
                 ->where('DATE(rentals.created_at) >=', $start_date)
                 ->where('DATE(rentals.created_at) <=', $end_date)
                 ->group_by('DATE(rentals.created_at)')
                 ->order_by('rentals.created_at', 'DESC');
        $data['daily_revenue'] = $this->db->get('rentals')->result_array();

        $this->db->select('consoles.console_type, COUNT(rentals.id) as rental_count, SUM(rentals.total_amount) as type_revenue, AVG(rentals.total_amount) as avg_revenue')
                 ->from('rentals')
                 ->join('consoles', 'consoles.id = rentals.console_id', 'left')
                 ->where('rentals.status', 'finished')
                 ->where('DATE(rentals.created_at) >=', $start_date)
                 ->where('DATE(rentals.created_at) <=', $end_date)
                 ->group_by('consoles.console_type')
                 ->order_by('type_revenue', 'DESC');
        $data['revenue_by_type'] = $this->db->get()->result_array();

        $this->db->select('payment_methods.name as method_name, COUNT(transactions.id) as transaction_count, SUM(transactions.amount) as method_revenue, AVG(transactions.amount) as avg_payment')
                 ->from('transactions')
                 ->join('payment_methods', 'payment_methods.id = transactions.payment_method_id', 'left')
                 ->where('DATE(transactions.paid_at) >=', $start_date)
                 ->where('DATE(transactions.paid_at) <=', $end_date)
                 ->group_by('transactions.payment_method_id')
                 ->order_by('method_revenue', 'DESC');
        $data['revenue_by_method'] = $this->db->get()->result_array();

        $totals = $this->db->select('COUNT(*) as total_rentals, SUM(total_amount) as total_revenue, SUM(duration_minutes) as total_minutes')
                           ->where('status', 'finished')
                           ->where('DATE(created_at) >=', $start_date)
                           ->where('DATE(created_at) <=', $end_date)
                           ->get('rentals')->row_array();
        $data['period_total'] = $totals;

        $this->load->view('reports/revenue', $data);
    }

    /**
     * Console performance report
     */
    public function console_performance() {
        $data['title'] = 'Laporan Performa Konsol';
        
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $this->db->select('consoles.id, consoles.console_name, consoles.console_type, consoles.price_per_hour, COUNT(rentals.id) as rental_count, SUM(rentals.duration_minutes) as total_minutes, AVG(rentals.duration_minutes) as avg_duration, MIN(rentals.duration_minutes) as min_duration, MAX(rentals.duration_minutes) as max_duration, SUM(rentals.total_amount) as total_revenue, AVG(rentals.total_amount) as avg_revenue')
                 ->from('consoles')
                 ->join('rentals', 'rentals.console_id = consoles.id', 'left')
                 ->where('rentals.status', 'finished')
                 ->where('DATE(rentals.created_at) >=', $start_date)
                 ->where('DATE(rentals.created_at) <=', $end_date)
                 ->group_by('consoles.id')
                 ->order_by('total_revenue', 'DESC');
        $data['console_stats'] = $this->db->get()->result_array();

        $this->load->view('reports/console_performance', $data);
    }

    /**
     * Payment analysis report
     */
    public function payment_analysis() {
        $data['title'] = 'Analisis Pembayaran';
        
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        // Get payment status breakdown with accurate payment amounts
        $this->db->select('rentals.payment_status, COUNT(rentals.id) as count, SUM(rentals.total_amount) as total_rental, COALESCE(SUM(transactions.amount), 0) as total_paid')
                 ->from('rentals')
                 ->join('transactions', 'transactions.rental_id = rentals.id', 'left')
                 ->where('rentals.status', 'finished')
                 ->where('DATE(rentals.created_at) >=', $start_date)
                 ->where('DATE(rentals.created_at) <=', $end_date)
                 ->group_by('rentals.id')
                 ->order_by('rentals.payment_status');
        $temp_breakdown = $this->db->get()->result_array();
        
        // Restructure by payment_status with accurate amounts
        $payment_status = ['paid' => ['count' => 0, 'total' => 0], 'partial' => ['count' => 0, 'total' => 0], 'pending' => ['count' => 0, 'total' => 0]];
        foreach ($temp_breakdown as $row) {
            $status = $row['payment_status'] ?? 'pending';
            if (isset($payment_status[$status])) {
                // For 'paid': show total paid amount
                // For 'partial': show remaining amount (total - paid)
                // For 'pending': show total amount (nothing paid)
                if ($status === 'paid') {
                    $amount = $row['total_paid'];
                } elseif ($status === 'partial') {
                    $amount = ($row['total_rental'] - $row['total_paid']);
                } else {
                    $amount = $row['total_rental'];
                }
                
                $payment_status[$status]['count'] += 1;
                $payment_status[$status]['total'] += $amount;
            }
        }
        $data['payment_status'] = $payment_status;

        $this->db->select('payment_methods.name as method_name, COUNT(transactions.id) as transaction_count, SUM(transactions.amount) as total_amount, AVG(transactions.amount) as avg_amount')
                 ->from('transactions')
                 ->join('payment_methods', 'payment_methods.id = transactions.payment_method_id', 'left')
                 ->where('DATE(transactions.paid_at) >=', $start_date)
                 ->where('DATE(transactions.paid_at) <=', $end_date)
                 ->group_by('transactions.payment_method_id')
                 ->order_by('total_amount', 'DESC');
        $data['payment_methods'] = $this->db->get()->result_array();

        $this->db->select('customers.full_name as customer_name, customers.customer_id as customer_id, rentals.payment_status as status, COUNT(rentals.id) as rental_count, SUM(rentals.total_amount) as total_amount, COALESCE(SUM(transactions.amount), 0) as paid_amount, (SUM(rentals.total_amount) - COALESCE(SUM(transactions.amount), 0)) as sisa_piutang')
                 ->from('rentals')
                 ->join('customers', 'customers.id = rentals.customer_id', 'left')
                 ->join('transactions', 'transactions.rental_id = rentals.id', 'left')
                 ->where('rentals.payment_status !=', 'paid')
                 ->where('DATE(rentals.created_at) >=', $start_date)
                 ->where('DATE(rentals.created_at) <=', $end_date)
                 ->group_by('rentals.customer_id')
                 ->order_by('sisa_piutang', 'DESC');
        $data['outstanding_payments'] = $this->db->get()->result_array();

        $this->load->view('reports/payment_analysis', $data);
    }

    /**
     * Customer analysis report
     */
    public function customer_analysis() {
        $data['title'] = 'Analisis Pelanggan';
        
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $this->db->select('customers.id, customers.full_name as customer_name, customers.customer_id, COUNT(rentals.id) as rental_count, SUM(rentals.duration_minutes) as total_minutes, SUM(rentals.total_amount) as total_spending, AVG(rentals.total_amount) as avg_spending')
                 ->from('rentals')
                 ->join('customers', 'customers.id = rentals.customer_id', 'left')
                 ->where('rentals.status', 'finished')
                 ->where('DATE(rentals.created_at) >=', $start_date)
                 ->where('DATE(rentals.created_at) <=', $end_date)
                 ->group_by('rentals.customer_id')
                 ->order_by('total_spending', 'DESC')
                 ->limit(20);
        $data['top_customers'] = $this->db->get()->result_array();

        $this->load->view('reports/customer_analysis', $data);
    }

    /**
     * Helper method to get stats for a date range
     */
    private function get_date_stats($start, $end) {
        // Get total rental charges completed in date range (not just paid amount)
        $this->db->select('COUNT(*) as total_rentals, SUM(total_amount) as total_revenue, AVG(total_amount) as avg_revenue, MIN(total_amount) as min_revenue, MAX(total_amount) as max_revenue')
                 ->where('status', 'finished')
                 ->where('DATE(created_at) >=', $start)
                 ->where('DATE(created_at) <=', $end);
        return $this->db->get('rentals')->row_array();
    }

    /**
     * Export revenue to CSV
     */
    public function export_revenue_csv() {
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');

        $this->db->select('DATE(rentals.created_at) as rent_date, COUNT(*) as rental_count, SUM(rentals.total_amount) as daily_revenue')
                 ->where('rentals.status', 'finished')
                 ->where('DATE(rentals.created_at) >=', $start_date)
                 ->where('DATE(rentals.created_at) <=', $end_date)
                 ->group_by('DATE(rentals.created_at)')
                 ->order_by('rentals.created_at', 'DESC');
        $data = $this->db->get('rentals')->result_array();

        $output = "Laporan Pendapatan ($start_date hingga $end_date)\n";
        $output .= "Tanggal,Jumlah Rental,Pendapatan\n";
        
        foreach ($data as $row) {
            $output .= $row['rent_date'] . ',' . $row['rental_count'] . ',' . $row['daily_revenue'] . "\n";
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="Revenue_Report_' . date('Y-m-d') . '.csv"');
        echo "\xEF\xBB\xBF" . $output;
        exit;
    }

    /**
     * Export console performance to CSV
     */
    public function export_console_csv() {
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');

        $this->db->select('consoles.console_name, consoles.console_type, COUNT(rentals.id) as total_rentals, SUM(rentals.total_amount) as total_revenue, AVG(rentals.total_amount) as avg_revenue')
                 ->from('consoles')
                 ->join('rentals', 'rentals.console_id = consoles.id', 'left')
                 ->where('rentals.status', 'finished')
                 ->where('DATE(rentals.created_at) >=', $start_date)
                 ->where('DATE(rentals.created_at) <=', $end_date)
                 ->group_by('consoles.id')
                 ->order_by('total_revenue', 'DESC');
        $data = $this->db->get()->result_array();

        $output = "Laporan Performa Konsol ($start_date hingga $end_date)\n";
        $output .= "Nama Unit,Tipe,Total Rental,Total Pendapatan,Rata-rata Pendapatan\n";
        
        foreach ($data as $row) {
            $output .= $row['console_name'] . ',' . $row['console_type'] . ',' . 
                      ($row['total_rentals'] ?? 0) . ',' . ($row['total_revenue'] ?? 0) . ',' . 
                      ($row['avg_revenue'] ?? 0) . "\n";
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="Console_Report_' . date('Y-m-d') . '.csv"');
        echo "\xEF\xBB\xBF" . $output;
        exit;
    }

    /**
     * Export customer analysis to CSV
     */
    public function export_customer_csv() {
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-d');

        $this->db->select('customers.full_name, customers.customer_id, COUNT(rentals.id) as rental_count, SUM(rentals.total_amount) as total_spending, AVG(rentals.total_amount) as avg_spending')
                 ->from('rentals')
                 ->join('customers', 'customers.id = rentals.customer_id')
                 ->where('rentals.status', 'finished')
                 ->where('DATE(rentals.created_at) >=', $start_date)
                 ->where('DATE(rentals.created_at) <=', $end_date)
                 ->group_by('rentals.customer_id')
                 ->order_by('total_spending', 'DESC');
        $data = $this->db->get()->result_array();

        $output = "Laporan Pelanggan Top ($start_date hingga $end_date)\n";
        $output .= "Nama Pelanggan,Telepon,Jumlah Rental,Total Spending,Rata-rata Spending\n";
        
        foreach ($data as $row) {
            $output .= $row['full_name'] . ',' . $row['phone'] . ',' . 
                      $row['rental_count'] . ',' . $row['total_spending'] . ',' . 
                      $row['avg_spending'] . "\n";
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="Customer_Report_' . date('Y-m-d') . '.csv"');
        echo "\xEF\xBB\xBF" . $output;
        exit;
    }
}

