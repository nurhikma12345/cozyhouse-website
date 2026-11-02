<?php
require __DIR__ . '/includes/bootstrap.php';
wajib_login($conn);

$judul = 'Dashboard';
$menu_aktif = 'dashboard';

$hitung = fn(string $sql): int => (int) ($conn->query($sql)->fetch_row()[0] ?? 0);
$stat = [
    'Total menu'     => $hitung('SELECT COUNT(*) FROM menu'),
    'Menu favorit'   => $hitung('SELECT COUNT(*) FROM menu WHERE favorit = 1'),
    'Kategori'       => $hitung('SELECT COUNT(*) FROM kategori_menu'),
    'Foto galeri'    => $hitung('SELECT COUNT(*) FROM galeri'),
];

$perKategori = $conn->query(
    'SELECT k.nama_kategori, COUNT(m.id_menu) AS jml
     FROM kategori_menu k LEFT JOIN menu m ON m.id_kategori = k.id_kategori
     GROUP BY k.id_kategori ORDER BY k.id_kategori'
)->fetch_all(MYSQLI_ASSOC);
$maks = max(1, ...array_column($perKategori ?: [['jml' => 1]], 'jml'));

$terbaru = $conn->query(
    'SELECT m.id_menu, m.nama_menu, m.harga, m.gambar, k.nama_kategori
     FROM menu m LEFT JOIN kategori_menu k ON k.id_kategori = m.id_kategori
     ORDER BY m.id_menu DESC LIMIT 6'
)->fetch_all(MYSQLI_ASSOC);

$tanpaKategori = $hitung('SELECT COUNT(*) FROM menu WHERE id_kategori IS NULL');

include __DIR__ . '/includes/layout_header.php';
?>
<?php if ($tanpaKategori > 0): ?>
  <div class="alert warn"><?= $tanpaKategori ?> menu belum punya kategori sehingga <b>tidak tampil di website</b>. <a href="menu.php?kategori=0">Perbaiki sekarang</a></div>
<?php endif; ?>

<div class="stats">
  <?php foreach ($stat as $label => $n): ?>
    <div class="stat"><span><?= e($label) ?></span><b><?= $n ?></b></div>
  <?php endforeach; ?>
</div>

<div class="grid-2">
  <section class="card">
    <div class="card-head"><h2>Menu per kategori</h2></div>
    <ul class="bars">
      <?php foreach ($perKategori as $k): ?>
        <li>
          <span><?= e($k['nama_kategori']) ?></span>
          <div class="bar"><i style="width:<?= round($k['jml'] / $maks * 100) ?>%"></i></div>
          <b><?= (int) $k['jml'] ?></b>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>

  <section class="card">
    <div class="card-head"><h2>Aksi cepat</h2></div>
    <div class="quick">
      <a class="btn" href="menu_form.php">+ Tambah menu</a>
      <a class="btn ghost" href="galeri_form.php">+ Tambah foto galeri</a>
      <a class="btn ghost" href="kategori.php">Kelola kategori</a>
      <a class="btn ghost" href="profil.php">Ubah foto hero</a>
    </div>
  </section>
</div>

<section class="card">
  <div class="card-head"><h2>Menu terbaru</h2><a class="link" href="menu.php">Lihat semua &rarr;</a></div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Foto</th><th>Nama</th><th>Kategori</th><th>Harga</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($terbaru as $m): ?>
        <tr>
          <td><img class="thumb" src="<?= e(url_gambar($m['gambar'])) ?>" alt="" loading="lazy"></td>
          <td><?= e($m['nama_menu']) ?></td>
          <td><?= e($m['nama_kategori'] ?? '—') ?></td>
          <td><?= e(rupiah($m['harga'])) ?></td>
          <td class="right"><a class="link" href="menu_form.php?id=<?= (int) $m['id_menu'] ?>">Edit</a></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$terbaru): ?><tr><td colspan="5" class="empty">Belum ada menu.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</section>
<?php include __DIR__ . '/includes/layout_footer.php'; ?>
