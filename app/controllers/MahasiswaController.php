<?php

class MahasiswaController extends Controller {
    
    // Constructor: cek login dan role mahasiswa
    public function __construct() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'mahasiswa') {
            header('Location: ' . BASEURL . '/AuthController');
            exit;
        }
    }
    
    // Halaman dashboard mahasiswa
    public function index() {
        $data = [
            'nama' => $_SESSION['nama'] ?? $_SESSION['username'],
            'nim' => $_SESSION['nim'] ?? '-',
            'email' => $_SESSION['email'] ?? '-'
        ];
    
        $this->view('mahasiswa/dashboard', $data);
    }
    
    // Lihat absensi sendiri
    public function absensi() {
        // Nanti diisi oleh Person 3
        $this->view('mahasiswa/absensi/lihat');
    }
    
    // Upload surat izin
    public function uploadSurat() {
        // Nanti diisi oleh Person 3
        $this->view('mahasiswa/surat/upload');
    }
    
    // Logout
    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . '/AuthController');
        exit;
    }
}