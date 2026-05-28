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

            // Memanggil User model untuk cek data dummy
            $userModel = $this->model('User');
            $user = $userModel->checkAdminCredentials($username, $password);

            if ($user) {
                // Simpan data umum ke session
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; // Menyimpan status role ('admin', 'dosen', 'mahasiswa')

                // DI SINI KUNCINYA: Tilang/Alirkan halaman sesuai dengan ROLE masing-masing
                if ($user['role'] === 'admin') {
                    // Jika admin, masuk ke dashboard admin milik Anda
                    header('Location: ' . BASEURL . '/AuthController/dashboard');
                    exit;
                } 
                elseif ($user['role'] === 'dosen') {
                    // Jika dosen, lempar ke halaman controller milik teman Anda
                    header('Location: ' . BASEURL . '/DosenController/index');
                    exit;
                } 
                elseif ($user['role'] === 'mahasiswa') {
                    // Jika mahasiswa, lempar ke halaman controller milik teman Anda
                    header('Location: ' . BASEURL . '/MahasiswaController/index');
                    exit;
                }

            } else {
                // Jika gagal login
                echo "<script>alert('Username atau Password Salah!'); window.location='".BASEURL."/AuthController';</script>";
            }
        }
    }

    // TAMBAHAN METHOD: Fungsi untuk menampilkan halaman dashboard yang bertanda x kemarin
    public function dashboard() {
        // Keamanan basic: jika belum login, tidak boleh buka dashboard
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . BASEURL . '/AuthController');
            exit;
        }
        $this->view('auth/dashboard');
    }

    // Fungsi untuk logout
    public function logout() {
        // PERBAIKAN 3: Hapus session_start() di sini
        session_destroy();
        header('Location: ' . BASEURL . '/AuthController');
        exit;
    }
}
