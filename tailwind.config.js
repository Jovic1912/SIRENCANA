/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/Views/**/*.php",
    "./public/**/*.html",
  ],
  theme: {
    extend: {
      colors: {
        // Skema Biru - Gradasi dari gelap ke terang
        primary: {
          950: '#000066', // Sangat gelap untuk teks on light
          900: '#0000CC', // Gelap untuk sidebar dark
          800: '#0000FF', // Biru murni - warna utama Anda
          700: '#3333FF', // Hover states
          600: '#6666FF', // Active states
          500: '#8080FF', // Medium untuk backgrounds
          400: '#9999FF', // Light hover
          300: '#B3B3FF', // Borders light
          200: '#CCCCFF', // Background light
          100: '#E6E6FF', // Background very light
          50: '#F5F5FF',  // Almost white bg
        },
        // Emas untuk border dan accent
        gold: {
          DEFAULT: '#FFD700',
          dark: '#E6C200',
          light: '#FFED4E',
          pale: '#FFF8DC',
        },
        // Kuning untuk tombol dan alert
        yellow: {
          DEFAULT: '#FFFF00',
          dark: '#E6E600',
          light: '#FFFF66',
          pale: '#FFFFCC',
        },
        // Status colors (opsional, bisa disesuaikan)
        success: '#10B981',
        danger: '#EF4444',
        warning: '#F59E0B',
        info: '#3B82F6',
      },
      fontFamily: {
        sans: ['"IBM Plex Sans"', 'system-ui', 'sans-serif'],
        serif: ['"Source Serif 4"', 'Georgia', 'serif'],
        mono: ['"IBM Plex Mono"', 'monospace'],
      },
    },
  },
  plugins: [],
}
