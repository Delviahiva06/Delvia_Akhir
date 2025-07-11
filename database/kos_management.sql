-- Database: kos_management
-- Aplikasi Web untuk Mengelola Kos
-- Created by: Delviahiva06

-- Buat database
CREATE DATABASE IF NOT EXISTS kos_management;
USE kos_management;

-- 1. Tabel Penghuni Kost
CREATE TABLE tb_penghuni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    no_ktp VARCHAR(16) UNIQUE NOT NULL,
    no_hp VARCHAR(15) NOT NULL,
    tgl_masuk DATE NOT NULL,
    tgl_keluar DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Tabel Kamar
CREATE TABLE tb_kamar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor VARCHAR(10) UNIQUE NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    status ENUM('kosong', 'terisi') DEFAULT 'kosong',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 3. Tabel Barang (Biaya Tambahan)
CREATE TABLE tb_barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 4. Tabel Kamar Penghuni (Relasi Many-to-Many)
CREATE TABLE tb_kmr_penghuni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_kamar INT NOT NULL,
    id_penghuni INT NOT NULL,
    tgl_masuk DATE NOT NULL,
    tgl_keluar DATE NULL,
    status ENUM('aktif', 'pindah', 'keluar') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kamar) REFERENCES tb_kamar(id) ON DELETE CASCADE,
    FOREIGN KEY (id_penghuni) REFERENCES tb_penghuni(id) ON DELETE CASCADE
);

-- 5. Tabel Barang Bawaan Penghuni
CREATE TABLE tb_brng_bawaan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_penghuni INT NOT NULL,
    id_barang INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_penghuni) REFERENCES tb_penghuni(id) ON DELETE CASCADE,
    FOREIGN KEY (id_barang) REFERENCES tb_barang(id) ON DELETE CASCADE
);

-- 6. Tabel Tagihan
CREATE TABLE tb_tagihan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bulan INT NOT NULL, -- 1-12
    tahun INT NOT NULL,
    id_kmr_penghuni INT NOT NULL,
    jml_tagihan DECIMAL(10,2) NOT NULL,
    status ENUM('belum_bayar', 'cicil', 'lunas') DEFAULT 'belum_bayar',
    tgl_jatuh_tempo DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kmr_penghuni) REFERENCES tb_kmr_penghuni(id) ON DELETE CASCADE
);

-- 7. Tabel Pembayaran
CREATE TABLE tb_bayar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_tagihan INT NOT NULL,
    jml_bayar DECIMAL(10,2) NOT NULL,
    status ENUM('lunas', 'cicil') DEFAULT 'cicil',
    tgl_bayar DATE NOT NULL,
    keterangan TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tagihan) REFERENCES tb_tagihan(id) ON DELETE CASCADE
);

-- 8. Tabel Admin/User
CREATE TABLE tb_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('admin', 'operator') DEFAULT 'operator',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert data awal
-- Admin default
INSERT INTO tb_admin (username, password, nama_lengkap, email, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@kos.com', 'admin');

-- Sample kamar
INSERT INTO tb_kamar (nomor, harga) VALUES
('A1', 800000),
('A2', 800000),
('A3', 850000),
('B1', 900000),
('B2', 900000),
('B3', 950000),
('C1', 1000000),
('C2', 1000000);

-- Sample barang tambahan
INSERT INTO tb_barang (nama, harga) VALUES
('AC', 200000),
('Kipas Angin', 50000),
('TV', 100000),
('Kulkas', 150000),
('WiFi', 75000),
('Kamar Mandi Dalam', 100000);

-- Index untuk optimasi query
CREATE INDEX idx_penghuni_aktif ON tb_penghuni(tgl_keluar) WHERE tgl_keluar IS NULL;
CREATE INDEX idx_kamar_status ON tb_kamar(status);
CREATE INDEX idx_kmr_penghuni_aktif ON tb_kmr_penghuni(status, tgl_keluar);
CREATE INDEX idx_tagihan_status ON tb_tagihan(status, bulan, tahun);
CREATE INDEX idx_bayar_tgl ON tb_bayar(tgl_bayar); 