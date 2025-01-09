-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2025 at 08:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `email`, `nama_lengkap`, `no_telepon`, `alamat`, `profile_image`, `otp_code`, `otp_expiry`) VALUES
(5, 'raflimuhamad123', '$2y$10$bimuRbAQE9K7YkJBwliDg.Pdw/wlCkJB0gglVP5.naYzsNjHBwXI2', 'rafligaming13@gmail.com', 'Muhamad Rafli', '081908539573', 'Jl. Anjay Gurinjay No.13', 'bootstrap/assets/img/profiles/35acc19394b0bf1a97d55e5c13869392.png', '377244', '2025-01-07 16:54:55'),
(8, 'mrasyadalazka', '$2y$10$Dwlg8GfZBrlr7Di07hOfRe5CjyOwe6PHuRKlA36hj7HWmXMUhwUZW', 'mrasyadalazka@gmail.com', 'Muhamad Al azka', '081908531234', 'Jl. Jurgen 02 Bougenville No.22', 'bootstrap/assets/img/profiles/f65c0383e1051e588d966236c4f96704.png', '216068', '2025-01-08 20:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` int(11) NOT NULL,
  `nama_dosen` varchar(100) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `nama_dosen`, `nip`, `email`, `telepon`, `alamat`, `jurusan`) VALUES
