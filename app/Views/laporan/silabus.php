<?= $this->extend('layout/print') ?>
<?= $this->section('content') ?>

<?php
  // Analisis pembelajaran otomatis: kelompokkan Sub-CPMK beserta minggu & bobotnya.
  $alur = [];
  foreach ($pertemuan as $p) {
      if ($p['is_uts'] || $p['is_uas']) { $alur[] = ['ujian' => $p['is_uts'] ? 'uts' : 'uas', 'minggu' => $p['minggu']]; continue; }
      $s = trim((string) $p['sub_cpmk']);
      if ($s === '') continue;
      $last = end($alur);
      if ($last && empty($last['ujian']) && $last['sub'] === $s) {
          $alur[key($alur)]['sampai'] = $p['minggu'];
          $alur[key($alur)]['bobot'] += (float) $p['bobot'];
      } else {
          $alur[] = ['sub' => $s, 'dari' => $p['minggu'], 'sampai' => $p['minggu'], 'bobot' => (float) $p['bobot']];
      }
  }
?>

<div class="sheet">
  <?= view('laporan/_kop', ['prodi' => $prodi, 'judul' => 'SILABUS MATA KULIAH']) ?>
  <div class="band" style="text-align:left;border-top:0">A. IDENTITAS MATA KULIAH</div>
  <table class="doc" style="margin-top:-1px">
    <tr><th style="width:28%;text-align:left">KOMPONEN</th><th style="text-align:left">KETERANGAN</th></tr>
    <tr><td>Nama Mata Kuliah</td><td><?= esc($mk['nama'] ?? '…') ?></td></tr>
    <tr><td>Kode Mata Kuliah</td><td><?= esc($mk['kode'] ?? '…') ?></td></tr>
    <tr><td>Semester</td><td><?= esc(($mk['semester'] ?? '') ?: '…') ?></td></tr>
    <tr><td>Deskripsi MK</td><td><?= lap_teks($mk['deskripsi'] ?? '') ?></td></tr>
    <tr>
      <td>CPL yang dibebankan</td>
      <td>
        <?php if ($cplList): ?>
          <?php foreach ($cplList as $c): ?><div><strong><?= esc($c['kode']) ?></strong>: <?= esc($c['deskripsi']) ?></div><?php endforeach; ?>
        <?php else: ?><span class="muted">Belum ada pemetaan CPMK → CPL (menu Kurikulum &amp; CPMK)</span><?php endif; ?>
      </td>
    </tr>
    <tr>
      <td>CPMK</td>
      <td>
        <?php foreach ($cpmkList as $c): ?><div><strong><?= esc($c['kode']) ?></strong>: <?= esc($c['deskripsi']) ?></div><?php endforeach; ?>
        <?php if (! $cpmkList): ?><span class="muted">…</span><?php endif; ?>
      </td>
    </tr>
    <tr>
      <td>Sub-CPMK</td>
      <td><?= $subCpmk ? '<ol>' . implode('', array_map(fn ($s) => '<li>' . esc($s) . '</li>', $subCpmk)) . '</ol>' : '<span class="muted">…</span>' ?></td>
    </tr>
    <tr><td>Materi Kajian</td><td><?= lap_daftar($rps['bahan_kajian'] ?? '') ?></td></tr>
    <tr><td>Referensi</td><td><?= lap_daftar($rps['pustaka'] ?? '') ?></td></tr>
  </table>

  <div class="band" style="text-align:left">B. MATRIKS BOBOT CPMK TERHADAP CPL</div>
  <table class="doc" style="margin-top:-1px;width:auto;min-width:50%">
    <tr>
      <th>CPMK</th>
      <?php foreach ($cplList as $c): ?><th><?= esc($c['kode']) ?> (%)</th><?php endforeach; ?>
      <?php if (! $cplList): ?><th>CPL … (%)</th><?php endif; ?>
    </tr>
    <?php foreach ($cpmkList as $cp): ?>
      <tr>
        <td><?= esc($cp['kode']) ?></td>
        <?php foreach ($cplList as $c): ?><td class="c"><?= lap_angka($cpmkCpl[$cp['id']][$c['id']] ?? '') ?></td><?php endforeach; ?>
        <?php if (! $cplList): ?><td></td><?php endif; ?>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

<div class="sheet landscape">
  <p class="sec">C. ANALISIS PEMBELAJARAN MATA KULIAH <?= esc(strtoupper($mk['nama'] ?? '…')) ?></p>
  <div style="border:1px solid #000;padding:6px 8px;margin-bottom:10px">
    <strong>Capaian Pembelajaran Mata Kuliah:</strong>
    <?php foreach ($cpmkList as $c): ?><div><strong><?= esc($c['kode']) ?></strong>: <?= esc($c['deskripsi']) ?></div><?php endforeach; ?>
  </div>

  <?php if ($alur): ?>
    <div style="display:flex;flex-direction:column-reverse;gap:6px;font-size:9.5pt">
      <div style="border-top:2px dashed #1f3fbf;color:#1f3fbf;text-align:right;font-style:italic;font-weight:bold;padding-top:2px">Garis Entry Behavior</div>
      <?php foreach ($alur as $a): ?>
        <?php if (! empty($a['ujian'])): ?>
          <div style="background:#d8e4bc;border:1px solid #000;text-align:center;font-weight:bold;padding:4px">
            EVALUASI / <?= $a['ujian'] === 'uts' ? 'UJIAN TENGAH SEMESTER' : 'UJIAN AKHIR SEMESTER' ?> (mg ke <?= $a['minggu'] ?>)
          </div>
        <?php else: ?>
          <div style="border:1px solid #000;padding:4px 8px;margin-left:<?= $a['dari'] < 8 ? '0' : '35%' ?>;width:65%">
            <?= esc($a['sub']) ?> (mg ke <?= $a['dari'] ?><?= $a['sampai'] !== $a['dari'] ? '–' . $a['sampai'] : '' ?>)<?= $a['bobot'] > 0 ? ' (' . lap_angka($a['bobot']) . '%)' : '' ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
      <div style="background:#fde9d9;border:1px solid #000;padding:4px 8px"><strong>CPMK <?= esc($mk['nama'] ?? '') ?></strong></div>
    </div>
  <?php else: ?>
    <p class="muted">Isi Sub-CPMK pada rancangan pertemuan RPS untuk membentuk analisis pembelajaran.</p>
  <?php endif; ?>

  <?php if (trim((string) ($rps['analisis_pembelajaran'] ?? '')) !== ''): ?>
    <p class="sec">Uraian Analisis Pembelajaran</p>
    <div class="pre" style="border:1px solid #000;padding:6px 8px"><?= esc($rps['analisis_pembelajaran']) ?></div>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
