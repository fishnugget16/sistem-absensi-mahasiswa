<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Lihat Absensi - Mahasiswa</title>
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
            cursor: pointer;
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
            cursor: pointer;
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

        .page-title {
            color: #e8eaed;
            font-size: 22px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .page-title i {
            color: #4caf50;
            margin-right: 10px;
        }

        hr {
            border-color: #2a2a2a;
            margin: 16px 0 24px 0;
        }

        /* Rekap Section */
        .rekap-title {
            color: #e8eaed;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #2a2a2a;
        }

        .rekap-title i {
            color: #4caf50;
            margin-right: 8px;
        }

        .rekap-card {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 12px;
        }

        .rekap-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 8px;
        }

        .rekap-matkul {
            color: #e8eaed;
            font-weight: 500;
            font-size: 14px;
        }

        .rekap-code {
            color: #9aa0a6;
            font-size: 11px;
            margin-left: 5px;
        }

        .rekap-info {
            color: #9aa0a6;
            font-size: 11px;
            margin-top: 4px;
        }

        .rekap-info i {
            margin-right: 4px;
            color: #4caf50;
        }

        .rekap-percent {
            color: #4caf50;
            font-weight: 600;
            font-size: 14px;
        }

        .progress {
            height: 5px;
            background-color: #2a2a2a;
            border-radius: 10px;
        }

        .progress-bar {
            background-color: #4caf50;
            border-radius: 10px;
        }

        /* ========== TABEL RIWAYAT ABSENSI ========== */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 8px;
            -webkit-overflow-scrolling: touch;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 500px;
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
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        /* BADGES */
        .badge-status {
            display: inline-block;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            min-width: 70px;
            letter-spacing: 0.3px;
        }

        .badge-hadir {
            background: #4caf50;
            color: #121212;
        }

        .badge-sakit {
            background: #ff9800;
            color: #121212;
        }

        .badge-izin {
            background: #2196f3;
            color: #121212;
        }

        .badge-alpa {
            background: #dc3545;
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #9aa0a6;
        }

        .empty-state i {
            font-size: 48px;
            color: #4caf50;
            margin-bottom: 16px;
            display: block;
        }

        /* Button */
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
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: #4a4e54;
            color: white;
        }

        /* Custom Confirm Dialog */
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
        }

        .confirm-buttons .btn-logout-confirm:hover {
            background: #c82333;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .navbar-custom {
                padding: 10px 16px;
            }

            .content-card {
                margin: 16px;
                padding: 18px;
            }

            .page-title {
                font-size: 20px;
            }

            .rekap-card {
                padding: 10px 14px;
                margin-bottom: 10px;
            }

            .rekap-matkul {
                font-size: 13px;
            }

            .rekap-info {
                font-size: 10px;
            }

            .rekap-percent {
                font-size: 13px;
            }

            .table-wrapper {
                overflow-x: auto;
            }

            .data-table {
                min-width: 550px;
            }

            .data-table th {
                padding: 10px 10px;
                font-size: 11px;
            }

            .data-table td {
                padding: 10px 10px;
                font-size: 12px;
            }

            .badge-status {
                padding: 4px 10px;
                font-size: 10px;
                min-width: 60px;
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

            .empty-state {
                padding: 30px;
            }

            .empty-state i {
                font-size: 40px;
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
            <span><?= $_SESSION['nama'] ?? 'Mahasiswa'; ?></span>
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
            <a href="<?= BASEURL; ?>/MahasiswaController/index" class="nav-link">
                <i class="fas fa-home"></i> Home
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/MahasiswaController/absensi" class="nav-link active">
                <i class="fas fa-calendar-alt"></i> Lihat Absensi
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/MahasiswaController/uploadSurat" class="nav-link">
                <i class="fas fa-upload"></i> Upload Surat Izin
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link logout" id="sideLogoutBtn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>

<!-- Custom Confirm Dialog -->
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
        <h3 class="page-title">
            <i class="fas fa-calendar-alt"></i> Riwayat Absensi
        </h3>
        <hr>

        <!-- Rekap per Mata Kuliah -->
        <?php if (!empty($data['rekap_matkul'])): ?>
        <div class="mb-4">
            <div class="rekap-title">
                <i class="fas fa-chart-pie"></i> Rekap Kehadiran per Mata Kuliah
            </div>
            <?php foreach ($data['rekap_matkul'] as $rekap): ?>
            <?php 
                $persen = $rekap['total_pertemuan'] > 0 ? round(($rekap['hadir'] / $rekap['total_pertemuan']) * 100, 1) : 0;
                $jumlah_pertemuan = $rekap['jumlah_pertemuan'] ?? $rekap['total_pertemuan'];
            ?>
            <div class="rekap-card">
                <div class="rekap-header">
                    <div>
                        <span class="rekap-matkul"><?= htmlspecialchars($rekap['nama']); ?></span>
                        <span class="rekap-code">(<?= htmlspecialchars($rekap['kode']); ?>)</span>
                        <div class="rekap-info">
                            <i class="fas fa-star"></i> <?= $rekap['sks']; ?> SKS
                        </div>
                        <div class="rekap-info">
                            <i class="fas fa-calendar-alt"></i> Hadir: <?= $rekap['hadir']; ?> / <?= $jumlah_pertemuan; ?> pertemuan
                        </div>
                    </div>
                    <div class="rekap-percent"><?= $persen; ?>%</div>
                </div>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?= $persen; ?>%;"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Tabel Absensi -->
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Mata Kuliah</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['absensi'])): ?>
                    <tr>
                        <td colspan="5" class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            Belum ada data absensi
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($data['absensi'] as $abs): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d-m-Y', strtotime($abs['tanggal'])); ?></td>
                            <td><?= htmlspecialchars($abs['mata_kuliah']); ?> (<?= $abs['kode']; ?>)<?= isset($abs['sks']) ? ' - ' . $abs['sks'] . ' SKS' : ''; ?></td>
                            <td>
                                <?php 
                                if ($abs['status'] == 'Hadir') {
                                    echo '<span class="badge-status badge-hadir"><i class="fas fa-check-circle"></i> Hadir</span>';
                                } elseif ($abs['status'] == 'Sakit') {
                                    echo '<span class="badge-status badge-sakit"><i class="fas fa-thermometer-half"></i> Sakit</span>';
                                } elseif ($abs['status'] == 'Izin') {
                                    echo '<span class="badge-status badge-izin"><i class="fas fa-file-alt"></i> Izin</span>';
                                } else {
                                    echo '<span class="badge-status badge-alpa"><i class="fas fa-times-circle"></i> Alpa</span>';
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($abs['keterangan'] ?? '-'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <a href="<?= BASEURL; ?>/MahasiswaController/index" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<script>
    // Custom Confirm Dialog for Logout
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

    // Toggle Sidebar
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
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>