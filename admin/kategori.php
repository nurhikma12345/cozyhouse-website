<?php
require __DIR__ . '/includes/bootstrap.php';
wajib_login($conn);

$judul = 'Kategori Menu';
$menu_aktif = 'kategori';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_wajib();
    $aksi = $_POST['aksi'] ?? '';
    $id   = (int) ($_POST['id'] ?? 0);
    $nama = trim($_POST['nama'] ?? '');

    if ($aksi === 'tambah' || $aksi === 'ubah') {
        if ($nama === '' || mb_strlen($nama) > 50) {
            flash('error', 'Nama kategori wajib diisi (maksimal 50 karakter).');
        } elseif ($aksi === 'tambah') {
            $stmt = $conn->prepare('INSERT INTO kategori_menu (nama_kategori) VALUES (?)');
            $stmt->bind_param('s', $nama);
            $stmt->execute();
            flash('success', 'Kategori ditambahkan.');
        } else {
            $stmt = $conn->prepare('UPDATE kategori_menu SET nama_kategori = ? WHERE id_kategori = ?');
            $stmt->bind_param('si', $nama, $id);
            $stmt->execute();
            flash('success', 'Kategori diperbarui.');
        }
    } elseif ($aksi === 'hapus') {
        $stmt = $conn->prepare('SELECT COUNT(*) FROM menu WHERE id_kategori = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ((int) $stmt->get_result()->fetch_row()[0] > 0) {
            flash('error', 'Kategori masih dipakai oleh menu. Pindahkan atau hapus menunya dulu.');
        } else {
            $stmt = $conn->prepare('DELETE FROM kategori_menu WHERE id_kategori = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
            flash('success', 'Kategori dihapus.');
        }
    }
    redirect('kategori.php');
}

$daftar = $conn->query(
    'SELECT k.id_kategori, k.nama_kategori, COUNT(m.id_menu) AS jml
     FROM kategori_menu k LEFT JOIN menu m ON m.id_kategori = k.id_kategori
     GROUP BY k.id_kategori ORDER BY k.id_kategori'
)->fetch_all(MYSQLI_ASSOC);

include __DIR__ . '/includes/layout_header.php';
?>
<div class="alert info">
  Website mengelompokkan menu berdasarkan nama kategori: <b>Coffee</b>, <b>Non Coffee</b>, <b>Makanan</b>, dan <b>Snack</b>.
  Kategori dengan nama lain akan tampil di grup <i>Makanan</i>. Jika mengganti nama kategori bawaan, filter di website bisa tidak cocok.
</div>

<div class="grid-2 wide-left">
  <section class="card">
    <div class="card-head"><h2>Daftar kategori</h2></div>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Nama</th><th>Jumlah menu</th><th class="right">Aksi</th></tr></thead>
        <tbody>
        <?php foreach ($daftar as $k): ?>
          <tr>
            <td>
              <form class="inline-edit" method="post">
                <?= csrf_field() ?><input type="hidden" name="aksi" value="ubah"><input type="hidden" name="id" value="<?= (int) $k['id_kategori'] ?>">
                <input type="text" name="nama" maxlength="50" value="<?= e($k['nama_kategori']) ?>" aria-label="Nama kategori" required>
                <button class="link" type="submit">Simpan</button>
              </form>
            </td>
            <td><?= (int) $k['jml'] ?></td>
            <td class="right">
              <form method="post" data-confirm="Hapus kategori &quot;<?= e($k['nama_kategori']) ?>&quot;?">
                <?= csrf_field() ?><input type="hidden" name="aksi" value="hapus"><input type="hidden" name="id" value="<?= (int) $k['id_kategori'] ?>">
                <button class="link danger" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (!$daftar): ?><tr><td colspan="3" class="empty">Belum ada kategori.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </section>

  <section class="card">
    <div class="card-head"><h2>Tambah kategori</h2></div>
    <form class="form" method="post">
      <?= csrf_field() ?><input type="hidden" name="aksi" value="tambah">
      <label>Nama kategori<input type="text" name="nama" maxlength="50" required></label>
      <div class="form-actions"><button class="btn" type="submit">Tambah</button></div>
    </form>
  </section>
</div>
<?php include __DIR__ . '/includes/layout_footer.php'; ?>
