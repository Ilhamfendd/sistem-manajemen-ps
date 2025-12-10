<?php $this->load->view('layouts/header_booking', ['title' => $title]); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="mb-0"><i class="fas fa-user"></i> <?= $title ?></h5>
                    <small>Langkah 2 dari 4</small>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h6>Data Pelanggan Baru</h6>
                        <p class="text-muted">Nomor HP Anda belum terdaftar, silakan isi nama lengkap</p>
                    </div>

                    <form id="step2Form" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor HP</label>
                            <input type="tel" class="form-control" value="<?= $phone ?>" disabled>
                            <input type="hidden" name="phone" value="<?= $phone ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="full_name" name="full_name" 
                                   placeholder="Contoh: Budi Santoso" required>
                            <small class="text-muted">Masukkan nama lengkap Anda</small>
                        </div>

                        <div id="error" class="alert alert-danger d-none" role="alert"></div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-arrow-right"></i> Lanjut (Next)
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
document.getElementById('step2Form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const fullName = document.getElementById('full_name').value;
    const errorDiv = document.getElementById('error');
    
    if (!fullName || fullName.length < 3) {
        errorDiv.textContent = 'Nama minimal 3 karakter';
        errorDiv.classList.remove('d-none');
        return;
    }
    
    errorDiv.classList.add('d-none');
    this.submit();
});
</script>

<?php $this->load->view('layouts/footer'); ?>
