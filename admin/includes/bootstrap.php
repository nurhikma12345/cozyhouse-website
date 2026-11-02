<?php
// Dipanggil di paling atas setiap halaman admin (kecuali login/logout).
// Memuat koneksi database yang SAMA dengan website utama, lalu fungsi bantu & sesi.
require __DIR__ . '/../../config/db.php';   // menghasilkan $conn (null jika gagal)
require __DIR__ . '/functions.php';
require __DIR__ . '/auth.php';

mulai_sesi();
