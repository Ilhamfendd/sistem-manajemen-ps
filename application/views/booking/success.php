<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center shadow">
                <div class="card-body p-5">
                    <div style="font-size: 4rem; color: #28a745; margin-bottom: 20px;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    
                    <h2 class="mb-3">Booking Berhasil!</h2>
                    
                    <p class="text-muted mb-4">
                        Booking Anda telah dibuat dan dikirim ke kasir untuk dikonfirmasi.
                    </p>

                    <div class="alert alert-info" role="alert">
                        <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Instruksi Selanjutnya:</h6>
                        <ul class="mb-0 text-start">
                            <li>Tunggu konfirmasi dari kasir via SMS atau telepon</li>
                            <li>Kasir akan mengkonfirmasi apakah booking diterima atau ditolak</li>
                            <li>Jika diterima, datang ke lokasi sesuai waktu yang telah ditentukan</li>
                            <li><strong>Anda memiliki waktu 15 menit untuk tiba dan melakukan pembayaran</strong></li>
                            <li>Jika tidak datang dalam 15 menit, booking akan otomatis dibatalkan</li>
                        </ul>
                    </div>

                    <div class="alert alert-warning" role="alert">
                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Perhatian:</h6>
                        <p class="mb-0 text-start">
                            Pastikan nomor HP Anda aktif dan siap menerima konfirmasi dari kasir. 
                            Jangan lupa untuk datang tepat waktu dan siapkan uang untuk pembayaran.
                        </p>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <a href="<?= site_url('booking') ?>" class="btn btn-primary btn-lg">
                            <i class="fas fa-home"></i> Kembali ke Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
