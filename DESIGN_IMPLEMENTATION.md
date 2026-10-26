# SIRENCANA Design System Implementation

> Sky Blue Gradasi ke Putih dengan Button Amber
> Berdasarkan DESIGN_peerk.md dengan adaptasi warna

## 🎨 Color Palette

### Primary Colors
- **Sky Blue:** `#0ea5e9` (sky-600) - Warna utama untuk sidebar, headers, links
- **White:** `#ffffff` - Background utama
- **Neutral Black:** `#0a0a0a` (neutral-950) - Teks utama

### Accent Colors
- **Amber:** `#f59e0b` (amber-500) - Primary button dan CTA
- **Sky Light:** `#38bdf8` (sky-500) - Light accents
- **Sky Pale:** `#f0f9ff` (sky-100) - Light backgrounds

### Gradients
- **Background:** `from-sky-50 via-white to-neutral-50`
- **Sidebar:** `from-sky-600 via-sky-700 to-sky-800`
- **Stats Cards:** `from-sky-50 to-white`

## 📐 Design Principles (dari design.md)

### 1. **Flat Design - No Shadows**
Sistem menggunakan tonal contrast untuk separasi layer, bukan shadow elevation:
```css
.card {
  box-shadow: none; /* Flat design */
  border: 1px solid sky-200/50; /* Tonal separation */
}
```

### 2. **Border Radius - 28px untuk Cards & Buttons**
```css
--radius-card: 28px;
--radius-button: 28px;
--radius-pill: 9999px;
--radius-input: 8px;
--radius-inner: 18px;
```

### 3. **Typography - Weight 400 & 500**
- **Weight 400:** Body text, supporting content
- **Weight 500:** Headings, labels, CTAs
- **Font:** Inter (primary), Source Serif 4 (optional)

### 4. **Generous Spacing**
- Section gaps: 80-120px
- Card padding: 32-48px (8-12 dalam Tailwind)
- Element gaps: 16-24px

## 🔧 Components

### Primary Button (Amber)
```php
<button class="btn-amber">
  Action Text
</button>
```
- Background: `amber-500`
- Text: `neutral-950`
- Radius: `28px`
- Weight: `500`

### Secondary/Ghost Button
```php
<button class="btn-ghost">
  Secondary Action
</button>
```
- Background: transparent
- Hover: `sky-100`
- Radius: `9999px` (pill)

### Card
```php
<div class="card">
  <h2 class="card-header">Title</h2>
  <!-- Content -->
</div>
```
- Radius: `28px`
- Padding: `32px` (p-8)
- Border: `sky-200/50`
- No shadow

### Stat Card
```php
<div class="stat-card">
  <div class="stat-number">123</div>
  <div class="stat-label">Label</div>
</div>
```
- Gradient: `from-sky-50 to-white`
- Radius: `28px`
- Hover: border `sky-300/70`

### Table
```php
<div class="table-container">
  <table class="table">
    <thead>...</thead>
    <tbody>...</tbody>
  </table>
</div>
```
- Header: `from-sky-600 to-sky-700`
- Border radius: `28px`
- Zebra striping dengan `sky-50/30`

### Badge/Status
```php
<?= status_badge($status) ?>
```
- Radius: `9999px` (pill)
- Weight: `500`
- Letter-spacing: `0.05em`

### Form Input
```php
<input type="text" class="form-input" />
```
- Radius: `8px`
- Border: `sky-200`
- Focus: `sky-500` dengan ring `sky-200`

## 📱 Layout Structure

### Auth Layout (`layout/auth_tailwind.php`)
```
- Background: sky-100 → white → sky-50 gradient
- Card: white, 28px radius, centered
- Max-width: 448px (max-w-md)
- Padding: 40px (p-10)
```

### Main Layout (`layout/main_tailwind.php`)
```
- Sidebar: 256px width, sky gradient
- Main: flex-1, max-w-7xl
- Background: sky-50 → white → neutral-50
```

## 🎯 Key Pages Updated

