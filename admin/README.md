# Panel Admin CozyHouse

Folder `admin/` berdiri sendiri: semua halaman, CSS, JS, dan fungsi admin ada di sini.
Website publik tidak diubah sama sekali. Admin memakai **database yang sama** (`config/db.php`)
dan menyimpan foto ke `assets/images/` supaya langsung tampil di website.

## Cara pasang

1. Salin folder `admin/` ke dalam `CozyHouse/` (sejajar dengan `index.php`).
2. Impor `admin/database/admin.sql` ke database `cozyhouse` (membuat tabel `admin`).
3. Buka `http://localhost/CozyHouse/admin/`
4. Login awal: **admin** / **admin123** — segera ganti username dan password di menu **Akun Saya**.

## Struktur

```
admin/
├── index.php          Dashboard (statistik, menu terbaru, aksi cepat)
├── login.php          Halaman masuk
├── logout.php         Keluar (POST + CSRF)
├── menu.php           Daftar menu + cari + filter kategori
├── menu_form.php      Tambah / edit menu (+ upload foto)
├── menu_hapus.php     Hapus menu
├── kategori.php       Tambah / ubah / hapus kategori
├── galeri.php         Daftar foto galeri
├── galeri_form.php    Tambah / edit foto galeri
├── galeri_hapus.php   Hapus foto galeri
├── profil.php         Profil cafe + foto hero (+ foto Tentang Kami)
├── akun.php           Ubah nama & password admin
├── includes/          bootstrap, auth, functions, layout_header, layout_footer
├── assets/css/admin.css
├── assets/js/admin.js
└── database/admin.sql
```

## Keamanan yang sudah ada

- Password disimpan sebagai hash (`password_hash`), login dibatasi 5 kali gagal per 5 menit.
- Semua form memakai token CSRF; hapus & logout hanya lewat POST.
- Semua query memakai prepared statement.
- Upload foto: dicek isi file (bukan hanya ekstensi), JPG/PNG/WEBP, maks 3 MB, nama file diacak.
- Sesi otomatis berakhir setelah 2 jam tidak aktif.

## Catatan

- Foto lama **tidak dihapus** dari `assets/images/` saat menu/foto dihapus atau diganti (aman jika file dipakai di tempat lain).
- Kategori yang masih dipakai menu tidak bisa dihapus (menu tanpa kategori tidak tampil di website).
- `tentang.php` membaca kolom `gambar_tentang` yang belum ada di `cozyhouse.sql`. Lihat baris `ALTER TABLE` (opsional) di `admin/database/admin.sql`.
- Alamat, telepon, jam buka, dan sosmed di halaman Lokasi & Kontak website masih dibaca dari `config/config.php`, bukan dari database.
- Untuk produksi: pasang HTTPS, dan pertimbangkan membatasi akses folder `admin/` (mis. via `.htaccess`).
