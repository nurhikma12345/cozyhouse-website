<?php
require __DIR__ . '/includes/bootstrap.php';
$title   = 'Lokasi & Kontak';
$scripts = ['lokasi'];
$sosial  = [
    'Instagram' => $config['instagram'],
    'TikTok'    => $config['tiktok'],
    'Facebook'  => $config['facebook'],
];
include __DIR__ . '/includes/header.php';
?>

<!-- ===== LOKASI & KONTAK ===== -->
<section class="page-head">
  <div class="container">
    <p class="eyebrow">COME VISIT US</p>
    <h1>Lokasi &amp; Kontak</h1>
    <p>Kami tunggu kunjunganmu di CozyHouse.</p>
  </div>
</section>

<section class="container loc" id="lokasi">
  <div class="map">
    <iframe title="Peta CozyHouse" loading="lazy" src="https://www.google.com/maps?q=<?= urlencode($config['maps']) ?>&amp;output=embed"></iframe>
  </div>
  <dl class="info">
    <dt>Alamat</dt>
    <dd id="alamat"><?= e($config['alamat']) ?><br><button type="button" id="salin-alamat" class="link-btn">Salin alamat</button></dd>
    <dt>Jam Operasional</dt>
    <dd><?= e($config['jam']) ?><br><span id="status-buka" class="status"></span></dd>
    <dt>Hubungi Kami</dt>
    <dd>WhatsApp: <?= e($config['telepon']) ?><br>Instagram: <?= e($config['instagram']['handle']) ?><br>Telepon: <?= e($config['telepon']) ?></dd>
    <a class="btn" href="https://wa.me/<?= e($config['whatsapp']) ?>" target="_blank" rel="noopener">Kirim Pesan</a>
  </dl>
</section>

<!-- ===== MEDIA SOSIAL ===== -->
<section class="section" id="sosial">
  <div class="container">
    <h2>Ikuti Kami di Media Sosial</h2>
    <p class="sub">Dapatkan informasi terbaru, menu, dan promo dari <?= e($config['nama']) ?>.</p>
    <div class="socials">
      <?php foreach ($sosial as $nama => $s): ?>
        <div class="social-card"><h3><?= e($nama) ?></h3><span><?= e($s['handle']) ?></span><a class="btn" href="<?= e($s['url']) ?>" target="_blank" rel="noopener">Lihat Akun</a></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
