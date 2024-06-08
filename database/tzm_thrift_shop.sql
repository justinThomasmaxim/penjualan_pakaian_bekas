-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Bulan Mei 2024 pada 14.22
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tzm_thrift_shop`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Delete_All_Data` (IN `ID` INT, IN `tabel` VARCHAR(50))   BEGIN
		IF tabel = "pengguna" THEN
			DELETE FROM jabatan 		WHERE id_pengguna = ID;
		ELSEIF tabel = "pelanggan" THEN
			DELETE FROM transaksi 				WHERE id_pelanggan = ID;
			DELETE FROM pelanggan 				WHERE id_pelanggan = ID;
		ELSEIF tabel = "transaksi" THEN
			DELETE FROM pembelian_barang_bekas  WHERE id_transaksi = ID;
			DELETE FROM transaksi 			    WHERE id_transaksi = ID;
		ELSEIF tabel = "pembelian_barang_bekas" THEN
			DELETE FROM pembelian_barang_bekas 	WHERE id_pembelian = ID;
		END IF;
	END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertPelanggan` (IN `p_id_pengguna` INT, IN `p_nama_pelanggan` VARCHAR(50), IN `p_alamat` VARCHAR(50), IN `p_nomor_telepon` VARCHAR(12))   BEGIN
    INSERT INTO pelanggan (id_pengguna, nama_pelanggan, alamat, nomor_telepon) 
    VALUES (p_id_pengguna, p_nama_pelanggan, p_alamat, p_nomor_telepon);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertPembelianBarangBekas` (IN `p_id_transaksi` VARCHAR(8), IN `p_id_barang_bekas` VARCHAR(8), IN `p_jumlah` INT)   BEGIN
    INSERT INTO pembelian_barang_bekas (id_transaksi, id_barang_bekas, jumlah) 
    VALUES (p_id_transaksi, p_id_barang_bekas, p_jumlah);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertPengguna` (IN `p_username` VARCHAR(50), IN `p_password` VARCHAR(50), IN `p_email` VARCHAR(50))   BEGIN
    INSERT INTO pengguna (username, password, email) VALUES (p_username, p_password, p_email);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertTransaksi` (IN `p_id_pelanggan` VARCHAR(8), IN `p_tanggal_transaksi` DATE, IN `p_total_harga` DOUBLE)   BEGIN
    INSERT INTO transaksi (id_pelanggan, tanggal_transaksi, total_harga) 
    VALUES (p_id_pelanggan, p_tanggal_transaksi, p_total_harga);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdatePelanggan` (IN `p_id_pelanggan` INT, IN `p_id_pengguna` INT, IN `p_nama_pelanggan` VARCHAR(50), IN `p_alamat` VARCHAR(50), IN `p_nomor_telepon` VARCHAR(12))   BEGIN
    UPDATE pelanggan
    SET id_pengguna = p_id_pengguna, 
        nama_pelanggan = p_nama_pelanggan, 
        alamat = p_alamat, 
        nomor_telepon = p_nomor_telepon
    WHERE id_pelanggan = p_id_pelanggan;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdatePembelianBarangBekas` (IN `p_id_pembelian` INT, IN `p_id_transaksi` VARCHAR(8), IN `p_id_barang_bekas` VARCHAR(8), IN `p_jumlah` INT)   BEGIN
    UPDATE pembelian_barang_bekas
    SET id_transaksi = p_id_transaksi, 
        id_barang_bekas = p_id_barang_bekas, 
        jumlah = p_jumlah
    WHERE id_pembelian = p_id_pembelian;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdatePengguna` (IN `p_id_pengguna` INT, IN `p_username` VARCHAR(50), IN `p_password` VARCHAR(50), IN `p_email` VARCHAR(50))   BEGIN
    UPDATE pengguna
    SET username = p_username, password = p_password, email = p_email
    WHERE id_pengguna = p_id_pengguna;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateTransaksi` (IN `p_id_transaksi` INT, IN `p_id_pelanggan` VARCHAR(8), IN `p_tanggal_transaksi` DATE, IN `p_total_harga` DOUBLE)   BEGIN
    UPDATE transaksi
    SET id_pelanggan = p_id_pelanggan, 
        tanggal_transaksi = p_tanggal_transaksi, 
        total_harga = p_total_harga
    WHERE id_transaksi = p_id_transaksi;
END$$

--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `CekHarga` (`p_id_barang` VARCHAR(8)) RETURNS INT(11)  BEGIN
    DECLARE harga_barang_bekas INT;
    SELECT harga INTO harga_barang_bekas FROM barang_bekas WHERE id_barang_bekas = p_id_barang;
    RETURN harga_barang_bekas;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_bekas`
--

CREATE TABLE `barang_bekas` (
  `id_barang_bekas` varchar(8) NOT NULL,
  `id_kategori` varchar(8) DEFAULT NULL,
  `nama_barang` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang_bekas`
