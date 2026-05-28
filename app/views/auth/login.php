<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Login - Sistem Absensi Mahasiswa</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts (Material 2 - Roboto) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/style.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0;
            padding: 16px;
        }
        
        /* Login Card - Material Design 2 Dark */
        .login-card {
            background: #1e1e1e;
            border-radius: 8px;
            width: 100%;
            max-width: 360px;
            padding: 32px 28px 36px 28px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3), 0 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        /* Logo / Icon */
        .login-icon {
            text-align: center;
            margin-bottom: 24px;
        }
        
        .login-icon i {
            font-size: 48px;
            color: #4caf50;
        }
        
        /* Title */
        .login-title {
            text-align: center;
            margin-bottom: 28px;
        }
        
        .login-title h2 {
            color: #e8eaed;
            font-weight: 500;
            font-size: 22px;
            margin-bottom: 6px;
            letter-spacing: -0.2px;
        }
        
        .login-title p {
            color: #9aa0a6;
            font-size: 13px;
            font-weight: 400;
        }
        
        /* Form Group - Material 2 Style */
        .form-group {
            margin-bottom: 20px;
        }
        
        .input-group-custom {
            position: relative;
            width: 100%;
        }
        
        .input-group-custom i {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            color: #9aa0a6;
            font-size: 18px;
            z-index: 1;
        }
        
        .input-group-custom input {
            width: 100%;
            padding: 12px 0 12px 28px;
            background: transparent;
            border: none;
            border-bottom: 1px solid #3c4043;
            font-size: 14px;
            font-family: 'Roboto', sans-serif;
            color: #e8eaed;
            transition: all 0.2s ease;
            outline: none;
        }
        
        .input-group-custom input:focus {
            border-bottom-color: #4caf50;
        }
        
        .input-group-custom input::placeholder {
            color: #5f6368;
        }
        
        /* Email input type style */
        .input-group-custom input[type="email"] {
            letter-spacing: 0.3px;
        }
        
        /* Button - Material Design 2 */
        .btn-login {
            width: 100%;
            padding: 10px;
            background: #4caf50;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 500;
            font-family: 'Roboto', sans-serif;
            color: #ffffff;
            cursor: pointer;
            transition: background 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-login:hover {
            background: #43a047;
        }
        
        .btn-login:active {
            background: #388e3c;
        }
        
        /* Alert / Error message */
        .alert-message {
            background: #2c1a1a;
            border-left: 3px solid #ef5350;
            padding: 10px 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            color: #ef9a9a;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-message i {
            font-size: 14px;
            color: #ef5350;
        }
        
        /* No footer links */
        .login-footer {
            display: none;
        }
        
        /* No scroll - body sudah fixed height */
        @media (max-width: 480px) {
            .login-card {
                padding: 28px 24px 32px 24px;
            }
            
            .login-title h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-icon">
            <i class="fas fa-graduation-cap"></i>
        </div>
        
        <div class="login-title">
            <h2>Sistem Absensi</h2>
            <p>Mahasiswa · Dosen · Admin</p>
        </div>
        
        <!-- Tampilkan error jika ada -->
        <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert-message">
            <i class="fas fa-exclamation-circle"></i>
            <span><?= $_SESSION['login_error']; ?></span>
        </div>
        <?php unset($_SESSION['login_error']); endif; ?>
        
        <!-- Form mengarah ke AuthController fungsi login -->
        <form action="<?= BASEURL; ?>/AuthController/login" method="POST">
            <div class="form-group">
                <div class="input-group-custom">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="Alamat Email" required autofocus>
                </div>
            </div>
            
            <div class="form-group">
                <div class="input-group-custom">
                    <i class="fas fa-lock"></i>
                    <i class="fas fa-eye-slash" id="togglePassword" style="right: 0; left: auto; cursor: pointer;"></i>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                </div>
            </div>
            
            <button type="submit" name="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                MASUK
            </button>
        </form>
        
        <!-- Footer dihilangkan -->
        <div class="login-footer"></div>
    </div>
    
    <!-- Simple toggle password visibility -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
    </script>
</body>
</html>