<?php $this->load->view('layouts/header'); ?>
<?php $this->load->view('layouts/notifications'); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Penyesuaian Pembayaran Penyewaan #<?php echo $rental['id']; ?></h4>
                </div>
                <div class="card-body">
                    
                    <?php if ($difference > 0): ?>
                        <!-- Ada Pembayaran Tambahan -->
                        <div class="notification notification-warning notification-flash" style="display: flex; margin-bottom: 1.5rem;">
                            <div class="notification-icon"><i class="fas fa-exclamation-triangle"></i></div>
                            <div class="notification-content">
                                <p class="notification-title" style="margin-bottom: 0.5rem; font-weight: 600;">Sisa Pembayaran</p>
                                <p class="notification-message" style="margin-bottom: 0.5rem;">Pelanggan belum melunasi pembayaran penuh. Sisa yang harus dibayar:</p>
                                <p style="font-size: 1.3rem; font-weight: bold; color: #ff9800; margin-top: 0.5rem; margin-bottom: 0;">Rp <?php echo number_format($difference, 0, ',', '.'); ?></p>
                            </div>
                        </div>

                        <!-- Payment Form -->
                        <form method="POST" action="<?php echo base_url('rentals/process_payment_adjustment/' . $rental['id']); ?>">
                            <div class="form-group mb-3">
                                <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                <select id="payment_method" name="payment_method" class="form-select" required>
                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                    <?php if (!empty($payment_methods)): ?>
                                        <?php foreach ($payment_methods as $method): ?>
                                            <option value="<?php echo $method['id']; ?>">
                                                <?php echo $method['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="amount" class="form-label">Jumlah Pembayaran (Rp)</label>
                                <input 
                                    type="number" 
                                    id="amount" 
                                    name="amount" 
                                    class="form-control" 
                                    value="<?php echo $difference; ?>"
                                    min="0"
                                    required
                                >
                            </div>

                            <div class="form-group mb-4">
                                <label for="notes" class="form-label">Catatan (Opsional)</label>
                                <textarea 
                                    id="notes" 
                                    name="notes" 
                                    class="form-control" 
                                    rows="2"
                                    placeholder="Catatan..."
                                ></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary" onclick="window.location.href='<?php echo base_url('rentals/mark_debt/' . $rental['id']); ?>'">Batal</button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-check-circle"></i> Selesaikan Pembayaran
                                </button>
                            </div>
                        </form>

                    <?php else: ?>
                        <!-- Pembayaran Sudah Selesai -->
                        <div class="notification notification-success notification-flash" style="display: flex; margin-bottom: 1.5rem;">
                            <div class="notification-icon"><i class="fas fa-check-circle"></i></div>
                            <div class="notification-content">
                                <p class="notification-title" style="margin-bottom: 0.5rem; font-weight: 600;">Pembayaran Selesai</p>
                                <p class="notification-message">Penyewaan telah selesai dan pembayaran sudah lunas.</p>
                            </div>
                        </div>

                        <div class="text-center mb-4">
                            <p class="text-muted mb-2">Total Biaya</p>
                            <p class="h3 text-success">Rp <?php echo number_format($rental['total_amount'], 0, ',', '.'); ?></p>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="<?php echo base_url('rentals'); ?>" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Penyewaan
                            </a>
                        </div>

                    <?php endif; ?>

                </div>
            </div>

            <!-- Info Box -->
            <div class="notification notification-info notification-flash" style="display: flex; margin-top: 1.5rem;">
                <div class="notification-icon"><i class="fas fa-info-circle"></i></div>
                <div class="notification-content">
                    <p class="notification-title" style="margin-bottom: 0.5rem; font-weight: 600;">Kebijakan Penyewaan</p>
                    <ul class="mb-0" style="margin-left: 1rem; font-size: 0.95rem;">
                        <li>Durasi aktual dihitung dari waktu mulai hingga waktu selesai</li>
                        <li>Biaya minimum = Estimasi awal (tidak ada pengembalian untuk durasi lebih pendek)</li>
                        <li>Biaya tambahan hanya jika durasi actual MELEBIHI estimasi yang dibayar</li>
                        <li>Contoh: Bayar 2 jam, pakai 1.5 jam → Tetap bayar 2 jam (tidak ada pengembalian)</li>
                        <li>Contoh: Bayar 2 jam, pakai 2.5 jam → Bayar 2.5 jam (tambah Rp untuk 0.5 jam)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Dark mode support
    document.addEventListener('DOMContentLoaded', function() {
        const isDarkMode = localStorage.getItem('darkMode') === 'true';
        if (isDarkMode) {
            document.body.classList.add('dark-mode');
        }
    });
</script>

<?php $this->load->view('layouts/footer'); ?>
