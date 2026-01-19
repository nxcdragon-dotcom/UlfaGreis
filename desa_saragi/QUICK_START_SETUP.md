# 🚀 QUICK START - Database & Admin Setup

**Waktu Estimasi:** 5-10 menit
**Status:** Ready to implement

---

## 📋 Checklist Cepat (Copy & Follow)

### ✅ Step 1: Buat Tabel Database (2 menit)

1. Buka: `http://localhost/phpmyadmin`
2. Pilih database: `desa_cendana`
3. Klik tab: **SQL**
4. Copy-paste kode ini:

```sql
-- Tabel Berita
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Perangkat Desa
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

-- Tabel Galeri
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Data Contoh
INSERT INTO news (title, content, image) VALUES 
('Pembangunan Jalan Desa', 'Pemerintah Desa Cendana memulai proyek pengaspalan jalan utama untuk memperlancar ekonomi warga.', 'news1.jpg'),
('Festival Budaya Cendana', 'Mari hadiri festival tahunan yang menampilkan tarian tradisional dan pameran kerajinan tangan lokal.', 'news2.jpg'),
('Program Bibit Gratis', 'Pembagian bibit pohon cendana gratis untuk mendukung penghijauan lingkungan desa.', 'news3.jpg');

INSERT INTO officials (name, position, bio, phone, email) VALUES 
('Bapak Cendana', 'Kepala Desa', 'Kepala Desa yang berdedikasi.', '+62 812 3456 7890', 'kepala@desacendana.id'),
('Ibu Sari', 'Sekretaris Desa', 'Sekretaris yang bertanggung jawab.', '+62 812 3456 7891', 'sekretaris@desacendana.id'),
('Bapak Heri', 'Bendahara Desa', 'Pengelola keuangan desa.', '+62 812 3456 7892', 'bendahara@desacendana.id');

INSERT INTO gallery (title, image, description) VALUES 
('Acara Musyawarah Desa', 'gallery1.jpg', 'Foto dari acara musyawarah desa'),
('Kegiatan Gotong Royong', 'gallery2.jpg', 'Kegiatan gotong royong pembersihan'),
('Pelatihan Keterampilan', 'gallery3.jpg', 'Program pelatihan keterampilan');
```

5. Klik: **Go** atau **Execute**
6. Tunggu ✅ "Query successful"

### ✅ Step 2: Buat Folder Uploads (1 menit)

1. Buka File Explorer
2. Navigasi ke: `c:\laragon\www\desa_cendana\`
3. Klik kanan → **New Folder** → `uploads`
4. Done! ✅

### ✅ Step 3: Test Halaman Berita (1 menit)

1. Refresh browser: `http://localhost/desa_cendana/news.php`
2. Lihat 3 berita dalam bentuk cards ✅

### ✅ Step 4: Test Halaman Perangkat (1 menit)

1. Buka: `http://localhost/desa_cendana/officials.php`
2. Lihat 3 perangkat desa ✅

### ✅ Step 5: Test Form Tambah Berita Admin (2 menit)

1. Buka: `http://localhost/desa_cendana/admin/login.php`
2. Login: `admin` / `admin123`
3. Akses: `http://localhost/desa_cendana/admin/add_news.php`
4. Isi form dan klik **Simpan Berita**
5. Cek di `news.php` - berita baru harus muncul! ✅

---

## 🎯 Hasil Akhir

Setelah semua steps selesai, Anda akan punya:

✅ Database dengan 4 tabel (users, news, officials, gallery)
✅ 3 berita contoh di halaman news.php
✅ 3 perangkat desa di halaman officials.php
✅ 3 foto galeri di halaman gallery.php
✅ Form admin untuk tambah berita baru
✅ Upload gambar otomatis ke folder uploads/

---

## 📂 File Struktur Sekarang

```
desa_cendana/
├── index.php                    ✅ Homepage
├── news.php                     ✅ Daftar berita
├── news_detail.php              ✅ Detail berita
├── officials.php                ✅ Perangkat desa
├── gallery.php                  ✅ Galeri foto
├── admin/
│   ├── login.php                ✅ Login admin
│   ├── dashboard.php            ✅ Dashboard admin
│   ├── add_news.php             ✨ NEW - Tambah berita
│   └── logout.php               ✅ Logout
├── config/
│   └── db.php                   ✅ Database config
├── uploads/                     ✨ NEW - Folder gambar
├── assets/                      (CSS, JS, images)
└── DATABASE_SETUP_COMPLETE.md   ✨ NEW - Setup guide
```