(1, 'Dr. Rina Suryani', '196705021992032001', 'rina@example.com', '081234567891', 'Jl. Diponegoro No. 7', 'Teknik Informatika'),
(2, 'Prof. Bambang Triyono', '195603091987032002', 'bambang@example.com', '081987654322', 'Jl. Gajah Mada No. 8', 'Sistem Informasi'),
(3, 'Dr. Agus Salim', '197806152003121001', 'agus@example.com', '0821122334466', 'Jl. Pahlawan No. 12', 'Manajemen'),
(4, 'Dr. Anisa Putri', '197405041995032003', 'anisa@example.com', '0812233445566', 'Jl. Kartini No. 2', 'Teknik Informatika'),
(5, 'Prof. Zulkifli Ahmad', '196808151988032004', 'zulkifli@example.com', '0813344556677', 'Jl. Merdeka Barat No. 6', 'Sistem Informasi'),
(6, 'Dr. Irwan Syah', '197912091990032005', 'irwan@example.com', '0814455667788', 'Jl. Sudirman No. 13', 'Manajemen'),
(7, 'Dr. Ratna Dewi', '196512121990032006', 'ratna@example.com', '0815566778899', 'Jl. Diponegoro No. 10', 'Teknik Informatika'),
(8, 'Dr. Sigit Pramono', '197311071993032007', 'sigit@example.com', '0816677889900', 'Jl. Kartini No. 8', 'Sistem Informasi'),
(9, 'Prof. Widya Lestari', '195908101986032008', 'widya@example.com', '0817788990011', 'Jl. Pahlawan No. 1', 'Manajemen'),
(10, 'Dr. Yudi Setiawan', '198305161996032009', 'yudi@example.com', '0818899001122', 'Jl. Gajah Mada No. 3', 'Teknik Informatika'),
(11, 'Dr. Tumar D. George', '19670502199154325', 'tumar@example.com', '084472916481', 'Jl. Simpang Ketapel No.4', 'Teknik Informatika'),
(12, 'Dr. Londo Smith', '19670502199256321', 'londo@example.com', '082682946291', 'Jl. Menteng Agung No.9', 'Teknik Informatika'),
(13, 'Dr. Bianca Lindsay', '196705021992021456', 'bianca@example.com', '0823654654654', 'Jl. Cilandak West No.4', 'Sistem Informasi'),
(14, 'Dr. Safira Lichorfort', '197311071993030943', 'safira@example.com', '08435345345', 'Jl. Diem Boullevard No.2', 'Manajemen'),
(15, 'Prof. Zulkifli Ahmad', '196808151988032015', 'zulkifli.ahmad@example.com', '0813344556678', 'Jl. Merdeka Barat No. 15', 'Sistem Informasi'),
(16, 'Dr. Irwan Syah', '197912091990032016', 'irwan.syah@example.com', '0814455667789', 'Jl. Sudirman No. 16', 'Manajemen'),
(17, 'Dr. Ratna Dewi', '196512121990032017', 'ratna.dewi@example.com', '0815566778900', 'Jl. Diponegoro No. 17', 'Teknik Informatika'),
(18, 'Dr. Sigit Pramono', '197311071993032018', 'sigit.pramono@example.com', '0816677889011', 'Jl. Kartini No. 18', 'Sistem Informasi'),
(19, 'Prof. Widya Lestari', '195908101986032019', 'widya.lestari@example.com', '0817788990122', 'Jl. Pahlawan No. 19', 'Manajemen'),
(20, 'Dr. Yudi Setiawan', '198305161996032020', 'yudi.setiawan@example.com', '0818899001233', 'Jl. Gajah Mada No. 20', 'Teknik Informatika'),
(21, 'Dr. Tumar D. George', '196705021991543226', 'tumar.george@example.com', '084472916482', 'Jl. Simpang Ketapel No. 5', 'Teknik Informatika'),
(22, 'Dr. Londo Smith', '196705021992563227', 'londo.smith@example.com', '082682946292', 'Jl. Menteng Agung No. 10', 'Teknik Informatika'),
(23, 'Dr. Bianca Lindsay', '196705021992021457', 'bianca.lindsay@example.com', '0823654654655', 'Jl. Cilandak West No. 5', 'Sistem Informasi'),
(24, 'Dr. Safira Lichorfort', '197311071993030944', 'safira.lichorfort@example.com', '08435345346', 'Jl. Diem Boulevard No. 3', 'Manajemen'),
(25, 'Dr. Rudi Hartono', '198001011990032021', 'rudi.hartono@example.com', '081234567893', 'Jl. Merdeka No. 21', 'Teknik Informatika'),
(26, 'Dr. Siti Fatimah', '198505051992032022', 'siti.fatimah@example.com', '081987654324', 'Jl. Diponegoro No. 22', 'Sistem Informasi'),
(27, 'Prof. Joko Widodo', '197001011993032023', 'joko.widodo@example.com', '0821122334488', 'Jl. Pahlawan No. 23', 'Manajemen'),
(28, 'Dr. Rina Amelia', '198205021994032024', 'rina.amelia@example.com', '0812233445588', 'Jl. Kartini No. 24', 'Teknik Informatika'),
(29, 'Prof. Ahmad Zaki', '197512121995032025', 'ahmad.zaki@example.com', '0813344556688', 'Jl. Merdeka Barat No. 25', 'Sistem Informasi'),
(30, 'Dr. Laila Rahma', '198305161996032026', 'laila.rahma@example.com', '0814455667799', 'Jl. Gajah Mada No. 26', 'Manajemen');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `nama_mahasiswa` varchar(100) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nama_mahasiswa`, `nim`, `tanggal_lahir`, `jurusan`, `email`, `telepon`, `alamat`) VALUES
(1, 'Budi Santoso', '123456789', '2000-01-01', 'Teknik Informatika', 'budi@example.com', '082390179217', 'Jl. Merdeka No. 1'),
(2, 'Siti Aminah', '987654321', '1999-05-15', 'Sistem Informasi', 'siti@example.com', '081987654321', 'Jl. Kartini No. 5'),
(3, 'Ahmad Yusuf', '1122334455', '2001-08-23', 'Manajemen', 'ahmad@example.com', '0821122334455', 'Jl. Sudirman No. 10'),
(4, 'Dewi Lestari', '5566778899', '1998-03-12', 'Teknik Informatika', 'dewi@example.com', '083344556677', 'Jl. Diponegoro No. 3'),
(5, 'Hendra Gunawan', '4455667788', '2000-07-30', 'Sistem Informasi', 'hendra@example.com', '084455667788', 'Jl. Pahlawan No. 6'),
(7, 'Lukman Hakim', '7788990011', '1999-04-10', 'Teknik Informatika', 'lukman@example.com', '0867788990011', 'Jl. Merdeka Barat No. 4'),
(8, 'Sri Wahyuni', '8899001122', '2001-09-05', 'Sistem Informasi', 'sri@example.com', '0878899001122', 'Jl. Sudirman No. 15'),
(9, 'Andi Pratama', '9900112233', '2000-06-17', 'Manajemen', 'andi@example.com', '0889900112233', 'Jl. Kartini No. 12'),
(10, 'Fitriani Sari', '0011223344', '1998-02-14', 'Teknik Informatika', 'fitriani@example.com', '0890011223344', 'Jl. Diponegoro No. 11'),
(11, 'Rizky Ramadhan', '124123456', '2000-02-10', 'Teknik Informatika', 'rizky@example.com', '081234567124', 'Jl. Kemerdekaan No. 124'),
(12, 'Maya Sari', '125987654', '1999-11-18', 'Sistem Informasi', 'maya@example.com', '081987654125', 'Jl. Kartini No. 125'),
(13, 'Fahmi Arifin', '126112233', '2001-03-25', 'Manajemen', 'fahmi@example.com', '082112233126', 'Jl. Sudirman No. 126'),
(37, 'Intan Permatasari', '127556677', '1998-09-05', 'Teknik Informatika', 'intan@example.com', '083344556127', 'Jl. Diponegoro No. 127'),
(38, 'Agus Setiawan', '128445566', '2000-07-11', 'Sistem Informasi', 'agus@example.com', '084455667128', 'Jl. Pahlawan No. 128'),
(39, 'Lina Mariska', '129667788', '1997-06-21', 'Manajemen', 'lina@example.com', '085667788129', 'Jl. Gajah Mada No. 129'),
(40, 'Heri Kurniawan', '130778899', '1999-01-14', 'Teknik Informatika', 'heri@example.com', '086778899130', 'Jl. Merdeka Barat No. 130'),
(41, 'Dina Wahyuni', '131889900', '2001-05-19', 'Sistem Informasi', 'dina@example.com', '087889900131', 'Jl. Sudirman No. 131'),
(42, 'Satria Wijaya', '132990011', '2000-03-08', 'Manajemen', 'satria@example.com', '088990011132', 'Jl. Kartini No. 132'),
(43, 'Rina Febriani', '133001122', '1998-12-15', 'Teknik Informatika', 'rinafebriani@example.com', '089001122133', 'Jl. Diponegoro No. 133'),
(44, 'Yudi Pratama', '134114477', '2000-09-03', 'Teknik Informatika', 'yudi@example.com', '081234567134', 'Jl. Merdeka No. 134'),
(45, 'Siska Amalia', '135255368', '1999-04-22', 'Sistem Informasi', 'siska@example.com', '081987654135', 'Jl. Kartini No. 135'),
(46, 'Bagus Prasetyo', '136312445', '2001-07-13', 'Manajemen', 'bagus@example.com', '082112233136', 'Jl. Sudirman No. 136'),
(47, 'Nurul Hidayah', '137556378', '1998-10-20', 'Teknik Informatika', 'nurul@example.com', '083344556137', 'Jl. Diponegoro No. 137'),
(48, 'Aditya Nugraha', '138445466', '2000-08-09', 'Sistem Informasi', 'aditya@example.com', '084455667138', 'Jl. Pahlawan No. 138'),
(49, 'Mila Rahmawati', '139667778', '1997-05-25', 'Manajemen', 'mila@example.com', '085667788139', 'Jl. Gajah Mada No. 139'),
(50, 'Eko Wahyudi', '140778899', '1999-06-12', 'Teknik Informatika', 'eko@example.com', '086778899140', 'Jl. Merdeka Barat No. 140'),
(51, 'Siti Rahmah', '141889900', '2001-01-27', 'Sistem Informasi', 'sitirahmah@example.com', '087889900141', 'Jl. Sudirman No. 141'),
(52, 'Anton Surya', '142990011', '2000-04-15', 'Manajemen', 'anton@example.com', '088990011142', 'Jl. Kartini No. 142'),
(53, 'Yulia Kartika', '143001122', '1998-11-30', 'Teknik Informatika', 'yulia@example.com', '089001122143', 'Jl. Diponegoro No. 143'),
(54, 'Dani Haryanto', '144114477', '2000-02-02', 'Teknik Informatika', 'dani@example.com', '081234567144', 'Jl. Merdeka No. 144'),
(55, 'Anisa Putri', '145255368', '1999-09-19', 'Sistem Informasi', 'anisa@example.com', '081987654145', 'Jl. Kartini No. 145'),
(56, 'Fadli Pramudya', '146312445', '2001-10-10', 'Manajemen', 'fadli@example.com', '082112233146', 'Jl. Sudirman No. 146'),
(57, 'Reni Kusuma', '147556378', '1998-05-07', 'Teknik Informatika', 'reni@example.com', '083344556147', 'Jl. Diponegoro No. 147'),
(58, 'Dimas Saputra', '148445466', '2000-12-01', 'Sistem Informasi', 'dimas@example.com', '084455667148', 'Jl. Pahlawan No. 148'),
(59, 'Lina Kurniasari', '149667778', '1997-02-23', 'Manajemen', 'linak@example.com', '085667788149', 'Jl. Gajah Mada No. 149'),
(60, 'Fikri Maulana', '150778899', '1999-03-11', 'Teknik Informatika', 'fikri@example.com', '086778899150', 'Jl. Merdeka Barat No. 150'),
(61, 'Rahma Dewi', '151889900', '2001-08-30', 'Sistem Informasi', 'rahmadewi@example.com', '087889900151', 'Jl. Sudirman No. 151'),
(62, 'Bayu Santoso', '152990011', '2000-07-05', 'Manajemen', 'bayu@example.com', '088990011152', 'Jl. Kartini No. 152'),
(63, 'Lutfia Handayani', '153001122', '1998-10-22', 'Teknik Informatika', 'lutfia@example.com', '089001122153', 'Jl. Diponegoro No. 153'),
(64, 'Rina Kartini', '6677889900', '2003-07-10', 'Manajemen', 'rina@example.com', '082390179217', 'Jl. Rina Sari No.13'),
(69, 'Fajar Pramono', '6677889906', '2003-12-15', 'Sistem Informasi', 'fajar.pramono@example.com', '082390179223', 'Jl. Merdeka Barat No.19'),
(70, 'Lina Sari', '6677889907', '2003-01-16', 'Manajemen', 'lina.sari@example.com', '082390179224', 'Jl. Sudirman No.20'),
(71, 'Rizky Hidayat', '6677889908', '2003-02-17', 'Teknik Informatika', 'rizky.hidayat@example.com', '082390179225', 'Jl. Kartini No.21'),
(72, 'Maya Lestari', '6677889909', '2003-03-18', 'Sistem Informasi', 'maya.lestari@example.com', '082390179226', 'Jl. Diponegoro No.22'),
(74, 'Siti Kosidah', '6677889911', '2003-05-20', 'Teknik Informatika', 'siti.kosidah@example.com', '082390179228', 'Jl. Merdeka No.24'),
(75, 'Agus Salim', '6677889912', '2003-06-21', 'Sistem Informasi', 'agus.salim@example.com', '082390179229', 'Jl. Gajah Mada No.25'),
(76, 'Dina Amalia', '6677889913', '2003-07-22', 'Manajemen', 'dina.amalia@example.com', '082390179230', 'Jl. Sudirman No.26'),
(77, 'Fikri Maulana', '6677889914', '2003-08-23', 'Teknik Informatika', 'fikri.maulana@example.com', '082390179231', 'Jl. Kartini No.27'),
(78, 'Reni Kusuma', '6677889915', '2003-09-24', 'Sistem Informasi', 'reni.kusuma@example.com', '082390179232', 'Jl. Diponegoro No.28'),
(79, 'Bayu Santoso', '6677889916', '2003-10-25', 'Manajemen', 'bayu.santoso@example.com', '082390179233', 'Jl. Pahlawan No.29'),
(80, 'Yulia Kartika', '6677889917', '2003-11-26', 'Teknik Informatika', 'yulia.kartika@example.com', '082390179234', 'Jl. Merdeka Barat No.30'),
(81, 'Anton Surya', '6677889918', '2003-12-27', 'Sistem Informasi', 'anton.surya@example.com', '082390179235', 'Jl. Gajah Mada No.31'),
(82, 'Dani Haryanto', '6677889919', '2004-01-28', 'Manajemen', 'dani.haryanto@example.com', '082390179236', 'Jl. Sudirman No.32'),
(83, 'Anisa Putri', '6677889920', '2004-02-29', 'Teknik Informatika', 'anisa.putri@example.com', '082390179237', 'Jl. Kartini No.33'),
(84, 'Fadli Pramudya', '6677889921', '2004-03-01', 'Sistem Informasi', 'fadli.pramudya@example.com', '082390179238', 'Jl. Diponegoro No.34'),
(85, 'Rina Febriani', '6677889922', '2004-04-02', 'Manajemen', 'rina.febriani@example.com', '082390179239', 'Jl. Pahlawan No.35'),
(86, 'Siska Amalia', '6677889923', '2004-05-03', 'Teknik Informatika', 'siska.amalia@example.com', '082390179240', 'Jl. Merdeka No.36'),
(87, 'Bagus Prasetyo', '6677889924', '2004-06-04', 'Sistem Informasi', 'bagus.prasetyo@example.com', '082390179241', 'Jl. Gajah Mada No.37'),
(88, 'Nurul Hidayah', '6677889925', '2004-07-05', 'Manajemen', 'nurul.hidayah@example.com', '082390179242', 'Jl. Sudirman No.38'),
(89, 'Aditya Nugraha', '6677889926', '2004-08-06', 'Teknik Informatika', 'aditya.nugraha@example.com', '082390179243', 'Jl. Kartini No.39'),
(90, 'Mila Rahmawati', '6677889927', '2004-09-07', 'Sistem Informasi', 'mila.rahmawati@example.com', '082390179244', 'Jl. Diponegoro No.40');

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `id_matakuliah` int(11) NOT NULL,
  `nama_matakuliah` varchar(100) NOT NULL,
  `kode_matakuliah` varchar(20) NOT NULL,
  `sks` int(11) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`id_matakuliah`, `nama_matakuliah`, `kode_matakuliah`, `sks`, `jurusan`) VALUES
(1, 'Pemrograman Dasar', 'TI101', 3, 'Teknik Informatika'),
(2, 'Basis Data', 'SI201', 4, 'Sistem Informasi'),
(3, 'Manajemen Keuangan', 'MN301', 3, 'Manajemen'),
(4, 'Algoritma dan Struktur Data', 'TI102', 4, 'Teknik Informatika'),
(5, 'Sistem Operasi', 'SI202', 3, 'Sistem Informasi'),
(6, 'Pemasaran Digital', 'MN302', 3, 'Manajemen'),
(7, 'Jaringan Komputer', 'TI103', 4, 'Teknik Informatika'),
(8, 'Analisis Sistem', 'SI203', 3, 'Sistem Informasi'),
(9, 'Etika Bisnis', 'MN303', 2, 'Manajemen'),
(11, 'Statistika', 'TI201', 3, 'Teknik Informatika'),
(12, 'Analisis Algoritma', 'TI202', 4, 'Teknik Informatika'),
(13, 'Pengembangan Web', 'TI203', 3, 'Teknik Informatika'),
(14, 'Sistem Informasi Terdistribusi', 'SI301', 4, 'Sistem Informasi'),
(15, 'Manajemen Proyek TI', 'MN401', 3, 'Manajemen'),
(16, 'Kewirausahaan TI', 'TI204', 3, 'Teknik Informatika'),
(17, 'Keamanan Jaringan', 'TI205', 4, 'Teknik Informatika'),
(18, 'Sistem Informasi Akuntansi', 'SI302', 3, 'Sistem Informasi'),
(19, 'Manajemen Sumber Daya Manusia', 'MN402', 3, 'Manajemen'),
(20, 'Desain Grafis', 'TI206', 3, 'Teknik Informatika'),
(21, 'Pemrograman Mobile', 'TI207', 4, 'Teknik Informatika'),
(22, 'Analisis Data', 'SI303', 3, 'Sistem Informasi'),
(23, 'Etika Profesi TI', 'MN403', 2, 'Manajemen'),
(24, 'Sistem Informasi Geografis', 'SI304', 3, 'Sistem Informasi'),
(25, 'Kecerdasan Bisnis', 'MN404', 3, 'Manajemen'),
(26, 'Pemrograman Lanjut', 'TI208', 4, 'Teknik Informatika'),
(27, 'Sistem Basis Data Lanjut', 'SI305', 4, 'Sistem Informasi'),
(28, 'Manajemen Risiko', 'MN405', 3, 'Manajemen'),
(29, 'Interaksi Manusia dan Komputer', 'TI209', 3, 'Teknik Informatika'),
(30, 'Analisis dan Desain Sistem', 'SI306', 3, 'Sistem Informasi'),
(77, 'Manajemen Proyek', 'MN304', 3, 'Manajemen'),
(78, 'Pengantar Ilmu Komputer', 'TI106', 3, 'Teknik Informatika'),
(79, 'Pemrograman Web', 'TI107', 4, 'Teknik Informatika'),
(80, 'Sistem Informasi Manajemen', 'SI205', 3, 'Sistem Informasi'),
(81, 'Komunikasi Bisnis', 'MN305', 2, 'Manajemen'),
(82, 'Desain Sistem Informasi', 'SI206', 3, 'Sistem Informasi'),
(83, 'Kewirausahaan', 'MN306', 3, 'Manajemen'),
(84, 'Kecerdasan Buatan', 'TI108', 4, 'Teknik Informatika');

-- --------------------------------------------------------

--
-- Table structure for table `registrasi`
--

CREATE TABLE `registrasi` (
  `id_registrasi` int(11) NOT NULL,
  `id_mahasiswa` int(11) NOT NULL,
  `id_matakuliah` int(11) NOT NULL,
  `id_dosen` int(11) NOT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `tahun_ajaran` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrasi`
