<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-users"></i> <?= $title ?></h5>
                </div>

                <div class="card-body">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> 
                            <?= validation_errors() ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= isset($item) ? site_url('customers/update/'.$item->id) : site_url('customers/store') ?>">

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                value="<?= isset($item) ? $item->full_name : set_value('full_name') ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" 
                                value="<?= isset($item) ? $item->phone : set_value('phone') ?>" required>
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
