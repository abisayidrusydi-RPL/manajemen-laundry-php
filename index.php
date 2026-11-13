
<?php
require_once __DIR__ . '/config/koneksi.php';

// Jika sudah login, arahkan sesuai role
if (isset($_SESSION['user'])) {
    $tujuan = ($_SESSION['user']['role'] === 'admin')
        ? 'admin/dashboard.php'
        : 'pelanggan/status.php';

    header('Location: ' . BASE_URL . $tujuan);
    exit;
}

// Ambil data lokasi laundry
$lokasi = $pdo->query(
    "SELECT * FROM lokasi_laundry LIMIT 1"
)->fetch(PDO::FETCH_ASSOC);

$judul = 'Bekaswiss Laundry';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title><?= e($judul) ?></title>

    <link rel="stylesheet"
          href="<?= BASE_URL ?>assets/landing.css">
</head>

<body>

<div class="landing-container">

    <!-- BAGIAN KIRI: SLIDE GAMBAR DAN LOKASI -->

<!-- BAGIAN KIRI: SLIDE GAMBAR DAN LOKASI -->
<section class="visual-section">

    <div class="slider">

        <!-- SLIDE 1: GAMBAR LAUNDRY -->
        <div class="slide active">

            <img
                src="<?= BASE_URL ?>assets/images/laundry-interior.png"
                alt="Ilustrasi Bekaswiss Laundry"
                class="slide-image"
            >

            <div class="slide-content">
                <h1>Bekaswiss Laundry</h1>

                <p>
                    Bersih, wangi, dan rapi.
                    Kami siap membantu kebutuhan laundry Anda.
                </p>
            </div>

        </div>


        <!-- SLIDE 2: LOKASI LAUNDRY -->
        <div class="slide location-slide">

            <?php if (!empty($lokasi['embed_maps'])): ?>

                <iframe
                    src="<?= e($lokasi['embed_maps']) ?>"
                    title="Lokasi Bekaswiss Laundry"
                    loading="lazy"
                    allowfullscreen>
                </iframe>

            <?php else: ?>

                <div class="location-empty">
                    <h2>Lokasi Laundry</h2>
                    <p>Informasi lokasi belum tersedia.</p>
                </div>

            <?php endif; ?>

            <div class="location-info">

                <h2>
                    <?= e($lokasi['nama'] ?? 'Bekaswiss Laundry') ?>
                </h2>

                <p>
                    <?= e($lokasi['alamat'] ?? 'Alamat belum tersedia') ?>
                </p>

            </div>

        </div>

    </div>


    <!-- TOMBOL NAVIGASI SLIDER -->
    <div class="slider-controls">

        <button type="button" id="prev">
            &#10094;
        </button>

        <div class="dots">

            <span class="dot active" data-index="0"></span>

            <span class="dot" data-index="1"></span>

        </div>

        <button type="button" id="next">
            &#10095;
        </button>

    </div>

</section>



    <!-- BAGIAN KANAN: LOGIN DAN REGISTER -->
    <section class="form-section">

        <div class="form-card">

            <div class="form-header">

                <span>BEKASWISS LAUNDRY</span>

                <h2 id="formTitle">Masuk ke Akun</h2>

                <p id="formDescription">
                    Masuk untuk melakukan pemesanan
                    dan melihat status laundry.
                </p>

            </div>


            <!-- PESAN NOTIFIKASI -->
            <?php if (isset($_GET['error_login'])): ?>
                <div class="alert">
                    Email atau password salah.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['daftar'])): ?>
                <div class="success">
                    Pendaftaran berhasil. Silakan masuk.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error_daftar'])): ?>
                <div class="alert">
                    Pendaftaran gagal. Periksa kembali data Anda.
                </div>
            <?php endif; ?>


            <!-- FORM LOGIN -->
            <form action="<?= BASE_URL ?>login.php"
                  method="POST"
                  id="loginForm">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan email"
                    autocomplete="username"
                    required
                >

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >

                <button type="submit" class="btn-submit">
                    Masuk
                </button>

            </form>


            <!-- FORM DAFTAR -->
            <form action="<?= BASE_URL ?>register.php"
                  method="POST"
                  id="registerForm"
                  style="display:none">

                <label>Nama Lengkap</label>

                <input
                    type="text"
                    name="nama"
                    placeholder="Nama lengkap"
                    required
                >

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan email"
                    required
                >

                <label>Nomor HP</label>

                <input
                    type="text"
                    name="no_hp"
                    placeholder="Nomor HP"
                >

                <label>Alamat</label>

                <textarea
                    name="alamat"
                    placeholder="Alamat lengkap"
                    rows="3"></textarea>

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Minimal 6 karakter"
                    minlength="6"
                    required
                >

                <button type="submit" class="btn-submit">
                    Daftar Akun
                </button>

            </form>


            <!-- PINDAH LOGIN / REGISTER -->
            <div class="switch-form">

                <span id="switchText">
                    Belum mempunyai akun?
                </span>

                <button type="button" id="switchButton">
                    Daftar sekarang
                </button>

            </div>

        </div>

    </section>

</div>


<script>

// ==========================
// SLIDER GAMBAR DAN LOKASI
// ==========================

const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');

let currentSlide = 0;

function showSlide(index) {

    currentSlide = (index + slides.length) % slides.length;

    slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === currentSlide);
    });

    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === currentSlide);
    });

}

document.getElementById('next').onclick = () => {
    showSlide(currentSlide + 1);
};

document.getElementById('prev').onclick = () => {
    showSlide(currentSlide - 1);
};

dots.forEach(dot => {
    dot.onclick = () => {
        showSlide(Number(dot.dataset.index));
    };
});


let touchStartX = 0;

const visualSection = document.querySelector('.visual-section');

visualSection.addEventListener('touchstart', function(e) {
    touchStartX = e.changedTouches[0].screenX;
}, { passive: true });

visualSection.addEventListener('touchend', function(e) {
    let touchEndX = e.changedTouches[0].screenX;
    let difference = touchStartX - touchEndX;

    if (difference > 50) {
        showSlide(currentSlide + 1);
    }

    if (difference < -50) {
        showSlide(currentSlide - 1);
    }
}, { passive: true });



// ==========================
// LOGIN DAN DAFTAR AKUN
// ==========================

const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');

const formTitle = document.getElementById('formTitle');
const formDescription = document.getElementById('formDescription');

const switchText = document.getElementById('switchText');
const switchButton = document.getElementById('switchButton');

let isRegister = false;

function switchForm() {

    isRegister = !isRegister;

    if (isRegister) {

        loginForm.style.display = 'none';
        registerForm.style.display = 'flex';

        formTitle.textContent = 'Daftar Akun';

        formDescription.textContent =
            'Buat akun baru untuk menggunakan layanan kami.';

        switchText.textContent =
            'Sudah mempunyai akun?';

        switchButton.textContent =
            'Masuk sekarang';

    } else {

        loginForm.style.display = 'flex';
        registerForm.style.display = 'none';

        formTitle.textContent = 'Masuk ke Akun';

        formDescription.textContent =
            'Masuk untuk melakukan pemesanan dan melihat status laundry.';

        switchText.textContent =
            'Belum mempunyai akun?';

        switchButton.textContent =
            'Daftar sekarang';

    }

}

switchButton.addEventListener('click', switchForm);


// Jika pendaftaran gagal, tampilkan form daftar kembali.
const params = new URLSearchParams(window.location.search);

if (params.has('error_daftar')) {
    switchForm();
}

</script>

</body>
</html>
