<?php $this->load->view('layouts/header', ['title' => 'Dashboard']); ?>

<div class="card">
    <h2 style="margin-bottom:10px;">Dashboard</h2>
    <p>Selamat datang, <b><?= $this->session->userdata('user')['name'] ?></b> 👋</p>
</div>

<div class="dashboard-grid">

    <div class="dash-box" style="background:#1f6feb;">
        <h3><?= $total_customers ?></h3>
        <p>Pelanggan</p>
    </div>

    <div class="dash-box" style="background:#8250df;">
        <h3><?= $total_consoles ?></h3>
        <p>Unit PS</p>
    </div>

    <div class="dash-box" style="background:#d63384;">
        <h3><?= $total_available ?></h3>
        <p>Tersedia</p>
    </div>

    <div class="dash-box" style="background:#fd7e14;">
        <h3><?= $total_in_use ?></h3>
        <p>Sedang Dipakai</p>
    </div>

</div>

<?php $this->load->view('layouts/footer'); ?>
