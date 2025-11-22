<?php 
$role = $this->session->userdata('user')['role'];
$uri1 = $this->uri->segment(1);
?>

<a href="<?= site_url('dashboard') ?>">Dashboard</a>

<?php if ($role == 'admin'): ?>
  <a href="<?= site_url('users') ?>">Manajemen User</a>
  <a href="<?= site_url('reports') ?>">Laporan</a>
<?php endif; ?>

<?php if (in_array($role, ['admin','kasir'])): ?>
  <a href="<?= site_url('customers') ?>">Pelanggan</a>
  <a href="<?= site_url('consoles') ?>">Unit PS</a>
  <a href="<?= site_url('rentals') ?>">Transaksi Sewa</a>
<?php endif; ?>

<a href="<?= site_url('logout') ?>">Logout</a>
