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
            <div class="notification notification-info notification-flash" style="display: flex;">
                <div class="notification-icon"><i class="fas fa-info-circle"></i></div>
                <div class="notification-content">
                    <p class="notification-message">Tidak ada booking yang menunggu persetujuan</p>
                </div>
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>ID Pelanggan</th>
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
                        <td><?= $b['customer_id'] ?></td>
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

    <script>
    // Define all booking actions globally so onclick handlers can access them
    window.approveBooking = function(bookingId) {
        console.log('Approve button clicked for booking ID:', bookingId);
        showConfirm('Setuju booking ini?', 'Setujui Booking', () => {
            console.log('Sending approve request');
            fetch('<?= site_url('booking/approve') ?>/' + bookingId, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                console.log('Response:', data);
                if (data.success) {
                    notify.success(data.message, 'Booking Disetujui');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    notify.error(data.message || 'Gagal', 'Error');
                }
            })
            .catch(e => {
                console.error('Fetch error:', e);
                notify.error('Error: ' + e.message, 'Network Error');
            });
        });
    };

    window.rejectBooking = function(bookingId) {
        console.log('Reject button clicked for booking ID:', bookingId);
        showConfirm('Tolak booking ini?', 'Tolak Booking', () => {
            console.log('Sending reject request');
            fetch('<?= site_url('booking/reject') ?>/' + bookingId, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                console.log('Response:', data);
                if (data.success) {
                    notify.success(data.message, 'Booking Ditolak');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    notify.error(data.message || 'Gagal', 'Error');
                }
            })
            .catch(e => {
                console.error('Fetch error:', e);
                notify.error('Error: ' + e.message, 'Network Error');
            });
        });
    };

    window.customerArrived = function(bookingId) {
        console.log('Customer arrived clicked for booking ID:', bookingId);
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
                    notify.error(data.message, 'Error');
                }
            })
            .catch(e => notify.error('Error: ' + e.message, 'Network Error'));
        });
    };
    </script>
    <div class="mb-5">
        <div class="d-flex align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-check text-info"></i> Booking Disetujui - Tunggu Pelanggan</h4>
            <span class="badge bg-info ms-2"><?= count($approved_bookings) ?></span>
        </div>
        
        <?php if (empty($approved_bookings)): ?>
            <div class="notification notification-info notification-flash" style="display: flex;">
                <div class="notification-icon"><i class="fas fa-info-circle"></i></div>
                <div class="notification-content">
                    <p class="notification-message">Tidak ada booking yang disetujui</p>
                </div>
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>ID Pelanggan</th>
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
                        <td><?= $b['customer_id'] ?></td>
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
                                <div class="d-grid gap-2" style="grid-template-columns: 1fr 1fr;">
                                    <button type="button" class="btn btn-sm btn-warning" id="pauseBtn-<?= $r->id ?>" 
                                            onclick="pauseRental_<?= $r->id ?>()" style="font-size: 0.8rem;">
                                        <i class="fas fa-pause"></i> Pause
                                    </button>
                                    <a href="<?= site_url('rentals/finish/'.$r->id) ?>" class="btn btn-sm btn-success" style="font-size: 0.8rem;">
                                        <i class="fas fa-check"></i> Selesai
                                    </a>
                                </div>
                            <?php else: ?>
                                <a href="<?= site_url('rentals/start_play/'.$r->id) ?>" class="btn btn-sm btn-primary w-100" style="font-size: 0.8rem;">
                                    <i class="fas fa-play"></i> Mulai Bermain
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
                            <th>Jam Pemainan</th>
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
                                $start_time = date('H:i', strtotime($r->start_time));
                                $end_time = date('H:i', strtotime($r->end_time));
                                echo $start_time . ' - ' . $end_time;
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
    
    let isPaused = false;
    let pausedSeconds = 0;
    let interval = null;
    
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
    
    // Pause button handler
    window['pauseRental_' + rentalId] = function() {
        if (timerStartedAt && !isPaused) {
            isPaused = true;
            pausedSeconds = remainingSeconds;
            if (interval) clearInterval(interval);
            
            const pauseBtn = document.getElementById('pauseBtn-' + rentalId);
            if (pauseBtn) {
                pauseBtn.innerHTML = '<i class="fas fa-play"></i> Lanjut';
                pauseBtn.classList.remove('btn-warning');
                pauseBtn.classList.add('btn-info');
            }
        } else if (isPaused) {
            // Resume
            isPaused = false;
            
            const pauseBtn = document.getElementById('pauseBtn-' + rentalId);
            if (pauseBtn) {
                pauseBtn.innerHTML = '<i class="fas fa-pause"></i> Pause';
                pauseBtn.classList.remove('btn-info');
                pauseBtn.classList.add('btn-warning');
            }
            
            startCountdown();
        }
    };
    
    function startCountdown() {
        if (interval) clearInterval(interval);
        
        interval = setInterval(() => {
            if (!isPaused) {
                remainingSeconds--;
                durationElement.textContent = displayTime(remainingSeconds);
                
                if (remainingSeconds <= 0) {
                    clearInterval(interval);
                    window.location.href = "<?= site_url('rentals/finish/') ?>" + rentalId;
                }
            }
        }, 1000);
    }
    
    // If timer was already started, run countdown
    if (timerStartedAt) {
        startCountdown();
    }
})();
<?php endforeach; ?>
</script>

