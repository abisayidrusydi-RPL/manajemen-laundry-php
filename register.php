
<?php
require_once __DIR__ . '/config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL);
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$password = $_POST['password'] ?? '';

if (
    $nama === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    strlen($password) < 6
) {
    header('Location: ' . BASE_URL . 'index.php?error_daftar=1');
    exit;
}

$cek = $pdo->prepare(
    "SELECT id_user FROM users WHERE email = ?"
);

$cek->execute([$email]);

if ($cek->fetch()) {
    header('Location: ' . BASE_URL . 'index.php?error_daftar=1');
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO users
    (nama, email, no_hp, alamat, password)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->execute([
    $nama,
    $email,
    $no_hp,
    $alamat,
    password_hash($password, PASSWORD_DEFAULT)
]);

header('Location: ' . BASE_URL . 'index.php?daftar=1');
exit;
