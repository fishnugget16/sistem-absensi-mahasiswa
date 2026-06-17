<?php

class DosenController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'dosen') {
            header('Location: ' . BASEURL . '/AuthController');
            exit;
        }
    }

    public function index() {
        $dosenModel = $this->model('Dosen');
        $absensiModel = $this->model('AbsensiDosen');
        $pengajaranModel = $this->model('Pengajaran');

        $userId = $_SESSION['user_id'];
        $dataDosen = $dosenModel->getDosenByUserId($userId);
        $dosenId = $dataDosen['id'] ?? 0;

        // Total kehadiran dosen
        $totalHadir = $absensiModel->countHadir($dosenId);

        // Rekap per mata kuliah
        $rekapMatkul = $absensiModel->getRekapPerMatkul($dosenId);

        $totalPertemuan = 0;
        $totalMengajar = 0;

        foreach ($rekapMatkul as $matkul) {
            $totalPertemuan += (int)$matkul['total_pertemuan'];
            $totalMengajar += (int)$matkul['hadir'];
        }

        if ($totalPertemuan > 0) {
            $persentase = round(($totalMengajar / $totalPertemuan) * 100, 2);
        } else {
            $persentase = 0;
        }

        $totalPengajaran = $pengajaranModel->countByDosenId($dosenId);

        $data = [
            'nama' => $_SESSION['nama'] ?? $_SESSION['username'],
            'nidn' => $_SESSION['nidn'] ?? '-',
            'prodi' => $dataDosen['prodi'] ?? 'Belum diisi',
            'total_hadir' => $totalHadir,
            'persentase' => $persentase,
            'total_pengajaran' => $totalPengajaran
        ];

        $this->view('dosen/dashboard', $data);
    }

    public function inputAbsensiMahasiswa() {

    $dosenModel = $this->model('Dosen');
    $absensiModel = $this->model('Absensi');

    $userId = $_SESSION['user_id'];
    $dataDosen = $dosenModel->getDosenByUserId($userId);
    $dosenId = $dataDosen['id'] ?? 0;

    $data = [
        'matkul_list' => $absensiModel->getMatkulByDosenId($dosenId)
    ];

    $this->view('app/views/dosen/absensi/input', $data);
}

    public function absensi() {
        $dosenModel = $this->model('Dosen');
        $absensiModel = $this->model('AbsensiDosen');

        $userId = $_SESSION['user_id'];
        $dataDosen = $dosenModel->getDosenByUserId($userId);
        $dosenId = $dataDosen['id'] ?? 0;

        $data = [
            'absensi' => $absensiModel->getByDosenId($dosenId),
            'rekap_matkul' => $absensiModel->getRekapPerMatkul($dosenId)
        ];

        $this->view('app/views/dosen/absensi/rekap', $data);
    }

    
    public function inputAbsensiMahasiswaStore() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

        $absensiModel = $this->model('Absensi');

        $mahasiswa_id = $_POST['mahasiswa_id'] ?? 0;
        $matkul_id = $_POST['matkul_id'] ?? 0;
        $status = $_POST['status'] ?? '';
        $tanggal = date('Y-m-d');

        if (empty($mahasiswa_id) || empty($matkul_id) || empty($status)) {

            $_SESSION['error'] = 'Semua field wajib diisi';

            header('Location: ' . BASEURL . '/DosenController/inputAbsensiMahasiswa');
            exit;
        }

        $dataAbsensi = [
            'mahasiswa_id' => $mahasiswa_id,
            'matkul_id' => $matkul_id,
            'tanggal' => $tanggal,
            'status' => $status
        ];

        $result = $absensiModel->createAbsensi($dataAbsensi);

        if ($result['success']) {
            $_SESSION['success'] = 'Absensi berhasil disimpan';
        } else {
            $_SESSION['error'] = 'Absensi gagal disimpan';
        }

        header('Location: ' . BASEURL . '/DosenController/inputAbsensiMahasiswa');
        exit;
    }
}

