<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'SIRENCANA') ?> — SIRENCANA</title>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,400;8..60,600;8..60,700&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">

<!-- Tailwind CSS Output -->
<link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
</head>
<body class="bg-primary-50 text-primary-950">

<div class="flex min-h-screen">
  <!-- Sidebar dengan gradasi biru dan border emas -->
  <aside class="sidebar w-64 flex-shrink-0 sticky top-0 h-screen overflow-y-auto border-r-4 border-gold">
    
    <!-- Brand Header -->
    <div class="px-6 py-5 border-b border-primary-700">
      <div class="brand-header">SIRENCANA</div>
      <div class="brand-subtitle">Sistem Perancangan &amp; Penjaminan Mutu Pembelajaran OBE</div>
    </div>
    
    <!-- Navigation -->
    <nav class="px-3 py-4 space-y-1">
      <?php $u = uri_string(); $on = static fn (string $p) => str_starts_with($u, $p) ? 'active' : ''; ?>
      
      <a href="<?= site_url('/') ?>" class="sidebar-link <?= $u === '' ? 'active' : '' ?>">
        <span>📊</span> Dasbor
      </a>

      <?php if (has_role('admin', 'kaprodi')): ?>
        <div class="px-4 pt-4 pb-2 text-xs font-semibold text-primary-300 uppercase tracking-wider">
          Data Induk
        </div>
        <a href="<?= site_url('prodi') ?>" class="sidebar-link <?= $on('prodi') ?>">
          <span>🏛️</span> Program Studi
        </a>
        <a href="<?= site_url('dosen') ?>" class="sidebar-link <?= $on('dosen') ?>">
          <span>👨‍🏫</span> Dosen
        </a>
        <a href="<?= site_url('mahasiswa') ?>" class="sidebar-link <?= $on('mahasiswa') ?>">
          <span>👨‍🎓</span> Mahasiswa
        </a>
        <a href="<?= site_url('mata-kuliah') ?>" class="sidebar-link <?= $on('mata-kuliah') ?>">
          <span>📚</span> Mata Kuliah
        </a>
      <?php endif; ?>

      <div class="px-4 pt-4 pb-2 text-xs font-semibold text-primary-300 uppercase tracking-wider">
        Perancangan Pembelajaran
      </div>
      <a href="<?= site_url('kurikulum') ?>" class="sidebar-link <?= $on('kurikulum') ?>">
        <span>📋</span> Kurikulum &amp; CPMK
      </a>
      <a href="<?= site_url('rps') ?>" class="sidebar-link <?= $on('rps') ?>">
        <span>📄</span> RPS &amp; Persetujuan
      </a>
      <?php if (has_role('admin', 'kaprodi', 'dosen')): ?>
        <a href="<?= site_url('kelas') ?>" class="sidebar-link <?= $on('kelas') ?>">
          <span>🎓</span> Kelas &amp; Kontrak
        </a>
      <?php endif; ?>

      <div class="px-4 pt-4 pb-2 text-xs font-semibold text-primary-300 uppercase tracking-wider">
        Pelaksanaan &amp; Pelaporan
      </div>
      <?php if (has_role('admin', 'kaprodi', 'dosen')): ?>
        <a href="<?= site_url('presensi') ?>" class="sidebar-link <?= $on('presensi') ?>">
          <span>✓</span> Presensi &amp; Nilai
        </a>
      <?php endif; ?>
      <a href="<?= site_url('capaian') ?>" class="sidebar-link <?= $on('capaian') ?>">
        <span>📈</span> Capaian CPMK
      </a>
      <a href="<?= site_url('portofolio') ?>" class="sidebar-link <?= $on('portofolio') ?>">
        <span>📁</span> Portofolio MK
      </a>

      <?php if (has_role('admin')): ?>
        <div class="px-4 pt-4 pb-2 text-xs font-semibold text-primary-300 uppercase tracking-wider">
          Administrasi
        </div>
        <a href="<?= site_url('users') ?>" class="sidebar-link <?= $on('users') ?>">
          <span>👥</span> Pengguna
        </a>
      <?php endif; ?>
    </nav>
    
    <!-- Sidebar Footer -->
    <div class="mt-auto px-6 py-4 border-t border-primary-700 text-sm">
      <div class="font-semibold text-white mb-1"><?= esc(user_name()) ?></div>
      <div class="text-primary-300 text-xs mb-3"><?= esc(role_label(session()->get('role'))) ?></div>
      
      <a href="<?= site_url('ganti-password') ?>" 
         class="block text-primary-200 hover:text-white text-xs mb-2 transition-colors">
        🔐 Ganti password
      </a>
      
      <form method="post" action="<?= site_url('logout') ?>">
        <?= csrf_field() ?>
        <button type="submit" 
                class="text-gold hover:text-gold-light text-xs font-semibold transition-colors">
          🚪 Keluar
        </button>
      </form>
    </div>
  </aside>
  
  <!-- Main Content -->
  <main class="flex-1 min-w-0 px-8 py-6 max-w-7xl">
    
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success mb-6">
        ✓ <?= esc(session()->getFlashdata('success')) ?>
      </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-error mb-6">
        ✗ <?= esc(session()->getFlashdata('error')) ?>
      </div>
    <?php endif; ?>
    
    <!-- Page Content -->
    <?= $this->renderSection('content') ?>
  </main>
</div>

</body>
</html>
