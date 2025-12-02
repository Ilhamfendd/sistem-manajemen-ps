<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body" style="background: white; padding: 30px;">
                    <!-- HEADER -->
                    <div class="text-center mb-4">
                        <h2 style="margin: 0; font-weight: bold;">GO-KOPI</h2>
                        <p style="margin: 5px 0 0 0; color: #666; font-size: 0.9rem;">PlayStation Rental</p>
                        <hr style="margin: 10px 0;">
                    </div>

                    <!-- RECEIPT INFO -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <small class="text-muted">No. Struk</small>
                            <p class="mb-0"><strong>#<?= $rental['id'] ?></strong></p>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted">Tanggal</small>
                            <p class="mb-0"><strong><?= date('d/m/Y') ?></strong></p>
                        </div>
                    </div>

                    <hr>

                    <!-- CUSTOMER INFO -->
                    <div class="mb-3">
                        <small class="text-muted">NAMA PELANGGAN</small>
                        <p class="mb-1"><strong><?= $rental['full_name'] ?></strong></p>
                        <small class="text-muted"><?= $rental['phone'] ?></small>
                    </div>

                    <hr>

                    <!-- RENTAL DETAILS TABLE -->
                    <div class="mb-3">
                        <small class="text-muted">DETAIL PENYEWAAN</small>
                        <table style="width: 100%; margin-top: 8px; font-size: 0.95rem;">
                            <tr>
                                <td><strong>Unit</strong></td>
                                <td class="text-end"><strong><?= $rental['console_name'] ?></strong></td>
                            </tr>
                            <tr>
                                <td>Tipe</td>
                                <td class="text-end"><?= $rental['console_type'] ?></td>
                            </tr>
                            <tr>
                                <td>Mulai</td>
                                <td class="text-end"><?= date('d/m/Y H:i', strtotime($rental['start_time'])) ?></td>
                            </tr>
                            <tr>
                                <td>Selesai</td>
                                <td class="text-end"><?= date('d/m/Y H:i', strtotime($rental['end_time'])) ?></td>
                            </tr>
                            <tr>
                                <td>Durasi</td>
                                <td class="text-end">
                                    <?php 
                                    $hours = floor($rental['duration_minutes'] / 60);
                                    $mins = $rental['duration_minutes'] % 60;
                                    echo $hours . 'j ' . $mins . 'm';
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <hr>

                    <!-- PRICING -->
                    <div class="mb-3">
                        <table style="width: 100%;">
                            <tr>
                                <td><strong>Harga/Jam</strong></td>
                                <td class="text-end"><strong>Rp <?= number_format($rental['price_per_hour']) ?></strong></td>
                            </tr>
                            <tr style="border-top: 2px solid #333; border-bottom: 2px solid #333;">
                                <td style="padding: 10px 0; font-size: 1.1rem;"><strong>TOTAL BIAYA</strong></td>
                                <td class="text-end" style="padding: 10px 0; font-size: 1.1rem;"><strong>Rp <?= number_format($rental['total_amount']) ?></strong></td>
                            </tr>
                        </table>
                    </div>

                    <!-- PAYMENT INFO -->
                    <div class="mb-3 p-3" style="background: #f8f9fa; border-radius: 5px;">
                        <small class="text-muted">RINGKASAN PEMBAYARAN</small>
                        <table style="width: 100%; margin-top: 8px; font-size: 0.95rem;">
                            <tr>
                                <td>Total Biaya</td>
                                <td class="text-end">Rp <?= number_format($rental['total_amount']) ?></td>
                            </tr>
                            <tr>
                                <td>Telah Dibayar</td>
                                <td class="text-end">Rp <?= number_format($paid_amount) ?></td>
                            </tr>
                            <tr style="border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; padding-top: 8px;">
                                <td style="padding: 8px 0;"><strong>Sisa Pembayaran</strong></td>
                                <td class="text-end" style="padding: 8px 0;">
                                    <strong class="<?= $outstanding > 0 ? 'text-danger' : 'text-success' ?>">
                                        Rp <?= number_format($outstanding) ?>
                                    </strong>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- PAYMENT METHOD HISTORY -->
                    <?php if (isset($rental['transactions']) && !empty($rental['transactions'])): ?>
                    <div class="mb-3">
                        <small class="text-muted">PEMBAYARAN DITERIMA</small>
                        <table style="width: 100%; margin-top: 8px; font-size: 0.9rem;">
                            <?php foreach ($rental['transactions'] as $t): ?>
                            <tr>
                                <td><?= $t['method_name'] ?? 'Unknown' ?></td>
                                <td class="text-end"><strong>Rp <?= number_format($t['amount']) ?></strong></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php endif; ?>

                    <hr>

                    <!-- STATUS BADGE -->
                    <div class="text-center mb-3">
                        <?php if ($outstanding <= 0): ?>
                        <div style="padding: 10px; background: #d4edda; color: #155724; border-radius: 5px;">
                            <strong><i class="fas fa-check-circle"></i> PEMBAYARAN LUNAS</strong>
                        </div>
                        <?php elseif ($paid_amount > 0): ?>
                        <div style="padding: 10px; background: #fff3cd; color: #856404; border-radius: 5px;">
                            <strong><i class="fas fa-exclamation-circle"></i> PEMBAYARAN SEBAGIAN</strong>
                        </div>
                        <?php else: ?>
                        <div style="padding: 10px; background: #f8d7da; color: #721c24; border-radius: 5px;">
                            <strong><i class="fas fa-times-circle"></i> BELUM DIBAYAR</strong>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- FOOTER -->
                    <div class="text-center mt-4">
                        <small class="text-muted">
                            Terima kasih telah menggunakan layanan kami.<br>
                            Tanggal Cetak: <?= date('d/m/Y H:i:s') ?>
                        </small>
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="mt-3 d-flex gap-2 justify-content-center">
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Cetak Struk
                </button>
                <?php if ($outstanding > 0): ?>
                <a href="<?= site_url('rentals/payment/'.$rental['id']) ?>" class="btn btn-warning">
                    <i class="fas fa-credit-card"></i> Tambah Pembayaran
                </a>
                <?php endif; ?>
                <a href="<?= site_url('rentals') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body {
        background: white;
    }
    .btn, .mt-3, hr:last-child {
        display: none !important;
    }
    .card {
        box-shadow: none !important;
        border: none !important;
    }
}
</style>

<?php $this->load->view('layouts/footer'); ?>
