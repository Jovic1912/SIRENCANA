<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'SIRENCANA') ?> — SIRENCANA</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,400;8..60,600;8..60,700&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">
<!-- Tailwind CSS dengan skema biru, emas, kuning -->
<link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
</head>
<body class="bg-primary-50 text-primary-950">
<div class="flex min-h-screen">
  <!-- Sidebar dengan gradasi biru dan border kuning gelap -->
  <aside class="sidebar w-64 flex-shrink-0 sticky top-0 h-screen overflow-y-auto border-r-2 border-yellow-dark">
    <div class="px-6 py-5 border-b border-primary-800">
      <div class="brand-header">SIRENCANA</div>
      <div class="brand-subtitle">Sistem Perancangan &amp; Penjaminan Mutu Pembelajaran OBE</div>
    </div>
    <nav class="px-3 py-4 space-y-1">
      <?php $u = uri_string(); $on = static fn (string $p) => str_starts_with($u, $p) ? 'active' : ''; ?>
      <a href="<?= site_url('/') ?>" class="sidebar-link <?= $u === '' ? 'active' : '' ?>">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        <span>Dasbor</span>
      </a>

      <?php if (has_role('admin', 'kaprodi')): ?>
        <div class="px-4 pt-4 pb-2 text-xs font-semibold text-primary-400 uppercase tracking-wider">Data Induk</div>
        <a href="<?= site_url('prodi') ?>" class="sidebar-link <?= $on('prodi') ?>">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
          <span>Program Studi</span>
        </a>
        <a href="<?= site_url('dosen') ?>" class="sidebar-link <?= $on('dosen') ?>">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
          <span>Dosen</span>
        </a>
        <a href="<?= site_url('mahasiswa') ?>" class="sidebar-link <?= $on('mahasiswa') ?>">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
          <span>Mahasiswa</span>
        </a>
        <a href="<?= site_url('mata-kuliah') ?>" class="sidebar-link <?= $on('mata-kuliah') ?>">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          <span>Mata Kuliah</span>
        </a>
      <?php endif; ?>

      <div class="px-4 pt-4 pb-2 text-xs font-semibold text-primary-400 uppercase tracking-wider">Perancangan Pembelajaran</div>
      <a href="<?= site_url('kurikulum') ?>" class="sidebar-link <?= $on('kurikulum') ?>">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
        <span>Kurikulum &amp; CPMK</span>
      </a>
      <a href="<?= site_url('rps') ?>" class="sidebar-link <?= $on('rps') ?>">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <span>RPS &amp; Persetujuan</span>
      </a>
      <?php if (has_role('admin', 'kaprodi', 'dosen')): ?>
        <a href="<?= site_url('kelas') ?>" class="sidebar-link <?= $on('kelas') ?>">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
          <span>Kelas &amp; Kontrak</span>
        </a>
      <?php endif; ?>

      <div class="px-4 pt-4 pb-2 text-xs font-semibold text-primary-400 uppercase tracking-wider">Pelaksanaan &amp; Pelaporan</div>
      <?php if (has_role('admin', 'kaprodi', 'dosen')): ?>
        <a href="<?= site_url('presensi') ?>" class="sidebar-link <?= $on('presensi') ?>">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
          <span>Presensi &amp; Nilai</span>
        </a>
      <?php endif; ?>
      <a href="<?= site_url('capaian') ?>" class="sidebar-link <?= $on('capaian') ?>">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        <span>Capaian CPMK</span>
      </a>
      <a href="<?= site_url('portofolio') ?>" class="sidebar-link <?= $on('portofolio') ?>">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
        <span>Portofolio MK</span>
      </a>

      <?php if (has_role('admin')): ?>
        <div class="px-4 pt-4 pb-2 text-xs font-semibold text-primary-400 uppercase tracking-wider">Administrasi</div>
        <a href="<?= site_url('users') ?>" class="sidebar-link <?= $on('users') ?>">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
          <span>Pengguna</span>
        </a>
      <?php endif; ?>
    </nav>
    
    <!-- Sidebar Footer -->
    <div class="mt-auto px-6 py-4 border-t border-primary-800 text-sm">
      <div class="font-semibold text-white mb-1"><?= esc(user_name()) ?></div>
      <div class="text-primary-400 text-xs mb-3"><?= esc(role_label(session()->get('role'))) ?></div>
      <a href="<?= site_url('ganti-password') ?>" class="flex items-center gap-2 text-primary-300 hover:text-yellow-dark text-xs mb-2 transition-colors">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
        <span>Ganti Password</span>
      </a>
      <form method="post" action="<?= site_url('logout') ?>">
        <?= csrf_field() ?>
        <button type="submit" class="flex items-center gap-2 text-yellow-dark hover:text-yellow text-xs font-semibold transition-colors">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
          <span>Keluar</span>
        </button>
      </form>
    </div>
  </aside>
  
  <!-- Main Content -->
  <main class="flex-1 min-w-0 px-8 py-6 max-w-7xl">
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success mb-6">
        <?= esc(session()->getFlashdata('success')) ?>
      </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-error mb-6">
        <?= esc(session()->getFlashdata('error')) ?>
      </div>
    <?php endif; ?>
    <?= $this->renderSection('content') ?>
  </main>
</div>
</body>
</html>
