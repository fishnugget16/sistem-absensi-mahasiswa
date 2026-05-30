<?php
session_start();

// Tentukan folder target
$targetDir = __DIR__ . '/uploads/surat/';

echo "<h2>Debug Upload File</h2>";

// Cek folder
echo "<h3>1. Cek Folder</h3>";
if (!is_dir($targetDir)) {
    echo "Folder belum ada, mencoba membuat...<br>";
    mkdir($targetDir, 0777, true);
    echo "Folder telah dibuat: " . $targetDir . "<br>";
} else {
    echo "Folder ditemukan: " . $targetDir . "<br>";
    echo "Izin folder: " . substr(sprintf('%o', fileperms($targetDir)), -4) . "<br>";
    echo "Bisa ditulisi: " . (is_writable($targetDir) ? 'YA' : 'TIDAK') . "<br>";
}

echo "<h3>2. Form Upload</h3>";
?>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="file_upload" required>
    <button type="submit" name="submit">Upload</button>
</form>

<?php
if (isset($_POST['submit'])) {
    echo "<h3>3. Hasil Upload</h3>";
    
    if ($_FILES['file_upload']['error'] !== 0) {
        echo "Error code: " . $_FILES['file_upload']['error'] . "<br>";
        $errors = [
            1 => 'File terlalu besar (max 2MB)',
            2 => 'File terlalu besar (max 2MB)',
            3 => 'File hanya terupload sebagian',
            4 => 'Tidak ada file yang diupload',
            6 => 'Folder temp tidak ditemukan',
            7 => 'Gagal menulis file ke disk',
            8 => 'Upload dihentikan oleh ekstensi'
        ];
        echo "Error: " . ($errors[$_FILES['file_upload']['error']] ?? 'Unknown error') . "<br>";
    } else {
        $fileName = time() . '_' . basename($_FILES['file_upload']['name']);
        $targetFile = $targetDir . $fileName;
        
        echo "Nama file asli: " . $_FILES['file_upload']['name'] . "<br>";
        echo "Tipe file: " . $_FILES['file_upload']['type'] . "<br>";
        echo "Ukuran file: " . round($_FILES['file_upload']['size'] / 1024, 2) . " KB<br>";
        echo "Temp file: " . $_FILES['file_upload']['tmp_name'] . "<br>";
        echo "Target file: " . $targetFile . "<br>";
        
        if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $targetFile)) {
            echo "<span style='color:green'>✓ BERHASIL upload!</span><br>";
            echo "File disimpan di: " . $targetFile . "<br>";
        } else {
            echo "<span style='color:red'>✗ GAGAL upload!</span><br>";
            $error = error_get_last();
            echo "Error detail: " . ($error ? $error['message'] : 'Unknown') . "<br>";
        }
    }
}
?>