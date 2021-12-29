-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 29, 2021 at 03:12 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventori_tb_perkasa`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(10) DEFAULT NULL,
  `nama_barang` varchar(50) DEFAULT NULL,
  `harga` int(255) DEFAULT NULL,
  `stok` int(5) DEFAULT NULL,
  `id_jenis` int(11) DEFAULT NULL,
  `id_merk` int(11) DEFAULT NULL,
  `kode_supplier` varchar(10) DEFAULT NULL,
  `id_warna` int(11) DEFAULT NULL,
  `berat` varchar(50) DEFAULT NULL,
  `ukuran` varchar(50) DEFAULT NULL,
  `keterangan` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_barang`, `nama_barang`, `harga`, `stok`, `id_jenis`, `id_merk`, `kode_supplier`, `id_warna`, `berat`, `ukuran`, `keterangan`) VALUES
(1, 'BRG0001', 'Sepatu', 100000, 13, 13, 0, '', 19, '12', '12', ''),
(2, 'BRG0002', 'Sandal', 10000, 9, 0, 0, '', 20, '12', '12', '');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_barang_keluar` int(11) NOT NULL,
  `kode_barang` varchar(20) DEFAULT NULL,
  `tgl_keluar` date DEFAULT NULL,
  `harga_satuan` int(30) NOT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tot_harga` int(255) DEFAULT NULL,
  `id_transaksi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_barang_keluar`, `kode_barang`, `tgl_keluar`, `harga_satuan`, `jumlah`, `tot_harga`, `id_transaksi`) VALUES
(1, 'BRG0001', '2021-10-12', 100000, 1, 100000, 1),
(2, 'BRG0001', '2021-10-12', 100000, 1, 100000, 2),
(3, 'BRG0002', '2021-10-20', 10000, 1, 10000, 3);

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_barang_masuk` int(11) NOT NULL,
  `kode_barang` varchar(10) DEFAULT NULL,
  `kode_supplier` varchar(10) DEFAULT NULL,
  `jumlah` int(3) DEFAULT NULL,
  `harga` int(10) DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_barang_masuk`, `kode_barang`, `kode_supplier`, `jumlah`, `harga`, `tgl_masuk`) VALUES
(1, 'BRG0001', '', 5, 0, '2021-10-12');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `kode_transaksi` varchar(10) DEFAULT NULL,
  `kode_barang` varchar(10) DEFAULT NULL,
  `qty` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_barang`
--

CREATE TABLE `jenis_barang` (
  `id_jenis` int(11) NOT NULL,
  `jenis_barang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `jenis_barang`
--

INSERT INTO `jenis_barang` (`id_jenis`, `jenis_barang`) VALUES
(6, 'CNP'),
(10, 'NAKO'),
(13, 'SIKU'),
(14, 'UNP'),
(16, 'IWF'),
(23, 'WERMES'),
(25, 'PLAT GALVANIS'),
(26, 'PLAT BORDES'),
(28, 'STAINLIS STAR 201'),
(29, 'PLAFON (BELUM)'),
(40, 'TALANG GALVALUM'),
(41, 'MATA BOR'),
(43, 'TALANG KARPET'),
(45, 'LIS GYPSUM'),
(47, 'CAKAR AYAM'),
(48, 'ATAP PVC'),
(50, 'GALVALUM (BELUM)'),
(52, 'BESI BETON'),
(53, 'PLAT STRIP'),
(54, 'PLAT HITAM'),
(56, 'PIPA HITAM (BELUM)'),
(57, 'PIPA GALVANIS (BELUM)'),
(58, 'HOLLOW GALVANIS'),
(59, 'HOLLOW HITAM'),
(60, 'PRALON + ACCESORIES (BELUM)'),
(63, 'STAINLIS BLUE STAR 201 (BELUM)'),
(64, 'TRIPLEK'),
(67, 'BAJA RINGAN'),
(68, 'PLAT STANLIS'),
(69, 'HOLLOW GYPSUM'),
(70, 'ALAT (BELUM)'),
(71, 'ASESORIS STANLIS (BELUM)'),
(72, 'ASESORIS BESI (BELUM)');

-- --------------------------------------------------------

--
-- Table structure for table `material_warna`
--

