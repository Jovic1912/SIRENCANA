<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php $narasi = \App\Controllers\EpbmController::NARASI; ?>

<div class="pagehead">
  <div>
    <a class="link" href="<?= site_url('epbm') ?>">← Daftar laporan EPBM</a>
    <h1 style="margin-top:8px">EPBM Jurusan <?= esc($epbm['jurusan']) ?></h1>
    <p>Semester <?= esc($epbm['semester'] . ' ' . $epbm['tahun_akademik']) ?> · <?= count($prodiList) ?> program studi · <?= count($kelasRows) ?> kelas terekap</p>
  </div>
  <div><a class="btn sm" target="_blank" href="<?= site_url('laporan/epbm/' . $epbm['id']) ?>">Cetak Laporan EPBM</a></div>
</div>

<div class="panel">
  <h2>Rekap Otomatis Kelas</h2>
  <?php if (empty($kelasRows)): ?>
    <div class="empty">
      Belum ada kelas pada semester ini untuk jurusan "<?= esc($epbm['jurusan']) ?>".
      Pastikan semester &amp; tahun akademik kelas serta nama jurusan pada data Program Studi sama persis.
    </div>
  <?php else: ?>
    <div class="tbl-wrap">
      <table>
        <thead><tr><th>Mata Kuliah</th><th>Kelas</th><th>Dosen</th><th class="num">Peserta</th><th class="num">Rata-rata</th><th class="num">% Lulus</th><th class="num">Kehadiran</th><th class="num">CPMK tercapai</th><th>Portofolio</th></tr></thead>
        <tbody>
          <?php foreach ($kelasRows as $r): ?>
            <tr>
              <td><span class="mono muted"><?= esc($r['mk']['kode']) ?></span> <?= esc($r['mk']['nama']) ?></td>
              <td><?= esc($r['kelas']['label']) ?></td>
              <td><?= esc(implode(', ', $r['dosen']) ?: '—') ?></td>
              <td class="num"><?= $r['peserta'] ?></td>
              <td class="num"><?= $r['rata'] ?? '—' ?></td>
              <td class="num"><?= $r['persenLulus'] !== null ? $r['persenLulus'] . '%' : '—' ?></td>
              <td class="num"><?= $r['hadir'] !== null ? $r['hadir'] . '%' : '—' ?></td>
              <td class="num"><?= $r['cpmkTercapai'] ?>/<?= $r['cpmkTotal'] ?></td>
              <td><?= esc($r['kelengkapan']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<form method="post" action="<?= site_url('epbm/' . $epbm['id'] . '/update') ?>">
  <?= csrf_field() ?>
  <fieldset <?= $canEdit ? '' : 'disabled' ?> style="border:0;padding:0;margin:0">
    <div class="panel">
      <h2>Identitas &amp; Tim GKM</h2>
      <div class="field-row">
        <div class="field"><label>Fakultas</label><input type="text" name="fakultas" value="<?= esc($epbm['fakultas']) ?>" required></div>
        <div class="field"><label>Jurusan</label><input type="text" name="jurusan" value="<?= esc($epbm['jurusan']) ?>" required></div>
        <div class="field">
          <label>Semester</label>
          <select name="semester"><?php foreach (['Ganjil', 'Genap'] as $s): ?><option <?= $epbm['semester'] === $s ? 'selected' : '' ?>><?= $s ?></option><?php endforeach; ?></select>
        </div>
        <div class="field"><label>Tahun Akademik</label><input type="text" name="tahun_akademik" value="<?= esc($epbm['tahun_akademik']) ?>" required></div>
      </div>
      <div class="field-row">
        <div class="field"><label>Ketua GKM</label><input type="text" name="ketua_gkm" value="<?= esc($epbm['ketua_gkm'] ?? '') ?>"></div>
        <div class="field"><label>Anggota GKM (satu nama per baris)</label><textarea name="anggota_gkm" rows="3"><?= esc($epbm['anggota_gkm'] ?? '') ?></textarea></div>
      </div>
    </div>

    <div class="panel">
      <h2>Isi Laporan</h2>
      <?php foreach ($narasi as $k => [$label, $ph]): ?>
        <div class="field">
          <label><?= esc($label) ?></label>
          <textarea name="<?= $k ?>" rows="4" placeholder="<?= esc($ph) ?>"><?= esc($epbm[$k] ?? '') ?></textarea>
        </div>
      <?php endforeach; ?>
      <p class="hint">Jumlah mahasiswa per prodi, tabel evaluasi mata kuliah, dan tabel kinerja dosen dicantumkan otomatis pada laporan cetak.</p>
    </div>

    <?php if ($canEdit): ?>
      <div class="form-actions" style="margin-bottom:22px"><button type="submit" class="btn">Simpan Laporan EPBM</button></div>
    <?php endif; ?>
  </fieldset>
</form>

<?= $this->endSection() ?>
