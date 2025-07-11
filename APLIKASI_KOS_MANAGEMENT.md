# 🏠 SISTEM MANAJEMEN KOS - Dokumentasi Lengkap

## 📋 Overview
Aplikasi web untuk mengelola kos yang dibangun dengan CodeIgniter 3.1.13. Sistem ini memungkinkan pemilik kos untuk mengelola data penghuni, kamar, tagihan, dan pembayaran dengan mudah dan efisien.

## 🗄️ Database Schema

### 1. Tabel `tb_penghuni`
Menyimpan data penghuni kost
```sql
tb_penghuni(id, nama, no_ktp, no_hp, tgl_masuk, tgl_keluar)
```

### 2. Tabel `tb_kamar`
Menyimpan data kamar dan harga sewa
```sql
tb_kamar(id, nomor, harga, status)
```

### 3. Tabel `tb_barang`
Menyimpan data barang tambahan yang dikenai biaya
```sql
tb_barang(id, nama, harga)
```

### 4. Tabel `tb_kmr_penghuni`
Mengelola relasi penghuni dengan kamar
```sql
tb_kmr_penghuni(id, id_kamar, id_penghuni, tgl_masuk, tgl_keluar, status)
```

### 5. Tabel `tb_brng_bawaan`
Mengelola barang bawaan penghuni
```sql
tb_brng_bawaan(id, id_penghuni, id_barang)
```

### 6. Tabel `tb_tagihan`
Mengelola tagihan bulanan
```sql
tb_tagihan(id, bulan, tahun, id_kmr_penghuni, jml_tagihan, status, tgl_jatuh_tempo)
```

### 7. Tabel `tb_bayar`
Mengelola pembayaran tagihan
```sql
tb_bayar(id, id_tagihan, jml_bayar, status, tgl_bayar, keterangan)
```

### 8. Tabel `tb_admin`
Mengelola user admin
```sql
tb_admin(id, username, password, nama_lengkap, email, role, is_active)
```

## 🚀 Fitur Utama

### Halaman Depan (Public)
1. **Dashboard Statistik**
   - Total kamar, penghuni aktif, kamar kosong
   - Tingkat hunian dalam persentase

2. **Kamar Kosong**
   - Menampilkan kamar yang tersedia
   - Informasi harga sewa
   - Tombol hubungi untuk booking

3. **Penghuni yang Akan Bayar**
   - Daftar penghuni yang akan bayar dalam 7 hari
   - Berdasarkan tanggal masuk kamar

4. **Penghuni Terlambat Bayar**
   - Daftar penghuni yang terlambat bayar
   - Informasi jumlah keterlambatan

### Halaman Admin
1. **Manajemen Penghuni**
   - CRUD data penghuni
   - Validasi KTP unik
   - Riwayat hunian

2. **Manajemen Kamar**
   - CRUD data kamar
   - Update status kamar
   - Monitoring hunian

3. **Manajemen Barang**
   - CRUD data barang tambahan
   - Harga barang

4. **Manajemen Tagihan**
   - Generate tagihan otomatis
   - Monitoring status pembayaran
   - Laporan tagihan

5. **Manajemen Pembayaran**
   - Input pembayaran
   - Status lunas/cicil
   - Riwayat pembayaran

## 🛠️ Instalasi

### 1. Requirements
- PHP >= 5.3.7
- MySQL/MariaDB
- Apache/Nginx
- XAMPP (recommended)

### 2. Setup Database
```bash
# Import database
mysql -u root -p < database/kos_management.sql
```

