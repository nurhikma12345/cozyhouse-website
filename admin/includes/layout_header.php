<?php
// Variabel dari halaman: $judul (wajib), $menu_aktif (kunci menu di sidebar)
$admin = admin_saat_ini();
$nav = [
    'dashboard' => ['index.php',    'Dashboard',  '<path d="M3 11l9-8 9 8v9a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/>'],
    'menu'      => ['menu.php',     'Menu',       '<path d="M6 2v8a3 3 0 0 0 3 3v9M9 2v8M12 2v20M17 2c-2 2-3 5-3 8h3v12"/>'],
    'kategori'  => ['kategori.php', 'Kategori',   '<path d="M3 3h8v8H3zM13 3h8v8h-8zM3 13h8v8H3zM13 13h8v8h-8z"/>'],
    'galeri'    => ['galeri.php',   'Galeri',     '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="1.6"/><path d="M21 16l-5-5-8 8"/>'],
    'profil'    => ['profil.php',   'Profil Cafe','<path d="M4 21V8l8-5 8 5v13M9 21v-6h6v6"/>'],
    'akun'      => ['akun.php',     'Akun Saya',  '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e($judul) ?> | Admin CozyHouse</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:wght@500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
<div class="shell">
  <aside class="sidebar" id="sidebar">
    <a href="index.php" class="brand">Cozy<br>house.<small>Panel Admin</small></a>
    <nav>
      <?php foreach ($nav as $kunci => [$url, $label, $ikon]): ?>
        <a href="<?= $url ?>"<?= ($menu_aktif ?? '') === $kunci ? ' class="active" aria-current="page"' : '' ?>>
          <svg viewBox="0 0 24 24" aria-hidden="true"><?= $ikon ?></svg><?= e($label) ?>
        </a>
      <?php endforeach; ?>
    </nav>
    <div class="side-foot">
      <a href="../index.php" target="_blank" rel="noopener">Lihat Website &#8599;</a>
      <form method="post" action="logout.php"><?= csrf_field() ?><button type="submit">Keluar</button></form>
    </div>
  </aside>

  <div class="main">
    <header class="topbar">
      <button class="burger" id="burger" aria-label="Buka menu" aria-expanded="false">&#9776;</button>
      <h1><?= e($judul) ?></h1>
      <div class="who"><span><?= e($admin['nama'] ?? '') ?></span><i><?= e(strtoupper(substr($admin['nama'] ?? 'A', 0, 1))) ?></i></div>
    </header>
    <main class="content">
      <?php foreach (ambil_flash() as $f): ?>
        <div class="alert <?= e($f['tipe']) ?>" role="status"><?= e($f['pesan']) ?></div>
      <?php endforeach; ?>
