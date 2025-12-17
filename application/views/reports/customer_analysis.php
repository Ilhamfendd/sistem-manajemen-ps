<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="mb-4">
        <h2><i class="fas fa-users"></i> <?= $title ?></h2>
        <p class="text-muted">Analisis pelanggan terbaik berdasarkan pengeluaran dan frekuensi rental</p>
    </div>

    <!-- DATE FILTER -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small">Dari Tanggal</label>
                    <input type="date" class="form-control form-control-sm" name="start_date" value="<?= $start_date ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Sampai Tanggal</label>
                    <input type="date" class="form-control form-control-sm" name="end_date" value="<?= $end_date ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="<?= site_url('reports/export_customer_csv?start_date=' . $start_date . '&end_date=' . $end_date) ?>" class="btn btn-success btn-sm w-100">
                        <i class="fas fa-download"></i> Export CSV
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- CUSTOMER SUMMARY STATS -->
    <div class="row mb-4 g-3">
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <small class="text-muted">Total Pelanggan</small>
                    <h4 class="text-primary mt-2 mb-1"><?= count($top_customers ?? []) ?></h4>
                    <small class="text-muted">Periode dipilih</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <small class="text-muted">Total Rental</small>
                    <h4 class="text-info mt-2 mb-1"><?= array_sum(array_column($top_customers ?? [], 'rental_count')) ?></h4>
                    <small class="text-muted">Semua pelanggan</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <small class="text-muted">Total Pendapatan</small>
                    <h4 class="text-success mt-2 mb-1">Rp <?= number_format(array_sum(array_column($top_customers ?? [], 'total_spending'))) ?></h4>
                    <small class="text-muted">Dari pelanggan</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <small class="text-muted">Rata-rata Per Pelanggan</small>
                    <h4 class="text-warning mt-2 mb-1">Rp <?= number_format(count($top_customers ?? []) > 0 ? round(array_sum(array_column($top_customers ?? [], 'total_spending')) / count($top_customers ?? [])) : 0) ?></h4>
                    <small class="text-muted">Pengeluaran</small>
                </div>
            </div>
        </div>
    </div>

    <!-- TOP CUSTOMERS LEADERBOARD -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white p-3">
            <h6 class="mb-0"><i class="fas fa-crown"></i> Top 20 Pelanggan Terbaik</h6>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">Ranking</th>
                            <th>Nama Pelanggan</th>
                            <th class="text-center">No. Kontak</th>
                            <th class="text-end">Jumlah Rental</th>
                            <th class="text-end">Total Durasi</th>
                            <th class="text-end">Total Pengeluaran</th>
                            <th class="text-end">Rata-rata/Rental</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($top_customers)): ?>
                            <?php $rank = 1; ?>
                            <?php foreach ($top_customers as $customer): ?>
                                <tr>
                                    <td>
                                        <?php if ($rank <= 3): ?>
                                            <span class="badge bg-warning text-dark">#<?= $rank ?></span>
                                        <?php else: ?>
                                            <strong><?= $rank ?></strong>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= $customer['customer_name'] ?></strong>
                                        <div class="progress mt-1" style="height: 6px; width: 250px;">
                                            <div class="progress-bar bg-success" style="width: <?= ($customer['total_spending'] / (max(array_column($top_customers, 'total_spending')) ?: 1)) * 100 ?>%"></div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <small class="text-muted">ID: <?= $customer['customer_id'] ?? '-' ?></small>
                                    </td>
                                    <td class="text-end"><?= $customer['rental_count'] ?></td>
                                    <td class="text-end"><?= number_format($customer['total_minutes']) ?> mnt</td>
                                    <td class="text-end">
                                        <strong class="text-success">Rp <?= number_format($customer['total_spending']) ?></strong>
                                    </td>
                                    <td class="text-end">
                                        Rp <?= number_format(round($customer['total_spending'] / max($customer['rental_count'], 1))) ?>
                                    </td>
                                </tr>
                                <?php $rank++; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">Tidak ada data pelanggan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- CUSTOMER INSIGHTS -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-star"></i> VIP Customers (Spending > Rp 500.000)</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php 
                        $vip_customers = array_filter($top_customers ?? [], function($c) {
                            return $c['total_spending'] >= 500000;
                        });
                        if (!empty($vip_customers)): 
                            foreach ($vip_customers as $vip):
                        ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">
                                            <i class="fas fa-crown text-warning"></i> <?= $vip['customer_name'] ?>
                                        </h6>
                                        <small class="text-muted"><?= $vip['rental_count'] ?> rental</small>
                                    </div>
                                    <strong class="text-success">Rp <?= number_format($vip['total_spending']) ?></strong>
                                </div>
                            </div>
                        <?php 
                            endforeach;
                        else:
                        ?>
                            <div class="text-center text-muted py-3">Tidak ada VIP customer</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-chart-line"></i> Pelanggan Aktif (10+ Rental)</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php 
                        $active_customers = array_filter($top_customers ?? [], function($c) {
                            return $c['rental_count'] >= 10;
                        });
                        if (!empty($active_customers)): 
                            foreach (array_slice($active_customers, 0, 5) as $active):
                        ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">
                                            <i class="fas fa-fire text-danger"></i> <?= $active['customer_name'] ?>
                                        </h6>
                                        <small class="text-muted"><?= $active['total_minutes'] ?> mnt durasi</small>
                                    </div>
                                    <strong class="text-primary"><?= $active['rental_count'] ?>x</strong>
                                </div>
                            </div>
                        <?php 
                            endforeach;
                        else:
                        ?>
                            <div class="text-center text-muted py-3">Tidak ada pelanggan aktif</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BACK LINK -->
    <div class="mt-5 mb-3">
        <a href="<?= site_url('reports') ?>" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
