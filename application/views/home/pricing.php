<?php $this->load->view('layouts/header_public'); ?>

<div class="hero" style="padding: 60px 0;">
    <div class="container">
        <h1>Harga Sewa GO-KOPI</h1>
        <p>Terjangkau dan Kompetitif</p>
    </div>
</div>

<section class="available-units">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="section-title">
                    <h2>Daftar Harga</h2>
                    <p>Semua harga per jam pemain</p>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th>Tipe Console</th>
                                <th>Harga Per Jam</th>
                                <th>Total Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pricing)): ?>
                                <?php foreach ($pricing as $item): ?>
                                    <tr>
                                        <td>
                                            <strong><?= $item['console_type'] ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Rp <?= number_format($item['avg_price'], 0, ',', '.') ?></span>
                                        </td>
                                        <td><?= $item['total'] ?> unit</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Tidak ada data pricing</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-check-circle text-success"></i> Keuntungan</h5>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-check text-success"></i> Harga Terjangkau</li>
                                    <li><i class="fas fa-check text-success"></i> Sistem Per Jam</li>
                                    <li><i class="fas fa-check text-success"></i> Console Terbaru</li>
                                    <li><i class="fas fa-check text-success"></i> Game Lengkap</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-info-circle text-info"></i> Informasi</h5>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-clock"></i> Pembayaran langsung setelah selesai</li>
                                    <li><i class="fas fa-credit-card"></i> Tunai saja (untuk sekarang)</li>
                                    <li><i class="fas fa-user"></i> Tidak perlu deposit</li>
                                    <li><i class="fas fa-star"></i> Gratis welcome snack</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('layouts/footer_public'); ?>
