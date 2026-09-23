-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2026 at 07:26 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ukk_2026`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_guru`
--

CREATE TABLE `t_guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_guru`
--

INSERT INTO `t_guru` (`id`, `nip`, `nama`, `email`, `status_aktif`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '198501012010011001', 'Ahmad Dahlan', 'ahmad@sekolah.sch.id', 1, 2, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(2, '198703152012011002', 'Budi Santoso', 'budi@sekolah.sch.id', 1, 3, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(3, '199005202015012003', 'Siti Nurhaliza', 'siti@sekolah.sch.id', 1, 4, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(4, '199208102018012004', 'Dewi Lestari', 'dewi@sekolah.sch.id', 1, 5, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(5, '198801012011011005', 'Eko Prasetyo', 'eko@sekolah.sch.id', 1, 6, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(6, '198902022012012006', 'Fitriani', 'fitriani@sekolah.sch.id', 1, 7, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(7, '199003032013011007', 'Ginanjar', 'ginanjar@sekolah.sch.id', 1, 8, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(8, '199104042014012008', 'Hany Handayani', 'hany@sekolah.sch.id', 1, 9, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(9, '199205052015011009', 'Irfan Hakim', 'irfan@sekolah.sch.id', 1, 10, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(10, '199306062016011010', 'Joko Widodo', 'joko@sekolah.sch.id', 1, 11, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(11, '199407072017012011', 'Kartika Sari', 'kartika@sekolah.sch.id', 1, 12, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(12, '199508082018011012', 'Lukman Hakim', 'lukman@sekolah.sch.id', 1, 13, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(13, '199609092019012013', 'Mina Kusuma', 'mina@sekolah.sch.id', 1, 14, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(14, '199710102020011014', 'Nugroho', 'nugroho@sekolah.sch.id', 1, 15, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(15, '199811112021012015', 'Oktavia', 'oktavia@sekolah.sch.id', 1, 16, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(16, '199912122022012016', 'Puspa Indah', 'puspa@sekolah.sch.id', 1, 17, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(17, '198001132005011017', 'Qomaruddin', 'qomar@sekolah.sch.id', 1, 18, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(18, '198102142006012018', 'Rini Astuti', 'rini@sekolah.sch.id', 1, 19, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(19, '198203152007011019', 'Surya Kencana', 'surya@sekolah.sch.id', 1, 20, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(20, '198304162008012020', 'Tri Wahyuni', 'tri@sekolah.sch.id', 1, 21, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(21, '198405172009012021', 'Utami', 'utami@sekolah.sch.id', 1, 22, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(22, '198506182010012022', 'Vina Pandu', 'vina@sekolah.sch.id', 1, 23, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(23, '198607192011011023', 'Wawan Kurniawan', 'wawan@sekolah.sch.id', 1, 24, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(24, '198708202012011024', 'Xavier', 'xavier@sekolah.sch.id', 1, 25, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(25, '198809212013012025', 'Yuni Shara', 'yuni@sekolah.sch.id', 1, 26, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(26, '198910222014011026', 'Zainal Abidin', 'zainal@sekolah.sch.id', 1, 27, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(27, '199011232015011027', 'Agus Harimurti', 'agus@sekolah.sch.id', 1, 28, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(28, '199112242016011028', 'Bambang Soesatyo', 'bambang@sekolah.sch.id', 1, 29, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(29, '199201252017012029', 'Cinta Laura', 'cinta@sekolah.sch.id', 1, 30, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(30, '199302262018012030', 'Dian Sastro', 'dian@sekolah.sch.id', 1, 31, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(31, '199403272019011031', 'Endank Soekamti', 'endank@sekolah.sch.id', 1, 32, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(32, '199504282020012032', 'Farah Quinn', 'farah@sekolah.sch.id', 1, 33, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(33, '199605292021011033', 'Gading Marten', 'gading@sekolah.sch.id', 1, 34, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(34, '199706302022011034', 'Hamish Daud', 'hamish@sekolah.sch.id', 1, 35, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(35, '199807312023011035', 'Iko Uwais', 'iko@sekolah.sch.id', 1, 36, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(36, '199908012024011036', 'Joe Taslim', 'joe@sekolah.sch.id', 1, 37, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(37, '198109022005012037', 'Kiki Fatmala', 'kikif@sekolah.sch.id', 1, 38, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(38, '198210032006012038', 'Luna Maya', 'luna@sekolah.sch.id', 1, 39, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(39, '198311042007012039', 'Maudy Ayunda', 'maudy@sekolah.sch.id', 1, 40, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(40, '198412052008011040', 'Nicholas Saputra', 'nicholas@sekolah.sch.id', 1, 41, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(41, '198501062009012041', 'Olla Ramlan', 'olla@sekolah.sch.id', 1, 42, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(42, '198602072010012042', 'Pebbi Lie', 'pebbi@sekolah.sch.id', 1, 43, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(43, '198703082011011043', 'Raditya Dika', 'raditya@sekolah.sch.id', 1, 44, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(44, '198804092012011044', 'Sule Prikitiw', 'sule@sekolah.sch.id', 1, 45, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(45, '198905102013012045', 'Titi Kamal', 'titi@sekolah.sch.id', 1, 46, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(46, '199006112014011046', 'Uus Standup', 'uus@sekolah.sch.id', 1, 47, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(47, '199107122015011047', 'Vino G Bastian', 'vino@sekolah.sch.id', 1, 48, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(48, '199208132016012048', 'Wika Salim', 'wika@sekolah.sch.id', 1, 49, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(49, '199309142017012049', 'Yura Yunita', 'yura@sekolah.sch.id', 1, 50, '2026-09-23 03:43:40', '2026-09-23 03:43:40'),
(50, '199410152018011050', 'Zidane Iqbal', 'zidane@sekolah.sch.id', 1, 1, '2026-09-23 03:43:40', '2026-09-23 03:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `t_kelas`
--

CREATE TABLE `t_kelas` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tingkat` varchar(20) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_kelas`
--

INSERT INTO `t_kelas` (`id`, `nama`, `tingkat`, `jurusan`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'X RPL 1', 'X', 'Rekayasa Perangkat Lunak', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(2, 'X RPL 2', 'X', 'Rekayasa Perangkat Lunak', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(3, 'XI RPL 1', 'XI', 'Rekayasa Perangkat Lunak', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(4, 'XI RPL 2', 'XI', 'Rekayasa Perangkat Lunak', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(5, 'XII RPL 1', 'XII', 'Rekayasa Perangkat Lunak', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(6, 'XII RPL 2', 'XII', 'Rekayasa Perangkat Lunak', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(7, 'X TKJ 1', 'X', 'Teknik Komputer Jaringan', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(8, 'X TKJ 2', 'X', 'Teknik Komputer Jaringan', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(9, 'XI TKJ 1', 'XI', 'Teknik Komputer Jaringan', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(10, 'XI TKJ 2', 'XI', 'Teknik Komputer Jaringan', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(11, 'XII TKJ 1', 'XII', 'Teknik Komputer Jaringan', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(12, 'XII TKJ 2', 'XII', 'Teknik Komputer Jaringan', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(13, 'X DKV 1', 'X', 'Desain Komunikasi Visual', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(14, 'X DKV 2', 'X', 'Desain Komunikasi Visual', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(15, 'XI DKV 1', 'XI', 'Desain Komunikasi Visual', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(16, 'XI DKV 2', 'XI', 'Desain Komunikasi Visual', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(17, 'XII DKV 1', 'XII', 'Desain Komunikasi Visual', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(18, 'XII DKV 2', 'XII', 'Desain Komunikasi Visual', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(19, 'X AKL 1', 'X', 'Akuntansi Keuangan Lembaga', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(20, 'X AKL 2', 'X', 'Akuntansi Keuangan Lembaga', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(21, 'XI AKL 1', 'XI', 'Akuntansi Keuangan Lembaga', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(22, 'XI AKL 2', 'XI', 'Akuntansi Keuangan Lembaga', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(23, 'XII AKL 1', 'XII', 'Akuntansi Keuangan Lembaga', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(24, 'XII AKL 2', 'XII', 'Akuntansi Keuangan Lembaga', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(25, 'X OTKP 1', 'X', 'Otomatisasi Tata Kelola Perkantoran', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(26, 'X OTKP 2', 'X', 'Otomatisasi Tata Kelola Perkantoran', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(27, 'XI OTKP 1', 'XI', 'Otomatisasi Tata Kelola Perkantoran', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(28, 'XI OTKP 2', 'XI', 'Otomatisasi Tata Kelola Perkantoran', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(29, 'XII OTKP 1', 'XII', 'Otomatisasi Tata Kelola Perkantoran', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(30, 'XII OTKP 2', 'XII', 'Otomatisasi Tata Kelola Perkantoran', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(31, 'X BDP 1', 'X', 'Bisnis Daring dan Pemasaran', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(32, 'X BDP 2', 'X', 'Bisnis Daring dan Pemasaran', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(33, 'XI BDP 1', 'XI', 'Bisnis Daring dan Pemasaran', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(34, 'XI BDP 2', 'XI', 'Bisnis Daring dan Pemasaran', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(35, 'XII BDP 1', 'XII', 'Bisnis Daring dan Pemasaran', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(36, 'XII BDP 2', 'XII', 'Bisnis Daring dan Pemasaran', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(37, 'X TKR 1', 'X', 'Teknik Kendaraan Ringan', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(38, 'X TKR 2', 'X', 'Teknik Kendaraan Ringan', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(39, 'XI TKR 1', 'XI', 'Teknik Kendaraan Ringan', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(40, 'XI TKR 2', 'XI', 'Teknik Kendaraan Ringan', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(41, 'XII TKR 1', 'XII', 'Teknik Kendaraan Ringan', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(42, 'XII TKR 2', 'XII', 'Teknik Kendaraan Ringan', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(43, 'X TSM 1', 'X', 'Teknik Sepeda Motor', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(44, 'X TSM 2', 'X', 'Teknik Sepeda Motor', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(45, 'XI TSM 1', 'XI', 'Teknik Sepeda Motor', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(46, 'XI TSM 2', 'XI', 'Teknik Sepeda Motor', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(47, 'XII TSM 1', 'XII', 'Teknik Sepeda Motor', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(48, 'XII TSM 2', 'XII', 'Teknik Sepeda Motor', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(49, 'X MM 1', 'X', 'Multimedia', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26'),
(50, 'XI MM 1', 'XI', 'Multimedia', 1, '2026-09-23 03:43:26', '2026-09-23 03:43:26');

-- --------------------------------------------------------

--
-- Table structure for table `t_kelas_siswa`
--

CREATE TABLE `t_kelas_siswa` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_kelas_siswa`
--

INSERT INTO `t_kelas_siswa` (`id`, `siswa_id`, `tahun_ajaran_id`, `kelas_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 49, 1, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(2, 2, 49, 1, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(3, 3, 49, 1, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(4, 4, 49, 1, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(5, 5, 49, 1, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(6, 6, 49, 3, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(7, 7, 49, 3, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(8, 8, 49, 3, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(9, 9, 49, 3, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(10, 10, 49, 3, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(11, 11, 49, 5, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(12, 12, 49, 5, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(13, 13, 49, 5, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(14, 14, 49, 5, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(15, 15, 49, 5, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(16, 16, 49, 1, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(17, 17, 49, 1, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(18, 18, 49, 3, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(19, 19, 49, 3, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(20, 20, 49, 5, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(21, 21, 49, 7, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(22, 22, 49, 7, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(23, 23, 49, 7, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(24, 24, 49, 7, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(25, 25, 49, 7, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(26, 26, 49, 9, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(27, 27, 49, 9, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(28, 28, 49, 9, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(29, 29, 49, 9, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(30, 30, 49, 9, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(31, 31, 49, 11, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(32, 32, 49, 11, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(33, 33, 49, 11, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(34, 34, 49, 11, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(35, 35, 49, 11, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(36, 36, 49, 13, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(37, 37, 49, 13, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(38, 38, 49, 15, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(39, 39, 49, 15, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(40, 40, 49, 17, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(41, 41, 49, 19, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(42, 42, 49, 19, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(43, 43, 49, 21, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(44, 44, 49, 21, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(45, 45, 49, 23, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(46, 46, 49, 25, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(47, 47, 49, 25, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(48, 48, 49, 27, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(49, 49, 49, 27, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56'),
(50, 50, 49, 29, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:56', '2026-09-23 03:44:56');

-- --------------------------------------------------------

--
-- Table structure for table `t_pelanggaran`
--

CREATE TABLE `t_pelanggaran` (
  `id` int(11) NOT NULL,
  `pelanggaran_kategori_id` int(11) DEFAULT NULL,
  `kode` varchar(30) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `poin` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_pelanggaran`
--

INSERT INTO `t_pelanggaran` (`id`, `pelanggaran_kategori_id`, `kode`, `nama`, `poin`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 'KED-01', 'Terlambat Masuk Sekolah (< 15 menit)', 5, 'Terlambat tipis', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(2, 1, 'KED-02', 'Terlambat Masuk Sekolah (> 15 menit)', 10, 'Terlambat parah', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(3, 1, 'KED-03', 'Membolos Jam Pelajaran', 20, 'Keluar tanpa izin', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(4, 2, 'RPH-01', 'Atribut Seragam Tidak Lengkap', 5, 'Tanpa dasi/sabuk', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(5, 2, 'RPH-02', 'Rambut Panjang / Tidak Rapi', 10, 'Rambut gondrong', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(6, 3, 'PRL-01', 'Bermain HP Saat Jam Pelajaran', 10, 'Main HP di kelas', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(7, 3, 'PRL-02', 'Bersikap Tidak Sopan Pada Guru', 25, 'Tidak santun', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(8, 4, 'BRT-01', 'Merokok di Lingkungan Sekolah', 50, 'Ngerokok di WC', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(9, 4, 'BRT-02', 'Terlibat Perkelahian / Tawuran', 100, 'Berkelahi', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(10, 5, 'LNK-01', 'Buang Sampah Sembarangan', 5, 'Mengotori area sekolah', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(11, 5, 'LNK-02', 'Coret-coret Meja/Dinding', 15, 'Vandalisme ringan', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(12, 6, 'FAS-01', 'Merusak Fasilitas Kelas', 30, 'Merusak kursi/meja', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(13, 7, 'ELE-01', 'Mencharge HP Tanpa Izin', 5, 'Gunakan listrik sekolah', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(14, 8, 'ADM-01', 'Palsu Tanda Tangan Orang Tua', 35, 'Pemalsuan dokumen', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(15, 9, 'AGM-01', 'Meninggalkan Sholat Berjamaah', 10, 'Meninggalkan ibadah wajib', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(16, 10, 'LLT-01', 'Knalpot Brong di Sekolah', 20, 'Bising kendaraan', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(17, 1, 'KED-04', 'Tidak Ikut Upacara Bendera', 15, 'Sengaja kabur upacara', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(18, 2, 'RPH-03', 'Pakaian Ketat / Tidak Sesuai', 10, 'Seragam dimodifikasi', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(19, 3, 'PRL-03', 'Mencuri Barang Teman', 50, 'Pencurian skala kecil', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(20, 4, 'BRT-03', 'Membawa Miras / Narkoba', 100, 'Pelanggaran hukum berat', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(21, 5, 'LNK-03', 'Tidak Piket Kelas', 5, 'Abaikan tugas kebersihan', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(22, 6, 'FAS-02', 'Mencoret Komputer Lab', 25, 'Vandalisme lab', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(23, 7, 'ELE-02', 'Main Game saat Ujian', 30, 'Kecurangan game', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(24, 8, 'ADM-02', 'Menolak Bayar Kas', 5, 'Tunggakan kas', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(25, 9, 'AGM-02', 'Makan Saat Bulan Puasa', 15, 'Tidak toleransi', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(26, 10, 'LLT-02', 'Parkir Diluar Area Resmi', 10, 'Parkir sembarangan', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(27, 1, 'KED-05', 'Pulang Sebelum Waktunya', 20, 'Kecolongan jam pulang', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(28, 2, 'RPH-04', 'Tidak Memakai Sepatu Hitam', 5, 'Sepatu warna-warni', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(29, 3, 'PRL-04', 'Bullying / Perundungan Lisan', 30, 'Mengejek berlebihan', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(30, 4, 'BRT-04', 'Judi Online / Kartu di Sekolah', 50, 'Perjudian', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(31, 1, 'KED-06', 'Izin Palsu Sakit', 15, 'Manipulasi surat izin', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(32, 2, 'RPH-05', 'Memakai Perhiasan Berlebih', 5, 'Perhiasan mencolok', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(33, 3, 'PRL-05', 'Nyontek Saat Ulangan', 20, 'Kecurangan akademik', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(34, 4, 'BRT-05', 'Membawa Senjata Tajam', 100, 'Ancaman keamanan', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(35, 5, 'LNK-04', 'Merusak Tanaman Sekolah', 10, 'Merusak taman', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(36, 6, 'FAS-03', 'Meninggalkan AC/Lampu Nyala', 5, 'Pemborosan energi', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(37, 7, 'ELE-03', 'Merekam Tanpa Izin Guru', 15, 'Pelanggaran privasi', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(38, 8, 'ADM-03', 'Hilangkan Kartu Pelajar', 5, 'Kelalaian dokumen', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(39, 9, 'AGM-03', 'Mengganggu Jam Ibadah', 20, 'Gagalkan ketertiban', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(40, 10, 'LLT-03', 'Ngebut di Area Sekolah', 25, 'Bahaya lalu lintas', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(41, 1, 'KED-07', 'Terlambat Ekstrakurikuler', 5, 'Disiplin ekstra', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(42, 2, 'RPH-06', 'Mewarnai Rambut', 20, 'Rambut di-cat', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(43, 3, 'PRL-06', 'Ujaran Kebencian di Sosmed', 35, 'Media sosial negatif', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(44, 4, 'BRT-06', 'Tindakan Asusila', 100, 'Pelanggaran moral berat', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(45, 5, 'LNK-05', 'Makan di Dalam Kelas', 5, 'Sampah makanan kelas', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(46, 6, 'FAS-04', 'Merusak Buku Perpustakaan', 15, 'Kerusakan sarana', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(47, 7, 'ELE-04', 'Sebar Hoaks di Grup Kelas', 20, 'Informasi palsu', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(48, 8, 'ADM-04', 'Terlambat Kembalikan Buku Lib', 5, 'Buku denda', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(49, 9, 'AGM-04', 'Mengejek Busana Keagamaan', 40, 'SARA', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14'),
(50, 10, 'LLT-04', 'Boncengan Tiga di Sekolah', 15, 'Pelanggaran safety', 1, '2026-09-23 03:44:14', '2026-09-23 03:44:14');

-- --------------------------------------------------------

--
-- Table structure for table `t_pelanggaran_kategori`
--

CREATE TABLE `t_pelanggaran_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_pelanggaran_kategori`
--

INSERT INTO `t_pelanggaran_kategori` (`id`, `nama`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Kedisiplinan & Kehadiran', 'Pelanggaran terkait waktu dan keterlambatan', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(2, 'Kerapihan & Seragam', 'Pelanggaran Atribut dan Pakaian', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(3, 'Perilaku & Etika', 'Pelanggaran Sikap dan Kesopanan', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(4, 'Pelanggaran Berat', 'Tindakan Kriminal dan Bencana Sekolah', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(5, 'Ketertiban Lingkungan', 'Pelanggaran kebersihan kelas dan lingkungan', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(6, 'Penggunaan Fasilitas', 'Kerusakan dan penyalahgunaan alat sekolah', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(7, 'Penggunaan Alat Elektronik', 'Penggunaan HP/Gadget tanpa izin', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(8, 'Administrasi & Keuangan', 'Pelanggaran dokumen dan kas kelas', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(9, 'Pelanggaran Norma Agama', 'Pelanggaran pelaksanaan ibadah wajib', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(10, 'Lalu Lintas & Kendaraan', 'Parkir liar dan pelanggaran berkendara', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(11, 'Kategori Sub-11', 'Deskripsi Kategori Pelanggaran 11', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(12, 'Kategori Sub-12', 'Deskripsi Kategori Pelanggaran 12', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(13, 'Kategori Sub-13', 'Deskripsi Kategori Pelanggaran 13', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(14, 'Kategori Sub-14', 'Deskripsi Kategori Pelanggaran 14', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(15, 'Kategori Sub-15', 'Deskripsi Kategori Pelanggaran 15', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(16, 'Kategori Sub-16', 'Deskripsi Kategori Pelanggaran 16', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(17, 'Kategori Sub-17', 'Deskripsi Kategori Pelanggaran 17', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(18, 'Kategori Sub-18', 'Deskripsi Kategori Pelanggaran 18', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(19, 'Kategori Sub-19', 'Deskripsi Kategori Pelanggaran 19', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(20, 'Kategori Sub-20', 'Deskripsi Kategori Pelanggaran 20', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(21, 'Kategori Sub-21', 'Deskripsi Kategori Pelanggaran 21', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(22, 'Kategori Sub-22', 'Deskripsi Kategori Pelanggaran 22', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(23, 'Kategori Sub-23', 'Deskripsi Kategori Pelanggaran 23', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(24, 'Kategori Sub-24', 'Deskripsi Kategori Pelanggaran 24', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(25, 'Kategori Sub-25', 'Deskripsi Kategori Pelanggaran 25', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(26, 'Kategori Sub-26', 'Deskripsi Kategori Pelanggaran 26', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(27, 'Kategori Sub-27', 'Deskripsi Kategori Pelanggaran 27', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(28, 'Kategori Sub-28', 'Deskripsi Kategori Pelanggaran 28', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(29, 'Kategori Sub-29', 'Deskripsi Kategori Pelanggaran 29', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(30, 'Kategori Sub-30', 'Deskripsi Kategori Pelanggaran 30', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(31, 'Kategori Sub-31', 'Deskripsi Kategori Pelanggaran 31', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(32, 'Kategori Sub-32', 'Deskripsi Kategori Pelanggaran 32', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(33, 'Kategori Sub-33', 'Deskripsi Kategori Pelanggaran 33', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(34, 'Kategori Sub-34', 'Deskripsi Kategori Pelanggaran 34', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(35, 'Kategori Sub-35', 'Deskripsi Kategori Pelanggaran 35', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(36, 'Kategori Sub-36', 'Deskripsi Kategori Pelanggaran 36', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(37, 'Kategori Sub-37', 'Deskripsi Kategori Pelanggaran 37', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(38, 'Kategori Sub-38', 'Deskripsi Kategori Pelanggaran 38', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(39, 'Kategori Sub-39', 'Deskripsi Kategori Pelanggaran 39', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(40, 'Kategori Sub-40', 'Deskripsi Kategori Pelanggaran 40', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(41, 'Kategori Sub-41', 'Deskripsi Kategori Pelanggaran 41', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(42, 'Kategori Sub-42', 'Deskripsi Kategori Pelanggaran 42', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(43, 'Kategori Sub-43', 'Deskripsi Kategori Pelanggaran 43', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(44, 'Kategori Sub-44', 'Deskripsi Kategori Pelanggaran 44', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(45, 'Kategori Sub-45', 'Deskripsi Kategori Pelanggaran 45', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(46, 'Kategori Sub-46', 'Deskripsi Kategori Pelanggaran 46', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(47, 'Kategori Sub-47', 'Deskripsi Kategori Pelanggaran 47', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(48, 'Kategori Sub-48', 'Deskripsi Kategori Pelanggaran 48', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(49, 'Kategori Sub-49', 'Deskripsi Kategori Pelanggaran 49', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59'),
(50, 'Kategori Sub-50', 'Deskripsi Kategori Pelanggaran 50', 1, '2026-09-23 03:43:59', '2026-09-23 03:43:59');

-- --------------------------------------------------------

--
-- Table structure for table `t_pelanggaran_siswa`
--

CREATE TABLE `t_pelanggaran_siswa` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `nama_siswa` varchar(150) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `pelanggaran_id` int(11) DEFAULT NULL,
  `nama_pelanggaran` varchar(150) NOT NULL,
  `pelanggaran_kategori_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `nama_guru` varchar(150) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` text NOT NULL,
  `poin` int(11) NOT NULL,
  `tindakan` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_pelanggaran_siswa`
--

INSERT INTO `t_pelanggaran_siswa` (`id`, `tahun_ajaran_id`, `siswa_id`, `nama_siswa`, `kelas_id`, `nama_kelas`, `pelanggaran_id`, `nama_pelanggaran`, `pelanggaran_kategori_id`, `guru_id`, `nama_guru`, `tanggal`, `keterangan`, `poin`, `tindakan`, `status`, `created_at`, `updated_at`) VALUES
(1, 49, 1, 'Andi Pratama', 1, 'X RPL 1', 1, 'Terlambat Masuk Sekolah (< 15 menit)', 1, 1, 'Ahmad Dahlan', '2025-08-01', 'Macet di jalan', 5, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(2, 49, 2, 'Budi Cahyono', 1, 'X RPL 1', 4, 'Atribut Seragam Tidak Lengkap', 2, 1, 'Ahmad Dahlan', '2025-08-02', 'Tidak pakai dasi', 5, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(3, 49, 4, 'Deni Setiawan', 1, 'X RPL 1', 2, 'Terlambat Masuk Sekolah (> 15 menit)', 1, 1, 'Ahmad Dahlan', '2025-08-03', 'Kesiangan', 10, 'Pembinaan Wali Kelas', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(4, 49, 6, 'Fajar Hidayat', 3, 'XI RPL 1', 6, 'Bermain HP Saat Jam Pelajaran', 3, 3, 'Siti Nurhaliza', '2025-08-05', 'Main game', 10, 'HP Disita 1 Hari', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(5, 49, 8, 'Hadi Wijaya', 3, 'XI RPL 1', 5, 'Rambut Panjang / Tidak Rapi', 2, 3, 'Siti Nurhaliza', '2025-08-06', 'Rambut gondrong', 10, 'Pangkas di Tempat', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(6, 49, 10, 'Joko Susilo', 3, 'XI RPL 1', 3, 'Membolos Jam Pelajaran', 1, 3, 'Siti Nurhaliza', '2025-08-08', 'Di kantin', 20, 'Surat Peringatan 1', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(7, 49, 11, 'Kiki Rizky', 5, 'XII RPL 1', 8, 'Merokok di Lingkungan Sekolah', 4, 5, 'Eko Prasetyo', '2025-08-10', 'Merokok di WC', 50, 'Panggilan Orang Tua', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(8, 49, 13, 'Muhammad Rizky', 5, 'XII RPL 1', 1, 'Terlambat Masuk Sekolah (< 15 menit)', 1, 5, 'Eko Prasetyo', '2025-08-11', 'Ban bocor', 5, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(9, 49, 15, 'Oki Lukman', 5, 'XII RPL 1', 7, 'Bersikap Tidak Sopan Pada Guru', 3, 5, 'Eko Prasetyo', '2025-08-12', 'Membentak guru', 25, 'Panggilan Orang Tua', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(10, 49, 3, 'Citra Dewi', 1, 'X RPL 1', 4, 'Atribut Seragam Tidak Lengkap', 2, 4, 'Dewi Lestari', '2025-08-14', 'Kaos kaki salah warna', 5, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(11, 49, 5, 'Eka Rahmawati', 1, 'X RPL 1', 1, 'Terlambat Masuk Sekolah (< 15 menit)', 1, 4, 'Dewi Lestari', '2025-08-15', 'Hujan deras', 5, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(12, 49, 7, 'Gita Gutawa', 3, 'XI RPL 1', 6, 'Bermain HP Saat Jam Pelajaran', 3, 3, 'Siti Nurhaliza', '2025-08-18', 'Main medsos', 10, 'HP Disita 1 Hari', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(13, 49, 9, 'Indah Permata', 3, 'XI RPL 1', 1, 'Terlambat Masuk Sekolah (< 15 menit)', 1, 3, 'Siti Nurhaliza', '2025-08-20', 'Macet KA', 5, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(14, 49, 12, 'Lia Amalia', 5, 'XII RPL 1', 4, 'Atribut Seragam Tidak Lengkap', 2, 5, 'Eko Prasetyo', '2025-08-22', 'Tanpa sabuk', 5, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(15, 49, 14, 'Nabila Putri', 5, 'XII RPL 1', 6, 'Bermain HP Saat Jam Pelajaran', 3, 5, 'Eko Prasetyo', '2025-08-25', 'Nonton video', 10, 'HP Disita 1 Hari', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(16, 49, 16, 'Pratama Arhan', 1, 'X RPL 1', 1, 'Terlambat Masuk Sekolah (< 15 menit)', 1, 1, 'Ahmad Dahlan', '2025-09-01', 'Kesiangan', 5, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(17, 49, 17, 'Qori Sandioriva', 1, 'X RPL 1', 4, 'Atribut Seragam Tidak Lengkap', 2, 1, 'Ahmad Dahlan', '2025-09-02', 'Kaos kaki pendek', 5, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(18, 49, 18, 'Rizky Febian', 3, 'XI RPL 1', 6, 'Bermain HP Saat Jam Pelajaran', 3, 3, 'Siti Nurhaliza', '2025-09-03', 'Dengar lagu', 10, 'HP Disita 1 Hari', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(19, 49, 19, 'Siti Badriah', 3, 'XI RPL 1', 2, 'Terlambat Masuk Sekolah (> 15 menit)', 1, 3, 'Siti Nurhaliza', '2025-09-04', 'Motor mogok', 10, 'Pembinaan Wali Kelas', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(20, 49, 20, 'Taufik Hidayat', 5, 'XII RPL 1', 5, 'Rambut Panjang / Tidak Rapi', 2, 5, 'Eko Prasetyo', '2025-09-05', 'Rambut gondrong', 10, 'Pangkas di Tempat', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(21, 49, 21, 'Umar Bin Khattab', 7, 'X TKJ 1', 10, 'Buang Sampah Sembarangan', 5, 7, 'Ginanjar', '2025-09-06', 'Buang plastik krupuk', 5, 'Kurung Kebersihan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(22, 49, 22, 'Vina Garut', 7, 'X TKJ 1', 11, 'Coret-coret Meja/Dinding', 5, 7, 'Ginanjar', '2025-09-07', 'Coret meja pakai tipe-x', 15, 'Bersihkan Meja', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(23, 49, 23, 'Wawan Febrianto', 7, 'X TKJ 1', 12, 'Merusak Fasilitas Kelas', 6, 7, 'Ginanjar', '2025-09-08', 'Gagang pintu patah', 30, 'Ganti Rugi', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(24, 49, 24, 'Xenia Indonesia', 7, 'X TKJ 1', 13, 'Mencharge HP Tanpa Izin', 7, 7, 'Ginanjar', '2025-09-09', 'Ngecas di stopkontak lab', 5, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(25, 49, 25, 'Yusuf Bachtiar', 7, 'X TKJ 1', 14, 'Palsu Tanda Tangan Orang Tua', 8, 7, 'Ginanjar', '2025-09-10', 'Surat izin dipalsukan', 35, 'Panggilan Orang Tua', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(26, 49, 26, 'Zaskia Gotik', 9, 'XI TKJ 1', 15, 'Meninggalkan Sholat Berjamaah', 9, 9, 'Irfan Hakim', '2025-09-11', 'Sembunyi saat dhuhur', 10, 'Sholat Sendirian', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(27, 49, 27, 'Atep Rizal', 9, 'XI TKJ 1', 16, 'Knalpot Brong di Sekolah', 10, 9, 'Irfan Hakim', '2025-09-12', 'Knalpot bising', 20, 'Copot Knalpot', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(28, 49, 28, 'Bintang Timur', 9, 'XI TKJ 1', 17, 'Tidak Ikut Upacara Bendera', 1, 9, 'Irfan Hakim', '2025-09-15', 'Ngepet di toilet', 15, 'Hormat Tiang Bendera', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(29, 49, 29, 'Cici Paramida', 9, 'XI TKJ 1', 18, 'Pakaian Ketat / Tidak Sesuai', 2, 9, 'Irfan Hakim', '2025-09-16', 'Rok terlalu pendek', 10, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(30, 49, 30, 'Deden Natshir', 9, 'XI TKJ 1', 19, 'Mencuri Barang Teman', 3, 9, 'Irfan Hakim', '2025-09-17', 'Ambil uang kas', 50, 'Panggilan Orang Tua', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(31, 49, 31, 'Eka Ramdani', 11, 'XII TKJ 1', 20, 'Membawa Miras / Narkoba', 4, 11, 'Kartika Sari', '2025-09-18', 'Bawa botol miras', 100, 'Skorsing / DO', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(32, 49, 32, 'Fani Supriyanto', 11, 'XII TKJ 1', 21, 'Tidak Piket Kelas', 5, 11, 'Kartika Sari', '2025-09-19', 'Langsung pulang', 5, 'Piket Sendiri', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(33, 49, 33, 'Gugun Gondrong', 11, 'XII TKJ 1', 22, 'Mencoret Komputer Lab', 6, 11, 'Kartika Sari', '2025-09-22', 'Coret layar monitor', 25, 'Bersihkan Lab', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(34, 49, 34, 'Hesti Purwadinata', 11, 'XII TKJ 1', 23, 'Main Game saat Ujian', 7, 11, 'Kartika Sari', '2025-09-23', 'Main Roblox pas UTS', 30, 'Nilai Ujian 0', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(35, 49, 35, 'Indra Sjafri', 11, 'XII TKJ 1', 24, 'Menolak Bayar Kas', 8, 11, 'Kartika Sari', '2025-09-24', 'Nunggak 3 bulan', 5, 'Bayar Kas', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(36, 49, 36, 'Jamal Mirdad', 13, 'X DKV 1', 25, 'Makan Saat Bulan Puasa', 9, 13, 'Mina Kusuma', '2025-09-25', 'Makan di kelas pas puasa', 15, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(37, 49, 37, 'Kristina', 13, 'X DKV 1', 26, 'Parkir Diluar Area Resmi', 10, 13, 'Mina Kusuma', '2025-09-26', 'Parkir di trotoar', 10, 'Pindahkan Motor', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(38, 49, 38, 'Lesti Kejora', 15, 'XI DKV 1', 27, 'Pulang Sebelum Waktunya', 1, 15, 'Oktavia', '2025-09-29', 'Kabur lewat pagar', 20, 'Surat Peringatan 1', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(39, 49, 39, 'Marcell Darwin', 15, 'XI DKV 1', 28, 'Tidak Memakai Sepatu Hitam', 2, 15, 'Oktavia', '2025-09-30', 'Sepatu warna putih', 5, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(40, 49, 40, 'Naysila Mirdad', 17, 'XII DKV 1', 29, 'Bullying / Perundungan Lisan', 3, 17, 'Qomaruddin', '2025-10-01', 'Ejek nama orang tua', 30, 'Bimbingan Konseling', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(41, 49, 41, 'Opick Tombo Ati', 19, 'X AKL 1', 30, 'Judi Online / Kartu di Sekolah', 4, 19, 'Surya Kencana', '2025-10-02', 'Main domino uang', 50, 'Panggilan Orang Tua', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(42, 49, 42, 'Prilly Latuconsina', 19, 'X AKL 1', 31, 'Izin Palsu Sakit', 1, 19, 'Surya Kencana', '2025-10-03', 'Surat dokter palsu', 15, 'Pembinaan Wali Kelas', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(43, 49, 43, 'Qibil Changcuters', 21, 'XI AKL 1', 32, 'Memakai Perhiasan Berlebih', 2, 21, 'Tri Wahyuni', '2025-10-06', 'Pakai kalung emas', 5, 'Copot Perhiasan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(44, 49, 44, 'Raffi Ahmad', 21, 'XI AKL 1', 33, 'Nyontek Saat Ulangan', 3, 21, 'Tri Wahyuni', '2025-10-07', 'Bawa kopekan', 20, 'Ulangan Susulan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(45, 49, 45, 'Sule Sutisna', 23, 'XII AKL 1', 34, 'Membawa Senjata Tajam', 4, 23, 'Wawan Kurniawan', '2025-10-08', 'Bawa pisau lipat', 100, 'Skorsing', 'Proses', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(46, 49, 46, 'Tria Changcuters', 25, 'X OTKP 1', 35, 'Merusak Tanaman Sekolah', 5, 25, 'Yuni Shara', '2025-10-09', 'Injak tanaman', 10, 'Ganti Tanaman', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(47, 49, 47, 'Uut Permatasari', 25, 'X OTKP 1', 36, 'Meninggalkan AC/Lampu Nyala', 6, 25, 'Yuni Shara', '2025-10-10', 'AC menyala pas pulang', 5, 'Teguran Lisan', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(48, 49, 48, 'Vicky Prasetyo', 27, 'XI OTKP 1', 37, 'Merekam Tanpa Izin Guru', 7, 27, 'Agus Harimurti', '2025-10-13', 'Video guru ngajar', 15, 'Hapus Video', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(49, 49, 49, 'Wika Salim Dua', 27, 'XI OTKP 1', 38, 'Hilangkan Kartu Pelajar', 8, 27, 'Agus Harimurti', '2025-10-14', 'Kartu hilang', 5, 'Cetak Ulang', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07'),
(50, 49, 50, 'Zaskia Adya Mecca', 29, 'XII OTKP 1', 39, 'Mengganggu Jam Ibadah', 9, 29, 'Cinta Laura', '2025-10-15', 'Ribut saat doa', 20, 'Pembinaan Rohani', 'Selesai', '2026-09-23 03:45:07', '2026-09-23 03:45:07');

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa`
--

CREATE TABLE `t_siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(30) DEFAULT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_siswa`
--

INSERT INTO `t_siswa` (`id`, `nis`, `nisn`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '23241001', '0061234001', 'Andi Pratama', 'L', '2008-01-15', 'Jl. Merdeka No. 12', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(2, '23241002', '0061234002', 'Budi Cahyono', 'L', '2008-03-22', 'Jl. Pemuda No. 45', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(3, '23241003', '0061234003', 'Citra Dewi', 'P', '2008-05-10', 'Jl. Mawar No. 08', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(4, '23241004', '0061234004', 'Deni Setiawan', 'L', '2008-07-19', 'Jl. Melati No. 23', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(5, '23241005', '0061234005', 'Eka Rahmawati', 'P', '2008-11-02', 'Jl. Anggrek No. 17', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(6, '22231006', '0051234006', 'Fajar Hidayat', 'L', '2007-02-14', 'Jl. Sudirman No. 99', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(7, '22231007', '0051234007', 'Gita Gutawa', 'P', '2007-04-25', 'Jl. Gatot Subroto No. 34', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(8, '22231008', '0051234008', 'Hadi Wijaya', 'L', '2007-06-30', 'Jl. Diponegoro No. 51', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(9, '22231009', '0051234009', 'Indah Permata', 'P', '2007-08-12', 'Jl. Ahmad Yani No. 11', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(10, '22231010', '0051234010', 'Joko Susilo', 'L', '2007-10-05', 'Jl. Veteran No. 76', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(11, '21221011', '0041234011', 'Kiki Rizky', 'L', '2006-01-20', 'Jl. Pahlawan No. 03', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(12, '21221012', '0041234012', 'Lia Amalia', 'P', '2006-03-18', 'Jl. Cendrawasih No. 22', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(13, '21221013', '0041234013', 'Muhammad Rizky', 'L', '2006-06-07', 'Jl. Kenanga No. 88', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(14, '21221014', '0041234014', 'Nabila Putri', 'P', '2006-09-14', 'Jl. Kartini No. 05', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(15, '21221015', '0041234015', 'Oki Lukman', 'L', '2006-12-01', 'Jl. Gajah Mada No. 40', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(16, '23241016', '0061234016', 'Pratama Arhan', 'L', '2008-02-11', 'Jl. Siliwangi No. 10', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(17, '23241017', '0061234017', 'Qori Sandioriva', 'P', '2008-04-18', 'Jl. Pajajaran No. 25', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(18, '22231018', '0051234018', 'Rizky Febian', 'L', '2007-09-09', 'Jl. Asia Afrika No. 77', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(19, '22231019', '0051234019', 'Siti Badriah', 'P', '2007-11-23', 'Jl. Braga No. 14', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(20, '21221020', '0041234020', 'Taufik Hidayat', 'L', '2006-08-10', 'Jl. Riau No. 88', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(21, '23241021', '0061234021', 'Umar Bin Khattab', 'L', '2008-01-01', 'Jl. Masjid No. 1', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(22, '23241022', '0061234022', 'Vina Garut', 'P', '2008-02-02', 'Jl. Garut No. 2', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(23, '23241023', '0061234023', 'Wawan Febrianto', 'L', '2008-03-03', 'Jl. Stadion No. 3', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(24, '23241024', '0061234024', 'Xenia Indonesia', 'P', '2008-04-04', 'Jl. Otomotif No. 4', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(25, '23241025', '0061234025', 'Yusuf Bachtiar', 'L', '2008-05-05', 'Jl. Persib No. 5', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(26, '22231026', '0051234026', 'Zaskia Gotik', 'P', '2007-06-06', 'Jl. Dangdut No. 6', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(27, '22231027', '0051234027', 'Atep Rizal', 'L', '2007-07-07', 'Jl. Kapten No. 7', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(28, '22231028', '0051234028', 'Bintang Timur', 'L', '2007-08-08', 'Jl. Langit No. 8', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(29, '22231029', '0051234029', 'Cici Paramida', 'P', '2007-09-09', 'Jl. Nada No. 9', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(30, '22231030', '0051234030', 'Deden Natshir', 'L', '2007-10-10', 'Jl. Kiper No. 10', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(31, '21221031', '0041234031', 'Eka Ramdani', 'L', '2006-11-11', 'Jl. Gelandang No. 11', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(32, '21221032', '0041234032', 'Fani Supriyanto', 'P', '2006-12-12', 'Jl. Timnas No. 12', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(33, '21221033', '0041234033', 'Gugun Gondrong', 'L', '2006-01-13', 'Jl. Artis No. 13', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(34, '21221034', '0041234034', 'Hesti Purwadinata', 'P', '2006-02-14', 'Jl. Komedi No. 14', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(35, '21221035', '0041234035', 'Indra Sjafri', 'L', '2006-03-15', 'Jl. Pelatih No. 15', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(36, '23241036', '0061234036', 'Jamal Mirdad', 'L', '2008-04-16', 'Jl. Senior No. 16', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(37, '23241037', '0061234037', 'Kristina', 'P', '2008-05-17', 'Jl. Melodi No. 17', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(38, '22231038', '0051234038', 'Lesti Kejora', 'P', '2007-06-18', 'Jl. Cianjur No. 18', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(39, '22231039', '0051234039', 'Marcell Darwin', 'L', '2007-07-19', 'Jl. Aktor No. 19', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(40, '21221040', '0041234040', 'Naysila Mirdad', 'P', '2006-08-20', 'Jl. Sinetron No. 20', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(41, '23241041', '0061234041', 'Opick Tombo Ati', 'L', '2008-09-21', 'Jl. Religi No. 21', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(42, '23241042', '0061234042', 'Prilly Latuconsina', 'P', '2008-10-22', 'Jl. Film No. 22', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(43, '22231043', '0051234043', 'Qibil Changcuters', 'L', '2007-11-23', 'Jl. Gitaris No. 23', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(44, '22231044', '0051234044', 'Raffi Ahmad', 'L', '2007-12-24', 'Jl. Sultan No. 24', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(45, '21221045', '0041234045', 'Sule Sutisna', 'L', '2006-01-25', 'Jl. Cimahi No. 25', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(46, '23241046', '0061234046', 'Tria Changcuters', 'L', '2008-02-26', 'Jl. Vokalis No. 26', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(47, '23241047', '0061234047', 'Uut Permatasari', 'P', '2008-03-27', 'Jl. Goyang No. 27', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(48, '22231048', '0051234048', 'Vicky Prasetyo', 'L', '2007-04-28', 'Jl. Kontroversi No. 28', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(49, '22231049', '0051234049', 'Wika Salim Dua', 'P', '2007-05-29', 'Jl. Bogor No. 29', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26'),
(50, '21221050', '0041234050', 'Zaskia Adya Mecca', 'P', '2006-06-30', 'Jl. Hijab No. 30', 1, '2026-09-23 03:44:26', '2026-09-23 03:44:26');

-- --------------------------------------------------------

--
-- Table structure for table `t_tahun_ajaran`
--

CREATE TABLE `t_tahun_ajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_tahun_ajaran`
--

INSERT INTO `t_tahun_ajaran` (`id`, `nama`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '2001/2002 Ganjil', '2001-07-16', '2001-12-20', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(2, '2001/2002 Genap', '2002-01-07', '2002-06-21', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(3, '2002/2003 Ganjil', '2002-07-15', '2002-12-20', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(4, '2002/2003 Genap', '2003-01-06', '2003-06-20', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(5, '2003/2004 Ganjil', '2003-07-14', '2003-12-19', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(6, '2003/2004 Genap', '2004-01-05', '2004-06-18', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(7, '2004/2005 Ganjil', '2004-07-12', '2004-12-17', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(8, '2004/2005 Genap', '2005-01-03', '2005-06-17', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(9, '2005/2006 Ganjil', '2005-07-18', '2005-12-23', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(10, '2005/2006 Genap', '2006-01-09', '2006-06-23', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(11, '2006/2007 Ganjil', '2006-07-17', '2006-12-22', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(12, '2006/2007 Genap', '2007-01-08', '2007-06-22', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(13, '2007/2008 Ganjil', '2007-07-16', '2007-12-21', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(14, '2007/2008 Genap', '2008-01-07', '2008-06-20', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(15, '2008/2009 Ganjil', '2008-07-14', '2008-12-19', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(16, '2008/2009 Genap', '2009-01-05', '2009-06-19', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(17, '2009/2010 Ganjil', '2009-07-13', '2009-12-18', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(18, '2009/2010 Genap', '2010-01-04', '2010-06-18', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(19, '2010/2011 Ganjil', '2010-07-12', '2010-12-17', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(20, '2010/2011 Genap', '2011-01-03', '2011-06-17', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(21, '2011/2012 Ganjil', '2011-07-18', '2011-12-23', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(22, '2011/2012 Genap', '2012-01-09', '2012-06-22', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(23, '2012/2013 Ganjil', '2012-07-16', '2012-12-21', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(24, '2012/2013 Genap', '2013-01-07', '2013-06-21', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(25, '2013/2014 Ganjil', '2013-07-15', '2013-12-20', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(26, '2013/2014 Genap', '2014-01-06', '2014-06-20', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(27, '2014/2015 Ganjil', '2014-07-14', '2014-12-19', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(28, '2014/2015 Genap', '2015-01-05', '2015-06-19', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(29, '2015/2016 Ganjil', '2015-07-27', '2015-12-18', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(30, '2015/2016 Genap', '2016-01-04', '2016-06-17', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(31, '2016/2017 Ganjil', '2016-07-18', '2016-12-23', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(32, '2016/2017 Genap', '2017-01-09', '2017-06-23', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(33, '2017/2018 Ganjil', '2017-07-17', '2017-12-22', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(34, '2017/2018 Genap', '2018-01-08', '2018-06-22', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(35, '2018/2019 Ganjil', '2018-07-16', '2018-12-21', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(36, '2018/2019 Genap', '2019-01-07', '2019-06-21', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(37, '2019/2020 Ganjil', '2019-07-15', '2019-12-20', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(38, '2019/2020 Genap', '2020-01-06', '2020-06-19', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(39, '2020/2021 Ganjil', '2020-07-13', '2020-12-18', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(40, '2020/2021 Genap', '2021-01-04', '2021-06-18', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(41, '2021/2022 Ganjil', '2021-07-12', '2021-12-17', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(42, '2021/2022 Genap', '2022-01-03', '2022-06-17', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(43, '2022/2023 Ganjil', '2022-07-18', '2022-12-23', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(44, '2022/2023 Genap', '2023-01-09', '2023-06-23', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(45, '2023/2024 Ganjil', '2023-07-17', '2023-12-22', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(46, '2023/2024 Genap', '2024-01-08', '2024-06-21', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(47, '2024/2025 Ganjil', '2024-07-15', '2024-12-20', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(48, '2024/2025 Genap', '2025-01-06', '2025-06-20', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(49, '2025/2026 Ganjil', '2025-07-14', '2025-12-19', 1, '2026-09-23 03:43:12', '2026-09-23 03:43:12'),
(50, '2025/2026 Genap', '2026-01-05', '2026-06-19', 0, '2026-09-23 03:43:12', '2026-09-23 03:43:12');

-- --------------------------------------------------------

--
-- Table structure for table `t_users`
--

CREATE TABLE `t_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_users`
--

INSERT INTO `t_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin Utama', 'admin@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'admin', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(2, 'Ahmad Dahlan', 'ahmad@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(3, 'Budi Santoso', 'budi@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(4, 'Siti Nurhaliza', 'siti@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(5, 'Dewi Lestari', 'dewi@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(6, 'Eko Prasetyo', 'eko@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(7, 'Fitriani', 'fitriani@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(8, 'Ginanjar', 'ginanjar@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(9, 'Hany Handayani', 'hany@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(10, 'Irfan Hakim', 'irfan@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(11, 'Joko Widodo', 'joko@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(12, 'Kartika Sari', 'kartika@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(13, 'Lukman Hakim', 'lukman@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(14, 'Mina Kusuma', 'mina@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(15, 'Nugroho', 'nugroho@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(16, 'Oktavia', 'oktavia@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(17, 'Puspa Indah', 'puspa@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(18, 'Qomaruddin', 'qomar@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(19, 'Rini Astuti', 'rini@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(20, 'Surya Kencana', 'surya@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(21, 'Tri Wahyuni', 'tri@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(22, 'Utami', 'utami@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(23, 'Vina Pandu', 'vina@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(24, 'Wawan Kurniawan', 'wawan@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(25, 'Xavier', 'xavier@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(26, 'Yuni Shara', 'yuni@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(27, 'Zainal Abidin', 'zainal@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(28, 'Agus Harimurti', 'agus@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(29, 'Bambang Soesatyo', 'bambang@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(30, 'Cinta Laura', 'cinta@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(31, 'Dian Sastro', 'dian@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(32, 'Endank Soekamti', 'endank@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(33, 'Farah Quinn', 'farah@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(34, 'Gading Marten', 'gading@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(35, 'Hamish Daud', 'hamish@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(36, 'Iko Uwais', 'iko@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(37, 'Joe Taslim', 'joe@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(38, 'Kiki Fatmala', 'kikif@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(39, 'Luna Maya', 'luna@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(40, 'Maudy Ayunda', 'maudy@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(41, 'Nicholas Saputra', 'nicholas@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(42, 'Olla Ramlan', 'olla@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(43, 'Pebbi Lie', 'pebbi@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(44, 'Raditya Dika', 'raditya@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(45, 'Sule Prikitiw', 'sule@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(46, 'Titi Kamal', 'titi@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(47, 'Uus Standup', 'uus@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(48, 'Vino G Bastian', 'vino@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(49, 'Wika Salim', 'wika@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43'),
(50, 'Yura Yunita', 'yura@sekolah.sch.id', '2026-09-23 03:41:43', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '', 'guru', '2026-09-23 03:41:43', '2026-09-23 03:41:43');

-- --------------------------------------------------------

--
-- Table structure for table `t_wali_kelas`
--

CREATE TABLE `t_wali_kelas` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_wali_kelas`
--

INSERT INTO `t_wali_kelas` (`id`, `tahun_ajaran_id`, `kelas_id`, `guru_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 49, 1, 1, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(2, 49, 2, 2, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(3, 49, 3, 3, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(4, 49, 4, 4, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(5, 49, 5, 5, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(6, 49, 6, 6, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(7, 49, 7, 7, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(8, 49, 8, 8, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(9, 49, 9, 9, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(10, 49, 10, 10, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(11, 49, 11, 11, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(12, 49, 12, 12, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(13, 49, 13, 13, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(14, 49, 14, 14, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(15, 49, 15, 15, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(16, 49, 16, 16, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(17, 49, 17, 17, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(18, 49, 18, 18, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(19, 49, 19, 19, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(20, 49, 20, 20, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(21, 49, 21, 21, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(22, 49, 22, 22, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(23, 49, 23, 23, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(24, 49, 24, 24, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(25, 49, 25, 25, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(26, 49, 26, 26, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(27, 49, 27, 27, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(28, 49, 28, 28, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(29, 49, 29, 29, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(30, 49, 30, 30, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(31, 49, 31, 31, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(32, 49, 32, 32, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(33, 49, 33, 33, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(34, 49, 34, 34, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(35, 49, 35, 35, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(36, 49, 36, 36, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(37, 49, 37, 37, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(38, 49, 38, 38, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(39, 49, 39, 39, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(40, 49, 40, 40, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(41, 49, 41, 41, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(42, 49, 42, 42, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(43, 49, 43, 43, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(44, 49, 44, 44, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(45, 49, 45, 45, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(46, 49, 46, 46, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(47, 49, 47, 47, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(48, 49, 48, 48, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(49, 49, 49, 49, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38'),
(50, 49, 50, 50, '2025-07-14', '2026-06-20', 1, '2026-09-23 03:44:38', '2026-09-23 03:44:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_guru`
--
ALTER TABLE `t_guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `t_kelas`
--
ALTER TABLE `t_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indexes for table `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`);

--
-- Indexes for table `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `pelanggaran_id` (`pelanggaran_id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indexes for table `t_siswa`
--
ALTER TABLE `t_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_guru`
--
ALTER TABLE `t_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_kelas`
--
ALTER TABLE `t_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_siswa`
--
ALTER TABLE `t_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_users`
--
ALTER TABLE `t_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_guru`
--
ALTER TABLE `t_guru`
  ADD CONSTRAINT `t_guru_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `t_users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD CONSTRAINT `t_kelas_siswa_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD CONSTRAINT `t_pelanggaran_ibfk_1` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_1` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_3` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_4` FOREIGN KEY (`pelanggaran_id`) REFERENCES `t_pelanggaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_5` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_6` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD CONSTRAINT `t_wali_kelas_ibfk_1` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_wali_kelas_ibfk_2` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_wali_kelas_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
