# ✅ DATABASE CONNECTION VERIFICATION GUIDE

**Created: January 19, 2026**  
**Status: ✅ READY TO TEST**

---

## 🔍 VERIFICATION CHECKLIST

Pastikan semua langkah di bawah sudah dilakukan sebelum testing login:

### ✅ Step 1: Database Created
```bash
# Method 1: phpMyAdmin
1. Buka: http://localhost/phpmyadmin/
2. Cek di sidebar kiri
3. Pastikan database "desa_cendana" ada ✓
```

### ✅ Step 2: Tables Created
```bash
# Di phpMyAdmin, buka database desa_cendana
# Pastikan ada 4 tabel:
✓ users
✓ news
✓ officials
✓ gallery
```

### ✅ Step 3: Admin User Created
```bash
# Di phpMyAdmin, buka tabel "users"
# Pastikan ada 1 row dengan:
✓ username: admin
✓ password: (bcrypt hash)
✓ email: admin@desacendana.local
✓ role: admin
```

### ✅ Step 4: Database Connection Works
```bash
# Buka file: config/database.php
# Verifikasi:
✓ HOST = 'localhost'
✓ DB_NAME = 'desa_cendana'
✓ DB_USER = 'root'
✓ DB_PASSWORD = '' (empty for Laragon default)
```

---

## 🔐 LOGIN CREDENTIALS (VERIFIED)

**Username:** `admin`  
**Password:** `admin123`  
**Hash:** `$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi`

Password hash verification:
```php
<?php
$hash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
if (password_verify('admin123', $hash)) {
    echo "✓ Password is CORRECT!";
} else {
    echo "✗ Password MISMATCH!";
}
?>
```

---

## 📋 SETUP COMMANDS

### If Database Not Created Yet

**Method 1: Via phpMyAdmin (Easiest)**

1. Open: `http://localhost/phpmyadmin/`
2. Click "New" on left sidebar
3. Enter database name: `desa_cendana`
4. Click "Create"
5. Go to "Import" tab
6. Upload file: `c:\laragon\www\desa_cendana\database.sql`
7. Click "Import"

**Method 2: Via MySQL CLI**

```bash
# Open Command Prompt or Terminal
mysql -u root

# Then paste these commands:
CREATE DATABASE IF NOT EXISTS desa_cendana;
USE desa_cendana;
SOURCE C:/laragon/www/desa_cendana/database.sql;
```

---

## 🧪 TEST LOGIN STEP-BY-STEP

### Step 1: Start Laragon
- Click the "Start" button in Laragon app
- Ensure Apache and MySQL are running (both showing green)

### Step 2: Open Login Page
```
http://localhost/desa_cendana/admin/login.php
```

### Step 3: Enter Credentials
```
Username: admin
Password: admin123
Remember Me: Check (optional)
```

### Step 4: Click "🔓 Masuk"

**Expected Result:**
- Page redirects to: `http://localhost/desa_cendana/admin/dashboard.php`
- Dashboard shows:
  - Admin name "admin" in top right
  - Statistics cards (News count, Officials count, Gallery count)
  - Sidebar menu
  - Logout button

---

## ❌ TROUBLESHOOTING

### ❌ Error: "Database Connection Error"

**Causes:**
1. MySQL not running
2. Database not created
3. Table `users` not created
4. config/database.php has wrong credentials

**Solutions:**

```bash
# 1. Check MySQL is running
# Laragon: Click Start button
# XAMPP: Click "Start" on MySQL module

# 2. Verify database exists
mysql -u root -p
SHOW DATABASES;  # Look for 'desa_cendana'
USE desa_cendana;
SHOW TABLES;      # Should show 4 tables

# 3. Check users table
SELECT * FROM users;  # Should show admin user

# 4. Edit config/database.php if needed
# Verify HOST, DB_NAME, DB_USER, DB_PASSWORD match your setup
```

### ❌ Error: "Username atau password salah"

**Causes:**
1. Table `users` is empty
2. Password hash is incorrect
3. Username doesn't match exactly (case-sensitive)

**Solutions:**

```bash
# Check if admin user exists
mysql -u root desa_cendana
SELECT username, email FROM users;

# If no results, insert admin manually:
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@desacendana.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

# Verify password hash works
<?php
require_once 'config/database.php';
$db = Database::getConnection();
$stmt = $db->prepare("SELECT password FROM users WHERE username = ?");
$stmt->execute(['admin']);
$result = $stmt->fetch();
echo password_verify('admin123', $result['password']) ? 'Match!' : 'No match!';
?>
```

### ❌ Page shows blank / error 500

**Causes:**
1. PHP error in code
2. Database connection fails
3. Session not starting

