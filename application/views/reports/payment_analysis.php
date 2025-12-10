<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="mb-4">
        <h2><i class="fas fa-credit-card"></i> <?= $title ?></h2>
        <p class="text-muted">Analisis status pembayaran, metode, dan piutang</p>
    </div>

    <!-- PAYMENT STATUS BREAKDOWN -->
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <small class="text-muted">Lunas (Paid)</small>
                    <h4 class="text-success mt-2 mb-1">Rp <?= number_format($payment_status['paid']['total'] ?? 0) ?></h4>
                    <small class="text-muted"><?= ($payment_status['paid']['count'] ?? 0) ?> rental</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <small class="text-muted">Sebagian (Partial)</small>
                    <h4 class="text-warning mt-2 mb-1">Rp <?= number_format($payment_status['partial']['total'] ?? 0) ?></h4>
                    <small class="text-muted"><?= ($payment_status['partial']['count'] ?? 0) ?> rental</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <small class="text-muted">Belum Dibayar (Pending)</small>
                    <h4 class="text-danger mt-2 mb-1">Rp <?= number_format($payment_status['pending']['total'] ?? 0) ?></h4>
                    <small class="text-muted"><?= ($payment_status['pending']['count'] ?? 0) ?> rental</small>
                </div>
            </div>
        </div>
    </div>

    <!-- PAYMENT METHOD BREAKDOWN -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white p-3">
            <h6 class="mb-0"><i class="fas fa-money-bill"></i> Pendapatan Per Metode Pembayaran</h6>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Metode Pembayaran</th>
                            <th class="text-end">Jumlah Transaksi</th>
                            <th class="text-end">Total Pendapatan</th>
                            <th class="text-end">Rata-rata</th>
                            <th class="text-end">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($payment_methods)): ?>
                            <?php 
                            $total_all = array_sum(array_column($payment_methods, 'total_amount'));
                            foreach ($payment_methods as $method):
                                $percentage = $total_all > 0 ? ($method['total_amount'] / $total_all) * 100 : 0;
                            ?>
                                <tr>
                                    <td><strong><?= $method['method_name'] ?></strong></td>
                                    <td class="text-end"><?= $method['transaction_count'] ?></td>
                                    <td class="text-end">Rp <?= number_format($method['total_amount']) ?></td>
                                    <td class="text-end">Rp <?= number_format(round($method['total_amount'] / max($method['transaction_count'], 1))) ?></td>
                                    <td class="text-end"><?= round($percentage) ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- OUTSTANDING PAYMENTS -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-danger text-white p-3">
            <h6 class="mb-0"><i class="fas fa-exclamation-circle"></i> Piutang Tagihan (Outstanding Payments)</h6>
        </div>
        <div class="card-body p-3">
            <?php if (!empty($outstanding_payments) && array_sum(array_column($outstanding_payments, 'total_amount')) > 0): ?>
                <div class="alert alert-warning" role="alert">
                    <strong>Total Piutang: Rp <?= number_format(array_sum(array_column($outstanding_payments, 'total_amount'))) ?></strong>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Pelanggan</th>
                                <th>No. Kontak</th>
                                <th class="text-end">Jumlah Rental</th>
                                <th class="text-end">Total Piutang</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($outstanding_payments as $payment): ?>
                                <tr>
                                    <td>
                                        <strong><?= $payment['customer_name'] ?></strong>
                                    </td>
                                    <td>
                                        <small><?= $payment['customer_phone'] ?? '-' ?></small>
                                    </td>
                                    <td class="text-end"><?= $payment['rental_count'] ?></td>
                                    <td class="text-end">
                                        <strong class="text-danger">Rp <?= number_format($payment['sisa_piutang']) ?></strong>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($payment['status'] === 'pending'): ?>
                                            <span class="badge bg-danger">Belum Dibayar</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Sebagian</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle"></i> Tidak ada piutang tagihan - Semua pembayaran lunas!
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- PAYMENT STATUS SUMMARY -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white p-3">
                    <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Ringkasan Status Pembayaran</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6>Distribusi Status Pembayaran</h6>
                                <div class="list-group">
                                    <div class="list-group-item d-flex justify-content-between">
                                        <span>
                                            <i class="fas fa-check-circle text-success"></i> Lunas (Paid)
                                        </span>
                                        <strong><?= ($payment_status['paid']['count'] ?? 0) ?> rental</strong>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <span>
                                            <i class="fas fa-exclamation-circle text-warning"></i> Sebagian (Partial)
                                        </span>
                                        <strong><?= ($payment_status['partial']['count'] ?? 0) ?> rental</strong>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <span>
                                            <i class="fas fa-times-circle text-danger"></i> Belum (Pending)
                                        </span>
                                        <strong><?= ($payment_status['pending']['count'] ?? 0) ?> rental</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6>Distribusi Nilai Pembayaran</h6>
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-check-circle text-success"></i> Lunas</span>
                                            <strong>Rp <?= number_format($payment_status['paid']['total'] ?? 0) ?></strong>
                                        </div>
                                        <div class="progress mt-2" style="height: 8px;">
                                            <div class="progress-bar bg-success" style="width: <?= ($payment_status['paid']['total'] ?? 0) > 0 ? (($payment_status['paid']['total'] / (($payment_status['paid']['total'] ?? 0) + ($payment_status['partial']['total'] ?? 0) + ($payment_status['pending']['total'] ?? 0))) * 100) : 0 ?>%"></div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-exclamation-circle text-warning"></i> Sebagian</span>
                                            <strong>Rp <?= number_format($payment_status['partial']['total'] ?? 0) ?></strong>
                                        </div>
                                        <div class="progress mt-2" style="height: 8px;">
                                            <div class="progress-bar bg-warning" style="width: <?= ($payment_status['partial']['total'] ?? 0) > 0 ? (($payment_status['partial']['total'] / (($payment_status['paid']['total'] ?? 0) + ($payment_status['partial']['total'] ?? 0) + ($payment_status['pending']['total'] ?? 0))) * 100) : 0 ?>%"></div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-times-circle text-danger"></i> Belum</span>
                                            <strong>Rp <?= number_format($payment_status['pending']['total'] ?? 0) ?></strong>
                                        </div>
                                        <div class="progress mt-2" style="height: 8px;">
                                            <div class="progress-bar bg-danger" style="width: <?= ($payment_status['pending']['total'] ?? 0) > 0 ? (($payment_status['pending']['total'] / (($payment_status['paid']['total'] ?? 0) + ($payment_status['partial']['total'] ?? 0) + ($payment_status['pending']['total'] ?? 0))) * 100) : 0 ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BACK LINK -->
    <div class="mb-3 mt-5">
        <a href="<?= site_url('reports') ?>" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
