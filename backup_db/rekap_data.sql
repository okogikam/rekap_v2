-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2025 at 01:13 PM
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
-- Database: `rekap_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_alumni`
--

CREATE TABLE `tabel_alumni` (
  `NO` int(1) NOT NULL,
  `NIM` varchar(2) DEFAULT NULL,
  `Nama` int(1) DEFAULT NULL,
  `Email` int(1) DEFAULT NULL,
  `Status_Pekerjaan` int(1) DEFAULT NULL,
  `Alamat_Instansi` int(1) DEFAULT NULL,
  `No_HP` int(1) DEFAULT NULL,
  `Tahun_Yudisium` int(1) DEFAULT NULL,
  `Tahun_Wisuda` int(1) DEFAULT NULL,
  `Tahun_Pertama_Bekerja` int(2) DEFAULT NULL,
  `Waktu_tunggu` int(2) DEFAULT NULL,
  `Instansi_Kerja_Pertama` int(2) DEFAULT NULL,
  `Gaji_Pertama` int(2) DEFAULT NULL,
  `Pekerjaan_Terakhir` int(2) DEFAULT NULL,
  `Nilai_Toefl` int(2) DEFAULT NULL,
  `Lama_Studi` int(2) DEFAULT NULL,
  `PIN_Ijazah` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_buku`
--

CREATE TABLE `tabel_buku` (
  `NO` int(1) NOT NULL,
  `ISBN` varchar(20) DEFAULT NULL,
  `JUDUL_BUKU` mediumtext DEFAULT NULL,
  `PENERBIT` mediumtext DEFAULT NULL,
  `PENGARANG` mediumtext DEFAULT NULL,
  `COPY` int(3) DEFAULT NULL,
  `TAHUN_TERBIT` varchar(20) DEFAULT NULL,
  `KODE_BUKU` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_dosen`
--

CREATE TABLE `tabel_dosen` (
  `NO` int(11) NOT NULL,
  `NIP` varchar(20) DEFAULT NULL,
  `NIDN` varchar(15) DEFAULT NULL,
  `GELAR_DEPAN` varchar(10) DEFAULT NULL,
  `NAMA` mediumtext DEFAULT NULL,
  `GELAR_ELAKANG` varchar(10) DEFAULT NULL,
  `JABATAN_AKADEMIK` varchar(30) DEFAULT NULL,
  `PENDIDIKAN_TERAKHIR` mediumtext DEFAULT NULL,
  `GOLONGAN` varchar(30) DEFAULT NULL,
  `STATUS` varchar(20) DEFAULT NULL,
  `HOMEBASE` mediumtext NOT NULL,
  `EMAIL` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_gsheet`
--

CREATE TABLE `tabel_gsheet` (
  `NO` int(11) NOT NULL,
  `NAMA_SHEET` varchar(50) NOT NULL,
  `ID_SHEET` varchar(100) NOT NULL,
  `KETERANGAN` varchar(500) NOT NULL,
  `KATEGORI` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_honor_skripsi`
--

CREATE TABLE `tabel_honor_skripsi` (
  `NO` int(1) NOT NULL,
  `NIM` varchar(20) DEFAULT NULL,
  `Nama` mediumtext DEFAULT NULL,
  `Pembimbing` varchar(10) DEFAULT NULL,
  `Penguji` varchar(10) DEFAULT NULL,
  `penguji_semhas` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_inventaris`
--

CREATE TABLE `tabel_inventaris` (
  `NO` int(1) NOT NULL,
  `Kode` varchar(30) DEFAULT NULL,
  `Nama_Barang` mediumtext DEFAULT NULL,
  `Tipe_Merk` mediumtext DEFAULT NULL,
  `Jumlah` int(3) DEFAULT NULL,
  `Tempat` mediumtext DEFAULT NULL,
  `Foto` mediumtext DEFAULT NULL,
  `Kondisi` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kehadiran`
--

CREATE TABLE `tabel_kehadiran` (
  `NO` int(11) NOT NULL,
  `PERIODE` int(5) DEFAULT NULL,
  `NIM` varchar(15) DEFAULT NULL,
  `NAMA_MAHASISWA` varchar(50) DEFAULT NULL,
  `KODE_MATA_KULIAH` varchar(10) DEFAULT NULL,
  `NAMA_MATA_KULIAH` varchar(50) DEFAULT NULL,
  `NAMA_KELAS` varchar(10) DEFAULT NULL,
  `DOSEN_PENGAMPU` longtext DEFAULT NULL,
  `JUMLAH_PERTEMUAN` int(2) DEFAULT NULL,
  `HADIR` int(2) DEFAULT NULL,
  `TANPA_KETERANGAN` int(2) DEFAULT NULL,
  `IZIN` int(2) DEFAULT NULL,
  `SAKIT` int(2) DEFAULT NULL,
  `LAST_UPDATE` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_kurikulum`
--

CREATE TABLE `tabel_kurikulum` (
  `NO` int(11) NOT NULL,
  `ID_KURIKULUM` varchar(20) DEFAULT NULL,
  `INDEX_FEEDER` varchar(20) DEFAULT NULL,
  `PROGRAM_STUDI` varchar(50) DEFAULT NULL,
  `TAHUN` varchar(10) DEFAULT NULL,
  `NAMA` varchar(50) DEFAULT NULL,
  `ANGKATAN` mediumtext DEFAULT NULL,
  `SKS_WAJIB_LULUS` int(3) NOT NULL,
  `SKS_PILIHAN_LULUS` int(3) NOT NULL,
  `SKS_DITAWARKAN` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mhs`
--

CREATE TABLE `tabel_mhs` (
  `NO` int(11) NOT NULL,
  `NIM` varchar(20) DEFAULT NULL,
  `NIK` varchar(20) DEFAULT NULL,
  `NAMA` varchar(100) DEFAULT NULL,
  `FAKULTAS` varchar(100) DEFAULT NULL,
  `PROGRAM_STUDI` varchar(50) DEFAULT NULL,
  `ANGKATAN` varchar(10) DEFAULT NULL,
  `JENIS_KELAMIN` varchar(10) DEFAULT NULL,
  `TEMPAT_LAHIR` varchar(50) DEFAULT NULL,
  `TANGGAL_LAHIR` varchar(10) DEFAULT NULL,
  `AGAMA` varchar(10) DEFAULT NULL,
  `STATUS_NIKAH` varchar(10) DEFAULT NULL,
  `NO_TELEPON` varchar(15) DEFAULT NULL,
  `NO_HP` varchar(15) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `JALUR_MASUK` varchar(10) DEFAULT NULL,
  `ALAMAT` longtext DEFAULT NULL,
  `KOTA` varchar(100) DEFAULT NULL,
  `PROPINSI` longtext DEFAULT NULL,
  `KODE_POS` varchar(10) DEFAULT NULL,
  `STATUS_TEMPAT_TINGGAL` longtext DEFAULT NULL,
  `PEMBIAYAAN_KULIAH` longtext DEFAULT NULL,
  `TINGGI_BADAN_CM` varchar(10) DEFAULT NULL,
  `BERAT_BADAN_KG` varchar(10) DEFAULT NULL,
  `GOL_DARAH` varchar(10) DEFAULT NULL,
  `ASAL_SEKOLAH` longtext DEFAULT NULL,
  `KOTA_SEKOLAH` longtext DEFAULT NULL,
  `TOTAL_NILAI_UN` varchar(10) DEFAULT NULL,
  `RATA_NILAI_UN` varchar(10) DEFAULT NULL,
  `MASUK_S1` varchar(10) DEFAULT NULL,
  `TAMAT_S1` varchar(10) DEFAULT NULL,
  `PERGURUAN_TINGGI_S1` longtext DEFAULT NULL,
  `FAKULTAS_S1` longtext DEFAULT NULL,
  `PRODI_S1` mediumtext DEFAULT NULL,
  `IPK_S1` varchar(10) DEFAULT NULL,
  `GELAR_S1` varchar(10) DEFAULT NULL,
  `NIK_AYAH` varchar(20) DEFAULT NULL,
  `NAMA_AYAH` mediumtext DEFAULT NULL,
  `NIK_IBU` varchar(20) DEFAULT NULL,
  `NAMA_IBU` mediumtext DEFAULT NULL,
  `STATUS_AYAH` varchar(10) DEFAULT NULL,
  `STATUS_IBU` varchar(10) DEFAULT NULL,
  `TELEPON_ORTU` varchar(15) DEFAULT NULL,
  `ALAMAT_ORTU` longtext DEFAULT NULL,
  `PEKERJAAN_AYAH` longtext DEFAULT NULL,
  `PEKERJAAN_IBU` longtext DEFAULT NULL,
  `PENGHASILAN_ORTU` varchar(10) DEFAULT NULL,
  `JUMLAH_TANGGUNGAN_ORTU` varchar(10) DEFAULT NULL,
  `NAMA_WALI` mediumtext DEFAULT NULL,
  `ALAMAT_WALI` longtext DEFAULT NULL,
  `TELEPON_WALI` varchar(10) DEFAULT NULL,
  `NOMOR_TES` varchar(20) DEFAULT NULL,
  `SEMESTER_MASUK` varchar(10) DEFAULT NULL,
  `JENIS_PENDAFTARAN` varchar(30) DEFAULT NULL,
  `STATUS_MAHASISWA` varchar(20) DEFAULT 'Aktif',
  `SEMESTER_KELUAR` varchar(6) NOT NULL,
  `BEASISWA` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_mk`
--

CREATE TABLE `tabel_mk` (
  `NO` int(11) NOT NULL,
  `KELOMPOK` varchar(10) DEFAULT NULL,
  `KODE` varchar(10) DEFAULT NULL,
  `NAMA_MATA_KULIAH` mediumtext DEFAULT NULL,
  `SKS` int(2) DEFAULT NULL,
  `PRASYARAT` mediumtext DEFAULT NULL,
  `SEMESTER` varchar(10) DEFAULT NULL,
  `NAMA_KURIKULUM` mediumtext DEFAULT NULL,
  `SIFAT_MATA_KULIAH` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_nilai_ipk`
--

CREATE TABLE `tabel_nilai_ipk` (
  `NO` int(11) NOT NULL,
  `PERIODE` int(5) DEFAULT NULL,
  `NIM` varchar(20) DEFAULT NULL,
  `NAMA` mediumtext NOT NULL,
  `ANGKATAN` varchar(4) NOT NULL,
  `STATUS_MAHASISWA` varchar(20) DEFAULT NULL,
  `IP_SEMESTER` varchar(10) DEFAULT NULL,
  `SKS_SEMESTER` varchar(10) DEFAULT NULL,
  `IPK` varchar(10) DEFAULT NULL,
  `SKS_TOTAL` varchar(10) DEFAULT NULL,
  `BOBOT` varchar(4) NOT NULL,
  `JUMLAH_SKS` varchar(4) NOT NULL,
  `SKS_LULUS` varchar(5) NOT NULL,
  `SKS_TIDAK_LULUS` varchar(5) NOT NULL,
  `SKS_MK_WAJIB_L` varchar(5) NOT NULL,
  `SKS_PILIHAN_L` varchar(5) NOT NULL,
  `Terakhir_Update` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_nilai_mk`
--

CREATE TABLE `tabel_nilai_mk` (
  `NO` int(11) NOT NULL,
  `NIM` varchar(20) DEFAULT NULL,
  `NILAI_ANGKA` varchar(10) DEFAULT NULL,
  `NILAI_HURUF` varchar(2) DEFAULT NULL,
  `NILAI_INDEKS` varchar(10) DEFAULT NULL,
  `NAMA_KURIKULUM` mediumtext DEFAULT NULL,
  `PERIODE` varchar(5) DEFAULT NULL,
  `NAMA_KELAS` mediumtext DEFAULT NULL,
  `KODE_MATA_KULIAH` varchar(10) DEFAULT NULL,
  `NAMA_MATA_KULIAH` mediumtext DEFAULT NULL,
  `SKS_MATA_KULIAH` varchar(2) DEFAULT NULL,
  `JENIS_MATA_KULIAH` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_pa`
--

CREATE TABLE `tabel_pa` (
  `NO` int(11) NOT NULL,
  `NIP_Dosen` varchar(20) DEFAULT NULL,
  `Nama_Dosen` mediumtext DEFAULT NULL,
  `NIM` varchar(20) DEFAULT NULL,
  `Nama_Mahasiswa` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `tabel_skripsi`
--

CREATE TABLE `tabel_skripsi` (
  `NO` int(11) NOT NULL,
  `NIM` varchar(20) DEFAULT NULL,
  `NAMA` mediumtext DEFAULT NULL,
  `JUDUL_SKRIPSI` longtext DEFAULT NULL,
  `PEMBIMBING_1` mediumtext DEFAULT NULL,
  `PEMBIMBING_2` mediumtext DEFAULT NULL,
  `PENGUJI_1` mediumtext DEFAULT NULL,
  `PENGUJI_2` mediumtext DEFAULT NULL,
  `SK_PEMBIMBING` varchar(18) NOT NULL,
  `SK_PENGUJI` varchar(18) NOT NULL,
  `TGL_SEMPRO` varchar(50) DEFAULT NULL,
  `TGL_SEMHAS` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_alumni`
--
ALTER TABLE `tabel_alumni`
  ADD PRIMARY KEY (`NO`);

--
-- Indexes for table `tabel_buku`
--
ALTER TABLE `tabel_buku`
  ADD PRIMARY KEY (`NO`);

--
-- Indexes for table `tabel_dosen`
--
ALTER TABLE `tabel_dosen`
  ADD PRIMARY KEY (`NO`);

--
-- Indexes for table `tabel_gsheet`
--
ALTER TABLE `tabel_gsheet`
  ADD PRIMARY KEY (`NO`);

--
-- Indexes for table `tabel_honor_skripsi`
--
ALTER TABLE `tabel_honor_skripsi`
  ADD PRIMARY KEY (`NO`);

--
-- Indexes for table `tabel_inventaris`
--
ALTER TABLE `tabel_inventaris`
  ADD PRIMARY KEY (`NO`);

--
-- Indexes for table `tabel_kehadiran`
--
ALTER TABLE `tabel_kehadiran`
  ADD PRIMARY KEY (`NO`);

--
-- Indexes for table `tabel_kurikulum`
--
ALTER TABLE `tabel_kurikulum`
  ADD PRIMARY KEY (`NO`);

--
-- Indexes for table `tabel_mhs`
--
ALTER TABLE `tabel_mhs`
  ADD PRIMARY KEY (`NO`);

--
-- Indexes for table `tabel_mk`
--
ALTER TABLE `tabel_mk`
  ADD PRIMARY KEY (`NO`);

--
-- Indexes for table `tabel_nilai_ipk`
--
ALTER TABLE `tabel_nilai_ipk`
  ADD PRIMARY KEY (`NO`);

--
-- Indexes for table `tabel_nilai_mk`
--
ALTER TABLE `tabel_nilai_mk`
  ADD PRIMARY KEY (`NO`);

--
-- Indexes for table `tabel_pa`
--
ALTER TABLE `tabel_pa`
  ADD PRIMARY KEY (`NO`);

--
-- Indexes for table `tabel_skripsi`
--
ALTER TABLE `tabel_skripsi`
  ADD PRIMARY KEY (`NO`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_alumni`
--
ALTER TABLE `tabel_alumni`
  MODIFY `NO` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_buku`
--
ALTER TABLE `tabel_buku`
  MODIFY `NO` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_dosen`
--
ALTER TABLE `tabel_dosen`
  MODIFY `NO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_gsheet`
--
ALTER TABLE `tabel_gsheet`
  MODIFY `NO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_honor_skripsi`
--
ALTER TABLE `tabel_honor_skripsi`
  MODIFY `NO` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_inventaris`
--
ALTER TABLE `tabel_inventaris`
  MODIFY `NO` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_kehadiran`
--
ALTER TABLE `tabel_kehadiran`
  MODIFY `NO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_kurikulum`
--
ALTER TABLE `tabel_kurikulum`
  MODIFY `NO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_mhs`
--
ALTER TABLE `tabel_mhs`
  MODIFY `NO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_mk`
--
ALTER TABLE `tabel_mk`
  MODIFY `NO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_nilai_ipk`
--
ALTER TABLE `tabel_nilai_ipk`
  MODIFY `NO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_nilai_mk`
--
ALTER TABLE `tabel_nilai_mk`
  MODIFY `NO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_pa`
--
ALTER TABLE `tabel_pa`
  MODIFY `NO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_skripsi`
--
ALTER TABLE `tabel_skripsi`
  MODIFY `NO` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