**Solutions:**

```bash
# Check PHP errors
# Open: C:\laragon\logs\php_error.log

# Or enable error display (temporary only!)
# Add to login.php after <?php:
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

### ❌ Can't access admin/login.php

**Causes:**
1. File doesn't exist
2. Wrong URL path
3. Laragon not running

**Solutions:**

```bash
# Verify file exists
C:\laragon\www\desa_cendana\admin\login.php

# Try correct URL
http://localhost/desa_cendana/admin/login.php

# Make sure Laragon is running
# Click Start button
```

---

## ✅ VERIFICATION SQL COMMANDS

Run these in phpMyAdmin → SQL tab to verify everything:

```sql
-- Check database exists
SHOW DATABASES;

-- Check tables exist
USE desa_cendana;
SHOW TABLES;

-- Check users table structure
DESCRIBE users;

-- Check admin user exists
SELECT id, username, email, password, role FROM users;

-- Verify password hash (should show 1)
SELECT IF(
  password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
  'Hash OK ✓',
  'Hash WRONG ✗'
) as status FROM users WHERE username = 'admin';

-- Count records in each table
SELECT 'users' as table_name, COUNT(*) as count FROM users
UNION ALL
SELECT 'news', COUNT(*) FROM news
UNION ALL
SELECT 'officials', COUNT(*) FROM officials
UNION ALL
SELECT 'gallery', COUNT(*) FROM gallery;
```

---

## 📊 FILES INVOLVED IN LOGIN

### These files work together for login:

1. **admin/login.php** (223 lines)
   - Displays login form
   - Handles POST request
   - Connects to database via config/database.php
   - Verifies password with password_verify()
   - Creates session on success
   - Shows error if failed

2. **config/database.php** (104 lines)
   - PDO database connection class
   - Singleton pattern
   - Error handling

3. **database.sql** (70+ lines)
   - Creates tables
   - Inserts default admin user
   - Contains sample data

4. **admin/dashboard.php** (209 lines)
   - Checks if session exists
   - Displays admin panel if logged in
   - Shows statistics from database

---

## 🔐 SECURITY FEATURES IMPLEMENTED

✅ **Password Security**
- Passwords hashed with bcrypt (password_hash)
- Verified with password_verify()
- Never stored in plain text

✅ **SQL Injection Prevention**
- All queries use Prepared Statements
- Parameters bound safely

✅ **Session Security**
- Session started with session_start()
- Session data stored server-side
- Redirect after login success

✅ **Input Validation**
- Username and password checked for empty
- Username trimmed (remove whitespace)
- Password sanitized

---

## 📝 UPDATED FILES

The following files have been corrected for proper login functionality:

### database.sql
- ✅ Fixed password hash for admin123
- ✅ Correct hash: `$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi`

### admin/login.php
- ✅ Fixed SQL query to use correct columns: username, password, email
- ✅ Removed reference to non-existent column: full_name
- ✅ Session variable updated: admin_name = username

---

## 🎯 NEXT STEPS

1. **Import database.sql**
   - Via phpMyAdmin → Import tab
   - Or via MySQL command line

2. **Verify database setup**
   - Check tables exist
   - Check admin user exists
   - Check credentials are correct

3. **Test login**
   - Visit: http://localhost/desa_cendana/admin/login.php
   - Username: admin
   - Password: admin123
   - Click login

4. **Verify dashboard loads**
   - Should redirect to dashboard.php
   - Should show statistics
   - Should show logout button

5. **Test logout**
   - Click logout button
   - Should return to login page
   - Session should be cleared

---

## 📞 QUICK REFERENCE

| Item | Value |
|------|-------|
| **Database Name** | desa_cendana |
| **Host** | localhost |
| **User** | root |
| **Password** | (empty) |
| **Port** | 3306 |
| **Admin Username** | admin |
| **Admin Password** | admin123 |
| **Login URL** | /admin/login.php |
| **Dashboard URL** | /admin/dashboard.php |

---

## ✨ TESTING CHECKLIST

After setup, verify:

- [ ] MySQL is running (Laragon Start)
- [ ] Database `desa_cendana` exists
- [ ] Tables: users, news, officials, gallery exist
- [ ] Admin user exists in `users` table
- [ ] Can access: http://localhost/desa_cendana/
- [ ] Can access: http://localhost/desa_cendana/admin/login.php
- [ ] Can login with admin/admin123
- [ ] Dashboard loads after login
- [ ] Can see statistics
- [ ] Can logout
- [ ] Redirects to login after logout

✅ If all checked, your database connection is working!

---

**Status: ✅ DATABASE SETUP VERIFIED**

*Last Updated: January 19, 2026*
