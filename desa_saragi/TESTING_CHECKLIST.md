# 🧪 TESTING CHECKLIST - DESA SARAGI WEBSITE

## ✅ PRE-TESTING VERIFICATION

### Database Synchronization
- [x] Struktur kolom NEWS verified: Judul, kontak, gambar, tanggal
- [x] Struktur kolom OFFICIALS verified: nama, posisi, foto  
- [x] Struktur kolom GALLERY verified: title, gambar, tanggal
- [x] Semua INSERT/SELECT queries valid
- [x] Folder uploads/ siap menerima file upload

### PHP Code Updates
- [x] admin/add_news.php - Updated dengan kolom Judul, kontak, gambar
- [x] admin/add_officials.php - Updated dengan kolom nama, posisi, foto
- [x] admin/add_gallery.php - Updated dengan kolom title, gambar
- [x] admin/officials_manage.php - Updated query dan template HTML
- [x] admin/gallery_manage.php - Updated query dan template HTML
- [x] admin/news_manage.php - Verified (already correct)

---

## 🚀 ADMIN TESTING

### 1️⃣ Login & Authentication
**URL:** `localhost/desa_cendana/admin/login.php`
- [ ] Halaman login muncul normal
- [ ] Login dengan username: admin, password: password123
- [ ] Redirect ke dashboard.php setelah login berhasil
- [ ] Session variables tersimpan (admin_id, admin_name)

### 2️⃣ Dashboard
**URL:** `localhost/desa_cendana/admin/dashboard.php`
- [ ] Dashboard muncul tanpa error
- [ ] Sidebar navigation lengkap (6 menu items)
- [ ] Card statistics menampilkan jumlah berita/pejabat/galeri
- [ ] "Kelola Berita" link berfungsi
- [ ] "Kelola Pejabat" link berfungsi
- [ ] "Kelola Galeri" link berfungsi
- [ ] "Pengaturan" link berfungsi
- [ ] Logout button berfungsi

---

## 📰 NEWS MANAGEMENT TESTING

### 3️⃣ Kelola Berita (List)
**URL:** `localhost/desa_cendana/admin/news_manage.php`
- [ ] Halaman muncul tanpa "Unknown column" error
- [ ] Tabel menampilkan list berita (jika ada)
- [ ] Kolom: No., Judul, Tanggal, Gambar, Aksi
- [ ] Edit button muncul dan dapat diklik
- [ ] Delete button muncul dan dapat diklik

### 4️⃣ Tambah Berita (Create)
**URL:** `localhost/desa_cendana/admin/add_news.php`
- [ ] Form muncul normal (title, content, image)
- [ ] Input title dapat diisi
- [ ] Input content dapat diisi
- [ ] Drag-drop image area muncul
- [ ] Upload button berfungsi
- [ ] Setelah submit, berita tersimpan di database
- [ ] Notifikasi "Berita berhasil ditambahkan!" muncul
- [ ] Auto-redirect ke news_manage.php setelah 2 detik
- [ ] Berita baru tampil di daftar berita

### 5️⃣ Edit Berita (Update)
**Status:** File belum ada (akan dibuat di tahap selanjutnya)
- [ ] File admin/edit_news.php perlu dibuat

### 6️⃣ Delete Berita
**URL:** `localhost/desa_cendana/admin/news_manage.php?action=delete&id=X`
- [ ] Notifikasi "Berita berhasil dihapus!" muncul
- [ ] Berita hilang dari daftar
- [ ] File gambar dihapus dari folder uploads/

---

## 👥 OFFICIALS MANAGEMENT TESTING

### 7️⃣ Kelola Pejabat (List)
**URL:** `localhost/desa_cendana/admin/officials_manage.php`
- [ ] Halaman muncul tanpa "Unknown column" error
- [ ] Tabel menampilkan list pejabat (jika ada)
- [ ] Kolom: No., Nama, Posisi, Foto, Aksi
- [ ] Edit button muncul dan dapat diklik
- [ ] Delete button muncul dan dapat diklik

### 8️⃣ Tambah Pejabat (Create)
**URL:** `localhost/desa_cendana/admin/add_officials.php`
- [ ] Form muncul normal (name, position, photo)
- [ ] Input name dapat diisi
- [ ] Input position dapat diisi
- [ ] Photo upload area muncul
- [ ] Upload button berfungsi
- [ ] Setelah submit, pejabat tersimpan di database
- [ ] Notifikasi "Pejabat berhasil ditambahkan!" muncul
- [ ] Auto-redirect ke officials_manage.php setelah 2 detik
- [ ] Pejabat baru tampil di daftar pejabat
- [ ] Foto ditampilkan thumbnail

### 9️⃣ Edit Pejabat (Update)
**Status:** File belum ada (akan dibuat di tahap selanjutnya)
- [ ] File admin/edit_officials.php perlu dibuat

### 🔟 Delete Pejabat
**URL:** `localhost/desa_cendana/admin/officials_manage.php?action=delete&id=X`
- [ ] Notifikasi "Pejabat berhasil dihapus!" muncul
- [ ] Pejabat hilang dari daftar

---

## 🖼️ GALLERY MANAGEMENT TESTING

### 1️⃣1️⃣ Kelola Galeri (List)
**URL:** `localhost/desa_cendana/admin/gallery_manage.php`
- [ ] Halaman muncul tanpa "Unknown column" error
- [ ] Grid foto menampilkan semua foto galeri (3 kolom responsif)
- [ ] Setiap card menampilkan: thumbnail, title, tanggal
- [ ] Edit button muncul dan dapat diklik
- [ ] Delete button muncul dan dapat diklik

