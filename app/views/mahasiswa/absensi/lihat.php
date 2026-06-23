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

        /* Filter Semester - Custom Select */
        .filter-semester {
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            background: rgba(255, 255, 255, 0.03);
            padding: 12px 16px;
            border-radius: 10px;
        }

        .filter-semester label {
            color: #e8eaed;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-semester label i {
            color: #4caf50;
            font-size: 14px;
        }

        /* Custom Select Styles */
        .custom-select-container {
            position: relative;
            width: 220px;
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

        .filter-semester span {
            font-size: 11px;
            color: #9aa0a6;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .filter-semester span i {
            color: #2196f3;
            font-size: 12px;
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

        .rekap-angkatan {
            color: #4caf50;
            font-size: 11px;
            margin-left: 8px;
            display: inline-block;
        }

        .rekap-angkatan i {
            margin-right: 3px;
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

        .empty-rekap {
            text-align: center;
            padding: 30px;
            color: #9aa0a6;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
        }

        .empty-rekap i {
            font-size: 40px;
            margin-bottom: 10px;
            display: block;
        }

        .empty-rekap small {
            color: #5f6368;
            display: block;
            margin-top: 8px;
        }

        /* Tabel */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 8px;
            -webkit-overflow-scrolling: touch;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 550px;
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

        /* ===== CLASS BADGE ===== */
        .class-badge {
            display: inline-block;
            padding: 3px 10px;
            background: rgba(76, 175, 80, 0.1);
            border-radius: 4px;
            color: #4caf50;
            font-size: 12px;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            border: 1px solid rgba(76, 175, 80, 0.12);
            white-space: nowrap;
            letter-spacing: 0.2px;
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
            min-width: 85px;
            min-height: 30px;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }

        .badge-status i {
            font-size: 12px;
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

        @media (max-width: 768px) {
            .navbar-custom {
                padding: 10px 16px;
                min-height: 56px;
            }

            .content-card {
                margin: 16px;
                padding: 18px;
            }

            .page-title {
                font-size: 20px;
            }

            .filter-semester {
                flex-direction: column;
                align-items: flex-start;
            }

            .custom-select-container {
                width: 100%;
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
                min-width: 480px;
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
                min-width: 75px;
                min-height: 26px;
            }

            .badge-status i {
                font-size: 10px;
            }

            .class-badge {
                font-size: 10px;
                padding: 2px 8px;
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

            .btn-back, .btn-pagination {
                padding: 6px 16px;
                font-size: 12px;
            }

            .pagination-container {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .badge-status {
                padding: 3px 8px;
                font-size: 9px;
                min-width: 65px;
                min-height: 22px;
                gap: 4px;
            }

            .badge-status i {
                font-size: 9px;
            }

            .class-badge {
                font-size: 9px;
                padding: 2px 6px;
            }

            .data-table {
                min-width: 400px;
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
        <div class="navbar-brand">
            <i class="fas fa-graduation-cap"></i>
            <span>SENMA</span>
        </div>
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
        <!-- ===== BRANDING SEBAGAI ITEM MENU PERTAMA ===== -->
        <li class="sidebar-brand">
            <i class="fas fa-graduation-cap"></i>
            <span>SENMA</span>
        </li>

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
            <a href="<?= BASEURL; ?>/MahasiswaController/historiSurat" class="nav-link">
                <i class="fas fa-history"></i> Histori Surat Izin
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

        <!-- Filter Semester - CUSTOM SELECT -->
        <div class="filter-semester">
            <label><i class="fas fa-layer-group"></i> Filter Mata Kuliah:</label>
            <div class="custom-select-container" id="semesterSelectContainer">
                <div class="custom-select-trigger" id="semesterSelectTrigger">
                    <span id="selectedSemesterText">
                        <?php 
                        $selected_semester_display = isset($_GET['semester']) ? 'Semester ' . $_GET['semester'] : 'Semua Semester';
                        echo $selected_semester_display;
                        ?>
                    </span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="custom-select-options" id="semesterSelectOptions">
                    <div class="options-list" id="semesterOptionsList">
                        <div class="option-item <?= (!isset($_GET['semester']) || $_GET['semester'] == 'semua') ? 'selected' : ''; ?>" data-value="semua">
                            <i class="fas fa-list"></i> Semua Semester
                        </div>
                        <?php for ($i = 1; $i <= 8; $i++): ?>
                        <div class="option-item <?= (isset($_GET['semester']) && $_GET['semester'] == $i) ? 'selected' : ''; ?>" data-value="<?= $i; ?>">
                            <i class="fas fa-calendar-alt"></i> Semester <?= $i; ?>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <span>
                <i class="fas fa-info-circle"></i> Filter hanya untuk Rekap Kehadiran
            </span>
        </div>

        <!-- Rekap per Mata Kuliah (TERFILTER SEMESTER) -->
        <?php 
        $selected_semester = isset($_GET['semester']) ? $_GET['semester'] : 'semua';
        $filtered_rekap = [];
        
        if ($selected_semester == 'semua') {
            $filtered_rekap = $data['rekap_matkul'];
        } else {
            foreach ($data['rekap_matkul'] as $rekap) {
                if ($rekap['semester'] == $selected_semester) {
                    $filtered_rekap[] = $rekap;
                }
            }
        }
        ?>
        
        <?php if (!empty($filtered_rekap)): ?>
        <div class="mb-4">
            <div class="rekap-title">
                <i class="fas fa-chart-pie"></i> Rekap Kehadiran per Mata Kuliah
                <?php if ($selected_semester != 'semua'): ?>
                    <span style="font-size: 12px; color: #4caf50;"> (Semester <?= $selected_semester; ?>)</span>
                <?php endif; ?>
            </div>
            <?php foreach ($filtered_rekap as $rekap): ?>
            <?php 
                $persen = $rekap['total_pertemuan'] > 0 ? round(($rekap['hadir'] / $rekap['total_pertemuan']) * 100, 1) : 0;
                $jumlah_pertemuan = $rekap['jumlah_pertemuan'] ?? $rekap['total_pertemuan'];
            ?>
            <div class="rekap-card">
                <div class="rekap-header">
                    <div>
                        <span class="rekap-matkul"><?= htmlspecialchars($rekap['nama']); ?></span>
                        <span class="rekap-code">(<?= htmlspecialchars($rekap['kode']); ?>)</span>
                        <?php if (isset($rekap['angkatan']) && !empty($rekap['angkatan'])): ?>
                        <span class="rekap-angkatan">
                            <i class="fas fa-calendar-alt"></i> Angkatan <?= $rekap['angkatan']; ?>
                        </span>
                        <?php endif; ?>
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
        <?php else: ?>
        <div class="empty-rekap">
            <i class="fas fa-folder-open"></i>
            <?php if ($selected_semester != 'semua'): ?>
                Belum ada mata kuliah untuk Semester <?= $selected_semester; ?>
            <?php else: ?>
                <?php 
                // Ambil data mahasiswa untuk menampilkan informasi angkatan
                $mahasiswaModel = $this->model('Mahasiswa');
                $userId = $_SESSION['user_id'];
                $dataMahasiswa = $mahasiswaModel->getMahasiswaByUserId($userId);
                $mahasiswaId = $dataMahasiswa['id'] ?? 0;
                
                $matkulModel = $this->model('MataKuliah');
                $matkul_list = $matkulModel->getMahasiswaByMatkulId($mahasiswaId);
                ?>
                <?php if (empty($matkul_list)): ?>
                    Belum ada mata kuliah yang terdaftar untuk angkatan Anda (<?= $dataMahasiswa['angkatan'] ?? 'Tahun tidak diketahui'; ?>)
                    <small><i class="fas fa-info-circle"></i> Silakan hubungi admin untuk mendaftarkan mata kuliah.</small>
                <?php else: ?>
                    Belum ada data absensi untuk mata kuliah Anda
                    <small><i class="fas fa-info-circle"></i> Silakan hubungi dosen untuk mengisi absensi.</small>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Tabel Riwayat Absensi -->
        <div class="rekap-title" style="margin-top: 30px;">
            <i class="fas fa-history"></i> Histori Absensi
        </div>
        
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Mata Kuliah</th>
                        <th>Kelas</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // PAGINATION: 10 data per halaman
                    $limit = 10;
                    $total_data = count($data['absensi']);
                    $total_pages = ceil($total_data / $limit);
                    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    if ($current_page < 1) $current_page = 1;
                    if ($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages;
                    
                    $start_index = ($current_page - 1) * $limit;
                    $display_data = array_slice($data['absensi'], $start_index, $limit);
                    ?>
                    
                    <?php if (empty($display_data)): ?>
                    <tr class="empty-row">
                        <td colspan="5" class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            Belum ada data absensi
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php $no = $start_index + 1; foreach ($display_data as $abs): ?>
                        <?php 
                        // ===== FORMAT KELAS =====
                        // Format: [PRODI]-[KODE_KELAS]-[TANGGAL_YYMMDD]
                        
                        // 1. Ambil PRODI dari kode mata kuliah (2 huruf pertama)
                        $prodi = isset($abs['kode']) ? substr($abs['kode'], 0, 2) : 'XX';
                        
                        // 2. Ambil KODE_KELAS dari data kelas atau generate
                        $kelas_raw = $abs['kelas'] ?? '';
                        if (!empty($kelas_raw)) {
                            $parts = explode('-', $kelas_raw);
                            if (count($parts) >= 2) {
                                $kode_kelas = $parts[1] . '-' . ($parts[2] ?? '00');
                            } else {
                                $kode_kelas = '001';
                            }
                        } else {
                            $kode_kelas = '001';
                        }
                        
                        // 3. Ambil TANGGAL format YYMMDD
                        $tanggal_kelas = date('ymd', strtotime($abs['tanggal']));
                        
                        // 4. Gabungkan menjadi format kelas
                        $kelas_format = $prodi . '-' . $kode_kelas . '-' . $tanggal_kelas;
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d-m-Y', strtotime($abs['tanggal'])); ?></td>
                            <td><?= htmlspecialchars($abs['mata_kuliah']); ?> (<?= $abs['kode']; ?>)<?= isset($abs['sks']) ? ' - ' . $abs['sks'] . ' SKS' : ''; ?></td>
                            <td><span class="class-badge"><?= htmlspecialchars($kelas_format); ?></span></td>
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
                <a href="?page=<?= $current_page - 1; ?><?= ($selected_semester != 'semua') ? '&semester=' . $selected_semester : ''; ?>" class="btn-pagination">
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </a>
                <?php else: ?>
                <button class="btn-pagination" disabled>
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </button>
                <?php endif; ?>
                
                <?php if ($current_page < $total_pages): ?>
                <a href="?page=<?= $current_page + 1; ?><?= ($selected_semester != 'semua') ? '&semester=' . $selected_semester : ''; ?>" class="btn-pagination">
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
    backdrop.addEventListener('click', closeSidebar);

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && sideMenu.classList.contains('open')) {
            closeSidebar();
        }
    });

    // ========== CUSTOM SELECT FOR SEMESTER FILTER ==========
    const semesterTrigger = document.getElementById('semesterSelectTrigger');
    const semesterOptionsContainer = document.getElementById('semesterSelectOptions');
    const semesterSelectedText = document.getElementById('selectedSemesterText');

    function toggleSemesterDropdown() {
        semesterOptionsContainer.classList.toggle('show');
        semesterTrigger.classList.toggle('open');
    }

    function selectSemesterOption(value, text) {
        semesterSelectedText.textContent = text;
        
        semesterOptionsContainer.querySelectorAll('.option-item').forEach(opt => {
            opt.classList.remove('selected');
        });
        
        const selectedOpt = Array.from(semesterOptionsContainer.querySelectorAll('.option-item')).find(
            opt => opt.getAttribute('data-value') === value
        );
        if (selectedOpt) selectedOpt.classList.add('selected');
        
        semesterOptionsContainer.classList.remove('show');
        semesterTrigger.classList.remove('open');
        
        let url = '<?= BASEURL; ?>/MahasiswaController/absensi';
        if (value !== 'semua') {
            url += '?semester=' + value;
        }
        window.location.href = url;
    }

    semesterTrigger.addEventListener('click', toggleSemesterDropdown);

    semesterOptionsContainer.querySelectorAll('.option-item').forEach(option => {
        option.addEventListener('click', () => {
            const value = option.getAttribute('data-value');
            const text = option.textContent.trim();
            selectSemesterOption(value, text);
        });
    });

    document.addEventListener('click', function(event) {
        const container = document.getElementById('semesterSelectContainer');
        if (!container.contains(event.target)) {
            semesterOptionsContainer.classList.remove('show');
            semesterTrigger.classList.remove('open');
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>