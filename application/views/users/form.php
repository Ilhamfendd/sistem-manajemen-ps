<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="card">
    <h3><?= $title ?></h3>
    <p style="color: #666; margin-top: 5px;">
        <?= !isset($user) || is_null($user) ? 'Tambahkan user baru ke dalam sistem' : 'Ubah data user yang sudah ada' ?>
    </p>
</div>

<?php if ($this->form_validation->run() === FALSE && $this->input->method() === 'post'): ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="flash error">
            <i class="fas fa-exclamation-circle"></i>
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="card">
    <form method="post" action="<?= isset($user) && !is_null($user) ? site_url('users/update/' . $user->id) : site_url('users/store') ?>">

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" value="<?= isset($user) && !is_null($user) ? $user->name : set_value('name') ?>" required>
            <?php if (form_error('name')): ?>
                <small style="color: #dc3545;"><?= form_error('name') ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= isset($user) && !is_null($user) ? $user->email : set_value('email') ?>" required>
            <?php if (form_error('email')): ?>
                <small style="color: #dc3545;"><?= form_error('email') ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Password <?= !isset($user) || is_null($user) ? '(required)' : '(biarkan kosong jika tidak ingin mengubah)' ?></label>
            <input type="password" id="password" name="password" <?= !isset($user) || is_null($user) ? 'required' : '' ?>>
            <?php if (form_error('password')): ?>
                <small style="color: #dc3545;"><?= form_error('password') ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="kasir" <?= (isset($user) && !is_null($user) && $user->role == 'kasir') ? 'selected' : (set_value('role') == 'kasir' ? 'selected' : '') ?>>Kasir</option>
                <option value="kasir" <?= (isset($user) && !is_null($user) && $user->role == 'kasir') ? 'selected' : (set_value('role') == 'kasir' ? 'selected' : '') ?>>Kasir</option>
                <option value="owner" <?= (isset($user) && !is_null($user) && $user->role == 'owner') ? 'selected' : (set_value('role') == 'owner' ? 'selected' : '') ?>>Owner</option>
            </select>
            <?php if (form_error('role')): ?>
                <small style="color: #dc3545;"><?= form_error('role') ?></small>
            <?php endif; ?>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> <?= isset($user) && !is_null($user) ? 'Update' : 'Simpan' ?>
            </button>
            <a href="<?= site_url('users') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>

    </form>
</div>

<?php $this->load->view('layouts/footer'); ?>
