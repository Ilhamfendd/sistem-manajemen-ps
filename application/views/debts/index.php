<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <?php $this->load->view('layouts/notifications'); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-list"></i> <?= $title ?></h2>
    </div>

    <!-- Total Outstanding Summary -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Hutang Pelanggan
                            </div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">
                                Rp <?= number_format($total_outstanding, 0, ',', '.') ?>
                            </div>
                        </div>
                        <div style="margin-left: auto;">
                            <i class="fas fa-exclamation-triangle text-danger" style="font-size: 2rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pelanggan Berhutang
                            </div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">
                                <?= count($customers_debt) ?>
                            </div>
                        </div>
                        <div style="margin-left: auto;">
                            <i class="fas fa-users text-warning" style="font-size: 2rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Debt List -->
    <?php if (empty($customers_debt)): ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Tidak ada pelanggan yang berhutang</p>
            </div>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Pelanggan</th>
                        <th>No. HP</th>
                        <th>Jumlah Hutang</th>
                        <th>Total Hutang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers_debt as $c): ?>
                    <tr>
                        <td>
                            <strong><?= $c['customer_name'] ?></strong>
                        </td>
                        <td><?= $c['customer_id'] ?></td>
                        <td>
                            <span class="badge bg-info"><?= count($c['rentals']) ?> transaksi</span>
                        </td>
                        <td>
                            <strong class="text-danger">Rp <?= number_format($c['total_outstanding'], 0, ',', '.') ?></strong>
                        </td>
                        <td>
                            <a href="<?= site_url('debts/customer_detail/'.$c['customer_id']) ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php $this->load->view('layouts/footer'); ?>
