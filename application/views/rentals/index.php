<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<style>
.rental-cards-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 30px;
}

.rental-card-wrapper {
    flex: 0 0 calc(25% - 6px);
}

@media (max-width: 1199px) {
    .rental-card-wrapper {
        flex: 0 0 calc(33.333% - 6px);
    }
}

@media (max-width: 767px) {
    .rental-card-wrapper {
        flex: 0 0 calc(50% - 4px);
    }
}

@media (max-width: 575px) {
    .rental-card-wrapper {
        flex: 0 0 100%;
    }
}
</style>

<div class="container mt-4">
    <?php $this->load->view('layouts/notifications'); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-cash-register"></i> <?= $title ?></h2>
        <a class="btn btn-primary" href="<?= site_url('rentals/create') ?>">
            Mulai Penyewaan Baru
        </a>
    </div>

    <!-- BOOKING PENDING SECTION -->
    <div class="mb-5">
        <div class="d-flex align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-hourglass-half text-warning"></i> Booking Menunggu Persetujuan</h4>
            <span class="badge bg-warning ms-2"><?= count($pending_bookings) ?></span>
        </div>
        
        <?php if (empty($pending_bookings)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Tidak ada booking yang menunggu persetujuan
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>No HP</th>
                        <th>Unit PS</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending_bookings as $b): ?>
                    <tr>
                        <td><strong>#<?= $b['id'] ?></strong></td>
                        <td><?= $b['full_name'] ?></td>
                        <td><?= $b['phone'] ?></td>
                        <td><?= $b['console_name'] ?> (<?= $b['console_type'] ?>)</td>
                        <td><?= $b['duration_hours'] ?> jam</td>
                        <td><strong>Rp <?= number_format($b['estimated_cost']) ?></strong></td>
                        <td>
                            <button class="btn btn-sm btn-success" onclick="approveBooking(<?= $b['id'] ?>)">
                                <i class="fas fa-check"></i> Setuju
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="rejectBooking(<?= $b['id'] ?>)">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <!-- BOOKING APPROVED SECTION -->
    <div class="mb-5">
        <div class="d-flex align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-check text-info"></i> Booking Disetujui - Tunggu Pelanggan</h4>
            <span class="badge bg-info ms-2"><?= count($approved_bookings) ?></span>
        </div>
        
        <?php if (empty($approved_bookings)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Tidak ada booking yang disetujui
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>No HP</th>
                        <th>Unit PS</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Timer</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($approved_bookings as $b): ?>
                    <tr class="table-info">
                        <td><strong>#<?= $b['id'] ?></strong></td>
                        <td><?= $b['full_name'] ?></td>
                        <td><?= $b['phone'] ?></td>
                        <td><?= $b['console_name'] ?> (<?= $b['console_type'] ?>)</td>
                        <td><?= $b['duration_hours'] ?> jam</td>
                        <td><strong>Rp <?= number_format($b['estimated_cost']) ?></strong></td>
                        <td>
                            <div class="timer" id="timer_<?= $b['id'] ?>" data-expires="<?= $b['expires_at'] ?>">
                                <small class="text-danger fw-bold">--:--</small>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="customerArrived(<?= $b['id'] ?>)">
                                <i class="fas fa-user-check"></i> Pelanggan Datang
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <!-- ONGOING RENTALS SECTION -->
    <div class="mb-5">
        <div class="d-flex align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-play-circle text-warning"></i> Penyewaan Berlangsung</h4>
            <span class="badge bg-warning ms-2"><?= count($ongoing) ?></span>
        </div>

        <?php if (empty($ongoing)): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Tidak ada penyewaan yang sedang berlangsung</p>
            </div>
        <?php else: ?>
            <div class="rental-cards-container">
                <?php foreach ($ongoing as $r): ?>
                <div class="rental-card-wrapper">
                    <div class="card shadow-sm border-warning h-100">
                        <div class="card-header bg-warning text-dark p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0" style="font-size: 0.9rem;"><strong>#<?= $r->id ?></strong></h6>
                                <span class="badge bg-dark" style="font-size: 0.7rem;"><?= $r->console_type ?></span>
                            </div>
                        </div>
                        
                        <div class="card-body p-2">
                            <div class="mb-2">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Pelanggan</small>
                                <p class="mb-1" style="font-size: 0.85rem;"><strong><?= substr($r->full_name, 0, 15) ?></strong></p>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Unit</small>
                                <p class="mb-1" style="font-size: 0.85rem;"><i class="fas fa-gamepad"></i> <?= $r->console_name ?></p>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">Mulai</small>
                                    <p class="mb-0" style="font-size: 0.85rem;"><strong><?= date('H:i', strtotime($r->start_time)) ?></strong></p>
                                </div>
                                <div style="text-align: right;">
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">Durasi</small>
                                    <p class="mb-0">
                                        <strong class="text-danger" id="duration-<?= $r->id ?>" style="font-size: 1.1rem;">0:00:00</strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light p-2">
                            <?php if ($r->timer_started_at): ?>
                                <a href="<?= site_url('rentals/finish/'.$r->id) ?>" class="btn btn-sm btn-success w-100" style="font-size: 0.8rem;">
                                    <i class="fas fa-check"></i> Selesai
                                </a>
                            <?php else: ?>
                                <a href="<?= site_url('rentals/start_play/'.$r->id) ?>" class="btn btn-sm btn-primary w-100" style="font-size: 0.8rem;">
                                    <i class="fas fa-play"></i> Play
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- FINISHED RENTALS SECTION -->
    <div>
        <div class="d-flex align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-check-circle text-success"></i> Penyewaan Selesai</h4>
            <span class="badge bg-success ms-2"><?= count($finished) ?></span>
        </div>

        <?php if (empty($finished)): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Belum ada penyewaan yang selesai</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>Unit PS</th>
                            <th>Durasi</th>
                            <th>Total Biaya</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($finished as $r): ?>
                        <tr>
                            <td><strong>#<?= $r->id ?></strong></td>
                            <td><?= $r->full_name ?></td>
                            <td>
                                <?php if ($r->console_type): ?>
                                    <span class="badge bg-info"><?= $r->console_type ?></span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Unit Terhapus</span>
                                <?php endif; ?>
                                <?= $r->console_name ?? '(Konsol tidak ditemukan)' ?>
                            </td>
                            <td>
                                <?php 
                                $hours = floor($r->duration_minutes / 60);
                                $mins = $r->duration_minutes % 60;
                                echo $hours . 'j ' . $mins . 'm';
                                ?>
                            </td>
                            <td><strong class="text-success">Rp <?= number_format($r->total_amount) ?></strong></td>
                            <td>
                                <?php 
                                if ($r->payment_status == 'paid') {
                                    echo '<span class="badge bg-success"><i class="fas fa-check"></i> Lunas</span>';
                                } elseif ($r->payment_status == 'partial') {
                                    echo '<span class="badge bg-warning"><i class="fas fa-exclamation"></i> Sebagian</span>';
                                } else {
                                    echo '<span class="badge bg-danger"><i class="fas fa-times"></i> Belum</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <div style="display: flex; gap: 5px;">
                                    <?php if ($r->payment_status == 'partial' || $r->payment_status == 'pending'): ?>
                                        <a href="<?= site_url('rentals/collect_payment/'.$r->id) ?>" class="btn btn-sm btn-warning" title="Terima Pembayaran">
                                            <i class="fas fa-money-bill"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= site_url('rentals/delete/'.$r->id) ?>" class="btn btn-sm btn-danger" 
                                        onclick="showConfirm('Hapus penyewaan #<?= $r->id ?>?', 'Hapus Penyewaan', () => window.location.href=this.href); return false;" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
<?php foreach ($ongoing as $r): ?>
(function() {
    const estimatedHours = <?= $r->estimated_hours ?>;
    const rentalId = <?= $r->id ?>;
    const totalSeconds = estimatedHours * 3600;
    const timerStartedAt = '<?= $r->timer_started_at ?? '' ?>';
    
    function displayTime(seconds) {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const secs = seconds % 60;
        
        return (hours < 10 ? "0" + hours : hours) + ":" +
               (minutes < 10 ? "0" + minutes : minutes) + ":" +
               (secs < 10 ? "0" + secs : secs);
    }
    
    function calculateRemainingTime() {
        if (!timerStartedAt) {
            return totalSeconds;
        }
        
        const startTime = new Date(timerStartedAt).getTime();
        const now = new Date().getTime();
        const elapsedMs = now - startTime;
        const elapsedSec = Math.floor(elapsedMs / 1000);
        
        let remaining = totalSeconds - elapsedSec;
        if (remaining < 0) remaining = 0;
        return remaining;
    }
    
    const durationElement = document.getElementById("duration-" + rentalId);
    if (!durationElement) return;
    
    // Calculate and display initial time
    let remainingSeconds = calculateRemainingTime();
    durationElement.textContent = displayTime(remainingSeconds);
    
    // If timer was already started, run countdown
    if (timerStartedAt) {
        const interval = setInterval(() => {
            remainingSeconds--;
            durationElement.textContent = displayTime(remainingSeconds);
            
            if (remainingSeconds <= 0) {
                clearInterval(interval);
                window.location.href = "<?= site_url('rentals/finish/') ?>" + rentalId;
            }
        }, 1000);
    }
})();
<?php endforeach; ?>
</script>

<script>
// Handle booking approve
function approveBooking(bookingId) {
    showConfirm('Setuju booking ini?', 'Setujui Booking', () => {
        fetch('<?= site_url('booking/approve') ?>/' + bookingId, {
            method: 'POST'
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                notify.success(data.message, 'Booking Disetujui');
                setTimeout(() => location.reload(), 1000);
            } else {
                notify.error(data.message, 'Gagal Menyetujui');
            }
        })
        .catch(e => notify.error('Error: ' + e, 'Kesalahan Jaringan'));
    });
}

// Handle booking reject
function rejectBooking(bookingId) {
    showConfirm('Tolak booking ini?', 'Tolak Booking', () => {
        fetch('<?= site_url('booking/reject') ?>/' + bookingId, {
            method: 'POST'
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                notify.success(data.message, 'Booking Ditolak');
                setTimeout(() => location.reload(), 1000);
            } else {
                notify.error(data.message, 'Gagal Menolak');
            }
        })
        .catch(e => notify.error('Error: ' + e, 'Kesalahan Jaringan'));
    });
}

