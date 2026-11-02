<?php
require __DIR__ . '/includes/bootstrap.php';
wajib_login($conn);

$judul = 'Akun Saya';
$menu_aktif = 'akun';
$me = admin_saat_ini();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_wajib();
    $nama = trim($_POST['nama_lengkap'] ?? '');
    $user = trim($_POST['username'] ?? '');
    $lama = (string) ($_POST['password_lama'] ?? '');
    $baru = (string) ($_POST['password_baru'] ?? '');
    $ulang = (string) ($_POST['password_ulang'] ?? '');

    $stmt = $conn->prepare('SELECT password_hash FROM admin WHERE id_admin = ?');
    $stmt->bind_param('i', $me['id']);
    $stmt->execute();
    $hash = $stmt->get_result()->fetch_row()[0] ?? '';

    if ($nama === '') $errors[] = 'Nama lengkap wajib diisi.';
    if (!preg_match('/^[A-Za-z0-9_.-]{3,50}$/', $user)) $errors[] = 'Username 3-50 karakter: huruf, angka, titik, garis bawah, atau strip.';
    else {
        $cek = $conn->prepare('SELECT 1 FROM admin WHERE username = ? AND id_admin <> ?');
        $cek->bind_param('si', $user, $me['id']);
        $cek->execute();
        if ($cek->get_result()->fetch_row()) $errors[] = 'Username sudah dipakai.';
    }
    if (!password_verify($lama, $hash)) $errors[] = 'Password saat ini salah.';
    if ($baru !== '') {
        if (strlen($baru) < 8) $errors[] = 'Password baru minimal 8 karakter.';
        if ($baru !== $ulang) $errors[] = 'Konfirmasi password baru tidak sama.';
    }

    if (!$errors) {
        if ($baru !== '') {
            $h = password_hash($baru, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('UPDATE admin SET username = ?, nama_lengkap = ?, password_hash = ? WHERE id_admin = ?');
            $stmt->bind_param('sssi', $user, $nama, $h, $me['id']);
        } else {
            $stmt = $conn->prepare('UPDATE admin SET username = ?, nama_lengkap = ? WHERE id_admin = ?');
            $stmt->bind_param('ssi', $user, $nama, $me['id']);
        }
        $stmt->execute();
        $_SESSION['admin']['nama'] = $nama;
        $_SESSION['admin']['user'] = $user;
        if ($baru !== '') session_regenerate_id(true);
        flash('success', $baru !== '' ? 'Akun dan password diperbarui.' : 'Akun diperbarui.');
        redirect('akun.php');
    }
}

include __DIR__ . '/includes/layout_header.php';
?>
<?php foreach ($errors as $er): ?><div class="alert error" role="alert"><?= e($er) ?></div><?php endforeach; ?>
<form class="card form narrow" method="post">
  <?= csrf_field() ?>
  <label>Username<input type="text" name="username" maxlength="50" required value="<?= e($_POST['username'] ?? $me['user']) ?>"></label>
  <label>Nama lengkap<input type="text" name="nama_lengkap" maxlength="100" required value="<?= e($_POST['nama_lengkap'] ?? $me['nama']) ?>"></label>
  <hr>
  <label>Password baru <small>(kosongkan jika tidak diganti, minimal 8 karakter)</small><input type="password" name="password_baru" autocomplete="new-password"></label>
  <label>Ulangi password baru<input type="password" name="password_ulang" autocomplete="new-password"></label>
  <hr>
  <label>Password saat ini <small>(wajib untuk menyimpan)</small><input type="password" name="password_lama" required autocomplete="current-password"></label>
  <div class="form-actions"><button class="btn" type="submit">Simpan</button></div>
</form>
<?php include __DIR__ . '/includes/layout_footer.php'; ?>
