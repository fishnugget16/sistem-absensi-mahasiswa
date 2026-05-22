<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Sistem Absensi</title>
    <link rel="stylesheet" href="<?= BASEURL; ?>/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        
        <!-- Form mengarah ke AuthController fungsi login -->
        <form action="<?= BASEURL; ?>/AuthController/login" method="POST">
            <div class="form-group">
                <label for="username">Username/Email</label>
                <input type="text" name="username" id="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            
            <button type="submit" name="submit">Masuk</button>
        </form>
    </div>
</body>
</html>
