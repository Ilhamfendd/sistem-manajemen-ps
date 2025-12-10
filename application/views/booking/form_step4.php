<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background-color: #f8f9fa; padding: 40px 20px;">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div style="text-align: center;">
                <h3 class="mb-4">Pilih Durasi</h3>

                <form id="step4Form" method="POST" action="<?= site_url('booking/store') ?>">
                    <input type="hidden" name="phone" value="<?= $phone ?>">
                    <input type="hidden" name="full_name" value="<?= $full_name ?>">
                    <input type="hidden" name="console_id" value="<?= $console['id'] ?>">
                    <input type="hidden" name="booking_date" value="<?= date('Y-m-d') ?>">
                    <input type="hidden" name="booking_start_time" value="<?= date('H:i') ?>">

                    <div class="card bg-light mb-4" style="border: none;">
                        <div class="card-body p-3">
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

                    <div class="mb-4">
                        <label class="form-label fw-bold">Durasi <span class="text-danger">*</span></label>
                        <div class="input-group input-group-lg">
                            <input type="number" class="form-control" id="duration_hours" 
                                   name="duration_hours" min="0.5" step="0.5" value="1" required>
                            <span class="input-group-text">jam</span>
                        </div>
                    </div>

                    <div class="alert alert-info mb-4">
                        <small>Total: <span id="calculation">1 jam × Rp <?= number_format($console['price_per_hour'], 0, ',', '.') ?></span></small>
                        <div><strong>Rp <span id="totalPrice"><?= number_format($console['price_per_hour'], 0, ',', '.') ?></span></strong></div>
                    </div>

                    <div id="error" class="alert alert-danger d-none" role="alert"></div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-check-circle"></i> Konfirmasi
                        </button>
                        <a href="<?= site_url('booking') ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const pricePerHour = <?= $console['price_per_hour'] ?>;

function updatePrice() {
    const duration = parseFloat(document.getElementById('duration_hours').value) || 1;
    const total = pricePerHour * duration;
    
    const formattedPrice = pricePerHour.toLocaleString('id-ID');
    const formattedTotal = total.toLocaleString('id-ID');
    
    document.getElementById('calculation').textContent = 
        duration + ' jam × Rp ' + formattedPrice;
    document.getElementById('totalPrice').textContent = formattedTotal;
}

document.getElementById('duration_hours').addEventListener('change', updatePrice);
document.getElementById('duration_hours').addEventListener('input', updatePrice);

document.getElementById('step4Form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const duration = parseFloat(document.getElementById('duration_hours').value);
    const consoleId = document.querySelector('input[name="console_id"]').value;
    const bookingDate = document.querySelector('input[name="booking_date"]').value;
    const errorDiv = document.getElementById('error');
    
    if (!duration) {
        errorDiv.textContent = 'Silakan masukkan durasi';
        errorDiv.classList.remove('d-none');
        return;
    }
    
    if (duration < 0.5) {
        errorDiv.textContent = 'Durasi minimal 0.5 jam';
        errorDiv.classList.remove('d-none');
        return;
    }
    
    // Check availability sebelum submit
    if (!consoleId || !bookingDate) {
        errorDiv.textContent = 'Data tidak lengkap';
        errorDiv.classList.remove('d-none');
        return;
    }
    
    errorDiv.classList.add('d-none');
    
    // Submit via AJAX untuk catch JSON response
    const formData = new FormData(this);
    fetch('<?= site_url('booking/store') ?>', {
        method: 'POST',
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Redirect ke status page
            window.location.href = '<?= site_url('booking/booking_status') ?>/' + data.booking_id;
        } else {
            errorDiv.textContent = data.message;
            errorDiv.classList.remove('d-none');
        }
    })
    .catch(e => {
        errorDiv.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
        errorDiv.classList.remove('d-none');
    });
});
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
