<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rentals extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->require_kasir();  // KASIR ONLY
        
        $this->load->model(['Rental_model', 'Customer_model', 'Console_model', 'Transaction_model', 'Payment_method_model']);
        $this->load->library('form_validation');
    }

    /**
     * List all rentals (ongoing and finished)
     */
    public function index() {
        // Auto-cancel expired approved bookings (no customer arrival after 15 min)
        $this->cleanup_expired_approved_bookings();
        
        // Auto-complete ongoing rentals with expired duration
        $this->auto_complete_expired_rentals();

        $data['title'] = 'Manajemen Penyewaan';
        $data['ongoing'] = $this->Rental_model->get_ongoing();
        $data['finished'] = $this->Rental_model->get_finished();

        // Get pending bookings
        $this->db->select('b.id, cu.customer_id, b.console_id, b.duration_hours, b.estimated_cost, b.created_at, cu.full_name, c.console_name, c.console_type, c.price_per_hour');
        $this->db->from('bookings b');
        $this->db->join('customers cu', 'cu.id = b.customer_id', 'left');
        $this->db->join('consoles c', 'c.id = b.console_id', 'left');
        $this->db->where('b.status', 'pending');
        $this->db->order_by('b.created_at', 'DESC');
        $data['pending_bookings'] = $this->db->get()->result_array();

        // Get approved bookings
        $this->db->select('b.id, b.customer_id, b.console_id, b.duration_hours, b.estimated_cost, b.approved_at, b.expires_at, 
                          COALESCE(cu.full_name, b.full_name) as full_name, 
                          cu.customer_id, c.console_name, c.console_type, c.price_per_hour');
        $this->db->from('bookings b');
        $this->db->join('customers cu', 'cu.id = b.customer_id', 'left');
        $this->db->join('consoles c', 'c.id = b.console_id', 'left');
        $this->db->where('b.status', 'approved');
        $this->db->order_by('b.approved_at', 'DESC');
        $approved_bookings = $this->db->get()->result_array();
        
        // Debug log
        log_message('info', "=== APPROVED BOOKINGS DEBUG ===");
        log_message('info', "Total approved bookings: " . count($approved_bookings));
        
        // Fix missing expires_at (set ke 15 menit dari approved_at jika NULL)
        foreach ($approved_bookings as &$booking) {
            log_message('info', "Booking ID " . $booking['id'] . ": expires_at=" . ($booking['expires_at'] ?? 'NULL') . ", approved_at=" . $booking['approved_at']);
            
            if (empty($booking['expires_at']) && !empty($booking['approved_at'])) {
                $booking['expires_at'] = date('Y-m-d H:i:s', strtotime($booking['approved_at'] . ' +15 minutes'));
                log_message('info', "  -> Auto-set expires_at to: " . $booking['expires_at']);
            }
        }
        
        $data['approved_bookings'] = $approved_bookings;

        $this->load->view('rentals/index', $data);
    }

    /**
     * Auto-cleanup expired approved bookings (after 15 minutes with no customer arrival)
     * Private method called automatically in index()
     */
    private function cleanup_expired_approved_bookings() {
        try {
            // Calculate expiry time: 15 minutes ago
            $expiry_time = date('Y-m-d H:i:s', strtotime('-15 minutes'));
            
            // Find all approved bookings that haven't had customer arrival in 15 minutes
            $this->db->select('b.id, b.console_id, b.full_name');
            $this->db->from('bookings b');
            $this->db->where('b.status', 'approved');
            $this->db->where('b.approved_at <', $expiry_time);
            $expired_bookings = $this->db->get()->result_array();
            
            // Process each expired booking
            foreach ($expired_bookings as $booking) {
                // Update booking status to expired
                $this->db->where('id', $booking['id']);
                $this->db->update('bookings', ['status' => 'expired']);
                
                // Restore console to available status
                $this->db->where('id', $booking['console_id']);
                $this->db->update('consoles', ['status' => 'available']);
                
                // Log action for debugging
                log_message('info', "Auto-expired booking: ID={$booking['id']}, Console={$booking['console_id']}, Customer={$booking['full_name']}");
            }
        } catch (Exception $e) {
            log_message('error', "Error in cleanup_expired_approved_bookings: " . $e->getMessage());
        }
    }

    /**
     * Auto-complete ongoing rentals when estimated duration expires
     * Private method called automatically in index()
     */
    private function auto_complete_expired_rentals() {
        try {
            // Find all ongoing rentals with timer_started_at and check if duration expired
            $this->db->select('r.id, r.timer_started_at, r.estimated_hours, r.start_time, r.console_id, r.customer_id, r.estimated_cost, c.price_per_hour');
            $this->db->from('rentals r');
            $this->db->join('consoles c', 'c.id = r.console_id', 'left');
            $this->db->where('r.status', 'ongoing');
            $this->db->where('r.timer_started_at IS NOT NULL', NULL, FALSE);
            $ongoing_rentals = $this->db->get()->result_array();
            
            foreach ($ongoing_rentals as $rental) {
                // Calculate if duration has expired
                $timer_start = new DateTime($rental['timer_started_at']);
                $now = new DateTime();
                $elapsed_seconds = $now->getTimestamp() - $timer_start->getTimestamp();
                $estimated_seconds = $rental['estimated_hours'] * 3600;
                
                // If elapsed time >= estimated time, auto-complete
                if ($elapsed_seconds >= $estimated_seconds) {
                    // Calculate actual duration in minutes
                    $duration_minutes = ceil($elapsed_seconds / 60);
                    
                    // Calculate actual cost (but no charge more than estimated - just use estimated)
                    $actual_cost_with_overage = ($rental['price_per_hour'] / 60) * $duration_minutes;
                    $total_cost = max($actual_cost_with_overage, $rental['estimated_cost']);
                    
                    // For auto-complete, just use estimated cost (no overage charge)
                    $total_cost = $rental['estimated_cost'];
                    
                    // Get current time as end time
                    $end_time = date('Y-m-d H:i:s');
                    
                    // Update rental as finished
                    $this->db->where('id', $rental['id']);
                    $this->db->update('rentals', [
                        'end_time' => $end_time,
                        'duration_minutes' => $duration_minutes,
                        'total_amount' => $total_cost,
                        'status' => 'finished'
                    ]);
                    
                    // Restore console to available
                    $this->db->where('id', $rental['console_id']);
                    $this->db->update('consoles', ['status' => 'available']);
                    
                    // Log action
                    log_message('info', "Auto-completed rental: ID={$rental['id']}, Duration={$duration_minutes}min, Cost=Rp{$total_cost}");
                }
            }
        } catch (Exception $e) {
            log_message('error', "Error in auto_complete_expired_rentals: " . $e->getMessage());
        }
    }

    /**
     * Create new rental
     */
    public function create() {
        $data['title'] = 'Mulai Penyewaan Baru';
        $data['customers'] = $this->Customer_model->get_all();
        
        // Only show available consoles
        $this->db->where('status', 'available');
        $data['consoles'] = $this->db->get('consoles')->result();
        
        $this->load->view('rentals/form', $data);
    }

    /**
     * Store new rental dengan pembayaran awal
     */
    public function store() {
        $this->form_validation->set_rules('customer_id', 'Pelanggan', 'required|numeric');
        $this->form_validation->set_rules('console_id', 'Unit PS', 'required|numeric');
        $this->form_validation->set_rules('estimated_duration', 'Estimasi Durasi', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            return $this->create();
        }

        $console = $this->Console_model->find($this->input->post('console_id'));
        $start_time = date('Y-m-d H:i:s');
        $estimated_duration = (int)$this->input->post('estimated_duration');
        
        // Calculate estimated cost
        $estimated_cost = $console->price_per_hour * $estimated_duration;

        $payload = [
            'customer_id' => $this->input->post('customer_id'),
            'console_id'  => $this->input->post('console_id'),
            'start_time'  => $start_time,
            'estimated_hours' => $estimated_duration,
            'estimated_cost' => $estimated_cost,
            'status'      => 'ongoing',
            'payment_status' => 'pending',
            'total_amount' => 0
        ];

        $rental_id = $this->Rental_model->insert($payload);

        // Update console status to in_use
        $this->Console_model->update($this->input->post('console_id'), [
            'status' => 'in_use'
        ]);

        // Redirect to payment
        redirect('rentals/initial_payment/' . $rental_id);
    }

    /**
     * Show initial payment form (pembayaran di awal)
     */
    public function initial_payment($id) {
        $rental = $this->Rental_model->find($id);
        if (!$rental) show_404();

        if ($rental->status != 'ongoing') {
            $this->session->set_flashdata('error', 'Penyewaan tidak valid.');
            redirect('rentals');
            return;
        }

        // Get rental with customer and console info
        // Note: Customer info already joined in Rental_model->find()
        $console = $this->Console_model->find($rental->console_id);

        $data['title'] = 'Pembayaran Awal - Penyewaan #' . $id;
        $data['rental'] = [
            'id' => $rental->id,
            'customer_id' => $rental->customer_id,
            'customer_name' => $rental->full_name,
            'console_id' => $rental->console_id,
            'console_name' => $console->console_name,
            'estimated_hours' => $rental->estimated_hours,
            'estimated_cost' => $rental->estimated_cost
        ];
        $data['payment_methods'] = $this->Payment_method_model->get_all();

        $this->load->view('rentals/initial_payment', $data);
    }

    /**
     * Process initial payment
     */
    public function process_initial_payment($id) {
        $this->form_validation->set_rules('amount', 'Jumlah Pembayaran', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('payment_method', 'Metode Pembayaran', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            return $this->initial_payment($id);
        }

        $rental = $this->Rental_model->find($id);
        if (!$rental) show_404();

        $amount = (int)$this->input->post('amount');
        $payment_method_id = (int)$this->input->post('payment_method');
        $notes = $this->input->post('notes');

        // Record initial transaction
        $transaction = [
            'rental_id' => $id,
            'amount' => $amount,
            'payment_method_id' => $payment_method_id,
            'paid_at' => date('Y-m-d H:i:s'),
            'change_amount' => max(0, $amount - $rental->estimated_cost),
            'created_by' => $this->get_user_id(),
            'notes' => 'Pembayaran awal (estimasi). ' . ($notes ? $notes : '')
        ];

        $this->db->insert('transactions', $transaction);

        // Update payment status - Awal bayar selalu dianggap "paid" untuk estimasi
        // Nanti saat selesai, akan di-adjust jika ada pembayaran tambahan
        $this->Rental_model->update($id, ['payment_status' => 'paid']);

        $this->session->set_flashdata('success', 'Pembayaran awal Rp ' . number_format($amount, 0, ',', '.') . ' berhasil dicatat.');
        redirect('rentals');
    }

    /**
     * Finish rental - Calculate actual cost dan adjustment pembayaran
     */
    public function finish($id) {
        $rental = $this->Rental_model->find($id);
        if (!$rental) show_404();

        if ($rental->status != 'ongoing') {
            $this->session->set_flashdata('error', 'Penyewaan ini sudah selesai.');
            redirect('rentals');
            return;
        }

        // Calculate duration and cost
        $end_time = date('Y-m-d H:i:s');
        $start = new DateTime($rental->start_time);
        $end   = new DateTime($end_time);
        $diff  = $start->diff($end);

        // Calculate total minutes
        $duration_minutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i + ($diff->s > 0 ? 1 : 0);

        // Get console price
        $console = $this->Console_model->find($rental->console_id);
        $cost_per_minute = $console->price_per_hour / 60;
        $actual_duration_cost = round($cost_per_minute * $duration_minutes);

        // IMPORTANT: Minimum charge is the estimated cost (no refund)
        // Only charge more if actual duration exceeds estimated hours
        $total_cost = max($actual_duration_cost, $rental->estimated_cost);

        // Update rental with cost calculation
        $this->Rental_model->update($id, [
            'end_time'        => $end_time,
            'duration_minutes'=> $duration_minutes,
            'total_amount'    => $total_cost,
            'status'          => 'finished'
        ]);

        // Restore console to available
        $this->Console_model->update($rental->console_id, [
            'status' => 'available'
        ]);

        // Calculate paid amount
        $this->db->select('SUM(amount) as total');
        $this->db->where('rental_id', $id);
        $paid_result = $this->db->get('transactions')->row_array();
        $paid_amount = $paid_result['total'] ?? 0;

        // Calculate difference
        $difference = $total_cost - $paid_amount;

        // If difference > 0, redirect to payment adjustment
        // If difference <= 0, show success notification and redirect to rentals
        if ($difference > 0) {
            redirect('rentals/payment_adjustment/' . $id);
        } else {
            $this->session->set_flashdata('success', 'Penyewaan selesai. Pembayaran sudah lunas.');
            redirect('rentals');
        }
    }

    /**
     * Show payment adjustment form (jika durasi actual berbeda dari estimasi)
     */
    public function payment_adjustment($id) {
        $rental = $this->Rental_model->find($id);
        if (!$rental) show_404();

        // Get customer and console info
        // Note: Customer info already joined in Rental_model->find()
        $console = $this->Console_model->find($rental->console_id);

        // Calculate paid amount
        $this->db->select('SUM(amount) as total');
        $this->db->where('rental_id', $id);
        $paid_result = $this->db->get('transactions')->row_array();
        $paid_amount = $paid_result['total'] ?? 0;

        // Calculate actual duration
        $start = new DateTime($rental->start_time);
        $end   = new DateTime($rental->end_time);
        $diff  = $start->diff($end);
        $actual_duration = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i + ($diff->s > 0 ? 1 : 0);

        $difference = $rental->total_amount - $paid_amount;

        $data['title'] = 'Penyesuaian Pembayaran - Penyewaan #' . $id;
        $data['rental'] = [
            'id' => $rental->id,
            'customer_id' => $rental->customer_id,
            'customer_name' => $rental->full_name,
            'console_id' => $rental->console_id,
            'console_name' => $console->console_name,
            'estimated_hours' => $rental->estimated_hours,
            'estimated_cost' => $rental->estimated_cost,
            'total_amount' => $rental->total_amount
        ];
        $data['actual_duration'] = $actual_duration;
        $data['paid_amount'] = $paid_amount;
        $data['difference'] = $difference;
        $data['payment_methods'] = $this->Payment_method_model->get_all();

        $this->load->view('rentals/payment_adjustment', $data);
    }

    /**
     * Process payment adjustment
     */
    public function process_payment_adjustment($id) {
        $this->form_validation->set_rules('amount', 'Jumlah', 'required|numeric');
        $this->form_validation->set_rules('payment_method', 'Metode Pembayaran', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            return $this->payment_adjustment($id);
        }

        $rental = $this->Rental_model->find($id);
        if (!$rental) show_404();

        $amount = (int)$this->input->post('amount');
        $payment_method_id = (int)$this->input->post('payment_method');
        $notes = $this->input->post('notes');

        // Get current paid amount
        $this->db->select('SUM(amount) as total');
        $this->db->where('rental_id', $id);
        $paid_result = $this->db->get('transactions')->row_array();
        $paid_amount = $paid_result['total'] ?? 0;

        $new_total_paid = $paid_amount + $amount;

        // Determine payment status
        if ($new_total_paid >= $rental->total_amount) {
            $payment_status = 'paid';
        } elseif ($new_total_paid > 0) {
            $payment_status = 'partial';
        } else {
            $payment_status = 'pending';
        }

        // Record adjustment transaction
        $transaction = [
            'rental_id' => $id,
            'amount' => $amount,
            'payment_method_id' => $payment_method_id,
            'paid_at' => date('Y-m-d H:i:s'),
            'change_amount' => max(0, $new_total_paid - $rental->total_amount),
            'created_by' => $this->get_user_id(),
            'notes' => 'Penyesuaian pembayaran (durasi sebenarnya). ' . ($notes ? $notes : '')
        ];

        $this->db->insert('transactions', $transaction);

        // Update rental payment status
        $this->Rental_model->update($id, [
            'payment_status' => $payment_status
        ]);

        $message_type = $amount >= 0 ? 'Pembayaran tambahan' : 'Pengembalian';
        $this->session->set_flashdata('success', $message_type . ' Rp ' . number_format(abs($amount), 0, ',', '.') . ' berhasil dicatat.');
        
        // If fully paid, redirect to invoice, otherwise back to adjustment
        if ($payment_status == 'paid') {
            redirect('rentals/invoice/' . $id);
        } else {
            redirect('rentals/payment_adjustment/' . $id);
        }
    }

    /**
     * Show invoice/receipt
     */
    public function invoice($id) {
        $rental = $this->Rental_model->get_with_transactions($id);
        if (!$rental) show_404();

        $data['title'] = 'Struk Pembayaran - Penyewaan #' . $id;
        $data['rental'] = $rental;
        
        // Calculate total paid
        $paid_amount = 0;
        if (isset($rental['transactions']) && !empty($rental['transactions'])) {
            foreach ($rental['transactions'] as $t) {
                $paid_amount += $t['amount'];
            }
        }
        $data['paid_amount'] = $paid_amount;
        $data['outstanding'] = max(0, $rental['total_amount'] - $paid_amount);

        $this->load->view('rentals/invoice', $data);
    }

    /**
     * Mark debt when customer cancel payment adjustment (batal on payment_adjustment page)
     */
    public function mark_debt($id) {
        $rental = $this->Rental_model->find($id);
        if (!$rental) show_404();

        // Calculate paid amount
        $this->db->select('SUM(amount) as total');
        $this->db->where('rental_id', $id);
        $paid_result = $this->db->get('transactions')->row_array();
        $paid_amount = $paid_result['total'] ?? 0;

        // Calculate outstanding debt
        $outstanding = $rental->total_amount - $paid_amount;

        // Only create debt record if there's outstanding amount
        if ($outstanding > 0) {
            // Record debt in debts table
            $debt = [
                'customer_id' => $rental->customer_id,
                'rental_id' => $id,
                'amount' => $outstanding,
                'paid_amount' => 0,
                'status' => 'unpaid',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('debts', $debt);

            // Update rental payment_status to partial
            $this->Rental_model->update($id, [
                'payment_status' => 'partial'
            ]);

            log_message('info', "Debt recorded: Rental={$id}, Customer={$rental->customer_id}, Amount={$outstanding}");
        }

        // Redirect to rentals with notification
        $this->session->set_flashdata('info', 'Hutang pelanggan tercatat. Sisa pembayaran: Rp ' . number_format($outstanding));
        redirect('rentals');
    }

    /**
     * Delete rental (only finished, unpaid rentals)
     */
    public function delete($id) {
        $rental = $this->Rental_model->find($id);
        if (!$rental) show_404();

        if ($rental->status == 'ongoing') {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus penyewaan yang masih berjalan!');
            redirect('rentals');
            return;
        }

        // Delete associated transactions
        $this->db->delete('transactions', ['rental_id' => $id]);
        
        // Delete rental
        $this->Rental_model->delete($id);

        redirect('rentals');
    }

    /**
     * Collect payment for unpaid or partially paid rentals
     */
    public function collect_payment($id) {
        $rental = $this->Rental_model->find($id);
        if (!$rental) show_404();

        if ($rental->status != 'finished') {
            $this->session->set_flashdata('error', 'Hanya bisa menerima pembayaran dari penyewaan yang sudah selesai.');
            redirect('rentals');
            return;
        }

        // Calculate paid amount
        $this->db->select('SUM(amount) as total');
        $this->db->where('rental_id', $id);
        $paid_result = $this->db->get('transactions')->row_array();
        $paid_amount = $paid_result['total'] ?? 0;

        $outstanding = $rental->total_amount - $paid_amount;

        if ($outstanding <= 0) {
            $this->session->set_flashdata('error', 'Pembayaran penyewaan ini sudah selesai.');
            redirect('rentals');
            return;
        }

        // Get customer and console info
        // Note: Customer info already joined in Rental_model->find()
        $console = $this->Console_model->find($rental->console_id);

        $data['title'] = 'Terima Pembayaran - Penyewaan #' . $id;
        $data['rental'] = [
            'id' => $rental->id,
            'customer_id' => $rental->customer_id,
            'customer_name' => $rental->full_name,
            'console_name' => $console->console_name,
            'total_amount' => $rental->total_amount,
            'paid_amount' => $paid_amount,
            'outstanding' => $outstanding
        ];
        $data['payment_methods'] = $this->Payment_method_model->get_all();

        $this->load->view('rentals/collect_payment', $data);
    }

    /**
     * Process debt payment
     */
    public function process_collect_payment($id) {
        $this->form_validation->set_rules('amount', 'Jumlah', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('payment_method', 'Metode Pembayaran', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            return $this->collect_payment($id);
        }

        $rental = $this->Rental_model->find($id);
        if (!$rental) show_404();

        $amount = (int)$this->input->post('amount');
        $payment_method_id = (int)$this->input->post('payment_method');
        $notes = $this->input->post('notes');

        // Get current paid amount
        $this->db->select('SUM(amount) as total');
        $this->db->where('rental_id', $id);
        $paid_result = $this->db->get('transactions')->row_array();
        $paid_amount = $paid_result['total'] ?? 0;

        $new_total_paid = $paid_amount + $amount;

        // Determine payment status
        if ($new_total_paid >= $rental->total_amount) {
            $payment_status = 'paid';
        } elseif ($new_total_paid > 0) {
            $payment_status = 'partial';
        } else {
            $payment_status = 'pending';
        }

        // Record payment transaction
        $transaction = [
            'rental_id' => $id,
            'amount' => $amount,
            'payment_method_id' => $payment_method_id,
            'paid_at' => date('Y-m-d H:i:s'),
            'change_amount' => max(0, $new_total_paid - $rental->total_amount),
            'created_by' => $this->get_user_id(),
            'notes' => 'Pembayaran cicilan/pelunasan. ' . ($notes ? $notes : '')
        ];

        $this->db->insert('transactions', $transaction);

        // Update rental payment status
        $this->Rental_model->update($id, [
            'payment_status' => $payment_status
        ]);

        $this->session->set_flashdata('success', 'Pembayaran Rp ' . number_format($amount, 0, ',', '.') . ' berhasil dicatat.');
        
        redirect('rentals');
    }

    /**
     * Start timer for rental
     */
    public function start_timer($id) {
        $rental = $this->Rental_model->find($id);
        if (!$rental) {
            echo json_encode(['success' => false, 'message' => 'Rental tidak ditemukan']);
            return;
        }

        if ($rental->status != 'ongoing') {
            echo json_encode(['success' => false, 'message' => 'Rental tidak aktif']);
            return;
        }

        // Record timer start time
        $this->Rental_model->update($id, [
            'timer_started_at' => date('Y-m-d H:i:s')
        ]);

        echo json_encode(['success' => true, 'timer_started_at' => date('Y-m-d H:i:s')]);
    }

    /**
     * Start play - simple redirect to record timer and show finish button
     */
    public function start_play($id) {
        $rental = $this->Rental_model->find($id);
        if (!$rental) {
            $this->session->set_flashdata('error', 'Rental tidak ditemukan');
            redirect('rentals');
            return;
        }

        if ($rental->status != 'ongoing') {
            $this->session->set_flashdata('error', 'Rental tidak aktif');
            redirect('rentals');
            return;
        }

        // Record timer start time
        $this->Rental_model->update($id, [
            'timer_started_at' => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Timer dimulai untuk penyewaan #' . $id);
        redirect('rentals');
    }

    /**
     * AJAX endpoint - Check and auto-finish expired rentals
     */
    public function check_expired_and_finish() {
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }

        try {
            $completed_count = 0;
            
            // Find all ongoing rentals with timer_started_at and check if duration expired
            $this->db->select('r.id, r.timer_started_at, r.estimated_hours, r.console_id, r.estimated_cost, c.price_per_hour');
            $this->db->from('rentals r');
            $this->db->join('consoles c', 'c.id = r.console_id', 'left');
            $this->db->where('r.status', 'ongoing');
            $this->db->where('r.timer_started_at IS NOT NULL', NULL, FALSE);
            $ongoing_rentals = $this->db->get()->result_array();
            
            foreach ($ongoing_rentals as $rental) {
                $timer_start = new DateTime($rental['timer_started_at']);
                $now = new DateTime();
                $elapsed_seconds = $now->getTimestamp() - $timer_start->getTimestamp();
                $estimated_seconds = $rental['estimated_hours'] * 3600;
                
                // If time expired, auto-finish
                if ($elapsed_seconds >= $estimated_seconds) {
                    $duration_minutes = ceil($elapsed_seconds / 60);
                    $end_time = date('Y-m-d H:i:s');
                    
                    $this->db->where('id', $rental['id']);
                    $this->db->update('rentals', [
                        'end_time' => $end_time,
                        'duration_minutes' => $duration_minutes,
                        'total_amount' => $rental['estimated_cost'],
                        'status' => 'finished'
                    ]);
                    
                    $this->db->where('id', $rental['console_id']);
                    $this->db->update('consoles', ['status' => 'available']);
                    
                    $completed_count++;
                    log_message('info', "AJAX auto-finished rental: ID={$rental['id']}");
                }
            }
            
            echo json_encode(['success' => true, 'finished' => $completed_count]);
        } catch (Exception $e) {
            log_message('error', "Error in check_expired_and_finish: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }}