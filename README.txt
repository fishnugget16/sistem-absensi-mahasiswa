Aplikasi Absensi Mahasiswa

###############
STRUKTUR FOLDER
###############

sistem-absensi-oop/
│
├── 📁 app/ # Inti aplikasi (semua logika program)
│ │
│ ├── 📁 core/ # Kelas dasar / fondasi aplikasi
│ │ ├── 📄 BaseModel.php # Abstract class: save(), delete()
│ │ ├── 📄 Database.php # Koneksi DB (Singleton pattern)
│ │ ├── 📄 Controller.php # Base controller: render view, redirect
│ │ └── 📄 Router.php # Mengatur URL ke controller
│ │
│ ├── 📁 interfaces/ # Tempat interface / kontrak
│ │ └── 📄 Exportable.php # Interface: exportPDF(), exportCSV()
│ │
│ ├── 📁 models/ # Kelas untuk data dan database
│ │ ├── 📄 User.php # Login, logout, role
│ │ ├── 📄 Dosen.php # NIDN, input absensi, rekap
│ │ ├── 📄 Mahasiswa.php # NIM, lihat absensi, upload surat
│ │ ├── 📄 MataKuliah.php # Kode, nama, sks, semester
│ │ ├── 📄 Absensi.php # Status, tanggal, keterangan
│ │ ├── 📄 RekapAbsensi.php # Generate laporan, export PDF/CSV
│ │ └── 📄 SuratIzin.php # Upload file, path, jenis
│ │
│ ├── 📁 controllers/ # Jembatan user dan model
│ │ ├── 📄 AuthController.php # Login, logout, dashboard
│ │ ├── 📄 AdminController.php # CRUD mahasiswa, dosen, matkul
│ │ ├── 📄 DosenController.php # Input absensi, rekap, search
│ │ ├── 📄 MahasiswaController.php # Lihat absensi, upload surat
│ │ └── 📄 ExportController.php # Export laporan PDF/CSV
│ │
│ └── 📁 views/ # Halaman tampilan (HTML)
│ │
│ ├── 📁 auth/ # Halaman login dan dashboard
│ │ ├── 📄 login.php # Form login
│ │ └── 📄 dashboard.php # Dashboard ringkasan data
│ │
│ ├── 📁 admin/ # Halaman untuk admin
│ │ ├── 📁 mahasiswa/ # CRUD mahasiswa
│ │ │ ├── 📄 index.php # Daftar mahasiswa
│ │ │ ├── 📄 create.php # Form tambah mahasiswa
│ │ │ └── 📄 edit.php # Form edit mahasiswa
│ │ │
│ │ ├── 📁 dosen/ # CRUD dosen
│ │ │ ├── 📄 index.php # Daftar dosen
│ │ │ ├── 📄 create.php # Form tambah dosen
│ │ │ └── 📄 edit.php # Form edit dosen
│ │ │
│ │ └── 📁 matakuliah/ # CRUD mata kuliah
│ │ ├── 📄 index.php # Daftar mata kuliah
│ │ ├── 📄 create.php # Form tambah matkul
│ │ └── 📄 edit.php # Form edit matkul
│ │
│ ├── 📁 dosen/ # Halaman untuk dosen
│ │ └── 📁 absensi/ # Manajemen absensi
│ │ ├── 📄 input.php # Form input absensi
│ │ ├── 📄 rekap.php # Tampilan rekap absensi
│ │ └── 📄 search.php # Form search dan filter
│ │
│ └── 📁 mahasiswa/ # Halaman untuk mahasiswa
│ ├── 📁 absensi/ # Lihat absensi sendiri
│ │ └── 📄 lihat.php # Daftar absensi pribadi
│ └── 📁 surat/ # Upload surat izin
│ └── 📄 upload.php # Form upload file
│
├── 📁 config/ # Folder konfigurasi
│ ├── 📄 database.php # Konfigurasi DB (host, user, pass, nama)
│ └── 📄 config.php # Konfigurasi umum (base_url, timezone)
│
├── 📁 public/ # Folder akses publik (entry point)
│ ├── 📄 index.php # File pertama dijalankan (inisialisasi)
│ ├── 📄 .htaccess # Atur ulang URL (bersihkan index.php)
│ ├── 📁 css/ # File stylesheet
│ │ └── 📄 style.css # Tampilan (Bootstrap/custom)
│ ├── 📁 js/ # File JavaScript
│ │ └── 📄 script.js # Validasi form, konfirmasi hapus
│ └── 📁 uploads/ # Tempat file upload
│ └── 📁 surat/ # Folder khusus surat izin
│
├── 📁 sql/ # Folder database
│ └── 📄 database.sql # Perintah SQL (tabel + contoh data)
│
├── 📄 .gitignore # Daftar file yang TIDAK ke GitHub
├── 📄 README.md # Dokumentasi proyek
└── 📄 .env # Variabel rahasia (JANGAN upload)
