<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title><?= $data['judul_halaman'] ?? 'Surat Izin' ?> - Admin</title>
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
            margin-bottom: 20px;
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

        hr {
            border-color: #2a2a2a;
            margin: 16px 0 20px 0;
        }

        /* Statistik Cards - Responsif Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            border: 1px solid #2a2a2a;
            transition: all 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: #4caf50;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: 700;
            color: #e8eaed;
        }

        .stat-card .label {
            font-size: 12px;
            color: #9aa0a6;
            margin-top: 8px;
        }

        .stat-card.pending .value { color: #ff9800; }
        .stat-card.approved .value { color: #4caf50; }
        .stat-card.rejected .value { color: #dc3545; }

        /* Filter Buttons */
        .filter-section {
            margin-bottom: 24px;
        }

        .filter-title {
            color: #e8eaed;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: #2a2a2a;
            border: 1px solid #3c4043;
            padding: 8px 20px;
            border-radius: 30px;
            color: #9aa0a6;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .filter-btn:hover {
            background: #4caf50;
            border-color: #4caf50;
            color: #121212;
        }

        .filter-btn.active {
            background: #4caf50;
            border-color: #4caf50;
            color: #121212;
        }

        /* Pagination */
        .btn-back, .btn-pagination {
            background: #3c4043;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            color: white;
            font-size: 13px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-back:hover, .btn-pagination:hover {
            background: #4a4e54;
            color: white;
        }

        .btn-pagination:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 16px;
            margin-top: 24px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .pagination-info {
            color: #9aa0a6;
            font-size: 13px;
        }

        /* Table */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 750px;
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
            padding: 14px 12px;
            color: #e8eaed;
            font-size: 13px;
            border-bottom: 1px solid #2a2a2a;
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        /* Badges */
        .badge-pending {
            background: rgba(255, 152, 0, 0.15);
            color: #ff9800;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-approved {
            background: rgba(76, 175, 80, 0.15);
            color: #4caf50;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-rejected {
            background: rgba(220, 53, 69, 0.15);
            color: #ef9a9a;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        /* Buttons */
        .btn-view {
            background: rgba(33, 150, 243, 0.15);
            border: 1px solid rgba(33, 150, 243, 0.3);
            padding: 6px 12px;
            border-radius: 6px;
            color: #90caf9;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-view:hover {
            background: #2196f3;
            border-color: #2196f3;
            color: white;
        }

        /* Alert */
        .alert-success {
            background: #1a2c1a;
            border: 1px solid #4caf50;
            color: #9aef9a;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-danger {
            background: #2c1a1a;
            border: 1px solid #dc3545;
            color: #ef9a9a;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
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
        @media (max-width: 992px) {
            .stats-grid {
                gap: 16px;
            }
            .stat-card .value {
                font-size: 28px;
            }
        }

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

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .stat-card {
                padding: 14px;
            }

            .stat-card .value {
                font-size: 24px;
            }

            .filter-btn {
                padding: 6px 14px;
                font-size: 12px;
            }

            .data-table th,
            .data-table td {
                padding: 10px 8px;
                font-size: 12px;
            }

            .badge-pending,
            .badge-approved,
            .badge-rejected {
                padding: 3px 8px;
                font-size: 10px;
            }

            .btn-view {
                padding: 4px 8px;
                font-size: 11px;
            }

            .btn-view span {
                display: none;
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

            .btn-back, .btn-pagination {
                padding: 6px 16px;
                font-size: 12px;
            }

            .pagination-container {
                justify-content: center;
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
        <li class="nav-item"><a href="<?= BASEURL; ?>/AuthController/dashboard" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
        <li class="nav-item"><a href="<?= BASEURL; ?>/AdminController/mahasiswa" class="nav-link"><i class="fas fa-user-graduate"></i> Kelola Mahasiswa</a></li>
        <li class="nav-item"><a href="<?= BASEURL; ?>/AdminController/dosen" class="nav-link"><i class="fas fa-chalkboard-user"></i> Kelola Dosen</a></li>
        <li class="nav-item"><a href="<?= BASEURL; ?>/AdminController/matakuliah" class="nav-link"><i class="fas fa-book-open"></i> Kelola Mata Kuliah</a></li>
        <li class="nav-item"><a href="<?= BASEURL; ?>/AdminController/surat_izin" class="nav-link active"><i class="fas fa-file-alt"></i> Surat Izin</a></li>
        <li class="nav-item"><a href="#" class="nav-link logout" id="sideLogoutBtn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<!-- Custom Confirm Dialog -->
<div class="custom-confirm-overlay" id="customConfirmOverlay">
    <div class="custom-confirm-dialog">
        <div class="confirm-icon"><i class="fas fa-sign-out-alt"></i></div>
        <div class="confirm-title">Konfirmasi Logout</div>
        <div class="confirm-message" id="confirmMessage">Apakah Anda yakin ingin keluar dari sistem?</div>
        <div class="confirm-buttons">
            <button class="btn-cancel-confirm" id="confirmCancelBtn"><i class="fas fa-times"></i> Batal</button>
            <button class="btn-logout-confirm" id="confirmLogoutBtn"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="content-card">
        <div class="page-header">
            <h3 class="page-title"><i class="fas fa-file-alt"></i> <?= $data['judul_halaman'] ?></h3>
        </div>
        <hr>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert-danger">
            <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>

        <!-- Statistik Cards -->
        <div class="stats-grid">
            <div class="stat-card pending">
                <div class="value"><?= number_format($data['statistik']['pending'] ?? 0, 0, ',', '.'); ?></div>
                <div class="label"><i class="fas fa-clock"></i> Menunggu</div>
            </div>
            <div class="stat-card approved">
                <div class="value"><?= number_format($data['statistik']['disetujui'] ?? 0, 0, ',', '.'); ?></div>
                <div class="label"><i class="fas fa-check-circle"></i> Disetujui</div>
            </div>
            <div class="stat-card rejected">
                <div class="value"><?= number_format($data['statistik']['ditolak'] ?? 0, 0, ',', '.'); ?></div>
                <div class="label"><i class="fas fa-times-circle"></i> Ditolak</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-title">
                <i class="fas fa-filter"></i> Filter Status
            </div>
            <div class="filter-buttons">
                <a href="<?= BASEURL; ?>/AdminController/surat_izin" class="filter-btn <?= $data['filter_aktif'] == 'semua' ? 'active' : '' ?>">
                    <i class="fas fa-list"></i> Semua
                </a>
                <a href="<?= BASEURL; ?>/AdminController/surat_izin?status=pending" class="filter-btn <?= $data['filter_aktif'] == 'pending' ? 'active' : '' ?>">
                    <i class="fas fa-clock"></i> Menunggu
                </a>
                <a href="<?= BASEURL; ?>/AdminController/surat_izin?status=disetujui" class="filter-btn <?= $data['filter_aktif'] == 'disetujui' ? 'active' : '' ?>">
                    <i class="fas fa-check-circle"></i> Disetujui
                </a>
                <a href="<?= BASEURL; ?>/AdminController/surat_izin?status=ditolak" class="filter-btn <?= $data['filter_aktif'] == 'ditolak' ? 'active' : '' ?>">
                    <i class="fas fa-times-circle"></i> Ditolak
                </a>
            </div>
        </div>

        <!-- Tabel Surat Izin dengan Pagination -->
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Mahasiswa</th>
                        <th>Mata Kuliah</th>
                        <th>Tanggal Upload</th>
                        <th>Jenis Surat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // PAGINATION: 10 data per halaman
                    $limit = 10;
                    $total_data = count($data['surat_izin']);
                    $total_pages = ceil($total_data / $limit);
                    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($current_page < 1) $current_page = 1;
                    if ($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages;
                    
                    $start_index = ($current_page - 1) * $limit;
                    $display_data = array_slice($data['surat_izin'], $start_index, $limit);
                    ?>
                    
                    <?php if (empty($display_data)): ?>
                    <tr class="empty-row">
                        <td colspan="7" class="text-center" style="color: #9aa0a6; padding: 40px;">
                            <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
                            Belum ada data surat izin
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php $no = $start_index + 1; foreach ($display_data as $sz): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <strong><?= htmlspecialchars($sz['mahasiswa_nama'] ?? '-'); ?></strong>
                                <br><small class="text-muted" style="color: #9aa0a6;"><?= htmlspecialchars($sz['nim'] ?? '-'); ?></small>
                            </td>
                            <td>
                                <?= htmlspecialchars($sz['mata_kuliah'] ?? '-'); ?>
                                <br><small class="text-muted" style="color: #9aa0a6;"><?= htmlspecialchars($sz['kode'] ?? '-'); ?></small>
                            </td>
                            <td><?= date('d-m-Y H:i', strtotime($sz['tanggal_upload'])); ?></td>
                            <td><?= ucfirst($sz['jenis'] ?? '-'); ?></td>
                            <td>
                                <?php if ($sz['status'] == 'pending'): ?>
                                    <span class="badge-pending"><i class="fas fa-hourglass-half"></i> Menunggu</span>
                                <?php elseif ($sz['status'] == 'disetujui'): ?>
                                    <span class="badge-approved"><i class="fas fa-check-circle"></i> Disetujui</span>
                                <?php else: ?>
                                    <span class="badge-rejected"><i class="fas fa-times-circle"></i> Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= BASEURL; ?>/AdminController/surat_izin_detail/<?= $sz['id']; ?>" class="btn-view">
                                    <i class="fas fa-eye"></i> <span>Detail</span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION SECTION -->
        <?php if ($total_data > $limit): ?>
        <div class="pagination-container">
            <div class="pagination-info">
                Menampilkan <?= $start_index + 1; ?> - <?= min($start_index + $limit, $total_data); ?> dari <?= $total_data; ?> data
            </div>
            <div class="d-flex gap-2">
                <?php 
                // Build URL with existing filter parameters
                $filter_param = '';
                if (isset($_GET['status']) && !empty($_GET['status'])) {
                    $filter_param = '&status=' . $_GET['status'];
                }
                ?>
                <?php if ($current_page > 1): ?>
                <a href="?page=<?= $current_page - 1; ?><?= $filter_param; ?>" class="btn-pagination">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </a>
                <?php else: ?>
                <button class="btn-pagination" disabled>
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </button>
                <?php endif; ?>
                
                <?php if ($current_page < $total_pages): ?>
                <a href="?page=<?= $current_page + 1; ?><?= $filter_param; ?>" class="btn-pagination">
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </a>
                <?php else: ?>
                <button class="btn-pagination" disabled>
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </button>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <a href="<?= BASEURL; ?>/AuthController/dashboard" class="btn-back">
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
        if (pendingLogoutUrl) window.location.href = pendingLogoutUrl;
    }

    confirmCancelBtn.addEventListener('click', closeConfirmDialog);
    confirmLogoutBtn.addEventListener('click', executeLogout);
    confirmOverlay.addEventListener('click', (e) => { if (e.target === confirmOverlay) closeConfirmDialog(); });
    logoutBtn.addEventListener('click', (e) => { e.preventDefault(); showConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout'); });
    sideLogoutBtn.addEventListener('click', (e) => { e.preventDefault(); showConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout'); });

    // Toggle Sidebar
    const toggleBtn = document.getElementById('toggleSidebar');
    const brandToggle = document.getElementById('brandToggle');
    const sideMenu = document.getElementById('sideMenuOverlay');
    const backdrop = document.getElementById('sidebarBackdrop');

    function openSidebar() { sideMenu.classList.add('open'); backdrop.classList.add('show'); document.body.style.overflow = 'hidden'; }
    function closeSidebar() { sideMenu.classList.remove('open'); backdrop.classList.remove('show'); document.body.style.overflow = ''; }
    function toggleSidebar() { sideMenu.classList.contains('open') ? closeSidebar() : openSidebar(); }

    toggleBtn.addEventListener('click', toggleSidebar);
    brandToggle.addEventListener('click', toggleSidebar);
    backdrop.addEventListener('click', closeSidebar);

    window.addEventListener('resize', () => { if (window.innerWidth > 768 && sideMenu.classList.contains('open')) closeSidebar(); });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>