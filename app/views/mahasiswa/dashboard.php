<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Dashboard Mahasiswa - Sistem Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            overflow-x: hidden;
        }

        /* ========== NAVBAR ========== */
        .navbar-custom {
            background: #1e1e1e;
            padding: 12px 24px;
            border-bottom: 1px solid #2a2a2a;
            position: sticky;
            top: 0;
            z-index: 1001;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .navbar-brand {
            font-size: 18px;
            font-weight: 500;
            color: #e8eaed;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand i {
            color: #4caf50;
            font-size: 20px;
        }

        .toggle-btn {
            background: transparent;
            border: none;
            color: #e8eaed;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info {
            color: #9aa0a6;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-info i {
            color: #4caf50;
            font-size: 16px;
        }

        .logout-link {
            color: #dc3545 !important;
            font-size: 14px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .logout-link:hover {
            color: #ef5350 !important;
        }

        /* ========== OVERLAY SIDEBAR ========== */
        .side-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100%;
            background: #1e1e1e;
            border-right: 1px solid #2a2a2a;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1050;
            overflow-y: auto;
        }

        .side-menu-overlay.open {
            transform: translateX(0);
        }

        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1040;
            display: none;
        }

        .sidebar-backdrop.show {
            display: block;
        }

        .side-menu-overlay .nav-menu {
            list-style: none;
            padding: 20px 16px;
            margin-top: 60px;
        }

        .side-menu-overlay .nav-item {
            margin-bottom: 8px;
        }

        .side-menu-overlay .nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: #9aa0a6;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .side-menu-overlay .nav-link i {
            width: 22px;
            font-size: 16px;
        }

        .side-menu-overlay .nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #e8eaed;
        }

        .side-menu-overlay .nav-link.active {
            background: rgba(76, 175, 80, 0.15);
            color: #4caf50;
        }

        .side-menu-overlay .nav-link.logout {
            color: #ef5350;
            margin-top: 30px;
        }

        .side-menu-overlay .nav-link.logout:hover {
            background: rgba(239, 83, 80, 0.1);
            color: #ef5350;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            width: 100%;
            min-height: calc(100vh - 60px);
        }

        /* Header Panel */
        .header-panel {
            background: linear-gradient(135deg, #1a2a1a 0%, #1e1e1e 100%);
            padding: 28px 32px;
            margin-bottom: 28px;
            border-bottom: 1px solid #2a2a2a;
        }

        .header-title {
            margin-bottom: 24px;
        }

        .header-title h2 {
            font-size: 24px;
            font-weight: 500;
            color: #e8eaed;
            margin-bottom: 6px;
        }

        .header-title h2 i {
            color: #4caf50;
            margin-right: 10px;
        }

        .header-title p {
            font-size: 13px;
            color: #9aa0a6;
            margin: 0;
        }

        /* Stat Cards - CSS Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 18px 20px;
            border: 1px solid #2a2a2a;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-card:hover {
            border-color: #4caf50;
            transform: translateY(-2px);
        }

        .stat-card .icon {
            width: 52px;
            height: 52px;
            background: rgba(76, 175, 80, 0.12);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-card .icon i {
            font-size: 26px;
            color: #4caf50;
        }

        .stat-card .info {
            flex: 1;
        }

        .stat-card .value {
            font-size: 26px;
            font-weight: 600;
            color: #e8eaed;
            line-height: 1.2;
        }

        .stat-card .label {
            font-size: 12px;
            color: #9aa0a6;
            margin-top: 4px;
        }

        /* Profile Card - Responsif Lebar */
        .profile-card {
            background: #1e1e1e;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #2a2a2a;
            width: 100%;
        }

        .profile-card h4 {
            color: #e8eaed;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #2a2a2a;
        }

        .profile-card h4 i {
            color: #4caf50;
            margin-right: 10px;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .profile-info {
            margin-bottom: 0;
        }

        .profile-info label {
            color: #9aa0a6;
            font-size: 11px;
            display: block;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-info .value {
            color: #e8eaed;
            font-size: 15px;
            font-weight: 500;
            word-break: break-word;
        }

        /* Main Container */
        .main-container {
            padding: 0 32px 40px 32px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 992px) {
            .stats-grid {
                gap: 16px;
            }
            .stat-card {
                padding: 14px 16px;
            }
            .stat-card .icon {
                width: 44px;
                height: 44px;
            }
            .stat-card .icon i {
                font-size: 22px;
            }
            .stat-card .value {
                font-size: 22px;
            }
            .profile-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
        }

        @media (max-width: 768px) {
            .navbar-custom {
                padding: 10px 16px;
            }
            .header-panel {
                padding: 20px 20px;
            }
            .main-container {
                padding: 0 20px 30px 20px;
            }
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .stat-card {
                padding: 12px 16px;
            }
            .profile-card {
                padding: 18px;
            }
            .profile-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .user-info span {
                display: none;
            }
            .logout-link span {
                display: none;
            }
            .navbar-brand span {
                display: none;
            }
        }

        @media (min-width: 769px) and (max-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .stat-card .value {
                font-size: 20px;
            }
        }

        @media (min-width: 1400px) {
            .stat-card .icon {
                width: 58px;
                height: 58px;
            }
            .stat-card .icon i {
                font-size: 28px;
            }
            .stat-card .value {
                font-size: 28px;
            }
            .profile-info .value {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar-custom">
    <div class="navbar-left">
        <button class="toggle-btn" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>
        <a href="#" class="navbar-brand" id="brandToggle">
            <i class="fas fa-graduation-cap"></i>
            <span>Absensi OOP</span>
        </a>
    </div>
    <div class="navbar-right">
        <span class="user-info">
            <i class="fas fa-user-circle"></i>
            <span><?= htmlspecialchars($data['nama'] ?? 'Mahasiswa'); ?></span>
        </span>
        <a href="<?= BASEURL; ?>/AuthController/logout" class="logout-link" onclick="return confirm('Yakin ingin keluar?')">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<!-- Overlay Sidebar -->
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<div class="side-menu-overlay" id="sideMenuOverlay">
    <ul class="nav-menu">
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/MahasiswaController/index" class="nav-link active">
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/MahasiswaController/absensi" class="nav-link">
                <i class="fas fa-calendar-alt"></i> Lihat Absensi
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/MahasiswaController/uploadSurat" class="nav-link">
                <i class="fas fa-upload"></i> Upload Surat Izin
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/AuthController/logout" class="nav-link logout" onclick="return confirm('Yakin ingin keluar?')">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Header Panel -->
    <div class="header-panel">
        <div class="header-title">
            <h2><i class="fas fa-user-graduate"></i> Dashboard Mahasiswa</h2>
            <p>Selamat datang di portal absensi mahasiswa</p>
        </div>

        <!-- Stat Cards - Grid System -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon"><i class="fas fa-calendar-check"></i></div>
                <div class="info">
                    <div class="value">0</div>
                    <div class="label">Total Kehadiran</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="icon"><i class="fas fa-chart-line"></i></div>
                <div class="info">
                    <div class="value">0%</div>
                    <div class="label">Persentase Kehadiran</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="icon"><i class="fas fa-file-alt"></i></div>
                <div class="info">
                    <div class="value">0</div>
                    <div class="label">Surat Izin Terkirim</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <div class="profile-card">
            <h4><i class="fas fa-id-card"></i> Profil Saya</h4>
            <div class="profile-grid">
                <div class="profile-info">
                    <label>Nama Lengkap</label>
                    <div class="value"><?= htmlspecialchars($data['nama'] ?? '-'); ?></div>
                </div>
                <div class="profile-info">
                    <label>NIM</label>
                    <div class="value"><?= htmlspecialchars($data['nim'] ?? '-'); ?></div>
                </div>
                <div class="profile-info">
                    <label>Email</label>
                    <div class="value"><?= htmlspecialchars($data['email'] ?? '-'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const brandToggle = document.getElementById('brandToggle');
    const sideMenu = document.getElementById('sideMenuOverlay');
    const backdrop = document.getElementById('sidebarBackdrop');

    function openSidebar() {
        sideMenu.classList.add('open');
        backdrop.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sideMenu.classList.remove('open');
        backdrop.classList.remove('show');
        document.body.style.overflow = '';
    }

    function toggleSidebar() {
        if (sideMenu.classList.contains('open')) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }

    toggleBtn.addEventListener('click', toggleSidebar);
    brandToggle.addEventListener('click', toggleSidebar);
    backdrop.addEventListener('click', closeSidebar);
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>