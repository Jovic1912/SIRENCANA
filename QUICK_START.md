# 🚀 Quick Start Guide - SIRENCANA

## ✅ Error Fixed!

Error `.env` sudah diperbaiki dan encryption key sudah di-generate.

---

## 📋 Setup Steps (5 Menit)

### **Step 1: Buat Database**

**Via Laragon Menu:**
1. Klik kanan icon Laragon di system tray
2. **MySQL** → **Open**
3. Di terminal MySQL, ketik:
   ```sql
   CREATE DATABASE sirencana_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   exit;
   ```

**Atau via phpMyAdmin:**
1. Buka: http://localhost/phpmyadmin
2. Klik tab **"Databases"**
3. Nama database: `sirencana_db`
4. Collation: `utf8mb4_general_ci`
5. Klik **"Create"**

---

### **Step 2: Run Migrations**

Buka terminal/PowerShell di folder project:

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

Ini akan membuat **19 tabel**:
- ✅ prodi, cpl, dosen, mahasiswa
- ✅ mata_kuliah, cpmk, cpmk_cpl
- ✅ rps, rps_pertemuan, rps_status_log
- ✅ jenis_penilaian, matriks_penilaian
- ✅ kelas, kelas_dosen, kontrak_kuliah
- ✅ peserta_kelas, presensi, nilai
- ✅ portofolio, users

---

### **Step 3: Seed Admin User**

```bash
php spark db:seed UserSeeder
```

**Expected output:**
```
Seeding: App\Database\Seeds\UserSeeder
Seeded: App\Database\Seeds\UserSeeder
```

Ini akan membuat user admin:
- **Username:** admin
- **Password:** admin123
- **Role:** Administrator

---

### **Step 4: Test Login**

1. **Buka browser:**
   ```
   http://localhost/SIRENCANA/login
   ```

2. **Login dengan:**
   ```
   Username: admin
   Password: admin123
   ```

3. **Expected Result:**
   - ✅ Login berhasil
   - ✅ Redirect ke Dashboard
   - ✅ Sidebar muncul dengan menu
   - ✅ Background sky blue gradient
   - ✅ Button amber

---

## 🎨 Fitur Design Baru

