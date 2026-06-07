<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Upload Surat Izin - Mahasiswa</title>
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

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-title {
            color: #e8eaed;
            font-size: 22px;
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

        /* Form */
        .form-label {
            color: #e8eaed;
            font-weight: 500;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .form-label i {
            color: #4caf50;
            margin-right: 6px;
            font-size: 12px;
        }

        .form-control {
            background: #2a2a2a;
            border: 1px solid #3c4043;
            color: #e8eaed;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-control:focus {
            background: #2a2a2a;
            border-color: #4caf50;
            color: #e8eaed;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
            outline: none;
        }

        .form-text {
            color: #6c757d;
            font-size: 11px;
            margin-top: 5px;
        }

        /* Buttons */
        .btn-submit {
            background: #4caf50;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #43a047;
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
        .alert-success {
            background: #1a2c1a;
            border: 1px solid #4caf50;
            color: #9aef9a;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-success i {
            margin-right: 8px;
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

        .alert-danger i {
            margin-right: 8px;
        }

        /* ========== UPLOAD AREA ========== */
        .upload-area {
            position: relative;
            width: 100%;
        }

        .upload-box {
            background: #2a2a2a;
            border: 2px dashed #3c4043;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .upload-box:hover {
            border-color: #4caf50;
            background: rgba(76, 175, 80, 0.05);
        }

        .upload-box.drag-over {
            border-color: #4caf50;
            background: rgba(76, 175, 80, 0.1);
        }

        .upload-box i {
            font-size: 48px;
            color: #4caf50;
            margin-bottom: 16px;
        }

        .upload-box p {
            color: #e8eaed;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .upload-box .upload-hint {
            color: #9aa0a6;
            font-size: 12px;
        }

        .upload-box .btn-browse {
            background: #4caf50;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            color: white;
            font-size: 13px;
            font-weight: 500;
            margin-top: 16px;
            display: inline-block;
            cursor: pointer;
            transition: all 0.2s;
        }

        .upload-box .btn-browse:hover {
            background: #43a047;
        }

        .file-input-hidden {
            display: none;
        }

        .file-info-area {
            margin-top: 16px;
            display: none;
        }

        .file-info-card {
            background: #1e1e1e;
            border: 1px solid #4caf50;
            border-radius: 10px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .file-info-card i {
            font-size: 28px;
            color: #4caf50;
        }

        .file-details {
            flex: 1;
        }

        .file-name {
            color: #e8eaed;
            font-size: 13px;
            font-weight: 500;
            word-break: break-all;
        }

        .file-size {
            color: #9aa0a6;
            font-size: 11px;
            margin-top: 4px;
        }

        /* Tombol Hapus - Background Merah, Teks Merah Muda, Ikon Kecil */
        .btn-remove-file {
            background: #dc3545;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            color: #ff9aa2;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-remove-file i {
            font-size: 12px;
            color: #ff9aa2;
        }

        .btn-remove-file:hover {
            background: #c82333;
            color: #ff9aa2;
        }

        .format-hint {
            margin-top: 12px;
            font-size: 11px;
            color: #6c757d;
            text-align: center;
        }

        .format-hint i {
            margin-right: 4px;
        }

        /* Custom Select */
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

        .search-box {
            padding: 10px;
            border-bottom: 1px solid #3c4043;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-box i {
            color: #9aa0a6;
            font-size: 14px;
        }

        .search-box input {
            background: #2a2a2a;
            border: none;
            color: #e8eaed;
            width: 100%;
            outline: none;
            font-size: 13px;
        }

        .search-box input::placeholder {
            color: #5f6368;
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
                padding: 20px;
            }

            .page-title {
                font-size: 20px;
            }

            .form-label {
                font-size: 12px;
            }

            .form-control, .custom-select-trigger {
                padding: 8px 12px;
                font-size: 13px;
            }

            .btn-submit, .btn-cancel {
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

            .alert-success, .alert-danger {
                padding: 10px 14px;
                font-size: 12px;
            }

            .option-item {
                padding: 8px 12px;
                font-size: 12px;
            }

            .upload-box {
                padding: 20px 16px;
            }

            .upload-box i {
                font-size: 36px;
            }

            .upload-box p {
                font-size: 13px;
            }

            .btn-remove-file {
                padding: 5px 12px;
                font-size: 11px;
            }

            .btn-remove-file i {
                font-size: 11px;
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
            <a href="<?= BASEURL; ?>/MahasiswaController/absensi" class="nav-link">
                <i class="fas fa-calendar-alt"></i> Lihat Absensi
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= BASEURL; ?>/MahasiswaController/uploadSurat" class="nav-link active">
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
        <div class="page-header">
            <h3 class="page-title">
                <i class="fas fa-upload"></i> Upload Surat Izin
            </h3>
        </div>
        <hr>

        <!-- Alert Messages -->
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

        <!-- Upload Form -->
        <form action="<?= BASEURL; ?>/MahasiswaController/uploadSuratStore" method="POST" enctype="multipart/form-data">
            <div class="row g-4">
                <!-- Mata Kuliah - Custom Select -->
                <div class="col-12">
                    <label class="form-label">
                        <i class="fas fa-book"></i> Mata Kuliah <span class="text-danger">*</span>
                    </label>
                    <div class="custom-select-container" id="matkulSelectContainer">
                        <div class="custom-select-trigger" id="matkulSelectTrigger">
                            <span id="selectedMatkulText">-- Pilih Mata Kuliah --</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="custom-select-options" id="matkulSelectOptions">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="matkulSearchInput" placeholder="Cari mata kuliah...">
                            </div>
                            <div class="options-list" id="matkulOptionsList">
                                <?php foreach ($data['matkul_list'] as $matkul): ?>
                                <div class="option-item" data-value="<?= $matkul['id']; ?>">
                                    <i class="fas fa-book-open"></i> <?= htmlspecialchars($matkul['kode']); ?> - <?= htmlspecialchars($matkul['nama']); ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="matkul_id" id="selectedMatkulValue" value="">
                    <?php if (empty($data['matkul_list'])): ?>
                    <div class="form-text text-warning">
                        <i class="fas fa-info-circle"></i> Belum ada data absensi, silakan hubungi admin.
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Jenis Surat - Custom Select -->
                <div class="col-12">
                    <label class="form-label">
                        <i class="fas fa-file-alt"></i> Jenis Surat <span class="text-danger">*</span>
                    </label>
                    <div class="custom-select-container" id="jenisSuratSelectContainer">
                        <div class="custom-select-trigger" id="jenisSuratSelectTrigger">
                            <span id="selectedJenisSuratText">-- Pilih Jenis Surat --</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="custom-select-options" id="jenisSuratSelectOptions">
                            <div class="options-list" id="jenisSuratOptionsList">
                                <div class="option-item" data-value="sakit">
                                    <i class="fas fa-thermometer-half"></i> Surat Keterangan Sakit
                                </div>
                                <div class="option-item" data-value="izin">
                                    <i class="fas fa-check-circle"></i> Surat Izin
                                </div>
                                <div class="option-item" data-value="dispensasi">
                                    <i class="fas fa-clock"></i> Surat Dispensasi
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="jenis_surat" id="selectedJenisSuratValue" value="">
                </div>

                <!-- Keterangan -->
                <div class="col-12">
                    <label class="form-label">
                        <i class="fas fa-comment"></i> Keterangan
                    </label>
                    <textarea name="keterangan" class="form-control" rows="3" 
                              placeholder="Isi keterangan tambahan (opsional)..."></textarea>
                </div>

                <!-- Upload File Area -->
                <div class="col-12">
                    <label class="form-label">
                        <i class="fas fa-paperclip"></i> Upload File <span class="text-danger">*</span>
                    </label>
                    <div class="upload-area">
                        <div class="upload-box" id="uploadBox">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Klik atau seret file ke sini</p>
                            <div class="upload-hint">Support: PDF, JPG, JPEG, PNG (Max 2MB)</div>
                            <div class="btn-browse" id="browseBtn">Pilih File</div>
                        </div>
                        <input type="file" name="file_surat" class="file-input-hidden" id="fileInput" accept=".pdf,.jpg,.jpeg,.png" required>
                        
                        <div class="file-info-area" id="fileInfoArea">
                            <div class="file-info-card">
                                <i class="fas fa-file-pdf" id="fileIcon"></i>
                                <div class="file-details">
                                    <div class="file-name" id="fileName"></div>
                                    <div class="file-size" id="fileSize"></div>
                                </div>
                                <button type="button" class="btn-remove-file" id="removeFileBtn">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </div>
                        </div>
                        <div class="format-hint">
                            <i class="fas fa-info-circle"></i> Format yang diperbolehkan: PDF, JPG, JPEG, PNG (Maksimal 2MB)
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-3 flex-wrap">
                <button type="submit" name="submit" class="btn-submit" <?= empty($data['matkul_list']) ? 'disabled' : ''; ?>>
                    <i class="fas fa-upload"></i> Upload
                </button>
                <a href="<?= BASEURL; ?>/MahasiswaController/index" class="btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // ========== CUSTOM SELECT MATA KULIAH ==========
    function initCustomSelect(containerId, triggerId, optionsId, selectedTextId, selectedValueId, hasSearch = false) {
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

        if (hasSearch) {
            const searchInput = document.getElementById('matkulSearchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    container.querySelectorAll('.option-item').forEach(option => {
                        const text = option.textContent.toLowerCase();
                        if (text.includes(searchTerm)) {
                            option.style.display = 'flex';
                        } else {
                            option.style.display = 'none';
                        }
                    });
                });
            }
        }

        document.addEventListener('click', function(event) {
            if (!container.contains(event.target)) {
                optionsContainer.classList.remove('show');
                trigger.classList.remove('open');
            }
        });
    }

    // Initialize custom selects
    initCustomSelect('matkulSelectContainer', 'matkulSelectTrigger', 'matkulSelectOptions', 'selectedMatkulText', 'selectedMatkulValue', true);
    initCustomSelect('jenisSuratSelectContainer', 'jenisSuratSelectTrigger', 'jenisSuratSelectOptions', 'selectedJenisSuratText', 'selectedJenisSuratValue', false);

    // ========== UPLOAD AREA FUNCTIONALITY ==========
    const fileInput = document.getElementById('fileInput');
    const uploadBox = document.getElementById('uploadBox');
    const browseBtn = document.getElementById('browseBtn');
    const fileInfoArea = document.getElementById('fileInfoArea');
    const fileNameSpan = document.getElementById('fileName');
    const fileSizeSpan = document.getElementById('fileSize');
    const fileIcon = document.getElementById('fileIcon');
    const removeFileBtn = document.getElementById('removeFileBtn');

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function getFileIcon(fileName) {
        const ext = fileName.split('.').pop().toLowerCase();
        if (ext === 'pdf') return 'fas fa-file-pdf';
        if (ext === 'jpg' || ext === 'jpeg') return 'fas fa-file-image';
        if (ext === 'png') return 'fas fa-file-image';
        return 'fas fa-file';
    }

    function updateFileInfo(file) {
        if (file) {
            fileNameSpan.textContent = file.name;
            fileSizeSpan.textContent = formatFileSize(file.size);
            fileIcon.className = getFileIcon(file.name);
            fileInfoArea.style.display = 'block';
            uploadBox.style.display = 'none';
        } else {
            fileInfoArea.style.display = 'none';
            uploadBox.style.display = 'block';
            fileInput.value = '';
        }
    }

    browseBtn.addEventListener('click', () => {
        fileInput.click();
    });

    uploadBox.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            updateFileInfo(this.files[0]);
        }
    });

    removeFileBtn.addEventListener('click', () => {
        updateFileInfo(null);
    });

    uploadBox.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadBox.classList.add('drag-over');
    });

    uploadBox.addEventListener('dragleave', (e) => {
        e.preventDefault();
        uploadBox.classList.remove('drag-over');
    });

    uploadBox.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadBox.classList.remove('drag-over');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            const validTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            if (validTypes.includes(file.type) && file.size <= 2 * 1024 * 1024) {
                fileInput.files = files;
                updateFileInfo(file);
            } else {
                alert('File tidak valid! Gunakan PDF, JPG, JPEG, PNG (Max 2MB)');
            }
        }
    });

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