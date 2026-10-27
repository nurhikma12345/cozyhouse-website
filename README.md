# Website Cafe CozyHouse

- **Mitra:** Cafe CozyHouse, Binturu, Kota Palopo, Sulawesi Selatan
- **Teknologi:** HTML, CSS, JavaScript, PHP, MySQL/MariaDB, Laragon, VS Code

## Struktur Proyek

```
CozyHouse/
├── index.php        Beranda (hero + menu favorit)
├── tentang.php      Tentang Kami
├── menu.php         Daftar menu + filter kategori
├── gallery.php      Galeri foto + lightbox
├── kontak.php       Lokasi, kontak, media sosial
├── config/
│   ├── config.php        Data cafe (alamat, telepon, sosmed)
│   ├── db.php            Koneksi database
│   └── menu_default.php  Data cadangan jika database belum diimpor
├── includes/
│   ├── bootstrap.php     Memuat config, db, functions
│   ├── functions.php     Fungsi bantu (e, rupiah, ambil_menu, kartu_menu)
│   ├── header.php        Navbar (dipakai semua halaman)
│   └── footer.php        Footer + pemanggil script
├── assets/
│   ├── css/style.css
│   ├── js/main.js        Navbar mobile + placeholder foto (semua halaman)
│   ├── js/menu.js        Filter menu
│   ├── js/gallery.js     Lightbox galeri
│   ├── js/lokasi.js      Status buka/tutup + salin alamat
│   └── images/           Foto (lihat daftar di bawah)
└── database/cozyhouse.sql
```

## Cara Menjalankan (Laragon)

1. Salin folder `CozyHouse` ke `C:\laragon\www\`.
2. Buka Laragon, klik **Start All** (Apache dan MySQL).
3. Impor database: buka phpMyAdmin (atau HeidiSQL dari Laragon), lalu impor `database/cozyhouse.sql`.
4. Buka `http://localhost/CozyHouse/` atau `http://cozyhouse.test`.

Kalau database belum diimpor, website tetap tampil memakai data cadangan di `config/menu_default.php`.

## Daftar Foto di `assets/images/`

`hero.jpg`, `tentang.jpg`, `nasi-ayam-goreng.jpg`, `mie-jebew.jpg`, `ice-chocolate.jpg`, `nasi-goreng-udang.jpg`,
`greentea.jpg`, `cream-cookies.jpg`, `calamansy.jpg`, `ice-coffee-aren.jpg`, `cheese-cake.jpg`,
`mie-ayam-bakso.jpg`, `roti-bakar.jpg`, `galeri-1.jpg` sampai `galeri-6.jpg`

## Mengubah Isi

- **Alamat, telepon, sosmed:** `config/config.php`
- **Menu & harga:** tabel `menu` di database (atau `config/menu_default.php` untuk data cadangan)
- **Foto galeri:** daftar `$foto` di `gallery.php`
- **Menu navigasi:** daftar `$nav` di `includes/header.php`
