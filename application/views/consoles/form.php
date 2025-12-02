<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?= $title ?></h5>
                </div>
                <div class="card-body">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <?= validation_errors() ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= isset($item) ? site_url('consoles/update/'.$item->id) : site_url('consoles/store') ?>" class="needs-validation" novalidate>

                        <div class="mb-3">
                            <label for="console_name" class="form-label">Nama Unit <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="console_name" name="console_name"
                                value="<?= isset($item) ? $item->console_name : set_value('console_name') ?>" required>
                            <small class="form-text text-muted">Contoh: PS4 Unit 1, PS5 VIP</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="console_type" class="form-label">Tipe Konsol <span class="text-danger">*</span></label>
                                    <select class="form-select" id="console_type" name="console_type" required>
                                        <option value="">-- Pilih Tipe --</option>
                                        <?php foreach ($console_types as $key => $name): ?>
                                            <option value="<?= $key ?>" 
                                                <?= isset($item) && $item->console_type == $key ? 'selected' : '' ?>>
                                                <?= $name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="available" <?= isset($item) && $item->status == 'available' ? 'selected' : '' ?>>
                                            <i class="fas fa-check-circle"></i> Tersedia
                                        </option>
                                        <option value="in_use" <?= isset($item) && $item->status == 'in_use' ? 'selected' : '' ?>>
                                            <i class="fas fa-play-circle"></i> Sedang Dipakai
                                        </option>
                                        <option value="maintenance" <?= isset($item) && $item->status == 'maintenance' ? 'selected' : '' ?>>
                                            <i class="fas fa-tools"></i> Maintenance
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="price_per_hour" class="form-label">Harga Per Jam (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="price_per_hour" name="price_per_hour" 
                                    value="<?= isset($item) ? number_format($item->price_per_hour, 0, '', '') : set_value('price_per_hour') ?>" 
                                    min="1000" step="1000" required>
                            </div>
                            <small class="form-text text-muted">Minimal Rp 1.000, kelipatan Rp 1.000</small>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Catatan</label>
                            <textarea class="form-control" id="note" name="note" rows="3" placeholder="Kondisi, kerusakan, atau informasi lainnya"><?= isset($item) ? $item->note : set_value('note') ?></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="<?= site_url('consoles') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <?php if (isset($item)): ?>
                                <a href="<?= site_url('consoles/price_history/'.$item->id) ?>" class="btn btn-info">
                                    <i class="fas fa-history"></i> Riwayat Harga
                                </a>
                            <?php endif; ?>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <?php if (isset($item) && isset($price_history) && !empty($price_history)): ?>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-history"></i> Riwayat Harga (5 Terbaru)</h6>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <div class="timeline">
                        <?php foreach (array_slice($price_history, 0, 5) as $history): ?>
                        <div class="mb-3 pb-2" style="border-bottom: 1px solid #eee;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-calendar"></i> <?= date('d/m/Y H:i', strtotime($history['changed_at'])) ?>
                                    </small>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-user"></i> <?= $history['username'] ?? 'Unknown' ?>
                                    </small>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="badge bg-danger"><i class="fas fa-arrow-down"></i> Rp <?= number_format($history['old_price'], 0, ',', '.') ?></span>
                                <i class="fas fa-arrow-right text-muted mx-2"></i>
                                <span class="badge bg-success"><i class="fas fa-arrow-up"></i> Rp <?= number_format($history['new_price'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->load->view('layouts/footer'); ?>
