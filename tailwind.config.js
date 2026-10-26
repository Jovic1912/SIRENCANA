/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/Views/**/*.php",
    "./public/**/*.html",
  ],
  theme: {
    extend: {
      colors: {
        // Sky Blue Gradasi - Inspirasi dari design.md dengan sky blue
        sky: {
          950: '#0c4a6e', // Deep sky - untuk teks penting
          900: '#075985', // Dark sky
          800: '#0369a1', // Sky blue solid
          700: '#0284c7', // Medium sky
          600: '#0ea5e9', // Sky cerah (primary)
          500: '#38bdf8', // Light sky
          400: '#7dd3fc', // Soft sky
          300: '#bae6fd', // Pale sky
          200: '#e0f2fe', // Almost white sky
          100: '#f0f9ff', // Very light sky bg
          50: '#f8fcff',  // Near white
        },
        // Amber untuk primary button - mengikuti design.md button style
        amber: {
          950: '#451a03', // Text on amber
          900: '#78350f',
          800: '#92400e',
          700: '#b45309',
          600: '#d97706', // Amber medium
          500: '#f59e0b', // Amber cerah (primary button)
          400: '#fbbf24', // Amber light
          300: '#fcd34d',
          200: '#fde68a',
          100: '#fef3c7',
          50: '#fffbeb',
        },
        // Neutral warm - untuk teks dan surface (mengikuti design.md)
        neutral: {
          950: '#0a0a0a', // Almost black (seperti #14140f di design.md)
          900: '#171717',
          800: '#262626',
          700: '#404040',
          600: '#525252',
          500: '#737373',
          400: '#a3a3a3',
          300: '#d4d4d4',
          200: '#e5e5e5',
          100: '#f5f5f5',
          50: '#fafafa',
        },
        // Status colors
        success: '#10b981',
        danger: '#ef4444',
        warning: '#f59e0b',
        info: '#0ea5e9',
      },
      fontFamily: {
        // Mengikuti design.md: OTSono → Inter → system
        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'sans-serif'],
        serif: ['"Source Serif 4"', 'Georgia', 'serif'],
        mono: ['ui-monospace', 'monospace'],
      },
      fontSize: {
        // Type scale dari design.md
        'eyebrow': ['10px', { lineHeight: '1.4', letterSpacing: '0.1em' }],
        'caption': ['12px', { lineHeight: '1.33', letterSpacing: '0.05em' }],
        'body-sm': ['14px', { lineHeight: '1.29' }],
        'body': ['16px', { lineHeight: '1.5' }],
        'subheading': ['22px', { lineHeight: '1.18' }],
        'heading': ['28px', { lineHeight: '1.14', letterSpacing: '-0.02em' }],
        'heading-lg': ['60px', { lineHeight: '1', letterSpacing: '-0.03em' }],
        'display': ['90px', { lineHeight: '0.89', letterSpacing: '-0.03em' }],
      },
      borderRadius: {
        // Border radius dari design.md
        'card': '28px',
        'button': '28px',
        'pill': '9999px',
        'input': '8px',
        'inner': '18px',
      },
      spacing: {
        // Spacing scale dari design.md (base 4px)
        '4': '4px',
        '8': '8px',
        '12': '12px',
        '16': '16px',
        '20': '20px',
        '24': '24px',
        '32': '32px',
        '40': '40px',
        '60': '60px',
        '64': '64px',
        '72': '72px',
        '80': '80px',
        '96': '96px',
        '120': '120px',
      },
      letterSpacing: {
        'tight-display': '-0.03em',
        'tight-heading': '-0.02em',
        'caps': '0.1em',
      },
    },
  },
  plugins: [],
}
