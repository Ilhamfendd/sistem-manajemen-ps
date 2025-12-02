<?php $this->load->view('layouts/auth_header', ['title' => 'Login']); ?>

<div class="login-wrapper">
    <div class="login-container">
        <!-- Login Header -->
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-gamepad"></i>
            </div>
            <h2>GO-KOPI</h2>
            <p>Sistem Manajemen Rental PS</p>
        </div>

        <!-- Error Message -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="flash error">
                <i class="fas fa-exclamation-circle"></i>
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <?= form_open('auth/login', ['class' => 'form']) ?>

            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i> Email
                </label>
                <input 
                    type="email" 
                    id="email"
                    name="email" 
                    placeholder="Masukkan email Anda"
                    required 
                    value="<?= set_value('email') ?>"
                    autocomplete="email"
                >
            </div>

            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> Password
                </label>
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    placeholder="Masukkan password Anda"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button class="btn-login" type="submit">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>

        <?= form_close(); ?>

        <!-- Login Footer -->
        <div class="login-footer">
            <p>
                <i class="fas fa-shield-alt"></i> Sistem Keamanan Terpercaya
            </p>
            <p style="font-size: 11px; color: #666;">
                &copy; 2025 GO-KOPI Rental PS. All rights reserved.
            </p>
        </div>
    </div>
</div>

<?php $this->load->view('layouts/auth_footer'); ?>
