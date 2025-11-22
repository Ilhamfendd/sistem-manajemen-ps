<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="card">
    <h2>Laporan Pendapatan</h2>
    <p>Ringkasan pendapatan berdasarkan transaksi selesai.</p>
</div>

<!-- RINGKASAN -->
<div class="dashboard-grid">

    <div class="dash-box" style="background:#1f6feb;">
        <h3>Rp <?= number_format($today['income']) ?></h3>
        <p>Pendapatan Hari Ini (<?= $today['count'] ?> transaksi)</p>
    </div>

    <div class="dash-box" style="background:#8250df;">
        <h3>Rp <?= number_format($week['income']) ?></h3>
        <p>Pendapatan Minggu Ini (<?= $week['count'] ?> transaksi)</p>
    </div>

    <div class="dash-box" style="background:#fd7e14;">
        <h3>Rp <?= number_format($month['income']) ?></h3>
        <p>Pendapatan Bulan Ini (<?= $month['count'] ?> transaksi)</p>
    </div>
</div>

<!-- TABEL TRANSAKSI -->
<div class="card" style="margin-top: 30px;">
    <h3>Transaksi Bulan Ini</h3>
    <table>
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Unit PS</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Durasi</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $r): ?>
                <tr>
                    <td><?= $r->customer_id ?></td>
                    <td><?= $r->console_id ?></td>
                    <td><?= $r->start_time ?></td>
                    <td><?= $r->end_time ?></td>
                    <td><?= $r->duration_minutes ?> menit</td>
                    <td>Rp <?= number_format($r->total_cost) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php $this->load->view('layouts/footer'); ?>
