CREATE DATABASE IF NOT EXISTS crud_produk
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE crud_produk;

CREATE TABLE IF NOT EXISTS produk (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(150) NOT NULL,
    harga DECIMAL(12,2) NOT NULL DEFAULT 0,
    stok INT UNSIGNED NOT NULL DEFAULT 0,
    deskripsi TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO produk (nama_produk, harga, stok, deskripsi) VALUES
('Buku Catatan', 15000, 20, 'Buku catatan untuk kuliah'),
('Pulpen Hitam', 5000, 50, 'Pulpen tinta hitam');