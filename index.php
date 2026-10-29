
<?php
require __DIR__ . '/includes/bootstrap.php';

$title = 'Beranda';

// Gambar cadangan jika database tidak tersedia.
$gambarHero = 'assets/images/hero.jpg';

// Ambil nama gambar dari database.
if ($conn) {
    $hasilHero = $conn->query(
        "SELECT gambar_hero
         FROM profil_cafe
         WHERE id_profil = 1
         LIMIT 1"
    );

    if ($hasilHero && ($dataHero = $hasilHero->fetch_assoc())) {
        if (!empty($dataHero['gambar_hero'])) {
            $namaFileHero = basename($dataHero['gambar_hero']);
            $lokasiHero = __DIR__ . '/assets/images/' . $namaFileHero;

            if (is_file($lokasiHero)) {
                $gambarHero = 'assets/images/' . $namaFileHero;
            }
        }
    }
}

// Ambil menu favorit.
$favorit = array_filter(
    ambil_menu($conn),
    fn($m) => (int) $m['favorit'] === 1
);

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

<div class="photo">
    <img src="<?= e($gambarHero) ?>" alt="Suasana CozyHouse">
</div>
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
