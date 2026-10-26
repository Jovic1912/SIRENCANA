<?= $this->extend('layout/main_tailwind') ?>
<?= $this->section('content') ?>

<div class="pagehead"><div><h1>Portofolio Mata Kuliah</h1><p>Ringkasan siap-cetak: kelengkapan dokumen, narasi pelaksanaan, dan hasil capaian.</p></div></div>

<div class="panel">
  <form method="get" action="">
    <div class="field"><label>Pilih Kelas</label>
      <select onchange="if(this.value) window.location = '<?= site_url('portofolio') ?>/' + this.value">
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
