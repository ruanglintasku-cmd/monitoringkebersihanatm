# Cara Menerapkan Perbaikan & Memasukkan 772 Data ATM Asli

## A. Perbaikan bug (WAJIB) — ganti folder aplikasi
Ganti folder `atm-monitoring` lama Anda dengan folder dari paket ini.
Perbaikan yang sudah dilakukan:
- Bug Notice/Warning di halaman **Data ATM** (admin/atm) sudah diperbaiki.
- Redirect saat membuka root sudah benar (tidak lagi ke alamat aneh).
- Jangan lupa salin lagi `public/setup_password.php` bila password belum diisi,
  lalu buka `http://localhost/bankmandiri/atm-monitoring/public/setup_password.php`.

## B. Memasukkan 772 data ATM asli dari Excel
Pilih SALAH SATU cara:

### Cara 1 — Database Anda SUDAH ada (paling cepat, tidak hapus akun)
Di phpMyAdmin, pilih database `atm_monitoring` lalu jalankan berurutan via tab **Import** atau **SQL**:
1. `database/UPDATE_KOLOM_ATM.sql`   (menambah kolom baru dengan aman)
2. `database/import_atm_data.sql`    (mengisi 772 ATM — ini akan MENGHAPUS data ATM contoh lama lalu mengisi data asli)

> Akun user, laporan, dll TIDAK terhapus. Hanya tabel atm_locations yang di-refresh.

### Cara 2 — Mulai bersih dari awal
1. Drop database `atm_monitoring`, buat ulang.
2. Import `database/atm_monitoring.sql` (skema terbaru sudah ada kolom tambahan).
3. Import `database/import_atm_data.sql` (772 ATM).
4. Buka `setup_password.php` untuk mengisi password.

## C. Update data ATM ke depannya (lewat aplikasi, tanpa SQL)
1. Login admin → menu **Data ATM** → tombol **Export Excel** untuk mengambil data saat ini.
2. Edit di Excel (boleh tambah baris ATM baru atau ubah yang ada). Simpan sebagai **CSV**.
3. Klik tombol **Import CSV**, unggah file. 
   - Kode ATM yang SUDAH ada → otomatis **diperbarui**.
   - Kode ATM baru → **ditambahkan**.
   - Header kolom dikenali otomatis (Kode/Terminal ID, Nama/Lokasi, Area, Alamat,
     Latitude, Longitude, Tipe Mesin, Merk, Pengelola, dll).

File contoh untuk import ada di:
- `database/template_import_atm.csv` (contoh 3 baris)
- `database/data_atm_lengkap.csv` (seluruh 772 ATM, siap diedit & di-import)
