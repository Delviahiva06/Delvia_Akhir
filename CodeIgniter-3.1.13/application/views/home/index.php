<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Sistem Manajemen Kos</h1>
                <p class="lead mb-4">Kelola data penghuni, kamar, dan tagihan kos dengan mudah dan efisien. Aplikasi web yang user-friendly untuk pemilik kos.</p>
                <a href="<?php echo base_url('admin'); ?>" class="btn btn-light btn-lg">
                    <i class="fas fa-user-shield me-2"></i>Masuk ke Admin Panel
                </a>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-home" style="font-size: 200px; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card stat-card text-center">
                    <div class="card-body">
                        <i class="fas fa-bed fa-3x mb-3"></i>
                        <h3 class="card-title"><?php echo $total_kamar; ?></h3>
                        <p class="card-text">Total Kamar</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card stat-card text-center">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <h3 class="card-title"><?php echo $total_penghuni; ?></h3>
                        <p class="card-text">Penghuni Aktif</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card stat-card text-center">
                    <div class="card-body">
                        <i class="fas fa-door-open fa-3x mb-3"></i>
                        <h3 class="card-title"><?php echo $kamar_kosong_count; ?></h3>
                        <p class="card-text">Kamar Kosong</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card stat-card text-center">
                    <div class="card-body">
                        <i class="fas fa-percentage fa-3x mb-3"></i>
                        <h3 class="card-title"><?php echo $total_kamar > 0 ? round(($kamar_terisi / $total_kamar) * 100) : 0; ?>%</h3>
                        <p class="card-text">Tingkat Hunian</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kamar Kosong Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-5">
                    <i class="fas fa-bed me-2"></i>Kamar Kosong Tersedia
                </h2>
            </div>
        </div>
        
        <?php if (empty($kamar_kosong)): ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        Saat ini tidak ada kamar kosong yang tersedia.
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($kamar_kosong as $kamar): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-door-open fa-3x text-success mb-3"></i>
                                <h5 class="card-title">Kamar <?php echo $kamar->nomor; ?></h5>
                                <p class="card-text">
                                    <strong>Harga Sewa:</strong><br>
                                    <span class="text-primary fw-bold">Rp <?php echo number_format($kamar->harga, 0, ',', '.'); ?>/bulan</span>
                                </p>
                                <a href="<?php echo base_url('home/kamar_kosong'); ?>" class="btn btn-primary">
                                    <i class="fas fa-info-circle me-1"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Akan Bayar Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-5">
                    <i class="fas fa-calendar me-2"></i>Penghuni yang Akan Bayar
                </h2>
            </div>
        </div>
        
        <?php if (empty($akan_bayar)): ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success text-center">
                        <i class="fas fa-check-circle me-2"></i>
                        Tidak ada penghuni yang akan bayar dalam 7 hari ke depan.
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Penghuni</th>
                            <th>Nomor Kamar</th>
                            <th>Tanggal Masuk</th>
                            <th>Jatuh Tempo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($akan_bayar as $penghuni): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $penghuni->nama; ?></td>
                                <td><span class="badge bg-primary"><?php echo $penghuni->nomor_kamar; ?></span></td>
                                <td><?php echo date('d/m/Y', strtotime($penghuni->tgl_masuk_kamar)); ?></td>
                                <td>
                                    <?php 
                                    $jatuh_tempo = date('Y-m-d', strtotime($penghuni->tgl_masuk_kamar . ' +1 month'));
                                    echo date('d/m/Y', strtotime($jatuh_tempo));
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Terlambat Bayar Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-5">
                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>Penghuni Terlambat Bayar
                </h2>
            </div>
        </div>
        
        <?php if (empty($terlambat_bayar)): ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success text-center">
                        <i class="fas fa-check-circle me-2"></i>
                        Tidak ada penghuni yang terlambat bayar.
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-warning">
                        <tr>
                            <th>No</th>
                            <th>Nama Penghuni</th>
                            <th>Nomor Kamar</th>
                            <th>Jumlah Tagihan</th>
                            <th>Jatuh Tempo</th>
                            <th>Keterlambatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($terlambat_bayar as $terlambat): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $terlambat->nama_penghuni; ?></td>
                                <td><span class="badge bg-warning text-dark"><?php echo $terlambat->nomor; ?></span></td>
                                <td><strong>Rp <?php echo number_format($terlambat->jml_tagihan, 0, ',', '.'); ?></strong></td>
                                <td><?php echo date('d/m/Y', strtotime($terlambat->tgl_jatuh_tempo)); ?></td>
                                <td>
                                    <?php 
                                    $selisih = date_diff(date_create($terlambat->tgl_jatuh_tempo), date_create(date('Y-m-d')));
                                    echo $selisih->days . ' hari';
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-5">Fitur Utama</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Manajemen Penghuni</h5>
                        <p class="card-text">Kelola data penghuni dengan lengkap termasuk KTP, nomor HP, dan riwayat hunian.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-bed fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Manajemen Kamar</h5>
                        <p class="card-text">Monitor status kamar, harga sewa, dan perpindahan penghuni antar kamar.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-file-invoice fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Sistem Tagihan</h5>
                        <p class="card-text">Generate tagihan otomatis, kelola pembayaran cicil, dan laporan keuangan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 