# Perbaikan Area Tertukar + Fitur Baru

## PENYEBAB area tertukar
Saat awal, skema dasar mengisi tabel `cities` dengan urutan id berbeda dari
data ATM, sehingga `city_id` menunjuk ke area yang salah (mis. id Balikpapan
justru berisi ATM Banjarmasin). 

## LANGKAH WAJIB (perbaiki data yang sudah ada)
1. Ganti folder `atm-monitoring` dengan isi paket terbaru ini.
2. Buka phpMyAdmin -> pilih database `atm_monitoring` -> tab **SQL**.
3. Jalankan file: **`database/PERBAIKAN_AREA.sql`**
   - Script ini menautkan ulang SETIAP ATM ke area yang benar berdasarkan
     kolom `area` (sumber kebenaran, mis. "149 / BALIKPAPAN").
   - Nama area diseragamkan ke format kode resmi.
   - TIDAK menghapus data ATM/laporan/user.
4. Di akhir, script menampilkan tabel verifikasi. Pastikan jumlahnya:
   - 031 / BANJARMASIN  = 164
   - 146 / PONTIANAK    = 133
   - 148 / SAMARINDA    = 194
   - 149 / BALIKPAPAN   = 186
   - 159 / PALANGKARAYA = 95

> Jika ingin mulai bersih: drop database, import `atm_monitoring.sql` lalu
> `import_atm_data.sql` (keduanya sudah memakai format kode resmi).

## Yang diperbaiki di kode
- **supervisor/map**: area tidak lagi tertukar; dropdown & sorot per area benar.
- **supervisor/atm**:
  - Bug pencarian DIPERBAIKI (dulu error karena placeholder SQL :q dipakai 3x).
  - Tambah tombol **Export Excel** (mengikuti filter pencarian/area/status).
  - Filter area kini memakai format kode resmi.
- Nama area di seluruh aplikasi memakai format "031 / BANJARMASIN", dst.
