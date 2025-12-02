<?php $this->load->view('layouts/header_public'); ?>

<div class="hero" style="padding: 60px 0;">
    <div class="container">
        <h1>Pertanyaan Umum (FAQ)</h1>
        <p>Cari jawaban atas pertanyaan Anda di sini</p>
    </div>
</div>

<section class="available-units">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="accordion" id="faqAccordion">
                    <?php foreach ($faqs as $index => $faq): ?>
                        <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                            <h2 class="accordion-header">
                                <button class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?>" 
                                        type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#faq<?= $index ?>">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    <?= $faq['q'] ?>
                                </button>
                            </h2>
                            <div id="faq<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" 
                                 data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <?= $faq['a'] ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-5 p-4 bg-light rounded">
                    <h5><i class="fas fa-lightbulb text-warning"></i> Masih ada pertanyaan?</h5>
                    <p>Hubungi kami melalui:</p>
                    <ul>
                        <li><strong>WhatsApp:</strong> +62 8XX-XXXX-XXXX</li>
                        <li><strong>Telepon:</strong> +62 8XX-XXXX-XXXX</li>
                        <li><strong>Email:</strong> info@gokopi.id</li>
                        <li><strong>Datang Langsung:</strong> Jl. Raya Utama, No. 123</li>
                    </ul>
                    <a href="<?= base_url('contact') ?>" class="btn btn-primary">
                        <i class="fas fa-envelope"></i> Kirim Pesan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('layouts/footer_public'); ?>
