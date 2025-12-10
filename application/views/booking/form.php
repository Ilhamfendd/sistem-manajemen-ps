<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white p-3">
                    <h4 class="mb-0"><i class="fas fa-calendar-check"></i> <?= $title ?></h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="<?= site_url('booking/store') ?>" id="bookingForm">
                        <!-- Customer Info (Read-only) -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Nama Pelanggan</label>
                                    <div class="form-control-plaintext" style="padding: 0.375rem 0;">
                                        <strong><?= $full_name ?></strong>
                                    </div>
                                    <input type="hidden" name="full_name" value="<?= $full_name ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Nomor HP</label>
                                    <div class="form-control-plaintext" style="padding: 0.375rem 0;">
                                        <strong><?= $phone ?></strong>
                                    </div>
                                    <input type="hidden" name="phone" value="<?= $phone ?>">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Booking Details -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Unit PS <span class="text-danger">*</span></label>
                                    <select name="console_id" class="form-control" required onchange="updatePrice()">
                                        <option value="">-- Pilih Unit --</option>
                                        <?php foreach ($consoles as $console): ?>
                                        <option value="<?= $console['id'] ?>" data-price="<?= $console['price_per_hour'] ?>">
                                            <?= $console['console_name'] ?> (<?= $console['console_type'] ?>) - Rp <?= number_format($console['price_per_hour']) ?>/jam
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Tanggal Pesan <span class="text-danger">*</span></label>
                                    <input type="date" name="booking_date" class="form-control" required 
                                           min="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="booking_start_time" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bold">Durasi (Jam) <span class="text-danger">*</span></label>
                                    <input type="number" name="duration_hours" class="form-control" required 
                                           min="0.5" step="0.5" value="1" onchange="updatePrice()" placeholder="Masukkan durasi">
                                </div>
                            </div>
                        </div>

                        <!-- Price Info -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light border">
                                    <div class="card-body">
                                        <h6 class="mb-2">Ringkasan Biaya</h6>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Harga per Jam:</span>
                                            <strong id="pricePerHour">Rp 0</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Durasi:</span>
                                            <strong id="durationDisplay">0 jam</strong>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">Estimasi Total:</span>
                                            <strong class="text-success" style="font-size: 1.2rem;" id="totalPrice">Rp 0</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                <i class="fas fa-check"></i> Konfirmasi Booking
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
function updatePrice() {
    const consoleSelect = document.querySelector('select[name="console_id"]');
    const durationInput = document.querySelector('input[name="duration_hours"]');
    
    const selectedOption = consoleSelect.options[consoleSelect.selectedIndex];
    const pricePerHour = parseInt(selectedOption.dataset.price) || 0;
    const duration = parseFloat(durationInput.value) || 0;
    
    const totalPrice = Math.ceil(duration) * pricePerHour;
    
    // Update display
    document.getElementById('pricePerHour').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(pricePerHour);
    document.getElementById('durationDisplay').textContent = duration + ' jam';
    document.getElementById('totalPrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalPrice);
}

// Update price on page load and when inputs change
document.addEventListener('DOMContentLoaded', function() {
    updatePrice();
    document.querySelector('select[name="console_id"]').addEventListener('change', updatePrice);
    document.querySelector('input[name="duration_hours"]').addEventListener('change', updatePrice);
    
    // Handle form submission
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        
        const formData = new FormData(this);
        
        fetch('<?= site_url('booking/store') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect ke halaman status booking
                window.location.href = '<?= site_url('booking/booking_status') ?>/' + data.booking_id;
            } else {
                alert('Error: ' + data.message);
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check"></i> Konfirmasi Booking';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check"></i> Konfirmasi Booking';
        });
    });
});
</script>

<?php $this->load->view('layouts/footer'); ?>
