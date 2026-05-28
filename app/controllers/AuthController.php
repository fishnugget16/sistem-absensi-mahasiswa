<?php

class AuthController extends Controller {
    
    // Tampilkan halaman login
    public function index() {
        $this->view('auth/login');
    }
    
    // Tampilkan halaman registrasi
    public function registerForm() {
        $this->view('auth/register');
    }
    
    // Proses registrasi
    public function register() {
        if (isset($_POST['submit'])) {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $nama = trim($_POST['nama']);
            $nim = isset($_POST['nim']) ? trim($_POST['nim']) : null;
            $nidn = isset($_POST['nidn']) ? trim($_POST['nidn']) : null;
            
            // Validasi email format
            $userModel = $this->model('User');
            $role = $userModel->getRoleFromEmail($email);
            
            if ($role === null) {
                $_SESSION['register_error'] = 'Format email tidak valid. Gunakan domain @mhs.kampus.ac.id, @dsn.kampus.ac.id, atau @admin.kampus.ac.id';
                header('Location: ' . BASEURL . '/AuthController/registerForm');
                exit;
            }
            
            // Validasi password
            if (strlen($password) > 8) {
                $_SESSION['register_error'] = 'Password maksimal 8 karakter';
                header('Location: ' . BASEURL . '/AuthController/registerForm');
                exit;
            }
            
            if (strlen($password) < 4) {
                $_SESSION['register_error'] = 'Password minimal 4 karakter';
                header('Location: ' . BASEURL . '/AuthController/registerForm');
                exit;
            }
            
            // Validasi nama
            if (strlen($nama) < 2) {
                $_SESSION['register_error'] = 'Nama minimal 2 karakter';
                header('Location: ' . BASEURL . '/AuthController/registerForm');
                exit;
            }
            
            // Validasi NIM untuk mahasiswa
            if ($role === 'mahasiswa' && empty($nim)) {
                $_SESSION['register_error'] = 'NIM wajib diisi untuk mahasiswa';
                header('Location: ' . BASEURL . '/AuthController/registerForm');
                exit;
            }
            
            // Validasi NIDN untuk dosen
            if ($role === 'dosen' && empty($nidn)) {
                $_SESSION['register_error'] = 'NIDN wajib diisi untuk dosen';
                header('Location: ' . BASEURL . '/AuthController/registerForm');
                exit;
            }
            
            // Proses registrasi
            $result = $userModel->register($email, $password, $nama, $role, $nim, $nidn);
            
            if ($result['success']) {
                $_SESSION['register_success'] = $result['message'];
                header('Location: ' . BASEURL . '/AuthController');
                exit;
            } else {
                $_SESSION['register_error'] = $result['message'];
                header('Location: ' . BASEURL . '/AuthController/registerForm');
                exit;
            }
        }
    }
    
    // Proses login
    public function login() {
        if (isset($_POST['submit'])) {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            
            if (empty($email) || empty($password)) {
                $_SESSION['login_error'] = 'Email dan Password harus diisi';
                header('Location: ' . BASEURL . '/AuthController');
                exit;
            }
            
            // Validasi password maksimal 8 karakter
            if (strlen($password) > 8) {
                $_SESSION['login_error'] = 'Password maksimal 8 karakter';
                header('Location: ' . BASEURL . '/AuthController');
                exit;
            }
            
            $userModel = $this->model('User');
            $user = $userModel->checkAdminCredentials($email, $password);
            
            if ($user) {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nama'] = $user['nama'];
                
                // Simpan NIM atau NIDN jika ada
                if ($user['nim']) {
                    $_SESSION['nim'] = $user['nim'];
                }
                if ($user['nidn']) {
                    $_SESSION['nidn'] = $user['nidn'];
                }
                
                // Redirect berdasarkan role
                if ($user['role'] === 'admin') {
                    header('Location: ' . BASEURL . '/AuthController/dashboard');
                    exit;
                } elseif ($user['role'] === 'dosen') {
                    header('Location: ' . BASEURL . '/DosenController/index');
                    exit;
                } elseif ($user['role'] === 'mahasiswa') {
                    header('Location: ' . BASEURL . '/MahasiswaController/index');
                    exit;
                }
            } else {
                $_SESSION['login_error'] = 'Email atau Password Salah!';
                header('Location: ' . BASEURL . '/AuthController');
                exit;
            }
        }
    }
    
    // Dashboard admin
    public function dashboard() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . '/AuthController');
            exit;
        }
    
        $data = [
            'nama' => $_SESSION['nama'] ?? $_SESSION['username'],
            'email' => $_SESSION['email'],
            'total_mahasiswa' => 0,
            'total_dosen' => 0,
            'total_matkul' => 0,
            'total_absensi_hari_ini' => 0
        ];
    
        $this->view('auth/dashboard', $data);
    }
    
    // Logout
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASEURL . '/AuthController');
        exit;
    }
}