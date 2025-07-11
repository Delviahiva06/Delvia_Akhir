<!-- Page Header -->
<div class="container-fluid bg-primary text-white py-4">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-0">
                    <i class="fas fa-bed me-2"></i>Kamar Kosong Tersedia
                </h1>
                <p class="mb-0">Daftar kamar yang tersedia untuk disewa</p>
            </div>
        </div>
    </div>
</div>

<!-- Content -->
<div class="container py-5">
    <?php if (empty($kamar_kosong)): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <h4>Maaf, Saat Ini Tidak Ada Kamar Kosong</h4>
                    <p class="mb-0">Semua kamar sudah terisi. Silakan cek kembali nanti atau hubungi admin untuk informasi lebih lanjut.</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-12 mb-4">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    Tersedia <strong><?php echo count($kamar_kosong); ?> kamar</strong> untuk disewa
                </div>
            </div>
        </div>
        
        <div class="row">
            <?php foreach ($kamar_kosong as $kamar): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-door-open fa-4x text-success"></i>
                            </div>
                            <h4 class="card-title text-primary">Kamar <?php echo $kamar->nomor; ?></h4>
                            <div class="mb-3">
                                <span class="badge bg-success fs-6">Tersedia</span>
                            </div>
                            <div class="mb-3">
                                <h5 class="text-success mb-0">
                                    Rp <?php echo number_format($kamar->harga, 0, ',', '.'); ?>
                                </h5>
                                <small class="text-muted">per bulan</small>
                            </div>
                            <hr>
                            <div class="row text-start">
                                <div class="col-6">
                                    <small class="text-muted">Status:</small><br>
                                    <span class="badge bg-success">Kosong</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Harga:</small><br>
                                    <strong>Rp <?php echo number_format($kamar->harga, 0, ',', '.'); ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center">
                            <button class="btn btn-primary btn-sm" onclick="showKamarDetail('<?php echo $kamar->nomor; ?>', '<?php echo number_format($kamar->harga, 0, ',', '.'); ?>')">
                                <i class="fas fa-info-circle me-1"></i>Lihat Detail
                            </button>
                            <a href="tel:+6281234567890" class="btn btn-success btn-sm">
                                <i class="fas fa-phone me-1"></i>Hubungi
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Summary -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Ringkasan Kamar Kosong
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <h4 class="text-primary"><?php echo count($kamar_kosong); ?></h4>
                                <p class="text-muted mb-0">Total Kamar Kosong</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <h4 class="text-success">
                                    Rp <?php 
                                    $total_harga = 0;
                                    foreach ($kamar_kosong as $kamar) {
                                        $total_harga += $kamar->harga;
                                    }
                                    echo number_format($total_harga, 0, ',', '.');
                                    ?>
                                </h4>
                                <p class="text-muted mb-0">Total Nilai Sewa</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <h4 class="text-info">
                                    Rp <?php echo $total_harga > 0 ? number_format($total_harga / count($kamar_kosong), 0, ',', '.') : 0; ?>
                                </h4>
                                <p class="text-muted mb-0">Rata-rata Harga</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <h4 class="text-warning">100%</h4>
                                <p class="text-muted mb-0">Tingkat Ketersediaan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Detail Kamar -->
<div class="modal fade" id="kamarDetailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kamar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-door-open fa-3x text-success"></i>
                </div>
                <div class="row">
                    <div class="col-6">
                        <strong>Nomor Kamar:</strong>
                        <p id="modalNomorKamar"></p>
                    </div>
                    <div class="col-6">
                        <strong>Harga Sewa:</strong>
                        <p id="modalHargaKamar"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <strong>Status:</strong>
                        <p><span class="badge bg-success">Kosong</span></p>
                    </div>
                    <div class="col-6">
                        <strong>Fasilitas:</strong>
                        <p>Kamar mandi dalam, WiFi, Listrik</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="tel:+6281234567890" class="btn btn-primary">
                    <i class="fas fa-phone me-1"></i>Hubungi Sekarang
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function showKamarDetail(nomor, harga) {
    document.getElementById('modalNomorKamar').textContent = nomor;
    document.getElementById('modalHargaKamar').textContent = 'Rp ' + harga + '/bulan';
    new bootstrap.Modal(document.getElementById('kamarDetailModal')).show();
}
</script> 