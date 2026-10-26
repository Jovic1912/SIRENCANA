# 🎨 SIRENCANA Design System

Design system SIRENCANA dengan skema warna biru langit gradasi ke putih dan aksen button kuning amber, diadaptasi dari filosofi design Perk.

## 📚 Dokumentasi

| File | Deskripsi |
|------|-----------|
| **[DESIGN.md](DESIGN.md)** | 📖 Dokumentasi lengkap design system (tokens, components, guidelines) |
| **[QUICK_START_DESIGN.md](QUICK_START_DESIGN.md)** | 🚀 Quick start guide untuk developer (cheat sheet, examples) |
| **[TESTING_DESIGN.md](TESTING_DESIGN.md)** | 🧪 Panduan testing di localhost (checklist, troubleshooting) |
| **[CHANGELOG_DESIGN.md](CHANGELOG_DESIGN.md)** | 📝 Detail perubahan dari design lama ke baru |
| **[design-preview.html](public/design-preview.html)** | 👁️ Visual preview semua komponen (buka di browser) |

## 🎯 Quick Access

### Visual Preview
```
http://localhost/SIRENCANA/design-preview.html
```

Buka file ini di browser untuk melihat visual reference semua komponen design system.

### Color Palette

```css
/* Primary */
#3b82f6  /* Sky Blue - Sidebar, primary color */
#f59e0b  /* Amber - Button actions */

/* Text */
#1e293b  /* Deep Ink - Primary text */
#64748b  /* Soft Ink - Secondary text */

/* Background */
#ffffff  /* Pure White - Main background */
#f8fafc  /* Surface Gray - Cards */
#eff6ff  /* Sky Tint - Hover states */

/* Status */
#10b981  /* Success */
#f97316  /* Warning */
#ef4444  /* Error */
```

### Common Components

```html
<!-- Button Primary -->
<button class="btn">Simpan</button>

<!-- Button Ghost -->
<button class="btn ghost">Batal</button>

<!-- Badge -->
<span class="badge draft">Draft</span>

<!-- Link -->
<a href="#" class="link">Detail →</a>

<!-- Panel -->
<div class="panel">
  <h2>Title</h2>
  <p>Content...</p>
</div>

<!-- Form Field -->
<div class="field">
  <label>Label</label>
  <input type="text" placeholder="Input...">
</div>

<!-- Alert -->
<div class="alert success">Success message!</div>
```

## 🚀 Getting Started

### 1. Untuk Developer Baru
1. Baca **[QUICK_START_DESIGN.md](QUICK_START_DESIGN.md)** untuk cheat sheet
2. Buka **[design-preview.html](public/design-preview.html)** untuk visual reference
3. Gunakan existing classes dari view files yang ada

### 2. Untuk Testing
1. Ikuti panduan di **[TESTING_DESIGN.md](TESTING_DESIGN.md)**
2. Test di localhost: `http://localhost/SIRENCANA`
3. Hard refresh: `Ctrl + Shift + R` setelah update CSS

### 3. Untuk Design Reference
1. Buka **[DESIGN.md](DESIGN.md)** untuk dokumentasi lengkap
2. Check **[DESIGN_peerk.md](DESIGN_peerk.md)** untuk inspirasi original

## 📁 File Structure

```
SIRENCANA/
├── public/
│   ├── assets/
│   │   └── style.css          # Main CSS file (UPDATED)
│   └── design-preview.html    # Visual preview (NEW)
├── app/
│   └── Views/
│       └── layout/
│           ├── main.php       # Main layout (font updated)
│           └── auth.php       # Auth layout (updated)
├── DESIGN.md                  # Design system docs (NEW)
├── DESIGN_peerk.md            # Perk reference (source)
├── QUICK_START_DESIGN.md      # Quick start guide (NEW)
├── TESTING_DESIGN.md          # Testing guide (NEW)
├── CHANGELOG_DESIGN.md        # Change log (NEW)
└── DESIGN_SYSTEM_README.md    # This file (NEW)
```

## ✨ Key Features

### Design Philosophy (dari Perk)
- ✅ **Single accent color** - Amber untuk semua primary actions
- ✅ **Generous whitespace** - Spacing yang lapang dan breathable
- ✅ **Flat hierarchy** - Minimal shadows, separasi dengan warna
- ✅ **Clean typography** - Single font system (Inter)
- ✅ **Smooth gradients** - Gradasi biru untuk visual depth

