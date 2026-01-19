# ✨ ADMIN TAMBAH BERITA - Quick Reference

## 🎯 Fitur Baru: admin/add_news.php

**File:** `c:\laragon\www\desa_cendana\admin\add_news.php`
**Akses:** Hanya untuk admin yang sudah login
**URL:** `http://localhost/desa_cendana/admin/add_news.php`

---

## 📋 Apa yang Bisa Dilakukan

✅ Menulis berita langsung di form
✅ Upload gambar saat membuat berita
✅ Validasi input otomatis (judul & isi wajib)
✅ Support drag-and-drop untuk upload gambar
✅ Preview nama file yang diupload
✅ Pesan error dan success otomatis
✅ Gambar otomatis disimpan ke folder uploads/

---

## 🚀 Cara Menggunakan

### Langkah 1: Login Admin
```
Buka: http://localhost/desa_cendana/admin/login.php
Username: admin
Password: admin123
→ Masuk ke dashboard.php
```

### Langkah 2: Akses Form Tambah Berita
```
Pilih salah satu:
A) Klik tombol "Tambah Berita" di dashboard (jika ada)
B) Ketik URL langsung: http://localhost/desa_cendana/admin/add_news.php
```

### Langkah 3: Isi Form

**Field 1: Judul Berita** 📝
```
- Wajib diisi
- Min 5 karakter (tips)
- Contoh: "Pembangunan Jalan Baru"
```

**Field 2: Isi Berita** 📄
```
- Wajib diisi
- Bisa panjang (TEXT unlimited)
- Gunakan baris baru untuk paragraf baru
- Contoh:
  Pemerintah desa memulai proyek...
  
  Proyek ini diharapkan selesai dalam...
```

**Field 3: Gambar Berita** 🖼️
```
- OPSIONAL (tidak wajib)
- Format: JPG, PNG, GIF, WebP
- Max 5MB
- Cara upload:
  A) Klik kotak → pilih file
  B) Drag-drop gambar ke kotak
```

### Langkah 4: Klik "Simpan Berita"

Sistem akan:
1. ✅ Validasi input (judul & isi harus ada)
2. ✅ Validasi file (tipe dan ukuran)
3. ✅ Upload gambar ke folder `/uploads/` (jika ada)
4. ✅ Simpan ke database
5. ✅ Tampilkan pesan sukses ✅

---

## 📸 Upload Gambar - Detail

### Tipe File yang Didukung:
- ✅ JPG / JPEG
- ✅ PNG
- ✅ GIF
- ✅ WebP

### Ukuran Maksimal:
- ✅ 5 MB (megabyte)

### Nama File Otomatis:
```
Format: TIMESTAMP_NAMA_ASLI
Contoh: 1674086400_gambar_berita.jpg

Keuntungan:
- Tidak ada konflik nama file
- Nama unik setiap kali upload
- Mudah tracking waktu upload
```

### Lokasi Penyimpanan:
```
Folder: /uploads/
Path Lengkap: c:\laragon\www\desa_cendana\uploads\
```

### Jika Gambar Tidak Diupload:
```
- Berita tetap tersimpan tanpa gambar
- Halaman berita akan tampilkan placeholder hijau
- Bisa upload gambar nanti via edit berita (fitur belum tersedia)
```

---

## ✅ Validasi Form

### Judul Berita
```
❌ SALAH: (kosong)
✅ BENAR: "Pembangunan Jalan Desa"
```

### Isi Berita
```
❌ SALAH: (kosong)
✅ BENAR: "Pemerintah memulai proyek... (bisa panjang)"
```

### Gambar
```
❌ SALAH: File PDF, Video, txt
✅ BENAR: JPG, PNG, GIF (maksimal 5MB)
```

---

## 🎨 Form Fields Details

### 1. Judul Berita (Title)
```
- Input type: TEXT
- Placeholder: "Masukkan judul berita yang menarik..."
- Wajib diisi
- Maksimal 255 karakter
```

### 2. Isi Berita (Content)
```
- Input type: TEXTAREA (10 baris)
- Placeholder: "Tulis isi berita di sini..."
- Wajib diisi
- Unlimited (TEXT type)
- Bisa enter untuk baris baru
```

### 3. Gambar Berita (Image)
```
- Input type: FILE
- Accept: image/*
- Opsional
- Drag-drop support
- File size validation
```

---

## 📊 Data Tersimpan di Database

Setelah klik "Simpan Berita", data disimpan:

```sql
Tabel: news
Kolom:
- id: Nomor unik (auto)
- title: Judul yang kamu tulis
- content: Isi yang kamu tulis
- image: Nama file (jika upload)
- date: Tanggal sekarang (auto)
- created_at: Waktu sekarang (auto)
```

### Contoh Data Tersimpan:
```
id: 4
title: "Pembangunan Jalan Desa"
content: "Pemerintah Desa Cendana..."
image: "1674086400_berita_baru.jpg"
date: 2026-01-19 14:30:45
created_at: 2026-01-19 14:30:45
```

---

## 🔄 Alur Proses Upload Gambar

