
<?php
require __DIR__ . '/includes/bootstrap.php';

$title = 'Tentang Kami';

// Gambar default
$gambarTentang = 'assets/images/tentang.jpg';

// Mengambil nama gambar dari database
if (isset($conn) && $conn instanceof mysqli) {
    $query = $conn->query(
        "SELECT gambar_tentang
         FROM profil_cafe
         WHERE id_profil = 1
         LIMIT 1"
    );

    if ($query && ($data = $query->fetch_assoc())) {
        if (!empty($data['gambar_tentang'])) {
            $namaGambar = basename($data['gambar_tentang']);

            $lokasiGambar = __DIR__ . '/assets/images/' . $namaGambar;

            if (is_file($lokasiGambar)) {
                $gambarTentang = 'assets/images/' . $namaGambar;
            }
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<!-- ===== TENTANG KAMI ===== -->
<section class="page-head">
  <div class="container">
    <h1>Cerita di balik CozyHouse</h1>
    <p>Ruang sederhana untuk menikmati rasa, cerita, dan kebersamaan.</p>
  </div>
</section>

<section class="container about" id="cerita">

<div class="photo">
    <img src="<?= e($gambarTentang) ?>" alt="Area outdoor CozyHouse">
</div>
  <div>
    <h2>Tempat singgah yang terasa dekat</h2>
    <p>Cafe CozyHouse hadir sebagai tempat nyaman untuk melepas penat, menikmati hidangan, dan berbagi cerita. Dengan suasana hangat dan desain modern, CozyHouse ingin menjadi rumah kedua bagi setiap pengunjung untuk menciptakan momen kebersamaan yang berkesan.</p>
    <h3>VISI</h3>
    <p>Menjadi ruang favorit untuk menikmati waktu bersama, dengan suasana nyaman dan hangat untuk bersantai, berbagi cerita, menikmati hidangan favorit, serta menciptakan momen berharga bersama orang-orang terdekat.</p>
    <h3>MISI</h3>
    <p>Menghadirkan suasana nyaman, pelayanan ramah, dan menu yang beragam.</p>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
