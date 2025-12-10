<?php $this->load->view('layouts/header_booking', ['title' => $title]); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="mb-0"><i class="fas fa-phone"></i> <?= $title ?></h5>
                    <small>Langkah 1 dari 4</small>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h6>Masukkan Nomor HP Anda</h6>
                        <p class="text-muted">Kami akan mengecek apakah nomor Anda sudah terdaftar di sistem</p>
                    </div>

                    <form id="step1Form">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor HP <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-lg" id="phone" name="phone" 
                                   placeholder="08xxxxxxxxx" required>
                            <small class="text-muted">Format: 08xxxxxxxxx (11-13 digit)</small>
                        </div>

                        <div id="phoneError" class="alert alert-danger d-none" role="alert"></div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="nextBtn">
                                <i class="fas fa-arrow-right"></i> Lanjut (Next)
                            </button>
                            <a href="<?= site_url('home') ?>" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-home"></i> Kembali ke Home
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('step1Form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const phone = document.getElementById('phone').value;
    const phoneError = document.getElementById('phoneError');
    const nextBtn = document.getElementById('nextBtn');
    
    // Validate
    if (!phone || phone.length < 10) {
        phoneError.textContent = 'Nomor HP tidak valid (minimal 10 digit)';
        phoneError.classList.remove('d-none');
        return;
    }
    
    phoneError.classList.add('d-none');
    nextBtn.disabled = true;
    nextBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengecek...';
    
    fetch('<?= site_url('booking/search_customer') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'phone=' + encodeURIComponent(phone)
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) {
            phoneError.textContent = data.message;
            phoneError.classList.remove('d-none');
            nextBtn.disabled = false;
            nextBtn.innerHTML = '<i class="fas fa-arrow-right"></i> Lanjut (Next)';
            return;
        }
        
        // Redirect to next step
        if (data.is_existing) {
            // Customer exists - go to step 3
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= site_url('booking/form_step3') ?>';
            form.innerHTML = '<input type="hidden" name="phone" value="' + phone + '">' +
                             '<input type="hidden" name="full_name" value="' + data.customer.full_name + '">';
            document.body.appendChild(form);
            form.submit();
        } else {
            // New customer - go to step 2
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= site_url('booking/form_step2') ?>';
            form.innerHTML = '<input type="hidden" name="phone" value="' + phone + '">';
            document.body.appendChild(form);
            form.submit();
        }
    })
    .catch(e => {
        console.error(e);
        phoneError.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
        phoneError.classList.remove('d-none');
        nextBtn.disabled = false;
        nextBtn.innerHTML = '<i class="fas fa-arrow-right"></i> Lanjut (Next)';
    });
});
</script>

<?php $this->load->view('layouts/footer'); ?>
