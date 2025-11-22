<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $title ?? '' ?> - Sistem Manajemen PS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
  <div class="nav-title">Sistem Manajemen PlayStation</div>
  <div class="nav-right">
      <?php if ($this->session->userdata('user')): ?>
        <span><?= $this->session->userdata('user')['name'] ?></span>
        <a href="<?= site_url('logout') ?>" class="logout-btn">Logout</a>
      <?php endif; ?>
  </div>
</div>

<!-- SIDEBAR -->
<?php 
// Sidebar hanya muncul jika user sudah login
if ($this->session->userdata('user')) {
    $this->load->view('layouts/sidebar'); 
}
?>

<!-- MAIN CONTENT -->
<div class="main">
