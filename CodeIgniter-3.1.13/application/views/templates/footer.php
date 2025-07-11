    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-home me-2"></i>Sistem Manajemen Kos</h5>
                    <p class="mb-0">Aplikasi web untuk mengelola data penghuni, kamar, dan tagihan kos dengan mudah dan efisien.</p>
                </div>
                <div class="col-md-3">
                    <h6>Fitur Utama</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-users me-2"></i>Manajemen Penghuni</li>
                        <li><i class="fas fa-bed me-2"></i>Manajemen Kamar</li>
                        <li><i class="fas fa-file-invoice me-2"></i>Sistem Tagihan</li>
                        <li><i class="fas fa-chart-bar me-2"></i>Laporan Keuangan</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Kontak</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone me-2"></i>+62 812-3456-7890</li>
                        <li><i class="fas fa-envelope me-2"></i>info@kos.com</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i>Jl. Contoh No. 123</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> Sistem Manajemen Kos. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="mb-0">Developed by <strong>Delviahiva06</strong></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JS -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Confirm delete
        function confirmDelete(url, message = 'Apakah Anda yakin ingin menghapus data ini?') {
            if (confirm(message)) {
                window.location.href = url;
            }
        }

        // Format currency
        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(amount);
        }

        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
    </script>
</body>
</html> 