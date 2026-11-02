<?php
/** Aman untuk dicetak ke HTML. */
function e($teks): string
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

/** 16000 -> "Rp 16.000" */
function rupiah($angka): string
{
    return 'Rp ' . number_format((float) $angka, 0, ',', '.');
}

/** Folder foto yang dipakai bersama website utama. */
const DIR_GAMBAR = __DIR__ . '/../../assets/images/';
const URL_GAMBAR = '../assets/images/';

/** URL gambar untuk ditampilkan di halaman admin. */
function url_gambar(?string $nama): string
{
    return URL_GAMBAR . rawurlencode(basename((string) $nama));
}

function mulai_sesi(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_name('cozyhouse_admin');
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }
}

/** Pesan sekali tampil (sukses / error). */
function flash(string $tipe, string $pesan): void
{
    $_SESSION['flash'][] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function ambil_flash(): array
{
    $f = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $f;
}

function redirect(string $url): never
{
    header('Location: ' . $url);
    exit;
}

/** Token CSRF. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

/** Hentikan request POST jika token CSRF tidak cocok. */
function csrf_wajib(): void
{
    $kirim = $_POST['csrf'] ?? '';
    $sesi  = $_SESSION['csrf'] ?? '';
    if ($sesi === '' || !is_string($kirim) || !hash_equals($sesi, $kirim)) {
        http_response_code(419);
        exit('Sesi formulir tidak valid. Kembali dan muat ulang halaman.');
    }
}

/**
 * Simpan foto yang diunggah ke assets/images/.
 * Mengembalikan nama file baru, null jika tidak ada file, atau string error diawali "ERR:".
 */
function simpan_upload(string $field, string $awalan): ?string
{
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    $f = $_FILES[$field];

    if ($f['error'] !== UPLOAD_ERR_OK) {
        return 'ERR:Unggah gagal (kode ' . (int) $f['error'] . '). Ukuran maksimal server mungkin terlampaui.';
    }
    if ($f['size'] > 3 * 1024 * 1024) {
        return 'ERR:Ukuran foto maksimal 3 MB.';
    }

    $izin = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    if (!isset($izin[$mime]) || @getimagesize($f['tmp_name']) === false) {
        return 'ERR:Format foto harus JPG, PNG, atau WEBP.';
    }

    $slug = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($awalan)), '-') ?: 'foto';
    $nama = $slug . '-' . bin2hex(random_bytes(4)) . '.' . $izin[$mime];

    if (!is_dir(DIR_GAMBAR) || !move_uploaded_file($f['tmp_name'], DIR_GAMBAR . $nama)) {
        return 'ERR:Gagal menyimpan foto. Periksa izin folder assets/images.';
    }
    return $nama;
}

/** Apakah kolom ada di tabel (untuk kolom opsional). */
function kolom_ada(mysqli $conn, string $tabel, string $kolom): bool
{
    $stmt = $conn->prepare(
        'SELECT 1 FROM information_schema.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ? LIMIT 1'
    );
    $stmt->bind_param('ss', $tabel, $kolom);
    $stmt->execute();
    return (bool) $stmt->get_result()->fetch_row();
}
