<?php

use Dompdf\Dompdf;

class DosenController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'dosen') {
            header('Location: ' . BASEURL . '/AuthController');
            exit;
        }
    }

    // ==========================================
    // DASHBOARD DOSEN
    // ==========================================

    public function index() {
        $dosenModel = $this->model('Dosen');
        $absensiModel = $this->model('Absensi');
        $matkulModel = $this->model('MataKuliah');

        $userId = $_SESSION['user_id'];
        $dataDosen = $dosenModel->getDosenByUserId($userId);
        $dosenId = $dataDosen['id'] ?? 0;

        // Total mata kuliah yang diampu
        $totalMatkul = $matkulModel->countByDosenId($dosenId);

        // Total absensi yang sudah diinput
        $totalAbsensi = $absensiModel->countByDosenId($dosenId);

        // Total mahasiswa yang diajar (distinct)
        $totalMahasiswa = $absensiModel->countDistinctMahasiswaByDosenId($dosenId);

        $data = [
            'nama' => $_SESSION['nama'] ?? $_SESSION['username'],
            'nidn' => $dataDosen['nidn'] ?? '-',
            'prodi' => $dataDosen['prodi'] ?? 'Belum diisi',
            'total_matkul' => $totalMatkul,
            'total_absensi' => $totalAbsensi,
            'total_mahasiswa' => $totalMahasiswa,
            'rekap_matkul' => $absensiModel->getRekapPerMatkulByDosenId($dosenId)
        ];

        $this->view('dosen/dashboard', $data);
    }

    // ==========================================
    // INPUT ABSENSI - DIPERBAIKI
    // ==========================================

    public function inputAbsensi() {
        $dosenModel = $this->model('Dosen');
        $matkulModel = $this->model('MataKuliah');
        $mahasiswaModel = $this->model('Mahasiswa');

        $userId = $_SESSION['user_id'];
        $dataDosen = $dosenModel->getDosenByUserId($userId);
        $dosenId = $dataDosen['id'] ?? 0;

        // Ambil mata kuliah yang diampu dosen
        $matkul_list = $matkulModel->getByDosenId($dosenId);

        // Jika ada matkul_id di GET, ambil daftar mahasiswa
        $mahasiswa_list = [];
        $selected_matkul = isset($_GET['matkul_id']) ? $_GET['matkul_id'] : 0;
        $prodi_display = '';
        $angkatan_display = '';
        
        if ($selected_matkul) {
            // Ambil data mata kuliah
            $matkul = $matkulModel->getMataKuliahById($selected_matkul);
            
            if ($matkul) {
                // Ambil prodi dari kode mata kuliah (2 huruf pertama)
                $prodi = substr($matkul['kode'], 0, 2);
                $angkatan = $matkul['angkatan'] ?? date('Y');
                
                $prodi_display = $prodi;
                $angkatan_display = $angkatan;
                
                // Ambil mahasiswa berdasarkan prodi dan angkatan
                $mahasiswa_list = $mahasiswaModel->getMahasiswaByProdiAngkatan($prodi, $angkatan, $selected_matkul);
            }
        }

        $data = [
            'matkul_list' => $matkul_list,
            'mahasiswa_list' => $mahasiswa_list,
            'selected_matkul' => $selected_matkul,
            'prodi_display' => $prodi_display,
            'angkatan_display' => $angkatan_display
        ];

        $this->view('dosen/absensi/input', $data);
    }

    // ==========================================
    // PROSES SIMPAN ABSENSI (MASSAL) - DIPERBAIKI
    // ==========================================

    public function inputAbsensiStore() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $absensiModel = $this->model('Absensi');

            $matkul_id = $_POST['matkul_id'] ?? 0;
            $tanggal = $_POST['tanggal'] ?? date('Y-m-d');
            $statuses = $_POST['status'] ?? [];
            $mahasiswa_ids = $_POST['mahasiswa_id'] ?? [];

            if (empty($matkul_id) || empty($mahasiswa_ids)) {
                $_SESSION['toast'] = [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => 'Pilih mata kuliah dan mahasiswa terlebih dahulu'
                ];
                header('Location: ' . BASEURL . '/DosenController/inputAbsensi');
                exit;
            }

            $success_count = 0;
            $error_count = 0;

            foreach ($mahasiswa_ids as $index => $mahasiswa_id) {
                $status = $statuses[$index] ?? 'Hadir';
                
                // Cek apakah sudah ada absensi untuk hari ini
                $existing = $absensiModel->getByMahasiswaMatkulTanggal($mahasiswa_id, $matkul_id, $tanggal);
                if ($existing) {
                    // Update jika sudah ada
                    $result = $absensiModel->updateStatus($existing['id'], $status);
                } else {
                    // Insert baru
                    $result = $absensiModel->createAbsensi($mahasiswa_id, $matkul_id, $tanggal, $status);
                }

                if ($result['success']) {
                    $success_count++;
                } else {
                    $error_count++;
                }
            }

            // Set toast notification
            if ($success_count > 0) {
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'title' => 'Berhasil',
                    'message' => "Berhasil menyimpan $success_count absensi"
                ];
            } else {
                $_SESSION['toast'] = [
                    'type' => 'error',
                    'title' => 'Gagal',
                    'message' => "Gagal menyimpan absensi"
                ];
            }

            // Redirect ke halaman input absensi dengan matkul_id yang sama
            header('Location: ' . BASEURL . '/DosenController/inputAbsensi?matkul_id=' . $matkul_id);
            exit;
        }
    }

    // ==========================================
    // LIHAT REKAP ABSENSI
    // ==========================================

    public function rekapAbsensi() {
        $dosenModel = $this->model('Dosen');
        $absensiModel = $this->model('Absensi');
        $matkulModel = $this->model('MataKuliah');

        $userId = $_SESSION['user_id'];
        $dataDosen = $dosenModel->getDosenByUserId($userId);
        $dosenId = $dataDosen['id'] ?? 0;

        // Ambil parameter filter
        $filter_matkul = isset($_GET['filter_matkul']) ? $_GET['filter_matkul'] : '';
        $filter_tanggal = isset($_GET['filter_tanggal']) ? $_GET['filter_tanggal'] : '';
        $filter_kelas = isset($_GET['filter_kelas']) ? $_GET['filter_kelas'] : '';
        $filter_nim = isset($_GET['filter_nim']) ? $_GET['filter_nim'] : '';
        $filter_nama = isset($_GET['filter_nama']) ? $_GET['filter_nama'] : '';

        // Ambil data absensi dengan filter
        $absensi_list = $absensiModel->getByDosenIdWithFilters(
            $dosenId, 
            $filter_matkul, 
            $filter_tanggal, 
            $filter_kelas, 
            $filter_nim, 
            $filter_nama
        );

        // Ambil daftar mata kuliah untuk dropdown filter
        $matkul_list = $matkulModel->getByDosenId($dosenId);

        $data = [
            'absensi' => $absensi_list,
            'matkul_list' => $matkul_list,
            'filter_matkul' => $filter_matkul,
            'filter_tanggal' => $filter_tanggal,
            'filter_kelas' => $filter_kelas,
            'filter_nim' => $filter_nim,
            'filter_nama' => $filter_nama,
            'judul_halaman' => 'Rekap Absensi'
        ];

        $this->view('dosen/absensi/rekap', $data);
    }

    // ==========================================
    // EXPORT PDF
    // ==========================================

    public function exportPDF() {
        // Load DOMPDF
        require_once __DIR__ . '/../../vendor/autoload.php';
        
        $dosenModel = $this->model('Dosen');
        $absensiModel = $this->model('Absensi');

        $userId = $_SESSION['user_id'];
        $dataDosen = $dosenModel->getDosenByUserId($userId);
        $dosenId = $dataDosen['id'] ?? 0;

        // Ambil parameter filter
        $filter_matkul = isset($_GET['filter_matkul']) ? $_GET['filter_matkul'] : '';
        $filter_tanggal = isset($_GET['filter_tanggal']) ? $_GET['filter_tanggal'] : '';
        $filter_kelas = isset($_GET['filter_kelas']) ? $_GET['filter_kelas'] : '';

        $absensi_list = $absensiModel->getByDosenIdWithFilters(
            $dosenId, 
            $filter_matkul, 
            $filter_tanggal, 
            $filter_kelas, 
            '', 
            ''
        );

        // Generate HTML untuk PDF
        $html = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                h1 { color: #333; text-align: center; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background: #4caf50; color: white; padding: 10px; }
                td { padding: 8px; border-bottom: 1px solid #ddd; }
                .footer { margin-top: 30px; text-align: center; color: #999; font-size: 12px; }
            </style>
        </head>
        <body>
            <h1>Laporan Rekap Absensi</h1>
            <p>Dosen: ' . $_SESSION['nama'] . '</p>
            <p>Tanggal Cetak: ' . date('d-m-Y H:i') . '</p>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Mata Kuliah</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';

        if (empty($absensi_list)) {
            $html .= '<tr><td colspan="6" style="text-align:center;">Tidak ada data absensi</td></tr>';
        } else {
            $no = 1;
            foreach ($absensi_list as $abs) {
                $status_color = '#4caf50';
                if ($abs['status'] == 'Sakit') $status_color = '#ff9800';
                if ($abs['status'] == 'Izin') $status_color = '#2196f3';
                if ($abs['status'] == 'Alpa') $status_color = '#dc3545';

                $html .= '<tr>
                    <td>' . $no++ . '</td>
                    <td>' . ($abs['nim'] ?? '-') . '</td>
                    <td>' . ($abs['mahasiswa_nama'] ?? '-') . '</td>
                    <td>' . ($abs['mata_kuliah'] ?? '-') . '</td>
                    <td>' . date('d-m-Y', strtotime($abs['tanggal'])) . '</td>
                    <td style="color:' . $status_color . ';">' . ($abs['status'] ?? '-') . '</td>
                </tr>';
            }
        }

        $html .= '
                </tbody>
            </table>
            <div class="footer">Dicetak dari Sistem Absensi Mahasiswa</div>
        </body>
        </html>';

        // Generate PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('laporan_absensi_' . date('Y-m-d') . '.pdf');
        exit;
    }

    // ==========================================
    // LOGOUT
    // ==========================================

    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . '/AuthController');
        exit;
    }
}