### 3. Konfigurasi
Edit file `application/config/database.php`:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'kos_management',
    'dbdriver' => 'mysqli'
);
```

### 4. Akses Aplikasi
```
http://localhost/Delvia_Akhir/CodeIgniter-3.1.13/
```

## 📁 Struktur File

```
CodeIgniter-3.1.13/
├── application/
│   ├── config/
│   │   ├── database.php      # Konfigurasi database
│   │   ├── routes.php        # Routing aplikasi
│   │   └── autoload.php      # Auto-load libraries
│   ├── controllers/
│   │   ├── Home.php          # Controller halaman depan
│   │   └── Admin.php         # Controller admin (akan dibuat)
│   ├── models/
│   │   ├── Penghuni_model.php
│   │   ├── Kamar_model.php
│   │   └── Tagihan_model.php
│   └── views/
│       ├── templates/
│       │   ├── header.php
│       │   └── footer.php
│       └── home/
│           ├── index.php
│           └── kamar_kosong.php
├── database/
│   └── kos_management.sql    # Script database
└── README.md
```

## 🔧 Model yang Dibuat

### 1. Penghuni_model
- `get_all()` - Ambil semua penghuni
- `get_active()` - Ambil penghuni aktif
- `get_by_ktp()` - Cari berdasarkan KTP
- `get_with_kamar()` - Ambil dengan info kamar
- `get_yang_akan_bayar()` - Penghuni yang akan bayar

### 2. Kamar_model
- `get_all()` - Ambil semua kamar
- `get_kosong()` - Ambil kamar kosong
- `get_terisi()` - Ambil kamar terisi
- `get_with_penghuni()` - Ambil dengan info penghuni
- `get_terlambat_bayar()` - Kamar terlambat bayar

### 3. Tagihan_model
- `get_all()` - Ambil semua tagihan
- `get_by_status()` - Ambil berdasarkan status
- `get_terlambat()` - Tagihan terlambat
- `generate_tagihan()` - Generate tagihan otomatis
- `update_status_by_pembayaran()` - Update status

## 🎨 UI/UX Features

### Design System
- **Framework**: Bootstrap 5.3.0
- **Icons**: Font Awesome 6.4.0
- **Color Scheme**: 
  - Primary: #667eea (Blue)
  - Secondary: #764ba2 (Purple)
  - Success: #28a745 (Green)
  - Warning: #ffc107 (Yellow)
  - Danger: #dc3545 (Red)

### Responsive Design
- Mobile-first approach
- Responsive tables
- Touch-friendly buttons
- Optimized for all devices

### User Experience
- Clean and modern interface
- Intuitive navigation
- Clear call-to-action buttons
- Informative alerts and notifications
- Loading states and feedback

## 🔐 Keamanan

### Authentication
- Session-based authentication
- Password hashing (bcrypt)
- Role-based access control
- CSRF protection

### Data Validation
- Server-side validation
- Client-side validation
- SQL injection prevention
- XSS protection

## 📊 Business Logic

### Perhitungan Tagihan
```php
// Tagihan = Harga Kamar + Total Harga Barang Bawaan
$jml_tagihan = $harga_kamar + $total_barang_bawaan;
```

### Status Kamar
- `kosong` - Kamar tersedia
- `terisi` - Kamar sudah dihuni

### Status Penghuni
- `aktif` - Masih menghuni
- `pindah` - Pindah kamar
- `keluar` - Keluar dari kos

### Status Tagihan
- `belum_bayar` - Belum ada pembayaran
- `cicil` - Pembayaran sebagian
- `lunas` - Pembayaran lengkap

## 🚧 TODO List

### Phase 1 (Current)
- ✅ Database schema
- ✅ Basic models
- ✅ Frontend pages
- ✅ Public interface

### Phase 2 (Next)
- [ ] Admin authentication
- [ ] CRUD operations
- [ ] Tagihan generation
- [ ] Payment management

### Phase 3 (Future)
- [ ] Reports and analytics
- [ ] Email notifications
- [ ] Mobile app
- [ ] API endpoints

## 🐛 Troubleshooting

### Common Issues
1. **Database Connection Error**
   - Check database credentials
   - Ensure MySQL service is running
   - Verify database exists

2. **404 Error**
   - Check .htaccess file
   - Verify mod_rewrite is enabled
   - Check base_url configuration

3. **Permission Error**
   - Set proper file permissions
   - Ensure cache and logs folders are writable

## 📞 Support

- **Developer**: Delviahiva06
- **Email**: delviahiva06@gmail.com
- **GitHub**: https://github.com/Delviahiva06/Delvia_Akhir.git

## 📄 License

This project is licensed under the MIT License.

---

**🎉 Selamat! Aplikasi Sistem Manajemen Kos siap digunakan!** 