<script>
// Handle booking approve
function approveBooking(bookingId) {
    console.log('Approve button clicked for booking ID:', bookingId);
    console.log('showConfirm function exists:', typeof showConfirm);
    
    showConfirm('Setuju booking ini?', 'Setujui Booking', () => {
        console.log('Confirm clicked, sending approve request');
        fetch('<?= site_url('booking/approve') ?>/' + bookingId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(r => {
            console.log('Response status:', r.status);
            return r.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                notify.success(data.message, 'Booking Disetujui');
                setTimeout(() => location.reload(), 1000);
            } else {
                notify.error(data.message || 'Gagal menyetujui booking', 'Gagal Menyetujui');
            }
        })
        .catch(e => {
            console.error('Fetch error:', e);
            notify.error('Error: ' + e, 'Kesalahan Jaringan');
        });
    });
}

// Handle booking reject
function rejectBooking(bookingId) {
    console.log('Reject button clicked for booking ID:', bookingId);
    
    showConfirm('Tolak booking ini?', 'Tolak Booking', () => {
        console.log('Confirm clicked, sending reject request');
        fetch('<?= site_url('booking/reject') ?>/' + bookingId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(r => {
            console.log('Response status:', r.status);
            return r.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                notify.success(data.message, 'Booking Ditolak');
                setTimeout(() => location.reload(), 1000);
            } else {
                notify.error(data.message || 'Gagal menolak booking', 'Gagal Menolak');
            }
        })
        .catch(e => {
            console.error('Fetch error:', e);
            notify.error('Error: ' + e, 'Kesalahan Jaringan');
        });
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


// Timer countdown untuk approved bookings - SYNCHRONIZED DENGAN CUSTOMER VIEW
// First, calibrate client time dengan server time
document.addEventListener('DOMContentLoaded', function() {
    const serverTimeStr = '<?= date('Y-m-d H:i:s') ?>';
    const serverTime = new Date(serverTimeStr).getTime();
    const clientTimeAtLoad = new Date().getTime();
    const timeOffset = serverTime - clientTimeAtLoad;
    
    console.log('[Kasir Timer] Server time:', serverTimeStr, 'Offset:', timeOffset);
    
    window.getServerTime = function() {
        return new Date().getTime() + timeOffset;
    };
    
    window.updateApprovedTimers = function() {
        const now = window.getServerTime();
        let activeTimers = 0;
        
        document.querySelectorAll('.timer').forEach(timerEl => {
            const expiresAt = timerEl.dataset.expires;
            if (!expiresAt) return;
            
            const expireTime = new Date(expiresAt).getTime();
            const remaining = Math.floor((expireTime - now) / 1000);
            
            activeTimers++;
            
            if (remaining <= 0) {
                timerEl.innerHTML = '<small class="text-danger fw-bold">Waktu Habis</small>';
                return;
            }
            
            const minutes = Math.max(0, Math.floor(remaining / 60));
            const seconds = Math.max(0, remaining % 60);
            const timeStr = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
            
            timerEl.innerHTML = '<small class="text-danger fw-bold">' + timeStr + '</small>';
        });
        
        if (activeTimers > 0) {
            console.log('[Kasir Timer] Updated', activeTimers, 'timers');
        }
    };
    
    // Update timers setiap detik
    setInterval(window.updateApprovedTimers, 1000);
    window.updateApprovedTimers(); // Initial update
});

// Periodic check untuk auto-finish expired rentals (setiap 20 detik)
setInterval(() => {
    fetch('<?= site_url('rentals/check_expired_and_finish') ?>', {
        method: 'POST'
    })
    .then(r => r.json())
    .then(data => {
        if (data.success && data.finished > 0) {
            // Refresh halaman jika ada rental yang selesai
            setTimeout(() => {
                location.reload();
            }, 500);
        }
    })
    .catch(e => console.error('Auto-finish check error:', e));
}, 20000);
