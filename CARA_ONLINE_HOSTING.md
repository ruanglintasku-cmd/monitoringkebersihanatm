# Cara Menjalankan di Hosting (cPanel) + Domain

Aplikasi sekarang **mendeteksi alamatnya sendiri secara otomatis** — di localhost
maupun di domain hosting. Anda TIDAK perlu lagi mengedit BASE_URL.

## Langkah 1 — Upload file
1. Kompres folder aplikasi atau upload via File Manager cPanel.
2. Letakkan di salah satu lokasi (bebas, semua didukung otomatis):
   - Langsung di `public_html/` (untuk domain.com)
   - Di subfolder `public_html/atm-monitoring/` (untuk domain.com/atm-monitoring)
   - Di folder subdomain (untuk atm.domain.com)
3. Ekstrak di sana.

> Aplikasi tetap berstruktur dengan folder `/public`. Saat dibuka, root akan
> otomatis mengarahkan ke `/public/login`. Jadi domain.com akan jalan sendiri.

### (Opsional, paling rapi) Arahkan domain langsung ke folder /public
Di cPanel: **Domains** → pada domain Anda klik ubah **Document Root** →
arahkan ke `.../atm-monitoring/public`. Dengan ini, domain.com langsung membuka
aplikasi tanpa perlu mengetik /public. (Kalau tidak diatur pun tetap jalan,
karena ada redirect otomatis.)

## Langkah 2 — Buat & impor database
1. cPanel → **MySQL Databases**: buat database baru + user, lalu tambahkan user
   ke database itu (centang ALL PRIVILEGES). Catat namanya, biasanya berprefix:
   - DB name: `namaakun_atm`
   - DB user: `namaakun_atmuser`
   - Password: (yang Anda buat)
2. cPanel → **phpMyAdmin** → pilih database tadi → tab **Import** →
   upload `database/atm_monitoring.sql`.
3. Lalu import juga (berurutan):
   - `database/import_atm_data.sql`  (772 data ATM)
   - `database/UPGRADE_FITUR.sql`    (fitur jadwal, GPS, foto temuan)

## Langkah 3 — Sesuaikan KONEKSI database
Edit file `config/config.php`, bagian DATABASE (bagian paling atas):
```php
define('DB_HOST', 'localhost');          // biasanya tetap 'localhost' di cPanel
define('DB_NAME', 'namaakun_atm');       // ganti sesuai yang Anda buat
define('DB_USER', 'namaakun_atmuser');   // ganti
define('DB_PASS', 'password_db_anda');   // ganti
```
Hanya 4 baris ini yang perlu diganti. BASE_URL biarkan — sudah otomatis.

## Langkah 4 — Isi password akun (sekali)
Buka di browser: `https://domain-anda/.../public/setup_password.php`
Setelah muncul "BERHASIL", login, lalu HAPUS file setup_password.php.

## Langkah 5 (PENTING) — Aktifkan HTTPS (SSL)
Fitur **kamera** (ambil foto laporan) hanya berfungsi di **HTTPS** atau localhost.
Di domain http:// biasa, browser memblokir kamera.
- cPanel → **SSL/TLS Status** atau **Let's Encrypt** → aktifkan SSL gratis untuk
  domain Anda. Setelah aktif, akses pakai `https://`.
- Aplikasi otomatis mendeteksi HTTPS (termasuk mengamankan cookie sesi).

## Masalah umum
- **Masih lari ke localhost** → file `config/config.php` versi lama. Pastikan
  Anda upload versi terbaru ini (BASE_URL sudah otomatis, tidak ada teks 'localhost').
- **Foto/kamera tidak muncul saat online** → domain belum HTTPS. Aktifkan SSL.
- **Error koneksi database** → cek lagi 4 baris DB di config (nama db/user berprefix).
- **Folder uploads tidak bisa simpan foto** → set permission folder `public/uploads`
  (dan subfolder before/after/findings) ke 755 atau 775 via File Manager.
