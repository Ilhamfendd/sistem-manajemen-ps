<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/notifications'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white p-4">
                    <h5 class="mb-0"><i class="fas fa-qrcode"></i> ID Pelanggan Berhasil Dibuat</h5>
                </div>
                <div class="card-body text-center p-5">
                    <h4 class="mb-2"><?= $customer->full_name ?></h4>
                    
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">ID Pelanggan</h6>
                        <h2 class="text-primary mb-4"><strong><?= $customer->customer_id ?></strong></h2>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-muted mb-3">QR Code</h6>
                        <div class="bg-light p-4 rounded d-inline-block">
                            <img id="qrCodeImage" src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?= urlencode($customer->customer_id) ?>" 
                                 alt="QR Code <?= $customer->customer_id ?>" class="img-fluid" style="max-width: 300px;">
                        </div>
                    </div>

                    <div class="alert alert-info mb-4" role="alert">
                        <i class="fas fa-camera"></i> <strong>Silakan foto QR code ini!</strong> Pelanggan dapat menyimpan foto untuk booking berikutnya.
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="<?= site_url('customers') ?>" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pelanggan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
