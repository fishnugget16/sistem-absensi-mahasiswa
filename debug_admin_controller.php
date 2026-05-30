<?php
// file: debug_admin_controller.php
// Simpan di folder root proyek (satu level dengan public/)

session_start();

// Load konfigurasi
require_once 'config/config.php';

// Load database
require_once 'app/core/Database.php';
require_once 'app/core/BaseModel.php';
require_once 'app/core/Controller.php';

// Load model
require_once 'app/models/SuratIzin.php';

echo "<h2>DEBUG SURAT IZIN UPDATE STATUS</h2>";

// Cek session login
echo "<h3>1. Cek Session</h3>";
echo "logged_in: " . (isset($_SESSION['logged_in']) ? $_SESSION['logged_in'] : 'TIDAK ADA') . "<br>";
echo "role: " . (isset($_SESSION['role']) ? $_SESSION['role'] : 'TIDAK ADA') . "<br>";
echo "user_id: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'TIDAK ADA') . "<br>";

// Cek apakah admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    echo "<span style='color:red'>ANDA BELUM LOGIN SEBAGAI ADMIN!</span><br>";
    echo "<a href='" . BASEURL . "/AuthController'>Login dulu</a>";
    exit;
}

echo "<span style='color:green'>✅ Session OK, Anda login sebagai admin</span><br><br>";

// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
echo "<h3>2. ID Surat Izin: " . $id . "</h3>";

// Jika ada POST (dari form)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h3>3. Form Terkirim (POST)</h3>";
    $status = $_POST['status'] ?? '';
    $keterangan = $_POST['keterangan_admin'] ?? '';
    
    echo "Status: " . $status . "<br>";
    echo "Keterangan: " . $keterangan . "<br>";
    
    if (!in_array($status, ['disetujui', 'ditolak'])) {
        echo "<span style='color:red'>❌ Status tidak valid!</span><br>";
    } else {
        $suratModel = new SuratIzin();
        $result = $suratModel->updateStatus($id, $status, $keterangan);
        
        echo "<h3>4. Hasil Update Status</h3>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        
        if ($result['success']) {
            echo "<span style='color:green'>✅ " . $result['message'] . "</span><br>";
            // Redirect balik
            echo "<br><a href='" . BASEURL . "/AdminController/surat_izin'>Kembali ke daftar surat izin</a>";
        } else {
            echo "<span style='color:red'>❌ " . $result['message'] . "</span><br>";
        }
    }
} else {
    // Jika belum ada POST, tampilkan form manual
    echo "<h3>3. Form Test Update Status</h3>";
    echo "<form method='POST'>";
    echo "<input type='hidden' name='id' value='$id'>";
    echo "<select name='status'>";
    echo "<option value='disetujui'>Setujui</option>";
    echo "<option value='ditolak'>Tolak</option>";
    echo "</select><br><br>";
    echo "<textarea name='keterangan_admin' placeholder='Keterangan (opsional)' rows='3' cols='40'></textarea><br><br>";
    echo "<button type='submit'>Update Status</button>";
    echo "</form>";
}

// Tampilkan data surat izin saat ini
echo "<h3>5. Data Surat Izin Saat Ini</h3>";
$suratModel = new SuratIzin();
$surat = $suratModel->getById($id);
if ($surat) {
    echo "<pre>";
    echo "ID: " . $surat['id'] . "<br>";
    echo "Jenis: " . $surat['jenis'] . "<br>";
    echo "Status: " . $surat['status'] . "<br>";
    echo "File: " . $surat['file_path'] . "<br>";
    echo "</pre>";
} else {
    echo "<span style='color:red'>Data surat izin tidak ditemukan! ID: $id</span><br>";
}
?>