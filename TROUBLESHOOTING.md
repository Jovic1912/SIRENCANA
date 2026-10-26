# 🔧 Troubleshooting Guide - SIRENCANA

## ✅ **FIXES APPLIED!**

Saya telah memperbaiki beberapa masalah konfigurasi:

---

## 🔴 **Masalah Yang Diperbaiki**

### **1. App.php Configuration** ✅ FIXED
**Location:** `app/Config/App.php`

**Before:**
```php
public string $baseURL = 'http://localhost:8080/';
public string $indexPage = 'index.php';
public string $defaultLocale = 'en';
public string $appTimezone = 'UTC';
```

**After (FIXED):**
```php
public string $baseURL = 'http://localhost/SIRENCANA/';
public string $indexPage = '';  // Kosong untuk clean URLs
public string $defaultLocale = 'id';  // Indonesia
public string $appTimezone = 'Asia/Jakarta';
```

### **2. .htaccess Root** ✅ CREATED
**Location:** `.htaccess` (root folder)

**Created new file** untuk redirect ke public folder:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^$ public/ [L]
    RewriteRule (.*) public/$1 [L]
</IfModule>
```

### **3. Database Configuration** ✅ VERIFIED
**Files:**
- `.env` - Sudah benar ✅
- `app/Config/Database.php` - Akan baca dari .env ✅

**Database settings:**
```env
database.default.hostname = localhost
database.default.database = sirencana_db
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### **4. Routes** ✅ VERIFIED
**Location:** `app/Config/Routes.php`

Routes sudah benar:
```php
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attempt');
$routes->get('/', 'Dashboard::index');
// ... dan routes lainnya
```

---

## 🌐 **URL Structure**

### **Correct URLs:**
```
✅ http://localhost/SIRENCANA/
✅ http://localhost/SIRENCANA/login
✅ http://localhost/SIRENCANA/prodi
✅ http://localhost/SIRENCANA/users
```

### **Wrong URLs (Don't Use):**
```
❌ http://localhost:8080/
❌ http://localhost/SIRENCANA/index.php/login
❌ http://localhost/SIRENCANA/public/login
```

---

## 📋 **Testing Steps**

### **Step 1: Start Laragon**
1. Buka Laragon
2. Klik **"Start All"**
3. Pastikan Apache dan MySQL hijau (running)

### **Step 2: Check Services**
Pastikan services running:
- ✅ Apache (httpd.exe)
- ✅ MySQL (mysqld.exe)

### **Step 3: Create Database**
```sql
-- Via MySQL di Laragon atau phpMyAdmin
CREATE DATABASE IF NOT EXISTS sirencana_db 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_general_ci;
```

### **Step 4: Run Migrations**
```bash
cd d:\laragon\www\SIRENCANA
php spark migrate
```

**Expected output:**
```
Running: 2026-01-01-000001_CreateObeSchema
Running: 2026-01-02-000001_CreateUsers
Migrations complete.
```

### **Step 5: Seed User**
```bash
php spark db:seed UserSeeder
```

### **Step 6: Test in Browser**
```
URL: http://localhost/SIRENCANA/
```

**Expected:**
- Redirect ke login page
- Design sky blue gradient
- Form login tampil

**Login:**
```
Username: admin
Password: admin123
```

---

## 🔍 **Diagnostic Checklist**

### **1. Apache Check**
```bash
# Check if Apache is running
Get-Process | Where-Object {$_.ProcessName -like "*httpd*"}
```

**Expected:** Process httpd.exe running

### **2. MySQL Check**
```bash
# Check if MySQL is running
Get-Process | Where-Object {$_.ProcessName -like "*mysql*"}
```

**Expected:** Process mysqld.exe running

### **3. Port 80 Check**
```bash
# Check if port 80 is in use
netstat -ano | findstr ":80 "
```

**Expected:** Apache listening on port 80

### **4. File Permissions**
Pastikan folder writable:
- `writable/session`
- `writable/logs`
- `writable/cache`

### **5. PHP Version**
```bash
php -v
```

**Required:** PHP >= 8.1

### **6. .env Check**
File `.env` harus ada dan readable:
```bash
Test-Path .env
```

**Expected:** True

---

## 🐛 **Common Issues & Solutions**

### **Issue 1: "Page Not Found" 404**

**Possible Causes:**
- Apache mod_rewrite not enabled
- .htaccess not working
- Wrong baseURL

**Solutions:**
```apache
# 1. Check mod_rewrite enabled in httpd.conf
LoadModule rewrite_module modules/mod_rewrite.so

# 2. Check AllowOverride in httpd.conf
<Directory "${SRVROOT}/www">
    AllowOverride All
</Directory>

# 3. Restart Apache via Laragon
```

### **Issue 2: "Database connection failed"**

**Possible Causes:**
- MySQL not running
- Database not created
- Wrong credentials

**Solutions:**
```bash
# 1. Start MySQL via Laragon

# 2. Create database
mysql -u root -p
CREATE DATABASE sirencana_db;
exit;

# 3. Check .env credentials
database.default.username = root
database.default.password = 
```

### **Issue 3: "localhost/SIRENCANA shows directory listing"**

**Possible Causes:**
- .htaccess not created
- index.php not found

**Solutions:**
```bash
# 1. Check .htaccess exists in root
Test-Path .htaccess

# 2. Check public/index.php exists
Test-Path public\index.php

# 3. If missing, check TROUBLESHOOTING.md
```

