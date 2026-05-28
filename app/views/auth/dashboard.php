<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Sistem Absensi</title>
    <style>
        /* CSS INTERNAL MANDIRI - JALAN TANPA INTERNET / TANPA FILE LUAR */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        
        /* Desain Navbar Atas Meniru Bootstrap Dark */
        .custom-navbar { background-color: #212529; padding: 12px 30px; display: flex; justify-content: space-between; align-items: center; color: white; }
        .navbar-brand { font-size: 20px; font-weight: bold; color: white; text-decoration: none; }
        .nav-links { display: flex; gap: 20px; list-style: none; margin: 0; padding: 0; align-items: center; }
        .nav-links a { color: rgba(255,255,255,0.75); text-decoration: none; font-size: 15px; }
        .nav-links a:hover, .nav-links a.active { color: white; }
        .btn-logout { background-color: #dc3545; color: white !important; padding: 6px 12px; border-radius: 4px; font-size: 14px; font-weight: bold; text-decoration: none; border: none; cursor: pointer; }
        .btn-logout:hover { background-color: #bb2d3b; }

        /* Desain Tata Letak Halaman */
        .header-panel { background: #333; color: white; padding: 25px; text-align: center; margin-bottom: 25px; }
        .main-container { display: flex; max-width: 1200px; margin: 0 auto; gap: 20px; padding: 0 20px; box-sizing: border-box;}
        .sidebar-menu { width: 25%; background: white; padding: 20px; border: 1px solid #ddd; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .content-area { width: 75%; background: white; padding: 25px; border: 1px solid #ddd; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        
        /* Desain Menu Samping */
        .sidebar-menu h3 { margin-top: 0; color: #333; font-size: 18px; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .sidebar-menu ul { padding: 0; list-style: none; }
        .sidebar-menu li { margin-bottom: 12px; }
        .sidebar-menu a { color: #0d6efd; text-decoration: none; display: block; padding: 8px; border-radius: 4px; }
        .sidebar-menu a:hover { background-color: #f8f9fa; text-decoration: underline; }
        
        .alert-box { background-color: #cff4fc; color: #055160; border: 1px solid #b6effb; padding: 15px; border-radius: 4px; margin-top: 15px; }
    </style>
</head>
<body>

    <!-- NAVBAR ATAS REKAYASA (Tampilan rapi mirip bootstrap tanpa perlu load library luar) -->
    <div class="custom-navbar">
        <div style="display: flex; align-items: center; gap: 30px;">
            <a href="<?= BASEURL; ?>/AuthController/dashboard" class="navbar-brand">Absensi OOP</a>
            <ul class="nav-links">
                <li><a href="<?= BASEURL; ?>/AuthController/dashboard" class="active">Home</a></li>
                <li><a href="<?= BASEURL; ?>/AdminController/mahasiswa">Kelola Data Mahasiswa</a></li>
            </ul>
        </div>
        <div style="display: flex; align-items: center; gap: 15px;">
            <span>Halo, <b><?= isset($_SESSION['username']) ? $_SESSION['username'] : 'Admin'; ?></b> 👋</span>
            <a href="<?= BASEURL; ?>/AuthController/logout" class="btn-logout" onclick="return confirm('Yakin ingin keluar?')">Logout</a>
        </div>
    </div>

    <!-- Header Panel Judul -->
    <div class="header-panel">
        <h2 style="margin: 0 0 5px 0;">Sistem Absensi OOP - Panel Admin</h2>
        <p style="margin: 0; color: #ccc;">Pusat Kendali Administrasi Data Akademik</p>
    </div>

    <!-- Konten Utama Kiri & Kanan -->
    <div class="main-container">
        
        <!-- Sisi Kiri: Menu -->
        <div class="sidebar-menu">
            <h3>Menu Navigasi</h3>
            <!-- Ganti link navigasi Anda menjadi seperti ini -->
            <ul>
                <li><a href="<?= BASEURL; ?>/AdminController/mahasiswa">👨‍🎓 Kelola Data Mahasiswa (CRUD)</a></li>
                <li><a href="<?= BASEURL; ?>/AdminController/dosen">👨‍🏫 Kelola Data Dosen</a></li>
                <li><a href="<?= BASEURL; ?>/AdminController/matakuliah">📚 Kelola Mata Kuliah</a></li>
                <li><a href="<?= BASEURL; ?>/AuthController/logout" style="color: #dc3545;">🚪 Keluar / Logout</a></li>
            </ul>
        </div>

        <!-- Sisi Kanan: Isi Konten -->
        <div class="content-area">
            <h4 style="margin-top: 0; font-size: 20px;">Selamat Datang di Halaman Utama</h4>
            <hr style="border: 0; border-top: 1px solid #eee;">
            <p>Anda masuk sebagai administrator sistem absensi. Seluruh menu kontrol data mahasiswa tingkat 2 telah dikonfigurasi dengan aman.</p>
            
            <div class="alert-box">
                <b>Petunjuk penggunaan:</b> Silakan gunakan menu navigasi di sisi kiri atau link di barisan navbar atas untuk memanipulasi data Mahasiswa.
            </div>
        </div>

    </div>

</body>
</html>
