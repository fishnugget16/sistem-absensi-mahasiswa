<?php

class AdminController extends Controller {
    
    // Constructor untuk keamanan: cek login dan role admin
    public function __construct() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . BASEURL . '/AuthController');
            exit;
        }
    }
    
    // ==========================================
    // DASHBOARD (Redirect)
    // ==========================================
    
    public function index() {
        header('Location: ' . BASEURL . '/AuthController/dashboard');
        exit;
    }
    
    // ==========================================
    // CRUD MAHASISWA
    // ==========================================
    
    // Menampilkan daftar semua mahasiswa
    public function mahasiswa() {
        $mahasiswaModel = $this->model('Mahasiswa');
        $data['judul_halaman'] = 'Manajemen Data Mahasiswa';
        $data['mahasiswa'] = $mahasiswaModel->getAllMahasiswa();
        $data['total'] = $mahasiswaModel->countMahasiswa();
        $this->view('admin/mahasiswa/index', $data);
    }
    
    // Menampilkan form tambah mahasiswa
    public function mahasiswaCreate() {
        $data['judul_halaman'] = 'Tambah Mahasiswa Baru';
        $this->view('admin/mahasiswa/create', $data);
    }
    
    // Proses simpan mahasiswa baru
    public function mahasiswaStore() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama'] ?? '');
            $nim = trim($_POST['nim'] ?? '');
            $angkatan = trim($_POST['angkatan'] ?? '');
            $kelas = trim($_POST['kelas'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            // Validasi sederhana
            if (empty($nama) || empty($nim) || empty($email)) {
                $_SESSION['error'] = 'Nama, NIM, dan Email wajib diisi';
                header('Location: ' . BASEURL . '/AdminController/mahasiswaCreate');
                exit;
            }
            
            $mahasiswaModel = $this->model('Mahasiswa');
            $result = $mahasiswaModel->createMahasiswa($nama, $nim, $angkatan, $kelas, $email, $password);
            
            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
                header('Location: ' . BASEURL . '/AdminController/mahasiswa');
                exit;
            } else {
                $_SESSION['error'] = $result['message'];
                header('Location: ' . BASEURL . '/AdminController/mahasiswaCreate');
                exit;
            }
        }
    }
    
    // Menampilkan form edit mahasiswa
    public function mahasiswaEdit($id) {
        $mahasiswaModel = $this->model('Mahasiswa');
        $data['mahasiswa'] = $mahasiswaModel->getMahasiswaById($id);
        
        if (!$data['mahasiswa']) {
            $_SESSION['error'] = 'Data mahasiswa tidak ditemukan';
            header('Location: ' . BASEURL . '/AdminController/mahasiswa');
            exit;
        }
        
        $data['judul_halaman'] = 'Edit Data Mahasiswa';
        $this->view('admin/mahasiswa/edit', $data);
    }
    
    // Proses update mahasiswa
    public function mahasiswaUpdate($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama'] ?? '');
            $nim = trim($_POST['nim'] ?? '');
            $angkatan = trim($_POST['angkatan'] ?? '');
            $kelas = trim($_POST['kelas'] ?? '');
            $email = trim($_POST['email'] ?? '');
            
            if (empty($nama) || empty($nim) || empty($email)) {
                $_SESSION['error'] = 'Nama, NIM, dan Email wajib diisi';
                header('Location: ' . BASEURL . '/AdminController/mahasiswaEdit/' . $id);
                exit;
            }
            
            $mahasiswaModel = $this->model('Mahasiswa');
            $result = $mahasiswaModel->updateMahasiswa($id, $nama, $nim, $angkatan, $kelas, $email);
            
            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
                header('Location: ' . BASEURL . '/AdminController/mahasiswa');
                exit;
            } else {
                $_SESSION['error'] = $result['message'];
                header('Location: ' . BASEURL . '/AdminController/mahasiswaEdit/' . $id);
                exit;
            }
        }
    }
    
    // Proses hapus mahasiswa
    public function mahasiswaDelete($id) {
        $mahasiswaModel = $this->model('Mahasiswa');
        $result = $mahasiswaModel->deleteMahasiswa($id);
        
        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
        
        header('Location: ' . BASEURL . '/AdminController/mahasiswa');
        exit;
    }
    
    // ==========================================
    // CRUD DOSEN
    // ==========================================
    
    // Menampilkan daftar semua dosen
    public function dosen() {
        $dosenModel = $this->model('Dosen');
        $data['judul_halaman'] = 'Manajemen Data Dosen';
        $data['dosen'] = $dosenModel->getAllDosen();
        $data['total'] = $dosenModel->countDosen();
        $this->view('admin/dosen/index', $data);
    }
    
    // Menampilkan form tambah dosen
    public function dosenCreate() {
        $data['judul_halaman'] = 'Tambah Dosen Baru';
        $this->view('admin/dosen/create', $data);
    }
    
    // Proses simpan dosen baru
    public function dosenStore() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama'] ?? '');
            $nidn = trim($_POST['nidn'] ?? '');
            $prodi = trim($_POST['prodi'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            if (empty($nama) || empty($nidn) || empty($email)) {
                $_SESSION['error'] = 'Nama, NIDN, dan Email wajib diisi';
                header('Location: ' . BASEURL . '/AdminController/dosenCreate');
                exit;
            }
            
            $dosenModel = $this->model('Dosen');
            $result = $dosenModel->createDosen($nama, $nidn, $prodi, $email, $password);
            
            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
                header('Location: ' . BASEURL . '/AdminController/dosen');
                exit;
            } else {
                $_SESSION['error'] = $result['message'];
                header('Location: ' . BASEURL . '/AdminController/dosenCreate');
                exit;
            }
        }
    }
    
    // Menampilkan form edit dosen
    public function dosenEdit($id) {
        $dosenModel = $this->model('Dosen');
        $data['dosen'] = $dosenModel->getDosenById($id);
        
        if (!$data['dosen']) {
            $_SESSION['error'] = 'Data dosen tidak ditemukan';
            header('Location: ' . BASEURL . '/AdminController/dosen');
            exit;
        }
        
        $data['judul_halaman'] = 'Edit Data Dosen';
        $this->view('admin/dosen/edit', $data);
    }
    
    // Proses update dosen
    public function dosenUpdate($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama'] ?? '');
            $nidn = trim($_POST['nidn'] ?? '');
            $prodi = trim($_POST['prodi'] ?? '');
            $email = trim($_POST['email'] ?? '');
            
            if (empty($nama) || empty($nidn) || empty($email)) {
                $_SESSION['error'] = 'Nama, NIDN, dan Email wajib diisi';
                header('Location: ' . BASEURL . '/AdminController/dosenEdit/' . $id);
                exit;
            }
            
            $dosenModel = $this->model('Dosen');
            $result = $dosenModel->updateDosen($id, $nama, $nidn, $prodi, $email);
            
            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
                header('Location: ' . BASEURL . '/AdminController/dosen');
                exit;
            } else {
                $_SESSION['error'] = $result['message'];
                header('Location: ' . BASEURL . '/AdminController/dosenEdit/' . $id);
                exit;
            }
        }
    }
    
    // Proses hapus dosen
    public function dosenDelete($id) {
        $dosenModel = $this->model('Dosen');
        $result = $dosenModel->deleteDosen($id);
        
        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
        
        header('Location: ' . BASEURL . '/AdminController/dosen');
        exit;
    }
    
    // ==========================================
    // CRUD MATA KULIAH
    // ==========================================
    
    // Menampilkan daftar semua mata kuliah
    public function matakuliah() {
        $matkulModel = $this->model('MataKuliah');
        $data['judul_halaman'] = 'Manajemen Data Mata Kuliah';
        $data['matakuliah'] = $matkulModel->getAllMataKuliah();
        $data['total'] = $matkulModel->countMataKuliah();
        $this->view('admin/matakuliah/index', $data);
    }
    
    // Menampilkan form tambah mata kuliah
    public function matakuliahCreate() {
        $data['judul_halaman'] = 'Tambah Mata Kuliah Baru';
        $this->view('admin/matakuliah/create', $data);
    }
    
    // Proses simpan mata kuliah baru
    public function matakuliahStore() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kode = trim($_POST['kode'] ?? '');
            $nama = trim($_POST['nama'] ?? '');
            $sks = trim($_POST['sks'] ?? 3);
            $semester = trim($_POST['semester'] ?? 1);
            
            if (empty($kode) || empty($nama)) {
                $_SESSION['error'] = 'Kode dan Nama Mata Kuliah wajib diisi';
                header('Location: ' . BASEURL . '/AdminController/matakuliahCreate');
                exit;
            }
            
            $matkulModel = $this->model('MataKuliah');
            $result = $matkulModel->createMataKuliah($kode, $nama, $sks, $semester);
            
            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
                header('Location: ' . BASEURL . '/AdminController/matakuliah');
                exit;
            } else {
                $_SESSION['error'] = $result['message'];
                header('Location: ' . BASEURL . '/AdminController/matakuliahCreate');
                exit;
            }
        }
    }
    
    // Menampilkan form edit mata kuliah
    public function matakuliahEdit($id) {
        $matkulModel = $this->model('MataKuliah');
        $data['matakuliah'] = $matkulModel->getMataKuliahById($id);
        
        if (!$data['matakuliah']) {
            $_SESSION['error'] = 'Data mata kuliah tidak ditemukan';
            header('Location: ' . BASEURL . '/AdminController/matakuliah');
            exit;
        }
        
        $data['judul_halaman'] = 'Edit Data Mata Kuliah';
        $this->view('admin/matakuliah/edit', $data);
    }
    
    // Proses update mata kuliah
    public function matakuliahUpdate($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kode = trim($_POST['kode'] ?? '');
            $nama = trim($_POST['nama'] ?? '');
            $sks = trim($_POST['sks'] ?? 3);
            $semester = trim($_POST['semester'] ?? 1);
            
            if (empty($kode) || empty($nama)) {
                $_SESSION['error'] = 'Kode dan Nama Mata Kuliah wajib diisi';
                header('Location: ' . BASEURL . '/AdminController/matakuliahEdit/' . $id);
                exit;
            }
            
            $matkulModel = $this->model('MataKuliah');
            $result = $matkulModel->updateMataKuliah($id, $kode, $nama, $sks, $semester);
            
            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
                header('Location: ' . BASEURL . '/AdminController/matakuliah');
                exit;
            } else {
                $_SESSION['error'] = $result['message'];
                header('Location: ' . BASEURL . '/AdminController/matakuliahEdit/' . $id);
                exit;
            }
        }
    }
    
    // Proses hapus mata kuliah
    public function matakuliahDelete($id) {
        $matkulModel = $this->model('MataKuliah');
        $result = $matkulModel->deleteMataKuliah($id);
        
        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
        
        header('Location: ' . BASEURL . '/AdminController/matakuliah');
        exit;
    }
}