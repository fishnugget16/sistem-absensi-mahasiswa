<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Absensi Mahasiswa</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts (Material 2 - Roboto) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212;
        }
        
        /* Navbar - Dark Material 2 */
        .material-navbar {
            background: #1e1e1e;
            padding: 12px 24px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            border-bottom: 1px solid #2a2a2a;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            color: #e8eaed !important;
        }
        
        .navbar-brand i {
            margin-right: 10px;
            color: #4caf50;
        }
        
        /* Navbar links - tanpa background aktif, warna sama */
        .nav .nav-link {
            color: #9aa0a6 !important;
            background: transparent !important;
            padding: 8px 16px !important;
            border-radius: 4px;
            transition: all 0.2s;
            font-size: 14px;
            font-weight: 500;
        }
        
        .nav .nav-link:hover {
            color: #e8eaed !important;
            background: rgba(255, 255, 255, 0.05) !important;
        }
        
        .btn-logout {
            background: #dc3545;
            border: none;
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 4px;
            color: white;
            transition: background 0.2s;
        }
        
        .btn-logout:hover {
            background: #c82333;
        }
        
        .user-name {
            color: #e8eaed;
            font-size: 14px;
            font-weight: 400;
        }
        
        .user-name i {
            margin-right: 6px;
            color: #4caf50;
        }
        
        /* Header Panel - Dark */
        .header-panel {
            background: linear-gradient(135deg, #1a2a1a 0%, #1e1e1e 100%);
            padding: 32px 24px;
            margin-bottom: 24px;
            border-bottom: 1px solid #2a2a2a;
        }
        
        .header-panel h2 {
            font-size: 28px;
            font-weight: 500;
            color: #e8eaed;
            margin-bottom: 8px;
        }
        
        .header-panel h2 i {
            color: #4caf50;
            margin-right: 12px;
        }
        
        .header-panel p {
            font-size: 14px;
            color: #9aa0a6;
            margin: 0;
        }
        
        /* Stat Cards - Dark */
        .stat-card {
            background: #1e1e1e;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid #2a2a2a;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            border-color: #4caf50;
        }
        
        .stat-card .icon {
            width: 48px;
            height: 48px;
            background: rgba(76, 175, 80, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }
        
        .stat-card .icon i {
            font-size: 24px;
            color: #4caf50;
        }
        
        .stat-card .value {
            font-size: 28px;
            font-weight: 500;
            color: #e8eaed;
        }
        
        .stat-card .label {
            font-size: 13px;
            color: #9aa0a6;
            margin-top: 4px;
        }
        
        /* Sidebar - Dark */
        .sidebar-menu {
            background: #1e1e1e;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            border: 1px solid #2a2a2a;
        }
        
        .sidebar-menu h3 {
            font-size: 16px;
            font-weight: 500;
            color: #e8eaed;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid #4caf50;
        }
        
        .sidebar-menu h3 i {
            margin-right: 8px;
            color: #4caf50;
        }
        
        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 8px;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: #9aa0a6;
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .sidebar-menu a i {
            width: 20px;
            font-size: 16px;
        }
        
        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #4caf50;
        }
        
        .sidebar-menu a.logout-link {
            color: #ef5350;
        }
        
        .sidebar-menu a.logout-link:hover {
            background: rgba(239, 83, 80, 0.1);
            color: #ef5350;
        }
        
        .sidebar-menu hr {
            border-color: #2a2a2a;
            margin: 12px 0;
        }
        
        /* Content Area - Dark */
        .content-area {
            background: #1e1e1e;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            border: 1px solid #2a2a2a;
        }
        
        .content-area h4 {
            font-size: 20px;
            font-weight: 500;
            color: #e8eaed;
            margin-bottom: 8px;
        }
        
        .content-area h4 i {
            margin-right: 8px;
            color: #4caf50;
        }
        
        .content-area p {
            color: #9aa0a6;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .alert-box {
            background: rgba(76, 175, 80, 0.08);
            border-left: 4px solid #4caf50;
            border-radius: 8px;
            padding: 16px;
            margin-top: 20px;
        }
        
        .alert-box b {
            color: #4caf50;
        }
        
        .alert-box p {
            margin: 8px 0 0 0;
            color: #9aa0a6;
            font-size: 13px;
        }
        
        hr {
            border: 0;
            border-top: 1px solid #2a2a2a;
            margin: 16px 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar-menu, .content-area {
                width: 100%;
                margin-bottom: 16px;
            }
            .stat-card {
                margin-bottom: 16px;
            }
            .material-navbar .nav {
                margin-top: 12px;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar Dark Material 2 -->
    <nav class="material-navbar">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center gap-4 flex-wrap">
                    <a href="<?= BASEURL; ?>/AuthController/dashboard" class="navbar-brand text-decoration-none">
                        <i class="fas fa-graduation-cap"></i> Absensi OOP
                    </a>
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="<?= BASEURL; ?>/AuthController/dashboard" class="nav-link">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= BASEURL; ?>/AdminController/mahasiswa" class="nav-link">
                                <i class="fas fa-users"></i> Kelola Mahasiswa
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="user-name">
                        <i class="fas fa-user-circle"></i> Halo, <b><?= $_SESSION['nama'] ?? $_SESSION['username'] ?? 'Admin'; ?></b>
                    </span>
                    <a href="<?= BASEURL; ?>/AuthController/logout" class="btn btn-logout" onclick="return confirm('Yakin ingin keluar?')">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header Panel -->
    <div class="header-panel">
        <div class="container-fluid">
            <h2><i class="fas fa-tachometer-alt"></i> Sistem Absensi OOP</h2>
            <p>Panel Administrator - Pusat Kendali Manajemen Data Akademik</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid">
        <!-- Statistik Cards -->
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <div class="value"><?= $data['total_mahasiswa'] ?? 0 ?></div>
                    <div class="label">Total Mahasiswa</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-chalkboard-user"></i></div>
                    <div class="value"><?= $data['total_dosen'] ?? 0 ?></div>
                    <div class="label">Total Dosen</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-book"></i></div>
                    <div class="value"><?= $data['total_matkul'] ?? 0 ?></div>
                    <div class="label">Total Mata Kuliah</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="value"><?= $data['total_absensi_hari_ini'] ?? 0 ?></div>
                    <div class="label">Absensi Hari Ini</div>
                </div>
            </div>
        </div>

        <!-- Menu dan Konten -->
        <div class="row g-4 mt-2">
            <!-- Sidebar Menu -->
            <div class="col-md-3">
                <div class="sidebar-menu">
                    <h3><i class="fas fa-bars"></i> Menu Navigasi</h3>
                    <ul>
                        <li><a href="<?= BASEURL; ?>/AdminController/mahasiswa"><i class="fas fa-user-graduate"></i> Kelola Data Mahasiswa</a></li>
                        <li><a href="<?= BASEURL; ?>/AdminController/dosen"><i class="fas fa-chalkboard-user"></i> Kelola Data Dosen</a></li>
                        <li><a href="<?= BASEURL; ?>/AdminController/matakuliah"><i class="fas fa-book-open"></i> Kelola Mata Kuliah</a></li>
                        <li><hr></li>
                        <li><a href="<?= BASEURL; ?>/AuthController/logout" class="logout-link"><i class="fas fa-sign-out-alt"></i> Keluar / Logout</a></li>
                    </ul>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-md-9">
                <div class="content-area">
                    <h4><i class="fas fa-smile-wink"></i> Selamat Datang di Halaman Utama</h4>
                    <hr>
                    <p>Anda masuk sebagai <strong style="color:#4caf50">Administrator</strong> sistem absensi.</p>
                    
                    <div class="alert-box">
                        <b><i class="fas fa-lightbulb"></i> Petunjuk penggunaan:</b>
                        <p>Silakan gunakan menu navigasi di sebelah kiri atau tautan pada navbar atas untuk mengelola data Mahasiswa, Dosen, dan Mata Kuliah.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>