### ✅ Auth Pages
- [x] `app/Views/layout/auth_tailwind.php` - Layout dengan sky blue gradient
- [x] `app/Views/auth/login.php` - Login dengan button amber

### ✅ Dashboard
- [x] `app/Views/layout/main_tailwind.php` - Main layout dengan sidebar sky blue
- [x] `app/Views/dashboard.php` - Dashboard dengan stats cards dan tables

### 🔄 Pending (untuk diupdate)
- [ ] `app/Views/kurikulum/*.php`
- [ ] `app/Views/rps/*.php`
- [ ] `app/Views/kelas/*.php`
- [ ] `app/Views/master/*.php` (prodi, dosen, mahasiswa, mata kuliah)
- [ ] `app/Views/presensi/*.php`
- [ ] `app/Views/capaian/*.php`
- [ ] `app/Views/portofolio/*.php`
- [ ] `app/Views/users/*.php`

## 🚀 Quick Implementation Guide

### Untuk halaman baru:

1. **Extend layout yang benar:**
```php
<?= $this->extend('layout/main_tailwind') ?>
<?= $this->section('content') ?>
```

2. **Gunakan page header:**
```php
<div class="page-header">
  <h1 class="page-title">Title</h1>
  <p class="page-subtitle">Subtitle</p>
</div>
```

3. **Gunakan card untuk konten:**
```php
<div class="card mb-12">
  <h2 class="card-header">Section Title</h2>
  <!-- Content -->
</div>
```

4. **Button amber untuk primary action:**
```php
<button class="btn-amber">Primary Action</button>
<button class="btn-outline">Secondary</button>
```

## 📦 Files Modified

### Config
- ✅ `tailwind.config.js` - Sky blue + amber color system
- ✅ `public/assets/css/input.css` - Components sesuai design.md
- ✅ `public/assets/css/output.css` - Compiled (auto-generated)

### Layouts
- ✅ `app/Views/layout/auth_tailwind.php`
- ✅ `app/Views/layout/main_tailwind.php`

### Views
- ✅ `app/Views/auth/login.php`
- ✅ `app/Views/dashboard.php`

## 🔄 Next Steps

1. **Update semua halaman lain** untuk menggunakan `layout/main_tailwind.php`
2. **Ganti semua button** dengan class `btn-amber` atau `btn-ghost`
3. **Update semua card** dengan class `card` dan `card-header`
4. **Update semua table** dengan class `table-container` dan `table`
5. **Compile Tailwind** setiap kali ada perubahan:
   ```bash
   npx tailwindcss -i ./public/assets/css/input.css -o ./public/assets/css/output.css --minify
   ```

## 📝 Notes

- **Inter font** diload via Google Fonts
- **No heavy shadows** - mengikuti flat design principle dari design.md
- **28px radius** untuk cards dan buttons - signature dari design.md
- **Amber button** sebagai singular action signal
- **Sky blue gradient** untuk backgrounds - friendly dan modern
- **Generous spacing** - 80-120px section gaps, 32-48px card padding

## 🎨 Color Variables Reference

```js
// Sky Blue Scale
sky-950: '#0c4a6e'  // Dark text
sky-800: '#0369a1'  // Sidebar dark
sky-600: '#0ea5e9'  // Primary
sky-500: '#38bdf8'  // Light
sky-300: '#bae6fd'  // Pale
sky-200: '#e0f2fe'  // Almost white
sky-100: '#f0f9ff'  // Very light
sky-50: '#f8fcff'   // Near white

// Amber Scale  
amber-900: '#78350f' // Text on amber
amber-500: '#f59e0b' // Primary button
amber-400: '#fbbf24' // Hover
amber-200: '#fde68a' // Light
amber-100: '#fef3c7' // Very light

// Neutral Scale
neutral-950: '#0a0a0a' // Almost black
neutral-700: '#404040' // Medium
neutral-600: '#525252' // Text secondary
neutral-200: '#e5e5e5' // Border
neutral-100: '#f5f5f5' // Light bg
neutral-50: '#fafafa'  // Almost white
```
