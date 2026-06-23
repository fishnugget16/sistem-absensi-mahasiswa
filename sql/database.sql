-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 22, 2026 at 12:48 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_absensi_oop`
--
CREATE DATABASE IF NOT EXISTS `db_absensi_oop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_absensi_oop`;

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Sakit','Izin','Alpa') DEFAULT 'Alpa',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nidn` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `prodi` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `prodi` varchar(50) DEFAULT NULL,
  `angkatan` year(4) DEFAULT NULL,
  `kelas` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Triggers `mahasiswa`
--
DELIMITER $$
CREATE TRIGGER `before_insert_mahasiswa` BEFORE INSERT ON `mahasiswa` FOR EACH ROW BEGIN
    IF NEW.prodi IS NULL OR NEW.prodi = '' THEN
        IF NEW.kelas IS NOT NULL AND NEW.kelas != '' THEN
            SET NEW.prodi = UPPER(SUBSTRING(NEW.kelas, 1, 2));
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_mahasiswa` BEFORE UPDATE ON `mahasiswa` FOR EACH ROW BEGIN
    IF NEW.prodi IS NULL OR NEW.prodi = '' THEN
        IF NEW.kelas IS NOT NULL AND NEW.kelas != '' THEN
            SET NEW.prodi = UPPER(SUBSTRING(NEW.kelas, 1, 2));
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `sks` int(1) DEFAULT 3,
  `jumlah_pertemuan` int(11) DEFAULT 14,
  `semester` int(1) DEFAULT 1,
  `angkatan` year(4) DEFAULT NULL,
  `dosen_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `matkul_mahasiswa`
--

