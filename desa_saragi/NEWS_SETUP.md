# 📰 SETUP DATA BERITA - Desa Cendana

## Step 1: Pastikan Database `desa_cendana` Sudah Ada

Jika belum ada, buat database terlebih dahulu:

```sql
CREATE DATABASE IF NOT EXISTS desa_cendana CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

## Step 2: Buat Tabel `news`

```sql
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    image VARCHAR(255),
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## Step 3: Insert Data Berita Contoh

Buka **phpMyAdmin** → pilih database **desa_cendana** → klik tab **SQL** → Copy & Paste kode di bawah:

```sql
INSERT INTO news (title, content, image, date) VALUES 
(
    'Pembangunan Jalan Desa', 
    'Pemerintah Desa Cendana memulai proyek pengaspalan jalan utama untuk memperlancar ekonomi warga. Proyek ini diharapkan selesai dalam 3 bulan dengan anggaran Rp 500 juta. Jalan sepanjang 5 km ini akan menghubungkan pusat desa dengan pinggiran dan mempermudah akses transportasi masyarakat.', 
    'news1.jpg', 
    NOW()
),
(
    'Festival Budaya Cendana', 
    'Mari hadiri festival tahunan yang menampilkan tarian tradisional dan pameran kerajinan tangan lokal. Festival ini akan berlangsung selama 3 hari dengan menghadirkan berbagai pertunjukan seni, lomba tradisional, dan penjualan produk lokal. Jangan lewatkan kesempatan untuk menikmati warisan budaya Desa Cendana yang kaya.', 
    'news2.jpg', 
    NOW()
),
(
    'Program Bibit Gratis', 
    'Pembagian bibit pohon cendana gratis untuk mendukung penghijauan lingkungan desa. Program ini merupakan komitmen pemerintah desa dalam menjaga kelestarian lingkungan dan meningkatkan kualitas udara. Sebanyak 1000 bibit pohon akan dibagikan kepada warga yang tertarik berpartisipasi dalam program penghijauan ini.', 
    'news3.jpg', 
    NOW()
);
```

---

## Step 4: Verifikasi Data Sudah Masuk

Jalankan query ini untuk memastikan data sudah tersimpan:

```sql
SELECT * FROM news;
```

Jika berhasil, Anda akan melihat 3 berita yang baru saja dimasukkan.

---

## Step 5: Folder Uploads

Pastikan folder `uploads/` sudah ada di direktori root project:

```
c:\laragon\www\desa_cendana\
├── uploads/          ← Folder gambar berita
│   ├── news1.jpg
│   ├── news2.jpg
│   └── news3.jpg
├── news.php          ← File akan mencari gambar di sini
└── news_detail.php
```

### Jika folder belum ada:
1. Buka File Explorer
2. Masuk ke folder `c:\laragon\www\desa_cendana\`
3. Buat folder baru bernama `uploads`
4. Masukkan file gambar ke dalam folder (opsional, placeholder otomatis jika tidak ada)

---

## Step 6: Cek news.php

File `news.php` sudah diupdate untuk:
✅ Mengambil data dari tabel `news`
✅ Menampilkan dalam grid cards (3 kolom desktop, responsive)
✅ Menampilkan gambar, tanggal, judul, dan excerpt
✅ Tombol "Baca Selengkapnya" untuk membaca artikel lengkap

---

## Step 7: Buka Browser

1. Pastikan Laragon sudah start (klik tombol Start)
2. Kunjungi: `http://localhost/desa_cendana/news.php`
3. Seharusnya Anda akan melihat 3 berita dalam bentuk cards

---

## 📝 File-File yang Terlibat

| File | Fungsi |
|------|--------|
| **news.php** | Halaman daftar berita dengan pagination |
| **news_detail.php** | Halaman untuk membaca berita lengkap |
| **config/db.php** | Koneksi database |
| **uploads/** | Folder tempat menyimpan gambar berita |

---

## 🎨 Struktur Database `news`

```
Kolom        | Type          | Keterangan
-------------|---------------|---------------------------
id           | INT           | ID unik berita (auto increment)
title        | VARCHAR(255)  | Judul berita
content      | LONGTEXT      | Isi berita (bisa panjang)
image        | VARCHAR(255)  | Nama file gambar (misal: news1.jpg)
date         | DATETIME      | Tanggal publikasi
created_at   | TIMESTAMP     | Waktu dibuat (auto)
```

---

## ✅ Checklist Setup

- [ ] Database `desa_cendana` sudah ada
- [ ] Tabel `news` sudah dibuat
- [ ] Data contoh (3 berita) sudah diinsert
- [ ] Folder `uploads/` sudah dibuat
- [ ] File `news.php` sudah diupdate
- [ ] File `news_detail.php` sudah dibuat
- [ ] Laragon running (MySQL hijau)
- [ ] Bisa akses http://localhost/desa_cendana/news.php
- [ ] Berita tampil dalam bentuk cards
- [ ] Tombol "Baca Selengkapnya" berfungsi

---

## 🔧 Troubleshooting

### Berita tidak tampil
- **Solusi**: Cek apakah data sudah diinsert ke database
  - Buka phpMyAdmin → desa_cendana → news → lihat isinya
  - Jika kosong, jalankan SQL INSERT lagi

### Error "Database Error"
- **Solusi**: Cek apakah MySQL running
  - Buka Laragon, pastikan MySQL indicator hijau
  - Check config/db.php, pastikan konfigurasi sesuai

### Gambar tidak tampil
- **Solusi**: Normal jika folder uploads kosong
  - Sistem akan otomatis menampilkan placeholder emerald
  - Atau upload gambar ke folder uploads/ dengan nama sesuai database

### Pagination tidak berfungsi
- **Solusi**: Jika ada 6+ berita, pagination otomatis tampil
  - Saat ini hanya ada 3 berita, jadi pagination belum terlihat
  - Tambah lebih banyak berita untuk melihat pagination bekerja

---

## 🚀 Menambah Berita Baru (Manual)

Jika ingin menambah berita tanpa command SQL, gunakan phpMyAdmin:

1. Buka phpMyAdmin
2. Pilih database `desa_cendana`
3. Pilih tabel `news`
4. Klik tab **Insert**
5. Isi form:
   - Title: Judul berita
   - Content: Isi berita
   - Image: Nama file (misal: news4.jpg)
   - Date: Tanggal publikasi
6. Klik **Go**

---

## 📞 Informasi Koneksi Database

```
Host: localhost
Username: root
Password: (kosong)
Database: desa_cendana
Port: 3306
```

Pastikan konfigurasi ini sama di `config/db.php`

---

## 🎯 Next Steps (Opsional)

1. **Admin CRUD** - Buat halaman untuk admin menambah/edit/hapus berita
2. **File Upload** - Implement upload gambar langsung
3. **Search** - Tambah fitur pencarian berita
4. **Kategori** - Pisahkan berita berdasarkan kategori
5. **Comments** - Izinkan pengunjung memberikan komentar

---

*Last Updated: January 19, 2026*
*Desa Cendana Website - News Module*
