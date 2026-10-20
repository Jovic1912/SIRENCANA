# 🎨 SIRENCANA Theme Guide - Blue, Gold & Yellow

## 📋 Daftar Isi
1. [Palet Warna](#palet-warna)
2. [Setup & Instalasi](#setup--instalasi)
3. [Komponen Utama](#komponen-utama)
4. [Contoh Penggunaan](#contoh-penggunaan)

---

## 🎨 Palet Warna

### Biru (Primary) - Gradasi dari Gelap ke Terang
```css
primary-950: #000066  /* Sangat gelap - teks on light */
primary-900: #0000CC  /* Gelap - sidebar dark */
primary-800: #0000FF  /* Biru murni - warna utama Anda ✨ */
primary-700: #3333FF  /* Hover states */
primary-600: #6666FF  /* Active states */
primary-500: #8080FF  /* Medium backgrounds */
primary-400: #9999FF  /* Light hover */
primary-300: #B3B3FF  /* Borders light */
primary-200: #CCCCFF  /* Background light */
primary-100: #E6E6FF  /* Background very light */
primary-50:  #F5F5FF  /* Almost white */
```

### Emas (Accent/Border)
```css
gold:       #FFD700  /* Default - border utama ✨ */
gold-dark:  #E6C200  /* Hover/darker */
gold-light: #FFED4E  /* Lighter */
gold-pale:  #FFF8DC  /* Background */
```

### Kuning (Button/Alert)
```css
yellow:       #FFFF00  /* Default - tombol & alert ✨ */
yellow-dark:  #E6E600  /* Hover */
yellow-light: #FFFF66  /* Lighter */
yellow-pale:  #FFFFCC  /* Background */
```

---

## 🚀 Setup & Instalasi

### 1. Install Dependencies
```bash
cd d:\laragon\www\SIRENCANA
npm install -D tailwindcss
```

### 2. Build CSS
```bash
# Development (watch mode)
npm run dev

# Production (minified)
npm run build
```

### 3. Gunakan Layout Tailwind
Ganti `layout/main` dengan `layout/main_tailwind` di view Anda:

```php
<?= $this->extend('layout/main_tailwind') ?>
```

---

## 🧩 Komponen Utama

### 1. 📊 Dashboard - Stats Card

**Class:** `stat-card`, `stat-number`, `stat-label`

```php
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
  <div class="stat-card">
    <div class="stat-number">150</div>
    <div class="stat-label">Mata Kuliah terdaftar</div>
  </div>
</div>
```

**Hasil:**
- Background: Gradasi biru muda (primary-100 → primary-50)
- Border: Emas 2px
- Hover: Shadow meningkat
- Font angka: Serif bold 4xl

---

### 2. 🎨 Sidebar & Navbar

**Sidebar Background:** Gradasi biru (primary-800 → primary-900)  
**Border Right:** Emas 4px  
**Link:** `sidebar-link`, `sidebar-link.active`

```php
<a href="<?= site_url('/') ?>" class="sidebar-link <?= $active ?>">
  <span>📊</span> Dasbor
</a>
```

**Active State:**
- Background: primary-600
- Border left: Emas 4px
- Font: Bold

---

### 3. 🔐 Form Login

**Background:** Gradasi biru penuh (primary-800 → primary-900)  
**Card:** Background putih, border emas 4px, shadow besar  
**Button:** `btn-yellow` (kuning dengan border emas)

```php
<button type="submit" class="w-full btn-yellow py-3">
  🔐 Masuk
</button>
```

**Input Field:**
```php
<input type="text" class="form-input" placeholder="Username">
```

---

### 4. 📋 Tabel

**Class:** `table-container`, `table`

```php
<div class="table-container">
  <table class="table">
    <thead>
      <tr>
        <th>Kolom 1</th>
        <th>Kolom 2</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Data 1</td>
        <td>Data 2</td>
      </tr>
    </tbody>
  </table>
</div>
```

**Fitur:**
- Border: Emas 2px pada container
- Header: Gradasi biru (primary-800 → primary-700), teks putih
- Baris: Hover background primary-50
- Zebra striping: primary-50/50 (baris genap)

---

### 5. 🃏 Card/Panel

**Class:** `card`, `card-header`

```php
<div class="card">
  <h2 class="card-header">Judul Panel</h2>
  <p>Konten panel...</p>
</div>
```

**Style:**
- Background: Putih
- Border: Emas 2px
- Shadow: Medium
- Header: Border bottom emas 2px

---

### 6. 🔘 Buttons

#### Primary Button (Biru + Border Emas)
```php
<button class="btn-primary">Simpan</button>
```

#### Yellow Button (Kuning + Border Emas)
```php
<button class="btn-yellow">Submit</button>
```

#### Gold Button (Emas + Border Biru)
```php
<button class="btn-gold">Special Action</button>
```

#### Outline Button (Transparan + Border Emas)
```php
<button class="btn-outline">Batal</button>
```

---

### 7. ⚠️ Alert

```php
<!-- Success -->
<div class="alert alert-success">
  ✓ Data berhasil disimpan!
</div>

<!-- Error -->
<div class="alert alert-error">
  ✗ Terjadi kesalahan!
</div>

<!-- Warning (Kuning) -->
<div class="alert alert-warning">
  ⚠️ Perhatian: Data akan dihapus!
</div>

<!-- Info (Biru) -->
<div class="alert alert-info">
  ℹ️ Informasi penting
</div>
```

---

### 8. 🏷️ Badge Status

```php
<span class="badge badge-primary">Status</span>
<span class="badge badge-gold">Premium</span>
<span class="badge badge-yellow">Pending</span>
```

**Badge OBE Status:**
```php
<?= status_badge('draft') ?>          <!-- Abu-abu -->
<?= status_badge('diajukan') ?>       <!-- Biru -->
<?= status_badge('revisi_diperlukan') ?> <!-- Merah -->
<?= status_badge('disetujui_gkm') ?>  <!-- Hijau -->
<?= status_badge('ditandatangani') ?> <!-- Kuning -->
<?= status_badge('diarsipkan') ?>     <!-- Emas (bold) -->
```

---

### 9. 📝 Form Input

```php
<div class="form-group">
  <label class="form-label">Nama</label>
  <input type="text" class="form-input" placeholder="Masukkan nama">
</div>
```

**Style:**
- Border: Emas 2px
- Focus: Border primary-600, ring primary-300
- Transition: Smooth

---

## 💡 Contoh Lengkap - Halaman dengan Semua Komponen

```php
<?= $this->extend('layout/main_tailwind') ?>
<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header">
  <h1 class="page-title">Judul Halaman</h1>
  <p class="page-subtitle">Deskripsi halaman</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-3 gap-4 mb-6">
  <div class="stat-card">
    <div class="stat-number">42</div>
    <div class="stat-label">Total Data</div>
  </div>
</div>

<!-- Form Card -->
<div class="card mb-6">
  <h2 class="card-header">Form Input</h2>
  
  <form>
    <div class="form-group">
      <label class="form-label">Nama</label>
      <input type="text" class="form-input">
    </div>
    
    <div class="flex justify-end gap-3">
      <button type="button" class="btn-outline">Batal</button>
      <button type="submit" class="btn-yellow">Simpan</button>
    </div>
  </form>
</div>

<!-- Table Card -->
<div class="card">
  <h2 class="card-header">Data Tabel</h2>
  
  <div class="table-container">
    <table class="table">
      <thead>
        <tr>
          <th>Kolom 1</th>
          <th>Kolom 2</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Data 1</td>
          <td>Data 2</td>
          <td><span class="badge badge-gold">Active</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
```

---

## 🎯 Utility Classes Khusus

### Gradien Teks Biru
```html
<h1 class="text-gradient-blue">Teks dengan Gradien</h1>
```

### Shadow Effects
```html
<div class="shadow-gold">Shadow emas</div>
<div class="shadow-blue">Shadow biru</div>
```

---

## 📂 File Structure

```
SIRENCANA/
├── public/assets/css/
│   ├── input.css         # Source Tailwind (edit ini)
│   ├── output.css        # Generated (jangan edit)
│   └── style.css         # Old CSS (backup)
├── app/Views/
│   ├── layout/
│   │   ├── main_tailwind.php      # Layout utama dengan Tailwind
│   │   └── auth_tailwind.php      # Layout auth dengan Tailwind
│   ├── dashboard_new.php          # Dashboard dengan Tailwind
│   └── auth/
│       └── login_tailwind.php     # Login dengan Tailwind
├── tailwind.config.js    # Config Tailwind
└── package.json          # NPM scripts
```

---

## 🔄 Cara Update/Custom

### Tambah Warna Baru
Edit `tailwind.config.js`:
```js
theme: {
  extend: {
    colors: {
      'custom-color': '#HEX_CODE',
    }
  }
}
```

### Tambah Komponen Baru
Edit `public/assets/css/input.css`:
```css
@layer components {
  .my-component {
    @apply bg-primary-800 border-2 border-gold;
  }
}
```

Lalu build ulang:
```bash
npm run build
```

---

## ✅ Checklist Migration

### Prioritas 1: Dashboard ✅
- [x] Stats cards dengan border emas
- [x] Panel dengan border emas
- [x] Progress bar dengan gradasi biru
- [x] Badge status

### Prioritas 2: Sidebar & Navbar ✅
- [x] Background gradasi biru
- [x] Border emas
- [x] Link styling
- [x] Active state

### Prioritas 3: Form Login ✅
- [x] Background gradasi biru
- [x] Card border emas
- [x] Input border emas
- [x] Button kuning

### Prioritas 4: Tabel ✅
- [x] Container border emas
- [x] Header gradasi biru
- [x] Row hover effects
- [x] Zebra striping

### Prioritas 5: Cards ✅
- [x] Border emas
- [x] Header border emas
- [x] Shadow effects

---

## 🎨 Preview Warna

Lihat file `THEME-PREVIEW.html` (akan dibuat) untuk preview visual semua komponen.

---

## 📞 Support

Jika ada pertanyaan atau butuh custom komponen:
1. Edit `input.css` untuk styling baru
2. Jalankan `npm run build`
3. Test di browser
4. Commit perubahan

**Happy Coding! 🚀**
