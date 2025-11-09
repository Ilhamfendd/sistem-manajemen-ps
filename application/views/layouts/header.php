<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?= isset($title)?$title.' | ':'' ?>Sistem Manajemen PS</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('public/css/style.css') ?>">
</head>
<body>
<div class="container">
  <?php if ($msg = $this->session->flashdata('success')): ?>
    <div class="flash success"><?= $msg ?></div>
  <?php endif; ?>
  <?php if ($msg = $this->session->flashdata('error')): ?>
    <div class="flash error"><?= $msg ?></div>
  <?php endif; ?>