### **Issue 4: "Blank white page"**

**Possible Causes:**
- PHP error
- Missing dependencies
- Wrong permissions

**Solutions:**
```bash
# 1. Check error logs
Get-Content writable\logs\log-*.log -Tail 50

# 2. Enable error display (development only)
# In .env:
CI_ENVIRONMENT = development

# 3. Check composer dependencies
composer install
```

### **Issue 5: "Session error"**

**Possible Causes:**
- writable/session folder missing
- No write permission

**Solutions:**
```bash
# 1. Create session folder
New-Item -ItemType Directory -Path writable\session -Force

# 2. Check .env session settings
session.driver = CodeIgniter\Session\Handlers\FileHandler
session.savePath = null
```

### **Issue 6: "CSRF token mismatch"**

**Possible Causes:**
- Session not working
- Cookie issues

**Solutions:**
```bash
# 1. Clear browser cookies
# 2. Check session working
# 3. Hard refresh: Ctrl+Shift+R
```

---

## 🧪 **Manual Testing**

### **Test 1: Homepage**
```
URL: http://localhost/SIRENCANA/
Expected: Redirect to /login
```

### **Test 2: Login Page**
```
URL: http://localhost/SIRENCANA/login
Expected: 
- Sky blue gradient background
- White card with login form
- Amber button
```

### **Test 3: Login Process**
```
Username: admin
Password: admin123
Expected:
- Redirect to dashboard
- No errors
```

### **Test 4: Dashboard**
```
URL: http://localhost/SIRENCANA/ (after login)
Expected:
- Sidebar dengan menu
- Stats cards
- Sky blue theme
```

### **Test 5: Routes**
```
Test these URLs (after login):
✅ /prodi
✅ /dosen
✅ /mahasiswa
✅ /mata-kuliah
✅ /kurikulum
✅ /rps
✅ /kelas
```

---

## 📊 **Configuration Summary**

### **Current Configuration:**

| Setting | Value | File |
|---------|-------|------|
| **BaseURL** | http://localhost/SIRENCANA/ | App.php |
| **IndexPage** | (empty) | App.php |
| **Environment** | development | .env |
| **Database** | sirencana_db | .env |
| **DB User** | root | .env |
| **DB Password** | (empty) | .env |
| **Timezone** | Asia/Jakarta | App.php |
| **Locale** | id | App.php |
| **Session Driver** | FileHandler | .env |

### **Files Modified:**
- ✅ `app/Config/App.php` - baseURL, indexPage, locale, timezone
- ✅ `.htaccess` (root) - Redirect to public
- ✅ `.env` - Already correct

### **Files Verified:**
- ✅ `app/Config/Routes.php` - All routes correct
- ✅ `app/Config/Database.php` - Will read from .env
- ✅ `public/.htaccess` - URL rewriting correct
- ✅ `public/index.php` - Entry point correct

---

## 🚀 **Quick Fix Commands**

If still not working, try these:

```bash
# 1. Clear cache
php spark cache:clear

# 2. Clear writable folders
Remove-Item writable\cache\* -Recurse -Force
Remove-Item writable\session\ci_session* -Force
Remove-Item writable\debugbar\* -Recurse -Force

# 3. Regenerate .env key
php spark key:generate --force

# 4. Test routes
php spark routes

# 5. Check config
php spark config:check
```

---

## 📞 **Still Having Issues?**

### **Check These:**

1. **Laragon Running?**
   - Apache hijau
   - MySQL hijau

2. **Database Created?**
   ```sql
   SHOW DATABASES LIKE 'sirencana_db';
   ```

3. **Migrations Run?**
   ```sql
   USE sirencana_db;
   SHOW TABLES;
   -- Should show 19 tables
   ```

4. **User Seeded?**
   ```sql
   SELECT * FROM users WHERE username='admin';
   -- Should return 1 row
   ```

5. **Apache mod_rewrite Enabled?**
   - Check Laragon → Apache → httpd.conf
   - Look for: `LoadModule rewrite_module`

6. **Port 80 Available?**
   - No other service using port 80
   - Skype, IIS, atau aplikasi lain bisa conflict

---

## ✅ **Verification Commands**

Run these to verify everything:

```bash
# Change to project directory
cd d:\laragon\www\SIRENCANA

# 1. Check PHP version
php -v

# 2. Check database connection
php spark db:show

# 3. Check routes
php spark routes | Select-String "login|dashboard|prodi"

# 4. Check environment
php spark env

# 5. Test URL (PowerShell)
Invoke-WebRequest -Uri "http://localhost/SIRENCANA/" -UseBasicParsing
```

---

## 🎉 **Success Indicators**

You know it's working when:
- ✅ http://localhost/SIRENCANA/ redirects to /login
- ✅ Login page shows sky blue theme
- ✅ Login with admin/admin123 works
- ✅ Dashboard displays with stats
- ✅ Sidebar menu appears
- ✅ No PHP errors in logs

---

## 📚 **Additional Resources**

- **CodeIgniter 4 Docs:** https://codeigniter.com/user_guide/
- **Laragon Docs:** https://laragon.org/docs/
- **Project Docs:**
  - `QUICK_START.md` - Setup guide
  - `BACKEND_SETUP.md` - Backend details
  - `DESIGN_IMPLEMENTATION.md` - Design system

---

**Configuration Updated! Try opening:**
```
http://localhost/SIRENCANA/
```

**Everything should work now! 🚀**
