# 🌿 Desa Cendana - Website Desa Wisata

Selamat datang di proyek website Desa Cendana! Ini adalah aplikasi web full-stack untuk mengelola informasi dan konten desa dengan desain yang indah dan responsif.

## 📋 Daftar Isi
- [Fitur Utama](#-fitur-utama)
- [Struktur Folder](#-struktur-folder)
- [Instalasi & Setup](#-instalasi--setup)
- [Database Schema](#-database-schema)
- [Akses Website](#-akses-website)
- [Akun Admin Default](#-akun-admin-default)
- [File-File yang Dibuat](#-file-file-yang-dibuat)

---

## ✨ Fitur Utama

### 🏠 Website Publik
- **Homepage (index.php)** - Halaman utama dengan hero section, berita terbaru, dan profil pejabat
- **News Page (news.php)** - Daftar lengkap berita desa dengan pagination
- **Officials Page (officials.php)** - Profil dan struktur organisasi perangkat desa
- **Gallery Page (gallery.php)** - Galeri foto kegiatan desa
- **Navigation Bar** - Menu responsif dengan hamburger menu untuk mobile
- **Footer** - Informasi kontak dan link cepat

### 🔐 Admin Panel
- **Login (admin/login.php)** - Halaman login dengan "Remember Me" feature
- **Dashboard (admin/dashboard.php)** - Ringkasan konten dan quick actions
- **Logout (admin/logout.php)** - Keluar dari akun admin dengan session cleanup

### 🛠️ Teknologi yang Digunakan
- **Frontend**: HTML5, Tailwind CSS (CDN), Vanilla JavaScript
- **Backend**: Native PHP (tanpa framework)
- **Database**: MySQL dengan PDO
- **Security**: Password hashing dengan `password_hash()`, Prepared Statements, Session management

---

## 📁 Struktur Folder

```
desa_cendana/
├── admin/
│   ├── login.php           # Halaman login admin
│   ├── dashboard.php       # Admin control panel
│   ├── logout.php          # Logout dan session cleanup
│   ├── news_manage.php     # (akan dibuat) CRUD berita
│   ├── officials_manage.php# (akan dibuat) CRUD pejabat
│   ├── gallery_manage.php  # (akan dibuat) CRUD galeri
│   └── users_manage.php    # (akan dibuat) Kelola user admin
│
├── assets/
│   ├── css/                # CSS files (jika diperlukan)
│   ├── js/                 # JavaScript files
│   └── images/             # Image assets
│
├── config/
│   └── database.php        # Database connection class (PDO)
│
├── includes/
│   └── (untuk future helpers/functions)
│
├── public/
│   └── (public facing files jika diperlukan)
│
├── uploads/
│   ├── news/               # Upload berita
│   ├── officials/          # Upload foto pejabat
│   └── gallery/            # Upload galeri
│
├── index.php               # Homepage
├── news.php                # Halaman berita
├── officials.php           # Halaman pejabat
├── gallery.php             # Halaman galeri
├── database.sql            # SQL schema
├── README.md               # Dokumentasi (file ini)
└── .htaccess               # (optional) URL rewriting

```

---

## 🚀 Instalasi & Setup

### 1️⃣ Download & Ekstrak Proyek
```bash
# Copy folder desa_cendana ke direktori web Anda
# Contoh: C:\laragon\www\desa_cendana
```

### 2️⃣ Setup Database
```bash
# Buka phpMyAdmin atau MySQL command line
# Jalankan file database.sql untuk membuat database dan tabel
```

**Tabel yang dibuat:**
- `users` - Data admin login
- `news` - Artikel berita
- `officials` - Profil perangkat desa
- `gallery` - Galeri foto

### 3️⃣ Konfigurasi Database (Optional)
Edit `config/database.php` jika konfigurasi database berbeda:
```php
private const HOST = 'localhost';           // Host database
private const DB_NAME = 'desa_cendana';     // Nama database
private const DB_USER = 'root';             // Username MySQL
private const DB_PASSWORD = '';             // Password MySQL
private const DB_PORT = 3306;               // Port MySQL
```

### 4️⃣ Buat Folder Uploads
Pastikan folder uploads telah dibuat dengan permissions yang benar:
```bash
mkdir uploads
mkdir uploads/news
mkdir uploads/officials
mkdir uploads/gallery
chmod 755 uploads
```

---

## 📊 Database Schema

### Tabel `users`
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,      -- Hashed dengan password_hash()
    full_name VARCHAR(100),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Tabel `news`
```sql
CREATE TABLE news (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    content LONGTEXT NOT NULL,
    image VARCHAR(255),                 -- Filename gambar
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Tabel `officials`
```sql
CREATE TABLE officials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    photo VARCHAR(255),                 -- Filename foto
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Tabel `gallery`
```sql
CREATE TABLE gallery (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    image VARCHAR(255) NOT NULL,        -- Filename gambar
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 🌐 Akses Website

### Public Website
```
http://localhost/desa_cendana/
```

**Halaman-halaman publik:**
- `http://localhost/desa_cendana/index.php` - Homepage
- `http://localhost/desa_cendana/news.php` - Berita Desa
- `http://localhost/desa_cendana/officials.php` - Perangkat Desa
- `http://localhost/desa_cendana/gallery.php` - Galeri Desa

### Admin Panel
```
http://localhost/desa_cendana/admin/login.php
```

**Halaman admin:**
- `http://localhost/desa_cendana/admin/dashboard.php` - Dashboard (setelah login)
- `http://localhost/desa_cendana/admin/logout.php` - Logout

---

## 🔑 Akun Admin Default

Setelah menjalankan `database.sql`, ada 1 akun admin default:

| Field | Value |
|-------|-------|
| **Username** | admin |
| **Password** | admin123 |
| **Full Name** | Administrator |

⚠️ **PENTING**: Ubah password ini segera setelah login pertama kali!

Untuk mengubah password, jalankan query SQL:
```sql
-- Ganti 'new_password' dengan password baru
UPDATE users SET password = '$2y$10$...' WHERE username = 'admin';
```

Atau gunakan PHP untuk generate hash:
```php
<?php
echo password_hash('new_password', PASSWORD_DEFAULT);
?>
```

---

## 📄 File-File yang Dibuat

### 🏠 Frontend Pages
| File | Deskripsi |
|------|-----------|
| `index.php` | Homepage dengan navbar, hero section, news, officials, footer |
| `news.php` | Halaman berita dengan pagination |
| `officials.php` | Halaman profil perangkat desa |
| `gallery.php` | Halaman galeri foto dengan pagination |

### 🔐 Admin Pages
| File | Deskripsi |
|------|-----------|
| `admin/login.php` | Form login admin dengan session management |
| `admin/dashboard.php` | Dashboard dengan statistik dan quick actions |
| `admin/logout.php` | Script logout dan session cleanup |

### ⚙️ Backend
| File | Deskripsi |
|------|-----------|
| `config/database.php` | Kelas Database dengan PDO connection (Singleton pattern) |

---

## 🎨 Design & Styling

- **Color Palette**: Emerald Green (#047857), Green (#16a34a), dengan accent Beige
- **Framework CSS**: Tailwind CSS (CDN)
- **Responsive Design**: Mobile-first approach dengan Tailwind breakpoints
- **Icons**: Emoji dan SVG icons untuk visual appeal

---

## 🔒 Security Features

✅ **Password Security**
- Menggunakan `password_hash()` dengan default algorithm (bcrypt)
- Verifikasi dengan `password_verify()`

✅ **SQL Injection Prevention**
- Semua query menggunakan Prepared Statements dengan PDO
- Parameter binding untuk semua input user

✅ **Session Management**
- Session-based authentication untuk admin
- Session timeout dapat dikonfigurasi di `php.ini`

✅ **Input Validation & Sanitization**
- `htmlspecialchars()` untuk XSS prevention pada output
- `trim()` untuk input cleaning

---

## 📝 TODO: File yang Masih Perlu Dibuat

Untuk implementasi CRUD lengkap, masih perlu membuat:

- [ ] `admin/news_manage.php` - CRUD untuk berita
- [ ] `admin/officials_manage.php` - CRUD untuk pejabat
- [ ] `admin/gallery_manage.php` - CRUD untuk galeri
- [ ] `admin/users_manage.php` - Kelola user admin
- [ ] Halaman detail berita (news_detail.php)
- [ ] .htaccess untuk URL rewriting (opsional)

---

## 🐛 Troubleshooting

### Error: "Database Connection Error"
**Solusi:**
- Pastikan MySQL server berjalan
- Periksa konfigurasi di `config/database.php`
- Verifikasi database `desa_cendana` sudah dibuat

### Error: "No news available" di halaman news
**Solusi:**
- Insert data berita ke tabel `news` terlebih dahulu
- Atau gunakan admin panel untuk menambah berita

### Login gagal meski password benar
**Solusi:**
- Pastikan tabel `users` sudah ada dan memiliki data
- Cek bahwa password di-hash dengan `password_hash()`
- Bersihkan browser cache/cookies

### File upload tidak berfungsi
**Solusi:**
- Periksa folder `uploads/` memiliki write permission (755 atau 777)
- Pastikan max_upload_size di `php.ini` cukup besar

---

## 📞 Kontak & Support

Untuk pertanyaan atau laporan bug, silakan hubungi administrator desa.

**Email:** info@desacendana.id  
**Telepon:** +62 XXX XXXX XXXX

---

## 📄 Lisensi

Proyek ini adalah proprietary software untuk Desa Cendana.

---

**Dibuat dengan ❤️ untuk Desa Cendana**  
*Last Updated: January 19, 2026*