public function getMahasiswaByMatkul($matkulId)
{
    $mahasiswaModel = $this->model('Mahasiswa');

    return $mahasiswaModel->getByMatkul($matkulId);
}

public function createAbsensi($data)
{
    $query = "INSERT INTO absensi
              (mahasiswa_id, matkul_id, tanggal, status)
              VALUES
              (:mahasiswa_id, :matkul_id, :tanggal, :status)";

    $this->db->query($query);

    $this->db->bind('mahasiswa_id', $data['mahasiswa_id']);
    $this->db->bind('matkul_id', $data['matkul_id']);
    $this->db->bind('tanggal', $data['tanggal']);
    $this->db->bind('status', $data['status']);

    if ($this->db->execute()) {
        return [
            'success' => true,
            'message' => 'Absensi berhasil disimpan'
        ];
    }

    return [
        'success' => false,
        'message' => 'Absensi gagal disimpan'
    ];
}

    public function uploadPengajaran() {
        $dosenModel = $this->model('Dosen');
        $absensiModel = $this->model('AbsensiDosen');

        $userId = $_SESSION['user_id'];
        $dataDosen = $dosenModel->getDosenByUserId($userId);
        $dosenId = $dataDosen['id'] ?? 0;

        $data = [
            'matkul_list' => $absensiModel->getMatkulByDosenId($dosenId)
        ];

        $this->view('dosen/pengajaran/upload', $data);
    }

    public function uploadPengajaranStore() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

            $dosenModel = $this->model('Dosen');
            $absensiModel = $this->model('AbsensiDosen');
            $pengajaranModel = $this->model('Pengajaran');

            $userId = $_SESSION['user_id'];
            $dataDosen = $dosenModel->getDosenByUserId($userId);
            $dosenId = $dataDosen['id'] ?? 0;

            $matkul_id = $_POST['matkul_id'] ?? 0;
            $materi = $_POST['materi'] ?? '';
            $keterangan = $_POST['keterangan'] ?? '';

            if (empty($matkul_id) || empty($materi)) {
                $_SESSION['error'] = 'Semua field wajib diisi';
                header('Location: ' . BASEURL . '/DosenController/uploadPengajaran');
                exit;
            }

            // Ambil absensi terakhir dosen pada matkul tersebut
            $absensi = $absensiModel->getLatestAbsensiByDosenAndMatkul($dosenId, $matkul_id);

            if (!$absensi) {
                $_SESSION['error'] = 'Belum ada data absensi untuk mata kuliah ini';
                header('Location: ' . BASEURL . '/DosenController/uploadPengajaran');
                exit;
            }

            // Upload file materi / laporan pengajaran
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/aplikasi-absensi-dosen/public/uploads/pengajaran/';

            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $fileName = time() . '_' . $_FILES['file_pengajaran']['name'];
            $targetFile = $targetDir . $fileName;

            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $allowedTypes = ['pdf', 'doc', 'docx', 'ppt', 'pptx'];

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['error'] = 'Hanya file PDF, DOC, DOCX, PPT, PPTX yang diperbolehkan';
                header('Location: ' . BASEURL . '/DosenController/uploadPengajaran');
                exit;
            }

            if ($_FILES['file_pengajaran']['size'] > 5 * 1024 * 1024) {
                $_SESSION['error'] = 'File maksimal 5MB';
                header('Location: ' . BASEURL . '/DosenController/uploadPengajaran');
                exit;
            }

            if (move_uploaded_file($_FILES['file_pengajaran']['tmp_name'], $targetFile)) {

                $filePath = 'uploads/pengajaran/' . $fileName;

                $result = $pengajaranModel->createPengajaran(
                    $absensi['id'],
                    $filePath,
                    $materi,
                    $keterangan
                );

                if ($result['success']) {
                    $_SESSION['success'] = $result['message'];
                } else {
                    $_SESSION['error'] = $result['message'];
                }

            } else {
                $_SESSION['error'] = 'Gagal mengupload file';
            }

            header('Location: ' . BASEURL . '/DosenController/uploadPengajaran');
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . '/AuthController');
        exit;
    }
}

