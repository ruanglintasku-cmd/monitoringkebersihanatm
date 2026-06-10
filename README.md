# Sistem Monitoring Kebersihan ATM Region IX Kalimantan

Aplikasi web lengkap (PHP Native + MySQL) untuk memonitor kebersihan ATM: multi-role,
laporan + foto before/after (kamera wajib), GPS otomatis, watermark foto, peta Leaflet,
dashboard, notifikasi, dan export PDF/Excel. **Tanpa Composer / library eksternal.**

## 0. Versi PHP
Paket INI sudah dibuat **kompatibel PHP 5.6** (sesuai XAMPP Anda). Tetap disarankan
upgrade ke PHP 8 di kemudian hari karena PHP 5.6 sudah tidak mendapat patch keamanan.

## 1. Persyaratan
- XAMPP / Laragon (PHP 8.0+, ekstensi **GD** aktif — default aktif di XAMPP)
- MySQL / MariaDB
- Browser modern (kamera & GPS butuh izin)

## 2. Instalasi (XAMPP)
1. Ekstrak folder `atm-monitoring` ke `C:\xampp\htdocs\bankmandiri\`
   sehingga menjadi `C:\xampp\htdocs\bankmandiri\atm-monitoring`
2. Jalankan **Apache** & **MySQL** dari XAMPP Control Panel.
3. Buat database & tabel:
   - Buka `http://localhost/phpmyadmin`
   - Tab **Import** → pilih `database/atm_monitoring.sql` → **Go**
4. Set password akun awal (membuat hash bcrypt):
   - Buka terminal/CMD:
     ```
     cd C:\xampp\htdocs\atm-monitoring
     C:\xampp\php\php.exe database\seed_password.php
     ```
   - (Jika `php` sudah ada di PATH cukup: `php database/seed_password.php`)
5. Cek konfigurasi `config/config.php`:
   - `DB_USER='root'`, `DB_PASS=''` (default XAMPP)
   - `BASE_URL='http://localhost/bankmandiri/atm-monitoring/public'`
6. Buka aplikasi: **http://localhost/bankmandiri/atm-monitoring/public**

> Catatan kamera/GPS: browser hanya mengizinkan kamera & lokasi pada `localhost`
> atau situs **HTTPS**. Di `localhost` sudah otomatis diizinkan.

## 3. Akun Demo (password: `password123`)
| Role       | Username     | Bisa akses                                   |
|------------|--------------|----------------------------------------------|
| Admin      | `admin`      | Semua master data, user, laporan, log, export|
| Supervisor | `supervisor` | Monitoring ATM, petugas, peta, laporan       |
| Petugas    | `adi`,`siti` | ATM tugas, buat laporan (kamera+GPS), histori|

## 4. Alur Penggunaan
- **Admin**: Login → Data ATM (tambah/edit/hapus, import CSV, export Excel) →
  Kelola User → Wilayah → Target Harian → Laporan → Audit Log.
- **Petugas**: Login → Buat Laporan → pilih ATM, status, isi catatan (wajib),
  ambil **Foto Sebelum** & **Foto Sesudah** lewat kamera (galeri diblokir),
  GPS terkunci otomatis → Kirim. Foto otomatis diberi watermark
  (nama, kode ATM, tanggal, jam WITA, koordinat).
- **Supervisor**: Login → Dashboard → Monitoring ATM / Petugas / Peta → Laporan → Export.

## 5. Fitur Utama
- Multi-role + RBAC, password bcrypt, CSRF, proteksi XSS & SQL injection (PDO prepared).
- Master ATM: CRUD, search, filter, import CSV (template di `database/template_import_atm.csv`), export Excel.
- Laporan kebersihan: kamera wajib (`capture="environment"`), 2 foto wajib, catatan wajib.
- GPS otomatis (lat, long, akurasi, timestamp) tersimpan ke DB.
- Watermark permanen pada foto via GD.
- Dashboard: kartu ringkasan, progress bar, grafik 7 hari (Chart.js), notifikasi popup.
- Peta monitoring Leaflet: marker hijau (sudah) / merah (belum), popup detail + foto.
- Monitoring petugas: kinerja & persentase penyelesaian.
- Audit log seluruh aktivitas.
- Export PDF (siap cetak) & Excel.

## 6. Struktur Folder
```
atm-monitoring/
├─ config/config.php          Konfigurasi DB & app
├─ database/
│  ├─ atm_monitoring.sql       Skema + seed
│  ├─ seed_password.php        Set password akun awal
│  └─ template_import_atm.csv  Contoh import
├─ routes/web.php             Definisi rute
├─ public/                    Document root (akses di sini)
│  ├─ index.php               Front controller
│  ├─ .htaccess               Rewrite + keamanan
│  ├─ assets/css/app.css
│  └─ uploads/before|after/   Foto hasil (otomatis)
├─ app/
│  ├─ Core/    Database, Router, Controller, bootstrap
│  ├─ Controllers/  Auth, Dashboard, Atm, Report, Admin, Supervisor, Petugas, Api
│  ├─ Models/  User, Atm, Report, Ref, ActivityLog
│  ├─ Middleware/  Auth + RBAC per role
│  ├─ Helpers/ functions, Watermark (GD), Exporter (PDF/Excel)
│  └─ Views/   auth, admin, supervisor, petugas, reports, layouts
└─ storage/logs/
```

## 7. Keamanan
- Password: `password_hash`/`password_verify` (bcrypt) + auto-rehash.
- Session: httponly, samesite, regenerate id saat login.
- CSRF token di semua form POST.
- XSS: semua output via `e()` (htmlspecialchars).
- SQL Injection: 100% PDO prepared statements.
- RBAC: middleware per role; supervisor/petugas dibatasi region/tugasnya.

## 8. Troubleshooting
- **Foto tanpa watermark / error GD**: pastikan ekstensi `gd` aktif di `php.ini` (`extension=gd`).
- **Tidak bisa login**: jalankan ulang `seed_password.php`.
- **Halaman 404 semua**: pastikan `mod_rewrite` aktif & akses lewat `/public`.
- **Kamera tidak terbuka**: akses lewat `localhost` atau HTTPS, dan izinkan kamera.
