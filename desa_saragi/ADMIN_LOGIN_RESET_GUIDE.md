# 🔐 ADMIN LOGIN RESET - Complete Guide

**Purpose:** Fix login error "Username atau password salah"
**Status:** Step-by-step instructions to restore login

---

## 🎯 Apa Masalahnya?

```
Error: "Username atau password salah"
Penyebab: Password di database tidak di-hash dengan benar
Solusi: Reset dengan password yang sudah di-hash dengan bcrypt
```

---

## ✅ 3 Langkah Perbaikan (5 Menit)

### **LANGKAH 1: Reset Data Admin di phpMyAdmin** (2 menit)

**Buka:**
```
http://localhost/phpmyadmin
```

**Pilih:**
1. Database: `desa_cendana`
2. Tab: `SQL`

**Copy & Paste kode ini:**

```sql
-- Hapus user lama
DELETE FROM users WHERE username = 'admin';

-- Masukkan user admin baru dengan password TERENKRIPSI
-- Username: admin
-- Password: password123 (sudah di-hash dengan bcrypt $2y$10$)
INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$0VrcP7WkF1YzJVrPwFGdde5HPsJDUQh6S4RNeyiL1cXnnS7KcX7P2');
```

**Klik:** `Go` atau `Execute`

**Tunggu:** Muncul pesan "Query successful" (hijau) ✅

---

### **LANGKAH 2: Rewrite admin/login.php** (sudah dilakukan)

File sudah diupdate dengan:
- ✅ Koneksi ke config/db.php
- ✅ PDO Prepared Statements
- ✅ password_verify() untuk validasi
- ✅ Session management
- ✅ Error handling yang jelas

---

### **LANGKAH 3: Update admin/dashboard.php** (sudah dilakukan)

File sudah diupdate dengan:
- ✅ Session check di awal
- ✅ Sidebar navigation
- ✅ Tombol "Tambah Berita Baru"
- ✅ Tabel daftar berita
- ✅ Tombol logout
- ✅ Tailwind CSS design

---

## 🧪 Testing Login

### **Step 1: Jalankan SQL di phpMyAdmin**
```
Copy kode SQL di atas
Paste di tab SQL
Klik Go
Lihat "Query successful" ✅
```

### **Step 2: Buka Halaman Login**
```
http://localhost/desa_cendana/admin/login.php
```

### **Step 3: Masukkan Kredensial Baru**
```
Username: admin
Password: password123
```

### **Step 4: Klik Tombol Login**
```
Harapan: Redirect ke dashboard.php ✅
Tidak masuk: Lihat pesan error yang spesifik
```

### **Step 5: Cek Dashboard**
```
Seharusnya ada:
- Username di pojok kanan atas
- Sidebar dengan menu
- Tombol "Tambah Berita Baru"
- Tabel daftar berita
- Tombol Logout
```

---

## 📝 Penjelasan Password Hash

### Apa itu Bcrypt?
```
Plain text:  password123
Hashed:      $2y$10$0VrcP7WkF1YzJVrPwFGdde5HPsJDUQh6S4RNeyiL1cXnnS7KcX7P2

$2y$    = Algoritma bcrypt
$10     = Cost factor (keamanan level)
$...    = Salt (pembeda password yang sama)
```

### Mengapa password_verify() Penting?
```
❌ SALAH: password == $2y$10$...
   Akan selalu FALSE karena format berbeda

✅ BENAR: password_verify('password123', '$2y$10$...')
   PHP akan decrypt dan bandingkan, hasil TRUE jika sama
```

---

## 🚀 Langkah-Langkah Detail

### **Step 1A: Buka phpMyAdmin**
```
1. Buka browser
2. Ketik: http://localhost/phpmyadmin
3. Login (default: root, password kosong)
```

### **Step 1B: Pilih Database**
```
1. Di sisi kiri, lihat list database
2. Klik: desa_cendana
```

### **Step 1C: Tab SQL**
```
1. Di atas table list, klik: SQL
2. Area kosong untuk input query akan muncul
```

### **Step 1D: Paste & Execute**
```
1. Copy kode SQL dari bagian "Copy & Paste kode ini"
2. Paste di text area
3. Klik: Go (atau Execute)
4. Tunggu hasilnya
```

### **Step 1E: Verifikasi**
```
1. Klik: users (tabel)
2. Lihat data: hanya ada 1 row (admin)
3. Cek password dimulai dengan: $2y$10$
```

---

## ✅ Checklist Verifikasi

- [ ] SQL berhasil dijalankan ("Query successful")
- [ ] Tabel users hanya punya 1 row (admin)
- [ ] Password format: $2y$10$... (bcrypt)
- [ ] Bisa akses login page
- [ ] Input username & password bisa diterima
- [ ] Redirect ke dashboard setelah login sukses
- [ ] Dashboard menampilkan data berita
- [ ] Tombol logout berfungsi
- [ ] Setelah logout, redirect ke login page

---

## 🔐 Keamanan Password

### Yang SALAH:
```sql
INSERT INTO users VALUES ('admin', 'password123');
-- Plain text, password_verify() akan selalu FALSE
```

### Yang BENAR:
```sql
INSERT INTO users VALUES ('admin', '$2y$10$0VrcP7WkF1YzJVrPwFGdde5HPsJDUQh6S4RNeyiL1cXnnS7KcX7P2');
-- Bcrypt hash, password_verify() akan compare dengan benar
```

---

## 🛠️ Troubleshooting