### 1️⃣2️⃣ Tambah Foto Galeri (Create)
**URL:** `localhost/desa_cendana/admin/add_gallery.php`
- [ ] Form muncul normal (title, image)
- [ ] Input title dapat diisi
- [ ] Drag-drop image area muncul
- [ ] Upload button berfungsi
- [ ] Setelah submit, foto tersimpan di database
- [ ] Notifikasi "Foto berhasil ditambahkan ke galeri!" muncul
- [ ] Auto-redirect ke gallery_manage.php setelah 2 detik
- [ ] Foto baru tampil di galeri

### 1️⃣3️⃣ Edit Foto Galeri (Update)
**Status:** File belum ada (akan dibuat di tahap selanjutnya)
- [ ] File admin/edit_gallery.php perlu dibuat

### 1️⃣4️⃣ Delete Foto Galeri
**URL:** `localhost/desa_cendana/admin/gallery_manage.php?action=delete&id=X`
- [ ] Notifikasi "Foto galeri berhasil dihapus!" muncul
- [ ] Foto hilang dari galeri

---

## ⚙️ SETTINGS/USERS MANAGEMENT

### 1️⃣5️⃣ Pengaturan (Users)
**URL:** `localhost/desa_cendana/admin/users_manage.php`
- [ ] Halaman muncul normal
- [ ] Tabel menampilkan list admin users
- [ ] Kolom: No., Username, Created Date, Aksi
- [ ] Delete button muncul (kecuali user sendiri)
- [ ] Tidak bisa delete user sendiri

### 1️⃣6️⃣ Register Admin (Create)
**URL:** `localhost/desa_cendana/admin/register.php`
- [ ] Form daftar admin muncul normal
- [ ] Input username dapat diisi
- [ ] Input password dapat diisi
- [ ] Validasi: Username tidak boleh kosong
- [ ] Validasi: Password tidak boleh kosong
- [ ] Submit berhasil membuat admin baru
- [ ] Password di-hash dengan bcrypt
- [ ] Notifikasi "Admin berhasil terdaftar!" muncul

### 1️⃣7️⃣ Logout
**URL:** `localhost/desa_cendana/admin/logout.php`
- [ ] Logout button berfungsi
- [ ] Session dihapus
- [ ] Redirect ke login.php
- [ ] Tidak bisa akses dashboard tanpa login

---

## 🌐 PUBLIC WEBSITE TESTING

### 1️⃣8️⃣ Homepage
**URL:** `localhost/desa_cendana/index.php`
- [ ] Halaman muncul normal
- [ ] Hero section muncul dengan gambar
- [ ] Section berita preview muncul (6 berita terbaru)
- [ ] Section pejabat muncul (grid)
- [ ] Footer muncul

### 1️⃣9️⃣ Berita (News List)
**URL:** `localhost/desa_cendana/news.php`
- [ ] Halaman muncul normal
- [ ] Daftar berita tampil
- [ ] Pagination muncul (6 item per halaman)
- [ ] Click berita menuju news_detail.php

### 2️⃣0️⃣ Detail Berita
**URL:** `localhost/desa_cendana/news_detail.php?id=X`
- [ ] Halaman detail muncul
- [ ] Judul, isi, gambar tampil
- [ ] Tanggal tampil dengan format yang benar

### 2️⃣1️⃣ Pejabat (Officials)
**URL:** `localhost/desa_cendana/officials.php`
- [ ] Halaman muncul normal
- [ ] Daftar pejabat tampil dalam grid
- [ ] Nama, posisi, foto tampil

### 2️⃣2️⃣ Galeri (Gallery)
**URL:** `localhost/desa_cendana/gallery.php`
- [ ] Halaman muncul normal
- [ ] Grid foto tampil (12 per halaman)
- [ ] Pagination muncul
- [ ] Foto dapat diklik (jika ada lightbox)

---

## 📝 FILE UPLOAD VERIFICATION

### 2️⃣3️⃣ Uploads Folder
- [ ] Folder `C:\laragon\www\desa_cendana\uploads\` ada dan writable
- [ ] Setelah upload berita, file muncul di folder
- [ ] Setelah upload pejabat, file muncul di folder
- [ ] Setelah upload galeri, file muncul di folder
- [ ] Filename unik (timestamp_uniqid.ext)
- [ ] Delete image juga menghapus file fisik

---

## ⚠️ ERROR HANDLING

### 2️⃣4️⃣ Error Messages
- [ ] "Unknown column" error TIDAK muncul di admin pages
- [ ] "Unknown column" error TIDAK muncul saat add data
- [ ] Validasi form berfungsi (empty field)
- [ ] Validasi file upload berfungsi (format, size)
- [ ] PDOException ditangani dengan baik (user-friendly message)

---

## 🔒 SECURITY VERIFICATION

- [ ] Password di-hash dengan bcrypt (password_hash)
- [ ] Login verify password dengan password_verify
- [ ] Session-based authentication implemented
- [ ] SQL Injection prevention (prepared statements)
- [ ] XSS prevention (htmlspecialchars)
- [ ] CSRF protection (session checks)
- [ ] File upload validation (MIME type, size)

---

## 📱 RESPONSIVE DESIGN

- [ ] Desktop view (1920px+) - normal
- [ ] Tablet view (768px-1024px) - sidebar tersembunyi
- [ ] Mobile view (320px-767px) - responsive layout
- [ ] Sidebar hamburger menu berfungsi (jika ada)
- [ ] Tables responsive di mobile

---

## 📊 FINAL SIGN-OFF

**Date:** 19 January 2026
**Tester:** [Your Name]
**Status:** ⏳ Ready to Test

**Total Test Cases:** 24
**Passed:** [ ]
**Failed:** [ ]
**Skipped:** [ ]

**Notes:**
```
[Ruang untuk catatan testing hasil]
```

---

**Jika semua test ✅ PASSED, website Desa Saragi siap untuk production deployment!**
