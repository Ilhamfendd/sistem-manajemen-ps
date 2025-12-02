<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="mb-4">
        <h2><i class="fas fa-money-bill-wave"></i> <?= $title ?></h2>
        <p class="text-muted">Analisis pendapatan berdasarkan tanggal, tipe konsol, dan metode pembayaran</p>
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
                    <a href="<?= site_url('reports/export_revenue_csv?start_date=' . $start_date . '&end_date=' . $end_date) ?>" class="btn btn-success btn-sm w-100">
                        <i class="fas fa-download"></i> Export CSV
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- PERIOD SUMMARY -->
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <small class="text-muted d-block">Total Pendapatan</small>
                    <h4 class="text-success mt-2 mb-1">Rp <?= number_format($period_total['total_revenue'] ?? 0) ?></h4>
                    <small class="text-muted"><?= ($period_total['total_rentals'] ?? 0) ?> rental</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <small class="text-muted d-block">Rata-rata Per Rental</small>
                    <h4 class="text-info mt-2 mb-1">Rp <?= number_format($period_total['total_rentals'] > 0 ? round($period_total['total_revenue'] / $period_total['total_rentals']) : 0) ?></h4>
                    <small class="text-muted">Periode dipilih</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-3">
                    <small class="text-muted d-block">Total Menit Rental</small>
                    <h4 class="text-warning mt-2 mb-1"><?= number_format($period_total['total_minutes'] ?? 0) ?></h4>
                    <small class="text-muted">Jam: <?= number_format(round(($period_total['total_minutes'] ?? 0) / 60)) ?></small>
                </div>
            </div>
        </div>
    </div>

    <!-- DAILY REVENUE -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white p-3">
            <h6 class="mb-0"><i class="fas fa-calendar"></i> Pendapatan Harian</h6>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th class="text-end">Jumlah Rental</th>
                            <th class="text-end">Total Menit</th>
                            <th class="text-end">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($daily_revenue)): ?>
                            <?php foreach ($daily_revenue as $day): ?>
                                <tr>
                                    <td><strong><?= date('d/m/Y', strtotime($day['rent_date'])) ?></strong></td>
                                    <td class="text-end"><?= $day['rental_count'] ?></td>
                                    <td class="text-end"><?= number_format($day['total_minutes']) ?> mnt</td>
                                    <td class="text-end"><strong>Rp <?= number_format($day['daily_revenue']) ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- REVENUE BY TYPE -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white p-3">
            <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Pendapatan Per Tipe Konsol</h6>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tipe Konsol</th>
                            <th class="text-end">Jumlah Rental</th>
                            <th class="text-end">Total Pendapatan</th>
                            <th class="text-end">Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($revenue_by_type)): ?>
                            <?php foreach ($revenue_by_type as $type): ?>
                                <tr>
                                    <td><strong><?= $type['console_type'] ?></strong></td>
                                    <td class="text-end"><?= $type['rental_count'] ?></td>
                                    <td class="text-end"><strong>Rp <?= number_format($type['type_revenue']) ?></strong></td>
                                    <td class="text-end">Rp <?= number_format(round($type['avg_revenue'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- REVENUE BY METHOD -->
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white p-3">
            <h6 class="mb-0"><i class="fas fa-credit-card"></i> Pendapatan Per Metode Pembayaran</h6>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Metode Pembayaran</th>
                            <th class="text-end">Transaksi</th>
                            <th class="text-end">Pendapatan</th>
                            <th class="text-end">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($revenue_by_method)): ?>
                            <?php $total = array_sum(array_column($revenue_by_method, 'method_revenue')); ?>
                            <?php foreach ($revenue_by_method as $method): ?>
                                <tr>
                                    <td><strong><?= $method['method_name'] ?></strong></td>
                                    <td class="text-end"><?= $method['transaction_count'] ?></td>
                                    <td class="text-end">Rp <?= number_format($method['method_revenue']) ?></td>
                                    <td class="text-end"><?= $total > 0 ? round(($method['method_revenue'] / $total) * 100) : 0 ?>%</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
