<?php
// Variabel yang diisi tiap halaman sebelum include: $title
$halaman = basename($_SERVER['SCRIPT_NAME'], '.php');
$nav = [
    'index'   => 'Beranda',
    'tentang' => 'Tentang Kami',
    'menu'    => 'Menu',
    'gallery' => 'Galeri',
    'kontak'  => 'Lokasi & Kontak',
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?> | <?= e($config['nama']) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500&family=Playfair+Display:wght@500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="navbar">
  <div class="container">
    <a href="index.php" class="logo" aria-label="CozyHouse">Cozy<br>house.</a>
    <button class="nav-toggle" aria-label="Buka menu" aria-expanded="false">&#9776;</button>
    <ul class="nav-links">
      <?php foreach ($nav as $file => $label): ?>
        <li><a href="<?= $file ?>.php"<?= $file === $halaman ? ' class="active" aria-current="page"' : '' ?>><?= e($label) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</header>
