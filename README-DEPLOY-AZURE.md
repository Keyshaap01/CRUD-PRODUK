# CRUD Produk PHP Native - Azure App Service (Docker)

Paket ini menyiapkan aplikasi PHP Native + MySQL agar Nginx melayani file dari `/var/www/html` dan menjalankan PHP lewat PHP-FPM. Port container: **8080**.

## Isi paket
- `index.php`, `tambah.php`, `edit.php`, `hapus.php`, `style.css`
- `db.php` membaca kredensial dari environment variables
- `database.sql` untuk membuat database/tabel dan data contoh
- `Dockerfile`, `deploy/nginx.conf`, `deploy/supervisord.conf`

## Penting: database
Database di Azure harus berupa MySQL yang dapat diakses dari App Service/container. Jangan gunakan `localhost` untuk database Azure kecuali MySQL memang berjalan di container yang sama (tidak disarankan). Impor `database.sql` ke server MySQL tujuan, lalu set App Service > Environment variables / Configuration:

- `DB_HOST` = hostname server MySQL
- `DB_PORT` = `3306` (atau port server database)
- `DB_NAME` = nama database yang berisi tabel `produk`
- `DB_USER` = username database
- `DB_PASSWORD` = password database
- `WEBSITES_PORT` = `8080`

Simpan password hanya di Application settings, jangan commit ke GitHub. Aktifkan TLS/SSL database sesuai konfigurasi provider MySQL dan aturan jaringan/firewall provider.

## Deploy lewat GitHub / Azure App Service

1. Ekstrak ZIP ini. Pastikan `Dockerfile` ada di root folder repository, sejajar dengan `index.php`.
2. Commit dan push seluruh file ke branch yang dipakai Azure.
3. Di Azure App Service, pilih deployment berbasis **Container** / build dari source dengan Dockerfile. Jika App Service saat ini diset sebagai runtime PHP Code, Dockerfile tidak otomatis dipakai; ubah konfigurasi deployment ke custom container atau gunakan alur container registry yang tersedia pada subscription.
4. Pastikan image dibangun dan dijalankan dengan port container `8080`. Set App Setting `WEBSITES_PORT=8080`.
5. Tambahkan environment variables database di atas, lalu restart App Service.
6. Buka URL website.

## Database schema
`database.sql` membuat database `crud_produk`, tabel `produk`, dan dua contoh produk. Jika kamu memakai nama database berbeda, samakan `DB_NAME` dengan nama tersebut.

## Catatan
- File ini tidak menyertakan kredensial database.
- Jika halaman dapat dibuka tetapi menampilkan pesan koneksi database gagal, periksa environment variables, izin user database, firewall, dan apakah database sudah diisi dengan `database.sql`.
- Jika masih 404 dari Nginx, pastikan deployment benar-benar menggunakan Dockerfile dari repository ini dan log build/runtime berhasil.
