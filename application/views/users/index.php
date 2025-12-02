<?php $this->load->view('layouts/header', ['title' => $title]); ?>

<div class="container mt-4">
    <div class="mb-4">
        <h2><i class="fas fa-users-cog"></i> <?= $title ?></h2>
        <p class="text-muted">Halaman ini hanya bisa diakses oleh <strong>Admin</strong>.</p>
    </div>

    <?php if (empty($items)): ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
            <p class="text-muted mt-3">Tidak ada user</p>
        </div>
    <?php else: ?>
        <div class="table-responsive mb-0">
            <table class="table table-hover table-striped table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $i => $u): ?>
                    <tr>
                        <td><strong><?= $i+1 ?></strong></td>
                        <td><?= $u->name ?></td>
                        <td><?= $u->email ?></td>
                        <td>
                            <?php
                                $role = ucfirst($u->role);
                                if ($u->role == 'admin') {
                                    echo '<span class="badge bg-danger"><i class="fas fa-crown"></i> ' . $role . '</span>';
                                } elseif ($u->role == 'kasir') {
                                    echo '<span class="badge bg-warning"><i class="fas fa-cash-register"></i> ' . $role . '</span>';
                                } elseif ($u->role == 'owner') {
                                    echo '<span class="badge bg-success"><i class="fas fa-briefcase"></i> ' . $role . '</span>';
                                }
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php $this->load->view('layouts/footer'); ?>
