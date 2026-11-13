CREATE DATABASE IF NOT EXISTS db_laundry CHARACTER SET utf8mb4;
USE db_laundry;

CREATE TABLE users (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  no_hp VARCHAR(20),
  alamat TEXT,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','pelanggan') NOT NULL DEFAULT 'pelanggan',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE layanan (
  id_layanan INT AUTO_INCREMENT PRIMARY KEY,
  nama_layanan VARCHAR(100) NOT NULL,
  deskripsi TEXT,
  harga_per_kg INT NOT NULL,
  estimasi_hari INT NOT NULL DEFAULT 2
);

CREATE TABLE pesanan (
  id_pesanan INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT NOT NULL,
  tgl_pesan DATETIME DEFAULT CURRENT_TIMESTAMP,
  total_harga INT NOT NULL DEFAULT 0,
  status ENUM('Menunggu','Diterima','Dicuci','Disetrika','Siap Diambil','Selesai') NOT NULL DEFAULT 'Menunggu',
  catatan TEXT,
  FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

CREATE TABLE detail_pesanan (
  id_detail INT AUTO_INCREMENT PRIMARY KEY,
  id_pesanan INT NOT NULL,
  id_layanan INT NOT NULL,
  berat DECIMAL(5,1) NOT NULL,
  subtotal INT NOT NULL,
  FOREIGN KEY (id_pesanan) REFERENCES pesanan(id_pesanan) ON DELETE CASCADE,
  FOREIGN KEY (id_layanan) REFERENCES layanan(id_layanan)
);

CREATE TABLE lokasi_laundry (
  id_lokasi INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  alamat TEXT NOT NULL,
  no_telp VARCHAR(20),
  jam_buka VARCHAR(50),
  embed_maps TEXT NOT NULL
);

INSERT INTO layanan (nama_layanan, deskripsi, harga_per_kg, estimasi_hari) VALUES
('Cuci Kering', 'Cuci dan keringkan, tanpa setrika', 5000, 2),
('Cuci Setrika', 'Cuci, keringkan, dan setrika rapi', 7000, 3),
('Setrika Saja', 'Setrika pakaian bersih', 4000, 1),
('Express (1 Hari)', 'Cuci setrika kilat selesai 1 hari', 12000, 1);

-- Ganti alamat dan URL embed dengan lokasi laundry yang sebenarnya
INSERT INTO lokasi_laundry (nama, alamat, no_telp, jam_buka, embed_maps) VALUES
('Laundry Bersih Wangi', 'Jl. Contoh No. 1, Bekasi, Jawa Barat', '081234567890', '08.00 - 20.00 WIB',
 'https://www.google.com/maps?q=Bekasi&output=embed');
