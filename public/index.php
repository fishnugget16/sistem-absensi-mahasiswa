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

// ==========================================
// DEFAULT (HALAMAN LOGIN)
// ==========================================

require_once '../app/controllers/AuthController.php';
$controller = new AuthController();
$controller->index();