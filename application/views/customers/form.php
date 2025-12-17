<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <?php $this->load->view('layouts/notifications'); ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-users"></i> <?= $title ?></h5>
                </div>

                <div class="card-body">

                    <form method="post" action="<?= isset($item) ? site_url('customers/update/'.$item->id) : site_url('customers/store') ?>">

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                value="<?= isset($item) ? $item->full_name : set_value('full_name') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="customer_id" class="form-label">ID Pelanggan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="customer_id" name="customer_id" 
                                    value="<?= isset($item) ? $item->customer_id : set_value('customer_id') ?>" required readonly>
                                <button class="btn btn-outline-primary" type="button" id="generateIdBtn">
                                    <i class="fas fa-magic"></i> Generate
                                </button>
                            </div>
                            <small class="text-muted d-block mt-1">Format: YYNNNN (cth: 250001, 250002)</small>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Catatan</label>
                            <textarea class="form-control" id="note" name="note" rows="4"><?= isset($item) ? $item->note : set_value('note') ?></textarea>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="<?= site_url('customers') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
<script>
document.getElementById('generateIdBtn').addEventListener('click', function() {
    fetch('<?= site_url("customers/generate_customer_id") ?>')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('customer_id').value = data.customer_id;
                showNotification('ID berhasil di-generate: ' + data.customer_id, 'success');
            } else {
                showNotification(data.message || 'Gagal generate ID', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan', 'error');
        });
});
</script>