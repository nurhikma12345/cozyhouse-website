-- ============================================================
-- CozyHouse Admin — tabel akun admin
-- Jalankan SEKALI di database cozyhouse_db (phpMyAdmin / HeidiSQL).
-- Login awal  : username "admin"  |  password "admin123"
-- WAJIB diganti lewat menu "Akun Saya" setelah login pertama.
-- ============================================================
USE `cozyhouse_db`;

CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin`      int NOT NULL AUTO_INCREMENT,
  `username`      varchar(50)  NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `nama_lengkap`  varchar(100) NOT NULL,
  `dibuat`        timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin` (`username`, `password_hash`, `nama_lengkap`) VALUES
  ('admin', 'admin12345', 'Administrator')
ON DUPLICATE KEY UPDATE `username` = `username`;

-- OPSIONAL: halaman Tentang Kami (tentang.php) membaca kolom gambar_tentang,
-- tetapi kolom ini belum ada di cozyhouse.sql. Jalankan baris di bawah
-- (hapus tanda -- di depannya) agar foto "Tentang Kami" bisa diganti dari admin.
-- ALTER TABLE `profil_cafe` ADD COLUMN `gambar_tentang` varchar(255) DEFAULT NULL;
