<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="card">
    <h2><?= $title ?></h2>

    <?php if (validation_errors()): ?>
        <div class="flash error"><?= validation_errors() ?></div>
    <?php endif; ?>

    <form method="post" action="<?= isset($item) ? site_url('consoles/update/'.$item->id) : site_url('consoles/store') ?>">

        <label>Nama Unit</label>
        <input type="text" name="console_name"
            value="<?= isset($item) ? $item->console_name : set_value('console_name') ?>" required>

        <label>Tipe</label>
        <select name="console_type" required>
            <option value="">-- Pilih --</option>
            <option value="PS4" <?= isset($item) && $item->console_type == 'PS4' ? 'selected' : '' ?>>PS4</option>
            <option value="PS5" <?= isset($item) && $item->console_type == 'PS5' ? 'selected' : '' ?>>PS5</option>
        </select>

        <label>Status</label>
        <select name="status">
            <option value="available"    <?= isset($item) && $item->status == 'available' ? 'selected' : '' ?>>Available</option>
            <option value="in_use"       <?= isset($item) && $item->status == 'in_use' ? 'selected' : '' ?>>Dipakai</option>
            <option value="maintenance"  <?= isset($item) && $item->status == 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
        </select>

        <label>Catatan</label>
        <textarea name="note"><?= isset($item) ? $item->note : set_value('note') ?></textarea>

        <br><br>
        <button class="btn btn-primary" type="submit">Simpan</button>
        <a href="<?= site_url('consoles') ?>" class="btn btn-secondary">Kembali</a>

    </form>
</div>

<?php $this->load->view('layouts/footer'); ?>
