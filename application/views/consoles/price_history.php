<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fas fa-history"></i> <?= $title ?></h2>
            <p class="text-muted">
                <strong><?= $console['console_name'] ?></strong> 
                <span class="badge bg-info"><?= $console['console_type'] ?></span>
                | Harga Saat Ini: <strong class="text-success">Rp <?= number_format($console['price_per_hour'], 0, ',', '.') ?>/jam</strong>
            </p>
        </div>
        <a href="<?= site_url('consoles') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-list"></i> Daftar Perubahan Harga</h6>
                </div>
                <div class="card-body">
                    <?php if (empty($history)): ?>
                        <div class="notification notification-info notification-flash" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                            <div class="notification-icon" style="font-size: 2rem;"><i class="fas fa-information-circle"></i></div>
                            <div class="notification-content" style="text-align: center;">
                                <p class="notification-message">Tidak ada riwayat perubahan harga untuk unit ini.</p>
                                <small style="opacity: 0.7;">Perubahan harga akan tercatat di sini saat Anda mengedit harga.</small>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="timeline">
                            <?php foreach ($history as $i => $record): ?>
                            <div class="mb-4 pb-4" style="border-left: 3px solid #0d6efd; padding-left: 20px; position: relative;">
                                <!-- Timeline dot -->
                                <div style="
                                    position: absolute;
                                    left: -8px;
                                    top: 0;
                                    width: 12px;
                                    height: 12px;
                                    background: #0d6efd;
                                    border: 2px solid white;
                                    border-radius: 50%;
                                "></div>

                                <div class="row align-items-start">
                                    <div class="col-md-8">
                                        <div class="card-sm">
                                            <p class="mb-2">
                                                <strong>Perubahan #{<?= $i+1 ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt"></i> 
                                                    <?= date('d M Y', strtotime($record['changed_at'])) ?> 
                                                    <i class="fas fa-clock"></i> 
                                                    <?= date('H:i:s', strtotime($record['changed_at'])) ?>
                                                </small>
                                            </p>
                                            <p class="mb-0">
                                                <small class="text-muted">
                                                    <i class="fas fa-user-circle"></i> Diubah oleh: 
                                                    <strong><?= $record['username'] ?? 'Unknown User' ?></strong>
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div class="price-change">
                                            <div class="mb-2">
                                                <span class="badge bg-danger" style="padding: 8px 12px; font-size: 0.95rem;">
                                                    <i class="fas fa-arrow-down"></i> 
                                                    Rp <?= number_format($record['old_price'], 0, ',', '.') ?>
                                                </span>
                                            </div>
                                            <div style="font-size: 1.5rem; color: #999; margin: 5px 0;">→</div>
                                            <div>
                                                <span class="badge bg-success" style="padding: 8px 12px; font-size: 0.95rem;">
                                                    <i class="fas fa-arrow-up"></i> 
                                                    Rp <?= number_format($record['new_price'], 0, ',', '.') ?>
                                                </span>
                                            </div>
                                            <div style="margin-top: 8px;">
                                                <?php 
                                                $diff = $record['new_price'] - $record['old_price'];
                                                $percent = ($diff / $record['old_price']) * 100;
                                                ?>
                                                <small class="<?= $diff > 0 ? 'text-success' : 'text-danger' ?>">
                                                    <strong>
                                                        <?= $diff > 0 ? '+' : '' ?><?= number_format($diff, 0, ',', '.') ?>
                                                        (<?= $diff > 0 ? '+' : '' ?><?= number_format($percent, 1, ',', '.') ?>%)
                                                    </strong>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-chart-line"></i> Statistik Harga</h6>
                </div>
                <div class="card-body">
                    <?php 
                    if (!empty($history)) {
                        $prices = array_map(function($h) { return [$h['old_price'], $h['new_price']]; }, $history);
                        $all_prices = [];
                        foreach ($prices as $p) {
                            $all_prices[] = $p[0];
                            $all_prices[] = $p[1];
                        }
                        $all_prices[] = $console['price_per_hour'];
                        
                        $min_price = min($all_prices);
                        $max_price = max($all_prices);
                        $avg_price = round(array_sum($all_prices) / count($all_prices));
                        $current_price = $console['price_per_hour'];
                    }
                    ?>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted"><small>Harga Tertinggi</small></label>
                        <h5 class="text-success">Rp <?= number_format($max_price ?? 0, 0, ',', '.') ?></h5>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted"><small>Harga Terendah</small></label>
                        <h5 class="text-danger">Rp <?= number_format($min_price ?? 0, 0, ',', '.') ?></h5>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted"><small>Rata-rata Harga</small></label>
                        <h5 class="text-info">Rp <?= number_format($avg_price ?? 0, 0, ',', '.') ?></h5>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label text-muted"><small>Harga Saat Ini</small></label>
                        <h5 class="text-primary">Rp <?= number_format($current_price, 0, ',', '.') ?></h5>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted"><small>Total Perubahan</small></label>
                        <h5><?= count($history) ?> kali</h5>
                    </div>

                    <hr>

                    <div class="d-grid">
                        <a href="<?= site_url('consoles/edit/'.$console['id']) ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit Harga
                        </a>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Unit</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <small class="text-muted">Nama Unit</small><br>
                        <strong><?= $console['console_name'] ?></strong>
                    </p>
                    <p class="mb-2">
                        <small class="text-muted">Tipe Konsol</small><br>
                        <strong><?= $console['console_type'] ?></strong>
                    </p>
                    <p class="mb-2">
                        <small class="text-muted">Status</small><br>
                        <span class="badge 
                            <?= $console['status'] == 'available' ? 'bg-success' : ($console['status'] == 'in_use' ? 'bg-warning' : 'bg-danger') ?>">
                            <?= ucfirst($console['status']) ?>
                        </span>
                    </p>
                    <?php if ($console['note']): ?>
                    <p class="mb-0">
                        <small class="text-muted">Catatan</small><br>
                        <small><?= $console['note'] ?></small>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