--

INSERT INTO `barang_bekas` (`id_barang_bekas`, `id_kategori`, `nama_barang`, `deskripsi`, `harga`, `stok`) VALUES
('BB001', 'KAT001', 'Kemeja', 'Kemeja lengan pendek warna biru', 25, 20),
('BB002', 'KAT001', 'Celana', 'Celana jeans warna hitam', 30, 30),
('BB003', 'KAT002', 'Smartphone', 'Smartphone merk XYZ dengan spesifikasi tertentu', 150, 20),
('BB004', 'KAT002', 'Laptop', 'Laptop merk ABC dengan spesifikasi tinggi', 500, 10),
('BB005', 'KAT003', 'Meja Belajar', 'Meja belajar kayu solid dengan rak buku', 80, 40),
('BB006', 'KAT003', 'Kursi', 'Kursi makan plastik warna putih', 20, 50),
('BB007', 'KAT001', 'Jaket', 'Jaket tebal untuk cuaca dingin', 40, 15),
('BB008', 'KAT003', 'Lemari Pakaian', 'Lemari pakaian berbahan kayu', 200, 10),
('BB009', 'KAT002', 'Tablet', 'Tablet dengan layar sentuh', 100, 25),
('BB010', 'KAT003', 'Rak Buku', 'Rak buku besi dengan 5 rak', 30, 35);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` varchar(8) NOT NULL,
  `nama_kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
('KAT001', 'Pakaian'),
('KAT002', 'Elektronik'),
('KAT003', 'Perabotan Rumah Tangga');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `nama_pelanggan` varchar(50) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `nomor_telepon` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `id_pengguna`, `nama_pelanggan`, `alamat`, `nomor_telepon`) VALUES
(1, 1, 'John Doe', '123 Main Street', '081234567890'),
(2, 2, 'Jane Smith', '456 Elm Street', '081234567891'),
(3, 3, 'Alex Wong', '789 Oak Street', '081234567892');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_barang_bekas`
--

CREATE TABLE `pembelian_barang_bekas` (
  `id_pembelian` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `id_barang_bekas` varchar(8) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembelian_barang_bekas`
--

INSERT INTO `pembelian_barang_bekas` (`id_pembelian`, `id_transaksi`, `id_barang_bekas`, `jumlah`) VALUES
(1, 1, 'BB001', 2),
(2, 1, 'BB002', 1),
(3, 2, 'BB003', 1),
(4, 2, 'BB004', 1),
(5, 3, 'BB005', 2),
(6, 3, 'BB006', 3),
(7, 4, 'BB007', 1),
(8, 5, 'BB008', 2),
(9, 6, 'BB009', 1),
(10, 7, 'BB010', 2);