### Highlights
- 🎨 **Color scheme:** Biru langit (#3b82f6) + Amber (#f59e0b)
- 📝 **Typography:** Inter single-family system
- 🔘 **Buttons:** Amber primary, blue ghost, smooth hover effects
- 📊 **Stat cards:** Gradient backgrounds dengan hover animations
- 📋 **Forms:** Focus states dengan shadow rings
- 🏷️ **Badges:** Pill shape dengan uppercase text
- ⚠️ **Alerts:** Border-left accent untuk clear hierarchy

## 🎯 Component Categories

### Layout
- Sidebar dengan gradient biru
- Main content area dengan max-width 1200px
- Grid system untuk responsive layouts

### Navigation
- Active states dengan background transparan
- Hover effects smooth
- Sidebar sticky dengan scroll

### Forms
- Input fields dengan focus states
- Checkboxes/radios dengan accent color
- Labels dengan hierarchy jelas

### Data Display
- Tables dengan hover rows
- Stat cards dengan gradients
- Panels dengan borders

### Feedback
- Alerts untuk success/error messages
- Badges untuk status indicators
- Empty states untuk no-data scenarios

### Actions
- Primary buttons (amber)
- Secondary/ghost buttons (blue)
- Icon buttons untuk destructive actions
- Links dengan hover states

## 🔧 Development

### CSS Variables
Semua styling menggunakan CSS custom properties untuk consistency:

```css
:root {
  --color-sky-blue: #3b82f6;
  --color-amber-action: #f59e0b;
  --color-deep-ink: #1e293b;
  --spacing-4: 16px;
  --radius-base: 12px;
  /* ... dan lainnya */
}
```

### Backward Compatibility
Legacy CSS variables tetap ada:
```css
--navy → --color-sky-blue
--teal → --color-sky-blue
--amber → --color-amber-action
```

### Browser Support
- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Modern browsers dengan CSS custom properties

## 📱 Responsive

```css
/* Mobile first approach */
@media (max-width: 900px) {
  /* Sidebar collapse, grid adjustments */
}
```

Breakpoints:
- **520px** - Small phones
- **768px** - Tablets
- **900px** - Sidebar collapse threshold
- **1024px** - Desktop

## ♿ Accessibility

- ✅ Focus states untuk keyboard navigation
- ✅ Color contrast minimal 4.5:1
- ✅ Touch targets minimal 44x44px
- ✅ Semantic HTML
- ✅ Screen reader friendly
- ✅ Reduced motion support

## 🎓 Learning Path

**Level 1: Basic**
1. Review color palette
2. Understand button variants
3. Use existing classes

**Level 2: Intermediate**
1. Form layouts dengan field-row
2. Panel dan card compositions
3. Table styling

**Level 3: Advanced**
1. Custom styling dengan CSS variables
2. Responsive adjustments
3. Utility class combinations

## 🆘 Support & Help

### Quick Help
1. **Visual not loading?** → Hard refresh (Ctrl+Shift+R)
2. **Colors wrong?** → Check CSS variables usage
3. **Layout broken?** → Verify class names

### Resources
- **Examples:** Check existing view files in `app/Views/`
- **Components:** Open `design-preview.html` di browser
- **Troubleshooting:** See `TESTING_DESIGN.md`

### Common Issues

**Issue:** Button tidak styled
```html
<!-- ❌ Wrong -->
<button class="button">Click</button>

<!-- ✅ Correct -->
<button class="btn">Click</button>
```

**Issue:** CSS variable tidak apply
```css
/* ❌ Wrong */
color: --color-sky-blue;

/* ✅ Correct */
color: var(--color-sky-blue);
```

## 📊 Statistics

- **CSS File Size:** ~15KB (with utilities)
- **Color Tokens:** 15 primary colors
- **Component Classes:** 40+ reusable classes
- **Utility Classes:** 50+ helper classes
- **Documentation:** 5 comprehensive guides

## 🎉 What's New

### Version 1.0.0 (2026-10-27)

**New Design System:**
- ✨ Biru langit + amber color scheme
- ✨ Inter typography system
- ✨ Enhanced component styling
- ✨ Improved spacing & layout
- ✨ Better accessibility
- ✨ Comprehensive documentation

**New Files:**
- 📄 5 documentation files
- 🎨 Visual preview page
- 🛠️ Utility classes library
- 📝 Developer guides

**Updated:**
- 💅 Complete CSS redesign
- 🔤 Font system update
- 🎯 Better focus states
- 📱 Improved responsive

## 🚀 Next Steps

1. **Test locally:** Follow `TESTING_DESIGN.md`
2. **Learn components:** Review `QUICK_START_DESIGN.md`
3. **Build features:** Use existing patterns
4. **Give feedback:** Report issues atau suggestions

## 📞 Contact

Untuk pertanyaan atau issue terkait design system:
- Check documentation files terlebih dahulu
- Review `design-preview.html` untuk visual reference
- Lihat existing view files untuk examples

---

**Design System Version:** 1.0.0  
**Based on:** Perk design philosophy  
**Updated:** 27 Oktober 2026  
**License:** Internal use - SIRENCANA Project

**Happy Designing! 🎨✨**
