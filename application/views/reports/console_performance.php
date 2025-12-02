<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="mb-4">
        <h2><i class="fas fa-gamepad"></i> <?= $title ?></h2>
        <p class="text-muted">Analisis performa setiap unit konsol</p>
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
                    <a href="<?= site_url('reports/export_console_csv?start_date=' . $start_date . '&end_date=' . $end_date) ?>" class="btn btn-success btn-sm w-100">
                        <i class="fas fa-download"></i> Export CSV
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- CONSOLE STATS TABLE -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white p-3">
            <h6 class="mb-0"><i class="fas fa-chart-table"></i> Statistik Performa Konsol</h6>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Konsol</th>
                            <th class="text-center">Tipe</th>
                            <th class="text-end">Jumlah Rental</th>
                            <th class="text-end">Total Menit</th>
                            <th class="text-end">Total Pendapatan</th>
                            <th class="text-end">Rata-rata Durasi</th>
                            <th class="text-end">Durasi Min</th>
                            <th class="text-end">Durasi Max</th>
                            <th class="text-end">Rata-rata Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($console_stats)): ?>
                            <?php 
                            $total_all_revenue = array_sum(array_column($console_stats, 'total_revenue'));
                            foreach ($console_stats as $console): 
                                $percentage = $total_all_revenue > 0 ? ($console['total_revenue'] / $total_all_revenue) * 100 : 0;
                            ?>
                                <tr>
                                    <td>
                                        <strong><?= $console['console_name'] ?></strong>
                                        <div class="progress mt-2" style="height: 8px; width: 150px;">
                                            <div class="progress-bar bg-success" style="width: <?= $percentage ?>%"></div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary"><?= ucfirst($console['console_type']) ?></span>
                                    </td>
                                    <td class="text-end"><?= $console['rental_count'] ?></td>
                                    <td class="text-end"><?= number_format($console['total_minutes']) ?> mnt</td>
                                    <td class="text-end">
                                        <strong>Rp <?= number_format($console['total_revenue']) ?></strong>
                                    </td>
                                    <td class="text-end"><?= number_format(round($console['avg_duration'])) ?> mnt</td>
                                    <td class="text-end"><?= $console['min_duration'] ?> mnt</td>
                                    <td class="text-end"><?= $console['max_duration'] ?> mnt</td>
                                    <td class="text-end">Rp <?= number_format(round($console['avg_revenue'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-3">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- CONSOLE RANKING -->
    <div class="row mt-5 g-3">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white p-3">
                    <h6 class="mb-0"><i class="fas fa-crown"></i> Top 3 Konsol Terlaris</h6>
                </div>
                <div class="card-body p-3">
                    <div class="list-group">
                        <?php 
                        $sorted = $console_stats ?? [];
                        usort($sorted, function($a, $b) {
                            return ($b['total_revenue'] ?? 0) <=> ($a['total_revenue'] ?? 0);
                        });
                        foreach (array_slice($sorted, 0, 3) as $index => $console):
                        ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">
                                            <span class="badge bg-warning text-dark">#<?= $index + 1 ?></span>
                                            <?= $console['console_name'] ?>
                                        </h6>
                                        <small class="text-muted"><?= $console['rental_count'] ?> rental - <?= number_format($console['total_minutes']) ?> mnt</small>
                                    </div>
                                    <strong class="text-success">Rp <?= number_format($console['total_revenue']) ?></strong>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white p-3">
                    <h6 class="mb-0"><i class="fas fa-hourglass"></i> Konsol Paling Digunakan</h6>
                </div>
                <div class="card-body p-3">
                    <div class="list-group">
                        <?php 
                        $sorted_usage = $console_stats ?? [];
                        usort($sorted_usage, function($a, $b) {
                            return ($b['total_minutes'] ?? 0) <=> ($a['total_minutes'] ?? 0);
                        });
                        foreach (array_slice($sorted_usage, 0, 3) as $index => $console):
                        ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">
                                            <span class="badge bg-info">#<?= $index + 1 ?></span>
                                            <?= $console['console_name'] ?>
                                        </h6>
                                        <small class="text-muted"><?= number_format($console['total_minutes']) ?> mnt - <?= $console['rental_count'] ?> rental</small>
                                    </div>
                                    <strong class="text-primary"><?= number_format(round($console['avg_duration'])) ?> mnt/avg</strong>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