CREATE TABLE `material_warna` (
  `id_warna` int(11) NOT NULL,
  `kode_warna` varchar(20) DEFAULT NULL,
  `ukuran` varchar(10) DEFAULT NULL,
  `berat` varchar(11) DEFAULT NULL,
  `warna` varchar(30) DEFAULT NULL,
  `harga` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `material_warna`
--

INSERT INTO `material_warna` (`id_warna`, `kode_warna`, `ukuran`, `berat`, `warna`, `harga`) VALUES
(10, 'WRN0001', NULL, NULL, 'KUNING', NULL),
(11, 'WRN0011', NULL, NULL, 'BIRU', NULL),
(12, 'WRN0012', NULL, NULL, 'HIJAU', NULL),
(13, 'WRN0013', NULL, NULL, 'PINK', NULL),
(14, 'WRN0014', NULL, NULL, 'UNGU', NULL),
(15, 'WRN0015', NULL, NULL, 'PUTIH', NULL),
(16, 'WRN0016', NULL, NULL, 'BIRU KUNING', NULL),
(17, 'WRN0017', NULL, NULL, 'HIJAU', NULL),
(18, 'WRN0018', NULL, NULL, 'KUNING PUTIH', NULL),
(19, 'WRN0019', NULL, NULL, 'MERAH PUTIH', NULL),
(20, 'WRN0020', NULL, NULL, 'BIRU PUTIH', NULL),
(21, 'WRN0021', NULL, NULL, 'HIJAU PUTIH', NULL),
(22, 'WRN0022', NULL, NULL, 'ORANGE', NULL),
(23, 'WRN0023', NULL, NULL, 'MERAH', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `merk_barang`
--

CREATE TABLE `merk_barang` (
  `id_merk` int(11) NOT NULL,
  `merk_barang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id_setting` int(11) NOT NULL,
  `nm_usaha` varchar(255) DEFAULT NULL,
  `notelp` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id_setting`, `nm_usaha`, `notelp`, `fax`, `alamat`) VALUES
(1, 'TB A PERKASA', '085725531089', '46546889', 'Jl. Runting, Kecamatab Dadiharjo, Kabupaten Pati');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `kode_supplier` varchar(10) DEFAULT NULL,
  `nama_supplier` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `no_hp` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `kode_transaksi` varchar(20) DEFAULT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `total_harga` int(255) DEFAULT NULL,
  `bayar` int(255) DEFAULT NULL,
  `sisa` int(255) DEFAULT NULL,
  `diskon` int(11) NOT NULL,
  `nama_pembeli` varchar(25) NOT NULL,
  `nohp_pembeli` varchar(12) NOT NULL,
  `alamat` text NOT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `kode_transaksi`, `tgl_transaksi`, `total_harga`, `bayar`, `sisa`, `diskon`, `nama_pembeli`, `nohp_pembeli`, `alamat`, `ket`) VALUES
(1, 'TR0000001', '2021-10-12', 100000, 120000, 20000, 0, 'customer 2', '085725531089', 'kelet', 'Lunas'),
(2, 'TR0000002', '2021-10-12', 100000, 120000, 20000, 0, 'customer new', '07879798', 'Jepara Kelet', 'Sudah Lunas'),
(3, 'TR0000003', '2021-10-20', 10000, 10000, 0, 0, 'dad', 's', 'dsa', 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(155) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `username`, `password`, `level`) VALUES
(1, 'Administrators', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(4, 'tbperkasa', 'gudang', '202446dd1d6028084426867365b0c7a1', 'petugas gudang');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_transaksi`
-- (See below for the actual view)
--
CREATE TABLE `view_transaksi` (
`id_barang_keluar` int(11)
,`kode_barang` varchar(20)
,`tgl_keluar` date
,`jumlah` int(11)
,`tot_harga` int(255)
,`harga_satuan` int(30)
,`id_transaksi` int(11)
,`nama_barang` varchar(50)
,`harga_awal` int(255)
);

-- --------------------------------------------------------

--
-- Structure for view `view_transaksi`
--
DROP TABLE IF EXISTS `view_transaksi`;

CREATE ALGORITHM=TEMPTABLE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_transaksi`  AS SELECT `a`.`id_barang_keluar` AS `id_barang_keluar`, `a`.`kode_barang` AS `kode_barang`, `a`.`tgl_keluar` AS `tgl_keluar`, `a`.`jumlah` AS `jumlah`, `a`.`tot_harga` AS `tot_harga`, `a`.`harga_satuan` AS `harga_satuan`, `a`.`id_transaksi` AS `id_transaksi`, `b`.`nama_barang` AS `nama_barang`, `b`.`harga` AS `harga_awal` FROM (`barang_keluar` `a` join `barang` `b` on(`a`.`kode_barang` = `b`.`kode_barang`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`) USING BTREE;

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`) USING BTREE;

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`) USING BTREE;

--
-- Indexes for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  ADD PRIMARY KEY (`id_jenis`) USING BTREE;

--
-- Indexes for table `material_warna`
--
ALTER TABLE `material_warna`
  ADD PRIMARY KEY (`id_warna`) USING BTREE;

--
-- Indexes for table `merk_barang`
--
ALTER TABLE `merk_barang`
  ADD PRIMARY KEY (`id_merk`) USING BTREE;

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id_setting`) USING BTREE;

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`) USING BTREE;

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id_barang_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_barang_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jenis_barang`
--
ALTER TABLE `jenis_barang`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `material_warna`
--
ALTER TABLE `material_warna`
  MODIFY `id_warna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `merk_barang`
--
ALTER TABLE `merk_barang`
  MODIFY `id_merk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
