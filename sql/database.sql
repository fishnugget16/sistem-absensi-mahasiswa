CREATE DATABASE IF NOT EXISTS db_absensi_oop;
USE db_absensi_oop;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE, -- TAMBAHAN: Kolom email baru
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'dosen', 'mahasiswa') NOT NULL
);

CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    nim VARCHAR(15) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    jurusan VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Data Awal: Kita masukkan username, email, password, dan role-nya
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@gmail.com', 'admin123', 'admin'),
('dosen1', 'dosen@gmail.com', 'dosen123', 'dosen'),
('mhs1', 'mahasiswa@gmail.com', 'mhs123', 'mahasiswa');
