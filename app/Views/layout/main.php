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
      <?php $u = uri_string(); $on = static fn (string $p) => str_starts_with($u, $p) ? 'active' : ''; ?>
      <a href="<?= site_url('/') ?>" class="<?= $u === '' ? 'active' : '' ?>">Dasbor</a>

      <?php if (has_role('admin', 'kaprodi')): ?>
        <div class="group-label">Data Induk</div>
        <a href="<?= site_url('prodi') ?>" class="<?= $on('prodi') ?>">Program Studi</a>
        <a href="<?= site_url('dosen') ?>" class="<?= $on('dosen') ?>">Dosen</a>
        <a href="<?= site_url('mahasiswa') ?>" class="<?= $on('mahasiswa') ?>">Mahasiswa</a>
        <a href="<?= site_url('mata-kuliah') ?>" class="<?= $on('mata-kuliah') ?>">Mata Kuliah</a>
      <?php endif; ?>

      <div class="group-label">Perancangan Pembelajaran</div>
      <a href="<?= site_url('kurikulum') ?>" class="<?= $on('kurikulum') ?>">Kurikulum &amp; CPMK</a>
      <a href="<?= site_url('rps') ?>" class="<?= $on('rps') ?>">RPS &amp; Persetujuan</a>
      <?php if (has_role('admin', 'kaprodi', 'dosen')): ?>
        <a href="<?= site_url('kelas') ?>" class="<?= $on('kelas') ?>">Kelas &amp; Kontrak</a>
      <?php endif; ?>

      <div class="group-label">Pelaksanaan &amp; Pelaporan</div>
      <?php if (has_role('admin', 'kaprodi', 'dosen')): ?>
        <a href="<?= site_url('presensi') ?>" class="<?= $on('presensi') ?>">Presensi &amp; Nilai</a>
      <?php endif; ?>
      <a href="<?= site_url('capaian') ?>" class="<?= $on('capaian') ?>">Capaian CPMK</a>
      <a href="<?= site_url('portofolio') ?>" class="<?= $on('portofolio') ?>">Portofolio MK</a>

      <?php if (has_role('admin')): ?>
        <div class="group-label">Administrasi</div>
        <a href="<?= site_url('users') ?>" class="<?= $on('users') ?>">Pengguna</a>
      <?php endif; ?>
    </nav>
    <div id="sidebar-foot">
      <div style="color:#e8e6de;font-weight:600;font-size:.8rem"><?= esc(user_name()) ?></div>
      <div style="margin-bottom:8px"><?= esc(role_label(session()->get('role'))) ?></div>
      <a href="<?= site_url('ganti-password') ?>" style="color:#b9c0d4;font-size:.74rem;text-decoration:none;padding:0">Ganti password</a>
      <form method="post" action="<?= site_url('logout') ?>" style="margin-top:6px"><?= csrf_field() ?>
        <button type="submit" style="background:none;border:none;color:#e0c98a;font:inherit;font-size:.74rem;cursor:pointer;padding:0">Keluar</button>
      </form>
    </div>
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
