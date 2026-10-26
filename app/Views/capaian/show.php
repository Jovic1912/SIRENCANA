<?= $this->extend('layout/main_tailwind') ?>
<?= $this->section('content') ?>

<div class="pagehead">
  <div>
    <a class="link" href="<?= site_url('capaian') ?>">← Pilih kelas lain</a>
    <h1 style="margin-top:8px"><?= esc(($mk['kode'] ?? '') . ' — ' . ($mk['nama'] ?? '')) ?> — Kelas <?= esc($kelas['label']) ?></h1>
  </div>
</div>

<?= view('capaian/_body', ['rows' => $rows, 'cpmkList' => $cpmkList, 'summary' => $summary]) ?>

<?= $this->endSection() ?>
