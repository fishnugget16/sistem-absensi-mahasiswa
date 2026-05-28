<?php

class AdminController extends Controller {

    // Konstruktor untuk keamanan: wajib login sebelum masuk menu admin
    public function __construct() {
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . BASEURL . '/AuthController');
            exit;
        }
    }

    // MENU 1: Menampilkan tabel data mahasiswa
    public function mahasiswa() {
        $mhsModel = $this->model('Mahasiswa');
        $data['judul_halaman'] = "Manajemen Data Mahasiswa";
        $data['kolom_id'] = "NIM";
        $data['tipe'] = "mahasiswa"; // Tambahan penanda tipe halaman
        $data['mahasiswa'] = $mhsModel->getAllMahasiswa();
        
        $this->view('admin/mahasiswa/index', $data);
    }

    // MENU 2: Menampilkan data Dosen (Pak Aldo) menggunakan file view yang sama
    public function dosen() {
        $mhsModel = $this->model('Mahasiswa');
        $data['judul_halaman'] = "Manajemen Data Dosen";
        $data['kolom_id'] = "NIDN / Kode Dosen";
        $data['tipe'] = "dosen"; // Tambahan penanda tipe halaman
        $data['mahasiswa'] = $mhsModel->getAllDosen();
        
        $this->view('admin/mahasiswa/index', $data);
    }

    // MENU 3: Menampilkan data Mata Kuliah menggunakan file view yang sama
    public function matakuliah() {
        $mhsModel = $this->model('Mahasiswa');
        $data['judul_halaman'] = "Manajemen Data Mata Kuliah";
        $data['kolom_id'] = "Kode Matkul";
        $data['tipe'] = "matkul"; // Tambahan penanda tipe halaman
        $data['mahasiswa'] = $mhsModel->getAllMatkul();
        
        $this->view('admin/mahasiswa/index', $data);
    }

    // -----------------------------------------------------------------
    // PROSES MANIPULASI DATA (DINAMIS MAHASISWA / DOSEN / MATKUL)
    // -----------------------------------------------------------------

    // REVISI FUNGSI CREATE: Mengirimkan data tipe halaman ke file view
    public function create($tipe = 'mahasiswa') {
        $data['tipe'] = $tipe; // Kunci perbaikan: baris ini wajib ada
        $this->view('admin/mahasiswa/create', $data);
    }

    // REVISI FUNGSI STORE: Memproses simpan data baru berdasarkan tipe halon
    public function store($tipe = 'mahasiswa') {
        if (isset($_POST['submit'])) {
            $mhsModel = $this->model('Mahasiswa');
            $mhsModel->tambahDinamis($_POST, $tipe);
            
            header('Location: ' . BASEURL . '/AdminController/' . $tipe);
            exit;
        }
    }

    // PERBAIKAN: Ditambahkan parameter $tipe agar bisa mengambil data lama dosen/matkul berdasarkan ID
    public function edit($id, $tipe = 'mahasiswa') {
        $mhsModel = $this->model('Mahasiswa');
        $data['mahasiswa'] = $mhsModel->getByIdDinamis($id, $tipe); // Memanggil fungsi dinamis baru di model
        $data['tipe'] = $tipe;
        
        $this->view('admin/mahasiswa/edit', $data);
    }

    // PERBAIKAN: Memproses update data berdasarkan tipenya, lalu melempar kembali ke halaman menu yang sesuai
    public function update($id, $tipe = 'mahasiswa') {
        if (isset($_POST['submit'])) {
            $mhsModel = $this->model('Mahasiswa');
            $mhsModel->updateDinamis($_POST, $id, $tipe); // Memanggil fungsi update dinamis baru di model
            
            header('Location: ' . BASEURL . '/AdminController/' . $tipe);
            exit;
        }
    }

    // PERBAIKAN: Memproses hapus data berdasarkan tipenya, lalu melempar kembali ke halaman menu yang sesuai
    public function delete($id, $tipe = 'mahasiswa') {
        $mhsModel = $this->model('Mahasiswa');
        $mhsModel->deleteDinamis($id, $tipe); // Memanggil fungsi hapus dinamis baru di model
        
        header('Location: ' . BASEURL . '/AdminController/' . $tipe);
        exit;
    }
}
