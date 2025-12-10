<?php 
$role = $this->session->userdata('user')['role'];
$uri1 = $this->uri->segment(1);
?>

<aside class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <h3>Menu</h3>
    <button class="close-btn" id="closeBtn">
      <i class="fas fa-times"></i>
    </button>
  </div>

  <div class="sidebar-content">
    
    <!-- Management Section - Kasir -->
    <?php if ($role == 'kasir'): ?>
      <div class="sidebar-section">
        <p class="sidebar-title">MANAJEMEN</p>

        <a href="<?= site_url('consoles') ?>" class="sidebar-item <?= ($uri1 == 'consoles') ? 'active' : '' ?>">
          <i class="fas fa-gamepad"></i>
          <span>Unit PS</span>
        </a>

        <a href="<?= site_url('customers') ?>" class="sidebar-item <?= ($uri1 == 'customers') ? 'active' : '' ?>">
          <i class="fas fa-users"></i>
          <span>Pelanggan</span>
        </a>

        <a href="<?= site_url('rentals') ?>" class="sidebar-item <?= ($uri1 == 'rentals') ? 'active' : '' ?>">
          <i class="fas fa-exchange-alt"></i>
          <span>Transaksi Sewa</span>
        </a>

        <a href="<?= site_url('debts') ?>" class="sidebar-item <?= ($uri1 == 'debts') ? 'active' : '' ?>">
          <i class="fas fa-list"></i>
          <span>Daftar Hutang</span>
        </a>

        <a href="<?= site_url('booking/manage') ?>" class="sidebar-item <?= ($uri1 == 'booking') ? 'active' : '' ?>">
          <i class="fas fa-calendar-check"></i>
          <span>Booking Online</span>
        </a>
      </div>
    <?php endif; ?>

    <!-- Owner Section - Reports & Analytics -->
    <?php if ($role == 'owner'): ?>
      <div class="sidebar-section">
        <p class="sidebar-title">LAPORAN & ANALITIK</p>

        <a href="<?= site_url('reports') ?>" class="sidebar-item <?= ($uri1 == 'reports') ? 'active' : '' ?>">
          <i class="fas fa-chart-bar"></i>
          <span>Dashboard Laporan</span>
        </a>

        <a href="<?= site_url('reports/revenue') ?>" class="sidebar-item <?= ($uri1 == 'reports' && $this->uri->segment(2) == 'revenue') ? 'active' : '' ?>">
          <i class="fas fa-money-bill-wave"></i>
          <span>Laporan Pendapatan</span>
        </a>

        <a href="<?= site_url('reports/console_performance') ?>" class="sidebar-item <?= ($uri1 == 'reports' && $this->uri->segment(2) == 'console_performance') ? 'active' : '' ?>">
          <i class="fas fa-gamepad"></i>
          <span>Performa Konsol</span>
        </a>

        <a href="<?= site_url('reports/payment_analysis') ?>" class="sidebar-item <?= ($uri1 == 'reports' && $this->uri->segment(2) == 'payment_analysis') ? 'active' : '' ?>">
          <i class="fas fa-credit-card"></i>
          <span>Analisis Pembayaran</span>
        </a>

        <a href="<?= site_url('reports/customer_analysis') ?>" class="sidebar-item <?= ($uri1 == 'reports' && $this->uri->segment(2) == 'customer_analysis') ? 'active' : '' ?>">
          <i class="fas fa-users"></i>
          <span>Analisis Pelanggan</span>
        </a>
      </div>
    <?php endif; ?>

    <!-- Logout -->
    <div class="sidebar-section" style="margin-top: auto; border-top: 1px solid #ddd; padding-top: 15px;">
      <a href="<?= site_url('logout') ?>" class="sidebar-item logout">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
      </a>
    </div>

  </div>
</aside>

<!-- Overlay untuk mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>
