<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'GO-KOPI' ?></title>
    <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="<?= base_url('public/js/dark-mode.js') ?>"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1f2937;
            background: #f9fafb;
        }

        .navbar {
            background: linear-gradient(135deg, #1f6feb 0%, #1558c5 100%) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .hero {
            background: linear-gradient(135deg, #1f6feb 0%, #1558c5 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .table-primary {
            background: linear-gradient(135deg, #1f6feb 0%, #1558c5 100%);
            color: white;
        }

        .table-primary th {
            color: white;
            border: none;
        }

        /* ============================================
           DARK MODE STYLES - PUBLIC PAGES
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

        body.dark-mode .hero {
            background: linear-gradient(135deg, #1f4a5c 0%, #8b2f5b 100%);
        }

        body.dark-mode .table {
            background: #242424;
            color: #e0e0e0;
        }

        body.dark-mode .table thead th {
            background: linear-gradient(135deg, #1f4a5c 0%, #8b2f5b 100%);
            color: white;
            border-color: #333;
        }

        body.dark-mode .table td,
        body.dark-mode .table th {
            border-color: #333;
            color: #e0e0e0;
        }

        body.dark-mode .table tbody tr:hover {
            background: #2a2a2a;
        }

        body.dark-mode .badge {
            background: #28a745 !important;
        }

        body.dark-mode .card {
            background: #242424;
            border-color: #333;
            color: #e0e0e0;
        }

        body.dark-mode .list-group-item {
            background: #242424;
            border-color: #333;
            color: #e0e0e0;
        }

        body.dark-mode .accordion-button {
            background: #242424;
            color: #e0e0e0;
        }

        body.dark-mode .accordion-button:not(.collapsed) {
            background: #2a2a2a;
            color: #e0e0e0;
        }

        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background: #2a2a2a;
            border-color: #444;
            color: #e0e0e0;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
            background: #2d3a4a;
            border-color: #6366f1;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        body.dark-mode footer {
            background: #1a1a1a;
            color: #b0b0b0;
            border-top: 1px solid #333;
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
