<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'SIRENCANA') ?> — SIRENCANA</title>

<!-- Inter Font - sesuai design.md -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Source+Serif+4:opsz,wght@8..60,600&display=swap" rel="stylesheet">

<!-- Tailwind CSS Output -->
<link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>">
</head>
<body class="bg-gradient-to-br from-sky-50 via-white to-neutral-50 text-neutral-950">

<div class="flex min-h-screen">
  <!-- Sidebar - sky blue gradient, flat design per design.md -->
  <aside class="sidebar w-64 flex-shrink-0 sticky top-0 h-screen overflow-y-auto border-r border-sky-700/20">
    
    <!-- Brand Header -->
    <div class="px-6 py-6 border-b border-white/10">
      <div class="brand-header">SIRENCANA</div>
      <div class="brand-subtitle">Sistem Perancangan &amp; Penjaminan Mutu Pembelajaran OBE</div>
    </div>
    
    <!-- Navigation -->
    <nav class="px-3 py-6 space-y-1">
      <?php $u = uri_string(); $on = static fn (string $p) => str_starts_with($u, $p) ? 'active' : ''; ?>
      
      <a href="<?= site_url('/') ?>" class="sidebar-link <?= $u === '' ? 'active' : '' ?>">
        <span>📊</span> Dasbor
      </a>

      <?php if (has_role('admin', 'kaprodi')): ?>
        <div class="eyebrow-label px-4 pt-6 pb-2 text-white/50">
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

      <div class="eyebrow-label px-4 pt-6 pb-2 text-white/50">
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

      <div class="eyebrow-label px-4 pt-6 pb-2 text-white/50">
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
        <div class="eyebrow-label px-4 pt-6 pb-2 text-white/50">
          Administrasi
        </div>
        <a href="<?= site_url('users') ?>" class="sidebar-link <?= $on('users') ?>">
          <span>👥</span> Pengguna
        </a>
      <?php endif; ?>
    </nav>
    
    <!-- Sidebar Footer -->
    <div class="mt-auto px-6 py-5 border-t border-white/10 text-sm">
      <div class="font-medium text-white mb-1"><?= esc(user_name()) ?></div>
      <div class="text-white/60 text-caption mb-4"><?= esc(role_label(session()->get('role'))) ?></div>
      
      <a href="<?= site_url('ganti-password') ?>" 
         class="block text-white/80 hover:text-white text-caption mb-3 transition-colors">
        🔐 Ganti password
      </a>
      
      <form method="post" action="<?= site_url('logout') ?>">
        <?= csrf_field() ?>
        <button type="submit" 
                class="text-amber-300 hover:text-amber-200 text-caption font-medium transition-colors">
          🚪 Keluar
        </button>
      </form>
    </div>
  </aside>
  
  <!-- Main Content -->
  <main class="flex-1 min-w-0 px-10 py-8 max-w-7xl">
    
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success">
        <span class="font-medium">✓</span> <?= esc(session()->getFlashdata('success')) ?>
      </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-error">
        <span class="font-medium">✗</span> <?= esc(session()->getFlashdata('error')) ?>
      </div>
    <?php endif; ?>
    
    <!-- Page Content -->
    <?= $this->renderSection('content') ?>
  </main>
</div>

</body>
</html>
