<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-file-invoice-dollar"></i> <?= $title ?></h2>
            <p class="text-muted mb-0">
                <i class="fas fa-phone"></i> <?= $customer->phone ?>
            </p>
        </div>
        <a href="<?= site_url('debts') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div data-flash-success="<?= htmlspecialchars($this->session->flashdata('success')) ?>" data-flash-title="Berhasil"></div>
    <?php endif; ?>

    <!-- Total Outstanding Card -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-left-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Hutang
                            </div>
                            <div class="h2 mb-0 font-weight-bold text-danger">
                                Rp <?= number_format($total_outstanding, 0, ',', '.') ?>
                            </div>
                        </div>
                        <div style="margin-left: auto;">
                            <i class="fas fa-money-bill-wave text-danger" style="font-size: 2.5rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Debt Details Table -->
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#Transaksi</th>
                    <th>Unit</th>
                    <th>Total Biaya</th>
                    <th>Sudah Dibayar</th>
                    <th>Sisa Hutang</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($debts as $d): ?>
                <tr>
                    <td>
                        <strong>#<?= $d->id ?></strong>
                    </td>
                    <td><?= $d->console_name ?></td>
                    <td class="text-end">
                        <strong>Rp <?= number_format($d->total_amount, 0, ',', '.') ?></strong>
                    </td>
                    <td class="text-end">
                        <span class="text-success">Rp <?= number_format($d->paid_amount, 0, ',', '.') ?></span>
                    </td>
                    <td class="text-end">
                        <span class="text-danger"><strong>Rp <?= number_format($d->outstanding, 0, ',', '.') ?></strong></span>
                    </td>
                    <td>
                        <?php 
                        if ($d->payment_status == 'partial') {
                            echo '<span class="badge bg-warning"><i class="fas fa-exclamation"></i> Sebagian</span>';
                        } else {
                            echo '<span class="badge bg-danger"><i class="fas fa-times"></i> Belum</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <a href="<?= site_url('rentals/collect_payment/'.$d->id) ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-money-bill"></i> Terima Pembayaran
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
