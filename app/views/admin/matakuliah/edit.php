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
            cursor: pointer;
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
            cursor: pointer;
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

        .form-control {
            background: #2a2a2a;
            border: 1px solid #3c4043;
            color: #e8eaed;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            transition: all 0.2s;
            width: 100%;
        }

        .form-control:focus {
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

        /* ========== CUSTOM CONFIRM DIALOG ========== */
        .custom-confirm-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
            z-index: 1100;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .custom-confirm-overlay.show {
            display: flex;
        }

        .custom-confirm-dialog {
            background: #1e1e1e;
            border-radius: 16px;
            width: 90%;
            max-width: 400px;
            padding: 24px;
            border: 1px solid #2a2a2a;
            animation: modalFadeIn 0.2s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .confirm-icon {
            text-align: center;
            margin-bottom: 20px;
        }

        .confirm-icon i {
            font-size: 56px;
            color: #dc3545;
        }

        .confirm-title {
            text-align: center;
            color: #e8eaed;
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .confirm-message {
            text-align: center;
            color: #9aa0a6;
            font-size: 14px;
            margin-bottom: 24px;
            line-height: 1.5;
        }

        .confirm-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .confirm-buttons .btn-cancel-confirm {
            background: #3c4043;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .confirm-buttons .btn-cancel-confirm:hover {
            background: #4a4e54;
        }

        .confirm-buttons .btn-logout-confirm {
            background: #dc3545;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .confirm-buttons .btn-logout-confirm:hover {
            background: #c82333;
        }

        /* ========== CUSTOM SELECT ========== */
        .custom-select-container {
            position: relative;
            width: 100%;
        }

        .custom-select-trigger {
            background: #2a2a2a;
            border: 1px solid #3c4043;
            border-radius: 8px;
            padding: 10px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s;
            color: #e8eaed;
            font-size: 14px;
        }

        .custom-select-trigger:hover {
            border-color: #4caf50;
        }

        .custom-select-trigger i {
            transition: transform 0.2s;
            color: #9aa0a6;
        }

        .custom-select-trigger.open i {
            transform: rotate(180deg);
        }

        .custom-select-options {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #1e1e1e;
            border: 1px solid #3c4043;
            border-radius: 8px;
            margin-top: 4px;
            z-index: 100;
            display: none;
            max-height: 280px;
            overflow: hidden;
            flex-direction: column;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .custom-select-options.show {
            display: flex;
        }

        .options-list {
            overflow-y: auto;
            max-height: 250px;
        }

        .option-item {
            padding: 10px 12px;
            cursor: pointer;
            transition: all 0.2s;
            color: #e8eaed;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .option-item i {
            width: 20px;
            font-size: 14px;
            color: #4caf50;
        }

        .option-item:hover {
            background: rgba(76, 175, 80, 0.1);
        }

        .option-item.selected {
            background: rgba(76, 175, 80, 0.2);
            color: #4caf50;
        }

        /* Scrollbar custom */
        .options-list::-webkit-scrollbar {
            width: 6px;
        }

        .options-list::-webkit-scrollbar-track {
            background: #2a2a2a;
            border-radius: 3px;
        }

        .options-list::-webkit-scrollbar-thumb {
            background: #4caf50;
            border-radius: 3px;
        }

        /* Info Box */
        .info-box {
            background: rgba(33, 150, 243, 0.1);
            border: 1px solid rgba(33, 150, 243, 0.3);
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        .info-box i {
            color: #2196f3;
            margin-right: 8px;
        }

        .info-box span {
            color: #9aa0a6;
            font-size: 12px;
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

            .form-control, .custom-select-trigger {
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

            .form-control, .custom-select-trigger {
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
        <a href="#" class="logout-link" id="logoutBtn">
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
            <a href="<?= BASEURL; ?>/AdminController/surat_izin" class="nav-link">
                <i class="fas fa-file-alt"></i> Surat Izin
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link logout" id="sideLogoutBtn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>

<!-- Custom Confirm Dialog untuk LOGOUT -->
<div class="custom-confirm-overlay" id="customConfirmOverlay">
    <div class="custom-confirm-dialog">
        <div class="confirm-icon">
            <i class="fas fa-sign-out-alt"></i>
        </div>
        <div class="confirm-title">Konfirmasi Logout</div>
        <div class="confirm-message" id="confirmMessage">
            Apakah Anda yakin ingin keluar dari sistem?
        </div>
        <div class="confirm-buttons">
            <button class="btn-cancel-confirm" id="confirmCancelBtn">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="btn-logout-confirm" id="confirmLogoutBtn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>
    </div>
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
        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <span>SKS adalah beban studi (1 SKS = 1 jam 50 menit per minggu). Jumlah pertemuan adalah total tatap muka dalam satu semester (minimal 1, maksimal 24).</span>
        </div>

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
                    <div class="custom-select-container" id="sksSelectContainer">
                        <div class="custom-select-trigger" id="sksSelectTrigger">
                            <span id="selectedSksText"><?= ($data['matakuliah']['sks'] ?? 3); ?> SKS</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="custom-select-options" id="sksSelectOptions">
                            <div class="options-list" id="sksOptionsList">
                                <div class="option-item <?= ($data['matakuliah']['sks'] ?? '') == 1 ? 'selected' : ''; ?>" data-value="1">
                                    <i class="fas fa-star"></i> 1 SKS
                                </div>
                                <div class="option-item <?= ($data['matakuliah']['sks'] ?? '') == 2 ? 'selected' : ''; ?>" data-value="2">
                                    <i class="fas fa-star"></i> 2 SKS
                                </div>
                                <div class="option-item <?= ($data['matakuliah']['sks'] ?? '') == 3 ? 'selected' : ''; ?>" data-value="3">
                                    <i class="fas fa-star"></i> 3 SKS
                                </div>
                                <div class="option-item <?= ($data['matakuliah']['sks'] ?? '') == 4 ? 'selected' : ''; ?>" data-value="4">
                                    <i class="fas fa-star"></i> 4 SKS
                                </div>
                                <div class="option-item <?= ($data['matakuliah']['sks'] ?? '') == 6 ? 'selected' : ''; ?>" data-value="6">
                                    <i class="fas fa-star"></i> 6 SKS
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="sks" id="selectedSksValue" value="<?= $data['matakuliah']['sks'] ?? 3; ?>">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Semester</label>
                    <div class="custom-select-container" id="semesterSelectContainer">
                        <div class="custom-select-trigger" id="semesterSelectTrigger">
                            <span id="selectedSemesterText">Semester <?= $data['matakuliah']['semester'] ?? 1; ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="custom-select-options" id="semesterSelectOptions">
                            <div class="options-list" id="semesterOptionsList">
                                <?php for ($i = 1; $i <= 8; $i++): ?>
                                <div class="option-item <?= ($data['matakuliah']['semester'] ?? '') == $i ? 'selected' : ''; ?>" data-value="<?= $i; ?>">
                                    <i class="fas fa-layer-group"></i> Semester <?= $i; ?>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="semester" id="selectedSemesterValue" value="<?= $data['matakuliah']['semester'] ?? 1; ?>">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label">Jumlah Pertemuan <span class="text-danger">*</span></label>
                    <div class="custom-select-container" id="pertemuanSelectContainer">
                        <div class="custom-select-trigger" id="pertemuanSelectTrigger">
                            <span id="selectedPertemuanText"><?= ($data['matakuliah']['jumlah_pertemuan'] ?? 14); ?> Pertemuan</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="custom-select-options" id="pertemuanSelectOptions">
                            <div class="options-list" id="pertemuanOptionsList">
                                <?php for ($i = 1; $i <= 24; $i++): ?>
                                <div class="option-item <?= ($data['matakuliah']['jumlah_pertemuan'] ?? 14) == $i ? 'selected' : ''; ?>" data-value="<?= $i; ?>">
                                    <i class="fas fa-calendar-alt"></i> <?= $i; ?> Pertemuan
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="jumlah_pertemuan" id="selectedPertemuanValue" value="<?= $data['matakuliah']['jumlah_pertemuan'] ?? 14; ?>">
                    <div class="form-text text-muted small">Minimal 1, maksimal 24 pertemuan per semester</div>
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
    // ========== CUSTOM CONFIRM DIALOG FOR LOGOUT ==========
    const confirmOverlay = document.getElementById('customConfirmOverlay');
    const confirmMessage = document.getElementById('confirmMessage');
    const confirmCancelBtn = document.getElementById('confirmCancelBtn');
    const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
    const logoutBtn = document.getElementById('logoutBtn');
    const sideLogoutBtn = document.getElementById('sideLogoutBtn');
    let pendingLogoutUrl = null;

    function showConfirmDialog(message, logoutUrl) {
        confirmMessage.innerHTML = message;
        pendingLogoutUrl = logoutUrl;
        confirmOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeConfirmDialog() {
        confirmOverlay.classList.remove('show');
        document.body.style.overflow = '';
        pendingLogoutUrl = null;
    }

    function executeLogout() {
        if (pendingLogoutUrl) {
            window.location.href = pendingLogoutUrl;
        }
    }

    confirmCancelBtn.addEventListener('click', closeConfirmDialog);
    confirmLogoutBtn.addEventListener('click', executeLogout);
    confirmOverlay.addEventListener('click', (e) => {
        if (e.target === confirmOverlay) closeConfirmDialog();
    });

    logoutBtn.addEventListener('click', (e) => {
        e.preventDefault();
        showConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout');
    });

    sideLogoutBtn.addEventListener('click', (e) => {
        e.preventDefault();
        showConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout');
    });

    // ========== TOGGLE SIDEBAR ==========
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

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && sideMenu.classList.contains('open')) {
            closeSidebar();
        }
    });

    // ========== CUSTOM SELECT FUNCTIONS ==========
    function initCustomSelect(containerId, triggerId, optionsId, selectedTextId, selectedValueId, defaultText) {
        const container = document.getElementById(containerId);
        const trigger = document.getElementById(triggerId);
        const optionsContainer = document.getElementById(optionsId);
        const selectedText = document.getElementById(selectedTextId);
        const selectedValue = document.getElementById(selectedValueId);

        function toggleDropdown() {
            optionsContainer.classList.toggle('show');
            trigger.classList.toggle('open');
        }

        function selectOption(value, text) {
            selectedText.textContent = text;
            selectedValue.value = value;
            
            container.querySelectorAll('.option-item').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            const selectedOpt = Array.from(container.querySelectorAll('.option-item')).find(
                opt => opt.getAttribute('data-value') == value
            );
            if (selectedOpt) selectedOpt.classList.add('selected');
            
            optionsContainer.classList.remove('show');
            trigger.classList.remove('open');
        }

        trigger.addEventListener('click', toggleDropdown);

        container.querySelectorAll('.option-item').forEach(option => {
            option.addEventListener('click', () => {
                const value = option.getAttribute('data-value');
                const text = option.textContent.trim();
                selectOption(value, text);
            });
        });

        document.addEventListener('click', function(event) {
            if (!container.contains(event.target)) {
                optionsContainer.classList.remove('show');
                trigger.classList.remove('open');
            }
        });
    }

    // Init custom select untuk SKS
    initCustomSelect('sksSelectContainer', 'sksSelectTrigger', 'sksSelectOptions', 'selectedSksText', 'selectedSksValue', '3 SKS');
    
    // Init custom select untuk Semester
    initCustomSelect('semesterSelectContainer', 'semesterSelectTrigger', 'semesterSelectOptions', 'selectedSemesterText', 'selectedSemesterValue', 'Semester 1');
    
    // Init custom select untuk Jumlah Pertemuan
    initCustomSelect('pertemuanSelectContainer', 'pertemuanSelectTrigger', 'pertemuanSelectOptions', 'selectedPertemuanText', 'selectedPertemuanValue', '14 Pertemuan');
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>