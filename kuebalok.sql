-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 03, 2025 at 05:21 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kuebalok`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_pesanan` varchar(12) NOT NULL,
  `id_produk` varchar(5) NOT NULL,
  `jumlah` int NOT NULL,
  `harga_produk` int NOT NULL,
  `sub_total` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int NOT NULL,
  `pesan` text NOT NULL,
  `tanggal` date NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `jabatan` enum('admin','kasir','owner') NOT NULL,
  `no_tlp` varchar(50) NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `username`, `jabatan`, `no_tlp`, `email`, `password`) VALUES
(3, 'Ridha', 'kasir', '085315537544', 'ridhabudiapril@gmai.com', '123'),
(4, 'Ahmad', 'admin', '085316703190', 'ahmadfauzi@gmail.com', '123'),
(9, 'Nuy', 'owner', '123456789012', 'nuy@gmail.com', '123'),
(11, 'cici', 'admin', '085315537544', 'ridhaapril06@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` varchar(12) NOT NULL,
  `nama_pemesan` varchar(50) DEFAULT NULL,
  `tgl_pesanan` date DEFAULT NULL,
  `total_hargaall` int DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `status_pesanan` enum('menunggu','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jenis_pesanan` enum('take_away','dine_in') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `nama_pemesan`, `tgl_pesanan`, `total_hargaall`, `catatan`, `status_pesanan`, `jenis_pesanan`) VALUES
('PSN000001', 'Andi', '2025-05-30', 15000, NULL, 'selesai', NULL),
('PSN000002', 'Sinta', '2025-05-30', 30000, NULL, 'selesai', NULL),
('PSN000003', 'Budi', '2025-05-30', 22000, NULL, 'selesai', NULL),
('PSN000004', 'Rina', '2025-05-29', 40000, NULL, 'selesai', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_kasir`
--

CREATE TABLE `pesanan_kasir` (
  `id_pesanan` varchar(12) NOT NULL,
  `nama_pemesan` varchar(50) DEFAULT NULL,
  `tgl_pesanan` date DEFAULT NULL,
  `total_hargaall` int DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `jenis_pesanan` enum('take_away','dine_in') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_kasir` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` varchar(5) NOT NULL,
  `kategori` enum('makanan','minuman') NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `poto_produk` varchar(100) DEFAULT NULL,
  `harga_produk` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `kategori`, `nama_produk`, `poto_produk`, `harga_produk`) VALUES
('KB001', 'makanan', 'Original', 'Original.jpg', 3000),
('KB002', 'makanan', 'Coklat', 'coklat.jpg', 3000),
('KB003', 'makanan', 'Coklat Keju', 'Coklat Keju.jpg', 3000),
('KB004', 'makanan', 'Keju ', 'Keju.jpg', 3000),
('KB005', 'makanan', 'Full Coklat', 'FullCoklat.jpg', 4000),
('KB006', 'makanan', 'Greentea', 'Greentea.jpg', 3500),
('KB007', 'makanan', 'Tiramisu', 'Tiramisu.jpg', 3500),
('KB008', 'makanan', 'Redvelvet', 'Redvelvet.jpg', 4000),
('KB009', 'makanan', 'Taro', 'Taro.jpg', 3000);

-- --------------------------------------------------------

--
-- Table structure for table `stok_harian`
--

CREATE TABLE `stok_harian` (
  `id` int NOT NULL,
  `id_produk` varchar(5) NOT NULL,
  `stok` int NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL,
  `id_pesanan` varchar(12) NOT NULL,
  `status_transaksi` enum('belum dibayar','sudah dibayar') NOT NULL,
  `bukti_pembayaran` varchar(255) NOT NULL,
  `metode_pembayaran` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `pesanan_kasir`
--
ALTER TABLE `pesanan_kasir`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `stok_harian`
--
ALTER TABLE `stok_harian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `stok_harian`
--
ALTER TABLE `stok_harian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan_kasir` (`id_pesanan`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `detail_pesanan_ibfk_3` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `stok_harian`
--
ALTER TABLE `stok_harian`
  ADD CONSTRAINT `stok_harian_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan_kasir` (`id_pesanan`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
