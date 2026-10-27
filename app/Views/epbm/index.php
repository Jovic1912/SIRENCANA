<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pagehead">
  <div>
    <h1>Laporan EPBM</h1>
    <p>Evaluasi Proses Belajar Mengajar per jurusan per semester, disusun oleh Gugus Kendali Mutu (GKM). Data kelas, nilai, kehadiran, dan capaian CPMK direkap otomatis.</p>
  </div>
</div>

<?php if ($canEdit): ?>
  <div class="panel">
    <h2>Buat Laporan Baru</h2>
    <form method="post" action="<?= site_url('epbm/store') ?>">
      <?= csrf_field() ?>
      <div class="field-row">
        <div class="field">
          <label>Fakultas</label>
          <input type="text" name="fakultas" list="daftar-fakultas" required value="<?= esc($fakultas[0] ?? '') ?>">
          <datalist id="daftar-fakultas"><?php foreach ($fakultas as $f): ?><option value="<?= esc($f) ?>"><?php endforeach; ?></datalist>
        </div>
        <div class="field">
          <label>Jurusan</label>
          <input type="text" name="jurusan" list="daftar-jurusan" required value="<?= esc($jurusan[0] ?? '') ?>">
          <datalist id="daftar-jurusan"><?php foreach ($jurusan as $j): ?><option value="<?= esc($j) ?>"><?php endforeach; ?></datalist>
          <p class="hint">Harus sama dengan isian jurusan pada data Program Studi agar kelasnya terekap.</p>
        </div>
        <div class="field">
          <label>Semester</label>
          <select name="semester"><option>Ganjil</option><option>Genap</option></select>
        </div>
        <div class="field">
          <label>Tahun Akademik</label>
          <input type="text" name="tahun_akademik" placeholder="mis. 2026/2027" pattern="\d{4}/\d{4}" required>
        </div>
      </div>
      <button type="submit" class="btn">Buat Laporan</button>
    </form>
  </div>
<?php endif; ?>

<div class="panel">
  <h2>Daftar Laporan</h2>
  <?php if (empty($epbmAll)): ?>
    <div class="empty">Belum ada laporan EPBM.</div>
  <?php else: ?>
    <table class="doc-list">
      <thead><tr><th>Fakultas</th><th>Jurusan</th><th>Semester</th><th>Diperbarui</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($epbmAll as $e): ?>
          <tr>
            <td><?= esc($e['fakultas']) ?></td>
            <td><?= esc($e['jurusan']) ?></td>
            <td><?= esc($e['semester'] . ' ' . $e['tahun_akademik']) ?></td>
            <td><?= esc(tanggal_id($e['updated_at'] ?? $e['created_at'])) ?></td>
            <td>
              <a class="btn ghost sm" href="<?= site_url('epbm/' . $e['id']) ?>"><?= $canEdit ? 'Isi / Ubah' : 'Lihat' ?></a>
              <a class="btn ghost sm" target="_blank" href="<?= site_url('laporan/epbm/' . $e['id']) ?>">Cetak</a>
              <?php if ($canEdit): ?><?= delete_form(site_url('epbm/' . $e['id'] . '/delete'), 'Hapus', 'Hapus laporan EPBM ini?') ?><?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
