# Quick Start Guide - SIRENCANA Design System

## 🎨 Design System Cheat Sheet

### Colors - Copy & Paste

```css
/* Primary Actions */
#f59e0b  /* Amber button */
#d97706  /* Amber hover */

/* Navigation */
#3b82f6  /* Sky blue */
#2563eb  /* Sky blue dark */

/* Text */
#1e293b  /* Primary text */
#64748b  /* Muted text */
#ffffff  /* White on dark */

/* Backgrounds */
#ffffff  /* Main background */
#f8fafc  /* Surface gray */
#eff6ff  /* Sky tint (hover) */

/* Borders */
#e2e8f0  /* Border gray */

/* Status */
#10b981  /* Success */
#f97316  /* Warning */
#ef4444  /* Error */
```

### Common Components

#### 1. Button (Primary)
```html
<button class="btn">Simpan</button>
<button class="btn sm">Simpan</button>
```

#### 2. Button (Outline/Ghost)
```html
<button class="btn ghost">Batal</button>
```

#### 3. Button Variants
```html
<button class="btn teal">Setujui</button>
<button class="btn amber">Update</button>
<button class="btn red">Hapus</button>
```

#### 4. Link/Action
```html
<a href="#" class="link">Lihat Detail →</a>
```

#### 5. Badge/Status
```html
<span class="badge draft">Draft</span>
<span class="badge diajukan">Diajukan</span>
<span class="badge diarsipkan">Diarsipkan</span>
```

#### 6. Card/Panel
```html
<div class="panel">
  <h2>Judul Panel</h2>
  <p>Konten...</p>
</div>
```

#### 7. Stat Card
```html
<div class="grid-stats">
  <div class="stat">
    <div class="n">42</div>
    <div class="l">Label Statistik</div>
  </div>
</div>
```

#### 8. Table
```html
<div class="tbl-wrap">
  <table>
    <thead>
      <tr>
        <th>Kolom 1</th>
        <th class="num">Angka</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Data</td>
        <td class="num">123</td>
      </tr>
    </tbody>
  </table>
</div>
```

#### 9. Form Field
```html
<div class="field">
  <label>Nama</label>
  <input type="text" placeholder="Masukkan nama...">
</div>
```

#### 10. Form Row (Multi-column)
```html
<div class="field-row">
  <div class="field">
    <label>Field 1</label>
    <input type="text">
  </div>
  <div class="field">
    <label>Field 2</label>
    <input type="text">
  </div>
</div>
```

#### 11. Alert Messages
```html
<div class="alert success">Berhasil disimpan!</div>
<div class="alert error">Terjadi kesalahan.</div>
```

#### 12. Empty State
```html
<div class="empty">Tidak ada data.</div>
```

### Layout Structure

```html
<!-- Main Layout (sudah di layout/main.php) -->
<div id="shell">
  <aside id="sidebar">
    <!-- Navigation -->
  </aside>
  <main id="main">
    <!-- Content -->
  </main>
</div>
```

### Spacing Scale

```
4px   → var(--spacing-1)
8px   → var(--spacing-2)
12px  → var(--spacing-3)
16px  → var(--spacing-4)
20px  → var(--spacing-5)
24px  → var(--spacing-6)
32px  → var(--spacing-8)
48px  → var(--spacing-12)
```

### Border Radius

```
6px    → var(--radius-sm)
8px    → (inputs)
12px   → var(--radius-base) / var(--radius-button)
16px   → var(--radius-card) / var(--radius-panel)
9999px → var(--radius-pill) (badges)
```

## 🚀 Usage Examples

### Example 1: Simple Form
```html
<div class="panel">
  <h2>Tambah Data</h2>
  <form method="post" action="...">
    <div class="field-row">
      <div class="field">
        <label>Nama</label>
        <input type="text" name="nama" required>
      </div>
      <div class="field">
        <label>Email</label>
        <input type="email" name="email" required>
      </div>
    </div>
    <div class="field">
      <label>Keterangan</label>
      <textarea name="keterangan"></textarea>
    </div>
    <button type="submit" class="btn">Simpan</button>
  </form>
</div>
```

### Example 2: Data Table with Actions
```html
<div class="panel">
  <h2>Daftar Mahasiswa</h2>
  <div class="tbl-wrap">
    <table>
      <thead>
        <tr>
          <th>NIM</th>
          <th>Nama</th>
          <th>Program Studi</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="mono">1234567890</td>
          <td>John Doe</td>
          <td>Informatika</td>
          <td>
            <a href="..." class="link">Edit</a>
            <button class="iconbtn">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
```

### Example 3: Stats Dashboard
```html
<div class="grid-stats">
  <div class="stat">
    <div class="n">42</div>
    <div class="l">Total Mahasiswa</div>
  </div>
  <div class="stat">
    <div class="n">12</div>
    <div class="l">Mata Kuliah</div>
  </div>
  <div class="stat">
    <div class="n">8</div>
    <div class="l">Kelas Aktif</div>
  </div>
</div>
```

### Example 4: Status Flow
```html
<div class="status-flow">
  <span>Draft</span>
  <span>→</span>
  <span class="cur">Diajukan</span>
  <span>→</span>
  <span>Disetujui</span>
</div>
```

## 🎯 CSS Custom Properties Reference

### Using CSS Variables in Inline Styles

