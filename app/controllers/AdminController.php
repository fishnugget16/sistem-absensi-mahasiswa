<?php

class AdminController extends Controller {
    
    // Constructor untuk keamanan: cek login dan role admin
    public function __construct() {
        // Pastikan session dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
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
    // CRUD MAHASISWA (DENGAN FILTER)
    // ==========================================
    
    // Menampilkan daftar semua mahasiswa dengan filter
    public function mahasiswa() {
        $mahasiswaModel = $this->model('Mahasiswa');
        
        // Ambil parameter filter dari URL
        $filter_prodi = isset($_GET['filter_prodi']) ? $_GET['filter_prodi'] : '';
        $filter_angkatan = isset($_GET['filter_angkatan']) ? $_GET['filter_angkatan'] : '';
        
        $data['judul_halaman'] = 'Manajemen Data Mahasiswa';
        $data['mahasiswa'] = $mahasiswaModel->getAllWithFilters($filter_prodi, $filter_angkatan);
        $data['total'] = count($data['mahasiswa']);
        
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
            $prodi = trim($_POST['prodi'] ?? '');
            $angkatan = trim($_POST['angkatan'] ?? '');
            $kelas = trim($_POST['kelas'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            if (empty($nama) || empty($nim) || empty($email)) {
                $_SESSION['error'] = 'Nama, NIM, dan Email wajib diisi';
                header('Location: ' . BASEURL . '/AdminController/mahasiswaCreate');
                exit;
            }
            
            $mahasiswaModel = $this->model('Mahasiswa');
            $result = $mahasiswaModel->createMahasiswa($nama, $nim, $prodi, $angkatan, $kelas, $email, $password);
            
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
            $prodi = trim($_POST['prodi'] ?? '');
            $angkatan = trim($_POST['angkatan'] ?? '');
            $kelas = trim($_POST['kelas'] ?? '');
            $email = trim($_POST['email'] ?? '');
            
            if (empty($nama) || empty($nim) || empty($email)) {
                $_SESSION['error'] = 'Nama, NIM, dan Email wajib diisi';
                header('Location: ' . BASEURL . '/AdminController/mahasiswaEdit/' . $id);
                exit;
            }
            
            $mahasiswaModel = $this->model('Mahasiswa');
            $result = $mahasiswaModel->updateMahasiswa($id, $nama, $nim, $prodi, $angkatan, $kelas, $email);
            
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
    // CRUD DOSEN (DENGAN FILTER)
    // ==========================================
    
    // Menampilkan daftar semua dosen dengan filter
    public function dosen() {
        $dosenModel = $this->model('Dosen');
        
        // Ambil parameter filter dari URL
        $filter_prodi = isset($_GET['filter_prodi']) ? $_GET['filter_prodi'] : '';
        
        $data['judul_halaman'] = 'Manajemen Data Dosen';
        $data['dosen'] = $dosenModel->getAllWithFilters($filter_prodi);
        $data['total'] = count($data['dosen']);
        
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
    // ASSIGN MATA KULIAH KE DOSEN
    // ==========================================
    
    /**
     * Get mata kuliah untuk dosen berdasarkan prodi (AJAX)
     * @param int $dosen_id ID dosen
     */
    public function getMatkulByDosen($dosen_id) {
        // ✅ Bersihkan output buffer
        ob_clean();
        
        // ✅ Mulai session jika belum
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // ✅ Cek login dan role
        if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized. Silakan login sebagai admin.'
            ]);
            exit;
        }
        
        // Matikan error reporting supaya tidak mengganggu JSON
        error_reporting(0);
        ini_set('display_errors', 0);
        
        // Set header JSON
        header('Content-Type: application/json');
        
        try {
            // Cek apakah dosen_id valid
            if (empty($dosen_id) || !is_numeric($dosen_id)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'ID dosen tidak valid'
                ]);
                exit;
            }
            
            $dosenModel = $this->model('Dosen');
            $matkulModel = $this->model('MataKuliah');
            
            // Cek apakah model berhasil di-load
            if (!$dosenModel || !$matkulModel) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Gagal memuat model'
                ]);
                exit;
            }
            
            // Ambil data dosen
            $dosen = $dosenModel->getDosenById($dosen_id);
            
            if (!$dosen) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Dosen tidak ditemukan'
                ]);
                exit;
            }
            
            $prodi = $dosen['prodi'] ?? '';
            
            if (empty($prodi)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Dosen belum memiliki program studi'
                ]);
                exit;
            }
            
            // Ambil semua mata kuliah sesuai prodi dosen (prefix kode)
            $all_matkul = $matkulModel->getByProdi($prodi);
            
            // Ambil mata kuliah yang sudah diampu dosen ini
            $assigned = $matkulModel->getByDosenId($dosen_id);
            $assigned_ids = array_column($assigned, 'id');
            
            // Hitung jumlah matkul yang sudah diampu
            $current_count = count($assigned_ids);
            $max = 4;
            
            echo json_encode([
                'success' => true,
                'matkul' => $all_matkul,
                'assigned' => $assigned_ids,
                'prodi' => $prodi,
                'dosen_nama' => $dosen['nama'],
                'current_count' => $current_count,
                'max' => $max,
                'is_full' => $current_count >= $max
            ]);
            exit;
            
        } catch (Exception $e) {
            error_log("Error in getMatkulByDosen: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
            exit;
        }
    }
    
    /**
     * Assign mata kuliah ke dosen (AJAX)
     */
    public function assignMatkul() {
        // ✅ Bersihkan output buffer
        ob_clean();
        
        // ✅ Mulai session jika belum
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // ✅ Cek login dan role
        if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
            exit;
        }
        
        // Matikan error reporting
        error_reporting(0);
        ini_set('display_errors', 0);
        
        header('Content-Type: application/json');
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan']);
                exit;
            }
            
            $dosen_id = isset($_POST['dosen_id']) ? (int)$_POST['dosen_id'] : 0;
            $matkul_id = isset($_POST['matkul_id']) ? (int)$_POST['matkul_id'] : 0;
            
            if (!$dosen_id || !$matkul_id) {
                echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
                exit;
            }
            
            $matkulModel = $this->model('MataKuliah');
            
            // Cek apakah dosen sudah punya 4 matkul
            $current = $matkulModel->countByDosenId($dosen_id);
            if ($current >= 4) {
                echo json_encode(['success' => false, 'message' => 'Maksimal 4 mata kuliah per dosen']);
                exit;
            }
            
            // Cek apakah matkul sudah punya dosen lain
            $matkul = $matkulModel->getMataKuliahById($matkul_id);
            if ($matkul && $matkul['dosen_id'] && $matkul['dosen_id'] != $dosen_id) {
                echo json_encode(['success' => false, 'message' => 'Mata kuliah ini sudah diampu dosen lain']);
                exit;
            }
            
            // Cek apakah matkul sudah diampu oleh dosen ini
            if ($matkul && $matkul['dosen_id'] == $dosen_id) {
                echo json_encode(['success' => false, 'message' => 'Mata kuliah ini sudah diampu oleh dosen ini']);
                exit;
            }
            
            // Assign matkul ke dosen
            $result = $matkulModel->assignDosen($matkul_id, $dosen_id);
            
            // Pastikan response selalu dalam format yang sama
            if ($result['success']) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Mata kuliah berhasil diassign'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal mengassign mata kuliah'
                ]);
            }
            exit;
            
        } catch (Exception $e) {
            error_log("Error in assignMatkul: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
            exit;
        }
    }
    
    /**
     * Remove mata kuliah dari dosen (AJAX)
     */
    public function removeMatkul() {
        // ✅ Bersihkan output buffer
        ob_clean();
        
        // ✅ Mulai session jika belum
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // ✅ Cek login dan role
        if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
            exit;
        }
        
        // Matikan error reporting
        error_reporting(0);
        ini_set('display_errors', 0);
        
        header('Content-Type: application/json');
        
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan']);
                exit;
            }
            
            $dosen_id = isset($_POST['dosen_id']) ? (int)$_POST['dosen_id'] : 0;
            $matkul_id = isset($_POST['matkul_id']) ? (int)$_POST['matkul_id'] : 0;
            
            if (!$dosen_id || !$matkul_id) {
                echo json_encode(['success' => false, 'message' => 'Data tidak valid']);
                exit;
            }
            
            $matkulModel = $this->model('MataKuliah');
            
            // Cek apakah matkul memang diampu dosen ini
            $matkul = $matkulModel->getMataKuliahById($matkul_id);
            if (!$matkul) {
                echo json_encode(['success' => false, 'message' => 'Mata kuliah tidak ditemukan']);
                exit;
            }
            
            if ($matkul['dosen_id'] != $dosen_id) {
                echo json_encode(['success' => false, 'message' => 'Mata kuliah tidak diampu oleh dosen ini']);
                exit;
            }
            
            // ✅ LANGSUNG LEPAS - TANPA VALIDASI MINIMAL
            $result = $matkulModel->removeDosen($matkul_id);
            
            // Pastikan response selalu dalam format yang sama
            if ($result['success']) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Mata kuliah berhasil dilepas'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal melepas mata kuliah'
                ]);
            }
            exit;
            
        } catch (Exception $e) {
            error_log("Error in removeMatkul: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
            exit;
        }
    }
    
    // ==========================================
    // CRUD MATA KULIAH (DENGAN FILTER) - DIPERBAIKI
    // ==========================================
    
    // Menampilkan daftar semua mata kuliah dengan filter - TAMBAH FILTER ANGKATAN
    public function matakuliah() {
        $matkulModel = $this->model('MataKuliah');
        
        // Ambil parameter filter dari URL
        $filter_semester = isset($_GET['filter_semester']) ? $_GET['filter_semester'] : '';
        $filter_prodi = isset($_GET['filter_prodi']) ? $_GET['filter_prodi'] : '';
        $filter_sks = isset($_GET['filter_sks']) ? $_GET['filter_sks'] : '';
        $filter_angkatan = isset($_GET['filter_angkatan']) ? $_GET['filter_angkatan'] : '';
        
        $data['judul_halaman'] = 'Manajemen Data Mata Kuliah';
        $data['matakuliah'] = $matkulModel->getAllWithFilters($filter_semester, $filter_prodi, $filter_sks, $filter_angkatan);
        $data['total'] = count($data['matakuliah']);
        
        $this->view('admin/matakuliah/index', $data);
    }
    
    // Menampilkan form tambah mata kuliah
    public function matakuliahCreate() {
        $data['judul_halaman'] = 'Tambah Mata Kuliah Baru';
        $this->view('admin/matakuliah/create', $data);
    }
    
    // Proses simpan mata kuliah baru - TAMBAH ANGKATAN
    public function matakuliahStore() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kode = trim($_POST['kode'] ?? '');
            $nama = trim($_POST['nama'] ?? '');
            $sks = trim($_POST['sks'] ?? 3);
            $semester = trim($_POST['semester'] ?? 1);
            $jumlah_pertemuan = trim($_POST['jumlah_pertemuan'] ?? 14);
            $angkatan = isset($_POST['angkatan']) && $_POST['angkatan'] != 'Semua' ? trim($_POST['angkatan']) : null;
            
            if (empty($kode) || empty($nama)) {
                $_SESSION['error'] = 'Kode dan Nama Mata Kuliah wajib diisi';
                header('Location: ' . BASEURL . '/AdminController/matakuliahCreate');
                exit;
            }
            
            $matkulModel = $this->model('MataKuliah');
            $result = $matkulModel->createMataKuliah($kode, $nama, $sks, $semester, $jumlah_pertemuan, null, $angkatan);
            
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
    
    // Proses update mata kuliah - TAMBAH ANGKATAN
    public function matakuliahUpdate($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kode = trim($_POST['kode'] ?? '');
            $nama = trim($_POST['nama'] ?? '');
            $sks = trim($_POST['sks'] ?? 3);
            $semester = trim($_POST['semester'] ?? 1);
            $jumlah_pertemuan = trim($_POST['jumlah_pertemuan'] ?? 14);
            $angkatan = isset($_POST['angkatan']) && $_POST['angkatan'] != 'Semua' ? trim($_POST['angkatan']) : null;
            
            if (empty($kode) || empty($nama)) {
                $_SESSION['error'] = 'Kode dan Nama Mata Kuliah wajib diisi';
                header('Location: ' . BASEURL . '/AdminController/matakuliahEdit/' . $id);
                exit;
            }
            
            $matkulModel = $this->model('MataKuliah');
            $result = $matkulModel->updateMataKuliah($id, $kode, $nama, $sks, $semester, $jumlah_pertemuan, null, $angkatan);
            
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
    
    // ==========================================
    // KELOLA SURAT IZIN
    // ==========================================
    
    /**
     * Menampilkan daftar semua surat izin
     * Bisa filter berdasarkan status (pending, disetujui, ditolak)
     */
    public function surat_izin() {
        $suratModel = $this->model('SuratIzin');
        
        $filter = isset($_GET['status']) ? $_GET['status'] : null;
        
        if ($filter && in_array($filter, ['pending', 'disetujui', 'ditolak'])) {
            $data['surat_izin'] = $suratModel->getAllSuratIzin($filter);
            $data['filter_aktif'] = $filter;
        } else {
            $data['surat_izin'] = $suratModel->getAllSuratIzin();
            $data['filter_aktif'] = 'semua';
        }
        
        $data['judul_halaman'] = 'Manajemen Surat Izin Mahasiswa';
        $data['statistik'] = $suratModel->getStatistik();
        
        $this->view('admin/suratizin/index', $data);
    }
    
    /**
     * Menampilkan detail surat izin
     */
    public function surat_izin_detail($id) {
        $suratModel = $this->model('SuratIzin');
        $data['surat'] = $suratModel->getDetailById($id);
        
        if (!$data['surat']) {
            $_SESSION['error'] = 'Data surat izin tidak ditemukan';
            header('Location: ' . BASEURL . '/AdminController/surat_izin');
            exit;
        }
        
        // Ambil data tambahan (mahasiswa, mata kuliah)
        $data['judul_halaman'] = 'Detail Surat Izin';
        $this->view('admin/suratizin/detail', $data);
    }
    
    /**
     * Update status surat izin (setujui/tolak)
     */
    public function surat_izin_update_status($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? '';
            $keterangan_admin = $_POST['keterangan_admin'] ?? '';
            
            if (!in_array($status, ['disetujui', 'ditolak'])) {
                $_SESSION['error'] = 'Status tidak valid';
                header('Location: ' . BASEURL . '/AdminController/surat_izin');
                exit;
            }
            
            $suratModel = $this->model('SuratIzin');
            $result = $suratModel->updateStatus($id, $status, $keterangan_admin);
            
            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
            } else {
                $_SESSION['error'] = $result['message'];
            }
            
            header('Location: ' . BASEURL . '/AdminController/surat_izin');
            exit;
        }
    }
    
    /**
     * Hapus surat izin
     */
    public function surat_izin_delete($id) {
        $suratModel = $this->model('SuratIzin');
        $result = $suratModel->deleteSuratIzin($id);
        
        if ($result['success']) {
            $_SESSION['success'] = $result['message'];
        } else {
            $_SESSION['error'] = $result['message'];
        }
        
        header('Location: ' . BASEURL . '/AdminController/surat_izin');
        exit;
    }
    
    /**
     * Download file surat izin
     */
    public function surat_izin_download($id) {
        $suratModel = $this->model('SuratIzin');
        $surat = $suratModel->getById($id);
        
        if (!$surat || empty($surat['file_path'])) {
            $_SESSION['error'] = 'File tidak ditemukan';
            header('Location: ' . BASEURL . '/AdminController/surat_izin');
            exit;
        }
        
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/aplikasi-absensi-mahasiswa/public/' . $surat['file_path'];
        
        if (file_exists($filePath)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        } else {
            $_SESSION['error'] = 'File tidak ditemukan di server';
            header('Location: ' . BASEURL . '/AdminController/surat_izin');
            exit;
        }
    }
}