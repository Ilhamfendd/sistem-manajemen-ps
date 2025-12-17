<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <?php $this->load->view('layouts/notifications'); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-credit-card"></i> <?= $title ?></h5>
                </div>
                <div class="card-body">

                    <form method="post" action="<?= site_url('rentals/process_payment/'.$rental['id']) ?>">
                        
                        <div class="mb-3">
                            <label class="form-label text-muted"><small>Jumlah Pembayaran (Rp)</small></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control form-control-lg" name="amount" 
                                    value="<?= set_value('amount', $outstanding) ?>" 
                                    min="1" required autofocus>
                            </div>
                            <small class="form-text text-muted mt-1">
                                Sisa pembayaran: <strong>Rp <?= number_format($outstanding) ?></strong>
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-select" id="payment_method" name="payment_method_id" required>
                                <option value="">-- Pilih Metode --</option>
                                <?php foreach ($payment_methods as $method): ?>
                                    <option value="<?= $method->id ?>">
                                        <i class="fas fa-money-bill"></i> <?= $method->method_name ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-success" type="submit">
                                <i class="fas fa-save"></i> Catat Pembayaran
                            </button>
                            <a href="<?= site_url('rentals') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <!-- RENTAL DETAIL -->
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-receipt"></i> Detail Penyewaan #<?= $rental['id'] ?></h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Pelanggan</small>
                        <p class="mb-0"><strong><?= $rental['full_name'] ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">ID Pelanggan</small>
                        <p class="mb-0"><strong><?= $rental['customer_id'] ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Unit PlayStation</small>
                        <p class="mb-0">
                            <span class="badge bg-info"><?= $rental['console_name'] ?></span>
                            <strong><?= $rental['console_type'] ?></strong>
                        </p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted">Waktu Mulai</small>
                        <p class="mb-0"><strong><?= date('d/m/Y H:i:s', strtotime($rental['start_time'])) ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Waktu Selesai</small>
                        <p class="mb-0"><strong><?= date('d/m/Y H:i:s', strtotime($rental['end_time'])) ?></strong></p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Durasi</small>
                        <p class="mb-0">
                            <strong>
                                <?php 
                                $hours = floor($rental['duration_minutes'] / 60);
                                $mins = $rental['duration_minutes'] % 60;
                                echo $hours . ' jam ' . $mins . ' menit';
                                ?>
                            </strong>
                        </p>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <small class="text-muted">Harga/Jam</small>
                        <p class="mb-0"><strong>Rp <?= number_format($rental['price_per_hour']) ?></strong></p>
                    </div>
                    <div class="mb-3 pb-3" style="border-bottom: 2px solid #e9ecef;">
                        <small class="text-muted">Total Biaya</small>
                        <p class="mb-0"><strong class="text-success" style="font-size: 1.2rem;">Rp <?= number_format($rental['total_amount']) ?></strong></p>
                    </div>
                </div>
            </div>

            <!-- PAYMENT HISTORY -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-history"></i> Riwayat Pembayaran</h6>
                </div>
                <div class="card-body">
                    <?php if (isset($rental['transactions']) && !empty($rental['transactions'])): ?>
                        <div style="max-height: 300px; overflow-y: auto;">
                            <?php foreach ($rental['transactions'] as $t): ?>
                            <div class="mb-3 pb-3" style="border-bottom: 1px solid #e9ecef;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong class="text-success">Rp <?= number_format($t['amount']) ?></strong>
                                        <br>
                                        <small class="text-muted"><?= $t['method_name'] ?? 'Unknown' ?></small>
                                    </div>
                                    <small class="text-muted text-end">
                                        <?= date('d/m/Y H:i', strtotime($t['paid_at'])) ?>
                                    </small>
                                </div>
                                <?php if ($t['change_amount'] > 0): ?>
                                <small class="text-warning">
                                    <i class="fas fa-coins"></i> Kembalian: Rp <?= number_format($t['change_amount']) ?>
                                </small>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <small class="text-muted">Total Pembayaran</small>
                            <strong>Rp <?= number_format($paid_amount) ?></strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Sisa</small>
                            <strong class="<?= $outstanding > 0 ? 'text-danger' : 'text-success' ?>">
                                Rp <?= number_format($outstanding) ?>
                            </strong>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-3">
                            <i class="fas fa-inbox"></i><br>
                            Belum ada pembayaran
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
