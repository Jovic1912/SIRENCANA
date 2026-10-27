<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pagehead">
  <div>
    <h1>Laporan &amp; Dokumen</h1>
    <p>Dokumen disusun otomatis dari data SIRENCANA mengikuti format OBE UMRAH 2026. Buka dokumen, lalu pilih "Cetak / Simpan PDF".</p>
  </div>
</div>

<div class="panel">
  <h2>Silabus &amp; RPS <span class="muted">(per RPS)</span></h2>
  <?php if (empty($rpsAll)): ?>
    <div class="empty">Belum ada RPS yang dapat Anda akses.</div>
  <?php else: ?>
    <div class="tbl-wrap">
      <table class="doc-list">
        <thead><tr><th>Mata Kuliah</th><th>Tahun Akademik</th><th>Pengembang</th><th>Status</th><th>Dokumen</th></tr></thead>
        <tbody>
          <?php foreach ($rpsAll as $r): $m = $mkById[$r['mk_id']] ?? null; ?>
            <tr>
              <td><span class="mono muted"><?= esc($m['kode'] ?? '') ?></span> <?= esc($m['nama'] ?? 'Mata kuliah tidak ditemukan') ?></td>
              <td><?= esc($r['tahun_akademik']) ?></td>
              <td><?= esc($dosenById[$r['pengembang_id']]['nama'] ?? '—') ?></td>
              <td><?= status_badge($r['status']) ?></td>
              <td>
                <a class="btn ghost sm" target="_blank" href="<?= site_url('laporan/silabus/' . $r['id']) ?>">Silabus</a>
                <a class="btn ghost sm" target="_blank" href="<?= site_url('laporan/rps/' . $r['id']) ?>">RPS</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<div class="panel">
  <h2>Kontrak Kuliah &amp; Portofolio MK <span class="muted">(per kelas)</span></h2>
  <?php if (empty($kelasAll)): ?>
    <div class="empty">Belum ada kelas yang dapat Anda akses.</div>
  <?php else: ?>
    <div class="tbl-wrap">
      <table class="doc-list">
        <thead><tr><th>Mata Kuliah</th><th>Kelas</th><th>Semester</th><th>Dokumen</th></tr></thead>
        <tbody>
          <?php foreach ($kelasAll as $k): $m = $mkById[$k['mk_id']] ?? null; ?>
            <tr>
              <td><span class="mono muted"><?= esc($m['kode'] ?? '') ?></span> <?= $m ? esc($m['nama']) : '<span class="muted">Mata kuliah tidak ditemukan</span>' ?></td>
              <td><?= esc($k['label']) ?></td>
              <td><?= esc(gabung_teks([$k['semester'], $k['tahun_akademik']])) ?></td>
              <td>
                <a class="btn ghost sm" target="_blank" href="<?= site_url('laporan/kontrak/' . $k['id']) ?>">Kontrak Kuliah</a>
                <a class="btn ghost sm" target="_blank" href="<?= site_url('laporan/portofolio/' . $k['id']) ?>">Portofolio MK</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php if (has_role('admin', 'kaprodi', 'gkm', 'gpm')): ?>
  <div class="panel">
    <h2>Laporan EPBM <span class="muted">(per jurusan per semester)</span></h2>
    <?php if (empty($epbmAll)): ?>
      <div class="empty">Belum ada laporan EPBM. <a class="link" href="<?= site_url('epbm') ?>">Buat di menu Laporan EPBM</a>.</div>
    <?php else: ?>
      <table class="doc-list">
        <thead><tr><th>Jurusan</th><th>Semester</th><th>Dokumen</th></tr></thead>
        <tbody>
          <?php foreach ($epbmAll as $e): ?>
            <tr>
              <td><?= esc($e['jurusan']) ?></td>
              <td><?= esc($e['semester'] . ' ' . $e['tahun_akademik']) ?></td>
              <td>
                <a class="btn ghost sm" href="<?= site_url('epbm/' . $e['id']) ?>">Isi / Ubah</a>
                <a class="btn ghost sm" target="_blank" href="<?= site_url('laporan/epbm/' . $e['id']) ?>">Laporan EPBM</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
<?php endif; ?>

<?= $this->endSection() ?>
