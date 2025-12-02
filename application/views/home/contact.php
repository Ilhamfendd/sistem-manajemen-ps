<?php $this->load->view('layouts/header_public'); ?>

<div class="hero" style="padding: 60px 0;">
    <div class="container">
        <h1>Hubungi Kami</h1>
        <p>Ada pertanyaan? Jangan ragu untuk menghubungi!</p>
    </div>
</div>

<section class="available-units">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><i class="fas fa-map-marker-alt"></i> Lokasi Toko</h5>
                        <p>
                            <strong>GO-KOPI Rental PS</strong><br>
                            Jl. Raya Utama, No. 123<br>
                            Kota Anda, Indonesia<br>
                            <br>
                            <strong>Jam Operasional:</strong><br>
                            24 Jam / Setiap Hari
                        </p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><i class="fas fa-phone"></i> Hubungi Langsung</h5>
                        <p>
                            <strong>Telepon:</strong> +62 8XX-XXXX-XXXX<br>
                            <strong>WhatsApp:</strong> +62 8XX-XXXX-XXXX<br>
                            <strong>Email:</strong> info@gokopi.id
                        </p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><i class="fas fa-social"></i> Media Sosial</h5>
                        <p>
                            <a href="#" class="btn btn-sm btn-outline-primary">
                                <i class="fab fa-facebook"></i> Facebook
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-danger">
                                <i class="fab fa-instagram"></i> Instagram
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-success">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-envelope"></i> Kirim Pesan</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <?= $this->session->flashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?= form_open('contact', ['method' => 'post']) ?>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" 
                                       name="name" value="<?= set_value('name') ?>" required>
                                <?php if (form_error('name')): ?>
                                    <div class="invalid-feedback"><?= form_error('name') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" 
                                       name="email" value="<?= set_value('email') ?>" required>
                                <?php if (form_error('email')): ?>
                                    <div class="invalid-feedback"><?= form_error('email') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control <?= form_error('phone') ? 'is-invalid' : '' ?>" 
                                       name="phone" value="<?= set_value('phone') ?>" required>
                                <?php if (form_error('phone')): ?>
                                    <div class="invalid-feedback"><?= form_error('phone') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pesan</label>
                                <textarea class="form-control <?= form_error('message') ? 'is-invalid' : '' ?>" 
                                          name="message" rows="5" required><?= set_value('message') ?></textarea>
                                <?php if (form_error('message')): ?>
                                    <div class="invalid-feedback"><?= form_error('message') ?></div>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block w-100">
                                <i class="fas fa-paper-plane"></i> Kirim Pesan
                            </button>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('layouts/footer_public'); ?>
