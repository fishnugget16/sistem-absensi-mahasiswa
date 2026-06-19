# Sistem Absensi Mahasiswa

Sistem informasi manajemen absensi mahasiswa berbasis web yang dibangun dengan **PHP OOP (Object Oriented Programming)** dan arsitektur **MVC (Model-View-Controller)**. Sistem ini memungkinkan tiga peran pengguna (Admin, Dosen, Mahasiswa) untuk mengelola data akademik dan absensi secara terintegrasi.

## Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Struktur Database](#struktur-database)
- [Konsep OOP yang Diimplementasikan](#konsep-oop-yang-diimplementasikan)
- [Instalasi](#cara-instalasi)

## Fitur Utama

### 👑 Admin
- Login dan Logout
- Kelola Data Mahasiswa (CRUD)
- Kelola Data Dosen (CRUD)
- Kelola Data Mata Kuliah (CRUD)
- Kelola Surat Izin (setujui/tolak)
- Dashboard dengan statistik (Total Mahasiswa, Dosen, Mata Kuliah, Absensi Hari Ini)

### 👨‍🏫 Dosen
- Login dan Logout
- Input Rekap Absensi Mahasiswa
- Lihat Rekap Absensi
- Search & Filter Absensi
- Export Laporan ke PDF

### 👨‍🎓 Mahasiswa
- Login dan Logout
- Lihat Riwayat Absensi dan Histori Surat Izin(tabel + rekap per mata kuliah)
- Upload Surat Izin (file PDF, JPG, PNG)

## Teknologi yang Digunakan

| Teknologi | Keterangan |
|-----------|------------|
| PHP 8.x | Bahasa pemrograman backend (OOP) |
| MySQL | Database |
| Bootstrap 5 | Framework CSS (responsif) |
| Font Awesome | Ikon-ikon |
| JavaScript (Vanilla) | Interaksi frontend (custom select, confirm dialog, drag & drop upload) |
| DomPDF | Export laporan PDF (fitur dosen) |

## Struktur Database

| Tabel | Keterangan |
|-------|-------------|
| users | Data login (email, password, role) |
| mahasiswa | Data mahasiswa (NIM, nama, program studi, angkatan) |
| dosen | Data dosen (NIDN, nama, prodi) |
| mata_kuliah | Data mata kuliah (kode, nama, SKS, semester, jumlah pertemuan) |
| absensi | Data absensi (mahasiswa, mata kuliah, tanggal, status) |
| surat_izin | Data surat izin (file path, status, keterangan) |

## Konsep OOP yang Diimplementasikan

| Konsep | Implementasi |
|--------|--------------|
| Abstract Class | `BaseModel` dengan method `save()`, `delete()`, `validate()` |
| Interface | `Exportable` untuk export PDF/CSV |
| Inheritance | `User` sebagai parent, `Dosen` dan `Mahasiswa` sebagai child |
| Encapsulation | Semua properti `private` / `protected`, diakses via getter/setter |
| Polymorphism | Method `validate()` di setiap model |
| Singleton | Class `Database` dengan method `getInstance()` |
| Namespace | (Opsional, bisa ditambahkan) |

## Cara Instalasi

### 1. Persiapan
Pastikan Anda memiliki **XAMPP** atau **Laragon** terinstal di komputer Anda.

### 2. Copy Project
Copy folder `aplikasi-absensi-mahasiswa` ke dalam folder `htdocs` (XAMPP) atau `www` (Laragon).

### 3. Import Database
- Buka **phpMyAdmin** 'http://localhost/phpmyadmin'
- Buat database baru dengan nama `absensi_oop`
- Pilih tab **Import**
- Pilih file `sql/database.sql` dari folder proyek
- Klik **Go** / **Execute**

### 4. Konfigurasi
Buka file `config/config.php` dan sesuaikan dengan setting server Anda:

```php
<?php
define('BASEURL', 'http://localhost/aplikasi-absensi-mahasiswa/public');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'absensi_oop');
```

### 5. Jalankan Aplikasi
Akses URL ini dibrowser 'http://localhost/aplikasi-absensi-mahasiswa/public'