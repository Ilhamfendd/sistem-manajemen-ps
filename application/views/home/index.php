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
            background: linear-gradient(135deg, #1f6feb 0%, #0d47a1 100%);
            color: white;
            padding: 120px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .hero::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(30px); }
        }
        
        body.dark-mode .hero {
            background: linear-gradient(135deg, #0d1b2a 0%, #051e3e 100%) !important;
        }
        
        .hero h1 {
            font-size: 4.5rem;
            font-weight: 900;
            margin-bottom: 20px;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            letter-spacing: -1px;
            position: relative;
            z-index: 1;
            animation: slideInDown 0.8s ease-out;
        }
        
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .hero p {
            font-size: 1.4rem;
            margin-bottom: 40px;
            opacity: 0.95;
            position: relative;
            z-index: 1;
            animation: slideInUp 0.8s ease-out 0.2s backwards;
            font-weight: 300;
            letter-spacing: 0.5px;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .btn-primary-light {
            background: white;
            color: var(--primary);
            font-weight: 700;
            padding: 15px 40px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn-primary-light::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: #f0f0f0;
            transition: left 0.3s ease;
            z-index: -1;
        }
        
        .btn-primary-light:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(31, 111, 235, 0.3);
        }
        
        body.dark-mode .btn-primary-light {
            background: #0f3460;
            color: #4a9eff;
            border: 2px solid #4a9eff;
        }
        
        body.dark-mode .btn-primary-light:hover {
            background: #1f5490;
            color: #fff;
            box-shadow: 0 15px 40px rgba(74, 158, 255, 0.3);
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
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            height: 100%;
            position: relative;
            border: 1px solid #e9ecef;
        }
        
        .console-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), #0d47a1);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .console-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(31, 111, 235, 0.2);
        }
        
        .console-card:hover::before {
            transform: scaleX(1);
        }
        
        .console-card-header {
            background: linear-gradient(135deg, var(--primary) 0%, #1558c5 100%);
            color: white;
            padding: 28px 25px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .console-card:hover .console-card-header {
            background: linear-gradient(135deg, #0d47a1 0%, #0932a8 100%);
        }
        
        body.dark-mode .console-card-header {
            background: linear-gradient(135deg, #1f6feb 0%, #1558c5 100%) !important;
        }
        
        body.dark-mode .console-card {
            border-color: #333;
        }
        
        .console-card-header h4 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            font-weight: 800;
            letter-spacing: 0.5px;
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
            background: linear-gradient(135deg, rgba(31,111,235,0.08) 0%, rgba(13,71,161,0.08) 100%);
            padding: 60px 0;
            margin: 60px 0;
            position: relative;
            overflow: hidden;
        }
        
        .stats-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(31,111,235,0.1), transparent);
            border-radius: 50%;
            pointer-events: none;
        }
        
        body.dark-mode .stats-section {
            background: linear-gradient(135deg, rgba(31,111,235,0.15) 0%, rgba(74,85,104,0.15) 100%) !important;
        }
        
        .stat-item {
            text-align: center;
            padding: 30px 20px;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }
        
        .stat-item:hover {
            transform: translateY(-5px);
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 900;
            color: var(--primary);
            display: block;
            line-height: 1;
            letter-spacing: -2px;
        }
        
        .stat-label {
            color: #6b7280;
            font-size: 1.1rem;
            margin-top: 12px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        body.dark-mode .stat-number {
            color: #4a9eff;
        }
        
        body.dark-mode .stat-label {
            color: #aaa;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, #0d47a1 50%, var(--secondary) 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
            margin: 80px 0;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.1), transparent);
            border-radius: 50%;
        }
        
        .cta-section::after {
            content: '';
            position: absolute;
            bottom: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.08), transparent);
            border-radius: 50%;
        }
        
        .cta-section h2 {
            font-size: 2.8rem;
            margin-bottom: 20px;
            font-weight: 900;
            position: relative;
            z-index: 1;
            letter-spacing: -1px;
        }
        
        .cta-section > p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
            opacity: 0.95;
        }
        
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }
        
        .btn-cta {
            padding: 16px 45px;
            border: 2px solid white;
            background: transparent;
            color: white;
            font-weight: 700;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
            display: inline-block;
            font-size: 1.05rem;
            position: relative;
            overflow: hidden;
        }
        
        .btn-cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.2);
            transition: left 0.3s ease;
        }
        
        .btn-cta:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .btn-cta:hover::before {
            left: 100%;
        }
        
        .btn-cta.filled {
            background: white;
            color: var(--primary);
        }
        
        .btn-cta.filled:hover {
            background: transparent;
            color: white;
            transform: translateY(-3px);
        }
        
        /* Footer */
        .footer {
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            color: white;
            padding: 60px 0 20px;
            margin-top: 80px;
            position: relative;
            border-top: 1px solid rgba(31, 111, 235, 0.2);
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(31, 111, 235, 0.5), transparent);
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 50px;
            margin-bottom: 40px;
        }
        
        .footer-section h4 {
            margin-bottom: 25px;
            font-weight: 800;
            color: var(--primary);
            font-size: 1.15rem;
            letter-spacing: 0.5px;
        }
        
        .footer-section p {
            color: #d1d5db;
            line-height: 1.8;
            margin-bottom: 10px;
            font-weight: 300;
        }
        
        .footer-section a {
            color: #d1d5db;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            padding-left: 0;
        }
        
        .footer-section a::before {
            content: '→';
            position: absolute;
            left: -20px;
            opacity: 0;
            transition: all 0.3s ease;
        }
        
        .footer-section a:hover {
            color: var(--primary);
            padding-left: 15px;
        }
        
        .footer-section a:hover::before {
            left: 0;
            opacity: 1;
        }
        
        .footer-divider {
            border-top: 1px solid #374151;
            margin-top: 40px;
            padding-top: 25px;
            text-align: center;
            color: #9ca3af;
            font-weight: 300;
        }
        
        body.dark-mode .footer {
            background: linear-gradient(180deg, #1a1a1a 0%, #0d0d0d 100%);
            border-top-color: rgba(74, 158, 255, 0.2);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero {
                padding: 80px 0;
            }
            
            .hero h1 {
                font-size: 2.5rem;
                font-weight: 800;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .btn-primary-light {
                padding: 12px 30px;
                font-size: 1rem;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
            
            .cta-section {
                padding: 50px 0;
                margin: 50px 0;
            }
            
            .cta-section h2 {
                font-size: 1.8rem;
            }
            
            .btn-cta {
                padding: 12px 30px;
                font-size: 0.95rem;
            }
            
            .stat-number {
                font-size: 2.2rem;
            }
            
            .stat-label {
                font-size: 0.95rem;
            }
        }
        
        @media (max-width: 480px) {
            .hero {
                padding: 60px 0;
            }
            
            .hero h1 {
                font-size: 1.8rem;
            }
            
            .hero p {
                font-size: 1rem;
                margin-bottom: 25px;
            }
            
            .btn-primary-light {
                padding: 10px 25px;
                font-size: 0.95rem;
            }
            
            .section-title h2 {
                font-size: 1.5rem;
            }
            
            .cta-section {
                padding: 40px 0;
            }
            
            .cta-section h2 {
                font-size: 1.5rem;
            }
            
            .btn-cta {
                padding: 10px 25px;
                font-size: 0.9rem;
            }
            
            .stat-number {
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
        
        /* Remove underline from buttons */
        .btn-primary-light {
            text-decoration: none !important;
        }
        
        .nav-link {
            text-decoration: none !important;
        }
        
        .nav-link:hover {
            text-decoration: none !important;
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
                        <a class="nav-link btn-sm btn-warning text-dark fw-bold ms-2" href="<?= base_url('booking') ?>" style="border-radius: 5px;">
                            <i class="fas fa-calendar-check"></i> Pesan Sekarang
                        </a>
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
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="<?= base_url('booking') ?>" class="btn-primary-light" style="background: #ffc107; color: #000; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-calendar-check"></i> Pesan Sekarang
                </a>
                <a href="#available" class="btn-primary-light">Lihat Ketersediaan Unit</a>
            </div>
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