--
-- Trigger `pembelian_barang_bekas`
--
DELIMITER $$
CREATE TRIGGER `UpdateJumlahStokADPembelianBarangBekas` AFTER DELETE ON `pembelian_barang_bekas` FOR EACH ROW BEGIN
	UPDATE barang_bekas
	SET stok = stok + OLD.jumlah
	WHERE id_barang_bekas = OLD.id_barang_bekas;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateJumlahStokAIPembelianBarangBekas` AFTER INSERT ON `pembelian_barang_bekas` FOR EACH ROW BEGIN
	UPDATE barang_bekas
	SET stok = stok - NEW.jumlah
	WHERE id_barang_bekas = NEW.id_barang_bekas;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateJumlahStokAUPembelianBarangBekas` AFTER UPDATE ON `pembelian_barang_bekas` FOR EACH ROW BEGIN
	UPDATE barang_bekas
	SET stok = stok + OLD.jumlah
	WHERE id_barang_bekas = OLD.id_barang_bekas;
	
	UPDATE barang_bekas
	SET stok = stok - NEW.jumlah
	WHERE id_barang_bekas = NEW.id_barang_bekas;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateTotalBiayaADPembelianBarangBekas` AFTER DELETE ON `pembelian_barang_bekas` FOR EACH ROW BEGIN
	UPDATE transaksi
	SET total_harga = total_harga - (SELECT harga * OLD.jumlah FROM barang_bekas WHERE id_barang_bekas = OLD.id_barang_bekas)
	WHERE id_transaksi = OLD.id_transaksi;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateTotalBiayaAIPembelianBarangBekas` AFTER INSERT ON `pembelian_barang_bekas` FOR EACH ROW BEGIN
	UPDATE transaksi
	SET total_harga = total_harga + (SELECT harga * NEW.jumlah FROM barang_bekas WHERE id_barang_bekas = NEW.id_barang_bekas)
	WHERE id_transaksi = NEW.id_transaksi;
    END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateTotalBiayaAUPembelianBarangBekas` AFTER UPDATE ON `pembelian_barang_bekas` FOR EACH ROW BEGIN
	UPDATE transaksi
	SET total_harga = total_harga - (SELECT harga * OLD.jumlah FROM barang_bekas WHERE id_barang_bekas = OLD.id_barang_bekas) 
	+ (SELECT harga * NEW.jumlah FROM barang_bekas WHERE id_barang_bekas = NEW.id_barang_bekas)
	WHERE id_transaksi = NEW.id_transaksi;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `username`, `password`, `email`) VALUES
(1, 'john_doe', 'hashed_password_1', 'john@example.com'),
(2, 'jane_smith', 'hashed_password_2', 'jane@example.com'),
(3, 'alex_wong', 'hashed_password_3', 'alex@example.com');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `penjualan_barang_bekas_view`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `penjualan_barang_bekas_view` (
`id_transaksi` int(11)
,`id_pelanggan` int(11)
,`nama_pelanggan` varchar(50)
,`alamat_pelanggan` varchar(50)
,`telepon_pelanggan` varchar(12)
,`tanggal_transaksi` date
,`total_harga` double
,`id_pembelian` int(11)
,`id_barang_bekas` varchar(8)
,`nama_barang` varchar(50)
,`deskripsi` text
,`harga_barang` double
,`jumlah` int(11)
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `tanggal_transaksi` date DEFAULT NULL,
  `total_harga` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `tanggal_transaksi`, `total_harga`) VALUES
(1, 1, '2024-04-01', 150),
(2, 2, '2024-04-02', 200),
(3, 3, '2024-04-03', 75),
(4, 3, '2024-04-04', 100),
(5, 2, '2024-04-05', 50),
(6, 1, '2024-04-06', 120),
(7, 1, '2024-04-07', 80),
(8, 2, '2024-04-08', 90),
(9, 3, '2024-04-09', 110),
(10, 3, '2024-04-10', 95),
(11, 1, '2024-04-17', 0);

-- --------------------------------------------------------

--
-- Struktur untuk view `penjualan_barang_bekas_view`
--
DROP TABLE IF EXISTS `penjualan_barang_bekas_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `penjualan_barang_bekas_view`  AS SELECT `t`.`id_transaksi` AS `id_transaksi`, `p`.`id_pelanggan` AS `id_pelanggan`, `p`.`nama_pelanggan` AS `nama_pelanggan`, `p`.`alamat` AS `alamat_pelanggan`, `p`.`nomor_telepon` AS `telepon_pelanggan`, `t`.`tanggal_transaksi` AS `tanggal_transaksi`, `t`.`total_harga` AS `total_harga`, `pb`.`id_pembelian` AS `id_pembelian`, `bb`.`id_barang_bekas` AS `id_barang_bekas`, `bb`.`nama_barang` AS `nama_barang`, `bb`.`deskripsi` AS `deskripsi`, `bb`.`harga` AS `harga_barang`, `pb`.`jumlah` AS `jumlah` FROM (((`transaksi` `t` join `pelanggan` `p` on(`t`.`id_pelanggan` = `p`.`id_pelanggan`)) join `pembelian_barang_bekas` `pb` on(`t`.`id_transaksi` = `pb`.`id_transaksi`)) join `barang_bekas` `bb` on(`pb`.`id_barang_bekas` = `bb`.`id_barang_bekas`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang_bekas`
--
ALTER TABLE `barang_bekas`
  ADD PRIMARY KEY (`id_barang_bekas`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indeks untuk tabel `pembelian_barang_bekas`
--
ALTER TABLE `pembelian_barang_bekas`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_barang_bekas` (`id_barang_bekas`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pembelian_barang_bekas`
--
ALTER TABLE `pembelian_barang_bekas`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang_bekas`
--
ALTER TABLE `barang_bekas`
  ADD CONSTRAINT `barang_bekas_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Ketidakleluasaan untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Ketidakleluasaan untuk tabel `pembelian_barang_bekas`
--
ALTER TABLE `pembelian_barang_bekas`
  ADD CONSTRAINT `pembelian_barang_bekas_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`),
  ADD CONSTRAINT `pembelian_barang_bekas_ibfk_2` FOREIGN KEY (`id_barang_bekas`) REFERENCES `barang_bekas` (`id_barang_bekas`);

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
