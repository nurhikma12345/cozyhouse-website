<?php
require __DIR__ . '/includes/bootstrap.php';
wajib_login($conn);

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$menu_aktif = 'menu';

$kategori = $conn->query('SELECT id_kategori, nama_kategori FROM kategori_menu ORDER BY id_kategori')->fetch_all(MYSQLI_ASSOC);

$data = ['nama_menu' => '', 'id_kategori' => '', 'harga' => '', 'deskripsi' => '', 'gambar' => '', 'favorit' => 0];
if ($id) {
    $stmt = $conn->prepare('SELECT * FROM menu WHERE id_menu = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    if (!$data) {
        flash('error', 'Menu tidak ditemukan.');
        redirect('menu.php');
    }
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_wajib();

    $nama      = trim($_POST['nama_menu'] ?? '');
    $idKat     = (int) ($_POST['id_kategori'] ?? 0);
    $harga     = (int) preg_replace('/\D/', '', $_POST['harga'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $favorit   = isset($_POST['favorit']) ? 1 : 0;

    if ($nama === '' || mb_strlen($nama) > 100) $errors[] = 'Nama menu wajib diisi (maksimal 100 karakter).';
    if (!in_array($idKat, array_map('intval', array_column($kategori, 'id_kategori')), true)) {
        $errors[] = 'Pilih kategori.';
    }
    if ($harga <= 0) $errors[] = 'Harga harus lebih dari 0.';

    $gambar = $data['gambar'];
    $up = simpan_upload('gambar', $nama);
    if (is_string($up) && str_starts_with($up, 'ERR:')) {
        $errors[] = substr($up, 4);
    } elseif ($up !== null) {
        $gambar = $up;
    }
    if (!$errors && $gambar === '') $errors[] = 'Foto menu wajib diunggah.';

    // Pertahankan isian jika ada error.
    $data = array_merge($data, ['nama_menu' => $nama, 'id_kategori' => $idKat, 'harga' => $harga, 'deskripsi' => $deskripsi, 'favorit' => $favorit, 'gambar' => $gambar]);

    if (!$errors) {
        $desk = $deskripsi === '' ? null : $deskripsi;
        if ($id) {
            $stmt = $conn->prepare('UPDATE menu SET nama_menu=?, id_kategori=?, harga=?, deskripsi=?, gambar=?, favorit=? WHERE id_menu=?');
            $stmt->bind_param('siissii', $nama, $idKat, $harga, $desk, $gambar, $favorit, $id);
        } else {
            $stmt = $conn->prepare('INSERT INTO menu (nama_menu, id_kategori, harga, deskripsi, gambar, favorit) VALUES (?,?,?,?,?,?)');
            $stmt->bind_param('siissi', $nama, $idKat, $harga, $desk, $gambar, $favorit);
        }
        if ($stmt->execute()) {
            flash('success', $id ? 'Menu berhasil diperbarui.' : 'Menu baru berhasil ditambahkan.');
            redirect('menu.php');
        }
        $errors[] = 'Gagal menyimpan ke database.';
    }
}

$judul = $id ? 'Edit Menu' : 'Tambah Menu';
include __DIR__ . '/includes/layout_header.php';
?>
<?php foreach ($errors as $er): ?><div class="alert error" role="alert"><?= e($er) ?></div><?php endforeach; ?>

<form class="card form" method="post" enctype="multipart/form-data">
  <?= csrf_field() ?><input type="hidden" name="id" value="<?= $id ?>">

  <div class="form-grid">
    <div class="fields">
      <label>Nama menu
        <input type="text" name="nama_menu" maxlength="100" required value="<?= e($data['nama_menu']) ?>">
      </label>
      <div class="row">
        <label>Kategori
          <select name="id_kategori" required>
            <option value="">— Pilih —</option>
            <?php foreach ($kategori as $k): ?>
              <option value="<?= (int) $k['id_kategori'] ?>"<?= (int) $data['id_kategori'] === (int) $k['id_kategori'] ? ' selected' : '' ?>><?= e($k['nama_kategori']) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>Harga (Rp)
          <input type="text" name="harga" inputmode="numeric" required value="<?= $data['harga'] !== '' ? (int) $data['harga'] : '' ?>" placeholder="16000">
        </label>
      </div>
      <label>Deskripsi <small>(opsional)</small>
        <textarea name="deskripsi" rows="4"><?= e($data['deskripsi']) ?></textarea>
      </label>
      <label class="check">
        <input type="checkbox" name="favorit" value="1"<?= $data['favorit'] ? ' checked' : '' ?>>
        Tampilkan sebagai <b>menu favorit</b> di beranda
      </label>
    </div>

    <div class="upload">
      <span class="label">Foto menu</span>
      <div class="preview" id="preview">
        <?php if ($data['gambar']): ?><img src="<?= e(url_gambar($data['gambar'])) ?>" alt="Foto saat ini"><?php else: ?><span>Belum ada foto</span><?php endif; ?>
      </div>
      <input type="file" name="gambar" accept="image/jpeg,image/png,image/webp" data-preview="preview">
      <small>JPG, PNG, atau WEBP. Maks 3 MB.<?= $id ? ' Kosongkan jika tidak ingin mengganti.' : '' ?></small>
    </div>
  </div>

  <div class="form-actions">
    <button class="btn" type="submit">Simpan</button>
    <a class="btn ghost" href="menu.php">Batal</a>
  </div>
</form>
<?php include __DIR__ . '/includes/layout_footer.php'; ?>
