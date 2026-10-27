<?php
// Dipanggil di paling atas setiap halaman: memuat konfigurasi, database, dan fungsi bantu.
$config = require __DIR__ . '/../config/config.php';
require __DIR__ . '/../config/db.php';      // menghasilkan $conn (null jika gagal)
require __DIR__ . '/functions.php';
