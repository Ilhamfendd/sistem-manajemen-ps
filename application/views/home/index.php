<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="<?= base_url('public/js/dark-mode.js') ?>"></script>
    <style>
        :root {
            --primary: #1f6feb;
            --secondary: #4a5568;
            --danger: #dc3545;
            --success: #28a745;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
            background: #f9fafb;
        }
        
        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--primary) 0%, #1558c5 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }
        
        body.dark-mode .navbar {
            background: linear-gradient(135deg, #0d1b2a 0%, #1a2332 100%) !important;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .navbar-brand i {
            font-size: 1.8rem;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, #1558c5 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        
        body.dark-mode .hero {
            background: linear-gradient(135deg, #0d1b2a 0%, #1a2332 100%) !important;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.95;
        }
        
        .btn-primary-light {
            background: white;
            color: var(--primary);
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        body.dark-mode .btn-primary-light {
            background: #2a2a2a;
            color: #4a9eff;
            border: 2px solid #4a9eff;
        }
        
        body.dark-mode .btn-primary-light:hover {
            background: #4a9eff;
            color: #1a1a1a;
        }
        
        .btn-primary-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        /* Available Units Section */
        .available-units {
            padding: 60px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--primary);
        }
        
        body.dark-mode .section-title h2 {
            color: #4a9eff !important;
        }
        
        .section-title p {
            font-size: 1.1rem;
            color: #6b7280;
        }
        
        body.dark-mode .section-title p {
            color: #aaa !important;
        }
        
        /* Console Cards */
        .console-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .console-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .console-card-header {
            background: linear-gradient(135deg, var(--primary) 0%, #1558c5 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        body.dark-mode .console-card-header {
            background: linear-gradient(135deg, #1f6feb 0%, #1558c5 100%) !important;
        }
        
        .console-card-header h4 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .console-card-body {
            padding: 25px;
        }
        
        .price-tag {
            font-size: 2rem;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .price-tag span {
            font-size: 1rem;
            color: #6b7280;
        }
        
        .available-badge {
            display: inline-block;
            background: var(--success);
            color: white;
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .console-details {
            margin: 20px 0;
            font-size: 0.95rem;
            line-height: 1.8;
        }
        
        .console-details p {
            margin: 8px 0;
            color: #6b7280;
        }
        
        .console-details i {
            color: var(--primary);
            margin-right: 10px;
            width: 20px;
        }
        
        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, rgba(31,111,235,0.05) 0%, rgba(74,85,104,0.05) 100%);
            padding: 40px 0;
            margin: 40px 0;
        }
        
        body.dark-mode .stats-section {
            background: linear-gradient(135deg, rgba(31,111,235,0.1) 0%, rgba(74,85,104,0.1) 100%) !important;
        }
        
        .stat-item {
            text-align: center;
            padding: 20px;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
        }
        
        .stat-label {
            color: #6b7280;
            font-size: 1rem;
            margin-top: 10px;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
            margin: 60px 0;
        }
        
        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            font-weight: 700;
        }
        
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-cta {
            padding: 15px 40px;
            border: 2px solid white;
            background: transparent;
            color: white;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-cta:hover {
            background: white;
            color: var(--primary);
        }
        
        .btn-cta.filled {
            background: white;
            color: var(--primary);
        }
        
        .btn-cta.filled:hover {
            background: transparent;
            color: white;
        }
        
        /* Footer */
        .footer {
            background: #1f2937;
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 30px;
        }
        
        .footer-section h4 {
            margin-bottom: 20px;
            font-weight: 700;
            color: var(--primary);
        }
        
        .footer-section p {
            color: #d1d5db;
            line-height: 1.8;
            margin-bottom: 10px;
        }
        
        .footer-section a {
            color: #d1d5db;
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }
        
        .footer-section a:hover {
            color: white;
            padding-left: 5px;
        }
        
        .footer-divider {
            border-top: 1px solid #374151;
            margin-top: 30px;
            padding-top: 20px;
            text-align: center;
            color: #9ca3af;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
        }

        /* ============================================
           DARK MODE STYLES - HOME PAGE
           ============================================ */
        body.dark-mode {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: #e0e0e0;
        }

        body.dark-mode .navbar {
            background: linear-gradient(135deg, #0d1b2a 0%, #1a2332 100%) !important;
        }

        body.dark-mode .nav-link {
            color: #b0b0b0 !important;
        }

        body.dark-mode .nav-link:hover {
            color: #fff !important;
        }

        body.dark-mode .console-card {
            background: #242424;
            color: #e0e0e0;
        }

        body.dark-mode .console-card-body {
            background: #242424;
            color: #e0e0e0;
        }

        body.dark-mode .hero {
            background: linear-gradient(135deg, #0d1b2a 0%, #1a2332 100%) !important;
        }

        body.dark-mode .section-title h2 {
            color: #a8d8ff;
        }

        body.dark-mode .section-title p {
            color: #b0b0b0;
        }

        body.dark-mode .faq-item {
            background: #242424;
            border-color: #333;
        }

        body.dark-mode .faq-question {
            color: #fff;
            background: #2a2a2a;
        }

        body.dark-mode .faq-answer {
            color: #d0d0d0;
        }

        body.dark-mode .contact-form input,
        body.dark-mode .contact-form textarea {
            background: #2a2a2a;
            border-color: #444;
            color: #e0e0e0;
        }

        body.dark-mode .contact-form input:focus,
        body.dark-mode .contact-form textarea:focus {
            background: #2d3a4a;
            border-color: #1f6feb;
            box-shadow: 0 0 0 3px rgba(31, 111, 235, 0.2);
        }

        body.dark-mode .btn-light {
            background: #3a3a3a;
            color: #fff;
            border-color: #444;
        }

        body.dark-mode .btn-light:hover {
            background: #4a4a4a;
        }

        body.dark-mode footer {
            background: #1a1a1a;
            color: #b0b0b0;
            border-top: 1px solid #333;
        }

        body.dark-mode .footer-divider {
            border-top-color: #333;
            color: #888;
        }

        body.dark-mode #themeToggle {
            color: #ffc107 !important;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fas fa-gamepad"></i>
                GO-KOPI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('pricing') ?>">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('faq') ?>">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('contact') ?>">Hubungi</a>
                    </li>
                    <li class="nav-item">
                        <button id="themeToggle" class="btn btn-link nav-link" style="border: none; background: none; cursor: pointer; text-decoration: none; color: white;" onclick="window.toggleDarkMode(); return false;">
                            <i class="fas fa-moon"></i>
                        </button>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-sm btn-light text-primary fw-bold ms-2" href="<?= base_url('auth/login') ?>">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container">
            <h1><i class="fas fa-gamepad"></i> Selamat Datang di GO-KOPI</h1>
            <p>Nikmati pengalaman gaming PS4/PS5 terbaik dengan harga terjangkau</p>
            <a href="#available" class="btn-primary-light">Lihat Ketersediaan Unit</a>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 stat-item">
                    <div class="stat-number" id="total-units">-</div>
                    <div class="stat-label">Total Unit</div>
                </div>
                <div class="col-md-4 stat-item">
                    <div class="stat-number" id="available-units">-</div>
                    <div class="stat-label">Tersedia Sekarang</div>
                </div>
                <div class="col-md-4 stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Jam Operasional</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Units Section -->
    <section class="available-units" id="available">
        <div class="container">
            <div class="section-title">
                <h2>Unit Tersedia</h2>
                <p>Pilih console favorit Anda dan mulai bermain sekarang!</p>
            </div>

            <div class="row">
                <?php if (!empty($available_consoles)): ?>
                    <?php foreach ($available_consoles as $console): ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="console-card">
                                <div class="console-card-header">
                                    <h4><?= $console['console_name'] ?></h4>
                                    <small><?= $console['console_type'] ?></small>
                                </div>
                                <div class="console-card-body">
                                    <div class="available-badge">
                                        <i class="fas fa-check-circle"></i> Tersedia
                                    </div>
                                    <div class="price-tag">
                                        Rp <?= number_format($console['price_per_hour'], 0, ',', '.') ?>
                                        <span>/jam</span>
                                    </div>
                                    <div class="console-details">
                                        <p><i class="fas fa-tv"></i> <?= $console['console_type'] ?></p>
                                        <p><i class="fas fa-clock"></i> Sistem Per Jam</p>
                                        <p><i class="fas fa-gamepad"></i> Game Terbaru</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> Semua unit sedang dipakai. Silakan coba lagi nanti.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <div class="cta-section">
        <div class="container">
            <h2>Siap Bermain?</h2>
            <p style="font-size: 1.1rem; margin-bottom: 30px; opacity: 0.95;">Kunjungi toko kami atau hubungi untuk informasi lebih lanjut</p>
            <div class="cta-buttons">
                <a href="<?= base_url('contact') ?>" class="btn-cta filled">
                    <i class="fas fa-envelope"></i> Hubungi Kami
                </a>
                <a href="<?= base_url('faq') ?>" class="btn-cta">
                    <i class="fas fa-question-circle"></i> Punya Pertanyaan?
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4><i class="fas fa-gamepad"></i> GO-KOPI</h4>
                    <p>Pusat gaming terlengkap dengan konsol terbaru dan game pilihan.</p>
                    <p><strong>Jam Buka:</strong> 24/7</p>
                </div>
                <div class="footer-section">
                    <h4><i class="fas fa-map-marker-alt"></i> Lokasi</h4>
                    <p>Jl. Raya Utama, No. 123</p>
                    <p>Kota Anda, Indonesia</p>
                    <p><strong>Telepon:</strong> +62 8XX-XXXX-XXXX</p>
                </div>
                <div class="footer-section">
                    <h4><i class="fas fa-link"></i> Menu</h4>
                    <a href="<?= base_url() ?>">Home</a>
                    <a href="<?= base_url('pricing') ?>">Pricing</a>
                    <a href="<?= base_url('faq') ?>">FAQ</a>
                    <a href="<?= base_url('contact') ?>">Hubungi</a>
                    <a href="<?= base_url('auth/login') ?>">Login</a>
                </div>
                <div class="footer-section">
                    <h4><i class="fas fa-social"></i> Ikuti Kami</h4>
                    <p>
                        <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
                        <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                        <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
                        <a href="#"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                    </p>
                </div>
            </div>
            <div class="footer-divider">
                <p>&copy; 2025 GO-KOPI Rental PS. All rights reserved. | Created with <i class="fas fa-heart text-danger"></i> by Your Dev Team</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load unit stats
        fetch('<?= base_url('api/get_available_units') ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('available-units').textContent = data.total;
                }
            });

        // Load total units
        fetch('<?= base_url('api/total_units') ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('total-units').textContent = data.total;
                }
            });

        // Dark mode - Ensure persistence on navigation
        (function() {
          const savedTheme = localStorage.getItem('theme');
          if (savedTheme === 'dark-mode') {
            document.documentElement.classList.add('dark-mode');
            document.body.classList.add('dark-mode');
          }
        })();
    </script>
</body>
</html>