```
User upload gambar
    ↓
Validasi tipe file (harus image)
    ↓
Validasi ukuran (max 5MB)
    ↓
Generate nama unik (timestamp + nama)
    ↓
Move file ke folder /uploads/
    ↓
Simpan nama file ke database
    ↓
Berita selesai dibuat! ✅
```

---

## 🛠️ Fitur Backend (Technical)

### File Processing:
- Menggunakan `move_uploaded_file()`
- Folder `uploads/` dibuat otomatis jika belum ada
- Permissions: 0755 untuk folder

### Database:
- PDO prepared statements (SQL injection safe)
- Timestamp otomatis dengan `NOW()`
- Character set: utf8mb4

### Error Handling:
```
- Judul kosong → "Judul berita harus diisi!"
- Isi kosong → "Isi berita harus diisi!"
- Format file salah → "Format file tidak didukung!"
- File terlalu besar → "Ukuran file terlalu besar! Maksimal 5MB."
- Upload gagal → "Gagal mengunggah gambar..."
- Database error → "Error: [pesan error]"
```

---

## 📝 Tips Menulis Berita Baik

1. **Judul**
   - Menarik dan deskriptif
   - Jangan terlalu panjang
   - Gunakan kata kunci penting

2. **Isi**
   - Mulai dengan paragraf pembuka yang kuat
   - Gunakan bahasa yang jelas
   - Gunakan baris baru untuk paragraf baru
   - Proofread sebelum simpan

3. **Gambar**
   - Resolusi cukup (min 400x250px)
   - Format modern (JPG atau PNG)
   - Ukuran tidak terlalu besar (<5MB)
   - Relevan dengan isi berita

---

## ✨ User Experience (UX)

### Success Message
```
Tampilan: ✅ Berita berhasil ditambahkan!
Warna: Hijau
Durasi: Permanen (sampai user refresh/pergi)
Action: Form di-reset (kosong) untuk berita baru
```

### Error Message
```
Tampilan: ❌ [Pesan error]
Warna: Merah
Durasi: Permanen
Action: Form tidak di-reset (data tetap ada)
```

### File Selected
```
Tampilan: ✅ nama_file.jpg (0.25 MB)
Lokasi: Di bawah kotak drag-drop
Update: Real-time saat file dipilih
```

---

## 🔐 Security Features

✅ **Input Validation**
- Judul dan isi harus ada
- Tipe file divalidasi
- Ukuran file dibatasi

✅ **SQL Injection Prevention**
- Menggunakan prepared statements (PDO)
- Semua input di-escape otomatis

✅ **File Upload Security**
- Validasi MIME type
- Rename file dengan timestamp
- Folder uploads/ bukan public execution zone

✅ **Session Protection**
- Hanya admin yang login bisa akses
- Check session di awal script

---

## 🚀 Testing Checklist

- [ ] Bisa akses form (sudah login admin)
- [ ] Judul field bisa di-input
- [ ] Content field bisa di-input
- [ ] File upload bisa dipilih
- [ ] Nama file ditampilkan setelah dipilih
- [ ] Tombol Simpan berfungsi
- [ ] Pesan sukses muncul
- [ ] Form di-reset setelah sukses
- [ ] Data tersimpan di database
- [ ] Gambar ada di folder uploads/
- [ ] Berita baru tampil di news.php
- [ ] Bisa baca detail di news_detail.php

---

## 📞 Troubleshooting

### ❌ "Gagal mengunggah gambar"
**Penyebab:** Folder uploads/ tidak ada
**Solusi:** 
1. Sistem akan buat otomatis
2. Jika masih error, buat manual di root folder

### ❌ "Format file tidak didukung"
**Penyebab:** Upload file bukan gambar (pdf, txt, dll)
**Solusi:** Pilih file JPG, PNG, GIF, atau WebP

### ❌ "Ukuran file terlalu besar"
**Penyebab:** File > 5MB
**Solusi:** Compress gambar atau pilih file lebih kecil

### ❌ "Database Error"
**Penyebab:** MySQL tidak running atau config salah
**Solusi:** 
1. Buka Laragon
2. Pastikan MySQL hijau ✅

---

## 🔗 Related Files

- `config/db.php` - Database connection
- `news.php` - Halaman daftar berita
- `news_detail.php` - Halaman detail berita
- `uploads/` - Folder penyimpanan gambar

---

## 📚 Database Query Reference

### Cek berita terakhir:
```sql
SELECT * FROM news ORDER BY date DESC LIMIT 1;
```

### Cek file yang diupload:
```sql
SELECT title, image, date FROM news WHERE image != '';
```

### Hapus berita tertentu:
```sql
DELETE FROM news WHERE id = 4;
```

---

## 🎉 Next Steps

Setelah fitur ini berjalan lancar:
1. ✅ Edit berita (update form)
2. ✅ Delete berita (dengan konfirmasi)
3. ✅ List berita di dashboard admin
4. ✅ Search berita
5. ✅ Kategori berita

---

*Last Updated: January 19, 2026*
*Desa Cendana Website - Admin Add News Feature*
