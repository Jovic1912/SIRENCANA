<?= $this->extend('layout/main_tailwind') ?>
<?= $this->section('content') ?>

<div class="pagehead">
  <div>
    <a class="link" href="<?= site_url('portofolio') ?>">← Pilih kelas lain</a>
    <h1 style="margin-top:8px"><?= esc(($mk['kode'] ?? '') . ' — ' . ($mk['nama'] ?? '')) ?> — Kelas <?= esc($kelas['label']) ?></h1>
  </div>
</div>

<div class="two-col">
  <div>
    <div class="panel">
      <h2>Kelengkapan Portofolio</h2>
      <?php
        $items = [
          ['RPS disahkan', $rps && $rps['status'] === 'diarsipkan'],
          ['Kontrak Kuliah disepakati', ! empty($kontrak['ttd'])],
          ['Presensi ' . ($kelas['jumlah_pertemuan'] ?? 16) . ' pertemuan lengkap', $presLengkap],
          ['Nilai seluruh jenis penilaian lengkap', $nilaiLengkap],
          ['Peserta terdaftar', count($peserta) > 0],
        ];
      ?>
      <div class="checklist">
        <?php foreach ($items as [$label, $ok]): ?>
          <div><span class="badge <?= $ok ? 'diarsipkan' : 'draft' ?>"><?= $ok ? '✓' : '—' ?></span> <?= esc($label) ?></div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="panel">
      <h2>Narasi Pelaksanaan</h2>
      <?php if (! $canWrite): ?><p class="hint">Anda hanya dapat melihat narasi ini.</p><?php endif; ?>
      <?php if ($canWrite): ?>
      <form method="post" action="<?= site_url('portofolio/' . $kelas['id'] . '/narasi') ?>">
<?= csrf_field() ?>
        <div class="field"><label>Tujuan Perkuliahan</label><textarea name="tujuan"><?= esc($portofolio['tujuan'] ?? '') ?></textarea></div>
        <div class="field"><label>Metode Pelaksanaan</label><textarea name="metode"><?= esc($portofolio['metode'] ?? '') ?></textarea></div>
        <div class="field"><label>Ringkasan Isi Perkuliahan</label><textarea name="isi"><?= esc($portofolio['isi'] ?? '') ?></textarea></div>
        <button type="submit" class="btn sm">Simpan Narasi</button>
      </form>
      <?php endif; ?>
    </div>
  </div>

  <div>
    <div class="panel">
      <h2><?= esc(($mk['kode'] ?? '') . ' — ' . ($mk['nama'] ?? '')) ?> — Kelas <?= esc($kelas['label']) ?></h2>
      <table><tbody>
        <tr><td class="muted">Semester</td><td><?= esc($kelas['semester']) ?> · <?= esc($kelas['tahun_akademik']) ?></td></tr>
        <tr><td class="muted">Jumlah Peserta</td><td><?= count($peserta) ?></td></tr>
        <tr><td class="muted">Status RPS</td><td><?= $rps ? status_badge($rps['status']) : '—' ?></td></tr>
      </tbody></table>
    </div>
    <?= view('capaian/_body', ['rows' => $rows, 'cpmkList' => $cpmkList, 'summary' => $summary]) ?>
  </div>
</div>

<?= $this->endSection() ?>
