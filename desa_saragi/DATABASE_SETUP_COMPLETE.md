# 🗄️ DATABASE SETUP GUIDE - Desa Cendana

**Status:** Database tables need to be created
**Date:** January 19, 2026

---

## ❌ Error yang Terjadi

```
Table 'desa_cendana.news' doesn't exist
Table 'desa_cendana.officials' doesn't exist
```

**Penyebab:** Database sudah ada, tapi tabelnya belum dibuat.

---

## ✅ SOLUSI: Buat Tabel di phpMyAdmin

### Langkah 1: Buka phpMyAdmin
1. Buka browser: `http://localhost/phpmyadmin`
2. Login (biasanya default: username `root`, password kosong)
3. Pilih database **`desa_cendana`** di sisi kiri

### Langkah 2: Jalankan SQL Commands

Di phpMyAdmin, klik tab **SQL** dan copy-paste kode di bawah ini:

```sql
-- ============================================
-- 1. TABEL BERITA
-- ============================================
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 2. TABEL PERANGKAT DESA
-- ============================================
CREATE TABLE IF NOT EXISTS officials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    bio TEXT,
    photo VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 3. TABEL GALERI
-- ============================================
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 4. INSERT DATA CONTOH
-- ============================================

-- Data Berita
INSERT INTO news (title, content, image) VALUES 
('Pembangunan Jalan Desa', 'Pemerintah Desa Cendana memulai proyek pengaspalan jalan utama untuk memperlancar ekonomi warga. Proyek ini diharapkan selesai dalam 3 bulan dengan anggaran Rp 500 juta.', 'news1.jpg'),
('Festival Budaya Cendana', 'Mari hadiri festival tahunan yang menampilkan tarian tradisional dan pameran kerajinan tangan lokal. Festival ini akan berlangsung selama 3 hari.', 'news2.jpg'),
('Program Bibit Gratis', 'Pembagian bibit pohon cendana gratis untuk mendukung penghijauan lingkungan desa. Sebanyak 1000 bibit pohon akan dibagikan.', 'news3.jpg');

-- Data Perangkat Desa
INSERT INTO officials (name, position, bio, phone, email) VALUES 
('Bapak Cendana', 'Kepala Desa', 'Kepala Desa Cendana yang berdedikasi untuk kemajuan desa.', '+62 812 3456 7890', 'kepala@desacendana.id'),
('Ibu Sari', 'Sekretaris Desa', 'Sekretaris yang bertanggung jawab atas administrasi desa.', '+62 812 3456 7891', 'sekretaris@desacendana.id'),
('Bapak Heri', 'Bendahara Desa', 'Pengelola keuangan desa dengan integritas tinggi.', '+62 812 3456 7892', 'bendahara@desacendana.id');

-- Data Galeri
INSERT INTO gallery (title, image, description) VALUES 
('Acara Musyawarah Desa', 'gallery1.jpg', 'Foto dari acara musyawarah desa yang melibatkan seluruh masyarakat'),
('Kegiatan Gotong Royong', 'gallery2.jpg', 'Kegiatan gotong royong pembersihan lingkungan desa'),
('Pelatihan Keterampilan', 'gallery3.jpg', 'Program pelatihan keterampilan untuk meningkatkan SDM desa');
```

### Langkah 3: Klik Tombol "Go"
- Setelah mengcopy semua kode SQL di atas, klik tombol **Go** atau **Execute**
- Tunggu hingga muncul pesan "Query successful" (hijau)

---

## ✅ Verifikasi Tabel Berhasil Dibuat

Setelah menjalankan SQL, cek apakah tabel sudah ada:

1. **Di phpMyAdmin:** Di sisi kiri, klik database **desa_cendana**
2. **Lihat daftar tabel:** Seharusnya ada:
   - ✅ `news` (4 baris)
   - ✅ `officials` (3 baris)
   - ✅ `gallery` (3 baris)
   - ✅ `users` (sudah ada dari setup sebelumnya)

### Atau jalankan query ini untuk verifikasi:
```sql
SELECT * FROM news;
SELECT * FROM officials;
SELECT * FROM gallery;
```

---

## 📁 Folder Struktur yang Dibutuhkan

```
c:\laragon\www\desa_cendana\
├── uploads/              ← Folder gambar (HARUS ADA!)
│   ├── news1.jpg        (opsional, bisa langsung upload via admin)
│   ├── news2.jpg
│   └── news3.jpg
├── admin/
│   ├── login.php        (sudah ada)
│   ├── dashboard.php    (sudah ada)
│   └── add_news.php     ✨ BARU - untuk tambah berita
├── config/
│   └── db.php           (sudah ada)
├── news.php             (sudah ada, siap pakai)
├── news_detail.php      (sudah ada)
└── ...
```

### Buat Folder `uploads` (Jika Belum Ada)
1. Buka File Explorer
2. Masuk ke: `c:\laragon\www\desa_cendana\`
3. Klik kanan → New Folder → Beri nama: `uploads`
4. Selesai! ✅

---

## 🚀 Testing Setelah Setup

### Test 1: Cek Halaman Berita
1. Pastikan Laragon sudah running (MySQL hijau ✅)
2. Buka: `http://localhost/desa_cendana/news.php`
3. Seharusnya menampilkan 3 berita dalam bentuk cards

**Expected:** ✅ 3 berita tampil (Pembangunan Jalan, Festival Budaya, Program Bibit)

### Test 2: Cek Halaman Perangkat Desa
1. Buka: `http://localhost/desa_cendana/officials.php`
2. Seharusnya menampilkan 3 perangkat desa

