-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 26, 2025 at 03:48 PM
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
-- Database: `rekap_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_prodi`
--

CREATE TABLE `tabel_prodi` (
  `KODE_PRODI` varchar(10) NOT NULL,
  `KODE_UNIV` varchar(10) NOT NULL,
  `PRODI` varchar(30) NOT NULL,
  `FAKULTAS` varchar(30) NOT NULL,
  `JENJANG` varchar(10) NOT NULL,
  `STATUS` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tabel_prodi`
--

INSERT INTO `tabel_prodi` (`KODE_PRODI`, `KODE_UNIV`, `PRODI`, `FAKULTAS`, `JENJANG`, `STATUS`) VALUES
('83207', 'A1C6', 'Pendidikan Komputer', 'F-KIP', 'S1', 'Aktif');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
