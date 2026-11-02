<?php
require __DIR__ . '/includes/bootstrap.php';
wajib_login($conn);

$judul = 'Kelola Menu';
$menu_aktif = 'menu';

$cari = trim($_GET['q'] ?? '');
$kat  = $_GET['kategori'] ?? '';

$kategori = $conn->query('SELECT id_kategori, nama_kategori FROM kategori_menu ORDER BY id_kategori')->fetch_all(MYSQLI_ASSOC);

$sql = 'SELECT m.id_menu, m.nama_menu, m.harga, m.gambar, m.favorit, k.nama_kategori
        FROM menu m LEFT JOIN kategori_menu k ON k.id_kategori = m.id_kategori WHERE 1=1';
$tipe = '';
$arg  = [];
if ($cari !== '') {
    $sql .= ' AND m.nama_menu LIKE ?';
    $tipe .= 's';
    $arg[] = '%' . $cari . '%';
}
if ($kat === '0') {
    $sql .= ' AND m.id_kategori IS NULL';
} elseif ($kat !== '' && ctype_digit($kat)) {
    $sql .= ' AND m.id_kategori = ?';
    $tipe .= 'i';
    $arg[] = (int) $kat;
}
$sql .= ' ORDER BY m.id_menu DESC';

$stmt = $conn->prepare($sql);
if ($arg) {
    $stmt->bind_param($tipe, ...$arg);
}
$stmt->execute();
$daftar = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

include __DIR__ . '/includes/layout_header.php';
?>
<section class="card">
  <div class="card-head">
    <form class="filter" method="get">
      <input type="search" name="q" placeholder="Cari nama menu…" value="<?= e($cari) ?>">
      <select name="kategori" aria-label="Kategori">
        <option value="">Semua kategori</option>
        <?php foreach ($kategori as $k): ?>
          <option value="<?= (int) $k['id_kategori'] ?>"<?= $kat === (string) $k['id_kategori'] ? ' selected' : '' ?>><?= e($k['nama_kategori']) ?></option>
        <?php endforeach; ?>
        <option value="0"<?= $kat === '0' ? ' selected' : '' ?>>(Tanpa kategori)</option>
      </select>
      <button class="btn ghost" type="submit">Terapkan</button>
    </form>
    <a class="btn" href="menu_form.php">+ Tambah menu</a>
  </div>

  <div class="table-wrap">
    <table>
      <thead><tr><th>Foto</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Favorit</th><th class="right">Aksi</th></tr></thead>
      <tbody>
      <?php foreach ($daftar as $m): ?>
        <tr>
          <td><img class="thumb" src="<?= e(url_gambar($m['gambar'])) ?>" alt="" loading="lazy"></td>
          <td><?= e($m['nama_menu']) ?></td>
          <td><?= $m['nama_kategori'] ? e($m['nama_kategori']) : '<span class="badge warn">Tanpa kategori</span>' ?></td>
          <td><?= e(rupiah($m['harga'])) ?></td>
          <td><?= $m['favorit'] ? '<span class="badge ok">&#9733; Favorit</span>' : '<span class="muted">—</span>' ?></td>
          <td class="right actions">
            <a class="link" href="menu_form.php?id=<?= (int) $m['id_menu'] ?>">Edit</a>
            <form method="post" action="menu_hapus.php" data-confirm="Hapus menu &quot;<?= e($m['nama_menu']) ?>&quot;?">
              <?= csrf_field() ?><input type="hidden" name="id" value="<?= (int) $m['id_menu'] ?>">
              <button class="link danger" type="submit">Hapus</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$daftar): ?><tr><td colspan="6" class="empty">Tidak ada menu yang cocok.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
  <p class="foot-note"><?= count($daftar) ?> menu ditampilkan</p>
</section>
<?php include __DIR__ . '/includes/layout_footer.php'; ?>
