# Sistem Katalog Laundry Berbasis Web (HTML, PHP, MySQL)

## Cara menjalankan (XAMPP)
1. Salin folder `laundry` ke `C:\xampp\htdocs\`
2. Jalankan Apache dan MySQL di XAMPP
3. Buka phpMyAdmin, import `database.sql`
4. Sesuaikan `config/koneksi.php` bila perlu (user/password MySQL)
5. Buka `http://localhost/laundry/setup_admin.php` SEKALI, lalu hapus file tersebut
6. Buka `http://localhost/laundry/`

Akun admin: admin@laundry.com / admin123 (segera ganti)

## Mengganti lokasi Google Maps
Google Maps > cari lokasi > Bagikan > Sematkan peta > salin isi atribut `src` pada iframe,
lalu perbarui kolom `embed_maps` di tabel `lokasi_laundry`.


## Perbaikan Analisis Pelanggan (K-Means)
- Variabel: frekuensi pesanan selesai, total berat, dan total pengeluaran.
- Target 4 cluster; jumlah aktual otomatis menjadi min(4, jumlah pelanggan).
- Nilai variabel distandardisasi dengan z-score sebelum menghitung jarak Euclidean.
- Hasil C1-C4 diurutkan dari karakteristik penggunaan terendah ke tertinggi.
- Export tersedia sebagai CSV UTF-8 bertanda BOM yang dapat dibuka di Microsoft Excel. Tidak membutuhkan Composer/PhpSpreadsheet.
- Menu analisis menggunakan BASE_URL.
- Pastikan folder project tetap bernama `laundry` atau sesuaikan BASE_URL pada config/koneksi.php.
"# manajemen-laundry-php" 
