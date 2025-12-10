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
        <div class="col-md-5">
            <div style="text-align: center;">
                <h3 class="mb-4">Masukkan Nama Anda</h3>
                
                <form id="step2Form" method="POST" action="<?= site_url('booking/form_step3') ?>">
                    <input type="hidden" name="phone" value="<?= $phone ?>">
                    
                    <div class="mb-4">
                        <input type="text" class="form-control form-control-lg" id="full_name" name="full_name" 
                               placeholder="Nama lengkap" required autocomplete="off">
                    </div>

                    <div id="error" class="alert alert-danger d-none" role="alert"></div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-arrow-right"></i> Lanjut
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
