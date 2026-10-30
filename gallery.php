
<?php
require __DIR__ . '/includes/bootstrap.php';

$title   = 'Galeri';
$scripts = [];

// Mengambil data foto dari database CozyHouse
$foto = [];
$errorGaleri = false;

if (isset($conn) && $conn instanceof mysqli) {
    $sql = "SELECT id_galeri, judul_foto, kategori, gambar, deskripsi
            FROM galeri
            ORDER BY id_galeri ASC";

    $hasil = $conn->query($sql);

    if ($hasil) {
        $foto = $hasil->fetch_all(MYSQLI_ASSOC);
    } else {
        $errorGaleri = true;
    }
} else {
    $errorGaleri = true;
}

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

<!-- ===== FOTO DARI DATABASE ===== -->
<section class="container gallery" id="foto">

  <?php if ($errorGaleri): ?>

    <p>Data galeri gagal dimuat. Periksa koneksi database.</p>

  <?php elseif (count($foto) > 0): ?>

    <?php foreach ($foto as $m): ?>
      <div class="photo">
        <img
          src="assets/images/<?= e($m['gambar']) ?>"
          alt="<?= e($m['judul_foto']) ?>"
          loading="lazy"
        >
      </div>
    <?php endforeach; ?>

  <?php else: ?>

    <p>Belum ada foto galeri.</p>

  <?php endif; ?>

</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
