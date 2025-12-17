<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
</head>
<body style="background-color: #f8f9fa; padding: 40px 20px;">

<div class="container" style="margin-top: 0;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div style="text-align: center;">
                <h3 class="mb-4">Pesan Unit PS</h3>
                
                <!-- Tab: Pelanggan Lama vs Baru -->
                <ul class="nav nav-tabs mb-4" id="customerTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="existing-tab" data-bs-toggle="tab" data-bs-target="#existing" type="button">Pelanggan Lama</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="new-tab" data-bs-toggle="tab" data-bs-target="#new" type="button">Pelanggan Baru</button>
                    </li>
                </ul>

                <!-- EXISTING CUSTOMER -->
                <div class="tab-content" id="customerTabContent">
                    <div class="tab-pane fade show active" id="existing" role="tabpanel">
                        <div class="mb-4">
                            <input type="text" class="form-control form-control-lg" id="customerId" 
                                   placeholder="Masukkan ID Pelanggan (cth: 250001)" autocomplete="off">
                        </div>

                        <button id="searchBtn" class="btn btn-outline-primary btn-lg w-100">
                            <i class="fas fa-search"></i> Cek ID Anda
                        </button>

                        <div id="error" class="alert alert-danger d-none mt-3" role="alert"></div>

                        <div id="resultBox" class="d-none mt-4">
                            <div class="text-center">
                                <p class="text-muted mb-2">Selamat datang kembali,</p>
                                <h5 id="customerName" class="mb-4"></h5>
                                <button id="continueBtn" class="btn btn-primary btn-lg w-100">Lanjut Booking</button>
                            </div>
                        </div>
                    </div>

                    <!-- NEW CUSTOMER -->
                    <div class="tab-pane fade" id="new" role="tabpanel">
                        <div class="mb-3">
                            <label for="fullName" class="form-label text-start d-block">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg" id="fullName" 
                                   placeholder="Masukkan nama Anda" autocomplete="off">
                        </div>

                        <div class="mb-4">
                            <label for="newCustomerId" class="form-label text-start d-block">ID Pelanggan</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" id="newCustomerId" 
                                       placeholder="Klik Generate untuk auto-create" readonly>
                                <button class="btn btn-outline-primary" type="button" id="generateBtn">
                                    <i class="fas fa-magic"></i> Generate
                                </button>
                            </div>
                            <small class="text-muted d-block mt-1">Format: YYNNNN (cth: 250001)</small>
                        </div>

                        <div id="newError" class="alert alert-danger d-none mt-3" role="alert"></div>

                        <button id="continueNewBtn" class="btn btn-primary btn-lg w-100" disabled>
                            <i class="fas fa-arrow-right"></i> Lanjut Booking
                        </button>
                    </div>
                </div>

                <hr class="my-4">
                <a href="<?= site_url('home') ?>" class="text-muted text-decoration-none">← Kembali ke Home</a>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/notifications'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('public/js/notifications.js') ?>"></script>

<script>
// ===== EXISTING CUSTOMER =====
const customerId = document.getElementById('customerId');
const searchBtn = document.getElementById('searchBtn');
const errorDiv = document.getElementById('error');
const resultBox = document.getElementById('resultBox');
const customerName = document.getElementById('customerName');
const continueBtn = document.getElementById('continueBtn');

let lastSearchResult = null;

