<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title><?= $data['judul_halaman'] ?? 'Data Mata Kuliah' ?> - Admin</title>
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

        /* Filter Section */
        .filter-section {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            border: 1px solid #2a2a2a;
        }

        .filter-title {
            color: #e8eaed;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .filter-title i {
            color: #4caf50;
            margin-right: 8px;
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 150px;
        }

        .filter-group label {
            color: #9aa0a6;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
            display: block;
        }

        .filter-group label i {
            margin-right: 4px;
        }

        /* Custom Select Styles */
        .custom-select-container {
            position: relative;
            width: 100%;
        }

        .custom-select-trigger {
            background: #2a2a2a;
            border: 1px solid #3c4043;
            border-radius: 8px;
            padding: 8px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s;
            color: #e8eaed;
            font-size: 13px;
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
            max-height: 220px;
        }

        .option-item {
            padding: 10px 12px;
            cursor: pointer;
            transition: all 0.2s;
            color: #e8eaed;
            font-size: 13px;
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

        .filter-active {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(76, 175, 80, 0.15);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            color: #4caf50;
        }

        .filter-active i {
            font-size: 10px;
            cursor: pointer;
        }

        .filter-active i:hover {
            color: #dc3545;
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
            cursor: pointer;
        }

        .btn-delete:hover {
            background: #c82333;
            color: white;
        }

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

        .table-wrapper {
            overflow-x: auto;
            border-radius: 8px;
            -webkit-overflow-scrolling: touch;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
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

        .badge-sks {
            background: #4caf50;
            color: #121212;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .aksi-cell {
            white-space: nowrap;
            min-width: 80px;
        }

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
        }

        .confirm-icon.delete-icon i {
            color: #ff9800;
        }

        .confirm-icon.logout-icon i {
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

        .confirm-message strong {
            color: #e8eaed;
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

        .confirm-buttons .btn-delete-confirm {
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

        .confirm-buttons .btn-delete-confirm:hover {
            background: #c82333;
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

            .btn-back, .btn-pagination {
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

            .btn-edit span, .btn-delete span {
                display: none;
            }
            
            .btn-edit, .btn-delete {
                padding: 6px 10px !important;
                font-size: 14px !important;
            }
            
            .btn-edit i, .btn-delete i {
                margin: 0 !important;
            }
            
            .aksi-cell {
                white-space: nowrap;
                min-width: 70px;
            }

            .pagination-container {
                justify-content: center;
            }

            .filter-row {
                flex-direction: column;
            }

            .filter-group {
                width: 100%;
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

<!-- Custom Confirm Dialog untuk DELETE -->
<div id="customConfirmDeleteOverlay" class="custom-confirm-overlay">
    <div class="custom-confirm-dialog">
        <div class="confirm-icon delete-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="confirm-title">Konfirmasi Hapus</div>
        <div class="confirm-message" id="confirmDeleteMessage">
            Apakah Anda yakin ingin menghapus data ini?
        </div>
        <div class="confirm-buttons">
            <button class="btn-cancel-confirm" id="confirmDeleteCancelBtn">
                <i class="fas fa-times"></i> Batal
            </button>
            <button class="btn-delete-confirm" id="confirmDeleteBtn">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>
    </div>
</div>

<!-- Custom Confirm Dialog untuk LOGOUT -->
<div id="customConfirmLogoutOverlay" class="custom-confirm-overlay">
    <div class="custom-confirm-dialog">
        <div class="confirm-icon logout-icon">
            <i class="fas fa-sign-out-alt"></i>
        </div>
        <div class="confirm-title">Konfirmasi Logout</div>
        <div class="confirm-message" id="confirmLogoutMessage">
            Apakah Anda yakin ingin keluar dari sistem?
        </div>
        <div class="confirm-buttons">
            <button class="btn-cancel-confirm" id="confirmLogoutCancelBtn">
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
        <div class="page-header">
            <h3 class="page-title"><i class="fas fa-book"></i> <?= $data['judul_halaman'] ?></h3>
            <a href="<?= BASEURL; ?>/AdminController/matakuliahCreate" class="btn-add">
                <i class="fas fa-plus"></i> Tambah Mata Kuliah
            </a>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
        <div class="alert-success"><i class="fas fa-check-circle"></i> <?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert-danger"><i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- FILTER SECTION - TANPA TOMBOL CARI & RESET -->
        <div class="filter-section">
            <div class="filter-title">
                <i class="fas fa-filter"></i> Filter Data
            </div>
            <form method="GET" action="<?= BASEURL; ?>/AdminController/matakuliah" id="filterForm">
                <div class="filter-row">
                    <!-- Filter Semester - CUSTOM SELECT -->
                    <div class="filter-group">
                        <label><i class="fas fa-layer-group"></i> Semester</label>
                        <input type="hidden" name="filter_semester" id="selectedSemesterValue" value="<?= isset($_GET['filter_semester']) ? htmlspecialchars($_GET['filter_semester']) : ''; ?>">
                        <div class="custom-select-container" id="semesterSelectContainer">
                            <div class="custom-select-trigger" id="semesterSelectTrigger">
                                <span id="selectedSemesterText">
                                    <?php 
                                    $selected_semester = isset($_GET['filter_semester']) ? $_GET['filter_semester'] : '';
                                    if ($selected_semester == '1') echo 'Semester 1';
                                    elseif ($selected_semester == '2') echo 'Semester 2';
                                    elseif ($selected_semester == '3') echo 'Semester 3';
                                    elseif ($selected_semester == '4') echo 'Semester 4';
                                    elseif ($selected_semester == '5') echo 'Semester 5';
                                    elseif ($selected_semester == '6') echo 'Semester 6';
                                    elseif ($selected_semester == '7') echo 'Semester 7';
                                    elseif ($selected_semester == '8') echo 'Semester 8';
                                    else echo '-- Semua Semester --';
                                    ?>
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="custom-select-options" id="semesterSelectOptions">
                                <div class="options-list" id="semesterOptionsList">
                                    <div class="option-item <?= ($selected_semester == '') ? 'selected' : ''; ?>" data-value="">
                                        <i class="fas fa-list"></i> -- Semua Semester --
                                    </div>
                                    <?php for ($i = 1; $i <= 8; $i++): ?>
                                    <div class="option-item <?= ($selected_semester == $i) ? 'selected' : ''; ?>" data-value="<?= $i; ?>">
                                        <i class="fas fa-calendar-alt"></i> Semester <?= $i; ?>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Prodi - CUSTOM SELECT (DENGAN KODE YANG BENAR) -->
                    <div class="filter-group">
                        <label><i class="fas fa-code-branch"></i> Program Studi</label>
                        <input type="hidden" name="filter_prodi" id="selectedProdiValue" value="<?= isset($_GET['filter_prodi']) ? htmlspecialchars($_GET['filter_prodi']) : ''; ?>">
                        <div class="custom-select-container" id="prodiSelectContainer">
                            <div class="custom-select-trigger" id="prodiSelectTrigger">
                                <span id="selectedProdiText">
                                    <?php 
                                    $selected_prodi = isset($_GET['filter_prodi']) ? $_GET['filter_prodi'] : '';
                                    $prodi_display = '';
                                    if ($selected_prodi == 'TI') $prodi_display = 'Teknik Informatika (TI)';
                                    elseif ($selected_prodi == 'SI') $prodi_display = 'Sistem Informasi (SI)';
                                    elseif ($selected_prodi == 'TK') $prodi_display = 'Teknik Komputer (TK)';
                                    elseif ($selected_prodi == 'MI') $prodi_display = 'Manajemen Informatika (MI)';
                                    elseif ($selected_prodi == 'KA') $prodi_display = 'Komputerisasi Akuntansi (KA)';
                                    elseif ($selected_prodi == 'TE') $prodi_display = 'Teknik Elektro (TE)';
                                    elseif ($selected_prodi == 'DKV') $prodi_display = 'Desain Komunikasi Visual (DKV)';
                                    elseif ($selected_prodi == 'BD') $prodi_display = 'Bisnis Digital (BD)';
                                    else $prodi_display = '-- Semua Prodi --';
                                    echo $prodi_display;
                                    ?>
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="custom-select-options" id="prodiSelectOptions">
                                <div class="options-list" id="prodiOptionsList">
                                    <div class="option-item" data-value="">
                                        <i class="fas fa-list"></i> -- Semua Prodi --
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'TI') ? 'selected' : ''; ?>" data-value="TI">
                                        <i class="fas fa-laptop-code"></i> Teknik Informatika (TI)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'SI') ? 'selected' : ''; ?>" data-value="SI">
                                        <i class="fas fa-database"></i> Sistem Informasi (SI)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'TK') ? 'selected' : ''; ?>" data-value="TK">
                                        <i class="fas fa-microchip"></i> Teknik Komputer (TK)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'MI') ? 'selected' : ''; ?>" data-value="MI">
                                        <i class="fas fa-chart-line"></i> Manajemen Informatika (MI)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'KA') ? 'selected' : ''; ?>" data-value="KA">
                                        <i class="fas fa-calculator"></i> Komputerisasi Akuntansi (KA)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'TE') ? 'selected' : ''; ?>" data-value="TE">
                                        <i class="fas fa-plug"></i> Teknik Elektro (TE)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'DKV') ? 'selected' : ''; ?>" data-value="DKV">
                                        <i class="fas fa-palette"></i> Desain Komunikasi Visual (DKV)
                                    </div>
                                    <div class="option-item <?= ($selected_prodi == 'BD') ? 'selected' : ''; ?>" data-value="BD">
                                        <i class="fas fa-chart-simple"></i> Bisnis Digital (BD)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter SKS - CUSTOM SELECT -->
                    <div class="filter-group">
                        <label><i class="fas fa-star"></i> SKS</label>
                        <input type="hidden" name="filter_sks" id="selectedSksValue" value="<?= isset($_GET['filter_sks']) ? htmlspecialchars($_GET['filter_sks']) : ''; ?>">
                        <div class="custom-select-container" id="sksSelectContainer">
                            <div class="custom-select-trigger" id="sksSelectTrigger">
                                <span id="selectedSksText">
                                    <?php 
                                    $selected_sks = isset($_GET['filter_sks']) ? $_GET['filter_sks'] : '';
                                    if ($selected_sks == '1') echo '1 SKS';
                                    elseif ($selected_sks == '2') echo '2 SKS';
                                    elseif ($selected_sks == '3') echo '3 SKS';
                                    elseif ($selected_sks == '4') echo '4 SKS';
                                    elseif ($selected_sks == '6') echo '6 SKS';
                                    else echo '-- Semua SKS --';
                                    ?>
                                </span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="custom-select-options" id="sksSelectOptions">
                                <div class="options-list" id="sksOptionsList">
                                    <div class="option-item <?= ($selected_sks == '') ? 'selected' : ''; ?>" data-value="">
                                        <i class="fas fa-list"></i> -- Semua SKS --
                                    </div>
                                    <div class="option-item <?= ($selected_sks == '1') ? 'selected' : ''; ?>" data-value="1">
                                        <i class="fas fa-star"></i> 1 SKS
                                    </div>
                                    <div class="option-item <?= ($selected_sks == '2') ? 'selected' : ''; ?>" data-value="2">
                                        <i class="fas fa-star"></i> 2 SKS
                                    </div>
                                    <div class="option-item <?= ($selected_sks == '3') ? 'selected' : ''; ?>" data-value="3">
                                        <i class="fas fa-star"></i> 3 SKS
                                    </div>
                                    <div class="option-item <?= ($selected_sks == '4') ? 'selected' : ''; ?>" data-value="4">
                                        <i class="fas fa-star"></i> 4 SKS
                                    </div>
                                    <div class="option-item <?= ($selected_sks == '6') ? 'selected' : ''; ?>" data-value="6">
                                        <i class="fas fa-star"></i> 6 SKS
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Active Filters Display -->
        <?php 
        $active_filters = [];
        if (isset($_GET['filter_semester']) && $_GET['filter_semester'] != '') {
            $active_filters[] = 'Semester ' . $_GET['filter_semester'];
        }
        if (isset($_GET['filter_prodi']) && $_GET['filter_prodi'] != '') {
            $prodi_name = '';
            if ($_GET['filter_prodi'] == 'TI') $prodi_name = 'Teknik Informatika (TI)';
            elseif ($_GET['filter_prodi'] == 'SI') $prodi_name = 'Sistem Informasi (SI)';
            elseif ($_GET['filter_prodi'] == 'TK') $prodi_name = 'Teknik Komputer (TK)';
            elseif ($_GET['filter_prodi'] == 'MI') $prodi_name = 'Manajemen Informatika (MI)';
            elseif ($_GET['filter_prodi'] == 'KA') $prodi_name = 'Komputerisasi Akuntansi (KA)';
            elseif ($_GET['filter_prodi'] == 'TE') $prodi_name = 'Teknik Elektro (TE)';
            elseif ($_GET['filter_prodi'] == 'DKV') $prodi_name = 'Desain Komunikasi Visual (DKV)';
            elseif ($_GET['filter_prodi'] == 'BD') $prodi_name = 'Bisnis Digital (BD)';
            $active_filters[] = $prodi_name;
        }
        if (isset($_GET['filter_sks']) && $_GET['filter_sks'] != '') {
            $active_filters[] = $_GET['filter_sks'] . ' SKS';
        }
        ?>
        <?php if (!empty($active_filters)): ?>
        <div style="margin-bottom: 20px; display: flex; gap: 8px; flex-wrap: wrap;">
            <?php foreach ($active_filters as $filter): ?>
            <span class="filter-active">
                <i class="fas fa-tag"></i> <?= $filter; ?>
            </span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Semester</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // PAGINATION: 10 data per halaman
                    $limit = 10;
                    $total_data = count($data['matakuliah']);
                    $total_pages = ceil($total_data / $limit);
                    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($current_page < 1) $current_page = 1;
                    if ($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages;
                    
                    $start_index = ($current_page - 1) * $limit;
                    $display_data = array_slice($data['matakuliah'], $start_index, $limit);
                    ?>
                    
                    <?php if (empty($display_data)): ?>
                    <tr class="empty-row">
                        <td colspan="6" class="text-center" style="color: #9aa0a6;">Tidak ada data mata kuliah yang sesuai filter</td>
                    </tr>
                    <?php else: ?>
                        <?php $no = $start_index + 1; foreach ($display_data as $mk): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><code><?= htmlspecialchars($mk['kode'] ?? '-'); ?></code></td>
                            <td><?= htmlspecialchars($mk['nama'] ?? '-'); ?></td>
                            <td><span class="badge-sks"><?= $mk['sks'] ?? '-'; ?> SKS</span></td>
                            <td>Semester <?= $mk['semester'] ?? '-'; ?></td>
                            <td class="aksi-cell">
                                <a href="<?= BASEURL; ?>/AdminController/matakuliahEdit/<?= $mk['id']; ?>" class="btn-edit">
                                    <i class="fas fa-edit"></i> <span>Edit</span>
                                </a>
                                <button class="btn-delete" onclick="showDeleteConfirmDialog('Apakah Anda yakin ingin menghapus mata kuliah <strong><?= htmlspecialchars($mk['nama']); ?></strong>?', '<?= BASEURL; ?>/AdminController/matakuliahDelete/<?= $mk['id']; ?>');">
                                    <i class="fas fa-trash"></i> <span>Hapus</span>
                                </button>
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
                // Build query string untuk pagination
                $query_params = [];
                if (isset($_GET['filter_semester']) && $_GET['filter_semester'] != '') {
                    $query_params[] = 'filter_semester=' . $_GET['filter_semester'];
                }
                if (isset($_GET['filter_prodi']) && $_GET['filter_prodi'] != '') {
                    $query_params[] = 'filter_prodi=' . $_GET['filter_prodi'];
                }
                if (isset($_GET['filter_sks']) && $_GET['filter_sks'] != '') {
                    $query_params[] = 'filter_sks=' . $_GET['filter_sks'];
                }
                $query_string = !empty($query_params) ? '&' . implode('&', $query_params) : '';
                ?>
                <?php if ($current_page > 1): ?>
                <a href="?page=<?= $current_page - 1; ?><?= $query_string; ?>" class="btn-pagination">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </a>
                <?php else: ?>
                <button class="btn-pagination" disabled>
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </button>
                <?php endif; ?>
                
                <?php if ($current_page < $total_pages): ?>
                <a href="?page=<?= $current_page + 1; ?><?= $query_string; ?>" class="btn-pagination">
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
    // ========== CUSTOM CONFIRM DIALOG FOR DELETE ==========
    const confirmDeleteOverlay = document.getElementById('customConfirmDeleteOverlay');
    const confirmDeleteMessage = document.getElementById('confirmDeleteMessage');
    const confirmDeleteCancelBtn = document.getElementById('confirmDeleteCancelBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    let pendingDeleteUrl = null;

    function showDeleteConfirmDialog(message, deleteUrl) {
        confirmDeleteMessage.innerHTML = message;
        pendingDeleteUrl = deleteUrl;
        confirmDeleteOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteConfirmDialog() {
        confirmDeleteOverlay.classList.remove('show');
        document.body.style.overflow = '';
        pendingDeleteUrl = null;
    }

    confirmDeleteCancelBtn.addEventListener('click', closeDeleteConfirmDialog);

    confirmDeleteBtn.addEventListener('click', function() {
        if (pendingDeleteUrl) {
            window.location.href = pendingDeleteUrl;
        }
        closeDeleteConfirmDialog();
    });

    // ========== CUSTOM CONFIRM DIALOG FOR LOGOUT ==========
    const confirmLogoutOverlay = document.getElementById('customConfirmLogoutOverlay');
    const confirmLogoutMessage = document.getElementById('confirmLogoutMessage');
    const confirmLogoutCancelBtn = document.getElementById('confirmLogoutCancelBtn');
    const confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
    const logoutBtn = document.getElementById('logoutBtn');
    const sideLogoutBtn = document.getElementById('sideLogoutBtn');

    let pendingLogoutUrl = null;

    function showLogoutConfirmDialog(message, logoutUrl) {
        confirmLogoutMessage.innerHTML = message;
        pendingLogoutUrl = logoutUrl;
        confirmLogoutOverlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeLogoutConfirmDialog() {
        confirmLogoutOverlay.classList.remove('show');
        document.body.style.overflow = '';
        pendingLogoutUrl = null;
    }

    function executeLogout() {
        if (pendingLogoutUrl) {
            window.location.href = pendingLogoutUrl;
        }
    }

    confirmLogoutCancelBtn.addEventListener('click', closeLogoutConfirmDialog);
    confirmLogoutBtn.addEventListener('click', executeLogout);

    logoutBtn.addEventListener('click', (e) => {
        e.preventDefault();
        showLogoutConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout');
    });

    sideLogoutBtn.addEventListener('click', (e) => {
        e.preventDefault();
        showLogoutConfirmDialog('Apakah Anda yakin ingin keluar dari sistem?', '<?= BASEURL; ?>/AuthController/logout');
    });

    confirmDeleteOverlay.addEventListener('click', function(event) {
        if (event.target === confirmDeleteOverlay) {
            closeDeleteConfirmDialog();
        }
    });

    confirmLogoutOverlay.addEventListener('click', function(event) {
        if (event.target === confirmLogoutOverlay) {
            closeLogoutConfirmDialog();
        }
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

    // ========== CUSTOM SELECT FOR ALL FILTERS ==========
    function initCustomSelect(containerId, triggerId, optionsId, selectedTextId, selectedValueId, formId) {
        const container = document.getElementById(containerId);
        const trigger = document.getElementById(triggerId);
        const optionsContainer = document.getElementById(optionsId);
        const selectedText = document.getElementById(selectedTextId);
        const selectedValue = document.getElementById(selectedValueId);
        const filterForm = document.getElementById(formId);

        function toggleDropdown() {
            optionsContainer.classList.toggle('show');
            trigger.classList.toggle('open');
        }

        function selectOption(value, text) {
            selectedText.textContent = text;
            selectedValue.value = value;
            
            // Update selected class
            optionsContainer.querySelectorAll('.option-item').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            const selectedOpt = Array.from(optionsContainer.querySelectorAll('.option-item')).find(
                opt => opt.getAttribute('data-value') === value
            );
            if (selectedOpt) selectedOpt.classList.add('selected');
            
            optionsContainer.classList.remove('show');
            trigger.classList.remove('open');
            
            // Submit form setelah memilih
            if (filterForm) {
                filterForm.submit();
            }
        }

        trigger.addEventListener('click', toggleDropdown);

        optionsContainer.querySelectorAll('.option-item').forEach(option => {
            option.addEventListener('click', () => {
                const value = option.getAttribute('data-value');
                const text = option.textContent.trim();
                selectOption(value, text);
            });
        });

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function(event) {
            if (container && !container.contains(event.target)) {
                optionsContainer.classList.remove('show');
                trigger.classList.remove('open');
            }
        });
    }

    // Init all custom selects
    initCustomSelect('semesterSelectContainer', 'semesterSelectTrigger', 'semesterSelectOptions', 'selectedSemesterText', 'selectedSemesterValue', 'filterForm');
    initCustomSelect('prodiSelectContainer', 'prodiSelectTrigger', 'prodiSelectOptions', 'selectedProdiText', 'selectedProdiValue', 'filterForm');
    initCustomSelect('sksSelectContainer', 'sksSelectTrigger', 'sksSelectOptions', 'selectedSksText', 'selectedSksValue', 'filterForm');
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>