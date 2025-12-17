<?php $this->load->view('layouts/header_booking', ['title' => $title]); ?>

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
                    <div class="notification notification-error notification-flash" style="display: flex;">
                        <div class="notification-icon"><i class="fas fa-clock"></i></div>
                        <div class="notification-content">
                            <p class="notification-title">⏰ WAKTU UNTUK TIBA KE LOKASI</p>
                            <h2 class="text-danger fw-bold" id="countdown" style="margin: 8px 0;">
                                <span id="minutes">--</span>:<span id="seconds">--</span>
                            </h2>
                            <p class="notification-message">Datang dalam waktu ini atau booking otomatis dibatalkan</p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- QR Code Section -->
                    <div class="row mb-4 pb-4 border-bottom">
                        <div class="col-12">
                            <h6 class="text-muted mb-3">ID Pelanggan Anda</h6>
                            <div class="text-center">
                                <h3 class="mb-3 text-primary"><strong><?= $booking['customer_id'] ?></strong></h3>
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($booking['customer_id']) ?>" 
                                     alt="QR Code Customer ID" class="img-fluid" style="max-width: 200px;">
                                <p class="text-muted mt-2 mb-0" style="font-size: 0.9rem;">
                                    Simpan atau scan QR code ini untuk proses booking berikutnya
                                </p>
                            </div>
                        </div>
                    </div>

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
// Calibrate server time dengan client time
const serverTime = new Date('<?= date('Y-m-d H:i:s') ?>').getTime();
const clientTimeAtLoad = new Date().getTime();
const timeOffset = serverTime - clientTimeAtLoad;

function getServerTime() {
    return new Date().getTime() + timeOffset;
}

// Calculate remaining time dari expires_at
const expiresAt = new Date('<?= $booking["expires_at"] ?>').getTime();

function updateCountdown() {
    const now = getServerTime();
    const remaining = Math.floor((expiresAt - now) / 1000);
    
    const minutes = Math.floor(remaining / 60);
    const seconds = remaining % 60;
    
    document.getElementById('minutes').textContent = String(Math.max(0, minutes)).padStart(2, '0');
    document.getElementById('seconds').textContent = String(Math.max(0, seconds)).padStart(2, '0');
    
    if (remaining <= 0) {
        document.getElementById('countdown').innerHTML = '<span class="text-danger">⏰ WAKTU HABIS!</span>';
        clearInterval(countdownInterval);
        return;
    }
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
