<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<style>
.rental-cards-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 30px;
}

.rental-card-wrapper {
    flex: 0 0 calc(25% - 6px);
}

@media (max-width: 1199px) {
    .rental-card-wrapper {
        flex: 0 0 calc(33.333% - 6px);
    }
}

@media (max-width: 767px) {
    .rental-card-wrapper {
        flex: 0 0 calc(50% - 4px);
    }
}

@media (max-width: 575px) {
    .rental-card-wrapper {
        flex: 0 0 100%;
    }
}
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-cash-register"></i> <?= $title ?></h2>
        <a class="btn btn-primary" href="<?= site_url('rentals/create') ?>">
            <i class="fas fa-plus"></i> Mulai Penyewaan Baru
        </a>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- ONGOING RENTALS SECTION -->
    <div class="mb-5">
        <div class="d-flex align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-play-circle text-warning"></i> Penyewaan Berlangsung</h4>
            <span class="badge bg-warning ms-2"><?= count($ongoing) ?></span>
        </div>

        <?php if (empty($ongoing)): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Tidak ada penyewaan yang sedang berlangsung</p>
            </div>
        <?php else: ?>
            <div class="rental-cards-container">
                <?php foreach ($ongoing as $r): ?>
                <div class="rental-card-wrapper">
                    <div class="card shadow-sm border-warning h-100">
                        <div class="card-header bg-warning text-dark p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0" style="font-size: 0.9rem;"><strong>#<?= $r->id ?></strong></h6>
                                <span class="badge bg-dark" style="font-size: 0.7rem;"><?= $r->console_type ?></span>
                            </div>
                        </div>
                        
                        <div class="card-body p-2">
                            <div class="mb-2">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Pelanggan</small>
                                <p class="mb-1" style="font-size: 0.85rem;"><strong><?= substr($r->full_name, 0, 15) ?></strong></p>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Unit</small>
                                <p class="mb-1" style="font-size: 0.85rem;"><i class="fas fa-gamepad"></i> <?= $r->console_name ?></p>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">Mulai</small>
                                    <p class="mb-0" style="font-size: 0.85rem;"><strong><?= date('H:i', strtotime($r->start_time)) ?></strong></p>
                                </div>
                                <div style="text-align: right;">
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">Durasi</small>
                                    <p class="mb-0">
                                        <strong class="text-danger" id="duration-<?= $r->id ?>" style="font-size: 1.1rem;">0:00:00</strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light p-2">
                            <a href="<?= site_url('rentals/finish/'.$r->id) ?>" class="btn btn-sm btn-warning w-100" style="font-size: 0.8rem;">
                                <i class="fas fa-stop-circle"></i> Selesai
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- FINISHED RENTALS SECTION -->
    <div>
        <div class="d-flex align-items-center mb-3">
            <h4 class="mb-0"><i class="fas fa-check-circle text-success"></i> Penyewaan Selesai</h4>
            <span class="badge bg-success ms-2"><?= count($finished) ?></span>
        </div>

        <?php if (empty($finished)): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Belum ada penyewaan yang selesai</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>Unit PS</th>
                            <th>Durasi</th>
                            <th>Total Biaya</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($finished as $r): ?>
                        <tr>
                            <td><strong>#<?= $r->id ?></strong></td>
                            <td><?= $r->full_name ?></td>
                            <td>
                                <?php if ($r->console_type): ?>
                                    <span class="badge bg-info"><?= $r->console_type ?></span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Unit Terhapus</span>
                                <?php endif; ?>
                                <?= $r->console_name ?? '(Konsol tidak ditemukan)' ?>
                            </td>
                            <td>
                                <?php 
                                $hours = floor($r->duration_minutes / 60);
                                $mins = $r->duration_minutes % 60;
                                echo $hours . 'j ' . $mins . 'm';
                                ?>
                            </td>
                            <td><strong class="text-success">Rp <?= number_format($r->total_amount) ?></strong></td>
                            <td>
                                <?php 
                                if ($r->payment_status == 'paid') {
                                    echo '<span class="badge bg-success"><i class="fas fa-check"></i> Lunas</span>';
                                } elseif ($r->payment_status == 'partial') {
                                    echo '<span class="badge bg-warning"><i class="fas fa-exclamation"></i> Sebagian</span>';
                                } else {
                                    echo '<span class="badge bg-danger"><i class="fas fa-times"></i> Belum</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?= site_url('rentals/invoice/'.$r->id) ?>" class="btn btn-primary" title="Struk">
                                        <i class="fas fa-receipt"></i>
                                    </a>
                                    <a href="<?= site_url('rentals/delete/'.$r->id) ?>" class="btn btn-danger" 
                                        onclick="return confirm('Hapus penyewaan #<?= $r->id ?>?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
<?php foreach ($ongoing as $r): ?>
(function() {
    const startTime = new Date("<?= date('c', strtotime($r->start_time)) ?>").getTime();
    const estimatedHours = <?= $r->estimated_hours ?>;
    const rentalId = <?= $r->id ?>;
    const totalSeconds = estimatedHours * 3600; // Total seconds dari estimated hours
    
    function updateCountdown() {
        const now = new Date().getTime();
        const elapsedMs = now - startTime;
        const elapsedSec = Math.floor(elapsedMs / 1000);
        
        // Countdown: kurangi total seconds dengan elapsed seconds
        let remainingSec = totalSeconds - elapsedSec;
        if (remainingSec < 0) remainingSec = 0;
        
        // Calculate countdown time (HH:MM:SS format)
        const hours = Math.floor(remainingSec / 3600);
        const minutes = Math.floor((remainingSec % 3600) / 60);
        const seconds = remainingSec % 60;
        
        const countdownStr = 
            (hours < 10 ? "0" + hours : hours) + ":" +
            (minutes < 10 ? "0" + minutes : minutes) + ":" +
            (seconds < 10 ? "0" + seconds : seconds);
        
        const durationElement = document.getElementById("duration-" + rentalId);
        if (durationElement) {
            durationElement.textContent = countdownStr;
            
            // Jika sudah 0:00:00, otomatis redirect ke finish
            if (remainingSec <= 0) {
                // Auto finish rental
                window.location.href = "<?= site_url('rentals/finish/') ?>" + rentalId;
            }
        }
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
})();
<?php endforeach; ?>
</script>

<?php $this->load->view('layouts/footer'); ?>
