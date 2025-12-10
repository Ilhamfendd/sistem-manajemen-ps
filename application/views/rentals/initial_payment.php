<?php $this->load->view('layouts/header'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Pembayaran Awal Penyewaan</h4>
                </div>
                <div class="card-body">


                    <!-- Rental Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Pelanggan</h6>
                            <p class="h5"><?php echo isset($rental['customer_name']) ? $rental['customer_name'] : 'N/A'; ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Konsol</h6>
                            <p class="h5"><?php echo isset($rental['console_name']) ? $rental['console_name'] : 'N/A'; ?></p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Durasi Estimasi</h6>
                            <p class="h5"><?php echo isset($rental['estimated_hours']) ? $rental['estimated_hours'] . ' jam' : 'N/A'; ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Biaya Estimasi</h6>
                            <p class="h5 text-success">Rp <?php echo isset($rental['estimated_cost']) ? number_format($rental['estimated_cost'], 0, ',', '.') : '0'; ?></p>
                        </div>
                    </div>

                    <hr>

                    <!-- Payment Form -->
                    <form method="POST" action="<?php echo base_url('rentals/process_initial_payment/' . $rental['id']); ?>">
                        <div class="form-group mb-3">
                            <label for="payment_method" class="form-label">Metode Pembayaran</label>
                            <select id="payment_method" name="payment_method" class="form-select form-select-lg" required>
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
                                value="<?php echo isset($rental['estimated_cost']) ? $rental['estimated_cost'] : 0; ?>"
                                min="0"
                                required
                            >
                        </div>

                        <div class="form-group mb-3">
                            <label for="notes" class="form-label">Catatan (Opsional)</label>
                            <textarea 
                                id="notes" 
                                name="notes" 
                                class="form-control" 
                                rows="3"
                                placeholder="Catatan pembayaran..."
                            ></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?php echo base_url('kasir/rentals'); ?>" class="btn btn-secondary btn-lg">Batal</a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle"></i> Proses Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
