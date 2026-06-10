# Upgrade Form Laporan Petugas (kamera-only + search + temuan + jarak)

## Langkah 1 — Jalankan SQL (sekali)
phpMyAdmin → database `atm_monitoring` → tab SQL → jalankan **`database/UPGRADE_FITUR.sql`**.
(Jika sudah pernah dijalankan, jalankan lagi tidak masalah — ada bagian baru untuk
menambah tipe foto 'temuan'. Jika muncul error "Duplicate", abaikan untuk baris yang
sudah ada; baris ALTER report_photos akan tetap berjalan.)

> Catatan: baris `ALTER TABLE report_photos MODIFY ... 'temuan'` aman diulang.

## Langkah 2 — Ganti folder aplikasi dengan isi paket ini.

---

## Yang berubah di halaman Buat Laporan (petugas/report)

### 1. Pencarian ATM (ketik ID langsung muncul)
- Tidak lagi dropdown panjang. Petugas mengetik kode (mis. `s1rhj`) atau nama lokasi,
  daftar cocok muncul otomatis, tinggal klik untuk memilih.

### 2. Kamera-only KETAT (galeri & file diblokir)
- Foto diambil dari **kamera live di dalam halaman** (memakai izin kamera browser),
  bukan dari dialog file. Petugas menekan "Buka Kamera" → "Ambil Foto".
- Tombol pilih file dinonaktifkan, sehingga **tidak bisa** memilih foto lama dari
  galeri/file, baik di HP maupun di laptop/desktop. Kamera harus hidup saat itu juga.
- Penting: kamera hanya bisa diakses lewat **localhost** atau **HTTPS** (sudah terpenuhi
  karena Anda akses via localhost). Berikan izin kamera saat diminta browser.

### 3. Foto TEMUAN (opsional)
- Slot foto ketiga untuk temuan kerusakan (mis. kaca/keramik pecah).
- Tidak wajib. Jika diisi, muncul kolom keterangan temuan, dan watermark foto
  menyertakan teks "TEMUAN: ...". Foto temuan tampil di tabel Laporan (bingkai merah).

### 4. Notifikasi JARAK ke ATM
- Setelah memilih ATM dan GPS terkunci, muncul info jarak real-time:
  - Hijau: "Anda berada ±X m dari ATM (dalam radius wajar)".
  - Merah: "Anda JAUH dari lokasi ATM: ±X m (lebih dari 50 m)".
- Jarak & status juga tersimpan di laporan (kolom gps_distance/location_flag).
