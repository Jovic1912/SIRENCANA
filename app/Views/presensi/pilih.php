<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pagehead"><div><h1>Presensi &amp; Nilai</h1><p>Input kehadiran per pertemuan dan nilai mentah per jenis penilaian untuk satu kelas.</p></div></div>

<div class="panel">
  <form method="get" action="">
    <div class="field"><label>Pilih Kelas</label>
      <select onchange="if(this.value) window.location = '<?= site_url('presensi') ?>/' + this.value">
        <option value="">— pilih kelas —</option>
        <?php foreach ($kelasAll as $k): $m = $mkById[$k['mk_id']] ?? null; ?>
          <option value="<?= $k['id'] ?>"><?= esc(($m['kode'] ?? '') . ' — ' . ($m['nama'] ?? '') . ' — ' . $k['label'] . ' (' . $k['tahun_akademik'] . ')') ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </form>
</div>
<?php if (empty($kelasAll)): ?><div class="empty">Belum ada kelas. Buka kelas terlebih dulu di menu Kelas &amp; Kontrak.</div><?php endif; ?>

<?= $this->endSection() ?>
