<?php
/** Admin yang sedang login (atau null). */
function admin_saat_ini(): ?array
{
    return $_SESSION['admin'] ?? null;
}

/** Wajib login; kalau belum, arahkan ke login.php. */
function wajib_login(?mysqli $conn): void
{
    if (!$conn) {
        http_response_code(503);
        exit('Database tidak terhubung. Pastikan MySQL di Laragon menyala dan database sudah diimpor.');
    }
    if (!admin_saat_ini()) {
        redirect('login.php');
    }
    // Sesi tidak aktif > 2 jam -> keluar otomatis.
    if (time() - ($_SESSION['aktif'] ?? 0) > 7200) {
        session_unset();
        redirect('login.php?expired=1');
    }
    $_SESSION['aktif'] = time();
}

/** Coba login. Mengembalikan pesan error atau null jika berhasil. */
function coba_login(mysqli $conn, string $username, string $password): ?string
{
    // Pembatasan percobaan: 5 kali gagal -> tunggu 5 menit.
    $b = &$_SESSION['gagal_login'];
    $b = $b ?? ['n' => 0, 't' => 0];
    if ($b['n'] >= 5 && time() - $b['t'] < 300) {
        return 'Terlalu banyak percobaan. Coba lagi dalam beberapa menit.';
    }
    if ($b['n'] >= 5) {
        $b = ['n' => 0, 't' => 0];
    }

    $stmt = @$conn->prepare('SELECT id_admin, username, password_hash, nama_lengkap FROM admin WHERE username = ? LIMIT 1');
    if (!$stmt) {
        error_log('CozyHouse admin: ' . $conn->error);
        return 'Tabel "admin" belum ada di database. Impor file admin/database/admin.sql lewat phpMyAdmin/HeidiSQL terlebih dahulu.';
    }
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    // Selalu jalankan verifikasi agar waktu respons relatif sama.
    $hash = $row['password_hash'] ?? '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ01234';
    if ($row && password_verify($password, $hash)) {
        session_regenerate_id(true);
        $_SESSION['admin'] = [
            'id'   => (int) $row['id_admin'],
            'user' => $row['username'],
            'nama' => $row['nama_lengkap'],
        ];
        $_SESSION['aktif'] = time();
        $_SESSION['gagal_login'] = ['n' => 0, 't' => 0];
        return null;
    }

    $b['n']++;
    $b['t'] = time();
    return 'Username atau password salah.';
}
