<?php // Memakai $nav dari header.php, $config dari bootstrap.php, dan $scripts (opsional) dari halaman. ?>

<!-- ===== FOOTER ===== -->
<footer class="footer">
  <div class="container">
    <div><span class="logo">CozyHouse</span><small>est-<?= (int) $config['berdiri'] ?> <?= e($config['nama']) ?></small></div>
    <nav>
      <?php foreach ($nav as $file => $label): ?>
        <a href="<?= $file ?>.php"><?= e($label) ?></a>
      <?php endforeach; ?>
    </nav>
    <div class="icons">
      <a href="<?= e($config['instagram']['url']) ?>" aria-label="Instagram" target="_blank" rel="noopener"><svg viewBox="0 0 24 24"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7Zm5 3.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Zm0 2a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5Zm5.2-3.2a1.1 1.1 0 1 1 0 2.2 1.1 1.1 0 0 1 0-2.2Z"/></svg></a>
      <a href="<?= e($config['tiktok']['url']) ?>" aria-label="TikTok" target="_blank" rel="noopener"><svg viewBox="0 0 24 24"><path d="M16.6 2h-3.2v13.3a2.9 2.9 0 1 1-2.9-2.9c.3 0 .6 0 .9.1V9.2a6.1 6.1 0 1 0 5.2 6V8.6a7.5 7.5 0 0 0 4.4 1.4V6.8A4.4 4.4 0 0 1 16.6 2Z"/></svg></a>
    </div>
  </div>
</footer>

<script src="assets/js/main.js"></script>
<?php foreach ($scripts ?? [] as $s): ?>
<script src="assets/js/<?= e($s) ?>.js"></script>
<?php endforeach; ?>
</body>
</html>
