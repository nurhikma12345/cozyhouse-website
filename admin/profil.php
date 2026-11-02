<?php
require __DIR__ . '/includes/bootstrap.php';
wajib_login($conn);

$judul = 'Profil Cafe';
$menu_aktif = 'profil';

$adaTentang = kolom_ada($conn, 'profil_cafe', 'gambar_tentang');

$data = $conn->query('SELECT * FROM profil_cafe WHERE id_profil = 1 LIMIT 1')->fetch_assoc();
if (!$data) {
    $conn->query("INSERT INTO profil_cafe (id_profil, nama_cafe) VALUES (1, 'Cafe CozyHouse')");
    $data = $conn->query('SELECT * FROM profil_cafe WHERE id_profil = 1 LIMIT 1')->fetch_assoc();
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_wajib();

    $nama = trim($_POST['nama_cafe'] ?? '');
    $desk = trim($_POST['deskripsi'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $jam = trim($_POST['jam_operasional'] ?? '');
    $wa = trim($_POST['whatsapp'] ?? '');
    $ig = trim($_POST['instagram'] ?? '');
    $tel = trim($_POST['telepon'] ?? '');

    if ($nama === '') $errors[] = 'Nama cafe wajib diisi.';
    if (!preg_match('/^[0-9+\s-]*$/', $wa . $tel)) $errors[] = 'Nomor telepon/WhatsApp hanya boleh berisi angka.';

    $hero = $data['gambar_hero'];
    $up = simpan_upload('gambar_hero', 'hero');
    if (is_string($up) && str_starts_with($up, 'ERR:')) $errors[] = 'Foto hero: ' . substr($up, 4);
    elseif ($up !== null) $hero = $up;

    $tentang = $data['gambar_tentang'] ?? null;
    if ($adaTentang) {
        $up = simpan_upload('gambar_tentang', 'tentang');
        if (is_string($up) && str_starts_with($up, 'ERR:')) $errors[] = 'Foto tentang: ' . substr($up, 4);
        elseif ($up !== null) $tentang = $up;
    }

    $data = array_merge($data, [
        'nama_cafe' => $nama, 'deskripsi' => $desk, 'alamat' => $alamat, 'jam_operasional' => $jam,
        'whatsapp' => $wa, 'instagram' => $ig, 'telepon' => $tel, 'gambar_hero' => $hero,
    ]);
    if ($adaTentang) $data['gambar_tentang'] = $tentang;

    if (!$errors) {
        if ($adaTentang) {
            $stmt = $conn->prepare('UPDATE profil_cafe SET nama_cafe=?, deskripsi=?, alamat=?, jam_operasional=?, whatsapp=?, instagram=?, telepon=?, gambar_hero=?, gambar_tentang=? WHERE id_profil=1');
            $stmt->bind_param('sssssssss', $nama, $desk, $alamat, $jam, $wa, $ig, $tel, $hero, $tentang);
        } else {
            $stmt = $conn->prepare('UPDATE profil_cafe SET nama_cafe=?, deskripsi=?, alamat=?, jam_operasional=?, whatsapp=?, instagram=?, telepon=?, gambar_hero=? WHERE id_profil=1');
            $stmt->bind_param('ssssssss', $nama, $desk, $alamat, $jam, $wa, $ig, $tel, $hero);
        }
        if ($stmt->execute()) {
            flash('success', 'Profil cafe disimpan.');
            redirect('profil.php');
        }
        $errors[] = 'Gagal menyimpan ke database.';
    }
}

include __DIR__ . '/includes/layout_header.php';
?>
<?php foreach ($errors as $er): ?><div class="alert error" role="alert"><?= e($er) ?></div><?php endforeach; ?>

<div class="alert info">
  Foto <b>hero</b> (beranda) dan foto <b>Tentang Kami</b> langsung dibaca website dari halaman ini.
  Alamat, telepon, jam buka, dan sosmed di halaman <i>Lokasi &amp; Kontak</i> website masih dibaca dari <code>config/config.php</code>.
</div>

<form class="card form" method="post" enctype="multipart/form-data">
  <?= csrf_field() ?>
  <div class="form-grid">
    <div class="fields">
      <label>Nama cafe<input type="text" name="nama_cafe" maxlength="100" required value="<?= e($data['nama_cafe']) ?>"></label>
      <label>Deskripsi singkat<textarea name="deskripsi" rows="3"><?= e($data['deskripsi']) ?></textarea></label>
      <label>Alamat<textarea name="alamat" rows="2"><?= e($data['alamat']) ?></textarea></label>
      <label>Jam operasional<input type="text" name="jam_operasional" maxlength="100" value="<?= e($data['jam_operasional']) ?>"></label>
      <div class="row">
        <label>WhatsApp<input type="text" name="whatsapp" maxlength="20" value="<?= e($data['whatsapp']) ?>" placeholder="6285787377112"></label>
        <label>Telepon<input type="text" name="telepon" maxlength="20" value="<?= e($data['telepon']) ?>"></label>
      </div>
      <label>Instagram<input type="text" name="instagram" maxlength="100" value="<?= e($data['instagram']) ?>" placeholder="@cozy_house_palopo"></label>
    </div>

    <div class="upload">
      <span class="label">Foto hero (beranda)</span>
      <div class="preview" id="prev-hero"><?php if ($data['gambar_hero']): ?><img src="<?= e(url_gambar($data['gambar_hero'])) ?>" alt="Hero saat ini"><?php else: ?><span>Belum ada foto</span><?php endif; ?></div>
      <input type="file" name="gambar_hero" accept="image/jpeg,image/png,image/webp" data-preview="prev-hero">

      <?php if ($adaTentang): ?>
        <span class="label" style="margin-top:18px">Foto Tentang Kami</span>
        <div class="preview" id="prev-tentang"><?php if (!empty($data['gambar_tentang'])): ?><img src="<?= e(url_gambar($data['gambar_tentang'])) ?>" alt="Tentang saat ini"><?php else: ?><span>Memakai foto bawaan</span><?php endif; ?></div>
        <input type="file" name="gambar_tentang" accept="image/jpeg,image/png,image/webp" data-preview="prev-tentang">
      <?php else: ?>
        <small class="note">Kolom <code>gambar_tentang</code> belum ada di database, jadi foto Tentang Kami belum bisa diganti. Lihat petunjuk di <code>admin/database/admin.sql</code>.</small>
      <?php endif; ?>
      <small>JPG, PNG, atau WEBP. Maks 3 MB. Kosongkan jika tidak ingin mengganti.</small>
    </div>
  </div>
  <div class="form-actions"><button class="btn" type="submit">Simpan</button></div>
</form>
<?php include __DIR__ . '/includes/layout_footer.php'; ?>
