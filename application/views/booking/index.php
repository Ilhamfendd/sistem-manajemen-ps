<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="d-flex align-items-center mb-4">
        <h2><i class="fas fa-calendar-alt"></i> <?= $title ?></h2>
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

    <div class="row">
        <?php if (!empty($consoles)): ?>
            <?php foreach ($consoles as $console): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm" style="cursor: pointer; transition: transform 0.2s;" 
                     onmouseover="this.style.transform='translateY(-5px)'" 
                     onmouseout="this.style.transform='translateY(0)'"
                     onclick="startBooking(<?= $console['id'] ?>)">
                    <div class="card-header bg-primary text-white p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><?= $console['console_name'] ?></h5>
                            <span class="badge bg-light text-dark"><?= $console['console_type'] ?></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Jenis Console</small>
                            <p class="mb-2"><i class="fas fa-gamepad"></i> <strong><?= $console['console_type'] ?></strong></p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Harga Per Jam</small>
                            <p class="mb-0"><strong class="text-success" style="font-size: 1.3rem;">Rp <?= number_format($console['price_per_hour']) ?></strong></p>
                        </div>
                    </div>
                    <div class="card-footer bg-light p-3">
                        <button type="button" class="btn btn-primary w-100" onclick="startBooking(<?= $console['id'] ?>)">
                            <i class="fas fa-plus"></i> Pesan Sekarang
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Tidak ada unit yang tersedia saat ini
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Input Nomor HP -->
<div class="modal fade" id="phoneModal" tabindex="-1" backdrop="static" keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-phone"></i> Masukkan Nomor HP</h5>
            </div>
            <div class="modal-body">
                <form id="phoneForm">
                    <div class="mb-3">
                        <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="08xxxxxxxxx" required>
                        <small class="text-muted">Gunakan format: 08xxxxxxxxx</small>
                    </div>
                    <div id="phoneError" class="alert alert-danger d-none"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="checkCustomer()">Lanjut</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Input Nama (untuk pelanggan baru) -->
<div class="modal fade" id="nameModal" tabindex="-1" backdrop="static" keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-user"></i> Pelanggan Baru - Masukkan Nama</h5>
            </div>
            <div class="modal-body">
                <form id="nameForm">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Masukkan nama lengkap" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="goToBookingForm()">Lanjut</button>
            </div>
        </div>
    </div>
</div>

<script>
let selectedConsoleId = null;
let customerPhone = null;
let customerName = null;
let isExistingCustomer = false;

function startBooking(consoleId) {
    selectedConsoleId = consoleId;
    const phoneModal = new bootstrap.Modal(document.getElementById('phoneModal'));
    phoneModal.show();
}

function checkCustomer() {
    const phone = document.getElementById('phone').value;
    
    if (!phone || phone.length < 10) {
        document.getElementById('phoneError').textContent = 'Nomor HP tidak valid (minimal 10 digit)';
        document.getElementById('phoneError').classList.remove('d-none');
        return;
    }

    // Show loading
    const phoneModal = bootstrap.Modal.getInstance(document.getElementById('phoneModal'));
    
    // AJAX check customer
    fetch('<?= site_url('booking/search_customer') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'phone=' + encodeURIComponent(phone)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            customerPhone = phone;
            phoneModal.hide();
            
            if (data.is_existing) {
                // Pelanggan lama - langsung ke booking form
                isExistingCustomer = true;
                customerName = data.customer.full_name;
                goToBookingForm();
            } else {
                // Pelanggan baru - minta nama
                isExistingCustomer = false;
                const nameModal = new bootstrap.Modal(document.getElementById('nameModal'));
                nameModal.show();
            }
        } else {
            document.getElementById('phoneError').textContent = 'Error: ' + data.message;
            document.getElementById('phoneError').classList.remove('d-none');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('phoneError').textContent = 'Terjadi kesalahan. Silakan coba lagi.';
        document.getElementById('phoneError').classList.remove('d-none');
    });
}

function goToBookingForm() {
    const fullName = document.getElementById('full_name').value || customerName;
    
    if (!fullName) {
        alert('Nama harus diisi');
        return;
    }

    // Close modal
    const nameModal = bootstrap.Modal.getInstance(document.getElementById('nameModal'));
    if (nameModal) nameModal.hide();

    // Submit form ke booking form page
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= site_url('booking/booking_form') ?>';
    
    form.innerHTML = '<input type="hidden" name="phone" value="' + customerPhone + '">' +
                     '<input type="hidden" name="full_name" value="' + fullName + '">' +
                     '<input type="hidden" name="console_id" value="' + selectedConsoleId + '">';
    
    document.body.appendChild(form);
    form.submit();
}

// Clear form on modal close
document.getElementById('phoneModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('phoneForm').reset();
    document.getElementById('phoneError').classList.add('d-none');
});

document.getElementById('nameModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('nameForm').reset();
});
</script>

<?php $this->load->view('layouts/footer'); ?>