### ❌ "Query successful" tapi masih error login

**Solusi 1:** Refresh browser (Ctrl + F5)
```
Cache browser kadang terserang, hardrefresh bisa membantu
```

**Solusi 2:** Cek database langsung
```
1. Buka phpMyAdmin
2. Klik: users table
3. Lihat isi data
4. Pastikan ada row dengan username=admin dan password=$2y$10$...
```

**Solusi 3:** Cek config/db.php
```
Pastikan setting:
- $host = "localhost"
- $db_name = "desa_cendana"
- $username = "root"
- $password = "" (kosong)
```

---

### ❌ "Username atau password salah" padahal benar

**Penyebab:** Password hash tidak cocok dengan PHP code

**Solusi:** 
1. Jalankan SQL reset lagi dari bagian "Copy & Paste kode ini"
2. Pastikan copy seluruh kode (termasuk $2y$10$...)
3. Jangan edit password hash, gunakan yang disediakan
4. Refresh browser
5. Coba login lagi

---

### ❌ Database connection error

**Penyebab:** MySQL tidak running atau config salah

**Solusi:**
```
1. Buka Laragon
2. Klik tombol Start
3. Pastikan MySQL indicator hijau ✅
4. Cek config/db.php setting
5. Restart Laragon jika masih error
```

---

### ❌ Halaman putih atau error 500

**Penyebab:** File ada error PHP atau database crash

**Solusi:**
1. Cek error di browser console (F12 → Console)
2. Cek error log di: `error_log`
3. Restart MySQL di Laragon
4. Refresh halaman

---

## 📚 File-File yang Terlibat

### `admin/login.php`
```
- Menerima username & password
- Validasi dengan password_verify()
- Buat session jika berhasil
- Redirect ke dashboard
```

### `admin/dashboard.php`
```
- Check session admin_id
- Redirect ke login jika tidak ada session
- Tampilkan sidebar & konten
- Tombol logout
```

### `config/db.php`
```
- PDO connection ke MySQL
- Database config (host, user, password, db_name)
```

### `admin/logout.php`
```
- Destroy session
- Redirect ke login.php
```

---

## 🔄 Login Flow (Benar)

```
User masuk ke /admin/login.php
    ↓
Input username & password
    ↓
Klik tombol login
    ↓
POST ke /admin/login.php
    ↓
PHP validasi input (tidak kosong)
    ↓
PDO query: SELECT * FROM users WHERE username=?
    ↓
Password_verify(input_password, db_password_hash)
    ↓
TRUE:
  - Set $_SESSION['admin_id'] = user.id
  - Redirect ke /admin/dashboard.php
  
FALSE:
  - $error = "Username atau password salah!"
  - Tampilkan login form lagi
```

---

## 📊 Database Struktur

### Tabel `users`
```
Kolom    | Type         | Value
---------|--------------|---------------------------
id       | INT          | (auto increment)
username | VARCHAR(50)  | admin
password | VARCHAR(255) | $2y$10$0VrcP7WkF1YzJVrPwFGdde5...
```

---

## 🎯 Setelah Login Berhasil

Anda akan melihat:
1. ✅ Dashboard admin
2. ✅ Sidebar navigation
3. ✅ Tombol "Tambah Berita Baru" 
4. ✅ Tabel daftar berita
5. ✅ Tombol logout

---

## 📝 Credentials Baru

```
Username: admin
Password: password123
```

**PENTING:** 
- Ini password baru, bukan password lama
- Harus login dengan `password123` bukan `admin123`
- Setelah login, sebaiknya ubah password

---

## 🧪 Full Testing Sequence

```
1. Jalankan SQL reset di phpMyAdmin                    (2 min)
2. Buka http://localhost/desa_cendana/admin/login.php (1 min)
3. Masukkan: admin / password123                        (1 min)
4. Klik login                                           (1 min)
5. Lihat dashboard muncul                              (1 min)
6. Klik "Tambah Berita Baru"                           (1 min)
7. Isi form berita baru                                (2 min)
8. Lihat berita muncul di news.php                     (1 min)
9. Klik logout                                          (1 min)
10. Redirect ke login page                             (1 min)

Total: ~15 menit untuk full test ✅
```

---

## 🎉 Success Criteria

✅ Login dengan `admin` / `password123` berhasil
✅ Redirect ke `/admin/dashboard.php`
✅ Dashboard menampilkan statistik berita
✅ Bisa akses `/admin/add_news.php`
✅ Bisa logout dan redirect ke login

---

## 📞 Quick Reference

| Item | Value |
|------|-------|
| Login URL | `http://localhost/desa_cendana/admin/login.php` |
| Dashboard URL | `http://localhost/desa_cendana/admin/dashboard.php` |
| Username | `admin` |
| Password | `password123` |
| Database | `desa_cendana` |
| Table | `users` |
| Config | `config/db.php` |

---

## 💡 Tips

1. **Copy Exact:** Copy kode SQL dengan persis, jangan edit
2. **Check Format:** Pastikan password dimulai dengan `$2y$10$`
3. **Verify Data:** Cek langsung di phpMyAdmin user sudah ada
4. **Clear Cache:** Gunakan Ctrl+F5 bukan hanya refresh
5. **Cek MySQL:** Pastikan Laragon running sebelum test

---

**Update:** January 19, 2026
**Status:** Ready to Reset ✅

Mari jalankan langkah 1 (SQL reset) di phpMyAdmin dan login dengan kredensial baru!
