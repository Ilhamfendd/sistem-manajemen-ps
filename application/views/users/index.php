<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="card">
    <h2>Manajemen User</h2>
    <p>Halaman ini hanya bisa diakses oleh <b>Admin</b>.</p>
</div>

<table>
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($items as $u): ?>
        <tr>
            <td><?= $u->name ?></td>
            <td><?= $u->email ?></td>
            <td>
                <span style="font-weight:bold;color:#1f6feb;">
                    <?= ucfirst($u->role) ?>
                </span>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $this->load->view('layouts/footer'); ?>
