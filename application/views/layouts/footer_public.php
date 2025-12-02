
    <!-- Footer -->
    <footer class="bg-dark text-light mt-5 py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-gamepad"></i> GO-KOPI
                    </h6>
                    <p class="text-muted small">Sistem manajemen penyewaan PS modern dengan fitur lengkap untuk bisnis rental gaming Anda.</p>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3">Navigasi</h6>
                    <ul class="list-unstyled small">
                        <li><a href="<?= base_url() ?>" class="text-decoration-none text-muted">Home</a></li>
                        <li><a href="<?= base_url('pricing') ?>" class="text-decoration-none text-muted">Pricing</a></li>
                        <li><a href="<?= base_url('faq') ?>" class="text-decoration-none text-muted">FAQ</a></li>
                        <li><a href="<?= base_url('contact') ?>" class="text-decoration-none text-muted">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3">Hubungi Kami</h6>
                    <p class="text-muted small">
                        <i class="fas fa-phone"></i> +62 812 3456 7890<br>
                        <i class="fas fa-envelope"></i> info@gokopi.com<br>
                        <i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia
                    </p>
                </div>
            </div>
            <div class="text-center pt-3 border-top border-dark">
                <p class="text-muted small mb-0">&copy; 2025 GO-KOPI. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
