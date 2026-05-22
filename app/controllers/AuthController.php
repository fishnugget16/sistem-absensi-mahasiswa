<?php

class AuthController extends Controller {
    
    // Fungsi untuk menampilkan halaman login
    public function index() {
        $this->view('auth/login');
    }

    // Fungsi untuk memproses data login admin
    public function login() {
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Memanggil User model untuk cek data ke database
            $userModel = $this->model('User');
            $admin = $userModel->checkAdminCredentials($username, $password);

            if ($admin) {
                // Jika sukses, buat session admin dan lempar ke dashboard
                session_start();
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                
                header('Location: ' . BASEURL . '/AdminController/index');
                exit;
            } else {
                // Jika gagal, kembali ke login dengan peringatan
                echo "<script>alert('Username atau Password Salah!'); window.location='".BASEURL."/AuthController';</script>";
            }
        }
    }

    // Fungsi untuk logout
    public function logout() {
        session_start();
        session_destroy();
        header('Location: ' . BASEURL . '/AuthController');
        exit;
    }
}