**Expected:** ✅ 3 perangkat tampil (Kepala Desa, Sekretaris, Bendahara)

### Test 3: Login Admin dan Tambah Berita
1. Buka: `http://localhost/desa_cendana/admin/login.php`
2. Login: **admin** / **admin123**
3. Di dashboard, klik: **Tambah Berita** atau akses: `http://localhost/desa_cendana/admin/add_news.php`
4. Isi form dengan berita baru
5. Klik: **Simpan Berita**

**Expected:** ✅ Berita baru terlihat di halaman news.php

---

## 🔧 Troubleshooting

### ❌ Error: "Parse Error" di news.php
**Solusi:** File sudah diperbaiki, cukup refresh halaman

### ❌ Error: "Table not found"
**Solusi:** Pastikan sudah menjalankan SQL commands di atas di phpMyAdmin

### ❌ Gambar tidak tampil
**Solusi:** Normal jika belum upload gambar. Sistem akan tampilkan placeholder hijau otomatis.

### ❌ Tidak bisa upload gambar di admin/add_news.php
**Penyebab:** Folder `uploads/` tidak ada atau permission salah

**Solusi:**
1. Pastikan folder `uploads/` ada di root project
2. Jika masih error, buat manual via File Explorer
3. Cek bahwa folder dapat di-write (biasanya otomatis)

### ❌ Database connection error di config/db.php
**Penyebab:** MySQL tidak running atau konfigurasi salah

**Solusi:**
1. Buka Laragon
2. Klik tombol Start (MySQL harus hijau ✅)
3. Cek config/db.php: host=localhost, user=root, password=(kosong)

---

## 📊 Struktur Tabel Database

### Tabel `news`
```
Kolom       | Type         | Keterangan
------------|--------------|-----------------------------------
id          | INT          | ID unik (auto increment)
title       | VARCHAR(255) | Judul berita
content     | TEXT         | Isi berita (bisa panjang)
image       | VARCHAR(255) | Nama file gambar (misal: news1.jpg)
date        | TIMESTAMP    | Waktu publikasi (auto)
created_at  | TIMESTAMP    | Waktu dibuat (auto)
```

### Tabel `officials`
```
Kolom       | Type         | Keterangan
------------|--------------|-----------------------------------
id          | INT          | ID unik
name        | VARCHAR(100) | Nama perangkat desa
position    | VARCHAR(100) | Jabatan (Kepala Desa, dll)
bio         | TEXT         | Biografi singkat
photo       | VARCHAR(255) | Nama file foto
phone       | VARCHAR(20)  | No. telepon
email       | VARCHAR(100) | Email
created_at  | TIMESTAMP    | Waktu dibuat
```

### Tabel `gallery`
```
Kolom       | Type         | Keterangan
------------|--------------|-----------------------------------
id          | INT          | ID unik
title       | VARCHAR(255) | Judul foto
image       | VARCHAR(255) | Nama file gambar
description | TEXT         | Deskripsi foto
created_at  | TIMESTAMP    | Waktu dibuat
```

---

## 📝 SQL Cheat Sheet

**Lihat semua tabel:**
```sql
SHOW TABLES;
```

**Lihat struktur tabel:**
```sql
DESCRIBE news;
DESCRIBE officials;
DESCRIBE gallery;
```

**Lihat semua data berita:**
```sql
SELECT * FROM news;
```

**Hapus semua data (tapi tabel tetap ada):**
```sql
DELETE FROM news;
DELETE FROM officials;
DELETE FROM gallery;
```

**Hapus tabel (hati-hati!):**
```sql
DROP TABLE news;
DROP TABLE officials;
DROP TABLE gallery;
```

---

## ✅ Checklist Setup Database

- [ ] Buka phpMyAdmin (http://localhost/phpmyadmin)
- [ ] Pilih database desa_cendana
- [ ] Klik tab SQL
- [ ] Copy semua kode SQL dari panduan ini
- [ ] Klik Go/Execute
- [ ] Lihat pesan "Query successful" (hijau)
- [ ] Cek tabel di sisi kiri (news, officials, gallery)
- [ ] Buat folder uploads/ di root project
- [ ] Refresh browser (Ctrl + F5)
- [ ] Buka news.php → lihat 3 berita tampil ✅
- [ ] Buka officials.php → lihat 3 perangkat tampil ✅
- [ ] Login admin dan test add_news.php ✅

---

## 🎯 Setelah Setup Selesai

### Langkah Berikutnya:
1. **Administrasi Berita:** Gunakan `/admin/add_news.php` untuk tambah berita
2. **Edit/Delete:** Buat fitur edit dan delete di dashboard (Phase 2)
3. **Gambar:** Upload gambar via form admin/add_news.php
4. **Customisasi:** Ubah data perangkat desa sesuai realita

---

## 📞 Koneksi Database Info

```
Host:     localhost
Username: root
Password: (kosong)
Database: desa_cendana
Port:     3306
```

**File config:** `config/db.php`

---

## 🎉 Selamat!

Setelah menjalankan semua langkah di atas, website Desa Cendana sudah siap dengan:
- ✅ Halaman berita dengan 3 data contoh
- ✅ Halaman perangkat desa dengan 3 data contoh  
- ✅ Halaman galeri dengan 3 data contoh
- ✅ Form admin untuk tambah berita baru
- ✅ Upload gambar otomatis ke folder uploads/

**Selamat menikmati website Desa Cendana! 🌿**

---

*Last Updated: January 19, 2026*
*Desa Cendana Website - Database Setup Guide*
