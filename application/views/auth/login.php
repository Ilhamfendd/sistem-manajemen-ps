<?php $this->load->view('layouts/auth_header', ['title' => 'Login']); ?>

<div class="login-container">
    <h2>Login</h2>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="flash error"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <?= form_open('login'); ?>

        <label>Email</label>
        <input type="email" name="email" required value="<?= set_value('email') ?>">

        <label>Password</label>
        <input type="password" name="password" required>

        <button class="btn btn-primary" type="submit" style="width:100%; margin-top:10px;">
            Sign In
        </button>

    <?= form_close(); ?>
</div>

<?php $this->load->view('layouts/auth_footer'); ?>
