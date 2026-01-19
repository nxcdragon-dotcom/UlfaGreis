# 🎯 DESA CENDANA - LOGIN SYSTEM VERIFICATION GUIDE

**Quick visual guide to verify everything is working**

---

## 🚀 STEP 1: START LARAGON (1 minute)

```
Open Laragon Application
    ↓
Click "Start" button
    ↓
Wait for Apache and MySQL to turn GREEN ✓
    ↓
PROCEED TO STEP 2
```

**What to see:**
```
┌─────────────────────────┐
│   LARAGON              │
├─────────────────────────┤
│ ✓ Apache: Running      │  ← Should be GREEN
│ ✓ MySQL: Running       │  ← Should be GREEN
│                         │
│    [Start]  [Stop]     │
└─────────────────────────┘
```

---

## 🧪 STEP 2: TEST DATABASE (2 minutes)

**Open this URL:**
```
http://localhost/desa_cendana/test_database.php
```

**You should see:**

```
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
🔧 Database Connection Test
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

✓ PHP Version: 7.4.X or higher
✓ PDO Extension: Installed
✓ MySQL PDO Driver: Available
✓ Database Connection: Connected to MySQL
✓ Database Exists: desa_cendana
✓ Tables Exist: users, news, officials, gallery
✓ Admin User: Found
  - ID: 1
  - Username: admin
  - Email: admin@desacendana.local
  ✓ Password hash verified for admin123
✓ Sample Data: 
  - Berita: 3 items
  - Pejabat: 3 items
  - Galeri: 3 items

📋 Summary
✓ All checks passed!

Next Steps:
1. Delete this file (test_database.php)
2. Visit: Admin Login
3. Login with: admin / admin123
4. Check dashboard for statistics
```

**If you see ✓ for all items → PROCEED TO STEP 3**

**If you see ✗ for any item → READ THE ERROR AND FIX IT**

---

## 🔐 STEP 3: TEST LOGIN (2 minutes)

**Open this URL:**
```
http://localhost/desa_cendana/admin/login.php
```

**You should see:**

```
┌────────────────────────────────────────┐
│         Desa Cendana                   │
│          Panel Admin                   │
├────────────────────────────────────────┤
│                                        │
│  📧 Username                           │
│  ┌────────────────────────────────┐   │
│  │ admin                          │   │  ← Type: admin
│  └────────────────────────────────┘   │
│                                        │
│  🔐 Password                           │
│  ┌────────────────────────────────┐   │
│  │ ••••••••••                     │   │  ← Type: admin123
│  └────────────────────────────────┘   │
│                                        │
│  ☐ Ingat saya                         │  ← Optional: Check
│                                        │
│  ┌────────────────────────────────┐   │
│  │    🔓 Masuk                    │   │  ← Click button
│  └────────────────────────────────┘   │
│                                        │
│  Kembali ke Beranda                   │
└────────────────────────────────────────┘
```

**What to enter:**
```
Username: admin
Password: admin123
Remember Me: (optional - check if you want)
```

**What to do:**
1. Type "admin" in Username field
2. Type "admin123" in Password field
3. Click "🔓 Masuk" button

**What happens next:**
- Page will process your login
- If successful: redirects to dashboard.php
- If failed: shows red error message

---

## ✅ STEP 4: VERIFY DASHBOARD (1 minute)

**After clicking "Masuk", you should be redirected to:**
```
http://localhost/desa_cendana/admin/dashboard.php
```

**You should see:**

```
┌──────────────────────────────────────────────────────────┐
│ 🌿 Desa Cendana Admin                          Logout    │
│                   👤 admin                               │
├──────────────────────────────────────────────────────────┤
│                                                          │
│ Sidebar (left):                                         │
│ ┌──────────────────────┐                               │
│ │ MENU                 │                               │
│ │ ✓ Dashboard  [highlighted]                          │
│ │ Kelola Berita                                        │
│ │ Kelola Pejabat                                       │
│ │ Kelola Galeri                                        │
│ │ Pengaturan                                           │
│ │ Logout                                               │
│ └──────────────────────┘                               │
│                                                          │
│ Main Content (right):                                  │
│ ┌──────────────────────────────────────────────────┐  │
│ │ Selamat Datang, admin! 👋                        │  │
│ │ Kelola konten Desa Cendana dari sini             │  │
│ │                                                   │  │
│ │ 📰 BERITA      👥 PEJABAT      🖼️ GALERI         │  │
│ │ [3]            [3]             [3]              │  │
│ │                                                   │  │
│ │ ⚡ Tindakan Cepat                                 │  │
│ │ [Tambah Berita] [Tambah Pejabat] [Unggah Foto]  │  │
│ └──────────────────────────────────────────────────┘  │
│                                                          │
└──────────────────────────────────────────────────────────┘
```

