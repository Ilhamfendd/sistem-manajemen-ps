<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <?php $this->load->view('layouts/notifications'); ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-gamepad"></i> <?= $title ?></h2>
        <a class="btn btn-primary" href="<?= site_url('consoles/create') ?>">
            <i class="fas fa-plus"></i> Tambah Unit
        </a>
    </div>

    <?php if (empty($items)): ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Tidak ada unit PlayStation</p>
        </div>
    <?php else: ?>
        <div class="table-responsive mb-0">
            <table class="table table-hover table-striped table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Unit</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $i => $c): ?>
                    <tr>
                        <td><strong><?= $i+1 ?></strong></td>
                        <td><?= $c->console_name ?></td>
                        <td><span class="badge bg-info"><?= $c->console_type ?></span></td>
                        <td>
                            <?php
                                if ($c->status == 'available') {
                                    echo '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Available</span>';
                                } elseif ($c->status == 'di_pesan') {
                                    echo '<span class="badge bg-info"><i class="fas fa-calendar-check"></i> Dipesan</span>';
                                } elseif ($c->status == 'in_use') {
                                    echo '<span class="badge bg-warning"><i class="fas fa-hourglass-half"></i> Dipakai</span>';
                                } elseif ($c->status == 'maintenance') {
                                    echo '<span class="badge bg-danger"><i class="fas fa-wrench"></i> Maintenance</span>';
                                }
                            ?>
                        </td>
                        <td><?= $c->note ?></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="<?= site_url('consoles/edit/'.$c->id) ?>" class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= site_url('consoles/delete/'.$c->id) ?>" class="btn btn-danger" 
                                    onclick="showConfirm('Hapus unit #<?= $c->id ?>?', 'Hapus Unit', () => window.location.href=this.href); return false;" title="Hapus">
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

<?php $this->load->view('layouts/footer'); ?>
