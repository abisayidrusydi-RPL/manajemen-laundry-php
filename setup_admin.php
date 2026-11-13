<?php
// Jalankan SEKALI lewat browser: http://localhost/laundry/setup_admin.php
// Setelah berhasil, HAPUS file ini.
require 'config/koneksi.php';
$ada = $pdo->query("SELECT COUNT(*) FROM users WHERE role='admin'")->fetchColumn();
if ($ada) { die('Admin sudah ada. Hapus file ini.'); }
$pdo->prepare("INSERT INTO users (nama,email,password,role) VALUES (?,?,?,'admin')")
    ->execute(['Admin','admin@laundry.com',password_hash('admin123', PASSWORD_DEFAULT)]);
echo 'Admin dibuat. Email: admin@laundry.com, password: admin123. Segera ganti password dan hapus file ini.';
