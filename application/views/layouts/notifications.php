<?php
// Flash Notifications
if ($this->session->flashdata('success')): ?>
    <div data-flash-success="<?= htmlspecialchars($this->session->flashdata('success')) ?>" data-flash-title="Berhasil"></div>
<?php endif;

if ($this->session->flashdata('error')): ?>
    <div data-flash-error="<?= htmlspecialchars($this->session->flashdata('error')) ?>" data-flash-title="Terjadi Kesalahan"></div>
<?php endif;

if ($this->session->flashdata('warning')): ?>
    <div data-flash-warning="<?= htmlspecialchars($this->session->flashdata('warning')) ?>" data-flash-title="Perhatian"></div>
<?php endif;

if ($this->session->flashdata('info')): ?>
    <div data-flash-info="<?= htmlspecialchars($this->session->flashdata('info')) ?>" data-flash-title="Informasi"></div>
<?php endif;

if (validation_errors()): ?>
    <div data-flash-error="<?= htmlspecialchars(strip_tags(validation_errors())) ?>" data-flash-title="Validasi Gagal"></div>
<?php endif;
?>
