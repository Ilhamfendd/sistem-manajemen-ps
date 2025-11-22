<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="card">
    <h2><?= $title ?></h2>

    <form method="post" action="<?= site_url('rentals/store') ?>">

        <label>Pilih Pelanggan</label>
        <select name="customer_id" required>
            <option value="">-- pilih --</option>
            <?php foreach ($customers as $c): ?>
                <option value="<?= $c->id ?>"><?= $c->full_name ?></option>
            <?php endforeach; ?>
        </select>

        <label>Pilih Unit PS</label>
        <select name="console_id" required>
            <option value="">-- pilih --</option>
            <?php foreach ($consoles as $ps): ?>
                <option value="<?= $ps->id ?>"><?= $ps->console_name ?> (<?= $ps->console_type ?>)</option>
            <?php endforeach; ?>
        </select>

        <br><br>
        <button class="btn btn-primary" type="submit">Mulai Sewa</button>
        <a href="<?= site_url('rentals') ?>" class="btn btn-secondary">Kembali</a>

    </form>
</div>

<?php $this->load->view('layouts/footer'); ?>
