<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Histori Surat Izin - Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background-color: #121212; overflow-x: hidden; }

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
            min-height: 60px;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
            height: 100%;
        }

        .toggle-btn {
            background: transparent;
            border: none;
            color: #e8eaed;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            border-radius: 4px;
            transition: background 0.2s;
            height: 36px;
            width: 36px;
        }

        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            cursor: default;
            pointer-events: none;
            user-select: none;
            height: 36px;
            line-height: 1;
        }

        .navbar-brand i {
            color: #4caf50;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .navbar-brand span {
            color: #e8eaed;
            font-size: 18px;
            font-weight: 500;
            display: flex;
            align-items: center;
            height: 24px;
            line-height: 24px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
            height: 100%;
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

        .side-menu-overlay.open { transform: translateX(0); }

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

        .sidebar-backdrop.show { display: block; }

        .side-menu-overlay .nav-menu {
            list-style: none;
            padding: 20px 16px 20px 16px;
            margin-top: 0;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            margin-bottom: 4px;
            cursor: default;
            pointer-events: none;
            user-select: none;
            min-height: 48px;
            border-radius: 10px;
        }

        .sidebar-brand i {
            color: #4caf50;
            font-size: 16px;
            width: 22px;
            text-align: center;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .sidebar-brand span {
            color: #e8eaed;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            line-height: 1;
        }

        .side-menu-overlay .nav-item {
            margin-bottom: 4px;
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
            min-height: 48px;
        }

        .side-menu-overlay .nav-link i {
            width: 22px;
            font-size: 16px;
            text-align: center;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
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

        hr {
            border-color: #2a2a2a;
            margin: 16px 0 24px 0;
        }

        /* Filter Section */
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
            display: inline-block;
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

        /* Table */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 10px;
            margin-bottom: 20px;
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
            font-size: 13px;
            border-bottom: 1px solid #2a2a2a;
            vertical-align: middle;
        }

        .data-table tbody tr {
            cursor: pointer;
            transition: background 0.2s;
            position: relative;
        }

        .data-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .data-table tbody tr.expanded {
            background: rgba(76, 175, 80, 0.08);
        }

        .data-table tbody tr .expand-icon {
            display: inline-block;
            transition: transform 0.3s ease;
            color: #4caf50;
            font-size: 14px;
        }

        .data-table tbody tr.expanded .expand-icon {
            transform: rotate(180deg);
        }

        /* ===== EXPANDED ROW ACTION ===== */
        .action-row {
            display: none;
            background: rgba(255, 255, 255, 0.02);
            border-bottom: 1px solid #2a2a2a;
        }

        .action-row td {
            padding: 0 12px 12px 12px;
        }

        .action-row.show {
            display: table-row;
        }

        .action-row .action-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 12px 8px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            border: 1px solid #2a2a2a;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
            background: transparent;
            color: #e8eaed;
        }

        .action-btn:hover {
            transform: translateY(-1px);
        }

        .action-btn:active {
            transform: scale(0.97);
        }

        .action-btn .action-icon {
            font-size: 15px;
        }

        .action-btn.action-download {
            background: rgba(33, 150, 243, 0.15);
            color: #2196f3;
        }

        .action-btn.action-download:hover {
            background: rgba(33, 150, 243, 0.25);
        }

        .action-btn.action-delete {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .action-btn.action-delete:hover {
            background: rgba(220, 53, 69, 0.25);
        }

        .action-divider {
            width: 1px;
            background: #2a2a2a;
            flex-shrink: 0;
        }

        /* ===== BADGE STATUS - UKURAN SERAGAM ===== */
        .badge-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            min-width: 105px;
            min-height: 30px;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }

        .badge-status i {
            font-size: 12px;
        }

        .badge-pending {
            background: rgba(255, 152, 0, 0.15);
            color: #ff9800;
        }

        .badge-approved {
            background: rgba(76, 175, 80, 0.15);
            color: #4caf50;
        }

        .badge-rejected {
            background: rgba(220, 53, 69, 0.15);
            color: #ef9a9a;
        }

        .badge-file {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: rgba(33, 150, 243, 0.15);
            color: #90caf9;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            min-width: 105px;
            min-height: 30px;
            text-decoration: none;
            white-space: nowrap;
        }

        .badge-file:hover {
            background: #2196f3;
            color: white;
        }

        /* Buttons */
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
            margin-top: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .pagination-info {
            color: #9aa0a6;
            font-size: 13px;
        }

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
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
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
                min-height: 56px;
            }

            .content-card {
                margin: 16px;
                padding: 20px;
            }

            .page-title {
                font-size: 18px;
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

            .user-info span,
            .logout-link span,
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

            .action-container {
                flex-direction: column;
                align-items: stretch;
            }

            .action-divider {
                display: none;
            }

            .action-btn {
                justify-content: center;
                padding: 10px 16px;
            }

            .badge-status,
            .badge-file {
                min-width: 90px;
                min-height: 26px;
                padding: 4px 10px;
                font-size: 10px;
            }

            .badge-status i,
            .badge-file i {
                font-size: 10px;
            }
        }

        @media (max-width: 576px) {
            .badge-status,
            .badge-file {
                min-width: 80px;
                min-height: 22px;
                padding: 3px 8px;
                font-size: 9px;
                gap: 4px;
            }

            .badge-status i,
            .badge-file i {
                font-size: 9px;
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
        <button class="toggle-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
        <div class="navbar-brand">
            <i class="fas fa-graduation-cap"></i>
            <span>SENMA</span>
        </div>
    </div>
    <div class="navbar-right">
        <span class="user-info"><i class="fas fa-user-circle"></i><span><?= $_SESSION['nama'] ?? 'Mahasiswa'; ?></span></span>
        <a href="#" class="logout-link" id="logoutBtn"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
    </div>
</div>

<!-- Overlay Sidebar -->
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<div class="side-menu-overlay" id="sideMenuOverlay">
    <ul class="nav-menu">
        <!-- ===== BRANDING SEBAGAI ITEM MENU PERTAMA ===== -->
        <li class="sidebar-brand">
            <i class="fas fa-graduation-cap"></i>
            <span>SENMA</span>
        </li>

        <li class="nav-item"><a href="<?= BASEURL; ?>/MahasiswaController/index" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
        <li class="nav-item"><a href="<?= BASEURL; ?>/MahasiswaController/absensi" class="nav-link"><i class="fas fa-calendar-alt"></i> Lihat Absensi</a></li>
        <li class="nav-item"><a href="<?= BASEURL; ?>/MahasiswaController/uploadSurat" class="nav-link"><i class="fas fa-upload"></i> Upload Surat Izin</a></li>
        <li class="nav-item"><a href="<?= BASEURL; ?>/MahasiswaController/historiSurat" class="nav-link active"><i class="fas fa-history"></i> Histori Surat Izin</a></li>
        <li class="nav-item"><a href="#" class="nav-link logout" id="sideLogoutBtn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<!-- Custom Confirm Dialog untuk Logout -->
<div id="customConfirmOverlay" class="custom-confirm-overlay">
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
            <h3 class="page-title"><i class="fas fa-history"></i> Histori Surat Izin</h3>
        </div>
        <hr>

        <?php 
        $current_filter = $data['filter_aktif'] ?? 'semua';
        
        $limit = 10;
        $total_data = count($data['surat_izin']);
        $total_pages = ceil($total_data / $limit);
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($current_page < 1) $current_page = 1;
        if ($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages;
        
        $start_index = ($current_page - 1) * $limit;
        $display_data = array_slice($data['surat_izin'], $start_index, $limit);
        
        $filter_param = '';
        if ($current_filter != 'semua') {
            $filter_param = '&status=' . $current_filter;
        }
        ?>

        <!-- FILTER SECTION -->
        <div class="filter-section">
            <div class="filter-title"><i class="fas fa-filter"></i> Filter Status</div>
            <div class="filter-buttons">
                <a href="<?= BASEURL; ?>/MahasiswaController/historiSurat" class="filter-btn <?= ($current_filter == 'semua') ? 'active' : ''; ?>">
                    <i class="fas fa-list"></i> Semua
                </a>
                <a href="<?= BASEURL; ?>/MahasiswaController/historiSurat?status=pending" class="filter-btn <?= ($current_filter == 'pending') ? 'active' : ''; ?>">
                    <i class="fas fa-clock"></i> Menunggu
                </a>
                <a href="<?= BASEURL; ?>/MahasiswaController/historiSurat?status=disetujui" class="filter-btn <?= ($current_filter == 'disetujui') ? 'active' : ''; ?>">
                    <i class="fas fa-check-circle"></i> Disetujui
                </a>
                <a href="<?= BASEURL; ?>/MahasiswaController/historiSurat?status=ditolak" class="filter-btn <?= ($current_filter == 'ditolak') ? 'active' : ''; ?>">
                    <i class="fas fa-times-circle"></i> Ditolak
                </a>
            </div>
        </div>

        <!-- TABEL -->
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:30px;"></th>
                        <th style="width:40px;">No</th>
                        <th>Mata Kuliah</th>
                        <th>Tanggal Upload</th>
                        <th>Jenis Surat</th>
                        <th>Status</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($display_data)): ?>
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <?php if ($current_filter != 'semua'): ?>
                                Tidak ada data surat izin dengan status <?= ucfirst($current_filter); ?>
                            <?php else: ?>
                                Belum ada data surat izin
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php $no = $start_index + 1; foreach ($display_data as $sz): ?>
                        <!-- Main Row -->
                        <tr class="surat-main-row" data-surat-id="<?= $sz['id']; ?>" onclick="toggleRow(<?= $sz['id']; ?>)">
                            <td style="text-align:center;">
                                <span class="expand-icon">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </td>
                            <td><?= $no++; ?></td>
                            <td>
                                <?= htmlspecialchars($sz['mata_kuliah'] ?? '-'); ?>
                                <br><small style="color: #9aa0a6;"><?= htmlspecialchars($sz['kode'] ?? '-'); ?></small>
                            </td>
                            <td><?= date('d-m-Y H:i', strtotime($sz['tanggal_upload'])); ?></td>
                            <td><?= ucfirst($sz['jenis'] ?? '-'); ?></td>
                            <td>
                                <?php if ($sz['status'] == 'pending'): ?>
                                    <span class="badge-status badge-pending"><i class="fas fa-hourglass-half"></i> Menunggu</span>
                                <?php elseif ($sz['status'] == 'disetujui'): ?>
                                    <span class="badge-status badge-approved"><i class="fas fa-check-circle"></i> Disetujui</span>
                                <?php else: ?>
                                    <span class="badge-status badge-rejected"><i class="fas fa-times-circle"></i> Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($sz['file_path'])): ?>
                                <a href="<?= BASEURL; ?>/<?= $sz['file_path']; ?>" target="_blank" class="badge-file" onclick="event.stopPropagation();">
                                    <i class="fas fa-download"></i> Lihat File
                                </a>
                                <?php else: ?>
                                <span style="color: #9aa0a6;">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <!-- Action Row (Expanded) -->
                        <tr class="action-row" id="action-row-<?= $sz['id']; ?>">
                            <td colspan="7">
                                <div class="action-container">
                                    <?php if (!empty($sz['file_path'])): ?>
                                    <a href="<?= BASEURL; ?>/<?= $sz['file_path']; ?>" target="_blank" class="action-btn action-download" onclick="event.stopPropagation();">
                                        <span class="action-icon"><i class="fas fa-download"></i></span>
                                        Unduh File
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($sz['status'] == 'pending'): ?>
                                    <div class="action-divider"></div>
                                    <button class="action-btn action-delete" onclick="event.stopPropagation();">
                                        <span class="action-icon"><i class="fas fa-times"></i></span>
                                        Batalkan Permohonan
                                    </button>
                                    <?php endif; ?>
                                </div>
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

        <a href="<?= BASEURL; ?>/MahasiswaController/index" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<script>
    // ========== TOGGLE ROW EXPAND ==========
    function toggleRow(suratId) {
        var actionRow = document.getElementById('action-row-' + suratId);
        var mainRow = document.querySelector('.surat-main-row[data-surat-id="' + suratId + '"]');
        
        if (!actionRow || !mainRow) return;
        
        // Close all other expanded rows
        document.querySelectorAll('.action-row.show').forEach(function(row) {
            if (row.id !== 'action-row-' + suratId) {
                row.classList.remove('show');
                var prevRow = row.previousElementSibling;
                if (prevRow && prevRow.classList.contains('surat-main-row')) {
                    prevRow.classList.remove('expanded');
                    var icon = prevRow.querySelector('.expand-icon i');
                    if (icon) {
                        icon.className = 'fas fa-chevron-down';
                    }
                }
            }
        });
        
        // Toggle current row
        actionRow.classList.toggle('show');
        mainRow.classList.toggle('expanded');
        
        var icon = mainRow.querySelector('.expand-icon i');
        if (icon) {
            if (mainRow.classList.contains('expanded')) {
                icon.className = 'fas fa-chevron-up';
            } else {
                icon.className = 'fas fa-chevron-down';
            }
        }
    }

    // Close expanded rows when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.data-table')) {
            document.querySelectorAll('.action-row.show').forEach(function(row) {
                row.classList.remove('show');
                var prevRow = row.previousElementSibling;
                if (prevRow && prevRow.classList.contains('surat-main-row')) {
                    prevRow.classList.remove('expanded');
                    var icon = prevRow.querySelector('.expand-icon i');
                    if (icon) {
                        icon.className = 'fas fa-chevron-down';
                    }
                }
            });
        }
    });

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
        if (pendingLogoutUrl) window.location.href = pendingLogoutUrl;
    }

    confirmCancelBtn.addEventListener('click', closeConfirmDialog);
    confirmLogoutBtn.addEventListener('click', executeLogout);
    confirmOverlay.addEventListener('click', (e) => { if (e.target === confirmOverlay) closeConfirmDialog(); });
    logoutBtn.addEventListener('click', (e) => { e.preventDefault(); showConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout'); });
    sideLogoutBtn.addEventListener('click', (e) => { e.preventDefault(); showConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout'); });

    // ========== TOGGLE SIDEBAR ==========
    const toggleBtn = document.getElementById('toggleSidebar');
    const sideMenu = document.getElementById('sideMenuOverlay');
    const backdrop = document.getElementById('sidebarBackdrop');

    function openSidebar() { sideMenu.classList.add('open'); backdrop.classList.add('show'); document.body.style.overflow = 'hidden'; }
    function closeSidebar() { sideMenu.classList.remove('open'); backdrop.classList.remove('show'); document.body.style.overflow = ''; }
    function toggleSidebar() { sideMenu.classList.contains('open') ? closeSidebar() : openSidebar(); }

    toggleBtn.addEventListener('click', toggleSidebar);
    backdrop.addEventListener('click', closeSidebar);

    window.addEventListener('resize', () => { if (window.innerWidth > 768 && sideMenu.classList.contains('open')) closeSidebar(); });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>