### **Login Page**
- Background: Sky blue gradasi ke putih
- Card: White dengan 28px border radius
- Button: **Amber** (#f59e0b) - menarik!
- Font: Inter

### **Dashboard**
- Sidebar: Sky blue gradient
- Stats Cards: Sky gradient dengan 28px radius
- Active menu: Amber background
- Tables: Sky blue header
- Progress bars: Sky gradient

### **Components**
- **Primary Button:** Amber dengan 28px radius
- **Cards:** White dengan 28px radius, no shadow
- **Badges:** Pill shaped (9999px radius)
- **Tables:** Sky blue header, rounded corners

---

## 📚 Menu Yang Tersedia

### **Dashboard** 
- Ringkasan stats (MK, RPS, Kelas, Mahasiswa)
- Dokumen menunggu tindak lanjut
- Distribusi status RPS

### **Data Induk** (Admin/Kaprodi)
- Program Studi
- Dosen
- Mahasiswa
- Mata Kuliah

### **Perancangan Pembelajaran**
- Kurikulum & CPMK
- RPS & Persetujuan
- Kelas & Kontrak

### **Pelaksanaan & Pelaporan**
- Presensi & Nilai
- Capaian CPMK
- Portofolio MK

### **Administrasi** (Admin)
- Pengguna (User Management)

---

## 🔧 Troubleshooting

### **Error: Database connection failed**
```
Solution:
1. Cek Laragon MySQL sudah running (hijau)
2. Cek database "sirencana_db" sudah dibuat
3. Cek .env file: username=root, password=(kosong)
```

### **Error: Table doesn't exist**
```
Solution:
php spark migrate
```

### **Error: Cannot login**
```
Solution:
php spark db:seed UserSeeder
```

### **Error: Session error**
```
Solution:
Folder writable/session sudah ada dan writeable
```

### **Page masih pakai design lama**
```
Solution:
1. Compile CSS: npx tailwindcss -i ./public/assets/css/input.css -o ./public/assets/css/output.css --minify
2. Hard refresh browser: Ctrl + Shift + R
```

---

## 🎯 Testing Checklist

Setelah login, test fitur-fitur ini:

### **1. Dashboard**
- [ ] Stats cards tampil
- [ ] Sky gradient applied
- [ ] Sidebar menu tampil
- [ ] Active menu dengan amber background

### **2. Data Induk**
- [ ] Buka: Program Studi
- [ ] Add new prodi
- [ ] Data tersimpan

### **3. Mata Kuliah**
- [ ] Buka: Mata Kuliah
- [ ] Add new mata kuliah
- [ ] Form dengan styling baru

### **4. Kurikulum**
- [ ] Buka: Kurikulum & CPMK
- [ ] Add CPL (Capaian Pembelajaran Lulusan)
- [ ] Add CPMK (Capaian Pembelajaran MK)

### **5. Design System**
- [ ] Background: Sky blue gradasi
- [ ] Buttons: Amber color
- [ ] Cards: 28px radius
- [ ] Tables: Sky blue header
- [ ] No heavy shadows

---

## 📖 User Roles

| Role | Username Example | Password | Access |
|------|------------------|----------|--------|
| **Admin** | admin | admin123 | Full access |
| **Kaprodi** | kaprodi | (set manually) | Master data, RPS approval |
| **Dosen** | dosen | (set manually) | Create RPS, input nilai |
| **GKM** | gkm | (set manually) | Review RPS |
| **GPM** | gpm | (set manually) | Archive RPS |

**Untuk menambah user lain:**
1. Login sebagai admin
2. Menu: **Administrasi** → **Pengguna**
3. Klik form **Tambah Pengguna**

---

## 🎨 Design Reference

Design mengikuti **DESIGN_peerk.md** dengan adaptasi:

### **Colors**
- **Primary:** Sky Blue (#0ea5e9)
- **Accent:** Amber (#f59e0b)
- **Background:** White → Sky-50 gradient
- **Text:** Neutral-950 (#0a0a0a)

### **Typography**
- **Font:** Inter (weight 400 & 500)
- **Headings:** Weight 500
- **Body:** Weight 400

### **Spacing**
- **Section gaps:** 80-120px
- **Card padding:** 32-48px
- **Element gaps:** 16-24px

### **Border Radius**
- **Cards:** 28px
- **Buttons:** 28px
- **Badges:** 9999px (pill)
- **Inputs:** 8px

---

## 📁 Project Structure

```
SIRENCANA/
├── app/
│   ├── Config/
│   │   ├── Database.php      ✅ DB config
│   │   └── Routes.php        ✅ All routes
│   ├── Controllers/          ✅ 14 controllers
│   ├── Models/               ✅ 21 models
│   ├── Helpers/              ✅ auth + obe helpers
│   ├── Views/
│   │   ├── layout/
│   │   │   ├── auth_tailwind.php    ✅ Auth layout
│   │   │   └── main_tailwind.php    ✅ Main layout
│   │   ├── auth/
│   │   │   └── login.php            ✅ Login page
│   │   └── dashboard.php            ✅ Dashboard
│   └── Database/
│       ├── Migrations/       ✅ 2 migrations
│       └── Seeds/            ✅ User seeders
├── public/
│   └── assets/css/
│       ├── input.css         ✅ Components
│       └── output.css        ✅ Compiled
├── .env                      ✅ Config (FIXED!)
├── tailwind.config.js        ✅ Sky + Amber
├── BACKEND_SETUP.md          ✅ Full setup guide
├── DESIGN_IMPLEMENTATION.md  ✅ Design docs
└── QUICK_START.md            ✅ This file
```

---

## ✅ Current Status

- ✅ `.env` file fixed
- ✅ Encryption key generated
- ✅ Session folder ready
- ✅ Design system applied
- ✅ All views updated
- ✅ Backend fully integrated
- ⏳ **Need to:** Create database + Run migrations
- ⏳ **Need to:** Seed admin user
- ⏳ **Then:** Ready to use!

---

## 🚀 Commands Summary

```bash
# 1. Create database (via MySQL/phpMyAdmin)
CREATE DATABASE sirencana_db;

# 2. Run migrations
cd d:\laragon\www\SIRENCANA
php spark migrate

# 3. Seed admin user
php spark db:seed UserSeeder

# 4. Open browser
http://localhost/SIRENCANA/login

# Login
Username: admin
Password: admin123
```

---

## 🎉 Ready!

Setelah menjalankan 3 commands di atas, SIRENCANA siap digunakan!

**Features:**
- ✅ Sky Blue + Amber design
- ✅ Modern & clean interface
- ✅ Role-based access
- ✅ Complete OBE system
- ✅ RPS workflow
- ✅ Presensi & Nilai
- ✅ Portofolio & Reports

**Enjoy your new SIRENCANA! 🎨✨**
