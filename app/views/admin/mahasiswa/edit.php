<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data</title>
</head>
<body style="font-family: Arial; margin: 20px;">

    <h2>Form Edit Data (<?= ucfirst($data['tipe']); ?>)</h2>
    <hr>

    <form action="<?= BASEURL; ?>/AdminController/update/<?= $data['mahasiswa']['id']; ?>/<?= $data['tipe']; ?>" method="POST" style="width: 300px;">
        
        <div style="margin-bottom: 10px;">
            <!-- REVISI LABEL 1 -->
            <label style="display: block; font-weight: bold;">
                <?php 
                if ($data['tipe'] == 'dosen') echo 'NIDN Dosen:';
                elseif ($data['tipe'] == 'matkul') echo 'Kode Mata Kuliah:';
                else echo 'NIM Mahasiswa:';
                ?>
            </label>
            <input type="text" name="nim" value="<?= $data['mahasiswa']['nim']; ?>" required style="width: 100%; padding: 5px;">
        </div>

        <div style="margin-bottom: 10px;">
            <!-- REVISI LABEL 2 -->
            <label style="display: block; font-weight: bold;">
                <?php 
                if ($data['tipe'] == 'dosen') echo 'Nama Lengkap Dosen:';
                elseif ($data['tipe'] == 'matkul') echo 'Nama Mata Kuliah:';
                else echo 'Nama Lengkap Mahasiswa:';
                ?>
            </label>
            <input type="text" name="nama" value="<?= $data['mahasiswa']['nama']; ?>" required style="width: 100%; padding: 5px;">
        </div>

        <div style="margin-bottom: 15px;">
            <!-- REVISI LABEL 3 -->
            <label style="display: block; font-weight: bold;">
                <?php 
                if ($data['tipe'] == 'dosen') echo 'Mata Kuliah Diampu:';
                elseif ($data['tipe'] == 'matkul') echo 'Jumlah SKS:';
                else echo 'Jurusan / Prodi:';
                ?>
            </label>
            <input type="text" name="jurusan" value="<?= $data['mahasiswa']['jurusan']; ?>" required style="width: 100%; padding: 5px;">
        </div>

        <button type="submit" name="submit" style="background: orange; color: black; padding: 5px 10px; cursor: pointer; font-weight: bold;">Perbarui Data</button>
        <a href="<?= BASEURL; ?>/AdminController/<?= $data['tipe']; ?>" style="margin-left: 10px; color: black;">Batal</a>

    </form>

</body>
</html>
