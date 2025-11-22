<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rentals extends MY_Controller {

    private $rate_per_hour = 5000; // tarif per jam

    public function __construct() {
        parent::__construct();
        $this->require_login();
        $this->load->model(['Rental_model', 'Customer_model', 'Console_model']);
        $this->load->library('form_validation');
        $this->require_any_role(['admin','kasir']);
    }

    public function index() {
        $data['title'] = 'Transaksi Penyewaan';
        $data['items'] = $this->Rental_model->get_all();
        $data['rate_per_hour'] = $this->rate_per_hour;
        $this->load->view('rentals/index', $data);
        
    }

    public function create() {
        $data['title'] = 'Mulai Sewa Baru';
        $data['customers'] = $this->Customer_model->get_all();
        $data['consoles'] = $this->db->where('status', 'available')->get('consoles')->result();
        $this->load->view('rentals/form', $data);
    }

    public function store() {
        $this->form_validation->set_rules('customer_id', 'Pelanggan', 'required');
        $this->form_validation->set_rules('console_id', 'Unit PS', 'required');

        if ($this->form_validation->run() == FALSE) {
            return $this->create();
        }

        $start_time = date('Y-m-d H:i:s');

        $payload = [
            'customer_id' => $this->input->post('customer_id'),
            'console_id'  => $this->input->post('console_id'),
            'start_time'  => $start_time,
            'status'      => 'ongoing'
        ];

        $this->Rental_model->insert($payload);

        // Ubah status PS menjadi dipakai
        $this->Console_model->update($this->input->post('console_id'), [
            'status' => 'in_use'
        ]);

        $this->session->set_flashdata('success', 'Transaksi sewa dimulai!');
        redirect('rentals');
    }
    public function delete($id)
    {
    $rental = $this->Rental_model->find($id);
    if (!$rental) show_404();

    // Jika transaksi masih berjalan, tidak boleh dihapus
    if ($rental->status == 'ongoing') {
        $this->session->set_flashdata('error', 'Tidak dapat menghapus transaksi yang masih berjalan. Selesaikan dulu.');
        return redirect('rentals');
        }

    // Hapus transaksi
    $this->Rental_model->delete($id);

    $this->session->set_flashdata('success', 'Transaksi berhasil dihapus.');
    return redirect('rentals');
    }


    public function finish($id) {
        $rental = $this->Rental_model->find($id);

        if (!$rental) show_404();

        $end_time = date('Y-m-d H:i:s');

        // Hitung durasi
        $start = new DateTime($rental->start_time);
        $end   = new DateTime($end_time);
        $diff  = $start->diff($end);

        $duration_minutes = ($diff->h * 60) + $diff->i + ($diff->s > 0 ? 1 : 0);

        // Hitung biaya
        $cost_per_minute = $this->rate_per_hour / 60;
        $total_cost = round($cost_per_minute * $duration_minutes);

        // Update transaksi
        $this->Rental_model->update($id, [
            'end_time'        => $end_time,
            'duration_minutes'=> $duration_minutes,
            'total_cost'      => $total_cost,
            'status'          => 'finished'
        ]);

        // Kembalikan status PS
        $this->Console_model->update($rental->console_id, [
            'status' => 'available'
        ]);

        $this->session->set_flashdata('success', 'Sewa selesai. Total biaya: Rp '.number_format($total_cost));
        redirect('rentals');
    }
}
