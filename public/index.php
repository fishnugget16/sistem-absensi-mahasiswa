<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/BaseModel.php';
require_once '../app/core/Controller.php';
require_once '../app/models/User.php';
require_once '../app/models/Mahasiswa.php';
require_once '../app/models/Dosen.php';
require_once '../app/models/MataKuliah.php';
require_once '../app/models/Absensi.php';
require_once '../app/models/SuratIzin.php';

$url = isset($_GET['url']) ? $_GET['url'] : '';

// ==========================================
// ROUTING AUTH CONTROLLER
// ==========================================

if ($url === 'AuthController/registerForm') {
    require_once '../app/controllers/AuthController.php';
    $controller = new AuthController();
    $controller->registerForm();
    exit;
}

if ($url === 'AuthController/register') {
    require_once '../app/controllers/AuthController.php';
    $controller = new AuthController();
    $controller->register();
    exit;
}

if ($url === 'AuthController/login') {
    require_once '../app/controllers/AuthController.php';
    $controller = new AuthController();
    $controller->login();
    exit;
}

if ($url === 'AuthController/logout') {
    require_once '../app/controllers/AuthController.php';
    $controller = new AuthController();
    $controller->logout();
    exit;
}

if ($url === 'AuthController/dashboard') {
    require_once '../app/controllers/AuthController.php';
    $controller = new AuthController();
    $controller->dashboard();
    exit;
}

// ==========================================
// ROUTING ADMIN CONTROLLER (MAHASISWA)
// ==========================================

if ($url === 'AdminController/mahasiswa') {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->mahasiswa();
    exit;
}

if ($url === 'AdminController/mahasiswaCreate') {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->mahasiswaCreate();
    exit;
}

if ($url === 'AdminController/mahasiswaStore') {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->mahasiswaStore();
    exit;
}

if (preg_match('/AdminController\/mahasiswaEdit\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->mahasiswaEdit($matches[1]);
    exit;
}

if (preg_match('/AdminController\/mahasiswaUpdate\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->mahasiswaUpdate($matches[1]);
    exit;
}

if (preg_match('/AdminController\/mahasiswaDelete\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->mahasiswaDelete($matches[1]);
    exit;
}

// ==========================================
// ROUTING ADMIN CONTROLLER (DOSEN)
// ==========================================

if ($url === 'AdminController/dosen') {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->dosen();
    exit;
}

if ($url === 'AdminController/dosenCreate') {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->dosenCreate();
    exit;
}

if ($url === 'AdminController/dosenStore') {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->dosenStore();
    exit;
}

if (preg_match('/AdminController\/dosenEdit\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->dosenEdit($matches[1]);
    exit;
}

if (preg_match('/AdminController\/dosenUpdate\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->dosenUpdate($matches[1]);
    exit;
}

if (preg_match('/AdminController\/dosenDelete\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->dosenDelete($matches[1]);
    exit;
}

// ==========================================
// ROUTING ADMIN CONTROLLER (ASSIGN MATA KULIAH) - 🔥 BARU
// ==========================================

if (preg_match('/AdminController\/getMatkulByDosen\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->getMatkulByDosen($matches[1]);
    exit;
}

if ($url === 'AdminController/assignMatkul') {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->assignMatkul();
    exit;
}

if ($url === 'AdminController/removeMatkul') {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->removeMatkul();
    exit;
}

// ==========================================
// ROUTING ADMIN CONTROLLER (MATA KULIAH)
// ==========================================

if ($url === 'AdminController/matakuliah') {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->matakuliah();
    exit;
}

if ($url === 'AdminController/matakuliahCreate') {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->matakuliahCreate();
    exit;
}

if ($url === 'AdminController/matakuliahStore') {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->matakuliahStore();
    exit;
}

if (preg_match('/AdminController\/matakuliahEdit\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->matakuliahEdit($matches[1]);
    exit;
}

if (preg_match('/AdminController\/matakuliahUpdate\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->matakuliahUpdate($matches[1]);
    exit;
}

if (preg_match('/AdminController\/matakuliahDelete\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->matakuliahDelete($matches[1]);
    exit;
}

// ==========================================
// ROUTING MAHASISWA CONTROLLER
// ==========================================

if ($url === 'MahasiswaController/index') {
    require_once '../app/controllers/MahasiswaController.php';
    $controller = new MahasiswaController();
    $controller->index();
    exit;
}

if ($url === 'MahasiswaController/absensi') {
    require_once '../app/controllers/MahasiswaController.php';
    $controller = new MahasiswaController();
    $controller->absensi();
    exit;
}

if ($url === 'MahasiswaController/uploadSurat') {
    require_once '../app/controllers/MahasiswaController.php';
    $controller = new MahasiswaController();
    $controller->uploadSurat();
    exit;
}

if ($url === 'MahasiswaController/logout') {
    require_once '../app/controllers/MahasiswaController.php';
    $controller = new MahasiswaController();
    $controller->logout();
    exit;
}

if ($url === 'MahasiswaController/uploadSuratStore') {
    require_once '../app/controllers/MahasiswaController.php';
    $controller = new MahasiswaController();
    $controller->uploadSuratStore();
    exit;
}

// ==========================================
// ROUTING MAHASISWA CONTROLLER (HISTORI SURAT)
// ==========================================

if ($url === 'MahasiswaController/historiSurat') {
    require_once '../app/controllers/MahasiswaController.php';
    $controller = new MahasiswaController();
    $controller->historiSurat();
    exit;
}

// ==========================================
// ROUTING SURAT IZIN (ADMIN)
// ==========================================

if ($url === 'AdminController/surat_izin') {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->surat_izin();
    exit;
}

if (preg_match('/AdminController\/surat_izin_detail\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->surat_izin_detail($matches[1]);
    exit;
}

if (preg_match('/AdminController\/surat_izin_update_status\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->surat_izin_update_status($matches[1]);
    exit;
}

if (preg_match('/AdminController\/surat_izin_delete\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->surat_izin_delete($matches[1]);
    exit;
}

if (preg_match('/AdminController\/surat_izin_download\/(\d+)/', $url, $matches)) {
    require_once '../app/controllers/AdminController.php';
    $controller = new AdminController();
    $controller->surat_izin_download($matches[1]);
    exit;
}

// ==========================================
// ROUTING DOSEN CONTROLLER
// ==========================================

if ($url === 'DosenController/index') {
    require_once '../app/controllers/DosenController.php';
    $controller = new DosenController();
    $controller->index();
    exit;
}

if ($url === 'DosenController/inputAbsensi') {
    require_once '../app/controllers/DosenController.php';
    $controller = new DosenController();
    $controller->inputAbsensi();
    exit;
}

if ($url === 'DosenController/inputAbsensiStore') {
    require_once '../app/controllers/DosenController.php';
    $controller = new DosenController();
    $controller->inputAbsensiStore();
    exit;
}

if ($url === 'DosenController/rekapAbsensi') {
    require_once '../app/controllers/DosenController.php';
    $controller = new DosenController();
    $controller->rekapAbsensi();
    exit;
}

if ($url === 'DosenController/exportPDF') {
    require_once '../app/controllers/DosenController.php';
    $controller = new DosenController();
    $controller->exportPDF();
    exit;
}

if ($url === 'DosenController/logout') {
    require_once '../app/controllers/DosenController.php';
    $controller = new DosenController();
    $controller->logout();
    exit;
}

// ==========================================
// DEFAULT (HALAMAN LOGIN)
// ==========================================

require_once '../app/controllers/AuthController.php';
$controller = new AuthController();
$controller->index();