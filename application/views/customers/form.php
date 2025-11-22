<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="card">
    <h2><?= $title ?></h2>

    <?php if (validation_errors()): ?>
        <div class="flash error"><?= validation_errors() ?></div>
    <?php endif; ?>

    <form method="post" action="<?= isset($item) ? site_url('customers/update/'.$item->id) : site_url('customers/store') ?>">

        <label>Nama Lengkap</label>
        <input type="text" name="full_name" value="<?= isset($item) ? $item->full_name : set_value('full_name') ?>" required>

        <label>No. Telepon</label>
        <input type="text" name="phone" value="<?= isset($item) ? $item->phone : set_value('phone') ?>" required>

        <label>Catatan</label>
        <textarea name="note"><?= isset($item) ? $item->note : set_value('note') ?></textarea>

        <br><br>
        <button class="btn btn-primary" type="submit">Simpan</button>
        <a href="<?= site_url('customers') ?>" class="btn btn-secondary">Kembali</a>

    </form>
</div>

<?php $this->load->view('layouts/footer'); ?>
