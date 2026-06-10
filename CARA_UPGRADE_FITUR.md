# Upgrade Fitur Profesional

Empat fitur baru sudah ditambahkan. Ikuti 2 langkah:

## Langkah 1 — Jalankan SQL upgrade (sekali saja)
phpMyAdmin → database `atm_monitoring` → tab **SQL** → jalankan:
**`database/UPGRADE_FITUR.sql`**

Script ini AMAN (tidak menghapus data). Ia menambah:
- Kolom `gps_distance` & `location_flag` pada tabel `cleaning_reports`
- Tabel baru `schedules` (untuk penjadwalan tugas)

## Langkah 2 — Ganti folder aplikasi
Ganti folder `atm-monitoring` dengan isi paket ini.

---

## Fitur yang ditambahkan

### 1. Validasi GPS Radius (anti laporan palsu)
- Saat petugas mengirim laporan, sistem menghitung jarak (rumus Haversine)
  antara lokasi GPS petugas dan koordinat ATM.
- Jika dalam 50 meter → ditandai **"ok"** (hijau).
- Jika lebih jauh → ditandai **"jauh / mencurigakan"** (merah) — laporan tetap
  tersimpan tapi diberi tanda agar supervisor bisa menindaklanjuti.
- Jarak & status muncul di tabel Laporan dan ikut ter-export.
- Ambang batas bisa diubah di `app/Helpers/Geo.php` (fungsi `threshold()`).

### 2. Grafik Mingguan / Bulanan / Tahunan + filter
- Dashboard punya tombol **Mingguan · Bulanan · Tahunan** di atas grafik.
- Grafik dimuat ulang otomatis sesuai periode yang dipilih.

### 3. Penjadwalan & Rotasi Tugas (menu "Penjadwalan")
- Admin bisa menjadwalkan ATM mana dibersihkan tanggal berapa & oleh siapa.
- Tombol **Auto-Rotasi**: sistem otomatis membagikan ATM (per area bila dipilih)
  ke petugas yang tersedia secara merata untuk tanggal tertentu.
- Bisa hapus per jadwal atau bersihkan semua jadwal pada tanggal tertentu.

### 4. Koordinat bisa diklik → buka Google Maps
- Di Data ATM, Laporan, dan daftar ATM petugas, koordinat latitude/longitude
  kini berupa tautan. Klik → langsung membuka titik itu di Google Maps tab baru.
