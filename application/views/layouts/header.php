<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $title ?? '' ?> - Sistem Manajemen PS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="<?= base_url('public/js/dark-mode.js') ?>"></script>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="navbar-container">
    <div class="navbar-brand">
      <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
      </button>
      <span class="brand-text">📱 Sistem Manajemen PS</span>
    </div>
    
    <div class="navbar-menu">
      <div class="navbar-nav">
        <button id="themeToggle" class="theme-toggle" title="Toggle Dark Mode">
          <i class="fas fa-moon"></i>
        </button>
        <?php if ($this->session->userdata('user')): ?>
          <span class="navbar-user">
            <i class="fas fa-user-circle"></i>
            <?= $this->session->userdata('user')['name'] ?>
          </span>
          <a href="<?= site_url('logout') ?>" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<!-- SIDEBAR -->
<?php 
if ($this->session->userdata('user')) {
    $this->load->view('layouts/sidebar'); 
}
?>

<!-- MAIN CONTENT -->
<div class="main-wrapper">
  <div class="main">
