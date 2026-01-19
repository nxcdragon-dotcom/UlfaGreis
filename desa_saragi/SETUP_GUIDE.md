# 🚀 DESA CENDANA - PANDUAN SETUP LENGKAP

Panduan langkah demi langkah untuk mengatur dan menjalankan Website Desa Cendana di Laragon atau server lokal Anda.

---

## 📋 Prasyarat

Sebelum memulai, pastikan Anda memiliki:
- ✅ **Laragon** atau **XAMPP** terinstall dan running
- ✅ **MySQL/MariaDB** aktif
- ✅ **PHP 7.4+** atau versi lebih baru
- ✅ **Text Editor** seperti VS Code
- ✅ **Database client** seperti phpMyAdmin atau MySQL CLI

---

## 🔧 STEP 1: Persiapan Folder Proyek

### 1.1 Navigasi ke folder web
```bash
# Jika menggunakan Laragon
cd C:\laragon\www

# Jika menggunakan XAMPP
cd C:\xampp\htdocs
```

### 1.2 Verifikasi folder desa_cendana sudah ada
```bash
dir desa_cendana
# Atau di Linux/Mac:
ls desa_cendana
```

Struktur folder seharusnya terlihat seperti ini:
```
desa_cendana/
├── admin/
├── assets/
├── config/
├── includes/
├── public/
├── uploads/
├── index.php
├── news.php
├── officials.php
├── gallery.php
├── database.sql
└── config/database.php
```

---

## 🗄️ STEP 2: Setup Database

### 2.1 Buka phpMyAdmin
```
Di Laragon:
- Klik icon Laragon → klik DB → atau buka http://localhost/phpmyadmin

Di XAMPP:
- Buka http://localhost/phpmyadmin
```

### 2.2 Import file database.sql

**Metode 1: Melalui phpMyAdmin UI**
1. Klik tab **"Import"** di halaman phpMyAdmin
2. Klik **"Choose File"** dan pilih file `database.sql` dari folder `desa_cendana`
3. Klik tombol **"Import"**
4. Tunggu proses selesai ✅

**Metode 2: Melalui MySQL Command Line**
```bash
# Login ke MySQL
mysql -u root -p

# Jika di Laragon (default no password)
mysql -u root

# Kemudian jalankan:
USE mysql;
source C:\laragon\www\desa_cendana\database.sql

# Atau
mysql -u root < C:\laragon\www\desa_cendana\database.sql
```

### 2.3 Verifikasi Database
Di phpMyAdmin atau MySQL CLI, jalankan:
```sql
-- Lihat database yang ada
SHOW DATABASES;

-- Gunakan database desa_cendana
USE desa_cendana;

-- Lihat tabel yang dibuat
SHOW TABLES;

-- Lihat data users
SELECT * FROM users;

-- Hasil yang diharapkan:
-- id=1, username=admin, role=admin
```

✅ **Database sudah siap!**

---

## ⚙️ STEP 3: Konfigurasi PHP (Optional)

Jika database Anda menggunakan konfigurasi berbeda, edit file `config/database.php`:

```php
<?php
// Ganti nilai berikut sesuai konfigurasi Anda:

class Database {
    private const HOST = 'localhost';           // Host MySQL
    private const DB_NAME = 'desa_cendana';     // Nama database
    private const DB_USER = 'root';             // Username MySQL
    private const DB_PASSWORD = '';             // Password MySQL (kosong jika tidak ada)
    private const DB_PORT = 3306;               // Port MySQL
    private const CHARSET = 'utf8mb4';          // Character set
    // ... rest of code
}
```

---

## 📁 STEP 4: Setup Folder Uploads

Folder ini digunakan untuk menyimpan file upload (gambar berita, foto pejabat, galeri).

### 4.1 Verifikasi folder ada
```bash
# Lihat isi folder uploads
dir C:\laragon\www\desa_cendana\uploads
```

### 4.2 Buat subfolder jika belum ada
```bash
# Di Command Prompt
mkdir C:\laragon\www\desa_cendana\uploads\news
mkdir C:\laragon\www\desa_cendana\uploads\officials
mkdir C:\laragon\www\desa_cendana\uploads\gallery
```

