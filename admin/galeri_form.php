<?php
require __DIR__ . '/includes/bootstrap.php';
wajib_login($conn);

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$menu_aktif = 'galeri';

$data = ['judul_foto' => '', 'kategori' => '', 'gambar' => '', 'deskripsi' => ''];
if ($id) {
    $stmt = $conn->prepare('SELECT * FROM galeri WHERE id_galeri = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    if (!$data) {
        flash('error', 'Foto tidak ditemukan.');
        redirect('galeri.php');
    }
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_wajib();

    $judul_foto = trim($_POST['judul_foto'] ?? '');
    $kategori   = trim($_POST['kategori'] ?? '');
    $deskripsi  = trim($_POST['deskripsi'] ?? '');

    if ($judul_foto === '' || mb_strlen($judul_foto) > 100) $errors[] = 'Judul foto wajib diisi (maksimal 100 karakter).';
    if (mb_strlen($kategori) > 50) $errors[] = 'Kategori maksimal 50 karakter.';

    $gambar = $data['gambar'];
    $up = simpan_upload('gambar', 'galeri-' . $judul_foto);
    if (is_string($up) && str_starts_with($up, 'ERR:')) {
        $errors[] = substr($up, 4);
    } elseif ($up !== null) {
        $gambar = $up;
    }
    if (!$errors && $gambar === '') $errors[] = 'Foto wajib diunggah.';

    $data = array_merge($data, ['judul_foto' => $judul_foto, 'kategori' => $kategori, 'deskripsi' => $deskripsi, 'gambar' => $gambar]);

    if (!$errors) {
        $kat  = $kategori === '' ? null : $kategori;
        $desk = $deskripsi === '' ? null : $deskripsi;
        if ($id) {
            $stmt = $conn->prepare('UPDATE galeri SET judul_foto=?, kategori=?, gambar=?, deskripsi=? WHERE id_galeri=?');
            $stmt->bind_param('ssssi', $judul_foto, $kat, $gambar, $desk, $id);
        } else {
            $stmt = $conn->prepare('INSERT INTO galeri (judul_foto, kategori, gambar, deskripsi) VALUES (?,?,?,?)');
            $stmt->bind_param('ssss', $judul_foto, $kat, $gambar, $desk);
        }
        if ($stmt->execute()) {
            flash('success', $id ? 'Foto berhasil diperbarui.' : 'Foto berhasil ditambahkan.');
            redirect('galeri.php');
        }
        $errors[] = 'Gagal menyimpan ke database.';
    }
}

$judul = $id ? 'Edit Foto Galeri' : 'Tambah Foto Galeri';
include __DIR__ . '/includes/layout_header.php';
?>
<?php foreach ($errors as $er): ?><div class="alert error" role="alert"><?= e($er) ?></div><?php endforeach; ?>

<form class="card form" method="post" enctype="multipart/form-data">
  <?= csrf_field() ?><input type="hidden" name="id" value="<?= $id ?>">
  <div class="form-grid">
    <div class="fields">
      <label>Judul foto<input type="text" name="judul_foto" maxlength="100" required value="<?= e($data['judul_foto']) ?>"></label>
      <label>Kategori <small>(contoh: Suasana Cafe, Menu, Dekorasi)</small>
        <input type="text" name="kategori" maxlength="50" list="saran-kat" value="<?= e($data['kategori']) ?>">
        <datalist id="saran-kat"><option>Suasana Cafe</option><option>Menu</option><option>Dekorasi</option><option>Aktivitas</option></datalist>
      </label>
      <label>Deskripsi <small>(opsional)</small><textarea name="deskripsi" rows="4"><?= e($data['deskripsi']) ?></textarea></label>
    </div>
    <div class="upload">
      <span class="label">Foto</span>
      <div class="preview" id="preview">
        <?php if ($data['gambar']): ?><img src="<?= e(url_gambar($data['gambar'])) ?>" alt="Foto saat ini"><?php else: ?><span>Belum ada foto</span><?php endif; ?>
      </div>
      <input type="file" name="gambar" accept="image/jpeg,image/png,image/webp" data-preview="preview">
      <small>JPG, PNG, atau WEBP. Maks 3 MB.<?= $id ? ' Kosongkan jika tidak ingin mengganti.' : '' ?></small>
    </div>
  </div>
  <div class="form-actions">
    <button class="btn" type="submit">Simpan</button>
    <a class="btn ghost" href="galeri.php">Batal</a>
  </div>
</form>
<?php include __DIR__ . '/includes/layout_footer.php'; ?>
