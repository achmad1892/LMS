-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 19, 2016 at 05:10 AM
-- Server version: 5.6.31-0ubuntu0.15.10.1
-- PHP Version: 5.6.11-1ubuntu3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `LMS`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_admin`
--

CREATE TABLE IF NOT EXISTS `t_admin` (
  `id_admin` varchar(2) NOT NULL,
  `username` varchar(35) DEFAULT NULL,
  `fullname` varchar(45) DEFAULT NULL,
  `password` varchar(35) DEFAULT NULL,
  `foto` varchar(200) DEFAULT 'default.png',
  `type` tinyint(1) DEFAULT NULL,
  `login_status` enum('N','Y') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_admin`
--

INSERT INTO `t_admin` (`id_admin`, `username`, `fullname`, `password`, `foto`, `type`, `login_status`) VALUES
('A1', 'admin', 'administrator', 'c3284d0f94606de1fd2af172aba15bf3', 'default.png', 1, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `t_forum`
--

CREATE TABLE IF NOT EXISTS `t_forum` (
  `id_forum` int(7) NOT NULL,
  `judul` varchar(200) DEFAULT NULL,
  `isi` text,
  `tgl_forum` date DEFAULT NULL,
  `foto_topik` varchar(200) DEFAULT NULL,
  `id_index` tinyint(3) DEFAULT NULL,
  `user` varchar(10) DEFAULT NULL,
  `diakses` text
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_forum`
--

INSERT INTO `t_forum` (`id_forum`, `judul`, `isi`, `tgl_forum`, `foto_topik`, `id_index`, `user`, `diakses`) VALUES
(10, 'Pengertian Motherboard', '<p>Apa Yang dimaksud dengan motherboard ? Motherboard adalah sebuah papan tempat semua komponen komputer terangkai</p>\r\n', '2016-08-09', '', 9, 'G02', '9989961582,A1');

-- --------------------------------------------------------

--
-- Table structure for table `t_guru`
--

CREATE TABLE IF NOT EXISTS `t_guru` (
  `id_guru` varchar(3) NOT NULL,
  `nip` varchar(22) DEFAULT NULL,
  `username` varchar(35) DEFAULT NULL,
  `fullname` varchar(45) DEFAULT NULL,
  `password` varchar(35) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `foto` varchar(200) NOT NULL DEFAULT 'default.png',
  `type` tinyint(1) NOT NULL DEFAULT '2',
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `login_status` enum('N','Y') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_guru`
--

INSERT INTO `t_guru` (`id_guru`, `nip`, `username`, `fullname`, `password`, `jk`, `foto`, `type`, `status`, `login_status`) VALUES
('G01', '197205222008011004', 'sunardi', 'SUNARDI, S.Pd', 'c3284d0f94606de1fd2af172aba15bf3', 'L', 'default.png', 2, 'Y', 'N'),
('G02', '', 'raqib', 'RAQIB HABIBI, S.Kom', 'c3284d0f94606de1fd2af172aba15bf3', 'L', 'default.png', 2, 'Y', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `t_header_soal`
--

CREATE TABLE IF NOT EXISTS `t_header_soal` (
  `id_header` tinyint(3) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `tgl_dibuat` date NOT NULL,
  `waktu` int(4) DEFAULT NULL,
  `id_index` tinyint(3) DEFAULT NULL,
  `publikasi` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_header_soal`
--

INSERT INTO `t_header_soal` (`id_header`, `judul`, `tgl_dibuat`, `waktu`, `id_index`, `publikasi`) VALUES
(1, 'test', '2016-07-23', 120, 9, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `t_index_mapel`
--

CREATE TABLE IF NOT EXISTS `t_index_mapel` (
  `id_index` tinyint(3) NOT NULL,
  `id_mapel` tinyint(2) NOT NULL,
  `id_guru` varchar(3) NOT NULL,
  `id_kelas` tinyint(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_index_mapel`
--

INSERT INTO `t_index_mapel` (`id_index`, `id_mapel`, `id_guru`, `id_kelas`) VALUES
(9, 8, 'G02', 3);

-- --------------------------------------------------------

--
-- Table structure for table `t_kelas`
--

CREATE TABLE IF NOT EXISTS `t_kelas` (
  `id_kelas` tinyint(2) NOT NULL,
  `nama_kelas` varchar(25) DEFAULT NULL,
  `id_guru` varchar(3) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_kelas`
--

INSERT INTO `t_kelas` (`id_kelas`, `nama_kelas`, `id_guru`) VALUES
(3, 'XII - TKJ', 'G02');

-- --------------------------------------------------------

--
-- Table structure for table `t_komentar`
--

CREATE TABLE IF NOT EXISTS `t_komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_forum` int(7) DEFAULT NULL,
  `komentar` text,
  `gambar` varchar(200) DEFAULT NULL,
  `user` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_mapel`
--

CREATE TABLE IF NOT EXISTS `t_mapel` (
  `id_mapel` tinyint(2) NOT NULL,
  `nama_mapel` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_mapel`
--

INSERT INTO `t_mapel` (`id_mapel`, `nama_mapel`) VALUES
(8, 'Produktif');

-- --------------------------------------------------------

--
-- Table structure for table `t_materi`
--

CREATE TABLE IF NOT EXISTS `t_materi` (
  `id_materi` int(7) NOT NULL,
  `judul_mat` varchar(255) DEFAULT NULL,
  `tgl_up` date NOT NULL,
  `download` text,
  `id_guru` varchar(3) DEFAULT NULL,
  `id_kelas` tinyint(2) DEFAULT NULL,
  `id_mapel` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_materi`
--

INSERT INTO `t_materi` (`id_materi`, `judul_mat`, `tgl_up`, `download`, `id_guru`, `id_kelas`, `id_mapel`) VALUES
(5, 'aplikasi-web-php-dan-mysql.pdf', '2016-08-03', '9989961582,0000406272', 'G02', 3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `t_nilai`
--

CREATE TABLE IF NOT EXISTS `t_nilai` (
  `id_nilai` int(10) NOT NULL,
  `id_header` tinyint(3) DEFAULT NULL,
  `nis` varchar(10) DEFAULT NULL,
  `nilai` tinyint(3) DEFAULT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa`
--

CREATE TABLE IF NOT EXISTS `t_siswa` (
  `nis` varchar(10) NOT NULL,
  `username` varchar(35) DEFAULT NULL,
  `fullname` varchar(45) DEFAULT NULL,
  `password` varchar(35) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `ayah` varchar(45) DEFAULT NULL,
  `ibu` varchar(45) DEFAULT NULL,
  `alamat` varchar(120) DEFAULT NULL,
  `id_kelas` tinyint(2) DEFAULT NULL,
  `foto` varchar(200) DEFAULT 'default.png',
  `type` tinyint(1) DEFAULT '3',
  `status` enum('Y','N') DEFAULT 'Y',
  `angkatan` varchar(4) DEFAULT NULL,
  `login_status` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_siswa`
--

INSERT INTO `t_siswa` (`nis`, `username`, `fullname`, `password`, `jk`, `tgl`, `ayah`, `ibu`, `alamat`, `id_kelas`, `foto`, `type`, `status`, `angkatan`, `login_status`) VALUES
('0000406272', 'aditya', 'ADITYA VITJAY ARIFANSAH', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '2000-05-04', 'Drs. KOKOK WIJARKO', 'SUTARMI', 'patihan', 3, 'default.png', 3, 'Y', NULL, 'N'),
('0003253427', 'ade', 'ADE PERMAN PRASETIO BUDI ABADI', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '2000-03-12', 'SUYANTO', 'PARTI', 'DS. MALANGSARI', 3, 'default.png', 3, 'Y', NULL, 'N'),
('0006268727', 'adi', 'ADI PRASTYO', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '2000-05-28', 'NASIRAN', 'SARI', 'DSN BULAK', 3, 'default.png', 3, 'Y', NULL, 'N'),
('0008109764', 'afian', 'AFIAN ADI PURNOMO', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '2000-01-18', 'AGUS WIJANARKO', 'ani susilowati', 'NGRAWAN', 3, 'default.png', 3, 'Y', NULL, 'N'),
('9971669522', 'agam', 'AGAM KUSUMA HADI', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '1997-07-31', 'JAIDI', 'NARPIAH', 'DS. TEKEN GLAGAHAN, LOCERET', 3, 'default.png', 3, 'Y', NULL, 'N'),
('9974028551', 'agata', 'AGATA SURYA HENDI', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '1997-07-08', 'BUDI SETYAWAN', 'SITI DAMINAH', 'GODEAN', 3, 'default.png', 3, 'Y', NULL, 'N'),
('9979665291', 'rohman', 'ABDURROHMAN Z', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '1997-11-30', 'FADHALUL MUNTAHA', 'Suwarti', 'DS. KARANG SONO, LOCERET', 3, 'default.png', 3, 'Y', NULL, 'N'),
('9980809159', 'hadi', 'AAN HADI PURNOMO', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '1998-02-25', 'SLAMET', 'SULASTRI', 'DS. KARANG SONO', 3, 'default.png', 3, 'Y', NULL, 'N'),
('9980809170', 'danar', 'DANAR SUWARNO', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '1998-06-21', 'SADIRAHAN', 'SOPIYATUN', 'Ds. Karangsono, Loceret - Nganjuk', 3, 'default.png', 3, 'Y', '2016', 'N'),
('9984321127', 'bima', 'ADI BIMA KURNIAWAN', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '1998-04-15', 'JASMANI', 'JINEM', 'DS. SENDANG BUMEN, KEC. BERBEK', 3, 'default.png', 3, 'Y', NULL, 'N'),
('9989152628', 'a''an', 'A''AN TRY SASMITO', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '1998-08-01', 'SUTADJI', 'TAMINEM', 'Ds. Kepanjen', 3, 'default.png', 3, 'Y', NULL, 'N'),
('9989961582', 'yuan', 'AHMAD YUAN WAHYU SADINO', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '1998-03-24', 'ISWANDI', 'UMI ANNISAH', 'Ds. Teken Glagahan, Loceret - Nganjuk', 3, 'default.png', 3, 'Y', '2016', 'N'),
('9990171268', 'topa', 'ACHMAD MUSTOPA', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '1999-06-23', 'SUYONO', 'SRI UTAMI', 'KATES', 3, 'default.png', 3, 'Y', NULL, 'N'),
('9991366992', 'abu', 'ABU YAZID ALMUNIR', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '1999-04-03', 'JUMADI', 'SUMIATI', 'DS. KEDUNGOMBO', 3, 'default.png', 3, 'Y', NULL, 'N'),
('9991367472', 'putro', 'ADI SAPUTRO', 'c3284d0f94606de1fd2af172aba15bf3', 'L', '1999-05-07', 'SUKIRAN HADI', 'KIFTIYAH MANDARSARI', 'jln bajulan', 3, 'default.png', 3, 'Y', NULL, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `t_soal`
--

CREATE TABLE IF NOT EXISTS `t_soal` (
  `id_soal` int(5) NOT NULL,
  `id_header` tinyint(3) NOT NULL,
  `soal` text NOT NULL,
  `gambar` varchar(200) DEFAULT NULL,
  `pil_a` text,
  `pil_b` text,
  `pil_c` text,
  `pil_d` text,
  `kunci` char(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_soal`
--

INSERT INTO `t_soal` (`id_soal`, `id_header`, `soal`, `gambar`, `pil_a`, `pil_b`, `pil_c`, `pil_d`, `kunci`) VALUES
(1, 1, '            apa yang dimaksud motherboard?          ', '', 'Papan rangkaian komputer tempat semua komponen elektronik komputer terangkai.', 'Kotak tempat mesin komputer', 'Perangkat yang digunakan untuk keperluan jaringan LAN', 'Semua jawaban benar', 'A'),
(2, 1, '            sfkjsdfbhkaknj          ', 'cute-baby3.jpg', 'benar', 'sdkjnf', 'ksjdnfsk', 'dkfjnsam', 'A'),
(3, 1, 'soal', NULL, 'pil_a', 'pil_b', 'pil_c', 'pil_d', 'K');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_admin`
--
ALTER TABLE `t_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `t_forum`
--
ALTER TABLE `t_forum`
  ADD PRIMARY KEY (`id_forum`),
  ADD KEY `fk_t_forum_1_idx` (`id_index`);

--
-- Indexes for table `t_guru`
--
ALTER TABLE `t_guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD UNIQUE KEY `fullname` (`fullname`);

--
-- Indexes for table `t_header_soal`
--
ALTER TABLE `t_header_soal`
  ADD PRIMARY KEY (`id_header`);

--
-- Indexes for table `t_index_mapel`
--
ALTER TABLE `t_index_mapel`
  ADD PRIMARY KEY (`id_index`),
  ADD KEY `fk_t_index_mapel_1_idx` (`id_guru`),
  ADD KEY `fk_t_index_mapel_2_idx` (`id_kelas`),
  ADD KEY `fk_t_index_mapel_3_idx` (`id_mapel`);

--
-- Indexes for table `t_kelas`
--
ALTER TABLE `t_kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `fk_t_kelas_1_idx` (`id_guru`);

--
-- Indexes for table `t_komentar`
--
ALTER TABLE `t_komentar`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `fk_t_komentar_1_idx` (`id_forum`);

--
-- Indexes for table `t_mapel`
--
ALTER TABLE `t_mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `t_materi`
--
ALTER TABLE `t_materi`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indexes for table `t_nilai`
--
ALTER TABLE `t_nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `fk_t_nilai_1_idx` (`id_header`),
  ADD KEY `fk_t_nilai_2_idx` (`nis`);

--
-- Indexes for table `t_siswa`
--
ALTER TABLE `t_siswa`
  ADD PRIMARY KEY (`nis`),
  ADD UNIQUE KEY `alamat_UNIQUE` (`alamat`),
  ADD KEY `fk_t_siswa_1_idx` (`id_kelas`);

--
-- Indexes for table `t_soal`
--
ALTER TABLE `t_soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `fk_t_soal_1_idx` (`id_header`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_forum`
--
ALTER TABLE `t_forum`
  MODIFY `id_forum` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `t_header_soal`
--
ALTER TABLE `t_header_soal`
  MODIFY `id_header` tinyint(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `t_index_mapel`
--
ALTER TABLE `t_index_mapel`
  MODIFY `id_index` tinyint(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `t_kelas`
--
ALTER TABLE `t_kelas`
  MODIFY `id_kelas` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `t_komentar`
--
ALTER TABLE `t_komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_mapel`
--
ALTER TABLE `t_mapel`
  MODIFY `id_mapel` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `t_materi`
--
ALTER TABLE `t_materi`
  MODIFY `id_materi` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `t_nilai`
--
ALTER TABLE `t_nilai`
  MODIFY `id_nilai` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `t_soal`
--
ALTER TABLE `t_soal`
  MODIFY `id_soal` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
