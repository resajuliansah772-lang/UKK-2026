-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Nov 2026 pada 06.24
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

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
-- Struktur dari tabel `t_guru`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_guru`
--

INSERT INTO `t_guru` (`id`, `nip`, `nama`, `email`, `status_aktif`, `user_id`, `created_at`, `updated_at`) VALUES
(601, '198501012010011001', 'Wawan Kurniawan, S.Pd.I', 'wawan.kurniawan@sekolah.sch.id', 1, 52, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(602, '198501022010012002', 'Ai Nuryaidah, S.Pd', 'ai.nuryaidah@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(603, '198501032010012003', 'Maya Permata Endah, S.Pd', 'maya.permata@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(604, '198501042010011004', 'Dody Jaenudin, S.Pd.', 'dody.jaenudin@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(605, '198501052010011005', 'Dedi Kardiman, S.Pd', 'dedi.kardiman@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(606, '198501062010011006', 'Uca Musa Yusenda, S.Pd', 'uca.musa@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(607, '198501072010011007', 'Drs. Ahmad Nur Mukhlis', 'ahmad.nur@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(608, '198501082010011008', 'Drs. Heri', 'drs.heri@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(609, '198501092010011009', 'Asep Bastaman', 'asep.bastaman@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(610, '198501102010011010', 'H. Encep Maemun, S.T.,M.Pd', 'encep.maemun@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(611, '198501112010011011', 'Opik', 'opik@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(612, '198501122010012012', 'Ida Farida, S.Pd', 'ida.farida@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(613, '198501132010012013', 'Idah Mahmudah, S.Pd', 'idah.mahmudah@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(614, '198501142010011014', 'Drs. Muhamad Ali', 'muhamad.ali@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(615, '198501152010011015', 'Helmi Ali Akbar, S.Pd.I', 'helmi.ali@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(616, '198501162010012016', 'Syeni Suswarini, S.Pd', 'syeni.suswarini@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(617, '198501172010012017', 'Wiwid Yulianti, S.Pd', 'wiwid.yulianti@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(618, '198501182010011018', 'Ansor Muhajir, S.T', 'ansor.muhajir@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(619, '198501192010011019', 'Ogi Gaosun Gias, S.Pd.I', 'ogi.gaosun@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(620, '198501202010011020', 'Sandi Mulyana, S.Pd', 'sandi.mulyana@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(621, '198501212010012021', 'Erna Suryani, S.Pd', 'erna.suryani@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(622, '198501222010012022', 'Ai Wahidah, S.Ag', 'ai.wahidah@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(623, '198501232010011023', 'Chandra Aditya Yusup, S.Pd', 'chandra.aditya@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(624, '198501242010011024', 'Arif Kusmawan, S.Pd', 'arif.kusmawan@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(625, '198501252010011025', 'Asep Taufiq Hidayat, S.Kom', 'asep.taufiq@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(626, '198501262010011026', 'Rendy Ichsan Kusumah, S.T', 'rendy.ichsan@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(627, '198501272010011027', 'Feri Rahmawan, S.Pd', 'feri.rahmawan@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(628, '198501282010011028', 'Ari Sandriana, S.Kom', 'ari.sandriana@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(629, '198501292010012029', 'Yaneu Nurdian, S.Pd, M.Pd', 'yaneu.nurdian@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(630, '198501302010011030', 'Ucu Muhammad Khoer N, S.Pd', 'ucu.muhammad@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(631, '198501312010012031', 'Mira Dwi Rahmawati, S.Ag', 'mira.dwi@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(632, '198502012010011032', 'Aldi Maulana, S.Pd', 'aldi.maulana@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(633, '198502022010012033', 'Eli Rosliah, S.Pd', 'eli.rosliah@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(634, '198502032010012034', 'Isni Nur Fitriani, S.Pd', 'isni.nur@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(635, '198502042010012035', 'Aanisah Putri Nur Aini, S.Pd', 'aanisah.putri@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(636, '198502052010012036', 'Yusi Luthfiani, S.Sos.I', 'yusi.luthfiani@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(637, '198502062010012037', 'Lilis Rustandy Mawardi, S.Pd., M.Pd', 'lilis.rustandy@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(638, '198502072010012038', 'Yusrin Noer Sabrina, S.Pd', 'yusrin.noer@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(639, '198502082010012039', 'Senny Indayani, S.Pd', 'senny.indayani@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(640, '198502092010012040', 'Ilma Amalia, S.Pd', 'ilma.amalia@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(641, '198502102010012041', 'Alvira Sofwatunnisa, S.Pd', 'alvira.sofwatunnisa@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(642, '198502112010012042', 'Risna Andriyani, S.Pd', 'risna.andriyani@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(643, '198502122010012043', 'Dra. Tintin Noerhayati', 'tintin.noerhayati@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(644, '198502132010012044', 'Rizkia Fahira, S.Pd', 'rizkia.fahira@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(645, '198502142010011045', 'Frasetio', 'frasetio@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(646, '198502152010012046', 'Ratnaningsih Hatil Aeni, S.Pd.', 'ratnaningsih.hatil@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(647, '198502162010012047', 'Dheny Darajatul Hasani, S.Pd.', 'dheny.darajatul@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(648, '198502172010011048', 'Fahrullah, S.Pd', 'fahrullah@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(649, '198502182010011049', 'Aan Andriana, S.T', 'aan.andriana@sekolah.sch.id', 1, 52, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(650, '198502192010012050', 'Fitri Fauziah, S.T', 'fitri.fauziah@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(651, '198502202010012051', 'Nida Aulia, S.Pd', 'nida.aulia@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(652, '198502212010012052', 'Sri Nurrizki Putri Krisnadi, S.Pd', 'sri.nurrizki@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(653, '198502222010012053', 'Riesy Putri Navia, S.Kom', 'riesy.putri@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(654, '198502232010012054', 'Rurry Febriani Maryadi, S.Pd', 'rurry.febriani@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47'),
(655, '198502242010011055', 'Irvan Rizal, S.Pd', 'irvan.rizal@sekolah.sch.id', 1, 0, '2026-11-09 08:03:47', '2026-11-09 08:03:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kelas`
--

