<?php

class MahasiswaController extends Controller {
    
    public function __construct() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'mahasiswa') {
            header('Location: ' . BASEURL . '/AuthController');
            exit;
        }
    }
    
    public function index() {
        $mahasiswaModel = $this->model('Mahasiswa');
        $absensiModel = $this->model('Absensi');
        $suratModel = $this->model('SuratIzin');
        
        $userId = $_SESSION['user_id'];
        $dataMahasiswa = $mahasiswaModel->getMahasiswaByUserId($userId);
        $mahasiswaId = $dataMahasiswa['id'] ?? 0;
        
        // Total kehadiran (status 'Hadir')
        $totalHadir = $absensiModel->countHadir($mahasiswaId);
        
        // Ambil rekap per mata kuliah untuk menghitung persentase yang akurat
        $rekapMatkul = $absensiModel->getRekapPerMatkul($mahasiswaId);
        
        $totalPertemuanAdmin = 0;
        $totalHadirSemuaMatkul = 0;
        
        foreach ($rekapMatkul as $matkul) {
            // total_pertemuan dari database (set admin)
            $totalPertemuanAdmin += (int)$matkul['total_pertemuan'];
            $totalHadirSemuaMatkul += (int)$matkul['hadir'];
        }
        
        // Hitung persentase berdasarkan TOTAL PERTEMUAN DARI ADMIN
        if ($totalPertemuanAdmin > 0) {
            $persentase = round(($totalHadirSemuaMatkul / $totalPertemuanAdmin) * 100, 2);
        } else {
            $persentase = 0;
        }
        
        $totalSurat = $suratModel->countByMahasiswaId($mahasiswaId);
        
        // Hitung surat yang masih pending untuk stat card tambahan
        $suratPending = $suratModel->countByMahasiswaIdAndStatus($mahasiswaId, 'pending');
        
        $data = [
            'nama' => $_SESSION['nama'] ?? $_SESSION['username'],
            'nim' => $_SESSION['nim'] ?? '-',
            'prodi' => $dataMahasiswa['kelas'] ?? 'Belum diisi',
            'total_hadir' => $totalHadir,
            'persentase' => $persentase,
            'total_surat' => $totalSurat,
            'surat_pending' => $suratPending
        ];
        
        $this->view('mahasiswa/dashboard', $data);
    }
    
    public function absensi() {
        $mahasiswaModel = $this->model('Mahasiswa');
        $absensiModel = $this->model('Absensi');
        
        $userId = $_SESSION['user_id'];
        $dataMahasiswa = $mahasiswaModel->getMahasiswaByUserId($userId);
        $mahasiswaId = $dataMahasiswa['id'] ?? 0;
        
        $data = [
            'absensi' => $absensiModel->getByMahasiswaId($mahasiswaId),
            'rekap_matkul' => $absensiModel->getRekapPerMatkul($mahasiswaId)
        ];
        
        $this->view('mahasiswa/absensi/lihat', $data);
    }
    
    public function uploadSurat() {
        $mahasiswaModel = $this->model('Mahasiswa');
        $absensiModel = $this->model('Absensi');
        
        $userId = $_SESSION['user_id'];
        $dataMahasiswa = $mahasiswaModel->getMahasiswaByUserId($userId);
        $mahasiswaId = $dataMahasiswa['id'] ?? 0;
        $matkul_list = $absensiModel->getMatkulByProdi($mahasiswaId);
        
        $data = [
            'matkul_list' => $matkul_list
        ];
        
        $this->view('mahasiswa/surat/upload', $data);
    }
    
    public function uploadSuratStore() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $mahasiswaModel = $this->model('Mahasiswa');
            $absensiModel = $this->model('Absensi');
            $suratModel = $this->model('SuratIzin');
            
            $userId = $_SESSION['user_id'];
            $dataMahasiswa = $mahasiswaModel->getMahasiswaByUserId($userId);
            $mahasiswaId = $dataMahasiswa['id'] ?? 0;
            
            $matkul_id = $_POST['matkul_id'] ?? 0;
            $jenis_surat = $_POST['jenis_surat'] ?? '';
            $keterangan = $_POST['keterangan'] ?? '';
            
            if (empty($matkul_id) || empty($jenis_surat)) {
                $_SESSION['error'] = 'Semua field wajib diisi';
                header('Location: ' . BASEURL . '/MahasiswaController/uploadSurat');
                exit;
            }
            
            // PAKAI MODEL, BUKAN QUERY LANGSUNG
            $absensi = $absensiModel->getLatestAbsensiByMahasiswaAndMatkul($mahasiswaId, $matkul_id);
            
            if (!$absensi) {
                $_SESSION['error'] = 'Belum ada data absensi untuk mata kuliah ini';
                header('Location: ' . BASEURL . '/MahasiswaController/uploadSurat');
                exit;
            }
            
            // Proses upload file
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/aplikasi-absensi-mahasiswa/public/uploads/surat/';

            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            
            $fileName = time() . '_' . $_FILES['file_surat']['name'];
            $targetFile = $targetDir . $fileName;
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
            
            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['error'] = 'Hanya file PDF, JPG, JPEG, PNG yang diperbolehkan';
                header('Location: ' . BASEURL . '/MahasiswaController/uploadSurat');
                exit;
            }
            
            if ($_FILES['file_surat']['size'] > 2 * 1024 * 1024) {
                $_SESSION['error'] = 'File maksimal 2MB';
                header('Location: ' . BASEURL . '/MahasiswaController/uploadSurat');
                exit;
            }
            
            if (move_uploaded_file($_FILES['file_surat']['tmp_name'], $targetFile)) {
                $filePath = 'uploads/surat/' . $fileName;
                $result = $suratModel->createSuratIzin($absensi['id'], $filePath, $jenis_surat, $keterangan);
                
                if ($result['success']) {
                    $_SESSION['success'] = $result['message'];
                } else {
                    $_SESSION['error'] = $result['message'];
                }
            } else {
                $_SESSION['error'] = 'Gagal mengupload file';
            }
            
            header('Location: ' . BASEURL . '/MahasiswaController/uploadSurat');
            exit;
        }
    }

    public function historiSurat() {

        $mahasiswaModel = $this->model('Mahasiswa');
        $suratModel = $this->model('SuratIzin');
    
        $userId = $_SESSION['user_id'];
        $dataMahasiswa = $mahasiswaModel->getMahasiswaByUserId($userId);
        $mahasiswaId = $dataMahasiswa['id'] ?? 0;
    
        // Ambil filter status dari URL
        $filter_status = isset($_GET['status']) ? $_GET['status'] : 'semua';
    
        // ✅ PAKAI method getByMahasiswaIdWithFilter (sudah ditambahkan di SuratIzin.php)
        $surat_izin = $suratModel->getByMahasiswaIdWithFilter($mahasiswaId, $filter_status);
    
        $data = [
            'judul_halaman' => 'Histori Surat Izin',
            'surat_izin' => $surat_izin,
            'filter_aktif' => $filter_status
        ];
    
        $this->view('mahasiswa/surat/histori', $data);
    }
    
    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . '/AuthController');
        exit;
    }
}