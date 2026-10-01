# SIRENCANA — Sistem Perancangan & Penjaminan Mutu Pembelajaran OBE

Aplikasi CodeIgniter 4 untuk mengelola siklus perancangan pembelajaran OBE:
Data Induk → Kurikulum & CPMK → RPS & Persetujuan → Kelas & Kontrak Kuliah →
Presensi & Nilai → Capaian CPMK (Laporan OBE) → Portofolio Mata Kuliah.

Proyek ini memakai **CodeIgniter 4.6.3** (kompatibel PHP 8.1 – 8.4) dan sudah menyertakan **inti framework (folder `system/`)**,
jadi **tidak perlu `composer install`** untuk menjalankannya.

## Menjalankan di komputer lokal (paling cepat)

1. Pastikan **PHP 8.1+** terpasang (cek dengan `php -v`). Ekstensi yang
   diperlukan: `sqlite3`, `mbstring`, `intl`, `curl`, `xml` — umumnya sudah
   aktif di instalasi PHP standar/XAMPP/Laragon.
2. Buka folder proyek ini di terminal, lalu jalankan migrasi database
   (otomatis membuat file `writable/sirencana.db` berisi seluruh tabel):
   ```
   php spark migrate --all
   ```
3. Jalankan server bawaan:
   ```
   php spark serve
   ```
4. Buka **http://localhost:8080** di browser.

Database default memakai **SQLite** (satu file, tanpa perlu instal server
database terpisah) — cocok untuk mencoba aplikasi ini langsung dari VS Code.

## Menjalankan di VS Code