CREATE TABLE `t_kelas` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tingkat` varchar(20) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_kelas`
--

INSERT INTO `t_kelas` (`id`, `nama`, `tingkat`, `jurusan`, `status_aktif`, `created_at`, `updated_at`) VALUES
(51, 'XII RPL 1', 'XII', 'Rekayasa Perangkat Lunak', 1, '2026-11-09 08:06:33', '2026-11-09 08:06:33'),
(52, 'XII RPL 2', 'XII', 'Rekayasa Perangkat Lunak', 1, '2026-11-09 08:06:33', '2026-11-09 08:06:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kelas_siswa`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_kelas_siswa`
--

INSERT INTO `t_kelas_siswa` (`id`, `siswa_id`, `tahun_ajaran_id`, `kelas_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(2, 2, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(3, 3, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(4, 4, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(5, 5, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(6, 6, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(7, 7, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(8, 8, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(9, 9, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(10, 10, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(11, 11, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(12, 12, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(13, 13, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(14, 14, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(15, 15, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(16, 16, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(17, 17, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(18, 18, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(19, 19, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(20, 20, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(21, 21, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(22, 22, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(23, 23, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(24, 24, 51, 51, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(32, 25, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(33, 26, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(34, 27, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(35, 28, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(36, 29, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(37, 30, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(38, 31, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(39, 32, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(40, 33, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(41, 34, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(42, 35, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(43, 36, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(44, 37, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(45, 38, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(46, 39, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(47, 40, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(48, 41, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(49, 42, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(50, 43, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(51, 44, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(52, 45, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(53, 46, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(54, 47, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(55, 48, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(56, 49, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44'),
(57, 50, 51, 52, '2026-07-13', '2027-06-18', 1, '2026-11-10 02:26:44', '2026-11-10 02:26:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran`
--

CREATE TABLE `t_pelanggaran` (
  `id` int(11) NOT NULL,
  `pelanggaran_kategori_id` int(11) DEFAULT NULL,
  `kode` varchar(30) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `poin` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_tindakan` varchar(50) DEFAULT 'Belum Ditindak',
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pelanggaran`
--

INSERT INTO `t_pelanggaran` (`id`, `pelanggaran_kategori_id`, `kode`, `nama`, `poin`, `deskripsi`, `status_tindakan`, `status_aktif`, `created_at`, `updated_at`) VALUES
(51, 52, NULL, 'TERLAMBAT SEKOLAH', 15, 'bensin abis', 'Belum Ditindak', 1, '2026-11-09 08:42:26', '2026-11-09 08:42:26'),
(52, 1, 'P001', 'Terlambat Hadir di Sekolah', 5, 'Datang melewati jam masuk sekolah yang telah ditentukan.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(53, 1, 'P002', 'Terlambat Masuk Kelas Setelah Istirahat', 3, 'Masuk terlambat ke dalam kelas seusai jam istirahat selesai.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(54, 1, 'P003', 'Tidak Masuk Sekolah Tanpa Keterangan (Alpa)', 15, 'Tidak hadir ke sekolah tanpa mengirimkan surat izin atau kabar.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(55, 1, 'P004', 'Membolos Jam Pelajaran', 10, 'Keluar kelas atau meninggalkan lingkungan sekolah saat KBM tanpa izin.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(56, 1, 'P005', 'Keluar Masuk Gerbang Tanpa Izin', 10, 'Keluar atau masuk area sekolah melewati batas pagar secara ilegal.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(57, 2, 'P006', 'Tidak Mengikuti Upacara Bendera', 10, 'Absen atau sengaja menghindari kegiatan upacara hari senin atau hari besar.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(58, 2, 'P007', 'Tidak Mengikuti Kegiatan Keagamaan Wajib', 10, 'Sengaja membolos atau mangkir dari kegiatan keagamaan sekolah.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(59, 3, 'P008', 'Atribut Seragam Tidak Lengkap', 5, 'Tidak memakai atribut kelengkapan sekolah seperti dasi, topi, atau badge.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(60, 3, 'P009', 'Seragam Tidak Sesuai Ketentuan', 5, 'Memakai pakaian seragam yang tidak sesuai model, warna, atau hari.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(61, 3, 'P010', 'Sepatu Tidak Sesuai Aturan', 5, 'Memakai sepatu yang tidak sesuai warna atau jenis yang ditentukan tata tertib.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(62, 3, 'P011', 'Rambut Tidak Sesuai Ketentuan', 5, 'Model atau panjang rambut siswa tidak sesuai standar kerapian sekolah.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(63, 3, 'P012', 'Memakai Perhiasan Berlebihan', 5, 'Menggunakan perhiasan atau aksesoris yang mencolok.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(64, 3, 'P013', 'Kuku Panjang / Memakai Kuteks', 5, 'Memelihara kuku panjang atau menggunakan pewarna kuku di sekolah.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(65, 3, 'P014', 'Berpakaian Olahraga Tidak Sesuai Jadwal', 5, 'Tidak mengenakan pakaian olahraga standar sekolah pada waktunya.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(66, 4, 'P015', 'Membawa Rokok / Vape', 25, 'Membawa, menyimpan, atau merokok/vape di lingkungan sekolah.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(67, 4, 'P016', 'Membawa / Mengonsumsi Minuman Keras', 50, 'Membawa atau mengonsumsi minuman beralkohol di lingkungan sekolah.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(68, 4, 'P017', 'Membawa Senjata Tajam', 50, 'Membawa sajam atau benda berbahaya lain tanpa izin.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(69, 4, 'P018', 'Membawa / Menyebarkan Pornografi', 50, 'Membawa atau menyebarkan media bermuatan pornografi.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(70, 5, 'P019', 'Tidur Saat Jam Pelajaran', 5, 'Tidur di dalam kelas ketika KBM sedang berlangsung.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(71, 5, 'P020', 'Membuat Kegaduhan / Keributan', 10, 'Berteriak atau mengganggu ketenangan kelas lain saat KBM.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(72, 5, 'P021', 'Tidak Mengerjakan Tugas / PR', 5, 'Sengaja tidak mengumpulkan atau mengerjakan tugas dari guru.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(73, 5, 'P022', 'Mengaktifkan HP Saat KBM Tanpa Izin', 10, 'Bermain game atau sosmed saat jam pelajaran tanpa instruksi.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(74, 5, 'P023', 'Tidak Membawa Buku Paket Pelajaran', 5, 'Sengaja tidak membawa buku pegangan pelajaran.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(75, 5, 'P024', 'Mengabaikan Piket Kelas', 5, 'Tidak melaksanakan tugas kebersihan kelas sesuai jadwal.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(76, 5, 'P025', 'Makan / Minum Saat KBM', 5, 'Makan atau minum di dalam kelas ketika guru menerangkan.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(77, 6, 'P026', 'Melakukan Perundungan Verbal', 20, 'Mengejek, mengatai, atau melontarkan kata kasar ke teman.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(78, 6, 'P027', 'Melakukan Perundungan Fisik', 40, 'Melakukan tindakan kekerasan fisik atau memukul siswa lain.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(79, 6, 'P028', 'Berkelahi / Tawuran', 50, 'Terlibat perkelahian antar siswa di dalam/luar sekolah.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(80, 6, 'P029', 'Melawan / Berkata Kasar Kepada Guru', 35, 'Berbicara dengan nada membentak atau melawan instruksi guru.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(81, 6, 'P030', 'Memaksa / Meminta Barang Teman (Pungli)', 25, 'Meminta uang atau barang milik teman secara paksa.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(82, 7, 'P031', 'Merusak Fasilitas Sekolah (Vandalisme)', 30, 'Mencorat-coret dinding atau merusak fasilitas sekolah.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(83, 7, 'P032', 'Pencurian Barang Milik Orang Lain', 40, 'Mengambil barang atau uang milik teman/guru tanpa izin.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(84, 7, 'P033', 'Memalsukan Tanda Tangan / Surat', 20, 'Memalsukan tanda tangan orang tua atau surat izin sekolah.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(85, 8, 'P034', 'Menyontek Saat Ujian', 15, 'Melakukan kecurangan atau melihat catatan saat ulangan/ujian.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(86, 8, 'P035', 'Terlambat Mengumpulkan Tugas', 5, 'Mengumpulkan tugas melewati batas waktu tanpa alasan.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(87, 9, 'P036', 'Membuang Sampah Sembarangan', 5, 'Tidak membuang sampah pada tempat yang disediakan.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(88, 9, 'P037', 'Membiarkan Meja / Laci Kotor', 5, 'Membiarkan laci meja penuh sampah hingga mengotori kelas.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(89, 10, 'P038', 'Menyimpan Kendaraan Sembarangan', 5, 'Memarkirkan motor atau sepeda di luar area parkir resmi.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(90, 10, 'P039', 'Membawa Kendaraan Tanpa SIM/STNK', 15, 'Membawa motor ke sekolah tanpa kelengkapan berkendara.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(91, 11, 'P040', 'Masuk ke Ruangan Terlarang', 15, 'Masuk ke ruang guru atau lab tanpa izin.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(92, 11, 'P041', 'Keluar Lingkungan Sekolah Saat Istirahat', 10, 'Keluar area sekolah tanpa izin resmi pada jam istirahat.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(93, 12, 'P042', 'Nongkrong di Kantin Saat Jam Belajar', 10, 'Berada di kantin ketika jam pelajaran masih berlangsung.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(94, 12, 'P043', 'Tidur di Mushola Saat Jam Pelajaran', 10, 'Berada di tempat ibadah untuk menghindari jam pelajaran.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(95, 13, 'P044', 'Menolak Perintah Pengurus Kelas / OSIS', 5, 'Tidak mengindahkan arahan dari pengurus kelas atau OSIS.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(96, 13, 'P045', 'Melanggar SOP Laboratorium', 15, 'Melakukan tindakan yang melanggar aturan keselamatan lab.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(97, 14, 'P046', 'Mengganggu Siswa Lain Belajar', 5, 'Mengajak ngobrol berlebihan dan mengusik teman.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(98, 14, 'P047', 'Membawa Barang Mewah Berlebihan', 5, 'Membawa barang mahal yang tidak berkaitan dengan KBM.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(99, 15, 'P048', 'Mengabaikan Protokol Kebersihan', 5, 'Tidak ikut serta menjaga kebersihan lingkungan sekolah.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(100, 15, 'P049', 'Mencoret-coret Seragam Sekolah', 10, 'Merusak atau mencoret seragam sendiri/teman di sekolah.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11'),
(101, 15, 'P050', 'Pelanggaran Ketertiban Umum Lainnya', 10, 'Segala bentuk tindakan indisipliner lain yang merugikan.', 'Belum Ditindak', 1, '2026-11-10 04:43:11', '2026-11-10 04:43:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran_kategori`
--

CREATE TABLE `t_pelanggaran_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pelanggaran_kategori`
--

INSERT INTO `t_pelanggaran_kategori` (`id`, `nama`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Kedisiplinan / Kehadiran', 'Pelanggaran terkait keterlambatan hadir dan kehadiran siswa di sekolah.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(2, 'Keagamaan & Upacara', 'Pelanggaran terkait kewajiban kegiatan keagamaan dan upacara bendera.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(3, 'Atribut & Kerapian Seragam', 'Pelanggaran terkait kelengkapan atribut, model, dan standar kerapian seragam.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(4, 'Barang Terlarang & Berbahaya', 'Pelanggaran membawa rokok, vape, miras, sajam, atau konten terlarang.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(5, 'Ketertiban di Kelas / KBM', 'Pelanggaran yang mengganggu proses Kegiatan Belajar Mengajar di dalam kelas.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(6, 'Tindakan Kekerasan / Asusila', 'Pelanggaran berat berupa perundungan, perkelahian, atau perkataan kasar.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(7, 'Perusakan & Pelanggaran Hukum', 'Pelanggaran merusak fasilitas sekolah, pencurian, atau pemalsuan surat.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(8, 'Akademik & Ujian', 'Pelanggaran kecurangan saat ujian atau keterlambatan tugas.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(9, 'Kebersihan Lingkungan', 'Pelanggaran membuang sampah sembarangan atau mengotori ruangan.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(10, 'Kendaraan & Parkir', 'Pelanggaran aturan penyimpanan kendaraan dan kelengkapan berkendara.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(11, 'Area Terlarang', 'Pelanggaran memasuki area sekolah yang tidak diizinkan.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(12, 'Waktu Istirahat / Jam Belajar', 'Pelanggaran nongkrong atau berada di tempat tidak semestinya.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(13, 'Organisasi & Laboratorium', 'Pelanggaran tata tertib lab atau menolak instruksi pengurus/OSIS.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(14, 'Etika & Perilaku Sosial', 'Pelanggaran mengganggu teman atau membawa barang berlebihan.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44'),
(15, 'Ketertiban Umum Lainnya', 'Segala bentuk pelanggaran indisipliner umum lainnya.', 1, '2026-11-10 04:44:44', '2026-11-10 04:44:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggaran_siswa`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_pelanggaran_siswa`
--

INSERT INTO `t_pelanggaran_siswa` (`id`, `tahun_ajaran_id`, `siswa_id`, `nama_siswa`, `kelas_id`, `nama_kelas`, `pelanggaran_id`, `nama_pelanggaran`, `pelanggaran_kategori_id`, `guru_id`, `nama_guru`, `tanggal`, `keterangan`, `poin`, `tindakan`, `status`, `created_at`, `updated_at`) VALUES
(51, 51, 25, 'ADITTIA NUR LANTIP', NULL, '', 51, 'TERLAMBAT SEKOLAH', NULL, 635, 'Aanisah Putri Nur Aini, S.Pd', '2026-11-08', 'bensin abis', 15, '', '', '2026-11-09 08:43:24', '2026-11-09 08:43:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_siswa`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_siswa`
--

INSERT INTO `t_siswa` (`id`, `nis`, `nisn`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '102410520', '0081234501', 'ALFIN RAHADIAN', 'L', '2008-05-12', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(2, '102410521', '0081234502', 'ALISA RAMADHANI', 'P', '2008-08-21', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(3, '102410522', '0081234503', 'ALMA AURA LIVIA', 'P', '2008-03-14', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(4, '102410523', '0081234504', 'ANIS KHOERUNNISA NUR RAMADANI', 'P', '2008-10-05', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(5, '102410524', '0081234505', 'AZMIL AMIRA', 'P', '2008-07-19', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(6, '102410525', '0081234506', 'AZRIL AKBAR FAWJI ABDILLAH', 'L', '2008-01-30', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(7, '102410527', '0081234507', 'ERLANGGA SAPUTRA HIDAYAT', 'L', '2008-11-11', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(8, '102410528', '0081234508', 'HILMA HUMMA TUNNAJAH', 'P', '2008-04-08', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(9, '102410529', '0081234509', 'ILMA NAJYA', 'P', '2008-09-25', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(10, '102410531', '0081234510', 'JULIANDA DHARMA PANGESTU', 'L', '2008-07-07', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(11, '102410532', '0081234511', 'KAYILA NUR FADILAH', 'P', '2008-02-17', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(12, '102410533', '0081234512', 'MOZA DINA NABILLAH', 'P', '2008-12-01', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(13, '102410534', '0081234513', 'MUHAMAD ALFARIZI', 'L', '2008-06-15', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(14, '102410535', '0081234514', 'MUHAMAD FAHRIN ADAM', 'L', '2008-08-09', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(15, '102410536', '0081234515', 'MUHAMMAD ZIDANE MAULIDAN', 'L', '2008-05-20', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(16, '102410537', '0081234516', 'MUHAMMAD ZULFAN NURALFANSYAH', 'L', '2008-10-18', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(17, '102410538', '0081234517', 'NATIYA NUR AZKIYA', 'P', '2008-03-29', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(18, '102410539', '0081234518', 'NOVITA PUSPITASARI', 'P', '2008-11-03', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(19, '102410540', '0081234519', 'NUCKY ANDREAS FEBRIAN', 'L', '2008-02-11', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(20, '102410743', '0081234520', 'RADITYA JETI PRASETYA', 'L', '2008-09-14', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(21, '102410541', '0081234521', 'RANGGA RAMADIYANTO NURHAKIM', 'L', '2008-04-22', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(22, '102410542', '0081234522', 'RISQI MUHAMAD IHWANI', 'L', '2008-01-10', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(23, '102410753', '0081234523', 'SALWA SABILATUL BARKAH', 'P', '2008-06-27', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(24, '102410543', '0081234524', 'TAZKIA ZAHRA', 'P', '2008-08-04', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(25, '102410544', '0081234525', 'ADITTIA NUR LANTIP', 'L', '2008-03-11', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(26, '102410545', '0081234526', 'AGNIA ROSYA NOERILLAH', 'P', '2008-07-24', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(27, '102410546', '0081234527', 'ANISA AMIRULLA', 'P', '2008-11-15', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(28, '102410547', '0081234528', 'ARADEA KANDI', 'P', '2008-02-28', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(29, '102410548', '0081234529', 'ARFA DIESA OKMALELIZA', 'P', '2008-10-09', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(30, '102410549', '0081234530', 'FITRI NUR SYIAMI', 'P', '2008-04-16', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(31, '102410550', '0081234531', 'JUNITA PUTRI NUR RAHMAN', 'P', '2008-06-02', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(32, '102410551', '0081234532', 'MOHAMMAD ATALARIK ALI SYAHBANA', 'L', '2008-09-30', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(33, '102410552', '0081234533', 'MUHAMAD FAHRIL FAHRUROZI', 'L', '2008-01-21', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(34, '102410750', '0081234534', 'MUHAMMAD ADNAN SYAEFUL ISLAMI', 'L', '2008-05-08', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(35, '102410553', '0081234535', 'MUHAMMAD ZAHRU AQILA FIKRI', 'L', '2008-08-17', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(36, '102410554', '0081234536', 'NADIA ZULFA SORAYA', 'P', '2008-12-14', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(37, '102410555', '0081234537', 'NAZRIL ILHAM', 'L', '2008-03-05', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(38, '102410556', '0081234538', 'PUSPITA DEWI', 'P', '2008-07-12', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(39, '102410558', '0081234539', 'RAKHA MUHAMMAD HAYKAL', 'L', '2008-10-23', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(40, '102410559', '0081234540', 'RANI MEILANI', 'P', '2008-05-19', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(41, '102410560', '0081234541', 'REIHAN MUZAKI', 'L', '2008-02-04', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(42, '102410561', '0081234542', 'RESA JULIANSAH', 'L', '2008-07-31', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(43, '102410562', '0081234543', 'RIZKI PERMATA SUGIANTO', 'L', '2008-09-06', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(44, '102410563', '0081234544', 'SAHIRA FIRAJ', 'P', '2008-04-27', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(45, '102410564', '0081234545', 'SENDI MARDIAN', 'L', '2008-01-18', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(46, '102410755', '0081234546', 'SHAHAIDAN NIZZAR', 'L', '2008-06-25', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(47, '102410565', '0081234547', 'SHERLY SATRIANI', 'P', '2008-08-13', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(48, '102410566', '0081234548', 'SOFI NURJANAH', 'P', '2008-11-29', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(49, '102410567', '0081234549', 'SURAIYA SALSABILA AZZAHRA', 'P', '2008-03-01', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50'),
(50, '102410568', '0081234550', 'TONI ANTONIO', 'L', '2008-10-10', 'Kota Tasikmalaya', 1, '2026-11-09 07:29:50', '2026-11-09 07:29:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_tahun_ajaran`
--

CREATE TABLE `t_tahun_ajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_tahun_ajaran`
--

INSERT INTO `t_tahun_ajaran` (`id`, `nama`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(51, '2026-2027', '2026-07-13', '2027-06-18', 1, '2026-11-09 08:12:22', '2026-11-09 08:12:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_users`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_users`
--

INSERT INTO `t_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(51, 'Administator', 'admin@gmail.com', '2026-11-09 06:02:52', '$2y$10$jKTeorvkbJXpZrcOi7iAwuSrs7YWm7yOyZmRXTU4N7.nOtgEacYy2', '', 'admin', '2026-11-09 06:02:52', '2026-11-09 06:02:52'),
(52, 'Aan Andriana, S.T', 'aan.andriana@sekolah.sch.id', '2026-11-09 06:29:46', '$2y$10$WhZZ6jSDUWrxmgXaJshP7OtxzNT1bOUqo2UmjqX3YNFLJHDEkYeEK', '', 'guru', '2026-11-09 06:29:46', '2026-11-09 06:29:46'),
(53, 'Administator', 'admin@gmail.com', '2026-11-09 23:51:51', '$2y$10$fz1fnWLrygjjEiCMJCsMa.bAcYYaM4LRRWsagv8nQ3.bLEJoGrSr.', '', 'admin', '2026-11-09 23:51:51', '2026-11-09 23:51:51'),
(54, 'Administator', 'admin@gmail.com', '2026-11-09 23:52:18', '$2y$10$XMYLzCkrIXcNqzDtl5YYN.KDHNFgpyDtbX9vbA8fC4fR/9yr.W44.', '', 'admin', '2026-11-09 23:52:18', '2026-11-09 23:52:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_wali_kelas`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_wali_kelas`
--

INSERT INTO `t_wali_kelas` (`id`, `tahun_ajaran_id`, `kelas_id`, `guru_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(53, 51, 51, 628, '2026-07-13', '2027-06-18', 1, '2026-11-09 08:20:32', '2026-11-09 08:20:32'),
(54, 51, 52, 632, '2026-07-13', '2027-06-18', 1, '2026-11-09 08:20:32', '2026-11-09 08:20:32');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `t_kelas`
--
ALTER TABLE `t_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indeks untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`);

--
-- Indeks untuk tabel `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_pelanggaran_siswa`
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
-- Indeks untuk tabel `t_siswa`
--
ALTER TABLE `t_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `guru_id` (`guru_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=656;

--
-- AUTO_INCREMENT untuk tabel `t_kelas`
--
ALTER TABLE `t_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `t_siswa`
--
ALTER TABLE `t_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT untuk tabel `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `t_users`
--
ALTER TABLE `t_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_guru`
--
ALTER TABLE `t_guru`
  ADD CONSTRAINT `t_guru_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `t_users` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD CONSTRAINT `t_kelas_siswa_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD CONSTRAINT `t_pelanggaran_ibfk_1` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_1` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_3` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_4` FOREIGN KEY (`pelanggaran_id`) REFERENCES `t_pelanggaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_5` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_6` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