### 4.3 Set permission (Windows: optional, Linux: important)
Untuk Linux/Mac, set folder permission:
```bash
chmod -R 755 uploads/
chmod -R 777 uploads/  # Jika diperlukan write access
```

---

## 🌐 STEP 5: Akses Website

### 5.1 Mulai Laragon/XAMPP
- **Laragon**: Klik start button di aplikasi Laragon
- **XAMPP**: Klik "Start" pada Apache dan MySQL

### 5.2 Akses halaman publik di browser
```
Homepage:       http://localhost/desa_cendana/
Berita:         http://localhost/desa_cendana/news.php
Pejabat:        http://localhost/desa_cendana/officials.php
Galeri:         http://localhost/desa_cendana/gallery.php
Admin Login:    http://localhost/desa_cendana/admin/login.php
```

### 5.3 Cek apakah halaman muncul dengan benar
✅ Navbar harus visible dengan menu Home, Berita, Pejabat, Galeri, Login Admin  
✅ Konten berita harus tampil (dari database)  
✅ Profil pejabat harus tampil (dari database)  
✅ Footer harus visible

---

## 🔓 STEP 6: Login ke Admin Panel

### 6.1 Buka halaman login
```
http://localhost/desa_cendana/admin/login.php
```

### 6.2 Masukkan kredensial default
| Field | Value |
|-------|-------|
| Username | `admin` |
| Password | `admin123` |
| Remember Me | Checked (opsional) |

### 6.3 Klik tombol "🔓 Masuk"

**Hasil yang diharapkan:**
- ✅ Redirect ke `admin/dashboard.php`
- ✅ Dashboard menampilkan statistik konten (3 berita, 3 pejabat, 0 galeri awal)
- ✅ Navbar admin menampilkan nama "Administrator"
- ✅ Sidebar navigation terlihat

---

## 🔐 STEP 7: Ubah Password Admin (PENTING!)

**Jangan lupa mengubah password default untuk keamanan!**

### 7.1 Generate password hash baru
```php
<?php
// Buat file test.php di root desa_cendana
echo password_hash('password_baru_anda', PASSWORD_DEFAULT);
// Copy hasil output (misal: $2y$10$abc123...)
?>
```

### 7.2 Update password di database
Buka phpMyAdmin:
1. Buka tabel `users`
2. Edit baris admin
3. Ganti field `password` dengan hash yang sudah di-generate
4. Klik "Save"

**Atau gunakan SQL query:**
```sql
UPDATE users SET password = '$2y$10$YourNewHashHere...' WHERE username = 'admin';
```

### 7.3 Test login dengan password baru
```
http://localhost/desa_cendana/admin/login.php
Username: admin
Password: password_baru_anda
```

✅ **Selesai! Password sudah diupdate.**

---

## 📝 STEP 8: Tambah Data Sample (Optional)

Untuk testing, Anda bisa menambah data melalui phpMyAdmin:

### 8.1 Tambah Berita
Buka tabel `news` dan insert:
```sql
INSERT INTO news (title, content, author_id, image) VALUES 
('Judul Berita Baru', 'Konten berita yang panjang...', 1, 'nama_gambar.jpg');
```

### 8.2 Tambah Pejabat
```sql
INSERT INTO officials (name, position, bio, phone, email) VALUES 
('Nama Pejabat', 'Posisi/Jabatan', 'Biografi singkat', '08xxxxx', 'email@desa.local');
```

### 8.3 Tambah Galeri
```sql
INSERT INTO gallery (title, image, description) VALUES 
('Judul Foto', 'nama_foto.jpg', 'Deskripsi foto');
```

---

## ✅ CHECKLIST: Setup Selesai?

Centang semua item ini untuk memastikan setup berhasil:

