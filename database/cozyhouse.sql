-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versi server:                 8.0.30 - MySQL Community Server - GPL
-- OS Server:                    Win64
-- HeidiSQL Versi:               12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Membuang struktur basisdata untuk cozyhouse_db
CREATE DATABASE IF NOT EXISTS `cozyhouse_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cozyhouse_db`;

-- membuang struktur untuk table cozyhouse_db.galeri
CREATE TABLE IF NOT EXISTS `galeri` (
  `id_galeri` int NOT NULL AUTO_INCREMENT,
  `judul_foto` varchar(100) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id_galeri`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel cozyhouse_db.galeri: ~9 rows (lebih kurang)
INSERT INTO `galeri` (`id_galeri`, `judul_foto`, `kategori`, `gambar`, `deskripsi`) VALUES
	(1, 'Pengunjung CozyHouse', 'Suasana Cafe', 'galeri-1.jpg', 'Suasana pengunjung di CozyHouse.'),
	(2, 'Sudut dekorasi cafe', 'Dekorasi', 'galeri-2.jpg', 'Sudut dekorasi cafe CozyHouse.'),
	(3, 'Area santai', 'Suasana Cafe', 'galeri-3.jpg', 'Area santai untuk pengunjung.'),
	(4, 'Minuman segar', 'Menu', 'galeri-4.jpg', 'Pilihan minuman segar CozyHouse.'),
	(5, 'Permainan di cafe', 'Aktivitas', 'galeri-5.jpg', 'Aktivitas permainan di cafe.'),
	(6, 'Suasana malam', 'Suasana Cafe', 'galeri-6.jpg', 'Suasana CozyHouse pada malam hari.'),
	(7, 'Suasana santai', 'Suasana Cafe', 'galeri-7.jpg', 'Suasana santai di CozyHouse.'),
	(8, 'Suasana malam', 'Suasana Cafe', 'galeri-8.jpg', 'Suasana cafe pada malam hari.'),
	(9, 'berkumpul dengan teman', 'Suasana Cafe', 'galeri-9.jpg', 'Pemandangan CozyHouse pada malam hari.');

-- membuang struktur untuk table cozyhouse_db.kategori_menu
CREATE TABLE IF NOT EXISTS `kategori_menu` (
  `id_kategori` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel cozyhouse_db.kategori_menu: ~4 rows (lebih kurang)
INSERT INTO `kategori_menu` (`id_kategori`, `nama_kategori`) VALUES
	(1, 'Coffee'),
	(2, 'Non Coffee'),
	(3, 'Makanan'),
	(4, 'Snack');

-- membuang struktur untuk table cozyhouse_db.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id_menu` int NOT NULL AUTO_INCREMENT,
  `id_kategori` int DEFAULT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `deskripsi` text,
  `harga` decimal(10,2) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `favorit` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_menu`),
  KEY `id_kategori` (`id_kategori`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_menu` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel cozyhouse_db.menu: ~32 rows (lebih kurang)
INSERT INTO `menu` (`id_menu`, `id_kategori`, `nama_menu`, `deskripsi`, `harga`, `gambar`, `favorit`) VALUES
	(98, 3, 'Nasi Ayam Goreng', NULL, 20000.00, 'nasi-ayam-goreng.jpg', 1),
	(99, 2, 'Ice Chocolate', NULL, 16000.00, 'Chocolate.png', 1),
	(100, 2, 'Greentea', NULL, 16000.00, 'Greentea.png', 0),
	(101, 2, 'Cream & Cookies', NULL, 16000.00, 'Cream Cookies.png', 0),
	(102, 2, 'Calamansy', NULL, 15000.00, 'Calamansy.png', 0),
	(103, 1, 'Americano', NULL, 15000.00, 'Americano.png', 0),
	(104, 1, 'ButterScotch', NULL, 17000.00, 'ButterScotch.png', 0),
	(105, 1, 'Cappucino', NULL, 17000.00, 'Cappucino.png', 0),
	(106, 2, 'OceanBlue', NULL, 15000.00, 'OceanBlue.jpeg', 1),
	(107, 1, 'MontBlanc', NULL, 19000.00, 'MontBlanc.png', 0),
	(108, 1, 'Caramel Coffe', NULL, 17000.00, 'Caramel Coffe.png', 0),
	(109, 2, 'Taro Milk', NULL, 16000.00, 'Taro Milk.png', 0),
	(110, 2, 'Red velvet', NULL, 16000.00, 'Red velvet.png', 0),
	(111, 2, 'Lemon Tea', NULL, 12000.00, 'lemon tea.png', 0),
	(112, 2, 'Teh Tarik', NULL, 16000.00, 'teh tarik.png', 0),
	(113, 2, 'Orange Squash', NULL, 15000.00, 'orange squash.png', 0),
	(114, 2, 'Lemon Squash', NULL, 15000.00, 'lemon squash.png', 0),
	(115, 2, 'Matcha ', NULL, 17000.00, 'Matcha.png', 0),
	(116, 3, 'Mie Jebew', NULL, 15000.00, 'mie jebew.png', 1),
	(117, 3, 'Mie Ayam Cozy', NULL, 18000.00, 'mie ayam.png', 0),
	(118, 3, 'Mie Kuah + Telur', NULL, 15000.00, 'mie kuah.png', 0),
	(119, 3, 'Nasi Goreng Spesial', NULL, 18000.00, 'nasi goreng spesial.png', 0),
	(120, 3, 'Nasi Goreng Cumi', NULL, 21000.00, 'nasi goreng cumi.png', 0),
	(121, 4, 'kentang Goreng', NULL, 15000.00, 'kentang goreng.png', 0),
	(122, 4, 'Bakso Goreng', NULL, 15000.00, 'bakso goreng.png', 0),
	(123, 1, 'Vanilla Coffe', NULL, 17000.00, 'Vanilla Coffe.png', 0),
	(124, 4, 'Cheese Cake Lotus', NULL, 28000.00, 'cheesecake lotus.png', 1),
	(125, 4, 'Roti Bakar', NULL, 15000.00, 'roti bakar.png', 0),
	(126, 4, 'Cheese Cake Coklat Milo', NULL, 28000.00, 'cheesecake coklat milo.png', 1),
	(127, 4, 'Cheese Cake Milo', NULL, 28000.00, 'cheesecake milo.png', 1),
	(128, 4, 'Cheese Cake Cookies &', NULL, 28000.00, 'cheesecake cookies&cream.png', 1),
	(129, 1, 'Aren Coffe', NULL, 15000.00, 'aren coffe.png', 0);

-- membuang struktur untuk table cozyhouse_db.profil_cafe
CREATE TABLE IF NOT EXISTS `profil_cafe` (
  `id_profil` int NOT NULL AUTO_INCREMENT,
  `nama_cafe` varchar(100) NOT NULL,
  `deskripsi` text,
  `alamat` text,
  `jam_operasional` varchar(100) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `instagram` varchar(100) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `gambar_hero` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_profil`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Membuang data untuk tabel cozyhouse_db.profil_cafe: ~1 rows (lebih kurang)
INSERT INTO `profil_cafe` (`id_profil`, `nama_cafe`, `deskripsi`, `alamat`, `jam_operasional`, `whatsapp`, `instagram`, `telepon`, `gambar_hero`) VALUES
	(1, 'Cafe CozyHouse', 'Tempat nyaman untuk menikmati waktu bersama.', 'Binturu, Kota Palopo, Sulawesi Selatan', 'Hubungi cafe untuk informasi jam operasional', '', '', '', 'hero.jpg');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