// Handle customer arrived
function customerArrived(bookingId) {
    showConfirm('Pelanggan telah tiba? Lanjutkan ke pembayaran?', 'Konfirmasi Kedatangan', () => {
        fetch('<?= site_url('booking/customer_arrived') ?>/' + bookingId, {
            method: 'POST'
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                notify.success(data.message, 'Lanjut ke Pembayaran');
                setTimeout(() => {
                    window.location.href = '<?= site_url('rentals/initial_payment') ?>/' + data.rental_id;
                }, 1000);
            } else {
                notify.error(data.message, 'Gagal Melanjutkan');
            }
        })
        .catch(e => notify.error('Error: ' + e, 'Kesalahan Jaringan'));
    });
}


// Timer countdown untuk approved bookings
// First, calibrate client time dengan server time
const serverTime = new Date('<?= date('Y-m-d H:i:s') ?>').getTime();
const clientTimeAtLoad = new Date().getTime();
const timeOffset = serverTime - clientTimeAtLoad;

function getServerTime() {
    return new Date().getTime() + timeOffset;
}

function updateApprovedTimers() {
    const now = getServerTime();
    document.querySelectorAll('.timer').forEach(timerEl => {
        const expiresAt = timerEl.dataset.expires;
        const expireTime = new Date(expiresAt).getTime();
        const remaining = expireTime - now;
        
        if (remaining <= 0) {
            timerEl.innerHTML = '<small class="text-danger fw-bold">Waktu Habis</small>';
            return;
        }
        
        const minutes = Math.floor((remaining / (1000 * 60)) % 60);
        const seconds = Math.floor((remaining / 1000) % 60);
        const timeStr = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
        
        timerEl.innerHTML = '<small class="text-danger fw-bold">' + timeStr + '</small>';
    });
}

// Update timers setiap detik
setInterval(updateApprovedTimers, 1000);
updateApprovedTimers(); // Initial update
</script>

<?php $this->load->view('layouts/footer'); ?>
