# 🎨 SIRENCANA Frontend - Tailwind CSS Implementation

## 📌 Overview

Proyek ini menggunakan **Tailwind CSS** dengan skema warna kustom:
- **Biru (#0000FF)** untuk background dan komponen utama
- **Emas (#FFD700)** untuk border dan accent
- **Kuning (#FFFF00)** untuk tombol dan alert

---

## 🚀 Quick Start

### 1. Install Dependencies
```bash
npm install
```

### 2. Development Mode (Watch)
```bash
npm run dev
```

Ini akan menjalankan Tailwind dalam mode watch. Setiap perubahan di `input.css` akan otomatis di-compile.

### 3. Production Build
```bash
npm run build
```

Ini akan menghasilkan CSS yang sudah di-minify untuk production.

---

## 📂 File Structure

```
SIRENCANA/
│
├── public/assets/css/
│   ├── input.css          # 📝 EDIT FILE INI untuk custom CSS
│   ├── output.css         # ⚙️ GENERATED - jangan edit manual
│   └── style.css          # 📦 Old CSS (backup)
│
├── app/Views/
│   ├── layout/
│   │   ├── main_tailwind.php       # Layout utama (gunakan ini)
│   │   ├── auth_tailwind.php       # Layout login
│   │   ├── main.php                # Old layout (backup)
│   │   └── auth.php                # Old auth layout (backup)
│   │
│   ├── dashboard_new.php            # Dashboard dengan Tailwind
│   └── auth/
│       └── login_tailwind.php       # Login dengan Tailwind
│
├── tailwind.config.js     # ⚙️ Konfigurasi Tailwind & warna
├── package.json           # NPM scripts
├── THEME-GUIDE.md         # 📖 Dokumentasi lengkap
└── THEME-PREVIEW.html     # 🎨 Preview visual komponen
```

---

## 🎯 Cara Migrasi View Lama ke Tailwind

### Step 1: Ganti Layout
Ubah dari:
```php
<?= $this->extend('layout/main') ?>
```

Menjadi:
```php
<?= $this->extend('layout/main_tailwind') ?>
```

### Step 2: Update Class CSS
Ganti class lama dengan Tailwind class baru:

| Old Class | New Class |
|-----------|-----------|
| `.panel` | `.card` |
| `.stat` | `.stat-card` |
| `.btn` | `.btn-primary` / `.btn-yellow` |
| `.link` | `text-primary-800 hover:underline` |
| `.alert.success` | `.alert.alert-success` |

### Step 3: Test di Browser
Buka halaman dan pastikan styling sudah sesuai.

---

## 🛠️ Custom Components

### Membuat Komponen Baru

Edit `public/assets/css/input.css`:

```css
@layer components {
  .my-new-component {
    @apply bg-primary-800 border-2 border-gold rounded-lg p-4;
  }
}
```

Lalu build:
```bash
npm run build
```

### Contoh Penggunaan:
```php
<div class="my-new-component">
  Konten saya
</div>
```

---

## 🎨 Komponen yang Sudah Tersedia

### 1. Stats Card
```php
<div class="stat-card">
  <div class="stat-number">150</div>
  <div class="stat-label">Label</div>
</div>
```

### 2. Button
```php
<button class="btn-primary">Primary</button>
<button class="btn-yellow">Yellow</button>
<button class="btn-gold">Gold</button>
<button class="btn-outline">Outline</button>
```

### 3. Card/Panel
```php
<div class="card">
  <h2 class="card-header">Judul</h2>
  <p>Konten...</p>
</div>
```

### 4. Table
```php
<div class="table-container">
  <table class="table">
    <thead>
      <tr><th>Header</th></tr>
    </thead>
    <tbody>
      <tr><td>Data</td></tr>
    </tbody>
  </table>
</div>
```

### 5. Form
```php
<div class="form-group">
  <label class="form-label">Label</label>
  <input type="text" class="form-input">
</div>
```

### 6. Alert
```php
<div class="alert alert-success">Success message</div>
<div class="alert alert-error">Error message</div>
<div class="alert alert-warning">Warning message</div>
<div class="alert alert-info">Info message</div>
```

**📖 Lihat THEME-GUIDE.md untuk dokumentasi lengkap!**

---

## 🎨 Preview Komponen

Buka file `THEME-PREVIEW.html` di browser untuk melihat preview visual semua komponen.

```bash
# Buka di browser
start THEME-PREVIEW.html
```

---

## 🔧 Troubleshooting

### CSS tidak berubah setelah edit
```bash
# Pastikan Tailwind running dalam watch mode
npm run dev

# Atau build ulang
npm run build

# Hard refresh di browser (Ctrl + Shift + R)
```

### Warna tidak sesuai
Cek `tailwind.config.js` pastikan warna sudah benar:
```js
colors: {
  primary: {
    800: '#0000FF', // Harus biru murni
  },
  gold: {
    DEFAULT: '#FFD700', // Harus emas
  },
  yellow: {
    DEFAULT: '#FFFF00', // Harus kuning
  }
}
```

### Class Tailwind tidak work
1. Pastikan path di `tailwind.config.js` sudah benar
2. Rebuild CSS: `npm run build`
3. Clear browser cache

---

## 📋 Checklist Frontend Developer

- [ ] Install dependencies (`npm install`)
- [ ] Jalankan watch mode (`npm run dev`)
- [ ] Baca `THEME-GUIDE.md`
- [ ] Buka `THEME-PREVIEW.html` untuk lihat komponen
- [ ] Migrasi view prioritas:
  - [ ] Dashboard
  - [ ] Sidebar & Navbar
  - [ ] Form Login
  - [ ] Tabel
  - [ ] Cards
- [ ] Test di berbagai browser
- [ ] Test responsive (mobile, tablet)
- [ ] Build production (`npm run build`)

---

## 🎓 Resources

- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [THEME-GUIDE.md](./THEME-GUIDE.md) - Dokumentasi lengkap komponen
- [THEME-PREVIEW.html](./THEME-PREVIEW.html) - Preview visual

---

## 💡 Tips

1. **Selalu gunakan class Tailwind** daripada inline style
2. **Test di THEME-PREVIEW.html** sebelum implement di view
3. **Gunakan `@apply` di input.css** untuk komponen yang sering dipakai
4. **Jangan edit output.css** karena akan di-overwrite saat build
5. **Keep it simple** - gunakan komponen yang sudah ada

---

## 📞 Support

Ada pertanyaan? Lihat dokumentasi di `THEME-GUIDE.md` atau preview di `THEME-PREVIEW.html`.

**Happy Coding! 🚀**
