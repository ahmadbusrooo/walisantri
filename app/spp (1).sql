-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Jan 2025 pada 07.58
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spp`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bebas`
--

CREATE TABLE `bebas` (
  `bebas_id` int(11) NOT NULL,
  `student_student_id` int(11) DEFAULT NULL,
  `payment_payment_id` int(11) DEFAULT NULL,
  `bebas_bill` decimal(10,0) DEFAULT NULL,
  `bebas_total_pay` decimal(10,0) DEFAULT '0',
  `bebas_input_date` timestamp NULL DEFAULT NULL,
  `bebas_last_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bebas`
--

INSERT INTO `bebas` (`bebas_id`, `student_student_id`, `payment_payment_id`, `bebas_bill`, `bebas_total_pay`, `bebas_input_date`, `bebas_last_update`) VALUES
(1, 2, 2, '200000', '24222', '2024-12-31 20:07:32', '2025-01-02 11:31:03'),
(2, 4, 2, '1000000', '1000000', '2024-12-31 22:13:03', '2024-12-31 22:28:29'),
(3, 5, 2, '250000', '250000', '2025-01-01 05:05:37', '2025-01-03 06:45:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bebas_pay`
--

CREATE TABLE `bebas_pay` (
  `bebas_pay_id` int(11) NOT NULL,
  `bebas_bebas_id` int(11) DEFAULT NULL,
  `bebas_pay_number` varchar(100) DEFAULT NULL,
  `bebas_pay_bill` decimal(10,0) DEFAULT NULL,
  `bebas_pay_desc` varchar(100) DEFAULT NULL,
  `user_user_id` int(11) DEFAULT NULL,
  `bebas_pay_input_date` date DEFAULT NULL,
  `bebas_pay_last_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bebas_pay`
--

INSERT INTO `bebas_pay` (`bebas_pay_id`, `bebas_bebas_id`, `bebas_pay_number`, `bebas_pay_bill`, `bebas_pay_desc`, `user_user_id`, `bebas_pay_input_date`, `bebas_pay_last_update`) VALUES
(1, 1, '20250100001', '22222', 'Hari ini', 1, '2025-01-01', '2024-12-31 20:16:01'),
(2, 2, '20250100007', '1000000', 'Hari ini', 1, '2025-01-01', '2024-12-31 22:28:29'),
(3, 1, '20250100014', '2000', 'Hari ini', 1, '2025-01-02', '2025-01-02 11:31:03'),
(4, 3, '20250100019', '250', 'Alhamdulillah', 1, '2025-01-03', '2025-01-03 06:45:01'),
(5, 3, '20250100020', '249750', 'Alhamdulillah', 1, '2025-01-03', '2025-01-03 06:45:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bulan`
--

CREATE TABLE `bulan` (
  `bulan_id` int(11) NOT NULL,
  `student_student_id` int(11) DEFAULT NULL,
  `payment_payment_id` int(11) DEFAULT NULL,
  `month_month_id` int(11) DEFAULT NULL,
  `bulan_bill` decimal(10,0) DEFAULT NULL,
  `bulan_status` tinyint(1) DEFAULT '0',
  `bulan_number_pay` varchar(100) DEFAULT NULL,
  `bulan_date_pay` date DEFAULT NULL,
  `user_user_id` int(11) DEFAULT NULL,
  `bulan_input_date` timestamp NULL DEFAULT NULL,
  `bulan_last_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bulan`
--

INSERT INTO `bulan` (`bulan_id`, `student_student_id`, `payment_payment_id`, `month_month_id`, `bulan_bill`, `bulan_status`, `bulan_number_pay`, `bulan_date_pay`, `user_user_id`, `bulan_input_date`, `bulan_last_update`) VALUES
(1, 2, 1, 1, '10000', 1, '20241200001', '2024-12-12', 1, '2024-12-11 17:27:44', '2024-12-11 23:33:25'),
(2, 2, 1, 2, '10000', 1, '20241200002', '2024-12-12', 1, '2024-12-11 17:27:44', '2024-12-11 23:33:29'),
(3, 2, 1, 3, '10000', 1, '20241200003', '2024-12-12', 1, '2024-12-11 17:27:44', '2024-12-11 23:33:32'),
(4, 2, 1, 4, '10000', 1, '20241200004', '2024-12-12', 1, '2024-12-11 17:27:44', '2024-12-11 23:33:35'),
(5, 2, 1, 5, '10000', 1, '20241200005', '2024-12-18', 1, '2024-12-11 17:27:44', '2024-12-18 08:35:11'),
(6, 2, 1, 6, '10000', 1, '20241200006', '2024-12-18', 1, '2024-12-11 17:27:44', '2024-12-18 08:35:23'),
(7, 2, 1, 7, '10000', 1, '20241200007', '2024-12-25', 1, '2024-12-11 17:27:44', '2024-12-25 02:49:11'),
(8, 2, 1, 8, '10000', 1, '20241200008', '2024-12-25', 1, '2024-12-11 17:27:44', '2024-12-25 02:56:15'),
(9, 2, 1, 9, '10000', 1, '20241200009', '2024-12-31', 1, '2024-12-11 17:27:44', '2024-12-30 22:32:20'),
(10, 2, 1, 10, '10000', 1, '20241200010', '2024-12-31', 1, '2024-12-11 17:27:44', '2024-12-30 23:13:47'),
(11, 2, 1, 11, '10000', 1, '20250100008', '2025-01-01', 1, '2024-12-11 17:27:44', '2025-01-01 14:35:02'),
(12, 2, 1, 12, '10000', 0, NULL, NULL, NULL, '2024-12-11 17:27:44', '2024-12-11 17:27:44'),
(13, 4, 3, 1, '10000', 1, '20241200011', '2024-12-31', 1, '2024-12-30 23:15:04', '2024-12-30 23:33:10'),
(14, 4, 3, 2, '10000', 1, '20241200012', '2024-12-31', 1, '2024-12-30 23:15:04', '2024-12-30 23:33:14'),
(15, 4, 3, 3, '10000', 1, '20241200016', '2024-12-31', 1, '2024-12-30 23:15:04', '2024-12-30 23:41:54'),
(16, 4, 3, 4, '10000', 1, '20241200014', '2024-12-31', 1, '2024-12-30 23:15:04', '2024-12-30 23:33:23'),
(17, 4, 3, 5, '10000', 1, '20241200015', '2024-12-31', 1, '2024-12-30 23:15:04', '2024-12-30 23:36:53'),
(18, 4, 3, 6, '10000', 1, '20241200018', '2024-12-31', 1, '2024-12-30 23:15:04', '2024-12-31 12:29:52'),
(19, 4, 3, 7, '10000', 1, '20241200019', '2024-12-31', 1, '2024-12-30 23:15:04', '2024-12-31 12:29:58'),
(20, 4, 3, 8, '10000', 1, '20241200020', '2024-12-31', 1, '2024-12-30 23:15:04', '2024-12-31 12:30:02'),
(21, 4, 3, 9, '10000', 1, '20241200021', '2024-12-31', 1, '2024-12-30 23:15:04', '2024-12-31 12:30:18'),
(22, 4, 3, 10, '10000', 1, '20241200022', '2024-12-31', 1, '2024-12-30 23:15:04', '2024-12-31 12:30:22'),
(23, 4, 3, 11, '10000', 1, '20241200023', '2024-12-31', 1, '2024-12-30 23:15:04', '2024-12-31 12:30:33'),
(24, 4, 3, 12, '10000', 1, '20241200017', '2024-12-31', 1, '2024-12-30 23:15:04', '2024-12-30 23:42:06'),
(25, 4, 1, 1, '100000', 1, '20250100002', '2025-01-01', 1, '2024-12-31 22:16:30', '2024-12-31 22:16:50'),
(26, 4, 1, 2, '100000', 1, '20250100003', '2025-01-01', 1, '2024-12-31 22:16:30', '2024-12-31 22:28:01'),
(27, 4, 1, 3, '100000', 1, '20250100004', '2025-01-01', 1, '2024-12-31 22:16:30', '2024-12-31 22:28:05'),
(28, 4, 1, 4, '100000', 1, '20250100005', '2025-01-01', 1, '2024-12-31 22:16:30', '2024-12-31 22:28:09'),
(29, 4, 1, 5, '100000', 1, '20250100006', '2025-01-01', 1, '2024-12-31 22:16:30', '2024-12-31 22:28:14'),
(30, 4, 1, 6, '100000', 1, '20250100015', '2025-01-02', 1, '2024-12-31 22:16:30', '2025-01-02 11:37:33'),
(31, 4, 1, 7, '100000', 1, '20250100017', '2025-01-02', 1, '2024-12-31 22:16:30', '2025-01-02 11:47:23'),
(32, 4, 1, 8, '100000', 0, NULL, NULL, NULL, '2024-12-31 22:16:30', '2024-12-31 22:16:30'),
(33, 4, 1, 9, '100000', 0, NULL, NULL, NULL, '2024-12-31 22:16:30', '2024-12-31 22:16:30'),
(34, 4, 1, 10, '100000', 0, NULL, NULL, NULL, '2024-12-31 22:16:30', '2024-12-31 22:16:30'),
(35, 4, 1, 11, '100000', 0, NULL, NULL, NULL, '2024-12-31 22:16:30', '2024-12-31 22:16:30'),
(36, 4, 1, 12, '100000', 1, '20250100016', '2025-01-02', 1, '2024-12-31 22:16:30', '2025-01-02 11:37:43'),
(37, 5, 1, 1, '30000', 1, '20250100009', '2025-01-01', 1, '2025-01-01 05:00:08', '2025-01-01 14:41:03'),
(38, 5, 1, 2, '30000', 1, '20250100010', '2025-01-02', 1, '2025-01-01 05:00:08', '2025-01-02 11:27:38'),
(39, 5, 1, 3, '30000', 1, '20250100011', '2025-01-02', 1, '2025-01-01 05:00:08', '2025-01-02 11:27:43'),
(40, 5, 1, 4, '30000', 1, '20250100012', '2025-01-02', 1, '2025-01-01 05:00:08', '2025-01-02 11:27:51'),
(41, 5, 1, 5, '30000', 1, '20250100018', '2025-01-03', 1, '2025-01-01 05:00:08', '2025-01-03 06:21:37'),
(42, 5, 1, 6, '30000', 1, '20250100021', '2025-01-03', 1, '2025-01-01 05:00:08', '2025-01-03 06:49:35'),
(43, 5, 1, 7, '30000', 1, '20250100022', '2025-01-03', 1, '2025-01-01 05:00:08', '2025-01-03 06:49:37'),
(44, 5, 1, 8, '30000', 1, '20250100023', '2025-01-03', 1, '2025-01-01 05:00:08', '2025-01-03 06:49:47'),
(45, 5, 1, 9, '30000', 0, NULL, NULL, NULL, '2025-01-01 05:00:08', '2025-01-01 05:00:08'),
(46, 5, 1, 10, '30000', 0, NULL, NULL, NULL, '2025-01-01 05:00:08', '2025-01-01 05:00:08'),
(47, 5, 1, 11, '30000', 0, NULL, NULL, NULL, '2025-01-01 05:00:08', '2025-01-01 05:00:08'),
(48, 5, 1, 12, '30000', 0, NULL, NULL, NULL, '2025-01-01 05:00:08', '2025-01-01 05:00:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `class`
--

INSERT INTO `class` (`class_id`, `class_name`) VALUES
(1, 'Ulya I'),
(2, 'Ulya II');

-- --------------------------------------------------------

--
-- Struktur dari tabel `debit`
--

CREATE TABLE `debit` (
  `debit_id` int(11) NOT NULL,
  `debit_date` date DEFAULT NULL,
  `debit_desc` varchar(100) DEFAULT NULL,
  `debit_value` decimal(10,0) DEFAULT NULL,
  `user_user_id` int(11) DEFAULT NULL,
  `debit_input_date` timestamp NULL DEFAULT NULL,
  `debit_last_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `debit`
--

INSERT INTO `debit` (`debit_id`, `debit_date`, `debit_desc`, `debit_value`, `user_user_id`, `debit_input_date`, `debit_last_update`) VALUES
(1, '2025-01-01', 'beli bensin', '90000', 1, '2025-01-01 14:07:16', '2025-01-01 14:07:16'),
(2, '2025-01-01', 'beli kondom', '900000', 1, '2025-01-01 14:07:16', '2025-01-01 14:07:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `health_records`
--

CREATE TABLE `health_records` (
  `health_record_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `kondisi_kesehatan` varchar(255) NOT NULL,
  `tindakan` varchar(255) NOT NULL,
  `catatan` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `health_records`
--

INSERT INTO `health_records` (`health_record_id`, `student_id`, `period_id`, `tanggal`, `kondisi_kesehatan`, `tindakan`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '2025-01-01', 'Sakit Hati', 'Dicabuli', 'Sudah Sembuh', '2025-01-03 01:55:35', '2025-01-03 01:55:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `holiday`
--

CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `year` year(4) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `information`
--

CREATE TABLE `information` (
  `information_id` int(11) NOT NULL,
  `information_title` varchar(100) DEFAULT NULL,
  `information_desc` text,
  `information_img` varchar(255) DEFAULT NULL,
  `information_publish` tinyint(1) DEFAULT '0',
  `user_user_id` int(11) DEFAULT NULL,
  `information_input_date` timestamp NULL DEFAULT NULL,
  `information_last_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `information`
--

INSERT INTO `information` (`information_id`, `information_title`, `information_desc`, `information_img`, `information_publish`, `user_user_id`, `information_input_date`, `information_last_update`) VALUES
(1, 'INFORMASI MASUK PONDOK', '<p><strong>dang bali pondok!!!</strong></p>', NULL, 1, 1, '2024-12-02 17:31:36', '2024-12-02 17:31:48'),
(2, 'Jangan Aneh', '<p>Segera</p>', 'Jangan_Aneh.jpg', 1, 1, '2024-12-31 20:24:58', '2024-12-31 20:24:58'),
(3, 'Bagus', '<p>Semangat</p>', 'Bagus.JPG', 1, 1, '2025-01-03 02:42:41', '2025-01-03 03:14:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kitab`
--

CREATE TABLE `kitab` (
  `kitab_id` int(11) NOT NULL,
  `nama_kitab` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kitab`
--

INSERT INTO `kitab` (`kitab_id`, `nama_kitab`, `created_at`, `updated_at`) VALUES
(2, 'Abu Syuja\'', '2025-01-01 12:13:30', '2025-01-01 12:13:30'),
(3, 'Alfiyyah Ibnu Malik', '2025-01-01 12:13:44', '2025-01-01 12:13:44'),
(4, 'Zubad', '2025-01-01 14:24:53', '2025-01-01 14:24:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kredit`
--

CREATE TABLE `kredit` (
  `kredit_id` int(11) NOT NULL,
  `kredit_date` date DEFAULT NULL,
  `kredit_desc` varchar(100) DEFAULT NULL,
  `kredit_value` decimal(10,0) DEFAULT NULL,
  `user_user_id` int(11) DEFAULT NULL,
  `kredit_input_date` timestamp NULL DEFAULT NULL,
  `kredit_last_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kredit`
--

INSERT INTO `kredit` (`kredit_id`, `kredit_date`, `kredit_desc`, `kredit_value`, `user_user_id`, `kredit_input_date`, `kredit_last_update`) VALUES
(1, '2024-12-12', 'Beli Lampu', '20000', 1, '2024-12-11 23:37:40', '2024-12-11 23:37:40'),
(2, '2024-12-12', 'Beli Sapi', '1000', 1, '2024-12-11 23:37:40', '2024-12-11 23:37:40'),
(3, '2025-01-01', 'masak garam', '900000', 1, '2025-01-01 14:07:40', '2025-01-01 14:07:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `letter`
--

CREATE TABLE `letter` (
  `letter_id` int(11) NOT NULL,
  `letter_number` varchar(100) DEFAULT NULL,
  `letter_month` int(11) DEFAULT NULL,
  `letter_year` year(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `letter`
--

INSERT INTO `letter` (`letter_id`, `letter_number`, `letter_month`, `letter_year`) VALUES
(1, '00001', 12, 2024),
(2, '00002', 12, 2024),
(3, '00003', 12, 2024),
(4, '00004', 12, 2024),
(5, '00005', 12, 2024),
(6, '00006', 12, 2024),
(7, '00007', 12, 2024),
(8, '00008', 12, 2024),
(9, '00009', 12, 2024),
(10, '00010', 12, 2024),
(11, '00011', 12, 2024),
(12, '00012', 12, 2024),
(13, '00013', 12, 2024),
(14, '00014', 12, 2024),
(15, '00015', 12, 2024),
(16, '00016', 12, 2024),
(17, '00017', 12, 2024),
(18, '00018', 12, 2024),
(19, '00019', 12, 2024),
(20, '00020', 12, 2024),
(21, '00021', 12, 2024),
(22, '00022', 12, 2024),
(23, '00023', 12, 2024),
(24, '00001', 1, 2025),
(25, '00002', 1, 2025),
(26, '00003', 1, 2025),
(27, '00004', 1, 2025),
(28, '00005', 1, 2025),
(29, '00006', 1, 2025),
(30, '00007', 1, 2025),
(31, '00008', 1, 2025),
(32, '00009', 1, 2025),
(33, '00010', 1, 2025),
(34, '00011', 1, 2025),
(35, '00012', 1, 2025),
(36, '00013', 1, 2025),
(37, '00014', 1, 2025),
(38, '00015', 1, 2025),
(39, '00016', 1, 2025),
(40, '00017', 1, 2025),
(41, '00018', 1, 2025),
(42, '00019', 1, 2025),
(43, '00020', 1, 2025),
(44, '00021', 1, 2025),
(45, '00022', 1, 2025),
(46, '00023', 1, 2025);

-- --------------------------------------------------------

--
-- Struktur dari tabel `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `log_date` timestamp NULL DEFAULT NULL,
  `log_action` varchar(45) DEFAULT NULL,
  `log_module` varchar(45) DEFAULT NULL,
  `log_info` text,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `logs`
--

INSERT INTO `logs` (`log_id`, `log_date`, `log_action`, `log_module`, `log_info`, `user_id`) VALUES
(1, '2020-06-23 06:13:54', 'Tambah', 'Tahun Ajaran', 'ID:null;Title:2020/2021', NULL),
(2, '2024-12-02 17:28:47', 'Tambah', 'Student', 'ID:1;Name:pp almaruf', 1),
(3, '2024-12-02 17:29:11', 'Sunting', 'Student', 'ID:1;Name:pp almaruf', 1),
(4, '2024-12-02 17:31:36', 'Tambah', 'Pengeluaran', 'ID:null;Title:<p xss=removed><strong>dang bali pondok!!!</strong></p>', NULL),
(5, '2024-12-02 17:31:48', 'Sunting', 'Pengeluaran', 'ID:null;Title:<p><strong>dang bali pondok!!!</strong></p>', NULL),
(6, '2024-12-11 17:25:51', 'Tambah', 'Student', 'ID:2;Name:pp almaruf', 1),
(7, '2024-12-11 17:26:12', 'Sunting', 'Student', 'ID:2;Name:pp almaruf', 1),
(8, '2024-12-11 17:27:10', 'Tambah', 'Jenis Pembayaran', 'ID:null;Title:', NULL),
(9, '2024-12-11 18:01:54', 'Sunting', 'Tahun Ajaran', 'ID:null;Title:2024/2025', NULL),
(10, '2024-12-11 23:35:56', 'Tambah', 'Jenis Pembayaran', 'ID:null;Title:', NULL),
(11, '2024-12-11 23:49:33', 'Edit', 'Profile', 'ID:1;Name:Administrator', 1),
(12, '2024-12-30 23:02:50', 'Tambah', 'Student', 'ID:4;Name:Revano', 1),
(13, '2024-12-30 23:03:04', 'Sunting', 'Student', 'ID:4;Name:Revano', 1),
(14, '2024-12-30 23:14:39', 'Tambah', 'Jenis Pembayaran', 'ID:null;Title:', NULL),
(15, '2024-12-31 20:24:58', 'Tambah', 'Pengeluaran', 'ID:null;Title:<p>Segera</p>', NULL),
(16, '2025-01-01 02:54:38', 'Sunting', 'Student', 'ID:4;Name:Revano', 1),
(17, '2025-01-01 02:56:02', 'Sunting', 'Student', 'ID:2;Name:Aisyah', 1),
(18, '2025-01-01 04:59:25', 'Tambah', 'Student', 'ID:5;Name:Revano Jaka', 1),
(19, '2025-01-01 05:01:47', 'Sunting', 'Student', 'ID:5;Name:Revano Jaka', 1),
(20, '2025-01-01 05:03:06', 'Sunting', 'Student', 'ID:5;Name:Revano Jaka', 1),
(21, '2025-01-01 14:08:53', 'Edit', 'Profile', 'ID:1;Name:Administrator', 1),
(22, '2025-01-01 14:34:36', 'Tambah', 'Tahun Ajaran', 'ID:null;Title:2024/2025', NULL),
(23, '2025-01-01 14:37:15', 'Hapus', 'Tahun Ajaran', 'ID:;Title:', 1),
(24, '2025-01-01 14:37:21', 'Tambah', 'Tahun Ajaran', 'ID:null;Title:2025/2026', NULL),
(25, '2025-01-01 14:38:33', 'Hapus', 'Tahun Ajaran', 'ID:;Title:', 1),
(26, '2025-01-01 21:10:41', 'Sunting', 'Student', 'ID:5;Name:Revano Jaka', 1),
(27, '2025-01-01 21:13:16', 'Sunting', 'Student', 'ID:4;Name:Revano', 1),
(28, '2025-01-01 21:14:20', 'Edit', 'Profile', 'ID:1;Name:Administrator', 1),
(29, '2025-01-02 11:39:08', 'Sunting', 'Student', 'ID:4;Name:Revano', 1),
(30, '2025-01-02 11:40:20', 'Sunting', 'Student', 'ID:4;Name:Revano', 1),
(31, '2025-01-03 02:42:41', 'Tambah', 'Pengeluaran', 'ID:null;Title:<p>Semangat</p>', NULL),
(32, '2025-01-03 03:14:55', 'Sunting', 'Pengeluaran', 'ID:null;Title:<p>Semangat</p>', NULL),
(33, '2025-01-03 04:19:25', 'Sunting', 'Student', 'ID:5;Name:Revano Jaka', 1),
(34, '2025-01-03 05:08:02', 'Sunting', 'Student', 'ID:5;Name:Revano Jaka', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_trx`
--

CREATE TABLE `log_trx` (
  `log_trx_id` int(11) NOT NULL,
  `student_student_id` int(11) DEFAULT NULL,
  `bulan_bulan_id` int(11) DEFAULT NULL,
  `bebas_pay_bebas_pay_id` int(11) DEFAULT NULL,
  `log_trx_input_date` timestamp NULL DEFAULT NULL,
  `log_trx_last_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `log_trx`
--

INSERT INTO `log_trx` (`log_trx_id`, `student_student_id`, `bulan_bulan_id`, `bebas_pay_bebas_pay_id`, `log_trx_input_date`, `log_trx_last_update`) VALUES
(1, 2, 1, NULL, '2024-12-11 23:33:25', '2024-12-11 23:33:25'),
(2, 2, 2, NULL, '2024-12-11 23:33:29', '2024-12-11 23:33:29'),
(3, 2, 3, NULL, '2024-12-11 23:33:32', '2024-12-11 23:33:32'),
(4, 2, 4, NULL, '2024-12-11 23:33:35', '2024-12-11 23:33:35'),
(5, 2, 5, NULL, '2024-12-18 08:35:11', '2024-12-18 08:35:11'),
(6, 2, 6, NULL, '2024-12-18 08:35:23', '2024-12-18 08:35:23'),
(7, 2, 7, NULL, '2024-12-25 02:49:11', '2024-12-25 02:49:11'),
(8, 2, 8, NULL, '2024-12-25 02:56:15', '2024-12-25 02:56:15'),
(9, 2, 9, NULL, '2024-12-30 22:32:20', '2024-12-30 22:32:20'),
(10, 2, 10, NULL, '2024-12-30 23:13:47', '2024-12-30 23:13:47'),
(11, 4, 13, NULL, '2024-12-30 23:33:10', '2024-12-30 23:33:10'),
(12, 4, 14, NULL, '2024-12-30 23:33:14', '2024-12-30 23:33:14'),
(14, 4, 16, NULL, '2024-12-30 23:33:23', '2024-12-30 23:33:23'),
(15, 4, 17, NULL, '2024-12-30 23:36:53', '2024-12-30 23:36:53'),
(16, 4, 15, NULL, '2024-12-30 23:41:54', '2024-12-30 23:41:54'),
(17, 4, 24, NULL, '2024-12-30 23:42:06', '2024-12-30 23:42:06'),
(18, 4, 18, NULL, '2024-12-31 12:29:52', '2024-12-31 12:29:52'),
(19, 4, 19, NULL, '2024-12-31 12:29:58', '2024-12-31 12:29:58'),
(20, 4, 20, NULL, '2024-12-31 12:30:02', '2024-12-31 12:30:02'),
(21, 4, 21, NULL, '2024-12-31 12:30:18', '2024-12-31 12:30:18'),
(22, 4, 22, NULL, '2024-12-31 12:30:22', '2024-12-31 12:30:22'),
(23, 4, 23, NULL, '2024-12-31 12:30:33', '2024-12-31 12:30:33'),
(24, 2, NULL, 1, '2024-12-31 20:16:01', '2024-12-31 20:16:01'),
(25, 4, 25, NULL, '2024-12-31 22:16:50', '2024-12-31 22:16:50'),
(26, 4, 26, NULL, '2024-12-31 22:28:01', '2024-12-31 22:28:01'),
(27, 4, 27, NULL, '2024-12-31 22:28:05', '2024-12-31 22:28:05'),
(28, 4, 28, NULL, '2024-12-31 22:28:09', '2024-12-31 22:28:09'),
(29, 4, 29, NULL, '2024-12-31 22:28:14', '2024-12-31 22:28:14'),
(30, 4, NULL, 2, '2024-12-31 22:28:29', '2024-12-31 22:28:29'),
(31, 2, 11, NULL, '2025-01-01 14:35:02', '2025-01-01 14:35:02'),
(32, 5, 37, NULL, '2025-01-01 14:41:03', '2025-01-01 14:41:03'),
(33, 5, 38, NULL, '2025-01-02 11:27:38', '2025-01-02 11:27:38'),
(34, 5, 39, NULL, '2025-01-02 11:27:43', '2025-01-02 11:27:43'),
(35, 5, 40, NULL, '2025-01-02 11:27:51', '2025-01-02 11:27:51'),
(36, 2, NULL, 3, '2025-01-02 11:31:03', '2025-01-02 11:31:03'),
(37, 4, 30, NULL, '2025-01-02 11:37:33', '2025-01-02 11:37:33'),
(38, 4, 36, NULL, '2025-01-02 11:37:43', '2025-01-02 11:37:43'),
(39, 4, 31, NULL, '2025-01-02 11:47:23', '2025-01-02 11:47:23'),
(40, 5, 41, NULL, '2025-01-03 06:21:37', '2025-01-03 06:21:37'),
(41, 5, NULL, 4, '2025-01-03 06:45:01', '2025-01-03 06:45:01'),
(42, 5, NULL, 5, '2025-01-03 06:45:25', '2025-01-03 06:45:25'),
(43, 5, 42, NULL, '2025-01-03 06:49:35', '2025-01-03 06:49:35'),
(44, 5, 43, NULL, '2025-01-03 06:49:37', '2025-01-03 06:49:37'),
(45, 5, 44, NULL, '2025-01-03 06:49:47', '2025-01-03 06:49:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `majors`
--

CREATE TABLE `majors` (
  `majors_id` int(11) NOT NULL,
  `majors_name` varchar(100) DEFAULT NULL,
  `majors_short_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `majors`
--

INSERT INTO `majors` (`majors_id`, `majors_name`, `majors_short_name`) VALUES
(1, 'Rami Malik', 'E2'),
(2, 'Roudlotul Ma\'wa', 'E2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `month`
--

CREATE TABLE `month` (
  `month_id` int(11) NOT NULL,
  `month_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `month`
--

INSERT INTO `month` (`month_id`, `month_name`) VALUES
(1, 'Juli'),
(2, 'Agustus'),
(3, 'September'),
(4, 'Oktober'),
(5, 'November'),
(6, 'Desember'),
(7, 'Januari'),
(8, 'Februari'),
(9, 'Maret'),
(10, 'April'),
(11, 'Mei'),
(12, 'Juni');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nadzhaman`
--

CREATE TABLE `nadzhaman` (
  `nadzhaman_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `kitab_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_hafalan` int(11) NOT NULL,
  `keterangan` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `nadzhaman`
--

INSERT INTO `nadzhaman` (`nadzhaman_id`, `student_id`, `kitab_id`, `tanggal`, `jumlah_hafalan`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, 4, 3, '2025-01-01', 4, 'Baik', '2025-01-01 12:22:10', '2025-01-01 12:22:10'),
(6, 2, 3, '2222-12-22', 12, '', '2025-01-01 12:42:46', '2025-01-01 12:42:46'),
(7, 1, 2, '2025-01-01', 1000, 'Lancar Jaya\r\n', '2025-01-01 12:49:30', '2025-01-01 12:49:30'),
(9, 5, 3, '2025-01-01', 10, 'Blas\r\n', '2025-01-01 14:23:02', '2025-01-01 14:23:02'),
(10, 1, 3, '2025-01-01', 100, 'Baik', '2025-01-02 11:19:46', '2025-01-02 11:19:46'),
(11, 5, 3, '2025-01-01', 1000, 'Buruk', '2025-01-02 11:20:07', '2025-01-02 11:20:07'),
(12, 5, 2, '2025-01-01', 20, 'Buruk', '2025-01-02 11:21:58', '2025-01-02 11:21:58'),
(13, 5, 3, '2025-01-01', 10, 'Baik', '2025-01-02 11:48:33', '2025-01-02 11:48:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `payment_type` enum('BEBAS','BULAN') DEFAULT NULL,
  `period_period_id` int(11) DEFAULT NULL,
  `pos_pos_id` int(11) DEFAULT NULL,
  `payment_input_date` timestamp NULL DEFAULT NULL,
  `payment_last_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `payment`
--

INSERT INTO `payment` (`payment_id`, `payment_type`, `period_period_id`, `pos_pos_id`, `payment_input_date`, `payment_last_update`) VALUES
(1, 'BULAN', 1, 1, '2024-12-11 17:27:10', '2024-12-11 17:27:10'),
(2, 'BEBAS', 1, 2, '2024-12-11 23:35:56', '2024-12-11 23:35:56'),
(3, 'BULAN', 1, 3, '2024-12-30 23:14:39', '2024-12-30 23:14:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggaran`
--

CREATE TABLE `pelanggaran` (
  `pelanggaran_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `poin` int(11) NOT NULL,
  `pelanggaran` varchar(255) NOT NULL,
  `tindakan` varchar(255) NOT NULL,
  `catatan` text,
  `pelanggaran_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pelanggaran_updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pelanggaran`
--

INSERT INTO `pelanggaran` (`pelanggaran_id`, `student_id`, `period_id`, `class_id`, `tanggal`, `poin`, `pelanggaran`, `tindakan`, `catatan`, `pelanggaran_created_at`, `pelanggaran_updated_at`) VALUES
(15, 2, 1, 1, '2025-01-01', 100, 'Ngocok', 'dipukul', 'Jangan Diulangi', '2025-01-01 02:49:38', '2025-01-01 02:49:38'),
(16, 2, 1, 1, '2025-01-01', 12, 'makan bakso', 'dipukul', 'jangan Diulangi', '2025-01-01 03:45:17', '2025-01-01 03:45:17'),
(17, 4, 1, 1, '2025-01-01', 12, 'Makan', 'dipukul', 'Jangan Diulangi', '2025-01-01 03:49:41', '2025-01-01 03:49:41'),
(18, 4, 1, 1, '2024-12-31', 100, 'Ngocok', 'dipukul', 'Jangan Diualangi', '2025-01-01 04:31:35', '2025-01-01 04:31:35'),
(19, 5, 1, 2, '2024-12-30', 12, 'Makan', 'dipukul', 'Jangan diulangi', '2025-01-01 05:00:49', '2025-01-01 05:00:49'),
(20, 5, 1, 2, '2025-01-01', 10000, 'Ngentot', 'Dicambuk', 'Jangan Ya Dek', '2025-01-01 06:36:46', '2025-01-01 06:36:46'),
(21, 5, 1, 2, '2025-01-01', 90, 'Ngoding', 'Dibelikan Laptop', 'Jangan Diulangi', '2025-01-03 00:43:03', '2025-01-03 00:43:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `period`
--

CREATE TABLE `period` (
  `period_id` int(11) NOT NULL,
  `period_start` year(4) DEFAULT NULL,
  `period_end` year(4) DEFAULT NULL,
  `period_status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `period`
--

INSERT INTO `period` (`period_id`, `period_start`, `period_end`, `period_status`) VALUES
(1, 2024, 2025, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pos`
--

CREATE TABLE `pos` (
  `pos_id` int(11) NOT NULL,
  `pos_name` varchar(100) DEFAULT NULL,
  `pos_description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pos`
--

INSERT INTO `pos` (`pos_id`, `pos_name`, `pos_description`) VALUES
(1, 'SPP', 'Bulanan'),
(2, 'Pembayaran Maulid', 'Iuran Pesantren'),
(3, 'Pelanggaran', 'Kesalahan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `setting`
--

CREATE TABLE `setting` (
  `setting_id` int(11) NOT NULL,
  `setting_name` varchar(255) DEFAULT NULL,
  `setting_value` text,
  `setting_last_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `setting`
--

INSERT INTO `setting` (`setting_id`, `setting_name`, `setting_value`, `setting_last_update`) VALUES
(1, 'setting_school', 'Pondok Pesantren Al-Ma\'ruf', '2020-06-23 05:07:07'),
(2, 'setting_address', 'Bandungsari', '2020-06-23 05:07:07'),
(3, 'setting_phone', '082235968001', '2020-06-23 05:07:07'),
(4, 'setting_district', 'Ngaringan', '2020-06-23 05:07:07'),
(5, 'setting_city', 'Grobogan', '2020-06-23 05:07:07'),
(6, 'setting_logo', 'Pondok_Pesantren_Al-Maruf.png', '2020-06-23 05:07:07'),
(7, 'setting_level', 'senior', '2020-06-23 05:07:07'),
(8, 'setting_wa_gateway_url', 'we4214r', '2020-06-23 05:07:07'),
(9, 'setting_wa_api_key', '43434', '2020-06-23 05:07:07'),
(10, 'setting_sms', 'Y', '2020-06-23 05:07:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `student_nis` varchar(45) DEFAULT NULL,
  `student_nisn` varchar(45) DEFAULT NULL,
  `student_password` varchar(100) DEFAULT NULL,
  `student_full_name` varchar(255) DEFAULT NULL,
  `student_gender` enum('L','P') DEFAULT NULL,
  `student_born_place` varchar(45) DEFAULT NULL,
  `student_born_date` date DEFAULT NULL,
  `student_img` varchar(255) DEFAULT NULL,
  `student_phone` varchar(45) DEFAULT NULL,
  `student_hobby` varchar(100) DEFAULT NULL,
  `student_address` text,
  `student_name_of_mother` varchar(255) DEFAULT NULL,
  `student_name_of_father` varchar(255) DEFAULT NULL,
  `student_parent_phone` varchar(45) DEFAULT NULL,
  `class_class_id` int(11) DEFAULT NULL,
  `majors_majors_id` int(11) DEFAULT NULL,
  `student_status` tinyint(1) DEFAULT '1',
  `student_input_date` timestamp NULL DEFAULT NULL,
  `student_last_update` timestamp NULL DEFAULT NULL,
  `student_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `student`
--

INSERT INTO `student` (`student_id`, `student_nis`, `student_nisn`, `student_password`, `student_full_name`, `student_gender`, `student_born_place`, `student_born_date`, `student_img`, `student_phone`, `student_hobby`, `student_address`, `student_name_of_mother`, `student_name_of_father`, `student_parent_phone`, `class_class_id`, `majors_majors_id`, `student_status`, `student_input_date`, `student_last_update`, `student_token`) VALUES
(1, '23121213', '200206', '7c222fb2927d828af22f592134e8932480637c0d', 'pp almaruf', 'L', 'Semarang', '2024-12-01', 'pp_almaruf.jpg', '085327784138', 'Mancing', 'Jln. KH. Ma\'ruf', 'Samijah', 'Samin', '083128563527', 2, NULL, 1, '2024-12-02 17:28:47', '2025-01-01 14:39:16', NULL),
(2, '200206', '313414142154253425', '7c222fb2927d828af22f592134e8932480637c0d', 'Aisyah', 'P', 'Semarang', '2024-04-01', NULL, '085327784138', 'Mancing', 'Jln. KH. Ma\'ruf', 'Samijah', 'Samin', '6282235968001', 2, 1, 1, '2024-12-11 17:25:51', '2025-01-01 14:39:16', NULL),
(4, '224232324', '42425t4563535', '7c222fb2927d828af22f592134e8932480637c0d', 'Revano', 'L', '16-KAB. BLORA', '2024-12-16', 'Revano.png', '082235968001', '', 'Jalan Sambeng', 'Aisyah', 'Ayah Ivan Jenner', '082235968001', 2, 1, 0, '2024-12-30 23:02:50', '2025-01-02 11:40:20', 'N2Tjda578MgocGKBYXw4U9une6Q13tkfmbsryHlS'),
(5, '12345678', '09876545678987', '7c222fb2927d828af22f592134e8932480637c0d', 'Revano Jaka', 'L', '16-KAB. BLORA', '2004-10-20', 'Revano_Jaka.jpeg', '6282235968001', 'Memancing', 'Jalan Sambeng', 'Aisyah', 'Samin', '6283878168044', 1, 2, 1, '2025-01-01 04:59:25', '2025-01-03 05:08:02', 'im8BEwqkSuyNJdQteRvxTfCZbloOAzn7Mh201FsX');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(45) DEFAULT NULL,
  `user_password` varchar(45) DEFAULT NULL,
  `user_full_name` varchar(255) DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_description` text,
  `user_role_role_id` int(11) DEFAULT NULL,
  `user_is_deleted` tinyint(1) DEFAULT '0',
  `user_input_date` timestamp NULL DEFAULT NULL,
  `user_last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_password`, `user_full_name`, `user_image`, `user_description`, `user_role_role_id`, `user_is_deleted`, `user_input_date`, `user_last_update`) VALUES
(1, 'admin@admin.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrator', 'Administrator3.png', 'Administrator', 1, 0, '2018-01-16 03:19:33', '2025-01-01 21:14:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_roles`
--

CREATE TABLE `user_roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_roles`
--

INSERT INTO `user_roles` (`role_id`, `role_name`) VALUES
(1, 'SUPERUSER'),
(2, 'USER');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bebas`
--
ALTER TABLE `bebas`
  ADD PRIMARY KEY (`bebas_id`),
  ADD KEY `fk_bebas_payment1_idx` (`payment_payment_id`),
  ADD KEY `fk_bebas_student1_idx` (`student_student_id`);

--
-- Indeks untuk tabel `bebas_pay`
--
ALTER TABLE `bebas_pay`
  ADD PRIMARY KEY (`bebas_pay_id`),
  ADD KEY `fk_bebas_pay_bebas1_idx` (`bebas_bebas_id`),
  ADD KEY `fk_bebas_pay_users1_idx` (`user_user_id`);

--
-- Indeks untuk tabel `bulan`
--
ALTER TABLE `bulan`
  ADD PRIMARY KEY (`bulan_id`),
  ADD KEY `fk_bulan_payment1_idx` (`payment_payment_id`),
  ADD KEY `fk_bulan_month1_idx` (`month_month_id`),
  ADD KEY `fk_bulan_student1_idx` (`student_student_id`),
  ADD KEY `fk_bulan_users1_idx` (`user_user_id`);

--
-- Indeks untuk tabel `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indeks untuk tabel `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indeks untuk tabel `debit`
--
ALTER TABLE `debit`
  ADD PRIMARY KEY (`debit_id`),
  ADD KEY `fk_jurnal_debit_users1_idx` (`user_user_id`);

--
-- Indeks untuk tabel `health_records`
--
ALTER TABLE `health_records`
  ADD PRIMARY KEY (`health_record_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `period_id` (`period_id`);

--
-- Indeks untuk tabel `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`information_id`),
  ADD KEY `fk_information_users1_idx` (`user_user_id`);

--
-- Indeks untuk tabel `kitab`
--
ALTER TABLE `kitab`
  ADD PRIMARY KEY (`kitab_id`);

--
-- Indeks untuk tabel `kredit`
--
ALTER TABLE `kredit`
  ADD PRIMARY KEY (`kredit_id`),
  ADD KEY `fk_jurnal_kredit_users1_idx` (`user_user_id`);

--
-- Indeks untuk tabel `letter`
--
ALTER TABLE `letter`
  ADD PRIMARY KEY (`letter_id`);

--
-- Indeks untuk tabel `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_g_activity_log_g_user1_idx` (`user_id`);

--
-- Indeks untuk tabel `log_trx`
--
ALTER TABLE `log_trx`
  ADD PRIMARY KEY (`log_trx_id`),
  ADD KEY `fk_log_trx_bebas_pay1_idx` (`bebas_pay_bebas_pay_id`),
  ADD KEY `fk_log_trx_bulan1_idx` (`bulan_bulan_id`),
  ADD KEY `fk_log_trx_student1_idx` (`student_student_id`);

--
-- Indeks untuk tabel `majors`
--
ALTER TABLE `majors`
  ADD PRIMARY KEY (`majors_id`);

--
-- Indeks untuk tabel `month`
--
ALTER TABLE `month`
  ADD PRIMARY KEY (`month_id`);

--
-- Indeks untuk tabel `nadzhaman`
--
ALTER TABLE `nadzhaman`
  ADD PRIMARY KEY (`nadzhaman_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `kitab_id` (`kitab_id`);

--
-- Indeks untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_payment_pos1_idx` (`pos_pos_id`),
  ADD KEY `fk_payment_period1_idx` (`period_period_id`);

--
-- Indeks untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD PRIMARY KEY (`pelanggaran_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `period_id` (`period_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indeks untuk tabel `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`period_id`);

--
-- Indeks untuk tabel `pos`
--
ALTER TABLE `pos`
  ADD PRIMARY KEY (`pos_id`);

--
-- Indeks untuk tabel `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indeks untuk tabel `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `fk_student_class1_idx` (`class_class_id`),
  ADD KEY `fk_student_majors1_idx` (`majors_majors_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_user_user_role1_idx` (`user_role_role_id`);

--
-- Indeks untuk tabel `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bebas`
--
ALTER TABLE `bebas`
  MODIFY `bebas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `bebas_pay`
--
ALTER TABLE `bebas_pay`
  MODIFY `bebas_pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `bulan`
--
ALTER TABLE `bulan`
  MODIFY `bulan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `debit`
--
ALTER TABLE `debit`
  MODIFY `debit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `health_records`
--
ALTER TABLE `health_records`
  MODIFY `health_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `information`
--
ALTER TABLE `information`
  MODIFY `information_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kitab`
--
ALTER TABLE `kitab`
  MODIFY `kitab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kredit`
--
ALTER TABLE `kredit`
  MODIFY `kredit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `letter`
--
ALTER TABLE `letter`
  MODIFY `letter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `log_trx`
--
ALTER TABLE `log_trx`
  MODIFY `log_trx_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `majors`
--
ALTER TABLE `majors`
  MODIFY `majors_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `month`
--
ALTER TABLE `month`
  MODIFY `month_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `nadzhaman`
--
ALTER TABLE `nadzhaman`
  MODIFY `nadzhaman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  MODIFY `pelanggaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `period`
--
ALTER TABLE `period`
  MODIFY `period_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pos`
--
ALTER TABLE `pos`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `setting`
--
ALTER TABLE `setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bebas`
--
ALTER TABLE `bebas`
  ADD CONSTRAINT `fk_bebas_payment1` FOREIGN KEY (`payment_payment_id`) REFERENCES `payment` (`payment_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_bebas_student1` FOREIGN KEY (`student_student_id`) REFERENCES `student` (`student_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `bebas_pay`
--
ALTER TABLE `bebas_pay`
  ADD CONSTRAINT `fk_bebas_pay_bebas1` FOREIGN KEY (`bebas_bebas_id`) REFERENCES `bebas` (`bebas_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_bebas_pay_users1` FOREIGN KEY (`user_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `bulan`
--
ALTER TABLE `bulan`
  ADD CONSTRAINT `fk_bulan_month1` FOREIGN KEY (`month_month_id`) REFERENCES `month` (`month_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bulan_payment1` FOREIGN KEY (`payment_payment_id`) REFERENCES `payment` (`payment_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_bulan_student1` FOREIGN KEY (`student_student_id`) REFERENCES `student` (`student_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_bulan_users1` FOREIGN KEY (`user_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `debit`
--
ALTER TABLE `debit`
  ADD CONSTRAINT `fk_jurnal_debit_users1` FOREIGN KEY (`user_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `health_records`
--
ALTER TABLE `health_records`
  ADD CONSTRAINT `health_records_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `health_records_ibfk_2` FOREIGN KEY (`period_id`) REFERENCES `period` (`period_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `information`
--
ALTER TABLE `information`
  ADD CONSTRAINT `fk_information_users1` FOREIGN KEY (`user_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `kredit`
--
ALTER TABLE `kredit`
  ADD CONSTRAINT `fk_jurnal_kredit_users1` FOREIGN KEY (`user_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `fk_g_activity_log_g_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `log_trx`
--
ALTER TABLE `log_trx`
  ADD CONSTRAINT `fk_log_trx_bebas_pay1` FOREIGN KEY (`bebas_pay_bebas_pay_id`) REFERENCES `bebas_pay` (`bebas_pay_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_log_trx_bulan1` FOREIGN KEY (`bulan_bulan_id`) REFERENCES `bulan` (`bulan_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_log_trx_student1` FOREIGN KEY (`student_student_id`) REFERENCES `student` (`student_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `nadzhaman`
--
ALTER TABLE `nadzhaman`
  ADD CONSTRAINT `nadzhaman_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nadzhaman_ibfk_2` FOREIGN KEY (`kitab_id`) REFERENCES `kitab` (`kitab_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_period1` FOREIGN KEY (`period_period_id`) REFERENCES `period` (`period_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_payment_pos1` FOREIGN KEY (`pos_pos_id`) REFERENCES `pos` (`pos_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pelanggaran`
--
ALTER TABLE `pelanggaran`
  ADD CONSTRAINT `pelanggaran_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggaran_ibfk_2` FOREIGN KEY (`period_id`) REFERENCES `period` (`period_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pelanggaran_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_class1` FOREIGN KEY (`class_class_id`) REFERENCES `class` (`class_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_student_majors1` FOREIGN KEY (`majors_majors_id`) REFERENCES `majors` (`majors_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_user_role1` FOREIGN KEY (`user_role_role_id`) REFERENCES `user_roles` (`role_id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
