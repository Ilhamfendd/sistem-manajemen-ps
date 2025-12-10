<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $title ?? '' ?> - Sistem Manajemen PS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <script src="<?= base_url('public/js/dark-mode.js') ?>"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR SIMPLE (NO SIDEBAR) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= site_url('home') ?>">
      <i class="fas fa-gamepad"></i> GO-KOPI
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url('home') ?>">
            <i class="fas fa-home"></i> Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url('booking') ?>">
            <i class="fas fa-calendar-check"></i> Pesan Sekarang
          </a>
        </li>
        <?php if ($this->session->userdata('user')): ?>
          <li class="nav-item">
            <span class="nav-link">
              <i class="fas fa-user-circle"></i> <?= $this->session->userdata('user')['name'] ?>
            </span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= site_url('auth/logout') ?>">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link btn btn-light text-primary ms-2" href="<?= site_url('auth/login') ?>">
              <i class="fas fa-sign-in-alt"></i> Login
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- MAIN CONTENT (NO SIDEBAR) -->
<div class="container-fluid">
