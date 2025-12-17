<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <?php $this->load->view('layouts/notifications'); ?>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus-circle"></i> <?= $title ?></h5>
                </div>
                <div class="card-body">

                    <form method="post" action="<?= site_url('rentals/store') ?>" class="needs-validation">

                        <!-- Pelanggan -->
                        <div class="mb-3">
                            <label for="customer_id" class="form-label fw-semibold">Pelanggan <span class="text-danger">*</span></label>
                            <select class="form-select" id="customer_id" name="customer_id" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php foreach ($customers as $c): ?>
                                    <option value="<?= $c->id ?>">
                                        <?= $c->full_name ?> (<?= $c->customer_id ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Unit PlayStation -->
                        <div class="mb-3">
                            <label for="console_id" class="form-label fw-semibold">Unit PlayStation <span class="text-danger">*</span></label>
                            <select class="form-select" id="console_id" name="console_id" required onchange="updateEstimatedCost()">
                                <option value="">-- Pilih Unit --</option>
                                <?php foreach ($consoles as $ps): ?>
                                    <option value="<?= $ps->id ?>" data-price="<?= $ps->price_per_hour ?>">
                                        <?= $ps->console_name ?> - Rp <?= number_format($ps->price_per_hour) ?>/jam
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Estimasi Durasi -->
                        <div class="mb-4">
                            <label for="estimated_duration" class="form-label fw-semibold">Estimasi Durasi <span class="text-danger">*</span></label>
                            <select class="form-select" id="estimated_duration" name="estimated_duration" required onchange="updateEstimatedCost()">
                                <option value="">-- Pilih Durasi --</option>
                                <option value="1">1 Jam</option>
                                <option value="2">2 Jam</option>
                                <option value="3">3 Jam</option>
                                <option value="4">4 Jam</option>
                                <option value="5">5 Jam</option>
                                <option value="6">6 Jam</option>
                                <option value="12">12 Jam</option>
                                <option value="24">24 Jam</option>
                            </select>
                        </div>

                        <!-- Estimasi Total -->
                        <div class="bg-light p-3 rounded mb-4 border-start border-4 border-success">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-0 small">Estimasi Total Biaya</p>
                                    <p class="h4 text-success mb-0" id="est-total">Rp -</p>
                                </div>
                                <div class="text-end">
                                    <p class="text-muted mb-0 small">Durasi: <strong id="est-duration-display">-</strong></p>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-play"></i> Mulai Penyewaan
                            </button>
                            <a href="<?= site_url('rentals') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateEstimatedCost() {
    const consoleSelect = document.getElementById('console_id');
    const durationSelect = document.getElementById('estimated_duration');
    
    const consoleOption = consoleSelect.options[consoleSelect.selectedIndex];
    const duration = durationSelect.value;
    
    if (consoleOption.value && duration) {
        const pricePerHour = parseInt(consoleOption.getAttribute('data-price'));
        const totalCost = pricePerHour * parseInt(duration);
        
        document.getElementById('est-duration-display').textContent = duration + ' jam';
        document.getElementById('est-total').textContent = 'Rp ' + totalCost.toLocaleString('id-ID');
    } else {
        document.getElementById('est-duration-display').textContent = '-';
        document.getElementById('est-total').textContent = 'Rp -';
    }
}
</script>

<?php $this->load->view('layouts/footer'); ?>
