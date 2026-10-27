-- Database Cafe CozyHouse
-- Cara impor (Laragon): buka phpMyAdmin atau HeidiSQL, lalu Import file ini.
CREATE DATABASE IF NOT EXISTS cozyhouse_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cozyhouse_db;

DROP TABLE IF EXISTS menu;
DROP TABLE IF EXISTS kategori;

CREATE TABLE kategori (
  id   TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(30) NOT NULL UNIQUE,
  nama VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE menu (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  kategori_id TINYINT UNSIGNED NOT NULL,
  nama        VARCHAR(100) NOT NULL,
  harga       INT UNSIGNED NOT NULL,
  gambar      VARCHAR(120) NOT NULL,
  favorit     TINYINT(1) NOT NULL DEFAULT 0,  -- 1 = tampil di "Menu favorit" (Beranda)
  di_menu     TINYINT(1) NOT NULL DEFAULT 1,  -- 1 = tampil di halaman Menu
  tersedia    TINYINT(1) NOT NULL DEFAULT 1,  -- 0 = sembunyikan sementara (stok habis)
  urutan      SMALLINT NOT NULL DEFAULT 0,
  CONSTRAINT fk_menu_kategori FOREIGN KEY (kategori_id) REFERENCES kategori(id)
) ENGINE=InnoDB;

INSERT INTO kategori (id, slug, nama) VALUES
  (1, 'coffee', 'Coffee'),
  (2, 'non-coffee', 'Non Coffee'),
  (3, 'makanan', 'Makanan'),
  (4, 'snack', 'Snack');

INSERT INTO menu (nama, harga, kategori_id, gambar, favorit, di_menu, urutan) VALUES
  ('Nasi Ayam Goreng', 20000, 3, 'nasi-ayam-goreng.jpg', 1, 0, 1),
  ('Mie Jebew', 15000, 3, 'mie-jebew.jpg', 1, 0, 2),
  ('Ice Chocolate', 16000, 2, 'ice-chocolate.jpg', 1, 0, 3),
  ('Greentea', 16000, 2, 'greentea.jpg', 0, 1, 10),
  ('Cream & Cookies', 16000, 2, 'cream-cookies.jpg', 0, 1, 11),
  ('Calamansy', 12000, 2, 'calamansy.jpg', 0, 1, 12),
  ('Ice coffe aren', 15000, 1, 'ice-coffee-aren.jpg', 0, 1, 13),
  ('Cheese Cake', 27000, 4, 'cheese-cake.jpg', 0, 1, 20),
  ('Mie Ayam Bakso', 18000, 3, 'mie-ayam-bakso.jpg', 0, 1, 21),
  ('Nasi Goreng Udang Special', 18000, 3, 'nasi-goreng-udang.jpg', 1, 1, 22),
  ('Roti Bakar', 15000, 4, 'roti-bakar.jpg', 0, 1, 23);
