<?php $this->load->view('layouts/header'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Terima Pembayaran - Penyewaan #<?php echo $rental['id']; ?></h4>
                </div>
                <div class="card-body">
                    
                    <!-- Rental Details -->
                    <div class="mb-4">
                        <div class="row mb-3">
                            <div class="col-6">
                                <h6 class="text-muted">Pelanggan</h6>
                                <p class="h5"><?php echo $rental['customer_name']; ?></p>
                            </div>
                            <div class="col-6">
                                <h6 class="text-muted">Unit</h6>
                                <p class="h5"><?php echo $rental['console_name']; ?></p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Outstanding Summary -->
                    <div class="mb-4 p-3 bg-light rounded border-start border-4 border-danger">
                        <div class="row mb-2">
                            <div class="col-6">
                                <small class="text-muted">Total Biaya</small>
                                <p class="mb-0"><strong>Rp <?php echo number_format($rental['total_amount'], 0, ',', '.'); ?></strong></p>
                            </div>
                            <div class="col-6 text-end">
                                <small class="text-muted">Sudah Dibayar</small>
                                <p class="mb-0"><strong class="text-success">Rp <?php echo number_format($rental['paid_amount'], 0, ',', '.'); ?></strong></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <small class="text-muted">Sisa Piutang</small>
                                <p class="h4 text-danger">Rp <?php echo number_format($rental['outstanding'], 0, ',', '.'); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <form method="POST" action="<?php echo base_url('rentals/process_collect_payment/' . $rental['id']); ?>">
                        <div class="form-group mb-3">
                            <label for="payment_method" class="form-label">Metode Pembayaran</label>
                            <select id="payment_method" name="payment_method" class="form-select" required>
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                <?php if (!empty($payment_methods)): ?>
                                    <?php foreach ($payment_methods as $method): ?>
                                        <option value="<?php echo $method['id']; ?>">
                                            <?php echo $method['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="amount" class="form-label">Jumlah Pembayaran (Rp)</label>
                            <input 
                                type="number" 
                                id="amount" 
                                name="amount" 
                                class="form-control form-control-lg" 
                                value="<?php echo $rental['outstanding']; ?>"
                                min="0"
                                required
                            >
                            <small class="text-muted">Maksimal: Rp <?php echo number_format($rental['outstanding'], 0, ',', '.'); ?></small>
                        </div>

                        <div class="form-group mb-4">
                            <label for="notes" class="form-label">Catatan (Opsional)</label>
                            <textarea 
                                id="notes" 
                                name="notes" 
                                class="form-control" 
                                rows="2"
                                placeholder="Catatan pembayaran..."
                            ></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?php echo base_url('rentals'); ?>" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check-circle"></i> Terima Pembayaran
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
