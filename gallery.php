<?php
require __DIR__ . '/includes/bootstrap.php';
$title   = 'Galeri';
$scripts = ['gallery'];

// Tambah foto baru cukup dengan menambah satu baris di sini.
$foto = [
    ['galeri-1.jpg', 'Pengunjung CozyHouse'],
    ['galeri-2.jpg', 'Sudut dekorasi cafe'],
    ['galeri-3.jpg', 'Area santai'],
    ['galeri-4.jpg', 'Minuman segar'],
    ['galeri-5.jpg', 'Permainan di cafe'],
    ['galeri-6.jpg', 'Suasana malam'],
];
include __DIR__ . '/includes/header.php';
?>

<!-- ===== GALERI ===== -->
<section class="page-head">
  <div class="container">
    <p class="eyebrow">A GLIMPSE OF COZYHOUSE</p>
    <h1>Galeri</h1>
    <p>Lihat suasana cafe, menu, dan kegiatan di CozyHouse.</p>
  </div>
</section>

<section class="container gallery" id="foto">
  <?php foreach ($foto as [$file, $alt]): ?>
    <div class="photo"><img src="assets/images/<?= e($file) ?>" alt="<?= e($alt) ?>" loading="lazy"></div>
  <?php endforeach; ?>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
