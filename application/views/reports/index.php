<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="mb-4">
        <h2><i class="fas fa-chart-bar"></i> <?= $title ?></h2>
        <p class="text-muted">Dashboard analitik dan laporan untuk pemilik bisnis</p>
    </div>

    <!-- QUICK STATS ROW -->
    <div class="row mb-4 g-3">
        <!-- Today -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-left-primary h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">Hari Ini</small>
                            <h4 class="text-primary mt-2 mb-1">Rp <?= number_format($today['total_revenue'] ?? 0) ?></h4>
                            <small class="text-muted"><?= ($today['total_rentals'] ?? 0) ?> rental</small>
                        </div>
                        <i class="fas fa-calendar-day fa-2x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- This Month -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-left-success h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">Bulan Ini</small>
                            <h4 class="text-success mt-2 mb-1">Rp <?= number_format($month['total_revenue'] ?? 0) ?></h4>
                            <small class="text-muted"><?= ($month['total_rentals'] ?? 0) ?> rental</small>
                        </div>
                        <i class="fas fa-calendar-alt fa-2x text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Time -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-left-info h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">Total Sepanjang Waktu</small>
                            <h4 class="text-info mt-2 mb-1">Rp <?= number_format($all_time['total_revenue'] ?? 0) ?></h4>
                            <small class="text-muted"><?= ($all_time['total_rentals'] ?? 0) ?> rental</small>
                        </div>
                        <i class="fas fa-infinity fa-2x text-info opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average -->
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-left-warning h-100">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">Rata-rata Per Rental</small>
                            <h4 class="text-warning mt-2 mb-1">Rp <?= number_format($all_time['total_rentals'] > 0 ? round($all_time['total_revenue'] / $all_time['total_rentals']) : 0) ?></h4>
                            <small class="text-muted">Sepanjang waktu</small>
                        </div>
                        <i class="fas fa-chart-line fa-2x text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 7-DAY TREND -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white p-3">
            <h6 class="mb-0"><i class="fas fa-chart-line"></i> Tren 7 Hari Terakhir</h6>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th class="text-end">Jumlah Rental</th>
                            <th class="text-end">Pendapatan</th>
                            <th class="text-center" style="width: 200px;">Visualisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $max_revenue = max(array_column($trend, 'revenue'));
                        foreach ($trend as $day):
                            $percentage = $max_revenue > 0 ? ($day['revenue'] / $max_revenue) * 100 : 0;
                        ?>
                        <tr>
                            <td><strong><?= $day['date'] ?></strong></td>
                            <td class="text-end"><?= $day['rentals'] ?></td>
                            <td class="text-end"><strong>Rp <?= number_format($day['revenue']) ?></strong></td>
                            <td>
                                <div class="progress" style="height: 18px;">
                                    <div class="progress-bar bg-success" style="width: <?= $percentage ?>%"></div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- REPORT CARDS -->
    <div class="row g-3">
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white p-3">
                    <h6 class="mb-0"><i class="fas fa-money-bill-wave"></i> Laporan Pendapatan</h6>
                </div>
                <div class="card-body p-3">
                    <p class="text-muted small">Analisis pendapatan berdasarkan tanggal, tipe konsol, dan metode pembayaran</p>
                    <div class="btn-group-vertical w-100" role="group">
                        <a href="<?= site_url('reports/revenue') ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-arrow-right"></i> Buka Laporan
                        </a>
                        <a href="<?= site_url('reports/export_revenue_csv') ?>" class="btn btn-outline-success btn-sm mt-2">
                            <i class="fas fa-download"></i> Export CSV
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white p-3">
                    <h6 class="mb-0"><i class="fas fa-gamepad"></i> Performa Konsol</h6>
                </div>
                <div class="card-body p-3">
                    <p class="text-muted small">Performa setiap unit konsol: penjualan, durasi, revenue</p>
                    <div class="btn-group-vertical w-100" role="group">
                        <a href="<?= site_url('reports/console_performance') ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-arrow-right"></i> Buka Laporan
                        </a>
                        <a href="<?= site_url('reports/export_console_csv') ?>" class="btn btn-outline-info btn-sm mt-2">
                            <i class="fas fa-download"></i> Export CSV
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-warning text-dark p-3">
                    <h6 class="mb-0"><i class="fas fa-credit-card"></i> Analisis Pembayaran</h6>
                </div>
                <div class="card-body p-3">
                    <p class="text-muted small">Status pembayaran, metode pembayaran, dan piutang</p>
                    <div class="btn-group-vertical w-100" role="group">
                        <a href="<?= site_url('reports/payment_analysis') ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-right"></i> Buka Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-secondary text-white p-3">
                    <h6 class="mb-0"><i class="fas fa-users"></i> Analisis Pelanggan</h6>
                </div>
                <div class="card-body p-3">
                    <p class="text-muted small">Pelanggan top berdasarkan pengeluaran dan frekuensi</p>
                    <div class="btn-group-vertical w-100" role="group">
                        <a href="<?= site_url('reports/customer_analysis') ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-right"></i> Buka Laporan
                        </a>
                        <a href="<?= site_url('reports/export_customer_csv') ?>" class="btn btn-outline-secondary btn-sm mt-2">
                            <i class="fas fa-download"></i> Export CSV
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary { border-left: 4px solid #007bff !important; }
.border-left-success { border-left: 4px solid #28a745 !important; }
.border-left-info { border-left: 4px solid #17a2b8 !important; }
.border-left-warning { border-left: 4px solid #ffc107 !important; }
</style>

<?php $this->load->view('layouts/footer'); ?>
