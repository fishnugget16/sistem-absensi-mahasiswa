<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Edit Mata Kuliah - Admin</title>
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

        .content-card h3 {
            color: #e8eaed;
            font-size: 22px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .content-card h3 i {
            color: #4caf50;
            margin-right: 10px;
        }

        hr {
            border-color: #2a2a2a;
            margin: 16px 0 24px 0;
        }

        /* Form */
        .form-label {
            color: #e8eaed;
            font-weight: 500;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            background: #2a2a2a;
            border: 1px solid #3c4043;
            color: #e8eaed;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            background: #2a2a2a;
            border-color: #4caf50;
            color: #e8eaed;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
            outline: none;
        }

        /* Buttons */
        .btn-update {
            background: #ff9800;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            color: #121212;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-update:hover {
            background: #fb8c00;
            transform: translateY(-1px);
        }

        .btn-cancel {
            background: #3c4043;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background: #4a4e54;
            color: white;
        }

        /* Alert */
        .alert-danger {
            background: #2c1a1a;
            border: 1px solid #dc3545;
            color: #ef9a9a;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
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

            .content-card h3 {
                font-size: 20px;
            }

            .form-label {
                font-size: 12px;
            }

            .form-control, .form-select {
                padding: 8px 12px;
                font-size: 13px;
            }

            .btn-update, .btn-cancel {
                padding: 8px 20px;
                font-size: 13px;
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
                padding: 32px;
            }

            .form-control, .form-select {
                padding: 12px 16px;
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
            <span><?= $_SESSION['nama'] ?? 'Admin'; ?></span>
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
            <a href="<?= BASEURL; ?>/AdminController/mahasiswa" class="nav-link">
                <i class="fas fa-user-graduate"></i> Kelola Mahasiswa
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/AdminController/dosen" class="nav-link">
                <i class="fas fa-chalkboard-user"></i> Kelola Dosen
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/AdminController/matakuliah" class="nav-link active">
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
        <h3><i class="fas fa-edit"></i> Edit Data Mata Kuliah</h3>
        <hr>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert-danger">
            <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error']; ?>
        </div>
        <?php unset($_SESSION['error']); endif; ?>

        <?php if ($data['matakuliah']): ?>
        <form action="<?= BASEURL; ?>/AdminController/matakuliahUpdate/<?= $data['matakuliah']['id']; ?>" method="POST">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <label class="form-label">Kode Mata Kuliah <span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control" value="<?= htmlspecialchars($data['matakuliah']['kode'] ?? ''); ?>" placeholder="Contoh: IF-101" required>
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['matakuliah']['nama'] ?? ''); ?>" placeholder="Contoh: Pemrograman Web" required>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">SKS</label>
                    <select name="sks" class="form-select">
                        <option value="1" <?= ($data['matakuliah']['sks'] ?? '') == 1 ? 'selected' : ''; ?>>1 SKS</option>
                        <option value="2" <?= ($data['matakuliah']['sks'] ?? '') == 2 ? 'selected' : ''; ?>>2 SKS</option>
                        <option value="3" <?= ($data['matakuliah']['sks'] ?? '') == 3 ? 'selected' : ''; ?>>3 SKS</option>
                        <option value="4" <?= ($data['matakuliah']['sks'] ?? '') == 4 ? 'selected' : ''; ?>>4 SKS</option>
                        <option value="6" <?= ($data['matakuliah']['sks'] ?? '') == 6 ? 'selected' : ''; ?>>6 SKS</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-select">
                        <?php for ($i = 1; $i <= 8; $i++): ?>
                        <option value="<?= $i; ?>" <?= ($data['matakuliah']['semester'] ?? '') == $i ? 'selected' : ''; ?>>Semester <?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex gap-3 flex-wrap">
                <button type="submit" name="submit" class="btn-update">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="<?= BASEURL; ?>/AdminController/matakuliah" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
        <?php else: ?>
        <div class="alert-danger">
            <i class="fas fa-exclamation-triangle"></i> Data mata kuliah tidak ditemukan
        </div>
        <div class="mt-3">
            <a href="<?= BASEURL; ?>/AdminController/matakuliah" class="btn-cancel">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <?php endif; ?>
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