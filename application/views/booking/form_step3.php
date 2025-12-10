<?php $this->load->view('layouts/header_booking', ['title' => $title]); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="mb-0"><i class="fas fa-gamepad"></i> <?= $title ?></h5>
                    <small>Langkah 3 dari 4</small>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h6>Pilih Unit PS yang Tersedia</h6>
                        <p class="text-muted">Data: <?= $full_name ?> (<?= $phone ?>)</p>
                    </div>

                    <div class="progress mb-4">
                        <div class="progress-bar" style="width: 75%"></div>
                    </div>

                    <?php if (empty($consoles)): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Semua unit sedang digunakan. Silakan coba lagi nanti.
                        </div>
                    <?php else: ?>
                        <form id="step3Form" method="POST" action="<?= site_url('booking/form_step4') ?>">
                            <input type="hidden" name="phone" value="<?= $phone ?>">
                            <input type="hidden" name="full_name" value="<?= $full_name ?>">
                            
                            <div class="row">
                                <?php foreach ($consoles as $console): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card console-card" style="cursor: pointer; border: 3px solid transparent;">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input console-radio" type="radio" 
                                                           name="console_id" value="<?= $console['id'] ?>" 
                                                           id="console_<?= $console['id'] ?>" required>
                                                    <label class="form-check-label w-100" for="console_<?= $console['id'] ?>">
                                                        <h6 class="mb-2"><?= $console['console_name'] ?></h6>
                                                        <small class="text-muted"><?= $console['console_type'] ?></small>
                                                        <div class="mt-2">
                                                            <strong class="text-primary">Rp <?= number_format($console['price_per_hour'], 0, ',', '.') ?>/jam</strong>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div id="error" class="alert alert-danger d-none mt-3" role="alert"></div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-arrow-right"></i> Lanjut (Next)
                                </button>
                                <a href="<?= site_url('booking') ?>" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.console-card {
    transition: all 0.3s ease;
}
.console-card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
.console-radio:checked ~ label {
    font-weight: bold;
}
</style>

<script>
// Highlight selected console
document.querySelectorAll('.console-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.console-card').forEach(card => {
            card.style.borderColor = 'transparent';
        });
        this.closest('.col-md-6').querySelector('.console-card').style.borderColor = '#0d6efd';
    });
});

document.getElementById('step3Form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const selected = document.querySelector('input[name="console_id"]:checked');
    const errorDiv = document.getElementById('error');
    
    if (!selected) {
        errorDiv.textContent = 'Silakan pilih salah satu unit';
        errorDiv.classList.remove('d-none');
        return;
    }
    
    errorDiv.classList.add('d-none');
    this.submit();
});
</script>

<?php $this->load->view('layouts/footer'); ?>
