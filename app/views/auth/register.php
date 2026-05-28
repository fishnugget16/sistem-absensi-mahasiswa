<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Sistem Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #121212;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 16px;
        }
        .register-card {
            background: #1e1e1e;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            padding: 32px 28px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }
        .register-card h3 {
            color: #e8eaed;
            text-align: center;
            margin-bottom: 24px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            background: #2a2a2a;
            border: 1px solid #3c4043;
            border-radius: 6px;
            color: #e8eaed;
            outline: none;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #4caf50;
        }
        .btn-register {
            width: 100%;
            padding: 12px;
            background: #4caf50;
            border: none;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-register:hover { background: #43a047; }
        .alert-error {
            background: #2c1a1a;
            border-left: 3px solid #ef5350;
            padding: 10px;
            margin-bottom: 20px;
            color: #ef9a9a;
            font-size: 13px;
        }
        .alert-success {
            background: #1a2c1a;
            border-left: 3px solid #4caf50;
            padding: 10px;
            margin-bottom: 20px;
            color: #9aef9a;
            font-size: 13px;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            color: #4caf50;
            text-decoration: none;
        }
        .info-text {
            color: #9aa0a6;
            font-size: 11px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <h3><i class="fas fa-user-plus"></i> Daftar Akun Baru</h3>
        
        <?php if (isset($_SESSION['register_error'])): ?>
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['register_error']; ?>
        </div>
        <?php unset($_SESSION['register_error']); endif; ?>
        
        <?php if (isset($_SESSION['register_success'])): ?>
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> <?= $_SESSION['register_success']; ?>
        </div>
        <?php unset($_SESSION['register_success']); endif; ?>
        
        <form action="<?= BASEURL; ?>/AuthController/register" method="POST">
            <div class="form-group">
                <input type="text" name="nama" placeholder="Nama Lengkap" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email (nama@mhs.kampus.ac.id / @dsn / @admin)" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" placeholder="Password (4-8 karakter)" maxlength="8" required>
                <i class="fas fa-eye-slash" id="togglePassword" style="float: right; margin-top: -28px; margin-right: 10px; cursor: pointer; color: #9aa0a6;"></i>
            </div>
            <div id="extraFields"></div>
            <button type="submit" name="submit" class="btn-register">
                <i class="fas fa-check"></i> Daftar
            </button>
        </form>
        
        <div class="login-link">
            <a href="<?= BASEURL; ?>/AuthController">Sudah punya akun? Login di sini</a>
        </div>
    </div>
    
    <script>
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const type = password.type === 'password' ? 'text' : 'password';
                password.type = type;
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
        
        // Dynamic field berdasarkan role dari email
        const emailInput = document.querySelector('input[name="email"]');
        const extraFields = document.getElementById('extraFields');
        
        function updateExtraFields() {
            const email = emailInput.value;
            let role = '';
            
            if (email.includes('@mhs.kampus.ac.id')) {
                role = 'mahasiswa';
            } else if (email.includes('@dsn.kampus.ac.id')) {
                role = 'dosen';
            } else if (email.includes('@admin.kampus.ac.id')) {
                role = 'admin';
            }
            
            if (role === 'mahasiswa') {
                extraFields.innerHTML = `
                    <div class="form-group">
                        <input type="text" name="nim" placeholder="NIM" required>
                        <div class="info-text">Contoh: 422025001</div>
                    </div>
                `;
            } else if (role === 'dosen') {
                extraFields.innerHTML = `
                    <div class="form-group">
                        <input type="text" name="nidn" placeholder="NIDN" required>
                        <div class="info-text">Contoh: 0012345601</div>
                    </div>
                `;
            } else {
                extraFields.innerHTML = '';
            }
        }
        
        emailInput.addEventListener('input', updateExtraFields);
    </script>
</body>
</html>