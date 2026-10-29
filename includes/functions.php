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
 * Ambil semua menu dari database CozyHouse.
 * Menggunakan struktur tabel menu dan kategori_menu.
 * Data cadangan digunakan jika database tidak tersedia.
 */
function ambil_menu(?mysqli $conn): array
{
    if ($conn) {
        $sql = "
            SELECT
                m.nama_menu AS nama,
                m.harga,
                CASE
                    WHEN LOWER(TRIM(k.nama_kategori)) = 'coffee'
                        THEN 'coffee'
                    WHEN LOWER(TRIM(k.nama_kategori)) = 'non coffee'
                        THEN 'non-coffee'
                    WHEN LOWER(TRIM(k.nama_kategori)) = 'makanan'
                        THEN 'makanan'
                    WHEN LOWER(TRIM(k.nama_kategori)) = 'snack'
                        THEN 'snack'
                    ELSE 'makanan'
                END AS kategori,
                m.gambar,
m.favorit,
1 AS di_menu
            FROM menu AS m
            INNER JOIN kategori_menu AS k
                ON k.id_kategori = m.id_kategori
            ORDER BY m.id_menu ASC
        ";

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
