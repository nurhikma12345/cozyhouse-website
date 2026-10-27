<?php
require __DIR__ . '/includes/bootstrap.php';
$title = 'Beranda';
$favorit = array_filter(ambil_menu($conn), fn($m) => (int) $m['favorit'] === 1);
include __DIR__ . '/includes/header.php';
?>

<!-- ===== HERO ===== -->
<section class="hero" id="hero">
  <div class="container">
    <div>
      <p class="eyebrow">A LITTLE PLACE TO FEEL AT HOME</p>
      <h1>Temukan nyamanmu di CozyHouse. &#10022;</h1>
      <a href="menu.php" class="btn">Jelajahi Menu</a>
      <small>Hangat &bull; Nyaman &bull; Bersahaja</small>
    </div>
    <div class="photo"><img src="assets/images/hero.jpg" alt="Suasana CozyHouse"></div>
  </div>
</section>

<!-- ===== MENU FAVORIT ===== -->
<section class="section" id="favorit">
  <div class="container">
    <h2>Menu favorit</h2>
    <p class="sub">Pilihan favorit untuk menemani obrolan dan momen kecil.</p>
    <div class="menu-grid">
      <?php foreach ($favorit as $m) kartu_menu($m); ?>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
