<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-chart-bar"></i> <?= $title ?></h2>
        <a href="<?= site_url('consoles') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Status Report -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-toggle-on"></i> Ringkasan Status Unit</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php 
                        $total_units = 0;
                        $status_colors = [
                            'available' => '#28a745',
                            'in_use' => '#ffc107',
                            'maintenance' => '#dc3545'
                        ];
                        $status_labels = [
                            'available' => 'Tersedia',
                            'in_use' => 'Sedang Dipakai',
                            'maintenance' => 'Maintenance'
                        ];
                        $status_icons = [
                            'available' => 'check-circle',
                            'in_use' => 'play-circle',
                            'maintenance' => 'tools'
                        ];
                        
                        foreach ($status_report as $status): 
                            $total_units += $status['count'];
                        ?>
                        <div class="col-md-4 mb-3">
                            <div class="card text-center" style="border-left: 4px solid <?= $status_colors[$status['status']] ?>;">
                                <div class="card-body">
                                    <i class="fas fa-<?= $status_icons[$status['status']] ?>" style="font-size: 2rem; color: <?= $status_colors[$status['status']] ?>;"></i>
                                    <h5 class="mt-3"><?= $status['count'] ?></h5>
                                    <p class="text-muted mb-0"><?= $status_labels[$status['status']] ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Total Unit: <strong><?= $total_units ?></strong></h6>
                            <div class="progress">
                                <?php foreach ($status_report as $status): ?>
                                <div class="progress-bar" role="progressbar" 
                                    style="width: <?= ($status['count'] / $total_units) * 100 ?>%; background-color: <?= $status_colors[$status['status']] ?>;"
                                    title="<?= $status_labels[$status['status']] ?>: <?= $status['count'] ?>">
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Type Report -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-cube"></i> Laporan Per Tipe Konsol</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tipe</th>
                                    <th class="text-center">Jumlah Unit</th>
                                    <th class="text-end">Harga Rata-rata</th>
                                    <th class="text-end">Harga Minimal</th>
                                    <th class="text-end">Harga Maksimal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($type_report as $type): ?>
                                <tr>
                                    <td><strong><?= $type['console_type'] ?></strong></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary"><?= $type['count'] ?></span>
                                    </td>
                                    <td class="text-end">
                                        <strong>Rp <?= number_format($type['avg_price'], 0, ',', '.') ?></strong>
                                    </td>
                                    <td class="text-end text-success">
                                        Rp <?= number_format($type['min_price'], 0, ',', '.') ?>
                                    </td>
                                    <td class="text-end text-danger">
                                        Rp <?= number_format($type['max_price'], 0, ',', '.') ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Price List -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-list"></i> Daftar Harga Lengkap</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Unit</th>
                                    <th>Tipe</th>
                                    <th class="text-end">Harga/Jam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($price_list as $i => $unit): ?>
                                <tr>
                                    <td><?= $i+1 ?></td>
                                    <td><strong><?= $unit['console_name'] ?></strong></td>
                                    <td><span class="badge bg-secondary"><?= $unit['console_type'] ?></span></td>
                                    <td class="text-end">
                                        <strong class="text-success">Rp <?= number_format($unit['price_per_hour'], 0, ',', '.') ?></strong>
                                    </td>
                                    <td>
                                        <?php 
                                        $status_map = [
                                            'available' => '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Tersedia</span>',
                                            'in_use' => '<span class="badge bg-warning"><i class="fas fa-play-circle"></i> Dipakai</span>',
                                            'maintenance' => '<span class="badge bg-danger"><i class="fas fa-tools"></i> Maintenance</span>'
                                        ];
                                        echo $status_map[$unit['status']] ?? '-';
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Button -->
    <div class="mt-4 text-center">
        <button class="btn btn-outline-secondary" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
    </div>
</div>

<style>
@media print {
    .btn, .d-flex, .navbar, footer {
        display: none !important;
    }
    .card {
        page-break-inside: avoid;
    }
}
</style>

<?php $this->load->view('layouts/footer'); ?>
