<?php
require __DIR__ . '/includes/bootstrap.php';
$title   = 'Menu';
$scripts = ['menu'];

$semua = ambil_menu($conn);
$minuman = array_filter($semua, fn($m) => grup_menu($m['kategori']) === 'minuman');
$makanan = array_filter($semua, fn($m) => grup_menu($m['kategori']) === 'makanan');
$filter  = ['all' => 'Semua', 'coffee' => 'Coffee', 'non-coffee' => 'Non Coffee', 'makanan' => 'Makanan', 'snack' => 'Snack'];
include __DIR__ . '/includes/header.php';
?>

<!-- ===== MENU ===== -->
<section class="page-head">
  <div class="container">
    <p class="eyebrow">MADE WITH CARE</p>
    <h1>Menu Kami</h1>
    <p>Pilihan makanan dan minuman untuk menemani waktu Anda.</p>
  </div>
</section>

<section class="container" id="daftar-menu" style="padding-bottom:40px">
  <div class="filters" role="group" aria-label="Kategori menu">
    <?php foreach ($filter as $kunci => $label): ?>
      <button class="chip<?= $kunci === 'all' ? ' active' : '' ?>" data-filter="<?= e($kunci) ?>"><?= e($label) ?></button>
    <?php endforeach; ?>
  </div>

  <div class="menu-grid">
    <?php foreach ($minuman as $m) kartu_menu($m); ?>
  </div>

  <h2 class="group-title">Makanan &amp; Snack</h2>
  <div class="menu-grid">
    <?php foreach ($makanan as $m) kartu_menu($m); ?>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
