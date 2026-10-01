<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pagehead"><div><h1>RPS &amp; Persetujuan</h1><p>Rencana Pembelajaran Semester — penyusunan, verifikasi GKM, pengesahan, dan pengarsipan.</p></div></div>

<?php if ($canCreate): ?>
<div class="panel">
  <h2>Susun RPS Baru</h2>
  <form method="post" action="<?= site_url('rps/store') ?>">
    <?= csrf_field() ?>
    <div class="field-row">
      <div class="field"><label>Mata Kuliah</label>
        <select name="mk_id" required>
          <?php if (empty($mkList)): ?><option value="">Belum ada MK — hubungi Admin/Kaprodi</option><?php endif; ?>
          <?php foreach ($mkList as $m): ?>
            <option value="<?= $m['id'] ?>"><?= esc($m['kode'] . ' — ' . $m['nama']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="field"><label>Tahun Akademik</label><input type="text" name="tahun_akademik" placeholder="2026/2027 Ganjil" required></div>
    </div>
    <div class="field-row">
      <div class="field"><label>Pengembang RPS (Dosen)</label>
        <?php if (has_role('dosen')): ?>
          <input type="text" value="<?= esc($myDosen['nama'] ?? 'Akun belum ditautkan ke data dosen') ?>" disabled>
        <?php else: ?>
          <select name="pengembang_id"><?php foreach ($dosenList as $d): ?><option value="<?= $d['id'] ?>"><?= esc($d['nama']) ?></option><?php endforeach; ?></select>
        <?php endif; ?>
      </div>
      <div class="field"><label>Koordinator Program Studi</label>
        <select name="koor_prodi_id"><?php foreach ($koorList as $d): ?><option value="<?= $d['id'] ?>"><?= esc($d['nama']) ?></option><?php endforeach; ?></select>
        <?php if ($koorFallback): ?><div class="hint">Belum ada akun Kaprodi; menampilkan semua dosen.</div><?php endif; ?>
      </div>
    </div>
    <button type="submit" class="btn">Buat Draf RPS</button>
    <p class="hint">CPMK dan matriks bobot mengacu pada data Kurikulum mata kuliah terpilih.</p>
  </form>
</div>
<?php endif; ?>

<div class="panel">
  <h2>Daftar RPS</h2>
  <?php if (empty($rpsAll)): ?>
    <div class="empty">Belum ada RPS disusun.</div>
  <?php else: ?>
    <div class="tbl-wrap"><table>
      <thead><tr><th>Mata Kuliah</th><th>Tahun Akademik</th><th>Pengembang</th><th>Status</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($rpsAll as $r): $m = $mkById[$r['mk_id']] ?? null; ?>
        <tr>
          <td><?= esc(($m['kode'] ?? '—') . ' — ' . ($m['nama'] ?? '—')) ?></td>
          <td><?= esc($r['tahun_akademik']) ?></td>
          <td><?= esc($dosenById[$r['pengembang_id']]['nama'] ?? '—') ?></td>
          <td><?= status_badge($r['status']) ?></td>
          <td><a class="link" href="<?= site_url('rps/' . $r['id']) ?>">Buka →</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table></div>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
