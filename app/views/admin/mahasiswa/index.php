<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $data['judul_halaman']; ?></title>
</head>
<body style="font-family: Arial; margin: 20px;">

    <h2><?= $data['judul_halaman']; ?></h2>
    <hr>
    
    <p>
        <!-- Tombol tambah data dinamis -->
        <a href="<?= BASEURL; ?>/AdminController/create/<?= $data['tipe']; ?>" style="background: green; color: white; padding: 5px 10px; text-decoration: none;">+ Tambah Data <?= ucfirst($data['tipe']); ?></a>


        | 
        <a href="<?= BASEURL; ?>/AuthController/dashboard" style="background: #333; color: white; padding: 5px 10px; text-decoration: none;">Kembali ke Dashboard</a>
    </p>

    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead style="background-color: #eee;">
            <tr>
                <th>No</th>
                
                <!-- REVISI HEADER TABEL: Menentukan nama kolom atas secara spesifik -->
                <th>
                    <?php 
                    if ($data['tipe'] == 'dosen') echo 'NIDN';
                    elseif ($data['tipe'] == 'matkul') echo 'Kode Matkul';
                    else echo 'NIM';
                    ?>
                </th>
                <th>
                    <?php 
                    if ($data['tipe'] == 'dosen') echo 'Nama Dosen';
                    elseif ($data['tipe'] == 'matkul') echo 'Nama Mata Kuliah';
                    else echo 'Nama Mahasiswa';
                    ?>
                </th>
                <th>
                    <?php 
                    if ($data['tipe'] == 'dosen') echo 'Mata Kuliah Diampu';
                    elseif ($data['tipe'] == 'matkul') echo 'SKS';
                    else echo 'Jurusan';
                    ?>
                </th>
                
                <th>Aksi Kelola</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $nomor = 1;
            foreach($data['mahasiswa'] as $mhs) : 
            ?>
            <tr>
                <td><?= $nomor++; ?></td>
                <td><?= $mhs['nim']; ?></td>
                <td><?= $mhs['nama']; ?></td>
                <td><?= $mhs['jurusan']; ?></td>
                <td>
                    <!-- Link aksi membawa parameter tipe halaman -->
                    <a href="<?= BASEURL; ?>/AdminController/edit/<?= $mhs['id']; ?>/<?= $data['tipe']; ?>" style="color: blue;">Edit</a> | 
                    <a href="<?= BASEURL; ?>/AdminController/delete/<?= $mhs['id']; ?>/<?= $data['tipe']; ?>" style="color: red;" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
