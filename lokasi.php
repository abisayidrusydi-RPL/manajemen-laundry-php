<?php
$judul = 'Lokasi Laundry';
require 'includes/header.php';
$lok = $pdo->query("SELECT * FROM lokasi_laundry LIMIT 1")->fetch();
?>
<h1>Lokasi Laundry</h1>
<?php if ($lok): ?>
  <div class="card" style="margin-bottom:16px">
    <h2><?= e($lok['nama']) ?></h2>
    <p>📍 <?= e($lok['alamat']) ?><br>📞 <?= e($lok['no_telp']) ?><br>🕒 <?= e($lok['jam_buka']) ?></p>
  </div>
  <div class="map"><iframe src="<?= e($lok['embed_maps']) ?>" allowfullscreen loading="lazy"></iframe></div>
<?php else: ?>
  <p>Data lokasi belum tersedia.</p>
<?php endif; ?>
<?php require 'includes/footer.php'; ?>
