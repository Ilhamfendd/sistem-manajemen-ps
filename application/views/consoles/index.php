<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="card">
    <h2>Unit PlayStation</h2>

    <a href="<?= site_url('consoles/create') ?>" class="btn btn-primary">+ Tambah Unit</a>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="flash success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <table>
        <thead>
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
                    <td><?= $i+1 ?></td>
                    <td><?= $c->console_name ?></td>
                    <td><?= $c->console_type ?></td>
                    <td>
                        <?php
                            if ($c->status == 'available') echo "<span style='color:green;'>Available</span>";
                            if ($c->status == 'in_use') echo "<span style='color:#d33;'>Dipakai</span>";
                            if ($c->status == 'maintenance') echo "<span style='color:#c97300;'>Maintenance</span>";
                        ?>
                    </td>
                    <td><?= $c->note ?></td>
                    <td>
                        <a class="btn btn-secondary" href="<?= site_url('consoles/edit/'.$c->id) ?>">Edit</a>
                        <a class="btn btn-danger" href="<?= site_url('consoles/delete/'.$c->id) ?>" onclick="return confirm('Hapus unit ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $this->load->view('layouts/footer'); ?>
