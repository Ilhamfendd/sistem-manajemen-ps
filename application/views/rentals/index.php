<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="card">
    <h2>Transaksi Penyewaan</h2>
    <a class="btn btn-primary" href="<?= site_url('rentals/create') ?>">+ Mulai Sewa</a>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="flash success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Unit PS</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Durasi</th>
                <th>Total Biaya</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($items as $r): ?>
            <tr>
                <td><?= $r->full_name ?></td>
                <td><?= $r->console_name ?></td>
                <td><?= $r->start_time ?></td>
                <td><?= $r->end_time ?: '-' ?></td>
                <?php if ($r->status == 'ongoing'): ?>

                    <td id="duration-<?= $r->id ?>" style="color:#1f6feb; font-weight:bold;">
                        calculating...
                    </td>

                    <td id="cost-<?= $r->id ?>" style="color:#d63384; font-weight:bold;">
                        calculating...
                    </td>

                <?php else: ?>

                    <td><?= $r->duration_minutes ?> menit</td>
                    <td>Rp <?= number_format($r->total_cost) ?></td>

                <?php endif; ?>

                <td>
                    <?php if ($r->status == 'ongoing'): ?>

                        <a href="<?= site_url('rentals/finish/'.$r->id) ?>" class="btn btn-warning">
                            Selesai
                        </a>

                        <button class="btn btn-danger" disabled style="opacity:0.5;">
                            Hapus
                        </button>

                    <?php else: ?>

                        <button onclick="confirmDelete(<?= $r->id ?>)" class="btn btn-danger">
                            Hapus
                        </button>

                    <?php endif; ?>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>
</div>
<script>
function formatTime(seconds) {
    let h = Math.floor(seconds / 3600);
    let m = Math.floor((seconds % 3600) / 60);
    let s = Math.floor(seconds % 60);

    return (
        (h < 10 ? "0"+h : h) + ":" +
        (m < 10 ? "0"+m : m) + ":" +
        (s < 10 ? "0"+s : s)
    );
}

function formatRupiah(angka) {
    return "Rp " + angka.toLocaleString('id-ID');
}

<?php foreach ($items as $r): ?>
    <?php if ($r->status == 'ongoing'): ?>

        // waktu mulai JS timestamp
        let start<?= $r->id ?> = new Date("<?= date('c', strtotime($r->start_time)) ?>").getTime();
        let costPerMinute<?= $r->id ?> = <?= $rate_per_hour / 60 ?>;

        setInterval(function() {
            let now = new Date().getTime();
            let diffSec = Math.floor((now - start<?= $r->id ?>) / 1000);

            // update durasi
            document.getElementById("duration-<?= $r->id ?>").innerText =
                formatTime(diffSec);

            // hitung biaya berjalan
            let minutes = diffSec / 60;
            let cost = Math.round(costPerMinute<?= $r->id ?> * minutes);

            document.getElementById("cost-<?= $r->id ?>").innerText =
                formatRupiah(cost);

        }, 1000);

    <?php endif; ?>
<?php endforeach; ?>

function confirmDelete(id) {
    if (confirm("Yakin ingin menghapus transaksi ini?")) {
        window.location.href = "<?= site_url('rentals/delete/') ?>" + id;
    }
}
</script>

<?php $this->load->view('layouts/footer'); ?>