---

## 🔗 URL Yang Penting

| Halaman | URL |
|---------|-----|
| Homepage | `http://localhost/desa_cendana/` |
| Berita | `http://localhost/desa_cendana/news.php` |
| Perangkat | `http://localhost/desa_cendana/officials.php` |
| Galeri | `http://localhost/desa_cendana/gallery.php` |
| **Login Admin** | `http://localhost/desa_cendana/admin/login.php` |
| **Dashboard** | `http://localhost/desa_cendana/admin/dashboard.php` |
| **Tambah Berita** | `http://localhost/desa_cendana/admin/add_news.php` |
| phpMyAdmin | `http://localhost/phpmyadmin` |

---

## 👤 Akun Admin

```
Username: admin
Password: admin123
```

⚠️ **PENTING:** Ubah password setelah login pertama!

---

## 🔐 Kredensial Database

```
Host:     localhost
Username: root
Password: (kosong)
Database: desa_cendana
```

📁 **Config file:** `config/db.php`

---

## 📝 Contoh Data yang Sudah Ada

### Berita (3 items)
1. Pembangunan Jalan Desa
2. Festival Budaya Cendana
3. Program Bibit Gratis

### Perangkat (3 items)
1. Bapak Cendana - Kepala Desa
2. Ibu Sari - Sekretaris Desa
3. Bapak Heri - Bendahara Desa

### Galeri (3 items)
1. Acara Musyawarah Desa
2. Kegiatan Gotong Royong
3. Pelatihan Keterampilan

---

## 🚨 Jika Ada Error

### ❌ Parse Error di news.php
**Solusi:** Refresh halaman (sudah diperbaiki)

### ❌ Table not found
**Solusi:** Jalankan SQL create table commands di phpMyAdmin

### ❌ Gambar tidak muncul
**Solusi:** Normal, gunakan form admin/add_news.php untuk upload

### ❌ Database connection error
**Solusi:** 
1. Buka Laragon
2. Pastikan MySQL running (hijau ✅)
3. Check config/db.php setting

---

## 💡 Tips

1. **Refresh Browser:** Setelah create table, refresh halaman dengan Ctrl+F5
2. **Upload Gambar:** Gunakan form di admin/add_news.php, bukan upload manual
3. **Password Admin:** Harus di-hash dengan bcrypt, gunakan form untuk create user baru
4. **Backup Database:** Export dari phpMyAdmin sebelum eksperimen

---

## 📚 Dokumentasi Lengkap

Baca file-file ini untuk detail lebih:

- `DATABASE_SETUP_COMPLETE.md` - Database setup detail
- `ADMIN_ADD_NEWS_GUIDE.md` - Admin tambah berita detail
- `LOGIN_READY.md` - Login system detail
- `NEWS_SETUP.md` - News module detail

---

## ⏱️ Timeline

```
T+0 min    : Mulai baca panduan ini
T+2 min    : Jalankan SQL di phpMyAdmin
T+3 min    : Buat folder uploads
T+4 min    : Test halaman news.php
T+5 min    : Test halaman officials.php
T+6 min    : Login ke admin panel
T+8 min    : Test form tambah berita
T+10 min   : Selesai! ✅
```

---

## ✨ Apa yang Bisa Dilakukan Sekarang

✅ Lihat berita dari database
✅ Lihat perangkat desa dari database
✅ Lihat galeri dari database
✅ Login sebagai admin
✅ Tambah berita baru via form
✅ Upload gambar otomatis
✅ Lihat berita detail
✅ Pagination berita

❌ (Belum ada) Edit berita
❌ (Belum ada) Delete berita
❌ (Belum ada) User management
❌ (Belum ada) Email notification

---

## 🎉 Selamat!

Jika semua step sudah selesai, berarti:
- ✅ Database sudah setup
- ✅ Tabel sudah dibuat
- ✅ Data contoh sudah ada
- ✅ Admin dapat tambah berita
- ✅ Website siap digunakan!

---

## 📞 Support

Jika ada masalah:
1. Cek error message (merah di halaman)
2. Cek folder structure
3. Cek MySQL running di Laragon
4. Cek SQL command berhasil di phpMyAdmin
5. Baca dokumentasi di folder project

---

**Waktu Update:** January 19, 2026
**Status:** Production Ready ✅
**Version:** 1.0

Enjoy your Desa Cendana website! 🌿
