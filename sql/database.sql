-- ==========================================
-- SISTEM ABSENSI MAHASISWA
-- Database: db_absensi_oop
-- ==========================================

-- HAPUS DATABASE JIKA SUDAH ADA (Opsional, untuk fresh install)
-- DROP DATABASE IF EXISTS db_absensi_oop;

-- BUAT DATABASE
CREATE DATABASE IF NOT EXISTS db_absensi_oop;
USE db_absensi_oop;

-- ==========================================
-- TABEL 1: USERS (Untuk Login Semua Role)
-- ==========================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'dosen', 'mahasiswa') NOT NULL,
    nama VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ==========================================
-- TABEL 2: MAHASISWA (Detail Khusus Mahasiswa)
-- ==========================================
CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nim VARCHAR(20) NOT NULL UNIQUE,
    angkatan YEAR,
    kelas VARCHAR(10),
    alamat TEXT,
    no_hp VARCHAR(15),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ==========================================
-- TABEL 3: DOSEN (Detail Khusus Dosen)
-- ==========================================
CREATE TABLE IF NOT EXISTS dosen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nidn VARCHAR(20) NOT NULL UNIQUE,
    prodi VARCHAR(50),
    alamat TEXT,
    no_hp VARCHAR(15),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ==========================================
-- TABEL 4: MATA KULIAH
-- ==========================================
CREATE TABLE IF NOT EXISTS mata_kuliah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    sks INT(1) NOT NULL DEFAULT 3,
    semester INT(1) NOT NULL,
    dosen_pengampu VARCHAR(100)
);

-- ==========================================
-- TABEL 5: ABSENSI
-- ==========================================
CREATE TABLE IF NOT EXISTS absensi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mahasiswa_id INT NOT NULL,
    matkul_id INT NOT NULL,
    tanggal DATE NOT NULL,
    status ENUM('Hadir', 'Sakit', 'Izin', 'Alpa') DEFAULT 'Alpa',
    keterangan TEXT,
    FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa(id) ON DELETE CASCADE,
    FOREIGN KEY (matkul_id) REFERENCES mata_kuliah(id) ON DELETE CASCADE
);

-- ==========================================
-- TABEL 6: SURAT IZIN
-- ==========================================
CREATE TABLE IF NOT EXISTS surat_izin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    absensi_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    jenis VARCHAR(50),
    tanggal_upload DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'disetujui', 'ditolak') DEFAULT 'pending',
    keterangan_admin TEXT,
    FOREIGN KEY (absensi_id) REFERENCES absensi(id) ON DELETE CASCADE
);

-- ==========================================
-- INDEX UNTUK OPTIMASI QUERY
-- ==========================================
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_mahasiswa_nim ON mahasiswa(nim);
CREATE INDEX idx_dosen_nidn ON dosen(nidn);
CREATE INDEX idx_absensi_tanggal ON absensi(tanggal);
CREATE INDEX idx_absensi_status ON absensi(status);
CREATE INDEX idx_surat_izin_status ON surat_izin(status);

-- ==========================================
-- VIEW: Laporan Absensi Per Mahasiswa
-- ==========================================
CREATE OR REPLACE VIEW v_rekap_absensi AS
SELECT 
    m.id AS mahasiswa_id,
    m.nim,
    m.nama AS nama_mahasiswa,
    mk.nama AS mata_kuliah,
    COUNT(a.id) AS total_pertemuan,
    SUM(CASE WHEN a.status = 'Hadir' THEN 1 ELSE 0 END) AS hadir,
    SUM(CASE WHEN a.status = 'Sakit' THEN 1 ELSE 0 END) AS sakit,
    SUM(CASE WHEN a.status = 'Izin' THEN 1 ELSE 0 END) AS izin,
    SUM(CASE WHEN a.status = 'Alpa' THEN 1 ELSE 0 END) AS alpa,
    ROUND((SUM(CASE WHEN a.status = 'Hadir' THEN 1 ELSE 0 END) / COUNT(a.id)) * 100, 2) AS persentase_kehadiran
FROM mahasiswa m
JOIN absensi a ON m.id = a.mahasiswa_id
JOIN mata_kuliah mk ON a.matkul_id = mk.id
GROUP BY m.id, m.nim, m.nama, mk.id, mk.nama;

