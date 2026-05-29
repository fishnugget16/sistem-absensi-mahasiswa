<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title><?= $data['judul_halaman'] ?? 'Data Mahasiswa' ?> - Admin</title>
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
            padding: 12px 20px;
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

        /* Content Card */
        .content-card {
            background: #1e1e1e;
            border-radius: 12px;
            padding: 24px;
            margin: 24px;
            border: 1px solid #2a2a2a;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-title {
            color: #e8eaed;
            font-size: 20px;
            font-weight: 500;
            margin: 0;
        }

        .page-title i {
            color: #4caf50;
            margin-right: 10px;
        }

        /* Buttons */
        .btn-add {
            background: #4caf50;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            color: white;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover {
            background: #43a047;
            transform: translateY(-1px);
            color: white;
        }

        .btn-edit {
            background: #ff9800;
            border: none;
            padding: 5px 12px;
            border-radius: 4px;
            color: #121212;
            font-size: 12px;
            font-weight: 500;
            margin-right: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-edit:hover {
            background: #fb8c00;
            color: #121212;
        }

        .btn-delete {
            background: #dc3545;
            border: none;
            padding: 5px 12px;
            border-radius: 4px;
            color: white;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-delete:hover {
            background: #c82333;
            color: white;
        }

        .btn-back {
            background: #3c4043;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            color: white;
            font-size: 13px;
            margin-top: 20px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back:hover {
            background: #4a4e54;
            color: white;
        }

        /* Table Responsive */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 8px;
            -webkit-overflow-scrolling: touch;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        .data-table thead tr {
            border-bottom: 2px solid #2a2a2a;
        }

        .data-table th {
            text-align: left;
            padding: 14px 12px;
            color: #4caf50;
            font-weight: 500;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table td {
            padding: 12px 12px;
            color: #e8eaed;
            font-size: 14px;
            border-bottom: 1px solid #2a2a2a;
        }

        .data-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .data-table code {
            background: #2a2a2a;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
            color: #e8eaed;
        }

        /* Alert */
        .alert-success {
            background: #1a2c1a;
            border: 1px solid #4caf50;
            color: #9aef9a;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #2c1a1a;
            border: 1px solid #dc3545;
            color: #ef9a9a;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .navbar-custom {
                padding: 10px 16px;
            }

            .content-card {
                margin: 16px;
                padding: 20px;
            }

            .page-title {
                font-size: 18px;
            }

            .btn-add {
                padding: 6px 16px;
                font-size: 12px;
            }

            .btn-back {
                padding: 6px 16px;
                font-size: 12px;
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
            .content-card {
                margin: 20px;
            }
        }

        @media (min-width: 1400px) {
            .content-card {
                margin: 28px 40px;
                padding: 28px;
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
            <span><?= $_SESSION['nama'] ?? $_SESSION['username'] ?? 'Admin'; ?></span>
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
            <a href="<?= BASEURL; ?>/AuthController/dashboard" class="nav-link">
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/AdminController/mahasiswa" class="nav-link active">
                <i class="fas fa-user-graduate"></i> Kelola Mahasiswa
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/AdminController/dosen" class="nav-link">
                <i class="fas fa-chalkboard-user"></i> Kelola Dosen
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/AdminController/matakuliah" class="nav-link">
                <i class="fas fa-book-open"></i> Kelola Mata Kuliah
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
    <div class="content-card">
        <div class="page-header">
            <h3 class="page-title"><i class="fas fa-users"></i> <?= $data['judul_halaman'] ?></h3>
            <a href="<?= BASEURL; ?>/AdminController/mahasiswaCreate" class="btn-add">
                <i class="fas fa-plus"></i> Tambah Mahasiswa
            </a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert-success"><i class="fas fa-check-circle"></i> <?= $_SESSION['success']; ?></div>
        <?php unset($_SESSION['success']); endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert-danger"><i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); endif; ?>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Angkatan</th>
                        <th>Program Studi</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['mahasiswa'])): ?>
                    <tr class="empty-row">
                        <td colspan="7" class="text-center" style="color: #9aa0a6;">Belum ada data mahasiswa</td>
                    </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($data['mahasiswa'] as $mhs): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><code><?= htmlspecialchars($mhs['nim'] ?? '-'); ?></code></td>
                            <td><?= htmlspecialchars($mhs['nama'] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($mhs['angkatan'] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($mhs['kelas'] ?? '-'); ?></td>
                            <td><?= htmlspecialchars($mhs['email'] ?? '-'); ?></td>
                            <td>
                                <a href="<?= BASEURL; ?>/AdminController/mahasiswaEdit/<?= $mhs['id']; ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?= BASEURL; ?>/AdminController/mahasiswaDelete/<?= $mhs['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="<?= BASEURL; ?>/AuthController/dashboard" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
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

    // Tutup sidebar saat resize ke desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && sideMenu.classList.contains('open')) {
            closeSidebar();
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>