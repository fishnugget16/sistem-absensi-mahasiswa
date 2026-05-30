<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title><?= $data['judul_halaman'] ?? 'Detail Surat Izin' ?> - Admin</title>
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
        }
        .navbar-left { display: flex; align-items: center; gap: 16px; }
        .navbar-brand { font-size: 18px; font-weight: 500; color: #e8eaed; text-decoration: none; display: flex; align-items: center; gap: 10px; }
        .navbar-brand i { color: #4caf50; font-size: 20px; }
        .toggle-btn { background: transparent; border: none; color: #e8eaed; font-size: 20px; cursor: pointer; display: flex; align-items: center; }
        .navbar-right { display: flex; align-items: center; gap: 16px; }
        .user-info { color: #9aa0a6; font-size: 14px; display: flex; align-items: center; gap: 8px; }
        .user-info i { color: #4caf50; font-size: 16px; }
        .logout-link { color: #dc3545 !important; font-size: 14px; text-decoration: none; display: flex; align-items: center; gap: 6px; cursor: pointer; }

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
        .sidebar-backdrop { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1040; display: none; }
        .sidebar-backdrop.show { display: block; }
        .side-menu-overlay .nav-menu { list-style: none; padding: 20px 16px; margin-top: 60px; }
        .side-menu-overlay .nav-item { margin-bottom: 8px; }
        .side-menu-overlay .nav-link { display: flex; align-items: center; gap: 14px; padding: 12px 16px; color: #9aa0a6; text-decoration: none; font-size: 14px; font-weight: 500; border-radius: 10px; transition: all 0.2s; }
        .side-menu-overlay .nav-link i { width: 22px; font-size: 16px; }
        .side-menu-overlay .nav-link:hover { background: rgba(255,255,255,0.05); color: #e8eaed; }
        .side-menu-overlay .nav-link.active { background: rgba(76,175,80,0.15); color: #4caf50; }
        .side-menu-overlay .nav-link.logout { color: #ef5350; margin-top: 30px; cursor: pointer; }

        /* ========== MAIN CONTENT ========== */
        .main-content { width: 100%; min-height: calc(100vh - 60px); }
        .content-card { background: #1e1e1e; border-radius: 12px; padding: 24px; margin: 24px; border: 1px solid #2a2a2a; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; flex-wrap: wrap; gap: 16px; }
        .page-title { color: #e8eaed; font-size: 22px; font-weight: 500; margin: 0; }
        .page-title i { color: #4caf50; margin-right: 10px; }
        hr { border-color: #2a2a2a; margin: 16px 0 24px 0; }

        /* Info Cards */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }
        .info-card {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 18px;
            border: 1px solid #2a2a2a;
            transition: all 0.2s;
        }
        .info-card:hover {
            border-color: #4caf50;
            background: rgba(76, 175, 80, 0.03);
        }
        .info-label {
            color: #9aa0a6;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .info-label i {
            color: #4caf50;
            width: 16px;
            font-size: 12px;
        }
        .info-value {
            color: #e8eaed;
            font-size: 15px;
            font-weight: 500;
            word-break: break-word;
        }
        .info-value small {
            color: #9aa0a6;
            font-weight: 400;
        }

        /* Badges */
        .badge-pending { background: rgba(255, 152, 0, 0.15); color: #ff9800; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; }
        .badge-approved { background: rgba(76, 175, 80, 0.15); color: #4caf50; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; }
        .badge-rejected { background: rgba(220, 53, 69, 0.15); color: #ef9a9a; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; }

        /* Buttons */
        .btn-back { background: #3c4043; border: none; padding: 8px 20px; border-radius: 6px; color: white; font-size: 13px; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .btn-back:hover { background: #4a4e54; color: white; }
        .btn-approve { background: #4caf50; border: none; padding: 10px 24px; border-radius: 6px; color: #121212; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-approve:hover { background: #43a047; transform: translateY(-1px); }
        .btn-reject { background: #dc3545; border: none; padding: 10px 24px; border-radius: 6px; color: white; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-reject:hover { background: #c82333; transform: translateY(-1px); }
        .btn-download { background: rgba(33, 150, 243, 0.15); border: 1px solid rgba(33, 150, 243, 0.3); padding: 8px 20px; border-radius: 6px; color: #90caf9; font-size: 13px; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .btn-download:hover { background: #2196f3; border-color: #2196f3; color: white; }

        /* Form */
        .form-label { color: #e8eaed; font-weight: 500; font-size: 13px; margin-bottom: 8px; }
        .form-label i { color: #4caf50; margin-right: 6px; }
        .form-control { background: #2a2a2a; border: 1px solid #3c4043; color: #e8eaed; border-radius: 8px; padding: 10px 12px; font-size: 14px; transition: all 0.2s; }
        .form-control:focus { background: #2a2a2a; border-color: #4caf50; color: #e8eaed; box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2); outline: none; }

        /* Alert */
        .alert-success { background: #1a2c1a; border: 1px solid #4caf50; color: #9aef9a; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-danger { background: #2c1a1a; border: 1px solid #dc3545; color: #ef9a9a; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; gap: 8px; }

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
        .custom-confirm-overlay.show { display: flex; }
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
        .confirm-icon { text-align: center; margin-bottom: 20px; }
        .confirm-icon i { font-size: 56px; color: #dc3545; }
        .confirm-title { text-align: center; color: #e8eaed; font-size: 20px; font-weight: 500; margin-bottom: 8px; }
        .confirm-message { text-align: center; color: #9aa0a6; font-size: 14px; margin-bottom: 24px; line-height: 1.5; }
        .confirm-buttons { display: flex; gap: 12px; justify-content: center; }
        .confirm-buttons .btn-cancel-confirm { background: #3c4043; border: none; padding: 10px 24px; border-radius: 8px; color: white; font-size: 14px; font-weight: 500; cursor: pointer; }
        .confirm-buttons .btn-cancel-confirm:hover { background: #4a4e54; }
        .confirm-buttons .btn-logout-confirm { background: #dc3545; border: none; padding: 10px 24px; border-radius: 8px; color: white; font-size: 14px; font-weight: 500; cursor: pointer; }
        .confirm-buttons .btn-logout-confirm:hover { background: #c82333; }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 992px) {
            .info-grid { gap: 12px; }
            .info-card { padding: 14px; }
            .info-value { font-size: 14px; }
        }

        @media (max-width: 768px) {
            .navbar-custom { padding: 10px 16px; }
            .content-card { margin: 16px; padding: 20px; }
            .page-title { font-size: 20px; }
            .info-grid { grid-template-columns: 1fr; gap: 12px; }
            .info-card { padding: 14px; }
            .info-value { font-size: 13px; }
            .btn-approve, .btn-reject { width: 100%; justify-content: center; margin-bottom: 10px; }
            .btn-download { width: 100%; justify-content: center; }
            .user-info span, .logout-link span, .navbar-brand span { display: none; }
        }

        @media (min-width: 769px) and (max-width: 992px) {
            .content-card { margin: 20px; }
        }

        @media (min-width: 1400px) {
            .content-card { margin: 28px 40px; padding: 28px; }
            .info-card { padding: 20px; }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar-custom">
    <div class="navbar-left">
        <button class="toggle-btn" id="toggleSidebar"><i class="fas fa-bars"></i></button>
        <a href="#" class="navbar-brand" id="brandToggle"><i class="fas fa-graduation-cap"></i> <span>Absensi OOP</span></a>
    </div>
    <div class="navbar-right">
        <span class="user-info"><i class="fas fa-user-circle"></i> <span><?= $_SESSION['nama'] ?? 'Admin'; ?></span></span>
        <a href="#" class="logout-link" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
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

        <?php if ($data['surat']): ?>
        <!-- Info Grid -->
        <div class="info-grid">
            <div class="info-card">
                <div class="info-label"><i class="fas fa-user"></i> Mahasiswa</div>
                <div class="info-value"><?= htmlspecialchars($data['surat']['mahasiswa_nama'] ?? '-'); ?></div>
            </div>
            <div class="info-card">
                <div class="info-label"><i class="fas fa-id-card"></i> NIM</div>
                <div class="info-value"><?= htmlspecialchars($data['surat']['nim'] ?? '-'); ?></div>
            </div>
            <div class="info-card">
                <div class="info-label"><i class="fas fa-graduation-cap"></i> Program Studi</div>
                <div class="info-value"><?= htmlspecialchars($data['surat']['prodi'] ?? '-'); ?></div>
            </div>
            <div class="info-card">
                <div class="info-label"><i class="fas fa-book"></i> Mata Kuliah</div>
                <div class="info-value"><?= htmlspecialchars($data['surat']['mata_kuliah'] ?? '-'); ?> <small>(<?= $data['surat']['kode'] ?? '-'; ?>)</small></div>
            </div>
            <div class="info-card">
                <div class="info-label"><i class="fas fa-tag"></i> Jenis Surat</div>
                <div class="info-value"><?= ucfirst($data['surat']['jenis'] ?? '-'); ?></div>
            </div>
            <div class="info-card">
                <div class="info-label"><i class="fas fa-calendar"></i> Tanggal Upload</div>
                <div class="info-value"><?= date('d-m-Y H:i:s', strtotime($data['surat']['tanggal_upload'])); ?></div>
            </div>
            <div class="info-card">
                <div class="info-label"><i class="fas fa-info-circle"></i> Status</div>
                <div class="info-value">
                    <?php if ($data['surat']['status'] == 'pending'): ?>
                        <span class="badge-pending"><i class="fas fa-hourglass-half"></i> Menunggu</span>
                    <?php elseif ($data['surat']['status'] == 'disetujui'): ?>
                        <span class="badge-approved"><i class="fas fa-check-circle"></i> Disetujui</span>
                    <?php else: ?>
                        <span class="badge-rejected"><i class="fas fa-times-circle"></i> Ditolak</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Keterangan Mahasiswa -->
        <div class="info-card" style="margin-bottom: 16px;">
            <div class="info-label"><i class="fas fa-comment"></i> Keterangan Mahasiswa</div>
            <div class="info-value"><?= nl2br(htmlspecialchars($data['surat']['keterangan'] ?? '-')); ?></div>
        </div>

        <!-- Keterangan Admin (jika ada) -->
        <?php if (!empty($data['surat']['keterangan_admin'])): ?>
        <div class="info-card" style="margin-bottom: 16px;">
            <div class="info-label"><i class="fas fa-user-shield"></i> Keterangan Admin</div>
            <div class="info-value"><?= nl2br(htmlspecialchars($data['surat']['keterangan_admin'])); ?></div>
        </div>
        <?php endif; ?>

        <!-- File Surat -->
        <div class="info-card" style="margin-bottom: 16px;">
            <div class="info-label"><i class="fas fa-paperclip"></i> File Surat</div>
            <div class="info-value">
                <a href="<?= BASEURL; ?>/AdminController/surat_izin_download/<?= $data['surat']['id']; ?>" class="btn-download">
                    <i class="fas fa-download"></i> Download File
                </a>
            </div>
        </div>

        <!-- Form Aksi (hanya untuk status pending) -->
        <?php if ($data['surat']['status'] == 'pending'): ?>
        <div class="mt-4">
            <form method="POST" action="<?= BASEURL; ?>/AdminController/surat_izin_update_status/<?= $data['surat']['id']; ?>" class="row g-3">
                <div class="col-12">
                    <label class="form-label"><i class="fas fa-edit"></i> Keterangan (opsional)</label>
                    <textarea name="keterangan_admin" class="form-control" rows="3" 
                              placeholder="Isi keterangan untuk mahasiswa (alasan disetujui/ditolak)..."></textarea>
                </div>
                <div class="col-12 d-flex gap-3 flex-wrap">
                    <button type="submit" name="status" value="disetujui" class="btn-approve">
                        <i class="fas fa-check-circle"></i> Setujui
                    </button>
                    <button type="submit" name="status" value="ditolak" class="btn-reject">
                        <i class="fas fa-times-circle"></i> Tolak
                    </button>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <div class="alert-danger">
            <i class="fas fa-exclamation-triangle"></i> Data surat izin tidak ditemukan
        </div>
        <?php endif; ?>

        <!-- Tombol Kembali -->
        <div class="mt-4">
            <a href="<?= BASEURL; ?>/AdminController/surat_izin" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Surat Izin
            </a>
        </div>
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
    function executeLogout() { if (pendingLogoutUrl) window.location.href = pendingLogoutUrl; }

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