# Changelog Design System SIRENCANA

**Tanggal:** 27 Oktober 2026  
**Versi:** 1.0.0  
**Based on:** Perk design philosophy (DESIGN_peerk.md)

## Ringkasan Perubahan

Design system SIRENCANA telah diperbarui dengan skema warna biru langit gradasi ke putih dengan aksen button kuning amber, mengadaptasi filosofi design dari Perk (electric lime on warm parchment).

## Perubahan Utama

### 1. Skema Warna Baru

#### Warna Utama (Blues)
- **Sky Blue** `#3b82f6` - Background sidebar, primary color
- **Sky 600** `#2563eb` - Gradient sidebar, deeper blue
- **Light Sky** `#93c5fd` - Hover states, accents
- **Pale Sky** `#dbeafe` - Soft backgrounds
- **Sky Tint** `#eff6ff` - Very light backgrounds

#### Warna Aksi (Ambers)
- **Amber Action** `#f59e0b` - Primary button (menggantikan navy)
- **Amber Dark** `#d97706` - Button hover state
- **Amber 600** `#ca8a04` - Additional amber variant

#### Neutrals
- **Deep Ink** `#1e293b` - Primary text (menggantikan #1c2536)
- **Soft Ink** `#64748b` - Secondary text
- **Border Gray** `#e2e8f0` - Borders and dividers
- **Surface Gray** `#f8fafc` - Subtle backgrounds
- **Pure White** `#ffffff` - Main background

#### Status Colors (tetap konsisten)
- Success: `#10b981` / soft `#d1fae5`
- Warning: `#f97316` / soft `#fed7aa`
- Error: `#ef4444` / soft `#fee2e2`

### 2. Typography

- **Font Family:** Berubah dari `Source Serif 4` + `IBM Plex Sans` → **Inter** (sebagai pengganti OTSono)
- **Weights:** 400 (body), 500 (emphasis), 600 (headings), 700 (display)
- **Letter Spacing:** Negatif tracking untuk heading besar (≥28px)

### 3. Komponen yang Diperbarui

#### Sidebar
- Background: Linear gradient biru (#3b82f6 → #2563eb)
- Width: 236px → **260px**
- Navigation active state: Background rgba(255,255,255,0.15) dengan shadow
- Footer button: Warna amber untuk "Keluar"

#### Buttons
- **Primary (.btn):** Amber background dengan hover effect + shadow
- **Ghost (.btn.ghost):** Blue outline dengan hover background
- **Teal/Blue (.btn.teal):** Sky blue background
- Semua button: Border radius 12px, padding lebih besar, transform hover effect

#### Cards & Panels
- Border: 1px → **1.5px** dengan hover state (border color berubah)
- Border radius: 3px → **16px**
- Background stat card: Gradient biru muda ke putih
- Hover effect: Transform translateY + shadow

#### Forms
- Border: 1.5px dengan focus state biru
- Focus ring: 3px pale sky shadow
- Border radius: **8px**
- Checkbox/radio: Accent color biru

#### Tables
- Header background: Surface gray
- Row hover: Sky tint background
- Font size: 14px untuk body, 13px untuk header

#### Badges
- Border radius: **pill (9999px)**
- Text: Uppercase dengan letter-spacing
- Padding: 4px 12px
- Warna disesuaikan dengan theme baru

#### Alerts
- Border-left: **4px solid** (accent color)
- Border radius: 12px
- Padding: 14px 18px

### 4. Spacing & Layout

- Section gaps: 22px → **32px**
- Card padding: 20-22px → **24-28px**
- Main content padding: 30px → **32-48px**
- Grid stats gap: 14px → **16px**

### 5. Transitions & Animations

- Semua interactive elements: Transition 150-200ms ease
- Hover states: Transform translateY(-1px atau -2px)
- Button hover: Box shadow dengan opacity

### 6. Responsive

- Breakpoint tetap di 900px untuk sidebar
- Grid stats: Minmax 150px → **180px**
- Mobile: Grid stats menjadi single column

## File yang Dimodifikasi

1. **public/assets/style.css** - CSS utama dengan design system baru
2. **app/Views/layout/main.php** - Font family Inter
3. **app/Views/layout/auth.php** - Halaman login dengan background gradient biru
4. **DESIGN.md** - Dokumentasi design system lengkap (file baru)

## Kompatibilitas Backend

✅ Semua struktur HTML dan class name **TETAP SAMA**  
✅ Semua helper functions (status_badge, dll) **TIDAK BERUBAH**  
✅ Semua controller dan model **TIDAK TERPENGARUH**  
✅ Hanya CSS yang diperbarui - tidak ada breaking changes

## Legacy Support

CSS variables legacy tetap dipertahankan untuk backward compatibility:
- `--ink` → `--color-deep-ink`
- `--navy` → `--color-sky-blue`
- `--teal` → `--color-sky-blue`
- `--amber` → `--color-amber-action`
- `--red` → `--color-error-red`
- dll.

## Testing Checklist

Sebelum production, pastikan test:

- [ ] Halaman login (gradient background biru)
- [ ] Dashboard dengan stat cards (gradient biru)
- [ ] Sidebar navigation (gradient + active states)
- [ ] Table dengan hover states
- [ ] Form inputs dengan focus states
- [ ] Buttons (primary amber, ghost blue, dll)
- [ ] Badges dengan berbagai status
- [ ] Alert messages (success, error)
- [ ] Responsive layout (<900px)
- [ ] Semua CRUD operations tetap berfungsi

## Browser Support

- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Modern browsers dengan CSS custom properties support

## Catatan Developer

Design system ini mengikuti prinsip Perk:
1. **Single accent color** - Amber untuk actions (seperti Perk pakai lime)
2. **Generous whitespace** - Spacing yang lapang
3. **Flat hierarchy** - Minimal shadows, warna untuk separasi
4. **Clean typography** - Single font family (Inter)
5. **Smooth gradients** - Biru untuk visual depth

Untuk detail lengkap, lihat **DESIGN.md**.
