-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Waktu pembuatan: 10 Mar 2025 pada 18.39
-- Versi server: 10.1.48-MariaDB-1~bionic
-- Versi PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absen_jamaah`
--

CREATE TABLE `absen_jamaah` (
  `jamaah_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `period_id` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `jumlah_tidak_jamaah` int(11) NOT NULL COMMENT 'Diisi manual',
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absen_jamaah`
--
ALTER TABLE `absen_jamaah`
  ADD PRIMARY KEY (`jamaah_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `period_id` (`period_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absen_jamaah`
--
ALTER TABLE `absen_jamaah`
  MODIFY `jamaah_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absen_jamaah`
--
ALTER TABLE `absen_jamaah`
  ADD CONSTRAINT `absen_jamaah_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `absen_jamaah_ibfk_2` FOREIGN KEY (`period_id`) REFERENCES `period` (`period_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
