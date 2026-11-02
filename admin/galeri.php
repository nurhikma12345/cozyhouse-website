<?php
require __DIR__ . '/includes/bootstrap.php';
wajib_login($conn);

$judul = 'Kelola Galeri';
$menu_aktif = 'galeri';

$foto = $conn->query('SELECT id_galeri, judul_foto, kategori, gambar FROM galeri ORDER BY id_galeri ASC')->fetch_all(MYSQLI_ASSOC);

include __DIR__ . '/includes/layout_header.php';
?>
<section class="card">
  <div class="card-head">
    <h2><?= count($foto) ?> foto</h2>
    <a class="btn" href="galeri_form.php">+ Tambah foto</a>
  </div>

  <?php if ($foto): ?>
  <div class="gallery-grid">
    <?php foreach ($foto as $f): ?>
      <figure class="g-item">
        <img src="<?= e(url_gambar($f['gambar'])) ?>" alt="<?= e($f['judul_foto']) ?>" loading="lazy">
        <figcaption>
          <b><?= e($f['judul_foto']) ?></b>
          <small><?= e($f['kategori'] ?: 'Tanpa kategori') ?></small>
          <div class="actions">
            <a class="link" href="galeri_form.php?id=<?= (int) $f['id_galeri'] ?>">Edit</a>
            <form method="post" action="galeri_hapus.php" data-confirm="Hapus foto &quot;<?= e($f['judul_foto']) ?>&quot;?">
              <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $f['id_galeri'] ?>">
              <button class="link danger" type="submit">Hapus</button>
            </form>
          </div>
        </figcaption>
      </figure>
    <?php endforeach; ?>
  </div>
  <?php else: ?>
    <p class="empty">Belum ada foto galeri.</p>
  <?php endif; ?>
</section>
<?php include __DIR__ . '/includes/layout_footer.php'; ?>
