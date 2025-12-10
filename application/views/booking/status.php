<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Status Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white p-4">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Status Booking Anda</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Detail Unit -->
                    <div class="row mb-4 pb-4 border-bottom">
                        <div class="col-md-6">
                            <h6 class="text-muted">Unit PS</h6>
                            <h5 class="mb-2"><?= $booking['console_name'] ?></h5>
                            <p class="mb-2">
                                <span class="badge bg-secondary"><?= $booking['console_type'] ?></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Harga Per Jam</h6>
                            <h5 class="text-success">Rp <?= number_format($booking['price_per_hour']) ?></h5>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="row mb-4 pb-4 border-bottom">
                        <div class="col-12">
                            <h6 class="text-muted mb-3">Status Booking</h6>
                            <div>
                                <?php 
                                $status_badge = '';
                                $status_text = '';
                                switch($booking['status']) {
                                    case 'pending':
                                        $status_badge = 'warning';
                                        $status_text = 'Menunggu Persetujuan Kasir';
                                        break;
                                    case 'approved':
                                        $status_badge = 'success';
                                        $status_text = 'Disetujui Kasir - Segera Datang!';
                                        break;
                                    case 'waiting_customer':
                                        $status_badge = 'info';
                                        $status_text = 'Kasir Menunggu Anda Tiba';
                                        break;
                                    case 'completed':
                                        $status_badge = 'secondary';
                                        $status_text = 'Selesai';
                                        break;
                                    default:
                                        $status_badge = 'danger';
                                        $status_text = 'Dibatalkan';
                                }
                                ?>
                                <h4><span class="badge bg-<?= $status_badge ?> p-3"><?= $status_text ?></span></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Timer (if approved) -->
                    <?php if($booking['status'] == 'approved' && $remaining_time !== null): ?>
                    <div class="alert alert-danger mb-4" role="alert">
                        <div class="text-center">
                            <h6 class="text-danger mb-2">⏰ WAKTU UNTUK TIBA KE LOKASI</h6>
                            <h2 class="text-danger fw-bold" id="countdown">
                                <span id="minutes">--</span>:<span id="seconds">--</span>
                            </h2>
                            <p class="text-muted small">Datang dalam waktu ini atau booking otomatis dibatalkan</p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Detail Booking -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Tanggal Booking</h6>
                            <p class="mb-0"><?= date('d/m/Y', strtotime($booking['booking_date'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Jam Mulai</h6>
                            <p class="mb-0"><?= $booking['booking_start_time'] ?></p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Durasi</h6>
                            <p class="mb-0"><?= $booking['duration_hours'] ?> jam</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Estimasi Total</h6>
                            <p class="mb-0"><strong class="text-success">Rp <?= number_format($booking['estimated_cost']) ?></strong></p>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="alert alert-info mb-4" role="alert">
                        <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Instruksi Penting:</h6>
                        <ul class="mb-0 small">
                            <?php if($booking['status'] == 'pending'): ?>
                                <li>Tunggu kasir mengkonfirmasi booking Anda</li>
                                <li>Anda akan menerima SMS/telepon dari kasir</li>
                                <li>Jika disetujui, datang segera ke lokasi</li>
                            <?php elseif($booking['status'] == 'approved'): ?>
                                <li><strong>🔥 Booking Anda DISETUJUI! Segera datang ke lokasi!</strong></li>
                                <li>Anda memiliki waktu 15 menit untuk tiba</li>
                                <li>Siapkan uang untuk pembayaran sejumlah: <strong>Rp <?= number_format($booking['estimated_cost']) ?></strong></li>
                                <li>Jika tidak datang dalam 15 menit, booking akan dibatalkan</li>
                            <?php elseif($booking['status'] == 'waiting_customer'): ?>
                                <li>Kasir telah siap menunggu Anda</li>
                                <li>Silakan datang dan lakukan pembayaran</li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="<?= site_url('booking') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if($booking['status'] == 'approved' && $remaining_time !== null): ?>
<script>
let remainingSeconds = <?= (int)$remaining_time ?>;

function updateCountdown() {
    const minutes = Math.floor(remainingSeconds / 60);
    const seconds = remainingSeconds % 60;
    
    document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
    document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
    
    if (remainingSeconds <= 0) {
        document.getElementById('countdown').innerHTML = '<span class="text-danger">⏰ WAKTU HABIS!</span>';
        clearInterval(countdownInterval);
        return;
    }
    
    remainingSeconds--;
}

updateCountdown();
const countdownInterval = setInterval(updateCountdown, 1000);

// Auto-refresh page setiap 5 detik untuk cek status terbaru
setInterval(() => {
    location.reload();
}, 5000);
</script>
<?php endif; ?>

<?php $this->load->view('layouts/footer'); ?>
