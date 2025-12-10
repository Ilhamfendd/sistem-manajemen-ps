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
        <div class="col-md-7">
            <div style="text-align: center;">
                <h3 class="mb-4">Pilih Unit PS</h3>

                <?php if (empty($consoles)): ?>
                    <div class="notification notification-warning notification-flash" style="display: flex;">
                        <div class="notification-icon"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="notification-content">
                            <p class="notification-message">Semua unit sedang digunakan. Silakan coba lagi nanti.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <form id="step3Form" method="POST" action="<?= site_url('booking/form_step4') ?>">
                        <input type="hidden" name="phone" value="<?= $phone ?>">
                        <input type="hidden" name="full_name" value="<?= $full_name ?>">
                        
                        <div class="row">
                            <?php foreach ($consoles as $console): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card console-card" style="cursor: pointer; border: 3px solid #ddd; transition: all 0.3s ease;">
                                        <div class="card-body p-3">
                                            <div class="form-check">
                                                <input class="form-check-input console-radio" type="radio" 
                                                       name="console_id" value="<?= $console['id'] ?>" 
                                                       id="console_<?= $console['id'] ?>" required>
                                                <label class="form-check-label w-100" for="console_<?= $console['id'] ?>" style="cursor: pointer;">
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
                                <i class="fas fa-arrow-right"></i> Lanjut
                            </button>
                            <a href="<?= site_url('booking') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
