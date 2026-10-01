<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pagehead">
  <div>
    <a class="link" href="<?= site_url('presensi') ?>">← Pilih kelas lain</a>
    <h1 style="margin-top:8px"><?= esc(($mk['kode'] ?? '') . ' — ' . ($mk['nama'] ?? '')) ?> — Kelas <?= esc($kelas['label']) ?></h1>
  </div>
</div>

<?php if (empty($peserta)): ?>
  <div class="empty">Kelas ini belum memiliki peserta. Tambahkan peserta di menu Kelas &amp; Kontrak.</div>
<?php else: ?>

<div style="display:flex;gap:4px;border-bottom:1px solid var(--line);margin-bottom:16px">
  <a href="?mode=presensi&minggu=<?= $minggu ?>" style="padding:8px 13px;font-size:.82rem;text-decoration:none;color:<?= $mode==='presensi'?'var(--navy)':'var(--ink-soft)' ?>;border-bottom:2px solid <?= $mode==='presensi'?'var(--navy)':'transparent' ?>;font-weight:<?= $mode==='presensi'?'600':'400' ?>">Presensi</a>
  <a href="?mode=nilai" style="padding:8px 13px;font-size:.82rem;text-decoration:none;color:<?= $mode==='nilai'?'var(--navy)':'var(--ink-soft)' ?>;border-bottom:2px solid <?= $mode==='nilai'?'var(--navy)':'transparent' ?>;font-weight:<?= $mode==='nilai'?'600':'400' ?>">Nilai</a>
</div>

<?php if ($mode === 'presensi'): ?>
  <div class="panel">
    <form method="get" action="" style="max-width:260px;margin-bottom:16px">
      <input type="hidden" name="mode" value="presensi">
      <div class="field"><label>Pertemuan ke-</label>
        <select name="minggu" onchange="this.form.submit()">
          <?php for ($m = 1; $m <= ($kelas['jumlah_pertemuan'] ?? 16); $m++): ?>
            <option value="<?= $m ?>" <?= $minggu == $m ? 'selected' : '' ?>>Pertemuan <?= $m ?><?= $m===8?' (UTS)':'' ?><?= $m===16?' (UAS)':'' ?></option>
          <?php endfor; ?>
        </select>
      </div>
    </form>
    <?php if (! $canWrite): ?><div class="empty">Anda hanya dapat melihat presensi kelas ini.</div><?php endif; ?>
    <?php if ($canWrite): ?>
    <form method="post" action="<?= site_url('presensi/' . $kelas['id'] . '/simpan') ?>">
<?= csrf_field() ?>
      <input type="hidden" name="minggu" value="<?= $minggu ?>">
      <div class="tbl-wrap"><table>
        <thead><tr><th>NIM</th><th>Nama</th><th style="width:220px">Status</th></tr></thead>
        <tbody>
        <?php foreach ($peserta as $p): $m = $mhsById[$p['mahasiswa_id']] ?? null; $st = $presensiMinggu[$p['id']] ?? ''; ?>
          <tr>
            <td class="mono"><?= esc($m['nim'] ?? '—') ?></td>
            <td><?= esc($m['nama'] ?? '—') ?></td>
            <td>
              <select name="status[<?= $p['id'] ?>]">
                <option value="" <?= $st===''?'selected':'' ?>>— belum diisi —</option>
                <option value="H" <?= $st==='H'?'selected':'' ?>>Hadir</option>
                <option value="I" <?= $st==='I'?'selected':'' ?>>Izin</option>
                <option value="S" <?= $st==='S'?'selected':'' ?>>Sakit</option>
                <option value="A" <?= $st==='A'?'selected':'' ?>>Alpa</option>
              </select>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table></div>
      <button type="submit" class="btn sm" style="margin-top:12px">Simpan Presensi Pertemuan <?= $minggu ?></button>
    </form>
    <?php endif; ?>
  </div>
<?php else: ?>
  <div class="panel">
    <?php if (! $canWrite): ?><div class="empty">Anda hanya dapat melihat nilai kelas ini.</div><?php endif; ?>
    <?php if ($canWrite): ?>
    <form method="post" action="<?= site_url('presensi/' . $kelas['id'] . '/nilai') ?>">
<?= csrf_field() ?>
      <div class="tbl-wrap"><table>
        <thead><tr><th>NIM</th><th>Nama</th>
          <?php foreach ($jenisPenilaian as $j): ?><th class="num"><?= esc($j['nama']) ?> (<?= $j['bobot'] ?>%)</th><?php endforeach; ?>
        </tr></thead>
        <tbody>
        <?php foreach ($peserta as $p): $m = $mhsById[$p['mahasiswa_id']] ?? null; $rec = $nilaiPeserta[$p['id']] ?? []; ?>
          <tr>
            <td class="mono"><?= esc($m['nim'] ?? '—') ?></td>
            <td><?= esc($m['nama'] ?? '—') ?></td>
            <?php foreach ($jenisPenilaian as $j): ?>
              <td class="num"><input class="matrix-input" type="number" min="0" max="100" step="0.01"
                name="nilai[<?= $p['id'] ?>][<?= $j['id'] ?>]" value="<?= $rec[$j['id']] ?? '' ?>"></td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table></div>
      <button type="submit" class="btn sm" style="margin-top:12px">Simpan Nilai</button>
    </form>
    <?php endif; ?>
  </div>
<?php endif; ?>
<?php endif; ?>

<?= $this->endSection() ?>