- [ ] MySQL database `desa_cendana` sudah dibuat
- [ ] Tabel `users`, `news`, `officials`, `gallery` sudah ada
- [ ] Admin user dengan username `admin` sudah ada
- [ ] Folder `uploads` dan subfoldernya sudah ada
- [ ] `config/database.php` dikonfigurasi dengan benar
- [ ] Dapat akses halaman publik: `http://localhost/desa_cendana/`
- [ ] Dapat akses admin login: `http://localhost/desa_cendana/admin/login.php`
- [ ] Dapat login dengan kredensial admin
- [ ] Dashboard admin menampilkan data dengan benar
- [ ] Password admin sudah diubah ke password yang aman

✅ **Jika semua terpenuhi, Website Desa Cendana sudah siap digunakan!**

---

## 🐛 Troubleshooting

### ❌ Error: "Database Connection Error"

**Kemungkinan penyebab:**
1. MySQL tidak running
2. Database tidak dibuat
3. Konfigurasi di `config/database.php` salah

**Solusi:**
```bash
# Cek apakah MySQL running (Laragon)
# Klik "Start" di Laragon app

# Verifikasi database dibuat
mysql -u root -p
SHOW DATABASES;  # Cari 'desa_cendana'

# Edit config/database.php jika perlu sesuaikan HOST, DB_USER, DB_PASSWORD
```

### ❌ Error: "No data" di halaman berita/pejabat

**Penyebab:**
- Data sample belum diinsert saat import database.sql

**Solusi:**
- Manually insert sample data melalui phpMyAdmin (lihat STEP 8)

### ❌ Error 404 saat akses admin pages

**Penyebab:**
- File `admin/login.php` tidak ada
- Path URL salah

**Solusi:**
```bash
# Verifikasi file admin ada
dir C:\laragon\www\desa_cendana\admin

# Pastikan URL benar:
http://localhost/desa_cendana/admin/login.php
```

### ❌ Login gagal dengan password benar

**Penyebab:**
- Session tidak working
- Browser cookies disabled

**Solusi:**
```bash
# Enable cookies di browser settings

# Atau test dengan browser baru/incognito mode

# Verifikasi user ada di database:
mysql -u root
USE desa_cendana;
SELECT * FROM users WHERE username='admin';
```

### ❌ Upload file tidak berfungsi (saat CRUD aktif nanti)

**Penyebab:**
- Folder uploads tidak ada write permission
- Max upload size di php.ini terlalu kecil

**Solusi:**
```bash
# Buat subfolder jika belum ada
mkdir uploads
mkdir uploads/news
mkdir uploads/officials
mkdir uploads/gallery

# Linux/Mac: set permission
chmod -R 777 uploads/

# Cek php.ini
# upload_max_filesize = 20M
# post_max_size = 20M
```

---

## 📚 File-File Penting

| File | Lokasi | Fungsi |
|------|--------|--------|
| **database.php** | `config/` | Database connection config |
| **database.sql** | Root | Schema & sample data |
| **index.php** | Root | Homepage |
| **news.php** | Root | Halaman berita |
| **officials.php** | Root | Halaman pejabat |
| **gallery.php** | Root | Halaman galeri |
| **login.php** | `admin/` | Admin login page |
| **dashboard.php** | `admin/` | Admin dashboard |
| **logout.php** | `admin/` | Logout handler |
| **README.md** | Root | Dokumentasi project |

---

## 🎯 Next Steps

Setelah setup selesai:

1. **Explore halaman publik** - Pastikan semua page berfungsi
2. **Test admin login** - Pastikan bisa login dan logout
3. **Ubah password admin** - Jangan gunakan default password
4. **Tambah sample data** - Insert berita, pejabat, galeri untuk testing
5. **Periksa design** - Pastikan responsive di mobile
6. **Check database** - Verifikasi semua tabel & data

Untuk implementasi CRUD (Create, Read, Update, Delete), lihat file:
- [CHECKLIST.md](./CHECKLIST.md) - Progress tracking
- [README.md](./README.md) - Dokumentasi lengkap

---

## 📞 Support & Issues

Jika ada masalah:
1. Cek **Troubleshooting** section di atas
2. Lihat error message di browser (F12 → Console)
3. Check database di phpMyAdmin
4. Lihat `php error_log` (di Laragon: `C:\laragon\logs\`)

---

**Selamat! Website Desa Cendana sudah siap digunakan! 🎉**

*Last Updated: January 19, 2026*