--

INSERT INTO `registrasi` (`id_registrasi`, `id_mahasiswa`, `id_matakuliah`, `id_dosen`, `semester`, `tahun_ajaran`) VALUES
(23, 1, 7, 24, 'Ganjil', '2023/2024'),
(24, 11, 83, 14, 'Genap', '2023/2024'),
(25, 83, 81, 8, 'Genap', '2023/2024'),
(26, 46, 29, 12, 'Ganjil', '2023/2024'),
(27, 42, 20, 28, 'Genap', '2023/2024'),
(28, 11, 83, 19, 'Ganjil', '2023/2024'),
(29, 74, 17, 28, 'Genap', '2023/2024'),
(30, 8, 9, 7, 'Ganjil', '2023/2024'),
(31, 71, 7, 25, 'Ganjil', '2023/2024'),
(33, 11, 7, 17, 'Genap', '2023/2024'),
(34, 44, 84, 24, 'Genap', '2023/2024'),
(35, 62, 83, 24, 'Ganjil', '2023/2024');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`id_matakuliah`),
  ADD UNIQUE KEY `kode_matakuliah` (`kode_matakuliah`);

--
-- Indexes for table `registrasi`
--
ALTER TABLE `registrasi`
  ADD PRIMARY KEY (`id_registrasi`),
  ADD KEY `id_mahasiswa` (`id_mahasiswa`),
  ADD KEY `id_matakuliah` (`id_matakuliah`),
  ADD KEY `id_dosen` (`id_dosen`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `id_matakuliah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `registrasi`
--
ALTER TABLE `registrasi`
  MODIFY `id_registrasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `registrasi`
--
ALTER TABLE `registrasi`
  ADD CONSTRAINT `registrasi_ibfk_1` FOREIGN KEY (`id_mahasiswa`) REFERENCES `mahasiswa` (`id_mahasiswa`),
  ADD CONSTRAINT `registrasi_ibfk_2` FOREIGN KEY (`id_matakuliah`) REFERENCES `matakuliah` (`id_matakuliah`),
  ADD CONSTRAINT `registrasi_ibfk_3` FOREIGN KEY (`id_dosen`) REFERENCES `dosen` (`id_dosen`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
