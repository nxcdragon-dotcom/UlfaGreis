# ⚡ DESA CENDANA - QUICK REFERENCE

Panduan cepat untuk akses website dan admin panel.

---

## 🔗 URL Shortcuts

### Public Website
| Halaman | URL |
|---------|-----|
| **Homepage** | http://localhost/desa_cendana/ |
| **Berita** | http://localhost/desa_cendana/news.php |
| **Pejabat** | http://localhost/desa_cendana/officials.php |
| **Galeri** | http://localhost/desa_cendana/gallery.php |

### Admin Panel
| Halaman | URL |
|---------|-----|
| **Login** | http://localhost/desa_cendana/admin/login.php |
| **Dashboard** | http://localhost/desa_cendana/admin/dashboard.php |
| **Logout** | http://localhost/desa_cendana/admin/logout.php |

---

## 🔐 Login Credentials

```
Username: admin
Password: admin123
```

⚠️ **Change password after first login!**

---

## 💾 Database

### Connection
```php
Host:     localhost
Database: desa_cendana
User:     root
Password: (empty)
Port:     3306
```

### phpMyAdmin
```
http://localhost/phpmyadmin/
```

### Database Tables
- `users` - Admin accounts
- `news` - Articles
- `officials` - Staff profiles
- `gallery` - Photos

---

## 📁 Important Folders

| Folder | Purpose |
|--------|---------|
| `/admin/` | Admin pages (login, dashboard) |
| `/config/` | Database configuration |
| `/uploads/` | User uploads (news, officials, gallery) |
| `/assets/` | CSS, JS, images |

---

## 🛠️ Common Tasks

### 1️⃣ Add News
- Login to admin panel → Dashboard
- Click "Tambah Berita" (when CRUD page ready)
- Fill form → Upload image → Save

### 2️⃣ Add Official
- Login to admin panel → Dashboard
- Click "Tambah Pejabat" (when CRUD page ready)
- Fill form → Upload photo → Save

### 3️⃣ Add Gallery Photo
- Login to admin panel → Dashboard
- Click "Unggah Foto" (when CRUD page ready)
- Upload image → Add caption → Save

### 4️⃣ Change Admin Password
```sql
-- Generate hash:
<?php echo password_hash('new_password', PASSWORD_DEFAULT); ?>

-- Update database:
UPDATE users SET password = '$2y$10$...' WHERE username = 'admin';
```

### 5️⃣ View Database Data
```bash
# Open phpMyAdmin
http://localhost/phpmyadmin/

# Or use MySQL CLI
mysql -u root desa_cendana
SHOW TABLES;
SELECT * FROM news;
SELECT * FROM officials;
SELECT * FROM gallery;
```

---

## 📊 File Locations

### Root Files
```
/index.php              (Homepage)
/news.php               (News page)
/officials.php          (Officials page)
/gallery.php            (Gallery page)
/database.sql           (Database schema)
/README.md              (Full documentation)
/SETUP_GUIDE.md         (Setup instructions)
/CHECKLIST.md           (Progress tracking)
/IMPLEMENTATION_SUMMARY.md (Summary)
```

### Admin Files
```
/admin/login.php        (Login page)
/admin/dashboard.php    (Admin dashboard)
/admin/logout.php       (Logout handler)
```

### Config Files
```
/config/database.php    (Database connection)
```

---

## 🎨 Colors Used

| Color | Tailwind Class | Use |
|-------|---|---|
| Emerald | `bg-emerald-700` | Primary (navbar) |
| Green | `bg-green-400` | Accent (buttons) |
| Gray | `bg-gray-50/100` | Background |
| Beige | `text-yellow-100` | Secondary text |

---

## 📱 Responsive Breakpoints

Tested breakpoints:
- ✅ Mobile: 320px - 640px
- ✅ Tablet: 641px - 1024px
- ✅ Desktop: 1025px+

Hamburgermenu muncul di mobile, sidebar di desktop.

---

## 🔧 File Permissions

Ensure correct permissions:
```bash
# Folder permissions (Linux/Mac)
chmod 755 uploads/
chmod 755 config/

# File permissions
chmod 644 *.php
chmod 644 config/database.php
```

---

## 🚨 Troubleshooting Quick Fixes

### Can't connect to database
```bash
# 1. Check MySQL is running (Laragon start button)
# 2. Verify database exists:
mysql -u root
SHOW DATABASES;
USE desa_cendana;

# 3. Check config/database.php settings
```

### No data showing
```bash
# Check database has data:
mysql -u root desa_cendana
SELECT COUNT(*) FROM news;
SELECT COUNT(*) FROM officials;
SELECT COUNT(*) FROM gallery;
```

### Login not working
```bash
# 1. Clear browser cookies
# 2. Try incognito mode
# 3. Check user in database:
SELECT * FROM users WHERE username='admin';

# 4. Verify password hash:
<?php
$hash = '$2y$10$92IXUNpkm1ySl9HAJ9lT1OPST9/PgBkqquzi.Ss7KIUgO2t0jWMUm';
echo password_verify('admin123', $hash) ? 'Valid' : 'Invalid';
?>
```

### Upload folder error
```bash
# Create uploads folder
mkdir uploads
mkdir uploads/news
mkdir uploads/officials
mkdir uploads/gallery

# Linux/Mac: set permissions
chmod -R 777 uploads/
```

---

## 📞 Contact

**Desa Cendana**
- Email: info@desacendana.id
- Phone: +62 XXX XXXX XXXX
- Address: Desa Cendana, Jawa Barat

---

## 📚 Full Documentation

- **README.md** - Complete project documentation
- **SETUP_GUIDE.md** - Detailed setup instructions
- **CHECKLIST.md** - Implementation progress tracker
- **IMPLEMENTATION_SUMMARY.md** - Files & features summary

---

## ✨ Features Overview

### ✅ Implemented
- Responsive public website
- Admin login system
- Database integration (MySQL + PDO)
- Data display from database
- Session management
- Password hashing

### ⏳ Coming Soon
- CRUD for news
- CRUD for officials
- CRUD for gallery
- File upload
- Search functionality
- Email notifications

---

**Website Status: ✅ READY TO USE**

*Last Updated: January 19, 2026*
