<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-tasks"></i> <?= $title ?></h2>
        <a href="<?= site_url('booking') ?>" class="btn btn-outline-primary">
            <i class="fas fa-plus"></i> Buat Booking Baru
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- PENDING BOOKINGS -->
    <div class="mb-5">
        <div class="d-flex align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-hourglass-half text-warning"></i> Booking Menunggu Konfirmasi</h4>
            <span class="badge bg-warning ms-2"><?= count($pending) ?></span>
        </div>

        <?php if (empty($pending)): ?>
            <div class="notification notification-info notification-flash" style="display: flex;">
                <div class="notification-icon"><i class="fas fa-inbox"></i></div>
                <div class="notification-content">
                    <p class="notification-message">Tidak ada booking yang menunggu konfirmasi</p>
                </div>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>No. HP</th>
                            <th>Unit PS</th>
                            <th>Tanggal & Jam</th>
                            <th>Durasi</th>
                            <th>Biaya Est.</th>
                            <th>Countdown</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending as $booking): ?>
                        <tr class="booking-row-<?= $booking['id'] ?>" id="booking-<?= $booking['id'] ?>">
                            <td><strong>#<?= $booking['id'] ?></strong></td>
                            <td><?= $booking['full_name'] ?></td>
                            <td><?= $booking['phone'] ?></td>
                            <td>
                                <span class="badge bg-info"><?= $booking['console_type'] ?? 'N/A' ?></span>
                                <?= $booking['console_name'] ?? '(Not found)' ?>
                            </td>
                            <td>
                                <?= date('d/m/Y H:i', strtotime($booking['booking_date'] . ' ' . $booking['booking_start_time'])) ?>
                            </td>
                            <td><?= $booking['duration_hours'] ?> jam</td>
                            <td><strong class="text-success">Rp <?= number_format($booking['estimated_cost']) ?></strong></td>
                            <td>
                                <span class="badge bg-danger countdown-<?= $booking['id'] ?>" 
                                      data-expires="<?= $booking['expires_at'] ?>">
                                    <i class="fas fa-clock"></i> <span class="time-left">00:00</span>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-success" 
                                            onclick="approveBooking(<?= $booking['id'] ?>)" title="Terima">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="rejectBooking(<?= $booking['id'] ?>)" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- APPROVED BOOKINGS (waiting for customer payment) -->
    <div>
        <div class="d-flex align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-check-circle text-success"></i> Booking Disetujui (Menunggu Pelanggan)</h4>
            <span class="badge bg-success ms-2"><?= count($approved) ?></span>
        </div>

        <?php if (empty($approved)): ?>
            <div class="notification notification-info notification-flash" style="display: flex;">
                <div class="notification-icon"><i class="fas fa-inbox"></i></div>
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
                            <th>No. HP</th>
                            <th>Unit PS</th>
                            <th>Tanggal & Jam</th>
                            <th>Durasi</th>
                            <th>Biaya Est.</th>
                            <th>Countdown</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($approved as $booking): ?>
                        <tr class="approved-row-<?= $booking['id'] ?>" id="approved-<?= $booking['id'] ?>">
                            <td><strong>#<?= $booking['id'] ?></strong></td>
                            <td><?= $booking['full_name'] ?></td>
                            <td><?= $booking['phone'] ?></td>
                            <td>
                                <span class="badge bg-info"><?= $booking['console_type'] ?? 'N/A' ?></span>
                                <?= $booking['console_name'] ?? '(Not found)' ?>
                            </td>
                            <td>
                                <?= date('d/m/Y H:i', strtotime($booking['booking_date'] . ' ' . $booking['booking_start_time'])) ?>
                            </td>
                            <td><?= $booking['duration_hours'] ?> jam</td>
                            <td><strong class="text-success">Rp <?= number_format($booking['estimated_cost']) ?></strong></td>
                            <td>
                                <span class="badge bg-warning countdown-<?= $booking['id'] ?>" 
                                      data-approved-at="<?= $booking['approved_at'] ?>">
                                    <i class="fas fa-clock"></i> <span class="time-left">00:00</span>
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" 
                                        onclick="confirmArrival(<?= $booking['id'] ?>)" title="Pelanggan Datang & Bayar">
                                    <i class="fas fa-money-bill"></i> Bayar
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Approve Booking -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-check-circle"></i> Terima Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="approveForm">
                <div class="modal-body">
                    <p>Anda akan menerima booking ini. Pelanggan akan menerima notifikasi dan memiliki waktu 15 menit untuk tiba dan melakukan pembayaran.</p>
                    <div class="form-group">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Contoh: Tempat sudah siap, dll..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Terima Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let selectedBookingId = null;

// Update countdown timers
function updateCountdowns() {
    // Pending bookings (expires_at)
    document.querySelectorAll('[data-expires]').forEach(element => {
        const expiresAt = new Date(element.dataset.expires).getTime();
        const now = new Date().getTime();
        const diff = expiresAt - now;
        
        if (diff <= 0) {
            element.querySelector('.time-left').textContent = 'EXPIRED';
            element.classList.add('bg-danger');
        } else {
            const minutes = Math.floor(diff / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            element.querySelector('.time-left').textContent = 
                (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        }
    });

    // Approved bookings (approved_at + 15 minutes)
    document.querySelectorAll('[data-approved-at]').forEach(element => {
        const approvedAt = new Date(element.dataset.approvedAt).getTime();
        const now = new Date().getTime();
        const fifteenMinutes = 15 * 60 * 1000;
        const diff = (approvedAt + fifteenMinutes) - now;
        const bookingId = element.classList[0].split('-')[1]; // Extract booking ID from class
        
        if (diff <= 0) {
            element.querySelector('.time-left').textContent = 'EXPIRED';
            element.classList.add('bg-danger');
            
            // Auto-cancel booking if expired
            if (!element.dataset.cancelled) {
                element.dataset.cancelled = 'true';
                autoCancelBooking(bookingId);
            }
        } else {
            const minutes = Math.floor(diff / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            element.querySelector('.time-left').textContent = 
                (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        }
    });
}

// Update setiap 1 detik
setInterval(updateCountdowns, 1000);
updateCountdowns(); // Initial call

function approveBooking(bookingId) {
    selectedBookingId = bookingId;
    const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
    approveModal.show();
}

document.getElementById('approveForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const notes = document.querySelector('[name="notes"]').value;
    
    window.location.href = '<?= site_url('booking/approve/') ?>' + selectedBookingId + '?notes=' + encodeURIComponent(notes);
});

function rejectBooking(bookingId) {
    showConfirm('Yakin ingin menolak booking #' + bookingId + '?', 'Tolak Booking', () => {
        window.location.href = '<?= site_url('booking/reject/') ?>' + bookingId;
    });
}

function confirmArrival(bookingId) {
    showConfirm('Pelanggan sudah datang dan siap membayar? Ini akan membuat rental baru.', 'Konfirmasi Kedatangan', () => {
        window.location.href = '<?= site_url('booking/process_payment/') ?>' + bookingId;
    });
}
</script>

<?php $this->load->view('layouts/footer'); ?>
