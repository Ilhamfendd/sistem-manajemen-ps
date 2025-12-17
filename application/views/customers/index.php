<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <?php $this->load->view('layouts/notifications'); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-users"></i> <?= $title ?></h2>
        <a class="btn btn-primary" href="<?= site_url('customers/create') ?>">
            <i class="fas fa-plus"></i> Tambah Pelanggan
        </a>
    </div>

    <?php if (empty($items)): ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Tidak ada data pelanggan</p>
        </div>
    <?php else: ?>
        <div class="table-responsive mb-0">
            <table class="table table-hover table-striped table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Lengkap</th>
                        <th>ID Pelanggan</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $i => $c): ?>
                    <tr>
                        <td><strong><?= $i+1 ?></strong></td>
                        <td><?= $c->full_name ?></td>
                        <td><strong><?= $c->customer_id ?></strong></td>
                        <td><?= $c->note ?></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-info" title="Download QR" 
                                        onclick="downloadCustomerQR('<?= $c->customer_id ?>')">
                                    <i class="fas fa-qrcode"></i>
                                </button>
                                <a href="<?= site_url('customers/edit/'.$c->id) ?>" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= site_url('customers/delete/'.$c->id) ?>" class="btn btn-danger" 
                                    onclick="showConfirm('Hapus pelanggan #<?= $c->id ?>?', 'Hapus Pelanggan', () => window.location.href=this.href); return false;" title="Hapus">
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

<script>
function downloadCustomerQR(customerId) {
    const link = document.createElement('a');
    link.href = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' + encodeURIComponent(customerId);
    link.download = `QR-${customerId}.png`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>