```html
<!-- Border color -->
<div style="border: 1px solid var(--color-border-gray)">...</div>

<!-- Text color -->
<span style="color: var(--color-soft-ink)">Muted text</span>

<!-- Background -->
<div style="background: var(--color-surface-gray)">...</div>

<!-- Spacing -->
<div style="padding: var(--spacing-4)">...</div>

<!-- Radius -->
<div style="border-radius: var(--radius-base)">...</div>
```

## 📦 Utility Classes (Baru)

```html
<!-- Text Alignment -->
<div class="text-center">Centered</div>
<div class="text-right">Right</div>

<!-- Text Color -->
<span class="text-muted">Muted text</span>
<span class="text-primary">Primary text</span>

<!-- Font Weight -->
<span class="font-bold">Bold text</span>
<span class="font-medium">Medium text</span>

<!-- Flexbox -->
<div class="flex items-center gap-2">
  <span>Item 1</span>
  <span>Item 2</span>
</div>

<div class="flex justify-between items-center">
  <span>Left</span>
  <span>Right</span>
</div>

<!-- Spacing -->
<div class="mt-4">Margin top 16px</div>
<div class="mb-6">Margin bottom 24px</div>
<div class="p-4">Padding 16px</div>

<!-- Width -->
<button class="btn w-full">Full width button</button>

<!-- Display -->
<span class="block">Block element</span>
<span class="hidden">Hidden element</span>
```

## 🎨 Custom Styling Tips

### 1. Hover Effects
```css
.custom-card:hover {
  border-color: var(--color-light-sky);
  transform: translateY(-2px);
  transition: all 200ms ease;
}
```

### 2. Focus States
```css
.custom-input:focus {
  border-color: var(--color-sky-blue);
  box-shadow: 0 0 0 3px var(--color-pale-sky);
  outline: none;
}
```

### 3. Gradient Backgrounds
```css
.custom-hero {
  background: linear-gradient(135deg, 
    var(--color-sky-blue) 0%, 
    var(--color-sky-600) 100%);
}
```

## 🔍 Finding Components in Codebase

```bash
# Button usage
grep -r "class=\"btn" app/Views/

# Panel usage
grep -r "class=\"panel" app/Views/

# Badge usage
grep -r "status_badge" app/Views/
```

## 📱 Responsive Breakpoints

```css
/* Mobile first approach */
@media (max-width: 520px) {
  /* Small phones */
}

@media (max-width: 768px) {
  /* Tablets */
}

@media (max-width: 900px) {
  /* Small laptops (sidebar collapse) */
}

@media (min-width: 1024px) {
  /* Desktop */
}
```

## 🎭 Status Badge Colors

```php
// In PHP views, use helper:
<?= status_badge('draft') ?>           // Gray
<?= status_badge('diajukan') ?>        // Blue
<?= status_badge('diperiksa') ?>       // Blue
<?= status_badge('revisi_diperlukan') ?> // Red
<?= status_badge('disetujui_gkm') ?>   // Blue dark
<?= status_badge('ditandatangani') ?>  // Amber
<?= status_badge('diarsipkan') ?>      // Green
```

## 🛠️ Development Workflow

### 1. Create New View
```php
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pagehead">
  <div>
    <h1>Page Title</h1>
    <p>Page description...</p>
  </div>
</div>

<div class="panel">
  <!-- Your content here -->
</div>

<?= $this->endSection() ?>
```

### 2. Test Locally
```bash
# Start Laragon services
# Visit: http://localhost/SIRENCANA

# Hard refresh after CSS changes:
Ctrl + Shift + R (Windows)
Cmd + Shift + R (Mac)
```

### 3. Debug CSS
```javascript
// Browser console
getComputedStyle(document.documentElement)
  .getPropertyValue('--color-sky-blue')

// Check CSS variable
console.log(getComputedStyle(document.body).backgroundColor)
```

## 📚 Resources

- **Main Documentation:** `DESIGN.md`
- **Change Log:** `CHANGELOG_DESIGN.md`
- **Testing Guide:** `TESTING_DESIGN.md`
- **CSS File:** `public/assets/style.css`

## 🆘 Common Issues

### Issue 1: CSS Not Loading
```html
<!-- Check in browser console -->
<!-- Verify path: http://localhost/SIRENCANA/assets/style.css -->
<!-- Hard refresh: Ctrl + Shift + R -->
```

### Issue 2: Colors Not Applying
```css
/* Make sure you're using CSS variables */
/* ✅ Good */
color: var(--color-sky-blue);

/* ❌ Bad */
color: --color-sky-blue;
```

### Issue 3: Button Not Styled
```html
<!-- Check class name -->
<!-- ✅ Good -->
<button class="btn">Click</button>

<!-- ❌ Bad -->
<button class="button">Click</button>
```

## 💡 Pro Tips

1. **Use existing classes first** - Check existing views before creating new CSS
2. **Follow spacing scale** - Use 4px multiples (4, 8, 12, 16, 24, 32)
3. **Consistent naming** - Follow existing patterns in codebase
4. **Test responsive** - Always check layout on smaller screens
5. **Browser DevTools** - Use "Inspect Element" to see applied styles

---

**Happy Coding!** 🚀

Need help? Check `DESIGN.md` for detailed documentation or `TESTING_DESIGN.md` for testing guides.
