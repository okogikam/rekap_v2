-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 19, 2026 at 02:34 AM
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
-- Database: `admin_akademik`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id` int(10) UNSIGNED NOT NULL,
  `nidn` varchar(20) NOT NULL,
  `gelar_depan` varchar(10) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `gelar_belakang` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `no_hp` varchar(30) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `pendidikan_terakhir` varchar(10) DEFAULT NULL,
  `golongan` varchar(50) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'aktif',
  `pangkat` varchar(30) DEFAULT NULL,
  `nuptk` varchar(20) DEFAULT NULL,
  `homebase` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id`, `nidn`, `gelar_depan`, `nama`, `gelar_belakang`, `email`, `nip`, `jabatan`, `no_hp`, `jenis_kelamin`, `pendidikan_terakhir`, `golongan`, `status`, `pangkat`, `nuptk`, `homebase`, `created_at`, `updated_at`) VALUES
(2, '0005076321', 'Drs', 'HARJA SANTANA PURBA', 'M.Kom Ph.D', 'harja.sp@ulm.ac.id', '196307051989031002', 'Lektor Kepala (550.00)', '081348710056', 'L', 'S3', NULL, 'aktif', 'III/d (Penata Tk. I)', '6037741642130153', 'Pendidikan Komputer', '2026-09-14 01:49:11', '2026-09-18 09:19:11'),
(3, '0028016602', 'Dr Dra', 'R ATI SUKMAWATI', 'M.Kom', 'atisukmawati@ulm.ac.id', '196601281993032002', 'Lektor Kepala (700.00)', '08195452570', 'P', 'S3', NULL, 'aktif', 'IV/c (Pembina Utama Muda)', '2460744645230062', 'Pendidikan Komputer', '2026-09-14 01:49:11', '2026-09-18 09:19:11'),
(6, '1130099001', NULL, 'IHDALHUBBI MAULIDA', 'S.Kom M.Kom', 'Ihdalhubbi@ulm.ac.id', '199009302024062001', 'Lektor (300.00)', '0856-5390-099', 'P', 'S2', NULL, 'aktif', 'III/b (Penata Muda Tk. I)', '7262768669230223', 'Pendidikan Komputer', '2026-09-14 01:49:11', '2026-09-18 09:19:11'),
(8, '0031038503', NULL, 'Andi Ichsan Mahardika, M.Pd', NULL, 'ichsan_pfis@ulm.ac.id', '19850331 201212 1 002', 'Lektor Kepala', '081355759011', 'L', NULL, NULL, 'aktif', '', '0663763664130212', NULL, '2026-09-14 01:49:11', '2026-09-18 09:00:19'),
(9, '0010119302', NULL, 'NOVAN ALKAF BAHRAINI SAPUTRA', 'S.Kom M.T.', 'novan.saputra@ulm.ac.id', '199311102020121008', 'Asisten Ahli (150.00)', NULL, 'L', 'S2', NULL, 'aktif', 'III/b (Penata Muda Tk. I)', '3442771672130383', 'Pendidikan Komputer', '2026-09-14 01:49:11', '2026-09-18 09:19:11'),
(10, '0001069402', NULL, 'RIZKY PAMUJI', 'S.Kom M.Kom', 'rizky.pamuji@ulm.ac.id', '199406012022031007', 'Asisten Ahli (150.00)', '0813-3349-0602', 'L', 'S2', NULL, 'aktif', 'III/b (Penata Muda Tk. I)', '7933772673130262', 'Pendidikan Komputer', '2026-09-14 01:49:11', '2026-09-18 09:19:11'),
(11, '0015039006', NULL, 'NURUDDIN WIRANDA', 'S.Kom M.Cs', 'nuruddin.wd@ulm.ac.id', '19900315201608101001', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'aktif', 'III/b (Penata Muda Tk. I)', '6647768669130342', 'Pendidikan Komputer', '2026-09-18 09:16:14', '2026-09-18 09:20:42'),
(12, '0005108806', NULL, 'MUHAMMAD HIFDZI ADINI', 'S.Kom M.T', 'III/b (Penata Muda Tk. I)', '198810052022031005', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'aktif', 'III/b (Penata Muda Tk. I)', '2337766667130343', 'Pendidikan Komputer', '2026-09-18 09:16:14', '2026-09-18 09:20:42'),
(13, '0029129203', NULL, 'DELSIKA PRAMATA SARI', 'S.Pd M.Pd', 'delsika.math@ulm.ac.id', '19921229201608201001', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'aktif', 'III/c (Penata)', '4561770671230323', 'Pendidikan Komputer', '2026-09-18 09:16:14', '2026-09-18 09:20:42'),
(14, '0010039203', NULL, 'CUCU WIDATY', 'S.Pd M.Pd', NULL, '199203102019032018', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Sosiologi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(15, '0029118003', NULL, 'LUMBAN AROFAH', 'S.Sos M.Sc. PhD', NULL, '198011292005011002', 'Asisten Ahli (150.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Sosiologi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(16, '0014088701', NULL, 'LAILA AZKIA', 'S.Sos M.Si', NULL, '198708142015042003', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Tugas Belajar', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Sosiologi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(17, '0026017005', NULL, 'SIGIT RUSWINARSIH', 'S.Sos M.Pd', NULL, '197001262005012001', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Sosiologi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(18, '0008089202', NULL, 'RESKI P', 'S.Pd M.Pd', NULL, '199208082018032001', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Tugas Belajar', 'III/c (Penata)', NULL, 'Pendidikan Sosiologi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(19, '0014059008', NULL, 'MUHAMMAD ADHITYA HIDAYAT PUTRA', 'S.Pd M.Pd', NULL, '199005142023211023', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Sosiologi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(20, '0025049506', NULL, 'SUMIATI', 'S.Pd M.Pd', NULL, '199504252024212001', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Sosiologi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(21, '0009038004', 'Dr', 'SYAHLAN MATTIRO', 'S.H. M.Si', NULL, '198003092009121002', 'Lektor (300.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Sosiologi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(22, '0016048401', 'Dr', 'YULI APRIATI', 'S.Sos M.A', NULL, '198404162008122006', 'Lektor (300.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Sosiologi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(23, '0013119102', NULL, 'RAHMAT NUR', 'S.Pd M.Pd', NULL, '199111132019031012', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/c (Penata)', NULL, 'Pendidikan Sosiologi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(24, '0022126504', 'Dr Drs', 'HIDAYAH ANSORI', 'M.Si Ph.D', NULL, '196512221992031002', 'Lektor Kepala (400.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'IV/b (Pembina Tk. I)', NULL, 'PR Pendidikan Profesi Guru', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(25, '0002108105', NULL, 'MOHAMMAD DANI WAHYUDI', 'S.Pd.I M.Pd', NULL, '198110022010121002', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'PR Pendidikan Profesi Guru', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(26, '0010016606', 'Dr Drs', 'KASPUL, DRS. MSI', 'M.Si', NULL, '196601101992031003', 'Lektor Kepala (550.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'IV/c (Pembina Utama Muda)', NULL, 'PR Pendidikan Profesi Guru', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(27, '0007056305', 'Drs', 'IRIANI BAKTI, DRS, MSI', 'M.Si', NULL, '196305071991031002', 'Lektor Kepala (400.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'IV/b (Pembina Tk. I)', NULL, 'PR Pendidikan Profesi Guru', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(28, '0011036612', 'Dr. Drs', 'KARIM', 'M.Si', NULL, '196603111992031005', 'Lektor Kepala (700.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'IV/c (Pembina Utama Muda)', NULL, 'PR Pendidikan Profesi Guru', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(29, '0002057505', NULL, 'MAHRUDIN', 'S.Pd M.Pd', NULL, '197505022005011005', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/c (Penata)', NULL, 'PR Pendidikan Profesi Guru', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(30, '0018068907', NULL, 'RAIHANAH SARI', 'S.Pd M.Pd', NULL, '198906182023212031', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan IPS', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(31, '0028119108', NULL, 'RUSMANIAH', 'S.Pd M.Pd', NULL, '199111282020122013', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan IPS', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(32, '0010108409', NULL, 'SIGIT TRIYONO', 'S.Pd M.Pd', NULL, '198410102024211001', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan IPS', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(33, '0020109502', NULL, 'JUMRIANI', 'S.Pd M.Pd', NULL, '199510202019032014', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/c (Penata)', NULL, 'Pendidikan IPS', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(34, '0013099203', NULL, 'MUHAMMAD REZKY NOOR HANDY', 'S.Pd M.Pd', NULL, '199209132019031016', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Tugas Belajar', 'III/c (Penata)', NULL, 'Pendidikan IPS', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(35, '0007098902', 'Dr', 'MUTIANI, S.Pd, M.Pd', 'S.Pd M.Pd', NULL, '198909072018032001', 'Lektor (200.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan IPS', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(36, '0008049406', NULL, 'M. RIDHA ILHAMI', 'S.Pd M.Pd', NULL, '199404082022031014', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan IPS', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(37, '0019048803', 'Dr', 'NEVY FARISTA ARISTIN', 'S.Pd M.Sc.', NULL, '198804192014042002', 'Lektor (300.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Geografi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(38, '0006109203', NULL, 'M. MUHAIMIN', 'S.Pd M.Sc.', NULL, '199210062024211001', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Geografi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(39, '0013028202', 'Dr.', 'KARUNIA PUJI HASTUTI', 'S.Pd M.Pd', NULL, '198202132003122001', 'Profesor (850.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'IV/b (Pembina Tk. I)', NULL, 'Pendidikan Geografi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(40, '0027098103', 'Dr', 'PARIDA ANGRIANI', 'S.Pd M.Pd', NULL, '198109272005012002', 'Lektor Kepala (400.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'IV/a (Pembina)', NULL, 'Pendidikan Geografi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(41, '0025049107', NULL, 'AKHMAD MUNAYA RAHMAN', 'S.Pd M.Pd', NULL, '199104252019031019', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Tugas Belajar', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Geografi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(42, '0029079007', NULL, 'FAISAL ARIF SETIAWAN', 'S.Pd M.Pd', NULL, '199007292018031001', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Tugas Belajar', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Geografi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(43, '0015039106', NULL, 'ASWIN NUR SAPUTRA', 'S.Pd M.Sc.', NULL, '199103152023211023', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Geografi', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(44, '0024027907', NULL, 'NOR JANNAH', 'S.Pd M.A', NULL, '197902242009122001', 'Asisten Ahli (100.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(45, '0716078005', 'Dr', 'MOH YAMIN', 'S.Pd M.Pd', NULL, '198007162010121003', 'Lektor Kepala (550.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'IV/b (Pembina Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(46, '0020089206', NULL, 'RAISA FADILLA', 'S.Pd M.Pd', NULL, '199208202018032001', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(47, '1107049102', NULL, 'ELSA ROSALINA', NULL, NULL, '199104072019032025', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(48, '0008056107', 'Dr Dra', 'CAYANDRAWATI SUTIONO', 'M.A.', NULL, '196105081986032003', 'Lektor Kepala (550.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'IV/c (Pembina Utama Muda)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(49, '0021067803', NULL, 'ASMI RUSMANAYANTI', 'S.Pd M.Sc.', NULL, '197806212001122002', 'Lektor Kepala (400.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'IV/a (Pembina)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(50, '0013087302', NULL, 'SIRAJUDDIN KAMAL', 'S.S.', NULL, '197308131999031001', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(51, '0020028201', NULL, 'EMMA ROSANA FEBRIYANTI', 'S.Pd M.Pd', NULL, '198202202005012002', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(52, '0018099504', NULL, 'INAYATI FITRIYAH ASRIMAWATI', 'S.Pd M.Pd', NULL, '199509182022032025', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(53, '0006087602', 'Dr.', 'JUMARIATI', 'S.Pd M.Pd', NULL, '197608062001122002', 'Lektor (200.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(54, '1127128801', NULL, 'DINI NOOR ARINI', 'S.Pd M.Pd', NULL, '198812272014042001', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(55, '0030019105', NULL, 'EKA PUTERI ELYANI', 'S.Pd M.Pd', NULL, '199101302019032014', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(56, '2124119102', NULL, 'NUR IFADLOH', 'S.Pd.I M.Pd', NULL, '199111242025061002', 'Tidak Ada', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(57, '0025128706', NULL, 'Yusuf Al Arief', 'S.Pd M.Hum', NULL, '198712252025211049', 'Tidak Ada', NULL, NULL, 'Tidak Dike', NULL, 'Aktif', 'Tidak Diketahui', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(58, '0019117401', NULL, 'NOVITA TRIANA', 'S.Pd M.A', NULL, '197411192000122001', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(59, '0013027905', NULL, 'ELVINA ARAPAH', 'S.Pd M.Pd', NULL, '197902132005012002', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Tugas Belajar', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(60, '1106038703', NULL, 'NASRULLAH', 'S.Pd', NULL, '198703062015041003', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Tugas Belajar', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(61, '0026088704', NULL, 'FAHMI HIDAYAT, S.PD', 'S.Pd M.Pd', NULL, '198708262023211017', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Bahasa Inggris', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(62, '1106029501', NULL, 'DEWICCA FATMA NADILLA', NULL, NULL, '199502062022032019', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Sejarah', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(63, '0002098201', 'Dr', 'HERI SUSANTO', 'S.Pd M.Pd', NULL, '198209022008121001', 'Lektor (300.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Sejarah', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(64, '0016018902', NULL, 'MELISA PRAWITASARI', 'S.Pd M.Pd', NULL, '198901162015042002', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Sejarah', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(65, '0026058107', NULL, 'DAUD YAHYA', 'S.Pd M.Pd', NULL, '198105262008031001', 'Tidak Ada', NULL, NULL, 'S2', NULL, 'Aktif', 'III/c (Penata)', NULL, 'Pendidikan Sejarah', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(66, '0018107708', 'Dr', 'WISNU SUBROTO', 'S.S. M.A', NULL, '197710182005011001', 'Lektor Kepala (400.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'IV/a (Pembina)', NULL, 'Pendidikan Sejarah', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(67, '0031076602', 'Drs.', 'RUSDI EFFENDI', 'M.Pd', NULL, '196607311991031002', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'IV/a (Pembina)', NULL, 'Pendidikan Sejarah', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(68, '0028049203', NULL, 'FITRI MARDIANI', 'S.Pd M.Pd', NULL, '199204282019032029', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Sejarah', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(69, '0009048203', NULL, 'MANSYUR', 'S.Pd M.Hum', NULL, '198204092008121001', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Sejarah', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(70, '0011049002', NULL, 'SRIWATI', 'S.Pd M.Pd', NULL, '199004112019032017', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Sejarah', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(71, '0003048806', NULL, 'RIZKI NUR ANALITA', 'S.Pd M.Pd', NULL, '198804032019032014', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/c (Penata)', NULL, 'Pendidikan Kimia', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(72, '0010106002', 'Dra', 'LENY', 'M.Si', NULL, '196010101985032008', 'Lektor Kepala (550.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'IV/c (Pembina Utama Muda)', NULL, 'Pendidikan Kimia', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(73, '0017099009', NULL, 'YOGO DWI PRASETYO', 'S.Pd M.Pd M.Sc', NULL, '199009172022031004', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan Kimia', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(74, '0004106209', 'Drs', 'PARHAM SAADI', 'M.Si', NULL, '196210041989031002', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan Kimia', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(75, '0028086801', 'Dr Drs', 'DR H RUSMANSYAH MPD', 'M.Pd', NULL, '196808281993031001', 'Lektor Kepala (700.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'IV/c (Pembina Utama Muda)', NULL, 'Pendidikan Kimia', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(76, '0029065907', 'Drs', 'MAHDIAN, M.Si, Drs', 'M.Si', NULL, '196404281991031002', 'Lektor Kepala (550.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'IV/c (Pembina Utama Muda)', NULL, 'Pendidikan Kimia', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(77, '0015016604', 'Dra', 'RILIA IRIANI', 'M.Si', NULL, '196601151991112001', 'Lektor Kepala (550.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'IV/c (Pembina Utama Muda)', NULL, 'Pendidikan Kimia', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(78, '0025106402', 'Drs', 'MUHAMMAD KUSASI', 'M.Pd', NULL, '196410251991031003', 'Lektor Kepala (400.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'IV/b (Pembina Tk. I)', NULL, 'Pendidikan Kimia', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(79, '0007069001', NULL, 'ALMUBARAK', 'S.Pd M.Pd', NULL, '199006072015041003', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Tugas Belajar', 'III/c (Penata)', NULL, 'Pendidikan Kimia', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(80, '0019029205', NULL, 'RIZKY FEBRIYANI PUTRI', 'S.Pd M.Pd', NULL, '199202192023212049', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan IPA', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(81, '1124069201', NULL, 'YASMINE KHAIRUNNISA', 'S.Pd M.A', NULL, '199206242022032014', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan IPA', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(82, '0008059007', NULL, 'Mella Mutika Sari', 'S.Pd M.Pd', NULL, '199005082025212052', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'Tidak Diketahui', NULL, 'Pendidikan IPA', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(83, '0025086703', 'Drs', 'MAYA ISTYADJI', 'M.Pd', NULL, '196708251992121001', 'Lektor Kepala (400.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'IV/a (Pembina)', NULL, 'Pendidikan IPA', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(84, '0006049305', NULL, 'SAUQINA', 'S.Pd M.A.', NULL, '199304062019032014', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan IPA', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(85, '0029078909', NULL, 'WIDA SALUPI', 'S.Si. S.Si M.Si', NULL, '198907292023212034', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan IPA', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(86, '0007117906', NULL, 'SYUBHAN AN`NUR', 'M.Pd', NULL, '197911072005011004', 'Lektor (200.00)', NULL, NULL, 'S3', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan IPA', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(87, '0016066901', NULL, 'YUDHA IRHASYUARNA', 'S.Pd M.Pd', NULL, '196906161994031002', 'Lektor Kepala (700.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'IV/b (Pembina Tk. I)', NULL, 'Pendidikan IPA', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(88, '0007098507', NULL, 'RATNA YULINDA', 'S.Pd M.Pd', NULL, '198509072012122001', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Pendidikan IPA', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(89, '0006089105', NULL, 'IKHWAN KHAIRU SADIQIN', 'S.Pd M.Pd', NULL, '199108062023211020', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan IPA', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(90, '0026039009', NULL, 'ELLYNA HAFIZAH', 'S.Pd M.Pd', NULL, '199003262024212045', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan IPA', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(91, '0705119402', NULL, 'MELIYANA AINI', 'S.Pd M.Pd', NULL, '199411052023212044', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan IPA', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(92, '0012058604', NULL, 'MUHAMMAD FUAD SYA`BAN', 'S.Pd M.Pd', NULL, '198605122023211014', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Pendidikan IPA', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(93, '0006089202', NULL, 'EKLYS CHESEDA MAKARIA', 'S.Pd M.Pd', NULL, '199208062018032001', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/d (Penata Tk. I)', NULL, 'Bimbingan dan Konseling', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(94, '0008088606', NULL, 'M. ANDRI SETIAWAN', 'S.Pd M.Pd', NULL, '198608082023211027', 'Lektor (300.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Bimbingan dan Konseling', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(95, '0013128701', NULL, 'MUHAMMAD ARSYAD', 'S.Psi M.Psi Psikolog', NULL, '198712132023211013', 'Asisten Ahli (150.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Bimbingan dan Konseling', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(96, '0018058505', NULL, 'HENDRO YULIUS SURYO PUTRO', 'S.Pd M.Psi', NULL, '198505182020121006', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Tugas Belajar', 'III/c (Penata)', NULL, 'Bimbingan dan Konseling', '2026-09-18 09:41:23', '2026-09-18 09:41:23'),
(97, '0020069302', NULL, 'NOOR AINAH', 'S.Th.I M.Pd', NULL, '19930620201801213001', 'Lektor (200.00)', NULL, NULL, 'S2', NULL, 'Aktif', 'III/b (Penata Muda Tk. I)', NULL, 'Bimbingan dan Konseling', '2026-09-18 09:41:23', '2026-09-18 09:41:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nidn` (`nidn`),
  ADD KEY `idx_dosen_nama` (`nama`),
  ADD KEY `idx_dosen_status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
