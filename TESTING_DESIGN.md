# Testing Design System SIRENCANA di Localhost

## Cara Menguji Design Baru

### 1. Pastikan Server Berjalan

```bash
# Di Laragon, pastikan Apache dan MySQL sudah aktif
# Akses: http://localhost/SIRENCANA atau http://sirencana.test
```

### 2. Clear Browser Cache

Tekan **Ctrl + Shift + R** (Windows) atau **Cmd + Shift + R** (Mac) untuk hard refresh dan memastikan CSS baru dimuat.

### 3. Halaman yang Harus Ditest

#### A. Halaman Login (`/login`)
**Yang harus dilihat:**
- ✅ Background gradient biru (sky blue → sky 600)
- ✅ Card login putih dengan shadow
- ✅ Font Inter (bukan Source Serif)
- ✅ Input fields dengan border 1.5px
- ✅ Button "Masuk" warna amber/kuning (#f59e0b)
- ✅ Focus state pada input (border biru + ring shadow)

#### B. Dashboard (`/` atau `/dashboard`)
**Yang harus dilihat:**
- ✅ Sidebar dengan gradient biru vertikal
- ✅ Text sidebar putih dengan opacity
- ✅ Active menu item: background rgba(255,255,255,0.15)
- ✅ Button "Keluar" warna amber
- ✅ Stat cards dengan gradient biru muda ke putih
- ✅ Angka statistik berwarna biru (#3b82f6)
- ✅ Panel cards dengan border 1.5px dan radius 16px
- ✅ Table dengan hover state (background sky-tint)
- ✅ Badge status dengan pill shape

#### C. Form Pages (misal: Tambah RPS, Edit Mata Kuliah)
**Yang harus dilihat:**
- ✅ Input fields dengan border abu-abu
- ✅ Focus state biru dengan shadow ring
- ✅ Label dengan font weight 500
- ✅ Button primary (amber) dan ghost (blue outline)
- ✅ Textarea dengan min-height 80px
- ✅ Checkbox/radio dengan accent color biru

#### D. Table Pages (List Dosen, Mahasiswa, dll)
**Yang harus dilihat:**
- ✅ Table header dengan background abu muda (#f8fafc)
- ✅ Row hover dengan background sky-tint (#eff6ff)
- ✅ Link actions berwarna biru
- ✅ Button "Tambah" amber di kanan atas

#### E. Detail Pages (Detail RPS, dll)
**Yang harus dilihat:**
- ✅ Panel sections dengan spacing generous
- ✅ Badge status dengan uppercase text
- ✅ Definition list (dt/dd) dengan grid layout
- ✅ Divider dengan warna border-gray

### 4. Interaksi yang Harus Ditest

#### Button Hover
- Hover pada button amber → warna lebih gelap + shadow + translateY(-1px)
- Hover pada button ghost → background sky-tint

#### Card Hover
- Hover pada stat card → border biru + shadow + translateY(-2px)
- Hover pada panel → border color berubah ke light-sky

#### Table Hover
- Hover pada table row → background sky-tint

#### Input Focus
- Focus pada input → border biru + shadow ring 3px

#### Navigation
- Click menu → active state dengan background putih transparan
- Hover menu → background rgba(255,255,255,0.08)

### 5. Responsive Testing

#### Desktop (>1024px)
- Sidebar visible full width
- Stat cards grid 2-4 columns
- Table full width

#### Tablet (768px - 1024px)
- Sidebar tetap visible
- Stat cards grid 2-3 columns

#### Mobile (<768px)
- **CATATAN:** Responsive belum fully optimized, tapi:
- Stat cards jadi 1 column
- Sidebar jadi position static (bukan sticky)

### 6. Fitur Backend yang Harus Ditest

#### Authentication
- [ ] Login berhasil
- [ ] Logout berhasil
- [ ] Session tetap berfungsi

#### CRUD Operations
- [ ] Create data (RPS, Mata Kuliah, dll)
- [ ] Read/View data
- [ ] Update data
- [ ] Delete data
- [ ] Form validation tetap berfungsi

#### Flash Messages
- [ ] Success alert (hijau dengan border-left)
- [ ] Error alert (merah dengan border-left)

#### Status Flow
- [ ] Badge status tampil dengan warna yang benar
- [ ] Status workflow RPS berfungsi
- [ ] Approval flow berjalan normal

### 7. Browser Compatibility Test

Test di:
- [ ] Chrome/Edge (recommended)
- [ ] Firefox
- [ ] Safari (jika ada)

### 8. Performance Check

- [ ] Page load cepat (CSS minimal)
- [ ] Hover effects smooth (no lag)
- [ ] Transitions tidak janky
- [ ] Font loading tidak FOUT (Flash of Unstyled Text)

### 9. Known Issues / Limitations

1. **Sidebar mobile:** Belum ada hamburger menu, jadi di mobile sidebar akan muncul di atas
2. **Font fallback:** Jika Inter gagal load, akan fallback ke IBM Plex Sans → system font
3. **Legacy compatibility:** Beberapa legacy CSS variables tetap ada untuk backward compatibility

## Jika Ada Masalah

### CSS Tidak Berubah
1. Hard refresh browser (Ctrl + Shift + R)
2. Clear browser cache
3. Cek file `public/assets/style.css` sudah terupdate
4. Cek console browser untuk error loading CSS

### Warna Tidak Sesuai
1. Cek CSS variables di `:root`
2. Pastikan browser support CSS custom properties
3. Cek apakah ada inline styles yang override

### Button Tidak Clickable
1. Cek z-index
2. Cek pointer-events
3. Cek apakah ada element yang overlap

### Fungsi Backend Rusak
1. Cek console browser untuk JS errors
2. Cek network tab untuk failed requests
3. Cek error log PHP di Laragon
4. **Rollback:** Restore style.css dari git jika perlu

## Rollback Plan

Jika design baru bermasalah:

```bash
# Git restore (jika sudah commit sebelumnya)
git checkout HEAD~1 -- public/assets/style.css
git checkout HEAD~1 -- app/Views/layout/main.php
git checkout HEAD~1 -- app/Views/layout/auth.php
```

Atau restore manual dari backup.

## Contact

Jika ada pertanyaan atau issue, hubungi developer atau buat issue di repository.

---

**Happy Testing!** 🎨✨
