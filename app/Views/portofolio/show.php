<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php
  $narasi   = \App\Controllers\PortofolioController::NARASI;
  $tautan   = \App\Controllers\PortofolioController::TAUTAN;
  $realisasi = $portofolio['realisasi_tatap_muka'] ?? null;
?>

<div class="pagehead">
  <div>
    <a class="link" href="<?= site_url('portofolio') ?>">← Pilih kelas lain</a>
    <h1 style="margin-top:8px"><?= esc(($mk['kode'] ?? '') . ' — ' . ($mk['nama'] ?? 'Mata kuliah tidak ditemukan')) ?> — Kelas <?= esc($kelas['label']) ?></h1>
    <p><?= esc(gabung_teks([$kelas['semester'], $kelas['tahun_akademik']])) ?> · <?= $jumlahPeserta ?> peserta · RPS: <?= $rps ? status_badge($rps['status']) : '—' ?></p>
  </div>
  <div><a class="btn sm" target="_blank" href="<?= site_url('laporan/portofolio/' . $kelas['id']) ?>">Cetak Portofolio (format UMRAH)</a></div>
</div>

<form method="post" action="<?= site_url('portofolio/' . $kelas['id'] . '/narasi') ?>">
  <?= csrf_field() ?>
  <fieldset <?= $canWrite ? '' : 'disabled' ?> style="border:0;padding:0;margin:0">

  <div class="two-col">
    <div>
      <div class="panel">
        <h2>Daftar Kelengkapan Portofolio</h2>
        <p class="hint">Centang otomatis ditebak dari data sistem sampai Anda menyimpannya sendiri.</p>
        <div class="checklist">
          <?php foreach (kelengkapan_portofolio() as $k => $label): ?>
            <label><input type="checkbox" name="kelengkapan[<?= $k ?>]" value="1" <?= ! empty($kelengkapan[$k]) ? 'checked' : '' ?>> <?= esc($label) ?></label>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="panel">
        <h2>Tautan Dokumen &amp; Realisasi</h2>
        <?php foreach ($tautan as $k => $label): ?>
          <div class="field">
            <label><?= esc($label) ?></label>
            <input type="url" name="<?= $k ?>" placeholder="https://..." value="<?= esc($portofolio[$k] ?? '') ?>">
          </div>
        <?php endforeach; ?>
        <div class="field">
          <label>Realisasi tatap muka dosen (kali)</label>
          <input type="number" min="0" max="99" name="realisasi_tatap_muka" value="<?= esc($realisasi ?? '') ?>" placeholder="<?= $terlaksana ?>">
          <p class="hint">Kosongkan untuk memakai jumlah pertemuan yang tercatat di presensi (<?= $terlaksana ?> dari <?= (int) ($kelas['jumlah_pertemuan'] ?? 16) ?>).</p>
        </div>
      </div>
    </div>

    <div>
      <div class="panel">
        <h2>Narasi Portofolio Mata Kuliah</h2>
        <?php foreach ($narasi as $k => [$label, $ph]): ?>
          <div class="field">
            <label><?= esc($label) ?></label>
            <textarea name="<?= $k ?>" rows="4" placeholder="<?= esc($ph) ?>"><?= esc($portofolio[$k] ?? '') ?></textarea>
          </div>
        <?php endforeach; ?>
        <p class="hint">Bagian 9 (Distribusi Nilai) dan 10 (Kesimpulan ketercapaian) dihitung otomatis dari nilai mahasiswa.</p>
      </div>
    </div>
  </div>

  <?php if ($canWrite): ?>
    <div class="form-actions" style="margin-bottom:22px"><button type="submit" class="btn">Simpan Portofolio</button></div>
  <?php else: ?>
    <p class="hint" style="margin-bottom:22px">Anda hanya dapat melihat portofolio ini.</p>
  <?php endif; ?>
  </fieldset>
</form>

<?= view('capaian/_body', ['rows' => $rows, 'cpmkList' => $cpmkList, 'summary' => $summary]) ?>

<?= $this->endSection() ?>
