# SIRENCANA — Style Reference
> biru langit gradasi putih dengan aksen amber cerah

**Theme:** light dengan gradasi biru

Sistem perancangan dan penjaminan mutu pembelajaran OBE dengan visual yang bersih dan profesional. SIRENCANA menggunakan gradasi biru langit (#3b82f6 → #93c5fd → #ffffff) sebagai fondasi visual yang menenangkan, dikombinasikan dengan amber gelap (#f59e0b) sebagai aksen aksi utama. Typography menggunakan single-family system dengan OTSono untuk semua elemen, menciptakan hierarki yang jelas namun tetap kohesif.

## Tokens — Colors

| Name | Value | Token | Role |
|------|-------|-------|------|
| Sky Blue | `#3b82f6` | `--color-sky-blue` | Background utama sidebar, hero sections, primary surface — warna dominan sistem |
| Light Sky | `#93c5fd` | `--color-light-sky` | Background sekunder, hover states, subtle accents |
| Pale Sky | `#dbeafe` | `--color-pale-sky` | Background card, panel surface, soft contrast zones |
| Pure White | `#ffffff` | `--color-pure-white` | Highest surface, main content background, text on dark backgrounds |
| Amber Action | `#f59e0b` | `--color-amber-action` | Primary action buttons, CTA, important highlights — singular action color |
| Amber Dark | `#d97706` | `--color-amber-dark` | Button hover, active states, emphasis moments |
| Deep Ink | `#1e293b` | `--color-deep-ink` | Primary text, headings, body copy on light backgrounds |
| Soft Ink | `#64748b` | `--color-soft-ink` | Secondary text, muted copy, labels |
| Border Gray | `#e2e8f0` | `--color-border-gray` | Dividers, borders, subtle structural lines |
| Surface Gray | `#f8fafc` | `--color-surface-gray` | Alternative card background, subtle elevation |
| Success Green | `#10b981` | `--color-success-green` | Success messages, positive indicators |
| Success Soft | `#d1fae5` | `--color-success-soft` | Success background tints |
| Warning Orange | `#f97316` | `--color-warning-orange` | Warning messages, attention indicators |
| Warning Soft | `#fed7aa` | `--color-warning-soft` | Warning background tints |
| Error Red | `#ef4444` | `--color-error-red` | Error messages, negative indicators |
| Error Soft | `#fee2e2` | `--color-error-soft` | Error background tints |

## Tokens — Typography

### OTSono — Single-family system covering everything from 90px display headlines down to 10px micro-labels. · `--font-otsono`
- **Substitute:** Inter, IBM Plex Sans, system-ui sans-serif
- **Weights:** 400, 500, 600, 700
- **Sizes:** 10, 11, 12, 13, 14, 15, 16, 18, 20, 22, 24, 28, 32, 40, 48, 60
- **Line height:** 1.2–1.6
- **Letter spacing:** -0.02em at 28px and above, normal at body sizes, 0.06em on uppercase labels
- **Role:** Weight 400 untuk body text, 500 untuk emphasis, 600 untuk headings, 700 untuk display headlines. Tracking yang ketat pada display sizes menciptakan presence yang kuat.

### Type Scale

| Role | Size | Weight | Line Height | Letter Spacing | Token |
|------|------|--------|-------------|----------------|-------|
| micro | 10px | 500 | 1.4 | 0.6px | `--text-micro` |
| caption | 12px | 500 | 1.4 | 0.72px | `--text-caption` |
| small | 13px | 400 | 1.5 | — | `--text-small` |
| body | 15px | 400 | 1.6 | — | `--text-body` |
| body-emphasis | 15px | 500 | 1.6 | — | `--text-body-emphasis` |
| lead | 16px | 400 | 1.6 | — | `--text-lead` |
| subheading | 18px | 600 | 1.4 | — | `--text-subheading` |
| heading | 22px | 600 | 1.3 | -0.22px | `--text-heading` |
| heading-lg | 28px | 600 | 1.2 | -0.56px | `--text-heading-lg` |
| display | 40px | 700 | 1.1 | -0.8px | `--text-display` |
| display-xl | 60px | 700 | 1 | -1.2px | `--text-display-xl` |

## Tokens — Spacing & Shapes

**Base unit:** 4px

**Density:** comfortable to spacious

### Spacing Scale

| Name | Value | Token |
|------|-------|-------|
| 1 | 4px | `--spacing-1` |
| 2 | 8px | `--spacing-2` |
| 3 | 12px | `--spacing-3` |
| 4 | 16px | `--spacing-4` |
| 5 | 20px | `--spacing-5` |
| 6 | 24px | `--spacing-6` |
| 7 | 28px | `--spacing-7` |
| 8 | 32px | `--spacing-8` |
| 10 | 40px | `--spacing-10` |
| 12 | 48px | `--spacing-12` |
| 14 | 56px | `--spacing-14` |
| 16 | 64px | `--spacing-16` |
| 20 | 80px | `--spacing-20` |
| 24 | 96px | `--spacing-24` |

### Border Radius

| Element | Value | Token |
|---------|-------|-------|
| small | 6px | `--radius-sm` |
| base | 12px | `--radius-base` |
| large | 16px | `--radius-lg` |
| xlarge | 20px | `--radius-xl` |
| pill | 9999px | `--radius-pill` |
| button | 12px | `--radius-button` |
| card | 16px | `--radius-card` |
| panel | 16px | `--radius-panel` |

### Layout

- **Page max-width:** 1200px
- **Sidebar width:** 260px
- **Section gap:** 32-48px
- **Card padding:** 20-32px
- **Content padding:** 32-48px

## Components

### Primary Action Button (Amber)
**Role:** Filled CTA untuk aksi utama

Background #f59e0b, text #ffffff, radius 12px, padding 10px 20px. Weight 600, 15px. Hover: background #d97706. Shadow ringan untuk lift. Ini adalah satu-satunya filled button dengan warna — amber melawan biru menciptakan focal point yang jelas.

```html
<button class="btn-primary">Simpan Dokumen</button>
```

### Secondary Button (Outline)
**Role:** Aksi sekunder, alternatif action

Background transparent, text #3b82f6, border 1.5px solid #3b82f6, radius 12px, padding 10px 20px. Weight 600, 15px. Hover: background #eff6ff.

```html
<button class="btn-secondary">Batal</button>
```

### Ghost Button
**Role:** Tertiary actions, navigation links

Background transparent, text #64748b, no border, radius 12px, padding 8px 16px. Weight 500, 14px. Hover: background #f8fafc, text #1e293b.

```html
<button class="btn-ghost">Lihat Detail</button>
```

### Card Component
**Role:** Content container, data display

Background #ffffff, border 1px solid #e2e8f0, radius 16px, padding 24px. No shadow di default state. Hover: border color #93c5fd.

```html
<div class="card">
  <h3 class="card-title">Judul Card</h3>
  <p class="card-body">Konten card...</p>
</div>
```

### Panel Component
**Role:** Sectioned content, grouped data

Background #dbeafe, border none, radius 16px, padding 28px. Digunakan untuk mengelompokkan informasi terkait dengan visual distinction dari background putih.

```html
<div class="panel">
  <h2 class="panel-title">Statistik</h2>
  <div class="panel-content">...</div>
</div>
```

### Stat Card
**Role:** Numeric display, KPI showcase

Background white atau gradient biru muda, large numeric display (40px, weight 700), label text (13px, weight 500, color soft-ink). Minimal chrome.

```html
<div class="stat-card">
  <div class="stat-value">42</div>
  <div class="stat-label">Dokumen RPS</div>
</div>
```

### Badge/Tag
**Role:** Status indicator, category label

Inline-block, padding 4px 12px, radius pill, text 11px weight 600 uppercase, letter-spacing 0.6px. Color scheme by status (success, warning, error, neutral).

```html
<span class="badge badge-success">Disetujui</span>
<span class="badge badge-warning">Revisi</span>
```

### Input Field
**Role:** Form input

Background #ffffff, text #1e293b, border 1.5px solid #e2e8f0, radius 8px, padding 10px 14px. Font 15px weight 400. Focus: border #3b82f6, outline ring 3px #dbeafe.

```html
<input type="text" class="input" placeholder="Masukkan teks...">
```

### Sidebar Navigation
**Role:** Main navigation structure

Background gradient dari #3b82f6 ke #2563eb (top to bottom), fixed width 260px, text #ffffff. Active state: background rgba(255,255,255,0.15), weight 600. Hover: background rgba(255,255,255,0.08).

```html
<nav class="sidebar-nav">
  <a href="#" class="nav-item active">Dashboard</a>
  <a href="#" class="nav-item">RPS</a>
</nav>
```

### Table
**Role:** Data presentation

Background white, border collapse, header row background #f8fafc, text 13px. Row borders 1px solid #e2e8f0. Hover row: background #f8fafc.

```html
<table class="data-table">
  <thead>
    <tr><th>Kolom 1</th><th>Kolom 2</th></tr>
  </thead>
  <tbody>
    <tr><td>Data 1</td><td>Data 2</td></tr>
  </tbody>
</table>
```

### Alert/Flash Message
**Role:** User feedback, notifications

Padding 14px 18px, radius 12px, border-left 4px solid (accent color), background tinted. Icon + text layout, 14px weight 500.

```html
<div class="alert alert-success">Perubahan berhasil disimpan!</div>
<div class="alert alert-error">Terjadi kesalahan, coba lagi.</div>
```

## Do's and Don'ts

### Do
- Gunakan amber (#f59e0b) HANYA untuk primary action buttons — jangan tambahkan warna aksi kedua
- Set border-radius ke 16px untuk cards, 12px untuk buttons, 8px untuk inputs
- Gunakan weight 400 untuk body, 500 untuk emphasis, 600 untuk headings, 700 untuk display
- Buat gradasi biru yang smooth: #3b82f6 → #93c5fd → #dbeafe → #ffffff
- Gunakan white space yang generous — section gap 32-48px minimum
- Terapkan letter-spacing negatif (-0.02em) pada heading 28px ke atas
- Gunakan uppercase + letter-spacing 0.06em untuk micro labels (10-12px)
- Pastikan contrast ratio minimal 4.5:1 untuk text

### Don't
- Jangan gunakan box-shadow yang berat — sistem ini bergantung pada border dan warna
- Jangan gunakan pure black (#000000) untuk text — gunakan #1e293b
- Jangan tambahkan warna aksen baru (merah, hijau, ungu) untuk button actions
- Jangan mix border-radius dalam satu komponen type
- Jangan gunakan weight 800 atau 900 — max 700 untuk display
- Jangan letakkan amber button langsung pada background biru gelap tanpa padding cukup
- Jangan gunakan gradients pada buttons — solid color only
- Jangan pakai multiple fonts — OTSono/Inter system saja

## Surfaces & Elevation

| Level | Name | Background | Purpose |
|-------|------|------------|---------|
| 0 | Base Canvas | `#ffffff` | Main page background |
| 1 | Sidebar | `linear-gradient(#3b82f6, #2563eb)` | Navigation structure |
| 2 | Card Surface | `#ffffff` with border | Content containers |
| 3 | Panel Surface | `#dbeafe` | Grouped content sections |
| 4 | Hover State | `#f8fafc` | Interactive feedback |

Sistem tidak menggunakan drop shadows yang signifikan. Elevation dikomunikasikan melalui border, warna background, dan subtle color shifts. Ini menjaga desain tetap flat, clean, dan modern.

## Layout Patterns

### Dashboard Layout
- Sidebar fixed 260px kiri dengan gradient biru
- Main content area dengan max-width 1200px
- Stat cards grid (auto-fit, minmax(180px, 1fr))
- Panel sections dengan spacing 32px vertikal
- Responsive: sidebar collapse ke hamburger menu pada <768px

### Form Layout
- Single column dengan max-width 640px
- Label di atas input (block)
- Field spacing 16px vertikal
- Action buttons kanan-aligned
- Multi-column grid untuk related fields (2-3 cols)

### Data Table Layout
- Full-width dalam container
- Sticky header pada scroll
- Action column kanan-aligned
- Responsive: horizontal scroll pada small screens dengan minimum column widths

## Responsive Breakpoints

| Name | Min Width | Usage |
|------|-----------|-------|
| mobile | — | Base styles |
| tablet | 768px | 2-column layouts begin |
| desktop | 1024px | Sidebar visible, multi-column grids |
| wide | 1280px | Max content width applied |

## Accessibility

- Semua interactive elements memiliki focus state yang jelas (outline ring)
- Color contrast minimal 4.5:1 untuk normal text, 3:1 untuk large text
- Button dan link memiliki minimum touch target 44x44px
- Form inputs memiliki label yang jelas dan accessible
- Semantic HTML (nav, main, article, section) untuk screen readers
- Skip-to-content link untuk keyboard navigation
- ARIA labels untuk icon-only buttons

## Design Tokens Usage

```css
/* Primary Action Button */
.btn-primary {
  background: var(--color-amber-action);
  color: var(--color-pure-white);
  border-radius: var(--radius-button);
  padding: var(--spacing-2) var(--spacing-5);
  font-size: var(--text-body);
  font-weight: 600;
}

/* Card Component */
.card {
  background: var(--color-pure-white);
  border: 1px solid var(--color-border-gray);
  border-radius: var(--radius-card);
  padding: var(--spacing-6);
}

/* Heading */
.heading {
  font-size: var(--text-heading);
  font-weight: 600;
  color: var(--color-deep-ink);
  letter-spacing: -0.22px;
  line-height: 1.3;
}
```

## Color Palette Extended

### Blues (Primary)
- Sky Blue: `#3b82f6`
- Sky 600: `#2563eb`
- Sky 500: `#0ea5e9`
- Light Sky: `#93c5fd`
- Pale Sky: `#dbeafe`
- Sky Tint: `#eff6ff`

### Ambers (Action)
- Amber Action: `#f59e0b`
- Amber Dark: `#d97706`
- Amber 600: `#ca8a04`

### Neutrals
- Deep Ink: `#1e293b`
- Soft Ink: `#64748b`
- Border Gray: `#e2e8f0`
- Surface Gray: `#f8fafc`
- Pure White: `#ffffff`

### Status Colors
- Success: `#10b981` / soft `#d1fae5`
- Warning: `#f97316` / soft `#fed7aa`
- Error: `#ef4444` / soft `#fee2e2`
- Info: `#3b82f6` / soft `#dbeafe`

## Animation & Transitions

- Default transition: `all 200ms cubic-bezier(0.4, 0, 0.2, 1)`
- Hover states: 150ms ease
- Page transitions: 300ms ease-out
- Micro-interactions (checkbox, toggle): 200ms ease

```css
.btn-primary {
  transition: background-color 200ms cubic-bezier(0.4, 0, 0.2, 1);
}

.card {
  transition: border-color 200ms ease, transform 200ms ease;
}
```

---

**Design System Version:** 1.0.0  
**Last Updated:** 2026-10-27  
**Based on:** Perk design philosophy — single accent, clean typography, generous whitespace
