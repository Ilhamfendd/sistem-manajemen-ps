<?php $this->load->view('layouts/header_booking', ['title' => $title]); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div style="text-align: center;">
                <h3 class="mb-4">Cari Nomor HP Anda</h3>
                
                <div class="mb-4">
                    <input type="tel" class="form-control form-control-lg" id="phone" 
                           placeholder="08xxxxxxxxx" autocomplete="off">
                </div>

                <button id="searchBtn" class="btn btn-outline-primary btn-lg" style="width: 60px; height: 60px; border-radius: 50%;">
                    <i class="fas fa-search fa-lg"></i>
                </button>

                <div id="error" class="alert alert-danger d-none mt-3" role="alert"></div>

                <div id="resultBox" class="d-none mt-4">
                    <div class="text-center">
                        <p class="text-muted mb-2">Selamat datang kembali,</p>
                        <h5 id="customerName" class="mb-4"></h5>
                        <button id="continueBtn" class="btn btn-primary btn-lg w-100">Lanjut Booking</button>
                    </div>
                </div>

                <hr class="my-4">
                <a href="<?= site_url('home') ?>" class="text-muted text-decoration-none">← Kembali ke Home</a>
            </div>
        </div>
    </div>
</div>

<style>
#searchBtn {
    border-width: 2px;
    transition: all 0.3s ease;
}

#searchBtn:hover {
    background-color: #0d6efd;
    color: white;
}

#searchBtn:disabled {
    opacity: 0.6;
}
</style>

<script>
const phone = document.getElementById('phone');
const searchBtn = document.getElementById('searchBtn');
const errorDiv = document.getElementById('error');
const resultBox = document.getElementById('resultBox');
const customerName = document.getElementById('customerName');
const continueBtn = document.getElementById('continueBtn');

let lastSearchResult = null;

searchBtn.addEventListener('click', function() {
    const phoneValue = phone.value.trim();
    
    if (!phoneValue || phoneValue.length < 10) {
        errorDiv.textContent = 'Nomor HP tidak valid (minimal 10 digit)';
        errorDiv.classList.remove('d-none');
        resultBox.classList.add('d-none');
        return;
    }
    
    errorDiv.classList.add('d-none');
    searchBtn.disabled = true;
    searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    
    fetch('<?= site_url('booking/search_customer') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'phone=' + encodeURIComponent(phoneValue)
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) {
            errorDiv.textContent = data.message;
            errorDiv.classList.remove('d-none');
            resultBox.classList.add('d-none');
            searchBtn.disabled = false;
            searchBtn.innerHTML = '<i class="fas fa-search fa-lg"></i>';
            return;
        }
        
        lastSearchResult = {
            phone: phoneValue,
            is_existing: data.is_existing,
            customer: data.customer || null
        };
        
        if (data.is_existing) {
            // Show existing customer welcome
            customerName.textContent = data.customer.full_name;
            resultBox.classList.remove('d-none');
        } else {
            // New customer - go directly to step 2
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= site_url('booking/form_step2') ?>';
            form.innerHTML = '<input type="hidden" name="phone" value="' + phoneValue + '">';
            document.body.appendChild(form);
            form.submit();
        }
        
        searchBtn.disabled = false;
        searchBtn.innerHTML = '<i class="fas fa-search fa-lg"></i>';
    })
    .catch(e => {
        console.error(e);
        errorDiv.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
        errorDiv.classList.remove('d-none');
        resultBox.classList.add('d-none');
        searchBtn.disabled = false;
        searchBtn.innerHTML = '<i class="fas fa-search fa-lg"></i>';
    });
});

continueBtn.addEventListener('click', function() {
    if (!lastSearchResult || !lastSearchResult.is_existing) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= site_url('booking/form_step3') ?>';
    form.innerHTML = '<input type="hidden" name="phone" value="' + lastSearchResult.phone + '">' +
                     '<input type="hidden" name="full_name" value="' + lastSearchResult.customer.full_name + '">';
    document.body.appendChild(form);
    form.submit();
});

// Enter key to search
phone.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchBtn.click();
    }
});
</script>

<?php $this->load->view('layouts/footer'); ?>
