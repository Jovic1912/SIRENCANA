<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pagehead"><div><h1>Capaian CPMK — Laporan OBE</h1><p>Dihitung otomatis dari nilai mentah dan matriks bobot penilaian × CPMK pada RPS.</p></div></div>

<div class="panel">
  <form method="get" action="">
    <div class="field"><label>Pilih Kelas</label>
      <select onchange="if(this.value) window.location = '<?= site_url('capaian') ?>/' + this.value">
        <option value="">— pilih kelas —</option>
        <?php foreach ($kelasAll as $k): $m = $mkById[$k['mk_id']] ?? null; ?>
          <option value="<?= $k['id'] ?>"><?= esc(($m['kode'] ?? '') . ' — ' . ($m['nama'] ?? '') . ' — ' . $k['label'] . ' (' . $k['tahun_akademik'] . ')') ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </form>
</div>
<?php if (empty($kelasAll)): ?><div class="empty">Belum ada kelas.</div><?php endif; ?>

<?= $this->endSection() ?>
