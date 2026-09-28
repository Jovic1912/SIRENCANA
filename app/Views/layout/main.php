<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'SIRENCANA') ?> — SIRENCANA</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Source+Serif+4:opsz,wght@8..60,400;8..60,600;8..60,700&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
</head>
<body>
<div id="shell">
  <aside id="sidebar">
    <div id="brand">
      <div class="mark">SIRENCANA</div>
      <div class="sub">Sistem Perancangan &amp; Penjaminan Mutu Pembelajaran OBE</div>
    </div>
    <nav>
      <a href="<?= site_url('/') ?>" class="<?= uri_string() === '' ? 'active' : '' ?>">Dasbor</a>
      <div class="group-label">Data Induk</div>
      <a href="<?= site_url('prodi') ?>" class="<?= str_starts_with(uri_string(),'prodi') ? 'active' : '' ?>">Program Studi</a>
      <a href="<?= site_url('dosen') ?>" class="<?= str_starts_with(uri_string(),'dosen') ? 'active' : '' ?>">Dosen</a>
      <a href="<?= site_url('mahasiswa') ?>" class="<?= str_starts_with(uri_string(),'mahasiswa') ? 'active' : '' ?>">Mahasiswa</a>
      <a href="<?= site_url('mata-kuliah') ?>" class="<?= str_starts_with(uri_string(),'mata-kuliah') ? 'active' : '' ?>">Mata Kuliah</a>
      <div class="group-label">Perancangan Pembelajaran</div>
      <a href="<?= site_url('kurikulum') ?>" class="<?= str_starts_with(uri_string(),'kurikulum') ? 'active' : '' ?>">Kurikulum &amp; CPMK</a>
      <a href="<?= site_url('rps') ?>" class="<?= str_starts_with(uri_string(),'rps') ? 'active' : '' ?>">RPS &amp; Persetujuan</a>
      <a href="<?= site_url('kelas') ?>" class="<?= str_starts_with(uri_string(),'kelas') ? 'active' : '' ?>">Kelas &amp; Kontrak</a>
      <div class="group-label">Pelaksanaan &amp; Pelaporan</div>
      <a href="<?= site_url('presensi') ?>" class="<?= str_starts_with(uri_string(),'presensi') ? 'active' : '' ?>">Presensi &amp; Nilai</a>
      <a href="<?= site_url('capaian') ?>" class="<?= str_starts_with(uri_string(),'capaian') ? 'active' : '' ?>">Capaian CPMK</a>
      <a href="<?= site_url('portofolio') ?>" class="<?= str_starts_with(uri_string(),'portofolio') ? 'active' : '' ?>">Portofolio MK</a>
    </nav>
    <div id="sidebar-foot">CodeIgniter 4 &middot; Database <?= esc(db_connect()->getPlatform()) ?></div>
  </aside>
  <main id="main">
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?= $this->renderSection('content') ?>
  </main>
</div>
</body>
</html>