1. Buka folder ini (`File → Open Folder…`).
2. Buka terminal terintegrasi (`` Ctrl+` ``), lalu ikuti langkah 2–3 di atas.
3. Disarankan memasang extension **PHP Intelephense** untuk auto-complete.
4. Jika memakai extension **PHP Server** / **Live Server**, tetap gunakan
   `php spark serve` (bukan Live Server biasa) karena aplikasi ini butuh
   routing & PHP backend CodeIgniter, bukan file statis.

## Beralih ke MySQL/MariaDB (XAMPP/Laragon)

Buka file `.env`, lalu:
1. Beri tanda pagar (`#`) pada 3 baris blok **SQLite**.
2. Hapus tanda pagar pada blok **MySQL/MariaDB**, sesuaikan nama database,
   username, dan password.
3. Buat database kosong (mis. `db_sirencana`) lewat phpMyAdmin/HeidiSQL.
4. Jalankan ulang `php spark migrate --all`.

## Struktur Modul

| Folder                         | Isi                                                   |
|---------------------------------|--------------------------------------------------------|
| `app/Database/Migrations/`      | Skema 17 tabel (prodi, mk, cpl, cpmk, rps, kelas, dst.) |
| `app/Models/`                   | 19 Model (satu per tabel)                              |
| `app/Controllers/`              | Dashboard, ProdiController, DosenController, MahasiswaController, MataKuliahController, KurikulumController, RpsController, KelasController, PresensiController, CapaianController, PortofolioController |
| `app/Views/`                    | Tampilan tiap modul + `layout/main.php` (sidebar & tema) |
| `app/Helpers/obe_helper.php`    | Fungsi kalkulasi: nilai akhir, huruf mutu, rekap presensi, capaian CPMK |
| `public/assets/style.css`       | Tema visual (navy sidebar, serif+sans, badge status)    |

## Alur pemakaian singkat

1. **Data Induk** → isi Program Studi, Dosen, Mahasiswa, Mata Kuliah
   (kategori Universitas/Fakultas/Prodi, sifat Wajib/Pilihan, SKS, semester).
2. **Kurikulum & CPMK** → pilih prodi, susun CPL, pilih MK, susun CPMK +
   matriks bobot CPMK→CPL.
3. **RPS & Persetujuan** → buat draf RPS dari sebuah MK (16 pertemuan &
   jenis penilaian ter-generate otomatis), isi rancangan pertemuan, bobot
   penilaian, dan matriks penilaian×CPMK, lalu jalankan alur:
   **Draf → Diajukan → (Revisi ↔ Diajukan ulang) → Disetujui GKM →
   Tanda Tangan Dosen & Kaprodi → Diserahkan GPM & Diarsipkan.**
4. **Kelas & Kontrak** → buka kelas dari RPS yang sudah **Diarsipkan**,
   lengkapi kontrak kuliah, tambahkan peserta.
5. **Presensi & Nilai** → input kehadiran per pertemuan dan nilai mentah
   per jenis penilaian.
6. **Capaian CPMK** & **Portofolio MK** → dihitung otomatis dari data di
   atas — tidak perlu input manual.

## Catatan keamanan (untuk pemakaian bersama/produksi)

Proyek ini dikonfigurasi untuk kemudahan uji coba lokal:
- `CI_ENVIRONMENT` di `.env` diset ke `development`.
- Proteksi CSRF global belum diaktifkan (baris `'csrf'` di
  `app/Config/Filters.php` masih dikomentari) agar form langsung berfungsi
  tanpa konfigurasi tambahan.
- Belum ada sistem login/otoritas pengguna — semua aksi (termasuk aksi GKM,
  tanda tangan Dosen/Kaprodi) dapat diakses siapa pun yang membuka aplikasi.

Sebelum dipakai lintas-pengguna sungguhan (bukan sekadar demo lokal),
tambahkan: autentikasi pengguna + peran (Dosen/GKM/Kaprodi/GPM/Admin Prodi),
aktifkan kembali proteksi CSRF, dan ubah `CI_ENVIRONMENT` ke `production`.


## Catatan untuk WAMP/XAMPP (Apache)

Jika aplikasi dibuka lewat Apache (mis. `http://localhost/SIRENCANA/public/`),
ubah `app.baseURL` di file `.env` agar sesuai alamat tersebut, contoh:

    app.baseURL = 'http://localhost/SIRENCANA/public/'

Bila memakai `php spark serve`, biarkan `http://localhost:8080/`.


## Login & Peran Pengguna

Sistem ini memakai autentikasi berbasis username/password dengan lima peran:
**Administrator, Dosen, GKM, Kaprodi, GPM.** Setiap peran punya menu dan
kewenangan berbeda mengikuti alur persetujuan RPS (lihat halaman Pengguna
di dalam aplikasi untuk penjelasan lengkap tiap peran).

### Membuat akun administrator pertama kali

Setelah migrasi (`php spark migrate --all`), jalankan:
```
php spark db:seed UserSeeder
```
Perintah ini menampilkan **username `admin` dan password acak satu kali** di
terminal. Catat password itu — Anda akan diminta menggantinya saat login
pertama. Setelah login, buat akun Dosen/GKM/Kaprodi/GPM lainnya lewat menu
**Pengguna** (khusus Administrator), masing-masing dengan password awal yang
wajib diganti sendiri oleh pemiliknya saat pertama login.

Akun **Dosen** dan **Kaprodi** harus ditautkan ke data Dosen (menu Data Induk
→ Dosen) agar sistem tahu RPS dan kelas mana yang menjadi tanggung jawab
mereka.

### Akun demo (opsional, hanya untuk uji coba lokal)

```
php spark db:seed UserDemoSeeder
```
Membuat 4 akun contoh (`dosen1`, `kaprodi1`, `gkm1`, `gpm1`, semua dengan
password `demo12345`) untuk mencoba alur kerja lintas-peran dengan cepat.
**Jangan pernah menjalankan seeder ini di server yang dipakai sungguhan** —
hapus akun-akun ini atau ganti passwordnya sebelum dipakai bersama.

### Ringkasan kewenangan

| Peran | Dapat melakukan |
|---|---|
| Administrator | Kelola Data Induk, Pengguna, Kurikulum; tidak dapat menyetujui/menandatangani RPS |
| Dosen | Menyusun & mengajukan RPS miliknya; mengelola kelas, presensi, nilai, portofolio yang diampunya |
| GKM | Menyetujui atau meminta revisi RPS yang diajukan |
| Kaprodi | Menandatangani RPS, mengelola CPL/CPMK & mata kuliah, membuka kelas, mengarsipkan RPS |
| GPM | Mengarsipkan RPS yang sudah ditandatangani, memantau capaian & portofolio |

Proteksi CSRF kini aktif untuk seluruh form. Jalankan
`php spark migrate --all` setelah menarik pembaruan ini agar tabel `users`
ikut terbuat.
