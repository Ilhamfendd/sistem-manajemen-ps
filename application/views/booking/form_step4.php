<?php $this->load->view('layouts/header_booking', ['title' => $title]); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="mb-0"><i class="fas fa-clock"></i> <?= $title ?></h5>
                    <small>Langkah 4 dari 4 - Konfirmasi Booking</small>
                </div>
                <div class="card-body p-4">
                    <div class="progress mb-4">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>

                    <form id="step4Form" method="POST" action="<?= site_url('booking/store') ?>">
                        <input type="hidden" name="phone" value="<?= $phone ?>">
                        <input type="hidden" name="full_name" value="<?= $full_name ?>">
                        <input type="hidden" name="console_id" value="<?= $console['id'] ?>">

                        <!-- Summary Section -->
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h6 class="card-title mb-3">📋 Ringkasan Booking</h6>
                                <div class="row mb-2">
                                    <div class="col-6"><small class="text-muted">Nama:</small></div>
                                    <div class="col-6"><strong><?= $full_name ?></strong></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6"><small class="text-muted">No HP:</small></div>
                                    <div class="col-6"><strong><?= $phone ?></strong></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6"><small class="text-muted">Unit:</small></div>
                                    <div class="col-6"><strong><?= $console['console_name'] ?></strong></div>
                                </div>
                                <div class="row">
                                    <div class="col-6"><small class="text-muted">Harga/Jam:</small></div>
                                    <div class="col-6"><strong>Rp <?= number_format($console['price_per_hour'], 0, ',', '.') ?></strong></div>
                                </div>
                            </div>
                        </div>

                        <!-- Duration & Timing -->
                        <div class="mb-4">
                            <h6 class="mb-3">⏱️ Durasi & Waktu</h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Booking <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-lg" id="booking_date" 
                                       name="booking_date" min="<?= date('Y-m-d') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Jam Mulai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control form-control-lg" id="booking_start_time" 
                                       name="booking_start_time" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Durasi <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <input type="number" class="form-control" id="duration_hours" 
                                           name="duration_hours" min="0.5" step="0.5" value="1" required>
                                    <span class="input-group-text">jam</span>
                                </div>
                                <small class="text-muted">Contoh: 1, 1.5, 2, 2.5 jam</small>
                            </div>
                        </div>

                        <!-- Price Calculation -->
                        <div class="card bg-info bg-opacity-10 mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h6 class="mb-0 text-info">Total Biaya</h6>
                                        <small class="text-muted" id="calculation">1 jam × Rp <?= number_format($console['price_per_hour'], 0, ',', '.') ?></small>
                                    </div>
                                    <div class="col-4 text-end">
                                        <h4 class="mb-0 text-info" id="totalPrice">Rp <?= number_format($console['price_per_hour'], 0, ',', '.') ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="error" class="alert alert-danger d-none" role="alert"></div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle"></i> Konfirmasi Booking
                            </button>
                            <a href="<?= site_url('booking') ?>" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const pricePerHour = <?= $console['price_per_hour'] ?>;

function updatePrice() {
    const duration = parseFloat(document.getElementById('duration_hours').value) || 1;
    const total = pricePerHour * duration;
    
    document.getElementById('calculation').textContent = 
        duration + ' jam × Rp ' + pricePerHour.toLocaleString('id-ID', {style: 'currency', currency: 'IDR'}).replace('IDR ', '');
    document.getElementById('totalPrice').textContent = 
        'Rp ' + total.toLocaleString('id-ID', {style: 'currency', currency: 'IDR'}).replace('IDR ', '');
}

document.getElementById('duration_hours').addEventListener('change', updatePrice);
document.getElementById('duration_hours').addEventListener('input', updatePrice);

document.getElementById('step4Form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const bookingDate = document.getElementById('booking_date').value;
    const bookingTime = document.getElementById('booking_start_time').value;
    const duration = parseFloat(document.getElementById('duration_hours').value);
    const errorDiv = document.getElementById('error');
    
    if (!bookingDate || !bookingTime || !duration) {
        errorDiv.textContent = 'Semua field harus diisi';
        errorDiv.classList.remove('d-none');
        return;
    }
    
    if (duration < 0.5) {
        errorDiv.textContent = 'Durasi minimal 0.5 jam';
        errorDiv.classList.remove('d-none');
        return;
    }
    
    errorDiv.classList.add('d-none');
    this.submit();
});
</script>

<?php $this->load->view('layouts/footer'); ?>
