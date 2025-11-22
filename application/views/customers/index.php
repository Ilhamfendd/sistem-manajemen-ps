<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="card">
    <h2 style="margin-bottom:10px;">Data Pelanggan</h2>

    <a href="<?= site_url('customers/create') ?>" class="btn btn-primary">+ Tambah Pelanggan</a>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="flash success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Lengkap</th>
                <th>No. Telepon</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($items as $i => $c): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= $c->full_name ?></td>
                <td><?= $c->phone ?></td>
                <td><?= $c->note ?></td>
                <td>
                    <a class="btn btn-secondary" href="<?= site_url('customers/edit/'.$c->id) ?>">Edit</a>
                    <a class="btn btn-danger" href="<?= site_url('customers/delete/'.$c->id) ?>" onclick="return confirm('Hapus pelanggan ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $this->load->view('layouts/footer'); ?>
