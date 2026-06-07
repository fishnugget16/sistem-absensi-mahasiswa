<?php
/**
 * DEBUG FILTER HISTORI SURAT IZIN
 * Akses: http://localhost/aplikasi-absensi-mahasiswa/public/debug_filter_histori.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Load konfigurasi dan database
require_once '../config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/BaseModel.php';
require_once '../app/models/SuratIzin.php';
require_once '../app/models/Absensi.php';
require_once '../app/models/Mahasiswa.php';

echo "<!DOCTYPE html>";
echo "<html><head><title>Debug Filter Histori Surat</title>";
echo "<style>
    body { font-family: monospace; background: #121212; color: #e8eaed; padding: 20px; }
    .success { color: #4caf50; }
    .error { color: #dc3545; }
    .warning { color: #ff9800; }
    .box { background: #1e1e1e; border: 1px solid #2a2a2a; border-radius: 8px; padding: 15px; margin: 10px 0; }
    hr { border-color: #2a2a2a; }
    h3 { color: #4caf50; }
    pre { background: #2a2a2a; padding: 10px; border-radius: 5px; overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 8px; text-align: left; border-bottom: 1px solid #2a2a2a; }
    th { color: #4caf50; }
</style>";
echo "</head><body>";

echo "<h1>🔍 DEBUG FILTER HISTORI SURAT IZIN</h1>";
echo "<hr>";

// ========== 1. CEK SESSION ==========
echo "<div class='box'>";
echo "<h3>1. CEK SESSION</h3>";
echo "<pre>";
echo "Session ID: " . session_id() . "\n";
echo "Isi Session:\n";
print_r($_SESSION);
echo "</pre>";

$user_id = $_SESSION['user_id'] ?? 0;
$role = $_SESSION['role'] ?? 'tidak ada';

echo "<p>User ID: <strong>" . $user_id . "</strong></p>";
echo "<p>Role: <strong>" . $role . "</strong></p>";

if ($role !== 'mahasiswa') {
    echo "<p class='error'>❌ Role bukan mahasiswa! Silakan login sebagai mahasiswa.</p>";
}
echo "</div>";

// ========== 2. CEK DATA MAHASISWA ==========
echo "<div class='box'>";
echo "<h3>2. CEK DATA MAHASISWA</h3>";

try {
    $mahasiswaModel = new Mahasiswa();
    $dataMahasiswa = $mahasiswaModel->getMahasiswaByUserId($user_id);
    
    if ($dataMahasiswa) {
        echo "<p class='success'>✅ Data mahasiswa ditemukan</p>";
        echo "<pre>";
        echo "ID Mahasiswa: " . ($dataMahasiswa['id'] ?? 'tidak ada') . "\n";
        echo "Nama: " . ($dataMahasiswa['nama'] ?? 'tidak ada') . "\n";
        echo "NIM: " . ($dataMahasiswa['nim'] ?? 'tidak ada') . "\n";
        echo "Kelas: " . ($dataMahasiswa['kelas'] ?? 'tidak ada') . "\n";
        echo "</pre>";
        $mahasiswa_id = $dataMahasiswa['id'] ?? 0;
    } else {
        echo "<p class='error'>❌ Data mahasiswa tidak ditemukan untuk user_id: $user_id</p>";
        $mahasiswa_id = 0;
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
    $mahasiswa_id = 0;
}
echo "</div>";

// ========== 3. CEK DATA ABSENSI MAHASISWA ==========
echo "<div class='box'>";
echo "<h3>3. CEK DATA ABSENSI MAHASISWA</h3>";

if ($mahasiswa_id > 0) {
    try {
        $absensiModel = new Absensi();
        $absensiList = $absensiModel->getByMahasiswaId($mahasiswa_id);
        
        echo "<p>Total data absensi: <strong>" . count($absensiList) . "</strong></p>";
        
        if (count($absensiList) > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Tanggal</th><th>Mata Kuliah</th><th>Status</th></tr>";
            foreach ($absensiList as $abs) {
                echo "<tr>";
                echo "<td>" . ($abs['id'] ?? '-') . "</td>";
                echo "<td>" . ($abs['tanggal'] ?? '-') . "</td>";
                echo "<td>" . ($abs['mata_kuliah'] ?? '-') . "</td>";
                echo "<td>" . ($abs['status'] ?? '-') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='warning'>⚠️ Mahasiswa belum memiliki data absensi</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='error'>❌ Mahasiswa ID tidak valid</p>";
}
echo "</div>";

// ========== 4. CEK DATA SURAT IZIN ==========
echo "<div class='box'>";
echo "<h3>4. CEK DATA SURAT IZIN</h3>";

if ($mahasiswa_id > 0) {
    try {
        $suratModel = new SuratIzin();
        
        // Test semua filter
        $filters = ['semua', 'pending', 'disetujui', 'ditolak'];
        
        foreach ($filters as $filter) {
            $data = $suratModel->getByMahasiswaIdWithFilter($mahasiswa_id, $filter);
            echo "<p><strong>Filter: $filter</strong> → Jumlah data: <strong class='success'>" . count($data) . "</strong></p>";
            
            if (count($data) > 0) {
                echo "<table>";
                echo "<tr><th>Mata Kuliah</th><th>Status</th><th>Jenis</th><th>Tanggal Upload</th></tr>";
                foreach ($data as $sz) {
                    $status_color = '#ff9800';
                    if ($sz['status'] == 'disetujui') $status_color = '#4caf50';
                    if ($sz['status'] == 'ditolak') $status_color = '#dc3545';
                    echo "<tr>";
                    echo "<td>" . ($sz['mata_kuliah'] ?? '-') . "</td>";
                    echo "<td style='color:$status_color;'>" . ($sz['status'] ?? '-') . "</td>";
                    echo "<td>" . ($sz['jenis'] ?? '-') . "</td>";
                    echo "<td>" . ($sz['tanggal_upload'] ?? '-') . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
        
        // Hitung statistik
        $total = $suratModel->countByMahasiswaId($mahasiswa_id);
        $pending = $suratModel->countByMahasiswaIdAndStatus($mahasiswa_id, 'pending');
        $disetujui = $suratModel->countByMahasiswaIdAndStatus($mahasiswa_id, 'disetujui');
        $ditolak = $suratModel->countByMahasiswaIdAndStatus($mahasiswa_id, 'ditolak');
        
        echo "<hr>";
        echo "<p><strong>📊 STATISTIK SURAT IZIN:</strong></p>";
        echo "<p>Total: $total</p>";
        echo "<p>Pending: $pending</p>";
        echo "<p>Disetujui: $disetujui</p>";
        echo "<p>Ditolak: $ditolak</p>";
        
    } catch (Exception $e) {
        echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='error'>❌ Mahasiswa ID tidak valid</p>";
}
echo "</div>";

// ========== 5. CEK URL PARAMETER ==========
echo "<div class='box'>";
echo "<h3>5. CEK URL PARAMETER</h3>";

$status_param = isset($_GET['status']) ? $_GET['status'] : 'tidak ada';
echo "<p>Parameter status dari URL: <strong class='warning'>" . $status_param . "</strong></p>";

echo "<p>🔗 Coba akses URL berikut untuk test filter:</p>";
echo "<ul>";
echo "<li><a href='debug_filter_histori.php?status=semua' style='color:#4caf50;'>Semua</a></li>";
echo "<li><a href='debug_filter_histori.php?status=pending' style='color:#4caf50;'>Menunggu (pending)</a></li>";
echo "<li><a href='debug_filter_histori.php?status=disetujui' style='color:#4caf50;'>Disetujui</a></li>";
echo "<li><a href='debug_filter_histori.php?status=ditolak' style='color:#4caf50;'>Ditolak</a></li>";
echo "</ul>";
echo "</div>";

// ========== 6. KESIMPULAN ==========
echo "<div class='box'>";
echo "<h3>6. KESIMPULAN & REKOMENDASI</h3>";

if ($mahasiswa_id == 0) {
    echo "<p class='error'>❌ Mahasiswa ID tidak ditemukan. Pastikan login sebagai mahasiswa.</p>";
} else {
    $totalData = $suratModel->countByMahasiswaId($mahasiswa_id);
    if ($totalData == 0) {
        echo "<p class='warning'>⚠️ Mahasiswa belum memiliki data surat izin. Upload surat izin terlebih dahulu.</p>";
    } else {
        echo "<p class='success'>✅ Data surat izin ada. Filter seharusnya berfungsi.</p>";
    }
}

echo "<hr>";
echo "<p>📌 <strong>CARA UJI FILTER:</strong></p>";
echo "<ol>";
echo "<li>Klik link filter di atas (Semua/Menunggu/Disetujui/Ditolak)</li>";
echo "<li>Lihat apakah jumlah data berubah sesuai filter</li>";
echo "<li>Jika jumlah data tidak berubah, ada masalah di query SQL</li>";
echo "</ol>";

echo "<p>🔗 <strong>UJI LANGSUNG DI HALAMAN ASLI:</strong></p>";
echo "<p><a href='" . BASEURL . "/MahasiswaController/historiSurat' style='color:#4caf50;'>Halaman Histori Surat</a></p>";

echo "</div>";

echo "<hr>";
echo "<p class='success'>✅ DEBUG SELESAI</p>";
echo "</body></html>";