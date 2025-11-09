<?php $this->load->view('layouts/header', ['title'=>'Login']); ?>

<h2>Login</h2>

<?= form_open('login', ['class'=>'form-login']); ?>
  <label>Email</label>
  <input type="email" name="email" value="<?= set_value('email') ?>" required>

  <label>Password</label>
  <input type="password" name="password" required>

  <button type="submit">Sign In</button>
<?= form_close(); ?>

<?php if (validation_errors()): ?>
  <div class="flash error"><?= validation_errors() ?></div>
<?php endif; ?>

<?php $this->load->view('layouts/footer'); ?>
