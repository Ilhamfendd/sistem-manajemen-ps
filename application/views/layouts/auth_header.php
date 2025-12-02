<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= $title ?? '' ?> - Sistem Manajemen PS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
      color: #e0e0e0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-wrapper {
      width: 100%;
      padding: 20px;
    }

    .login-container {
      max-width: 450px;
      margin: 0 auto;
      background: linear-gradient(135deg, #242424 0%, #1f1f1f 100%);
      padding: 50px 40px;
      border-radius: 15px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);
      border: 1px solid #333;
      backdrop-filter: blur(10px);
    }

    .login-header {
      text-align: center;
      margin-bottom: 40px;
    }

    .login-header .logo {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, #1f6feb 0%, #1558c5 100%);
      border-radius: 12px;
      margin-bottom: 20px;
      font-size: 30px;
      color: white;
    }

    .login-header h2 {
      font-size: 28px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 10px;
    }

    .login-header p {
      color: #b0b0b0;
      font-size: 14px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #d0d0d0;
      font-weight: 500;
      font-size: 14px;
    }

    .form-group input {
      width: 100%;
      padding: 12px 15px;
      background: #2a2a2a;
      border: 1px solid #444;
      border-radius: 8px;
      color: #e0e0e0;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    .form-group input:focus {
      outline: none;
      border-color: #6366f1;
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
      background: #2d3a4a;
    }

    .form-group input::placeholder {
      color: #888;
    }

    .btn-login {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, #1f6feb 0%, #1558c5 100%);
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .flash {
      margin-bottom: 20px;
      padding: 12px 15px;
      border-radius: 8px;
      border-left: 4px solid;
      font-size: 14px;
      animation: slideIn 0.3s ease;
    }

    .flash.error {
      background: #4a1a1a;
      color: #ff7070;
      border-left-color: #dc3545;
    }

    .flash.success {
      background: #1b4620;
      color: #90ee90;
      border-left-color: #28a745;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-footer {
      text-align: center;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 1px solid #333;
      color: #888;
      font-size: 13px;
    }

    .login-footer p {
      margin-bottom: 10px;
    }

    .login-info {
      background: #2a3a4a;
      border-left: 4px solid #6366f1;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 13px;
      color: #b0b0b0;
    }

    .login-info strong {
      color: #e0e0e0;
    }

    .theme-toggle-login {
      position: fixed;
      top: 20px;
      right: 20px;
      background: #2a2a2a;
      border: 1px solid #444;
      color: #ffc107;
      width: 40px;
      height: 40px;
      border-radius: 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      transition: all 0.3s ease;
      z-index: 1000;
    }

    .theme-toggle-login:hover {
      background: #3a3a3a;
      transform: rotate(20deg);
    }
  </style>
</head>
<body class="dark-mode">
