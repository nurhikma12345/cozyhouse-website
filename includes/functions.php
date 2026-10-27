<?php
/** Aman untuk dicetak ke HTML. */
function e($teks): string
{
    return htmlspecialchars((string) $teks, ENT_QUOTES, 'UTF-8');
}

/** 16000 -> "Rp 16.000" */
function rupiah(int $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

/** Kategori -> grup tampilan di halaman Menu. */
function grup_menu(string $kategori): string
{
    return in_array($kategori, ['coffee', 'non-coffee'], true) ? 'minuman' : 'makanan';
}

/**
 * Ambil semua menu yang tersedia dari database.
 * Kalau database belum siap, pakai data cadangan agar website tetap jalan.
 */
function ambil_menu(?mysqli $conn): array
{
    if ($conn) {
        $sql = "SELECT m.nama, m.harga, k.slug AS kategori, m.gambar, m.favorit, m.di_menu
                FROM menu m JOIN kategori k ON k.id = m.kategori_id
                WHERE m.tersedia = 1
                ORDER BY m.urutan, m.id";
        $hasil = $conn->query($sql);
        if ($hasil && $hasil->num_rows > 0) {
            return $hasil->fetch_all(MYSQLI_ASSOC);
        }
    }
    return require __DIR__ . '/../config/menu_default.php';
}

/** Cetak satu kartu menu. */
function kartu_menu(array $m): void
{
    ?>
      <article class="menu-card" data-cat="<?= e($m['kategori']) ?>">
        <div class="photo"><img src="assets/images/<?= e($m['gambar']) ?>" alt="<?= e($m['nama']) ?>" loading="lazy"></div>
        <h3><?= e($m['nama']) ?></h3>
        <p class="price"><?= rupiah((int) $m['harga']) ?></p>
      </article>
    <?php
}
