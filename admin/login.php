<?php
require __DIR__ . '/includes/bootstrap.php';

if (admin_saat_ini()) {
    redirect('index.php');
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_wajib();
    if (!$conn) {
        $error = 'Database tidak terhubung. Nyalakan MySQL di Laragon.';
    } else {
        $error = coba_login($conn, trim($_POST['username'] ?? ''), (string) ($_POST['password'] ?? ''));
        if ($error === null) {
            redirect('index.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Masuk | Admin CozyHouse</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="login-body">
  <form class="login-card" method="post" autocomplete="on">
    <p class="brand-big">Cozy<br>house.</p>
    <p class="muted">Masuk ke panel admin</p>

    <?php if (isset($_GET['expired'])): ?><div class="alert info">Sesi berakhir. Silakan masuk lagi.</div><?php endif; ?>
    <?php if ($error): ?><div class="alert error" role="alert"><?= e($error) ?></div><?php endif; ?>

    <?= csrf_field() ?>
    <label>Username
      <input type="text" name="username" required autofocus autocomplete="username" value="<?= e($_POST['username'] ?? '') ?>">
    </label>
    <label>Password
      <input type="password" name="password" required autocomplete="current-password">
    </label>
    <button class="btn" type="submit">Masuk</button>
    <a class="back" href="../index.php">&larr; Kembali ke website</a>
  </form>
</body>
</html>
