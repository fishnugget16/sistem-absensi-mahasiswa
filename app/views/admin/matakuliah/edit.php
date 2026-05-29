<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Kuliah - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #121212; }
        .navbar-custom { background: #1e1e1e; padding: 12px 24px; border-bottom: 1px solid #2a2a2a; }
        .navbar-custom a { color: #e8eaed; text-decoration: none; }
        .content-card { background: #1e1e1e; border-radius: 12px; padding: 24px; margin-top: 24px; border: 1px solid #2a2a2a; }
        .form-label { color: #e8eaed; font-weight: 500; }
        .form-control { background: #2a2a2a; border: 1px solid #3c4043; color: #e8eaed; }
        .form-control:focus { background: #2a2a2a; border-color: #4caf50; color: #e8eaed; box-shadow: none; }
        .btn-update { background: #ff9800; border: none; padding: 10px 24px; border-radius: 6px; color: #121212; }
        .btn-cancel { background: #3c4043; border: none; padding: 10px 24px; border-radius: 6px; color: white; }
        .alert-danger { background: #2c1a1a; border: 1px solid #dc3545; color: #ef9a9a; }
    </style>
</head>
<body>

<nav class="navbar-custom">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a href="<?= BASEURL; ?>/AuthController/dashboard"><i class="fas fa-graduation-cap"></i> Absensi OOP</a>
        <span style="color: #9aa0a6;"><i class="fas fa-user"></i> <?= $_SESSION['nama'] ?? 'Admin'; ?></span>
    </div>
</nav>

<div class="container">
    <div class="content-card">
        <h3 style="color: #e8eaed;"><i class="fas fa-edit"></i> Edit Data Mata Kuliah</h3>
        <hr style="border-color: #2a2a2a;">
        
        <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); endif; ?>
        
        <?php if ($data['matakuliah']): ?>
        <form action="<?= BASEURL; ?>/AdminController/matakuliahUpdate/<?= $data['matakuliah']['id']; ?>" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Mata Kuliah <span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control" value="<?= htmlspecialchars($data['matakuliah']['kode'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Mata Kuliah <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['matakuliah']['nama'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">SKS</label>
                    <select name="sks" class="form-control">
                        <option value="1" <?= ($data['matakuliah']['sks'] ?? '') == 1 ? 'selected' : ''; ?>>1 SKS</option>
                        <option value="2" <?= ($data['matakuliah']['sks'] ?? '') == 2 ? 'selected' : ''; ?>>2 SKS</option>
                        <option value="3" <?= ($data['matakuliah']['sks'] ?? '') == 3 ? 'selected' : ''; ?>>3 SKS</option>
                        <option value="4" <?= ($data['matakuliah']['sks'] ?? '') == 4 ? 'selected' : ''; ?>>4 SKS</option>
                        <option value="6" <?= ($data['matakuliah']['sks'] ?? '') == 6 ? 'selected' : ''; ?>>6 SKS</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-control">
                        <?php for ($i = 1; $i <= 8; $i++): ?>
                        <option value="<?= $i; ?>" <?= ($data['matakuliah']['semester'] ?? '') == $i ? 'selected' : ''; ?>>Semester <?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" name="submit" class="btn-update"><i class="fas fa-save"></i> Update</button>
                <a href="<?= BASEURL; ?>/AdminController/matakuliah" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
            </div>
        </form>
        <?php else: ?>
        <div class="alert alert-danger">Data mata kuliah tidak ditemukan</div>
        <a href="<?= BASEURL; ?>/AdminController/matakuliah" class="btn-cancel">Kembali</a>
        <?php endif; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>