CREATE TABLE `matkul_mahasiswa` (
  `id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_izin`
--

CREATE TABLE `surat_izin` (
  `id` int(11) NOT NULL,
  `absensi_id` int(11) DEFAULT NULL,
  `mahasiswa_id` int(11) DEFAULT NULL,
  `matkul_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `keterangan_admin` text DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `tanggal_upload` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dosen','mahasiswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_mahasiswa_per_matkul`
-- (See below for the actual view)
--
CREATE TABLE `v_mahasiswa_per_matkul` (
`matkul_id` int(11)
,`kode` varchar(10)
,`mata_kuliah` varchar(100)
,`semester` int(1)
,`sks` int(1)
,`dosen_id` int(11)
,`dosen_pengampu` varchar(100)
,`dosen_prodi` varchar(50)
,`mahasiswa_id` int(11)
,`nim` varchar(20)
,`mahasiswa_nama` varchar(100)
,`mahasiswa_prodi` varchar(50)
,`mahasiswa_kelas` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_rekap_absensi`
-- (See below for the actual view)
--
CREATE TABLE `v_rekap_absensi` (
`mahasiswa_id` int(11)
,`nim` varchar(20)
,`nama_mahasiswa` varchar(100)
,`prodi_mahasiswa` varchar(50)
,`kelas` varchar(255)
,`matkul_id` int(11)
,`kode` varchar(10)
,`mata_kuliah` varchar(100)
,`total_pertemuan` bigint(21)
,`hadir` decimal(22,0)
,`sakit` decimal(22,0)
,`izin` decimal(22,0)
,`alpa` decimal(22,0)
,`persentase_kehadiran` decimal(28,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_statistik_absensi`
-- (See below for the actual view)
--
CREATE TABLE `v_statistik_absensi` (
`tanggal` date
,`total_absensi` bigint(21)
,`hadir` decimal(22,0)
,`sakit` decimal(22,0)
,`izin` decimal(22,0)
,`alpa` decimal(22,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_statistik_mahasiswa`
-- (See below for the actual view)
--
CREATE TABLE `v_statistik_mahasiswa` (
`mahasiswa_id` int(11)
,`nim` varchar(20)
,`mahasiswa_nama` varchar(100)
,`prodi` varchar(50)
,`kelas` varchar(255)
,`total_absensi` bigint(21)
,`hadir` decimal(22,0)
,`sakit` decimal(22,0)
,`izin` decimal(22,0)
,`alpa` decimal(22,0)
,`persentase_kehadiran` decimal(28,2)
);

-- --------------------------------------------------------

--
-- Structure for view `v_mahasiswa_per_matkul`
--
DROP TABLE IF EXISTS `v_mahasiswa_per_matkul`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_mahasiswa_per_matkul`  AS SELECT `mk`.`id` AS `matkul_id`, `mk`.`kode` AS `kode`, `mk`.`nama` AS `mata_kuliah`, `mk`.`semester` AS `semester`, `mk`.`sks` AS `sks`, `d`.`id` AS `dosen_id`, `d`.`nama` AS `dosen_pengampu`, `d`.`prodi` AS `dosen_prodi`, `m`.`id` AS `mahasiswa_id`, `m`.`nim` AS `nim`, `m`.`nama` AS `mahasiswa_nama`, `m`.`prodi` AS `mahasiswa_prodi`, `m`.`kelas` AS `mahasiswa_kelas` FROM (((`mata_kuliah` `mk` left join `dosen` `d` on(`mk`.`dosen_id` = `d`.`id`)) left join `matkul_mahasiswa` `mm` on(`mk`.`id` = `mm`.`matkul_id`)) left join `mahasiswa` `m` on(`mm`.`mahasiswa_id` = `m`.`id`)) ORDER BY `mk`.`kode` ASC, `m`.`nama` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `v_rekap_absensi`
--
DROP TABLE IF EXISTS `v_rekap_absensi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rekap_absensi`  AS SELECT `m`.`id` AS `mahasiswa_id`, `m`.`nim` AS `nim`, `m`.`nama` AS `nama_mahasiswa`, `m`.`prodi` AS `prodi_mahasiswa`, `m`.`kelas` AS `kelas`, `mk`.`id` AS `matkul_id`, `mk`.`kode` AS `kode`, `mk`.`nama` AS `mata_kuliah`, count(`a`.`id`) AS `total_pertemuan`, sum(case when `a`.`status` = 'Hadir' then 1 else 0 end) AS `hadir`, sum(case when `a`.`status` = 'Sakit' then 1 else 0 end) AS `sakit`, sum(case when `a`.`status` = 'Izin' then 1 else 0 end) AS `izin`, sum(case when `a`.`status` = 'Alpa' then 1 else 0 end) AS `alpa`, round(sum(case when `a`.`status` = 'Hadir' then 1 else 0 end) / nullif(count(`a`.`id`),0) * 100,2) AS `persentase_kehadiran` FROM ((`mahasiswa` `m` join `absensi` `a` on(`m`.`id` = `a`.`mahasiswa_id`)) join `mata_kuliah` `mk` on(`a`.`matkul_id` = `mk`.`id`)) GROUP BY `m`.`id`, `m`.`nim`, `m`.`nama`, `mk`.`id`, `mk`.`kode`, `mk`.`nama` ;

-- --------------------------------------------------------

--
-- Structure for view `v_statistik_absensi`
--
DROP TABLE IF EXISTS `v_statistik_absensi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_statistik_absensi`  AS SELECT `absensi`.`tanggal` AS `tanggal`, count(0) AS `total_absensi`, sum(case when `absensi`.`status` = 'Hadir' then 1 else 0 end) AS `hadir`, sum(case when `absensi`.`status` = 'Sakit' then 1 else 0 end) AS `sakit`, sum(case when `absensi`.`status` = 'Izin' then 1 else 0 end) AS `izin`, sum(case when `absensi`.`status` = 'Alpa' then 1 else 0 end) AS `alpa` FROM `absensi` GROUP BY `absensi`.`tanggal` ORDER BY `absensi`.`tanggal` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `v_statistik_mahasiswa`
--
DROP TABLE IF EXISTS `v_statistik_mahasiswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_statistik_mahasiswa`  AS SELECT `m`.`id` AS `mahasiswa_id`, `m`.`nim` AS `nim`, `m`.`nama` AS `mahasiswa_nama`, `m`.`prodi` AS `prodi`, `m`.`kelas` AS `kelas`, count(`a`.`id`) AS `total_absensi`, sum(case when `a`.`status` = 'Hadir' then 1 else 0 end) AS `hadir`, sum(case when `a`.`status` = 'Sakit' then 1 else 0 end) AS `sakit`, sum(case when `a`.`status` = 'Izin' then 1 else 0 end) AS `izin`, sum(case when `a`.`status` = 'Alpa' then 1 else 0 end) AS `alpa`, round(sum(case when `a`.`status` = 'Hadir' then 1 else 0 end) / nullif(count(`a`.`id`),0) * 100,2) AS `persentase_kehadiran` FROM (`mahasiswa` `m` left join `absensi` `a` on(`m`.`id` = `a`.`mahasiswa_id`)) GROUP BY `m`.`id`, `m`.`nim`, `m`.`nama` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_absensi` (`mahasiswa_id`,`matkul_id`,`tanggal`),
  ADD KEY `idx_absensi_tanggal` (`tanggal`),
  ADD KEY `idx_absensi_status` (`status`),
  ADD KEY `idx_absensi_matkul` (`matkul_id`),
  ADD KEY `idx_absensi_mahasiswa` (`mahasiswa_id`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nidn` (`nidn`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_dosen_nidn` (`nidn`),
  ADD KEY `idx_dosen_prodi` (`prodi`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_mahasiswa_nim` (`nim`),
  ADD KEY `idx_mahasiswa_prodi` (`prodi`),
  ADD KEY `idx_mahasiswa_kelas` (`kelas`);

--
-- Indexes for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`),
  ADD KEY `idx_matkul_kode` (`kode`),
  ADD KEY `idx_matkul_dosen` (`dosen_id`);

--
-- Indexes for table `matkul_mahasiswa`
--
ALTER TABLE `matkul_mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_relasi` (`mahasiswa_id`,`matkul_id`),
  ADD KEY `idx_matkul_mahasiswa_matkul` (`matkul_id`),
  ADD KEY `idx_matkul_mahasiswa_mahasiswa` (`mahasiswa_id`);

--
-- Indexes for table `surat_izin`
--
ALTER TABLE `surat_izin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absensi_id` (`absensi_id`),
  ADD KEY `idx_surat_izin_status` (`status`),
  ADD KEY `idx_surat_izin_mahasiswa` (`mahasiswa_id`),
  ADD KEY `idx_surat_izin_matkul` (`matkul_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_email` (`email`),
  ADD KEY `idx_users_role` (`role`),
  ADD KEY `idx_users_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `matkul_mahasiswa`
--
ALTER TABLE `matkul_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_izin`
--
ALTER TABLE `surat_izin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_ibfk_2` FOREIGN KEY (`matkul_id`) REFERENCES `mata_kuliah` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD CONSTRAINT `mata_kuliah_ibfk_1` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `matkul_mahasiswa`
--
ALTER TABLE `matkul_mahasiswa`
  ADD CONSTRAINT `matkul_mahasiswa_ibfk_1` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matkul_mahasiswa_ibfk_2` FOREIGN KEY (`matkul_id`) REFERENCES `mata_kuliah` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `surat_izin`
--
ALTER TABLE `surat_izin`
  ADD CONSTRAINT `surat_izin_ibfk_1` FOREIGN KEY (`absensi_id`) REFERENCES `absensi` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;