-- ==========================================
-- VIEW: Statistik Harian Absensi
-- ==========================================
CREATE OR REPLACE VIEW v_statistik_absensi AS
SELECT 
    tanggal,
    COUNT(*) AS total_absensi,
    SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) AS hadir,
    SUM(CASE WHEN status = 'Sakit' THEN 1 ELSE 0 END) AS sakit,
    SUM(CASE WHEN status = 'Izin' THEN 1 ELSE 0 END) AS izin,
    SUM(CASE WHEN status = 'Alpa' THEN 1 ELSE 0 END) AS alpa
FROM absensi
GROUP BY tanggal
ORDER BY tanggal DESC;

-- ==========================================
-- TRIGGER: Auto Update updated_at
-- ==========================================
DELIMITER //
CREATE TRIGGER update_users_updated_at 
BEFORE UPDATE ON users
FOR EACH ROW
BEGIN
    SET NEW.updated_at = CURRENT_TIMESTAMP;
END //
DELIMITER ;

-- ==========================================
-- PROSEDUR: Tambah Mahasiswa Baru (Otomatis buat user)
-- ==========================================
DELIMITER //
CREATE PROCEDURE daftar_mahasiswa(
    IN p_email VARCHAR(100),
    IN p_password VARCHAR(255),
    IN p_nama VARCHAR(100),
    IN p_nim VARCHAR(20),
    IN p_angkatan YEAR,
    IN p_kelas VARCHAR(10)
)
BEGIN
    DECLARE v_user_id INT;
    
    -- Insert ke tabel users
    INSERT INTO users (email, password, role, nama) 
    VALUES (p_email, MD5(p_password), 'mahasiswa', p_nama);
    
    -- Ambil ID user yang baru
    SET v_user_id = LAST_INSERT_ID();
    
    -- Insert ke tabel mahasiswa
    INSERT INTO mahasiswa (user_id, nim, angkatan, kelas) 
    VALUES (v_user_id, p_nim, p_angkatan, p_kelas);
END //
DELIMITER ;

-- ==========================================
-- PROSEDUR: Tambah Dosen Baru (Otomatis buat user)
-- ==========================================
DELIMITER //
CREATE PROCEDURE daftar_dosen(
    IN p_email VARCHAR(100),
    IN p_password VARCHAR(255),
    IN p_nama VARCHAR(100),
    IN p_nidn VARCHAR(20),
    IN p_prodi VARCHAR(50)
)
BEGIN
    DECLARE v_user_id INT;
    
    INSERT INTO users (email, password, role, nama) 
    VALUES (p_email, MD5(p_password), 'dosen', p_nama);
    
    SET v_user_id = LAST_INSERT_ID();
    
    INSERT INTO dosen (user_id, nidn, prodi) 
    VALUES (v_user_id, p_nidn, p_prodi);
END //
DELIMITER ;

-- ==========================================
-- PROSEDUR: Tambah Admin Baru
-- ==========================================
DELIMITER //
CREATE PROCEDURE daftar_admin(
    IN p_email VARCHAR(100),
    IN p_password VARCHAR(255),
    IN p_nama VARCHAR(100)
)
BEGIN
    INSERT INTO users (email, password, role, nama) 
    VALUES (p_email, MD5(p_password), 'admin', p_nama);
END //
DELIMITER ;

-- ==========================================
-- FUNGSI: Hitung Persentase Kehadiran Mahasiswa
-- ==========================================
DELIMITER //
CREATE FUNCTION hitung_persentase_kehadiran(p_mahasiswa_id INT, p_matkul_id INT)
RETURNS DECIMAL(5,2)
DETERMINISTIC
BEGIN
    DECLARE total_pertemuan INT;
    DECLARE total_hadir INT;
    DECLARE hasil DECIMAL(5,2);
    
    SELECT COUNT(*) INTO total_pertemuan 
    FROM absensi 
    WHERE mahasiswa_id = p_mahasiswa_id AND matkul_id = p_matkul_id;
    
    SELECT COUNT(*) INTO total_hadir 
    FROM absensi 
    WHERE mahasiswa_id = p_mahasiswa_id AND matkul_id = p_matkul_id AND status = 'Hadir';
    
    IF total_pertemuan > 0 THEN
        SET hasil = (total_hadir / total_pertemuan) * 100;
    ELSE
        SET hasil = 0;
    END IF;
    
    RETURN hasil;
END //
DELIMITER ;