**Verify these elements:**
- [ ] Username "admin" shown in top right
- [ ] Statistics show numbers: Berita=3, Pejabat=3, Galeri=3
- [ ] Sidebar menu visible on left
- [ ] Quick action buttons visible
- [ ] Logout button available

✅ **If all elements visible → LOGIN SYSTEM WORKS!**

---

## 📋 COMPLETE VERIFICATION CHECKLIST

```
STEP 1: LARAGON
  [ ] Apache is GREEN (running)
  [ ] MySQL is GREEN (running)

STEP 2: DATABASE TEST
  [ ] Visit test_database.php
  [ ] All items show ✓
  [ ] No red ✗ marks
  [ ] Admin user verified
  [ ] Password hash verified

STEP 3: LOGIN TEST
  [ ] Visit admin/login.php
  [ ] Form displays correctly
  [ ] Can type username
  [ ] Can type password
  [ ] Can click Masuk button

STEP 4: DASHBOARD TEST
  [ ] Redirected to dashboard.php
  [ ] Shows "Selamat Datang, admin!"
  [ ] Statistics show 3, 3, 3
  [ ] Sidebar menu visible
  [ ] Logout button visible

FINAL:
  [ ] Delete test_database.php (security)
  [ ] Test logout button
  [ ] Verify back at login.php

ALL CHECKED = ✅ SYSTEM WORKING!
```

---

## ⚠️ IF SOMETHING GOES WRONG

### Problem: "Database Connection Error"

**Solution:**
1. Make sure MySQL is running (Laragon start)
2. Check test_database.php for details
3. See DATABASE_SETUP.md for full troubleshooting

### Problem: "Username atau password salah"

**Solutions:**
1. Double-check username: `admin` (lowercase)
2. Double-check password: `admin123`
3. Run test_database.php to verify password hash
4. Make sure database was imported

### Problem: Can't see test_database.php

**Solution:**
1. Check file exists: `c:\laragon\www\desa_cendana\test_database.php`
2. Check URL: `http://localhost/desa_cendana/test_database.php`
3. Make sure Laragon is running
4. Try in different browser

### Problem: Dashboard shows no statistics

**Solution:**
1. Database imported correctly
2. Run test_database.php to check sample data
3. Check sample data shows: Berita=3, Pejabat=3, Galeri=3
4. Refresh the dashboard page

---

## 🔄 TESTING WORKFLOW

```
1. START LARAGON
   └─→ Verify Apache & MySQL green

2. TEST DATABASE
   └─→ Visit test_database.php
       └─→ Check all ✓ marks
           └─→ No errors?

3. TEST LOGIN
   └─→ Visit /admin/login.php
       └─→ Enter: admin / admin123
           └─→ Click Masuk button

4. VERIFY DASHBOARD
   └─→ Check page loaded
       └─→ Check elements visible
           └─→ Check statistics

5. TEST LOGOUT
   └─→ Click logout button
       └─→ Back at login.php?

✅ ALL PASSED = SYSTEM READY!
```

---

## 🧹 CLEANUP

After verifying everything works:

1. **Delete test file** (for security)
   ```bash
   Delete: c:\laragon\www\desa_cendana\test_database.php
   ```

2. **Change admin password** (if using in production)
   - See: LOGIN_FIX_SUMMARY.md → How to change password

3. **Backup database**
   - Export from phpMyAdmin
   - Save to safe location

---

## 📱 QUICK REFERENCE URLS

```
Laragon:
  http://localhost/

Desa Cendana Homepage:
  http://localhost/desa_cendana/

Admin Login:
  http://localhost/desa_cendana/admin/login.php

Admin Dashboard:
  http://localhost/desa_cendana/admin/dashboard.php

Database Test:
  http://localhost/desa_cendana/test_database.php

phpMyAdmin:
  http://localhost/phpmyadmin/
```

---

## 🎯 SUCCESS INDICATORS

✅ **You know it's working when:**
- test_database.php shows all ✓
- Login page displays correctly
- Can login with admin/admin123
- Dashboard loads after login
- Statistics show numbers (3, 3, 3)
- Logout button works
- Returns to login.php after logout

---

## 📞 NEED HELP?

**See these files:**
1. [LOGIN_FIX_SUMMARY.md](./LOGIN_FIX_SUMMARY.md) - Fixes applied
2. [DATABASE_SETUP.md](./DATABASE_SETUP.md) - Setup verification
3. [README.md](./README.md) - Complete documentation

**Check these:**
1. Is Laragon running? (Apache & MySQL green)
2. Is database imported? (test_database.php)
3. Is table created? (phpMyAdmin)
4. Is admin user there? (test_database.php)
5. Is password correct? (test_database.php shows ✓)

---

**Status: ✅ READY TO TEST**

Follow this guide step-by-step and your login system will work! 🚀

*Created: January 19, 2026 | Desa Cendana Website*
