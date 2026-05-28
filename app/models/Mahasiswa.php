<?php
// Pastikan BaseModel ter-load dengan aman
require_once __DIR__ . '/../core/BaseModel.php';

class Mahasiswa extends BaseModel {

    public function __construct() {
        if (method_exists('BaseModel', '__construct')) { 
            parent::__construct(); 
        }

        // 1. DATA DUMMY: 2 Orang Mahasiswa
        if (!isset($_SESSION['daftar_mahasiswa'])) {
            $_SESSION['daftar_mahasiswa'] = [
                ['id' => 1, 'nim' => '422025016', 'nama' => 'Federico', 'jurusan' => 'Teknik Informatika'],
                ['id' => 2, 'nim' => '422025014', 'nama' => 'Farrel', 'jurusan' => 'Sistem Informasi']
            ];
        }
        
        // 2. DATA DUMMY: 1 Orang Dosen bernama Aldo
        if (!isset($_SESSION['daftar_dosen'])) {
            $_SESSION['daftar_dosen'] = [
                ['id' => 1, 'nim' => 'D001', 'nama' => 'Aldo, M.T.', 'jurusan' => 'Dosen OOP']
            ];
        }
        
        // 3. DATA DUMMY: 1 Data Mata Kuliah
        if (!isset($_SESSION['daftar_matkul'])) {
            $_SESSION['daftar_matkul'] = [
                ['id' => 1, 'nim' => 'MK01', 'nama' => 'Object Oriented Programming', 'jurusan' => '3 SKS']
            ];
        }
    }

    // ==========================================
    // FUNGSI MEMANGGIL DATA (READ)
    // ==========================================

    public function getAllMahasiswa() { return $_SESSION['daftar_mahasiswa']; }
    public function getAllDosen() { return $_SESSION['daftar_dosen']; }
    public function getAllMatkul() { return $_SESSION['daftar_matkul']; }

    // Fungsi Ambil Data Berdasarkan ID Secara Dinamis
    public function getByIdDinamis($id, $tipe) {
        $session_name = ($tipe == 'dosen') ? 'daftar_dosen' : (($tipe == 'matkul') ? 'daftar_matkul' : 'daftar_mahasiswa');
        foreach ($_SESSION[$session_name] as $item) {
            if ($item['id'] == $id) return $item;
        }
        return null;
    }

    // ==========================================
    // FUNGSI MANIPULASI DATA (CRUD DINAMIS)
    // ==========================================

    // Fungsi Tambah Data Dinamis (Mahasiswa / Dosen / Matkul)
    public function tambahDinamis($data, $tipe) {
        $session_name = ($tipe == 'dosen') ? 'daftar_dosen' : (($tipe == 'matkul') ? 'daftar_matkul' : 'daftar_mahasiswa');
        
        // Hitung ID otomatis secara aman
        $newId = count($_SESSION[$session_name]) > 0 ? end($_SESSION[$session_name])['id'] + 1 : 1;
        
        $dataBaru = [
            'id' => $newId,
            'nim' => $data['nim'],
            'nama' => $data['nama'],
            'jurusan' => $data['jurusan']
        ];
        
        $_SESSION[$session_name][] = $dataBaru;
        return true;
    }

    // Fungsi Update Dinamis (Mahasiswa / Dosen / Matkul)
    public function updateDinamis($data, $id, $tipe) {
        $session_name = ($tipe == 'dosen') ? 'daftar_dosen' : (($tipe == 'matkul') ? 'daftar_matkul' : 'daftar_mahasiswa');
        foreach ($_SESSION[$session_name] as $key => $item) {
            if ($item['id'] == $id) {
                $_SESSION[$session_name][$key]['nim'] = $data['nim'];
                $_SESSION[$session_name][$key]['nama'] = $data['nama'];
                $_SESSION[$session_name][$key]['jurusan'] = $data['jurusan'];
                return true;
            }
        }
        return false;
    }

    // Fungsi Hapus Dinamis (Mahasiswa / Dosen / Matkul)
    public function deleteDinamis($id, $tipe) {
        $session_name = ($tipe == 'dosen') ? 'daftar_dosen' : (($tipe == 'matkul') ? 'daftar_matkul' : 'daftar_mahasiswa');
        foreach ($_SESSION[$session_name] as $key => $item) {
            if ($item['id'] == $id) {
                unset($_SESSION[$session_name][$key]);
                $_SESSION[$session_name] = array_values($_SESSION[$session_name]);
                return true;
            }
        }
        return false;
    }
} // Tanda kurung kurawal penutup class dipastikan berada paling akhir
