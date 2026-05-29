<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul_halaman'] ?? 'Data Mata Kuliah' ?> - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Roboto', sans-serif; background-color: #121212; }
        .navbar-custom { background: #1e1e1e; padding: 12px 24px; border-bottom: 1px solid #2a2a2a; position: sticky; top: 0; z-index: 1000; }
        .navbar-custom a { color: #e8eaed; text-decoration: none; }
        .navbar-brand { font-size: 18px; font-weight: 500; }
        .navbar-brand i { color: #4caf50; margin-right: 8px; }
        .content-card { background: #1e1e1e; border-radius: 12px; padding: 24px; margin-top: 24px; border: 1px solid #2a2a2a; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; }
        .page-title { color: #e8eaed; font-size: 20px; font-weight: 500; margin: 0; }
        .page-title i { color: #4caf50; margin-right: 10px; }
        .btn-add { background: #4caf50; border: none; padding: 8px 20px; border-radius: 6px; color: white; font-size: 13px; font-weight: 500; transition: all 0.2s; }
        .btn-add:hover { background: #43a047; transform: translateY(-1px); }
        .btn-edit { background: #ff9800; border: none; padding: 5px 12px; border-radius: 4px; color: #121212; font-size: 12px; font-weight: 500; margin-right: 5px; }
        .btn-edit:hover { background: #fb8c00; }
        .btn-delete { background: #dc3545; border: none; padding: 5px 12px; border-radius: 4px; color: white; font-size: 12px; font-weight: 500; }
        .btn-delete:hover { background: #c82333; }
        .btn-back { background: #3c4043; border: none; padding: 8px 20px; border-radius: 6px; color: white; font-size: 13px; margin-top: 20px; transition: all 0.2s; }
        .btn-back:hover { background: #4a4e54; }
        .table-wrapper { overflow-x: auto; border-radius: 8px; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead tr { border-bottom: 2px solid #2a2a2a; }
        .data-table th { text-align: left; padding: 14px 12px; color: #4caf50; font-weight: 500; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .data-table td { padding: 12px 12px; color: #e8eaed; font-size: 14px; border-bottom: 1px solid #2a2a2a; }
        .data-table tbody tr:hover { background: rgba(255, 255, 255, 0.03); }
        .alert-success { background: #1a2c1a; border: 1px solid #4caf50; color: #9aef9a; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; }
        .alert-danger { background: #2c1a1a; border: 1px solid #dc3545; color: #ef9a9a; border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; }
        .empty-row td { text-align: center; padding: 40px !important; color: #9aa0a6; font-size: 14px; }
        .user-info { color: #9aa0a6; font-size: 14px; }
        .user-info i { color: #4caf50; margin-right: 6px; }
        .logout-link { color: #dc3545 !important; margin-left: 16px; }
        .logout-link:hover { color: #ef5350 !important; }
        .badge-sks { background: #4caf50; color: #121212; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    </style>
</head>
<body>

<nav class="navbar-custom">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a href="<?= BASEURL; ?>/AuthController/dashboard" class="navbar-brand"><i class="fas fa-graduation-cap"></i> Absensi OOP</a>
        <div>
            <span class="user-info"><i class="fas fa-user-circle"></i> <?= $_SESSION['nama'] ?? $_SESSION['username'] ?? 'Admin'; ?></span>
            <a href="<?= BASEURL; ?>/AuthController/logout" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="content-card">
        <div class="page-header">
            <h3 class="page-title"><i class="fas fa-book"></i> <?= $data['judul_halaman'] ?></h3>
            <a href="<?= BASEURL; ?>/AdminController/matakuliahCreate" class="btn-add"><i class="fas fa-plus"></i> Tambah Mata Kuliah</a>
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
                        <th>Kode</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Semester</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['matakuliah'])): ?>
                    <tr class="empty-row"><td colspan="6">📚 Belum ada data mata kuliah. Silakan tambah data baru.</td></tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($data['matakuliah'] as $mk): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><code><?= htmlspecialchars($mk['kode'] ?? '-'); ?></code></td>
                            <td><?= htmlspecialchars($mk['nama'] ?? '-'); ?></td>
                            <td><span class="badge-sks"><?= $mk['sks'] ?? '-'; ?> SKS</span></td>
                            <td>Semester <?= $mk['semester'] ?? '-'; ?></td>
                            <td style="text-align: center;">
                                <a href="<?= BASEURL; ?>/AdminController/matakuliahEdit/<?= $mk['id']; ?>" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                <a href="<?= BASEURL; ?>/AdminController/matakuliahDelete/<?= $mk['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus?')"><i class="fas fa-trash"></i> Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <a href="<?= BASEURL; ?>/AuthController/dashboard" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>