searchBtn.addEventListener('click', function() {
    const idValue = customerId.value.trim();
    
    if (!idValue || idValue.length !== 6) {
        errorDiv.textContent = 'ID Pelanggan harus 6 karakter (format: YYNNNN)';
        errorDiv.classList.remove('d-none');
        resultBox.classList.add('d-none');
        return;
    }
    
    errorDiv.classList.add('d-none');
    searchBtn.disabled = true;
    searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengecek...';
    
    fetch('<?= site_url('booking/search_customer') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'customer_id=' + encodeURIComponent(idValue)
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) {
            errorDiv.textContent = data.message || 'ID Pelanggan tidak ditemukan';
            errorDiv.classList.remove('d-none');
            resultBox.classList.add('d-none');
            searchBtn.disabled = false;
            searchBtn.innerHTML = '<i class="fas fa-search"></i> Cek ID Anda';
            return;
        }
        
        lastSearchResult = {
            type: 'existing',
            customer: data.customer
        };
        
        customerName.textContent = data.customer.full_name;
        resultBox.classList.remove('d-none');
        searchBtn.disabled = false;
        searchBtn.innerHTML = '<i class="fas fa-search"></i> Cek ID Anda';
    })
    .catch(err => {
        console.error(err);
        errorDiv.textContent = 'Terjadi kesalahan. Coba lagi.';
        errorDiv.classList.remove('d-none');
        searchBtn.disabled = false;
        searchBtn.innerHTML = '<i class="fas fa-search"></i> Cek ID Anda';
    });
});

continueBtn.addEventListener('click', function() {
    if (!lastSearchResult) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= site_url('booking/form_step2') ?>';
    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'customer_id';
    input.value = lastSearchResult.customer.customer_id;
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
});

// ===== NEW CUSTOMER =====
const fullName = document.getElementById('fullName');
const newCustomerId = document.getElementById('newCustomerId');
const generateBtn = document.getElementById('generateBtn');
const newError = document.getElementById('newError');
const continueNewBtn = document.getElementById('continueNewBtn');

generateBtn.addEventListener('click', function() {
    if (!fullName.value.trim()) {
        newError.textContent = 'Silakan masukkan nama terlebih dahulu';
        newError.classList.remove('d-none');
        return;
    }
    
    newError.classList.add('d-none');
    generateBtn.disabled = true;
    generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    
    fetch('<?= site_url('booking/generate_customer_id') ?>')
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                newCustomerId.value = data.customer_id;
                continueNewBtn.disabled = false;
                showNotification('ID berhasil di-generate: ' + data.customer_id, 'success');
            } else {
                newError.textContent = data.message || 'Gagal generate ID';
                newError.classList.remove('d-none');
            }
            generateBtn.disabled = false;
            generateBtn.innerHTML = '<i class="fas fa-magic"></i> Generate';
        })
        .catch(err => {
            console.error(err);
            newError.textContent = 'Terjadi kesalahan';
            newError.classList.remove('d-none');
            generateBtn.disabled = false;
            generateBtn.innerHTML = '<i class="fas fa-magic"></i> Generate';
        });
});

continueNewBtn.addEventListener('click', function() {
    if (!fullName.value.trim() || !newCustomerId.value.trim()) {
        newError.textContent = 'Semua data harus diisi';
        newError.classList.remove('d-none');
        return;
    }
    
    // Save new customer and continue to step 2 (pilih unit)
    continueNewBtn.disabled = true;
    continueNewBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    
    fetch('<?= site_url('booking/create_new_customer') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'full_name=' + encodeURIComponent(fullName.value.trim()) + 
              '&customer_id=' + encodeURIComponent(newCustomerId.value.trim())
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Go to step 2 directly
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= site_url('booking/form_step2') ?>';
            
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'customer_id';
            idInput.value = newCustomerId.value.trim();
            form.appendChild(idInput);
            
            document.body.appendChild(form);
            form.submit();
        } else {
            newError.textContent = data.message || 'Gagal membuat pelanggan';
            newError.classList.remove('d-none');
            continueNewBtn.disabled = false;
            continueNewBtn.innerHTML = '<i class="fas fa-arrow-right"></i> Lanjut Booking';
        }
    })
    .catch(err => {
        console.error(err);
        newError.textContent = 'Terjadi kesalahan';
        newError.classList.remove('d-none');
        continueNewBtn.disabled = false;
        continueNewBtn.innerHTML = '<i class="fas fa-arrow-right"></i> Lanjut Booking';
    });
});

customerId.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') searchBtn.click();
});
</script>

</body>
</html>

