-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2026 at 05:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bedroom`
--

CREATE TABLE `bedroom` (
  `no_kamar` varchar(10) NOT NULL,
  `id_kamar` int(11) NOT NULL,
  `lantai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bedroom`
--

INSERT INTO `bedroom` (`no_kamar`, `id_kamar`, `lantai`) VALUES
('A01', 1, 1),
('A02', 1, 1),
('B01', 2, 2),
('C01', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `menyewa`
--

CREATE TABLE `menyewa` (
  `id_sewa` int(11) NOT NULL,
  `id_cust` int(11) NOT NULL,
  `no_kamar` varchar(10) NOT NULL,
  `tgl_check_in` date NOT NULL,
  `tgl_check_out` date NOT NULL,
  `lama_menginap` int(11) NOT NULL,
  `total_harga` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menyewa`
--

INSERT INTO `menyewa` (`id_sewa`, `id_cust`, `no_kamar`, `tgl_check_in`, `tgl_check_out`, `lama_menginap`, `total_harga`) VALUES
(1, 1, 'A01', '2026-01-06', '2026-01-08', 2, 600000.00);

-- --------------------------------------------------------

--
-- Table structure for table `penyewa`
--

CREATE TABLE `penyewa` (
  `id_cust` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `no_identitas` varchar(50) NOT NULL,
  `jenis_identitas` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penyewa`
--

INSERT INTO `penyewa` (`id_cust`, `nama`, `alamat`, `no_telp`, `no_identitas`, `jenis_identitas`) VALUES
(1, 'Andriansyah', 'JALAN JALAN', '087656451671', '3322445566772', 'KTP');

-- --------------------------------------------------------

--
-- Table structure for table `tipe_kamar`
--

CREATE TABLE `tipe_kamar` (
  `id_kamar` int(11) NOT NULL,
  `tipe` varchar(50) NOT NULL,
  `harga_per_mlm` decimal(12,2) NOT NULL,
  `max_orang` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipe_kamar`
--

INSERT INTO `tipe_kamar` (`id_kamar`, `tipe`, `harga_per_mlm`, `max_orang`, `foto`) VALUES
(1, 'Standard', 300000.00, 2, 'foto_696076be09fb8.jpg'),
(2, 'Deluxe', 500000.00, 2, 'foto_696076e26feaa.jpg'),
(3, 'President', 1000000.00, 4, 'foto_69607a965630b.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `created_at`, `foto`) VALUES
(1, 'nabil', '$2y$10$oZAq8ArKHaMHsVtYs7iI/expBkJv9hhfxF4Ad0VsNGH8Bo2KqUUMC', 'Nabil Labqino', '2026-01-06 14:24:15', NULL),
(2, 'andre', '$2y$10$z9AgG0Z.83eju735kwiH5eLL4UprReS0EgOYzCTvNuhtMiIwAFtEW', 'andre', '2026-01-09 03:27:44', 'foto_696075b0ccfb2.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bedroom`
--
ALTER TABLE `bedroom`
  ADD PRIMARY KEY (`no_kamar`),
  ADD KEY `id_kamar` (`id_kamar`);

--
-- Indexes for table `menyewa`
--
ALTER TABLE `menyewa`
  ADD PRIMARY KEY (`id_sewa`),
  ADD KEY `id_cust` (`id_cust`),
  ADD KEY `no_kamar` (`no_kamar`);

--
-- Indexes for table `penyewa`
--
ALTER TABLE `penyewa`
  ADD PRIMARY KEY (`id_cust`);

--
-- Indexes for table `tipe_kamar`
--
ALTER TABLE `tipe_kamar`
  ADD PRIMARY KEY (`id_kamar`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menyewa`
--
ALTER TABLE `menyewa`
  MODIFY `id_sewa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penyewa`
--
ALTER TABLE `penyewa`
  MODIFY `id_cust` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tipe_kamar`
--
ALTER TABLE `tipe_kamar`
  MODIFY `id_kamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bedroom`
--
ALTER TABLE `bedroom`
  ADD CONSTRAINT `bedroom_ibfk_1` FOREIGN KEY (`id_kamar`) REFERENCES `tipe_kamar` (`id_kamar`) ON DELETE CASCADE;

--
-- Constraints for table `menyewa`
--
ALTER TABLE `menyewa`
  ADD CONSTRAINT `menyewa_ibfk_1` FOREIGN KEY (`id_cust`) REFERENCES `penyewa` (`id_cust`) ON DELETE CASCADE,
  ADD CONSTRAINT `menyewa_ibfk_2` FOREIGN KEY (`no_kamar`) REFERENCES `bedroom` (`no_kamar`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
